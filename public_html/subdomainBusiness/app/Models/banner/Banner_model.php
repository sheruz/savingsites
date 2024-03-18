<?php
namespace App\Models\banner;

use CodeIgniter\Model;
use App\Libraries\IonAuth;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Banner_model extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->CommonController = new CommonController();
    } 

function save_banner($image_name='',$zone_id=0,$status=1,$description='',$order=0){

		$data=array('image_name'=>$image_name,'zone_id'=>$zone_id,'description'=>$description,'timestamp'=>time());

		$this->db->insert('banner',$data);

		$banner_id=$this->db->insert_id();

		$display_data=array('banner_id'=>$banner_id,'zone_id'=>$zone_id,'order'=>$order,'status'=>$status);

		$this->db->insert('banner_display',$display_data);

		$banner_display_id=$this->db->insert_id();

		$return_data=array('banner_id'=>$banner_id,'banner_display_id'=>$banner_display_id);

		return $return_data;

 	}
	
	public function save_zonelogo($image_name='',$zone_id=0){
		$data=array('image_name'=>$image_name,'id'=>$zone_id);
		$banner_id = $this->CommonController->InsertData('sales_zone', $data);
		$return_data=array('banner_id'=>$banner_id);
		return $return_data;
	} 

	

	function save_zone_banner($data=array(),$table=''){			###########   For New Zone Dashboard   ###########

		if(!empty($data))

		{

			$this->db->insert($table,$data);

			$banner_id=$this->db->insert_id();

			return $banner_id;

		}

 	}



 	function get_order_val($zone_id)

 	{

 		$sql="SELECT (MAX(`order`)+1) as neworder FROM banner_display WHERE `zone_id` ="."$zone_id";

		$query = $this->db->query($sql);

		$result=$query->row_array();

		//echo $this->db->last_query();

		return $result;	

 	}



 	function checkExistBannerdisplay($banner_id='',$zone_id='',$view_at='')

 	{

 		$this->db->select('*');

 		$this->db->from('banner_display');

 		$this->db->where('banner_id',$banner_id);

 		$this->db->where('viewable_at',$view_at);

 		$this->db->where('zone_id',$zone_id);



 		$query = $this->db->get();

 		//echo $this->db->last_query();die;

 		$num_result = $query->num_rows();

 		if($num_result > 0)

 		{

 			$result = $query->row_array();

 			return $result;

 		}

 		else{

 			return 0;

 		}



 	}



	function checkBannername($banner_id='',$zone_id='',$image_name='')

 	{

 		$this->db->select('*');

 		$this->db->from('banner');

 		$this->db->where('id',$banner_id);

 		$this->db->where('image_name',$image_name);

 		$this->db->where('zone_id',$zone_id);



 		$query = $this->db->get();

 		//echo $this->db->last_query();die;

 		$num_result = $query->num_rows();

 		if($num_result > 0)

 		{

 			$result = $query->row_array();

 			return $result;

 		}

 		else{

 			return 0;

 		}



 	}

 	function getBannerlist($zone_id,$viewable_id,$device_type)

 	{

 		$this->db->select('BNR.*,BDSP.order,BDSP.status,BDSP.banner_id as bid,BDSP.zone_id as zid');

 		$this->db->from('banner_display BDSP');

 		$this->db->join('banner BNR','BNR.id = BDSP.banner_id',LEFT);

 		

 		$this->db->where('BDSP.zone_id',$zone_id);

 		//$this->db->or_where('BNR.zone_id','0');

		 $this->db->where('BDSP.viewable_at',$viewable_id);

		 $this->db->where('BDSP.device_type',$device_type);

 		$this->db->order_by('BDSP.order', 'asc');



 		$query = $this->db->get();

 		$num_result = $query->num_rows();

 		if($num_result > 0)

 		{

 			$result = $query->result_array();

 			return $result;

 		}

 		else{

 			return 0;

 		}



 	}

	

	public function all_banner($zone_id=0,$device_type = ''){

		 	$this->db->select('BNR.*,BDSP.order,BDSP.status,BDSP.banner_id as bid,BDSP.zone_id as zid');

	 		$this->db->from('banner_display BDSP');

	 		$this->db->join('banner BNR','BNR.id = BDSP.banner_id',LEFT);

	 		

	 		$this->db->where('BDSP.zone_id',$zone_id);

	 		//$this->db->or_where('BNR.zone_id','0');

			 $this->db->where('BDSP.viewable_at','1');

			 $this->db->where('BDSP.device_type',$device_type);

	 		$this->db->order_by('BDSP.order', 'asc');



	 		$query = $this->db->get();

	 		$num_result = $query->num_rows();

	 		if($num_result > 0)

	 		{

	 			$result = $query->result_array();

	 			return $result;

	 		}

	 		else{

	 			return 0;

	 		}

	}

	

	function active_banner($zone_id=0,$from='',$viewable_at = ''){

		if($from == 'directory'){

			$limit= ' limit 1';

		}

		else{

			$limit = '';

		}

		$sql="SELECT b.image_name, b.description, bd.order ,b.zone_id, bd.banner_id, bd.device_type FROM (banner AS b, banner_display AS bd) WHERE b.id = bd.banner_id AND bd.zone_id =$zone_id AND bd.status=1 AND bd.viewable_at=$viewable_at ORDER BY bd.order ASC". $limit;

		$query = $this->db->query($sql);

    	$result = $query->result_array();

		//echo $this->db->last_query(); exit;

		return $result;		

	}



	function update_banner_imagestatus($data='',$banner_id=0,$zone_id = 0,$device_type=0,$vieable_at=0){

		if(!empty($banner_id))

		{

			$this->db->where('banner_id',$banner_id);

			$this->db->where('device_type',$device_type);

			$this->db->where('zone_id',$zone_id);

			$this->db->where('viewable_at',$vieable_at);

			$this->db->update('banner_display',$data);

		}

		

	}

	function active_banner_slider_desktopmobile($zone_id=0,$from='',$viewable_at = '',$device_type = ''){
		if($from == 'directory'){
			$limit= ' limit 1';
		}else{
			$limit = '';
		}
		
		$sql="SELECT b.image_name, b.description, bd.order ,b.zone_id, bd.banner_id, bd.device_type, bd.set_banner_url FROM (banner AS b, banner_display AS bd) WHERE b.id = bd.banner_id AND bd.zone_id =$zone_id AND bd.status=1 AND bd.viewable_at=$viewable_at AND bd.device_type=$device_type ORDER BY bd.order ASC  limit 1";
		$query = $this->db->query($sql);
		$result = $query->getResultArray();
		return $result;	
	}



	public function active_banner_desktopmobile($zone_id=0,$from='',$viewable_at = '',$device_type = '',$key = ''){
		if($from == 'directory'){
			$limit= ' limit 1';
		}else{
			$limit = '';
		}
		
		$sql="SELECT b.image_name, b.description, bd.order ,b.zone_id, bd.banner_id, bd.device_type, bd.viewable_at ,  bd.set_banner_url FROM (banner AS b, banner_display AS bd) WHERE b.id = bd.banner_id AND bd.zone_id =$zone_id AND bd.status=1 AND bd.viewable_at=$viewable_at AND bd.device_type=$device_type ORDER BY bd.order ASC". $limit;
		$result = $this->CommonController->getStoreCache($sql,'resultArray',$key,3600);
		return $result;	
	}



	/*function home_active_banner($viewable_at){

		if($from == 'directory'){

			$limit= ' limit 1';

		}

		else{

			$limit = '';

		}

		$sql="SELECT b.image_name, b.description, bd.order ,b.zone_id FROM (banner AS b, banner_display AS bd) WHERE b.id = bd.banner_id AND bd.status=1 AND bd.viewable_at=$viewable_at ORDER BY bd.order ASC". $limit;

		$query = $this->db->query($sql);

    	$result = $query->result_array();

		//echo $this->db->last_query();

		return $result;		

	}*/



	function active_mobile_banner(){

		$sql="SELECT b.image_name, b.description, bd.order ,b.zone_id FROM (banner AS b, banner_display AS bd) WHERE b.id = bd.banner_id AND bd.view = 1 AND bd.status=1 ORDER BY bd.order ASC ";

		$query = $this->db->query($sql);

    	$result = $query->result_array();

		//echo $this->db->last_query();

		return $result;

	}



	function count_banner($zone_id=0){

		$sql="SELECT COUNT(b.image_name) as image  FROM (banner AS b, banner_display AS bd) WHERE b.id = bd.banner_id AND bd.zone_id =$zone_id AND bd.status=1 ORDER BY bd.order ASC ";

		$query = $this->db->query($sql);

    	$result = $query->result_array();//var_dump($result['0']['image']);exit;

		//echo $this->db->last_query();

		return $result['0']['image'];		

	}

	

	function home_banner(){

		$sql="SELECT b.image_name, b.description,b.id FROM (banner AS b) WHERE b.zone_id = 0";

		$query = $this->db->query($sql);

    	$result = $query->result_array();

		//echo $this->db->last_query();

		return $result;		

	}

	// get defaultBannerId

	function getDefaultBannerId() {

		$sql = "SELECT

			        id

			       		FROM banner

			       		WHERE zone_id =0";

	    $query = $this->db->query($sql);

	    return $query->result_array();

	}

	

	function banner_view($banner_id=0,$zone_id=0,$tab_id=0,$device_type=0){

		$sql="SELECT b.image_name,b.description,b.id,b.zone_id as uploaded_by,bd.status,bd.viewable_at,bd.set_banner_url,bd.order FROM (banner AS b, banner_display AS bd) WHERE bd.banner_id=$banner_id AND bd.banner_id=b.id AND bd.zone_id=$zone_id

		 AND bd.viewable_at=$tab_id AND bd.device_type=$device_type";

		$query = $this->db->query($sql);

    	$result = $query->result_array();

		return $result;

	}

	

	function update_banner($banner_id=0,$image_name='',$zone_id=0,$status=1,$description='',$order=0,$uploadedby=0){

		if($uploadedby != 0){

			$data=array('image_name'=>$image_name,'description'=>$description,'timestamp'=>time());

			$this->db->where('id',$banner_id);

			$this->db->update('banner',$data);

		}

		$display_data=array('banner_id'=>$banner_id,'zone_id'=>$zone_id,'order'=>$order,'status'=>$status);

		$display_data_where=array('banner_id'=>$banner_id,'zone_id'=>$zone_id);

		$this->db->where($display_data_where);

		$this->db->update('banner_display',$display_data);

		//echo $this->db->last_query();

	}
	
	public function checkZonelogo($zone_id,$key = ''){
		$query = "SELECT *  FROM sales_zone where id = ".$zone_id."";
		$row = $this->CommonController->getStoreCache($query,'resultArray',$key,3600);
		if(count($row) > 0){ return $row; }else{ return 0; }
	}
	
	public function getZonelogo($zone_id){
		$result = $this->CommonController->SelectDataMultiWay('sales_zone','*','rowArray',['id'=>$zone_id]);
		if(count($result) > 0){
			return $result;	
		}else{
			return 0;
		}
	}
	
	public function update_zonelogo($image_name='',$id=0){
		if(!empty($id)){
			$data=array('image_name'=>$image_name);
			$this->CommonController->updateData('sales_zone',$data,['id' => $id]);
		}
	}



	function deleteZonelogo($zoneid){



		$sql="SELECT image_name FROM sales_zone WHERE `id` =".$zoneid;

		$query = $this->db->query($sql);		

		$result = $query->result_array();		

		$imagepath = "./uploads/zone_logo/".$zoneid."/normal_image/".$result[0]['image_name'];

		$get_upload_zonelogo_path = $this->config->item('upload_zonelogo_path');		

		$imagepath = $_SERVER['DOCUMENT_ROOT'].$get_upload_zonelogo_path.'/'.$zoneid.'/normal_image/'.$result[0]['image_name']; 

				

		if(!empty($zoneid))

		{

			$data=array('image_name'=>'');

			$this->db->where('id',$zoneid);

			if($this->db->update('sales_zone',$data)){

				unlink($imagepath);

			}

			

		}

	}



	function update_banner_image($data='',$id=0){

		if(!empty($id))

		{

			$this->db->where('id',$id);

			$this->db->update('banner',$data);



			return true;

		}

		

	}

	

	function update_banner_new($banner_id=0,$image_name='',$zone_id=0,$status=1,$description='',$uploadedby=0,$viewable_at=''){			###########   For New Zone Dashboard   ###########

		if($uploadedby != 0){

			$data=array('image_name'=>$image_name,'description'=>$description,'timestamp'=>time());

			$this->db->where('id',$banner_id);

			$this->db->update('banner',$data);

		}

		$display_data=array('banner_id'=>$banner_id,'zone_id'=>$zone_id,'status'=>$status,'viewable_at'=>$viewable_at);

		$display_data_where=array('banner_id'=>$banner_id,'zone_id'=>$zone_id);

		$this->db->where($display_data_where);

		$this->db->update('banner_display',$display_data);

		//echo $this->db->last_query();

	}	

	

	

	function delete_banner($banner_id=0,$zone_id=0,$banner_path="",$image_name=''){

		if($banner_path!="default"){

			$this->db->where('id',$banner_id);

			$this->db->delete('banner');

			unlink('uploads/zone_banner/'.$zone_id.'/'.$image_name.'');

		}

		

		$display_data_where=array('banner_id'=>$banner_id,'zone_id'=>$zone_id);

		$this->db->where($display_data_where);

		$this->db->delete('banner_display');

	}

	# + Banner Display Order Settings

	function banner_order_change($updateRecords = '',$zone_id = '',$tab_id = '',$device_type = ''){ 

		if ($updateRecords != '' && $zone_id != ''){

			

			$trimvalue = rtrim($updateRecords,','); 

			$updateRecordsArray = explode(',',$trimvalue);

			

			foreach ($updateRecordsArray as $key=>$banner_data) {	

				$banner_value = explode('_',$banner_data);

				$banner_display_data=array('order'=>$key+1);

				$banner_display_where = array('banner_id'=>$banner_value[1],'zone_id'=>$zone_id,'viewable_at'=>$tab_id,'device_type'=>$device_type);

				$this->db->where($banner_display_where);

				$this->db->update('banner_display',$banner_display_data);

	

			}

		}

	}



	function banner_order_changeformobile($updateRecords = '',$zone_id = '',$tab_id = '',$device_type = ''){ 

		if ($updateRecords != '' && $zone_id != ''){

			

			$trimvalue = rtrim($updateRecords,','); 

			$updateRecordsArray = explode(',',$trimvalue);

			

			foreach ($updateRecordsArray as $key=>$banner_data) {	

				$banner_value = explode('_',$banner_data);

				$banner_display_data=array('order'=>$key+1);

				$banner_display_where = array('banner_id'=>$banner_value[1],'zone_id'=>$zone_id,'viewable_at'=>$tab_id,'device_type'=>$device_type);

				$this->db->where($banner_display_where);

				$this->db->update('banner_display',$banner_display_data);

	

			}

		}

	}

	# - Banner Display Order Settings

	

	################################################# + Start Realtor Banner Display Settings + ######################################################################

	

	function banner_realtor_view($banner_id,$org_id){

		/*$sql="SELECT b.image_name,b.description,b.zone_id as uploaded_by,bd.status,bd.order FROM (banner AS b, banner_display AS bd) WHERE bd.banner_id=$banner_id AND     bd.banner_id=b.id AND bd.zone_id=$zone_id";*/

		//echo "SELECT banner_name,upload_banner,description FROM banner_info WHERE id=$banner_id and organizationid=$org_id";exit;

		$sql="SELECT banner_name,upload_banner,description FROM banner_info WHERE id=$banner_id and organizationid=$org_id";

		$query = $this->db->query($sql);

    	$result = $query->result_array();

		return $result;

		

	}

	function update_realtor_banner($banner_id=0,$banner_name='',$upload_banner='',$zone_id=0,$status=1,$description='',$order=0,$uploaded=0){

		if($banner_id != 0){//var_dump($banner_id);exit;

			$data=array('banner_name'=>$banner_name,'upload_banner'=>$uploaded,'description'=>$description);

			$this->db->where('id',$banner_id);

			$this->db->update('banner_info',$data);

		}

	}



   function delete_realtor_banner($banner_id=0,$org_id=0,$upload_banner=""){//var_dump($_REQUEST);exit;

		if($banner_id!=0){

			$this->db->where('id',$banner_id);

			$this->db->delete('banner_info');

			unlink('uploads/bannerupload/'.$org_id.'/'.$upload_banner.'');

		}

		/*$display_data_where=array('banner_id'=>$banner_id,'zone_id'=>$zone_id);

		$this->db->where($display_data_where);

		$this->db->delete('banner_display');*/

	}





	################################################# - End Realtor Banner Display Settings End - ######################################################################

}

?>