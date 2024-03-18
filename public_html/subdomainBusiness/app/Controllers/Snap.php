<?php

class Snap extends CI_Controller {

    function __construct(){

		

        parent::__construct();



        $this->load->library('ion_auth');



        $this->load->library('session');



        $this->load->library('form_validation');



        $this->load->helper('url');



        $this->load->helper('time_helper');
		$this->load->model("admin/Business_type_model", "business_type");


        $this->load->model("Dialog_result", "dr");



        $this->load->model("admin/Ads_model", "ad");



   		$this->load->model("admin/Announcement_model", "announcements");

        $this->load->model("admin/Sales_zone", "sales_zone");

        $this->load->model("States", "states");

		



        $this->load->model("admin/Category_model", "category");



        $this->load->model("admin/Users", "users");



        $this->load->model("admin/Business_type_model", "business_type");



        $this->load->model("admin/Sales_rep", "sales_reps");



        $this->load->model("admin/Business", "business");



        $this->load->model("admin/Sales_zone", "zone");

		$this->load->model("admin/Category_management_model", "category_model");

		$this->load->model("admin/Zonal_ads", "zonalads");//added by koushik chhetri to fetch the ads against the zoneid

		$this->load->model("admin/Snap_model", "snap");



        $this->load->config('security', TRUE);



        $this->load->database();





        @set_magic_quotes_runtime(0); // Kill magic quotes



        



    }

	function index(){

    }

	function get_all_zone(){

		$query = $this->db->query("SELECT * FROM sales_zone");

        $result = $query->result_array();

        return $result;



	}

	function display_org_in_zone($zoneid=false){ 

		$data = array();

		$data['zone_id']=$zoneid;

		$auser = $this->ion_auth->user()->row();

		$data['userid']=$auser->user_id;

		$data['org_list'] = $this->snap->get_org_in_zone($zoneid,$auser->user_id); //var_dump($data['org_list']);

		//$data['snap_user_org_status']=$this->snap->snap_user_org_status($zoneid); //var_dump($data['org_list']);

		$this->load->view('snap_org_details', $data);

	}

	

	function update_status_email_from_org($zoneid=false,$orgid=false,$userid=false,$status=false){ 

		$data = array();

		$data['zone_id']=$zoneid;

		$auser = $this->ion_auth->user()->row();

		$data['userid']=$auser->user_id;

		$data['snap_user_org_status']=$this->snap->update_status_email_from_org($orgid,$userid,$status);          			

		//var_dump($data['snap_user_org_status']);

		$data['org_list'] = $this->snap->get_org_in_zone($zoneid,$auser->user_id); //var_dump($data['org_list']);		

		$this->load->view('snap_org_details', $data);

	}

	

	function display_snap_list_in_zone($zoneid=false){ //echo $zoneid ;

		$data = array();

		$data['zone_id']=$zoneid;

		$auser = $this->ion_auth->user()->row(); 

		$data['approved_bus'] = $this->snap->get_all_businesses_approved_in_snap($zoneid,$auser->user_id);

		//var_dump($data['approved_bus']);		

		$this->load->view('snap_list_details', $data);

	}

	function update_status_email_from_business($businessid,$zoneid,$userid,$status){ //echo $zoneid ;

		$data = array();

		$auser = $this->ion_auth->user()->row();

		$data['snap_user_business_status']=$this->snap->update_snap_user_business_status($businessid,$zoneid,$userid,$status);

		$data['approved_bus'] = $this->snap->get_all_businesses_approved_in_snap($zoneid,$auser->user_id);				

		$this->load->view('snap_list_details', $data);

	}

	function display_newsletter_list_in_zone($zoneid=false){ 

		$data = array();

		$data['zone_id']=$zoneid;

		$auser = $this->ion_auth->user()->row(); 

		$data['approved_bus'] = $this->snap->get_all_businesses_approved_in_newsletter($zoneid,$auser->user_id);				

		$this->load->view('newsletter_list_details', $data);

	}

	function update_status_newsletter_from_business($businessid,$zoneid,$userid,$status){ //echo $zoneid ;

		$data = array();

		$auser = $this->ion_auth->user()->row();

		$data['snap_user_business_status']=$this->snap->update_newsletter_business_status($businessid,$zoneid,$userid,$status);

		$data['approved_bus'] = $this->snap->get_all_businesses_approved_in_newsletter($zoneid,$auser->user_id);				

		$this->load->view('newsletter_list_details', $data);

	}

}