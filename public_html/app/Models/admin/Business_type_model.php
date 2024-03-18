<?php
namespace App\Models\admin;

use CodeIgniter\Model;
use App\Controllers\CommonController;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class Business_type_model extends Model{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->CommonController = new CommonController();
    } 
    
    function get_business_types_name_array()

    {

        $query = $this->db->query('SELECT * from business_type');



        $ret = array();

        foreach($query->result_array() as $ra)

        {

            $ret[$ra['id']] = $ra['name'];

        }



        return $ret;

    }
    
    public function get_all_bussdata($business_id){
        $query = 'SELECT * from business inner join address on address.id =  business.addressid where business.id='.$business_id; 
        return $this->CommonController->SelectRawquery($query, 'resultArray');
    }

    public function get_all_dealsdata($business_id,$zoneid){
        $query = 'select distinct tbd.deal_id as dealid , tbld.* , tbd.*  from ads_setting_preferences a 

        INNER JOIN business b ON a.businessid=b.id 
        INNER JOIN address c ON b.addressid=c.id 
        INNER JOIN users d ON b.business_owner_id=d.id 
        LEFT JOIN users_groups e ON d.id=e.user_id 
        LEFT JOIN ads f ON b.id=f.business_id 
        LEFT JOIN ad_to_zone g ON f.id=g.adid 
        LEFT JOIN ad_category_subcategory h ON f.id=h.adid 
        left join tbl_member tblm on tblm.user_name =  d.username 
        left join tbl_deals_products  tbld on tbld.user_id = tblm.user_id 
        left join tbl_deals  tbd on tbd.product_id = tbld.deal_product_id 


        where a.settingszoneid="'.$zoneid.'" and a.type IN(1,2) and a.isdefault IN(0,1) and a.approval IN(1,2,3,-1,-2,-3) and  a.businessid = "'.$business_id.'" ';






        return $this->CommonController->SelectRawquery($query, 'resultArray');
    }
    
    function get_all_business_types_name()
    {
        $query = $this->db->query('SELECT * from business_type');
    
        $ret = array();
        return $query->result_array();
    }
    public function update_business_logo($business_id,$image_name){
        $path="/uploads/ckeditor/".$business_id."/".$image_name;
        $sql="UPDATE business SET logo='".$path."' WHERE id=".$business_id;
        //print_r($sql);
        $result=$this->db->query($sql);
        return $result;     
    }

     public function update_business_image_logo($business_id,$image_name){
        $path="/uploads/ckeditor/".$business_id."/".$image_name;
        $sql="UPDATE business SET common_logo_image='".$path."' WHERE id=".$business_id;
        //print_r($sql);
        $result=$this->db->query($sql);
        return $result;     
    }

    public function delete_logo($id){
        $sql="UPDATE business SET logo='' WHERE id=".$id;
        $result=$this->db->query($sql);
        return $result;
    }
    public function make_sponsered_business($zone_id,$business_id) {
        $sql="INSERT INTO business_sponsor(business_id,status,zone_id) VALUES(".$business_id.",0,".$zone_id.")";
        $result=$this->db->query($sql);
        return $result;

    }
    public function remove_sponsered_business($zone_id,$business_id) {
        $sql="DELETE FROM business_sponsor WHERE business_id=".$business_id." AND zone_id=".$zone_id;
        $sql1="DELETE FROM business_sponsor_order WHERE business_id=".$business_id;
        $result=$this->db->query($sql);
        $this->db->query($sql1);
        return $result;
    }


}

