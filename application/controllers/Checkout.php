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
        $this->load->model('Signup_model');
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

        $groupId = $this->input->post('groupId');
        $data['product_id'] = $this->input->post('productid');
        $data['price']= $this->Checkout_model->getProductPrice($data['product_id']);
        $data['qty'] = $this->input->post('number_qty_'.$groupId);
        $data['frequency_id'] =$this->input->post('frequency_'.$groupId);
        $data['manufacturer_id'] = $this->input->post('manufacturerId_'.$groupId);

        $data['is_deal'] = '-1';

        $this->Checkout_model->additemoncart($data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function cart($loginData=null)
    {
        $customerId = $this->session->userdata('customerId');
        $data['customerDelivery']= $deliveryDate = $this->fetchfunctions->getDeliveryDate();
        if (!isset($customerId)) {
            $customerId = '-1';
            $orderNo= $this->session->userdata('sessionNumber');
        }
        else{
            $orderNo= $this->Checkout_model->getOrderNo($customerId);

        }
        $data["loginMessage"]=$loginData;
        $data['cartCount'] = $this->Checkout_model->cartAmount($customerId,$orderNo );
        $data['orderNo'] = $orderNo;
        $data['deliveryDayList'] = $this->fetchfunctions->listDeliveryDate();
        $data['frequencyList'] = $this->fetchfunctions->frequencyList();
        $data['itemDetails'] = $this->Checkout_model->getItemInCart($customerId,$orderNo);
        $data['username'] = array('id' => 'username', 'name' => 'username');
        $data['password'] = array('id' => 'password', 'name' => 'password');
        $this->template->load('default','checkout/cartItems', $data);

    }

    public function orderSummery( )
    {
        $customerId = $this->session->userdata('customerId');
        $data['customerDelivery']= $deliveryDate = $this->fetchfunctions->getDeliveryDate();
        if (!isset($customerId)){
            $this->cart(0);
        }
        else {

            $orderNumber = $this->Checkout_model->getOrderNo($customerId);
            $data['customerDetails'] = $this->Signup_model->getCustomerDetails($customerId);
            $data['deliveryFee'] = $this->fetchfunctions->calculateDeliveryFee($customerId,$deliveryDate,"'P', 'N'");
            $data['cartCount'] = $this->Checkout_model->cartAmount($customerId, $orderNumber);
            $data['orderNo'] = $orderNumber;
            $data['deliveryDayList'] = $this->fetchfunctions->listDeliveryDate();
            $data['frequencyList'] = $this->fetchfunctions->frequencyList();
            $data['itemDetails'] = $itemDetails =  $this->Checkout_model->getItemInCart($customerId, $orderNumber);
            $data['foodDiscount'] = $this->fetchfunctions->getFoodDiscount($itemDetails);
            $data['codeDiscount'] = $this->fetchfunctions->getDiscount($customerId,$orderNumber,$deliveryDate);
            $data['recurringDiscount'] = $this->fetchfunctions->getRecurringDiscount($itemDetails);
            $data['username'] = array('id' => 'username', 'name' => 'username');
            $data['password'] = array('id' => 'password', 'name' => 'password');
            $this->template->load('default', 'checkout/orderSummery', $data);
        }

    }
    public function removeItems($itemRwoId)
    {
        if($this->session->userdata('sessionNumber')) {
            $this->Checkout_model->removeOrederItems($itemRwoId);
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    public function updateOrderItems()
    {
        $customerId = $this->session->userdata('customerId');
        if($_POST && $customerId > 2){
            $itemRowId = $this->security->xss_clean($this->input->post('itemRowId'));
            $itemQuantity = $this->security->xss_clean($this->input->post('itemQuantity'));
            $deliveryDate = $this->security->xss_clean($this->input->post('deliveryDate'));
            $itemFrequency = $this->security->xss_clean($this->input->post('itemFrequency'));
            $data = array("qty" => $itemQuantity,"next_delivery" => $deliveryDate,"frequency_id" => $itemFrequency);
            echo $this->Checkout_model->updateOrderItems($itemRowId,$data);
            exit();

        }
    }
    public function applyDiscountToOrder()
    {
        $customerId = $this->session->userdata('customerId');
        if( $customerId > 2) {
            $orderNumber = $this->Checkout_model->getOrderNo($customerId);
            $discountCode = $this->security->xss_clean($this->input->post('discountCode'));
            echo $this->fetchfunctions->setDiscount($customerId, $orderNumber, $confirmed = 'Y', $discountCode);
            exit();
        }
    }

}