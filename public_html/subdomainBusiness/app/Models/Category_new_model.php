<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\IonAuth;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Category_new_model extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->CommonController = new CommonController();
    } 
// add category, first subcategory in tha database

    function add_category_display($catid='',$zoneid=0){

		$arr_actionedcateids=explode(',',$catid);

		$arr_existingcategories=array();

		$this->db->select('catid');

		$this->db->where('zoneid',$zoneid); 

		$query1=$this->db->get('category_display');

		$result1=$query1->result();

		if(isset($result1)){

			$inc=0;

			foreach($result1 as $vresult1){

				$arr_existingcategories[$vresult1->catid]=$vresult1->catid;

				$inc++;

			}

		}		

		if(trim($catid)==''){

			$this->db->where_in('catid',$arr_existingcategories); 

			$this->db->where('zoneid',$zoneid);																																																																					        	$this->db->delete('category_display');//delete category	

			

			$this->db->where_in('catid',$arr_existingcategories); 

			$this->db->where('zoneid',$zoneid);						

			$this->db->delete('subcategory_display');//delete subcategory

		}else if(empty($arr_existingcategories) && !empty($arr_actionedcateids)){ // if category not present 			

			foreach($arr_actionedcateids as $v1){

				$data_subcat_arr=$this->fn_make_cat_subcat_for_zone($v1,$zoneid); 

				$data_arr=array('catid'=>$v1,'zoneid'=>$zoneid);

				$this->db->insert('category_display',$data_arr);

				$this->db->insert('subcategory_display',$data_subcat_arr);				

			}

		}else if(count($arr_existingcategories)!=count($arr_actionedcateids)){ // if category present 			

			$arrdiffdb2html=array_diff($arr_existingcategories,$arr_actionedcateids);

			$arrdiffhtml2db=array_diff($arr_actionedcateids,$arr_existingcategories);

			if(!empty($arrdiffdb2html)){

				//delete from database		

				foreach($arrdiffdb2html as $v1){

					$this->db->where('catid',$v1);

					$this->db->where('zoneid',$zoneid);																																																														$this->db->delete('category_display');//delete category					

					$this->db->where('catid',$v1);

					$this->db->where('zoneid',$zoneid);																																																														$this->db->delete('subcategory_display');//delete subcategory

				}

			}

			////////////

			if(!empty($arrdiffhtml2db)){

				//insert to database	

				foreach($arrdiffhtml2db as $v2){

					$data_subcat_arr=$this->fn_make_cat_subcat_for_zone($v2,$zoneid); 

					$data_arr=array('catid'=>$v2,'zoneid'=>$zoneid);

					$this->db->insert('category_display',$data_arr);

					$this->db->insert('subcategory_display',$data_subcat_arr);					

				}	

			}

			  

		}

	}

	// this function is call from another function

	function fn_make_cat_subcat_for_zone($catid,$zoneid,$from=''){

		$this->db->select('id,child_type');

		$this->db->where('id',$catid); 

		$sql=$this->db->get('category_new');

		$result=$sql->result_array();		

		if(isset($result)){

			if($result[0]['child_type']=='n'){

				$this->db->select('id');

				$array=array('parent_id'=>$result[0]['id'],'parent_type'=>'c');

				$this->db->where($array);

				$this->db->order_by("name", "asc");

				if($from=='')

				$this->db->limit(1);  

				$sql_1=$this->db->get('category_sub_subcategory_new');

				$result_1=$sql_1->result_array();

				$data_subcat_arr=array('subcatid'=>$result_1[0]['id'],'catid'=>$catid,'zoneid'=>$zoneid);

			}else if($result[0]['child_type']=='y'){

				 //$sql_2="SELECT b.id FROM category_subcategory_new a,category_sub_subcategory_new b WHERE a.id=b.parent_id and a.catid=".$result[0]['id']." and b.parent_id=".$result[0]['id']." and b.parent_type='s' order by b.name asc limit 1";

				 $sql_2="SELECT b.id FROM category_subcategory_new a,category_sub_subcategory_new b WHERE a.id=b.parent_id and a.catid=".$result[0]['id']." and  b.parent_type='s' order by b.name asc limit 1";							

				$query_2 = $this->db->query($sql_2);

				$result_2=$query_2->result_array();

				$data_subcat_arr=array('subcatid'=>$result_2[0]['id'],'catid'=>$catid,'zoneid'=>$zoneid);

			}

		}

		return $data_subcat_arr; 

	}

	// add subcategory in a specific category

	function add_sub_category_display($catid=0,$zoneid=0,$subcatid=''){

		$arr_actionedcateids=explode(',',$subcatid);  

		$arr_existingcategories=array();

		$this->db->select('subcatid');

		$this->db->where('zoneid',$zoneid);

		$this->db->where('catid',$catid);  

		$query1=$this->db->get('subcategory_display');

		$result1=$query1->result();

		if(isset($result1)){

			$inc=0;

			foreach($result1 as $vresult1){

				$arr_existingcategories[$vresult1->subcatid]=$vresult1->subcatid;

				$inc++;

			}

		}

		if(trim($subcatid)==''){ 

			$this->db->where_in('subcatid',$arr_existingcategories);

			$this->db->where('catid',$catid);

			$this->db->where('zoneid',$zoneid);																																																																					        	$this->db->delete('subcategory_display');//delete subcategory

		}else if(empty($arr_existingcategories) && !empty($arr_actionedcateids)){ // if subcategory not present

			foreach($arr_actionedcateids as $v1){

				$data_arr=array('subcatid'=>$v1,'catid'=>$catid,'zoneid'=>$zoneid); 

				$this->db->insert('subcategory_display',$data_arr);				

			} 

		}else if(count($arr_existingcategories)!=count($arr_actionedcateids)){ // if subcategory present

			$arrdiffdb2html=array_diff($arr_existingcategories,$arr_actionedcateids);

			$arrdiffhtml2db=array_diff($arr_actionedcateids,$arr_existingcategories);

			if(!empty($arrdiffdb2html)){

				//delete from database		

				foreach($arrdiffdb2html as $v1){									

					$this->db->where('subcatid',$v1);

					$this->db->where('catid',$catid);

					$this->db->where('zoneid',$zoneid);																																																																					        			$this->db->delete('subcategory_display');//delete subcategory

				}

			}

			////////////

			if(!empty($arrdiffhtml2db)){

				//insert to database	

				foreach($arrdiffhtml2db as $v2){

					$data_arr=array('subcatid'=>$v2,'catid'=>$catid,'zoneid'=>$zoneid); 

					$this->db->insert('subcategory_display',$data_arr);				

				}	

			}

		}

	}

	

	#############################################

	// display Food Category for Sample Layout start 

	function display_food_category(){

		$this->db->select('id,child_type,name');

		$this->db->where('id',1); 

		$this->db->where('status',1);

		$sql=$this->db->get('category_new');

		$result=$sql->result_array();

		foreach($result as $_x){

			if($_x['child_type']=='y'){								

				$sql="SELECT a.name as subcat_name,b.* FROM category_subcategory_new a,category_sub_subcategory_new b WHERE a.id=b.parent_id  and b.parent_type='s' and a.catid=".$_x['id'];

				$query = $this->db->query($sql);

				$result=$query->result_array();

				$i=0; 

				foreach($result as $k=>$subcat){

					/*$arr[$subcat['parent_id']]['name']=$subcat['subcat_name'];

					$arr[$subcat['parent_id']][$subcat['id']]['name']=$subcat['name'];*/

					$arr[$_x['name']][$subcat['subcat_name']][$i++]=$subcat['name'];

					//$arr[$subcat['parent_id']][$subcat['id']]['name']=$subcat['name'];

					//$i++;

					/*$arr[$i]['CategoryId']=$_x['id'];

					$arr[$i]['Category']=$_x['name'];

					$arr[$i]['CategoryType']=$subcat['subcat_name'];

					$arr[$i]['SubCategoryId']=$subcat['id'];

					$arr[$i]['SubCategory']=$subcat['name'];

					$i++;*/

				}

			}

		}		

		return $arr;

	}

	// display Product & Services Category for Sample Layout start

	 function display_product_category(){

		$this->db->select('id,child_type,name');

		$this->db->where_not_in('id','1,14,-99'); 

		$this->db->where('status',1);

		$sql=$this->db->get('category_new');

		$result=$sql->result_array();

		foreach($result as $_x){

			if($_x['child_type']=='y'){								

				$sql="SELECT a.name as subcat_name,b.* FROM category_subcategory_new a,category_sub_subcategory_new b WHERE a.id=b.parent_id  and b.parent_type='s' and a.catid=".$_x['id'];

				$query = $this->db->query($sql);

				$result=$query->result_array();

				$i=0; 

				foreach($result as $k=>$subcat){

					/*$arr[$subcat['parent_id']]['name']=$subcat['subcat_name'];

					$arr[$subcat['parent_id']][$subcat['id']]['name']=$subcat['name'];*/

					$arr[$_x['name']][$subcat['subcat_name']][$i++]=$subcat['name'];

					//$arr[$subcat['parent_id']][$subcat['id']]['name']=$subcat['name'];

					//$i++;

					/*$arr[$i]['CategoryId']=$_x['id'];

					$arr[$i]['Category']=$_x['name'];

					$arr[$i]['CategoryType']=$subcat['subcat_name'];

					$arr[$i]['SubCategoryId']=$subcat['id'];

					$arr[$i]['SubCategory']=$subcat['name'];

					$i++;*/

				}

			}

		}		

		return $arr;

	}

	

	##########################################################################

	// for zone dashboard

	function get_all_categories_zone($zoneid=false,$from='',$group_id = 0){ 

		return $this->fn_get_all_categories($zoneid,$from,'',$group_id);

	}

	public function get_all_categories_zone_create_business($biz_mode=0,$biz_type=1,$zoneid=0,$from='',$groupid=0,$business_is_restaurant=0){
		$wh=''; $category='';		
		if($biz_mode==2){ $category=" and a.catid =14"; }else{ $category=" and a.catid !=14";}

		if($business_is_restaurant==1){ $business_is_restaurant=" and a.catid =1"; }else{ $business_is_restaurant=" and a.catid !=1"; }

		if($biz_type == 3 ){ $wh=" and a.catid='-99'"; }else{ $wh=" and a.catid!='-99'"; }
		
		$sql="SELECT b.id,b.name from category_display a,category_new b where a.catid=b.id and a.zoneid IN(".$zoneid.")". $wh.$category.$business_is_restaurant." group by b.id order by b.name asc";
		$result = $this->CommonController->SelectRawquery($sql,'resultArray');
		$result=!empty($result) ? $result : '';
		return $result;
	}

	##########################################################################

	// for Business Dashboard

	public function get_all_categories_business($id=false,$from='',$businesstype='',$busmode='',$catid=''){ 
		$sql="select group_concat(settingszoneid) as zoneid from ads_setting_preferences where businessid=".$id." AND isdefault IN(0,1)";
		$result1 = $this->CommonController->SelectRawquery($sql,'resultArray');
		if(!empty($result1)){
			$allzoneids= $result1[0]['zoneid'];
			return $this->fn_get_all_categories($allzoneids,$from,$businesstype,$busmode,'',$catid); 
		}		
	}

	

	// get sub categories againest a category
	public function get_all_subcategories_zone($catid=false,$zoneid=false,$from=''){ //var_dump($catid);
		if($from=='create_business'){
			$arr=$this->fn_get_subcat_against_cat($catid,$zoneid);
		}else{
			$arr=array();
			foreach($catid as $val){		
				$arr[]=$this->fn_get_subcat_against_cat($val,$zoneid); 
			}
		}
		return $arr;
	}

	// get sub categories againest a category

	function get_all_subcategories_zone_sorted($catid=false,$zoneid=false,$from=''){

		

		if($from=='create_business'){

			$arr=$this->fn_get_subcat_against_cat_sorted($catid,$zoneid);

		}else{

			$arr=array();

			foreach($catid as $val){		

				$arr[]=$this->fn_get_subcat_against_cat_sorted($val,$zoneid);

					

			}

		}

		return $arr;

	}	
	
	public function fn_get_subcat_against_cat($catid='',$zoneid=''){
		$result = $this->CommonController->SelectDataMultiWay('category_new','id,child_type,name','resultArray',['id'=> $catid]);
		
		if(isset($result)){
			if($result[0]['child_type']=='y'){
				$sql_2="SELECT b.id,b.name,c.id as group_id,c.name as group_name FROM subcategory_display a,category_sub_subcategory_new b, category_subcategory_new c WHERE a.subcatid=b.id and b.parent_id=c.id and a.catid=".$catid." and a.zoneid=".$zoneid." and b.parent_type='s' and c.catid=".$catid." order by b.name asc"; 													
			}else if($result[0]['child_type']=='n'){
				$sql_2="SELECT b.id,b.name FROM subcategory_display a,category_sub_subcategory_new b WHERE a.subcatid=b.id and a.catid=b.parent_id and a.catid=".$catid." and a.zoneid=".$zoneid." and b.parent_type='c' order by b.name asc"; 
			}
			
			$result_2 = $this->CommonController->SelectRawquery($sql_2, 'resultArray');
			$i=0; 
			
			foreach($result_2 as $k=>$subcat){
				if($result[0]['child_type']=='y'){
					$final_arr[$result[0]['id']][$result[0]['name']][$subcat['group_name'].'###'.$subcat['group_id']][$subcat['id']]=$subcat['name'];
				}else if($result[0]['child_type']=='n'){
					$final_arr[$result[0]['id']][$result[0]['name']][-100][$subcat['id']]=$subcat['name'];
				}
			}	
			return $final_arr;
		}
	}

	// new function added on

	//////////

	// save category, subcategory in a add from dashboard
	public function ads_save_cat_subcat($adid=0,$category_id='',$subcategory_id='',$zoneid=0,$where_from='',$business_id = 0,$demo='',$showreservation=0,$showmenutab=0){
		$this->CommonController->deleteData('ad_category_subcategory',['adid'=> $adid,'zoneid'=> $zoneid]);
		$foodtypeArr = ['885','2','888','3','4','5','7','15'];
		$typeserviceArr = ['35','38','40','41'];
		$ethnicityArr = ['44','45','49','883','22'];
		if(!is_array($subcategory_id)){
			$subcategory_id = explode(',',$subcategory_id);
		}
		foreach($subcategory_id as $_x){
			if(in_array($_x, $foodtypeArr)){
				$cat_group_id = 1;
			}
			if(in_array($_x, $typeserviceArr)){
				$cat_group_id = 2;
			}
			if(in_array($_x, $ethnicityArr)){
				$cat_group_id = 3;
			}
			$data=array('adid'=>$adid,'catid'=>$category_id,'cat_group_id'=>$cat_group_id,'subcatid'=>$_x,'zoneid'=>$zoneid,'display_zone'=>1,'reservation_status'=>$showreservation,'menutab_status' =>$showmenutab); 

			$this->CommonController->InsertData('ad_category_subcategory', $data);

			$data1=array('adid'=>$adid,'catid'=>$category_id,'subcatid'=>$_x,'zoneid'=>$zoneid,'display_order'=>1); 
			$this->CommonController->InsertData('business_sponsor_order_cat', $data1);
		}
		
		if(in_array("-99!@#0!@#-99",$subcategory_id)){
			$data_ads = array('categoryid' =>-99,'subcategoryid' =>-99);
			$this->CommonController->updateData('ads',$data_ads,['id' =>$adid]);
		}else{
			$data_ads = array('categoryid' =>0,'subcategoryid' =>0);
			$this->CommonController->updateData('ads',$data_ads,['id' =>$adid]);
		}
	}
	
	public function ads_save_approval($adid=0,$category_id='',$subcategory_id='',$zoneid=0,$where_from='',$business_id = 0){ 
		$subcategory_id_arr=explode(',',$subcategory_id); 
		$userselected = $existinanother = array();
		$isactive = 0;
		$cat_subcat_exist_ad = "select a.subcatid,a.adid from ad_category_subcategory a,ad_to_zone b, ads c where  a.adid=b.adid and b.approval='1' and a.adid=c.id and  a.adid NOT IN($adid) and c.business_id='$business_id'";

		$cat_subcat_ad = $this->CommonController->SelectRawquery($cat_subcat_exist_ad, 'resultArray');
		foreach($cat_subcat_ad as $val){
			$existinanother[] = $val['subcatid'];
		}
		foreach($subcategory_id_arr as $_x){	
			$a=explode('!@#',$_x);
			$subcatid = $_x; 
			// $subcatid = $a['2']; 
			if(in_array($subcatid,$existinanother)){
				$isactive = 1 ;
			}
		} 	

		$ad_approval_result = $this->CommonController->SelectDataMultiWay('ad_to_zone','approval','resultArray',['adid'=>$adid],[],'',[]);
		$approval = $ad_approval_result['0']['approval'];

		if($isactive == 1 && $approval == -1){
			$update_ad_approval = array('approval' => 1);  
			// $update_ad_approval = array('approval' => -1);  
			$this->CommonController->updateData('ad_to_zone',$update_ad_approval,['adid'=>$adid]);
		} else if($isactive == 0 && $approval == -1){
			// $update_ad_approval = array('approval' => -1);  
			$update_ad_approval = array('approval' => 1);  
			$this->CommonController->updateData('ad_to_zone',$update_ad_approval,['adid'=>$adid]);
		} else if($isactive == 1 && $approval == 1){
			$update_ad_approval = array('approval' => 1);  
			// $update_ad_approval = array('approval' => -1);  
			$this->CommonController->updateData('ad_to_zone',$update_ad_approval,['adid'=>$adid]);
		} else if($isactive == 0 && $approval == 1){
			$update_ad_approval = array('approval' => 1);  
			$this->CommonController->updateData('ad_to_zone',$update_ad_approval,['adid'=>$adid]);
		}
	}

	

	function get_all_categories_zone_anish($zoneid){

		$wh=" and a.catid!='-99'";

		$wh.=" and a.catid!='14'";

		$sql1="SELECT b.id,b.name from category_display a,category_new b where a.catid=b.id and a.zoneid IN(".$zoneid.")". $wh." group by b.id order by b.name asc";

		$query1=$this->db->query($sql1);

		//echo $this->db->last_query(); exit;

		$result=$query1->result_array();

		$result=!empty($result) ? $result : '';

		return $result;

	}

	################################################ this call from another functions        ###############################################
	public function fn_get_all_categories($allzoneids=0,$from='',$businesstype='',$busmode='',$group_id=0,$catid=''){
		$wh=''; $category='';
		if($allzoneids!=0){
			if($from=='business'){  
				if($busmode==1){
					if($businesstype != 3 && $businesstype != -3 ){ //echo 2; active upload ->coming soon
						if($catid != -99 ){ 
							$wh=" and a.catid!='-99'";
							$wh.=" and a.catid!='14'";
						}else{
							$wh.=" and a.catid!='14'";
						}
					}else{                
						$wh=" and a.catid!='-99'";
						$wh.=" and a.catid!='14'";
					}
					$category=" and a.catid =1";
				}else{                                 
					$wh =" and a.catid NOT IN(1,14,-99)";
				}
			}
			
			if($group_id==5){
				$category=" and a.catid !=14";
			}else if($group_id==13){ 
				$category=" and a.catid =14";
			}
			
			$sql1="SELECT b.id,b.name from category_display a,category_new b where a.catid=b.id and a.zoneid IN(".$allzoneids.")". $wh.$category." group by b.id order by b.name asc"; 
			$result = $this->CommonController->SelectRawquery($sql1,'resultArray');
		}
		$result=!empty($result) ? $result : '';
		return $result;
	}

	#############################################################################################
	// old function in business search page
	public function get_products_details($zoneid=0,$id=0, $type = '', $subcatselect= ''){
	    $wh_cond = $subcat_id = '';
	    $urlsubcatidArr = [];
	    $urlcatidArr = [];
		$arr= array();
		if($zoneid!=0){
			if($type == 'ads'){
				$cond=" and catid='".$id."'";
			}else if($subcatselect == 'subcatselect'){
				$cond=" and catid='".$id."'";
			}else{
				if($id==1){
					$cond=" and catid=1";
				}else if($id==14){
					$cond=" and catid=14";
				}else{
					$cond=" and catid NOT IN(1,14,-99)";
				}
			}
			$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;
			$sql="SELECT group_concat(catid) as catid FROM category_display  WHERE zoneid=".$zoneid." ".$cond; 
			$query = $this->db->query($sql);
			$result=$query->getResultArray();		
			if(!empty($result)){
				$allcatids_str= $result[0]['catid'];
			}
			if($allcatids_str != ''){
				$allcatids=explode(',',$allcatids_str);
				
			}else{
				$allcatids='';
			}

			$wh_in_arr=array();
			$wh_in_arr=$allcatids;
			if($wh_in_arr != ''){
				$result = $this->CommonController->SelectDataMultiWay('category_new','id,child_type,name,attachment_image','ArrayIn',array("status"=> 1),array('column' =>"id",'param' => $wh_in_arr));

				foreach($result as $_x){
                $_x['attachment_image'] =  $_x['attachment_image'];
				if($_x['child_type']=='y'){
					$wh_cond=" group by b.name order by b.name asc";
					$sql="SELECT a.id as subcat_id,a.name as subcat_name,b.*,c.zoneid as newzoneid FROM category_subcategory_new as a,category_sub_subcategory_new as b, subcategory_display as c WHERE a.id=b.parent_id and b.id=c.subcatid and a.catid=c.catid and b.parent_type='s' and a.catid=".$_x['id']." and c.zoneid=".$zoneid.$wh_cond;
					$result = $this->CommonController->SelectRawquery($sql);
					$i=0; 
					foreach($result as $k=>$subcat){
						$sql_adcount="SELECT count(distinct a.adid) AS adcount,a.subcatid from ad_category_subcategory a, ads b, ads_setting_preferences c, ad_to_zone z  where z.adid = a.adid AND a.adid = b.id AND b.business_id = c.businessid AND c.approval IN(1,2) AND a.catid=".$_x['id']." and a.zoneid=".$zoneid." and a.subcatid=".$subcat['id']." and a.display_zone=1 and z.approval=1 GROUP BY a.subcatid";
						$result_adcount = $this->CommonController->SelectRawquery($sql_adcount);
						if(!empty($result_adcount)){
							if($result_adcount[0]['adcount']==0){
								/*$adcount='[0]';*/
							}else{
								$adcount='['.$result_adcount[0]['adcount'].']';
								if(!empty($subcat['subcat_id'])){
									$subcat_id = $subcat['subcat_id'] ;
								}
								$arr[$_x['name'].'#'.$_x['id']][$i++]=$subcat['name'].'#'.$subcat['id'].'#'.$adcount.'#'.$subcat_id;
								$urlsubcatidArr[] = array('id'=>$subcat['id'],'name'=>$subcat['name'],'catname'=>$_x['name'],'catid'=>$_x['id']);
								$urlcatidArr[] = array('catname'=>$_x['name'],'catid'=>$_x['id']);
								// $arr[$_x['name'].'#'.$_x['id']][$subcat['subcat_name'].'#@#'.$subcat_id][$i++]=$subcat['name'].'#'.$subcat['id'].'#'.$adcount.'#'.$subcat_id;
								// $arr[$_x['name'].'#'.$_x['id']]['attachment_image']=   $_x['attachment_image'];
							}
						}
					}
					$arrres = [];
					$rest1 = '';
					foreach ($arr as $k1 => $v1) {
						$rest1 = $k1;
						if($k1 == 'Restaurants#1'){
							$sr = $ser = $ser1 = 0;
							$dd = [];
						foreach ($v1 as $k2 => $v2) {
							$sr++;
							if($sr <= 5){
								$dd['ethicity#@#'.$ser1][$ser] = $v2;
								$ser++;
							}
							if($sr == 5){
								$ser1++;
								$sr = 0;
							}
						}
						$newArrd[$k1] = $dd;
						}else{

						}
					}
					if($rest1 == 'Restaurants#1'){
						$arr = $newArrd;
					}
				}else if($_x['child_type']=='n'){
					$sql="SELECT a.* FROM category_sub_subcategory_new a, subcategory_display b WHERE a.id=b.subcatid and a.parent_id=b.catid  and a.parent_type='c' and a.parent_id=".$_x['id']." and b.zoneid=".$zoneid." order by a.name asc";
					$result = $this->CommonController->SelectRawquery($sql);
					$i=0; 
					foreach($result as $k=>$subcat){
						$sql_adcount="SELECT count(distinct a.adid) AS adcount,a.subcatid from ad_category_subcategory a , ad_to_zone z  where z.adid = a.adid and a.catid=".$_x['id']." and a.zoneid=".$zoneid." and a.subcatid=".$subcat['id']." and a.display_zone=1 and z.approval=1  GROUP BY subcatid";
						$result_adcount = $this->CommonController->SelectRawquery($sql_adcount);
						if(!empty($result_adcount)){
							if($result_adcount[0]['adcount']==0){
								/*$adcount='[0]';*/
							}else{
								$adcount='['.$result_adcount[0]['adcount'].']';
								$arr[$_x['name'].'#'.$_x['id']][-100][$i++]=$subcat['name'].'#'.$subcat['id'].'#'.$adcount;
								$urlsubcatidArr[] = array('id'=>$subcat['id'],'name'=>$subcat['name'],'catname'=>$_x['name'],'catid'=>$_x['id']);
								$urlcatidArr[] = array('catname'=>$_x['name'],'catid'=>$_x['id']);
		 						// $arr[$_x['name'].'#'.$_x['id']]['attachment_image']=   $_x['attachment_image'];
							}
						}
					}
				}
			}
		}
		if($type == 'ads'){
			return $urlsubcatidArr;
		}else if($type == 'catads'){
			return $urlcatidArr;
		}else{
			return $arr;			
		}
		}
	}

		function get_products_detailsbackup($zoneid=0,$id=0){
		$wh_cond = $subcat_id = '';
			$arr= array();
		if($zoneid!=0){
			if($id==1){
				$cond=" and catid=1";
			}else if($id==14){
				$cond=" and catid=14";
			}else{
				$cond=" and catid NOT IN(1,14,-99)";
			}
			
			$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;
			$sql="SELECT group_concat(catid) as catid FROM category_display  WHERE zoneid=".$zoneid." ".$cond; 
			$query = $this->db->query($sql);
			$result=$query->getResultArray();			
			if(!empty($result)){
				$allcatids_str= $result[0]['catid'];
			}
			if($allcatids_str != ''){
				$allcatids=explode(',',$allcatids_str);
			}else{
				$allcatids='';
			}
			$wh_in_arr=array();
			$wh_in_arr=$allcatids;
			echo "<pre>";print_r($wh_in_arr);die;
			
			$result = $this->CommonController->SelectDataMultiWay('category_new','id,child_type,name,attachment_image','ArrayIn',array("status"=> 1),array('column' =>"id",'param' => $wh_in_arr));
			
			foreach($result as $_x){
                $_x['attachment_image'] =  $_x['attachment_image'];
				if($_x['child_type']=='y'){
					$wh_cond=" group by b.name order by subcat_name asc,b.name asc";
					$sql="SELECT a.id as subcat_id,a.name as subcat_name,b.* FROM category_subcategory_new a,category_sub_subcategory_new b, subcategory_display c WHERE a.id=b.parent_id and b.id=c.subcatid and a.catid=c.catid and b.parent_type='s' and a.catid=".$_x['id']." and c.zoneid=".$zoneid.$wh_cond;
					$result = $this->CommonController->SelectRawquery($sql);
					$i=0; 
					
					foreach($result as $k=>$subcat){
						$sql_adcount="SELECT count(distinct a.adid) AS adcount,a.subcatid from ad_category_subcategory a, ads b, ads_setting_preferences c, ad_to_zone z  where z.adid = a.adid AND a.adid = b.id AND b.business_id = c.businessid AND c.approval IN(1,2) AND a.catid=".$_x['id']." and a.zoneid=".$zoneid." and a.subcatid=".$subcat['id']." and a.display_zone=1 and z.approval=1 GROUP BY a.subcatid";
						$result_adcount = $this->CommonController->SelectRawquery($sql_adcount);
						if(!empty($result_adcount)){
							if($result_adcount[0]['adcount']==0){
								/*$adcount='[0]';*/
							}else{
								$adcount='['.$result_adcount[0]['adcount'].']';
								if(!empty($subcat['subcat_id'])){
									$subcat_id = $subcat['subcat_id'] ;
								}
								$arr[$_x['name'].'#'.$_x['id']][$subcat['subcat_name'].'#@#'.$subcat_id][$i++]=$subcat['name'].'#'.$subcat['id'].'#'.$adcount.'#'.$subcat_id;
								// $arr[$_x['name'].'#'.$_x['id']]['attachment_image']=   $_x['attachment_image'];
							}
						}
					}
				}else if($_x['child_type']=='n'){
					$sql="SELECT a.* FROM category_sub_subcategory_new a, subcategory_display b WHERE a.id=b.subcatid and a.parent_id=b.catid  and a.parent_type='c' and a.parent_id=".$_x['id']." and b.zoneid=".$zoneid." order by a.name asc";
					$result = $this->CommonController->SelectRawquery($sql);
					$i=0; 
					foreach($result as $k=>$subcat){
						$sql_adcount="SELECT count(distinct a.adid) AS adcount,a.subcatid from ad_category_subcategory a , ad_to_zone z  where z.adid = a.adid and a.catid=".$_x['id']." and a.zoneid=".$zoneid." and a.subcatid=".$subcat['id']." and a.display_zone=1 and z.approval=1  GROUP BY subcatid";
						$result_adcount = $this->CommonController->SelectRawquery($sql_adcount);
						if(!empty($result_adcount)){
							if($result_adcount[0]['adcount']==0){
								/*$adcount='[0]';*/
							}else{
								$adcount='['.$result_adcount[0]['adcount'].']';
								$arr[$_x['name'].'#'.$_x['id']][-100][$i++]=$subcat['name'].'#'.$subcat['id'].'#'.$adcount;
		 						// $arr[$_x['name'].'#'.$_x['id']]['attachment_image']=   $_x['attachment_image'];
							}
						}
					}
				}
			}	
 			return $arr;			
		}
	}


	function get_products_details_selected($zoneid=0,$id=0){

	
 
		if($zoneid!=0){

			if($id==1){

				$cond=" and catid=1";

			}else if($id==14){

				$cond=" and catid=14";

			}else{

				$cond=" and catid NOT IN(1,14,-99) and catid =".$id;

			}

			$this->db->query("SET SESSION group_concat_max_len=10000000000000") ;

			# get all cat ids

			/*echo $sql="SELECT group_concat(a.catid) as catid FROM category_display a,subcategory_display b WHERE a.zoneid=b.zoneid AND a.catid=b.catid AND a.zoneid=".$zoneid." ".$cond; exit;*/

			$sql="SELECT group_concat(catid) as catid FROM category_display  WHERE zoneid=".$zoneid." ".$cond; 

			$query = $this->db->query($sql);

			$result=$query->result_array();			

			if(!empty($result)){

				$allcatids_str= $result[0]['catid'];

			}

			$allcatids=explode(',',$allcatids_str);

			$wh_in_arr=array();

			$wh_in_arr=$allcatids;

			$this->db->select('id,child_type,name,attachment_image');

			$this->db->where_in("id",$wh_in_arr); 

			$this->db->where('status',1);

			$sql=$this->db->get('category_new');

			$result=$sql->result_array();

		//	echo $this->db->last_query(); 

			// var_dump($result);


			 $wh_cond='';

			 $subcat_id = '';

			 $arr= array();

			foreach($result as $_x){
                  $_x['attachment_image'] =  $_x['attachment_image'];
				if($_x['child_type']=='y'){
					
                 
                 
					/*if($_x['id']==1){

						$wh_cond=" order by b.parent_id asc,b.name asc";

					}else{

						$wh_cond=" order by subcat_name asc,b.name asc";

					}*/

					$wh_cond=" group by b.name order by subcat_name asc,b.name asc";

					$sql="SELECT a.id as subcat_id,a.name as subcat_name,b.* FROM category_subcategory_new a,category_sub_subcategory_new b, subcategory_display c WHERE a.id=b.parent_id and b.id=c.subcatid and a.catid=c.catid and b.parent_type='s' and a.catid=".$_x['id']." and c.zoneid=".$zoneid.$wh_cond;

					$query = $this->db->query($sql);

					$result=$query->result_array();

					$i=0; 

					foreach($result as $k=>$subcat){ //var_dump($subcat); echo '<br>';

						$sql_adcount="SELECT count(distinct a.adid) AS adcount,a.subcatid from ad_category_subcategory a, ads b, ads_setting_preferences c  where a.adid = b.id AND b.business_id = c.businessid AND c.approval IN(1,2) AND a.catid=".$_x['id']." and a.zoneid=".$zoneid." and a.subcatid=".$subcat['id']." and a.display_zone=1  GROUP BY a.subcatid"; //echo '<br>'; echo '<br>';

						$query_adcount = $this->db->query($sql_adcount);

						$result_adcount=$query_adcount->result_array();						

						if(!empty($result_adcount)){

							if($result_adcount[0]['adcount']==0){

								/*$adcount='[0]';*/

							}else{

								$adcount='['.$result_adcount[0]['adcount'].']';

								if(!empty($subcat['subcat_id'])){

									$subcat_id = $subcat['subcat_id'] ;

								}

						

								$arr[$_x['name'].'#'.$_x['id']][$subcat['subcat_name'].'#@#'.$subcat_id][$i++]=$subcat['name'].'#'.$subcat['id'].'#'.$adcount.'#'.$subcat_id;

									$arr[$_x['name'].'#'.$_x['id']]['attachment_image']=   $_x['attachment_image'];
							

							}

						}else{

							/*$adcount='[0]';*/

						}

						

					}

				}else if($_x['child_type']=='n'){

					$sql="SELECT a.* FROM category_sub_subcategory_new a, subcategory_display b WHERE a.id=b.subcatid and a.parent_id=b.catid  and a.parent_type='c' and a.parent_id=".$_x['id']." and b.zoneid=".$zoneid." order by a.name asc";

					$query = $this->db->query($sql);

					$result=$query->result_array();					

					$i=0; 

					foreach($result as $k=>$subcat){

						$sql_adcount="SELECT count(distinct adid) AS adcount,subcatid from ad_category_subcategory where catid=".$_x['id']." and zoneid=".$zoneid." and subcatid=".$subcat['id']." and display_zone=1  GROUP BY subcatid";

						$query_adcount = $this->db->query($sql_adcount);

						$result_adcount=$query_adcount->result_array();

						if(!empty($result_adcount)){

							if($result_adcount[0]['adcount']==0){

								/*$adcount='[0]';*/

							}else{

								$adcount='['.$result_adcount[0]['adcount'].']';

		 						$arr[$_x['name'].'#'.$_x['id']][-100][$i++]=$subcat['name'].'#'.$subcat['id'].'#'.$adcount;
		 							$arr[$_x['name'].'#'.$_x['id']]['attachment_image']=   $_x['attachment_image'];

		 						//$arr[$_x['image'].'#'.$_x['id']][-100][$i++]=$_x['attachment_image'];


							}

						}else{

							/*$adcount='[0]';*/

						}

						/*$arr[$_x['name'].'#'.$_x['id']][-100][$i++]=$subcat['name'].'#'.$subcat['id'].'#'.$adcount;*/

					}

				}

			}	
 
			return $arr;			

		}

		

	}

	// Category, Subcategory name for directory 

	function display_cat_subcat_for_directory($adid=0,$zoneId=0){  

		$sql="SELECT catid,cat_group_id,subcatid FROM ad_category_subcategory WHERE adid=".$adid." AND zoneid=".$zoneId; 

		$query = $this->db->query($sql);

		$result=$query->result_array();

		$arr='';$cat_name=''; $cat_group_name=''; $subcat_name='';

		$catcommon = array();

		foreach($result as $result){ 

			

			if($result['catid']!=0){ // for Category name

				$sql_cat="SELECT name FROM category_new WHERE id=".$result['catid'];

				$query_cat = $this->db->query($sql_cat);

				$result_cat=$query_cat->result_array();

				$cat_name=$result_cat[0]['name'];

				

			}

			if($result['cat_group_id']!=0){ // for Category Group name

				$sql_cat_group="SELECT name FROM category_subcategory_new WHERE id=".$result['cat_group_id'];

				$query_cat_group = $this->db->query($sql_cat_group);

				$result_cat_group=$query_cat_group->result_array();

				$cat_group_name=$result_cat_group[0]['name'];

			}

			if($result['subcatid']!=0){ // for Subcategory name

				$sql_subcat="SELECT name FROM category_sub_subcategory_new WHERE id=".$result['subcatid'];

				$query_subcat = $this->db->query($sql_subcat);

				$result_subcat=$query_subcat->result_array();

				$subcat_name=$result_subcat[0]['name'];

			}

			

			if($cat_group_name!=''){

				$cat_string = $cat_name.':'.$cat_group_name ;

			if(in_array($cat_string,$catcommon)){

				//array_push($catcommon,$cat_string);

				$arr=$arr.', '.$subcat_name;  //var_dump($arr);exit;

			}else{

				$catcommon[] = $cat_name.':'.$cat_group_name ;//var_dump($catcommon);

				$arr=$arr.'  <span style="color:rgb(221, 190, 132);">'.$cat_name.'</span>: '.$cat_group_name.': '.$subcat_name;

			}

			}else{

				//$arr=$arr.''.$cat_name.':'.$subcat_name;

				$cat_string = $cat_name ;

			if(in_array($cat_string,$catcommon)){

				//array_push($catcommon,$cat_string);

				$arr=$arr.', '.$subcat_name;  //var_dump($arr);exit;

			}else{

				$catcommon[] = $cat_name;//var_dump($catcommon);

				$arr=$arr.'  <span style="color:rgb(221, 190, 132);">'.$cat_name.'</span>: '.$subcat_name;

			}

			}

			//var_dump($catcommon);exit;

		}

		//var_dump($catcommon);exit;

		//echo rtrim($arr, '='); 

		echo trim(trim($arr,' '), '; ');

		

	}

	function display_specific_cat_subcat_for_directory($subcatid=0){

		$cat_name='';

		if($subcatid!=0){

			$sql="SELECT name,parent_id,parent_type FROM category_sub_subcategory_new WHERE id=".$subcatid; 

			$query = $this->db->query($sql);

			$result=$query->result_array();

			if(!empty($result)){

				if($result[0]['parent_type']=='c'){

					$sql_cat="SELECT name FROM category_new WHERE id=".$result[0]['parent_id'];

					$query_cat = $this->db->query($sql_cat);

					$result_cat=$query_cat->result_array();

					$cat_name=' <span style="color:wheat">'.$result_cat[0]['name'].'</span>: '.$result[0]['name'];

				}else if($result[0]['parent_type']=='s'){

					$sql_cat="SELECT a.name as group_name,b.name as cat_name FROM category_subcategory_new a,category_new b WHERE a.catid=b.id and a.id=".$result[0]['parent_id'];

					$query_cat = $this->db->query($sql_cat);

					$result_cat=$query_cat->result_array();

					if(!empty($result_cat)){

						$cat_name=' <span style="color:wheat">'.$result_cat[0]['cat_name'].'</span>: '.$result_cat[0]['group_name'].': '.$result[0]['name'];

					}

				}

			}			

		}

		return $cat_name; 

	}

	function display_specific_cat_for_directory($cat_id=0){

		$cat_name='';

		if($cat_id!=0){

			$sql_cat="SELECT name FROM category_new WHERE id=".$cat_id;

			$query_cat = $this->db->query($sql_cat);

			$result_cat=$query_cat->result_array();

			$cat_name=' <span style="color:wheat">'.$result_cat[0]['name'].'</span>';

		}

		return $cat_name; 

	}

	

	function display_specific_subcatparentid_for_directory($subcatid=0){

		$cat_name='';

		if($subcatid!=0){

			$sql="SELECT name,catid FROM category_subcategory_new WHERE id=".$subcatid; 

			$query = $this->db->query($sql);

			$result=$query->result_array();

			$cat_name = 'By Industry & Start-up Cost : '.$result[0]['name'] ;			

		}

		return $cat_name; 

	}

	function get_cost_limit_details(){

	$sql="SELECT * from startup_cost_limit";

	$query=$this->db->query($sql);

	$result=$query->result_array();

	return $result;

	}

	function get_subcat_under_startupcost_limits($cost_limit=0){

		//$multisubcat_id='';

		if($cost_limit!=0){

			$sql="SELECT GROUP_CONCAT(subcat_id) as subcat_id FROM mapping_subcat_limits  WHERE limit_id =".$cost_limit;

			$query = $this->db->query($sql);

			$result=$query->result_array();

		}

		return ($result['0']["subcat_id"]) ; 

	}
	
	public function get_category_subcategory($adid=0,$zoneid = 0){
		if($adid == ''){$adid = 0;}
		if($adid!=0){
			$sql="SELECT catid,subcatid,reservation_status,menutab_status FROM ad_category_subcategory  WHERE adid =".$adid;
			$result = $this->CommonController->SelectRawquery($sql, 'resultArray');
			return $result['0']; 
		}
	}

	

	

	 

	 function bcs_default_ad_delete($business_id){//var_dump($_REQUEST);

		 if($business_id!=''){

		   $sql = "SELECT a.approval,d.name from ads_setting_preferences a ,ad_category_subcategory b ,ads c, business d WHERE b.adid = c.id AND c.business_id =a.businessid and a.businessid=d.id and d.id='$business_id' group by d.name; ";

			$change_status = $this->db->query($sql);

			$change_status_business = $change_status->result_array();  

			if($change_status_business['0']['approval']==3){

		 

		  // ++ When an ad create from BCS then default ad will be deleted and convert to FREE TRIAL BUSINESS	

		       $default_ad_delete_sql = "select a.*,c.approval, c.settingszoneid from ads a, business b, ads_setting_preferences c, ad_category_subcategory d where a.business_id=b.id and a.business_id='$business_id' and approval='3' and d.adid=a.id and d.catid=-99 and d.subcatid=-99 and c.businessid=a.business_id order by a.id ASC limit 1";//echo $default_ad_delete_sql;exit; 

			   $default_ad = $this->db->query($default_ad_delete_sql);

			   $default_ad_delete = $default_ad->result_array(); 

			   

			      $ad_id = $default_ad_delete['0']['id'];//var_dump($ad_id);exit;

				  $settingszoneid =$default_ad_delete['0']['settingszoneid'];//var_dump($settingszoneid);exit;



			            $this->db->where('adid',$ad_id); 

						$this->db->where('zoneid',$settingszoneid);																																																																					        				$this->db->delete('ad_category_subcategory');

						$this->db->where('adid', $ad_id);

						$this->db->where('zoneid',$settingszoneid);

						$this->db->delete('ad_to_zone');

						$this->db->where('id',$ad_id); 

						$this->db->delete('ads');	

				 // -- When an ad create from BCS then default ad will be deleted and convert to FREE TRIAL BUSINESS

			}

		 }

	 }

	

	 //////////////////// +++++  Update change status Business Coming Soon  to Trial Business after creation ad 15.09.2015(Tamal) +++++ /////////////

	

	

	function update_change_status($business_id,$fromzoneid,$adid){

		

		if($business_id!=0){

			  $sql = "SELECT a.approval,d.name from ads_setting_preferences a ,ad_category_subcategory b ,ads c, business d WHERE b.adid = c.id AND c.business_id =a.businessid and a.businessid=d.id and d.id='$business_id' group by d.name; ";

			$change_status = $this->db->query($sql);

			$change_status_business = $change_status->result_array();  

			if($change_status_business['0']['approval']==3){

				// update approval for converting business BCS to Free trial.

			        $update_change_status = $this->db->query("update ads_setting_preferences set approval='2' where businessid='$business_id'");

				// When  BCS convert to Free trial then Peekaboo Account will be created - 16.09.2015 (Tamal) 	

				    $peekaboo_account_sql = "SELECT a.*,b.name,c.street_address_1,c.street_address_2,c.city,c.state, c.zip_code,c.phone from users a, business b, address c where a.id=b.business_owner_id and b.id='$business_id' and b.addressid=c.id  ";

					$peekaboo_account = $this->db->query($peekaboo_account_sql);

					$create_peekaboo_account = $peekaboo_account->result_array();

					

					$peekaboo_contactfirstname =  !empty($create_peekaboo_account['0']['first_name']) ? $create_peekaboo_account['0']['first_name'] : '';

				    $peekaboo_contactlastname  =  !empty($create_peekaboo_account['0']['last_name']) ? $create_peekaboo_account['0']['last_name'] : '';

					$peekaboo_contactemail     =  !empty($create_peekaboo_account['0']['email']) ? $create_peekaboo_account['0']['email'] : '';

					$peekaboo_street_address_1 =  !empty($create_peekaboo_account['0']['street_address_1']) ? $create_peekaboo_account['0']['street_address_1'] : '';

					$peekaboo_street_address_2 =  !empty($create_peekaboo_account['0']['street_address_2']) ? $create_peekaboo_account['0']['street_address_2'] : '';

					$peekaboo_business_name    =  !empty($create_peekaboo_account['0']['name']) ? $create_peekaboo_account['0']['name'] : '';

					$peekaboo_zip_code =  !empty($create_peekaboo_account['0']['zip_code']) ? $create_peekaboo_account['0']['zip_code'] : '';

					$peekaboo_state =  !empty($create_peekaboo_account['0']['state']) ? $create_peekaboo_account['0']['state'] : '';

					$peekaboo_city =  !empty($create_peekaboo_account['0']['city']) ? $create_peekaboo_account['0']['city'] : '';

					$peekaboo_phone =  !empty($create_peekaboo_account['0']['phone']) ? $create_peekaboo_account['0']['phone'] : '';

					$peekaboo_username =  !empty($create_peekaboo_account['0']['username']) ? $create_peekaboo_account['0']['username'] : '';

					$peekaboo_password =  !empty($create_peekaboo_account['0']['uploaded_business_password']) ? $create_peekaboo_account['0']['uploaded_business_password'] : '';

					 

							$data_peekaboo=array(

							 'fName'=>$peekaboo_contactfirstname,

							 'lName'=>$peekaboo_contactlastname,

							 'email'=>$peekaboo_contactemail,

							 'address1'=>$peekaboo_street_address_1,

							 'address2'=>$peekaboo_street_address_2,

							 'company_name'=>$peekaboo_business_name,

							 'city_name'=>$peekaboo_city,

							 'state_name'=>$peekaboo_state,

							 'post_code'=>$peekaboo_zip_code,

							 'phone'=>$peekaboo_phone,

							 'user_name'=>$peekaboo_username,

							 'password'=>sha1($peekaboo_password),

							 'activated'=>'yes',

							 'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),

							 'member_type'=>2

						);	

						

					$this->db->insert('tbl_member', $data_peekaboo);

       		       $peekaboo_id = $this->db->insert_id();	

				   

				 // ++ If business owner login and change status then zone owner will get a email

				   if($fromzoneid == 0 ){  

				   $zoneowner_get_email_sql = "SELECT b.name as zone_name,b.id as zone_id, c.name,c.id , c.contactemail, d.email, d.first_name, d.last_name, e.city ,e.phone,e.street_address_1  from ads_setting_preferences a, sales_zone b, business c, users d , address e  where a.businessid=c.id and a.settingszoneid=b.id and b.sales_rep_id=d.id and c.addressid=e.id and c.id='$business_id' group by c.name";

				 

				   

				    $query =$this->db->query($zoneowner_get_email_sql);

				    $zoneowner_get_email = $query->result_array();

					

					$bus_name = $zoneowner_get_email['0']['name'];

					$zoneowner_name = $zoneowner_get_email['0']['zone_name'];

					$zoneowner_zone_id = $zoneowner_get_email['0']['zone_id'];

					$zoneowner_email = $zoneowner_get_email['0']['email'];

					$zoneowner_first_name = $zoneowner_get_email['0']['first_name'];

					$zoneowner_last_name = $zoneowner_get_email['0']['last_name'];

					$businessowner_id = $zoneowner_get_email['0']['id'];

					$businessowner_email = $zoneowner_get_email['0']['contactemail'];

					$businessowner_city = $zoneowner_get_email['0']['city'];

					$businessowner_phone = $zoneowner_get_email['0']['phone'];

					$businessowner_address = $zoneowner_get_email['0']['street_address_1'];

					

					

					$message=	   '<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">

									<div style="width:960px; margin:0 auto !important;">

									<div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">

									<div style="background-color:#3f3f3f; height:70px;"><img src="'.base_url('assets/images/logo_white.png').'"   

									 style="margin:10px 202px;" alt="logo"/></div>

									<div style="clear:both"></div>

									<div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:300px; padding:15px;">

									<h2 style="text-align:left;">Dear '.' '.$zoneowner_first_name.' '.$zoneowner_last_name.',

									</h2>

									<h3><p style="text-align:left; display:block; color:#333;">'.$bus_name.' business status has been changed from Business coming soon to Viewable Free Trial. </p></h3>

									<h3><p style="text-align:left; display:block; color:#333;">Business Id  :'."  ".$businessowner_id.'</p></h3>

									<h3><p style="text-align:left; display:block; color:#333;">Business Name  :'."  ".$bus_name.'</p></h3>

									<h3><p style="text-align:left; display:block; color:#333;">Email  :'."  ".$businessowner_email.'</p></h3>

									<h3><p style="text-align:left; display:block; color:#333;">Business Zone Name  :'."  ".$zoneowner_name.' '.'('.$zoneowner_zone_id.')</p></h3>

									<h3><p style="text-align:left; display:block; color:#333;">Address  :'."  ".$businessowner_address.'</p></h3>

									<h3><p style="text-align:left; display:block; color:#333;">City  :'."  ".$businessowner_city.'</p></h3>

									<h3><p style="text-align:left; display:block; color:#333;">Contact Number  :'."  ".$businessowner_phone.'</p></h3>

									



									</div>

									<div style="background-color:#999; height:60px;"></div>

									</div>

									</div>

									</body>';

					$fromemail='noreply@development.savingssites.com';

					$this->load->library('email');

					$template_subject="Business Status Change";

					$this->email->clear();

					$this->email->from($fromemail);

					$this->email->to($zoneowner_email);

					$this->email->subject($template_subject);

					$this->email->message($message);

					$this->email->send();			

				  

				  

				 }

				 // -- If business owner login and change status then zone owner will get a email   

			}

		}

	}

	

	 //////////////////// +++++  Update change status Business Coming Soon  to Trial Business after creation ad 15.09.2015(Tamal) +++++ /////////////

	 

		function subcategory_exists($catid,$zoneid,$busid,$adid){ //echo $catid; exit;

	    //$sql ="select a.subcatid from ad_category_subcategory a, ads b  where a.zoneid='$zoneid' and b.id = a.adid and b.business_id='$busid' and a.zoneid='$zoneid' ";

		$con ='' ;

		if($adid!=''){

			$con = " and a.adid NOT IN (".$adid.")"; 

		}

		$sql ="select a.subcatid from ad_category_subcategory a, ads b  where a.adid=b.id and  a.zoneid='$zoneid' and b.business_id='$busid' ".$con; 

	    $result = $this->db->query($sql);

		$subcategory = $result->result_array(); 

		$arr = array() ;

		foreach($subcategory as $k=>$v){

			$arr[] = $v['subcatid'] ;

		}

		return $arr; 

	   }

	   

	   

	   /////////////////////////////////////////////////////////////////////////////

	   

	   

	   function cat_display($zoneid){

		   

		   $show_cat_sql = "select catid from category_display where zoneid='".$zoneid."'";

		   $show_cat_query = $this->db->query($show_cat_sql);

		   $show_cat_result = $show_cat_query->result_array();//var_dump($show_cat_result);exit;

		   $cat_id = $show_cat_result['0']['catid'];

		   $arr = array() ;

		   $arr1 = array();

				foreach($show_cat_result as $k=>$v){

					$arr[] = $v['catid'] ;

				}

			    return (in_array(14, $arr)) ? 1 : 0;				

				//echo '<pre>'; var_dump($arr);exit;

			//return $arr;

		   //$byindustry_show = $show_cat_result['0']['catid'];

		   //return $byindustry_show;

	   }

	/**

	 * get subcategory according to the category

	 * get count of subcategory

	*/

	public function fetch_subcategory_items($category_id,$zone_id) {

		$sql="SELECT * FROM ad_category_subcategory WHERE catid=".$category_id." AND zoneid=".$zone_id." GROUP BY subcatid";

		$query=$this->db->query($sql);

		$result=$query->result_array();

		/*return $result;*/

		$result_data=array();

		$i=0;

		$sql1="";

		foreach ($result as $value) {

			$subcat_id=$value['subcatid'];

			$sql1="SELECT * FROM category_sub_subcategory_new WHERE id=".$subcat_id;

			//return $sql1;

			$count_query="SELECT count(*) AS total_count FROM ad_category_subcategory WHERE subcatid=".$subcat_id." AND catid=".$category_id." AND zoneid=".$zone_id;

			$result_count=$this->db->query($count_query);

			$result_count_content=$result_count->row();

			$count=0;

			if(count($result_count)>0){

				$count = $result_count_content->total_count;

			}

			$query1=$this->db->query($sql1);

			$result_array1=$query1->row();

			//return $result_array1;

			//$result_data[$i] = array('id'=>$result_array1->id,'name'=>$result_array1->name,'parent_id'=>$result_array1->parent_id);

			if(count($result_array1)>0){

				//$result_data[$i]=$result_array1;

				$result_data[$i] = array('id'=>$result_array1->id,'name'=>$result_array1->name,'parent_id'=>$result_array1->parent_id,'count'=>$count);

				$i++;



			}

			

		}

		return $result_data;

	}
	
	public function checkExistcms($zone_id){
		$query = $this->db->table('zone_cms')->select('*')->where('zone_id', $zone_id)->get();
        $result = $query->getResultArray(); 
        if(count($result) > 0){
        	return $result;	
        }else{
        	return 0;
        }
    }



	function update_zonecms($zone_id,$data){

		if(!empty($zone_id))

		{

			$this->db->where('zone_id',$zone_id);

			$this->db->update('zone_cms',$data);

		}

		

	}



	public function saveCmscontent($data){

		if(!empty($data))

		{

			$this->db->insert('zone_cms',$data);

			$zone_cms_id=$this->db->insert_id();

			

			$return_data=array('zone_cms_id'=>$zone_cms_id);

			return $return_data;

		}

		else{

			return array();

		}

	 }

	 

	 public function getLocalStore($zoneId){
	 	$query = $this->db->table('zone_local_stores')->select('*')->where('zone_id', $zoneId)->get();
        $result = $query->getResultArray(); 
        if(count($result) > 0){
        	return $result;
        }else{
        	return 0 ;
        }
    }

	   

	   

	   

	   

	   

	   

	   

	   

	   

	   

	   

	   		

}

