<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 class Verify extends CI_Controller {
 	/**
 	  * @desc constructor function to load required data
 	*/
 	public function __construct() {
 		parent::__construct();
 		$this->load->helper('url');
 		//$this->load->model('groupDeals/groupDealsmodel');
 		//$this->load->model("admin/Ads_model", "ad");
 		$this->load->model("peekaboo/peekaboo_model");
 		$this->load->database();
        $this->load->library('session');

 	}
 	/**
 	  * @desc method to load home page 

 	*/
 	public function index($zoneId="") {  		
         
         //echo "11111"; exit;
		$my_rtp_close_auc = $this->peekaboo_model->get_cash_certificate_value($_GET['id']);
		$bidderuser = $this->peekaboo_model->get_bidder_userid("assuser2@test.com",1); 

		$qry_site_set=$this->peekaboo_model->querySelectSingle();

		$my_rtp_auc=$this->peekaboo_model->my_close_rtp_auction($bidderuser[0]->user_id,$qry_site_set[0]->purchase_time);
		$post = array('bidderuser_id' =>$bidderuser[0]->user_id ,'certificate_id'=>$_GET['id'],'seller'=>$bidderuser[0]->user_id);
		$check_certficate=$this->peekaboo_model->check_user_certficate($post);
		echo "<pre>";
		print_r($my_rtp_close_auc);
		echo "</pre>";

		echo "<pre> bidder";
		print_r($bidderuser); 
		echo "</pre>";

		echo "<pre>";
		print_r($my_rtp_auc); 
		echo "</pre>";
		echo "Certificate details<br />";
		echo "<pre>";
		print_r($check_certficate);
		echo "</pre>";
 		$this->load->view('verify/header');
 		$this->load->view('verify/certificate');
 		$this->load->view('verify/footer');
 		
 	}

    

 	 	
 	
 }