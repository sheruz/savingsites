<?php 
### This page is created by Athena eSolutions
if (!defined('BASEPATH')) exit('No direct script access allowed');
class DirectoryOwners extends CI_Controller{
	
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper("time_helper");
		$this->load->library('ion_auth');       
        $this->load->database();
    }

    public function index(){
		/*$user = $this->ion_auth->user()->row(); 
		$data['user']=$user;
		$data['fname']=$user->first_name;*/
        
        $this->load->view('DirectoryOwners');
    }
}
?>

