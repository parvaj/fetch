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
        $CI = &get_instance();
        $CI->load->database();
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
        $CI->load->model('Checkout_model');

        $Error = "Faild to set the discount";

        //delete all the discount of this order
        $sql = "DELETE FROM items WHERE   order_no = ? AND cust_id = ? and discount_code !='' ";
        $CI->db->query($sql,array($orderNumber,$customerId));
        if($CI->db->affected_rows() == 0){
            //return $Error;
        }

        // delete Free food discount
        $sqlDeleteFreeFood = "DELETE FROM items WHERE locked = 1 and order_no = ?";
        $CI->db->query($sqlDeleteFreeFood,array($orderNumber));
        if($CI->db->affected_rows() == 0){
            //return $Error;
        }

        if($discountCode == '' ){
            $sError = 'No discount entered but the cuatomer can get 1 buy 5 get 1 free.(depend on specific manufactured product)';
            return $sError;
        }

        $sqlDiscountDetails = "SELECT
                    discount_id, code, discount_type_id, discount_value, discount_fixed_value, minimspend, msg, sales_msg, qty, category_id, discount_date_from, discount_date_to, multiple_discount, order_count, manufacturer_id, status, manufacturer_ids,buy_product_id,buy_qty,free_product_id,free_qty,department_id
                FROM
                    discount
                WHERE
                    LCASE(code) = LCASE(?) and status = 1";
        $discountDetails = $CI->db->query($sqlDiscountDetails,array($discountCode));
        if($discountDetails->num_rows() == 0){
            return $Error;
        }

        $rowDiscountArray = $discountDetails->result_array();
        $rowDiscount = $rowDiscountArray[0];
        //check active/inactive discount code
        if($rowDiscount['status'] == 0){
            $sError = 'Inactive discount code';
            return $sError;
        }

        //check date validate/star discount code
        if($rowDiscount['discount_date_from'] !='0000-00-00'){
            $dateArr = explode("-",$rowDiscount['discount_date_from']);
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
        if($rowDiscount['discount_date_to'] !='0000-00-00'){
            $dateArr = explode("-",$rowDiscount['discount_date_to']);
            $date1Int = mktime(0,0,0,$dateArr[1],$dateArr[2]+1,$dateArr[0]);
            $dateNow = time();
            $dateDiff = $date1Int - $dateNow;
            if($dateDiff < 0){
                $sError = 'Discount code date expire';
                return $sError; // discount code expire
            }
        }

        //check is it only for new customer or the customer going to set first order
        if($rowDiscount['order_count'] == 1 ){

            // check the first order offer or this order
            $checkUsed = $this->getValue("count(first_order_discount)","items","cust_id='".$customerId."' and  order_no='".$orderNumber."' and first_order_discount!=''");
            if(!empty($checkUsed)){
                $sError = "You have already use the first order offer";
                return $sError;
            }

            $lastDeliveryDuration = $this->getValue("DATEDIFF(now(),`last_delivery`)","customercall","cust_id = '".$customerId."'");
            $numberOfInvoiced = $this->getValue(" count(invoice_id)","invoices","cust_id = '".$customerId."'");
            if( (int)$numberOfInvoiced >= $rowDiscount["order_count"] && $lastDeliveryDuration < 365){
                $sError = "Discount code is valid only for {$rowDiscount['order_count']} order(s) , you already placed  {$numberOfInvoiced} order(s) (Invoiced).";
                return $sError;
            }
        }

        // qty available
        if(!empty($rowDiscount['qty']) && $rowDiscount['qty'] > 0 ) {
            $numberOfInvoiced = $this->getValue("count(distinct invoice_id)","items","LCASE(discount_code) = LCASE('$discountCode')");
            if( (int)$numberOfInvoiced >= $rowDiscount["qty"] ){
                $sError = "Discount code is valid only for {$rowDiscount['qty']} order(s) , your  placed  {$numberOfInvoiced} order(s) (Invoiced).";
                return $sError;
            }
        }


        //check same discount code use multiple
        if($rowDiscount['multiple_discount'] > 0 ){
            $discountUsed = $this->getValue("count(item_id)","items","cust_id = '$customerId' and removed <> 'Y' AND active = 'Y' and LCASE(discount_code) = LCASE('$discountCode')");
            if( (int)$discountUsed >= $rowDiscount['multiple_discount'] ){
                $sError = "This Discount code is valid only to use {$rowDiscount['multiple_discount']} .";
                return $sError;
            }
        }

        //get all product list of that order
        $itemDetails = $CI->Checkout_model->getItemInCart($customerId,$orderNumber);
        $n=0;
        $easyDiscount=0;
        $orderTotal=0;
        foreach($itemDetails as $rowItems){
            if($easyDiscount == 0 && $rowItems['frequency_id']!=0 && $rowItems['frequency_id']!=14) {
                $easyDiscount=1;
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

        if(!empty($rowDiscount['minimspend']) && $rowDiscount['minimspend'] > $orderTotal ){
            $sError = "you have to spend minimum amount $".$rowDiscount['minimspend'];
            return $sError;
        }

        //discount
        $fDiscountFixedValue = $rowDiscount['discount_fixed_value'];
        $discountValue = $rowDiscount['discount_value'];
        $classId =  $rowDiscount['category_id'];

        //	Fixed Credit
        if($rowDiscount['discount_type_id'] == 1 ){
            $disAmountRemain = $fDiscountFixedValue;
            $aDiscountDate = array();
            foreach($aProducts as $key => $aProduct){
                $aDiscountDate[$aProduct[8]] = 0;
                if($rowDiscount['manufacturer_id']>0 &&  $aProduct[6]==$rowDiscount['manufacturer_id']) {
                    if($fDiscountFixedValue > 0){
                        $amount = $aProduct[4];
                        if ($amount >= $disAmountRemain){
                            $aDiscountDate["{$aProduct[8]}"] += $disAmountRemain;
                            $disAmountRemain = 0;
                        }
                        else{
                            $aDiscountDate["{$aProduct[8]}"]  +=  $amount;
                            $disAmountRemain = $disAmountRemain - $amount;
                        }
                    }
                }
                else{
                    if($fDiscountFixedValue > 0 && ($rowDiscount['manufacturer_id']<=0 || $rowDiscount['manufacturer_id']=="")){
                        $amount = $aProduct[4];
                        if ($amount >= $disAmountRemain){
                            $aDiscountDate[$aProduct[8]] += $disAmountRemain;
                            $disAmountRemain = 0;
                        }
                        else{
                            $aDiscountDate[$aProduct[8]] +=  $amount;
                            $disAmountRemain = $disAmountRemain - $amount;
                        }
                    }
                }
            }


            foreach($aDiscountDate as $date => $discountAmount){
                if($discountAmount > 0){
                    $deliveryDate = str_replace("_", "-", $date);
                    $queryDiscount = "INSERT INTO items ( order_no, cust_id, qty, next_delivery, ref_id, active, discount_code, price, confirmed) VALUES (?,?,  1, ?, '', 'Y', ?, '-$discountAmount',?)";
                    return $CI->db->query($queryDiscount,array($orderNumber,$customerId,$deliveryDate,$discountCode,$confirmed));
                }
            }

        }
        //Percent Discount
        else if($rowDiscount['discount_type_id'] == 2){
            $aDiscountDate = array();
            $discountPercentage = (1-$discountValue)*100;
            if($aProducts) {
                foreach ($aProducts as $key => $aProduct) {
                    if ($rowDiscount['manufacturer_id'] > 0) {
                        if ($aProduct[4] > 0 && $aProduct[6] == $rowDiscount['manufacturer_id']) {
                            $aDiscountDate[$aProduct[8]] += sprintf("%01.2f", ($aProduct[4] * (1 - $discountValue)));
                        }
                    } else {
                        // echo $aProduct[4];
                        if ($easyDiscount == 1 && $aProduct[4] > 0)
                            $aDiscountDate[$aProduct[8]] += sprintf("%01.2f", ($aProduct[4] * (1 - $discountValue)));
                        else if ($aProduct[4] > 0 && $discountCode != 'EASY') {
                            $aDiscountDate[$aProduct[8]] += sprintf("%01.2f", ($aProduct[4] * (1 - $discountValue)));
                        }
                    }
                }
            }

            foreach($aDiscountDate as $date => $discountAmount){
                if($discountAmount > 0){
                    $deliveryDate = str_replace("_", "-", $date);
                    $queryDiscount = "INSERT INTO items ( order_no, cust_id, qty, next_delivery, ref_id, active, discount_code, price, confirmed) VALUES (?,?,  1, ?, '', 'Y', ?, '-$discountAmount',?)";
                    return $CI->db->query($queryDiscount,array($orderNumber,$customerId,$deliveryDate,$discountCode,$confirmed));
                }
            }
        }
        // Discount On First Item
        else if($rowDiscount['discount_type_id'] == 3){
            $discountProductId = 0;
            $productPrice = 0;
            $discountDate = '';
            $discountItemId = '';
            foreach($aProducts as $key => $aProduct){
                if($aProduct[3] > $productPrice ){
                    $productPrice = $aProduct[3];
                    $discountProductId = $aProduct[0];
                    $discountDate = $aProduct[7];
                    $discountItemId = $aProduct[9];
                }
            }
            if($discountProductId > 0){
                $discountAmount = sprintf("%01.2f",($productPrice*(1-$discountValue)));
                $queryDiscount="INSERT INTO items (order_no, cust_id, qty, next_delivery, ref_id, active, discount_code, price, ref_item, confirmed ) VALUES ( ?,?,  1, ?, ?, 'Y', '$discountCode', '-$discountAmount', ?, ?)";
                return $CI->db->query($queryDiscount,array($orderNumber,$customerId,$discountDate,$discountProductId,$discountCode,$discountItemId,$confirmed));
            }
        }
        //type=4 free bag discount
        else if($rowDiscount['discount_type_id'] == 4 || $rowDiscount['discount_type_id']==6){
            $discountProductId = 0;
            $productPrice = 0;
            $discountDate = '';
            $discountItemId = '';
            foreach($aProducts as $key => $aProduct){
                if ($aProduct[0] == $rowDiscount['buy_product_id'] &&  $aProduct[2]>=$rowDiscount['buy_qty']){
                    $discountDate = $aProduct[7];
                    $discountItemId = $aProduct[9];
                    $freeProductPrice = $this->getValue("price","price","product_id='".$rowDiscount['free_product_id']."'");
                    $freeBagManufacturerId = $this->getValue("distinct manufacturer_id","combos","product_id='".$rowDiscount['free_product_id']."'");


                    $queryAddFreeBag="INSERT INTO items ( order_no, cust_id, qty, next_delivery, product_id, active, confirmed, locked,manufacturer_id,  price, item_type_msg,discount_code,ref_id ) VALUES ( ?, ?, ?, ?, ?, 'Y','P',1, ?, ?,?,'',?)";
                    return $CI->db->query($queryAddFreeBag,array($orderNumber,$customerId,$rowDiscount['free_qty'],$discountDate, $rowDiscount['free_product_id'], $freeBagManufacturerId, $freeProductPrice,$rowDiscount['product_line_msg'],'',$discountItemId));

                    //add a discount line for that free product
                    $queryAddDiscountBag="INSERT INTO items (order_no, cust_id, qty, next_delivery, ref_item, active, confirmed, discount_code, price, locked ) VALUES ( ?, ?, ?, ?, ?, 'Y', ?, ?, '-$freeProductPrice', 1)";
                    return $CI->db->query($queryAddDiscountBag,array($orderNumber,$customerId,$rowDiscount['free_qty'],$discountDate, $rowDiscount['free_product_id'], $confirmed, $discountCode));

                }
            }
        }
        // customer will get % discount on a particular manufacturers food
        else if($rowDiscount['discount_type_id'] == 5){
            $discountManufacturerId = $rowDiscount['manufacturer_id'];
            $departmentId= $rowDiscount['department_id'];
            $aDiscountManufacturerId = array();
            if($rowDiscount['manufacturer_ids'] !='' ){
                $aDiscountManufacturerId = explode(",", $rowDiscount['manufacturer_ids']);
            }

            $aDiscountDate = array();
            if($aProducts) {
                foreach ($aProducts as $key => $aProduct) {
                    if ($discountManufacturerId == $aProduct[6]) { //$aProduct[5] == $cust_class_id &&
                        if ($departmentId == $aProduct[10]) {
                            if ($classId == $aProduct[5]) {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f", ($aProduct[4] * (1 - $discountValue)));
                            }
                            else if ($classId <= 0) {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f", ($aProduct[4] * (1 - $discountValue)));
                            }

                        }
                        else if ($departmentId <= 0) {
                            if ($classId == $aProduct[5]) {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f", ($aProduct[4] * (1 - $discountValue)));
                            }
                            else if ($classId <= 0) {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f", ($aProduct[4] * (1 - $discountValue)));
                            }
                        }
                    }
                    else if (in_array($aProduct[6], $aDiscountManufacturerId) && is_array($aDiscountManufacturerId)) {
                        if ($departmentId == $aProduct[10]) {
                            if ($classId == $aProduct[5]) {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f", ($aProduct[4] * (1 - $discountValue)));
                            }
                            else if ($classId <= 0) {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f", ($aProduct[4] * (1 - $discountValue)));
                            }

                        } else if ($departmentId <= 0) {
                            if ($classId == $aProduct[5]) {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f", ($aProduct[4] * (1 - $discountValue)));
                            }
                            else if ($classId <= 0) {
                                $aDiscountDate[$aProduct[8]] += sprintf("%01.2f", ($aProduct[4] * (1 - $discountValue)));
                            }
                        }
                    }
                }
            }
            foreach($aDiscountDate as $date => $discountAmount){
                if($discountAmount > 0){
                    $deliveryDate = str_replace("_", "-", $date);
                    $queryDiscount="INSERT INTO items ( order_no, cust_id, qty, next_delivery, ref_id, active, discount_code, price, confirmed) VALUES ( ?, ?,  1, ?, '', 'Y', ?, '-$discountAmount', ?)";
                    return $CI->db->query($queryDiscount,array($orderNumber,$customerId,$deliveryDate,$discountCode,$confirmed));
                }
            }
        }
        //type=8
        else if($rowDiscount [discount_type_id] == 8){
            //code will be write here
        }
    }

    public function getDiscount($customerId,$orderNumber,$deliveryDate)
    {
        $CI =& get_instance();
        $CI->load->database();
        $totalDiscount = 0;
        $sqlDiscount = "SELECT
                            b.code, b.discount_value, b.discount_fixed_value, b.msg, c.weight, c.unit, c.product_name, a.price
                        FROM
                            discount b
                            inner join items as a on b.code = a.discount_code
                            left join products c on c.product_id = a.ref_id
                        WHERE
                            a.cust_id = ?
							AND a.order_no = ?
							AND a.`removed` != 'Y'
							AND a.`next_delivery` = ?
							and a.invoiced <> 'Y'
							AND a.`active` = 'Y'
							and b.status=1
                        ";
        $discountDetails = $CI->db->query($sqlDiscount,array($customerId,$orderNumber,$deliveryDate));
        if($discountDetails->num_rows() > 0){
            $resultDiscount = $discountDetails->result_array();
            foreach($resultDiscount as $rowDiscount){
                if ($rowDiscount['weight']!='' || $rowDiscount['unit']!='')
                    $rowDiscount[product_name]=displaysafe($rowDiscount["product_name"])."(".displaysafe($rowDiscount['weight']).' '.displaysafe($rowDiscount['unit']).")";
                //$msgDiscount = str_replace('[product]', $rowDiscount["product_name"] , $rowDiscount['msg']);
                //$msgDiscount = str_replace('[code]', $rowDiscount["code"] , $msgDiscount);
                $fDiscount = abs($rowDiscount["price"]);

                $totalDiscount += $fDiscount;
            }
        }
        return $totalDiscount;
    }

    public function getFoodDiscount($cartItemList)
    {
        $discountAmount = 0;
        $foodItemsTotal = 0;

        if(is_array($cartItemList)){
            foreach($cartItemList as $itemRow){
                $isFoodItems = $this->getValue("class_id","combos","product_id='".$itemRow["group_id"]."' and class_id !=0");
                $totalPrice = $itemRow["price"]*$itemRow["qty"];
                if(( $isFoodItems == 22 || $isFoodItems == 31 )  ) {
                    if($foodItemsTotal < $itemRow["price"])
                        $foodItemsTotal = $itemRow["price"];
                    if($itemRow["qty"] >= 2){
                        $heighestProductId = $this->getValue("products.product_id","products left join price on `products`.product_id=price.product_id","products.group_id='".$itemRow["group_id"]."' order by price DESC limit 1");
                        if($itemRow["product_id"] ==  $heighestProductId ){
                            $discountAmount +=  $this->getValue("page_discount_parcent/100","product_page_discount","page_discount_id=2")*$totalPrice;
                        }
                    }
                }
            }
        }

        return $discountAmount;
    }

    public function getRecurringDiscount($cartItemList)
    {
        $discountAmount = 0;

        if(is_array($cartItemList)){
            foreach($cartItemList as $itemRow){
                $totalPrice = $itemRow["price"]*$itemRow["qty"];
                if( $itemRow["frequency_id"] !=0 && $itemRow["frequency_id"] !=14 )
                    $discountAmount += $this->getValue("page_discount_parcent/100","product_page_discount","page_discount_id=1")*$totalPrice;
            }
        }
        return $discountAmount;
    }

    public function getFetchCreditBalance($customerId)
    {
        $balanceCredits = 0;
        $customerReferralCode = $this->getValue("code","sales_reps","cust_id='".$customerId."' and is_customer=1");

        if(!empty($customerReferralCode)){
            $fetchCredit = $this->getValue("ifnull(sum(customerCredit.paid_amount),0)","(SELECT  cr.`paid_amount` FROM `customer_credits` as cr WHERE cr.cust_rep_code='".$customerReferralCode."' and cr.rescueID='0' and cr.is_paid='0' union all 	SELECT rc.`paid_amount` FROM `referral_credits` as rc WHERE rc.rescueID='".$customerReferralCode."' )  as customerCredit","");
            $usedFetchCredit = $this->getValue("ifnull(sum(credits),0)","customer_used_credits","cust_id='".$customerId."'");
            $balanceCredits = $fetchCredit - $usedFetchCredit;
        }
        return $balanceCredits;
    }

    public function getGiftCreditBalance($customerId)
    {
        $giftBalanceCredits = 0;
        $giftAmount = $this->getValue("SUM(qty*gift_amount)","gift_certificates","converted_by = '".$customerId."' and status = 1 ");
        $usedAmount = $this->getValue("sum(dgc.gift_amount)","gift_certificates as gc inner join details_gift_certificates	as dgc on dgc.gift_id = gc.gift_id","gc.status = 1 and gc.converted_by = '".$customerId."' group by gc.converted_by ");

        $giftBalanceCredits = $giftAmount - $usedAmount;

        return $giftBalanceCredits;
    }

}