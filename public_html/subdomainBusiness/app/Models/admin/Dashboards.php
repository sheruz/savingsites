<?php

### Created by Athena eSolutions



require_once(dirname(__FILE__)."/welcome.php"); // the controller route.



class Dashboards extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->library('ion_auth');

        $this->load->library('session');

        $this->load->library('form_validation');

		$this->load->library('pagination');

        

		$this->load->helper('url');

        $this->load->helper('ckeditor');

        $this->load->helper("time_helper");

        $this->load->helper('cookie');

		$this->load->helper('url');

		$this->load->helper('download');

		

		$this->load->model("States");

        $this->load->model("Statistics");

        $this->load->model("admin/Users", "users");

        $this->load->model("Dialog_result", "dr");

        $this->load->model("admin/Category_model", "category");

        $this->load->model("admin/Announcement_model", "announcements");

        $this->load->model("admin/Ads_model", "ads");

        $this->load->model("admin/Sales_zone", "sales_zone");

        $this->load->model("admin/Business", "business");

        $this->load->model("Zips", "zip");		

		//$this->load->model("admin/business_dashboard1", "business_dashboard1");

        $this->load->model("admin/Templates", "template");

        $this->load->model("admin/Business_type_model", "business_type");

		$this->load->model("admin/Category_management_model", "category_model");

		

		

		$this->load->config('security', TRUE);

		

        $this->load->database();

		



    }

### public function start

    public function index()

    {

        echo("Index works..");

        $this->load->view("dashboards/zone_dashboard");

		

    }

	public function organization($org_id=false){

		$user = $this->ion_auth->user()->row();

		//var_dump($org_id);exit;

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}



        if (empty($user)) {

        	redirect('welcome/index', 'refresh');

        }

		$data = array();

		$data['user'] = $user;

		$data['uid']= $uid;

		$data["usergroup"]=$this->business->get_user_group1($uid);

		$usergrid=$data["usergroup"]->group_id;

        if(!empty($user)){

        	$data["email"] = $user->email;

        	$data["firstName"] = $user->first_name;

        	$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

        }

		$data['organizationid']=$org_id;

		$data['zone']=$this->announcements->organization_zone($org_id);

		$userzoneid=$data['zone'][0]['zoneid'];

		$data['ckeditor'] = array(



            //ID of the textarea that will be replaced

            'id' 	=> 	'announcement_text',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



        ));	

		

		$data['hideSlider'] = true;

		$newsessiondata = array(

                   'usergrid'=>$usergrid,

                   'userzoneid'=>$userzoneid

        );

		$this->session->set_userdata('usersessiondata',$newsessiondata);  // assign session for logout redirection

		$data['right_container'] = $this->load->view("dashboards/organization_dashboard", $data, true);

        $data['content'] = $this->load->view("content", $data, true);

		//var_dump($data);exit;

        $this->load->view("default/blank", $data);

	}

	public function zone($id=false)

    {

        //var_dump($id); exit;

		

		$aa=$this->check_login_status("dashboards/zone/" . $id);

		//var_dump($aa); exit;

		$user = $this->ion_auth->user()->row();

		//var_dump($user);		

        $uid = 0;

        if(!empty($user)){ $uid = $user->id;}



        if (empty($user) || empty($id)) {

        	redirect('welcome/index', 'refresh');

        }

		

		

		if (!get_cookie('')) {

			// cookie not set, first visit



			// create cookie to avoid hitting this case again

			$cookie = array(

				'name'   => 'csvuploaderzoneid',

				'value'  => $id,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($cookie);

			//var_dump($_COOKIE);

		}

		

		$data = array();

		/*$zone = $this->sales_zone->get_zone($id);

		var_dump($zone);*/

		

		/*$config['total_rows'] = 200;

		$config['per_page'] = 20; 



		$this->pagination->initialize($config); 



		echo $this->pagination->create_links();

		var_dump($this->pagination->create_links());*/

		

		

		

		

		

		

		$data['user'] = $user;

		$data['uid']=$uid;

		

		$data["usergroup"]=$this->business->get_user_group1($uid); // get user from which group

		$usergrid=$data["usergroup"]->group_id;

		//var_dump($data['usergrid']);

        if(!empty($user)){

        	$data["email"] = $user->email;

        	$data["firstName"] = $user->first_name;

        	$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

        }	



		$data['ckeditor'] = array(



            //ID of the textarea that will be replaced

            'id' 	=> 	'announcement_text',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



        ));	

		$data['ckeditor_fromshowad'] = array(



            //ID of the textarea that will be replaced

            'id' 	=> 	'ad_text_fromshowad',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



            ));	

		$data['my_zones'] = $this->sales_zone->get_zones_for_user($uid);

		

		$data['all_my_zones']=$this->sales_zone->get_all_zones_by_user($id,$uid);

		//var_dump($data['my_zones']);

		$data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

		//var_dump($data['zone_owner_new']);

		$data['zone_id'] = $id;

		//var_dump($data['zone_id']);

		$zone= $this->sales_zone->get_zone($id);

		$data['zone'] = $zone;		

		$data['zone_owner'] = $this->ion_auth->user($zone->sales_rep_id)->row();

		$data['top_stats'] = $this->statistics->get_top_level_stats($id);

		$data['total_business'] = $this->business->get_all_business($id);

		$data['total_ads'] = $this->ads->get_all_ads_in_zone($id);

		//var_dump($data['total_business']);

		// For Statistics Part Start

		

		// For Statistics Part end

		// for bulk email start

		$data['business_owner_bulk']=$this->business->get_businesses_owner_new($id);

        $data['templates'] = $this->load->view("dashboards/bulk_template", $data, true);

		// for bulk email end

		

		// for municipal owner start

		

		// for municipal owner end

		

		// for zone manager start

		

		// for zone manager end

		

		// For Advertisement start

		$data['advertising_businesses_data'] = $this->business->get_businesses_who_have_advertised($id,$uid);

		//var_dump($data['advertising_businesses_data']);

		//if($data['advertising_businesses_data']!=''){		

        $data['advertising_businesses'] = $data['advertising_businesses_data'][0];

        $data['advertising_businesses_ids'] = $data['advertising_businesses_data'][1];

		

		$data_all_bus_ids=explode(',',$data['advertising_businesses_ids']);

		$data['data_all_bus_ids']=count($data_all_bus_ids); //var_dump($a);

		//var_dump($data['advertising_businesses_ids']);

		/*}else{

			$data['advertising_businesses'] ='';

        	$data['advertising_businesses_ids'] = '';

		}*/

		$data['category_list1'] = $this->category_model->get_all_categories_zone($id);

		$data['category_list2'] = $this->category_model->get_all_subcategories_ad_zone($id);

		

		// For Advertisement end				

		// For Style tags start

		

		// for Style Tag end

		$data['hideSlider'] = true;

		$newsessiondata = array(

                   'usergrid'=>$usergrid,

                   'userzoneid'=>$id

        );

		$this->session->set_userdata('usersessiondata',$newsessiondata);   // assign session for logout redirection

		//$usersession_data = $this->session->userdata('usersessiondata');

		//var_dump($usersession_data);

		//var_dump($data);

		$data['right_container'] = $this->load->view("dashboards/zone_dashboard", $data, true);

        $data['content'] = $this->load->view("content", $data, true);

        $this->load->view("default/blank", $data);

		

    }

	// ****************** main zone function end ******************************************

	// ****************** main business function start ************************************

	public function business($id=false,$fromzoneid=false){

		//var_dump($id); var_dump($fromzoneid);

		$this->check_login_status("dashboards/business/" . $id);

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		//var_dump($uid);

        if (empty($user) || empty($id)) {

            redirect('welcome/index', 'refresh');

        }

		

		$data = array();

		$data['fromzoneid']=($fromzoneid!='') ? $fromzoneid: 0;

		//var_dump($fromzoneid);

		

		if($fromzoneid!=''){

			$data['defaultzone'] =$fromzoneid;

			$data['from_zoneid']=$fromzoneid;

			$zone= $this->sales_zone->get_zone($fromzoneid);

			$data['zone'] = $zone;

			$data['where_from']='from_zone';

		}else{		

			$data['defaultzone'] = $this->category_model->get_defaultzone($id);

			foreach($data['defaultzone'] as $_val){

				$data['from_zoneid']=$_val;

				$data['where_from']='from_business';

			}

		}

		//var_dump($data['defaultzone']);

		

		

		$data['business_id']= $id; 

		$data['user'] = $user;

		//var_dump($data['user']);

		

		$data['uid']= $uid;

		

		$data["usergroup"]=$this->business->get_user_group1($uid); // get user from which group

		if(!empty($data["usergroup"])){

		$usergrid=$data["usergroup"]->group_id;

		}

		$bzid=$this->business->get_businessin_zone($id);

		$userzoneid=$bzid->settingszoneid;

		if(!empty($user)){

        	$data["email"] = $user->email;

        	$data["firstName"] = $user->first_name;

			$data["lastName"] = $user->last_name;

			$data["status"] = $user->status;

        	$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

        }

		

		// business part start

		$data['business'] = $this->business->get_business_by_id($id);

		//$data['business'] = $this->business->get_business_by_id($id);

		//var_dump($data['business']);

		$data['zonename'] = $this->business->get_zonename($id);

		//var_dump($data['zonename']);

		//var_dump($data['zonename']);

		//var_dump($data['zonename']->id); exit;

		//var_dump($data['zonename']);

		//var_dump($data['zonename']);

			

		$data['business_owner'] = $this->users->get_by_id($data['business']->business_owner_id); 

		$data['my_businesses'] = $this->business->get_all_businesses_for_user($uid);

		if($data['zonename']->id!=''){

			$data['business_type']=$this->business->get_business_type_by_id($id,$data['zonename']->id); 

		}

		$data['business_type']=$this->business->get_business_type_by_id($id,$data['zonename']->id); 

		

		$data['result']=$this->ads->getBusinessByID($id);    // add 22.01.13

		$data['address']=$this->ads->getBusinessAddresByID($data['result']['addressid']); // add 22.01.13

		$data['state_list']=$this->states->get_state_dropdown(); // add 22.01.13

		

		$data['snapuser_email']=$this->business->get_allsnapuser($id);  // for span email add 18.03.13

		//var_dump($data['spanuser_email']);

		$data['snapemailtemplates'] = $this->load->view("dashboards/snapuseremail", $data, true);

			

		$data["business_part_data_view"] = $this->load->view("dashboards/business_parts/data_view", $data, true); 

		// business part end

		/*if($fromzoneid!=''){

			$data['defaultzone'] =$fromzoneid;

		}else{

		

		$data['defaultzone'] = $this->category_model->get_defaultzone($id);

		}

		var_dump($data['defaultzone']);*/

		$data['category_list_bus'] = $this->category_model->get_all_categories_business($id);

		//var_dump($data['category_list_bus']);

		//$data['category_list2'] = $this->category_model->get_all_subcategories_ad_zone($data['defaultzone']->settingszoneid);

		//var_dump($data['category_list2']);

		//$data['defaultzoneid']=$data['defaultzone']->settingszoneid;

		$data['ckeditor_businessad'] = array(

			//ID of the textarea that will be replaced

			'id' 	=> 	'ad_text_fromshowad',

			'path'	=>	'assets/ckeditor',

	

			//Optional values

			'config' => array(

				'toolbar' 	=> 	"Full", 	//Using the Full toolbar

				'width' 	=> 	"550px",	//Setting a custom width

				'height' 	=> 	'100px',	//Setting a custom height



		));	

		// location part start

		$data['branches'] = $this->business->get_branches_for_business($id);

		$data["business_part_location_view"] = $this->load->view("dashboards/business_parts/location_view", $data, true);

		// location part end

		

		// job part start

		$data['ckeditor_jd'] = array(

            //ID of the textarea that will be replaced

            'id' 	=> 	'job_description',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



            ));		

		// job part end

		// Barter part start

		$data['ckeditor_barterdescription'] = array(

            //ID of the textarea that will be replaced

            'id' 	=> 	'barter_description',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



         )); 	

		// Barter part end

		// short notice email part start

		/*business_subscriber*/

        

        $business_subscriber = $this->business_dashboard1->get_all_subscriber($id);

        $total=count($business_subscriber);

         

        $sitesperpage = 10;

        $currentpage = 1;

        $index_limit = 10;

        $current=1;

        

         

        if (isset($_REQUEST['page']) && ($_REQUEST['page'] + 0) > 0) {

        	$currentpage = $_REQUEST['page'] + 0;

        	$current = $_REQUEST['page'] + 0;

        }

         

        if ($currentpage <= 1) {

        	$LIMIT_CLAUSE = sprintf("LIMIT 0, %s", $sitesperpage);

        }

         

        else

        {

        	$firstresult = (($currentpage - 1) * $sitesperpage);

        	$LIMIT_CLAUSE = sprintf("LIMIT %s, %s", $firstresult, $sitesperpage);

        }

        

        $data['business_subscriber']='';

        $business_subscriber = $this->business_dashboard1->get_all_subscriber_page($id,$LIMIT_CLAUSE);

        $data['business_subscriber'] = $business_subscriber;

        

        $total_pages=ceil($total/$sitesperpage);

         

        $start=max($currentpage-intval($index_limit/2), 1);

        $end=$start+$index_limit-1;

         

         

         

        $pagination='';

        $data['pagination'] = '';

        $data['job_listing'] = $this->db->query("select * from job_listing where business_id = " . $id)->result_array();

        $data['jobs'] = '';



        $business_owner = true;



        if($business_owner){

            $data['jobs'] = $this->load->view("dashboards/business_parts/job_view", $data, true);

        }



        $pagination.='<div class="pagination-dashboard"><ul class="pag_list">';

         

        if($current==1) {

        	$pagination.='<li><a class="button light_blue_btn" href="#"><span><span>Previous</span></span></a></li> ';

        } else {

        	$i = $current-1;

        	$pagination.='<li><a class="button light_blue_btn" title="go to page '.$i.'" rel="nofollow" onclick="get_subscriber('.$id.','.$i.');return false;" href=""><span><span>Previous</span></span></a></li> ';

        	$pagination.='<li><span><span>...</span></span></li> ';

        }

         

        if($start > 1) {

        	$i = 1;

        	$pagination.='<li><a title="go to page '.$i.'" onclick="get_subscriber('.$id.','.$i.');return false;" href="">'.$i.'</a></li> ';

        }

         

        for ($i = $start; $i <= $end && $i <= $total_pages; $i++){

        	if($i==$current) {

        		$pagination.='<li><a class="current_page" href="#"><span><span>'.$i.'</span></span></a></li> ';

        	} else {

        		$pagination.='<li><a title="go to page '.$i.'" onclick="get_subscriber('.$id.','.$i.');return false;" href="">'.$i.'</a></li> ';

        	}

        }

         

        if($total_pages > $end){

        	$i = $total_pages;

        	$pagination.='<li><a title="go to page '.$i.'"  onclick="get_subscriber('.$id.','.$i.');return false;" href="">'.$i.'</a></li> ';

        }

         

        if($current < $total_pages) {

        	$i = $current+1;

        	$pagination.='<li><span><span>...</span></span></li> ';

        	$pagination.='<li><a class="button light_blue_btn" title="go to page '.$i.'" rel="nofollow" onclick="get_subscriber('.$id.','.$i.');return false;" href=""><span><span>Next</span></span></a></li> ';

        } else {

        	$pagination.='<li><a class="button light_blue_btn" href="#"><span><span>Next</span></span></a></li>';

        }

        

        $data['pagination'] = $pagination;

        

        $data['hot']='';

        if(!empty($business_subscriber)){

        

        	$count=$this->business->subscribe_count($id);

        	$email_count=$this->business->email_count($id);

        	$hot="";

        

        	if(!empty($email_count))

        	{

        		$email_date = strtotime($email_count->date_time);

        		$pre_tday = strtotime('-2 day');

        		$pre_month = strtotime('-1 month');

        		$current_tday = strtotime('now');

        

        		if($email_date>$pre_tday && $current_tday>$email_date && $email_count->emai_count>=4)

        		{

        			$data['hot']='<div class="nine-tex-container"><a href="javascript:void()"> (Hot) </a></div>';

        		}elseif($email_date>$pre_month && $current_tday>$email_date && $email_count->emai_count>=4)

        		{

        			$data['hot']='<div class="nine-tex-container"><a href="javascript:void()"> (Super) </a></div>';

        		}

        	}

        }else{

    	

    		$count=$this->business->subscribe_count($id);

    		$email_count=$this->business->email_count($id);

    		$hot="";

    		

    		if(!empty($email_count))

    		{

    			$email_date = strtotime($email_count->date_time);

    			$pre_tday = strtotime('-2 day');

    			$pre_month = strtotime('-1 month');

    			$current_tday = strtotime('now');

    		

    			if($email_date>$pre_tday && $current_tday>$email_date && $email_count->emai_count>=4)

    			{

    				$data['hot']='<div class="nine-tex-container"><a href="javascript:void()"> (Hot) </a></div>';

    			}elseif($email_date>$pre_month && $current_tday>$email_date && $email_count->emai_count>=4)

    			{

    				$data['hot']='<div class="nine-tex-container"><a href="javascript:void()"> (Super) </a></div>';

    			}

    		}

        }

       

        	/*business_subscriber*/

		$data["bus_id"] = $id;

		$data["count"] = $count;

		$data["snap"] = $this->load->view("dashboards/business_parts/snap", $data, true);

		// short notice email part end

		

		$data['hideSlider'] = true;

		if(!empty($usergrid)){

		$newsessiondata = array(

                   'usergrid'=>$usergrid,

                   'userzoneid'=>$userzoneid

        );

		

		$this->session->set_userdata('usersessiondata',$newsessiondata); // assign session for logout redirection

		}

		$data['right_container'] = $this->load->view("dashboards/business_dashboard", $data, true);

        $data['content'] = $this->load->view("content", $data, true);

        $this->load->view("default/blank", $data);

	}

	// ****************** main business function end ************************************	

	private function check_login_status($return_page)

    {

       // var_dump($return_page); exit; 

		if (!$this->ion_auth->logged_in())

        {

            //redirect them to the login page

            $this->session->set_userdata('return_page', $return_page);

            redirect('auth/login', 'refresh');

        }

    }

	### ****************** Zone Owner Part Start ******************************************

	

	### create business from zone owner start

	

	function upload_docs($filename, $form_id){ 

    	//loading file upload library and setting up variables

    	//var_dump($filename); exit;

		$new_filename = 'busi_'.time();

    	$result = '';

    	$output_image_data = '';

   		

		$new_filename='busi_'.time().'_'.$_REQUEST['docx'];

		

		

    	$file_config = array();

    	$file_config['upload_path'] = "./uploads/docs/";

    	$file_config['max_size'] = "1024";

    	$file_config['allowed_types'] = "docx|doc|pdf";

    	//$file_config['file_name'] = $new_filename;

    	$file_config['max_width'] = 0;

    	$file_config['max_height'] = 0;

		//var_dump($filename);var_dump($file_config); var_dump($_FILES); exit;

    	$this->load->library('upload', $file_config);

    	//var_dump($this->upload->do_upload($filename)); //exit;

    	if ( ! $this->upload->do_upload($filename))

    	{

    		$result = $this->upload->display_errors();

    	}else{

    		$data['upload_data'] = $this->upload->data();

    		$img = $data['upload_data']['file_name'];

			//var_dump($img);

			$img_display = substr($img,16);

    			

    		$output_image_data = 'New Uploaded file : '.$img_display;

    		$output_image_data .= '<input type="hidden" name="docs_pdf" id="docs_pdf" value="'.$img.'" />';

    		$result = 'docs-upload-success';

    		

    	}

    

    	sleep(1);

    	?>

    		<script language="javascript" type="text/javascript">window.top.window.stopUpload('<?php echo $result; ?>', '<?php echo $output_image_data;?>', 'logo_image22', '<?php echo $filename;?>', '<?php echo $form_id;?>');</script>   

    		<?php

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

		//var_dump($file_config); exit;

		$this->load->library('upload', $file_config); 

		//var_dump($this->load->library('upload', $file_config)); exit;

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

	

	function upload_mar_mat($filename, $form_id){ 

    	//loading file upload library and setting up variables

    	//var_dump($filename); var_dump($form_id); //exit;

		$new_filename = 'busix_'.time();//var_dump($new_filename); exit;

    	$result = '';

    	$output_image_data = '';

   		

		$new_filename='busi_'.time().'_'.$_REQUEST['mmx'];

		

		

    	$file_config = array();

    	$file_config['upload_path'] = "./uploads/market_materials/";

    	$file_config['max_size'] = "1024";

    	$file_config['allowed_types'] = "docx|doc|pdf|xlsx";

    	//$file_config['file_name'] = $new_filename;

    	$file_config['max_width'] = 0;

    	$file_config['max_height'] = 0;

		//var_dump($filename);var_dump($file_config); var_dump($_FILES); exit;

    	$this->load->library('upload', $file_config);

    	//var_dump($this->upload->do_upload($filename)); //exit;

    	if ( ! $this->upload->do_upload($filename,'market'))

    	{

    		$result = $this->upload->display_errors();

    	}else{

    		$data['upload_data'] = $this->upload->data();

    		$img = $data['upload_data']['file_name'];

			$img_display = explode('~!~',$img);

    			

    		$output_image_data = 'New Uploaded file : '.$img_display[2];

    		$output_image_data .= '<input type="hidden" name="ups_mm" id="ups_mm" value="'.$img.'" />';

    		$result = 'docs-upload-success';

    		

    	}

    

    	sleep(1);

    	?>

    		<script language="javascript" type="text/javascript">window.top.window.stopUpload('<?php echo $result; ?>', '<?php echo $output_image_data;?>', 'market', '<?php echo $filename;?>', '<?php echo $form_id;?>');</script>   

    		<?php

	}

		

	



	function createABusiness($msg=false)

	{

		//var_dump($msg);

		if($this->ion_auth->logged_in()){

        $data = array();



        $auser = $this->ion_auth->user()->row();

		//var_dump($auser);

        if(!empty($auser)){

	        $uid = $auser->id;

			$data["uid"]=$uid;

			$data["usergroup"]=$this->business->get_user_group1($uid);

			//var_dump($data["usergroup"]);

			$user_group=$this->business->get_user_group1($uid);

			//var_dump($data["usergroup"]);

			//echo $data["usergroup"]->group_id;

			//$ppg=$this->business->get_user_group1($uid);

			//echo $grid=$data["usergroup"]->group_id;

			//var_dump($data);

	        $data["email"] = $auser->email;

	        $data["firstName"] = $auser->first_name;

	        $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

	        

	        $data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

	        $data['business_owner_new'] = $this->business->business_owner_user($uid);

        }

        $data['msg']=$msg;

        $data['user'] = $auser;

        

        $data['zone_null'] = 'create_business';

        

        $data['referrer'] = !empty($_REQUEST['Referrer']) ? $_REQUEST['Referrer'] : 'dashboards';

        $data['state_list'] = $this->states->get_state_dropdown();

        //$data['users_list'] = $this->users->get_user_list(true);

		

		$users_all_zone = $this->sales_zone->users_all_zone($uid);

		if($data["usergroup"]->group_id==4){

		$data['users_list'] = $this->users->get_user_list_zone($users_all_zone);

		}

		//var_dump($data['get_user_list_zone']);

		$data['ckeditor_staterad'] = array(



            //ID of the textarea that will be replaced

            'id' 	=> 	'stater_ad_message',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



            ));

        $data['hideSlider'] = true;

		//$scripts = array("assets/scripts/jquery.tools.min.js");

		//$data['scripts'] = $scripts;

		//var_dump ($data);

        $data['right_container'] = $this->load->view("dashboards/create_a_business", $data, true);

        $data['content'] = $this->load->view("content", $data, true);

        $this->load->view("default/blank", $data);



	}else{

		$data1=array('createabusiness' => TRUE );

		$this->session->set_userdata($data1); 

		$data = array();

        $data['hideSlider'] = true;

        $data['class']="login";

		$scripts = array("assets/scripts/jquery.tools.min.js");

		$data['scripts'] = $scripts;

		$data['content'] = $this->load->view('default/zone_login', $data, true);

        $this->load->view('default/blank', $data);

		}	

	}

	public function createBusiness()

	{

		//var_dump($data);exit;

		//var_dump($_REQUEST['zone_id']); exit;

		//var_dump($_REQUEST); exit;

		

	    $name = !empty($_REQUEST['name'])? stripslashes($_REQUEST['name']) : '';

		//var_dump($name); exit;

        $addressid = !empty($_REQUEST['addressid']) ? $_REQUEST['addressid'] : '';

        $contactemail = !empty($_REQUEST['contactemail']) ? $_REQUEST['contactemail'] : '';

        $website = !empty($_REQUEST['website']) ? $_REQUEST['website'] : '';

		$siccode = !empty($_REQUEST['siccode']) ? $_REQUEST['siccode'] : '';

        $contactfirstname = !empty($_REQUEST['contactfirstname']) ? stripslashes($_REQUEST['contactfirstname']): '' ;

        $contactlastname = !empty($_REQUEST['contactlastname']) ? stripslashes($_REQUEST['contactlastname']) : '' ;

		$contactfullname = !empty($_REQUEST['contactfullname']) ? stripslashes($_REQUEST['contactfullname']) : '' ;   // add 05.02.2013

        //$business_owner_id = $_REQUEST['business_owner_id']; //var_dump($business_owner_id);  exit;

        $street1 = !empty($_REQUEST['street1']) ? stripslashes($_REQUEST['street1']) : '' ;

        $street2 =  !empty($_REQUEST['street2']) ? stripslashes($_REQUEST['street2']) : '' ;

        $city = !empty($_REQUEST['city']) ? stripslashes($_REQUEST['city']) : '' ;

        $state = !empty($_REQUEST['city']) ? $_REQUEST['state'] : '' ;

        $zipcode = !empty($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : 0 ;

        $phone = !empty($_REQUEST['phone']) ? $_REQUEST['phone'] : '' ;

		$motto = !empty($_REQUEST['motto']) ? $_REQUEST['motto'] : '' ;

		$logo = $_REQUEST['logo'];

		//$current_zone_id = $_REQUEST['current_zone_id'];		

		//$zone_id_null = $_REQUEST['zone_id_null'];

		$zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;

		$is_stater_ad = !empty($_REQUEST['is_starter_ad']) ? $_REQUEST['is_starter_ad'] : 0;

		$stater_ad = !empty($_REQUEST['stater_ad']) ? stripslashes($_REQUEST['stater_ad']) : '';

		//var_dump($zone_id); exit;

		if($zipcode!=0 || $zone_id!=0){

		if($zipcode!='' && $zipcode!='0'){

		$auser = $this->ion_auth->user()->row();

	    $uid = $auser->id;

		

		

		/*$zone_owner_details=$this->users->get_user_details($uid);

		var_dump($zone_owner_details); exit;*/

		

		

		

		

		$data = array(

			'logo' => $logo,

            'name' => $name,

            'contactemail' => $contactemail,

            'contactfirstname' => $contactfirstname,

            'contactlastname' => $contactlastname,

			'contactfullname' => $contactfullname,

			'motto' => $motto ,

			'siccode' =>$siccode,

			'created_by' =>$uid  

			//'stater_ad' => $stater_ad

        ); //var_dump($data); exit;

		

		/*$data['ckeditor_staterad'] = array(



            //ID of the textarea that will be replaced

            'id' 	=> 	'stater_ad_message',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



            ));*/

		

		

		

		

        if (!empty($website)) {

            $data['website'] = $website;

        }

        $address = '';

        if ($street1 != '') {

            $address .= $street1;

        }

        if ($street2 != '') {

            if ($address != '') {

                $address .= ',' . $street2;

            } else {

                $address .= $street2;

            }



        }

        if ($city != '') {

            if ($address != '') {

                $address .= ',' . $city;

            } else {

                $address .= $city;

            }



        }

        if ($state != '') {

            if ($address != '') {

                $address .= ',' . $state;

            } else {

                $address .= $state;

            }



        }

        if ($zipcode != '') {

            if ($address != '') {

                $address .= ',' . $zipcode;

            } else {

                $address .= $zipcode;

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



		$lat='';

		$long='';



		if(is_object($response_a) && isset($response_a->results[0])){

			$lat = $response_a->results[0]->geometry->location->lat;

			$long = $response_a->results[0]->geometry->location->lng;

		}



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

		if (!empty($addressid)) {

            $data['addressid'] = $addressid;

        }

		

		$a=$this->business->get_user_group1($uid); //var_dump($data["usergroup"]); exit;

		$grid=$a->group_id;

		

		if($grid!=5){ // 4 = zone owner, 5 = business owner

        	

			$owner_account_type = $_REQUEST['owner_account_type']; //var_dump($owner_account_type); exit;

			if($owner_account_type==1){

				$data['business_owner_id']=$uid;

			}else if($owner_account_type==2){

				$username = $_REQUEST['username'];

        		$password = $_REQUEST['password'];

				$data['business_owner_id']=0;

			}else if($owner_account_type==3){

				$data['business_owner_id']=$_REQUEST['existing_owner_id'];

			}

			$businesstype=$_REQUEST['businesstype'];

			

		}else{

		$businesstype='0';

		$owner_account_type=0;

		//var_dump($businesstype); exit;

		$data['business_owner_id']=$uid;

		}

       

		

		if($owner_account_type==2 && $data['business_owner_id']==0){ //var_dump($owner_account_type); var_dump($data['business_owner_id']); //exit;

			$additional_data = array('first_name' => $contactfirstname,'last_name' => $contactlastname);

            //var_dump($additional_data); var_dump($username); var_dump($password);

			$business_owner_id_1 = $this->ion_auth->register($username, $password, $contactemail, $additional_data);

			//var_dump($business_owner_id_1); exit;

			$data['business_owner_id'] = $business_owner_id_1;

			//var_dump($data['business_owner_id']); exit;

			if($data['business_owner_id']==0){

				$data['business_owner_id']=$uid;

			}

		}



		//commented by saswata+++++++++++++++++++++++

		//$zone_id=7;

       /* $bu_detail=$this->business->get_all_business_details($zone_id);

		echo '<pre>';

		echo count($bu_detail);

		var_dump($bu_detail);

		echo '<table>

				<tr>

					<td>

						<tr>

							<td colspan="2"></td>

						</tr>

						<tr></tr>

					</td>

					<td></td>

				</tr>

			</table>	

		';

		die ();*/

        //insert

		//var_dump($data); exit;

		//commented by saswata------------------

		

        $this->db->insert('address', $addressData);

        $data['addressid'] = $this->db->insert_id();

        $this->db->insert('business', $data);

        $id = $this->db->insert_id();

		

		/*$this->load->library('email');

		$template_subject="Create your business";

		$message="<a href=\"#\" style=\"display: block; margin: 0pt 0pt 10px;\"><p></a>

		  <p style=\"margin: 0pt 0pt 9px; font-size: 14px; line-height: 18px; font-family: Arial,Helvetica,Verdana,sans-serif;\"></p>

		  <p style=\"margin: 0pt 0pt 4px; font-size: 14px; line-height: 18px; font-family: Arial,Helvetica,Verdana,sans-serif;\">Hi, {EMAILID}</p>

		  <p style=\"margin: 0pt 0pt 4px; font-size: 14px; line-height: 18px; font-family: Arial,Helvetica,Verdana,sans-serif;\">{NAME} invites you to join the <strong>{PLUGIN}</strong> .</p>

		   <p style=\"margin: 0pt 0pt 9px; font-size: 14px; line-height: 18px; font-family: Arial,Helvetica,Verdana,sans-serif;\"></p>

		<p style=\"margin: 0pt 0pt 9px; font-size: 14px; line-height: 18px; font-family: Arial,Helvetica,Verdana,sans-serif;\">To see more details, follow the link below:

		<br/>{LINK}<br/></p>

		<p style=\"margin: 0pt 0pt 4px; font-size: 12px; line-height: 10px; font-family: Arial,Helvetica,Verdana,sans-serif;\">

		</p><p style=\"font-size: 12px;  font-family: Arial,Helvetica,Verdana,sans-serif;\"><br />Savings Sites 2012</p>";

		$this->email->clear();

		$this->email->from($auser->email);

		//$message=str_replace($shortcode, $replace, $template);

		$this->email->subject($template_subject);

		$this->email->message($message);

		if($contactemail!='')

		{

			$this->email->to($contactemail);

			$this->email->send();

			$to[]=$contactemail;

		}*/

		

		$bu_detail=$this->business->get_all_business_details($zone_id);		

		$zone_owner_details=$this->users->get_user_details($uid);

		if(!empty($zone_owner_details)){

			$_zone_owner_email=$zone_owner_details['email'];

			$_zone_owner_name=$zone_owner_details['last_name'].','.$zone_owner_details['first_name'];

		}

		$a='<table>

				<tr>

					<td width="275">

						<table>

							<tr>

								<td  colspan="2">Zone Details</td>

							</tr>



							<tr>                    

								<td width="132" height="42">UserName</td>

								<td width="131"> Zone</td>                          

							</tr>

						</table>

					</td>

					<td width="265">

						<table>

							<tr>

								<td colspan="2">Buisness Details</td> 

							</tr>';

							

								for($i=0;$i<count($bu_detail);$i++)

								{ 

								$b='           

								<tr>

									<td width="140">UserName</td>

									<td width="113">'.$bu_detail[$i]['bus_name'].'</td>

								</tr>	

								<tr>

									<td>Email</td>

									<td>'.$bu_detail[$i]['email'].'</td>

								</tr>';								

								}

						$c='		

						</table>

					</td>

				</tr>

			</table>

		';

		$s=$a.$b.$c;

		$message_body=$s; 

		

				

		$fromemail='noreply@savingssites.com';

		$this->load->library('email');

		$email_subject="Information related with zone";

		$this->email->clear();

		$this->email->from($fromemail);

		$this->email->subject($email_subject);

		$this->email->message($message_body);

		if($_zone_owner_email!='')

		{

			$this->email->to($_zone_owner_email);

			$this->email->send();

			$to[]=$result->email;

		}

		

		$businesszonedata = array(

                   'buszoneid'=>$zone_id

        );

		$this->session->set_userdata('businesszonedata',$businesszonedata); // assign session for create business from particular zone  29.01.2013

		$data['save_default_zone_ads_pref'] = $this->business->save_business_approval($id,$zone_id,$businesstype,$grid);

		if($is_stater_ad==1){

		$data['stater_ad']=$this->ads->save_stater_ad_business($id,$zone_id,$stater_ad);

		}

		

		$message=2;

		}

		

		}else{

			$message=3;

		}

		//var_dump($message);

        echo($this->dr->GetDR("Success", $message, "", "0"));

		

    }

	

	public function SaveBusiness()

    {

		//var_dump($_REQUEST); exit;

        //var_dump(1); exit;

		//Add code to

        // 1. Save Business Data

        // 2. Get Geolocation Data Only If Address Changed

        // 3. Save Address Data

        // 4. Logo???

        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

		//$logo = stripslashes($_REQUEST['logo']);

		//echo 'Partha'.$zoneids = empty($_REQUEST['zone_ids']) ? 0 : $_REQUEST['zone_ids']; echo '<br/>'; 

		//echo 'Gayen'.$zoneids = $_REQUEST['zoneids']; echo '<br/>';

		//exit;

		$zoneids = empty($_REQUEST['zone_ids']) ? 0 : $_REQUEST['zone_ids'];

		$zone_id = empty($_REQUEST['zoneids']) ? 0 : $_REQUEST['zoneids'];

		//var_dump($zoneids);  exit;

        $name = stripslashes($_REQUEST['name']);

        $addressid = $_REQUEST['addressid'];

        $contactemail = $_REQUEST['contactemail'];

        $website = !empty($_REQUEST['website']) ? $_REQUEST['website'] : '';

        $contactfirstname = stripslashes($_REQUEST['contactfirstname']);

        $contactlastname = stripslashes($_REQUEST['contactlastname']);

		$contactfullname = !empty($_REQUEST['contactfullname']) ? stripslashes($_REQUEST['contactfullname']) : '' ;   // add 06.02.2013

        $business_owner_id = $_REQUEST['business_owner_id'];

        $street1 = stripslashes($_REQUEST['street1']);

        $street2 = stripslashes($_REQUEST['street2']);

        $city = stripslashes($_REQUEST['city']);

        $state = $_REQUEST['state'];

        $zipcode = $_REQUEST['zipcode'];

        $phone = $_REQUEST['phone'];

		$logo = $_REQUEST['logo'];

		/*$username = $_REQUEST['username'];

		$password = $_REQUEST['password'];*/

		$biz_type = $_REQUEST['biz_type'];

		$motto = stripslashes($_REQUEST['biz_motto']);

		

        $data = array(

			'logo' => $logo,

            'name' => $name,

            'contactemail' => $contactemail,

            'contactfirstname' => $contactfirstname,

            'contactlastname' => $contactlastname,

			'contactfullname' =>$contactfullname,

			'motto' => $motto

        );





        if (!empty($website)) {

            $data['website'] = $website;

        }

        $address = '';

        if ($street1 != '') {

            $address .= $street1;

        }

        if ($street2 != '') {

            if ($address != '') {

                $address .= ',' . $street2;

            } else {

                $address .= $street2;



            }

        }

        if ($city != '') {

            if ($address != '') {

                $address .= ',' . $city;

            } else {

                $address .= $city;

            }



        }

        if ($state != '') {

            if ($address != '') {

                $address .= ',' . $state;

            } else {

                $address .= $state;

            }



        }

        if ($zipcode != '') {

            if ($address != '') {

                $address .= ',' . $zipcode;

            } else {

                $address .= $zipcode;

            }



        }



        $address = urlencode($address);

       /* $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);

        curl_close($ch);

        $response_a = json_decode($response);



        $lat='';

		$long='';



		if(is_object($response_a) && isset($response_a->results[0])){

			$lat = $response_a->results[0]->geometry->location->lat;

			$long = $response_a->results[0]->geometry->location->lng;

		}*/

		 $lat='';

		$long='';

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





        /*if (!empty($business_owner_id)) {





            $data['business_owner_id'] = $business_owner_id;



        }*/

		//$data['zonename'] = $this->business->get_zonename($id);

        $data['business_owner_id'] = $business_owner_id;

        if (!empty($business_owner_id)) {

        	if($business_owner_id < 0)

        	{

        		//create an owner

        		$additional_data = array('first_name' => $contactfirstname,

        				'last_name' => $contactlastname

        		);

        

        		$business_owner_id = $this->ion_auth->register($username, $password, $contactemail, $additional_data);

        

        	}

        	$data['business_owner_id'] = $business_owner_id;

        

        }



        if (!empty($addressid)) {



            $data['addressid'] = $addressid;



        }





        if (!empty($id) && $id > 0) {



            if (!empty($addressid) && $addressid > 0) {



                $this->db->where('id', $addressid);



                $this->db->update('address', $addressData);



            } else {



                $this->db->insert('address', $addressData);



                $data['addressid'] = $this->db->insert_id();



            }



            //update

            $this->db->where('id', $id);



            $this->db->update('business', $data);



            /*26-10-2012*/

            $data_zone = array();

            $sql="select id from sales_zone where sales_rep_id = ".$data['business_owner_id'];

            $query = $this->db->query($sql);

            

            $data_zone['business_id']=$id;

            $data_zone['zone_owner_id']=$data['business_owner_id'];

            

            if($query->row())

            {

            	$this->db->where('business_id', $id);

            	$this->db->update('business_zone_owners', $data_zone);

            }

            else

            {

            	$result = $this->db->query("select * from zone_managers where user_id = ".$data['business_owner_id'])->result_array();

            	if(!empty($result))

            	{

            		$result1 = $this->db->query("select sales_rep_id from sales_zone where id = ".$result[0]['zone_id'])->result_array();

            		$data_zone['zone_owner_id']=$result1[0]['sales_rep_id'];

            

            		$this->db->where('business_id', $id);

            		$this->db->update('business_zone_owners', $data_zone);

            	}

            }

			if($zoneids==0){

				$zoneids=$zone_id ;

			}

            /*26-10-2012*/

			$data_zone = array(

				'business_id' => $id,

            	'zone_id' => $zoneids,

            	'date_added' => date('Y-m-d H:i:s'),

            	'act_deact' => 0

        	);

        	$sql="select zone_id from business_to_zone where business_id = ".$id;

       	 	$query = $this->db->query($sql);

        	if($query->row())

        	{

            	$this->db->where('business_id',$id);

            	$this->db->update('business_to_zone', $data_zone);

				// ad setting preferences update

				if($zoneids!=0){

					$sqledit="SELECT id FROM ads_setting_preferences WHERE settingszoneid='0' AND businessid=".$id;

					$query_edit =$this->db->query($sqledit);

					if($query_edit->row()){

						$zonedata=array('settingszoneid'=>$zoneids);

						$this->db->where('businessid',$id);

						$this->db->update('ads_setting_preferences', $zonedata);

					}else{

						$data['business_zone_change'] = $this->business->business_zone_change_new($id,$zoneids,$biz_type);

						//var_dump($data['business_zone_change']);

					}

				}

				

				//var_dump($data['business_zone_change']);

        	}else{

				$this->db->insert('business_to_zone', $data_zone);

        		//$zids = $this->db->insert_id();

			}



        } else {



            //insert



            $this->db->insert('address', $addressData);

            $data['addressid'] = $this->db->insert_id();

            $this->db->insert('business', $data);

            $bus_id = $this->db->insert_id();

            

            /*26-10-2012*/

            $data_zone = array();

            $sql="select id from sales_zone where sales_rep_id = ".$data['business_owner_id'];

            $query = $this->db->query($sql);

            

            $data_zone['business_id']=$bus_id;

            $data_zone['zone_owner_id']=$data['business_owner_id'];

            

            if($query->row())

            {

            	$this->db->insert('business_zone_owners', $data_zone);

            }

            else

            {

            	$result = $this->db->query("select * from zone_managers where user_id = ".$data['business_owner_id'])->result_array();

            	if(!empty($result))

            	{

            		$result1 = $this->db->query("select sales_rep_id from sales_zone where id = ".$result[0]['zone_id'])->result_array();

            		$data_zone['zone_owner_id']=$result1[0]['sales_rep_id'];

            		$this->db->insert('business_zone_owners', $data_zone);

            	}

            }

            /*26-10-2012*/



        }



        

        $user = $this->ion_auth->user();

        $auser = $user->row();

        

        

        $sql="select id from sales_zone where sales_rep_id = ".$data['business_owner_id'];

        $data = array();

        $data['zone_owner']='';

        $query = $this->db->query($sql);

        

        if($query->row())

        {

        	$result = $query->row();

        	$data['zone_owner']=$result->id;

        }

        

        $data['users_list'] = $this->users->get_user_list(true);

        

        $data['business'] = $this->business->get_business_by_id($id);

		$data['zonename'] = $this->business->get_zonename($id);

        $data['business_owner'] = $this->users->get_by_id($data['business']->business_owner_id);

		$data['business_type']=$this->business->get_business_type_by_id($id,$zoneids);

		//var_dump($data['business_type']);

		// update portion(ads_setting_preferences) start 18.01.2013

		/*if($zoneids!=0){

			$sqledit="SELECT id FROM ads_setting_preferences WHERE settingszoneid='0' AND businessid=".$id;

        	$query_edit =$this->db->query($sqledit);

			if($query_edit->row()){

				$zonedata=array('settingszoneid'=>$zoneids);

				$this->db->where('businessid',$id);

            	$this->db->update('ads_setting_preferences', $zonedata);

			}

		}*/

		// update portion(ads_setting_preferences) end 18.01.2013

		//var_dump($data);

		$data['result']=$this->ads->getBusinessByID($id);    // add 22.01.13

		$data['address']=$this->ads->getBusinessAddresByID($data['result']['addressid']); // add 22.01.13

		$data['state_list']=$this->states->get_state_dropdown(); // add 22.01.13

        $data["business_part_data_view"] = $this->load->view("dashboards/business_parts/data_view", $data, true);



        echo($this->dr->GetDR("Save Complete", "Save Completed...", $data["business_part_data_view"], "0"));

    }

	public function SaveBusinessfromZone()

    {

		$zoneuser = $this->ion_auth->user()->row();

	    $userid = $zoneuser->id;

		//var_dump($_REQUEST); exit;

        //var_dump(1); exit;

		//Add code to

        // 1. Save Business Data

        // 2. Get Geolocation Data Only If Address Changed

        // 3. Save Address Data

        // 4. Logo???

        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

		//$logo = stripslashes($_REQUEST['logo']);

		//echo 'Partha'.$zoneids = empty($_REQUEST['zone_ids']) ? 0 : $_REQUEST['zone_ids']; echo '<br/>'; 

		//echo 'Gayen'.$zoneids = $_REQUEST['zoneids']; echo '<br/>';

		//exit;

		$zoneids = empty($_REQUEST['zone_ids']) ? 0 : $_REQUEST['zone_ids'];

		$zone_id = empty($_REQUEST['zoneids']) ? 0 : $_REQUEST['zoneids'];

		//var_dump($zoneids); var_dump($zone_id);  exit; 

        $name = stripslashes($_REQUEST['name']);

        $addressid = $_REQUEST['addressid'];

        $contactemail = $_REQUEST['contactemail'];

        $website = !empty($_REQUEST['website']) ? $_REQUEST['website'] : '';

		$siccode = !empty($_REQUEST['siccode']) ? $_REQUEST['siccode'] : '';

        $contactfirstname = stripslashes($_REQUEST['contactfirstname']);

        $contactlastname = stripslashes($_REQUEST['contactlastname']);

		$contactfullname = !empty($_REQUEST['contactfullname']) ? stripslashes($_REQUEST['contactfullname']) : '' ;   // add 06.02.2013

		if($_REQUEST['biz_owner_type']==1){

			$business_owner_id = $userid;

		}else{

        	$business_owner_id = $_REQUEST['business_owner_id'];

		}

        $street1 = stripslashes($_REQUEST['street1']);

        $street2 = stripslashes($_REQUEST['street2']);

        $city = stripslashes($_REQUEST['city']);

        $state = $_REQUEST['state'];

        $zipcode = $_REQUEST['zipcode'];

        $phone = $_REQUEST['phone'];

		$logo = $_REQUEST['logo'];

		/*$username = $_REQUEST['username'];

		$password = $_REQUEST['password'];*/

		$biz_type = $_REQUEST['biz_type'];

		$motto = $_REQUEST['biz_motto'];

		$email_verification=$_REQUEST['email_verification'];

		$new_uname = empty($_REQUEST['new_username']) ? 0 : $_REQUEST['new_username'];

		$new_password = empty($_REQUEST['new_password']) ? 0 : $_REQUEST['new_password'];

		//$new_uname=$_REQUEST['new_username'];

		//$new_password=$_REQUEST['new_password'];

		//var_dump($new_password); //exit;

        $data = array(

			'logo' => $logo,

            'name' => $name,

            'contactemail' => $contactemail,

            'contactfirstname' => $contactfirstname,

            'contactlastname' => $contactlastname,

			'contactfullname' =>$contactfullname,

			'motto' => stripslashes($motto),

			'siccode' => $siccode

        );

		//var_dump($data);



        if (!empty($website)) {

            $data['website'] = $website;

        }

        $address = '';

        if ($street1 != '') {

            $address .= $street1;

        }

        if ($street2 != '') {

            if ($address != '') {

                $address .= ',' . $street2;

            } else {

                $address .= $street2;



            }

        }

        if ($city != '') {

            if ($address != '') {

                $address .= ',' . $city;

            } else {

                $address .= $city;

            }



        }

        if ($state != '') {

            if ($address != '') {

                $address .= ',' . $state;

            } else {

                $address .= $state;

            }



        }

        if ($zipcode != '') {

            if ($address != '') {

                $address .= ',' . $zipcode;

            } else {

                $address .= $zipcode;

            }



        }



        $address = urlencode($address);

       /* $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);

        curl_close($ch);

        $response_a = json_decode($response);



        $lat='';

		$long='';



		if(is_object($response_a) && isset($response_a->results[0])){

			$lat = $response_a->results[0]->geometry->location->lat;

			$long = $response_a->results[0]->geometry->location->lng;

		}*/

		 $lat='';

		$long='';

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





        /*if (!empty($business_owner_id)) {





            $data['business_owner_id'] = $business_owner_id;



        }*/

		//$data['zonename'] = $this->business->get_zonename($id);

        $data['business_owner_id'] = $business_owner_id;

        if (!empty($business_owner_id)) {

        	if($business_owner_id < 0)

        	{

        		//create an owner

        		$additional_data = array('first_name' => $contactfirstname,

        				'last_name' => $contactlastname

        		);

        

        		$business_owner_id = $this->ion_auth->register($username, $password, $contactemail, $additional_data);

        

        	}

        	$data['business_owner_id'] = $business_owner_id;

        

        }



        if (!empty($addressid)) {



            $data['addressid'] = $addressid;



        }





        if (!empty($id) && $id > 0) {



            if (!empty($addressid) && $addressid > 0) {



                $this->db->where('id', $addressid);



                $this->db->update('address', $addressData);



            } else {



                $this->db->insert('address', $addressData);



                $data['addressid'] = $this->db->insert_id();



            }



            //update

            $this->db->where('id', $id);



            $this->db->update('business', $data);



            /*26-10-2012*/

            $data_zone = array();

            $sql="select id from sales_zone where sales_rep_id = ".$data['business_owner_id'];

            $query = $this->db->query($sql);

            

            $data_zone['business_id']=$id;

            $data_zone['zone_owner_id']=$data['business_owner_id'];

            

            if($query->row())

            {

            	$this->db->where('business_id', $id);

            	$this->db->update('business_zone_owners', $data_zone);

            }

            else

            {

            	$result = $this->db->query("select * from zone_managers where user_id = ".$data['business_owner_id'])->result_array();

            	if(!empty($result))

            	{

            		$result1 = $this->db->query("select sales_rep_id from sales_zone where id = ".$result[0]['zone_id'])->result_array();

            		$data_zone['zone_owner_id']=$result1[0]['sales_rep_id'];

            

            		$this->db->where('business_id', $id);

            		$this->db->update('business_zone_owners', $data_zone);

            	}

            }

			if($zoneids==0){

				$zoneids=$zone_id ;

			}

            /*26-10-2012*/

			$data_zone = array(

				'business_id' => $id,

            	'zone_id' => $zoneids,

            	'date_added' => date('Y-m-d H:i:s'),

            	'act_deact' => 0

        	);

        	$sql="select zone_id from business_to_zone where business_id = ".$id;

       	 	$query = $this->db->query($sql);

        	if($query->row())

        	{

            	$this->db->where('business_id',$id);

            	$this->db->update('business_to_zone', $data_zone);

				// ad setting preferences update

				if($zone_id!=0){ //var_dump($zone_id); exit;

					$sqledit="SELECT id FROM ads_setting_preferences WHERE settingszoneid='0' AND businessid=".$id;

					$query_edit =$this->db->query($sqledit);

					//var_dump($query_edit);

					if($query_edit->row()){ //var_dump(1);

						$zonedata=array('settingszoneid'=>$zoneids);

						$this->db->where('businessid',$id);

						$this->db->update('ads_setting_preferences', $zonedata);

					}else{ //var_dump(2);

						$data['business_zone_change'] = $this->business->business_zone_change_new($id,$zoneids,$biz_type);

						//var_dump($data['business_zone_change']);

					}

				}

				

				//var_dump($data['business_zone_change']);

        	}else{

				$this->db->insert('business_to_zone', $data_zone);

        		//$zids = $this->db->insert_id();

			}



        } else {



            //insert



            $this->db->insert('address', $addressData);

            $data['addressid'] = $this->db->insert_id();

            $this->db->insert('business', $data);

            $bus_id = $this->db->insert_id();

            

            /*26-10-2012*/

            $data_zone = array();

            $sql="select id from sales_zone where sales_rep_id = ".$data['business_owner_id'];

            $query = $this->db->query($sql);

            

            $data_zone['business_id']=$bus_id;

            $data_zone['zone_owner_id']=$data['business_owner_id'];

            

            if($query->row())

            {

            	$this->db->insert('business_zone_owners', $data_zone);

            }

            else

            {

            	$result = $this->db->query("select * from zone_managers where user_id = ".$data['business_owner_id'])->result_array();

            	if(!empty($result))

            	{

            		$result1 = $this->db->query("select sales_rep_id from sales_zone where id = ".$result[0]['zone_id'])->result_array();

            		$data_zone['zone_owner_id']=$result1[0]['sales_rep_id'];

            		$this->db->insert('business_zone_owners', $data_zone);

            	}

            }

            /*26-10-2012*/



        }



        

        $user = $this->ion_auth->user();

        $auser = $user->row();

        

        

        $sql="select id from sales_zone where sales_rep_id = ".$data['business_owner_id'];

        $data = array();

        $data['zone_owner']='';

        $query = $this->db->query($sql);

        

        if($query->row())

        {

        	$result = $query->row();

        	$data['zone_owner']=$result->id;

        }

        

        $data['users_list'] = $this->users->get_user_list(true);

        

        $data['business'] = $this->business->get_business_by_id($id);

		$data['zonename'] = $this->business->get_zonename($id);

        $data['business_owner'] = $this->users->get_by_id($data['business']->business_owner_id);

		$data['business_type']=$this->business->get_business_type_by_id($id,$zoneids);

		//var_dump($data['business_type']);

		// update portion(ads_setting_preferences) start 18.01.2013

		/*if($zoneids!=0){

			$sqledit="SELECT id FROM ads_setting_preferences WHERE settingszoneid='0' AND businessid=".$id;

        	$query_edit =$this->db->query($sqledit);

			if($query_edit->row()){

				$zonedata=array('settingszoneid'=>$zoneids);

				$this->db->where('businessid',$id);

            	$this->db->update('ads_setting_preferences', $zonedata);

			}

		}*/

		// update portion(ads_setting_preferences) end 18.01.2013

		//var_dump($data);

		$data['result']=$this->ads->getBusinessByID($id);    // add 22.01.13

		//var_dump($data['result']);

		$data['address']=$this->ads->getBusinessAddresByID($data['result']['addressid']); // add 22.01.13

		$data['state_list']=$this->states->get_state_dropdown(); // add 22.01.13

		if($email_verification==1){

			$data['email_notification']=$this->business->get_business_update($id); // 30.1.13

			$data['businessinf']=$this->business->specific_business_information($id);

			$fname=$data['businessinf']->first_name;

			$busemail=$data['businessinf']->email;

			$data['zoneinformation'] = $this->announcements->get_zoneinformation($zoneids); // get zone informations

			$zonename=$data['zoneinformation']->zname;

			$zoneowneremail=$data['zoneinformation']->email;

			$zoneownerfname=$data['zoneinformation']->first_name;

			$zoneownerlname=$data['zoneinformation']->last_name;

			$link="http://savingssites.com/welcome/business_verification_user/".$id;

			$message_body="<div style='border:1px solid #900; padding:5px;'>Dear ".$fname.",<br /><br />

				Your business type has been changed on SavingsSites by <strong>".$zoneownerfname." ".$zoneownerlname."</strong> (".$zoneowneremail.").<br/><br/>								

				

				To complete your business verification, simple click <a href='".$link."'> here </a> .<br/><br/>

				

									

				You can login into your account and change this information at your convenience.<br /><br />

				We are constantly trying to improve the application and will notify you of future updates as and when they are available. If you have any queries in the meantime then please email us at <a href='mailto:support@savingssites.com'>support@savingssites.com</a> and we will get back to you promptly.<br /><br />

				Best Regards,<br />

				Savings Sites Support." ;

			$fromemail='noreply@savingssites.com';

			$this->load->library('email');

			$template_subject="Savings Sites Business verification";

			$this->email->clear();

			$this->email->from($fromemail);

			$this->email->subject($template_subject);

			$this->email->message($message_body);

			if($busemail!='')

			{

				$this->email->to($busemail);

				$this->email->send();

				$to[]=$email;

			}

		}

		//$data['edit_business_from_zone']=$this->ion_auth->edit_business_from_zone($business_owner_id,$new_password);                // comment 05.02.2013

		if($new_uname!=0 || $new_password!=0){

			$data['edit_business_from_zone']=$this->ion_auth->edit_business_from_zonepage($business_owner_id,$new_uname,$new_password);   // add 05.02.2013

		}

        $data["business_part_data_view"] = $this->load->view("dashboards/business_parts/data_view", $data, true);



        echo($this->dr->GetDR("Save Complete", "Save Completed...", $data["business_part_data_view"], "0"));

    }

	public function SaveListedBusinessfromZone()

    {

		$zoneuser = $this->ion_auth->user()->row();

	    $userid = $zoneuser->id;

		//var_dump($_REQUEST); exit;

        //var_dump(1); exit;

		//Add code to

        // 1. Save Business Data

        // 2. Get Geolocation Data Only If Address Changed

        // 3. Save Address Data

        // 4. Logo???

        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

		//$logo = stripslashes($_REQUEST['logo']);

		//echo 'Partha'.$zoneids = empty($_REQUEST['zone_ids']) ? 0 : $_REQUEST['zone_ids']; echo '<br/>'; 

		//echo 'Gayen'.$zoneids = $_REQUEST['zoneids']; echo '<br/>';

		//exit;

		$zoneids = empty($_REQUEST['zone_ids']) ? 0 : $_REQUEST['zone_ids'];

		$zone_id = empty($_REQUEST['zoneids']) ? 0 : $_REQUEST['zoneids'];

		//var_dump($zoneids); var_dump($zone_id);  exit; 

        $name = stripslashes($_REQUEST['name']);

        $addressid = $_REQUEST['addressid'];

        $contactemail = $_REQUEST['contactemail'];

        $website = !empty($_REQUEST['website']) ? $_REQUEST['website'] : '';

		$siccode = !empty($_REQUEST['siccode']) ? $_REQUEST['siccode'] : '';

        $contactfirstname = stripslashes($_REQUEST['contactfirstname']);

        $contactlastname = stripslashes($_REQUEST['contactlastname']);

		$contactfullname = !empty($_REQUEST['contactfullname']) ? stripslashes($_REQUEST['contactfullname']) : '' ;   // add 06.02.2013

		if($_REQUEST['biz_owner_type']==1){

			$business_owner_id = $userid;

		}else{

        	$business_owner_id = $_REQUEST['business_owner_id'];

		}

        $street1 = stripslashes($_REQUEST['street1']);

        $street2 = stripslashes($_REQUEST['street2']);

        $city = stripslashes($_REQUEST['city']);

        $state = $_REQUEST['state'];

        $zipcode = $_REQUEST['zipcode'];

        $phone = $_REQUEST['phone'];

		$logo = $_REQUEST['logo'];

		/*$username = $_REQUEST['username'];

		$password = $_REQUEST['password'];*/

		$biz_type = $_REQUEST['biz_type'];

		$motto = $_REQUEST['biz_motto'];

		$email_verification=$_REQUEST['email_verification'];

		$new_uname = empty($_REQUEST['new_username']) ? 0 : $_REQUEST['new_username'];

		$new_password = empty($_REQUEST['new_password']) ? 0 : $_REQUEST['new_password'];

		//$new_uname=$_REQUEST['new_username'];

		//$new_password=$_REQUEST['new_password'];

		//var_dump($new_password); //exit;

        $data = array(

			'logo' => $logo,

            'name' => $name,

            'contactemail' => $contactemail,

            'contactfirstname' => $contactfirstname,

            'contactlastname' => $contactlastname,

			'contactfullname' =>$contactfullname,

			'motto' => stripslashes($motto),

			'siccode' => $siccode

        );

		//var_dump($data);



        if (!empty($website)) {

            $data['website'] = $website;

        }

        $address = '';

        if ($street1 != '') {

            $address .= $street1;

        }

        if ($street2 != '') {

            if ($address != '') {

                $address .= ',' . $street2;

            } else {

                $address .= $street2;



            }

        }

        if ($city != '') {

            if ($address != '') {

                $address .= ',' . $city;

            } else {

                $address .= $city;

            }



        }

        if ($state != '') {

            if ($address != '') {

                $address .= ',' . $state;

            } else {

                $address .= $state;

            }



        }

        if ($zipcode != '') {

            if ($address != '') {

                $address .= ',' . $zipcode;

            } else {

                $address .= $zipcode;

            }



        }



        $address = urlencode($address);

       /* $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);

        curl_close($ch);

        $response_a = json_decode($response);



        $lat='';

		$long='';



		if(is_object($response_a) && isset($response_a->results[0])){

			$lat = $response_a->results[0]->geometry->location->lat;

			$long = $response_a->results[0]->geometry->location->lng;

		}*/

		 $lat='';

		$long='';

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





        /*if (!empty($business_owner_id)) {





            $data['business_owner_id'] = $business_owner_id;



        }*/

		//$data['zonename'] = $this->business->get_zonename($id);

        $data['business_owner_id'] = $business_owner_id;

        if (!empty($business_owner_id)) {

        	if($business_owner_id < 0)

        	{

        		//create an owner

        		$additional_data = array('first_name' => $contactfirstname,

        				'last_name' => $contactlastname

        		);

        

        		$business_owner_id = $this->ion_auth->register($username, $password, $contactemail, $additional_data);

        

        	}

        	$data['business_owner_id'] = $business_owner_id;

        

        }



        if (!empty($addressid)) {



            $data['addressid'] = $addressid;



        }





        if (!empty($id) && $id > 0) {



            if (!empty($addressid) && $addressid > 0) {



                $this->db->where('id', $addressid);



                $this->db->update('address', $addressData);



            } else {



                $this->db->insert('address', $addressData);



                $data['addressid'] = $this->db->insert_id();



            }



            //update

            $this->db->where('id', $id);



            $this->db->update('business', $data);



            /*26-10-2012*/

            $data_zone = array();

            $sql="select id from sales_zone where sales_rep_id = ".$data['business_owner_id'];

            $query = $this->db->query($sql);

            

            $data_zone['business_id']=$id;

            $data_zone['zone_owner_id']=$data['business_owner_id'];

            

            if($query->row())

            {

            	$this->db->where('business_id', $id);

            	$this->db->update('business_zone_owners', $data_zone);

            }

            else

            {

            	$result = $this->db->query("select * from zone_managers where user_id = ".$data['business_owner_id'])->result_array();

            	if(!empty($result))

            	{

            		$result1 = $this->db->query("select sales_rep_id from sales_zone where id = ".$result[0]['zone_id'])->result_array();

            		$data_zone['zone_owner_id']=$result1[0]['sales_rep_id'];

            

            		$this->db->where('business_id', $id);

            		$this->db->update('business_zone_owners', $data_zone);

            	}

            }

			if($zoneids==0){

				$zoneids=$zone_id ;

			}

            /*26-10-2012*/

			$data_zone = array(

				'business_id' => $id,

            	'zone_id' => $zoneids,

            	'date_added' => date('Y-m-d H:i:s'),

            	'act_deact' => 0

        	);

        	$sql="select zone_id from business_to_zone where business_id = ".$id;

       	 	$query = $this->db->query($sql);

        	if($query->row())

        	{

            	$this->db->where('business_id',$id);

            	$this->db->update('business_to_zone', $data_zone);

				// ad setting preferences update

				if($zone_id!=0){ //var_dump($zone_id); exit;

					$sqledit="SELECT id FROM ads_setting_preferences WHERE settingszoneid='0' AND businessid=".$id;

					$query_edit =$this->db->query($sqledit);

					//var_dump($query_edit);

					if($query_edit->row()){ //var_dump(1);

						$zonedata=array('settingszoneid'=>$zoneids);

						$this->db->where('businessid',$id);

						$this->db->update('ads_setting_preferences', $zonedata);

					}else{ //var_dump(2);

						$data['business_zone_change'] = $this->business->business_zone_change_new($id,$zoneids,$biz_type);

						//var_dump($data['business_zone_change']);

					}

				}

				

				//var_dump($data['business_zone_change']);

        	}else{

				$this->db->insert('business_to_zone', $data_zone);

        		//$zids = $this->db->insert_id();

			}



        } else {



            //insert



            $this->db->insert('address', $addressData);

            $data['addressid'] = $this->db->insert_id();

            $this->db->insert('business', $data);

            $bus_id = $this->db->insert_id();

            

            /*26-10-2012*/

            $data_zone = array();

            $sql="select id from sales_zone where sales_rep_id = ".$data['business_owner_id'];

            $query = $this->db->query($sql);

            

            $data_zone['business_id']=$bus_id;

            $data_zone['zone_owner_id']=$data['business_owner_id'];

            

            if($query->row())

            {

            	$this->db->insert('business_zone_owners', $data_zone);

            }

            else

            {

            	$result = $this->db->query("select * from zone_managers where user_id = ".$data['business_owner_id'])->result_array();

            	if(!empty($result))

            	{

            		$result1 = $this->db->query("select sales_rep_id from sales_zone where id = ".$result[0]['zone_id'])->result_array();

            		$data_zone['zone_owner_id']=$result1[0]['sales_rep_id'];

            		$this->db->insert('business_zone_owners', $data_zone);

            	}

            }

            /*26-10-2012*/



        }



        

        $user = $this->ion_auth->user();

        $auser = $user->row();

        

        

        $sql="select id from sales_zone where sales_rep_id = ".$data['business_owner_id'];

        $data = array();

        $data['zone_owner']='';

        $query = $this->db->query($sql);

        

        if($query->row())

        {

        	$result = $query->row();

        	$data['zone_owner']=$result->id;

        }

        

        $data['users_list'] = $this->users->get_user_list(true);

        

        $data['business'] = $this->business->get_business_by_id($id);

		$data['zonename'] = $this->business->get_zonename($id);

        $data['business_owner'] = $this->users->get_by_id($data['business']->business_owner_id);

		$data['business_type']=$this->business->get_business_type_by_id($id,$zoneids);

		//var_dump($data['business_type']);

		// update portion(ads_setting_preferences) start 18.01.2013

		/*if($zoneids!=0){

			$sqledit="SELECT id FROM ads_setting_preferences WHERE settingszoneid='0' AND businessid=".$id;

        	$query_edit =$this->db->query($sqledit);

			if($query_edit->row()){

				$zonedata=array('settingszoneid'=>$zoneids);

				$this->db->where('businessid',$id);

            	$this->db->update('ads_setting_preferences', $zonedata);

			}

		}*/

		//$data['edit_business_from_zone']=$this->ion_auth->edit_business_from_zone($business_owner_id,$new_password);                // comment 05.02.2013

		if($new_uname!=0 || $new_password!=0){

			$data['edit_business_from_zone']=$this->ion_auth->edit_business_from_zonepage($business_owner_id,$new_uname,$new_password);   // add 05.02.2013

		}

		// update portion(ads_setting_preferences) end 18.01.2013

		//var_dump($data);

		$data['result']=$this->ads->getBusinessByID($id);    // add 22.01.13

		//var_dump($data['result']);

		$data['address']=$this->ads->getBusinessAddresByID($data['result']['addressid']); // add 22.01.13

		$data['state_list']=$this->states->get_state_dropdown(); // add 22.01.13

		if($email_verification==1){

			$data['email_notification']=$this->business->get_business_update($id); // 30.1.13

			$data['businessinf']=$this->business->specific_business_information($id);

			$fname=$data['businessinf']->first_name;

			$busemail=$data['businessinf']->email;

			$data['zoneinformation'] = $this->announcements->get_zoneinformation($zoneids); // get zone informations

			$zonename=$data['zoneinformation']->zname;

			$zoneowneremail=$data['zoneinformation']->email;

			$zoneownerfname=$data['zoneinformation']->first_name;

			$zoneownerlname=$data['zoneinformation']->last_name;

			$link="http://savingssites.com/welcome/business_verification_user/".$id;

			if($biz_type==2){

				$result_bus = $this->db->query("select username from users where id = ".$business_owner_id)->result_array();

            	$bowner_username=$result_bus[0]['username'];

				if($new_password!=0){

					$bowner_password=$new_password;

				}else{

					$bowner_password='abcd1234';

				}

				$login_path = "http://savingssites.com/welcome/zone_login";

				$template_subject="Savings Sites Business Information";

				$message_body="<div style='border:1px solid #900; padding:5px;'>Dear ".$fname.",<br /><br />

				Your business is presently under \"Active Trial\" on SavingsSites by <strong>".$zoneownerfname." ".$zoneownerlname."</strong> (".$zoneowneremail.").<br/><br/>

				Your business information below listed by <strong>".$zoneownerfname." ".$zoneownerlname."</strong> is as below:<br/><br/>

				Business Name: ".$name."<br/>

				Login URL: <a href='".$login_path."'>http://savingssites.com/welcome/zone_login</a><br/>

				Username: ".$bowner_username."<br/>

				Password: ".$bowner_password."<br/><br/>

				

									

				You can login into your account and change this information at your convenience.<br /><br />

				We are constantly trying to improve the application and will notify you of future updates as and when they are available. If you have any queries in the meantime then please email us at <a href='mailto:support@savingssites.com'>support@savingssites.com</a> and we will get back to you promptly.<br /><br />

				Best Regards,<br />

				Savings Sites Support." ;

			}else{

				$template_subject="Savings Sites Business verification";

				$message_body="<div style='border:1px solid #900; padding:5px;'>Dear ".$fname.",<br /><br />

				Your business type has been changed on SavingsSites by <strong>".$zoneownerfname." ".$zoneownerlname."</strong> (".$zoneowneremail.").<br/><br/>								

				

				To complete your business verification, simple click <a href='".$link."'> here </a> .<br/><br/>

				

									

				You can login into your account and change this information at your convenience.<br /><br />

				We are constantly trying to improve the application and will notify you of future updates as and when they are available. If you have any queries in the meantime then please email us at <a href='mailto:support@savingssites.com'>support@savingssites.com</a> and we will get back to you promptly.<br /><br />

				Best Regards,<br />

				Savings Sites Support." ;

			}

			$fromemail='noreply@savingssites.com';

			$this->load->library('email');

			$this->email->clear();

			$this->email->from($fromemail);

			$this->email->subject($template_subject);

			$this->email->message($message_body);

			if($busemail!='')

			{

				$this->email->to($busemail);

				$this->email->send();

				$to[]=$email;

			}

		}

        $data["business_part_data_view"] = $this->load->view("dashboards/business_parts/data_view", $data, true);



        echo($this->dr->GetDR("Save Complete", "Save Completed...", $data["business_part_data_view"], "0"));

    }

	function zip_to_zone($zip){

		$data=array();

		$data['zip_to_zone']=$this->zip->zip_to_zone($zip); //var_dump($data['zip_to_zone']);

		$result = $this->load->view('dashboards/zip_to_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	

	

	function zip_to_zone_old($zip=false)

    {

		if($zip)

		{

			$sql="select t1.id,t1.name from sales_zone as t1 join zip_code_zone as t2 on t2.zone_id=t1.id where t2.zip_code=$zip";

			$query = $this->db->query($sql);

			

			if($query->row())

			{

				echo $query->row()->id.'####<label for="biz_zone">Zone : </label>'.$query->row()->name;

			}

			else

			{

				$zip_code_detail = $this->business->get_zip_code($zip);

				if($zip_code_detail)

				{

					echo $zip_code_detail->id.'####<label for="biz_zone">Zone : </label>'.$zip_code_detail->name;

				}else{

					$zip_code_detail = $this->business->get_zone_all();?>

					

					<label for="biz_zone">Select Zone:</label>

					<select name="biz_zone" id="biz_zone" onchange="change_zone_id(this.value);return false;">

						<?php foreach($zip_code_detail as $zone){?>

						<option value="<?php echo $zone['id'];?>"><?php echo $zone['name'];?></option>

						<?php }?>

					</select><?php 

				}

			}

		}

		exit;

    }

	function zip_to_zipnew($zip=false)

	{

			if($zip){

				$auser = $this->ion_auth->user()->row();

				if(!empty($auser)){

					$uid = $auser->id;

					$usergr=$this->business->get_user_group1($uid);

					$grtyp=$usergr->group_id;

					if($grtyp==5){  // for Business Owner

						$sql="select t1.id,t1.name,t3.first_name,t3.last_name from sales_zone as t1 join zip_code_zone as t2 on t2.zone_id=t1.id join users as t3 on t1.sales_rep_id=t3.id where t2.zip_code=$zip";

        				$query = $this->db->query($sql);

						$allzone=$query->result_array();

						if(!empty($allzone)){

						?>

						<label for="biz_zone" class="fleft">Select Zone:</label>

						<select name="biz_zone" id="biz_zone" onchange="change_zone_id(this.value);return false;" class="fright">

							<?php							

							foreach($allzone as $zone){?>

							<option value="<?php echo $zone['id'];?>"><?php echo $zone['name'];?></option>

							<?php }?>

						</select><?php }

					}else{       // for Zone Owner

						//$sql="select id,name from sales_zone where sales_rep_id=$uid";

						$sql="select t1.id,t1.name,t3.first_name,t3.last_name from sales_zone as t1 join zip_code_zone as t2 on t2.zone_id=t1.id join users as t3 on t1.sales_rep_id=t3.id where t2.zip_code=$zip";

        				$query = $this->db->query($sql);

						$allzone=$query->result_array();

						if(!empty($allzone)){?>

						<label for="biz_zone" class="fleft">Select Zone:</label>

						<select name="biz_zone" id="biz_zone" onchange="change_zone_id(this.value);return false;" class="fright">

							<?php foreach($allzone as $zone){?>

							<option value="<?php echo $zone['id'];?>"><?php echo $zone['name'];?></option>

							<?php }?>

						</select><?php

						}

					}

				}

			}

			exit;

		}

		function zip_to_zipnewedit($zip=false,$curzone=false)

		{

			//var_dump($zip); var_dump($zone);

			if($zip){

				$auser = $this->ion_auth->user()->row();

				if(!empty($auser)){

					$uid = $auser->id;

					$usergr=$this->business->get_user_group1($uid);

					$grtyp=$usergr->group_id;

					if($grtyp==5){  // for Business Owner

						$sql="select t1.id,t1.name,t3.first_name,t3.last_name from sales_zone as t1 join zip_code_zone as t2 on t2.zone_id=t1.id join users as t3 on t1.sales_rep_id=t3.id where t2.zip_code=$zip";

        				$query = $this->db->query($sql);

						$allzone=$query->result_array();

						if(!empty($allzone)){ ?>

						<label for="biz_zone" style="width:150px; float:left; display:block; padding-right:10px;">Select Zone:</label>

						<select name="biz_zone" id="biz_zone" onchange="change_zone_id(this.value);return false;">

							<?php foreach($allzone as $zone){?>

							<option value="<?php echo $zone['id'];?>" <?php if ($zone['id']==$curzone) echo 'selected="selected"';?>><?php echo $zone['name'];?></option>

							<?php }?>

						</select><?php } 

					}else{       // for Zone Owner

						//$sql="select id,name from sales_zone where sales_rep_id=$uid";

						$sql="select t1.id,t1.name from sales_zone as t1 join zip_code_zone as t2 on t2.zone_id=t1.id where t2.zip_code=$zip and t1.sales_rep_id=$uid";

        				$query = $this->db->query($sql);

						$allzone=$query->result_array();

						if(!empty($allzone)){?>

						<label for="biz_zone" style="width:150px; float:left; display:block; padding-right:10px;">Select Zone:</label>

						<select name="biz_zone" id="biz_zone" onchange="change_zone_id(this.value);return false;">

							<?php foreach($allzone as $zone){?>

							<option value="<?php echo $zone['id'];?>"<?php if ($zone['id']==$curzone) echo 'selected="selected"';?>><?php echo $zone['name'];?></option>

							<?php }?>

						</select><?php }else{?>

                        <label for="biz_zone" style="width:150px; float:left; display:block; padding-right:10px;">Zone:</label>

                        	<select id="biz_zone" name="biz_zone" onchange="change_zone_id(this.value);return false;">

								<option value="-1">Zone not Specified</option>

                            </select>



                        <?php } 

					}

				}

			}

			exit;

		}

	### create business from zone owner end

	### Zone Data Related Part Start

	function zip_to_zipbus($zip=false)

		{

			if($zip){

				$auser = $this->ion_auth->user()->row();

				if(!empty($auser)){

					$uid = $auser->id;

					$usergr=$this->business->get_user_group1($uid);

					$grtyp=$usergr->group_id;

						$sql="select t1.id,t1.name,t3.first_name,t3.last_name from sales_zone as t1 join zip_code_zone as t2 on t2.zone_id=t1.id join users as t3 on t1.sales_rep_id=t3.id where t2.zip_code=$zip";

        				$query = $this->db->query($sql);

						$allzone=$query->result_array();

						if(!empty($allzone)){ ?>

						<label for="biz_zone" style="width:150px; float:left; display:block; padding-right:10px;">Select Zone:</label>

						<select name="biz_zone" id="biz_zone" onchange="change_zone_id(this.value);return false;">

							<?php foreach($allzone as $zone){?>

							<option value="<?php echo $zone['id'];?>"><?php echo $zone['name'];?></option>

							<?php }?>

						</select><?php } 

				}

			}

			exit;

		} 

	

	function check_zonename(){

		$data=array();

		//$data['zoneid']=$_REQUEST['zone_id'];

		$data['nonename'] = $_REQUEST['zone_name'];

		$result = $this->sales_zone->check_zonename($_REQUEST['zone_name']);

		//var_dump($result);

		//var_dump($result);

		//var_dump($data['check_zonename']);

		//echo($this->dr->GetDR("Title", "Message", $result, 0));

		//echo $result;

		echo($this->dr->GetDR("Title", "Message", $result, 0));

	}

	function check_username(){

		$data=array();

		//$data['zoneid']=$_REQUEST['zone_id'];

		$data['username'] = $_REQUEST['user_name'];

		//var_dump($data['username']); exit;

		$result = $this->users->check_username($_REQUEST['user_name']);

		//var_dump($result);

		//var_dump($result);

		//var_dump($data['check_zonename']);

		//echo($this->dr->GetDR("Title", "Message", $result, 0));

		//echo $result;

		echo($this->dr->GetDR("Title", "Message", $result, 0));

	}

	function check_business_to_zip(){

		$data=array();

		

		$data['busname'] = !empty($_REQUEST['bus_name'])? stripslashes($_REQUEST['bus_name']) : '';

		$data['zipcode'] = !empty($_REQUEST['zipcode'])? stripslashes($_REQUEST['zipcode']) : '';		

		$result = $this->business->check_business_to_zip($data['busname'],$data['zipcode']);

		//var_dump($result); exit;

		echo($this->dr->GetDR("Title", "Message", $result, 0));

	}

	function renameZone(){    

        $id = $_REQUEST['zone_id'];

        $name = $_REQUEST['zone_name'];

        $cat_option = 0;

		//var_dump($id);



        if ($id == -1) {

            //new zone

            $uid = $this->ion_auth->user()->row()->id;



            $zoneId = $this->sales_zone->create($name, $uid, $cat_option);

			$zone_org_announcement = $this->ion_auth->create_zone_org_announcement($uid, $zoneId);

            echo($this->dr->GetDR("Title", "Message", $zoneId, 0));

        } else {

            $this->sales_zone->rename_zone($id, $name, $cat_option);

        }

    }

	function deleteZone(){

		

		$zoneid=$_REQUEST['zid'];

		

		$data['deletezone']=$this->sales_zone->get_delete_zone($zoneid); //exit;

		//var_dump($zoneid); 

		$message="Zone deleted successfully ";

		echo($this->dr->GetDR("Successfully", $message, "", "0"));

	}

	### Zone Data Related Part End

	### User Information Part Start

	function getUserInformation(){

		$data=array();

		if ($this->ion_auth->logged_in())

        {

            $user = $this->ion_auth->user()->row();			

			$data["user_id"] = $user->id;

            $data["firstName"] = $user->first_name;

            $data["email"] = $user->email;

            $data["full_name"] = $user->first_name . " " . $user->last_name;

            

            $data["lastName"] = $user->last_name;

            $data["phone"] = $user->phone;

            $data["address"] = $user->Address;

            $data["city"] = $user->City;

            $data["username"] = $user->username;

            $data["zip1"] = $user->Zip; 

            $data["state_Code"] = $user->State_Code;

		    $data['state_list'] = $this->states->get_state_dropdown();

        

        }

		$result = $this->load->view('dashboards/zone_parts/zoneuserinformation', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	public function update_profile(){

		$userid = $_REQUEST['userid'];

        $email = $_REQUEST['email'];

        $firstname = $_REQUEST['firstname'];

		$lastname = $_REQUEST['lastname'];

        $phone = $_REQUEST['phone'];

        $address = $_REQUEST['address'];

        $city = $_REQUEST['city'];

        $state = $_REQUEST['state'];

        $zip = $_REQUEST['zip'];

        

		 $userData = array(



            'email' => $email,



            'first_name' => $firstname,



            'last_name' => $lastname,



            'phone' => $phone,



            'Address' => $address,



            'City' => $city,



            'State_Code' => $state,



            'Zip' => $zip



        );

		$this->db->where('id', $userid);



        $this->db->update('users', $userData);

		

	}

	function getUserPassword(){

		$data=array();

		if ($this->ion_auth->logged_in()){

			$user = $this->ion_auth->user()->row();

			$data["user_id"] = $user->id;

		}

		$result = $this->load->view('dashboards/zone_parts/zoneuserpassword', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function update_password(){

		$userid = $_REQUEST['userid'];

		$current_pass = $_REQUEST['current_pass'];

        $new_pass = $_REQUEST['new_pass'];

        $confirm_pass = $_REQUEST['confirm_pass'];

		if($new_pass != $confirm_pass){

			$message = "Your New Password and Confirm Password are not same. For this No Changes Made!";

		}else{

			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($identity, $current_pass, $new_pass);				

		if ($change)

		{

			$message = "Update Successful";

		}

		else

		{

			$message = "No Changes Made!";

		}

		}

		 echo($this->dr->GetDR("Update Profile", $message, "", "0"));

	}

	### User Information Part End

	### Zip Code Related Part Start

	function zipcode_display(){

		$zone= $this->sales_zone->get_zone($_REQUEST['zoneid']);

		$data['zone'] = $zone;

		$data['zoneid']=$_REQUEST['zoneid'];

		$data['uid']=$_REQUEST['uid'];

		$data['not_zip_codes'] = $this->zip->get_zips_not_in_zone($data['zoneid'], $data['uid']);

		$data['zip_codes'] = $this->zip->get_zips_for_zone($data['zoneid']);

		//var_dump($data['zip_codes']);

		$result = $this->load->view('dashboards/zipcodes', $data, true);

		echo($this->dr->GetDR("Save Complete","Save Completed...", $result, "0"));

	}

	function addZipToZone(){    

        $id = $_REQUEST['zone_id'];

		$zip = $_REQUEST['zipcode'];        

		$zone= $this->sales_zone->get_zone($_REQUEST['zone_id']);

		$data['zone'] = $zone;

        $uid = $this->ion_auth->user()->row()->id;

        $title = " Failed";

        $result = "";

        $message = "There was no id set";

        if (!empty($id) && $id > 0) {

            $data = array();

            $data['zip_codes'] = $this->zip->add_zip_to_zone($id, $zip);

            $data['not_zip_codes'] = $this->zip->get_zips_not_in_zone($id, $uid);

            $data['zoneId'] = $id;

			$zip = $_REQUEST['zipcode'];

			$zone= $this->sales_zone->get_zone($id);

			$data['zone'] = $zone;

            $result = $this->load->view('dashboards/zip_view', $data, true);

        }

        echo($this->dr->GetDR("Delete " . $title, $message, $result, "0"));

    }

	function removeZipFromZone(){    

        $id = $_REQUEST['id'];

        $zip = $_REQUEST['zipcode'];

		

        $uid = $this->ion_auth->user()->row()->id;

        $title = " Failed";

        $message = "There was no id set";

        $result = "";

        if (!empty($id) && $id > 0) {

            $data = array();

            $data['zip_codes'] = $this->zip->remove_zip_from_zone($id, $zip);

            $data['not_zip_codes'] = $this->zip->get_zips_not_in_zone($id, $uid);

            $data['zoneId'] = $id;

			$zone= $this->sales_zone->get_zone($id);

			$data['zone'] = $zone;

            $result = $this->load->view('dashboards/zip_view', $data, true);

        }

        echo($this->dr->GetDR("Delete " . $title, $message, $result, "0"));



    }

	### Zip Code Related Part End

	### Category related Function start

	function add_new_cat_zone(){ 

		$data['zoneid']=$_REQUEST['zoneid'];

		$result = $this->load->view('categories/new_category_add', $data, true);

		echo($this->dr->GetDR("Save Complete","Save Completed...", $result, "0"));

	}

	function save_category_zone(){     

    	$zone_id = $_REQUEST['zone_id'];

    	$cat_name = $_REQUEST['cat_name'];

		$sub_cat_name = $_REQUEST['sub_cat_name'];		

    	$data = array(

    			'name' => $cat_name,

				'status' => 0,

				'zoneid' => $zone_id,

    	);

		$this->db->insert('category', $data);

		$cat_id= $this->db->insert_id();

			$newdata=array(

				'catid' => $cat_id,

				'name' => $sub_cat_name,				

				'status' => 0,

				'zoneid'=>$zone_id,

			);

			$this->db->insert('category_subcategory', $newdata);

    	$message="new category is successfully created. If you want to add more subcategory, then go to Add Sub Category option.";	

    	$newTable1 = $this->load->view("categories/new_category_add.php", $data, true);

    	echo($this->dr->GetDR("Save Successful", $message, $newTable1, "0"));;

    }

	function add_new_subcat_zone(){		

		$data['zoneid']=$_REQUEST['zoneid']; 

		$data['categories'] = $this->category_model->get_category_for_zone($_REQUEST['zoneid']);

		$data['count_categories'] =count($data['categories']);

		$result = $this->load->view('categories/new_subcategory_add', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function save_subcategory_zone()

    {

    	$zone_id = $_REQUEST['zone_id'];

    	$cat_id = $_REQUEST['cat_name'];

		$sub_cat_name = $_REQUEST['sub_cat_name'];		

    	

		$newdata=array(

			'catid' => $cat_id,

			'name' => $sub_cat_name,				

			'status' => 0,

			'zoneid'=>$zone_id,

		);

		$this->db->insert('category_subcategory', $newdata);

    		

    	$newTable1 = $this->load->view("categories/new_subcategory_add.php", $newdata, true);

		$message="sub category is successfully created.";

    	echo($this->dr->GetDR("Save Successful", $message, $newTable1, "0"));;

    }

	function edit_category_display(){	

		$data['zoneid']=$_REQUEST['zoneid'];

		//var_dump($data['zoneid']);

		//$data['categories'] = $this->category_model->get_category_for_zone2($_REQUEST['zoneid']);

		$user = $this->ion_auth->user()->row();

		//var_dump($org_id);exit;

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;} 

		//$data['all_my_zones']=$this->sales_zone->get_all_zones_by_user($_REQUEST['zoneid'],$uid);

		$data['all_my_zones']=$this->sales_zone->users_all_zone($uid);

		$data['categories'] = $this->category_model->get_category_display_for_zone($_REQUEST['zoneid']);

		//var_dump($data['categories']);

		$data['display_categories']=$this->category_model->get_display_category_for_zone($_REQUEST['zoneid']);

		//var_dump($data['display_categories']);

		//$data['count_display_categories']=count($data['display_categories']);

		$data['count_categories']=count($data['categories']);

		//var_dump($data['count_categories']);

		$result = $this->load->view('categories/edit_category', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function save_zone_cat_display(){

		$catid=$_REQUEST['catid'];

		$zoneid=$_REQUEST['zoneid'];

		//var_dump($catid); var_dump($zoneid); exit;

		//$type=$_REQUEST['type'];

		/*if($type==1){ 

			$add_cat_to_zone=$this->category_model->add_category_display($catid,$zoneid);

		}else if($type==2){ 

			$add_cat_to_zone=$this->category_model->add_all_category_subcategory_display($catid,$zoneid);

		}*/

		$add_cat_to_zone=$this->category_model->add_category_display($catid,$zoneid);

		

	}

	function save_cat_subcat_all_my_zone(){

		$all_zone=$_REQUEST['all_zone'];

		//var_dump($all_zone);

		//$this_zone=$_REQUEST['this_zone'];

		//$save_cat_subcat_all_my_zone=$this->category_model->save_cat_subcat_all_my_zone($all_zone,$this_zone);

		//$save_cat_subcat_all_my_zone=$this->category_model->save_cat_subcat_all_my_zone($all_zone);

		//var_dump($save_cat_subcat_all_my_zone);

	}

	

	function save_zone_cat_display_change(){

		/*$catid=$_REQUEST['catid'];

		$zoneid=$_REQUEST['zoneid'];

		$type=$_REQUEST['type'];

		$my_current_zone=$_REQUEST['my_current_zone'];

		$my_all_zone=$_REQUEST['my_all_zone'];*/

		

		/*$catid_this_zone=$_REQUEST['catid_this_zone'];

		$catid_all_zone=$_REQUEST['catid_all_zone'];*/

		/*$catid=$_REQUEST['catid'];

		$my_current_zone=$_REQUEST['my_current_zone'];

		$my_all_zone=$_REQUEST['my_all_zone'];

		var_dump($catid_this_zone); var_dump($catid_all_zone); var_dump($my_current_zone); var_dump($my_all_zone); exit;

		

		if($catid_this_zone!=''){

			$add_cat_to_zone=$this->category_model->add_category_this_zone($catid_this_zone,$my_current_zone,1);

		}if($catid_all_zone!=''){

			$add_cat_to_zone=$this->category_model->add_category_all_zone($catid_all_zone,$my_all_zone,2);

		}*/

		

		//exit;

		

		

		/*if($type==1){ 

			$add_cat_to_zone=$this->category_model->add_category_display($catid,$my_current_zone);

			$user = $this->ion_auth->user()->row();		

			$uid = 0;

			if(!empty($user)){ $uid = $user->id;}	

			$data['all_my_zones']=$this->sales_zone->get_all_zones_by_user($uid);

			

			$data['zoneid']=$_REQUEST['my_current_zone'];

			//var_dump($data['zoneid']);

			//$data['categories'] = $this->category_model->get_category_for_zone2($_REQUEST['zoneid']);

			$data['categories'] = $this->category_model->get_category_display_for_zone($my_current_zone,$uid);

			

			$data['display_categories']=$this->category_model->get_display_category_for_zone($my_current_zone);

			$data['count_categories']=count($data['categories']);		

			$result = $this->load->view('categories/edit_category', $data, true);

			echo($this->dr->GetDR("","", $result, "0"));

		}else if($type==2){ 

			$add_cat_to_zone=$this->category_model->add_all_category_subcategory_display($catid,$my_all_zone);

			$user = $this->ion_auth->user()->row();		

			$uid = 0;

			if(!empty($user)){ $uid = $user->id;}	

			$data['all_my_zones']=$this->sales_zone->get_all_zones_by_user($uid);

			

			$data['zoneid']=$_REQUEST['my_current_zone'];

			//var_dump($data['zoneid']);

			//$data['categories'] = $this->category_model->get_category_for_zone2($_REQUEST['zoneid']);

			$data['categories'] = $this->category_model->get_category_display_for_zone($my_all_zone,$uid);

			

			$data['display_categories']=$this->category_model->get_display_category_for_zone($my_current_zone);

			$data['count_categories']=count($data['categories']);		

			$result = $this->load->view('categories/edit_category', $data, true);

			echo($this->dr->GetDR("","", $result, "0"));

		}

		//$add_cat_to_zone=$this->category_model->add_category_display($catid,$zoneid);*/

		

		

	}

	function edit_sub_category_display(){	

		$data['zoneid']=$_REQUEST['zoneid'];

		$data['catid']=$_REQUEST['catid'];

		$data['subcategories_1'] = $this->category_model->get_sub_category_for_zone($_REQUEST['catid'],$_REQUEST['zoneid']);		

		$data['count_subcat']=count($data['subcategories_1']);		

		$data['display_subcategories']=$this->category_model->get_display_sub_category_for_zone($_REQUEST['zoneid'],$_REQUEST['catid']);		

		$data['category_name']=$this->category_model->get_category_name($_REQUEST['catid']);		

		if($data['count_subcat']>0){

			$data['subcategories']=$this->category_model->get_all_sub_category_for_zone($_REQUEST['catid'],$_REQUEST['zoneid']);

			//var_dump($data['subcategories']); exit;				

			$result = $this->load->view('categories/edit_sub_category', $data, true);

		}else if($data['count_subcat']==0){

			$data['all_subcategories'] = $this->category_model->get_all_sub_category_for_zone($_REQUEST['catid'],$_REQUEST['zoneid']);			

			$result = $this->load->view('categories/display_sub_category', $data, true);

		}

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function save_zone_sub_cat_display(){

		$catid=$_REQUEST['catid'];

		$zoneid=$_REQUEST['zoneid'];

		$subcatid=$_REQUEST['subcatid']; //var_dump($catid); var_dump($zoneid); var_dump($subcatid); anish24

		$add_cat_to_zone=$this->category_model->add_sub_category_display($catid,$zoneid,$subcatid);

	}

	### Category related Function end

	### Listed Business Part Start

	function delete_listed_business_ad_zone(){

		/*$charval='all';

		$data = array();

		$data['zoneid'] = $_REQUEST['zoneid'];

		$business_id= $_REQUEST['busid'];

		$data['business_zone']=$_REQUEST['business_zone_select_value'];

		$data['business_zone_select_value']=$_REQUEST['business_zone_select_value'];

		$data['business_type_select_value']=$_REQUEST['business_type_select_value'];

		$data['my_business_in_zone'] = $this->business->delete_business_ad_zone($business_id,$data['zoneid']);

		$data['my_business_in_zone'] = $this->business->get_businesses_details($data['business_zone_select_value'],$data['business_type_select_value'],$data['zoneid'],$charval);

		//var_dump($data['my_business_in_zone']);

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);*/

		

		

		$charval='all';

		$data = array();

		$data['zoneid'] = $_REQUEST['zoneid'];

		$data['businesstype_select']=$_REQUEST['business_type_select_value'];

		$business_id= $_REQUEST['busid'];

		//var_dump($business_id); var_dump($data['zoneid']); exit;

		$data['my_business_in_zone1'] = $this->business->delete_business_ad_zone($business_id,$data['zoneid']);

		$data['my_business_in_zone'] = $this->business->get_businesses_details_listed($data['businesstype_select'],$data['zoneid'],$charval);

		//var_dump($data['my_business_in_zone']); exit;

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);

		

		

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;} 

		$data['all_my_zones']=$this->sales_zone->users_all_zone($uid);

		$result = $this->load->view('dashboards/business_parts/listed_business_display', $data, true);		

		echo($this->dr->GetDR("","", $result, "0"));

	}

	

	function delete_listed_business_ad_all_zone(){

		/*$charval='all';

		$data = array();

		$data['zoneid'] = $_REQUEST['zoneid'];

		$business_id= $_REQUEST['busid'];

		$data['business_zone']=$_REQUEST['business_zone_select_value'];

		$data['business_zone_select_value']=$_REQUEST['business_zone_select_value'];

		$data['business_type_select_value']=$_REQUEST['business_type_select_value'];

		$data['my_business_in_zone'] = $this->business->delete_business_ad_zone($business_id,$data['zoneid']);

		$data['my_business_in_zone'] = $this->business->get_businesses_details($data['business_zone_select_value'],$data['business_type_select_value'],$data['zoneid'],$charval);

		//var_dump($data['my_business_in_zone']);

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);*/

		

		

		$charval='all';

		$data = array();

		$data['zoneid'] = $_REQUEST['zoneid'];

		$data['businesstype_select']=$_REQUEST['business_type_select_value'];

		$business_id= $_REQUEST['busid'];

		//var_dump($business_id); var_dump($data['zoneid']); exit;

		$data['my_business_in_zone1'] = $this->business->delete_business_ad_all_zone($business_id,$data['zoneid']);

		$data['my_business_in_zone'] = $this->business->get_businesses_details_listed($data['businesstype_select'],$data['zoneid'],$charval);

		//var_dump($data['my_business_in_zone']); exit;

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);

		

		

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;} 

		$data['all_my_zones']=$this->sales_zone->users_all_zone($uid);

		$result = $this->load->view('dashboards/business_parts/listed_business_display', $data, true);		

		echo($this->dr->GetDR("","", $result, "0"));

	}

	

	function display_business_listed($businesstype_select,$zoneid,$charval,$lowerlimit,$upperlimit){

		//var_dump($businesstype_select); var_dump($zoneid);  var_dump($charval);

		/*$config['base_url'] = 'http://example.com/index.php/test/page/';

		$config['total_rows'] = 200;

		$config['per_page'] = 20; 



		$this->pagination->initialize($config); */



		//echo $this->pagination->create_links();

		

		

		 

		$data = array();

		//$data['pagination']=$this->pagination->create_links();

		$data['zoneid'] = $zoneid;

		//$data['business_zone']=$_REQUEST['business_zone']; 

		//$data['businesstype_select']=$businesstype_select;

		$data['show_bus_type_listed']=$businesstype_select;

		$data['charval']=$charval;

		//var_dump($data); exit;

		//var_dump($data['zoneid']); var_dump($charval); var_dump($businesszone_select); var_dump($businesstype_select); exit;

		$data['my_business_in_zone'] = $this->business->get_businesses_details_listed($businesstype_select,$zoneid,$charval,$lowerlimit,$upperlimit);

		//var_dump($data['my_business_in_zone']);

		//var_dump($data['my_business_in_zone']); exit;

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);		

		//$result = $this->load->view('dashboards/business_parts/business_display', $data, true);

		/*if($businesszone_select!=2 && $businesstype_select!=5){

			$result = $this->load->view('dashboards/business_parts/business_display', $data, true);		

		}else {

			$result = $this->load->view('dashboards/business_parts/all_business_display', $data, true);	

		}*/

		$data['listed_business_category']=$this->category_model->get_category_listed_business($zoneid);

		$data['listed_business_subcategory']=$this->category_model->get_subcategory_listed_business($zoneid);

		//var_dump($data['listed_business_subcategory']);

		//$data['ad_selected_category']=$this->category_model->get_selected_category_listed_business($zoneid);

		//var_dump($data['listed_business_category']);

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;} 

		$data['all_my_zones']=$this->sales_zone->users_all_zone($uid);



		$lowerlimit=$lowerlimit+5;

		$upperlimit1=2;

		$limit=$lowerlimit.','.$upperlimit;

		$result = $this->load->view('dashboards/business_parts/listed_business_display', $data, true);		

		echo($this->dr->GetDR("",$limit, $result, "0"));

	}

	function listed_business_action($busid,$zoneid,$businesstype_select){ //var_dump($businesstype_select); exit;

		$data = array();

		$data['zoneid'] = $zoneid;

		$data['edit_business_action'] = $this->business->listed_business_approval($busid,$zoneid,$businesstype_select);

		$data['my_business_in_zone'] = $this->business->get_businesses_details_listed($businesstype_select,$zoneid);

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);

		$data['business_zone'] =$businesstype_select;

		$result = $this->load->view('dashboards/business_parts/listed_business_display', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function listed_deleteBusiness()

    {

        

		$data = array();

		$data['busid'] = $_REQUEST['busid'];

		$data['zoneid'] = $_REQUEST['zoneid'];

		//$data['business_zone_select_value'] = $_REQUEST['business_zone_select_value'];

		$data['business_type_select_value'] = $_REQUEST['business_type_select_value'];

		//var_dump($data['business_zone_select_value']); var_dump($data['business_type_select_value']); var_dump($data['zoneid']);

		$data['edit_business_action'] = $this->business->listed_business_approval_delete($data['busid'],$data['zoneid']);

		$data['my_business_in_zone'] = $this->business->get_businesses_details_listed($_REQUEST['business_type_select_value'],$_REQUEST['zoneid'],'all');

		//var_dump($data['my_business_in_zone']);

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);

		$data['business_zone'] =$data['business_type_select_value'];

		

		$result = $this->load->view('dashboards/business_parts/listed_business_display', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

		

    }

	/*function business_action($busid,$zoneid,$option,$businesszone_select,$businesstype_select){

		$data = array();

		$data['zoneid'] = $zoneid;

		$data['edit_business_action'] = $this->business->listed_business_approval($busid,$zoneid,$option);

		$data['my_business_in_zone'] = $this->business->get_businesses_details_listed($businesszone_select,$businesstype_select,$zoneid);

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);

		$data['business_zone'] =$businesstype_select;

		$result = $this->load->view('dashboards/business_parts/listed_business_display', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}*/

	function action_performed_listed_business(){

		$charval='all';

		$data = array();

		$data['zoneid'] = $_REQUEST['zoneid'];

		$data['allzoneid'] = $_REQUEST['allzoneid'];

		$business_id= $_REQUEST['busid'];

		$data['business_id']=$_REQUEST['busid'];

		$data['businesstype_select']=$_REQUEST['business_type_select_value'];

		$data['business_zone']=$_REQUEST['business_zone_select_value'];

		$data['show_bus_type_listed']=$_REQUEST['show_bus_type_listed'];

		$data['business_zone_select_value']=$_REQUEST['business_zone_select_value'];

		$data['business_type_select_value']=$_REQUEST['business_type_select_value'];

		$data['action_performed']=$_REQUEST['action_performed'];

		$data['action_performed_in_where']=$_REQUEST['action_performed_in_where'];

		//$data['business_active_paid_trial']=$_REQUEST['business_active_paid_trial'];

		$data['business_active_paid_trial']=3;

		//var_dump($data);exit;

		if($_REQUEST['action_performed']==1){ // For Activate

			$data['edit_business_action'] = $this->business->listed_business_activate($business_id,$data['zoneid'],$data['business_active_paid_trial']);

			//$data['edit_business_action'] = $this->business->listed_business_activate($busid,$zoneid,$businesstype_select);

		}

		else if($_REQUEST['action_performed']==2){ // For Deactivate

			$data['edit_business_action'] = $this->business->listed_business_deactivate($business_id,$data['zoneid'],$data['business_active_paid_trial']);

			//$data['edit_business_action'] = $this->business->listed_business_activate($business_id,$data['zoneid'],$data['business_active_paid_trial']);

		}

		else if($_REQUEST['action_performed']==3 && $data['action_performed_in_where']==0){ // For Delete in zone

			$data['my_business_in_zone1'] = $this->business->delete_business_ad_zone($business_id,$data['zoneid']);

		}

		else if($_REQUEST['action_performed']==3 && $data['action_performed_in_where']==1){ // For Delete in all zone

			$data['my_business_in_zone1'] = $this->business->delete_business_ad_all_zone($business_id,$data['allzoneid']);

		}

		else if($_REQUEST['action_performed']==4){ // For Verify

			$data['my_business_in_zone1'] = $this->business->verify_business_in_zone($business_id,1);

		}

		else if($_REQUEST['action_performed']==5){ // For Verify

			$data['my_business_in_zone1'] = $this->business->unverify_business_in_zone($business_id,0);

		}

		//var_dump($data['my_business_in_zone1']);

		$data['my_business_in_zone'] = $this->business->get_businesses_details_listed($data['show_bus_type_listed'],$data['zoneid'],$charval);

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);		

		

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;} 

		$data['all_my_zones']=$this->sales_zone->users_all_zone($uid);

		$result = $this->load->view('dashboards/business_parts/listed_business_display', $data, true);		

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function samplay_csv(){

		$data=array();

		$result = $this->load->view('dashboards/business_parts/sample_csv', $data, true);		

		echo($this->dr->GetDR("","", $result, "0"));

	}

	### Listed Business Part End

	### Business related Function start

	function action_performed_business(){

		$charval='all';

		$data = array();

		$data['zoneid'] = $_REQUEST['zoneid'];

		$data['allzoneid'] = $_REQUEST['allzoneid'];

		$business_id= $_REQUEST['busid'];

		$data['business_id']=$_REQUEST['busid'];

		$data['businesstype_select']=$_REQUEST['business_type_select_value'];

		$data['business_zone']=$_REQUEST['business_zone_select_value'];

		$data['business_zone_select_value']=$_REQUEST['business_zone_select_value'];

		$data['business_type_select_value']=$_REQUEST['business_type_select_value'];

		$data['action_performed']=$_REQUEST['action_performed'];

		$data['action_performed_in_where']=$_REQUEST['action_performed_in_where'];

		$data['business_active_paid_trial']=$_REQUEST['business_active_paid_trial'];

		//var_dump($data);exit;

		if($_REQUEST['action_performed']==1){ // For Activate

			$data['my_business_in_zone1'] = $this->business->business_activate_in_zone($business_id,$data['zoneid'],$data['business_active_paid_trial']);

		}

		else if($_REQUEST['action_performed']==2){ // For Deactivate

			$data['my_business_in_zone1'] = $this->business->business_deactivate_in_zone($business_id,$data['zoneid'],$data['business_type_select_value']);

		}

		else if($_REQUEST['action_performed']==3 && $data['action_performed_in_where']==0){ // For Delete in zone

			$data['my_business_in_zone1'] = $this->business->delete_business_ad_zone($business_id,$data['zoneid']);

		}

		else if($_REQUEST['action_performed']==3 && $data['action_performed_in_where']==1){ // For Delete in all zone

			$data['my_business_in_zone1'] = $this->business->delete_business_ad_all_zone($business_id,$data['allzoneid']);

		}

		else if($_REQUEST['action_performed']==4 ){ // For Verify

			$data['my_business_in_zone1'] = $this->business->verify_business_in_zone($business_id,1);

		}

		else if($_REQUEST['action_performed']==5 ){ // For Unverify

			$data['my_business_in_zone1'] = $this->business->unverify_business_in_zone($business_id,0);

		}

		//var_dump($data['my_business_in_zone1']);

		$data['my_business_in_zone'] = $this->business->get_businesses_details($data['business_zone_select_value'],$data['business_type_select_value'],$data['zoneid'],$charval);

		//var_dump($data['my_business_in_zone']);

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;} 

		$data['all_my_zones']=$this->sales_zone->users_all_zone($uid);

		//$result = $this->load->view('dashboards/business_parts/business_display', $data, true);

		if($data['business_zone_select_value']!=2 && $data['business_zone_select_value']!=5){

			$result = $this->load->view('dashboards/business_parts/business_display', $data, true);		

		}else {

			$result = $this->load->view('dashboards/business_parts/all_business_display', $data, true);	

		}				

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function delete_business_ad_zone(){

		$charval='all';

		$data = array();

		$data['zoneid'] = $_REQUEST['zoneid'];

		$business_id= $_REQUEST['busid'];

		$data['business_zone']=$_REQUEST['business_zone_select_value'];

		$data['business_zone_select_value']=$_REQUEST['business_zone_select_value'];

		$data['business_type_select_value']=$_REQUEST['business_type_select_value'];

		$data['my_business_in_zone1'] = $this->business->delete_business_ad_zone($business_id,$data['zoneid']);

		$data['my_business_in_zone'] = $this->business->get_businesses_details($data['business_zone_select_value'],$data['business_type_select_value'],$data['zoneid'],$charval);

		//var_dump($data['my_business_in_zone']);

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;} 

		$data['all_my_zones']=$this->sales_zone->users_all_zone($uid);

		//$result = $this->load->view('dashboards/business_parts/business_display', $data, true);

		if($data['business_zone_select_value']!=2 && $data['business_zone_select_value']!=5){

			$result = $this->load->view('dashboards/business_parts/business_display', $data, true);		

		}else {

			$result = $this->load->view('dashboards/business_parts/all_business_display', $data, true);	

		}				

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function delete_business_ad_all_zone(){

		$charval='all';

		$data = array();

		$data['zoneid'] = $_REQUEST['zoneid'];

		$business_id= $_REQUEST['busid'];

		$data['business_zone']=$_REQUEST['business_zone_select_value'];

		$data['business_zone_select_value']=$_REQUEST['business_zone_select_value'];

		$data['business_type_select_value']=$_REQUEST['business_type_select_value'];

		$data['my_business_in_zone2'] = $this->business->delete_business_ad_all_zone($business_id,$data['zoneid']);

		$data['my_business_in_zone'] = $this->business->get_businesses_details($data['business_zone_select_value'],$data['business_type_select_value'],$data['zoneid'],$charval);

		//var_dump($data['my_business_in_zone']);

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;} 

		$data['all_my_zones']=$this->sales_zone->users_all_zone($uid);

		//$result = $this->load->view('dashboards/business_parts/business_display', $data, true);

		if($data['business_zone_select_value']!=2 && $data['business_zone_select_value']!=5){

			$result = $this->load->view('dashboards/business_parts/business_display', $data, true);		

		}else {

			$result = $this->load->view('dashboards/business_parts/all_business_display', $data, true);	

		}				

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function display_business($businesszone_select,$businesstype_select,$zoneid,$charval,$lowerlimit,$upperlimit){ 

		$data = array();

		$data['zoneid'] = $zoneid;

		$data['business_zone']=$_REQUEST['business_zone'];

		$data['businesszone_select']=$businesszone_select;

		$data['businesstype_select']=$businesstype_select;

		$data['charval']=$charval;

		//var_dump($data['business_zone']); var_dump($data['businesszone_select']); var_dump($businesstype_select); exit;

		$data['my_business_in_zone'] = $this->business->get_businesses_details($businesszone_select,$businesstype_select,$zoneid,$charval,$lowerlimit,$upperlimit);

		//$data['all_my_business_in_zone'] = $this->business->get_all_businesses_details($businesszone_select,$businesstype_select,$zoneid,$charval);

		//echo sizeof($data['my_business_in_zone']);

		//var_dump(count($data['my_business_in_zone'])); 

		//var_dump($data['my_business_in_zone']);		

		//$data['count_my_business_in_zone']=count($data['my_business_in_zone']);

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;} 

		$data['all_my_zones']=$this->sales_zone->users_all_zone($uid);

		//$result = $this->load->view('dashboards/business_parts/business_display', $data, true);

		

		

		/*$config = array();

        $config["base_url"] = base_url() . "dashboards/zone/7";

        $config["total_rows"] = 7;

        $config["per_page"] = 2;

        $config["uri_segment"] = 3;



        $this->pagination->initialize($config);



        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		

		$data['my_business_in_zone'] = $this->business->get_businesses_details($businesszone_select,$businesstype_select,$zoneid,$charval,$config["per_page"], $page);

		//var_dump($data['my_business_in_zone']);

       

        $data["links"] = $this->pagination->create_links();

		//var_dump($data["links"]);*/

		$lowerlimit=$lowerlimit+2;

		$upperlimit1=2;

		$limit=$lowerlimit.','.$upperlimit;

		if($businesszone_select!=2 && $businesstype_select!=5){

			$result = $this->load->view('dashboards/business_parts/business_display', $data, true);		

		}else {

			$result = $this->load->view('dashboards/business_parts/all_business_display', $data, true);	

		}				

		echo($this->dr->GetDR("",$limit, $result, "0"));

	}

	/*function showeditbusinessform(){  // comment partha 24.01.13

		$data = array();

		$data['businessid']=$_REQUEST['businessid'];

		$data['zoneid']=$_REQUEST['zoneid'];

		$data['result']=$this->ads->getBusinessByID($_REQUEST['businessid']);

		//var_dump($data['result']); 

		$data['address']=$this->ads->getBusinessAddresByID($data['result']['addressid']); 

		$data['users_list'] = $this->users->get_user_list(true);

		$data['state_list']=$this->states->get_state_dropdown();

		$data['business_type']=$this->business->get_business_type_by_id($_REQUEST['businessid'],$_REQUEST['zoneid']);

		//var_dump($data['business_type']); exit;

		$html = $this->load->view('dashboards/business_parts/BusinessFormForZone', $data, true); 

		echo($this->dr->GetDR("","", $html, "0"));

	}*/

	function showeditbusinessform(){    // add partha 24.01.13

		$auser = $this->ion_auth->user()->row();

		$uid = $auser->id;

		$data = array();

		$data['businessid']=$_REQUEST['businessid'];

		$data['zoneid']=$_REQUEST['zoneid'];

		$data['result']=$this->ads->getBusinessByID($_REQUEST['businessid']);

		//var_dump($data['result']);

		$busownerid=$data['result']['business_owner_id'];

		if($busownerid==$uid){

			$data['ownertype']=1;

		}else{

			$data['ownertype']=3;

		}

		

		$data['address']=$this->ads->getBusinessAddresByID($data['result']['addressid']); 

		//$data['users_list'] = $this->users->get_user_list(true);

		$users_all_zone = $this->sales_zone->users_all_zone($uid);

		$data['users_list'] = $this->users->get_user_list_zone($users_all_zone);

		//var_dump($data['users_list']);

		$data['count_users_list']=count($data['users_list']);

		$data['state_list']=$this->states->get_state_dropdown();

		$data['business_type']=$this->business->get_business_type_by_id($_REQUEST['businessid'],$_REQUEST['zoneid']);

		//var_dump($data['business_type']); exit; 

		$data['get_user_details']=$this->users->get_user_details($busownerid);

		//var_dump($data['get_user_details']);

		$html = $this->load->view('dashboards/business_parts/BusinessFormForZone', $data, true); 

		echo($this->dr->GetDR("","", $html, "0"));

	}

	function showeditbusinessformListed(){   

		$auser = $this->ion_auth->user()->row();

		$uid = $auser->id;

		$data = array();

		$data['businessid']=$_REQUEST['businessid'];

		$data['zoneid']=$_REQUEST['zoneid'];

		$data['result']=$this->ads->getBusinessByID($_REQUEST['businessid']);

		//var_dump($data['result']);

		$busownerid=$data['result']['business_owner_id'];

		if($busownerid==$uid){

			$data['ownertype']=1;

		}else{

			$data['ownertype']=3;

		}

		

		$data['address']=$this->ads->getBusinessAddresByID($data['result']['addressid']); 

		//$data['users_list'] = $this->users->get_user_list(true);

		$users_all_zone = $this->sales_zone->users_all_zone($uid);

		$data['users_list'] = $this->users->get_user_list_zone($users_all_zone);

		//var_dump($data['users_list']);

		$data['count_users_list'] =count($data['users_list']);

		$data['state_list']=$this->states->get_state_dropdown();

		$data['business_type']=$this->business->get_business_type_by_id($_REQUEST['businessid'],$_REQUEST['zoneid']);

		//var_dump($data['business_type']); exit;

		$data['get_user_details']=$this->users->get_user_details($busownerid);

		$html = $this->load->view('dashboards/business_parts/BusinessFormForZoneListed', $data, true); 

		echo($this->dr->GetDR("","", $html, "0"));

	}

	

	function business_action($busid,$zoneid,$option,$businesszone_select,$businesstype_select){

		$data = array();

		$data['zoneid'] = $zoneid;

		$data['edit_business_action'] = $this->business->business_approval($busid,$zoneid,$option);

		$data['my_business_in_zone'] = $this->business->get_businesses_details($businesszone_select,$businesstype_select,$zoneid);

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);

		$data['business_zone'] =$businesstype_select;

		$result = $this->load->view('dashboards/business_display', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function SaveBusinessPayment($busid,$selectval){

		$data['SaveBusinessApproval'] = $this->business->SaveBusinessPayment($busid,$selectval);	

	}

	function SaveBusinessApproval($busid,$selectval){

		$data['SaveBusinessApproval'] = $this->business->SaveBusinessApproval($busid,$selectval);		

	}

	function SaveWebsiteVisible($busid,$selectval){

		$data['SaveWebsiteVisible'] = $this->business->website_visibility_business($busid,$selectval);		

	}

	function SaveEmailVisible($busid,$selectval){

		$data['SaveEmailVisible'] = $this->business->email_visibility_business($busid,$selectval);	

	}

	function deleteBusiness()

    {

        $data = array();

		$data['busid'] = $_REQUEST['busid'];

		$data['zoneid'] = $_REQUEST['zoneid'];

		$data['business_zone_select_value'] = $_REQUEST['business_zone_select_value'];

		$data['business_type_select_value'] = $_REQUEST['business_type_select_value'];

		//var_dump($data['business_zone_select_value']); var_dump($data['business_type_select_value']); var_dump($data['zoneid']);

		$data['edit_business_action'] = $this->business->business_approval_delete($data['busid'],$data['zoneid']);

		$data['my_business_in_zone'] = $this->business->get_businesses_details($data['business_zone_select_value'],$data['business_type_select_value'],$data['zoneid'],'all');

		//var_dump($data['my_business_in_zone']);

		$data['count_my_business_in_zone']=count($data['my_business_in_zone']);

		$data['business_zone'] =$data['business_type_select_value'];

		

		if($data['business_zone_select_value']!=2 && $data['business_type_select_value']!=5){

			$result = $this->load->view('dashboards/business_parts/business_display', $data, true);		

		}else {

			$result = $this->load->view('dashboards/business_parts/all_business_display', $data, true);	

		}	

		

		

		//$result = $this->load->view('dashboards/business_display', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

		//exit;

		

		/*$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];		

        $business_id = $_REQUEST['business_id']; var_dump($id); var_dump($business_id);  

        $this->db->where('id', $id);

        $this->db->delete('ads');

		$this->db->where('adid', $id);

		$this->db->delete('ad_to_zone');

        $data = array();

        $data['ads'] = $this->ads->get_ads_for_business($business_id);

        $tag = $this->load->view("dashboards/business_parts/ad_table", $data, true);

        echo($this->dr->GetDR("Success", "Success", $tag, "0"));*/

    }

	function subcat_listed_business_change_cat(){ 

		$catid=$_REQUEST['cat_id']; $zoneid=$_REQUEST['iszoneid']; $businesstype_select=$_REQUEST['default_value']; $charval='all'; $listed_businessid=$_REQUEST['listed_businessid'];

		//$cat_id_final=implode(',',$catid);

		//var_dump($cat_id_final); exit;

		//$cat_id_final=implode(',',$catid);

		//$data['subcategory_category_zone']=$this->category_model->zone_get_all_subcategories_zone($catid,$zoneid);

		$data['cat_id']=$catid; $data['listed_businessid']=$listed_businessid;

		//$data['my_business_in_zone'] = $this->business->get_businesses_details_listed($businesstype_select,$zoneid,$charval);

		

		//var_dump($data['my_business_in_zone']);

		$data['listed_business_subcategory_change_category']=$this->category_model->get_listed_business_subcat($catid,$zoneid);

		//var_dump($data['listed_business_subcategory_change_category']);

		//$data['adid']=0; $data['zoneid']=0; $data['businessid']=0;

		$selected_subcat_id=$this->ads->get_selected_subcat_id_listed_business($listed_businessid);

		//var_dump($selected_subcat_id);

		$result = $this->load->view('dashboards/zone_parts/get_subcat_listed_business', $data, true);

		//var_dump($data);

		/*foreach($data['my_business_in_zone'] as $_scid){

			$subcatid=$_scid['subcategoryid'];*/

		

		echo($this->dr->GetDR($selected_subcat_id,$data['listed_businessid'], $result, "0"));

		//}

	}

	function save_listed_cat_subcat(){

		$adid=$_REQUEST['adid']; $catid=$_REQUEST['catid']; $subcatid=$_REQUEST['subcatid'];

		$data['save_listed_cat_subcat']=$this->ads->get_save_listed_cat_subcat($adid,$catid,$subcatid);

	}

	### Business related Function end

	### Advertisement related Function start

	

	/*function delete_ad_from_specific_business(){

		$data=array();

		$data['zoneid'] = !empty($_REQUEST['zoneid'])? $_REQUEST['zoneid'] : 0 ;

		$data['businessid'] = !empty($_REQUEST['busid'])? $_REQUEST['busid'] : 0 ;

		$data['allbusiness_id'] = $_REQUEST['busid'];

		$all_ad_id=$_REQUEST['adid'];

		$data['select_id'] = $_REQUEST['select_id'];

		$data['selectedoption'] = 5; 

		$count_bus_id=explode('-',$businessid);

		$data['count_bus_id']=count($count_bus_id);

		//var_dump($all_ad_id);

		$data['ad_delete_specific_bussiness'] = $this->ads->delete_ads_in_zone_for_delete($all_ad_id,$data['zoneid']);

		$data['sticky_ad_settings']=$this->sales_zone->get_default_settings_in_zone($data['zoneid']);		

		$data['add_approve_zone'] = $this->ads->get_ads_in_zone_for_approve($data['select_id'],$data['zoneid'],$data['businessid']);		

		$result = $this->load->view('dashboards/zone_parts/ad_display', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}*/

	function display_ad($selectid='',$zoneid='',$businessid='',$charval='',$lowerlimit='',$upperlimit=''){		

		$data = array();		

		$data['zoneid'] = $zoneid;

		$data['selectedoption'] = $selectid;

		$data['businessid'] = $businessid;

		$data['charval']=$charval;

		

		if($businessid!=''){

		$count_bus_id=explode('-',$businessid);

		$data['count_bus_id']=count($count_bus_id);

		//var_dump($data['businessid']);

		if($data['count_bus_id']!='all'){

			$data['bus_name']=$this->business->get_business_name_against_id($businessid);

			//var_dump($data['bus_name']);

		}

		}

		$data['sticky_ad_settings']=$this->sales_zone->get_default_settings_in_zone($zoneid);

		//var_dump($data['sticky_ad_settings']);

		

		$data['add_approve_zone'] = $this->ads->get_ads_in_zone_for_approve($selectid,$zoneid,$businessid,$charval,$lowerlimit,$upperlimit);

		

		$data['countallads']=count($data['add_approve_zone']);

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$my_zones = $this->sales_zone->get_zones_for_user($uid);

		$data['my_zones']=count($my_zones);

		//var_dump($data['my_zones']);

		//var_dump($data['add_approve_zone']);

		$data['reason']=array();

		$tempreason=array();

		if(!empty($data['add_approve_zone'])){

		foreach($data['add_approve_zone'] as $_x){			

			$aaa = $this->ads->get_reason_for_ad($selectid,$zoneid,$businessid,$_x['adid']);			

			$tempreason[$_x['adid']]=$aaa[0]['reason'];			

		}

		}

		$data['reason']=$tempreason;

		$lowerlimit=$lowerlimit+2;

		$upperlimit1=2;

		$limit=$lowerlimit.','.$upperlimit;

				

		$result = $this->load->view('dashboards/zone_parts/ad_display', $data, true); 

		echo($this->dr->GetDR("",$limit,$result, "0"));

	}

	function edit_ad($adid,$zoneid,$selectid,$mainid,$businessid,$allbusiness_id){ 		

		$data = array();

		$data['zoneid'] = $zoneid;

		$data['selectedoption'] = $selectid;

		$data['businessid'] = $businessid;

		$data['allbusiness_id'] = $allbusiness_id;

		$data['sticky_ad_settings']=$this->sales_zone->get_default_settings_in_zone($zoneid);		

		$data['add_approve_zone_save'] = $this->ads->edit_ads_in_zone_for_approve($adid,$zoneid,$selectid,$businessid);				

		$data['add_approve_zone'] = $this->ads->get_ads_in_zone_for_approve($mainid,$zoneid,$allbusiness_id);

		$data['countallads']=count($data['add_approve_zone']);

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$my_zones = $this->sales_zone->get_zones_for_user($uid);

		$data['my_zones']=count($my_zones);				

		$result = $this->load->view('dashboards/zone_parts/ad_display', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function delete_ad(/*$adid,$zoneid,$selectid,$mainid,$businessid,$allbusiness_id*/){

		$data = array();

		

		$data['adid'] = $_REQUEST['adid'];

		$data['zoneid'] = $_REQUEST['zoneid'];

		$data['selectedoption'] = $_REQUEST['option'];; 

		$data['mainid'] = $_REQUEST['select_id'];

		$data['businessid'] = $_REQUEST['busid'];

		$data['allbusiness_id'] = $_REQUEST['business_id'];

		//$data['zoneid'] = $zoneid;

		//$data['selectedoption'] = $selectid;

		//$data['businessid'] = $businessid;

		//$data['allbusiness_id'] = $allbusiness_id;

		//var_dump($data); //var_dump($zoneid); 

		$data['add_approve_zone_delete'] = $this->ads->delete_ads_in_zone_for_approve($data['adid'],$data['zoneid']);

		$data['sticky_ad_settings']=$this->sales_zone->get_default_settings_in_zone($data['zoneid']);		

		$data['add_approve_zone'] = $this->ads->get_ads_in_zone_for_approve($data['mainid'],$data['zoneid'],$data['allbusiness_id']);		

		$result = $this->load->view('dashboards/zone_parts/ad_display', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function sticky_ad($adid,$zoneid,$selectid,$mainid,$businessid,$allbusiness_id){ 		

		$data = array();

		$data['zoneid'] = $zoneid;

		$data['selectedoption'] = $selectid;

		$data['businessid'] = $businessid;

		$data['allbusiness_id'] = $allbusiness_id;

		$data['sticky_ad_settings']=$this->sales_zone->get_default_settings_in_zone($zoneid);		

		$data['add_approve_zone_save'] = $this->ads->edit_sticky_ads_in_zone_for_approve($adid,$zoneid,$selectid,$businessid);				

		$data['add_approve_zone'] = $this->ads->get_ads_in_zone_for_approve($mainid,$zoneid,$allbusiness_id);

		$data['countallads']=count($data['add_approve_zone']);

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$my_zones = $this->sales_zone->get_zones_for_user($uid);

		$data['my_zones']=count($my_zones);				

		$result = $this->load->view('dashboards/zone_parts/ad_display', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function saveAdfromshowad(){    // 7313

        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

		//var_dump($id); exit;

        $name = $_REQUEST['name'];

        $offerCode = $_REQUEST['offer_code'];

		$adtext = $_REQUEST['adtext'];//var_dump($adtext); exit; 

		$zoneid=$_REQUEST['zoneid'];

        $business_id = $_REQUEST['business_id'];

        $category_id = $_REQUEST['category_id'];

		$subcategory_id_arr = $_REQUEST['subcategory_id'];

		if($subcategory_id_arr!='null'){

		

		//var_dump($subcategory_id_arr);

		//var_dump(count($subcategory_id_arr)); //exit;

		if(count($subcategory_id_arr)==2){

			

		if($subcategory_id_arr[0]!=''){

			$subcategory_id=$subcategory_id_arr[0];

		}else{

			$subcategory_id=0;

		}

		if($subcategory_id_arr[1]!=''){

			$subcategory_id1=$subcategory_id_arr[1];

		}else{

			$subcategory_id1=0;

		}

		}else if(count($subcategory_id_arr)==1){

			if($subcategory_id_arr[0]!=''){

			$subcategory_id=$subcategory_id_arr[0];

		}else{

			$subcategory_id=0;

		}

		$subcategory_id1=0;

		}

	    }else{

			$subcategory_id=0; $subcategory_id1=0; 

		}

		//var_dump($subcategory_id); var_dump($subcategory_id1);exit; 

		/*if($subcategory_id_arr!='null' || $subcategory_id_arr!=''){

		$subcategory_id=implode(",",$subcategory_id_arr);

		}else{

			$subcategory_id=0;

		}*/

		//var_dump($subcategory_id); exit;

		$imagetype = $_REQUEST['imagetype'];

		

        $return_ads = empty($_REQUEST['biz_list']);

        $ad_startdatetime = $_REQUEST['ad_startdatetime'];

        $ad_stopdatetime = $_REQUEST['ad_stopdatetime'];

        $text_message = $_REQUEST['text_message'];

		$iseditad=$_REQUEST['iseditad'];

		/*$change_reason=$_REQUEST['change_reason'];*/

        

        $docs_pdf = $_REQUEST['docs_pdf'];

		//var_dump($docs_pdf); exit;

        $a=1; $b=2;

        $data = array(

            'name' => stripslashes($name),

            'adtext' => $adtext,

            //'starttime' => $starttime,

            //'stoptime' => $stoptime,

            'categoryid' => $category_id,

			'subcategoryid' => $subcategory_id,

			'subcategoryid1' => $subcategory_id1,

			/*'categoryid' => 0,

			'subcategoryid' => 0,*/

			'imagetype' =>  $imagetype,

            'active' => '1',

        	'startdatetime' => $ad_startdatetime,

       		'stopdatetime' => $ad_stopdatetime,

       		'text_message' => stripslashes($text_message),

        	'docs_pdf' => $docs_pdf

        ); //var_dump($data); exit;

        if(!empty($offerCode)){

            $data['offer_code'] = stripslashes($offerCode);

        }

        if(!empty($business_id))

        {

            $data['business_id'] = $business_id;

        }

		//var_dump($data); exit;

        if(!empty($id) && $id > 0)

        {

            //update

			//var_dump($id); exit;

            $this->db->where('id', $id);

            $this->db->update('ads', $data);

        }

        else

        {

            //insert

			//var_dump($id); exit;

            $this->db->insert('ads', $data);

			// Athena eSolutions - 01.12.2012

			// Ad setting preferences start

			$adid= $this->db->insert_id();

			$data['ads_save_zone'] = $this->ads->ads_save_zonetofromzone($zoneid,$business_id,$adid);

			// Ad setting preferences end 			

        }

		

		//if edit ad then

		/*if($iseditad==1){

			//$arr_myad_change_reason==$this->ads->getReasonOfAdChange($this->ion_auth->user()->row()->id,5,$zoneid);

			$arr=array('adid'=>$id,'usertype'=>5,'userid'=>$this->ion_auth->user()->row()->id,'reason'=>$change_reason);

			$this->db->insert('ads_edit_info', $arr);

		}*/

        if(!empty($return_ads))

        {

            $data['ads'] = $this->ads->get_ads_for_business($business_id);

            $tag = $this->load->view("dashboards/business_parts/ad_table", $data, true);

        }

        else

        {

           // $data['business'] = $this->business->get_business_by_id($business_id);

            //$data['business_owner'] = $this->users->get_by_id($data['business']->business_owner_id);

            //$tag = $this->load->view("dashboards/business_parts/data_view", $data, true);

        }

		//var_dump($tag);

        //echo($this->dr->GetDR("Success", "Success", $tag, "0"));



    }

	

	function showeditform($adid='',$zoneid='',$businessid=''){ //var_dump($adid); var_dump($businessid); var_dump($zoneid); exit;

		//$data['category_list2'] = $this->category_model->get_all_subcategories_ad_zone($zoneid);

		//var_dump($data['category_list2']); //anish

		$data=$this->ads->get_ads_by_zoneid_adid_selectedid_businessid($zoneid,$adid,$businessid);

		//var_dump($data);

		//$data['subcategory_category_zone']=$this->category_model->get_all_subcategories_zone($data[0]['categoryid'],$zoneid);

		//var_dump($data[0]);

		//$category_list2=$this->category_model->get_all_subcategories_zone($data[0]['categoryid'],$zoneid);

		//var_dump($category_list2);

		//$result = $this->load->view('dashboards/business_parts/ad_subcategory_zone', $category_list2, true);

		//echo($this->dr->GetDR("","", $result, "0"));

		//var_dump($data[0]['categoryid']);

		echo($this->dr->GetDR_athena($data[0]));

	}

	function showeditformnew($adid='',$businessid='',$zoneid=false){

		//$data['category_list2'] = $this->category_model->get_all_subcategories_ad_zone($zoneid);

		$data=$this->ads->get_ads_by_zoneid_adid_selectedid_businessidnew($adid,$businessid);

		$data[0]['zoneid']=$zoneid;

		//var_dump($data);

		echo($this->dr->GetDR_athena($data[0]));

	}

	function subcategories_in_a_category_zone(){ 

		$catid=$_REQUEST['cat_id']; $zoneid=$_REQUEST['iszoneid'];

		//$cat_id_final=implode(',',$catid);

		//var_dump($cat_id_final); exit;

		//$cat_id_final=implode(',',$catid);

		$data['subcategory_category_zone']=$this->category_model->get_all_subcategories_zone($catid,$zoneid);

		//var_dump($data['subcategory_category_zone']);

		$data['adid']=0; $data['zoneid']=0; $data['businessid']=0;

		$result = $this->load->view('dashboards/business_parts/ad_subcategory_zone', $data, true);

		

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function zone_subcategories_in_a_category_zone(){ 

		$catid=$_REQUEST['cat_id']; $zoneid=$_REQUEST['iszoneid'];

		//$cat_id_final=implode(',',$catid);

		//var_dump($cat_id_final); exit;

		//$cat_id_final=implode(',',$catid);

		$data['subcategory_category_zone']=$this->category_model->zone_get_all_subcategories_zone($catid,$zoneid);

		//var_dump($data['subcategory_category_zone']);

		$data['adid']=0; $data['zoneid']=0; $data['businessid']=0;

		$result = $this->load->view('dashboards/zone_parts/ad_subcategory_zone', $data, true);

		

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function show_details_ad($adid=false,$zoneid=false,$businessid=false){

		$data['subcategory_category_zone']=$this->category_model->get_subcategories_in_a_category($adid,$zoneid);

		$data['adid']=$adid; $data['zoneid']=$zoneid; $data['businessid']=$businessid;

		//var_dump($data); exit;

		$result = $this->load->view('dashboards/business_parts/ad_subcategory_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function show_details_ad_zone($adid=false,$zoneid=false,$businessid=false){

		$data['subcategory_category_zone']=$this->category_model->get_subcategories_in_a_category_zone($adid,$zoneid);

		$data['adid']=$adid; $data['zoneid']=$zoneid; $data['businessid']=$businessid;

		//var_dump($data); exit;

		$result = $this->load->view('dashboards/zone_parts/ad_subcategory_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}



	function all_ads_apply_to_all_zones(){

		$all_bus_id=$_REQUEST['all_bus_id']; //exit;		

		$user = $this->ion_auth->user()->row();			

        $uid = 0;

        if(!empty($user)){ $uid = $user->id;}			

		$users_all_zone=$this->sales_zone->users_all_zone($uid);

		//var_dump($users_all_zone);

		//$data['business_to_zone']=$this->business->get_business_to_zone($all_bus_id,$users_all_zone);

		//$data['ads_to_zone']=$this->business->get_ads_to_zone($all_bus_id,$users_all_zone);

		//var_dump($data['business_to_zone']);	

	}

	### Advertisement related Function end

	### Export Business Start

	function export_business_display(){

		$data['zoneid']=$_REQUEST['zoneid'];

		/*$data['zonepref']=$this->ads->getZonePpreferencesByZone($data['zoneid']);

		$data['businesses_of_myzone']=$this->ads->getBusinessesOfMyZoneByZone($data['zoneid']);

		$data['businesses_located_myzone']=$this->ads->getBusinessesLocatedInMyZone($data['zoneid']);*/

		$result = $this->load->view('dashboards/zone_parts/export_business', $data, true);

		echo($this->dr->GetDR("Save Complete","Save Completed...", $result, "0"));

	}

	function export_business(){

		$zoneid=$_REQUEST['zoneid'];

		$business_type=$_REQUEST['business_type'];

		$business_kind=$_REQUEST['business_kind'];

		//var_dump($zoneid); var_dump($business_type); var_dump($business_kind);

		//$export_business=$this->exporter->get_business_export($zoneid,$business_type,$business_kind);

		//var_dump($export_business);

		//$name=$export_business;

		$data=file_get_contents("uploads/docs/file123.csv"); //var_dump($datapath);

		force_download('file123.csv', $data);

	}

	### Export Business End

	### Default Setting Part Start

	function default_setting_display(){

		$data['zoneid']=$_REQUEST['zoneid'];

		$data['zonepref']=$this->ads->getZonePpreferencesByZone($data['zoneid']);

		//var_dump($data['zonepref']);

		$data['businesses_of_myzone']=$this->ads->getBusinessesOfMyZoneByZone($data['zoneid']);

		$data['businesses_located_myzone']=$this->ads->getBusinessesLocatedInMyZone($data['zoneid']);

		$result = $this->load->view('dashboards/zone_parts/default_setting', $data, true);

		echo($this->dr->GetDR("Save Complete","Save Completed...", $result, "0"));

	}

	public function savespecificBusiness(){

		

		$zoneid = $_REQUEST['zoneid'];

        $auto_approve_paid_ad_myzone = $_REQUEST['auto_approve_paid_ad_myzone'];

        $auto_approve_paid_specific_ad_myzone = $_REQUEST['auto_approve_paid_specific_ad_myzone'];

        $auto_approve_paid_ad_locatedmyzone = $_REQUEST['auto_approve_paid_ad_locatedmyzone'];

		$auto_approve_paid_specific_ad_locatedmyzone = $_REQUEST['auto_approve_paid_specific_ad_locatedmyzone'];

		

		$auto_approve_trial_ad_myzone = $_REQUEST['auto_approve_trial_ad_myzone'];

        $auto_approve_trial_specific_ad_myzone = $_REQUEST['auto_approve_trial_specific_ad_myzone'];

        $auto_approve_trial_ad_locatedmyzone = $_REQUEST['auto_approve_trial_ad_locatedmyzone'];

		$auto_approve_trial_specific_ad_locatedmyzone = $_REQUEST['auto_approve_trial_specific_ad_locatedmyzone'];

		

		$auto_approve_paid_business_myzone = $_REQUEST['auto_approve_paid_business_myzone'];

		$auto_approve_paid_business_locatedmyzone = $_REQUEST['auto_approve_paid_business_locatedmyzone'];

		

		$auto_approve_trial_business_myzone = $_REQUEST['auto_approve_trial_business_myzone'];

		$auto_approve_trial_business_locatedmyzone = $_REQUEST['auto_approve_trial_business_locatedmyzone'];

		

		$auto_approve_listed_business_myzone = $_REQUEST['auto_approve_listed_business_myzone'];

		$auto_approve_listed_business_locatedmyzone = $_REQUEST['auto_approve_listed_business_locatedmyzone'];

		

		$auto_approve_emergency_announcements = $_REQUEST['auto_approve_emergency_announcements'];

		$auto_approve_normal_announcements = $_REQUEST['auto_approve_normal_announcements'];

		

		$auto_approve_offers_announcements = $_REQUEST['auto_approve_offers_announcements'];

		$auto_approve_banner = $_REQUEST['auto_approve_banner'];

		$showoffer = $_REQUEST['showoffer'];

		

		$auto_approve_sticky_ad = $_REQUEST['auto_approve_sticky_ad'];

		

		$ischangezonetheme = $_REQUEST['ischangezonetheme'];

		//if($ischangezonetheme==1){

		$zonetheme = ($_REQUEST['ischangezonetheme']==1) ? '' : $_REQUEST['zonetheme'];

		

		//var_dump($ischangezonetheme); var_dump($zonetheme); exit;

		

		$data=array('zoneid'=>$zoneid,

					'auto_approve_paid_ad_myzone'=>$auto_approve_paid_ad_myzone,

					'auto_approve_paid_specific_ad_myzone'=>$auto_approve_paid_specific_ad_myzone,

					'auto_approve_paid_ad_locatedmyzone'=>$auto_approve_paid_ad_locatedmyzone,

					'auto_approve_paid_specific_ad_locatedmyzone'=>$auto_approve_paid_specific_ad_locatedmyzone,

					'auto_approve_trial_ad_myzone'=>$auto_approve_trial_ad_myzone,

					'auto_approve_trial_specific_ad_myzone'=>$auto_approve_trial_specific_ad_myzone,

					'auto_approve_trial_ad_locatedmyzone'=>$auto_approve_trial_ad_locatedmyzone,

					'auto_approve_trial_specific_ad_locatedmyzone'=>$auto_approve_trial_specific_ad_locatedmyzone,

					

					'auto_approve_paid_business_myzone'=>$auto_approve_paid_business_myzone,

					'auto_approve_paid_business_locatedmyzone'=>$auto_approve_paid_business_locatedmyzone,

					'auto_approve_trial_business_myzone'=>$auto_approve_trial_business_myzone,

					'auto_approve_trial_business_locatedmyzone'=>$auto_approve_trial_business_locatedmyzone,

					

					'auto_approve_listed_business_myzone'=>$auto_approve_listed_business_myzone,

					'auto_approve_listed_business_locatedmyzone'=>$auto_approve_listed_business_locatedmyzone,

					

					'auto_approve_emergency_announcements'=>$auto_approve_emergency_announcements,

					'auto_approve_normal_announcements'=>$auto_approve_normal_announcements,

					 

					'auto_approve_offers_announcements'=>$auto_approve_offers_announcements,

					'auto_approve_banner'=>$auto_approve_banner,

					'displayoffer'=>$showoffer,

					'auto_approve_sticky_ad'=>$auto_approve_sticky_ad,

					'ischangezonetheme'=>$ischangezonetheme,

					'zonetheme'=>$zonetheme);

					

        $sql="select id from zone_preferences where zoneid=".$zoneid;

        $query = $this->db->query($sql);

        if($query->row())

        {

			$zids=$query->row()->id;

            $this->db->where('id',$zids);

            $this->db->update('zone_preferences', $data);

        }else{

			$this->db->insert('zone_preferences', $data);

        	$zids = $this->db->insert_id();

		}

		$message="Success";

		echo($this->dr->GetDR("Success", $message, $zids, "0"));

		exit;	

	}

	### Default Setting Part End

	### Announcement Part Start

	function getAnnounceData($id,$announcements_category,$announcements_type,$charval){

		$data=array();

		$data['announcements_category']=$announcements_category;

		$data['announcements_type']=$announcements_type;

		$data['announcement_list'] = $this->announcements->get_announcements_for_zone($id,$announcements_category,$announcements_type,$charval);

		$data['countallannouncements']=count($data['announcement_list']);

		//var_dump($data['announcement_list']);

        //$data['announcement_table'] = $this->load->view("admin/announcement.table_2.php",$data, true);

		if($announcements_category==0){

			$result = $this->load->view("dashboards/zone_parts/announcement_display.php",$data, true);

		}else if($announcements_category!=0){

			$result = $this->load->view("dashboards/zone_parts/announcement_display_by_organization.php",$data, true);

		}

		

		//var_dump($result); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function getAnnounceData_org($zoneid,$orgid){

		//var_dump($zoneid); var_dump($orgid); exit;

		$data=array();

		$data['announcement_list'] = $this->announcements->get_announcements_for_organization($zoneid,$orgid);

		$data['countallannouncements']=count($data['announcement_list']);

		//var_dump($data['announcement_list']);

        //$data['announcement_table'] = $this->load->view("admin/announcement.table_2.php",$data, true);

		$result = $this->load->view("dashboards/zone_parts/organization_announcement_display.php",$data, true);

		//var_dump($result); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function create_generate_password_org(){

		$size = 8;

		$pool = array_merge(range(0, 9), range('A', 'Z'), range('a', 'z'));

		$rand_keys = array_rand($pool, $size);

		$password = ''; 

		foreach ($rand_keys as $key) {

			$password .= $pool[$key];

		}

		echo($this->dr->GetDR("","", $password, "0"));

	}

	function SaveOrganization(){

		/*$this->announcements->save_organization($_REQUEST);

		$data = array();

		$data['announcement_list'] = $this->announcements->get_announcements_for_zone($_REQUEST['zone_id']    );

		$var = $this->load->view("admin/announcement.table.php",$data, true);

        echo($this->dr->GetDR("Save Successful", "The save was successful", $var, $height = "0"));*/

		//var_dump($_REQUEST['org_type']); exit;

		

		$auser = $this->ion_auth->user()->row();

		$uid = $auser->id;

		$id = stripslashes($_REQUEST['id']); //var_dump($id); exit;

		$zone_id = stripslashes($_REQUEST['zone_id']);

		$org_name = stripslashes($_REQUEST['org_name']);

		$org_type=$_REQUEST['org_type'];

		$org_email = stripslashes($_REQUEST['org_email']);

		$org_username = stripslashes($_REQUEST['org_username']);

		$org_password = stripslashes($_REQUEST['org_password']);

		//var_dump($id); exit;

		

		//var_dump($organization_owner_id);

		if($id>0){

			$newdata=array('name' => $org_name);

			$this->db->where('id',$id);

            $this->db->update('zone_organization', $newdata);

			$update_users=$this->ion_auth->update_user_info_for_organization($id,$org_username,$org_password,$org_email,$zone_id);

			

		}else{

			$additional_data='';

			$organization_owner_id = $this->ion_auth->register($org_username, $org_password, $org_email, $additional_data);

			$this->ion_auth->change_user_group($organization_owner_id);

			$data=array('name' => $org_name,'type'=>$org_type,'zoneid' => $zone_id,'ownerid' => $uid);

			$this->db->insert('zone_organization', $data);

			$orgid= $this->db->insert_id();

			

			$data=array('zone_id' =>$zone_id,'title' =>'Organization Info Comming Soon','date_modified' =>date("Y-m-d"),'announcement_text'=>'','announcement_type'=>0,'organizationid'=>$orgid,'approval'=>1);

			$this->db->insert('zone_announcement', $data);

			

			$data=array('orgid' => $orgid,'userid' => $organization_owner_id,'zoneid' => $zone_id,'approval'=>1);

			$this->db->insert('organization_owners_in_zone', $data);

			

			

		}

		$data['organization_list'] = $this->announcements->get_organization_for_zone($_REQUEST['zone_id']);

		$data['zoneinformation'] = $this->announcements->get_zoneinformation($_REQUEST['zone_id']); // get zone informations

		//var_dump($data['zoneinformation']); echo '<br/>';

		$zonename=$data['zoneinformation']->zname;

		$zoneowneremail=$data['zoneinformation']->email;

		$zoneownerfname=$data['zoneinformation']->first_name;

		$zoneownerlname=$data['zoneinformation']->last_name;

		//exit;

		// this is commented for local

		$path = "http://savingssites.com";

		$login_path = "http://savingssites.com/welcome/zone_login";

		$message="<div style='border:1px solid #900; padding:5px;'>Dear ".$org_username.",<br /><br />

				Your organization has been created on SavingsSites by <strong>".$zoneownerfname." ".$zoneownerlname."</strong> (".$zoneowneremail."). To learn more about SavingsSites and it's benefits, please click <a href='".$path."'>HERE</a><br/><br/>

				Your organization information below listed by <strong>".$zoneownerfname." ".$zoneownerlname."</strong> is as below:<br/><br/>

				Organization Name: ".$org_name."<br/>

				Login URL: <a href='".$login_path."'>http://savingssites.com/welcome/zone_login</a><br/>

				Username: ".$org_username."<br/>

				Password: ".$org_password."<br/><br/>

				You can login into your account and change this information at your convenience.<br /><br />

				We are constantly trying to improve the application and will notify you of future updates as and when they are available. If you have any queries in the meantime then please email us at <a href='mailto:support@savingssites.com'>support@savingssites.com</a> and we will get back to you promptly.<br /><br />

				Best Regards,<br />

				Savings Sites Support." ;

		$fromemail='noreply@savingssites.com';

		$this->load->library('email');

		$template_subject="Your organization has been created";

		$this->email->clear();

		$this->email->from($fromemail);

		$this->email->subject($template_subject);

		$this->email->message($message);

		if($org_email!='')

		{

			$this->email->to($org_email);

			$this->email->send();

			$to[]=$org_email;

		}

		$var = $this->load->view("dashboards/zone_parts/organization_display.php",$data, true);

        echo($this->dr->GetDR("Save Successful", "The save was successful", $var, $height = "0"));

		//var_dump($org_name);exit;

	}

	function getOrganizationData($id){

		$data=array();

		$data['organization_list'] = $this->announcements->get_organization_for_zone($id);// var_dump($data['organization_list']);

        //$data['announcement_table'] = $this->load->view("admin/announcement.table_2.php",$data, true);

		$result = $this->load->view("dashboards/zone_parts/organization_display.php",$data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function EditOrganization($id){

		//var_dump($this->announcements->get_organization_by_id($id));

		echo(json_encode($this->announcements->get_organization_by_id($id)));

	}

	function ApprovalOrganization($id,$status,$zoneid){

		//var_dump($id); var_dump($status); var_dump($zoneid);

		$data = array();

		//$data['ApprovalOrganization'] = $this->announcements->get_organization_for_zone($id);

		$data['ApprovalOrganization']=$this->announcements->announcement_organization_status_change($id,$status);

		$data['organization_list'] = $this->announcements->get_organization_for_zone($zoneid);

		//var_dump($data['organization_list']);

		$result = $this->load->view("dashboards/zone_parts/organization_display.php",$data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

		

	}

	function DeleteOrganization(){

		$id = $_REQUEST['id'];

		$zone_id = $_REQUEST['zone_id'];

		$data = array();

		$data['organization_delete']=$this->announcements->delete_organization_by_id($id);  

		$data['organization_list'] = $this->announcements->get_organization_for_zone($zone_id);

		$data['countallannouncements']=count($data['organization_list']);        

		$result = $this->load->view("dashboards/zone_parts/organization_display.php",$data, true); 

		//var_dump($result);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function announcement_status_change($anid=false,$option=false,$announcements_category=false,$announcements_type=false,$zoneid=false,$charval=false){ 		

		$data = array();

		$data['anid'] = $zoneid;

		$data['option'] = $option;

		//var_dump($announcements_category);

		/*$data['businessid'] = $businessid;

		$data['allbusiness_id'] = $allbusiness_id;*/

			

		/*$data['add_approve_zone_save'] = $this->ads->edit_ads_in_zone_for_approve($adid,$zoneid,$selectid,$businessid);				

		$data['add_approve_zone'] = $this->ads->get_ads_in_zone_for_approve($mainid,$zoneid,$allbusiness_id);

		$data['countallads']=count($data['add_approve_zone']);*/

		$data['announcements_category']=$announcements_category;

		$data['announcements_type']=$announcements_type;

		$data['announcement_status_change']=$this->announcements->announcement_status_change($anid,$option);

		$data['announcement_list'] = $this->announcements->get_announcements_for_zone($zoneid,$announcements_category,$announcements_type,$charval);

		

		$data['countallannouncements']=count($data['announcement_list']);

		

		if($announcements_category==0){

			$result = $this->load->view("dashboards/zone_parts/announcement_display.php",$data, true);

		}else if($announcements_category!=0){

			$result = $this->load->view("dashboards/zone_parts/announcement_display_by_organization.php",$data, true);

		}

						

		//$result = $this->load->view('dashboards/zone_parts/ad_display', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	### Announcement Part End

	// bulk email portion start

	function get_business_bulk($zone)

	{

		$data['business_owner_bulk']=$this->business->get_businesses_owner_new($zone);

		$data["ajax"] = 'ajax';

		$data["zone_id"] = $zone;	

		$this->load->view("dashboards/bulk_template", $data);

		exit;

	}

	function get_template_bulk()

	{

		$data["template"] = 'template';

		$data["ajax"] = 'ajax';

			

		$template_list = $this->template->get_all_template_admin();

		$data['template_list']=$template_list;

		$this->load->view("dashboards/bulk_template", $data);

		exit;

	}

	function edit_template_bulk($id)

	{

			$data['id']=$id;

		

			$data["ajax"] = 'ajax';

		

			$data['ckeditor'] = array(

		

					//ID of the textarea that will be replaced

					'id' 	=> 	'addtemplate_content',

					'path'	=>	'assets/ckeditor',

		

					//Optional values

					'config' => array(

							'toolbar' 	=> 	"Full", 	//Using the Full toolbar

							'width' 	=> 	"550px",	//Setting a custom width

							'height' 	=> 	'100px',	//Setting a custom height

		

					));

		

			$data["template"] = 'newtemplate';

		

			$sql_address="select * from template where id = $id";

			$query_address=$this->db->query($sql_address);

		

			$row = $query_address->row();

			 

			$data["template_data"] = $row;

			 

			$this->load->view("dashboards/bulk_template", $data);

			exit;

		}

	function delete_template_bulk($id=false)

	{

		$title = " Failed";

		$message = "There was no id set";

		if(!empty($id) && $id > 0)

		{

			$this->db->delete('template', array('id' => $id));

			$title = " Succeeded";

			$message = "Delete is complete.";

		}

		$this->get_template_bulk();

		exit;

	}

	function newtemplate_bulk($zone)

	{

		$data["template"] = 'newtemplate';

			

		$data["bus_id"] = $bus_id;

		$data["count"] = $count;

		$data["ajax"] = 'ajax';

			

		$data['zoneId'] = $zone;

			

		$data['ckeditor'] = array(

		

				//ID of the textarea that will be replaced

				'id' 	=> 	'addtemplate_content',

				'path'	=>	'assets/ckeditor',

		

				//Optional values

				'config' => array(

					'toolbar' 	=> 	"Full", 	//Using the Full toolbar

					'width' 	=> 	"550px",	//Setting a custom width

					'height' 	=> 	'100px',	//Setting a custom height

		

				));

			

		$this->load->view("dashboards/bulk_template", $data);

		exit;

	}

	function save_template_bulk($zone)

	{

			$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

			$status = $_REQUEST['status'];

			$zone = $_REQUEST['zone'];

			$template_subject = $_REQUEST['template_subject'];

			$template_content = $_REQUEST['addtemplate_content'];

			

			$data = array(

					"subject" => $template_subject,

					"content" => $template_content,

					"admin"   =>'1'

			);

			

			if(!empty($id) && $id > 0)

			{

				//update

				$this->db->where('id', $id);

				$this->db->update('template', $data);

			}

			else

			{

				//insert

				$this->db->insert('template', $data);

			}

			if($status==1)

			{

				$this->set_subscriber_bulk($zone,$id);

			}else{

				$this->get_template_bulk();

			}

			 

			exit;

	}

	function get_all_business($user,$zoneId)

	{

		$all_business_by_user = $this->business->get_all_business_by_user($user,$zoneId);

			

		$data["zone_id"] = $zoneId;

		$data["ajax"] = 'ajax';

			

		?>

			<table align="center" class="pretty" width="950px" cellpadding="0" cellspacing="0">

		        <thead>

		            <tr>

						<th width="250px">Businesses</th>

		            </tr>

		        </thead>

		                <tbody>

		                    <? foreach ($all_business_by_user as $business_types){?>

		                    <tr>

								<td><?=$business_types['name']?></td>

							</tr>

							<?}?>

		            	</tbody>

		            </table>

		            <button onclick="$('#contactOwnerDialog').dialog('close');">Close</button>

		<?php

			

			//$this->load->view("dashboards/bulk_template", $data);

		exit;

	}

	function set_subscriber_bulk($zone,$id=-1)

	{

			$business_subscriber = $_REQUEST['zone_owner'];

			$template_list = $this->template->get_all_template();

				

			$data['ckeditor'] = array(

			

					//ID of the textarea that will be replaced

					'id' 	=> 	'template_content',

					'path'	=>	'assets/ckeditor',

			

					//Optional values

					'config' => array(

							'toolbar' 	=> 	"Full", 	//Using the Full toolbar

							'width' 	=> 	"550px",	//Setting a custom width

							'height' 	=> 	'100px',	//Setting a custom height

			

					));

			

			$data['id']=$id;

			$data['business_subscriber']='';

			$data['template_list']=$template_list;

			

			$data['business_subscriber'] = $business_subscriber;

			

			$data["ajax"] = 'ajax';

			$this->load->view("dashboards/bulk_set_subscriber", $data);

			exit;

		}

	// bulk email portion end

	

	/* Municipal Owner start */

	

	/* Municipal Owner end */

	/* Zone Manager start */

	

	/* Zone Manager end */

	

	/* Style Tag Part Start */

	

	/*  Style Tag Part End */	

	### ****************** Zone Owner Part End ******************************************

	### ***************** Business Related Function Part Start **********************************

	### Business Data part start

	### Business Owner Verification Start

	function update_business_verification(){

		$data=array();

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$data['businessid'] = empty($_REQUEST['bid'])? 0 : $_REQUEST['bid'];

		

		$data['bus_name'] = empty($_REQUEST['bus_name'])? '' : $_REQUEST['bus_name'];

		$data['bus_fname'] = empty($_REQUEST['bus_fname'])? '' : $_REQUEST['bus_fname'];

		$data['bus_lname'] = empty($_REQUEST['bus_lname'])? '' : $_REQUEST['bus_lname'];

		$data['bus_email'] = empty($_REQUEST['bus_email'])? '' : $_REQUEST['bus_email'];

		$data['bus_website'] = empty($_REQUEST['bus_website'])? '' : $_REQUEST['bus_website'];

		$data['bus_address'] = empty($_REQUEST['bus_address'])? '' : $_REQUEST['bus_address'];

		$data['bus_city'] = empty($_REQUEST['bus_city'])? '' : $_REQUEST['bus_city'];

		$data['bus_state'] = empty($_REQUEST['bus_state'])? '' : $_REQUEST['bus_state'];

		$data['bus_zip'] = empty($_REQUEST['bus_state'])? '' : $_REQUEST['bus_zip'];

		

		

		

		

		

		$data['user_email'] = empty($_REQUEST['user_email'])? '' : $_REQUEST['user_email'];

		$data['user_fname'] = empty($_REQUEST['user_fname'])? '' : $_REQUEST['user_fname'];

		$data['user_lname'] = empty($_REQUEST['user_lname'])? '' : $_REQUEST['user_lname'];

		$data['user_phone'] = empty($_REQUEST['user_phone'])? '' : $_REQUEST['user_phone'];

		$data['user_address'] = empty($_REQUEST['user_address'])? '' : $_REQUEST['user_address'];

		$data['user_city'] = empty($_REQUEST['user_city'])? '' : $_REQUEST['user_city'];

		$data['user_state'] = empty($_REQUEST['user_state'])? '' : $_REQUEST['user_state'];

		$data['user_zip'] = empty($_REQUEST['user_zip'])? '' : $_REQUEST['user_zip'];

		

		

		$data['update_business_business_owner'] = $this->business->update_business_business_owner($data['businessid'],$data['bus_name'],$data['bus_fname'],$data['bus_lname'],$data['bus_email'],$data['bus_website'],$data['bus_address'],$data['bus_city'],$data['bus_state'],$data['bus_zip']);

		$data['update_ad_setting_pref_business_owner'] = $this->business->update_ad_setting_pref_business_owner($data['businessid']);

		

		$data['update_users'] = $this->users->update_users_for_business_owner($uid,$data['user_email'],$data['user_fname'],$data['user_lname'],$data['user_phone'],$data['user_address'],$data['user_city'],$data['user_state'],$data['user_zip']);

		

		

		$result=$data['businessid'];

		echo($this->dr->GetDR("","", $result, "0"));

	}

	### Business Owner Verification End

	

	### Ad Setting Preferences Part Start

	function display_adsettingpref($busid){ //echo $busid; exit;

		$data = array();

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		if(!empty($user)){

			$data["status"] = $user->status;

        }

		

		$data['business'] = $this->business->get_business_by_id($busid);

		$data['business_id']=$busid;

		$data['view_default_ad_setting_pref'] = $this->sales_zone->get_default_zones_for_ad_pref($busid);

		$data['view_ad_setting_pref'] = $this->sales_zone->get_all_zones_for_ad_pref($busid);

		$data['select_all_ziped_zone_for_ad_pref'] = $this->sales_zone->get_all_ziped_zone_for_ad_pref($busid);

		$data['count_select_all_ziped_zone_for_ad_pref']=count($data['select_all_ziped_zone_for_ad_pref']);

		//var_dump($data['count_select_all_ziped_zone_for_ad_pref']);

		$data['business'] = $this->business->get_business_by_id($busid);

		//var_dump($data['business']);

		$result = $this->load->view('dashboards/ad_setting_pref_to_zone', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));		

	}

	function save_zone_for_ad_pref($id,$zone,$checkbox_value){

		$data = array();

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		if(!empty($user)){

			$data["status"] = $user->status;

        }

		

		$data['business'] = $this->business->get_business_by_id($id);

		$data['business_id'] = $id;

		$data['zone_id'] = $zone;		

		$data['save_zone_ads_pref'] = $this->sales_zone->save_zone_ads_pref($id,$zone,$checkbox_value);		

		$data['select_all_ziped_zone_for_ad_pref'] = $this->sales_zone->get_all_ziped_zone_for_ad_pref($id);

		$data['count_select_all_ziped_zone_for_ad_pref']=count($data['select_all_ziped_zone_for_ad_pref']);

		$data['view_ad_setting_pref'] = $this->sales_zone->get_all_zones_for_ad_pref($id);

		$data['view_default_ad_setting_pref'] = $this->sales_zone->get_default_zones_for_ad_pref($id);

		$result = $this->load->view('dashboards/ad_setting_pref_to_zone', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function delete_zone_for_ad_pref($id,$zone,$checkbox_value){

		$data = array();

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		if(!empty($user)){

			$data["status"] = $user->status;

        }

		

		$data['business'] = $this->business->get_business_by_id($id);

		$data['business_id'] = $id;

		$data['zone_id'] = $zone;

		$data['delete_zone_ads_pref'] = $this->sales_zone->delete_zone_ads_pref($id,$zone,$checkbox_value);		

		$data['select_all_ziped_zone_for_ad_pref'] = $this->sales_zone->get_all_ziped_zone_for_ad_pref($id);

		$data['count_select_all_ziped_zone_for_ad_pref']=count($data['select_all_ziped_zone_for_ad_pref']);

		$data['view_ad_setting_pref'] = $this->sales_zone->get_all_zones_for_ad_pref($id);

		$data['view_default_ad_setting_pref'] = $this->sales_zone->get_default_zones_for_ad_pref($id);						

		$result = $this->load->view('dashboards/ad_setting_pref_to_zone', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	### Ad Setting Preferences Part end

	### Ad Part Start

	function new_ads($id){

		$data['businessid']=$id;

		$data['category_list_business'] = $this->category_model->get_all_categories_business($id);

		 $data['ckeditor_businessad'] = array(



            //ID of the textarea that will be replaced

            'id' 	=> 	'ad_text_business',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



            ));

		$result = $this->load->view('dashboards/business_parts/new_ad', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function subcategories_in_a_category($catid,$businessid){

		$data = array();

		$data['subcategory_category']=$this->category_model->get_all_subcategories_business($catid,$businessid);

		$result = $this->load->view('dashboards/business_parts/ad_subcategory', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function saveAd(){ // 7313

		//$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

		$id = $_REQUEST['id']==-1 ? "-1" : $_REQUEST['id'];

		$adid = $_REQUEST['adid']==-1 ? "-1" : $_REQUEST['adid'];

		//echo $id.' --- '.$adid; exit;

		//var_dump($id); var_dump($adid);

        $name = $_REQUEST['name'];

        $offerCode = $_REQUEST['offer_code'];

		$adtext = $_REQUEST['adtext']; //var_dump($adtext);

        $business_id = $_REQUEST['business_id'];

        $category_id_arr = $_REQUEST['category_id'];

		//$subcategory_id = $_REQUEST['subcategory_id'];

		$_subcategory_id1_arr=$_REQUEST['subcategory_id1'];

		$_subcategory_id2_arr=$_REQUEST['subcategory_id2'];

		$_subcategory_id_1=0;$_subcategory_id_2=0; $_category_id_1=0; $_category_id_2=0;

		//var_dump($category_id_arr); var_dump($_subcategory_id1_arr); var_dump($_subcategory_id2_arr); var_dump(count($_subcategory_id1_arr)); var_dump(count($_subcategory_id2_arr));

		if($category_id_arr!=0){

			//$category_id_ex=explode(',',$category_id_arr);

			

			$_category_id_1=(!empty($category_id_arr[0]))?$category_id_arr[0]:0;

			$_category_id_2=(!empty($category_id_arr[1]))?$category_id_arr[1]:0;

			

			if($_subcategory_id1_arr!='0'){

				if(count($_subcategory_id1_arr)==2){

					$_subcategory_id_1=(!empty($_subcategory_id1_arr[0]))?$_subcategory_id1_arr[0]:0;

					$_subcategory_id_2=(!empty($_subcategory_id1_arr[1]))?$_subcategory_id1_arr[1]:0;

				}else if(count($_subcategory_id1_arr)==1){

					$_subcategory_id_1=(!empty($_subcategory_id1_arr[0]))?$_subcategory_id1_arr[0]:0;

				}

				//$_subcategory_id_1=(!empty($_subcategory_id1_arr[0]))?$_subcategory_id1_arr[0]:0;

				//$_subcategory_id_2=(!empty($_subcategory_id1_arr[1]))?$_subcategory_id1_arr[1]:0;

			}else{

				//$_subcategory_id_1=0;

			}

			

			if($_subcategory_id2_arr!='0'){

				

				if(count($_subcategory_id2_arr)==2){

					$_subcategory_id_1=(!empty($_subcategory_id2_arr[0]))?$_subcategory_id2_arr[0]:0;

					$_subcategory_id_2=(!empty($_subcategory_id2_arr[1]))?$_subcategory_id2_arr[1]:0;

				}else if(count($_subcategory_id2_arr)==1){

					$_subcategory_id_2=(!empty($_subcategory_id2_arr[0]))?$_subcategory_id2_arr[0]:0;

				}

				//$_subcategory_id_1=(!empty($_subcategory_id2_arr[0]))?$_subcategory_id2_arr[0]:0;

				//$_subcategory_id_2=(!empty($_subcategory_id2_arr[1]))?$_subcategory_id2_arr[1]:0;

			}else{

				//$_subcategory_id_2=0;

			}

			

		}else{

			$_category_id_1=0;

			$_category_id_2=0;

			$_subcategory_id_1=0;

			$_subcategory_id_2=0;

		}

		//var_dump($_category_id_1); var_dump($_category_id_2); var_dump($_subcategory_id_1); var_dump($_subcategory_id_2); exit;

		

		/*$_subcategory_id1_arr=($_REQUEST['subcategory_id1']!='null')? $_REQUEST['subcategory_id1']:'';

		$_subcategory_id2_arr=($_REQUEST['subcategory_id2']!='null')? $_REQUEST['subcategory_id2']:'';

		//var_dump($_subcategory_id1_arr); var_dump($_subcategory_id2_arr); //exit;

		//var_dump(count($_subcategory_id1_arr)); var_dump(count($_subcategory_id2_arr));

		$_subcategory_id_1=0;$_subcategory_id_2=0; $_category_id_1=0; $_category_id_2=0;

		

		if($_subcategory_id1_arr!=''){

			if(count($_subcategory_id1_arr)==2){

				if($_subcategory_id1_arr[0]!='' || $_subcategory_id1_arr[0]!='null'){

					$_subcat1_ex=explode('#',$_subcategory_id1_arr[0]);

					$_subcategory_id_1=$_subcat1_ex[1];

					$_category_id_1=$_subcat1_ex[0];					

				}//else 

				if($_subcategory_id1_arr[1]!='' || $_subcategory_id1_arr[1]!='null'){

					$_subcat1_ex=explode('#',$_subcategory_id1_arr[1]);

					$_subcategory_id_2=$_subcat1_ex[1];

					$_category_id_2=$_subcat1_ex[0];					

				}

			}else if(count($_subcategory_id1_arr)==1){

				if($_subcategory_id1_arr[0]!='' || $_subcategory_id1_arr[0]!='null'){

					//var_dump($_subcategory_id1_arr[0]);

					$_subcat1_ex=explode('#',$_subcategory_id1_arr[0]);

					$_subcategory_id_1=$_subcat1_ex[1];

					$_category_id_1=$_subcat1_ex[0];					

				}

			} 

		}

		if($_subcategory_id2_arr!=''){

			if(count($_subcategory_id2_arr)==2){

				if($_subcategory_id2_arr[0]!='' || $_subcategory_id2_arr[0]!='null'){

					$_subcat2_ex=explode('#',$_subcategory_id2_arr[0]);

					$_subcategory_id_1=$_subcat2_ex[1];

					$_category_id_1=$_subcat2_ex[0];					

				}//else 

				if($_subcategory_id2_arr[1]!='' || $_subcategory_id2_arr[1]!='null'){

					$_subcat2_ex=explode('#',$_subcategory_id2_arr[1]);

					$_subcategory_id_2=$_subcat2_ex[1];

					$_category_id_2=$_subcat2_ex[0];					

				}

			}else if(count($_subcategory_id2_arr)==1){

				if($_subcategory_id2_arr[0]!='' || $_subcategory_id2_arr[0]!='null'){

					$_subcat2_ex=explode('#',$_subcategory_id2_arr[0]);

					$_subcategory_id_2=$_subcat2_ex[1];

					$_category_id_2=$_subcat2_ex[0];					

				}

			} 

		}*/

		//var_dump($_subcategory_id_1); var_dump($_category_id_1); var_dump($_subcategory_id_2); var_dump($_category_id_2); exit;

		

		

		

		

		

		

		/*$subcategory_id_arr = $_REQUEST['subcategory_id'];

		if($subcategory_id_arr!='null'){

		

		//var_dump($subcategory_id_arr);

		//var_dump(count($subcategory_id_arr)); //exit;

		if(count($subcategory_id_arr)==2){

			

		if($subcategory_id_arr[0]!=''){

			$subcategory_id=$subcategory_id_arr[0];

		}else{

			$subcategory_id=0;

		}

		if($subcategory_id_arr[1]!=''){

			$subcategory_id1=$subcategory_id_arr[1];

		}else{

			$subcategory_id1=0;

		}

		}else if(count($subcategory_id_arr)==1){

			if($subcategory_id_arr[0]!=''){

			$subcategory_id=$subcategory_id_arr[0];

		}else{

			$subcategory_id=0;

		}

		$subcategory_id1=0;

		}

	    }else{

			$subcategory_id=0; $subcategory_id1=0; 

		}

*/		//var_dump($subcategory_id); var_dump($subcategory_id1);exit;

		

		

		

		

		

        $return_ads = empty($_REQUEST['biz_list']);

        $ad_startdatetime = $_REQUEST['ad_startdatetime'];

        $ad_stopdatetime = $_REQUEST['ad_stopdatetime'];

        $text_message = $_REQUEST['text_message'];        

        $docs_pdf = $_REQUEST['docs_pdf'];

		$text_reason = $_REQUEST['text_reason'];

		$business_zone_id = $_REQUEST['business_zone_id'];

		$where_from=$_REQUEST['where_from'];

		//var_dump($where_from); exit;

		$data = array(

            'name' => stripslashes($name),

            'adtext' => stripslashes($adtext),

            //'starttime' => $starttime,

            //'stoptime' => $stoptime,

            'categoryid' => $_category_id_1,

			'categoryid1' => $_category_id_2,

			'subcategoryid' => $_subcategory_id_1,

			'subcategoryid1' => $_subcategory_id_2,

            'active' => '1',

        	'startdatetime' => $ad_startdatetime,

       		'stopdatetime' => $ad_stopdatetime,

       		'text_message' => $text_message,

        	'docs_pdf' => $docs_pdf

        );

        if(!empty($offerCode)){

            $data['offer_code'] = stripslashes($offerCode);

        }

        if(!empty($business_id)){        

            $data['business_id'] = $business_id;

        }

		//var_dump($data); exit;

		if($adid>0){ //echo 1; exit;

			$this->db->where('id', $adid);

            $this->db->update('ads', $data);

		}else { //echo 2; exit;

			$this->db->insert('ads', $data);

			$adid= $this->db->insert_id();

			$data['ads_save_zone'] = $this->ads->ads_save_zonefrombusiness($business_id,$adid,$where_from);

			//var_dump($data['ads_save_zone']);			

		}

		/*if($adid>0){

			$this->db->where('id', $adid);

            $this->db->update('ads', $data);

		}*/

		$user = $this->ion_auth->user()->row()->id;

		$data['ads'] = $this->ads->get_ads_for_business($business_id,$user);

		$data['business'] = $this->business->get_business_by_id($business_id);

		$data['zoneid'] = $business_zone_id;

		

		$result = $this->load->view('dashboards/business_parts/ad_table', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));	

	}

	function edit_ads($adid,$busid){

		$data = array();

		/*$data['ckeditor_businessad'] = array(

			//ID of the textarea that will be replaced

			'id' 	=> 	'ad_text_business',

			'path'	=>	'assets/ckeditor',

	

			//Optional values

			'config' => array(

				'toolbar' 	=> 	"Full", 	//Using the Full toolbar

				'width' 	=> 	"550px",	//Setting a custom width

				'height' 	=> 	'100px',	//Setting a custom height



		));	*/

		$data['adid']=$adid;

		$data['businessid']=$busid;

		$data['category_list_business1'] = $this->category_model->get_all_categories_business($busid);

		

		$data['ads']=$this->ads->get_adsbusiness($adid,$busid);

		//var_dump($data['ads']);

		//var_dump($data['ads'][0]['subcategoryid']);

		$data['subcategory_details']= $this->category_model->get_subcategory_details($data['ads'][0]['categoryid']);

		$result = $this->load->view('dashboards/business_parts/edit_ad', $data, true);

		//var_dump($result);

		echo($this->dr->GetDR("","", $result, "0"));

		

	}

	function view_ads($id, $zoneid){

		$data = array();

		$user = $this->ion_auth->user()->row()->id;

		$data['ads'] = $this->ads->get_ads_for_business($id,$user);

		$data['business'] = $this->business->get_business_by_id($id);

		$data['zoneid'] =$zoneid;

		//var_dump($data['business']);

		//$data['defaultzone'] = $this->category_model->get_defaultzone($data['business']->id);

		$result = $this->load->view('dashboards/business_parts/ad_table', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function editzone_ad($adid,$busid){

		$data = array();

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		if(!empty($user)){

			$data["status"] = $user->status;

        }

		$data['business'] = $this->business->get_business_by_id($busid);

		$data['business_id']=$busid;

		$data['view_default_ad_setting_pref'] = $this->sales_zone->get_default_zones_for_ad_pref($busid);

		//var_dump($data['view_default_ad_setting_pref']);

		$_zone_owner_zones_str='';

		foreach($data['view_default_ad_setting_pref'] as $_x_str){

			$_zone_owner_zones_str.=$_x_str['settingszoneid'].",";

			

		}

		//if($_zone_owner_zones_str != '') $_zone_owner_zones_str = substr($_zone_owner_zones_str,0,strlen($_zone_owner_zones_str)-1) ;

		

		

		$data['view_ad_setting_pref'] = $this->sales_zone->get_all_zones_for_ad_pref($busid);

		//var_dump($data['view_ad_setting_pref']);

		foreach($data['view_ad_setting_pref'] as $_x_str){

			$_zone_owner_zones_str.=$_x_str['settingszoneid'].",";

			

		}

		$data['select_all_ziped_zone_for_ad_pref'] = $this->sales_zone->get_all_ziped_zone_for_ad_pref($busid);

		//var_dump($data['select_all_ziped_zone_for_ad_pref']);

		

		foreach($data['select_all_ziped_zone_for_ad_pref'] as $_x_str){

			$_zone_owner_zones_str.=$_x_str['id'].",";

			

		}

		if($_zone_owner_zones_str != '') $_zone_owner_zones_str = substr($_zone_owner_zones_str,0,strlen($_zone_owner_zones_str)-1) ;

		//var_dump($_zone_owner_zones_str);

		

		$data['count_select_all_ziped_zone_for_ad_pref']=count($data['select_all_ziped_zone_for_ad_pref']);

		$data['select_all_ziped_zone'] = $this->sales_zone->get_all_zones_for_business_dashboard($_zone_owner_zones_str);

		

		//var_dump($data['count_select_all_ziped_zone_for_ad_pref']);

		$data['business'] = $this->business->get_business_by_id($busid);

		//var_dump($data['business']);

		$result = $this->load->view('dashboards/business_parts/edit_zone_from_business', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function save_zone_for_ad_pref_from_ad($id,$zone,$checkbox_value){

		$data = array();

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		if(!empty($user)){

			$data["status"] = $user->status;

        }

		$data['business'] = $this->business->get_business_by_id($id);

		$data['business_id'] = $id;

		$data['zone_id'] = $zone;

		$data['view_default_ad_setting_pref'] = $this->sales_zone->get_default_zones_for_ad_pref($id);

		$_zone_owner_zones_str='';

		foreach($data['view_default_ad_setting_pref'] as $_x_str){

			$_zone_owner_zones_str.=$_x_str['settingszoneid'].",";

			

		}		

		$data['save_zone_ads_pref'] = $this->sales_zone->save_zone_ads_pref($id,$zone,$checkbox_value);

		$_zone_owner_zones_str.=$zone.",";		

		$data['select_all_ziped_zone_for_ad_pref'] = $this->sales_zone->get_all_ziped_zone_for_ad_pref($id);

		foreach($data['select_all_ziped_zone_for_ad_pref'] as $_x_str){

			$_zone_owner_zones_str.=$_x_str['id'].",";

			

		}

		if($_zone_owner_zones_str != '') $_zone_owner_zones_str = substr($_zone_owner_zones_str,0,strlen($_zone_owner_zones_str)-1) ;

		

		$data['count_select_all_ziped_zone_for_ad_pref']=count($data['select_all_ziped_zone_for_ad_pref']);

		$data['view_ad_setting_pref'] = $this->sales_zone->get_all_zones_for_ad_pref($id);

		

		$result = $this->load->view('dashboards/business_parts/edit_zone_from_business', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function delete_zone_for_ad_pref_from_ad($id,$zone,$checkbox_value){

		$data = array();

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		if(!empty($user)){

			$data["status"] = $user->status;

        }

		$data['business'] = $this->business->get_business_by_id($id);

		$data['business_id'] = $id;

		$data['zone_id'] = $zone;

		$data['delete_zone_ads_pref'] = $this->sales_zone->delete_zone_ads_pref($id,$zone,$checkbox_value);		

		$data['select_all_ziped_zone_for_ad_pref'] = $this->sales_zone->get_all_ziped_zone_for_ad_pref($id);

		$data['count_select_all_ziped_zone_for_ad_pref']=count($data['select_all_ziped_zone_for_ad_pref']);

		$data['view_ad_setting_pref'] = $this->sales_zone->get_all_zones_for_ad_pref($id);

		$data['view_default_ad_setting_pref'] = $this->sales_zone->get_default_zones_for_ad_pref($id);						

		$result = $this->load->view('dashboards/business_parts/edit_zone_from_business', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	/*function save_zone_for_ad_display($adid,$busid,$zoneid){		

		$data['business_id'] = $busid;

		$data['ad_id'] =$adid;		

		$data['save_zone_ads_display'] = $this->sales_zone->save_zone_ads_display($adid,$busid,$zoneid);		

		$data['show_all_zone_for_ad'] = $this->sales_zone->get_all_zone_for_ad($adid);		

		$data['select_all_ziped_zone_for_ad_display'] = $this->sales_zone->get_all_ziped_zone_for_ad_select($adid);		 

		$result = $this->load->view('dashboards/business_parts/edit_zone_from_business', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function delete_zone_for_ad_display($adid,$zoneid,$busid){		

		$data = array();

		$data['business_id'] = $busid;

		$data['ad_id'] =$adid;		

		$data['delete_zone_ads_display'] = $this->sales_zone->delete_zone_ads_display($adid,$zoneid);

		$data['show_all_zone_for_ad'] = $this->sales_zone->get_all_zone_for_ad($adid);		

		$data['select_all_ziped_zone_for_ad_display'] = $this->sales_zone->get_all_ziped_zone_for_ad_select($adid);		 

		$result = $this->load->view('dashboards/business_parts/edit_zone_from_business', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}*/

	function deleteAd()

    {

        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

		

        $business_id = $_REQUEST['business_id']; //var_dump($id); var_dump($business_id);  

        $this->db->where('id', $id);

        $this->db->delete('ads');

		$this->db->where('adid', $id);

		$this->db->delete('ad_to_zone');

        $data = array();

        $data['ads'] = $this->ads->get_ads_for_business($business_id);

		$data['business'] = $this->business->get_business_by_id($business_id);

		$data['zoneid'] =0;

        $tag = $this->load->view("dashboards/business_parts/ad_table", $data, true);

        echo($this->dr->GetDR("Success", "Success", $tag, "0"));

    }

	### Ad Part End

	### Job parts start 

	function view_jobs($busid){ 

		$data['business'] = $this->business->get_business_by_id($busid);

		$data['ckeditor_jd'] = array(



            //ID of the textarea that will be replaced

            'id' 	=> 	'job_description',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



            ));

		$data['job_listing'] = $this->db->query("select * from job_listing where business_id = " . $busid)->result_array();

        $data['jobs'] = '';		

        $business_owner = true;

       // if($business_owner){

            $data['jobs'] = $this->load->view("dashboards/business_parts/job_view", $data, true);

			echo($this->dr->GetDR("Success", "Success", $data['jobs'], "0"));

        //}

		

	}

	function saveJob(){    

        $id = $_REQUEST['id'];

        $business_id = $_REQUEST['business_id'];

        $title = $_REQUEST['title'];

        $start_date = $_REQUEST['start_date'];

        $salary_range = $_REQUEST['salary_range'];

        $description = $_REQUEST['description'];



        $data = array(

            "business_id" => $business_id,

            "title" => $title,

            "description" => $description,

            "start_date" => $start_date,

            "salary_range" => $salary_range

        );

		//var_dump($id); exit;

        //need a jobs model with CRUD + List



        if($id == "-1")

        {

            //new create

            $this->db->insert('job_listing', $data);

        }

        else

        {

            //save

            $this->db->where('id', $id);

            $this->db->update('job_listing', $data);

        }



        $updata = array();



        $updata['job_listing'] = $this->db->query("select * from job_listing where business_id = " . $business_id)->result_array();

        $data['jobs'] = $this->load->view("dashboards/business_parts/job_view", $updata, true);



        //echo($this->dr->GetDR("Updated", "n/a", $result, "0"));

		//var_dump($data['jobs']);

		echo($this->dr->GetDR("Success", "Success", $data['jobs'], "0"));



    }

    function loadJob(){    

        $id = $_REQUEST['id'];

        $result = $this->db->query("select * from job_listing where id = " .$id);

        echo(json_encode($result->row()));

    }

	function RemoveJob(){    

        $id = $_REQUEST['id'];

        $business_id = $_REQUEST['business_id'];

        $this->db->where('id', $id);

        $this->db->delete('job_listing');

        $updata = array();

        $updata['job_listing'] = $this->db->query("select * from job_listing where business_id = " . $business_id)->result_array();

        //$result = $this->load->view("dashboards/business_parts/job_view", $updata, true);

		$data['jobs'] = $this->load->view("dashboards/business_parts/job_view", $updata, true);

        echo($this->dr->GetDR("Updated", "n/a", $data['jobs'], "0"));

    }

	### Job Part End

	### Barter Part Start

	function view_barter($busid){ 	

		$data['business'] = $this->business->get_business_by_id($busid);

		$data['ckeditor_barterdescription'] = array(

            //ID of the textarea that will be replaced

            'id' 	=> 	'barter_description',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



        ));

		$data['barter_listing'] = $this->db->query("select * from barter_listing where business_id = " . $busid)->result_array();

        $data['barter'] = $this->load->view("dashboards/business_parts/barter_view", $data, true);       

		echo($this->dr->GetDR("Success", "Success", $data['barter'], "0"));

	}

	function SaveBarter(){    

        $id = $_REQUEST['id'];

        $business_id = $_REQUEST['business_id'];

        $title = $_REQUEST['title'];

        $start_date = $_REQUEST['start_date'];

        $salary_range = $_REQUEST['salary_range'];

        $description = $_REQUEST['description'];



        $data = array(

            "business_id" => $business_id,

            "title" => $title,

            "description" => $description,

            "start_date" => $start_date,

            "salary_range" => $salary_range

        );		

        if($id == "-1")

        {

            //new create

            $this->db->insert('barter_listing', $data);

        }

        else

        {

            //save

            $this->db->where('id', $id);

            $this->db->update('barter_listing', $data);

        }

        $updata = array();

        $updata['barter_listing'] = $this->db->query("select * from barter_listing where business_id = " . $business_id)->result_array();

        $data['barter'] = $this->load->view("dashboards/business_parts/barter_view", $updata, true);

		echo($this->dr->GetDR("Success", "Success", $data['barter'], "0"));

    }

	function loadBarter(){    

        $id = $_REQUEST['id'];

        $result = $this->db->query("select * from barter_listing where id = " .$id);

        echo(json_encode($result->row()));

    }

	function RemoveBarter(){    

        $id = $_REQUEST['id'];

        $business_id = $_REQUEST['business_id'];

        $this->db->where('id', $id);

        $this->db->delete('barter_listing');

        $updata = array();

        $updata['barter_listing'] = $this->db->query("select * from barter_listing where business_id = " . $business_id)->result_array();

		$data['barter'] = $this->load->view("dashboards/business_parts/barter_view", $updata, true);

        echo($this->dr->GetDR("Updated", "n/a", $data['barter'], "0"));

    }

	### Barter Part End

	/* Business user information */

	function getbusinessUserInformation(){

		$business_owner_create=$_REQUEST['business_owner_create']; //var_dump($business_owner); exit;

		$data=array();

		if ($this->ion_auth->logged_in())

        {

            $user = $this->ion_auth->user()->row();

			if($business_owner_create==0){

			$data["user_id"] = $user->id;

			$data["firstName"] = $user->first_name;

            $data["email"] = $user->email;

            $data["full_name"] = $user->first_name . " " . $user->last_name;

            

            $data["lastName"] = $user->last_name;

            $data["phone"] = $user->phone;

            $data["address"] = $user->Address;

            $data["city"] = $user->City;

            $data["username"] = $user->username;

            $data["zip1"] = $user->Zip; 

            $data["state_Code"] = $user->State_Code;

		    $data['state_list'] = $this->states->get_state_dropdown();

			}else{

				$data["user_id"] = $business_owner_create;

				$_user_info=$this->users->get_user_details($business_owner_create);

				//var_dump($_user_info);

				$data["firstName"] = $_user_info['first_name'];

				$data["email"] = $_user_info['email'];

				$data["full_name"] =$_user_info['first_name'] . " " . $_user_info['last_name'];				

				$data["lastName"] = $_user_info['last_name'];

				$data["phone"] = $_user_info['phone'];

				$data["address"] = $_user_info['Address'];

				$data["city"] = $_user_info['City'];

				$data["username"] = $_user_info['username'];

				$data["zip1"] = $_user_info['Zip']; 

				$data["state_Code"] = $_user_info['State_Code'];

				$data['state_list'] = $this->states->get_state_dropdown();

			}

            

        

        }

		$result = $this->load->view('dashboards/businessuserinformation', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	public function update_businessprofile(){

		$userid = $_REQUEST['userid'];

        $email = $_REQUEST['email'];

        $firstname = $_REQUEST['firstname'];

		$lastname = $_REQUEST['lastname'];

        $phone = $_REQUEST['phone'];

        $address = $_REQUEST['address'];

        $city = $_REQUEST['city'];

        $state = $_REQUEST['state'];

        $zip = $_REQUEST['zip'];

        

		 $userData = array(



            'email' => $email,



            'first_name' => $firstname,



            'last_name' => $lastname,



            'phone' => $phone,



            'Address' => $address,



            'City' => $city,



            'State_Code' => $state,



            'Zip' => $zip



        );

		$this->db->where('id', $userid);



        $this->db->update('users', $userData);

		

	}

	function getbusinessUserPassword(){

		$data=array();

		if ($this->ion_auth->logged_in()){

			$user = $this->ion_auth->user()->row();

			$data["user_id"] = $user->id;

		}

		$result = $this->load->view('dashboards/businessuserpassword', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));

	}

	public function UpdateBusinessPassword(){

		$userid = $_REQUEST['userid'];

		$current_pass = $_REQUEST['current_pass'];

        $new_pass = $_REQUEST['new_pass'];

        $confirm_pass = $_REQUEST['confirm_pass'];

		if($new_pass != $confirm_pass){

			$message = "Your New Password and Confirm Password are not same. For this No Changes Made!";

		}else{

			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

			$change = $this->ion_auth->change_password($identity, $current_pass, $new_pass);

		

		//var_dump($change); exit;

		if ($change)

		{

			$message = "Password Update Successful";

		}

		else

		{

			$message = "No Changes Made!";

		}

		}

		 echo($this->dr->GetDR("Update Profile", $message, "", "0"));

	}

	### ***************** Business Related Function Part End **********************************

	

	### ***************** For Super Admin(Al) part start ***************************************

	function zipadmin()

    {

    	$this->check_login_status("dashboards/zipadmin/");

    	$user = $this->ion_auth->user();

    	if (empty($user)) {

    		redirect('welcome/index', 'refresh');

    	}

    	$data=array();

    	

    	$auser = $this->ion_auth->user()->row();

    	$data['user'] = $auser;

    	if(!empty($auser)){

    		$data["email"] = $auser->email;

    		$data["firstName"] = $auser->first_name;

    		$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

    	}

    	

    	//Security

    	if(!$this->ion_auth->in_group(array( "Tier I","Tier II","Tier III")))

    	{

    		$data['hideSlider'] = true;

    		$data['content'] = $this->load->view("unauthorized", $data, true);

    		$this->load->view("default/blank", $data);

    		return;

    	}

    	

    	$data['ckeditor1'] = array(

    	

    			//ID of the textarea that will be replaced

    			'id' 	=> 	'addtemplate_content1',

    			'path'	=>	'assets/ckeditor',

    	

    			//Optional values

    			'config' => array(

    					'toolbar' 	=> 	"Full", 	//Using the Full toolbar

    					'width' 	=> 	"550px",	//Setting a custom width

    					'height' 	=> 	'100px',	//Setting a custom height

    	

    			));

    	

    	//$data['user'] = $auser;

    	$data['user_id'] = $auser->id;

    	

    	$uid = $auser->id;

    	$data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

    	$data['business_owner_new'] = $this->business->business_owner_user($uid);

    	//$data['zone_id_home'] = $id;

    	

    	$data['zone_manager'] = $this->business->get_zone_manager_owner($auser->id);

    	

    	$data['zone_id'] = '';

    	

    	//$data['user_all'] = $this->business->get_all_users();

		//var_dump($data['user_all']);

    	

    	//$data['user_claim'] = $this->business->get_all_users_claim();

		

    	

    	$data['category'] = $this->business->get_all_business_type();

    	

    	$data['zone_all'] = $this->business->get_zone_all();

    	

    	//print_r($data['user_claim']);

    	$data['ajax'] = '';

    	

    	/*$all_zone_owner = $this->business->get_all_zone_owner();

    	

    	$all_user_zone=array();

    	foreach($all_zone_owner as $key => $value)

    	{

    		if()

    		$all_user_zone[$key]=$value;

    	}*/

    	

    	$data['all_zone_owner'] = $this->business->get_all_zone_owner();

    	

    	$data['all_zone_owner'] = $this->load->view("dashboards/bulk_template_admin", $data, true);

    	

    	//$data['useradmin_table'] = $this->load->view("dashboards/useradmin_table", $data, true);

    	$data['useradmin_table']='';

    	//$data['zipadmin_table'] = $this->load->view("dashboards/zipadmin_table", $data, true);

    	//$data['zipadmin_table']='';

    	$data['category'] = $this->load->view("dashboards/categoryadmin_table", $data, true);

    	//var_dump($data);

    	$data['hideSlider'] = true;

    	$data['right_container'] = $this->load->view("dashboards/zipadmin_dashboard", $data, true);

    	$data['content'] = $this->load->view("content", $data, true);

    	$this->load->view("default/blank", $data);

    }

	

	function get_zip_codes(){

		$data=array();

		$data['user_claim'] = $this->business->get_all_users_claim();

		//$data['zipadmin_table'] = $this->load->view("dashboards/zipadmin_table", $data, true);

		$result = $this->load->view('dashboards/zipadmin_table', $data, true);

		echo($this->dr->GetDR("Save Complete","Save Completed...", $result, "0"));

	}

	

	function get_all_users(){

		$data=array();

		$data['user_all'] = $this->business->get_all_users();

		//$data['zipadmin_table'] = $this->load->view("dashboards/zipadmin_table", $data, true);

		$result = $this->load->view('dashboards/useradmin_table', $data, true);

		echo($this->dr->GetDR("Save Complete","Save Completed...", $result, "0"));

	}

	

	function revoke_zip_user()

	{

		$user_id = $_REQUEST['user_id'];

		$zip = $_REQUEST['zip'];

		 

		foreach($zip as $zip)

		{

			$data = array( 'approved' => '1');

			$this->db->where('zip', $zip);

			$this->db->where('uid', $user_id);

			$this->db->delete('tblClaimedZips');

		}

		 

		$data['user_claim'] = $this->business->get_all_users_claim();

	

		$data['ajax'] = 'ajax';

		$this->load->view("dashboards/zipadmin_table", $data);

		exit;

	}

	

	function approve_zip_user()

    {

    	$user_id = $_REQUEST['user_id'];

    	$zip = $_REQUEST['zip'];

    	

    	foreach($zip as $zip)

    	{

    		$data = array( 'approved' => '1');

    		$this->db->where('zip', $zip);

    		$this->db->where('uid', $user_id);

    		$this->db->update('tblClaimedZips', $data);

    	}

    	

    	$data['user_claim'] = $this->business->get_all_users_claim();

    	 

    	$data['ajax'] = 'ajax';

    	$this->load->view("dashboards/zipadmin_table", $data);

    	exit;

    }

	/* zipcodes part */

	function json_zipcode_approve()

    {

    	$user_id = $_REQUEST['user_id'];

    	$query = $this->db->query("SELECT t1.zip,t3.primarycity FROM tblClaimedZips as t1 join zipcode as t3 on t3.zip=t1.zip where t1.uid=$user_id and t1.approved='0'");

    	$result = $query->result_array();



    	$approve_html='';

	    	

	    	$approve_html.='<input type="hidden" name="hidden_user_id" id="hidden_user_id" value="'.$user_id.'"  /><table align="center" class="pretty" width="950px" cellpadding="0" cellspacing="0">

				<thead>

					<tr>

						<th>Approved</th>

						<th>Zip Codes</th>

						<th>Primary City</th>

					</tr>

				</thead>

				<tbody>';

	    	if($result)

	    	{

		    	foreach($result as $result)

		    	{

		    		$approve_html.='<tr>

							<td><input type="checkbox" name="zip[]" id="zip_'.$result['zip'].'" value="'.$result['zip'].'" checked="checked"  /></td>

							<td>'.$result['zip'].'</td>

							<td>'.$result['primarycity'].'</td>

						</tr>';

		    	}

	    	}

	    	else

	    	{

	    		$approve_html.='<tr><td colspan="3">No zip codes founds.</td></tr>';

	    	}

	    	

	    	$approve_html.='</tbody>

			</table>';

    	

	    if($result)

	    {

	    	$approve_html .= '<button onclick="approve_zip_user();return false;">Ok</button>';

	    }

    	echo $approve_html;?>

    	<button onclick="$('#contactOwnerDialog').dialog('close');return false;">Cancel</button><?php 

    	exit;

    }

	function zip_revoked()

    {

    	$user_id = $_REQUEST['user_id'];

    	 

    	$query = $this->db->query("SELECT t1.zip,t3.primarycity FROM tblClaimedZips as t1 join zipcode as t3 on t3.zip=t1.zip where t1.uid=$user_id");

    	$result = $query->result_array();

    

    	$approve_html='';

    

    	$approve_html.='<input type="hidden" name="hidden_user_id" id="hidden_user_id" value="'.$user_id.'"  /><table align="center" class="pretty" width="950px" cellpadding="0" cellspacing="0">

				<thead>

					<tr>

						<th>Approved</th>

						<th>Zip Codes</th>

						<th>Primary City</th>

					</tr>

				</thead>

				<tbody>';

    	if($result)

    	{

    		foreach($result as $result)

    		{

    			$approve_html.='<tr>

							<td><input type="checkbox" name="zip[]" id="zip_'.$result['zip'].'" value="'.$result['zip'].'" checked="checked"  /></td>

							<td>'.$result['zip'].'</td>

							<td>'.$result['primarycity'].'</td>

						</tr>';

    		}

    	}

    	else

    	{

    		$approve_html.='<tr><td colspan="3">No zip codes founds.</td></tr>';

    	}

    

    	$approve_html.='</tbody>

			</table>';

    	 

    	if($result)

    	{

    		$approve_html .= '<button onclick="revoke_zip_user();return false;">Ok</button>';

    	}

        	echo $approve_html;?>

        	<button onclick="$('#contactOwnerDialog').dialog('close');return false;">Cancel</button><?php 

        	exit;

    }

	

	/* users part start */

	function edit_user($user)

	{

		$data=array();

		$data['edit_user'] = $this->business->edit_user($user);

		

		$data['ajax'] = 'ajax';

		

		$this->load->view("dashboards/useradmin_table", $data);

		exit;

	}

	function cancel_user()

	{

		$data['user_all'] = $this->business->get_all_users();

		

		$data['ajax'] = 'ajax';

		

		$this->load->view("dashboards/useradmin_table", $data);

		exit;

	}

	function insert_user_group($user_id,$user_group)

	{

		$data=array();

		$data['user_id']=$user_id;

		$data['group_id']=$user_group;

		$this->db->insert('users_groups', $data);

		

		$data['user_all'] = $this->business->get_all_users();

			

		$data['ajax'] = 'ajax';

			

		$this->load->view("dashboards/useradmin_table", $data);

		exit;

	}

	function add_user_group($user=false)

	{

		$data['user_group'] = $this->business->get_all_users_group();

		

		$data['ajax'] = 'ajax';

		$data['user_id'] = $user;

		

		$this->load->view("dashboards/useradmin_table", $data);

		exit;

	}

	function save_user()

	{

		$data=array();

		$user_id = empty($_REQUEST['user_id']) ? 0 : $_REQUEST['user_id'];

		$data['username'] = $_REQUEST['username'];

		$data['email'] = $_REQUEST['email'];

		$data['first_name'] = $_REQUEST['first_name'];

		$data['last_name'] = $_REQUEST['last_name'];

		

		if($user_id)

		{

			$this->db->where('id', $user_id);

			$this->db->update('users', $data);

		}

		

		

		$data['user_all'] = $this->business->get_all_users();

		

		$data['ajax'] = 'ajax';

		

		$this->load->view("dashboards/useradmin_table", $data);

		exit;

	}

	function sendallemails(){

		$userids = empty($_REQUEST['uid']) ? 0 : $_REQUEST['uid'];

		$sub = $_REQUEST['subject'];

		$msg = str_replace("\n","<br>",$_REQUEST['message']);

		//echo $userids ;exit;

		$uid_arr=explode(',',$userids);

		//var_dump($uid_arr);exit;

		foreach($uid_arr as $uid){

			$sql_u="SELECT email FROM users WHERE id=".$uid;

			$query_u1 = $this->db->query($sql_u);	

			$useremail=$query_u1->result_array();

			if(!empty($useremail)){

				$uemailid=$useremail[0]['email']; 

				$fromemail='noreply@savingssites.com';

				$this->load->library('email');

				$this->email->clear();

				$this->email->from($fromemail);

				$this->email->subject($sub);

				$this->email->message($msg);

				$this->email->to($uemailid);

				$this->email->send();

				$to[]=$uemailid;

			}

		}

		//exit;

		$message="Email send successfully ";

		echo($this->dr->GetDR("Successfully", $message, "", "0"));

		

	}

	function sendsnapuseremails(){

		$userids = empty($_REQUEST['uid']) ? 0 : $_REQUEST['uid'];

		$sub = $_REQUEST['subject'];

		$msg = str_replace("\n","<br>",$_REQUEST['message']);

		//echo $userids ;exit;

		$uid_arr=explode(',',$userids);

		//var_dump($uid_arr);exit;

		foreach($uid_arr as $uid){

			$sql_u="SELECT email FROM users WHERE id=".$uid;

			$query_u1 = $this->db->query($sql_u);	

			$useremail=$query_u1->result_array();

			if(!empty($useremail)){

				$uemailid=$useremail[0]['email']; 

				$fromemail='noreply@savingssites.com';

				$this->load->library('email');

				$this->email->clear();

				$this->email->from($fromemail);

				$this->email->subject($sub);

				$this->email->message($msg);

				$this->email->to($uemailid);

				$this->email->send();

				$to[]=$uemailid;

			}

		}

		//exit;

		$message="Email send successfully ";

		echo($this->dr->GetDR("Successfully", $message, "", "0"));

		

	}

	function Delete_user($user=false)

	{

		$sql = "delete from users WHERE id = $user";

		$this->db->query($sql);

		

		$sql = "delete from users_groups WHERE user_id = $user";

		$this->db->query($sql);

			

		$data['user_all'] = $this->business->get_all_users();

		

		$data['ajax'] = 'ajax';

		

		$this->load->view("dashboards/useradmin_table", $data);

		exit;

	}

	function Deactivate_user($user,$status)

	{

		$data=array();

		$data['active']=$status;

		$this->db->where('id', $user);

		$this->db->update('users', $data);

		

		$data['user_all'] = $this->business->get_all_users();

			

		$data['ajax'] = 'ajax';

			

		$this->load->view("dashboards/useradmin_table", $data);

		exit;

	}

	function remove_user_group($user=false)

	{

		$sql = "delete from users_groups WHERE user_id = $user";

		$this->db->query($sql);

		

		$data['user_all'] = $this->business->get_all_users();

		 

		$data['ajax'] = 'ajax';

		 

		$this->load->view("dashboards/useradmin_table", $data);

		exit;

	}

	function get_zone_byuser($user)

	{

		$data=array();

		

		$data['zone_byuser'] = $this->business->get_zone_byuser($user);

		//var_dump($data['zone_byuser']);

			

		$data['ajax'] = 'ajax';

			

		$this->load->view("dashboards/useradmin_table", $data);

		exit;

	}

	### ***************** For Super Admin part end *********************************************

	function abc(){ 	

		$id=$_REQUEST['id'];

		$fname=$_REQUEST['fname'];

		$lname=$_REQUEST['lname'];

		$email=$_REQUEST['email']; //var_dump($id); exit;

		$bsid=$_REQUEST['busid'];

		 // this is commented for local

		$path = "http://savingssites.com";

		$login_path = "http://savingssites.com/welcome/zone_login";

		//$link="http://savingssites.com/dashboards/business/".$bsid;

		$link="http://savingssites.com/welcome/account_verification_user/".$id."/".$bsid;

		//var_dump($link);

		$message_body="<div style='border:1px solid #900; padding:5px;'>Dear ".$fname.",<br /><br />

				Thank you for your SavingsSites registration.<br/><br/>									

				

				To complete your account verification, simple click <a href='".$link."'> here </a> .<br/><br/>

				

									

				You can login into your account and change this information at your convenience.<br /><br />

				We are constantly trying to improve the application and will notify you of future updates as and when they are available. If you have any queries in the meantime then please email us at <a href='mailto:support@savingssites.com'>support@savingssites.com</a> and we will get back to you promptly.<br /><br />

				Best Regards,<br />

				Savings Sites Support." ;

		

		$fromemail='noreply@savingssites.com';

		$this->load->library('email');

		$template_subject="Savings Sites Account verification";

		$this->email->clear();

		$this->email->from($fromemail);

		$this->email->subject($template_subject);

		$this->email->message($message_body);

		if($email!='')

		{

			$this->email->to($email);

			$this->email->send();

			$to[]=$email;

		}

		// end

		$data = array('status' => rand());

        $this->db->where('id', $id);

        $this->db->update('users', $data);

		$result=1;

		echo $result;

		

	}

	function getusername($uid=false)

	{

			//var_dump($zip); var_dump($zone);

			if($uid){

				$sql="select username from users where id=".$uid;

        		$query = $this->db->query($sql);

				$result=$query->result_array();

				$username=$result[0]['username'];

				echo($this->dr->GetDR("","", $username, "0"));

				//echo $result;	

			}

	}

	function get_baner($cssvalue){

		//$cssvalue=$_REQUEST['cssvalue'];

		//$data['org_announcement_list'] = $this->announcements->get_org_announcements_for_zonepage($orgid);

		//var_dump($data['org_announcement_list']);

		$data['css_value']=$cssvalue;

		var_dump($data['css_value']);

		$this->load->view('show_baner', $data);

		//var_dump($result);

		//echo($this->dr->GetDR("","", $result, "0"));

	}

	function get_announcements_by_ogr(){

		$orgid=!empty($_REQUEST['orgid']) ? $_REQUEST['orgid'] : '';

		$data['org_announcement_list'] = $this->announcements->get_org_announcements_for_zonepage($orgid);

		//var_dump($data['org_announcement_list']);

		$result = $this->load->view('dashboards/announcement_parts/org_announcement', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function get_ogr_for_snap(){

		$orgid=!empty($_REQUEST['orgid']) ? $_REQUEST['orgid'] : '';

		$data['org_announcement_list'] = $this->announcements->get_org_announcements_for_zonepage($orgid);

		//var_dump($data['org_announcement_list']);

		$result = $this->load->view('dashboards/announcement_parts/snap_ogr', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	

	/*function get_announcements_by_ogr(){

		$orgid=!empty($_REQUEST['orgtypeid']) ? $_REQUEST['orgtypeid'] : '';

		$data['org_announcement_list'] = $this->announcements->get_org_announcements_for_zonepage($orgid);

		//var_dump($data['org_announcement_list']);

		$result = $this->load->view('dashboards/announcement_parts/org_announcement', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}*/

	function presentation_on_demand($adid=false){

		//$presentation_on_demand=$_REQUEST['presentation_on_demand'];

		//var_dump($adid); exit;

		$sql="select id,docs_pdf from ads where id=".$adid;

		$query = $this->db->query($sql);

		$result= $query->result_array();

		//var_dump($result);

		$_docs_pdf=$result[0]['docs_pdf'];

		var_dump($_docs_pdf);

		//$data =file_get_contents("uploads/docs/".$_docs_pdf);

		$name = $_docs_pdf;

		force_download($name, $data);

	}

	/* market materials part start*/

	function save_market_materials(){

		$_mm_display_name=$_REQUEST['mm_display_name'];

		$_mm_desc=$_REQUEST['mm_desc'];

		$upload_file=$_REQUEST['mm_file'];

		$upload_file_exp=explode('~!~',$upload_file);

		$name=$upload_file_exp[2];

		$zoneid=$upload_file_exp[0];		

		$timestamp=$upload_file_exp[1];		

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$data=array();

		$data = array(

			'name' => $name,

            'zoneid' => $zoneid,

            'createdby' => $uid,

            'timestamp' => $timestamp,

            'status' => 1,

			'display_name' => $_mm_display_name,

            'description' => $_mm_desc

        );

        $this->db->insert('marketing_materials', $data);

		$result=$zoneid;

		echo($this->dr->GetDR("","", $result, "0")); 

	}

	function market_materials_zone_dropdown(){

		$zoneid=$_REQUEST['zoneid'];

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;} 

		$data = array();

		$data['zoneid'] = $zoneid;

		$data['mm_my_zones']=$this->sales_zone->mm_zone();

		//var_dump($data['mm_my_zones']);

		$result = $this->load->view('dashboards/zone_parts/market_materials_dropdown_display', $data, true);		

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function view_all_mm(){

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$data = array();

		$data['uid']=$uid;

		$data['market_materials']=$this->sales_zone->get_all_mm();

		//var_dump($data['market_materials']);

		$result = $this->load->view('dashboards/zone_parts/market_materials_display', $data, true);		

		echo($this->dr->GetDR("","", $result, "0"));

		

	}

	function market_materials_display(){

		$zone_option=$_REQUEST['zone_option'];

		$zoneid=$_REQUEST['zoneid'];

		//var_dump($zone_option); var_dump($zoneid);

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$data = array();

		$data['zoneid'] = $zoneid;

		$data['zone_option'] = $zone_option;

		$data['market_materials']=$this->sales_zone->get_market_materials($zone_option,$uid);

		//var_dump($data['market_materials']);

		$result = $this->load->view('dashboards/zone_parts/market_materials_display', $data, true);		

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function delete_mm(){

		$id=$_REQUEST['id'];

		$zoneid=$_REQUEST['zoneid'];

		$zone_option=$_REQUEST['zone_option'];

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$data = array();

		$data['zoneid'] = $zoneid;

		$data['zone_option'] = $zone_option;

		$data['delete_market_materials']=$this->sales_zone->delete_market_materials($id);

		$data['market_materials']=$this->sales_zone->get_market_materials($zone_option,$uid);

		$result = $this->load->view('dashboards/zone_parts/market_materials_display', $data, true);		

		echo($this->dr->GetDR("","", $result, "0"));

	}

	/* market materials part end*/

	function check_org_username(){

		$data=array();

		$data['zoneid'] = $_REQUEST['zoneid']; $data['org_username'] = $_REQUEST['org_username']; $data['org_id'] = $_REQUEST['org_id'];

		$result = $this->sales_zone->check_org_username($_REQUEST['zoneid'],$_REQUEST['org_username']);

		//var_dump($result);

		//$result='';

		echo($this->dr->GetDR("Title", "Message", $result, 0));

	}

}