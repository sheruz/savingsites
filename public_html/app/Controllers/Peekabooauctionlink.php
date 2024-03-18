<?php

error_reporting(0);
//require_once(dirname(__FILE__)."/welcome.php"); 

class Peekabooauctionlink extends CI_Controller{
		
		
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
			$this->load->helper('string');
			
			$this->load->model("peekaboo/Peekaboo_model", "peekaboomodel");
			
			$this->load->config('security', TRUE);		
			$this->load->database();
		}
		
		function clear_cache(){    
			$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
			$this->output->set_header("Pragma: no-cache");
		}
		public function index(){
		
		}
		
		/*
		 *	Redirect to peekaboo auction page
		 */
		public function gotoPeekaboo($url = false){
				if($url != ''){
					$checkurl = $this->peekaboomodel->checkLink($url) ;
					if(!empty($checkurl)){
						header('Location:'.PEEKABOO_URL.'ss_redirect_link?bus_id='.$checkurl[0]['id']) ;		// Redirect to peekaboo site	
					}else{
						header("location:javascript://history.go(-1)");											// Back to previous page
					}
				}else{
					header("location:javascript://history.go(-1)");												// Back to previous page
				}
		}
	
}

?>