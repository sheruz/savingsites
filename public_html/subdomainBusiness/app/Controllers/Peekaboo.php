<?php

require_once(dirname(__FILE__)."/welcome.php"); // the controller route.



class Peekaboo extends CI_Controller{

	 public function __construct(){    

        parent::__construct();

        $this->load->library('ion_auth');

        $this->load->library('session');

        $this->load->library('form_validation');

		$this->load->library('pagination');

        

		$this->load->helper('url');

        $this->load->helper('ckeditor');

        $this->load->helper("time_helper");

        $this->load->helper('cookie');

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

		$this->load->model("peekaboo/Peekaboo_model", "peekaboo");

		

		$this->load->config('security', TRUE);

        $this->load->database();

    }

	### start

	public function index(){

	}

	function pboo_current_location(){

		$this->load->library('session');

		$latitude=!empty($_REQUEST['latitude']) ? $_REQUEST['latitude'] : '0';

		$longitude=!empty($_REQUEST['longitude']) ? $_REQUEST['longitude'] : '0';

		$newsessiondata = array('latitude'=>$latitude,'longitude'=>$longitude);

		$this->session->set_userdata('current_location_sessiondata',$newsessiondata);

		echo 1;

	}

	/*function pboo_database_connection(){

		$hostname = "localhost";

       	$username = "root";

        $password = "";

		$dbh2 = mysql_connect($hostname, $username, $password, true); 

		$con= mysql_select_db('peekabooauctions', $dbh2);

		if($con){

			echo 'success'; 

		}

	}*/

	function pboo_login(){

		var_dump(5);exit;

		/*print_r($this->session->all_userdata());*/

		/*$this->pboo_database_connection();		

		$data = array();

		$data["user_favorites_ads_ids"] = $this->peekaboo->get_favorites_ads_ids($auser->id, 'array');				

		$this->load->view('peekaboo/show_pboo_search_results', $data);*/

	}

	function pboo_search(){//echo "<pre>"; var_dump($_REQUEST);exit;

		

		//print_r($this->session->all_userdata());

		$session_arr=$this->session->userdata('current_location_sessiondata');

		//$latitude=!empty($session_arr['latitude']) ? $session_arr['latitude'] : 0;

		//$longitude=!empty($session_arr['longitude']) ? $session_arr['longitude'] : 0;

		$limit=!empty($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;

		//$user_id=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;

		//var_dump($latitude);

		$active_peekaboo_auction=!empty($_REQUEST['active_peekaboo_auction']) ? $_REQUEST['active_peekaboo_auction'] : ''; 

		$active_gift_zone=!empty($_REQUEST['active_gift_zone']) ? $_REQUEST['active_gift_zone'] : '';

		$peekaboo_category=!empty($_REQUEST['peekaboo_category']) ? $_REQUEST['peekaboo_category'] : '';

		$selectPrductSort=!empty($_REQUEST['selectPrductSort']) ? $_REQUEST['selectPrductSort'] : '';	

		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

		$orderby='';$orderway='';

		if(!empty($selectPrductSort)){

			$prductsortarray=explode(':',$selectPrductSort);//var_dump($prductsortarray);exit;

			$orderby=$prductsortarray[0];

			$orderway=$prductsortarray[1];

		}

		

		//$this->pboo_database_connection();		

		$data = array();

		//$data["pboo_search"] = $this->peekaboo->get_pboo_search($limit,$orderby,$orderway,$user_id,$distance,$latitude,$longitude); 

		$data["pboo_search"] = $this->peekaboo->get_pboo_search($limit,$orderby,$orderway,$active_gift_zone,$peekaboo_category,$selectPrductSort,$active_peekaboo_auction,$zoneid); 

		//var_dump($data["pboo_search"]);	

			

		//$view = $this->load->view('peekaboo/show_pboo_search_results', $data);

		//var_dump($view);

		echo json_encode($data["pboo_search"]);

	}

	
 
 
	

	### common part start

	function add_new_group(){

		$data=array();

		$data['zoneid'] = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$data['createdby_id'] = !empty($_REQUEST['createdby_id'])? $_REQUEST['createdby_id'] : 0 ;

		$data['createdby_type'] = !empty($_REQUEST['createdby_type'])? $_REQUEST['createdby_type'] : 0 ;

		$result = $this->load->view('emailnotice/add_new_group', $data, true);

		echo($this->dr->GetDR("Save Complete","Save Completed...", $result, "0"));

	}

	function save_group(){

		$data=array();

		$zoneid= !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;		

		$group_id = !empty($_REQUEST['group_id']) ? $_REQUEST['group_id'] : 0; 

    	$data['name'] = !empty($_REQUEST['group_name']) ? $_REQUEST['group_name'] : '';

		$data['description'] = !empty($_REQUEST['group_desc']) ? $_REQUEST['group_desc'] : '';

		$data['createdby_id'] = !empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;

		$data['createdby_type'] = !empty($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : '' ;

		$data['assign_type'] = !empty($_REQUEST['assign_type']) ? $_REQUEST['assign_type'] : 0 ;

		$data['status'] = !empty($_REQUEST['status']) ? $_REQUEST['status'] : 0 ;

		if(!empty($data)){			

			$is_save_group=$this->email_notice->save_group($data,$group_id,$zoneid); 			

			if(!empty($is_save_group) && $is_save_group=='update'){			

				$message="Group is updated successfully!";			

			}else if($is_save_group=='insert'){			

				$message="New Group is Successfully created!";

			}else{

				echo 'Not succesfully done';

			}

		}else{

			$message="Temporary Problem Occured! Please Logout and then do this again.";

			$is_save_group='';

		}

		echo($this->dr->GetDR("Save Successful", $message,$is_save_group, "0"));

	}

	function view_interest_group(){

		$data=array();

		$data['zoneid']=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;		

		$data['createdby_id']=isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;

		$data['createdby_type']=isset($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0 ;

		$result = $this->load->view('emailnotice/view_interest_group', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));



	}

	function display_ig(){

		$data=array();

		$data['zoneid']=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;		

		$data['createdby_id']=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['ig_type']=!empty($_REQUEST['ig_type']) ? $_REQUEST['ig_type'] : 0 ;

		$data['createdby_type']=!empty($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0;				

		$data['display_ig']=$this->email_notice->display_ig($data['zoneid'],$data['createdby_id'],$data['ig_type'],$data['createdby_type']);

		//var_dump($data['view_group_display_option']);

		$result = $this->load->view('emailnotice/display_ig', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));



	}

	function edit_group(){

		$data['group_id'] = !empty($_REQUEST['group_id']) ? $_REQUEST['group_id'] : 0 ;

		$data['zoneid'] = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$data['createdby_id'] = !empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;

		$data['createdby_type'] = !empty($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0 ;

		//var_dump($data);

		$data['group_details']	= $this->email_notice->edit_group($data['group_id'],$data['zoneid']);							      	//var_dump($data['group_details']); exit;

		$result = $this->load->view('emailnotice/edit_group_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	### common part ends

	### Zone part start

	function view_group(){

		$data=array();

		$data['zoneid']=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;		

		$data['createdby_id']=isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;

		$data['createdby_type']=isset($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0 ;	

		$data['view_group']	= $this->email_notice->view_group($data['zoneid']); //var_dump($data['view_group']); exit;	

		$result = $this->load->view('emailnotice/view_group_display', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	/*function add_new_group(){

		$data=array();

		$data['zoneid']=$_REQUEST['zoneid'];

				

		$result = $this->load->view('emailnotice/new_group_add', $data, true);

		echo($this->dr->GetDR("Save Complete","Save Completed...", $result, "0"));

	}*/

	/*function edit_group(){

		$data['group_id'] = $_REQUEST['id'];

		isset($_REQUEST['busid']) ? $data['busid'] = $_REQUEST['busid'] : $data['busid'] = '';

    	isset($_REQUEST['zoneid']) ? $data['zoneid'] = $_REQUEST['zoneid'] : $data['zoneid']='';

		$data['group_details']	= $this->email_notice->edit_group($data['group_id'],$data['zoneid']);							      	//var_dump($data['group_details']); exit;

		$result = $this->load->view('emailnotice/edit_group_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}*/

	/*function save_group(){

		$zone_id = $_REQUEST['zone_id']; 

		$group_id = $_REQUEST['group_id']; 

    	$group_name = $_REQUEST['group_name']; 

		$group_desc = $_REQUEST['group_desc']; 

		$is_inserted=$this->email_notice->save_group($zone_id,$group_id,$group_name,$group_desc,'zone'); 

		if($is_inserted!=0){

			if($group_id==-1)

				$message="New Group is Successfully created.";

			else

				$message="Interest Group is Successfully updated.";

		}else

			$message="New Group is not created.";

		echo($this->dr->GetDR("Save Successful", $message,"", "0"));

	}*/

	function delete_group(){

		$id = $_REQUEST['id']; //var_dump($id); exit;

		$is_delete=$this->email_notice->delete_group($id,'zone'); //var_dump($is_delete);

		echo($this->dr->GetDR("","",$id, "0"));

	}

	function view_menu_group_business_by_zone(){

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$data=array();

		$data['zoneid']=$_REQUEST['zoneid'];

		$data['advertising_businesses_data'] = $this->business->get_businesses_who_have_advertised($data['zoneid'],$uid);			

        $data['advertising_businesses'] = $data['advertising_businesses_data'][0];

        $data['advertising_businesses_ids'] = $data['advertising_businesses_data'][1];

		$data_all_bus_ids=explode(',',$data['advertising_businesses_ids']);

		$data['data_all_bus_ids']=count($data_all_bus_ids);

		$result = $this->load->view('emailnotice/group_display_menu_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function view_groups_business_by_zone(){

		$data=array();

		$data['zoneid'] = $_REQUEST['zoneid'];

    	$bus_id = $_REQUEST['busid'];

		$type = $_REQUEST['ig_type']; //var_dump($data['zoneid']); var_dump($bus_id); var_dump($type);		

		$data['display_group_business_by_zone']=$this->email_notice->display_group_business_by_zone($data['zoneid'],$bus_id,$type);

		//var_dump($data['display_group_business_by_zone']);

		$result = $this->load->view('emailnotice/group_display_content_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0")); 

	}

	function update_groups_business_by_zone(){

		$id=$_REQUEST['id'];

		$status=$_REQUEST['status'];

		$result = $this->email_notice->update_groups_business_by_zone($id,$status);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	### Zone part end

	### Business Part Start 

	/*function add_new_group_by_business(){

		$data=array();

		$data['zoneid']=$_REQUEST['zoneid'];		

		$data['busid']=$_REQUEST['busid'];

		$result = $this->load->view('emailnotice/new_group_add_by_business', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}*/

	function save_group_by_business(){

		isset($_REQUEST['bus_id']) ? $bus_id = $_REQUEST['bus_id'] : $bus_id = '';

		$group_id = $_REQUEST['group_id']; 

    	$group_name = $_REQUEST['group_name'];

		$group_desc = $_REQUEST['group_desc']; 

		//$is_inserted=$this->email_notice->save_group($bus_id,$group_name,'business');

		$is_inserted=$this->email_notice->save_group($bus_id,$group_id,$group_name,$group_desc,'business');  

		if($is_inserted!=0){

			if($group_id==-1)

				$message="New Group is Successfully created.";

			else

				$message="Interest Group is Successfully updated.";

		}else

			$message="New Group is not created.";

		echo($this->dr->GetDR("Save Successful", $message,"", "0"));

	}

	/*function view_group_by_business_option(){

		$data=array();

		$data['zoneid']=$_REQUEST['zoneid'];		

		$data['busid']=$_REQUEST['busid'];		

		$result = $this->load->view('emailnotice/group_display_menu_business', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}*/

	function view_groups_by_business(){

		$data=array();

		$data['zoneid']=$_REQUEST['zoneid'];		

		$data['busid']=$_REQUEST['busid'];

		$data['ig_type']=$_REQUEST['ig_type']; //var_dump($data);

		$data['view_group_display_by_business']=$this->email_notice->view_group_display_by_business($_REQUEST['zoneid'],$data['busid'],$data['ig_type']);//var_dump($data['view_group_display_by_business']);

		$result = $this->load->view('emailnotice/view_group_display_business', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function group_visibility_menu(){

		$data=array();

		$data['zoneid']=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;		

		$data['createdby_id']=isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;

		$data['createdby_type']=isset($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0 ;

		$result = $this->load->view('emailnotice/group_visibility_menu', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function group_visibility(){		

		$data=array();

		$data['zoneid']=$_REQUEST['zoneid'];		

		$data['createdby_id']=$_REQUEST['createdby_id']; //var_dump($data);

		$data['createdby_type']=$_REQUEST['createdby_type'];

		$data['option']=$_REQUEST['option'];

		$data['group_visibility_by_business']=$this->email_notice->group_visibility($_REQUEST['zoneid'],$data['createdby_id'],$data['createdby_type'],$data['option']);

		//var_dump($data['group_visibility_by_business']); exit; 

		$data['count_group_visibility_by_business'] =count($data['group_visibility_by_business']);

		$data['display_categories']=$this->email_notice->get_display_group_for_zone($_REQUEST['zoneid']);	        

		//var_dump($data['group_visibility_by_business']); var_dump($data['display_categories']); exit;

		$result = $this->load->view('emailnotice/group_visibility', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function save_group_display(){

		$groupid=$_REQUEST['groupid'];

		$zoneid=$_REQUEST['zoneid'];

		$createdby_id=$_REQUEST['createdby_id'];

		$createdby_type=$_REQUEST['createdby_type'];

		$option=(!empty($_REQUEST['option'])) ? $_REQUEST['option']: 1;

		$add_cat_to_zone=$this->email_notice->add_group_display($groupid,$zoneid,$createdby_id,$createdby_type,$option);

		

	}

	function active_group_display(){

		$data=array();

		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;

		$data['createdby_id']=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['createdby_type']=!empty($_REQUEST['type']) ? $_REQUEST['type'] : 0;

		$data['user_id']=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;		

		$data['active_group_display']=$this->email_notice->active_group_display($data['zone_id'],$data['createdby_id'],$data['createdby_type'],$data['user_id']); 

		$data['status']=$this->email_notice->snap_status_check($data['zone_id'],$data['createdby_id'],$data['createdby_type'],$data['user_id']);		

		//echo '<pre>';print_r($data);

		echo json_encode($data);

	}

	function check_ig_display(){

		$data=array();		

		$data['user_id']=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;

		$data['createdby_id']=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0; 

		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;	

		$data['type']=!empty($_REQUEST['type']) ? $_REQUEST['type'] : 0;	

		$data['check_ig']=$this->email_notice->check_ig_display($data['user_id'],$data['createdby_id'],$data['zone_id'],$data['type']);

		echo json_encode($data['check_ig']);

	}

	function user_ig_insert(){ //echo 1; exit;

		$data=array();		

		$data['user_id']=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;

		$data['createdby_id']=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;

		$data['type']=!empty($_REQUEST['type']) ? $_REQUEST['type'] : 0;

		$data['status']=$_REQUEST['status'];

		//var_dump($data); exit;

		isset($_REQUEST['iggroup']) ? $data['iggroup']=$_REQUEST['iggroup'] : $data['iggroup']='';

		

		!empty($data['iggroup']) ? $interest_group=implode('@#$',$data['iggroup']) : $interest_group='';

		

		$this->email_notice->user_group_interest_insert($data['user_id'],$interest_group,$data['zone_id'],$data['createdby_id'],$data['type']);

		$this->email_notice->user_status_update($data['user_id'],$data['zone_id'],$data['createdby_id'],$data['type'],$data['status']);	

		

	}	

	

	### Business Part End

	### Org part start

	function view_menu_group_org_by_zone(){		

		$data=array();

		$data['zoneid']=$_REQUEST['zoneid'];

		$data['org_zone']=$this->email_notice->get_all_org_againest_zone($data['zoneid']); //var_dump($data['org_zone']);

		$result = $this->load->view('emailnotice/group_display_menu_org_by_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function view_groups_org_by_zone(){

		$data=array();

		$data['zoneid'] = $_REQUEST['zoneid'];

    	$org_id = $_REQUEST['orgid'];

		$type = $_REQUEST['ig_type']; //var_dump($data['zoneid']); var_dump($bus_id); var_dump($type);		

		$data['display_group_business_by_zone']=$this->email_notice->display_group_org_by_zone($data['zoneid'],$org_id,$type);

		//var_dump($data['display_group_business_by_zone']);

		$result = $this->load->view('emailnotice/group_display_content_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0")); 

	}

	

	//++++++++++++++++++++++++++++++++++++++++++++EMAIL SIGN UP SECTION STARTED++++++++++++++++++++++++++++++++++++++++++++//

	function emailnoticesignform(){

		isset($_REQUEST['createdby_id']) ? $data['createdby_id']=$_REQUEST['createdby_id'] : $data['createdby_id']='';				

		isset($_REQUEST['zone_id']) ? $data['zone_id']=$_REQUEST['zone_id'] : $data['zone_id']='';

		isset($_REQUEST['type']) ? $data['type']=$_REQUEST['type'] : $data['type']='';	

		isset($_REQUEST['ad_id']) ? $data['ad_id']=$_REQUEST['ad_id'] : $data['ad_id']='';	

		isset($_REQUEST['offer_type']) ? $data['offer_type']=$_REQUEST['offer_type'] : $data['offer_type']='';		

		//$data['interestedgroup']=$this->email_notice->active_group_display($data['zone_id'],$data['createdby_id'],$data['type']);

		$result = $this->load->view("emailnotice/emailnoticesignup",$data, true);

        echo($this->dr->GetDR("Save Complete", "Save Completed...",$result, "0"));		

		//$this->load->view('emailnotice/emailnoticesignup');

	}

	function emailnoticeinsertdata(){

		//echo '<pre>';print_r($_REQUEST);exit;

		isset($_REQUEST['first_name']) ? $first_name=$_REQUEST['first_name'] : $first_name='';

		isset($_REQUEST['last_name']) ? $last_name=$_REQUEST['last_name'] : $last_name='';

		isset($_REQUEST['street']) ? $street=$_REQUEST['street'] : $street='';

		isset($_REQUEST['city']) ? $city=$_REQUEST['city'] : $city='';

		isset($_REQUEST['state']) ? $state=$_REQUEST['state'] : $state='';

		isset($_REQUEST['zipcode']) ? $zipcode=$_REQUEST['zipcode'] : $zipcode='';

		isset($_REQUEST['phone']) ? $phone=$_REQUEST['phone'] : $phone='';

		isset($_REQUEST['cellphone1']) ? $cellphone1=$_REQUEST['cellphone1'] : $cellphone1='';

		isset($_REQUEST['cellphone2']) ? $cellphone2=$_REQUEST['cellphone2'] : $cellphone2='';

		isset($_REQUEST['username']) ? $username=$_REQUEST['username'] : $username='';

		isset($_REQUEST['emailnotice_email']) ? $email=$_REQUEST['emailnotice_email'] : $email='';

		isset($_REQUEST['password']) ? $password=$_REQUEST['password'] : $password='';

		isset($_REQUEST['group']) ? $group=$_REQUEST['group'] : $group='';

		isset($_REQUEST['createdby_id']) ? $createdby_id=$_REQUEST['createdby_id'] : $createdby_id='';

		isset($_REQUEST['zone_id']) ? $zone_id=$_REQUEST['zone_id'] : $zone_id='';

		isset($_REQUEST['type']) ? $type=$_REQUEST['type'] : $type='';

		isset($_REQUEST['offer_type']) ? $offer_type=$_REQUEST['offer_type'] : $offer_type='';

		//echo $interested_group;exit;

		$additional_data = array('first_name'=>$first_name,'last_name'=>$last_name,'City'=>$city,'phone'=>$phone,'Zip'=>$zipcode,'Address'=>$state."<br/>".$cellphone1."<br/>".$cellphone2);

		$accountGroups = array();

		$accountGroups[] = "10";

		$data['emailnoticeuser']=$this->ion_auth->register($email, $password, $email, $additional_data,$accountGroups);		

		$remember='';

		if ($this->ion_auth->login($email, $password, $remember)){

			$session_normal_user_in_zone = array('sesuserzone'=>$zone_id,'sesusertype'=>'resident_user');                   		

        	$this->session->set_userdata('session_normal_user_in_zone',$session_normal_user_in_zone);

			$usersession_data = $this->session->userdata('session_normal_user_in_zone');

			//$auser = $this->ion_auth->user()->row();

            //$user_id = $auser->id; echo $user_id; 

		}

		$par_for_ig=array('user_id'=>$data['emailnoticeuser'],'createdby_id'=>$createdby_id,'zone_id'=>$zone_id,'type'=>$type,'offer_type'=>$offer_type);

		echo($this->dr->GetDR("","", $par_for_ig, "0")); 

		/*if(!empty($group))

		{

			$interested_group=implode('@#$',$group);

			$this->email_notice->user_group_interest_insert($data['emailnoticeuser'],$interested_group,$zone_id,$createdby_id,$type);

		}*/

		//echo 1;

	}

	//++++++++++++++++++++++++++++++++++++++++++++EMAIL SIGN UP SECTION ENDED++++++++++++++++++++++++++++++++++++++++++++//

	### Email notice from business dashboard part start 

	function create_email_notice(){

		$data=array();

		$data['createdby_id']=$_REQUEST['createdby_id'];		

		$data['zoneid']=$_REQUEST['zoneid']; 

		$data['type']=$_REQUEST['type']; 

		$result = $this->load->view('emailnotice/create_email_notice', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function save_email_notice(){

		$data=array();

		$data['zoneid'] = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;   

		$data['createdby_id'] = !empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['notice_name'] = !empty($_REQUEST['notice_name']) ? $_REQUEST['notice_name'] : 0;		 	

		$data['notice_details'] = !empty($_REQUEST['notice_details']) ? $_REQUEST['notice_details'] : 0;

		$data['createdby_type'] = !empty($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0;		

		$data['notice_id'] = !empty($_REQUEST['notice_id']) ? $_REQUEST['notice_id'] : $notice_id='';

		$save_email_notice=$this->email_notice->save_email_notice($data['zoneid'],$data['createdby_id'],$data['notice_name'],$data['notice_details'],$data['createdby_type'],$data['notice_id']);

		if(!empty($save_email_notice) && $save_email_notice=='update')

		{

			$message="Notice is updated successfully!";

		}

		else if($save_email_notice=='insert')

		{

			$message="New Notice is Successfully created!";

		}

		else

		{

			echo 'Not succesfully done';

		}

		echo($this->dr->GetDR("Save Successful", $message,$save_email_notice, "0"));

	}

	function view_email_notice(){

		$data=array();

		$data['createdby_id']=$_REQUEST['createdby_id'];		

		$data['zoneid']=$_REQUEST['zoneid'];

		$data['createdby_type']=$_REQUEST['createdby_type'];

		$result = $this->load->view('emailnotice/view_email_notice', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function display_all_email_notice(){

		$data=array();

		$data['zoneid']=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;		

		$data['createdby_id']=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['createdby_type']=!empty($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0;

		$data['show_en_status_type']=!empty($_REQUEST['show_en_status_type'])? $_REQUEST['show_en_status_type'] : 0; //var_dump($data);

		$data['display_all_email_notice']=$this->email_notice->display_all_email_notice($_REQUEST['zoneid'],$data['createdby_id'],$data['createdby_type'],$data['show_en_status_type']);        //var_dump($data['view_en_by_business']);

		$result = $this->load->view('emailnotice/display_all_email_notice.php', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	

	function view_send_notice(){

		$data=array();

		$data['zoneid']=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;

		$data['createdby_id']=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['createdby_type']=!empty($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0;

		$data['ig_group']=$this->email_notice->active_subscribed_group_display($data['zoneid'],$data['createdby_id'],$data['createdby_type']);

		$data['all_bus_notice']=$this->email_notice->all_notices($data['zoneid'],$data['createdby_id'],$data['createdby_type']);

		//echo '<pre>'; print_r($data['all_bus_notice']);exit;

		$result=$this->load->view('emailnotice/view_send_notice',$data,true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function show_email_box(){	

		$data=array();

		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;

		$data['createdby_id']=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['createdby_type']=!empty($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0;		

		$data['selectNotce']=!empty($_REQUEST['selectNotce']) ? $_REQUEST['selectNotce'] : '';

		$data['iggroup']=!empty($_REQUEST['iggroup']) ? $_REQUEST['iggroup'] : '';

		$data['notice']=$this->email_notice->get_notice($data['zone_id'],$data['createdby_id'],$data['selectNotce']);

		$data['iggroupemail']=$this->email_notice->get_ig_email($data['zone_id'],$data['createdby_id'],$data['selectNotce'],$data['iggroup'],$data['createdby_type']);

		$data['iggroupname']=$this->email_notice->get_ig_group_name($data['zone_id'],$data['createdby_id'],$data['selectNotce'],$data['iggroup'],$data['createdby_type']);		

		//echo '<pre>'; print_r($data['groupnotice']);

		$result=$this->load->view('emailnotice/show_email_box',$data,true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function send_mail_to_all_group(){

		$data=array();

		$data['zone_id']=$_REQUEST['zone_id'];

		$data['createdby_id']=$_REQUEST['createdby_id'];

		$data['mailtosent']=$_REQUEST['mailtosent'];

		$data['subject']=$_REQUEST['subject'];

		$data['detail']=$_REQUEST['detail'];

		$data['all_groupname']=$_REQUEST['all_groupname'];

		$data['all_ig_id']=$_REQUEST['all_ig_id'];

		isset($_REQUEST['createdby_type']) ? $data['createdby_type']=$_REQUEST['createdby_type'] : $data['createdby_type']='';

		$result=$this->email_notice->send_mail_to_all_group($data['zone_id'],$data['createdby_id'],$data['mailtosent'],$data['subject'],$data['detail'],$data['createdby_type'],$data['all_groupname'],$data['all_ig_id']);	

		echo($this->dr->GetDR("","", $result, "0"));	

	}	

	function edit_en(){

		$data['notice_id'] = $_REQUEST['notice_id'];

		$data['zoneid'] = $_REQUEST['zoneid'];

		$data['createdby_id'] = $_REQUEST['createdby_id'];

		$data['createdby_type'] = $_REQUEST['createdby_type'];

		$data['en_details']	= $this->email_notice->edit_en($data['notice_id'],$data['zoneid'],$data['createdby_id'],$data['createdby_type']);

		//var_dump($data['group_details']); exit;

		$result = $this->load->view('emailnotice/edit_en', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function delete_en(){

		$id = $_REQUEST['id']; //var_dump($id); exit;

		$is_delete=$this->email_notice->delete_en($id); //var_dump($is_delete);

		echo($this->dr->GetDR("","",$id, "0"));

	}

	function view_email_notice_history(){

		$data=array();

		$data['createdby_id']=$_REQUEST['createdby_id'];

		$data['zoneid']=$_REQUEST['zoneid'];

		$data['createdby_type']=$_REQUEST['createdby_type'];

		$data['email_history']=$this->email_notice->view_email_notice_history($data['createdby_id'],$data['zoneid'],$data['createdby_type']);

		$result=$this->load->view('emailnotice/view_email_notice_history',$data,true);

		echo($this->dr->GetDR("","",$result,"0"));

	}

	function delete_history(){

		$id = $_REQUEST['id']; //var_dump($id); exit;

		$is_delete=$this->email_notice->delete_history($id); //var_dump($is_delete);

		echo($this->dr->GetDR("","",$id, "0"));

	}

	

	function view_detail_email_history(){

		$data=array();

		$data['id']= $_REQUEST['id']; //var_dump($id); exit;

		$data['detail_history']=$this->email_notice->view_detail_email_history($data['id']); //var_dump($is_delete);

		$result=$this->load->view('emailnotice/view_detail_email_history',$data,true);

		echo($this->dr->GetDR("","",$result, "0"));

		

		}

	

}



?>