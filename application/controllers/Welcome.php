<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Product_model');
		$this->load->model('Checkout_model');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('template');
		$this->fetchfunctions->getSessionID();
		$this->fetchfunctions->destroyProductsSession();
	}
	public function index()
	{

		$this->load->helper('form');
        $this->load->helper('url');
		$this->load->helper('fetch');
		$customerId = $this->session->userdata('customerId');
		$orderNo = isset($customerId)?$this->Checkout_model->getOrderNo($customerId): $this->session->userdata('sessionNumber');
		$data['cartCount'] = $this->Checkout_model->cartAmount($customerId, $orderNo);
		$data['username'] = array('id' => 'username', 'name' => 'username');
		$data['password'] = array('id' => 'password', 'name' => 'password');
		$this->template->load('default','home', $data);

	}
}
