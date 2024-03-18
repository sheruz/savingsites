<?php
namespace App\Models\admin;

use CodeIgniter\Model;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Sales_zone extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->CommonController = new CommonController();
    }
	
	function clear_cache()

    {

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma: no-cache");

    }

	

    public function get_all_zones()

    {

        $query = $this->db->query('select t1.*, t2.last_name as lastname, t2.first_name as firstname from  sales_zone

                                   as t1 inner join users as t2 on t1.sales_rep_id = t2.id order by t1.name');

        return $query->result_array();

    }

     public function get_ads_miles($zoneid=0,$adid=''){

		$sql="select estimate_miles , delivery_charges  from  ads where id='".$adid."'";

		$query = $this->db->query($sql);

		$result=$query->result_array();

		return $result[0];


	}
	
	public function generate_referalcode($length = 10){
		return substr(md5(time()), 0, $length);
	}
	
	public function check_unique_referral(){
		$code = $this->generate_referalcode(10);
        $sql="select  count(referral_code) as total from  users where 	referral_code='".$code."'";
        $result = $this->CommonController->SelectRawquery($sql,'resultArray');
		if($result[0]['total'] != 0){
			$this->check_unique_referral($code);
		}else{
			return  $code;
		}       
	}


// checking   referral code validation
    public function validate_referral($code1){
   

            $code  =  $this->generate_referalcode(10);
            $sql1="select  count(referral_code) as total from  users where 	referral_code = '".$code1."'";
			$query1 = $this->db->query($sql1);
			$result1 = $query1->getResultArray();  

		 return $result1[0]['total'];
			
             
     }



// checking and updating the referral for business users 
	 function get_referral_code($businessid=0){

        $sql="select  users.referral_code  from  business inner join users on users.id = business.business_owner_id  where business.id='".$businessid."'";
		$query = $this->db->query($sql);
		$result=$query->result_array();
 

		if($result[0]['referral_code'] != '' ){
	        return $result[0]['referral_code'];
		}else{	  
        
	        $referalcode = $this->check_unique_referral();

	        $get_org_owner_id = "SELECT business_owner_id FROM business WHERE id=".$businessid; 

				$query1 = $this->db->query($get_org_owner_id);

				$result1 = $query1->result_array();

	        $bus_owner_id = $result1[0]['business_owner_id'];


			$data = array('referral_code' => $referalcode);

	        $this->db->where('id', $bus_owner_id);

	        $this->db->update('users', $data);
	        
	        return  $referalcode;                
		   
		} 

	  
	 }
	
	public function get_referral_organisation_code($orgid=0){
		$sql="select  users.refer_code_link from  organization  inner join users on users.id = organization.userid where organization.id='".$orgid."'";
		$result = $this->CommonController->SelectRawquery($sql,'rowArray');
		if(is_array($result)){
	        return $result['refer_code_link'];
		}else{	  
        	$referalcode = $this->check_unique_referral();
			$get_org_owner_id = "SELECT userid FROM organization WHERE id=".$orgid;
	        $result1 = $this->CommonController->SelectRawquery($get_org_owner_id,'rowArray');
			$organization_owner_id = isset($result1[0]['userid'])?$result1[0]['userid']:'';
			$this->CommonController->updateData('users',array('referral_code' => $referalcode),['id' => $organization_owner_id]);
			return  $referalcode;                
		} 
	}



// checking and updating the referral for business users 
	public function get_referral_resident_code($userid=0){ //conpleted
		$sql="select  users.referral_code  from  users   where users.id='".$userid."'";
        $result = $this->CommonController->SelectRawquery($sql, 'resultArray');
		if($result[0]['referral_code'] != '' ){
	    	return $result[0]['referral_code'];
		}else{	  
        	$referalcode = $this->check_unique_referral();
        	$this->CommonController->updateData('users',['referral_code' => $referalcode],['id'=> $userid]);
			return  $referalcode;                
		} 
	}
	
	public function zone_owner_login($id){
		$sql="select a.id,a.name,a.sales_rep_id,b.status,b.last_name as lastname, b.first_name as firstname from sales_zone a,users b where a.sales_rep_id=b.id and a.sales_rep_id=".$id." limit 0,1";
		$query=$this->db->query($sql);
		$result=$query->getResultArray();
		return $result;
	}

	 

	 

# + checked_unchecked --> Get the is_exist_other_zones value => 1->exist in other zones ; 0->does not exist in other zones // Added on 13/8/14

	public function checked_unchecked($businessid){

		$sql = "SELECT settingszoneid , is_exist_other_zone , businessid FROM ads_setting_preferences WHERE businessid=".$businessid." AND  is_exist_other_zone=1";

		$query = $this->db->query($sql);

		$result = $query->result_array();

		$zone_ids = array();

		foreach($result as $get_zone_ids){ 

			$zone_ids[] = $get_zone_ids['settingszoneid'];

		}

		$zone_ids = implode(',',$zone_ids);

		return $zone_ids;

	}

# - checked_unchecked
	public function get_zones_for_user($id = 0){       
		$query = $this->db->query("select t1.*, t2.last_name as lastname, t2.first_name as firstname from  sales_zone as t1 inner join users as t2 on t1.sales_rep_id = t2.id where t1.sales_rep_id = $id
			
			or (t1.id IN (select zone_id from zone_managers where user_id = $id))order by t1.name");
		return $query->getResultArray();

    }

    public function business_zone($id){
		$query = "SELECT settingszoneid as zoneid FROM ads_setting_preferences where businessid = $id LIMIT 1";
		$row = $this->CommonController->SelectRawquery($query);
      	return $row;
      }

	public function realtor_zone($id){

		$query = $this->db->query("SELECT zoneid FROM realtor where id = $id LIMIT 1");

        $row = $query->result_array();;

        return $row;

	}

	public function changeTheme($theme='',$zone_id=0){
		$data=array('theme_color'=>$theme);
		if ($theme!="all") {
			$this->CommonController->updateData('sales_zone',$data,['id' =>$zone_id]);
		}elseif($theme=="all"){
			$query = "SELECT * FROM sales_zone where id = '$zone_id' LIMIT 1";
			$row = $this->CommonController->SelectRawquery($query, 'row');
			return $row;	
		}
	}

	public function get_zone($id){
		$id = trim(rawurldecode($id)) ;
		$query = $this->db->query("SELECT * FROM sales_zone where id = $id LIMIT 1");
		$row = $query->getRow();
		return $row;
	}

    public function get_zone_by_name($name)

    {

        $query = $this->db->query("SELECT * FROM sales_zone where name = '$name' LIMIT 1");

        $row = $query->row();

        return $row;

    }

	public function get_zone_by_seo_name($seo_name){
		// $seo_name=preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ', '-',htmlentities(trim($seo_name))));
	
		$sql = "SELECT id,seo_zone_name FROM sales_zone where seo_zone_name = '$seo_name' LIMIT 1";
		$result = $this->CommonController->SelectRawquery($sql,'row');
		return $result;
	}

	

# + Get the count of BCS business form the zone  	

	public function get_bcs_count_for_zone($zoneId){
   

		 $query = $this->db->query("select a.* from ad_category_subcategory a,ads b, ads_setting_preferences c where c.approval =3 and  b.business_id=c.businessid and a.zoneid=$zoneId and a.adid=b.id ");	

		$result = count($query->result_array());

		return $result;

	}

# - Get the count of BCS business form the zone



# + zone_where_ads_are_visible

	public function zone_where_ads_are_visible($businessid){

		$sql = "SELECT a.name, b.* FROM sales_zone a, ads_setting_preferences b WHERE b.businessid=".$businessid." AND b.settingszoneid=a.id";

		$query = $this->db->query($sql);

		$res = $query->result_array();

		return $res;

	}

# - zone_where_ads_are_visible



# + To get the approval status of the businesses so as to modify the Default Ads Settings view and its messages

	/*public function get_default_zones_for_ad_pref($businessid,$zone_id){

		$sql = "SELECT approval FROM ads_setting_preferences WHERE businessid=".$businessid." AND settingszoneid=".$zone_id;

		$query = $this->db->query($sql);

		$res = $query->result_arrya();

		return $res;

	} */

# - To get the approval status of the businesses so as to modify the Default Ads Settings view and its messages



	public function get_zone_by_name_url($name)

    {

        $query = $this->db->query("SELECT * FROM sales_zone where name = '$name' LIMIT 1");

        $row = $query->result_array();

        return $row;

    }



    public function get_all_zones_business_is_in($id)

    {

        $query = $this->db->query('SELECT t1 . * ,t4.act_deact, t2.last_name AS lastname, t2.first_name AS firstname FROM sales_zone AS t1 

        		INNER JOIN users AS t2 ON t1.sales_rep_id = t2.id

		    	INNER JOIN business_to_zone AS t4 ON t1.id = t4.zone_id WHERE t4.business_id =? ORDER BY t1.name', array($id));

        return $query->result_array();



    }

    

    function requestZoneAdd($id,$zone)

    {

    	$data = array();

    	$data['business_id'] = $id;

    	$data['zone_id'] = $zone;

    	$data['act_deact'] = '0';

    	$data['date_added'] = date('Y-m-d H:i:s');

    	

    	$this->db->insert('business_to_zone', $data);

    	return $this->get_all_zones_business_is_in($id);

    }

	

    public function get_all_zones_business_not_in($id)

    {

        $query = $this->db->query('select t1.*, t2.last_name as lastname, t2.first_name as firstname from  sales_zone

                                   as t1 inner join users as t2 on t1.sales_rep_id = t2.id

                                   where t1.id not in (select zone_id from business_to_zone where business_id = ?)

                                   order by t1.name', array($id));		 

        return $query->result_array();



    }

	

	

	

    public function generate_csv_for_zone($id)

    {



    }



    public function get_excluded_categories($zoneId)

    {

        $data = array("-1");



        $results = $this->db->query("select * from category_exluded where zone_id = $zoneId")->result_array();



        foreach($results as $result)

        {

            $data[] = $result['category_id'];

        }





        return $data;

    }

    public function update_category_selection($zoneId, $category_option, $categories = false){

        $data = array('category_option' => $category_option);

        $this->db->where('id', $zoneId);

        $this->db->update('sales_zone', $data);



        $this->db->where('zone_id', $zoneId);

        $this->db->delete('category_exluded');



        if( ($category_option == 2) && !empty($categories))

        {

            $data = array();

            foreach($categories as $category_id){

                $data[] = array("zone_id" => $zoneId, "category_id" => $category_id);

            }

            $this->db->insert_batch('category_exluded', $data);

        }

    }

    public function rename_zone($zoneId, $zoneName, $category_option = false){ 

        $data = array(

            'name' => trim($zoneName),

			'seo_zone_name'=>preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ', '-',htmlentities(trim($zoneName))))

        );

        if(!empty($category_option)){$data['category_option'] = $category_option;}



     

	    $sql="select name,seo_zone_name from sales_zone where name='".$zoneName."'";

		$query = $this->db->query($sql);

		$result_num = $query->num_rows(); 

		if($result_num>=1){

			$zoneId = '0';

		}else{

			$this->db->where('id', $zoneId);

            $this->db->update('sales_zone', $data);

		    return $zoneId;

		}

    }



    public function create($name, $repid, $category_option = false){

        $data = array(

            'name' => $name,

            'sales_rep_id' => $repid,

			'seo_zone_name'=>preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ', '-',htmlentities(trim($name))))

        );

        if(!empty($category_option)){$data['category_option'] = $category_option;}

        $this->db->insert('sales_zone', $data);

        $zoneid = $this->db->insert_id();

		

		$newdata = array(

            'zoneid' => $zoneid,			

            'auto_approve_paid_ad_myzone' => 1,			

			'auto_approve_paid_specific_ad_myzone' => '',

            'auto_approve_paid_ad_locatedmyzone' => 1,

			'auto_approve_paid_specific_ad_locatedmyzone' => '',			

			'auto_approve_trial_ad_myzone' => 0,

			'auto_approve_trial_specific_ad_myzone' => '',

            'auto_approve_trial_ad_locatedmyzone' => 0,

			'auto_approve_trial_specific_ad_locatedmyzone' => '',			

			'auto_approve_paid_business_myzone' => 1,

			'auto_approve_paid_business_locatedmyzone' => 1,

            'auto_approve_trial_business_myzone' => 0,

			'auto_approve_trial_business_locatedmyzone' => 0,

			'auto_approve_offers_announcements' => 3,

			'auto_approve_banner' => 1

        );       

        $this->db->insert('zone_preferences', $newdata);

		$default_cat=array(

			'catid'=>'-99',

			'zoneid'=>$zoneid

		);

		$this->db->insert('category_display', $default_cat);

		

		$default_subcat=array(

			'subcatid'=>'-99',

			'catid'=>'-99',

			'zoneid'=>$zoneid

		);



		$this->db->insert('subcategory_display', $default_subcat);

		//// Default banner

		for($i=1;$i<=15;$i++){

			$default_banner = array(

				'banner_id'=>$i,

				'zone_id'=>$zoneid,

				'order'=>$i,

				'status'=>'1'

			) ;

			$this->db->insert('banner_display', $default_banner);

		}

        return $zoneid;

    }

### Athena eSolutions Start

	

	// this function is calling from dashboards.php in business function

	// this function get the all ziped zone for ad setting preferences

	public function get_all_ziped_zone_for_ad_pref($id)

	{

		$sql="SELECT b.sales_rep_id as uid FROM ads_setting_preferences a,sales_zone b WHERE a.settingszoneid=b.id and a.isdefault IN(0,1)"." AND a.businessid=".$id;

		$query=$this->db->query($sql);

		$result=$query->result_array();

		if(!empty($result)){

			$sql_inner="SELECT id,name FROM sales_zone WHERE sales_rep_id=".$result[0]['uid']." AND id NOT IN (select settingszoneid  from ads_setting_preferences where businessid = ".$id.")";

			$query_inner = $this->db->query($sql_inner);

			return $query_inner->result_array();

		}

	}

	

	function get_all_zones_for_business_dashboard($id){

		$sql_inner="SELECT id,name FROM sales_zone WHERE id NOT IN (".$id.",1,-1)";

			$query_inner = $this->db->query($sql_inner);

			return $query_inner->result_array();

	}

	

	public function get_all_zones_for_ad_pref($id)

    {

		$sql="SELECT a.businessid,a.settingszoneid,b.name FROM  ads_setting_preferences a,sales_zone b WHERE a.settingszoneid=b.id and a.businessid=".$id." and isdefault=0";

		$query= $this->db->query($sql);

		

		return $query->result_array();



    }

	function save_default_zone_ads_pref($id,$businesstype)

    {

		$sql="select zone_id from business_to_zone where business_id =".$id;		

		$query= $this->db->query($sql);

		

		$results=$query->result_array();

		

		$data = array(); 		

    	foreach($results as $result)

        {

            $data['settingszoneid'] = $result['zone_id'];

			$sql_zone_pref="SELECT * FROM zone_preferences WHERE zoneid=".$result['zone_id'];

			$query_1 = $this->db->query($sql_zone_pref);

			$query=$query_1->result_array();

			if(!empty($query)){

				if($query[0]['autoapprove_business']==1){

					$data['approval'] = 1;

				}else{

					$data['approval'] = 0;

				}

			}else{

				

				$data['approval']=0;

			}

				

			

			 

        }	

		$data['businessid'] = $id;

		$data['isdefault'] = 1;

    	$this->db->insert('ads_setting_preferences', $data);

    }





	function save_zone_ads_pref($id,$zone,$checkbox_value,$current_zoneid=0)

    {

    	$sql_a="SELECT approval FROM ads_setting_preferences WHERE businessid=".$id." and settingszoneid=".$current_zoneid;

		$query_a= $this->db->query($sql_a);		

		$res=$query_a->result_array(); 

		if(!empty($res)){

			$app=$res[0]['approval'];

		}else{

			$app=1;

		}

			

		// for zone preferences

		$data = array();

		$data['businessid'] = $id;

		$data['settingszoneid'] = $zone;		

		$data['isdefault'] = 0;

		$data['approval']=$app;

    	$this->db->insert('ads_setting_preferences', $data);

		

		if($checkbox_value==1){

			$sql="SELECT id FROM ads WHERE business_id=".$id;

			//echo $sql;

			$query_1= $this->db->query($sql);		

			$query=$query_1->result_array();

			$newdata=array();

			if(!empty($query)){

				foreach($query as $_x){

					$newdata['adid'] = $_x['id'];

					$newdata['zoneid'] = $zone;

					$newdata['approval'] = 1;

					

					$this->db->insert('ad_to_zone', $newdata);

				}

			}

		}

		

		

    	return $this->get_all_zones_for_ad_pref($id);

    }

	// this function is calling from dashboard.php

	// this function delete the zone for ad setting preferences for a business

	function delete_zone_ads_pref($id=0,$zone=0,$checkbox_value='',$condition='')

    {

    	if($condition=='business_ad'){

			$data = array();

			$data['businessid'] = $id;

			$data['settingszoneid'] = $zone;						

			$this->db->delete('ads_setting_preferences', $data);

		}

		if($checkbox_value==1){

			$sql="SELECT id FROM ads WHERE business_id=".$id;

			//echo $sql;

			$query_1= $this->db->query($sql);		

			$query=$query_1->result_array();

			$newdata=array();

			if(!empty($query)){

				foreach($query as $_x){

					$newdata['adid'] = $_x['id'];

					$newdata['zoneid'] = $zone;

					

					

					$this->db->delete('ad_to_zone', $newdata);

				}

			}

		}

    	return $this->get_all_zones_for_ad_pref($id);

    }

	

	// this function is calling from dashboard.php

	// this function display the default zone for ad setting preferences for a business

	public function get_default_zones_for_ad_pref($id)

    {        

		$sql="SELECT a.businessid,a.settingszoneid,b.name FROM  ads_setting_preferences a,sales_zone b WHERE a.settingszoneid=b.id and a.businessid=".$id." and a.isdefault=1"; 		

		$query= $this->db->query($sql);

		

		return $query->result_array();



    }

	

	// this function is calling from dashboards.php in business function

	// this function get the all ziped zone for edit zone

	public function get_all_zone_for_ad($id)

	{			   

		/*$sql="SELECT a.id,a.name FROM sales_zone a,zip_code_zone b WHERE a.id=b.zone_id AND a.id NOT IN (select settingszoneid  from ads_setting_preferences where businessid = ".$id.") and a.name!='' group by a.id order by a.name";*/

		

		$sql="SELECT a.zoneid,b.name FROM ad_to_zone a,sales_zone b WHERE a.zoneid=b.id AND a.adid=".$id."  order by a.id";

		//echo $sql; exit;

		$query = $this->db->query($sql);

		return $query->result_array();	

	}

	

	function delete_zone_ads_display($adid,$zoneid)

    {

		$data = array();

    	$data['adid'] = $adid;

    	$data['zoneid'] = $zoneid;

    	$this->db->delete('ad_to_zone', $data);

    }

	

	function save_zone_ads_display($adid,$busid,$zoneid)

    {

    	$data = array();

    	$data['adid'] = $adid;

    	$data['zoneid'] = $zoneid;		

		$data['approval'] = 0;

		

    	$this->db->insert('ad_to_zone', $data);

    }

	

	public function get_all_ziped_zone_for_ad_select($id)

	{			   

		$sql="SELECT a.id,a.name FROM sales_zone a,zip_code_zone b WHERE a.id=b.zone_id AND a.id NOT IN (select zoneid  from ad_to_zone where adid = ".$id.") and a.name!='' group by a.id order by a.name";

		//echo $sql; exit;

		$query = $this->db->query($sql);

		return $query->result_array();	

	}

	

	public function get_default_settings_in_zone($id,$from=false)

	{	

		if($from=='directory'){

			$select = 'auto_approve_offers_announcements,auto_approve_banner';

		}else{

			$select = '*';

		}

		$sql="SELECT $select FROM zone_preferences WHERE zoneid=".trim(rawurldecode($id));		

		$query = $this->db->query($sql);

		return $query->getResultArray();	

	}

	

	function get_all_spzones($catid,$val=false){

		$sql="select b.id,b.name from category_to_zone a,sales_zone b where a.zoneid=b.id and a.catid=".$catid;

		$query = $this->db->query($sql);

		return $query->result_array();	

	}



	function check_zonename($zonename=false){

		//$seo_name=preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ', '-',htmlentities(trim($seo_name))));exit;		

		$sql="select name from sales_zone where name='".$zonename."'";

		$query = $this->db->query($sql);

		$result_num = $query->num_rows();

		if($result_num>=1){

			$result = '0';

			

		}else if($result_num==0){

			$result = $zonename;

		}

		

		return $result;

	}

	function get_all_zones_by_user($id,$uid){ //var_dump($id); var_dump($uid);

		$sql="select id from sales_zone where sales_rep_id=".$uid." and id!=".$id;

		$query = $this->db->query($sql);

		$result=$query->result_array();

		$allmyzones = '' ;

		for($i=0;$i<count($result);$i++)

			$allmyzones .= $result[$i]['id']."," ;

		if($allmyzones != '') $allmyzones = substr($allmyzones,0,strlen($allmyzones)-1) ;

		return $allmyzones;

	}

	function users_all_zone($uid){ 

		$sql="select id from sales_zone where sales_rep_id=".$uid;

		$query = $this->db->query($sql);

		$result=$query->result_array();

		$allmyzones = '' ;

		for($i=0;$i<count($result);$i++)

			$allmyzones .= $result[$i]['id']."," ;

		if($allmyzones != '') $allmyzones = substr($allmyzones,0,strlen($allmyzones)-1) ;

		return $allmyzones;

	}

	function get_delete_zone($zoneid=0){

		$data = array();

		$data['id'] = $zoneid;										

		$this->db->delete('sales_zone', $data);

	}

	function get_delete_zone_old($zoneid=0){

		$sql_business="SELECT businessid from  ads_setting_preferences where settingszoneid=".$zoneid;

		$query_business=$this->db->query($sql_business);		

		$result=$query_business->result_array(); //var_dump($result); exit;

		if(!empty($result)){

			foreach($result as $val){

				$business_id=$val['businessid'];

				// Ad Delete Start

				$sql_ad="SELECT id from ads where business_id=".$business_id;

				$query_sel=$this->db->query($sql_ad);

				$result_ad=$query_sel->result_array();

				//var_dump($result_ad);

				if(!empty($result_ad)){

					foreach($result_ad as $val_1){

						$ad_id=$val_1['id']; //var_dump($ad_id);

						$sql_ad_to_zone="SELECT id from ad_to_zone where adid=".$ad_id;

						$query_sql_ad_to_zone=$this->db->query($sql_ad_to_zone);

						$result_inner_count = $query_sql_ad_to_zone->num_rows();

						//delete

						$data = array();

						$data['adid'] = $ad_id;

						$data['zoneid'] = $zoneid;

						$this->db->delete('ad_to_zone', $data);

						if($result_inner_count==1){

							$data = array();

							$data['id'] = $ad_id;										

							$this->db->delete('ads', $data);

						}	

					}

				}

				// Ad Delete End

				// Delete Business Start

				$sql_ad_setting_pref="SELECT id from ads_setting_preferences where businessid=".$business_id;

				$query_ad_setting_pref=$this->db->query($sql_ad_setting_pref);

				$result_ad_setting_pref = $query_ad_setting_pref->num_rows();

				$data = array();

				$data['businessid'] = $business_id;

				$data['settingszoneid'] = $zoneid;						

				$this->db->delete('ads_setting_preferences', $data);

				if($result_ad_setting_pref==1){

					$data = array();

					$data['id'] = $business_id;										

					$this->db->delete('business', $data);

				}

				// Delete Business End

				// Delete Barter Listing Start

				$sql_barter="SELECT id from  barter_listing where business_id=".$business_id;

				$query_barter=$this->db->query($sql_barter);		

				$result_barter=$query_barter->result_array();

				if(!empty($result_barter)){

					foreach($result_barter as $_barter){

						$data = array();

						$data['id'] = $_barter['id'];										

						$this->db->delete('barter_listing', $data);

					}

				}

				// Delete Barter Listing End 

				// Delete Job Listing Start

				$sql_job="SELECT id from job_listing where business_id=".$business_id;

				$query_job=$this->db->query($sql_job);		

				$result_job=$query_job->result_array();

				if(!empty($result_job)){

					foreach($result_job as $_job){

						$data = array();

						$data['id'] = $_job['id'];										

						$this->db->delete('job_listing', $data);

					}

				}

				// Delete Job Listing End

				   

			}

		}

		//else{ 

		// Sub Category Delete Start

		$sql_subcat="SELECT id from subcategory_display where zoneid=".$zoneid;

		$query_subcat=$this->db->query($sql_subcat);		

		$result_subcat=$query_subcat->result_array();

		if(!empty($result_subcat)){

			foreach($result_subcat as $_subcat){

				$data = array();

				$data['id'] = $_subcat['id'];										

				$this->db->delete('subcategory_display', $data);

			}

		}

		// Sub Category Delete End

		// Category Delete Start

		$sql_cat="SELECT id from category_display where zoneid=".$zoneid;

		$query_cat=$this->db->query($sql_cat);		

		$result_cat=$query_cat->result_array();

		if(!empty($result_cat)){

			foreach($result_cat as $_cat){

				$data = array();

				$data['id'] = $_cat['id'];										

				$this->db->delete('category_display', $data);

			}

		}

		// Category Delete End			

		// Announcement Delete Start

		$sql_ann="SELECT id from zone_announcement where zone_id=".$zoneid;

		$query_ann=$this->db->query($sql_ann);		

		$result_ann=$query_ann->result_array();

		if(!empty($result_ann)){

			foreach($result_ann as $_ann){

				$data = array();

				$data['id'] = $_ann['id'];										

				$this->db->delete('zone_announcement', $data);

			}

		}

		// Announcement Delete End

		// Organization Delete Start

		$sql_org="SELECT id from zone_organization where zoneid=".$zoneid;

		$query_org=$this->db->query($sql_org);		

		$result_org=$query_org->result_array();

		if(!empty($result_org)){

			foreach($result_org as $_org){

				$data = array();

				$data['id'] = $_org['id'];										

				$this->db->delete('zone_organization', $data);

			}

		}

		// Organization Delete End

		// Zip Code Delete Start

		$sql_zip="SELECT id from zip_code_zone where zone_id=".$zoneid;

		$query_zip=$this->db->query($sql_zip);		

		$result_zip=$query_zip->result_array();

		if(!empty($result_zip)){

			foreach($result_zip as $_zip){

				$data = array();

				$data['id'] = $_zip['id'];										

				$this->db->delete('zip_code_zone', $data);

			}

		}

		// Zip Code Delete End

		// Zone Delete Start

		$data = array();

		$data['id'] = $zoneid;										

		$this->db->delete('sales_zone', $data);

		// Zone Delete End

		//}

	}

	

	function get_all_zone_for_snap_user($userid=false){

		//echo "SELECT * FROM business_approved where user_id = $userid";

		

		$query = $this->db->query("SELECT * FROM business_approved where user_id = $userid");

        $row = $query->result_array();

        return $row;

	}

	

	function mm_zone(){

		$query = $this->db->query("SELECT b.id,b.name FROM marketing_materials a,sales_zone b where a.zoneid = b.id group by a.zoneid");

        $row = $query->result_array();

        return $row;

	}

	function get_market_materials($option=false, $uid=false){

		if($option=='me'){

			$where=" and a.createdby =".$uid;

		}else if($option=='all'){

			$where='';

		}else{

			$where=" and a.zoneid =".$option;

		}

		$query = $this->db->query("SELECT a.*,b.username,b.first_name,b.last_name FROM marketing_materials a,users b where a.createdby=b.id".$where." order by a.display_name asc");

        $row = $query->result_array();

        return $row;

	}

	function get_all_mm($zoneid){

        if(empty($zoneid)) { return false;}

		$query = $this->db->query("SELECT a.*,b.username,b.first_name,b.last_name FROM marketing_materials a,users b where a.createdby=b.id order by a.display_name asc ");

        $row = $query->result_array();

        return $row;

	}

	function delete_market_materials($id=false){

		$sql="select * from marketing_materials where id=".$id;

		$query = $this->db->query($sql);

		$result=$query->result_array();

		$file_info='mm_'.$result[0]['zoneid'].'~!~'.$result[0]['timestamp']."~!~".$result[0]['name'];

		if(file_exists('uploads/market_materials/'.$file_info)){

			unlink('uploads/market_materials/'.$file_info);		

			$this->db->where('id', $id);

        	$this->db->delete('marketing_materials');

		}

	}

	

	function check_org_username($zoneid=false , $orguname=false, $realtor_username=false){//var_dump($realtor_username);exit;

		

		//$sql_check = "select b.username from sales_zone a,users b where a.id=".$zoneid." and b.username='".$orguname."' and username  NOT IN ('".$orguname."')"; 

		//$sql = "select b.username from sales_zone a,users b where a.id=".$zoneid." and b.username='".$orguname."' and NOT IN (".$orguname.")";

		//$sql="select b.username from sales_zone a,users b where a.sales_rep_id=b.id and a.id=".$zoneid." and b.username='".$orguname."'";

		//echo "select b.username from sales_zone a,users b where a.id=".$zoneid." and b.username='".$orguname."'  NOT IN ('".$realtor_username."') "; exit;

		if(($orguname!==$realtor_username )){//var_dump($org_username_other);exit;

		$sql="select b.username from sales_zone a,users b where a.id=".$zoneid." and b.username='".$orguname."' ";

		$query = $this->db->query($sql);

		$result_num = $query->num_rows();

		if($result_num>=1){

			$result = '';

		}

		}else{

			$result = $orguname;

		}

		

		return $result;

		

	}

	

	function get_zone_id_againest_title($adtext=false){

		$sql="select c.id,c.name from ads a,ad_to_zone b,sales_zone c where a.id=b.adid and b.zoneid=c.id and a.search_engine_title='".$adtext."'";

		$query = $this->db->query($sql);

		$result=$query->row();

		return $result;

	}

	

	function get_all_uploaded_letters($zoneid){

		$query = $this->db->query("SELECT a.*,b.username,b.first_name,b.last_name FROM uploaded_letters a,users b where a.createdby=b.id and a.zoneid=".$zoneid." order by a.display_name asc");

        $row = $query->result_array();

        return $row;

	}

	function get_letters_by_id($id){

		$query = $this->db->query("SELECT * FROM uploaded_letters WHERE id=".$id);

        $row=$query->result_array();

		if($row && !empty($row))

		{

			foreach($row as $l);

		}

		$query = $this->db->query("SELECT organizationid FROM uploaded_letters_in_organization WHERE letterid=".$l['id']);

		$row1=$query->result_array();		

		

		if($row1 && $row1!='')

		{

			foreach($row1 as $org_id)

			{

			 $og_id[]=$org_id['organizationid'];

			}

		}

		if($og_id && !empty($og_id))

		{

			$organizationid=implode(',',$og_id);

			$row[0]['organizationid']=$organizationid;

		}

		return $row;

    }

	

	function get_letters_for_organization($id){

		$q="select b.*,c.username,c.first_name,c.last_name from uploaded_letters_in_organization a,uploaded_letters b,users c where a.letterid=b.id and b.createdby=c.id and a.organizationid=".$id." group by letterid order by b.timestamp desc";

		$r=$this->db->query($q)->result_array();

		return $r;

	}

	function delete_all_uploaded_letters($id=false){

		$sql="select * from uploaded_letters where id=".$id;

		$query = $this->db->query($sql);

		$result=$query->result_array();

		$file_info=$result[0]['zoneid'].'~!~'.$result[0]['timestamp']."~!~".$result[0]['name'];		

		if(file_exists('uploads/upload_letters/'.$file_info)){

			unlink('uploads/upload_letters/'.$file_info);		

			$this->db->where('letterid', $result[0]['id']);

        	$this->db->delete('uploaded_letters_in_organization');

			$this->db->where('id', $id);

        	$this->db->delete('uploaded_letters');

		}

	}

	function get_zones_by_business_id($bid){ 

		$sql="select b.name as zone_name,a.settingszoneid,c.* from ads_setting_preferences a,sales_zone b,users c where a.settingszoneid=b.id and b.sales_rep_id=c.id and a.businessid=".$bid;

		$result=$this->db->query($sql)->row();

		return $result;

	}

	function owner_against_zone($id=0){

		if($id==0){

			return $id;

		}else{

			$sql="select sales_rep_id from sales_zone where id='".$id."'";

			$query = $this->db->query($sql);

			$result=$query->result_array();

			if(!empty($result)){

				return $result;

			}else{

				return 0;

			}

		}		

	}

	function logout($return_page = false)

	{

		//var_dump($_COOKIE); exit;	

		$this->data['title'] = "Logout";

		//log the user out

		delete_cookie("theme"); delete_cookie("zoneid");

		delete_cookie("blog_username"); delete_cookie("blog_password"); delete_cookie("blog_zoneid"); delete_cookie("blog_businessid"); delete_cookie("back_to_blog"); delete_cookie("back_to_blog_path");

		//	

		if($this->session->userdata('usersessiondata')){ //echo 1; 

			$usersession_data = $this->session->userdata('usersessiondata');

			//var_dump($usersession_data);exit; 

     		$ugid = $usersession_data['usergrid'];

			$uzid = $usersession_data['userzoneid'];

			$this->session->unset_userdata('usersessiondata');

			$logout = $this->ion_auth->logout();

			$this->session->sess_destroy();

			//var_dump($this->session->all_userdata());exit;

			redirect('/', 'refresh');

			//redirect('/index.php?zone='.$uzid, 'refresh');

			/*redirect('/zone/load/'.$uzid, 'refresh');*/

		}else{ //echo 2; exit;

			$logout = $this->ion_auth->logout();

			$this->session->sess_destroy();

			$return_page = empty($return_page) ? $this->session->userdata("return_page") : $return_page;

			if(!empty($return_page))

			{

				redirect($return_page, 'refresh');

			}

			else

			{

				redirect('/', 'refresh');

			}

		}

	}

	

	function make_search_engine_title($zoneid=0,$business_id=0,$deal_title='',$deal_title_newad='',$adid=''){

		$sql="select name from sales_zone where id='".$zoneid."'";

		$query = $this->db->query($sql);

		$result=$query->result_array();

		$zone_name=$result[0]['name'];

		$sql_1="select name from business where id='".$business_id."'";

		$query_1 = $this->db->query($sql_1);

		$result_1=$query_1->result_array();

		$business_name=$result_1[0]['name'];

		if($adid!=0){

			$sql_2 = "SELECT count(*) as count_deal_title FROM ads WHERE deal_title='".$deal_title."' and id NOT IN ('".$adid."')";

			$query_2 = $this->db->query($sql_2);

			$result_2 = $query_2->result_array();

		}else{

			$sql_2 = "SELECT count(*) as count_deal_title FROM ads WHERE deal_title='".$deal_title."'";

			$query_2 = $this->db->query($sql_2);

			$result_2 = $query_2->result_array();	

		}

		if($result_2>0){

			return $zone_name.'#@!'.$business_name.'#@!'.$deal_title.'#@!'.$result_2[0]['count_deal_title'];

		}else{

			return $zone_name.'#@!'.$business_name.'#@!'.$deal_title;

		}

		//return $zone_name.'#@!'.$business_name.'#@!'.$deal_title;

	}

	function get_all_zone(){

		$sql = "SELECT * FROM sales_zone WHERE id NOT IN (-1,0,1) and active='1' ORDER BY name ASC";	

		$query = $this->db->query($sql);

		return $query->result_array();

	}

	

	/**

	* Function added on 03.02.2017

	* Get local stores by zoneid

	* 

	* @public

	*

	* @return : array of local stores of a zone

	*/

	public function get_all_localstores($zoneid){

        if(empty($zoneid)) { 

			return false;

		}

		$query = $this->db->query("SELECT a.* FROM zone_local_stores a where a.zone_id = ".$zoneid." order by a.timestamp desc ");

        $row = $query->result_array();

        return $row;

	}

	

	/**

	* Function added on 03.02.2017

	* Get local store details by storeid

	* 

	* @public

	*

	* @return : details of a local store

	*/

	public function get_localstore_details_by_id($storeid){

        if(empty($storeid)) { 

			return false;

		}

		$query = $this->db->query("SELECT a.* FROM zone_local_stores a where a.id = ".$storeid."");

        $row = $query->result_array();

        return $row;

	}

	

	/**

	* Function added on 03.02.2017

	* Delete local store by storeid

	* 

	* @public

	*

	*/

	public function delete_local_store($storeid){

        $this->db->where('id', $storeid);

        $this->db->delete('zone_local_stores');

	}

	

	/**

	* Function added on 03.02.2017

	* Get active local zones of a zone

	* 

	* @public

	*

	*/

	public function get_active_local_stores_zone($zoneid)

    {

		$zoneid = trim(rawurldecode($zoneid)) ;

		$query = $this->db->query("SELECT store_name, store_link FROM zone_local_stores where zone_id = ".$zoneid." AND status = '1'");

        $row = $query->result_array();

        return $row;

    }

	

	

	

	/**

	* Function added on 08.02.2017

	* Get real estates by zoneid

	* 

	* @public

	*

	* @return : array of real estates of a zone

	*/

	public function get_all_realestates($zoneid){

        if(empty($zoneid)) { 

			return false;

		}

		$query = $this->db->query("SELECT a.* FROM zone_real_estates a where a.zone_id = ".$zoneid." order by a.timestamp desc ");

        $row = $query->result_array();

        return $row;

	}

	

	/**

	* Function added on 08.02.2017

	* Get real estate details by realestateid

	* 

	* @public

	*

	* @return : details of a real estate

	*/

	public function get_realestate_details_by_id($realestateid){

        if(empty($realestateid)) { 

			return false;

		}

		$query = $this->db->query("SELECT a.* FROM zone_real_estates a where a.id = ".$realestateid."");

        $row = $query->result_array();

        return $row;

	}

	

	/**

	* Function added on 08.02.2017

	* Delete real estate by realestateid

	* 

	* @public

	*

	*/

	public function delete_real_estate($realestateid){

        $this->db->where('id', $realestateid);

        $this->db->delete('zone_real_estates');

	}

	

	/**

	* Function added on 08.02.2017

	* Get active real estates of a zone

	* 

	* @public

	*

	*/

	public function get_active_real_estates_zone($zoneid)

    {

		$zoneid = trim(rawurldecode($zoneid)) ;

		$query = $this->db->query("SELECT real_estate_name, real_estate_link FROM zone_real_estates where zone_id = ".$zoneid." AND status = '1'");

        $row = $query->result_array();

        return $row;

    }

	

	/**

	* Function added on 08.02.2017

	* Get autos by zoneid

	* 

	* @public

	*

	* @return : array of autos of a zone

	*/

	public function get_all_autos($zoneid){

        if(empty($zoneid)) { 

			return false;

		}

		$query = $this->db->query("SELECT a.* FROM zone_autos a where a.zone_id = ".$zoneid." order by a.timestamp desc ");

        $row = $query->result_array();

        return $row;

	}

	

	/**

	* Function added on 08.02.2017

	* Get autos details by autosid

	* 

	* @public

	*

	* @return : details of a autos

	*/

	public function get_autos_details_by_id($autosid){

        if(empty($autosid)) { 

			return false;

		}

		$query = $this->db->query("SELECT a.* FROM zone_autos a where a.id = ".$autosid."");

        $row = $query->result_array();

        return $row;

	}

	

	/**

	* Function added on 08.02.2017

	* Delete autos by autosid

	* 

	* @public

	*

	*/

	public function delete_autos($autosid){

        $this->db->where('id', $autosid);

        $this->db->delete('zone_autos');

	}

	

	/**

	* Function added on 08.02.2017

	* Get active autos of a zone

	* 

	* @public

	*

	*/

	public function get_active_autos_zone($zoneid)

    {

		$zoneid = trim(rawurldecode($zoneid)) ;

		$query = $this->db->query("SELECT autos_name, autos_link FROM zone_autos where zone_id = ".$zoneid." AND status = '1'");

        $row = $query->result_array();

        return $row;

	}

	

	public function get_grocery($id)

	{			

		$sql="SELECT coupon_link FROM zone_preferences WHERE zoneid=".$id;		

		$query = $this->db->query($sql);

		return $query->result_array();	

	}

	

}

