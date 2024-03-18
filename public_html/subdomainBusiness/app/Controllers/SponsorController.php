<?php
namespace App\Controllers;
// files from libraries folder
require_once APPPATH . "/Libraries/PHPMailer-master/src/PHPMailer.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/Exception.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/SMTP.php";
use App\Libraries\IonAuth;
use App\Libraries\PHPMailer_Lib;
use Config\MyConfig;
use App\Models\zone\Zone_model;
use App\Models\admin\Business;
use App\Models\admin\Ads_model;
use App\Controllers\CommonController;
use App\Controllers\CronController;
use App\Controllers\BusinessSearch;
use App\Models\admin\Sales_zone;
use App\Models\admin\Category_management_model;
use App\Models\Statistics;
use App\Models\States;
use App\Models\banner\Banner_model;
use App\Models\Category_new_model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
#[\AllowDynamicProperties]
class SponsorController extends BaseController{
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
    	$this->Banner_model = new Banner_model();
    	$this->Category_new_model = new Category_new_model();
    	$this->Category_management_model = new Category_management_model();
    	$this->CronController = new CronController();
    	$this->BusinessSearch = new BusinessSearch();
    	$this->PHPMailer = new PHPMailer();
    }

    public function sponsordetail($page='',$fromzoneid=0,$sess_destroy=0){
		$sessionzone = isset($_REQUEST['sessionzone'])?$_REQUEST['sessionzone']:'';
    	$decodedata = base64_decode($sessionzone);
    	$decodedata = json_decode($decodedata);
    	if($decodedata!= ''){
    		$session_data = array(
      			'identity' => $decodedata->identity,
        		'username' => $decodedata->username,
        		'email' => $decodedata->email,
        		'user_id' => $decodedata->user_id,
        		'old_last_login' => $decodedata->old_last_login
      		);
      		$this->session->set($session_data);
      		$this->CommonController->setSession('session_zoneid', array('userzoneid'=>$decodedata->session_zoneid->userzoneid,'sesuserid'=>$decodedata->session_zoneid->sesuserid), 'array');
      		$this->CommonController->setSession('session_login_details', array('type'=>$decodedata->session_login_details->type,'id'=>$decodedata->session_login_details->id), 'array');
    	}
		
		$amazonurl = $this->myconfig->AWSimageurl;
		$zoneid = $this->CommonController->redirectToZone();
		$this->CronController->rankbusiness($zoneid);
	  	
	  	$user_id = $refer_code = '';
	  	$uid = 0;
	  	$busArr = [];
		
		$userscrapzoneName = isset($_REQUEST['zoneName'])?$_REQUEST['zoneName']:'';
	  	$subuserid = isset($_GET['subuserid'])?$_GET['subuserid']:'';
	  	$subuser = isset($_GET['subuser'])?$_GET['subuser']:'';
	  	$busid = isset($_GET['busid'])?$_GET['busid']:'';
		$scrapresponse = $this->CommonController->getAutoLogin($subuser);
		$user = $this->ionAuth->user()->row();
		if($userscrapzoneName != ''){
	  		return redirect()->to($scrapresponse);	
	  	}
	  	
	  	$pagesidebar = isset($page)?$page:'zoneinformation';
	 	if(!empty($user)){ 
	   		$uid = $user->id;
	   		$loginzoneid = $user->Zone_ID;
	   		if($loginzoneid != $zoneid){
	   			$subdomainZone = $this->CommonController->SelectDataMultiWay('sales_zone','subdomainZone','column',['id' => $loginzoneid]);	
	   			return redirect()->to('https://'.$subdomainZone.'.savingssites.com/Zonedashboard/zoneinformation');	
	   		}else{
	   			$subdomain = $this->CommonController->SelectDataMultiWay('sales_zone','subdomain','column',['id' => $loginzoneid]);
	   		}
	  	}	 
    	
    	if (empty($uid)) {
    		return redirect()->to(base_url().'/zone/'.$zoneid.'/');
		}
  		
  		$zone_name = $this->CommonController->SelectDataMultiWay('sales_zone','name','column',['id' => $zoneid]);
  		$zone= $this->Zone_model->get_zone($zoneid);
	  	$zone_owner = $this->ion_auth->user($zone['sales_rep_id'])->row();

	  	if($pagesidebar == 'add_business_sponsor_banner'){
			$busqry="SELECT * FROM business as a INNER JOIN ads_setting_preferences as b ON b.businessid=a.id WHERE b.settingszoneid=".$zoneid." Order by name ASC";
			$busArr = $this->CommonController->SelectRawquery($busqry,'result');
		}

		if($pagesidebar == 'view_business_sponsor_banner'){
			$busqry="SELECT * FROM businesssponsorbannerlist  WHERE zone=".$zoneid." Order by id ASC";
			$busArr = $this->CommonController->SelectRawquery($busqry,'result');
			if(count($busArr) > 0){
				foreach ($busArr as $key => $v) {
					$v->businessname = $this->CommonController->getsinglecolumndata('business','name','id',$v->businessid); 
					
				}
			}
		}
		
		$common = $this->common_first($zoneid,$fromzoneid);
		$sql="SELECT Distinct * , category_sub_subcategory_new.* FROM business_sponsor_order INNER JOIN business ON business_sponsor_order.business_id=business.id left JOIN business_sponsor_order_subcat ON business_sponsor_order_subcat.bussiness_id=business.id INNER JOIN ads ON ads.business_id=business.id INNER JOIN ad_category_subcategory ON ad_category_subcategory.adid=ads.id INNER JOIN business_sponsor ON business_sponsor.business_id=business_sponsor_order.business_id INNER JOIN category_sub_subcategory_new ON ad_category_subcategory.subcatid=category_sub_subcategory_new.id WHERE business_sponsor.zone_id=".$common['zoneid']." and category_sub_subcategory_new.status = 1 and category_sub_subcategory_new.parent_id <> -99 GROUP BY ad_category_subcategory.subcatid";
  		$subdata = $this->CommonController->SelectRawquery($sql);
    	$business_search_value = $this->CommonController->getSession('business_search_value');
   		
   		return view('Sponsordashboard',array('zone' => $zone,'zone_id' => $zoneid,'zoneid' => $zoneid,'zone_name' => $zone_name,'zone_owner' => $zone_owner,'uid' =>$uid,'amazonurl' =>$amazonurl,'sessionzone'=>$sessionzone,'pagesidebar' => $pagesidebar,'busArr'=>$busArr,'user_id' => $user_id,'refer_code' => $refer_code,'via' =>''));
	}	

		public function common_first($zoneid=0,$fromzoneid=0){
		$data=array();
		$user = $this->ionAuth->user()->row();
		if($zoneid==308){
			log_message('custom', 'The purpose of some variable is to provide some value.');
		}
		$uid = 0;
		if(!empty($user)){ $uid = $user->id;} 
        	if (empty($user)) {
			redirect(base_url('/Zone/'.$zoneid), 'refresh');
		}
		
		$data['zoneid']=$zoneid; 
		$data['from_zoneid']=isset($fromzoneid) ? $fromzoneid : 0; 
		$data['where_from'] = 'zone';
		$data['top_header_name'] = $this->Zone_model->get_zone($zoneid);
		$data['user'] = $user; 		
		$data['uid']= $uid; 
		$data["usergroup"] = $this->Business->get_user_group1($uid); 
		$usergrid=$data["usergroup"]->group_id;
		$session_login_details=$this->session->get('session_login_details');
		$data['login_type']=$session_login_details['type'];
		$data['login_id']=$session_login_details['id'];
		$newsessiondata = array('usergrid'=>$usergrid,'userzoneid'=>$zoneid);
		$this->session->set('usersessiondata',$newsessiondata);
		
		$check_valid_url= $this->ionAuth->check_valid_url($uid,$zoneid); 
		$check_zoneid = $this->session->get('session_zoneid');
		if (empty($check_zoneid)) {
			if ($user->Zone_ID) {
				redirect(base_url('/zone/'.$user->Zone_ID), 'location', 301);
			}
			else{
				redirect(base_url(), 'location', 301);
			}
		}
		
		$valid_zoneid = $check_zoneid['userzoneid'];
		if($check_valid_url==0){
			$modified_url = base_url('/Zonedashboard/zonedetail/'.$valid_zoneid);
		}
		
		if (!get_cookie('')) {
		  $this->CommonController->SetCookie('csvuploaderzoneid',$zoneid,time()+86500,'','/','');
		  $this->CommonController->SetCookie('zoneid',$zoneid,time()+86500,'','/','');
		}
		return $data;
	} 

	public function savebusinesssponserbanner(){
		$zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:'';
		$loginuser = isset($_FILES['loginuser'])?$_FILES['loginuser']:'';
		$sponsorbusinessid = isset($_REQUEST['sponsorbusinessid'])?$_REQUEST['sponsorbusinessid']:'';
		if($sponsorbusinessid != ''){
			$explodeArr = explode(',',$sponsorbusinessid);
			$filename = $_FILES['bannerfile']['name'];
			if($filename == '' && $text == ''){
				echo json_encode(['msg'=>'Please select atleast Image or Text','type'=>'warning']);
				die;
			}
			
			$sql = "SELECT * FROM businesssponsorbannerlist WHERE sponsorid='".$loginuser."'";
			$data = $this->CommonController->SelectRawquery($sql,'row');
			$uploaded_file = $_FILES['bannerfile']['tmp_name'];
    		$folder_path1 = "./assets/SavingsUpload/uploadtoaws/";
    		if(is_dir($folder_path1)==false){ mkdir($folder_path1,0777);}
    		if(move_uploaded_file($uploaded_file, $folder_path1.$filename)){
    			$resname = $this->CommonController->uploadtoaws($folder_path1, $filename);
				foreach ($explodeArr as $k => $businessid) {
					$sponsorexistsqry="SELECT * FROM businesssponsorbannerlist WHERE sponsorid =".$loginuser." AND businessid=".$businessid."";
					$sponsorexists = $this->CommonController->SelectRawquery($sponsorexistsqry,'count');
					if($sponsorexists > 0){
						$dataArr= ['image'=>$resname];
						$this->CommonController->updateData('businesssponsorbannerlist',$dataArr,['sponsorid' => $loginuser,'businessid'=>$businessid]);
					}else{
						$arr = ['sponsorid'=>$loginuser,'businessid'=>$businessid,'zone'=>$zoneid,'image'=>$resname];
						$this->CommonController->InsertData('businesssponsorbannerlist', $arr);	
					}	
				}	
				unlink($folder_path1.$filename);
				echo json_encode(['msg'=>'sponser data added successfully','type'=>'success']);
				die;
			}
		}
		//path $this->myconfig->AWSimageurl/011-details-2560x1440-A.jpg
	}
}