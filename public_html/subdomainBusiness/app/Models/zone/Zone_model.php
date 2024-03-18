<?php
namespace App\Models\zone;

use CodeIgniter\Model;
use App\Controllers\CommonController;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class Zone_model extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
    } 
	
	public function refferaldata($zoneid){


	   $sql="SELECT users.* , tbl_member.fromreferrer FROM `users` LEFT join tbl_member on tbl_member.user_name = users.username where tbl_member.fromreferrer != '' ";

		$query=$this->db->query($sql);

		$result=$query->result_array();

		// $arr=(!empty($result)) ? $result : 0; 
 
	    $arr = [];
	    $count = 0;
		foreach ($result as $key) {
			
			$arr[$count]['username'] = $key['username'];
			$arr[$count]['email'] = $key['email'];
			$arr[$count]['first_name'] = $key['first_name'];
			$arr[$count]['last_name'] = $key['last_name'];

			  $sql1="SELECT users.* FROM `users` where users.referral_code ='".$key['fromreferrer']."'";
		      $query1=$this->db->query($sql1);
		      $result1 = $query1->result_array();

		       foreach ($result1 as $key) {

		       	    $arr[$count]['reffered'] = $key['username'];
		             
		       }
		       $count++;
		}

 
		return $arr;



    }

     public function reffered_users($zoneid){


	
	   $sql="SELECT * FROM `users` inner join users_groups on users_groups.user_id = users.id where users_groups.group_id = 16 and users.Zone_ID =".$zoneid;

		$query=$this->db->query($sql);

		$result=$query->result_array();

		$arr=(!empty($result)) ? $result : 0; 
 
		return $arr;


    }



	public function get_zone($id, $key= ''){
		$Common = new CommonController();
    	$sql="SELECT * FROM sales_zone where id = $id LIMIT 1";
    	$result = $Common->getStoreCache($sql,'resultArray',$key,3600);
		$arr=(!empty($result[0])) ? $result[0] : 0;
		return $arr;
	}

    public function pbgpaidbusiness($zoneid=''){
    	$sql = "SELECT t1.packagename as packagename,t1.ammount as packageprice ,t1.pbg_user_id as pbguserid, t2.id as business_id, t2.name as business_name, t3.email as user_email,t3.first_name as first_name, t3.last_name as last_name, t3.id as user_id FROM pbg_payment t1 INNER JOIN business t2 ON t1.business_id= t2.id INNER JOIN users t3 ON t2.business_owner_id = t3.id WHERE t1.to_id=$zoneid and t1.status= 's'";
		$query=$this->db->query($sql);
		$result=$query->result_array(); 
		$arr=(!empty($result)) ? $result : '';
		return $arr;
	}
	
	public function get_ordered_sponsor_business_sort_category($zone_id, $cat_id){
		$Common = new CommonController();
		// $sql="SELECT * , business.* FROM business_sponsor_order INNER JOIN business ON business_sponsor_order.business_id=business.id left JOIN business_sponsor_order_subcat ON business_sponsor_order_subcat.bussiness_id=business.id right JOIN ads ON ads.business_id=business.id left JOIN ad_category_subcategory ON ad_category_subcategory.adid=ads.id left JOIN business_sponsor ON business_sponsor.business_id=business_sponsor_order.business_id WHERE business_sponsor.zone_id=".$zone_id." and ad_category_subcategory.subcatid=".$cat_id." GROUP BY business.id   ORDER BY business_sponsor_order_subcat.order_id ASC  ";

		$sql="SELECT * , business.* FROM business_sponsor_order 

		INNER JOIN business ON business_sponsor_order.business_id=business.id 

		left JOIN business_sponsor_order_subcat ON business_sponsor_order_subcat.bussiness_id=business.id 

		right JOIN ads ON ads.business_id=business.id 
		INNER JOIN business_sponsor_order_cat ON business_sponsor_order_cat.adid=ads.id 

		left JOIN business_sponsor ON business_sponsor.business_id=business_sponsor_order.business_id 

		WHERE business_sponsor.zone_id=".$zone_id." and business_sponsor_order_cat.subcatid=".$cat_id." GROUP BY business.id   ORDER BY business_sponsor_order_cat.display_order ASC  ";
		return $Common->SelectRawquery($sql);
	}

	public function sort_business_data($data){
 		$substring=rtrim($data['order'],',');
		$array_data=explode(',',$substring);
		$substring_add=rtrim($data['adid'],',');
		$array_data_add=explode(',',$substring_add);
		$j=1;
		$result="";
		for($i=0;$i<count($array_data);$i++){
 			$sql="select count(*) as counted from business_sponsor_order_subcat WHERE bussiness_id=".$array_data[$i]." and  subcat_id=".$data['catid'];
			$result1=$this->db->query($sql);
	 		$resulted_array = $result1->result_array();
			if( $resulted_array[0]['counted'] == 0){
				$sql="INSERT INTO business_sponsor_order_subcat(subcat_id,bussiness_id,order_id,add_id)VALUES(".$data['catid'].",".$array_data[$i].",".$j.",".$array_data_add[$i].")";
				$result=$this->db->query($sql);
			}else{
				$sql="UPDATE business_sponsor_order_subcat SET order_id=".$j." WHERE bussiness_id=".$array_data[$i];
				$result=$this->db->query($sql);
			}
			$j++;
		}
		return $result;
	}
	
	public function sort_restaurant_data($data){
 		$substring=rtrim($data['order'],',');
		$array_data=explode(',',$substring);
		$j=1;$result="";
		for($i=0;$i<count($array_data);$i++){
			$sql="UPDATE  restaurantbooking_restaurant_basic_info SET sort_order=".$j." WHERE id=".$array_data[$i];
			$result=$this->db->query($sql);
			$j++;
		}
 		return $result;
 	}

 	public function zone_details($zoneid){
 		$this->db->where('id', $zoneid);
		$this->db->select('id,name as zone_name');
		$this->db->from('sales_zone');
		$query = $this->db->get();
		$result=$query->result_array();
		$arr=(!empty($result[0])) ? $result[0] : 0;
		return $arr;
	}	
	
	public function global_bus_search($zone_id=0,$search_value=''){
		$where=' AND ( a.name LIKE "%'.$search_value.'%"';
		$where.=' OR b.phone = "'.$search_value.'"';
		$where.=' OR b.phone_int = "'.$search_value.'"';
		$where.=' OR a.id = "'.$search_value.'")';
		$sql="select a.id,a.name,a.contactfullname,CONCAT(a.contactfirstname,' ',a.contactlastname) as usercontactfullname,b.phone,c.settingszoneid,c.approval from business a,address b,ads_setting_preferences c,users d where a.addressid=b.id and a.id=c.businessid and a.business_owner_id=d.id and c.settingszoneid=".$zone_id."".$where;
		if($zone_id == 0){
			$sql="select a.id,a.name,a.contactfullname,CONCAT(a.contactfirstname,' ',a.contactlastname) as usercontactfullname,b.phone,c.settingszoneid,c.approval from business a,address b,ads_setting_preferences c,users d where a.addressid=b.id and a.id=c.businessid and a.business_owner_id=d.id ".$where;
		}
		$query=$this->db->query($sql);
		$result=$query->result_array();
		$arr=(!empty($result)) ? $result : '';
		return $arr;
	}
	
	public function categories_for_new_subcategory($zoneid=0,$mode=0){
		if($mode==1){
			$sql="SELECT id,name from category_new where zoneid=".$zoneid." AND child_type= 'n' order by name";
		}else if($mode==2){
			$sql="SELECT id,name from category_new where id!='-99' and zoneid=0 AND child_type= 'n' order by name";
		}
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	public function get_existing_business_owner_for_zone($zoneid=0){
		$sql="select c.id,c.first_name,c.last_name,c.username from ads_setting_preferences a,business b,users c where a.businessid=b.id and b.business_owner_id=c.id and a.approval IN(1,2,-1,-2) and a.settingszoneid=".$zoneid." group by c.id order by c.first_name asc,c.username asc";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	public function save_business_approval($id=0,$zoneid=0,$biz_mode=0,$biz_type=0,$grid=0){ 		
		$Common = new CommonController();
		if($biz_mode==13){
			$data['type']=2;
		}else{
			$data['type']=1;
		}
		
		if($grid==4){
			$data['approval']=$biz_type;
			$data['isverified_businessowner'] = 1;
		}else{
			$data['approval']=0;
			$data['isverified_businessowner'] = 0;
		}		
		
		$data['isdefault'] = 1;
		$data['businessid'] = $id;
		$data['settingszoneid'] = $zoneid;		
		$Common->InsertData('ads_setting_preferences', $data);
		
		return $data;
	}

	public function save_stater_ad_business($busid=false, $zoneid=false, $stater_ad=false, $catid=0, $subcatid=0,$grid=false,$ad_startdatetime=false,$ad_stopdatetime=false,$deliver=0,$miles=0 , $deliveryCharges = 0 ,  $deliveryTime = 0){   
		$Common = new CommonController();                                     
		$data=array();
		$data['deal_description'] = $stater_ad; 
		$data['business_id'] = $busid;                              
		$data['categoryid'] = $catid;                              
		$data['subcategoryid'] = $subcatid;                                
		$data['active'] = 1;                                        
		$data['startdatetime'] = $ad_startdatetime;
		$data['stopdatetime'] = $ad_stopdatetime;
		$data['timestamp'] = time();
		$data['deliver'] = $deliver;	
		$data['estimate_miles'] = $miles;
		$data['delivery_charges'] = $deliveryCharges;
		$data['delivery_time'] = $deliveryTime;
		$adid = $Common->InsertData('ads', $data);
		
		$data1 = array('search_engine_title' => $adid,'deal_title'=>$adid);    
		$Common->updateData('ads',$data1,['id' =>$adid]);
		
		$newdata=array();
		$newdata['adid'] = $adid;
		$newdata['zoneid'] = $zoneid;
		if($grid==4){
			$newdata['approval'] = 1;  
		}else if($grid==5 || $grid==13){   
			$newdata['approval'] = 0;
		}
		$Common->InsertData('ad_to_zone', $newdata);
		return $adid;
	}

	################################################################ Create Business Part start ##########################################################

	

	################################################################ Show Business Details Part Start ####################################################

	// show Temp Business part start

	public function get_temp_businesses_details_in_zone($zoneid=0,$charval='',$lowerlimit=false,$upperlimit=false,$approval=0,$is_default=0){ 

		if($charval=='all'){

			$where_charval=' ';

		}else{ 

			$where_charval=' AND ( b.name LIKE "'.urldecode($charval).'%"';

			$where_charval.=' OR c.phone ="'.urldecode($charval).'"';

			$where_charval.=' OR c.phone_int ="'.urldecode($charval).'")';

		}

		if($lowerlimit!='' && $upperlimit!=''){

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{

			$limit_where="";

		}

		if($is_default!=2){

			$where_isdefault=" and a.isdefault=$is_default";

		}else{

			$where_isdefault="";

		}

		$where_type=" and a.type=1";

		$where_approval=" and a.approval=$approval";

		$where_cat_subcat=" and h.catid='-99' and h.subcatid='-99'";

		$where_group_by=" GROUP BY a.businessid ";

		$where_order_by=" ORDER BY trim(b.name) asc";

		

		$table="ads_setting_preferences a,business b,address c,users d,users_groups e, ads f, ad_to_zone g, ad_category_subcategory h";

		$table_relation="a.businessid=b.id and b.addressid=c.id and b.business_owner_id=d.id and d.id=e.user_id and b.id=f.business_id and f.id=g.adid and f.id=h.adid ";

		$table_relation_1=" and a.settingszoneid=$zoneid";

		$select_value="a.businessid,a.settingszoneid,a.approval,b.id,b.name,b.contactfirstname as first_name,b.contactlastname as last_name,d.username,d.uploaded_business_password,c.phone";

		$sql="select $select_value from $table where $table_relation $table_relation_1 $where_isdefault $where_type $where_cat_subcat $where_approval $where_charval $where_group_by $where_order_by $limit_where";

		$query=$this->db->query($sql);

		//echo $this->db->last_query();

		$result=$query->result_array();

		$i=0;

		foreach($result as $arr) {

			/////// ++ Removed "where catid!='-99' GROUP BY adid" from the below three queries 

			// New ads

				//$sql="select count(b.id) as count_new from ads a, ad_to_zone b,ad_category_subcategory c WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND a.id=c.adid AND b.approval=0 AND c.catid='-99'" ;

				$sql="select count(b.id) as count_new from ads a, ad_to_zone b where a.id=b.adid and b.approval=0 and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid='-99')";

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				//var_dump($result_inner);

				$result[$i]['new'] = $result_inner[0]['count_new'] ;

				// Approved ads

				//$sql="select count(b.id) as count_approved from ads a, ad_to_zone b,ad_category_subcategory c WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND a.id=c.adid AND b.approval=1 AND c.catid='-99'" ;

				$sql="select count(b.id) as count_approved from ads a, ad_to_zone b where a.id=b.adid and b.approval=1 and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid='-99')";

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				$result[$i]['approved'] = $result_inner[0]['count_approved'] ;

				// Unapproved ads

				//$sql="select count(b.id) as count_unapproved from ads a, ad_to_zone b,ad_category_subcategory c WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND a.id=c.adid AND b.approval=-1 AND c.catid='-99'" ;

				$sql="select count(b.id) as count_unapproved from ads a, ad_to_zone b where a.id=b.adid and b.approval='-1' and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid='-99')";

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				$result[$i]['unapproved'] = $result_inner[0]['count_unapproved'] ;

			$i++;

		/////// -- Removed "where catid!='-99' GROUP BY adid" from the below three queries 

		}

		return $result;

	}

	// show Temp Business part end

	// show Non-temp business start

	//public function get_businesses_details($zoneid=0,$charval='',$lowerlimit=0,$upperlimit=0,$business_zone=0,$business_type=0,$business_type_by_category=0){

	public function get_non_temp_business_details_in_zone($zoneid=0,$charval='',$lowerlimit=0,$upperlimit=0,$business_zone=0,$business_type=0,$business_type_by_category=0){	

		if($charval=='all'){

			$where_charval=' ';

		}else{

			$where_charval=' AND ( b.name LIKE "'.urldecode($charval).'%"';

			$where_charval.=' OR c.phone ="'.urldecode($charval).'"';

			$where_charval.=' OR c.phone_int ="'.urldecode($charval).'")';

		}

		/*if($lowerlimit!='' && $upperlimit!=''){

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{

			$limit_where="";

		}*/

		/*if($business_zone==0){

			$where_business_zone=" and a.isdefault=0";

		} else if($business_zone==1){

			$where_business_zone=" and a.isdefault=1";

		}*/ 

		if($business_zone==2){

			$where_business_zone=" and a.isdefault IN(0,1)";

		}

		if($business_type_by_category=='pbntc'){

			$catid=0;

		}else{

			$catid='-99';

		}

		

		if($business_type_by_category=='pbntc' || $business_type_by_category=='tbntc' || $business_type_by_category=='ubntc'){

			$where_cat_subcat=" and h.catid!='-99' and h.subcatid!='-99'";

		}else if($business_type_by_category=='pbtc' || $business_type_by_category=='tbtc'){

			$where_cat_subcat=" and h.catid='-99' and h.subcatid='-99'";

		}

		$where_approval=" and a.approval=$business_type";

		$where_type=" and a.type=1";

		$where_group_by=" GROUP BY a.businessid ";

		$where_order_by=" ORDER BY trim(b.name) asc";

		$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		//var_dump($zoneid); var_dump($charval); var_dump($lowerlimit); var_dump($upperlimit); var_dump($business_zone); var_dump($business_type); var_dump($business_type_by_category); var_dump($catid);

		

		$table="ads_setting_preferences a,business b,address c,users d,users_groups e, ads f, ad_to_zone g, ad_category_subcategory h";

		$table_relation="a.businessid=b.id and b.addressid=c.id and b.business_owner_id=d.id and d.id=e.user_id and b.id=f.business_id and f.id=g.adid and f.id=h.adid ";

		$table_relation_1=" and a.settingszoneid=$zoneid";

		$select_value="a.businessid,a.settingszoneid,a.approval,b.id,b.name,b.contactfirstname as first_name,b.contactlastname as last_name,d.username,c.phone";

		$sql="select $select_value from $table where $table_relation $table_relation_1 $where_type $where_business_zone $where_cat_subcat $where_approval $where_charval $where_group_by $where_order_by $limit_where";

		$query=$this->db->query($sql);

		$result=$query->result_array();

		$i=0;

		foreach($result as $arr) {

			/////// ++ Removed "where catid!='-99' GROUP BY adid" from the below three queries 

				// New ads

				//$sql="select count(b.id) as count_new from ads a, ad_to_zone b,ad_category_subcategory c WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND a.id=c.adid AND b.approval=0 AND c.catid!='-99'" ;

				$sql="select count(b.id) as count_new from ads a, ad_to_zone b where a.id=b.adid and b.approval=0 and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid!='-99')";

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				$result[$i]['new'] = $result_inner[0]['count_new'] ;

				// Approved ads anish

				//$sql="select count(b.id) as count_approved from ads a, ad_to_zone b,ad_category_subcategory c WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND a.id=c.adid AND b.approval=1 AND c.catid!='-99' group by c.adid" ;	

				$sql="select count(b.id) as count_approved from ads a, ad_to_zone b where a.id=b.adid and b.approval=1 and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid!='-99')";

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				$result[$i]['approved'] = $result_inner[0]['count_approved'] ;

				// Unapproved ads

				//$sql="select count(b.id) as count_unapproved from ads a, ad_to_zone b,ad_category_subcategory c WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND a.id=c.adid AND b.approval=-1 AND c.catid!='-99'" ;

				$sql="select count(b.id) as count_unapproved from ads a, ad_to_zone b where a.id=b.adid and b.approval='-1' and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid!='-99')";

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				$result[$i]['unapproved'] = $result_inner[0]['count_unapproved'] ;

			$i++;

		/////// -- Removed "where catid!='-99' GROUP BY adid" from the below three queries

		}

		return $result;

	}

	// show Non-temp business end

	// show Non-temp business start

	//public function get_businesses_details($zoneid=0,$charval='',$lowerlimit=0,$upperlimit=0,$business_zone=0,$business_type=0,$business_type_by_category=0){

	public function get_make_real_offers_business_details_in_zone($zoneid=0,$charval='',$lowerlimit=0,$upperlimit=0,$business_zone=0,$business_type=0,$business_type_by_category=0){	

		if($charval=='all'){

			$where_charval=' ';

		}else{

			$where_charval=' AND ( b.name LIKE "'.urldecode($charval).'%"';

			$where_charval.=' OR c.phone ="'.urldecode($charval).'"';

			$where_charval.=' OR c.phone_int ="'.urldecode($charval).'")';

		}

		if($lowerlimit!='' && $upperlimit!=''){

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{

			$limit_where="";

		}

		/*if($business_zone==0){

			$where_business_zone=" and a.isdefault=0";

		} else if($business_zone==1){

			$where_business_zone=" and a.isdefault=1";

		}*/ 

		if($business_zone==2){

			$where_business_zone=" and a.isdefault IN(0,1)";

		}

		if($business_type_by_category=='pbntc'){

			$catid=0;

		}else{

			$catid='-99';

		}

		

		if($business_type_by_category=='pbntc' || $business_type_by_category=='tbntc' || $business_type_by_category=='ubntc'){

			$where_cat_subcat=" and h.catid!='-99' and h.subcatid!='-99'";

		}else if($business_type_by_category=='pbtc' || $business_type_by_category=='tbtc'){

			$where_cat_subcat=" and h.catid='-99' and h.subcatid='-99'";

		}

		$where_approval=" and a.approval=$business_type";

		$where_type=" and a.type=1";

		$where_group_by=" GROUP BY a.businessid ";

		$where_order_by=" ORDER BY trim(b.name) asc";

		$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		//var_dump($zoneid); var_dump($charval); var_dump($lowerlimit); var_dump($upperlimit); var_dump($business_zone); var_dump($business_type); var_dump($business_type_by_category); var_dump($catid);

		

		$table="ads_setting_preferences a,business b,address c,users d,users_groups e, ads f, ad_to_zone g, ad_category_subcategory h";

		$table_relation="a.businessid=b.id and b.addressid=c.id and b.business_owner_id=d.id and d.id=e.user_id and b.id=f.business_id and f.id=g.adid and f.id=h.adid ";

		$table_relation_1=" and a.settingszoneid=$zoneid";

		$select_value="a.businessid,a.settingszoneid,a.approval,b.id,b.name,b.contactfirstname as first_name,b.contactlastname as last_name,d.username,c.phone";

		$sql="select $select_value from $table where $table_relation $table_relation_1 $where_type $where_business_zone $where_cat_subcat $where_approval $where_charval $where_group_by $where_order_by $limit_where";

		$query=$this->db->query($sql);

		$result=$query->result_array();

		$i=0;

		foreach($result as $arr) {

			// New ads

				//$sql="select count(b.id) as count_new from ads a, ad_to_zone b,ad_category_subcategory c WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND a.id=c.adid AND b.approval=0 AND c.catid!='-99'" ;

				$sql="select count(b.id) as count_new from ads a, ad_to_zone b where a.id=b.adid and b.approval=0 and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid!='-99' GROUP BY adid)";

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				//var_dump($result_inner);

				$result[$i]['new'] = $result_inner[0]['count_new'] ;

				// Approved ads anish

				//$sql="select count(b.id) as count_approved from ads a, ad_to_zone b,ad_category_subcategory c WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND a.id=c.adid AND b.approval=1 AND c.catid!='-99' group by c.adid" ;				

				$sql="select count(b.id) as count_approved from ads a, ad_to_zone b where a.id=b.adid and b.approval=1 and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid!='-99' GROUP BY adid)";

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				$result[$i]['approved'] = $result_inner[0]['count_approved'] ;

				// Unapproved ads

				// $sql="select count(b.id) as count_unapproved from ads a, ad_to_zone b,ad_category_subcategory c WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND a.id=c.adid AND b.approval=-1 AND c.catid!='-99'" ;

				$sql="select count(b.id) as count_unapproved from ads a, ad_to_zone b where a.id=b.adid and b.approval='-1' and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid!='-99' GROUP BY adid)";

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				$result[$i]['unapproved'] = $result_inner[0]['count_unapproved'] ;

			$i++;

		}

		return $result;

	}

	// show Non-temp business end

	// Show Franchisee Business Start

	public function get_franchisee_business_details_in_zone($zoneid=0,$charval='',$lowerlimit=0,$upperlimit=0,$business_zone=0,$business_type=0,$business_type_by_category=0){	

		if($charval=='all'){

			$where_charval=' ';

		}else{

			//$where_charval=' AND ( b.name="'.urldecode($charval).'"';

			$where_charval=' AND ( b.name LIKE "'.urldecode($charval).'%"';

			$where_charval.=' OR c.phone ="'.urldecode($charval).'"';

			$where_charval.=' OR c.phone_int ="'.urldecode($charval).'")';

		}

		if($lowerlimit!='' && $upperlimit!=''){

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{

			$limit_where="";

		}

		if($business_zone==2){

			$where_business_zone=" and a.isdefault IN(0,1)";

		} 

		$where_cat_subcat=" and h.catid=14";

		$where_approval=" and a.approval=$business_type";

		$where_type=" and a.type=2";

		$where_group_by=" GROUP BY a.businessid ";

		$where_order_by=" ORDER BY trim(b.name) asc";

		$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		//var_dump($zoneid); var_dump($charval); var_dump($lowerlimit); var_dump($upperlimit); var_dump($business_zone); var_dump($business_type); var_dump($business_type_by_category); var_dump($catid);

		

		$table="ads_setting_preferences a,business b,address c,users d,users_groups e, ads f, ad_to_zone g, ad_category_subcategory h";

		$table_relation="a.businessid=b.id and b.addressid=c.id and b.business_owner_id=d.id and d.id=e.user_id and b.id=f.business_id and f.id=g.adid and f.id=h.adid ";

		$table_relation_1=" and a.settingszoneid=$zoneid";

		$select_value="a.businessid,a.settingszoneid,a.approval,b.id,b.name,d.last_name,d.first_name,d.username";

		$sql="select $select_value from $table where $table_relation $table_relation_1 $where_type $where_business_zone $where_cat_subcat $where_approval $where_charval $where_group_by $where_order_by $limit_where";

		$query=$this->db->query($sql);

		$result=$query->result_array();

		$i=0;

		foreach($result as $arr) {

			// New ads

				//$sql="select count(b.id) as count_new from ads a, ad_to_zone b WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND b.approval=0" ;

				$sql="select count(b.id) as count_new from ads a, ad_to_zone b where a.id=b.adid and b.approval=0 and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid!='-99')";

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				//var_dump($result_inner);

				$result[$i]['new'] = $result_inner[0]['count_new'] ;

				// Approved ads

				//$sql="select count(b.id) as count_approved from ads a, ad_to_zone b WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND b.approval=1" ;

				$sql="select count(b.id) as count_approved from ads a, ad_to_zone b where a.id=b.adid and b.approval=1 and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid!='-99')";

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				$result[$i]['approved'] = $result_inner[0]['count_approved'] ;

				// Unapproved ads

				//$sql="select count(b.id) as count_unapproved from ads a, ad_to_zone b WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND b.approval=-1" ;

				$sql="select count(b.id) as count_unapproved from ads a, ad_to_zone b where a.id=b.adid and b.approval='-1' and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid!='-99')";

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				$result[$i]['unapproved'] = $result_inner[0]['count_unapproved'] ;

			$i++;

		}

		return $result;

	}

	// Show Franchisee Business End

	

	public function get_new_businesses_details_in_zone($zoneid=0,$lowerlimit=0,$upperlimit=0,$businesszone_select=false,$businesstype_select=false,$normal_business=0){

		$user = $this->ion_auth->user()->row();

		$uid=$user->id;

		if($businesszone_select==5){                  // for franchise business

			$isdefault_query=" and a.type=2";         //database value is type=2

		}

		if($businesszone_select==0){

			//$isdefault=1;

			$isdefault_query=" and a.isdefault=1 and a.type=1";    // a.type is added on 25.3.15 for normal business

		} else if($businesszone_select==1){

			//$isdefault=0;

			$isdefault_query=" and a.isdefault=0";

		} else if($businesszone_select==2){

			$isdefault_query=" and a.isdefault IN(0,1)";

		}else if($businesszone_select==3){

			$isdefault_query=" and a.isdefault IN(0,1) and b.created_by=".$uid;

			$zoneid=-1;

		}

		if($businesszone_select!=2 && $businesstype_select!=3 && $businesstype_select!=5){

			$businesstype_select_query=" and a.approval=".$businesstype_select;

		}else{

			$businesstype_select_query=" and a.approval IN(0,1,-1,2,-2)";

		}

		if($charval=='all'){

			$where='';

		}else{			

			$where_charval=' AND ( b.name="'.urldecode($charval).'"';

			$where_charval.=' OR c.phone ="'.urldecode($charval).'"';

			$where_charval.=' OR c.phone_int ="'.urldecode($charval).'")';

		}

		if($lowerlimit!='' && $upperlimit!=''){

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{

			$limit_where="";

		}

			$sql="select a.businessid,a.approval,a.paymenttype,a.websitevisibility,a.emailvisibility,b.name,b.isverified,c.last_name,c.first_name,c.username from ads_setting_preferences a,business b,users c,address d WHERE a.businessid=b.id AND b.business_owner_id=c.id AND b.addressid=d.id AND a.settingszoneid=".$zoneid."".$businesstype_select_query."".$isdefault_query."".$where." GROUP BY a.businessid ORDER BY trim(b.name) asc ". $limit_where; 			

			$query=$this->db->query($sql);

			$result=$query->result_array();

			//var_dump($result) ;

			$i=0;

			foreach($result as $arr) {

				// New ads

				$sql="select count(b.id) as count_new from ads a, ad_to_zone b WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND b.approval=0" ;

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				//var_dump($result_inner);

				$result[$i]['new'] = $result_inner[0]['count_new'] ;

				// Approved ads

				$sql="select count(b.id) as count_approved from ads a, ad_to_zone b WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND b.approval=1" ;

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				$result[$i]['approved'] = $result_inner[0]['count_approved'] ;

				// Unapproved ads

				$sql="select count(b.id) as count_unapproved from ads a, ad_to_zone b WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND b.approval=-1" ;

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				$result[$i]['unapproved'] = $result_inner[0]['count_unapproved'] ;

				

				$sql="select a.id as adid,a.categoryid,a.subcategoryid from ads a, ad_to_zone b WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zoneid." AND a.id=b.adid AND b.approval IN(0,1,-1)" ;

				$query_inner=$this->db->query($sql);

				$result_inner=$query_inner->result_array();

				if(!empty($result_inner)){

					$result[$i]['categoryid'] = $result_inner[0]['categoryid'] ;

					$result[$i]['subcategoryid'] = $result_inner[0]['subcategoryid'] ;

					$result[$i]['adid'] = $result_inner[0]['adid'] ;

				}else{

					$result[$i]['categoryid'] = '' ;

					$result[$i]['subcategoryid'] = '' ;

					$result[$i]['adid'] = '' ;

				}

				$i++;

			}

		return $result;                              

	}

	

	################################################################ Show Business Details Part End ####################################################

	

	

	// ////////////////////////////////////////////   Change Business Status For New Business start //////////////////////////////////////////////////////

	public function change_business_status_new_business($busid='',$zoneid=0,$status=0,$bustype=0,$business_type = 0){

		$explode_value=explode(',',$busid);

		

		if($business_type==5){

			foreach($explode_value as $bussinessid){

				$data = array('approval' => $status,'isverified_businessowner' =>1);

				$this->db->where('businessid', $bussinessid);

				$this->db->where('settingszoneid', $zoneid);

				$this->db->update('ads_setting_preferences', $data);

				

				$data1['isverified']=1;

				$data1['timestamp']=time();

				$this->db->where('id', $bussinessid);

				$this->db->update('business', $data1);

				

				$sql_ad="SELECT id from ads where business_id=".$bussinessid; 

				$query_sel=$this->db->query($sql_ad);

				$result=$query_sel->result_array();

				if(!empty($result)){

					foreach($result as $result){

					$data2['approval']=1;

					$this->db->where('adid', $result['id']);

					$this->db->where('zoneid', $zoneid);

					$this->db->update('ad_to_zone', $data2);

					//$data3=array('display_zone' => 1 , 'catid'=>14, 'subcatid'=>0);

					//$this->db->update('ad_category_subcategory', $data3);

					}

				}

			}

		}else{

			foreach($explode_value as $bussinessid){

				$data = array('approval' => $status,'isverified_businessowner' =>1);

				$this->db->where('businessid', $bussinessid);

				$this->db->where('settingszoneid', $zoneid);

				$this->db->update('ads_setting_preferences', $data);

				

				$data1['isverified']=1;

				$data1['timestamp']=time();

				$this->db->where('id', $bussinessid);

				$this->db->update('business', $data1);

				

				$sql_ad="SELECT id from ads where business_id=".$bussinessid; 

				$query_sel=$this->db->query($sql_ad);

				$result=$query_sel->result_array();

				if(!empty($result)){

					foreach($result as $result){

					$data2['approval']=1;

					$this->db->where('adid', $result['id']);

					$this->db->where('zoneid', $zoneid);

					$this->db->update('ad_to_zone', $data2);

					$data3=array('display_zone' => 1);

					$this->db->update('ad_category_subcategory', $data3);

					}

				}

			}

		}

	}


	

	public function change_ads_status_in_zone($busid='',$zoneid=0,$status=0,$statusnote=''){ //var_dump(11);exit;
 
	    $explode_value=explode(',',$busid);

		$explode_value_bus=explode(',',$busid); //var_dump($explode_value); //exit;

		$explode_value_zone=explode(',',$zoneid);


	 	$sql_bus="SELECT id from ads where business_id IN (".$busid.")  "; 

	    $query_bus=$this->db->query($sql_bus);
	    $result=$query_bus->result_array();
	    $arr = array_column($result,"id");

       // setting status of advertisements to active or inactive
        $approval = ' ';

        if($status=='-1' || $status=='-2' || $status=='-3'){

			$approval = '-1'; 
		}else{

			$approval  ='1';

		}	


         $sql_bus1="Update ad_to_zone SET  approval = ".$approval." where zoneid = ".$zoneid." and adid IN (".implode(',' ,$arr).")  "; 

	    $query_bus1=$this->db->query($sql_bus1);
	  
  
		$data1['isverified']=1;

		$data1['timestamp']=time();

		$data1['Message']='Updated';



	 
	}

	// ////////////////////////////////////////////   Change Business Status For New Business end //////////////////////////////////////////////////////

	// ////////////////////////////////////////////   Change Business Status   start //////////////////////////////////////////////////////

	public function change_business_status_in_zone($busid='',$zoneid=0,$status=0,$statusnote=''){ //var_dump(11);exit;

	/*var_dump($status); var_dump($business_delete_all_or_specific); var_dump($business_type); var_dump($business_type_by_category); var_dump($business_zone); exit;*/

		//var_dump($busid); var_dump($zoneid); var_dump($status); exit;

		$explode_value=explode(',',$busid); //var_dump($explode_value); //exit;

		foreach($explode_value as $bussinessid){				

			$sql_bus="SELECT approval from ads_setting_preferences where businessid=".$bussinessid." and settingszoneid=".$zoneid; 

			$query_bus=$this->db->query($sql_bus);

			$result_bus=$query_bus->result_array(); //var_dump($result); exit; 

			if(!empty($result_bus)){

				$business_approval = $result_bus[0]['approval'];

			}else{

				$business_approval = '';

			}

			if($business_approval == 3){

				$sql_ad="SELECT id from ads where business_id=".$bussinessid; 

				$query_sel=$this->db->query($sql_ad);

				$result=$query_sel->result_array(); //var_dump($result); exit; 

				//if(!empty($result)){

					//change_business_status,business_type_by_category

					/*foreach($result as $x){

						$this->db->where('adid',$x['id']); 

						$this->db->where('zoneid',$zoneid);																																																																					        				$this->db->delete('ad_category_subcategory');

						$this->db->where('adid', $x['id']);

						$this->db->where('zoneid',$zoneid);

						$this->db->delete('ad_to_zone');

						$this->db->where('id',$allads); 

						$this->db->delete('ads');						

					}*/

					// When  BCS convert to Free trial then Peekaboo Account will be created - 16.09.2015 (Tamal) 	

				   /* $peekaboo_account_sql = "SELECT a.*,b.name,c.street_address_1,c.street_address_2,c.city,c.state, c.zip_code,c.phone from users a, business b, address c where a.id=b.business_owner_id and b.id='$bussinessid' and b.addressid=c.id  ";  

					$peekaboo_account = $this->db->query($peekaboo_account_sql);

					$create_peekaboo_account = $peekaboo_account->result_array();

					

					$peekaboo_contactfirstname =  !empty($create_peekaboo_account['0']['first_name']) ? $create_peekaboo_account['0']['first_name'] : '';

				    $peekaboo_contactlastname  =  !empty($create_peekaboo_account['0']['last_name']) ? $create_peekaboo_account['0']['last_name'] : '';

					$peekaboo_contactemail     =  !empty($create_peekaboo_account['0']['email']) ? $create_peekaboo_account['0']['email'] : '';

					$peekaboo_street_address_1 =  !empty($create_peekaboo_account['0']['street_address_1']) ? $create_peekaboo_account['0']['street_address_1'] : '';

					$peekaboo_street_address_2 =  !empty($create_peekaboo_account['0']['street_address_2']) ? $create_peekaboo_account['0']['street_address_2'] : '';

					$peekaboo_business_name    =  !empty($create_peekaboo_account['0']['name']) ? $create_peekaboo_account['0']['name'] : '';

					$peekaboo_zip_code =  !empty($create_peekaboo_account['0']['zip_code']) ? $create_peekaboo_account['0']['zip_code'] : '';

					$peekaboo_state =  !empty($create_peekaboo_account['0']['state']) ? $create_peekaboo_account['0']['state'] : '';

					$peekaboo_city =  !empty($create_peekaboo_account['0']['city']) ? $create_peekaboo_account['0']['city'] : '';

					$peekaboo_phone =  !empty($create_peekaboo_account['0']['phone']) ? $create_peekaboo_account['0']['phone'] : '';

					$peekaboo_username =  !empty($create_peekaboo_account['0']['username']) ? $create_peekaboo_account['0']['username'] : '';

					//$peekaboo_password =  !empty($create_peekaboo_account['0']['password']) ? $create_peekaboo_account['0']['password'] : '';

					$peekaboo_password = 'changepassword';

					

					$data_peekaboo=array(

							 'fName'=>$peekaboo_contactfirstname,

							 'lName'=>$peekaboo_contactlastname,

							 'email'=>$peekaboo_contactemail,

							 'address1'=>$peekaboo_street_address_1,

							 'address2'=>$peekaboo_street_address_2,

							 'company_name'=>$peekaboo_business_name,

							 'city_name'=>$peekaboo_city,

							 'state_name'=>$peekaboo_state,

							 'post_code'=>$peekaboo_zip_code,

							 'phone'=>$peekaboo_phone,

							 'user_name'=>$peekaboo_username,

							 'password'=>sha1($peekaboo_password),

							 'activated'=>'yes',

							 'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),

							 'member_type'=>2

						);	

						

					$this->db->insert('tbl_member', $data_peekaboo);

       		        $peekaboo_id = $this->db->insert_id();	*/

					//}

			}else{

				$sql_ad="SELECT id from ads where business_id=".$bussinessid; 

				$query_sel=$this->db->query($sql_ad);

				$result=$query_sel->result_array(); //var_dump($result); exit; 

				if(!empty($result)){

					//change_business_status,business_type_by_category

					foreach($result as $x){

						if($status=='-1' || $status=='-2' || $status=='-3'){

							$data2=array('approval' => '-1');//['approval']='-1';

							$data3=array('display_zone' => 0);

						}else{

							$data2=array('approval' => '1');

							$data3=array('display_zone' => 1);

						}

						

						$this->db->where('adid', $x['id']);

						$this->db->where('zoneid', $zoneid);

						$this->db->update('ad_to_zone', $data2);

						//echo $this->db->last_query();

						$this->db->update('ad_category_subcategory', $data3);

					}

				}

			}

			if($status == 1){

				$status_data = array(

				   'businessid' => $bussinessid ,

				   'zoneid' => $zoneid ,

				   'note' => $statusnote,

				   'status_from' => $business_approval,

				   'status_to' => $status,

				   'timestamp' => time() 

				);

				$this->db->insert('business_status_change', $status_data); 

			}

			$data = array('approval' => $status,'isverified_businessowner' =>1, 'statuschangingtimestamp' => time());

			$this->db->where('businessid', $bussinessid);

			$this->db->where('settingszoneid', $zoneid);

			$this->db->update('ads_setting_preferences', $data);

			 

			$data1['isverified']=1;

			$data1['timestamp']=time();

			$this->db->where('id', $bussinessid);

			$this->db->update('business', $data1);

			

			

			

			

		}

	}

	// ////////////////////////////////////////////   Change Business Status  end //////////////////////////////////////////////////////

	

	/////////////////////////////////////////////// Edit Business Start //////////////////////////////////////////////////////////////////

	public function business_details_by_id($business_id=0,$zone_id=0){

		$this->db->select('approval');

		$this->db->where('businessid',$business_id);

		$get_approval = $this->db->get('ads_setting_preferences');

		$result_approval = $get_approval->result_array();//var_dump($result_approval);exit;

		$approval = $result_approval[0]['approval'];//var_dump($approval);exit;

		/*if($approval == 1 || $approval == -1){

		//$sql="SELECT a.id as adsettingid,a.isdefault,a.approval,b.id as businessid,b.name,b.contactemail,b.contactfirstname,b.contactlastname,b.website,b.motto,b.siccode,b.business_owner_id as userid,c.id as addressid,c.street_address_1,c.street_address_2,c.city,c.state,c.phone,d.username,d.password,e.note,e.status_from,e.status_to,uploaded_business_password FROM ads_setting_preferences a, business b ,address c, users d,business_status_change e WHERE a.businessid=b.id and b.addressid=c.id and b.business_owner_id=d.id and a.businessid=e.businessid and e.timestamp=(select MAX(timestamp) FROM business_status_change WHERE businessid=$business_id) and a.settingszoneid=".$zone_id." and a.businessid=".$business_id; 

		    $sql="SELECT a.id as adsettingid,a.isdefault,a.approval,b.id as businessid,b.name,b.contactemail,b.contactfirstname,b.contactlastname,b.website,b.motto,b.siccode,b.business_owner_id as userid,c.id as addressid,c.street_address_1,c.street_address_2,c.city,c.state,c.phone,d.username,d.password,uploaded_business_password FROM ads_setting_preferences a, business b ,address c, users d WHERE a.businessid=b.id and b.addressid=c.id and b.business_owner_id=d.id and a.settingszoneid=".$zone_id." and a.businessid=".$business_id; 

		}else{

			$sql="SELECT a.id as adsettingid,a.isdefault,a.approval,b.id as businessid,b.name,b.contactemail,b.contactfirstname,b.contactlastname,b.website,b.motto,b.siccode,b.business_owner_id as userid,c.id as addressid,c.street_address_1,c.street_address_2,c.city,c.state,c.phone,d.username,d.password FROM ads_setting_preferences a, business b ,address c, users d,business_status_change e WHERE a.businessid=b.id and b.addressid=c.id and b.business_owner_id=d.id and a.settingszoneid=".$zone_id." and a.businessid=".$business_id;

		}//echo $sql;exit;*/

		$sql="SELECT a.id as adsettingid,a.isdefault,a.approval,b.id as businessid,b.name,b.contactemail,b.contactfirstname,b.contactlastname,b.website,b.motto,b.aboutus,b.siccode,b.business_owner_id as userid,b.type as restaurant_type,c.id as addressid,c.street_address_1,c.street_address_2,c.city,c.state,c.zip_code,c.phone,d.username,d.password FROM ads_setting_preferences a, business b ,address c, users d,business_status_change e WHERE a.businessid=b.id and b.addressid=c.id and b.business_owner_id=d.id and a.settingszoneid=".$zone_id." and a.businessid=".$business_id; 

		$query=$this->db->query($sql);

		$result=$query->result_array();

		$arr=(!empty($result[0])) ? $result[0] : 0; 

		return $arr;

	}

	/////////////////////////////////////////////// Edit Business End //////////////////////////////////////////////////////////////////





# + This to get the approval of the business from the ad_settings_preference

	public function get_approval_of_businesses($businessid){ 
		$Common = new CommonController();
		$sql = "SELECT approval FROM ads_setting_preferences WHERE businessid=$businessid LIMIT 1"; 
		$row   = $Common->SelectRawquery($sql,'rowArray');
		return $row;
	}

# - This to get the approval of the business from the ad_settings_preference	



# + For Advertisement part start 

public function business_name_for_display_ads($zoneid,$approval,$bustype){

	$this->load->model('admin/ads_model', 'ads');

	return $this->ads->business_name_for_display_ads($zoneid,$approval,$bustype);

}





#########################################################################################################################################################



												/*Csv uploaded for the Home Sold*/



#########################################################################################################################################################



# + showHomeSold

public function showHomeSold($zone_id = false,$charval=false,$lowerlimit=false,$upperlimit=false){

		//$charval='all';

        if(empty($zone_id)) { return false;}	

		if($lowerlimit!='' && $upperlimit!=''){

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{

			$limit_where="";

		}

		if($charval=='all'){

			$where='';

		}else{

			$where=' AND streetnumber LIKE "'.urldecode($charval).'%"';

		}

		if($type==""){

			$type='';

		}else{

			$type = ' AND approval="'.$type.'"';

		}

		$where_orderby=" ORDER BY id ASC";

		

		$query = $this->db->query("SELECT * FROM tbl_savingstore_home_sold WHERE zoneid=".$zone_id." ".$where." ".$where_orderby."".$limit_where." ");

		$result = $query->result_array();

		

		/*$i=0;

		foreach($result as $arr) {

			//Contact Information			-----> Added on 19/8/14 to get the Contact Details for the Contact Details Column.

			$contact_details = "SELECT first_name,last_name,email,phone FROM users WHERE id=".$arr['userid'];

			$query = $this->db->query($contact_details);

			$result_contact_details = $query->result_array(); 

			$result[$i]['first_name'] = $result_contact_details[0]['first_name'];

			$result[$i]['last_name'] =	$result_contact_details[0]['last_name'];	

			$result[$i]['email'] =	$result_contact_details[0]['email'];

			$result[$i]['phone'] =	$result_contact_details[0]['phone'];

			$i++;

		}*/

		return $result;

    } 

	

public function update_password($business_owner_id)	

		{

		 $sql="update users set password='a15a7c9e5af0737f1f3f22cf1043518ebd1213a6' , uploaded_business_password='changepassword' where id=".$business_owner_id;	

		 $this->db->query($sql);	

		}

	

# - showHomeSold







/**********************************************************************************************************************************************



											*********Zone_Model endds here********



**********************************************************************************************************************************************/

public function get_all_webinars($zoneid=0){ //var_dump($bus_search_results);exit;	//var_dump($paymentstatus);var_dump($activestatus);exit;

		
 

	  $sql="Select webinar_information.* ,  wb_webinar_user.username ,  wb_webinar_user.role   from webinar_information  inner join wb_webinar_user  on wb_webinar_user.id = webinar_information.created_by_userid  where  webinar_information.zoneid=".$zoneid; //exit;

	$query=$this->db->query($sql);

	$result=$query->result_array();

 
    return $result;
	 

}



public function get_all_business_deals_in_zone($zoneid=0,$charval='',$lowerlimit=0,$upperlimit=0,$business_zone=0,$typeofbusinesses='',$typeofadds='',$paymentstatus='',$activestatus='',$businessmode='',$bus_search_results='',$all_zone_business=''){ 

	    $sql="select DISTINCT tp.id  , tp.*  ,  tp.id as purchaseid , b.* ,  users.*  , bus.name  as businessname  , d. * , ct.cat_name as categoryname  from  tbl_member a, users  users  , tbl_deals b, ads c, tbl_deals_products d , tbl_deals_purchased tp  , business bus  , tbl_category ct  where  ct.cat_id=d.cat_id and   bus.id = tp.busId and   a.user_name = users.username and tp.dealId = b.product_id and  a.user_id=b.user_id    and  b.product_id=d.deal_product_id and tp.zoneid = ".$zoneid;
		$query=$this->db->query($sql);
		$result=$query->result_array();
		$result=(!empty($result)) ? $result : '';
	
		return $result;
 

}


public function get_all_business_auctions_in_zone($zoneid=0, $fromzoneid=0,$userd=0){

	     $sql="Select distinct transaction_info.invoice , business.id as business_id ,  transaction_info.pay_time , business.name as business_name , tbl_auction.* ,tbl_auction.auc_id ,  tbl_auction.deal_title as auc_name  , tbl_auction.start_date  ,  tbl_auction.end_date , tbl_auction.buy_price_decrease_by , tbl_auction.current_price , tbl_member.user_name as buyer_name ,  tbl_member.address1 as buyer_address , tbl_member.city_name as buyer_city , tbl_member.state_name as buyer_state_name , tbl_member.post_code as buyer_post_code ,  tbl_member.email as buyer_email ,  tbl_member.phone as buyer_phone , users.username as seller_name , address.street_address_1 as seller_address , address.city as seller_city , address.zip_code as seller_zip_code , address.phone as seller_phone , business.contactemail as seller_email ,  tbl_inventory_products.publisher_fee  , tbl_inventory_products.seller_fee  from transaction_info  INNER JOIN tbl_auction on transaction_info.auc_id = tbl_auction.auc_id 
INNER JOIN tbl_member on tbl_member.zone_id = tbl_auction.zone_id 
inner JOIN business_sponsor on business_sponsor.zone_id = tbl_auction.zone_id 
inner  JOIN business on business.id = business_sponsor.business_id
inner  JOIN users on users.id = business.business_owner_id
LEFT JOIN address on business.addressid = address.id
LEFT JOIN tbl_inventory_products on tbl_inventory_products.user_id = tbl_auction.user_id
where transaction_info.user_id = ".$userd."  limit 30";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		$result=(!empty($result)) ? $result : '';	
		return $result;


}






 
	



     public function delete_all_business_fromzone($zoneid){

		if($zoneid != ''){

        $zoneid_sql = "SELECT sales_rep_id FROM sales_zone WHERE id='".$zoneid."'";

		$zoneid_query = $this->db->query($zoneid_sql);

		$zoneid_result = $zoneid_query->result_array();

		$zone_userid = $zoneid_result[0]['sales_rep_id'];

		

		$business_sql = "SELECT businessid FROM ads_setting_preferences WHERE settingszoneid = '".$zoneid."' limit 0,500";

		$business_query = $this->db->query($business_sql);

		$business_result = $business_query->result_array();

		$sql_str = '' ;

		if(!empty($business_result)){

			foreach($business_result as $businessid_val){

				$sql_str .= $businessid_val['businessid'].',';

			}

			$allbusinessid_string = substr( $sql_str , 0 , -1 ) ;

			$allbusinessid = explode(',',$allbusinessid_string);

			

			$address_sql = "SELECT a.addressid , a.business_owner_id from business a, ads_setting_preferences b where a.id=b.businessid and a.id IN(".$allbusinessid_string.") and  b.settingszoneid IN(".$zoneid.") AND a.business_owner_id NOT IN(".$zone_userid.")";

			

			$address_query = $this->db->query($address_sql);

			$address_result = $address_query->result_array();//var_dump($address_result);exit;

			foreach($address_result as $address_val){

				$owner_id .= $address_val['business_owner_id'].',';

				$addrid .= $address_val['addressid'].',';

			}

			$businessownerid_string = substr( $owner_id , 0 , -1 );

			$businessownerid = explode(',',$businessownerid_string); //var_dump($businessownerid);exit;

			

			$addressid_string = substr( $addrid , 0 , -1 );//var_dump($addressid);exit;

			$addressid = explode(',',$addressid_string) ;

			if($businessownerid_string != ''){

				$ads_sql = "SELECT id FROM ads WHERE business_id IN(".$allbusinessid_string.")";

				$ads_query = $this->db->query($ads_sql);

				$ads_result = $ads_query->result_array();//var_dump($ads_result);exit;

				foreach($ads_result as $ads_val){

					$all_adid .= $ads_val['id'].',';

				}

				$allads_string = substr( $all_adid , 0 , -1 );

				$allads = explode(',',$allads_string) ; //var_dump($allads);

				

				if(!empty($allads)){  

					// Delete ad_to_zone

					foreach($allads as $allads){//var_dump($zoneid);exit;

						$this->db->where_in('adid',$allads);

						$this->db->delete('ad_to_zone');

						

						// Delete users_favorites

							

						$this->db->where_in('adid',$allads); 

						$this->db->delete('users_favorites');

						

						// Delete ads

			

						$this->db->where_in('id',$allads); 

						$this->db->delete('ads');

						

						// Delete ad_category_subcategory

												

						$this->db->where_in('adid',$allads); 

						$this->db->where('zoneid',$zoneid);																																																																					        				$this->db->delete('ad_category_subcategory');

					}

				}

			}

			// Delete users_groups

			foreach($businessownerid as $businessownerid){

				$this->db->where_in('user_id',$businessownerid); 

				$this->db->delete('users_groups');

				

				// Delete users

		

				$this->db->where_in('id',$businessownerid); 

				$this->db->delete('users');

			}

			

			// Delete address

             foreach($addressid as $addressid){

			$this->db->where_in('id',$addressid); 

			$this->db->delete('address');

			 }

			

			// Delete business_photos

            foreach($allbusinessid as $allbusinessid){

				$this->db->where_in('bus_id',$allbusinessid); 

				$this->db->delete('business_photos');

				

				// Delete businessphotos_display

	

				$this->db->where_in('bus_id',$allbusinessid); 

				$this->db->delete('businessphotos_display');

				

				// Delete business_operation_hour

										

				$this->db->where_in('business_id',$allbusinessid); 

				$this->db->where('zone_id',$zoneid);																																																																					        		$this->db->delete('business_operation_hour');//delete category

				

				// Delete business

	

				$this->db->where_in('id',$allbusinessid); 

				$this->db->delete('business');

				

				// Delete ads_setting_preferences

	

				$this->db->where_in('businessid',$allbusinessid); 

				$this->db->delete('ads_setting_preferences');

			}

			

			$business_sql_check = "SELECT businessid FROM ads_setting_preferences WHERE settingszoneid = '".$zoneid."'";

			$business_query_check = $this->db->query($business_sql_check);

			//var_dump($business_query_check->num_rows());

			if(($business_query_check->num_rows() > 0)){

				return "delete";

			}else{

				return "success";

			}

		  }

		}

    }

	

   /** 

   * FREE TRIAL BUSINESS EXPIRATION IN A ZONE WISE

   */

	public function get_all_trialbusiness_expiration_in_zone($zoneid=0,$charval=0,$lowerlimit=0,$upperlimit=0){	

		// FREE TRIAL BUSINESS

		$where_charval = ' ';

		$business_type = '2,-2';

		// BUSINESS IS ACTIVE OR DEACTIVE

		$where_business_zone=" and a.isdefault IN(0,1)";

		$where_cat_subcat = '';

		$where_approval=" and a.approval IN(".$business_type.")";	// PAID or TRIAL or UPLOADED (active or deactive)

		// WHETHER NORMAL BUSINESS OR BUSINESS OPPORTUNITY PROVIDERS

		$where_type=" and a.type IN(1)";

		$where_group_by=" GROUP BY a.businessid ";

		$where_order_by=" ORDER BY trim(b.name) asc";

		$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		$table = "ads_setting_preferences a";

		$table.= " INNER JOIN business b ON a.businessid=b.id";

		$table.= " INNER JOIN address c ON b.addressid=c.id";

		$table.= " INNER JOIN users d ON b.business_owner_id=d.id";

		

		$table_relation = "";

		$table_relation_1=" a.settingszoneid=$zoneid";

		

		$select_value="a.businessid,a.settingszoneid,a.approval,b.id,b.name,a.statuschangingtimestamp,b.contactfirstname as first_name,b.contactlastname as last_name,b.trialstarted,d.username,c.phone,c.zip_code";

		

		$sql="select $select_value from $table where $table_relation $table_relation_1 $where_type $where_business_zone $where_cat_subcat $where_approval $where_charval  and a.statuschangingtimestamp!='0' $where_group_by $where_order_by $limit_where";

		$query=$this->db->query($sql);

		$result=$query->result_array();

		return $result;

	}

	

	/**

	* Notification Day count

	*/

	public function notificationday_remains($zoneid){

	  $this->db->select('notification_day');

	  $this->db->where('zoneid', $zoneid); 

	  $this->db->from('zone_preferences');

      $query = $this->db->get();

	  $result=$query->result_array();

	  return $result['0'];

	}

	

	// + Get username for this zone calendar auto loggin purpose

			

	 function get_userid($zoneid){

		 $this->db->select('a.id');

		 $this->db->from('users as a');

		 $this->db->join('sales_zone b','a.id=b.sales_rep_id');

		 $this->db->where('b.id',$zoneid);

		 $query = $this->db->get();

		 $result = $query->result_array();

		 $last_login = date("Y-m-d H:i:s");

	

		 return $result['0']['id'];

	 }		

// + Get username for this zone calendar auto loggin purpose

	 public function get_all_sponsored_business_information($zone_id) {
		$sql="SELECT * FROM business_sponsor INNER JOIN business ON business_sponsor.business_id=business.id INNER JOIN address ON business.addressid=address.id WHERE business_sponsor.zone_id=".$zone_id;
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	 public function get_ordered_sponsor_business($zone_id){
      
     $Common = new CommonController();
	 $sql="SELECT * FROM business_sponsor_order INNER JOIN business ON business_sponsor_order.business_id=business.id INNER JOIN business_sponsor ON business_sponsor.business_id=business_sponsor_order.business_id WHERE business_sponsor.zone_id=".$zone_id." ORDER BY business_sponsor_order.display_order ASC"; 
	return $query =  $Common->SelectRawquery($sql,'resultArray');	
 

	 }

	 public function update_sponsored_business_status($business_id,$update_status){ 

	 	$update_status=(int)$update_status;

	 	if($update_status ==1){

	 		$sql="UPDATE business_sponsor SET status=".$update_status." WHERE business_id=".$business_id;

	 		$result1=$this->db->query($sql);

	 		if($result1){

	 		$sql1="SELECT MAX(display_order) AS max_display_order FROM business_sponsor_order";

	 		$query=$this->db->query($sql1);

	 		$result=$query->result();

	 		if($result){

	 			$maximum_display_order=(int)$result['max_display_order'];

	 			$maximum_display_order=$maximum_display_order+1;

	 		} else{

	 			$maximum_display_order=1;

	 		}

	 		$sql2="INSERT INTO business_sponsor_order(business_id,display_order) VALUES(".$business_id.",".$maximum_display_order.")";

		 	$result2=$this->db->query($sql2);

		 	if($result2){

		 		return "activated";

		 	}

		 }

		 	//return "a";

	 	}

	 	else if($update_status==0){

	 		$sql="UPDATE business_sponsor SET status=".$update_status." WHERE business_id=".$business_id;

		 	$result=$this->db->query($sql);

		 	$sql1="DELETE FROM business_sponsor_order WHERE business_id=".$business_id;

		 	$result1=$this->db->query($sql1);

		 	if($result1){

		 		return "deactivated";

		 	}

	 	} else if($update_status ==2){

	 		$sql="UPDATE business_sponsor SET status=".$update_status." WHERE business_id=".$business_id;

		 	$result=$this->db->query($sql);

		 	$sql1="DELETE FROM business_sponsor_order WHERE business_id=".$business_id;

		 	$result1=$this->db->query($sql1);

		 	if($result1){

		 		return "decliened";

		 	}



	 	}

	 	//return $business_id;

	 	

	 }



// Getting list of all snap dining restaurant by zone id
     public function getallsnapdingbusiness($zoneId){
  
 


          $sqlRestaurantDetails = "SELECT

                                    bus.name as buss_name, 

                                  	b.id AS userId, 
                                   
									a.business_id AS businessId,

									a.zone_id AS zoneId,

									b.id AS userId ,

									c.restaurant_name,
									
									c.id as res_id,

									c.sort_order
                                 FROM 

									restaurantbooking_food_offered_type a

								INNER  JOIN

									restaurantbooking_users b

								INNER JOIN

									restaurantbooking_restaurant_basic_info c

								INNER JOIN

									restaurantbooking_business_snap_offered d

							    INNER JOIN

									business bus 

							 
								ON (a.business_id = b.business_id AND a.zone_id = b.zone_id AND a.business_id = c.business_id AND a.business_id = d.business_id  AND a.business_id = bus.id ) 

								WHERE

								a.zone_id = ".$zoneId."

								GROUP BY a.business_id ORDER BY c.sort_order ASC";
								 
                        $queryRestaurantDetails = $this->db->query($sqlRestaurantDetails);
	                    return  $queryRestaurantDetails->result_array();

 
 

     }
	
	public function rearrange_business_data($data){
		$Common = new CommonController();
		$substring=rtrim($data,',');
		$array_data=explode(',',$substring);
		$j=1;
		$result="";
		for($i=0;$i<count($array_data);$i++){
			$data1 = array('display_order' => $j);    
		   	$Common->updateData('business_sponsor_order',$data1,['business_id' =>$array_data[$i]]);
		   	$j++;
		}
		return $result;
	}

	public function rearrange_business_data_cat($data,$zone_id,$subcat){
		$Common = new CommonController();
		$substring=rtrim($data,',');
		$array_data=explode(',',$substring);
		$j=1;
		$result="";
		for($i=0;$i<count($array_data);$i++){
			$data1 = array('display_order' => $j);    
		   	$Common->updateData('business_sponsor_order_cat',$data1,['adid' =>$array_data[$i],'subcatid'=>$subcat,'zoneid'=>$zone_id]);
		   	$j++;
		}
		return $result;
	}

	 /** function to fetch zone category

	   * @param zone id integer

	   * return array 

	 */

	 public function fetch_jotform_zonecategory($zoneid){

	 	$data                                 = array();

	 	$sql                                  = "SELECT * FROM payment_module WHERE receiver_type='zone'";

	 	$query                                = $this->db->query($sql);

	 	$data['category']                     = $query->result_array();

	 	$fetch_form_category_query            = "SELECT 

	 												a.code_id, 

	 												a.code, 

	 												a.payment_module_receiver_id AS zone_id,

	 												b.id AS payment_module_id,

	 												b.value AS payment_form_type,

	 												b.receiver_type,

	 												b.payer_type

 												FROM 

 													payment_module AS b

												LEFT JOIN 

 													jot_form_embed_code AS a 

													ON a.payment_module_id=b.id AND a.payment_module_receiver_id=".$zoneid."

												WHERE 

													b.receiver_type = 'zone'";

	 	$fetch_form_category_query_result     = $this->db->query($fetch_form_category_query);

	

	 	$codes['form_codes']                   = $fetch_form_category_query_result->result_array();

	 	$data['form_codes'] ="";

	 	if(count($codes['form_codes']) > 0){

	 	foreach ($codes['form_codes'] as $value) {

	 		$type_id = $value['payment_module_id'];

	 		$data['form_codes'][$type_id] = $value;	

	 	}

	 }

	 	return $data;

	 }

	 public function update_jotformcode_data($form_type_id,$codes,$zone_id){
	 	$Common = new CommonController();
		$zone_id = (int)$zone_id;
		$form_type_id=(int)$form_type_id;
		$codes = addslashes($codes);
		
		$sql = "SELECT * FROM jot_form_embed_code WHERE payment_module_id=".$form_type_id." AND payment_module_receiver_id=".$zone_id;
		$row = $Common->SelectRawquery($sql,'count');
		if($row > 0){
			$update_result = $Common->updateData('jot_form_embed_code',['code' => $codes],['payment_module_id'=>$form_type_id,'payment_module_receiver_id'=>$zone_id]);
			$code_result=$update_result;
		}else{
			$data = array(
				'code'=>$codes,
				'payment_module_id'=>$form_type_id,
				'payment_module_receiver_id'=>$zone_id
			);
			$inserted_query = $Common->InsertData('jot_form_embed_code', $data);	
			$code_result = $inserted_query;	
		}
		return $code_result;
	}

	 public function get_payment_details($zone_id){

	 	$sql =   "SELECT 

	 				  a.payer_id,

	 				  a.amount,

	 				  a.submission_id,

	 				  a.form_id,

	 				  a.time AS payment_creation_time,

	 				  b.name AS business_name,

	 				  c.value AS payment_purpose

	 			   FROM

	 			   	  payment AS a

	 			   INNER JOIN business AS b

	 			   		ON a.payer_id=b.id

	 			   INNER JOIN payment_module AS c

	 			   		ON a.payment_module = c.id

	 			   WHERE a.receiver_id=".$zone_id."

	 			   ORDER BY a.time ASC";

	   $query = $this->db->query($sql);

	   return $query->result_array();

				 

	 }

	 public function zone_payment_business($zone_id){

	 	$sql =   "SELECT

	 				   a.id,

	 				   a.payer_id,

	 				   a.amount,

	 				   a.auction_details,

	 				   a.time AS payment_creation_time,

	 				   b.status,

	 				   c.buy_price_decrease_by

	 			 FROM 

	 			 	payment AS a

	 			 INNER JOIN business_payment_for_certificate AS b

	 			 		ON a.id=b.payment_id

	 			 INNER JOIN tbl_auction AS c

	 			 		ON a.auction_id=c.auc_id

	 			 WHERE a.payment_module=2

	 			 	AND a.receiver_id=".$zone_id;

	 	$query = $this->db->query($sql);

	 	return $query->result_array();

	 }

	public function get_jotform_code($receiver_id,$payment_module_id){

		$sql = "SELECT 

					code 

				FROM 

					jot_form_embed_code

				WHERE 

					payment_module_id=".$payment_module_id." AND

					payment_module_receiver_id=".$receiver_id;

		$query = $this->db->query($sql);

		$data=$query->result();

		return $data;

	}

	public function business_details_using_id($business_id){

		$sql = "SELECT * FROM business WHERE id=".$business_id;

		$query = $this->db->query($sql);

		return $query->result();



	}

	public function insert_business_certification_payment($data){

		$form_details = json_encode($data);

		extract($data);

		$page_url_array = explode('/',$pageurl);

		$page_url_array_size = count($page_url_array);

		$user_payment_id = $page_url_array[$page_url_array_size-1];

		$payer_id = $page_url_array[$page_url_array_size-4];

		$sql = "INSERT INTO 

						payment(payment_module,receiver_id,payer_id,amount,submission_id,form_id,form_details,time)

						VALUES(4,".$businessid.",".$payer_id.",".$amount[2].",'".$submission_id."','".$formID."','".$form_details."',NOW())";

		$result = $this->db->query($sql);

		$payment_id = $this->db->insert_id();

		$result1 = 0;

		if($payment_id){

		//$payment_id = $this->db->insert_id();

		$business_payment_query = "UPDATE business_payment_for_certificate

								   	SET

								   		status=1,

								   	  	receive_payment_id=".$payment_id."

								   	WHERE payment_id=".$user_payment_id;

		$result1 = $this->db->query($business_payment_query);

		//return $result1;

		}

		$total_result = $result*$result1;

		return $total_result;

	}

	public function get_certificate_selected_organization_list($zone_id){

		$sql = "SELECT 

					a.id AS payment_id,

					a.amount,

					b.organization_id,

					b.status,

					c.name,

					d.buy_price_decrease_by

				FROM

					payment AS a

				INNER JOIN certificate_benificary_organization AS b

					ON a.id=b.payment_id

				INNER JOIN organization AS c

					ON b.organization_id=c.id

				INNER JOIN tbl_auction AS d

					ON a.auction_id=d.auc_id

				WHERE a.payment_module=2 AND a.receiver_id=".$zone_id;

		$query = $this->db->query($sql);

		return $query->result_array();

	}

public function insert_payment($payment_module_id,$receiver_id,$payer_id,$amount,$submission_id,$formid,$auction_details,$auction_id,$form_details){

		$sql ="INSERT INTO 

						payment(payment_module,receiver_id,payer_id,amount,submission_id,form_id,form_details,time)

						VALUES(".$payment_module_id.",".$receiver_id.",".$payer_id.",".$amount.",'".$submission_id."','".$formid."','".$form_details."',NOW())";

		$result =$this->db->query($sql);

		$last_inserted_id = 0;

		if($result){

			$last_inserted_id=$this->db->insert_id();

		}

		return $last_inserted_id;

	}

public function update_certificate_organization($user_payment_id,$zone_payment_to_organization,$organization_id){

	$sql = "UPDATE 

				certificate_benificary_organization

			SET 

				payment_receive_id=".$zone_payment_to_organization.",

				status=1 

			WHERE payment_id=".$user_payment_id."

				AND 

			organization_id=".$organization_id;

	$result = $this->db->query($sql);

	return $result;

}	



	public function get_zone_name($zoneId){



		$sql = "SELECT * FROM `sales_zone` AS `sz` INNER JOIN `users` AS `us` ON `sz`.`sales_rep_id` = `us`.`id` WHERE `sz`.`id`= $zoneId ";

		$query = $this->db->query($sql);

		return $query->result_array();

	}



	public function get_current_credits($zoneId){



		$sql = "SELECT * FROM `zone_owner_credits` WHERE `zone_id` = ".$zoneId;

		$query = $this->db->query($sql);

		return $query->result_array();

	}

	

	public function checkExistPaypalid($zone_id){
		$Common = new CommonController();
		$data = $Common->SelectDataMultiWay('zone_paypal_details','*','resultArray',['zone_id' =>$zone_id],[]);
		if(count($data) > 0){
			return $data;
		}else{
			return 0;
		}
	}
	
	public function save_paypalinfo($paypal_url='',$zone_id=0, $braintree_merchantid='',$braintree_public_key='',$braintree_private_key=''){
		$Common = new CommonController();
		$data=array('paypal_url'=>$paypal_url,'braintree_merchantid'=>$braintree_merchantid , 'braintree_public_key'=>$braintree_public_key , 'braintree_private_key'=>$braintree_private_key , 'zone_id'=>$zone_id);
		$banner_id = $Common->InsertData('zone_paypal_details', $data);
		$return_data=array('zone_id'=>$zone_id);
		return $return_data;
	}
	
	public function update_paypalinfo($paypal_url='',$zone_id=0, $braintree_merchantid='',$braintree_public_key='',$braintree_private_key=''){
		$Common = new CommonController();
		if(!empty($zone_id)){
			$data=array('paypal_url'=>$paypal_url , 'braintree_merchantid'=>$braintree_merchantid , 'braintree_public_key'=>$braintree_public_key , 'braintree_private_key'=>$braintree_private_key);
			return $Common->updateData('zone_paypal_details',$data,['zone_id'=> $zone_id]);
		}
	}



	function update_shorturlinfo($short_url='',$zone_id=0){

		if(!empty($zone_id))

		{

			$data=array('short_url'=>$short_url);

			$this->db->where('id',$zone_id);

			$this->db->update('sales_zone',$data);

		}

		

	}



	function checkExistShortUrl($zone_id)

	{

		$this->db->select('*');

		$this->db->from('sales_zone');

		$this->db->where('id',$zone_id);

		

		$query = $this->db->get();

		

		$num_rows = $query->num_rows();

		if($num_rows > 0)

		{

			$result = $query->row_array();

			

			return $result;

		}

		else{

			return 0;

		}

	}



	public function get_username($zoneid){

		$this->db->select('a.username');

		$this->db->from('users as a');

		$this->db->join('sales_zone b','a.id=b.sales_rep_id');

		$this->db->where('b.id',$zoneid);

		$query = $this->db->get();

		$result = $query->result_array();

		$last_login = date("Y-m-d H:i:s");

   

		return $result['0']['username'];

	}

	public function get_all_business_details_in_zone($zoneid=0,$charval='',$lowerlimit=0,$upperlimit=0,$business_zone=0,$typeofbusinesses='',$typeofadds='',$paymentstatus='',$activestatus='',$businessmode='',$bus_search_results='',$all_zone_business='' , $bus_search_by_cat='', $bus_search_by_subcategory='' ){ 

	if($charval=='all'){
		$where_charval=' ';
 	}else if($bus_search_results == 'contains'){
		$where_charval=' AND ( b.name LIKE "%'.urldecode($charval).'%"';
		$where_charval.=' OR c.phone LIKE "%'.urldecode($charval).'%"';
		$where_charval.=' OR c.phone_int LIKE "%'.urldecode($charval).'%"';
		$where_charval.=' OR b.id LIKE "%'.urldecode($charval).'%")';
	}else if($bus_search_results == 'startwith'){
		$where_charval=' AND ( b.name LIKE "'.urldecode($charval).'%"';
		$where_charval.=' OR c.phone LIKE "'.urldecode($charval).'%"';
		$where_charval.=' OR c.phone_int LIKE "'.urldecode($charval).'%"';
		$where_charval.=' OR b.id LIKE "'.urldecode($charval).'%")';
	}else if($bus_search_results == 'resultbycat'){
		$where_charval =' AND ( b.name LIKE "%'.urldecode($charval).'%"';
		if($bus_search_by_subcategory){
			$where_charval.=' AND  h.subcatid  = '.$bus_search_by_subcategory  ;
		}
		if($bus_search_by_cat){
			$where_charval.=' AND  h.catid  = '.$bus_search_by_cat ;
	    }
		$where_charval.=')';
	}
	
	$business_type = '';
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
	$where_cat_subcat = '';
	$where_approval=" and a.approval IN(".$business_type.")";
	
	if($businessmode == 1){
		$where_type=" a.type IN(1,2)";
	}else if($businessmode == 2){
		$where_type=" a.type IN(2)";
	}
	
	$where_group_by=" GROUP BY a.businessid ";
	$where_order_by=" ORDER BY trim(b.name) asc";
	
	if($upperlimit != 100000000){
		$limit_where=" limit  10 offset ".$lowerlimit;
	}else{
		 $limit_where=" limit ".$lowerlimit.",".$upperlimit;
	}
	
	$table = "ads_setting_preferences a";
	$table.= " INNER JOIN business b ON a.businessid=b.id";
	$table.= " INNER JOIN address c ON b.addressid=c.id";
	$table.= " INNER JOIN users d ON b.business_owner_id=d.id";
	$table.= " INNER JOIN users_groups e ON d.id=e.user_id";
	$table.= " LEFT JOIN ads f ON b.id=f.business_id";
	$table.= " LEFT JOIN ad_to_zone g ON f.id=g.adid";
	$table.= " LEFT JOIN ad_category_subcategory h ON f.id=h.adid";
	
	$table_relation = "";
	if($all_zone_business == 1){
		$table_relation_1 = "";
	}else if($all_zone_business != 1){
		$table_relation_1 = " a.settingszoneid=$zoneid and";
	}		
	
	$select_value="f.id as adsid ,  h.cat_group_id , h.catid , h.subcatid ,  g.approval as adsapproval, a.businessid,a.settingszoneid,a.approval,b.id,b.name,b.contactfirstname as first_name,b.contactlastname as last_name,b.timestamp,b.trialstarted,d.username,c.phone,c.zip_code";

    $sql="select $select_value from $table where $table_relation $table_relation_1 $where_type $where_business_zone $where_cat_subcat $where_approval $where_charval $where_group_by $where_order_by $limit_where"; 

	$query=$this->db->query($sql);
	$result=$query->getResultArray();
	$i=0;

	foreach($result as $arr) {
		$sql="select count(b.id) as count_new from ads a, ad_to_zone b where a.id=b.adid and b.approval=0 and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid!='-99')"; 
		$query_inner=$this->db->query($sql);
		$result_inner=$query_inner->getResultArray();
		$result[$i]['new'] = $result_inner[0]['count_new'] ;
		
		$sql="select count(b.id) as count_approved from ads a, ad_to_zone b where a.id=b.adid and b.approval=1 and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid!='-99')";
		$query_inner=$this->db->query($sql);
		$result_inner=$query_inner->getResultArray();
		$result[$i]['approved'] = $result_inner[0]['count_approved'] ;
		
		$sql="select count(b.id) as count_unapproved from ads a, ad_to_zone b where a.id=b.adid and b.approval='-1' and a.business_id=".$arr['businessid']." and b.zoneid=".$zoneid." AND b.adid IN (SELECT adid from ad_category_subcategory where catid!='-99')";
		$query_inner=$this->db->query($sql);
		$result_inner=$query_inner->getResultArray();
		$result[$i]['unapproved'] = $result_inner[0]['count_unapproved'] ;
		$i++;
	}
	return $result;
}



}











