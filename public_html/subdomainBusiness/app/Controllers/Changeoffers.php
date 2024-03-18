<?php

 if (!defined('BASEPATH')) exit('No direct script access allowed');

 class Changeoffers extends CI_Controller {

 	/**

 	  * @desc constructor function to load required data

 	*/

 	public function __construct() {

 		parent::__construct();

 		$this->load->helper('url');

 		//$this->load->model('groupDeals/groupDealsmodel');

 		//$this->load->model("admin/Ads_model", "ad");

 		$this->load->database();

        $this->load->library('session');


                $this->load->library('form_validation'); 

        $this->load->library('pagination');

        $this->load->library('email');

        $this->load->library('excel');

        //$this->load->library('session');

        $this->load->library('image_lib');

        

        $this->load->helper('url');

        $this->load->helper('ckeditor');

        $this->load->helper("time_helper");

        $this->load->helper('cookie');

        $this->load->helper('url');

        $this->load->helper('download');

        $this->load->helper('string');

        

        $this->load->model("States","states");

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

        $this->load->model("emailnotice/Snap_email_notification","snap_email"); 

        $this->load->model("zone/Zone_model", "zone_model");

        $this->load->model("business/Business_model", "business_model");

        $this->load->model("User", "user");
        

        $this->load->config('security', TRUE);      




 	}

 	/**

 	  * @desc method to load home page 



 	*/

 	public function index($zoneId="") { 		

 
 		$this->load->view('changeOffers/header');

 		$this->load->view('changeOffers/home');

 		$this->load->view('changeOffers/footer');

 		

 	}



    public function emailing(){

// print_r(base_url());

        $header = array();
 

        $header['pg']  = 'emailing';



        $this->load->view('changeOffers/header',$header);

        $this->load->view('changeOffers/emailing');

        $this->load->view('changeOffers/footer');

    }

    

    public function broadcast(){



        $header = array();

 

        $header['pg']  = 'broadcast';



        $this->load->view('changeOffers/header',$header);

        $this->load->view('changeOffers/broadcast');

        $this->load->view('changeOffers/footer');

    }



    public function optedin(){



        $header = array();

        //$data['zoneId']  = $zoneId;

        $header['pg']  = 'opted-in';



        $this->load->view('changeOffers/header',$header);

        $this->load->view('changeOffers/opted-in');

        $this->load->view('changeOffers/footer');



    }



    public function booking(){



        $header = array();

        //$data['zoneId']  = $zoneId;

        $header['pg']  = 'booking';



        $this->load->view('changeOffers/header',$header);

        $this->load->view('changeOffers/booking');

        $this->load->view('changeOffers/footer');



    }



    public function schedule(){



        $header = array();

        //$data['zoneId']  = $zoneId;

        $header['pg']  = 'schedule';



        $this->load->view('changeOffers/header',$header);

        $this->load->view('changeOffers/schedule');

        $this->load->view('changeOffers/footer');



    }



    public function auctions(){



        $header = array();

        //$data['zoneId']  = $zoneId;

        $header['pg']  = 'auctions';



        $this->load->view('changeOffers/header',$header);

        $this->load->view('changeOffers/auctions');

        $this->load->view('changeOffers/footer');

    }



    public function certificate(){



        $header = array();

        //$data['zoneId']  = $zoneId;

        $header['pg']  = 'certificate';



        $this->load->view('changeOffers/header',$header);

        $this->load->view('changeOffers/certificate');

        $this->load->view('changeOffers/footer');

    }



    public function discounts(){



        $header = array();

        //$data['zoneId']  = $zoneId;

        $header['pg']  = 'discounts';



        $this->load->view('changeOffers/header',$header);

        $this->load->view('changeOffers/discounts');

        $this->load->view('changeOffers/footer');

    }



    public function gallary(){



        /*$header = array();

        $data['zoneId']  = $zoneId;

        $header['pg']  = 'gallary';*/

        //$_SESSION['header'] = "offer_header";

        $url = base_url('image_gallery/index.php?controller=pjAdmin&action=pjActionIndex');

        redirect($url,'refresh');

    }



    public function menuMaker(){



        $url = base_url('restaurantMenuMaker/index.php?controller=pjAdminProducts&action=pjActionIndex');

        redirect($url,'refresh');

    }



 	 	

 	

 }