<?php
class Managemenu extends CI_Model
{ 
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function get_menu_items($zoneid='',$businessid='',$cat_id=0,$fromwhere="")
    {
      
        if ($fromwhere=="topcuisines") {
           $catlist = "AND (t1.category_id IN (".$cat_id.") OR t1.parent_category_id IN (".$cat_id."))";
        }else{
        $catlist = $cat_id==0 ? "" : "AND t1.category_id IN (".$cat_id.")";
        }
        $this->db->query("SET SESSION group_concat_max_len=10000000000000") ;
         $sql="SELECT
             t1.id, b3.name as busname ,t2.foreign_id,t1.category_id,t1.image,t1.price,t1.set_different_sizes,
            group_concat(t2.field,'>>') AS fields,
            group_concat(t2.content,'>>') AS contents
            FROM
            menu_builder_products AS t1
            INNER JOIN menu_builder_multi_lang AS t2 
            ON t1.id = t2.foreign_id
            INNER JOIN business AS b3
            ON t1.business_id= b3.id
            where t1.zone_id= $zoneid AND t1.business_id= $businessid AND t1.status = 'T'
            AND t2.model='pjProduct' $catlist
            group by t1.id
            order by t1.order ";
         $query = $this->db->query($sql);
        $result = $query->result_array();
       // return $this->db->last_query();
       // return $result;

        foreach ($result as $key => $value) {
            if($value['set_different_sizes']=="T"){
                $sql1="SELECT
                         t1.id,t1.price,t1.product_id,t2.content,t2.model,t2.field
                        FROM
                        menu_builder_products_prices AS t1
                        INNER JOIN menu_builder_multi_lang AS t2 
                        ON t1.id = t2.foreign_id
                        where t1.product_id = ".$value['id']." 
                        AND t2.model='pjProductPrice' AND t2.field='price_name'";
                $query1 = $this->db->query($sql1);
                $result1 = $query1->result_array();
                $result[$key]['price'] = $result1;
            }
        }
        return $result;
    }


     public function get_favlist($zoneid='',$businessid=''){
         
 
            $sql1="SELECT *  FROM  users_favorites_restaurant" ;
            $query1 = $this->db->query($sql1);
            $result1 = $query1->result_array();


          return $result1; 
        die;

     }

}