<?php

require_once(dirname(__FILE__)."/welcome.php"); // the controller route.

class Dashboards_category_management extends CI_Controller
{
	public function __construct()

    {

        parent::__construct();

        $this->load->library('ion_auth');

        $this->load->library('session');

        $this->load->library('form_validation');

        

		$this->load->helper('url');

        $this->load->helper('ckeditor');

        $this->load->helper("time_helper");

        

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

		

		$this->load->config('security', TRUE);

		

        $this->load->database();



    }

		

	public function add_new_cat_zone(){	

			$data['zoneid']=$_REQUEST['zoneid'];

			//var_dump($data['zoneid']);

			$result = $this->load->view('categories/new_category_add', $data, true);

			echo($this->dr->GetDR("","", $result, "0"));

	}

}

?>