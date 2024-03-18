<?php
class groupDealsmodel extends CI_Model{
	public function __construct(){
		parent::__construct();
        $this->load->library('ion_auth');
		$this->load->helper('url');
        $this->load->database();
		$this->load->helper('array');
    }
	
	
	######################################################################
}
?>