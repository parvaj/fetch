<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Al Amin
 * Date: 8/27/15
 * Time: 4:41 PM
 */

class Product extends CI_Controller {

    public function __construct()
    {
       parent::__construct();
        $this->load->model('Product_model');
        $this->load->model("Checkout_model");
        $this->load->helper('url');
        $this->load->library('fetchfunctions');


    }
    public function index()
    {
        $departments = $this->Product_model->get_departments();
        $data['departments'] = $departments;

        $data['username'] = array('id' => 'username', 'name' => 'username');
        $data['password'] = array('id' => 'password', 'name' => 'password');
        $customerId = $this->session->userdata('customerId');
        /*  update order number and cust id */
        $customerId = $this->session->userdata('customerId');
        $orderNo = isset($customerId)?$this->Checkout_model->getOrderNo($customerId): $this->session->userdata('sessionNumber');
        $data['cartCount'] = $this->Checkout_model->cartAmount($customerId, $orderNo);
        $this->load->view( 'header',$data );
        $this->load->view('products/department',$data);
        $this->load->view('footer');

    }
    public function searchproduct(){
         if ($_POST) {

            $departmentId = $this->security->xss_clean($this->input->post('deptId'));
            $classId = $this->security->xss_clean($this->input->post('category'));
            $brandId = $this->security->xss_clean($this->input->post('brand'));
            $subClassId = $this->security->xss_clean($this->input->post('petType'));
            $departmentId."  ".$classId." ".$subClassId."--" .$brandId;
             $products = $this->Product_model->get_products($departmentId, $classId, $brandId, $subClassId);

        }
    }
    public function products($departmentId=null, $classId=null, $brandId=null, $subClassId=null, $stageId=null)
    {
        if ($_POST) {

            echo $departmentId = $this->security->xss_clean($this->input->post('deptId'));
            echo $classId = $this->security->xss_clean($this->input->post('category'));
            echo $brandId = $this->security->xss_clean($this->input->get('brand'));
            echo $subClassId = $this->security->xss_clean($this->input->post('petType'));
            die();

        }

        //$uri
        if($departmentId==null){
            $this->index();
        }
        else{

            $department = array();
            $classes = array();
            $subClasses = array();
            $brands = array();
            $products = array();
            $urls =array();
            $urls['deptSection'] = $departmentId;
            $urls['classSection'] = $classId;
            $urls['brandSection'] = $brandId;
            $urls['subClassSection'] = $subClassId;
			
			if($classId != null ){
                $subClasses = $this->Product_model->get_subclasses($departmentId,$classId,$brandId);
            }

            $brands = $this->Product_model->get_manufacturers($departmentId,$classId);

            $classes = $this->Product_model->get_classes($departmentId);
            $products = $this->Product_model->get_products($departmentId, $classId, $brandId, $subClassId);
            $productList= array();
            $i=0;
            foreach($products as $product){
                $productList[$i] = array_merge($product,array("nextDeliveryDate"=>$this->fetchfunctions->getNextDeliveryDate($product['group_id'],$product['leadtime'])));
                $i++;
            }

            $data["urlSegment"] = $urls;
            $data["departments"]=$department;
            $data["products"]=$productList;

            $data["departmentName"] = $this->fetchfunctions->getValue("department_name","department","department_id=".$departmentId);
            $data["classes"] = $classes;
            $data["subClasses"]= $subClasses;
            $data["brands"]= $brands;
            $data['username'] = array('id' => 'username', 'name' => 'username');
            $data['password'] = array('id' => 'password', 'name' => 'password');
            $data['frequency'] =  $this->fetchfunctions->frequencyList();

            /*  update order number and cust id */
            $customerId = $this->session->userdata('customerId');
            $orderNo = isset($customerId)?$this->Checkout_model->getOrderNo($customerId): $this->session->userdata('sessionNumber');
            $data['cartCount'] = $this->Checkout_model->cartAmount($customerId, $orderNo);
            $this->template->load('default', 'products/product', $data);

        }
    }
    public function item($itemId=null)
    {
        $sOrderNo='';

        if($itemId==null){
            $this->index();
        }
        else{

            $items= array();
            $items = $this->Product_model->get_items($itemId);

			$data['nextDelivery'] = $this->fetchfunctions->getNextDeliveryDate($itemId,3);
            $data["products"]= $items;
            $data['username'] = array('id' => 'username', 'name' => 'username');
            $data['password'] = array('id' => 'password', 'name' => 'password');
            $data['frequency'] =  $this->fetchfunctions->frequencyList();
            if( $data["products"]['0']['class_id'] =='22' || $data["products"]['0']['class_id'] =='31'  ){
                $data['largestBagOffer'] = $this->Product_model->getLargestBagOffer( $itemId );

            }else{
                $data['largestBagOffer']='';
            }
            $customerId = $this->session->userdata('customerId');
            $orderNo = isset($customerId)?$this->Checkout_model->getOrderNo($customerId): $this->session->userdata('sessionNumber');
            $data['cartCount'] = $this->Checkout_model->cartAmount($customerId, $orderNo);


            $this->template->load('default','products/items', $data);

        }
    }

} 