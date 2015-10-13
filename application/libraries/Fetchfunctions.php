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
        $CI =& get_instance();
        $CI->load->helper('url');
        $CI->load->library('session');
        $CI->config->item('base_url');
        $CI->load->database();

    }

    public function getSessionID()
    {
        $CI =& get_instance();
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

    public function getDeliveryDate(){
        $dateList = explode(",",$this->getAvailableDeliveryDate());
        $tempExplode=explode(" ",$dateList[0]);
        $tempDate=explode("-",$tempExplode[1]);
        $deliveryDate = date('Y-m-d',mktime(0, 0, 0,  $tempDate[0] , $tempDate[1], $tempDate[2]));
        $newDate = $this->checkHoliday($deliveryDate);
        if($newDate!="")
        {
            $deliveryDate = $newDate;
        }
        return $deliveryDate;
    }

    public function getAvailableDeliveryDate($iLeadTime = 3){
        $CI =& get_instance();
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
                if($iLeadTime>3 && $iLeadTime<=7 )
                {
                    $deliverdDate=explode("-",$deliveryDate);
                    $sDeliveryDate = date('l m-d-Y', mktime(0, 0, 0, $deliverdDate[1]  , $deliverdDate[2]+7, $deliverdDate[0]));
                }
                else if($iLeadTime>7 && $iLeadTime<=14 )
                {
                    $deliverdDate=explode("-",$deliveryDate);
                    $sDeliveryDate = date('l m-d-Y', mktime(0, 0, 0, $deliverdDate[1]  , $deliverdDate[2]+14, $deliverdDate[0]));
                }
                else if($iLeadTime>14 && $iLeadTime<=21 )
                {
                    $deliverdDate=explode("-",$deliveryDate);
                    $sDeliveryDate = date('l m-d-Y', mktime(0, 0, 0, $deliverdDate[1]  , $deliverdDate[2]+21, $deliverdDate[0]));
                }
                else if($iLeadTime>21 && $iLeadTime<=28 )
                {
                    $deliverdDate=explode("-",$deliveryDate);
                    $sDeliveryDate = date('l m-d-Y', mktime(0, 0, 0, $deliverdDate[1]  , $deliverdDate[2]+28, $deliverdDate[0]));
                }
                else
                {
                    $deliverdDate=explode("-",$deliveryDate);
                    $sDeliveryDate = date('l m-d-Y', mktime(0, 0, 0, $deliverdDate[1]  , $deliverdDate[2], $deliverdDate[0]));
                }
                $returnstring[$deliveryDate]= $sDeliveryDate;
            }
        }

        if(is_array($returnstring))
        {
            ksort($returnstring);
            return $stringDate = implode(',',$returnstring);

        }
        else
        {
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

        if($query->num_rows()>0) {
            $newDate = $query->row()->new_date;
        }

        return $newDate;
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
        $sql = "SELECT frequency_id, frequency FROM  frequency order by list_order";
        $query = $CI->db->query($sql);
        return $query->result_array();
    }


}