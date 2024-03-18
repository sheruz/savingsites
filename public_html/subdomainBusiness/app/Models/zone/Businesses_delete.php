<?php
class Businesses_delete extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->database();
    }
	
	function businesses_delete($business_id='',$zone_id='',$businessmode='',$typeofadds='',$paymentstatus='',$activestatus='',$typeofbusinesses=''){
		$arr_business_in_one_zone=array(); $arr_business_in_more_zone=array(); //var_dump($typeofadds);exit;
		
		if(!empty($zone_id)){

			// D E L E T E    A L L    B U S I N E S S   R E S P E C T   TO  F I L T E R   R E S U L T
			if(empty($business_id)){			
				// BUSINESS IS ACTIVE OR DEACTIVE
				if($paymentstatus==4 && $activestatus==3){
					$business_type = "1,2,3,-1,-2,-3";
				}else if($paymentstatus !=4 && $activestatus==3){
					$business_type = $paymentstatus.",-".$paymentstatus;
				}else if($paymentstatus ==4 && $activestatus !=3){
					if($activestatus == 1){
						$business_type = "1,2,3";
					}else if($activestatus == 2){
						$business_type = "-1,-2,-3";
					}
				}else if($paymentstatus !=4 && $activestatus !=3){
					if($activestatus == 1){
						$business_type = $paymentstatus;
					}else if($activestatus == 2){
						$business_type = '-'.$paymentstatus;
					}
				}			
				$where_business_zone=" and a.isdefault IN(0,1)";
				
				// BUSINESS ADS CATEGORY AND SUBCATEGORY
				/*if($typeofadds==1){//var_dump(11);exit;
					$where_cat_subcat=" and h.catid='-99' and h.subcatid='-99'";
				}else if($typeofadds==2){//var_dump(22);exit;
					$where_cat_subcat=" and h.catid!='-99' and h.subcatid!='-99'";
				}*/
		
				$where_approval=" and a.approval IN($business_type)";	// PAID or TRIAL or UPLOADED (active or deactive)
				
				// WHETHER NORMAL BUSINESS OR BUSINESS OPPORTUNITY PROVIDERS
				/*if($businessmode != ''){
					$where_type=" and a.type=".$businessmode;
				}*/
				if($businessmode == 1){
					$where_type="  a.type IN(1,2)";
				}else if($businessmode == 2){
					$where_type="  a.type IN(2)";
				}
				$where_group_by=" GROUP BY a.businessid ";
				$where_order_by=" ORDER BY trim(b.name) asc";
				//$limit_where=" limit ".$lowerlimit.",".$upperlimit;
				
				$table="ads_setting_preferences a,business b,address c,users d,users_groups e, ads f, ad_to_zone g, ad_category_subcategory h";
				$table_relation="a.businessid=b.id and b.addressid=c.id and b.business_owner_id=d.id and d.id=e.user_id and b.id=f.business_id and f.id=g.adid and f.id=h.adid ";
				$table_relation_1=" and a.settingszoneid=$zone_id";
				 //echo $sql_one_bus="select GROUP_CONCAT(DISTINCT(a.businessid)) as businessid ,GROUP_CONCAT(DISTINCT(f.id)) as addid,GROUP_CONCAT(DISTINCT(e.user_id)) as user_id from $table where $table_relation $table_relation_1 $where_type $where_business_zone $where_approval"; exit;
				 $sql_one_bus=" SELECT SUBSTRING_INDEX(GROUP_CONCAT(businessid), ',', 500) as businessid from ads_setting_preferences a where $where_type $where_business_zone $where_approval and a.settingszoneid =".$zone_id; 
				$query_one_bus=$this->db->query($sql_one_bus); 
				
				$result_one_bus=$query_one_bus->result_array(); //var_dump($result_one_bus);exit;
				if(!empty($result_one_bus)){
					foreach($result_one_bus as $arr_one_bus)//var_dump($arr_one_bus);exit;
					  // $allbusinessids_bus=$arr_one_bus['businessid']; 
					   $arr_business_in_one_zone=rtrim($arr_one_bus['businessid'], ','); 
						//$allbusinessids_bus[$arr_one_bus['businessid']]= $arr_one_bus['businessid'];				
				//	$arr_business_in_one_zone=implode(',',$allbusinessids_bus); var_dump($arr_business_in_one_zone);exit;
				}else{
					$arr_business_in_one_zone='';
				}

			}else{			// D E L E T E    S P E C I F I C    B U S I N E S S   R E S P E C T   TO  F I L T E R   R E S U L T
				$arr_business_in_one_zone = $business_id ;//var_dump($arr_business_in_one_zone);exit;
			}
			
			//var_dump($arr_business_in_one_zone);exit;
		
			$sql_more_bus="SELECT businessid FROM ads_setting_preferences where businessid IN(".$arr_business_in_one_zone.") group by businessid having count(businessid)>1 ";			
			$query_more_bus=$this->db->query($sql_more_bus);
			$result_more_bus=$query_more_bus->result_array(); //var_dump($result_more_bus);exit;
			if(!empty($result_more_bus)){
				foreach($result_more_bus as $arr_more_bus)
					$allbusinessids_more_bus[$arr_more_bus['businessid']]= $arr_more_bus['businessid'];
			
				$arr_business_in_more_zone=implode(',',$allbusinessids_more_bus);
			}else{
				$arr_business_in_more_zone='';
			}//var_dump($arr_business_in_more_zone);var_dump($arr_business_in_one_zone);
			if($arr_business_in_one_zone!=''){
				return $this->fn_business_delete_in_one_zone($arr_business_in_one_zone,$zone_id,$sql_one_bus); //passing the above query which picks the business id
				
			}
			if($arr_business_in_more_zone!=''){
				$this->fn_business_delete_in_more_zone($arr_business_in_more_zone,$zone_id);
			}
		}
	}	
	function fn_business_delete_in_one_zone($arr_business_in_one_zone='',$zone_id='',$sql_one_bus=''){
		if($arr_business_in_one_zone=='' || $zone_id=='') continue;
		$arr_users_id=array(); $all_business_ids=''; $all_address_ids=''; $all_users_ids=''; $all_ad_ids=''; $arr_uid=array();
		$session_zoneid_arr=$this->session->userdata('session_zoneid');
		$session_userid=$session_zoneid_arr['sesuserid']; 
		if($session_userid==false) continue;
		$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;						
		// + Fetch Ads
		$sql_ad="SELECT group_concat(a.id) as adid from ads a, ad_to_zone b where a.business_id IN(".$arr_business_in_one_zone.") AND a.id=b.adid and b.zoneid IN(".$zone_id.")";
		$query_ad=$this->db->query($sql_ad);
		$result_ad=$query_ad->result_array(); //var_dump($result_ad);exit;
		if(!empty($result_ad)){
			$all_ad_ids= $result_ad[0]['adid']; 
		}
		// - Fetch Ads
		$sql_bus="SELECT group_concat(a.id) as busid,group_concat(a.addressid) as addressid,group_concat(a.business_owner_id) as userid from business a, ads_setting_preferences b where a.id=b.businessid and a.id IN(".$arr_business_in_one_zone.") and  b.settingszoneid IN(".$zone_id.")"; 
		$query_bus=$this->db->query($sql_bus);
		$result_bus=$query_bus->result_array(); 
		if(!empty($result_bus)){
			$all_business_ids=$result_bus[0]['busid']; 
			$all_address_ids=$result_bus[0]['addressid']; 
			$all_users_ids=$result_bus[0]['userid']; 
		}
		$sql="select sales_rep_id from sales_zone where id=".$zone_id;   
		$query=$this->db->query($sql);
		$result=$query->result_array(); 
		$zoneowner_user_id = $result[0]['sales_rep_id'];//var_dump($zoneowner_user_id);exit;
		
		$all_business_ids=$arr_business_in_one_zone;		
		$arr_users_id=explode(',',$all_users_ids);
		$arr_uid=array_unique($arr_users_id); 
		foreach($arr_uid as $key=>$v_arr_uid){
    		if($v_arr_uid==$zoneowner_user_id)
  				unset($arr_uid[$key]);	
		}
		
		$all_users_ids=implode(',',$arr_uid); 


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
		if($all_users_ids!=''){
			$_delete_users = "delete tbl_member.* , users.*  from users inner join tbl_member on  tbl_member.user_name = users.username  WHERE users.id IN (".$all_users_ids.")";
    		$this->db->query($_delete_users) ;
			$_delete_users_groups = "delete from users_groups WHERE user_id IN (".$all_users_ids.")";
    		$this->db->query($_delete_users_groups) ;
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
			$_delete_ad_setting_pref = "delete from ads_setting_preferences WHERE businessid IN (".$all_business_ids.")";
			$this->db->query($_delete_ad_setting_pref) ;			
			$_delete_business = "delete from business WHERE id IN (".$all_business_ids.")";
			$this->db->query($_delete_business) ;
			$_delete_business_op_hrs = "delete from business_operation_hour WHERE business_id IN (".$all_business_ids.") and zone_id IN(".$zone_id.")";
			$this->db->query($_delete_business_op_hrs) ;						
		}


		// - Delete Business 
		// ++ checking left businesses
		if($sql_one_bus != ''){
			$query_last_bus = $this->db->query($sql_one_bus);
			$result_left_bus=$query_last_bus->result_array();
			if($result_left_bus[0]['businessid'] != 'NULL' && $result_left_bus[0]['businessid'] != NULL){ 
			  return "delete";
			}else{
				return "success";
			}
			                
		}


	}
	function fn_business_delete_in_more_zone($arr_business_in_more_zone='',$zone_id=''){
		$this->fn_business_delete_in_one_zone($arr_business_in_more_zone,$zone_id);
	}
}