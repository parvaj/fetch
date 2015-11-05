<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Al Amin
 * Date: 9/1/15
 * Time: 9:11 AM
 */
class Checkout_model extends CI_Model{

    public function __construct(){
        $this->load->database();
    }

    public function additemoncart($data)
    {
        return  $query = $this->db->insert('items',$data);
    }

    public function cartCount($orderId,$custId)
    {
        $this->db->from('items');
        if($custId>0)
            $this->db->where('order_no',$orderId);
        else
            $this->db->where('order_id',$orderId);
        return $count = $this->db->count_all_results();

    }
    public function cartAmount($custId,$sOrderNo )
    {
        if ($custId > 0) {
            $sql = "select
                        distinct products.product_id,
                        upc,
                        product_name,
                        weight,
                        unit,
                        qty,
                        price,
                        extended,
                        products.taxable,
                        item_id ,
                        manufacturer_name
                    from
    					items, products , combos ,manufacturer
	    			where
                        products.product_id=items.product_id
                        and combos.product_id=products.group_id
                        and manufacturer.manufacturer_id=combos.manufacturer_id
                        and cust_id = ?
                        AND confirmed IN ('P', 'N')
                        AND active = 'Y'
                        AND removed <> 'Y'
                        AND locked = 0
                        AND order_no = ?
                    ORDER BY
					    next_delivery";
            return $rows = $this->db->query($sql,array($custId,$sOrderNo))->num_rows();
        }
        else{
            $sql= "select
                        distinct products.product_id,
                        upc,
                        product_name,
                        weight,
                        unit,
                        qty,
                        price,
                        extended,
                        products.taxable,
                        item_id,
                        manufacturer_name
                    from
                        items, products, combos ,manufacturer
                    where
                        products.product_id=items.product_id
                        and combos.product_id=products.group_id
                        and manufacturer.manufacturer_id=combos.manufacturer_id
                        and order_id=?";
            return $rows = $this->db->query($sql,array($sOrderNo))->num_rows();
        }

    }

    public function getOrderNo($custId){
        $sOrderNo='';

        $sql = "SELECT
                    a.order_no
                FROM
                    items a
                WHERE
                    a.cust_id = ?
                    AND a.confirmed in ( 'P', 'N')
                    AND active = 'Y'
                    AND removed <> 'Y'
                    AND locked = 0
                    AND discount_code = ''
                GROUP BY
                    order_no
                ORDER BY
                    SUBSTRING(order_no,5) ";
        $query = $this->db->query($sql,array($custId));
        $row =  $query->num_rows();
        if( !empty($row)){
            $sOrderNo = $query->row()->order_no;
        }
        if($sOrderNo==''){
            $sql = "SELECT max(SUBSTRING(order_no,5)) as maxOrderNo from items";
            $maxOrderNo = $this->db->query($sql)->row()->maxOrderNo+1;

            $sOrderNo =  sprintf("%04s", $custId) . sprintf("%06s", $maxOrderNo);
        }
        return $sOrderNo;
    }

    public function updatedOrderCompleted( $cust_id, $iOrderId, $sOrderNo, $deliveryDate ){
        $query="UPDATE
                    items
                set
                    cust_id= ?,
                    confirmed='P',
                    order_id='0',
                    order_no = ?,
                    next_delivery = ?
			    WHERE
			        order_id = ?
				    AND cust_id = '-1'";
        $this->db->query($query,array($cust_id,$sOrderNo,$deliveryDate,$iOrderId));
    }

    public function updateCurrentOrderDate($sOrderNo,$deliveryDate)
    {
        $query="UPDATE
                    items
                set
                    next_delivery = ?
			    WHERE
			        order_no = ?
			        AND confirmed IN ('N','P')
                    AND active = 'Y' AND invoiced <> 'Y' AND removed <> 'Y'
                    ";
        $this->db->query($query,array($deliveryDate,$sOrderNo));
    }

    public function productsInCart($cust_id){

        $sql = "SELECT
                    a.order_no
        		from
        		    items a
		        where
		            a.cust_id = ?
                    AND a.confirmed IN ('N','P')
                    AND active = 'Y' AND invoiced <> 'Y' AND removed <> 'Y'
                    and locked = 0 AND discount_code = ''
                group by
                    order_no
                order by
                    SUBSTRING(order_no,5)";
        $rows = $this->db->query($sql,array($cust_id))->num_rows();

        return $rows;
    }

    public function getdeliveryDate( $cust_id ){

        $sql = "SELECT
                    a.order_no, a.next_delivery
                FROM
                    items a
                where
                    a.cust_id = ?
                    AND a.confirmed IN ('P', 'N')
                    AND active = 'Y'
                    AND removed <> 'Y'
                    AND locked = 0
                GROUP BY
                    next_delivery
                ORDER BY
                    a.next_delivery";
        return $this->db->query($sql,array($cust_id))->result_array();

    }

    public function getItemInCart($cust_id,$orderNo){

        $sql = "SELECT
                    `items`.`item_id`,
                    `items`.order_no,
                    `items`.`qty`,
                    `items`.`price`,
                    `items`.`frequency_id`,
                    `items`.`last_delivery`,
                    `items`.`next_delivery`,
                    `items`.`active`,
                    `items`.`edit`,
                    `items`.`item_type_msg`,
                    `items`.`locked`,
                    `items`.`discount_code`,
                    `products`.`product_id`,
                    `products`.`leadtime`,
                    `products`.`group_id`,
                     products.img,
                    `products`.`product_name`,
                    `products`.`upc`,
                    `products`.`weight`,
                    `products`.`unit`,
                     products.taxable,
                    `manufacturer`.`manufacturer_name`,
                    `frequency`.`frequency`
                FROM `items`
                    LEFT JOIN `customer` ON `items`.`cust_id` = `customer`.`cust_id`
                    INNER JOIN `products` ON `items`.`product_id` = `products`.`product_id`
                    INNER JOIN `manufacturer` ON `items`.`manufacturer_id` = `manufacturer`.`manufacturer_id`
                    INNER JOIN `frequency` ON `items`.`frequency_id` = `frequency`.`frequency_id`

                WHERE
                    `items`.`cust_id` = ?
                    ".($cust_id>1?" AND `items`.`order_no` ":" and items.order_id ")." = ?
                    and items.product_id<>10834
                    and items.product_id<>0
                    AND `items`.`removed` != 'Y'
                    AND `items`.`active` = 'Y'
                    and items.invoiced <> 'Y'
                    AND `items`.`confirmed` in ('N', 'P')
                ORDER BY
                    `items`.`next_delivery` ASC, locked ASC";
        return $this->db->query($sql,array($cust_id,$orderNo))->result_array();
    }

    public function getProductPrice( $pID ){
        $sql = "select price from price where quantity=1 and product_id=?";
        return $this->db->query($sql,array($pID))->row()->price;
    }
    public function removeDublicateItems($pID, $custId,$orderType ){
        $sql="delete from items where product_id='".$pID."' and cust_id='".$custId."' and ".($custId>0?"order_no='".getOrderNo($cust_id)."'":"order_id='".dbsafe($_SESSION["sessionNumber"])."'")."";

    }

    /**
     * @param $itemRowId
     * @return bool
     */
    public function removeOrederItems($itemRowId){
        if(!empty($itemRowId)) {
            $sql = "update items set removed = 'Y', next_delivery = NULL, active = 'N', confirmed = 'Y', discount_code = '', ref_id = '' WHERE item_id = ?";
            return $query = $this->db->query($sql, array($itemRowId));
        }else{
            return false;
        }

    }
    public function updateOrderItems($itemRowId,$data)
    {
        if(!empty($itemRowId)){
           // $this->db->_compile_select();
            $this->db->where('item_id', $itemRowId);
            $this->db->update('items', $data);
            //echo $this->db->last_query();
           return $this->db->affected_rows();
        }
        else{
            return false;
        }
    }

}