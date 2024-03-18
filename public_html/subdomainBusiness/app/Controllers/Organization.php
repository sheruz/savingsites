<?php

### Created by Athena eSolutions

error_reporting(0);

require_once(dirname(__FILE__)."/welcome.php"); 



class Organization extends CI_Controller

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

		//$this->load->model("admin/business_dashboard1", "business_dashboard1");

        $this->load->model("admin/Templates", "template");

        $this->load->model("admin/Business_type_model", "business_type");

		$this->load->model("admin/Category_management_model", "category_model");

		$this->load->model("Category_new_model");

		//$this->load->model("Organization_model", "org_model");

		// new model

		$this->load->model("organization/Organization_model", "org_model");

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

	

	function organization_common_first($org_id=0,$fromzoneid=0){

		$data=array();

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}



        if (empty($user)) {

        	redirect('welcome/index', 'refresh');

        }

		$data['organizationname']=$this->org_model->organization_details($org_id);

		

		$data['from_zoneid']=isset($fromzoneid) ? $fromzoneid : 0;			

		//$data['from_zone']= $this->sales_zone->get_zone($fromzoneid); 

		$data['from_zone']=0;

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

		$data['zoneid']=$userzoneid; 

		// newly added

		$data['getall_category']=$this->announcements->getall_category($org_id); 

		

		

		

		$newsessiondata = array(

                   'usergrid'=>$usergrid,

                   'userzoneid'=>$userzoneid

        );

		$this->session->set_userdata('usersessiondata',$newsessiondata);  

		return $data;

	}

	

	function organization_common($info){		

		$data['left_container'] = $this->load->view("default/common/left_panel_organization", $info, true); 

		$data['side_dashboard_container'] = $this->load->view("default/common/left_aside_admindashboard", $info, true); 

        $data['content'] = $this->load->view("content_new", $data, true);

		$data['header']= $this->load->view("default/common/header", $data);

		

	}

	

	################################################  Organization Details Part Start #################################################################

	public function dashboard($org_id=false,$fromzoneid=0){ 			

		

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);		 	

		$data['state_list'] = $this->states->get_state_dropdown();

		$data['organization_owner_detail']=$this->org_model->organization_owner_details($org_id); 		

		$data['right_container'] = $this->load->view("organization/dashboard", $data, true); 

		$this->organization_common($data);

			

	}

	# + update profile

	public function update_profile(){

		$data=!empty($_REQUEST) ? $_REQUEST : '';

		$this->user->update_profile($data);

	}

	# + update_password

	public function update_password(){

		$userid = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : '' ;

		$current_pass = !empty($_REQUEST['current_pass']) ? $_REQUEST['current_pass'] : '';

        $new_pass = !empty($_REQUEST['new_pass']) ? $_REQUEST['new_pass'] : '';

        $confirm_pass = !empty($_REQUEST['confirm_pass']) ? $_REQUEST['confirm_pass'] : '';

		if($new_pass != $confirm_pass){

			$message = "Your New Password and Confirm Password are not same. For this No Changes Made!";

		}else{

			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($identity, $current_pass, $new_pass);				

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

	################################################  Organization Details Part End #################################################################

		

	################################################  Organization Category/Sub category Part Start #######################################################

	// + Create New Category

	public function new_category($org_id=false,$fromzoneid=false){		

		$data['organizationid']=$org_id;

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);		

		$data['right_container'] = $this->load->view("organization/new_category", $data, true);

		$this->organization_common($data);

	}

	// + Create New Subc-ategory

	public function new_subcategory($org_id=false,$fromzoneid=0){

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/new_subcategory", $data, true);

		$this->organization_common($data);

	}

	// + View All Category/Subcategory

	public function view_category_subcategory($org_id=false,$fromzoneid=0){

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/view_category_subcategory", $data, true);

		$this->organization_common($data);

	}

	################################################  Organization Category/Sub category Part ends #######################################################

	

	################################################  Organization Announcement Part Start #################################################################

	

	public function new_announcement($org_id=false,$fromzoneid=0){				

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);

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

		$this->organization_common($data);

	}

	

	public function view_announcement($org_id=false,$fromzoneid=0){

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);  

		//var_dump($data['organization_common']); var_dump($data['organization_common']['zoneid']);

		$lowerlimit=0; $upperlimit=100;

		$data['announcement_list'] = $this->announcements->get_announcements_for_organization($data['organization_common']['zoneid'],$org_id,$lowerlimit,$upperlimit);

		

		$data['right_container'] = $this->load->view("organization/view_announcement", $data, true);

		$this->organization_common($data);

	}

	

	public function edit_announcement($org_id=false,$fromzoneid=0,$ann_id){

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);

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

		$this->organization_common($data);

	}

	################################################  Organization Announcement Part End #################################################################

	

	################################################  Organization Uploaded Letters Part Start #################################################################	

	public function organization_letters($org_id=0, $fromzoneid=0){

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);		

		$data['right_container'] = $this->load->view("organization/view_letters", $data, true);

		$this->organization_common($data);		

	}

	################################################  Organization Uploaded Letters Part End #################################################################

	

	################################################  Organization Interest Group Part Start #################################################################

	# + New interest Group

	public function new_ig($org_id=false,$fromzoneid=0){ 	

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);		

		$data['right_container'] = $this->load->view("organization/create_interest_group", $data, true);

		$this->organization_common($data);

	}

	

	public function view_ig($org_id=false,$fromzoneid=0){ 	

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/view_interest_group", $data, true);

		$this->organization_common($data);

	}

		

	public function view_ig_visibility($org_id=false,$fromzoneid=0){ 	

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/interest_group_visibility", $data, true);

		$this->organization_common($data);

	}

	

	

	

	

	################################################  Organization Interest Group Part End #################################################################

	

	

	################################################  Organization Email Notice Part Start #################################################################

	public function createemailnotice($org_id=false,$fromzoneid=0){ 	

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/create_email_notice", $data, true);

		$this->organization_common($data);

	}

	public function viewemailnotice($org_id=false,$fromzoneid=0){ 	

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/view_email_notice", $data, true);

		$this->organization_common($data);

	}

	public function sendemailnotice($org_id=false,$fromzoneid=0){ 	

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/send_email_notice", $data, true);

		$this->organization_common($data);

	}

	public function historyemailnotice($org_id=false,$fromzoneid=0){ 	

		$data['organization_common']=$this->organization_common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/history_email_notice", $data, true);

		$this->organization_common($data);

	}

	################################################  Organization Email Notice Part End #################################################################

	/*public function get_jotform_code(){

		$this->load->view('organization/sell_pboo_credits');

	}*/

	

	

	

}

