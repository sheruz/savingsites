<?php
class Zone_model_delete extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->database();
    }
	
	function business_delete($business_id_arr='',$zone_id_arr=0,$type_of_zone=0,$type=0,$type_by_category='',$business_zone=0,$businessmode='',$typeofadds='',$paymentstatus='',$activestatus='',$typeofbusinesses=''){
		//var_dump($business_id_arr,$zone_id_arr,$type_of_zone,$type,$type_by_category,$business_zone,$businessmode,$typeofadds,$paymentstatus,$activestatus,$typeofbusinesses);  exit;
		// + Check Current Zone OR All Zone
		if($type_of_zone==0){ // current zone
			$zone_id=$zone_id_arr;
		}else{ // all zone
			$zone_id=$zone_id_arr;
		}
		// - Check Current Zone OR All Zone
		// + Fetch Business Data
		if(!empty($business_id_arr)){
			$business_id=$business_id_arr; 
		}else{
			 $business_id = '' ;
			//$business_id=$this->fn_business_delete_fetch_business_id($zone_id,$type,$type_by_category,$business_zone); 
		}
		$this->load->model('zone/businesses_delete', 'bd');
		$value= $this->bd->businesses_delete($business_id,$zone_id,$businessmode,$typeofadds,$paymentstatus,$activestatus,$typeofbusinesses);
		//var_dump($value);
		if($value == "delete"){
			return "delete";
		}else{
			return "success";
		}
		// - Fetch Business Data
		/*if($type_by_category=='ub'){ 			
			$this->load->model('zone/uploaded_businesses_delete', 'ubd');
			$this->ubd->uploaded_businesses_delete($business_id,$zone_id);
		}else{ 
			$this->load->model('zone/businesses_delete', 'bd');
			$this->bd->businesses_delete($business_id,$zone_id,$businessmode,$typeofadds,$paymentstatus,$activestatus,$typeofbusinesses);//var_dump($businessmode);exit;
			//$this->fn_business_delete_step_1($business_id,$zone_id,$type,$type_by_category,$business_zone);
		}*/
		
	}
	
	function fn_business_delete_fetch_business_id($zone_id,$type,$type_by_category,$business_zone){ 
		$allbusinessids=array();
		$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;		
		if($type_by_category=='ub'){
			$sql="SELECT group_concat(b.id) as id FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid IN(".$zone_id.")  and a.approval IN(".$type.") and isdefault=".$business_zone;
		}else{
			if($type_by_category=='pbntc' || $type_by_category=='tbntc' || $type_by_category=='nb'){
				$where_cat_subcat=" and h.catid!='-99' and h.subcatid!='-99'";
				$where_isdefault= " and a.isdefault IN(1)";
				$where_type=" and a.type=1";
			}else if($type_by_category=='pbtc' || $type_by_category=='tbtc'){
				$where_cat_subcat=" and h.catid='-99' and h.subcatid='-99'";
				$where_isdefault= " and a.isdefault IN(0,1)";
				$where_type=" and a.type=1";
			}else if($type_by_category=='fbt' || $type_by_category=='fbp'){
				$where_cat_subcat=" and h.catid=14";
				$where_isdefault= " and a.isdefault IN(0,1)";
				$where_type=" and a.type=2";
			}else if($type_by_category=='ub_m'){
				$where_cat_subcat=" and h.catid='-99' and h.subcatid='-99'";
				$where_isdefault= " and a.isdefault IN(1)";
				$where_type=" and a.type=1";
			}
			
			$where_approval=" and a.approval IN(".$type.")";
			
			$where_group_by=" GROUP BY a.businessid ";
			
			
			$table="ads_setting_preferences a,business b,address c,users d,users_groups e, ads f, ad_to_zone g, ad_category_subcategory h";
			$table_relation="a.businessid=b.id and b.addressid=c.id and b.business_owner_id=d.id and d.id=e.user_id and b.id=f.business_id and f.id=g.adid and f.id=h.adid ";
			$table_relation_1=" and a.settingszoneid IN(".$zone_id.")";
			$select_value="group_concat(a.businessid) as id ";
			$sql="select $select_value from $table where $table_relation $table_relation_1 $where_isdefault $where_type $where_business_zone $where_cat_subcat $where_approval ";
		}
		//echo $sql;
		$query = $this->db->query($sql);
		$result= $query->result_array() ; 
		if(!empty($result)){
			$allbusinessids= $result[0]['id']; 
		}
		//return $allbusinessids;
		return $this->fn_remove_duplicate_values($allbusinessids); 
		
	}
	

function fn_remove_duplicate_values($str) {
    return implode(',', array_keys(array_flip(explode(',', $str))));			
}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
}