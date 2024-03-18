<?php

class Business_type extends CI_Controller {



    function __construct()

    {

        parent::__construct();

        $this->load->library('ion_auth');

        $this->load->library('session');

        $this->load->library('form_validation');

        $this->load->helper('url');

        $this->load->model("admin/Category_model", "category");

        $this->load->model("Dialog_result", "dr");

        $this->load->database();

        $this->load->helper("time_helper");

        $this->load->model("admin/Users", "users");

        $this->load->model("admin/Business_type_model", "business_type");

        $this->load->model("admin/Sales_rep", "sales_reps");

        $this->load->model("admin/Business", "business");

        $this->load->model("admin/Ads_model", "ads");

        $this->load->model("admin/Sales_zone", "sales_zone");

        $this->load->config('security', TRUE);

   

        $this->tierI = $this->config->item('Tier_I');

        $this->tierII = $this->config->item('Tier_II');

        $this->tierIII = $this->config->item('Tier_III');

   

    }

    

    function delete_business_type()

    {

    	$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

    	$title = " Failed";

    	$message = "There was no id set";

    	if(!empty($id) && $id > 0)

    	{

    		$this->db->delete('business_type', array('id' => $id));

    		$title = " Succeeded";

    		$message = "Delete is complete.";

    	}

    	$data['business_types'] = $this->business_type->get_all_business_types_name();

    	$newTable = $this->load->view("admin/business_type.table.php", $data, true);

    	echo($this->dr->GetDR("Delete " . $title, $message, $newTable, "0"));

    }



    function save_business_type()

    {

    	$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

    	$name = $_REQUEST['name'];

    	

    	$data = array(

    			'name' => $name,

    	);

    

    	if(!empty($id) && $id > 0)

    	{

    		//update

    		$this->db->where('id', $id);

    		$this->db->update('business_type', $data);

    	}

    	else

    	{

    		//insert

    		$this->db->insert('business_type', $data);

    	}

    	$data['business_types'] = $this->business_type->get_all_business_types_name();

    	$newTable = $this->load->view("admin/business_type.table.php", $data, true);

    	echo($this->dr->GetDR("Save Successful", "The save was successful", $newTable, "0"));;

    }

    

    function json_business_type($id)

    {

    	$query = $this->db->get_where('business_type', array('id' => $id));

    	echo(json_encode($query->row()));

    }

    

    function index($zone = false)

    {

       if (!$this->ion_auth->logged_in())

        {

            //redirect them to the login page

            redirect('auth/login', 'refresh');

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

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/business_type.inc.js");

        $data['business_types'] = $this->business_type->get_all_business_types_name();

        $data["scripts"] = $scripts;

        $data["firstName"] = $this->ion_auth->user()->row()->first_name;

        $data["page_name"] = "business_type";

        $this->load->view("admin/header", $data);

        $this->load->view("admin/admin_buttons", $data);

        $this->load->view("admin/business_type.inc.php", $data);

        $this->load->view("admin/business_type.table.php",$data);

        $this->load->view("admin/footer");

		

     //   redirect("admin");

    }

}