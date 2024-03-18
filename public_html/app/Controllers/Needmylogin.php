<?php 
### This page is modified by Athena eSolutions
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Needmylogin extends CI_Controller{
	
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper("time_helper");
		$this->load->library('ion_auth');
		$this->load->library('session');
       /* $this->load->model("admin/Category_model", "category");
        $this->load->model("admin/Announcement_model", "announcements");
        $this->load->model("admin/Ads_model", "ads");
        $this->load->model("admin/Sales_zone", "sales_zone");
		$this->load->model("States", "states");
		$this->load->model("admin/Business", "business");
		$this->load->model("admin/Ads_model", "ad");*/
		$this->load->model("Zips", "zip");
		$this->load->model("admin/Category_management_model", "category_model");
		$this->load->model("Samplelayoutmodel","obj_samplelayoutmodel"); // Added Athena eSolutions
        $this->load->database();
    }

    public function index(){
		
		$theme_cookie_value=''; $zoneid_cookie_value='';
		$theme_cookie_value=$this->input->cookie('theme', TRUE);
		$zoneid_cookie_value=$this->input->cookie('zoneid', TRUE);
		
		
		if($theme_cookie_value != '' ){
			if($theme_cookie_value=='DT'){
				$data['css_value']="assets/stylesheets/up_styles.css";
				$data['css_vertical_value']="assets/stylesheets/up_vertical_menu.css";
				$data['css_value_for_blue']="";
				$data['barter_button']='green'; $data['job_button']='green';
			}else if($theme_cookie_value=='MT'){
				$data['css_value']="assets/stylesheets/styles_maroon_skin.css";
				$data['css_vertical_value']="assets/stylesheets/maroon_vertical_menu.css";
				$data['css_value_for_blue']="";
				$data['barter_button']='red'; $data['job_button']='red';
			}else if($theme_cookie_value=='BT'){
				$data['css_value']="assets/stylesheets/up_styles_blue.css";
				$data['css_value_for_blue']="assets/stylesheets/styles_blue_skin.css";
				$data['css_vertical_value']="assets/stylesheets/blue_vertical_menu.css";
				$data['barter_button']='blue'; $data['job_button']='blue';
			}
			
		}
		$data['theme_cookie_value']=$theme_cookie_value;
		
		$this->load->view('needmylogin',$data);
    }
	
	
	function change_theme(){
		//$zoneid=$_REQUEST['zoneid'];
		$themeid=$_REQUEST['themeid'];
		//var_dump($themeid); exit;
		if (!get_cookie('')) {
			// cookie not set, first visit

			// create cookie to avoid hitting this case again
			$cookie = array(
				'name'   => 'theme',
				'value'  => $themeid,
				'expire' => time()+86500,
				'domain' => '',
				'path'   => '/',
				'prefix' => '',
			);
			/*$cookie = array(
				'name'   => 'zoneid',
				'value'  => $zoneid,
				'expire' => time()+86500,
				'domain' => '',
				'path'   => '/',
				'prefix' => '',
			);*/
			set_cookie($cookie);
			
			/*$cookie = array(
				'name'   => 'zoneid',
				'value'  => $zoneid,
				'expire' => time()+86500,
				'domain' => '',
				'path'   => '/',
				'prefix' => '',
			);
			set_cookie($cookie);*/
			
			//var_dump($_COOKIE);
		} 
		$result = 1;
		//echo($this->dr->GetDR("","", $result, "0"));
		echo $result;
	}
	
	function zip_to_zone(){
		$zip =(!empty($_REQUEST['zip']))? $_REQUEST['zip'] : "";
		$zone = $this->zip->zip_to_zone($zip);
		if(!empty($zone)){
			$_zone_id=$zone[0]['id'];
		}else{
			$_zone_id=0;
		}
		echo $_zone_id;
	}
}

