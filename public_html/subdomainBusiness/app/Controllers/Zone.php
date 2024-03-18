<?php
namespace App\Controllers;
use App\Models\Zips;
use App\Models\admin\Sales_zone;
use App\Models\banner\Banner_model;
use App\Models\admin\Ads_model;
use App\Models\zone\Zone_model;
use App\Models\Users;
use App\Models\admin\Business;
use App\Models\Organization_model;
use App\Models\Category_new_model;
use App\Libraries\IonAuth;
use App\Controllers\CommonController;
use App\Controllers\Emailnotice;
use Config\MyConfig;
#[\AllowDynamicProperties]
class Zone extends BaseController{
    public function __construct(){
        $this->Zips = new Zips();
        $this->cart = cart();
        $this->SalesZone = new Sales_zone();
        $this->Banner_model = new Banner_model();
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->Users = new Users();
        $this->Organization_model = new Organization_model();
        $this->Category_new_model = new Category_new_model();
        $this->Ads_model = new Ads_model();
        $this->Zone_model = new Zone_model();
        $this->Business = new Business();
        $this->CommonController = new CommonController();
        $this->Emailnotice = new Emailnotice();
        $this->ion_auth = $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->myconfig = new MyConfig;
    } 
	
	public function index($zone = false){  //pending  
		redirect(base_url(),'location', 301);
		$zoneId = empty($_REQUEST['zone']) ? 99 : $_REQUEST['zone'];
		if(!empty($zone)) { $zoneId = $zone;}
			$data = array();
			$zone= $this->zone_model->get_zone($zoneId);
			
			$data['announcements'] = $this->org_model->get_announcements_by_zone($zoneId,0,10); 
			$data['zone_owner'] = $this->ion_auth->user($zone->sales_rep_id)->row();
			$data['category_list'] = $this->category->get_category_subcategory($zoneId);
			$data['announcement_list'] = $this->announcements->get_announcements_for_all_athena($zoneId);
			$data['add_list'] = $this->ads->get_ads_for_all_athena($zoneId); 
			$data['zone'] = $this->sales_zone->get_zone($zoneId);
			$data['states'] = $this->states->get_all_states_zone();
			$data["firstName"] = "";
			$data['zone_id'] = $zoneId;
			$data["email"] = "";
			$data["admin"] = "";
		
		if ($this->ion_auth->logged_in()){
			$auser = $this->ion_auth->user()->row();
			if(!empty($auser)){
				$data["email"] = $auser->email;
				$data["firstName"] = $auser->first_name;
				$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";
				$data["admin_tier"] = $this->ion_auth->in_group(array( "Tier I", "Tier II")) ? "yes" : "";
			}
		}
		
		$this->load->view('new_page', $data);
	      }
	
	public function load($zone=false,$business=false,$adid=false){
		$time = 3600;
		$amazonurl = $this->myconfig->AWSimageurl;
		$usergiftemail =  '';
		$giftuserexists = 'no';
		$theme = "green";
		$page = 'Save Green';
		$page_title = 'Save Green';
		$business_theme = 'green';
		$zone = $this->CommonController->redirectToZone();
		
		$qry = "select * from sales_zone where id='".$zone."'";
		$dealuserzonedata = $this->CommonController->getStoreCache($qry,'row','loginzonename',$time);
 		$loginzonename = isset($dealuserzonedata->subdomainZone)?$dealuserzonedata->subdomainZone:'';

 		if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
  			$pagesidebar = 'https://'.$loginzonename.'.savingssites.loc/';
		}else{
			$pagesidebar = 'https://'.$loginzonename.'.savingssites.com/';
		}
		if($this->CommonController->getCookie('business_sstheme')){
			$theme = $this->CommonController->getCookie('business_sstheme');
			$page_title = $this->CommonController->getCookie('business_sstitle');
			$page_title = 'Save Green';
			$business_theme = 'green';
		}

		$url = $_SERVER['SERVER_NAME'];
        $parsedUrl = parse_url($url);
        $host = explode('.', $parsedUrl['path']);
        $subdomain = $host[0];
        $zonename = $subdomain;

        $sql = "SELECT * FROM sales_zone WHERE subdomainZone = '".$zonename."'";
        $urlseq = $this->CommonController->getStoreCache($sql,'row','zonebusinessname',$time);
		$zonebusinessname = $urlseq->subdomain;

		$this->CommonController->getAutoLogin();
		$seo_zone = $zone; 
		$refer_code = isset($_GET['refer'])?$_GET['refer']:'';
		$gifttoken = isset($_GET['token'])?$_GET['token']:'';
		if($gifttoken != ''){
			$giftuserqry = "SELECT * FROM tbl_deals_purchased WHERE userId='".$gifttoken."' AND certificate_verify=0 ";
			$usergiftArr = $this->CommonController->getStoreCache($giftuserqry,'row','usergiftemail',$time);
			$usergiftemail = $usergiftArr->certreciever;
			
			$giftuserexistqry = "SELECT * FROM users WHERE email='".$usergiftemail."'";
			$usergiftexistArr = $this->CommonController->getStoreCache($giftuserexistqry,'row','giftuserexists',$time);
			$giftuserexists = isset($usergiftexistArr->email)?$usergiftexistArr->email:'';	
		}
		if($giftuserexists != '' && $giftuserexists != 'no'){
			if($usergiftemail != ''){
				$this->Emailnotice->sendgiftdata($giftuserexists,$usergiftexistArr->id);
			}
		}
     	$cookie_name = "refer_code";
		$cookie_value = $refer_code;
		setcookie($cookie_name, $cookie_value, time() + (60 * 20), "/");
		$deal_title = $business;
		if($deal_title!=''){
			$query2 = "SELECT * FROM ads WHERE deal_title=".$deal_title."";
			$row = $this->CommonController->getStoreCache($query2,'row','zonepageiddealtitle',$time);
			$row->id;
			$row->deal_title;
		}
		if(isset($zone)){
			$zone = trim($zone);
		}else{
			$modified_url=base_url();	
			redirect($modified_url, 'location', 301);
		}
		
		if(!is_numeric($zone)){  
			$zone_details = $this->SalesZone->get_zone_by_seo_name(str_replace(' ','-',$zone),'zonepagegetzonebyseoname');
			$zoneid = $zone_details->id;
			
			if($zoneid == ''){
				$modified_url=base_url();
				redirect($modified_url, 'location', 301);
			}
			  
			$zonename = $zone_details->seo_zone_name;  
			$zone_name = str_replace('-',' ',$zonename);
			$display_zone_details = $this->SalesZone->get_zone($zoneid);
			$display_zone_name = $display_zone_details->name;
			$zone_logo = $display_zone_details->image_name;	
		}else{  
 			$zone_details = $this->SalesZone->get_zone($zone);
			$zoneid =$zone;			
			$zone_name=$zone_details->seo_zone_name;
			$zone_name=str_replace(' ','-',htmlentities(urldecode($zone_name)));
			$display_zone_name = $zone_details->name;
			$zone_logo = $zone_details->image_name;	
			
			if($this->request->uri->getSegment(1,0) == "zone" && is_numeric($zone)){
				if($this->request->uri->getSegment(2,0)==$zoneid){
					return redirect()->to(base_url().'/zone/'.$zone_name); 
				}
			}
		}
		/*empty variable*/
		$user_id = $email = $firstName = $lastName = $businessUser = $session_usertype = $session_session_normal_user_in_zone = $session_session_normal_user_type = $session_type = $session_type_id = $req_url = '';
		$header = 'zoneheader';
		/*empty variable*/
		if($this->ionAuth->loggedIn()){ 
			$auser = $this->ionAuth->user()->row();
 			if(!empty($auser)){ 
				$this->session->set('get_email',$auser->email);
				$user_id = $auser->user_id;
				$email = $auser->email; 
				$firstName = $auser->first_name;
				$lastName = $auser->last_name;
				$businessUser = $auser->username;
				
				//Cookies set as user_id
				$cookie = array(
					'name'   => 'user_id',
					'email'  => 'email',
					'value'  => $user_id,
					'expire' => time()+86500,
					'domain' => '',
					'path'   => '/',
					'prefix' => '',
				);
				set_cookie($cookie);
				
				$user_type1 = $this->CommonController->check_user_type($auser->user_id);
		  		$user_type = $user_type1[0]['group_id']; 
		  		$header = 'loginheader';
		  	}
		}

		//session data set
		if($this->session->get('session_usertype')!=''){
			$session_usertype_arr=$this->session->get('session_usertype');
			$session_usertype=$session_usertype_arr['usertype']; 
		}
		
		if($this->session->get('session_normal_user_in_zone')!=''){
			$session_normal_user_in_zone_arr=$this->session->get('session_normal_user_in_zone');

			 if(!empty($session_normal_user_in_zone_arr['sesuserzone'])){
				$session_session_normal_user_in_zone=$session_normal_user_in_zone_arr['sesuserzone'];
				$session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype']; 
			}
		}

		if($this->session->get('usersessiondata')!=''){ 			
			$session_type_arr=$this->session->get('usersessiondata');
			$session_type=$session_type_arr['usergrid'];
		}else if($this->session->get('session_normal_user_in_zone')!=''){
			$session_type_arr=$this->session->get('session_normal_user_in_zone');
			if(!empty($session_type_arr['sesusertype'])){
				$session_type=$session_type_arr['sesusertype']; 
			}
		}
		
		if($session_type==4){
			$session_type_id=$session_type_arr['userzoneid'];
			// $req_url=base_url().'dashboards/zone/'.$session_type_id;
			$req_url=base_url().'/Zonedashboard/zoneinformation';
		}else if($session_type==5){
			if($this->session->get('session_zoneid_from_bus')!=''){ 			
				$session_type_arr=$this->session->get('session_zoneid_from_bus');
				$session_type_id=$session_type_arr['busid'];
				$session_type=$session_type_arr['type'];
				
				if($session_type=='business'){
					$req_url=base_url().'dashboards/business/'.$session_type_id;
				}else if($session_type=='listed'){
					$req_url=base_url().'auth/listed_business_verification/'.$session_type_id;
				}
			}
		}else if($session_type==8){
			if($this->session->get('session_orgid')!=''){ 			
				$session_type_arr=$this->session->get('session_orgid');
				$session_type_id=$session_type_arr['sesorgid'];
				// $req_url=base_url().'dashboards/organization/'.$session_type_id;
				$req_url=base_url().'/organizationdashboard/'.$session_type_id."/organizationdetail";
			}
		}else if($session_type=='resident_user'){
			$session_type_id=$session_type_arr['sesuserzone'];
			// $req_url=base_url().'zone/load/'.$session_type_id;
			$req_url=base_url().'/my_account';
		}
 

		if(is_numeric($adid)){  
			$addealtitle = urldecode($ad_dealtitle);
			$fetch_id="SELECT * FROM ads WHERE deal_title='$addealtitle'"; 
			$ads_id=$this->db->query($fetch_id);
			$aid=$ads_id->row('id');
			$fetch_id="SELECT * FROM ads WHERE deal_title='$addealtitle'"; 
			$ads_id=$this->db->query($fetch_id);
			$aid=$ads_id->row('id');
			
			if(!empty($aid)){
				$meta_tag_details = $this->ion_auth->meta_tag_details($aid);
			} 
			
			if(!empty($meta_tag_details)){ 
				if($meta_tag_details[0]['deal_title']!=''){ 
					$data['business_name']=$meta_tag_details[0]['deal_title'];
					$data['bsname']=$meta_tag_details[0]['business_name'];
					$data['zone_name']=$zone_name;
					$data['business_id']=$meta_tag_details[0]['business_id'];
				}else{
					$data['business_name']=$meta_tag_details[0]['business_name'];
				}
				
				$ckeditor_img = '';
				preg_match( '@src="([^"]+)"@' , $meta_tag_details[0]['image'], $match );
				$image = array_pop($match); 

				if(!empty($image)){
					$ckeditor_img= $image; 
				}
				
				if($ckeditor_img != ''){  
					$data['meta_business_image'][0] = $ckeditor_img;
				}else{
					$data['meta_business_image'][0]="http://savingssites.com/assets/images/slides/slide-1_fb.jpg";
				}

				$description=$meta_tag_details[0]['description'];
				$data['description']=urldecode(strip_tags($description));  
			}	 
		}
		
		$_SESSION['ssZone'] = $zoneid;
		$zone= $this->Zone_model->get_zone($zoneid);
		
		$resultdata = isset($refferalcode[0])?$refferalcode[0]:[];
		$zone_pref_setting = $this->SalesZone->get_default_settings_in_zone($zoneid);
		$announcements = $this->Organization_model->get_announcements_by_zone($zoneid,0,10); 
		$zone_owner = (object)$this->Users->get_user_details($zone['sales_rep_id']);
		$active_banner_mobile 	= $this->Banner_model->active_banner_desktopmobile($zoneid,'','1','2');	
		$active_banner_desktop 	= $this->Banner_model->active_banner_desktopmobile($zoneid,'','1','1');
		$data['firstzoneimage'] = $this->Banner_model->active_banner_slider_desktopmobile($zoneid,'','1','1');
		$data['displayoffer'] = $this->Ads_model->get_display_offer_in_zonepage($zoneid);
		$data['get_zone_cms'] = $this->Category_new_model->checkExistcms($zoneid);
		$data['get_local_store'] = $this->Category_new_model->getLocalStore($zoneid);
		$check_zone_logo = $this->Banner_model->checkZonelogo($zoneid);	
		$zone_name = $display_zone_name; 
		$zone_logo = $zone_logo; 
		$session_usertype = $session_usertype; 
		$session_session_normal_user_in_zone = $session_session_normal_user_in_zone;
		$session_session_normal_user_type = $session_session_normal_user_type;
		$session_session_type = $session_type;
		$session_session_type_id = $session_type_id;
		$req_url = $req_url;
		$refer_code = $refer_code;
		$adid = $adid; 
		$deal_title = $deal_title;


        $organizationsql1 = "SELECT name,id FROM organization WHERE zoneid=".$zoneid." AND approval= 1 AND type IN (0)";
        $nonprofitorg = $this->CommonController->getStoreCache($organizationsql1,'resultArray','zonepagenonprofitorg',$time);

        $organizationsql2 = "SELECT name,id FROM organization WHERE zoneid=".$zoneid." AND approval= 1 AND type IN (4,2)";
        $schoolorg = $this->CommonController->getStoreCache($organizationsql2,'resultArray','zonepageschoolorg',$time);
		
		$organizationsql3 = "SELECT name,id FROM organization WHERE zoneid=".$zoneid." AND approval= 1 AND type IN (1)";
        $municipalityorg = $this->CommonController->getStoreCache($organizationsql3,'resultArray','zonepagemunicipalityorg',$time);
		
		if($this->CommonController->getCookie('business_sstheme')){
			$business_theme = $this->CommonController->getCookie('business_sstheme');
		}
		 	
		$footer = 'zonefooter';	
        $host = $_SERVER['HTTP_HOST'];
        $explodehost = explode('.', $host);

        if(in_array('loc', $explodehost)){
            $dealurl = 'https://'.$zonebusinessname.'.savingssites.loc';
        }else if(in_array('qa', $explodehost)){
            $dealurl = 'https://'.$zonebusinessname.'.qa.savingssites.com';
        }else{
            $dealurl = 'https://'.$zonebusinessname.'.savingssites.com';
        } 
		
		$deal_cert_qry = "Select * from deal_cashcert Order by id ASC";
    	$deal_cert_Arr = $this->CommonController->SelectRawquery($deal_cert_qry,'result');
		return view('directory',array('zone_id' => $zoneid,'zoneid' => $zoneid,'zone_name' => $zone_name,'user_id' => $user_id,'email' => $email,'firstName' => $firstName,'lastName' => $lastName,'businessUser' => $businessUser,'page' => $page,'page_title' => $page_title,'zone_logo' => $zone_logo,'resultdata' => $resultdata,'theme' => $theme,'header' => $header,'active_banner_desktop' => $active_banner_desktop,'zone_pref_setting' => $zone_pref_setting,'footer' => $footer,'refer_code' => $refer_code,'seo_zone_name' => $seo_zone,'session_session_normal_user_type' => $session_session_normal_user_type,'zone_owner'=> $zone_owner,'announcements'=>$announcements,'check_zone_logo'=>$check_zone_logo,'active_banner_mobile'=> $active_banner_mobile,'nonprofitorg'=> $nonprofitorg,'schoolorg'=> $schoolorg,'municipalityorg'=> $municipalityorg,'usergiftemail'=> $usergiftemail,'giftuserexists'=> $giftuserexists,'zonebusinessname'=> $zonebusinessname, 'req_url'=>$req_url, 'business_theme'=>$business_theme,'amazonurl'=>$amazonurl,'pagesidebar'=>$pagesidebar,'dealurl'=>$dealurl,'deal_cert_Arr'=>$deal_cert_Arr));
	}
	
	public function load_old($zone=false,$business=false,$adid=false,$s=''){   //pending
		if(isset($zone)){
			$zone = trim($zone);
		}
		$zone=!empty($zone) ? htmlentities(urldecode($zone)) : 0;
 		$data = array();
		if(strpos(current_url(),'zone/load/')!=false){ 
			if($this->uri->total_segments()==4)			
				$modified_url=base_url("zone/".$this->uri->segment(3, 0)."/business/".$this->uri->slash_segment(4,'leading'));
			else if($this->uri->total_segments()==3)	
				$modified_url=base_url("zone/".$this->uri->segment(3, 0)."/");
			else if($this->uri->total_segments()==2)	
				$modified_url=base_url();	
			redirect($modified_url, 'location', 301);
		}
		
		$link_path = $this->config->item('link_path'); 	
		if($link_path==''){ 
			if($this->uri->total_segments()==4)
				$data['link_path']= "../../../../";
			else if($this->uri->total_segments()==3)
				$data['link_path']= "../../../"	;
			else if($this->uri->total_segments()==2)
				$data['link_path']= "../../";		
		}else{
			$data['link_path']= $link_path ; 
		}

		if(!is_numeric($zone)){ 
			$zone_details = $this->sales_zone->get_zone_by_seo_name(str_replace(' ','-',$zone)); 
			$zoneId =$zone_details->id;
			$zone_name=$zone_details->seo_zone_name; 
			if($zoneId!=''){
				$count_num = $this->sales_zone->get_bcs_count_for_zone($zoneId);
				$data['bcs_count'] = number_format($count_num);	
			}else{
				$modified_url=base_url();	
				redirect($modified_url, 'location', 301);
			}
		}else{ 
			$zone_details = $this->sales_zone->get_zone($zone);
			$zoneId =$zone;
			$zone_name=$zone_details->seo_zone_name;
			$zone_name=str_replace(' ','-',htmlentities(urldecode($zone_name)));
			if($this->uri->segment(1,0)=="zone" && is_numeric($zone)){
				if($this->uri->segment(2,0)==$zoneId){
					$modified_url=str_replace('zone/'.$zoneId,'zone/'.$zone_name,current_url());
					redirect($modified_url, 'location', 301);
				}
			}
		}
		
		if(!empty($adid)){	
			if(is_numeric($adid)){
			//  ++ edited by suman for numeric deal_title
				$data['deal_title']=preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ', '-',htmlentities(urldecode($adid))));	
				$data['deal_title_ad_id']=$adid; 
				$data['deal_title_type']="insert_deal_title";
			}else{	
				$data['deal_title']=preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ', '-',htmlentities(urldecode($adid))));	
			}
		}
		
		$data['adid']=$adid;
		//session data set
		if($this->session->userdata('session_usertype')!=''){
			$session_usertype_arr=$this->session->userdata('session_usertype');
			$session_usertype=$session_usertype_arr['usertype']; 
		}else{
			$session_usertype='';
		}
		
		if($this->session->userdata('session_normal_user_in_zone')!=''){
			$session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_session_normal_user_in_zone=$session_normal_user_in_zone_arr['sesuserzone'];
			$session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype']; 
		}else{
			$session_session_normal_user_in_zone='';
			$session_session_normal_user_type='';
			$session_type='';
			$session_type_id='';
		}
		
		if($this->session->userdata('usersessiondata')!=''){ 			
			$session_type_arr=$this->session->userdata('usersessiondata');
			$session_type=$session_type_arr['usergrid'];
		}else if($this->session->userdata('session_normal_user_in_zone')!=''){
			$session_type_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_type=$session_type_arr['sesusertype']; 
		}else{
			$session_type=''; $session_type_id=''; $req_url='';
		}

		if($session_type==4){
			$session_type_id=$session_type_arr['userzoneid'];
			$req_url=base_url().'dashboards/zone/'.$session_type_id;
		}else if($session_type==5){
			if($this->session->userdata('session_zoneid_from_bus')!=''){ 			
				$session_type_arr=$this->session->userdata('session_zoneid_from_bus');
				$session_type_id=$session_type_arr['busid'];
				$session_type=$session_type_arr['type'];
				if($session_type=='business'){
					$req_url=base_url().'dashboards/business/'.$session_type_id;
				}else if($session_type=='listed'){
					$req_url=base_url().'auth/listed_business_verification/'.$session_type_id;
				}
			}
		}else if($session_type==8){
			if($this->session->userdata('session_orgid')!=''){ 			
				$session_type_arr=$this->session->userdata('session_orgid');
				$session_type_id=$session_type_arr['sesorgid'];
				$req_url=base_url().'dashboards/organization/'.$session_type_id;
			}
		}else if($session_type=='resident_user'){
			$session_type_id=$session_type_arr['sesuserzone'];
			$req_url=base_url().'index.php?zone='.$session_type_id;
		}
		
		if(is_numeric($adid)){ 
			$ad_dealtitle = urldecode($adid);
			$fetch_id="SELECT * FROM ads WHERE deal_title='$ad_dealtitle'";
			$ads_id=$this->db->query($fetch_id);
			$aid=$ads_id->row('id');                            
			
			if(!empty($aid)){
				$meta_tag_details = $this->ion_auth->meta_tag_details($aid);
			}else{
				$modified_url=base_url().'zone/'.$zone.'/'.$business.'/';
				redirect($modified_url, 'location', 301);
			}

			if(!empty($meta_tag_details)){ 
				if($meta_tag_details[0]['deal_title']!=''){
					$data['business_name']=$meta_tag_details[0]['deal_title'];
					$data['bsname']=$meta_tag_details[0]['business_name'];
					$data['zone_name']=$zone_name;
					$data['business_id']=$meta_tag_details[0]['business_id'];
				}else{
					$data['business_name']=$meta_tag_details[0]['business_name'];
				}
				
				$ckeditor_img = '';
				preg_match( '@src="([^"]+)"@' , $meta_tag_details[0]['image'], $match );
				$image = array_pop($match);
				if(!empty($image)){
					$ckeditor_img= $image;
				}
				
				if($ckeditor_img != ''){ 
					$data['meta_business_image'][0] = $ckeditor_img;
				}else{
					$data['meta_business_image'][0]="http://savingssites.com/assets/images/slides/slide-1_fb.jpg";
				}
				
				$description=$meta_tag_details[0]['description'];
				$data['description']=urldecode(strip_tags($description));   
			}
		}else if(!is_numeric($adid) && $adid !=''){ //echo 2; exit;		
			$businessname = urldecode($business) ;
			$ad_dealtitle = urldecode($adid);
			$fetch_id="SELECT * FROM ads WHERE deal_title='$ad_dealtitle'";
			$ads_id=$this->db->query($fetch_id);
			$aid=$ads_id->row('id');
			if(!empty($aid)){
				$meta_tag_details = $this->ion_auth->meta_tag_details($aid);
			}else{
				$modified_url=base_url().'zone/'.$zone.'/'.$business.'/';
				redirect($modified_url, 'location', 301);
			}
			
			$meta_tag_details = $this->ion_auth->meta_tag_details($aid);
			if(!empty($meta_tag_details)){  
				if($meta_tag_details[0]['deal_title']!=''){
					$data['business_name']=$meta_tag_details[0]['deal_title'];
					$data['bsname']=$meta_tag_details[0]['business_name'];
					$data['zone_name']=$zone_name;
					$data['business_id']=$meta_tag_details[0]['business_id'];
				}else{
					$data['business_name']=$meta_tag_details[0]['business_name'];
				}
				
				$ckeditor_img = '';
				preg_match( '@src="([^"]+)"@' , $meta_tag_details[0]['image'], $match );
				$image = array_pop($match);
				if(!empty($image)){
					$ckeditor_img= $image;
				}

				if($ckeditor_img != ''){ 
					$data['meta_business_image'][0] = $ckeditor_img;
				}else{
					$data['meta_business_image'][0]="http://savingssites.com/assets/images/slides/slide-1_fb.jpg";
				}
				
				$description=$meta_tag_details[0]['description'];
				$data['description']=urldecode(strip_tags($description));
			}
		} 

		if($this->session->userdata('session_normal_user_in_zone')!=''){
			$session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_session_normal_user_in_zone=$session_normal_user_in_zone_arr['sesuserzone']; 
		}else{
			$session_session_normal_user_in_zone='';
		}		
		
		if($adid == ''){
			$data['home_url']=current_url();
		}else{
			$data['home_url']=base_url()."zone/".$zone;
		}	    

		$data['home_url']=current_url();	
		$data['where_from']='';
		$data['zone_type']=$zone ;
		$data['zone_owner_new'] = array();
		$data['zone_id'] = $zoneId; 
		$data["user_id"]='';
		$data['uid_admin']='';
		$data['login_from_mail']='';
		$data['userid_for_registration']='';		
		if(empty($zoneId)){  
			$data['class']="home";
			if ($this->ion_auth->logged_in()){
				$auser = $this->ion_auth->user()->row();
				$data['user'] = $auser;
				$data['userid_zone']=$auser->id;
				
				if(!empty($auser)){ 
					$data["email"] = $auser->email;
					if($auser->first_name!=''){
						$data["firstName"] = $auser->first_name;
					}else{
						$data["firstName"] = $auser->username;
					}
					
					$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";
					$uid = $auser->id;
					$data['zone_owner_new'] = $this->business->get_zone_byuser($uid);
					$data['business_owner_new'] = $this->business->business_owner_user($uid);
				}
			}

			$data['content']=$this->load->view("default/show_content_home",$data,TRUE);		
			$this->load->view("default/default_content", $data);
			return;
		}
		
		if ($this->ion_auth->logged_in()){ 
			$auser = $this->ion_auth->user()->row();
			if(!empty($auser)){ 
				$data["user_id"] = $auser->user_id;
				$data["email"] = $auser->email; 
				$data["firstName"] = $auser->first_name;
				$data["lastName"] = $auser->last_name;
				$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";
				$data["user_id"] = $auser->id;
				$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";

				$cookie = array(
					'name'   => 'user_id',
					'value'  => $data["user_id"],
					'expire' => time()+86500,
					'domain' => '',
					'path'   => '/',
					'prefix' => '',
				);
				set_cookie($cookie);
			}
		}
		
		$theme_cookie_value=''; $zoneid_cookie_value='';
		$data['change_theme'] = $this->ad->get_display_change_theme_in_zonepage($zoneId); 
		
		if(!empty($data['change_theme'])){
			if($data['change_theme'][0]['ischangezonetheme']==0){
				delete_cookie("theme"); delete_cookie("zoneid");
				$theme_cookie_value=''; $zoneid_cookie_value='';
			}else{
				$theme_cookie_value=$this->input->cookie('theme_zone', TRUE);
				$zoneid_cookie_value=$this->input->cookie('zoneid_zone', TRUE);
			}
		}
		
		$data['css_value']=''; $data['css_vertical_value']=''; 
		if($theme_cookie_value != '' && $zoneid_cookie_value!=''){ 
			if($theme_cookie_value=='LT' && $zoneid_cookie_value==$zoneId){ 
				$data['image_url'] =base_url('assets/stylesheets/light_theme');
				$data['css_value1']="assets/stylesheets/light_theme/styles.css?time=".time();
				$data['css_value2']="assets/stylesheets/light_theme/light_styles.css?time=".time();
			}else if($theme_cookie_value=='BLT' && $zoneid_cookie_value==$zoneId){
				$data['image_url'] =base_url('assets/stylesheets/blue_theme');
				$data['css_value1']="assets/stylesheets/blue_theme/styles.css?time=".time();
				$data['css_value2']="assets/stylesheets/blue_theme/blue_styles.css?time=".time();
			}else if($theme_cookie_value=='BRT' && $zoneid_cookie_value==$zoneId){ 
				$data['image_url'] =base_url('assets/stylesheets/brown_theme');
				$data['css_value1']="assets/stylesheets/brown_theme/styles.css?time=".time();
				$data['css_value2']="assets/stylesheets/brown_theme/brown_styles.css?time=".time();
			} else if($theme_cookie_value=='RT' && $zoneid_cookie_value==$zoneId){
				$data['image_url'] =base_url('assets/stylesheets/red_theme');
				$data['css_value1']="assets/stylesheets/red_theme/styles.css?time=".time();
				$data['css_value2']="assets/stylesheets/red_theme/red_styles.css?time=".time();
			} 
		}else{ 
			$change_theme = $this->ad->get_display_change_theme_in_zonepage($zoneId);
			
			if(!empty($change_theme)){
				if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='DT'){
					$data['image_url'] =base_url('assets/stylesheets/blue_theme');
					$data['css_value']="assets/stylesheets/up_styles_blue.css?time=".time();
					$data['css_value_for_blue']="assets/stylesheets/styles_blue_skin.css?time=".time();
					$data['css_vertical_value']="assets/stylesheets/blue_vertical_menu.css?time=".time();
					$data['barter_button']='blue'; $data['job_button']='blue';
				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='MT'){
					$data['image_url'] =base_url('assets/stylesheets/blue_theme');
					$data['css_value']="assets/stylesheets/styles_maroon_skin.css?time=".time();
					$data['css_vertical_value']="assets/stylesheets/maroon_vertical_menu.css?time=".time();
					$data['css_value_for_blue']="assets/stylesheets/styles_maroon_skin.css?time=".time();
					$data['barter_button']='red'; $data['job_button']='red';
				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='BT'){
					$data['image_url'] =base_url('assets/stylesheets/light_theme');;
					$data['css_value']="assets/stylesheets/up_styles_blue.css?time=".time();
					$data['css_value_for_blue']="assets/stylesheets/styles_blue_skin.css?time=".time();
					$data['css_vertical_value']="assets/stylesheets/blue_vertical_menu.css?time=".time();
					$data['barter_button']='blue'; $data['job_button']='blue';
				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='ET'){
					$data['css_value']="assets/stylesheets/style_3/styles_dark_skin.css?time=".time();
					$data['css_vertical_value']="assets/stylesheets/dark_vertical_menu.css?time=".time();
					$data['barter_button']='dark'; $data['job_button']='dark';
				} else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='RT'){
					$data['image_url'] =base_url('assets/stylesheets/red_theme');
					$data['css_value1']="assets/stylesheets/red_theme/styles.css?time=".time();
					$data['css_value2']="assets/stylesheets/red_theme/red_styles.css?time=".time();	
				} else if($change_theme[0]['ischangezonetheme']==1){
					$data['image_url'] =base_url('assets/stylesheets/red_theme');
					$data['css_value']="assets/stylesheets/red_theme/styles.css?time=".time();
					$data['css_value_for_blue']="assets/stylesheets/red_theme/red_styles.css?time=".time();
					$data['barter_button']='dark'; $data['job_button']='dark';
				}
			}
		}
		
		$data['theme_cookie_value']=$theme_cookie_value;
		$cookie = array(
			'name'   => 'zoneid',
			'value'  => $data['zone_id'],
			'expire' => time()+86500,
			'domain' => '',
			'path'   => '/',
			'prefix' => '',
		);
		set_cookie($cookie);
		
		$themeImageUrl = array(
			'name'  => 'themeImageUrl',
			'value' => $data['image_url'],
			'expire' => time() + (10 * 365 * 24 * 60 * 60),
			'domain' => '',
			'path'   => '/',
			'prefix' => ''
		);
		set_cookie($themeImageUrl);
		
		$cookie = array(
			'name'   => 'back_to_blog',
			'value'  => 2,
			'expire' => time()+86500,
			'domain' => '',
			'path'   => '/',
			'prefix' => '',
		);
		set_cookie($cookie);
		
		$cookie = array(
			'name'   => 'back_to_blog_path',
			'value'  => base_url(),
			'expire' => time()+86500,
			'domain' => '',
			'path'   => '/',
			'prefix' => '',
		);
		set_cookie($cookie);
		
		$data['displayoffer'] = $this->ad->get_display_offer_in_zonepage($zoneId); 
		$data['zone_pref_setting']=$this->sales_zone->get_default_settings_in_zone($zoneId);	
		$data['count_banner']=$this->banner->count_banner($zoneId);
		$data['sponsor_ad_text'] = $this->ads->sponsorshiptext($zoneId);
		$data['zone'] = $this->sales_zone->get_zone($zoneId); 
		$data['get_adid']=$adid; 
		$data['from_sharing']=$s; 	
		$data['session_usertype']=$session_usertype; 
		$data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;
		$data['session_session_normal_user_type']=$session_session_normal_user_type;
		$data['session_session_type']=$session_type;
		$data['session_session_type_id']=$session_type_id;
		$data['req_url']=$req_url;
		$scripts = array("assets/scripts/jquery-1.7.2.min.js");
		$data['scripts'] = $scripts; 
		$data['aid'] = $aid;    
		$data['user_type']  =  $this->session->userdata("session_login_details");
		$data['snapDiningData']   = $this->snapDining->getAllCommonSnapData();
		$data['zone_local_stores'] = $this->sales_zone->get_active_local_stores_zone($zoneId);
		$data['zone_real_estates'] = $this->sales_zone->get_active_real_estates_zone($zoneId);
		$data['zone_autos'] = $this->sales_zone->get_active_autos_zone($zoneId);
		$data['activeBanner'] = $this->get_baner($zoneId);
		
		if($data['zone_id'] == 213){
			$this->load->view('directory', $data);
		}else{
			$this->load->view('new_page', $data);
		}
	}

    public function add_fav_restaurant(){  //pending
		$checkData = $this->db->query('Select * from users_favorites_restaurant where fav_res ="'.$_REQUEST['productid'].'" and userid = "'.$_REQUEST['userid'].'" and  restaurant ="'.$_REQUEST['busid'].'"');
		if($checkData->num_rows() == 0){          
          	$getCredits = "INSERT INTO users_favorites_restaurant (fav_res, userid , restaurant)
				VALUES ( '".$_REQUEST['productid']."', '".$_REQUEST['userid']."' , '".$_REQUEST['busid']."');";
			$getCreditsResult = $this->db->query($getCredits);
		}
		die();
    }

    public function thankyou(){
		$giftemail = isset($_GET["giftemail"])?$_GET["giftemail"]:'';
    	$zoneid = $this->CommonController->redirectToBusiness();
    	$session_usertype = $session_session_normal_user_in_zone = $session_session_normal_user_type = $session_type = $session_type_id= $user_id = $email = $firstName = $lastName = $businessUser = $refferalcode = $session_session_type_id = $from_where = $username = $member_type = $userid = $zone_name = $zone_logo =  '';
   		$used_certificate = 1;
   		$final_data_sum = $maxvalue1 = 0;
    	$maxsubtotal = $paypal_info = [];
		$theme = "blue"; 
		$page 	= 'Old Glory';
		$referAmount = $this->myconfig->referAmount;
		$businessmulti = isset($_GET["businessim"])?$_GET["businessim"]:'';
    	if(isset($_REQUEST['user_type']) && $_REQUEST['user_type'] == 'business'){
    		$month = date('m');
    		// if($month == 1){$premonth = 12;}
    		// else{$premonth = $month-1;}
    		// $this->CommonController->updateData('business_bid_detail',['status' => 'expired'],['month' => $premonth]);
    		if($month == 12){$nextmonth = 1;}
    		else{$nextmonth = $month+1;}
    		$sqlcounter = "Select * from business_bid_detail where business_id =".$_REQUEST['busid'];
    		$counter = $this->CommonController->SelectRawquery($sqlcounter, 'count');

    		$pidcounter = "Select * from business_bid_detail where business_id ='".$_REQUEST['busid']."' AND month='".$nextmonth."'";
    		$eixstsentry = $this->CommonController->SelectRawquery($pidcounter, 'count');
    		$arr = [
        			'counter' => $counter+1,
        			'month' => $nextmonth,
        			'business_id' => $_REQUEST['busid'],
        			'zone_id' => $_REQUEST['zoneid'],
        			'payerId' => $_REQUEST['PayerID'],
        			'business_name' => $_REQUEST['business_name'],
        			'bid_amount' => $_REQUEST['bid_amount'],
        			'status' => 'active',
        		];
        		if($eixstsentry == 0){
        			$this->CommonController->InsertData('business_bid_detail', $arr);
        		}
        		return redirect()->to(base_url().'/businessdashboard/businessdetail/'.$_REQUEST['busid'].'/'.$_REQUEST['zoneid'].'?page=businessbidrank&pay=1');	
    	}else{
    		$userID = @$_GET["UserId"];
       		$payerId = isset($_GET['PayerID'])?$_GET['PayerID']:'';
       		$amountPaid = @$_GET['Amount'];
       		$AucId =@$_GET['AucId']; 
       		$Token = time();//@$_GET['token'];
        	$AucId_encode =  explode(':', $AucId);
        	$busid = @$_GET["busid"];
        	$zoneid = ($zoneid != '')?$zoneid:@$_GET["zoneid"];
        	$user_type = isset($_GET["user_type"])?$_GET["user_type"]:'';
        	$usedcert = isset($_GET["usedcert"])?$_GET["usedcert"]:0;
			$checkData = $this->db->query('Select * from tbl_deals_purchased where token ="'.$Token.'"');	
			/*get implode data*/
			$businessmulti = isset($_GET["businessim"])?$_GET["businessim"]:'';   
			$dealidmulti = isset($_GET["dealidim"])?$_GET["dealidim"]:'';   
			$amountmulti = isset($_GET["amountim"])?$_GET["amountim"]:'';   
			$subtotalmulti = isset($_GET["subtotalim"])?$_GET["subtotalim"]:'';   
			$dis = isset($_GET["disim"])?$_GET["disim"]:0;   
			$creditpay = isset($_GET["creditim"])?$_GET["creditim"]:0;   
			$disamountim = isset($_GET["disamountim"])?$_GET["disamountim"]:'';   
        	/*get implode data*/
			$sql = 'Select * from tbl_deals_purchased where token ="'.$Token.'"';
        	$checkData = $this->CommonController->SelectRawquery($sql,'row');
        	if($checkData == ''){
        		$arr = [
        			'userId' => $userID,
        			'zoneId' => $zoneid,
        			'payerId' => $payerId,
        			'busId' => $busid,
        			'amountPrchased' => $amountPaid,
        			'purchasedAt' => date('Y-m-d'),
        			'dealId' => json_encode($AucId_encode),
        			'token' => $Token,
        			'user_type' => $user_type,
        			'certreciever' => $giftemail
        		];
        		$this->CommonController->InsertData('tbl_deals_purchased', $arr);
        		$views_credit = $this->CommonController->SelectDataMultiWay('tbl_member','views_credit','column',['user_id' => $userID],[],'',[]);
        		if(@$_GET['creditStatus'] == 'deduct'){
        			$this->CommonController->updateData('tbl_member',['views_credit' => ($views_credit-3)],['user_id' => $userID]);
				}
				foreach ($AucId_encode as $key => $AucId) {
					if($AucId != ''){
						$concolation_certificatedetails = "SELECT a.numberofconsolation  , a.deal_product_id  as productid ,  count(so.id)   as totalconsolationleft FROM tbl_deals_products a,  tbl_deals c , tbl_deals_purchased  so WHERE a.deal_product_id=c.product_id  and so.dealId =  c.product_id and c.deal_id=".$AucId;
						$certidcateleft_data = $this->CommonController->SelectRawquery($concolation_certificatedetails,'row');
						if($certidcateleft_data->numberofconsolation != -1  &&  $certidcateleft_data->numberofconsolation != 0){
							$numberofconsolation = $this->CommonController->SelectDataMultiWay('tbl_deals_products','numberofconsolation','column',['deal_product_id' => $certidcateleft_data->productid],[],'',[]);
							$this->CommonController->updateData('tbl_deals_products',['numberofconsolation' => ($numberofconsolation-1)],['deal_product_id' => $certidcateleft_data->productid]);
						}else if($certidcateleft_data->numberofconsolation == 0){
							$this->CommonController->updateData('tbl_deals',['status' => 'Closed'],['deal_id' => $AucId]);
						}
					} 
				}
				$views_credit = $this->CommonController->SelectDataMultiWay('tbl_member','views_credit','column',['user_id' => $userID],[],'',[]);
				$checkData = $this->CommonController->updateData('tbl_member',['views_credit' => ($views_credit+3)],['user_id' => $userID]);
			}
			$this->cart->destroy();
			$this->free_refer_update($userID,$usedcert);
			/*insert meta data*/
		}
    	
    	if($businessmulti != ''){
           	$busArr = explode(',', $businessmulti);
           	$dealArr = explode(',', $dealidmulti);
           	$amountArr = explode(',', $amountmulti);
           	$totalArr = explode(',', $subtotalmulti);
           	$busArr = explode(',', $businessmulti);
			foreach ($busArr as $k1 => $v1) {
				$total = (int)$totalArr[$k1]-((int)$totalArr[$k1]*(int)$dis/100); 
				$meta_data = array(
					'userId' => $userID,
					'zoneId' => $zoneid,
					'totalamount' => $totalArr[$k1],
					'discount' => $dis,
					'amountPurchased' => $total,
					'busId' => $busArr[$k1],
					'dealId' => $dealArr[$k1],
					'token' => $Token,
					'purchasedAt' => date('Y-m-d'),
					'certreciever' => $giftemail

				); 
				if($disamountim[$k1] != 'notuse' || $disamountim[$k1] != 'notusefreecert'){
					$checkData = $this->CommonController->updateData('businesscreditcheck',['amount_used' => 1],['user_id' => $userID,'business_id'=> $busArr[$k1]]);
				}
				$this->CommonController->InsertData('tbl_deals_purchased_meta', $meta_data);
			}  
		}
		if($giftemail != ''){
    		$sub = 'Gift Certificate';
    		$userqry = "Select * from users where id ='".$_REQUEST['UserId']."'";
    		$usergiftarr = $this->CommonController->SelectRawquery($userqry, 'row');
    		$gituserfirstname = $usergiftarr->first_name;
    		$gituserlastname = $usergiftarr->last_name;
    		$gituserzone = $_REQUEST['zoneid'];
    		$link = base_url().'/zone/'.$gituserzone.'?token='.$_REQUEST['UserId'].'';
    		$body = 'Hi user , savings sites resident user '.$gituserfirstname.' '.$gituserlastname.' send you a gift certificate. Redeem this gift simply <a href="'.$link.'">click</a> and register on savingssites.';
    		$send = $this->CommonController->SendMail('',$giftemail,$sub,$body);
		}
		/*free cert data*/
    	$dealcertqry = "Select * from user_refer_meta where gen_user_id =".$_REQUEST['UserId']." AND amountused='no'";
    	$deslcertArr = $this->CommonController->SelectRawquery($dealcertqry, 'row');
    	if($deslcertArr != ''){
    		$referdealuser = isset($deslcertArr->from_user)?$deslcertArr->from_user:'';
    		$refferaldealuser = isset($deslcertArr->gen_user_id)?$deslcertArr->gen_user_id:'';
			$setdealcertqry = "Select * from users where id IN (".$referdealuser.",".$refferaldealuser.")";
    		$setdealcertArr = $this->CommonController->SelectRawquery($setdealcertqry);
    		if(count($setdealcertArr) > 0){
    			foreach ($setdealcertArr as $k => $v) {
    				if($v->id == $referdealuser){
						$addfreecert = $v['free_cert_amount']+$referAmount;
    					$this->CommonController->updateData('users',['free_cert_amount' => $addfreecert],['id' => $v['id']]);
					}
    			}
    			$this->CommonController->updateData('users',['from_user_refer' => ''],['id' => $refferaldealuser]);
    			$this->CommonController->updateData('user_refer_meta',['amountused' => 'yes'],['gen_user_id' => $_REQUEST['UserId']]);
    		}
    	}else{
    		$userqry = "Select * from users where id=".$_REQUEST['UserId']."";
    		$userArr = $this->CommonController->SelectRawquery($userqry,'row');

    		$referdealuser = isset($userArr->from_user_refer)?$userArr->from_user_refer:'';
    		$refferaldealuser = isset($userArr->id)?$userArr->id:'';
    		if($referdealuser > 0){
				$referuserqry = "Select * from users where id=".$referdealuser."";
    			$referuserArr = $this->CommonController->SelectRawquery($referuserqry,'row');

    			$referuseramount = isset($referuserArr->free_cert_amount)?$referuserArr->free_cert_amount:'';
				$addfreecert = $referuseramount+$referAmount;
    			$this->CommonController->updateData('users',['free_cert_amount' => $addfreecert],['id' => $referdealuser]);
    			$this->CommonController->updateData('users',['from_user_refer' => ''],['id' => $refferaldealuser]);
    		}
    	}

    	if(isset($_REQUEST['dealcertamount']) && $_REQUEST['dealcertamount'] > 0){
    		$mindealcertqry = "Select * from users where id=".$_REQUEST['UserId'];
    		$mindealcertArr = $this->CommonController->SelectRawquery($mindealcertqry);
    		if(count($mindealcertArr) > 0){
    			foreach ($mindealcertArr as $k => $v) {
    				$addfreecert = $v['free_cert_amount']-$_REQUEST['dealcertamount'];
    				if($addfreecert <= 0 || $addfreecert == ''){
    					$addfreecert = 0;
    				}
    				$this->CommonController->updateData('users',['free_cert_amount' => $addfreecert],['id' => $v['id']]);
    			}	
    		}
    	}
		/*free cert data*/
		if($this->ionAuth->loggedIn()){ 
			$auser = $this->ionAuth->user()->row();
			if(!empty($auser)){ 
				$user_id = $auser->user_id;
				$email = $auser->email; 
				$firstName = $auser->first_name;
				$lastName = $auser->last_name;
				$businessUser = $auser;
				$username = $auser->username;
			}
		}
		/*insert meta data*/
		$footer = 'homefooter';
		$header = 'loginheader';
		$data['zoneid'] = $zoneid;

		return view('thankyou',['user_id' => $user_id,'email'=>$email,'firstName'=>$firstName,'lastName' => $lastName,'businessUser' => $businessUser,'username' => $username,'zoneid' => $zoneid,'userid'=> $user_id,'theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zone_name' => $zone_name,'zone_id' => $zoneid,'zone_logo' => $zone_logo,'session_session_normal_user_type'=> $session_session_normal_user_type]);


		$data['head'] = $this->load->view("includes/head",$data); 
		$data['content']=$this->load->view("admin/thankyou",$data,TRUE);
		$this->load->view("default/default_content", $data);
	}
	
	public function free_refer_update($user_id = '',$usedcert = 0){
		if($user_id != ''){
			$userquery="SELECT * FROM users WHERE id=".$user_id."";
        	$userArr = $this->CommonController->SelectRawquery($userquery,'row');
			$old_user_id = $userArr->from_user_refer; 
        	$new_user_free_cert = $userArr->free_cert; 
        	$updateNewUser = array('free_cert'=> $new_user_free_cert-$usedcert);
			$this->CommonController->updateData('users',$updateNewUser,['id' => $user_id]);
			
			if($old_user_id != ''){
				$userquery="SELECT * FROM users WHERE id=".$old_user_id."";
        		$userArr = $this->CommonController->SelectRawquery($userquery,'row');
				$old_user_free_cert = isset($userArr->free_cert)?$userArr->free_cert:0; 
				$updateoldUser = array('free_cert'=> $old_user_free_cert+$usedcert);
				$this->CommonController->updateData('users',$updateoldUser,['id' => $old_user_id]);
			}	
		}
	}

    public function load_final($zone=false,$business=false,$adid=false,$s=''){  //pending
		if(isset($zone)){
			$zone = trim($zone);
		}
		$zone=!empty($zone) ? htmlentities(urldecode($zone)) : 0;
		$data = array();
		if(strpos(current_url(),'zone/load/')!=false){ 
			if($this->uri->total_segments()==4)			
				$modified_url=base_url("zone/".$this->uri->segment(3, 0)."/business/".$this->uri->slash_segment(4,'leading'));
			else if($this->uri->total_segments()==3)	
				$modified_url=base_url("zone/".$this->uri->segment(3, 0)."/");
			else if($this->uri->total_segments()==2)	
				$modified_url=base_url();	

		redirect($modified_url, 'location', 301);
		}
		//setting relative path
		$link_path = $this->config->item('link_path'); 
		if($link_path==''){ 
			if($this->uri->total_segments()==4)
				$data['link_path']= "../../../../";
			else if($this->uri->total_segments()==3)
				$data['link_path']= "../../../"	;
			else if($this->uri->total_segments()==2)
				$data['link_path']= "../../";		
		}else{
			$data['link_path']= $link_path ; 
		}
		
		if(!is_numeric($zone)){  
 			$zone_details = $this->sales_zone->get_zone_by_seo_name(str_replace(' ','-',$zone)); 
			$zoneId =$zone_details->id;
			$zone_name=$zone_details->seo_zone_name;
			if($zoneId!=''){
				$count_num = $this->sales_zone->get_bcs_count_for_zone($zoneId);
				$data['bcs_count'] = number_format($count_num);	
			}else{
				$modified_url=base_url();	
				redirect($modified_url, 'location', 301);
			}
		}else{ 
			$zone_details = $this->sales_zone->get_zone($zone);
			$zoneId =$zone;
			$zone_name=$zone_details->seo_zone_name;
			$zone_name=str_replace(' ','-',htmlentities(urldecode($zone_name)));
			if($this->uri->segment(1,0)=="zone" && is_numeric($zone)){
				if($this->uri->segment(2,0)==$zoneId){
					$modified_url=str_replace('zone/'.$zoneId,'zone/'.$zone_name,current_url());
					redirect($modified_url, 'location', 301);
				}
			}
		}
		//adid setted here
		if(!empty($adid)){		
			if(is_numeric($adid)){
				$data['deal_title']=preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ', '-',htmlentities(urldecode($adid))));	
				$data['deal_title_ad_id']=$adid; 
				$data['deal_title_type']="insert_deal_title";
			}else{
				$data['deal_title']=preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ', '-',htmlentities(urldecode($adid))));	
			}
		}
		
		$data['adid']=$adid;
		//session data set
		if($this->session->userdata('session_usertype')!=''){
			$session_usertype_arr=$this->session->userdata('session_usertype');
			$session_usertype=$session_usertype_arr['usertype']; 
		}else{
			$session_usertype='';
		}
		
		if($this->session->userdata('session_normal_user_in_zone')!=''){
			$session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_session_normal_user_in_zone=$session_normal_user_in_zone_arr['sesuserzone'];
			$session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype']; 
		}else{
			$session_session_normal_user_in_zone='';
			$session_session_normal_user_type='';
			$session_type='';
			$session_type_id='';
		}
		
		if($this->session->userdata('usersessiondata')!=''){ 			
			$session_type_arr=$this->session->userdata('usersessiondata');
			$session_type=$session_type_arr['usergrid'];
		}else if($this->session->userdata('session_normal_user_in_zone')!=''){
			$session_type_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_type=$session_type_arr['sesusertype']; 
		}else{
			$session_type=''; $session_type_id=''; $req_url='';
		}
		if($session_type==4){
			$session_type_id=$session_type_arr['userzoneid'];
			$req_url=base_url().'dashboards/zone/'.$session_type_id;
		}else if($session_type==5){
			if($this->session->userdata('session_zoneid_from_bus')!=''){ 			
				$session_type_arr=$this->session->userdata('session_zoneid_from_bus');
				$session_type_id=$session_type_arr['busid'];
				$session_type=$session_type_arr['type'];
				if($session_type=='business'){
					$req_url=base_url().'dashboards/business/'.$session_type_id;
				}else if($session_type=='listed'){
					$req_url=base_url().'auth/listed_business_verification/'.$session_type_id;
				}
			}
		}else if($session_type==8){
			if($this->session->userdata('session_orgid')!=''){ 			
				$session_type_arr=$this->session->userdata('session_orgid');
				$session_type_id=$session_type_arr['sesorgid'];
				$req_url=base_url().'dashboards/organization/'.$session_type_id;
			}
		}else if($session_type=='resident_user'){
			$session_type_id=$session_type_arr['sesuserzone'];
			$req_url=base_url().'index.php?zone='.$session_type_id;
		}
		
		if(is_numeric($adid)){ 
			$ad_dealtitle = urldecode($adid);
			$fetch_id="SELECT * FROM ads WHERE deal_title='$ad_dealtitle'";
			$ads_id=$this->db->query($fetch_id);
			$aid=$ads_id->row('id');                            
			if(!empty($aid)){
				$meta_tag_details = $this->ion_auth->meta_tag_details($aid);
			}else{
				$modified_url=base_url().'zone/'.$zone.'/'.$business.'/';
				redirect($modified_url, 'location', 301);
			}
			
			if(!empty($meta_tag_details)){ 
				if($meta_tag_details[0]['deal_title']!=''){
					$data['business_name']=$meta_tag_details[0]['deal_title'];
					$data['bsname']=$meta_tag_details[0]['business_name'];
					$data['zone_name']=$zone_name;
					$data['business_id']=$meta_tag_details[0]['business_id'];
				}else
					$data['business_name']=$meta_tag_details[0]['business_name'];
				
				$ckeditor_img = '';
				preg_match( '@src="([^"]+)"@' , $meta_tag_details[0]['image'], $match );
				$image = array_pop($match);
				if(!empty($image)){
					$ckeditor_img= $image;
				}
				
				if($ckeditor_img != ''){ 
					$data['meta_business_image'][0] = $ckeditor_img;
				}else{
					$data['meta_business_image'][0]="http://savingssites.com/assets/images/slides/slide-1_fb.jpg";
				}
				
				$description=$meta_tag_details[0]['description'];
				$data['description']=urldecode(strip_tags($description));
			}		
		}else if(!is_numeric($adid) && $adid !=''){
			$businessname = urldecode($business) ;
			$ad_dealtitle = urldecode($adid); 
			$fetch_id="SELECT * FROM ads WHERE deal_title='$ad_dealtitle'";
			$ads_id=$this->db->query($fetch_id);
			$aid=$ads_id->row('id');
			
			if(!empty($aid)){
				$meta_tag_details = $this->ion_auth->meta_tag_details($aid);
			}else{
				$modified_url=base_url().'zone/'.$zone.'/'.$business.'/';
				redirect($modified_url, 'location', 301);
			}
			
			$meta_tag_details = $this->ion_auth->meta_tag_details($aid);
			if(!empty($meta_tag_details)){  
				if($meta_tag_details[0]['deal_title']!=''){
					$data['business_name']=$meta_tag_details[0]['deal_title'];
					$data['bsname']=$meta_tag_details[0]['business_name'];
					$data['zone_name']=$zone_name;
					$data['business_id']=$meta_tag_details[0]['business_id'];
				}else
					$data['business_name']=$meta_tag_details[0]['business_name'];
				
				$ckeditor_img = '';
				preg_match( '@src="([^"]+)"@' , $meta_tag_details[0]['image'], $match );
				$image = array_pop($match);
				
				if(!empty($image)){
					$ckeditor_img= $image;
				}
				
				if($ckeditor_img != ''){ 
					$data['meta_business_image'][0] = $ckeditor_img;
				}else{
					$data['meta_business_image'][0]="http://savingssites.com/assets/images/slides/slide-1_fb.jpg";
				}
				$description=$meta_tag_details[0]['description'];
				$data['description']=urldecode(strip_tags($description));
			}
		} 
		
		if($this->session->userdata('session_normal_user_in_zone')!=''){
			$session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_session_normal_user_in_zone=$session_normal_user_in_zone_arr['sesuserzone']; 
		}else{
			$session_session_normal_user_in_zone='';
		}		
		
		if($adid == ''){
			$data['home_url']=current_url();
		}else{
			$data['home_url']=base_url()."zone/".$zone;
		}	    

		$data['home_url']=current_url();	
		$data['where_from']='';
		$data['zone_type']=$zone;
		$data['zone_owner_new'] = array();
		$data['zone_id'] = $zoneId; 
		$data["user_id"]='';
		$data['uid_admin']='';
		$data['login_from_mail']='';
		$data['userid_for_registration']='';		
		if(empty($zoneId)){  
			$data['class']="home";
			if ($this->ion_auth->logged_in()){
				$auser = $this->ion_auth->user()->row();
				$data['user'] = $auser;
				$data['userid_zone']=$auser->id;
				if(!empty($auser)){ 
					$data["email"] = $auser->email;
					if($auser->first_name!=''){
						$data["firstName"] = $auser->first_name;
					}else{
						$data["firstName"] = $auser->username;
					}

					$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";
					$uid = $auser->id;
					$data['zone_owner_new'] = $this->business->get_zone_byuser($uid);
					$data['business_owner_new'] = $this->business->business_owner_user($uid);
				}
			}

			$data['content']=$this->load->view("default/show_content_home",$data,TRUE);		
			$this->load->view("default/default_content", $data);
			return;
		}
		
		if ($this->ion_auth->logged_in()){ 
			$auser = $this->ion_auth->user()->row();
			if(!empty($auser)){ 
				$data["user_id"] = $auser->user_id;
				$data["email"] = $auser->email; 
				$data["firstName"] = $auser->first_name;
				$data["lastName"] = $auser->last_name;
				$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";
				$data["user_id"] = $auser->id;
				$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";
				
				$cookie = array(
					'name'   => 'user_id',
					'value'  => $data["user_id"],
					'expire' => time()+86500,
					'domain' => '',
					'path'   => '/',
					'prefix' => '',
				);
				set_cookie($cookie);
			}
		}
		
		$theme_cookie_value=''; $zoneid_cookie_value='';
		$data['change_theme'] = $this->ad->get_display_change_theme_in_zonepage($zoneId);
		if(!empty($data['change_theme'])){
			if($data['change_theme'][0]['ischangezonetheme']==0){
				delete_cookie("theme"); delete_cookie("zoneid");
				$theme_cookie_value=''; $zoneid_cookie_value='';
			}else{
				$theme_cookie_value=$this->input->cookie('theme_zone', TRUE);
				$zoneid_cookie_value=$this->input->cookie('zoneid_zone', TRUE);
			}
		}
		
		$data['css_value']=''; $data['css_vertical_value']='';
		
		if($theme_cookie_value != '' && $zoneid_cookie_value!=''){ 
			if($theme_cookie_value=='LT' && $zoneid_cookie_value==$zoneId){ // Blue-R Theme
				$data['image_url'] =base_url('assets/stylesheets/light_theme');
				$data['css_value1']="assets/stylesheets/light_theme/styles.css?time=".time();
				$data['css_value2']="assets/stylesheets/light_theme/light_styles.css?time=".time();
			}else if($theme_cookie_value=='BLT' && $zoneid_cookie_value==$zoneId){ // Blue-R Theme
				$data['image_url'] =base_url('assets/stylesheets/blue_theme');
				$data['css_value1']="assets/stylesheets/blue_theme/styles.css?time=".time();
				$data['css_value2']="assets/stylesheets/blue_theme/blue_styles.css?time=".time();
			}else if($theme_cookie_value=='BRT' && $zoneid_cookie_value==$zoneId){ // Blue-R Theme
				$data['image_url'] =base_url('assets/stylesheets/brown_theme');
				$data['css_value1']="assets/stylesheets/brown_theme/styles.css?time=".time();
				$data['css_value2']="assets/stylesheets/brown_theme/brown_styles.css?time=".time();
			} else if($theme_cookie_value=='RT' && $zoneid_cookie_value==$zoneId){ // Blue-R Theme
				$data['image_url'] =base_url('assets/stylesheets/red_theme');
				$data['css_value1']="assets/stylesheets/red_theme/styles.css?time=".time();
				$data['css_value2']="assets/stylesheets/red_theme/red_styles.css?time=".time();
			} 
		}else{
			$change_theme = $this->ad->get_display_change_theme_in_zonepage($zoneId);
			if(!empty($change_theme)){
				if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='DT'){
					$data['image_url'] =base_url('assets/stylesheets/blue_theme');
					$data['css_value']="assets/stylesheets/up_styles_blue.css?time=".time();
					$data['css_value_for_blue']="assets/stylesheets/styles_blue_skin.css?time=".time();
					$data['css_vertical_value']="assets/stylesheets/blue_vertical_menu.css?time=".time();
					$data['barter_button']='blue'; $data['job_button']='blue';
				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='MT'){
					$data['image_url'] =base_url('assets/stylesheets/blue_theme');
					$data['css_value']="assets/stylesheets/styles_maroon_skin.css?time=".time();
					$data['css_vertical_value']="assets/stylesheets/maroon_vertical_menu.css?time=".time();
					$data['css_value_for_blue']="assets/stylesheets/styles_maroon_skin.css?time=".time();
					$data['barter_button']='red'; $data['job_button']='red';
				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='BT'){
					$data['image_url'] =base_url('assets/stylesheets/light_theme');;
					$data['css_value']="assets/stylesheets/up_styles_blue.css?time=".time();
					$data['css_value_for_blue']="assets/stylesheets/styles_blue_skin.css?time=".time();
					$data['css_vertical_value']="assets/stylesheets/blue_vertical_menu.css?time=".time();
					$data['barter_button']='blue'; $data['job_button']='blue';
				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='ET'){
					$data['css_value']="assets/stylesheets/style_3/styles_dark_skin.css?time=".time();
					$data['css_vertical_value']="assets/stylesheets/dark_vertical_menu.css?time=".time();
					$data['barter_button']='dark'; $data['job_button']='dark';
				} else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='RT'){
					$data['image_url'] =base_url('assets/stylesheets/red_theme');
					$data['css_value1']="assets/stylesheets/red_theme/styles.css?time=".time();
					$data['css_value2']="assets/stylesheets/red_theme/red_styles.css?time=".time();	
				} else if($change_theme[0]['ischangezonetheme']==1){
					$data['image_url'] =base_url('assets/stylesheets/red_theme');
					$data['css_value']="assets/stylesheets/red_theme/styles.css?time=".time();
					$data['css_value_for_blue']="assets/stylesheets/red_theme/red_styles.css?time=".time();
					$data['barter_button']='dark'; $data['job_button']='dark';
				}
			}
		}
		
		$data['theme_cookie_value']=$theme_cookie_value;
		$cookie = array(
			'name'   => 'zoneid',
			'value'  => $data['zone_id'],
			'expire' => time()+86500,
			'domain' => '',
			'path'   => '/',
			'prefix' => '',
		);
		set_cookie($cookie);
		
		$themeImageUrl = array(
			'name'  => 'themeImageUrl',
			'value' => $data['image_url'],
			'expire' => time() + (10 * 365 * 24 * 60 * 60),
			'domain' => '',
			'path'   => '/',
			'prefix' => ''
		);
		set_cookie($themeImageUrl);
		
		$cookie = array(
			'name'   => 'back_to_blog',
			'value'  => 2,
			'expire' => time()+86500,
			'domain' => '',
			'path'   => '/',
			'prefix' => '',
		);
		set_cookie($cookie);
		
		$cookie = array(
			'name'   => 'back_to_blog_path',
			'value'  => base_url(),
			'expire' => time()+86500,
			'domain' => '',
			'path'   => '/',
			'prefix' => '',
		);
		set_cookie($cookie);
		
		$data['displayoffer'] = $this->ad->get_display_offer_in_zonepage($zoneId); 
		$data['zone_pref_setting']=$this->sales_zone->get_default_settings_in_zone($zoneId,'directory');
		$data['count_banner']= 0;
		$data['sponsor_ad_text'] = $this->ads->sponsorshiptext($zoneId);
		$data['zone'] = $this->sales_zone->get_zone($zoneId);
		$data['get_adid']=$adid; 
		$data['from_sharing']=$s; 
		$data['session_usertype']=$session_usertype; 
		$data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;
		$data['session_session_normal_user_type']=$session_session_normal_user_type;
		$data['session_session_type']=$session_type;
		$data['session_session_type_id']=$session_type_id;
		$data['req_url']=$req_url;
		$scripts = array("assets/scripts/jquery-1.7.2.min.js");
		$data['scripts'] = $scripts; 
		$data['aid'] = $aid; 
		$data['user_type']  =  $this->session->userdata("session_login_details");
		$data['snapDiningData']   = '';
		$data['zone_local_stores'] = $this->sales_zone->get_active_local_stores_zone($zoneId);
		$data['zone_real_estates'] = $this->sales_zone->get_active_real_estates_zone($zoneId);
		$data['zone_autos'] = $this->sales_zone->get_active_autos_zone($zoneId);
		$data['activeBanner'] = $this->banner->active_banner($zoneId,'directory');
		$this->load->view('directory', $data);
	}
	
	public function home(){  //pending
		redirect('refresh');
	}

	public function about(){  //pending
		echo $this->load->view('includes/about');  
	}
	
	public function benefits(){  //pending
		$data['link_path']= $this->config->item('link_path');
		$data['base_url'] = $this->config->item('base_url');	
		echo $this->load->view('includes/benefits', $data, TRUE);  
	}
	
	public function about_us(){  //pending
 		$data = array();
		$zoneid = $_REQUEST['zone_id'];
		if (empty($zoneid)){
			$zoneid = $_SESSION['ssZone'];
		}
		
		if (empty($zoneid)){
          	$uri = $_SERVER['REQUEST_URI'];
		    $parts = explode('/', $uri);
		    $zoneid = $parts[3]; 
       	}
		
		$data['zoneid'] = $zoneid;
		$zone= $this->zone_model->get_zone($zoneid);
		$data['announcements'] = $this->org_model->get_announcements_by_zone($zoneid,0,10); 
		$data['zone_owner'] = $this->ion_auth->user($zone->sales_rep_id)->row();
		$data['link_path']= $this->config->item('link_path');
		$data['base_url'] = $this->config->item('base_url');
		$zone_logo = $this->banner->getZonelogo($zoneid);
		$data['zone_logo'] = $zone_logo['image_name'];
		$data['about_us'] = 'hide';
		$auser = $this->ion_auth->user()->row();
		$data["user_id"] = $auser->user_id;
		$data["email"] = $auser->email; 
		$data["firstName"] = $auser->first_name;
		$data["lastName"] = $auser->last_name;
		$zone_details = $this->sales_zone->get_zone($zoneid);  
		$zone_name=$zone_details->seo_zone_name;
		$zone_name=str_replace(' ','-',htmlentities(urldecode($zone_name)));
		$data['zone_name'] = $zone_name;
		$data['user_type'] = $this->session->userdata("session_login_details");
		
		if ($this->session->userdata('session_normal_user_in_zone')!='') {
			$session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype'];
		} else{
			$session_session_normal_user_type='';
		}
		
		$data['session_session_normal_user_type']=$session_session_normal_user_type;
		$data['adid'] = '';
		$data['deal_title'] = '';
		$theme_color = $this->sales_zone->changeTheme("all",$zoneid);
		$data['theme'] = (strlen($theme_color->theme_color)!=0)? $theme_color->theme_color :"blue";
		$data['page'] 	= 'Old Glory';
		$data['currentpage']   = 'about_us'; 
		$data['css']            = 'style';
		$data['head'] 			= $this->load->view("includes/head",$data); 
		$data['header'] 			= $this->load->view("includes/header",$data); 
		$data['directory'] 		= $this->load->view("includes/benefits",$data);
		$data['slider'] 		= $this->load->view("includes/about_slider", $data);
		$data['footer'] 		= $this->load->view("includes/footer", $data);
		$data['modals'] 		= $this->load->view("includes/modals",$data);
	}
	
	public function my_account(){
		$zoneId = $this->CommonController->redirectToBusiness();
		$residentshareurl = $this->myconfig->residentshareurl;
		$session_session_normal_user_type = '';
		$url = $_SERVER['REQUEST_URI'];
	    $url = explode('/', $url);
    	if($zoneId){
            $zoneId = $zoneId;
		}else{
            $zoneId = $url[3];
		}
		$auser = $this->ionAuth->user()->row();
		if(!empty($auser)){ 
	   		$uid = $auser->id;
	   		$loginzoneid = $auser->Zone_ID;
	  	} 
    	if (empty($uid)) {
    		return redirect()->to(base_url().'/zone/'.$zoneId.'/');
    	}
		$header = 'residentloginheader';
		$footer = 'residentfooter';

		$page = 'Old Glory';
		$theme_color = $this->SalesZone->changeTheme("all",$zoneId);
		$zone= $this->Zone_model->get_zone($zoneId);
		$theme = (strlen($theme_color->theme_color)!=0)? $theme_color->theme_color :"blue";
		$zone_logo = $this->Banner_model->getZonelogo($zoneId);
		$announcements = $this->Organization_model->get_announcements_by_zone($zoneId,0,10); 
		$zone_logo = $zone_logo['image_name'];
		$zone_details =  $this->SalesZone->get_zone($zoneId);
		$zone_name=$zone_details->seo_zone_name;
		$zone_name=str_replace(' ','-',htmlentities(urldecode($zone_name)));
		$zone_owner = $this->ionAuth->user($zone['sales_rep_id'])->row();
		$user_id = $auser->user_id;
		$email = $auser->email;
		$firstName = $auser->first_name;
		$lastName = $auser->last_name;
		$user_name = $auser->username;
		$referralCode =  $this->SalesZone->get_referral_resident_code($auser->user_id);
		$check_zone_logo = $this->Banner_model->checkZonelogo($zoneId);

		if ($this->CommonController->getSession('session_normal_user_in_zone') !='') {
			$session_normal_user_in_zone_arr=$this->CommonController->getSession('session_normal_user_in_zone');
			$session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype'];
		}
		if(!empty($auser)){ 
			$session_login_details = $this->CommonController->getSession('session_login_details');
			$user_type = $this->CommonController->getSession('session_login_details');
			$user_id = $session_login_details['id'];
		}
		return view('/zone/my_account',array('zoneid' => $zoneId,'zone_id' => $zoneId,'zone_name' => $zone_name,'theme' => $theme,'header' => $header,'footer' =>$footer,'zone_logo' => $zone_logo,'session_session_normal_user_type' => $session_session_normal_user_type,'user_id' =>$user_id,'email' => $email,'firstName' =>$firstName,'lastName' => $lastName,'user_name' => $user_name,'page' => $page,'zone_owner' => $zone_owner,'announcements' => $announcements,'user_type' => $user_type,'referralCode' => $referralCode,'check_zone_logo'=>$check_zone_logo,'residentshareurl'=>$residentshareurl));
	}
	
	public function to_advertise(){  //pending
		$data['link_path']= $this->config->item('link_path');
		$data['base_url'] = $this->config->item('base_url');
		echo $this->load->view('includes/to_advertise', $data, TRUE);  
	}
	
	public function advertise(){  //pending
		$data['link_path']= $this->config->item('link_path');
		$data['base_url'] = $this->config->item('base_url');
		echo $this->load->view('includes/home/advertise', $data, TRUE); 
	}
	
	public function organization(){  //pending
		$data['link_path']= $this->config->item('link_path');
		$data['base_url'] = $this->config->item('base_url');
		$zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$data['zoneid'] = $zone_id;
		if ($this->ion_auth->logged_in()){ 
			$auser = $this->ion_auth->user()->row();
			if(!empty($auser)){ 
				$data["user_id"] = $auser->user_id;
			}
			$data['user_type'] 	= $this->org_model->getUserTypebyId($data["user_id"]);
		}
		$data['active_org'] 	= $this->org_model->get_all_active_org_list_except_highschool($zone_id);
		echo $this->load->view('includes/local_org', $data, TRUE);
	}
	
	public function hs_sports(){  //pending
		$data['link_path']= $this->config->item('link_path');
		$data['base_url'] = $this->config->item('base_url');
		$zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$data['zoneid'] = $zone_id;
		$data['active_hssport'] 	= $this->org_model->get_highschool_org_details($zone_id);
		echo $this->load->view('includes/hs_sports', $data, TRUE);  
	}
	
	public function grocery(){  //pending
		$data['link_path']= $this->config->item('link_path');
		$data['base_url'] = $this->config->item('base_url');
		$zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$data['zoneid'] = $zone_id;
		$data['grocery'] = $this->sales_zone->get_grocery($zone_id);
		echo $this->load->view('includes/grocery', $data, TRUE);
	}
	
	public function changetheme(){  //pending
		$sstheme_cookie  = array(
			'name'   => 'sstheme',
			'value'  => $_REQUEST['theme'],
			'expire' => time()+86500,
			'domain' => '',
			'path'   => '/', 
			'prefix' => '',
		);
		$sstitle_cookie  = array(
			'name'   => 'sstitle',
			'value'  => $_REQUEST['title'],
			'expire' => time()+86500,
			'domain' => '',
			'path'   => '/',
			'prefix' => '',
		);
		
		set_cookie($sstheme_cookie);
		set_cookie($sstitle_cookie);
	}

	public function contactus(){  //pending
    	$data = array();
		$zoneid = $_REQUEST['zone_id'];
		if (empty($zoneid)){
			$zoneid = $_SESSION['ssZone'];
       	}
       	if (empty($zoneid)){
          	$uri = $_SERVER['REQUEST_URI'];
		    $parts = explode('/', $uri);
		    $zoneid = $parts[3]; 
       	}
		
		$data['zoneid'] = $zoneid;
		$zone= $this->zone_model->get_zone($zoneid);
		$data['announcements'] = $this->org_model->get_announcements_by_zone($zoneid,0,10); 
		$data['zone_owner'] = $this->ion_auth->user($zone->sales_rep_id)->row();
		$data['link_path']= $this->config->item('link_path');
		$data['base_url'] = $this->config->item('base_url');
		$zone_logo = $this->banner->getZonelogo($zoneid);
		$data['zone_logo'] = $zone_logo['image_name'];
		$auser = $this->ion_auth->user()->row();
		$data["user_id"] = $auser->user_id;
		$data["email"] = $auser->email; 
		$data["firstName"] = $auser->first_name;
		$data["lastName"] = $auser->last_name;
		$zone_details = $this->sales_zone->get_zone($zoneid);  
		$zone_name=$zone_details->seo_zone_name;
		$zone_name=str_replace(' ','-',htmlentities(urldecode($zone_name)));
		$data['zone_name'] = $zone_name;
		$data['user_type'] = $this->session->userdata("session_login_details");
		
		if ($this->session->userdata('session_normal_user_in_zone')!='') {
			$session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_session_normal_user_type='';
		}
		
		$data['session_session_normal_user_type']=$session_session_normal_user_type;
		$data['adid'] = '';
		$data['deal_title'] = '';
		$theme_color = $this->sales_zone->changeTheme("all",$zoneid);
		$data['theme'] = (strlen($theme_color->theme_color)!=0)? $theme_color->theme_color :"blue";
			$data['page'] 	= 'Old Glory';
		$data['currentpage']   = 'contact_us'; 
		$data['css']            = 'style';
		$data['head'] 			= $this->load->view("includes/head",$data); 
		$data['header'] 			= $this->load->view("includes/header",$data);
		$data['directory'] 		= $this->load->view("includes/contact_us",$data);
		$data['footer'] 		= $this->load->view("includes/footer", $data);
	}
	public function set_session(){ //pending
		$session_type_from_zone = array(
			'zone_type'=>$_REQUEST['type'],
			'session_zonid'=>$_REQUEST['session_zonid']
		);
		$this->session->set_userdata('session_'.$_REQUEST['type'],$session_type_from_zone);
		echo 1;
	}
	
	public function set_session_pbg(){ //pending
		$callback ='mycallback'; 
		$response_arr = array();
		$session_type_from_zone = array(
			'zone_type'=>$_REQUEST['type'],
			'session_zonid'=>$_REQUEST['session_zonid']
		);
		
		$this->session->set_userdata('session_'.$_REQUEST['type'],$session_type_from_zone);
		$response_arr[0]= 1;
		echo $callback.'(' . json_encode($response_arr) . ')';
	}
	
	public function change_status_type(){  //pending
		$user_id=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
		$zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$createdby_id=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;
		$type=!empty($_REQUEST['type']) ? $_REQUEST['type'] : 0;
		$status=!empty($_REQUEST['status']) ? $_REQUEST['status'] : 0; 
		$adid=!empty($_REQUEST['adid']) ? $_REQUEST['adid'] : 0;		
		$result = $this->ad->ad_to_favourites($adid, $user_id, $zone_id, $status);
		echo $result;
	}
	public function offfernewpage(){
		return view('offfernewpage');
	}
	
	public function my_deal($dealid,$zoneid,$busid,$adid,$userid = ''){
		return redirect()->to(base_url().'/business/businessdetail/'.$busid.'/'.$zoneid.'?adid='.$adid.'&dealid='.$dealid.'&userid='.$userid.'');
		$zone= $zoneid;
		$business = $busid;
		$adid = $adid;
		$dealid = $dealid;
		$business_name = $bsname = $business_id = $meta_business_image_type = $description = $user_id = $email = $firstName = $lastName = $user_name =  '';
		if($dealid!=''){
			$fetch_id="SELECT * FROM ads WHERE id=".$adid."";  
			$adid = $this->CommonController->SelectRawquery($fetch_id,'row');
			$adidid = $adid->id;

			$zonequery="SELECT * FROM sales_zone WHERE id=".$zoneid."";  
			$zone_name = $this->CommonController->SelectRawquery($zonequery,'row')->name;  
			
			if(!empty($adidid)){
				$meta_tag_details = $this->ionAuth->meta_tag_details($adidid);
				$meta_tag_image = $this->ionAuth->meta_tag_image_details($adidid);
				if(!empty($meta_tag_details)){ 
					if($meta_tag_details[0]['deal_title']!=''){
						$data['business_name']=$meta_tag_details[0]['deal_title'];
						$bsname = $meta_tag_details[0]['business_name'];
						$zone_name = $zone_name;
						$business_id = $meta_tag_details[0]['business_id'];
					}else
						$business_name = $meta_tag_details[0]['business_name'];	
					
					$bs_logo = $this->Business->business_logo($meta_tag_details[0]['business_id']);
					if ($bs_logo->bs_logo) {		
						$data['meta_business_image'][0] = ''.base_url().''.$bs_logo->bs_logo;
					}elseif (isset($meta_tag_image[0]['image_name']) && $meta_tag_image[0]['image_name'] != ''){
						$data['meta_business_image'][0] = base_url().'uploads/businessphoto/'. $meta_tag_details[0]['business_id'] .'/'. $meta_tag_image[0]['image_name'];
					}else {
						$data['meta_business_image'][0]= base_url()."assets/directory/images/ss-share-logo.jpg";
					}
					
					$image_type ='';// getimagesize($data['meta_business_image'][0]);
					
					// if ($image_type[0] < 200 || $image_type[1] < 200 ) {
					// 	$data['meta_business_image'][0]= base_url()."assets/directory/images/ss-share-logo.jpg";
					// }
					
					$meta_business_image_type = '';//$image_type['mime'];
					$description=$meta_tag_details[0]['description'];
					$description = urldecode(strip_tags($description));  
				}
			}
			
			$ad_dealtitle = $adid->deal_title;
		}
		
		$adlist = $this->Ads_model->get_requested_ad($zone,$ad_dealtitle);  
 		if(isset($zone)){
			$zone = trim($zone);
		}else{
			$modified_url=base_url();	
			redirect($modified_url, 'location', 301);
		}
		
		if(!is_numeric($zoneid)){  
    		$zone_details = $this->SalesZone->get_zone_by_seo_name(str_replace(' ','-',$zoneid));  
			$zoneid = $zone_details->id;
			$zonename = $zone_details->seo_zone_name;  
			$zone_name = str_replace('-',' ',$zonename);
			$display_zone_details = $this->SalesZone->get_zone($zoneid);
			$display_zone_name = $display_zone_details->name;
			$zone_logo = $display_zone_details->image_name;	
		}else{ 
			$zone_details = $this->SalesZone->get_zone($zoneid);  
			$zoneid =$zone;
			$zone_name=$zone_details->seo_zone_name;
			$zone_name=str_replace(' ','-',htmlentities(urldecode($zone_name)));
			$display_zone_name = $zone_details->name;
			$zone_logo = $zone_details->image_name;	
			
			// if($this->uri->segment(2,0)=="zone" && is_numeric($zoneid)){
			// 	if($this->uri->segment(3,0)==$zoneid){
			// 		$modified_url=str_replace('zone/'.$zoneid,'zone/'.$zone_name,current_url());
			// 		redirect($modified_url, 'location', 301);
			// 	}
			// }
		}
		if($this->ionAuth->loggedIn()){ 
			$auser = $this->ionAuth->user()->row();
			if(!empty($auser)){ 
				$this->CommonController->setSession('get_email', $auser->email);
				$user_id = $auser->user_id;
				$user_name = $auser->username;
				$email = $auser->email; 
				$firstName = $auser->first_name;
				$lastName = $auser->last_name;
				$this->CommonController->SetCookie('user_id',$user_id,time()+86500,'','/','','email');
			}
		}

		$user_type = $this->CommonController->getSession('session_login_details');
		
		
		
		$theme 	= "blue"; 
		$page = 'Old Glory'; 
		if($this->CommonController->getCookie('sstheme')){
			$theme = $this->CommonController->getCookie('sstheme');
			$page = $this->CommonController->getCookie('sstitle');
		}
		$active_banner_mobile 	= $this->Banner_model->active_banner_desktopmobile($zoneid,'','1','2');
		$active_banner_desktop = $this->Banner_model->active_banner_desktopmobile($zoneid,'','1','1');
		$displayoffer = $this->Ads_model->get_display_offer_in_zonepage($zoneid);
		$get_zone_cms = $this->Category_new_model->checkExistcms($zoneid);
		$get_local_store = $this->Category_new_model->getLocalStore($zoneid);
		$addlist = $this->Ads_model->show_popup($adidid, $zoneid); 
		return view('short_url',array('business_name' => $business_name,'bsname' => $bsname,'zone_name' => $zone_name,'business_id' => $business_id,'data' => $data,'meta_business_image_type' => $meta_business_image_type,'description' => $description,'user_id' => $user_id,'user_email' => $email,'first_name' => $firstName,'last_name' => $lastName,'user_type' => $user_type,'zoneid' => $zoneid,'zone_name' => $display_zone_name,'zone_logo' => $zone_logo,'theme' => $theme,'page' => $page,'active_banner_mobile' => $active_banner_mobile,'active_banner_desktop' => $active_banner_desktop,'displayoffer' => $displayoffer,'get_zone_cms' => $get_zone_cms,'get_local_store' => $get_local_store,'addlist' => $addlist,'adid' => $adidid,'deal_title' => $ad_dealtitle,'user_name' => $user_name));
     }

    public function refer_generate_mail(){
		$type = $_REQUEST['type']?$_REQUEST['type']:'';
		$email = $_REQUEST['email']?$_REQUEST['email']:'';
		$code = $_REQUEST['code']?$_REQUEST['code']:'';
		$fromemail="donotreply@hgd.deals";
		$subject = 'Did you sign up yet for this new service?';
		$message = '<div style="color:#000;background: #fff;width: 70%;margin: 50px auto;padding: 11px;border: 1px solid #ccc;font-size: 14px;line-height: 26px;box-shadow: 0px 1px 11px rgb(111 110 122 / 52%);"><div style="text-align: center;background: #f2f2f2;padding: 17px;margin-bottom: 20px"><img style="width: 240px;" src="https://cdn.savingssites.com/logo-green.png"/></div>
		     <p>Check out this website:<a href="'.base_url().'?refer='.$code.'" style="text-decoration:none">'.base_url().'</a></p>

		       <p>Digital Deals! Huge savings from thousands of local businesses.  The deals are like 50% discount, but the number of deals is very limited, so jump on it! $5 extra discount for first-time use of each business. You get to pay the business directly the substantially discounted price at the time of the online order or at the business. No expiration.</p>

				<p>Activities & Entertainment!. Searchable database of content from Municipalities, Schools, Nonprofits, and Businesses.</p>

				<p>Municipal Alerts:  Timely emergency and general info is provided in such a way that the municipalities are no longer required by law to disclose residents email addresses.</p>

				<p>Your Favorite Nonprofit Benefits:  You only choose your favorite nonprofit. Then, you gain access to these digital deals on your phone by donating only a small part of the discount. So, you actually “save by giving” to your chosen favorite non-profit—Win!-Win!</p>

				<p>You have to see it! It’s like a Digital Town Newspaper and a Savings Directory.</p>

				<div style="width: 100%;float: left;text-align:center;margin: 10px 0px;"><button style="background: #5c8a47;border: 1px solid #5c8a47;box-shadow: none;padding: 8px 30px;color: #fff;text-transform: uppercase;font-size: 14px;font-weight: bold;line-height: 20px;border-radius: 0;"><a style="text-decoration:none;color:#fff;" href="'.base_url().'?refer='.$code.'">Click here</a></button></div>

				<p>Take Care!</p></div>';
			$res = $this->CommonController->SendMail($fromemail,$email,$subject,$message);	
			
			return $res;
		}

	public function qr_generate_email(){
		$email = $_REQUEST['email']?$_REQUEST['email']:'';
		$user_id = $_REQUEST['user_id']?$_REQUEST['user_id']:'';
		$qrqry = "SELECT * FROM users where id ='".$user_id."'";
        $qrArr = $this->CommonController->SelectRawquery($qrqry);
        $QR_Image = isset($qrArr[0]['qrimage'])?$qrArr[0]['qrimage']:'';
		$fromemail="donotreply@hgd.deals";
		$subject = 'Did you sign up yet for this new service?';
		
		$message = '<!DOCTYPE html>
			<html>
				<head>
					<meta charset="utf-8">
					<meta name="viewport" content="width=device-width, initial-scale=1">
					<title>QR Code Savingssites</title>
				</head>
				<body>
					<div style="width:90%;margin:auto;">
						<div style="color:#000;background: transparent;width: 100%;margin: 50px auto;padding: 11px;border: 1px solid #ccc;font-size: 14px;line-height: 26px;box-shadow: 0px 1px 11px rgb(111 110 122 / 52%);"">
							<div style="text-align: center;padding: 17px;margin-bottom: 20px"><img style="width: 240px;"" src="https://cdn.savingssites.com/logo-green.png"/>
							</div>	
							<h3>SCAN QR Code</h3>
							<img style="width:90%;margin:auto;" src="https://cdn.savingssites.com/'.$QR_Image.'"/>
							<div style="background: #000;color: #fff;text-align: center;padding: 1px 0 1px;line-height: 0;margin-top: 15px;font-size:12px !important;"><p>© "'.date("Y").'" SS Businesses Search . All Rights Reserved.</p></div>
						</div>
					</div>
				</body>
			</html>';
		$res = $this->CommonController->SendMail($fromemail,$email,$subject,$message);
		$msg = ['msg'=>'Email Not Send','type'=>'warning'];
		if($res == 1){
			$msg = ['msg'=>'Email Send Successfully','type'=>'success'];
		}	
		echo $res;
		die;
	}
	
	public function new_email_offer(){   //pending
		$adId = $_POST['adId'];
		$emailAddress = $_POST['emailAddress'];
		session_start();
		$message_status = 1 ;
		$recArr = array();
		if(!empty($adId) && $adId > 0){
			$sql="select t1.adtext,t1.deal_description,t1.textmeoffer,t1.adtext,t1.id,t1.deal_title, t2.name as biz_name, t2.contactfirstname, t2.contactlastname, t2.contactemail , t3.zoneid from ads as t1 inner join business as t2 on t1.business_id = t2.id
				inner join ad_to_zone as t3 on t1.id = t3.adid where t1.id = ". $adId;
			$query = $this->db->query($sql);
			$result = $query->row();
			$result1=$query->row('id');
			$deal_description = !empty($result->deal_description) ? $result->deal_description : '';
			$adtext = !empty($result->adtext) ? $result->adtext : '';
			$url_details = $this->ion_auth->meta_tag_details($result1);  
			if(!empty($url_details)){
				if($url_details[0]['deal_title']!=''){
					$data=array();
					$data['business_name']=$url_details[0]['deal_title'];
					$data['bsname']=$url_details[0]['business_name'];
					$data['business_id']=$url_details[0]['business_id'];
				}
			}

            $deal_link = base_url().'short_url/index.php?deal_title='.$result->deal_title;
			if($message_status == 1){
				$ad_text=urldecode(stripslashes(str_replace("&nbsp;"," ",$deal_description)));
				$fromemail=$this->config->item('adminEmailId');
				$email_subject=stripslashes($result->biz_name) . " Special Offer";
				
				if($deal_description!=''){
					$message_body= '<body style="background-color:#FFF;font-family:Arial,Helvetica,sans-serif">
						<div style="width:960px;margin:0 auto!important">
						<div style="background-color:#f2f2f2;border-radius:4px;width:650px;margin:5px auto;padding:15px">
						<div style="background-color:#3f3f3f;height:70px"><img src="'.base_url('assets/images/logo_white.png').'" style="margin:10px 202px" alt="logo"/></div>
						<div style="clear:both"></div>
						<div style="background-color:#FFF;margin-top:10px;margin-bottom:10px;min-height:300px;padding:15px">
							<h2 style="text-align:left">Dear'." ".$emailAddress.'</h2><br><h3 style="text-align:left;display:block;color:#666">Below is the deal email you requested</h3><br>
							<h3><p style="text-align:left;display:block;color:#333">Posted By: '." ".stripslashes($result->biz_name) .'</p></h3>
							<h3><p style="text-align:left;display:block;color:#333">To see the Deal '.'<a target="_blank" href="'.$deal_link.'">CLICK HERE</a></p></h3><h3 style="text-align:left;display:block;color:#666">DEAL DESCRIPTION: </h3>
							<p style="text-align:left;display:block;color:#333"><h3 style="text-align:left">' .$ad_text.'</h3></p>
						</div>
						<div style="background-color:#999;height:60px"></div></div></div></body>';
				}else{
					$message_body= '<body style="background-color:#FFF;font-family:Arial,Helvetica,sans-serif">
						<div style="width:960px;margin:0 auto!important">
						<div style="background-color:#f2f2f2;border-radius:4px;width:650px;margin:5px auto;padding:15px">
						<div style="background-color:#3f3f3f;height:70px"><img src="'.base_url('assets/images/logo_white.png').'" style="margin:10px 202px" alt="logo"/></div>
						<div style="clear:both"></div>
						<div style="background-color:#FFF;margin-top:10px;margin-bottom:10px;min-height:300px;padding:15px"><h2 style="text-align:left">Dear'." ".$emailAddress.'</h2><br><h3 style="text-align:left;display:block;color:#666">Below is the deal email you requested</h3><br>
						<h3><p style="text-align:left;display:block;color:#333">Posted By: '." ".stripslashes($result->biz_name) .'</p></h3>
						<h3><p style="text-align:left;display:block;color:#333">To see the Deal '.'<a target="_blank" href="'.$deal_link.'">CLICK HERE</a></p></h3></div>
						<div style="background-color:#999;height:60px"></div></div></div></body>';
				}
				$this->load->library('email');
				$this->email->clear();
				$this->email->from($fromemail);
				$this->email->subject($email_subject);
				$this->email->message($message_body);
				
				if($emailAddress!=''){
					$this->email->to($emailAddress);
					$this->email->send();
					$to[]=$emailAddress;
				}
				
				$message = "Successfully Sent!";
				$recArr['message'] = $message;
				$recArr['get_login_details'] = $url_details;
			}else{
				$message = "Message not sent, Wrong Captcha!";
			}
			echo json_encode($recArr);
		}
	}
	
	public function load_debug($zone=false,$business=false,$adid=false,$s=''){     //pending
		if(isset($zone)){
			$zone = trim($zone);
		}
		$zone=!empty($zone) ? htmlentities(urldecode($zone)) : 0;
		$data = array();
		
		if(strpos(current_url(),'zone/load/')!=false){ 
			if($this->uri->total_segments()==4)			
				$modified_url=base_url("zone/".$this->uri->segment(3, 0)."/business/".$this->uri->slash_segment(4,'leading'));
			else if($this->uri->total_segments()==3)	
				$modified_url=base_url("zone/".$this->uri->segment(3, 0)."/");
			else if($this->uri->total_segments()==2)	
				$modified_url=base_url();	
			redirect($modified_url, 'location', 301);
		}
		
		$link_path = $this->config->item('link_path'); 
		if($link_path==''){ 
			if($this->uri->total_segments()==4)
				$data['link_path']= "../../../../";
			else if($this->uri->total_segments()==3)
				$data['link_path']= "../../../"	;
			else if($this->uri->total_segments()==2)
				$data['link_path']= "../../";		
		}else{
			$data['link_path']= $link_path ; 
		}
		
		if(!is_numeric($zone)){  
         	$zone_details = $this->sales_zone->get_zone_by_seo_name(str_replace(' ','-',$zone));  
			$zoneId =$zone_details->id;
			$zone_name=$zone_details->seo_zone_name;  
			
			if($zoneId!=''){
				$count_num = $this->sales_zone->get_bcs_count_for_zone($zoneId);
				$data['bcs_count'] = number_format($count_num);	 
			}else{
				$modified_url=base_url();	
				redirect($modified_url, 'location', 301);
			}
		}else{  
			$zone_details = $this->sales_zone->get_zone($zone);
			$zoneId =$zone;
			$zone_name=$zone_details->seo_zone_name;
			$zone_name=str_replace(' ','-',htmlentities(urldecode($zone_name)));
			if($this->uri->segment(1,0)=="zone" && is_numeric($zone)){
				if($this->uri->segment(2,0)==$zoneId){
					$modified_url=str_replace('zone/'.$zoneId,'zone/'.$zone_name,current_url());
					redirect($modified_url, 'location', 301);
				}
			}
		}
		
		if(!empty($adid)){	 
			if(is_numeric($adid)){
				$data['deal_title']=preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ', '-',htmlentities(urldecode($adid))));	
				$data['deal_title_ad_id']=$adid; 
				$data['deal_title_type']="insert_deal_title";
			}else{	
				$data['deal_title']=preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ', '-',htmlentities(urldecode($adid))));	
			}
		}
		
		$data['adid']=$adid;
		if($this->session->userdata('session_usertype')!=''){
			$session_usertype_arr=$this->session->userdata('session_usertype');
			$session_usertype=$session_usertype_arr['usertype']; 
		}else{
			$session_usertype='';
		}
		
		if($this->session->userdata('session_normal_user_in_zone')!=''){
			$session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_session_normal_user_in_zone=$session_normal_user_in_zone_arr['sesuserzone'];
			$session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype']; 
		}else{
			$session_session_normal_user_in_zone='';
			$session_session_normal_user_type='';
			$session_type='';
			$session_type_id='';
		}
		
		if($this->session->userdata('usersessiondata')!=''){ 			
			$session_type_arr=$this->session->userdata('usersessiondata');
			$session_type=$session_type_arr['usergrid'];
		}else if($this->session->userdata('session_normal_user_in_zone')!=''){
			$session_type_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_type=$session_type_arr['sesusertype']; 
		}else{
			$session_type=''; $session_type_id=''; $req_url='';
		}

		if($session_type==4){
			$session_type_id=$session_type_arr['userzoneid'];
			$req_url=base_url().'dashboards/zone/'.$session_type_id;
		}else if($session_type==5){
			if($this->session->userdata('session_zoneid_from_bus')!=''){ 			
				$session_type_arr=$this->session->userdata('session_zoneid_from_bus');
				$session_type_id=$session_type_arr['busid'];
				$session_type=$session_type_arr['type'];
				if($session_type=='business'){
					$req_url=base_url().'dashboards/business/'.$session_type_id;
				}else if($session_type=='listed'){
					$req_url=base_url().'auth/listed_business_verification/'.$session_type_id;
				}
			}
		}else if($session_type==8){
			if($this->session->userdata('session_orgid')!=''){ 			
				$session_type_arr=$this->session->userdata('session_orgid');
				$session_type_id=$session_type_arr['sesorgid'];
				$req_url=base_url().'dashboards/organization/'.$session_type_id;
			}
		}else if($session_type=='resident_user'){
			$session_type_id=$session_type_arr['sesuserzone'];
			$req_url=base_url().'index.php?zone='.$session_type_id;
		}
		
		if(is_numeric($adid)){ 
			$ad_dealtitle = urldecode($adid);
			$fetch_id="SELECT * FROM ads WHERE deal_title='$ad_dealtitle'";
			$ads_id=$this->db->query($fetch_id);
			$aid=$ads_id->row('id');                            
			if(!empty($aid)){
				$meta_tag_details = $this->ion_auth->meta_tag_details($aid);
			}else{
				$modified_url=base_url().'zone/'.$zone.'/'.$business.'/';
				redirect($modified_url, 'location', 301);
			}
			
			if(!empty($meta_tag_details)){ 
				if($meta_tag_details[0]['deal_title']!=''){ 
					$data['business_name']=$meta_tag_details[0]['deal_title'];
					$data['bsname']=$meta_tag_details[0]['business_name'];
					$data['zone_name']=$zone_name;
					$data['business_id']=$meta_tag_details[0]['business_id'];
				}else
					$data['business_name']=$meta_tag_details[0]['business_name'];
			
				$ckeditor_img = '';
				preg_match( '@src="([^"]+)"@' , $meta_tag_details[0]['image'], $match );
				$image = array_pop($match); 
				if(!empty($image)){
					$ckeditor_img= $image; 
				}
				
				if($ckeditor_img != ''){  
					$data['meta_business_image'][0] = $ckeditor_img;
				}else{
					$data['meta_business_image'][0]="http://savingssites.com/assets/images/slides/slide-1_fb.jpg";
				}
				
				$description=$meta_tag_details[0]['description'];
				$data['description']=urldecode(strip_tags($description));   
			}	 	
		}else if(!is_numeric($adid) && $adid !=''){  	
			$businessname = urldecode($business) ;
			$ad_dealtitle = urldecode($adid);  	
			$fetch_id="SELECT * FROM ads WHERE deal_title='$ad_dealtitle'"; 
			$ads_id=$this->db->query($fetch_id); 
			$aid=$ads_id->row('id'); 
			if(!empty($aid)){
				$meta_tag_details = $this->ion_auth->meta_tag_details($aid);
			}else{
				$modified_url=base_url().'zone/'.$zone.'/'.$business.'/';
				redirect($modified_url, 'location', 301);
			}
			
			$meta_tag_details = $this->ion_auth->meta_tag_details($aid);
			if(!empty($meta_tag_details)){  
				if($meta_tag_details[0]['deal_title']!=''){
					$data['business_name']=$meta_tag_details[0]['deal_title'];
					$data['bsname']=$meta_tag_details[0]['business_name'];
					$data['zone_name']=$zone_name;
					$data['business_id']=$meta_tag_details[0]['business_id'];
				}else
					$data['business_name']=$meta_tag_details[0]['business_name'];
				
				$ckeditor_img = '';
				preg_match( '@src="([^"]+)"@' , $meta_tag_details[0]['image'], $match );
				$image = array_pop($match);
				if(!empty($image)){
					$ckeditor_img= $image;
				}
				
				if($ckeditor_img != ''){
					$data['meta_business_image'][0] = $ckeditor_img;
				}else{
					$data['meta_business_image'][0]="http://savingssites.com/assets/images/slides/slide-1_fb.jpg";
				}
				
				$description=$meta_tag_details[0]['description'];
				$data['description']=urldecode(strip_tags($description));
			}
		} 
		
		if($this->session->userdata('session_normal_user_in_zone')!=''){
			$session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_session_normal_user_in_zone=$session_normal_user_in_zone_arr['sesuserzone']; 
		}else{
			$session_session_normal_user_in_zone='';
		}		
		
		if($adid == ''){
			$data['home_url']=current_url();
		}else{
			$data['home_url']=base_url()."zone/".$zone;
		}	    

		$data['home_url']=current_url();
		$data['where_from']='';
		$data['zone_type']=$zone ;
		$data['zone_owner_new'] = array();
		$data['zone_id'] = $zoneId;
		$data["user_id"]='';
		$data['uid_admin']='';
		$data['login_from_mail']='';
		$data['userid_for_registration']='';		
		
		if(empty($zoneId)){  
			$data['class']="home";

			if ($this->ion_auth->logged_in()){
				$auser = $this->ion_auth->user()->row();
				$data['user'] = $auser;
				$data['userid_zone']=$auser->id;
				if(!empty($auser)){
					$data["email"] = $auser->email;
					if($auser->first_name!=''){
						$data["firstName"] = $auser->first_name;
					}else{
						$data["firstName"] = $auser->username;
					}
					$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";
					$uid = $auser->id;
					$data['zone_owner_new'] = $this->business->get_zone_byuser($uid);
					$data['business_owner_new'] = $this->business->business_owner_user($uid);
				}
			}
			
			$data['content']=$this->load->view("default/show_content_home",$data,TRUE);		
			$this->load->view("default/default_content", $data);
			return;
		}
		
		if ($this->ion_auth->logged_in()){ 
			$auser = $this->ion_auth->user()->row();
			if(!empty($auser)){ 
				$data["user_id"] = $auser->user_id;
				$data["email"] = $auser->email; 
				$data["firstName"] = $auser->first_name;
				$data["lastName"] = $auser->last_name;
				$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";
				$data["user_id"] = $auser->id;
				$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";

				$cookie = array(
					'name'   => 'user_id',
					'value'  => $data["user_id"],
					'expire' => time()+86500,
					'domain' => '',
					'path'   => '/',
					'prefix' => '',
				);
				set_cookie($cookie);
			}
		}
		
		$theme_cookie_value=''; $zoneid_cookie_value='';
		$data['change_theme'] = $this->ad->get_display_change_theme_in_zonepage($zoneId);  
		
		if(!empty($data['change_theme'])){ 
			if($data['change_theme'][0]['ischangezonetheme']==0){
				delete_cookie("theme"); delete_cookie("zoneid");
				$theme_cookie_value=''; $zoneid_cookie_value='';
			}else{
				$theme_cookie_value=$this->input->cookie('theme_zone', TRUE);
				$zoneid_cookie_value=$this->input->cookie('zoneid_zone', TRUE); 
			}
		}

		$data['css_value']=''; $data['css_vertical_value']='';  
		if($theme_cookie_value != '' && $zoneid_cookie_value!=''){ 
			if($theme_cookie_value=='LT' && $zoneid_cookie_value==$zoneId){  
				$data['image_url'] =base_url('assets/stylesheets/light_theme');
				$data['css_value1']="assets/stylesheets/light_theme/styles.css?time=".time();
				$data['css_value2']="assets/stylesheets/light_theme/light_styles.css?time=".time();
			}else if($theme_cookie_value=='BLT' && $zoneid_cookie_value==$zoneId){ // Blue-R Theme
				$data['image_url'] =base_url('assets/stylesheets/blue_theme');
				$data['css_value1']="assets/stylesheets/blue_theme/styles.css?time=".time();
				$data['css_value2']="assets/stylesheets/blue_theme/blue_styles.css?time=".time();
			}else if($theme_cookie_value=='BRT' && $zoneid_cookie_value==$zoneId){ // Blue-R Theme
				$data['image_url'] =base_url('assets/stylesheets/brown_theme');
				$data['css_value1']="assets/stylesheets/brown_theme/styles.css?time=".time();
				$data['css_value2']="assets/stylesheets/brown_theme/brown_styles.css?time=".time();
			} else if($theme_cookie_value=='RT' && $zoneid_cookie_value==$zoneId){ // Blue-R Theme
				$data['image_url'] =base_url('assets/stylesheets/red_theme');
				$data['css_value1']="assets/stylesheets/red_theme/styles.css?time=".time();
				$data['css_value2']="assets/stylesheets/red_theme/red_styles.css?time=".time();
			} 
		}else{
			$change_theme = $this->ad->get_display_change_theme_in_zonepage($zoneId);
			if(!empty($change_theme)){
				if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='DT'){
					$data['image_url'] =base_url('assets/stylesheets/blue_theme');
					$data['css_value']="assets/stylesheets/up_styles_blue.css?time=".time();
					$data['css_value_for_blue']="assets/stylesheets/styles_blue_skin.css?time=".time();
					$data['css_vertical_value']="assets/stylesheets/blue_vertical_menu.css?time=".time();
					$data['barter_button']='blue'; $data['job_button']='blue';

				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='MT'){
					$data['image_url'] =base_url('assets/stylesheets/blue_theme');
					$data['css_value']="assets/stylesheets/styles_maroon_skin.css?time=".time();
					$data['css_vertical_value']="assets/stylesheets/maroon_vertical_menu.css?time=".time();
					$data['css_value_for_blue']="assets/stylesheets/styles_maroon_skin.css?time=".time();
					$data['barter_button']='red'; $data['job_button']='red';
				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='BT'){
					$data['image_url'] =base_url('assets/stylesheets/light_theme');;
					$data['css_value']="assets/stylesheets/up_styles_blue.css?time=".time();
					$data['css_value_for_blue']="assets/stylesheets/styles_blue_skin.css?time=".time();
					$data['css_vertical_value']="assets/stylesheets/blue_vertical_menu.css?time=".time();
					$data['barter_button']='blue'; $data['job_button']='blue';
				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='ET'){
					$data['css_value']="assets/stylesheets/style_3/styles_dark_skin.css?time=".time();
					$data['css_vertical_value']="assets/stylesheets/dark_vertical_menu.css?time=".time();
					$data['barter_button']='dark'; $data['job_button']='dark';
				} else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='RT'){
					$data['image_url'] =base_url('assets/stylesheets/red_theme');
					$data['css_value1']="assets/stylesheets/red_theme/styles.css?time=".time();
					$data['css_value2']="assets/stylesheets/red_theme/red_styles.css?time=".time();	
				} else if($change_theme[0]['ischangezonetheme']==1){
					$data['image_url'] =base_url('assets/stylesheets/red_theme');
					$data['css_value']="assets/stylesheets/red_theme/styles.css?time=".time();
					$data['css_value_for_blue']="assets/stylesheets/red_theme/red_styles.css?time=".time();
					$data['barter_button']='dark'; $data['job_button']='dark';
				}
			}
		}
		
		$data['theme_cookie_value']=$theme_cookie_value;
		$cookie = array(
			'name'   => 'zoneid',
			'value'  => $data['zone_id'],
			'expire' => time()+86500,
			'domain' => '',
			'path'   => '/',
			'prefix' => '',
		);
		set_cookie($cookie);
		
		$themeImageUrl = array(
			'name'  => 'themeImageUrl',
			'value' => $data['image_url'],
			'expire' => time() + (10 * 365 * 24 * 60 * 60),
			'domain' => '',
			'path'   => '/',
			'prefix' => ''
		);
		set_cookie($themeImageUrl);
		
		$cookie = array(
			'name'   => 'back_to_blog',
			'value'  => 2,
			'expire' => time()+86500,
			'domain' => '',
			'path'   => '/',
			'prefix' => '',
		);
		set_cookie($cookie);
		
		$cookie = array(
			'name'   => 'back_to_blog_path',
			'value'  => base_url(),
			'expire' => time()+86500,
			'domain' => '',
			'path'   => '/',
			'prefix' => '',
		);
		set_cookie($cookie);
		
		$data['displayoffer'] = $this->ad->get_display_offer_in_zonepage($zoneId); 
		$data['zone_pref_setting']=$this->sales_zone->get_default_settings_in_zone($zoneId,'directory');
		$data['count_banner']= 0;
		$data['sponsor_ad_text'] = $this->ads->sponsorshiptext($zoneId);	
		$data['zone'] = $this->sales_zone->get_zone($zoneId); 
		$data['get_adid']=$adid; 
		$data['from_sharing']=$s; 
		$data['session_usertype']=$session_usertype; 
		$data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;
		$data['session_session_normal_user_type']=$session_session_normal_user_type;
		$data['session_session_type']=$session_type;
		$data['session_session_type_id']=$session_type_id;
		$data['req_url']=$req_url;
		$scripts = array("assets/scripts/jquery-1.7.2.min.js");	
		$data['scripts'] = $scripts; 
		$data['aid'] = $aid;   
		$data['user_type']  =  $this->session->userdata("session_login_details");
		$data['snapDiningData']   = '';
		$data['zone_local_stores'] = $this->sales_zone->get_active_local_stores_zone($zoneId);
		$data['zone_real_estates'] = $this->sales_zone->get_active_real_estates_zone($zoneId);
		$data['zone_autos'] = $this->sales_zone->get_active_autos_zone($zoneId);
		$data['activeBanner'] = $this->banner->active_banner($zoneId,'directory');
		
		$this->load->view('directory', $data);
	}

    /**
		*get banner for new page without ajax
	**/
	public function get_baner($zoneId){ // //pending
		$data['active_banner']=$this->banner->active_banner($zoneId,'directory');
		$viewContent  = $this->load->view('includes/slider', $data,true);
		return $viewContent;
	}
	
	public function change_theme(){ //pending
		$zoneid=$_REQUEST['zoneid'];
		$themeid=$_REQUEST['themeid'];
		
		if (!get_cookie('')) {
			$cookie = array(
				'name'   => 'theme',
				'value'  => $themeid,
				'expire' => time()+86500,
				'domain' => '',
				'path'   => '/',
				'prefix' => '',
			);
			set_cookie($cookie);
			
			$cookie = array(
				'name'   => 'zoneid',
				'value'  => $zoneid,
				'expire' => time()+86500,
				'domain' => '',
				'path'   => '/',
				'prefix' => '',
			);
			set_cookie($cookie);
		} 
		
		$result = $zoneid;
		echo $result;
	}
		
	public function test($id){ //pending
		$data = array();
		$data['zone'] = null;
		if(!is_numeric($id)){
			$data['zone'] = $this->sales_zone->get_zone_by_name(urldecode($id));
		}else{
			$data['zone'] = $this->sales_zone->get_zone($id);
		}
		
		$zoneId = $data['zone']->id;
		$data['category_list'] = $this->category->get_category_subcategory($zoneId);
		$data["firstName"] = "";
		$data['zone_id'] = $zoneId;
		$data["email"] = "";
		$data["admin"] = "";
		$data["user_id"] = "";
		
		if ($this->ion_auth->logged_in()){
			$auser = $this->ion_auth->user()->row();
			if(!empty($auser)){
				$data["email"] = $auser->email;
				$data["firstName"] = $auser->first_name;
				$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";
				$data["user_id"] = $auser->id;
			}
		}
		$this->load->view('new_page_test', $data);
	}
	
	public function search_zone($code){ //pending
		$zones = $this->states->get_all_zone($code);
		$state = $this->states->get_states_from_code($code);
		if($zones) {?>
			<div id="for-title"><?php echo $state->name;?></div>
		<?php
		foreach($zones as $zones)
			{?>
			<div id="for-business"><a href="<?=base_url()?>index.php?zone=<?php echo $zones->id;?>"><?php echo $zones->name;?></a></div><?php
			}
		exit;
		}else{?>
			<div id="for-title"><?php echo $state->name;?></div>
			<div id="for-business">No zone founds.</div><?php 
		}
	}
	
	public function search_zone_zipcode($zip_code,$zone_radius=5){ //pending
		$zip_code_detail = $this->states->get_zip_code($zip_code,$zone_radius);
		if($zip_code_detail)
		{?>
			<div id="for-title"><?php echo $zip_code;?></div>
		<?php
			foreach($zip_code_detail as $zones)
		{?>
			<div id="for-business"><a href="<?=base_url()?>index.php?zone=<?php echo $zones->id;?>"><?php echo $zones->name;?></a></div><?php
			}
			exit;
		}else{?>	
			<div id="for-title"><?php echo $zip_code;?></div>
			<div id="for-business">No zone founds.</div><?php
		}
		exit;
	}
	
	public function search($zone = false){ //pending
		$zoneId = empty($_REQUEST['zone']) ? 99 : $_REQUEST['zone'];
		if(!empty($zone)) {
			$zoneId = $zone;
		}
		
		$data = array();
		$data["firstName"] = "";
		$data["email"] = "";
		$data["admin"] = "";
		$data["admin_tier"]='';
		$data['category_list'] = $this->category->get_category_subcategory($zoneId);
		$data['zone'] = $this->sales_zone->get_zone($zoneId);
		$data['states'] = $this->states->get_all_states_zone();
		
		if ($this->ion_auth->logged_in()){
			$auser = $this->ion_auth->user()->row();
			if(!empty($auser)){
				$data["email"] = $auser->email;
				$data["firstName"] = $auser->first_name;
				$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";
				$data["admin_tier"] = $this->ion_auth->in_group(array( "Tier I", "Tier II")) ? "yes" : "";
			}
		}else{
			redirect('zone');
		}
		$this->load->view('search', $data);
	}
	
	public function check_rating($v=0,$n=0){	 //pending
		return $v;
	}
	
	public function get_snap_ogr_in_zone($zoneid=0){ //pending
		$data = array();
		$data['zone_id']=$zoneid;
		$auser = $this->ion_auth->user()->row();
		$data['userid']=$auser->user_id;
		$data['org_list'] = $this->users->get_snap_org_in_zone($zoneid,$auser->user_id);
		$this->load->view('snap_org_details', $data);		
	}

	public function update_status_email_from_org($zoneid=false,$orgid=false,$userid=false,$status=false){  //pending
		$data = array();
		$data['zone_id']=$zoneid;
		$auser = $this->ion_auth->user()->row();
		$data['userid']=$auser->user_id;
		$data['snap_user_org_status']=$this->users->update_status_email_from_org($orgid,$userid,$status);          			
		$data['org_list'] = $this->users->get_snap_org_in_zone($zoneid,$auser->user_id);		
		$this->load->view('snap_org_details', $data);
	}
	
	public function display_snap_list_in_zone($zoneid=false){ // //pending
		$data = array();
		$data['zone_id']=$zoneid;
		$auser = $this->ion_auth->user()->row(); 
		$data['approved_bus'] = $this->users->get_all_businesses_approved_in_snap($zoneid,$auser->user_id);
		$this->load->view('snap_list_details', $data);
	}
	
	public function update_status_email_from_business($businessid,$zoneid,$userid,$status){ //pending
		$data = array();
		$auser = $this->ion_auth->user()->row();
		$data['snap_user_business_status']=$this->users->update_snap_user_business_status($businessid,$zoneid,$userid,$status);
		$data['approved_bus'] = $this->users->get_all_businesses_approved_in_snap($zoneid,$auser->user_id);				
		$this->load->view('snap_list_details', $data);
	}
	
	public function callzoneslider(){
		$data['slider'] = $this->load->view("includes/home_slider", $data);
		echo $data['slider'];
	}
	
	public function get_user_newsletter_delete($id=0){
		$this->users->delete_newsletter_user($id); 
	}
	
	public function get_user_ig($zoneid=0,$type=0){  //pending
		$data = array();
		$data['zone_id']=$zoneid;
		$auser = $this->ion_auth->user()->row(); 
		$data['approved_bus'] = $this->users->get_all_interest_group_for_user($zoneid,$auser->user_id,$type);
		if($type==2)				
			$this->load->view('ig_bus_details', $data);
		else if($type==3)
			$this->load->view('ig_org_details', $data);
	}
	
	public function get_user_ig_delete($zoneid=0,$id=0,$type=0){ //pending
		$data = array();
		$data['zone_id']=$zoneid;
		$auser = $this->ion_auth->user()->row();
		$this->users->delete_interest_group_for_user($id); 
		$data['approved_bus'] = $this->users->get_all_interest_group_for_user($zoneid,$auser->user_id,$type);
		if($type==2)				
			$this->load->view('ig_bus_details', $data);
		else if($type==3)
			$this->load->view('ig_org_details', $data);
	}
	
	public function profile_update($id=0,$fn='',$ln=''){ //pending
		$this->users->get_profile_update($id,$fn,$ln);
	}
	
	public function callslider(){ //pending
		$zoneid = $_POST['zoneId'];
		$data['zoneid'] = $zoneid;
		try{
			$data['active_banner_mobile'] 	= $this->banner->active_banner_desktopmobile($zoneid,'','1','2');
			$data['active_banner_desktop'] 	= $this->banner->active_banner_desktopmobile($zoneid,'','1','1');
			$data['slider'] = $this->load->view("includes/slider", $data);
		}catch(exception $e){
			$data['slider'] = $this->load->view("includes/home_slider", $data);
		}
		echo $data['slider'];
	}
	public function approvalcheck(){
	    $user_id = isset($_REQUEST['userid_s'])?$_REQUEST['userid_s']:0;
	    if($user_id > 0){
	    	$sql="SELECT * FROM business_deal_approval WHERE userId=".$user_id." AND via ='' AND status='A' AND showmodal=0";  
			$userapprove = $this->CommonController->SelectRawquery($sql);
			echo json_encode($userapprove);
			die;
		}
	}

	public function dontshowmodalfree5(){
	    $userid = isset($_REQUEST['userid'])?$_REQUEST['userid']:0;
	    if($userid > 0){
	    	$this->CommonController->updateData('business_deal_approval',['showmodal' => 1],['userId' => $userid]);
			echo json_encode(1);
			die;
		}
	}

	public function recoverpassword(){
     $username = isset($_GET['username'])?$_GET['username']:'';
     $usertype = isset($_GET['usertype'])?$_GET['usertype']:'';
     return view('recoverpassword', array('username'=>$username,'usertype'=>$usertype));
   }
  
    public function recover_pass_set(){
     $username = $_REQUEST['username'];
     $usertype = $_REQUEST['usertype'];
     $new_pass = $_REQUEST['new_pass'];
     $newpassword = $this->ion_auth->hash_password($new_pass);

     $this->CommonController->updateData('users',['password' => $newpassword,'uploaded_business_password'=> $new_pass],['username' => $username]);
      echo json_encode(1);
  }

}