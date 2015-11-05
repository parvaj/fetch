<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Al Amin
 * Date: 8/27/15
 * Time: 5:13 PM
 */
class Product_model extends CI_Model{

    public function __construct()
    {
        $this->load->database();
    }
    public function get_departments()
    {
        $sql = "select
                    department.department_id,department_name,COUNT( items.product_id ) AS mos,max(price.price) as price
                from
                    combos, items,department,price
                where
                    department.department_id = combos.department_id
                    AND items.product_id = combos.product_id
                    and items.product_id=price.product_id
                    and department.department_id in(3,2,1,4,8,7,9,6,11,5)
                group by
                    department.department_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_classes($departmentId)
    {
        $sql = "SELECT
                    DISTINCT class.class_id, class_name,'a' as upc,COUNT( items.product_id ) AS mos,max(price.price) as price
                FROM
                    combos, class, items,price
                WHERE
                    combos.department_id ='".$departmentId."'
                    AND class.class_id = combos.class_id
                    AND items.product_id = combos.product_id
                    AND items.product_id = price.product_id
                    and class.class_id>0
                GROUP BY
                    class_name
                ORDER BY
                    class_name";

        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_classesInfo($classId)
    {
        $sql = "SELECT
                    DISTINCT class.class_id, class_name
                FROM
                    class
                WHERE
                    class_id in (".$classId.")
                GROUP BY
                    class_name
                ORDER BY
                    class_name";

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_manufacturers($departmentId,$classId=null)
    {
        $sql = "select
                    distinct manufacturer.manufacturer_id,manufacturer.manufacturer_name,graphic
                from
                    combos, manufacturer
                where
                    combos.department_id='".$departmentId."'
                    and combos.manufacturer_id=manufacturer.manufacturer_id
                    ".($classId!=null && $classId>2?"  and combos.class_id in(".$classId.")":"")."
                order by
                    manufacturer_name";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_manufacturersInfo($brandId)
    {
        $sql = "select
                    manufacturer.manufacturer_id,manufacturer.manufacturer_name,graphic
                from
                    manufacturer
                where
                    manufacturer_id in (".$brandId.")
                order by
                    manufacturer_name";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_subclasses($departmentId,$classId=null,$brandId=null)
    {
        $sql = "select
                    distinct subclass.subclass_id,subclass.subclass_name
                from
                    combos, subclass
                where
                    combos.subclass_id=subclass.subclass_id
                    and subclass.subclass_id>1
                    and combos.department_id='".$departmentId."'
                    ".($classId!=null && $classId>2?" and combos.class_id in (".$classId.")":"")."
                    ".($brandId!=null && $brandId>2?" and combos.manufacturer_id in (".$brandId.")":"")."
                order by
                    subclass_name";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_products($departmentId, $classId, $brandId=null, $subClassId=null)
    {
        $sql = "select

                    distinct products.leadtime,
                    products.product_id,
                    products.fetch_likes,
                    combos.manufacturer_id,
                    products.group_id,
                    COUNT( items.product_id ) AS mos,
                    products.product_name,
                    products.extended,
                    products.ingredients,
                    products.analysis,
                    products.upc,
                    products.weight,
                    products.unit,
                    products.img,
                    price.price,
                    manufacturer.manufacturer_name,
                    manufacturer.manufacturer_id,
                    combos.class_id


                from
                    combos
                    inner join products on combos.product_id=products.group_id
                    inner join price on price.product_id=products.product_id
                    left join items on products.product_id=items.product_id
                    left join products_keywords on products_keywords.product_id=combos.product_id
                    left join manufacturer on combos.manufacturer_id = manufacturer.manufacturer_id
                where
                    products.product_status = 1
                    and combos.department_id='".$departmentId."'
                    ".($classId!=null && $classId>2? " and combos.class_id in( ".$classId.")":"")."
                    ".($brandId!=null && $brandId>2?" and combos.manufacturer_id in (".$brandId.")":"")."
                    ".($subClassId!=null?" and combos.subclass_id  in (".$subClassId.")":"")."

                group by
                    products.product_id
                order by
                    products.group_id,price.price asc,products.product_id
                limit 12";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_items($groupId)
    {
       $sql = "SELECT
                    products.product_id,
                    EXTENDED ,
                    ingredients,
                    leadtime,
                    analysis,
                    upc,
                    group_id,
                    weight,
                    unit,
                    product_name,
                    discount_amount,
                    sales_price_type,
                    sales_price_applicable,
                    sales_price,
                    sales_price_for_duration,
                    start_date,
                    end_date,
                    sales_offer_applicable,
                    total_sold_limit,
                    sales_offer_type,
                    manufacturer_name,
                    manufacturer.manufacturer_id,
                    price,
                    class_id,
                    img
                FROM
                    products, combos, manufacturer, price
                WHERE
                    products.group_id =  '".$groupId."'
                    AND products.product_status = 1
                    AND combos.product_id = products.group_id
                    AND combos.manufacturer_id = manufacturer.manufacturer_id
                    AND price.product_id = products.product_id
                GROUP BY
                    products.product_id
                order by
                    price";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function getLargestBagOffer($groupId){

        $sql = "SELECT
                    products.product_id,
                    group_id,
                    weight,
                    unit,
                    product_name,
                    discount_amount,
                    sales_price_type,
                    sales_price_applicable,
                    sales_price,
                    sales_price_for_duration,
                    start_date,
                    end_date,
                    sales_offer_applicable,
                    total_sold_limit,
                    sales_offer_type,
                    manufacturer.manufacturer_id,
                    price,
                    class_id,
                    img
                FROM
                    products, combos, manufacturer, price
                WHERE
                    products.group_id =  '".$groupId."'
                    AND products.product_status = 1
                    AND combos.product_id = products.group_id
                    AND combos.manufacturer_id = manufacturer.manufacturer_id
                    AND price.product_id = products.product_id
                GROUP BY
                    products.product_id
                order by
                    price desc
                limit 1";
        $query = $this->db->query($sql);
        return $query->result_array();


    }
   /* public function getDepartmentImages($deptId){
        $sql = "select petimg from department where department_id ='".$deptId."'";
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            $row = $query->row_array();
            $imageName = $row['petimg'];
        }else
            $imageName = 0;
        return $imageName;
    } */

    public function getClassImages($departmentId, $classId)
    {
        $sql ="SELECT
                  upc,count(item_id) as c ,img
                FROM
                  items inner join combos using(product_id) inner join products on products . product_id = items . product_id
                WHERE
                  combos . department_id = '".$departmentId."' and combos . class_id = '".$classId."'
                GROUP BY
                    upc
                ORDER BY
                c desc
                    LIMIT 0,1";
            $query = $this->db->query($sql);
            if($query->num_rows()>0) {
                $classImage = $query->row()->img;
            }
        return $classImage;

    }
}