<?php
class Sales_reps extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model("Dialog_result", "dr");
        $this->load->helper("time_helper");
        $this->load->model("admin/Category_model", "category");
        $this->load->model("admin/Users", "users");
        $this->load->model("admin/Business_type_model", "business_type");
        $this->load->model("admin/Business", "business");
        $this->load->model("admin/sales_rep", "sales_rep");
        $this->load->model("admin/Ads_model", "ads");
        $this->load->model("admin/Sales_zone", "sales_zone");
        $this->load->config('security', TRUE);
        $this->load->database();

        $this->tierI = $this->config->item('Tier_I');
        $this->tierII = $this->config->item('Tier_II');
        $this->tierIII = $this->config->item('Tier_III');
 }

    public function get()
    {
        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
        if(!empty($id) && $id > 0)
        {
            $this->sales_rep->json_result($id);
        }
    }

    public function json_result($id)
    {
        $this->sales_rep->json_result($id);
    }

    public function delete()
    {
        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
        $title = " Failed";
        $message = "There was no id set";
        if(!empty($id) && $id > 0)
        {
            $this->db->delete('sales_rep', array('id' => $id));
            $title = " Succeeded";
            $message = "Delete is complete.";
        }

        $data['sales_rep_list'] = $this->sales_rep->get_sales_reps();
        
        $result = $this->load->view("admin/sales_reps.table.php",$data, true);
        

        echo($this->dr->GetDR("Delete " . $title, $message, $result, "0"));

    }

    public function save()
    {
        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
        $firstname = $_REQUEST['firstname'];
        $lastname = $_REQUEST['lastname'];
        $email = $_REQUEST['email'];
        $addressId = $_REQUEST['addressid'];
        $street1 = $_REQUEST['street1'];
        $street2 = $_REQUEST['street2'];
        $city = $_REQUEST['city'];
        $state = $_REQUEST['state'];
        $zipcode = $_REQUEST['zipcode'];
        $phone = $_REQUEST['phone'];

        $addressData = array(
            'street_address_1' => $street1,
            'street_address_2' => $street2,
            'city' => $city,
            'state' => $state,
            'zip_code' => $zipcode,
            'phone' => $phone
        );

        $data = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email
        );
        if(!empty($id) && $id > 0)
        {
            //update
            $this->db->where('id', $id);
            $this->db->update('sales_rep', $data);

            $this->db->where('id', $addressId);
            $this->db->update('address', $addressData);
        }
        else
        {
            //insert
            $this->db->insert('address', $addressData);
            $data['addressid'] = $this->db->insert_id();
            $this->db->insert('sales_rep', $data);
        }

        $data['sales_rep_list'] = $this->sales_rep->get_sales_reps();
        
        $result = $this->load->view("admin/sales_reps.table.php",$data, true);
        
        echo($this->dr->GetDR("Save Successful", "The save was successful", $result, "0"));;

    }

    function index()
    {
        if (!$this->ion_auth->logged_in())
        {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->in_group(array( "Tier I")))
        {
            //redirect them to the home page because they must be an administrator to view this
            redirect($this->config->item('base_url'), 'refresh');
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
        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/sales_rep.inc.js");

        $admin_tabs = array();
        $data['sales_rep_list'] = $this->sales_rep->get_sales_reps();
        $data["scripts"] = $scripts;
        $data["firstName"] = $this->ion_auth->user()->row()->first_name;
        $data["page_name"] = "sales_rep";

        $this->load->view("admin/header", $data);
        $this->load->view("admin/admin_buttons", $data);
        $this->load->view("admin/sales_reps.inc.php", $data);
        $this->load->view("admin/sales_reps.table.php",$data);
        $this->load->view("admin/footer");
    }
}