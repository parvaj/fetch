<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Al Amin
 * Date: 8/31/15
 * Time: 10:59 AM
 */
class Checkout extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('fetchfunctions');
        $this->load->model('Checkout_model');
        $this->fetchfunctions->getSessionID();
    }

    public function index(){

    }

    public function additems(){
        $customerId = $this->session->userdata('customerId');
        $data['cust_id'] = !empty( $customerId )? $customerId : '-1';
        if($customerId>1)
            $data['order_no'] = $this->Checkout_model->getOrderNo($customerId);
        else
            $data['order_id'] = $this->session->userdata('sessionNumber');
        echo $this->session->userdata('sessionNumber');
        $data['product_id'] = $this->input->post('productid');
        $data['price']= $this->Checkout_model->getProductPrice($data['product_id']);
        //$data['price'] = $this->input->post('productPrice');
        $data['qty'] = $this->input->post('productQty');
        $data['frequency_id'] =$this->input->post('frequency');
        $data['manufacturer_id'] = $this->input->post('manufacturerId');
        $data['is_deal'] = '-1';
        $this->Checkout_model->additemoncart($data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function cartItems( )
    {
        $customerId = $this->session->userdata('customerId');
        $data['customerDelivery']= $deliveryDate = $this->fetchfunctions->getDeliveryDate();
        if (!isset($customerId)) {

            $customerId = '-1';
            $orderNo= $this->session->userdata('sessionNumber');
        }
        else{
            $orderNo= $this->Checkout_model->getOrderNo($customerId);
            // put the product to customer cart
            $this->Checkout_model->updateCurrentOrderDate($orderNo,$deliveryDate);
        }
        $data['cartCount'] = $this->Checkout_model->cartAmount($customerId,$orderNo );
        $data['orderNo'] = $orderNo;
        $data['deliveryDayList'] = $this->fetchfunctions->listDeliveryDate();
        $data['frequencyList'] = $this->fetchfunctions->frequencyList();
        $data['itemDetails'] = $this->Checkout_model->getItemInCart($customerId,$orderNo);
        $data['username'] = array('id' => 'username', 'name' => 'username');
        $data['password'] = array('id' => 'password', 'name' => 'password');
        $this->template->load('default','checkout/cartItems', $data);

    }

}