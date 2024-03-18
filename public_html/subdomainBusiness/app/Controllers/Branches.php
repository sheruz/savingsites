<?php
class Branches extends CI_Controller {

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
    
	function calc_lat_long($offset=0)
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
    	
    	
    	$sql_address="select * from address order by id limit ".$offset.", 10";
    	$query_address=$this->db->query($sql_address);
    	
    	$result_address=$query_address->result();
    	if(empty($result_address))
    	{
    		redirect("category". (!empty($zone) ? "/".$zone : ""));
    	}
    	foreach($result_address as $result_address)
    	{
	    	$address ='';
	    	if($result_address->street_address_1!='')
	    	{
	    		$address.=$result_address->street_address_1;
	    	}
	    	if($result_address->street_address_2!='')
	    	{
	    		if($address!='')
	    		{
	    			$address.=','.$result_address->street_address_2;
	    		}else{
	    			$address.=$result_address->street_address_2;
	    		}
	    		
	    	}
	    	if($result_address->city!='')
	    	{
	    		if($address!='')
	    		{
	    			$address.=','.$result_address->city;
	    		}else{
	    			$address.=$result_address->city;
	    		}
	    	
	    	}
	    	if($result_address->state!='')
	    	{
	    		if($address!='')
	    		{
	    			$address.=','.$result_address->state;
	    		}else{
	    			$address.=$result_address->state;
	    		}
	    	
	    	}
	    	if($result_address->zip_code!='')
	    	{
	    		if($address!='')
	    		{
	    			$address.=','.$result_address->zip_code;
	    		}else{
	    			$address.=$result_address->zip_code;
	    		}
	    	
	    	}
	    	
	    	
	    	$address = urlencode($address);
	    	$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
	    	$ch = curl_init();
	    	curl_setopt($ch, CURLOPT_URL, $url);
	    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    	curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
	    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    	$response = curl_exec($ch);
	    	curl_close($ch);
	    	$response_a = json_decode($response);
	    	
			
			if(isset($response_a->results[0]))
			{
				$lat = $response_a->results[0]->geometry->location->lat;
				$long = $response_a->results[0]->geometry->location->lng;
			
				$data_address = array(
						'latitude' => $lat,
						'longitude' => $long
				);
				if(!empty($result_address->id) && $result_address->id > 0)
				{
					//update
					$this->db->where('id', $result_address->id);
					$this->db->update('address', $data_address);
				}
			}
    	}
		
    	$offset=$offset+10;
    	redirect("branches/calc_lat_long/". $offset);
    	
    }
	
    function delete_branche()
    {
    	$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
    	$title = " Failed";
    	$message = "There was no id set";
    	if(!empty($id) && $id > 0)
    	{
    		$this->db->delete('branches', array('id' => $id));
    		$title = " Succeeded";
    		$message = "Delete is complete.";
    	}
    	$data['business_list'] = $this->business->get_all_businesses();
        $data['branche_list'] = $this->business->get_all_branches();
    	$newTable = $this->load->view("admin/branches.table.php", $data, true);
    	echo($this->dr->GetDR("Delete " . $title, $message, $newTable, "0"));
    }

    function save_branche()
    {
    	$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
    	$branches_address1 = $_REQUEST['branches_address1'];
    	$branches_address2 = $_REQUEST['branches_address2'];
    	$branches_city = $_REQUEST['branches_city'];
    	$branches_state = $_REQUEST['branches_state'];
    	$branches_zipcode = $_REQUEST['branches_zipcode'];
    	
    	$name = $_REQUEST['branches_name'];
    	$business_id = $_REQUEST['business_id'];
    	$branches_number = $_REQUEST['branches_number'];
    	
    	$address_id = empty($_REQUEST['address_id']) ? "-1" : $_REQUEST['address_id'];
    	
    	$address ='';
    	if($branches_address1!='')
    	{
    		$address.=$branches_address1;
    	}
    	if($branches_address2!='')
    	{
    		if($address!='')
    		{
    			$address.=','.$branches_address2;
    		}else{
    			$address.=$branches_address2;
    		}
    		
    	}
    	if($branches_city!='')
    	{
    		if($address!='')
    		{
    			$address.=','.$branches_city;
    		}else{
    			$address.=$branches_city;
    		}
    	
    	}
    	if($branches_state!='')
    	{
    		if($address!='')
    		{
    			$address.=','.$branches_state;
    		}else{
    			$address.=$branches_state;
    		}
    	
    	}
    	if($branches_zipcode!='')
    	{
    		if($address!='')
    		{
    			$address.=','.$branches_zipcode;
    		}else{
    			$address.=$branches_zipcode;
    		}
    	
    	}
    	
    	
    	$address = urlencode($address);
    	$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    	$response = curl_exec($ch);
    	curl_close($ch);
    	$response_a = json_decode($response);
    	
    	$lat = $response_a->results[0]->geometry->location->lat;
    	$long = $response_a->results[0]->geometry->location->lng;
    	
    	
    	$data_address = array(
    			"street_address_1" => $branches_address1,
    			"street_address_2" => $branches_address2,
    			"city" => $branches_city,
    			"state" => $branches_state,
    			"zip_code" => $branches_zipcode,
    			'latitude' => $lat,
    			'longitude' => $long
    	);
    	if(!empty($address_id) && $address_id > 0)
    	{
    		//update
    		$this->db->where('id', $address_id);
    		$this->db->update('address', $data_address);
    	}
    	else
    	{
    		//insert
    		$this->db->insert('address', $data_address);
    		$address_id = $this->db->insert_id();
    	}
    	
    	$data = array(
    			"branch_name" => $name,
    			"business_id" => $business_id,
		    	"branch_identifier" => $branches_number,
    			"address_id" => $address_id,
    	);
    	
    	
    
    	if(!empty($id) && $id > 0)
    	{
    		//update
    		$this->db->where('id', $id);
    		$this->db->update('Branches', $data);
    	}
    	else
    	{
    		//insert
    		$this->db->insert('Branches', $data);
    	}
    	$data['business_list'] = $this->business->get_all_businesses();
        $data['branche_list'] = $this->business->get_all_branches();
    	$newTable = $this->load->view("admin/branches.table.php", $data, true);
    	echo($this->dr->GetDR("Save Successful", "The save was successful", $newTable, "0"));;
    }
    
    function json_business_type($id)
    {
    	
    	$sql_address="select t1.id as b_id,t1.business_id,t1.branch_name,t1.address_id,t1.branch_identifier,t2.* from Branches as t1
                      join address as t2 on
                      t1.address_id = t2.id
                      where t1.id = $id";
    	$query_address=$this->db->query($sql_address);
    	echo(json_encode($query_address->row()));
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
        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/branches.inc.js");
        $data['business_list'] = $this->business->get_all_businesses();
        $data['branche_list'] = $this->business->get_all_branches();
        $data["scripts"] = $scripts;
        $data["firstName"] = $this->ion_auth->user()->row()->first_name;
        $data["page_name"] = "branches";
        $this->load->view("admin/header", $data);
        $this->load->view("admin/admin_buttons", $data);
        $this->load->view("admin/branches.inc.php", $data);
        $this->load->view("admin/branches.table.php",$data);
        $this->load->view("admin/footer");
     //   redirect("admin");
    }
}