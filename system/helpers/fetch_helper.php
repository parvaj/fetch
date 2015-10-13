<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('fetch_classes'))
{
    function fetch_classes($departmentId = '')
    {
        $ci->load->database();

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
}