<?php

class Snap_model extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

        $this->load->database();

    }

	function register_snap_user($userid,$zoneid){

		$data = array(

            'userid' => $userid,

			'zoneid' => $zoneid,

			'status' => 1

        	);

		$this->db->insert('snap_user_in_zone', $data);

	}

	function get_org_in_zone($zoneid=false,$userid=false){

		$sql="select a.id,a.name,b.approval from zone_organization a 

		LEFT JOIN snap_organization b ON a.id=b.orgid and b.userid=".$userid." 

		where a.approval=1 and a.zoneid=".$zoneid;

		$query = $this->db->query($sql);

    	$result_outer=$query->result_array();

		$result_inner=array();

		foreach($result_outer as $r){

			$r['approval']!='' ? ($r['approval']=1) : ($r['approval']=0);

			$result_inner[]=array(

				'id'=>$r['id'],

				'name'=>$r['name'],

				'approval'=>$r['approval']

			);

		}

		return $result_inner;

	}

	

	function update_status_email_from_org($orgid,$userid,$status){				

		if($status==1){

			$data = array();

    		$data['orgid'] = $orgid;

    		$data['userid'] = $userid;						

    		$this->db->delete('snap_organization', $data);

		}else if($status==0){

			$newdata = array(

            'userid' => $userid,

			'orgid' => $orgid,

			'approval' => 1

        	);

			$this->db->insert('snap_organization', $newdata);

		}

	}

	

	function get_all_businesses_approved_in_snap($zone,$user){		

		$sql="SELECT a.user_id as user,a.email_status as approved,b.id,b.name,c.id as zoneid,c.name as zone_name from business_approved a,business b,sales_zone c where a.business_id=b.id and a.zoneid=c.id and a.user_id=".$user." order by a.id desc";    	

    	$query = $this->db->query($sql);

    	return $query->result_array();		

    }

	

	function update_snap_user_business_status($businessid,$zoneid,$userid,$status){				

		$data = array('email_status' => $status);

        $this->db->where('business_id', $businessid);

		$this->db->where('zoneid', $zoneid);

		$this->db->where('user_id', $userid);

        $this->db->update('business_approved', $data);

	}

	

	function get_all_businesses_approved_in_newsletter($zone,$user){		

		$sql="SELECT a.user_id as user,a.status as approved,b.id,b.name,c.id as zoneid,c.name as zone_name from newsletter_approved a,business b,sales_zone c where a.business_id=b.id and a.zoneid=c.id and a.user_id=".$user." order by a.id desc";    	

    	$query = $this->db->query($sql);

    	return $query->result_array();		

    }

	function update_newsletter_business_status($businessid,$zoneid,$userid,$status){				

		$data = array('status' => $status);

        $this->db->where('business_id', $businessid);

		$this->db->where('zoneid', $zoneid);

		$this->db->where('user_id', $userid);

        $this->db->update('newsletter_approved', $data);

	}
	
	function view_information(){
		
		$sql="select * from zzclick";
		
		$query = $this->db->query($sql);

    	return $query->result_array();	
	}
	function personal_information($clickid){
		
		$sql="select * from zzclick where clickid=".$clickid;
		
		$query = $this->db->query($sql);

    	return $query->result_array();	
	}
	function del_info($clickid){
		
		$sql="delete from zzclick where clickid=".$clickid;
		
		$query = $this->db->query($sql);

    	//return $query->result_array();	
	}
	function update_profile_info($userid,$data){
		$sql="update zzclick set firstname='".$data["firstname"]."',lastname='".$data["lastname"]."',address='".$data["address"]."',city='".$data["city"]."' where clickid=".$userid;
		
		$query = $this->db->query($sql);

    	//return $query->result_array();	
		
	/*	$this->db->where('clickid', $userid);
        $this->db->update('zzclick', $userData);*/
	}
	function del_user_data($all_user_id){
		$sql="delete from zzclick where clickid in ($all_user_id)";
		
		$query = $this->db->query($sql);

    	//return $query->result_array();	
	}
	function users_row($name){ 
		$sql="SELECT a.id, a.username, b.group_id FROM users a INNER JOIN users_groups b ON a.id = b.user_id WHERE a.username='".$name."'";
		//$sql="select * from users where username=".$name;
		$query = $this->db->query($sql);

    	return $query->result_array();	
	}
	/*function users_group_row($user_row_id){
		$sql="select * from users_groups where user_id=".$user_row_id;
		
		$query = $this->db->query($sql);

    	return $query->result_array();	
	}*/

}