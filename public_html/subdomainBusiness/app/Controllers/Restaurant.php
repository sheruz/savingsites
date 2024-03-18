<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Restaurant extends CI_Controller
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
		$this->load->model("banner/Banner_model", "banner");
		$this->load->model('dining/Diningmodel','snapDining');
		
        $this->load->database();
    }
	  
	function menu($zoneId){
		//echo $zoneId; 
		$data['zoneid'] = $zoneId;
		$data['link_path']= $this->config->item('link_path');
    	$data['base_url'] = $this->config->item('base_url');
    	$data['theme'] 	= "blue"; 
		$data['page'] 	= 'Old Glory';
		$data['from_where']	= 'sponsor_businesses_menu_home_page';
		$data['css']	= 'style';
		$zone_details = $this->sales_zone->get_zone($zoneId); //var_dump($zone_details);exit;
		//$zoneid =$zone;
		$zone_name=$zone_details->seo_zone_name;
		$zone_name=str_replace(' ','-',htmlentities(urldecode($zone_name)));
		$display_zone_name = $zone_details->name;
		$data['zone_name'] 	= $display_zone_name;
		$data['active_banner_mobile'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','1','2');
		$data['active_banner_desktop'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','1','1');
		
    	$data['head'] 			= $this->load->view("includes/head",$data); 
        $data['header'] 		= $this->load->view("includes/header", $data);
        $data['modals'] 		= $this->load->view("includes/modals",$data);
        $data['slider'] 		= $this->load->view("includes/slider", $data);
        $data['offer_header'] 	= $this->load->view("includes/offer_header",$data);
        $data['directory'] 		= $this->load->view("directory",$data);
        $data['footer'] 		= $this->load->view("includes/footer", $data);
	}
}

