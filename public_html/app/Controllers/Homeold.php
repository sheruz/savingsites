<?php

 if (!defined('BASEPATH')) exit('No direct script access allowed');

 class Homeold extends CI_Controller {

    /**

      * @desc constructor function to load required data

    */

    public function __construct() {

        parent::__construct();



        $this->load->library('ion_auth');

        $this->load->library('session');

        $this->load->library('form_validation');

        $this->load->library('user_agent');



        $this->load->helper('url');

        $this->load->helper('cookie');

        $this->load->model("Zips","zips");

        $this->load->model("admin/Business", "business");

        $this->load->helper("time_helper");

		$this->load->model("banner/Banner_model", "banner");

        

        $this->load->database();



    }



    /**

      * @desc method to load business search view



    */

    public function index() {
   


        $data = array();

        if($this->ion_auth->logged_in()){ 
 
            $auser = $this->ion_auth->user()->row();

 
         
            if(!empty($auser)){                 

                $this->session->set_userdata('get_email',$auser->email);

                $data["user_id"] = $auser->user_id;

                $data["email"] = $auser->email; 

                $data["firstName"] = $auser->first_name;

                $data["lastName"] = $auser->last_name;

                $data['businessUser'] = $auser->username;

                $data['this'] = $this;

            
                # + Cookies set as user_id

                    $cookie = array(

                    'name'   => 'user_id',

                    'email'   => 'email',

                    'value'  => $data["user_id"],

                    'expire' => time()+86500,

                    'domain' => '',

                    'path'   => '/',

                    'prefix' => '',

                    );

                    set_cookie($cookie);

                # - Cookies set as user_id

            }

        }

 // print_r($_SESSION['session_normal_user_in_zone']['usertype']);

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


       

        $data['link_path']= $this->config->item('base_url');

        $data['base_url'] = $this->config->item('base_url');

 
          if($_SESSION['session_login_details']){

            $data['zoneid'] = $_SESSION['session_login_details']['id'];

            $data['user_type']['type'] = $_SESSION['session_login_details']['type'];


                $sql="select * from others_referral_id where zoneid=".$_SESSION['session_login_details']['id'];

                $query=$this->db->query($sql);

                $refferalcode = $query->result_array();

                $data['resultdata']=$refferalcode[0];






          } else{

              $data['zoneid'] = '598';
               
             $data['user_type']['type'] = '';

             $data['resultdata']=[];

          }
     
 

        $data['adid'] = '';

        $data['deal_title'] = '';

        $data['theme']  = "blue"; 

        $data['page']   = 'Old Glory';

        $data['currentpage']   = 'home';

        $data['css']            = 'style_home';  

        $data['head']           = $this->load->view("includes/head",$data); 

        $data['header']         = $this->load->view("includes/home_header", $data); 

        $data['slider']         = $this->load->view("includes/home_mslider", $data);

        $data['offer_header']   = $this->load->view("includes/home_offer_header",$data); 

        $data['footer']         = $this->load->view("includes/home_footer", $data);

        $data['modals']         = $this->load->view("includes/modals",$data);

 

    }


    
     public function thankyou(){ 

        $data['adid'] = '';

        $data['deal_title'] = '';

        $data['theme']  = "blue"; 

        $data['page']   = 'Old Glory';

        $data['currentpage']   = 'home';

        $data['css']            = 'style_home';
          
        $this->business->storecredit(@$_REQUEST['bid'] ,@$_REQUEST['credit'] , @$_REQUEST['token']);


        $data['head']           = $this->load->view("includes/head",$data); 

        $data['header']         = $this->load->view("includes/home_header", $data); 

 
       $data['content']         = $this->load->view("includes/thankyou", $data); 

        $data['footer']         = $this->load->view("includes/home_footer", $data);

        $data['modals']         = $this->load->view("includes/modals",$data);
    }



    public function contact_us(){

        $data = array();

        $data['link_path']= $this->config->item('link_path');

        $data['base_url'] = $this->config->item('base_url');

        $data['zoneid'] = '';

        $data['user_id'] = '';

        $data['user_type']['type'] = '';

        $data['adid'] = '';

        $data['deal_title'] = '';

        $data['theme']  = "blue"; 

        $data['page']   = 'Old Glory';

        $data['css']            = 'style_home';

        $data['currentpage']   = 'contact';  

        $data['head']           = $this->load->view("includes/head",$data); 

        $data['header']         = $this->load->view("includes/home_header", $data);

        //$data['slider']       = $this->load->view("includes/home_slider", $data);

       // $data['offer_header']     = $this->load->view("includes/offer_header",$data);

        $data['directory']      = $this->load->view("includes/home/contact",$data);

        $data['footer']         = $this->load->view("includes/home_footer", $data);

        $data['modals']         = $this->load->view("includes/modals",$data);

    }



        public function publisherTOS(){

            /*echo "hello TOS";

            exit;*/

        $data = array();

        $data['link_path']= $this->config->item('link_path');

        $data['base_url'] = $this->config->item('base_url');

        $data['zoneid'] = '';

        $data['user_id'] = '';

        $data['user_type']['type'] = '';

        $data['adid'] = '';

        $data['deal_title'] = '';

        $data['theme']  = "blue"; 

        $data['page']   = 'Old Glory';

        $data['css']            = 'style_home';

        $data['currentpage']   = 'contact';  

        $data['head']           = $this->load->view("includes/head",$data); 

        $data['header']         = $this->load->view("includes/home_header", $data);

        $data['directory']      = $this->load->view("includes/home/publishertos",$data);

        $data['footer']         = $this->load->view("includes/home_footer", $data);

        $data['modals']         = $this->load->view("includes/modals",$data);

    }

    

    public function contact(){

        

        $name =(!empty($_REQUEST['name']))? $_REQUEST['name'] : "";

        $email = (!empty($_REQUEST['email']))? $_REQUEST['email'] : "";

        $phone =(!empty($_REQUEST['phone']))? $_REQUEST['phone'] : "";

        $subject = (!empty($_REQUEST['subject']))? str_replace('_',' ',$_REQUEST['subject']) : "";

        $message =(!empty($_REQUEST['message']))? $_REQUEST['message'] : "";

        //var_dump($subject); exit;

        

        

        $message_body="<div style='border:1px solid #900; padding:5px;'>Dear Administrator,<br /><br />

                                        

        

        My Contact Information is as bellows: <br/><br/>

        Name:".$name." <br/><br/>

        Email:".$email." <br/><br/>

        Phone:".$phone." <br/><br/>

        Subject:".$subject." <br/><br/>

        Message:".$message." <br/><br/>";

        

        

        $fromemail=$email;

        //$admin_mail='ajdmm@optonline.net';

        $admin_mail='postmaster@savingssites.com';

      

	$config = Array(

		'protocol' => 'smtp',

		'smtp_host' => 'smtp.office365.com',

		'smtp_user' => 'postmaster@savingssites.com',

		'smtp_pass' => 'BaseballLightShoe926',

		'smtp_port' => '587',

		'smtp_crypto' => 'tls',

		'smtp_timeout' => 60,

		'newline' => "\r\n",

		'crlf' => "\r\n",

		'mailtype' => 'html',

		'charset' => 'utf-8',

		'wordwrap' => TRUE

	);





	$this->load->library('email',$config);

        $template_subject="Savingssites Contact Page Submission";

        $this->email->clear();

        $this->email->from($fromemail);

        $this->email->reply_to($fromemail);

	$this->email->subject($template_subject);

        

	$this->email->message($message_body);

        if ($this->email->send()) {

	    $report = 1;

	} else {

	    $report = 0;

	}

	echo $report;

     

    }

    

    public function about_us(){

        $data = array();

        $data['link_path'] = $this->config->item('link_path');

        $data['base_url']  = $this->config->item('base_url');

        $data['zoneid'] = '';

        $data['user_id'] = '';

        $data['user_type']['type'] = '';

        $data['adid'] = '';

        $data['deal_title'] = '';

        $data['theme']  = "blue"; 

        $data['page']   = 'Old Glory';

        $data['currentpage']   = 'about_us'; 

        $data['css']            = 'style_home';

        $data['head']           = $this->load->view("includes/head",$data); 

        $data['header']         = $this->load->view("includes/home_header", $data);

        $data['slider']       = $this->load->view("includes/about_slider", $data);

        // $data['offer_header']    = $this->load->view("includes/offer_header",$data);

        $data['directory']      = $this->load->view("includes/benefits",$data);

        $data['footer']         = $this->load->view("includes/home_footer", $data);

        $data['modals']         = $this->load->view("includes/modals",$data);

    }

    

    public function advertise(){

        $data = array();

        $data['link_path']= $this->config->item('link_path');

        $data['base_url'] = $this->config->item('base_url');

        $data['zoneid'] = '';

        $data['user_id'] = '';

        $data['user_type']['type'] = '';

        $data['adid'] = '';

        $data['deal_title'] = '';

        $data['theme']  = "blue"; 

        $data['page']   = 'Old Glory';

        $data['currentpage']   = 'advertise'; 

        $data['css']            = 'style_home';

        $data['head']           = $this->load->view("includes/head",$data); 

        $data['header']         = $this->load->view("includes/home_header", $data);

        //$data['slider']       = $this->load->view("includes/home_slider", $data);

       // $data['offer_header']     = $this->load->view("includes/offer_header",$data);

        $data['directory']      = $this->load->view("includes/home/advertise",$data);

        $data['footer']         = $this->load->view("includes/home_footer", $data);

        $data['modals']         = $this->load->view("includes/modals",$data);

    }

    

    public function zip_to_zone($zip){
        

        $zone = $this->zips->zip_to_zone($zip);
   
        if($zone == -1){

            $_zone_id = -1 ;

        }elseif(!empty($zone)){

            $_zone_id = $zone[0]['id'];           

        }else{

            $_zone_id = 0;            

        }


        echo $_zone_id;

    }



    

    

    public function business_registration($zoneId=""){
        $data = array();
        $data['zoneId'] = !empty($zoneId) ? $zoneId : 525;
        $data['link_path']= $this->config->item('link_path');
        $data['base_url'] = $this->config->item('base_url');
        $data['zoneid'] = $zoneId;
        $data['user_id'] = '';
        $data['user_type']['type'] = '';
        $data['adid'] = '';
        $data['deal_title'] = '';
        $data['theme']  = "blue"; 
        $data['page']   = 'Old Glory';
        $data['css']            = 'style_home';
        
        $all_claimed_zip = "SELECT * FROM tblClaimedZips WHERE approved = 1 ORDER BY zip ASC";
        $query_all_claimed_zip = $this->db->query($all_claimed_zip);
        $data['all_claimed_zip'] = $query_all_claimed_zip->result_array();
        
        $all_states = "SELECT a.id, a.code, a.name FROM states a, sales_zone b, zip_code_zone c, zipcode d WHERE b.id = c.zone_id AND c.zip_Code = d.zip AND d.state = a.code AND b.active = 1 GROUP BY d.state "; 
        $query_all_state = $this->db->query($all_states) ;
        $data['all_state_name'] = $query_all_state->result_array() ;
        
        $all_states = "SELECT a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name FROM zipcode as a INNER JOIN zip_code_zone as b ON a.zip=b.zip_code INNER JOIN states as c ON a.state=c.code GROUP BY state ORDER BY state asc";            
        $query_all_states = $this->db->query($all_states);
        $data['get_all_states'] = $query_all_states->result_array();
        
        $data['head']           = $this->load->view("includes/head",$data); 
        $data['header']         = $this->load->view("includes/home_header", $data);        
        $data['business_registration']   = $this->load->view("includes/home/business_registration",$data);        
        $data['footer']         = $this->load->view("includes/footer", $data);
        $data['modals']         = $this->load->view("includes/modals",$data);
    }



    public function organization_registration(){



        $data = array();

        $data['zoneId'] = !empty($zoneId) ? $zoneId : 525;

        $data['link_path']= $this->config->item('link_path');

        $data['base_url'] = $this->config->item('base_url');

        $data['zoneid'] = '';

        $data['user_id'] = '';

        $data['user_type']['type'] = '';

        $data['adid'] = '';

        $data['deal_title'] = '';

        $data['theme']  = "blue"; 

        $data['page']   = 'Old Glory'; 

        $data['css']            = 'style_home';



        $all_claimed_zip = "SELECT * FROM tblClaimedZips WHERE approved = 1 ORDER BY zip ASC";

		$query_all_claimed_zip = $this->db->query($all_claimed_zip);

        $data['all_claimed_zip'] = $query_all_claimed_zip->result_array();



        $all_zip_code = "SELECT a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name FROM zipcode as a INNER JOIN zip_code_zone as b ON a.zip=b.zip_code INNER JOIN states as c ON a.state=c.code GROUP BY zip_code ORDER BY state asc";

		$query_zip_code = $this->db->query($all_zip_code);

        $data['all_zip_code'] = $query_zip_code->result_array();

        

        $all_states = "SELECT a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name FROM zipcode as a INNER JOIN zip_code_zone as b ON a.zip=b.zip_code INNER JOIN states as c ON a.state=c.code GROUP BY state ORDER BY state asc";

			

        $query_all_states = $this->db->query($all_states);

        $data['get_all_states'] = $query_all_states->result_array();

            

        $data['head']           = $this->load->view("includes/head",$data); 

        $data['header']         = $this->load->view("includes/home_header", $data);        

        $data['organization_registration']   = $this->load->view("includes/home/organization_registration",$data);        

        $data['footer']         = $this->load->view("includes/home_footer", $data);

        $data['modals']         = $this->load->view("includes/modals",$data);

    }



    public function business_login(){



        $data = array();

        //$data['zoneId'] = !empty($zoneId) ? $zoneId : 525;

        $data['link_path']          = $this->config->item('link_path');

        $data['base_url']           = $this->config->item('base_url');

        $data['zoneid']             = '';

        $data['user_id']            = '';

        $data['user_type']['type']  = '';

        $data['adid']               = '';

        $data['deal_title']         = '';

        $data['theme']              = "blue"; 

        $data['page']               = 'Old Glory';

        $data['css']                = 'style_home';

        $data['logintype']          = 5;

        $data['formtitle']          = 'Business '; 

        $data['head']               = $this->load->view("includes/head",$data); 

        $data['header']             = $this->load->view("includes/home_header", $data);        

        $data['login']              = $this->load->view("includes/home/login",$data);        

        $data['footer']             = $this->load->view("includes/home_footer", $data);

        //$data['modals']             = $this->load->view("includes/modals",$data);



    }



    public function organization_login(){



        $data = array();

        //$data['zoneId'] = !empty($zoneId) ? $zoneId : 525;

        $data['link_path']          = $this->config->item('link_path');

        $data['base_url']           = $this->config->item('base_url');

        $data['zoneid']             = '';

        $data['user_id']            = '';

        $data['user_type']['type']  = '';

        $data['adid']               = '';

        $data['deal_title']         = '';

        $data['theme']              = "blue"; 

        $data['page']               = 'Old Glory';

        $data['css']                = 'style_home';

        $data['logintype']          = 8;

        $data['formtitle']          = 'Organization ';  

        $data['head']               = $this->load->view("includes/head",$data); 

        $data['header']             = $this->load->view("includes/home_header", $data);        

        $data['login']              = $this->load->view("includes/home/login",$data);        

        $data['footer']             = $this->load->view("includes/home_footer", $data);

        //$data['modals']             = $this->load->view("includes/modals",$data);



    }



    public function zone_login(){



        $data = array();

        //$data['zoneId'] = !empty($zoneId) ? $zoneId : '';

        $data['link_path']          = $this->config->item('link_path');

        $data['base_url']           = $this->config->item('base_url');

        $data['zoneid']             = '';

        $data['user_id']            = '';

        $data['user_type']['type']  = '';

        $data['adid']               = '';

        $data['deal_title']         = '';

        $data['theme']              = "blue"; 

        $data['page']               = 'Old Glory';

        $data['css']                = 'style_home';

        $data['logintype']          = 4;

        $data['formtitle']          = 'Zone '; 

        $data['head']               = $this->load->view("includes/head",$data); 

        $data['header']             = $this->load->view("includes/home_header", $data);        

        $data['login']              = $this->load->view("includes/home/login",$data);        

        $data['footer']             = $this->load->view("includes/home_footer", $data);

        //$data['modals']             = $this->load->view("includes/modals",$data);



    }



        public function superadmin_login(){



        $data = array();

        //$data['zoneId'] = !empty($zoneId) ? $zoneId : '';

        $data['link_path']          = $this->config->item('link_path');

        $data['base_url']           = $this->config->item('base_url');

        $data['zoneid']             = '';

        $data['user_id']            = '';

        $data['user_type']['type']  = '';

        $data['adid']               = '';

        $data['deal_title']         = '';

        $data['theme']              = "blue"; 

        $data['page']               = 'Old Glory';

        $data['css']                = 'style_home';

        $data['logintype']          = 3;

        $data['formtitle']          = 'Zone '; 

        $data['head']               = $this->load->view("includes/head",$data); 

        $data['header']             = $this->load->view("includes/home_header", $data);        

        $data['login']              = $this->load->view("includes/home/login",$data);        

        $data['footer']             = $this->load->view("includes/home_footer", $data);

        //$data['modals']             = $this->load->view("includes/modals",$data);



    }



    public function business_registration_authentication($zoneId = ''){

        $data['passfrom']           = strlen($_REQUEST['passfrom'])!=0?$_REQUEST['passfrom']:"";

        $data['businessid']           = strlen($_REQUEST['businessid'])!=0?$_REQUEST['businessid']:"";

        $data['link_path']          = $this->config->item('link_path');

        $data['base_url']           = $this->config->item('base_url');

        $data['zoneid']             = $zoneId;

        $data['user_id']            = '';

        $data['user_type']['type']  = '';

        $data['adid']               = '';

        $data['deal_title']         = '';

        $data['theme']              = "blue"; 

        $data['page']               = 'Old Glory'; 

        $data['css']                = 'style_home';

        $data['head']               = $this->load->view("includes/head",$data); 

        $data['header']             = $this->load->view("includes/home_header", $data);        

        $data['check_login']        = $this->load->view("includes/home/business_authentication",$data);        

        $data['footer']             = $this->load->view("includes/footer", $data);        

    }



    public function get_forgot_password($id){

        $data = array();

        $data['link_path']          = $this->config->item('link_path');

        $data['base_url']           = $this->config->item('base_url');        

        $data['typeid']             = $id;

        $data['theme']              = "blue"; 

        $data['page']               = 'Old Glory'; 

        $data['css']                = 'style_home';

        $data['head']               = $this->load->view("includes/head",$data); 

        $data['header']             = $this->load->view("includes/home_header", $data);

        $data['forgot_password']    = $this->load->view("includes/home/forgot_password",$data); 

        $data['footer']             = $this->load->view("includes/home_footer", $data);        

    }



    function forgot_password(){ 

        $message = array();

        $name =(!empty($_REQUEST['name']))? $_REQUEST['name'] : ""; var_dump($name);

        $usertype =(!empty($_REQUEST['usertype']))? $_REQUEST['usertype'] : "";

        $forgotten = $this->ion_auth->forgotten_password($name,$usertype); var_dump($forgotten); 

        if ($forgotten){

            //$message='<div class="succ_messs_form">Thank you for submitting your reset request. A reset code should be emailed to the email address you registered under.</div>';

            $message['msg'] = 'Success';

        }else{

            //$message='<div class="error_messs_form">Sorry! Unable to get your request. Please Try again later.</div>';

            $message['msg'] = 'Failed';

        }

        echo json_encode($message);

    }



    function getZip(){

        $zone = $_REQUEST['zone'];

        $data = array();

        if($zone!=''){

            $get_zip="SELECT distinct(zip_code) AS zip FROM zip_code_zone WHERE zone_id = $zone";

            $query_get_zip = $this->db->query($get_zip);

            $data['get_zip'] = $query_get_zip->result_array();

            echo json_encode($data['get_zip']);

        }

    }



    function getZone(){

        $state = $_REQUEST['state'];

        $city = $_REQUEST['city'];

        

        $data = array();

        if($state!=''){

            if($city!=''){

                $wh=" AND a.primarycity='".$city."'";

            }

            $get_zone="SELECT c.id,c.name as zone FROM zipcode as a INNER JOIN zip_code_zone as b ON a.zip=b.zip_code INNER JOIN sales_zone as c ON b.zone_id=c.id WHERE a.state='".$state."' ".$wh." AND c.active = 1 GROUP BY c.id ORDER BY c.name asc";

            $query_get_zone = $this->db->query($get_zone);

            $data['get_zone'] = $query_get_zone->result_array();

            echo json_encode($data['get_zone']);

        }

    }



    function getCity(){ 

        $state_code = $_REQUEST['state_code']; 

        $data = array(); 

        if($state_code != -1){

            $get_all_cities = "SELECT distinct(c.primarycity) AS city FROM sales_zone a, zip_code_zone b, zipcode c WHERE a.id = b.zone_id AND b.zip_Code = c.zip AND c.state = '$state_code'  AND a.active = 1 ";

            $query_get_all_cities = $this->db->query($get_all_cities);

            $data['query_get_all_cities'] = $query_get_all_cities->result_array(); 

            echo json_encode($data['query_get_all_cities']);

        }

    }

      function callslider(){

    $data['slider']         = $this->load->view("includes/home_slider", $data);

    echo $data['slider'];



    }

    

	function callzoneslider()

	{

		$zoneid = $_POST['zoneId'];

		$data['zoneid'] = $zoneid;

		try {

			$data['active_banner_mobile'] 	= $this->banner->active_banner_desktopmobile($zoneid,'','1','2');

			$data['active_banner_desktop'] 	= $this->banner->active_banner_desktopmobile($zoneid,'','1','1');

			$data['slider'] 		= $this->load->view("includes/slider", $data);

		} catch (exception $e) {

			$data['slider'] 		= $this->load->view("includes/home_slider", $data);

		}

		echo $data['slider'];

	}

 }

 ?>

