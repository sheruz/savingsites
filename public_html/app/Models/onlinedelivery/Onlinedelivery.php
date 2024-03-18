<?php
class Onlinedelivery extends CI_Model
{ 
  public function __construct(){
    parent::__construct();
        $this->load->database();
    }
    public function get_category($zoneid='',$businessid='',$limit=0,$value="")
    {
        $setlimit = $limit==0 ? "" : 'LIMIT '.$limit;
      $sql="SELECT t1.id, 
       t1.parent_id, 
       t1.image, 
       t2.field, 
       t2.content 
FROM   menu_builder_categories AS t1 
       INNER JOIN menu_builder_multi_lang AS t2 
               ON t1.id = t2.foreign_id 
WHERE  t1.zone_id = $zoneid 
       AND t1.business_id = $businessid 
       AND t2.model = 'pjCategory' 
       AND t2.field = 'name' 
       AND ( t1.parent_id IS NULL 
              OR t1.parent_id = 0 
              OR t1.parent_id = NULL ) 
       AND t2.content LIKE '%".$value."%' 
ORDER  BY t1.order  $setlimit";
     $query = $this->db->query($sql);
        $result = $query->result_array();
        //return $this->db->last_query();
        return $result;
    }


      ###############################################################################################

  function get_products_details($zoneid=0,$id=0, $businessid=0){
// print_r($businessid);die;

 
    if($zoneid!=0){

      if($id==1){

        $cond=" and catid=1";

      }else if($id==14){

        $cond=" and catid=14";

      }else{

        $cond=" and catid NOT IN(1,14,-99)";

      }

      $this->db->query("SET SESSION group_concat_max_len=10000000000000") ;

      # get all cat ids

      $sql="SELECT group_concat(catid) as catid FROM category_display  WHERE zoneid=".$zoneid." ".$cond; 

      $query = $this->db->query($sql);

      $result=$query->result_array();     

      if(!empty($result)){

        $allcatids_str= $result[0]['catid'];

      }

      $allcatids=explode(',',$allcatids_str);

      $wh_in_arr=array();

      $wh_in_arr=$allcatids;

      $this->db->select('id,child_type,name,attachment_image');

      $this->db->where_in("id",$wh_in_arr); 

      $this->db->where('status',1);

      $sql=$this->db->get('category_new');

      $result=$sql->result_array();

 
       $wh_cond='';

       $subcat_id = '';

       $arr= array();

      foreach($result as $_x){
         $_x['attachment_image'] =  $_x['attachment_image'];
        if($_x['child_type']=='y'){
          
     

          $wh_cond=" group by b.name order by subcat_name asc,b.name asc";

          $sql="SELECT a.id as subcat_id,a.name as subcat_name,b.* FROM category_subcategory_new a,category_sub_subcategory_new b, subcategory_display c WHERE a.id=b.parent_id and b.id=c.subcatid and a.catid=c.catid and b.parent_type='s' and a.catid=".$_x['id']." and c.zoneid=".$zoneid.$wh_cond;

          $query = $this->db->query($sql);

          $result=$query->result_array();

          $i=0; 

          foreach($result as $k=>$subcat){  
 


            $sql_adcount ="SELECT count(distinct a.adid) AS adcount,a.subcatid from ad_category_subcategory a,   menu_builder_products mb , ads b, ads_setting_preferences c   where a.adid = b.id AND  b.business_id = mb.business_id  AND b.business_id = c.businessid AND c.approval IN(1,2) AND a.catid=".$_x['id']." and a.zoneid=".$zoneid."  "; //echo '<br>'; echo '<br>';

            if($businessid){
              $sql_adcount .=" and c.businessid = ".@$businessid." and "; //echo '<br>'; echo '<br>';

            }else{

              $sql_adcount .=" and "; 
            }

            $sql_adcount .="   a.subcatid=".$subcat['id']." and a.display_zone=1  GROUP BY a.subcatid"; //echo '<br>'; echo '<br>';

            $query_adcount = $this->db->query($sql_adcount);

            $result_adcount=$query_adcount->result_array();           

            if(!empty($result_adcount)){

              if($result_adcount[0]['adcount']==0){

                /*$adcount='[0]';*/

              }else{

                $adcount='['.$result_adcount[0]['adcount'].']';

                if(!empty($subcat['subcat_id'])){

                  $subcat_id = $subcat['subcat_id'] ;

                }

            

                $arr[$_x['name'].'#'.$_x['id']][$subcat['subcat_name'].'#@#'.$subcat_id][$i++]=$subcat['name'].'#'.$subcat['id'].'#'.$adcount.'#'.$subcat_id;
                 if($_x['attachment_image']){
                 // $arr[$_x['name'].'#'.$_x['id']]['attachment_image']=   $_x['attachment_image'];
                }
              

              }

            }else{

              /*$adcount='[0]';*/

            }

            

          }

        }else if($_x['child_type']=='n'){

          $sql="SELECT a.* FROM category_sub_subcategory_new a, subcategory_display b WHERE a.id=b.subcatid and a.parent_id=b.catid  and a.parent_type='c' and a.parent_id=".$_x['id']." and b.zoneid=".$zoneid." order by a.name asc";

          $query = $this->db->query($sql);

          $result=$query->result_array();         

          $i=0; 

          foreach($result as $k=>$subcat){

            $sql_adcount="SELECT count(distinct adid) AS adcount,subcatid from ad_category_subcategory where catid=".$_x['id']." and zoneid=".$zoneid." and subcatid=".$subcat['id']." and display_zone=1  GROUP BY subcatid";

            $query_adcount = $this->db->query($sql_adcount);

            $result_adcount=$query_adcount->result_array();

            if(!empty($result_adcount)){
 
              if($result_adcount[0]['adcount']==0){

                /*$adcount='[0]';*/

              }else{

                $adcount='['.$result_adcount[0]['adcount'].']';

                $arr[$_x['name'].'#'.$_x['id']][-100][$i++]=$subcat['name'].'#'.$subcat['id'].'#'.$adcount;
                if($_x['attachment_image']){
                  //$arr[$_x['name'].'#'.$_x['id']]['attachment_image']=   $_x['attachment_image'];
                }

                //$arr[$_x['image'].'#'.$_x['id']][-100][$i++]=$_x['attachment_image'];


              }

            }else{

             

            }

           

          }

        }

      } 
 
      return $arr;      

    }

    

  }


     public function get_paymentdetails($businessid='')
    {
      $sql="SELECT *  FROM   restaurantbooking_payment_details AS t1  WHERE  t1.UserID = $businessid";
      $query = $this->db->query($sql);
      $result = $query->result_array();
    
      return $result;
    }



     public function getzoneemail($zoneid = ''){

        $sql = 'SELECT users.* FROM `sales_zone` inner join users on users.id = sales_zone.sales_rep_id where sales_zone.id = '.$zoneid;
        $query = $this->db->query($sql);
        $result = $query->result_array();
      
        return $result;


     }

    public function get_business_by_id($businessid='')
    {
  

  $sql="SELECT t1.id,
      b.deliver ,  
      b.delivery_charges , 
        b.delivery_time , 
      t1.name, 
      t1.contactemail, 
      t1.contactfirstname, 
      t1.contactlastname,
      t2.street_address_1,
      t2.street_address_2,
      t2.city,
      t2.state,
      t2.zip_code,
      t2.phone,
      t2.phone_int 
      FROM   business AS t1 
      INNER JOIN address AS t2   
      ON t1.addressid = t2.id 
          INNER join ads as b on t1.id = b.business_id
      WHERE  t1.id = $businessid and  b.categoryid !=-99 ";


      $query = $this->db->query($sql);
      $result = $query->result_array();
   
      return $result;
    }




     public function get_order_by_id($userid='')
    {
      $data = [];
      $sql="SELECT u1.username as username, u1.email as useremail ,  t1.* , b1.name as bus_name  
      FROM   online_order AS t1  
      INNER JOIN business AS b1
      ON b1.id = t1.business_id 
      INNER JOIN users AS u1
      ON u1.id = t1.user_id 
      WHERE  t1.user_id = $userid ORDER BY t1.id DESC";
      $query = $this->db->query($sql);
      $result = $query->result_array();
      $count = 0;
 
      foreach ($result as $key  ) {   
      $data['orderdata'][$count] = $key;

         $productID = json_decode($key['product']);
        
            $c = 0;
             foreach ($productID as $key ) {
 
                  $sql1 = "SELECT t1.*, 
                   t1.id,t2.foreign_id,t1.category_id,t1.image,t1.price,t1.set_different_sizes,
                  group_concat(t2.field,'>>') AS fields,
                  group_concat(t2.content,'>>') AS contents
                  FROM
                  menu_builder_products AS t1
                  INNER JOIN menu_builder_multi_lang AS t2 
                  ON t1.id = t2.foreign_id
                  where  t1.id= $key AND t1.status = 'T'
                  group by t1.id ";
                
                  $query1 = $this->db->query($sql1);
               
                  $data['orderdata'][$count]['productdata'][$c] =   $query1->row_array();
                  
                  $c++;                
 
             }   
  $count++;

      }
  
      return $data;
    }


  public function favouriteItem($userid=''){

      $data = [];
           $sql="SELECT DISTINCT t1.id , u1.username as username, u1.email as useremail , t1.* , b1.name as bus_name FROM users_favorites_restaurant AS t1 
INNER JOIN business AS b1 ON b1.id = t1.restaurant
INNER JOIN users AS u1 ON u1.id = t1.userid 
INNER JOIN users_favorites_restaurant AS f1 ON f1.userid = u1.id      WHERE  t1.userid = $userid ORDER BY t1.id DESC";
      $query = $this->db->query($sql);
      $result = $query->result_array();
      $count = 0;
 
       
      foreach ($result as $key) {   
      $data['orderdata'][$count] = $key;
  
       
 
     $c = 0;
          
 
         
                    $sql1 = "SELECT t1.*, 
                   t1.id,t2.foreign_id,t1.category_id,t1.image,t1.price,t1.set_different_sizes,
                  group_concat(t2.field,'>>') AS fields,
                  group_concat(t2.content,'>>') AS contents
                  FROM
                  menu_builder_products AS t1
                  INNER JOIN menu_builder_multi_lang AS t2 
                  ON t1.id = t2.foreign_id
                  where  t1.id=  ".$key['fav_res']."  AND t1.status = 'T'
                  group by t1.id ";
                
                  $query1 = $this->db->query($sql1);
               
                  $data['orderdata'][$count]['productdata'][$c] =   $query1->row_array();
                  
                  $c++;                
 
               
  $count++;
 
      }
 
 
 
      return $data;
 
  }





    public function get_subcategory($zoneid='',$businessid='',$limit=0,$value="")
    {
        $setlimit = $limit==0 ? "" : 'LIMIT '.$limit;
        $sql="SELECT t1.id, 
       t1.parent_id, 
       t1.image, 
       t2.field, 
       t2.content 
FROM   menu_builder_categories AS t1 
       INNER JOIN menu_builder_multi_lang AS t2 
               ON t1.id = t2.foreign_id 
WHERE  t1.zone_id = $zoneid 
       AND t1.business_id = $businessid 
       AND t2.model = 'pjCategory' 
       AND t2.field = 'name' 
       AND t1.parent_id IS NOT NULL 
       AND t2.content LIKE '%".$value."%' 
ORDER  BY t1.order   $setlimit";
         $query = $this->db->query($sql);
        $result = $query->result_array();
        //echo $this->db->last_query();
        return $result;
    }

 



    public function send_email($zoneid='',$businessid='')
    {
        $sql="SELECT t1.email, t2.contactemail FROM users AS t1 INNER JOIN business AS t2 ON t1.id = t2.created_by where t2.id = $businessid";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function placeorder($data,$table)
    {
       
      $this->db->insert($table,$data);
     return $this->db->last_query();
    }

    public function getpboocredit($userid,$bidderid,$credit,$order_id)
    {
            $sql="UPDATE tbl_member SET balance=balance+".$credit." WHERE user_id=".$bidderid;
            $query = $this->db->query($sql);

            $sql1="UPDATE tbl_sales_order SET certificate_verify = 1 WHERE order_id=".$order_id;
            $query1 = $this->db->query($sql1);
    }

    public function check_certficate($post){
      $user_id = $post['user_id'];
      $certificate_id=!empty($post['certificate_id']) ? $post['certificate_id'] : '';
      $businessid=!empty($post['businessid']) ? $post['businessid'] : '';


      $sql2 = "SELECT t1.id, 
       t1.username, 
       t1.first_name,
       t1.last_name,
       t2.user_id AS tbl_user_id, 
       t2.balance 
FROM   users AS t1 
       INNER JOIN tbl_member AS t2 
               ON t1.username = t2.user_name 
WHERE  t1.id = $user_id";
        $query2 = $this->db->query($sql2);
        $result2 = $query2->row();
        $sql1 = "SELECT t1.id, 
       t1.business_owner_id, 
       t2.username,
       t2.email,

       t3.user_id AS tbl_business_id, 
       t3.balance
FROM   business AS t1 
       INNER JOIN users AS t2 
               ON t1.business_owner_id = t2.id 
       INNER JOIN tbl_member AS t3
               ON t2.username=t3.user_name
WHERE  t1.id = $businessid";
        $query1 = $this->db->query($sql1);
        $result1 = $query1->row();
   //   return $this->db->last_query(); exit;

     echo  $sql = " SELECT a.product_id,
        b.user_id,
       a.user_id,
       e.certificate_verify,
       e.order_id,
       e.user_id AS bidder_id,
       f.auc_id,
       f.buy_price_decrease_by,
       f.current_price
FROM   tbl_inventory_products a,
       tbl_member b,
       users c,
       business d,
       tbl_sales_order e,
       tbl_auction f
WHERE  a.product_id = $certificate_id  
       AND a.user_id = b.user_id
       AND b.user_name = b.user_name
       and b.user_id=   $result1->tbl_business_id 
       AND a.product_id = f.product_id
       AND c.id = d.business_owner_id
       AND e.auc_id = f.auc_id
      AND e.user_id =   $result2->tbl_user_id  
GROUP  BY a.product_id"; 
  
       
        
         
        $query = $this->db->query($sql);
        $result = $query->row();
       /*return $this->db->last_query(); exit;*/
        return $result;
    }
    public function catNameByID($value='')
    {
/*      SELECT *
FROM `menu_builder_multi_lang`
WHERE `foreign_id` = '75' and model='pjProduct' and field='name'
LIMIT 50*/
      $sql = 'SELECT * 
          FROM `menu_builder_multi_lang` 
         WHERE model="pjProduct" AND field="name"  AND source="data" AND `foreign_id` IN ("' . $value . '")';


                $query = $this->db->query($sql);
        $result = $query->result_array();
      // return $this->db->last_query(); exit;
        return $result;//;
    }
}