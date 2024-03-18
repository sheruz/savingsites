<?php
namespace App\Models\emailnotice;

use CodeIgniter\Model;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Email_notice extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->table = "tblClaimedZips";
        $this->CommonController = new CommonController();
    } 



	
	function view_group($zone_id=0){
		$sql="SELECT id,name FROM group_interest WHERE createdby_type=1 AND createdby_id=$zone_id AND assign_type=1 order by name asc"; 
		$query = $this->db->query($sql);
    	$result = $query->result_array();
		return $result;
	}

# + To get the ig which the zone owner have preapred	
	function view_group_zone($zone_id=0){
		$sql="SELECT id,name FROM group_interest WHERE createdby_type=1 AND createdby_id=$zone_id order by name asc"; 
		$query = $this->db->query($sql);
    	$result = $query->result_array();
		return $result;
	}
# - To get the ig which the zone owner have preapred

# + to get the ig for businesses only	   ==>==>==>==> To Do ===> need a condition to ensure that only activated businesses are visible in the show drop-down.
	function view_business_by_ig_type($zoneid=0, $approval=0){ 
		$sql = "SELECT a.name, a.id, c.status FROM business a, ads_setting_preferences b, group_interest c WHERE a.id = b.businessid AND 	b.settingszoneid =".$zoneid." AND c.createdby_type=2 AND c.createdby_id = a.id AND c.status = $approval group by a.id" ;
		$query = $this->db->query($sql);
		//$this->db->last_query();
    	$result = $query->result_array();
		return $result;
	}
# - to get the ig for businesses only
	
	function edit_group($group_id=0,$zoneid=0){
		$sql="SELECT id,name,description FROM group_interest WHERE id=$group_id";
		$query = $this->db->query($sql);
    	$result = $query->result_array();
		return $result;
	}
	
	function save_group($data=array(),$group_id=0,$zoneid=0){
		if($group_id==-1){
			if($data['createdby_type']==1){
				$status=1;
			}else if($data['createdby_type']==2){
				$status=$this->fn_check_zone_pref_for_interest_group($zoneid);
			}else if($data['createdby_type']==3){				
				$status=$this->fn_check_zone_pref_for_interest_group($zoneid);				
			}
			$data['status']=$status;

			$id = $this->CommonController->InsertData('group_interest', $data);
			!empty($id)? $success='insert' : $success='';
		}else{
			$is_updated = $this->CommonController->updateData('group_interest',$data,['id'=>$group_id]);
			!empty($is_updated) ? $success="update" : $success="";
		}
		return $success;
	}

	public function fn_check_zone_pref_for_interest_group($zoneid=0){
		$result = $this->CommonController->SelectDataMultiWay('zone_preferences','auto_approve_ig_by_org,auto_approve_ig_by_business','resultArray',['zoneid'=>$zoneid]);
		if(!empty($result)){
			if($result[0]['auto_approve_ig_by_org']==1){
				$status=1;
			}
			if($result[0]['auto_approve_ig_by_business']==1){
				$status=1;
			}
		}
		$status=(!empty($status) && $status==1) ? $status : 0; 		
		return $status;
	}
	public function delete_group($id=0,$param=''){
		if($param='zone'){
			$this->CommonController->deleteData('group_interest',['id'=>$id]);
		}
	}
	public function display_ig($zoneid=0,$createdby_id=0,$ig_type=0,$createdby_type=0){
		$sql="SELECT id,name,createdby_type,description FROM group_interest WHERE  createdby_type=$createdby_type AND createdby_id=$createdby_id AND status=$ig_type";
		return $this->CommonController->SelectRawquery($sql);
	}
	
	function display_group_business_by_zone($zoneid=0,$bus_id=0,$type=0){		
		if(!empty($bus_id))
		{
			$business_where = "" ;
			$business_where = " AND a.createdby_id IN (".str_replace('-',',',$bus_id).")";
			$sql="SELECT a.id,a.name,a.status FROM group_interest a,ads_setting_preferences b  WHERE a.createdby_id=b.businessid AND a.createdby_type=2 AND b.settingszoneid=$zoneid AND a.status=$type $business_where";
			$query= $this->db->query($sql);		    	
			$result=$query->result_array();
		}
		$result=!empty($result) ? $result : '';
		return $result;
	}
	function update_groups_business_by_zone($id=0,$status=0){
		$data=array();
		$data['status']=$status;
		$this->db->where('id', $id);
    	$this->db->update('group_interest', $data);
	}

# + Sourav-07/05/14 -> 	
	function group_visibility($zoneid=0,$createdby_id=0,$createdby_type=0,$option=1){ 			//var_dump($_REQUEST);exit;
		/*$sql="SELECT a.id,a.name FROM group_interest a,ads_setting_preferences b WHERE ((a.createdby_type=$createdby_type AND a.createdby_id=$createdby_id ) OR (a.createdby_id=b.settingszoneid AND a.createdby_type=1 AND a.createdby_id=$zoneid )) AND a.status=1 GROUP BY a.id";*/
		//var_dump($option); exit;
		if($option==1){
			$wh=" a.createdby_id=b.settingszoneid AND a.createdby_type=1 AND a.createdby_id=$zoneid and ";
			$wh1=" and c.createdby_id=d.zone_id and d.createdby_id=$createdby_id";
		}else if($option==2){  
			//$wh=" a.createdby_type=$createdby_type AND a.createdby_id=$createdby_id and ";
			//$wh1=" and c.createdby_id=d.createdby_id and d.createdby_id=$createdby_id";
			
			$wh=" a.createdby_type IN(1,2,3) AND a.createdby_id IN($zoneid,$createdby_id) and ";  // Added on 19/8/14 to view all the IG
			$wh1=" and c.createdby_id=d.createdby_id and d.createdby_id=$createdby_id";
			
		}else{
			$wh=''; $wh1='';
		}
		//$sql="SELECT a.id,a.name FROM group_interest a,ads_setting_preferences b WHERE $wh AND a.status=1 GROUP BY a.id"
		$sql="SELECT c.id,c.name,d.user
		FROM
		(SELECT a.id,a.name,a.createdby_id FROM group_interest a,ads_setting_preferences b WHERE $wh  a.status=1 GROUP BY a.id) as c
		LEFT JOIN (SELECT count(distinct id) AS user,interest_groupid,createdby_id,zone_id  from user_group_interest group by interest_groupid) AS d ON d.interest_groupid=c.id $wh1 
		";
		$query= $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
# - Sourav-07/05/14 -> 
	
	function get_display_group_for_zone($zoneid){		
		$sql='SELECT groupid from group_interest_display where zoneid='.$zoneid;		
    	$result_arr=$this->db->query($sql)->result_array();
		//var_dump($result_arr);		
		$displayzones='';
		for($i = 0 ; $i < count($result_arr) ; $i++) {
			$displayzones.= $result_arr[$i]['groupid']."," ;			
		}
		$displayzones = substr($displayzones,0,strlen($displayzones)-1);
		if($displayzones===false)
			return 0;
		else
			return $displayzones;
	}
	
	function add_group_display($groupid,$zoneid,$createdby_id,$createdby_type,$option){  //exit;
		$arr_actionedcateids=explode(',',$groupid); //var_dump($groupid);exit;
		
		if(!empty($createdby_id)){
			$this->db->where('displayid',$createdby_id);
			$this->db->delete('group_interest_display');
			if(!empty($groupid)){
				foreach($arr_actionedcateids as $v1){
					$data1=array();
					$data1=array('groupid'=>$v1,'zoneid'=>$zoneid,'displayid'=>$createdby_id,'displaytype'=>$createdby_type);
				//var_dump($data1);exit;
					$this->db->insert('group_interest_display',$data1);
				}
			}
		}
                         ###############  INTEREST GROUP AVAILABLE  FOR BUSINESS  AND   ORGANIZATION   ################
                                   
								   ########  THIS IS BEFORE CHANGING INTEREST GROUP CONCEPT   #############
		
		////get categoryid from category_display w.r.t $zoneid
//		$arr_existingcategories=array();
//		/*$this->db->select('groupid');
//		$this->db->where('zoneid',$zoneid);
//		$this->db->where('displayid',$createdby_id); 
//		$this->db->where('displaytype',$createdby_type);  
//		$query1=$this->db->get('group_interest_display');*/
//		
//		if($option==1){
//			//$wh=" a.createdby_id=b.settingszoneid AND a.createdby_type=1 AND a.createdby_id=$zoneid";
//			$wh=" and b.createdby_type=1 and createdby_id=$zoneid";
//			
//		}else if($option==2){
//			//$wh=" and displaytype=$createdby_type AND displayid=$createdby_id";
//			$wh=" and b.createdby_type=$createdby_type and b.createdby_id=$createdby_id";
//		}else{
//			$wh='';
//		}
//		$sql="select groupid from group_interest_display a,group_interest b where a.groupid=b.id and a.zoneid=$zoneid and a.displaytype=$createdby_type AND a.displayid=$createdby_id $wh and b.status=1"; 
//		
//		$query= $this->db->query($sql);	
//	//echo $this->db->last_query();	    	
//		$result1=$query->result();
//		//var_dump($result1); 
//		//$result1=$query1->result();//
//		//$this->db->last_query(); 
//		
//		if(isset($result1)){
//			$inc=0;
//			foreach($result1 as $vresult1){
//				//var_dump($vresult1);exit;
//				$arr_existingcategories[$vresult1->groupid]=$vresult1->groupid;
//				//var_dump($arr_existingcategories[$vresult1->groupid]);exit;
//				$inc++;
//			}
//		}
//		//var_dump($arr_existingcategories); //exit;
//		/*if(!empty($arr_existingcategories))
//		{*/
//			/*if(trim($groupid)==''){
//				$this->db->where_in('groupid',$arr_existingcategories); 
//				$this->db->where('zoneid',$zoneid);
//				$this->db->where('displayid',$createdby_id); 
//				$this->db->where('displaytype',$createdby_type); 																																																																					        	$this->db->delete('group_interest_display');//delete category	
//				
//			}else if(empty($arr_existingcategories) && !empty($arr_actionedcateids)){*/	
//			if(empty($arr_existingcategories) && !empty($arr_actionedcateids)){ //var_dump(1); exit;
//				foreach($arr_actionedcateids as $v1){
//					$data1=array();
//					$data1=array('groupid'=>$v1,'zoneid'=>$zoneid,'displayid'=>$createdby_id,'displaytype'=>$createdby_type);
//				//var_dump($data1);exit;
//					$this->db->insert('group_interest_display',$data1);
//				}
//			}else if(count($arr_existingcategories)!=count($arr_actionedcateids)){ //var_dump(2); exit;
//				$arrdiffdb2html=array_diff($arr_existingcategories,$arr_actionedcateids);
//				$arrdiffhtml2db=array_diff($arr_actionedcateids,$arr_existingcategories);
//				//var_dump($arrdiffdb2html); var_dump($arrdiffhtml2db); exit;
//				if(!empty($arrdiffdb2html)){
//					//delete from database		
//					foreach($arrdiffdb2html as $v1){
//						$this->db->where('groupid',$v1);
//						$this->db->where('zoneid',$zoneid);
//						$this->db->where('displayid',$createdby_id); 
//						$this->db->where('displaytype',$createdby_type); 																																																																					        			$this->db->delete('group_interest_display');
//					}
//				}
//				if(!empty($arrdiffhtml2db)){
//					//insert to database	
//					foreach($arrdiffhtml2db as $v2){
//						$data1=array();
//						$data1=array('groupid'=>$v2,'zoneid'=>$zoneid,'displayid'=>$createdby_id,'displaytype'=>$createdby_type);
//						$this->db->insert('group_interest_display',$data1);
//					}	
//				}
//			/*}else {
//				var_dump($arr_actionedcateids);
//			}*/
//		}else if($arr_actionedcateids[0]=='' && !empty($arr_existingcategories)){ //var_dump(3); exit;
//			foreach($arr_existingcategories as $v1){
//					$data1=array();
//					//$data1=array('groupid'=>$v1,'zoneid'=>$zoneid,'displayid'=>$createdby_id,'displaytype'=>$createdby_type);
//					//$this->db->insert('group_interest_display',$data1);
//					$this->db->where('groupid',$v1);
//						$this->db->where('zoneid',$zoneid);
//						$this->db->where('displayid',$createdby_id); 
//						$this->db->where('displaytype',$createdby_type); 																																																																					        			$this->db->delete('group_interest_display');
//				}
//		}
                  ###############  INTEREST GROUP AVAILABLE  FOR BUSINESS  AND   ORGANIZATION   ################

	}
	
	function active_group_display($zoneid=0,$createdby_id=0,$createdby_type=0,$user_id=0){
		$sql="SELECT DISTINCT gi.id,gi.name FROM (group_interest as gi,group_interest_display as gid) WHERE (gi.status=1 AND gid.displayid=$createdby_id AND gi.id=gid.groupid AND gid.displaytype=$createdby_type)";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;		
	}
	function active_subscribed_group_display($zoneid=0,$createdby_id=0,$createdby_type=0,$user_id=0){
		$sql="SELECT DISTINCT gi.id,gi.name FROM (group_interest as gi,group_interest_display as gid,user_group_interest as ugi) WHERE (gi.status=1 AND ugi.createdby_id=$createdby_id AND gi.id=ugi.interest_groupid AND ugi.type=$createdby_type)";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;		
	}
	function snap_status_check($zoneid=0,$createdby_id=0,$createdby_type=0,$user_id=0,$adid=0){
		$this->db->select('status');
		$_where=array('zone_id'=>$zoneid,'user_id'=>$user_id,'createdby_id'=>$createdby_id,'type'=>$createdby_type,'adid'=>$adid);
		$query=$this->db->get_where('user_offer_status',$_where);		
		$result=$query->result_array();
		$status = 0;
		if(!empty($result)){			
			$status=$result[0]['status'];
		} else {
			$this->db->select('status');
			$_where = array('created_for_zone' => $zoneid,'user_id' => $user_id);
			$snapGlobalQuery = $this->db->get_where('global_snap_settings',$_where);
			$snapGlobalResult = $snapGlobalQuery->row();
			if(!empty($snapGlobalResult)) {
				$status = $snapGlobalResult->status;
			}
		}
		return $status;
	}
	public function snap_sendtype_check($zoneid=0,$createdby_id=0,$createdby_type=0,$user_id=0,$adid=0){ 
		$send_type = 0;
		$_where=array('zone_id'=>$zoneid,'user_id'=>$user_id,'createdby_id'=>$createdby_id,'type'=>$createdby_type,'adid'=>$adid);
		$result = $this->CommonController->SelectDataMultiWay('user_offer_status','send_type','resultArray',$_where,[],'',[]);
		
		if(!empty($result)){			
			$send_type=$result[0]['send_type'];
		} else {
			$_where = array('user_id' => $user_id,'created_for_zone' => $zoneid);
			$globalSnapSendTypeResult = $this->CommonController->SelectDataMultiWay('global_snap_settings','snap_send_type','column',$_where,[],'',[]);
			if(!empty($globalSnapSendTypeResult)) {
				$send_type = $globalSnapSendTypeResult->snap_send_type;
			}
		}
		return $send_type;
	}
	
	public function interest_group_id($createdby_id=0,$type=0){
		$where_array=array('createdby_type'=>$type,'createdby_id'=>$createdby_id);
		$result = $this->CommonController->SelectDataMultiWay('group_interest','id','rowArray',$where_array,[],'',[]);
		return $result;
	}	
	 
	public function check_ig_display($user_id=0,$createdby_id=0,$zone_id=0,$type=0){
		$where_array=array('zone_id'=>$zone_id,'user_id'=>$user_id,'createdby_id'=>$createdby_id,'type'=>$type);
		$result = $this->CommonController->SelectDataMultiWay('user_group_interest','interest_groupid','rowArray',$where_array,[],'',[]);
		return $result;
	}	
	 
	public function user_group_interest_insert($user_id=0,$interest_group=false,$zone_id=0,$createdby_id=0,$type=0){
		!empty($interest_group) ? $interest_group_array=explode('@#$',$interest_group) : $interest_group_array='';

		$where_array=array('zone_id'=>$zone_id,'user_id'=>$user_id,'createdby_id'=>$createdby_id);
		$this->CommonController->deleteData('user_group_interest',$where_array);
		
		if(!empty($interest_group_array)){
			foreach($interest_group_array as $key=>$ig){
				$data=array(
					'zone_id'=>$zone_id,						
					'user_id'=>$user_id,
					'createdby_id'=>$createdby_id,
					'interest_groupid'=>$ig,
					'type'=>$type
				);
				$this->CommonController->InsertData('user_group_interest', $data);
			}	
		}
	}
	public function user_status_update($user_id=0,$zone_id=0,$createdby_id=0,$type=0,$status=0,$send_type=0,$snapweekDaysArray = array(),$snapTimeArray = array(),$minPercentage = NULL,$adid=0){
		$snapweekDays = "";
		$snapTime = "";
		if($minPercentage != NULL){ $minPercentage = (int)$minPercentage; }
		if(count($snapweekDaysArray) > 0){ $snapweekDays = implode(',',$snapweekDaysArray);}
		if(count($snapTimeArray) > 0){ $snapTime = implode(',', $snapTimeArray);}
		$type = (int)$type;
       	$sql="select * from user_offer_status where zone_id=$zone_id and user_id=$user_id and createdby_id=$createdby_id and type=".$type." and  adid=".$adid;
		$data = $this->CommonController->SelectRawquery($sql,'resultArray');

		if(count($data) > 0){
			$id=$data[0]['id'];
			$data = array(
				'status' => $status,
				'send_type' => $send_type,
				'snap_days_id' => $snapweekDays,
				'snap_time_id' => $snapTime,
				'snap_min_percentage_id' => $minPercentage,
				'adid'=>$adid
			);
			if($send_type != 0 || $status==0){	  
				$is_updated = $this->CommonController->updateData('user_offer_status',$data,['id' => $id]);
			}
		}else{
			$data_ins = array(
    			'zone_id' => $zone_id,
				'user_id' => $user_id,					
				'createdby_id' => $createdby_id,
				'type'=>$type,
				'snap_days_id' => $snapweekDays,
				'snap_time_id' => $snapTime,
				'snap_min_percentage_id' => $minPercentage,
				'status'=>$status,
				'send_type'=>$send_type,		//edited for org texting,
				'adid'=>$adid
    		);
    		$this->CommonController->InsertData('user_offer_status', $data_ins);
		}
	}
	
	function edit_broadcast($broadcast_id=0,$zoneid=0,$createdby_id=0,$createdby_type=0){
		$this->db->select('*');
		$this->db->where('broadcast_id',$broadcast_id); 
		$query =$this->db->get('voice_broadcast');
    	$result = $query->result_array();
		return $result;
	}
	
	function save_broadcast($data){	
		if(!empty($data['broadcast_id']))
		{
			$this->db->where('broadcast_id', $data['broadcast_id']);
            $is_updated=$this->db->update('voice_broadcast', $data);
			!empty($is_updated) ? $success="update" : $success="";
		}
		else
		{ 
			$this->db->insert('voice_broadcast', $data);
			$id=$this->db->insert_id();
			!empty($id)? $success='insert' : $success=' ';
		}
		return $success;
	}
		
	function delete_broadcast($id=0){
		$this->db->where('broadcast_id', $id);
		$this->db->delete('voice_broadcast');
	}
	
	function display_all_broadcasts($zoneid=0,$createdby_id=0,$createdby_type=0,$show_en_status_type=0){
		if($show_en_status_type=='1' || $show_en_status_type=='2'){
			$where_status=" and status=$show_en_status_type";
		}else if($show_en_status_type=='0'){
			$where_status=" and status IN(0,1,2)";
		}
		$sql="SELECT * FROM voice_broadcast WHERE createdby_type=$createdby_type AND createdby_id=$createdby_id AND zoneid=$zoneid AND offer_date >= CURDATE() $where_status";
		//var_dump($sql);
		$query = $this->db->query($sql);
    	$result = $query->result_array();
		return $result;
	}
	
	function all_broadcasts($zoneid=0,$createdby_id=0,$createdby_type=0){ //var_dump($createdby_type); exit;
		$sql="SELECT * FROM voice_broadcast WHERE createdby_type=$createdby_type AND status=1 AND createdby_id=$createdby_id AND zoneid=$zoneid ORDER BY offer_date";
		$query = $this->db->query($sql);
    	$result = $query->result_array();
		return $result;
	}
	
	function save_email_notice($zoneid=0,$createdby_id=0,$notice_name='',$notice_details='',$createdby_type='',$notice_id=0){	
		$data = array(
    			'subject' => $notice_name,
				'detail' => $notice_details,					
				'createdby_id' => $createdby_id,
				'zoneid'=>$zoneid,
				'createdby_type'=>$createdby_type,
				'timestamp'=>time(),
				'status'=>'1'
    	);
		if(!empty($notice_id))
		{
			$this->db->where('id', $notice_id);
            $is_updated=$this->db->update('email_notice', $data);
			//echo $this->db->last_query(); exit;			
			!empty($is_updated) ? $success="update" : $success="";
		}
		else
		{ 
			$this->db->insert('email_notice', $data);
			$id=$this->db->insert_id();
			!empty($id)? $success='insert' : $success=' ';
		}
		return $success;
	}
		
	function zone_owner_interested_group($zone_id=0,$id=0,$type=''){
		/*$sql="SELECT DISTINCT gi.id as gi_id,gi.name as gi_name FROM(group_interest as gi,group_interest_display as gid) WHERE (gid.zoneid=gi.createdby_id AND gi.status=1 AND gi.createdby_type=1) ";*/
		$sql="SELECT DISTINCT gi.id as gi_id,gi.name as gi_name FROM(group_interest as gi) WHERE (gi.createdby_id=$zone_id AND gi.status=1 AND gi.createdby_type=1) ";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		//echo $this->db->last_query();
		return $result;
		
	}
	
	function display_all_email_notice($zoneid=0,$createdby_id=0,$createdby_type=0,$show_en_status_type=0){
		if($show_en_status_type=='1' || $show_en_status_type=='2'){
			$where_status=" and status=$show_en_status_type";
		}else if($show_en_status_type=='0'){
			$where_status=" and status IN(0,1,2)";
		}
		$sql="SELECT id,subject,detail FROM email_notice WHERE createdby_type=$createdby_type AND createdby_id=$createdby_id AND zoneid=$zoneid $where_status";
		$query = $this->db->query($sql);
    	$result = $query->result_array();
		return $result;
	}
	
	function all_notices($zoneid=0,$createdby_id=0,$createdby_type=0){ //var_dump($createdby_type); exit;
		$sql="SELECT id,subject FROM email_notice WHERE createdby_type=$createdby_type AND status=1 AND createdby_id=$createdby_id AND zoneid=$zoneid ORDER BY `timestamp`";
		$query = $this->db->query($sql);
    	$result = $query->result_array();
		return $result;
	}
	
	function get_ig_group_name($zoneid=0,$createdby_id=0,$noticeid=0,$iggroup=0,$createdby_type=0){
		!empty($iggroup) ? $groupid=implode(',',$iggroup) : $groupid=$iggroup;
		$sql="SELECT DISTINCT ugi.interest_groupid as ig_id,gi.name as groupname FROM(user_group_interest as ugi,group_interest as gi) 
		      WHERE (ugi.interest_groupid IN($groupid) AND ugi.interest_groupid=gi.id AND ugi.createdby_id=$createdby_id AND ugi.zone_id=$zoneid AND ugi.type=$createdby_type) GROUP BY ugi.interest_groupid";		
		$query = $this->db->query($sql);
    	$result = $query->result();
		return $result;
	}
	function get_ig_email($zoneid=0,$createdby_id=0,$noticeid=0,$iggroup=0,$createdby_type=0){
		!empty($iggroup) ? $groupid=implode(',',$iggroup) : $groupid=$iggroup;
		$sql="SELECT DISTINCT u.email FROM(users as u,user_group_interest as ugi) 
		      WHERE (ugi.user_id=u.id AND ugi.interest_groupid IN($groupid) AND ugi.createdby_id=$createdby_id AND ugi.zone_id=$zoneid AND ugi.type=$createdby_type) GROUP BY u.email";		
		$query = $this->db->query($sql);
    	$result = $query->result();
		//echo $this->db->last_query();
		//echo '<pre>'; print_r($result);
		return $result;
	}
	function get_notice($zoneid=0,$createdby_id=0,$noticeid=0){
		$this->db->where('id', $noticeid);
		$this->db->select('id,subject,detail');
		$query=$this->db->get('email_notice');
		$result=$query->result();
		return $result;
	}
	
	function send_mail_to_all_group($zone_id=0,$owner_id=0,$mailtosent=false,$subject=false,$detail=false,$createdby_type=0,$all_groupname=false,$all_ig_id=false,$mailtosend=''){					
		//$i = 0;
		//echo '<pre>';print_r($mailtosend); exit;
		foreach($mailtosend as $key=>$val){
			
			foreach($val as $key1=>$val1){ 
				//var_dump($key1);
				$mailfromig = explode('#',$key1); 
				$fromemail='noreply@savingssites.com';
					$email_subject=$subject;
					/*$message_body="<div style='border:1px solid #900; padding:5px;'><br /><br />".$detail."<br/>
							<br /><br />
							Best Regards,<br />
							".$mailfromig[1]."</div>"; */
				$email_val = explode(',', $val1);		
				//$email_to = $email_val[$i];		var_dump($email_to);	
				$message_body=	'<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">
				<div style="width:960px; margin:0 auto !important;">
				<div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">
				<div style="background-color:#3f3f3f; height:70px;"><img src="'.base_url('assets/images/logo_white.png').'"   
				 style="margin:10px 202px;" alt="logo"/></div>
				<div style="clear:both"></div>
				<div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:150px; padding:15px;">
				<h2 style="text-align:left;">Description Email Notice:'."  "."<br>".$detail. 
				'</h2><h3 style="text-align:left; display:block; color:#666;">Best Regards, </h3>
				<p style="text-align:left; display:block; color:#333;"><h3 style="text-align:left;">
				' .$mailfromig[1].'</h3></p>
				</div>
				<div style="background-color:#999; height:60px;"></div>
				</div>
				</div>
				</body>';	
						
					$this->load->library('email');
					$this->email->clear();
					$this->email->from($fromemail);
					$this->email->subject($email_subject);
					$this->email->message($message_body);
					if($val1!=''){
						$this->email->to($val1);
						$this->email->bcc($val1);
						$s=$this->email->send();
						$to[]=$val1;
					}	
					if(!empty($s))
					{
						$data=array(	'recipient'=>$val1,
										'group_id'=>$all_ig_id,
										'group_name'=>$mailfromig[1],
										'subject'=>$subject,
										'detail'=>$detail,
										'status'=>1,
										'timestamp'=>time(),
										'createdby_type'=>$createdby_type,
										'createdby_id'=>$owner_id,
										'zoneid'=>$zone_id
									);
						$this->db->insert('email_notice_history',$data);			
					}	
					//$i++;
			}
		}
		$result="Notice Successfully Sent!";
		return $result;
	}
	
	function edit_en($notice_id=0,$zoneid=0,$createdby_id=0,$createdby_type=0){
		$this->db->select('id,subject,detail');
		$this->db->where('id',$notice_id);
		//$this->db->where('zoneid', $zoneid);
		//$this->db->where('createdby_id',$createdby_id);
		//$this->db->where('createdby_type',$createdby_type);
		$query =$this->db->get('email_notice');
    	$result = $query->result_array();
		return $result;
	}

	function getZonedetails($zone_id=0){
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
	}
		
	function delete_en($id=0){
		//$this->db->delete('mytable', array('id' => $id)); 
		$this->db->where('id', $id);
		$this->db->delete('email_notice');
	}
	function view_email_notice_history($createdby_id=0,$zone_id=0,$createdby_type=''){	
		$this->db->where('createdby_type',$createdby_type);
		$this->db->where('createdby_id',$createdby_id);
		$this->db->where('zoneid',$zone_id);
		$this->db->select('id,group_id,group_name,recipient,subject,detail,timestamp');
		$query=$this->db->get('email_notice_history');
		$result = $query->result_array();
		//echo '<pre>'; print_r($result); exit;
		return $result;
		
	}
	function view_detail_email_history($id=0){
		$this->db->where('id',$id);
		$this->db->select('id,group_id,group_name,recipient,subject,detail,timestamp');	
		$query=$this->db->get('email_notice_history');
		$result = $query->result_array();
		//echo '<pre>';print_r($result);exit;
		return $result;
		
	}
	
	function delete_history($id=0){
		$this->db->where('id', $id);
		$this->db->delete('email_notice_history');
	}
	
	function get_all_org_againest_zone($zoneid=0){		
		$array=array('zoneid'=>$zoneid, 'approval'=>1);
		$this->db->where($array); 
		$this->db->select('id,name');
		$query=$this->db->get('organization');
		$result=$query->result_array();		
		return $result;
	}
	// To Do : =>=>=> Need a condition (a.approval = 1) for active organization
	public function get_all_org_for_zone($zoneid=0,$status=0){
		//echo $sql = "SELECT  a.name, a.zoneid, b.id, b.status FROM organization a ,group_interest b WHERE b.createdby_id = a.id AND a.zoneid=".$zoneid." AND b.status=".$status;
		$sql = "SELECT a.id, a.name, b.status FROM organization a, group_interest b
				WHERE a.id = b.createdby_id AND a.zoneid = $zoneid AND
				b.createdby_type = 3 AND
				b.status=$status group by a.id";
		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	} 
	
	function display_group_org_by_zone($zoneid=0,$org_id=0,$type=0){
		$array=array('createdby_type'=>3, 'createdby_id'=>$org_id, 'status'=>$type);
		$this->db->where($array); 
		$this->db->select('id,name,status');
		$query=$this->db->get('group_interest');
		$result=$query->result_array();		
		return $result;
	}
	function get_email_by_ig($ig_arr = '', $zoneid = 0, $type = 0){ //var_dump($ig_arr);
		$arr = array() ;
		$send_typeval = " AND uos.send_type in (1,2,3)";
		foreach($ig_arr as $key=>$val){ //echo $key;
			$email ='';
			$sql = "SELECT DISTINCT u.email as email FROM(users as u,user_group_interest as ugi, user_offer_status as uos)
			 WHERE (ugi.user_id=u.id AND uos.user_id = u.id AND ugi.interest_groupid IN($key) AND ugi.zone_id=$zoneid AND ugi.type=$type $send_typeval)" ;  
			$query = $this->db->query($sql) ;
			$result = $query->result_array() ; 
			foreach($result as $k=>$v){			
				$email .= $v['email'].',';
			}
			$arr[$key][$key.'#'.$val] = substr($email,0,strlen($email)-1) ;
		}
		return $arr ;
	}
	// for getting phone by ig
	function get_phone_by_ig($ig_arr = '', $zoneid = 0, $type = 0){
		$arr = array() ;
		foreach($ig_arr as $key=>$val){ //echo $key;
			$phone ='';
			$sql = "SELECT DISTINCT u.phone as phone,u.carrier as carrier FROM(users as u,user_group_interest as ugi, user_offer_status as uos)
			 WHERE (ugi.user_id=u.id AND uos.user_id = u.id AND ugi.interest_groupid IN($key) AND ugi.zone_id=$zoneid AND ugi.type=$type AND uos.send_type = 2)" ;  
			$query = $this->db->query($sql) ;
			$result = $query->result_array() ; 
			foreach($result as $k=>$v){	
				if($v['phone'] != '' && $v['carrier'] != ''){		
					$phone .= $v['phone'].'@'.$v['carrier'].',';
				}
			}
			$arr[$key][$key.'#'.$val] = substr($phone,0,strlen($phone)-1) ;
		}
		return $arr ;
	}
	
	function get_email_phone_by_ig($ig_arr = '', $zoneid = 0, $type = 0){
		$arr = array() ;
		foreach($ig_arr as $key=>$val){ //echo $key;
			$phoneandemail ='';
			$sql = "SELECT DISTINCT u.email as email,u.phone as phone,u.carrier as carrier FROM(users as u,user_group_interest as ugi, user_offer_status as uos)
			 WHERE (ugi.user_id=u.id AND uos.user_id = u.id AND ugi.interest_groupid IN($key) AND ugi.zone_id=$zoneid AND ugi.type=$type AND uos.send_type = 3)" ;  
			$query = $this->db->query($sql) ;
			$result = $query->result_array() ; 
			foreach($result as $k=>$v){		
				if($v['phone'] != '' && $v['carrier'] != '' && $v['email'] != ''){	
					$phoneandemail .= $v['phone'].'@'.$v['carrier'].','.$v['email'].',';
				}
			}
			$arr[$key][$key.'#'.$val] = substr($phoneandemail,0,strlen($phoneandemail)-1) ;
		}
		return $arr ;
	}
	
	// send sms to ig users
	function send_text_to_all_group($zone_id=0,$owner_id=0,$mailtosent=false,$subject=false,$detail=false,$createdby_type=0,$all_groupname=false,$all_ig_id=false,$texttosend=''){	
		//echo '<pre>';print_r($texttosend); exit;
		foreach($texttosend as $key=>$val){
			//var_dump($val);
			foreach($val as $key1=>$val1){
				//var_dump($key1);
				$mailfromig = explode('#',$key1);
				$fromemail='noreply@savingssites.com';
					$email_subject=$subject;
					$message_body="<div style='border:1px solid #900; padding:5px;'><br /><br />".$detail."<br/>
							<br /><br />
							Best Regards,<br />
							".$mailfromig[1]."</div>"; 
					$this->load->library('email');
					$this->email->clear();
					$this->email->from($fromemail);
					$this->email->subject($email_subject);
					$this->email->message($message_body);
					if($val1!=''){
						$this->email->to("");
						$this->email->bcc($val1);
						$s=$this->email->send();
						$to[]=$val1;
					}	
					if(!empty($s))
					{
						$data=array(	'recipient'=>$val1,
										'group_id'=>$all_ig_id,
										'group_name'=>$mailfromig[1],
										'subject'=>$subject,
										'detail'=>$detail,
										'status'=>1,
										'timestamp'=>time(),
										'createdby_type'=>$createdby_type,
										'createdby_id'=>$owner_id,
										'zoneid'=>$zone_id
									);
						$this->db->insert('email_notice_history',$data);			
					}	
			}
		}
		$result="Notice Successfully Sent!";
		return $result;
	}
	
	// send both email and sms to ig users
	function send_email_and_text_to_all_group($zone_id=0,$owner_id=0,$mailtosent=false,$subject=false,$detail=false,$createdby_type=0,$all_groupname=false,$all_ig_id=false,$mailtexttosend=''){	
	
	//var_dump($mailtexttosend);exit;
		//echo '<pre>';print_r($mailtexttosend); exit;
		foreach($mailtexttosend as $key=>$val){
			//var_dump($val);
			foreach($val as $key1=>$val1){
				//var_dump($key1);
				$mailfromig = explode('#',$key1);
				$fromemail='noreply@savingssites.com';
					$email_subject=$subject;
					$message_body="<div style='border:1px solid #900; padding:5px;'><br /><br />".$detail."<br/>
							<br /><br />
							Best Regards,<br />
							".$mailfromig[1]."</div>"; 
					$this->load->library('email');
					$this->email->clear();
					$this->email->from($fromemail);
					$this->email->subject($email_subject);
					$this->email->message($message_body);
					if($val1!=''){
						$this->email->to("");
						$this->email->bcc($val1);
						$s=$this->email->send();
						$to[]=$val1;
					}	
					if(!empty($s))
					{
						$data=array(	'recipient'=>$val1,
										'group_id'=>$all_ig_id,
										'group_name'=>$mailfromig[1],
										'subject'=>$subject,
										'detail'=>$detail,
										'status'=>1,
										'timestamp'=>time(),
										'createdby_type'=>$createdby_type,
										'createdby_id'=>$owner_id,
										'zoneid'=>$zone_id
									);
						$this->db->insert('email_notice_history',$data);			
					}	
			}
		}
		$result="Notice Successfully Sent!";
		return $result;
	}

	function email_notice_history($id,$zone_id=0,$businessid = 0,$createdby_type=0){
		$this->db->where('createdby_type',$createdby_type);
		$this->db->where('createdby_id',$businessid);
		$this->db->where('zoneid',$zone_id);
		$this->db->where('id',$id);
		$this->db->select('id,group_id,group_name,recipient,subject,detail,timestamp');
		$query=$this->db->get('email_notice_history');
		$result = $query->result_array(); 
		//echo '<pre>'; print_r($result); exit;
		return $result;
		
	}
	function email_notice_history_org($id,$zone_id=0,$organizationid = 0,$createdby_type=0){
		$this->db->where('createdby_type',$createdby_type);
		$this->db->where('createdby_id',$organizationid);
		$this->db->where('zoneid',$zone_id);
		$this->db->where('id',$id);
		$this->db->select('id,group_id,group_name,recipient,subject,detail,timestamp');
		$query=$this->db->get('email_notice_history');
		$result = $query->result_array(); 
		//echo '<pre>'; print_r($result); exit;
		return $result;
		
	}
	
	/**
	*
	*
	*/
	
	function show_user_details($zoneid){
		$this->db->select('users.*,zone_residentuser.zone_residentuser_zoneid');
        $this->db->from('users', 'users');
        $this->db->join('zone_residentuser', 'users.id = zone_residentuser.zone_residentuser_userid');
		$this->db->where('zone_residentuser_zoneid',$zoneid);
        $query = $this->db->get();
		$result = $query->result_array(); //echo "<pre>";print_r($result);exit;
		return $result;
	}
	
	/*function showResident($zoneid = false,$charval = false,$lowerlimit = false,$upperlimit = false){
		if(empty($zoneid)) { return false;}	
		if($lowerlimit!='' && $upperlimit!=''){
			$limit_where=" limit ".$lowerlimit.",".$upperlimit;
		}else{
			$limit_where="";
		}
	//echo "SELECT a.* FROM users a,zone_residentuser b WHERE a.id=b.zone_residentuser_userid and b.zone_residentuser_zoneid=".$zoneid." ".$where_orderby." ".$limit_where." ";exit;
		
		$query = $this->db->query("SELECT a.* FROM users a,zone_residentuser b WHERE a.id=b.zone_residentuser_userid and b.zone_residentuser_zoneid=".$zoneid." ".$where_orderby." ".$limit_where." ");
		$result = $query->result_array();
	    return $result;
	}
	*/
	
	/**
	*	Category of created announcement by organization			by cr7
	*
	*/
	
	public function getcategoryofcreatedannouncement($zoneid){
		$builder = $this->db->table('organization_category as b');
        $builder->select('b.id,b.name,c.name AS orgname');
        $builder->join('organization as c', 'c.id = b.orgid');
        $builder->where('c.approval',1);
		$builder->where('b.parent_id',0);
		$builder->where('c.zoneid',$zoneid);
		$builder->groupBy('b.id'); 
        $query = $builder->get();
        $result = $query->getResultArray();
		return $result;
	}
	
	/**
	*	Get selected organization category of a user			by cr7
	*
	*/
	
	function selectedcategoryoforganization($zoneid='', $org_id='', $loggeduserid=''){
		$this->db->select('a.*');
        $this->db->from('organization_category a');
		$this->db->where('a.orgid',$org_id);
        $query = $this->db->get();
		$result = $query->result_array(); //echo "<pre>";print_r($result);exit;
		$selectedvalue = array(); 
		
		if(!empty($result)){
			
			foreach($result as $val){
				$this->db->select('a.*');
				$this->db->from('resident_interestedcategory a');
				$this->db->like('selectedcategory',','.$val['id'].',');
				$this->db->where('a.zoneid',$zoneid);
				$this->db->where('a.resident_userid',$loggeduserid);
				$query 	= $this->db->get();
				if($query->num_rows() == 1){
					$temp 						= array() ;
					$selectedcategory_details 	= $query->row() ;
					
					$temp['catid'] 				= $val['id'] ;
					$temp['catname'] 			= $val['name'] ;
					$temp['ischecked'] 			= (preg_match(','.$val['id'].',',trim($selectedcategory_details->activecategory,' ')) == true) ? '1' : '0' ;
					$selectedvalue[]			= $temp ;
				}
			}
		}//echo "<pre>";print_r($selectedvalue);exit;
		return $selectedvalue;
	}
	
	/**
	*	Update organization category status			by cr7
	*
	*/
	function changeorganizationcategorystatus($zone_id = '', $user_id = '', $category_id = ''){
		if($zone_id != '' && $user_id != '' && $category_id != ''){
		
		// + Select category details of current user
			$this->db->from('resident_interestedcategory');
			$this->db->where('zoneid',$zone_id);
			$this->db->where('resident_userid',$user_id);
			$query 	= $this->db->get();
		// - Select category details of current user
			if($query->num_rows() == 1){	
				$temp 						= array() ;
				$selectedcategory_details 	= $query->row() ;
				
				if($selectedcategory_details->activecategory != ''){												// Already have active category
				
					if(preg_match('/,'.$category_id.',/',trim($selectedcategory_details->activecategory,' '))){		// Current category is in active ?
					
						if($selectedcategory_details->activecategory == ','.$category_id.','){						// If only current category selected
							$activecategory = str_replace(','.$category_id.',', '', $selectedcategory_details->activecategory) ;
						}else{																						// Others category with current cat
							$activecategory = str_replace(','.$category_id.',', ',', $selectedcategory_details->activecategory) ;
						}
						
					}else{																							// Current category is not active
						$activecategory = $selectedcategory_details->activecategory.$category_id.',' ;	
					}
					
				}else{																								// Do not have any active category
					$activecategory = ','.$category_id.',' ;
				}
			// + Update status
				$this->db->where('zoneid', $zone_id);
				$this->db->where('resident_userid', $user_id);
				$is_updated	= $this->db->update('resident_interestedcategory', array('activecategory'=>$activecategory));
				if($is_updated){
					return true ;
				}
			// - Update status
			}
			
		}else{
			return false ;	
		}
	}


    ###############################################################################################################################################################################

	
	/**
	*	Get info about email offers criteria		by L10
	*
	*/
	
	/*function email_offers_criteria(){
		$this->db->select('*');
		$this->db->from('email_offers_criteria');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}*/
	
	public function email_offers_criteria($parent_id = ''){
		$array = array($parent_id);
		$query = $this->db->table('email_offers_criteria')->select('*')->whereNotIn('parent_id',$array)->get();
        $result = $query->getResultArray();
		return $result;
	}
	
	
	/**
	*	Select insert user email offers criteria		by L10
	*
	*/
	function insert_users_email_offer($userid,$zone_id,$all_email_offers_criteria_id){
		$insertvalues = '';
		$all_criteria_id = explode(',', $all_email_offers_criteria_id);
			
			foreach($all_criteria_id as $criteria_id){
				$users_email_offers_details=array(
				  'usersid'=>$userid,
				  'zoneid'=>$zone_id,
				  'email_offers_criteria_id'=>$criteria_id,
				  'users_email_offers_timestamp'=>time(),
				  'users_email_offers_status'=> 1
				);	
				$this->db->insert('users_email_offers', $users_email_offers_details);
			}
	}
	
	# + Start Email offer details view

			function users_email_offers($zoneid,$age_residentuser,$resident_gender,$resident_info,$lowerlimit,$upperlimit,$dropdownval){
					if($age_residentuser == 1){ // + for resident age drop down value
						//$age_criteria_id = '1,2,3,4';
						$this->db->select('email_offers_criteria_id');
						$this->db->from('email_offers_criteria');
						$this->db->where('parent_id',$age_residentuser);
						$query1 = $this->db->get();
						$result1 = $query1->result_array();
						foreach($result1 as $val){
							$age_criteria .= $val['email_offers_criteria_id'].',';
						}
						$age_criteria_val = substr($age_criteria,0,-1);
						$age_criteria_id = $age_residentuser.','.$age_criteria_val;
						
						$user_agearr = array();
						$userage_explode = explode(',', $age_criteria_id);
							foreach($userage_explode as $ageval){
								$user_agearr[] = $ageval;
							}
					}else{
						$age_criteria_id = $age_residentuser;
						$user_agearr[] = $age_criteria_id;
					}
				if($resident_gender == 5){ // + for resident gender infi++
						//$gender_criteria_id = '5,6,7';
						$this->db->select('email_offers_criteria_id');
						$this->db->from('email_offers_criteria');
						$this->db->where('parent_id',$resident_gender);
						$query2 = $this->db->get();
						$result2 = $query2->result_array();
						
						foreach($result2 as $val2){
							$gender_criteria .= $val2['email_offers_criteria_id'].',';
						}
						$gender_criteria_val = substr($gender_criteria,0,-1);
						$gender_criteria_id = $resident_gender.','.$gender_criteria_val;
						
						$user_genderarr = array();
						$usergender_explode = explode(',', $gender_criteria_id);
							foreach($usergender_explode as $genderval){
								$user_genderarr[] = $genderval;
							}
					}else{
						$gender_criteria_id = $resident_gender;
						$user_genderarr[] = $gender_criteria_id;
					}
					
				if($resident_info == 8){ // + for a resident rent info 
						//$rental_criteria_id = '8,9,10';
						$this->db->select('email_offers_criteria_id');
						$this->db->from('email_offers_criteria');
						$this->db->where('parent_id',$resident_info);
						$query3 = $this->db->get();
						$result3 = $query3->result_array();
						
						foreach($result3 as $val3){
							$rental_criteria .= $val3['email_offers_criteria_id'].',';
						}
						$rental_criteria_val = substr($rental_criteria,0,-1);
						$rental_criteria_id = $resident_info.','.$rental_criteria_val;
						
						$user_residentarr = array();
						$userresident_explode = explode(',', $rental_criteria_id);
							foreach($userresident_explode as $residentval){
								$user_residentarr[] = $residentval;
							}
						
					}else{
						$rental_criteria_id = $resident_info;
						$user_residentarr[] = $rental_criteria_id;
					}
				
					$total_criteria_arr = array(array_filter($user_agearr),array_filter($user_genderarr),array_filter($user_residentarr));
					
					$arr_total_criteriaval = array_filter($total_criteria_arr);
					
					$total_criteria_val = array();
					foreach($arr_total_criteriaval as $t_c_l){
						$total_criteria_val[] = $t_c_l;
					}
					$count_criteria = count($total_criteria_val);
					$criteria_arr = array();
					for($i=0; $i<$count_criteria; $i++){
						$this->db->select('usersid');
						$this->db->from('users_email_offers');
						$this->db->where_in('email_offers_criteria_id',$total_criteria_val[$i]); 
						$criteria_query = $this->db->get();
				        $criteria_result=$criteria_query->result_array();
						$criteria_arr[$i] = $criteria_result;
					} //echo "<pre>"; var_dump($criteria_arr);exit;
					$total_count = count($criteria_arr);
					
					$array_common = array();
					 if($total_count!=1){
						for($j=0; $j<$total_count; $j++){
							  foreach($criteria_arr[$j] as $key=>$arrval){
								  $array_common[$j][] = $arrval['usersid'];
							  }
						}
						$intersect = call_user_func_array('array_intersect',$array_common); 
					 }else{
				         
						 $countid = 0;
						 foreach($criteria_arr as $arrval){
							 foreach($arrval as $key=>$subarrval){
								 $array_common[] = $subarrval['usersid'];
							 }
						 }  
						  $intersect = $array_common;
					 }
					//echo "<pre>"; var_dump($intersect);exit;
					$all_criteria = addslashes($age_criteria_id.','.$gender_criteria_id.','.$rental_criteria_id);  
				# + Store an array selective criteria value 	
					$all_criteria_id = array();
					$all_criteria_explode = explode(',',$all_criteria);
					foreach($all_criteria_explode as $val){
						$all_criteria_id[] = $val;
					}
				# - Store an array selective criteria value 
				
				$intersect = !empty($intersect) ? $intersect : '';
				# + Store an another array selective criteria value 	
				        $this->db->select('GROUP_CONCAT(email_offers_criteria_id) as criteria_id');
						$this->db->from('users_email_offers');
						$this->db->where_in('usersid',$intersect); 
						$this->db->group_by('users_email_offers_id'); 
						$criteria_query1 = $this->db->get();
				        $criteria_result1=$criteria_query1->result_array();
						$sort_select = array();
						foreach($criteria_result1 as $sort_selectval){
							$sort_select[] = $sort_selectval['criteria_id'];
						}
				
				$this->db->select('GROUP_CONCAT(a.users_email_offers_id) as users_email_offers_id, GROUP_CONCAT(a.email_offers_criteria_id) as email_offers_criteria_id, GROUP_CONCAT(c.email_offers_criteria_value) as email_offers_criteria_value, d.*');
				$this->db->from('users_email_offers as a,sales_zone as b');
				$this->db->join('email_offers_criteria c', 'c.email_offers_criteria_id=a.email_offers_criteria_id');
				$this->db->join('users as d', 'd.id=a.usersid');

				if(($age_residentuser == 1) && ($resident_gender == 5) && ($resident_info == 8)){
					$this->db->where_in('a.email_offers_criteria_id',$all_criteria_id); 
				}else{
				    $sort_select = !empty($sort_select) ? $sort_select : ''; //echo "<pre>";var_dump($sort_select);exit;
					if(!empty($sort_select)){
						$sort_selectarr = array_merge($user_agearr,$user_genderarr,$user_residentarr);
					} 
					$arrval_coomon = array_filter($sort_selectarr);
					$arrval_coomon = !empty($arrval_coomon) ? $arrval_coomon : '';//var_dump($intersect);exit;
					if($dropdownval == ''){
						$this->db->where_in('a.email_offers_criteria_id',$arrval_coomon);	
						$this->db->where_in('a.usersid',$intersect);	
					}
				}
				$this->db->where('b.id', $zoneid);
				$this->db->order_by('a.users_email_offers_timestamp','desc');
				$this->db->limit($upperlimit,$lowerlimit);
				$this->db->group_by('a.usersid');
				$query = $this->db->get(); //echo $this->db->last_query();exit;
				$result=$query->result_array();//echo $this->db->last_query();exit;
				return $result;
		}




	# + End Email offer details view
	
	function businessid($busid){
		$this->db->select('a.contactemail,b.email');
		$this->db->from('business a');
		$this->db->join('users b', 'b.id=a.business_owner_id');
		$this->db->where('a.id', $busid);
		$query = $this->db->get();
		$result = $query->result_array();
		$contactemail = ($result[0]['contactemail'] !='') ? ($result[0]['contactemail']) : ''; 
		$email = $result[0]['email'] !='' ? $result[0]['email'] : $contactemail; 
		return $email;
	}
	
	function view_emailcredit_offer($zoneid,$businessid,$criteriaid,$all,$lowerlimit=false,$upperlimit=false,$age_residentuser=false,$resident_gender=false,$resident_info=false){
	 /*if($age_residentuser == 1){
					$this->db->select('email_offers_criteria_id');
					$this->db->from('email_offers_criteria');
					$this->db->where('parent_id',$age_residentuser);
					$query1 = $this->db->get();
					$result1 = $query1->result_array();
					foreach($result1 as $val){
						$age_criteria .= $val['email_offers_criteria_id'].',';
					}
					$age_criteria_val = substr($age_criteria,0,-1);
					$age_criteria_id = $age_residentuser.','.$age_criteria_val;
				}else{
					$age_criteria_id = $age_residentuser;
				}
			if($resident_gender == 5){
					$this->db->select('email_offers_criteria_id');
					$this->db->from('email_offers_criteria');
					$this->db->where('parent_id',$resident_gender);
					$query2 = $this->db->get();
					$result2 = $query2->result_array();
					
					foreach($result2 as $val2){
						$gender_criteria .= $val2['email_offers_criteria_id'].',';
					}
					$gender_criteria_val = substr($gender_criteria,0,-1);
					$gender_criteria_id = $resident_gender.','.$gender_criteria_val;
				}else{
					$gender_criteria_id = $resident_gender;
				}
				
			if($resident_info == 8){
					$this->db->select('email_offers_criteria_id');
					$this->db->from('email_offers_criteria');
					$this->db->where('parent_id',$resident_info);
					$query3 = $this->db->get();
					$result3 = $query3->result_array();
					
					foreach($result3 as $val3){
						$rental_criteria .= $val3['email_offers_criteria_id'].',';
					}
					$rental_criteria_val = substr($rental_criteria,0,-1);
					$rental_criteria_id = $resident_info.','.$rental_criteria_val;
					
				}else{
					$rental_criteria_id = $resident_info;
				}*/
	  			
	      	if($age_residentuser == 1){ // + for resident age drop down value
	  					//$age_criteria_id = '1,2,3,4';
						$this->db->select('email_offers_criteria_id');
						$this->db->from('email_offers_criteria');
						$this->db->where('parent_id',$age_residentuser);
						$query1 = $this->db->get();
						$result1 = $query1->result_array();
						foreach($result1 as $val){
							$age_criteria .= $val['email_offers_criteria_id'].',';
						}
						$age_criteria_val = substr($age_criteria,0,-1);
						$age_criteria_id = $age_residentuser.','.$age_criteria_val;
						
						$user_agearr = array();
						$userage_explode = explode(',', $age_criteria_id);
							foreach($userage_explode as $ageval){
								$user_agearr[] = $ageval;
							}
					}else{
						$age_criteria_id = $age_residentuser;
						$user_agearr[] = $age_criteria_id;
					}
			if($resident_gender == 5){ // + for resident gender infi++
						//$gender_criteria_id = '5,6,7';
						$this->db->select('email_offers_criteria_id');
						$this->db->from('email_offers_criteria');
						$this->db->where('parent_id',$resident_gender);
						$query2 = $this->db->get();
						$result2 = $query2->result_array();
						
						foreach($result2 as $val2){
							$gender_criteria .= $val2['email_offers_criteria_id'].',';
						}
						$gender_criteria_val = substr($gender_criteria,0,-1);
						$gender_criteria_id = $resident_gender.','.$gender_criteria_val;
						
						$user_genderarr = array();
						$usergender_explode = explode(',', $gender_criteria_id);
							foreach($usergender_explode as $genderval){
								$user_genderarr[] = $genderval;
							}
					}else{
						$gender_criteria_id = $resident_gender;
						$user_genderarr[] = $gender_criteria_id;
					}
					
		    if($resident_info == 8){ // + for a resident rent info 
						//$rental_criteria_id = '8,9,10';
						$this->db->select('email_offers_criteria_id');
						$this->db->from('email_offers_criteria');
						$this->db->where('parent_id',$resident_info);
						$query3 = $this->db->get();
						$result3 = $query3->result_array();
						
						foreach($result3 as $val3){
							$rental_criteria .= $val3['email_offers_criteria_id'].',';
						}
						$rental_criteria_val = substr($rental_criteria,0,-1);
						$rental_criteria_id = $resident_info.','.$rental_criteria_val;
						
						$user_residentarr = array();
						$userresident_explode = explode(',', $rental_criteria_id);
							foreach($userresident_explode as $residentval){
								$user_residentarr[] = $residentval;
							}
						
					}else{
						$rental_criteria_id = $resident_info;
						$user_residentarr[] = $rental_criteria_id;
					}
				
					$total_criteria_arr = array(array_filter($user_agearr),array_filter($user_genderarr),array_filter($user_residentarr));
					
					$arr_total_criteriaval = array_filter($total_criteria_arr);	//echo "<pre>";var_dump($arr_total_criteriaval);exit;	
				
			        $total_criteria_val = array();
					foreach($arr_total_criteriaval as $t_c_l){
						$total_criteria_val[] = $t_c_l;
					}
					$count_criteria = count($total_criteria_val);//echo "<pre>";var_dump($total_criteria_val);exit;	
					$criteria_arr = array();
					for($i=0; $i<$count_criteria; $i++){
						$this->db->select('b.business_email_id ');
						$this->db->from('users_email_offers a');
						$this->db->join('business_email_to_users b', 'a.users_email_offers_id=b.users_email_offers_id');
						$this->db->where_in('a.email_offers_criteria_id',$total_criteria_val[$i]); // $businessid
						$this->db->where('b.businessid', $businessid);
						$this->db->group_by('b.business_email_id');
						$criteria_query = $this->db->get(); //echo "<pre>"; echo $this->db->last_query();
				        $criteria_result=$criteria_query->result_array();
						$criteria_arr[$i] = $criteria_result;
					}//echo "<pre>";var_dump($criteria_arr);exit;	
					
					$total_count = count($criteria_arr);//var_dump($total_count);exit;	
					 if($total_count!=1){
						 $common_val = call_user_func_array('array_intersect',$criteria_arr);
					 }else{
						 $common_val = $criteria_arr;
					 }
					
					
				  if(!empty($common_val)){
					$array_common = array();
					 if($total_count!=1){
						for($j=0; $j<$total_count; $j++){
							  foreach($criteria_arr[$j] as $key=>$arrval){
								  $array_common[$j][] = $arrval['business_email_id'];
							  }
						}//echo "<pre>";var_dump($array_common);exit;	
						$intersect = call_user_func_array('array_intersect',$array_common); 
					 }else{
				         
						 $countid = 0;
						 foreach($criteria_arr as $arrval){
							 foreach($arrval as $key=>$subarrval){
								 $array_common[] = $subarrval['business_email_id'];
							 }
						 }  
						  $intersect = $array_common;
					 } //echo "<pre>";var_dump($intersect);exit;	
					}else{
						$intersect = '';
					}
					
					$all_criteria = addslashes($age_criteria_id.','.$gender_criteria_id.','.$rental_criteria_id);  
					
					# + Store an array selective criteria value 	
					$all_criteria_id = array();
					$all_criteria_explode = explode(',',$all_criteria);
					foreach($all_criteria_explode as $val){
						$all_criteria_id[] = $val;
					}
				# - Store an array selective criteria value 
			
			
			$all_criteria = addslashes($age_criteria_id.','.$gender_criteria_id.','.$rental_criteria_id);  
			$all_criteria_id = array();
			$all_criteria_explode = explode(',',$all_criteria);
			
			foreach($all_criteria_explode as $val){
				$all_criteria_id[] = $val;
			}
			
			
			$display_criteria_arr = array();
			$pagination_arr = array();
			if($criteriaid!=''){
				$display_criteria_explode = explode('##',$criteriaid); //echo "<pre>";var_dump($display_criteria_explode);exit;
				$dataval_arr = array();
				foreach($display_criteria_explode as $dataval){
					$dataval_explode = explode(',',$dataval); //echo "<pre>";var_dump($dataval_explode);
					$dataval_arr[] = $dataval_explode;
				}
				//echo "<pre>";var_dump($dataval_arr);exit;
				$pagination_criteriaval = count($dataval_arr); //var_dump($pagination_criteriaval);exit;
				
				
				for($i=0; $i<$pagination_criteriaval; $i++){//echo "<pre>";var_dump($dataval_arr[$i]);
						$this->db->select('b.business_email_id ');
						$this->db->from('users_email_offers a');
						$this->db->join('business_email_to_users b', 'a.users_email_offers_id=b.users_email_offers_id');
						$this->db->where_in('a.email_offers_criteria_id',$dataval_arr[$i]); // $businessid
						$this->db->where('b.businessid', $businessid);
						$this->db->group_by('b.business_email_id');
						$pagination_query = $this->db->get(); //echo "<pre>"; echo $this->db->last_query();
				        $pagination_result=$pagination_query->result_array();
						$pagination_arr[$i] = $pagination_result;
					}
					$total_paginationcount = count($pagination_arr);
					if($total_paginationcount!=1){
						 $pagination_val = call_user_func_array('array_intersect',$pagination_arr);
					 }else{
						 $pagination_val = $pagination_arr;
					 }
					  
					foreach($pagination_val as $pagination_sepcific_val){
						$display_criteria_arr[] = $pagination_sepcific_val['business_email_id'];
					}
			}
			
			//echo "<pre>";var_dump($display_criteria_arr);exit; 
			
			/*$display_criteria_arr = array();
			if($criteriaid!=''){
				$display_criteria_explode = explode(',',$criteriaid);
					foreach($display_criteria_explode as $criteria_val){
					$display_criteria_arr[] = $criteria_val;
				}
			}*/
			
			
		$intersect = !empty($intersect) ? $intersect : '';	
		$this->db->select('a.business_email_to_users_timestamp,a.business_email_to_users_id, a.business_email_id, GROUP_CONCAT(a.usersid) as useridval, b.business_email_subject, b.business_email_offer, d.email_offers_criteria_value');
		$this->db->from('business_email_to_users a');
		$this->db->join('business_email b', 'b.business_email_id=a.business_email_id AND business_email_status=1');
		$this->db->join('users_email_offers c', 'c.users_email_offers_id=a.users_email_offers_id');
		$this->db->join('email_offers_criteria d', 'd.email_offers_criteria_id=c.email_offers_criteria_id');
		$this->db->join('users e', 'e.id=a.usersid');
		$this->db->where('a.businessid', $businessid);
		$this->db->where('c.zoneid', $zoneid);
		
		if(($age_residentuser == 1) && ($resident_gender == 5) && ($resident_info == 8)){//var_dump( $all_criteria_id);exit;
		   $this->db->where_in('d.email_offers_criteria_id', $all_criteria_id);
		}else if($criteriaid!=''){	//var_dump(22);exit;
		   $display_criteria_arr = !empty($display_criteria_arr) ? $display_criteria_arr : '';	
		   $this->db->where_in('b.business_email_id', $display_criteria_arr);
		}else if(($age_residentuser != '') || ($resident_gender != '') || ($resident_info != '')){
			$this->db->where_in('b.business_email_id', $intersect);
		}else if(($age_residentuser == '') && ($resident_gender == '') && ($resident_info == '') && ($all == '')){//var_dump(11);exit;
			$this->db->where_in('b.business_email_id', $intersect);
		}
		$this->db->group_by('a.business_email_id'); 
		$this->db->order_by('a.business_email_to_users_timestamp','desc');
		$this->db->limit($upperlimit,$lowerlimit);
		$query = $this->db->get();//echo $this->db->last_query();exit;
		$result = $query->result_array(); 
		return $result;	
	}
	
	
	function all_email_criteria_id($age_residentuser,$resident_gender,$resident_info){
		if($age_residentuser == 1){
					$this->db->select('email_offers_criteria_id');
					$this->db->from('email_offers_criteria');
					$this->db->where('parent_id',$age_residentuser);
					$query1 = $this->db->get();
					$result1 = $query1->result_array();
					foreach($result1 as $val){
						$age_criteria .= $val['email_offers_criteria_id'].',';
					}
					$age_criteria_val = substr($age_criteria,0,-1);
					$age_criteria_id = $age_residentuser.','.$age_criteria_val;
				}else{
					$age_criteria_id = $age_residentuser;
				}
			if($resident_gender == 5){
					$this->db->select('email_offers_criteria_id');
					$this->db->from('email_offers_criteria');
					$this->db->where('parent_id',$resident_gender);
					$query2 = $this->db->get();
					$result2 = $query2->result_array();
					
					foreach($result2 as $val2){
						$gender_criteria .= $val2['email_offers_criteria_id'].',';
					}
					$gender_criteria_val = substr($gender_criteria,0,-1);
					$gender_criteria_id = $resident_gender.','.$gender_criteria_val;
				}else{
					$gender_criteria_id = $resident_gender;
				}
				
			if($resident_info == 8){
					$this->db->select('email_offers_criteria_id');
					$this->db->from('email_offers_criteria');
					$this->db->where('parent_id',$resident_info);
					$query3 = $this->db->get();
					$result3 = $query3->result_array();
					
					foreach($result3 as $val3){
						$rental_criteria .= $val3['email_offers_criteria_id'].',';
					}
					$rental_criteria_val = substr($rental_criteria,0,-1);
					$rental_criteria_id = $resident_info.','.$rental_criteria_val;
					
				}else{
					$rental_criteria_id = $resident_info;
				}
				
			$all_criteria = addslashes($age_criteria_id.'##'.$gender_criteria_id.'##'.$rental_criteria_id);  
		    return $all_criteria;
	}
	
	function view_email_specificinfo($business_email_to_users_id, $businessid, $business_email_id){
		$business_email_to_users = array();
		$userid = explode(',', $business_email_to_users_id);
		 foreach($userid as $val){
			 $business_email_to_users[] = $val;
		 }
		$this->db->select('b.business_email_subject, b.business_email_offer,  GROUP_CONCAT(d.email_offers_criteria_value) as criteria_value,  GROUP_CONCAT(e.email) as emailval,e.email, e.first_name, e.last_name');
		$this->db->from('business_email_to_users a');
		$this->db->join('business_email b', 'b.business_email_id=a.business_email_id AND b.business_email_status=1');
		$this->db->join('users_email_offers c', 'c.users_email_offers_id=a.users_email_offers_id');
		$this->db->join('email_offers_criteria d', 'd.email_offers_criteria_id=c.email_offers_criteria_id');
		$this->db->join('users e', 'e.id=a.usersid');
		$this->db->where_in('a.usersid',$business_email_to_users);
		$this->db->where('a.businessid',$businessid);
		$this->db->where('b.business_email_id',$business_email_id);
		$query = $this->db->get();//echo $this->db->last_query();exit;
		$result = $query->result_array();
		return $result;
	}
	
	function usercontactname($residentuserid){
		$userid_arr = array();
		$userid_explode = explode(',',$residentuserid);
		foreach($userid_explode as $val){
			$userid_arr[] = $val;
		}
		$this->db->select('first_name, last_name');
		$this->db->from('users');
		$this->db->where_in('id',$userid_arr);
		$query = $this->db->get();//echo $this->db->last_query();exit;
		$result = $query->result_array(); //echo "<pre>"; var_dump($result);exit;
		$noofrows = $query->num_rows();//var_dump($noofrows);
		$count = 1;
		  foreach($result as $user_name){
			  if($noofrows!=$count){
				  $contactname .= $user_name['first_name'].' '.$user_name['last_name'].', ';
			  }else if($noofrows==$count){
				  $contactname .= $user_name['first_name'].' '.$user_name['last_name'];
			  }
			  $count++;
		  }
		return $contactname;
	}
	
	function email_credit_package($businessid){
		$this->db->select('*');
		$this->db->from('email_credit_package');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	function get_userid($businessid){
		$this->db->select('business_owner_id');
		$this->db->from('business');
		$this->db->where('id',$businessid);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result[0]['business_owner_id'];
	}
	
	
	/*function get_userid($zoneid,$businessid,$email_credit_package_id,$userid){
		
	}
	*/
	
	function email_credit_purchase($zoneid,$businessid,$email_credit_package_id,$userid,$packageval){//var_dump(11);exit;
		               $timestamp = time();
		               $email_credit_balance=array(
											 'usersid'=> '-99',
											 'businessid'=> $businessid,
											 'email_credit_package_id'=> $email_credit_package_id,
											 'email_credit_balance_type' => 'C',
											 'email_credit_balance_value'=> $packageval,
											 'email_credit_balance_timestamp'=>$timestamp,
											 'email_credit_balance_status'=> '1',
						
						);
						
						$email_credit_balance= array_filter($email_credit_balance);//echo "<pre>"; var_dump($business_email_insert);		
						$this->db->insert('email_credit_balance', $email_credit_balance);
						$email_credit_balance_id = $this->db->insert_id();
		                $afftectedRows=$this->db->affected_rows();//var_dump($afftectedRows);exit;
						return $afftectedRows;
		
	}
	
}