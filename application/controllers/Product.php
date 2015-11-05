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

    public function products($departmentId=null, $classId=null, $brandId=null, $subClassId=null, $stageId=null)
    {
        $segments = $this->uri->segment(3);
        $data['flag']=0;
        if(!empty($segments)) {
            $this->fetchfunctions->destroyProductsSession();
        }
        if ( isset( $_SESSION['brandList'] ) && !empty($_SESSION['brandList']) && isset( $_SESSION['department_id'] ) && isset( $_SESSION['classList'] ) ) {
            $departmentId = $_SESSION['department_id'];
            $classId = $_SESSION['classList'];
            $brandId = $_SESSION['brandList'];
            $data['flag'] = 1;
        }
        if($departmentId==null){
            $this->index();
        }
        else
        {
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
            if(!empty($_SESSION['brandList'])){
                $brandId = $_SESSION['brandList'];
                $brands = $this->Product_model->get_manufacturersInfo($brandId);
            }else{
                $brands = $this->Product_model->get_manufacturers($departmentId,$classId);
            }
            if(!empty($_SESSION['classList'])){
                $classId = $_SESSION['classList'];
                $classes = $this->Product_model->get_classesInfo($classId);
            }else{
                $classes = $this->Product_model->get_classes($departmentId);
            }
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
            $data['images'] = $this->fetchfunctions->getValue("petimg","department","department_id=".$departmentId);
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
    public function pets($departmentId=null, $classId=null, $brandId=null, $subClassId=null){
        $data['title']= "Pet departments";
        $data['departmentlist'] =  $this->fetchfunctions->departmentList();
        $data['classes'] = $this->Product_model->get_classes($departmentId);
        //$products = $this->Product_model->get_products($departmentId, $classId, $brandId, $subClassId);
        $this->template->load('default','products/pets', $data);

    }

    public function brands( $departmentId=null, $classId=null, $brandId=null, $subClassId=null, $stageId=null )
    {
        if(isset($_POST['idArray'])){
            $_SESSION['brandList'] = $_POST['idArray'];
            echo "1";
            exit;
        }
        //$urls['deptSection'] = $_SESSION['department_id'];
        $data['title']= "test brands";
        $brands = $this->Product_model->get_manufacturers($_SESSION['department_id'],$_SESSION['classList']);
        $data['brands'] = $brands;
        $data['dept_id'] = $_SESSION['department_id'];
        $data['classes'] = $_SESSION['classList'];
        $this->template->load('default', 'products/brands', $data);
    }

    public function shop( )
    {
        $data['brands'] = $_SESSION['brandList'];
        $data['deptList'] = $_SESSION['department_id'];
        $data['classes'] = $_SESSION['classList'];

        $data['title']= "shop page for fetchdelivers.com";
        //$brands = $this->Product_model->get_manufacturers($_SESSION['department_id'],$_SESSION['classList']);
        $products = $this->Product_model->get_products($_SESSION['department_id'], $_SESSION['classList'], $_SESSION['brandList']);
        //$data['brands'] = $brands;
        $data['dept_id'] = $_SESSION['department_id'];
        $data['classes'] = $_SESSION['classList'];
        $data['products'] = $products;
        $this->template->load('default', 'products/shop', $data);
    }

    public function stuffs( $departmentId=null, $classId=null, $brandId=null, $subClassId=null, $stageId=null )
     {
       if(isset($_POST['idArray'])){
           $_SESSION['classList'] = $_POST['idArray'];
           $_SESSION['department_id'] = $_POST['department'];
           echo "1";
           exit;
       }
       //$uri
       if($departmentId==null){
           $this->index();
       }
       else{

           $department = array();

           $brands = array();

           $urls =array();
           $urls['deptSection'] = $departmentId;
           $urls['classSection'] = $classId;
           $urls['brandSection'] = $brandId;
           $urls['subClassSection'] = $subClassId;
           $classes = $this->Product_model->get_classes($departmentId);

           $data["urlSegment"] = $urls;
           $data["departments"]=$department;
           $i=0;
           foreach($classes as $class){
               $classList[$i] = array_merge($class,array("images"=>$this->Product_model->getClassImages($departmentId, $class['class_id'])));
               $i++;
           }
           $data["classes"] = $classList;
           $data['username'] = array('id' => 'username', 'name' => 'username');
           $data['password'] = array('id' => 'password', 'name' => 'password');
           $this->template->load('default', 'products/stuffs', $data);
       }
    }
} 