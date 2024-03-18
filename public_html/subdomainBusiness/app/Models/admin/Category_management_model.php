<?php
namespace App\Models\admin;

use CodeIgniter\Model;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Category_management_model extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->CommonController = new CommonController();
    }
	
	function get_business_types_name_array(){
        $query = $this->db->query('SELECT * from business_type');
        $ret = array();
        foreach($query->result_array() as $ra){
            $ret[$ra['id']] = $ra['name'];
        }
        return $ret;
    }
	
	function get_all_categories()
    {
    	$query = $this->db->query('SELECT * from category');		
    	return $query->result_array();
    }
	
	function update_category_status($category_id=0,$status=0){
		$data=array('status'=>$status);
		$this->db->where('id',$category_id);
		$update_category=$this->db->update('category',$data);
		return $update_category;
	}
	
	function get_all_subcategories($id)
    {    	
		$query = $this->db->query('SELECT * from  category_subcategory where catid='.$id);		
    	return $query->result_array();
    }
	function get_individual_category_details($id)
    {
    	$query = $this->db->query('SELECT * from category where id='.$id);		
    	return $query->result_array();
    }
	function get_individual_subcategory_details($id)
    {
    	$query = $this->db->query('SELECT * from category_subcategory where id='.$id);		
    	return $query->result_array();
    }
	
	function get_all_active_categories()
    {
    	$query = $this->db->query('SELECT * from category where status=1');		
    	return $query->result_array();
    }
	function get_all_subcat_in_category($catid){
		$query=$this->db->query("select * from category_subcategory where catid=".$catid." and status=1");			
    	return $query->result_array();
	}
	
	function delete_category($cat_id=0){
		if(!empty($cat_id)){
			$delete_cat=array('id'=>$cat_id);
			$delete_subcat=array('catid'=>$cat_id);
			$this->db->delete('category',$delete_cat);
			$this->db->delete('category_subcategory',$delete_subcat);
		}
	}
	
	function add_cat_to_zone($catid,$zonetype,$selectedzone,$allsubcats=false){ //13
		
		$data = array(				
				'zoneassigntype' => $zonetype,
		);
		$this->db->where('id', $catid);
		$this->db->update('category', $data);
		if($zonetype==1){
			$this->db->where('catid', $catid);						
			$this->db->delete('category_to_zone');
		}
		else if($zonetype==2){
			$this->db->where('catid', $catid);
			$this->db->delete('category_to_zone');
			$explode_value=explode(',',$selectedzone);
			for($i=0;$i<count($explode_value);$i++){
				$val[$i]=$explode_value[$i];
				$data=array(
					'catid'=>$catid,
					'zoneid'=>$val[$i],
					'status'=>1,
					'assigntype' => 1
				);
				$sql="select * from category_to_zone where catid=".$catid." and zoneid=".$val[$i];
				$check_sqlquery = $this->db->query($sql);
				$result = $check_sqlquery->num_rows();
				if($result =='0'){
					$this->db->insert('category_to_zone', $data);
				}
			}
		}
	
	}
	function get_category_zone($catid){
		$query = $this->db->query('SELECT * from category_to_zone where catid='.$catid);		
    	return $query->result_array();
	}
	
	function get_all_zone_subcategories1($catid){
		$query = $this->db->query('SELECT b.id,b.name from category_to_zone a,sales_zone b where a.zoneid=b.id and a.catid='.$catid);		
    	return $query->result_array();
	}
	
	function get_all_zone_subcategories($catid){
		$query = $this->db->query('SELECT a.id,a.name,a.catid,a.status,a.zoneid,a.zoneassigntype as ztype,b.zoneassigntype from category_subcategory a,category b where a.catid=b.id and a.catid='.$catid.' and a.status=1');		
    	return $query->result_array();
	}
	
	function get_category_for_zone($zoneid,$catfrom){
		$query = $this->db->query('SELECT * from category where zoneid='.$zoneid);
		return $query->result_array();
	}
	function change_get_category_for_zone($zoneid,$catfrom){
		if($catfrom=='byyou' || $catfrom=='')	
		{	
			$query = $this->db->query('SELECT * from category where zoneid='.$zoneid);		
		}
		else if($catfrom=='all')
		{
			$query = $this->db->query('SELECT * from category where zoneid="0" AND zoneassigntype="1"' );
		}
		
		return $query->result_array();
	}
	function get_category_for_zone1($zoneid){		
		$query = $this->db->query('SELECT * from category where zoneid='.$zoneid." and status=1");		
    	return $query->result_array();
	}
	function get_category_for_zone2($zoneid){		
		$query = $this->db->query('SELECT a.zoneid as zone,b.* from category_to_zone a,category b where a.catid=b.id and a.zoneid='.$zoneid." and a.status=1");		
    	return $query->result_array();
	}
	function get_category_display_for_zone_change($zoneid=false, $uid=false){		
		$sql_1="select id from sales_zone where sales_rep_id=".$uid;
		$result_1 = $this->CommonController->SelectRawquery($sql_1,'resultArray');
		// $result_1=$query_1->result_array();
		$allmyzones = '' ;
		for($i=0;$i<count($result_1);$i++)
			$allmyzones .= $result_1[$i]['id']."," ;
		if($allmyzones != '') $allmyzones = substr($allmyzones,0,strlen($allmyzones)-1) ;
		
		
		$sql="select * from category where zoneassigntype!=0 and status=1 order by name asc";
		$query=	$this->db->query($sql);
		$result=$query->result_array();
		for($i = 0 ; $i < count($result) ; $i++) {
			if($result[$i]['zoneassigntype']==1){
				$result1[$i]['id'] = $result[$i]['id'] ;
				$result1[$i]['catname'] = $result[$i]['name'] ;
				$result1[$i]['status'] = $result[$i]['status'] ;
				$result1[$i]['zoneid'] = $result[$i]['zoneid'] ;
				$result1[$i]['zoneassigntype'] = $result[$i]['zoneassigntype'] ;
				$sql_zone="select b.name from category_display a,sales_zone b where a.catid=".$result[$i]['id']." and a.zoneid=b.id and a.zoneid in (".$allmyzones.") order by b.name asc";
				$query_zone=$this->db->query($sql_zone);
				$result_zone=$query_zone->result_array();
				if(!empty($result_zone)){
					$allmyzones_name = '' ;
					for($j=0;$j<count($result_zone);$j++)
						$allmyzones_name .= $result_zone[$j]['name'].", " ;
					if($allmyzones_name != '') $allmyzones_name = substr($allmyzones_name,0,strlen($allmyzones_name)-2) ;
				
					$result1[$i]['zone_names'] = $allmyzones_name ;
				}else{
					$result1[$i]['zone_names'] = '---' ;
				}
			}else if($result[$i]['zoneassigntype']==2){
				$sql_inner="select b.* from category_to_zone a,category b where a.catid=b.id and a.catid=".$result[$i]['id']." and a.zoneid in(".$zoneid.")";
				$result_inner=$this->CommonController->SelectRawquery($sql_inner,'resultArray');
				// $result_inner=$query_inner->result_array();
				//var_dump($result_inner);
				if(!empty($result_inner)){
					$result1[$i]['id'] = $result[$i]['id'] ;
					$result1[$i]['catname'] = $result[$i]['name'] ;
					$result1[$i]['status'] = $result[$i]['status'] ;
					$result1[$i]['zoneid'] = $result[$i]['zoneid'] ;
					$result1[$i]['zoneassigntype'] = $result[$i]['zoneassigntype'] ;
					$sql_zone="select b.name from category_display a,sales_zone b where a.catid=".$result[$i]['id']." and a.zoneid=b.id and a.zoneid in (".$allmyzones.") order by b.name asc";
					$result_zone=$this->CommonController->SelectRawquery($sql_zone,'resultArray');
					// $result_zone=$query_zone->result_array();
					if(!empty($result_zone)){
						$allmyzones_name = '' ;
						for($j=0;$j<count($result_zone);$j++)
							$allmyzones_name .= $result_zone[$j]['name'].", " ;
						if($allmyzones_name != '') $allmyzones_name = substr($allmyzones_name,0,strlen($allmyzones_name)-2) ;
					
						$result1[$i]['zone_names'] = $allmyzones_name ;
					}else{
						$result1[$i]['zone_names'] = '---' ;
					}
				}
			}
		}
    	return $result1;
	}
	public function get_category_display_for_zone($zoneid){		
		$sql="select * from category_new where zoneassigntype!=0 and status=1 order by name asc";
		$result = $this->CommonController->SelectRawquery($sql,'resultArray');
		for($i = 0 ; $i < count($result) ; $i++) {
			if($result[$i]['zoneassigntype']==1){
				$result1[$i]['id'] = $result[$i]['id'] ;
				$result1[$i]['catname'] = $result[$i]['name'] ;
				$result1[$i]['status'] = $result[$i]['status'] ;
				$result1[$i]['zoneid'] = $result[$i]['zoneid'] ;
				$result1[$i]['zoneassigntype'] = $result[$i]['zoneassigntype'] ;
			}else if($result[$i]['zoneassigntype']==2){
				$sql_inner="select b.* from category_to_zone a,category b where a.catid=b.id and a.catid=".$result[$i]['id']." and a.zoneid=".$zoneid;
				$result_inner = $this->CommonController->SelectRawquery($sql_inner,'resultArray');
				if(!empty($result_inner)){
					$result1[$i]['id'] = $result[$i]['id'] ;
					$result1[$i]['catname'] = $result[$i]['name'] ;
					$result1[$i]['status'] = $result[$i]['status'] ;
					$result1[$i]['zoneid'] = $result[$i]['zoneid'] ;
					$result1[$i]['zoneassigntype'] = $result[$i]['zoneassigntype'] ;
				}
			}
		}
    	return $result1;
	}
	
	function check_category_created_zoneowner($catid){
		$sql="select * from category where id=".$catid;
		$query=$this->db->query($sql);
		$result=$query->result_array();
		if($result[0]['zoneid']==0){
			return 0;
		}else if($result[0]['zoneid']!=0){
			return $result[0]['zoneid'];
		}		
	}
	function assign_category_created_zoneowner($catid,$cat_name,$status,$check_category_created_zoneowner){
		$data = array(
				'name' => $cat_name,				
				'status' => $status,
				'zoneassigntype' => 1,
		);
		$this->db->where('id', $catid);
		$this->db->update('category', $data);
		
		$newdata = array(
				'catid' => $catid,				
				'zoneid' => $check_category_created_zoneowner,
				'status' => 1,
		);		
		$this->db->insert('category_to_zone', $newdata);
	}
	
	function check_sub_category_created_zoneowner($id){
		$sql="select * from category_subcategory where id=".$id;
		$query=$this->db->query($sql);
		$result=$query->result_array();
		if($result[0]['zoneid']==0){
			return 0;
		}else if($result[0]['zoneid']!=0){
			return $result[0]['zoneid'];
		}		
	}
	
	function assign_sub_category_created_zoneowner($id,$subcat_name,$subcatstatus,$check_sub_category_created_zoneowner){
		$data = array(
				'name' => $subcat_name,				
				'status' => $subcatstatus,
		);
		$this->db->where('id', $id);
		$this->db->update('category_subcategory', $data);
		
		$newdata = array(
				'subcatid' => $id,				
				'zoneid' => $check_sub_category_created_zoneowner,
				'status' => 1,
		);		
		$this->db->insert('category_subcategory_to_zone', $newdata);
	}
	function add_category_display_all_zone($allzoneid,$current_zone){

		die;

		$arr_zoneid=explode(',',$allzoneid);		
		$arr_existingsubcategories=array();
		// for categories
		$arr_existingcategories=array();
		$this->db->select('catid');
		$this->db->where('zoneid',$current_zone); 
		$query1=$this->db->get('category_display');
		$result1=$query1->result();
		if(isset($result1)){
			$inc=0;
			foreach($result1 as $vresult1){
				$arr_existingcategories[$vresult1->catid]=$vresult1->catid;
				$inc++;
			}
		}			
		foreach($arr_existingcategories as $_x){			
			$this->db->select('catid,subcatid');
			$this->db->where('zoneid',$current_zone);
			$this->db->where('catid',$_x);  
			$query2=$this->db->get('subcategory_display');
			$result2=$query2->result(); 
			if(isset($result2)){
				$inc1=0;
				foreach($result2 as $vresult2){
					$arr_existingsubcategories[$vresult2->catid][$vresult2->subcatid]=$vresult2->subcatid;
					$inc1++;
				}
			}
		}
		foreach($arr_zoneid as $zoneid){			
			$this->db->where('zoneid',$zoneid);																																																																					        	$this->db->delete('category_display');//delete category
			$this->db->where('zoneid',$zoneid);																																																																					        	$this->db->delete('subcategory_display'); // delete subcategory
			
			foreach($arr_existingcategories as $v1){
				$data1=array();
				$data1=array('catid'=>$v1,'zoneid'=>$zoneid);
				$this->db->insert('category_display',$data1);
			}
			foreach($arr_existingsubcategories as $key=>$val){
				foreach($val as $v2){
					$data2=array();
					$data2=array('catid'=>$key,'subcatid'=>$v2,'zoneid'=>$zoneid);
					$this->db->insert('subcategory_display',$data2);
				}
			}
		}
	}
	
	
	
	function add_category_display($catid,$zoneid,$status){ 

        
        $sql_1="select id from category_display where catid=".$catid." and zoneid =".$zoneid;
		$result_1 = $this->CommonController->SelectRawquery($sql_1,'resultArray');
	 
		if($status == 'unselected'){

			    if(count($result_1) != 0){ 
	             	$this->CommonController->deleteData('category_display',['id' => $result_1[0]['id']]);
			    }		

		}else{

			 if(count($result_1) == 0){ 
				 $catdata = array(
				'catid' => $catid,
				'zoneid' => $zoneid		 
		    );		    

		    $data['addressid'] = $this->CommonController->InsertData('category_display', $catdata);

	        }
		}
 

 

	}
	function add_category_display_new($catid,$zoneid){
		$sql="select * from category_display where catid IN(".$catid.") and zoneid=".$zoneid; //exit;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		//var_dump($result);
		if($catid!=''){
			for($i=0;$i<count($result);$i++){			
				$this->db->where('id', $result[$i]['id']); 
				$this->db->delete('category_display');
			}
		}else{
			$this->db->where('zoneid',$zoneid);		
			$this->db->delete('category_display');
		}
		if($catid!=''){
			$explode_value=explode(',',$catid);
			for($i=0;$i<count($explode_value);$i++){
				$val[$i]=$explode_value[$i];
				$data=array('catid'=>$val[$i],'zoneid'=>$zoneid);
				$this->db->insert('category_display', $data);
			}
		}
	}
	function add_all_category_subcategory_display($catid,$zoneid){
		//var_dump($catid); var_dump($zoneid);
		$explode_value_zone=explode(',',$zoneid);
		for($i=0;$i<count($explode_value_zone);$i++){
			$val_zone[$i]=$explode_value_zone[$i];
			$this->db->where('zoneid',$val_zone[$i]);
			//$this->db->where('type',2);
			$this->db->delete('category_display');
		}
		if($catid!=''){ 
			for($i=0;$i<count($explode_value_zone);$i++){
				$explode_value_cat=explode(',',$catid);
				$val_zone[$i]=$explode_value_zone[$i];
				for($j=0;$j<count($explode_value_cat);$j++){
					$val_cat[$j]=$explode_value_cat[$j];
					$data=array('catid'=>$val_cat[$j],'zoneid'=>$val_zone[$i]); //var_dump($data);
					$this->db->insert('category_display', $data);
				}
			}
		}
	}
	
	
	function get_display_category_for_zone($zoneid){
		
		$Common = new CommonController();
		$sql='SELECT catid from category_display where zoneid='.$zoneid; 
    	$result_arr = $Common->SelectRawquery($sql, 'resultArray');

		 		
		$displayzones='';
		for($i = 0 ; $i < count($result_arr) ; $i++) {
			$displayzones.= $result_arr[$i]['catid']."," ;			
		}
		$displayzones = substr($displayzones,0,strlen($displayzones)-1);
		if($displayzones===false)
			return 0;
		else
			return $displayzones;
	}
	function get_sub_category_for_zone($catid,$zoneid){
		$Common = new CommonController();
		$query = 'SELECT * from category_display where catid='.$catid.' and zoneid='.$zoneid;		
    	return $Common->SelectRawquery($query, 'resultArray');
	}
	function get_all_sub_category_for_zone_old($catid,$zoneid){
		$Common = new CommonController();
		$query =  'SELECT id,catid,name,status,zoneid,zoneassigntype from category_subcategory where catid IN('.$catid.',-1) and status=1 order by name asc';
		return $Common->SelectRawquery($query, 'resultArray');
	 
	}
	function get_all_sub_category_for_zone($catid,$zoneid){
	 
		$Common = new CommonController();
	 
        $query = 'SELECT id,child_type from category_new where id ='.$catid ;
        $result=$Common->SelectRawquery($query, 'resultArray');


		foreach($result as $_x){
			if($_x['child_type']=='n'){			 

                $query1 = 'SELECT * from category_sub_subcategory_new where parent_id ='.$_x['id'].' and parent_type = "c" order by name asc' ;
                $result=$Common->SelectRawquery($query1, 'resultArray'); 
				foreach($result as $k=>$subcat){
					$arr['-100']['name']='-100';
					$arr[-100][$subcat['id']]['name']=$subcat['name'];				
				}
				
			}else if($_x['child_type']=='y'){
		 
				$sql="SELECT a.name as subcat_name,b.* FROM category_subcategory_new a,category_sub_subcategory_new b WHERE a.id=b.parent_id and a.catid=".$_x['id']." and b.parent_type='s' order by subcat_name asc,b.name asc"; //exit;			 
				$result=$Common->SelectRawquery($sql, 'resultArray');
				foreach($result as $k=>$subcat){
					$arr[$subcat['parent_id']]['name']=strtoupper($subcat['subcat_name']);
					$arr[$subcat['parent_id']][$subcat['id']]['name']=$subcat['name'];
					
				}
			}
		}
		return $arr;
 	
	}
	
	
	function add_sub_category_display($catid,$zoneid,$pcatid){

	 
       $Common = new CommonController();	
 
         

      	     $catdata = array(
				'catid' => $pcatid,
				'zoneid' => $zoneid,
				'subcatid'	=>  $catid
		    );		    

		      $this->CommonController->InsertData('subcategory_display', $catdata);


 }
 





	
	function get_display_sub_category_for_zone($zoneid,$catid){
    	$Common = new CommonController();		
		$sql='SELECT subcatid from subcategory_display where zoneid='.$zoneid.' and catid='.$catid;	
		$result_arr=$Common->SelectRawquery($sql, 'resultArray');	
     
		$displayzones='';
		for($i = 0 ; $i < count($result_arr) ; $i++) {
			$displayzones.= $result_arr[$i]['subcatid']."," ;			
		}
		$displayzones = substr($displayzones,0,strlen($displayzones)-1);
		return $displayzones;
	}
	function get_all_categories_zone($zoneid=0,$param=''){
		if($param=='create_business'){
			$where=" and b.id!='-99'";
		}else{
			$where='';
		}
		$query = $this->db->query('SELECT b.id,b.name from category_display a,category b where a.catid=b.id and a.zoneid='.$zoneid.$where);		
    	return $query->result_array();
	}
	
	function get_all_categories_business($id=false){
		$sql="select group_concat(settingszoneid) as zoneid from ads_setting_preferences where businessid=".$id." AND isdefault IN(0,1)";
		$query=$this->db->query($sql);
		$result1=$query->result_array();
		//var_dump($result1);
		if(!empty($result1)){
			$allzoneids= $result1[0]['zoneid']; //echo '<br/>'; 
		//foreach($result1 as $_x){
			$sql1='SELECT b.id,b.name from category_display a,category_new b where a.catid=b.id and a.zoneid IN('.$allzoneids.') group by b.id order by b.name asc';
			$query1=$this->db->query($sql1);
			$result=$query1->result_array();
		//}
		return $result;
		}		
	}
	function get_defaultzone($id){
		$sql="select settingszoneid from ads_setting_preferences where businessid=".$id." AND isdefault IN(0,1)";
		$query=$this->db->query($sql);
		$result1=$query->row();
		return $result1; 
	}
	
		function get_all_subcategories_business($catid,$busid){
		$sql="select * from ads_setting_preferences where businessid=".$busid;
		$query=$this->db->query($sql);
		$result1=$query->result_array();
		foreach($result1 as $_x){
			$sql1='SELECT b.id,b.name from subcategory_display a,category_subcategory b where a.subcatid=b.id and a.catid=b.catid and a.catid='.$catid.' and a.zoneid='.$_x['settingszoneid'].' and b.status=1 order by b.name asc';
			$query1=$this->db->query($sql1);
			$result=$query1->result_array();
		}
		return $result; 
	}
	function get_all_subcategories_business1($busid){
		$sql="select * from ads_setting_preferences where businessid=".$busid;
		$query=$this->db->query($sql);
		$result1=$query->result_array();
		foreach($result1 as $_x){
			$sql1='SELECT b.id,b.name from subcategory_display a,category_subcategory b where a.subcatid=b.id and a.catid=b.catid and a.zoneid='.$_x['settingszoneid'].' and b.status=1';
			$query1=$this->db->query($sql1);
			$result=$query1->result_array();
		}
		return $result; 
	}
	
	
	function get_all_subcategories_ad_zone($id){
		$sql1='SELECT b.id,b.name from subcategory_display a,category_subcategory b where a.subcatid=b.id and a.catid=b.catid and a.zoneid='.$id.' and b.status=1';
		$query1=$this->db->query($sql1);
		$result=$query1->result_array();
		return $result; 
	}
	function get_all_selected_zones(){
		$query = $this->db->query('SELECT * from category_to_zone where status=1');		
    	return $query->result_array();
	}
	
	function getaa(){		
		$sql='SELECT * from category where status=1';		
    	$result_arr=$this->db->query($sql)->result_array();		
		$selectedzones='';
		for($i = 0 ; $i < count($result_arr) ; $i++) {
			$selectedzones.= $result_arr[$i]['id']."," ;			
		}
		$selectedzones = substr($selectedzones,0,strlen($selectedzones)-1);
		return $selectedzones;
	}
	function getbb(){		
		$sql='SELECT b.zoneid from category a,category_to_zone b where a.id=b.catid and a.status=1 and b.status=1';		
    	$result_arr=$this->db->query($sql)->result_array();		
		$selectedzones='';
		for($i = 0 ; $i < count($result_arr) ; $i++) {
			$selectedzones.= $result_arr[$i]['zoneid']."," ;			
		}
		$selectedzones = substr($selectedzones,0,strlen($selectedzones)-1);
		return $selectedzones;
	}
	function getcc($catid){		
		$sql='SELECT * from category_to_zone where catid='.$catid.' and status=1';		
    	$result_arr=$this->db->query($sql)->result_array();		
		$selectedzones='';
		for($i = 0 ; $i < count($result_arr) ; $i++) {
			$selectedzones.= $result_arr[$i]['zoneid']."," ;			
		}
		$selectedzones = substr($selectedzones,0,strlen($selectedzones)-1);
		return $selectedzones;
	}
	function zone_get_all_subcategories_zone($catid,$zoneid){
		$sql1='SELECT b.id,b.name from subcategory_display a,category_subcategory b where a.subcatid=b.id and a.catid=b.catid and a.catid='.$catid.' and a.zoneid='.$zoneid.' and b.status=1';
		$query1=$this->db->query($sql1);
		$result=$query1->result_array();
		return $result; 
	}
	function get_all_subcategories_zone($catid=false,$zoneid=false){		
		$catid1=($catid[0]!='')? $catid[0]:0 ; $catid2=(!empty($catid[1]))? $catid[1] : 0 ; 
		if($catid1!=0){
		$sql_cat1_name="select name from category where id=".$catid1;
		$query_cat1=$this->db->query($sql_cat1_name);
		$result_cat1=$query_cat1->result_array();	
		$_cat1_name=$result_cat1[0]['name'];
			
		$sql1='SELECT b.id,b.name from subcategory_display a,category_subcategory b where a.subcatid=b.id and a.catid=b.catid and a.catid='.$catid1.' and a.zoneid='.$zoneid.' and b.status=1';
		$query1=$this->db->query($sql1);
		
		$result=$query1->result_array();
		if(!empty($result)){
		foreach($result as $key=>$val){
			$result_final[$_cat1_name][$key]['id']=$val['id'];
			$result_final[$_cat1_name][$key]['name']=$val['name'];
		}
		}else{
			$result_final='';
		}
		}
		if($catid2!=0){
		
		$sql_cat2_name="select name from category where id=".$catid2;
		$query_cat2=$this->db->query($sql_cat2_name);
		$result_cat2=$query_cat2->result_array();	
		$_cat2_name=$result_cat2[0]['name'];
		
		$sql1='SELECT b.id,b.name from subcategory_display a,category_subcategory b where a.subcatid=b.id and a.catid=b.catid and a.catid='.$catid2.' and a.zoneid='.$zoneid.' and b.status=1';
		$query1=$this->db->query($sql1);
		
		$result=$query1->result_array();
		if(!empty($result)){
		foreach($result as $key=>$val){
			$result_final[$_cat2_name][$key]['id']=$val['id'];
			$result_final[$_cat2_name][$key]['name']=$val['name'];
		}
		}else{
			$result_final='';
		}
		}
		return $result_final; 
	}
	function get_subcategories_in_a_category_zone($adid=false,$zoneid=false){
		$sql="select categoryid from ads where id=".$adid;
		$query=$this->db->query($sql);
		$result=$query->result_array();
		for($i=0;$i<count($result);$i++){
			$sql1='SELECT b.id,b.name from subcategory_display a,category_subcategory b where a.subcatid=b.id and a.catid=b.catid and a.catid='.$result[$i]['categoryid'].' and a.zoneid='.$zoneid.' and b.status=1';
			$query1=$this->db->query($sql1);
			$result_final=$query1->result_array();
		}
		return $result_final;
	}
	function get_subcategories_in_a_category($adid=false,$zoneid=false){
		$result_final='';
		$sql="select categoryid,categoryid1 from ads where id=".$adid;
		$query=$this->db->query($sql);
		$result=$query->result_array();
		foreach($result as $_val){
			$catid1=$_val['categoryid']; $catid2= $_val['categoryid1'];
			if($catid1!=0){
				$sql_cat1_name="select name from category where id=".$catid1;
				$query_cat1=$this->db->query($sql_cat1_name);
				$result_cat1=$query_cat1->result_array();	
				$_cat1_name=$result_cat1[0]['name'];
					
				$sql1='SELECT b.id,b.name from subcategory_display a,category_subcategory b where a.subcatid=b.id and a.catid=b.catid and a.catid='.$catid1.' and a.zoneid='.$zoneid.' and b.status=1';
				$query1=$this->db->query($sql1);
				
				$result=$query1->result_array();
				foreach($result as $key=>$val){
					$result_final[$catid1.'#'.$_cat1_name][$key]['id']=$val['id'];
					$result_final[$catid1.'#'.$_cat1_name][$key]['name']=$val['name'];
				}
			}
			if($catid2!=0){
		
				$sql_cat2_name="select name from category where id=".$catid2;
				$query_cat2=$this->db->query($sql_cat2_name);
				$result_cat2=$query_cat2->result_array();	
				$_cat2_name=$result_cat2[0]['name'];
				
				$sql1='SELECT b.id,b.name from subcategory_display a,category_subcategory b where a.subcatid=b.id and a.catid=b.catid and a.catid='.$catid2.' and a.zoneid='.$zoneid.' and b.status=1';
				$query1=$this->db->query($sql1);
				
				$result=$query1->result_array();
				foreach($result as $key=>$val){
					$result_final[$catid2.'#'.$_cat2_name][$key]['id']=$val['id'];
					$result_final[$catid2.'#'.$_cat2_name][$key]['name']=$val['name'];
				}
			}
		}
		return $result_final;
	}
	
	function get_subcategories_in_a_category_old($adid=false,$zoneid=false){
		$sql="select categoryid from ads where id=".$adid;
		$query=$this->db->query($sql);
		$result=$query->result_array();
		for($i=0;$i<count($result);$i++){
			$sql1='SELECT b.id,b.name from subcategory_display a,category_subcategory b where a.subcatid=b.id and a.catid=b.catid and a.catid='.$result[$i]['categoryid'].' and a.zoneid='.$zoneid.' and b.status=1';
			$query1=$this->db->query($sql1);
			$result_final=$query1->result_array();
		}
		return $result_final;
	}
	
	
	function add_subcat_to_zone($subcatid,$subzonetype,$selectedsubzone,$catid){
		$data = array(				
				'zoneassigntype' => $subzonetype,
		);
		$this->db->where('id', $subcatid);
		$this->db->update('category_subcategory', $data);
		
		if($subzonetype==1){
			
			$this->db->where('subcatid', $subcatid);
			$this->db->where('catid', $catid);
			$this->db->where('zoneid', $selectedsubzone);
			$this->db->delete('category_subcategory_to_zone');
			
			$data=array(
					'subcatid'=>$subcatid,					
					'zoneid'=>$selectedsubzone,
					'catid'=>$catid,
					'status'=>1
				);
			$this->db->insert('category_subcategory_to_zone', $data);
		}else if($subzonetype==2){
			if($selectedsubzone!=''){
				$zoneassigntype=2;
			}else if($selectedsubzone==''){
				$zoneassigntype=1;
			}
			$data = array('zoneassigntype' => $zoneassigntype);
			$this->db->where('id', $subcatid);
			$this->db->where('catid', $catid);
			$this->db->update('category_subcategory', $data);
			
			$this->db->where('subcatid', $subcatid);
			$this->db->where('catid', $catid);
			$this->db->delete('category_subcategory_to_zone');
			
			$explode_value=explode(',',$selectedsubzone);
			if($selectedsubzone!=''){
			for($i=0;$i<count($explode_value);$i++){
				$val[$i]=$explode_value[$i];
				$data=array(
					'subcatid'=>$subcatid,
					'catid'=>$catid,
					'zoneid'=>$val[$i],
					'status'=>1
				);
				$sql="select * from category_subcategory_to_zone where subcatid=".$subcatid." and catid=".$catid." and zoneid=".$val[$i]; 
				$check_sqlquery = $this->db->query($sql);
				$result = $check_sqlquery->num_rows();
				if($result =='0'){
					$this->db->insert('category_subcategory_to_zone', $data);
				}
				
			}
			}
		}
	
	}
	function getsubcatforzone($subcatid){		
		$sql='SELECT * from category_subcategory_to_zone where subcatid='.$subcatid.' and status=1';		
    	$result_arr=$this->db->query($sql)->result_array();		
		$selectedzones='';
		for($i = 0 ; $i < count($result_arr) ; $i++) {
			$selectedzones.= $result_arr[$i]['zoneid']."," ;			
		}
		$selectedzones = substr($selectedzones,0,strlen($selectedzones)-1);
		return $selectedzones;
	}
	
	function get_subcategory_details($id){ 
		$sql='SELECT * from category_subcategory where catid='.$id.' and status=1';		
    	$result_arr=$this->db->query($sql)->result_array();
		return $result_arr;	
	}
	
	// this function is called from zone page
	
	function get_category_subcategory_for_food($zone){		
		$sql="SELECT c.id as CategoryId,c.name as Category,d.id as SubCategoryId,d.name as SubCategory FROM category_display a,subcategory_display b,category c,category_subcategory d WHERE a.catid=b.catid AND a.catid=c.id AND b.subcatid=d.id AND a.zoneid=".$zone." AND a.zoneid=b.zoneid and c.status=1 and c.id=30 order by c.name asc,d.name asc";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		$arr=array();
		foreach($result as $_val_cat_subcat){
			$str1='';
			$str1=stripslashes($_val_cat_subcat['CategoryId'].'~!~'.$_val_cat_subcat['Category'].'~!~'.$_val_cat_subcat['SubCategoryId'].'~!~'.$_val_cat_subcat['SubCategory']);
			$arr[$str1]=0;
		}
		$sql_1="SELECT c.id as CategoryId,c.name as Category,d.id as SubCategoryId,d.name as SubCategory,count(f.id) as adcount FROM category_display a,subcategory_display b,category c,category_subcategory d,ad_to_zone e,ads f,business g,ads_setting_preferences h
		WHERE a.catid=b.catid and a.zoneid=b.zoneid and a.catid=c.id AND b.subcatid=d.id and a.zoneid=e.zoneid and e.adid=f.id AND f.business_id=g.id   		
		and a.zoneid=".$zone." and  c.status=1 and c.id=30 		
		and h.businessid=g.id AND h.settingszoneid=".$zone." AND h.approval IN(1,2,3) and (f.subcategoryid=d.id or f.subcategoryid1=d.id) and (f.categoryid=c.id or f.categoryid1=c.id) and e.approval=1 
		
		group by c.id,d.id order by c.name asc,d.name asc";
		$query_1 = $this->db->query($sql_1);
		$result_1=$query_1->result_array();
		$arr1=array();
		foreach($result_1 as $_val_cat_subcat){
			$str2='';
			$str2=stripslashes($_val_cat_subcat['CategoryId'].'~!~'.$_val_cat_subcat['Category'].'~!~'.$_val_cat_subcat['SubCategoryId'].'~!~'.$_val_cat_subcat['SubCategory']);
			$arr1[$str2]=$_val_cat_subcat['adcount'];
		}
		$final_arr=array_merge($arr,$arr1);
		$i=0; $arr=array();
		foreach($final_arr as $key=>$_val_cat_subcat){
			$key_explode=explode('~!~',$key);
			$arr[$i]['CategoryId']=$key_explode[0];
			$arr[$i]['Category']=$key_explode[1];
			$arr[$i]['SubCategoryId']=$key_explode[2];
			$arr[$i]['SubCategory']=$key_explode[3];
			$arr[$i]['adcount']=$_val_cat_subcat;
			$i++;
		}
		return $arr;
	}
	function get_category_subcategory_for_bcsoon($zone){
		$sql="SELECT c.id as CategoryId,c.name as Category,d.id as SubCategoryId,d.name as SubCategory,count(f.id) as adcount FROM category_display a,subcategory_display b,category c,category_subcategory d,ad_to_zone e,ads f,business g,ads_setting_preferences h 
		WHERE a.catid=b.catid and a.zoneid=b.zoneid and a.catid=c.id AND b.subcatid=d.id and a.zoneid=e.zoneid and e.adid=f.id AND f.business_id=g.id   
		
		and a.zoneid=".$zone." and  c.status=1 and c.id=-99		
		and h.businessid=g.id AND h.settingszoneid=".$zone." AND h.approval IN(1,2,3) and (f.subcategoryid=d.id or f.subcategoryid1=d.id) and (f.categoryid=c.id or f.categoryid1=c.id) and e.approval=1 		
		group by c.id,d.id order by c.name asc,d.name asc";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	function get_category_subcategory_for_bcsoon_old($zone){		
		$sql="SELECT c.id as CategoryId,c.name as Category,d.id as SubCategoryId,d.name as SubCategory FROM category_display a,subcategory_display b,category c,category_subcategory d WHERE a.catid=b.catid AND a.catid=c.id AND b.subcatid=d.id AND a.zoneid=".$zone." AND a.zoneid=b.zoneid and c.status=1 and c.id=-99 order by c.name asc,d.name asc";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		$arr=array();
		foreach($result as $_val_cat_subcat){
			$str1='';
			$str1=stripslashes($_val_cat_subcat['CategoryId'].'~!~'.$_val_cat_subcat['Category'].'~!~'.$_val_cat_subcat['SubCategoryId'].'~!~'.$_val_cat_subcat['SubCategory']);
			$arr[$str1]=0;
		}
		$sql_1="SELECT c.id as CategoryId,c.name as Category,d.id as SubCategoryId,d.name as SubCategory,count(f.id) as adcount FROM category_display a,subcategory_display b,category c,category_subcategory d,ad_to_zone e,ads f,business g,ads_setting_preferences h 
		WHERE a.catid=b.catid and a.zoneid=b.zoneid and a.catid=c.id AND b.subcatid=d.id and a.zoneid=e.zoneid and e.adid=f.id AND f.business_id=g.id   
		
		and a.zoneid=".$zone." and  c.status=1 and c.id=-99		
		and h.businessid=g.id AND h.settingszoneid=".$zone." AND h.approval IN(1,2,3) and (f.subcategoryid=d.id or f.subcategoryid1=d.id) and (f.categoryid=c.id or f.categoryid1=c.id) and e.approval=1 		
		group by c.id,d.id order by c.name asc,d.name asc";
		$query_1 = $this->db->query($sql_1);
		$result_1=$query_1->result_array(); var_dump($result_1);
		$arr1=array();
		foreach($result_1 as $_val_cat_subcat){
			$str2='';
			$str2=stripslashes($_val_cat_subcat['CategoryId'].'~!~'.$_val_cat_subcat['Category'].'~!~'.$_val_cat_subcat['SubCategoryId'].'~!~'.$_val_cat_subcat['SubCategory']);
			$arr1[$str2]=$_val_cat_subcat['adcount'];
		}
		$final_arr=array_merge($arr,$arr1);
		$i=0; $arr=array();
		foreach($final_arr as $key=>$_val_cat_subcat){
			$key_explode=explode('~!~',$key);
			$arr[$i]['CategoryId']=$key_explode[0];
			$arr[$i]['Category']=$key_explode[1];
			$arr[$i]['SubCategoryId']=$key_explode[2];
			$arr[$i]['SubCategory']=$key_explode[3];
			$arr[$i]['adcount']=$_val_cat_subcat;
			$i++;
		}
		return $arr;
	}
	function getAllCategories($zoneId=false){
		$arr=array();
	}
	
	function get_category_subcategory($zone){		
		$sql="SELECT c.id as CategoryId,c.name as Category,d.id as SubCategoryId,d.name as SubCategory FROM category_display a,subcategory_display b,category c,category_subcategory d WHERE a.catid=b.catid AND a.catid=c.id AND b.subcatid=d.id AND a.zoneid=".$zone." AND a.zoneid=b.zoneid and c.status=1 and c.id NOT IN(30,-99) order by c.name asc,d.name asc";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		$arr=array();
		foreach($result as $_val_cat_subcat){
			$str1='';
			$str1=stripslashes($_val_cat_subcat['CategoryId'].'~!~'.$_val_cat_subcat['Category'].'~!~'.$_val_cat_subcat['SubCategoryId'].'~!~'.$_val_cat_subcat['SubCategory']);
			$arr[$str1]=0;
		}
		$sql_1="SELECT c.id as CategoryId,c.name as Category,d.id as SubCategoryId,d.name as SubCategory,count(f.id) as adcount FROM category_display a,subcategory_display b,category c,category_subcategory d,ad_to_zone e,ads f,business g,ads_setting_preferences h 
		WHERE a.catid=b.catid and a.zoneid=b.zoneid and a.catid=c.id AND b.subcatid=d.id and a.zoneid=e.zoneid and e.adid=f.id AND f.business_id=g.id   
		and a.zoneid=".$zone." and  c.status=1 and c.id NOT IN(30,-99)
		and (f.subcategoryid=d.id or f.subcategoryid1=d.id) and (f.categoryid=c.id or f.categoryid1=c.id) and e.approval=1 and h.businessid=g.id AND h.settingszoneid=".$zone."        AND h.approval IN(1,2,3) group by c.id,d.id order by c.name asc,d.name asc";
		$query_1 = $this->db->query($sql_1);
		$result_1=$query_1->result_array();
		$arr1=array();
		foreach($result_1 as $_val_cat_subcat){
			$str2='';
			$str2=stripslashes($_val_cat_subcat['CategoryId'].'~!~'.$_val_cat_subcat['Category'].'~!~'.$_val_cat_subcat['SubCategoryId'].'~!~'.$_val_cat_subcat['SubCategory']);
			$arr1[$str2]=$_val_cat_subcat['adcount'];
		}
		$final_arr=array_merge($arr,$arr1);
		$i=0; $arr=array();
		foreach($final_arr as $key=>$_val_cat_subcat){
			$key_explode=explode('~!~',$key);
			$arr[$i]['CategoryId']=$key_explode[0];
			$arr[$i]['Category']=$key_explode[1];
			$arr[$i]['SubCategoryId']=$key_explode[2];
			$arr[$i]['SubCategory']=$key_explode[3];
			$arr[$i]['adcount']=$_val_cat_subcat;
			$i++;
		}
		return $arr;
	}
	function get_category_type($catid){		
		$query = $this->db->query('SELECT zoneassigntype from category where id='.$catid);		
    	return $query->result_array();
	}
	function get_category_name($catid){
		$query = $this->db->query('SELECT id,name from category_new where id='.$catid);		
    	return $query->result_array();
	}
	
	function get_category_subcategory_details($zone){
		$a=array();
		$query = $this->db->query("SELECT b.id,b.name FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid=".$zone." AND approval IN(1,2) GROUP BY b.id");
		$result[0] = $query->result_array() ;		
		$allbusinessids = '' ;
		for($j=0;$j<count($result[0]);$j++)
			$allbusinessids .= $result[0][$j]['id']."," ;
		if($allbusinessids != '') $allbusinessids = substr($allbusinessids,0,strlen($allbusinessids)-1) ;
			$a = $allbusinessids ;
			
		$sql="SELECT c.id as CategoryId,c.name as Category FROM category_display a,category c  WHERE a.catid=c.id AND a.zoneid=".$zone." AND c.status=1 AND c.id!=30 order by c.name asc";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		
		for($i=0;$i<count($result);$i++){
			$sql_inner="SELECT d.id as SubCategoryId,d.name as SubCategory FROM subcategory_display b,category_subcategory d WHERE   b.subcatid=d.id AND b.zoneid=".$zone."  AND b.catid=".$result[$i]['CategoryId']." order by d.name asc";
			$query_inner=$this->db->query($sql_inner);
			$result_inner=$query_inner->result_array();			
			$arr_subcat=array();
			$j=0;	
			foreach($result_inner as $_x){
				if($a!=''){
				$sql_ad_count="SELECT count(b.id) as count_ad from ad_to_zone a,ads b,business c WHERE a.adid=b.id AND b.business_id=c.id AND a.zoneid=".$zone." AND c.id IN(".$a.") and subcategoryid=".$_x['SubCategoryId']." and categoryid=".$result[$i]['CategoryId'];
				$query_inner_1=$this->db->query($sql_ad_count);
				$result_inner_1=$query_inner_1->result_array();				
				$ad_count = $result_inner_1[0]['count_ad'] ;
				if($ad_count==0){
					$ad_count='(0)';
				}else
					$ad_count='('.$ad_count.')';
				$result[$i]['subcatinfo'][$_x['SubCategoryId']]=$_x['SubCategory'].''.$ad_count;
				}
			}
			
		}
		
		
		return $result;	
	}
	
	function get_category_subcategory_details_for_food($zone){
		$a=array();
		$query = $this->db->query("SELECT b.id,b.name FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid=".$zone." AND approval IN(1,2) GROUP BY b.id");
		$result[0] = $query->result_array() ;		
		$allbusinessids = '' ;
		for($j=0;$j<count($result[0]);$j++)
			$allbusinessids .= $result[0][$j]['id']."," ;
		if($allbusinessids != '') $allbusinessids = substr($allbusinessids,0,strlen($allbusinessids)-1) ;
			$a = $allbusinessids ;
			
		$sql="SELECT c.id as CategoryId,c.name as Category FROM category_display a,category c  WHERE a.catid=c.id AND a.zoneid=".$zone." AND c.status=1 AND c.id=30 order by c.name asc";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		
		for($i=0;$i<count($result);$i++){
			$sql_inner="SELECT d.id as SubCategoryId,d.name as SubCategory FROM subcategory_display b,category_subcategory d WHERE   b.subcatid=d.id AND b.zoneid=".$zone."  AND b.catid=".$result[$i]['CategoryId']." order by d.name asc";
			$query_inner=$this->db->query($sql_inner);
			$result_inner=$query_inner->result_array();			
			$arr_subcat=array();
			$j=0;	
			foreach($result_inner as $_x){
				if($a!=''){
				$sql_ad_count="SELECT count(b.id) as count_ad from ad_to_zone a,ads b,business c WHERE a.adid=b.id AND b.business_id=c.id AND a.zoneid=".$zone." AND c.id IN(".$a.") and subcategoryid=".$_x['SubCategoryId']." and categoryid=".$result[$i]['CategoryId'];
				$query_inner_1=$this->db->query($sql_ad_count);
				$result_inner_1=$query_inner_1->result_array();				
				$ad_count = $result_inner_1[0]['count_ad'] ;
				if($ad_count==0){
					$ad_count='(0)';
				}else
					$ad_count='('.$ad_count.')';
				$result[$i]['subcatinfo'][$_x['SubCategoryId']]=$_x['SubCategory'].''.$ad_count;
				}
			}
			
		}
		return $result;	
	}
		
	function get_all_subcategory_in_a_main_category($catId, $zone){
		$sql="SELECT d.id as SubCategoryId,d.name as SubCategory FROM subcategory_display b,category_subcategory d WHERE   b.subcatid=d.id AND b.zoneid=".$zone."  AND b.catid=".$catId." order by d.name asc";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	function add_category_this_zone($catid,$zoneid){
		$this->db->where('zoneid',$zoneid);
		$this->db->where('type',1);	
		$this->db->delete('category_display');
		if($catid!=''){			
			$explode_value=explode(',',$catid);
			for($i=0;$i<count($explode_value);$i++){
				$val[$i]=$explode_value[$i];
				$data=array('catid'=>$val[$i],'zoneid'=>$zoneid,'type'=>1);
				$this->db->insert('category_display', $data);					
			}
		}
	}
	function add_category_all_zone($catid,$zoneid){	
		$explode_value_zone=explode(',',$zoneid);
		for($i=0;$i<count($explode_value_zone);$i++){
			$val_zone[$i]=$explode_value_zone[$i];
			$this->db->where('zoneid',$val_zone[$i]);
			$this->db->where('type',2);			
			$this->db->delete('category_display');
		}
		if($catid!=''){ 
			for($i=0;$i<count($explode_value_zone);$i++){
				$explode_value_cat=explode(',',$catid);
				$val_zone[$i]=$explode_value_zone[$i];
				for($j=0;$j<count($explode_value_cat);$j++){
					$val_cat[$j]=$explode_value_cat[$j];
					$data=array('catid'=>$val_cat[$j],'zoneid'=>$val_zone[$i],'type'=>2); 
					$this->db->insert('category_display', $data);
				}
			}
		}
	}
	
	function save_cat_subcat_all_my_zone($users_all_zone){ 
		$users_all_zone_arr=explode(",",$users_all_zone);
		// for select category start
		$sql="select * from category_display where zoneid IN(".$users_all_zone.")";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		// for select category end
		// for select subcategory start
		$sql_subcat="select * from subcategory_display where zoneid IN(".$users_all_zone.")";
		$query_subcat=$this->db->query($sql_subcat);
		$result_subcat=$query_subcat->result_array();
		// for select subcategory end
		// for delete category start
		for($i=0;$i<count($result);$i++){			
			$this->db->where('id', $result[$i]['id']); 
        	$this->db->delete('category_display');
		} // for delete category end
		// for delete subcategory start
		for($i=0;$i<count($result_subcat);$i++){			
			$this->db->where('id', $result_subcat[$i]['id']); 
        	$this->db->delete('subcategory_display');
		} // for delete subcategory end
		// insert category_display table start
		for($i=0; $i<count($users_all_zone_arr); $i++){
			for($j=0;$j<count($result);$j++){
				$sql_sel="select * from category_display where catid=".$result[$j]['catid']." and zoneid=".$users_all_zone_arr[$i];
				$query_sel=$this->db->query($sql_sel);
				$result_sel = $query_sel->num_rows();
				if($result_sel < 1){
					$newdata['catid'] = $result[$j]['catid'];
					$newdata['zoneid'] = $users_all_zone_arr[$i];
					$this->db->insert('category_display', $newdata);
				}
			}
		} // insert category_display table end
		// insert subcategory_display table start
		for($i=0; $i<count($users_all_zone_arr); $i++){
			for($j=0;$j<count($result_subcat);$j++){
				$sql_sel_subcat="select * from subcategory_display where subcatid=".$result_subcat[$j]['subcatid']." and catid=".$result_subcat[$j]['catid']." and zoneid=".$users_all_zone_arr[$i];
				$query_sel_subcat=$this->db->query($sql_sel_subcat);
				$result_sel_subcat = $query_sel_subcat->num_rows();
				if($result_sel_subcat < 1){
					$newdata1['subcatid'] = $result_subcat[$j]['subcatid'];
					$newdata1['catid'] = $result_subcat[$j]['catid'];
					$newdata1['zoneid'] = $users_all_zone_arr[$i];
					$this->db->insert('subcategory_display', $newdata1);
				}
			}
		}// insert subcategory_display table end
		//return $result;		
	}
	function get_category_subcategory_food_sample_layout(){
		$sql="SELECT a.id as CategoryId,a.name as Category,b.id as SubCategoryId,b.name as SubCategory FROM category a,category_subcategory b WHERE a.id=b.catid and a.status=1 and a.id=30 order by a.name asc,b.name asc";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		$arr1=array();
		foreach($result as $_val_cat_subcat){
			$str1='';
			$str1=stripslashes($_val_cat_subcat['CategoryId'].'~!~'.$_val_cat_subcat['Category'].'~!~'.$_val_cat_subcat['SubCategoryId'].'~!~'.$_val_cat_subcat['SubCategory']);
			$arr1[$str1]=0;
		}
		$i=0; $arr=array();
			foreach($arr1 as $key=>$_val_cat_subcat){
				$key_explode=explode('~!~',$key);
				$arr[$i]['CategoryId']=$key_explode[0];
				$arr[$i]['Category']=$key_explode[1];
				$arr[$i]['SubCategoryId']=$key_explode[2];
				$arr[$i]['SubCategory']=$key_explode[3];
				$arr[$i]['adcount']=$_val_cat_subcat;
				$i++;
			}
			return $arr;
	}
	function get_category_subcategory_food_sample_layout_old(){
		$sql="select * from category where id=30 and zoneid=0";
		
		//echo $sql;
		$query = $this->db->query($sql);
		$result=$query->result_array();
		$count=0;
		foreach($result as $val){
			$sql_inner="select id as subcatid,name as subcatname from category_subcategory where catid=".$val['id'];
			$query_inner = $this->db->query($sql_inner);
			$result_inner=$query_inner->result_array();
			foreach($result_inner as $key_1=>$val_1){
				$result_final[$count]['CategoryId']=$val['id'];
				$result_final[$count]['Category']=$val['name'];
				$result_final[$count]['SubCategoryId']=$val_1['subcatid'];
				$result_final[$count]['SubCategory']=$val_1['subcatname'];
				$count++;
			}
		}
		return $result_final ;
	}
	function get_category_subcategory_sample_layout(){
		$sql="SELECT a.id as CategoryId,a.name as Category,b.id as SubCategoryId,b.name as SubCategory FROM category a,category_subcategory b WHERE a.id=b.catid and a.status=1 and a.id NOT IN(30,-99) order by a.name asc,b.name asc";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		$arr1=array();
		foreach($result as $_val_cat_subcat){
			$str1='';
			$str1=stripslashes($_val_cat_subcat['CategoryId'].'~!~'.$_val_cat_subcat['Category'].'~!~'.$_val_cat_subcat['SubCategoryId'].'~!~'.$_val_cat_subcat['SubCategory']);
			$arr1[$str1]=0;
		}
		$i=0; $arr=array();
			foreach($arr1 as $key=>$_val_cat_subcat){
				$key_explode=explode('~!~',$key);
				$arr[$i]['CategoryId']=$key_explode[0];
				$arr[$i]['Category']=$key_explode[1];
				$arr[$i]['SubCategoryId']=$key_explode[2];
				$arr[$i]['SubCategory']=$key_explode[3];
				$arr[$i]['adcount']=0;
				$i++;
			}
			return $arr;
	}
	function get_category_subcategory_sample_layout_old(){ 
		$sql="select * from category where id NOT IN(30,-99) and zoneid=0 order by name asc";
		$query = $this->db->query($sql);
		$result=$query->result_array();
		$count=0;
		foreach($result as $val){
			$sql_inner="select id as subcatid,name as subcatname from category_subcategory where catid=".$val['id'];
			$query_inner = $this->db->query($sql_inner);
			$result_inner=$query_inner->result_array();
			foreach($result_inner as $key_1=>$val_1){
				$result_final[$count]['CategoryId']=$val['id'];
				$result_final[$count]['Category']=$val['name'];
				$result_final[$count]['SubCategoryId']=$val_1['subcatid'];
				$result_final[$count]['SubCategory']=$val_1['subcatname'];
				$count++;
			}
		}
		return $result_final ;
	}
	
	function get_category_listed_business($zoneid=0,$param=''){
		/*if($param=='my_business'){
			$where=" and b.id!='-99'";
		}else{
			$where='';
		}*/
		$sql="select b.id,b.name from category_display a,category b where a.catid=b.id and a.zoneid=".$zoneid." order by b.name asc";
		$query= $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	function get_subcategory_listed_business($zoneid){
		$sql="select b.id,b.name from subcategory_display a,category_subcategory b where a.subcatid=b.id and a.zoneid=".$zoneid;
		$query= $this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	function get_listed_business_subcat($catid,$zoneid){
		
		$sql1='SELECT b.id,b.name from subcategory_display a,category_subcategory b where a.subcatid=b.id and a.catid=b.catid and a.catid='.$catid.' and a.zoneid='.$zoneid.' and b.status=1 order by b.name asc';
		$query1=$this->db->query($sql1);
		$result=$query1->result_array();
		return $result; 
	}
	
	function update_zone_menu($zoneid=0){
		$sql_1="SELECT count(id) AS id FROM zone_menu WHERE zoneid=$zoneid GROUP BY zoneid";
		$query_1=$this->db->query($sql_1);		
		$sql="SELECT COUNT(a.id) AS id FROM category_display AS a 
		      INNER JOIN subcategory_display AS b ON a.catid=b.catid AND a.zoneid=b.zoneid AND a.zoneid=$zoneid GROUP BY a.zoneid";	    	
		$query=$this->db->query($sql);
		$result = $query->getResultArray();
		$result1 = $query_1->getResultArray();
		if(count($result) > 0){
			if(count($result1) == 0){
				$data = array('zoneid'=>$zoneid,'status' => 1);
				$this->CommonController->InsertData('zone_menu', $data);
			}else{
				$data = ['status' => 1];
				$builder = $this->db->table('zone_menu');
				$builder->where('zoneid', $zoneid);	
			}
		}else{
			$this->CommonController->deleteData('zone_menu',['zoneid' =>$zoneid]);
		} 
	}
	function zone_menu_store($var='',$zoneid=0){ 
		$data1 = array('menu'=>$var,'status'=>2);
		$this->db->where('zoneid', $zoneid);
		$this->db->update('zone_menu', $data1);
	}
	function check_menu_exist_or_not($zoneid=0){
		$sql="SELECT menu FROM zone_menu WHERE zoneid=$zoneid AND status=2";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		if(!empty($result)){
			return $result;
		}else{
			return 1;
		}
		
	}
	
	############################################################################
	
	
	function get_category_subcategory_food_sample_layout_working(){
		//$sql="SELECT a.id as CategoryId,a.name as Category,b.id as SubCategoryId,b.name as SubCategory FROM category a,category_subcategory b WHERE a.id=b.catid and a.status=1 and a.id=30 order by a.name asc,b.name asc";
		$sql="SELECT id as catid,name as catname,child_type FROM category_new order by name asc";
		$query = $this->db->query($sql);
		$result=$query->result_array(); var_dump($result);
		foreach($result as $_x){
			if($_x['child_type']=='y'){
				$sql_1="SELECT category_subcategory_new a,category_sub_subcategory_new b ";
			}else if($_x['child_type']=='n'){
			}
		}
		
		
		
		
		
		
		$arr1=array();
		foreach($result as $_val_cat_subcat){
			$str1='';
			$str1=stripslashes($_val_cat_subcat['CategoryId'].'~!~'.$_val_cat_subcat['Category'].'~!~'.$_val_cat_subcat['SubCategoryId'].'~!~'.$_val_cat_subcat['SubCategory']);
			$arr1[$str1]=0;
		}
		$i=0; $arr=array();
			foreach($arr1 as $key=>$_val_cat_subcat){
				$key_explode=explode('~!~',$key);
				$arr[$i]['CategoryId']=$key_explode[0];
				$arr[$i]['Category']=$key_explode[1];
				$arr[$i]['SubCategoryId']=$key_explode[2];
				$arr[$i]['SubCategory']=$key_explode[3];
				$arr[$i]['adcount']=$_val_cat_subcat;
				$i++;
			}
			return $arr;
	}
	
}
