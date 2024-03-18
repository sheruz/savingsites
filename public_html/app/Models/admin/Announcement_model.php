<?php
namespace App\Models\admin;

use CodeIgniter\Model;
use App\Controllers\CommonController;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class Announcement_model extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->CommonController = new CommonController();
    }
	
	function organization_details($id=0){

		$sql="SELECT auto_approve_emergency_announcements,auto_approve_normal_announcements FROM  zone_preferences WHERE zoneid=".$data['zone_id'];

		$query=$this->db->query($sql);

		$result=$query->result_array();

	}
	
	public function save_category($orgid,$category){
		$data = array('orgid'=>$orgid,'name'=>$category);
		
		$sql = 'SELECT * FROM organization_category WHERE orgid='.$orgid.' AND name="'.$category.'" AND parent_id=0';
		$rows = $this->CommonController->SelectRawquery($sql,'count');
		if($rows > 0){
			$msg = ['msg'=>'Category Already Exists','type'=>'warning'];
		}else{
			$id = $this->CommonController->InsertData('organization_category', $data);
			if($id > 0){
				$msg = ['msg'=>'Category Inserted Successfully','type'=>'success'];
			}else{
				$msg = ['msg'=>'Something Went Wrong','type'=>'warning'];
			}
		}
		return $msg;
	}
	
	public function webnair_edit_category($zone_id = false,$org_id=false,$lowerlimit=false,$upperlimit=false){ // Added $lowerlimit=false,$upperlimit=false on 26/5/14   

//var_dump($zone_id); var_dump($org_id);var_dump($lowerlimit);var_dump($lowerlimit);exit;  

		if($lowerlimit!='' && $upperlimit!=''){

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{

			$limit_where="";

		}

		$query = $this->db->query("SELECT * FROM organization_announcement WHERE orgid=".$org_id." and zoneid=".$zone_id." order by timestamp desc". $limit_where);

       return $query->result_array();		

    }
	
	public function edit_category($id,$name){
		$id = $this->CommonController->updateData('organization_category',['name'=>$name],['id'=>$id]);
		if($id == 1){
			$msg = ['msg'=>'Category Updated Successfully','type'=>'success'];
		}else{
			$msg = ['msg'=>'Category Not Updated','type'=>'warning'];
		}
		return $msg;
	}

	

	
 function webinar_userslist(){


     $sql = 'Select * from wb_webinar_user ';

		$query = $this->db->query($sql);	 

		return $query->result_array();
	 
 }
	

	// Editing webniar

	function webniar_category($data){ 

		$sql = 'UPDATE webinar_information SET link="'.$data['link'].'" WHERE id='.$data['description'];

		$query = $this->db->query($sql);	

		if($this->db->affected_rows() > 0){

			return 1;

		}

		else{

			return -1;

		}

	}

	// Delete webniar

	

	function delete_category($data){

		$sql = 'DELETE from organization_category WHERE id='.$data['id'];

		$query = $this->db->query($sql);

		/*$arr = array();

		$sql = "SELECT * FROM organization_category WHERE parent_id=".$data['id'];

		$query = $this->db->query($sql);

  		  if ($query->num_rows()>0) {

			   foreach($query->result_array() as $row)

			   {

				   $arr['id'] = $row['id'];

				   $this->delete_category($arr['id']);

			   }

    	   }

   		mysql_query("DELETE FROM organization_category WHERE id=".$data['id']);*/

	}
	
	public function getall_category($orgid=0,$lowerlimit=0,$upperlimit=0){
		$limit_where="";
		if($lowerlimit!=0 && $upperlimit!=0){ 
			$limit_where=" limit ".$lowerlimit.",".$upperlimit;
		}
		$sql = "SELECT * FROM organization_category WHERE orgid=".$orgid." AND parent_id=0 ORDER BY name ASC".$limit_where;
		return $this->CommonController->SelectRawquery($sql);
	}

	// Showing webnair categories

 

# + Get all the webniar info	

	function getall_webinar_info($zoneid=0,$webinar_id=0,$lowerlimit=0,$upperlimit=0){ //var_dump($webinar_id);exit;

		if($lowerlimit!='' && $upperlimit!=''){ 

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{ 

			$limit_where="";

		}

      	$sql = "SELECT * FROM webinar_information WHERE zoneid=".$zoneid." AND id=".$webinar_id." ORDER BY id ASC".$limit_where;

		$query = $this->db->query($sql);	

		return $query->result_array();

	}

# - Get all the webniar info

	

	public function show_webinar($zone_id = false,$lowerlimit=0,$upperlimit=0,$usersid=false){ // Added $lowerlimit=false,$upperlimit=false on 26/5/14   

		$usersql = "";

		if($lowerlimit!='' && $upperlimit!=''){ 

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{ 

			$limit_where="";

		}

		if($usersid!=''){

			$usersql= " AND created_by_userid='".$usersid."'";

		}

		//echo "SELECT * FROM webinar_information WHERE zoneid=".$zone_id. $usersql." order by id ASC".$limit_where;exit;

		$query = $this->db->query("SELECT * FROM webinar_information WHERE zoneid=".$zone_id. $usersql." order by id ASC".$limit_where);//var_dump($query->result_array());exit;

       return $query->result_array();		

    }

	

# + Webinar Exists checking if this user 
	public function webniar_exist($usersid, $zoneid){
		return 0;	
		$$count = $this->CommonController->SelectDataMultiWay('webinar_information','id','rowArray',['zoneid'=>$zoneid,'created_by_userid'=>$usersid]);
		if(count($count) > 0){
			return $count;	
		}
	}



# - Webinar Exists checking if this user 

	

# - Get all the coupon info

	public function create_coupon($zone_id = false){ 

			//echo "SELECT * FROM zone_preferences WHERE zoneid='$zone_id'";exit;

			$query = $this->db->query("SELECT * FROM zone_preferences WHERE zoneid='$zone_id'");

		   return $query->result_array();		

		}

	

	public function show_coupon($zone_id = false,$lowerlimit=0,$upperlimit=0){ // Added $lowerlimit=false,$upperlimit=false on 26/5/14   

		if($lowerlimit!='' && $upperlimit!=''){ 

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{ 

			$limit_where="";

		}

		//echo "SELECT * FROM coupon_site WHERE zoneid='$zone_id' order by id ASC".$limit_where;exit;

		$query = $this->db->query("SELECT * FROM zone_preferences WHERE zoneid='$zone_id' order by id ASC".$limit_where);

       return $query->result_array();		

    }

	

	public function edit_coupon($zone_id = false){ // Added $lowerlimit=false,$upperlimit=false on 26/5/14   

	

		//echo "SELECT * FROM coupon_site WHERE zoneid='$zone_id' order by id ASC".$limit_where;exit;

		$query = $this->db->query("SELECT * FROM zone_preferences WHERE zoneid='$zone_id' order by id ASC");

       return $query->result_array();		

    }

	public function delete_coupon($zone_id, $coupon_id){ // Added $lowerlimit=false,$upperlimit=false on 26/5/14   

	 //echo "UPDATE zone_preferences SET coupon_link='' WHERE zoneid=".$zone_id;exit;

		$sql_delete = "UPDATE zone_preferences SET coupon_link='' WHERE zoneid=".$zone_id;

		$query = $this->db->query($sql_delete);//var_dump($sql_delete);exit; 

		return 1;

    }

	public function coupon_view($zone_id){ // Added $lowerlimit=false,$upperlimit=false on 26/5/14   

	 //echo "UPDATE zone_preferences SET coupon_link='' WHERE zoneid=".$zone_id;exit;

	 //echo "SELECT * FROM zone_preferences  WHERE zoneid=".$zone_id; exit;

		 $sql="SELECT coupon_link FROM zone_preferences  WHERE zoneid=".$zone_id; 

	     $query = $this->db->query($sql); 

		 $result = $query->result_array();

		 if($result['0']['coupon_link']!="")

			 return $result['0']['coupon_link']; 

		 else

		 	 return 1;

    }

	

//Show  phone broadcasting sites Start

	public function phone_broadcasting($zone_id = false){ 

			$query = $this->db->query("SELECT * FROM zone_preferences WHERE zoneid='$zone_id'");

		   return $query->result_array();		

		} 

	public function show_phone_broadcasting_view($zone_id = false,$lowerlimit=0,$upperlimit=0){    

		if($lowerlimit!='' && $upperlimit!=''){ 

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{ 

			$limit_where="";

		}

		$query = $this->db->query("SELECT * FROM zone_preferences WHERE zoneid='$zone_id' order by id ASC".$limit_where);

	   return $query->result_array();		

    }

		

		public function show_phone_broadcasting_link($zone_id = false,$lowerlimit=0,$upperlimit=0){

		if($lowerlimit!='' && $upperlimit!=''){ 

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{ 

			$limit_where="";

		}

		$query = $this->db->query("SELECT * FROM zone_preferences WHERE zoneid='$zone_id' order by id ASC".$limit_where);

       return $query->result_array();		

    }

		

		public function Editphone_broadcasting($zone_id = false){ 

		$query = $this->db->query("SELECT * FROM zone_preferences WHERE zoneid='$zone_id' order by id ASC");

        return $query->result_array();		

    }

		

		public function deletephone_broadcasting($zone_id, $phone_id){

		$sql_delete = "UPDATE zone_preferences SET phone_broadcasting='' WHERE zoneid=".$zone_id;

		$query = $this->db->query($sql_delete);

		return 1;

	}

		

		

		

		

		

		

		

		

		

//Show  phone broadcasting sites End

	

	// Showing all subcategories

	function show_subcategory($data,$lowerlimit,$upperlimit){ //var_dump($data);exit;

		if($lowerlimit!='' && $upperlimit!=''){ 

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{ 

			$limit_where="";

		}

		if($lowerlimit!='' && $upperlimit!=''){

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{

			$limit_where="";

		}

		

		$sql = 'SELECT * FROM organization_category WHERE orgid='.$data['orgid'].' AND parent_id='.$data['parentid'].' ORDER BY name ASC'.$limit_where;

		$query = $this->db->query($sql);	

		return $query->result_array();	

	}

	function subcategoryname($data){ 				// Edited 2/4/14

		$sql = 'SELECT * FROM organization_category WHERE orgid='.$data['orgid'].' AND id='.$data['id'];

		$query = $this->db->query($sql);	

		$ret = $query->row();		

		$arr = array();

		$arr['name'] = !empty($ret->name) ? $ret->name : '';					//Added !empty() check on 29/5/14

		$arr['id'] = !empty($ret->parent_id) ? $ret->parent_id : 0;				//Added !empty() check on 29/5/14

		return $arr;

	}

	// Add new sub-category

	function add_subcategory($data){

		/*$sql_sub = 'SELECT id FROM organization_category WHERE parent_id='.$data['parentid'];

		$query1 = $this->db->query($sql_sub);

		$res = $query1->result_array();

		if(!$res){

			$sql_sub2 = 'SELECT id FROM organization_category WHERE id='.$data['parentid'].' AND parent_id=0';

			$query2 = $this->db->query($sql_sub2);

			$res2 = $query2->result_array();

			if(!$res2){

				$id = $res2[0]['id'];

			}

			//$id = $data['parentid'];

		}else{

			$id = $res[0]['id'];

		}*/

		/*if($data['id'] != NULL && $data['parentid'] == NULL){

			$id = $data['id'];

		}

		elseif($data['parentid'] != NULL && $data['id'] != NULL){

			

			$id = $data['parentid'];

			

		}*/

		$sql = "INSERT INTO organization_category (orgid,name,parent_id) VALUES (".$data['orgid'].",'".$data['catname']."',".$data['parentid'].")";

		$query = $this->db->query($sql);

		if($this->db->affected_rows() > 0){

			return 1;

		}

		else{

			return -1;

		}

	}

	

	// Delete Org By User

	public function user_deleteorganization($data){

		$this->db->insert('user_zone_organization',$data);

		if($this->db->affected_rows() > 0){

			return 1;

		}

		else{

			return -1;

		}

	}

	

	// Delete Category By User

	public function user_deletecategory($data){

		$this->db->insert('user_zone_organization_category',$data);

		if($this->db->affected_rows() > 0){

			return 1;

		}

		else{

			return -1;

		}

	}

	

	 public function save_announcement($data){

		 $sql="SELECT auto_approve_emergency_announcements,auto_approve_normal_announcements FROM  zone_preferences WHERE zoneid=".$data['zone_id'];

		 $query=$this->db->query($sql);

		 $result=$query->result_array();

		 $auto_emer_ann=$result[0]['auto_approve_emergency_announcements'];

		 $auto_nor_ann=$result[0]['auto_approve_normal_announcements']; 

		 if($data['announcementtype']==1){

			if($auto_emer_ann==1){

				$approval=1;

			}else{

				$approval=0;

			}

		}else{

			if($auto_nor_ann==1){

				$approval=1;

			}else{

				$approval=0;

			}

		}

		$newdate=(empty($data['date_modified'])) ? date("Y-m-d h:i:s") : $data['date_modified'];

		$newdata=array(

			'zone_id' => $data['zone_id'],



            'title' => $data['title'],



            'date_modified' => $newdate,



            'announcement_text' => $data['announcement_text'],



            'announcement_type' => $data['announcementtype'],



            'approval' => $approval

		);

		if(empty($data['id']) || $data['id'] < 1){

            $this->db->insert($this->table, $newdata);

            $data['id'] = $this->db->insert_id();

        }else{

            $this->db->where('id', $data['id']);

            $this->db->update($this->table, $newdata);

        }

        return $data['id'];

	 }

	public function getZonePpreferencesByZone($zoneid){ 
		$sql="SELECT auto_approve_emergency_announcements,auto_approve_normal_announcements FROM zone_preferences WHERE zoneid =".$zoneid;
		$result_1 = $this->CommonController->SelectRawquery($sql);
		if(!empty($arr))return $arr[0];
		else return array();
	}

	public function save_announcement_org($data){	
		$sql_1="select announcement_display from organization where id=".$data['organization_id'];
		$result_1 = $this->CommonController->SelectRawquery($sql_1);
		if(!empty($result_1)){
			$_announcement_display=$result_1[0]['announcement_display'];
		}
		
		$arr_zonepref=$this->getZonePpreferencesByZone($data['zone_id']);	
		if($data['announcement_type']==1){	
			if($arr_zonepref['auto_approve_emergency_announcements']==1){
				$approval=1;
			}else if($arr_zonepref['auto_approve_emergency_announcements']==0){
				$approval=0;
			}
			
			if(empty($arr_zonepref)) $approval=1;
				$sql_org="select name from  organization where id=".$data['organization_id'];
				$result_org = $this->CommonController->SelectRawquery($sql_org);
				if(!empty($result_org)){
					$_org_name=$result_org[0]['name'];
				}
				
				$sql_push="select * from device_token order by id asc";
				$result = $this->CommonController->SelectRawquery($sql_push);
				$message = $_org_name.' post a new announcement.'; 
				$passphrase = 'tarun';			 

				$ctx = stream_context_create();
				stream_context_set_option($ctx, 'ssl', 'local_cert', 'application/models/admin/SSDistribution.pem');
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
				$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
				
				$body['aps'] = array('alert' => $message,'sound' => 'default');
				$payload = json_encode($body);
				$temp_arr=array('app' => 'ToKoVLt7by5wutIBh4PEnpFkCFUioKreXt9uSYTz', 'api' => '9HuqD7l0zYLrdHzgWODd23aI5Eq3fH7w1pnbaP10', 'body' => $message);
				
				if (!empty($temp_arr)) { 
					$errors = array();
					foreach (array('app' => 'APPLICATION_ID', 'api' => 'REST_API_KEY', 'body' => 'MESSAGE') as $key => $var) {
						if (empty($temp_arr[$key])) {
							$errors[$var] = true;
						} else {
							$$var = $temp_arr[$key];
						}
					}
					
					if (!$errors) {
						$url = 'https://api.parse.com/1/push';
						$data_an = array(
							'channel' => 'Giants',
							'type' => 'android',
							'expiry' => 1451606400,
							'data' => array(
								'alert' => $MESSAGE,
							),
						);
						$_data = json_encode($data_an);
						
						$headers = array(
							'X-Parse-Application-Id: ' . $APPLICATION_ID,
							'X-Parse-REST-API-Key: ' . $REST_API_KEY,
							'Content-Type: application/json',
							'Content-Length: ' . strlen($_data),
						);
						
						$curl = curl_init($url);
						curl_setopt($curl, CURLOPT_POST, 1);
						curl_setopt($curl, CURLOPT_POSTFIELDS, $_data);
						curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
						$response = curl_exec($curl);
					}
				}
				
				foreach($result as $_val){
					$deviceToken=$_val['devicetoken'];
					$deviceToken_type=$_val['type'];
					if($deviceToken==''){
						continue;
					}
					if($deviceToken_type==1){				
						$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload; 
						$result1 = fwrite($fp, $msg, strlen($msg));

					}else if($deviceToken_type==2){
						$registrationIDs[]=$deviceToken;
					}
				}
			}else{
				if(count($arr_zonepref) > 0){
					if($arr_zonepref['auto_approve_normal_announcements']==1){
						$approval=1;
					}else if($arr_zonepref['auto_approve_normal_announcements']==0){
						$approval=0;
					}
				}else{
					$approval=1;
				}
			}

			$newdate=date("Y-m-d h:i:s") ;
			$newdata=array(
				'zoneid' => $data['zone_id'],
				'orgid'=> $data['organization_id'],
				'title' => $data['title'],
				'announcement'=> $data['announcement_text'],
				'type'=> $data['announcement_type'],
				'timestamp'=>time(),
				'category'=>$data['category'],
				'textme'=>$data['announcement_text']
			);

			if(empty($data['id']) || $data['id'] < 1){
				$newdata['approval']=$approval;
				$data['id'] = $this->CommonController->InsertData('organization_announcement', $newdata);
			}else{    
				$this->CommonController->updateData('organization_announcement',$newdata,['id'=>$data['id']]);        
			}
			return $data['id'];
	}

    public function get_announcement_by_id($id){

        $query = $this->db->get_where($this->table, array('id' => $id), 1);

        return $query->row();

    }



    //D

    public function delete_announcement($id){

        

        $this->db->where('id', $id);

        $this->db->delete($this->table);    

    }

    

    public function get_announcements_for_zone_old($zone_id = false){

        if(empty($zone_id)) { return false;}

		return $this->db->get_where($this->table, array('zone_id' => $zone_id))->result_array();

    }

	 public function get_announcements_for_zone($zone_id = false,$announcements_category=false,$announcements_type=false,$charval=false,$lowerlimit=false,$upperlimit=false){

		if($announcements_category==0){

			$where=" and organizationid=0";

		}else if($announcements_category==1){

			$where=" and organizationid!=0";

		}

		if($charval=='all'){

			$wherecharval='';

		}else{

			$wherecharval=' AND title LIKE "'.$charval.'%"';

		}

		if($lowerlimit!='' && $upperlimit!=''){

			$limit_where=" limit ".$lowerlimit.",".$upperlimit;

		}else{

			$limit_where="";

		}

		

		$sql="select * from zone_announcement where zone_id=".$zone_id." ".$where."".$wherecharval." and approval=".$announcements_type." ".$limit_where."";		

		$query=$this->db->query($sql);

		$result=$query->result_array();

		if($announcements_category!=0){

			for($i = 0 ; $i < count($result) ; $i++) {

				$sql_inner="select name,approval from zone_organization where id=".$result[$i]['organizationid'];

				$query_inner=$this->db->query($sql_inner);

				$result_inner=$query_inner->result_array();

				$result[$i]['organization_name'] = $result_inner[0]['name'] ;

				$result[$i]['approval_1'] = $result_inner[0]['approval'] ;

			}

		}

		return $result;

    }

	

	function get_org_announcements_for_zonepage($org_id=0){

		$sql="select * from zone_announcement where organizationid=".$org_id." and approval=1 order by announcement_type desc";

		$query=$this->db->query($sql);

		$result=$query->result_array();

		foreach($result as $key=>$val){

			$result[$key]['announcement_text']=str_replace('src="../../uploads/','src="uploads/',$result[$key]['announcement_text']);

		}

		return $result;

		

	}

	

	public function get_announcements_for_zonepage($zone_id = false){

		$result_final='';

		$sql="select a.approval,b.id as org_id,b.name as org_name from zone_announcement a, zone_organization b where a.organizationid=b.id and a.zone_id=b.zoneid and a.organizationid!=0 and b.approval=1 and a.zone_id='".$zone_id."' group by a.organizationid order by b.id asc";

		$query=$this->db->query($sql);

		$result=$query->result_array();

		if(!empty($result)){

			foreach($result as $_x){

				$result_final[$_x['org_id']]=$_x['org_name'];

			}

		}

		

		$sql_1="select b.id as org_id1,b.name as org_name1 from zone_announcement a, zone_organization b where a.organizationid=b.id  and a.organizationid!=0 and a.approval=1 and b.announcement_display=1 and a.zone_id!='".$zone_id."' group by a.organizationid order by b.id asc";

		$query_1=$this->db->query($sql_1);

		$result_1=$query_1->result_array();

		if(!empty($result_1)){

			foreach($result_1 as $_y){

				$result_final[$_y['org_id1']]=$_y['org_name1'];

			}

		}

		return $result_final;

    }

	

	public function get_announcements_for_all_athena($zone_id = false){

		if($zone){

			date_default_timezone_set('EST');

			$date = new DateTime();

			$interval = new DateInterval('PT1H');

			$date->add($interval);

			$inow=$date->format('Y-m-d H:i:s');

			

			$sql_1="select * from zone_preferences where zoneid=".$zone;

			$r1=$this->db->query($sql_1)->result_array();

			if($r1[0]['auto_approve_offers_announcements']==2 || $r1[0]['auto_approve_offers_announcements']==3){

			$q="SELECT * FROM zone_announcement WHERE zone_id=".$zone." ORDER BY id DESC";

			$r=$this->db->query($q)->result_array();

			return $r;

		}

		}

	}

	

	function get_organization_for_zone($zone_id = false,$charval=false,$lowerlimit=false,$upperlimit=false){

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

			$where=' AND name LIKE "'.urldecode($charval).'%"';

		}

		//echo "SELECT * FROM zone_organization WHERE zoneid=".$zone_id." ".$where." ".$limit_where;

		//$query = $this->db->query("SELECT * FROM zone_organization WHERE zoneid=".$zone_id." ".$where." ".$limit_where."");

		$query = $this->db->query("SELECT * FROM organization WHERE zoneid=".$zone_id." ".$where." ".$limit_where."");

		return $query->result_array();

    }

	function get_organization_by_id($id){

		$query = $this->db->query("SELECT a.id,a.name,a.type,a.announcement_display,c.username,c.password,c.email FROM zone_organization a,organization_owners_in_zone b,users c WHERE a.id=b.orgid and b.userid=c.id and a.id=".$id);

        return $query->row();

    }
	
	public function delete_organization_by_id($id){
		$session_zoneid_arr=$this->CommonController->getSession('session_zoneid');
		$session_userid=$session_zoneid_arr['sesuserid'];
		// if($session_userid==false) continue;

		

		

        $this->db->where('id', $id);

        $this->db->delete('zone_organization');

		

		$this->db->where('organizationid', $id);

        $this->db->delete('zone_announcement');

		

		$query = $this->db->query("SELECT userid FROM organization_owners_in_zone WHERE orgid=".$id);

		$result=$query->result_array();

		if(!empty($result)){

			$_uid=$result[0]['userid'];

		}else

			$_uid=0;		

		//var_dump($_uid); var_dump($session_userid); exit; 

		if($_uid!=0 && $_uid!=$session_userid){ 

			/*$this->db->where('id', $_uid);

        	$this->db->delete('users');		

			$this->db->where('user_id', $_uid);

        	$this->db->delete('users_groups');*/

		}

		$this->db->where('orgid', $id);

        $this->db->delete('organization_owners_in_zone');

		      

    }
	
	public function organization_status($id){
		$query = "SELECT approval FROM organization WHERE id=".$id;
		return $this->CommonController->SelectRawquery($query);
	}

	public function organization_zone($id){
		$query = "SELECT * FROM organization WHERE id=".$id;
		return $this->CommonController->SelectRawquery($query);
	}
	
	public function get_announcements_for_organization($zone_id = false,$org_id=false,$lowerlimit=false,$upperlimit=false){  
		$limit_where="";
		if($lowerlimit!='' && $upperlimit!=''){
			$limit_where=" limit ".$lowerlimit.",".$upperlimit;
		}
		$query = "SELECT * FROM organization_announcement WHERE orgid=".$org_id." and zoneid=".$zone_id." order by timestamp desc". $limit_where."";
		return $this->CommonController->SelectRawquery($query);		
   	}

	public function delete_announcement_org($id){
		$this->CommonController->deleteData('organization_announcement',['id'=>$id]);
	}
	
	public function save_broadcast($data){
		$msg = ['msg'=>'Something Went Wrong','type'=>'warning'];
		if (!empty($data['announceId']) && $data['announceId'] != -1) {
			$this->CommonController->updateData('organization_broadcast',$data,['announceId'=>$data['announceId']]);
			$msg = ['msg'=>'broadcast Updated Successfully','type'=>'success'];
		} else {
			$this->CommonController->InsertData('organization_broadcast', $data);
			$msg = ['msg'=>'broadcast Inserted Successfully','type'=>'success'];
		}
		return $msg;
	}

	function get_broadcast_by_id($id)

	{

		$query = $this->db->query("SELECT * FROM organization_broadcast WHERE announceId=".$id);

		return $query->row();

	}

	public function delete_broadcast($id=0){
		$this->CommonController->deleteData('organization_broadcast',['announceId'=>$id]);
	}

	public function display_all_broadcasts($zoneid=0, $orgid=0, $brodcastid = 0){
		$sql="SELECT * FROM organization_broadcast WHERE orgId=$orgid AND zoneId=$zoneid";
		if($brodcastid > 0){
			$sql .= " AND announceId=".$brodcastid."";	
		}
		return $this->CommonController->SelectRawquery($sql);
	}



	function all_broadcasts($zoneid=0, $orgid=0, $announced=false)

	{ //var_dump($createdby_type); exit;

	$sql="SELECT * FROM organization_broadcast WHERE orgId=$orgid AND zoneId=$zoneid AND announceDate >= CURDATE() ORDER BY announceDate";

		$query = $this->db->query($sql);

		$result = $query->result_array();

		return $result;

	}

	public function get_zoneinformation($zid){ 

		$sql="SELECT a.name as zname,b.first_name,b.last_name,b.email,b.phone FROM sales_zone a, users b WHERE a.sales_rep_id=b.id AND a.id=".$zid;

		$query = $this->db->query($sql);

        return $query->row();  

    }

	function announcement_status_change($anid=false,$option=false){

		$data = array('approval' => $option);

        $this->db->where('id', $anid);	

        $this->db->update('zone_announcement', $data);

	}

	function announcement_organization_status_change($orgid=0,$option=0){		

		$data = array('approval' => $option);

        $this->db->where('id', $orgid);	

        $this->db->update('zone_organization', $data);

		$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;

		$sql="SELECT group_concat(id) as id from zone_announcement where organizationid=".$orgid;

		$query=$this->db->query($sql);

		$result=$query->result_array(); 

		if(!empty($result)){

			$ann_ids= $result[0]['id']; 

		}

		if($ann_ids!=''){									

			$ups="UPDATE zone_announcement SET approval=".$option." WHERE id IN (".$ann_ids.")"; 

			$this->db->query($ups) ;			

		}		 

	}

}



class UpdateAnnouncement{

    var $zone_id;

    var $title;

    var $date_modified;

    var $announcement_text;



    public function __construct($data = false)

    {

        if(!empty($data) && is_array($data)){

          @set_magic_quotes_runtime(0); // Kill magic quotes

       

            $this->zone_id = $data['zone_id'];

            $this->title = stripslashes($data['title']);

            $this->date_modified = (empty($data['date_modified'])) ? date("Y-m-d h:i:s") : $data['date_modified'];

            $this->announcement_text = stripslashes($data['announcement_text']);

			$this->announcement_type = stripslashes($data['announcementtype']);

        }

}



}

class UpdateAnnouncement_org{

    var $zone_id;

    var $title;

    var $date_modified;

    var $announcement_text;



    public function __construct($data = false)

    {

        if(!empty($data) && is_array($data)){

          @set_magic_quotes_runtime(0); // Kill magic quotes

       

            $this->zone_id = $data['zone_id'];

            $this->title = stripslashes($data['title']);

            $this->date_modified = (empty($data['date_modified'])) ? date("Y-m-d h:i:s") : $data['date_modified'];

            $this->announcement_text = stripslashes($data['announcement_text']);

			$this->announcement_type = (!empty($data['announcement_type']))? stripslashes($data['announcement_type']) :0;

			$this->organizationid = (!empty($data['organization_id']))? stripslashes($data['organization_id']) :0;

        }

}



}

class UpdateOrganization{

    var $zone_id;

    var $title;

    var $date_modified;

    var $announcement_text;



    public function __construct($data = false)

    {

        if(!empty($data) && is_array($data)){

          @set_magic_quotes_runtime(0); // Kill magic quotes

       

            $this->zone_id = $data['zone_id'];

            $this->title = stripslashes($data['title']);

            $this->date_modified = (empty($data['date_modified'])) ? date("Y-m-d h:i:s") : $data['date_modified'];

            $this->announcement_text = stripslashes($data['announcement_text']);

        }

}



}