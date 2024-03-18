<?php
namespace App\Controllers;
use App\Models\IonAuthModel;
use App\Models\Zips;
use App\Models\zone\Zone_model;
use App\Models\Users;
use App\Controllers\CronController;
use App\Libraries\IonAuth;
use App\Controllers\CommonController;
use DOMDocument;
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
    } 
    
    public function index() {
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
                SetCookie('user_id',$user_id,time()+86500,'','/','','email');
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
        
        $orgsql = "SELECT name,id FROM organization WHERE approval= 1 AND type IN (0,1,2)";
        $nonprofitorg = $this->CommonController->getStoreCache($orgsql,'resultArray','homeorgdata',3600);
        $this->CronController->rankbusiness($zoneid);
        $deal_cert_qry = "Select * from deal_cashcert Order by id ASC";
        $deal_cert_Arr = $this->CommonController->SelectRawquery($deal_cert_qry,'result');
        return view('home', array('user_id' => $user_id,'email' => $email,'firstName' => $firstName,'lastName' => $lastName,'businessUser' => $businessUser,'session_usertype' => $session_usertype,'session_session_normal_user_in_zone' => $session_session_normal_user_in_zone,'session_session_normal_user_type' => $session_session_normal_user_type,'session_type' => $session_type,'session_type_id' => $session_type_id,'zone_name' => $zone_name,'adid' => $adid,'deal_title' => $deal_title,'zoneid' => $zoneid,'zone_id' => $zoneid,'theme' => $theme,'page' => $page,'resultdata' => $resultdata,'bsname' => $bsname,'description' => $description,'meta_business_image' => [],'meta_business_image_type' => $meta_business_image_type,'business_name' => $business_name,'header' => $header,'footer' => $footer,'nonprofitorg' => $nonprofitorg,'refer_code'=> $refer_code,'zone_owner'=>$zone_owner,'deal_cert_Arr'=>$deal_cert_Arr));
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







    public function contact_us(){
        $zoneid = $user_id = $adid = $deal_title =  $zone_logo ='';
        $theme  = "blue"; 
        $page   = 'Old Glory'; 
        $header = 'homeheader';
        $footer = 'zonefooter';
        $theme  = "blue"; 
        return view('contact',array('zone_id' => $zoneid,'zoneid' => $zoneid,'user_id' => $user_id,'deal_title' => $deal_title,'theme' => $theme,'page' => $page,'zone_logo' => $zone_logo,'header' => $header,'footer' => $footer));
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
            if ($zone[0]['subdomainZone']) {
                $url = "https://".$zone[0]['subdomainZone'].".savingssites.com";           
            }else{
                $url = base_url('zone/').$zone[0]['seo_zone_name'];
            }
        }else{
            $url = base_url();            
        }

        echo $url; 

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

    public function organization_registration(){
        $zoneid = !empty($zoneId) ? $zoneId : 213;
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = "homefooter";
        $zone_name = "";
        
        $query = $this->db->table('tblClaimedZips')->select('*')->where('approved', 1)->orderBy('zip', 'ASC')->get();
        $all_claimed_zip = $query->getResult(); 

        $builder = $this->db->table('zipcode as a');
        $builder->select('a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name');
        $builder->join('zip_code_zone as b', 'a.zip = b.zip_code');
        $builder->join('states as c', 'a.state = c.code');
        $builder->orderBy('state', 'ASC');
        $builder->groupBy('zip_code');
        $query = $builder->get();
        $all_zip_code = $query->getResult();

        $builder = $this->db->table('zipcode as a');
        $builder->select('a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name');
        $builder->join('zip_code_zone as b', 'a.zip = b.zip_code');
        $builder->join('states as c', 'a.state = c.code');
        $builder->orderBy('state', 'ASC');
        $builder->groupBy('state');
        $query = $builder->get();
        $get_all_states = $query->getResult();
        
        return view('organization_registration',array('zoneid' => $zoneid,'zone_id' => $zoneid,'zone_name' => $zone_name,'theme' => $theme,'page' => $page,'footer' => $footer,'all_claimed_zip' => $all_claimed_zip,'all_zip_code' => $all_zip_code,'get_all_states' => $get_all_states,'header' => $header));
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
        $forgotten = $this->ionAuth->forgotten_password($name,$usertype);  
        if ($forgotten){
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
                $get_all_cities = "SELECT distinct(c.primarycity) AS city FROM sales_zone a, zip_code_zone b, zipcode c WHERE a.id = b.zone_id AND b.zip_Code = c.zip AND c.state = '$state_code'  AND a.active = 1 ";
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

    public function saveInlineImages($structure, $mailbox, $messageNumber, $savePath, $partNumber = null) {
        if (!$partNumber) {$partNumber = 1;}
        foreach ($structure->parts as $index => $part) {
            $currentPartNumber = ($partNumber) ? $partNumber . '.' . ($index + 1) : ($index + 1);
            if ($part->subtype === 'RELATED') {
                saveInlineImages($part, $mailbox, $messageNumber, $savePath, $currentPartNumber);
            }
            
            if (isset($part->disposition) && $part->disposition === 'INLINE') {
                $imageData = imap_fetchbody($mailbox, $messageNumber, $currentPartNumber);
                $imageInfo = imap_mime_header_decode($part->dparameters[0]->value);
                $imageName = $imageInfo[0]->text;
                $filePath = $savePath . '/' . $imageName;
                file_put_contents($filePath, $imageData);
            }else{
                if(isset($part->parts) && count($part->parts) > 0){
                    foreach ($part->parts as $k1 => $v1) {
                        if(isset($v1->parts)){
                            foreach ($v1->parts as $k2 => $v2) {
                                if (isset($v2->disposition) && $v2->disposition === 'attachment') {
                                    $imageData = imap_fetchbody($mailbox, $messageNumber, $currentPartNumber);
                                    $imageInfo = imap_mime_header_decode($v2->dparameters[0]->value);
                                    $imageName = $imageInfo[0]->text;
                                    $filePath = $savePath . '/' . $imageName;
                                    file_put_contents($filePath, $imageData);
                                }















                            }
                            die;
                        }
                        echo "here";
                        // echo $v1->disposition;
                        if (isset($v1->disposition) && $v1->disposition === 'attachment') {
                        echo "here34";
                            $imageData = imap_fetchbody($mailbox, $messageNumber, $currentPartNumber);
                            $imageInfo = imap_mime_header_decode($part->dparameters[0]->value);
                            $imageName = $imageInfo[0]->text;
                            $filePath = $savePath . '/' . $imageName;
                            echo $filePath;die;
                            file_put_contents($filePath, $imageData);
                        }
                    }
                }
                // if(isset($part) && $part->disposition === 'INLINE')
            }
            die;
        }
    }
    
    public function webnotification() {
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
        $organizationsql = "SELECT name,id FROM organization WHERE approval= 1 AND type IN (0,1,2)";
        $nonprofitorg = $this->CommonController->SelectRawquery($organizationsql , "resultArray");
        $this->CronController->rankbusiness($zoneid);
        return view('pushnotification', array('user_id' => $user_id,'email' => $email,'firstName' => $firstName,'lastName' => $lastName,'businessUser' => $businessUser,'session_usertype' => $session_usertype,'session_session_normal_user_in_zone' => $session_session_normal_user_in_zone,'session_session_normal_user_type' => $session_session_normal_user_type,'session_type' => $session_type,'session_type_id' => $session_type_id,'zone_name' => $zone_name,'adid' => $adid,'deal_title' => $deal_title,'zoneid' => $zoneid,'zone_id' => $zoneid,'theme' => $theme,'page' => $page,'resultdata' => $resultdata,'bsname' => $bsname,'description' => $description,'meta_business_image' => [],'meta_business_image_type' => $meta_business_image_type,'business_name' => $business_name,'header' => $header,'footer' => $footer,'nonprofitorg' => $nonprofitorg,'refer_code'=> $refer_code,'zone_owner'=>$zone_owner));

    }

    public function getnotificationdata(){
        $array = $rows = []; 
        $totalNotification = 0;
        $qry = "SELECT * FROM emailblog WHERE pushstatus=0 LIMIT 1";
        $arr = $this->CommonController->SelectRawquery($qry , "resultArray");
        if(count($arr) > 0){
            foreach ($arr as $k => $v) {
                $senderArr = explode('@', $v['sender']);
                if($senderArr[1] != ''){
                    $sendinnerArr = explode('.', $senderArr[1]);
                }
                $subdomain = isset($sendinnerArr[0])?$sendinnerArr[0]:'';
                $data['title'] = 'New blog waiting for you';
                $data['message'] = 'Check now.';
                $data['icon'] = 'https://windycity.savingssites.com/assets/home/directory/images/logo-green.png';
                if($subdomain != ''){
                    $data['url'] = 'https://'.$subdomain.'.savingssites.com/blogdetail?id='.$v['id'].'';
                }else{
                    $data['url'] = 'https://windycity.savingssites.com/blogdetail?id='.$v['id'].'';
                }
                $rows[] = $data;
                $this->updateNotification($v['id']);
                $totalNotification++;   
            }
            $array['notif'] = $rows;
            $array['count'] = $totalNotification;
            $array['result'] = true;
            echo json_encode($array);
            die; 
        }
    }

    public function updateNotification($id) {     
        $userData = array('pushstatus' => 1);
        $this->CommonController->updateData('emailblog',$userData,['id' => $id]);    
    }

    public function blog(){
        $search = isset($_GET['search'])?$_GET['search']:'';
        $emailArr = [];
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = 'zonefooter';
        $zone_name = "";
        $passfrom= '';
        $businessid = '';
        $zoneid = isset($zoneId) ? $zoneId:'';
        
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
                $conn = @imap_open($host, $user, $password) or die('unable to connect Gmail: ' . imap_last_error());
                if($search != ''){
                    $mails = imap_search($conn, 'SUBJECT "'.$search.'"');
                }else{
                    $mails = imap_search($conn, 'ALL');
                }
                $messageNumber = 1;
                $structure = imap_fetchstructure($conn, $messageNumber);
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
                imap_close($conn);
            }
        }
        $sql1="select * from emailblog where statx=1";
        $result=$this->CommonController->SelectRawquery($sql1);
        $purchasedealArr = $result;
        return view('blog',array('theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zoneid' => $zoneid,'zone_id' => $zoneid,'passfrom' => $passfrom,'businessid' => $businessid,'zone_name'=>'','emailArr'=> $purchasedealArr,'search'=> $search));
    }

    public function getemaildata(){
        $html = '';
        $search = isset($_REQUEST['search'])?$_REQUEST['search']:'';
        $sql1="select * from emailblog where statx=1 and subject LIKE '%".$search."%'";
        $result=$this->CommonController->SelectRawquery($sql1);
        if(count($result) > 0){
            foreach ($result as $v) {
                $html .= '<div class="col-md-6">
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
        
        echo json_encode($html);
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

