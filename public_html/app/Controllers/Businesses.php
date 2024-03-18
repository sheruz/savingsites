<?php

class Businesses extends CI_Controller {



    function __construct()

    {

        parent::__construct();

        $this->load->library('ion_auth');

        $this->load->library('session');

        $this->load->library('form_validation');

        $this->load->helper('url');

        $this->load->model("Dialog_result", "dr");

        $this->load->model("admin/Sales_zone", "zone");

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

        @set_magic_quotes_runtime(0); // Kill magic quotes

       

    }

    
 

    public function get($id)

    {

        if(!empty($id) && $id > 0)

        {

            $sql = "select t1.*,t2.street_address_1, t2.street_address_2, t2.city,t2.state,t2.zip_code,t2.phone

                    from business as t1 left join address as t2 on t1.addressid = t2.id where t1.id = " .$id;

            $query = $this->db->query($sql);

            echo(json_encode($query->row()));

        }

    }



    public function delete()

    {

        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

        $title = " Failed";

        $message = "There was no id set";

        if(!empty($id) && $id > 0)

        {
			$this->delete_logo($id, $logo);

            $this->db->delete('business', array('id' => $id));

            $title = " Succeeded";

            $message = "Delete is complete.";

        }

        echo($this->dr->GetDR("Delete " . $title, $message, "", "0"));



    }



    public function save()

    {

        @set_magic_quotes_runtime(0); // Kill magic quotes

       

        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
		
		$logo = stripslashes($_REQUEST['logo']);

        $name = stripslashes($_REQUEST['name']);

        $addressid = $_REQUEST['addressid'];

        $contactemail = $_REQUEST['contactemail'];

        $website = !empty($_REQUEST['website']) ? $_REQUEST['website'] : '';

        $contactfirstname = stripslashes($_REQUEST['contactfirstname']);

        $contactlastname = stripslashes($_REQUEST['contactlastname']);

        $business_owner_id = $_REQUEST['business_owner_id'];

        $street1 = stripslashes($_REQUEST['street1']);

        $street2 = stripslashes($_REQUEST['street2']);

        $city = stripslashes($_REQUEST['city']);

        $state = $_REQUEST['state'];

        $zipcode = $_REQUEST['zipcode'];

        $phone = $_REQUEST['phone'];



        $data = array(

            'name' => $name,
			
			'logo' => $logo,

            'contactemail' => $contactemail,

            'contactfirstname' => $contactfirstname,

            'contactlastname' => $contactlastname

        );



        if(!empty($website)){

            $data['website'] = $website;

        }
		
		$address ='';
        if($street1!='')
        {
        	$address.=$street1;
        }
        if($street2!='')
        {
        	if($address!='')
        	{
        		$address.=','.$street2;
        	}else{
        		$address.=$street2;
        	}
        
        }
        if($city!='')
        {
        	if($address!='')
        	{
        		$address.=','.$city;
        	}else{
        		$address.=$city;
        	}
        
        }
        if($state!='')
        {
        	if($address!='')
        	{
        		$address.=','.$state;
        	}else{
        		$address.=$state;
        	}
        
        }
        if($zipcode!='')
        {
        	if($address!='')
        	{
        		$address.=','.$zipcode;
        	}else{
        		$address.=$zipcode;
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

        $addressData = array(

            'street_address_1' => $street1,

            'street_address_2' => $street2,

            'city' => $city,

            'state' => $state,

            'zip_code' => $zipcode,

            'phone' => $phone,
			
			'latitude' => $lat,
			
        	'longitude' => $long

        );



        if(!empty($business_owner_id))

        {



            $data['business_owner_id'] = $business_owner_id;

        }

        if(!empty($addressid))

        {

            $data['addressid'] = $addressid;

        }



        if(!empty($id) && $id > 0)

        {

            if(!empty($addressid) && $addressid > 0)

            {

                $this->db->where('id', $addressid);

                $this->db->update('address', $addressData);

            }

            else

            {

                $this->db->insert('address', $addressData);

                $data['addressid'] = $this->db->insert_id();

            }



            //update
			$this->delete_logo($id, $logo);
			
            $this->db->where('id', $id);

            $this->db->update('business', $data);



        }

        else

        {

            //insert

            $this->db->insert('address', $addressData);

            $data['addressid'] = $this->db->insert_id();



            $this->db->insert('business', $data);

        }

        $data['business_list'] = $this->business->get_all_businesses();

        $data['users_list'] = $this->users->get_all_users();

        $data['sales_rep_list'] = $this->sales_reps->get_sales_reps();

        $data['sales_zone_list'] = $this->zone->get_all_zones();

        

        $result = $this->load->view("admin/business.table.php",$data, true);

        echo($this->dr->GetDR("Save Successful", "The save was successful", $result, "0"));



    }

	function upload_logo($filename, $form_id){
		//loading file upload library and setting up variables
		$new_filename = 'busi_'.time();
		$result = '';
		$output_image_data = '';
		
		$file_config = array();
		$file_config['upload_path'] = "./uploads/businesses/";
		$file_config['max_size'] = "1024";
		$file_config['allowed_types'] = "jpg|jpeg|gif|png";
		$file_config['file_name'] = $new_filename;
		$file_config['max_width'] = 0;
		$file_config['max_height'] = 0;

		$this->load->library('upload', $file_config);
		
		if ( ! $this->upload->do_upload($filename))
		{
			$result = $this->upload->display_errors();				
		}else{
			$data['upload_data'] = $this->upload->data();
			$img = $data['upload_data']['file_name'];
			
			$output_image_data = '<img src="'.base_url('uploads/businesses').'/'.$data['upload_data']['file_name'].'" alt="" title="" border="1" id="current_logo" />';
			$output_image_data .= '<input type="hidden" name="logo" id="logo" value="'.$img.'" />';
			$result = 'upload-success';
		}
		
		sleep(1);
		?>
		
		<script language="javascript" type="text/javascript">window.top.window.stopUpload('<?php echo $result; ?>', '<?php echo $output_image_data;?>', 'logo_image', '<?php echo $filename;?>', '<?php echo $form_id;?>');</script>   
		<?php
	}

	function delete_logo($id, $logo = ''){
		$query = $this->db->get_where('business', array('id' => $id));
		$business = $query->row();
		
		if( $logo && $logo <> $business->logo ){
			@unlink(FCPATH."/uploads/businesses/".$business->logo);
		}
	}

    function index()

    {

        if (!$this->ion_auth->logged_in())

        {

            //redirect them to the login page
			redirect(base_url(), 'refresh');
            //redirect('auth/login', 'refresh');

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

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/business.inc.js","assets/scripts/upload.js");

        $data['business_list'] = $this->business->get_all_businesses();

        $data['users_list'] = $this->users->get_user_list();

        $data['sales_rep_list'] = $this->sales_reps->get_sales_reps();



        $data['sales_zone_list'] = $this->zone->get_all_zones();

        $data["scripts"] = $scripts;

        $data["firstName"] = $this->ion_auth->user()->row()->first_name;

        $data["page_name"] = "businesses";



        $this->load->view("admin/header", $data);

        $this->load->view("admin/admin_buttons", $data);

        $this->load->view("admin/business.inc.php", $data);

        $this->load->view("admin/business.table.php",$data);

        $this->load->view("admin/footer");

    }

    function get_businesses_for_zone_csv($id)
    {
        $zone = $this->zone->get_zone($id);
        $filename = $zone->name . "_businesses.csv";
        $filename = str_replace(" ", "_", $filename);
        $filename = str_replace("'", "", $filename);
        $filename = str_replace("\"", "", $filename);
        $filename = str_replace(",", "", $filename);

        header('Content-type: text/csv');
        header("Content-disposition: attachment;filename=" . $filename);
        echo "email,sic_code,naics_code,company_name,contact_name,first_name,last_name,title,address,address2,city,state,zip,phone,fax,company_website,revenue,employees,industries,desc". PHP_EOL;

        $businesses = $this->business->get_businesses_for_zone($id);
        foreach($businesses as $business)
        {
            extract($business);
            echo "$contactemail,,,\"$name\",,$contactfirstname,$contactlastname,,$street_address_1,$street_address_2,$city,$state,$zip_code,$phone,,$website,,,,," . PHP_EOL;

        }


    }

}