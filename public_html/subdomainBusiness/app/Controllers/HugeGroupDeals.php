<?php

 if (!defined('BASEPATH')) exit('No direct script access allowed');

 class HugeGroupDeals extends CI_Controller {

 	/**

 	  * @desc constructor function to load required data

 	*/

 	public function __construct() {

 		parent::__construct();

 		$this->load->helper('url');
 		redirect('https://www.hugegroupdeals.com/');

 		//$this->load->model('groupDeals/groupDealsmodel');

 		//$this->load->model("admin/Ads_model", "ad");

 		$this->load->database();



 	}

 	/**

 	  * @desc method to load snap dining view



 	*/

 	public function home($zoneId="") {

 		

 		$header = array();

 		$data['zoneId']  = $zoneId;

 		$header['page']  = 'home';

 		$header['claz']  = "";

    	$header['claz1'] = "";

    	$header['claz2'] = "";

 		$this->load->view('groupDeals/header',$header);

 		$this->load->view('groupDeals/group_deals',$data);

 		$this->load->view('groupDeals/footer');

 		

 	}



 	public function about(){



 		$header = array();

 		$header['page']  = 'about';

 		$header['claz']  = "header_off";

    	$header['claz1'] = "bg__mod";

    	$header['claz2'] = "brand__md";

 		$this->load->view('groupDeals/header',$header);

 		$this->load->view('groupDeals/about');

 		$this->load->view('groupDeals/footer');

 	}



 	public function search(){



 		$header = array();

 		$header['page']  = 'search';

 		$header['claz']  = "header_off";

    	$header['claz1'] = "bg__mod";

    	$header['claz2'] = "brand__md";

 		$this->load->view('groupDeals/header',$header);

 		$this->load->view('groupDeals/search');

 		$this->load->view('groupDeals/footer');



 	}



 	public function create(){



 		$header = array();

 		$header['page']  = 'create';

 		$header['claz']  = "header_off";

    	$header['claz1'] = "bg__mod";

    	$header['claz2'] = "brand__md";

 		$this->load->view('groupDeals/header',$header);

 		$this->load->view('groupDeals/create');

 		$this->load->view('groupDeals/footer');

 	}



 	public function login(){



 		$header = array();

 		$header['page']  = 'login';

 		$header['claz']  = "header_off";

    	$header['claz1'] = "bg__mod";

    	$header['claz2'] = "brand__md";

 		$this->load->view('groupDeals/header',$header);

 		$this->load->view('groupDeals/login');

 		$this->load->view('groupDeals/footer');

 	}



 	public function contact(){



 		$header = array();

 		$header['page']  = 'contact';

 		$header['claz']  = "header_off";

    	$header['claz1'] = "bg__mod";

    	$header['claz2'] = "brand__md";

 		$this->load->view('groupDeals/header',$header);

 		$this->load->view('groupDeals/contact');

 		$this->load->view('groupDeals/footer');

 	}

 	

 	

 }