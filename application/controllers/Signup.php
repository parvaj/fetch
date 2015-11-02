<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Parvaj Sarker
 * Date: 8/31/15
 * Time: 10:59 AM
 */
class Signup extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->library('fetchfunctions');
        $this->load->model('Checkout_model');
        $this->fetchfunctions->getSessionID();
        $this->load->model('Signup_model');

    }

    public function index(){
        $data['title'] = "my title";
        $this->template->load('default','signup',$data);
    }
    public function checkzip(){

        $this->load->library('fetchfunctions');
        $zipCode = $this->security->xss_clean($this->input->get('zipcode'));
        $zipCodeDetails = $this->fetchfunctions->getZipInfo($zipCode);

        echo json_encode($zipCodeDetails);
        exit;

    }

      public function signup_process(){

        $emailAddress = $this->security->xss_clean($this->input->get('email'));
        $zipCode = $this->security->xss_clean($this->input->get('zip_code'));
        $checkUser =  $this->Signup_model->checkUserInfo($emailAddress);
        //$checkUser =  getValue("user_name","users","user_name='".$emailAddress."'");
            if( $checkUser > 0){
                $data['success'] ="exist";
            }
            else if(!empty($emailAddress)  && empty($checkUser))
            {
                $custId = $this->Signup_model->addUser( $emailAddress, $zipCode );
                if( !empty($custId)) {
                    $data = array(
                        'customerId' => $custId,
                        'username'  => $emailAddress,
                        'user_type'  => 'customer',
                        'logged_in'  => TRUE
                    );
                    $this->session->set_userdata($data);
                    $data['success'] ='yes';
                }else
                {
                    $data['success'] ='no';
                }
            }else{
                $data['success'] ='no';
            }
        echo json_encode($data);
        exit;
    }
}