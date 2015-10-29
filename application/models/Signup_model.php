<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Al Amin
 * Date: 8/27/15
 * Time: 5:13 PM
 */
class Signup_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
    }
    public function checkUserInfo($emailAddress)
    {
        $sql = "select user_name from users where user_name='".$emailAddress."'";
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            $row = $query->row_array();
            $resultValue = $row['user_name'];
        }else
            $resultValue = 0;
        //return $query->result_array();
        return $resultValue;
    }
    public function addUser($emailAddress){
        $sql = "insert into users set user_name='".$emailAddress."'";
        $query = $this->db->query($sql);
       //$custId = $this->db->insert_id();
        //$sql2 = "insert into customer set cust_id='".$custId."' and email ='".$emailAddress."' and zipcode='".$zipcode."'";
        //$query = $this->db->query($sql2);
        return $this->db->insert_id();
    }

} 