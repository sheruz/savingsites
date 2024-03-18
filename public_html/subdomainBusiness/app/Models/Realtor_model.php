<?php
class Organization_model extends CI_Model
{    
    public function __construct(){    
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->database();
    }

# + get_all_organizations -> To get all the Organizations in a zone for Bulk Email //Added on 6/8/14
	public function get_all_organizations($zoneid){ 
		$sql= "SELECT a.*, b.username FROM organization a, users b WHERE zoneid=".$zoneid." AND a.userid=b.id";
		$result = $this->db->query($sql)->result_array();
		$result = (!empty($result)) ? $result : '';
		return $result;
	}
# - get_all_organizations -> To get all the Organizations in a zone for Bulk Email
	
	function get_org_details($zone_id=0){ 
		$sql="select id,name from organization where zoneid='".$zone_id."' and type!=4 and approval=1 order by id asc"; // added on 5-11-14 type!=4 to eliminate High School Sports
		$query=$this->db->query($sql);
		$result=$query->result_array();
		$result=(!empty($result)) ? $result : '';
		return $result;
	}
	function get_org_details_user($zone_id=0,$user_id=0){
		$sql = "select id,name from organization where zoneid='".$zone_id."' AND id NOT IN(SELECT `orgid` FROM `user_zone_organization` WHERE `zoneid`='".$zone_id."' AND `userid`='".$user_id."') and type!=4 and approval=1 order by id asc"; // // added on 5-11-14 type!=4 to eliminate High School Sports
		$query=$this->db->query($sql);
		$result=$query->result_array();
		$result=(!empty($result)) ? $result : '';
		return $result;
	}
	
# + get_highschool_org_details added on 5-11-14 for High School Org Details
	function get_highschool_org_details($zone_id=0){ 
		$sql="select id,name from organization where zoneid='".$zone_id."' and approval=1 and type = 4 order by id asc";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		$result=(!empty($result)) ? $result : '';
		return $result;
	}
# - get_highschool_org_details

# + get_highschool_org_details_user added on 5-11-14 for High School Org User Details
	function get_highschool_org_details_user($zone_id=0,$user_id=0){
		$sql = "select id,name from organization where zoneid='".$zone_id."' AND id NOT IN(SELECT `orgid` FROM `user_zone_organization` WHERE `zoneid`='".$zone_id."' AND `userid`='".$user_id."') and type = 4 and approval=1 order by id asc";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		$result=(!empty($result)) ? $result : '';
		return $result;
	}

# - get_highschool_org_details_user added on 5-11-14 for High School Org User Details

	// viewing organizations for resident user
	public function get_all_deleted_organization($zoneid=0,$userid=0){
		$sql = "select id,name from organization where zoneid='".$zoneid."' AND id IN(SELECT `orgid` FROM `user_zone_organization` WHERE `zoneid`='".$zoneid."' AND `userid`='".$userid."') order by name asc";
		$query=$this->db->query($sql);
		$result=$query->result_array(); //var_dump($result); exit;
		$result=(!empty($result)) ? $result : '';
		return $result;
	}
	// Adding organizations for resident user
	public function adduserorganization($userid=0,$zoneid=0,$orgid=0){
		$sql = 'DELETE FROM `user_zone_organization` WHERE `userid`='.$userid.' AND `zoneid`='.$zoneid.' AND `orgid`='.$orgid;
		//mysql_query($sql);
		$query = $this->db->query($sql);
		
	}
	function detail_org($org_id=0,$id=0,$level=0){ 
		$this->db->select('id,name');
		$this->db->where('orgid',$org_id);
		//$this->db->where('type!=' , 4);		// added on 5-11-14 type!=4 to eliminate High School Sports
		if($id=='0'){			 
			$this->db->where('parent_id',0);
		}else if($id!='0'){
			$this->db->where('parent_id',$id);
		}
		$sql=$this->db->get('organization_category');
		$result=$sql->result_array();
		$arr='';
		if(!empty($result)){		
			foreach($result as $_x){
				if($id=='0' && $level=='0'){
					$arr[$_x['id']]=$_x['name'];
				}else{
					$a=$this->fn_checking_subcat($_x['id'],$org_id);
					if($a==0){			
						$arr[$_x['id']]=$_x['name'].'###orgpopupbtn';
						
					}else{
						$arr[$_x['id']]=$_x['name'].'###arrow sc';
					}
				}
			}
			
		}
		return $arr;
	}
	/* Delete Category in Directory page */
	
	
	
	
	#### for Zone Dashboard part start 
	function get_realtor_for_zone($zone_id = false,$charval=false,$type=false,$lowerlimit=false,$upperlimit=false){ 
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
		if($type==""){
			$type='';
		}else{
			$type = ' AND approval="'.$type.'"';
		}
		$where_orderby=" ORDER BY name ASC";
		
		$query = $this->db->query("SELECT * FROM realtor WHERE zoneid=".$zone_id." ".$where." ".$where_orderby."".$limit_where." ");		
		$result = $query->result_array();
		
		$i=0;
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
		}
		return $result;
    }
	
	
	function get_organization_by_id($id){
		$query = $this->db->query("SELECT a.id,a.name,a.type,a.announcement_display,b.username,b.password,b.email FROM organization a,users b WHERE a.userid=b.id and a.id=".$id);
        return $query->row();
    }	
	function delete_organization_by_id($id=0,$zone_id=0){
		
		$query = $this->db->query("SELECT userid FROM organization WHERE id=".$id." and zoneid=".$zone_id);
		$result=$query->result_array();
		if(!empty($result)){
			$_uid=$result[0]['userid'];
		}else
			$_uid=0;
		if($_uid!=0){ 
			$this->db->where('id', $_uid);
        	$this->db->delete('users');		
			$this->db->where_in('user_id', $_uid);
        	$this->db->delete('users_groups');
		}
		$this->db->where('orgid', $id);
		$this->db->where('zoneid', $zone_id);
        $this->db->delete('organization_announcement');
		
		$this->db->where('orgid', $id);
        $this->db->delete('organization_category');
		
		$this->db->where('id', $id);
		$this->db->where('zoneid', $zone_id);
        $this->db->delete('organization');
    }
	function announcement_organization_status_change($orgid=0,$option=0){	//var_dump($orgid , $option); exit;	
		$data = array('approval' => $option);
        $this->db->where('id', $orgid);	
        $this->db->update('organization', $data);
		$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;
		$sql="SELECT group_concat(id) as id from organization_announcement where orgid=".$orgid;
		$query=$this->db->query($sql);
		$result=$query->result_array(); 
		if(!empty($result)){
			$ann_ids= $result[0]['id']; 
		}
		if($ann_ids!=''){									
			$ups="UPDATE organization_announcement SET approval=".$option." WHERE id IN (".$ann_ids.")"; 
			$this->db->query($ups) ;			
		}		 
	}
	 public function get_announcements_for_zone($zone_id = false,$announcements_category=false,$announcements_type=false,$charval=false,$lowerlimit=false,$upperlimit=false){
		if($announcements_category==0){
			$where=" and orgid=0";
		}else if($announcements_category==1){
			$where=" and orgid!=0";
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
		
		$sql="select * from organization_announcement where zoneid=".$zone_id." ".$where."".$wherecharval." and approval=".$announcements_type." ".$limit_where."";		
		$query=$this->db->query($sql);
		$result=$query->result_array();
		if($announcements_category!=0){
			for($i = 0 ; $i < count($result) ; $i++) {
				$sql_inner="select name,approval from organization where id=".$result[$i]['orgid'];
				$query_inner=$this->db->query($sql_inner);
				$result_inner=$query_inner->result_array();
				$result[$i]['organization_name'] = $result_inner[0]['name'] ;
				$result[$i]['approval_1'] = $result_inner[0]['approval'] ;
			}
		}
		return $result;
    }
	function announcement_status_change($anid=false,$option=false){
		$data = array('approval' => $option);
        $this->db->where('id', $anid);	
        $this->db->update('organization_announcement', $data);
	}
	function delete_announcement($id){
        
        $this->db->where('id', $id);        
        $this->db->delete('organization_announcement');    
    }
	#### for zone dashboard part ends
	#### For Organization Dashboard Part Start
	// Showing all subcategories
	function show_subcategory($data){
		$sql = 'SELECT * FROM organization_category WHERE orgid='.$data['org_id'].' AND parent_id='.$data['parentid'].' ORDER BY name ASC';
		$query = $this->db->query($sql);	
		return $query->result_array();	
	}
	function delete_category($id=0){		
		$sql = "SELECT id FROM organization_category WHERE parent_id=".$id; 
		$query = $this->db->query($sql);
		$result=$query->result_array();
		if(!empty($result)){
			foreach($result as $arr){				
				$this->delete_category($arr['id']);
			}
		}
		$sql = "DELETE FROM organization_category WHERE id=".$id;
		$this->db->query($sql);
	}
	
	#### For Organization Dashboard Part Ends
	
# + get_organization_by_announcement_type
	public function get_organization_by_announcement_type($zoneid,$userid,$orgvalue='',$char='',$announcement_type='') 
    {	//var_dump( $zoneId,$user,$orgvalue,$char,$announcement_type); exit;
		$by_char = '';	
		$approval = '';							
		if($orgvalue!='' && $orgvalue == 1){
			$approval = '1';
		}
		else if($orgvalue!='' && $orgvalue == 0){
			$approval = '0';
		}else if($orgvalue!='' && $orgvalue == -1){
			$approval = '-1';
		}
		if($char != ''){
			$by_char = ' AND a.name LIKE "'.$char.'%"';
		}
		else{
			$by_char = '';
		}
		
		$query = $this->db->query("SELECT a.id,a.name FROM organization a, organization_announcement b WHERE a.id = b.orgid AND b.approval = $announcement_type AND a.type != 4 AND b.zoneid = $zoneid $by_char GROUP BY a.id order by a.name asc");
		$result[0] = $query->result_array() ;
		$allorganizationids = '' ;
		foreach($result[0] as $arr)
			$allorganizationids.= $arr['id']."," ;
		if($allorganizationids != '') $allorganizationids = substr($allorganizationids,0,-1);
		$result[1] = $allorganizationids ;
    	return $result;
    } 
# - get_organization_by_announcement_type

# + get_highschool_organization_by_announcement_type added on 05-11-14 to get the announcement for type 4(HS) orgs 
	public function get_highschool_organization_by_announcement_type($zoneid,$userid,$orgvalue='',$char='',$announcement_type='') 
    {	//var_dump( $zoneid,$userid,$orgvalue,$char,$announcement_type); 
		$by_char = '';	
		$approval = '';							
		if($orgvalue!='' && $orgvalue == 1){
			$approval = '1';
		}
		else if($orgvalue!='' && $orgvalue == 0){
			$approval = '0';
		}else if($orgvalue!='' && $orgvalue == -1){
			$approval = '-1';
		}
		if($char != ''){
			$by_char = ' AND a.name LIKE "'.$char.'%"';
		}
		else{
			$by_char = '';
		}
		
		$query = $this->db->query("SELECT a.id,a.name FROM organization a, organization_announcement b WHERE a.id = b.orgid AND b.approval = $announcement_type AND a.type = 4 AND b.zoneid = $zoneid $by_char GROUP BY a.id order by a.name asc");
		$result[0] = $query->result_array() ;
		$allorganizationids = '' ;
		foreach($result[0] as $arr)
			$allorganizationids.= $arr['id']."," ;
		if($allorganizationids != '') $allorganizationids = substr($allorganizationids,0,-1);
		$result[1] = $allorganizationids ;
    	return $result;
    } 
# - get_highschool_organization_by_announcement_type

# + get_organization_name_against_id
	function get_organization_name_against_id($org_id=false){
		if($org_id!='all'){
		$sql = "SELECT name FROM organization WHERE id=".$org_id;
       	$result = $this->db->query($sql)->result_array();
		}else{
			$result='';
		}
		return $result;
	}
# - get_organization_name_against_id

# + get_announcements_in_zone_for_approve
	public function get_announcements_in_zone_for_approve($selectid='',$zoneId='',$org_id='',$charval='',$lowerlimit='',$upperlimit='')
	{ 	//var_dump($selectid); exit;
		$limit_where="";	
		$org_where = "" ;
		$selected_where = "" ;
		if($lowerlimit!='' && $upperlimit!=''){
			$limit_where=" limit ".$lowerlimit.",".$upperlimit;
		}else{
			$limit_where="";
		}
		if(trim($org_id) != "all"){
			$org_where = " AND b.id IN (".str_replace('-',',',$org_id).")";	// This portion must appear for particular org announcements
			//!empty($business_where) ? " AND c.id IN (".str_replace('-',',',$businessId).")" : '';  // Added !empty() on 21/6/14 for database error on 649 line.
			$selected_where = " AND a.approval IN (".$selectid.",2)";		// 2 == ??????????
			
			$sql = "SELECT a.approval, a.id, a.orgid, a.title, a.announcement, b.name, c.first_name, c.last_name, c.username FROM organization_announcement a, organization b , users c WHERE a.orgid=b.id AND b.userid=c.id AND a.zoneid=".$zoneId.$selected_where.$org_where.$limit_where;
			$query= $this->db->query($sql);	
			$result=$query->result_array();
		}else{
			$result='';
		}
		return $result;
    }
# - get_announcements_in_zone_for_approve

# + edit_announcement_in_zone_for_approve
	public function edit_announcement_in_zone_for_approve($id,$zoneid,$selectid,$orgid){ //var_dump($id, $zoneid ,$selectid,$orgid); exit;
		if($id!=NULL){
			$sql = "UPDATE organization_announcement SET approval=".$selectid." WHERE id=".$id." AND zoneid=".$zoneid." AND orgid=".$orgid;
			$query = $this->db->query($sql);
		}
	} 
# - edit_announcement_in_zone_for_approve

# +
	public function delete_announcements_in_zone_for_approve($id,$zoneId){
		$sql="select id from organization_announcement where id=".$id;
		$query_sel=$this->db->query($sql);
		$result_sel = $query_sel->num_rows();
		if($result_sel==1){
			$data1 = array();
    		$data1['id'] = $id;					
    		$this->db->delete('organization_category', $data1);
		}
		$data = array();
    	$data['adid'] = $adid;
    	$data['zoneid'] = $zoneId;						
    	$this->db->delete('ad_to_zone', $data);
		$this->db->delete('ad_category_subcategory',$data);
	}
# -


# + Change Organization Status
	public function fn_organization_status_change($orgid, $zoneid, $action_performed, $change_business_status, $allorspecific, $organization_type){
		//var_dump($orgid);
		if($action_performed == 1 && $allorspecific == 1){ // For specific organizations
			$explode_value=explode(',',$orgid);
			foreach($explode_value as $organization){	
				$data = array('approval' => $change_business_status);
				$this->db->where('id', $organization);
				$this->db->where('zoneid', $zoneid);
				$this->db->update('organization', $data);				
			}
			$this->fn_announcement_update($orgid, $zoneid, $change_business_status);
			
		return $orgid;	
			
		}else if($action_performed == 1 && $allorspecific == 2){ // For all organizations
				$data = array('approval' => $change_business_status);
				$this->db->where('approval', $organization_type);
				$this->db->where('zoneid', $zoneid);
				$this->db->update('organization', $data);
				
				$orgid=$this->fn_get_all_org($zoneid,$organization_type); 
				$this->fn_announcement_update($orgid, $zoneid, $change_business_status);
		return 'all';
					
		}
	}
# - Change Organization Status

# + announcement update by zone

public function fn_announcement_update($orgid = '', $zoneid = '', $change_business_status = ''){ //var_dump($orgid,$change_business_status); exit;
	$data = array('approval' => $change_business_status);
	$this->db->where('zoneid', $zoneid);
	$this->db->where_in('orgid', $orgid);
	$this->db->update('organization_announcement',$data);
}

# - announcement update by zone

# + Delete Organization Start
function fn_organization_delete($orgid_arr, $zoneid, $action_performed, $change_business_status, $allorspecific, $organization_type){ 
	if($allorspecific == 2){ // Delete All Organization
		$orgid_arr='';
		$orgid=$this->fn_get_all_org($zoneid,$organization_type);
		$all_users_ids=$this->fn_get_org_owners($orgid);		
	}else if($allorspecific == 1){ // Delete Specific Organization
		$orgid=$orgid_arr;
		$all_users_ids=$this->fn_get_org_owners($orgid_arr);
	}	
	if($all_users_ids!=''){
		$_delete_users = "delete from users WHERE id IN (".$all_users_ids.")";
		$this->db->query($_delete_users) ;
		$_delete_users_groups = "delete from users_groups WHERE user_id IN (".$all_users_ids.")";
		$this->db->query($_delete_users_groups) ;
	}
	if($orgid!=''){
		$_delete_organization_announcement = "delete from organization_announcement WHERE orgid IN (".$orgid.")";
		$this->db->query($_delete_organization_announcement) ;
		$_delete_organization_category = "delete from organization_category WHERE orgid IN (".$orgid.")";
		$this->db->query($_delete_organization_category) ;
		$_delete_organization = "delete from organization WHERE id IN (".$orgid.")";
		$this->db->query($_delete_organization) ;
	}
	if($allorspecific == 2){
		return 'all';		
	}else if($allorspecific == 1){
		return $orgid_arr;
	}
}
# - Delete Organization Start
function fn_get_all_org($zoneid,$organization_type){
	$allorgids=array();
	$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;	
	$sql="SELECT group_concat(id) as id FROM organization WHERE zoneid=".$zoneid." and approval=".$organization_type;
	$query = $this->db->query($sql);
	$result= $query->result_array() ; 
	if(!empty($result)){
		$allorgids= $result[0]['id']; 
	}
	return $allorgids;
}
function fn_get_org_owners($orgid){
	$alluserids=array();
	$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;	
	$sql="SELECT group_concat(userid) as userid FROM organization WHERE id IN(".$orgid.")";
	$query = $this->db->query($sql);
	$result= $query->result_array() ; 
	if(!empty($result)){
		$alluserids= $result[0]['userid']; 
	}
	return $alluserids;
}
# + all_announcements_status_change
function all_announcements_status_change($orgid='',$status=''){
		if($status==1)
			$ups_status=-1;
		else if($status==-1)
			$ups_status=1;
		$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;
		$sql_ad = "SELECT group_concat(a.id) as id FROM organization_announcement a, organization b WHERE a.orgid=".$orgid." AND a.orgid=b.id AND a. 	approval=".$status;
		$query_ad=$this->db->query($sql_ad);
		$result_ad=$query_ad->result_array(); 
		if(!empty($result_ad)){
			$all_announcement_ids= $result_ad[0]['id']; 
		}
		if($all_announcement_ids!=''){						
			$ups="UPDATE organization_announcement SET approval=".$ups_status." WHERE id IN (".$all_announcement_ids.")"; 
			$this->db->query($ups) ;			
		}
	}
# - all_announcements_status_change

}