<?php
namespace App\Controllers;
use App\Libraries\IonAuth;
use Config\MyConfig;
use App\Models\Zips;
use App\Models\admin\Sales_zone;
use App\Models\admin\Category_management_model;
use App\Models\admin\Business;
use App\Models\Organization_model;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
/**
 * Class Auth
 *
 * @property Ion_auth|Ion_auth_model $ion_auth      The ION Auth spark
 * @package  CodeIgniter-Ion-Auth
 * @author   Ben Edmunds <ben.edmunds@gmail.com>
 * @author   Benoit VRIGNAUD <benoit.vrignaud@zaclys.net>
 * @license  https://opensource.org/licenses/MIT	MIT License
 */
class Auth extends BaseController
{

	/**
	 *
	 * @var array
	 */
	public $data = [];

	/**
	 * Configuration
	 *
	 * @var \IonAuth\Config\IonAuth
	 */
	protected $configIonAuth;

	/**
	 * IonAuth library
	 *
	 * @var \IonAuth\Libraries\IonAuth
	 */
	protected $ionAuth;

	/**
	 * Session
	 *
	 * @var \CodeIgniter\Session\Session
	 */
	protected $session;

	/**
	 * Validation library
	 *
	 * @var \CodeIgniter\Validation\Validation
	 */
	protected $validation;

	/**
	 * Validation list template.
	 *
	 * @var string
	 * @see https://bcit-ci.github.io/CodeIgniter4/libraries/validation.html#configuration
	 */
	protected $validationListTemplate = 'list';

	/**
	 * Views folder
	 * Set it to 'auth' if your views files are in the standard application/Views/auth
	 *
	 * @var string
	 */
	protected $viewsFolder = 'IonAuth\Views\auth';

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->db = \Config\Database::connect();
		$this->myconfig = new MyConfig;
		$config = new MyConfig;
		$this->ionAuth    = new \IonAuth\Libraries\IonAuth();
		$this->validation = \Config\Services::validation();
		helper(['form', 'url']);
		$this->configIonAuth = config('IonAuth');
		$this->session       = \Config\Services::session();

		if (! empty($this->configIonAuth->templates['errors']['list']))
		{
			$this->validationListTemplate = $this->configIonAuth->templates['errors']['list'];
		}
		$this->email = \Config\Services::email();
		$this->session = \Config\Services::session();
		$this->SalesZone = new Sales_zone();
		$this->Category_management_model = new Category_management_model();
		$this->Business = new Business();
		$this->Zips = new Zips();
		$this->CommonController = new CommonController();
		$this->Organization_model = new Organization_model();
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function index()
	{
		if (! $this->ionAuth->loggedIn())
		{
			// redirect them to the login page
			return redirect()->to('/auth/login');
		}
		else if (! $this->ionAuth->isAdmin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			//show_error('You must be an administrator to view this page.');
			throw new \Exception('You must be an administrator to view this page.');
		}
		else
		{
			$this->data['title'] = lang('Auth.index_heading');

			// set the flash data error message if there is one
			$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');
			//list the users
			$this->data['users'] = $this->ionAuth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ionAuth->getUsersGroups($user->id)->getResult();
			}
			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'index', $this->data);
		}
	}

	public function businessdashboard_update(){
		$zone_id = (!empty($_REQUEST['zone_id']))? $_REQUEST['zone_id'] : 0;
    	$businessid = (!empty($_REQUEST['businessid']))? $_REQUEST['businessid'] : 0;
    	$biz_name = (!empty($_REQUEST['biz_name']))? $_REQUEST['biz_name'] : "";
    	$restaurant_type = (!empty($_REQUEST['restaurant_type']))? $_REQUEST['restaurant_type'] : 0;
    	$biz_motto = (!empty($_REQUEST['biz_motto']))? $_REQUEST['biz_motto'] : "";
    	$biz_about = (!empty($_REQUEST['biz_about']))? $_REQUEST['biz_about'] : "";
    	$biz_history = (!empty($_REQUEST['biz_history']))? $_REQUEST['biz_history'] : "";
    	$biz_contact_email = (!empty($_REQUEST['biz_contact_email']))? $_REQUEST['biz_contact_email'] : "";
    	$biz_contactfirstname = (!empty($_REQUEST['biz_contactfirstname']))? $_REQUEST['biz_contactfirstname'] : "";
    	$biz_contactlastname = (!empty($_REQUEST['biz_contactlastname']))? $_REQUEST['biz_contactlastname'] : "";
    	$biz_street_1 = (!empty($_REQUEST['biz_street_1']))? $_REQUEST['biz_street_1'] : "";
    	$biz_street_2 = (!empty($_REQUEST['biz_street_2']))? $_REQUEST['biz_street_2'] : "";
    	$biz_city = (!empty($_REQUEST['biz_city']))? $_REQUEST['biz_city'] : "";
    	$biz_zip_code = (!empty($_REQUEST['biz_zip_code']))? $_REQUEST['biz_zip_code'] : "";
    	$biz_zone = (!empty($_REQUEST['biz_zone']))? $_REQUEST['biz_zone'] : "";
    	$biz_state = (!empty($_REQUEST['biz_state']))? $_REQUEST['biz_state'] : "";
    	$biz_phone = (!empty($_REQUEST['biz_phone']))? str_replace("-", "", $_REQUEST['biz_phone']) : "";
    	$albiz_phone = (!empty($_REQUEST['albiz_phone']))? str_replace("-", "", $_REQUEST['albiz_phone']) : "";
    	$biz_website = (!empty($_REQUEST['biz_website']))? $_REQUEST['biz_website'] : "";
    	$service_number = (!empty($_REQUEST['service_number']))? $_REQUEST['service_number'] : "";
		$lonlngArr = $this->CommonController->getLocationLatLong($biz_zip_code);
		$address_data=array(
            'street_address_1'=>$biz_street_1,
            'street_address_2'=>$biz_street_2,
            'city'=>$biz_city,
            'state'=>$biz_state,
            'zip_code'=>$biz_zip_code,            
            'phone'=>$biz_phone, 
            'latitude'=>$lonlngArr['lat'],           
            'longitude'=>$lonlngArr['lng']           
        );

        $sql = "SELECT addressid,business_owner_id FROM `business` WHERE  id=".$businessid."";  
        $data = $this->CommonController->SelectRawquery($sql,'row');
        $addressid = $data->addressid;
        $userid = $data->business_owner_id;

		$sql = "SELECT id FROM `address` WHERE  id=".$addressid."";  
        $addata = $this->CommonController->SelectRawquery($sql,'row');
        if($addata != ''){
        	$this->CommonController->updateData('address',$address_data,['id' => $addressid]);
        }else{
        	$address_dataup=array(
                'street_address_1'=>$biz_street_1,
                'street_address_2'=>$biz_street_2,
                'city'=>$biz_city,
                'state'=>$biz_state,
                'zip_code'=>$biz_zip_code,            
                'phone'=>$biz_phone,            
                'id'=>$addressid, 
                'latitude'=>$lonlngArr['lat'],           
            	'longitude'=>$lonlngArr['lng']        
            ); 
           	$this->db->table('address')->insert($address_dataup);
        }
		
		if($albiz_phone > 0){
			$this->CommonController->updateData('users',['alternate_phone' => $albiz_phone],['id' => $userid]);	
		}
		$business_data=array(
            'contactfirstname'=>$biz_contactfirstname,
            'contactlastname'=>$biz_contactlastname,
            'contactfullname'=>$biz_contactfirstname.' '.$biz_contactlastname,
            'contactemail'=>$biz_contact_email,
            'name' => $biz_name,
            'motto' => $biz_motto , 
            'aboutus' => $biz_about, 
            'history' => $biz_history, 
            'timestamp' => time(),
            'website' => $biz_website, 
            'service_number' => $service_number,
            'name' => $biz_name,
            'type' => $restaurant_type,
        );
        $this->CommonController->updateData('business',$business_data,['id' => $businessid]);
        echo json_encode(['msg' => 'updated Successfully', 'type' => 'success']);
    }

	public function profile_update(){
        $account_type = 5;
        $id =(!empty($_REQUEST['id']))? $_REQUEST['id'] : "";       
        $zone =(!empty($_REQUEST['zone']))? $_REQUEST['zone'] : "";
        $company_name = (!empty($_REQUEST['business_name']))? $_REQUEST['business_name'] : "";
        $motto = (!empty($_REQUEST['motto']))? $_REQUEST['motto'] : "";
        $name = (!empty($_REQUEST['name']))? $_REQUEST['name'] : "";
        $password =(!empty($_REQUEST['password']))? $_REQUEST['password'] : "";
        $uemail = (!empty($_REQUEST['uemail']))? $_REQUEST['uemail'] : "";
        $fname =(!empty($_REQUEST['fname']))? $_REQUEST['fname'] : "";
        $lname = (!empty($_REQUEST['lname']))? $_REQUEST['lname'] : "";
        $fullname = (!empty($_REQUEST['fullname']))? $_REQUEST['fullname'] : "";
        $phone =(!empty($_REQUEST['phone']))? str_replace("-", "", $_REQUEST['phone']): "";
        $alternate_phone =(!empty($_REQUEST['alternate_phone']))? str_replace("-", "", $_REQUEST['alternate_phone']) : 0;
        $user_address = (!empty($_REQUEST['user_address']))? $_REQUEST['user_address'] : "";
        $user_address2 = (!empty($_REQUEST['user_address2']))? $_REQUEST['user_address2'] : "";
        $address = $user_address.' '.$user_address2;
        $user_city = (!empty($_REQUEST['user_city']))? $_REQUEST['user_city'] : "";
        $user_state = (!empty($_REQUEST['user_state']))? $_REQUEST['user_state'] : "";
        $user_zip = (!empty($_REQUEST['user_zip']))? $_REQUEST['user_zip'] : "";
        $website = (!empty($_REQUEST['website']))? $_REQUEST['website'] : "";
        $city = (!empty($_REQUEST['city']))? $_REQUEST['city'] : "";
        $state =(!empty($_REQUEST['state']))? $_REQUEST['state'] : "";
        $siccode =(!empty($_REQUEST['sic_code']))? $_REQUEST['sic_code'] : "";
        $vedio_presentation =(!empty($_REQUEST['vedio_presentation']))? $_REQUEST['vedio_presentation'] : "";
        $audio_presentation =(!empty($_REQUEST['audio_presentation']))? $_REQUEST['audio_presentation'] : "";
        $zip = (!empty($_REQUEST['zip']))? $_REQUEST['zip'] : "";
        $postalcode = (!empty($_REQUEST['postalcode']))? $_REQUEST['postalcode'] : "";
        $selZone =  (!empty($_REQUEST['selZone']))? $_REQUEST['selZone'] : ""; 
        $referralcode =     (!empty($_REQUEST['referralcode']))? $_REQUEST['referralcode'] : ""; 
        $userid_for_registration = (!empty($_REQUEST['userid_for_registration']))? $_REQUEST['userid_for_registration'] : ""; 
        $timestamp = time();
        $company_name = (!empty($_REQUEST['company_name']))? $_REQUEST['company_name'] : "";
        $refer_url_code = (!empty($_REQUEST['refer_code']))? $_REQUEST['refer_code'] : "";
        $refer_choice = (!empty($_REQUEST['refer_choice']))? $_REQUEST['refer_choice'] : "";
        $refer_email = (!empty($_REQUEST['refer_email']))? $_REQUEST['refer_email'] : "";
        $refer_phone = (!empty($_REQUEST['refer_phone']))? $_REQUEST['refer_phone'] : "";
        $zone_owner = (!empty($_REQUEST['zone_owner']))? $_REQUEST['zone_owner'] : "";
        $bemail =   (!empty($_REQUEST['bemail']))? $_REQUEST['bemail'] : "";
        $restaurant_type =   (!empty($_REQUEST['restaurant_type']))? $_REQUEST['restaurant_type'] : "";
        if($zip == ''){
        	$zip = $postalcode;
        }
        $ZO_seo_name = $redirection_link = '';
        $sql =  'SELECT id FROM users  WHERE username='.$name;
        $userexists = $this->CommonController->SelectRawquery($sql,'row');
        if($userexists != ''){
        	echo json_encode(['msg'=>'Phone Number Already Registered','type'=>'warning']);
        	die;
        }
        if($selZone!=''){
            if($selZone != -1){
                $sql_get_zone_owner_email = "SELECT a.email , a.first_name , a.last_name , b.name, b.seo_zone_name, b.redirection_link,b.short_url,b.subdomainZone FROM users a , sales_zone b WHERE a.id = b.sales_rep_id AND b.id=".$selZone;
                $query_sql_get_zone_owner_email = $this->db->query($sql_get_zone_owner_email);
                $res_zone_owner_email = $query_sql_get_zone_owner_email->getResultArray();
                
                $ZO_email = isset($res_zone_owner_email[0]['email'])?$res_zone_owner_email[0]['email']:'';
                $ZO_fname = isset($res_zone_owner_email[0]['first_name'])?$res_zone_owner_email[0]['first_name']:'';
                $ZO_lname = isset($res_zone_owner_email[0]['last_name'])?$res_zone_owner_email[0]['last_name']:'';
                $ZO_name = isset($res_zone_owner_email[0]['name'])?$res_zone_owner_email[0]['name']:'';
                $subdomainZone = isset($res_zone_owner_email[0]['subdomainZone'])?$res_zone_owner_email[0]['subdomainZone']:'';
                $ZO_seo_name = isset($res_zone_owner_email[0]['seo_zone_name'])?$res_zone_owner_email[0]['seo_zone_name']:'';
                $redirection_link = isset($res_zone_owner_email['0']['redirection_link'])?$res_zone_owner_email['0']['redirection_link']:'';
                $short_url = isset($res_zone_owner_email[0]['short_url'])?$res_zone_owner_email[0]['short_url']:'';
            } 
            if($zip != -1 && strlen($zip)!=0){
                $sql_zone_from_zip = "SELECT a.email , a.first_name , a.last_name , c.name FROM users a , tblClaimedZips b , sales_zone c WHERE a.id=b.uid AND a.id=c.sales_rep_id AND b.zip=".$zip;
                $res_sql_zone_from_zip = $this->CommonController->SelectRawquery($sql_zone_from_zip);
             	$zip_Zo_mail = $res_sql_zone_from_zip[0]['email'];
                $zip_Zo_fname = $res_sql_zone_from_zip[0]['first_name'];
                $zip_Zo_lname = $res_sql_zone_from_zip[0]['last_name'];
                $zip_Zo_name = $res_sql_zone_from_zip[0]['name'];
            }
        }
        $accountGroups = array();
        $accountGroups[] = $account_type;
        $additional_data = array('first_name' => $fname,'last_name' => $lname,'company' =>$company_name,'phone' => $phone,'Address' => $address,'City' => $city,'State_Code' => $state,'Zip' => $zip,'Zone_ID' => $selZone,'alternate_phone' => $alternate_phone);
        $id = $this->ionAuth->register($name, $password, $uemail, $additional_data, $accountGroups,$userid_for_registration);
        $lonlngArr = $this->CommonController->getLocationLatLong($zip);
        if($id != '' && $zone==''){
            $address_data=array(
                'street_address_1'=>$user_address,
                'street_address_2'=>$user_address2,
                'city'=>$city,
                'state'=>$state,
                'zip_code'=>$zip,           
                'latitude'=>$lonlngArr['lat'],           
                'longitude'=>$lonlngArr['lng']            
            );  
            
            $this->db->table('address')->insert($address_data);
			$address_id = $this->db->insertID();
			
			$business_data=array(
                'contactfirstname'=>$fname,
                'type'=>$restaurant_type,
                'contactlastname'=>$lname,
                'contactfullname'=>$fullname,
                'contactemail'=>$bemail,
                'name' => $company_name,
                'motto' => $motto , 
                'timestamp' => time(),
                'addressid'=>$address_id,
                'business_owner_id'=>$id,
                'created_by'=>$id,
                'siccode' =>$siccode,
                'website' => $website, 
                'video_presentation'=>1,
                'audio_presentation'=>1,    
                'trialstarted' => time(),
            );
            
            $this->db->table('business')->insert($business_data);
			$id1 = $this->db->insertID();
			
			$bSponsorData = array('business_id' => $id1,'status' => '1','zone_id' => $selZone);
       		$this->CommonController->InsertData('business_sponsor', $bSponsorData);
		
			$bbusiness_sponsor_orderData = array('business_id' => $id1,'display_order' => '1','zoneid' => $selZone);
			$this->CommonController->InsertData('business_sponsor_order', $bbusiness_sponsor_orderData);
			
			if($account_type == 13){ $type = 2;
            }else{ $type = 1; }
        
        	$business_id= array(
            	'businessid'=>$id1,
            	'settingszoneid'=>$selZone,
            	'isdefault'=>1,
            	'approval'=>2,
            	'type'=>$type,
            	'isverified_businessowner'=>1,
        	);
            
            $this->db->table('ads_setting_preferences')->insert($business_id);
			$id2 = $this->db->insertID();
			
			$data_peekaboo=array(
            	'fName'=>$fname,
            	'lName'=>$lname,
            	'email'=>$uemail,
            	'address1'=>$user_address,
            	'address2'=>$user_address2,
            	'company_name'=>$company_name,
            	'city_name'=>$city,
            	'state_name'=>$state,
            	'post_code'=>$zip,
            	'phone'=>$phone,
            	'user_name'=>$name,
            	'password'=>sha1($password),
            	'activated'=>'yes',
            	'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),
            	'member_type'=>2 ,
            	'fromreferrer' => $referralcode
        	);
        	
        	$this->db->table('tbl_member')->insert($data_peekaboo);
			$peekaboo_id = $this->db->insertID();
		}
    	
    	if($id != ''){
        	$user_company_update = "UPDATE users SET company='".$company_name."' WHERE id=".$id;
        	$this->db->query($user_company_update);
    	}
    	
    	if($refer_url_code != ''){
        	$refer_url_code_arr = explode('_',$refer_url_code);
        	$refer_code = $refer_url_code_arr[0];
        	$referer_bus_id = $refer_url_code_arr[1];               
        	$refer_sql = "INSERT INTO refer_user(referer_bus_id, referrer_email_by_user, referrer_phone_by_user, refer_code, referred_user_id, referal_accepted) VALUES (".$referer_bus_id.",'".$refer_email."','".$refer_phone."','".$refer_code."',".$id.",".$refer_choice.")";
        	$this->db->query($refer_sql);       
    	}
    	if($account_type == '4'){                           
        	$saleszoneid=$this->sales_zone->create("$zone", $id);       
    	}
    	if(!$id){            
        	$message = "Registration Failed.";
    	}else{  
        	$message1 = '<div class="succ_messs_form">
            <span style="text-align:center; margin-left: 0px;">Thank you for registering your businesses with SavingsSites.</span><br /> 
            <span style="text-align:center; margin-left: 0px;">A confirmation email has been sent to your email address.</span> <br />
            <span style="text-align:center; margin-left: 0px;">BE SURE to check your JUNK email folder if the email does</span> <br />
            <span style="text-align:center; margin-left: 0px;">not appear in your inbox. The confirmation email will have</span><br />
            <span style="text-align:center; margin-left: 0px;">a link to your SavingsSites dashboard where you can confirm </span><br />
            <span style="text-align:center; margin-left: 0px;">and edit your business information. Below the "create a new </span><br />
            <span style="text-align:center; margin-left: 0px;">advertisement" bar you will find the advertisement editor that </span><br />
            <span style="text-align:center; margin-left: 0px;">you can use to create your first offer. When the SavingsSites </span><br />
            <span style="text-align:center; margin-left: 0px;">directory manager approves your registration your ad will </span><br />
            <span style="text-align:center; margin-left: 0px;">immediately become visible in the SavingsSites directory that </span><br />
            <span style="text-align:center; margin-left: 0px;">you registered for. You can also have your ad appear in multiple </span><br />
            <span style="text-align:center; margin-left: 0px;">SavingsSites directories, and your directory manager can easily</span><br />
            <span style="text-align:center; margin-left: 0px;">assist you with this.</span><br /></div>';

        	$message = '<div class="succ_messs_form">
            <span style="text-align:center; margin-left: 0px;">Thank you for registering your businesses with SavingsSites.</span><br /> 
            <span style="text-align:center; margin-left: 0px;">A confirmation email has been sent to your email address.</span> <br /></div>';
        	$zone_name = $ZO_seo_name!='' ? $ZO_seo_name : $zone;
        	if($short_url!=''){
            	$link = $short_url;
        	}
        	else{
            	$link=base_url()."/zone/".$zone_name;
        	}
        	$message_body1="<div style='border:1px solid #900; padding:5px;'><font size='4'>Dear ".$name.",<br /><br />Thank you for registering with SavingsSites.<br/><br/>Please click the link below:<br /><br />".$link."<br/><br/>
            Clicking the link above will confirm your registration and you will be able to login to your new business account and start creating  your first ad. As soon as the Directory Manager approves your account your ad will become visible within the SavingsSites directory  in which you registered. The link above will take you to the main SavingsSites page so that you can login to your business dashboard.<br /><br />
            Best Regards,<br />
            Savings Sites<br/>
            <a href='savingssites.com'>savingssites.com</a>
            <hr></font>" ;
        	
        	if($redirection_link!=''){
            $message_body= '<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">
                    <div style="width:960px; margin:0 auto !important;">
                    <div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">
                    <div style="background-color:#3f3f3f; height:90px;"><img src="'.base_url().'/assets/directory/images/logo.png"   
                        style="margin-left: 198px; max-height: 80%;margin-top: 10px;" alt="logo"/></div>
                    <div style="clear:both"></div>
                    <div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:300px; padding:15px;">
                        <h1 style="text-align:left; color:#333;">Dear'."  ".$fname.', 
                        </h1><h2 style="text-align:left; display:block; color:#333;"> Thank you for registering with SavingsSites.</h2><h2 style="text-align:left; display:block; color:#333; font-size: 18.0pt;">The link below will take you to the directory homepage where you can login to your business dashboard to create your<br/> FREE Ad and INCREASE SALES!</h2>
                        <h2 style="text-align:left; display:block; color:#333;"><a target="_blank" href="'.$redirection_link.'">'.$redirection_link.'</a></h2>
                        <h2 style="text-align:left; display:block; color:#333;">Best Regards,</h2>
                        <h2 style="text-align:left; display:block; color:#333;">Your Friends at Savings Sites</h2>
                    </div>
                    <div style="background-color:#999; height:60px;"></div></div></div></body>';                            
        	}else{
            	$message_body= '<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">
                <div style="width:960px; margin:0 auto !important;">
                <div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">
                <div style="background-color:#3f3f3f; height:90px;"><img src="'.base_url().'/assets/directory/images/logo.png"   
                        style="margin-left: 198px;max-height: 80%;margin-top: 10px;" alt="logo"/></div>
                <div style="clear:both"></div>
                <div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:300px; padding:15px;">
                    <h1 style="text-align:left; color:#333;">Dear'."  ".$fname.', 
                    </h1><h2 style="text-align:left; display:block; color:#333;"> Thank you for registering with SavingsSites.</h2><h2 style="text-align:left; display:block; color:#333; font-size: 18.0pt;">The link below will take you to the directory homepage where you can login to your business dashboard to create your<br/> FREE Ad and INCREASE SALES!</h2>
                    <h2 style="text-align:left; display:block; color:#333;"><a href="'.$link.'">'.$link.'</a></h2>
                    <h2 style="text-align:left; display:block; color:#333;">Best Regards,</h2>
                    <h2 style="text-align:left; display:block; color:#333;">Your Friends at Savings Sites</h2>
                    </div>
                    <div style="background-color:#999; height:60px;"></div></div></div></body>';
        	}
        	
        	$fromemail=$this->myconfig->adminEmailId;
        	$template_subject="Savings Sites Account Registration";
        	
			$this->email->setFrom($this->myconfig->fromemail);
			$this->email->setSubject($template_subject);
			$this->email->setMessage($message_body);
			if($uemail!=''){
            	$this->email->setTo($uemail);
            	$this->email->send();
            	$to[]=$uemail;
        	}
			if($selZone!=''){
            	if($selZone != -1){     
                	$message1 = '<div class="succ_messs_form">
                    <span style="text-align:center; margin-left: 0px;">Thank you for registering your businesses with SavingsSites.</span><br /> 
                    <span style="text-align:center; margin-left: 0px;">A confirmation email has been sent to your email address.</span> <br />
                    <span style="text-align:center; margin-left: 0px;">BE SURE to check your JUNK email folder if the email does</span> <br />
                    <span style="text-align:center; margin-left: 0px;">not appear in your inbox. The confirmation email will have</span><br />
                    <span style="text-align:center; margin-left: 0px;">a link to your SavingsSites dashboard where you can confirm </span><br />
                    <span style="text-align:center; margin-left: 0px;">and edit your business information. Below the "create a new </span><br />
                    <span style="text-align:center; margin-left: 0px;">advertisement" bar you will find the advertisement editor that </span><br />
                    <span style="text-align:center; margin-left: 0px;">you can use to create your first offer. When the SavingsSites </span><br />
                    <span style="text-align:center; margin-left: 0px;">directory manager approves your registration your ad will </span><br />
                    <span style="text-align:center; margin-left: 0px;">immediately become visible in the SavingsSites directory that </span><br />
                    <span style="text-align:center; margin-left: 0px;">you registered for. You can also have your ad appear in multiple </span><br />
                    <span style="text-align:center; margin-left: 0px;">SavingsSites directories, and your directory manager can easily</span><br />
                    <span style="text-align:center; margin-left: 0px;">assist you with this.</span><br /></div>';
                $zonedirectorybutton = base_url()."/zone/".$zone_name;
                $message = '<div class="succ_messs_form">
                    <span style="text-align:center; margin-left: 0px;">Thank you for registering your businesses with SavingsSites.</span><br /> 
                    <span style="text-align:center; margin-left: 0px;">A confirmation email has been sent to your email address.</span> <br /><br><br>
                    <span style="text-align:center; margin-left: 0px; background-color: #00A4B5;font-size: 24px; background-image: -webkit-gradient(linear, left top, left bottom, from(#ee432e 0%), to(#c63929 50%));background-image: -webkit-linear-gradient(top, #ee432e 0%, #c63929 50%, #b51700 50%, #891100 100%);background-image: -moz-linear-gradient(top, #ee432e 0%, #c63929 50%, #b51700 50%, #891100 100%);background-image: -ms-linear-gradient(top, #ee432e 0%, #c63929 50%, #b51700 50%, #891100 100%);background-image: -o-linear-gradient(top, #ee432e 0%, #c63929 50%, #b51700 50%, #891100 100%);background-image: linear-gradient(top, #ee432e 0%, #c63929 50%, #b51700 50%, #891100 100%);border: 1px solid #951100; background-color: #f37873;background-image: -webkit-gradient(linear, left top, left bottom, from(#f37873 0%), to(#db504d 50%));background-image: -webkit-linear-gradient(top, #f37873 0%, #db504d 50%, #cb0500 50%, #a20601 100%);background-image: -moz-linear-gradient(top, #f37873 0%, #db504d 50%, #cb0500 50%, #a20601 100%);background-image: -ms-linear-gradient(top, #f37873 0%, #db504d 50%, #cb0500 50%, #a20601 100%);background-image: -o-linear-gradient(top, #f37873 0%, #db504d 50%, #cb0500 50%, #a20601 100%);background-image: linear-gradient(top, #f37873 0%, #db504d 50%, #cb0500 50%, #a20601 100%);cursor: pointer; }
                        
                        .alt-gradient:active {background-color: #d43c28;background-image: -webkit-gradient(linear, left top, left bottom, from(#d43c28 0%), to(#ad3224 50%));background-image: -webkit-linear-gradient(top, #d43c28 0%, #ad3224 50%, #9c1500 50%, #700d00 100%);background-image: -moz-linear-gradient(top, #d43c28 0%, #ad3224 50%, #9c1500 50%, #700d00 100%);background-image: -ms-linear-gradient(top, #d43c28 0%, #ad3224 50%, #9c1500 50%, #700d00 100%);background-image: -o-linear-gradient(top, #d43c28 0%, #ad3224 50%, #9c1500 50%, #700d00 100%);background-image: linear-gradient(top, #d43c28 0%, #ad3224 50%, #9c1500 50%, #700d00 100%);-webkit-box-shadow: inset 0px 0px 0px 1px rgba(255, 115, 100, 0.4);-moz-box-shadow: inset 0px 0px 0px 1px rgba(255, 115, 100, 0.4);-ms-box-shadow: inset 0px 0px 0px 1px rgba(255, 115, 100, 0.4);-o-box-shadow: inset 0px 0px 0px 1px rgba(255, 115, 100, 0.4);box-shadow: inset 0px 0px 0px 1px rgba(255, 115, 100, 0.4); }
                        
                        box-shadow: 0px 0px 4px 2px #aaa;"><a target="_blank" style="text-decoration:none;" href="'.$zonedirectorybutton.'/">Back To Directory Homepage</a></span> <br /></div>';
                
                	$message_body= '<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">
                    <div style="width:960px; margin:0 auto !important;">
                    <div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">
                    <div style="background-color:#3f3f3f; height:70px;"><img src="'.base_url().'/assets/directory/images/logo.png" style="margin:10px 202px;" alt="logo"/></div>
                    <div style="clear:both"></div>
                    <div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:300px; padding:15px;">
                        <h2 style="text-align:left;">Hi'."  ".$ZO_fname.', 
                        </h2><h3 style="text-align:left; display:block; color:#666;"> A new business owner has registered in: '.$ZO_name.'</h3>
                        <h3><p style="text-align:left; display:block; color:#333;">Business Name: '.$company_name.'</p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;">First Name: '."  ".$fname.'</p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;">Last Name: '.$lname.'</p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;">Phone Number : '.$phone.'</p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;">Email: '.$uemail.'</p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;">Street Address: '.$address.'</p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;">City: '.$city.'</p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;">State: '.$state.'</p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;">Zip: '.$zip.'</p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;">Business Credentials Info - </p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;">Username: '.$name.'</p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;">Best Regards</p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;">Savings Sites</p></h3>
                        <h3><p style="text-align:left; display:block; color:#333;"><a href="http://'.$subdomainZone.'.savingssites.com">savingssites.com</a></p></h3>
                    </div>
                    <div style="background-color:#999; height:60px;"></div></div></div></body>';

                   	$fromemail=$this->myconfig->adminEmailId;
        			$template_subject="New Registration";
        			$this->email->setHeader('MIME-Version', '1.0; charset=utf-8');
        			$this->email->setHeader('Content-type', 'text/html'); 
        			$this->email->setFrom($this->myconfig->fromemail);
            		$this->email->setTo($ZO_email);
					$this->email->setSubject($template_subject);
					$this->email->setMessage($message_body);
            		$this->email->send();
            	}
            }   
        }
        echo json_encode($message);
        die;
    }

	/**
	 * Log the user in
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function login()
	{
		$this->data['title'] = lang('Auth.login_heading');

		// validate form input
		$this->validation->setRule('identity', str_replace(':', '', lang('Auth.login_identity_label')), 'required');
		$this->validation->setRule('password', str_replace(':', '', lang('Auth.login_password_label')), 'required');

		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run())
		{
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->request->getVar('remember');

			if ($this->ionAuth->login($this->request->getVar('identity'), $this->request->getVar('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->setFlashdata('message', $this->ionAuth->messages());
				return redirect()->to('/')->withCookies();
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				// use redirects instead of loading views for compatibility with MY_Controller libraries
				return redirect()->back()->withInput();
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');

			$this->data['identity'] = [
				'name'  => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => set_value('identity'),
			];

			$this->data['password'] = [
				'name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			];

			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'login', $this->data);
		}
	}
	
	public function logout(){
		$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
		if($type == 'business'){
			$this->ionAuth->logout();
			$this->response->deleteCookie('subDomainUsername');
			$this->response->setCookie(['name'   => 'subDomainUsername', 'value'  => ""]);
			$this->response->deleteCookie('subDomainUserPass');
			$this->response->setCookie(['name'   => 'subDomainUserPass', 'value'  => ""]);
			$this->response->deleteCookie('subDomainZone');
			$this->response->setCookie(['name'   => 'subDomainZone', 'value'  => ""]);
			echo json_encode(array('msg' => 'logout success', 'type' => 'success'));
			die;
		}else{
			$this->data['title'] = 'Logout';
			$this->ionAuth->logout();
			$this->session->setFlashdata('message', $this->ionAuth->messages());
			return redirect()->to('/auth/login')->withCookies();
		}
	}

	/**
	 * Change password
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function change_password()
	{
		if (! $this->ionAuth->loggedIn())
		{
			return redirect()->to('/auth/login');
		}
		
		$this->validation->setRule('old', lang('Auth.change_password_validation_old_password_label'), 'required');
		$this->validation->setRule('new', lang('Auth.change_password_validation_new_password_label'), 'required|min_length[' . $this->configIonAuth->minPasswordLength . ']|matches[new_confirm]');
		$this->validation->setRule('new_confirm', lang('Auth.change_password_validation_new_password_confirm_label'), 'required');

		$user = $this->ionAuth->user()->row();

		if (! $this->request->getPost() || $this->validation->withRequest($this->request)->run() === false)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = ($this->validation->getErrors()) ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');

			$this->data['minPasswordLength'] = $this->configIonAuth->minPasswordLength;
			$this->data['old_password'] = [
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			];
			$this->data['new_password'] = [
				'name'    => 'new',
				'id'      => 'new',
				'type'    => 'password',
				'pattern' => '^.{' . $this->data['minPasswordLength'] . '}.*$',
			];
			$this->data['new_password_confirm'] = [
				'name'    => 'new_confirm',
				'id'      => 'new_confirm',
				'type'    => 'password',
				'pattern' => '^.{' . $this->data['minPasswordLength'] . '}.*$',
			];
			$this->data['user_id'] = [
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			];

			// render
			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'change_password', $this->data);
		}
		else
		{
			$identity = $this->session->get('identity');

			$change = $this->ionAuth->changePassword($identity, $this->request->getPost('old'), $this->request->getPost('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->setFlashdata('message', $this->ionAuth->messages());
				return $this->logout();
			}
			else
			{
				$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				return redirect()->to('/auth/change_password');
			}
		}
	}

	/**
	 * Forgot password
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function forgot_password()
	{
		$this->data['title'] = lang('Auth.forgot_password_heading');

		// setting validation rules by checking whether identity is username or email
		if ($this->configIonAuth->identity !== 'email')
		{
			$this->validation->setRule('identity', lang('Auth.forgot_password_identity_label'), 'required');
		}
		else
		{
			$this->validation->setRule('identity', lang('Auth.forgot_password_validation_email_label'), 'required|valid_email');
		}

		if (! ($this->request->getPost() && $this->validation->withRequest($this->request)->run()))
		{
			$this->data['type'] = $this->configIonAuth->identity;
			// setup the input
			$this->data['identity'] = [
				'name' => 'identity',
				'id'   => 'identity',
			];

			if ($this->configIonAuth->identity !== 'email')
			{
				$this->data['identity_label'] = lang('Auth.forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = lang('Auth.forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');
			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'forgot_password', $this->data);
		}
		else
		{
			$identityColumn = $this->configIonAuth->identity;
			$identity = $this->ionAuth->where($identityColumn, $this->request->getPost('identity'))->users()->row();

			if (empty($identity))
			{
				if ($this->configIonAuth->identity !== 'email')
				{
					$this->ionAuth->setError('Auth.forgot_password_identity_not_found');
				}
				else
				{
					$this->ionAuth->setError('Auth.forgot_password_email_not_found');
				}

				$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				return redirect()->to('/auth/forgot_password');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ionAuth->forgottenPassword($identity->{$this->configIonAuth->identity});

			if ($forgotten)
			{
				// if there were no errors
				$this->session->setFlashdata('message', $this->ionAuth->messages());
				return redirect()->to('/auth/login'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				return redirect()->to('/auth/forgot_password');
			}
		}
	}

	/**
	 * Reset password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function reset_password($code = null)
	{
		if (! $code)
		{
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}

		$this->data['title'] = lang('Auth.reset_password_heading');

		$user = $this->ionAuth->forgottenPasswordCheck($code);

		if ($user)
		{
			// if the code is valid then display the password reset form

			$this->validation->setRule('new', lang('Auth.reset_password_validation_new_password_label'), 'required|min_length[' . $this->configIonAuth->minPasswordLength . ']|matches[new_confirm]');
			$this->validation->setRule('new_confirm', lang('Auth.reset_password_validation_new_password_confirm_label'), 'required');

			if (! $this->request->getPost() || $this->validation->withRequest($this->request)->run() === false)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');

				$this->data['minPasswordLength'] = $this->configIonAuth->minPasswordLength;
				$this->data['new_password'] = [
					'name'    => 'new',
					'id'      => 'new',
					'type'    => 'password',
					'pattern' => '^.{' . $this->data['minPasswordLength'] . '}.*$',
				];
				$this->data['new_password_confirm'] = [
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{' . $this->data['minPasswordLength'] . '}.*$',
				];
				$this->data['user_id'] = [
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				];
				$this->data['code'] = $code;

				// render
				return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'reset_password', $this->data);
			}
			else
			{
				$identity = $user->{$this->configIonAuth->identity};

				// do we have a valid request?
				if ($user->id != $this->request->getPost('user_id'))
				{
					// something fishy might be up
					$this->ionAuth->clearForgottenPasswordCode($identity);

					throw new \Exception(lang('Auth.error_security'));
				}
				else
				{
					// finally change the password
					$change = $this->ionAuth->resetPassword($identity, $this->request->getPost('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->setFlashdata('message', $this->ionAuth->messages());
						return redirect()->to('/auth/login');
					}
					else
					{
						$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
						return redirect()->to('/auth/reset_password/' . $code);
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
			return redirect()->to('/auth/forgot_password');
		}
	}

	/**
	 * Activate the user
	 *
	 * @param integer $id   The user ID
	 * @param string  $code The activation code
	 *
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function activate(int $id, string $code = ''): \CodeIgniter\HTTP\RedirectResponse
	{
		$activation = false;

		if ($code)
		{
			$activation = $this->ionAuth->activate($id, $code);
		}
		else if ($this->ionAuth->isAdmin())
		{
			$activation = $this->ionAuth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->setFlashdata('message', $this->ionAuth->messages());
			return redirect()->to('/auth');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
			return redirect()->to('/auth/forgot_password');
		}
	}

	/**
	 * Deactivate the user
	 *
	 * @param integer $id The user ID
	 *
	 * @throw Exception
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function deactivate(int $id = 0)
	{
		if (! $this->ionAuth->loggedIn() || ! $this->ionAuth->isAdmin())
		{
			// redirect them to the home page because they must be an administrator to view this
			throw new \Exception('You must be an administrator to view this page.');
			// TODO : I think it could be nice to have a dedicated exception like '\IonAuth\Exception\NotAllowed
		}

		$this->validation->setRule('confirm', lang('Auth.deactivate_validation_confirm_label'), 'required');
		$this->validation->setRule('id', lang('Auth.deactivate_validation_user_id_label'), 'required|integer');

		if (! $this->validation->withRequest($this->request)->run())
		{
			$this->data['user'] = $this->ionAuth->user($id)->row();
			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->request->getPost('confirm') === 'yes')
			{
				// do we have a valid request?
				if ($id !== $this->request->getPost('id', FILTER_VALIDATE_INT))
				{
					throw new \Exception(lang('Auth.error_security'));
				}

				// do we have the right userlevel?
				if ($this->ionAuth->loggedIn() && $this->ionAuth->isAdmin())
				{
					$message = $this->ionAuth->deactivate($id) ? $this->ionAuth->messages() : $this->ionAuth->errors($this->validationListTemplate);
					$this->session->setFlashdata('message', $message);
				}
			}

			// redirect them back to the auth page
			return redirect()->to('/auth');
		}
	}

	/**
	 * Create a new user
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function create_user()
	{
		$this->data['title'] = lang('Auth.create_user_heading');

		if (! $this->ionAuth->loggedIn() || ! $this->ionAuth->isAdmin())
		{
			return redirect()->to('/auth');
		}

		$tables                        = $this->configIonAuth->tables;
		$identityColumn                = $this->configIonAuth->identity;
		$this->data['identity_column'] = $identityColumn;

		// validate form input
		$this->validation->setRule('first_name', lang('Auth.create_user_validation_fname_label'), 'trim|required');
		$this->validation->setRule('last_name', lang('Auth.create_user_validation_lname_label'), 'trim|required');
		if ($identityColumn !== 'email')
		{
			$this->validation->setRule('identity', lang('Auth.create_user_validation_identity_label'), 'trim|required|is_unique[' . $tables['users'] . '.' . $identityColumn . ']');
			$this->validation->setRule('email', lang('Auth.create_user_validation_email_label'), 'trim|required|valid_email');
		}
		else
		{
			$this->validation->setRule('email', lang('Auth.create_user_validation_email_label'), 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
		}
		$this->validation->setRule('phone', lang('Auth.create_user_validation_phone_label'), 'trim');
		$this->validation->setRule('company', lang('Auth.create_user_validation_company_label'), 'trim');
		$this->validation->setRule('password', lang('Auth.create_user_validation_password_label'), 'required|min_length[' . $this->configIonAuth->minPasswordLength . ']|matches[password_confirm]');
		$this->validation->setRule('password_confirm', lang('Auth.create_user_validation_password_confirm_label'), 'required');

		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run())
		{
			$email    = strtolower($this->request->getPost('email'));
			$identity = ($identityColumn === 'email') ? $email : $this->request->getPost('identity');
			$password = $this->request->getPost('password');

			$additionalData = [
				'first_name' => $this->request->getPost('first_name'),
				'last_name'  => $this->request->getPost('last_name'),
				'company'    => $this->request->getPost('company'),
				'phone'      => $this->request->getPost('phone'),
			];
		}
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run() && $this->ionAuth->register($identity, $password, $email, $additionalData))
		{
			// check to see if we are creating the user
			// redirect them back to the admin page
			$this->session->setFlashdata('message', $this->ionAuth->messages());
			return redirect()->to('/auth');
		}
		else
		{
			// display the create user form
			// set the flash data error message if there is one
			$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : ($this->ionAuth->errors($this->validationListTemplate) ? $this->ionAuth->errors($this->validationListTemplate) : $this->session->getFlashdata('message'));

			$this->data['first_name'] = [
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'value' => set_value('first_name'),
			];
			$this->data['last_name'] = [
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'value' => set_value('last_name'),
			];
			$this->data['identity'] = [
				'name'  => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => set_value('identity'),
			];
			$this->data['email'] = [
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'email',
				'value' => set_value('email'),
			];
			$this->data['company'] = [
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
				'value' => set_value('company'),
			];
			$this->data['phone'] = [
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'text',
				'value' => set_value('phone'),
			];
			$this->data['password'] = [
				'name'  => 'password',
				'id'    => 'password',
				'type'  => 'password',
				'value' => set_value('password'),
			];
			$this->data['password_confirm'] = [
				'name'  => 'password_confirm',
				'id'    => 'password_confirm',
				'type'  => 'password',
				'value' => set_value('password_confirm'),
			];

			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'create_user', $this->data);
		}
	}

	/**
	 * Redirect a user checking if is admin
	 *
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function redirectUser()
	{
		if ($this->ionAuth->isAdmin())
		{
			return redirect()->to('/auth');
		}
		return redirect()->to('/');
	}

	/**
	 * Edit a user
	 *
	 * @param integer $id User id
	 *
	 * @return string string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function edit_user(int $id)
	{
		$this->data['title'] = lang('Auth.edit_user_heading');

		if (! $this->ionAuth->loggedIn() || (! $this->ionAuth->isAdmin() && ! ($this->ionAuth->user()->row()->id == $id)))
		{
			return redirect()->to('/auth');
		}

		$user          = $this->ionAuth->user($id)->row();
		$groups        = $this->ionAuth->groups()->resultArray();
		$currentGroups = $this->ionAuth->getUsersGroups($id)->getResult();

		if (! empty($_POST))
		{
			// validate form input
			$this->validation->setRule('first_name', lang('Auth.edit_user_validation_fname_label'), 'trim|required');
			$this->validation->setRule('last_name', lang('Auth.edit_user_validation_lname_label'), 'trim|required');
			$this->validation->setRule('phone', lang('Auth.edit_user_validation_phone_label'), 'trim|required');
			$this->validation->setRule('company', lang('Auth.edit_user_validation_company_label'), 'trim|required');

			// do we have a valid request?
			if ($id !== $this->request->getPost('id', FILTER_VALIDATE_INT))
			{
				//show_error(lang('Auth.error_security'));
				throw new \Exception(lang('Auth.error_security'));
			}

			// update the password if it was posted
			if ($this->request->getPost('password'))
			{
				$this->validation->setRule('password', lang('Auth.edit_user_validation_password_label'), 'required|min_length[' . $this->configIonAuth->minPasswordLength . ']|matches[password_confirm]');
				$this->validation->setRule('password_confirm', lang('Auth.edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->request->getPost() && $this->validation->withRequest($this->request)->run())
			{
				$data = [
					'first_name' => $this->request->getPost('first_name'),
					'last_name'  => $this->request->getPost('last_name'),
					'company'    => $this->request->getPost('company'),
					'phone'      => $this->request->getPost('phone'),
				];

				// update the password if it was posted
				if ($this->request->getPost('password'))
				{
					$data['password'] = $this->request->getPost('password');
				}

				// Only allow updating groups if user is admin
				if ($this->ionAuth->isAdmin())
				{
					// Update the groups user belongs to
					$groupData = $this->request->getPost('groups');

					if (! empty($groupData))
					{
						$this->ionAuth->removeFromGroup('', $id);

						foreach ($groupData as $grp)
						{
							$this->ionAuth->addToGroup($grp, $id);
						}
					}
				}

				// check to see if we are updating the user
				if ($this->ionAuth->update($user->id, $data))
				{
					$this->session->setFlashdata('message', $this->ionAuth->messages());
				}
				else
				{
					$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				}
				// redirect them back to the admin page if admin, or to the base url if non admin
				return $this->redirectUser();
			}
		}

		// display the edit user form

		// set the flash data error message if there is one
		$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : ($this->ionAuth->errors($this->validationListTemplate) ? $this->ionAuth->errors($this->validationListTemplate) : $this->session->getFlashdata('message'));

		// pass the user to the view
		$this->data['user']          = $user;
		$this->data['groups']        = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = [
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => set_value('first_name', $user->first_name ?: ''),
		];
		$this->data['last_name'] = [
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => set_value('last_name', $user->last_name ?: ''),
		];
		$this->data['company'] = [
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => set_value('company', empty($user->company) ? '' : $user->company),
		];
		$this->data['phone'] = [
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => set_value('phone', empty($user->phone) ? '' : $user->phone),
		];
		$this->data['password'] = [
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password',
		];
		$this->data['password_confirm'] = [
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password',
		];
		$this->data['ionAuth'] = $this->ionAuth;

		return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'edit_user', $this->data);
	}

	/**
	 * Create a new group
	 *
	 * @return string string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function create_group()
	{
		$this->data['title'] = lang('Auth.create_group_title');

		if (! $this->ionAuth->loggedIn() || ! $this->ionAuth->isAdmin())
		{
			return redirect()->to('/auth');
		}

		// validate form input
		$this->validation->setRule('group_name', lang('Auth.create_group_validation_name_label'), 'trim|required|alpha_dash');

		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run())
		{
			$newGroupId = $this->ionAuth->createGroup($this->request->getPost('group_name'), $this->request->getPost('description'));
			if ($newGroupId)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->setFlashdata('message', $this->ionAuth->messages());
				return redirect()->to('/auth');
			}
		}
		else
		{
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : ($this->ionAuth->errors($this->validationListTemplate) ? $this->ionAuth->errors($this->validationListTemplate) : $this->session->getFlashdata('message'));

			$this->data['group_name'] = [
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => set_value('group_name'),
			];
			$this->data['description'] = [
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => set_value('description'),
			];

			return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'create_group', $this->data);
		}
	}

	/**
	 * Edit a group
	 *
	 * @param integer $id Group id
	 *
	 * @return string|CodeIgniter\Http\Response
	 */
	public function edit_group(int $id = 0)
	{
		// bail if no group id given
		if (! $id)
		{
			return redirect()->to('/auth');
		}

		$this->data['title'] = lang('Auth.edit_group_title');

		if (! $this->ionAuth->loggedIn() || ! $this->ionAuth->isAdmin())
		{
			return redirect()->to('/auth');
		}

		$group = $this->ionAuth->group($id)->row();

		// validate form input
		$this->validation->setRule('group_name', lang('Auth.edit_group_validation_name_label'), 'required|alpha_dash');

		if ($this->request->getPost())
		{
			if ($this->validation->withRequest($this->request)->run())
			{
				$groupUpdate = $this->ionAuth->updateGroup($id, $this->request->getPost('group_name'), ['description' => $this->request->getPost('group_description')]);

				if ($groupUpdate)
				{
					$this->session->setFlashdata('message', lang('Auth.edit_group_saved'));
				}
				else
				{
					$this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
				}
				return redirect()->to('/auth');
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = $this->validation->listErrors($this->validationListTemplate) ?: ($this->ionAuth->errors($this->validationListTemplate) ?: $this->session->getFlashdata('message'));

		// pass the user to the view
		$this->data['group'] = $group;

		$readonly = $this->configIonAuth->adminGroup === $group->name ? 'readonly' : '';

		$this->data['group_name']        = [
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => set_value('group_name', $group->name),
			$readonly => $readonly,
		];
		$this->data['group_description'] = [
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => set_value('group_description', $group->description),
		];

		return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'edit_group', $this->data);
	}

	/**
	 * Render the specified view
	 *
	 * @param string     $view       The name of the file to load
	 * @param array|null $data       An array of key/value pairs to make available within the view.
	 * @param boolean    $returnHtml If true return html string
	 *
	 * @return string|void
	 */
	protected function renderPage(string $view, $data = null, bool $returnHtml = true): string
	{
		$viewdata = $data ?: $this->data;

		$viewHtml = view($view, $viewdata);

		if ($returnHtml)
		{
			return $viewHtml;
		}
		else
		{
			echo $viewHtml;
		}
	}

	/*old controllers data*/
		function allbusinespaymentsstatus(){

  

   $inactive_business_list = json_decode($_REQUEST['inactive_business_list'], TRUE);
   $active_business_list = json_decode($_REQUEST['active_business_list'], TRUE);

   $active_business = implode(', ', $active_business_list);
   $inactive_business = implode(', ', $inactive_business_list);
  

  if(count($active_business_list) != 0){
      $query12 =" UPDATE business SET bpayment_status = 1  WHERE id in  (".$active_business.")";
		  $query_sql_zone_from_zip = $this->db->query($query12);
  }

  if(count($inactive_business_list) != 0){

  	$query12 =" UPDATE business SET bpayment_status = 0  WHERE id in  (".$inactive_business.")";
		 $query_sql_zone_from_zip = $this->db->query($query12);

  }




	}

	 function checkpromo(){
     

         $sql_get_zone_owner_email = "SELECT * FROM `tbl_promo_code` where code ='".$_REQUEST['code']."' ";

		 $query_option1=$this->db->query($sql_get_zone_owner_email);
		 $allSnappost = $query_option1->result_array();

		 // Creates DateTime objects
		  $datetime1 = date_create($allSnappost[0]['created_at']);
		  $datetime2 = date_create(date("Y-m-d h:i:sa"));
		  
		  // Calculates the difference between DateTime objects
		  $interval = date_diff($datetime1, $datetime2);
		  
		 
            if( count($allSnappost) == 1){
           if($allSnappost[0]['status'] == ''){
            
		   if($interval->days <= 3){

		   
			    if($allSnappost[0]['userid']){

			   	  	$updateCredit = "UPDATE tbl_member   inner join users on tbl_member.user_name = users.username  SET   tbl_member.balance = tbl_member.balance + 3   WHERE users.id = ".$allSnappost[0]['userid'];
			        $this->db->query($updateCredit);

			        $updateInfo = "UPDATE tbl_promo_code   SET   status = 1 , used_at = '".date("Y-m-d h:i:sa")."'  WHERE id = ".$allSnappost[0]['id'];
			        $this->db->query($updateInfo);

			   	  }

		   	    echo 'success';

		   }else{

		   	       $updateInfo = "UPDATE tbl_promo_code   SET   status = '0'  WHERE id = ".$allSnappost[0]['id'];
			        $this->db->query($updateInfo);
			         echo 'expired';

		   }
            }else{

	               if($allSnappost[0]['status'] == 1){
	               	 echo 'used';
	               }else if($allSnappost[0]['status'] == 0){
	               	 echo 'expired';
	               }

            }

           }else{
           	  echo 'invalid';
           }



		 

	 }

  function gmaillogin(){
  

// Facebook API Key
  
 
// require_once(dirname(__DIR__).'/third_party/Classes/php-graph-sdk-5.x/src/Facebook/autoload.php');



// $facebook = new Facebook(array(
//   'appId'  => 'YOUR_APP_ID',
//   'secret' => 'YOUR_APP_SECRET',
// ));

die;
  }



  function deleteaction(){
      

    $query =" delete  from webinar_information   WHERE  id =".$_REQUEST['form'];
	   $query_sql_zone_from_zip = $this->db->query($query);
  	 die();
  }

  	function updatecreditprice(){
 
    $params = array();
    parse_str($_REQUEST['form'], $params);
 
    $query =" UPDATE sales_zone SET rate_per_credit = '".$params['price']."' WHERE id =".$_REQUEST['zoneID'];
		$query_sql_zone_from_zip = $this->db->query($query);

  	}

	function paymentconfirm(){
    

      if($_POST['datause'] == 'false'){
          $status = '0';
      }else{
          $status = '1';
      }


        $query =" UPDATE sales_zone SET zpayment_status = '".$status."' WHERE id =".$_POST['zoneID'];

		$query_sql_zone_from_zip = $this->db->query($query);

       
	}

	#################################  new #############################################


    

	//redirect if needed, otherwise display the user list



	// User Registration Process



	// when login business login page, login from mail

	function business_login(){ 



		$username =(!empty($_REQUEST['username']))? $_REQUEST['username'] : "";

		$password = (!empty($_REQUEST['password']))? $_REQUEST['password'] : "";

		$remember='';

	

		if ($this->ion_auth->login($username, $password, $remember)){

			// create cookie to avoid hitting this case again

			$cookie = array(

				'name'   => 'blog_username',

				'value'  => $username,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($cookie);

			

			// create cookie to avoid hitting this case again

			$cookie = array(

				'name'   => 'blog_password',

				'value'  => $password,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($cookie);

			$auser = $this->ion_auth->user()->row();

            $user_id = $auser->id;

            $this->session->set_userdata('blog_user_id',$user_id);

            // Set original password in session

            $this->session->set_userdata('password',$password);

            echo $this->session->userdata('password');

            exit();

//var_dump($user_id); echo 2;

			$user_type1=$this->ion_auth->check_user_type($user_id);

			$user_type = $user_type1[0]['group_id'];

//var_dump($user_type); echo 3;

			if($user_type==4){ 

				$user_type = $user_type1[0]['group_id'];			

				$zones = $this->sales_zone->zone_owner_login($user_id);

				$zoneId = $zones[0]['id'] ? $zones[0]['id'] : 0;

				//var_dump($zones); exit;

				//If zone owner pick first zone dashboard

				if(!empty($zones)){					

					$session_zoneid = array(                   		

                   		'userzoneid'=>$zones[0]['id'],

						'sesuserid'=>$user_id

        			);

					$this->session->set_userdata('session_zoneid',$session_zoneid);

					if($zip_claimed_by_user!=''){

						$this->zips->get_zip_claim($zip_claimed_by_user, $user_id);

			 			$this->session->unset_userdata('session_zip_claimed_by_user');

					}

					//base_url().'blog/blog1.php';

					$update_zone_menu=$this->category_model->update_zone_menu($zones[0]['id']);

//var_dump($update_zone_menu); echo 4; exit;

					if($zones[0]['status']==1){									

						$response = 'zone_owner!~!'.$zones[0]['id'];

					}else{

						$response = 'zone_owner_not_verify!~!'.$zones[0]['id'];

					}

				}/*else{

					$response='<span style="color:red">Please verify your account.</span>!~!0';

				}*/

			}else if($user_type==5){ //echo 'business';

				 //If business owner pick first business

				$businesses = $this->business->get_all_businesses_for_user($user_id);					

				if(!empty($businesses)){				

					$bid = $businesses[0]['id'];

					$business_authentication=$this->business->check_business_authentication($bid);

					//var_dump($bid); exit;

					if($business_authentication=='business'){

						$response='business_owner!~!'.$bid;

					}else if($business_authentication=='verification'){

						$response='verification!~!'.$bid;

					}else if($business_authentication=='listed'){

						$response='listed!~!'.$bid;

					}else{

						$response='home!~!';

					}

					/*$listed_businesses = $this->business->check_listed_business($bid);

					//var_dump($listed_businesses); exit;

					if($listed_businesses>=1){

						//redirect("auth/verification/$bid", 'refresh');

						$response='verification!~!'.$bid;

					}else{

						//redirect("dashboards/business/$bid", 'refresh');

						$response='business_owner!~!'.$bid;

					}*/

					

				}else{

					//redirect("dashboards/createABusiness/1", 'refresh');

					$response='createABusiness!~!1';

				}

			}else if($user_type==6){ 

				//redirect("welcome/profile", 'refresh');

				$snap_zone=$this->ion_auth->get_snap_user_zone($user_id);



				//$snap_zone_id=$snap_zone[0]['zoneid']; var_dump($snap_zone_id); exit;

				$response='snap_profile!~!'.$snap_zone[0]['zoneid'];					

			}else if($user_type==8){ 

				$organization=$this->ion_auth->check_organization($user_id);

				//var_dump($organization); 

				if(!empty($organization)){

					$session_orgid = array(                   		

                   		'sesorgid'=>$organization[0]['orgid']						

        			);

					$this->session->set_userdata('session_orgid',$session_orgid);				

					$response ='organization!~!'.$organization[0]['orgid'];

					//redirect("dashboards/organization/$org_id", 'refresh');

				}

			}

			else if($user_type==9){

				//$user_id;exit;

				//$data=array('business_id'=>$business_id,'userid'=>$user_id); 

				//$response=json_encode($data);				

				$response='rating_profile!~!'.$user_id;

			}

			else{

				//redirect("dashboards/zipadmin", 'refresh');

				$response='zipadmin!~!';

			}



		}else{

			$response='<span style="color:red">Invalid Username or Password.</span>!~!0';

		}



		

		//$message='Invalid Username or Password. Please Try again.';

		echo $response;

				//echo($this->dr->GetDR("", $message, "", "0"));

		

	}

	function check_athena_login($user_id,$zid,$zonename){

		

		//$user_type = $user_type1[0]['group_id'];

		$sql="SELECT username, email, id, password, active, last_login, first_name, last_name FROM users WHERE id='$user_id'";

		$query = $this->db->query($sql);

		if ($query->num_rows() === 1){

			$user = $query->row();

		

		$session_data = array(



				    'identity'             => '',



				    'username'             => $user->username,



				    'email'                => $user->email,



				    'user_id'              => $user->id, //everyone likes to overwrite id so we'll use user_id



				    'old_last_login'       => $user->last_login



				);

				/*$this->update_last_login($user->id);



				



				$this->clear_login_attempts($identity);*/



				



				$this->session->set_userdata($session_data);			

		}

		$zones = $this->sales_zone->zone_owner_login($user_id);

		if(!empty($zones)){

			$session_zoneid = array(                   		

				'userzoneid'=>$zid,

				'sesuserid'=>$user_id

			);

			$this->session->set_userdata('session_zoneid',$session_zoneid);

			redirect("Zonedashboard/zonedetail/$zid", 'refresh'); 

		}

		 

	}
	
	public function check_login_type(){ 
		$response = '';		
		$username = (!empty($_REQUEST['username']))? $_REQUEST['username'] : "";
		$login_type = (!empty($_REQUEST['loginType']))? $_REQUEST['loginType'] : "";
		$zoneid =(!empty($_REQUEST['zoneid']))? $_REQUEST['zoneid'] : "";
 		$msgArr = ['4'=> 'Zone Login', '5' => 'Business Login','8' => 'Organization Login','10' => 'Neighbors Login. Want to login as Visitor?','7' => 'Visitor Login'];
		$msg = isset($msgArr[$login_type])?$msgArr[$login_type]:'';
		$check_login = $this->ionAuth->check_login_type($username,$login_type);
		
		
		if($check_login == 1){
			$response=1;
		}else if($check_login == 0){
			$response='<span>Sorry! You are not a valid user for '.$msg.'</span>';
		} 			 
		
		echo json_encode($response);
	}

	

	/**

	* this function is used for login

	* Different user accesses from same this fuction

	* Zone owner verification 

	* Input Parameters - $username,$password, $userzone, $login_type, $zip_claimed_by_user, $zoneid

	* Diffrent model function is used into this function.

	**/

	function login_from_zone_page($username = '',$password = '',$zoneid = '', $via = ''){
 		$username =(!empty($_REQUEST['username']))? $_REQUEST['username'] : $username;
		$password = (!empty($_REQUEST['password']))? $_REQUEST['password'] : $password;
		$userzone = (!empty($_REQUEST['userzone']))? $_REQUEST['userzone'] : $zoneid;
		$login_type = (!empty($_REQUEST['login_type']))? $_REQUEST['login_type'] : "";
		$zip_claimed_by_user = (!empty($_REQUEST['zip_claimed_by_user']))? $_REQUEST['zip_claimed_by_user'] : "";
		$zoneid = (!empty($_REQUEST['zoneid_login'])) ? $_REQUEST['zoneid_login'] : "" ; 
		$remember='';
		// $this->session->remove('session_zoneid');
		// $this->session->remove('user_id');
		// echo "<pre>";print_r($this->session->get('session_zoneid'));die;
		

		// if($this->session->get('user_id') !=''){  
		// 	$userdata = $this->session->get('session_zoneid');
		// 	$exists = isset($userdata['userzoneid'])?$userdata['userzoneid']:'';
		// 	if($exists == ''){
		// 		$this->CommonController->destroySession();
		// 	}
		// }



		if($this->session->get('user_id') !=''){  
			$userdata = $this->session->get('session_zoneid');
			$zoneid = $userdata['userzoneid'];
			redirect("/index.php?zone=".$zoneid, 'refresh');
		}
		if ($this->ionAuth->login($username, $password, $remember)){
			$auser = $this->ionAuth->user()->row(); 
			$user_type1=$this->ionAuth->check_user_type($auser->id);
			$user_type = $user_type1[0]['group_id'];
			$user_id = $auser->id;
			$this->CommonController->SetCookie('neighbors_classifieds_username',$username,time()+86500,'','/','');
			$this->CommonController->SetCookie('timeSlotUserName',$username,time()+86500,'','/','');
			$this->CommonController->SetCookie('timeSlotPassword',$password,time()+86500,'','/','');
			$this->CommonController->SetCookie('timeSlotName',$auser->first_name.' '.$auser->last_name,time()+86400,'','/','');
			$this->CommonController->SetCookie('timeSlotEmail',$auser->email,time()+86400,'','/','');
			$this->CommonController->SetCookie('neighbors_classifieds_password',$password,time()+86500,'','/','');
			$this->CommonController->SetCookie('neighbors_classifieds_zoneid',$userzone,time()+86500,'','/','');
			$this->CommonController->SetCookie('blog_username',$username,time()+86500,'','/','');
			$this->CommonController->SetCookie('blog_password',$password,time()+86500,'','/','');
			$this->CommonController->SetCookie('neighbors_classifieds_userid',$user_id,time()+86500,'','/','');
			$this->CommonController->SetCookie('subDomainUsername',$username,time()+86500,'savingssites.com','/','');
			$subpassword = base64_encode($password);
			$this->CommonController->SetCookie('subDomainUserPass',$subpassword,time()+86500,'savingssites.com','/','');
			$this->CommonController->SetCookie('subDomainZone',$userzone,time()+86500,'savingssites.com','/','');
			$this->CommonController->setSession('session_zoneid', array('userzoneid'=>$auser->Zone_ID,'sesuserid'=>$user_id), 'array');
			if($user_type==4){ 
				$user_type = $user_type1[0]['group_id'];			
				$zones = $this->SalesZone->zone_owner_login($user_id);
				if(!empty($zones)){				
					$this->CommonController->setSession('session_zoneid', array('userzoneid'=>$zones[0]['id'],'sesuserid'=>$user_id), 'array');
					
					$this->CommonController->setSession('session_login_details', array('type'=>$user_type,'id'=>$zones[0]['id']), 'array');
					$update_zone_menu=$this->Category_management_model->update_zone_menu($zones[0]['id']);
					if($zip_claimed_by_user!=''){
						$this->Zips->get_zip_claim($zip_claimed_by_user, $user_id); //exit;
						$this->session->remove('session_zip_claimed_by_user');
						$response = 'claimzip_by_zone_owner!~!'.$zones[0]['id'];
					}else{
						if($zones[0]['status']==1){									
							$response = 'zone_owner!~!'.$zones[0]['id'];
						}else{
							$all_sessiondata = $this->session->all_userdata();
							foreach($all_sessiondata as $key => $sessiondata){
								if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity'){
									$this->session->remove($key);
								}
							}
							$response = 'zone_owner_not_verify!~!'.$zones[0]['id'];
						}
					}
				}
			}else if($user_type==5 || $user_type==13){ 
				$businessDetails = $this->Business->getBusinessByOwnerUserId($user_id);
				$businesses = $this->Business->get_all_businesses_for_user($user_id);
				if(!empty($businesses)){				
					$bid = $businesses[0]['id'];
					$zoneid=$businesses[0]['id'];
					$business_authentication=$this->Business->check_business_authentication($bid); 
					$session_login_details = array('type'=>$user_type,'id'=>$bid);
					$this->CommonController->setSession('session_zoneid', $zoneid);
					$this->CommonController->setSession('session_login_details', $session_login_details);
					if($business_authentication=='business' || $business_authentication=='franchisee' || $business_authentication=='listed'){
						$response='business_owner!~!'.$bid.'!~!'.$user_type;
					}else if($business_authentication=='verification'){
						$response='business_owner!~!'.$bid.'!~!'.$user_type;	
					}else{
						$response='home!~!';
					}
				}else{
					$response='createABusiness!~!1';
				}
				$this->CommonController->SetCookie('timeSlotUserName',$userzone,time()+86500,'','/','');
				$this->CommonController->SetCookie('timeSlotPassword',$password,time()+86500,'','/','');
				$this->CommonController->SetCookie('timeSlotName',$auser->first_name.' '.$auser->last_name,time()+86400,'','/','');
				$this->CommonController->SetCookie('timeSlotEmail',$auser->email,time()+86400,'','/','');
				$this->CommonController->SetCookie('timeSlotBusinessName',isset($businessDetails->name)?$businessDetails->name:'',time()+86400,'','/','');
				$this->CommonController->SetCookie('timeSlotssId',isset($businessDetails->id)?$businessDetails->id:'',time()+86400,'','/','');
				$this->CommonController->SetCookie('timeSlotFrom',1,time()+86400,'','/','');
			}else if($user_type==6){ 
				$snap_zone=$this->ion_auth->get_snap_user_zone($user_id);
				$snap_zone_id=$snap_zone[0]['zoneid'];
				$response='snap_profile!~!'.$userzone;	
			}else if($user_type==10){ 
				$auser = $this->ionAuth->user()->row(); 
				$user_id = $auser->id;
				if($login_type=='main_login'){
					$this->CommonController->setSession('session_normal_user_in_zone', array('sesuserzone'=>$zoneid,'sesusertype'=>'resident_user' ,'usertype' =>$user_type), 'array');
					$this->CommonController->setSession('session_login_details', array('id'=>$zoneid,'type'=>'resident_user' ,'type' =>$user_type), 'array');
					$update_zone_menu=$this->Category_management_model->update_zone_menu($zoneid);
					$response='user_profile!~!'.$zoneid; 
				}else{
					if($login_type!='main_login'){
						$this->CommonController->setSession('session_normal_user_in_zone', array('sesuserzone'=>$userzone,'sesusertype'=>'resident_user' , 'usertype' =>$user_type), 'array');
						$this->CommonController->setSession('session_login_details', array('id'=>$user_id,'type'=>'resident_user' ,'type' =>$user_type,'zone' =>$userzone), 'array');
						$update_zone_menu=$this->Category_management_model->update_zone_menu($userzone);
						$response='snap_profile!~!'.$userzone.'!~!'.$user_type;	
					}else{
						$response='<span style="color:red">Invalid User.</span>!~!0';
					}
				}
			}else if($user_type==8){
					$organization=$this->ionAuth->check_organization($user_id);			
					if(!empty($organization)){
						$this->CommonController->setSession('session_orgid', array('sesorgid'=>$organization[0]['id']));
						$this->CommonController->setSession('session_login_details', array('type'=>$user_type,'id'=>$organization[0]['id']));
						$organizationDetails = $this->Organization_model->getOrganizationDetailsByOwnerId($auser->id);
						$this->CommonController->SetCookie('timeSlotUserName',$username,time()+86500,'','/','');
						$this->CommonController->SetCookie('timeSlotPassword',$password,time()+86500,'','/','');
						$this->CommonController->SetCookie('timeSlotName',$auser->first_name.' '.$auser->last_name,time()+86500,'','/','');
						$this->CommonController->SetCookie('timeSlotEmail',$auser->email,time()+86500,'','/','');
						$this->CommonController->SetCookie('timeSlotBusinessName',$organizationDetails->name,time()+86400,'','/','');
						$this->CommonController->SetCookie('timeSlotssId',$organizationDetails->id,time()+86400,'','/','');
						$this->CommonController->SetCookie('timeSlotFrom',2,time()+86400,'','/','');
						$response ='organization!~!'.$organization[0]['id'].'!~!'.$organization[0]['zoneid'];
					}
				}else if($user_type==7){   
 					if($login_type=='main_login'){
						$session_normal_user_in_zone = array('sesuserzone'=>$zoneid,'sesusertype'=>'resident_user');                   		
						$this->session->set('session_normal_user_in_zone',$session_normal_user_in_zone);
						$update_zone_menu=$this->Category_management_model->update_zone_menu($zoneid);
						$response='user_profile!~!'.$zoneid; 
					}else{
						if($login_type!='main_login'){
							$session_normal_user_in_zone = array('sesuserzone'=>$userzone,'sesusertype'=>'resident_user');                   		
							$this->session->set('session_normal_user_in_zone',$session_normal_user_in_zone);
							$update_zone_menu=$this->Category_management_model->update_zone_menu($userzone);
							$response='snap_profile!~!'.$userzone.'!~!'.$user_type;	
						}else{
							$response='<span style="color:red">Invalid User.</span>!~!0';
						}
					}
				}else if($user_type==15){ 
 					if($login_type=='main_login'){
						$session_normal_user_in_zone = array('sesuserzone'=>$zoneid,'sesusertype'=>'resident_user');                   		
						$this->session->set('session_normal_user_in_zone',$session_normal_user_in_zone);
						$update_zone_menu=$this->Category_management_model->update_zone_menu($zoneid);
						$response='user_profile!~!'.$zoneid; 
					}else{
						if($login_type!='main_login'){
							$session_normal_user_in_zone = array('sesuserzone'=>$userzone,'sesusertype'=>'resident_user');                   		
							$this->session->set('session_normal_user_in_zone',$session_normal_user_in_zone);
							$update_zone_menu=$this->Category_management_model->update_zone_menu($userzone);
							$response='snap_profile!~!'.$userzone.'!~!'.$user_type;	
						}else{
							$response='<span style="color:red">Invalid User.</span>!~!0';
						}
					}
				}else if($user_type==9){
					$response='rating_profile!~!'.$user_id;
				}else if($user_type==14){ 
					$realtor = $this->ion_auth->check_realtor($user_id);
					if(!empty($realtor)){
						$session_realtorid =array(
							'sesrealid'=>$realtor['0']['id']
						);
						$this->session->set('sesrealid',$session_realtorid);
						$session_login_details1 = array('type'=>$user_type,'id'=>$realtor['0']['id']);    
						$this->session->set('usersessionrealtordata','usersessionrealtordata') ;
						$user_type = $user_type1[0]['group_id'];	
						$response='realtor!~!'.$user_id;
					}
				}else{
					$response='zipadmin!~!';
				}
			}else{
				$response='<span style="color:red">Invalid Username or Password.</span>!~!0';
			}
			if($via == ''){
				echo json_encode($response);
			}
	}

/*=======login from pboo start========*/

	function login_from_peekaboo(){

		$callback ='mycallback'; 

		$response_arr = array();

/*		if (isset($_GET['loginrequestformpboo'])) {

			$response= array();

		}*/


		$this->load->library('session');

		$this->session->unset_userdata('user_id');  ///// remove later ------ 26-02-2015

		$username =(!empty($_REQUEST['username']))? $_REQUEST['username'] : "";

		$password = (!empty($_REQUEST['password']))? $_REQUEST['password'] : "";

		$userzone = (!empty($_REQUEST['userzone']))? $_REQUEST['userzone'] : "";

		$login_type = (!empty($_REQUEST['login_type']))? $_REQUEST['login_type'] : "";

		$zip_claimed_by_user = (!empty($_REQUEST['zip_claimed_by_user']))? $_REQUEST['zip_claimed_by_user'] : "";

		$zoneid = (!empty($_REQUEST['zoneid_login'])) ? $_REQUEST['zoneid_login'] : "" ; 

		

		//$group_usertype = $this->sales_zone->user_group_id($username);

		//$group_id = $group_usertype['group_id'];

		//$user_status = $group_usertype['status'];

		//var_dump();

		//echo $login_type;

		//var_dump($userzone); exit;

		$remember='';





		//if($zoneid==308){

			log_message('custom', '<br/>==================================== Log start =============================== <br/>');

			log_message('custom', '<br/>----------------------------------- REQUEST PARAMETERS START---------------------------------- <br/>');

			log_message('custom', json_encode($_REQUEST));

			log_message('custom', '<br/>------------------------------------ REQUEST PARAMETERS END-------------------------------- <br/>');

			

			//show_error('custom', 'The purpose of some variable is to provide some value.');

		//}

		//isset($_REQUEST['business_id']) && $_REQUEST['business_id']!='' ? $business_id=$_REQUEST['business_id'] : $business_id='';  

		//$from_where = (!empty($_REQUEST['from_where']))? $_REQUEST['from_where'] : "";

		log_message('custom', '<br/>----------------------------------- LOGIN  ---------------------------------- <br/>');

		if($this->session->userdata('user_id')!=''){  

			//var_dump($this->session->userdata('session_zoneid')); exit;



			$userdata = $this->session->userdata('session_zoneid');

			$zoneid = $userdata['userzoneid'];

			/*log_message('custom', '<br/>----------------------------------- IF USER ID IS BLANK  ---------------------------------- <br/>');

			log_message('custom', json_encode($userdata)););

			log_message('custom', '<br/>-------------------------------------------------------------------- <br/>');

			log_message('custom', $zoneid);

			log_message('custom', '<br/>-------------------------------------------------------------------- <br/>');*/

			redirect("/index.php?zone=".$zoneid, 'refresh');

		}else

		if ($this->ion_auth->login($username, $password, $remember)){

			//log_message('custom', '<br/>----------------------------------- LOGGIN SUCCESSFULL---------------------------------- <br/>');



			

			// create cookie to avoid hitting this case again

			// create cookie to avoid hitting this case again

			$classifiedsUserName = array(

				'name'   => 'neighbors_classifieds_username',

				'value'  => $username,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($classifiedsUserName);



			$timeSlotCookieUsername = array (

				'name'   => 'timeSlotUserName',

				'value'  => $username,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => ''

			);

			set_cookie($timeSlotCookieUsername);



			$timeSlotPassword = array (

									'name'   => 'timeSlotPassword',

									'value'  => $password,

									'expire' => time()+86500,

									'domain' => '',

									'path'   => '/',

									'prefix' => ''

										);

			set_cookie($timeSlotPassword);



			$timeSlotname = array(

							'name'    =>'timeSlotName',

							'value'   => $auser->first_name.' '.$auser->last_name,

							'expire'  => time()+86400,

							'domain'  => '',

							'path'    => '/',

							'prefix'  => ''

						);

			set_cookie($timeSlotname);



			$timeSlotEmail = array (

							'name'   => 'timeSlotEmail',

							'value'  => $auser->email,

							'expire' => time()+86400,

							'domain' => '',

							'path'   => '/',

							'prefix' => ''

						);

			set_cookie($timeSlotEmail);

			

			// create cookie to avoid hitting this case again

			$classifiedsPassword = array(

				'name'   => 'neighbors_classifieds_password',

				'value'  => $password,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($classifiedsPassword);

			$classifiedsZoneId = array(

				'name'   => 'neighbors_classifieds_zoneid',

				'value'  => $userzone,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($classifiedsZoneId);

			$cookie = array(

				'name'   => 'blog_username',

				'value'  => $username,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($cookie);

			

			// create cookie to avoid hitting this case again

			$cookie = array(

				'name'   => 'blog_password',

				'value'  => $password,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($cookie);

			// Set user password in session

			//$this->session->set_userdata($password);



			$auser = $this->ion_auth->user()->row(); 

            $user_id = $auser->id; 

            $user_name = $auser->username;

            //$user_id = '1600044';

            $classifiedsUserId = array(

				'name'   => 'neighbors_classifieds_userid',

				'value'  => $user_id,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($classifiedsUserId);

			$user_type1=$this->ion_auth->check_user_type($user_id);

			$user_type = $user_type1[0]['group_id']; //print_r($user_type1)  exit;

			log_message('custom', '<br/>----------------------------------- user type START---------------------------------- <br/>');

			log_message('custom', $user_type);

			log_message('custom', '<br/>------------------------------------ user type END-------------------------------- <br/>');

			 


			//echo $user_type; exit;

//var_dump($user_type); 

			/*$session_login_details = array('type'=>$user_type);        			

			$this->session->set_userdata('session_login_details',$session_login_details);*/

			if($user_type==4){ // For Zone Owner

				$user_type = $user_type1[0]['group_id'];			

				$zones = $this->sales_zone->zone_owner_login($user_id);

				log_message('custom', '<br/>----------------------------------- zones START---------------------------------- <br/>');

				log_message('custom', json_encode($zones));

				log_message('custom', '<br/>------------------------------------ zones END-------------------------------- <br/>');

			 

				//var_dump($zones); exit;

				//If zone owner pick first zone dashboard

				if(!empty($zones)){				

					$session_zoneid = array(                   		

                   		'userzoneid'=>$zones[0]['id'],

						'sesuserid'=>$user_id

        			);

					$this->session->set_userdata('session_zoneid',$session_zoneid);

					$session_login_details = array('type'=>$user_type,'id'=>$zones[0]['id']); 			

					$this->session->set_userdata('session_login_details',$session_login_details);

					//var_dump($this->session->all_userdata());

					//base_url().'blog/blog1.php';

					/*// create cookie to avoid hitting this case again

					$cookie = array(

						'name'   => 'blog_username',

						'value'  => $username,

						'expire' => time()+86500,

						'domain' => '',

						'path'   => '/',

						'prefix' => '',

					);

					set_cookie($cookie);

					

					// create cookie to avoid hitting this case again

					$cookie = array(

						'name'   => 'blog_password',

						'value'  => $password,

						'expire' => time()+86500,

						'domain' => '',

						'path'   => '/',

						'prefix' => '',

					);

					set_cookie($cookie);*/

					$update_zone_menu=$this->category_model->update_zone_menu($zones[0]['id']);

					if($zip_claimed_by_user!=''){

						$this->zips->get_zip_claim($zip_claimed_by_user, $user_id); //exit;

			 			$this->session->unset_userdata('session_zip_claimed_by_user');

						$response_arr['response'] = 'claimzip_by_zone_owner!~!'.$zones[0]['id'];

					}else{

						if($zones[0]['status']==1){									

							$response_arr['response'] = 'zone_owner!~!'.$zones[0]['id'];

						}else{

							$all_sessiondata = $this->session->all_userdata();//var_dump($all_sessiondata);exit;

							foreach($all_sessiondata as $key => $sessiondata){//echo "<pre>"; var_dump($key);

							  if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity'){

							         $this->session->unset_userdata($key);

							  }

							}

							$response_arr['response'] = 'zone_owner_not_verify!~!'.$zones[0]['id'];

						}

					}

					/*$a = $this->session->all_userdata();

					log_message('custom', '<br/>----------------------------------- all userdata START---------------------------------- <br/>');

			log_message('custom', json_encode($a);

			log_message('custom', '<br/>------------------------------------ all userdata END-------------------------------- <br/>');*/

				}/*else{

					$response='<span style="color:red">Please verify your account.</span>!~!0';

				}*/

			}else if($user_type==5 || $user_type==13){ // For business Owner

//var_dump($user_type==13);

				 //If business owner pick first business

				$businessDetails = $this->business->getBusinessByOwnerUserId($user_id);

				$businesses = $this->business->get_all_businesses_for_user($user_id);



				if(!empty($businesses)){				

					$bid = $businesses[0]['id'];

					$zoneid=$businesses[0]['id'];

					$business_authentication=$this->business->check_business_authentication($bid); 

					$session_login_details = array('type'=>$user_type,'id'=>$bid);        			

					$this->session->set_userdata('session_login_details',$session_login_details);

					//var_dump($bid); exit;

					// newly added for new dashboard start					

					/*$session_business_arr = array('zoneid'=>$zoneid,'userid'=>$user_id,'user_groupid'=>$user_type);

					$this->session->set_userdata('session_business',$session_business_arr);*/

					// newly added for new dashboard end

					if($business_authentication=='business' || $business_authentication=='franchisee' || $business_authentication=='listed'){

						$response_arr['response']='business_owner!~!'.$bid.'!~!'.$user_type.'!~!'.$user_id.'!~!'.$user_name;

						// added user type for peekaboologin on 8.jan.2016

					}else if($business_authentication=='verification'){

						//$response='verification!~!'.$bid;

						$response_arr['response']='business_owner!~!'.$bid.'!~!'.$user_type.'!~!'.$user_id.'!~!'.$user_name;	// added user type for peekaboologin on 8.jan.2016

					}/*else if($business_authentication=='listed'){ // Updated 8.6.2015(CSV UPLOADED BUSINESS WILL GET BUSINESS DASHBOARD SOON AFTER LOGIN)

						$response='listed!~!'.$bid;

					}*/else{

						$response_arr['response']='home!~!';

					}

					/*$listed_businesses = $this->business->check_listed_business($bid);

					//var_dump($listed_businesses); exit;

					if($listed_businesses>=1){

						//redirect("auth/verification/$bid", 'refresh');

						$response='verification!~!'.$bid;

					}else{

						//redirect("dashboards/business/$bid", 'refresh');

						$response='business_owner!~!'.$bid;

					}*/

					

				}else{

					//redirect("dashboards/createABusiness/1", 'refresh');

					$response_arr['response']='createABusiness!~!1';

				}

				//echo "5555"; exit;

				$timeSlotCookieUsername = array (

											'name'   => 'timeSlotUserName',

											'value'  => $username,

											'expire' => time()+86500,

											'domain' => '',

											'path'   => '/',

											'prefix' => ''

										);

				set_cookie($timeSlotCookieUsername);

				$timeSlotPassword = array (

										'name'   => 'timeSlotPassword',

										'value'  => $password,

										'expire' => time()+86500,

										'domain' => '',

										'path'   => '/',

										'prefix' => ''

										 );

				set_cookie($timeSlotPassword);

				$timeSlotname = array(

										'name'    =>'timeSlotName',

										'value'   => $auser->first_name.' '.$auser->last_name,

										'expire'  => time()+86400,

										'domain'  => '',

										'path'    => '/',

										'prefix'  => ''

									 );

				set_cookie($timeSlotname);

				$timeSlotEmail = array (

										 'name'   => 'timeSlotEmail',

										 'value'  => $auser->email,

										 'expire' => time()+86400,

										 'domain' => '',

										 'path'   => '/',

										 'prefix' => ''

									   );

				set_cookie($timeSlotEmail);

				$timeSlotBusinessName = array (

												'name'   => 'timeSlotBusinessName',

												'value'  => $businessDetails->name,

												'expire' => time()+86400,

												'domain' => '',

												'path'   => '/',

												'prefix' => ''

											  );

				set_cookie($timeSlotBusinessName);

				$timeSlotssId = array (	

												'name'    => 'timeSlotssId',

												'value'   => $businessDetails->id,

												'expire'  => time()+86400,

												'domain'  => '',

												'path'    => '/' 

											);

				set_cookie($timeSlotssId);

				$timeSlotFrom       = array (

												'name'   => 'timeSlotFrom',

												'value'  => 1,

												'expire' => time()+86400,

												'domain' => '',

												'path'   => '/'

											);

				set_cookie($timeSlotFrom);

			}else if($user_type==6){ 

				$snap_zone=$this->ion_auth->get_snap_user_zone($user_id);

				$snap_zone_id=$snap_zone[0]['zoneid'];

				$response_arr['response']='snap_profile!~!'.$userzone.'!~!'.$user_id.'!~!'.$user_name;	

			}else if($user_type==10 || $user_type==15 || $user_type==7 ){ 

				//redirect("welcome/profile", 'refresh');

				/*print_r($this->session->userdata); 

				//var_dump($this->session->userdata('session_zoneid_x'));

				$xxx=$this->session->userdata('session_zoneid_x');

			    $session_zoneid_for_user_xxx=$xxx['session_zoneid_for_user_reg'];

				var_dump($session_zoneid_for_user_xxx); exit;*/ 

				////$session_normal_user_in_zone = array('sesuserzone'=>$userzone);                   		

                ////$this->session->set_userdata('session_normal_user_in_zone',$session_normal_user_in_zone);

				//$snap_zone=$this->ion_auth->get_snap_user_zone($user_id);

				//var_dump($aa);

				//print_r($this->session->userdata); exit;

				//$snap_zone_id=$snap_zone[0]['zoneid']; //var_dump($snap_zone_id); exit;

				//$response='user_profile!~!'.$zoneid;

				if($login_type=='main_login'){

					$session_normal_user_in_zone = array('sesuserzone'=>$zoneid,'sesusertype'=>'resident_user');                   		

					$this->session->set_userdata('session_normal_user_in_zone',$session_normal_user_in_zone);

					

					$update_zone_menu=$this->category_model->update_zone_menu($zoneid);

					$response_arr['response']='user_profile!~!'.$zoneid; 

					log_message('custom', '<br/>----------------------------------- Neighbors login response ---------------------------------- <br/>');

					log_message('custom', $response_arr['response']);

					log_message('custom', '<br/>------------------------------------ Neighbors login response -------------------------------- <br/>');

				}else{

					if($login_type!='main_login'){

						$session_normal_user_in_zone = array('sesuserzone'=>$userzone,'sesusertype'=>'resident_user');                   		

						$this->session->set_userdata('session_normal_user_in_zone',$session_normal_user_in_zone);

						$update_zone_menu=$this->category_model->update_zone_menu($userzone);

						$response_arr['response']='snap_profile!~!'.$userzone.'!~!'.$user_type.'!~!'.$user_id.'!~!'.$user_name;	// added user type for peekaboologin on 8.jan.2016

					}else{

						$response_arr['response']='<span style="color:red">Invalid User.</span>!~!0';

					}

				}

			}else if($user_type==8){ // For Organization user

				$organization=$this->ion_auth->check_organization($user_id);			

				if(!empty($organization)){

					$session_orgid = array(                   		

                   		'sesorgid'=>$organization[0]['id']					

        			);

					$this->session->set_userdata('session_orgid',$session_orgid);

					$session_login_details = array('type'=>$user_type,'id'=>$organization[0]['id']);        			

					$this->session->set_userdata('session_login_details',$session_login_details);

					$organizationDetails = $this->org_model->getOrganizationDetailsByOwnerId($auser->id);

					$timeSlotCookieUsername = array (

											'name'   => 'timeSlotUserName',

											'value'  => $username,

											'expire' => time()+86500,

											'domain' => '',

											'path'   => '/',

											'prefix' => ''

										);

				  set_cookie($timeSlotCookieUsername);

				  $timeSlotPassword = array (

											'name'   => 'timeSlotPassword',

											'value'  => $password,

											'expire' => time()+86500,

											'domain' => '',

											'path'   => '/',

											'prefix' => ''

											 );

					set_cookie($timeSlotPassword);

				$timeSlotname = array(

										'name'    =>'timeSlotName',

										'value'   => $auser->first_name.' '.$auser->last_name,

										'expire'  => time()+86400,

										'domain'  => '',

										'path'    => '/',

										'prefix'  => ''

									 );

				set_cookie($timeSlotname);

				$timeSlotEmail = array (

										 'name'   => 'timeSlotEmail',

										 'value'  => $auser->email,

										 'expire' => time()+86400,

										 'domain' => '',

										 'path'   => '/',

										 'prefix' => ''

									   );

				set_cookie($timeSlotEmail);

				$timeSlotBusinessName = array (

												'name'   => 'timeSlotBusinessName',

												'value'  => $organizationDetails->name,

												'expire' => time()+86400,

												'domain' => '',

												'path'   => '/',

												'prefix' => ''

											  );

				set_cookie($timeSlotBusinessName);

				$timeSlotssId = array (	

												'name'    => 'timeSlotssId',

												'value'   => $organizationDetails->id,

												'expire'  => time()+86400,

												'domain'  => '',

												'path'    => '/' 

											);

				set_cookie($timeSlotssId);

				$timeSlotFrom       = array (

												'name'   => 'timeSlotFrom',

												'value'  => 2,

												'expire' => time()+86400,

												'domain' => '',

												'path'   => '/'

											);

				set_cookie($timeSlotFrom);

					//$organizationDetails = 				

					//$response ='organization!~!'.$organization[0]['orgid'];

					//$response = json_encode($auser);

					$response_arr['response'] ='organization!~!'.$organization[0]['id'].'!~!'.$user_id.'!~!'.$user_name;

					//redirect("dashboards/organization/$org_id", 'refresh');

				}

			}

			else if($user_type==9){

				//$user_id;exit;

				//$data=array('business_id'=>$business_id,'userid'=>$user_id); 

				//$response=json_encode($data);				

				$response_arr['response']='rating_profile!~!'.$user_id.'!~!'.$user_name;

			}

			else if($user_type==14){ 

			    

			   $realtor = $this->ion_auth->check_realtor($user_id);

			    if(!empty($realtor)){

			       $session_realtorid =array(

					        'sesrealid'=>$realtor['0']['id']

				   );

			    $this->session->set_userdata('sesrealid',$session_realtorid);

				$session_login_details1 = array('type'=>$user_type,'id'=>$realtor['0']['id']);    

				$this->session->set_userdata('usersessionrealtordata','usersessionrealtordata') ;

				$user_type = $user_type1[0]['group_id'];	

				$response_arr['response']='realtor!~!'.$user_id.'!~!'.$user_name;

				//$response='realtor!~!'.$user_id;

			}

		}

			else{

				//redirect("dashboards/zipadmin", 'refresh');

				$response_arr['response']='zipadmin!~!';

			}



		}else{

			$response_arr['response']='<span style="color:red">Invalid Username or Password.</span>!~!0';

		}

/*		if (isset($_GET['loginrequestformpboo'])) {

			$response=json_encode($response);

		}*/

		

		//$message='Invalid Username or Password. Please Try again.';

		/*echo $response;*/

		echo $callback.'(' . json_encode($response_arr) . ')';

				//echo($this->dr->GetDR("", $message, "", "0"));

		

	}

/*=======login from pboo end=========*/

	function login_from_zone_page_rating(){

		

		//var_dump($_REQUEST);

		/*$username =(!empty($_REQUEST['username']))? $_REQUEST['username'] : "";

		$password = (!empty($_REQUEST['password']))? $_REQUEST['password'] : "";*/

		$username =(!empty($_REQUEST['username']))? $_REQUEST['username'] : "";

		$password = (!empty($_REQUEST['password']))? $_REQUEST['password'] : "";

		$businessid =(!empty($_REQUEST['business_id']))? $_REQUEST['business_id'] : 0;

		$adid = (!empty($_REQUEST['adid']))? $_REQUEST['adid'] : 0;

		$zoneid =(!empty($_REQUEST['zoneid']))? $_REQUEST['zoneid'] : 0;

		$type = (!empty($_REQUEST['type']))? $_REQUEST['type'] : 0;

		$from = (!empty($_REQUEST['from']))? $_REQUEST['from'] : 1;

		$remember='';

		

     	 

		if ($this->ion_auth->login($username, $password, $remember)){

			$session_normal_user_in_zone = array('sesuserzone'=>$zoneid,'sesusertype'=>'resident_user');                   		

        	$this->session->set_userdata('session_normal_user_in_zone',$session_normal_user_in_zone);

			$usersession_data = $this->session->userdata('session_normal_user_in_zone');

			$auser = $this->ion_auth->user()->row();

            $user_id = $auser->id;

			$update_zone_menu=$this->category_model->update_zone_menu($zoneid);			

			$data=array('business_id'=>$businessid,'userid'=>$user_id,'zoneid'=>$zoneid,'adid'=>$adid,'type'=>$type); 

			$response=json_encode($data);

		

		}else{

			$response='<span style="color:red">Invalid Username or Password.</span>';

		}

		/*$username =(!empty($_REQUEST['username']))? $_REQUEST['username'] : "";

		$password = (!empty($_REQUEST['password']))? $_REQUEST['password'] : "";

		$businessid =(!empty($_REQUEST['businessid']))? $_REQUEST['businessid'] : 0;

		$adid = (!empty($_REQUEST['adid']))? $_REQUEST['adid'] : 0;

		$zoneid =(!empty($_REQUEST['zoneid']))? $_REQUEST['zoneid'] : 0;

		$type = (!empty($_REQUEST['type']))? $_REQUEST['type'] : 0;

		

		

		$response='s';*/

		echo $response;

	}

	

	


	// when business owner verify the business

	function verification($bid=false){    

		$scripts = array("assets/scripts/auth/profile.js","assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js");

		$this->check_login_status("auth/verification/" . $bid);

		$user = $this->ion_auth->user()->row();

		//var_dump($user);

/*		echo $bid;

		echo '<pre>';

		print_r($user);

		die ();*/

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		//var_dump($uid);

        if (empty($user) || empty($bid)) {

            redirect('welcome/index', 'refresh');

        }

		//var_dump($this->session->userdata('usersessiondata'));

		if($this->session->userdata('usersessiondata')){

			$this->session->unset_userdata('usersessiondata');

			//var_dump($this->session->userdata('usersessiondata'));

		}

		$data=array();

		$data['bid'] = $bid;

		$data['user']=$user;

		$data['where_from']='business_verification';

		$data['business'] = $this->business->get_business_by_id($bid); //var_dump($data['business']);

		$data['state_list'] = $this->states->get_state_dropdown();

		//var_dump($data['state_list']);

		//$data["user"] = $this->ion_auth->user()->row();

		//$data['zoneid']=$zid;

		//var_dump($data["user"]);

		//if($data["user"]){

			/*$data['message'] = str_replace('#', '', $this->session->flashdata('message'));

			$data['scripts'] = $scripts;

			$data['title'] = "Delete Zone";

			$data["firstName"] = $data["user"]->first_name;   

			$data['zoneinformation'] = $this->announcements->get_zoneinformation($zid); // get zone informations

			//var_dump($data['zoneinformation']);

			$data['zonename']=$data['zoneinformation']->zname;

			$data['csses'] = array('assets/stylesheets/common.css','assets/stylesheets/template.css');*/

			$data['content'] = $this->load->view('default/verification', $data, true);

			$data['hideSlider'] = true;

			$this->load->view("default/blank", $data);

		//}

	}

	function listed_business_verification($bid=''){ 

		//var_dump($bid); exit;

		//print_r($this->session->all_userdata());

		$scripts = array("assets/scripts/auth/profile.js","assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js");

		$this->check_login_status("auth/listed_business_information/" . $bid);

		$user = $this->ion_auth->user()->row();

/*		echo $bid;

		echo '<pre>';

		print_r($user);

		die ();*/

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		//var_dump($uid);

        if (empty($user) || empty($bid)) {

            redirect(base_url(), 'refresh');

        }

		$data=array();

		$data['uid']=$uid;

		$data['bid'] = $bid;

		$data['business'] = $this->business->get_business_by_id($bid); //print_r($data['business']); //exit;

		$data['ad'] = $this->ad->get_ads_by_business_id($bid); //var_dump($data['ad']);

		 

		$data['zone_details']=$this->sales_zone->get_zones_by_business_id($bid); 

		$zoneid=$data['zone_details']->settingszoneid; //var_dump($zoneid);

		//var_dump($data['zone_details']);

		//$data['category_list_bus'] = $this->Category_new_model->get_all_categories_business($bid,''); //var_dump($data['category_list_bus']);

		$data['category_list_bus']=$this->Category_new_model->get_all_categories_zone_create_business('',3,$zoneid,'create_business',4);

		$data['state_list'] = $this->states->get_state_dropdown(); //var_dump($data['state_list']);

		//var_dump($data['zone_details']);

		//var_dump($data['state_list']);

		//$data["user"] = $this->ion_auth->user()->row();

		//$data['zoneid']=$zid;

		//var_dump($data["user"]);

		//if($data["user"]){

			/*$data['message'] = str_replace('#', '', $this->session->flashdata('message'));

			$data['scripts'] = $scripts;

			$data['title'] = "Delete Zone";

			$data["firstName"] = $data["user"]->first_name;   

			$data['zoneinformation'] = $this->announcements->get_zoneinformation($zid); // get zone informations

			//var_dump($data['zoneinformation']);

			$data['zonename']=$data['zoneinformation']->zname;

			$data['csses'] = array('assets/stylesheets/common.css','assets/stylesheets/template.css');*/

			//$data['content'] = $this->load->view('default/listed_business_information', $data, true);

			

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

			

			$data['hideSlider'] = true;

			//$data['category_list_bus'] = $this->category_model->get_all_categories_business($bid); //var_dump($data['category_list_bus']);

			$update_zone_menu=$this->category_model->update_zone_menu($zoneid);

			

			$data["usergroup"]=$this->business->get_user_group1($uid); // get user from which group

			if(!empty($data["usergroup"])){

			$usergrid=$data["usergroup"]->group_id;

			}

			/*$bzid=$this->business->get_businessin_zone($id);

			$userzoneid=$bzid->settingszoneid;*/

			$newsessiondata = array(

                   'usergrid'=>$usergrid,

                   'userzoneid'=>$zoneid

        );

		

		$this->session->set_userdata('usersessiondata',$newsessiondata); // assign session for logout redirection

			

		//print_r($this->session->all_userdata());	

			//var_dump($data['category_list_bus']);

			//$data['from_where']='from_listed_business';

			//var_dump($data['from_where']);

			$this->load->view("default/listed_business_information", $data);

		//}

	}

	public $session_arr = array() ;

	public function check_authentication(){
		$user = $this->ionAuth->user()->row();
		$this->session_arr = implode(' ' ,$this->session_arr) == '' ? $this->session->get() : $this->session_arr ;	
		if( $this->session->get('user_id') == '' && $this->input->cookie('blog_username') ){
			if( implode(' ' ,$this->session_arr) != '' ){
				$this->session->set($this->session_arr) ;
			}	
		}
		
		if($this->session->get('user_id')!=''){
			echo 1;
		}else{
			echo 0;
		}
	}

	function profile()

    {

        if (!$this->ion_auth->logged_in())

        {

            //redirect them to the login page

            redirect('auth/login', 'refresh');

        }

        $scripts = array("assets/scripts/auth/profile.js","assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js");

        $data["user"] = $this->ion_auth->user()->row();

        $data['scripts'] = $scripts;

        $data['message'] = str_replace('#', '', $this->session->flashdata('message'));

        $data['title'] = "Profile";

        $data['new_password'] = "";

        $data['new_password_confirm'] = "";

        $data["firstName"] = "";

        $data["lastName"] = "";

        $data["email"] = "";

        $data["full_name"] = "";

        $data["phone"] = "";

        $data["admin"] = "";

        $data["address"] = "";

        $data["city"] = "";

        $data["state_Code"] = "";

        $data["zip"] = "";

        $data["username"] = "";

        $data["id"] = 0;

        $data["referred" ] = "claimzips/claimedzips";

        if ($this->ion_auth->logged_in())

        {

            $user = $this->ion_auth->user()->row();

            $data["firstName"] = $user->first_name;

            $data["email"] = $user->email;

            $data["full_name"] = $user->first_name . " " . $user->last_name;

            $data["admin"] = $this->ion_auth->in_group(array( "Tier I")) ? "yes" : "";

            $data["lastName"] = $user->last_name;

            $data["phone"] = $user->phone;

            $data["address"] = $user->Address;

            $data["city"] = $user->City;

            $data["state_Code"] = $user->State_Code;

            $data["zip"] = $user->Zip;

            $data["username"] = $user->username;

            $data["id"] = $user->id;

        

        }

        $data['csses'] = array('assets/stylesheets/common.css','assets/stylesheets/template.css');

   

        $zipData = array();

        $zipData['checkbox'] = 0;

        $zipData['claim_status'] = 0;

        $zipData['approve_status'] = "Approval Status";

        $zipData['zips'] = $this->zips->get_full_zip_list($this->input->post('txtZip'), $this->ion_auth->user()->row()->id);

      

        $data['my_zips'] = $this->load->view("claimzips/zipdata", $zipData, true);

        $data['state_list'] = $this->states->get_state_dropdown();

        

        $this->load->view("claimzips/header", $data);

        $this->load->view("claimzips/buttons", $data);

        $this->load->view("auth/profile", $data);

    }

    

	

	

	

	

	

	//log the user in

	

	

	

	



	


















	function deleteZone($zid=false){    // add for delete zone 07.02.2013

		

		$scripts = array("assets/scripts/auth/profile.js","assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js");

		$data["user"] = $this->ion_auth->user()->row();

		$data['zoneid']=$zid;

		//var_dump($data["user"]);

		if($data["user"]){

			$data['message'] = str_replace('#', '', $this->session->flashdata('message'));

			$data['scripts'] = $scripts;

			$data['title'] = "Delete Zone";

			$data["firstName"] = $data["user"]->first_name;   

			$data['zoneinformation'] = $this->announcements->get_zoneinformation($zid); // get zone informations

			//var_dump($data['zoneinformation']);

			$data['zonename']=$data['zoneinformation']->zname;

			//$data['csses'] = array('assets/stylesheets/common.css','assets/stylesheets/template.css');

			//$data['content'] = $this->load->view('default/deletezone', $data, true);

			$data['hideSlider'] = true;

			$this->load->view("default/deletezone", $data);

		}

	}

    function create_user_link()

    {

        $scripts = array("assets/scripts/auth/profile.js","assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js");

        $data["user"] = $this->ion_auth->user()->row();

        $data['scripts'] = $scripts;

        $data['message'] = str_replace('#', '', $this->session->flashdata('message'));

        $data['title'] = "Create User";

        $data['new_password'] = "";

        $data['new_password_confirm'] = "";

        $data["firstName"] = "";

        $data["lastName"] = "";

        $data["email"] = "";

        $data["full_name"] = "";

        $data["phone"] = "";

        $data["admin"] = "";

        $data["address"] = "";

        $data["city"] = "";

        $data["stateCode"] = "";

        $data["zip"] = "";

        $data["username"] = "";

        $data["id"] = 0;

             

        $data['csses'] = array('assets/stylesheets/common.css','assets/stylesheets/template.css');

        $data['state_list'] = $this->states->get_state_dropdown();

        

        $this->load->view("claimzips/header", $data);

        $this->load->view("claimzips/buttons", $data);

        $this->load->view("auth/profile", $data);

    

    }

	





	function _get_csrf_nonce()

	{

		$this->load->helper('string');

		$key = random_string('alnum', 8);

		$value = random_string('alnum', 20);

		$this->session->set_flashdata('csrfkey', $key);

		$this->session->set_flashdata('csrfvalue', $value);



		return array($key => $value);

	}



	function _valid_csrf_nonce()

	{

		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&

				$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))

		{

			return TRUE;

		}

		else

		{

			return FALSE;

		}

	}

	

	

	

	private function check_login_status($return_page)

    {

		//var_dump($return_page); exit;

        if (!$this->ion_auth->logged_in())

        {

            //redirect them to the login page

            $this->session->set_userdata('return_page', $return_page);

            redirect('welcome/index', 'refresh');

        }

    }



function update_profile(){   // this function is not needed for new design --- 15.5.13

    

        $id = $this->input->post('id');

        $first = $this->input->post('Firstname');

        $last = $this->input->post('Lastname');

        $email = $this->input->post('Email');

        $phone = $this->input->post('Phone');

        $address = $this->input->post('Address');

        $city = $this->input->post('City');

        $state = $this->input->post('State');

        $zip = $this->input->post('Zip');

        if(empty($id)){

            $password = $this->input->post('new_password');

            $confirm_password = $this->input->post('password_confirm');

            $accountType= $this->input->post('owner_type');

			$username = $this->input->post('Username');

			$accountGroups = array();

            $accountGroups[] = ($accountType == 'zone_owner') ? "4" : "5";

			$zonename= $this->input->post('Zonename');

			$additional_data = array('first_name' => $first,

				'last_name' => $last,

				'phone' => $phone,

                'Address' => $address,

                'City' => $city,

                'State_Code' => $state,

                'Zip' => $zip

			);

			//var_dump($zonename);  var_dump($username); exit; 

           $id = $this->ion_auth->register($username, $password, $email, $additional_data, $accountGroups);

			

			// this is commented for local

				/*$path = "http://savingssites.com";

				$login_path = "http://savingssites.com/welcome/zone_login";

				$link="http://savingssites.com/welcome/account_verification/774/12345";

				$message="<div style='border:1px solid #900; padding:5px;'>Dear ".$username.",<br /><br />

						Thank you for register in SavingsSites. To learn more about SavingsSites and it's benefits, please click <a href='".$path."'>HERE</a><br/><br/>										

						

						To complete your registration, simple click the following link<br> <a href='".$link."'>Here</a> .<br/><br/>

						If the link does not work for you, then copy/paste the following link in your browser address bar:<br/><br/>".$link."<br/><br/>

											

						You can login into your account and change this information at your convenience.<br /><br />

						We are constantly trying to improve the application and will notify you of future updates as and when they are available. If you have any queries in the meantime then please email us at <a href='mailto:support@savingssites.com'>support@savingssites.com</a> and we will get back to you promptly.<br /><br />

						Best Regards,<br />

						Savings Sites Support." ;

				

				$fromemail=$this->config->item('adminEmailId');

				$this->load->library('email');

				$template_subject="Savings Sites Account verification";

				$this->email->clear();

				$this->email->from($fromemail);

				$this->email->subject($template_subject);

				$this->email->message($message);

				if($email!='')

				{

					$this->email->to($email);

					$this->email->send();

					$to[]=$email;

				}*/

				// end

			

			

		    if(!$id)

            {

                $message = "Register User Failed.";

            }

            else

            {

               $message = "Register User Was Successful, A email is sent to your email.<br/> Please verify your account.";

			   // this is commented for local

				$path = "http://savingssites.com";

				$login_path = "http://savingssites.com/";

				$link="http://savingssites.com/welcome/account_verification/".$id;

				$message_body="<div style='border:1px solid #900; padding:5px;'>Dear ".$username.",<br /><br />

						Thank you for your SavingsSites registration.<br/><br/>To complete your registration, simply click <a href='".$link."'>here</a> .<br/><br/>	

						You can login into your account and change this information at your convenience.<br /><br />

						We are constantly trying to improve the application, and will notify you of future updates <b>when</b> they are available. If you have any <b>questions</b> in the meantime, then please email us at <a href='mailto:support@savingssites.com'>support@savingssites.com</a> and we will get back to you promptly.<br /><br />

						Best Regards,<br />

						Savings Sites Support." ;

				

				$fromemail=$this->config->item('adminEmailId');

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

                if($accountType == 'zone_owner')

                {

                    //$this->sales_zone->create("$last $first", $id);

					 $saleszoneid=$this->sales_zone->create("$zonename", $id);

					// create organization start

					

					$zone_org_announcement = $this->ion_auth->create_zone_org_announcement($id, $saleszoneid);

					

					

					// create organization end

					//$this->sales_zone->create_zone_pref_default_values($id); 

                }

            }



        }

        else

        {

            $change = $this->ion_auth->update_user_ex($id, $first, $last, $email, $phone, $address, $city, $state,$zip);



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

	//log the user out

	function logout_old($return_page = false)

	{

		//$this->session->sess_destroy();

		//var_dump($this->session->all_userdata());exit;

		$this->data['title'] = "Logout";

		//log the user out

		//delete_cookie("theme"); delete_cookie("zoneid");

		//delete_cookie("blog_username"); delete_cookie("blog_password"); delete_cookie("blog_zoneid"); delete_cookie("blog_businessid"); delete_cookie("back_to_blog"); delete_cookie("back_to_blog_path");

		/*var_dump($this->session->userdata('usersessiondata')); 

		var_dump($this->session->userdata('session_zoneid_from_bus'));	 

		exit;*/

		if($this->session->userdata('usersessiondata')){ // this session is set from zone_dashboard 

		    //echo 1; exit; 

			$usersession_data = $this->session->userdata('usersessiondata');

     		$ugid = $usersession_data['usergrid'];

			$uzid = $usersession_data['userzoneid']; //var_dump($uzid);exit; 

			$update_zone_menu=$this->category_model->update_zone_menu($uzid); 

			$this->session->unset_userdata('usersessiondata');

			

			$logout = $this->ion_auth->logout();

			$this->session->sess_destroy();

			//var_dump($this->session->all_userdata());exit;

			//redirect('/', 'refresh');

			redirect('/zone/'.$uzid, 'refresh');

			/*redirect('/zone/load/'.$uzid, 'refresh');*/

		}else{ //echo 2; exit; 

			if($this->session->userdata('session_zoneid_from_bus')){ // this session is set when business oener login

				$usersession_data = $this->session->userdata('session_zoneid_from_bus');

     			$uzid = $usersession_data['buszoneid']; 

				$this->session->unset_userdata('session_zoneid_from_bus');

			     //var_dump($this->session->userdata('usersessiondata'));

				$logout = $this->ion_auth->logout();

				$this->session->sess_destroy();

				//var_dump($this->session->userdata('usersessiondata')); exit;

				redirect('/zone/'.$uzid, 'refresh');

				$uzid='';

			}else{ //echo 3; exit;

				redirect('/', 'refresh');

			}

		}

	}

	function check_session(){

		//print_r($this->session->userdata); echo "1122"; 

		if($this->session->userdata('user_id')!=''){

			echo 1;

		}

		else{

			echo -1;

		}

		//echo -1;

	}

	function timeout_redirect(){

		$this->load->view('default/timeout_redirect');

		$this->session->set_flashdata('message', $this->ion_auth->messages());

		$this->session->set_userdata('return_page', 'welcome/zone_login');	

		$this->data['changepass']="changed";

		$this->data['usertype'] = $usertype ;

		$this->data['message'] = 'Logout' ;				

		$this->data['content'] = $this->load->view('default/timeout_redirect',  true);

		$this->data['hideSlider'] = true;

		$this->load->view("default/common_section", $this->data);

		

		

		$data=array();

		$data['uid_admin']='';

		$data['uid']='';

		$data['login_from_mail']='';

		$data['userid_for_registration']='';

		$link_path = $this->config->item('link_path');

		if($link_path=='')	

			$data['link_path']="../";

		else

			$data['link_path']=$link_path;

		$data['content']=$this->load->view("default/timeout_redirect",$data,TRUE);		

        $this->load->view("default/default_content", $data);

	}

	

	function createABusiness($msg=false)

	{ 

		//isset($_REQUEST['curr_url']) ? setcookie("cur_url", $_REQUEST['curr_url']) : '';

		//$cur_url=$_COOKIE['cur_url'];

		$cur_url=$_COOKIE['cur_url'] = isset($_REQUEST['curr_url']) ? setcookie("cur_url", $_REQUEST['curr_url']) : '';

		// this session variables set in zone function, it's value is zoneid

		$session_cb_arr=$this->session->userdata('create_business_ses_id');

		$session_create_business_zoneid=$session_cb_arr['create_business_sesid'];

		

		

		if(is_object($session_create_business_zoneid)){				

			$zoneid=$session_create_business_zoneid->id;			

		}else{		

			$zoneid=$session_create_business_zoneid;

		}

				

		if($this->ion_auth->logged_in()){

        $data = array();

		$data['cur_url']=$cur_url;

		

		if($this->session->userdata('session_zoneid_from_bus')){ //echo 1; // business owner

			$data['business_exist']=1;

			$usersession_data = $this->session->userdata('session_zoneid_from_bus');

     		$session_type_id=$usersession_data['busid']; //var_dump($session_type_id); //exit;

			$data['req_url']=base_url().'businessdashboard/businessdetail/'.$session_type_id;

		} else if($this->session->userdata('usersessiondata')!=''){ //echo 2;  // zone owner 

			$data['business_exist']=1;

			$session_type_arr=$this->session->userdata('usersessiondata');

			$session_type_id=$session_type_arr['userzoneid']; //var_dump($session_type_id);

			$data['req_url']=base_url().'Zonedashboard/zonedetail/'.$session_type_id;

		}else{ //echo 3;

			$data['business_exist']=0; $data['req_url']=0;

		}

		//var_dump($data['business_exist']);	

		

		

		//$data['business_exist']=$zoneid; 

        $auser = $this->ion_auth->user()->row();	

        if(!empty($auser)){

	        $uid = $auser->id;

			$data["uid"]=$uid;

			$data["email"] = $auser->email;

	        $data["firstName"] = $auser->first_name;

			$data["usergroup"]=$this->business->get_user_group1($uid);

	//var_dump($data["usergroup"]);

        }

		

		$data['category_list']=$this->Category_new_model->get_all_categories_zone($zoneid,'create_business',$data["usergroup"]->group_id);

	//var_dump($data['category_list']); exit;

        $data['msg']=$msg;

        $data['user'] = $auser;

        

        $data['zone_null'] = 'create_business';

        

        $data['referrer'] = !empty($_REQUEST['Referrer']) ? $_REQUEST['Referrer'] : 'dashboards';

        $data['state_list'] = $this->states->get_state_dropdown();

		

		$users_all_zone = $this->sales_zone->users_all_zone($uid); //var_dump($users_all_zone);

		if($data["usergroup"]->group_id==4){

			$data['users_list'] = $this->users->get_user_list_zone($users_all_zone);

			$data['where_from']='from_zone';

		}else{

			$data['where_from']='from_business';

		}

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

        $data['right_container'] = $this->load->view("dashboards/create_a_business", $data, true);

        $data['content'] = $this->load->view("content", $data, true); 

        $this->load->view("default/blank", $data);

	}else{

		header("Location: ".base_url());

		}	

	}

	// + Peekaboo user checking

	function checkPeekabooDetails(){ 

		$username =(!empty($_REQUEST['username']))? $_REQUEST['username'] : "";

		$password = (!empty($_REQUEST['password']))? $_REQUEST['password'] : "";

		$peekabooUser=$this->ion_auth->checkPeekabooUser($username, $password);//var_dump($peekabooUser);exit ;

		$this->session->sess_destroy() ; // Destroy all session while stored in SS login process

		if($peekabooUser > 0){

			echo $peekabooUser ;

		}

	}

	// - Peekaboo user checking

	///////////////////////////////////////////	++ NOT IN USE	\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

	function check_peekaboo_authentication(){ 

	// + File get content

		/*$opts = array('http' => array('header'=> 'Cookie: ' . $_SERVER['HTTP_COOKIE']."\r\n"));echo $_SERVER['HTTP_COOKIE'] ;echo '<br>' ;

		$context = stream_context_create($opts);echo $context ;echo '<br>' ;echo PEEKABOO_URL.'includes/sessionuserid.php' ;

		//session_write_close(); // unlock the file

		$contents = file_get_contents(PEEKABOO_URL.'includes/sessionuserid.php', false, $context);// Peekaboo Logged userid stored in this page

		//session_start(); 

		echo $contents ;*/

	// - File get content

	// + cURL

		$url = PEEKABOO_URL.'includes/sessionuserid.php';

		$useragent = $_SERVER['HTTP_USER_AGENT'];

		$strCookie = 'PHPSESSID=' . $_COOKIE['PHPSESSID'] . '; path=/';

		//session_write_close();

		$ch = curl_init();

		//$ch = curl_init($rssFeedLink); 

		curl_setopt($ch,CURLOPT_URL,$url);

		curl_setopt($ch,CURLOPT_USERAGENT, $useragent);

		curl_setopt($ch,CURLOPT_COOKIE,$strCookie );

		$response = curl_exec($ch); 

		curl_close($ch); 

	// - cURL

	}

	///////////////////////////////////////////	++ NOT IN USE	\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
	function login_from_classified(){

		$callback ='mycallback'; 

		$response_arr = array();

/*		if (isset($_GET['loginrequestformpboo'])) {

			$response= array();

		}*/

		$this->load->library('session');

		$this->session->unset_userdata('user_id');  ///// remove later ------ 26-02-2015

		$username =(!empty($_REQUEST['username']))? $_REQUEST['username'] : "";

		$password = (!empty($_REQUEST['password']))? $_REQUEST['password'] : "";

		$userzone = (!empty($_REQUEST['userzone']))? $_REQUEST['userzone'] : "";

		$login_type = (!empty($_REQUEST['login_type']))? $_REQUEST['login_type'] : "";

		$zip_claimed_by_user = (!empty($_REQUEST['zip_claimed_by_user']))? $_REQUEST['zip_claimed_by_user'] : "";

		$zoneid = (!empty($_REQUEST['zoneid_login'])) ? $_REQUEST['zoneid_login'] : "" ; 

		

		//$group_usertype = $this->sales_zone->user_group_id($username);

		//$group_id = $group_usertype['group_id'];

		//$user_status = $group_usertype['status'];

		//var_dump();

		//echo $login_type;

		//var_dump($userzone); exit;

		$remember='';





		//if($zoneid==308){

			log_message('custom', '<br/>==================================== Log start =============================== <br/>');

			log_message('custom', '<br/>----------------------------------- REQUEST PARAMETERS START---------------------------------- <br/>');

			log_message('custom', json_encode($_REQUEST));

			log_message('custom', '<br/>------------------------------------ REQUEST PARAMETERS END-------------------------------- <br/>');

			

			//show_error('custom', 'The purpose of some variable is to provide some value.');

		//}

		//isset($_REQUEST['business_id']) && $_REQUEST['business_id']!='' ? $business_id=$_REQUEST['business_id'] : $business_id='';  

		//$from_where = (!empty($_REQUEST['from_where']))? $_REQUEST['from_where'] : "";

		log_message('custom', '<br/>----------------------------------- LOGIN  ---------------------------------- <br/>');

		if($this->session->userdata('user_id')!=''){  

			//var_dump($this->session->userdata('session_zoneid')); exit;



			$userdata = $this->session->userdata('session_zoneid');

			$zoneid = $userdata['userzoneid'];

			/*log_message('custom', '<br/>----------------------------------- IF USER ID IS BLANK  ---------------------------------- <br/>');

			log_message('custom', json_encode($userdata)););

			log_message('custom', '<br/>-------------------------------------------------------------------- <br/>');

			log_message('custom', $zoneid);

			log_message('custom', '<br/>-------------------------------------------------------------------- <br/>');*/

			redirect("/index.php?zone=".$zoneid, 'refresh');

		}else

		if ($this->ion_auth->login($username, $password, $remember)){

			//log_message('custom', '<br/>----------------------------------- LOGGIN SUCCESSFULL---------------------------------- <br/>');



			

			// create cookie to avoid hitting this case again

			// create cookie to avoid hitting this case again

			$classifiedsUserName = array(

				'name'   => 'neighbors_classifieds_username',

				'value'  => $username,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($classifiedsUserName);



			$timeSlotCookieUsername = array (

				'name'   => 'timeSlotUserName',

				'value'  => $username,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => ''

			);

			set_cookie($timeSlotCookieUsername);



			$timeSlotPassword = array (

									'name'   => 'timeSlotPassword',

									'value'  => $password,

									'expire' => time()+86500,

									'domain' => '',

									'path'   => '/',

									'prefix' => ''

										);

			set_cookie($timeSlotPassword);



			$timeSlotname = array(

							'name'    =>'timeSlotName',

							'value'   => $auser->first_name.' '.$auser->last_name,

							'expire'  => time()+86400,

							'domain'  => '',

							'path'    => '/',

							'prefix'  => ''

						);

			set_cookie($timeSlotname);



			$timeSlotEmail = array (

							'name'   => 'timeSlotEmail',

							'value'  => $auser->email,

							'expire' => time()+86400,

							'domain' => '',

							'path'   => '/',

							'prefix' => ''

						);

			set_cookie($timeSlotEmail);

			

			// create cookie to avoid hitting this case again

			$classifiedsPassword = array(

				'name'   => 'neighbors_classifieds_password',

				'value'  => $password,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($classifiedsPassword);

			$classifiedsZoneId = array(

				'name'   => 'neighbors_classifieds_zoneid',

				'value'  => $userzone,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($classifiedsZoneId);

			$cookie = array(

				'name'   => 'blog_username',

				'value'  => $username,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($cookie);

			

			// create cookie to avoid hitting this case again

			$cookie = array(

				'name'   => 'blog_password',

				'value'  => $password,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($cookie);

			// Set user password in session

			//$this->session->set_userdata($password);



			$auser = $this->ion_auth->user()->row(); 

            $user_id = $auser->id; 

            $user_name = $auser->username;

            //$user_id = '1600044';

            $classifiedsUserId = array(

				'name'   => 'neighbors_classifieds_userid',

				'value'  => $user_id,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($classifiedsUserId);

			$user_type1=$this->ion_auth->check_user_type($user_id);

			$user_type = $user_type1[0]['group_id']; //print_r($user_type1)  exit;

			log_message('custom', '<br/>----------------------------------- user type START---------------------------------- <br/>');

			log_message('custom', $user_type);

			log_message('custom', '<br/>------------------------------------ user type END-------------------------------- <br/>');

			 

			//echo $user_type; exit;

//var_dump($user_type); 

			/*$session_login_details = array('type'=>$user_type);        			

			$this->session->set_userdata('session_login_details',$session_login_details);*/

			if($user_type==4){ // For Zone Owner

				$user_type = $user_type1[0]['group_id'];			

				$zones = $this->sales_zone->zone_owner_login($user_id);

				log_message('custom', '<br/>----------------------------------- zones START---------------------------------- <br/>');

				log_message('custom', json_encode($zones));

				log_message('custom', '<br/>------------------------------------ zones END-------------------------------- <br/>');

			 

				//var_dump($zones); exit;

				//If zone owner pick first zone dashboard

				if(!empty($zones)){				

					$session_zoneid = array(                   		

                   		'userzoneid'=>$zones[0]['id'],

						'sesuserid'=>$user_id

        			);

					$this->session->set_userdata('session_zoneid',$session_zoneid);

					$session_login_details = array('type'=>$user_type,'id'=>$zones[0]['id']); 			

					$this->session->set_userdata('session_login_details',$session_login_details);

					//var_dump($this->session->all_userdata());

					//base_url().'blog/blog1.php';

					/*// create cookie to avoid hitting this case again

					$cookie = array(

						'name'   => 'blog_username',

						'value'  => $username,

						'expire' => time()+86500,

						'domain' => '',

						'path'   => '/',

						'prefix' => '',

					);

					set_cookie($cookie);

					

					// create cookie to avoid hitting this case again

					$cookie = array(

						'name'   => 'blog_password',

						'value'  => $password,

						'expire' => time()+86500,

						'domain' => '',

						'path'   => '/',

						'prefix' => '',

					);

					set_cookie($cookie);*/

					$update_zone_menu=$this->category_model->update_zone_menu($zones[0]['id']);

					if($zip_claimed_by_user!=''){

						$this->zips->get_zip_claim($zip_claimed_by_user, $user_id); //exit;

			 			$this->session->unset_userdata('session_zip_claimed_by_user');

						$response_arr['response'] = 'claimzip_by_zone_owner!~!'.$zones[0]['id'];

					}else{

						if($zones[0]['status']==1){									

							$response_arr['response'] = 'zone_owner!~!'.$zones[0]['id'];

						}else{

							$all_sessiondata = $this->session->all_userdata();//var_dump($all_sessiondata);exit;

							foreach($all_sessiondata as $key => $sessiondata){//echo "<pre>"; var_dump($key);

							  if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity'){

							         $this->session->unset_userdata($key);

							  }

							}

							$response_arr['response'] = 'zone_owner_not_verify!~!'.$zones[0]['id'];

						}

					}

					/*$a = $this->session->all_userdata();

					log_message('custom', '<br/>----------------------------------- all userdata START---------------------------------- <br/>');

			log_message('custom', json_encode($a);

			log_message('custom', '<br/>------------------------------------ all userdata END-------------------------------- <br/>');*/

				}/*else{

					$response='<span style="color:red">Please verify your account.</span>!~!0';

				}*/

			}else if($user_type==5 || $user_type==13){ // For business Owner

//var_dump($user_type==13);

				 //If business owner pick first business

				$businessDetails = $this->business->getBusinessByOwnerUserId($user_id);

				$businesses = $this->business->get_all_businesses_for_user($user_id);



				if(!empty($businesses)){				

					$bid = $businesses[0]['id'];

					$zoneid=$businesses[0]['id'];

					$business_authentication=$this->business->check_business_authentication($bid); 

					$session_login_details = array('type'=>$user_type,'id'=>$bid);        			

					$this->session->set_userdata('session_login_details',$session_login_details);

					//var_dump($bid); exit;

					// newly added for new dashboard start					

					/*$session_business_arr = array('zoneid'=>$zoneid,'userid'=>$user_id,'user_groupid'=>$user_type);

					$this->session->set_userdata('session_business',$session_business_arr);*/

					// newly added for new dashboard end

					if($business_authentication=='business' || $business_authentication=='franchisee' || $business_authentication=='listed'){

						$response_arr['response']='business_owner!~!'.$bid.'!~!'.$user_type.'!~!'.$user_id.'!~!'.$user_name;

						// added user type for peekaboologin on 8.jan.2016

					}else if($business_authentication=='verification'){

						//$response='verification!~!'.$bid;

						$response_arr['response']='business_owner!~!'.$bid.'!~!'.$user_type.'!~!'.$user_id.'!~!'.$user_name;	// added user type for peekaboologin on 8.jan.2016

					}/*else if($business_authentication=='listed'){ // Updated 8.6.2015(CSV UPLOADED BUSINESS WILL GET BUSINESS DASHBOARD SOON AFTER LOGIN)

						$response='listed!~!'.$bid;

					}*/else{

						$response_arr['response']='home!~!';

					}

					/*$listed_businesses = $this->business->check_listed_business($bid);

					//var_dump($listed_businesses); exit;

					if($listed_businesses>=1){

						//redirect("auth/verification/$bid", 'refresh');

						$response='verification!~!'.$bid;

					}else{

						//redirect("dashboards/business/$bid", 'refresh');

						$response='business_owner!~!'.$bid;

					}*/

					

				}else{

					//redirect("dashboards/createABusiness/1", 'refresh');

					$response_arr['response']='createABusiness!~!1';

				}

				//echo "5555"; exit;

				$timeSlotCookieUsername = array (

											'name'   => 'timeSlotUserName',

											'value'  => $username,

											'expire' => time()+86500,

											'domain' => '',

											'path'   => '/',

											'prefix' => ''

										);

				set_cookie($timeSlotCookieUsername);

				$timeSlotPassword = array (

										'name'   => 'timeSlotPassword',

										'value'  => $password,

										'expire' => time()+86500,

										'domain' => '',

										'path'   => '/',

										'prefix' => ''

										 );

				set_cookie($timeSlotPassword);

				$timeSlotname = array(

										'name'    =>'timeSlotName',

										'value'   => $auser->first_name.' '.$auser->last_name,

										'expire'  => time()+86400,

										'domain'  => '',

										'path'    => '/',

										'prefix'  => ''

									 );

				set_cookie($timeSlotname);

				$timeSlotEmail = array (

										 'name'   => 'timeSlotEmail',

										 'value'  => $auser->email,

										 'expire' => time()+86400,

										 'domain' => '',

										 'path'   => '/',

										 'prefix' => ''

									   );

				set_cookie($timeSlotEmail);

				$timeSlotBusinessName = array (

												'name'   => 'timeSlotBusinessName',

												'value'  => $businessDetails->name,

												'expire' => time()+86400,

												'domain' => '',

												'path'   => '/',

												'prefix' => ''

											  );

				set_cookie($timeSlotBusinessName);

				$timeSlotssId = array (	

												'name'    => 'timeSlotssId',

												'value'   => $businessDetails->id,

												'expire'  => time()+86400,

												'domain'  => '',

												'path'    => '/' 

											);

				set_cookie($timeSlotssId);

				$timeSlotFrom       = array (

												'name'   => 'timeSlotFrom',

												'value'  => 1,

												'expire' => time()+86400,

												'domain' => '',

												'path'   => '/'

											);

				set_cookie($timeSlotFrom);

			}else if($user_type==6){ 

				$snap_zone=$this->ion_auth->get_snap_user_zone($user_id);

				$snap_zone_id=$snap_zone[0]['zoneid'];

				$response_arr['response']='snap_profile!~!'.$userzone.'!~!'.$user_id.'!~!'.$user_name;	

			}else if($user_type==10){ 

				//redirect("welcome/profile", 'refresh');

				/*print_r($this->session->userdata); 

				//var_dump($this->session->userdata('session_zoneid_x'));

				$xxx=$this->session->userdata('session_zoneid_x');

			    $session_zoneid_for_user_xxx=$xxx['session_zoneid_for_user_reg'];

				var_dump($session_zoneid_for_user_xxx); exit;*/ 

				////$session_normal_user_in_zone = array('sesuserzone'=>$userzone);                   		

                ////$this->session->set_userdata('session_normal_user_in_zone',$session_normal_user_in_zone);

				//$snap_zone=$this->ion_auth->get_snap_user_zone($user_id);

				//var_dump($aa);

				//print_r($this->session->userdata); exit;

				//$snap_zone_id=$snap_zone[0]['zoneid']; //var_dump($snap_zone_id); exit;

				//$response='user_profile!~!'.$zoneid;

				if($login_type=='main_login'){

					$session_normal_user_in_zone = array('sesuserzone'=>$zoneid,'sesusertype'=>'resident_user');                   		

					$this->session->set_userdata('session_normal_user_in_zone',$session_normal_user_in_zone);

					

					$update_zone_menu=$this->category_model->update_zone_menu($zoneid);

					$response_arr['response']='user_profile!~!'.$zoneid; 

					log_message('custom', '<br/>----------------------------------- Neighbors login response ---------------------------------- <br/>');

					log_message('custom', $response_arr['response']);

					log_message('custom', '<br/>------------------------------------ Neighbors login response -------------------------------- <br/>');

				}else{

					if($login_type!='main_login'){

						$session_normal_user_in_zone = array('sesuserzone'=>$userzone,'sesusertype'=>'resident_user');                   		

						$this->session->set_userdata('session_normal_user_in_zone',$session_normal_user_in_zone);

						$update_zone_menu=$this->category_model->update_zone_menu($userzone);

						$response_arr['response']='snap_profile!~!'.$userzone.'!~!'.$user_type.'!~!'.$user_id.'!~!'.$user_name;	// added user type for peekaboologin on 8.jan.2016

					}else{

						$response_arr['response']='<span style="color:red">Invalid User.</span>!~!0';

					}

				}

			}else if($user_type==8){ // For Organization user

				$organization=$this->ion_auth->check_organization($user_id);			

				if(!empty($organization)){

					$session_orgid = array(                   		

                   		'sesorgid'=>$organization[0]['id']					

        			);

					$this->session->set_userdata('session_orgid',$session_orgid);

					$session_login_details = array('type'=>$user_type,'id'=>$organization[0]['id']);        			

					$this->session->set_userdata('session_login_details',$session_login_details);

					$organizationDetails = $this->org_model->getOrganizationDetailsByOwnerId($auser->id);

					$timeSlotCookieUsername = array (

											'name'   => 'timeSlotUserName',

											'value'  => $username,

											'expire' => time()+86500,

											'domain' => '',

											'path'   => '/',

											'prefix' => ''

										);

				  set_cookie($timeSlotCookieUsername);

				  $timeSlotPassword = array (

											'name'   => 'timeSlotPassword',

											'value'  => $password,

											'expire' => time()+86500,

											'domain' => '',

											'path'   => '/',

											'prefix' => ''

											 );

					set_cookie($timeSlotPassword);

				$timeSlotname = array(

										'name'    =>'timeSlotName',

										'value'   => $auser->first_name.' '.$auser->last_name,

										'expire'  => time()+86400,

										'domain'  => '',

										'path'    => '/',

										'prefix'  => ''

									 );

				set_cookie($timeSlotname);

				$timeSlotEmail = array (

										 'name'   => 'timeSlotEmail',

										 'value'  => $auser->email,

										 'expire' => time()+86400,

										 'domain' => '',

										 'path'   => '/',

										 'prefix' => ''

									   );

				set_cookie($timeSlotEmail);

				$timeSlotBusinessName = array (

												'name'   => 'timeSlotBusinessName',

												'value'  => $organizationDetails->name,

												'expire' => time()+86400,

												'domain' => '',

												'path'   => '/',

												'prefix' => ''

											  );

				set_cookie($timeSlotBusinessName);

				$timeSlotssId = array (	

												'name'    => 'timeSlotssId',

												'value'   => $organizationDetails->id,

												'expire'  => time()+86400,

												'domain'  => '',

												'path'    => '/' 

											);

				set_cookie($timeSlotssId);

				$timeSlotFrom       = array (

												'name'   => 'timeSlotFrom',

												'value'  => 2,

												'expire' => time()+86400,

												'domain' => '',

												'path'   => '/'

											);

				set_cookie($timeSlotFrom);

					//$organizationDetails = 				

					//$response ='organization!~!'.$organization[0]['orgid'];

					//$response = json_encode($auser);

					$response_arr['response'] ='organization!~!'.$organization[0]['id'].'!~!'.$user_id.'!~!'.$user_name;

					//redirect("dashboards/organization/$org_id", 'refresh');

				}

			}

			else if($user_type==9){

				//$user_id;exit;

				//$data=array('business_id'=>$business_id,'userid'=>$user_id); 

				//$response=json_encode($data);				

				$response_arr['response']='rating_profile!~!'.$user_id.'!~!'.$user_name;

			}

			else if($user_type==14){ 

			    

			   $realtor = $this->ion_auth->check_realtor($user_id);

			    if(!empty($realtor)){

			       $session_realtorid =array(

					        'sesrealid'=>$realtor['0']['id']

				   );

			    $this->session->set_userdata('sesrealid',$session_realtorid);

				$session_login_details1 = array('type'=>$user_type,'id'=>$realtor['0']['id']);    

				$this->session->set_userdata('usersessionrealtordata','usersessionrealtordata') ;

				$user_type = $user_type1[0]['group_id'];	

				$response_arr['response']='realtor!~!'.$user_id.'!~!'.$user_name;

				//$response='realtor!~!'.$user_id;

			}

		}

			else{

				//redirect("dashboards/zipadmin", 'refresh');

				$response_arr['response']='zipadmin!~!';

			}



		}else{

			$response_arr['response']='<span style="color:red">Invalid Username or Password.</span>!~!0';

		}

/*		if (isset($_GET['loginrequestformpboo'])) {

			$response=json_encode($response);

		}*/

		

		//$message='Invalid Username or Password. Please Try again.';

		/*echo $response;*/

		echo $callback.'('. json_encode($response_arr).')';

				//echo($this->dr->GetDR("", $message, "", "0"));

		

	}
// authenticate the details
function decryptPasswrdClassified(){

		$this->load->library('session');

		$this->session->unset_userdata('user_id');   

		$remember='';
		  
		$logged = $this->ion_auth->login($_REQUEST['username'], base64_decode($_REQUEST['paswrd']),$remember);
	 
		echo  $logged;


}
	/*old controllers data*/
}