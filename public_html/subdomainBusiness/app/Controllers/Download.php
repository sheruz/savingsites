<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Download extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->library('ion_auth');

        $this->load->library('session');

        $this->load->library('form_validation');

        $this->load->helper('url');

        $this->load->helper("time_helper");

        $this->load->model("admin/Category_model", "category");

        $this->load->model("admin/Announcement_model", "announcements");

        $this->load->model("admin/Ads_model", "ads");

        $this->load->model("admin/Sales_zone", "sales_zone");

        $this->load->model("States", "states");

        $this->load->database();

		$this->load->helper('download');

    }

    public function index($zone = false){

		

	}

	function municipality(){

		$data =file_get_contents("downloads/Letter_to_the_Municipality.docx");

		$name = 'Letter_to_the_Municipality.docx';

		force_download($name, $data); 

	}

	function new_business_added(){

		$data =file_get_contents("downloads/Letter_to_New_Business_Added.docx");

		$name = 'Letter_to_New_Business_Added.docx';

		force_download($name, $data); 

	}

	function sales_info(){

		$data =file_get_contents("downloads/Savings_Sites_Sales_Info_1_16_13.docx");

		var_dump($data);

		$name = 'Savings_Sites_Sales_Info_1_16_13.docx';

		force_download($name, $data); 

	}

	function local_advertising(){

		$data =file_get_contents("downloads/Comparison_of_Local_Advertising.xlsx");

		$name = 'Comparison_of_Local_Advertising.xlsx';

		force_download($name, $data); 

	}

}



