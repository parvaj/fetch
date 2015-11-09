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
           $resultValue = $query->num_rows();
        }else
            $resultValue = 0;

        return $resultValue;
    }
    public function addUser($emailAddress, $zipCode){
        $sql = "insert into users set user_name='".$emailAddress."'";
        $query = $this->db->query($sql);
        $customerId =  $this->db->insert_id();
        $insertCustomerQuery="insert into
								customer
								(
									cust_id,
									surname,
									firstname,
									email,
									company_id,
									cust_type_id,
									signup_date,
									zipcode,
									code,
									cust_discount_code
								)
								values
								(
									?,
									'',
									'',
									?,
									'2',
									'2'	,
									now(),
									?,
									'',
									''
								)";
        $query = $this->db->query($insertCustomerQuery,array($customerId,$emailAddress,$zipCode));
        return $zipCode;
    }

	public function getCustomerDetails($customerId)
	{
		$sql = "SELECT
                   *
                FROM
                    customer
					INNER JOIN  `zipcode_tax_rate` USING ( zipcode )
                WHERE
                    cust_id=?";
		$query = $this->db->query($sql,array($customerId));
		return $query->result_array();
	}

} 