<?php
namespace App\Controllers;
use App\Models\IonAuthModel;
use App\Models\emailnotice\Email_notice;
use App\Models\emailnotice\Snap_email_notification;
use App\Models\admin\Sales_zone;
use App\Libraries\IonAuth;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Emailnotice extends BaseController{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ion_auth = $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->email_notice = $this->Email_notice = new Email_notice();
        $this->SalesZone = new Sales_zone();
        $this->Snap_email_notification = new Snap_email_notification();
        $this->CommonController = new CommonController();
   	}




	### start

	public function index(){

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

	public function save_group(){ 
		$data=array();
		$zoneid= isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;		
		$group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : 0; 
		$data['name'] = isset($_REQUEST['group_name']) ? $_REQUEST['group_name'] : '';
		$data['description'] = isset($_REQUEST['group_desc']) ? $_REQUEST['group_desc'] : '';
		$data['createdby_id'] = isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;
		$data['createdby_type'] = isset($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : '' ;
		$data['assign_type'] = isset($_REQUEST['assign_type']) ? $_REQUEST['assign_type'] : 0 ;
		$data['status'] = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0 ;
		if(!empty($data)){			
			$is_save_group=$this->email_notice->save_group($data,$group_id,$zoneid); 			
			if(!empty($is_save_group) && $is_save_group=='update'){			
				$message=['type'=>'success','msg'=>'Group is updated successfully!'];			
			}else if($is_save_group=='insert'){			
				$message=['type'=>'success','msg'=>'New Group is Successfully created!'];			
			}else{
				$message=['type'=>'warning','msg'=>'Something Went Wrong'];			
			}
		}else{
			$message=['type'=>'warning','msg'=>'Temporary Problem Occured! Please Logout and then do this again.'];			
		}
		echo json_encode($message);
	}

	function view_interest_group(){

		$data=array();

		$data['zoneid']=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;		

		$data['createdby_id']=isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;

		$data['createdby_type']=isset($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0 ;

		$result = $this->load->view('emailnotice/view_interest_group', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));



	}

	public function display_ig(){  
		$zoneid = isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;		
		$createdby_id = isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;
		$ig_type = isset($_REQUEST['ig_type']) ? $_REQUEST['ig_type'] : 0 ;
		$createdby_type = isset($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0;	
		$data = $this->email_notice->display_ig($zoneid,$createdby_id,$ig_type,$createdby_type);
		echo json_encode($data);
	}

	public function edit_group(){
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
	
	public function delete_group(){
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0 ;
		$is_delete=$this->email_notice->delete_group($id,'zone');
		echo json_encode(['msg'=>'Deleted Group Successfully','type'=>'success']);
	}

	function view_menu_group_business_by_zone(){

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$data=array();

		$data['zoneid']=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

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

		$data['zoneid']=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

    	$bus_id = isset($_REQUEST['busid']) ? $_REQUEST['busid'] : 0;

		$type = isset($_REQUEST['ig_type']) ? $_REQUEST['ig_type'] : 0 ;

			

		$data['display_group_business_by_zone']=$this->email_notice->display_group_business_by_zone($data['zoneid'],$bus_id,$type);

		//var_dump($data['display_group_business_by_zone']);

		$result = $this->load->view('emailnotice/group_display_content_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0")); 

	}

	function update_groups_business_by_zone(){

		$id=isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;

		$status=isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;

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

		$group_id = isset($_REQUEST['group_id'])? $_REQUEST['group_id'] : 0; 

    	$group_name = isset($_REQUEST['group_name']) ? $_REQUEST['group_name'] : 0;

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

		$data['zoneid']=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;		

		$data['busid']=isset($_REQUEST['busid']) ? $_REQUEST['busid'] : 0;

		$data['ig_type']=isset($_REQUEST['ig_type']) ? $_REQUEST['ig_type'] : 0; //var_dump($data);

		$data['view_group_display_by_business']=$this->email_notice->view_group_display_by_business($_REQUEST['zoneid'],$data['busid'],$data['ig_type']);

		$result = $this->load->view('emailnotice/view_group_display_business', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function group_visibility_menu(){ 

		$data=array();

		$data['zoneid']=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;		

		$data['createdby_id']=isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;

		$data['createdby_type']=isset($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0 ;

		$result = $this->load->view('emailnotice/group_visibility_menu', $data, true);		//$result=1

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function group_visibility(){ 	

		$data=array();

		$data['zoneid']=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;		

		$data['createdby_id']=isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;

		$data['createdby_type']=isset($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0 ;

		$data['option']=isset($_REQUEST['option']) ? $_REQUEST['option'] : 1;

		$data['group_visibility_by_business']=$this->email_notice->group_visibility($_REQUEST['zoneid'],$data['createdby_id'],$data['createdby_type'],$data['option']);

		//echo '<pre>'; print_r($data['group_visibility_by_business']); exit; 

		$data['count_group_visibility_by_business'] =count($data['group_visibility_by_business']);

		$data['display_categories']=$this->email_notice->get_display_group_for_zone($_REQUEST['zoneid']);	   

		$data['active_group_display']=$this->email_notice->active_group_display($data['zoneid'],$data['createdby_id'],$data['createdby_type']); 	

		$data['active_group_display_id']=array();

		if(!empty($data['active_group_display'])){

			foreach($data['active_group_display'] as $agd){

				$data['active_group_display_id'][]=$agd['id'];

			}

		}

		//exit;      

	//var_dump($data['group_visibility_by_business']); var_dump($data['display_categories']); exit;

		$result = $this->load->view('emailnotice/group_visibility', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function save_group_display(){

		$groupid=isset($_REQUEST['groupid']) ? $_REQUEST['groupid'] : 0;

		$zoneid=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;

		$createdby_id=isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$createdby_type=isset($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0 ;

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

		$data['send_type']=$this->email_notice->snap_sendtype_check($data['zone_id'],$data['createdby_id'],$data['createdby_type'],$data['user_id']);// for ORG texting		

		//echo '<pre>';print_r($data);

		echo json_encode($data);

	}

	public function check_ig_display(){
		$user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:0;
		$adid = isset($_REQUEST['adid'])?$_REQUEST['adid']:0;
		$createdby_id = isset($_REQUEST['createdby_id'])?$_REQUEST['createdby_id']:0;
		$zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:0;
		$type = isset($_REQUEST['type'])?$_REQUEST['type']:0;
		
		$check_ig=$this->email_notice->check_ig_display($user_id,$createdby_id,$zone_id,$type);
		$interest_group_id_chk = $this->email_notice->interest_group_id($createdby_id,$type);
		$id = isset($interest_group_id_chk['id'])?$interest_group_id_chk['id']:'';
		$snap_criteria = $this->Snap_email_notification->fetchSnapCriteria();
		$selected_snap_data = $this->Snap_email_notification->getSelectedSnapCriteria($user_id,$createdby_id,$zone_id,$type);
		$returnData = array($check_ig,$snap_criteria,$selected_snap_data,$id);
		$returnData['interest_group_id_chk'] = !empty($id) ? $id : '';

		$returnData['check_ig'] = !empty($data['check_ig']['interest_groupid']) ? $data['check_ig']['interest_groupid'] : '';

		$returnData['send_type']=$this->email_notice->snap_sendtype_check($zone_id,$createdby_id,$type,$user_id,$adid);


		echo json_encode($returnData);

	}

	public function user_ig_insert(){  

		$data=array();		

 

		$data['user_id']=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;

		$data['createdby_id']=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;

		$data['type']=!empty($_REQUEST['type']) ? $_REQUEST['type'] : 0;

		echo $data['status']=$_REQUEST['status'];

		$data['send_type'] = !empty($_REQUEST['send_type']) ? $_REQUEST['send_type'] : 0 ;

		$data['snapWeekDaysId'] = !empty($_REQUEST['snapWeekDaysId']) ? $_REQUEST['snapWeekDaysId'] : 0;

		$data['snapTime'] = !empty($_REQUEST['snapTime']) ? $_REQUEST['snapTime'] : '';

		$data['minPercentage'] = $_REQUEST['minPercentageId'] ? $_REQUEST['minPercentageId'] : 0;	

        $data['adid'] = $_REQUEST['adid'] ? $_REQUEST['adid'] : 0;		

		isset($_REQUEST['iggroup']) ? $data['iggroup']=$_REQUEST['iggroup'] : $data['iggroup']='';		

		!empty($data['iggroup']) ? $interest_group=implode('@#$',$data['iggroup']) : $interest_group='';		

		$r = $this->email_notice->user_group_interest_insert($data['user_id'],$interest_group,$data['zone_id'],$data['createdby_id'],$data['type']);

		$t = $this->email_notice->user_status_update($data['user_id'],$data['zone_id'],$data['createdby_id'],$data['type'],$data['status'],$data['send_type'],$data['snapWeekDaysId'],$data['snapTime'],$data['minPercentage'],$data['adid']);	
 
	}

	

	### Business Part End

	### Org part start

	function view_menu_group_org_by_zone(){		

		$data=array();

		$data['zoneid']=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$data['org_zone']=$this->email_notice->get_all_org_againest_zone($data['zoneid']); //var_dump($data['org_zone']);

		$result = $this->load->view('emailnotice/group_display_menu_org_by_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function view_groups_org_by_zone(){

		$data=array();

		$data['zoneid'] = isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;

    	$org_id = isset($_REQUEST['orgid']) ? $_REQUEST['orgid'] : 0;

		$type = isset($_REQUEST['ig_type']) ? $_REQUEST['ig_type'] : 0 ; //var_dump($data['zoneid']); var_dump($bus_id); var_dump($type);		

		$data['display_group_business_by_zone']=$this->email_notice->display_group_org_by_zone($data['zoneid'],$org_id,$type);

		//var_dump($data['display_group_business_by_zone']);

		$result = $this->load->view('emailnotice/group_display_content_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0")); 

	}

	

	//++++++++++++++++++++++++++++++++++++++++++++EMAIL SIGN UP SECTION STARTED++++++++++++++++++++++++++++++++++++++++++++//

	public function emailnoticesignform(){
		isset($_REQUEST['createdby_id']) ? $data['createdby_id']=$_REQUEST['createdby_id'] : $data['createdby_id']='';				
		isset($_REQUEST['zone_id']) ? $data['zone_id']=$_REQUEST['zone_id'] : $data['zone_id']='';
		isset($_REQUEST['type']) ? $data['type']=$_REQUEST['type'] : $data['type']='';	
		isset($_REQUEST['ad_id']) ? $data['ad_id']=$_REQUEST['ad_id'] : $data['ad_id']='';	
		isset($_REQUEST['offer_type']) ? $data['offer_type']=$_REQUEST['offer_type'] : $data['offer_type']='';
		isset($_REQUEST['refer_code']) ? $data['refer_code']=$_REQUEST['refer_code'] : $data['refer_code']='';		
		isset($_REQUEST['seo_zone']) ? $data['seo_zone']=$_REQUEST['seo_zone'] : $data['seo_zone']='';

		$organization_category 	= 	$this->Email_notice->getcategoryofcreatedannouncement($data['zone_id']) ;
		$refferalcode = '';
		if($data['zone_id'] != ''){
 			$valid_referrer = $this->SalesZone->validate_referral($data['offer_type']);	 
 		   	if($valid_referrer == 1){
 		   		$refferalcode	 = $data['offer_type']; 
 		   	}
 		}
		
		$email_offers_criteria = $this->Email_notice->email_offers_criteria($parent_id=0) ;
		$snapEmailCriteria = $this->Snap_email_notification->fetchSnapCriteria();			
			
		$result =  view('emailnotice/emailnoticesignup',array('organization_category' => $organization_category,'refferalcode' => $refferalcode,'email_offers_criteria' => $email_offers_criteria,'snapEmailCriteria' => $snapEmailCriteria));

	 	echo "<pre>";print_r($result);die;




		$result	= 	$this->load->view("emailnotice/emailnoticesignup",$data, true);

        echo($this->dr->GetDR("Save Complete", "Save Completed...",$result, "0"));		

		//$this->load->view('emailnotice/emailnoticesignup');

	}

// visitor registeration form 

	function visitornoticesignform(){  
       
 		$segments = explode('/', rtrim($_REQUEST['url'], '/'));
  
		isset($_REQUEST['createdby_id']) ? $data['createdby_id']=$_REQUEST['createdby_id'] : $data['createdby_id']='';				

		isset($_REQUEST['zone_id']) ? $data['zone_id']=$_REQUEST['zone_id'] : $data['zone_id']='';

		isset($_REQUEST['type']) ? $data['type']=$_REQUEST['type'] : $data['type']='';	

		isset($_REQUEST['ad_id']) ? $data['ad_id']=$_REQUEST['ad_id'] : $data['ad_id']='';	

		isset($_REQUEST['offer_type']) ? $data['offer_type']=$_REQUEST['offer_type'] : $data['offer_type']='';		

	    if(count($segments) == 7){
 		 

 			 $valid_referrer = $this->sales_zone->validate_referral($segments[6]);	 
 		   if($valid_referrer == 1){
 		   	$data['refferalcode']	 = $segments[6]; 
 		   }
 		}
 

		$data['organization_category'] 	= 	$this->email_notice->getcategoryofcreatedannouncement($data['zone_id']) ;

		# + Signup from resident dropdown info fetch 

		$data['email_offers_criteria'] = $this->email_notice->email_offers_criteria($parent_id=0) ;//echo "<pre>"; var_dump($data['email_ageoffers_criteria']);exit;

		# - Signup from resident dropdown info fetch 

		$data['snapEmailCriteria']  	= $this->snap_email->fetchSnapCriteria();			

 

		$result	= 	$this->load->view("emailnotice/visitor_registration_form",$data, true);

	 
        echo($this->dr->GetDR("Save Complete", "Save Completed...",$result, "0"));		

		//$this->load->view('emailnotice/emailnoticesignup');

	}


// employee registeration form 

	function employeenoticesignform(){
 

     	$segments = explode('/', rtrim($_REQUEST['url'], '/'));
 
		isset($_REQUEST['createdby_id']) ? $data['createdby_id']=$_REQUEST['createdby_id'] : $data['createdby_id']='';				

		isset($_REQUEST['zone_id']) ? $data['zone_id']=$_REQUEST['zone_id'] : $data['zone_id']='';

		isset($_REQUEST['type']) ? $data['type']=$_REQUEST['type'] : $data['type']='';	

		isset($_REQUEST['ad_id']) ? $data['ad_id']=$_REQUEST['ad_id'] : $data['ad_id']='';	

		isset($_REQUEST['offer_type']) ? $data['offer_type']=$_REQUEST['offer_type'] : $data['offer_type']='';		 

		$data['organization_category'] 	= 	$this->email_notice->getcategoryofcreatedannouncement($data['zone_id']) ;

		 if(count($segments) == 7){
 			 $valid_referrer = $this->sales_zone->validate_referral($segments[6]);	 
 		   if($valid_referrer == 1){
 		   	$data['refferalcode']	 = $segments[6]; 
 		   }
 		}

		

		# + Signup from resident dropdown info fetch 

		$data['email_offers_criteria'] = $this->email_notice->email_offers_criteria($parent_id=0) ;//echo "<pre>"; var_dump($data['email_ageoffers_criteria']);exit;

		# - Signup from resident dropdown info fetch 

		$data['snapEmailCriteria']  	= $this->snap_email->fetchSnapCriteria();			

 

		$result	= 	$this->load->view("emailnotice/employee_registration_form",$data, true);

	 
        echo($this->dr->GetDR("Save Complete", "Save Completed...",$result, "0"));		

		//$this->load->view('emailnotice/emailnoticesignup');

	}




	function classifiedemailnoticesignform(){

 
		isset($_REQUEST['createdby_id']) ? $data['createdby_id']=$_REQUEST['createdby_id'] : $data['createdby_id']='';				

		isset($_REQUEST['zone_id']) ? $data['zone_id']=$_REQUEST['zone_id'] : $data['zone_id']='';

		isset($_REQUEST['type']) ? $data['type']=$_REQUEST['type'] : $data['type']='';	

		isset($_REQUEST['ad_id']) ? $data['ad_id']=$_REQUEST['ad_id'] : $data['ad_id']='';	

		isset($_REQUEST['offer_type']) ? $data['offer_type']=$_REQUEST['offer_type'] : $data['offer_type']='';		

	 

		$data['organization_category'] 	= 	$this->email_notice->getcategoryofcreatedannouncement($data['zone_id']) ;

		

		# + Signup from resident dropdown info fetch 

		$data['email_offers_criteria'] = $this->email_notice->email_offers_criteria($parent_id=0) ;//echo "<pre>"; var_dump($data['email_ageoffers_criteria']);exit;

		# - Signup from resident dropdown info fetch 

		//$data['snapEmailCriteria']  = $this->snap_email->fetchSnapCriteria();			

 

		$result	= 	$this->load->view("emailnotice/classifiedemailnoticesinup",$data, true);

		$results['Title'] = 'Save Complete';
		$results['Message'] = 'Save Completed...';
		$results['Tag'] = $result;
		$results['Height'] = '0';

 
 

       echo    json_encode($results) ;
 
  

	}






	public function emailnoticeinsertdata_social_linkdin($email= '' , $firstname='', $lastname='',$from=''){
 
 
	  
	 

	 

		isset($firstname) ? $name= $firstname.$lastname : $name=''; 

		isset($_REQUEST['user_type']) ? $user_type=$_REQUEST['user_type'] : $user_type='';

		isset($_REQUEST['zone_id']) ? $zone_id=$_REQUEST['zone_id'] : $zone_id='';

		isset($_REQUEST['globalSnapStatus']) ? $glbalSnapStatus = $_REQUEST['globalSnapStatus'] : $glbalSnapStatus = '';

     

		
	 
 

             $login = $this->ion_auth_model->login_event_fromsocial($name,$email,$from);
   
             if($login == true){

                  echo 'existing_user';


             }else{


          


		$globalSnapSendType = 3; 

		$additional_data = array('first_name'=>$first_name,'last_name'=>$last_name,'City'=>$city,'phone'=>$emailnotice_phone,'Zip'=>$zipcode,'Address'=>$state."<br/>".$cellphone1."<br/>".$cellphone2,'company'=>'','Zone_ID' => $zone_id);

		$data_peekaboo_bidder=array(			  

				 'email'=>$email,  

			     'user_name'=>$name,	 

				 'register_date'=>time(),

				 'balance'=>20,

				 'activated'=>'yes',

				 'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),

				 'member_type'=>1

				 

			);

			$this->db->insert('tbl_member', $data_peekaboo_bidder);

       		$data_peekaboo_bidder_id = $this->db->insert_id();

       		if($data_peekaboo_bidder_id>0){

       			$data_member_credit=array(

			     'member_id'=>$data_peekaboo_bidder_id,

				 'credit_type'=>'c',

				 'credit'=>10,

				 'created_at'=>now()

			);

			$this->db->insert('tbl_member_credit', $data_member_credit);

       		}	






		

		$accountGroups = array();

		$accountGroups[] = "10";

	    $data['emailnoticeuser']=$this->ion_auth->register($name, '', $email, '', $accountGroups,'','','', '',$from);		 

		

		$resident_details=array(

		      'zone_residentuser_userid'=>$data['emailnoticeuser'],
		      'zone_residentuser_zoneid'=>$zone_id
		      

		);	

		$this->db->insert('zone_residentuser', $resident_details);

       	$resident_details_id = $this->db->insert_id();	

		

		////////////

		

		/////////////	Insert selected category by resident user

		

		$selectedcategory_details=array(

		      'resident_userid'=>$data['emailnoticeuser'],

		      'zoneid'=>$zone_id,

			  'selectedcategory'=>','.$selected_category.',',

			  'time'=>time()

		);	

		$this->db->insert('resident_interestedcategory', $selectedcategory_details);

 
		////////////

		// Insert global snap status

		$globalSnapData = array();

		if($glbalSnapStatus == 1) {

			$snapWeekDays  = implode(',',$snapWeekDays);

			$snapTimeArray = implode(',', $snapTimeArray);

			$globalSnapData = array(

									'snap_send_type'          => $globalSnapSendType,

									'snap_minimum_percentage' => $snapMinimumPercentacge,

									'created_for_zone'        => $zone_id,

									'user_id'                 => $data['emailnoticeuser'],

									'status'                  => $glbalSnapStatus,

									'from_where'              => 'global_snap_settings'

							   );

		} else {

			$globalSnapData = array(

									'created_for_zone'        => $zone_id,

									'user_id'                 => $data['emailnoticeuser'],

									'status'                  => $glbalSnapStatus,

									'from_where'              => 'global_snap_settings'

							   );



		}

		

		$this->db->insert('global_snap_settings',$globalSnapData);

		$remember='';

		if ($this->ion_auth->login($email, $password, $remember)){

			$session_normal_user_in_zone = array('sesuserzone'=>$zone_id,'sesusertype'=>'resident_user');                   		

        	$this->session->set_userdata('session_normal_user_in_zone',$session_normal_user_in_zone);

			$usersession_data = $this->session->userdata('session_normal_user_in_zone');

		}

		$zone_id = $_REQUEST['zone_id'];

		$get_zone_details = $this->email_notice->getZonedetails($zone_id);

		$short_url = $get_zone_details['short_url'];

		$zone_name = $get_zone_details['name'];

		if($short_url!='')

			$zone_url = $short_url;

		else

			$zone_url = 'http://savingssites.com/zone/'.$get_zone_details['seo_zone_name'];

	 

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		if(!empty($emailvalidation)==1){
 

					$message_body =	'<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">

								<div style="width:960px; margin:0 auto !important;">

								<div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">

								<div style="background-color:#3f3f3f; height:70px;"><h1 style="color: #fff;padding-left: 9px;">'.$zone_name.'</h1><br>

								<p style="color: #fff;margin-top: -14px;padding-left: 22px;">powered by <b>SavingsSites</b></p>

								</div>

								<div style="clear:both"></div>

								<div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:300px; padding:15px;">

								<h2 style="text-align:left;">Dear '.$first_name." ".$last_name.',<br>'. 

								'</h2><h3><p style="text-align:left; display:block; color:#333;">Thank you for signing up with '.$zone_name.'.<br>Below are your registered details:</h3>

								<h3><p style="text-align:left; display:block; color:#333;">Username: '.$username.' </p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">First Name: '.$first_name.'	</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Last Name: '.$last_name.'</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Telephone: '.$emailnotice_phone.'</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Email: '.$email.'</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Best Regards,<br />

								'.$zone_name.'<br/>'.								 

								'</h3>

								</div>

								<div style="background-color:#999; height:60px;"></div>

								</div>

								</div>

								</body>';

			

								$fromemail=$this->config->item('adminEmailId');

								$this->load->library('email');

								$template_subject="New Registration";

								$this->email->clear();

								$this->email->from($fromemail);

								$this->email->to($email);

								$this->email->subject($template_subject);

								$this->email->message($message_body);

								$this->email->send();

		 }

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		

		$par_for_ig=array('user_id'=>$data['emailnoticeuser'],'createdby_id'=>$createdby_id,'zone_id'=>$zone_id,'type'=>$type,'offer_type'=>$offer_type);

		echo($this->dr->GetDR("","", $par_for_ig, "0")); 
    }

	}



	function curllinkdein(){


	 $data = [];

        $curl_handle=curl_init();
  curl_setopt($curl_handle,CURLOPT_URL,'https://www.linkedin.com/oauth/v2/accessToken?grant_type=authorization_code&code='.$_REQUEST['data'].'&redirect_uri='.base_url().'/zone/zone-test&client_id=86fx45gfg2z3jg&client_secret=u3UwftYdjjJFPgMg&scope=r_liteprofile,r_emailaddress');
  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
  $buffer = curl_exec($curl_handle);
  curl_close($curl_handle);
  if (empty($buffer)){
      print "Nothing returned from url.<p>";
  }
  else{
    
     $buffer = json_decode($buffer); 
             

                $header = array();
				$header[] = 'Content-length: 0';
				$header[] = 'Content-type: application/json';
				$header[] = 'Authorization: Bearer '.$buffer->access_token;


 
             $curl_handle=curl_init();
			  curl_setopt($curl_handle,CURLOPT_URL,'https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))');
			  curl_setopt($curl_handle, CURLOPT_HTTPHEADER,$header);
			  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
			  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
			  
			  $buffer1 = curl_exec($curl_handle);
			  curl_close($curl_handle);
			  if (empty($buffer1)){
			      print "Nothing returned from url.<p>";
			  }
			  else{
			     $data[] = json_decode($buffer1);                 

			      
			  }



			   $curl_handle=curl_init();
			  curl_setopt($curl_handle,CURLOPT_URL,'https://api.linkedin.com/v2/me');
			  curl_setopt($curl_handle, CURLOPT_HTTPHEADER,$header);
			  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
			  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
			  
			  $buffer2 = curl_exec($curl_handle);
			  curl_close($curl_handle);

			  if (empty($buffer2)){
			      print "Nothing returned from url.<p>";
			  }
			  else{
			     $data[] = json_decode($buffer2);                   

			      
			  }

 
			if(@$data[0]->status!='401'){

			             	// print_r($data);
			                // print_r(@$data[0]->elements[0]->{"handle~"}->emailAddress);            
			                // print_r(@$data[1]->localizedFirstName);
			                // print_r(@$data[1]->localizedLastName);

		    $this->emailnoticeinsertdata_social_linkdin(@$data[0]->elements[0]->{"handle~"}->emailAddress , @$data[1]->localizedFirstName, @$data[1]->localizedLastName,'linkd');

			}

			 
 





  }


 
	}


	function emailnoticeinsertdata_social(){
 
 
	  
		isset($_REQUEST['email']) ? $email=$_REQUEST['email'] : $email='';

		isset($_REQUEST['name']) ? $name=$_REQUEST['name'] : $name='';

		isset($_REQUEST['user_type']) ? $user_type=$_REQUEST['user_type'] : $user_type='';

		isset($_REQUEST['zone_id']) ? $zone_id=$_REQUEST['zone_id'] : $zone_id='';

		isset($_REQUEST['globalSnapStatus']) ? $glbalSnapStatus = $_REQUEST['globalSnapStatus'] : $glbalSnapStatus = '';

        isset($_REQUEST['from']) ? $from = $_REQUEST['from'] : $from = '';

		
 

             $login = $this->ion_auth_model->login_event_fromsocial($_REQUEST['name'],$_REQUEST['email'],$from);
   
             if($login == true){

                  echo 'existing_user';


             }else{


          


		$globalSnapSendType = 3; 

		$additional_data = array('first_name'=>$first_name,'last_name'=>$last_name,'City'=>$city,'phone'=>$emailnotice_phone,'Zip'=>$zipcode,'Address'=>$state."<br/>".$cellphone1."<br/>".$cellphone2,'company'=>'','Zone_ID' => $zone_id);

		$data_peekaboo_bidder=array(			  

				 'email'=>$email,  

			     'user_name'=>$name,	 

				 'register_date'=>time(),

				 'balance'=>20,

				 'activated'=>'yes',

				 'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),

				 'member_type'=>1

				 

			);

			$this->db->insert('tbl_member', $data_peekaboo_bidder);

       		$data_peekaboo_bidder_id = $this->db->insert_id();

       		if($data_peekaboo_bidder_id>0){

       			$data_member_credit=array(

			     'member_id'=>$data_peekaboo_bidder_id,

				 'credit_type'=>'c',

				 'credit'=>10,

				 'created_at'=>now()

			);

			$this->db->insert('tbl_member_credit', $data_member_credit);

       		}	






		

		$accountGroups = array();

		$accountGroups[] = "10";

	    $data['emailnoticeuser']=$this->ion_auth->register($name, '', $email, '', $accountGroups,'','','', '',$from);		 

		

		$resident_details=array(

		      'zone_residentuser_userid'=>$data['emailnoticeuser'],
		      'zone_residentuser_zoneid'=>$zone_id
		      

		);	

		$this->db->insert('zone_residentuser', $resident_details);

       	$resident_details_id = $this->db->insert_id();	

		

		////////////

		

		/////////////	Insert selected category by resident user

		

		$selectedcategory_details=array(

		      'resident_userid'=>$data['emailnoticeuser'],

		      'zoneid'=>$zone_id,

			  'selectedcategory'=>','.$selected_category.',',

			  'time'=>time()

		);	

		$this->db->insert('resident_interestedcategory', $selectedcategory_details);

 
		////////////

		// Insert global snap status

		$globalSnapData = array();

		if($glbalSnapStatus == 1) {

			$snapWeekDays  = implode(',',$snapWeekDays);

			$snapTimeArray = implode(',', $snapTimeArray);

			$globalSnapData = array(

									'snap_send_type'          => $globalSnapSendType,

									'snap_minimum_percentage' => $snapMinimumPercentacge,

									'created_for_zone'        => $zone_id,

									'user_id'                 => $data['emailnoticeuser'],

									'status'                  => $glbalSnapStatus,

									'from_where'              => 'global_snap_settings'

							   );

		} else {

			$globalSnapData = array(

									'created_for_zone'        => $zone_id,

									'user_id'                 => $data['emailnoticeuser'],

									'status'                  => $glbalSnapStatus,

									'from_where'              => 'global_snap_settings'

							   );



		}

		

		$this->db->insert('global_snap_settings',$globalSnapData);

		$remember='';

		if ($this->ion_auth->login($email, $password, $remember)){

			$session_normal_user_in_zone = array('sesuserzone'=>$zone_id,'sesusertype'=>'resident_user');                   		

        	$this->session->set_userdata('session_normal_user_in_zone',$session_normal_user_in_zone);

			$usersession_data = $this->session->userdata('session_normal_user_in_zone');

		}

		$zone_id = $_REQUEST['zone_id'];

		$get_zone_details = $this->email_notice->getZonedetails($zone_id);

		$short_url = $get_zone_details['short_url'];

		$zone_name = $get_zone_details['name'];

		if($short_url!='')

			$zone_url = $short_url;

		else

			$zone_url = 'http://savingssites.com/zone/'.$get_zone_details['seo_zone_name'];

		/*echo"<pre>";

		print_r($get_zone_details);

		die;*/	

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		if(!empty($emailvalidation)==1){
 

					$message_body =	'<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">

								<div style="width:960px; margin:0 auto !important;">

								<div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">

								<div style="background-color:#3f3f3f; height:70px;"><h1 style="color: #fff;padding-left: 9px;">'.$zone_name.'</h1><br>

								<p style="color: #fff;margin-top: -14px;padding-left: 22px;">powered by <b>SavingsSites</b></p>

								</div>

								<div style="clear:both"></div>

								<div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:300px; padding:15px;">

								<h2 style="text-align:left;">Dear '.$first_name." ".$last_name.',<br>'. 

								'</h2><h3><p style="text-align:left; display:block; color:#333;">Thank you for signing up with '.$zone_name.'.<br>Below are your registered details:</h3>

								<h3><p style="text-align:left; display:block; color:#333;">Username: '.$username.' </p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">First Name: '.$first_name.'	</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Last Name: '.$last_name.'</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Telephone: '.$emailnotice_phone.'</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Email: '.$email.'</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Best Regards,<br />

								'.$zone_name.'<br/>'.

								"<a href='{$zone_url}'>{$zone_url}</a>".

								'</h3>

								</div>

								<div style="background-color:#999; height:60px;"></div>

								</div>

								</div>

								</body>';

			

								$fromemail=$this->config->item('adminEmailId');

								$this->load->library('email');

								$template_subject="New Registration";

								$this->email->clear();

								$this->email->from($fromemail);

								$this->email->to($email);

								$this->email->subject($template_subject);

								$this->email->message($message_body);

								$this->email->send();

		 }

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		

		$par_for_ig=array('user_id'=>$data['emailnoticeuser'],'createdby_id'=>$createdby_id,'zone_id'=>$zone_id,'type'=>$type,'offer_type'=>$offer_type);

		echo($this->dr->GetDR("","", $par_for_ig, "0")); 
    }

	}





	function emailnoticeinsertdata(){
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
		isset($_REQUEST['user_type']) ? $user_type=$_REQUEST['user_type'] : $user_type='';
		isset($_REQUEST['refferalcode']) ? $refferalcode=$_REQUEST['refferalcode'] : $refferalcode='';
		//Added on 29/5/14
		isset($_REQUEST['emailnotice_phone']) ? $emailnotice_phone=$_REQUEST['emailnotice_phone'] : $emailnotice_phone='';			
		isset($_REQUEST['carrier']) ? $carrier=$_REQUEST['carrier'] : $carrier='';
		//Added on 23/02/18
		isset($_REQUEST['cell_phone']) ? $cellPhone=$_REQUEST['cell_phone'] : $cellPhone='';
		isset($_REQUEST['cell_phoneextra']) ? $cell_phoneextra=$_REQUEST['cell_phoneextra'] : $cell_phoneextra=[];
		//Added on 29/5/14
		isset($_REQUEST['password']) ? $password=$_REQUEST['password'] : $password='';
		isset($_REQUEST['group']) ? $group=$_REQUEST['group'] : $group='';
		isset($_REQUEST['createdby_id']) ? $createdby_id=$_REQUEST['createdby_id'] : $createdby_id='';
		isset($_REQUEST['zone_id']) ? $zone_id=$_REQUEST['zone_id'] : $zone_id='';
		isset($_REQUEST['type']) ? $type=$_REQUEST['type'] : $type='';
		isset($_REQUEST['offer_type']) ? $offer_type=$_REQUEST['offer_type'] : $offer_type='';
		isset($_REQUEST['emailvalidation']) ? $emailvalidation=$_REQUEST['emailvalidation'] : $emailvalidation='';
		isset($_REQUEST['selected_orgcategory']) ? $selected_category = $_REQUEST['selected_orgcategory'] : $selected_category = '';
		isset($_REQUEST['globalSnapStatus']) ? $glbalSnapStatus = $_REQUEST['globalSnapStatus'] : $glbalSnapStatus = '';
		isset($_REQUEST['snapWeekdays']) ? $snapWeekDays = $_REQUEST['snapWeekdays'] : $snapWeekDays = '';
		isset($_REQUEST['snapStartTime']) ? $snapTimeArray = $_REQUEST['snapStartTime'] : $snapTimeArray = '';
		isset($_REQUEST['additionalDelivery']) ? $additionalDelivery = $_REQUEST['additionalDelivery'] : $additionalDelivery = '';
		isset($_REQUEST['snapSelectedMinimumPercentage']) ? $snapMinimumPercentacge = $_REQUEST['snapSelectedMinimumPercentage'] : $snapMinimumPercentacge = 0;
		isset($_REQUEST['refferalcode']) ? $refferalcode=$_REQUEST['refferalcode'] : $refferalcode=''; //refer code
		isset($_REQUEST['refer_code']) ? $refer_code=$_REQUEST['refer_code'] : $refer_code=''; //refer code
 		$globalSnapSendType = 3; 
 		$cellPhone = str_replace("-", "", $cellPhone);
 		$phone = str_replace("-", "", $phone);
 		$accountGroups = array();
		$accountGroups[] = "10";
		$remember='';
		// $additional_data = array('first_name'=>$first_name,'last_name'=>$last_name,'City'=>$city,'phone'=>$emailnotice_phone,'Zip'=>$zipcode,'Address'=>$state."<br/>".$cellphone1."<br/>".$cellphone2,'company'=>'','Zone_ID' => $zone_id);

		$additional_data = array('first_name'=>$first_name,'last_name'=>$last_name,'City'=>$city,'phone'=>$cellPhone,'Zip'=>$zipcode,'Address'=>$state."<br/>".$cellphone1."<br/>".$cellphone2,'company'=>'','Zone_ID' => $zone_id);

		$data_peekaboo_bidder=array(
			'fName'=>$first_name,
			'lName'=>$last_name,
			'email'=>$email,
			'city_name'=>$city,
			'state_name'=>$state,
			'phone'=>$emailnotice_phone,
			'user_name'=>$username,
			'password'=>sha1($password),
			'register_date'=>time(),
			'balance'=>20,
			'activated'=>'yes',
			'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),
			'member_type'=>1,
			'additional_info' => $additionalDelivery,
			'fromreferrer' => $refferalcode
		);
		$data_peekaboo_bidder_id = $this->CommonController->InsertData('tbl_member', $data_peekaboo_bidder);
		
		if($data_peekaboo_bidder_id>0){
			$data_member_credit=array(
				'member_id'=>$data_peekaboo_bidder_id,
				'credit_type'=>'c',
				'credit'=>10,
				'created_at'=>now()
			);
			$this->CommonController->InsertData('tbl_member_credit', $data_member_credit);
		}	
		
		$data['emailnoticeuser']=$this->ion_auth->register($username, $password, $email, $additional_data, $accountGroups,'',$emailnotice_phone, $carrier, $cellPhone,'',$refer_code);
		if($data['emailnoticeuser'] > 0){
			if(count($cell_phoneextra) > 0){
				$sraltp = 0;
				foreach ($cell_phoneextra as $alphone) {
					$sraltp++;
					$alphone = str_replace("-", "", $alphone);
					$user_phone_alternate = array('user_id' => $data['emailnoticeuser'],'phone' => $alphone,'counter' => $sraltp);
					$this->CommonController->InsertData('users_multiple_phonesno', $user_phone_alternate);
				}
			}
		}		 
	    // select the organisation
        if($refferalcode){
			$sql = "SELECT organization.id FROM `users` LEFT JOIN users_groups ON users_groups.user_id = users.id LEFT JOIN organization ON organization.userid = users.id WHERE users_groups.group_id = 8 AND users.referral_code = '".$refferalcode."'";
			$query=$this->db->query($sql);
	        $organization_id=$query->result();
			$id = $organization_id[0]->id;
	    	if ($id) {
		    	$data_org1=array('userid' => $data['emailnoticeuser'],'zoneid'=>$zone_id,'org' => $id);
		    	$id =$insert_id =  $this->CommonController->InsertData('tbl_selected_nonorg', $data_org1);
			}
		}

		$resident_details=array(
			'zone_residentuser_userid'=>$data['emailnoticeuser'],
		    'zone_residentuser_zoneid'=>$zone_id
		);
		
		$resident_details_id = $this->CommonController->InsertData('zone_residentuser', $resident_details);
		/////////////	Insert selected category by resident user
		$selectedcategory_details=array(
			'resident_userid'=>$data['emailnoticeuser'],
			'zoneid'=>$zone_id,
			'selectedcategory'=>','.$selected_category.',',
			'time'=>time()
		);	

		$this->CommonController->InsertData('resident_interestedcategory', $selectedcategory_details);
		
		// Insert global snap status
		$globalSnapData = array();
		if($glbalSnapStatus == 1) {
			$snapWeekDays  = implode(',',$snapWeekDays);
			$snapTimeArray = implode(',', $snapTimeArray);
			$globalSnapData = array(
				'snap_send_type'          => $globalSnapSendType,
				'snap_minimum_percentage' => $snapMinimumPercentacge,
				'created_for_zone'        => $zone_id,
				'user_id'                 => $data['emailnoticeuser'],
				'status'                  => $glbalSnapStatus,
				'from_where'              => 'global_snap_settings'
			);
		} else {
			$globalSnapData = array(
				'created_for_zone'        => $zone_id,
				'user_id'                 => $data['emailnoticeuser'],
				'status'                  => $glbalSnapStatus,
				'from_where'              => 'global_snap_settings'
			);
		}
		
		$this->CommonController->InsertData('global_snap_settings', $globalSnapData);
		
		if ($this->ion_auth->login($email, $password, $remember)){
			$session_normal_user_in_zone = array('sesuserzone'=>$zone_id,'sesusertype'=>'resident_user'); 
			$this->CommonController->setSession('session_normal_user_in_zone', $session_normal_user_in_zone,'array');
			$this->CommonController->setSession('session_normal_user_in_zone',[],'array');
		}
		$zone_id = $_REQUEST['zone_id'];
		$get_zone_details = $this->CommonController->SelectDataMultiWay('sales_zone','*','rowArray',array('id'=>$zone_id));
		$this->CommonController->setSession('session_login_details', array('type'=>10,'id'=>$data['emailnoticeuser']));
		$this->CommonController->setSession('session_normal_user_in_zone', array('sesusertype'=>10));
		// $get_zone_details = $this->email_notice->getZonedetails($zone_id);
		$short_url = $get_zone_details['short_url'];
		$zone_name = $get_zone_details['name'];
		if($short_url!=''){
			$zone_url = $short_url;
		}
		else{
			$zone_url = 'http://savingssites.com/zone/'.$get_zone_details['seo_zone_name'];
		}
		
		if(!empty($emailvalidation)==1){
 			$message_body =	'<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">
				<div style="width:960px; margin:0 auto !important;">
				<div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">
				<div style="background-color:#3f3f3f; height:70px;"><h1 style="color: #fff;padding-left: 9px;">'.$zone_name.'</h1><br>
					<p style="color: #fff;margin-top: -14px;padding-left: 22px;">powered by <b>SavingsSites</b></p>
				</div>
				<div style="clear:both"></div>
				<div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:300px; padding:15px;">
					<h2 style="text-align:left;">Dear '.$first_name." ".$last_name.',<br>'. '</h2><h3><p style="text-align:left; display:block; color:#333;">Thank you for signing up with '.$zone_name.'.<br>Below are your registered details:</h3>
					<h3><p style="text-align:left; display:block; color:#333;">Username: '.$username.' </p></h3>
					<h3><p style="text-align:left; display:block; color:#333;">First Name: '.$first_name.'	</p></h3>
					<h3><p style="text-align:left; display:block; color:#333;">Last Name: '.$last_name.'</p></h3>
					<h3><p style="text-align:left; display:block; color:#333;">Telephone: '.$emailnotice_phone.'</p></h3>
					<h3><p style="text-align:left; display:block; color:#333;">Email: '.$email.'</p></h3>
					<h3><p style="text-align:left; display:block; color:#333;">Best Regards,<br />'.$zone_name.'<br/>'."<a href='{$zone_url}'>{$zone_url}</a>".'</h3>
				</div>
				<div style="background-color:#999; height:60px;"></div>
				</div></div></body>';
			$this->CommonController->SendMail('',$to,'New Registration',$message_body);
		}

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$par_for_ig=array('user_id'=>$data['emailnoticeuser'],'createdby_id'=>$createdby_id,'zone_id'=>$zone_id,'type'=>$type,'offer_type'=>$offer_type);
		echo json_encode($par_for_ig);
		die;
		// echo($this->dr->GetDR("","", $par_for_ig, "0")); 
 	}


	//  employee regsiteration 
	function employeenoticeinsertdata(){
	 
 
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

		isset($_REQUEST['user_type']) ? $user_type=$_REQUEST['user_type'] : $user_type='';

		isset($_REQUEST['refferalcode']) ? $refferalcode=$_REQUEST['refferalcode'] : $refferalcode='';

		//Added on 29/5/14

		isset($_REQUEST['emailnotice_phone']) ? $emailnotice_phone=$_REQUEST['emailnotice_phone'] : $emailnotice_phone='';			

		isset($_REQUEST['carrier']) ? $carrier=$_REQUEST['carrier'] : $carrier='';

		//Added on 23/02/18

		isset($_REQUEST['cell_phone']) ? $cellPhone=$_REQUEST['cell_phone'] : $cellPhone='';



		//Added on 29/5/14

		isset($_REQUEST['password']) ? $password=$_REQUEST['password'] : $password='';

		isset($_REQUEST['group']) ? $group=$_REQUEST['group'] : $group='';

		isset($_REQUEST['createdby_id']) ? $createdby_id=$_REQUEST['createdby_id'] : $createdby_id='';

		isset($_REQUEST['zone_id']) ? $zone_id=$_REQUEST['zone_id'] : $zone_id='';

		isset($_REQUEST['type']) ? $type=$_REQUEST['type'] : $type='';

		isset($_REQUEST['offer_type']) ? $offer_type=$_REQUEST['offer_type'] : $offer_type='';

		isset($_REQUEST['emailvalidation']) ? $emailvalidation=$_REQUEST['emailvalidation'] : $emailvalidation='';

		isset($_REQUEST['selected_orgcategory']) ? $selected_category = $_REQUEST['selected_orgcategory'] : $selected_category = '';

		isset($_REQUEST['globalSnapStatus']) ? $glbalSnapStatus = $_REQUEST['globalSnapStatus'] : $glbalSnapStatus = '';

		isset($_REQUEST['snapWeekdays']) ? $snapWeekDays = $_REQUEST['snapWeekdays'] : $snapWeekDays = '';

		isset($_REQUEST['snapStartTime']) ? $snapTimeArray = $_REQUEST['snapStartTime'] : $snapTimeArray = '';

		isset($_REQUEST['snapSelectedMinimumPercentage']) ? $snapMinimumPercentacge = $_REQUEST['snapSelectedMinimumPercentage'] : $snapMinimumPercentacge = 0;
	    
	    isset($_REQUEST['additionalDelivery']) ? $additionalDelivery = $_REQUEST['additionalDelivery'] : $additionalDelivery = '';

		$globalSnapSendType = 3;

		 

		

		$additional_data = array('first_name'=>$first_name,'last_name'=>$last_name,'City'=>$city,'phone'=>$emailnotice_phone,'Zip'=>$zipcode,'Address'=>$state."<br/>".$cellphone1."<br/>".$cellphone2,'company'=>'','Zone_ID' => $zone_id);

		$data_peekaboo_bidder=array(

			     'fName'=>$first_name,

				 'lName'=>$last_name,

				 'email'=>$email,

				 'city_name'=>$city,

				 'state_name'=>$state,

				 'phone'=>$emailnotice_phone,

			     'user_name'=>$username,

				 'password'=>sha1($password),

				 'register_date'=>time(),

				 'balance'=>20,

				 'activated'=>'yes',

				 'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),

				 'member_type'=>1,

				 'fromreferrer' => $refferalcode,
				 
				 'additional_info' => $additionalDelivery

			);

			$this->db->insert('tbl_member', $data_peekaboo_bidder);

       		$data_peekaboo_bidder_id = $this->db->insert_id();

       		if($data_peekaboo_bidder_id>0){

       			$data_member_credit=array(

			     'member_id'=>$data_peekaboo_bidder_id,

				 'credit_type'=>'c',

				 'credit'=>10,

				 'created_at'=>now()

			);

			$this->db->insert('tbl_member_credit', $data_member_credit);

       		}	

		

		

		$accountGroups = array();

		$accountGroups[] = $user_type;

	    $data['emailnoticeuser']=$this->ion_auth->register($username, $password, $email, $additional_data, $accountGroups,'',$emailnotice_phone, $carrier, $cellPhone);		 

		 
		$remember='';

		if ($this->ion_auth->login($email, $password, $remember)){

			$session_normal_user_in_zone = array('sesuserzone'=>$zone_id,'sesusertype'=>'resident_user');                   		

        	$this->session->set_userdata('session_normal_user_in_zone',$session_normal_user_in_zone);

			$usersession_data = $this->session->userdata('session_normal_user_in_zone');
 

		}



		$zone_id = $_REQUEST['zone_id'];

		$get_zone_details = $this->email_notice->getZonedetails($zone_id);

		$short_url = $get_zone_details['short_url'];

		$zone_name = $get_zone_details['name'];


		// select the organisation
        if($refferalcode){

        $sql = "SELECT organization.id FROM `users` LEFT JOIN users_groups ON users_groups.user_id = users.id LEFT JOIN organization ON organization.userid = users.id WHERE users_groups.group_id = 8 AND users.referral_code = '".$refferalcode."'";


        $query=$this->db->query($sql);
	          
	    $organization_id=$query->result();

	    $id = $organization_id[0]->id;
	    
		    if ($id) {
		    	$data_org1=array('userid' => $data['emailnoticeuser'],'zoneid'=>$zone_id,'org' => $id); 
				$this->db->insert('tbl_selected_nonorg', $data_org1);
				$id = $insert_id = $this->db->insert_id();
		    }
		
      	}





		if($short_url!='')

			$zone_url = $short_url;

		else

			$zone_url = 'http://savingssites.com/zone/'.$get_zone_details['seo_zone_name'];

 
		if(!empty($emailvalidation)==1){ 

					$message_body =	'<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">

								<div style="width:960px; margin:0 auto !important;">

								<div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">

								<div style="background-color:#3f3f3f; height:70px;"><h1 style="color: #fff;padding-left: 9px;">'.$zone_name.'</h1><br>

								<p style="color: #fff;margin-top: -14px;padding-left: 22px;">powered by <b>SavingsSites</b></p>

								</div>

								<div style="clear:both"></div>

								<div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:300px; padding:15px;">

								<h2 style="text-align:left;">Dear '.$first_name." ".$last_name.',<br>'. 

								'</h2><h3><p style="text-align:left; display:block; color:#333;">Thank you for signing up with '.$zone_name.'.<br>Below are your registered details:</h3>

								<h3><p style="text-align:left; display:block; color:#333;">Username: '.$username.' </p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">First Name: '.$first_name.'	</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Last Name: '.$last_name.'</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Telephone: '.$emailnotice_phone.'</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Email: '.$email.'</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Best Regards,<br />

								'.$zone_name.'<br/>'.

								"<a href='{$zone_url}'>{$zone_url}</a>".

								'</h3>

								</div>

								<div style="background-color:#999; height:60px;"></div>

								</div>

								</div>

								</body>';

			

								$fromemail=$this->config->item('adminEmailId');

								$this->load->library('email');

								$template_subject="New Registration";

								$this->email->clear();

								$this->email->from($fromemail);

								$this->email->to($email);

								$this->email->subject($template_subject);

								$this->email->message($message_body);

								$this->email->send();

		 }

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		

		$par_for_ig=array('user_id'=>$data['emailnoticeuser'],'createdby_id'=>$createdby_id,'zone_id'=>$zone_id,'type'=>$type,'offer_type'=>$offer_type);

		echo($this->dr->GetDR("","", $par_for_ig, "0")); 
 

	}

//  referral user

	function referalnoticeinsertdata(){

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

		isset($_REQUEST['user_type']) ? $user_type=$_REQUEST['user_type'] : $user_type='';

		isset($_REQUEST['referraluser']) ? $referraluser=$_REQUEST['referraluser'] : $referraluser='';
		

		//Added on 29/5/14

		isset($_REQUEST['emailnotice_phone']) ? $emailnotice_phone=$_REQUEST['emailnotice_phone'] : $emailnotice_phone='';			

		isset($_REQUEST['carrier']) ? $carrier=$_REQUEST['carrier'] : $carrier='';

		//Added on 23/02/18

		isset($_REQUEST['cell_phone']) ? $cellPhone=$_REQUEST['cell_phone'] : $cellPhone='';



		//Added on 29/5/14

		isset($_REQUEST['password']) ? $password=$_REQUEST['password'] : $password='';

		isset($_REQUEST['group']) ? $group=$_REQUEST['group'] : $group='';

		isset($_REQUEST['createdby_id']) ? $createdby_id=$_REQUEST['createdby_id'] : $createdby_id='';

		isset($_REQUEST['zone_id']) ? $zone_id=$_REQUEST['zone_id'] : $zone_id='';

		isset($_REQUEST['refferalcode']) ? $refferalcode=$_REQUEST['refferalcode'] : $refferalcode='';

		isset($_REQUEST['type']) ? $type=$_REQUEST['type'] : $type='';

		isset($_REQUEST['offer_type']) ? $offer_type=$_REQUEST['offer_type'] : $offer_type='';

		isset($_REQUEST['emailvalidation']) ? $emailvalidation=$_REQUEST['emailvalidation'] : $emailvalidation='';

		isset($_REQUEST['selected_orgcategory']) ? $selected_category = $_REQUEST['selected_orgcategory'] : $selected_category = '';

		isset($_REQUEST['globalSnapStatus']) ? $glbalSnapStatus = $_REQUEST['globalSnapStatus'] : $glbalSnapStatus = '';

		isset($_REQUEST['snapWeekdays']) ? $snapWeekDays = $_REQUEST['snapWeekdays'] : $snapWeekDays = '';

		isset($_REQUEST['snapStartTime']) ? $snapTimeArray = $_REQUEST['snapStartTime'] : $snapTimeArray = '';

		isset($_REQUEST['snapSelectedMinimumPercentage']) ? $snapMinimumPercentacge = $_REQUEST['snapSelectedMinimumPercentage'] : $snapMinimumPercentacge = 0;

	 

		$globalSnapSendType = 3;		

		$additional_data = array('first_name'=>$first_name,'last_name'=>$last_name,'City'=>$city,'phone'=>$emailnotice_phone,'Zip'=>$zipcode,'Address'=>$state."<br/>".$cellphone1."<br/>".$cellphone2,'company'=>'','Zone_ID' => $zone_id);

		$data_peekaboo_bidder=array(

			     'fName'=>$first_name,

				 'lName'=>$last_name,

				 'email'=>$email,

				 'city_name'=>$city,

				 'state_name'=>$state,

				 'phone'=>$emailnotice_phone,

			     'user_name'=>$username,

				 'password'=>sha1($password),

				 'register_date'=>time(),

				 'balance'=>20,

				 'activated'=>'yes',

				 'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),

				 'member_type'=>1
 

			);

			$this->db->insert('tbl_member', $data_peekaboo_bidder);

       		$data_peekaboo_bidder_id = $this->db->insert_id();

     
		

		

		$accountGroups = array();

		$accountGroups[] = $user_type;

	    $data['emailnoticeuser']=$this->ion_auth->registerreferal($username, $password, $email, $additional_data, $accountGroups,'',$emailnotice_phone, $carrier, $cellPhone,$referraluser,$zone_id);		 

		 
		$remember=''; 

		$zone_id = $_REQUEST['zone_id'];

		$get_zone_details = $this->email_notice->getZonedetails($zone_id);

		$short_url = $get_zone_details['short_url'];

		$zone_name = $get_zone_details['name'];

		// select the organisation
        if($refferalcode){

        $sql = "SELECT organization.id FROM `users` LEFT JOIN users_groups ON users_groups.user_id = users.id LEFT JOIN organization ON organization.userid = users.id WHERE users_groups.group_id = 8 AND users.referral_code = '".$refferalcode."'";


        $query=$this->db->query($sql);
	          
	    $organization_id=$query->result();

	    $id = $organization_id[0]->id;
	    
		    if ($id) {
		    	$data_org1=array('userid' => $data['emailnoticeuser'],'zoneid'=>$zone_id,'org' => $id); 
				$this->db->insert('tbl_selected_nonorg', $data_org1);
				$id = $insert_id = $this->db->insert_id();
		    }
		
      	}

 

 
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
		$par_for_ig=array('user_id'=>$data['emailnoticeuser'],'createdby_id'=>$createdby_id,'zone_id'=>$zone_id,'type'=>$type,'offer_type'=>$offer_type);
		 

		echo($this->dr->GetDR("","", $par_for_ig, "0")); 


 

	}



	
//  visitor regsiteration 
	function visitornoticeinsertdata(){
	 
 
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

		isset($_REQUEST['user_type']) ? $user_type=$_REQUEST['user_type'] : $user_type='';

		//Added on 29/5/14

		isset($_REQUEST['emailnotice_phone']) ? $emailnotice_phone=$_REQUEST['emailnotice_phone'] : $emailnotice_phone='';			

		isset($_REQUEST['carrier']) ? $carrier=$_REQUEST['carrier'] : $carrier='';

		//Added on 23/02/18

		isset($_REQUEST['cell_phone']) ? $cellPhone=$_REQUEST['cell_phone'] : $cellPhone='';



		//Added on 29/5/14

		isset($_REQUEST['password']) ? $password=$_REQUEST['password'] : $password='';

		isset($_REQUEST['group']) ? $group=$_REQUEST['group'] : $group='';

		isset($_REQUEST['createdby_id']) ? $createdby_id=$_REQUEST['createdby_id'] : $createdby_id='';

		isset($_REQUEST['zone_id']) ? $zone_id=$_REQUEST['zone_id'] : $zone_id='';

		isset($_REQUEST['refferalcode']) ? $refferalcode=$_REQUEST['refferalcode'] : $refferalcode='';

		isset($_REQUEST['type']) ? $type=$_REQUEST['type'] : $type='';

		isset($_REQUEST['offer_type']) ? $offer_type=$_REQUEST['offer_type'] : $offer_type='';

		isset($_REQUEST['emailvalidation']) ? $emailvalidation=$_REQUEST['emailvalidation'] : $emailvalidation='';

		isset($_REQUEST['selected_orgcategory']) ? $selected_category = $_REQUEST['selected_orgcategory'] : $selected_category = '';

		isset($_REQUEST['globalSnapStatus']) ? $glbalSnapStatus = $_REQUEST['globalSnapStatus'] : $glbalSnapStatus = '';

		isset($_REQUEST['snapWeekdays']) ? $snapWeekDays = $_REQUEST['snapWeekdays'] : $snapWeekDays = '';

		isset($_REQUEST['snapStartTime']) ? $snapTimeArray = $_REQUEST['snapStartTime'] : $snapTimeArray = '';

		isset($_REQUEST['snapSelectedMinimumPercentage']) ? $snapMinimumPercentacge = $_REQUEST['snapSelectedMinimumPercentage'] : $snapMinimumPercentacge = 0;

	 

		$globalSnapSendType = 3;

		 

		

		$additional_data = array('first_name'=>$first_name,'last_name'=>$last_name,'City'=>$city,'phone'=>$emailnotice_phone,'Zip'=>$zipcode,'Address'=>$state."<br/>".$cellphone1."<br/>".$cellphone2,'company'=>'','Zone_ID' => $zone_id);

		$data_peekaboo_bidder=array(

			     'fName'=>$first_name,

				 'lName'=>$last_name,

				 'email'=>$email,

				 'city_name'=>$city,

				 'state_name'=>$state,

				 'phone'=>$emailnotice_phone,

			     'user_name'=>$username,

				 'password'=>sha1($password),

				 'register_date'=>time(),

				 'balance'=>20,

				 'activated'=>'yes',

				 'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),

				 'member_type'=>1,

				 'fromreferrer' => $refferalcode

			);

			$this->db->insert('tbl_member', $data_peekaboo_bidder);

       		$data_peekaboo_bidder_id = $this->db->insert_id();

       		if($data_peekaboo_bidder_id>0){

       			$data_member_credit=array(

			     'member_id'=>$data_peekaboo_bidder_id,

				 'credit_type'=>'c',

				 'credit'=>10,

				 'created_at'=>now()

			);

			$this->db->insert('tbl_member_credit', $data_member_credit);

       		}	

		

		

		$accountGroups = array();

		$accountGroups[] = $user_type;

	    $data['emailnoticeuser']=$this->ion_auth->register($username, $password, $email, $additional_data, $accountGroups,'',$emailnotice_phone, $carrier, $cellPhone);		 

		 
		$remember='';

		if ($this->ion_auth->login($email, $password, $remember)){

			$session_normal_user_in_zone = array('sesuserzone'=>$zone_id,'sesusertype'=>'resident_user');                   		

        	$this->session->set_userdata('session_normal_user_in_zone',$session_normal_user_in_zone);

			$usersession_data = $this->session->userdata('session_normal_user_in_zone');
 

		}

		$zone_id = $_REQUEST['zone_id'];


		// select the organisation
        if($refferalcode){

        $sql = "SELECT organization.id FROM `users` LEFT JOIN users_groups ON users_groups.user_id = users.id LEFT JOIN organization ON organization.userid = users.id WHERE users_groups.group_id = 8 AND users.referral_code = '".$refferalcode."'";


        $query=$this->db->query($sql);
	          
	    $organization_id=$query->result();

	    $id = $organization_id[0]->id;
	    
		    if ($id) {
		    	$data_org1=array('userid' => $data['emailnoticeuser'],'zoneid'=>$zone_id,'org' => $id); 
				$this->db->insert('tbl_selected_nonorg', $data_org1);
				$id = $insert_id = $this->db->insert_id();
		    }
		
      	}



		$get_zone_details = $this->email_notice->getZonedetails($zone_id);

		$short_url = $get_zone_details['short_url'];

		$zone_name = $get_zone_details['name'];

		if($short_url!='')

			$zone_url = $short_url;

		else

			$zone_url = 'http://savingssites.com/zone/'.$get_zone_details['seo_zone_name'];

 
		if(!empty($emailvalidation)==1){
 

					$message_body =	'<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">

								<div style="width:960px; margin:0 auto !important;">

								<div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">

								<div style="background-color:#3f3f3f; height:70px;"><h1 style="color: #fff;padding-left: 9px;">'.$zone_name.'</h1><br>

								<p style="color: #fff;margin-top: -14px;padding-left: 22px;">powered by <b>SavingsSites</b></p>

								</div>

								<div style="clear:both"></div>

								<div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:300px; padding:15px;">

								<h2 style="text-align:left;">Dear '.$first_name." ".$last_name.',<br>'. 

								'</h2><h3><p style="text-align:left; display:block; color:#333;">Thank you for signing up with '.$zone_name.'.<br>Below are your registered details:</h3>

								<h3><p style="text-align:left; display:block; color:#333;">Username: '.$username.' </p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">First Name: '.$first_name.'	</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Last Name: '.$last_name.'</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Telephone: '.$emailnotice_phone.'</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Email: '.$email.'</p></h3>

								<h3><p style="text-align:left; display:block; color:#333;">Best Regards,<br />

								'.$zone_name.'<br/>'.

								"<a href='{$zone_url}'>{$zone_url}</a>".

								'</h3>

								</div>

								<div style="background-color:#999; height:60px;"></div>

								</div>

								</div>

								</body>';

			

								$fromemail=$this->config->item('adminEmailId');

								$this->load->library('email');

								$template_subject="New Registration";

								$this->email->clear();

								$this->email->from($fromemail);

								$this->email->to($email);

								$this->email->subject($template_subject);

								$this->email->message($message_body);

								$this->email->send();

		 }

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		

		$par_for_ig=array('user_id'=>$data['emailnoticeuser'],'createdby_id'=>$createdby_id,'zone_id'=>$zone_id,'type'=>$type,'offer_type'=>$offer_type);

		echo($this->dr->GetDR("","", $par_for_ig, "0")); 
 

	}



	//++++++++++++++++++++++++++++++++++++++++++++EMAIL SIGN UP SECTION ENDED++++++++++++++++++++++++++++++++++++++++++++//

	

	//++++++++++++++++++++++++++++++++++++++++++++Voice Broadcast Start++++++++++++++++++++++++++++++++++++++++++++//

	function create_broadcast(){

		$data=array();

		$data['createdby_id']=isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;		

		$data['zoneid']=isset($_REQUEST['zoneid'])? $_REQUEST['zoneid'] : 0; 

		$data['type']=isset($_REQUEST['type']) ? $_REQUEST['type'] : 0 ; 

		$result = $this->load->view('emailnotice/create_email_notice', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function save_broadcast(){

		$data=array();

		$data['zoneid'] = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;   

		$data['createdby_id'] = !empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['broadcast_title'] = !empty($_REQUEST['broadcast_title']) ? $_REQUEST['broadcast_title'] : 0;		 	

		$data['offer_percent'] = !empty($_REQUEST['offer_percent']) ? $_REQUEST['offer_percent'] : 0;

		$data['offer_date'] = !empty($_REQUEST['offer_date']) ? $_REQUEST['offer_date'] : date();

		$data['createdby_type'] = !empty($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0;		

		$data['broadcast_id'] = !empty($_REQUEST['broadcast_id']) ? $_REQUEST['broadcast_id'] : '';

		$data['offer_times'] = !empty($_REQUEST['offer_times']) ? $_REQUEST['offer_times'] : '';

		$data['status'] = 1;

		//var_dump($data); exit;

		$save_broadcast=$this->email_notice->save_broadcast($data);

		if(!empty($save_broadcast) && $save_broadcast=='update')

		{

			$message="Broadcast is updated successfully!";

		}

		else if($save_broadcast=='insert')

		{

			$message="New Broadcast is Successfully created!";

		}

		else

		{

			echo 'Not succesfully done';

		}

		echo($this->dr->GetDR("Save Successful", $message,$save_broadcast, "0"));

	}

	

	function edit_broadcast(){ 

		$data['broadcast_id'] = isset($_REQUEST['broadcast_id']) ? $_REQUEST['broadcast_id'] : 0 ;

		$data['zoneid'] = isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$data['createdby_id'] = isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['createdby_type'] = isset($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0 ;

		$data['en_details']	= $this->email_notice->edit_broadcast($data['broadcast_id'],$data['zoneid'],$data['createdby_id'],$data['createdby_type']);

		//var_dump($data['group_details']); exit;

		$result = $this->load->view('emailnotice/edit_broadcast', $data, true);  	

		//$result = $this->load->view('business/edit_email_notice', $data, true);	// added on 09/07/14

		echo($this->dr->GetDR("","", $result, "0"));

	}

	

	function delete_broadcast(){ 			

		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0 ; //var_dump($id); exit;

		$is_delete=$this->email_notice->delete_broadcast($id); //var_dump($is_delete);

		echo($this->dr->GetDR("","",$id, "0"));

	}

	

	function display_all_broadcasts(){ 

		$data=array();

		$data['zoneid']=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;		

		$data['createdby_id']=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['createdby_type']=!empty($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0;

		$data['show_en_status_type']=!empty($_REQUEST['show_en_status_type'])? $_REQUEST['show_en_status_type'] : 0; //var_dump($data);

		$data['display_all_broadcasts']=$this->email_notice->display_all_broadcasts($_REQUEST['zoneid'],$data['createdby_id'],$data['createdby_type'],$data['show_en_status_type']);        //var_dump($data['display_all_email_notice']); exit;

		$result = $this->load->view('emailnotice/display_all_broadcasts', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	

	//++++++++++++++++++++++++++++++++++++++++++++Voice Broadcast Ends++++++++++++++++++++++++++++++++++++++++++++//

	

	### Email notice from business dashboard part start 

	function create_email_notice(){

		$data=array();

		$data['createdby_id']=isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;		

		$data['zoneid']=isset($_REQUEST['zoneid'])? $_REQUEST['zoneid'] : 0; 

		$data['type']=isset($_REQUEST['type']) ? $_REQUEST['type'] : 0 ; 

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

		//var_dump($data); exit;

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

		$data['createdby_id']=isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;		

		$data['zoneid']=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;

		$data['createdby_type']=isset($_REQUEST['createdby_type'])? $_REQUEST['createdby_type'] : 0;

		//$result = $this->load->view('emailnotice/view_email_notice', $data, true);	commented on 09/07/14

		$result = $this->load->view('business/view_email_notice', $data, true);		// added on 09/07/14

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function display_all_email_notice(){ 

		$data=array();

		$data['zoneid']=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;		

		$data['createdby_id']=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['createdby_type']=!empty($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0;

		$data['show_en_status_type']=!empty($_REQUEST['show_en_status_type'])? $_REQUEST['show_en_status_type'] : 0; //var_dump($data);

		$data['display_all_email_notice']=$this->email_notice->display_all_email_notice($_REQUEST['zoneid'],$data['createdby_id'],$data['createdby_type'],$data['show_en_status_type']);        //var_dump($data['display_all_email_notice']); exit;

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

		$result=$this->load->view('business/send_email_notice',$data,true);

		//$result=$this->load->view('emailnotice/view_send_notice',$data,true);

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

		$data['iggroupemail']=$this->email_notice->get_ig_email($data['zone_id'],$data['createdby_id'],$data['selectNotce'],$data['iggroup'],$data['createdby_type']);		// var_dump($data['iggroupemail']); exit;

		$data['iggroupname']=$this->email_notice->get_ig_group_name($data['zone_id'],$data['createdby_id'],$data['selectNotce'],$data['iggroup'],$data['createdby_type']);		

		

		//echo '<pre>'; print_r($data['groupnotice']);

		$result=$this->load->view('emailnotice/show_email_box',$data,true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function send_mail_to_all_group(){ 

		$data=array();

		$arr_ig_id = array();

		$arr1_ig_name = array();

		$data['zone_id']=isset($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0 ;

		$data['createdby_id']=isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['mailtosent']=isset($_REQUEST['mailtosent']) ? $_REQUEST['mailtosent'] : 0 ;

		$data['subject']=$_REQUEST['subject'];

		$data['detail']=$_REQUEST['detail'];

		$data['all_groupname']=$_REQUEST['all_groupname'];

		$data['all_ig_id']=$_REQUEST['all_ig_id'];

		isset($_REQUEST['createdby_type']) ? $data['createdby_type']=$_REQUEST['createdby_type'] : $data['createdby_type']='';

		/* new */ 

		$arr_ig_id = explode(',',$_REQUEST['all_ig_id']);

		$arr1_ig_name = explode(',',$_REQUEST['all_groupname']);

		$data['ig_data'] = array_combine($arr_ig_id,$arr1_ig_name); // var_dump($data['ig_data']); exit;

		$mailtosend = $this->email_notice->get_email_by_ig($data['ig_data'],$data['zone_id'],$data['createdby_type']); // for mail only

		$texttosend = $this->email_notice->get_phone_by_ig($data['ig_data'],$data['zone_id'],$data['createdby_type']); // for sms only

		$mailtexttosend = $this->email_notice->get_email_phone_by_ig($data['ig_data'],$data['zone_id'],$data['createdby_type']); // for both mail and sms only



	    $result=$this->email_notice->send_mail_to_all_group($data['zone_id'],$data['createdby_id'],$data['mailtosent'],$data['subject'],$data['detail'],$data['createdby_type'],$data['all_groupname'],$data['all_ig_id'],$mailtosend);	 // for email only

	

		

		/* new */

		//$result=$this->email_notice->send_mail_to_all_group($data['zone_id'],$data['createdby_id'],$data['mailtosent'],$data['subject'],$data['detail'],$data['createdby_type'],$data['all_groupname'],$data['all_ig_id'],$mailtosend);	 // for email only

		

		//$result1=$this->email_notice->send_text_to_all_group($data['zone_id'],$data['createdby_id'],$data['mailtosent'],$data['subject'],$data['detail'],$data['createdby_type'],$data['all_groupname'],$data['all_ig_id'],$texttosend);	 // for email only

		

		//$result2=$this->email_notice->send_email_and_text_to_all_group($data['zone_id'],$data['createdby_id'],$data['mailtosent'],$data['subject'],$data['detail'],$data['createdby_type'],$data['all_groupname'],$data['all_ig_id'],$mailtexttosend);	 // for both email and text only

		echo($this->dr->GetDR("","", $result, "0"));	

		

	}	

	function edit_en(){ 

		$data['notice_id'] = isset($_REQUEST['notice_id']) ? $_REQUEST['notice_id'] : 0 ;

		$data['zoneid'] = isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$data['createdby_id'] = isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$data['createdby_type'] = isset($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0 ;

		$data['en_details']	= $this->email_notice->edit_en($data['notice_id'],$data['zoneid'],$data['createdby_id'],$data['createdby_type']);

		//var_dump($data['group_details']); exit;

		$result = $this->load->view('emailnotice/edit_en', $data, true);  	

		//$result = $this->load->view('business/edit_email_notice', $data, true);	// added on 09/07/14

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function delete_en(){ 			

		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0 ; //var_dump($id); exit;

		$is_delete=$this->email_notice->delete_en($id); //var_dump($is_delete);

		echo($this->dr->GetDR("","",$id, "0"));

	}

	function view_email_notice_history(){

		$data=array();

		$data['createdby_id']=isset($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0 ;

		$data['zoneid']=isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$data['createdby_type']=isset($_REQUEST['createdby_type']) ? $_REQUEST['createdby_type'] : 0 ;

		$data['email_history']=$this->email_notice->view_email_notice_history($data['createdby_id'],$data['zoneid'],$data['createdby_type']);

		$result=$this->load->view('emailnotice/view_email_notice_history',$data,true);

		echo($this->dr->GetDR("","",$result,"0"));

	}

	function delete_history(){

		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0 ; //var_dump($id); exit;

		$is_delete=$this->email_notice->delete_history($id); //var_dump($is_delete);

		echo($this->dr->GetDR("","",$id, "0"));

	}

	

	function view_detail_email_history(){

		$data=array();

		$data['id']= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0 ; //var_dump($id); exit;

		$data['detail_history']=$this->email_notice->view_detail_email_history($data['id']); //var_dump($is_delete);

		$result=$this->load->view('emailnotice/view_detail_email_history',$data,true);

		echo($this->dr->GetDR("","",$result, "0"));

		

		}

		

		/*

		 *	Get selected ( by resident user ) category of an organization

		 *

		 */

		function selected_orgcategory_byloggeduser(){

			$data=array();

			$data['zone_id']				=	!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;

			$data['createdby_id']			=	!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

			$data['createdby_type']			=	!empty($_REQUEST['type']) ? $_REQUEST['type'] : 0;

			$data['user_id']				=	!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;		

			/*$data['active_group_display']	=	$this->email_notice->active_group_display($data['zone_id'],$data['createdby_id'],$data['createdby_type'],$data['user_id']);*/ 

			

			$data['selected_category']		=	$this->email_notice->selectedcategoryoforganization($data['zone_id'],$data['createdby_id'], $data['user_id']);

			// for ORG texting		

			//echo '<pre>';print_r($data);

			echo json_encode($data);

		}

		

		/*

		 *	Change organization category status

		 *

		 */

		function update_orgcategorystatus(){

			$data=array();

			$zone_id			=	!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;

			$category_id		=	!empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : 0;

			$user_id			=	!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;		

			

			$updatestatus		=	$this->email_notice->changeorganizationcategorystatus($zone_id, $user_id, $category_id);

			

			echo $updatestatus ;

		}

	

}



?>