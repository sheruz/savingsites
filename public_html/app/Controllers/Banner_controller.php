<?php
namespace App\Controllers;
use App\Libraries\IonAuth;
use Config\MyConfig;
use App\Models\zone\Zone_model;
use App\Models\admin\Business;
use App\Models\banner\Banner_model;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Banner_controller extends BaseController{
    public function __construct(){
		$this->myconfig = new MyConfig;
    	$this->db = \Config\Database::connect();
    	$this->email = \Config\Services::email();
    	$this->ionAuth = new \IonAuth\Libraries\IonAuth();
    	$this->session = \Config\Services::session();
    	$this->Zone_model = new Zone_model();
    	$this->Business = new Business();
    	$this->email = \Config\Services::email();
    	$this->banner = new Banner_model();
    	$this->CommonController = new CommonController();
    }
	// public function __construct(){    
 //        parent::__construct();
 //        $this->load->library('ion_auth');
 //        $this->load->library('session');
 //        $this->load->library('form_validation');
	// 	$this->load->library('pagination');
        
	// 	$this->load->helper('url');
 //        $this->load->helper('ckeditor');
 //        $this->load->helper("time_helper");
 //        $this->load->helper('cookie');
	// 	$this->load->helper('download');
		
	// 	$this->load->model("States");
 //        $this->load->model("Statistics");
 //        $this->load->model("admin/Users", "users");
 //        $this->load->model("Dialog_result", "dr");
 //        $this->load->model("admin/Category_model", "category");
 //        $this->load->model("admin/Announcement_model", "announcements");
 //        $this->load->model("admin/Ads_model", "ads");
 //        $this->load->model("admin/Sales_zone", "sales_zone");
 //        $this->load->model("admin/Business", "business");
 //        $this->load->model("Zips", "zip");		
	// 	//$this->load->model("admin/business_dashboard1", "business_dashboard1");
 //        $this->load->model("admin/Templates", "template");
 //        $this->load->model("admin/Business_type_model", "business_type");
	// 	$this->load->model("admin/Category_management_model", "category_model");
	// 	$this->load->model("emailnotice/Email_notice", "email_notice");
	// 	$this->load->model("banner/Banner_model", "banner");
	// 	$this->load->library('image_lib');
		
	// 	$this->load->config('security', TRUE);
 //        $this->load->database();
 //    }
	
	public function index(){
	}
	
	function banner_section_view(){
		$data=array();
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$result = $this->load->view("banner/banner_section_view",$data, true);
		echo($this->dr->GetDR("","", $result, "0"));
	}
	
	function add_banner(){
		$data=array();
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$result = $this->load->view("banner/add_banner",$data, true);
		echo($this->dr->GetDR("","", $result, "0"));		
	}
	
	function manage_banner(){
		$data=array();
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$data['all_banner']=$this->banner->all_banner($data['zone_id']); 
		$result = $this->load->view("banner/manage_banner",$data, true);
		echo($this->dr->GetDR("","", $result, "0"));
	}
	function save_banner(){
		$data=array();
		$data['image_name']=!empty($_REQUEST['uploadedInput']) ? $_REQUEST['uploadedInput'] : '';
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;		
		$data['status']=!empty($_REQUEST['status']) ? $_REQUEST['status'] : 1;		
		$data['description']=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';
		$data['order']=!empty($_REQUEST['order']) ? $_REQUEST['order'] : 0;
		$data['save_banner']=$this->banner->save_banner($data['image_name'],$data['zone_id'],$data['status'],$data['description'],$data['order']);
		
		
	}
	
	function save_zone_banner(){			###########   For New Zone Dashboard   ###########
		$data=array();
		$data['image_name']=!empty($_REQUEST['uploadedInput']) ? $_REQUEST['uploadedInput'] : '';
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;		
		$data['status']=isset($_REQUEST['status']) ? $_REQUEST['status'] : 1;		
		$data['description']=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';
		$view_ats = !empty($_REQUEST['view_at']) ? $_REQUEST['view_at'] : '';
		$data['set_banner']=!empty($_REQUEST['set_banner']) ? $_REQUEST['set_banner'] : '';

		$order_val = $this->banner->get_order_val($data['zone_id']);
		$neworder = $order_val['neworder'];

		/*$sql_order = $this->db->query("SELECT (MAX(`order`)+1) as neworder FROM banner_display WHERE `zone_id` =".$data['zone_id']);
		$order = $sql_order->result_array();
		$order_val = count($order) > 0 ? $order[0]['neworder'] : 1;*/

		$data_arr = array('image_name'=>$data['image_name'],'zone_id'=>$data['zone_id'],'description'=>$data['description'],'timestamp'=>time());

		$banner_id = $this->banner->save_zone_banner($data_arr,'banner');



		if(!empty($banner_id) && $banner_id > 0)
		{
			foreach($view_ats as $view_at)
			{
				$check_exist_bannerdisplay = $this->banner->checkExistBannerdisplay($banner_id,$view_at,$data['zone_id']);

				$display_data=array('banner_id'=>$banner_id,'zone_id'=>$data['zone_id'],
				'order'=>$neworder,'status'=>$data['status'],'view'=>'0','viewable_at'=>$view_at,
				'device_type' => '1','set_banner_url' => $data['set_banner']);
				if(!empty($check_exist_bannerdisplay))
				{
					$json_arr['response'] = 'This banner already exist';
				}
				else{
					$ins_banner_display = $this->banner->save_zone_banner($display_data,'banner_display');
					$json_arr['response'] = 'Success';
				}
			}
			echo json_encode($json_arr);
			
		}
	}	

	function save_zone_bannermobile(){			###########   For New Zone Dashboard   ###########
		$data=array();
		$data['image_name']=!empty($_REQUEST['uploadedInput']) ? $_REQUEST['uploadedInput'] : '';
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;		
		$data['status']=isset($_REQUEST['status']) ? $_REQUEST['status'] : 1;		
		$data['description']=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';
		$view_ats = !empty($_REQUEST['view_at']) ? $_REQUEST['view_at'] : '';
		$data['set_banner']=!empty($_REQUEST['set_banner']) ? $_REQUEST['set_banner'] : '';

		$order_val = $this->banner->get_order_val($data['zone_id']);
		$neworder = $order_val['neworder'];

		/*$sql_order = $this->db->query("SELECT (MAX(`order`)+1) as neworder FROM banner_display WHERE `zone_id` =".$data['zone_id']);
		$order = $sql_order->result_array();
		$order_val = count($order) > 0 ? $order[0]['neworder'] : 1;*/

		$data_arr = array('image_name'=>$data['image_name'],'zone_id'=>$data['zone_id'],'description'=>$data['description'],'timestamp'=>time());

		$banner_id = $this->banner->save_zone_banner($data_arr,'banner');



		if(!empty($banner_id) && $banner_id > 0)
		{
			foreach($view_ats as $view_at)
			{
				$check_exist_bannerdisplay = $this->banner->checkExistBannerdisplay($banner_id,$view_at,$data['zone_id']);

				$display_data=array('banner_id'=>$banner_id,'zone_id'=>$data['zone_id'],
				'order'=>$neworder,'status'=>$data['status'],'view'=>'0','viewable_at'=>$view_at,
				'device_type' => '2','set_banner_url' => $data['set_banner']);
				if(!empty($check_exist_bannerdisplay))
				{
					$json_arr['response'] = 'This banner already exist';
				}
				else{
					$ins_banner_display = $this->banner->save_zone_banner($display_data,'banner_display');
					$json_arr['response'] = 'Success';
				}
			}
			echo json_encode($json_arr);
			
		}
	}
	                       /////////////////////  For new  banner  /////////////
/* 	function save_banner_image($zone_id){
		$uploadedImage=$_FILES['imgfile']['name'];
		$var = explode('.',$uploadedImage);
		$ext = strtolower(array_pop($var));
		$imagename=time().rand().'.'.$ext;
		$rand = mt_rand( 100, 999 );
		//$target = "./uploads/banner/$zone_id/";
		$target = "./assets/directory/images/banner";
		
		if(is_dir($target)==false){
			mkdir($target,0777);
		}
		$outPutImage=$imagename;
		$target=$target.basename($outPutImage);
		$pic=($_FILES['imgfile']['name']);
	
		if(move_uploaded_file($_FILES['imgfile']['tmp_name'], $target))
		{
			$picarray=array(
			'clientImage'=>$pic,
			'uploadedImage'=>$outPutImage,
			'zone_id'=>$zone_id
			);
			echo json_encode($picarray);
		}else{
			echo json_encode(0);
		}
	} */
	
	function save_banner_image($zone_id){
		
		$newfolder_name = $zone_id.'_'.time();
		
		$target = "./assets/directory/images/normal_banner";
		
		if(is_dir($target)==false){
			mkdir($target,0777);
		}
		
    	$result = '';
    	$output_image_data = '';
		
    	$file_config = array();
    	$file_config['upload_path'] = $target;
    	$file_config['max_size'] = "";
    	$file_config['allowed_types'] = "jpg|png|jpeg";
    	//$file_config['file_name'] = $new_filename;
    	
		//var_dump($filename);var_dump($file_config); var_dump($_FILES); exit;
    	$this->load->library('upload', $file_config);
    	//var_dump($this->upload->do_upload($filename)); //exit;
		
		
    	if ( ! $this->upload->do_upload('imgfile','banner_image'))
    	{
    		$result = $this->upload->display_errors();
			//echo json_encode(0);
			echo $result;
    	}else{
    		$data['upload_data'] = $this->upload->data();
			$img = $data['upload_data']['file_name'];
			
			$width = '1583';
			$height = '505';
			$resize_target = "./uploads/zone_banner/$zone_id";
		
			if(is_dir($resize_target)==false){
				mkdir($resize_target,0777);
			}
			$this->resize($resize_target,$data['upload_data'],$width,$height);
			
			//$delete_prev_folder = $this->upload->rrmdir($target); 
			
			//var_dump($img);
			$img_display = substr($img,16);
			
			$picarray=array(
			'clientImage'=>$img,
			'uploadedImage'=>'',
			'zone_id'=>$zone_id,
			);
			echo json_encode($picarray);
    	}
	}
	
	function save_banner_imagemobile($zone_id){
		
		$newfolder_name = $zone_id.'_'.time();
		
		$target = "./assets/directory/images/normal_banner";
		
		if(is_dir($target)==false){
			mkdir($target,0777);
		}
		
    	$result = '';
    	$output_image_data = '';
		
    	$file_config = array();
    	$file_config['upload_path'] = $target;
    	$file_config['max_size'] = "";
    	$file_config['allowed_types'] = "jpg|png|jpeg";
    	//$file_config['file_name'] = $new_filename;
    	
		//var_dump($filename);var_dump($file_config); var_dump($_FILES); exit;
    	$this->load->library('upload', $file_config);
    	//var_dump($this->upload->do_upload($filename)); //exit;
		
		
    	if ( ! $this->upload->do_upload('imgfile','banner_image'))
    	{
    		$result = $this->upload->display_errors();
			//echo json_encode(0);
			echo $result;
    	}else{
    		$data['upload_data'] = $this->upload->data();
			$img = $data['upload_data']['file_name'];
			
			$resize_mob_width = '737';
			$resize_mob_height = '1150';
			$resize_mob_target = "./uploads/zone_mobile_resizeupload/$zone_id";
		
			if(is_dir($resize_mob_target)==false){
				mkdir($resize_mob_target,0777);
			}
			$this->resize($resize_mob_target,$data['upload_data'],$resize_mob_width,$resize_mob_height);
			
			//$delete_prev_folder = $this->upload->rrmdir($target);
			
			//var_dump($img);
			$img_display = substr($img,16);
			
			$picarray=array(
			'clientImage'=>$img,
			'uploadedImage'=>'',
			'zone_id'=>$zone_id,
			);
			echo json_encode($picarray);
    	}
	}

	function save_zonecms_logo($zone_id){
		
		$newfolder_name = $zone_id.'_'.time();
		
		$target1 = "./uploads/zone_logo/temp_folder/".$newfolder_name."";
		
		mkdir($target1,0777);
		$target = "./uploads/zone_logo/temp_folder/".$zone_id."_".time()."/normal_image";
		
		if(is_dir($target)==false){
			mkdir($target,0777);
		}
		
    	$result = '';
    	$output_image_data = '';
		
    	$file_config = array();
    	$file_config['upload_path'] = $target;
    	$file_config['max_size'] = "300000";
    	$file_config['allowed_types'] = "jpg|png|jpeg";
    	//$file_config['file_name'] = $new_filename;
    	
		//var_dump($filename);var_dump($file_config); var_dump($_FILES); exit;
    	$this->load->library('upload', $file_config);
    	//var_dump($this->upload->do_upload($filename)); //exit;
		
		
    	if ( ! $this->upload->do_upload('imgfile','zone_logo'))
    	{
    		$result = $this->upload->display_errors();
			//echo json_encode(0);
			echo $result;
    	}else{
    		$data['upload_data'] = $this->upload->data();
    		$img = $data['upload_data']['file_name'];
			$width = '20';
			$height = '20';
			$resize_target = "./uploads/zone_logo/temp_folder/".$zone_id."_".time()."/resize_image";
		
			if(is_dir($resize_target)==false){
				mkdir($resize_target,0777);
			}
			$this->resize($resize_target,$data['upload_data'],$width,$height);
			
			//var_dump($img);
			$img_display = substr($img,16);
			
			$picarray=array(
			'clientImage'=>$img,
			'uploadedImage'=>$zone_id."_".time(),
			'zone_id'=>$zone_id,
			'folder_name'=>$newfolder_name
			);
			echo json_encode($picarray);
    	}
		
	}
		
	public function save_zonelogo(){
		$zone = $_REQUEST['zone_id'];
		$imagename = $_REQUEST['imagename'];
		$check_zone_logo = $this->banner->checkZonelogo($zone);
		if(!empty($check_zone_logo)){
			$data['save_banner']=$this->banner->update_zonelogo($imagename,$zone);
		}else{
		    $data['save_banner']=$this->banner->save_zonelogo($imagename,$zone);
		}
	    echo json_encode(['type' => 'success','msg' => 'Logo Updated Successfully', 'data' => $imagename]);
	}

	public function save_buisnesslogo(){
		$busid = $_REQUEST['busid'];
		$imagename = $_REQUEST['imagename'];
		$this->CommonController->updateData('business',['logo' => $imagename],['id' => $busid]);
	    echo json_encode(['type' => 'success','msg' => 'Logo Updated Successfully', 'data' => $imagename]);
	}
	
	public function resize($target,$image_data,$width,$height) {
		
		//$img = substr($image_data['full_path'], 51);
		$config['image_library'] = 'gd2';
		$config['source_image'] = $image_data['full_path'];
		$config['new_image'] = $target;
		$config['width'] = $width;
		$config['height'] = $height;

		//send config array to image_lib's  initialize function
		$this->image_lib->initialize($config);
		$src = $config['new_image'];
		$data['new_image'] = substr($src, 2);
		$data['img_src'] = base_url() . $data['new_image'];
		// Call resize function in image library.
		$this->image_lib->resize();
		// Return new image contains above properties and also store in "upload" folder.
		return $data;
	}
	
	function save_zonelogo_image($zone_id){
		
		//$newfolder_name = $zone_id.'_'.time();
		$newfolder_name = $zone_id;
		
		//$target1 = "./uploads/zone_logo/temp_folder/".$newfolder_name."";
		$target1 = "./uploads/zone_logo/".$newfolder_name."";
		
		mkdir($target1,0777);
		//$target = "./uploads/zone_logo/temp_folder/".$zone_id."_".time()."/normal_image";
		$target = "./uploads/zone_logo/".$zone_id."/normal_image";
		if(is_dir($target)==false){
			mkdir($target,0777);
		}
		
    	$result = '';
    	$output_image_data = '';
		
    	$file_config = array();
    	$file_config['upload_path'] = $target;
    	$file_config['max_size'] = "300000";
    	$file_config['allowed_types'] = "jpg|png|jpeg";
    	//$file_config['file_name'] = $new_filename;
    	
		//var_dump($filename);var_dump($file_config); var_dump($_FILES); exit;
    	$this->load->library('upload', $file_config);
    	//var_dump($this->upload->do_upload($filename)); //exit;
		
		
    	if ( ! $this->upload->do_upload('imgfile','zone_logo'))
    	{
    		$result = $this->upload->display_errors();
			//echo json_encode(0);
			echo $result;
    	}else{
    		$data['upload_data'] = $this->upload->data();
    		$img = $data['upload_data']['file_name'];
			$width = '260';
			$height = '80';
			//$resize_target = "./uploads/zone_logo/temp_folder/".$zone_id."_".time()."/resize_image";
			$resize_target = "./uploads/zone_logo/".$zone_id."/resize_image";
			if(is_dir($resize_target)==false){
				mkdir($resize_target,0777);
			}
			$this->resize($resize_target,$data['upload_data'],$width,$height);
			
			//var_dump($img);
			$img_display = substr($img,16);
			
			$picarray=array(
			'clientImage'=>$img,
			'uploadedImage'=>$zone_id."_".time(),
			'zone_id'=>$zone_id,
			'folder_name'=>$newfolder_name
			);
			echo json_encode($picarray);
    	}
		
	}
	
	
	                 /////////////////////////  For edit banner  /////////////////////
	function edit_banner_image($zone_id){

		$newfolder_name = $zone_id.'_'.time();
		
		$target = "./assets/directory/images/normal_banner";
		
		if(is_dir($target)==false){
			mkdir($target,0777);
		}
		
    	$result = '';
    	$output_image_data = '';
		
    	$file_config = array();
    	$file_config['upload_path'] = $target;
    	$file_config['max_size'] = "300000";
    	$file_config['allowed_types'] = "jpg|png|jpeg";
    	//$file_config['file_name'] = $new_filename;
    	
		//var_dump($filename);var_dump($file_config); var_dump($_FILES); exit;
    	$this->load->library('upload', $file_config);
    	//var_dump($this->upload->do_upload($filename)); //exit;
		
		
    	if ( ! $this->upload->do_upload('edit_banner','banner_image'))
    	{
    		$result = $this->upload->display_errors();
			//echo json_encode(0);
			echo $result;
    	}else{
    		$data['upload_data'] = $this->upload->data();
    		$img = $data['upload_data']['file_name'];
			
			$width = '1583';
			$height = '505';
			$resize_target = "./uploads/zone_banner/$zone_id";
		
			if(is_dir($resize_target)==false){
				mkdir($resize_target,0777);
			}
			$this->resize($resize_target,$data['upload_data'],$width,$height);
			
			//$delete_prev_folder = $this->upload->rrmdir($target);
			
			//var_dump($img);
			$img_display = substr($img,16);
			
			$picarray=array(
			'clientImage'=>$img,
			'uploadedImage'=>$img,
			'zone_id'=>$zone_id,
			);
			echo json_encode($picarray);
    	}


		/*$uploadedImage=$_FILES['edit_banner']['name'];//var_dump($uploadedImage);exit;
		$var = explode('.',$uploadedImage);
		$ext = strtolower(array_pop($var));
		$imagename=time().rand().'.'.$ext;
		$rand = mt_rand( 100, 999 );
		$target = "./uploads/banner/$zone_id/";
		
		if(is_dir($target)==false){
			mkdir($target,0777);
		}
		$outPutImage=$imagename;
		$target=$target.basename($outPutImage);
		$pic=($_FILES['edit_banner']['name']);
	
		if(move_uploaded_file($_FILES['edit_banner']['tmp_name'], $target))
		{
			$picarray=array(
			'clientImage'=>$pic,
			'uploadedImage'=>$outPutImage,
			'zone_id'=>$zone_id
			);
			echo json_encode($picarray);
		}else{
			echo json_encode(0);
		}*/
	}

	function edit_banner_imageformobile($zone_id){

		$newfolder_name = $zone_id.'_'.time();
		
		$target = "./assets/directory/images/normal_banner";
		
		if(is_dir($target)==false){
			mkdir($target,0777);
		}
		
    	$result = '';
    	$output_image_data = '';
		
    	$file_config = array();
    	$file_config['upload_path'] = $target;
    	$file_config['max_size'] = "300000";
    	$file_config['allowed_types'] = "jpg|png|jpeg";
    	//$file_config['file_name'] = $new_filename;
    	
		//var_dump($filename);var_dump($file_config); var_dump($_FILES); exit;
    	$this->load->library('upload', $file_config);
    	//var_dump($this->upload->do_upload($filename)); //exit;
		
		
    	if ( ! $this->upload->do_upload('edit_banner','banner_image'))
    	{
    		$result = $this->upload->display_errors();
			//echo json_encode(0);
			echo $result;
    	}else{
    		$data['upload_data'] = $this->upload->data();
    		$img = $data['upload_data']['file_name'];
			
			$resize_mob_width = '737';
			$resize_mob_height = '1150';
			$resize_mob_target = "./uploads/zone_mobile_resizeupload/$zone_id";
		
			if(is_dir($resize_mob_target)==false){
				mkdir($resize_mob_target,0777);
			}
			$this->resize($resize_mob_target,$data['upload_data'],$resize_mob_width,$resize_mob_height);
			
			//$delete_prev_folder = $this->upload->rrmdir($target);
			
			//var_dump($img);
			$img_display = substr($img,16);
			
			$picarray=array(
			'clientImage'=>$img,
			'uploadedImage'=>$img,
			'zone_id'=>$zone_id,
			);
			echo json_encode($picarray);
    	}
	}
	
	function edit_banner(){
		$data=array();
		$data['banner_id']=!empty($_REQUEST['banner_id']) ? $_REQUEST['banner_id'] : 0;
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$data['banner_view']=$this->banner->banner_view($data['banner_id'],$data['zone_id']); //var_dump($data['banner_view']); exit;
		$result=$this->load->view("banner/edit_banner",$data, true);
		echo($this->dr->GetDR("","", $result, "0"));
	}

	
	function update_banner(){
		$data=array();
		$data['banner_id']=!empty($_REQUEST['banner_id']) ? $_REQUEST['banner_id'] : 0;
		$data['image_name']=!empty($_REQUEST['uploadedInput']) ? $_REQUEST['uploadedInput'] : '';
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;		
		$data['status']=isset($_REQUEST['status']) ? $_REQUEST['status'] : 1;	
		$data['description']=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';
		$data['order']=!empty($_REQUEST['order']) ? $_REQUEST['order'] : 0; 
		$data['uploadedby'] = !empty($_REQUEST['uploadedby']) ? $_REQUEST['uploadedby'] : 0 ; //var_dump($data); exit;
		$data['save_banner']=$this->banner->update_banner($data['banner_id'],$data['image_name'],$data['zone_id'],$data['status'],$data['description'],$data['order'],$data['uploadedby']);
	}
	
	function edit_banner_new(){		###########   For New Zone Dashboard   ###########
		$data=array();
		$data['banner_id']=!empty($_REQUEST['banner_id']) ? $_REQUEST['banner_id'] : 0;
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$data['tab_id']=!empty($_REQUEST['tab_id']) ? $_REQUEST['tab_id'] : 0;
		$data['device_type']=!empty($_REQUEST['device_type']) ? $_REQUEST['device_type'] : 0;
		
		$data['banner_view']=$this->banner->banner_view($data['banner_id'],$data['zone_id'],$data['tab_id'],$data['device_type']); //var_dump($data['banner_view']); exit;
		
		foreach($data['banner_view'] as $viewable)
		{
			$total_checkbox[] = $viewable['viewable_at'];
		}
		 
		$data['total_checkbox'] = $total_checkbox;
		$result=$this->load->view("zone/subpage/banner/edit_banner",$data, true);
		echo($this->dr->GetDR("","", $result, "0"));
	}	

	function edit_banner_formobile(){		###########   For New Zone Dashboard   ###########
		$data=array();
		$data['banner_id']=!empty($_REQUEST['banner_id']) ? $_REQUEST['banner_id'] : 0;
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$data['tab_id']=!empty($_REQUEST['tab_id']) ? $_REQUEST['tab_id'] : 0;
		$data['device_type']=!empty($_REQUEST['device_type']) ? $_REQUEST['device_type'] : 0;

		$data['banner_view']=$this->banner->banner_view($data['banner_id'],$data['zone_id'],$data['tab_id'],$data['device_type']); //var_dump($data['banner_view']); exit;

		foreach($data['banner_view'] as $viewable)
		{
			$total_checkbox[] = $viewable['viewable_at'];
		}
		 
		$data['total_checkbox'] = $total_checkbox;
		$result=$this->load->view("zone/subpage/banner/edit_banner_formobile",$data, true);
		echo($this->dr->GetDR("","", $result, "0"));
	}
	
	function update_banner_new(){//var_dump($_REQUEST);exit;		###########   For New Zone Dashboard   ###########
		$data=array();
		$data['banner_id']=!empty($_REQUEST['banner_id']) ? $_REQUEST['banner_id'] : 0;
		$data['vieable_at']=!empty($_REQUEST['tab_id']) ? $_REQUEST['tab_id'] : 0;
		$data['image_name']=!empty($_REQUEST['uploadedInput1']) ? $_REQUEST['uploadedInput1'] : '';
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;		
		$data['status']=isset($_REQUEST['status']) ? $_REQUEST['status'] : 1;	
		$data['device_type']=!empty($_REQUEST['device_type']) ? $_REQUEST['device_type'] : '';
		$data['description']=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';
		$data['order']=!empty($_REQUEST['order1']) ? $_REQUEST['order1'] : 0; 
		$data['uploadedby'] = !empty($_REQUEST['uploadedby']) ? $_REQUEST['uploadedby'] : 0 ; //var_dump($data); exit;
		//$view_ats = !empty($_REQUEST['view_at']) ? $_REQUEST['view_at'] : '';
		$data['set_banner']=!empty($_REQUEST['set_banner']) ? $_REQUEST['set_banner'] : '';

		$check_banner_name = $this->banner->checkBannername($data['banner_id'],$data['zone_id'],$data['image_name']);
		if($check_banner_name['image_name'] != $data['image_name'])
		{
			$data_arr = array('image_name'=>$data['image_name']);
			$data['save_banner']=$this->banner->update_banner_image($data_arr,$data['banner_id']);

			
		}
		$data_for_bannerdisplay = array('status'=>$data['status'],'set_banner_url' => $data['set_banner']);
		$update_img_status = $this->banner->update_banner_imagestatus($data_for_bannerdisplay,$data['banner_id'],
		$data['zone_id'],$data['device_type'],$data['vieable_at']);

		/*foreach($view_ats as $view_at){
			$check_bannertab_exist = $this->banner->checkExistBannerdisplay($_REQUEST['banner_id'],$data['zone_id'],$view_at);
			$banner_arr[] = $check_bannertab_exist['viewable_at'];
			if(!in_array($view_at,$banner_arr))
			{
				$display_data=array('banner_id'=>$data['banner_id'],'zone_id'=>$data['zone_id'],'order'=>$data['order'],'status'=>$data['status'],'view'=>'0','viewable_at'=>$view_at);
					 $ins_banner_display = $this->banner->save_zone_banner($display_data,'banner_display');
			}
		}*/

		
		
	}	

	function update_banner_mobile(){//var_dump($_REQUEST);exit;		###########   For New Zone Dashboard   ###########
		$data=array();
		$data['banner_id']=!empty($_REQUEST['banner_id']) ? $_REQUEST['banner_id'] : 0;
		$data['vieable_at']=!empty($_REQUEST['tab_id']) ? $_REQUEST['tab_id'] : 0;
		$data['image_name']=!empty($_REQUEST['uploadedInput1']) ? $_REQUEST['uploadedInput1'] : '';
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;		
		$data['status']=isset($_REQUEST['status']) ? $_REQUEST['status'] : 1;
		$data['device_type']=!empty($_REQUEST['device_type']) ? $_REQUEST['device_type'] : '';	
		$data['description']=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';
		$data['order']=!empty($_REQUEST['order1']) ? $_REQUEST['order1'] : 0; 
		$data['uploadedby'] = !empty($_REQUEST['uploadedby']) ? $_REQUEST['uploadedby'] : 0 ; //var_dump($data); exit;
		//$view_ats = !empty($_REQUEST['view_at']) ? $_REQUEST['view_at'] : '';
		$data['set_banner']=!empty($_REQUEST['set_banner']) ? $_REQUEST['set_banner'] : '';

		$check_banner_name = $this->banner->checkBannername($data['banner_id'],$data['zone_id'],$data['image_name']);
		if($check_banner_name['image_name'] != $data['image_name'])
		{
			$data_arr = array('image_name'=>$data['image_name']);
			$data['save_banner']=$this->banner->update_banner_image($data_arr,$data['banner_id']);
		}

		$data_for_bannerdisplay = array('status'=>$data['status'],'set_banner_url' => $data['set_banner']);
		$this->banner->update_banner_imagestatus($data_for_bannerdisplay,$data['banner_id'],$data['zone_id'],
		$data['device_type'],$data['vieable_at']);
		
	}
	
	function delete_banner(){
		$data=array();
		$data['banner_id']=!empty($_REQUEST['banner_id']) ? $_REQUEST['banner_id'] : 0;
		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$data['banner_path']=!empty($_REQUEST['banner_path']) ? $_REQUEST['banner_path'] : 'default';
		$data['image_name']=!empty($_REQUEST['image_name']) ? $_REQUEST['image_name'] : '';
		$data['banner_view']=$this->banner->delete_banner($data['banner_id'],$data['zone_id'],$data['banner_path'],$data['image_name']);
		echo($this->dr->GetDR($data['banner_id'],"", "", "0"));
	}
	
		
	### Banner Image Oredering Part Start
	function banner_order_change(){  
		$updateRecordsArray 	= $_REQUEST['order']; //var_dump($updateRecordsArray); exit;
		$zone_id 				= $_POST['zone_id']; 
		$tab_id = $_POST['tab_id'];
		$device_type = $_POST['device_type'];

		$this->banner->banner_order_change($updateRecordsArray,$zone_id,$tab_id,$device_type);
	}
	### Banner Image Oredering Part End

	function banner_order_changeformobile(){  
		$updateRecordsArray 	= $_REQUEST['order']; //var_dump($updateRecordsArray); exit;
		$zone_id 				= $_POST['zone_id']; 
		$tab_id = $_POST['tab_id'];
		$device_type = $_POST['device_type'];

		$this->banner->banner_order_changeformobile($updateRecordsArray,$zone_id,$tab_id,$device_type);
	}
}