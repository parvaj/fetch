<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Al Amin
 * Date: 9/1/15
 * Time: 11:56 AM
 */
class Fetchfunctions {

    public function _construct(){
        $CI = &get_instance();
        $CI->load->helper('url');
        $CI->load->library('session');
        $CI->config->item('base_url');
        $CI->load->database();

    }

    public function getSessionID()
    {
        $CI = &get_instance();
        if (!($CI->session->has_userdata("sessionNumber"))){
            $CI->load->database();
           // lock table and update current session
            $CI->db->query("LOCK TABLES sessions WRITE");
            $CI->db->query("update sessions set sess_id=sess_id+1");
            $query = $CI->db->query("select sess_id from sessions");
            $row = $query->row_array();
            $CI->session->set_userdata(array('sessionNumber'=>$row['sess_id']));
            $CI->db->query("UNLOCK TABLES");
        }
    }

public function destroyProductsSession(){
    $_SESSION['department_id'] ='';
    $_SESSION['classList'] ='';
    $_SESSION['brandList'] ='';
}

    public function getDeliveryDate(){
        $dateList = explode(",",$this->getAvailableDeliveryDate());
        $tempExplode=explode(" ",$dateList[0]);
        $tempDate=explode("-",$tempExplode[1]);
        $deliveryDate = date('Y-m-d',mktime(0, 0, 0,  $tempDate[0] , $tempDate[1], $tempDate[2]));
        $newDate = $this->checkHoliday($deliveryDate);
        if($newDate!=""){
            $deliveryDate = $newDate;
        }
        return $deliveryDate;
    }

    public function getAvailableDeliveryDate($iLeadTime = 3){
        $CI = &get_instance();
        $CI->load->database();
        $dayNo = date('w');
        $returnstring="";
        $sessionUser = $CI->session->userdata('customerId');
        $customerId = isset($sessionUser)?$sessionUser:"-1";
        if($customerId>0)
        {
            //echo getDeliveryDate($cust_id);
            $sql = "SELECT
                      `day_1` as day1,`day_2` as day2,`day_3` as day3,`day_4` as day4,`day_5` as day5,`day_6` as day6,`day_7` as day7
				    FROM
				      customer a , delivery_days b
				    WHERE
					  a.zipcode = b.zipcode
					  AND a.cust_id = ?
                ";
            $query = $CI->db->query($sql,array($customerId));
        }
        else
        {
            $sql='SELECT
					IF( SUM(  `day_1` ) >0,  "1",  "0" ) AS day1, IF( SUM(  `day_2` ) >0,  "2",  "0" ) AS day2, IF( SUM(  `day_3` ) >0,  "3",  "0" ) AS day3, IF( SUM( `day_4` ) >0,  "4",  "0" ) AS day4, IF( SUM(  `day_5` ) >0,  "5",  "0" ) AS day5, IF( SUM(  `day_6` ) >0,  "6",  "0" ) AS day6, IF( SUM(  `day_7` ) >0,  "7", "0" ) AS day7
				FROM  `delivery_days`';
            $query = $CI->db->query($sql);
        }

        $row = $query->row_array();

        for($i=1;$i<=7;$i++)
        {
            $dayCode = $row["day$i"];
            if($dayCode>0) {
                $dayInfo = $CI->db->get("days where daycode='".$dayCode."'")->row();
                $cutoffTime = $dayInfo->cutoff_time==""?"23:59":$dayInfo->cutoff_time;
                $cutoff = explode(":",$cutoffTime);
                $cutoffDay = $dayInfo->cutoff_day==""?"":$dayInfo->cutoff_day;

                if($cutoffDay < $dayCode){
                    $dateDiff = $dayCode-$cutoffDay;
                } else{
                    $dateDiff = $dayCode+7-$cutoffDay;
                }
                if($cutoffDay==7)
                    $cutoffDay = 0;

                if($cutoffDay == $dayNo && time() < mktime($cutoff[0],$cutoff[1], 0, date("m")  , date("d"), date("Y"))){
                    $dayNeedToAdd = $dateDiff;
                } else if($cutoffDay > $dayNo ){
                    $dayNeedToAdd = ($cutoffDay-$dayNo)+$dateDiff;
                }else {
                    $dayNeedToAdd = 7+$dateDiff-($dayNo-$cutoffDay);
                }

                $deliveryDate = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+$dayNeedToAdd, date("Y")));

                // based on lead time make the string for delivery date
                if($iLeadTime>3 && $iLeadTime<=7 ){
                    $deliverdDate=explode("-",$deliveryDate);
                    $sDeliveryDate = date('l m-d-Y', mktime(0, 0, 0, $deliverdDate[1]  , $deliverdDate[2]+7, $deliverdDate[0]));
                }
                else if($iLeadTime>7 && $iLeadTime<=14 ){
                    $deliverdDate=explode("-",$deliveryDate);
                    $sDeliveryDate = date('l m-d-Y', mktime(0, 0, 0, $deliverdDate[1]  , $deliverdDate[2]+14, $deliverdDate[0]));
                }
                else if($iLeadTime>14 && $iLeadTime<=21 ){
                    $deliverdDate=explode("-",$deliveryDate);
                    $sDeliveryDate = date('l m-d-Y', mktime(0, 0, 0, $deliverdDate[1]  , $deliverdDate[2]+21, $deliverdDate[0]));
                }
                else if($iLeadTime>21 && $iLeadTime<=28 ){
                    $deliverdDate=explode("-",$deliveryDate);
                    $sDeliveryDate = date('l m-d-Y', mktime(0, 0, 0, $deliverdDate[1]  , $deliverdDate[2]+28, $deliverdDate[0]));
                }
                else{
                    $deliverdDate=explode("-",$deliveryDate);
                    $sDeliveryDate = date('l m-d-Y', mktime(0, 0, 0, $deliverdDate[1]  , $deliverdDate[2], $deliverdDate[0]));
                }
                $returnstring[$deliveryDate]= $sDeliveryDate;
            }
        }

        if(is_array($returnstring)){
            ksort($returnstring);
            return $stringDate = implode(',',$returnstring);

        }
        else{
            if(date('w')<2)
                return date('l m-d-Y',strtotime( "next thursday" ));
            else {
                $theDay = date('Y-m-d',strtotime( "next thursday" ));
                $deliverDate=explode("-",$theDay);
                return date('l m-d-Y', mktime(0, 0, 0, $deliverDate[1]  , $deliverDate[2]+7, $deliverDate[0]));
            }
        }
    }

    public function getNextDeliveryDate($groupId,$leadTime=3)
    {
        $CI =& get_instance();
        $CI->load->database();
        if( $groupId == 10483){
            return date('l m-d-Y');
        }
        else {
            $dateList = explode(',', $this->getAvailableDeliveryDate($leadTime));
            $tempExplode=explode(" ",$dateList[0]);
            $tempDate=explode("-",$tempExplode[1]);
            $deliveryDate = date('Y-m-d',mktime(0, 0, 0,  $tempDate[0] , $tempDate[1], $tempDate[2]));
            // check holiday
            $newDate = $this->checkHoliday($deliveryDate);
            if($newDate!=""){
                $newDateElements = explode('-',$newDate);
                return $deliveryDateDay = date('l m-d-Y',mktime(0, 0, 0,  $newDateElements[1] , $newDateElements[2], $newDateElements[0]));
            } else {
                return $dateList[0];
            }
        }
    }
    public function checkHoliday($deliveryDate)
    {
        $CI =& get_instance();
        $CI->load->database();
        $newDate ="";
        $query = $CI->db->get("move_delivery_date where schadule_date='".$deliveryDate."'");

        if($query->num_rows()>0){
            $newDate = $query->row()->new_date;
        }

        return $newDate;
    }

    public function getValue($columnname,$tablename,$condition)
    {
        $CI =& get_instance();
        $CI->load->database();
        $resultValue="";
        $queryString="SELECT ".$columnname." as columnName FROM ".$tablename. " WHERE ". (empty($condition)? " 1 ": $condition) ;
        $query = $CI->db->query($queryString);
        if($query->num_rows()>0){
            $row = $query->row_array();
            $resultValue = $row['columnName'];

        }

        return $resultValue;
    }

    public function listDeliveryDate($leadTime=3, $frequency_id=1)
    {
        $CI =& get_instance();
        $CI->load->database();
        $sessionUser = $CI->session->userdata('customerId');
        $customerId = isset($sessionUser)?$sessionUser:"-1";
        $vailableDeliveryList = array();
        $avilableDate = explode(",",$this->getAvailableDeliveryDate($leadTime));
        $listIndex = 0;

        for($r=0;$r<10;$r++){
            $k=0;
            while($k < count($avilableDate)){
                $tempExplode=explode(" ",$avilableDate[$k]);
                $tempDate=explode("-",$tempExplode[1]);
                $deliveryDate = date('Y-m-d',mktime(0, 0, 0,  $tempDate[0] , $tempDate[1], $tempDate[2]));
                // check holiday
                $newDate = $this->checkHoliday($deliveryDate);
                if($newDate!=""){
                    $CI->db->query("replace into move_date_details (cust_id,schadule_date,new_date) values( ?,?,? )",array($customerId,$deliveryDate,$newDate));
                    $deliveryDate = $newDate;
                    $newDateElements = explode('-',$newDate);
                    $deliveryDateDay = date('Y-m-d(D)',mktime(0, 0, 0,  $newDateElements[1] , $newDateElements[2], $newDateElements[0]));
                }else{
                    $deliveryDateDay = date('Y-m-d(D)',mktime(0, 0, 0,  $tempDate[0] , $tempDate[1], $tempDate[2]));
                }

                $vailableDeliveryList[$listIndex]['dateValue'] = $deliveryDate;
                $vailableDeliveryList[$listIndex]['dateDisplay'] = $deliveryDateDay;
                $avilableDate[$k] = date('l m-d-Y',mktime(0, 0, 0,  $tempDate[0] , $tempDate[1]+7, $tempDate[2]));

                $listIndex++;
                $k++;
            }
        }

        if ($frequency_id==0){
            $vailableDeliveryList[$listIndex]['dateValue'] = "0000-00-00";
            $vailableDeliveryList[$listIndex]['dateDisplay'] ="Cancel Order";
        }

        return $vailableDeliveryList;
    }

    public function frequencyList()
    {
        $CI =& get_instance();
        $CI->load->database();
        $sql = "SELECT frequency_id, frequency ,list_order FROM  frequency order by list_order";
        $query = $CI->db->query($sql);
        return $query->result_array();
    }
    public function calculateDeliveryFee($customerId,$deliveryDate,$confirmArrray = "'Y'")
    {
        $CI = &get_instance();
        $CI->load->database();

        $totalDeliveryCharge = 0;
        $deliveryCharge = 0;
        $deliveryType = 0;
        $minOrder = 0;
        $lowDeliveryCharge=0;
        $maxOrderAmountforWavDelivery=0;

        $deliveryChargeQuery="SELECT
							customer.cust_id,
							customer.zipcode,
							delivery_days.zipcode,
							delivery_type,
							ifnull(delivery_price,0) as delivery_price,
							ifnull(min_order,0) as min_order,
							ifnull(low_delivery_price,0) as low_delivery_price,
							min_order_to_wave_deliveryfee
						FROM
							`customer`
							LEFT JOIN delivery_days ON customer.zipcode = delivery_days.zipcode
						WHERE
							customer.cust_id = ?";
        $query = $CI->db->query($deliveryChargeQuery,array($customerId));

        if($query->num_rows()>0){
            $deliveryRow = $query->result_array();
            $deliveryType = $deliveryRow[0]['delivery_type'];
            $deliveryCharge = $deliveryRow[0]['delivery_price'];
            $minOrder = $deliveryRow[0]['min_order'];
            $lowDeliveryCharge = $deliveryRow[0]['low_delivery_price'];
            $maxOrderAmountforWavDelivery = $deliveryRow[0]['min_order_to_wave_deliveryfee'];
        }

        // get the total order amount
        $itemsTotalQuery = "SELECT
                                sum(a.qty*price) as orderamount
                            from
                                items a
                            where
                                a.cust_id = ?
                                and a.product_id<>10834
                                and a.product_id<>0
                                and a.product_id not in (select product_id from products where group_id=10483)
                                AND a.confirmed in (".$confirmArrray.")
                                AND active = 'Y'
                                AND removed <> 'Y'
                                and locked = 0
                                and discount_code =''
                                and invoiced <> 'Y'
                                AND next_delivery = ?
                            group by
                                 next_delivery
                            order by
                                next_delivery ";
        $items = $CI->db->query($itemsTotalQuery,array($customerId,$deliveryDate));

        if($items->num_rows()>0) {
            $rowItemTotal = $items->result_array();
            $orderAmount = $rowItemTotal[0]['orderamount'];
        }
        else {
            $orderAmount = 0;
        }

        if(($deliveryType == 1)){
            if($minOrder > $orderAmount)
                $totalDeliveryCharge = $deliveryCharge;
            else
                $totalDeliveryCharge = 0;
        }
        else if($deliveryType == 2){
            if($orderAmount >= $maxOrderAmountforWavDelivery && $maxOrderAmountforWavDelivery > 0)
                $totalDeliveryCharge = 0;
            else if($orderAmount >= $minOrder)
                $totalDeliveryCharge = $deliveryCharge;
            else
                $totalDeliveryCharge = $lowDeliveryCharge;
        }
        return $totalDeliveryCharge;

    }
    public function setDeliveryFee($customerId,$deliveryDate)
    {
        // delete existing delivery fee
        $deleteDeliveryFee = "delete from items where items.cust_id=? and next_delivery = ? and product_id=10834";
        $CI->db->query($deleteDeliveryFee,array($customerId,$deliveryDate));

        $totalDeliveryCharge = $this->calculateDeliveryFee($customerId,$deliveryDate);

        $Query="update items set delivery_rate=? where items.cust_id = ?  and removed <> 'Y'  and next_delivery = ? ";
        $CI->db->query($Query,array($totalDeliveryCharge,$customerId,$deliveryDate));

        if($totalDeliveryCharge > 0 ){
            $queryInsertDeliveryFee="insert into items(cust_id,order_id,product_id,qty,price,frequency_id,manufacturer_id,active,confirmed,delivery_rate,next_delivery,order_no) select cust_id,order_id,'10834','1',?,frequency_id,'256',active,confirmed,delivery_rate,next_delivery,order_no  from items where items.cust_id=? and active='Y' and confirmed='Y'  and next_delivery=? limit 1";
            $CI->db->query($queryInsertDeliveryFee,array($totalDeliveryCharge,$customerId,$deliveryDate));
        }
    }

    public function getZipInfo($zipCode){
        $CI =& get_instance();
        $CI->load->database();
        $sql = "select * from delivery_days where zipcode='".$zipCode."'";
        $query = $CI->db->query($sql);
        return $query->result_array();
    }

    public function departmentList()
    {
        $CI =& get_instance();
        $CI->load->database();
        $sql = "SELECT * from department where petimg !=''";
        $query = $CI->db->query($sql);
        return $query->result_array();
    }

    public function setDiscount($customerId, $orderNumber, $confirmed='Y', $discountCode=''){
        $CI =& get_instance();
        $CI->load->database();
        $Error = "Faild to set the discount";
        //delete all the discount of this order
        $sql = "DELETE FROM items WHERE   order_no = ? AND cust_id = ? and discount_code !='' ";
        $CI->db->query($sql,array($orderNumber,$customerId));
        if($CI->db->affected_rows() == 0){
            return $Error;
        }

        // delete Free food discount
        $sqlDeleteFreeFood = "DELETE FROM items WHERE locked = 1 and order_no = ?";
        $CI->db->query($sqlDeleteFreeFood,array($orderNumber));
        if($CI->db->affected_rows() == 0){
            return $Error;
        }

        if($discountCode == '' ){
            $sError = 'No discount entered but the cuatomer can get 1 buy 5 get 1 free.(depend on specific manufactured product)';
            return $sError;
        }

        $sql = "SELECT
                    discount_id, code, discount_type_id, discount_value, discount_fixed_value, minimspend, msg, sales_msg, qty, category_id, discount_date_from, discount_date_to, multiple_discount, order_count, manufacturer_id, status, manufacturer_ids,buy_product_id,buy_qty,free_product_id,free_qty,department_id
                FROM
                    discount
                WHERE
                    LCASE(code) = LCASE(?) and status = 1";

        $result = mysql_query($sql) or die("get discount info , sql error $sql  :" .mysql_error());
        if(!$count = mysql_num_rows($result)){
            $sError = 'Invalid discount ';// . $sql;
            return $sError;
        }

        $row = mysql_fetch_array($result);
        //check active/inactive discount code
        if($row[status] == 0){
            $sError = 'Inactive discount code';
            return $sError;
        }
        //check date validate/star discount code
        if($row[discount_date_from] !='0000-00-00'){
            $dateArr = explode("-",$row[discount_date_from]);
            $date0Int = mktime(0,0,0,$dateArr[1],$dateArr[2]+1,$dateArr[0]);
            $dateNow = time();
            $dateDiff0 =  $dateNow-$date0Int;
            //exit;
            if($dateDiff0 < 0){
                $sError = 'Discount code date not start';
                return $sError; // discount code expire
            }
        }
        //check date validate/expire discount code
        if($row[discount_date_to] !='0000-00-00'){
            $dateArr = explode("-",$row[discount_date_to]);
            $date1Int = mktime(0,0,0,$dateArr[1],$dateArr[2]+1,$dateArr[0]);
            $dateNow = time();
            $dateDiff = $date1Int - $dateNow;
            if($dateDiff < 0){
                $sError = 'Discount code date expire';
                return $sError; // discount code expire
            }
        }

        //check is it only for new customer or the customer going to set first order
        if($row['order_count'] == 1 ){
            // check the first order offer or this order
            $checkUsed = getvalue("count(first_order_discount)","items","cust_id='".dbsafe($cust_id)."' and  order_no='".dbsafe($sOrderNo)."' and first_order_discount!=''");
            if(!empty($checkUsed))
            {
                $sError = "You have already use the first order offer";
                return $sError;
            }

            $lastDeliveryDuration = getvalue("DATEDIFF(now(),`last_delivery`)","customercall","cust_id = '".dbsafe($cust_id)."'");
            $sql = "SELECT count(invoice_id) as count_invoice from invoices where cust_id = '".dbsafe($cust_id)."' ";

            $result_count_invoiced = mysql_query($sql) or die("result_count_invoiced , sql error $sql  :" .mysql_error());
            $row_count_invoiced = mysql_fetch_array($result_count_invoiced);
            if( (int)$row_count_invoiced["count_invoice"] >= $row["order_count"] && $lastDeliveryDuration < 365){
                $sError = "Discount code is valid only for $row[order_count] order(s) , you already placed  $row_count_invoiced[count_invoice] order(s) (Invoiced).";
                return $sError;
            }
        }

        // qty available
        if(!empty($row['qty']) && $row['qty'] > 0 )
        {
            $sql = "SELECT count(distinct invoice_id) as count_invoice from items where LCASE(discount_code) = LCASE('$discountCode')";
            $result_count_invoiced = mysql_query($sql) or die("result_count_invoiced , sql error $sql  :" .mysql_error());
            $row_count_invoiced = mysql_fetch_array($result_count_invoiced);
            if( (int)$row_count_invoiced["count_invoice"] >= $row["qty"] ){
                $sError = "Discount code is valid only for $row[qty] order(s) , your  placed  $row_count_invoiced[count_invoice] order(s) (Invoiced).";
                return $sError;
            }
        }

        $today = date('Y-m-d');
        //check same discount code use multiple
        if($row[multiple_discount] > 0 ){
            $sql = "SELECT count(item_id) as count_used_code from items where cust_id = '$cust_id' and removed <> 'Y' AND active = 'Y' and LCASE(discount_code) = LCASE('$discountCode')  "; // next_delivery <= '$today'
            //change it to invoice table later
            $result_count_used_code = mysql_query($sql) or die("result_count_used_code , sql error $sql  :" .mysql_error());
            $row_count_used_code = mysql_fetch_array($result_count_used_code);
            if( (int)$row_count_used_code[count_used_code] >= $row[multiple_discount] ){
                $sError = "This Discount code is valid only use once.";
                return $sError;
            }
        }

        //get all product list of that order
        $sqlItem="
			select
					p.product_id, p.group_id, p.leadtime, i.qty, i.price,
					i.manufacturer_id, i.next_delivery, i.item_id,i.frequency_id,
					c.class_id,c.department_id
			from
					products p,items i, combos c
			where
					p.product_id=i.product_id
					and c.product_id = p.group_id
					and p.sales_price_applicable <> 1
					and i.removed <> 'Y'
					and cust_id = '".dbsafe($cust_id)."'
					and order_no = '".dbsafe($sOrderNo)."'
					and i.next_delivery <> '0000-00-00'
			group by
					i.item_id
			order by
					i.next_delivery DESC, i.product_id ";

        //echo $sqlItem .'--------------';
        $resultItem=mysql_query($sqlItem) or die($sqlItem .' > ' .mysql_error());
        $n=0;
        $easydiscount=0;
        $orderTotal=0;
        while ($rowItems = mysql_fetch_assoc($resultItem)){
            if($easydiscount==0 && $rowItems['frequency_id']!=0 && $rowItems['frequency_id']!=14)
            {
                $easydiscount=1;
                //die();
            }

            $freeBagDeliveryDate = $rowItems['next_delivery'];
            $aProducts[] = array(
                $rowItems['product_id'],
                $rowItems['leadtime'],
                $rowItems['qty'],
                $rowItems['price'],
                ($rowItems['qty']* $rowItems['price']),
                $rowItems['class_id'],
                $rowItems['manufacturer_id'],
                $rowItems['next_delivery'],
                str_replace("-", "_", $rowItems['next_delivery']),
                $rowItems['item_id'],
                $rowItems['department_id']
            );
            $orderTotal += 	($rowItems['qty']* $rowItems['price']);
            $n++;
        }
        //var_dump($aProducts);
//echo $row['minimspend']." <> ". $orderTotal;
        // check minimum spend amount
        if(!empty($row['minimspend']) && $row['minimspend'] > $orderTotal )
        {

            $sError = "you have to spend minimum amount $".$row['minimspend'];
            return $sError;

        }

        //discount
        $fDiscountFixedValue = $row['discount_fixed_value'];
        $discount_value = $row['discount_value'];
        $class_id =  $row['category_id'];

        if($row['discount_type_id'] == 1 ){ //	Fixed Credit
            $disAmountRemain = $fDiscountFixedValue;
            $aDiscountDate = array();
            foreach($aProducts as $key => $aProduct){
                if($row['manufacturer_id']>0 &&  $aProduct[6]==$row['manufacturer_id'])
                {
                    if($fDiscountFixedValue > 0){
                        $amount = $aProduct[4];
                        if ($amount >= $disAmountRemain){
                            $aDiscountDate[$aProduct[8]] += $disAmountRemain;
                            $disAmountRemain = 0;
                        }else{
                            $aDiscountDate[$aProduct[8]] +=  $amount;
                            $disAmountRemain = $disAmountRemain - $amount;
                        }
                    }
                }
                else
                {
                    if($fDiscountFixedValue > 0 && ($row['manufacturer_id']<=0 || $row['manufacturer_id']=="")){
                        $amount = $aProduct[4];
                        if ($amount >= $disAmountRemain){
                            $aDiscountDate[$aProduct[8]] += $disAmountRemain;
                            $disAmountRemain = 0;
                        }else{
                            $aDiscountDate[$aProduct[8]] +=  $amount;
                            $disAmountRemain = $disAmountRemain - $amount;
                        }
                    }
                }
            }

            foreach($aDiscountDate as $date => $discountAmount){
                if($discountAmount > 0){
                    $deliveryDate = str_replace("_", "-", $date);
                    $query_discount="INSERT INTO items (".($sOrderNo !='' ? " order_no " : "order_id ") .", cust_id, qty, next_delivery, ref_id, active, discount_code, price, confirmed) VALUES (".($sOrderNo !='' ? " '$sOrderNo' " : " '$iOrderId' ") .", ".($sOrderNo !='' ? " '$cust_id' " : " '-1' ") .",  1, '$deliveryDate', '', 'Y', '$discountCode', '-$discountAmount', '$confirmed')";
                    $resultInsertDiscount=mysql_query($query_discount) or die( 'Add discount as a new entry error:  $query_discount'. mysql_error());
                    //echo '<script language="javascript">alert("you have got $'.$discountAmount.' discount on non-sales item"); </script>';
                }
            }
        }else if($row[discount_type_id] == 2){  //Percent Discount
            $aDiscountDate = array();
            $discountparcentage=(1-$discount_value)*100;
            if($aProducts)
                foreach($aProducts as $key => $aProduct){
                    if($row['manufacturer_id']>0)
                    {
                        if ($aProduct[4] > 0 &&  $aProduct[6]==$row['manufacturer_id']){
                            $aDiscountDate[$aProduct[8]] += sprintf("%01.2f",($aProduct[4]*(1-$discount_value)));
                        }
                    }
                    else
                    {
                        // echo $aProduct[4];
                        if($easydiscount==1 && $aProduct[4] > 0)
                            $aDiscountDate[$aProduct[8]] += sprintf("%01.2f",($aProduct[4]*(1-$discount_value)));
                        else if ($aProduct[4] > 0 && $discountCode!='EASY' ){
                            $aDiscountDate[$aProduct[8]] += sprintf("%01.2f",($aProduct[4]*(1-$discount_value)));
                        }
                    }
                }

            foreach($aDiscountDate as $date => $discountAmount){
                if($discountAmount > 0){
                    $deliveryDate = str_replace("_", "-", $date);
                    $query_discount="INSERT INTO items (".($sOrderNo !='' ? " order_no " : "order_id ") .", cust_id, qty, next_delivery, ref_id, active, discount_code, price, confirmed) VALUES (".($sOrderNo !='' ? " '$sOrderNo' " : " '$iOrderId' ") .", ".($sOrderNo !='' ? " '$cust_id' " : " '-1' ") .",  1, '$deliveryDate', '', 'Y', '$discountCode', '-$discountAmount', '$confirmed')";
                    $resultInsertDiscount=mysql_query($query_discount) or die( 'Add discount as a new entry error:  $query_discount'. mysql_error());
                    //echo '<script language="javascript">alert("you have got '.$discountparcentage.'% discount on non-sales item"); </script>';
                }
            }
        }else if($row[discount_type_id] == 3){ // Discount On First Item
            $discount_product_id = 0;
            $product_price = 0;
            $discount_date = '';
            $discount_item_id = '';
            foreach($aProducts as $key => $aProduct){
                //if ($aProduct[5] == $class_id ){
                if($aProduct[3] > $product_price ){
                    $product_price = $aProduct[3];
                    $discount_product_id = $aProduct[0];
                    $discount_date = $aProduct[7];
                    $discount_item_id = $aProduct[9];
                }
                //}
            }
            if($discount_product_id > 0){
                $discountAmount = sprintf("%01.2f",($product_price*(1-$discount_value)));
                $query_discount="INSERT INTO items (".($sOrderNo !='' ? " order_no " : "order_id ") .", cust_id, qty, next_delivery, ref_id, active, discount_code, price, ref_item, confirmed ) VALUES (".($sOrderNo !='' ? " '$sOrderNo' " : " '$iOrderId' ") .", ".($sOrderNo !='' ? " '$cust_id' " : " '-1' ") .",  1, '$discount_date', '$discount_product_id', 'Y', '$discountCode', '-$discountAmount', '$discount_item_id', '$confirmed')";
                $resultInsertDiscount=mysql_query($query_discount) or die( 'Add discount as a new entry error:  $query_discount'. mysql_error());
                echo '<script language="javascript">alert("you have got $'.$discountAmount.' discount on  non-sales item"); </script>';
            }
        }else if($row[discount_type_id] == 4 || $row[discount_type_id]==6){ //type=4 free bag discount
            $discount_product_id = 0;
            $product_price = 0;
            $discount_date = '';
            $discount_item_id = '';
            foreach($aProducts as $key => $aProduct){
                if ($aProduct[0] == $row['buy_product_id'] &&  $aProduct[2]>=$row['buy_qty']){
                    $discount_date = $aProduct[7];
                    $discount_item_id = $aProduct[9];
                    $freeProductPrice=getvalue("price","price","product_id='".(dbsafe($row['free_product_id']))."'");
                    $freeBagManufacturerId=getvalue("distinct manufacturer_id","combos","product_id='".(dbsafe($row['free_product_id']))."'");
                    $queryAddFreeBag="INSERT INTO items (".($sOrderNo !='' ? " order_no " : "order_id ") .", cust_id, qty, next_delivery, product_id, active, confirmed, locked,manufacturer_id,  price, item_type_msg,discount_code,ref_id ) VALUES (".($sOrderNo !='' ? " '$sOrderNo' " : " '$iOrderId' ") .", ".($sOrderNo !='' ? " '$cust_id' " : " '-1' ") .",  '".$row['free_qty']."', '$discount_date', '".$row['free_product_id']."', 'Y','P',1, '$freeBagManufacturerId', '$freeProductPrice','".$row['product_line_msg']."','','$discount_item_id')";
                    $resultAddFreeBag=mysql_query($queryAddFreeBag) or die( 'queryAddFreeBag entry error:  $queryAddFreeBag'. mysql_error());
                    //add a discount line for that free product
                    $queryAddDiscountBag="INSERT INTO items (".($sOrderNo !='' ? " order_no " : "order_id ") .", cust_id, qty, next_delivery, ref_item, active, confirmed, discount_code, price, locked ) VALUES (".($sOrderNo !='' ? " '$sOrderNo' " : " '$iOrderId' ") .", ".($sOrderNo !='' ? " '$cust_id' " : " '-1' ") .",  '".$row['free_qty']."', '$discount_date', '".$row['free_product_id']."', 'Y', '$confirmed', '$discountCode', '-$freeProductPrice', 1)";
                    $resultAddDiscountBag=mysql_query($queryAddDiscountBag) or die( 'queryAddDiscountBag error:  $queryAddDiscountBag'. mysql_error());
                }
            }
            echo '<script language="javascript">alert("you have got discount on non-sales item"); </script>';

        }else if($row[discount_type_id] == 5){ // customer will get % discount on a particular manufacturers food
            $discountManufacturerId = $row['manufacturer_id'];
            $departmentId= $row['department_id'];
            $aDiscountManufacturerId = array();
            if($row[manufacturer_ids] !='' ){
                $aDiscountManufacturerId = explode(",", $row[manufacturer_ids]);

            }


            //$cust_class_id = $rowCustomerDiscount[class_id];
            $aDiscountDate = array();
            if($aProducts)
                foreach($aProducts as $key => $aProduct){
                    if ( $discountManufacturerId == $aProduct[6] ){ //$aProduct[5] == $cust_class_id &&
                        if($departmentId==$aProduct[10])
                        {
                            if($class_id==$aProduct[5])
                            {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f",($aProduct[4]*(1-$discount_value)));
                            }else if($class_id<=0)
                            {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f",($aProduct[4]*(1-$discount_value)));
                            }

                        }else if($departmentId<=0)
                        {
                            if($class_id==$aProduct[5])
                            {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f",($aProduct[4]*(1-$discount_value)));
                            }else if($class_id<=0)
                            {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f",($aProduct[4]*(1-$discount_value)));
                            }
                        }
                    }else if( in_array($aProduct[6], $aDiscountManufacturerId) && is_array($aDiscountManufacturerId)){
                        if($departmentId==$aProduct[10])
                        {
                            if($class_id==$aProduct[5])
                            {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f",($aProduct[4]*(1-$discount_value)));
                            }else if($class_id<=0)
                            {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f",($aProduct[4]*(1-$discount_value)));
                            }

                        }else if($departmentId<=0)
                        {
                            if($class_id==$aProduct[5])
                            {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f",($aProduct[4]*(1-$discount_value)));
                            }else if($class_id<=0)
                            {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f",($aProduct[4]*(1-$discount_value)));
                            }
                        }
                        //$aDiscountDate[$aProduct[8]] += sprintf("%01.2f",($aProduct[4]*(1-$discount_value)));
                    }
                }
            foreach($aDiscountDate as $date => $discountAmount){
                if($discountAmount > 0){
                    $deliveryDate = str_replace("_", "-", $date);
                    $query_discount="INSERT INTO items (".($sOrderNo !='' ? " order_no " : "order_id ") .", cust_id, qty, next_delivery, ref_id, active, discount_code, price, confirmed) VALUES (".($sOrderNo !='' ? " '$sOrderNo' " : " '$iOrderId' ") .", ".($sOrderNo !='' ? " '$cust_id' " : " '-1' ") .",  1, '$deliveryDate', '', 'Y', '$discountCode', '-$discountAmount', '$confirmed')";
                    $resultInsertDiscount=mysql_query($query_discount) or die( 'Add discount as a new entry error:  $query_discount'. mysql_error());
                }
                echo '<script language="javascript">alert("you have got discount on non-sales item"); </script>';
            }
            //echo '<script language="javascript">alert("you have got discount on non-sales item"); </script>';
        }else if($row[discount_type_id] == 8){ //type=8
            //code will be write here
        }
    }


}