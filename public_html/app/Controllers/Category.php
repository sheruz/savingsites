<?php
class Category extends CI_Controller {

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

    function json_category($id)
    {
        $query = $this->db->get_where('business_category', array('id' => $id));
        echo(json_encode($query->row()));
    }
    function delete_category()
    {
        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
        $title = " Failed";
        $message = "There was no id set";
        if(!empty($id) && $id > 0)
        {
            $this->db->delete('business_category', array('id' => $id));
			$this->db->delete('category_exluded', array('category_id' => $id));
            $title = " Succeeded";
            $message = "Delete is complete.";
        }
       $data['category_list'] = $this->category->get_categories();
       $data['business_types'] = $this->business_type->get_business_types_name_array();
       $newTable = $this->load->view("admin/category.table.php", $data, true);
       echo($this->dr->GetDR("Delete " . $title, $message, $newTable, "0"));
    }
    function save_category()
    {
        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
        $name = $_REQUEST['name'];
        $business_type = $_REQUEST['business_type'];

        $data = array(
            'name' => $name,
            'business_type_id' => $business_type
        );

        if(!empty($id) && $id > 0)
        {
            //update
            $this->db->where('id', $id);
            $this->db->update('business_category', $data);
        }
        else
        {
            //insert
            $this->db->insert('business_category', $data);
       }
       $data['category_list'] = $this->category->get_categories();
       $data['business_types'] = $this->business_type->get_business_types_name_array();
       $newTable = $this->load->view("admin/category.table.php", $data, true);
       echo($this->dr->GetDR("Save Successful", "The save was successful", $newTable, "0"));;
    }
    function index($zone = false)
    {
       if (!$this->ion_auth->logged_in())
        {
            //redirect them to the login page
            redirect(base_url(), 'refresh');
			//redirect('auth/login', 'refresh');
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
        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/category.inc.js");
        $data['category_list'] = $this->category->get_categories();
        $data['business_types'] = $this->business_type->get_business_types_name_array();
        $data["scripts"] = $scripts;
        $data["firstName"] = $this->ion_auth->user()->row()->first_name;
        $data["page_name"] = "category";
        $this->load->view("admin/header", $data);
        $this->load->view("admin/admin_buttons", $data);
        $this->load->view("admin/category.inc.php", $data);
        $this->load->view("admin/category.table.php",$data);
        $this->load->view("admin/footer");    
    }
}