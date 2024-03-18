<?php
### This page is created by Athena eSolutions
error_reporting(0);
class Directory_model extends CI_Model{
  	 public function __construct(){
        parent::__construct();
        $this->load->database();
    }
	
	 public function get_all_state(){
		$sql="SELECT a.state as state_id,c.name as state_name FROM(zipcode as a,zip_code_zone as b,states as c) WHERE a.zip= b.zip_code AND a.state=c.code GROUP BY a.state";	
		$query=$this->db->query($sql);
		$result = $query->result_array();
		return $result;    
	}
	
	function get_zone($state=''){
		$sql="SELECT c.id,c.name FROM zipcode a,zip_code_zone b,sales_zone c WHERE a.zip=b.zip_code and b.zone_id=c.id and a.state='".$state."' group by c.id order by c.name ASC";
		$query = $this->db->query($sql);
    	$result = $query->result_array();
		return $result;
	}
	function show_favorites_directory($userid=0){
		$sql="SELECT a.id as id,b.id as zone_id,b.name as zone_name FROM users_favorites_directory a,sales_zone b WHERE a.zoneid=b.id and a.userid=".$userid." group by b.id order by b.name ASC";
		$query = $this->db->query($sql);
    	$result = $query->result_array();
		return $result;
	}
	function save_favorites_directory($userid=0,$zoneid=0){
		$explode_value_zone=explode(',',$zoneid);
		for($i=0;$i<count($explode_value_zone);$i++){
			$data=array('userid'=>$userid,'zoneid'=>$explode_value_zone[$i],'timestamp'=>time()); 
			$this->db->insert('users_favorites_directory', $data);
		}
	}
	function delete_favorites_directory($id=0){
		$new_id=explode('~!~',$id);
		if($new_id[1]!='' && $new_id[0]!=''){
			$this->db->where('userid',$new_id[1]);
			$this->db->where('zoneid',$new_id[0]);				
			$this->db->delete('users_favorites_directory');
		}
	}
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function view_user_category($userid=0,$zoneid=0){
		$this->db->select('id,name');
		$this->db->where('userid',$userid);
		$this->db->where('zoneid',$zoneid);  
		$query=$this->db->get('user_category');
		return $query->result();
	}
	function view_user_quick_access($userid=0,$zoneid=0){
		$this->db->select('a.*,b.id,b.name');
		$this->db->where('a.userid',$userid);
		$this->db->where('a.zoneid',$zoneid);
		$this->db->from('user_quick_access a');
		$this->db->join('user_category b', 'b.id = a.catid','left');  
		$query=$this->db->get(); //echo $this->db->last_query();
		
		//$sql="";
		
		return $query->result();
	}
	function insert_user_category($userid,$zoneid,$catname,$category_id){//var_dump($userid);exit;
			
		$this->db->select('id');
		$this->db->where('name',$catname); 
		$query=$this->db->get('user_category');
		if($query->num_rows()==0){
			$data_arr=array('userid'=>$userid,'name'=>trim($catname),'zoneid'=>$zoneid,'status'=>1);
			$this->db->insert('user_category',$data_arr);
			$id = $this->db->insert_id();
		}
		
		return $id;
	}

	function insert_user_favourite($userid,$zoneid,$sitename,$cat_id,$sitelink,$sitecomments){//var_dump($userid);exit;
			
		$data_arr_ins=array('userid'=>$userid,'catid'=>trim($cat_id),'zoneid'=>$zoneid,'sitename'=>$sitename,'sitelink'=>$sitelink,'sitecomments'=>$sitecomments,'timestamp'=>time());		
		$this->db->insert('user_quick_access',$data_arr_ins);
		//echo $this->db->last_query();
		return $this->db->insert_id();
	}
	function getFavouritelinks($userid,$zoneid)
	{
		$this->db->select('ua.*,uc.name');
		$this->db->from('user_quick_access ua');
		$this->db->where('ua.userid',$userid);
		$this->db->where('ua.zoneid',$zoneid);

		$this->db->join('user_category uc', 'uc.id = ua.catid','left');
		$query = $this->db->get();
		
		$num_rows = $query->num_rows();
		if($num_rows > 0)
		{
			$result = $query->result_array();

			return $result;
		}
	}
	function user_quick_access($userid,$cat_id_a,$zoneid,$sitename,$sitelink,$sitecomments,$from_where,$quick_access_id,$create){ //var_dump($quick_access_id);exit;
		/*if($quick_access_id=='-1'){
			$data_arr_ins=array('userid'=>$userid,'catid'=>trim($cat_id_a),'zoneid'=>$zoneid,'sitename'=>$sitename,'sitelink'=>$sitelink,'sitecomments'=>$sitecomments,'timestamp'=>time());		
			$this->db->insert('user_quick_access',$data_arr_ins);
			//echo $this->db->last_query();
			return $this->db->insert_id();
		}else{
			$data_arr_up=array('sitename'=>$sitename,'sitelink'=>$sitelink,'sitecomments'=>$sitecomments,'timestamp'=>time());
			$this->db->where('id', $quick_access_id);
			$this->db->update('user_quick_access', $data_arr_up);
			return $quick_access_id;  
		}*/
		//if($from_where=='Save'){
		if($quick_access_id=='-1'){
			$data_arr=array('userid'=>$userid,'catid'=>trim($cat_id_a),'zoneid'=>$zoneid,'sitename'=>$sitename,'sitelink'=>$sitelink,'sitecomments'=>$sitecomments);	
			$sql = "select id from user_quick_access where userid=$userid and zoneid=$zoneid and (sitename='$sitename' OR sitelink='$sitelink')";	
			$sql_query = $this->db->query($sql);
			//$query_result = $sql_query->result_array();
			//$this->db->where($data_arr);  
//			$query=$this->db->get('user_quick_access');
			//var_dump($this->db->last_query());
			//var_dump($sql_query->num_rows());
			if($sql_query->num_rows()==0){ //var_dump(999);
				$data_arr_ins=array('userid'=>$userid,'catid'=>trim($cat_id_a),'zoneid'=>$zoneid,'sitename'=>$sitename,'sitelink'=>$sitelink,'sitecomments'=>$sitecomments,'timestamp'=>time());		
				$this->db->insert('user_quick_access',$data_arr_ins);
				//echo $this->db->last_query();
				return $this->db->insert_id();
			}else{  var_dump($create);
			  if($create ==1){
			   $sql_delete = "delete from user_category where id=$cat_id_a";
			   $delete_category = $this->db->query($sql_delete);
			  }
				return 0;
			}
		//}else if($from_where=='Update'){
		}else {
			//return $quick_access_id;
			/*$this->db->select(' * ');
			$this->db->where('id',$quick_access_id); 
			$query=$this->db->get('user_quick_access');
			$result=$query->result(); //var_dump($result); exit;
			echo $this->db->last_query();*/
			$sql="select * from user_quick_access where id=".$quick_access_id;
			$query=$this->db->query($sql);
			$result = $query->result_array();
			//var_dump($result);
			if(!empty($result)){
				if($result[0]['catid']==$cat_id_a){
					$data_arr_up=array('sitename'=>$sitename,'sitelink'=>$sitelink,'sitecomments'=>$sitecomments,'timestamp'=>time());
					$this->db->where('id',$quick_access_id); 
					$this->db->update('user_quick_access', $data_arr_up);
					//echo $this->db->last_query();
					return $quick_access_id;
				}else{
					if($quick_access_id != -1){
					$this->db->where('id',$quick_access_id);
					$this->db->delete('user_quick_access');
				}
					$data_arr_ins=array('userid'=>$userid,'catid'=>trim($cat_id_a),'zoneid'=>$zoneid,'sitename'=>$sitename,'sitelink'=>$sitelink,'sitecomments'=>$sitecomments,'timestamp'=>time());		
					$this->db->insert('user_quick_access',$data_arr_ins);
					//echo $this->db->last_query();
					return $this->db->insert_id();
				}
			}
			/*$data_arr=array('userid'=>$userid,'catid'=>trim($cat_id_a),'zoneid'=>$zoneid);		
			$this->db->where($data_arr);  
			$query=$this->db->get('user_quick_access');
			if($query->num_rows()==0){
			}
			$data_arr_up=array('sitename'=>$sitename,'sitelink'=>$sitelink,'sitecomments'=>$sitecomments,'timestamp'=>time());
			$this->db->where('userid', $userid);
			$this->db->where('catid', trim($cat_id_a));
			$this->db->where('zoneid', $zoneid);
			$this->db->update('user_quick_access', $data_arr_up);
			echo $this->db->last_query(); */
		}
		
		/*$data_arr=array('userid'=>$userid,'catid'=>trim($cat_id_a),'zoneid'=>$zoneid,'sitename'=>$sitename,'sitelink'=>$sitelink,'sitecomments'=>$sitecomments);
		
		$this->db->where($data_arr);  
		$query=$this->db->get('user_quick_access');	
		if($query->num_rows()==0){
			$data_arr_ins=array('userid'=>$userid,'catid'=>trim($cat_id_a),'zoneid'=>$zoneid,'sitename'=>$sitename,'sitelink'=>$sitelink,'sitecomments'=>$sitecomments,'timestamp'=>time());		
			$this->db->insert('user_quick_access',$data_arr_ins);
		}else{
			$data_arr_up=array('sitename'=>$sitename,'sitelink'=>$sitelink,'sitecomments'=>$sitecomments,'timestamp'=>time());
			$this->db->where('userid', $userid);
			$this->db->where('catid', trim($cat_id_a));
			$this->db->where('zoneid', $zoneid);
			$this->db->update('user_quick_access', $data_arr_up); 
		}*/
		//echo $this->db->last_query();
	}
	function user_fav_zone($userid,$zoneid){
		$sql = "SELECT id FROM users_favorites_directory WHERE userid=".$userid." AND zoneid=".$zoneid ;
		$query = $this->db->query($sql) ;
		if($query->num_rows()==0){
			$data_arr_ins=array('userid'=>$userid,'zoneid'=>$zoneid,'timestamp'=>time());		
			$this->db->insert('users_favorites_directory',$data_arr_ins);
			$id=$this->db->insert_id();
			//return $this->fetch_user_fav_zone($userid,$zoneid,0);
			return 'Successfully Inserted...';	
		}else{
			return 'Already exist!!!';
		}
	}

	function update_category($data_arr,$user_category_id){
		
		$this->db->where('id', $user_category_id);
		$this->db->update('user_category', $data_arr); 
	}
	/*function fetch_user_fav_zone($userid=0,$zoneid=0,$catid=0){
		if($catid=='0'){
			$this->db->select('id');
			$this->db->where('name',$catname); 
			$query=$this->db->get('users_favorites_directory');
		}
	}*/
	function get_user_fav_cat($userid=0,$zoneid=0){
		$this->db->select('id,name');
		$this->db->where('userid',$userid);
		$this->db->where('zoneid',$zoneid); 
		$query=$this->db->get('user_category');
		return $query->result_array();
	}
	function fetch_user_fav_zone($userid=0,$zoneid=0,$catid=0,$id=0){
		if($catid!='0' && $zoneid!='0'){
			/*$sql="SELECT a.id as id,b.id as zone_id,b.name as zone_name FROM users_favorites_directory a,sales_zone b WHERE a.zoneid=b.id and a.userid=".$userid." and a.zoneid=".$zoneid." group by b.id order by b.name ASC";*/
			$this->db->select('a.*,b.id as zone_id,b.name as zone_name');
			$this->db->where('a.userid',$userid);
			$this->db->where('a.zoneid',$zoneid);
			$this->db->where('a.catid',$catid);
			$this->db->from('user_quick_access a');
			$this->db->join('user_category b', 'b.id = a.catid','left');  
			$query=$this->db->get();					
		}
		else if($zoneid=='0'){
			$sql="SELECT a.id as id,b.id as zone_id,b.name as zone_name,b.seo_zone_name FROM users_favorites_directory a,sales_zone b WHERE a.zoneid=b.id and a.userid=".$userid." group by b.id order by b.name ASC";
			$query = $this->db->query($sql);
		}
		
		//echo $this->db->last_query();
		return $query->result_array();	
	}
	// Deleting fav. zone by resident user
	function user_delete_zone($id=0){ 
		if($id != '0'){
			$sql = "DELETE FROM `users_favorites_directory` WHERE id=".$id;
			$this->db->query($sql);
			//echo $this->db->last_query();
			return 1;
		}
	}
	function user_delete_sites($id=0){ 
		if($id != '0'){
			$sql = "DELETE FROM `user_quick_access` WHERE id=".$id;
			$this->db->query($sql);
			//echo $this->db->last_query();
			return 1;
		}
	}

	function delete_category($id=0){ 
		if($id != '0'){
			$sql = "DELETE FROM `user_category` WHERE id=".$id;
			$this->db->query($sql);
			//echo $this->db->last_query();
			return 1;
		}
	}

	function view_specific_links($id=0){
		if($id != 0){
			$sql = "SELECT * FROM user_quick_access WHERE id=".$id;
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	}
}
?>



