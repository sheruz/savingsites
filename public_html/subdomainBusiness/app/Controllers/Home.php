<?php
namespace App\Controllers;
use App\Models\IonAuthModel;
use App\Models\Zips;
use App\Models\zone\Zone_model;
use App\Models\Users;
use App\Controllers\CronController;
use App\Libraries\IonAuth;
use App\Controllers\CommonController;
use Config\MyConfig;
#[\AllowDynamicProperties]
class Home extends BaseController{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->CommonController = new CommonController();
        $this->Zips = new Zips();
        $this->CronController = new CronController();
        $this->Users = new Users();
        $this->Zone_model = new Zone_model();
        $this->myconfig = new MyConfig;
    } 
    
    public function index() {
        $amazonurl = $this->myconfig->AWSimageurl;
        $this->CommonController->getAutoLogin();
        $zoneid = $this->CommonController->redirectToZone();
        
        $sqlsubdomain = "SELECT * FROM sales_zone WHERE id='".$zoneid."'";
        $subdomaindata = $this->SelectRawquery($sqlsubdomain,'row');
        $subdomain = isset($subdomaindata->subdomain)?$data->subdomain:'';
        $header= 'homeheader';
        $footer = 'homefooter';
        $data = [];
        $user_id = $email = $firstName = $lastName = $businessUser = $session_usertype= $session_session_normal_user_in_zone = $session_session_normal_user_type = $session_type = $session_type_id = $zone_name = $adid = $deal_title = $bsname = $description = $meta_business_image_type = $business_name = $refer_code = $firstName = '';
        $zoneid = '598';
        $theme  = "blue"; 
        $page = 'Old Glory';
        $data['user_type']['type'] = '';
        $resultdata=[];
        
        if($this->ionAuth->loggedIn()){ 
            $auser = $this->ionAuth->user()->row();
            if(!empty($auser)){                 
                $this->session->set('get_email',$auser->email);
                
                $user_id = $auser->user_id;
                $email = $auser->email; 
                $firstName = $auser->first_name;
                $lastName = $auser->last_name;
                $businessUser = $auser->username;
                // $this = $this;
             
                $cookie = array(
                    'name' => 'user_id',
                    'email' => 'email',
                    'value' => $user_id,
                    'expire' => time()+86500,
                    'domain' => '',
                    'path'   => '/',
                    'prefix' => '',
                );
                set_cookie($cookie);
            }
        }
        $zone= $this->Zone_model->get_zone($zoneid);
        $zone_owner = (object)$this->Users->get_user_details($zone['sales_rep_id']);
        
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
        
        if(isset($_SESSION['session_login_details']) && $_SESSION['session_login_details']){
            $zoneid = $_SESSION['session_login_details']['id'];
            $data['user_type']['type'] = $_SESSION['session_login_details']['type'];
            $sql="select * from others_referral_id where zoneid=".$_SESSION['session_login_details']['id'];
            $query=$this->db->query($sql);
            $refferalcode = $query->getResultArray();
            if($refferalcode){
                $resultdata = $refferalcode[0];
            }else{
                $resultdata = '';
            }
            
        }
         // non-profit organization list
        $organizationsql = "SELECT name,id FROM organization WHERE approval= 1 AND type IN (0,1,2)";
        $nonprofitorg = $this->CommonController->SelectRawquery($organizationsql , "resultArray");
        $this->CronController->rankbusiness($zoneid);
        $deal_cert_qry = "Select * from deal_cashcert Order by id ASC";
        $deal_cert_Arr = $this->CommonController->SelectRawquery($deal_cert_qry,'result');
        return view('home', array('user_id' => $user_id,'email' => $email,'firstName' => $firstName,'lastName' => $lastName,'businessUser' => $businessUser,'session_usertype' => $session_usertype,'session_session_normal_user_in_zone' => $session_session_normal_user_in_zone,'session_session_normal_user_type' => $session_session_normal_user_type,'session_type' => $session_type,'session_type_id' => $session_type_id,'zone_name' => $zone_name,'adid' => $adid,'deal_title' => $deal_title,'zoneid' => $zoneid,'zone_id' => $zoneid,'theme' => $theme,'page' => $page,'resultdata' => $resultdata,'bsname' => $bsname,'description' => $description,'meta_business_image' => [],'meta_business_image_type' => $meta_business_image_type,'business_name' => $business_name,'header' => $header,'footer' => $footer,'nonprofitorg' => $nonprofitorg,'refer_code'=> $refer_code,'zone_owner'=>$zone_owner,'subdomain'=>$subdomain,'amazonurl'=>$amazonurl,'deal_cert_Arr'=>$deal_cert_Arr));

    }

    public function contact_us(){
        $header= 'homeheader';
        $footer = 'residentfooter';
        $zoneid = $user_id = $adid = $deal_title =  $zone_logo ='';
        $theme  = "blue"; 
        $page   = 'Old Glory'; 
        return view('contact',array('zoneid' => $zoneid,'user_id' => $user_id,'adid' => $adid,'deal_title' => $deal_title,'theme' => $theme,'page' => $page,'zone_logo' => $zone_logo,'header' => $header,'footer' => $footer));
    }

    

    public function thankyou(){ // pending 

        $data['adid'] = '';

        $data['deal_title'] = '';

        $data['theme']  = "blue"; 

        $data['page']   = 'Old Glory';

        $data['currentpage']   = 'home';

        $data['css'] = 'style_home';

        

        $this->business->storecredit(@$_REQUEST['bid'] ,@$_REQUEST['credit'] , @$_REQUEST['token']);

        

        $data['head']           = $this->load->view("includes/head",$data); 

        $data['header']         = $this->load->view("includes/home_header", $data); 

        $data['content']         = $this->load->view("includes/thankyou", $data); 

        $data['footer']         = $this->load->view("includes/home_footer", $data);

        $data['modals']         = $this->load->view("includes/modals",$data);

    }
    
    public function publisherTOS(){ // pending

        $data = array();

        $meta_business_image  = [];

        $zoneid = $zone_id = $user_id = $adid = $deal_title =  $zone_logo = $meta_business_image_type = $business_name= '' ;

        $header= 'homeheader';

        $footer = 'zonefooter';

        $theme  = "blue"; 

        $page   = 'Old Glory'; 

        return view('terms',array('bsname' =>'','meta_business_image'=> $meta_business_image,'description'=>'','zone_id' => $zoneid,'zoneid' => $zoneid,'user_id' => $user_id,'adid' => $adid,'deal_title' => $deal_title,'theme' => $theme,'page' => $page,'zone_logo' => $zone_logo,'meta_business_image_type'=>$meta_business_image_type, 'business_name'=>$business_name,'header'=>$header,'footer'=>$footer ));



    }

    

    public function contact(){

        $emailconfig = \Config\Services::email();

        $template_subject="Savingssites Contact Page Submission";

        $name =(!empty($_REQUEST['name']))? $_REQUEST['name'] : "";

        $email = (!empty($_REQUEST['email']))? $_REQUEST['email'] : "";

        $phone =(!empty($_REQUEST['phone']))? $_REQUEST['phone'] : "";

        $subject = (!empty($_REQUEST['subject']))? str_replace('_',' ',$_REQUEST['subject']) : "";

        $message =(!empty($_REQUEST['message']))? $_REQUEST['message'] : "";

        $message_body="<div style='border:1px solid #900; padding:5px;'>Dear Administrator,<br /><br />My Contact Information is as bellows: <br/><br/>

            Name:".$name." <br/><br/>

            Email:".$email." <br/><br/>

            Phone:".$phone." <br/><br/>

            Subject:".$subject." <br/><br/>

            Message:".$message." <br/><br/>";

        

        $emailconfig->setFrom('romil@nexusfleck.com');

        $emailconfig->setTo($email);

        $emailconfig->setSubject($template_subject);

        $emailconfig->setMessage($message_body);

        if ($emailconfig->send()) { $report = 1;

        } else { $report = 0; }

        echo json_encode($report);

        die;   

    }

    

    public function about_us(){ // pending

        $zoneid = $user_id = $adid = $deal_title =  $zone_logo = $session_session_type_id = '';

        $theme  = "blue"; 

        $page   = 'Old Glory'; 

        

        return view('about',array('zoneid' => $zoneid,'user_id' => $user_id,'adid' => $adid,'deal_title' => $deal_title,'theme' => $theme,'page' => $page,'zone_logo' => $zone_logo,'session_session_type_id' => $session_session_type_id));

        

        // $data['modals']         = $this->load->view("includes/modals",$data);



    }



    



    public function advertise(){

        $zoneid = $user_id = $adid = $deal_title =  $zone_logo = $session_session_type_id = '';

        $theme  = "blue"; 

        $page   = 'Old Glory';

        

        return view('advertise',array('zoneid' => $zoneid,'user_id' => $user_id,'adid' => $adid,'deal_title' => $deal_title,'theme' => $theme,'page' => $page,'zone_logo' => $zone_logo,'session_session_type_id' => $session_session_type_id));

    }

    

    public function zip_to_zone($zip){
        $zone = $this->Zips->zip_to_zone($zip);
        if($zone == -1){
            $_zone_id = -1 ;
        }elseif(!empty($zone)){
            $_zone_id = $zone[0]['seo_zone_name'];           
        }else{
            $_zone_id = 0;            
        }

        echo $_zone_id; 

    }

    public function business_registration($zoneId=""){ 
        $zoneid = !empty($zoneId) ? $zoneId : 213;
        $user_id = $adid = $deal_title =  $zone_logo = $session_session_type_id = $zone_name = $meta_business_image_type = $business_name = '';
        $meta_business_image  = [];
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';

        $builder = $this->db->table('zipcode as a');
        $builder->select('a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name');
        $builder->join('zip_code_zone as b', 'a.zip = b.zip_code');
        $builder->join('states as c', 'a.state = c.code');
        $builder->orderBy('state', 'ASC');
        $query = $builder->get();
        $all_states = $query->getResult();
        $query = $this->db->table('tblClaimedZips')->select('*')->where('approved', 1)->orderBy('zip', 'ASC')->get();
        $all_claimed_zip = $query->getResult();
        
        return view('business_registration',array('zoneid' => $zoneid,'zone_id' => $zoneid,'user_id' => $user_id,'adid' => $adid,'deal_title' => $deal_title,'theme' => $theme,'page' => $page,'zone_logo' => $zone_logo,'session_session_type_id' => $session_session_type_id,'header' => $header,'footer' => $footer,'zone_name' => $zone_name,'all_states' => $all_states,'bsname' =>'','description'=>'','meta_business_image'=> $meta_business_image,'meta_business_image_type'=> $meta_business_image_type,'business_name'=> $business_name,'all_claimed_zip'=> $all_claimed_zip));
    }

    public function organization_registration($zoneId){
        $zoneid = !empty($zoneId) ? $zoneId : 213;
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = "homefooter";
        $zone_name = "";
        
        $query = $this->db->table('tblClaimedZips')->select('*')->where('approved', 1)->orderBy('zip', 'ASC')->get();
        $all_claimed_zip = $query->getResult(); 

        $all_zip_codeqry="SELECT a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name FROM zipcode as a LEFT JOIN zip_code_zone as b ON a.zip = b.zip_code LEFT JOIN states as c ON a.state = c.code LIMIT 100";
        $all_zip_code=$this->CommonController->SelectRawquery($all_zip_codeqry ,'result');

        $get_all_statesqry="SELECT a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name FROM zipcode as a LEFT JOIN zip_code_zone as b ON a.zip = b.zip_code LEFT JOIN states as c ON a.state = c.code LIMIT 100";
        $get_all_states=$this->CommonController->SelectRawquery($get_all_statesqry ,'result');
        
        return view('organization_registration',array('zoneid' => $zoneid,'zone_id' => $zoneid,'zone_name' => $zone_name,'theme' => $theme,'page' => $page,'footer' => $footer,'all_claimed_zip' => $all_claimed_zip,'all_zip_code' => $all_zip_code,'get_all_states' => $get_all_states,'header' => $header));
    }

    public function sponsor_registration($zoneId){
        $zoneid = !empty($zoneId) ? $zoneId : 213;
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = "homefooter";
        $zone_name = "";
        
        $query = $this->db->table('tblClaimedZips')->select('*')->where('approved', 1)->orderBy('zip', 'ASC')->get();
        $all_claimed_zip = $query->getResult(); 

        $all_zip_codeqry="SELECT a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name FROM zipcode as a LEFT JOIN zip_code_zone as b ON a.zip = b.zip_code LEFT JOIN states as c ON a.state = c.code LIMIT 100";
        $all_zip_code=$this->CommonController->SelectRawquery($all_zip_codeqry ,'result');

        $get_all_statesqry="SELECT a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name FROM zipcode as a LEFT JOIN zip_code_zone as b ON a.zip = b.zip_code LEFT JOIN states as c ON a.state = c.code LIMIT 100";
        $get_all_states=$this->CommonController->SelectRawquery($get_all_statesqry);
        
        return view('sponsor_registration',array('zoneid' => $zoneid,'zone_id' => $zoneid,'zone_name' => $zone_name,'theme' => $theme,'page' => $page,'footer' => $footer,'all_claimed_zip' => $all_claimed_zip,'all_zip_code' => $all_zip_code,'get_all_states' => $get_all_states,'header' => $header));
    }

    public function business_login(){ //pending
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $footer = "";
        $zone_name = "";
        $logintype = 5;
        $formtitle = 'Business';
        $formtitle = (!empty($_GET['title']))? ' - '.$_GET['title'] : "Business";
        $zoneid = isset($zoneid) ? $zoneid:'';
        
        return view('login',array('theme' => $theme,'page' => $page,'footer' => $footer,'formtitle' => $formtitle,'logintype' => $logintype,'zoneid' => $zoneid));
    }

    public function organization_login(){ // pending
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $footer = "";
        $zone_name = "";
        $logintype = 8;
        $formtitle = (!empty($_GET['title']))? ' - '.$_GET['title'] : "Organization";
        $zoneid = isset($zoneid) ? $zoneid:'';
        
        return view('login',array('theme' => $theme,'page' => $page,'footer' => $footer,'formtitle' => $formtitle,'logintype' => $logintype,'zoneid' => $zoneid));
    }

    public function zone_login(){ // pending
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $footer = "";
        $zone_name = "";
        $logintype = 4;
        $formtitle = (!empty($_GET['title']))? ' - '.$_GET['title'] : "Zone";
        $zoneid = isset($zoneid) ? $zoneid:'';
        
        return view('login',array('theme' => $theme,'page' => $page,'footer' => $footer,'formtitle' => $formtitle,'logintype' => $logintype,'zoneid' => $zoneid));
    }

    public function superadmin_login(){ // pending
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $footer = "";
        $zone_name = "";
        $logintype = 3;
        $formtitle = (!empty($_GET['title']))? ' - '.$_GET['title'] : "Zone";
        $zoneid = isset($zoneid) ? $zoneid:'';
        
        return view('login',array('theme' => $theme,'page' => $page,'footer' => $footer,'formtitle' => $formtitle,'logintype' => $logintype,'zoneid' => $zoneid));
    }

    public function business_registration_authentication($zoneId = ''){ // pending
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';
        $zone_name = "";
        $passfrom= '';//strlen($_REQUEST['passfrom'])!=0?$_REQUEST['passfrom']:"";
        $businessid = '';//strlen($_REQUEST['businessid'])!=0?$_REQUEST['businessid']:"";
        $zoneid = isset($zoneId) ? $zoneId:'';
        
        return view('business_authentication',array('theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zoneid' => $zoneid,'zone_id' => $zoneid,'passfrom' => $passfrom,'businessid' => $businessid,'zone_name'=>''));
    }

    public function get_forgot_password($id = ''){
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $footer = "";
        $zone_name = "";
        $typeid = $id;
        $zoneid = isset($zoneid) ? $zoneid:'';
        
        return view('get_forgot_password',array('theme' => $theme,'page' => $page,'footer' => $footer,'zoneid' => $zoneid,'typeid' => $typeid));
    }

    public function forgot_password(){
        $message = array();
        $name =(!empty($_REQUEST['name']))? $_REQUEST['name'] : ""; 
        $usertype =(!empty($_REQUEST['usertype']))? $_REQUEST['usertype'] : "";

        $sqlqry="SELECT a.username,b.group_id FROM users as a INNER JOIN  users_groups as b ON a.id=b.user_id WHERE  a.username='".$name."' AND b.group_id=".$usertype."";
        $userArr = $this->CommonController->SelectRawquery($sqlqry,'row');
        if($userArr != ''){
            $name = $userArr->username; 
            $usertype = $userArr->group_id;
        }else{
            $sqlqry1="SELECT a.username,b.group_id FROM users as a INNER JOIN  users_groups as b ON a.id=b.user_id WHERE  a.email='".$name."' AND b.group_id=".$usertype."";
            $userArr1 = $this->CommonController->SelectRawquery($sqlqry1,'row');  
            if($userArr1 != ''){
                $name = $userArr1->username; 
                $usertype = $userArr1->group_id;   
            }else{
                $sqlqry2="SELECT a.username,b.group_id FROM users as a INNER JOIN  users_groups as b ON a.id=b.user_id WHERE  a.phone='".$name."' AND b.group_id=".$usertype."";
                $userArr2 = $this->CommonController->SelectRawquery($sqlqry2,'row');
                if($userArr2 != ''){
                    $name = $userArr2->username; 
                    $usertype = $userArr2->group_id;   
                }   
            }
        }

        $forgotten = $this->ionAuth->forgotten_password($name,$usertype);  
        if ($forgotten){
            $sql="SELECT username,email,sales_zone.name FROM users Join sales_zone on sales_zone.id = users.Zone_ID WHERE username ='".$name."'";
            $query = $this->db->query($sql); 
            $userdata = $query->getResult();
            $array = json_decode(json_encode($userdata), true);
            $email=$array[0]['email'];
            $zone_name= $array[0]['name'];
            $sub = "Reset your password for $zone_name";
            $body = "Dear ".$name.", <br>  
            <p> We received a request to reset your $zone_name account password. if you did not make this request, please disregard this email.<p> 
            <p> To reset your password, please click the button below: </p>
            <p> <a href='".base_url()."/recoverpassword?username=".$name."&usertype=".$usertype."'> <button style='padding: 5px 10px; background-color: green; color: #fff; box-shadow: 0; border: 0;'> Reset Password </button></a></p>
            <p> This secure, one-time-use link will expire in 24 hours. Once you have reset your password, you can login using your new password. </p> 
            <p> If you have any trouble resetting your password, please don't hesitate to contact our support team at $zone_name for assistance. </p>                
            <p> Thank you for using $zone_name! We are committed to keeping your account secure.</p>
            <p> Regards, $zone_name Support Team</p>
            <p> Please do not reply directly to this automated email. If you need help, don't hesitate to get in touch with our support team.</p>";


            $send = $this->CommonController->SendMail('',$email,$sub,$body);
            $message['msg'] = 'Success';
        }else{
            $message['msg'] = 'Failed';
        }
        echo json_encode($message);
    }
    
    public function getZip(){
        $zone = $_REQUEST['zone']?$_REQUEST['zone']:'';
        if($zone!=''){
            $sql="SELECT distinct(zip_code) AS zip FROM zip_code_zone WHERE zone_id = $zone";
            $query = $this->db->query($sql); 
            $get_zip = $query->getResult(); 
            echo json_encode($get_zip);
            die;
        }
    }
    
    public function getZone(){
        $state = $_REQUEST['state'];
        $city = $_REQUEST['city'];
        $data = array();
        if($state!=''){
            if($city!=''){
                $wh=" AND a.primarycity='".$city."'";
            }
            $get_zone="SELECT c.id,c.name as zone FROM zipcode as a INNER JOIN zip_code_zone as b ON a.zip=b.zip_code INNER JOIN sales_zone as c ON b.zone_id=c.id WHERE a.state='".$state."' ".$wh." AND c.active = 1 GROUP BY c.id ORDER BY c.name asc";
            $query_get_zone = $this->db->query($get_zone);
            $data['get_zone'] = $query_get_zone->getResult();
            
            echo json_encode($data['get_zone']);
        }
    }

    public function getCity(){
        $state_code = $_REQUEST['state_code']; 
        $zoneid = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:''; 
        if($state_code != -1){
            if($zoneid != ''){
                $get_all_cities = "SELECT distinct(c.primarycity) AS city FROM sales_zone a, zip_code_zone b, zipcode c WHERE a.id = b.zone_id AND b.zip_Code = c.zip AND c.state = '$state_code'  AND a.active = 1 AND a.id = ".$zoneid." ";
            }else{
                $get_all_cities = "SELECT distinct(c.primarycity) AS city FROM zip_code_zone a, zipcode c WHERE a.zip_Code = c.zip AND c.state = '$state_code' ";
            }
            $query_get_all_cities = $this->db->query($get_all_cities);
            $data['query_get_all_cities'] = $query_get_all_cities->getResult(); 
            echo json_encode($data['query_get_all_cities']);
        }
    }
    
    public function callslider(){ // pending
        $data['slider']         = $this->load->view("includes/home_slider", $data);
        echo $data['slider'];
    }
    
    public function callzoneslider(){ // pending
        $zoneid = $_POST['zoneId'];
        $data['zoneid'] = $zoneid;
        try {
            $data['active_banner_mobile']   = $this->banner->active_banner_desktopmobile($zoneid,'','1','2');
            $data['active_banner_desktop']  = $this->banner->active_banner_desktopmobile($zoneid,'','1','1');
            $data['slider']         = $this->load->view("includes/slider", $data);
        } catch (exception $e) {
            $data['slider']         = $this->load->view("includes/home_slider", $data);
        }
        echo $data['slider'];
    }

    public function qrscan(){
        $data = [];
        $user_id = $email = $firstName = $lastName = $businessUser = $session_usertype= $session_session_normal_user_in_zone = $session_session_normal_user_type = $session_type = $session_type_id = $zone_name = $adid = $deal_title = $bsname = $description = $meta_business_image_type = $business_name = $refer_code = $firstName = '';
        $theme  = "blue"; 
        $page = 'Old Glory';
        $data['user_type']['type'] = '';
        $resultdata=[];
        $busid = $businessName = '';
        $hide = 'hide';
        $userid = $_GET['userid'];
        $zoneid = $_GET['zoneid'];
        if($this->ionAuth->loggedIn()){
            $session_login_details = $this->CommonController->getSession('session_login_details');
            $login_type = $session_login_details['type'];
            $busid = $session_login_details['id'];
            $busqry = "SELECT * FROM business where id ='".$busid."'";
            $busArr = $this->CommonController->SelectRawquery($busqry);
            $businessName = isset($busArr[0]['name'])?$busArr[0]['name']:'';
            $hide = '';
        }
        $userqry = "SELECT * FROM users where id ='".$userid."'";
        $userArr = $this->CommonController->SelectRawquery($userqry);
        $firstName = $userArr[0]['first_name'];
        $lastName = $userArr[0]['last_name'];
        $this->CommonController->getAutoLogin();
        $header= 'homeheader';
        $footer = 'homefooter';
        
        
        if($this->ionAuth->loggedIn()){ 
            $auser = $this->ionAuth->user()->row();
            if(!empty($auser)){                 
                $this->session->set('get_email',$auser->email);
                
                $user_id = $auser->user_id;
                $email = $auser->email; 
                $firstName = $auser->first_name;
                $lastName = $auser->last_name;
                $businessUser = $auser->username;
                // $this = $this;
             
                $cookie = array(
                    'name' => 'user_id',
                    'email' => 'email',
                    'value' => $user_id,
                    'expire' => time()+86500,
                    'domain' => '',
                    'path'   => '/',
                    'prefix' => '',
                );
                set_cookie($cookie);
            }
        }
        $zone= $this->Zone_model->get_zone($zoneid);
        $zone_owner = (object)$this->Users->get_user_details($zone['sales_rep_id']);
        
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
        
        if(isset($_SESSION['session_login_details']) && $_SESSION['session_login_details']){
            $zoneid = $_SESSION['session_login_details']['id'];
            $data['user_type']['type'] = $_SESSION['session_login_details']['type'];
            $sql="select * from others_referral_id where zoneid=".$_SESSION['session_login_details']['id'];
            $query=$this->db->query($sql);
            $refferalcode = $query->getResultArray();
            if($refferalcode){
                $resultdata = $refferalcode[0];
            }else{
                $resultdata = '';
            }
            
        }
         // non-profit organization list
        $organizationsql = "SELECT name,id FROM organization WHERE approval= 1 AND type IN (0,1,2)";
        $nonprofitorg = $this->CommonController->SelectRawquery($organizationsql , "resultArray");
        $this->CronController->rankbusiness($zoneid);
        $zoneid = $_GET['zoneid'];
        return view('qrcode', array('userid'=> $userid,'zoneid'=> $zoneid,'busid'=> $busid,'businessName'=> $businessName,'userfname'=> $firstName,'userlname' =>$lastName,'user_id' => $user_id,'email' => $email,'firstName' => $firstName,'lastName' => $lastName,'businessUser' => $businessUser,'session_usertype' => $session_usertype,'session_session_normal_user_in_zone' => $session_session_normal_user_in_zone,'session_session_normal_user_type' => $session_session_normal_user_type,'session_type' => $session_type,'session_type_id' => $session_type_id,'zone_name' => $zone_name,'adid' => $adid,'deal_title' => $deal_title,'zoneid' => $zoneid,'zone_id' => $zoneid,'theme' => $theme,'page' => $page,'resultdata' => $resultdata,'bsname' => $bsname,'description' => $description,'meta_business_image' => [],'meta_business_image_type' => $meta_business_image_type,'business_name' => $business_name,'header' => $header,'footer' => $footer,'nonprofitorg' => $nonprofitorg,'refer_code'=> $refer_code,'zone_owner'=>$zone_owner,'hide'=>$hide));
    }

    public function validateqrbusiness(){
        $res = $this->ionAuth->loginverify($_REQUEST['user'], $_REQUEST['pass']);
        if($res == 1){
            $sql_option="select * from users INNER JOIN users_groups ON users.id=users_groups.user_id where users.username = ".$_REQUEST['user']." and users_groups.group_id=5";
            $allfavpost=$this->CommonController->SelectRawquery($sql_option,'resultArray');

            $busqry = "SELECT * FROM business where business_owner_id ='".$allfavpost[0]['user_id']."'";
            $busArr = $this->CommonController->SelectRawquery($busqry);

            $businessName = isset($busArr[0]['name'])?$busArr[0]['name']:'';
            $businessId = isset($busArr[0]['id'])?$busArr[0]['id']:'';
            echo json_encode(['msg'=>'user exists','type'=>'success','business_name'=> base64_encode($businessName),'busid'=>$businessId]);
        }else{
            echo json_encode(['msg'=>'user not exists','type'=>'warning','business_name'=>'','busid'=>'']);  
        }
    }

    public function blogdetail(){
        $emailArr = [];
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';
        $zone_name = "";
        $passfrom= '';
        $businessid = '';
        $zoneid = isset($zoneId) ? $zoneId:'';
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
       
        $sql1="select * from emailblog where id=".$id."";
        $result=$this->CommonController->SelectRawquery($sql1);
        $purchasedealArr = $result;
        return view('blogdetail',array('theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zoneid' => $zoneid,'zone_id' => $zoneid,'passfrom' => $passfrom,'businessid' => $businessid,'zone_name'=>'','emailArr'=> $purchasedealArr));
    }

    public function getemaildata(){
        $zoneid = $this->CommonController->redirectToZone();
        $html = '';
        $search = isset($_REQUEST['search'])?$_REQUEST['search']:'';
        $sql1="select * from emailblog where zone='".$zoneid."' AND subject LIKE '%".$search."%'";
        $result=$this->CommonController->SelectRawquery($sql1);
        if(count($result) > 0){
            foreach ($result as $v) {
                $html .= '<div class="col-md-3">
                    <div class="row" style="margin: 15px;">
                        <a target="_blank" href="/blogdetail?id='.$v['id'].'">
                            <div class="col-md-4">
                                <img src="'.$v['image'].'" />
                            </div>
                            <div class="col-md-8">
                                <h2 style="font-size: 18px;font-weight: 700;">'.$v['subject'].'</h2>
                                <p>'.$v['sender'].'<br></p>
                            </div>
                        </a>
                    </div>
                </div>';
            }     
        }else{
            $html .= '<div class="col-md-12">
                    <h2>No Data Found</h2>
                </div>';
        }
        //print_r($html);die('heer');
        echo $html;
        die;

    }

        public function free5(){
        $emailArr = [];
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';
        $zone_name = "";
        $passfrom= '';
        $businessid = '';
        $zoneid = isset($zoneId) ? $zoneId:'';
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        return view('free5',array('theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zoneid' => $zoneid,'zone_id' => $zoneid,'passfrom' => $passfrom,'businessid' => $businessid,'zone_name'=>'','emailArr'=>$emailArr));  
    }

    public function residents_email_template(){
        $emailArr = [];
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';
        $zone_name = "";
        $passfrom= '';
        $businessid = '';
        $zoneid = isset($zoneId) ? $zoneId:'';
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        return view('residents_email_template',array('theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zoneid' => $zoneid,'zone_id' => $zoneid,'passfrom' => $passfrom,'businessid' => $businessid,'zone_name'=>'','emailArr'=>$emailArr));  
    }

    public function groceryStore(){
        $emailArr = [];
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';
        $zone_name = "";
        $passfrom= '';
        $businessid = '';
        $zoneid = isset($zoneId) ? $zoneId:'';
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        return view('groceryStore',array('theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zoneid' => $zoneid,'zone_id' => $zoneid,'passfrom' => $passfrom,'businessid' => $businessid,'zone_name'=>'','emailArr'=>$emailArr));  
    }

    public function gov_email_template(){
        $emailArr = [];
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';
        $zone_name = "";
        $passfrom= '';
        $businessid = '';
        $zoneid = isset($zoneId) ? $zoneId:'';
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        return view('government_email_template',array('theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zoneid' => $zoneid,'zone_id' => $zoneid,'passfrom' => $passfrom,'businessid' => $businessid,'zone_name'=>'','emailArr'=>$emailArr));  
    }

    public function resident_email(){
        $emailArr = [];
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';
        $zone_name = "";
        $passfrom= '';
        $businessid = '';
        $zoneid = isset($zoneId) ? $zoneId:'';
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        return view('resident_email',array('theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zoneid' => $zoneid,'zone_id' => $zoneid,'passfrom' => $passfrom,'businessid' => $businessid,'zone_name'=>'','emailArr'=>$emailArr));  
    }

    public function resident_info(){
        $emailArr = [];
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';
        $zone_name = "";
        $passfrom= '';
        $businessid = '';
        $zoneid = isset($zoneId) ? $zoneId:'';
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        return view('resident_info',array('theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zoneid' => $zoneid,'zone_id' => $zoneid,'passfrom' => $passfrom,'businessid' => $businessid,'zone_name'=>'','emailArr'=>$emailArr));  
    }

    public function business_fraternal_orgs(){
        $emailArr = [];
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';
        $zone_name = "";
        $passfrom= '';
        $businessid = '';
        $zoneid = isset($zoneId) ? $zoneId:'';
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        return view('business_fraternal_orgs',array('theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zoneid' => $zoneid,'zone_id' => $zoneid,'passfrom' => $passfrom,'businessid' => $businessid,'zone_name'=>'','emailArr'=>$emailArr));  
    }

    public function referral_letter(){
        $emailArr = [];
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';
        $zone_name = "";
        $passfrom= '';
        $businessid = '';
        $zoneid = isset($zoneId) ? $zoneId:'';
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
        return view('important_gov_updates',array('theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zoneid' => $zoneid,'zone_id' => $zoneid,'passfrom' => $passfrom,'businessid' => $businessid,'zone_name'=>'','emailArr'=>$emailArr));  
    }

}

