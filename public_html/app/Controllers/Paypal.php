<?php
class Paypal extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model("Dialog_result", "dr");
        $this->load->database();
        $this->load->helper("time_helper");
        $this->load->config('security', TRUE);
        //$this->load->model("admin/business_dashboard1", "business_dashboard1");
        
        $this->tierI = $this->config->item('Tier_I');
        $this->tierII = $this->config->item('Tier_II');
        $this->tierIII = $this->config->item('Tier_III');
   
    }
	
    function save_paypal_config()
    {
    	$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
    	$paypal_url = $_REQUEST['paypal_url'];
    	$business_email = $_REQUEST['business_email'];
    
    	$data = array(
    			"paypal_url" => $paypal_url,
    			"business_email" => $business_email
    	);
    	
    	if(!empty($id) && $id > 0)
    	{
    		$this->db->where('id', $id);
    		$this->db->update('paypal_configuration', $data);
    	}
    	else
    	{
    		$this->db->insert('paypal_configuration', $data);
    	}
    	exit;
    }
    
    function index($zone = false)
    {
       if (!$this->ion_auth->logged_in())
        {
            //redirect them to the login page
            //redirect('auth/login', 'refresh');
			redirect(base_url(), 'refresh');
        }
        elseif (!$this->ion_auth->in_group(array( "Tier I", "Tier II" )))
        {
            //redirect them to the home page because they must be an administrator to view this
            redirect($this->config->item('base_url') . (!empty($zone) ? "index.php?zone=".$zone : ""), 'refresh');
        }
        
        if($this->ion_auth->in_group("Tier I"))
        {
            $tiers = "Tier I";
        }
        else if($this->ion_auth->in_group("Tier II"))
        {
            $tiers = "Tier II";
        }
        else
        {
            $tiers = "Tier III";
        }
     
        $data = array();
        $data['tier'] = $tiers;
        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/paypal.inc.js");
        $data['paypal'] = $this->business_dashboard1->get_all_paypal();
        $data["scripts"] = $scripts;
        $data["firstName"] = $this->ion_auth->user()->row()->first_name;
        $data["page_name"] = "paypal";
        $this->load->view("admin/header", $data);
        $this->load->view("admin/admin_buttons", $data);
        //$this->load->view("admin/paypal.inc.php", $data);
        $this->load->view("admin/paypal.table.php",$data);
        $this->load->view("admin/footer");
     //   redirect("admin");
    }
}