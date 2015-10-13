<?php
/*
 * Created on Mar 8, 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class Login_model extends CI_Model
{
     public function __construct()
     {
         $this->load->database();
     }
    function checkUserLogin($username,$password)
    {
     	$this->load->database();
        $sql = "select
                      user_name,password,firstname
                  from
                      users, customer
                  where
                      user_name=?
                      and password=?
                      and email=?";

        $query = $this->db->query($sql,array($username,md5($password),$username));

        if ($query->num_rows() == 0) {
            return NULL;
        }
 
        return TRUE;

    }
    function getUserInfo($username)
    {
     $this->load->database();
     $sql = "select
                cust_id,firstname,surname,email
              from
                   customer
              where
                  email=?";

     $query = $this->db->query($sql,array($username));
     return $query->row();


    }

}
 
?>
