<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * Created on Sep 03, 2015
 * Created By Parvaj Sarker
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("Login_model");
		$this->load->model("Checkout_model");


	}
	public function index()
	{
	    if ($this->session->userdata('logged_in') == TRUE)
	    {
			redirect('pages');
	    }

	    $data['title'] = 'Login';
	    $data['username'] = array('id' => 'username', 'name' => 'username');
	    $data['password'] = array('id' => 'password', 'name' => 'password');	        
	    $this->load->view('login', $data);
	}

	public function process_login()
	{

		$userName = $this->security->xss_clean($this->input->post('username'));
		$password  = $this->security->xss_clean($this->input->post('password'));
	    if ($this->Login_model->checkUserLogin($userName,$password)== TRUE){
			$customerInfo=$this->Login_model->getUserInfo($userName);
            $data = array(
                        'customerId' => $customerInfo->cust_id,
                   		'username'  => $customerInfo->email,
						'firstName' => $customerInfo->firstname,
                        'surName'   => $customerInfo->surname,
                   		'user_type'  => 'customer',
                   		'logged_in'  => TRUE
                	);

            $this->session->set_userdata($data);
            $customerId = $this->session->userdata('customerId');
            $deliveryDate = $this->fetchfunctions->getDeliveryDate();
			$orderNo= $this->Checkout_model->getOrderNo($customerId);
			// put the product to customer cart
			$this->Checkout_model->updatedOrderCompleted($customerId,$this->session->userdata('sessionNumber'),$orderNo,$deliveryDate);

            redirect($_SERVER["HTTP_REFERER"]);
        }
	    else{
	        $this->session->set_flashdata('message', '<div id="message">It seems your username or password is incorrect, please try again.</div>');
            redirect($_SERVER["HTTP_REFERER"]);
	    }
	}

	function logout()
	{
	    $this->session->sess_destroy();
        redirect(base_url());
	}
}
 
?>
