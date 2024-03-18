<?php



error_reporting(1);

### This page is created by Athena eSolutions

class DwollaConfig extends CI_Controller {

	var $id;

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

       // //$this->load->model("admin/business_dashboard1", "business_dashboard1");

		$this->load->model("admin/Dwollaconfiguration", "dw");

        

        $this->tierI = $this->config->item('Tier_I');

        $this->tierII = $this->config->item('Tier_II');

        $this->tierIII = $this->config->item('Tier_III');

   

    }

	

    function save_dwolla_facilitator_config()

    {

    	

		//$id = empty($_REQUEST['faci_id']) ? "-1" : $_REQUEST['faci_id'];

		$id = $_REQUEST['faci_id'];  

    	$faci_email = $_REQUEST['faci_email']; 

    	$faci_phone = $_REQUEST['faci_phone']; 

		$isupdate = $_REQUEST['isupdate']; 

    

    	$data = array(

    			 "userid"=> $id,

				 "dw_email" => $faci_email,

    			 "dw_phone" => $faci_phone

    	);

    	

    	if($isupdate==1)

    	{

			

    		$this->db->where('userid', $id);

    		$this->db->update('dwollasellerfacilitatoraccount', $data);

    	}else if($isupdate==0)

    	{

    		$this->db->insert('dwollasellerfacilitatoraccount', $data);

    	}

    	//exit;

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

			//echo $this->config->item('base_url'); exit;

           // redirect($this->config->item('base_url') . (!empty($zone) ? "index.php?zone=".$zone : ""), 'refresh');

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

		//echo $this->ion_auth->user()->row()->id; exit;

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/dwolla.inc.js");

		$this->dw->setid($this->ion_auth->user()->row()->id);

		$this->dw->setdwolla_facilitator_details();

		

        $data['dwollafacilitator'] = $this->dw;

		//var_dump($data['dwollafacilitator']);

        $data["scripts"] = $scripts;

       

		

		//$data['id'] = $this->ion_auth->user()->row()->id;

		

        $data["page_name"] = "dwollaconfig";

        $this->load->view("admin/header", $data);

        $this->load->view("admin/admin_buttons", $data);

        //$this->load->view("admin/dwolla.inc.php", $data);

        $this->load->view("admin/dwolla.table.php",$data);

        $this->load->view("admin/footer");

		//var_dump($data);

     //   redirect("admin");

    }

}