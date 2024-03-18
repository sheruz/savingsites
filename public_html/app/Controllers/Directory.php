<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Directory_anish extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
		$this->load->library('session');
        $this->load->library('ion_auth');        
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
		$this->load->model("admin/Users", "users");
		$this->load->model("Category_new_model");
		$this->load->model("Organization_model", "org_model");

        $this->load->database();
    }
	public function index(){
    
	}
	function soumya(){
		$id=$_REQUEST['id'];
		var_dump($id); exit;
		$this->users->delete_newsletter_user(16); 
		
	}
}
?>