<?php
namespace App\Controllers;
require_once APPPATH . "/Libraries/PHPMailer-master/src/PHPMailer.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/Exception.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/SMTP.php";
use App\Libraries\IonAuth;
use App\Libraries\PHPMailer_Lib;
use Config\MyConfig;
use App\Models\zone\Zone_model;
use App\Models\admin\Business;
use App\Models\admin\Ads_model;
use App\Models\admin\Announcement_model;
use App\Controllers\CommonController;
use App\Models\admin\Sales_zone;
use App\Models\admin\Category_management_model;
use App\Models\Statistics;
use App\Models\States;
use App\Models\banner\Banner_model;
use App\Models\organization\Organization_model;
use App\Models\Category_new_model;
use PHPMailer\PHPMailer\PHPMailer;
use App\Controllers\CronController;
use PHPMailer\PHPMailer\Exception;
#[\AllowDynamicProperties]
class Organizationdashboard extends BaseController{
    public function __construct(){
		$this->myconfig = new MyConfig;
    	$this->db = \Config\Database::connect();
    	$this->email = \Config\Services::email();
    	$this->ion_auth = $this->ionAuth = new \IonAuth\Libraries\IonAuth();
    	$this->session = \Config\Services::session();
    	$this->Zone_model = new Zone_model();
    	$this->Business = new Business();
    	$this->SalesZone = new Sales_zone();
    	$this->CommonController = new CommonController();
    	$this->Ads_model = new Ads_model();
    	$this->Statistics = new Statistics();
    	$this->States = new States();
    	$this->CronController = new CronController();
    	$this->Banner_model = new Banner_model();
    	$this->Category_new_model = new Category_new_model();
    	$this->Category_management_model = new Category_management_model();
    	$this->Organization_model = new Organization_model();
    	$this->Announcement_model = new Announcement_model();
    }	
// public function __construct()

    // {

		

    //     parent::__construct();

	// 	$this->clear_cache();

        

	// 	$this->load->library('ion_auth');

    //     $this->load->library('session');

    //     $this->load->library('form_validation');

	// 	$this->load->library('pagination');

	// 	$this->load->library('excel');

        

	// 	$this->load->helper('url');

    //     $this->load->helper('ckeditor');

    //     $this->load->helper("time_helper");

    //     $this->load->helper('cookie');

	// 	$this->load->helper('url');

	// 	$this->load->helper('download');

	// 	$this->load->model("States","states");

    //     $this->load->model("Statistics","statistics");

    //     $this->load->model("admin/Users", "users");

    //     $this->load->model("Dialog_result", "dr");

    //     $this->load->model("admin/Category_model", "category");

    //     $this->load->model("admin/Announcement_model", "announcements");

    //     $this->load->model("admin/Ads_model", "ads");

    //     $this->load->model("admin/Sales_zone", "sales_zone");

    //     $this->load->model("admin/Business", "business");

	// 	$this->load->model("Zips", "zip");	

	// 	////$this->load->model("admin/business_dashboard1", "business_dashboard1");

    //     $this->load->model("admin/Templates", "template");

    //     $this->load->model("admin/Business_type_model", "business_type");

	// 	$this->load->model("admin/Category_management_model", "category_model");

	// 	$this->load->model("Category_new_model","category_new_model");

	// 	$this->load->model("emailnotice/Email_notice", "email_notice");

	// 	//$this->load->model("Organization_model", "org_model");

	// 	// new model

	// 	$this->load->model("organization/Organization_model", "org_model");

	// 	//$this->load->model("organization/webinar_organization", "webinar_organization");

	// 	$this->load->model("zone/Zone_model", "zone_model");

		

	// 	$this->load->model("User", "user");

		

	// 	$this->load->config('security', TRUE);		

	// 	$this->load->database();

		

    // }

	function clear_cache(){    

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma: no-cache");

    }

    public function index(){    

        echo("Index works..");

        $this->load->view("dashboards/zone_dashboard");		

    }
	
	public function common_first($org_id=0,$fromzoneid=0){
		$data=array();
		$data['businessid'] = '';
		$data['realtorid'] = '';
		$uid = 0;
		$user = $this->ion_auth->user()->row();
		if(!empty($user)){ $uid = $user->id;}
		if (empty($user)) {
			return redirect()->to(base_url());
		}
		
		$data['where_from']='organization';
		$data['from_zoneid']=isset($fromzoneid) ? $fromzoneid : 0;
		$fromzoneid = 0;
		if($data['from_zoneid']!=0){
			$data['top_header_name']=$this->Zone_model->get_zone($data['from_zoneid']);
			$data['sub_header_name_from_zone']=$this->Organization_model->organization_details($org_id);
			$data['from_where']='zone_organization'; 
		}else{
			$data['top_header_name']=$this->Organization_model->organization_details($org_id);
			$data['sub_header_name_from_zone']=''; $data['from_where']='';
		}
		
		$data['user'] = $user;		
		$data['uid']= $uid; 
		$data["usergroup"]=$this->Business->get_user_group1($uid);
		$usergrid=$data["usergroup"]->group_id;
		
		if(!empty($user)){
			$data["email"] = $user->email;
			$data["firstName"] = $user->first_name;
			// $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";
		}

		$data['organizationid']=$org_id;  
		$organization_status= $this->Announcement_model->organization_status($org_id); 
		$data['organization_status']= isset($organization_status[0]['approval'])?$organization_status[0]['approval']:'';
		$data['zone']=$this->Announcement_model->organization_zone($org_id);
		$userzoneid= isset($data['zone'][0]['zoneid'])?$data['zone'][0]['zoneid']:''; 
		$data['org_name']= isset($data['zone'][0]['name'])?$data['zone'][0]['name']:'';
		$data['org_owner_id']= isset($data['zone'][0]['userid'])?$data['zone'][0]['userid']:''; 
		$data['zoneid']=$userzoneid; 
		$data['getall_category']=$this->Announcement_model->getall_category($org_id); 
		$session_login_details= $this->CommonController->getSession('session_login_details');
		$data['login_type']=$session_login_details['type'];
		$data['login_id']=$session_login_details['id'];//var_dump($data['login_id']);exit;

		$check_valid_url= $this->ion_auth->check_valid_url_other($uid,$userzoneid,$org_id,$fromzoneid,$data['where_from']);
		// var_dump($check_valid_url);exit;
		$check_zoneid = $this->CommonController->getSession('session_zoneid');
		$session_orgid = $this->CommonController->getSession('session_orgid');
		$sesorgid = $session_orgid['sesorgid'];
		$valid_zoneid = $check_zoneid['userzoneid'];
		if($check_valid_url==0){
			if($data['from_zoneid']!=0){
				return redirect()->to(base_url().'/Zonedashboard/zonedetail/'.$valid_zoneid);
			}else{
				return redirect()->to(base_url().'/organizationdashboard/organizationdetail/'.$org_id.'/'.$sesorgid);
			}
		}
		$newsessiondata = array(
			'usergrid'=>$usergrid,
			'userzoneid'=>$userzoneid
		);
		$this->CommonController->setSession('usersessiondata', $newsessiondata);
		return $data;
	}

	

	function common($info){		

		 // $data['left_container'] = $this->load->view("default/common/left_panel_organization", $info, true); 

		$data['side_dashboard_container'] = $this->load->view("default/common/left_panel_organization", $info, true); 

        $data['content'] = $this->load->view("content_new", $data, true);

		$data['header']= $this->load->view("default/common/header", $data);

		

	}
	
	public function organizationdetail($org_id=false,$fromzoneid=0){ 
		$this->CronController->rankbusiness($fromzoneid);
		$this->CommonController->SetCookie('orgid',$org_id,time()+86500,'','/','');
		$user = $this->ionAuth->user()->row();
	   	$uid = 0;
	   	if(!empty($user)){ $uid = $user->id;} 
        $usergroup=$this->Business->get_user_group1($uid);
        $group_id = $usergroup->group_id;  
        $lowerlimit=0; $upperlimit=100;
        $payment_module_id = 6;

        $orgyearsum = [];

		$pagesidebar = isset($_GET['page'])?$_GET['page']:'organizationdetail';
		$zone_name ='';
		$zoneid = '';
		$org_owner_id = '';
		$organization_status = '1';
		$from_zoneid = '';
		
		$username ='';
		$user_id  = '';
		$refer_code = '';
		$zone_id = '';
	   	$via = '';
	   	$login_type = '';
	   	$organizationid = '';
	   	// sub_header_name_from_zone [name] = '';
	   	$referralCode = '';
	   	$right_container = '';
	   	$x = '';//isset($this->CommonController->getSession('business_search_value'))?$this->CommonController->getSession('business_search_value'):'';	









		$zone= $this->Zone_model->get_zone($fromzoneid);
	   	$zone_owner = $this->ion_auth->user($zone['sales_rep_id'])->row();
	   	$referralCode = $this->SalesZone->get_referral_organisation_code($org_id);
	   	$organization_owner_detail=$this->Organization_model->organization_owner_details($org_id);
	   	$state_list = $this->States->get_state_dropdown();
	   	$common=$this->common_first($org_id,$fromzoneid);
	   	$data['usersid']=$common['org_owner_id'];
		$data['zoneid'] = $common['zoneid'] ;
	   	$webniar_exist = $this->Announcement_model->webniar_exist($data['usersid'],$data['zoneid']);
		$getall_category = $this->Announcement_model->getall_category($org_id); 
		$pboo_credit_payment_data = $this->Organization_model->get_org_pboo_credit_request($org_id,$payment_module_id);
		$details_payment_list = $this->Organization_model->get_payment_details($org_id);
		$jotform_category_data = $this->Organization_model->fetch_jotform_organizationcategory($org_id);



		$announcement_list = $this->Announcement_model->get_announcements_for_organization($fromzoneid,$org_id,$lowerlimit,$upperlimit);
		$countallannouncements = count($announcement_list);
		if($countallannouncements<1){		
			$countallannouncements = 0;		
		}
		// $lowerlimit=$lowerlimit+5;				

			$limit=$lowerlimit.','.$upperlimit;	
		
		$builder = $this->db->table('zipcode as a');
        $builder->select('a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name');
        $builder->join('zip_code_zone as b', 'a.zip = b.zip_code');
        $builder->join('states as c', 'a.state = c.code');
        $builder->orderBy('state', 'ASC');
        $builder->groupBy('state');
        $query = $builder->get();
        $get_all_states = $query->getResult();


        $monthwisecountfavorg = $totalsumfavorg = [];
        if($pagesidebar == 'organizationfeereport'){
        	$pbcashqry="SELECT userId,zoneId,amountPurchased,purchasedAt,certificate_verify FROM tbl_deals_purchased_meta WHERE  zoneId='".$fromzoneid."'";
			$purchasedArr = $this->CommonController->SelectRawquery($pbcashqry);
			
			$nonfavperqry="SELECT nonfavorgper,id FROM  users WHERE  Zone_ID='".$fromzoneid."'";
			$nonfavperArr = $this->CommonController->SelectRawquery($nonfavperqry,'row');
			$nonfavper = isset($nonfavperArr->nonfavorgper)?$nonfavperArr->nonfavorgper:0;

			$totalorgqry="SELECT c.id FROM users as a INNER JOIN  users_groups as b ON a.id=b.user_id INNER JOIN organization as c ON a.id=c.userid LEFT JOIN org_fee as d ON a.id=d.user_id WHERE  a.zone_ID='".$fromzoneid."' AND b.group_id=8";
			$totalorgArr = $this->CommonController->SelectRawquery($totalorgqry,'resultArray');
			$totalorgcount = count($totalorgArr);

			$org_fee = 0;
			foreach ($purchasedArr as $k => $v) {
				$favorgqry="SELECT org_id FROM  users_fav_org WHERE  zone_id='".$v['zoneId']."' AND user_id='".$v['userId']."'";
				$favorgArr = $this->CommonController->SelectRawquery($favorgqry,'row');
				$orgfavid = isset($favorgArr->org_id)?$favorgArr->org_id:'';
				$purchasedArr[$k]['user_fav_org'] = $orgfavid;
				$favorgperqry="SELECT fee_per FROM  org_fee WHERE  zone_id='".$v['zoneId']."' AND org_id='".$orgfavid."'";
				$favorgperArr = $this->CommonController->SelectRawquery($favorgperqry,'row');
				$orgper = isset($favorgperArr->fee_per)?$favorgperArr->fee_per:'';
				$purchasedArr[$k]['user_fav_org_per'] = $orgper;
				if($v['amountPurchased'] > 0 && $orgper > 0){
					$org_fee = $v['amountPurchased']*$orgper/100;	
				}
				$purchasedArr[$k]['user_fav_org_fee'] = $org_fee;
			}
			if(count($purchasedArr) > 0){
				foreach ($purchasedArr as $k1 => $v1) {
					$month = date('m', strtotime($v1['purchasedAt']));
					$monthwisecountfavorg[$month][] = $v1;
				}
				
				if(count($monthwisecountfavorg) > 0){
					foreach ($monthwisecountfavorg as $k3 => $v3) {
						$sumfavuser = 0;
						$sumfavorg = 0;
						foreach ($v3 as $k4 => $v4) {
							$orgcomission = 0;
							if($v4['user_fav_org'] > 0){
								if($v4['user_fav_org'] == $org_id){
									$orgcomission = $v4['user_fav_org_fee'];
								}else{
									$orgcomission = $v4['user_fav_org_fee']/$totalorgcount;
								}
							}else{
								if($v4['amountPurchased'] > 0 && $nonfavper > 0){
									$orgcomissionper = ($v4['amountPurchased']*$nonfavper)/100;
									$orgcomission = $orgcomissionper/$totalorgcount;	
								}
							}
							$sumfavuser += $v4['amountPurchased'];	
							$sumfavorg += $orgcomission; 	
						}
						$orgyearsum[] = $sumfavorg;
						$totalsumfavorg[$k3] = array(
							'useramountsum' => $sumfavuser,
							'orgfavsumfee' => $sumfavorg,
							'zone_id' => $v4['zoneId'],
							'totalorg' => $totalorgcount
						);
					}
				}
			}	
        }
		$payment_module_id = 6;
		if(isset($_REQUEST['brodcastid']) && $_REQUEST['brodcastid'] > 0){
			$announcement_list = $this->Announcement_model->display_all_broadcasts($common['zoneid'],$org_id,$_REQUEST['brodcastid']);
		}else{
			$announcement_list = $this->Announcement_model->display_all_broadcasts($common['zoneid'],$org_id);
		}
		$jotform_category_data = $this->Organization_model->fetch_jotform_organizationcategory($org_id);
		$details_payment_list = $this->Organization_model->get_payment_details($org_id);


    	$pboo_credit_payment_data = $this->Organization_model->get_org_pboo_credit_request($org_id,$payment_module_id);
		$pboo_credit_account_id = $this->Organization_model->get_org_pboo_credit_account($org_id);
		return view('organizationdashboard',array('org_id'=>$org_id,'pagesidebar'=>$pagesidebar,'zone_name'=> $zone_name,'zoneid'=> $zoneid,'org_owner_id'=> $org_owner_id,'organization_status'=> $organization_status,'from_zoneid'=> $from_zoneid,'group_id'=> $group_id,'username'=> $username,'user_id'=> $user_id,'refer_code'=> $refer_code,'zone_id'=> $zone_id,'zone_owner'=> $zone_owner,'via'=> $via,'login_type'=> $login_type,'organizationid'=> $organizationid,'referralCode'=> $referralCode,'organization_owner_detail'=> $organization_owner_detail,'state_list'=> $state_list,'common'=> $common,'webniar_exist'=> $webniar_exist,'fromzoneid'=> $fromzoneid,'getall_category'=> $getall_category,'countallannouncements'=> $countallannouncements,'limit'=> $limit,'right_container'=> $right_container,'organization_id'=> $org_id,'pboo_credit_payment_data'=> $pboo_credit_payment_data,'x'=> $x,'details_payment_list'=> $details_payment_list,'jotform_category_data'=> $jotform_category_data,'get_all_states'=> $get_all_states,'uid'=> $uid,'totalsumfavorg'=> $totalsumfavorg,'orgyearsum'=> $orgyearsum,'announcement_list'=> $announcement_list,'jotform_category_data'=> $jotform_category_data,'details_payment_list'=> $details_payment_list,'pboo_credit_payment_data'=> $pboo_credit_payment_data,'pboo_credit_account_id'=> $pboo_credit_account_id));		
	}

# - This will show the dashboard of an Organization 



# + update profile
	public function update_profile(){ 
		$userid    = $_REQUEST['userid'];
		$email     = $_REQUEST['email'];
		$firstname = $_REQUEST['firstname'];
		$lastname  = $_REQUEST['lastname'];
		$phone     = $_REQUEST['phone'];
		$address   = $_REQUEST['address'];
		$city      = $_REQUEST['city'];
		$state     = $_REQUEST['state'];
		$zip       = $_REQUEST['zip'];
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
		$this->CommonController->updateData('users',$userData,['id' => $userid]);
		echo json_encode(['msg'=>'Orgnization Updated Successfully','type'=>'success']);
	}

# + manage photo

	public function managephoto($org_id=false,$fromzoneid=0){ 			

		$data['common']=$this->common_first($org_id,$fromzoneid);  

		$data['right_container'] = $this->load->view("organization/managephoto", $data, true); 

		$this->common($data);

	}

	// saving new photos

	public function save_org_photo(){ 
		$image_name = isset($_REQUEST['uploadedInput']) ? $_REQUEST['uploadedInput'] : '';
		$org_id = isset($_REQUEST['organizationid']) ? $_REQUEST['organizationid'] : 0;
		$cat_id = isset($_REQUEST['allcategories']) ? $_REQUEST['allcategories'] : '';		
		$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 1;		
		$description = isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
		$this->Organization_model->save_org_photo_new($image_name,$org_id,$cat_id,$status,$description);
		echo json_encode(['msg'=>'Photo has been updated successfully','type'=>'success']);
	}
	
	public function org_photo_by_catid(){
		$cat_id = isset($_REQUEST['catid'])?$_REQUEST['catid']:'';
		$org_id = isset($_REQUEST['orgnid'])?$_REQUEST['orgnid']:'';
		$all_banner = $this->Organization_model->org_photo_by_catid($cat_id,$org_id);
		echo json_encode($all_banner);
	}

	// save uploaded image into folder

	function save_banner_image($org_id){ 

		$uploadedImage=$_FILES['imgfile']['name'];

		$var = explode('.',$uploadedImage);

		$ext = strtolower(array_pop($var));

		$imagename=time().rand().'.'.$ext;

		$rand = mt_rand( 100, 999 );

		$target = "./uploads/organizationphoto/$org_id/";

		

		if(is_dir($target)==false){

			mkdir($target,0777);

		}

		$outPutImage=$imagename;

		$target=$target.basename($outPutImage);

		$pic=($_FILES['imgfile']['name']);

	

		if(move_uploaded_file($_FILES['imgfile']['tmp_name'], $target))

		{

			$picarray=array(

			'clientImage'=>$pic,

			'uploadedImage'=>$outPutImage,

			'org_id'=>$org_id

			);

			echo json_encode($picarray);

		}else{

			echo json_encode(0);

		}

	}

	// changing the image orders for org

	public function org_photo_order_change(){ 

		$updateRecordsArray 	= $_REQUEST['order']; //var_dump($updateRecordsArray); exit;

		$org_id 				= $_REQUEST['orgnid']; 

		$cat_id					= $_REQUEST['cat_id'];

		$this->org_model->org_photo_order_change($updateRecordsArray,$org_id,$cat_id);

		

	}

	// deleting organization photos

	public function delete_org_photo(){
		$photo_id = isset($_REQUEST['photo_id']) ? $_REQUEST['photo_id'] : 0;
		$org_id = isset($_REQUEST['org_id']) ? $_REQUEST['org_id'] : 0;
		$cat_id = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 'default';
		$image_name = isset($_REQUEST['image_name']) ? $_REQUEST['image_name'] : '';
		$banner_view = $this->Organization_model->delete_org_photo($photo_id,$org_id,$cat_id,$image_name);
		echo json_encode(['msg' => 'Image Deleted Successfully','type'=>'success']);
	}

	// edit org photo

	public function edit_org_photo(){

		$data=array();

		$data['photo_id']=!empty($_REQUEST['photo_id']) ? $_REQUEST['photo_id'] : 0;

		$data['org_id']=!empty($_REQUEST['org_id']) ? $_REQUEST['org_id'] : 0;

		$data['catlist'] = $this->announcements->getall_category($data['org_id']);	//var_dump($data['catlist']); exit;

		$data['org_photo_view']=$this->org_model->org_photo_by_id($data['photo_id'],$data['org_id']); //var_dump($data['org_photo_view']); exit;

		$result = $this->load->view('organization/subpage/editphotos', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}
	
	public function update_org_photo(){
		$uploadedInput1 = isset($_REQUEST['uploadedInput1']) ? $_REQUEST['uploadedInput1'] : '';
		$cat_id = isset($_REQUEST['allcategories3']) ? $_REQUEST['allcategories3'] : '';
		$uploadedInput = isset($_REQUEST['uploadedInput']) ? $_REQUEST['uploadedInput'] : '';
		$org_id = isset($_REQUEST['org_id']) ? $_REQUEST['org_id'] : 0;
		$photo_id = isset($_REQUEST['photo_id']) ? $_REQUEST['photo_id'] : 0;
		$description = isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
		$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
		$this->Organization_model->update_org_photo($photo_id,$org_id,$description,$status,$cat_id);
		echo json_encode(['msg' => 'Image Updated Successfully','type'=>'success']);
	}

	

# - manage photo



	################################################  Organization Details Part End ######################################################

		

	################################################  Organization Category/Sub category Part Start ######################################

	// + Create New Category

	public function newcategory($org_id=false,$fromzoneid=false){		

		$data['organizationid']=$org_id;

		$data['common']=$this->common_first($org_id,$fromzoneid);		

		$data['right_container'] = $this->load->view("organization/new_category", $data, true);

		$this->common($data);

	}

	// + Create New Subc-ategory

	public function newsubcategory($org_id=false,$fromzoneid=0){

		$data['common']=$this->common_first($org_id,$fromzoneid); //var_dump($data['common']); exit;

		$data['right_container'] = $this->load->view("organization/new_subcategory", $data, true);

		$this->common($data);

	}

	// + View All Category/Subcategory

	public function allcategorysubcategory($org_id=false,$fromzoneid=0){

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/view_category_subcategory", $data, true);

		$this->common($data);

	}

	################################################  Organization Category/Sub category Part ends #######################################################

	

	################################################  Organization Announcement Part Start #################################################################

	

	public function newannouncement($org_id=false,$fromzoneid=0){				

		$data['common']=$this->common_first($org_id,$fromzoneid); //var_dump($data['common']); exit;

		$data['getall_category']=$this->announcements->getall_category($org_id); 

		$data['ckeditor'] = array(



            //ID of the textarea that will be replaced

            'id' 	=> 	'announcement_text',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"100%",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



        ));	

		

		$data['right_container'] = $this->load->view("organization/new_announcement", $data, true);

		$this->common($data);

	}

	

	public function viewannouncement($org_id=false,$fromzoneid=0){

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['fromzoneid']=$fromzoneid;  

		//var_dump($data['common']); var_dump($data['common']['zoneid']);

		//$lowerlimit=0; $upperlimit=100;

		$data['announcement_list'] = $this->announcements->get_announcements_for_organization($data['common']['zoneid'],$org_id,$lowerlimit,$upperlimit);

		//$data['announcement_list'] = $this->announcements->get_announcements_for_organization($fromzoneid,$org_id,$lowerlimit,$upperlimit); //var_dump($data['announcement_list']); exit;

		$data['right_container'] = $this->load->view("organization/view_announcement", $data, true);

		$this->common($data);

	}

	public function viewmoreannouncement($org_id=false,$fromzoneid=0,$lowerlimit=0,$upperlimit=0){ 
		$org_id = isset($_REQUEST['org_id'])?$_REQUEST['org_id']:$org_id;
		$fromzoneid = isset($_REQUEST['fromzoneid'])?$_REQUEST['fromzoneid']:$fromzoneid;
		$query = "SELECT * FROM organization_announcement WHERE orgid=".$org_id." and zoneid=".$fromzoneid." order by timestamp desc";
		$data = $this->CommonController->SelectRawquery($query);
		echo json_encode($data);
	}

	public function editannouncement($org_id=false,$fromzoneid=0,$ann_id = ''){ 

		$data['common']=$this->common_first($org_id,$fromzoneid);

		// newly added

		$data['getall_category']=$this->announcements->getall_category($org_id); 

		$data['ckeditor'] = array(



            //ID of the textarea that will be replaced

            'id' 	=> 	'announcement_text',

            'path'	=>	'assets/ckeditor',



            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"100%",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



        ));	

		//$data['announceData'] = $this->announcements->get($ann_id); 

		

		

		$data['right_container'] = $this->load->view("organization/edit_announcement", $data, true);

		$this->common($data);

	}

	################################################  Organization Announcement Part End #################################################

	

	################################################  Business Voice Broadcast Start ######################################################



	public function createBroadcast($org_id=false, $fromzoneid=0){

		$data['common']=$this->common_first($org_id,$fromzoneid); //var_dump($data['common']); exit;

		$data['getall_category']=$this->announcements->getall_category($org_id);

		$data['ckeditor'] = array(

		'id' 	=> 	'announcement_text',

		'path'	=>	'assets/ckeditor',

		'config' => array(

		'toolbar' 	=> 	"Full", 	//Using the Full toolbar

		'width' 	=> 	"100%",	//Setting a custom width

		'height' 	=> 	'100px',	//Setting a custom height

		));

		$data['right_container'] = $this->load->view("organization/new_broadcast", $data, true);

		$this->common($data);

	}

	

	public function editBroadcast($org_id=false, $fromzoneid=0, $ann_id = ''){

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['getall_category']=$this->announcements->getall_category($org_id);

		$data['announceData'] = $this->announcements->get_broadcast_by_id($ann_id);

		$data['right_container'] = $this->load->view("organization/edit_broadcast", $data, true);

		$this->common($data);

	}



	public function viewBroadcast($org_id=false, $fromzoneid=0){

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['fromzoneid']=$fromzoneid;

		$data['announcement_list'] = $this->announcements->display_all_broadcasts($data['common']['zoneid'],$org_id);

		$data['right_container'] = $this->load->view("organization/view_broadcast", $data, true);

		$this->common($data);

	}

	

	################################################  Organization Uploaded Letters Part Start ###########################################

	public function uploadedletters($org_id=0, $fromzoneid=0){

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['uploaded_letters'] = $this->sales_zone->get_letters_for_organization($org_id);		

		$data['right_container'] = $this->load->view("organization/view_letters", $data, true);

		$this->common($data);	

	}

	################################################  Organization Uploaded Letters Part End ################################################

	

	################################################  Organization Interest Group Part Start ################################################

	# + New interest Group

	public function newinterestgroup($org_id=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($org_id,$fromzoneid);		

		$data['right_container'] = $this->load->view("organization/create_interest_group", $data, true);

		$this->common($data);

	}

	

	public function viewinterestgroup($org_id=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/view_interest_group", $data, true);

		$this->common($data);

	}

		

	public function viewinterestgroupvisibility($org_id=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/interest_group_visibility", $data, true);

		$this->common($data);

	}

	

	

	

	

	################################################  Organization Interest Group Part End #################################################





################################################  Organization Bulk Email Part Start #######################################################	

# + viewbulkemail  --> To get the list of the members under the organization - Added on 21/08/14

	public function viewbulkemail($org_id=false,$fromzoneid=0){

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['zoneid']=$data['common']['zoneid'];

		//$data['organization_members_bulk_email'] = $this->org_model->get_all_org_members($org_id,$data['zoneid']);  // Send the firts/last name , email , phone , id to the view page

		$data['ckeditor_sendbulkemail'] = array(

		//ID of the textarea that will be replaced  

			'id' 	=> 	'text_for_mail',

			'path'	=>	'assets/ckeditor',

			//Optional values

			'config' => array(

				'toolbar' 	=> 	"Full", 	//Using the Full toolbar

				'width' 	=> 	"100%",	//Setting a custom width

				'height' 	=> 	'150px',	//Setting a custom height

	    ));	

		$data['right_container'] = $this->load->view("organization/viewbulkemail", $data, true);

		$this->common($data);	

	}

# - viewbulkemail



# + send_mail_to_org_members --> To send bulkemail to the organization members

	public function send_mail_to_org_members(){

		$userids = empty($_REQUEST['uid']) ? 0 : $_REQUEST['uid']; 

		$sub = $_REQUEST['subject'];

		$msg = str_replace("\n","<br>",$_REQUEST['message']);

		//echo $userids ;exit;

		$uid_arr=explode(',',$userids); 

		//foreach($uid_arr as $uid){	

			//$sql = "SELECT group_concat(email) as contactemail FROM users WHERE id IN(".$userids.")" ;

			$sql = "SELECT group_concat(email) as contactemail FROM org_members WHERE id IN(".$userids.") ";

			$query_u1 = $this->db->query($sql);	

			$useremail=$query_u1->result_array(); 

			if(!empty($useremail)){

				$uemailid=$useremail[0]['contactemail']; //var_dump($uemailid); exit;

				//var_dump($uemailid); exit;

				$fromemail=$this->config->item('adminEmailId');

				$this->load->library('email');

				$this->email->clear();

				$this->email->from($fromemail);

				$this->email->subject($sub);

				$this->email->message($msg);

				$this->email->to($uemailid);

				$this->email->send();

				$to[]=$uemailid;

			}

		//}

		//exit;

		$message="Email send successfully ";

		echo($this->dr->GetDR("Successfully", $message, "", "0"));

	}

# - send_mail_to_org_members





################################################  Organization Bulk Email Part End #########################################################

	

	

################################################  Organization Email Notice Part Start #################################################################

	public function createemailnotice($org_id=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($org_id,$fromzoneid);

		$data['right_container'] = $this->load->view("organization/create_email_notice", $data, true);

		$this->common($data);

	}

	public function viewemailnotice($org_id=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($org_id,$fromzoneid);	

		$data['right_container'] = $this->load->view("organization/view_email_notice", $data, true);

		$this->common($data);

	}

	public function sendemailnotice($org_id=false,$fromzoneid=0){ 

		$data['common']=$this->common_first($org_id,$fromzoneid); //echo "<pre>"; var_dump($data['common']);exit;

	

	# + Added on 10/07/14

		$data['zoneid'] = $data['common']['zoneid'];

		//$data['createdby_id'] = $data['common']['top_header_name']['id'];

		$data['createdby_id'] = $data['common']['sub_header_name_from_zone']['id'];

		$data['createdby_type'] = 3;

		$data['ig_group']=$this->email_notice->active_subscribed_group_display($data['zoneid'],$data['createdby_id'],$data['createdby_type']); //var_dump($data['ig_group']);exit;

		$data['all_bus_notice']=$this->email_notice->all_notices($data['zoneid'],$data['createdby_id'],$data['createdby_type']);

	# - Added on 10/07/14

		

		$data['right_container'] = $this->load->view("organization/send_email_notice", $data, true);

		$this->common($data);

	}

	public function historyemailnotice($org_id=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($org_id,$fromzoneid);

		

	# + Added on 10/07/14

		$data['zoneid'] = $data['common']['zoneid'];

		$data['createdby_id'] = $data['common']['sub_header_name_from_zone']['id']; 

		$data['createdby_type'] = 3;

		$data['email_history']=$this->email_notice->view_email_notice_history($data['createdby_id'],$data['zoneid'],$data['createdby_type']);

	# - Added on 10/07/14

		

		$data['right_container'] = $this->load->view("organization/history_email_notice", $data, true);

		$this->common($data);

	}

	

		function veiw_email_notice(){

		$data=array();

		$data['id']=!empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;

		$data['zoneid']=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;

		$data['organizationid']=!empty($_REQUEST['organizationid']) ? $_REQUEST['organizationid'] : 0;

		$data['createdby_type'] = 3;

		$data['veiw_email_notice']=$this->email_notice->email_notice_history_org($data['id'],$data['zoneid'],$data['organizationid'],$data['createdby_type']); 

		$data['right_container'] = $this->load->view("organization/veiw_email_notice",$data, true);

		echo($this->dr->GetDR($data['id'],$data['veiw_email_notice'], $data['right_container'], "0"));

	}



	function delete_history(){

		$id=!empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;

		$organizationid=!empty($_REQUEST['organizationid']) ? $_REQUEST['organizationid'] : 0;

		//$delete_history=$this->email_notice->delete_notice_history($id,$businessid);

		  $sql = "delete from email_notice_history where id='".$id."' and createdby_id='".$organizationid."'";

	      $query = $this->db->query($sql); 

	      echo($this->dr->GetDR($id,"", "", "0"));

	}



################################################  Organization Email Notice Part End #################################################################	

	

	

############################################################## Business Webinar Start ################################################################

	

	public function webinar_information($organizationid=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($organizationid,$fromzoneid);	

		$data['usersid']=$data['common']['org_owner_id']; //echo "<pre>"; var_dump($data['usersid']);exit;

		$data['zoneid'] = $data['common']['zoneid'] ;

		$data['webniar_exist'] = $this->announcements->webniar_exist($data['usersid'],$data['zoneid']);		

		$data['right_container'] = $this->load->view("organization/webinar_information", $data, true); 

		$this->common($data);

	}

	public function get_organization_owner_id($organization_id){
		$get_org_owner_id = "SELECT userid FROM organization WHERE id=".$organization_id; 
		$result = $this->CommonController->SelectRawquery($get_org_owner_id);
		$organization_owner_id = $result[0]['userid'];
		return $organization_owner_id;
	}
	
	public function save_webinar_link(){
		$zoneid = isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';
		$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';	
		$organization_id = isset($_REQUEST['organization_id']) ? $_REQUEST['organization_id'] : '';
		$organization_owner_id = $this->get_organization_owner_id($organization_id);
		
		$webinar_link=isset($_REQUEST['webinar_link']) ? $_REQUEST['webinar_link'] : '';
		$description=isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
		
		$sql="select id from webinar_information where created_by_userid=".$organization_owner_id." AND zoneid=".$zoneid;
		$result = $this->CommonController->SelectRawquery($sql);

		if(count($result) > 0){
			echo json_encode(['msg'=>'Webinar information already exist in the system. Either delete and create new or update the existing','type'=>'warning']);
			die;
		}else{
			$webinar=array(
				'zoneid'=>$zoneid,
				'link'=>$webinar_link,
				'description'=>$description,
				'created_by_userid'=>$organization_owner_id,
				'status'=>$status,
				'type'=>3,
				'timestamp'=>time(),
			);
			$this->CommonController->InsertData('webinar_information', $webinar);
			echo json_encode(['msg'=>'Successfully saved the webinar information.','type'=>'success']);
		}
	}

	public function webinar_details($organizationid=false,$fromzoneid=0){

		$data['common']=$this->common_first($organizationid,$fromzoneid);

		$data['fromzoneid']=$fromzoneid;  

		$organization_owner_id = $this->get_organization_owner_id($organizationid); 

		$data['webinar_list'] = $this->org_model->show_webinar($data['common']['zoneid'],$organization_owner_id);

		$data['right_container'] = $this->load->view("organization/webinar_details1", $data, true);

		$this->common($data);

	}

	

	public function viewmorewebinar($organizationid=0,$lowerlimit=0,$upperlimit=0){
		$zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:'';
		$organization_id = isset($_REQUEST['organization_id'])?$_REQUEST['organization_id']:'';
		$orguser_id = isset($_REQUEST['orguser_id'])?$_REQUEST['orguser_id']:'';
		$data = $this->Organization_model->show_webinar($zoneid,$orguser_id);
		echo json_encode($data);
		// $data['countallannouncements']=count($data['webinar_list']);

		// if($data['countallannouncements']<1){		

		// 	$data['countallannouncements'] = 0;		

		// }

		// $lowerlimit=$lowerlimit+5;				

		// $limit=$lowerlimit.','.$upperlimit;	

		// $result = $this->load->view("organization/more_webinar",$data, true);

		// echo($this->dr->GetDR($data['countallannouncements'],$limit,$result,"0"));

	}

	

	public function edit_webinar($zoneid=false,$organizationid=false,$webinar_id=false,$fromzoneid=0){

		$data['common']=$this->common_first($organizationid,$fromzoneid);

		$data['getall_webinar']=$this->org_model->getall_webinar_info($zoneid,$webinar_id);

		$data['right_container'] = $this->load->view("organization/edit_webinar", $data, true);

		$this->common($data);

	}

	

	public function update_webinar_link(){
		$webinar_id = isset($_REQUEST['webinar_id']) ? $_REQUEST['webinar_id'] : '';
		$zoneid = isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';	
		$organization_id = isset($_REQUEST['organization_id']) ? $_REQUEST['organization_id'] : '';
		$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
		$webinar_link=isset($_REQUEST['webinar_link']) ? $_REQUEST['webinar_link'] : '';
		$description=isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
		$current_time = time();
		$arr = array(
			'link' =>$webinar_link,
			'description'=>$description,
			'status'=>$status,
			'timestamp'=>$current_time

		);
		$this->CommonController->updateData('webinar_information',$arr,['zoneid'=>$zoneid,'id'=>$webinar_id]);
		echo json_encode(['msg'=>'Webinar Updated Successfully','type'=>'success']);
	}
	
	public function delete_webinar(){
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
		$zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:'';
		$this->CommonController->deleteData('webinar_information',['id'=> $id,'zoneid'=>$zoneid]);	
		echo json_encode(['msg'=>'Webinar Deleted Successfully','type'=>'success']);
	}



############################################################# Business Webinar Start ################################################################



######################################## Organization Peekaboo Section ###################################################



   

		

########################################  ++++++ Start Left Organization panel peekaboo banner section (Create Auction button) ++++++++  ########################################

		

	function peekaboo_access_org(){


		$data = array();

		$organizationid =  !empty($_REQUEST['organizationid']) ? $_REQUEST['organizationid'] : '';

		$zoneid = !empty($_REQUEST['zoneid']) ?  $_REQUEST['zoneid'] : '';

		$approval = !empty($_REQUEST['approval']) ? $_REQUEST['approval'] : '';

		

		$data['auction_view']=$this->org_model->auction_view($zoneid,$organizationid);

		

		$peekaboo_response = explode(',',$data['auction_view']); //var_dump($peekaboo_response);exit;

		$username = $peekaboo_response['0']; 

		$group_id = $peekaboo_response['1']; 

		echo($this->dr->GetDR($username, $group_id, $zoneid , "", "0"));			

		

	}

	

########################################  ++++++ End Left Organization panel peekaboo banner section (Create Auction button) ++++++++  ########################################

 

 

										 ######################### ++++ Event Calendar System ++++ ###############################

 

 	function eventcalendar(){

		$orgid = !empty($_REQUEST['orgid']) ? $_REQUEST['orgid'] : '' ;	  

		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '' ;	  

		

		// + Get username for this organization calendar auto loggin purpose

			$username = $this->org_model->get_username($orgid,$zoneid);//var_dump($username);exit;

			echo($this->dr->GetDR($username, "1", "", "0"));		

				

		// + Get username for this organization calendar auto loggin purpose

		

	}

 

										 ######################### ---- Event Calendar System ---- ###############################

 

 	/*

	 *	View event calendar event history

	 *

	 */

	public function eventcalendaremailhistory($org_id=false,$fromzoneid=0){

		$data['common']					=	$this->common_first($org_id,$fromzoneid);

		$data['calendarhistorylist']	=	$this->org_model->geteventcalendarhistory($org_id);

		$data['right_container'] 		= 	$this->load->view("organization/calendaremailhistory", $data, true);

		$this->common($data);	

	}



    /**

     * this function is used to to load jotform upload view part

     * @param organization id

     * return view display



     */

    public function uploadjotform($organizationid,$fromzoneid=0){

        $data['common']=$this->common_first($organizationid,$fromzoneid);

        $data['organizationid']=$data['common']['organizationid'];

        $data['jotform_category_data'] = $this->org_model->fetch_jotform_organizationcategory($organizationid);

        /*var_dump($data['jotform_category_data']);

        exit();*/

        $data['right_container'] = $this->load->view("organization/jotform", $data, true);

        $this->common($data);

    }

    /**

     * @description to view jotform

     * @param organization id

     * return view display

     */

    public function viewjotform($organizationid,$fromzoneid=0){

        /*$data['common'] = $this->common_first($zoneid,$fromzoneid);

        $data['zoneid'] = $data['common']['zoneid'];*/

        $data['right_container'] = $this->load->view('zone/jotform_page');

        /*$this->common($data);*/

    }
	
	public function updatejotformcodes(){
		$form_type_id = $_REQUEST['form_type_id'];
		$codes = $_REQUEST['codes'];
		$organization_id = $_REQUEST['organization_id'];
		$update_code_details = $this->zone_model->update_jotformcode_data($form_type_id,$codes,$organization_id);
		echo json_encode($update_code_details);
	}

    public function payment_list($organization_id,$fromzoneid=0) {

        $data['common']=$this->common_first($organization_id,$fromzoneid);

        $data['organizationid']=$data['common']['organizationid'];

        $data['details_payment_list'] = $this->org_model->get_payment_details($organization_id);

        $data['right_container'] = $this->load->view("organization/payment_list", $data, true);

        $this->common($data);



    }

    public function users_pboo_credit_order($organization_id,$fromzoneid=0){

    	//echo $organization_id;

    	$data['common'] = $this->common_first($organization_id,$fromzoneid);

    	$data['organizationid'] = $organization_id;

    	$payment_module_id = 6;

    	$data['pboo_credit_payment_data'] = $this->org_model->get_org_pboo_credit_request($organization_id,$payment_module_id);

    	//var_dump($data['pboo_credit_payment_data']);

    	$data['pboo_credit_account_id'] = $this->org_model->get_org_pboo_credit_account($organization_id);

    	$data['right_container'] = $this->load->view("organization/pboo_credit_order",$data,true);

    	$this->common($data);

    }

    public function get_organization_jotform_pboo_credits($organization_id,$user_id,$credits,$amount,$payment_module_id){

	    $data['jotform_embed_code'] = $this->zone_model->get_jotform_code($organization_id,$payment_module_id);

	    $data['user_details'] = $this->user->get_user_details($user_id);

	    $data['organization_id'] = $organization_id;

	    $data['credits'] = $credits;

	    $data['amount'] = $amount;

	    $data['organization_details'] = $this->org_model->organization_details($organization_id);

	   // $data['organization_details'] = "hiii";

	    $data['user_id'] = $user_id;

	    $this->load->view("organization/sell_pboo_credits",$data);

	    

	}

	public function pboo_credits_payment_recive_data(){

		/*var_dump($_REQUEST);*/

		$form_details =json_encode($_POST);

		$data['submission_id'] = $_REQUEST['submission_id'] ? $_REQUEST['submission_id'] : 0;

		$data['form_id'] = $_REQUEST['formID'] ? $_REQUEST['formID'] : 0;

		$data['user_id'] = $_REQUEST['userid'] ? $_REQUEST['userid'] : 0;

		$data['organization_name'] = $_REQUEST['organizationname'] ? $_REQUEST['organizationname'] : '';

		$data['amount'] = $_REQUEST['amount'][2] ? $_REQUEST['amount'][2] : 0;

		$data['credits'] = $_REQUEST['credits'] ? $_REQUEST['credits'] : 0;

		$data['organization_id'] = $_REQUEST['organizationid'] ? $_REQUEST['organizationid'] : 0;

		$data['page_url'] = $_REQUEST['pageurl'] ? $_REQUEST['pageurl'] : '';

		$payment_module_id = 6;

		$data['payment_result'] = 0 ;

		//var_dump($data);

		if(!empty($data['submission_id']) && !empty($data['user_id']) && !empty($data['amount']) && !empty($data['form_id']) && !empty($data['organization_id'])){

			$data['payment_result'] = $this->zone_model->insert_payment($payment_module_id,$data['organization_id'],$data['user_id'],$data['amount'],$data['submission_id'],$data['form_id'],$auction_details='',$auction_id=0,$form_details);



		}

		$this->load->view('organization/thanku.php',$data);

	}

	public function pay_pboo_credit(){

		$user_id = $_POST['user_id'];

		$payment_id = $_POST['payment_id'];

		$account_id = $_POST['account_id'];

		$credits = $_POST['credits'];

		$amount = $_POST['amount'];

		//echo json_encode($amount);

		$result = $this->org_model->update_pboo_credits($user_id,$payment_id,$account_id,$credits);

		if($result){

			echo json_encode($payment_id);

		} else{

			return false;

		}

		//echo json_encode($result);

	}

	public function current_pboo_credit(){

		$account_id = (int)$_POST['account_id'];

		$result = $this->org_model->current_credit($account_id);

		$balance = $result->balance;

		echo json_encode($balance);

	}

	public function transfer_pboo_credits($organization_id,$fromzoneid=0){

		$data['common'] = $this->common_first($organization_id,$fromzoneid);

		$data['organization_id'] = $organization_id;

		$data['right_container'] = $this->load->view('organization/transfer_pboo_credit',$data,true);

		$this->common($data);



	}

	public function pboo_account_details(){ 	
		$pboo_receiver_user_name = $_REQUEST['username'];
		$payer_id = $_REQUEST['payer_id'];
		$payer_type = $_REQUEST['payer_type'];
 		$payer_pboo_account_id = $this->Organization_model->get_pboo_account_id($payer_id,$payer_type);
		
		$data = array();
		if($payer_pboo_account_id){
			$receiver_account_details = $this->Organization_model->get_pboo_account_details($pboo_receiver_user_name);
			if($receiver_account_details){
				$data = array('payer_pboo_id'=>$payer_pboo_account_id,'receiver_details'=>$receiver_account_details,'status'=>'success');
			} else{
				$data = array('status'=>'nousers');
			}
		} else{
			$data = array('status'=>'your_pboo_not_exists');
		}
 		echo json_encode($data);
 	}

	public function certificate_benificary_organization_spread_sheet($organization_id,$fromzoneid=0){

		$data['common'] = $this->common_first($organization_id,$fromzoneid);

		$data['organization_id'] = $organization_id;

		$data['right_container'] = $this->load->view('organization/spreadsheet_download.php',$data,true);

		$this->common($data);

	}

	public function pboo_credit_transfer(){

		$payer_id = $_REQUEST['payer_pboo_id'];

		$receiver_id = $_REQUEST['receiver_id'];

		$credits  = $_REQUEST['credits'];

		$payer_current_credit_result = $this->org_model->current_credit($payer_id);

		$payer_current_credit = $payer_current_credit_result->balance;

		$data = array();

		if($payer_current_credit >= $credits){

			$result = $this->org_model->pboo_credit_transfer($payer_id,$receiver_id,$credits);

			//echo json_encode($result);

			if($result){

				$data = array('status'=>'success');

			} else{

				$data = array('status' => 'failed');

			}

		} else{

			//echo json_encode("insufficient_credits");

			$data =array('status'=>'insufficient_credits','current_credit'=>$payer_current_credit);

		}

		echo json_encode($data);	

	}

	public function speradsheet_list_data($requestor_id,$type){
		
		$users_list = $this->Organization_model->spread_sheet_data($requestor_id,$type);
	
//This is for static data only code start
		$data = array(     
			'0' => array('Name'=> 'Parvez', 'Status' =>'complete', 'Priority'=>'Low', 'Salary'=>'001'),
			'1' => array('Name'=> 'Alam', 'Status' =>'inprogress', 'Priority'=>'Low', 'Salary'=>'111'),
			'2' => array('Name'=> 'Sunnay', 'Status' =>'hold', 'Priority'=>'Low', 'Salary'=>'333'),
			'3' => array('Name'=> 'Amir', 'Status' =>'pending', 'Priority'=>'Low', 'Salary'=>'444'),
			'4' => array('Name'=> 'Amir1', 'Status' =>'pending', 'Priority'=>'Low', 'Salary'=>'777'),
			'5' => array('Name'=> 'Amir2', 'Status' =>'pending', 'Priority'=>'Low', 'Salary'=>'777')
			);
		
			$filename =  time().".xls";      
           header("Content-Type: application/vnd.ms-excel");
           header("Content-Disposition: attachment; filename=\"$filename\"");
           $heading = false;
           foreach($data as $row) {
                if(!$heading) {
                    echo implode("\t", array_keys($row)) . "\n";
                    $heading = true;
                }
                echo implode("\t", array_values($row)) . "\n";
            }
        exit;   
// This is  for static data  downlod only  code end
		$this->excel->setActiveSheetIndex(0);

		$this->excel->getActiveSheet()->setTitle('Users list');

		if($type == "org"){

		$users_header = array('Auction Id'=>'auction id','Last Name'=>'Last Name','First Name'=>'First Name','Phone'=>'Phone','Address'=>'Address','City'=>'City','State'=>'State');
    
		$this->excel->getActiveSheet()->fromArray(array_keys($users_header),NULL,'A1');

		$j=2;

		if(count($users_list)>0){

			for($i=0;$i<count($users_list);$i++){

				$this->excel->getActiveSheet()->setCellValue('A'.$j, $users_list[$i]['auction_id']);

				$this->excel->getActiveSheet()->setCellValue('B'.$j, $users_list[$i]['lName']);

				$this->excel->getActiveSheet()->setCellValue('C'.$j, $users_list[$i]['fName']);

				$this->excel->getActiveSheet()->setCellValue('D'.$j, $users_list[$i]['phone']);

				$this->excel->getActiveSheet()->setCellValue('E'.$j, $users_list[$i]['address1']." ".$users_list[$i]['address2']);

				$this->excel->getActiveSheet()->setCellValue('F'.$j, $users_list[$i]['city_name']);

				$this->excel->getActiveSheet()->setCellValue('G'.$j, $users_list[$i]['state_name']);

				$j++;

			}

		} else{

			$this->excel->getActiveSheet()->setCellValue('A2','No Result Found');

		}

	  } else if($type == "business"){

	  	$users_header = array('Auction Id'=>'auction id','Received By'=>'Received By','Date'=>'Date','$ Sale'=>'$ Sale','Last Name'=>'Last Name','First Name'=>'First Name','Phone'=>'Phone','Address'=>'Address','City'=>'City','State'=>'State');

		$this->excel->getActiveSheet()->fromArray(array_keys($users_header),NULL,'A1');

		$j=2;

		if(count($users_list) > 0){

			for($i=0;$i<count($users_list);$i++){

				$this->excel->getActiveSheet()->setCellValue('A'.$j, $users_list[$i]['auction_id']);

				$this->excel->getActiveSheet()->setCellValue('B'.$j,$users_list[$i]['fName']." ".$$users_list[$i]['lName']);

				$this->excel->getActiveSheet()->setCellValue('C'.$j, $users_list[$i]['time']);

				$this->excel->getActiveSheet()->setCellValue('D'.$j, $users_list[$i]['amount']);

				$this->excel->getActiveSheet()->setCellValue('E'.$j, $users_list[$i]['lName']);

				$this->excel->getActiveSheet()->setCellValue('F'.$j, $users_list[$i]['fName']);

				$this->excel->getActiveSheet()->setCellValue('G'.$j, $users_list[$i]['phone']);

				$this->excel->getActiveSheet()->setCellValue('H'.$j, $users_list[$i]['address1']." ".$users_list[$i]['address2']);

				$this->excel->getActiveSheet()->setCellValue('I'.$j, $users_list[$i]['city']);

				$this->excel->getActiveSheet()->setCellValue('J'.$j, $users_list[$i]['state']);

				$j++;

			}

	  } else{

	  	 $this->excel->getActiveSheet()->setCellValue('A2','No Result Found');

	  }

	  }

		$filename='userlist.xls';

		header("Content-Type: application/force-download");

		header('Content-Type: application/vnd.ms-excel');

		header('Content-Disposition: attachment;filename="'.$filename.'"');

		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');

		$objWriter->save('php://output');

	}

	public function updateorgperdetail(){
		$zone_id = $_REQUEST['zone_id'];
        $userid = $_REQUEST['userid'];
        $orgid = $_REQUEST['orgid'];	
        $fee_per = $_REQUEST['fee_per'];	
        $data = array(
			'org_id' => $orgid,
			'user_id' => $userid,
			'fee_per' => $fee_per,
			'zone_id' => $zone_id,
		);
		$data['addressid'] = $this->CommonController->InsertData('org_fee', $data);	
		echo json_encode(['msg'=>'Updated Successfully','type'=>'success']);
	}

}