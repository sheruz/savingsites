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
class Zonedashboard extends BaseController{
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
    	/**pending all**/public function clear_cache(){  //pending  
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
    	}
	/**pending all**/public function index(){ //pending
		echo("Index works..");
		$this->load->view("Zonedashboard/zonedetail");		
	}
	
	/**pending all**/public function emailformating($zoneid,$fromzoneid){ //pending
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$zone= $this->zone_model->get_zone($data['common']['zoneid']);
		$data['zone'] = $zone;
		$sql="select * from tbl_emailformat where zoneid=".$zoneid;
		$query=$this->db->query($sql);
		$result = $query->result_array();
		$data['resultdata']=$result[0];
		
		$sql1="select * from tbl_keys_awssmtp where zoneid=".$zoneid;
		$query1=$this->db->query($sql1);	
		$result1 = $query1->result_array();
		
		$data['keyaws']=$result1[0];
		$data['zoneid']=$data['common']['zoneid'];
		$data['uid']=$data['common']['uid'];	 
		$data['right_container'] = $this->load->view("zone/emailformat", $data, true); 
		$this->common($data);	
	}

	public function listofcategory(){
		echo $sql_get_categories = "SELECT id , name FROM `category_new` WHERE STATUS = 1 AND id != -99 order by name ASC";
		die;
		$cat = $this->CommonController->SelectRawquery($sql_get_categories, 'resultArray');
		$html = '<option value="0">Select Category</option>';
		foreach($cat as $categories){
    	$html .= '<option value="'.$categories['id'].'">'.$categories['name'].'</option>';
    }
    echo $html;
    die;
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
  
  public function sendEmailSnapONUSer(){
  	$zoneid = $_REQUEST['zone_id'];
	$weekday = '';
    $date = date('Y-m-d') ;
    $weekNumber = date('N', strtotime($date));
 		if($weekNumber=='7'){
    		$weekday = 1;
    	}else{
    		$weekday  = $weekNumber+1;
    	}
		$sql="SELECT id , zone_id  , user_id  FROM `user_offer_status` where status = 1 and   FIND_IN_SET('".$weekday."',snap_days_id)  group by user_id";
		$result=$this->CommonController->SelectRawquery($sql,'resultArray');
		foreach ($result as   $value) {
			if($value['zone_id'] && $value['user_id']){	  
      			// $this->sendCustomemail($zoneid,$value['user_id']);
      			$this->sendCustomemailnewTemplate($zoneid,$value['user_id']);
      			die;
	    	}
	  	}
	}

	public function sendCustomemailnewTemplate($zoneid , $userID){
  		$postLimit = ''; 	
  		$sponserbannerArr = [];
		$addlist = array();
 		$Today=date('d/m/y');
		$promoexpiredate=Date('d/m/y', strtotime('+3 days'));
		$generatedPromoCode = $this->generatePRomo();
		$sql1="select * from tbl_emailformat where zoneid=".$zoneid;
 		$result=$this->CommonController->SelectRawquery($sql1,'resultArray');
		$viewhtmlArr = [];

		$sql1="select * from sales_zone where id=".$zoneid;
 		$zoneres = $this->CommonController->SelectRawquery($sql1,'row');
 		$zoneuserid = $zoneres->sales_rep_id;
 		$sqluser="select * from users where id=".$zoneuserid;
 		$userres = $this->CommonController->SelectRawquery($sqluser,'row');
 		$publisherrefer = $userres->refer_code_link;
		
 		if(@count($result) != 0){
 			$setdataArr = [];
  			$dataPattarn = json_decode($result[0]['emailformat']);
  			foreach($dataPattarn as $dataPattarn){
				if($dataPattarn->value == 'Sponser1'){
					$sectiondata = $this->CommonController->getsponserdata($zoneid,1);
  					$viewhtmlArr[$dataPattarn->value] = $sectiondata;
  				}
				if($dataPattarn->value == 'Sponser2'){
					$sectiondata = $this->CommonController->getsponserdata($zoneid,2);
  					$viewhtmlArr[$dataPattarn->value] = $sectiondata;
  				}
  				if($dataPattarn->value == 'Sponser3'){
  					$sectiondata = $this->CommonController->getsponserdata($zoneid,3);
  					$viewhtmlArr[$dataPattarn->value] = $sectiondata;
  				}
  				if($dataPattarn->value == 'Sponser4'){
  					$sectiondata = $this->CommonController->getsponserdata($zoneid,4);
  					$viewhtmlArr[$dataPattarn->value] = $sectiondata;
  				}
  				if($dataPattarn->value == 'Sponser5'){
  					$sectiondata = $this->CommonController->getsponserdata($zoneid,5);
  					$viewhtmlArr[$dataPattarn->value] = $sectiondata;
  				}

  				if($dataPattarn->value == 'Snap'){
  					$snapdatahtml = '';
  					$snapqry="select business.id from user_offer_status  INNER JOIN ads ON user_offer_status.adid=ads.id  INNER JOIN business ON ads.business_id=business.id  where  user_offer_status.user_id = ".$userID." and   user_offer_status.adid != '0'";
					$allSnappost = $this->CommonController->SelectRawquery($snapqry ,'resultArray');
					shuffle($allSnappost);
					$allSnappost= array_slice($allSnappost,0,8);
					if(count($allSnappost) > 0){
						foreach ($allSnappost as $k2 => $v2) {
							$peekaboo_id = $this->allpeekabooId($v2['id']);
							$peekaboo_type = $this->allpeekabootype($v2['id']);	
							if($peekaboo_id && $peekaboo_type){
								$snapsql = 'SELECT  c.name as cat_name,ip.company_name ,ip.*, a.*,a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update  FROM tbl_deals a LEFT JOIN tbl_deals_products ip ON ip.deal_product_id=a.product_id LEFT JOIN category_new c ON c.id=ip.cat_id WHERE a.user_id='.$peekaboo_id.' AND a.member_type='.$peekaboo_type.' AND a.auction_type="RTP" order by a.start_date ASC';   
								$snapres= $this->CommonController->SelectRawquery($snapsql ,'resultArray');
								$snapdatahtml .= '<div style="width:100%;max-width:650px;margin:auto;">';
								foreach ($snapres as $key =>  $v3) {
									if($v3['numberofconsolation'] == -1){
                                        $htmlcerti = `Unlimited`;
                                    }else{
                                        $htmlcerti = $v3['numberofconsolation'];
                                   	}
                                   	if(file_exists('https://cdn.savingssites.com/'.$v3['card_img'])){
                                   		$img = 'https://cdn.savingssites.com/'.$v3['card_img'].'';
                                   	}else{
                                   		$img = 'https://cdn.savingssites.com/OurDealsComingSoon-1.png';
                                   	}
									$savings = @$v3['buy_price_decrease_by'] -  @$v3['current_price'] - @$v3['publisher_fee'];
									$snapdatahtml .= '<div class="service-cont" style="margin-bottom:20px;padding-bottom: 15px;width:45%;float:left; padding: 15px 10px; background: #fff; margin: 0px 5px 5px 0px;box-shadow: 0px 0px 5px #b3b3b3c4;border-radius: 5px;">
	<div style="width: 100%;align-items: center;">
    	<div style="width: 50%;float:left;">
            <p class="fontkaint" style="margin:0px;padding: 10px 0px 0px 0px; font-size: 18px; font-weight: 500;color: #38373d;">'.$v3['deal_title'].'</p>
        </div>
        <div style="width: 50%;float:left">
            <p style="float: right;"><img src="https://cdn.savingssites.com/home.png" style="width: 100%;height:20px;"/></p>
        </div>
    </div>
    
    <div style="width: 100%;align-items: center;">
        <div style="margin: 10px auto;">
            <img src="'.$img.'" style="width: 100%;height:210px;"/>
        </div>
    </div>

	<div style="width: 100%;align-items: center;margin-bottom: 30px;">
        <div style="width: 50%;float:left;">
            <table>
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">Deals Value:<img src="https://cdn.savingssites.com/information-button.png" style="width: 15px;"/></td>
                </tr>
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">pay Business:<img src="https://cdn.savingssites.com/information-button.png" style="width: 15px;"/></td>
                </tr>
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">Deals Left:<img src="https://cdn.savingssites.com/information-button.png" style="width: 15px;"/></td>
                </tr>
            </table>
        </div>
        <div style="width: 50%;float:left;">
            <table style="float: right;">
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">$'.$v3['buy_price_decrease_by'].'</td>
                </tr>
               	<tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">$'.$v3['current_price'].'</td>
                </tr>
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">$'.$htmlcerti.'</td>
                </tr>
            </table>
        </div>
    </div>		

    <div style="width: 100%;display:flex;justify-content: space-between; margin: 30px auto 0px; align-items: center;">
        <p style="width:25%;margin-top:25px;">
            <img src="https://cdn.savingssites.com/information-button.png" style="width: 20px;"/>
            <img src="https://cdn.savingssites.com/left.png"  style="width:60px;" class="serve-img" /></p>
        <p style="color: #f00; font-size: 25px;width:25%;position:relative;">
            <img src="https://cdn.savingssites.com/information-button.png" style="width: 20px;"/>
            <img src="https://cdn.savingssites.com/heart.png"  style="width:50px;" class="serve-img" /></p>
        <p style="font-size: 25px;width:25%;margin-top:60px;">
            <img src="https://cdn.savingssites.com/pin.png"  style="width:50px;" class="serve-img" /></p>
       	<p style="font-size: 25px;width:25%;margin-top:60px;">
            <img src="https://cdn.savingssites.com/tag.png"  style="width:50px;" class="serve-img" /></p>
    </div>

	<div style="width:100%;">
        <button type="button" style="cursor: pointer;width: 100%;border: 0;padding: 15px; background: #5f9900;border-radius: 10px;color: #fff;font-size: 16px;font-weight: 800;"> Free $5 </button>
    </div>
</div>'; 
								}
								$snapdatahtml .= '</div>';
							}
						}
						$viewhtmlArr[$dataPattarn->value] = $snapdatahtml;
					}
  				}
  				if($dataPattarn->value == 'Ranked'){
  					$Rankeddatahtml = '';
					$ranked_sql="SELECT business.id FROM business_sponsor INNER JOIN business ON business_sponsor.business_id=business.id INNER JOIN ads ON business.id=ads.business_id WHERE business_sponsor.zone_id= ".$userID;
					$rankedsql1=$this->CommonController->SelectRawquery($ranked_sql ,'resultArray');
		 			shuffle($rankedsql1);
					$rankedsql1= array_slice($rankedsql1,0,8);
					if(count($rankedsql1) > 0){
						foreach ($rankedsql1 as $k2 => $v2) {
							$peekaboo_id = $this->allpeekabooId($v2['id']);
							$peekaboo_type = $this->allpeekabootype($v2['id']);	
							if($peekaboo_id && $peekaboo_type){
								$snapsql = 'SELECT  c.name as cat_name,ip.company_name ,ip.*, a.*,a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update  FROM tbl_deals a LEFT JOIN tbl_deals_products ip ON ip.deal_product_id=a.product_id LEFT JOIN category_new c ON c.id=ip.cat_id WHERE a.user_id='.$peekaboo_id.' AND a.member_type='.$peekaboo_type.' AND a.auction_type="RTP" order by a.start_date ASC';   
								$snapres= $this->CommonController->SelectRawquery($snapsql ,'resultArray');
								$Rankeddatahtml .= '<div style="width:100%;max-width:650px;margin:auto;">';
								foreach ($snapres as $key =>  $v3) {
									if($v3['numberofconsolation'] == -1){
                                        $htmlcerti = `Unlimited`;
                                    }else{
                                        $htmlcerti = $v3['numberofconsolation'];
                                   	}
                                   	if(file_exists('https://cdn.savingssites.com/'.$v3['card_img'])){
                                   		$img = 'https://cdn.savingssites.com/'.$v3['card_img'].'';
                                   	}else{
                                   		$img = 'https://cdn.savingssites.com/OurDealsComingSoon-1.png';
                                   	}
									$savings = @$v3['buy_price_decrease_by'] -  @$v3['current_price'] - @$v3['publisher_fee'];
									$Rankeddatahtml .= '<div class="service-cont" style="margin-bottom:20px;padding-bottom: 15px;width:45%;float:left; padding: 15px 10px; background: #fff; margin: 0px 5px 5px 0px;box-shadow: 0px 0px 5px #b3b3b3c4;border-radius: 5px;">
	<div style="width: 100%;align-items: center;">
    	<div style="width: 50%;float:left;">
            <p class="fontkaint" style="margin:0px;padding: 10px 0px 0px 0px; font-size: 18px; font-weight: 500;color: #38373d;">'.$v3['deal_title'].'</p>
        </div>
        <div style="width: 50%;float:left">
            <p style="float: right;"><img src="https://cdn.savingssites.com/home.png" style="width: 100%;height:20px;"/></p>
        </div>
    </div>
    
    <div style="width: 100%;align-items: center;">
        <div style="margin: 10px auto;">
            <img src="'.$img.'" style="width: 100%;height:210px;"/>
        </div>
    </div>

	<div style="width: 100%;align-items: center;margin-bottom: 30px;">
        <div style="width: 50%;float:left;">
            <table>
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">Deals Value:<img src="https://cdn.savingssites.com/information-button.png" style="width: 15px;"/></td>
                </tr>
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">pay Business:<img src="https://cdn.savingssites.com/information-button.png" style="width: 15px;"/></td>
                </tr>
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">Deals Left:<img src="https://cdn.savingssites.com/information-button.png" style="width: 15px;"/></td>
                </tr>
            </table>
        </div>
        <div style="width: 50%;float:left;">
            <table style="float: right;">
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">$'.$v3['buy_price_decrease_by'].'</td>
                </tr>
               	<tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">$'.$v3['current_price'].'</td>
                </tr>
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">$'.$htmlcerti.'</td>
                </tr>
            </table>
        </div>
    </div>		

    <div style="width: 100%;display:flex;justify-content: space-between; margin: 30px auto 0px; align-items: center;">
        <p style="width:25%;margin-top:25px;">
            <img src="https://cdn.savingssites.com/information-button.png" style="width: 20px;"/>
            <img src="https://cdn.savingssites.com/left.png"  style="width:60px;" class="serve-img" /></p>
        <p style="color: #f00; font-size: 25px;width:25%;position:relative;">
            <img src="https://cdn.savingssites.com/information-button.png" style="width: 20px;"/>
            <img src="https://cdn.savingssites.com/heart.png"  style="width:50px;" class="serve-img" /></p>
        <p style="font-size: 25px;width:25%;margin-top:60px;">
            <img src="https://cdn.savingssites.com/pin.png"  style="width:50px;" class="serve-img" /></p>
       	<p style="font-size: 25px;width:25%;margin-top:60px;">
            <img src="https://cdn.savingssites.com/tag.png"  style="width:50px;" class="serve-img" /></p>
    </div>

	<div style="width:100%;">
        <button type="button" style="cursor: pointer;width: 100%;border: 0;padding: 15px; background: #5f9900;border-radius: 10px;color: #fff;font-size: 16px;font-weight: 800;"> Free $5 </button>
    </div>
</div>'; 
								}
								$Rankeddatahtml .= '</div>';
							}
						}
						$viewhtmlArr[$dataPattarn->value] = $Rankeddatahtml;
					}
					
 					
  				}
  				if($dataPattarn->value == 'Favourities'){
  					$favdatahtml = '';
  					$favsql="select business.id as adid from users_favorites  INNER JOIN ads ON users_favorites.adid=ads.id  INNER JOIN business ON ads.business_id=business.id  where  users_favorites.user_id = ".$userID;
					$allfavpost=$this->CommonController->SelectRawquery($favsql,'resultArray');      
					shuffle($allfavpost);
					$favdataArr= array_slice($allfavpost,0,8);
					if(count($favdataArr) > 0){
						foreach ($favdataArr as $k2 => $v2) {
							$peekaboo_id = $this->allpeekabooId($v2['adid']);
							$peekaboo_type = $this->allpeekabootype($v2['adid']);	
							if($peekaboo_id && $peekaboo_type){
								$snapsql = 'SELECT  c.name as cat_name,ip.company_name ,ip.*, a.*,a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update  FROM tbl_deals a LEFT JOIN tbl_deals_products ip ON ip.deal_product_id=a.product_id LEFT JOIN category_new c ON c.id=ip.cat_id WHERE a.user_id='.$peekaboo_id.' AND a.member_type='.$peekaboo_type.' AND a.auction_type="RTP" order by a.start_date ASC';   
								$snapres= $this->CommonController->SelectRawquery($snapsql ,'resultArray');
								$favdatahtml .= '<div style="width:100%;max-width:650px;margin:auto;">';
								foreach ($snapres as $key =>  $v3) {
									if($v3['numberofconsolation'] == -1){
                                        $htmlcerti = `Unlimited`;
                                    }else{
                                        $htmlcerti = $v3['numberofconsolation'];
                                   	}
                                   	if(file_exists('https://cdn.savingssites.com/'.$v3['card_img'])){
                                   		$img = 'https://cdn.savingssites.com/'.$v3['card_img'].'';
                                   	}else{
                                   		$img = 'https://cdn.savingssites.com/OurDealsComingSoon-1.png';
                                   	}
									$savings = @$v3['buy_price_decrease_by'] -  @$v3['current_price'] - @$v3['publisher_fee'];
									$favdatahtml .= '<div class="service-cont" style="margin-bottom:20px;padding-bottom: 15px;width:45%;float:left; padding: 15px 10px; background: #fff; margin: 0px 5px 5px 0px;box-shadow: 0px 0px 5px #b3b3b3c4;border-radius: 5px;">
	<div style="width: 100%;align-items: center;">
    	<div style="width: 50%;float:left;">
            <p class="fontkaint" style="margin:0px;padding: 10px 0px 0px 0px; font-size: 18px; font-weight: 500;color: #38373d;">'.$v3['deal_title'].'</p>
        </div>
        <div style="width: 50%;float:left">
            <p style="float: right;"><img src="https://cdn.savingssites.com/home.png" style="width: 100%;height:20px;"/></p>
        </div>
    </div>
    
    <div style="width: 100%;align-items: center;">
        <div style="margin: 10px auto;">
            <img src="'.$img.'" style="width: 100%;height:210px;"/>
        </div>
    </div>

	<div style="width: 100%;align-items: center;margin-bottom: 30px;">
        <div style="width: 50%;float:left;">
            <table>
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">Deals Value:<img src="https://cdn.savingssites.com/information-button.png" style="width: 15px;"/></td>
                </tr>
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">pay Business:<img src="https://cdn.savingssites.com/information-button.png" style="width: 15px;"/></td>
                </tr>
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">Deals Left:<img src="https://cdn.savingssites.com/information-button.png" style="width: 15px;"/></td>
                </tr>
            </table>
        </div>
        <div style="width: 50%;float:left;">
            <table style="float: right;">
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">$'.$v3['buy_price_decrease_by'].'</td>
                </tr>
               	<tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">$'.$v3['current_price'].'</td>
                </tr>
                <tr>
                    <td class="fontkaint" style="font-weight: 500;font-size: 15px;color: #333;">$'.$htmlcerti.'</td>
                </tr>
            </table>
        </div>
    </div>		

    <div style="width: 100%;display:flex;justify-content: space-between; margin: 30px auto 0px; align-items: center;">
        <p style="width:25%;margin-top:25px;">
            <img src="https://cdn.savingssites.com/information-button.png" style="width: 20px;"/>
            <img src="https://cdn.savingssites.com/left.png"  style="width:60px;" class="serve-img" /></p>
        <p style="color: #f00; font-size: 25px;width:25%;position:relative;">
            <img src="https://cdn.savingssites.com/information-button.png" style="width: 20px;"/>
            <img src="https://cdn.savingssites.com/heart.png"  style="width:50px;" class="serve-img" /></p>
        <p style="font-size: 25px;width:25%;margin-top:60px;">
            <img src="https://cdn.savingssites.com/pin.png"  style="width:50px;" class="serve-img" /></p>
       	<p style="font-size: 25px;width:25%;margin-top:60px;">
            <img src="https://cdn.savingssites.com/tag.png"  style="width:50px;" class="serve-img" /></p>
    </div>

	<div style="width:100%;">
        <button type="button" style="cursor: pointer;width: 100%;border: 0;padding: 15px; background: #5f9900;border-radius: 10px;color: #fff;font-size: 16px;font-weight: 800;"> Free $5 </button>
    </div>
</div>'; 
								}
								$favdatahtml .= '</div>';
							}
						}
						$viewhtmlArr[$dataPattarn->value] = $favdatahtml;
					}
  				}
  				if($dataPattarn->value == 'content'){
  					
  				}
  			}
  		}
  		$htmlfinal = '<!DOCTYPE html><html><head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AWS SES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,200;0,300;0,500;1,700&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   	<style>
   		.code-sec:before{
       		position: absolute;
       		content: "";
       		background: #0000007a;
       		width: 100%;
       		height: 100%;
       	}
      	.vedio-sec:before{
       		position: absolute;
       		content: "";
       		background: #00000033;
       		width: 100%;
       		height: 100%;
		}
		.sky-sec:before{
			position: absolute;
		    content: "";
		    width: 100%;
		    height: 80px;
		    background: linear-gradient(0deg, #00538442, #00538400);
		    bottom: 0;
		    left: 0;
		    right: 0;
		}
		.fa-check{
		    font-size: 19px;
		    margin-right: 5px;
		    
		    padding: 2px 4px;
		    border-radius: 5px;
		}
		.abt-ttl{
		    width:50% !important;
		}
		.fontkaint{
		    font-family: "Kanit", sans-serif;
		}
		@media screen and (min-width: 300px) and (max-width: 650px){
    		p{
			    font-size:19px!important;
			    margin-top:50px;
			}
			ul{
			    display:block !important;
			    padding: 10px !important;
			}
			.logo-img{
			    max-width:200px !important;
			}
			.banner-img{
			    padding:0px 10px;
			}
			.service-cont{
				width:100% !important;
				margin:auto;
			}
			.service-cont1{
				width:100% !important;
				margin:auto;
				padding:20px;
			}
				    .service-cont2{
				        
				        width:90% !important;
				        
				    }
			    .police-boy{
			        
			    width: 100% !important;
			    min-width: 80px !important;
			    max-width: 89px !important;
			    margin: auto !important;
			    display: block !important;
			    padding-top: 15px !important;
			    }
    
			    .police-girl{
			    width: 100% !important;
			    min-width: 54px !important;
			    max-width: 65px !important;
			    margin: auto !important;
			    display: block !important;
			    padding-top: 30px !important;
			    }
			    
			    .police-ttl{
			        
			    font-size: 14px !important;
			    color: #000 !important;
			    padding-left: 6px !important;
			    padding-right: 6px !important;
			    font-weight: 300 !important;
			    }
			     .police-ttl2{
			        font-size: 18px !important;
			    color: #000 !important;
			    padding-left: 6px !important;
			    padding-right: 6px !important;
			    }
			    .service-cont p{
			        
			        font-size:20px !important;
			    }
			    .serve-img{
			        width:28px !important;
			    }
			    .notice-pera{
			        
			        font-size:18px !important;
			        padding-left:6px !important;
			    }
			    .abt-sec{
			        
			        display:block;
			        height:250px;
			    }
    
			    .abt-ttl{
			        font-size:16px !important;
			        width:100% !important;
			    }
			    .email-sec{
			        
			       box-shadow:none !important; 
			    }
			    .banner-sec p{
			        
			        font-size:16px !important;
			    }
			    .footer-sec img{
			        max-width: 170px !important;
			    }
    
			    .footer-sec p{
			        font-size: 15px!important;
			    }
			    .section{
			        
			        padding:0px 20px;
			    }
				.police-img{
				    width: 350px !important;
				    max-height: 150px !important;
				    background-repeat: no-repeat;
				    background-size: 100% 100% !important;
				    max-width: 100% !important;
				    margin: 0px auto 20px !important;
    			}
			    .police-img{
			        border:none !important;
			    }
			    .abt-img{
			        
			        max-height: 300px !important;

			    }
			    iframe{
			        height:200px !important;
			    }
			    
			    .police-heading{
			        
			        font-size:15px !important;
			    }
			    .police-heading2{
			        
			        font-size:13px !important;
			    }
				 .fa-check {
				    font-size: 13px;
				    margin-right: 5px;
				    
				    padding: 2px 4px;
				    border-radius: 5px;
				    margin-bottom: 10px;
				}
				.order-img{
				    
				    width: 100% !important;
				    max-width: 100%;
				    padding: 0px !important;
				}
			}
			</style>
		</head>
		<body>
      		<div class="section" style="max-width: 700px; display: block; margin: auto;">
            	<div style="padding: 0px 0px;">
					<div class="email-sec" style="width: 100%;background: #fff; padding: 0px 0px 0px 0px;box-shadow: 0px 0px 5px #b3b3b3c4;">
               			<div>
                  			<div style="width: 100%; max-width: 650px; width: 100%; margin:auto;">
                  				<div style="border-bottom: 1px solid #a9a9a938; margin-bottom: 20px; padding-bottom: 10px;">
                     				<img style="padding-top: 20px;padding-left: 10px;width: 100%; max-width: 250px;display: block;margin: auto;" src="https://cdn.savingssites.com/logo-green.png" class="logo-img" />
                     			</div>

                     			<div style="margin-bottom: 20px;">
                     				<p class="fontkaint" style="color: #38373d;font-size: 40px;line-height: 35px !important; font-weight: 500;text-align: center;margin: 0;">You Save and Your Favorite <br><span style="color: #5f9900; margin-top: 10px;">Nonprofit Also Benefits!<span></p>
                     				<p class="fontkaint" style="color: #38373d;font-size: 40px;line-height: 35px !important; font-weight: 500;text-align: center;margin: 0;">Everyone <span style="color: #5f9900; margin-top: 10px; ">Benefits!<span></p>
                     			</div>

                     			<div style=" margin: 0px auto; max-width: 650px; width: 100%;">
                        			<ul class="fontkaint" style="padding: 0px;list-style: none;margin: 0px auto;display:flex;">
                           				<li class="fontkaint" style="margin-bottom: 30px;border-right: 1px solid #fff;  box-sizing: border-box;float: left;color: white;width: 100%;text-align: center;padding-top:13px;padding-bottom: 13px;cursor: pointer;background: #333;font-size: 25px;">Residents </li>

                           				<li class="fontkaint" style="margin-bottom: 30px;border-right: 1px solid #fff;  box-sizing: border-box;float: left;color: white;width: 100%;text-align: center;padding-top:13px;padding-bottom: 13px;cursor: pointer;background: #333;font-size: 25px;">Non profits</li>

                           				<li class="fontkaint" style="margin-bottom: 30px;border-right: 1px solid #fff;  box-sizing: border-box;float: left;color: white;width: 100%;text-align: center;padding-top:13px;padding-bottom: 13px;cursor: pointer;background: #333;font-size: 25px;">Businesses</li>

                           				<li class="fontkaint" style="margin-bottom: 30px; border-right: 1px solid #fff;  box-sizing: border-box;float: left;color: white;width: 100%;text-align: center;padding-top:13px;padding-bottom: 13px;cursor: pointer;background: #333;font-size: 25px;">Municipality</li>
                         			</ul>
                     			</div>

                     			<div class="banner-img">
                        			<img style="width: 100%; max-width: 650px;display: block;margin: auto; margin-bottom: 30px;" src="https://cdn.savingssites.com/banner.png  " />
                        		</div>

                     			<div style="width: 100%; background: #bd1f36;max-width: 650px; margin:0px auto 20px; ">
                        			<p class="fontkaint" style="padding: 10px;text-align: center; color: #fff; font-size: 25px; font-weight: 500;letter-spacing: 1px;">Free $1.00 by confirming<br> that you read this email!</p>
                        		</div>
                        	</div>';
        $grocery = '<div style="width:100%;max-width: 650px;margin:0px auto 30px; display: flex; align-items: center; flex-wrap:wrap;">
            <div class="service-cont" style="width:50%;">
               	<img class="abt-img" src="https://cdn.savingssites.com/about.png" style="width: 100%; min-width: 200px; max-height: 330px;object-fit: cover;">
            </div>
           	<div class="service-cont" style="width:50%;">
                <p class="fontkaint" style="margin: 0; padding:0px; text-align: center; font-size: 30px;font-weight: 500;">Grocery Specials!</p>
                <h3 class="fontkaint" style="margin: 0; padding:0px;text-align: center; font-size: 17px;font-weight: 400;">See daily, weekly, monthly specials from local grocery stores:<button type="button" style="border: 0; padding: 5px; background: #549926;  color: #fff;margin-left: 10px;border-radius: 3px;">Grocery Stores</button> </h3>
            </div>
        </div>';                	
        foreach ($viewhtmlArr as $kf => $vf) {
        	if($kf == 'Favourities'){
				$htmlfinal .= '<div style="width:100%;max-width: 650px;margin:0px auto 30px;"><p>
    				<img style="width:100%;height:250px;object-fit: cover;" src="https://cdn.savingssites.com/banner4.jpg"/></p></div>'.$vf.'<div style="width:100%;max-width: 650px;margin:0px auto 30px;"><p>
    				<img style="width:100%;height:250px;object-fit: cover;" src="https://cdn.savingssites.com/banner6.jpg"/></p></div>'.$grocery;
        	}else if($kf == 'Snap'){
        		$htmlfinal .= '<div style="width:100%;max-width: 650px;margin:0px auto 30px;"><p>
    				<img style="width:100%;height:250px;object-fit: cover;" src="https://cdn.savingssites.com/banner5.jpg"/></p></div>'.$vf;	
        	}else{
				$htmlfinal .= $vf;
        	}
        }	
        $htmlfinal .= '<div style="width: 100%; max-width: 650px; width: 100%; margin:auto;">
	<div style="width:100%;max-width: 650px;margin:0px auto 30px;">
    	<p>
    		<img style="width:100%;height:250px;object-fit: cover;" src="https://cdn.savingssites.com/banner7.jpg"/>
    	</p>
    </div>
	
	<div style="width:100%;max-width: 650px;margin:0px auto 30px; display: flex; align-items: center;">
        <iframe style="width:100%; height: 315px;" src="https://www.youtube.com/embed/USZAofevitM?si=Gwu4_q_znG_4BCsC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>
	
	<div style="width:100%;max-width: 650px;margin:0px auto 30px;">
    	<p class="notice-pera fontkaint" style="font-size:22px;">Short Notice Alert Program (SNAP)</p>
        <p>
        	<img style="width:100%;height:250px;object-fit: cover;" src="https://cdn.savingssites.com/video.jpg"/>
        </p>
    </div>
	
	<div class="fontkaint" style="background: linear-gradient(182deg, #58972a, #070f00e3);width:100%;max-width:650px;margin:auto;height:310px;margin-bottom:20px;">
        <p style="color:#fff;text-align: center;font-size: 28px; font-weight: 500;margin: 0px 0px 20px;">New Food Ordering Feature is Coming Soon!</p>
        <img src="https://cdn.savingssites.com/food-order.png" style="padding: 3px; border: 1px solid #a5a5a54f; border-radius: 5px; width: 490px; display: block; margin: auto;background: #fff; padding-left: 15px;" class="order-img">
        <div class="abt-sec" style="width: 100%;margin: 20px auto;">
            <p class="abt-ttl fontkaint" style="width:50%;float:left;color:#fff;text-align: center;font-size: 28px; font-weight: 500; margin: 0;"><img class="fa-check" style="width:25px;" src="https://cdn.savingssites.com/check-box.png"/> Saves Money !</p>
            <p class="abt-ttl fontkaint" style="width:50%;float:left;color:#fff;text-align: center;font-size: 28px; font-weight: 500; margin: 0;"><img class="fa-check" style="width:25px;" src="https://cdn.savingssites.com/check-box.png"/> Much Faster !</p>
            <p class="abt-ttl fontkaint" style="width:50%;float:left;color:#fff;text-align: center;font-size: 28px; font-weight: 500; margin: 0;"><img class="fa-check" style="width:25px;" src="https://cdn.savingssites.com/check-box.png"/> More Accurate !</p>
            <p class="abt-ttl fontkaint" style="width:50%;float:left;color:#fff;text-align: center;font-size: 28px; font-weight: 500; margin: 0;"><img class="fa-check" style="width:25px;" src="https://cdn.savingssites.com/check-box.png"/> Safer payments !</p>
        </div>
    </div>
                      
	<div style="width: 100%;height: 60vh;max-width: 650px;margin:0px auto 20px; position: relative;" class="code-sec">
        <img class="fa-check" style="width:100%;height:100%;" src="https://cdn.savingssites.com/about-banner.jpg"/>
            <p class="fontkaint" style="margin-top:-310px;color: #fff; text-align: center;  padding-top: 55px;  font-size: 30px; font-weight: 500;position: relative;">Free $1.00 to thank you <br> for reading this email! </p>
            <p class="fontkaint" style="color: #fff; text-align: center; padding: 0;margin:0;  font-size: 20px; font-weight: 400;position: relative;">
                   			<a href="javascript:;" style="color: #fff;">Your Promo Code: 12DDGZYCRB </a>
            </p>
            <p class="fontkaint" style="color: #fff; text-align: center; padding: 0;margin:0;  font-size: 15px; font-weight: 400;position: relative;">
                <a href="javascript:;" style="color: #fff;"> Expire 23/11/2024 Restrictions Apply. </a>
            </p>
    </div>

    <div style="width: 100%;max-width: 650px;margin:0px auto 20px;background:#bd1f36;">
        <p class="fontkaint" style="padding:10px; text-align: center;color: #fff; font-size: 25px;">Free $1.00, click here and submit code on site!</p>
    </div>

	<div class="fontkaint" style="width: 100%; max-width: 650px; width: 100%; margin:20px auto;">
        <div class="footer-sec" style="margin-bottom: 20px; padding-bottom: 10px;width: 100%; max-width: 650px;margin:auto;border: 2px solid #58972a;">
            <img style="padding-top: 20px;padding-left: 10px;width: 100%; max-width: 220px;display: block;margin: auto;" src="https://cdn.savingssites.com/referral8.jpg" />
            <h3 style="font-weight: 400;line-height: 1.2;">For every referral that registers and claims a deal you get $5 credit, that is usable on any deal! Below is a sample message with your
                    unique referral link that you can copy and email to friends and family and post on social media.</h3>
            <p style="margin:0px;padding:0px;font-weight: 300;">Hi,</p>
            <p style="margin:0px;font-weight: 300;">Check out Savings Sites. It’s one source for Savings & Events. Everyone wins !</p>
            <ol style="padding:15px;">
               	<li style="margin-bottom:10px;"> Residents :  <span style="font-weight: 300;">Get quick and easy access to non-expiring digital deals from a huge number of local businesses. 
                      Also you can freely search all the fun things to do.</span></li>
                <li style="margin-bottom:10px;"> Businesses :  <span style="font-weight: 300;">Get free promotion of their deals, so there is lots to choose from.</span></li>
                <li style="margin-bottom:10px;"> Nonprofits :  <span style="font-weight: 300;">Fundraise as residents choose their favorite nonprofit to benefit.</span></li>
                <li style="margin-bottom:10px;"> Municipalities :  <span style="font-weight: 300;">Email general and emergency alerts with no taxpayer money used.
                       It’s done with their partner Microsoft in a way that protects municipalities from being forced under 
                       OPEN PUBLIC RECORDS ACT to disclose residents email addresses to anyone!</span></li>
            </ol>
            <p style="display:block;margin:0 auto;text-align:center;"><a href="'.base_url().'?refer='.$publisherrefer.'"><button>Click Here</button></a></p>
        </div>
   </div>
            
    <div style="width: 100%; max-width: 650px; width: 100%; margin:20px auto;">
        <div class="footer-sec" style="border-bottom: 1px solid #a9a9a938; margin-bottom: 20px; padding-bottom: 10px;">
            <img style="padding-top: 20px;padding-left: 10px;width: 100%; max-width: 200px;display: block;margin: auto;" src="https://cdn.savingssites.com/logo-green.png" />
            <p class="fontkaint" style="color: #333333; text-align:center; font-size:16px;">© 2023 Savings Sites. All rights reserved.</p>
        </div>
    </div>



            		';


        $htmlfinal .='</div></div></div></div></body></html>';	

        // echo $htmlfinal;die;

		// $sql="Select * from tbl_keys_awssmtp where zoneid=".$zoneid;
		$sql="Select * from tbl_keys_awssmtp where zoneid=213";
		$result=$this->CommonController->SelectRawquery($sql,'resultArray');	
 		$sql12="Select * from users inner join tbl_member on tbl_member.user_name = users.username where users.id=2494414";//.$userID;
		$result12=$this->CommonController->SelectRawquery($sql12,'resultArray');
  	if(@count($result12) != 0){	
	  	$useremail = $result12[0]['email'];
 		$sender = $result[0]['email'];
		$senderName = 'SavingsSites';
		$recipient = $useremail;
		// $recipient = 'salmannexusfleck@gmail.com';
		$usernameSmtp = $result[0]['username'];
		$passwordSmtp = $result[0]['password'];
		$host = 'email-smtp.'.$result[0]['region'].'.amazonaws.com';
		$port = 587;
		$subject = 'Crack the Amazing Deals Now!';
		$mail_aws = new PHPMailer(true);
	 	try{
			$mail_aws->isSMTP();
		    $mail_aws->setFrom($sender, $senderName);
		    $mail_aws->SMTPOptions = array(
			   	'ssl' => array(
			        'verify_peer' => false,
			        'verify_peer_name' => false,
			        'allow_self_signed' => true
			    )
				);
				$mail_aws->Username   = $usernameSmtp;
		    $mail_aws->Password   = $passwordSmtp;
		    $mail_aws->Host       = $host;
		    $mail_aws->Port       = $port;
		    $mail_aws->SMTPAuth   = true;
		    $mail_aws->SMTPSecure = 'tls';
				$mail_aws->addAddress($recipient);
		    $mail_aws->msgHTML(true);
		    $mail_aws->Subject    = $subject;
		    $mail_aws->Body       =  $htmlfinal;
		    $mail_aws->CharSet="UTF-8";
		    $mail_aws->Send();
		    echo "Email sent!" , PHP_EOL;
		  }catch(phpmailerException $e) {
		    echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
			}catch(Exception $e) {
		    echo "Email not sent. {$mail_aws->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
			}
		}else{
	    echo "User doesnt exists";
	  }
	}
	
	public function generatePRomo(){
		$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	   	$res = "";
		for ($i = 0; $i < 10; $i++) {
		    $res .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		
		$sql12="select * from tbl_promo_code where code = '".$res."' ";
		$result12= $this->CommonController->SelectRawquery($sql12 , "resultArray");

	 
		if(count($result12) != 0){
			$this->generatePRomo();
	    }else{
            return $res;
	    }
	}

  public function sendCustomemail($zoneid , $userID){
  	$postLimit = ''; 	
 		$Today=date('d/m/y');
		$promoexpiredate=Date('d/m/y', strtotime('+3 days'));
		$generatedPromoCode = $this->generatePRomo();
		
		$sql1="select * from tbl_emailformat where zoneid=".$zoneid;
 		$result=$this->CommonController->SelectRawquery($sql1,'resultArray');
 		if(@count($result) != 0){
  		$dataPattarn = json_decode($result[0]['emailformat']);
			$addlist = array();
     	foreach ($dataPattarn as $dataPattarn){ 
     		if(@$dataPattarn->value == 'Favourities'){
					$sql_option="select business.id as adid from users_favorites  INNER JOIN ads ON users_favorites.adid=ads.id  INNER JOIN business ON ads.business_id=business.id  where  users_favorites.user_id = ".$userID;
					$allfavpost=$this->CommonController->SelectRawquery($sql_option,'resultArray');      
					shuffle($allfavpost);
					$r= array_slice($allfavpost,0,8);
					if($allfavpost && ($postLimit != 'reached')){
						foreach ($r as $value) {  	
				    	if (!in_array($value['adid'],$addlist, TRUE)){			              	  
				       	array_push($addlist , $value['adid']);      
				    	}  	 
						}
					}
					array_unique($addlist);
					if(count($addlist) == 100){
						$postLimit = 'reached';
					}
				}else if(@$dataPattarn->value == 'Snap'){
					//  sanp on ads
					$sql_option1="select business.id from user_offer_status  INNER JOIN ads ON user_offer_status.adid=ads.id  INNER JOIN business ON ads.business_id=business.id  where  user_offer_status.user_id = ".$userID." and   user_offer_status.adid != '0'";
					$allSnappost=$this->CommonController->SelectRawquery($sql_option1 ,'resultArray');
					shuffle($allSnappost);
					$allSnappost= array_slice($allSnappost,0,8);
					if($allSnappost && ($postLimit != 'reached')){
						foreach ($allSnappost as $values) {  
							if (!in_array($values['id'],$addlist, TRUE)){
				        array_push($addlist , $values['id']); 
				    	}  
						}	        
					}
				}else if(@$dataPattarn->value == 'Ranked'){
					//  ranked ads 
					$ranked_sql="SELECT business.id FROM business_sponsor INNER JOIN business ON business_sponsor.business_id=business.id INNER JOIN ads ON business.id=ads.business_id WHERE business_sponsor.zone_id= ".$userID;
					$rankedsql1=$this->CommonController->SelectRawquery($ranked_sql ,'resultArray');
		 			shuffle($rankedsql1);
					$rankedsql1= array_slice($rankedsql1,0,8);
					array_unique($addlist);
					if(count($addlist) == 100){
						$postLimit = 'reached';
					}
 					if($rankedsql1 && ($postLimit != 'reached')){
						foreach ($rankedsql1 as $ranked_val) {  
				    	if (!in_array($ranked_val['id'],$addlist, TRUE)){
				        array_push($addlist , $ranked_val['id' ]);          	 
							}	        
						}
					}
				}else if(@$dataPattarn->value == 'business'){
					if (!in_array($dataPattarn->busid,$addlist, TRUE)){				         			 
		      	array_push($addlist , $dataPattarn->busid);
		      }   
				}else if(@$dataPattarn->value == 'content'){
		    	$textValue = $dataPattarn->dataValue;
	    	}
	    } 
			
			$adslistCount = 0;
 	 		$htmlAds  = '';
  	 	$overalllistCount = 0;
	 		$arrayCount = count($addlist);
 			
 			$htmlAds .= '<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 810px;" width="810"> <tbody> ';
 			foreach ($addlist as  $value) {
 				$peekaboo_id = $this->allpeekabooId($value);
				$peekaboo_type = $this->allpeekabootype($value);
				if($peekaboo_id && $peekaboo_type){
					$auction_sql_setting = 'SELECT  c.name as cat_name,ip.company_name ,ip.*, a.*,a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update  FROM tbl_deals a LEFT JOIN tbl_deals_products ip ON ip.deal_product_id=a.product_id LEFT JOIN category_new c ON c.id=ip.cat_id WHERE a.user_id='.$peekaboo_id.' AND a.member_type='.$peekaboo_type.' AND a.auction_type="RTP" order by a.start_date ASC';   
					$auction_result_setting= $this->CommonController->SelectRawquery($auction_sql_setting ,'resultArray');
					foreach ($auction_result_setting as $key =>  $auction_result_setting) {
						$savings = @$auction_result_setting['buy_price_decrease_by'] -  @$auction_result_setting['current_price'] - @$auction_result_setting['publisher_fee']; 
						$htmlAds .= '<tr style=" min-height: 472px;   width: 31%;float: left;"><td class="column column-1" data-id="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-bottom: 0px solid #ACB1BD; border-left: 0px solid #ACB1BD; border-right: 0px solid #ACB1BD; border-top: 0px solid #ACB1BD; padding-left: 15px; padding-right: 15px;" width="50%">'; 
       			if($auction_result_setting['card_img']){
       				$htmlAds .='<table border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
								<tbody><tr>
									<td style="width:100%;padding-right:0px;padding-left:0px;padding-top:15px;">
										<div align="left" style="line-height:10px"><img src="'.base_url().'/uploads/zone_mobile_resizeupload/'.$zoneid.'/'.$auction_result_setting['card_img'].'" style="display: block; height: auto; border: 0; width: 235px; max-width: 100%;" width="235"></div>
									</td>
								</tr></tbody></table>';							
						}else{
				 			$htmlAds .='<table border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
								<tbody><tr>
									<td style="width:100%;padding-right:0px;padding-left:0px;padding-top:15px;">
										<div align="left" style="line-height:10px"><img src="'.base_url().'/assets/businessSearch/images/support_orgs.jpg" style="display: block; height: auto; border: 0; width: 235px; max-width: 100%;" width="235"></div>
									</td>
								</tr></tbody></table>';	
						}

						$htmlAds .='<table border="0" cellpadding="0" cellspacing="0" class="heading_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
							<tbody><tr>
								<td style="padding-bottom:10px;padding-top:10px;text-align:center;width:100%;">
									<h1 style="margin: 0; color: #1f1f1f; direction: ltr; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; font-size: 13px; font-weight: 700; letter-spacing: normal; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0;"><strong>'.$auction_result_setting['page_title'].'</strong></h1>
								</td>
							</tr></tbody></table>
							<table border="0" cellpadding="0" cellspacing="0" class="html_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
								<tbody><tr>
									<td>
										<div align="center" style="font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;text-align:center;"><div class="our-class" style="text-align: left; font-weight: bold;"><s>$'.$auction_result_setting['current_price'].'</s> <span style="color:#bd2036">$'.$auction_result_setting['publisher_fee'].'</span> <span style="background: #000; color: #fff; font-size: 13px; padding: 5px;">$'.$savings.' OFF</span> </div></div>
									</td>
								</tr></tbody></table>
								<table border="0" cellpadding="0" cellspacing="0" class="paragraph_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
									<tbody><tr>
										<td style="padding-bottom:10px;padding-top:10px;">
											<div style="color:#000000;direction:ltr;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:14px;font-weight:400;letter-spacing:0px;line-height:120%;text-align:left;"><p style="margin: 0;"> '.$auction_result_setting['tech_description'].'</p></div>
										</td>
									</tr></tbody></table>
									<table border="0" cellpadding="0" cellspacing="0" class="paragraph_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
										<tbody><tr>
											<td style="padding-bottom:10px;padding-top:10px;">
												<div style="color:#000000;direction:ltr;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:14px;font-weight:400;letter-spacing:0px;line-height:120%;text-align:left;"><p style="margin: 0;">'.$auction_result_setting['cat_name'].'</p></div>
											</td>
										</tr></tbody></table>
										<table border="0" cellpadding="0" cellspacing="0" class="button_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
											<tbody><tr>
												<td style="padding-bottom:25px;padding-top:10px;text-align:left;">
													<!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" style="height:42px;width:114px;v-text-anchor:middle;" arcsize="3%" stroke="false" fillcolor="#bd2036"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, Verdana, sans-serif; font-size:16px"><![endif]-->
													<div style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#bd2036;border-radius:1px;width:auto;border-top:1px solid #bd2036;border-right:1px solid #bd2036;border-bottom:1px solid #bd2036;border-left:1px solid #bd2036;padding-top:5px;padding-bottom:5px;font-family:Roboto, Tahoma, Verdana, Segoe, sans-serif;text-align:center;mso-border-alt:none;word-break:keep-all;"><a href="'.base_url().'/businessSearch/search/'.$zoneid.'" style="text-decoration: none;color: #fff;padding-left:20px;padding-right:20px;font-size:16px;display:inline-block;letter-spacing:normal;"><span style="font-size: 16px; line-height: 2; word-break: break-word; mso-line-height-alt: 32px;">View Deal&nbsp;</span></a></div>
												</td>
											</tr></tbody></table> ';
								$htmlAds .= '</td></tr>';
                $adslistCount++;
              }
            }  
            $overalllistCount++;
          }
					
					$htmlAds .= '</tbody></table>';
 					
 					$html = '<!DOCTYPE html><html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
						<head>
						<title></title>
						<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
						<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
						<!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
						<!--[if !mso]><!-->
						<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css"/>
						<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css"/>
						<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css"/>
						<!--<![endif]-->
						<style>
						* {
							box-sizing: border-box;
						}
						body {
							margin: 0;
							padding: 0;
						}
						a[x-apple-data-detectors] {
							color: inherit !important;
							text-decoration: inherit !important;
						}
						#MessageViewBody a {
							color: inherit;
							text-decoration: none;
						}
						p{
							line-height: inherit
						}
						@media (max-width:830px) {
							.row-content {
								width: 100% !important;
							}
							.image_block img.big {
								width: auto !important;
							}
							.column .border {
								display: none;
							}
							.video_block .sizer {
								max-width: none !important;
							}
							table {
								table-layout: fixed !important;
							}
							.stack .column {
								width: 100%;
								display: block;
							}
						}
						</style>
						</head>
						<body style="background-color: transparent; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
							<table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: transparent;" width="100%">
								<tbody><tr><td>
									<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-1" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff;" width="100%">
										<tbody><tr><td>
											<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 810px;" width="810">
												<tbody><tr>
													<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
														<table border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%"><tr>
															<td style="padding-top:20px;width:100%;padding-right:0px;padding-left:0px;">
																<div align="center" style="line-height:10px"><a href="'.base_url().'" style="outline:none" tabindex="-1" target="_blank"><img alt="logo" class="big" src="'.base_url().'/assets/template-images/02.jpg" style="display: block; height: auto; border: 0; width: 810px; max-width: 100%;" title="logo" width="810"/></a></div>
															</td>
														</tr>
													</table>
													<table border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
														<tr>
															<td style="padding-top:20px;width:100%;padding-right:0px;padding-left:0px;">
																<div align="center" style="line-height:10px"><a href="'.base_url().'/zone/'.$zoneid.'" style="outline:none" tabindex="-1" target="_blank"><img alt="logo" class="big" src="'.base_url().'/assets/template-images/image002.png" style="display: block; height: auto; border: 0; width: 810px; max-width: 100%;" title="logo" width="810"/></a></div>
															</td>
														</tr>
													</table>
												</td></tr>
											</tbody>
										</table>
										</td>
									</tr>
								</tbody>
								</table>'.$htmlAds.' <table  align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
								<tbody><tr>
									<td>
										<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 810px;" width="810"><tbody>
											<tr>
												<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
													<table border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
											<tr>
												<td style="width:100%;padding-right:0px;padding-left:0px;">
													<div align="center" style="line-height:10px"><img class="big" src="'.base_url().'/assets/template-images/03.jpg" style="display: block; height: auto; border: 0; width: 810px; max-width: 100%;" width="810"/></div>
												</td>
											</tr>
										</table>
										</td>
									</tr>
								</tbody>
							</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-6" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
					<tbody><tr>
						<td>
							<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; background-color: #ffffff; width: 810px;" width="810">
								<tbody><tr>
									<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-bottom: 0px solid #FFFFFF; border-left: 0px solid #FFFFFF; border-right: 0px solid #FFFFFF; border-top: 0px solid #FFFFFF; padding-left: 10px;" width="50%">
										<table border="0" cellpadding="0" cellspacing="0" class="video_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
											<tr style="box-sizing: content-box;">
												<td style="box-sizing: content-box; padding-bottom: 25px; padding-left: 5px; padding-right: 5px; padding-top: 25px; width: 100%;" width="100%">
													<!--[if (mso)|(IE)]><table width="385" align="center" cellpadding="0" cellspacing="0" role="presentation"><tr><td><![endif]-->
													<div align="center" class="sizer" style="box-sizing: content-box; max-width: 385px; min-width: 310px;">
													<!--[if !vml]><!--><a class="video-preview" href="https://youtu.be/R4p89ui30yk" style="box-sizing: content-box; background-color: #5b5f66; background-image: radial-gradient(circle at center, #5b5f66, #1d1f21); display: block; text-decoration: none;" target="_blank">
													<div style="box-sizing: content-box;">
												<table background="https://img.youtube.com/vi/R4p89ui30yk/maxresdefault.jpg" border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; box-sizing: content-box; background-image: url(https://img.youtube.com/vi/R4p89ui30yk/maxresdefault.jpg); background-size: cover; min-height: 174px; min-width: 310px;" width="100%">
											<tr style="box-sizing: content-box;">
												<td style="box-sizing: content-box;" width="25%"><img alt="ratio" border="0" src="https://beefree.io/img-host/video_ratio_16-9.gif" style="display: block; box-sizing: content-box; height: auto; opacity: 0; visibility: hidden;" width="100%"/></td>
												<td align="center" style="box-sizing: content-box; vertical-align: middle;" valign="middle" width="50%">
													<div class="play-button_outer" style="box-sizing: content-box; display: inline-block; vertical-align: middle; background-color: #ffffff; border: 3px solid #ffffff; height: 59px; width: 59px; border-radius: 100%;">
													<div style="box-sizing: content-box; padding: 14.75px 22.69230769230769px;">
													<div class="play-button_inner" style="box-sizing: content-box; border-style: solid; border-width: 15px 0 15px 20px; display: block; font-size: 0; height: 0; width: 0; border-color: transparent transparent transparent #000000;"> </div>
													</div>
													</div>
												</td>
												<td style="box-sizing: content-box;" width="25%"> </td>
											</tr>
										</table>
									</div>
								</a>
							<!--<![endif]-->
							<!--[if vml]>
							<v:group xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" coordsize="385,217" coordorigin="0,0" href="https://youtu.be/R4p89ui30yk" style="width:385px;height:217px;">
							<v:rect fill="t" stroked="f" style="position:absolute;width:385;height:217;">
							<v:fill src="https://img.youtube.com/vi/R4p89ui30yk/maxresdefault.jpg" type="frame"/>
							</v:rect>
							<v:oval fill="t" strokecolor="#ffffff" strokeweight="3px" style="position:absolute;left:163;top:79;width:59;height:59">
							<v:fill color="#ffffff" opacity="100%" />
							</v:oval>
							<v:shape coordsize="24,32" path="m,l,32,24,16,xe" fillcolor="#000000" stroked="f" style="position:absolute;left:184;top:94;width:21;height:30;" />
							</v:group>
							<![endif]-->
						</div>
						<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
						</td>
					</tr>
				</table>
			</td>
			<td class="column column-2" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-right: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
			<table border="0" cellpadding="0" cellspacing="0" class="paragraph_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
				<tr>
					<td style="padding-bottom:30px;padding-left:10px;padding-right:10px;padding-top:30px;">
						<div style="color:#393d47;direction:ltr;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;font-size:14px;font-weight:400;letter-spacing:0px;line-height:120%;text-align:left;">
							<p style="margin: 0; margin-bottom: 16px;">Businesses submit deals to Savings Sites and only if the deals meet all 3 of your SNAP Filters does Savings Sites email you the deal.</p>
							<p style="margin: 0; margin-bottom: 16px;">SNAP Filters:</p>
							<p style="margin: 0; margin-bottom: 16px;">(A)Your Minimum Discount Percentage Required.<br/>(B)Your Available Days of the Week to use deals.<br/>(C)Your Available Time of the Day to use deals.</p>
							<p style="margin: 0;">Simply Click SNAP Off to SNAP On and Your SNAP Filters.</p>
						</div>
					</td>
				</tr>
			</table>
			</td>
			</tr>
			</tbody>
			</table>
			</td>
			</tr>
			</tbody>
			</table>
			<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-7" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
			<tbody>
			<tr>
			<td>
			<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 810px;" width="810">
			<tbody>
			<tr>
			<td class="column column-1" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 5px; padding-bottom: 5px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
			<table border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
			<tr>
			<td style="width:100%;padding-right:0px;padding-left:0px;">
			<div align="center" style="line-height:10px"><img class="big" src="'.base_url().'/assets/template-images/new_savv_1.jpg" style="display: block; height: auto; border: 0; width: 810px; max-width: 100%;" width="810"/></div>
			</td>
			</tr>
			</table>
			<table border="0" cellpadding="15" cellspacing="0" class="divider_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
			<tr>
			<td>
			<div align="center">
			<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
			<tr>
			<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 3px solid #FFFFFF;"><span> </span></td>
			</tr>
			</table>
			</div>
			</td>
			</tr>
			</table>
			<table border="0" cellpadding="10" cellspacing="0" class="paragraph_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
			<tr>
			<td>
			<div style="color:#393d47;direction:ltr;font-family:Ubuntu, Tahoma, Verdana, Segoe, sans-serif;font-size:16px;font-weight:400;letter-spacing:0px;line-height:120%;text-align:left;">
			<p style="margin: 0;">'.$textValue.'</p>
			</div>
			</td>
			</tr>
			</table>
			<table border="0" cellpadding="15" cellspacing="0" class="divider_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
			<tr>
			<td>
			<div align="center">
			<table border="0" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
			<tr>
			<td class="divider_inner" style="font-size: 1px; line-height: 1px; border-top: 3px solid #FFFFFF;"><span> </span></td>
			</tr>
			</table>
			</div>
			</td>
			</tr>
			</table>
			
			<table style="background: url('.base_url().'/assets/template-images/05.jpg);
			    background-repeat: no-repeat;
			    background-size: 100%;" border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
				<tbody><tr>
					<td style="width:100%;padding-right:0px;padding-left:0px;">
						<div align="center" style="font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;text-align:center;">
						<div class="our-class" style="    background: #283434a1;color: #fff;font-size: 16px;font-style: normal;font-weight: 600;padding: 80px 0 200px;">
							<h1>Free $1.50 Credits!</h1>
							<p style="line-height: 0;">Your Free $1.50 code is already on Deals page,waiting for you to simply submit it.</p>
							<p>Go there now by clicking: Get the $1.50</p>
							<a target="_blank" href="'.base_url().'/businessSearch/search/'.$zoneid.'?promo='.base64_encode($generatedPromoCode).'&exxpiresat='.$promoexpiredate.'" style="font-size: 25px;line-height: 50px;color: #fff;">Your Promo Code:'.$generatedPromoCode.'<br></a>
								<span style="font-style: normal !important;font-size:13px;text-decoration: underline;position: relative;top: 4px;">Expires  '.$promoexpiredate.'.  Restrictions Apply.</span>
							</div>
						</div>
					</td>
				</tr>
			</tbody></table>
			
			<table border="0" cellpadding="10" cellspacing="0" class="button_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
				<tbody><tr>
					<td>
						<div align="center">
							<!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" style="height:44px;width:228px;v-text-anchor:middle;" arcsize="10%" strokeweight="0.75pt" strokecolor="#005850" fillcolor="#005850"><w:anchorlock/><v:textbox inset="0px,0px,0px,0px"><center style="color:#ffffff; font-family:Tahoma, sans-serif; font-size:16px"><![endif]-->
							<div style="text-decoration:none;display:inline-block;color:#ffffff;background-color:#bd1f36;border-radius:4px;width:auto;border-top:1px solid #bd1f36;border-right:1px solid #bd1f36;border-bottom:1px solid #bd1f36;border-left:1px solid #bd1f36;padding-top:5px;padding-bottom:5px;font-family:Montserrat, Trebuchet MS, Lucida Grande, Lucida Sans Unicode, Lucida Sans, Tahoma, sans-serif;text-align:center;mso-border-alt:none;word-break:keep-all;width:100%;position: relative;top: -60px;"><a href="'.base_url().'/zone/'.$zoneid.'" style="padding-left:20px;color: #fff;padding-right:20px;text-decoration: none;font-size:16px;display:inline-block;letter-spacing:normal;"><span style="font-size: 16px; line-height: 2; word-break: break-word; mso-line-height-alt: 32px;">&nbsp;<strong>Free $1.50 Credits</strong></span>&nbsp;</a></div>
							<!--[if mso]></center></v:textbox></v:roundrect><![endif]-->
						</div>
					</td>
				</tr>
				</tbody></table>
			</td>
			</tr></tbody></table>
			</td></tr></tbody></table>
			</td></tr></tbody></table></body></html>';
		
		$sql="Select * from tbl_keys_awssmtp where zoneid=".$zoneid;
		$result=$this->CommonController->SelectRawquery($sql,'resultArray');	
 		$sql12="Select * from users inner join tbl_member on tbl_member.user_name = users.username where users.id=".$userID;
		$result12=$this->CommonController->SelectRawquery($sql12,'resultArray');
	  	if(@count($result12) != 0){
			$useremail = $result12[0]['email'];
 			$sender = $result[0]['email'];
			$senderName = 'SavingsSites';
			// $recipient = 'salmannexusfleck@gmail.com';
			$recipient = $useremail;
			$usernameSmtp = $result[0]['username'];
			$passwordSmtp = $result[0]['password'];
			$host = 'email-smtp.'.$result[0]['region'].'.amazonaws.com';
			$port = 587;
			$subject = 'Crack the Amazing Deals Now!';
			$mail_aws = new PHPMailer(true);
	 		try{
				$mail_aws->isSMTP();
		    $mail_aws->setFrom($sender, $senderName);
		    $mail_aws->SMTPOptions = array(
			   	'ssl' => array(
			        'verify_peer' => false,
			        'verify_peer_name' => false,
			        'allow_self_signed' => true
			    )
				);
				$mail_aws->Username   = $usernameSmtp;
		    $mail_aws->Password   = $passwordSmtp;
		    $mail_aws->Host       = $host;
		    $mail_aws->Port       = $port;
		    $mail_aws->SMTPAuth   = true;
		    $mail_aws->SMTPSecure = 'tls';
				$mail_aws->addAddress($recipient);
		    $mail_aws->msgHTML(true);
		    $mail_aws->Subject    = $subject;
		    $mail_aws->Body       =  $html;
		    $mail_aws->CharSet="UTF-8";
		    $mail_aws->Send();
		    echo "Email sent!" , PHP_EOL;
		  }catch(phpmailerException $e) {
		    echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
			}catch(Exception $e) {
		    echo "Email not sent. {$mail_aws->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
			}
		}else{
	    echo "User doesnt exists";
	  }
	}
}



	/**pending all**/public function addemailformat(){
		$certificate_sql_setting=$this->query="delete   FROM tbl_emailformat  where zoneid =".$_REQUEST['zone_id'];		
		$certificate_result_setting= $this->db->query($certificate_sql_setting);		
  		$this->query_certificate="INSERT INTO tbl_emailformat  SET  emailformat='".json_encode($_REQUEST['dataarray'])."'  , zoneid =".$_REQUEST['zone_id'];  
  		$this->db->query($this->query_certificate);
  	}

	/**This function is loading left panel, contents and header part*/	
  public function searchBusinessads(){
		if($_REQUEST['searchkey'] != ''){
    	$adsdata = 'select  d.username   , a.businessid   from ads_setting_preferences a INNER JOIN business b ON a.businessid=b.id INNER JOIN address c ON b.addressid=c.id INNER JOIN users d ON b.business_owner_id=d.id INNER JOIN users_groups e ON d.id=e.user_id LEFT JOIN ads f ON b.id=f.business_id LEFT JOIN ad_to_zone g ON f.id=g.adid LEFT JOIN ad_category_subcategory h ON f.id=h.adid where a.settingszoneid="'.$_REQUEST['zoneid'].'" and a.type IN(1,2) and a.isdefault IN(0,1) and a.approval IN(1,2,3,-1,-2,-3) and  d.username LIKE "%'.$_REQUEST['searchkey'].'%"  GROUP BY a.businessid ORDER BY trim(b.name) asc';
			$adsdata =   $this->CommonController->SelectRawquery($adsdata,'resultArray');
		  $html = '';
      if($adsdata){
      	foreach ($adsdata as   $value) {
		    	$html .= '<div id="b2" data-id="business" data-bid='.$value['businessid'].' data-username='.$value['username'].' class="item activeProp">'.$value['username'].' <span class="crosssign"><i class="fa fa-times" aria-hidden="true"></i></span></div>';
		    }
			}else{
				$html = '<div>No Business Found</div>';
			}
     	echo $html;
    }
    die();
   }
	
	/**pending all**/public function addingdifferentkeys($zoneid=false,$fromzoneid=0){
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'];  
		$sql="select * from others_referral_id where zoneid=".$zoneid;
		$query=$this->db->query($sql);
		$result = $query->result_array();
		
		$data['resultdata']=$result[0];
		$data['right_container'] = $this->load->view("zone/otherwebsitekeys.php", $data, true); 
		$this->common($data);
	}
	
	/**pending all**/public function allrefferals($zoneid=false,$fromzoneid=0){
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'];
		$data['common']=$this->common_first($zoneid,$fromzoneid);	
		$data['referaldata']=   $this->zone_model->refferaldata($zoneid,$fromzoneid);
		$data['right_container'] = $this->load->view("zone/allreferals.php", $data, true); 
		$this->common($data);
	}
	
	/**pending all**/public function paymentconfirmbox($zoneid=false,$fromzoneid=0){	
		$data['common']=$this->common_first($zoneid,$fromzoneid);
		$data['zone_id'] = $data['common']['zoneid'];
		$data['business_list'] = $this->business->getallbusiness_listing($zoneid);
		$data['payment_status'] = $this->business->status_payment($zoneid);
		$data['right_container'] = $this->load->view("business/paymentconfirm", $data, true); 
		$this->common($data);
	}
	
	/**pending all**/public function credittobusiness($zoneid=false,$fromzoneid=0){
		$data['common']=$this->common_first($zoneid,$fromzoneid);
		$data['zone_id'] = $data['common']['zoneid'];
		$data['business_list'] = $this->business->getallbusiness_listing($zoneid);
		$data['payment_status'] = $this->business->status_payment($zoneid);
		$data['payment_creditprice'] = $this->business->business_credit($zoneid);
		$data['right_container'] = $this->load->view("zone/credittobusiness", $data, true); 
		$this->common($data);
	}
	
	/**pending all**/public function allrefferalusers($zoneid=false,$fromzoneid=0){
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'];
		$data['common']=$this->common_first($zoneid,$fromzoneid);	
		$data['referaldata'] =  $this->zone_model->reffered_users($zoneid,$fromzoneid);
  		$data['right_container'] = $this->load->view("zone/allreferalusers.php", $data, true); 
		$this->common($data);
	}

	/**pending all**/public function embendcode_iframe($zoneid=false,$fromzoneid=0){
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'];
		$data['common']=$this->common_first($zoneid,$fromzoneid);	
		$data['right_container'] = $this->load->view("zone/embendcode_iframe.php", $data, true); 
		$this->common($data);
	}
	
	/**pending all**/public function addrefferalusers($zoneid=false,$fromzoneid=0){
        	$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'];
		$data['common']=$this->common_first($zoneid,$fromzoneid);	
		$data['referaldata']=   $this->zone_model->refferaldata($zoneid,$fromzoneid);
		$data['referalcode']=  $this->sales_zone->check_unique_referral();
		$data['right_container'] = $this->load->view("zone/addrefferalusers.php", $data, true); 
		$this->common($data);
	}

	/**pending all**/public function dealhistory($zoneid=false,$fromzoneid=0){
          	$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'];
		$data['dealsdata']=   $this->zone_model->get_all_business_deals_in_zone($zoneid,$fromzoneid);
		$data['right_container'] = $this->load->view("zone/dealhistory", $data, true); 
		$this->common($data);	
	}
       
	/**pending all**/public function peekaboohistory($zoneid=false,$fromzoneid=0){
          	$data['common']=$this->common_first($zoneid,$fromzoneid);	
		$data['userId'] = $data['common']['uid'];	
		$data['zoneid']=$data['common']['zoneid'];
		$data['dealsdata']=   $this->zone_model->get_all_business_auctions_in_zone($zoneid,$fromzoneid,$data['common']['uid']);			
		$data['right_container'] = $this->load->view("zone/peakaboohistory", $data, true); 
		$this->common($data);	
	}
	public function addDiscount(){
		$this->CommonController->deleteData('tbl_zone_discount',['zoneid' => $_REQUEST['zoneid']]);
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
		$data_peekaboo=array(
			'zoneid'=>$_REQUEST['zoneid'],
			'discount'=>$_REQUEST['array'],				 
		);
		$this->CommonController->InsertData('tbl_zone_discount', $data_peekaboo);
		if($zonesubuser != ''){
			$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'add discount',serialize($data_peekaboo));
		}
		echo json_encode(['msg' => 'Discount Added Successfully', 'type'=> 'success']);
	}
	
	/**pending all*/public function common($info){		
		$sql="SELECT Distinct * , category_sub_subcategory_new.* FROM business_sponsor_order 
 			INNER JOIN business ON business_sponsor_order.business_id=business.id 
 			left JOIN business_sponsor_order_subcat ON business_sponsor_order_subcat.bussiness_id=business.id 
 			INNER JOIN ads ON ads.business_id=business.id    INNER JOIN ad_category_subcategory ON ad_category_subcategory.adid=ads.id 
 			INNER JOIN business_sponsor ON business_sponsor.business_id=business_sponsor_order.business_id
 			INNER JOIN category_sub_subcategory_new ON ad_category_subcategory.subcatid=category_sub_subcategory_new.id 
  	    		WHERE business_sponsor.zone_id=".$info['common']['zoneid']." and category_sub_subcategory_new.status = 1 and category_sub_subcategory_new.parent_id <> -99 GROUP BY ad_category_subcategory.subcatid";
  	    	$query=$this->db->query($sql);
		$data =  json_encode($query->getResultArray()); 
		return $data;
		// $data['side_dashboard_container'] = $this->load->view("default/common/left_aside_admindashboard", $info , true); 
		// $data['left_container'] = $this->load->view("default/common/left_panel_zone", $info , true); 
		// $data['content'] = $this->load->view("content_new", $data, true);
		// $data['header']= $this->load->view("default/common/header", $data);		
		// return view('content_new');
	}

	/**pending all**/public function remove_specialcharAndSpaces($value){
		$remove_specialchar = preg_replace('/[-`~!@#$%\^&*()+={}[\]\\\\|;:\'",.><?\/]/ ', '', $value) ;

		$remove_space = str_replace(' ','',$remove_specialchar);
		if(is_numeric($remove_space)){
			return $remove_space ;
		}else{
			return $value ;
		}
	}

	/**pending all**/public function global_bus_search(){
		$zone_id = !empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : 0;
		$search_value =(!empty($_REQUEST['search_value']) ? $_REQUEST['search_value'] : '') ;
		if($search_value != ''){
			$search_value = $this->remove_specialcharAndSpaces($search_value);
		}
		$data['zone_id']=$zone_id;
		if (!get_cookie('')) {
			$cookie = array(
				'name'   => 'global_search_value',
				'value'  => $search_value,
				'expire' => time()+86500,
				'domain' => '',
				'path'   => '/',
				'prefix' => '',
			);
			set_cookie($cookie);
		}
		$this->session->set_userdata('business_search_value',$search_value);
		if($type > 0){
			$data['search_value'] = $this->zone_model->global_bus_search(0,$search_value); 
		} else {
			$data['search_value'] = $this->zone_model->global_bus_search($zone_id,$search_value); 
		}
		$result = $this->load->view('zone/subpage/global_search', $data, true);
		echo($this->dr->GetDR('','', $result, "0"));
	}
	
	/**pending all**/public function unset_business_search_value(){
		$this->session->unset_userdata('business_search_value');
	}
	
	/**pending all**/public function allreservatons($zoneid=false,$fromzoneid=0){ 
     		$data['common']=$this->common_first($zoneid,$fromzoneid);		 	
		$data['zoneid']=$data['common']['zoneid'];		
		$data['right_container'] = $this->load->view("zone/all_snapdining_restaurant_reservations", $data, true); 	
		$this->common($data);
	}
	
	public function zonedetail($page='',$fromzoneid=0,$sess_destroy=0){
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
    	if(isset($_SESSION) && $_SESSION['identity'] != ''){
    		$session_data = array(
      			'identity' => $_SESSION['identity'],
        		'username' => $_SESSION['username'],
        		'email' => $_SESSION['email'],
        		'user_id' => $_SESSION['user_id'],
        		'old_last_login' => $_SESSION['old_last_login']
      		);
      		$this->session->set($session_data);
      	}
      	
		$amazonurl = $this->myconfig->AWSimageurl;
		$subuserpageArr = ['zs1'=>'zoneinformation','zs2'=>'emailFormat','zs3'=>'referlinkgenerate','zs4'=>'paypal_as','zs5'=>'publisherdealreport','zs6'=>'orgfeereport','zsuser1'=>'zonecreatesubuser','zsuser2'=>'zoneshowsubuser','zc1'=>'managecategories','zab1'=>'addbusiness','zab2'=>'myzonebusiness','zab3'=>'ranksponsorrestaurants','zab4'=>'ranksponsorsubcat','zab5'=>'businessusers','zab6'=>'businessbidrank','zma1'=>'makenewadvertisement','zma2'=>'viewads','zcd1'=>'create_deal','zcd2'=>'viewdeals','zcd3'=>'dealreport','zcd4'=>'dealemailreport','zco1'=>'add_organization','zco2'=>'view_organization','zco3'=>'organization_users','zco4'=>'organizationfeereport','zes1'=>'everydayfoodspecial'];
		$zoneid = $this->CommonController->redirectToZone();
		$this->CronController->rankbusiness($zoneid);
	  $businessArr = $pbcashcert = $categories = $keyaws = $EmailformatingSaved = $subcatnew = $all_sponsored_business_details = $selected_display_categories = $display_categories =  $display_categories = $adsarr = $get_paypal_info = $purchasedealArr = $userpassArr = $savedorganization = $businessrankbid = $totalsumfavorg = $monthArr = $datasubuserArr1 = $show_all_org = [];
	  $login_type = $login_id = $refer_code = $user_id = $twiliossid = $twilioauthtoken = $twiliophoneno = $twiliodbid = $twiliodbactive = $twilioaudiofle = $subdomain = $datasubusername = $datasubuserzipcodesassign = '';
		$nonfavper = 10;

	  $userscrapzoneName = isset($_REQUEST['zoneName'])?$_REQUEST['zoneName']:'';
	  $subuserid = isset($_GET['subuserid'])?$_GET['subuserid']:'';
	  $subuser = isset($_GET['subuser'])?$_GET['subuser']:'';
	  $busid = isset($_GET['busid'])?$_GET['busid']:'';
	
		$scrapresponse = $this->CommonController->getAutoLogin($subuser);
		$user = $this->ionAuth->user()->row();

	  $uid = 0;
	  

	  if($userscrapzoneName != ''){
	  	return redirect()->to($scrapresponse);	
	  }
	  if($subuser != ''){
	  	$this->CommonController->setSession('subuserlogin', $subuser);
	  }
  	$pagesidebar = isset($page)?$page:'zoneinformation';
	  $subusersession = $this->CommonController->getSession('subuserlogin');

	  if($subusersession != ''){
			$subuserquery="SELECT * FROM zone_users WHERE username='".$subusersession."' AND type='zonedashboard'";
			$subuserArr = $this->CommonController->SelectRawquery($subuserquery);
			$datasubuser = isset($subuserArr[0]['data'])?$subuserArr[0]['data']:'';
			$datasubusername = isset($subuserArr[0]['username'])?$subuserArr[0]['username']:'';
			$datasubuserzipcodesassign = isset($subuserArr[0]['zipcodesassign'])?$subuserArr[0]['zipcodesassign']:'';
			if($datasubuser != ''){
					
				$combineArrsubuser = [];
				$datasubuserArr1 = unserialize($datasubuser);
				foreach ($datasubuserArr1 as $sk => $sv) {
					if(isset($subuserpageArr[$sv])){
						$combineArrsubuser[] = $subuserpageArr[$sv]; 
					}
				}
 				if(!in_array($pagesidebar, $combineArrsubuser) || $pagesidebar == 'ranksponsorrestaurants'){
					echo "<div style='width:50%;height: 250px;margin: auto;background: #c6c6c6;'><p style='padding: 90px;font-size: 25px;'>You dont have a Permission to Excess this page</p></div>";
					die;
				}
				
			}
	  }
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
	  }else{
	   	$nonfavper = $user->nonfavorgper;
	   	$session_login_details = $this->CommonController->getSession('session_login_details');
	   	$login_type = $session_login_details['type'];
	   	$login_id = $session_login_details['id'];
	   	if($login_type == 10){
		   	return redirect()->to(base_url().'/my_account/');
      }else if($login_type == 5){
       	// return redirect()->to(base_url().'/businessdashboard/businessdetail/'.$login_id.'/'.$zoneid.'/');	
       	return redirect()->to(base_url().'/businessdashboard/'.$login_id.'/businessdetail/');	

      }else if($login_type == 8){
        return redirect()->to(base_url().'/organizationdashboard/organizationdetail/'.$login_id.'/'.$zoneid.'/');
      }else if($login_type != 4){
		   	return redirect()->to(base_url());
			}

			if($login_id != $zoneid){
				 //echo base_url().'/Zonedashboard/zoneinformation/';
				//return redirect()->to(base_url().'/Zonedashboard/zoneinformation/');
			}
	  }
  	
	  $zone_name = $this->CommonController->SelectDataMultiWay('sales_zone','name','column',['id' => $zoneid]);	
	  $zone= $this->Zone_model->get_zone($zoneid);
	  $zone_owner = $this->ion_auth->user($zone['sales_rep_id'])->row();
	  $total_business = $this->Business->get_all_business($zoneid,$type='all');
	  $active_coming_soon_bus = $this->Business->get_all_business($zoneid,$type='active_comingsoon');
	  $inactive_coming_soon_bus = $this->Business->get_all_business($zoneid,$type='inactive_comingsoon');
	  $active_trial = $this->Business->get_all_business($zoneid,$type='active_trial');
    $inactive_trial = $this->Business->get_all_business($zoneid,$type='inactive_trial');
    $active_paid = $this->Business->get_all_business($zoneid,$type='active_paid');
	  $inactive_paid = $this->Business->get_all_business($zoneid,$type='inactive_paid');
	  $total_ads = $this->Ads_model->get_all_ads_in_zone($zoneid,$type='all',$approval='all');
	  $active_coming_soon = $this->Ads_model->get_all_ads_in_zone($zoneid,$type='comingsoon',$approval='active');
	  $inactive_coming_soon = $this->Ads_model->get_all_ads_in_zone($zoneid,$type='comingsoon',$approval='inactive');
	  $active_realad = $this->Ads_model->get_all_ads_in_zone($zoneid,$type='realad',$approval='active');
   	$inactive_realad = $this->Ads_model->get_all_ads_in_zone($zoneid,$type='realad',$approval='inactive');
   	$state_list = $this->States->get_state_dropdown();
   	$check_zone_logo = $this->Banner_model->checkZonelogo($zoneid);
		$theme_color = $this->SalesZone->changeTheme('all', $zoneid);
		$discountsql = "SELECT discount FROM `tbl_zone_discount` WHERE zoneid=".$zoneid;
   	$discountrate1 = $this->CommonController->SelectRawquery($discountsql,'resultArray');

   	if($discountrate1){
   	 	$discountrate= $discountrate1[0]['discount'];
   	}else{
   	  $discountrate = 0;
   	}
   	$lowerlimit = isset($lowerlimit)?$lowerlimit:1;
   	$upperlimit = isset($upperlimit)?$upperlimit:10;
		$pbcashqry = "SELECT * FROM `deal_cashcert`";	
	  $pbcashcert = $this->CommonController->SelectRawquery($pbcashqry,'resultArray');
	  if($pagesidebar == 'myzonebusiness' || $pagesidebar == 'everydayfoodspecial' || $pagesidebar == 'communicationmethod' || $pagesidebar == 'pendingbusinessbid'){
   	  $businessArr = $this->getMyZoneBusiness($zoneid,$lowerlimit,$upperlimit,$datasubusername,$datasubuserzipcodesassign);
   	}
   	if($pagesidebar == 'create_deal' || $pagesidebar == 'makenewadvertisement'|| $pagesidebar == 'viewads'){
   	  $categories = $this->Category_management_model->get_category_display_for_zone($zoneid);
   	  $subqry = 'SELECT  a.id as subcatid,a.catid,a.name as subcatname,b.id as subsubid,b.name as subsubname FROM category_subcategory_new as a LEFT JOIN category_sub_subcategory_new as b on a.id=b.parent_id where a.catid=1 AND b.parent_type ="s" ORDER BY a.id';
   	  $subcategory = $this->CommonController->SelectRawquery($subqry,'resultArray');
   	  foreach ($subcategory as $k => $v) {
   	   	$subcatnew[$v['subcatname']][] = $v;
   	  }
   	  $businessArr = $this->create_deal($zoneid,'',$busid);	
   	  foreach ($businessArr as $key => $value) {
   	 		$lowerlimit=0; $upperlimit=1000; 
		   	$adsarr[$value['name']] = $this->Ads_model->get_ads_for_business_new($value['businessid'],$uid,$lowerlimit,$upperlimit,1,$datasubusername,$datasubuserzipcodesassign); 
   	  }
   	}

   	if($pagesidebar == 'viewdeals'){
   	  $businessArr = $this->alldeals($zoneid,0,$datasubusername,$datasubuserzipcodesassign);	
   	}
   	if($pagesidebar == 'groceryspecial'){
   		$zipcodeg = [];
   		$zipqry = 'SELECT zip_code FROM zip_code_zone  WHERE zone_id='.$zoneid.'';
   	 	$zipArr = $this->CommonController->SelectRawquery($zipqry);	
   	 	if(count($zipArr) >0){
   	 		foreach ($zipArr as $kz => $vz) {
   	 			$zipcodeg[] = $vz['zip_code'];
   	 		}
   	 	}
   	 	if(count($zipcodeg) > 0){
   	 		$implodezip = implode(',', $zipcodeg);
   	 		$groqry = "select * from grocery_store WHERE zip IN (".$implodezip.")";
 			$businessArr = $this->CommonController->SelectRawquery($groqry);
   	 	}
   	}
   	if($pagesidebar == 'emailFormat'){
    	$sql1="select * from tbl_keys_awssmtp where zoneid=".$zoneid;
			$keyaws= $this->CommonController->SelectRawquery($sql1,'rowArray');
			if($keyaws == ''){
				$keyaws = [];
			}	
			$sqlEmail="select * from tbl_emailformat where zoneid=".$zoneid;
			$EmailformatingSaved=$this->CommonController->SelectRawquery($sqlEmail,'rowArray');
			if($EmailformatingSaved == ''){
				$EmailformatingSaved = [];
			}			 
    }
	  
	  if($pagesidebar == 'ranksponsorrestaurants'){
 			$all_sponsored_business_details = $this->Zone_model->get_ordered_sponsor_business($zoneid);
 			$all_sponsored_business_details=$all_sponsored_business_details;
 	  }
 	  
 	  if($pagesidebar == 'managecategories'){
      $display_categories=$this->Category_management_model->get_category_display_for_zone($zoneid);
      $selected_display_categories = $this->Category_management_model->get_display_category_for_zone($zoneid);
    }

    if($pagesidebar == 'dealemailreport' || $pagesidebar == 'dealivrreport' || $pagesidebar == 'dealsapprovaldpareport'){
			$emaildealbusiness="SELECT * FROM business_deal_approval where zoneId='".$zoneid."'";
			$purchasedealArr = $this->CommonController->SelectRawquery($emaildealbusiness,'resultArray');
    	$businessArr = $purchasedealArr;
    }
    
    if($pagesidebar == 'paypal_as'){
     	$get_paypal_info = $this->Zone_model->checkExistPaypalid($zoneid);
      if(is_array($get_paypal_info) && count($get_paypal_info) > 0){
       	$get_paypal_info = $get_paypal_info[0];	
      }else if($get_paypal_info == 0){
       	$get_paypal_info = '';	
      }
		}
		
		if($pagesidebar == 'dealreport'){
    	$pbcashqry="SELECT a.*,b.start_date,b.end_date,b.created_date,b.deal_title,b.deal_description,b.status,c.card_img,d.email,d.first_name,d.last_name,d.phone,e.purchasedAt,c.company_name,c.publisher_fee FROM tbl_deals_purchased_meta as a INNER JOIN tbl_deals as b ON a.dealID=b.deal_id INNER JOIN tbl_deals_products as c ON b.product_id=c.deal_product_id INNER JOIN users as d ON d.id=a.userId INNER JOIN tbl_deals_purchased as e ON e.userId=a.userId WHERE a.zoneId='".$zoneid."' GROUP BY b.deal_id";
			$purchasedealArr = $this->CommonController->SelectRawquery($pbcashqry,'resultArray');
		}
		
		if($pagesidebar == 'publisherdealreport'){
			$pbcashqry="SELECT a.*,b.start_date,b.end_date,b.created_date,b.deal_title,b.deal_description,b.status,c.card_img,d.email,d.first_name,d.last_name,d.phone,c.company_name,c.publisher_fee FROM tbl_deals_purchased_meta as a INNER JOIN tbl_deals as b ON a.dealID=b.deal_id INNER JOIN tbl_deals_products as c ON b.product_id=c.deal_product_id INNER JOIN users as d ON d.id=a.userId WHERE  a.zoneId='".$zoneid."' GROUP BY b.deal_id";
			$purchasedealArr = $this->CommonController->SelectRawquery($pbcashqry,'resultArray');
		}
		
		if($pagesidebar == 'orgfeereport'){
			$pbcashqry="SELECT a.*,b.*,c.*,d.fee_per FROM users as a INNER JOIN  users_groups as b ON a.id=b.user_id INNER JOIN organization as c ON a.id=c.userid LEFT JOIN org_fee as d ON a.id=d.user_id WHERE  a.zone_ID='".$zoneid."' AND b.group_id=8";
			$purchasedealArr = $this->CommonController->SelectRawquery($pbcashqry,'resultArray');
		}
    $zonename='';
		if($pagesidebar == 'emaildetailserver'){
			$sql1="select * from serveremaildetail where zone=".$zoneid."";
      $result=$this->CommonController->SelectRawquery($sql1);
      $purchasedealArr = $result;//echo"<pre>"; print_r($purchasedealArr);die('here');

      $sql="select * from organization where zoneid=".$zoneid."";
      $results=$this->CommonController->SelectRawquery($sql);
      $show_all_org=$results;

       $url = $_SERVER['SERVER_NAME'];
        $parsedUrl = parse_url($url);
        $host = explode('.', $parsedUrl['path']);
        $subdomain = $host[0];
        $zonename = $subdomain;
      
		}

		if($pagesidebar == 'showemaildetailserver'){
			$sql1="select * from emailblog where zone=".$zoneid."";
      $result=$this->CommonController->SelectRawquery($sql1);
      $purchasedealArr = $result;
		}
				
		if($pagesidebar == 'organizationfeereport'){
			$monthArr = ['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'];
			$pbcashqry="SELECT userId,zoneId,amountPurchased,purchasedAt,certificate_verify FROM  tbl_deals_purchased_meta WHERE  zoneId='".$zoneid."'";
			$purchasedArr = $this->CommonController->SelectRawquery($pbcashqry);
			$nonfavperqry="SELECT nonfavorgper,id FROM  users WHERE  id='".$uid."'";
			$nonfavperArr = $this->CommonController->SelectRawquery($nonfavperqry,'row');
			$nonfavper = isset($nonfavperArr->nonfavorgper)?$nonfavperArr->nonfavorgper:5;
			
			if(count($purchasedArr) > 0){
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
				
				$monthwisecountfavorg = $monthwisecountnonfavorg = [];
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
								$orgcomission = $v4['user_fav_org_fee'];
							}else{
								if($v4['amountPurchased'] > 0 && $nonfavper > 0){
									$orgcomission = ($v4['amountPurchased']*$nonfavper)/100;	
								}
							}
							$sumfavuser += $v4['amountPurchased'];	
							$sumfavorg += $orgcomission; 	
						}
						$totalsumfavorg[$k3] = array(
							'useramountsum' => $sumfavuser,
							'orgfavsumfee' => $sumfavorg,
							'zone_id' => $v4['zoneId']
						);
					}
				}
			}
		}
		
		if($pagesidebar == 'businessusers'){
			$userquery="SELECT a.id,a.name,b.email,b.id as userid,b.username,b.uploaded_business_password,b.phone,b.zone_ID FROM business as a INNER JOIN users as b ON b.id=a.business_owner_id WHERE b.uploaded_business_password != '' AND b.zone_ID='".$zoneid."' GROUP BY a.id order by userid DESC";
					$userpassArr = $this->CommonController->SelectRawquery($userquery,'resultArray');
		}
		
		if($pagesidebar == 'businessbidrank'){
			$userquery="SELECT id,counter,month,business_id,zone_id,business_name,sum(bid_amount) as bid_amount FROM business_bid_detail WHERE zone_id='".$zoneid."' AND status='active' GROUP BY business_id order by bid_amount DESC";
			$businessrankbid = $this->CommonController->SelectRawquery($userquery);
		}

		if($pagesidebar == 'zoneshowsubuser'){
			if($datasubusername != ''){
				$userquery="SELECT * FROM zone_users WHERE zoneid='".$zoneid."' AND type='zonedashboard' AND username='".$datasubusername."'";
			}else{
				$userquery="SELECT * FROM zone_users WHERE zoneid='".$zoneid."' AND type='zonedashboard'";
			}
			
			$businessrankbid = $this->CommonController->SelectRawquery($userquery);
		}

		if($pagesidebar == 'twilioAccount'){
			$userquery="SELECT * FROM twilioZoneAccount WHERE zoneid='".$zoneid."'";
			$businessrankbid = $this->CommonController->SelectRawquery($userquery);
			if(count($businessrankbid) > 0){
				$twiliossid = $businessrankbid[0]['twiliossid'];
				$twilioauthtoken = $businessrankbid[0]['twilioauthtoken'];
				$twiliophoneno = $businessrankbid[0]['twiliophoneno'];
				$twiliodbid = $businessrankbid[0]['id'];
				$twiliodbactive = $businessrankbid[0]['status'];
				$twilioaudiofle = $businessrankbid[0]['filename'];
			}
		}

		if($pagesidebar == 'zonecreatesubuser'){
			if($subuserid > 0){
				$userquery="SELECT * FROM zone_users WHERE id='".$subuserid."' AND type='zonedashboard'";
				$businessrankbid = $this->CommonController->SelectRawquery($userquery);
			}
		}
		/*organization start*/
		$all_claimed_zip = $this->CommonController->SelectDataMultiWay('tblClaimedZips','*','result',$arr = ['approved'=> 1,'uid'=>$uid],[],'', []);
		$joinArr[] = ['table' => 'zip_code_zone as b','link' => 'a.zip = b.zip_code','type' => 'left'];
   	$joinArr[] = ['table' => 'states as c','link' => 'a.state = c.code','type' => 'inner'];
   	$get_all_states = $this->CommonController->SelectJoinMulti('zipcode as a', $joinArr,['b.zone_id'=>$zoneid],[],[],'a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name','','','',[],'','state');
   	$whereIN = [];
   	if($pagesidebar == 'organization_users'){
   		$whereorg = ['c.Zone_ID'=>$zoneid]; 
   	}else{
   	  $whereorg = ['a.zoneid'=>$zoneid,'a.approval'=>1]; 
   	}

   	if($datasubusername != '' && $datasubuserzipcodesassign != ''){
   		$zipcodeArrexplode = explode(',', $datasubuserzipcodesassign);
   	  $whereIN = ['a.zip'=> $zipcodeArrexplode];	
   	}
		
		$joinArr1[] = ['table' => 'users as c','link' => 'a.userid = c.id','type' => 'inner'];
   	$savedorganization = $this->CommonController->SelectJoinMulti('organization as a', $joinArr1,$whereorg,$whereIN,[],'a.id as orgid,a.name as orgname,c.id as userid,c.username,c.email,c.first_name,c.last_name,a.zoneid as zoneuserid,c.status,c.uploaded_organization_password','','','',[],'','');
		/*organization end*/

		$common = $this->common_first($zoneid,$fromzoneid);
		$sql="SELECT Distinct * , category_sub_subcategory_new.* FROM business_sponsor_order INNER JOIN business ON business_sponsor_order.business_id=business.id left JOIN business_sponsor_order_subcat ON business_sponsor_order_subcat.bussiness_id=business.id INNER JOIN ads ON ads.business_id=business.id INNER JOIN ad_category_subcategory ON ad_category_subcategory.adid=ads.id INNER JOIN business_sponsor ON business_sponsor.business_id=business_sponsor_order.business_id INNER JOIN category_sub_subcategory_new ON ad_category_subcategory.subcatid=category_sub_subcategory_new.id WHERE business_sponsor.zone_id=".$common['zoneid']." and category_sub_subcategory_new.status = 1 and category_sub_subcategory_new.parent_id <> -99 GROUP BY ad_category_subcategory.subcatid";
  	$subdata = $this->CommonController->SelectRawquery($sql);
    $business_search_value = $this->CommonController->getSession('business_search_value');

    $subcatnew1 = isset($_REQUEST['subcat'])?$_REQUEST['subcat']:'';
    $all_sponsored_business_subcat = [];
    if($subcatnew1 > 0 && $pagesidebar == 'ranksponsorsubcat'){
    	$all_sponsored_business_subcat = $this->Zone_model->get_ordered_sponsor_business_sort_category($zoneid , $subcatnew1);
    }

    if($pagesidebar == 'sponser'){
    	$sql = "SELECT * FROM tbl_keys_awssponser WHERE zoneid='".$zoneid."' AND sponseractive=1 ORDER BY id ASC";
		$dataArr = $this->CommonController->SelectRawquery($sql);
		$i = 0;
		if(count($dataArr) > 0){
			foreach ($dataArr as $k => $v) {
				$i++;
				$this->CommonController->updateData('tbl_keys_awssponser',['counter'=> $i],['id'=> $v['id']]);
			}
		}

		$sql = "SELECT * FROM tbl_keys_awssponser WHERE zoneid='".$zoneid."' AND sponseractive=2 ORDER BY id ASC";
		$dataArr = $this->CommonController->SelectRawquery($sql);
		if(count($dataArr) > 0){
			foreach ($dataArr as $k => $v) {
				$i++;
				$this->CommonController->updateData('tbl_keys_awssponser',['counter'=> $i],['id'=> $v['id']]);
			}
		}



    	$sql="SELECT *  FROM tbl_keys_awssponser WHERE zoneid=".$zoneid." AND sponseractive=1";
  		$businessArr = $this->CommonController->SelectRawquery($sql);
  		$sql="SELECT *  FROM tbl_keys_awssponser WHERE zoneid=".$zoneid." AND sponseractive=2";
  		$businessArr1 = $this->CommonController->SelectRawquery($sql);
  		$businessArr = array_merge($businessArr,$businessArr1);
    }
		
		return view('Zonedashboard',array('zone' => $zone,'zone_id' => $zoneid,'zoneid' => $zoneid,'zone_name' => $zone_name,'zone_owner' => $zone_owner,'total_business'=>$total_business,'active_coming_soon_bus' => $active_coming_soon_bus,'inactive_coming_soon_bus' => $inactive_coming_soon_bus,'active_trial' => $active_trial,'inactive_trial'=> $inactive_trial,'active_paid' => $active_paid,'inactive_paid' => $inactive_paid,'total_ads' => $total_ads,'active_coming_soon' => $active_coming_soon,'inactive_coming_soon' => $inactive_coming_soon,'active_realad' => $active_realad,'inactive_realad' => $inactive_realad,'discountrate' => $discountrate,'state_list' =>$state_list,'check_zone_logo'=>$check_zone_logo,'theme_color' => $theme_color,'pagesidebar' => $pagesidebar,'businessArr' => $businessArr,'pbcashcert' => $pbcashcert,'categories' => $categories,'login_type' => $login_type,'login_id' => $login_id,'refer_code' => $refer_code,'user_id' => $user_id,'keyaws'=>$keyaws,'EmailformatingSaved'=>$EmailformatingSaved,'subcatArr'=> $subcatnew,'all_sponsored_business_details'=>$all_sponsored_business_details,'display_categories'=> $display_categories,'selected_display_categories'=>$selected_display_categories,'adsarr' => $adsarr,'addapproval'=> 1,'get_paypal_info'=> $get_paypal_info,'via' =>'','businessid' =>'','purchasedealArr' =>$purchasedealArr,'userpassArr' =>$userpassArr,'all_claimed_zip' =>$all_claimed_zip,'get_all_states' =>$get_all_states,'savedorganization' =>$savedorganization,'businessrankbid' =>$businessrankbid,'common' =>$common,'business_search_value' =>$business_search_value,'subdata' =>$subdata,'uid' =>$uid,'nonfavper' =>$nonfavper,'totalsumfavorg' =>$totalsumfavorg,'monthArr' =>$monthArr,'loginzoneid' =>$loginzoneid,'datasubuserArr1' =>$datasubuserArr1,'subuser' =>$subusersession,'twiliossid' =>$twiliossid,'twilioauthtoken' =>$twilioauthtoken,'twiliophoneno' =>$twiliophoneno,'twiliodbid' =>$twiliodbid,'twiliodbactive' =>$twiliodbactive,'twilioaudiofle' =>$twilioaudiofle,'amazonurl' =>$amazonurl,'show_all_org'=>$show_all_org,'zonename'=>$zonename,'all_sponsored_business_subcat'=>$all_sponsored_business_subcat,'subcatnew'=>$subcatnew,'subdomain'=>$subdomain,'sessionzone'=>$sessionzone,'datasubusername'=> $datasubusername));
	}
	
	public function getMyZoneBusiness($zoneid = 0,$lowerlimit = 1,$upperlimit = 10,$datasubusername = '',$datasubuserzipcodesassign = ''){
		$like = [];
		$whereIN = [];
	   $zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:$zoneid;
	   $catoption = isset($_REQUEST['catoption'])?$_REQUEST['catoption']:'';
	   $selectcatsubcat = isset($_REQUEST['selectcatsubcat'])?$_REQUEST['selectcatsubcat']:'';
   	   $joinArr[] = ['table' => 'ads_setting_preferences as b','link' => 'a.id=b.businessid','type' => 'left'];
	   $joinArr[] = ['table' => 'address as c','link' => 'c.id=a.addressid','type' => 'inner'];
   	   $joinArr[] = ['table' => 'ads as d','link' => 'd.business_id=a.id','type' => 'left'];
   	   $joinArr[] = ['table' => 'ad_to_zone as e','link' => 'd.id=e.adid','type' => 'left'];
   	   $joinArr[] = ['table' => 'users as f','link' => 'a.business_owner_id=f.id','type' => 'left'];
   	   $select = 'a.id,a.name,a.contactfirstname,a.contactlastname,f.phone,c.zip_code,a.comm_method,d.id as busadid';
   	   $where = ['b.settingszoneid' => $zoneid];
   	   
   	   if($catoption != ''){
   	   	if($catoption == 'category'){
		   $joinArr[] = ['table' => 'ad_category_subcategory as f','link' => 'd.id=f.adid','type' => 'left'];
		   $where = ['b.settingszoneid' => $zoneid,'f.catid' => $selectcatsubcat];	
   	   	}
   	   	if($catoption == 'subcategory'){
		   $joinArr[] = ['table' => 'ad_category_subcategory as f','link' => 'd.id=f.adid','type' => 'left'];
		   $where = ['b.settingszoneid' => $zoneid,'f.subcatid' => $selectcatsubcat];	
   	   	}
   	   	if($catoption == 'contains'){
   	   		$like[] = ['column' => 'a.name','match' => $selectcatsubcat,'type' => 'both'];
   	   	}
   	   	if($catoption == 'startwith'){
   	   		$like[] = ['column' => 'a.name','match' => $selectcatsubcat,'type' => 'after'];
   	   	}
   	   }
   	  if($datasubusername != '' && $datasubuserzipcodesassign != ''){
   	  	$zipcodeArrexplode = explode(',', $datasubuserzipcodesassign);
   	  	$whereIN = ['c.zip_code'=> $zipcodeArrexplode];	
   	  }
   	   $filterdataArr = [];
	   	$data = $this->CommonController->SelectJoinMulti('business as a', $joinArr,$where,$whereIN,['a.name' => 'ASC'],$select,'','','',$like);
	   	foreach ($data as $k => $v) {
	   		$filterdataArr[$v->id] = $v;
	   	}
   	   if($catoption != ''){
   	   	echo json_encode($filterdataArr);die;
   	   }else{
   	   	return $filterdataArr;
   	   }
	}
	
	/*pending all*/public function renameZone(){    
		$id = $_REQUEST['zone_id'];
		$name = $_REQUEST['zone_name'];
		$cat_option = 0;
 		if ($id == -1) {
			$uid = $this->ion_auth->user()->row()->id;
			$zoneId = $this->sales_zone->create($name, $uid, $cat_option);
			echo($this->dr->GetDR("Title", "Message", $zoneId, 0));
		} else {
			$zoneId = $this->sales_zone->rename_zone($id, $name, $cat_option);
			echo($this->dr->GetDR("Title", "Message", $zoneId, 0));
		}
	}

	

	/*penidng all*/public function check_zonename(){
		$data=array();
		$data['nonename'] = $_REQUEST['zone_name'];
		$type = $_REQUEST['type'];
		$result = $this->sales_zone->check_zonename($_REQUEST['zone_name']);
		if($type=='home')
			echo $result;
		else
			echo($this->dr->GetDR("Title", "Message", $result, 0));
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
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
		$userData = array('email' => $email,'first_name' => $firstname,'last_name' => $lastname,'phone' => $phone,'Address' => $address,'City' => $city,'State_Code' => $state,'Zip' => $zip
	);

	$this->CommonController->updateData('users',$userData,['id' => $userid]);
	if($zonesubuser != ''){
		$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Update Zone Owner Information',serialize($userData));
	}
	echo json_encode(['msg' => 'Profile updated successfully','type' => 'success']);
	die;
}
	
	public function update_password(){	 
		$userid = $_REQUEST['userid'];
		$current_pass = $_REQUEST['current_pass'];
		$new_pass = $_REQUEST['new_pass'];
		$confirm_pass = $_REQUEST['confirm_pass'];
		$username = $_REQUEST['username'];
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
		$change = $this->ion_auth->change_password($username, $current_pass, $new_pass); 
		if ($change == true){
			$message = "Update Successful";
		}else{
			$message = "No Changes Made!";
		}
		if($zonesubuser != ''){
			$array = ['username'=>$username,'currentpassword'=>$current_pass,'newpassword'=>$new_pass];
			$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Update Zone password',serialize($array));
		}
		echo json_encode(['msg' => $message,'type' => 'success']);
	}
	
	/*pending all*/ public function save_short_url(){
		$url = $_REQUEST['url'];
		$zoneId = $_REQUEST['zoneid'];
		$result = $this->sales_zone->insert_url($zoneId,$url);
		if($result == true){
			$message = "saved successfully";
		}else{
			$message = "No Changes Made";
		}
		echo($this->dr->GetDR("Save Url", $message, "", "0"));
	}

	/**pending all**/public function zonesetting($zoneid=false,$fromzoneid=0){ 	
		$data['common']=$this->common_first($zoneid,$fromzoneid);		 	
		$data['zoneid']=$zoneid;
		$data['zonepref']=$this->ads->getZonePpreferencesByZone($zoneid);
		$data['businesses_of_myzone']=$this->ads->getBusinessesOfMyZoneByZone($zoneid);
		$data['businesses_located_myzone']=$this->ads->getBusinessesLocatedInMyZone($zoneid);		
		$data['right_container'] = $this->load->view("zone/defaultsetting", $data, true); 
		$this->common($data);
	}
	
	/**pending all**/public function savespecificBusiness(){ //echo '<pre>';var_dump($_REQUEST);exit;
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
		$auto_approve_ig_by_org = $_REQUEST['auto_approve_ig_by_org'];
		$auto_approve_ig_by_business = $_REQUEST['auto_approve_ig_by_business'];
		$auto_approve_offers_announcements = 3;
		$auto_approve_banner = $_REQUEST['auto_approve_banner'];
		$auto_approve_csvupload = $_REQUEST['auto_approve_csvupload'];
		if(!empty($_REQUEST['showoffer'])){
			$showoffer = $_REQUEST['showoffer'];
		}else{
			$showoffer = 3;
		}
		$auto_approve_sticky_ad = $_REQUEST['auto_approve_sticky_ad'];
		if(!empty($_REQUEST['ischangezonetheme'])){
			$ischangezonetheme = $_REQUEST['ischangezonetheme'];
		}else{
			$ischangezonetheme = 1;
		}
		$zonetheme = ($_REQUEST['ischangezonetheme']==1) ? '' : $_REQUEST['zonetheme'];
		$notification_day = $_REQUEST['notification_day'];
		$trial_business_active = $_REQUEST['trial_business_active'];
		$sponsor_ad_text = $_REQUEST['sponsor_ad_text'];
		$data=array('zoneid'=>$zoneid,
			'auto_approve_paid_ad_myzone'=>$auto_approve_paid_ad_myzone,
			'auto_approve_paid_specific_ad_myzone'=>$auto_approve_paid_specific_ad_myzone,  //id = 85,86
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
			'auto_approve_ig_by_org'=>$auto_approve_ig_by_org,
			'auto_approve_ig_by_business'=>$auto_approve_ig_by_business,
			'auto_approve_offers_announcements'=>$auto_approve_offers_announcements,
			'auto_approve_banner'=>$auto_approve_banner,
			'auto_approve_csvupload'=>$auto_approve_csvupload,
			'displayoffer'=>$showoffer,
			'auto_approve_sticky_ad'=>$auto_approve_sticky_ad,
			'ischangezonetheme'=>$ischangezonetheme,
			'zonetheme'=>$zonetheme,
			'notification_day'=>$notification_day,		
			'trial_business_active'=>$trial_business_active,
			'sponsor_ad_text'=>$sponsor_ad_text);
		$sql="select id from zone_preferences where zoneid=".$zoneid;
		$query = $this->db->query($sql);
		if($query->row()){	
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
	
	/**pending all**/public function zonebanner($zoneid=false){ 	
		$data=array();
		$data['common']=$this->common_first($zoneid,$fromzoneid);		 	
		$data['zone_id'] = $data['common']['zoneid'] ;
		$data['all_banner']=$this->banner->all_banner($data['zone_id'],'1');
		$data['right_container'] = $this->load->view("zone/banner", $data, true); 
		$this->common($data);
	}
	
	/**pending all**/public function manage_banner_mobile($zoneid=false){ 	
		$data=array();
		$data['common']=$this->common_first($zoneid,$fromzoneid);		 	
		$data['zone_id'] = $data['common']['zoneid'] ;
		$data['all_banner']=$this->banner->all_banner($data['zone_id'],'2');
		$data['right_container'] = $this->load->view("zone/banner_formobile", $data, true); 
		$this->common($data);
	}
	
	/**pending all**/public function remove_zonelogo(){
		$zoneid = $_REQUEST['zoneid'];
		$data['check_zone_logo'] = $this->banner->deleteZonelogo($zoneid);
	}

	/**pending all**/public function tabeviewZonebanner($zone_id = ''){
		$json_arr = array();
		$all_banner_list = array();
		$viewable_id = $_REQUEST['viewable_at'];
		if(!empty($viewable_id)){
			$all_banner_list['all_banner'] = $this->banner->getBannerlist($zone_id,$viewable_id,'1');
			$json_arr['zone_id'] = $zone_id;
			$all_banner_list['zone_id'] = $zone_id;
			$json_arr['viewable_id'] = $viewable_id;
			$json_arr['html'] = $this->load->view("zone/banner_tab_change", $all_banner_list, true);
			$json_arr['rseponse_msg'] = 'success';
		}else{
			$json_arr['rseponse_msg'] = 'Failed';
		}
		echo json_encode($json_arr);
	}
	
	/**pending all**/public function tabeviewZonebannerFormobile($zone_id = ''){
		$json_arr = array();
		$all_banner_list = array();
		$viewable_id = $_REQUEST['viewable_at'];
		if(!empty($viewable_id)){
			$all_banner_list['all_banner'] = $this->banner->getBannerlist($zone_id,$viewable_id,'2');
			$json_arr['zone_id'] = $zone_id;
			$all_banner_list['zone_id'] = $zone_id;
			$json_arr['viewable_id'] = $viewable_id;
			$json_arr['html'] = $this->load->view("zone/banner_tab_changeformobile", $all_banner_list, true);
			$json_arr['rseponse_msg'] = 'success';
		}else{
			$json_arr['rseponse_msg'] = 'Failed';
		}
		echo json_encode($json_arr);
	}
	
	/**pending all**/public function addbanner($zoneid=false,$fromzoneid=0){
		$data=array();
		$data['common']=$this->common_first($zoneid,$fromzoneid);
		$data['zone_id'] = $data['common']['zoneid'] ;
		$data['all_banner']=$this->banner->all_banner($data['zone_id']);
		$data['right_container'] = $this->load->view("zone/add_banner", $data, true);
		$this->common($data);
	}
	
	/**pending all**/public function add_banner_mobile($zoneid=false,$fromzoneid=0){
		$data=array();
		$data['common']=$this->common_first($zoneid,$fromzoneid);
		$data['zone_id'] = $data['common']['zoneid'] ;
		$data['all_banner']=$this->banner->all_banner($data['zone_id']);
		$data['right_container'] = $this->load->view("zone/add_banner_mobile", $data, true);
		$this->common($data);
	}
	
	/**pending all**/public function zipcode($zoneid=false,$fromzoneid=0){ 				
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$zone= $this->zone_model->get_zone($data['common']['zoneid']);
		$data['zone'] = $zone;
		$data['zoneid']=$data['common']['zoneid'];
		$data['uid']=$data['common']['uid'];
		$data['not_zip_codes'] = $this->zip->get_zips_not_in_zone($data['zoneid'], $data['uid']);
		$data['zip_codes'] = $this->zip->get_zips_for_zone($data['zoneid']);
		$data['right_container'] = $this->load->view("zone/zipcode", $data, true); 
		$this->common($data);			
	}
	
	/**pending all**/public function claim_zips($zoneid=false,$fromzoneid=0){
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['right_container'] = $this->load->view("default/show_content_claim_zips", $data, true);
		$this->common($data);
	}
	
	/**pending all**/public function addZipToZone(){    
		$id = $_REQUEST['zone_id'];	
		$zip = $_REQUEST['zipcode'];
		$zone= $this->zone_model->get_zone($_REQUEST['zone_id']);
		$data['zone'] = $zone;
		$uid = $this->ion_auth->user()->row()->id;
		$result = "";
		if (!empty($id) && $id > 0) {
			$data = array();
			$data['zip_codes'] = $this->zip->add_zip_to_zone($id, $zip);
			$data['not_zip_codes'] = $this->zip->get_zips_not_in_zone($id, $uid);
			$data['zoneId'] = $id;
			$zip = $_REQUEST['zipcode'];
			$zone= $this->zone_model->get_zone($id);
			$data['zone'] = $zone;
			$result = $this->load->view('dashboards/zip_view', $data, true);
		}
		echo($this->dr->GetDR("", "", $result, "0"));
	}
	
	/**pending all**/public function removeZipFromZone(){    
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
			$zone= $this->zone_model->get_zone($id);
			$data['zone'] = $zone;
			$result = $this->load->view('dashboards/zip_view', $data, true);
		}
		echo($this->dr->GetDR("Delete " . $title, $message, $result, "0"));
	}
	
	/**pending all**/public function newcategory($zoneid=false,$fromzoneid=0){ 	
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid'] = $data['common']['zoneid'] ;	
		$data['right_container'] = $this->load->view("zone/new_category", $data, true); 
		$this->common($data);		
	}
	
	/**pending all**/public function save_category_zone(){     
		$zone_id = $_REQUEST['zone_id'];
		$cat_name = $_REQUEST['cat_name'];
		$sub_cat_name = $_REQUEST['sub_cat_name']; 
		$data = array('name' => $cat_name,'status' => 0,'zoneid' => $zone_id ,'zoneassigntype'=>1, 'businesstypeid'=>0,'child_type'=>'n');    	
		$this->db->insert('category_new', $data);
		$cat_id= $this->db->insert_id();
		$newdata=array('name'=>$sub_cat_name,'parent_id' => $cat_id, 'parent_type'=>'c','status' => 1,'zoneid'=>$zone_id,'zoneassigntype'=>1);
		$this->db->insert('category_sub_subcategory_new', $newdata);
		$message=1;
		echo($this->dr->GetDR("", "", $message, "0"));
	}
	
	/**pending all**/public function newsubcategory($zoneid=false,$fromzoneid=0){ 	
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'] ;
		$data['right_container'] = $this->load->view("zone/new_subcategory", $data, true); 
		$this->common($data);
	}
	
	/**pending all**/public function categories_for_new_subcategory(){	
		$zone_id = !empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$mode = !empty($_REQUEST['mode']) ? $_REQUEST['mode'] : 0 ;
		$data['categories'] = $this->zone_model->categories_for_new_subcategory($zone_id,$mode); 
		$result = $this->load->view('zone/subpage/get_categories_for_new_subcategory', $data, true);
		echo($this->dr->GetDR('','', $result, "0"));
	}
	
	/**pending all**/public function save_subcategory_zone(){
		$zone_id = $_REQUEST['zone_id'];
		$cat_id = $_REQUEST['cat_id'];
		$sub_cat_name = $_REQUEST['sub_cat_name']; 
		$newdata=array('name'=>$sub_cat_name,'parent_id' => $cat_id, 'parent_type'=>'c','status' => 1,'zoneid'=>$zone_id,'zoneassigntype'=>1);
		$this->db->insert('category_sub_subcategory_new', $newdata);
		$message=1;
		echo($this->dr->GetDR("", "", $message, "0"));
	}
	
	/**pending all**/public function viewcategorysubcategory($zoneid=false,$fromzoneid=0){ 	
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'] ;
		$user = $this->ion_auth->user()->row();
		$uid = 0;
		if(!empty($user)){ $uid = $user->id;} 
		$data['all_my_zones']=$this->sales_zone->users_all_zone($uid);
		$data['categories'] = $this->category_model->get_category_display_for_zone($data['zoneid']);
		$data['display_categories']=$this->category_model->get_display_category_for_zone($data['zoneid']);
		$data['count_categories']=count($data['categories']);
		$data['right_container'] = $this->load->view("zone/view_category_subcategory", $data, true);
		$this->common($data);
	}
	

	
	public function listofsubcategory(){
		$sql_get_categories = "SELECT distinct b.id,b.name  FROM subcategory_display a,category_sub_subcategory_new b, category_subcategory_new c WHERE a.subcatid=b.id and b.parent_id=c.id and     b.parent_type='s'   order by b.name asc";
		$cat = $this->CommonController->SelectRawquery($sql_get_categories, 'resultArray');
		$html = '<option value="0">Select Sub-Category</option>';
		foreach($cat as $categories){
        		$html .= '<option value="'.$categories['id'].'">'.$categories['name'].'</option>';
        	}
        	echo $html;
        }
	
	public function edit_sub_category_display(){	

		$zoneid = $zoneid =$_REQUEST['zoneid'];
		$catid = $_REQUEST['catid'];   
		
 		$all_subcategories = $this->Category_management_model->get_all_sub_category_for_zone($_REQUEST['catid'],$_REQUEST['zoneid']);
 		$display_subcategories=$this->Category_management_model->get_display_sub_category_for_zone($_REQUEST['zoneid'],$_REQUEST['catid']);

     
 		$cat_categoriessql = "SELECT * from  category_display where catid = ".$catid." and zoneid =".$zoneid;
		$catCat = $this->CommonController->SelectRawquery($cat_categoriessql, 'resultArray');
		$catStatus = count($catCat);
	
		if($catStatus == 0){
       	$status = 'disabled=disabled';
		}else{
	     $status = '';
		}
 
 		$table  = '';

		$count = 0;

		foreach ($all_subcategories as $type) {

			$count+= count($type);

		}

		$tot=$count-1;  
		$cnt_no=$tot/2;
		$cnt_mod=$tot%2;
		$cnt=0;
		if($cnt_mod==0){
		$cnt=floor($cnt_no);	
	     } 
		else{
		$cnt=floor($cnt_no)+1;	
		}
		 $i=1;

		   
 
         $table  .= '<table class="display responsive-table dataTable no-footer" width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0; margin-top:0;"> <tr> <td class="alllist_sub"> <table width="50%" align="left" class="pretty" style="width:49.6% ; margin-top:0;">';
 	    foreach($all_subcategories as $key=>$val){ 	     
 	    	  
            if($key=='-100'){
            	     
                foreach($val as $item_name=>$item_details){

		            $checked = '';
		        	if($item_name=='name'){
		            } 
		            else {  
		                  if(strpos(','.$display_subcategories.',',','.$item_name.',')!==false)  $checked="checked=checked";
		            	  
		                $table  .=  '<tr > <td class="subcatID"> <input type="checkbox" name="check"  class="display_checkbox1"      '.	$status.' '.$checked.' data-cat='.$item_name.'   data-zoneid='.$zoneid.'    value='.$item_name.'   />'.$item_details['name'].'</td> </tr>';
		                  if($i % $cnt == 0){				 

		                $table  .= '</table><table width="50%" align="left" class="pretty pretty_new" style="width:50.4% ; clear:none !important; margin-top:0;">';					 

						}						

						  $i++;  
					}

				    }  

				    } else { 

						foreach($val as $item_name=>$item_details){  if($item_name=='name'){             

                        $checked = '';
                        $table  .= '<tr> <td><strong><strong>'.$item_details.'</strong></strong></td>  </tr>';

                         if($i % $cnt == 0){					 

                         $table  .= '</table><table width="50%" align="left" class="pretty pretty_new" style="width:50.4% !important; clear:none !important; margin-top:0;">';					 

						}		 
                        $i++;                

                    	 } else {  
                        
                        if(strpos(','.$display_subcategories.',',','.$item_name.',')!==false)  $checked="checked=checked";

                    	$table  .= '<tr > <td class="subcatID"> <input type="checkbox" name="check" class="display_checkbox1"  '.$status.' '.$checked.' data-cat='.$item_name.'   data-zoneid='.$zoneid.'    value='.$item_name.'  />'.$item_details['name'].'</td>  </tr>';

	                    if($i % $cnt == 0){						 

	                    $table  .= '</table><table width="50%" align="left" class="pretty pretty_new" style="width:50.4% !important; clear:none !important; margin-top:0;">';					 

						}						

						 $i++;  

                        }  

                        } 
                        } 

                        } 
                 
                     $table  .= '</table>';
                     

                       if($catStatus == 1){
                     $table  .= '<input type="submit" name="update" class="sub_updatecat cus-btn" />';
                      }

                      return   $table ;

		 
	}



	/**

	* This function is updating category/subcategory(s) of a specific zone . 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> category(s) id</li>

	* <li> subcategory(s) id</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>get_all_sub_category_for_zone</b> (Model Name: category_model)</li>

	* <li><b>get_all_sub_category_for_zone</b> (Model Name: category_model)</li>

	* </ol>

	* <br>

	* view page: <b>views/zone/subpage/display_sub_category</b>

	*/

	public function save_zone_cat_display(){ 
		$catid=$_REQUEST['catid'];
		$zoneid=$_REQUEST['zoneid'];	
		$status=$_REQUEST['status'];
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
		if($status == 'all'){
			$catid = json_decode($catid);
	    foreach ($catid as  $catid) {
	    	$add_cat_to_zone=$this->Category_management_model->add_category_display($catid,$zoneid,'selected');
	    } 
    }else{
	    $add_cat_to_zone=$this->Category_management_model->add_category_display($catid,$zoneid,$status);
	  }
	  if($zonesubuser != ''){
			$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Update Categories Info',serialize(['zoneid'=> $zoneid,'catid'=> $catid,'status'=> $status]));
		}
	}

	/**

	* This function is updating category/subcategory(s) of a specific zone . 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> category(s) id</li>

	* <li> subcategory(s) id</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>get_all_sub_category_for_zone</b> (Model Name: category_model)</li>

	* <li><b>get_all_sub_category_for_zone</b> (Model Name: category_model)</li>

	* </ol>

	* <br>

	* view page: <b>views/zone/subpage/display_sub_category</b>

	*/





	/**pending all**/public function save_cat_subcat_all_my_zone(){

		$all_zone=$_REQUEST['all_zone'];

		$current_zone=$_REQUEST['current_zone'];

		$add_cat_to_zone=$this->category_model->add_category_display_all_zone($all_zone,$current_zone);

	}

	/**

	* This function is used for creating Zone directory menu . 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>get_products_details</b> (Model Name: Category_new_model)</li>

	* <li><b>get_cost_limit_details</b> (Model Name: Category_new_model)</li>

	* </ol>

	* <br>

	* view page: <b>views/directory/generate_zone_menu</b>

	* After inserting the tables, create a text file in uploads folder.

	*/

	/**pending all**/public function menu_generator($zoneid=0){ 

		$data=array();

		$data['category_list_food']=$this->Category_new_model->get_products_details($zoneid,1); 

		$data['category_list']=$this->Category_new_model->get_products_details($zoneid,0); 

		$data['category_list_other']=$this->Category_new_model->get_products_details($zoneid,14);

	    $data['startup_cost_limit']=$this->Category_new_model->get_cost_limit_details();  //fetch limit from startup_cost_limit table

		ob_start();

		$this->load->view('directory/generate_zone_menu', $data);

		$var=ob_get_contents(); 

		ob_clean();

		// $ourFileName = $zoneid.".txt";

		// $from="uploads/zone_menu/".$ourFileName;

		// $ourFileHandle = fopen($from, 'w') or die("can't open file");

		// fwrite($ourFileHandle,$var);

		// fclose($ourFileHandle);

	}

	/**

	* This function is saving subcategories for a specific category . 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> category(s) id</li>

	* <li> sub category(s) id</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>add_sub_category_display</b> (Model Name: Category_new_model)</li>

	* </ol>

	*/

	public function save_zone_sub_cat_display(){

		// $this->load->model("Category_new_model");
 
		$catid=$_REQUEST['catid'];
		$zoneid=$_REQUEST['zoneid'];
		$parentID = $_REQUEST['PCatId'];
	 

	 
             $this->CommonController->deleteData('subcategory_display',['zoneid' => $zoneid , 'catid' => $parentID ]);

              $catid = json_decode($catid);
	          foreach ($catid as  $catid) {

	             $add_cat_to_zone=$this->Category_management_model->add_sub_category_display($catid,$zoneid,$parentID);
	        
           }


	}

################################################  Zone Category/Subcategory Part End #######################################################









	

################################################  Zone Business Part Start #################################################################

	

	/**

	 * This function is help to open the All Businesses page

	 *

	 * Input Parameters:

	 * <ol>

	 * <li> zoneid</li>

	 * <li> fromzoneid( it defines whether user is ZO or BO)</li>

	 * </ol>

	 * <br>

	 * View: <b>views/zone/create_business.php</b>

	 * 

	 */

	/**pending all**/public function createbusiness($zoneid=false,$fromzoneid=0){ 			
		$data['common']=$this->common_first($zoneid,$fromzoneid);
		$data['zoneid']=$data['common']['zoneid'];
		$data['zonename'] = $this->sales_zone->get_zone($data['zoneid']);
		$data['zipcode'] = $this->zip->get_zip_for_zone($data['zoneid']);
		$data['state_list'] = $this->states->get_state_dropdown();
		$data['delete_cat_byindustry']=$this->Category_new_model->cat_display($data['zoneid']);
		$data['ckeditor_staterad'] = array(//ID of the textarea that will be replaced
			'id' => 'stater_ad_message',
			'path' => 'assets/ckeditor',
			'config' => array(//Optional values
				'toolbar' => "Full", 	// Using the Full toolbar
				'width' => "100%",	// Setting a custom width
				'height' => '350px',	// Setting a custom height
			));		
		$data['right_container'] = $this->load->view("zone/create_business", $data, true); 
		$this->common($data);			
	}



	/**

	 * This function is help to create zonecms in front page

	 

	*/

	/**pending all**/public function zonecms($zoneid=false,$fromzoneid=0){ 			

		$data['common']=$this->common_first($zoneid,$fromzoneid);

		$data['zoneid']=$data['common']['zoneid'];

		$data['state_list'] = $this->states->get_state_dropdown();

		$data['delete_cat_byindustry']=$this->Category_new_model->cat_display($data['zoneid']);//var_dump($data['delete_cat_byindustry']);exit;

		$data['ckeditor_staterad'] = array(

		//ID of the textarea that will be replaced

			'id' 	=> 	'stater_ad_message',

			'path'	=>	'assets/ckeditor',

			//Optional values

			'config' => array(

				'toolbar' 	=> 	"Full", 	//Using the Full toolbar

				'width' 	=> 	"100%",	//Setting a custom width

				'height' 	=> 	'350px',	//Setting a custom height

	    ));		

	    $data['get_zone_cms'] = $this->Category_new_model->checkExistcms($zoneid);

		$data['right_container'] = $this->load->view("zone/zone_cms", $data, true); 

		$this->common($data);			

	}



	/**pending all**/public function zone_logo_remove(){ 			

		$zoneid = $_REQUEST['zoneid'];

		$updat_column_name = $_REQUEST['remove_column_name'];

		if($updat_column_name != '')

		{

			$data_arr = array($updat_column_name => '');



			$row_img_update = $this->Category_new_model->update_zonecms($zoneid,$data_arr);

			

			echo json_encode(array('remove' => 'Exist'));

		}else{

			echo json_encode(array('remove' => 'Not Exist'));

		}

	}



	/**

	 * This function is help to create zonecms in front page

	 

	*/

	/**pending all**/public function create_zonecms(){

		//print_r($_REQUEST['leftpanel_text1_name']);

		$dataArr = array();

		//die;

		$leftpanel_text1_name 		= $_REQUEST['leftpanel_text1_name'];

		$leftpanel_text2_name 		= $_REQUEST['leftpanel_text2_name'];

		$rightpanel_text1_name 		= $_REQUEST['rightpanel_text1_name'];

		$rightpane2_text2_name 		= $_REQUEST['rightpane2_text2_name'];

		$uploadedInput_lefttop 		= $_REQUEST['uploadedInput_lefttop'];

		$uploadedInput_leftbottom 	= $_REQUEST['uploadedInput_leftbottom'];

		$uploadedInput_righttop 	= $_REQUEST['uploadedInput_righttop'];

		$uploadedInput_rightbottom 	= $_REQUEST['uploadedInput_rightbottom'];



		$leftpanel_firstlogourl_link = !empty($_REQUEST['leftpanel_firstlogourl_link']) ? $_REQUEST['leftpanel_firstlogourl_link'] : '';

		$leftpanel_secondlogourl_link = !empty($_REQUEST['leftpanel_secondlogourl_link']) ? $_REQUEST['leftpanel_secondlogourl_link'] : '';

		$rightpanel_firstlogourl_link = !empty($_REQUEST['rightpanel_firstlogourl_link']) ? $_REQUEST['rightpanel_firstlogourl_link'] : '';

		$rightpanel_secondlogourl_link = !empty($_REQUEST['rightpanel_secondlogourl_link']) ? $_REQUEST['rightpanel_secondlogourl_link'] : '';

		$zoneid 					= $_REQUEST['zoneid'];



		$_REQUEST['folder_name_rightbottom'] != '' ? $this->save_zonecmsimages($_REQUEST['folder_name_rightbottom']) : '';

		$_REQUEST['folder_name_righttop'] != '' ? $this->save_zonecmsimages($_REQUEST['folder_name_righttop']) : '';

		$_REQUEST['folder_name_leftbottom'] != '' ? $this->save_zonecmsimages($_REQUEST['folder_name_leftbottom']) : '';

		$_REQUEST['folder_name_lefttop'] != '' ? $this->save_zonecmsimages($_REQUEST['folder_name_lefttop']) : '';



		$check_existcms_byzone = $this->Category_new_model->checkExistcms($zoneid);



		$data = array('zone_id'=>$zoneid,'left_panel_first_text'=>$leftpanel_text1_name,'left_panel_first_logo'=>$uploadedInput_lefttop,

		'left_panel_second_logo'=>$uploadedInput_leftbottom,'right_panel_first_logo'=>$uploadedInput_righttop,

		'right_panel_second_logo'=>$uploadedInput_rightbottom,'left_panel_second_text' => $leftpanel_text2_name,

		'right_panel_first_text' => $rightpanel_text1_name,'right_panel_second_text' => $rightpane2_text2_name,

		'leftpanel_firstlogourl_link' => $leftpanel_firstlogourl_link,'leftpanel_secondlogourl_link' => $leftpanel_secondlogourl_link,

		'rightpanel_firstlogourl_link' => $rightpanel_firstlogourl_link,'rightpanel_secondlogourl_link' => $rightpanel_secondlogourl_link);



		if(!empty($check_existcms_byzone))

		{

			$update_zonecms = $this->Category_new_model->update_zonecms($zoneid,$data);

			$dataArr['response'] = 'success';

		}else{

			$ins_zonecms = $this->Category_new_model->saveCmscontent($data);

			$dataArr['response'] = 'success';

		}



		echo json_encode($dataArr);

	}



	/**pending all**/public function save_zonecmsimages($folder_name = '')

	{

		if(!empty($folder_name))

		{

			$explode_folder_name = explode('_',$folder_name);

			$new_folder_name = $explode_folder_name[0];

			

			$target = "./uploads/zone_logo/".$new_folder_name;

			

			if(is_dir($target)==false){

				mkdir($target,0777);

			}

			$this->load->library('upload');

			

			$get_upload_zonelogo_path = $this->config->item('upload_zonelogo_path');

			$src = $_SERVER['DOCUMENT_ROOT'].$get_upload_zonelogo_path.'temp_folder/'.$folder_name;

			$dst = $_SERVER['DOCUMENT_ROOT'].$get_upload_zonelogo_path.$new_folder_name;

			

			$this->upload->copy_directory($src,$dst);

			 

		}

	}

	

	/**

	 * This function is help to open the Delete Businesses page

	 

	 */

	/**pending all**/public function deletebusiness($zoneid=false,$fromzoneid=0){ 			

		$data['common']=$this->common_first($zoneid,$fromzoneid);

		$data['zoneid']=$data['common']['zoneid'];

		$data['state_list'] = $this->states->get_state_dropdown();

		$data['ckeditor_staterad'] = array(

		//ID of the textarea that will be replaced

			'id' 	=> 	'stater_ad_message',

			'path'	=>	'assets/ckeditor',

			//Optional values

			'config' => array(

				'toolbar' 	=> 	"Full", 	//Using the Full toolbar

				'width' 	=> 	"100%",	//Setting a custom width

				'height' 	=> 	'350px',	//Setting a custom height

	    ));		

		$data['right_container'] = $this->load->view("zone/delete_business", $data, true); 

		$this->common($data);			

	}

	/**

	 * Get zone name against zip code

	 * 

	 */

	function zip_to_zone(){	

		$zip =(!empty($_REQUEST['zip']))? $_REQUEST['zip'] : "";

		$data=array();

		$data['zip_to_zone']=$this->zip->zip_to_zone($zip); 

		$result = $this->load->view('zone/subpage/zip_to_zone', $data, true);

		//echo($this->dr->GetDR("","", $result, "0"));

		echo $result;

	}

	/**

	 * Get business mode

	 * 

	 */

	function business_mode_for_create_business(){

		$biz_mode=!empty($_REQUEST['biz_mode']) ? $_REQUEST['biz_mode'] : 1 ;

		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$data=array();

		$data['biz_mode']=$biz_mode;

		$result = $this->load->view('zone/subpage/get_business_mode', $data, true);

		echo($this->dr->GetDR('','', $result, "0"));

	}

	/**

	 * Get category for create business

	 * 

	 */

	public function category_for_create_business(){
		
		$biz_type=isset($_REQUEST['biz_type'])?$_REQUEST['biz_type'] : 2 ;
		$zoneid=isset($_REQUEST['zoneid'])?$_REQUEST['zoneid'] : 0 ;
		$biz_mode=isset($_REQUEST['biz_mode'])?$_REQUEST['biz_mode'] : 1 ;
		$business_is_restaurant=isset($_REQUEST['business_is_restaurant']) ? $_REQUEST['business_is_restaurant'] : 0 ;
		$category_list = $this->Category_new_model->get_all_categories_zone_create_business($biz_mode,$biz_type,$zoneid,'create_business',4,$business_is_restaurant);
		echo json_encode($category_list);
	}
	
	public function subcat_for_create_business(){ 
		$catid=!empty($_REQUEST['catid']) ? $_REQUEST['catid'] : 0 ;
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$data=array();
		$data['sub_category_list']= $this->Category_new_model->get_all_subcategories_zone($catid,$zoneid,'create_business'); 
		$result = view('includes/zone/subpage/get_subcat_create_business', $data);
		echo $result;

	}

	public function subcat_for_create_businessnew(){ 
		$catid=!empty($_REQUEST['catid']) ? $_REQUEST['catid'] : 0 ;
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		

		$result = $this->CommonController->SelectDataMultiWay('category_new','id,child_type,name','resultArray',['id'=> $catid]);
		echo "<pre>";print_r($result);
		if(isset($result)){
			if($result[0]['child_type']=='y'){
				$sql_2="SELECT b.id,b.name,c.id as group_id,c.name as group_name FROM subcategory_display a,category_sub_subcategory_new b, category_subcategory_new c WHERE a.subcatid=b.id and b.parent_id=c.id and a.catid=".$catid." and a.zoneid=".$zoneid." and b.parent_type='s' and c.catid=".$catid." order by b.name asc"; 													
			}else if($result[0]['child_type']=='n'){
				$sql_2="SELECT b.id,b.name FROM subcategory_display a,category_sub_subcategory_new b WHERE a.subcatid=b.id and a.catid=b.parent_id and a.catid=".$catid." and a.zoneid=".$zoneid." and b.parent_type='c' order by b.name asc"; 
			}
		}
		$result_2 = $this->CommonController->SelectRawquery($sql_2, 'resultArray');

		$html = '';
		if($result[0]['child_type']=='y'){
			$subcatArr = [];
			foreach ($result_2 as $k => $v) {
				$subcatArr[$v['group_name']][] = $v;
			}

			foreach ($subcatArr as $gk => $gv) {
                        	$html .= '<option disabled>'.$gk.'</option>';
				foreach ($gv as $gk1 => $gv1) {
					$html .= '<option value='.$gv1['id'].'>'.$gv1['name'].'</option>';
				}
			}
			
		}else if($result[0]['child_type']=='n'){
			foreach ($result_2 as $k => $gv1) {
				$html .= '<option value='.$gv1['id'].'>'.$gv1['name'].'</option>';
			}
		}

		echo $html;
	}

	/**

	 * Checking username for create business

	 * 

	 */

	function check_username(){

		$data=array();

		$data['username'] = $_REQUEST['user_name'];

		$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';

		$result = $this->users->check_username($_REQUEST['user_name']); 

		if($type=='home')

			echo $result;

		else

			echo($this->dr->GetDR("Title", "Message", $result, 0));

	}

	/**

	  * this function is used to to load jotform upload view part

	  * @param zone id

	  * return view display



	*/

	/**pending all**/public function uploadjotform($zoneid,$fromzoneid=0){

		$data['common']=$this->common_first($zoneid,$fromzoneid);		

		$data['zoneid']=$data['common']['zoneid'];

		$data['jotform_category_data'] = $this->zone_model->fetch_jotform_zonecategory($zoneid);

		/*var_dump($data['jotform_category_data']);

		exit();*/

		$data['right_container'] = $this->load->view("zone/jotform", $data, true); 

		$this->common($data);

	}

	/**

	  * @description to view jotform

	  * @param zone id

	  * return view display

	*/

	/**pending all**/public function viewjotform($zoneid,$fromzoneid=0){

		/*$data['common'] = $this->common_first($zoneid,$fromzoneid);

		$data['zoneid'] = $data['common']['zoneid'];*/

		$data['right_container'] = $this->load->view('zone/jotform_page');

		/*$this->common($data);*/

	}

	

	

	function add_business_check_username(){

		$data=array();

		$data['username'] = $_REQUEST['user_name'];

		$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';

		$result = $this->users->add_business_check_username($_REQUEST['user_name']); 

		/*if($type=='home')

			echo $result;

		else

			echo($this->dr->GetDR("Title", "Message", $result, 0));*/

		echo $result;

	}

	/**

	 * Get existing business owner for create business

	 * 

	 */

	function existing_business_owner_for_zone(){

		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$data=array();

		$data['existing_business_owner_for_zone']=$this->zone_model->get_existing_business_owner_for_zone($zoneid);

		$result = $this->load->view('zone/subpage/existing_business_owner_for_zone', $data, true);

		echo($this->dr->GetDR('','', $result, "0"));

	}











	/**

	* This function is used for manually create business. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> userid</li>

	* <li> Other many inputs from view page.</li>

	* </ol>

	* Table : <b>ad_setting_preferences, address, business, ads, ad_to_zone, ads_category_subcategory, users, user_groups</b>

	*/
	function upload_business_greetings(){
		$saved_audio = isset($_REQUEST['saved_audio'])?$_REQUEST['saved_audio']:'';
		$path = FCPATH . 'assets/audio';
		$valid_formats = array("mp3", "wav");
		$file = $_FILES['file']['name']; 
        $size = $_FILES['file']['size'];
		$ext = explode(".", $file);
		$ext1 = end($ext);
		if($saved_audio != ''){
			$oldfile = $path.'/'.$saved_audio;
			unlink($oldfile);
		}
        if(in_array($ext1,$valid_formats)){
        	$actual_image_name = $txt.".".$ext;
        	$name = time().$file;
            $tmp = $_FILES['file']['tmp_name'];
            if(move_uploaded_file($tmp, $path.'/'.$name)){
            	echo json_encode(array('type'=>'success','msg' => 'uploaded successfully','data' => $name));
            }else{
                echo json_encode(array('type'=>'warning','msg' => 'Something went wrong','data' => ''));
            }
        }else{
        	echo json_encode(array('type'=>'error','msg' => 'Please select MP3, WAV Format Only','data' => ''));
        }
	}
	public function create_business(){
		print_r($_REQUEST);die('here');
		$auser = $this->ion_auth->user()->row();		
		$uid = $auser->id; 
		$zipcode = !empty($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : 0 ;
		$zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$name = !empty($_REQUEST['name']) ? $_REQUEST['name'] : '';
		$motto = !empty($_REQUEST['motto']) ? $_REQUEST['motto'] : '' ;
		$aboutus = !empty($_REQUEST['aboutus']) ? $_REQUEST['aboutus'] : '' ;
		$contactemail = !empty($_REQUEST['contactemail']) ? $_REQUEST['contactemail'] : '';
		$contactfirstname = !empty($_REQUEST['contactfirstname']) ? $_REQUEST['contactfirstname']: '' ;
		$contactlastname = !empty($_REQUEST['contactlastname']) ? $_REQUEST['contactlastname'] : '' ;
		$contactfullname = !empty($_REQUEST['contactfullname']) ? $_REQUEST['contactfullname'] : '' ; 
		$street1 = !empty($_REQUEST['street1']) ? $_REQUEST['street1'] : '' ;
		$street2 =  !empty($_REQUEST['street2']) ? $_REQUEST['street2'] : '' ;
		$city = !empty($_REQUEST['city']) ? $_REQUEST['city'] : '' ;
		$state = !empty($_REQUEST['city']) ? $_REQUEST['state'] : '' ;
		$phone = !empty($_REQUEST['phone']) ? str_replace("-", "", $_REQUEST['phone']) : '' ;
		$alternate_phone = !empty($_REQUEST['alternate_phone']) ? str_replace("-", "", $_REQUEST['alternate_phone']) : '' ;
		$phone_int = !empty($_REQUEST['phone_int']) ? $_REQUEST['phone_int'] : 0 ;
		$website = !empty($_REQUEST['website']) ? $_REQUEST['website'] : '';
		$restaurant_type = !empty($_REQUEST['restaurant_type']) ? $_REQUEST['restaurant_type'] : 0;
		$siccode = !empty($_REQUEST['siccode']) ? $_REQUEST['siccode'] : '';
		$audio_presentation = !empty($_REQUEST['audio_presentation']) ? $_REQUEST['audio_presentation'] : 0 ;
		$video_presentation = !empty($_REQUEST['video_presentation']) ? $_REQUEST['video_presentation'] : 0 ;
		$owner_account = !empty($_REQUEST['owner_account']) ? $_REQUEST['owner_account'] : 0 ;
		$biz_username = !empty($_REQUEST['biz_username']) ? $_REQUEST['biz_username'] : '' ;
		$biz_username = str_replace('-','',$biz_username);
		$biz_password = !empty($_REQUEST['biz_password']) ? $_REQUEST['biz_password'] : '' ;
		$existing_bo = !empty($_REQUEST['existing_bo']) ? $_REQUEST['existing_bo'] : '' ;
		$biz_mode = !empty($_REQUEST['biz_mode']) ? $_REQUEST['biz_mode'] : 0 ;
		$biz_type = !empty($_REQUEST['biz_type']) ? $_REQUEST['biz_type'] : 0 ;
		$catid=!empty($_REQUEST['catid']) ? $_REQUEST['catid'] : '0';
		$subcatid=!empty($_REQUEST['subcatid']) ? $_REQUEST['subcatid'] : '0';
		$stater_ad = !empty($_REQUEST['stater_ad']) ? $_REQUEST['stater_ad'] : ''; 
		$show_profile = isset($_REQUEST['biz_profile_check'])?$_REQUEST['biz_profile_check']:1;
		$miles=!empty($_REQUEST['miles']) ? $_REQUEST['miles'] : '0';
		$deliveryCharges= !empty($_REQUEST['deliveryCharges']) ? $_REQUEST['deliveryCharges'] : '' ; 
 		$deliveryTime= !empty($_REQUEST['deliveryTime']) ? $_REQUEST['deliveryTime'] : '' ; 
		$audio_greetings= !empty($_REQUEST['audio_greetings']) ? $_REQUEST['audio_greetings'] : '' ; 
		$service_number = !empty($_REQUEST['service_number']) ? $_REQUEST['service_number'] : '' ; 
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';


		/*check phone number exists*/
		$usernameqry="SELECT a.phone,b.group_id FROM users as a INNER JOIN users_groups as b ON a.id=b.user_id WHERE a.username = '".$name."'";
		$usernameexists = $this->CommonController->SelectRawquery($usernameqry,'count');
		if($usernameexists > 0){
			echo json_encode(['msg'=>'UserName Already Exists','type'=>'warning']);
			die;
		}
		$userorgquery="SELECT a.phone,b.group_id FROM users as a INNER JOIN users_groups as b ON a.id=b.user_id WHERE a.phone = '".$phone."' AND b.group_id=5";
		$userexists = $this->CommonController->SelectRawquery($userorgquery,'count');
		if($userexists > 0){
			echo json_encode(['msg'=>'User Phone Number Already Exists, Please Use Another Phone Number','type'=>'warning']);
			die;
		}
		$userorgnoquery="SELECT a.phone,b.group_id FROM users as a INNER JOIN users_groups as b ON a.id=b.user_id WHERE a.email = '".$contactemail."' AND b.group_id=5";
		$userenoxists = $this->CommonController->SelectRawquery($userorgnoquery,'count');
		if($userenoxists > 0){
			echo json_encode(['msg'=>'User Email Already Exists, PLease Use Another Email Address','type'=>'warning']);
			die;
		}
		/*check phone number exists*/







		
		$timestamp = time();
		$arr = explode('\n',$stater_ad) ;
		$deal = $address = '';
		
		foreach( $arr as $val ){ $deal .= $val ;}
		$stater_ad = $deal ;
		$user_mode = ($biz_mode == 2) ? 13 : 4 ;
		$ad_startdatetime = !empty($_REQUEST['ad_startdatetime']) ? $_REQUEST['ad_startdatetime'] : '';
		$ad_stopdatetime = !empty($_REQUEST['ad_stopdatetime']) ? $_REQUEST['ad_stopdatetime'] : '';
		$deliver = !empty($_REQUEST['deliver']) ? $_REQUEST['deliver'] : 0 ;
		
		if($zone_id != -1){
			$sql_get_zone_owner_email = "SELECT b.id , b.name , a.email , a.first_name , a.last_name,b.subdomainZone FROM users a , sales_zone b WHERE a.id = b.sales_rep_id AND b.id=".$zone_id;
			$res_zone_owner_email = $this->CommonController->SelectRawquery($sql_get_zone_owner_email,'resultArray');
			$ZO_email = $res_zone_owner_email[0]['email'];
			$ZO_fname = $res_zone_owner_email[0]['first_name'];
			$ZO_lname = $res_zone_owner_email[0]['last_name'];
			$zone_id = $res_zone_owner_email[0]['id'];
			$ZO_name = $res_zone_owner_email[0]['name'];
			$subdomainZone = $res_zone_owner_email[0]['subdomainZone'];
		} 
		if ($street1 != '') { $address .= $street1;}
		if ($street2 != '') {
			if ($address != '') { $address .= ',' . $street2;
			} else { $address .= $street2;}
		}
		if ($city != '') {
			if ($address != '') { $address .= ',' . $city;
			} else { $address .= $city; }
		}
		if ($state != '') {
			if ($address != '') { $address .= ',' . $state;
			} else { $address .= $state; }
		}
		if ($zipcode != '') {
			if ($address != '') { $address .= ',' . $zipcode;
			} else { $address .= $zipcode; }
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
		$lat = $long='';
		
		if(is_object($response_a) && isset($response_a->results[0])){
			$lat = $response_a->results[0]->geometry->location->lat;
			$long = $response_a->results[0]->geometry->location->lng;
		}
		
		if($owner_account==1){
			$business_owner_id=$uid;
		}else if($owner_account==2 ){ 
			$additional_data = array('first_name' => $contactfirstname,'last_name' => $contactlastname, 'company' =>$name,'phone' => $phone, 'alternate_phone' => $alternate_phone);
			$franchise_arr = array();
			$franchise_arr['franchisor'] = ($biz_mode == 2) ? 13 : '' ; 
			
			if($franchise_arr['franchisor'] == 13){
				$business_owner_id = $this->ion_auth->register($biz_username, $biz_password, $contactemail, $additional_data, $franchise_arr);
			}else{ 
				$groups = array('group_id'=> 5);
				$business_owner_id = $this->ion_auth->register($biz_username, $biz_password, $contactemail, $additional_data,$groups);
			}
		}else if($owner_account==3){
			$business_owner_id=$existing_bo;
		}else{
			$groups = array('group_id'=> 5);
			$business_owner_id = $this->ion_auth->register($biz_username, $biz_password, $contactemail, $additional_data,$groups);	
		}
		
		// Password Update For Uploaded Business 
		if($business_owner_id != '' && $biz_type == 3 && $biz_password != ''){
			$this->ion_auth->update_uploadbusiness_password($business_owner_id,$biz_password);
		}
		
		$data = array(
			'name' => $name,
			'contactemail' => $contactemail,
			'contactfirstname' => $contactfirstname,
			'contactlastname' => $contactlastname,
			'contactfullname' => $contactfullname,
			'motto' => $motto ,
			'aboutus' => $aboutus,
			'timestamp' => time(),
			'siccode' =>$siccode,
			'created_by' =>$uid,
			'business_owner_id' => $business_owner_id,								
			'website'=> $website,
			'type'=> $restaurant_type,
			'audio_presentation'=>$audio_presentation,
			'video_presentation'=> $video_presentation,	
			'trialstarted' => time(),
			'audio_greetings' => $audio_greetings,
			'service_number' => $service_number,
		); 
		
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
		if($zonesubuser != ''){
			$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Create New Business',serialize($data));
		}
		$data['addressid'] = $this->CommonController->InsertData('address', $addressData);
		$id = $this->CommonController->InsertData('business', $data);
		
		$bSponsorData = array(
			'business_id' => $id,
			'status' => '1',
			'zone_id' => $zone_id		           
		);
       		
       		$this->CommonController->InsertData('business_sponsor', $bSponsorData);
		$bbusiness_sponsor_orderData = array(
			'business_id' => $id,
			'display_order' => '1'
		);
		$this->CommonController->InsertData('business_sponsor_order', $bbusiness_sponsor_orderData);
       		
       		if($biz_type == 3  && $biz_mode==0){
			$data['pass']=$this->Zone_model->update_password($business_owner_id);
		}
		
		$data_peekaboo=array(
			'fName'=>$contactfirstname,
			'lName'=>$contactlastname,
			'email'=>$contactemail,
			'address1'=>$street1,
			'address2'=>$street2,
			'company_name'=>$name,
			'city_name'=>$city,
			'state_name'=>$state,
			'post_code'=>$zipcode,
			'phone'=>$phone,
			'user_name'=>$biz_username,
			'password'=>sha1($biz_password),
			'activated'=>'yes',
			'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),
			'member_type'=>2
		);

		$peekaboo_id  = $this->CommonController->InsertData('tbl_member', $data_peekaboo);
		$message_body = '';			
		$message_body.= '<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">
			<div style="width:960px; margin:0 auto !important;">
			<div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">
			<div style="background-color:#3f3f3f; height:70px;"><img src="http://www.savingssites.com/assets/images/logo_white.png" style="margin:10px 202px;" alt="logo"/></div>
			<div style="clear:both"></div>
			<div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:300px; padding:15px;">
			<h2 style="text-align:left;">Hi'."  ".$ZO_fname.', 
			</h2><h3 style="text-align:left; display:block; color:#666;"> A new business owner has registered in: '.$ZO_name.'</h3>
			<h3><p style="text-align:left; display:block; color:#333;">Business Name: '.$name.'</p></h3>
			<h3><p style="text-align:left; display:block; color:#333;">First Name: '."  ".$contactfirstname.'</p></h3>
			<h3><p style="text-align:left; display:block; color:#333;">Last Name: '.$contactlastname.'</p></h3>
			<h3><p style="text-align:left; display:block; color:#333;">Phone Number : '.$phone.'</p></h3>
			<h3><p style="text-align:left; display:block; color:#333;">Email: '.$contactemail.'</p></h3>';
		
		if($street1!=''){	
			$message_body.= '<h3><p style="text-align:left; display:block; color:#333;">Street Address: '.$street1.'</p></h3>';
		} else if($city!=''){
			$message_body.= '<h3><p style="text-align:left; display:block; color:#333;">City: '.$city.'</p></h3>';
		} else if($state!=''){
			$message_body.= '<h3><p style="text-align:left; display:block; color:#333;">State: '.$state.'</p></h3>';
		} else if($zipcode!=''){
			$message_body.= '<h3><p style="text-align:left; display:block; color:#333;">Zip: '.$zipcode.'</p></h3>';
		}
		
		$message_body.= '<h3><p style="text-align:left; display:block; color:#333;">Business Credentials Info - </p></h3>
			<h3><p style="text-align:left; display:block; color:#333;">Username: '.$biz_username.'</p></h3>
			<h3><p style="text-align:left; display:block; color:#333;">Best Regards</p></h3>
			<h3><p style="text-align:left; display:block; color:#333;">Savings Sites</p></h3>
			<h3><p style="text-align:left; display:block; color:#333;"><a href="http://'.$subdomainZone.'.savingssites.com">savingssites.com</a></p></h3></div>
			<div style="background-color:#999; height:60px;"></div></div></div></body>';		

		$fromemail=$this->myconfig->adminEmailId;
		$this->CommonController->SendMail($fromemail,$ZO_email,'New Business Registration',$message_body);
		
		$grid=4;		
		$data['save_default_zone_ads_pref'] = $this->Zone_model->save_business_approval($id,$zone_id,$user_mode,$biz_type,$grid);
		$data['stater_ad']=$this->Zone_model->save_stater_ad_business($id,$zone_id,$stater_ad,$catid,0,$grid,$ad_startdatetime,$ad_stopdatetime,$deliver,$miles,$deliveryCharges,$deliveryTime);
		$ad_id=$data['stater_ad']; 
		$data['ads_save_cat_subcat'] = $this->Category_new_model->ads_save_cat_subcat($ad_id,$catid,$subcatid,$zone_id,'create_business');
		// $update_zone_menu=$this->menu_generator($zone_id);

		if($show_profile == 0)
			echo json_encode(['type' => 'success','msg' => 'Profile Updated','data' => 1]);
		else if($show_profile == 1)
			echo json_encode(['type' => 'success','msg' => 'Business Created Successfully','data' => $id]);
	}



	

	/**

	 * Left pannel trial business expiration 

	 *

	 */

	/**pending all**/public function trial_business_expiration($zoneid=false,$fromzoneid=0){

		$data['common']=$this->common_first($zoneid,$fromzoneid);		

		$data['zoneid']=$data['common']['zoneid'];

		$data['right_container'] = $this->load->view("zone/trial_business_expiration.php", $data, true); 

		$this->common($data);	

	}

	

	

	/**

	* View on free trial business filter 

	*

	*/

	

	/**pending all**/public function all_freetrial_business_expiration_filtering(){	

		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$business_type=!empty($_REQUEST['business_type']) ? $_REQUEST['business_type'] : 0 ; 

		$business_type_by_category=!empty($_REQUEST['business_type_by_category']) ? $_REQUEST['business_type_by_category'] : '' ;

		$business_zone = 2;

		$charval_name=!empty($_REQUEST['bus_search_by_name']) ? $_REQUEST['bus_search_by_name'] : 'all';

		if($charval_name != ''){

			$charval_name = $this->remove_specialcharAndSpaces($charval_name) ;	// Override with removable value

		}

		$charval_alphabet=!empty($_REQUEST['bus_search_by_alphabet']) ? $_REQUEST['bus_search_by_alphabet'] : '-1';

		### check the search criteria

		if($charval_name=='all' && $charval_alphabet=='-1'){

			$charval='all';

		}else if($charval_name!='all' && $charval_alphabet=='-1'){

			$charval=$charval_name;

		}else if($charval_name=='all' && $charval_alphabet!='-1'){

			$charval=$charval_alphabet;

		}

		

		$lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0 ;

		$upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 10 ; 

		// + Select drop down value this function are sorting in the business

		$data['non_temp_business_in_zone'] = $this->zone_model->get_all_trialbusiness_expiration_in_zone($zoneid,$charval,$lowerlimit,$upperlimit); 

		$data['notificationday_remains'] = $this->zone_model->notificationday_remains($zoneid); 

		$notification_day = $data['notificationday_remains']['notification_day'];//var_dump('-'.$notification_day.' day');exit;

	    $temp_arr  = array();

		    // + Calculate time stamp value  

			if(!empty($data['non_temp_business_in_zone']) && $charval!='all'){

				// + For exipre business 

				if($charval == 61){

					foreach($data['non_temp_business_in_zone'] as $key1=>$val1){

						if($val1['statuschangingtimestamp'] != 0){

							$bus_statuschanging_time = $charval;

							$current_timestamp = strtotime('midnight'); 

							$bus_post_time = $val1['statuschangingtimestamp'];

							$bus_approval = $val1['approval'];

							$bus_expire_time = strtotime('+'.$notification_day, $bus_post_time);

							$diffrence_time = $bus_expire_time - $current_timestamp;

							if($bus_post_time <= strtotime('-'.$notification_day.' day', $current_timestamp)){

								$temp_arr['businessdata'][$key1] = $val1 ;

							}

						}

					}

				}else{

			    // + For free trial viewable expire business 

				foreach($data['non_temp_business_in_zone'] as $key1=>$val1){

					if($val1['statuschangingtimestamp'] != 0){

					$bus_statuschanging_time = $charval;

					$current_timestamp = strtotime('midnight'); 

					$bus_post_time = $val1['statuschangingtimestamp'];

					$bus_approval = $val1['approval'];

					$bus_expire_time = strtotime('+'.$notification_day.' day', $bus_post_time);

					$diffrence_time = $bus_expire_time - $current_timestamp;

					if($bus_post_time >= strtotime('-'.$notification_day.' day', $current_timestamp)){

							if($bus_expire_time >= $current_timestamp){

								if(($bus_expire_time >= $current_timestamp) && ($current_timestamp >= strtotime('-'.$bus_statuschanging_time.' day', $bus_expire_time))){

									$temp_arr['businessdata'][$key1] = $val1 ;

								}

							  }

							}

						}

					}

				}

					$data['non_temp_business_in_zone'] = $temp_arr['businessdata']; 

			}

		$count_business = $charval!='all' ? $count_freetrial_business : count($data['non_temp_business_in_zone']) ;

		$zonepref=$this->ads->getZonePpreferencesByZone($zoneid);

		$data['count_non_temp_business_in_zone']=$count_business;

		$lowerlimit_new=$lowerlimit+$upperlimit;

		$limit=$lowerlimit_new.','.$upperlimit; 

		$data['zoneid']=$zoneid; 

		$result = $this->load->view('zone/subpage/view_freetrialexpiration', $data, true);

		$this->session->unset_userdata('business_value');

		echo($this->dr->GetDR($data['count_non_temp_business_in_zone'],$limit, $result, "0"));	

	} 

	

	

	///////////////////////////////////////////

	

	

	

	

	

	/**

	 * This function is help to open the All Businesses page

	 *

	 * Input Parameters:

	 * <ol>

	 * <li> zoneid</li>

	 * <li> fromzoneid( it defines whether user is ZO or BO)</li>

	 * </ol>

	 * <br>

	 * View: <b>views/zone/all_business.php</b>

	 * 

	 */

	public function all_business($zoneid=false,$fromzoneid=0){
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'];
		$data['right_container'] = $this->load->view("zone/all_business.php", $data, true); 
		$this->common($data);	
	}

	/**

	* This function is displaying all businesses from the 'business filtered search' results. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> payment status( it defines bcs, trial or paid)</li>

	* <li> viewable status( it defines active or inactive or all)</li>

	* <li> business mode ( it defines normal business or franchisee business)</li>

	* <li> search value by name,id or alphabet( like A, B etc.)</li>

	* <li> lowerlimit, upperlimit( it defines how many businesses will show at a time)</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>get_all_business_details_in_zone</b> (Model Name: zone_model, Utility: to view all businesses)</li>

	* </ol>

	* <br>

	* view page: <b>views/zone/subpage/view_all_business</b>

	*/
 


	/**pending all**/public function get_all_business_deals_in_zone(){	

	    $typeofbusinesses = ($_REQUEST['typeofbusinesses'] != 'null') ? $_REQUEST['typeofbusinesses'] : '' ; 

	    $typeofadds = !empty($_REQUEST['typeofadds']) ? $_REQUEST['typeofadds'] : '' ;

		$paymentstatus = !empty($_REQUEST['paymentstatus']) ? $_REQUEST['paymentstatus'] : '' ;

		$activestatus = !empty($_REQUEST['activestatus']) ? $_REQUEST['activestatus'] : '' ;

	    $businessmode = !empty($_REQUEST['businessmode']) ? $_REQUEST['businessmode'] : '' ;	//var_dump($typeofbusinesses); exit;

		$all_zone_business = !empty($_REQUEST['all_zone_business']) ? $_REQUEST['all_zone_business'] : '' ;

		//print_r($_REQUEST); exit;		

		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$business_type=!empty($_REQUEST['business_type']) ? $_REQUEST['business_type'] : 0 ; 

		$business_type_by_category=!empty($_REQUEST['business_type_by_category']) ? $_REQUEST['business_type_by_category'] : '' ;

		$business_zone = 2;

		$charval_name=!empty($_REQUEST['bus_search_by_name']) ? $_REQUEST['bus_search_by_name'] : 'all';

		$bus_search_results=!empty($_REQUEST['bus_search_results']) ? $_REQUEST['bus_search_results'] : '';

		if($charval_name != ''){

			$charval_name = $this->remove_specialcharAndSpaces($charval_name) ;	// Override with removable value

		}

		$charval_alphabet=!empty($_REQUEST['bus_search_by_alphabet']) ? $_REQUEST['bus_search_by_alphabet'] : '-1';

		### check the search criteria

		if($charval_name=='all' && $charval_alphabet=='-1'){

			$charval='all';

		}else if($charval_name!='all' && $charval_alphabet=='-1'){

			$charval=$charval_name;

		}else if($charval_name=='all' && $charval_alphabet!='-1'){

			$charval=$charval_alphabet;

		}

		

		$lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0 ;

		$upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 10 ; 

		

		$data['non_temp_business_in_zone'] = $this->zone_model->get_all_business_deals_in_zone($zoneid,$charval,$lowerlimit,$upperlimit,$business_zone,$typeofbusinesses,$typeofadds,$paymentstatus,$activestatus,$businessmode,$bus_search_results,$all_zone_business);  

		 

		$zonepref=$this->ads->getZonePpreferencesByZone($zoneid);		

		$data['trial_business_active'] = $zonepref['trial_business_active'] ; 

		$data['count_non_temp_business_in_zone']=count($data['non_temp_business_in_zone']); 

		$lowerlimit_new=$lowerlimit+$upperlimit;

		$limit=$lowerlimit_new.','.$upperlimit;

		$data['lowerLimit'] = $lowerlimit_new;

		$data['zoneid']=$zoneid; 

		$data['business_type']=$business_type; 

	    $data['business_type_by_category']=$business_type_by_category;

		$data['business_zone']=$business_zone; 

		$data['charval_name']=$charval_name; 

		$data['charval_alphabet']=$charval_alphabet; 

		$data['bus_search_results']=$bus_search_results; 		

		$data['typeofbusinesses']= $typeofbusinesses; 

		$data['typeofadds']= $typeofadds; 

		$data['paymentstatus']= $paymentstatus; 

		$data['activestatus']= $activestatus; 

		$data['businessmode']= $businessmode;

		$data['all_zone_business'] = $all_zone_business;	

		$data['busid']=$data['non_temp_business_in_zone']['0']['businessid'];

		$result = $this->load->view('zone/subpage/view_all_deals', $data, true);

		$this->session->unset_userdata('business_value');

		// print_r($data);

		echo($this->dr->GetDR($data['count_non_temp_business_in_zone'],$limit, $result, "0"));	

	} 	
	
	public function all_business_by_filtering(){
		$zoneid=isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:0;
		$typeofbusinesses = isset($_REQUEST['typeofbusinesses'])?$_REQUEST['typeofbusinesses']:''; 
		$typeofadds = isset($_REQUEST['typeofadds'])?$_REQUEST['typeofadds']:'';
		$paymentstatus = isset($_REQUEST['paymentstatus'])?$_REQUEST['paymentstatus']:'';
		$activestatus = isset($_REQUEST['activestatus'])?$_REQUEST['activestatus']:'';
		$businessmode = isset($_REQUEST['businessmode'])?$_REQUEST['businessmode']:'';	 
		$bus_search_by_subcategory = isset($_REQUEST['bus_search_by_subcategory'])?$_REQUEST['bus_search_by_subcategory']:'';
		$business_type_by_category = isset($_REQUEST['bus_search_by_cat'])? $_REQUEST['bus_search_by_cat']:'';
		
		if($bus_search_by_subcategory != ''){  
            		$charval_name = isset($_REQUEST['bus_search_by_name'])? $_REQUEST['bus_search_by_name']:' ';
        	}else if($business_type_by_category != ''){ 
        		$charval_name = isset($_REQUEST['bus_search_by_name'])? $_REQUEST['bus_search_by_name']:' ';
        	}else{
        		$charval_name = isset($_REQUEST['bus_search_by_name'])? $_REQUEST['bus_search_by_name']:'all';
        	}
		$charval_alphabet = isset($_REQUEST['bus_search_by_alphabet'])? $_REQUEST['bus_search_by_alphabet']:'-1';
		$bus_search_results = isset($_REQUEST['bus_search_results']) ? $_REQUEST['bus_search_results']:'';
		$all_zone_business = isset($_REQUEST['all_zone_business'])? $_REQUEST['all_zone_business'] : '' ;
		$business_type = isset($_REQUEST['business_type'])? $_REQUEST['business_type']:0; 
		$business_zone = 2;
		if($charval_name != ''){
			$charval_name = $this->remove_specialcharAndSpaces($charval_name);
		}
		
		if($charval_name=='all' && $charval_alphabet=='-1'){
			$charval='all';
		}else if($charval_name!='all' && $charval_alphabet=='-1'){
			$charval=$charval_name;
		}else if($charval_name=='all' && $charval_alphabet!='-1'){
			$charval=$charval_alphabet;
		}
 		
 		$lowerlimit = isset($_POST['lowerlimit'])? $_POST['lowerlimit']:0;
		$upperlimit = isset($_POST['upperlimit'])? $_POST['upperlimit'] :10; 
		$data['non_temp_business_in_zone'] = $this->Zone_model->get_all_business_details_in_zone($zoneid,$charval,$lowerlimit,$upperlimit,$business_zone,$typeofbusinesses,$typeofadds,$paymentstatus,$activestatus,$businessmode,$bus_search_results,$all_zone_business,$business_type_by_category , $bus_search_by_subcategory );
		$data['totalbus'] = $this->Zone_model->get_all_business_details_in_zone($zoneid,$charval,0 ,100000000,$business_zone,$typeofbusinesses,$typeofadds,$paymentstatus,$activestatus,$businessmode,$bus_search_results,$all_zone_business,$business_type_by_category , $bus_search_by_subcategory);  

		echo "<pre>"; print_r($data);die;		
		
		
		 
		 
		$lowerlimit_new=$lowerlimit+$upperlimit;
		$limit=$lowerlimit_new.','.$upperlimit;


		$data['lowerLimit'] = $lowerlimit_new;

		
		$data['business_type']=$business_type; 

		$data['business_type_by_category']=$business_type_by_category;

		$data['business_zone']=$business_zone; 

		$data['charval_name']=$charval_name; 
		$data['charval_alphabet']=$charval_alphabet; 
		$data['bus_search_results']=$bus_search_results; 		
		$data['typeofbusinesses']= $typeofbusinesses; 
		$data['typeofadds']= $typeofadds; 
		$data['paymentstatus']= $paymentstatus; 
		$data['activestatus']= $activestatus; 
		$data['businessmode']= $businessmode;
		$data['all_zone_business'] = $all_zone_business;	
		$data['busid']=$data['non_temp_business_in_zone']['0']['businessid'];

		if($all_zone_business == 1){
        		$result = $this->load->view('zone/subpage/view_all_business', $data, true);
        	}else{
			$result = $this->load->view('zone/subpage/view_all_myzonebusiness', $data, true);
        	}
		$this->session->unset_userdata('business_value');
		echo($this->dr->GetDR($data['count_non_temp_business_in_zone'],$limit, $result, "0"));	
	} 	

	/**pending all**/public function get_business_credits($zone_id){
		$zoneid = $_SESSION['session_zoneid']['userzoneid'];
		/*get business id via zoneid*/
		$this->db->select('businessid');
        $this->db->from('ads_setting_preferences');
        $this->db->where(['settingszoneid' => $zoneid]);
        $query = $this->db->get(); 
        $result = $query->result_array();
        $arr = array_map (function($value){
    		return $value['businessid'];
			} , $result);
		/*get business id via zoneid*/
		$start = isset($_REQUEST['start'])?$_REQUEST['start']:0;
		$limit = isset($_REQUEST['limit'])?$_REQUEST['limit']:10;
		$this->db->select('address.*,business.*');
        $this->db->from('business');
        $this->db->join('address', 'business.addressid = address.id', 'left');
        $this->db->where_in('business.id', $arr);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        $result = $query->result_array(); 
        echo json_encode($result);
        die;
	}

	/**pending all**/public function set_business_credits(){
		$resid = $_REQUEST['resid'];
		$credit_qty = $_REQUEST['credit_qty'];

		$data = array('credits' => $credit_qty);
		$this->db->where('id', $resid);
		$this->db->update('business', $data);
		if($this->db->affected_rows()){
			$this->db->select('credits');
        	$this->db->from('business');
        	$this->db->where(['id' => $resid]);
        	$query = $this->db->get()->row();
        	echo json_encode(array('type'=>'warninig','msg' => 'Credits transfer Successfully','data' =>$query->credits));
		}else{
			echo json_encode(array('type'=>'warninig','msg' => 'Something Went Wrong','data' =>''));
		}
	}

	public function allpeekabooId($userID){
	  $auction_sql_setting =  'select tbl_member.user_id from business inner join users on users.id = business.business_owner_id inner join tbl_member on tbl_member.user_name = users.username where business.id = '.$userID;
           $auction_result_setting = $this->CommonController->SelectRawquery($auction_sql_setting,'resultArray');
	   return isset($auction_result_setting[0]['user_id'])?$auction_result_setting[0]['user_id']:'';
   	}
	
	public function allpeekabootype($userID){
            $auction_sql_setting =  'select tbl_member.member_type from business inner join users on users.id = business.business_owner_id inner join tbl_member on tbl_member.user_name = users.username where business.id = '.$userID;
            $auction_result_setting = $this->CommonController->SelectRawquery($auction_sql_setting,'resultArray');
    	    return isset($auction_result_setting[0]['member_type'])?$auction_result_setting[0]['member_type']:'';
        }
	
	public function alldeals($zoneid=false,$fromzoneid=0,$datasubusername = '',$datasubuserzipcodesassign = ''){
  	$count= 0;
  	$auction_data = [];
  	if($datasubusername != '' && $datasubuserzipcodesassign != ''){
   	  	$listbusiness1 = 'select a.businessid , b.* , a.* from ads_setting_preferences a INNER JOIN business b ON a.businessid=b.id INNER JOIN address c ON b.addressid=c.id LEFT JOIN ads f ON b.id=f.business_id LEFT JOIN ad_to_zone g ON f.id=g.adid LEFT JOIN ad_category_subcategory h ON f.id=h.adid where a.settingszoneid='.$zoneid.' and a.type IN(1,2) and c.zip_code IN('.$datasubuserzipcodesassign.') and a.isdefault IN(0,1) and a.approval IN(1,2,3,-1,-2,-3) GROUP BY a.businessid ORDER BY trim(b.name) asc';
   	  }else{
   	  	$listbusiness1 = 'select a.businessid , b.* , a.* from ads_setting_preferences a INNER JOIN business b ON a.businessid=b.id INNER JOIN address c ON b.addressid=c.id LEFT JOIN ads f ON b.id=f.business_id LEFT JOIN ad_to_zone g ON f.id=g.adid LEFT JOIN ad_category_subcategory h ON f.id=h.adid where a.settingszoneid='.$zoneid.' and a.type IN(1,2) and a.isdefault IN(0,1) and a.approval IN(1,2,3,-1,-2,-3) GROUP BY a.businessid ORDER BY trim(b.name) asc';
   	  }
	  
	  $listbusinessdata = $this->CommonController->SelectRawquery($listbusiness1,'resultArray');

	  foreach ($listbusinessdata as $k => $listbusiness) {
   		$peekaboo_id = $this->allpeekabooId($listbusiness['businessid']); 
			if($peekaboo_id){
		    $peekaboo_type = $this->allpeekabootype($listbusiness['businessid']); 
				
				if($peekaboo_type){
					$auction_sql_setting = 'SELECT  ip.* , a.*,  c.name as cat_name,ip.company_name ,ip.deal_product_id,ip.product_name,   a.deal_id ,a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update FROM tbl_deals a LEFT JOIN tbl_deals_products ip ON ip.deal_product_id=a.product_id LEFT JOIN category_new c ON c.id=ip.cat_id WHERE a.user_id='.$peekaboo_id.' AND a.member_type='.$peekaboo_type.'  order by a.start_date ASC';     
				}else{
					$auction_sql_setting = 'SELECT  ip.* , a.*,  c.name as cat_name,ip.company_name ,ip.deal_product_id,ip.product_name,   a.deal_id ,a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update FROM tbl_deals a LEFT JOIN tbl_deals_products ip ON ip.deal_product_id=a.product_id LEFT JOIN category_new c ON c.id=ip.cat_id WHERE a.user_id='.$peekaboo_id.' order by a.start_date ASC';
				}
		   
			$auction_result_setting = $this->CommonController->SelectRawquery($auction_sql_setting,'resultArray');
		    if(count($auction_result_setting) > 0){
		     	foreach($auction_result_setting as $auction_datas){
          	$auction_data['auctions'][$count]['company_name']  = $auction_datas['company_name'];
			    	$auction_data['auctions'][$count]['businessname'] = $listbusiness['name'];
			    	$auction_data['auctions'][$count]['businessid'] = $listbusiness['businessid'];
			    	$auction_data['auctions'][$count]['product_id'] = $auction_datas['product_id'];
			    	$auction_data['auctions'][$count]['product_name'] = $auction_datas['product_name'];
			    	$auction_data['auctions'][$count]['cat_name'] = $auction_datas['cat_name'];
			    	$auction_data['auctions'][$count]['status'] = $auction_datas['status'];
			    	$count++;    	    	
			    } 
			  } 	   
			}
		}
    return $auction_data;
  }

function allauctions($zoneid=false,$fromzoneid=0){   

    $user = $this->ion_auth->user()->row();   


      $auction_data = '';
         $listbusiness = 'select a.businessid , b.* , a.* from ads_setting_preferences a INNER JOIN business b ON a.businessid=b.id INNER JOIN address c ON b.addressid=c.id INNER JOIN users d ON b.business_owner_id=d.id INNER JOIN users_groups e ON d.id=e.user_id LEFT JOIN ads f ON b.id=f.business_id LEFT JOIN ad_to_zone g ON f.id=g.adid LEFT JOIN ad_category_subcategory h ON f.id=h.adid where a.settingszoneid='.$zoneid.' and a.type IN(1,2) and a.isdefault IN(0,1) and a.approval IN(1,2,3,-1,-2,-3) GROUP BY a.businessid ORDER BY trim(b.name) asc ';
        $listbusiness= $this->db->query($listbusiness);	
		$listbusiness =   $listbusiness->result_array();

  
  $count= 0;
         foreach($listbusiness as $listbusiness){

 

        $peekaboo_id = $this->allpeekabooId($listbusiness['businessid']); 

        if(@$peekaboo_id){
		$peekaboo_type = $this->allpeekabootype($listbusiness['businessid']); 
 

        $auction_sql_setting = 'SELECT  a.*,  ip.* , c.name as cat_name,ip.company_name ,ip.product_id,ip.product_name,   a.auc_id,a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update FROM tbl_auction a LEFT JOIN tbl_inventory_products ip ON ip.product_id=a.product_id LEFT JOIN category_new c ON c.id=ip.cat_id WHERE a.user_id='.$peekaboo_id.' AND a.member_type='.$peekaboo_type.'  and  a.auction_type="RTP" AND a.status <> "Deleted"  order by a.start_date ASC';     


    	    $auction_result_setting= $this->db->query($auction_sql_setting);    	   
    	    if(count($auction_result_setting->result_array()) != 0){
    	    	  
    	    	  
    	    	foreach($auction_result_setting->result_array() as $auction_datas){
                     
                     
			            $auction_data['auctions'][$count]['company_name']  = $auction_datas['company_name'];
			            $auction_data['auctions'][$count]['businessname'] = $listbusiness['name'];
			            $auction_data['auctions'][$count]['businessid'] = $listbusiness['businessid'];
			            $auction_data['auctions'][$count]['product_id'] = $auction_datas['product_id'];
			            $auction_data['auctions'][$count]['product_name'] = $auction_datas['product_name'];
			            $auction_data['auctions'][$count]['cat_name'] = $auction_datas['cat_name'];
			            $auction_data['auctions'][$count]['status'] = $auction_datas['status'];
  
 
                        $count++;    	    	
                    } 

    	    }
           }


         }
 
 
 
		$data['common']=$this->common_first($zoneid,$fromzoneid);		

		$data['zoneid']=$data['common']['zoneid']; 

		$data['auctiondata']= $auction_data; 

 
   
        $data['right_container'] = $this->load->view("zone/allauctions.php", $data, true);
        	
        $this->common($data);	
    }


     function peekaboo_createauction($zoneid=false,$fromzoneid=0){   

       
       
    $user = $this->ion_auth->user()->row();   


      $auction_data = '';
         $listbusiness = 'select a.businessid , b.* , a.* from ads_setting_preferences a INNER JOIN business b ON a.businessid=b.id INNER JOIN address c ON b.addressid=c.id INNER JOIN users d ON b.business_owner_id=d.id INNER JOIN users_groups e ON d.id=e.user_id LEFT JOIN ads f ON b.id=f.business_id LEFT JOIN ad_to_zone g ON f.id=g.adid LEFT JOIN ad_category_subcategory h ON f.id=h.adid where a.settingszoneid='.$zoneid.' and a.type IN(1,2) and a.isdefault IN(0,1) and a.approval IN(1,2,3,-1,-2,-3) GROUP BY a.businessid ORDER BY trim(b.name) asc ';

        $listbusiness= $this->db->query($listbusiness);	

		$listbusiness =   $listbusiness->result_array();  
 
 
		$data['common']=$this->common_first($zoneid,$fromzoneid);		

 
		$data['zoneid']=$data['common']['zoneid'];

		$data['auctiondata']= $listbusiness; 

 

  
        $data['businessid']=$businessid;

     
     
        $data['right_container'] = $this->load->view("zone/peekaboo_auction_create", $data, true);

        $this->common($data);       

 
	
    }
    
    public function create_deal($zoneid=false,$fromzoneid=0,$busid = ''){   
    	if($busid != ''){
    		$listbusiness = 'select a.businessid ,b.id,b.name,b.contactfirstname,b.contactlastname,b.contactemail,c.phone,c.zip_code,f.id as adsid from ads_setting_preferences a INNER JOIN business b ON a.businessid=b.id INNER JOIN address c ON b.addressid=c.id LEFT JOIN ads f ON b.id=f.business_id LEFT JOIN ad_to_zone g ON f.id=g.adid LEFT JOIN ad_category_subcategory h ON f.id=h.adid where a.settingszoneid='.$zoneid.' and b.id='.$busid.' and a.type IN(1,2) and a.isdefault IN(0,1) and a.approval IN(1,2,3,-1,-2,-3) GROUP BY a.businessid ORDER BY trim(b.name) asc';
    	}else{
  			$listbusiness = 'select a.businessid ,b.id,b.name,b.contactfirstname,b.contactlastname,b.contactemail,c.phone,c.zip_code,f.id as adsid from ads_setting_preferences a INNER JOIN business b ON a.businessid=b.id INNER JOIN address c ON b.addressid=c.id LEFT JOIN ads f ON b.id=f.business_id LEFT JOIN ad_to_zone g ON f.id=g.adid LEFT JOIN ad_category_subcategory h ON f.id=h.adid where a.settingszoneid='.$zoneid.' and a.type IN(1,2) and a.isdefault IN(0,1) and a.approval IN(1,2,3,-1,-2,-3) GROUP BY a.businessid ORDER BY trim(b.name) asc';  	
    	}
			return $this->CommonController->SelectRawquery($listbusiness,'resultArray');
    }



	// snapding reservations

	/**pending all**/public function all_snapdingreservations(){	


	 

	    $typeofbusinesses = ($_REQUEST['typeofbusinesses'] != 'null') ? $_REQUEST['typeofbusinesses'] : '' ; 

	    $typeofadds = !empty($_REQUEST['typeofadds']) ? $_REQUEST['typeofadds'] : '' ;

		$paymentstatus = !empty($_REQUEST['paymentstatus']) ? $_REQUEST['paymentstatus'] : '' ;

		$activestatus = !empty($_REQUEST['activestatus']) ? $_REQUEST['activestatus'] : '' ;

	    $businessmode = !empty($_REQUEST['businessmode']) ? $_REQUEST['businessmode'] : '' ;	 

		$all_zone_business = !empty($_REQUEST['all_zone_business']) ? $_REQUEST['all_zone_business'] : '' ; 

		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$business_type=!empty($_REQUEST['business_type']) ? $_REQUEST['business_type'] : 0 ; 

		$userID=!empty($_REQUEST['userID']) ? $_REQUEST['userID'] : 0 ; 

		$business_type_by_category=!empty($_REQUEST['business_type_by_category']) ? $_REQUEST['business_type_by_category'] : '' ;

		$business_zone = 2;

		$charval_name=!empty($_REQUEST['bus_search_by_name']) ? $_REQUEST['bus_search_by_name'] : 'all';

		$bus_search_results=!empty($_REQUEST['bus_search_results']) ? $_REQUEST['bus_search_results'] : '';

		if($charval_name != ''){

			$charval_name = $this->remove_specialcharAndSpaces($charval_name); 

		}

		$charval_alphabet=!empty($_REQUEST['bus_search_by_alphabet']) ? $_REQUEST['bus_search_by_alphabet'] : '-1';

		### check the search criteria

		if($charval_name=='all' && $charval_alphabet=='-1'){

			$charval='all';

		}else if($charval_name!='all' && $charval_alphabet=='-1'){

			$charval=$charval_name;

		}else if($charval_name=='all' && $charval_alphabet!='-1'){

			$charval=$charval_alphabet;

		}

		

		$lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0 ;

		$upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 10 ; 

		

		$data['non_temp_business_in_zone'] = $this->zone_model->get_all_business_snapdining_details($zoneid,$charval,$lowerlimit,$upperlimit,$business_zone,$typeofbusinesses,$typeofadds,$paymentstatus,$activestatus,$businessmode,$bus_search_results,$all_zone_business,$userID );   

 
		$zonepref=$this->ads->getZonePpreferencesByZone($zoneid);

		$data['trial_business_active'] = $zonepref['trial_business_active'] ; 

		$data['count_non_temp_business_in_zone']=count($data['non_temp_business_in_zone']); 

		$lowerlimit_new=$lowerlimit+$upperlimit;

		$limit=$lowerlimit_new.','.$upperlimit;

		$data['lowerLimit'] = $lowerlimit_new;

		$data['zoneid']=$zoneid; 

		$data['business_type']=$business_type; 

	    $data['business_type_by_category']=$business_type_by_category;

		$data['business_zone']=$business_zone; 

		$data['charval_name']=$charval_name; 

		$data['charval_alphabet']=$charval_alphabet; 

		$data['bus_search_results']=$bus_search_results; 

		

		$data['typeofbusinesses']= $typeofbusinesses; 

		$data['typeofadds']= $typeofadds; 

		$data['paymentstatus']= $paymentstatus; 

		$data['activestatus']= $activestatus; 

		$data['businessmode']= $businessmode;

		$data['all_zone_business'] = $all_zone_business;	

		$data['busid']=$data['non_temp_business_in_zone']['0']['businessid'];

		$result = $this->load->view('zone/subpage/view_all_business', $data, true);

		$this->session->unset_userdata('business_value');

		echo($this->dr->GetDR($data['count_non_temp_business_in_zone'],$limit, $result, "0"));	

	} 	





	/**pending all**/public function all_ads_by_filtering(){	

	    $typeofbusinesses = ($_REQUEST['typeofbusinesses'] != 'null') ? $_REQUEST['typeofbusinesses'] : '' ; 

	    $typeofadds = !empty($_REQUEST['typeofadds']) ? $_REQUEST['typeofadds'] : '' ;

		$paymentstatus = !empty($_REQUEST['paymentstatus']) ? $_REQUEST['paymentstatus'] : '' ;

		$activestatus = !empty($_REQUEST['activestatus']) ? $_REQUEST['activestatus'] : '' ;

	    $businessmode = !empty($_REQUEST['businessmode']) ? $_REQUEST['businessmode'] : '' ;	//var_dump($typeofbusinesses); exit;

		$all_zone_business = !empty($_REQUEST['all_zone_business']) ? $_REQUEST['all_zone_business'] : '' ;

		//print_r($_REQUEST); exit;		

		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$business_type=!empty($_REQUEST['business_type']) ? $_REQUEST['business_type'] : 0 ; 

		$business_type_by_category=!empty($_REQUEST['business_type_by_category']) ? $_REQUEST['business_type_by_category'] : '' ;

		$business_zone = 2;

		$charval_name=!empty($_REQUEST['bus_search_by_name']) ? $_REQUEST['bus_search_by_name'] : 'all';

		$bus_search_results=!empty($_REQUEST['bus_search_results']) ? $_REQUEST['bus_search_results'] : '';

		if($charval_name != ''){

			$charval_name = $this->remove_specialcharAndSpaces($charval_name) ;	// Override with removable value

		}

		$charval_alphabet=!empty($_REQUEST['bus_search_by_alphabet']) ? $_REQUEST['bus_search_by_alphabet'] : '-1';

		### check the search criteria

		if($charval_name=='all' && $charval_alphabet=='-1'){

			$charval='all';

		}else if($charval_name!='all' && $charval_alphabet=='-1'){

			$charval=$charval_name;

		}else if($charval_name=='all' && $charval_alphabet!='-1'){

			$charval=$charval_alphabet;

		}

		

		$lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0 ;

		$upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 500 ; 

		

		$data['non_temp_business_in_zone'] = $this->zone_model->get_all_business_details_in_zone($zoneid,$charval,$lowerlimit,$upperlimit,$business_zone,$typeofbusinesses,$typeofadds,$paymentstatus,$activestatus,$businessmode,$bus_search_results,$all_zone_business);  //var_dump($data['non_temp_business_in_zone']);exit;

		$zonepref=$this->ads->getZonePpreferencesByZone($zoneid);

		$data['trial_business_active'] = $zonepref['trial_business_active'] ; 

		$data['count_non_temp_business_in_zone']=count($data['non_temp_business_in_zone']); 

		$lowerlimit_new=$lowerlimit+$upperlimit;

		$limit=$lowerlimit_new.','.$upperlimit;

		$data['lowerLimit'] = $lowerlimit_new;

		$data['zoneid']=$zoneid; 

		$data['business_type']=$business_type; 

	    $data['business_type_by_category']=$business_type_by_category;

		$data['business_zone']=$business_zone; 

		$data['charval_name']=$charval_name; 

		$data['charval_alphabet']=$charval_alphabet; 

		$data['bus_search_results']=$bus_search_results; 		

		$data['typeofbusinesses']= $typeofbusinesses; 

		$data['typeofadds']= $typeofadds; 

		$data['paymentstatus']= $paymentstatus; 

		$data['activestatus']= $activestatus; 

		$data['businessmode']= $businessmode;

		$data['all_zone_business'] = $all_zone_business;	

		$data['busid']=$data['non_temp_business_in_zone']['0']['businessid'];

		$result = $this->load->view('zone/subpage/view_all_status_business', $data, true);

		$this->session->unset_userdata('business_value');

		echo($this->dr->GetDR($data['count_non_temp_business_in_zone'],$limit, $result, "0"));	

	} 	


		// status to active/inactive

/**pending all**/public function business_by_status(){	

        $typeofbusinesses = ($_REQUEST['typeofbusinesses'] != 'null') ? $_REQUEST['typeofbusinesses'] : '' ; 

	    $typeofadds = !empty($_REQUEST['typeofadds']) ? $_REQUEST['typeofadds'] : '' ;

		$paymentstatus = !empty($_REQUEST['paymentstatus']) ? $_REQUEST['paymentstatus'] : '' ;

		$activestatus = !empty($_REQUEST['activestatus']) ? $_REQUEST['activestatus'] : '' ;

	    $businessmode = !empty($_REQUEST['businessmode']) ? $_REQUEST['businessmode'] : '' ;	 

		$all_zone_business = !empty($_REQUEST['all_zone_business']) ? $_REQUEST['all_zone_business'] : '' ;

	 

		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$business_type=!empty($_REQUEST['business_type']) ? $_REQUEST['business_type'] : 0 ; 

		$business_type_by_category=!empty($_REQUEST['business_type_by_category']) ? $_REQUEST['business_type_by_category'] : '' ;

		$business_zone = 2;

		$charval_name=!empty($_REQUEST['bus_search_by_name']) ? $_REQUEST['bus_search_by_name'] : 'all';

		$bus_search_results=!empty($_REQUEST['bus_search_results']) ? $_REQUEST['bus_search_results'] : '';

		if($charval_name != ''){

			$charval_name = $this->remove_specialcharAndSpaces($charval_name) ;	 

		}

		$charval_alphabet=!empty($_REQUEST['bus_search_by_alphabet']) ? $_REQUEST['bus_search_by_alphabet'] : '-1';

		### check the search criteria

		if($charval_name=='all' && $charval_alphabet=='-1'){

			$charval='all';

		}else if($charval_name!='all' && $charval_alphabet=='-1'){

			$charval=$charval_name;

		}else if($charval_name=='all' && $charval_alphabet!='-1'){

			$charval=$charval_alphabet;

		}

		

		$lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0 ;

		$upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 500 ; 

		

		$data['non_temp_business_in_zone'] = $this->zone_model->get_all_business_details_in_zone($zoneid,$charval,$lowerlimit,$upperlimit,$business_zone,$typeofbusinesses,$typeofadds,$paymentstatus,$activestatus,$businessmode,$bus_search_results,$all_zone_business);  //var_dump($data['non_temp_business_in_zone']);exit;

		$zonepref=$this->ads->getZonePpreferencesByZone($zoneid);

		$data['trial_business_active'] = $zonepref['trial_business_active'] ; 

		$data['count_non_temp_business_in_zone']=count($data['non_temp_business_in_zone']); 

		$lowerlimit_new=$lowerlimit+$upperlimit;

		$limit=$lowerlimit_new.','.$upperlimit;

		$data['lowerLimit'] = $lowerlimit_new;

		$data['zoneid']=$zoneid; 

		$data['business_type']=$business_type; 

	    $data['business_type_by_category']=$business_type_by_category;

		$data['business_zone']=$business_zone; 

		$data['charval_name']=$charval_name; 

		$data['charval_alphabet']=$charval_alphabet; 

		$data['bus_search_results']=$bus_search_results; 

		

		$data['typeofbusinesses']= $typeofbusinesses; 

		$data['typeofadds']= $typeofadds; 

		$data['paymentstatus']= $paymentstatus; 

		$data['activestatus']= $activestatus; 

		$data['businessmode']= $businessmode;

		$data['all_zone_business'] = $all_zone_business;	

		$data['busid']=$data['non_temp_business_in_zone']['0']['businessid'];

		$result = $this->load->view('zone/subpage/view_all_status_business', $data, true);

		$this->session->unset_userdata('business_value');

		echo($this->dr->GetDR($data['count_non_temp_business_in_zone'],$limit, $result, "0"));	

	} 


	/**

	* This function is used for business's status change and can update/delete business(s) from the 'business filtered search' results. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> business id</li>

	* <li> action_performed( it defines whether to change status or delete)</li>

	* <li> payment status ( it defines Paid, Trial or Uploaded)</li>

	* <li> business mode</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the two functions in two related models.

	* <br>

	* <ol>

	* <li><b>change_business_status_in_zone</b> (Model Name: zone_model, Utility: Change the status of a business)</li> 

	* <li><b>business_delete</b> (Model Name: zone_model_delete,  Utility: Delete Business and business associated data like ads, business images, user favorite ads)</li>

	* </ol>

	*/

	function action_performed_all_business(){ 

		$charval='all';

		$data = array();

		$data['zoneid'] = !empty($_REQUEST['zoneid'])? $_REQUEST['zoneid']:0;

		$data['business_id']=!empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : 0;

		$data['allzoneid'] = $data['zoneid'];

		$data['action_performed']=$_REQUEST['action_performed'];

		$data['change_business_status']=$_REQUEST['change_business_status'];

		$data['action_performed_in_where']=$_REQUEST['action_performed_in_where']; 

		$data['listed_business_delete_all_or_specific']=$_REQUEST['business_delete_all_or_specific'];

		$data['show_bus_type_listed']=3;

		$data['business_type'] = $_REQUEST['business_type'];

		$data['business_type_by_category']=$_REQUEST['business_type_by_category'];

		$data['business_zone']=$_REQUEST['business_zone']; 

		$data['businessmode']=!empty($_REQUEST['businessmode'])? $_REQUEST['businessmode'] : 0;

		$data['typeofadds']=!empty($_REQUEST['typeofadds'])? $_REQUEST['typeofadds'] : 0;

		$data['paymentstatus']=!empty($_REQUEST['paymentstatus'])? $_REQUEST['paymentstatus'] : 0;

		$data['activestatus']=!empty($_REQUEST['activestatus'])? $_REQUEST['activestatus'] : 0;

		$data['typeofbusinesses']=!empty($_REQUEST['typeofbusinesses'])? $_REQUEST['typeofbusinesses'] : 0; 

		$data['status_popup_value'] = !empty($_REQUEST['status_popup_value'])? $_REQUEST['status_popup_value'] : '';
 
		if($_REQUEST['action_performed']==6){

			$this->zone_model->change_business_status_in_zone($data['business_id'],$data['zoneid'],$data['change_business_status'],$data['status_popup_value']);

		$result='';

		}

		// For Delete Selected Businesses from Current Zone

		else if($_REQUEST['action_performed']==3 && $data['action_performed_in_where']==0 && $data['listed_business_delete_all_or_specific']==1){

			$data['my_business_in_zone1'] = $this->zone_model_delete->business_delete($data['business_id'],$data['zoneid'],$data['action_performed_in_where'],$data['business_type'],$data['business_type_by_category'],$data['business_zone'],$data['businessmode'],$data['typeofadds'],$data['paymentstatus'],$data['activestatus'],$data['typeofbusinesses']);

						

			$result='';

		}

		// For Delete Selected Businesses from All Zone	

		else if($_REQUEST['action_performed']==3 && $data['action_performed_in_where']==1 && $data['listed_business_delete_all_or_specific']==1){

			 //var_dump(2); exit; 

			$data['my_business_in_zone1'] = $this->zone_model_delete->business_delete($data['business_id'],$data['zoneid'],$data['action_performed_in_where'],$data['business_type'],$data['business_type_by_category'],$data['business_zone'],$data['businessmode'],$data['typeofadds'],$data['paymentstatus'],$data['activestatus'],$data['typeofbusinesses']); //var_dump($data['my_business_in_zone1']); exit;

			$result='';

		}

		// For Delete All Businesses from Current Zone	

		else if($_REQUEST['action_performed']==3 && $data['action_performed_in_where']==0 && $data['listed_business_delete_all_or_specific']==2){

			//var_dump(3); exit; 				 	

			$data['my_business_in_zone1'] = $this->zone_model_delete->business_delete('',$data['zoneid'],$data['action_performed_in_where'],$data['business_type'],$data['business_type_by_category'],$data['business_zone'],$data['businessmode'],$data['typeofadds'],$data['paymentstatus'],$data['activestatus'],$data['typeofbusinesses']); //var_dump($data['my_business_in_zone1']); exit;

			$result='';

		}

		// For Delete All Businesses from All Zone

		else if($_REQUEST['action_performed']==3 && $data['action_performed_in_where']==1 && $data['listed_business_delete_all_or_specific']==2){

			//var_dump(4); exit; 				 

			$data['my_business_in_zone1'] = $this->zone_model_delete->business_delete($data['business_id'],$data['zoneid'],$data['action_performed_in_where'],$data['business_type'],$data['business_type_by_category'],$data['business_zone'],$data['businessmode'],$data['typeofadds'],$data['paymentstatus'],$data['activestatus'],$data['typeofbusinesses']);

			$result='';

		}

		//$update_zone_menu=$this->category_model->update_zone_menu($data['zoneid']);

		$update_zone_menu=$this->menu_generator($data['zoneid']); //echo 1 ; exit;

		

		///////////////  Receive response for all business deleting  ////////////////

		$delete_response = isset($data['my_business_in_zone1']) ? $data['my_business_in_zone1'] : '' ;

		///////////////  Receive response for all business deleting  ////////////////

		echo($this->dr->GetDR($data['listed_business_delete_all_or_specific'], $delete_response, $result, 0));

	}




	function action_performed_all_ads(){ 

		$charval='all';

		$data = array();

		$data['zoneid'] = !empty($_REQUEST['zoneid'])? $_REQUEST['zoneid']:0;

		$data['business_id']=!empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : 0;

		$data['allzoneid'] = $data['zoneid'];

		$data['action_performed']=$_REQUEST['action_performed'];

		$data['change_business_status']=$_REQUEST['change_business_status'];

		$data['action_performed_in_where']=$_REQUEST['action_performed_in_where']; 

		$data['listed_business_delete_all_or_specific']=$_REQUEST['business_delete_all_or_specific'];

		$data['show_bus_type_listed']=3;

		$data['business_type'] = $_REQUEST['business_type'];

		$data['business_type_by_category']=$_REQUEST['business_type_by_category'];

		$data['business_zone']=$_REQUEST['business_zone']; 

		$data['businessmode']=!empty($_REQUEST['businessmode'])? $_REQUEST['businessmode'] : 0;

		$data['typeofadds']=!empty($_REQUEST['typeofadds'])? $_REQUEST['typeofadds'] : 0;

		$data['paymentstatus']=!empty($_REQUEST['paymentstatus'])? $_REQUEST['paymentstatus'] : 0;

		$data['activestatus']=!empty($_REQUEST['activestatus'])? $_REQUEST['activestatus'] : 0;

		$data['typeofbusinesses']=!empty($_REQUEST['typeofbusinesses'])? $_REQUEST['typeofbusinesses'] : 0; 

		$data['status_popup_value'] = !empty($_REQUEST['status_popup_value'])? $_REQUEST['status_popup_value'] : '';

		// Change Business Status		
 
		if($_REQUEST['action_performed']==6){

			$this->zone_model->change_ads_status_in_zone($data['business_id'],$data['zoneid'],$data['change_business_status'],$data['status_popup_value']);

		$result='';

		}

 

		$update_zone_menu=$this->menu_generator($data['zoneid']); //echo 1 ; exit;

  
		///////////////  Receive response for all business deleting  ////////////////

		echo($this->dr->GetDR($data['listed_business_delete_all_or_specific'], $delete_response, $result, 0));

	}
	/**

	* This function is showing edit business page. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> business id</li>

	* <li> business type(trial, paid, uploaded)</li>

	* <li> business_type_by_category ( it defines Active, inactive)</li>

	* <li> business_zone ( it defines the business is manually created or csv uploaded)</li>

	* <li> state list</li>

	* </ol>

	* <br>

	* view page: <b>views/zone/subpage/edit_non_temp_business</b>

	*/

	function edit_non_temp_business(){ 

		$data=array();

		$data['business_id']= !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : 0;

		$data['zoneid'] = !empty($_REQUEST['zoneid'])? $_REQUEST['zoneid']:0;

		$data['business_type']= !empty($_REQUEST['businesstype']) ? $_REQUEST['businesstype'] : 0;

		$data['business_type_by_category'] = !empty($_REQUEST['businesstypebycategory'])? $_REQUEST['businesstypebycategory']:0;

		$data['business_zone'] = !empty($_REQUEST['businesszone'])? $_REQUEST['businesszone']:0;

		$data['state_list']=$this->states->get_state_dropdown();

		

		

		

		$result = $this->load->view('zone/subpage/edit_non_temp_business', $data, true);

		echo($this->dr->GetDR('','', $result, "0"));

	}

	

	/**

	* This function is showing the details of a business 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> business id</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in the related models.

	* <br>

	* <ol>

	* <li><b>business_details_by_id</b> (Model Name: zone_model, Utility: details of a business)</li> 

	* </ol>

	*/

	function view_edit_non_temp_business(){ //var_dump($_REQUEST);exit;

		$data=array();

		$data['business_id']= !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : 0;

		$data['zoneid'] = !empty($_REQUEST['zoneid'])? $_REQUEST['zoneid']:0;

		$data['ckeditor_businessad'] = array(

		//ID of the textarea that will be replaced  

			'id' 	=> 	'ad_text_fromshowad',

			'path'	=>	'assets/ckeditor',

			//Optional values

			'config' => array(

				'toolbar' 	=> 	"Full", 	//Using the Full toolbar

				'width' 	=> 	"100%",	//Setting a custom width

				'height' 	=> 	'350px',	//Setting a custom height

	    ));	

		$result=$this->zone_model->business_details_by_id($data['business_id'],$data['zoneid']); //var_dump($result); exit;

		

		echo($this->dr->GetDR('','', $result, "0"));

	}

	/**

	* This function is update the business. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> All other parameters from the view page</li>

	* </ol>

	* <br>

	* <b>Update business and address table.</b>

	*/

	function update_edit_non_temp_business(){ 

		$auser = $this->ion_auth->user()->row();		

	    $uid = $auser->id;

		$business_id = !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : 0 ;

		$zone_id=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;

		$business_address_id = !empty($_REQUEST['biz_address_id']) ? $_REQUEST['biz_address_id'] : 0 ;

		$business_user_id=!empty($_REQUEST['biz_user_id']) ? $_REQUEST['biz_user_id'] : 0; 

		$business_addsetting_id=!empty($_REQUEST['biz_addsetting_id']) ? $_REQUEST['biz_addsetting_id'] : 0;

		$business_type=!empty($_REQUEST['businesstype']) ? $_REQUEST['businesstype'] : 0;

		$business_type_by_category=!empty($_REQUEST['businesstypebycategory']) ? $_REQUEST['businesstypebycategory'] : 0;

		$business_zone=!empty($_REQUEST['businesszone']) ? $_REQUEST['businesszone'] : 0;

		

		

		$biz_name = !empty($_REQUEST['biz_name'])? stripslashes($_REQUEST['biz_name']) : '';

		$biz_motto = !empty($_REQUEST['biz_motto']) ? $_REQUEST['biz_motto'] : '' ;

		$biz_about = !empty($_REQUEST['biz_about']) ? $_REQUEST['biz_about'] : '' ;

		$biz_email = !empty($_REQUEST['biz_email']) ? $_REQUEST['biz_email'] : '';

		$biz_first_name = !empty($_REQUEST['biz_first_name']) ? stripslashes($_REQUEST['biz_first_name']): '' ;

        $biz_last_name = !empty($_REQUEST['biz_last_name']) ? stripslashes($_REQUEST['biz_last_name']) : '' ;

		$biz_address_1 = !empty($_REQUEST['biz_address_1']) ? stripslashes($_REQUEST['biz_address_1']) : '' ;

        $biz_address_2 =  !empty($_REQUEST['biz_street_2']) ? stripslashes($_REQUEST['biz_street_2']) : '' ;

		$biz_city = !empty($_REQUEST['biz_city']) ? stripslashes($_REQUEST['biz_city']) : '' ;

		$biz_state = !empty($_REQUEST['biz_state']) ? $_REQUEST['biz_state'] : '' ;

		$biz_zip_code = !empty($_REQUEST['biz_zip_code']) ? $_REQUEST['biz_zip_code'] : '' ;

		$biz_phone = !empty($_REQUEST['biz_phone']) ? $_REQUEST['biz_phone'] : '' ;

		$biz_website = !empty($_REQUEST['biz_website']) ? $_REQUEST['biz_website'] : '';

		$biz_sic = !empty($_REQUEST['biz_sic']) ? $_REQUEST['biz_sic'] : '';

		$biz_username = !empty($_REQUEST['biz_username']) ? $_REQUEST['biz_username'] : '' ;

		$biz_restaurant_type = !empty($_REQUEST['biz_restaurant_type']) ? $_REQUEST['biz_restaurant_type'] : '' ;

		$biz_contact_full_name = $biz_first_name." ".$biz_last_name;

		// - For converting address into lattitude and longitude

		$address_maps = '';

        if ($biz_address_1 != '') {

            $address_maps .= $biz_address_1;

        }

        if ($biz_address_2 != '') {

            if ($address_maps != '') {

                $address_maps .= ',' . $biz_address_2;

            } else {

                $address_maps .= $biz_address_2;

            }



        }

        if ($biz_city != '') {

            if ($address_maps != '') {

                $address_maps .= ',' . $biz_city;

            } else {

                $address_maps .= $biz_city;

            }



        }

        if ($biz_state != '') {

            if ($address_maps != '') {

                $address_maps .= ',' . $biz_state;

            } else {

                $address_maps .= $biz_state;

            }



        }

        /*if ($zipcode != '') {

            if ($address_maps != '') {

                $address_maps .= ',' . $zipcode;

            } else {

                $address_maps .= $zipcode;

            }

        }*/

		$address_maps = urlencode($address_maps);

        $url = "http://maps.google.com/maps/api/geocode/json?address=$address_maps&sensor=false";

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

		

	// - For converting address into lattitude and longitude

		

		

		$businessData = array('name' => $biz_name,'motto' => $biz_motto ,'aboutus' => $biz_about ,'contactemail' => $biz_email,'contactfirstname' => $biz_first_name,'contactlastname' => $biz_last_name,'contactfullname' => $biz_contact_full_name,'siccode' =>$biz_sic,'website'=> $biz_website, 'timestamp'=> time(),'type'=>$biz_restaurant_type ); 

       

		$addressData = array(

		'street_address_1' => $biz_address_1,

		'street_address_2' => $biz_address_2,

		'zip_code' => $biz_zip_code,

		'city' => $biz_city,

		'state' => $biz_state,

		'phone' => $biz_phone,

		'latitude' => $lat,

        'longitude' => $long

		);

				

		if($business_address_id>0){

			$this->db->where('id', $business_address_id);

            $this->db->update('address', $addressData);

		}

		 

		if($business_id>0){

			$this->db->where('id', $business_id);

            $this->db->update('business', $businessData);

		}

		echo($this->dr->GetDR('','', 1, "0"));

	}

	/**

	* not used.

	*/

	function delete_all_business_fromzone(){//var_dump($_REQUEST);exit;

		$data['zoneid'] = $_REQUEST['zoneid'];

		$data['delete_business'] =$this->zone_model->delete_all_business_fromzone($data['zoneid']);//var_dump($data['delete_business']);exit;

		echo($this->dr->GetDR('','',$data['delete_business'],"0"));

    }	

################################################  Zone Business Part End #####################################################################





	

################################################  New Organization Start ####################################################################################	

	/**

	 * This function is help to open the new organization view

	 *

	 * Input Parameters:

	 * <ol>

	 * <li> zoneid</li>

	 * </ol>

	*/

	/**pending all**/public function neworganization($zoneid=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($zoneid,$fromzoneid);		 	

		$data['zoneid']=$data['common']['zoneid'];		

		$data['right_container'] = $this->load->view("zone/create_new_organization", $data, true); 

		$this->common($data);

			

	}

	/**

	* This function is checking organization username is exist or not. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> organization id</li>

	* <li> organization username</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>check_org_username</b> (Model Name: sales_zone)</li>

	* </ol>

	*/

	/**pending all**/public function check_org_username(){//var_dump($_REQUEST);exit;

		$data=array();

		$data['zoneid'] = $_REQUEST['zoneid']; $data['org_username'] = $_REQUEST['org_username']; $data['org_id'] = $_REQUEST['org_id'];

		$data['realtor_username'] = $_REQUEST['realtor_username'];//$data['org_username_other'] = $_REQUEST['org_username_other'];

		$result = $this->sales_zone->check_org_username($_REQUEST['zoneid'],$_REQUEST['org_username'],$_REQUEST['realtor_username']);

		//var_dump($result);

		//$result='';

		echo($this->dr->GetDR("Title", "Message", $result, 0));

	}

	/**

	* This function is generate organization password depends on organization name. 

	*

	*/

	public function create_generate_password_org(){
		$size = 10;
		$special_char =  array("&","%","#","$","@");
		$pool = array_merge(range(0, 9), $special_char,range('A', 'Z'), range(0, 9),$special_char,range('a', 'z'),$special_char);
		$rand_keys = array_rand($pool, $size);
		$password = '';
		foreach ($rand_keys as $key) { $password .= $pool[$key];}
		$password = $password."!";
		echo json_encode($password);
	}

	/**

	* This function is to generate direct url for menu. 

	*

	*/

	/**pending all**/public function create_direct_url(){



		$zoneId = $_REQUEST['zoneid'];

		$businessName = $_REQUEST['business'];

		$data["zone_name"] = $this->zone_model->get_zone_name($zoneId);

		$zoneName = $data["zone_name"][0]['seo_zone_name'];

		$url =base_url()."zone/".$zoneName."/".$businessName;		

		echo($this->dr->GetDR("","", $url, "0"));

	}



	public function organization_registration($id= -1,$organizationname='',$accounttype = '',$email = '',$username = '',$zipcode= '',$state = '',$city='',$firstname='',$lastname='',$phone='',$address='',$password='',$salt='',$pass='',$selzone = '',$viacsv = 0){


		$group_arr = array();
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:-1; 
		$org_name = (!empty($_REQUEST['org_name']))? $_REQUEST['org_name'] : $organizationname;
		$org_type=isset($_REQUEST['org_type'])?$_REQUEST['org_type']:$accounttype;
		$org_email = isset($_REQUEST['org_email'])?$_REQUEST['org_email']:$email;
		$org_username = (!empty($_REQUEST['org_username']))? str_replace("-", "", $_REQUEST['org_username']) : $username;
		$org_password = isset($_REQUEST['org_password'])?$_REQUEST['org_password']:$password;
		$announcement_display =isset($_REQUEST['announcement_display'])?$_REQUEST['announcement_display']:0;
		$zip = (!empty($_REQUEST['zip'])) ? $_REQUEST['zip'] : $zipcode;
		$state = (!empty($_REQUEST['state'])) ? $_REQUEST['state'] : $state;
		$city = (!empty($_REQUEST['city']))? $_REQUEST['city'] : $city;
		$selZone = isset($_REQUEST['selzone'])?$_REQUEST['selzone']:$selzone;
		$fname =(!empty($_REQUEST['fname']))? $_REQUEST['fname'] : $firstname;
		$lname = (!empty($_REQUEST['lname']))? $_REQUEST['lname'] : $lastname;
		$phone =(!empty($_REQUEST['phone']))? str_replace("-", "", $_REQUEST['phone']) : $phone;
		$phone =(!empty($_REQUEST['phone']))? str_replace(".", "", $_REQUEST['phone']) : $phone;
		$user_address = (!empty($_REQUEST['user_address']))? $_REQUEST['user_address'] : $address;
		$user_city = (!empty($_REQUEST['user_city']))? $_REQUEST['user_city'] : "";
		$user_state = (!empty($_REQUEST['user_state']))? $_REQUEST['user_state'] : "";
		$user_zip = (!empty($_REQUEST['user_zip']))? $_REQUEST['user_zip'] : "";
		$referalcode = (!empty($_REQUEST['referalcode']))? $_REQUEST['referalcode'] : "";
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';

 		if($selZone != -1){
			$sql_get_zone_owner_email = "SELECT b.id , b.name , a.email , a.first_name , a.last_name FROM users a , sales_zone b WHERE a.id = b.sales_rep_id AND b.id=".$selZone;
			$query_sql_get_zone_owner_email = $this->db->query($sql_get_zone_owner_email);
			$res_zone_owner_email = $query_sql_get_zone_owner_email->getResultArray(); 
			$ZO_email = $res_zone_owner_email[0]['email'];
			$ZO_fname = $res_zone_owner_email[0]['first_name'];
			$ZO_lname = $res_zone_owner_email[0]['last_name'];
			$zone_id = $res_zone_owner_email[0]['id'];
			$ZO_name = $res_zone_owner_email[0]['name'];	
		} 
		if($zip != -1){
			$sql_zone_from_zip = "SELECT c.id , c.name, a.email , a.first_name , a.last_name FROM users a , tblClaimedZips b , sales_zone c WHERE a.id=b.uid AND c.sales_rep_id=a.id AND b.zip=".$zip;
			$query_sql_zone_from_zip = $this->db->query($sql_zone_from_zip);
			$res_sql_zone_from_zip = $query_sql_zone_from_zip->getResultArray(); 

			$zip_Zo_mail = $res_sql_zone_from_zip[0]['email'];
			$zip_Zo_fname = $res_sql_zone_from_zip[0]['first_name'];
			$zip_Zo_lname = $res_sql_zone_from_zip[0]['last_name'];
			$zone_id = $res_sql_zone_from_zip[0]['id'];
			$zip_Zo_name = $res_sql_zone_from_zip[0]['name'];
		}
		
		$phone = str_replace("-", "", $phone);
		/*check phone number exists*/
		$usernameqry="SELECT a.phone,b.group_id FROM users as a INNER JOIN users_groups as b ON a.id=b.user_id WHERE a.username = '".$org_username."'";
		$usernameexists = $this->CommonController->SelectRawquery($usernameqry,'count');
		if($usernameexists > 0){
			echo json_encode(['msg'=>'UserName Already Exists','type'=>'warning']);
			die;
		}
		$userorgquery="SELECT a.phone,b.group_id FROM users as a INNER JOIN users_groups as b ON a.id=b.user_id WHERE a.phone = '".$phone."' AND b.group_id=8";
		$userexists = $this->CommonController->SelectRawquery($userorgquery,'count');
		if($userexists > 0){
			echo json_encode(['msg'=>'User Phone Number Already Exists, Please Use Another Phone Number','type'=>'warning']);
			die;
		}
		$userorgnoquery="SELECT a.phone,b.group_id FROM users as a INNER JOIN users_groups as b ON a.id=b.user_id WHERE a.email = '".$org_email."' AND b.group_id=8";
		$userenoxists = $this->CommonController->SelectRawquery($userorgnoquery,'count');
		if($userenoxists > 0){
			echo json_encode(['msg'=>'User Email Already Exists, PLease Use Another Email Address','type'=>'warning']);
			die;
		}
		/*check phone number exists*/


		$additional_data = array('first_name' => $fname,'last_name' => $lname,'phone' => $phone,'Address' => $user_address,'City' => $city,'State_Code' => $state,'Zip' => $zip, 'Zone_ID' => $selZone);
		$group_arr['group_arr'] = 8; 
		$organization_owner_id = $this->ionAuth->register($org_username, $org_password, $org_email, $additional_data,$group_arr);
		
		$this->ionAuth->change_user_group($organization_owner_id);

		$data_org=array('name' => $org_name,'type'=>$org_type,'zoneid' => $zone_id,'userid'=>$organization_owner_id,'announcement_display'=>0,'approval'=>1,'viacsv'=>$viacsv); 

		$this->db->table('organization')->insert($data_org);
		$id = $insert_id = $this->db->insertID();
		
		if($referalcode){
			$sql = "SELECT organization.id FROM `users` LEFT JOIN users_groups ON users_groups.user_id = users.id LEFT JOIN organization ON organization.userid = users.id WHERE users_groups.group_id = 8 AND users.referral_code = '".$referalcode."' ";
			$query=$this->db->query($sql); 
	        $organization_id=$query->getResultArray();
			$id = $organization_id[0]->id;
	    	if ($id) {
		    	$data_org1=array('userid' => $organization_owner_id,'zoneid'=>$zone_id,'org' => $id); 
		    	$this->db->table('tbl_selected_nonorg')->insert($data_org1);
				$id = $insert_id = $this->db->insertID();
			}
		}
		
		$group_id = $this->ionAuth->getuserid($organization_owner_id); 
		
		if($id>0 && $id!=''){

			$data_peekaboo=array(
				'fName'=>$fname,
				'lName'=>$lname,
				'email'=>$org_email,
				'address1'=>$user_address,
				'company_name'=>$org_name,
				'city_name'=>$user_city,
				'state_name'=>$user_state,
				'post_code'=>$user_zip,
				'phone'=>$phone,
				'user_name'=>$org_username,
				'password'=>sha1($org_password),
				'activated'=>'yes',
				'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),
				'member_type'=>2
			);
 

			if($zonesubuser != ''){
				$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Add Organization',serialize($data_peekaboo));
			}
			
			$this->db->table('tbl_member')->insert($data_peekaboo);
			$peekaboo_id = $this->db->insertID();	
			if($pass != ''){
				$this->CommonController->updateData('users',['uploaded_organization_password'=>$pass],array('id' => $organization_owner_id));
			}
		 	
		 	$data_calendar=array('role_id'=> '8','email'=>$org_email,'users_id'=>$organization_owner_id,'password'=>sha1($org_password),'name'=>$org_name,'phone'=>$phone,'created'=>date('Y-m-d H:i:s.0000'),'last_login'=>date('Y-m-d H:i:s.0000'),'status'=>'T','is_active'=>'F','zoneid'=>$zone_id,'ip'=>$_SERVER['REMOTE_ADDR']);
			
			$this->db->table('calendarphpeventcalendar_users')->insert($data_calendar);
			$calendar_id = $this->db->insertID();
		}
		if($id>0){
			$message_sub ="Hey ".$fname.' '.$lname." Your ". $org_name." Registration Successful.";
			$message_body="<div style='color:#000;background: #fff;width: 70%;margin: 50px auto;padding: 11px;border: 1px solid #ccc;font-size: 14px;line-height: 26px;box-shadow: 0px 1px 11px rgb(111 110 122 / 52%);'><div style='text-align: center;background: #f2f2f2;padding: 17px;margin-bottom: 20px'><img style='width: 240px;' src='https://cdn.savingssites.com/logo-green.png'/></div><br><br><br>

				<div style='border:1px solid #a6cd7a; padding:5px;'><font size='4'>Dear ".$org_name.",<br /><br />Thank you for your SavingsSites registration.<br/><br/>
					You can login into your account and change the information at your convenience.<br /><br />
					We are constantly trying to improve this application, and will notify you of future updates <b>when</b> they are available. If you have any <b>questions</b> in the meantime, then please email us at <a href='mailto:support@savingssites.com'>support@savingssites.com</a> and we will get back to you promptly.<br /><br />
					Best Regards,<br />
					Savings Sites Support<br/><br/>
					<hr>Please add <a href='mailto:noreply@savingssites.com'>noreply@savingssites.com</a> to your email whitelist.<br/><br/></font>";
					"<br>
					<div style='background: #000;color: #fff;text-align: center;padding: 1px 0 1px;line-height: 0;margin-top: 15px;'><p>© 2023 SS Businesses Search . All Rights Reserved.</p></div>";
			// $send = $this->CommonController->SendMail('',$org_email,$message_sub,$message_body);
			
			if($selZone != -1){ 

				$message_sub = "Thank You For Registering!";

				$message_body="<div style='border:1px solid #a6cd7a; padding:5px;'><font size='4'>Hi, ".$ZO_fname."<br /><br />
					A new organization owner has registered in ".$ZO_name.". The following are the user details.<br/><br/>	
					Organization Name : ".$org_name."<br /><br />
					First Name:  ".$fname."<br /><br />
					Last Name:  ".$lname."<br /><br />
					Telephone:  ".$phone."<br /><br />
					Email:  ".$org_email."<br /><br />
					Street Address:  ".$user_address."<br /><br />
					City :  ".$user_city."<br /><br />
					State:  ".$user_state."<br /><br />
					Zip:  ".$user_zip."<br /></font>" ;

					// $send = $this->CommonController->SendMail('',$org_email,$message_sub,$message_body);

            }else if($zip!=-1){	
				$message_sub = "Thank You For Registering!";
				$message_body="<div style='border:1px solid #a6cd7a; padding:5px;'<font size='4'>Hi, ".$zip_Zo_fname."<br /><br />
					A new organization owner has registered in ".$zip_Zo_name.". The following are the user details.<br/><br/>	
					Organization Name : ".$org_name."<br /><br />
					First Name:  ".$fname."<br /><br />
					Last Name:  ".$lname."<br /><br />
					Telephone:  ".$phone."<br /><br />
					Email:  ".$org_email."<br /><br />
					Street Address:  ".$user_address."<br /><br />
					</font>" ;
					// $send = $this->CommonController->SendMail('',$org_email,$message_sub,$message_body);
          }
        }
    if($pass != ''){
    	return 1;
   	}else{
   		echo json_encode(['type'=>'success','msg'=>'Thank You For Registering! We Will Be Contacting You Shortly']);
			die;
    }
		die;
	}
	
	function SaveOrganization(){

		$auser = $this->ion_auth->user()->row();

		$uid = $auser->id;

		$id = stripslashes($_REQUEST['id']); 

		$zone_id = stripslashes($_REQUEST['zone_id']);

		/*echo $org_name = $this->db->escape_str(stripslashes($_REQUEST['org_name'])); echo '<br>'; echo 1; echo '<br>';

		echo $org_name = $this->db->escape_str(stripslashes($_REQUEST['org_name'])); exit;*/

		$org_name = $this->db->escape_str($_REQUEST['org_name']);

		$org_type=$_REQUEST['org_type'];

		$org_email = $this->db->escape_str($_REQUEST['org_email']);

		$org_username = $this->db->escape_str($_REQUEST['org_username']);

		$org_password = $this->db->escape_str($_REQUEST['org_password']);

		$announcement_display =$this->db->escape_str($_REQUEST['announcement_display']);

		if($id>0){			

			$newdata=array('name' => $org_name,'type'=>$org_type,'announcement_display'=>$announcement_display);

			$this->db->where('id',$id);

            $this->db->update('organization', $newdata);

			$update_users=$this->ion_auth->update_user_info_for_organization($id,$org_username,$org_password,$org_email,$zone_id);

			$template_subject="Your organization has been edited";

			$message_change="edited";

		}else{

			$additional_data='';

			$group_arr = array();

			$group_arr['group_arr'] = 8; 

			$organization_owner_id = $this->ion_auth->register($org_username, $org_password, $org_email, $additional_data,$group_arr);

			$this->ion_auth->change_user_group($organization_owner_id);

			$data_org=array('name' => $org_name,'type'=>$org_type,'zoneid' => $zone_id,'userid'=>$organization_owner_id,'announcement_display'=>$announcement_display,'approval'=>1); 

			$this->db->insert('organization', $data_org);



			$organization_id = $this->db->insert_id();

			/* Add data to interser group*/

			$data_group_interest = array(

				'name' => 'Get Our Notices',

				'description' => 'by Org',

				'createdby_type' => 3,

				'createdby_id' => $organization_id,

				'assign_type' => 0,

				'status' => 1

			);

			$this->db->insert('group_interest', $data_group_interest);

			/* End*/

			

			/*// + Get Zone name 

			  $zone_name = $this->org_model->get_zone_name($zone_id);			 			

			// + Get Zone name 	*/		

			

				// + Organization create peekaboo account with the same users name and password	

					$data_peekaboo=array(

						 'email'=>$org_email,

						 'user_name'=>$org_username,

						 'password'=>sha1($org_password),

						 'activated'=>'yes',

						 'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),

						 'company_name'=>$org_name,

						 'member_type'=>2

					);

					$this->db->insert('tbl_member', $data_peekaboo);

					$peekaboo_id = $this->db->insert_id(); 

			   // + Organization create peekaboo account with the same users name and password

			   

			   

			   // + Organization owner create calendar account 

			        $data_calendar=array(

				         'role_id'=> '8', 

						 'email'=>$org_email,

						 'users_id'=>$organization_owner_id,

						 'password'=>sha1($org_password),

						 'name'=>$org_name,

						 'created'=>date('Y-m-d H:i:s.0000'),

						 'last_login'=>date('Y-m-d H:i:s.0000'),

						 'status'=>'T',

						 'is_active'=>'F',

						 'zoneid'=>$zone_id,

						 'ip'=>$_SERVER['REMOTE_ADDR'],

					);

					

				$this->db->insert('calendarphpeventcalendar_users', $data_calendar);

				$calendar_id = $this->db->insert_id();	

		     // + Organization owner create calendar account	

			   

		}

		$data['organization_list'] = $this->org_model->get_organization_for_zone($_REQUEST['zone_id']);

		$data['zoneinformation'] = $this->announcements->get_zoneinformation($_REQUEST['zone_id']); // get zone informations		

		$var = $this->load->view("dashboards/zone_parts/organization_display.php",$data, true);

        echo($this->dr->GetDR("Save Successful", "The save was successful", $var, $height = "0"));

	}

	/**

	* This function is not used.

	*/

	function upload_csv_file_organization($filename, $form_id){ 

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

    			

    		$output_image_data = '<p class="form-group-row" style="margin-left:200px;color:#859731">New Uploaded file : <b>'.$img_display."</b></p>";

    		$output_image_data .= '<input type="text" name="docs_pdf" id="docs_pdf" value="'.$img.'" />'; //var_dump($output_image_data);

    		$result = 'docs-upload-success';

    		

    	}

    

    	sleep(1);

    	?>

    		<script language="javascript" type="text/javascript">window.top.window.stopUpload('<?php echo $result; ?>', '<?php echo $output_image_data;?>', 'logo_image22', '<?php echo $filename;?>', '<?php echo $form_id;?>');</script>   

    		<?php

	}

	/**

	* This function is viewing the organization details. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* </ol>

	*/

	/**pending all**/public function vieworganization($zoneid=false,$fromzoneid=0){ 	

		

		$data['common']=$this->common_first($zoneid,$fromzoneid);		 	

		$data['zoneid']=$data['common']['zoneid'];		

		$data['right_container'] = $this->load->view("zone/view_organization", $data, true); 

		$this->common($data);

			

	}

	/**

	* This function is displaying all organizations of a specific zone. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> organization id</li>

	* <li> searching value</li>

	* <li> limits</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>get_organization_for_zone</b> (Model Name: org_model)</li>

	* </ol>

	* <br>

	* view page: <b>views/zone/subpage/organization/organization_display</b>

	*/

	/**pending all**/public function getOrganizationData($id,$charval,$type,$lowerlimit,$upperlimit){ //var_dump($id);  

		$data=array();

		

		// for csv uploader */

		$data['organization_list'] = $this->org_model->get_organization_for_zone($id,$charval,$type,$lowerlimit,$upperlimit); //var_dump($data['organization_list']);

		$data['count_organization_list']=count($data['organization_list']); 

		if($data['count_organization_list']<=1){

			$data['count_organization_list']=0;

		}

		$lowerlimit=$lowerlimit+15;

		$upperlimit1=2;

		$limit=$lowerlimit.','.$upperlimit;

		$data['organization_type'] = $type;

		$result = $this->load->view("zone/subpage/organization/organization_display.php",$data, true); 

		echo($this->dr->GetDR($data['count_organization_list'],$limit, $result, "0"));

	}

	/**

	* This function is viewing the edit organization form. 

	*

	*/

	/**pending all**/public function EditOrganization($id){

		echo(json_encode($this->org_model->get_organization_by_id($id)));

	}

	/**

	* This function is used for organization's status change and can update/delete business(s) from the 'business filtered search' results. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> organization id</li>

	* <li> action_performed( it defines whether to change status or delete)</li>

	* <li> allorspecific ( it defines selected organization or all organization)</li>

	* <li> organization_type( it defines municipality or others type of organization)</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the two functions in two related models.

	* <br>

	* <ol>

	* <li><b>fn_organization_status_change</b> (Model Name: org_model, Utility: Change the status of a organization)</li> 

	* <li><b>fn_organization_delete</b> (Model Name: org_model,  Utility: Delete organization and organization associated data like announcements etc.)</li>

	* </ol>

	*/

	/**pending all**/public function action_performed_organization(){ //var_dump($_REQUEST); exit;

		$data = array();

		$data['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

		$data['zoneid'] =!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : '';

		$data['action_performed'] = !empty($_REQUEST['action_performed']) ? $_REQUEST['action_performed'] : '';

		$data['change_business_status'] = !empty($_REQUEST['change_business_status']) ? $_REQUEST['change_business_status'] : '';

		$data['allorspecific'] = !empty($_REQUEST['allorspecific']) ? $_REQUEST['allorspecific'] : '';

		$data['organization_type'] = !empty($_REQUEST['organization_type']) ? $_REQUEST['organization_type'] : '';

		//var_dump($data); //exit;

		// Change organization status

		if($data['action_performed'] == 1){

			$data['my_organization_in_zone'] = $this->org_model->fn_organization_status_change($data['id'],$data['zoneid'],$data['action_performed'],$data['change_business_status'],$data['allorspecific'],$data['organization_type']);

		}

		// Dele Organixation

		else if($data['action_performed'] == 2){  

			$data['my_organization_in_zone'] = $this->org_model->fn_organization_delete($data['id'],$data['zoneid'],$data['action_performed'],$data['change_business_status'],$data['allorspecific'],$data['organization_type']); //var_dump($data['my_organization_in_zone']);exit;

			

					

		}

		

		echo($this->dr->GetDR($data['my_organization_in_zone'],"", "", "0"));	

		

	}

	/**

	* This function is deleting the organization.

	* <br> 

	* View: <b>views/zone/subpage/organization/organization_display</b>

	*

	*/

	/**pending all**/public function DeleteOrganization(){ //var_dump($_REQUEST); exit;

		$id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

		$zone_id =!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : '';

		$data = array();

		$data['organization_delete']=$this->org_model->delete_organization_by_id($id,$zone_id);  

		$data['organization_list'] = $this->org_model->get_organization_for_zone($zone_id); 

		$data['countallannouncements']=count($data['organization_list']);        

		$result = $this->load->view("zone/subpage/organization/organization_display.php",$data, true);

		echo($this->dr->GetDR("","", $result, "0"));		

	}

	/**

	* Not used.

	*/

	/**pending all**/public function ApprovalOrganization($id,$status,$zoneid,$charval=false,$lowerlimit=false,$upperlimit=false){

		$data = array();

		$data['ApprovalOrganization']=$this->org_model->announcement_organization_status_change($id,$status);

		$data['organization_list'] = $this->org_model->get_organization_for_zone($zoneid,$charval,$lowerlimit,$upperlimit);

		$data['count_organization_list']=count($data['organization_list']); 

		if($data['count_organization_list']<=1){

			$data['count_organization_list']=0;

		}

		$limit=$lowerlimit.','.$upperlimit;	

		$result = $this->load->view("zone/subpage/organization/organization_display.php",$data, true);

		echo($this->dr->GetDR($data['count_organization_list'],$limit, $result, "0"));

	}	    					

	/**

	* This function is viewing the high school sports details. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* </ol>

	*/

	/**pending all**/public function viewhighschoolsports($zoneid=false,$fromzoneid=0){ 		

		$data['common']=$this->common_first($zoneid,$fromzoneid);		 	

		$data['zoneid']=$data['common']['zoneid'];		

		$data['right_container'] = $this->load->view("zone/view_highschoolsports", $data, true); 

		$this->common($data);

	}	

	/**

	* This function is displaying all high school sports details. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> organizationid</li>

	* <li> search value</li>

	* <li> organization type( it defines municipality or high sports or others)</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>get_highschoolsports_for_zone</b> (Model Name: org_model)</li>

	* </ol>

	* <br>

	* view page: <b>views/zone/subpage/organization/highschoolsports_display</b>

	*/

	/**pending all**/public function getHighschoolsportsData($id,$charval,$type,$lowerlimit,$upperlimit){

		$data=array();



		// for csv uploader */

		$data['organization_list'] = $this->org_model->get_highschoolsports_for_zone($id,$charval,$type,$lowerlimit,$upperlimit);

		$data['count_organization_list']=count($data['organization_list']); 

		if($data['count_organization_list']<=1){

			$data['count_organization_list']=0;

		}

		$lowerlimit=$lowerlimit+15;

		$upperlimit1=2;

		$limit=$lowerlimit.','.$upperlimit;

		$data['organization_type'] = $type;

		$result = $this->load->view("zone/subpage/organization/highschoolsports_display",$data, true); 

		echo($this->dr->GetDR($data['count_organization_list'],$limit, $result, "0"));

	}

	/**

	* This function is viewing announcement details. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> userid</li>

	* </ol>

	*/	

	/**pending all**/public function viewannouncement($zoneid=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($zoneid,$fromzoneid);	

		$data['uid'] = $data['common']['uid'];	 	

		$data['zoneid']=$data['common']['zoneid'];	

		$data['orgvalue'] = 0;		

		$data['right_container'] = $this->load->view("zone/view_announcement", $data, true); 

		$this->common($data);

	}

	/**

	* This function is viewing announcement details

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> userid</li>

	* <li> other values from view page</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>get_organization_by_announcement_type</b> (Model Name: org_model)</li>

	* </ol>

	* <br>

	* view page: <b>views/zone/subpage/organization/organization_list</b>

	*/

	/**pending all**/public function get_org_list(){ 

		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '' ;

		$userid = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : '' ;

		$char = !empty($_REQUEST['char']) ? $_REQUEST['char'] : '' ;	

		$announcement_type = ($_REQUEST['select_id'] != '') ? $_REQUEST['select_id'] : '' ;

		$orgvalue = ($_REQUEST['orgvalue'] != '') ? $_REQUEST['orgvalue'] : '' ;	

		$data['select_id'] = !empty($_REQUEST['select_id']) ? $_REQUEST['select_id'] : '' ;	

		$data['zoneid'] = $zoneid ;

		$data['announcement_organization_data'] = $this->org_model->get_organization_by_announcement_type($zoneid,$userid,$orgvalue,$char,$announcement_type);

        $data['announcement_organization'] = $data['announcement_organization_data'][0];

        $data['announcement_org_ids'] = $data['announcement_organization_data'][1];

		$data_all_org_ids=explode(',',$data['announcement_org_ids']);

		$data['data_all_org_ids']=count($data_all_org_ids); 

		$result = $this->load->view("zone/subpage/organization/organization_list", $data, true); 

		echo($this->dr->GetDR("","",$result, "0")); 

	}

	/**

	* This function is viewing high school announcement details. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> userid</li>

	* </ol>

	*/

	/**pending all**/public function viewhighschool_announcement($zoneid=false,$fromzoneid=0){

		$data['common']=$this->common_first($zoneid,$fromzoneid);	

		$data['uid'] = $data['common']['uid'];	 	

		$data['zoneid']=$data['common']['zoneid'];	

		$data['orgvalue'] = 0;		

		$data['right_container'] = $this->load->view("zone/view_highschool_announcement", $data, true); 

		$this->common($data);

	}



    /**

	* This function is viewing high school announcement details

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> userid</li>

	* <li> other values from view page</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>get_highschool_organization_by_announcement_type</b> (Model Name: org_model)</li>

	* </ol>

	* <br>

	* view page: <b>views/zone/subpage/organization/organization_list</b>

	*/

	/**pending all**/public function get_highschool_org_list(){

		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '' ;

		$userid = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : '' ;

		$char = !empty($_REQUEST['char']) ? $_REQUEST['char'] : '' ;	

		$announcement_type = ($_REQUEST['select_id'] != '') ? $_REQUEST['select_id'] : '' ;

		$orgvalue = ($_REQUEST['orgvalue'] != '') ? $_REQUEST['orgvalue'] : '' ;	

		$data['select_id'] = !empty($_REQUEST['select_id']) ? $_REQUEST['select_id'] : '' ;	

		$data['zoneid'] = $zoneid ;

		$data['announcement_organization_data'] = $this->org_model->get_highschool_organization_by_announcement_type($zoneid,$userid,$orgvalue,$char,$announcement_type);

        $data['announcement_organization'] = $data['announcement_organization_data'][0];

        $data['announcement_org_ids'] = $data['announcement_organization_data'][1];

		$data_all_org_ids=explode(',',$data['announcement_org_ids']);

		$data['data_all_org_ids']=count($data_all_org_ids); 

		$result = $this->load->view("zone/subpage/organization/organization_list", $data, true); 

		echo($this->dr->GetDR("","",$result, "0")); 

	}

	/**

	* not in used

	*/

	/**pending all**/public function display_announcement_submenu($zoneid='',$selectid=''){ 

		$data = array();

		$org_id = !empty($_REQUEST['org_id']) ? $_REQUEST['org_id'] : '';

		$data['zoneid']=$zoneid;

		$data['selectid']=$selectid;

		$data['org_id']=$org_id;

		$data['org_name']=$this->org_model->get_organization_name_against_id($org_id);		 	

		$result = $this->load->view('zone/subpage/organization/display_organization_submenu', $data, true); 

		echo($this->dr->GetDR($zoneid,"",$result, "0")); 

	} 

	/**

	* not in used

	*/

	/**pending all**/public function display_announcement($selectid='',$zoneid='',$charval='',$lowerlimit='',$upperlimit=''){

		$org_id = !empty($_REQUEST['org_id']) ? $_REQUEST['org_id'] : ''; 

		$data = array();		

		$data['zoneid'] = $zoneid;

		$data['selectedoption'] = $selectid;

		$data['org_id'] = $org_id;

		$data['charval']=$charval;

		if($org_id!=''){

			$count_org_id=explode('-',$org_id);

			$data['count_org_id']=count($count_org_id);

			if($data['count_org_id']==1){

				$data['org_name']=$this->org_model->get_organization_name_against_id($org_id);

			}

		}

		$data['announcement_approve_zone'] = $this->org_model->get_announcements_in_zone_for_approve($selectid,$zoneid,$org_id,$charval,$lowerlimit,$upperlimit); 	

		$data['countallannouncements']=count($data['announcement_approve_zone']);	

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$my_zones = $this->sales_zone->get_zones_for_user($uid);

		$data['my_zones']=count($my_zones);			

		$lowerlimit=$lowerlimit+5;

		$limit=$lowerlimit.','.$upperlimit;

		$result = $this->load->view('zone/subpage/organization/announcement_display_new.php', $data, true); 

		echo($this->dr->GetDR($data['countallads'],$limit,$result, "0"));

	}

	/**

	* not in used

	*/

	/**pending all**/public function edit_announcement($id,$zoneid,$selectid,$mainid,$orgid,$allbusiness_id){  

		$data['announcement_approve_zone_save'] = $this->org_model->edit_announcement_in_zone_for_approve($id,$zoneid,$selectid,$orgid);

	}

	/**

	* not in used

	*/

	/**pending all**/public function delete_announcement(){ 

		$data = array();

		$data['id'] = $_REQUEST['id'];

		$data['zoneid'] = $_REQUEST['zoneid'];

		$data['selectedoption'] = $_REQUEST['option']; 

		$data['mainid'] = $_REQUEST['select_id'];

		$data['orgid'] = $_REQUEST['orgid'];

		$data['allorganization_id'] = $_REQUEST['org_id'];

		$data['delete_announcements'] = $this->ann_model->delete_announcements($data['id'],$data['zoneid']);		

		echo($this->dr->GetDR("","", $data['id'], "0"));

	}

	/**

	* not in used

	*/

	/**pending all**/public function all_announcements_status_change($orgid=0,$status=0,$zoneid=0){ 

		$data['status_change'] = $this->org_model->all_announcements_status_change($orgid,$status);

		echo($this->dr->GetDR("","", $data['status_change'], "0"));

	}



################################################  Zone Organization Part End #########################################################################



###########################################################		Zone Marketing Matarials Start	 #############################################

   /**

	* This function is displaying Zone Marketing Materials view. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* view page: <b>views/zone/subpage/marketmatarials</b>

	*/	

	/**pending all**/public function zonemarketmatarials($zoneid=false,$fromzoneid=0){ 	

		

		$data['common']=$this->common_first($zoneid,$fromzoneid);	

		$data['zone_id'] = $data['common']['zoneid'] ;	

		$data['right_container'] = $this->load->view("zone/marketmatarials", $data, true); 

		$this->common($data);	

			

	}

	/**

		* This function is displaying Zone Marketing Materials details. 

		*

		* This function is accessable from the Zonedashboard.

		* <br>

		* Input Parameters:

		* <ol>

		* <li> zoneid</li>

		* <li> userid</li>

		* </ol>

		* After getting all the  parameters from the view page, these values passes through the function in related model.

		* <br>

		* <ol>

		* <li><b>get_all_mm</b> (Model Name: sales_zone)</li>

		* </ol>

		* <br>

		* view page: <b>views/zone/subpage/marketing_matarials/mm_display</b>

	*/		

	/**pending all**/public function view_all_mm(){

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$data = array();

		$data['uid']=$uid;

		$zoneid=$_REQUEST['zoneid'];

		$data['market_materials']=$this->sales_zone->get_all_mm($zoneid);

		//var_dump($data['market_materials']);

		$result = $this->load->view('zone/subpage/marketing_matarials/mm_display', $data, true);		

		echo($this->dr->GetDR("","", $result, "0"));

		

	}

	/**

		* This function is uploading Marketing Materials files into a specific folder. 

		*

		* This function is accessable from the Zonedashboard.

		* <br>

		* Folder Name: uploads/market_materials. 

	*/	

	/**pending all**/public function upload_mar_mat($filename, $form_id){ 

		$new_filename = 'busix_'.time();

    	$result = '';

    	$output_image_data = '';

    	$file_config = array();

    	$file_config['upload_path'] = "./uploads/market_materials/";

    	$file_config['max_size'] = "3072";

    	$file_config['allowed_types'] = "docx|doc|pdf|xlsx";

    	$file_config['max_width'] = 0;

    	$file_config['max_height'] = 0;

    	$this->load->library('upload', $file_config);

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

    /**

	* This function is updating market matarials. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> market matarials id</li>

	* <li> other parameters from view page.</li>

	* </ol>

	* table: marketing_materials 

	*/

	/**pending all**/public function save_market_materials(){

		$_mm_display_name=$_REQUEST['mm_display_name'];

		$_mm_desc=$_REQUEST['mm_desc'];

		$upload_file=$_REQUEST['mm_file']; 

		$upload_file_exp=explode('~!~',$upload_file);

		$name=$upload_file_exp[2];

		$zoneid_arr=explode('_',$upload_file_exp[0]);

		$zoneid=$zoneid_arr[1];		

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

    /**

	* This function is deleting market matarials. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> userid</li>

	* <li> other parameters from view page</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>delete_market_materials</b> (Model Name: sales_zone)</li>

	* <li><b>get_market_materials</b> (Model Name: sales_zone)</li>

	* </ol>

	* <br>

	* view page: <b>views/zone/subpage/view_all_business</b>

	*/

	/**pending all**/public function delete_mm(){

		$id=$_REQUEST['id'];

		$zoneid=$_REQUEST['zoneid'];

		$zone_option=$_REQUEST['zone_option'];

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$data = array();

		$data['zoneid'] = $zoneid;

		$data['zone_option'] = $zone_option;

		$data['uid']=$uid;

		$data['delete_market_materials']=$this->sales_zone->delete_market_materials($id);

		$data['market_materials']=$this->sales_zone->get_market_materials($zone_option,$uid);

		echo($this->dr->GetDR($id,"","", "0"));

	}

###########################################################		Zone Marketing Matarials End	 #################################################



		

############################################### Neighbours Home Sold For Start #####################################################	



# + upload_neighbours_home_image

    /**

	* This function is Upload Neighbours Home Image. 

	* <br>

	* This function is accessable from the Zonedashboard. 

	* 

	*/ 

	/**pending all**/public function upload_neighbours_home_image(){

		$new_filename = 'home_'.time();

    	$result = '';

    	$output_image_data1 = '';

    	$file_config = array();

    	$file_config['upload_path'] = "./uploads/home_sold_images/";

    	$file_config['max_size'] = "2048";

    	$file_config['allowed_types'] = "gif|jpg|png";

    	$file_config['max_width'] = 0;

    	$file_config['max_height'] = 0;

    	$this->load->library('upload', $file_config);

    	if ( ! $this->upload->do_upload($filename,'home_sold_image'))

    	{

    		$result = $this->upload->display_errors();

    	}else{

    		$data['upload_data1'] = $this->upload->data(); 

    		$img_letter = $data['upload_data1']['file_name'];

			$img_display_letter = explode('~!~',$img_letter);

    		$output_image_data1 = 'New Uploaded file : '.$img_display_letter[2];

    		$output_image_data1 .= '<input type="hidden" name="ups_letter" id="ups_letter" value="'.$img_letter.'" />';

    		$result = 'docs-upload-success';

    	}

    	sleep(1);

    	?>

    		<script language="javascript" type="text/javascript">window.top.window.stopUpload('<?php echo $result; ?>', '<?php echo $output_image_data1;?>', 'upload_home_image', '<?php echo $filename;?>', '<?php echo $form_id;?>');</script>   

    		<?php

	}

# - upload_neighbours_home_image



# + neighbours_home added on 22.12.2014 for showing the 'at what price neighbours home sold for' and its related information

/**

	* This function is displaying all businesses from the 'business filtered search' results. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>show_realtor</b> (Model Name: org_model)</li>

	* </ol>

	* <br>

	* view page: <b>views/zone/create_new_realator</b>

	*/

	/**pending all**/public function create_new_realator($zoneid=false,$fromzoneid=0){

		$data['common']=$this->common_first($zoneid,$fromzoneid);

		$data['zoneid']=$data['common']['zoneid'];

		$data['realtor']=$this->org_model->show_realtor($data['zoneid']);

	    $data['right_container'] = $this->load->view("zone/create_new_realator", $data, true);

		$this->common($data);

		

	}

# + SaveRealtor --> added on 09.01.2015



/**

	* This function is displaying SaveRealtor. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> id</li>

	* <li> zoneid</li>

	* <li> org_name</li>

	* <li> org_email</li>

	* <li> org_username</li>

    * <li> org_password</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>update_user_info_for_realtor</b> (Model Name: ion_auth)</li>

	* </ol>

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zone_id</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>register</b> (Model Name: ion_auth)</li>

	* </ol>

	* <br>

	* view page: <b>views/zone/realtor_display</b>

	*/

	

	/**pending all**/public function SaveRealtor(){

		$auser = $this->ion_auth->user()->row();

		$uid = $auser->id;

		$id = stripslashes($_REQUEST['id']); 

		$zone_id = stripslashes($_REQUEST['zone_id']);

		$org_name = $this->db->escape_str($_REQUEST['org_name']);

		$org_email = $this->db->escape_str($_REQUEST['org_email']);

		$org_username = trim($this->db->escape_str($_REQUEST['org_username']));//var_dump($org_username);exit;

		

		$org_password = $this->db->escape_str($_REQUEST['org_password']);

		

		if($id>0){	

			$newdata=array('name' => $org_name);

			$this->db->where('id',$id);

            $this->db->update('realtor', $newdata);

			$update_users=$this->ion_auth->update_user_info_for_realtor($id,$org_username,$org_password,$org_email,$zone_id);

			$template_subject="Your realtor has been edited";

			$message_change="edited";

		}else{

			$additional_data='';

			$group_arr = array();

			$group_arr['group_arr'] = 14; 

			$realtor_owner_id = $this->ion_auth->register($org_username, $org_password, $org_email, $additional_data,$group_arr);

			$data_realtor=array('name' => $org_name,'zoneid' => $zone_id,'userid'=>$realtor_owner_id,'approval'=>1); 

			$this->db->insert('realtor', $data_realtor);

		}

		$data['organization_list'] = $this->org_model->get_realtor_for_zone($_REQUEST['zone_id']);

		$var = $this->load->view("dashboards/zone_parts/realtor_display.php",$data, true);

        echo($this->dr->GetDR("Save Successful", "The save was successful", $var, $height = "0"));

	} 

# - SaveRealtor



# + view_new_realtor

	/**

	* This function View New Realtor info . 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* view page: <b>views/zone/view_realtor</b>

	*/



 	/**pending all**/public function view_new_realtor($zoneid=false,$fromzoneid=0){

		$data['common']=$this->common_first($zoneid,$fromzoneid);		 	

		$data['zoneid']=$data['common']['zoneid'];		

		$data['right_container'] = $this->load->view("zone/view_realtor", $data, true); 

		$this->common($data);

	}

# - view_new_realtor



# + getRealtorData

	/**

		* This function use edit and delete button option for realtor . 

		*

		* This function is accessable from the Zonedashboard. 

		*

		* Input Parameters:

		* <ol>

		* <li> id</li>

		* <li> charval</li>

		* <li> type</li>

		* <li> lowerlimit</li>

		* <li> upperlimit</li>

		* </ol>

		* After getting all the  parameters from the view page, these values passes through the function in related model.

		* <br>

		* <ol>

		* <li><b>get_realtor_for_zone</b> (Model Name: org_model)</li>

		* </ol>

		* view page: <b>views/zone/view_realtor</b>

	*/



# + getRealtorData

	/**pending all**/public function getRealtorData($id,$charval,$type,$lowerlimit,$upperlimit){

		$data=array();

		$data['organization_list'] = $this->org_model->get_realtor_for_zone($id,$charval,$type,$lowerlimit,$upperlimit); 

		$data['count_organization_list']=count($data['organization_list']); 

		if($data['count_organization_list']<=1){

			$data['count_organization_list']=0;

		}

		$lowerlimit=$lowerlimit+15;

		$upperlimit1=2;

		$limit=$lowerlimit.','.$upperlimit;

		$data['organization_type'] = $type;

		$result = $this->load->view("zone/subpage/realtor/realtor_display.php",$data, true); 

		echo($this->dr->GetDR($data['count_organization_list'],$limit, $result, "0"));

	}

	# + action_performed_realtor 

	/**

		* This function use delete and change option through dropdown for realtor . 

		*

		* This function is accessable from the Zonedashboard. 

		*

		* Input Parameters:

		* <ol>

		* <li> id</li>

		* <li> zoneid</li>

		* <li> action_performed</li>

		* <li> change_business_status</li>

		* <li> allorspecific</li>

		* <li> organization_type</li>

		* </ol>

		* After getting all the  parameters from the view page, these values passes through the function in related model.

		* <br>

		* <ol>

		* <li><b>fn_realtor_status_change</b> (Model Name: org_model)</li>

		* </ol>

		* Input Parameters:

		* <ol>

		* <li> id</li>

		* <li> zoneid</li>

		* <li> action_performed</li>

		* <li> change_business_status</li>

		* <li> allorspecific</li>

		* <li> organization_type</li>

		* </ol>

		* After getting all the  parameters from the view page, these values passes through the function in related model.

		* <br>

		* <ol>

		* <li><b>fn_realtor_delete</b> (Model Name: org_model)</li>

		* </ol>

	*/

	

	/**pending all**/public function action_performed_realtor(){

		$data = array();

		$data['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

		$data['zoneid'] =!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : '';

		$data['action_performed'] = !empty($_REQUEST['action_performed']) ? $_REQUEST['action_performed'] : '';

		$data['change_business_status'] = !empty($_REQUEST['change_business_status']) ? $_REQUEST['change_business_status'] : '';

		$data['allorspecific'] = !empty($_REQUEST['allorspecific']) ? $_REQUEST['allorspecific'] : '';

		$data['organization_type'] = !empty($_REQUEST['organization_type']) ? $_REQUEST['organization_type'] : '';

		if($data['action_performed'] == 1){

			$data['my_organization_in_zone'] = $this->org_model->fn_realtor_status_change($data['id'],$data['zoneid'],$data['action_performed'],$data['change_business_status'],            $data['allorspecific'],$data['organization_type']);

		}

		// Delete Organization

		else if($data['action_performed'] == 2){  

			$data['my_organization_in_zone'] = $this->org_model->fn_realtor_delete($data['id'],$data['zoneid'],$data['action_performed'],$data['change_business_status'],$data['allorspecific'],$data['organization_type']);

		}

		

		echo($this->dr->GetDR($data['my_organization_in_zone'],"", "", "0"));	

	} 

	

	

# - EditRealtor

/**

		* This function is editing for realtor. 

		*

		* This function is accessable from the Zonedashboard. 

		*

		* Input Parameters:

		* <ol>

		* <li> id</li>

		* <li> charval</li>

		* <li> type</li>

		* <li> lowerlimit</li>

		* <li> upperlimit</li>

		* </ol>

		* After getting all the  parameters from the view page, these values passes through the function in related model.

		* <br>

		* <ol>

		* <li><b>get_realtor_by_id</b> (Model Name: org_model)</li>

		* </ol>

	*/

# + EditRealtor

	/**pending all**/public function EditRealtor($id){

		echo(json_encode($this->org_model->get_realtor_by_id($id)));

	}

# - EditRealtor



# + view_uploaded_home_sold

	/**

	* This function View New Realtor info . 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* view page: <b>views/zone/view_uploaded_home_sold</b>

	*/



	/**pending all**/public function view_uploaded_home_sold($zoneid=false,$fromzoneid=0){ 			

		$data['common']=$this->common_first($zoneid,$fromzoneid);		

		$data['zoneid']=$data['common']['zoneid'];

		$data['right_container'] = $this->load->view("zone/view_uploaded_home_sold", $data, true); 

		$this->common($data);			

	} 

# - view_uploaded_home_sold



# + Get the csv uploaded home sold information

 	/**pending all**/public function showHomeSold($id,$charval,$lowerlimit,$upperlimit){

		$data=array();

		$data['homesold_list'] = $this->zone_model->showHomeSold($id,$charval,$lowerlimit,$upperlimit);

		$approve_csv_sql = "SELECT auto_approve_csvupload FROM zone_preferences WHERE zoneid=".$id;	

		$approve_csv_query = $this->db->query($approve_csv_sql);

		$data['approve_csv']=$approve_csv_query->result_array();//var_dump($data['approve_csv']);exit;

		$data['count_organization_list']=count($data['homesold_list']); 

		if($data['count_organization_list']<=1){

			$data['count_organization_list']=0;

		}

		$lowerlimit=$lowerlimit+15;

		$upperlimit1=2;

		$limit=$lowerlimit.','.$upperlimit;

		$data['organization_type'] = $type;

		$result = $this->load->view("zone/subpage/realtor/view_uploaded_home_sold_display.php",$data, true); 

		echo($this->dr->GetDR($data['count_organization_list'],$limit, $result, "0"));

	}

# - Get the csv uploaded home sold information

# - delete_home_sold

/**

		* This function use for delete realtor informtion. 

		*

		* This function is accessable from the Zonedashboard. 

		*

		* Input Parameters:

		* <ol>

		* <li> id</li>

		* <li> zoneid</li>

		* <li> action_performed</li>

		* <li> change_business_status</li>

		* <li> allorspecific</li>

		* <li> organization_type</li>

		* </ol>

		* After getting all the  parameters from the view page, these values passes through the function in related model.

		* <br>

		* <ol>

		* <li><b>fn_homesold_delete</b> (Model Name: org_model)</li>

		* </ol>

	*/

# + delete_home_sold

	/**pending all**/public function delete_home_sold(){// function is not defind in the view page

		$data = array();

		$data['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';

		$data['zoneid'] =!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : '';

		$data['action_performed'] = !empty($_REQUEST['action_performed']) ? $_REQUEST['action_performed'] : '';

		//$data['change_business_status'] = !empty($_REQUEST['change_business_status']) ? $_REQUEST['change_business_status'] : '';

		$data['allorspecific'] = !empty($_REQUEST['allorspecific']) ? $_REQUEST['allorspecific'] : '';

		$data['realtor_type'] = !empty($_REQUEST['realtor_type']) ? $_REQUEST['realtor_type'] : '';

		$data['my_organization_in_zone'] = $this->org_model->fn_homesold_delete($data['id'],$data['zoneid'],$data['action_performed'],$data['change_business_status'],$data['allorspecific'],$data['organization_type']);

		echo($this->dr->GetDR($data['my_organization_in_zone'],"", "", "0"));	

	}

# - delete_home_sold





# + delete_home_sold_directory

	/**pending all**/public function delete_home_sold_directory(){

		$data = array();

		$data['id'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';//var_dump($data['id']);exit;

		$realtor_csvdata_id = $data['id'];

		$data['zoneid'] =!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : '';//var_dump($data['zoneid']);exit;

		$_delete_organization = "delete from tbl_savingstore_home_sold WHERE id IN (".$realtor_csvdata_id.") and zoneid=".$data['zoneid'];//echo $_delete_organization;exit;

		$this->db->query($_delete_organization) ;

		

	}

# - delete_home_sold_directory







##################################################### Neighbours Home Sold For End ####################################################################	



	

###########################################################  Webinar Information start ################################################################



	# + Webinar Services 

	/**

	* This function is displaying webinar services . 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* view page: <b>views/zone/webinar_services</b>

	*/

	/**pending all**/public function webinar_services($zoneid=false,$fromzoneid=0){

		$data['common']=$this->common_first($zoneid,$fromzoneid);		

		$data['zoneid'] = $data['common']['zoneid'] ;	

		$data['right_container'] = $this->load->view("zone/webinar_services", $data, true); 

		$this->common($data);

	}

	

	# + webinar Information

	/**

	* This function is displaying webinar Information . 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* view page: <b>views/zone/webinar_information</b>

	*/

	

	/**pending all**/public function webinar_info($zoneid=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($zoneid,$fromzoneid);

		$data['usersid']=$data['common']['user']->id;

		$data['webniar_exist'] = $this->announcements->webniar_exist($data['usersid'],$zoneid);	

		$data['zoneid'] = $data['common']['zoneid'] ;	

		$data['right_container'] = $this->load->view("zone/webinar_information", $data, true); 

		$this->common($data);

	}

	
/**pending all**/public function save_webinar_login(){
    
        $zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

		$username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';	 

		$password=!empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
		
	     $sql="SELECT * FROM wb_webinar_user  where username = '$username'";

	     $query=$this->db->query($sql);
	     
	      $result=$query->num_rows(); 
	      
	     $userpassword=$query->result_array();
	     
	 // echo password_hash('admin123',PASSWORD_DEFAULT) ;
	     

	  
	     if($result == 1){
	          
        		
        		 $verify = password_verify(trim($password), $userpassword[0]['password']);  
        	 
        		   if ($verify) {
        
                  	  $_SESSION['edu_webinar']['username'] = $userpassword[0]['username'];
                  	  $_SESSION['edu_webinar']['role'] = $userpassword[0]['role'];
                  	  $_SESSION['edu_webinar']['userId'] = $userpassword[0]['id'];
                  	  $_SESSION['edu_webinar']['zoneid'] = $userpassword[0]['zoneid'];
                
               
                 echo($this->dr->GetDR($message, "Login Successful", $var , $height = "0"));
            
              } else {
                  
                  echo($this->dr->GetDR($message, "Incorrect Password!", $var , $height = "0"));
              }
      
      
      
      
	     }else{
	         
	         echo($this->dr->GetDR($message, "User Not Found!", $var , $height = "0"));
	     }

      

		 
    
}
	

	# + Save Webinar Link

	/**

	* This function is displaying Save Webinar Link . 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	*/

	/**pending all**/public function webinar_settings($zoneid=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($zoneid,$fromzoneid);

		$data['usersid']=$data['common']['user']->id;

		$data['webniar_exist'] = $this->announcements->webniar_exist($data['usersid'],$zoneid);	

		$data['zoneid'] = $data['common']['zoneid'] ;	

        $sql="select * from wb_webinar_setting where zone_id=".$zoneid;

		$query=$this->db->query($sql);
		$data['settingdata'] = $query->result_array();

		

		$data['right_container'] = $this->load->view("zone/webinar_settings", $data, true); 

		$this->common($data);
	}


	 public function saveawskeys(){

	 
        $zoneid = $_REQUEST['zone_id'];
		$sql_delete = "DELETE FROM `tbl_keys_awssmtp` WHERE zoneid=".$zoneid;
		$query = $this->db->query($sql_delete);
	    $insert_query="INSERT INTO tbl_keys_awssmtp set username='".$_REQUEST['username']."' ,  email='".$_REQUEST['email']."',password='".$_REQUEST['password']."',region='".$_REQUEST['region']."' , zoneid = '".$_REQUEST['zone_id']."' ";
	    $this->db->query($insert_query);	
 
	 }

	 	public function saveawssponser(){
		$zoneid = $_REQUEST['zone_id'];
		$arr = ['text'=>'','counter'=>'','image'=>'','sponserid'=>'','sponseractive'=>'','zoneid'=>$zoneid];
		$this->CommonController->InsertData('tbl_keys_awssponser', $arr);
	  $insert_query="INSERT INTO tbl_keys_awssmtp set username='".$_REQUEST['username']."' ,  email='".$_REQUEST['email']."',password='".$_REQUEST['password']."',region='".$_REQUEST['region']."' , zoneid = '".$_REQUEST['zone_id']."' ";
	  $this->db->query($insert_query);	
	}

	public function saveSponser(){
		//path $this->myconfig->AWSimageurl/011-details-2560x1440-A.jpg
		$file = isset($_FILES['file'])?$_FILES['file']:'';
		$text = isset($_REQUEST['text'])?$_REQUEST['text']:'';
		$status = isset($_REQUEST['status'])?$_REQUEST['status']:'';
		$zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:'';
		$filename = $_FILES['file']['name'];
		if($filename == '' && $text == ''){
			echo json_encode(['msg'=>'Please select atleast Image or Text','type'=>'warning']);
			die;
		}
		
		$sql = "SELECT * FROM tbl_keys_awssponser WHERE zoneid='".$zoneid."' ORDER BY id DESC";
		$data = $this->CommonController->SelectRawquery($sql,'row');
		$uploaded_file = $_FILES['file']['tmp_name'];
    	$folder_path1 = "./assets/SavingsUpload/uploadtoaws/";
    	if(is_dir($folder_path1)==false){ mkdir($folder_path1,0777);}
    	$counter = isset($data->counter)?$data->counter:0; 
    	$counterplus = $counter+1;
		if(move_uploaded_file($uploaded_file, $folder_path1.$filename)){
			
			$resname = $this->CommonController->uploadtoaws($folder_path1, $filename);
			$arr = ['text'=>$text,'counter'=>$counterplus,'image'=>$resname,'sponseractive'=>$status,'zoneid'=>$zoneid];
			$this->CommonController->InsertData('tbl_keys_awssponser', $arr);
			unlink($folder_path1.$filename);
			echo json_encode(['msg'=>'sponser data added successfully','type'=>'success']);
			die;
		}
	}	

	public function editSponser(){
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
		$status = isset($_REQUEST['status'])?$_REQUEST['status']:'';
		$arr = ['sponseractive'=>$status];
   	$this->CommonController->updateData('tbl_keys_awssponser',$arr,['id'=> $id]);
		echo json_encode(['msg'=>'sponser Banner Status updated successfully','type'=>'success']);
		die;
	}

  /**pending all**/public function save_webinar_setting(){
 
	 
	    $zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

		$braintree_merchant_id = !empty($_REQUEST['braintree_merchant_id']) ? $_REQUEST['braintree_merchant_id'] : '';	

		$braintree_public_key = !empty($_REQUEST['braintree_public_id']) ? $_REQUEST['braintree_public_id'] : '';

		$braintree_private_key = !empty($_REQUEST['braintree_private_id']) ? $_REQUEST['braintree_private_id'] : ''; 

		$paypal_emailid=!empty($_REQUEST['paypal_emailid']) ? $_REQUEST['paypal_emailid'] : '';

		$payment=!empty($_REQUEST['payment']) ? $_REQUEST['payment'] : '';

		$business_charge=!empty($_REQUEST['business_charge']) ? $_REQUEST['business_charge'] : '';



        $sql="select * from wb_webinar_setting where zone_id=".$zoneid;

		$query=$this->db->query($sql);

		$result=$query->num_rows(); 
 

	    if($result){
         // update settings
	 

 	     $sql_update= "UPDATE wb_webinar_setting SET braintree_merhant_key='".$braintree_merchant_id."' , braintree_public_key='".$braintree_public_key."' , braintree_private_key='".$braintree_private_key."',paypal_id ='".$paypal_emailid."', payment_option ='".$payment."' , business_charge= '".$business_charge."'    WHERE zone_id=".$zoneid;
 	      $query = $this->db->query($sql_update);

	     echo($this->dr->GetDR($message, "The  data update was successful", $var , $height = "0"));

	    }else{


          $webinar=array(

			 'braintree_merhant_key'=>$braintree_merchant_id,

			 'paypal_id'=>$paypal_emailid,

			 'payment_option'=>$payment,

			 'zone_id' => $zoneid,

			  'braintree_public_key'=>$braintree_public_key,

			  'braintree_private_key'=>$braintree_private_key,

			   'business_charge' => $business_charge



		 
		);

		// - Insert the values int the db

		$this->db->insert('wb_webinar_setting', $webinar);  

		$inserted_id = $this->db->insert_id();

	     echo($this->dr->GetDR($message, "The data save was successful", $var , $height = "0"));
        
	    }
  

  }
	 

/**pending all**/public function save_others_website_id($zoneid=false,$fromzoneid=0){



  	   $zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

		$hugegroup_referralid = !empty($_REQUEST['hugegroup_referralid']) ? $_REQUEST['hugegroup_referralid'] : '';	 

		$emailing_referralid=!empty($_REQUEST['emailing_referralid']) ? $_REQUEST['emailing_referralid'] : '';

		$usagroup_referralid=!empty($_REQUEST['usagroup_referralid']) ? $_REQUEST['usagroup_referralid'] : '';		 

		 
		// + Insert the values into the db

		$webinar=array(

			 'zoneid'=>$zoneid, 

			 'emailing_id'=>$emailing_referralid,

			 'usergroup_id'=>$usagroup_referralid,

			 'hugegroup_id'=>$hugegroup_referralid
		);

		// - Insert the values int the db


		$sql="select id from others_referral_id where zoneid=".$zoneid;

		$query=$this->db->query($sql);



		$result=$query->num_rows(); 
	 

		if($result > 0){


	     
		$sql_update= "UPDATE others_referral_id SET  emailing_id='".$emailing_referralid."' ,usergroup_id='".$usagroup_referralid."',  hugegroup_id='".$hugegroup_referralid."'  WHERE zoneid=".$zoneid;

		$query = $this->db->query($sql_update);


		}else{

		$this->db->insert('others_referral_id', $webinar);  

		$inserted_id = $this->db->insert_id();

		}
 
 

		echo($this->dr->GetDR($message, "The save was successful", $var , $height = "0"));


}




/**pending all**/public function allwebinars($zoneid=false,$fromzoneid=0){

  	    $data['common']=$this->common_first($zoneid,$fromzoneid);		

		$data['zoneid']=$data['common']['zoneid'];

		$data['allwebinar'] = $this->zone_model->get_all_webinars($zoneid);

		$data['right_container'] = $this->load->view("zone/all_webinars.php", $data, true); 

		$this->common($data);


}

  /**pending all**/public function save_webinar_register(){
  	
   
	 
        $zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

		$username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';	 

		$lastname=!empty($_REQUEST['lastname']) ? $_REQUEST['lastname'] : '';

		$firstname=!empty($_REQUEST['firstname']) ? $_REQUEST['firstname'] : '';

		$email=!empty($_REQUEST['email']) ? $_REQUEST['email'] : '';

		$passwword=!empty($_REQUEST['passwword']) ? $_REQUEST['passwword'] : '';

		$role=!empty($_REQUEST['role']) ? $_REQUEST['role'] : '';
		
		$userid=!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : '';

	 
 
		 
		// + Insert the values into the db

		$webinar=array(

			 'zoneid'=>$zoneid,

			 'username'=>$username,

			 'lname'=>$lastname,

			 'fname'=>$firstname,

			 'email'=>$email,			 

			 'password'=>password_hash($passwword,PASSWORD_DEFAULT) ,

			 'role'=>$role,
			 
			 'users_id'=>$userid
 


		);

		// - Insert the values int the db

		$this->db->insert('wb_webinar_user', $webinar);  

		$inserted_id = $this->db->insert_id();

		 
	// }

		echo($this->dr->GetDR($message, "User Registered Successfully", $var , $height = "0"));






  }
	 

	/**pending all**/public function save_webinar_link(){


 
		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

		$status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : '';	

		$user_id= $_SESSION['edu_webinar']['userId'];

		$webinar_link=!empty($_REQUEST['webinar_link']) ? $_REQUEST['webinar_link'] : '';

		$start_time=!empty($_REQUEST['ad_startdatetime']) ? $_REQUEST['ad_startdatetime'] : '';

		$end_time=!empty($_REQUEST['ad_stopdatetime']) ? $_REQUEST['ad_stopdatetime'] : '';

		$description=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';

		$room_type=!empty($_REQUEST['room_type']) ? $_REQUEST['room_type'] : '';

		$desImage=!empty($_REQUEST['desImage']) ? $_REQUEST['desImage'] : '';

		$totalpeople=!empty($_REQUEST['totalpeople']) ? $_REQUEST['totalpeople'] : '';

		$category=!empty($_REQUEST['main_cat_selected']) ? $_REQUEST['main_cat_selected'] : '';

		$subcategory=!empty($_REQUEST['main_subcat_selected']) ? $_REQUEST['main_subcat_selected'] : '';


		$price=!empty($_REQUEST['price']) ? $_REQUEST['price'] : '';

		$pemail=!empty($_REQUEST['pemail']) ? $_REQUEST['pemail'] : '';




		$descrirecordinglinkption=!empty($_REQUEST['recordinglink']) ? $_REQUEST['recordinglink'] : '';

		$sql="select id from webinar_information where created_by_userid=".$user_id." AND zoneid=".$zoneid;

		$query=$this->db->query($sql);

		$result=$query->num_rows(); 

		// if($result > 0){

		// 	$message = 1;

		// } 

		// else

		// {

		// + Insert the values into the db

		$webinar=array(

			 'zoneid'=>$zoneid,

			 'link'=>$webinar_link,

			 'description'=>$description,

			 'created_by_userid'=>$user_id,

			 'status'=>$status,

			 'type'=>1,

			 'start_time'=>$start_time,

			 'end_time'=>$end_time,

			 'timestamp'=>time(),

			 'room_type' => $room_type ,

			 'recording_link' => $descrirecordinglinkption ,

			 'webinarImage' => $desImage,

			 'totalpeople' => $totalpeople,

			  'paypal_id' => $pemail,

			 'price' => $price,
			 	 'sub_category' => $subcategory,

			 'category' => $category




		);

		// - Insert the values int the db

		$this->db->insert('webinar_information', $webinar); //echo $this->db->last_query(); exit;

		$inserted_id = $this->db->insert_id();

		$message = 2;

	// }

		echo($this->dr->GetDR($message, "Webinar successful Saved!", $var , $height = "0"));

 }

	/**

	* This function is displaying Webinar Details. 

	*
     
	* This function is accessable from the Zonedashboard. 

	* <br>

	* view page: <b>views/zone/webinar_details1</b>

	*/

	/**pending all**/public function webinar_details($zoneid=false,$fromzoneid=0){

		$data['common']=$this->common_first($zoneid,$fromzoneid); //echo "<pre>"; var_dump($data['common']['user']->id);exit;

		$data['usersid']=$data['common']['user']->id;

		$data['fromzoneid']=$fromzoneid;  

		$data['webinar_list'] = $this->announcements->show_webinar($data['common']['zoneid'],'','',$data['usersid']); //echo "<pre>"; var_dump($data['webinar_list']);exit;

		$data['right_container'] = $this->load->view("zone/webinar_details1", $data, true);

		$this->common($data);

	}

	/**pending all**/public function webinar_userslist($zoneid=false,$fromzoneid=0){

        $data['common']=$this->common_first($zoneid,$fromzoneid); //echo "<pre>"; var_dump($data['common']['user']->id);exit;

		$data['usersid']=$data['common']['user']->id;

		$data['fromzoneid']=$fromzoneid;  

		$data['webinar_lists'] = $this->announcements->webinar_userslist(); 

		$data['right_container'] = $this->load->view("zone/webinar_listofusers", $data, true);

		$this->common($data);

	} 

	/**

	* This function is displaying view more webinar details. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> fromzoneid</li>

	* <li> limit</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>show_webinar</b> (Model Name: announcements)</li>

	* </ol>

	* <br>

	* view page: <b>views/zone/more_webinar</b>

	*/

	/**pending all**/public function viewmorewebinar($fromzoneid=0,$lowerlimit=0,$upperlimit=0,$userid=false){//var_dump($userid);exit;

		$data = array();

		$data['webinar_list'] = $this->announcements->show_webinar($fromzoneid,$lowerlimit,$upperlimit,$userid);

		$data['countallannouncements']=count($data['webinar_list']);

		if($data['countallannouncements']<1){		

			$data['countallannouncements'] = 0;		

		}

		$lowerlimit=$lowerlimit+5;				

		$limit=$lowerlimit.','.$upperlimit;	

		$result = $this->load->view("zone/more_webinar",$data, true);

		echo($this->dr->GetDR($data['countallannouncements'],$limit,$result,"0"));

	}

	/**

	* This function is updating webinar details view. 

	*

	*/

	// /**pending all**/public function edit_webinar($zoneid=false,$webinar_id = ''){ //pending
	/**pending all**/public function edit_webinar(){ //pending

		$data['common']=$this->common_first($zoneid);

		// newly added

		$data['getall_webinar']=$this->announcements->getall_webinar_info($zoneid,$webinar_id); 

		$data['right_container'] = $this->load->view("zone/edit_webinar", $data, true);

		$this->common($data);

	}

	/**

	* This function is updating webinar details. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> zoneid</li>

	* <li> webinar id</li>

	* <li> other details from view page</li>

	* </ol>

	* After getting all the  parameters from the view page, these values passes through the function in related model.

	* <br>

	* <ol>

	* table: webinar_information</b>

	*/

	/**pending all**/public function update_webinar_link(){
 
		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';	

		 $status =  $_REQUEST['status'] ;

		$webinar_id = !empty($_REQUEST['webinar_id']) ? $_REQUEST['webinar_id'] : '';

		$webinar_link=!empty($_REQUEST['webinar_link']) ? $_REQUEST['webinar_link'] : '';

		$description=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';

		$start_time=!empty($_REQUEST['ad_startdatetime']) ? $_REQUEST['ad_startdatetime'] : '';

		$end_time=!empty($_REQUEST['ad_stopdatetime']) ? $_REQUEST['ad_stopdatetime'] : '';


		$room_type=!empty($_REQUEST['room_type']) ? $_REQUEST['room_type'] : '';

		$desImage=!empty($_REQUEST['desImage']) ? $_REQUEST['desImage'] : '';

		$totalpeople=!empty($_REQUEST['totalpeople']) ? $_REQUEST['totalpeople'] : '';

		$descrirecordinglinkption=!empty($_REQUEST['recordinglink']) ? $_REQUEST['recordinglink'] : '';

		$price=!empty($_REQUEST['price']) ? $_REQUEST['price'] : '';

		$pemail=!empty($_REQUEST['pemail']) ? $_REQUEST['pemail'] : '';

		$category=!empty($_REQUEST['main_cat_selected']) ? $_REQUEST['main_cat_selected'] : '';

		$subcategory=!empty($_REQUEST['main_subcat_selected']) ? $_REQUEST['main_subcat_selected'] : '';



		$current_time = time();

		 $sql_update= "UPDATE webinar_information SET link='".$webinar_link."',description ='".$description."',status =".$status.",start_time='".$start_time."',end_time='".$end_time."' ,timestamp=".$current_time."  , room_type='".$room_type."' ,webinarImage='".$desImage." ',totalpeople='".$totalpeople."' ,recording_link='".$descrirecordinglinkption." ' , paypal_id = '".$pemail."', price = '".$price."'  , sub_category = '".$subcategory."', category  = '".$category."'       WHERE zoneid=".$zoneid." AND id=".$webinar_id;

		$query = $this->db->query($sql_update);

		echo($this->dr->GetDR("","success","","0"));		

	}

	/**

	* This function is updating delete webinar. 

	*

	* This function is accessable from the Zonedashboard. 

	* <br>

	* table: webinar_information</b>

	*/

	function delete_webinar(){

		$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

		$zoneid = $_REQUEST['zoneid'];

		$sql_delete = "DELETE FROM `webinar_information` WHERE zoneid=".$zoneid." AND id=".$id;

		$query = $this->db->query($sql_delete);

		echo($this->dr->GetDR($id,"", "success", "0"));

    }

########################################################### Webinar Information close  ##########################################################





########################################################### Export Business Part Start ##########################################################

	/**

	* This function is not used in new code.

	*/

	/**pending all**/public function exportbusiness($zoneid=false,$fromzoneid=0){ 			

		$data['common']=$this->common_first($zoneid,$fromzoneid);

		$data['zoneid']=$data['common']['zoneid'] ;		

		$data['right_container'] = $this->load->view("zone/export_business", $data, true); 

		$this->common($data);			

	}

##########################################################  Export Business Part End ##############################################################



#########################################################   Grocery Coupon Banner Start    ##############################################################

 

 function coupon_info($zoneid=false,$fromzoneid=0){

	$data['common']=$this->common_first($zoneid,$fromzoneid);

	$data['zoneid'] = $data['common']['zoneid'] ;	

	$data['create_list'] = $this->announcements->create_coupon($data['zoneid']);	

	$data['right_container'] = $this->load->view("zone/coupon_info", $data, true); 

	$this->common($data);

 }

 

 function save_coupon_info(){//var_dump($_REQUEST);exit;

 

     $zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

     $coupon_link=!empty($_REQUEST['coupon_link']) ? $_REQUEST['coupon_link'] : '' ;

     //$coupon_description=!empty($_REQUEST['coupon_description']) ? $_REQUEST['coupon_description'] : '' ;

	 $coupon= "UPDATE zone_preferences SET coupon_link='".$coupon_link."' WHERE zoneid=".$zoneid;

	 $query = $this->db->query($coupon);

	 echo($this->dr->GetDR("The Acknowledgement ", "The save was successful", $var , $height = "0"));

 }

 function coupon_view($zoneid,$fromzoneid){

	    $data['common']=$this->common_first($zoneid,$fromzoneid);

		$data['fromzoneid']=$fromzoneid;  

		$data['coupon_list'] = $this->announcements->show_coupon($data['common']['zoneid']);//var_dump($data['coupon_list']);exit;

		$data['right_container'] = $this->load->view("zone/coupon_view", $data, true);

		$this->common($data);

 }

 function more_coupon($fromzoneid=0){

		$data = array();

		$data['coupon_list'] = $this->announcements->show_coupon($fromzoneid,$lowerlimit,$upperlimit);

		$data['countallannouncements']=count($data['coupon_list']);

		if($data['countallannouncements']<1){		

			$data['countallannouncements'] = 0;		

		}

		$lowerlimit=$lowerlimit+5;				

		$limit=$lowerlimit.','.$upperlimit;	

		$result = $this->load->view("zone/more_coupon",$data, true);

		echo($this->dr->GetDR($data['countallannouncements'],$limit,$result,"0"));

	}

	// /**pending all**/public function Editcoupon($zoneid=false,$webinar_id){ // pending
	/**pending all**/public function Editcoupon(){

		$data['common']=$this->common_first($zoneid);

		// newly added

		$data['getall_coupon']=$this->announcements->edit_coupon($zoneid,$webinar_id); 

		$data['right_container'] = $this->load->view("zone/edit_coupon", $data, true);

		$this->common($data);

	}

	function update_coupon_link(){//var_dump($_REQUEST);exit;

		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';	

		$coupon_id = !empty($_REQUEST['coupon_id']) ? $_REQUEST['coupon_id'] : '';

		$coupon_link=!empty($_REQUEST['coupon_link']) ? $_REQUEST['coupon_link'] : '';

		$sql_update= "UPDATE zone_preferences SET coupon_link='".$coupon_link."' WHERE zoneid=".$zoneid." AND id=".$coupon_id;

		$query = $this->db->query($sql_update);

		echo($this->dr->GetDR("","success","","0"));		

	}

	function delete_coupon(){//var_dump($_REQUEST);exit;

	    $data = array();

		$coupon_id = empty($_REQUEST['coupon_id']) ? "-1" : $_REQUEST['coupon_id'];

		$zoneid = $_REQUEST['zoneid'];

		//$sql_delete = "DELETE  FROM zone_preferences WHERE coupon_link='$coupon_id'";

		//echo "DELETE  FROM zone_preferences WHERE coupon_link IN(SELECT coupon_link from zone_preferences WHERE coupon_link='$coupon_id')";exit;

		//$sql_delete = "DELETE  FROM zone_preferences WHERE coupon_link IN(SELECT coupon_link from zone_preferences WHERE coupon_link='$coupon_id')";

		$data['coupon_delete']=$this->announcements->delete_coupon($zoneid,$coupon_id);

		$data['coupon_list'] = $this->announcements->show_coupon($zoneid);//var_dump($data['coupon_list']);exit;

		

		/*$sql_delete = "UPDATE zone_preferences SET coupon_link=' ' WHERE zoneid=".$zoneid;

		$query = $this->db->query($sql_delete);*/

		$result = $this->load->view("zone/more_coupon",$data, true);

		echo($this->dr->GetDR("","", "success", "0"));

    }





#########################################################   Grocery Coupon Banner End    ##############################################################



    function phone_broadcasting($zoneid,$fromzoneid=0){

		$data['common']=$this->common_first($zoneid,$fromzoneid);

		$data['zoneid'] = $data['common']['zoneid'] ;	

		$data['create_list'] = $this->announcements->phone_broadcasting($data['zoneid']);

		$data['right_container'] = $this->load->view("zone/phone_broadcasting", $data, true); 

		$this->common($data);

	}



    function save_phone_link(){//var_dump($_REQUEST);exit;

		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

		$phone_link=!empty($_REQUEST['phone_link']) ? $_REQUEST['phone_link'] : '' ;

		//$coupon_description=!empty($_REQUEST['phone_description']) ? $_REQUEST['phone_description'] : '' ;

		$phone_broadcasting= "UPDATE zone_preferences SET phone_broadcasting='".$phone_link."' WHERE zoneid=".$zoneid;

		$query = $this->db->query($phone_broadcasting);

		echo($this->dr->GetDR("The Acknowledgement ", "The save was successful", $var , $height = "0"));

	}



   function phone_broadcasting_view($zoneid,$fromzoneid=0){//var_dump(11);exit;

	    $data['common']=$this->common_first($zoneid,$fromzoneid);

		$data['fromzoneid']=$fromzoneid;  

		$data['coupon_list'] = $this->announcements->show_phone_broadcasting_view($data['common']['zoneid']);//var_dump($data['coupon_list']);exit;

		$data['right_container'] = $this->load->view("zone/phone_broadcasting_sites", $data, true);

		$this->common($data);

	   

   }

   function more_phone_broadcasting_view($fromzoneid=0){

		$data = array();

		$data['coupon_list'] = $this->announcements->show_phone_broadcasting_view($fromzoneid,$lowerlimit,$upperlimit);

		$data['countallannouncements']=count($data['coupon_list']);

		if($data['countallannouncements']<1){		

			$data['countallannouncements'] = 0;		

		}

		$lowerlimit=$lowerlimit+5;				

		$limit=$lowerlimit.','.$upperlimit;	

		$result = $this->load->view("zone/more_phone_broadcasting",$data, true);

		echo($this->dr->GetDR($data['countallannouncements'],$limit,$result,"0"));

	}

	// /**pending all**/public function Editphone_broadcasting($zoneid=false,$webinar_id){
	/**pending all**/public function Editphone_broadcasting(){

		$data['common']=$this->common_first($zoneid);

		$data['getall_coupon']=$this->announcements->Editphone_broadcasting($zoneid,$webinar_id); 

		$data['right_container'] = $this->load->view("zone/Editphone_broadcasting", $data, true);

		$this->common($data);

	}

   function update_phone_broadcasting_link(){//var_dump($_REQUEST);exit;

		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';	

		$phone_id = !empty($_REQUEST['phone_id']) ? $_REQUEST['phone_id'] : '';

		$phone_link=!empty($_REQUEST['phone_link']) ? $_REQUEST['phone_link'] : '';

		$sql_update= "UPDATE zone_preferences SET phone_broadcasting='".$phone_link."' WHERE zoneid=".$zoneid." AND id=".$phone_id;

		$query = $this->db->query($sql_update);

		echo($this->dr->GetDR("","success","","0"));		

	}

	function deletephone_broadcasting(){//var_dump($_REQUEST);exit;

	    $data = array();

		$phone_id = empty($_REQUEST['phone_id']) ? "-1" : $_REQUEST['phone_id'];

		$zoneid = $_REQUEST['zoneid'];

		$data['coupon_delete']=$this->announcements->deletephone_broadcasting($zoneid,$phone_id);

		$data['coupon_list'] = $this->announcements->show_phone_broadcasting_view($zoneid);

		$result = $this->load->view("zone/more_phone_broadcasting",$data, true);

		echo($this->dr->GetDR("","", "success", "0"));

    }

	/**pending all**/public function check_login_password(){
		$zoneid = isset($_REQUEST['zoneid']) ?  $_REQUEST['zoneid'] : '';
		$password = isset($_REQUEST['popup_password']) ?  $_REQUEST['popup_password'] : '';
		$userid = $this->session->userdata('user_id');
		if($userid != ''){
			$encryptpassword = $this->ion_auth_model->encryptpassword($userid,$password);
			if($encryptpassword == true){
				echo($this->dr->GetDR("","", "success", "1"));
			}else{
				echo($this->dr->GetDR("","", "fail", "0"));
			}
		}
	}
	
	/**pending all**/public function residentuser($zoneid,$fromzoneid=0){
		$data['common']=$this->common_first($zoneid,$fromzoneid);
		$data['zoneid'] = $data['common']['zoneid'];
		$data['resident_list'] = $this->email_notice->show_user_details($data['common']['zoneid']);
		$data['right_container'] = $this->load->view("zone/residentuserdetails", $data, true);
		$this->common($data);
	}
	
	# + Bulk Email Page View	
	/**pending all**/public function bulkemail($zoneid=false,$fromzoneid=0){
		$data['common']=$this->common_first($zoneid,$fromzoneid);	
		$data['zoneid']=$data['common']['zoneid'];	
		$data['business_owner_bulk']=$this->business->get_businesses_owner_new($data['zoneid']);
		$data['templates'] = $this->load->view("zone/subpage/bulkemail/bulk_template", $data, true);
		$data['right_container'] = $this->load->view("zone/bulkemail", $data, true); 
		$this->common($data);
	}	
	
	# - Bulk Email Page View
	/**pending all**/public function get_business_bulk($zone_id,$bulk_email_select_value,$bulk_email_type_select_value){
		$data = array();
		$data['zone_id'] = $zone_id;
		$data['bulk_email_select_value']=$bulk_email_select_value;
		$data['bulk_email_type_select_value']=$bulk_email_type_select_value;
		$data['business_owner_bulk']=$this->business->get_businesses_owner_new($zone_id,$bulk_email_select_value,$bulk_email_type_select_value);
		$data["ajax"] = 'ajax';	
		$this->load->view("zone/subpage/bulkemail/bulk_template", $data);
		exit;
	}
	
	/**pending all**/public function sendallemails(){
		$userids = empty($_REQUEST['uid']) ? 0 : $_REQUEST['uid'];
		$sub = $_REQUEST['subject'];
		$msg = str_replace("\n","<br>",$_REQUEST['message']);
		$uid_arr=explode(',',$userids);
		
		$sql_u="SELECT group_concat(contactemail) contactemail FROM business WHERE business_owner_id IN(".$userids.")"; 
		$query_u1 = $this->db->query($sql_u);	
		$useremail=$query_u1->result_array();
		if(!empty($useremail)){
			$uemailid=$useremail[0]['contactemail']; 
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
		$message="Email send successfully ";
		echo($this->dr->GetDR("Successfully", $message, "", "0"));
	}
	
	/**pending all**/public function eventcalendar(){
		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '' ;	  
		$userid = $this->zone_model->get_userid($zoneid); 
 		echo($this->dr->GetDR($userid, "1", "", "0"));		
 	}
	
	/**pending all**/public function zonelocalstores($zoneid=false,$fromzoneid=0){ 	
		$data['common']=$this->common_first($zoneid,$fromzoneid);	
		$data['zone_id'] = $data['common']['zoneid'] ;	
		$data['right_container'] = $this->load->view("zone/localstores", $data, true); 
		$this->common($data);	
	}
	
	/**pending all**/public function viewalllocalstores(){
		$user = $this->ion_auth->user()->row();
		$uid = 0;
		if(!empty($user)){ $uid = $user->id;}
		$data = array();
		$data['uid'] = $uid;
		$zoneid = $_REQUEST['zoneid'];
		$data['local_stores']=$this->sales_zone->get_all_localstores($zoneid);
		$result = $this->load->view('zone/subpage/local_stores/localstoresdisplay', $data, true);		
		echo($this->dr->GetDR("","", $result, "0"));
	}
	
	/**pending all**/public function savelocalstore(){
		$store_name = $_REQUEST['store_name'];
		$store_link = $_REQUEST['store_link'];
		$store_status = $_REQUEST['store_status']; 
		$zoneid = $_REQUEST['zoneid'];		
		$timestamp = time();		
		$data=array();
		$data = array(
			'zone_id' => $zoneid,
			'store_name' => $store_name,
			'store_link' => $store_link,
			'timestamp' => $timestamp,
			'status' => $store_status
		);
		
		$this->db->insert('zone_local_stores', $data);
		$result = $zoneid;
		echo($this->dr->GetDR("","", $result, "0")); 
	}
	
	/**pending all**/public function deletelocalstore(){
		$storeid = $_REQUEST['storeid'];
		$zoneid = $_REQUEST['zoneid'];
		$user = $this->ion_auth->user()->row();
		$uid = 0;
		if(!empty($user)){ $uid = $user->id;}
		$data = array();
		$data['storeid'] = $storeid;
		$data['uid']=$uid;
		$data['delete_local_zone']=$this->sales_zone->delete_local_store($storeid);
		$data['local_stores']=$this->sales_zone->get_all_localstores($zoneid);
		echo($this->dr->GetDR($storeid,"","", "0"));
	}

	/**pending all**/public function editlocalstore(){
		$data['common']=$this->common_first($zoneid);
		$data['get_store_details']=$this->sales_zone->get_localstore_details_by_id($storeid); 
		$data['right_container'] = $this->load->view("zone/editlocalstore", $data, true);
		$this->common($data);
	}
	
	/**pending all**/public function updatelocalstore(){
		$store_name = $_REQUEST['store_name'];
		$store_link = $_REQUEST['store_link'];
		$store_status = $_REQUEST['store_status']; 
		$storeid = $_REQUEST['storeid'];
		$sql_update= "UPDATE zone_local_stores SET store_name = '".$store_name."', store_link ='".$store_link."', status =".$store_status." WHERE id=".$storeid."";
		$query = $this->db->query($sql_update);
		echo($this->dr->GetDR("","success","","0"));		
	}

	
	
	/**pending all**/public function zonerealestates($zoneid=false,$fromzoneid=0){ 	
		$data['common']=$this->common_first($zoneid,$fromzoneid);	
		$data['zone_id'] = $data['common']['zoneid'] ;	
		$data['right_container'] = $this->load->view("zone/realestates", $data, true); 
		$this->common($data);	
	}
	
	/**pending all**/public function viewallrealestates(){
		$user = $this->ion_auth->user()->row();
		$uid = 0;
		if(!empty($user)){ $uid = $user->id;}
		$data = array();
		$data['uid'] = $uid;
		$zoneid = $_REQUEST['zoneid'];
		$data['real_estates']=$this->sales_zone->get_all_realestates($zoneid);
		$result = $this->load->view('zone/subpage/real_estates/realestatesdisplay', $data, true);		
		echo($this->dr->GetDR("","", $result, "0"));
	}
	
	/**pending all**/public function saverealestate(){
		$real_estate_name = $_REQUEST['real_estate_name'];
		$real_estate_link = $_REQUEST['real_estate_link'];
		$real_estate_status = $_REQUEST['real_estate_status']; 
		$zoneid = $_REQUEST['zoneid'];		
		$timestamp = time();		
		$data=array();
		$data = array(
			'zone_id' => $zoneid,
			'real_estate_name' => $real_estate_name,
			'real_estate_link' => $real_estate_link,
			'timestamp' => $timestamp,
			'status' => $real_estate_status
		);
		
		$this->db->insert('zone_real_estates', $data);
		$result = $zoneid;
		echo($this->dr->GetDR("","", $result, "0")); 
	}
	
	/**pending all**/public function deleterealestate(){
		$realestateid = $_REQUEST['realestateid'];
		$zoneid = $_REQUEST['zoneid'];
		$user = $this->ion_auth->user()->row();
		$uid = 0;
		if(!empty($user)){ $uid = $user->id;}
		$data = array();
		$data['realestateid'] = $realestateid;
		$data['uid']=$uid;
		$data['delete_real_estate']=$this->sales_zone->delete_real_estate($realestateid);
		$data['real_estates']=$this->sales_zone->get_all_realestates($zoneid);
		echo($this->dr->GetDR($realestateid,"","", "0"));
	}
	
	/**pending all**/public function editrealestate(){
		$data['common']=$this->common_first($zoneid);
		$data['get_realestate_details']=$this->sales_zone->get_realestate_details_by_id($realestateid); 
		$data['right_container'] = $this->load->view("zone/editrealestate", $data, true);
		$this->common($data);
	}
	
	/**pending all**/public function updaterealestate(){
		$real_estate_name = $_REQUEST['real_estate_name'];
		$real_estate_link = $_REQUEST['real_estate_link'];
		$real_estate_status = $_REQUEST['real_estate_status']; 
		$realestateid = $_REQUEST['realestateid'];
		$sql_update= "UPDATE zone_real_estates SET real_estate_name = '".$real_estate_name."', real_estate_link ='".$real_estate_link."', status =".$real_estate_status." WHERE id=".$realestateid."";
		$query = $this->db->query($sql_update);
		echo($this->dr->GetDR("","success","","0"));		
	}
	
	/**pending all**/public function zoneautos($zoneid=false,$fromzoneid=0){ 	
		$data['common']=$this->common_first($zoneid,$fromzoneid);	
		$data['zone_id'] = $data['common']['zoneid'] ;	
		$data['right_container'] = $this->load->view("zone/autos", $data, true); 
		$this->common($data);	
	}
	
	/**pending all**/public function viewallautos(){
		$user = $this->ion_auth->user()->row();
		$uid = 0;
		if(!empty($user)){ $uid = $user->id;}
		$data = array();
		$data['uid'] = $uid;
		$zoneid = $_REQUEST['zoneid'];
		$data['autos']=$this->sales_zone->get_all_autos($zoneid);
		$result = $this->load->view('zone/subpage/autos/autosdisplay', $data, true);		
		echo($this->dr->GetDR("","", $result, "0"));
	}
	
	/**pending all**/public function saveautos(){
		$autos_name = $_REQUEST['autos_name'];
		$autos_link = $_REQUEST['autos_link'];
		$autos_status = $_REQUEST['autos_status']; 
		$zoneid = $_REQUEST['zoneid'];		
		$timestamp = time();		
		$data=array();
		$data = array(
			'zone_id' => $zoneid,
			'autos_name' => $autos_name,
			'autos_link' => $autos_link,
			'timestamp' => $timestamp,
			'status' => $autos_status
		);
		
		$this->db->insert('zone_autos', $data);
		$result = $zoneid;
		echo($this->dr->GetDR("","", $result, "0")); 
	}
	
	/**pending all**/public function deleteautos(){
		$autosid = $_REQUEST['autosid'];
		$zoneid = $_REQUEST['zoneid'];
		$user = $this->ion_auth->user()->row();
		$uid = 0;
		if(!empty($user)){ $uid = $user->id;}
		$data = array();
		$data['autosid'] = $autosid;
		$data['uid']=$uid;
		$data['delete_autos']=$this->sales_zone->delete_autos($autosid);
		$data['autos']=$this->sales_zone->get_all_autos($zoneid);
		echo($this->dr->GetDR($autosid,"","", "0"));
	}
	
	/**pending all**/public function editautos(){
		$data['common']=$this->common_first($zoneid);
		$data['get_autos_details']=$this->sales_zone->get_autos_details_by_id($autosid); 
		$data['right_container'] = $this->load->view("zone/editautos", $data, true);
		$this->common($data);
	}
	
	/**pending all**/public function updateautos(){
		$autos_name = $_REQUEST['autos_name'];
		$autos_link = $_REQUEST['autos_link'];
		$autos_status = $_REQUEST['autos_status']; 
		$autosid = $_REQUEST['autosid'];
		$sql_update= "UPDATE zone_autos SET autos_name = '".$autos_name."', autos_link ='".$autos_link."', status =".$autos_status." WHERE id=".$autosid."";
		$query = $this->db->query($sql_update);
		echo($this->dr->GetDR("","success","","0"));		
	}

	/**pending all**/public function sponsor_business($zoneid=false,$fromzoneid=0) {
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'];
		$data['right_container'] = $this->load->view("zone/sponsor_business.php", $data, true); 
		$this->common($data);
	}
	
	/**pending all**/public function get_all_sponsored_business_data() {
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$business_type=!empty($_REQUEST['business_type']) ? $_REQUEST['business_type'] : 0 ; 
		$business_type_by_category=!empty($_REQUEST['business_type_by_category']) ? $_REQUEST['business_type_by_category'] : '' ;
		$business_zone = 2;
		$charval_name=!empty($_REQUEST['bus_search_by_name']) ? $_REQUEST['bus_search_by_name'] : 'all';
		if($charval_name != ''){
			$charval_name = $this->remove_specialcharAndSpaces($charval_name) ;	// Override with removable value
		}
		$charval_alphabet=!empty($_REQUEST['bus_search_by_alphabet']) ? $_REQUEST['bus_search_by_alphabet'] : '-1';
		
		### check the search criteria
		if($charval_name=='all' && $charval_alphabet=='-1'){
			$charval='all';
		}else if($charval_name!='all' && $charval_alphabet=='-1'){
			$charval=$charval_name;
		}else if($charval_name=='all' && $charval_alphabet!='-1'){
			$charval=$charval_alphabet;
		}
		
		$lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0 ;
		$upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 10 ; 
		$limit=$lowerlimit_new.','.$upperlimit; 
		$all_sponsored_business_details = $this->zone_model->get_all_sponsored_business_information($zoneid);
		$data['total_content']=$all_sponsored_business_details;
		$result = $this->load->view('zone/subpage/view_sponsored_business',array('data'=>$all_sponsored_business_details),true);
		
		echo($this->dr->GetDR($data['total_content'],$limit, $result, "0"));
	}

	public function get_ordered_sponsored_business_data(){
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$business_type=!empty($_REQUEST['business_type']) ? $_REQUEST['business_type'] : 0 ; 
		$business_type_by_category=!empty($_REQUEST['business_type_by_category']) ? $_REQUEST['business_type_by_category'] : '' ;
		$business_zone = 2;
		$charval_name=!empty($_REQUEST['bus_search_by_name']) ? $_REQUEST['bus_search_by_name'] : 'all';
		if($charval_name != ''){
			$charval_name = $this->remove_specialcharAndSpaces($charval_name) ;	// Override with removable value
		}
		$charval_alphabet=!empty($_REQUEST['bus_search_by_alphabet']) ? $_REQUEST['bus_search_by_alphabet'] : '-1';
		
		### check the search criteria
		if($charval_name=='all' && $charval_alphabet=='-1'){
			$charval='all';
		}else if($charval_name!='all' && $charval_alphabet=='-1'){
			$charval=$charval_name;
		}else if($charval_name=='all' && $charval_alphabet!='-1'){
			$charval=$charval_alphabet;
		}
		
		$lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0 ;
		$upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 10 ; 
		$limit=$lowerlimit_new.','.$upperlimit; 
		$all_sponsored_business_details = $this->zone_model->get_ordered_sponsor_business($zoneid);
		
		$data['total_content']=$all_sponsored_business_details;
		$result = $this->load->view('zone/subpage/view_ordered_sponsored',array('data'=>$all_sponsored_business_details),true);
		echo($this->dr->GetDR($data['total_content'],$limit, $result, "0"));
	}
	
	public function get_ordered_sponsored_business_data_category_sort(){
 		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$catid =!empty($_REQUEST['catid']) ? $_REQUEST['catid'] : 0 ; 
		$business_type=!empty($_REQUEST['business_type']) ? $_REQUEST['business_type'] : 0 ; 
		$business_type_by_category=!empty($_REQUEST['business_type_by_category']) ? $_REQUEST['business_type_by_category'] : '' ;
		$business_zone = 2;
		$charval_name=!empty($_REQUEST['bus_search_by_name']) ? $_REQUEST['bus_search_by_name'] : 'all';
		if($charval_name != ''){
			$charval_name = $this->remove_specialcharAndSpaces($charval_name);	
		}
		$charval_alphabet=!empty($_REQUEST['bus_search_by_alphabet']) ? $_REQUEST['bus_search_by_alphabet'] : '-1';
		
		if($charval_name=='all' && $charval_alphabet=='-1'){
			$charval='all';
		}else if($charval_name!='all' && $charval_alphabet=='-1'){
			$charval=$charval_name;
		}else if($charval_name=='all' && $charval_alphabet!='-1'){
			$charval=$charval_alphabet;
		}
		$lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0 ;
		$upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 10 ;
		$lowerlimit_new=$lowerlimit+$upperlimit; 
		$limit=$lowerlimit_new.','.$upperlimit; 
    $all_sponsored_business_details = $this->Zone_model->get_ordered_sponsor_business_sort_category($zoneid , $catid);
		$data['total_content']=$all_sponsored_business_details;

		echo json_encode($all_sponsored_business_details);

 		// $result = $this->load->view('zone/subpage/view_ordered_sort',array('catid'=> $catid , 'data'=>$all_sponsored_business_details),true);
		// echo($this->dr->GetDR($data['total_content'],$limit, $result, "0"));
	}
	
	// display bussiness catgory sponsor posts 
 	/**pending all**/public function category_sort($zoneid=false,$fromzoneid=0){ 
		$zoneid = $_GET['zoneid'];
  		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$zoneid;	
		$data['cateid']=$_GET['catid'];	 
		$data['right_container'] = $this->load->view("zone/sort_zone_category.php", $data, true); 
		$this->common($data);
	}

   	 
	public function sponser_business_subcat_reorder(){
		$data['order']=$_POST['order'];
		$data['catid']=$_POST['catid'];
		$data['adid']=$_POST['adid'];
		$data['busiid']=$_POST['busiid'];
		$rearragr = $this->Zone_model->sort_business_data($data);
		echo json_encode($rearragr);
	}
	
	/**pending all**/public function resta_business_reorder(){
		$data['order']=$_POST['order'];
		$data['catid']=$_POST['catid'];
		$data['adid']=$_POST['adid'];
		$data['busiid']=$_POST['busiid'];
 		$rearragr=$this->zone_model->sort_restaurant_data($data);
		echo json_encode($rearragr);
	}
	
	/**pending all**/public function change_sponsored_business_status(){
		$business_id=$_POST['data_id'];
		$business_status=$_POST['data_update'];
		$result=$this->zone_model->update_sponsored_business_status($business_id,$business_status);
		echo json_encode($result);
	}

    // redirecting sponsored view to ordered_sponsored_details
	/**pending all**/public function ordered_sponsored_details($zoneid=false,$fromzoneid=0){
		$data['common']=$this->common_first($zoneid,$fromzoneid);
		$data['zoneid']=$data['common']['zoneid'];
		$data['right_container'] = $this->load->view("zone/sponsor_order_view.php", $data, true);
		$this->common($data);
	}

  	// redirecting snapdining view to snapdining_order_view
	/**pending all**/public function snap_dining_list($zoneid=false,$fromzoneid=0){
      	$data['content'] = $this->zone_model->getallsnapdingbusiness($zoneid);
      	$data['common']=$this->common_first($zoneid,$fromzoneid);
		$data['zoneid']=$data['common']['zoneid'];
		$data['right_container'] = $this->load->view("zone/snapdining_order_view.php", $data, true);
	    $this->common($data);
	}

	// displaying the list of all snapdining restaurant
	/**pending all**/public function getsnap_dining_list($zoneid=false,$fromzoneid=0){
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$business_type=!empty($_REQUEST['business_type']) ? $_REQUEST['business_type'] : 0 ; 
		$catid =!empty($_REQUEST['catid']) ? $_REQUEST['catid'] : 0 ; 
		$business_type_by_category=!empty($_REQUEST['business_type_by_category']) ? $_REQUEST['business_type_by_category'] : '' ;
		$business_zone = 2;
		$charval_name=!empty($_REQUEST['bus_search_by_name']) ? $_REQUEST['bus_search_by_name'] : 'all';
		
		if($charval_name != ''){
			$charval_name = $this->remove_specialcharAndSpaces($charval_name) ;	// Override with removable value
		}
		$charval_alphabet=!empty($_REQUEST['bus_search_by_alphabet']) ? $_REQUEST['bus_search_by_alphabet'] : '-1';
		
		### check the search criteria
		if($charval_name=='all' && $charval_alphabet=='-1'){
			$charval='all';
		}else if($charval_name!='all' && $charval_alphabet=='-1'){
			$charval=$charval_name;
		}else if($charval_name=='all' && $charval_alphabet!='-1'){
			$charval=$charval_alphabet;
		}
		
		$lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0 ;
		$upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 10 ; 
		$limit=$lowerlimit_new.','.$upperlimit; 
        $all_sponsored_business_details = $this->zone_model->getallsnapdingbusiness($zoneid);
  		$data['total_content']=$all_sponsored_business_details;
 		$result = $this->load->view('zone/subpage/view_order_bussiness',array( 'data'=>$all_sponsored_business_details),true);
		echo($this->dr->GetDR($data['total_content'],$limit, $result, "0"));
	}
	
	 public function sponser_business_reorder(){
		$data=$_POST['order'];
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
		$rearragr=$this->Zone_model->rearrange_business_data($data);
		if($zonesubuser != ''){
			$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Re Arrange Business',serialize($data));
		}
		echo json_encode($rearragr);
	}

	public function sponser_business_reorder_cat(){
		$data=$_POST['order'];
		$zone_id=$_POST['zone_id'];
		$subcat=$_POST['subcat'];
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
		$rearragr=$this->Zone_model->rearrange_business_data_cat($data,$zone_id,$subcat);
		if($zonesubuser != ''){
			$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Re Arrange Business categories',serialize($subcat));
		}
		echo json_encode($rearragr);
	}
	
	public function updatejotformcodes(){
		$form_type_id  = $_REQUEST['form_type_id'];
		$codes         = $_REQUEST['codes'];
		$zone_id       = $_REQUEST['zone_id'];
		$update_code_details = $this->Zone_model->update_jotformcode_data($form_type_id,$codes,$zone_id);
		echo json_encode($update_code_details);
	}

	/**pending all**/public function payment_list($zone_id,$fromzoneid=0) {
		$data['common']=$this->common_first($zone_id,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'];
		$data['details_payment_list'] = $this->zone_model->get_payment_details($zone_id);
		$data['right_container'] = $this->load->view("zone/payment_list", $data, true); 
		$this->common($data);
	}

	/**pending all**/public function zone_payment_business_for_cerificate($zone_id,$fromzoneid=0){
		$data['common'] = $this->common_first($zone_id,$fromzoneid);
		$data['zoneid'] = $data['common']['zoneid'];
		$data['details_certificate_payment_list'] = $this->zone_model->zone_payment_business($zone_id);
		$data['right_container'] = $this->load->view("zone/zone_business_payment_list",$data,true);
		$this->common($data);
	}

	/**pending all**/public function business_payment_certification($payer_id,$receiver_id,$amount,$payment_id){
		$data['common'] = $this->common_first($payer_id,0);
		$data['zone_id'] = $payer_id;
		$data['business_id'] = $receiver_id;
		$data['amount'] = $amount;
		$data['right_container'] = $this->load->view("zone/business_certification_payment_view",$data,true);
		$this->common($data);
	}

	/**pending all**/public function jot_form_view($receiver_id,$payer_id,$amount,$payment_module_id){
		$data['zone_id'] = $payer_id;
		$data['amount'] = $amount;
		$data['business_id'] = $receiver_id;
		$data['jotform_embed_code'] = $this->zone_model->get_jotform_code($receiver_id,$payment_module_id);
		$data['business_details'] = $this->zone_model->business_details_using_id($receiver_id);
		$this->load->view("zone/business_jotform",$data);
	}

	/**pending all**/public function pbooCreditPurchase($receiverId,$zoneId,$paymentModuleId) {
		$data['zone_id'] = $zoneId;
		$data['jotform_embed_code'] = $data['jotform_embed_code'] = $this->zone_model->get_jotform_code($receiverId,$paymentModuleId);
		$data["zone_name"] = $this->zone_model->get_zone_name($zoneId);
		$this->load->view("zone/pboo_credit_purchse",$data);
	}
	
	/**pending all**/public function paypalcreditipn() {
		if($_POST['payment_status'] == "Completed"){
			echo "<h4>Your Payment is successful.</h4>";
		}else if($_POST['payment_status'] == "Pending"){
			echo "<h4>Your Payment is Pending.</h4>";
		}
	}

	/**pending all**/public function paypalCreditPayment() {

		$zoneId = $_GET['zoneId'];

		$userId = $_GET['userId'];

		$item_name = $_POST['item_name'];



		$payment_currency = $_POST['mc_currency'];

		$txn_id = $_POST['txn_id'];

		$receiver_email = $_POST['receiver_email'];

		$receiver_id = $_POST['receiver_id'];

		$quantity = $_POST['quantity'];

		$num_cart_items = $_POST['num_cart_items'];

		$payment_date = $_POST['payment_date'];

		$first_name = $_POST['first_name'];

		$last_name = $_POST['last_name'];

		$payment_type = $_POST['payment_type'];

		$payment_status = $_POST['payment_status'];

		$payment_gross = $_POST['payment_gross'];

		$payment_fee = $_POST['payment_fee'];

		$mc_gross = $_POST['mc_gross'];

		$memo = $_POST['memo'];

		$payer_email = $_POST['payer_email'];

		$txn_type = $_POST['txn_type'];

		$payer_status = $_POST['payer_status'];

		$address_street = $_POST['address_street'];

		$address_city = $_POST['address_city'];

		$address_state = $_POST['address_state'];

		$address_zip = $_POST['address_zip'];

		$address_country = $_POST['address_country'];

		$address_status = $_POST['address_status'];

		$item_number = $_POST['item_number'];

		$tax = number_format($_POST['tax'],2,".",'');

		$option_name1 = $_POST['option_name1'];

		$option_selection1 = $_POST['option_selection1'];

		$option_name2 = $_POST['option_name2'];

		$option_selection2 = $_POST['option_selection2'];

		$for_auction = $_POST['for_auction'];

		$invoice = $_POST['invoice'];

		$custom = $_POST['custom'];

		$organization = $_POST['org_name'];

		$notify_version = $_POST['notify_version'];

		$verify_sign = $_POST['verify_sign'];

		$payer_business_name = $_POST['payer_business_name'];

		$payer_id =$_POST['payer_id'];

		$mc_currency = $_POST['mc_currency'];

		$mc_fee = number_format($_POST['mc_fee'],2,".",'');

		$exchange_rate = $_POST['exchange_rate'];

		$settle_currency  = $_POST['settle_currency'];

		$parent_txn_id  = $_POST['parent_txn_id'];

		$pending_reason  = $_POST['pending_reason'];



		//$str = "Hello world. It's a beautiful day.";

		$organization = explode(",",$custom);



		$sql = "INSERT INTO payment(`payment_module`,`receiver_id`,`payer_id`,`amount`,`pboo_credit_status`,`time`) VALUES('1','$zoneId','$userId','$payment_gross','1',now())";

		$query = mysql_query($sql);





		$sql = "INSERT INTO transaction_info(`payment_method`,`user_id`,`gross_amount`,`vip_credits`,`debit_credit`,`credit_used_from`,`pay_time`,`item_name`,`payment_status`,`payment_date`,`mc_gross`,`mc_fee`,`txn_id`,`payer_email`) VALUES('paypal','$userId','$payment_gross','20','CREDIT','real',now(),'$item_name','$payment_status','$payment_date','$mc_gross','$mc_fee','$txn_id','$payer_email')";

		$query = mysql_query($sql);



		$sql = "INSERT INTO payment(`payment_module`,`receiver_id`,`payer_id`,`amount`,`pboo_credit_status`,`time`) VALUES('1','$zoneId','$userId','$payment_gross','1',now())";

		$query = mysql_query($sql);



		$sql="SELECT bonus_credit FROM tbl_member WHERE user_id='$userId'";

		$query = mysql_query($sql);

		$row = mysql_fetch_row($query);

		echo $row[0];



		$updatedCredit = $row[0] + $item_number;



		$sql = "UPDATE tbl_member SET `bonus_credit` = '$updatedCredit' WHERE `user_id`=".$userId;

		$query = mysql_query($sql);

		//print_r($_POST); exit; 



		foreach($organization as $val){

			$sql = "INSERT INTO organization_share_credit(`users_id`,`org_id`,`credit`) VALUES('$userId','$val','$item_number')";

			$query = mysql_query($sql);

		}

	}

	/**pending all**/public function organization_jot_form_view($receiver_id,$payer_id,$amount,$payment_module_id){
		$data['zone_id'] = $payer_id;
		$data['amount'] = $amount;
		$data['organizatifon_id'] = $receiver_id;
		$data['organization_details'] = $this->org_model->get_organization_by_id($receiver_id);
		$data['jotform_embed_code'] = $this->zone_model->get_jotform_code($receiver_id,$payment_module_id);
		$this->load->view("zone/organization_jotform_certification_payment",$data);
	}

	/**pending all**/public function certificattion_payment_thanku(){
		if(!empty($_POST['submission_id']) && !empty($_POST['formID']) && !empty($_POST['businessid'])){
			$data['payment_details_insertation'] = $this->zone_model->insert_business_certification_payment($_POST);
			$data['submission_id'] = $_POST['submission_id'] ? $_POST['submission_id'] : '';
			$data['form_id'] = $_POST['formID'] ? $_POST['formID'] : '';
			$data['businessid'] = $_POST['businessid'] ? $_POST['businessid'] : '';
			$data['amount'] = $_POST['amount'][2] ? $_POST['amount'][2] : '';
			$data['pageurl'] = $_POST['pageurl'] ? $_POST['pageurl'] : '';
			$this->load->view('zone/business_certificate_thanku',$data);
		}
	}

	/**pending all**/public function organization_payment_for_certificate($zone_id){
		$data['common'] = $this->common_first($zone_id,0);
		$data['zone_id'] = $zone_id;
		$data['organization_list'] = $this->zone_model->get_certificate_selected_organization_list($zone_id);
		$data['right_container'] = $this->load->view("zone/organization_payment_for_certificate",$data,true);
		$this->common($data);
	}
	
	public function update_paypal_accounting_setting(){
		$paypal_url  = $_REQUEST['paypal_url'];
		$braintree_merchantid  = $_REQUEST['braintree_merchantid'];
		$braintree_public_key  = $_REQUEST['braintree_public_key'];
		$braintree_private_key  = $_REQUEST['braintree_private_key'];
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
		$zone_id       = $_REQUEST['zone_id'];
		$check_exist_paypalid = $this->Zone_model->checkExistPaypalid($zone_id);
		if($zonesubuser != ''){
			$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Update paypal info',serialize(['paypal_url'=> $paypal_url,'zone_id'=> $zone_id]));
		}
		if(!empty($check_exist_paypalid)){
			$update_code_details = $this->Zone_model->update_paypalinfo($paypal_url,$zone_id,$braintree_merchantid,$braintree_public_key,$braintree_private_key);
			echo json_encode($update_code_details);
		}else{
			$ins_zone_paypalid = $this->Zone_model->save_paypalinfo($paypal_url,$zone_id,$braintree_merchantid,$braintree_public_key,$braintree_private_key);
			echo json_encode($ins_zone_paypalid);
		}
	}
	
	/**pending all**/public function organization_certification_payment($payer_id,$receiver_id,$amount,$payment_id){
		$data['common'] = $this->common_first($payer_id,0);
		$data['zone_id'] = $payer_id;
		$data['receiver_id'] = $receiver_id;
		$data['amount'] = $amount;
		$data['payment_id'] = $payment_id;
		$data['right_container'] = $this->load->view("zone/organization_jot_form_payment_certificate",$data,true);
		$this->common($data);
	}

	/**pending all**/public function organization_payment_success(){
		$data['formid'] = $_POST['formID'] ? $_POST['formID'] : 0;
		$data['submission_id'] = $_POST['submission_id'] ? $_POST['submission_id'] : 0;
		$receiver_id = $_POST['organizationid'] ? $_POST['organizationid'] : 0;
		$data['amount'] = $_POST['amount'][2] ? $_POST['amount'][2] : 0;
		$data['pageurl'] = $_POST['pageurl'] ? $_POST['pageurl'] : 0;
		$payer_id = 0;
		$user_payment_id = 0;
		
		if($data['pageurl']){
			$pageurl_array = explode('/', $data['pageurl']);
			$page_url_size = count($pageurl_array);
			$payer_id = $pageurl_array[$page_url_size-4];
			$user_payment_id = $pageurl_array[$page_url_size-1];
		}
		
		$auction_details =  '';
		$auction_id = 0;
		$payment_module_id = 5;
		$form_details = json_encode($_POST);
		
		$data['update_certificate_benificary_organization']=0;
		$data['last_inserted_id']=0;
		if($_POST['formID'] && $_POST['submission_id'] && $_POST['amount'][2]){
			$data['last_inserted_id'] = $this->zone_model->insert_payment($payment_module_id,$receiver_id,$payer_id,$data['amount'],$data['submission_id'],$data['formid'],$auction_details,$auction_id,$form_details);
			if($data['last_inserted_id']){
				$data['update_certificate_benificary_organization'] = $this->zone_model->update_certificate_organization($user_payment_id,$data['last_inserted_id'],$receiver_id);
			}
		}
		
		$data['payment_details_insertation'] = $data['last_inserted_id']*$data['update_certificate_benificary_organization'];
		$this->load->view('zone/business_certificate_thanku',$data); 
	}
	
	/**pending all**/public function buy_pekaboo_credits($zoneId){
		$data['receiverId'] = 0;
		$data['paymentModuleId'] = 9;
		$data['zoneId'] = $zoneId;
		$data['common'] = $this->common_first($zoneId,0);
		$data['right_container'] = $this->load->view('zone/purchase_credit', $data,true);
		$this->common($data);
	}

	/**pending all**/public function donationclaim($zoneId){
		$data['receiverId'] = 0;
		$data['paymentModuleId'] = 9;
		$data['zoneId'] = $zoneId;
		$data['common'] = $this->common_first($zoneId,0);
		$data['payment_creditprice'] = $this->business->donation_credit($zoneId);        
		$data['right_container'] = $this->load->view('zone/donationclaim', $data,true);
		$this->common($data);
	}
	
	/**pending all**/public function updateClaimfee(){
 		$params = array();
    	parse_str($_REQUEST['form'], $params);
  		$status = 0;
		$query = "SELECT percentage from publisher_fee where zone_id=".$_REQUEST['zoneID'];
		$percentage = $this->db->query($query);
		
		if($percentage > 0){ 
			$update_query="UPDATE publisher_fee SET percentage='".$params['price']."' WHERE zone_id=".$_REQUEST['zoneID'];		
			$this->db->query($update_query);
			$status = 0;
		}else{				
			$insert_query="INSERT INTO publisher_fee set percentage='".$params['price']."',zone_id='".$_REQUEST['zoneID']."'";
			$this->db->query($insert_query);	
			$status = 1;
		}
		return $status;
	}
	
	/**pending all**/public function thanku(){
		$session_array = $this->session->all_userdata();
		$data['payment_details'] = $_POST;
		$user_id = $session_array['session_zoneid']['sesuserid'];      
		$form_details = json_encode($_POST);
		$getReceiverId = "SELECT `user_id` FROM `users_groups` WHERE `group_id` = 3";
		$getReceiverIdResult = $this->db->query($getReceiverId);
		$receiverIdResult = $getReceiverIdResult ->row();
		$receiver_id = $receiverIdResult->user_id;
		
		if($_POST['submission_id'] && $_POST['price'][2]){
			$sql = "INSERT INTO payment(payment_module,receiver_id,payer_id,amount,submission_id,form_id,form_details,time) VALUES(9,".$_POST['zoneid'].",".$user_id.",".$_POST['price'][2].",'".$_POST['submission_id']."','".$_POST['formID']."','".$form_details."',NOW())";
			$result = $this->db->query($sql);
			
			$getCredits = "SELECT `peekabo_credits` FROM `users_credits` WHERE `payer_id` = ".$user_id." ORDER BY `id` DESC LIMIT 1 ";
			$getCreditsResult = $this->db->query($getCredits);
			$creditResult = $getCreditsResult ->row();    
			
			$updateZoneOwnerCredits = "UPDATE `zone_owner_credits` SET `credits` = (`credits` + ".$_POST['choosecredit'].") WHERE `user_id` = ".$user_id." ";
			$this->db->query($updateZoneOwnerCredits);
			
			//update credit history
			$updateCredits = "INSERT INTO `users_credits`(receiver_id,payer_id,peekabo_credits,payment_mode,submission_id,time) values(".$receiver_id.",".$user_id.",".$_POST['choosecredit'].",1,".$_POST['submission_id'].",NOW())";
			$updateCreditResult = $this->db->query($updateCredits);
			$data['status'] = "success";
		}else{
			$data['status'] = "fail";
		}       
		
		$data['zoneId'] = $_POST['zoneid'];
		$data['common'] = $this->common_first($_POST['zoneid'],0);
		$data['right_container'] = $this->load->view("zone/thank_you",$data,true);
		$this->common($data);
	}
	
	/**pending all**/public function allBusiness($zoneid=false,$fromzoneid=0){
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'];
		$data['all_zone_business']= "1";
		$data['right_container'] = $this->load->view("zone/all_zone_business.php", $data, true); 
		$this->common($data);
	}

	/**pending all**/public function checkResCredits($zoneid=false,$fromzoneid=0){
		$query = $this->db->query('SELECT * FROM business');
		$count = $query->num_rows();
		$data['count'] = $count; 
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'];
		$data['all_zone_business']= "1";
		$data['right_container'] = $this->load->view("zone/checkResCredits.php", $data, true); 
		$this->common($data);
	}	

	/**pending all**/public function changeStatusBusinessads($zoneid=false,$fromzoneid=0){
		$data['common']=$this->common_first($zoneid,$fromzoneid);		
		$data['zoneid']=$data['common']['zoneid'];
		$data['all_zone_business']= "1";
		$data['right_container'] = $this->load->view("zone/statusbusiness_ads.php", $data, true); 
		$this->common($data);
	}
	
	/**pending all**/public function add_business_to_zone(){		
		$zoneId = $_REQUEST['zoneId'];
		$data = array();
		$flag = 0;		
		foreach($_REQUEST['businessid'] as $val){
			$sql = "SELECT * FROM ads_setting_preferences WHERE settingszoneid = $zoneId AND businessid =".$val;
			$query = $this->db->query($sql);
			$num = $query->num_rows();
			if($num == 0){
				$sql = "SELECT * FROM ads_setting_preferences WHERE businessid =".$val;
				$query = $this->db->query($sql);
				$businessData = $query->result();		
				foreach($businessData as $row){			
					$data = array(
						'businessid' => $val,
						'settingszoneid' => $zoneId,
						'isdefault' => $row->isdefault,
						'approval' => 3,
						'type' => $row->type,
						'paymenttype' => 0,
						'websitevisibility' => $row->websitevisibility,
						'emailvisibility' => $row->emailvisibility,
						'isverified_businessowner' => $row->isverified_businessowner,
						'is_duplicate' => $row->is_duplicate,
						'remaining_trial_period' => $row->remaining_trial_period,
						'statuschangingtimestamp' => $row->statuschangingtimestamp
					); 
				}
				
				if($this->db->insert('ads_setting_preferences', $data)){
					$flag = 1;
				}					
			}			
		}	 
		echo($this->dr->GetDR('','', 1, "0"));		
	}
	
	/**pending all**/public function delete_business_from_zone(){		
		$zoneId = $_REQUEST['zoneId'];
		foreach($_REQUEST['businessid'] as $val){
			$deleteZone = "delete from ads_setting_preferences WHERE settingszoneid = $zoneId AND businessid =".$val;			
			$this->db->query($deleteZone);
		}
		echo($this->dr->GetDR('','', 1, "0"));
	}
	
	/**pending all**/public function reseller_dashboard($zone_id){
		$data['common'] = $this->common_first($zone_id,0);
		$data['zoneId'] = $zone_id;
		$username = $this->zone_model->get_username($data['zoneId']);
		$data['username'] = $username;		
		$data['right_container'] = $this->load->view("zone/reseller_dashboard",$data,true);
		$this->common($data);
	}

	public function refer_generate(){
	 
		$type = $_REQUEST['type']?$_REQUEST['type']:'';
		$email = $_REQUEST['email']?$_REQUEST['email']:'';
		$code = $_REQUEST['code']?$_REQUEST['code']:'';
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
		if(trim($type) == 'link_refer_mail'){
		 
			$fromemail="donotreply@hgd.deals";
			$subject = 'Did you sign up yet for this new service?';
			$message = '<div style="color:#000;background: #fff;width: 70%;margin: 50px auto;padding: 11px;border: 1px solid #ccc;font-size: 14px;line-height: 26px;box-shadow: 0px 1px 11px rgb(111 110 122 / 52%);"><div style="text-align: center;background: #f2f2f2;padding: 17px;margin-bottom: 20px"><img style="width: 240px;" src="'.base_url().'/assets/directory/images/logo-green.png"/></div><p>Really interesting new local savings directory to save money quickly and easily.  You also get timely emergency and general info from the municipality staff.</p>
				<p>You signup and decide which local nonprofit org you want to benefit. The nonprofits see who selected them. The saving directory enables all our local businesses free promotion of deals, only if businesses give really good deals.</p>

				<p>You pay the business directly the substantially discounted price whenever you go there. No expiration. It’s not like these other deals where you pay upfront for the entire dinner-- then forget to use it!</p>

				<p>You get these deals by just donating a small donation claiming fee—just a small part of the discount. So, you actually “save by giving” to your favorite non-profit—Win!-Win!</p>

				<p>The deals are good but the number of them to the really good restaurants is limited, so jump on it!<br>
				If you haven’t signed-up yet you can use the below link and you get a free deal w/o paying at all!</p>

				<div style="width: 100%;float: left;text-align:center;margin: 10px 0px;"><button style="background: #5c8a47;border: 1px solid #5c8a47;box-shadow: none;padding: 8px 30px;color: #fff;text-transform: uppercase;font-size: 14px;font-weight: bold;line-height: 20px;border-radius: 0;"><a style="text-decoration:none;color:#fff;" href="'.base_url().'?refer='.$code.'">Click here</a></button></div>

 				<p>You can also redeem the deal when you do an order for pick up or delivery. You simply apply the discount right online, or on this amazing new automated Food Order Call service using Amazon computer telephone service.</p>
				<p>Take Care!</p></div>';
				
			$res = $this->CommonController->sendMail($fromemail,$email,$subject,$message);
			if($zonesubuser != ''){
				$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'refer code mail',serialize(['email'=>$email,'msg'=>$message]));
			}
			return $res;
		}
	 
	}

	public function get_refer_link(){

		$user = $this->ion_auth->user()->row();	
		$msg = [];
 
		if($user != ''){
     		 
    		 $selectquesry = 'select refer_code_link from users  where username = "'.$user->username.'" and password ="'.$user->password.'"';    		 
    		$data = $this->CommonController->SelectRawquery($selectquesry,'resultArray');
     
    		if(@$data[0]['refer_code_link'] == ''){
    			 
				$str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
    			$code =  substr(str_shuffle($str_result), 0, 10);
    	 
			    $updateData=array("refer_code_link"=>$code);			 
				$dataID = $this->CommonController->updateData('users',$updateData, ['id' => $user->id]); 
  
				$msg = array('status' => 'success','msg' => 'updated','data' =>$code);
				echo json_encode($msg);
				 
			}else{
				$msg = array('status' => 'success','msg' => 'exists','data' =>@$data[0]['refer_code_link']);
				echo json_encode($msg);
			}
		}
	}

	public function change_theme(){
		$zoneid = $_REQUEST['zone_id'];
		$theme = $_REQUEST['theme'];
		$this->SalesZone->changeTheme($theme, $zoneid);
		echo json_encode(['msg' => 'Theme Color Updated Successfully','type' => 'success']);
	}	

	/**pending all**/public function export_report($zoneid=false,$fromzoneid=0){ 
     	$data['common']=$this->common_first($zoneid,$fromzoneid);		 	
		$data['zoneid']=$data['common']['zoneid'];		
		$data['right_container'] = $this->load->view("zone/peekaboo_export_report", $data, true); 
		$this->common($data);
	}

	/**pending all**/public function sendMail($from_email,$to_email,$subject,$message) {
		$this->load->library('email');
		$this->email->set_newline("\r\n");
 		$this->email->from($from_email);
        $this->email->to($to_email); 
        $this->email->subject($subject);
		$this->email->message($message);
		if($this->email->send()){
			echo $msg ='Email Send Successfully'; 
		}else{
			show_error($this->email->print_debugger());
		}
		
	}

	public function deal_reschedule(){
	   $current_date_time=date('Y-m-d');     
	   $end_date_time=date('Y-m-d H:i:s',strtotime('+30 days',strtotime($current_date_time))) . PHP_EOL;
	   $data = ['start_date' => $current_date_time,'end_date' => $end_date_time,'created_date' => $current_date_time,'status' => 'Live'];
	   $this->CommonController->updateData('tbl_deals',$data,['product_id' => $_REQUEST['data_to_use']]);
	   echo json_encode(['msg' => 'Re-Schedule Successfully','type' => 'success']);
	   die;
	}

	public function alldeal_reschedule(){
  	   // date_default_timezone_set('Pacific/Auckland');
	   $current_date_time=date('Y-m-d');     
	   $end_date_time=date('Y-m-d H:i:s',strtotime('+30 days',strtotime($current_date_time))) . PHP_EOL;
	   $zoneid = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:0;
	   $data = ['start_date' => $current_date_time,'end_date' => $end_date_time,'created_date' => $current_date_time,'status' => 'Live'];
	   $this->CommonController->updateData('tbl_deals',$data,['zone_id' => $zoneid]);
	   echo json_encode(['msg' => 'All Re-Schedule Successfully','type' => 'success']);
           die;
   	}

   	public function business_set(){
			$businessid=$_REQUEST['businessid'];
	  	$bussall = "SELECT * FROM business INNER JOIN users ON business.business_owner_id=users.id 
	  	INNER JOIN address ON address.id=business.addressid 
	  	WHERE business.id=$businessid";
	  	$address_data = $this->CommonController->SelectRawquery($bussall,'resultArray');
	  	$msg = ['data' => $address_data,'response' => 1];
   	 	echo json_encode($msg);
   	  die;
   	}

   	public function showdealdata(){
			$dealmetaid = $_REQUEST['dealmeta'];
			$busid = $_REQUEST['busid'];
			$pbcashqry="SELECT
				a.busId,e.userId,e.amountPrchased as purchasedprice,e.purchasedAt,e.user_type,a.id as metaid, a.totalamount as dealamounnt, a.discount as dealdiscount,a.amountPurchased as dealactual_price,a.dealId,b.start_date, b.end_date,b.created_date,b.auction_type,b.status,b.deal_title,b.deal_description,c.card_img,c.publisher_fee,c.seller_fee,d.email,d.first_name,d.last_name,d.Gender,d.phone,d.Address,c.numberofconsolation,b.current_price,b.buy_price_decrease_by
		  	FROM tbl_deals_purchased_meta as a 
 				INNER JOIN tbl_deals as b ON a.dealID=b.deal_id 
				INNER JOIN tbl_deals_products as c ON b.product_id=c.deal_product_id 
				INNER JOIN users as d ON d.id=a.userId
				INNER JOIN tbl_deals_purchased as e ON e.userId=a.userId
 				WHERE a.busId=".$busid." AND a.id=".$dealmetaid."";
			$purchasedealArr = $this->CommonController->SelectRawquery($pbcashqry,'resultArray');
			$msg = ['data' => $purchasedealArr,'response' => 1];
   	    echo json_encode($msg);
   	}

  public function get_organization(){
  	$orgid = isset($_REQUEST['orgid'])?$_REQUEST['orgid']:'';
  	$orguser = isset($_REQUEST['orguser'])?$_REQUEST['orguser']:'';
  	$zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:'';
  	$joinArr1[] = ['table' => 'users as c','link' => 'a.userid = c.id','type' => 'inner'];
   	$savedorganization = $this->CommonController->SelectJoinMulti('organization as a', $joinArr1,['a.zoneid'=>$zone_id,'a.approval'=>1,'a.id'=>$orgid],[],[],'a.id as orgid,a.name as orgname,c.id as userid,c.username,c.email,c.first_name,c.last_name,a.zoneid as zoneuserid,c.status,c.phone,c.Address','','','',[],'','');
   	echo json_encode($savedorganization);
  } 	

  public function update_organization(){
  	$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
  	$userData = array('email' => $_REQUEST['email'],'first_name' => $_REQUEST['first_name'],'last_name' => $_REQUEST['last_name'],'phone' => $_REQUEST['phone'],'Address' => $_REQUEST['Address']);
		$this->CommonController->updateData('users',$userData,['id' => $_REQUEST['userid']]);
		if($zonesubuser != ''){
			$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Update Organization',serialize($userData));
		}
		echo json_encode(['msg'=>'Organization Updated Successfully','type'=> 'success']);
	}

	public function checkexistsbid(){
		$today = date('m');
		if($today == 12){
			$newdate = 1;
		} else{
			$newdate = $today+1;
		}
		$this->CommonController->updateData('business_bid_detail',['status'=>'expired'],['month' => $today]);
		$business_id = isset($_REQUEST['business_id'])?$_REQUEST['business_id']:'';
		if($business_id!=''){
		 $pbbusiness_idcashqry="SELECT * FROM  business_bid_detail WHERE business_id=".$business_id." AND month=".$newdate." ";
		 $purchasedealArr = $this->CommonController->SelectRawquery($pbbusiness_idcashqry,'count');
		 echo json_encode($purchasedealArr);
  	}
	}

	public function getclaimfeereport(){
		$startdate = $_REQUEST['startdate'];
		$stopdate = $_REQUEST['stopdate'];
		$zoneid = $_REQUEST['zoneid'];
		$sql="SELECT a.*,b.start_date,b.end_date,b.created_date,b.deal_title,b.deal_description,b.status,c.card_img,d.email,d.first_name,d.last_name,d.phone,c.company_name,c.publisher_fee FROM tbl_deals_purchased_meta as a INNER JOIN tbl_deals as b ON a.dealID=b.deal_id INNER JOIN tbl_deals_products as c ON b.product_id=c.deal_product_id INNER JOIN users as d ON d.id=a.userId WHERE  a.zoneId='".$zoneid."' AND a.purchasedAt BETWEEN '".$startdate."' AND '".$stopdate."' GROUP BY b.deal_id";
		$data = $this->CommonController->SelectRawquery($sql,'resultArray');
		echo json_encode($data);
	}

	public function saveNonFavPer(){
		$percentage = isset($_REQUEST['percentage'])?$_REQUEST['percentage']:'';
		$loginuser = isset($_REQUEST['loginuser'])?$_REQUEST['loginuser']:'';
		$sql="SELECT Zone_ID from users WHERE id=".$loginuser."";
		$zoneid = $this->CommonController->SelectRawquery($sql,'row')->Zone_ID;
		
		$data = array('nonfavorgper' => $percentage);
		$this->CommonController->updateData('users',$data,['Zone_ID' => $zoneid]);
		echo json_encode(['msg' => 'Percentage updated successfully','type' => 'success']);
		die;
	}

	public function save_sub_zoneuser(){
		$msg = ['msg'=>'Something went wrong','type'=>'warning'];
		$subusereditid = isset($_REQUEST['subusereditid'])?$_REQUEST['subusereditid']:0;
		$fname = isset($_REQUEST['fname'])?$_REQUEST['fname']:'';
		$lname = isset($_REQUEST['lname'])?$_REQUEST['lname']:'';
		$email = isset($_REQUEST['email'])?$_REQUEST['email']:'';
		$username = isset($_REQUEST['username'])?$_REQUEST['username']:'';
		$password = isset($_REQUEST['password'])?$_REQUEST['password']:'';
		$zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:'';
		$data = isset($_REQUEST['data'])?$_REQUEST['data']:'';
		$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
		$businessid = isset($_REQUEST['businessid'])?$_REQUEST['businessid']:'';
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
		$zonesubuserzipcodes = isset($_REQUEST['zonesubuserzipcodes'])?$_REQUEST['zonesubuserzipcodes']:'';
		$zipcodesassign;
		if(count($zonesubuserzipcodes) > 0){
			$zipcodesassign = implode(',', $zonesubuserzipcodes);
		}
		if($subusereditid == 0){
			/*check phone number exists*/
			$usernameqry="SELECT * FROM zone_users WHERE username = '".$username."'";
			$usernameexists = $this->CommonController->SelectRawquery($usernameqry,'count');
			if($usernameexists > 0){
				echo json_encode(['msg'=>'UserName Already Exists','type'=>'warning']);
				die;
			}
			
			$userorgnoquery="SELECT * FROM zone_users WHERE email = '".$email."'";
			$userenoxists = $this->CommonController->SelectRawquery($userorgnoquery,'count');
			if($userenoxists > 0){
				echo json_encode(['msg'=>'User Email Already Exists, PLease Use Another Email Address','type'=>'warning']);
				die;
			}
			/*check phone number exists*/
		}
		if($type == 'business'){
			$sql="SELECT business_owner_id as name from business WHERE id=".$businessid."";
		}else{
			$sql="SELECT name from sales_zone WHERE id=".$zoneid."";
		}
		$name = $this->CommonController->SelectRawquery($sql,'row')->name;
		if(count($data) > 0){
			$data = serialize($data);
		}
		$dataArr=array(
			'firstname'=>$fname,
			'lastname'=>$lname,				 
			'email'=>$email,				 
			'username'=>$username,				 
			'password'=>$password,				 
			'zoneid'=>$zoneid,				 
			'zoneowner'=>$name,				 
			'data'=>$data,		 
			'type'=>$type,		 
			'zipcodesassign'=>$zipcodesassign		 
		);
		if($subusereditid > 0){
			$this->CommonController->updateData('zone_users',$dataArr,['id' => $subusereditid]);
			$msg = ['msg'=>'user Updated Successfully','type'=>'success'];
		}else{
			$res = $this->CommonController->InsertData('zone_users', $dataArr);
			$msg = ['msg'=>'user Created Successfully','type'=>'success'];
		}
		if($zonesubuser != ''){
			$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Update Create Zone Sub User',serialize($dataArr));
		}
		echo json_encode($msg);
	}

	public function save_commumethod(){
		$busid = isset($_REQUEST['busid'])?$_REQUEST['busid']:'';
		$method = isset($_REQUEST['method'])?$_REQUEST['method']:'';
		$this->CommonController->updateData('business',['comm_method'=>$method],['id' => $busid]);
		echo json_encode(['msg'=>'Method Saved Successfully','type'=>'success']);
	}

	public function save_blogumethod(){
		$status = isset($_REQUEST['status'])?$_REQUEST['status']:'';
		$blogid = isset($_REQUEST['blogid'])?$_REQUEST['blogid']:'';
		$this->CommonController->updateData('emailblog',['statx'=>$status],['id' => $blogid]);
		echo json_encode(['msg'=>'Status Changes Successfully','type'=>'success']);
	}

	public function chnage_approvaldpa(){
		$status = isset($_REQUEST['status'])?$_REQUEST['status']:'';
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
		$this->CommonController->updateData('business_deal_approval',['status'=>$status],['id' => $id]);
		echo json_encode(['msg'=>'Status Updated Successfully','type'=>'success']);
	}

	public function downloadcsvdpa(){
		$delimiter = ","; 
		$status = isset($_GET['status'])?$_GET['status']:'';
		$zoneid = isset($_GET['zoneid'])?$_GET['zoneid']:'';
		$filename = "dpaReport" . date('Y-m-d') . ".csv"; 
    $f = fopen('php://memory', 'w');
		if($status == 'all'){
			$pbcashqry="SELECT * FROM business_deal_approval";
		}else if($status == 'N'){
			$pbcashqry="SELECT * FROM business_deal_approval where status='N'";
		}else if($status == 'A'){
			$pbcashqry="SELECT * FROM business_deal_approval where status='A'";
		}else if($status == 'P'){
			$pbcashqry="SELECT * FROM business_deal_approval where status='P'";
		}
		$purchasedealArr = $this->CommonController->SelectRawquery($pbcashqry,'resultArray');
    $businessArr = $userArr2 = [];
    // print_r($businessArr);die('here');
    foreach($purchasedealArr as $k=> $v){
    	$businessArr[] = $v['businessId'];
    }
    if(count($businessArr) > 0){
    	$implodebus = implode(',',$businessArr);
			$userArr="SELECT a.id,b.email,b.address,b.phone FROM business as a INNER JOIN users as b ON a.business_owner_id=b.id WHERE  a.id IN (".$implodebus.")";
    	$userArr1 = $this->CommonController->SelectRawquery($userArr,'resultArray');
    	foreach($userArr1 as $k1=> $v1){
    		$userArr2[$v1['id']] = $v1;
    	}
    }else{	
    	return redirect()->to(base_url().'/Zonedashboard/zonedetail/'.$zoneid.'?page=dealsapprovaldpareport&d=E');
    }
		
		foreach ($purchasedealArr as $k3 => $v3) {
			$purchasedealArr[$k3]['email'] = isset($userArr2[$v3['businessId']])?$userArr2[$v3['businessId']]['email']:'';
			$purchasedealArr[$k3]['address'] = isset($userArr2[$v3['businessId']])?$userArr2[$v3['businessId']]['address']:'';
			$purchasedealArr[$k3]['phone'] = isset($userArr2[$v3['businessId']])?$userArr2[$v3['businessId']]['phone']:'';
			$purchasedealArr[$k3]['method'] = ($v3['via'] == '')?'Email':'Phone Call';
			if($v3['status'] == 'P'){$purchasedealArr[$k3]['status'] = 'Pending';}
			if($v3['status'] == 'A'){$purchasedealArr[$k3]['status'] = 'Active';}
			if($v3['status'] == 'N'){$purchasedealArr[$k3]['status'] = 'Hiding';}
			if($v['updated_at'] != '0000-00-00'){
				$updatedate = date('d-m-Y', strtotime($v['updated_at']));
			}else{
				$updatedate = '';
			}
		}
		$fields = array('Business Name','Business Owner Name','Email', 'Phone','Address','Send Method','Send Date', 'Status','Accept/Reject Date'); 
        fputcsv($f, $fields, $delimiter); 
        foreach ($purchasedealArr as $k4 => $row) {
            $lineData = array($row['businessname'], $row['userfname'].' '.$row['userlname'], $row['email'], $row['phone'], $row['address'], $row['method'],date('d-m-Y', strtotime($row['created_at'])),$row['status'],$updatedate);  
            fputcsv($f, $lineData, $delimiter);  
        }
       
        
        fseek($f, 0); 
        header('Content-Type: text/csv'); 
        header('Content-Disposition: attachment; filename="' . $filename . '";'); 
        fpassthru($f); 
        exit;
	}

	public function deletebuisness(){
		$busid = $_REQUEST['busid'];
		$userqry="SELECT a.id,b.email,b.address,b.phone,a.business_owner_id,b.username FROM business as a INNER JOIN users as b ON a.business_owner_id=b.id WHERE  a.id=".$busid;
    $data = $this->CommonController->SelectRawquery($userqry,'row'); 
		$this->CommonController->deleteData('ads_setting_preferences',['businessid' => $busid]);
		$this->CommonController->deleteData('business',['id' => $busid]);
		$this->CommonController->deleteData('ads',['business_id' => $busid]);
		$this->CommonController->deleteData('ads',['business_id' => $busid]);
		$this->CommonController->deleteData('users',['id' => $data->business_owner_id]);
		$this->CommonController->deleteData('tbl_member',['user_name' => $data->username]);
		//$this->CommonController->deleteData('business_deal_approval',['businessId' => $busid]);    //business_deal_approval data have deleted as well.
		echo json_encode(['msg'=>'Business Deleted Successfully','type'=>'success']);
	}

	public function bidpendingaction(){
		$busid = $_REQUEST['busid'];
		$action = $_REQUEST['action'];
		$busname = $_REQUEST['busname'];
		$zoneid = $_REQUEST['zoneid'];
		$user = $this->ionAuth->user()->row();
		$uid = $user->id;
		if($action == 'email'){
			$action = 1;
		}else{
			$action = 2;
		}
		$this->BusinessSearch->sendEmail($zoneid,$uid,$busid,$busname,'functioncall',$action,1);
	}
	
	public function rescheduleapprovedbus(){
		$busarr = [];
		$msg = array('msg'=>'Deals Not Created','type'=>'warning');
		$userqry="SELECT * FROM business_deal_approval WHERE  status='A'";
    $busArr = $this->CommonController->SelectRawquery($userqry);
    if(count($busArr) > 0){
    	foreach ($busArr as $k => $v) {
    		$busarr[] = $v['businessId'];
    	}
    }
		
		if(count($busarr) > 0){
    	$busimplode = implode(',', $busarr);
    	$sql_option1="select c.user_id from business as a INNER JOIN users as b ON a.business_owner_id=b.id INNER JOIN tbl_member as c ON c.user_name=b.username where  a.id IN (".$busimplode.")";
			$alluserid=$this->CommonController->SelectRawquery($sql_option1);
			if(count($alluserid) > 0){
				$todate = date('Y-m-d', strtotime("+30 days"));
				foreach ($alluserid as $k2 => $v2) {
					$this->CommonController->updateData('tbl_deals',['start_date'=>date('Y-m-d'),'end_date'=>$todate],['user_id' => $v2['user_id']]);
					$msg = array('msg'=>'Business Deals Re schedule Successfully','type'=>'success');
				}
			}
    }
    echo json_encode($msg);
	}

	public function GETSUBCATEGORY(){
		$catid = isset($_REQUEST['cattid'])?$_REQUEST['cattid']:'';
		$zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:'';
		$subcat = $this->Category_new_model->get_products_details($zone_id,$catid,'','subcatselect');
		$htmlArr = [];
		if(count($subcat) > 0){
			if($catid == 1){
				foreach ($subcat as $k => $v) {
					foreach ($v as $k1 => $v1) {
						foreach ($v1 as $k2 => $v2) {
							$sub_category=explode('#',$v2);
							$htmlArr[] = array(
								'rel'=>$sub_category[1],
								'id'=>$sub_category[1],
								'id0'=>$sub_category[0],
								'id2'=>$sub_category[2]
							);
						}
					}
				}
			}else{
				foreach ($subcat as $k => $v) {
					foreach ($v as $k1 => $v1) {
						if($k1 == '-100'){
							foreach ($v1 as $k2 => $v2) {
								$sub_category=explode('#',$v2);
								$htmlArr[] = array(
									'rel'=>$sub_category[1],
									'id'=>$sub_category[1],
									'id0'=>$sub_category[0],
									'id2'=>$sub_category[2]
								);
							}
						}else{
							$sub_category=explode('#',$v1);
							$htmlArr[] = array(
								'rel'=>$sub_category[1],
								'id'=>$sub_category[1],
								'id0'=>$sub_category[0],
								'id2'=>$sub_category[2]
							);
						}
					}
				}		
			}
			echo json_encode($htmlArr);
			die;
		}
	}

	public function checktestconnection(){
		$host=$_REQUEST['host'];
		$user=$_REQUEST['user'];
		$pass=$_REQUEST['pass'];
		$port=$_REQUEST['port'];
		$mbox = @imap_open("{".$host.":".$port."/imap/ssl/novalidate-cert}INBOX",$user,$pass);

		if(imap_errors()){
			echo 0;
		}else{
			echo 1;
		}
		die;
	}

	public function deltemailblgid(){
		$deltemailblgid=$_REQUEST['delid'];
		$serveremaildetaildelet =$this->CommonController->deleteData('serveremaildetail',['id' => $_REQUEST['delid']]);
		if($serveremaildetaildelet){
			echo 1;
		}
	}

	public function emailserversave(){
		$msg = ['msg'=>'Something Went Wrong','type'=>'warning'];
		$host = $_REQUEST['hostname'];
		$user = $_REQUEST['username'];
		$pass = $_REQUEST['password'];
		$port = $_REQUEST['port'];
		$zone = $_REQUEST['zoneemail'];
   
		if(count($host) > 0){
			foreach ($host as $k => $v) {
				if(isset($user[$k]) && isset($pass[$k]) && isset($port[$k])){
					
					$sql="SELECT *  FROM `serveremaildetail` where zone=".$zone." AND user='".$user[$k]."'";
					$result=$this->CommonController->SelectRawquery($sql,'resultArray');
					
					$arr =  array("host"=>$v, "user"=>$user[$k], "pass"=>$pass[$k], "port"=>$port[$k], "zone"=>$zone); 

					if(count($result) > 0){
						$this->CommonController->updateData('serveremaildetail',$arr,['zone' => $zone,'user'=>$user[$k]]);
						$msg = ['msg'=>'Detail Updated Successfully','type'=>'success'];
						
					}else{
	 					$insertedID = $this->CommonController->InsertData('serveremaildetail',$arr);	
						$msg = ['msg'=>'Detail Inserted Successfully','type'=>'success'];
					}	
				}
			}
		}
		
		echo json_encode($msg);
	}

	public function zonebusid_updt(){
		$product_id=$_REQUEST['produtid'];
		$sql="SELECT *  FROM `tbl_deals` where product_id=".$product_id." ";
					$result=$this->CommonController->SelectRawquery($sql,'resultArray');
					$product_id=$result['0']['product_id'];
					$selected_deal=$result['0']['selected_deal'];
					$user_id=$result['0']['user_id'];

					$sql1="SELECT *  FROM `deal_cashcert` where id=".$selected_deal." ";
					$results=$this->CommonController->SelectRawquery($sql1,'resultArray');
					$numberOfDeals=$results['0']['numberOfDeals'];

					$arr=array('numberofconsolation'=>$numberOfDeals);		
						if(count($arr) > 0){
						$this->CommonController->updateData('tbl_deals_products',$arr,['deal_product_id' => $product_id]);
						if($user_id){
							$sql2="SELECT *  FROM `tbl_member` where user_id=".$user_id." ";
					    $resultd=$this->CommonController->SelectRawquery($sql2,'resultArray');
					    $user_name=$resultd['0']['user_name'];
					    $zone_id = $resultd['0']['zone_id'];
					    $zone = $this->CommonController->SelectRawquery("SELECT *  FROM `sales_zone` where id=".$zone_id." ",'resultArray');
					    $deal_url = $zone['0']['subdomain']; 
					    $sql3="SELECT *  FROM `users` where username=".$user_name." ";
					    $resultdata=$this->CommonController->SelectRawquery($sql3,'resultArray');
					    $email_user=$resultdata['0']['email'];
					    $users_id=$resultdata['0']['id'];
					    $first_name=$resultdata['0']['first_name'];					    
					    $last_name=$resultdata['0']['last_name'];
					    $users_Zid=$resultdata['0']['Zone_ID'];
              $sql_busnam="SELECT *  FROM `business` where business_owner_id=".$users_id." ";
					    $result_buss=$this->CommonController->SelectRawquery($sql_busnam,'resultArray');
					    $buss_name=$result_buss['0']['name'];
							if($email_user!= ''){

              $sub ="Hey ".$first_name.' '.$last_name." Quick ". $buss_name." just approved a limited number of deals.";
							$body="<div style='color:#000;background: #fff;width: 70%;margin: 50px auto;padding: 11px;border: 1px solid #ccc;font-size: 14px;line-height: 26px;box-shadow: 0px 1px 11px rgb(111 110 122 / 52%);'><div style='text-align: center;background: #f2f2f2;padding: 17px;margin-bottom: 20px'><img style='width: 240px;' src='https://cdn.savingssites.com/logo-green.png'/></div><br><br> 

								".$buss_name." just added very limited number of deals… <br><br> 

								Login Link:<a href='".base_url()."'>".base_url()."</a><br>
		            Deal Link: <a href='https://".$deal_url.".savingssites.com'> https://".$deal_url.".savingssites.com</a><br>
	              <br>

								Everyone who clicked the Free $5 button is also being alerted that this business has just approved additional deals. So, act quickly and grab one of the cash certificate deals now, before they’re sold out!<br>  

								Thank you for helping support your favorite nonprofit!<br><br>  

								Also remember, your cash certificate purchases are enabling your municipality to email residents unlimited valuable updates, with none of your taxpayer money used! Additionally, your email address is not being subjected under the OPEN PUBLIC RECORDS ACT law to disclosure to anyone!<br>

								Please thank the business for providing deals which enables all these benefits!<br>   

								Enjoy the savings! <br>

								";
					 		 $send = $this->CommonController->SendMail('',$email_user,$sub,$body);

					 		 $msg = ['msg'=>'New Deal Arrives Successfully','type'=>'success'];
					     echo json_encode($msg);
							}else{
								 $msg = ['msg'=>'Email not found','type'=>'Failed'];
								 echo json_encode($msg);
							}
						}
					}			
	}

	    public function event_emailblog(){
	    	$zoneid = $this->CommonController->redirectToZone();
        $search = isset($_GET['search'])?$_GET['search']:'';
        $emailArr = [];
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';
        $zone_name = "";
        $passfrom= '';
        $businessid = '';
        //$zoneid = isset($zoneId) ? $zoneId:''; 
        $sql="SELECT *  FROM `serveremaildetail`";
        $server = $this->CommonController->SelectRawquery($sql);
        if(count($server) > 0){
            foreach ($server as $k => $v) {
                $image = '';
                $host = '{'.$v['host'].':'.$v['port'].'/imap/notls}INBOX';
                $user = $v['user'];
                $password = $v['pass'];
                $zone = $v['zone'];
                if($v['host'] == '' || $user == '' || $password == '' || $zone == ''){
                    continue;
                }
                $host = '{mail.nexusfleck.com:143/imap/notls}INBOX';
                $user = 'salman@nexusfleck.com';
                $password = 'aL)qQfequn2M';
                $conn = @imap_open($host, $user, $password);
                if (!$conn) {
                	echo"<pre>";print_r($conn);die;
      						continue;	
  							}
               	$mails = imap_search($conn, 'ALL');

                 // $messageNumber = 1;
                 // $structure = imap_fetchstructure($conn, $messageNumber); //commented because its extra
                
                $savePath = "./assets/SavingsUpload/emailemages";
                if($mails){
                    rsort($mails);
                    foreach ($mails as $email_number) {
                        $headers = imap_fetch_overview($conn, $email_number, 0);
                        $imagrhtml = $imageData = $message = imap_fetchbody($conn, $email_number, '1');
                        
                        preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $imageData, $urls);
                        $urls = $urls[1];
                        $image = isset($urls[0])?$urls[0]:'';
                        $subMessage = substr($message, 0, 150);
                        $finalMessage = trim(quoted_printable_decode($subMessage));
                        $emailArr[] = array(
                            'subject' => $headers[0]->subject,
                            'from' => $headers[0]->from,
                            'date' => $headers[0]->date,
                            'mainmessage' => $finalMessage,
                            'image' => $image,
                        );
                        
                        $sql1="select * from emailblog where subject='".$headers[0]->subject."' AND sender='".$headers[0]->from."'";
                        $result=$this->CommonController->SelectRawquery($sql1,'row');
                        if($result == ''){
                            $blogArr =  array("subject"=>$headers[0]->subject, "sender"=>$headers[0]->from, "date"=>$headers[0]->date,'bodydata'=> $imagrhtml,'image'=>$image,'zone'=>$zone); 
                            $this->CommonController->InsertData('emailblog',$blogArr);
                        }
                    }
                }
               $error = imap_errors();
								if (count($error) > 1 || $error[0] != 'SECURITY PROBLEM: insecure server advertised AUTH=PLAIN') {
								  // More than 1 error or not the expected error
								  var_dump($error);
								  throw new Exception('IMAP error detected');
								}
                imap_close($conn);
            }
        }
        $sql1="select * from emailblog where zone='".$zoneid."'";
        $result=$this->CommonController->SelectRawquery($sql1);
        $purchasedealArr = $result;
        return view('event_emailblog',array('theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zoneid' => $zoneid,'zone_id' => $zoneid,'passfrom' => $passfrom,'businessid' => $businessid,'zone_name'=>'','emailArr'=> $purchasedealArr,'search'=> $search));
    }

    public function editurlgrocerylink(){
    	$updatelink = isset($_REQUEST['updatelink'])?$_REQUEST['updatelink']:'';
    	$storeid = isset($_REQUEST['storeid'])?$_REQUEST['storeid']:'';
    	$this->CommonController->updateData('grocery_store',['website'=> $updatelink],['id'=> $storeid]);
    	echo json_encode(['msg'=>'Grocery Special Link Updated Successfully','type'=>'success']);
    	die;
    }

    public function deleteurlgrocerylink(){
    	$storeid = isset($_REQUEST['storeid'])?$_REQUEST['storeid']:'';
    	$this->CommonController->deleteData('grocery_store',['id' => $storeid]);
    	echo json_encode(['msg'=>'Grocery Special Deleted Successfully','type'=>'success']);
    	die;
    }



}