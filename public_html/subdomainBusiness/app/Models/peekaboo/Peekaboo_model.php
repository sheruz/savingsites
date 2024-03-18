<?php
class Peekaboo_model extends CI_Model

{
	public function __construct(){
		parent::__construct();
        $this->load->library('ion_auth');
		$this->load->helper('url');
        //$this->load->database();
		$this->load->helper('array');
    }
	
	function get_pboo_search($limit=20,$orderbyvalue="",$orderway="",$active_gift_zone='',$peekaboo_category='',$selectPrductSort='',$active_peekaboo_auction_busid='',$zoneid=''){
		//var_dump($peekaboo_category);var_dump($orderway);exit;
		//if($selectDistanceSort!='0' && $selectPrductSort!='0'){

		/*$sql="select * from tbl_member limit 1"; 
		$query=$peekaboo_db->query($sql);
		$result=$query->result_array();	*/
		$current_time = date('Y-m-d');
		$extraquery='';$select='';$select_catid='';
		if(!empty($user_id)){ 
			$extraquery='
			LEFT JOIN tbl_auc_watch as tw ON tw.auc_id=a.auc_id';
			$select="tw.id as my_auction_id,";
		}
		//$orderby=!empty($orderby) ? 'ORDER BY '.$orderby : 'ORDER BY auc_id';
		if(!empty($orderbyvalue) && $orderbyvalue!="laststart_date"){
			$orderby = 'ORDER BY '.$orderbyvalue  ;
		}else if(!empty($orderbyvalue) && $orderbyvalue=="laststart_date"){
			$orderby = 'ORDER BY start_date'  ;
		}else{
		    $orderby = 'ORDER BY product_name' ;
		}
		$orderway=!empty($orderway) ? $orderway : 'DESC';
		/*$orderby=!empty($distance) ? '' : $orderby; 
		$orderway=!empty($distance) ? '' : $orderway;*/
		$proximity_select=!empty($distance) ? "m.user_id, ( 3959 * acos( cos( radians(".$latitude.") ) * cos( radians( `lattitude` ) ) * cos( radians(`longitude`) - radians(".$longitude.")) + sin(radians(".$latitude.")) * sin( radians(`lattitude`)))) AS distance," : '';
		$proximity_from=!empty($distance) ? " LEFT JOIN tbl_member as m ON m.user_id=a.user_id" : '';
		$proximity_where=!empty($distance) ? "AND m.member_type=2 AND a.auc_id IS NOT NULL " : '';
		$proximity_having=!empty($distance) ? "HAVING distance<$distance" : '';
		$current_time=date("Y-m-d",time());
		$tbl_autobid_autobuy=!empty($user_id) ? "LEFT JOIN tbl_autobid_autobuy ab ON ab.auc_id=a.auc_id AND ab.user_id=".$user_id."": '';
		$select_autobid_status=!empty($user_id) ? ',ab.autobid_buy_status' : '';
		$tbl_alerts=!empty($user_id) ? "LEFT JOIN tbl_alerts al ON al.seller_id=ip.user_id AND al.user_id=".$user_id." AND al.seller_id=ip.user_id": '';
		$select_alerts=!empty($user_id) ? ',al.status as alert_status' : '';
		//$active_peekaboo_auction_busid = !empty($active_peekaboo_auction_busid) ? "LEFT JOIN business bus on " : '';
        //$active_gift_zone =!empty($active_gift_zone) && ($active_gift_zone!='all') ? " AND sales_zone ss_zoneid.id='".$active_gift_zone."'" : ''; 
		
        if($peekaboo_category!='all'){
		  $select_catid=" INNER JOIN tbl_category cat ON cat.cat_id=ip.cat_id AND cat.cat_id='$peekaboo_category' "; 	
			
		}
		// + search in specific zone
		if($active_gift_zone != ''){
			// + search in SS zone
			if(is_numeric($active_gift_zone)){
				$proximity_search = ' INNER JOIN tbl_member tm ON tm.user_id = a.user_id INNER JOIN users u ON u.username = tm.user_name INNER JOIN business bus ON bus.business_owner_id = u.id INNER JOIN ads_setting_preferences asp ON asp.businessid = bus.id AND asp.settingszoneid ='.$active_gift_zone ;
				$where_proximity = '' ;
			}else{ // search in peekaboo zone
				$proximity_search = 'LEFT JOIN tbl_member tm ON tm.user_id = a.user_id left JOIN users u ON u.username = tm.user_name ' ;
				$where_proximity = ' AND u.username IS NULL' ;
			}
		}else{
			$proximity_search = '' ;
			$where_proximity = '' ;
		}
		
		if($zoneid!=''){
			$zone_pbbo_search = "INNER JOIN tbl_member tm ON tm.user_id = a.user_id INNER JOIN users u ON u.username = tm.user_name INNER JOIN business bus ON bus.business_owner_id = u.id INNER JOIN ads_setting_preferences a_s_p ON a_s_p.businessid = bus.id AND a_s_p.settingszoneid='".$zoneid."'"; 
			
			//INNER JOIN sales_zone ss_zoneid ON ss_zoneid.sales_rep_id=u.id AND ss_zoneid.id='".$zoneid."'"; 
			
			//$zone_pbbo_select_search = " sales_zone ss_zoneid,"; 
			//$zone_pbbo_search = " AND ss_zoneid.id='".$zoneid."'"; 
		}else{
			//$zone_pbbo_select_search = "";
			$zone_pbbo_search = ""; 
		}
		
		// - search in specific zone


         // + search within 24 hours to take sort by dropdown value
		if(!empty($orderbyvalue)){
			if($orderbyvalue == "start_date"){
				$search_by_date = " AND a.start_date>='".date('Y-m-d ', strtotime($current_time. ' -1 day'))."' AND a.start_date<='".$current_time."'" ;
			}else if($orderbyvalue == "end_date"){
				$search_by_date = " AND a.end_date<='".date('Y-m-d ', strtotime($current_time. ' +1 day'))."'" ;
			}else{
		     $search_by_date = " AND a.start_date<='".$current_time."'" ;	
		   }//var_dump($search_by_date);exit ;
		}else{
		     $search_by_date = " AND a.start_date<='".$current_time."'" ;	
		}
		// - search within 24 hours to take sort by dropdown value

		$sql="SELECT $select $proximity_select ip.product_name $select_autobid_status  $select_alerts,ip.company_name,ip.unit_price,ip.model,ip.image,ip.nobypass,ip.consolation_price,ip.user_id as seller_id,a.*,COUNT(sbr.auc_id) no_bids
				FROM tbl_auction a LEFT JOIN tbl_inventory_products ip ON ip.product_id=a.product_id $select_catid
				LEFT JOIN tbl_showprice_bid_records sbr ON sbr.auc_id = a.auc_id 	
				$extraquery
				$proximity_from
				$tbl_autobid_autobuy
				$tbl_alerts
				$proximity_search
				$zone_pbbo_search
				WHERE 
				(a.display='yes' AND a.status='Live' $search_by_date AND a.approval_status=1 $proximity_where $where_proximity)				
				GROUP BY a.auc_id 
				$proximity_having
				$orderby $orderway";
				//echo $sql;exit;
				
		$query=$this->db->query($sql);
		$result=$query->result_array();	
		
		if(!empty($result)){
			// ++ Add remaining time of each auction
			 foreach($result as $key=>$val){
				$startdate = strtotime('now');
				$stopdate = strtotime($val['end_date']);
				$diff = $stopdate - $startdate; //<-Time of countdown in seconds.  ie. 3600 = 1 hr. or 86400 = 1 day.
				
				$days = floor($diff / 86400);
				$diff = $diff % 86400;
				$hours = floor($diff / 3600);
				$diff = $diff % 3600;
				$minutes = floor($diff / 60);
				$diff = $diff % 60;
				$seconds = $diff;
				$arr = array('days'=>$days,'hours'=>$hours,'minutes'=>$minutes,'seconds'=>$seconds) ;
				$result[$key] = array_merge($val,$arr) ;
			 }
			 // -- Add remaining time of each auction
		}
			
			//echo "<pre>";var_dump(count($result),$result);exit;
			
		/*$sql_1="select * from users limit 1"; 
		$query_1=$default_db->query($sql_1);
		$result1=$query_1->result_array();*/
		$result=!empty($result) ? $result : $result='';
		return $result;		
		//}
	}
	
	function get_categories(){
		$sql="select * from tbl_category"; 
		$query=$this->db->query($sql);
		$result=$query->result_array();	
		return $result;
	}
	function get_active_zone(){
			$sql="SELECT f.id,f.name from tbl_member a, tbl_auction b, users c, business d,ads_setting_preferences e, sales_zone f where a.user_id=b.user_id and a.user_name=c.username and c.id=d.business_owner_id and d.id=e.businessid and e.settingszoneid=f.id and f.active='1' and b.status='Live' group by f.id";
			$query=$this->db->query($sql);
		    $result=$query->result_array();	
			return $result;
		}
		
	function peekaboo_zone(){
			$sql="SELECT b.auc_id,c.username from tbl_member a LEFT JOIN tbl_auction b on a.user_id=b.user_id LEFT JOIN users c on a.user_name=c.username where b.status='Live' and c.username IS NULL group by b.auc_id";
			$query=$this->db->query($sql);
			$result=$query->result_array();
			if(count($result)>0){
			return 1;
			}
		}	
	
	function active_peekaboo_auction($zone_id){
			$current_time=date("Y-m-d",time());
			$sql = "select c.id as bus_id from tbl_member a,tbl_auction b,business c, users d, tbl_inventory_products e, sales_zone f, ads_setting_preferences g where a.user_id=b.user_id and a.user_name=d.username and f.id='$zone_id' and b.product_id=e.product_id and c.business_owner_id=d.id and a.status='active' and a.user_id=e.user_id and b.status='Live' and c.id=g.businessid and f.id=g.settingszoneid AND b.start_date<='$current_time' group by c.id";
			$query=$this->db->query($sql);
			$result=$query->result_array();
			$bus_id = '';
			foreach($result as $val){
				$bus_id.= $val['bus_id'].',';
			}
			 $all_bus_id = substr($bus_id, 0, -1); 
			  return $all_bus_id;
	}
	
	
	
	function get_favorites_ads_ids(){
	
	    var_dump(11);exit;	
		
	}
	
	
	
	
	
	
	
	
	
	
	
	function view_group($zone_id=0){
		$sql="SELECT id,name FROM group_interest WHERE createdby_type=1 AND createdby_id=$zone_id AND assign_type=1 order by name asc";
		$query = $this->db->query($sql);
    	$result = $query->result_array();
		return $result;
	}
	
	function edit_group($group_id=0,$zoneid=0){
		$sql="SELECT id,name,description FROM group_interest WHERE id=$group_id";
		$query = $this->db->query($sql);
    	$result = $query->result_array();
		return $result;
	}
	
	function save_group($data=array(),$group_id=0,$zoneid=0){
		if($group_id==-1){
			if(element('createdby_type',$data)==1){
				$status=1;
			}else if(element('createdby_type',$data)==2){ // business
				$status=$this->fn_check_zone_pref_for_interest_group($zoneid);
			}else if(element('createdby_type',$data)==3){ // org				
				$status=$this->fn_check_zone_pref_for_interest_group($zoneid);				
			}
			$data['status']=$status; 
			$this->db->insert('group_interest', $data);
			$id=$this->db->insert_id();
			!empty($id)? $success='insert' : $success='';
		}else{
			$new_data = elements(array('name', 'description'), $data);
			$this->db->where('id', $group_id);
            $is_updated=$this->db->update('group_interest', $new_data);
			!empty($is_updated) ? $success="update" : $success="";
		}
		return $success;
	}
	function fn_check_zone_pref_for_interest_group($zoneid=0){		
		$this->db->where('zoneid',$zoneid);
		$this->db->select('auto_approve_ig_by_org,auto_approve_ig_by_business');
		$query=$this->db->get('zone_preferences');
		$result=$query->result_array(); //var_dump($result);
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
	function delete_group($id=0,$param=''){
		if($param='zone'){
			$this->db->where('id', $id);
			$this->db->delete('group_interest');
		}
	}
	function display_ig($zoneid=0,$createdby_id=0,$ig_type=0,$createdby_type=0){
		$array=array('createdby_type'=>$createdby_type,'createdby_id'=>$createdby_id,'status'=>$ig_type);
		$this->db->select('id,name,createdby_type');
		$query = $this->db->get_where('group_interest', $array);
		//echo $this->db->last_query();exit;
		
		/*$sql="SELECT id,name FROM group_interest WHERE createdby_type=$createdby_type AND createdby_id=$createdby_id AND status=$ig_type";
		$query = $this->db->query($sql);*/
    	$result = $query->result_array();
		return $result;
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
	
	function group_visibility($zoneid=0,$createdby_id=0,$createdby_type=0,$option=1){
		/*$sql="SELECT a.id,a.name FROM group_interest a,ads_setting_preferences b WHERE ((a.createdby_type=$createdby_type AND a.createdby_id=$createdby_id ) OR (a.createdby_id=b.settingszoneid AND a.createdby_type=1 AND a.createdby_id=$zoneid )) AND a.status=1 GROUP BY a.id";*/
		if($option==1){
			$wh=" a.createdby_id=b.settingszoneid AND a.createdby_type=1 AND a.createdby_id=$zoneid";
			$wh1=" c.createdby_id=d.zone_id and d.createdby_id=$createdby_id";
		}else if($option==2){
			$wh=" a.createdby_type=$createdby_type AND a.createdby_id=$createdby_id";
			$wh1=" c.createdby_id=d.createdby_id and d.createdby_id=$createdby_id";
		}else{
			$wh=''; $wh1='';
		}
		//$sql="SELECT a.id,a.name FROM group_interest a,ads_setting_preferences b WHERE $wh AND a.status=1 GROUP BY a.id";
		
		$sql="SELECT c.id,c.name,d.user
		FROM
		(SELECT a.id,a.name,a.createdby_id FROM group_interest a,ads_setting_preferences b WHERE $wh AND a.status=1 GROUP BY a.id) as c
		LEFT JOIN (SELECT count(distinct id) AS user,interest_groupid,createdby_id,zone_id  from user_group_interest group by interest_groupid) AS d ON d.interest_groupid=c.id and $wh1 
		";
		
		$query= $this->db->query($sql);		    	
		$result=$query->result_array();
		return $result;
	}
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
		$arr_actionedcateids=explode(',',$groupid); //var_dump($arr_actionedcateids);
		//get categoryid from category_display w.r.t $zoneid
		$arr_existingcategories=array();
		/*$this->db->select('groupid');
		$this->db->where('zoneid',$zoneid);
		$this->db->where('displayid',$createdby_id); 
		$this->db->where('displaytype',$createdby_type);  
		$query1=$this->db->get('group_interest_display');*/
		
		if($option==1){
			//$wh=" a.createdby_id=b.settingszoneid AND a.createdby_type=1 AND a.createdby_id=$zoneid";
			$wh=" and b.createdby_type=1 and createdby_id=$zoneid";
			
		}else if($option==2){
			//$wh=" and displaytype=$createdby_type AND displayid=$createdby_id";
			$wh=" and b.createdby_type=$createdby_type and b.createdby_id=$createdby_id";
		}else{
			$wh='';
		}
		$sql="select groupid from group_interest_display a,group_interest b where a.groupid=b.id and a.zoneid=$zoneid and a.displaytype=$createdby_type AND a.displayid=$createdby_id $wh and b.status=1"; //exit;
		
		$query= $this->db->query($sql);		    	
		$result1=$query->result();
		//var_dump($result1); 
		//$result1=$query1->result();//
		//$this->db->last_query(); 
		
		if(isset($result1)){
			$inc=0;
			foreach($result1 as $vresult1){
				$arr_existingcategories[$vresult1->groupid]=$vresult1->groupid;
				$inc++;
			}
		}
		//var_dump($arr_existingcategories); //exit;
		/*if(!empty($arr_existingcategories))
		{*/
			/*if(trim($groupid)==''){
				$this->db->where_in('groupid',$arr_existingcategories); 
				$this->db->where('zoneid',$zoneid);
				$this->db->where('displayid',$createdby_id); 
				$this->db->where('displaytype',$createdby_type); 																																																																					        	$this->db->delete('group_interest_display');//delete category	
				
			}else if(empty($arr_existingcategories) && !empty($arr_actionedcateids)){*/	
			if(empty($arr_existingcategories) && !empty($arr_actionedcateids)){ //var_dump(1); exit;
				foreach($arr_actionedcateids as $v1){
					$data1=array();
					$data1=array('groupid'=>$v1,'zoneid'=>$zoneid,'displayid'=>$createdby_id,'displaytype'=>$createdby_type);
					$this->db->insert('group_interest_display',$data1);
				}
			}else if(count($arr_existingcategories)!=count($arr_actionedcateids)){ //var_dump(2); exit;
				$arrdiffdb2html=array_diff($arr_existingcategories,$arr_actionedcateids);
				$arrdiffhtml2db=array_diff($arr_actionedcateids,$arr_existingcategories);
				//var_dump($arrdiffdb2html); var_dump($arrdiffhtml2db); exit;
				if(!empty($arrdiffdb2html)){
					//delete from database		
					foreach($arrdiffdb2html as $v1){
						$this->db->where('groupid',$v1);
						$this->db->where('zoneid',$zoneid);
						$this->db->where('displayid',$createdby_id); 
						$this->db->where('displaytype',$createdby_type); 																																																																					        			$this->db->delete('group_interest_display');
					}
				}
				if(!empty($arrdiffhtml2db)){
					//insert to database	
					foreach($arrdiffhtml2db as $v2){
						$data1=array();
						$data1=array('groupid'=>$v2,'zoneid'=>$zoneid,'displayid'=>$createdby_id,'displaytype'=>$createdby_type);
						$this->db->insert('group_interest_display',$data1);
					}	
				}
			/*}else {
				var_dump($arr_actionedcateids);
			}*/
		}else if($arr_actionedcateids[0]=='' && !empty($arr_existingcategories)){ //var_dump(3); exit;
			foreach($arr_existingcategories as $v1){
					$data1=array();
					//$data1=array('groupid'=>$v1,'zoneid'=>$zoneid,'displayid'=>$createdby_id,'displaytype'=>$createdby_type);
					//$this->db->insert('group_interest_display',$data1);
					$this->db->where('groupid',$v1);
						$this->db->where('zoneid',$zoneid);
						$this->db->where('displayid',$createdby_id); 
						$this->db->where('displaytype',$createdby_type); 																																																																					        			$this->db->delete('group_interest_display');
				}
		}
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
	function snap_status_check($zoneid=0,$createdby_id=0,$createdby_type=0,$user_id=0){
		$this->db->select('status');
		$_where=array('zone_id'=>$zoneid,'user_id'=>$user_id,'createdby_id'=>$createdby_id,'type'=>$createdby_type);
		$query=$this->db->get_where('user_offer_status',$_where);		
		$result=$query->result_array();
		if(!empty($result)){			
			$status=$result[0]['status'];
		}else
			$status=0;
		
		return $status;
	}
	function check_ig_display($user_id=0,$createdby_id=0,$zone_id=0,$type=0){
		$this->db->select('interest_groupid');
		$where_array=array('zone_id'=>$zone_id,'user_id'=>$user_id,'createdby_id'=>$createdby_id,'type'=>$type);
		$query=$this->db->get_where('user_group_interest',$where_array);
		//echo $this->db->last_query();			
		$result=$query->result_array();
		return $result;
 	}	
	function user_group_interest_insert($user_id=0,$interest_group=false,$zone_id=0,$createdby_id=0,$type=0){
		!empty($interest_group) ? $interest_group_array=explode('@#$',$interest_group) : $interest_group_array='';		
		
		$where_array=array('zone_id'=>$zone_id,'user_id'=>$user_id,'createdby_id'=>$createdby_id);
		$this->db->delete('user_group_interest',$where_array); 			
		
		if(!empty($interest_group_array))
		{
			foreach($interest_group_array as $key=>$ig)
			{
				$data=array(
							'zone_id'=>$zone_id,						
							'user_id'=>$user_id,
							'createdby_id'=>$createdby_id,
							'interest_groupid'=>$ig,
							'type'=>$type
							
							);
				$this->db->insert('user_group_interest',$data);
			}	
		}
		
	}
	function user_status_update($user_id=0,$zone_id=0,$createdby_id=0,$type=0,$status=0){
		$sql="select id from user_offer_status where zone_id=$zone_id and user_id=$user_id and createdby_id=$createdby_id and type=$type";
		$query=$this->db->query($sql);
		if($query->num_rows()>0){ // update
			$id_arr= $query->result_array();
			$id=$id_arr[0]['id'];
			$data=array('status'=>$status);
			$this->db->where('id', $id);
            $is_updated=$this->db->update('user_offer_status', $data);
			
		}else{ // insert
			$data_ins = array(
    			'zone_id' => $zone_id,
				'user_id' => $user_id,					
				'createdby_id' => $createdby_id,
				'type'=>$type,
				'status'=>$status
    		);
			$this->db->insert('user_offer_status', $data_ins);
		}
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
	
	function all_notices($zoneid=0,$createdby_id=0,$createdby_type=0){
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
	
	function send_mail_to_all_group($zone_id=0,$owner_id=0,$mailtosent=false,$subject=false,$detail=false,$createdby_type=0,$all_groupname=false,$all_ig_id=false){	
		$fromemail='noreply@savingssites.com';
		$email_subject=$subject;
		$message_body="<div style='border:1px solid #900; padding:5px;'><br /><br />".$detail."<br/>
				<br /><br />
				Best Regards,<br />
				Savings Sites Support.</div>"; 
		$this->load->library('email');
		$this->email->clear();
		$this->email->from($fromemail);
		$this->email->subject($email_subject);
		$this->email->message($message_body);
		if($mailtosent!=''){
			$this->email->to($mailtosent);
			$s=$this->email->send();
			$to[]=$mailtosent;
		}		
		if(!empty($s))
		{
			$data=array(	'recipient'=>$mailtosent,
							'group_id'=>$all_ig_id,
							'group_name'=>$all_groupname,
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
		$result="Notice Successfully Sent!";
		return $result;
	}
	
	function edit_en($notice_id=0,$zoneid=0,$createdby_id=0,$createdby_type=0){
		$this->db->select('id,subject,detail');
		$this->db->where('id',$notice_id);
		$query =$this->db->get('email_notice');
    	$result = $query->result_array();
		return $result;
	}
	function delete_en($id=0){
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
		$query=$this->db->get('zone_organization');
		$result=$query->result_array();		
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
	/*
	 * Checking peekaboo link to redirect
	 */
	function checkLink($url = ''){
		$result = array() ;
		$array=array('a.peekaboo_link'=>$url);
		
		$this->db->select('a.user_id, c.id');
		$this->db->from('tbl_member a') ;
		$this->db->join('users b', 'a.user_name = b.username') ;
		$this->db->join('business c', 'b.id = c.business_owner_id') ;
		$this->db->where($array); 
		
		$query		= $this->db->get();
		if($query->num_rows() == 1){
			$result		= $query->result_array();
		}
		return $result;
	}
	/*
	* get_cash_certificate_value
	*/
	function get_cash_certificate_value($data=0)
	{
	$sql="SELECT t1.product_id, t1.product_name, t1.company_name, t1.consolation_price, t1.publisher_fee, t1.seller_credit, t1.zone_id
,t2.auc_id, t2.buy_price_decrease_by, t2.current_price, t2.start_date, t2.end_date
FROM tbl_inventory_products t1
INNER JOIN tbl_auction t2 ON t1.product_id = t2.product_id
WHERE t2.product_id=$data;";
	$query = $this->db->query($sql);
	$result = $query->result();
	return $result;
	}
	function get_bidder_userid($username='',$member_type)  
	{
		$sql="SELECT * from tbl_member where `user_name`='$username' AND `member_type` = $member_type;";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}  
	
	function my_close_rtp_auction($userid='',$purchase_time='')
	{
		$current_time=$this->get_local_time("time");
		$sql="SELECT ip.user_id as seller_id,ip.product_id,ip.product_name,ip.unit_price,ip.model,ip.image,ip.company_name,a.auc_id,tso.order_id,tso.dispatched_status,tso.unit_price sold_for, tso.order_datetime,tso.payment_status
		FROM tbl_auction a LEFT JOIN tbl_inventory_products ip ON ip.product_id=a.product_id LEFT JOIN 
		tbl_sales_order tso ON  tso.auc_id=a.auc_id
		WHERE tso.user_id='$userid' AND ('$current_time'<= DATE_ADD(tso.order_datetime,INTERVAL $purchase_time DAY) OR tso.payment_status='Completed') AND a.status!='Live'  GROUP BY tso.order_id  ORDER BY tso.order_id DESC,tso.payment_status asc";

		$query = $this->db->query($sql);
		$data = $query->result();
		return $data;
	}
	function get_time_zone_setting()
	{
		$sql="SELECT gmt_time FROM tbl_time_zone_setting WHERE active='yes'";
		$query = $this->db->query($sql);
		$data = $query->result();

		$split=explode(":",$data[0]->gmt_time);
		return $split;
	}
		
	function get_local_time($time="none")
	{
		$time_zone=$this->get_time_zone_setting();	
		$hour_delay=$time_zone[0];$minute_delay=$time_zone[1];
		
		if($time!='none')
			return date("Y-m-d H:i:s",mktime (gmdate("H")+$hour_delay,gmdate("i")+$minute_delay,gmdate("s"), gmdate("m"),gmdate("d"),gmdate("Y")));
			else
			return date("Y-m-d",mktime(gmdate("H")+$hour_delay,gmdate("i")+$minute_delay,gmdate("s"),gmdate("m"), gmdate("d"),gmdate("Y")));
	}


	function querySelectSingle()
	{
		$query = "SELECT *FROM tbl_settings";
		$query = $this->db->query($query);
		$result = $query->result();
		return $result;
	}
	function check_user_certficate($post){
	$user_id = !empty($post['seller']) ? $post['seller'] : '';
	$certificate_id=!empty($post['certificate_id']) ? $post['certificate_id'] : '';
	$bidderuser_id=!empty($post['bidderuser_id']) ? $post['bidderuser_id'] : '';

	if(empty($certificate_id))
	{$this->error_msg[]='Please provide certificate id.';}	

	$sql = "SELECT a.product_id,a.user_id,e.certificate_verify,e.order_id,e.user_id as bidder_id,f.auc_id from tbl_inventory_products a, tbl_member b, users c, business d, tbl_sales_order e, tbl_auction f  where a.product_id='$certificate_id' and a.user_id=b.user_id and b.user_name=b.user_name and b.user_id='$user_id' and a.product_id=f.product_id and c.id=d.business_owner_id and e.auc_id=f.auc_id and e.user_id='$bidderuser_id' GROUP by a.product_id";// echo $query; exit;

	/*"SELECT a.product_id,e.certificate_verify,e.order_id from tbl_inventory_products a, tbl_member b, users c, business d, tbl_sales_order e, tbl_auction f  where a.product_id='$this->certificate_id' and a.user_id=b.user_id and b.user_name=b.user_name and b.user_id='$user_id' and a.product_id=f.product_id and c.id=d.business_owner_id and e.auc_id=f.auc_id and e.user_id='$this->bidderuser_id' GROUP by a.product_id";

	$query = "SELECT a.certificate_verify,a.product_id,a.user_id  from tbl_inventory_products a, tbl_member b, users c, business d  where a.product_id='$this->certificate_id' and a.user_id=b.user_id and b.user_name=b.user_name and b.user_id='$user_id' and c.id=d.business_owner_id GROUP by a.product_id";*/
	//$data=parent::querySelect($query); //var_dump($data);exit;
	echo $sql;echo "<br />";
	print_r($post);
	$query = $this->db->query($sql);
	$data = $query->result();
	return $data;
	}
}