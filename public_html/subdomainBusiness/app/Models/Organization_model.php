<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\IonAuth;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Organization_model extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->CommonController = new CommonController();
    } 
# + get_all_organizations -> To get all the Organizations in a zone for Bulk Email //Added on 6/8/14
	public function get_all_organizations($zoneid){ 
		$sql= "SELECT a.*, b.username FROM organization a, users b WHERE zoneid=".$zoneid." AND a.userid=b.id";
		$result = $this->db->query($sql)->result_array();
		$result = (!empty($result)) ? $result : '';
		return $result;
	}

     
   	public function getuserdealsbyid($zone_id, $user_id , $dealid, $purchaseID,$via){
   		$result = '';
   		if($via == 'zonedashboard'){
   			$sql="select DISTINCT b.*, users.id as userId,b.deal_id as dealId,b.current_price as amountPurchased,b.created_date as purchasedAt from  tbl_member a, users  users  , tbl_deals b, ads c, tbl_deals_products d where  a.user_name = users.username and  a.user_id=b.user_id    and  b.product_id=d.deal_product_id and b.deal_id =".$dealid."";
   		}else{
			$sql="select DISTINCT tp.id  , tp.*  ,  tp.id as purchaseid , b.* from  tbl_member a, users  users  , tbl_deals b, ads c, tbl_deals_products d , tbl_deals_purchased_meta tp where  a.user_name = users.username and  a.user_id=b.user_id    and  b.product_id=d.deal_product_id and  tp.userId = ".$user_id.' and b.deal_id ='.$dealid.' and tp.id ='.$purchaseID ;
   		}

   		$result = $this->CommonController->SelectRawquery($sql);
   		if($result != ''){
   			foreach ($result as $k => $v) {
        		$userquery="SELECT * FROM users WHERE id=".$v['userId']."";
        		$userArr = $this->CommonController->SelectRawquery($userquery,'row');
        		$result[$k]['username'] = $userArr->username;
        		$result[$k]['first_name'] = $userArr->first_name;
        		$result[$k]['last_name'] = $userArr->last_name;
        		$result[$k]['email'] = $userArr->email;
			}	
   		}
		return $result;
	}


	public function getuserdeals($zone_id, $user_id,$type = ''){
		$finalArr = [];
		if($type == 'claimdealsend'){
			$fetch_id="SELECT * FROM tbl_deals_purchased_meta WHERE userId=".$user_id." AND certificate_verify=1 AND certreciever != ''";
		}else{
			$fetch_id="SELECT * FROM tbl_deals_purchased_meta WHERE userId=".$user_id." AND certreciever=''";
		}
		$purchasequery = $this->CommonController->SelectRawquery($fetch_id);
		if(count($purchasequery) > 0){
			foreach ($purchasequery as $k => $v) {
				$tbl_deal="SELECT `deal_id`,`page_title` FROM tbl_deals WHERE deal_id=".$v['dealId']."";
				$tbl_deal_data = $this->CommonController->SelectRawquery($tbl_deal,'row');
				if($tbl_deal_data != ''){
					$arr['id'] = $v['id'];
					$arr['deal_id'] = $tbl_deal_data->deal_id;
					$arr['page_title'] = $tbl_deal_data->page_title;
					$arr['amount_purchased'] = $v['amountPurchased'];
					$arr['purchasedAt'] = isset($v['purchasedAt'])?date('d-m-Y', strtotime($v['purchasedAt'])):'';
					$arr['purchaseid'] = $v['id'];
					$arr['certificate_verify'] = ($v['certificate_verify'] == 1)?'Verified':'Not Verify';	
					$arr['certreciever'] = $v['certreciever'];	
					$arr['giftsenderemail'] = $v['giftsenderemail'];	
				}else{
					$arr['id'] = '';
					$arr['deal_id'] = '';
					$arr['page_title'] = '';
					$arr['amount_purchased'] = '';
					$arr['purchasedAt'] = '';
					$arr['purchaseid'] = '';
					$arr['certificate_verify'] = '';
					$arr['certreciever'] = '';
					$arr['giftsenderemail'] = '';
				}
				
				$finalArr[] = $arr;
			}
		}
		return $finalArr;














			$fetch_id="SELECT * FROM tbl_deals_purchased WHERE userId=".$user_id."";
			$purchasequery = $this->CommonController->SelectRawquery($fetch_id);
			$finalArr = [];
			
			if(count($purchasequery) > 0){
				foreach ($purArr as $key => $dealid) {
				$tbl_deal="SELECT `deal_id`,`page_title` FROM tbl_deals WHERE deal_id=".$dealid."";
				$tbl_del_query = $this->db->query($tbl_deal);
				$tbl_deal_data = $tbl_del_query->row();

				$tbl_deal_purchased="SELECT `id`,`amountPrchased`,`purchasedAt` FROM tbl_deals_purchased WHERE userId=".$user_id."";
				$tbl_del_purchased_query = $this->db->query($tbl_deal_purchased);
				$tbl_deal_purchased_data = $tbl_del_purchased_query->row();

				$arr['page_title'] = $tbl_deal_data->page_title;
				$arr['amount_purchased'] = $tbl_deal_purchased_data->amountPrchased;
				$arr['purchasedAt'] = 
				isset($tbl_deal_purchased_data->purchasedAt)?date('d-m-Y', strtotime($tbl_deal_purchased_data->purchasedAt)):'';
				$arr['deal_id'] = $tbl_deal_data->deal_id;
				$arr['purchaseid'] = $tbl_deal_purchased_data->id;
				$finalArr[] = $arr;
				}
			}
			

       //  echo $sql="select DISTINCT tp.id , tp.id as purchaseid , tp.*  , b.* ,  users.* from  tbl_member a, users  users  , tbl_deals b, ads c, tbl_deals_products d , tbl_deals_purchased tp where  a.user_name = users.username and tp.dealId = b.product_id and  a.user_id=b.user_id    and  b.product_id=d.deal_product_id and  tp.userId = ".$user_id;

       // echo  $sql="select DISTINCT tp.id , tp.id as purchaseid , tp.*  , b.* ,  users.* from  tbl_member a, users  users  , tbl_deals b, ads c, tbl_deals_products d , tbl_deals_purchased tp where  a.user_name = users.username and  b.product_id=d.deal_product_id and  tp.userId = ".$user_id;
	// 	$query=$this->db->query($sql);
	// 	$result=$query->result_array();
	// 	$result=(!empty($result)) ? $result : '';
		return $finalArr;

	}


# - get_all_organizations -> To get all the Organizations in a zone for Bulk Email
	
	function get_org_details($zone_id=0){ 
	  //  $sql="select id,name from organization where zoneid='".$zone_id."' and type!=4 and approval=1 order by id asc"; // added on 5-11-14 type!=4 to eliminate High School Sports
		$select_value="a.id,a.name,d.auc_id";
		
		$table = "organization a";
		$table.= " INNER JOIN users b ON a.userid=b.id";
		$table.= " LEFT JOIN tbl_member c ON b.username=c.user_name";
		$table.= " LEFT JOIN tbl_auction d ON c.user_id=d.user_id and d.status='Live'";
		
		$where_val="a.zoneid='".$zone_id."' and a.type!=4 and a.approval=1 group by a.id order by a.id asc";
		
		$sql="select $select_value from $table where $where_val"; // added on 5-11-14 type!=4 to eliminate High School Sports
		
		$query=$this->db->query($sql);
		$result=$query->result_array(); //echo "<pre>"; var_dump($result);exit;
		$result=(!empty($result)) ? $result : '';
		return $result;
	}
	public function get_all_active_org_list_except_highschool($zone_id){
		$sql = "SELECT 
					name,id
				FROM 
					organization 
				WHERE 
					zoneid=".$zone_id."
				AND
					approval=1
				AND type IN (0,1,2)";
		$query = $this->db->query($sql);
		return $query->result_array();

	}
	
	
	function get_auction_list($zone_id=0){ 
	//$sql="select id,name from organization where zoneid='".$zone_id."' and type!=4 and approval=1 order by id asc"; // added on 5-11-14 type!=4 to eliminate High School Sports
		
		$select_value="a.id, d.auc_id";
		
		$table = "organization a";
		$table.= " INNER JOIN users b ON a.userid=b.id";
		$table.= " LEFT JOIN tbl_member c ON b.username=c.user_name";
		$table.= " LEFT JOIN tbl_auction d ON c.user_id=d.user_id and d.status='Live'";
		
		$where_val="a.zoneid='".$zone_id."' and a.type!=4 and a.approval=1 order by a.id asc";
		
		$sql="select $select_value from $table where $where_val"; // added on 5-11-14 type!=4 to eliminate High School Sports
		
		$query=$this->db->query($sql);
		$result=$query->result_array(); //echo "<pre>"; var_dump($result);exit;
		$result=(!empty($result)) ? $result : '';
		return $result;
	}
	
	/*function get_auction_list($zone_id,$uid){
		
	}*/
	
	
	
	
	
	
	
	function get_org_details_user($zone_id=0,$user_id=0){
		
		// + Org all details 09-07-2016
			$select_value="a.id,a.name,d.auc_id";
			$table = "organization a";
			$table.= " INNER JOIN users b ON a.userid=b.id";
			$table.= " LEFT JOIN tbl_member c ON b.username=c.user_name";
			$table.= " LEFT JOIN tbl_auction d ON c.user_id=d.user_id and d.status='Live'";
			$where_val="a.zoneid='".$zone_id."' AND a.id NOT IN(SELECT e.orgid FROM user_zone_organization e WHERE e.zoneid='".$zone_id."' AND e.userid='".$user_id."') and type!=4 and approval=1 order by id asc";
			$sql="select $select_value from $table where $where_val"; 
			$query=$this->db->query($sql);
			$result=$query->result_array(); 
			$result=(!empty($result)) ? $result : '';
			return $result;
		// - Org all details 	
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
	/*public function get_jotform_code_model($org_id,$payment_module_id){
		return $org_id;
	}*/
	
	/*function detail_org($org_id=0,$id=0,$level=0){ 
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
		
		// echo "<pre>"; var_dump($result);exit;
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
	}*/
	
		function detail_org($org_id=0,$id=0,$level=0){ 
		/*$this->db->select('id,name');
		$this->db->where('orgid',$org_id);*/
		//$this->db->where('type!=' , 4);		// added on 5-11-14 type!=4 to eliminate High School Sports
		if($id=='0'){			 
			//$this->db->where('parent_id',0);
		}/*else if($id!='0'){
			$this->db->where('parent_id',$id);
		}*/
		/*$sql=$this->db->get('organization_category');
		$result=$sql->result_array();*/
		
			/**
				Modify organization manage banner
			*/
			
			$this->db->select('a.id,a.name,GROUP_CONCAT(b.image_name) as image_name,b.id as orgphotosid,c.status');
			$this->db->from('organization_category a') ;
			$this->db->join('organization_photos b', 'b.cat_id = a.id', 'left');
			$this->db->join('organizationphotos_display c', 'c.orgphotosid = b.id', 'left');
			$this->db->where('a.orgid',$org_id);
			$this->db->group_by('a.id');
			if($id=='0'){			 
				$this->db->where('a.parent_id',0);
			}
			$sql=$this->db->get();//echo $this->db->last_query();
			$result=$sql->result_array();
			//echo "<pre>"; var_dump($result);exit;
			/*****/
		
		$arr_result = '';
		$arr='';
		if(!empty($result)){		
			foreach($result as $key=>$_x){//echo "<pre>"; var_dump($_x);
				
				//$arr[$_x['id']]=$_x['name'];
				if($id=='0' && $level=='0'){
					$arr[$key]['name']=$_x['name'];
					$arr[$key]['id']=$_x['id'];
					if($_x['image_name']!='')
						$arr[$key]['image_name']=$_x['image_name'];
				}else{
					$a=$this->fn_checking_subcat($_x['id'],$org_id);
					if($a==0){			
						$arr[$key][$_x['id']]=$_x['name'].'###orgpopupbtn';
						if($_x['image_name']!='')
							$arr[$key][$_x['id'].'_image_name']=$_x['image_name'].'###orgpopupbtn';
						
					}else{
						$arr[$key][$_x['id']]=$_x['name'].'###arrow sc';
						if($_x['image_name']!='')
							$arr[$key][$_x['id'].'_image_name']=$_x['image_name'].'###arrow sc';
					}
				}
			}
		}//echo "<pre>"; var_dump($arr);exit;
		return $arr;
	}
	
	
	/* Delete Category in Directory page */
	function detail_org_user($org_id=0,$id=0,$level=0,$zoneid=0,$userid=0){ 
		$this->db->select('id,name');
		$this->db->where('orgid',$org_id);
		//$this->db->where('type!=' , 4);		// added on 5-11-14 for other than High School
		if($id=='0'){			 
			$this->db->where('parent_id',0);
		}else if($id!='0'){
			$this->db->where('parent_id',$id);
		}
		$this->db->where('id NOT IN (SELECT catid FROM user_zone_organization_category WHERE zoneid='.$zoneid.' AND userid='.$userid.' AND orgid='.$org_id.')');
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
	
# + detail_highschool_org added on 5-11-14 for High School 
 	function detail_highschool_org($org_id=0,$id=0,$level=0){ 
		$this->db->select('id,name');
		$this->db->where('orgid',$org_id);
		//$this->db->where('type =' , 4);		// added on 5-11-14 for other than High School
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
						$arr[$_x['id']]=$_x['name'].'###orgpopupbtn1';
						
					}else{
						$arr[$_x['id']]=$_x['name'].'###arrow sc1';
					}
				}
			}
			
		}
		return $arr;
	}
# - detail_highschool_org added on 5-11-14 for High School

# + detail_highschool_org_user added on 5-11-14 for High School Org User
	function detail_highschool_org_user($org_id=0,$id=0,$level=0,$zoneid=0,$userid=0){ 
		$this->db->select('id,name');
		$this->db->where('orgid',$org_id);
		//$this->db->where('type =' , 4);		// added on 5-11-14 for other than High School
		if($id=='0'){			 
			$this->db->where('parent_id',0);
		}else if($id!='0'){
			$this->db->where('parent_id',$id);
		}
		$this->db->where('id NOT IN (SELECT catid FROM user_zone_organization_category WHERE zoneid='.$zoneid.' AND userid='.$userid.' AND orgid='.$org_id.')');
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
						$arr[$_x['id']]=$_x['name'].'###orgpopupbtn1';
					}else{
						$arr[$_x['id']]=$_x['name'].'###arrow sc1';
					}
				}
			}
		}
		return $arr;
	}
# - detail_highschool_org_user added on 5-11-14 for High School Org User


	// org photo uploaded or not
	function check_photo_upload($org_id=0,$cat_id=0){
		$sql="SELECT o.image_name, o.description, od.order ,o.org_id FROM (organization_photos AS o, organizationphotos_display AS od) WHERE o.id = od.orgphotosid AND od.org_id =$org_id AND o.cat_id=$cat_id AND od.status=1 ORDER BY od.order ASC ";
		//$sql = "SELECT * FROM organization_photos WHERE org_id=$org_id AND cat_id=$cat_id" ;
		$query = $this->db->query($sql);
		//echo $this->db->last_query(); exit;
		if($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return 0;
		}
	}
	
	function fn_checking_subcat($id=0,$org_id=0){
		$this->db->select('id,name');
		$this->db->where('orgid',$org_id);
		$this->db->where('parent_id',$id);
		$sql=$this->db->get('organization_category');		
		return $sql->num_rows();
	}
	
	function detail_org_announcement($org_id=0,$id=0){
		$this->db->select('id,title,announcement');
		$this->db->where('orgid',$org_id);
		$this->db->where('category',$id);
		$this->db->where('approval','1');
		$this->db->order_by("timestamp", "desc"); 
		$sql=$this->db->get('organization_announcement');
		$result=$sql->result_array();		
		$result=(!empty($result)) ? $result : '';
		return $result; 	
	}
	
	
	#### for Zone Dashboard part start 
	function get_organization_for_zone($zone_id = false,$charval=false,$type=false,$lowerlimit=false,$upperlimit=false){ 
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
		//echo "SELECT * FROM zone_organization WHERE zoneid=".$zone_id." ".$where." ".$limit_where;
		//$query = $this->db->query("SELECT * FROM zone_organization WHERE zoneid=".$zone_id." ".$where." ".$limit_where."");
		$query = $this->db->query("SELECT * FROM organization WHERE zoneid=".$zone_id." and type!=4 ".$type." ".$where." ".$where_orderby."".$limit_where." ");			// added type!=4 on 6-11-14 to eliminate the High School Sports
		$result = $query->result_array();
		$i=0;
		foreach($result as $arr) {
			// New announcement
/*				$sql="select count(b.id) as count_new from organization a, organization_announcement b WHERE a.id=".$arr['id']." AND b.zoneid=".$zone_id." AND a.id=b.orgid AND b.approval=0" ;
				$query_inner=$this->db->query($sql);
				$result_inner=$query_inner->result_array();
				//var_dump($result_inner);
				$result[$i]['new'] = $result_inner[0]['count_new'] ;*/
				
				//Contact Information			-----> Added on 19/8/14 to get the Contact Details for the Contact Details Column.
				$contact_details = "SELECT first_name,last_name,email,phone FROM users WHERE id=".$arr['userid'];
				$query = $this->db->query($contact_details);
				$result_contact_details = $query->result_array(); 
				$result[$i]['first_name'] = $result_contact_details[0]['first_name'];
				$result[$i]['last_name'] =	$result_contact_details[0]['last_name'];	
				$result[$i]['email'] =	$result_contact_details[0]['email'];
				$result[$i]['phone'] =	$result_contact_details[0]['phone'];
				// Approved announcement
				$sql="select count(b.id) as count_approved from organization a, organization_announcement b WHERE a.id=".$arr['id']." AND b.zoneid=".$zone_id." AND a.id=b.orgid AND b.approval=1" ;
				$query_inner=$this->db->query($sql);
				$result_inner=$query_inner->result_array();
				$result[$i]['approved'] = $result_inner[0]['count_approved'] ;
				// Unapproved announcement
				$sql1="select count(b.id) as count_unapproved from organization a, organization_announcement b WHERE a.id=".$arr['id']." AND b.zoneid=".$zone_id." AND a.id=b.orgid AND b.approval=-1" ;
				$query_inner1=$this->db->query($sql1);
				$result_inner1=$query_inner1->result_array();
				$result[$i]['unapproved'] = $result_inner1[0]['count_unapproved'] ;
			$i++;
		}
		return $result;
		
    }
	
	/*// + Get zone name
		function get_zone_name($zone_id){
			$this->db->select('name');
			$this->db->from('sales_zone');
			$this->db->where('id', $zone_id);
			$query = $this->db->get();
			$result =  $query->result_array();
			return $result['0']['name'];			
		}
	// + Get zone name*/
	
	// + High School Sports
	function get_highschoolsports_for_zone($zone_id = false,$charval=false,$type=false,$lowerlimit=false,$upperlimit=false){ 
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
		$query = $this->db->query("SELECT * FROM organization WHERE zoneid=".$zone_id." AND type = 4 ".$type." ".$where." ".$where_orderby."".$limit_where." ");
		$result = $query->result_array();
		$i=0;
		foreach($result as $arr) {
				$contact_details = "SELECT first_name,last_name,email,phone FROM users WHERE id=".$arr['userid'];
				$query = $this->db->query($contact_details);
				$result_contact_details = $query->result_array(); 
				$result[$i]['first_name'] = $result_contact_details[0]['first_name'];
				$result[$i]['last_name'] =	$result_contact_details[0]['last_name'];	
				$result[$i]['email'] =	$result_contact_details[0]['email'];
				$result[$i]['phone'] =	$result_contact_details[0]['phone'];
				// Approved announcement
				$sql="select count(b.id) as count_approved from organization a, organization_announcement b WHERE a.id=".$arr['id']." AND b.zoneid=".$zone_id." AND a.id=b.orgid AND b.approval=1" ;
				$query_inner=$this->db->query($sql);
				$result_inner=$query_inner->result_array();
				$result[$i]['approved'] = $result_inner[0]['count_approved'] ;
				// Unapproved announcement
				$sql1="select count(b.id) as count_unapproved from organization a, organization_announcement b WHERE a.id=".$arr['id']." AND b.zoneid=".$zone_id." AND a.id=b.orgid AND b.approval=-1" ;
				$query_inner1=$this->db->query($sql1);
				$result_inner1=$query_inner1->result_array();
				$result[$i]['unapproved'] = $result_inner1[0]['count_unapproved'] ;
			$i++;
		}
		return $result;
		
    }
	// - High School Sports
	
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
		
		$query = $this->db->query("SELECT a.id,a.name FROM organization a, organization_announcement b WHERE a.id = b.orgid AND (b.approval = 0 OR b.approval = $announcement_type) AND a.type != 4 AND b.zoneid = $zoneid $by_char GROUP BY a.id order by a.name asc");
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
		if(trim($charval) != "all"){
			$org_where = " AND b.id IN (".str_replace('-',',',$charval).")";	// This portion must appear for particular org announcements
			//!empty($business_where) ? " AND c.id IN (".str_replace('-',',',$businessId).")" : '';  // Added !empty() on 21/6/14 for database error on 649 line.
		}
			$selected_where = " AND a.approval IN (".$selectid.",2)";		// 2 == ??????????
			
			$sql = "SELECT a.approval, a.id, a.orgid, a.title, a.announcement, b.name, c.first_name, c.last_name, c.username FROM organization_announcement a, organization b , users c WHERE a.orgid=b.id AND b.userid=c.id AND a.zoneid=".$zoneId.$selected_where.$org_where.$limit_where;
			$query= $this->db->query($sql);	
			$result=$query->result_array();
		if(empty($result)){
			$result='';
		}
		return $result;
    }
# - get_announcements_in_zone_for_approve

	public function get_announcements_by_zone($zoneId='',$lowerlimit=0,$upperlimit=10,$key = '')
	{ 				
		$sql = "SELECT a.approval, a.id, a.orgid, a.title, a.announcement, a.timestamp, b.name, c.first_name, c.last_name, c.username FROM organization_announcement a, organization b , users c WHERE a.orgid=b.id AND b.userid=c.id AND a.zoneid=".$zoneId." AND a.approval IN (1,2) limit ".$lowerlimit.",".$upperlimit;
		$result = $this->CommonController->getStoreCache($sql,'',$key,3600);
		if(empty($result)){
			$result=array();
		}
		return $result;
    }

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
public function get_organization_details($id){
	return $id;
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
			$afftectedRows = $this->db->affected_rows();
			return $afftectedRows;
		}
	}
# - all_announcements_status_change


######################################################################################################################################################

														/*Realtor Secton Begins Below*/

######################################################################################################################################################
// added the below on 09.01.2015
# + get_realtor_for_zone
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
		
		$query = $this->db->query("SELECT * FROM realtor WHERE zoneid=".$zone_id." ".$type." ".$where." ".$where_orderby."".$limit_where." ");		
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
# - get_realtor_for_zone

# + Change Realtor Status
	function fn_realtor_status_change($orgid, $zoneid, $action_performed, $change_business_status, $allorspecific, $organization_type){
		if($action_performed == 1 && $allorspecific == 1){ // For specific organizations
			$explode_value=explode(',',$orgid);
			foreach($explode_value as $organization){	
				$data = array('approval' => $change_business_status);
				$this->db->where('id', $organization);
				$this->db->where('zoneid', $zoneid);
				$this->db->update('realtor', $data);				
			}
			//$this->fn_announcement_update($orgid, $zoneid, $change_business_status);
			
		return $orgid;	
			
		}else if($action_performed == 1 && $allorspecific == 2){ // For all organizations
				$data = array('approval' => $change_business_status);
				$this->db->where('approval', $organization_type);
				$this->db->where('zoneid', $zoneid);
				$this->db->update('realtor', $data);
				
				$orgid=$this->fn_get_all_realtor($zoneid,$organization_type); 
				
				//$this->fn_announcement_update($orgid, $zoneid, $change_business_status);
		return 'all';
					
		}
	}
# - Change Realtor Status

 
function fn_get_all_realtor($zoneid,$organization_type){
	$allorgids=array();
	$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;	
	$sql="SELECT group_concat(id) as id FROM realtor WHERE zoneid=".$zoneid." and approval=".$organization_type;
	$query = $this->db->query($sql);
	$result= $query->result_array() ; 
	if(!empty($result)){
		$allorgids= $result[0]['id']; 
	}
	return $allorgids;
}


# + Delete Realtor
	public function fn_realtor_delete($orgid_arr, $zoneid, $action_performed, $change_business_status, $allorspecific, $organization_type){ //var_dump($_REQUEST);
		/*if($allorspecific == 2){ var_dump(1);// Delete All Organization
			$orgid_arr='';
			$orgid=$this->fn_get_all_org($zoneid,$organization_type); 
			$all_users_ids=$this->get_realtor_user_ids($orgid);		
		}else*/ 
		if($allorspecific == 1){  // Delete Specific Organization
			$orgid=$orgid_arr; 
			$all_users_ids=$this->get_realtor_user_ids($orgid_arr);
		}
		if($all_users_ids!=''){
			$_delete_users = "delete from users WHERE id IN (".$all_users_ids.")";
			$this->db->query($_delete_users) ;
			$_delete_users_groups = "delete from users_groups WHERE user_id IN (".$all_users_ids.")";
			$this->db->query($_delete_users_groups) ;
		}
		if($orgid!=''){
			$_delete_users = "delete from realtor WHERE id IN (".$orgid.") and zoneid='$zoneid'"; 
			$this->db->query($_delete_users) ;
		}
		if($zoneid!=''){
			$_delete_users_csvdocument = "delete from  tbl_savingstore_home_sold WHERE  zoneid='$zoneid'"; 
			$this->db->query($_delete_users_csvdocument) ;
		}
		if($allorspecific == 2){
			return 'all';		
		}else if($allorspecific == 1){
			return $orgid_arr;
		}
	}
# - Delete Realtor

# + get the realtor user ids
	public function get_realtor_user_ids($orgid){
		$alluserids = array();
		$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;
		$sql="SELECT group_concat(userid) as userid FROM realtor WHERE id IN(".$orgid.")";
		$query = $this->db->query($sql);
		$result= $query->result_array() ; 
		if(!empty($result)){
			$alluserids= $result[0]['userid']; 
		}
		return $alluserids;
	}
# - get the realtor user ids

# + realtor_detail
	function realtor_owner_detail($organizationid){		
		$this->db->where('a.id', $organizationid);
		$this->db->select('b.*');
		$this->db->from('realtor a');
		$this->db->join('users b', 'a.userid = b.id');
		$query = $this->db->get();
		$result=$query->result_array();
		$arr=(!empty($result[0])) ? $result[0] : 0; 
		return $arr;
	}
# - realtor_detail

# + realtor_details
function realtor_details($organizationid){
		$this->db->where('id', $organizationid);
		$this->db->select('id,name,zoneid');
		$this->db->from('realtor');
		$query = $this->db->get();
		$result=$query->result_array();
		$arr=(!empty($result[0])) ? $result[0] : 0; 
		return $arr;
	}
# - realtor_details	

# + get_realtor_by_id
	function get_realtor_by_id($id){
		$query = $this->db->query("SELECT a.id,a.name,b.username,b.password,b.email FROM realtor a,users b WHERE a.userid=b.id and a.id=".$id);
        return $query->row();
    } 
# - get_realtor_by_id

# + get_realtor_by_userid
	function get_realtor_by_userid($id){
		$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;
		$query = $this->db->query("SELECT * FROM realtor WHERE userid=".$id);
        return $query->result_array();
    } 
# - get_realtor_by_userid
##################################################################################################################################################

// Home Sold 

	public function fn_homesold_delete($orgid_arr, $zoneid, $action_performed, $change_business_status, $allorspecific, $organization_type){
		//var_dump($allorspecific); exit; 
		if($allorspecific == 2){ // Delete All Organization
			$orgid_arr='';
			$orgid=$this->fn_get_all_homesold($zoneid,$organization_type);
			//$all_users_ids=$this->fn_get_org_owners($orgid);		
		}else if($allorspecific == 1){ // Delete Specific Organization
			$orgid=$orgid_arr;
			//$all_users_ids=$this->fn_get_org_owners($orgid_arr);
		}	
		/*if($all_users_ids!=''){
			$_delete_users = "delete from users WHERE id IN (".$all_users_ids.")";
			$this->db->query($_delete_users) ;
			$_delete_users_groups = "delete from users_groups WHERE user_id IN (".$all_users_ids.")";
			$this->db->query($_delete_users_groups) ;
		}*/
		if($orgid!=''){
			//$_delete_organization_announcement = "delete from organization_announcement WHERE orgid IN (".$orgid.")";
			//$this->db->query($_delete_organization_announcement) ;
			//$_delete_organization_category = "delete from organization_category WHERE orgid IN (".$orgid.")";
			//$this->db->query($_delete_organization_category) ;
			$_delete_organization = "delete from tbl_savingstore_home_sold WHERE id IN (".$orgid.")";
			$this->db->query($_delete_organization) ;
		}
		if($allorspecific == 2){
			return 'all';		
		}else if($allorspecific == 1){
			return $orgid_arr;
		}
	}

function fn_get_all_homesold($zoneid,$organization_type){
	$allorgids=array();
	$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;	
	//$sql="SELECT group_concat(id) as id FROM organization WHERE zoneid=".$zoneid." and approval=".$organization_type;
	$sql="SELECT group_concat(id) as id FROM tbl_savingstore_home_sold WHERE zoneid=".$zoneid;
	$query = $this->db->query($sql);
	$result= $query->result_array() ; 
	if(!empty($result)){
		$allorgids= $result[0]['id']; 
	}
	return $allorgids;
}
function update_banner_upload($cat_id,$image_name,$description,$organizationid){
	$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;
    $sql = "SELECT * from banner_info where organizationid=".$organizationid;
	$query=$this->db->query($sql); 
	//$row=num_rows($query); 
	//if($row>1){
	if ($query->num_rows() > 0){ 
		 $sql1="update banner_info set banner_name='$cat_id',upload_banner='$image_name',description='$description' where organizationid=".$organizationid; 
	     $this->db->query($sql1);
		 return 1;
	}else{
		$data=array();
			$data=array(
				'banner_name'=>$cat_id,
				'upload_banner'=>$image_name,
				'description'=>$description,
				'organizationid'=>$organizationid,
			);	
			$this->db->insert('banner_info', $data);
       		$upload_id = $this->db->insert_id();
			return 0;
	    }
	
   
	
}

/*function fn_get_org_owners($orgid){
	$alluserids=array();
	$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;	
	$sql="SELECT group_concat(userid) as userid FROM organization WHERE id IN(".$orgid.")";
	$query = $this->db->query($sql);
	$result= $query->result_array() ; 
	if(!empty($result)){
		$alluserids= $result[0]['userid']; 
	}
	return $alluserids;
}*/

function show_realtor($zoneid){
	$sql=" select * from realtor WHERE zoneid=$zoneid";
	$query = $this->db->query($sql);
	return $query->result_array() ; 
}


function get_banner_by_realtorid($realtor_id){//var_dump($realtor_id);exit;
   if(!empty($realtor_id)){
	 $sql = "SELECT * FROM banner_info WHERE organizationid = $realtor_id" ;
	$query = $this->db->query($sql);
	return $query->result_array() ;
   }else{
	   return  0 ;
   }
}

	# + Delete banner photo
function delete_banner_photo($image_name,$organizationid){
		
		$sql="delete from banner_info";
		$this->db->query($sql);
		unlink('uploads/bannerupload/'.$organizationid.'/'.$image_name.'');
	}
# - Delete banner photo	

	/*
	 *	Get resident user selected category								by cr7
	 *
	 */
	 public function get_residentuserselectedorgcategory($zoneid = '', $loggeduserid = ''){
		 $response = array() ;
		 $this->db->select('selectedcategory, activecategory') ;
		 $this->db->from('resident_interestedcategory') ;
		 $this->db->where('zoneid', $zoneid) ;
		 $this->db->where('resident_userid', $loggeduserid) ;
		 $query = $this->db->get() ;
		 if($query->num_rows() == 1){
			 $result 					= $query->row() ;
		 	 $allselectedcategory_arr 	= explode(',', trim($result->selectedcategory, ',')) ;			// get all selected category as an array
			 $allactivecategory_arr 	= explode(',', trim($result->activecategory, ',')) ;			// get all selected category as an array
			 if(!empty($allselectedcategory_arr)){
					$this->db->select('a.*, b.id as orgid, b.name as orgname') ;
					$this->db->from('organization_category a') ;
					$this->db->join('organization b', 'a.orgid = b.id') ;
					$this->db->where('a.parent_id', 0) ;
					$this->db->where('b.approval', 1) ;
					$this->db->where('b.zoneid', $zoneid) ;
					$org_query 				= $this->db->get() ;
					$org_categorydetails 	= $org_query->result_array() ;								// get all category of above organization
				 
					if(!empty($org_categorydetails)){
						foreach($org_categorydetails as $orgdetails){
							$temp = array() ;
							if(!isset($response[$orgdetails['orgid']]['org_name'])){
								$response[$orgdetails['orgid']]['org_name'] = $orgdetails['orgname'] ;	// set organizatin name for a single time
							}
							$temp['isselected'] 						= (in_array($orgdetails['id'], $allselectedcategory_arr)) ? 1 : 0 ;
							$temp['isactive'] 							= (in_array($orgdetails['id'], $allactivecategory_arr)) ? 1 : 0 ;
							$temp['cat_id'] 							= $orgdetails['id'] ;
							$temp['cat_name'] 							= $orgdetails['name'] ;
							$response[$orgdetails['orgid']]['category_details'][] 	= $temp ;
						}
					}
			 }
		 }
		 return $response ;
	 }
	 
	/*
	 *	Update organization category status			by cr7
	 *
	 */
	function change_selectedcalendarcategory($zone_id = '', $user_id = '', $category_id = ''){
		if($zone_id != '' && $user_id != '' && $category_id != ''){
		
		// + Select category details of current user
			$this->db->from('resident_interestedcategory');
			$this->db->where('zoneid',$zone_id);
			$this->db->where('resident_userid',$user_id);
			$query 	= $this->db->get();
		// - Select category details of current user
			if($query->num_rows() == 1){	
				$temp 						= array() ;
				$selectedcategory_details 	= $query->row() ;//print_r($selectedcategory_details) ;exit ;
				
				if($selectedcategory_details->selectedcategory != ''){											// Already have active category
				
					if(preg_match('/,'.$category_id.',/',trim($selectedcategory_details->selectedcategory,' '))){		// Current category is in active ?
					
						if($selectedcategory_details->selectedcategory == ','.$category_id.','){					// If only current category selected
							$activecategory = str_replace(','.$category_id.',', '', $selectedcategory_details->selectedcategory) ;
						}else{																						// Others category with current cat
							$activecategory = str_replace(','.$category_id.',', ',', $selectedcategory_details->selectedcategory) ;
						}
						
					}else{																							// Current category is not active
						$activecategory = $selectedcategory_details->selectedcategory.$category_id.',' ;	
					}
					
				}else{																								// Do not have any active category
					$activecategory = ','.$category_id.',' ;
				}//print_r($activecategory) ;exit ;
			// + Update status
				$this->db->where('zoneid', $zone_id);
				$this->db->where('resident_userid', $user_id);
				$is_updated	= $this->db->update('resident_interestedcategory', array('selectedcategory'=>$activecategory));
				if($is_updated){
					return true ;
				}
			// - Update status
			}
			
		}else{
			return false ;	
		}
	}
	
	/**
	*	Get info about email offers criteria	
	*
	*/
	
	function getemailoffercriteria(){
		$this->load->model('emailnotice/email_notice','emailnotice') ;
		return $this->emailnotice->email_offers_criteria(0) ;
	}
	
	/**
	*	Get selected email offers criteria	
	*
	*/
	
	function getselectedemailoffercriteria($userid = '', $zoneid = ''){
		$this->db->select('a.*, b.email_offers_criteria_type') ;
		$this->db->from('users_email_offers a') ;
		$this->db->join('email_offers_criteria b', 'b.email_offers_criteria_id=a.email_offers_criteria_id');
		$this->db->where('a.usersid', $userid) ;
		$query 	= $this->db->get();
		$result = $query->result_array();
		
		$temp 	= array() ;
		// make array for selected criteria
		if(!empty($result)){
			foreach($result as $val){
				if($val['email_offers_criteria_type'] == 1){											// age
					$temp['age']['categoryid'] = $val['email_offers_criteria_id'] ;
				}
				if($val['email_offers_criteria_type'] == 2){											// gender
					$temp['gender']['categoryid'] = $val['email_offers_criteria_id'] ;
				}
				if($val['email_offers_criteria_type'] == 3){											// renter
					$temp['renter']['categoryid'] = $val['email_offers_criteria_id'] ;
				}
			}
		}
		return $temp ;
	}
	
	/**
	*	Update email offers criteria	
	*
	*/
	
	function updateemailoffercriteriaofuser($userid = '', $zoneid = '', $user_age = '', $user_gender = '', $user_renter = '', $action = 0){
		
		$flag = 1 ;
		if($action == 1){																// selected something
			$arr = array_filter(array('1'=>$user_age, '2'=>$user_gender, '3'=>$user_renter)) ;
			$this->db->select('a.*, b.email_offers_criteria_type') ;
			$this->db->from('users_email_offers a') ;
			$this->db->join('email_offers_criteria b', 'b.email_offers_criteria_id=a.email_offers_criteria_id');
			$this->db->where('a.usersid', $userid) ;
			$query = $this->db->get();
			$result = $query->result_array();											// get all selected criteria in an array
			
			if(!empty($result)){
				$result_arr = array() ;
				foreach($arr as $criteria_type=>$criteria_id){
					foreach($result as $key=>$val){
							if($val['email_offers_criteria_type'] == $criteria_type){								// update matching criteria
								$this->db->where('usersid', $userid) ;
								$this->db->where('email_offers_criteria_id', $val['email_offers_criteria_id']) ;
								$this->db->update('users_email_offers', array('usersid'=>$userid, 'zoneid'=>$zoneid, 'email_offers_criteria_id'=>$criteria_id, 'users_email_offers_timestamp'=>time(), 'users_email_offers_status'=>1)) ;
								if($this->db->affected_rows() < 0)	$flag = 0 ;
							}
							$result_arr[$val['email_offers_criteria_type']] = $val['email_offers_criteria_id'] ;	// constract array with saved data
					}
				}
				
				$add_arraydiff = array_diff_key($arr,$result_arr) ;						// differ new criteria from saved array
				if(!empty($add_arraydiff)){
					foreach($add_arraydiff as $addval){									// add criteria
						$this->db->insert('users_email_offers', array('usersid'=>$userid, 'zoneid'=>$zoneid, 'email_offers_criteria_id'=>$addval, 'users_email_offers_timestamp'=>time(), 'users_email_offers_status'=>1));
						if($this->db->insert_id() == '') $flag = 0 ;
					}
				}
				
				$del_arraydiff = array_diff_key($result_arr,$arr) ;						// differ saved criteria from new array
				if(!empty($del_arraydiff)){
					foreach($del_arraydiff as $delval){									// remove criteria
						$this->db->where('usersid', $userid) ;
						$this->db->where('email_offers_criteria_id', $delval) ;
						$this->db->delete('users_email_offers');
						if($this->db->affected_rows() < 0)	$flag = 0 ;
					}
				}
				
			}else{																		// save selected criteria as new
				foreach($arr as $key=>$val){
					$this->db->insert('users_email_offers', array('usersid'=>$userid, 'zoneid'=>$zoneid, 'email_offers_criteria_id'=>$val, 'users_email_offers_timestamp'=>time(), 'users_email_offers_status'=>1));
					if($this->db->insert_id() == '') $flag = 0 ;
				}
			}
		}else{																			// delete all criteria of a user
			$this->db->where('usersid', $userid) ;
			$this->db->delete('users_email_offers');
		}
		
		if($flag == 1) 																	// indicator
			return true ;
		else 
			return false ;
	}
	
	/**
	*	Get peekaboo credits of resident user
	*
	*/
	
	public function getpeekaboocreditsofresidentuser($userid = '', $zoneid = ''){
		$response = array();
		if($userid != ''){
			$result = $this->CommonController->SelectDataMultiWay('email_credit_balance','email_credit_balance_id,email_credit_balance_earn,email_credit_balance_status,MAX(email_credit_balance_timestamp) AS email_credit_balance_timestamp','resultArrayG',['usersid' =>$userid,'email_credit_balance_status' => 1],[],'email_credit_balance_earn');
			
			$defaultCredits = $this->getDefaultCredits($userid);	
		    $defaultBalance = isset($defaultCredits->defaultBalance)?$defaultCredits->defaultBalance:0;
			$response['totalcredits'] = (count($result) * 2) + $defaultBalance;

			$notcredited_result = $this->CommonController->SelectDataMultiWay('email_credit_balance','*','resultArrayG',['usersid' =>$userid,'email_credit_balance_status' => 0],[],'email_credit_balance_status');
			if(!empty($notcredited_result) && count($notcredited_result) == 1){
				$result[count($result)] = $notcredited_result[0] ; 
			}
			$response['result'] = array_reverse($result) ;
		}
		return $response ;
	}
	
	public function getDefaultCredits($userId) {
		$sqlDefaultCredits = "SELECT b.balance AS defaultBalance FROM users a INNER JOIN tbl_member b ON a.username = b.user_name WHERE b.member_type = 1 AND a.id = ".$userId;
		return $this->CommonController->SelectRawquery($sqlDefaultCredits, 'row');
	}
	
	/**
	*	Show peekaboo credit details of resident user
	*
	*/
	
	function showpeekaboocreditdetails($userid = '', $earnbalance = 0){
		$result = array() ;
		if($userid != ''){
			////	++
			$this->db->select('a.email_credit_balance_timestamp, b.business_email_subject, b.business_email_offer, c.name') ;
			$this->db->from('email_credit_balance a') ;
			$this->db->join('business_email b', 'a.business_email_id = b.business_email_id') ;
			$this->db->join('business c','c.id = a.businessid') ;
			$this->db->where('usersid', $userid) ;
			$this->db->order_by("a.email_credit_balance_id","desc");
			($earnbalance != 0) ? $this->db->where('email_credit_balance_earn', $earnbalance) : $this->db->where('email_credit_balance_status', $earnbalance) ;
			$query 	= $this->db->get();
			$result = $query->result_array();	//var_dump($result) ;exit ;
		}
		return $result ;
	}
	public function getOrganizationDetailsByOwnerId($organizationUserId) {
		$organizationUserId = (int)$organizationUserId;
		$sqlOrganizationFetchData = "SELECT id,name,zoneid FROM organization WHERE userid = ".$organizationUserId;
		return $this->CommonController->SelectRawquery($sqlOrganizationFetchData, 'row');
	}

	function getUserTypebyId($user_id=0)
	{
		$this->db->select('group_id');
		$this->db->from('users_groups');
		$this->db->where('user_id',$user_id);
		$row=$this->db->get();
		$num_rows = $row->num_rows();
		if($num_rows > 0)
		{
			$result=$row->row_array();
		}
		return $result;
	}
	
}