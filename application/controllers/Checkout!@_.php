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

    }

    public function index(){

    }

    public function additems(){
       // $query="insert into items (cust_id,order_id,product_id,qty,price,frequency_id,manufacturer_id,is_deal) values ( '-1','".dbsafe($_SESSION["sessionNumber"])."','".dbsafe($productId)."','".dbsafe($orderedqty)."','".dbsafe($item_price)."','".dbsafe($_GET['frequency_'.$groupId])."','".dbsafe($_GET['manufacturer_id'])."','".dbsafe($isdeal)."')";
        $customerId = $this->session->userdata('customerId');
        $data['cust_id'] = !empty( $customerId )? $customerId : '-1';
        $data['order_id'] = $this->session->userdata('sessionNumber');
        $data['order_no'] = $this->Checkout_model->getOrderNo($this->session->userdata('customerId'));
        /* remove dublicate items */
        $orderType = !empty($data['cust_id'])?$data['order_no']:$this->session->userdata('sessionNumber');
        $data['product_id'] = $this->input->post('productid');
        //$this->Checkout_model->removeDublicateItems($data['product_id'],$data['cust_id'],$orderType,$orderValue='');
        //$data['price']= $this->Checkout_model->getProductPrice($data['product_id']);
        //echo $data['product_price']; die;
        $data['price'] = $this->input->post('productPrice');
        $data['qty'] = $this->input->post('productQty');
        //$data['manufactuerID'] = $this->input->post('manufacturerId');
        $data['frequency_id'] =$this->input->post('productFrequency');
        $data['manufacturer_id'] = $this->input->post('manufacturerId');
        $data['is_deal'] = '-1';
        $this->Checkout_model->additemoncart($data);
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function cartItems( )
    {
        $customerId = $this->session->userdata('customerId');
        $checkProductsInCart = $this->Checkout_model->productsInCart($customerId);
        //echo $checkProductsInCart;die;
        if (!isset($customerId)){
            $data['errorMessage'] = "Please login.";
            //$this->template->load('default','', $data);
        }
        $data['getDeliveryDate'] = $this->Checkout_model->getdeliveryDate($customerId);
        $data['itemDetails'] = $this->Checkout_model->getItemInCart($customerId,$data['getDeliveryDate']);

        $this->template->load('default','checkout/cartItems', $data);
        //echo "<pre>";
       // print_r($data['itemDetails']); die;
       // $orderType = !empty($customerId)?"order_no":"order_id";
        //$this->fetchfunctions->getOrderType($customerId,$orderType);
        //$this->Checkout_model->getItems($customerId);
    }

}