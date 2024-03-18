<?php 
### This page is modified by Athena eSolutions
if (!defined('BASEPATH')) exit('No direct script access allowed');
class SampleLayout extends CI_Controller{	

	private $arr_ad=array();
    public function __construct()
    {
        parent::__construct();
		$this->clear_cache();
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
		
		$this->load->library('user_agent');
		
        $this->load->helper('url');
		$this->load->helper('cookie');
        $this->load->model("Zips");
        $this->load->helper("time_helper");
		//$this->load->helper("translate_helper");
        $this->load->model("admin/Category_model", "category");
        $this->load->model("admin/Announcement_model", "announcements");
		$this->load->model("admin/Zonal_ads", "zonalads");//added by koushik chhetri to fetch the ads against the zoneid
        $this->load->model("admin/Ads_model", "ads");
        $this->load->model("admin/Sales_zone", "sales_zone");
		$this->load->model("States", "states");
		$this->load->model("admin/Business", "business");
		$this->load->model("admin/Ads_model", "ad");
		$this->load->model("admin/Business_type_model", "business_type");
		$this->load->model("admin/Category_management_model", "category_model");
		$this->load->model("admin/Snap_model", "snap");
		$this->load->model("admin/Users", "users");
		$this->load->model("Directory_model","directory"); // Added Athena eSolutions
		$this->load->model("banner/Banner_model", "banner");
        $this->load->database();
		//$this->load->helper('download');
    }
   /* public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->helper('cookie');
        $this->load->helper("time_helper");
		$this->load->library('ion_auth');
		$this->load->model("admin/Category_management_model", "category_model");
		$this->load->model("Directory_model","directory"); // Added Athena eSolutions
		$this->load->model("banner/Banner_model", "banner");
        $this->load->database();
    }*/
	function clear_cache()
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }
    public function index(){ 
		$data=array();
		$link_path = $this->config->item('link_path');
		$data['link_path']= $link_path ;		
		/*$user = $this->ion_auth->user()->row();
		$data['user']=$user;
		$data["user_id"] = $user->user_id;
		if($auser->first_name!=''){
		$data["firstName"] = $user->first_name;
		}else{
			$data["firstName"] = $user->username;
		}*/
		$theme_cookie_value=''; $zoneid_cookie_value='';
		$theme_cookie_value=$this->input->cookie('sample_layout_theme_cookie', TRUE); //var_dump($theme_cookie_value);				
		if($theme_cookie_value != '' ){ 
			if($theme_cookie_value=='DT' ){ // Blue Theme
				$data['css_value']="assets/stylesheets/up_styles_blue.css?time=".time();
				$data['css_value_for_blue']="assets/stylesheets/styles_blue_skin.css?time=".time();
				$data['css_vertical_value']="assets/stylesheets/blue_vertical_menu.css?time=".time();
				$data['barter_button']='green'; $data['job_button']='green';
			}else if($theme_cookie_value=='MT'){ //  Tan Theme, it is default theme
				$data['css_value']="assets/stylesheets/styles_maroon_skin.css?time=".time();
				$data['css_vertical_value']="assets/stylesheets/maroon_vertical_menu.css?time=".time();
				$data['css_value_for_blue']="assets/stylesheets/styles_maroon_skin.css?time=".time();
				$data['barter_button']='red'; $data['job_button']='red';
			}else if($theme_cookie_value=='BT'){ // Blue-R Theme
				$data['css_value']="assets/stylesheets/up_styles_blue.css?time=".time();
				$data['css_value_for_blue']="assets/stylesheets/styles_blue-r_skin.css?time=".time();
				$data['css_vertical_value']="assets/stylesheets/blue_vertical_menu.css?time=".time();
				$data['barter_button']='blue'; $data['job_button']='blue';
			}
			else if($theme_cookie_value=='ET'){
				/*$data['css_value']="assets/stylesheets/style_3/styles_dark_skin.css?time=".time();
				$data['css_vertical_value']="assets/stylesheets/dark_vertical_menu.css?time=".time();
                $data['barter_button']='dark'; $data['job_button']='dark';
				*/
				$data['css_value']="assets/stylesheets/style_3/styles_dark_skin.css?time=".time();
				$data['css_value_for_blue']="assets/stylesheets/style_3/styles_dark_skin.css?time=".time();
				$data['css_vertical_value']="assets/stylesheets/dark_vertical_menu.css?time=".time();
				$data['barter_button']='dark'; $data['job_button']='dark';
				
			}
		}
		$data['theme_cookie_value']=$theme_cookie_value;
		//var_dump($data);
		/*$this->load->view('samplelayout/default',$data);
		$this->load->view('samplelayout/all_script',$data);*/
        $this->load->view('sampleLayout',$data);
		//$this->load->view('samplelayout/default_footer',$data);
    }
	////function change_theme(){
		//$sample_layout_theme_cookie=$_REQUEST['SampleLayouttheme_1']; //var_dump($themeid_1); //exit;
		//if (!get_cookie('')) {
			// create cookie to avoid hitting this case again
			/*$some_cookie_array = array(
				'name'   => 'SampleLayouttheme_name',
				'value'  => $themeid_1,
				'expire' => time()+1000000,
				'domain' => '',
				'path'   => '/',
				'prefix' => '',
			);
			var_dump($some_cookie_array);
			$this->input->set_cookie($some_cookie_array);*/
			//setcookie("theme_zone",$themeid_zone,time()+86500,'/');
			//setcookie("sample_layout_theme_cookie",$sample_layout_theme_cookie,time()+86500,'/');
			//setcookie("sas","1");
			//set_cookie($cookie);
			//echo get_cookie();
			//var_dump($_COOKIE);
		//} 
		////$result = 1;
		////echo $result;

	////}	
	// for all offers
	function showalloffer_samplelayout(){
		$link_path = $this->config->item('link_path');
		$data['link_path']= $link_path ;
		$this->load->view('samplelayout/alloffers');	
	}
	//category
	function category_samplelayout(){
		$this->load->model("Category_new_model"); // Added Athena eSolutions
		$data=array();
		//$data['category_list_food'] = $this->category_model->get_category_subcategory_food_sample_layout();
		$data['category_list_food'] = $this->Category_new_model->display_food_category();
		$data['category_list_product'] = $this->Category_new_model->display_product_category();
		//var_dump($data['category_list_product']);
		/*echo '<pre>';
		print_r($data['category_list_product']);*/
		//$data['category_list'] = $this->category_model->get_category_subcategory_sample_layout();
		//var_dump($data['category_list']);
		$this->load->view('samplelayout/show_category', $data);
	}
	function organization_samplelayout(){
		$this->load->view('samplelayout/show_organization');
	}
	function blog_samplelayout(){
		$this->load->view('samplelayout/show_blog');
	}
	function peekaboo_banner_samplelayout(){
		$this->load->view('samplelayout/peekaboo_banner');
	}
	function peekaboo_control_panel_samplelayout(){
		$this->load->view('samplelayout/peekaboo_control_panel');
	}
	function show_deliver_samplelayout(){
		$this->load->view('samplelayout/delivery');
	}	
	function hight_school_sports_samplelayout(){
		$this->load->view('samplelayout/highschool_banner');
	}
	function banner_samplelayout(){
		$data=array();
		$data['active_banner']=$this->banner->home_banner();
		$this->load->view('default/header1', $data);;
	}
	function get_zone(){
		$data=array();
		$data['state']=!empty($_REQUEST['state']) ? $_REQUEST['state'] : '';
		$data['get_zone']=$this->directory->get_zone($data['state']);
		echo json_encode($data['get_zone']);
	}
	
	function get_all_state(){
		$data=array();
		$data['get_all_state']=$this->directory->get_all_state();
		echo json_encode($data['get_all_state']);
	}
	
	function save_fav_zone(){		
		$data=array();
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';
		$userid=!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0;
		$data['save_fav_zone']=$this->directory->save_favorites_directory($userid,$zoneid);
		echo json_encode($data['save_fav_zone']);
	}
	function show_fav_zone(){
		$data=array();		
		$userid=!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0;
		$data['show_fav_zone']=$this->directory->show_favorites_directory($userid);
		echo json_encode($data['show_fav_zone']);
	}
	function delete_favorites_directory(){
		$data=array();		
		$id=!empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;
		$data['delete_favorites_directory']=$this->directory->delete_favorites_directory($id);
		echo json_encode($data['delete_favorites_directory']);
	}
	function about_us_samplelayout(){
		$this->load->view('samplelayout/about_us');
	}
	function advertise_samplelayout(){
		$this->load->view('samplelayout/advertise');
	}
	function businessopportunities_samplelayout(){
		$this->load->view('samplelayout/businessopportunities');
	}
	function directoryfeature_samplelayout(){
		$this->load->view('samplelayout/directoryfeature');
	}
	function usersignup(){
		$this->load->view('samplelayout/usersignup');
	}
	
	function free_pboo_credits(){
		$data['userid'] = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$data['zoneid'] = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$this->load->view('samplelayout/free_pboo_credits',$data);
	}
	function buy_pboo_credits(){
		//$data['userid'] = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		//$data['zoneid'] = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$this->load->view('samplelayout/buy_pboo_credits');
	}
	
	
	function advertise_newpage(){
		$data['userid'] = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$data['zoneid'] = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$this->load->view('samplelayout/advertise_newpage',$data);
	}
}