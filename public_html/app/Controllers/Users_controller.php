<?php
class Users_controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('time_helper');
        $this->load->model("Dialog_result", "dr");

        $this->load->model("admin/Ads_model", "ad");
    
        $this->load->model("admin/Category_model", "category");
        $this->load->model("admin/Users", "users");
        $this->load->model("admin/Business_type_model", "business_type");
        $this->load->model("admin/Sales_rep", "sales_reps");
        $this->load->model("Zips");
       
        $this->load->model("admin/Business", "business");
        $this->load->model("admin/Sales_zone", "zone");
        $this->load->config('security', TRUE);
        $this->load->database();

        $this->tierI = $this->config->item('Tier_I');
        $this->tierII = $this->config->item('Tier_II');
        $this->tierIII = $this->config->item('Tier_III');
}

    public function convert()
    {
        $query = $this->db->query("select * from replist")->result_array();
        foreach($query as $q){
            extract($q);
              $additional_data = array('first_name' => $Firstname,
            'last_name' => $Lastname, 'phone' => $Phone, 'active' => 1);
            $groups = array("4");
            if($Status = "Admin"){ $groups[] = "3";}
            $my_id = $this->ion_auth->register($Username, $Email, $Email, $additional_data, $groups);
            echo("$Username registered- $Email (password)<br/>");
            {
                $mailData =  array();
                $mailData['mailUser'] = $this->ion_auth->user($my_id)->row();
                $headers = "From: \"Savings Sites Website\"<savings@savingssites.com>\r\n";
		        $headers .="Reply-To:  \"No Reply\"<a@a.com>";
                $to = $Email;
		        $body = $this->load->view("email_templates/user_sign_up", $mailData, true);
        
                $mtest = mail($to, "Your Account has been upgraded", $body, $headers);
            }
            $uid = 1000 + $User_ID;
            $data = array(
               'uid' => $my_id
            );

            $this->db->where('uid', $uid);
            $this->db->update('tblClaimedZips', $data); 

            //Create Zone
            $this->db->insert('sales_zone', array("sales_rep_id" => $my_id, "name" => $Firstname . "_" . $Lastname, "state" => "Unknown"));
            $zoneid =  $this->db->insert_id();
            //Add Zips To Zone
            foreach($this->zips->get_zips($my_id) as $zzip){
                $this->db->insert('zip_code_zone', array("zip_code" => $zzip['zip'], "zone_id" => $zoneid));
            }
        }

    }

    public function get($id)
    {
        if (!empty($id) && $id > 0) {
            $sql = "select t1.*, t2.id as securityId, t2.name as securityName from users as t1
                    LEFT JOIN users_groups as t3 on t1.id = user_id LEFT join groups as t2 on
                    t3.group_id = t2.id where t1.id =" . $id;

            $query = $this->db->query($sql);
            $result = $query->row();
            echo(json_encode($result));
        }
    }

    public function get_role($id)
    {
        if (!empty($id) && $id > 0) {
            $sql = "select t1.id, t1.username, t2.id as securityId, t2.name as securityName from users as t1
                    LEFT JOIN users_groups as t3 on t1.id = user_id LEFT join groups as t2 on
                    t3.group_id = t2.id where t1.id =" . $id;

            $query = $this->db->query($sql);
            $result = $query->row();
            echo(json_encode($result));
        }
    }
    public function delete()
    {
        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
        $title = " Failed";
        $message = "There was no id set";
        if (!empty($id) && $id > 0) {
            $data = array("active" => "-1");
            //update
            $this->db->where('id', $id);
            $this->db->update('users', $data);

            $this->db->where('uid', $id);
            $this->db->update('tblClaimedZips', array("approved" => "0"));

            $title = " Succeeded";
            $message = "Delete is complete.";
        }
        $data['user_list'] = $this->db->query("select * from users where active = 1 order by username")->result_array();
        $data['role_list'] = $this->db->query("select * from groups order by name")->result_array();
        $data = array();
        $data['user_list'] = $this->db->query("select * from users where active = 1 order by username")->result_array();
        $data['role_list'] = $this->db->query("select * from groups order by name")->result_array();

        echo($this->dr->GetDR("Delete " . $title, $message, $this->load->view("admin/users.table.php",$data,true), "0"));

    }

    public function save_role()
    {
        $id = $_REQUEST['id'];
        $roleId = $_REQUEST['user_role'];

        if (!empty($id) && $id > 0) {
            $this->db->delete('users_groups', array('user_id' => $id));
            $this->db->insert('users_groups', array('user_id' => $id, 'group_id' => $roleId));
        }

        echo($this->dr->GetDR("Save Successful", "User Role was Changed","", "0"));
    }

    public function save()
    {
        $name = $_REQUEST['username'];
        $firstname = $_REQUEST['firstname'];
        $lastname = $_REQUEST['lastname'];
        $email = $_REQUEST['email'];
        $password = $name;
        $additional_data = array('first_name' => $firstname,
            'last_name' => $lastname
        );

        $this->ion_auth->register($name, $password, $email, $additional_data);
        $data['user_list'] = $this->db->query("select * from users where active = 1 order by username")->result_array();
        $data['role_list'] = $this->db->query("select * from groups order by name")->result_array();
        $data = array();
        $data['user_list'] = $this->db->query("select * from users where active = 1 order by username")->result_array();
        $data['role_list'] = $this->db->query("select * from groups order by name")->result_array();

        echo($this->dr->GetDR("Save Successful", "User was Created Successfully", $this->load->view("admin/users.table.php",$data,true), "0"));

    }

    function index()
    {
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
                $data['business_list'] = $this->business->get_all_businesses_for_user();
            }

        $data = array();
        $data['tier']  = $tiers;
        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/users.inc.js");
        $data['user_list'] = $this->db->query("select a.*,b.group_id from users a,users_groups b where a.id=b.user_id and a.active = 1 order by username")->result_array();
		//var_dump($data['user_list']);
        $data['role_list'] = $this->db->query("select * from groups order by name")->result_array();
        $data['page_name'] = "users";
        $data["firstName"] = $this->ion_auth->user()->row()->first_name;
        
        $data['scripts'] = $scripts;       
        $this->load->view("admin/header", $data);
        $this->load->view("admin/admin_buttons", $data);
        $this->load->view("admin/users.inc.php", $data);
        $this->load->view("admin/users.table.php",$data);
        $this->load->view("admin/footer");
     }
}