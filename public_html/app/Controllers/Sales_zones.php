<?php
class Sales_zones extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model("admin/Sales_zone", "zone");
        $this->load->model("Dialog_result", "dr");
        $this->load->helper("time_helper");
        $this->load->model("admin/Category_model", "category");
        $this->load->model("admin/Users", "users");
        $this->load->model("admin/Business_type_model", "business_type");
        $this->load->model("admin/Sales_rep", "sales_reps");
        $this->load->model("admin/Business", "business");
        $this->load->model("admin/Ads_model", "ads");
        $this->load->config('security', TRUE);
        
        $this->tierI = $this->config->item('Tier_I');
        $this->tierII = $this->config->item('Tier_II');
        $this->tierIII = $this->config->item('Tier_III');
        $this->load->database();

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
        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/sales_zone.inc.js");
        $data['users_list'] = $this->users->get_user_list();
        $data['new_id'] = $this->ion_auth->user()->row()->id;
        $data['sales_zone_list'] = $this->zone->get_all_zones();
        if($tiers != "Tier I"){
            $data['sales_zone_list'] = $this->zone->get_zones_for_user($data['new_id']);
        }
        $data["scripts"] = $scripts;
        $data["firstName"] = $this->ion_auth->user()->row()->first_name;
        $data["page_name"] = "sales_zone";

        $this->load->view("admin/header", $data);
        $this->load->view("admin/admin_buttons", $data);
        $this->load->view("admin/sales_zones.inc.php", $data);
        $this->load->view("admin/sales_zone.table.php",$data);
        $this->load->view("admin/footer");
    }
    public function get($id)
    {
        if(!empty($id) && $id > 0)
        {
            $query = $this->db->get_where('sales_zone', array('id' => $id));
            $row = $query->row();
            $sql = "select t1.* from business as t1
                      join business_to_zone as t2 on
                      t1.id = t2.business_id
                      where t2.zone_id = $row->id";
            $biz_html = "<center><table width='50%' border='0'>";
            foreach($this->db->query($sql)->result_array() as $biz)
            {
                $biz_html .= "<tr><td>" .$biz['name'] . "</td><td><button class='deleteButton' onclick='RemoveFromZone(".
                $biz['id'] . "," . $id .", \"" . str_replace("'","",$biz['name']) ."\")'>Remove</button></td></tr>";
            }
            $biz_html .= "<tr><td colspan='2'>
            <select id='bizToAdd'>";
            $sql = "select * from business where id not in (
                           select business_id from business_to_zone
                           where zone_id = $row->id)";

            foreach($this->db->query($sql)->result_array() as $biz2)
            {
                $biz_html .= "<option value='" . $biz2['id'] . "'>" . $biz2['name'] . "</option>";
            }
            $biz_html .= "</select><button class='newButton' onclick='addBusinessToZone($row->id);'>Add</button>";
            $biz_html .= "</td></tr></table></center>";
            
            $row->biz_list = $biz_html;
			
			 $sql_option="select category_option from sales_zone where id= $id";
            $query_option=$this->db->query($sql_option);
            
            if($query_option->row())
            {
            	$row->cat_option = $query_option->row()->category_option;
            }else{
            	$row->category_option = 0;
            }
            
            if($row->category_option==2)
            {
            	$sql_category="select category_id from category_exluded where zone_id= $id";
            	$query_category=$this->db->query($sql_category);
            	
            	$result_category=$query_category->result();
            	//print_r($result_category);exit;
            	
            	foreach($result_category as $result_category)
            	{
            		$category_array[]=$result_category->category_id;
            	}
            	
            	$category_list = $this->category->get_categories();
            	$category_html = "<center><table width='50%' border='0'><tr><td>Exclude Category</td></tr><tr><td><select multiple='multiple' name='category[]' id='category'>";
            	foreach($category_list as $category_list)
            	{
            		$select='';
            		if(in_array($category_list['id'], $category_array))
            		{
            			$select='selected="selected"';
            		}
            		$category_html .= "<option ".$select." value='" .$category_list['id'] . "'>" .$category_list['name'] . "</option>";
            	}
            	$category_html .= "</select></td></tr></table></center>";
            	
            	$row->category_html = $category_html;
            }
			
            //get zip codes for zone
            //SELECT * FROM zipcode where zip in (select zip_code from zip_code_zone where zone_id = ?)
            $tempData = array();
            $tempData['zone'] = $id;
            $tempData['zip_list'] = $this->db->query("select * from zipcode where zip in (select zip_code from zip_code_zone where zone_id = ?)", array($id))->result_array();
            //get zip codes for user not in zone
            $tempData['zip_list_excluded'] = $this->db->query("SELECT * FROM zipcode where zip in (select zip from tblClaimedZips where uid = ?) and zip not in (select zip_code from zip_code_zone where zone_id = ?)", array($this->ion_auth->user()->row()->id, $id))->result_array();

            $row->zip_list = $this->load->view("admin/sales_zone_zip_to_zone", $tempData, true);
            
            echo(json_encode($query->row()));
        }
    }
	
	function get_category()
	{
		$category_list = $this->category->get_categories();
		$biz_html = "<center><table width='50%' border='0'><tr><td>Exclude Category</td></tr><tr><td><select multiple='multiple' name='category[]' id='category'>";
		foreach($category_list as $category_list)
		{
			$biz_html .= "<option value='" .$category_list['id'] . "'>" .$category_list['name'] . "</option>";
		}
		$biz_html .= "</select></td></tr></table></center>";
		echo $biz_html;exit;
	}
	
    public function delete()
    {
        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
        $title = " Failed";
        $message = "There was no id set";
        if(!empty($id) && $id > 0)
        {
            $this->db->delete('sales_zone', array('id' => $id));
			$this->db->delete('category_exluded', array('zone_id' => $id));
            $title = " Succeeded";
            $message = "Delete is complete.";
        }
        echo($this->dr->GetDR("Delete " . $title, $message, "", "0"));

    }

    public function save()
    {
		$category = '';
        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
        $name = $_REQUEST['name'];
        $state = $_REQUEST['state'];
        $repid = $_REQUEST['sales_rep_id'];
		if(isset($_REQUEST['category']))
        {
        	$category = $_REQUEST['category'];
        }
		
        $data = array(
            'name' => $name,
            'state' => $state,
            'sales_rep_id' => $repid
        );
        if(!empty($id) && $id > 0)
        {
            //update
            $this->db->where('id', $id);
            $this->db->update('sales_zone', $data);
			 $this->db->delete('category_exluded', array('zone_id' => $id));
            
            if(is_array($category))
            {
	            foreach($category as $category )
	            {
		            $category_date=array(
	            				'zone_id' => $id,
	            				'category_id' => $category
	            				);
		            $this->db->insert('category_exluded', $category_date);
	        	}
            }
        }
        else
        {
            //insert
            $this->db->insert('sales_zone', $data);
			$zoneid = $this->db->insert_id();
           
           if(is_array($category))
           {
           	foreach($category as $category )
           	{
           		$category_date=array(
           				'zone_id' => $zoneid,
           				'category_id' => $category
           		);
           		$this->db->insert('category_exluded', $category_date);
           	}
           }
        }
		
		if(!empty($id) && $id > 0)
        {
        	$zoneid=$id;
        }
        $cat_option = array(
        		'category_option' => $_REQUEST['cat_option']
        		);
        
        $this->db->where('id', $id);
        $this->db->update('sales_zone', $cat_option);

        $data['sales_rep_list'] = $this->sales_reps->get_sales_reps();

        $data['sales_zone_list'] = $this->zone->get_all_zones();
        $result = $this->load->view("admin/sales_zone.table.php",$data, true);
        
        echo($this->dr->GetDR("Save Successful", "The save was successful", $result, "0"));;

    }

    public function addZipToZone()
    {
       $id = $_REQUEST['zone_id'];
       $zip_id = $_REQUEST['zipcode'];
       $title = " Failed";
       $message = "There was no id set";
        if(!empty($id) && $id > 0)
        {
            $this->db->insert('zip_code_zone', array('zip_code' => $zip_id, 'zone_id' => $id));
            $this->get($id);
            exit();
        }
        echo($this->dr->GetDR("Delete " . $title, $message, "", "0"));

    }
    public function addBusinessToZone()
    {
        $id = $_REQUEST['zone_id'];
        $biz_id = $_REQUEST['biz_id'];

        $title = " Failed";
        $message = "There was no id set";
        if(!empty($id) && $id > 0)
        {
            $this->db->insert('business_to_zone', array('business_id' => $biz_id, 'zone_id' => $id));
            $this->get($id);
            exit();
        }
        echo($this->dr->GetDR("Delete " . $title, $message, "", "0"));

    }
    public function removeZipFromZone()
    {
        $id = $_REQUEST['id'];
        $zip = $_REQUEST['zipcode'];

        $title = " Failed";
        $message = "There was no id set";
        if(!empty($id) && $id > 0)
        {
            $this->db->delete('zip_code_zone', array('zip_code' => $zip, 'zone_id' => $id));
            $this->get($id);
            exit();
        }
        echo($this->dr->GetDR("Delete " . $title, $message, "", "0"));

    }

    
    public function removeFromZone()
    {
        $id = $_REQUEST['id'];
        $biz_id = $_REQUEST['bizId'];

        $title = " Failed";
        $message = "There was no id set";
        if(!empty($id) && $id > 0)
        {
            $this->db->delete('business_to_zone', array('business_id' => $biz_id, 'zone_id' => $id));
            $this->get($id);
            exit();
        }
        echo($this->dr->GetDR("Delete " . $title, $message, "", "0"));

    }
    
}