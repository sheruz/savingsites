<?php
namespace App\Models\admin;

use CodeIgniter\Model;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Business extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }
	
	function subscribe_count($id)
    {
    	$query = $this->db->query("select count(id) as count from business_approved where business_id=".$id);
    	return $query->row()->count;
    }

    public function business_credit($zoneid){
    	$common = new CommonController();
		$sql="SELECT * FROM `sales_zone` WHERE `id` =".$zoneid;
		$r = $common->SelectRawquery($sql,'row');
       	return $r->rate_per_credit;
    }

      function donation_credit($zoneid){

        $sql="SELECT percentage FROM publisher_fee WHERE zone_id=".$zoneid;

       $r = $this->db->query($sql)->row();

       return $r->percentage;


    }

    public function get_business_by_id($id){
    	$common = new CommonController();
       	$sql = "select t1.*,t2.street_address_1, t2.street_address_2, t2.city,t2.state,t2.zip_code,t2.phone,asf.approval from business as t1 left join address as t2 on t1.addressid = t2.id left join ads_setting_preferences as asf ON asf.businessid=t1.id
       		where t1.id = " . $id . " LIMIT 1";			
		$data = $common->SelectRawquery($sql,'row');
		return $data;
	}
	
	/* Getting address detail by business id */	
	public function addressdata($id){
		$common = new CommonController();
		$sql = "SELECT a.*,b.* FROM business a, address b WHERE a.addressid = b.id AND a.id=".$id;
		$result = $common->SelectRawquery($sql,'row');
		return $result;
	}
	/* Getting address detail by business id */	
	
	public function business_owner_zone_owner($id){
		$common = new CommonController();
		$sql = "SELECT c.* FROM business a, users b, sales_zone c WHERE a.business_owner_id = b.id AND b.id = c.sales_rep_id AND a.id=".$id;
		$data = $common->SelectRawquery($sql);
		if(count($data) > 0){
			return 1;
		}else{
			return 0;
		}
	}

	   public function getallbusiness_listing($zoneID=0){
		$sql =  "SELECT  business.*  FROM ads_setting_preferences 
		inner join business on business.id = ads_setting_preferences.businessid
		WHERE   ads_setting_preferences.settingszoneid =".$zoneID;

		$query = $this->db->query($sql);
    	return $query->result_array();
    }
	  public function status_payment($zoneID=0){

        $sql =  "SELECT  zpayment_status  FROM sales_zone WHERE  id =".$zoneID;

		$query = $this->db->query($sql);
    	return $query->result_array();        

    }

    public function storecredit($busid = '' , $credit = '' , $token = ''){    


		 $sql="SELECT count(*) as counted FROM `business_credits_purchase` WHERE `credits` = ".$credit." and token_id =  '". $token."' and busid =  ".$busid."   and datetimestamp  <= now() + INTERVAL 1 DAY";
		 $data = $this->db->query($sql)->row();
	 

		 if($data->counted != 1){

	          $this->db->insert('business_credits_purchase', array('busid' => $busid, 'token_id' => $token,'credits' => $credit  ));
			  $sql = "UPDATE business SET creditprice = creditprice + ".$credit." where id = ".$busid;
			  $result = $this->db->query($sql);

		 }



    }


	public function get_ad_setting_by_id($id){
		$common = new CommonController();
		$sql="select asp.type,asp.isverified_businessowner,b.audio_presentation,b.video_presentation from (ads_setting_preferences as asp,business as  b) where b.id=asp.businessid  and b.id=".$id."";
		return $common->SelectRawquery($sql,'row');
	}
	public function get_business_for_pbg($id)
	{
		$sql = "SELECT t1.business_owner_id,t1.id AS business_iD,t2.username FROM business as t1 INNER JOIN users AS t2 where t1.business_owner_id=t2.id AND t1.id =".$id;
		return $this->db->query($sql)->row();
	}
# + get_all_from_ad_setting_pref 				// Added on 8/8/14
	public function get_all_from_ad_setting_pref($business_id,$zone_id,$send_to_zone_id){ 
			
		/*Retreive all from ads_setting_preferences for a particular business and zone.*/
		$sql = "SELECT * FROM  ads_setting_preferences WHERE businessid=".$business_id." AND settingszoneid=".$zone_id." AND is_exist_other_zone = 0";
		$query = $this->db->query($sql);
		$res = $query->row_array();  
		
		/*Check for duplicate entry. If not insert a new row having zoneid = send_to_zone_id*/
		$sql1 = "SELECT * FROM ads_setting_preferences WHERE businessid=".$business_id." AND settingszoneid=".$send_to_zone_id." AND is_exist_other_zone = 1";
		$query = $this->db->query($sql1);
		$result= $query->num_rows();
			if($result==0){
				$data = array('businessid'=>$res['businessid'] , 'settingszoneid'=>$send_to_zone_id , 'isdefault'=> 0, 'approval'=>$res['approval'] , 'type'=>$res['type'] , 'paymenttype'=>$res['paymenttype'] , 'websitevisibility'=>$res['websitevisibility'] , 'emailvisibility'=> $res['emailvisibility'], 'isverified_businessowner'=>$res['isverified_businessowner'] , 'is_duplicate'=>$res['is_duplicate'] , 'is_exist_other_zone'=> 1);
				$insert = $this->db->insert('ads_setting_preferences', $data);
				//echo $this->db->last_query(); exit;
				//return 'all';
			} 
	}
# - get_all_from_ad_setting_pref

# + get_ad_to_zone_and_insert					// Added on 8/8/14
	public function get_ad_to_zone_and_insert($business_id,$zone_id,$send_to_zone_id){
		
		/*Retreive all from ad_to_zone for a particular business and zone*/
		$select_business_ads_adtozone = "SELECT a.* FROM ad_to_zone a, ads b, business c WHERE c.id=b.business_id AND a.adid=b.id AND a.zoneid=".$zone_id." AND b.business_id=".$business_id;
		$query = $this->db->query($select_business_ads_adtozone);
		$res = $query->result_array($query);
		
		/*Check for duplicate entry. If not then insert with zoneid = send_to_zone_id*/
		foreach($res as $k=>$val){ 
			$adid = $val['adid'];	
			$select_dupes = "SELECT * FROM ad_to_zone WHERE adid=".$adid." AND zoneid=".$send_to_zone_id;
			$query = $this->db->query($select_dupes);
			$row_count = $query->num_rows();
			
			if($row_count==0){
				$data = array('adid'=>$val['adid'] , 'zoneid'=>$send_to_zone_id , 'approval'=>$val['approval'] , 'stickyad'=>$val['stickyad']);	
				$insert_rows = $this->db->insert('ad_to_zone',$data);
				//return 'all';
			}
		}
	}
# - get_ad_to_zone_and_insert

# + Delete from_ad_setting_pref				// Added on 8/8/14
	public function from_ad_setting_pref($business_id,$zone_id){
		$sql = "DELETE FROM ads_setting_preferences WHERE businessid=".$business_id." AND settingszoneid=".$zone_id;
		$query = $this->db->query($sql);
	}
# - Delete from_ad_setting_pref

# + Delete from_ad_to_zone					// Added on 8/8/14
	public function from_ad_to_zone($business_id,$zone_id){
		/*Select the data against businessid and zone id*/
		$select_business_ads_adtozone = "SELECT a.* FROM ad_to_zone a, ads b, business c WHERE c.id=b.business_id AND a.adid=b.id AND a.zoneid=".$zone_id." AND b.business_id=".$business_id;
		$query = $this->db->query($select_business_ads_adtozone);
		$res = $query->result_array($query);
		
		foreach($res as $k=>$val){ 
			$adid = $val['adid'];
			$sql = "DELETE FROM ad_to_zone WHERE adid=".$adid." AND zoneid=".$zone_id;
			$query = $this->db->query($sql);
		}
	}
# - Delete from_ad_to_zone
	
	
    public function get_all_businesses()
    {
        $query = $this->db->query('select * from business order by name');
        return $query->result_array();
    }

    public function get_all_businesses_for_user($id = false){
    	$common = new CommonController();	
     	$query = "select distinct a.*,b.settingszoneid as zoneid from business a,ads_setting_preferences b where a.id=b.businessid and  a.business_owner_id = $id  order by a.name";
       	return $common->SelectRawquery($query,'resultArray');        
    }
    
      public function get_all_businesses_for_data($id = false)
    {	
        
        $query = $this->db->query("select distinct a.*,b.settingszoneid as zoneid from business a,ads_setting_preferences b where a.id=b.businessid and  a.business_owner_id = $id  order by a.name");
       
        return $query->result_array();        
    }

    public function get_businesses_for_zone($zoneId,$user){
        $query = $this->db->query("SELECT t1.id as biz_id,t4.act_deact, t1.*, t3.*, (select count(*) from ads as t2 where t2.business_id = t1.id ) as ad_count FROM business as t1 
		join address as t3 on t1.addressid = t3.id 
		join business_to_zone as t4 on t4.business_id=t1.id and t4.zone_id=$zoneId 
		WHERE t1.id in (select business_id from business_to_zone where zone_id = $zoneId) AND t1.business_owner_id=$user AND name!='' order by name");
        return $query->result_array();
    }
    public function get_businesses_not_in_zone($zoneId,$user){
        $query = $this->db->query("SELECT *, id as biz_id FROM business WHERE id not in (select business_id from business_to_zone where zone_id = $zoneId)  AND business_owner_id=$user AND name!='' order by name");
        return $query->result_array();
    }
    
    public function add_business_to_zone($biz_id, $id, $user){
        $this->db->insert('business_to_zone', array('business_id' => $biz_id, 'zone_id' => $id, 'date_added' => date('Y-m-d H:i:s')));
        return $this->get_businesses_for_zone($id,$user);
    }
    public function remove_business_from_zone($biz_id, $id, $user){
        $this->db->delete('business_to_zone', array('business_id' => $biz_id, 'zone_id' => $id));
         return $this->get_businesses_for_zone_new($id,$user);
    }
    function get_all_branches()
    {
    	$query = $this->db->query('select * from Branches order by branch_name');
    	return $query->result_array();
    }
    function get_branches_for_business($id)
    {
        $sql = "select t1.*,t2.street_address_1, t2.street_address_2, t2.city,t2.state,t2.zip_code,t2.phone
                    from Branches as t1 left join address as t2 on t1.address_id = t2.id where t1.business_id = ?";
        return $this->db->query($sql, array($id))->result_array();
    }
	public function get_all_businesses_zone($zone=false,$user=false)
    {
    	$sql = "SELECT t1.id, t1.name, t2 . * , t3.approved, t3.user_id as user
    	from business as t1 left join business_to_zone as t2 on t1.id = t2.business_id
    	left join business_approved as t3 on t3.business_id = t1.id
    	where t2.zone_id = " . $zone;
    	
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }
	public function get_all_businesses_approved($zone,$user)
    {
    	
		$sql="SELECT a.user_id as user,a.approved,b.id,b.name,c.id as zoneid,c.name as zone_name from business_approved a,business b,sales_zone c where a.business_id=b.id and a.zoneid=c.id and a.user_id=".$user;
    	
    	$query = $this->db->query($sql);
    	return $query->result_array();
		
    }    
    function upadte_user_paypal($user_id,$status)
    {
    	$sql_user="select * from user_paypal where user_id = '".$user_id."'";
    	$query_user=$this->db->query($sql_user);
    	$approved = $query_user->row();
    	
    	$data['success']=$status;
    	$data['user_id']=$user_id;
    	$data['cancel']='0';
    	
    	if(!empty($approved))
    	{
    		$this->db->where('user_id', $user_id);
    		$this->db->update('user_paypal', $data);
    	}else
    	{
    		$this->db->insert('user_paypal', $data);
    	}
    	return true;
    }
    
    public function get_all_businesses_business_type($zone,$bus_type)
    {
    	$sql = "SELECT t1.id, t1.name, t2 . * , t3.approved, t3.user_id as user
    	from business as t1 left join business_to_zone as t2 on t1.id = t2.business_id
    	left join business_approved as t3 on t3.business_id = t1.id
    	left join business_business_type as t4 on t1.id = t4.business_id
    	where t2.zone_id = " . $zone. " and t4.business_type_id=" .$bus_type;
    
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }
    
    public function get_all_businesses_approved_business_type($zone,$bus_type,$user)
    {
    	$sql = "SELECT t1.id, t1.name, t2 . * , t3.approved, t3.user_id as user
    	from business as t1 left join business_to_zone as t2 on t1.id = t2.business_id
    	left join business_approved as t3 on t3.business_id = t1.id
    	left join business_business_type as t4 on t1.id = t4.business_id
    	where t3.user_id=$user and  t2.zone_id = " . $zone. " and t4.business_type_id=" .$bus_type;
    
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }
    
    function email_count($id)
    {
    	$sql = "select * from hot_email_count where business_id = " . $id;
    	$query = $this->db->query($sql);
    	
    	return $query->row();
    	
    }
	/*25-10-2012*/
    public function get_businesses_for_zone_new($zoneId,$user)
    {
    	$query = $this->db->query("SELECT t1.id as biz_id, t1.*, t3.*,t4.act_deact, (select count(*) from ads as t2 where t2.business_id = t1.id ) as ad_count FROM business as t1 
    			join address as t3 on t1.addressid = t3.id
    			join business_to_zone as t4 on t4.business_id=t1.id and t4.zone_id=$zoneId 
    			WHERE (t1.id NOT IN (select business_id from business_zone_owners) OR t1.id in (select bz.business_id from business_zone_owners as bz join sales_zone as sz on sz.sales_rep_id=bz.zone_owner_id where sz.id='$zoneId')) 
		AND t1.id in (select business_id from business_to_zone where zone_id = $zoneId) AND name!='' order by name");
    	return $query->result_array();
    }
	public function get_all_business($zoneId='',$type='',$approval=''){
		$business_type = '' ;
		if($type == 'all'){
			$business_type = '1,-1,2,-2,3,-3' ;
		}else if($type == 'active_comingsoon'){
			$business_type = '3' ;
		}else if($type == 'inactive_comingsoon'){
			$business_type = '-3' ;
		}else if($type == 'active_trial'){
			$business_type = '2' ;
		}else if($type == 'inactive_trial'){
			$business_type = '-2' ;
		}else if($type == 'active_paid'){
			$business_type = '1' ;
		}else if($type == 'inactive_paid'){
			$business_type = '-1' ;
		}
		$query = "SELECT Count(id) AS countbus FROM ads_setting_preferences WHERE approval IN($business_type) AND settingszoneid = $zoneId" ;
		$sql = $this->db->query($query) ;
		return $result = $sql->getResultArray() ;
	}
    public function get_businesses_who_have_advertised($zoneId,$user,$busvalue='',$char='')
    {	
		$is_duplicate = '';	
		$by_char = '';								// added $is_duplicate on 12/6/14
		if($busvalue!='' && $busvalue == 1){
			$approval = '3';
			$is_duplicate = ' AND a.is_duplicate != 1';		// added on 12/6/14
		}
		else{
			$approval = '1,2';
			$is_duplicate = '';								// added on 12/6/14
		}
		if($char != ''){
			$by_char = ' AND b.name LIKE "'.$char.'%"';
		}
		else{
			$by_char = '';
		}
		
    	$query = $this->db->query("SELECT b.id,b.name FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid=".$zoneId." AND approval IN(".$approval.")".$is_duplicate."$by_char GROUP BY b.id order by b.name asc");
 		 //added $is_duplicate on 12/6/14
		 //echo $this->db->last_query(); exit;
		$result[0] = $query->result_array() ;
		$allbusinessids = '' ;
		foreach($result[0] as $arr)
			$allbusinessids.= $arr['id']."," ;
		if($allbusinessids != '') $allbusinessids = substr($allbusinessids,0,-1);
		$result[1] = $allbusinessids ;
    	return $result;
    }
	
	public function get_businesses_by_advertisement_type($zoneId,$user,$busvalue='',$char='',$adtype='')
    {	
		$is_duplicate = '';	
		$by_char = '';	
		$approval = '';							
		if($busvalue!='' && $busvalue == 1){
			$approval = '3';			// Active Upload
			$is_duplicate = ' AND a.is_duplicate != 1';		
		}
		else if($busvalue!='' && $busvalue == 0){
			$approval = '1,2';			// Active paid or Active trial      
			$is_duplicate = '';								
		}
		if($char != ''){
			$by_char = ' AND b.name LIKE "'.$char.'%"';
		}
		else{
			$by_char = '';
		}
		
    	$query = $this->db->query("SELECT b.id,b.name FROM ads_setting_preferences a, business b, ads c, ad_to_zone d 
		WHERE a.businessid=b.id AND 
		b.id = c.business_id AND
		c.id = d.adid AND
		d.approval = $adtype AND
		a.settingszoneid=".$zoneId." AND 
		a.approval IN(".$approval.")".$is_duplicate."$by_char GROUP BY b.id order by b.name asc");

		 //echo $this->db->last_query(); exit;
		$result[0] = $query->result_array() ;
		$allbusinessids = '' ;
		foreach($result[0] as $arr)
			$allbusinessids.= $arr['id']."," ;
		if($allbusinessids != '') $allbusinessids = substr($allbusinessids,0,-1);
		$result[1] = $allbusinessids ;
    	return $result;
    }
	
	public function get_businesses_by_advertisement_category_type($zoneId,$user,$busvalue='',$char='',$adtype='')
    {	
		//$is_duplicate = '';		
		//$approval = '';
		$by_char = '';	
		$wh_type = '';						
		if($busvalue!='' && $busvalue == 0){		// For Non temp ads
			$wh_type=" and e.catid!='-99' and e.subcatid!='-99'";
		}
		else if($busvalue!='' && $busvalue == 1){	// For temp ads
			$wh_type=" and e.catid='-99' and e.subcatid='-99'";
		}
		else if($busvalue!='' && $busvalue == 2){	// For franchisee ads
			$wh_type=" and e.catid='14' and a.type=2";
		}
		if($char != ''){
			$by_char = ' AND b.name LIKE "'.$char.'%"';
		}
		else{
			$by_char = '';
		}
		
    	$query = $this->db->query("SELECT b.id,b.name 
		FROM ads_setting_preferences a, business b, ads c, ad_to_zone d, ad_category_subcategory e 
		WHERE a.businessid=b.id AND 
		b.id = c.business_id AND
		c.id = d.adid AND
		c.id = e.adid AND
		d.approval = $adtype AND
		a.settingszoneid=".$zoneId." AND 
		a.is_duplicate != 1 $wh_type $by_char GROUP BY b.id order by b.name asc");

		//echo $this->db->last_query(); exit;
		$result[0] = $query->result_array() ;
		$allbusinessids = '' ;
		foreach($result[0] as $arr)
			$allbusinessids.= $arr['id']."," ;
		if($allbusinessids != '') $allbusinessids = substr($allbusinessids,0,-1);
		$result[1] = $allbusinessids ;
    	return $result;
    }
	
		// 		C O M M E N T E D  O N  14.8.14 for non-temp business
/*	public function get_businesses_by_advertisement_category_type($zoneId,$user,$busvalue='',$char='',$adtype='')
    {	
		//$is_duplicate = '';		
		//$approval = '';
		$by_char = '';	
		$wh_type = '';						
		if($busvalue!='' && $busvalue == 0){		// For Non temp ads
			//$wh_type=" and e.catid!='-99' and e.subcatid!='-99' and a.type=1";
			$wh_type=" and a.approval IN (1,2) and a.type=1";
		}
		else if($busvalue!='' && $busvalue == 1){	// For temp ads
			//$wh_type=" and e.catid='-99' and e.subcatid='-99'";
			$wh_type=" and a.approval IN (3) and a.type=1";
		}
		else if($busvalue!='' && $busvalue == 2){	// For franchisee ads
			//$wh_type=" and e.catid='14' and a.type=2";
			$wh_type=" and a.approval IN (1,2) and a.type=2";
		}
		
		if($char != ''){
			$by_char = ' AND b.name LIKE "'.$char.'%"';
		}
		else{
			$by_char = '';
		}
		
    	$query = $this->db->query("SELECT b.id,b.name 
		FROM ads_setting_preferences a, business b, ads c, ad_to_zone d, ad_category_subcategory e 
		WHERE a.businessid=b.id AND 
		b.id = c.business_id AND
		c.id = d.adid AND
		c.id = e.adid AND
		d.approval = $adtype AND
		a.settingszoneid=".$zoneId." AND 
		a.is_duplicate != 1 $wh_type $by_char GROUP BY b.id order by b.name asc");

		//echo $this->db->last_query(); exit;
		$result[0] = $query->result_array() ;
		$allbusinessids = '' ;
		foreach($result[0] as $arr)
			$allbusinessids.= $arr['id']."," ;
		if($allbusinessids != '') $allbusinessids = substr($allbusinessids,0,-1);
		$result[1] = $allbusinessids ;
    	return $result;
    }*/
    
    public function get_businesses_not_in_zone_new($zoneId,$user){
    	
    	$query = $this->db->query("SELECT t1.*, t1.id as biz_id FROM business as t1 WHERE 
    	(t1.id NOT IN (select business_id from business_zone_owners) OR t1.id in (select bz.business_id from business_zone_owners as bz join sales_zone as sz on sz.sales_rep_id=bz.zone_owner_id where sz.id='$zoneId')) 
		AND id not in (select business_id from business_to_zone where zone_id = $zoneId) AND name!='' order by name");
    	return $query->result_array();
    }
    
    public function add_business_to_zone_new($biz_id, $id, $uid){
    	$this->db->insert('business_to_zone', array('business_id' => $biz_id, 'zone_id' => $id));
    	return $this->get_businesses_for_zone_new($id, $uid);
    }
	// +athena eSolutions
	public function add_business_approved($id, $approve, $uid){
    	$this->db->insert('business_approved', array('business_id' => $id, 'user_id' => $uid, 'approved'=>$approve));
    }
	public function get_businesses_for_zone_new_admin($biz_id, $id, $uid, $status){
    	$this->db->insert('business_to_zone', array('business_id' => $biz_id, 'zone_id' => $id, 'act_deact'=>$status));
    	return $this->get_businesses_for_zone_new($id, $uid);
    }
	public function get_user_group1($uid){
    	$sql = "select group_id from  users_groups where user_id =".$uid;
    	$query = $this->db->query($sql);
    	return $query->getRow();
    }
	
	public function business_information($id){
    	$sql = "select id,name from  business where id =".$id;
    	$query = $this->db->query($sql)->result_array();
    	return $query ;
    }

    public function business_logo($id){
    	$common = new CommonController();
    	$sql = "select logo as bs_logo from  business where id =".$id;
		$r = $common->SelectRawquery($sql,'row');
    	return $r ;
    }

	public function zone_preferences_informatiom($id){
		$sql = "select * from  zone_preferences where zoneid  =".$id;
    	$query = $this->db->query($sql)->row();
    	return $query ;
    }
	// -athena eSolutions
	function get_businesses_act_deact($zoneId,$status, $user)
    {
    	if($status=='1'){
	    	$query = $this->db->query("SELECT t1.id as biz_id,t4.act_deact, t1.*, t3.*, (select count(*) from ads as t2 where t2.business_id = t1.id ) as ad_count FROM business as t1
			join address as t3 on t1.addressid = t3.id
			join business_to_zone as t4 on t4.business_id=t1.id and t4.zone_id=$zoneId and t4.act_deact='1'
			WHERE t1.id in (select business_id from business_to_zone where zone_id = $zoneId) AND t1.business_owner_id=$user AND name!='' order by name");
    	}
    	elseif($status=='2')
    	{
    		$query = $this->db->query("SELECT t1.id as biz_id,t4.act_deact, t1.*, t3.*, (select count(*) from ads as t2 where t2.business_id = t1.id ) as ad_count FROM business as t1
    		join address as t3 on t1.addressid = t3.id
    		join business_to_zone as t4 on t4.business_id=t1.id and t4.zone_id=$zoneId and t4.act_deact='0'
    		WHERE t1.id in (select business_id from business_to_zone where zone_id = $zoneId) AND t1.business_owner_id=$user AND name!='' order by name");
    	}
    	else
    	{
    		$query = $this->db->query("SELECT t1.id as biz_id,t4.act_deact, t1.*, t3.*, (select count(*) from ads as t2 where t2.business_id = t1.id ) as ad_count FROM business as t1
    		join address as t3 on t1.addressid = t3.id
    		join business_to_zone as t4 on t4.business_id=t1.id and t4.zone_id=$zoneId
    		WHERE t1.id in (select business_id from business_to_zone where zone_id = $zoneId) AND t1.business_owner_id=$user AND name!='' order by name");
    	}
    	
    	return $query->result_array();
    }
	function get_all_users_claim()
    {
    	$query = $this->db->query("SELECT t1.id,t1.first_name,t1.last_name, (select count(zip) from tblClaimedZips as t2 where t2.uid = t1.id and t2.approved='1') as zip_approve,
    			(select count(zip) from tblClaimedZips as t2 where t2.uid = t1.id and t2.approved='0' ) as zip_notapprove 
    			FROM users as t1 join tblClaimedZips as t3 on t3.uid=t1.id GROUP BY t1.id order by t1.last_name, t1.first_name");
    	return $query->result_array();
    }
    
    function get_zip_code($code)
    {
    	$query=$this->db->query("select * from zipcode where zip='".$code."'");
    	if($query->num_rows()>=1)
    	{
    		$row=$query->row();
    
    		$latitude=deg2rad($row->latitude);
    		$longitude=deg2rad($row->longitude);
    
    		$radius_query='SELECT Zip_ID, zip, latitude, longitude, ACOS( SIN( '.$latitude.' ) * SIN( RADIANS( latitude ) ) + COS( '.$latitude.' ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - ( '.$longitude.' ) ) ) *6371 AS D
    		FROM zipcode 
    		WHERE ACOS( SIN( '.$latitude.' ) * SIN( RADIANS( latitude ) ) + COS( '.$latitude.' ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - ( '.$longitude.' ) ) ) *6371 < 5 ORDER BY D';
    
    		$query=$this->db->query($radius_query);
    		$result=$query->result_array();
    
    		if($result)
    		{
    			foreach($result as $val_result)
    			{
	    			$qry="select zz.zone_id,sz.name,sz.id from zip_code_zone as zz, sales_zone as sz where zz.zip_code = '".$val_result['zip']."' and zz.zone_id=sz.id group by zz.zone_id";
	    			$query=$this->db->query($qry);
	    			
	    			if($query->row()){
	    				return $query->row();
	    			}
    			}
    		}else{
    			return false;
    		}
    	}
    	else
    	{
    		return false;
    	}
    }
    
    function get_zone_all()
    {
		$radius_query="SELECT a.id, a.name from sales_zone a, users b where a.sales_rep_id=b.id and a.sales_rep_id NOT IN(658,774,794,821,717,522,660,155,8741,8742,808,380,198,5068) and a.id NOT IN(0,-1,1) and a.name!='' order by a.name";
    	
    	$query=$this->db->query($radius_query);
    	return $query->result_array();
    }
	function get_all_business_type($zone_id=false)
    {
    	if($zone_id)
    	{
    		$business_type_query="SELECT * from business_type where zone_id = $zone_id or zone_id = '0' order by name";
    	}else{
    		$business_type_query="SELECT * from business_type order by name";
    	}
    	
    	$query=$this->db->query($business_type_query);
    	return $query->result_array();
    }
    
    function get_category_byid($id)
    {
    	$qry="select * from business_type where id=$id";
    	$query=$this->db->query($qry);
    	
    	if($query->row()){
    		return $query->row();
    	}
    	else{
    		return false;
    	}
    }
    
    function get_all_subcategory($catid,$zone_id = false)
    {
    	if($zone_id)
    	{
    		$qry="select t1.*, (select count(id) from ads as t2 where t2.category_id = t1.id) as ads_id from business_category as t1 where (t1.zone_id = $zone_id or t1.zone_id = 0) and business_type_id=$catid";
    	}else{
    		$qry="select t1.*, (select count(id) from ads as t2 where t2.category_id = t1.id) as ads_id from business_category as t1 where business_type_id=$catid";
    	}
    	
    	$query=$this->db->query($qry);
    	return $query->result_array();
    }
    function get_subcategory_byid($subcat)
    {
    	$qry="select * from business_category where id=$subcat";
    	$query=$this->db->query($qry);
    	 
    	if($query->row()){
    		return $query->row();
    	}
    	else{
    		return false;
    	}
    }
    function all_subcategory()
    {
    	$qry="select * from business_category order by name";
    	$query=$this->db->query($qry);
    	return $query->result_array();
    }
    function get_all_users()
    {
    	$sql="select id,username,email,first_name,last_name,active from users order by username";
    	$query=$this->db->query($sql);
    	return $query->result_array();
    }
    function get_user_group($user_id)
    {
    	$qry="select g.id,g.name from users_groups as ug join groups as g on g.id=ug.group_id where ug.user_id=$user_id";
    	$query=$this->db->query($qry);
    	if($query->row()){
    		return $query->row();
    	}
    	else{
    		return false;
    	}
    }
    function get_all_users_group()
    {
    	$sql="select * from groups order by name";
    	$query=$this->db->query($sql);
    	return $query->result_array();
    }
    
    function user_zone_owner($user)
    {
    	$sql="SELECT z.* FROM `zip_code_zone` as z join users as u on u.Zip=z.zip_code WHERE u.id='".$user."'";
    	$query = $this->db->query($sql);
    	
    	if($query->row())
    	{
    		return $query->row();
    	}
    	else{
    		return false;
    	}
    }
    function edit_user($user)
    {
    	$sql="SELECT id,username,email,first_name,last_name FROM `users` WHERE id='".$user."'";
    	$query = $this->db->query($sql);
    	 
    	if($query->row())
    	{
    		return $query->row();
    	}
    	else{
    		return false;
    	}
    }
    function get_zone_byuser($user)
    {
    	$sql="select id, name from sales_zone where sales_rep_id=$user LIMIT 1";
    	$query=$this->db->query($sql);
    	
    	if($query->row())
    	{
    		return $query->row();
    	}
    }
    function get_zone_manager_owner($user_id)
    {
    	$sql="select zone_id from zone_managers where user_id=$user_id";
    	$query = $this->db->query($sql);
    
    	if($query->row())
    	{
    		return $query->row()->zone_id;
    	}
    	else
    	{
    		$sql="select id from sales_zone where sales_rep_id=$user_id";
    		$query = $this->db->query($sql);
    		if($query->row())
    		{
    			return $query->row()->id;
    		}else{
    			return false;
    		}
    	}
    }
    
    public function DeleteBusiness($biz_id, $id, $user){
    	$this->db->delete('business_to_zone', array('business_id' => $biz_id, 'zone_id' => $id));
    	$this->db->delete('business', array('id' => $biz_id));
    	$this->db->delete('business_approved', array('business_id' => $biz_id));
    	$this->db->delete('business_business_type', array('business_id' => $biz_id));
    	$this->db->delete('business_zone_owners', array('business_id' => $biz_id));
    	
    	return $this->get_businesses_for_zone_new($id,$user);
    }
    
    function zone_owner_user($user)
    {
    	$sql="select * from users where id=$user";
    	$query = $this->db->query($sql);
    	if($query->row())
    	{
    		return $query->row();
    	}else{
    		return false;
    	}
    }
    
    function business_owner_user($user)
    {
    	$sql="select t1.id, t2.zone_id from business as t1 join business_to_zone as t2 on t2.business_id=t1.id where t1.business_owner_id=$user";
    	
    	$query=$this->db->query($sql);
    	$result = $query->result_array();
    	
    	$i=0;
    	foreach($result as $v_result)
    	{
    		if($i==1)
    		{
    			break;
    		}
    		$i++;
    		return $v_result['zone_id'];
    	}
    }
    
    public function get_businesses_owner_zone_new($zoneId)
    {
    	$query = $this->db->query("SELECT t1.id as biz_id, t1.name, t7.email FROM business as t1
    			join address as t3 on t1.addressid = t3.id
    			join users as t7 on t1.business_owner_id = t7.id
    			join business_to_zone as t4 on t4.business_id=t1.id and t4.zone_id=$zoneId
    			WHERE (t1.id NOT IN (select business_id from business_zone_owners) OR t1.id in (select bz.business_id from business_zone_owners as bz join sales_zone as sz on sz.sales_rep_id=bz.zone_owner_id where sz.id='$zoneId'))
    			AND t1.id in (select business_id from business_to_zone where zone_id = $zoneId) AND name!='' order by name");
    			return $query->result_array();
    }
    
    function get_all_zone_owner()
    {
    	$radius_query='SELECT t1.id, t1.username, t1.first_name, t1.last_name FROM users AS t1 JOIN sales_zone AS t2 ON t2.sales_rep_id = t1.id GROUP BY t1.id ORDER BY t1.username';
    	 
    	$query=$this->db->query($radius_query);
    	return $query->result_array();
    }
    
    function get_all_zone_by_user($user)
    {
    	$radius_query="SELECT name FROM sales_zone where sales_rep_id=$user and name!='' ORDER BY name";
    
    	$query=$this->db->query($radius_query);
    	return $query->result_array();
    }
	 public function get_businesses_owner_new($zone_id=0,$bulk_email_select_value=0,$bulk_email_type_select_value=0)
    {
		$user = $this->ion_auth->user()->row();
		$uid=$user->id;
		
		if($bulk_email_select_value==0){
			//$isdefault=1;
			$isdefault_query=" and a.isdefault=1";
		} else if($bulk_email_select_value==1){
			//$isdefault=0;
			$isdefault_query=" and a.isdefault=0";
		} else if($bulk_email_select_value==2){
			$isdefault_query=" and a.isdefault IN(0,1)";
		}else if($bulk_email_select_value==3){
			$isdefault_query=" and a.isdefault IN(0,1) and b.created_by=".$uid;
			$zone_id=-1;
		}
		if($bulk_email_select_value!=2 && $bulk_email_select_value!=3 && $bulk_email_select_value!=5){
			$bulk_email_type_select_query=" and a.approval=".$bulk_email_type_select_value;
		}else{
			$bulk_email_type_select_query=" and a.approval IN(0,1,-1,2,-2)";
		}
		
			$sql="select a.businessid,a.approval,a.paymenttype,a.websitevisibility,a.emailvisibility,b.name,b.isverified,c.last_name,c.first_name,c.username,c.id as userid from ads_setting_preferences a,business b,users c WHERE a.businessid=b.id AND b.business_owner_id=c.id AND a.settingszoneid=".$zone_id."".$bulk_email_type_select_query."".$isdefault_query." GROUP BY a.businessid ORDER BY b.name asc "; 
			$query=$this->db->query($sql);
			$result=$query->result_array();
			$i=0;
			foreach($result as $arr) {
				// New ads
				$sql="select count(b.id) as count_new from ads a, ad_to_zone b WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zone_id." AND a.id=b.adid AND b.approval=0" ;
				$query_inner=$this->db->query($sql);
				$result_inner=$query_inner->result_array();
				//var_dump($result_inner);
				$result[$i]['new'] = $result_inner[0]['count_new'] ;
				// Approved ads
				$sql="select count(b.id) as count_approved from ads a, ad_to_zone b WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zone_id." AND a.id=b.adid AND b.approval=1" ;
				$query_inner=$this->db->query($sql);
				$result_inner=$query_inner->result_array();
				$result[$i]['approved'] = $result_inner[0]['count_approved'] ;
				// Unapproved ads
				$sql="select count(b.id) as count_unapproved from ads a, ad_to_zone b WHERE a.business_id=".$arr['businessid']." AND b.zoneid=".$zone_id." AND a.id=b.adid AND b.approval=-1" ;
				$query_inner=$this->db->query($sql);
				$result_inner=$query_inner->result_array();
				$result[$i]['unapproved'] = $result_inner[0]['count_unapproved'] ;
				$i++;
			}
			//var_dump($result);
		//}
		
		return $result;
	}
    
    function get_all_business_by_user($user,$zoneId)
    {
    	$query = $this->db->query("SELECT t1.name FROM business as t1
    			join address as t3 on t1.addressid = t3.id
    			join business_to_zone as t4 on t4.business_id=t1.id and t4.zone_id=$zoneId
    			WHERE (t1.id NOT IN (select business_id from business_zone_owners) OR t1.id in (select bz.business_id from business_zone_owners as bz join sales_zone as sz on sz.sales_rep_id=bz.zone_owner_id where sz.id='$zoneId'))
    			AND t1.id in (select business_id from business_to_zone where zone_id = $zoneId) AND name!='' AND business_owner_id=$user order by name") ;
    	return $query->result_array();
    }
	public function get_businesses_details($businesszone_select=false,$businesstype_select=false,$zoneid=false,$charval=false,$lowerlimit=false,$upperlimit=false){
		$user = $this->ion_auth->user()->row();
		$uid=$user->id;
		if($businesszone_select==0){
			//$isdefault=1;
			$isdefault_query=" and a.isdefault=1";
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
			$where=' AND b.name LIKE "'.urldecode($charval).'%"';
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
	public function get_businesses_details_listed($businesstype_select=false,$zoneid=false,$charval=false,$lowerlimit=false,$upperlimit=false,$duplicate_type=0){												//0,3,-3,0(Dupes business)
		
		//echo $lowerlimit; echo $upperlimit;		
		//var_dump($duplicate_type);
		
		//$limit_where="";
		if($charval=='all'){
			$where='';
		}else{ 
			// Added  OR c.phone ="'.trim(urldecode($charval)).'" on 23/5/14
			/*$charval=str_replace('(','',$charval);
			$charval=str_replace(')','',$charval);
			$charval=str_replace('-','',$charval);*/
			/*$phone1=trim(urldecode($charval)).'</br>';
			preg_match_all('/\d+/', $phone1, $matches);
			$matches[0]; 
			$phone=implode('',$matches[0]).'<br>';
			$b=preg_replace('/[^0-9]/', '',trim(urldecode($charval))).'<br>';*/
			/*$str = trim(preg_replace('/\s*\([^)]*\)/', '', trim(urldecode($charval))));
			$str = preg_replace("/^.*\(([^)]*)\).*$/", '$1', $charval);			
			$phone=preg_replace('(-)', '',str_replace(' ','-',trim(urldecode($charval)))).'<br>';
			$str = 'Hard Disk (HDD)';
			echo $job = preg_replace('/([()]+)/i' ,'',trim(urldecode($charval)));*/
			//var_dump($job);
			//$a='(220) 022-3022';
			/*$phone1=str_replace('(', '',$b).'<br>';
			$phone2=str_replace(')', '', $phone1); */
			//$charval=str_replace('',' ',$charval);
			
			//$phone_number = str_replace(array('(','-',')'),array("","",""),$charval);
			//$a=trim($charval);
			//var_dump(html_entity_decode($a));
			$phone_number=urldecode(html_entity_decode(trim($charval)));  
			$phone_number_1=str_replace(' ','',$phone_number);
			$where=' AND (b.name LIKE "'.urldecode($charval).'%" OR d.phone_int ="'.trim(urldecode($charval)).'" OR d.phone ="'.$phone_number.'")';
		}
		if($businesstype_select==3 || $businesstype_select==4){
			$where_businesstype_approval=" and a.approval IN(3,4)";
		}else if($businesstype_select==-3 || $businesstype_select==-4){
			$where_businesstype_approval=" and a.approval IN(-3,-4)";
		}else if($businesstype_select==0 ){
			$where_businesstype_approval=" and a.approval IN(3,-3)";
		}													//need to add $businesstype_select==5; $where_businesstype_approval ="" 
		if($lowerlimit!='' && $upperlimit!=''){
			$limit_where=" limit ".$lowerlimit.",".$upperlimit;
		}else{
			$limit_where="";
		}
		// Added c.phone on 23/5/14
			$sql="select a.businessid,a.approval,a.paymenttype,a.websitevisibility,a.emailvisibility,b.name,b.isverified,b.contactemail,c.last_name,c.first_name,c.username,c.uploaded_business_password,c.phone from ads_setting_preferences a,business b,users c,address d WHERE a.businessid=b.id AND b.business_owner_id=c.id AND b.addressid=d.id AND a.settingszoneid=".$zoneid."".$where_businesstype_approval." and a.isdefault=0 and a.is_duplicate=".$duplicate_type." ".$where." GROUP BY a.businessid ORDER BY trim(b.name) asc". $limit_where; 
	//echo $sql;
			$query=$this->db->query($sql);
			$result=$query->result_array();
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
			
		return $result; //var_dump($result);exit;
	}
	
	
	public function business_approval($busid,$zoneid,$option){
		$data = array('approval' => $option);
        $this->db->where('businessid', $busid);
		$this->db->where('settingszoneid', $zoneid);
        $this->db->update('ads_setting_preferences', $data);
		$sql="SELECT id FROM ads WHERE business_id=".$busid;
		$query=$this->db->query($sql);
		$result=$query->result_array();
		$newdata=array();
		if(!empty($result)){
			foreach($result as $x){
				$newdata['approval'] = $option;
				$this->db->where('adid', $x['id']);
				$this->db->where('zoneid', $zoneid);
       			$this->db->update('ad_to_zone', $newdata);
			}
		}
	}
	
	public function listed_business_approval($busid,$zoneid,$businesstype_select){
		
		if($businesstype_select==3){
			$approval=-3;
		}else if($businesstype_select==-3){
			$approval=3;
		}else if($businesstype_select==4){
			$approval=-4;
		}else if($businesstype_select==-4){
			$approval=4;
		}
		$data = array('approval' => $approval);
        $this->db->where('businessid', $busid);
		$this->db->where('settingszoneid', $zoneid);
        $this->db->update('ads_setting_preferences', $data);		
	}
	public function listed_business_approval_delete($busid,$zoneid){
		$data = array('approval' => 9);
        $this->db->where('businessid', $busid);
		$this->db->where('settingszoneid', $zoneid);
        $this->db->update('ads_setting_preferences', $data);
	}
	public function business_approval_delete($busid,$zoneid){
		$data = array('approval' => 9);
        $this->db->where('businessid', $busid);
		$this->db->where('settingszoneid', $zoneid);
        $this->db->update('ads_setting_preferences', $data);
	}
	
	public function get_zonename($id)       
	{
		$sql="select t2.id,t2.name from ads_setting_preferences as t1 join sales_zone as t2 on t1.settingszoneid=t2.id where t1.businessid=".$id;
        return $this->db->query($sql)->row();
	}
	public function default_settings_in_zone($id)
	{			   
		$sql="SELECT * FROM zone_preferences WHERE zoneid=".$id;		
		$query = $this->db->query($sql)->result_array();
		return $query;	
	}
	public function business_zone_change($id,$zoneid,$biz_type=false)
	{
		$query=$this->db->query("SELECT id FROM ads_setting_preferences WHERE businessid=".$id." AND settingszoneid=".$zoneid);
			if($query->num_rows()>0){
				$newdata['approval']=$biz_type;
				$newdata['settingszoneid']=$zoneid;	
				$this->db->where('businessid', $id);
				$this->db->update('ads_setting_preferences', $newdata);		
			}else{
				$newdata=array();
				$zone_pref=$this->default_settings_in_zone($zoneid);
				$newdata['approval']=0;
				$newdata['businessid']=$id;
				$newdata['settingszoneid']=$zoneid;		
				$newdata['isdefault']=1;
				$this->db->insert('ads_setting_preferences', $newdata);
			}
	}
	public function listed_business_status_updata($id=0,$zoneid=0,$biz_type=0)   
	{
		if($biz_type==3 || $biz_type==-3){
			$newdata['isdefault']=0;
		}
		$newdata['approval']=$biz_type;
		$newdata['settingszoneid']=$zoneid;	
		$this->db->where('businessid', $id);
		$this->db->update('ads_setting_preferences', $newdata);
		
		$data1['isverified']=1;
		$data1['timestamp']=time();
		$this->db->where('id', $id);
		$this->db->update('business', $data1);
		
		if($biz_type!=0){
			if($biz_type==1 || $biz_type==2 || $biz_type=='3'){
				$data2['approval']='1';
				
			/*}else if($inwhere==3 && ($status==1 || $status==2)){
				$data2['approval']='1';*/
				
			}else if($biz_type=='-1' || $biz_type=='-2' || $biz_type=='-3' ){
				$data2['approval']='-1';
				
			}
			$sql_ad="SELECT id from ads where business_id IN(".$id.")"; 
			$query_sel=$this->db->query($sql_ad);
			$result=$query_sel->result_array(); //var_dump($result);
			if(!empty($result)){
				foreach($result as $_x){
				$this->db->where('adid', $_x['id']);
				$this->db->where('zoneid', $zoneid);
				$this->db->update('ad_to_zone', $data2);
				}
			}
		}		
	}
	function get_business_type_by_id($busid,$zoneid){
		$common = new CommonController();
		$sql="SELECT approval,type FROM ads_setting_preferences WHERE businessid=".$busid." and settingszoneid =".$zoneid;
		$query = $this->db->query($sql);
		$result = $common->SelectRawquery($sql,'resultArray');
		if(count($result) > 0){
			return $result[0];	
		}else{
			return false;	
		}
	}

	public function get_businessin_zone($id)
	{
		$sql="SELECT settingszoneid FROM ads_setting_preferences WHERE businessid=".$id;
        return $this->db->query($sql)->row();
	}
	
	function SaveBusinessPayment($busid,$selectval){
		$data['paymenttype']=$selectval;
		$this->db->where('businessid', $busid);
		$this->db->update('ads_setting_preferences', $data);
	}
	/*function SaveBusinessApproval($busid,$selectval,$zoneid){ var_dump($zoneid); exit;
		$data['approval']=$selectval;
		$this->db->where('businessid', $busid);
		$this->db->update('ads_setting_preferences', $data);
	}*/
	function SaveBusinessApproval($busid,$selectval,$zoneid){
		$data['approval']=$selectval;
		$this->db->where('businessid', $busid);
		$this->db->update('ads_setting_preferences', $data);
        
        if($selectval==1 || $selectval==2 ){
			$data2['approval']='1';
        }else if($selectval=='-1' || $selectval=='-2' || $selectval=='0' ){
            $data2['approval']='-1';
            
        }
        $sql_ad="SELECT id from ads where business_id IN(".$busid.")"; 
        $query_sel=$this->db->query($sql_ad);
        $result=$query_sel->result_array(); //var_dump($result);
        if(!empty($result)){
            foreach($result as $_x){
            $this->db->where('adid', $_x['id']);
            $this->db->where('zoneid', $zoneid);
            $this->db->update('ad_to_zone', $data2);
            }
        }
	}
	function website_visibility_business($busid,$selectval){
		$data['websitevisibility']=$selectval;
		$this->db->where('businessid', $busid);
		$this->db->update('ads_setting_preferences', $data);
	}
	function email_visibility_business($busid,$selectval){
		$data['emailvisibility']=$selectval;
		$this->db->where('businessid', $busid);
		$this->db->update('ads_setting_preferences', $data);
	}
	function save_business_approval($id='',$zoneid='',$businesstype='',$usertype=''){
		/////////////////////////////////////////////////////////////////////////////////////////////////
		if($usertype==5){ // i.e, created by business owner
			$data['approval']=0;
			$data['isdefault'] = 1;
			$data['isverified_businessowner'] = 1;
		}
		// Added on 21/5/14
		else if($usertype==13){
			//$data['approval']=0;
			//$data['isdefault'] = 1;
			$data['isverified_businessowner'] = 1;
		}
		// Added on 21/5/14
		else{ // i.e, created by zone owner
			if($businesstype==1){ // i.e, Paid Business
				$data['approval']=1;
				$data['isdefault'] = 1;
			}else if($businesstype==2){ // i.e, Trial Business
				$data['approval']=2;
				$data['isdefault'] = 1;
			}else if($businesstype==3){ // i.e, Listed Business
				$data['approval']=3;
				$data['isdefault'] = 1;
			}
		}
		////////////////////////////////////////////////////////////////////////////////////////////////
		if($usertype==5){
			$data['type']=1;
		}else if($usertype==13){
			$data['type']=2;
		}
		$data['businessid'] = $id;
		$data['settingszoneid'] = $zoneid;		
		$this->db->insert('ads_setting_preferences', $data);
	}
	
	function get_business_name_against_id($busid=false){
		if($busid!='all'){
		$sql="SELECT name FROM business WHERE id=".$busid;
       	$a=$this->db->query($sql)->result_array();
		}else{
			$a='';
		}
		return $a;
	}
	
	function get_business_to_zone($all_bus_id=false,$users_all_zone=false){		
		$all_bus_id=str_replace("-",",",$all_bus_id);
		$users_all_zone_arr=explode(",",$users_all_zone);
		$sql="select * from ads_setting_preferences where settingszoneid IN(".$users_all_zone.") and approval IN(1,2)"; //exit;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		foreach($result as $arr_ads_setting_preferences){
			$this->db->where('id', $arr_ads_setting_preferences['id']); 
        	$this->db->delete('ads_setting_preferences');
		}
		foreach($users_all_zone_arr as $settingszoneid){
			foreach($result as $arr_result){
				$sql_sel="select * from ads_setting_preferences where businessid=".$arr_result['businessid']." and settingszoneid=".$settingszoneid." and isdefault=".$arr_result['isdefault']." and approval=".$arr_result['approval'];
				$query_sel=$this->db->query($sql_sel);
				$result_sel = $query_sel->num_rows();
				if($result_sel < 1){
					
				$newdata['businessid'] = $arr_result['businessid'];
				$newdata['settingszoneid'] = $settingszoneid;
				if($arr_result['settingszoneid']==$settingszoneid){
					$newdata['isdefault'] =$arr_result['isdefault'];
					$newdata['approval'] = $arr_result['approval'];
				}else{
					$newdata['isdefault'] = 0;
					$newdata['approval'] = 2;
				}
				$newdata['paymenttype'] = $arr_result['paymenttype'];
				$newdata['websitevisibility'] = $arr_result['websitevisibility'];
				$newdata['emailvisibility'] = $arr_result['emailvisibility'];
				$this->db->insert('ads_setting_preferences', $newdata);
				}
			}
		}
	}
	
	function get_ads_to_zone($all_bus_id=false,$users_all_zone=false){
		$users_all_zone_arr=explode(",",$users_all_zone);
		$sql="select * from ad_to_zone where zoneid IN(".$users_all_zone.") and approval=1";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		$alladids = '' ;
		foreach($result as $arr_ad_to_zone){
			$this->db->where('id', $arr_ad_to_zone['id']);
       		$this->db->delete('ad_to_zone');
		}
		
		foreach($users_all_zone_arr as $v_users_all_zone_arr){
			foreach($result as $arr_ad_to_zone){
				$sql_sel="select * from ad_to_zone where adid=".$arr_ad_to_zone['adid']." and zoneid=".$v_users_all_zone_arr." and approval=".$arr_ad_to_zone['approval']." and stickyad=".$arr_ad_to_zone['stickyad'];
				$query_sel=$this->db->query($sql_sel);
				$result_sel = $query_sel->num_rows();
				if($result_sel < 1){
					$newdata['adid'] = $arr_ad_to_zone['adid'];
					$newdata['zoneid'] = $v_users_all_zone_arr;
					$newdata['approval'] = $arr_ad_to_zone['approval'];
					$newdata['stickyad'] = $arr_ad_to_zone['stickyad'];
					$this->db->insert('ad_to_zone', $newdata);
				}
			}
		}
	}
	function get_business_update($id){
		$data['isverified']=1;
		$this->db->where('id', $id);
		$this->db->update('business', $data);
	}
	function get_ad_setting_pref_update($id=false){
		$data = array('isverified_businessowner' => 0);
		$this->db->where('businessid', $id);
		$this->db->update('ads_setting_preferences', $data);
	}
	function specific_business_information($id){
		$sql="select business_owner_id from business where id=".$id; //exit;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		echo $insql="select first_name,email from users where id=".$result[0]['business_owner_id'];
		exit;
		return $this->db->query($insql)->row();
	}
	function delete_business_ad_all_zone($busid,$zoneid){ // for current zone
		$explode_value=explode(',',$busid);
		foreach($explode_value as $bussinessid){
			$sql_ad="SELECT id from ads where business_id=".$bussinessid;
			$query_sel=$this->db->query($sql_ad);
			$result_sel = $query_sel->num_rows();
			$result=$query_sel->result_array();
			if(!empty($result)){
				foreach($result as $addid){
					$data = array();
					$data['adid'] = $addid;
					$this->db->delete('ad_to_zone', $data);
					
					$data1 = array();
					$data1['id'] = $addid;										
					$this->db->delete('ads', $data1);
				}
			
			}
			// business delete start
			$data = array();
			$data['businessid'] = $bussinessid;
			//$data['settingszoneid'] = $zoneid;						
			$this->db->delete('ads_setting_preferences', $data);
			
			$data2 = array();
			$data2['id'] = $bussinessid;										
			$this->db->delete('business', $data2);
			
			
		}
	}
	
	function delete_all_business_by_zone_owner($zoneid_arr,$param){
		//var_dump($zoneid_arr);
		$explode_zone=explode(',',$zoneid_arr);
		$allbusinessids=array();
		foreach($explode_zone as $zoneid){
			if($param=='nonlisted'){		
				$query = $this->db->query("SELECT b.id,b.name FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid=".$zoneid."  and a.approval IN(0,1,2,-1,-2) GROUP BY b.id");
			}else if($param=='listed'){		
				$query = $this->db->query("SELECT b.id,b.name FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid=".$zoneid."  and a.approval IN(3,-3) GROUP BY b.id");
				$result= $query->result_array() ;
				//var_dump($result[0]);
				foreach($result as $arr_business)
					$allbusinessids[$arr_business['id']]= $arr_business['id'];
			}
		}
		//var_dump($allbusinessidsarr_new);
		$allbusinessidsarr_new_imp=implode(',',$allbusinessids);
		//var_dump($allbusinessidsarr_new_imp);
		
		$this->delete_business_by_zone_owner($allbusinessidsarr_new_imp,$zoneid_arr);
	}
	function all_business_against_zone_old($zoneid,$param){
		//$allbusinessids=array();
		if($param=='nonlisted'){		
			$query_x = $this->db->query("SELECT group_concat(b.id) as busid FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid IN(".$zoneid.")   and a.approval IN(0,1,2,-1,-2)");
		}else if($param=='listed'){				
			$query_x = $this->db->query("SELECT group_concat(b.id) as busid FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid IN(".$zoneid.") and a.approval IN(3,-3)");
		}
			$result_x= $query_x->result_array() ; var_dump($result_x); exit;
			if(!empty($result_x)){
				$all_business_ids=$result_x[0]['busid'];
			}
			return $all_business_ids; 
			
	}
	
	
	function all_business_against_zone($zoneid,$param){ //var_dump($param); exit;
		$allbusinessids=array();
		$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;
		if($param=='nonlisted'){		
			/*echo "SELECT b.id,b.name FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid IN(".$zoneid.")  and a.approval IN(0,1,2,-1,-2) GROUP BY b.id";*/
			$query = $this->db->query("SELECT group_concat(b.id) as id FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid IN(".$zoneid.")  and a.approval IN(0,1,2,-1,-2)");
		}else if($param=='listed'){		
			/*$query = $this->db->query("SELECT b.id FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid IN(".$zoneid.")  and a.approval IN(3,-3)");*/
			
			$sql="SELECT group_concat(b.id) as id FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid IN(".$zoneid.")  and a.approval IN(3,-3)";
			$query = $this->db->query($sql);
		}
		$result= $query->result_array() ; 
		if(!empty($result)){
			$allbusinessids= $result[0]['id']; //echo '<br/>'; 
		}
		return $allbusinessids;	
			//var_dump($allbusinessids); exit;
			//$allbusinessids='';
			/*foreach($result as $arr_bussiness)
				$allbusinessids[$arr_bussiness['id']]= $arr_bussiness['id'];
		return implode(',',$allbusinessids);*/
	}
	//function delete_business_by_zone_owner_this_zone($busis_arr,$zoneid,$param){
	
	// Uploaded Business Delete
	function fn_uploaded_business_delete($busis_arr,$zoneid,$param){
		if($busis_arr==''){
			$busid=$this->all_business_against_zone($zoneid,$param);
		}else{
			$busid=$busis_arr;
		}
		$this->fn_delete_uploaded_businesses($busid,$zoneid);
	}
	function fn_delete_uploaded_businesses($busid,$zoneid){ 
		$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;				
		$sql_ad="SELECT group_concat(a.id) as adid from ads a, ad_to_zone b where a.business_id IN(".$busid.") AND a.id=b.adid and b.zoneid IN(".$zoneid.")";
		$query_ad=$this->db->query($sql_ad);
		$result_ad=$query_ad->result_array(); 
		if(!empty($result_ad)){
			$all_ad_ids= $result_ad[0]['adid'];  
		}
		
		$sql_bus="SELECT group_concat(a.id) as busid,group_concat(a.addressid) as addressid,group_concat(a.business_owner_id) as userid,group_concat(b.id) as prefid from business a, ads_setting_preferences b where a.id=b.businessid and a.id IN(".$busid.") and  b.settingszoneid IN(".$zoneid.")"; 
		$query_bus=$this->db->query($sql_bus);
		$result_bus=$query_bus->result_array();
		if(!empty($result_bus)){
			$all_pref_ids=$result_bus[0]['prefid'];
			$all_business_ids=$result_bus[0]['busid']; 
			$all_address_ids=$result_bus[0]['addressid'];
			$all_users_ids=$result_bus[0]['userid'];
		}
		//var_dump($all_pref_ids); var_dump($all_business_ids); var_dump($all_address_ids); var_dump($all_users_ids); var_dump($all_ad_ids); exit;
		// 1st check business then delete business 
		if($all_address_ids!=''){  	// Added on 16.6.14 for not deleting those addresses which have multiple business
			$address_ids = explode(',',$all_address_ids); 
			foreach($address_ids as $val){
				$sql = "SELECT * FROM business WHERE addressid =".$val;
				$query = $this->db->query($sql);		
				if($query->num_rows() == 1){ 
					$_delete_address = "delete from address WHERE id IN (".$val.")"; 
					$this->db->query($_delete_address) ;
				}
			}
		}
		// 1st check user then delete user 
		if($all_users_ids!=''){  	// Added on 17.6.14 for not deleting those users which have multiple business
			$users_ids = explode(',',$all_users_ids);
			foreach($users_ids as $val){
				$sql = "SELECT * FROM business WHERE business_owner_id =".$val;
				$query = $this->db->query($sql);
				if($query->num_rows() == 1){
					$_delete_users = "delete from users WHERE id IN (".$val.")";
					$this->db->query($_delete_users) ;
					$_delete_users_groups = "delete from users_groups WHERE user_id IN (".$val.")";
					$this->db->query($_delete_users_groups) ;
				}
			}
		}
		if($all_ad_ids!=''){
			$_delete_ad_to_zone = "delete from ad_to_zone WHERE adid IN (".$all_ad_ids.")"; 
			$this->db->query($_delete_ad_to_zone) ;
			$_delete_ads= "delete from ads WHERE id IN (".$all_ad_ids.")";
			$this->db->query($_delete_ads) ;
			$_delete_ads_cat_subcat= "delete from  ad_category_subcategory WHERE adid IN (".$all_ad_ids.") and zoneid IN(".$zoneid.")";
			$this->db->query($_delete_ads_cat_subcat) ;
		}
		if($all_business_ids!=''){
			$_delete_ad_setting_pref = "delete from ads_setting_preferences WHERE id IN (".$all_pref_ids.")";
			$this->db->query($_delete_ad_setting_pref) ;			
			$_delete_business = "delete from business WHERE id IN (".$all_business_ids.")";
			$this->db->query($_delete_business) ;			
		}
	}
	
	
	function fn_business_delete($busis_arr,$zoneid){ 
		if($busis_arr==''){
				$busid=$this->all_business_against_zone($zoneid,'nonlisted');
			}else{
				$busid=$busis_arr;
			}
			
			$this->fn_delete_businesses_nonlisted($busid,$zoneid);
		}
	
	function fn_delete_businesses_nonlisted($busid,$zoneid){ 
		
		//var_dump($busid); var_dump($zoneid);	 exit;			
		$arr_business_in_one_zone=array(); $arr_business_in_more_zone=array(); 
		$sql_one_bus="SELECT businessid FROM ads_setting_preferences where businessid IN(".$busid.") group by businessid having count(businessid)=1 ";				
		$query_one_bus=$this->db->query($sql_one_bus);
		$result_one_bus=$query_one_bus->result_array();
		if(!empty($result_one_bus)){
			foreach($result_one_bus as $arr_one_bus)
				$allbusinessids_bus[$arr_one_bus['businessid']]= $arr_one_bus['businessid'];				
			$arr_business_in_one_zone=implode(',',$allbusinessids_bus);
		}else{
			$arr_business_in_one_zone='';
		}
		$sql_more_bus="SELECT businessid FROM ads_setting_preferences where businessid IN(".$busid.") group by businessid having count(businessid)>1 ";				
		$query_more_bus=$this->db->query($sql_more_bus);
		$result_more_bus=$query_more_bus->result_array();
		if(!empty($result_more_bus)){
			foreach($result_more_bus as $arr_more_bus)
				$allbusinessids_more_bus[$arr_more_bus['businessid']]= $arr_more_bus['businessid'];
		
			$arr_business_in_more_zone=implode(',',$allbusinessids_more_bus);
		}else{
			$arr_business_in_more_zone='';
		}
		if($arr_business_in_one_zone!=''){
			$this->fn_business_delete_in_one_zone($arr_business_in_one_zone,$zoneid);
		}
		if($arr_business_in_more_zone!=''){
			$this->fn_business_delete_in_more_zone($arr_business_in_more_zone,$zoneid);
		}
		
	}
	
	function fn_business_delete_in_one_zone($arr_business_in_one_zone,$zoneid){
		$arr_users_id=array(); $all_business_ids=''; $all_address_ids=''; $all_users_ids=''; $all_ad_ids=''; $arr_uid=array();
		$session_zoneid_arr=$this->session->userdata('session_zoneid');
		$session_userid=$session_zoneid_arr['sesuserid'];
		// if($session_userid==false) continue; //pending
		$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;						
		$sql_ad="SELECT group_concat(a.id) as adid from ads a, ad_to_zone b where a.business_id IN(".$arr_business_in_one_zone.") AND a.id=b.adid and b.zoneid IN(".$zoneid.")";
		$query_ad=$this->db->query($sql_ad);
		$result_ad=$query_ad->result_array(); 
		if(!empty($result_ad)){
			$all_ad_ids= $result_ad[0]['adid']; 
		}
		
		//$sql_bus="SELECT group_concat(a.id) as busid,group_concat(a.addressid) as addressid,group_concat(a.business_owner_id) as userid from business a, ads_setting_preferences b where a.id=b.businessid and a.id IN(".$arr_business_in_one_zone.") and  b.settingszoneid IN(".$zoneid.") and a.business_owner_id!=".$session_userid;
		$sql_bus="SELECT group_concat(a.id) as busid,group_concat(a.addressid) as addressid,group_concat(a.business_owner_id) as userid from business a, ads_setting_preferences b where a.id=b.businessid and a.id IN(".$arr_business_in_one_zone.") and  b.settingszoneid IN(".$zoneid.")";   
		$query_bus=$this->db->query($sql_bus);
		$result_bus=$query_bus->result_array(); //var_dump($result_bus);
		if(!empty($result_bus)){
			$all_business_ids=$result_bus[0]['busid']; 
			$all_address_ids=$result_bus[0]['addressid']; 
			$all_users_ids=$result_bus[0]['userid']; 
		}
		$all_business_ids=$arr_business_in_one_zone;		
		$arr_users_id=explode(',',$all_users_ids);
		/*$index=array_search($session_userid,$arr_users_id); var_dump($index);
		if($index!==false){
			unset($arr_users_id[$index]);
		}*/
		//var_dump(array_unique($arr_users_id));
		$arr_uid=array_unique($arr_users_id);
		/*var_dump($arr_uid);
		var_dump($arr_uid);*/
		 
		/*while($key=array_search($session_userid,$arr_uid)){
			if($key!==false)
			unset($arr_uid[$key]);	
		}*/
		foreach($arr_uid as $key=>$v_arr_uid){
    		if($v_arr_uid==$session_userid)
  				unset($arr_uid[$key]);	
		}
		//echo '-----------';
		$all_users_ids=implode(',',$arr_uid); // anishdelete
		//var_dump($all_business_ids); var_dump($all_address_ids); var_dump($all_users_ids); var_dump($all_ad_ids); exit; 		
		if($all_ad_ids!=''){
			$_delete_ad_to_zone = "delete from ad_to_zone WHERE adid IN (".$all_ad_ids.")"; 
			$this->db->query($_delete_ad_to_zone) ;
			$_delete_ads= "delete from ads WHERE id IN (".$all_ad_ids.")";
			$this->db->query($_delete_ads) ;
			$_delete_ads_cat_subcat= "delete from  ad_category_subcategory WHERE adid IN (".$all_ad_ids.") and zoneid IN(".$zoneid.")";
			$this->db->query($_delete_ads_cat_subcat) ;
		}
		if($all_business_ids!=''){
			$_delete_ad_setting_pref = "delete from ads_setting_preferences WHERE businessid IN (".$all_business_ids.")";
			$this->db->query($_delete_ad_setting_pref) ;			
			$_delete_business = "delete from business WHERE id IN (".$all_business_ids.")";
			$this->db->query($_delete_business) ;
			$_delete_business_op_hrs = "delete from business_operation_hour WHERE business_id IN (".$all_business_ids.") and zone_id IN(".$zoneid.")";
			$this->db->query($_delete_business_op_hrs) ;
						
		}
		if($all_address_ids!=''){
			$_delete_address = "delete from address WHERE id IN (".$all_address_ids.")";
    		$this->db->query($_delete_address) ;
		}
		if($all_users_ids!=''){
			$_delete_users = "delete from users WHERE id IN (".$all_users_ids.")";
    		$this->db->query($_delete_users) ;
			$_delete_users_groups = "delete from users_groups WHERE user_id IN (".$all_users_ids.")";
    		$this->db->query($_delete_users_groups) ;
		}
		
	}
	function fn_business_delete_in_more_zone($arr_business_in_more_zone,$zoneid){ //var_dump($arr_business_in_more_zone); var_dump($zoneid); exit;
		$_delete_ad_setting_pref = "delete from ads_setting_preferences WHERE businessid IN (".$arr_business_in_more_zone.") and settingszoneid IN(".$zoneid.")";
		$this->db->query($_delete_ad_setting_pref) ;
	}
	function delete_business_by_zone_owner_all_zone($busis_arr,$zoneid_arr,$param){
		$allbusinessids=array();
		if($busis_arr==''){
			$explode_zone=explode(',',$zoneid_arr);
			foreach($explode_zone as $v_explode_zone){
				if($param=='nonlisted'){		
					$query = $this->db->query("SELECT b.id,b.name FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid=".$v_explode_zone."  and a.approval IN(0,1,2,-1,-2) GROUP BY b.id");
				}else if($param=='listed'){
				$query = $this->db->query("SELECT b.id,b.name FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid=".$v_explode_zone."  and a.approval IN(3,-3) GROUP BY b.id");
				}
				$result= $query->result_array() ;
				foreach($result as $v)
					$allbusinessids[$v['id']]=$v['id'];				
				
			}
			$busid=implode(',',$allbusinessids);
		}else{
			$busid=$busis_arr;
		}
		$explode_zone=explode(',',$zoneid_arr);
		foreach($explode_zone as $v_explode_zone){
			$this->fn_delete_businesses($busid,$v_explode_zone);
		}
	}
	
	
	
	function delete_business_by_zone_owner($busid,$zoneid_arr){ 
		$success=0;		
		$arrzones=explode(',',$zoneid_arr);
		foreach($arrzones as $zoneid){ 
			$arrbussiness=explode(',',$busid);
			foreach($arrbussiness as $bussinessid){ 
				//delete ads start
				$sql_ad="SELECT id from ads where business_id=".$bussinessid;
				$query_sel=$this->db->query($sql_ad);
				$result_sel = $query_sel->num_rows();
				$result=$query_sel->result_array();
				if($result_sel==1){ // this ad present only one zone				
					$data1 = array();
					$data1['adid'] = $result[0]['id'];
					$data1['zoneid'] = $zoneid;						
					$this->db->delete('ad_to_zone', $data1);
					$data2 = array();
					$data2['id'] = $result[0]['id'];
					//$data2['business_id'] = $val[$i];										
					$this->db->delete('ads', $data2);
					$success=1; 
				}else if($result_sel>1){ // this ad present more than one zone					
					foreach($result as $addid){
						//echo $_x['id']; echo '<br>';
						$sql_ad="SELECT id from ad_to_zone where adid=".$addid." and zoneid=".$zoneid;
						$query_sel=$this->db->query($sql_ad);
						$result_sel_1 = $query_sel->num_rows(); 					
						if($result_sel_1==1){ //echo $_x['id'];
							$data3 = array();
							$data3['adid'] = $addid;
							$data3['zoneid'] = $zoneid;						
							$this->db->delete('ad_to_zone', $data3);
							$data4 = array();
							$data4['id'] = $addid;
							$data4['business_id'] = $bussinessid;										
							$this->db->delete('ads', $data4);
							$success=1; 
						}
					}
				}
				// delete ads end
				if($success==1){ // i.e, ad is successfully deleted
					
					// delete business start
					$sql_business="select addressid,business_owner_id from business where id=".$bussinessid;
					$query_business=$this->db->query($sql_business);
					$result_business=$query_business->result_array();
					if(!empty($result_business)){
						$sql_ad_setting_pref="SELECT id from ads_setting_preferences where businessid=".$bussinessid;
						$query_ad_setting_pref=$this->db->query($sql_ad_setting_pref);
						$result_ad_setting_pref = $query_ad_setting_pref->num_rows(); //var_dump($result_ad_setting_pref);
						if($result_ad_setting_pref==1){ 
						// delete address start
						$sql_address="select id from business where addressid=".$result_business[0]['addressid'];
						$query_address=$this->db->query($sql_address);
						$result_address = $query_address->num_rows();
						if($result_address==1){
							$data5 = array();
							$data5['id'] = $result_business[0]['addressid']; 					
							$this->db->delete('address', $data5);
						}
						// delete address end
						// delete users start
						$sql_users="select id from business where business_owner_id=".$result_business[0]['business_owner_id'];
						$query_users=$this->db->query($sql_users);
						$result_users = $query_users->num_rows();
						if($result_users==1){
							$data6 = array();
							$data6['id'] = $result_business[0]['business_owner_id'];						
							//$this->db->delete('users', $data6);
							$data7 = array();
							$data7['user_id'] = $result_business[0]['business_owner_id']; 						
							//$this->db->delete('users_groups', $data7);
						}
						// delete users end
						
							$data8 = array();
							$data8['id'] = $bussinessid;						
							$this->db->delete('business', $data8);
						}
						$data9 = array(); 
						$data9['businessid'] = $bussinessid;
						$data9['settingszoneid'] = $zoneid;							
						$this->db->delete('ads_setting_preferences', $data9);
						// delete ad_setting_preferences start 
					}
					// delete business end
				}
			}
			//}
		}
	}
	
	
	function delete_business_ad_zone($busid,$zoneid){ // for current zone
		//var_dump($busid); var_dump($zoneid); exit;
		$arr_bussinesses=explode(',',$busid);
		foreach($arr_bussinesses as $bussinessid){
			// delete ads start 
			$sql_ad="SELECT id from ads where business_id=".$bussinessid;
			$query_sel=$this->db->query($sql_ad);
			$result_sel = $query_sel->num_rows();
			$result=$query_sel->result_array();
			//var_dump($result);
			if(!empty($result)){
				//var_dump($result);
				foreach($result as $addid){
					$sql_ad_to_zone="SELECT id from ad_to_zone where adid=".$addid;
					$query_sql_ad_to_zone=$this->db->query($sql_ad_to_zone);
					$result_inner_count = $query_sql_ad_to_zone->num_rows(); //echo '<br>';
					//delete
					$data = array();
					$data['adid'] = $addid;
					$data['zoneid'] = $zoneid;						
					$this->db->delete('ad_to_zone', $data);
					if($result_inner_count==1){
						$data = array();
						$data['id'] = $addid;										
						$this->db->delete('ads', $data);
					}
				}
			}
			// delete ads end
			// business delete start
			$sql_ad_setting_pref="SELECT id from ads_setting_preferences where businessid=".$bussinessid;
			$query_ad_setting_pref=$this->db->query($sql_ad_setting_pref);
			$result_ad_setting_pref = $query_ad_setting_pref->num_rows();
			//$result=$query_sel->result_array();
			$data = array();
			$data['businessid'] = $bussinessid;
			$data['settingszoneid'] = $zoneid;						
			$this->db->delete('ads_setting_preferences', $data);
			if($result_ad_setting_pref==1){
				$data = array();
				$data['id'] = $bussinessid;										
				$this->db->delete('business', $data);
			}
			// business delete end
		}
	}
	
	function delete_all_business_ad_zone($zoneid,$param){
		if($param=='nonlisted'){		
			$query = $this->db->query("SELECT b.id,b.name FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid=".$zoneid."  and a.approval IN(0,1,2,-1,-2) GROUP BY b.id");
		}else if($param=='listed'){		
			$query = $this->db->query("SELECT b.id,b.name FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid=".$zoneid."  and a.approval IN(3,-3) GROUP BY b.id");
		}
			$result= $query->result_array() ;
			//var_dump($result[0]);
			$arr_bussiness=array();
			foreach($result as $ads_setting_preferences)
				$arr_bussiness[$ads_setting_preferences['id']]= $ads_setting_preferences['id'];
				
			foreach($arr_bussiness as $bussinessid){
			// delete ads start 
			$sql_ad="SELECT id from ads where business_id=".$bussinessid;
			$query_sel=$this->db->query($sql_ad);
			$result_sel = $query_sel->num_rows();
			$result=$query_sel->result_array();
			//var_dump($result);
			if(!empty($result)){
				//var_dump($result);
				foreach($result as $addid){
					$sql_ad_to_zone="SELECT id from ad_to_zone where adid=".$addid;
					$query_sql_ad_to_zone=$this->db->query($sql_ad_to_zone);
					$result_inner_count = $query_sql_ad_to_zone->num_rows();
					//delete
					$data = array();
					$data['adid'] = $addid;
					$data['zoneid'] = $zoneid;						
					$this->db->delete('ad_to_zone', $data);
					if($result_inner_count==1){
						$data = array();
						$data['id'] = $addid;										
						$this->db->delete('ads', $data);
					}
				}
			}
			// delete ads end
			// business delete start
			$sql_ad_setting_pref="SELECT id from ads_setting_preferences where businessid=".$bussinessid;
			$query_ad_setting_pref=$this->db->query($sql_ad_setting_pref);
			$result_ad_setting_pref = $query_ad_setting_pref->num_rows();
			$data = array();
			$data['businessid'] = $bussinessid;
			$data['settingszoneid'] = $zoneid;						
			$this->db->delete('ads_setting_preferences', $data);
			if($result_ad_setting_pref==1){
				$data = array();
				$data['id'] = $bussinessid;										
				$this->db->delete('business', $data);
			}
			// business delete end
		}
			 
	}
	
	function verify_business_in_zone($busid,$option){
		//var_dump($busid);
		$explode_value=explode(',',$busid);
		foreach($explode_value as $bussinessid){
			$sql_ad="SELECT isverified from business where id=".$bussinessid;
			$query_sel=$this->db->query($sql_ad);
			$result=$query_sel->result_array();
			//var_dump($result);
			if($result[0]['isverified']==0){
				$data['isverified']=$option;
				$this->db->where('id', $bussinessid);
				$this->db->update('business', $data);
			}
		}
	}
	function unverify_business_in_zone($busid,$option){
		//var_dump($busid);
		$explode_value=explode(',',$busid);
		foreach($explode_value as $bussinessid){
			$sql_ad="SELECT isverified from business where id=".$bussinessid;
			$query_sel=$this->db->query($sql_ad);
			$result=$query_sel->result_array();
			//var_dump($result);
			if($result[0]['isverified']==1){
				$data['isverified']=$option;
				$this->db->where('id', $bussinessid);
				$this->db->update('business', $data);
			}
		}
	}
	
# + function change the status of the Duplicate businesses -> update the cat-subcat to -99 cat-subcat, is_duplicate=0
	function change_duplicate_business_status_in_zone($busid,$zoneid,$status,$inwhere,$duplicate_type){
		$explode_value=explode(',',$busid);	
		$explode_duplicate_type=explode(',',$duplicate_type);	
		foreach($explode_value as $bussinessid){
			if($bussinessid!=''){
				$sql = "UPDATE ads_setting_preferences a , ads b SET a.is_duplicate =0 , b.categoryid =-99 , b.subcategoryid =-99 WHERE a.businessid =".$bussinessid." AND b.business_id=".$bussinessid; 
				$result = $this->db->query($sql);
			}
		}
	}
# + function change the status of the Duplicate businesses
	
	function change_listed_business_status_in_zone($busid=0,$zoneid=0,$status=0,$inwhere=0){ 
		// var_dump($busid); var_dump($zoneid); var_dump($status); var_dump($inwhere); exit;
		$explode_value=explode(',',$busid);
		foreach($explode_value as $bussinessid){
			$data_x = array('approval' => $status,'isverified_businessowner' =>1);
			//var_dump($data_x);
			$this->db->where('businessid', $bussinessid);
			$this->db->where('settingszoneid', $zoneid);
			$this->db->update('ads_setting_preferences', $data_x);
			//echo $db->last_query(); exit;
		
			$data1 =array('isverified'=>1, 'timestamp' => time());
			//$data1['timestamp']=time();
			$this->db->where('id', $bussinessid);
			$this->db->update('business', $data1);
		 	
			//if($inwhere!=''){  
				$sql_ad="SELECT id from ads where business_id=".$bussinessid; 
				$query_sel=$this->db->query($sql_ad);
				$result=$query_sel->result_array(); //echo $this->$db->last_query();
				
				if(!empty($result)){
					if($inwhere==0 && ($status==1 || $status==2)){
						$data2=array('approval'=>1);
					}else if($inwhere==3 && ($status==1 || $status==2)){
						
						$data2=array('approval'=>1);
					}else if($inwhere==3 && $status=='-3'){
						
						$data2=array('approval'=>-1);
					}else if($inwhere==3 && $status=='3'){
						
						$data2=array('approval'=>1);
					}else if($inwhere=='-3'){
						
						$data2=array('approval'=>1);
					}
					
					$this->db->where('adid', $result[0]['id']);
					$this->db->where('zoneid', $zoneid);
					$this->db->update('ad_to_zone', $data2);
				}
			//}
		}
	}
	function change_business_status_in_zone($busid,$zoneid,$status,$bustype,$buszone=''){
		 $explode_value=explode(',',$busid); 
		 foreach($explode_value as $bussinessid){
			if($buszone!=2 && ($bustype==1 || $bustype==2)){
				$bus_status='-'.$bustype;
			}else if($buszone!=2 && ($bustype=='-1' || $bustype=='-2' || $bustype=='0')){
				$bus_status=$status;
			}
			 
			$data = array('approval' => $bus_status,'isverified_businessowner' =>1);
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
				//$data2['approval']='-1';
				if($buszone!=2 && ($bustype==1 || $bustype==2)){
					$data2['approval']='-1';
				}else if($buszone!=2 && ($bustype=='-1' || $bustype=='-2' || $bustype=='0')){
					$data2['approval']=1;
				}
				$this->db->where('adid', $result[0]['id']);
				$this->db->where('zoneid', $zoneid);
				$this->db->update('ad_to_zone', $data2);
			}
		 }
	}
	
	function business_activate_in_zone($busid,$zoneid,$option){
		$explode_value=explode(',',$busid);
		foreach($explode_value as $bussinessid){
			$data = array('approval' => $option);
			$this->db->where('businessid', $bussinessid);
			$this->db->where('settingszoneid', $zoneid);
			$this->db->update('ads_setting_preferences', $data);
			
			$sql="SELECT id FROM ads WHERE business_id=".$bussinessid;
			$query=$this->db->query($sql);
			$result=$query->result_array();
			$newdata=array();
			if(!empty($result)){
				foreach($result as $_x){
					$newdata['approval'] = $option;
					$this->db->where('adid', $_x['id']);
					$this->db->where('zoneid', $zoneid);
					$this->db->update('ad_to_zone', $newdata);
				}
			}
		}
		
	}
	
	function business_deactivate_in_zone($busid,$zoneid,$option){
		$option='-'.$option; 
		$explode_value=explode(',',$busid);
		foreach($explode_value as $bussinessid){
			$val[$i]=$explode_value[$i];
			$data = array('approval' => $option);
			$this->db->where('businessid', $bussinessid);
			$this->db->where('settingszoneid', $zoneid);
			$this->db->update('ads_setting_preferences', $data);
			
			$sql="SELECT id FROM ads WHERE business_id=".$bussinessid;
			$query=$this->db->query($sql);
			$result=$query->result_array();
			$newdata=array();
			if(!empty($result)){
				foreach($result as $_x){
					$newdata['approval'] = $option;
					$this->db->where('adid', $_x['id']);
					$this->db->where('zoneid', $zoneid);
					$this->db->update('ad_to_zone', $newdata);
				}
			}
		}
		
	}
	function listed_business_activate($busid,$zoneid){
		$explode_value=explode(',',$busid);
		foreach($explode_value as $bussinessid){
			$data = array('approval' => '3');
			$this->db->where('businessid', $bussinessid);
			$this->db->where('settingszoneid', $zoneid);
			$this->db->update('ads_setting_preferences', $data);
		}
		
	}
	
	function listed_business_deactivate($busid,$zoneid){
		$explode_value=explode(',',$busid);
		foreach($explode_value as $bussinessid){
			$data = array('approval' => '-3');
			$this->db->where('businessid', $bussinessid);
			$this->db->where('settingszoneid', $zoneid);
			$this->db->update('ads_setting_preferences', $data);
		}
		
	}
	
	 function check_business_to_zip($busname=false, $zipcode=false){ 
		$sql="select name from business a,address b where a.addressid=b.id and a.name='".addslashes($busname)."' and b.zip_code=".$zipcode;
		$query = $this->db->query($sql);
		$result_num = $query->num_rows(); 
		if($result_num>=1){
			$result = '';
			
		}else if($result_num==0){
			$result = $busname;
		}
		return $result;
	}
	function check_business_authentication($id = false){
		$common = new CommonController();
		$sql="select type,approval,isverified_businessowner,settingszoneid from ads_setting_preferences where businessid=$id";
		$result = $common->SelectRawquery($sql,'resultArray');
		if(!empty($result)){
			if($result[0]['type']==1){
				if($result[0]['isverified_businessowner']==1){
					$var='business';
					$type=2;
				}else if(($result[0]['approval']==1 || $result[0]['approval']==2 || $result[0]['approval']==-1 || $result[0]['approval']==-2) && $result[0]['isverified_businessowner']==0){
					$var='verification';
					$type=3;
					$session_zoneid_from_bus = array('buszoneid'=>$result[0]['settingszoneid'],'busid'=>$id);
					$common->setSession('session_zoneid_from_bus', $session_zoneid_from_bus);
					
				}else if(($result[0]['approval']==3 || $result[0]['approval']==-3)  && $result[0]['isverified_businessowner']==0){
					$var='listed';
					$type=4;
					$session_zoneid_from_bus = array('buszoneid'=>$result[0]['settingszoneid']);
					$common->setSession('session_zoneid_from_bus', $session_zoneid_from_bus);
				}
			}else if($result[0]['type']==2){
				if($result[0]['isverified_businessowner']==1){
					$var='franchisee';
					$type=2;
				}
			}
			$session_zoneid_from_bus = array('buszoneid'=>$result[0]['settingszoneid'],'busid'=>$id,'type'=>$var);
			$common->setSession('session_zoneid_from_bus', $session_zoneid_from_bus);
		}else{
			$var='home';
		}
		return $var;
	}
	function check_listed_business($id = false) {         
		$query=$this->db->query("select id from ads_setting_preferences where businessid=$id and approval=3 and isverified_businessowner=0");
        return $query->num_rows();
    }
	function update_ad_setting_pref_business_owner($id=false){
		$data = array('isverified_businessowner' => 1);
		$this->db->where('businessid', $id);
		$this->db->update('ads_setting_preferences', $data);
	}
	
################# + this is called when business owner log in for the first time and updates his account
	function update_business_business_owner($id=false,$bus_name=false,$bus_fname=false,$bus_lname=false,$bus_email=false,$bus_website=false,$street_address_1=false,$street_address_2=false,$bus_city=false,$bus_state=false,$bus_zip=false){
		
		$data = array('name' => $bus_name, 'contactfirstname' => $bus_fname, 'contactlastname' => $bus_lname, 'contactemail' => $bus_email, 'website' => $bus_website, 'isverified'=>1);
		$this->db->where('id', $id);
		$this->db->update('business', $data);
		
		$sql="select addressid from business where id=".$id;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		$addressid=$result[0]['addressid'];
		
		$newdata = array('street_address_1' => $street_address_1,'street_address_2' => $street_address_2, 'city' => $bus_city, 'state' => $bus_state, 'zip_code' => $bus_zip);
		$this->db->where('id', $addressid);
		$this->db->update('address', $newdata);
		$datad=array('isverified_businessowner'=>'1');
		$this->db->where('isverified_businessowner',1);
		$this->db->update('ads_setting_preferences',$datad);
	}
############### - this is called when business owner log in for the first time and updates his account
	
	function get_allsnapuser($businessid){
		$sql="select b.id,b.username,b.email from business_approved a,users b where a.user_id=b.id and a.business_id=".$businessid." and a.approved=1";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	public function get_all_business_details($zone_id){
    	$sql = "select asf.settingszoneid as zoneid,asf.businessid,asf.approval,b.id,b.business_owner_id,b.name as buisness_name,b.contactemail as buisness_email,u.id,u.username,u.email
,sz.id,sz.name as zone_name from (ads_setting_preferences as asf ,business as b,users as u ,sales_zone as sz) where (asf.settingszoneid=sz.id and asf.businessid=b.id and b.business_owner_id=u.id and asf.settingszoneid=".$zone_id." and asf.approval=1)";
    	$query = $this->db->query($sql);
    	return $query->result_array();
    }
	
	function get_org_owner_bulk($orgid){
		$sql="select b.id,b.username from snap_organization a,users b where a.userid=b.id and a.orgid=".$orgid;
		$query = $this->db->query($sql);
    	return $query->result_array();
	}
	function get_newsletter_by_business($id){
		$sql="select * from business_newsletter where businessid=".$id;
		$query = $this->db->query($sql);
    	$result=$query->result_array();
		if(!empty($result)){
			$result_1=$query->result_array();
			$result=$result_1[0]['approval'];
			//$result=1;
		}else{
			$result=0;
		}
		return $result;
	}
	
	function get_newsletter_users_by_business($id){
		$sql="select na.id,u.username,u.email from (users as u,newsletter_approved as na) where na.business_id=".$id." and na.user_id=u.id and na.status=1 and na.approved=1";
		$query = $this->db->query($sql);
    	$result=$query->result_array();		
		if(!empty($result))			
		{
			$result=$query->result_array();
		}
		else
		{
			$result='';
		}
		return $result;	
		
	//echo	$sql1="SELECT COUNT(business_id)  FROM newsletter_approved as a WHERE a.business_id=".$business_id; exit;
		
	}	
	////////////// Start count News Leter ////////////////
	function total_newsletter($business_id){
      $sql="SELECT COUNT(business_id) as bus_id  FROM newsletter_approved as a WHERE a.business_id=".$business_id;  
	  $query = $this->db->query($sql);
      $result=$query->result_array();
	  if(!empty($result))			
		{
			$result=$query->result_array();
		}
		else
		{
			$result='';
		}
		return $result;			
	}
   ////////////// End count News Leter ////////////////
	
	function update_newsletter_by_business($id=false,$status=false){
		$data=array();		
		$sql_user="select * from business_newsletter where businessid = '".$id."'";
    	$query_user=$this->db->query($sql_user);
    	$result = $query_user->row();    	    	
    	if(!empty($result)){    	
    		$data['approval']=$status;
    		$this->db->where('businessid', $id);
    		$this->db->update('business_newsletter', $data);
    	}else{    	
    		$data['approval']=$status;
			$data['businessid']=$id;
			$this->db->insert('business_newsletter', $data);
    	}
	}
	
	function getOperationHour($business_id=0,$zone_id=0){
		$this->CommonController = new CommonController();
		$result = $this->CommonController->SelectDataMultiWay('business_operation_hour','*','resultArray',['business_id' =>$business_id,'zone_id'=>$zone_id],[],'',[]);
		
		return $result;
	}
	
	function active_paid_trial_and_temp_cat($business_id=0){
		$sql = "SELECT a.businessid FROM ads_setting_preferences a, ads b, ad_category_subcategory c WHERE 
		a.businessid = b.business_id AND 
		b.id = c.adid AND 
        c.catid = -99 AND c.subcatid = -99 AND
		a.businessid = $business_id AND a.approval IN(1,2)" ;
		$query = $this->db->query($sql);
    	if($query->num_rows() > 0){
			return 1;
		}else{
			return 0;
		}
		
	}
	
# + get_all_referal_credit_businesses added on 13.11.14  -- this will get all the businesses who have got the referal credit.
	public function get_all_referal_credit_businesses($zone_id=0){
		if(!empty($zone_id)){
			$get_business = "SELECT a.settingszoneid , b.id , b.contactemail , b.name , b.id , b.referal_credit , c.phone , c.username FROM ads_setting_preferences a , business b , users c WHERE a.businessid = b.id AND b.business_owner_id = c.id AND b.referal_credit= 1 AND a.settingszoneid=".$zone_id;
			$query = $this->db->query($get_business);
			$result = $query->result_array();
			return $result;
		}
	}
# - get_all_referal_credit_businesses added on 13.11.14

	function get_bus_photo_details($businessid=0,$adsid=0){
		$sql="SELECT `od`.`order` ,`od`.`status`, `od`.`busphotosid` as pid, `od`.`bus_id` as bid, `o` . * FROM (`business_photos` AS o, `businessphotos_display` AS od) WHERE `od`.`bus_id` = $businessid AND od.busphotosid = o.id AND o.ad_id = $adsid ORDER BY `od`.`order` ASC ";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		//echo $this->db->last_query(); exit;
		return $result;
		
/*		$sql = "SELECT * FROM business_photos WHERE bus_id=$businessid AND ad_id=$adsid";
		$query = $this->db->query($sql);
		//echo $this->db->last_query(); exit;
    	$result=$query->result_array();	
		return $result;*/
	}
	
	function bus_photo_order_change($order,$bus_id,$ad_id){
		if ($order != '' && $bus_id != '' && $ad_id != ''){
			$trimvalue = rtrim($order,','); 
			$order_display = explode(',',$trimvalue);
			
			foreach ($order_display as $key=>$banner_data) {
				$banner_value = explode('_',$banner_data);  
				//$banner_display_data=array('order'=>$key+1);//var_dump($banner_display_data);exit;
				//$banner_display_where = array('busphotosid'=>$banner_value[1]);
				//$banner_display_where = array('busphotosid'=>$banner_value[1],'bus_id'=>$bus_id, 'ad_id'=>$ad_id);
				//$this->db->where($banner_display_where);
				//$this->db->update('businessphotos_display',$banner_display_data);
				$x = $key+1;
				//echo $sql = "UPDATE `businessphotos_display SET order = ".$x." WHERE busphotosid =".$banner_value[1]; 
				$sql = "UPDATE `businessphotos_display` SET `order`= $x WHERE `bus_id`=".$bus_id." AND `ad_id`=".$ad_id." AND `busphotosid`= ".$banner_value[1];
				$result = $this->db->query($sql);
			}
		}
	}
		
	public function save_bus_photo_new($image_name='', $bus_id=0, $ad_id=0){ 
		$this->CommonController = new CommonController();
		$sql_order = "SELECT (MAX(`order`)+1) as neworder FROM businessphotos_display WHERE `bus_id` =".$bus_id." AND ad_id=".$ad_id;

		$order = $this->CommonController->SelectRawquery($sql_order,'resultArray');
		$order_val = !empty($order[0]['neworder']) ? $order[0]['neworder'] : 1;
		$data=array('image_name'=>$image_name,'bus_id'=>$bus_id,'ad_id'=>$ad_id,'timestamp'=>time());
		$bus_photo_id = $this->CommonController->InsertData('business_photos', $data);
		$data_photo_display=array('busphotosid'=>$bus_photo_id , 'bus_id'=>$bus_id,'ad_id'=>$ad_id, 'order'=>$order_val,'status'=>1);
		$this->CommonController->InsertData('businessphotos_display', $data_photo_display);
		if($ad_id != '' || $ad_id != 0){
			$data_ads['timestamp']=time();
			$this->CommonController->updateData('ads',$data_ads,['id'=> $ad_id]);
		}
	}
	
	function delete_bus_photo($photo_id=0,$bus_id=0,$ad_id=0,$image_name='',$zoneid=0){
		if($photo_id!=0){
			$data_where_display=array('busphotosid'=>$photo_id,'ad_id'=>$ad_id,'bus_id'=>$bus_id);
			$this->db->where($data_where_display);
			$this->db->delete('businessphotos_display');
			
			$data_where=array('id'=>$photo_id,'ad_id'=>$ad_id,'bus_id'=>$bus_id);
			$this->db->where($data_where);
			$this->db->delete('business_photos');
			unlink('uploads/businessphoto/'.$bus_id.'/'.$image_name.'');
			if($ad_id != '' || $ad_id != 0){
			$data_ads['timestamp']=time();
			$this->db->where('id', $ad_id);
			$this->db->update('ads', $data_ads);
		}
			
		}
	}
	// + Time Zone List
	function gettimezonelist(){
		$query = $this->db->query("SELECT timezoneid, timezonename FROM timezone");
		$result = $query->result_array();
		return $result;
	}
	public function get_all_sponsored_businessd() {
		$sql="SELECT * FROM business_sponsor WHERE status=1";
		$result = $this->db->query($sql);
		
	}


	/**
	  * GET BUSINESS DETAILS BY BUSINESS USERS ID
	  * @desc fetch business details by owner userId
	  * @param $userId int
	  * @return array
	*/
	public function getBusinessByOwnerUserId($userId) {
		$query = $this->db->table('business')->select('id,name')->where('business_owner_id', $userId)->get();
        return $query->getRow();
	}
	
	// - Time Zone List
	public function get_business_details_by_id($busid){
		$this->CommonController = new CommonController();
		
		$sql="SELECT * FROM business WHERE id=".$busid;
		$result = $this->CommonController->SelectRawquery($sql,'resultArray');
		if(count($result) > 0){
			return $result[0];
		}else{
			return false;
		}
	}
}


