<?php
class Uploaded_businesses_delete extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->database();
    }
	
	function uploaded_businesses_delete($business_id='',$zone_id=''){ 
		if(!empty($business_id) || !empty($zone_id)){
			$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;
			// + Fetch All Ad ids
			$sql_ad="SELECT group_concat(a.id) as adid from ads a, ad_to_zone b where a.business_id IN(".$business_id.") AND a.id=b.adid and b.zoneid IN(".$zone_id.")";
			$query_ad=$this->db->query($sql_ad);
			$result_ad=$query_ad->result_array(); 
			if(!empty($result_ad)){
				$all_ad_ids= $result_ad[0]['adid'];  
			}
			// - Fetch All Ad ids
			// + Fetch Business ids
			$sql_bus="SELECT group_concat(a.id) as busid,group_concat(a.addressid) as addressid,group_concat(a.business_owner_id) as userid,group_concat(b.id) as prefid from business a, ads_setting_preferences b where a.id=b.businessid and a.id IN(".$business_id.") and  b.settingszoneid IN(".$zone_id.")"; 
			$query_bus=$this->db->query($sql_bus);
			$result_bus=$query_bus->result_array();
			if(!empty($result_bus)){
				$all_pref_ids=$result_bus[0]['prefid'];
				$all_business_ids=$result_bus[0]['busid']; 
				$all_address_ids=$result_bus[0]['addressid'];
				$all_users_ids=$result_bus[0]['userid'];
			}
			//var_dump($all_business_ids); var_dump($all_address_ids); var_dump($all_users_ids); var_dump($all_ad_ids); exit;
			// - fetch Business ids
			//var_dump($all_business_ids); var_dump($all_address_ids); var_dump($all_users_ids); var_dump($all_ad_ids); exit;
			// + Delete Ads
			if($all_ad_ids!=''){
				$_delete_ad_to_zone = "delete from ad_to_zone WHERE adid IN (".$all_ad_ids.")"; 
				$this->db->query($_delete_ad_to_zone) ;
				$_delete_ads= "delete from ads WHERE id IN (".$all_ad_ids.")";
				$this->db->query($_delete_ads) ;
				$_delete_ads_cat_subcat= "delete from  ad_category_subcategory WHERE adid IN (".$all_ad_ids.") and zoneid IN(".$zone_id.")";
				$this->db->query($_delete_ads_cat_subcat) ;
			}
			// - Delete Ads
			// + Delete Users
			if($all_users_ids!=''){  	// Added on 17.6.14 for not deleting those users which have multiple business
				$_delete_users_groups = "delete from users_groups WHERE user_id IN (".$all_users_ids.")";
				$this->db->query($_delete_users_groups) ;
				$_delete_users = "delete from users WHERE id IN (".$all_users_ids.")";
				$this->db->query($_delete_users) ;				
			}
			// - Delete Users
			// + Delete Address
			if($all_address_ids!=''){
				$_delete_address = "delete from address WHERE id IN (".$all_address_ids.")";
				$this->db->query($_delete_address) ;	
			}
			// - Delete Address
			// + Delete Business
			if($all_business_ids!=''){
				$_delete_ad_setting_pref = "delete from ads_setting_preferences WHERE id IN (".$all_pref_ids.")";
				$this->db->query($_delete_ad_setting_pref) ;			
				$_delete_business = "delete from business WHERE id IN (".$all_business_ids.")";
				$this->db->query($_delete_business) ;			
			}
			// - Delete Business
		}
	}
}