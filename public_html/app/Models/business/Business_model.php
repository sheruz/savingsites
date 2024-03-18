<?php
namespace App\Models\business;

use CodeIgniter\Model;
use App\Libraries\IonAuth;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Business_model extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->CommonController = new CommonController();
    } 
	
	public function business_details($businessid){	
		$result = $this->CommonController->SelectDataMultiWay('business','*','rowArray',['id' =>$businessid],[],'',[]);
		if($result != ''){
			return 	$result;
		}else{
			return 0;
		}
	}

	function business_ad_setting_pref_details($businessid){

		$this->db->where('businessid', $businessid);

		$this->db->select('approval');

		$this->db->from('ads_setting_preferences');

		

		$query = $this->db->get();

		//echo $this->db->last_query();

		$result=$query->result_array();

		$arr=(!empty($result[0])) ? $result[0] : 0; 

		return $arr;

	}

	////////////////////////////////////////////////// From Zone part Start /////////////////////////////////////////////

	

	

	

	////////////////////////////////////////////////// From Zone part End /////////////////////////////////////////////

	# + get_business_by_id

	public function get_business_by_id($id){
		$sql = "select t1.*,t2.street_address_1, t2.street_address_2, t2.city,t2.state,t2.zip_code,t2.phone,asf.approval from business as t1 left join address as t2 on t1.addressid = t2.id left join ads_setting_preferences as asf ON asf.businessid=t1.id where t1.id = " . $id . " LIMIT 1";			
		return $this->CommonController->SelectRawquery($sql,'row');
	}

	# - get_business_by_id

	

	# + get_zonename

	public function get_zonename($id)       

	{

		$sql="select t2.id,t2.name from ads_setting_preferences as t1 join sales_zone as t2 on t1.settingszoneid=t2.id where t1.businessid=".$id;

        return $this->db->query($sql)->row();

	}

	# - get_zonename

	

	# + get_business_type_by_id

	public function get_business_type_by_id($busid,$zoneid)

	{

		$sql="SELECT approval FROM ads_setting_preferences WHERE businessid=".$busid." and settingszoneid =".$zoneid;

		$query = $this->db->query($sql);

		if($query->row()){

			$result=$query->result_array();

			return $result[0];

		}else{

			return false;

		}

	}

	# - get_business_type_by_id

	

	

	public function check_title($ad_title,$ad_id){ //var_dump($ad_id);
		if($ad_title != ''){
			$sql_ad_title = "SELECT count(*) as count_num FROM ads WHERE deal_title='".$ad_title."' and id != '".$ad_id."'";
			$result = $this->CommonController->SelectRawquery($sql_ad_title,'resultArray');
			if($result>0){
				return $result[0]['count_num'];
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}

	

# + Called when the ads are edited , to check the existence of the same string deal title. Added on 28-10-14

	public function check_deal_title_in_edit($deal_title){//var_dump($deal_title);exit;

		$sql = "SELECT count(*) as count_deal_title FROM ads WHERE deal_title='".$deal_title."'";

		$query = $this->db->query($sql);

		$result = $query->result_array();

		if($result>0){

			return $result[0]['count_deal_title'];

		}else{

			return 0;

		}

	}

# - Called when the ads are edited , to check the existence of the same string deal title

		

# + check_start_time  --> To check weather this start time exits in the database with the same date  ; type = 1 -> Start ; Type = 2 -> Stop

	public function check_time_slot($business_id,$user_start_date,$user_end_date,$user_start_time,$user_end_time){

		//var_dump($business_id); var_dump($user_start_date); var_dump($user_end_date); var_dump($user_start_time); var_dump($user_end_time);	exit;

		//echo $sql="SELECT * FROM ads WHERE business_id=".$business_id." and startdate > '".$user_start_date."' AND enddate < '".$user_end_date."'";

		$flag=1;

		//$sql="SELECT id,starttime,stoptime FROM ads WHERE business_id=".$business_id." and '".$user_start_date."' > startdate and '".$user_start_date."' < enddate";

		

		$sql="SELECT id,starttime,stoptime FROM ads WHERE business_id=".$business_id." and '".$user_start_date."' >= startdate and '".$user_end_date."' <= enddate";

		

		$query = $this->db->query($sql);

		$result = $query->result_array(); //var_dump(count($result)); exit;

		if(!empty($result)){ //var_dump($result); echo "</br>";

			foreach($result as $results){//var_dump($user_start_time);var_dump($results['stoptime']);

				//var_dump($result); echo "</br>";

				//if($user_start_time>$results['starttime'] && $user_end_time<$results['stoptime']){ echo 0;

				if($user_start_time>=$results['stoptime'] && $user_end_time>$results['stoptime']){

					$flag=1;

				}else{

					$flag=0;

				}

			}

		}else{

			$flag=1;

		}

		return $flag;

	}

	

	public function check_date_time_old_1($business_id,$date_time,$type){ //var_dump($date_time);

		$date_time_explode = explode(' ',$date_time);

		$user_start_date = $date_time_explode[0]; 

		$user_start_time = $date_time_explode[1]; //var_dump($user_start_date);

		

		$user_start_time_explode=explode(":",substr($date_time,-5,5)); //var_dump($user_start_time);

		$user_start_time_hour = $user_start_time_explode[0] ;

		$user_start_time_min = $user_start_time_explode[1] ; //var_dump($user_start_time_1); var_dump($user_start_time_2);

		//$sql = "SELECT startdatetime,stopdatetime FROM ads WHERE business_id = ".$business_id;

		//echo $sql="SELECT startdatetime,stopdatetime FROM ads WHERE business_id = ".$business_id." and ".$user_start_date." > FROM_UNIXTIME(startdatetime) and ".$user_start_date." < FROM_UNIXTIME(stopdatetime)";

		$sql="SELECT SUBSTRING(startdatetime,12,100) AS starttime, SUBSTRING(stopdatetime,12,100) AS stoptime FROM ads WHERE business_id = ".$business_id." and '".$user_start_date."' > SUBSTRING(startdatetime,1,10) and '".$user_start_date."' < SUBSTRING(stopdatetime,1,10)";

		//$sql = "SELECT startdatetime, stopdatetime FROM ads WHERE business_id = ".$business_id." and '".$date_time."' > startdatetime and '".$date_time."' < stopdatetime";

		$query = $this->db->query($sql);

		$result = $query->result_array(); var_dump($result); exit;

		if(!empty($result)){

			foreach($result as $result){

				//var_dump($result['startdatetime']);

				$starttime_explode = $this->get_date_time($result['starttime']); //var_dump($starttime);

				$db_start_time_1 = $starttime_explode[0];

				$db_start_time_2 = $starttime_explode[1];

				$db_start_time_3 = $starttime_explode[2];

				$stoptime_explode = $this->get_date_time($result['stoptime']);

				$db_stop_time_1 = $stoptime_explode[0];

				$db_stop_time_2 = $stoptime_explode[1];

				$db_stop_time_3 = $stoptime_explode[2];

				//echo 'start time: hour=>'.$user_start_time_hour.'<br>start time: min=>'.$user_start_time_min.'<br>';

				//echo $user_start_time_2.'<br>a'.$db_start_time_1.'<br>b'.$user_start_time_2.'<br>c'.$db_stop_time_1.'<br><br>';

				for($i=$db_start_time_1; $i<=$db_stop_time_1; $i++){

					if($user_start_time_hour>=$i && $user_start_time_hour<=$i){ // if exist						

						return 0;

					}

				}

			}

			return 1; // if not exist	

		}else{			

			return 1; // first ad			

		}

				

				 

				//if($user_start_time_2 >= $db_start_time_2 ){

//					/*if($user_start_time_3 >= $db_start_time_3 && $user_start_time_3 <= $db_stop_time_3){

//						echo 1;

//					}*/

//					echo 1;

//				}else{

//					echo 2;

//				}

				

				/*$startdatetime_result =  $result['startdatetime'];

				$stopdatetime_result =  $result['stopdatetime'];

				$startdatetime_explode = $this->get_date_time($startdatetime_result); //var_dump($startdatetime); exit;

				$stopdatetime_explode  = $this->get_date_time($stopdatetime_result);

				$db_start_date = $startdatetime_explode[0]; 

				$db_start_time = $startdatetime_explode[1];

				$db_stop_date = $stopdatetime_explode[0]; 

				$db_stop_time = $stopdatetime_explode[1];*/

				/*if($user_start_date > $db_start_date && $user_start_date < $db_stop_date){

					if($user_start_time > $db_start_time && $user_start_time < $db_stop_time){

						//return 0; // fail - Cannot be seleted

						$a=0; // fail - Cannot be seleted

					}else{

						//return 1; // start date is in database but start time is not

						$a=1; // start date is in database but start time is not

					}

				}else{

					$a=5;

					//return 5;	// success					

				}*/

				/*if($a==2)

					return 4;*/	// fail -- no need			

			/*}

			return 1; // fail

		}else{			

			return 1; // first ad			

		}*/

	}

	# + get_date_time  ---> Split and get the exact date and time

 	public function get_date_time($date_time){

		$exploded_date_time = explode(':',$date_time);

		return $exploded_date_time;

	}

	# - get_date_time



	public function check_date_time_old($business_id,$date_time,$type){

		if(!empty($type)){

			if($type == 1)

			{

				//$start_date_time = $this->get_date_time($date_time);

				//$start_date = $start_date_time[0];  $start_time = $start_date_time[1];

				

				// Check weather the start date exists in the database

				//$sql = "SELECT startdatetime FROM ads WHERE business_id = ".$business_id." AND startdatetime = '".$date_time."'";

				echo $sql = "SELECT startdatetime,stopdatetime FROM ads WHERE business_id = ".$business_id;

				$query = $this->db->query($sql);

				$result = $query->num_rows();

				$start_values = $query->result_array(); var_dump($start_values);

					if($result == 0){ 

						return "success"; 

					}

					else if(!empty($start_values)){

						foreach($start_values as $user_val){

							$this->check_and_insert_multiple_ads($user_val,$business_id);

						}

					}

					else{

						return "failed"; 

					} 

			}

			else if($type == 2)

			{

				//$stop_date_time = $this->get_date_time($date_time);

				//$stop_date = $stop_date_time[0]; $stop_time = $stop_date_time[1];

				

				// Check weather the stop date exists in the database

				$sql = "SELECT stopdatetime FROM ads WHERE business_id = ".$business_id." AND stopdatetime = '".$date_time."'";  

				$query = $this->db->query($sql);

				$result = $query->num_rows();

				$end_results = $result->result_array();

					if($result == 0){ 

						return "success";

					}//$not_three = $this->check_and_insert_multiple_ads('',$imploded_stop);

					else{

						return "failed"; 

					} 

			}

		}

	}

# - check_start_time



# + insert the new values in the ads table if the entry is new

	public function check_and_insert_multiple_ads($user_val,$business_id){ // $start_values = Given time by the user

	// + user given values

		$user_date_time = $this->get_date_time($user_val);

		$user_date = $user_date_time[0]; 

		$user_time = $user_date_time[1];

	// - user given values

	

	// + Get all the ads start and stop Date/Time for that business id 

		$sql = "SELECT startdatetime , stopdatetime FROM ads WHERE business_id = ".$business_id;

		$query = $this->db->query($sql);

		$result['start_stop']= $query->result_array();

		$count = count($result);

		$i = 0;

	// + Get all the ads start and stop Date/Time for that business id

	

	// + It can be that the date can be same but the time must be different. Check the difference in timing.

		foreach($result['start_stop'] as $key=>$val){ //var_dump($val);

		// + Exploded Values of the DB 

			$db_date[$key]['start'] = explode(' ',$val['startdatetime']);

			$db_date[$key]['stop'] =  explode(' ',$val['stopdatetime']);	

			

					/* Start								**		Stop

					Date = $db_date[$key]['start'][0]);		** 		Date = $db_date[$key]['stop'][0]	

					Time = $db_date[$key]['start'][1]);		**		Time = $db_date[$key]['stop'][1]

															**									*/

			

		// - Exploded Values of the DB 	

		

		// + Check weather 

		// 1).the user given date is in between the existing Start Date and Stop Date in the DB then check for different time slot

		// 2).the user given date is = to the Start & Stop date then check for different time slot.

		// 3).

			//var_dump($db_date[$key]['start']); var_dump($db_date[$key]['end']);

			

			if($user_date == $db_date[$key]['start'][0] && $user_date == $db_date[$key]['stop'][0]){

				if($user_time > $db_date[$key]['stop'][1]){

					return "3";

				}else{

					return "4";

				}

			}if($user_date > $db_date[$key]['start'][0] ||  $user_date <= $db_date[$key]['stop'][0]){

				if($user_time > $db_date[$key]['start'][1] && $user_time <= $db_date[$key]['stop'][1]){

					return 1;

				}else if($user_time > $db_date[$key]['stop'][1]){

					return 2;

				}

			}else if($user_date > $db_date[$key]['start'][0] && $user_date < $db_date[$key]['stop'][0]){

				

			}

		// + Check weather the user given date is in between the existing Start Date and Stop Date in the DB 

			

			

		}

		//var_dump($db_date);

	// + It can be that the date can be same but the time must be different

		

	}

# + insert the new values in the ads table if the entry is new







/***********************************************************************************************************************************











														business_model ends here									



***********************************************************************************************************************************/

function go_to_next_business($zone_id=0,$business_id=0){

	$where_type=" and a.type=1";

	$where_approval=" ";

	$where_cat_subcat=" and h.catid='-99' and h.subcatid='-99'";

	$where_group_by=" ";

	$where_order_by=" ORDER BY trim(b.name) asc";

	$limit_where=" limit 1";

	$table="ads_setting_preferences a,business b,address c,users d,users_groups e, ads f, ad_to_zone g, ad_category_subcategory h";

	$table_relation="a.businessid=b.id and b.addressid=c.id and b.business_owner_id=d.id and d.id=e.user_id and b.id=f.business_id and f.id=g.adid and f.id=h.adid ";

	$table_relation_1=" and a.settingszoneid=$zone_id and a.approval IN(1,2) 

	and a.businessid=(select min(i.id) from business i, ads j, ads_setting_preferences k, ad_category_subcategory l where i.id > $business_id 

	AND i.id = j.business_id 

	AND i.id = k.businessid 

	AND k.settingszoneid = $zone_id

	AND j.id = l.adid 

	AND l.catid='-99' and l.subcatid='-99' 

	AND k.approval IN(1,2)

	AND k.type=1) and b.name!=''";

		

	$sql="select b.id as businessid, f.id as adid,b.name from $table where $table_relation $table_relation_1 $where_isdefault $where_type $where_cat_subcat $where_approval $where_charval $where_group_by $where_order_by $limit_where";

		$query=$this->db->query($sql);

		//echo $this->db->last_query();

		$result=$query->result_array();

		$arr=(!empty($result[0])) ? $result[0] : 0; 

		return $arr; 

}



function go_to_previous_business($zone_id=0,$business_id=0){

	$where_type=" and a.type=1";

	$where_approval=" ";

	$where_cat_subcat=" and h.catid='-99' and h.subcatid='-99'";

	$where_group_by=" ";

	$where_order_by=" ORDER BY trim(b.name) asc";

	$limit_where=" limit 1";

	$table="ads_setting_preferences a,business b,address c,users d,users_groups e, ads f, ad_to_zone g, ad_category_subcategory h";

	$table_relation="a.businessid=b.id and b.addressid=c.id and b.business_owner_id=d.id and d.id=e.user_id and b.id=f.business_id and f.id=g.adid and f.id=h.adid ";

	$table_relation_1=" and a.settingszoneid=$zone_id and a.approval IN(1,2) and a.businessid=(select max(i.id) from business i, ads j, ads_setting_preferences k, 	ad_category_subcategory l where i.id < $business_id 

	AND i.id = j.business_id 

	AND i.id = k.businessid 

	AND k.settingszoneid = $zone_id

	AND j.id = l.adid 

	AND l.catid='-99' and l.subcatid='-99' 

	AND k.approval IN(1,2)

	AND k.type=1) and b.name!=''";

		

	$sql="select b.id as businessid, f.id as adid,b.name from $table where $table_relation $table_relation_1 $where_isdefault $where_type $where_cat_subcat $where_approval $where_charval $where_group_by $where_order_by $limit_where";

		$query=$this->db->query($sql);

		//echo $this->db->last_query();

		$result=$query->result_array();

		$arr=(!empty($result[0])) ? $result[0] : 0; 

		return $arr; 

}





# + Get a particular webinar info for edit

	function getall_webinar_info($zoneid=0,$webinar_id=0){ //var_dump($zoneid); var_dump($webinar_id); exit;

      	$sql = "SELECT * FROM webinar_information WHERE zoneid=".$zoneid." AND id=".$webinar_id." ORDER BY id ASC";

		$query = $this->db->query($sql);	

		return $query->result_array();

	}

# - Get a particular webinar info for edit

	

	public function show_webinar($zone_id=false,$business_owner_id=0,$lowerlimit=0,$upperlimit=0){ // Added $lowerlimit=false,$upperlimit=false on 26/5/14

		if($lowerlimit!='' && $upperlimit!=''){ 

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{ 

			$limit_where="";

		}  
		 

		$query = $this->db->query("SELECT webinar_information.* FROM webinar_information 
              inner join wb_webinar_user on wb_webinar_user.id = webinar_information.created_by_userid
			WHERE webinar_information.zoneid=".$zone_id." AND wb_webinar_user.bus_id=".$business_owner_id." ORDER BY webinar_information.id ASC".$limit_where);
		
 
		return $query->result_array();		

    }

	# + Delete front image of ad

function delete_front_photo($image_name,$ad_id,$business_id){

    $array = array();

    preg_match( '/src="([^"]*)"/i', $image_name, $array ) ;

    $b= $array[1]  ;

	

		$a=str_replace(base_url(),'',$b);//var_dump($ad_id);exit;

	    $sql="update ads set adtext='' where id=".$ad_id;

		$this->db->query($sql);

		if(unlink($a)){

		$title = 1;	

		};

		return $title;

	}

    # -  Delete front image of ad	

   public function view_business_jotform($business_id,$zone_id){

   		$business_id=(int)$business_id;

   		$zone_id = (int)$zone_id;

		$fetch_form_category_query = "SELECT 

										a.code_id, 

										a.code, 

										a.payment_module_receiver_id AS business_id,

										b.id AS payment_module_id,

										b.value AS payment_form_type,

										b.receiver_type,

										b.payer_type

											FROM 

												payment_module AS b

										LEFT JOIN 

												jot_form_embed_code AS a 

											ON a.payment_module_id=b.id AND a.payment_module_receiver_id=".$business_id."

										WHERE 

											b.receiver_type ='business'";

		$query = $this->db->query($fetch_form_category_query);

		return $query->result_array();

   }

  /* public function get_jotform_code($reciver_id,$payer_id){

   		$sql = "SELECT code FROM jot_form_embed_code WHERE  payment_module_receiver_id=".$reciver_id;

   		$query = $this->db->query($sql);

   		return $query->result();

   }*/

	 public function get_all_payment_details($reciver_id){

	 	$sql =   "SELECT 

	 				  a.payer_id,

	 				  a.amount,

	 				  a.submission_id,

	 				  a.form_id,

	 				  a.time AS payment_creation_time,

	 				  b.first_name AS payer_first_name,

	 				  b.last_name AS payer_last_name,

	 				  c.value AS payment_purpose

	 			   FROM

	 			   	  payment AS a

	 			   INNER JOIN users AS b

	 			   		ON a.payer_id=b.id

	 			   INNER JOIN payment_module AS c

	 			   		ON a.payment_module = c.id

	 			   WHERE a.receiver_id=".$reciver_id."

	 			   ORDER BY a.time ASC";

	   $query = $this->db->query($sql);

	   return $query->result_array();

				 

	 }

	# + All inactive ads from business dashboard

	function all_inactive_ads($businessid,$zoneid){

			$select_all_inactive_ads = "select id from ads where business_id=".$businessid;

			$query_all_inactive_ads = $this->db->query($select_all_inactive_ads);

			$all_inactive_ads_result= $query_all_inactive_ads->result_array(); 

			    foreach($all_inactive_ads_result as $val){

					$ad_id.= $val['id'].',';

				}

		    $all_adid = substr($ad_id, 0, -1);  

		    $update_all_inactive_ads_sql = "update ad_to_zone set approval='-1' where approval='1' and zoneid='".$zoneid."' and  adid IN ($all_adid) ORDER BY `id` DESC"; 

		    $updatequery_all_inactive_ads= $this->db->query($update_all_inactive_ads_sql);

		    if (updatequery_all_inactive_ads) {
		    	echo "1";
		    }
		    else{
		    	return false;
		    }

		    

	}

    # -  All inactive ads from business dashboard

    public function get_sponsor_business_status($business_id){
		$sql="SELECT * FROM business_sponsor WHERE business_id=".$business_id;
		return $this->CommonController->SelectRawquery($sql,'row');
    }

    public function fetch_embed_jotform_code($zone_id){

    	/*$sql="SELECT * FROM jot_form_embed_code INNER JOIN payment_form_type ON jot_form_embed_code.form_type_id = payment_form_type.reciver_id WHERE payment_form_type.type='Sponsor Business' AND jot_form_embed_code.zone_id=".$zone_id;*/

    	$sql="SELECT * FROM jot_form_embed_code WHERE payment_module_id=1 AND payment_module_receiver_id=".$zone_id;

    	$query = $this->db->query($sql);

    	return $query->result();

    }

    public function save_payment($payment_data){

    	extract($payment_data);

    	$businessname = isset($businessname) ? $businessname : '';

    	$businessperiod = isset($businessperiod) ? $businessperiod : '';

    	$message = isset($message) ? $message : '';

    	$url = isset($clickto) ? $clickto : '';

    	$url_array = array();

    	$payer_id = "";

    	$receiver_id = "";

    	if(!empty($url)){

    		$url_array = explode('/',$url);

    		$count = count($url_array);

    		$payer_id = (int) $url_array[$count-2];

    		$receiver_id  = (int) $url_array[$count-1];

    	}

    	$formDetails = json_encode($payment_data);

    	if(!empty($payer_id) && !empty($receiver_id) && !empty($submission_id) && !empty($amount[2])){

    	$sql = "INSERT

				INTO 

					payment 

				SET 

					payment_module = 1,

					receiver_id = ".$receiver_id." ,

					payer_id = ".$payer_id.",

					amount = ".$amount[2].",

					submission_id = '".$submission_id."',

					form_id = '".$formID."',

					form_details = '".$formDetails."',

					time = NOW()";

		$query = $this->db->query($sql);

		$query1 = $this->make_business_sponsor($payer_id,$receiver_id);

		if($query){

			return array($payer_id,$receiver_id);

		}

	} else {

		return false;

	}



  }

  public function residence_payment_data($zone_id,$ad_id,$business_id,$users_id,$paymentData){

  	extract($paymentData);

  	$formDetails=json_encode($paymentData);

  	if(!empty($ad_id) && !empty($business_id) && !empty($users_id) && !empty($submission_id) && $amount[2]){

  	$sql = "INSERT

				INTO 

					payment 

				SET 

					payment_module = 2,

					receiver_id = ".$business_id." ,

					payer_id = ".$users_id.",

					amount = ".$amount[2].",

					submission_id = '".$submission_id."',

					form_id = '".$formID."',

					form_details = '".$formDetails."',

					time = NOW()";

	$query = $this->db->query($sql);

	return $query;

  } else{

  	return false;

  }







  }

  public function make_business_sponsor($business_id,$zone_id){

  	$sql = "SELECT * FROM business_sponsor WHERE business_id=".$business_id." AND zone_id=".$zone_id;

  	$query = $this->db->query($sql);

  	$sql1="";

  	if($query->result()){

  		$sql1 = "UPDATE business_sponsor SET business_id=".$business_id.",status=1,zone_id=".$zone_id." WHERE business_id=".$business_id." AND zone_id=".$zone_id;

  	} else {

  	$sql1="INSERT INTO business_sponsor(business_id,status,zone_id) VALUES(".$business_id.",1,".$zone_id.")";

  	}

    $query=$this->db->query($sql1);

    $make_order_sponsor = $this->zone_model->update_sponsored_business_status($business_id,1);

  }

  public function insertPaymentData($data,$payamentModuleId){

  	$totalData = json_encode($data);

  	extract($data);

  	$submissionId = $submission_id ? $submission_id : 0;

  	$formID = $formID ? $formID : 0;

  	$payerId = $userid ? $userid : 0;

  	$receiverId = $businessid ? $businessid : 0;

  	$amount = $amount[2];

  	if($submissionId && $formID && $payerId && $receiverId && $amount){

  		$sql = "INSERT 

  					INTO 

  						payment

  					SET

  						payment_module =".$payamentModuleId.",

  						receiver_id = ".$receiverId.",

  						payer_id = ".$payerId.",

  						amount =".$amount.",

  						submission_id = '".$submissionId."',

  						form_id = '".$formID."',

  						form_details='".$totalData."'";

  		$result = $this->db->query($sql);

  		return $result;

  	}



  }

  public function getRestaurentUserId($businessId,$zoneId,$password){

  	$sql = "SELECT * FROM restaurantbooking_users WHERE business_id=".$businessId;

			$query = $this->db->query($sql);

			$result = $query->row();

			$user_id = 0;

			if($result){

				$user_id = $result->id;

			} else{

				$sql_business = "SELECT 

            				a.contactfullname,

            				a.name,

            				b.email,

            				b.username,

            				b.password

            			FROM

            				business a

            			INNER join

            				users b

            			WHERE

            				a.business_owner_id=b.id

            			AND

            				a.id=".$businessId;

            	$query = $this->db->query($sql_business);

            	$query_result = $query->row();



            	$sql_insert = "INSERT INTO 

            						  restaurantbooking_users

            					SET 

            						role_id=1,

            						 email = '".$query_result->email."',

            						 password = '".sha1($password)."',

            						 name = '".addslashes($query_result->contactfullname)."',

            						 phone = ".$query_result->username.",

            						 created = ".NOW().",

            						 status = 'T',

            						 is_active = 'T',

            						 ip = '".$_SERVER['REMOTE_ADDR']."',

            						 business_id = ".$businessId.",

            						 zone_id = ".$zoneId;

            	$query_result_data = $this->db->query($sql_insert);

            	$user_id = $this->db->insert_id();

            	$this->setRestaurantBasicInfo($businessId,$zoneId,$query_result->name);

            	if($user_id) {

            		$this->setDefaultSnapOption($businessId,$zoneId);

            	}

			}

			return $user_id;

  }

  /**

	  * @desc method to insert default snap settings

	  * @access public

	  * @param $businessId



	*/

	public function setDefaultSnapOption($businessId,$zoneId) {

		// Query for default snap settings



		$sqlQuery = "INSERT INTO `restaurantbooking_business_snap_offered` (`business_id`, `zone_id`, `snap_week_day_id`, `snap_time_id`, `snap_percentage`) VALUES

			(".$businessId.",".$zoneId.",2,5,5),

			(".$businessId.",".$zoneId.",2,6,4),

			(".$businessId.",".$zoneId.",2,7,3),

			(".$businessId.",".$zoneId.",2,8,3),

			(".$businessId.",".$zoneId.",2,9,3),

			(".$businessId.",".$zoneId.",2,10,5),

			(".$businessId.",".$zoneId.",2,11,4),

			(".$businessId.",".$zoneId.",2,12,2),

			(".$businessId.",".$zoneId.",2,13,2),

			(".$businessId.",".$zoneId.",2,14,3),

			(".$businessId.",".$zoneId.",2,15,4),

			(".$businessId.",".$zoneId.",2,16,5),

			(".$businessId.",".$zoneId.",2,17,6),

			(".$businessId.",".$zoneId.",2,18,7),



			(".$businessId.",".$zoneId.",3,5,5),

			(".$businessId.",".$zoneId.",3,6,4),

			(".$businessId.",".$zoneId.",3,7,3),

			(".$businessId.",".$zoneId.",3,8,3),

			(".$businessId.",".$zoneId.",3,9,3),

			(".$businessId.",".$zoneId.",3,10,5),

			(".$businessId.",".$zoneId.",3,11,4),

			(".$businessId.",".$zoneId.",3,12,2),

			(".$businessId.",".$zoneId.",3,13,2),

			(".$businessId.",".$zoneId.",3,14,3),

			(".$businessId.",".$zoneId.",3,15,4),

			(".$businessId.",".$zoneId.",3,16,5),

			(".$businessId.",".$zoneId.",3,17,7),

			(".$businessId.",".$zoneId.",3,18,7),



			(".$businessId.",".$zoneId.",4,5,5),

			(".$businessId.",".$zoneId.",4,6,4),

			(".$businessId.",".$zoneId.",4,7,3),

			(".$businessId.",".$zoneId.",4,8,3),

			(".$businessId.",".$zoneId.",4,9,3),

			(".$businessId.",".$zoneId.",4,10,5),

			(".$businessId.",".$zoneId.",4,11,4),

			(".$businessId.",".$zoneId.",4,12,2),

			(".$businessId.",".$zoneId.",4,13,2),

			(".$businessId.",".$zoneId.",4,14,3),

			(".$businessId.",".$zoneId.",4,15,4),

			(".$businessId.",".$zoneId.",4,16,5),

			(".$businessId.",".$zoneId.",4,17,7),

			(".$businessId.",".$zoneId.",4,18,7),



			(".$businessId.",".$zoneId.",5,5,5),

			(".$businessId.",".$zoneId.",5,6,4),

			(".$businessId.",".$zoneId.",5,7,3),

			(".$businessId.",".$zoneId.",5,8,2),

			(".$businessId.",".$zoneId.",5,9,3),

			(".$businessId.",".$zoneId.",5,10,5),

			(".$businessId.",".$zoneId.",5,11,4),

			(".$businessId.",".$zoneId.",5,12,2),

			(".$businessId.",".$zoneId.",5,13,2),

			(".$businessId.",".$zoneId.",5,14,3),

			(".$businessId.",".$zoneId.",5,15,4),

			(".$businessId.",".$zoneId.",5,16,5),

			(".$businessId.",".$zoneId.",5,17,7),

			(".$businessId.",".$zoneId.",5,18,7),



			(".$businessId.",".$zoneId.",6,5,5),

			(".$businessId.",".$zoneId.",6,6,4),

			(".$businessId.",".$zoneId.",6,7,3),

			(".$businessId.",".$zoneId.",6,8,2),

			(".$businessId.",".$zoneId.",6,9,3),

			(".$businessId.",".$zoneId.",6,10,5),

			(".$businessId.",".$zoneId.",6,11,2),

			(".$businessId.",".$zoneId.",6,12,1),

			(".$businessId.",".$zoneId.",6,13,2),

			(".$businessId.",".$zoneId.",6,14,1),

			(".$businessId.",".$zoneId.",6,15,1),

			(".$businessId.",".$zoneId.",6,16,3),

			(".$businessId.",".$zoneId.",6,17,4),

			(".$businessId.",".$zoneId.",6,18,5),



			(".$businessId.",".$zoneId.",7,5,3),

			(".$businessId.",".$zoneId.",7,6,3),

			(".$businessId.",".$zoneId.",7,7,3),

			(".$businessId.",".$zoneId.",7,8,2),

			(".$businessId.",".$zoneId.",7,9,3),

			(".$businessId.",".$zoneId.",7,10,3),

			(".$businessId.",".$zoneId.",7,11,1),

			(".$businessId.",".$zoneId.",7,12,1),

			(".$businessId.",".$zoneId.",7,13,1),

			(".$businessId.",".$zoneId.",7,14,1),

			(".$businessId.",".$zoneId.",7,15,2),

			(".$businessId.",".$zoneId.",7,16,4),

			(".$businessId.",".$zoneId.",7,17,4),

			(".$businessId.",".$zoneId.",7,18,4),



			(".$businessId.",".$zoneId.",1,5,1),

			(".$businessId.",".$zoneId.",1,6,3),

			(".$businessId.",".$zoneId.",1,7,3),

			(".$businessId.",".$zoneId.",1,8,2),

			(".$businessId.",".$zoneId.",1,9,3),

			(".$businessId.",".$zoneId.",1,10,3),

			(".$businessId.",".$zoneId.",1,11,1),

			(".$businessId.",".$zoneId.",1,12,1),

			(".$businessId.",".$zoneId.",1,13,1),

			(".$businessId.",".$zoneId.",1,14,1),

			(".$businessId.",".$zoneId.",1,15,2),

			(".$businessId.",".$zoneId.",1,16,4),

			(".$businessId.",".$zoneId.",1,17,4),

			(".$businessId.",".$zoneId.",1,18,4)";

		// Insert default snsp settings

		$this->db->query($sqlQuery);

		// Sql to set default snap Status

		$sqlSnapStatus = "INSERT INTO restaurantbooking_business_snap_status SET business_id =".$businessId.",snap_status=1";

		$this->db->query($sqlSnapStatus);

	}

	 /**

	  * @desc method to insert basic restaurant info

	  * @access public

	  * @param $businessId, 



	*/

	 public function setRestaurantBasicInfo($businessId,$zoneId,$businessName) {



		$sqlQuery = "INSERT INTO `restaurantbooking_restaurant_basic_info` (`business_id`, `zone_id`, `restaurant_name`) VALUES (".$businessId.",".$zoneId.",'".addslashes($businessName)."')";

		$this->db->query($sqlQuery);

	}



	/**

	   * Method to update business information status

	   * @access public

	   * @param $businessId 

	   * @return boolean $businessInformationUpdateStatus

	*/

	public function updateBusinessInformation($businessId,$status) {

		$businessId = (int)$businessId;

		$status     = (int)$status;

		$queryToupdateBusinessInformation = "UPDATE `business` SET 	`business_information` = ".$status." WHERE `id` =".$businessId;

		if($this->db->query($queryToupdateBusinessInformation)) {

			return true;

		}

		return false;

	}



	public function getGalleryUserId($businessId,$zoneId,$password){



		$sql = "SELECT * FROM stivagallery_users WHERE business_id=".$businessId;

			$query = $this->db->query($sql);

			$result = $query->row();

			$user_id = 0;

			if($result){

				$user_id = $result->id;

			} else{

				$sql_business = "SELECT 

            				a.contactfullname,

            				b.email,

            				b.username,

            				b.password

            			FROM

            				business a

            			INNER join

            				users b

            			WHERE

            				a.business_owner_id=b.id

            			AND

            				a.id=".$businessId;

            	$query = $this->db->query($sql_business);

            	$query_result = $query->row();



            	$sql_insert = "INSERT INTO 

            						  stivagallery_users

            					SET 

            						role_id=1,

            						 email = '".$query_result->email."',

            						 password = '".sha1($password)."',

            						 name = '".$query_result->contactfullname."',

            						 phone = ".$query_result->username.",

            						 created = ".NOW().",

            						 status = 'T',

            						 is_active = 'T',

            						 ip = '".$_SERVER['REMOTE_ADDR']."',

            						 business_id = ".$businessId.",

            						 zone_id = ".$zoneId;

            	$query_result_data = $this->db->query($sql_insert);

            	$user_id = $this->db->insert_id();



            	$sql_gallery = "INSERT INTO `stivagallery_galleries` (`name`,`layout`,`target`,`width`,`height`,`preview_width`,`preview_height`,`thumb_width`,`thumb_height`,`ratio`,`custom_width`,`custom_height`,`max_width`,`slideshow_speed`,`created`,`status`,`business_id`,`zone_id`) VALUES

            		('offer',1,'_self',320,240,800,800,200,200,1,1,1,800,1500,now(),'T',".$businessId.",".$zoneId."),

            		('logo',1,'_self',320,240,800,800,200,200,1,1,1,800,1500,now(),'T',".$businessId.",".$zoneId."),

            		('photo',1,'_self',320,240,800,800,200,200,1,1,1,800,1500,now(),'T',".$businessId.",".$zoneId."),

            		('menu',1,'_self',320,240,800,800,200,200,1,1,1,800,1500,now(),'T',".$businessId.",".$zoneId.")";

            	$query_result_data = $this->db->query($sql_gallery);

			}

			return $user_id;

	}



	public function get_gallery_images($businessid){

		//echo $businessid; exit;

		$gallery_content = array();

		$gallery_content[] = array('logo' => $this->gallery('logo',$businessid),'offer' => $this->gallery('offer',$businessid),'photo'=> $this->gallery('photo',$businessid));



        return $gallery_content;

	}
	
	public function gallery($gallary_name,$businessid){
		$joinArr[] = ['table' => 'stivagallery_galleries','link' => 'stivagallery_plugin_gallery.foreign_id = stivagallery_galleries.id','type'=> 'left'];

		return $this->CommonController->SelectJoinMulti('stivagallery_plugin_gallery', $joinArr,['stivagallery_galleries.name'=>$gallary_name,'stivagallery_galleries.business_id'=>$businessid],[],[],'stivagallery_plugin_gallery.small_path,stivagallery_plugin_gallery.medium_path,stivagallery_plugin_gallery.large_path','','','',[],'resultArray');
	}
	public function business_images_gallery($adid){
		$sql = "select image_name from business_photos where ad_id = " . $adid . "";			
		return $this->CommonController->SelectRawquery($sql,'row');
	}



    public function getMenuMakerUserId($businessId,$zoneId,$password){



    	$sql = "SELECT * FROM menu_builder_users WHERE business_id=".$businessId;

			$query = $this->db->query($sql);

			$result = $query->row();

			$user_id = 0;

			if($result){

				$user_id = $result->id;

			} else{

				$sql_business = "SELECT 

            				a.contactfullname,

            				b.email,

            				b.username,

            				b.password

            			FROM

            				business a

            			INNER join

            				users b

            			WHERE

            				a.business_owner_id=b.id

            			AND

            				a.id=".$businessId;

            	$query = $this->db->query($sql_business);

            	$query_result = $query->row();



            	$sql_insert = "INSERT INTO 

            						  menu_builder_users

            					SET 

            						role_id=1,

            						 email = '".$query_result->email."',

            						 password = '".sha1($password)."',

            						 name = '".$query_result->contactfullname."',

            						 phone = ".$query_result->username.",

            						 created = ".NOW().",

            						 status = 'T',

            						 is_active = 'T',

            						 ip = '".$_SERVER['REMOTE_ADDR']."',

            						 business_id = ".$businessId.",

            						 zone_id = ".$zoneId;

            	$query_result_data = $this->db->query($sql_insert);

            	$user_id = $this->db->insert_id();

            	

			}

			return $user_id;

    }

 



}