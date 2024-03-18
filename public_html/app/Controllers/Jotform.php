<?php
class Jotform extends CI_Controller {

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
        
        $this->tierI = $this->config->item('Tier_I');

        $this->tierII = $this->config->item('Tier_II');

        $this->tierIII = $this->config->item('Tier_III');

    }

    public function index(){
        if (!$this->ion_auth->logged_in())
        {
            //redirect them to the login page
            //redirect('auth/login', 'refresh');
			redirect(base_url(), 'refresh');
        }
        elseif (!$this->ion_auth->in_group(array( "Tier I", "Tier II" )))
        {
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

        $sql_payment_type = "select `id`,`value` from `payment_module` where `receiver_type` = 'admin'";
        $query_payment_type = $this->db->query($sql_payment_type);

        $data['payment_type'] = $query_payment_type->result();

        //print_r($this->session->all_userdata());
         
        //$scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/paypal.inc.js");
        //$data['paypal'] = $this->business_dashboard1->get_all_paypal();
       // $data["scripts"] = $scripts;
        $data["firstName"] = $this->ion_auth->user()->row()->first_name;
        $data["page_name"] = "jotform";
        $this->load->view("admin/header",$data);
        $this->load->view("admin/admin_buttons", $data);
        $this->load->view("admin/jotform.table.php", $data);
        $this->load->view("admin/footer");
    }

    public function insert_payment_details()
    {

        $admin_type = $this->input->post('admin_type');
        $payment_script = addslashes($this->input->post('jotformscript'));
        //$payment_module_receiver_id = $this->session->userdata('user_id');
        $payment_module_receiver_id = 0;
        $sqlTocheckIfScriptExists = "SELECT * FROM jot_form_embed_code WHERE payment_module_id = ".$admin_type." AND payment_module_receiver_id = ".$payment_module_receiver_id;
        $checkQueryStatus = '<p style = "color:red">Something went wrong,please try again</p>';
        $query = $this->db->query($sqlTocheckIfScriptExists);
        if($query->num_rows() > 0 ) {
            $sqlToUpdate = "UPDATE `jot_form_embed_code` SET `code` = '".$payment_script."' WHERE `payment_module_id` =".$admin_type." AND `payment_module_receiver_id` = ".$payment_module_receiver_id;
            if($this->db->query($sqlToUpdate)) {
                $checkQueryStatus = '<p style = "color:green">you have updated jotform successfully</p>';
            }

        } else {
            $payment_code = array(
                'code' => $payment_script,
                'payment_module_id' =>  $admin_type,
                'payment_module_receiver_id' =>  $payment_module_receiver_id
             );
            if($this->db->insert('jot_form_embed_code', $payment_code)) {
                $checkQueryStatus = '<p style = "color : green">You have successfully inserted new jot form</p>';
            }
        }
        $this->session->set_flashdata('jotformStatus',$checkQueryStatus);
        redirect('jotform');
    }

    public function show_payment_code(){

        //print_r($_POST);
        $payment_module_receiver_id = $this->input->post('receiver_id');

        $sql_payment_code = "select `code` from `jot_form_embed_code` where `payment_module_id` = $payment_module_receiver_id";
        $query_payment_code = $this->db->query($sql_payment_code);

        $payment_code = $query_payment_code->row();
        echo json_encode($payment_code);
    }
   
    
}