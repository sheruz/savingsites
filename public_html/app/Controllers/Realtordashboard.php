<?php

### Created by Athena eSolutions

error_reporting(0);

require_once(dirname(__FILE__)."/welcome.php"); 



class Realtordashboard extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

		$this->clear_cache();

        

		$this->load->library('ion_auth');

        $this->load->library('session');

        $this->load->library('form_validation');

		$this->load->library('pagination');

        

		$this->load->helper('url');

        $this->load->helper('ckeditor');

        $this->load->helper("time_helper");

        $this->load->helper('cookie');

		$this->load->helper('url');

		$this->load->helper('download');

		

		$this->load->model("States");

        $this->load->model("Statistics");

        $this->load->model("admin/Users", "users");

        $this->load->model("Dialog_result", "dr");

        $this->load->model("admin/Category_model", "category");

        $this->load->model("admin/Announcement_model", "announcements");

        $this->load->model("admin/Ads_model", "ads");

        $this->load->model("admin/Sales_zone", "sales_zone");

        $this->load->model("admin/Business", "business");

        $this->load->model("Zips", "zip");		

		////$this->load->model("admin/business_dashboard1", "business_dashboard1");

        $this->load->model("admin/Templates", "template");

        $this->load->model("admin/Business_type_model", "business_type");

		$this->load->model("admin/Category_management_model", "category_model");

		$this->load->model("Category_new_model");

		$this->load->model("emailnotice/Email_notice", "email_notice");

		//$this->load->model("Organization_model", "org_model");

		// new model

		$this->load->model("Organization_model", "org_model");

		$this->load->model("zone/Zone_model", "zone_model");

		$this->load->model("User", "user");

		$this->load->model("banner/Banner_model", "banner");

		

		$this->load->config('security', TRUE);		

        $this->load->database();

    }

	function clear_cache(){    

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma: no-cache");

    }

    public function index(){    

        echo("Index works..");

        $this->load->view("dashboards/zone_dashboard");		

    }

	

	/**

	* common_first function golabal function on that page

	*

	* All session variable set in this function 

	*

	* Redirect page according to condtion

	*/

	

	function common_first($org_id=0,$fromzoneid=0){//var_dump($org_id);exit;//echo "<pre>";var_dump($this->session->all_userdata());exit;

		$data=array();

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}



        if (empty($user)) {

        	redirect('/', 'refresh');

        }

		//$data['top_header_name']=$this->org_model->organization_details($org_id); //var_dump($data['top_header_name']);

		$data['where_from']='realtor';  

		$data['from_zoneid']=isset($fromzoneid) ? $fromzoneid : 0;

		

		if($data['from_zoneid']!=0){//var_dump(1);exit;

			$data['top_header_name']=$this->zone_model->get_zone($data['from_zoneid']); //var_dump($data['top_header_name']);

			$data['sub_header_name_from_zone']=$this->org_model->realtor_details($org_id);

			$data['from_where']='zone_realtor'; 

		}else{//var_dump(2);exit;

			$data['top_header_name']=$this->org_model->realtor_details($org_id);// var_dump($data['sub_header_name_from_zone']);exit;

			$data['sub_header_name_from_zone']=''; $data['from_where']='';

		}

			

		//$data['from_zone']= $this->zone_model->get_zone($fromzoneid); 

		//$data['from_zone']=0;

		$data['user'] = $user;		

		$data['uid']= $uid; 

		$data["usergroup"]=$this->business->get_user_group1($uid);

		$usergrid=$data["usergroup"]->group_id;

        if(!empty($user)){

        	$data["email"] = $user->email;

        	$data["firstName"] = $user->first_name;

        	$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

        }

		$data['realtorid']=$org_id;  //var_dump($data); exit;

		//$organization_status= $this->announcements->organization_status($org_id); 

		$data['zone']=$this->sales_zone->realtor_zone($org_id); 

		$data['zoneid']=$data['zone'][0]['zoneid'];

		$data['organization_status']=$organization_status[0]['approval'];

		//$data['zone']=$this->announcements->organization_zone($org_id);

		$userzoneid=$data['top_header_name']['zoneid'];

		$userzoneid=$data['zone'][0]['zoneid'];

		$data['org_name']=$data['zone'][0]['name'];

		$data['org_owner_id']=$data['zone'][0]['userid']; 

		//$data['zoneid']=$userzoneid; //var_dump($data['zoneid']); exit;

		//$data['zoneid']=$userzoneid;//var_dump($data['zoneid']);exit;

		$data['zoneid_no']=$data['sub_header_name_from_zone']['zoneid'];

		//$data['zoneid']='';  

		// newly added

		//$data['getall_category']=$this->announcements->getall_category($org_id); 

		

		////////////////////////////////////////////////////////////////////

		

		$check_valid_url= $this->ion_auth->check_valid_url_other($uid,$userzoneid,$org_id,$fromzoneid,$data['where_from']);

		$check_zoneid = $this->session->userdata('session_zoneid'); 

		$session_realtorid = $this->session->userdata('sesrealid'); 

		$realtor_id = $session_realtorid['sesrealid'];

		$valid_zoneid = $check_zoneid['userzoneid'];

			if($check_valid_url==0){//var_dump($data['from_zoneid']);exit;

				if($data['from_zoneid']!=0){

				//redirect(base_url('/index.php?zone='.$valid_zoneid), 'refresh');

				$modified_url = base_url('/Zonedashboard/zonedetail/'.$valid_zoneid);

			    redirect($modified_url, 'location', 301);

			   }else{

				 $modified_url = base_url('/realtordashboard/realtordetail/'.$realtor_id);//var_dump($modified_url);exit;

			    redirect($modified_url, 'location', 301);

			   }

			}

		//////////////////////////////////////////////////////////////////

		

		//$data['zoneid']=$valid_zoneid;

		$session_login_details=$this->session->userdata('session_login_details');

		$data['login_type']=$session_login_details['type'];

		$data['login_id']=$session_login_details['id'];	

		$newsessiondata_realtor = array(

                   'usergrid'=>$usergrid,

                   'userzoneid'=>$userzoneid

        ); 

		$this->session->set_userdata('realtor_usersessiondata',$newsessiondata_realtor);  //var_dump($this->session->userdata('usersessiondata'));exit;

		$session_zoneid_from_realtor = array(

                   'usergrid'=>$usergrid,

                   'userzoneid'=>$userzoneid,

				   'type'=>'realtor'

        );

		$this->session->set_userdata('session_zoneid_from_realtor',$session_zoneid_from_realtor);  //var_dump($this->session->userdata('session_zoneid_from_realtor'));exit;

		$newsessiondata = array(

                   'usergrid'=>$usergrid,

                   'userzoneid'=>$userzoneid

        );

		$this->session->set_userdata('usersessiondata',$newsessiondata); //var_dump($this->session->userdata('usersessiondata'));exit;

		return $data;

	}

	

	function common($info){	//var_dump($info['common']['top_header_name']['zoneid']);exit;

	    //$data['common'] = $info['common']['top_header_name'];

		$data['left_container'] = $this->load->view("default/common/left_panel_realtor", $info, true); 

		$data['side_dashboard_container'] = $this->load->view("default/common/left_panel_realtor", $info, true);

        $data['content'] = $this->load->view("content_new", $data, true);

		$data['header']= $this->load->view("default/common/header", $data);

	}

	

	################################################  Realtor Details Part Start ####################################################



# + This will show the dashboard of an Organization <br />



// + Realtor information view (with change password)

public function realtordetail($org_id=false,$fromzoneid=0){			

		$data['common']=$this->common_first($org_id,$fromzoneid); 

		$data['state_list'] = $this->states->get_state_dropdown();

		$data['realtor_details'] = $this->org_model->realtor_details($org_id);

		$data['realtor_detail']=$this->org_model->realtor_owner_detail($org_id); 	//var_dump($data['realtor_detail']);exit;

		$data['right_container'] = $this->load->view("realtor/dashboard", $data, true); //echo '<pre>';var_dump($data['common']); exit;		

		$this->common($data);

	}



// + Realtor background upload section

  public function manage_banner($org_id=false,$fromzoneid=0){ 

        $data['org_id']=$org_id;		

		$data['common']=$this->common_first($org_id,$fromzoneid);  

		$data['banner'] = $this->org_model->get_banner_by_realtorid($org_id); 

		$data['right_container'] = $this->load->view("realtor/manage_banner", $data, true);  

		$data['upload'] = $this->load->view("realtor/realestate",$data,true);

		$this->common($data);

	}

// - Realtor background upload section 	



// + Save banner image section for realtor background



 function save_banner_image($org_id){//var_dump($_REQUEST);exit;

		$uploadedImage=$_FILES['imgfile']['name'];

		$var = explode('.',$uploadedImage);

		$ext = strtolower(array_pop($var));

		$imagename=time().rand().'.'.$ext;

		$rand = mt_rand( 100, 999 );

		$target = "./uploads/bannerupload/$org_id/";

		

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

			'org_id'=>$org_id

			);

			echo json_encode($picarray);

		}else{

			echo json_encode(0);

		}

	}



// - Save banner image section for realtor background



	function save_banner_image1($org_id){//echo 1;exit;

		$uploadedImage=$_FILES['img_name']['name']; //var_dump($uploadedImage);exit;

		$var = explode('.',$uploadedImage);

		$ext = strtolower(array_pop($var));

		$imagename=time().rand().'.'.$ext;

		$rand = mt_rand( 100, 999 );

		$target = "./uploads/bannerupload/$org_id/";

		

		if(is_dir($target)==false){

			mkdir($target,0777);

		}

		$outPutImage=$imagename;

		$target=$target.basename($outPutImage);

		$pic=($_FILES['img_name']['name']);

	

		if(move_uploaded_file($_FILES['img_name']['tmp_name'], $target))

		{

			$picarray=array(

			'clientImage'=>$pic,

			'uploadedImage'=>$outPutImage,

			'org_id'=>$org_id

			);

			echo json_encode($picarray);

		}else{

			echo json_encode(0);

		}

	}

	// changing the image orders for org

	public function org_photo_order_change(){ 

		$updateRecordsArray 	= $_REQUEST['order']; //var_dump($updateRecordsArray); exit;

		$org_id 				= $_REQUEST['orgnid']; 

		$cat_id					= $_REQUEST['cat_id'];

		$this->org_model->org_photo_order_change($updateRecordsArray,$org_id,$cat_id);

		

	}



 public function banner_photo_catid(){

		//var_dump($_REQUEST); exit;

		$data=array();

		$data['cat_id'] = !empty($_REQUEST['catid']) ? $_REQUEST['catid'] : '';

		$data['org_id'] = !empty($_REQUEST['orgnid']) ? $_REQUEST['orgnid'] : '';

		$data['all_banner'] = $this->org_model->org_photo_by_catid($data['cat_id'],$data['org_id']); 

		$result = $this->load->view('organization/subpage/viewphotos', $data, true);		

		echo($this->dr->GetDR("","", $result, "0"));

	}

	public function save_banner_upload(){ 

		$organizationid=!empty($_REQUEST['organizationid']) ? $_REQUEST['organizationid'] : '';   

		$cat_id=!empty($_REQUEST['bannername']) ? $_REQUEST['bannername'] : '';          

		$image_name=!empty($_REQUEST['uploadedInput']) ? $_REQUEST['uploadedInput'] : '';

		$description=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';

		

		   $upload['data']=$this->org_model->update_banner_upload($cat_id,$image_name,$description,$organizationid);

		  

	}

	#------------ open delete image in realtor----------------------#

	

	public function delete_banner_photo($image_name,$bannername,$organizationid){

		$data=array();

		$image_name=!empty($_REQUEST['uploadedInput']) ? $_REQUEST['uploadedInput'] : '';

		$bannername=!empty($_REQUEST['bannername']) ? $_REQUEST['bannername'] : '';

		$organizationid=!empty($_REQUEST['organizationid']) ? $_REQUEST['organizationid'] : '';

		$data['banner_view']=$this->org_model->delete_banner_photo($image_name,$organizationid);

		echo($this->dr->GetDR($data['banner_view'],"", "", "0"));

		

	}

	

	// + Edit button click for access view edit info about banner  

	

	function edit_banner(){//var_dump($_REQUEST);exit;

		$data=array();

		$data['banner_id']=!empty($_REQUEST['banner_id']) ? $_REQUEST['banner_id'] : 0;

		$data['org_id']=!empty($_REQUEST['org_id']) ? $_REQUEST['org_id'] : 0;

		$data['banner_view']=$this->banner->banner_realtor_view($data['banner_id'],$data['org_id']); //var_dump($data['banner_view']); exit;

		$result=$this->load->view("realtor/edit_banner",$data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	

	// - Edit button click for access view edit info about banner  

	

	// + Update banner section for realtor directory background

	

	function update_realtor_banner(){//var_dump($_REQUEST);exit;

		$data=array();

		$data['banner_id']=!empty($_REQUEST['banner_id']) ? $_REQUEST['banner_id'] : 0;

		$data['image_name']=!empty($_REQUEST['uploadedInput1']) ? $_REQUEST['uploadedInput1'] : '';

		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;

		$data['banner_name']=!empty($_REQUEST['banner_name']) ? $_REQUEST['banner_name'] : 0;	

		$data['status']=isset($_REQUEST['status']) ? $_REQUEST['status'] : 1;	

		$data['description']=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';

		$data['order']=!empty($_REQUEST['order']) ? $_REQUEST['order'] : 0; 

		$data['uploaded'] = !empty($_REQUEST['uploaded']) ? $_REQUEST['uploaded'] : 0 ; //var_dump($data); exit;

		$data['save_banner']=$this->banner->update_realtor_banner($data['banner_id'],$data['banner_name'],$data['image_name'],$data['zone_id'],$data['status'],$data['description'],$data['order'],$data['uploaded']);

	}

	

	// - Update banner section for realtor directory background

	

	

	// + Delete banner 

	

	function delete_banner(){

		$data=array();

		$data['banner_id']=!empty($_REQUEST['banner_id']) ? $_REQUEST['banner_id'] : 0;

		$data['org_id']=!empty($_REQUEST['org_id']) ? $_REQUEST['org_id'] : 0;

		//$data['banner_path']=!empty($_REQUEST['banner_path']) ? $_REQUEST['banner_path'] : 'default';

		$data['upload_banner']=!empty($_REQUEST['upload_banner']) ? $_REQUEST['upload_banner'] : '';

		$data['banner_view']=$this->banner->delete_realtor_banner($data['banner_id'],$data['org_id'],$data['upload_banner']);

		echo($this->dr->GetDR($data['banner_id'],"", "", "0"));

	}

	

	// - Delete banner 

	

	#-------------- close delete imaage in realtor---------------------#

	

# - This will show the dashboard of an Organization 



# + update profile

	public function update_profile(){

		$userid = $_REQUEST['userid'];

        $email = $_REQUEST['email'];

        $firstname = $_REQUEST['firstname'];

		$lastname = $_REQUEST['lastname'];

        $phone = $_REQUEST['phone'];

        $address = $_REQUEST['address'];

        $city = $_REQUEST['city'];

        $state = $_REQUEST['state'];

        $zip = $_REQUEST['zip'];

		$userData = array(

            'email' => $email,

            'first_name' => $firstname,

            'last_name' => $lastname,

            'phone' => $phone,

            'Address' => $address,

            'City' => $city,

            'State_Code' => $state,

            'Zip' => $zip

         );

		//$sql = "UPDATE users SET row_to_update = (SELECT row_you_need from tbl_target WHERE tbl_updateme.comparison_row = tbl_target.comparison_row)";

		//$sql = "SELECT userid FROM realtor WHERE id=".$userid;

		//$query = $this->db->query($sql);

		//$id = $query->row_array(); 

		//$userid = $id['userid'];var_dump($userid);exit;

		$this->db->where('id', $userid);

        $this->db->update('users', $userData);

		echo($this->dr->GetDR("Updating Profile", "", "", "0"));

		//$this->user->update_profile($data);

	}

# - update profile



# + update_password

	public function update_password(){

		$userid = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : '' ;

		$username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '' ;

		$current_pass = !empty($_REQUEST['current_pass']) ? $_REQUEST['current_pass'] : '';//var_dump($current_pass);

        $new_pass = !empty($_REQUEST['new_pass']) ? $_REQUEST['new_pass'] : '';

        $confirm_pass = !empty($_REQUEST['confirm_pass']) ? $_REQUEST['confirm_pass'] : '';

		if($new_pass != $confirm_pass){

			$message = "<h4 style='color:#090'>Your New Password and Confirm Password are not same. For this No Changes Made!</h4>";

		}else{ 

			$change = $this->ion_auth->change_password($username, $current_pass, $new_pass);				

			if ($change)

			{

				$message = "<h4 style='color:#090'>Update Successful</h4>";

			}

			else

			{

				$message = "<h4 style='color:#090'>No Changes Made!</h4>";

			}

		}

		 echo($this->dr->GetDR("Update Profile", $message, "", "0"));

	}

# - update_password



# + manage photo

	public function managephoto($org_id=false,$fromzoneid=0){ 			

		$data['common']=$this->common_first($org_id,$fromzoneid);  

		$data['right_container'] = $this->load->view("organization/managephoto", $data, true); 

		$this->common($data);

	}

	// saving new photos

	/*public function save_org_photo(){ 

		$data=array();

		$data['image_name']=!empty($_REQUEST['uploadedInput']) ? $_REQUEST['uploadedInput'] : '';

		$data['org_id']=!empty($_REQUEST['organizationid']) ? $_REQUEST['organizationid'] : 0;

		$data['cat_id']=!empty($_REQUEST['allcategories']) ? $_REQUEST['allcategories'] : '';		

		$data['status']=($_REQUEST['status'] != '') ? $_REQUEST['status'] : 1;		

		$data['description']=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';

		$data['save_banner']=$this->org_model->save_org_photo_new($data['image_name'],$data['org_id'],$data['cat_id'],$data['status'],$data['description']);

	}*/

	// viewing org photos in org dashboard 

	/*public function org_photo_by_catid(){

		//var_dump($_REQUEST); exit;

		$data=array();

		$data['cat_id'] = !empty($_REQUEST['catid']) ? $_REQUEST['catid'] : '';

		$data['org_id'] = !empty($_REQUEST['orgnid']) ? $_REQUEST['orgnid'] : '';

		$data['all_banner'] = $this->org_model->org_photo_by_catid($data['cat_id'],$data['org_id']); //var_dump($data['all_banner']); exit;

		$result = $this->load->view('organization/subpage/viewphotos', $data, true);		

		echo($this->dr->GetDR("","", $result, "0"));

	}*/

	// save uploaded image into folder

	

	// changing the image orders for org

	

	// deleting organization photos

	public function delete_org_photo(){

		$data=array();

		$data['photo_id']=!empty($_REQUEST['photo_id']) ? $_REQUEST['photo_id'] : 0;

		$data['org_id']=!empty($_REQUEST['org_id']) ? $_REQUEST['org_id'] : 0;

		$data['cat_id']=!empty($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 'default';

		$data['image_name']=!empty($_REQUEST['image_name']) ? $_REQUEST['image_name'] : '';

		$data['banner_view']=$this->org_model->delete_org_photo($data['photo_id'],$data['org_id'],$data['cat_id'],$data['image_name']);

		echo($this->dr->GetDR($data['photo_id'],"", "", "0"));

		

	}

	// edit org photo

	public function edit_org_photo(){

		$data=array();

		$data['photo_id']=!empty($_REQUEST['photo_id']) ? $_REQUEST['photo_id'] : 0;

		$data['org_id']=!empty($_REQUEST['org_id']) ? $_REQUEST['org_id'] : 0;

		$data['catlist'] = $this->announcements->getall_category($data['org_id']);	//var_dump($data['catlist']); exit;

		$data['org_photo_view']=$this->org_model->org_photo_by_id($data['photo_id'],$data['org_id']); //var_dump($data['org_photo_view']); exit;

		$result = $this->load->view('organization/subpage/editphotos', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	

	public function update_org_photo(){

		//var_dump($_REQUEST); exit;

		$data=array();

		$data['photo_id']=!empty($_REQUEST['photo_id']) ? $_REQUEST['photo_id'] : 0;

		$data['org_id']=!empty($_REQUEST['org_id']) ? $_REQUEST['org_id'] : 0;

		$data['description']=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';

		$data['status']=!empty($_REQUEST['status']) ? $_REQUEST['status'] : '';

		$data['cat_id']=!empty($_REQUEST['allcategories3']) ? $_REQUEST['allcategories3'] : '';

		$this->org_model->update_org_photo($data['photo_id'],$data['org_id'],$data['description'],$data['status'],$data['cat_id']);

		

	}

	

# - manage photo



	################################################  Organization Details Part End ######################################################

		

	################################################  Organization Category/Sub category Part Start ######################################

	// + Create New Category

	public function newcategory($org_id=false,$fromzoneid=false){		

		$data['organizationid']=$org_id;

		$data['common']=$this->common_first($org_id,$fromzoneid);		

		$data['right_container'] = $this->load->view("organization/new_category", $data, true);

		$this->common($data);

	}

	// + Create New Subc-ategory

	public function newsubcategory($org_id=false,$fromzoneid=0){

		$data['common']=$this->common_first($org_id,$fromzoneid); //var_dump($data['common']); exit;

		$data['right_container'] = $this->load->view("organization/new_subcategory", $data, true);

		$this->common($data);

	}

	// + View All Category/Subcategory

	public function allcategorysubcategory($org_id=false,$fromzoneid=0){

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/view_category_subcategory", $data, true);

		$this->common($data);

	}

	################################################  Organization Category/Sub category Part ends #######################################################

	

	################################################  Organization Announcement Part Start #################################################################

	

	public function newannouncement($org_id=false,$fromzoneid=0){				

		$data['common']=$this->common_first($org_id,$fromzoneid); //var_dump($data['common']); exit;

		$data['getall_category']=$this->announcements->getall_category($org_id); 

		$data['ckeditor'] = array(



            //ID of the textarea that will be replaced

            'id' 	=> 	'announcement_text',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



        ));	

		

		$data['right_container'] = $this->load->view("organization/new_announcement", $data, true);

		$this->common($data);

	}

	

	public function viewannouncement($org_id=false,$fromzoneid=0){

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['fromzoneid']=$fromzoneid;  

		//var_dump($data['common']); var_dump($data['common']['zoneid']);

		//$lowerlimit=0; $upperlimit=100;

		$data['announcement_list'] = $this->announcements->get_announcements_for_organization($data['common']['zoneid'],$org_id,$lowerlimit,$upperlimit);

		//$data['announcement_list'] = $this->announcements->get_announcements_for_organization($fromzoneid,$org_id,$lowerlimit,$upperlimit); //var_dump($data['announcement_list']); exit;

		$data['right_container'] = $this->load->view("organization/view_announcement", $data, true);

		$this->common($data);

	}

	public function viewmoreannouncement($org_id=false,$fromzoneid=0,$lowerlimit=0,$upperlimit=0){ //var_dump($org_id,$fromzoneid,$lowerlimit,$upperlimit); exit;

		$data = array();

		$data['announcement_list'] = $this->announcements->get_announcements_for_organization($fromzoneid,$org_id,$lowerlimit,$upperlimit);

		$data['countallannouncements']=count($data['announcement_list']);

		if($data['countallannouncements']<1){		

			$data['countallannouncements'] = 0;		

		}

			$lowerlimit=$lowerlimit+5;				

			$limit=$lowerlimit.','.$upperlimit;	

		$result = $this->load->view("organization/more_announcement",$data, true);

		echo($this->dr->GetDR($data['countallannouncements'],$limit,$result,"0"));

		

	}

	public function editannouncement($org_id=false,$fromzoneid=0,$ann_id){ 

		$data['common']=$this->common_first($org_id,$fromzoneid);

		// newly added

		$data['getall_category']=$this->announcements->getall_category($org_id); 

		$data['ckeditor'] = array(



            //ID of the textarea that will be replaced

            'id' 	=> 	'announcement_text',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



        ));	

		

		$data['right_container'] = $this->load->view("organization/edit_announcement", $data, true);

		$this->common($data);

	}

	################################################  Organization Announcement Part End #################################################################

	

	################################################  Organization Uploaded Letters Part Start #################################################################	

	public function uploadedletters($org_id=0, $fromzoneid=0){

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['uploaded_letters'] = $this->sales_zone->get_letters_for_organization($org_id);		

		$data['right_container'] = $this->load->view("organization/view_letters", $data, true);

		$this->common($data);	

	}

	################################################  Organization Uploaded Letters Part End #################################################################

	

	################################################  Organization Interest Group Part Start #################################################################

	# + New interest Group

	public function newinterestgroup($org_id=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($org_id,$fromzoneid);		

		$data['right_container'] = $this->load->view("organization/create_interest_group", $data, true);

		$this->common($data);

	}

	

	public function viewinterestgroup($org_id=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/view_interest_group", $data, true);

		$this->common($data);

	}

		

	public function viewinterestgroupvisibility($org_id=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/interest_group_visibility", $data, true);

		$this->common($data);

	}

	

	

	

	

	################################################  Organization Interest Group Part End #################################################################





################################################  Organization Bulk Email Part Start #######################################################	

# + viewbulkemail  --> To get the list of the members under the organization - Added on 21/08/14

	public function viewbulkemail($org_id=false,$fromzoneid=0){

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['zoneid']=$data['common']['zoneid'];

		//$data['organization_members_bulk_email'] = $this->org_model->get_all_org_members($org_id,$data['zoneid']);  // Send the firts/last name , email , phone , id to the view page

		$data['ckeditor_sendbulkemail'] = array(

		//ID of the textarea that will be replaced  

			'id' 	=> 	'text_for_mail',

			'path'	=>	'assets/ckeditor',

			//Optional values

			'config' => array(

				'toolbar' 	=> 	"Full", 	//Using the Full toolbar

				'width' 	=> 	"555",	//Setting a custom width

				'height' 	=> 	'150px',	//Setting a custom height

	    ));	

		$data['right_container'] = $this->load->view("organization/viewbulkemail", $data, true);

		$this->common($data);	

	}

# - viewbulkemail



# + send_mail_to_org_members --> To send bulkemail to the organization members

	public function send_mail_to_org_members(){

		$userids = empty($_REQUEST['uid']) ? 0 : $_REQUEST['uid']; 

		$sub = $_REQUEST['subject'];

		$msg = str_replace("\n","<br>",$_REQUEST['message']);

		//echo $userids ;exit;

		$uid_arr=explode(',',$userids); 

		//foreach($uid_arr as $uid){	

			//$sql = "SELECT group_concat(email) as contactemail FROM users WHERE id IN(".$userids.")" ;

			$sql = "SELECT group_concat(email) as contactemail FROM org_members WHERE id IN(".$userids.") ";

			$query_u1 = $this->db->query($sql);	

			$useremail=$query_u1->result_array(); 

			if(!empty($useremail)){

				$uemailid=$useremail[0]['contactemail']; //var_dump($uemailid); exit;

				//var_dump($uemailid); exit;

				$fromemail=$this->config->item('adminEmailId');

				$this->load->library('email');

				$this->email->clear();

				$this->email->from($fromemail);

				$this->email->subject($sub);

				$this->email->message($msg);

				$this->email->to($uemailid);

				$this->email->send();

				$to[]=$uemailid;

			}

		//}

		//exit;

		$message="Email send successfully ";

		echo($this->dr->GetDR("Successfully", $message, "", "0"));

	}

# - send_mail_to_org_members





################################################  Organization Bulk Email Part End #########################################################

	

	

	################################################  Organization Email Notice Part Start #################################################################

	public function createemailnotice($org_id=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/create_email_notice", $data, true);

		$this->common($data);

	}

	public function viewemailnotice($org_id=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($org_id,$fromzoneid);	

		$data['right_container'] = $this->load->view("organization/view_email_notice", $data, true);

		$this->common($data);

	}

	public function sendemailnotice($org_id=false,$fromzoneid=0){ 

		$data['common']=$this->common_first($org_id,$fromzoneid);

	

	# + Added on 10/07/14

		$data['zoneid'] = $data['common']['zoneid'];

		$data['createdby_id'] = $data['common']['top_header_name']['id'];

		$data['createdby_type'] = 3;

		$data['ig_group']=$this->email_notice->active_subscribed_group_display($data['zoneid'],$data['createdby_id'],$data['createdby_type']); 

		$data['all_bus_notice']=$this->email_notice->all_notices($data['zoneid'],$data['createdby_id'],$data['createdby_type']);

	# - Added on 10/07/14

		

		$data['right_container'] = $this->load->view("organization/send_email_notice", $data, true);

		$this->common($data);

	}

	public function historyemailnotice($org_id=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($org_id,$fromzoneid);

		

	# + Added on 10/07/14

		$data['zoneid'] = $data['common']['zoneid'];

		$data['createdby_id'] = $data['common']['top_header_name']['id'];

		$data['createdby_type'] = 3;

		$data['email_history']=$this->email_notice->view_email_notice_history($data['createdby_id'],$data['zoneid'],$data['createdby_type']);	

	# - Added on 10/07/14

		

		$data['right_container'] = $this->load->view("organization/history_email_notice", $data, true);

		$this->common($data);

	}

	################################################  Organization Email Notice Part End #################################################################

	public function delete_home_sold(){

		$data = array();

		$data['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

		$data['zoneid'] =!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : '';

		$data['action_performed'] = !empty($_REQUEST['action_performed']) ? $_REQUEST['action_performed'] : '';

		//$data['change_business_status'] = !empty($_REQUEST['change_business_status']) ? $_REQUEST['change_business_status'] : '';

		$data['allorspecific'] = !empty($_REQUEST['allorspecific']) ? $_REQUEST['allorspecific'] : '';

		$data['realtor_type'] = !empty($_REQUEST['realtor_type']) ? $_REQUEST['realtor_type'] : '';

		$data['my_organization_in_zone'] = $this->org_model->fn_homesold_delete($data['id'],$data['zoneid'],$data['action_performed'],$data['change_business_status'],$data['allorspecific'],$data['organization_type']);

		//echo($this->dr->GetDR($data['my_organization_in_zone'],"", "", "0"));	

		echo $data['my_organization_in_zone'];

	}

	

	// + Realtor directory for realtor owner

	

	public function realtor_directory($user_id=false,$zoneid_from_directory){

		

		$data = array();

		$data['user_id'] = $user_id;   

		

		if($this->session->userdata('realtor_usersessiondata')){ // + Realtor user session data exists

			$user_sessiondata = $this->session->userdata('realtor_usersessiondata'); 

			$zoneid=$this->session->userdata('session_zoneid');

			$data['user_group_id'] = $user_sessiondata['usergrid'];

			if(!empty($user_sessiondata['userzoneid']))

			$data['userzoneid'] = $user_sessiondata['userzoneid'];	

			else

			$data['userzoneid'] = $zoneid['userzoneid'];

		}

		else{ 

			$session_normal_user_in_zone = $this->session->userdata('session_normal_user_in_zone');

			$data['user_id'] = $this->session->userdata('user_id');

			$data['userzoneid'] = $session_normal_user_in_zone['sesuserzone'];

			$data['sesusertype'] = $session_normal_user_in_zone['sesusertype'];  // this is the user type name like 'resident'

			if(!empty($data['user_id'])){

				$select_group_id = "SELECT a.group_id FROM users_groups as a , users as b WHERE b.id=".$data['user_id']." AND a.user_id=b.id";

				$query_group_id = $this->db->query($select_group_id);

				$data['user_group_id'] = $query_group_id->result_array(); 

			}

		}

		if(!empty($data['userzoneid'])){

			$select_realtor_info = "SELECT b.id as realtor_id, b.name as realtor_name , b.userid as users_id, c.email , c.first_name , c.last_name , c.phone , c.Address , c.City , c.State_Code , c.Zip FROM realtor as b , users as c WHERE b.zoneid=".$data['userzoneid']." AND b.userid=c.id";

			$query_realtor_info = $this->db->query($select_realtor_info); 

			$data['result_realtor_info'] = $query_realtor_info->result_array();

			$rid = !empty($data['result_realtor_info'][0]['realtor_id']) ? $data['result_realtor_info'][0]['realtor_id'] : '' ;

		// + Get the home sold details for a particular zone. This will get dispaly in the Realestate page.s

		

		                      ////////////////////////////////////

		      $realtor_access_csvupload_sql = "SELECT auto_approve_csvupload FROM zone_preferences WHERE zoneid=".$data['userzoneid'];

			  $query_realtor_access_csvupload = $this->db->query($realtor_access_csvupload_sql);

		      $data['realtor_access_csvupload'] = $query_realtor_access_csvupload->result_array();

		                   //////////////////////////////////////

		

			$select_home_sold = "SELECT * FROM tbl_savingstore_home_sold WHERE zoneid=".$data['userzoneid'];

			$query_select_home_sold = $this->db->query($select_home_sold);

			$data['result_home'] = $query_select_home_sold->result_array(); 

			$data['banner'] = $this->org_model->get_banner_by_realtorid($rid);

			if(!empty($rid)){

				  // - Get the home sold details for a particular zone

			     echo $this->load->view("realtor/realestate",$data,true);

			}else{

				 echo $this->load->view("coupon_img");

			}

		

		}

		else if(!empty($user_id)){//var_dump($_REQUEST);exit; var_dump(77);exit; //var_dump($this->session->all_userdata());exit;

		 	$session_zone_id = $this->session->userdata('session_zoneid');

			$data['userzoneid'] =  $session_zone_id['userzoneid'];

			if(!empty($data['userzoneid'])){

				$select_realtor_info = "SELECT b.id as realtor_id, b.name as realtor_name , b.userid as users_id, c.email , c.first_name , c.last_name , c.phone , c.Address , c.City , c.State_Code , c.Zip FROM realtor as b , users as c WHERE b.zoneid=".$data['userzoneid']." AND b.userid=c.id";

				$query_realtor_info = $this->db->query($select_realtor_info);

				$data['result_realtor_info'] = $query_realtor_info->result_array();

				// + Get the home sold details for a particular zone. This will get dispaly in the Realestate page.s

				$select_home_sold = "SELECT * FROM tbl_savingstore_home_sold WHERE zoneid=".$data['userzoneid'];

				$query_select_home_sold = $this->db->query($select_home_sold);

				$data['result_home'] = $query_select_home_sold->result_array();

			}else{

				$get_zone_id = "SELECT zoneid FROM realtor WHERE userid=".$user_id;

				$query_get_zone_id = $this->db->query($get_zone_id);

				$zoneid = $query_get_zone_id->result_array(); //var_dump($zoneid[0]['zoneid']); exit;

				$data['userzoneid'] = $zoneid[0]['zoneid'];//var_dump($data['userzoneid']); exit;

				

				$select_group_id = "SELECT a.group_id FROM users_groups as a , users as b WHERE b.id=".$user_id." AND a.user_id=b.id";

				$query_group_id = $this->db->query($select_group_id);

				$group_id = $query_group_id->result_array();  

				$data['user_group_id'] = $group_id[0]['group_id']; //var_dump($data['user_group_id']); exit;

			if(!empty($zoneid_from_directory)){	

				$select_realtor_info = "SELECT b.id as realtor_id, b.name as realtor_name , b.userid as users_id,b.zoneid, c.email , c.first_name , c.last_name , c.phone , c.Address , c.City , c.State_Code , c.Zip FROM realtor as b , users as c WHERE b.zoneid=".$zoneid_from_directory." AND  b.userid=c.id"; //echo $select_realtor_info;exit;

				$query_realtor_info = $this->db->query($select_realtor_info);

			}else{

				$select_realtor_info = "SELECT b.id as realtor_id, b.name as realtor_name , b.userid as users_id,b.zoneid, c.email , c.first_name , c.last_name , c.phone , c.Address , c.City , c.State_Code , c.Zip FROM realtor as b , users as c WHERE b.zoneid=".$data['userzoneid']." AND  b.userid=c.id"; //echo $select_realtor_info;exit;

				$query_realtor_info = $this->db->query($select_realtor_info);

				

			}

				$data['result_realtor_info'] = $query_realtor_info->result_array();//var_dump($data['result_realtor_info']);exit;

			}

			//echo "<pre>"; var_dump($data);exit;

		if(!empty($zoneid_from_directory)){	

		      $realtor_access_csvupload_sql = "SELECT auto_approve_csvupload FROM zone_preferences WHERE zoneid=".$zoneid_from_directory;

			  $query_realtor_access_csvupload = $this->db->query($realtor_access_csvupload_sql);

		}else{

			  $realtor_access_csvupload_sql = "SELECT auto_approve_csvupload FROM zone_preferences WHERE zoneid=".$data['userzoneid'];

			  $query_realtor_access_csvupload = $this->db->query($realtor_access_csvupload_sql);

		 }

		     $data['realtor_access_csvupload'] = $query_realtor_access_csvupload->result_array();

		// + Get the home sold details for a particular zone. This will get dispaly in the Realestate page.s

		if(!empty($zoneid_from_directory)){

			$select_home_sold = "SELECT * FROM tbl_savingstore_home_sold WHERE zoneid=".$zoneid_from_directory;

			$query_select_home_sold = $this->db->query($select_home_sold);

		 }else{

			 $select_home_sold = "SELECT * FROM tbl_savingstore_home_sold WHERE zoneid=".$data['userzoneid'];

			$query_select_home_sold = $this->db->query($select_home_sold);

		 }

			$rid = isset($data["result_realtor_info"][0]["realtor_id"]) ? $data["result_realtor_info"][0]["realtor_id"] : '';

			//$data['banner'] = $this->org_model->get_banner_by_realtorid($rid); //echo "<pre>"; var_dump($data['banner']);exit;

			$data['result_home'] = $query_select_home_sold->result_array(); //echo "<pre>"; var_dump( $data['result_home']);exit;

			$data['banner'] = $this->org_model->get_banner_by_realtorid($rid);

			echo $this->load->view("realtor/realestate",$data,true); 

		}

		else{

			//redirect(base_url().'index.php?zone=').$data['user_zone_id']; 

			echo $this->load->view("realtor/realestate",true);

		}

		//$result = $this->load->view("realtor/realestate", $data , true);

	} 

	

	// + CSV upload data view section

	

	public function view_home_sold_realtor($zoneid=false,$fromzoneid=0){ 

		$data['common']=$this->common_first($zoneid,$fromzoneid);		

		$data['zoneid']=$data['common']['zoneid'];

		$approve_csv_sql = "SELECT auto_approve_csvupload FROM zone_preferences WHERE zoneid=".$data['zoneid'];	

		$approve_csv_query = $this->db->query($approve_csv_sql);

		$data['approve_csv']=$approve_csv_query->result_array();

		$data['right_container'] = $this->load->view("realtor/view_uploaded_home_sold", $data, true); 

		$this->common($data);			

	}

	

	// - CSV upload data view section

	 

	public function realtordetail_front($userId,$zoneId){//var_dump($userId);exit;

		

		$sql ="select id from realtor where userid='".$userId."' and zoneid='".$zoneId."'";

		$query = $this->db->query($sql);

		$realtor_id = $query->result_array();//var_dump($realtor_id);exit;

		echo $realtor_id['0']['id'];

		

	}

	

}