<?php

### Created by Athena eSolutions

error_reporting(0);

// require_once(dirname(__FILE__)."/welcome.php"); 



class Highschoolsportsdashboard extends CI_Controller

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

        $this->load->model("admin/Templates", "template");

        $this->load->model("admin/Business_type_model", "business_type");

		$this->load->model("admin/Category_management_model", "category_model");

		$this->load->model("Category_new_model");

		$this->load->model("emailnotice/Email_notice", "email_notice"); 

		$this->load->model("organization/Organization_model", "org_model");

		$this->load->model("zone/Zone_model", "zone_model");

		$this->load->model("User", "user");

		

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

	

	function common_first($org_id=0,$fromzoneid=0){ // 

		$data=array();

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}



        if (empty($user)) {

        	redirect('/', 'refresh');

        }

		//$data['top_header_name']=$this->org_model->organization_details($org_id); //var_dump($data['top_header_name']);

		$data['where_from']='organization';

		$data['from_zoneid']=isset($fromzoneid) ? $fromzoneid : 0;

		

		if($data['from_zoneid']!=0){

			$data['top_header_name']=$this->zone_model->get_zone($data['from_zoneid']); //var_dump($data['top_header_name']);

			$data['sub_header_name_from_zone']=$this->org_model->organization_details($org_id);

			$data['from_where']='zone_organization'; 

		}else{

			$data['top_header_name']=$this->org_model->organization_details($org_id); //var_dump($data['top_header_name']);

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

		$data['organizationid']=$org_id;  

		$organization_status= $this->announcements->organization_status($org_id); 

		$data['organization_status']=$organization_status[0]['approval'];

		$data['zone']=$this->announcements->organization_zone($org_id);

		$userzoneid=$data['zone'][0]['zoneid']; 

		$data['org_name']=$data['zone'][0]['name'];

		$data['org_owner_id']=$data['zone'][0]['userid']; 

		$data['zoneid']=$userzoneid; //var_dump($data['zoneid']); exit;

		//$data['zoneid']='';  

		// newly added

		$data['getall_category']=$this->announcements->getall_category($org_id); 

		

		$session_login_details=$this->session->userdata('session_login_details');

		$data['login_type']=$session_login_details['type'];

		$data['login_id']=$session_login_details['id'];

		

		$newsessiondata = array(

                   'usergrid'=>$usergrid,

                   'userzoneid'=>$userzoneid

        );

		$this->session->set_userdata('usersessiondata',$newsessiondata);  

		return $data;

	}

	

	function common($info){		

	//	$data['left_container'] = $this->load->view("default/common/left_panel_organization", $info, true); 

		$data['side_dashboard_container'] = $this->load->view("default/common/left_panel_organization", $info, true); 

        $data['content'] = $this->load->view("content_new", $data, true);

		$data['header']= $this->load->view("default/common/header", $data);

		

	}

	

	################################################  Organization Details Part Start ####################################################



# + This will show the dashboard of an Organization 

	public function organizationdetail($org_id=false,$fromzoneid=0){ 	

	

		$data['common']=$this->common_first($org_id,$fromzoneid);  
		// echo '<pre>';	var_dump($data['common']);	 exit;	

		//$data['state_list'] = $this->states->get_state_dropdown();

		$data['organization_owner_detail']=$this->org_model->organization_owner_details($org_id); 



		$data['right_container'] = $this->load->view("organization/dashboard", $data, true); //echo '<pre>'; var_dump($data); exit;

		$this->common($data);

	}

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

		$this->db->where('id', $userid);

        $this->db->update('users', $userData);

		echo($this->dr->GetDR("Updating Profile", "", "", "0"));

		//$this->user->update_profile($data);

	}

# - update profile



# + update_password

	public function update_password(){ //var_dump($_REQUEST); exit;

		$userid = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : '' ;

		$username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '' ;

		$current_pass = !empty($_REQUEST['current_pass']) ? $_REQUEST['current_pass'] : '';

        $new_pass = !empty($_REQUEST['new_pass']) ? $_REQUEST['new_pass'] : '';

        $confirm_pass = !empty($_REQUEST['confirm_pass']) ? $_REQUEST['confirm_pass'] : '';

		if($new_pass != $confirm_pass){ 

			$message = "Your New Password and Confirm Password are not same. For this No Changes Made!";

		}else{ 

			//$identity = $this->session->userdata($this->config->item('identity', 'ion_auth')); // session is set for zone owner even if zone owner log into org dashboard //

			$change = $this->ion_auth->change_password($username, $current_pass, $new_pass);				

			if ($change)

			{

				$message = "Update Successful";

			}

			else

			{

				$message = "No Changes Made!";

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

	public function save_org_photo(){ 

		$data=array();

		$data['image_name']=!empty($_REQUEST['uploadedInput']) ? $_REQUEST['uploadedInput'] : '';

		$data['org_id']=!empty($_REQUEST['organizationid']) ? $_REQUEST['organizationid'] : 0;

		$data['cat_id']=!empty($_REQUEST['allcategories']) ? $_REQUEST['allcategories'] : '';		

		$data['status']=($_REQUEST['status'] != '') ? $_REQUEST['status'] : 1;		

		$data['description']=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';

		$data['save_banner']=$this->org_model->save_org_photo_new($data['image_name'],$data['org_id'],$data['cat_id'],$data['status'],$data['description']);

	}

	// viewing org photos in org dashboard 

	public function org_photo_by_catid(){

		//var_dump($_REQUEST); exit;

		$data=array();

		$data['cat_id'] = !empty($_REQUEST['catid']) ? $_REQUEST['catid'] : '';

		$data['org_id'] = !empty($_REQUEST['orgnid']) ? $_REQUEST['orgnid'] : '';

		$data['all_banner'] = $this->org_model->org_photo_by_catid($data['cat_id'],$data['org_id']); //var_dump($data['all_banner']); exit;

		$result = $this->load->view('organization/subpage/viewphotos', $data, true);		

		echo($this->dr->GetDR("","", $result, "0"));

	}

	// save uploaded image into folder

	function save_banner_image($org_id){ 

		$uploadedImage=$_FILES['imgfile']['name'];

		$var = explode('.',$uploadedImage);

		$ext = strtolower(array_pop($var));

		$imagename=time().rand().'.'.$ext;

		$rand = mt_rand( 100, 999 );

		$target = "./uploads/organizationphoto/$org_id/";

		

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

	// changing the image orders for org

	public function org_photo_order_change(){ 

		$updateRecordsArray 	= $_REQUEST['order']; //var_dump($updateRecordsArray); exit;

		$org_id 				= $_REQUEST['orgnid']; 

		$cat_id					= $_REQUEST['cat_id'];

		$this->org_model->org_photo_order_change($updateRecordsArray,$org_id,$cat_id);

		

	}

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

	

	

}