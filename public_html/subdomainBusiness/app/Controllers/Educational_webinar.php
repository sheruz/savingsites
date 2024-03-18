<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Educational_webinar extends CI_Controller {

          /**

      	  * @desc constructor function to load required data

      	*/

        public $_apiUrl = 'https://www.googleapis.com/urlshortener/v1/url?key=AIzaSyCDm5xr3XHPhRkhXDOux7j0ru0bChdEyJ0';

      	public function __construct() {

      		parent::__construct();


                $this->load->model('webinar/Webinarmodel','webinarmodel');

                $this->load->model("banner/Banner_model", "banner");

                $this->load->model("zone/Zone_model", "get_zone");

             		$this->load->database();

               $this->load->library('session');
             
               $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');

               $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

               $this->output->set_header('Pragma: no-cache');

               $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 

        
      

          }
          



 
              /**

          * @desc method to load educational webinar view 

        */

        public function webinar_register($zoneId) {
            
            


                $education_session =  $this->session->userdata('edu_webinar')['userId'];
                

          // load educational webinar  view with specific zoneId          

               $user_id =  $this->session->userdata('edu_webinar')['userId'];          

              if($user_id != ""){

                    $data['user'] = $this->webinarmodel->get_username($user_id);

                    $data['logged_in'] = 1;

                    $data['user_id'] = $user_id;

               }
                     

                $data['session_usertype']=$session_usertype; 

                $data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;

                $data['session_session_normal_user_type']=$session_session_normal_user_type;            

                $data['zonedetails'] = $this->get_zone->get_zone($zoneId); 

               $data['active_banner_mobile']  = $this->banner->active_banner_desktopmobile($zoneId,'','5','2');

               $data['active_banner_desktop']   = $this->banner->active_banner_desktopmobile($zoneId,'','5','1');



               $data['dates'] = $this->webinarmodel->get_dates();

               $data['categories'] = $this->webinarmodel->get_categories();

               // $data['banner'] = $this->webinarmodel->get_banners($zoneId);  

               $data['banner'] = $this->webinarmodel->get_banners();

               

               $data['about'] = $this->webinarmodel->get_about_content();

                $data['zoneId'] = $zoneId;


                $this->load->view('webinar/educational_header',$data);
                $this->load->view('webinar/educational_register',$data);
                $this->load->view('webinar/educational_footer',$data);

          

        }



    public function emailcheck(){
              
       
             $email =  $_REQUEST['email'];
             $role =  $_REQUEST['role'];

                $emailchecking = "SELECT * FROM `wb_webinar_user` WHERE `email` LIKE  '%".$email."%' and role ='".$role."'";

                $query = $this->db->query($emailchecking);
               
                if($query->num_rows() > 0) {
                     echo  'Exists';
                }


    }



    public function usernamecheck(){
              
       
             $username =  $_REQUEST['username'];

              $emailchecking = "SELECT * FROM `wb_webinar_user` WHERE `username` LIKE  '%".$username."%' ";

               $query = $this->db->query($emailchecking);
               
                  if($query->num_rows() > 0) {
                     echo  'Exists';
                  }


    }


  public function finalcheckout($zoneId) {
         
                 session_start();
                 $user_id =   $this->session->userdata('edu_webinar')['userId'];   

                $education_data =  $this->webinarmodel->get_userdata($user_id);
 
          // load educational webinar  view with specific zoneId          

                 $data =   $this->webinarmodel->packageDetails($_GET['pid'] , 'paid');
                 $data['education_data'] = $data;

               if($user_id != ""){

                    $data['user'] = $this->webinarmodel->get_username($user_id);

                    $data['logged_in'] = 1;

                    $data['user_id'] = $user_id;

                    $data['zone_id'] = $this->session->userdata('edu_webinar')['zoneid'];

               }          

                       if( $user_id){ 

            $auser = $education_data[0];    
 

            if(!empty($auser)){ 

     //   $this->session->set_userdata('get_email', $auser->email);

        $data["user_id"] = $auser->user_id;

        $data["email"] = $auser->email; 

        $data["firstName"] = $auser->fname;

        $data["lastName"] = $auser->lname;

        $data['businessUser'] = $auser;

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

           $directory_owner_notice = $this->webinarmodel->owner_selected_option($zoneId);


          if(@$directory_owner_notice[0]->paypal_id != ' ' && @$directory_owner_notice[0]->paypal_id){
               
            $data['paypal_key'] = $directory_owner_notice[0]->paypal_id;

          }



          $this->load->view('webinar/checkout',$data);         

        }



 public function webinar_edit($zoneId) {


             $education_session =   $this->session->userdata('edu_webinar')['userId'];                 

               $url = base_url();     
 
              $user_id =   $this->session->userdata('edu_webinar')['userId'];   
                  $data['user_id'] = $user_id;    

               if($user_id != ""){

                    $data['user'] = $this->webinarmodel->get_username($user_id);

                    $data['logged_in'] = 1;

                    $data['user_id'] = $user_id;

               }else{

                 header("Location: ".$url."educational_webinar/webinar_register/".$this->session->userdata('edu_webinar')['zoneid']);
                 die();

               }  
                
                $data['getall_webinar'] = $this->webinarmodel->get_webinar_details_order($_GET['webinar']);

        $data['zoneid'] = $zoneId;
        $data['zoneId'] = $zoneId;


           $this->load->view('webinar/educational_header', $data);
          $this->load->view('webinar/educational_webinar_edit',$data);
           $this->load->view('webinar/educational_footer',$data);



     }


     public function webinar_listregistrations($zoneId) {


             $education_session =   $this->session->userdata('edu_webinar')['userId'];                 

               $url = base_url();     
 
              $user_id =   $this->session->userdata('edu_webinar')['userId'];   
                  $data['user_id'] = $user_id;    

               if($user_id != ""){

                    $data['user'] = $this->webinarmodel->get_username($user_id);

                    $data['logged_in'] = 1;

                    $data['user_id'] = $user_id;

               }else{

                 header("Location: ".$url."educational_webinar/webinar_register/".$this->session->userdata('edu_webinar')['zoneid']);
                 die();

               }  
                
                $data['webinar_info'] = $this->webinarmodel->get_webinar_details_order($_GET['webinar']);

                $data['total_registration_users'] = $this->webinarmodel->get_registration_content($_GET['webinar']);

        $data['zoneid'] = $zoneId;
        $data['zoneId'] = $zoneId;

           $this->load->view('webinar/educational_header', $data);
          $this->load->view('webinar/educational_listregistrations',$data);
           $this->load->view('webinar/educational_footer',$data);



     }

    public function webinar_checkout($zoneId) {

            $rootpath =  realpath(".").'/application/libraries/braintree-php/lib/autoload.php' ;
            require_once($rootpath); 



         
      
             $education_session =   $this->session->userdata('edu_webinar')['userId'];                 

               $url = base_url();     
 
              $user_id =   $this->session->userdata('edu_webinar')['userId'];   

                  $data['user_id'] = $user_id;    

               if($user_id != ""){

                    $data['user'] = $this->webinarmodel->get_username($user_id);

                    $data['logged_in'] = 1;

                    $data['user_id'] = $user_id;

               }else{

                 header("Location: ".$url."educational_webinar/webinar_register/".$zoneId);
                 die();

               }       
          

              if($_GET['from'] == 'paypal' && $_GET['response']){
                
                if($_GET['PayerID']){
                $orderdupicate_check = $this->webinarmodel->checkorder(  $_GET['pid'] , $user_id);

                if($orderdupicate_check == false){
            
                  $this->webinarmodel->inderorder('paypal', $_GET['PayerID']  , $_GET['pid'] , $user_id);
                }
                 }
                 $data =   $this->webinarmodel->packageDetails($_GET['pid'] , 'paid');
                 $data['education_data'] = $data;
                 $data['education_type'] = 'paypalresponse' ;

              }  

               if($_GET['from'] == 'braintree' && $_GET['response']){
                
      
                $orderdupicate_check = $this->webinarmodel->checkorder(   $_GET['pid'] , $user_id);

                if($orderdupicate_check == false){
            
                  $this->webinarmodel->inderorder(  'braintree',0 ,  $_GET['pid'] , $user_id);
             
                 }
                 $data =   $this->webinarmodel->packageDetails($_GET['pid'] , 'paid');
                 $data['education_data'] = $data;
                 $data['education_type'] = 'paypalresponse' ;

              }  


  
 
    $packagevalidity = $this->webinarmodel->checkpackage($_GET['packageid'] , $_GET['type']);
    if($packagevalidity == 'true'){
      $data =   $this->webinarmodel->packageDetails($_GET['packageid']);
  
      if($data[0]->room_type == 'free'){
         $data['education_type'] = $data[0]->room_type;
          $data['education_data'] = $data;
           $orderdupicate_check = $this->webinarmodel->checkorder(  $_GET['packageid'] , $user_id);
           if($orderdupicate_check == false){
          
                 $this->webinarmodel->inderorder( 'free' ,  0,  $_GET['packageid'] , $user_id);
            }
                 
      }else {
         $data['education_type'] = $data[0]->room_type;
        $data['education_data'] = $data;
      }
     
       
    } 

    $data['user_type'] = $this->session->userdata("session_login_details");

    $data['session_usertype']=$session_usertype; 

    $data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;

    $data['session_session_normal_user_type']=$session_session_normal_user_type;    

               //$data['active_banner']     = $this->banner->active_banner($zoneId,'','5');

                $data['zonedetails'] = $this->get_zone->get_zone($zoneId); 

               $data['active_banner_mobile']  = $this->banner->active_banner_desktopmobile($zoneId,'','5','2');

               $data['active_banner_desktop']   = $this->banner->active_banner_desktopmobile($zoneId,'','5','1');

                

               $data['dates'] = $this->webinarmodel->get_dates();

               $data['categories'] = $this->webinarmodel->get_categories();

          //$data['banner'] = $this->webinarmodel->get_banners($zoneId);  

               $data['banner'] = $this->webinarmodel->get_banners();

               

           $data['about'] = $this->webinarmodel->get_about_content();

           $data['zoneId'] = $zoneId;

                 $directory_owner_notice = $this->webinarmodel->owner_selected_option($zoneId);

                



                 if(@$directory_owner_notice[0]->paypal_id != ' ' && @$directory_owner_notice[0]->paypal_id){
               
                   $data['paypal_key'] = $directory_owner_notice[0]->paypal_id;

                 }

          
           if(@$directory_owner_notice[0]->braintree_public_key != ' ' && @$directory_owner_notice[0]->braintree_public_key){

            if(@$directory_owner_notice[0]->braintree_merhant_key != ' ' && @$directory_owner_notice[0]->braintree_merhant_key ){
 
              if(@$directory_owner_notice[0]->braintree_private_key != ' ' && @$directory_owner_notice[0]->braintree_private_key){

    


            $gateway = new Braintree\Gateway([
                'environment' => 'production',
                'merchantId' => $directory_owner_notice[0]->braintree_merhant_key,
                'publicKey' =>  $directory_owner_notice[0]->braintree_public_key,
                'privateKey' =>  $directory_owner_notice[0]->braintree_private_key
            ]);

 
               

                 try {
                   $data['gateway_clientkey'] = $gateway->ClientToken()->generate();
                }

                //catch exception
                catch(Exception $e) {
                 
                }


          
           }
          }
 
          }



          

           $this->load->view('webinar/educational_header', $data);
           $this->load->view('webinar/educational_checkout',$data);
           $this->load->view('webinar/educational_footer',$data);

          

        }


  public function webinar_dashboard($zoneId) {
 
                

          // load educational webinar  view with specific zoneId          
 
        $user_id = $this->session->userdata('edu_webinar')['userId'];         

               if($user_id != ""){

                    

                    $data['user'] = $this->webinarmodel->get_username($user_id);

                    $data['logged_in'] = 1;

                    $data['user_id'] = $user_id;

                     $data['role'] =$this->session->userdata('edu_webinar')['role'];

                     


               }          
 
            if ($this->session->userdata('edu_webinar')['zoneid'] != $zoneId) {
                header("Location: ".base_url()."educational_webinar/webinar_dashboard/".$zoneId);
                 die();

            }
     

       

                $data['zonedetails'] = $this->get_zone->get_zone($zoneId); 

               $data['active_banner_mobile']  = $this->banner->active_banner_desktopmobile($zoneId,'','5','2');

               $data['active_banner_desktop']   = $this->banner->active_banner_desktopmobile($zoneId,'','5','1');

      

               $data['dates'] = $this->webinarmodel->get_dates($zoneId);

               $directory_owner_notice = $this->webinarmodel->owner_selected_option($zoneId);

 
               if($directory_owner_notice[0]->payment_option == 'PP'){
                 $data['payment_method_notice'] = 'The Directory Owner will charge you per person !';
               }elseif($directory_owner_notice[0]->payment_option == 'OT'){
                $data['payment_method_notice'] = 'The Directory Owner will charge Group  Tutoring!';
               }elseif($directory_owner_notice[0]->payment_option == 'MC'){
                $data['payment_method_notice'] = 'The Directory Owner will charge you monthly! ';
               }else{
                  
               }
  

              $data['registration_content'] = $this->webinarmodel->get_dashboard_content();

              $data['total_registration'] = $this->webinarmodel->get_registration_content();

              $data['overall_history'] = $this->webinarmodel->get_registration_history();



              $data['zoneid'] = $zoneId;
              $data['zoneId']= $zoneId;


          $this->load->view('webinar/educational_header', $data);
          $this->load->view('webinar/educational_dashboard',$data);
          $this->load->view('webinar/educational_footer',$data);

          

        }

      	/**

      	  * @desc method to load educational webinar view 

      	*/

      	public function webinar($zoneId) {


               $data['resultdata']=[];
 
               $user_id = $this->session->userdata('edu_webinar')['userId'];     

               if($user_id != ""){

                    

                    $data['user'] = $this->webinarmodel->get_username($user_id);

                    $data['logged_in'] = 1;

                    $data['user_id'] = $user_id;

                      $sql="select * from others_referral_id where zoneid=".$zoneId;

                      $query=$this->db->query($sql);

                        $refferalcode = $query->result_array();

                        $data['resultdata']=$refferalcode[0];



               }          
 


                $data['zonedetails'] = $this->get_zone->get_zone($zoneId); 

               $data['active_banner_mobile'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','5','2');

               $data['active_banner_desktop'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','5','1');



               $data['dates'] = $this->webinarmodel->get_dates($zoneId);

          

               $data['categories'] = $this->webinarmodel->get_categories();

      	 

               $data['banner'] = $this->webinarmodel->get_banners();

               

              $data['about'] = $this->webinarmodel->get_about_content();

              // $data['ordercount'] = $this->webinarmodel->get_totalorder();


           		$data['zoneId'] = $zoneId;


         $this->load->view('webinar/educational_header', $data);
      		$this->load->view('webinar/educational_webinar',$data);
          $this->load->view('webinar/educational_footer',$data);

      		

      	}



          public function logout($zoneId){

 
            unset($_SESSION['edu_webinar']);
      
             $url = base_url();

            echo $url.'educational_webinar/webinar/'.$_SESSION['ssZone'];

            //redirect($url.'educational_webinar/webinar/'.$zoneid);

          }



          /**

            * @desc method to load webinar details



          */

          public function showWebinar(){

               $data = array();



               $user_id =  $this->session->userdata('user_id');         

               if($user_id != ""){                       

                    $data['logged_in'] = 1;

                    $data['user_id'] = $user_id;

               } 



               $zoneid = $this->input->post('zone_id');

               $date = $this->input->post('wb_date') ? $this->input->post('wb_date') : '';

               $category = $this->input->post('category') ? $this->input->post('category') : '';                  

               $data['content'] = $this->webinarmodel->get_webinar_info($zoneid,$category,$date);

               //$data['webinar_user'] = $this->webinarmodel->get_webinar_user_info();

               //echo "<pre>";print_r($data);echo "</pre>"; //exit;            

               $this->load->view('webinar/educational_webinar_content', $data);

          }

    

         /**

            * @desc method to register a user for Live Q&A Webinar 



          */

          public function autoRegister(){



               $webinar_class_id = $this->input->post('wb_id');

               $user_id = $this->input->post('user_id');



               $this->webinarmodel->register_user($webinar_class_id,$user_id); 

               //exit;

          }

     /** ----------------------------------------------------------------------- Admin section ----------------------------------------------------------------------------------- */

          public function admin(){

               $this->load->view('webinar/admin/admin_login');

          }



          /**

            * @desc method to load admin home page

          */

          public function adminHome($userType,$userTypeId='business'){ 

               $logintype = $this->uri->segment('3');

               $this->session->set_userdata('loggedInType', $logintype);

               $loggedIn = $this->check_login();          

               if($loggedIn) {

                    $this->load->view('webinar/admin/admin_header');

                    $this->load->view('webinar/admin/admin_footer');

               }  

          }



          /**

            * @desc method to check admin login

          */

          public function check_login(){

               $session_data = array();

               $session_data = $this->session->userdata;

               $loginId = $session_data['session_login_details']['id'];         

               if(!empty($loginId)){

                    return $loginId;

               }else{

                    $url = base_url();

                    redirect($url.'educational_webinar/admin/');

               }

          }



          /**

            * @desc method to check admin logout

          */

          public function adminLogout(){

               $url = base_url();

               $this->load->driver('cache');

               $this->session->sess_destroy();

               $this->cache->clean();

               ob_clean();

               redirect($url.'educational_webinar/admin/');

          }



          /**

            * @desc method to load view for About page content 



          */

          public function aboutContent(){

               $session_data = array();

               $session_data = $this->session->userdata;

               $zoneId = $session_data['session_zoneid']['userzoneid'];          

               $data['content'] = $this->webinarmodel->get_about_content($zoneId); //echo '<pre>'; print_r($data['content']); exit;

               $data['zone_id'] = $zoneId;

               $loggedIn = $this->check_login();

               if($loggedIn) {        

                    $this->load->view('webinar/admin/admin_header');

                    $this->load->view('webinar/admin/about_content',$data);

                    $this->load->view('webinar/admin/admin_footer');

               }

          }



          /**

            * @desc method to insert and edit About page content 



          */

          public function updateAboutContent(){

               $id = $this->input->post('edit_content') ? $this->input->post('edit_content') : '' ;

               $updateData =  $this->webinarmodel->update_about_content($id,$zone_id); //echo '<pre>'; print_r($updateData); //exit;

               if($updateData){

                    $this->session->set_flashdata('msg', 'Content Updated Successfully!');

               }else{

                    $this->session->set_flashdata('error_msg', 'Content does not save at that moment! Please try after some time.'); 

               }

               redirect(base_url('educational_webinar/aboutContent')); 

          }



          /**

            * @desc method to load view for insert Categories 



          */

          public function addCategories(){

               $loggedIn = $this->check_login();

               if($loggedIn) {  

                    $this->load->view('webinar/admin/admin_header');

                    $this->load->view('webinar/admin/add_categories');

                    $this->load->view('webinar/admin/admin_footer');

               }

          }



          public function insertCategories(){



               $data = $this->webinarmodel->insert_categories();



               if($data){

                                  

                    $this->session->set_flashdata('msg', 'Data inserted Successfully!');               

                    redirect(base_url('educational_webinar/viewCategories','refresh'));

               } 

          }

           /**

            * @desc method to load view for Categories 



          */

          public function viewCategories(){

               $loggedIn = $this->check_login();

               if($loggedIn) { 

                    $data['categories'] = $this->webinarmodel->get_categories();

                    $this->load->view('webinar/admin/admin_header');

                    $this->load->view('webinar/admin/view_categories',$data);

                    $this->load->view('webinar/admin/admin_footer');

               }

          }



          /**

            * @desc method to change status for Categories 



          */

          public function changeCategoryStatus(){



               $categoryId = $this->input->post('category_id');

               $status = $this->input->post('status');



               $data = $this->webinarmodel->change_category_status($categoryId,$status);



               echo $data;

          }

          /**

            * @desc method to load view for upload Banners 



          */

          public function addBanners(){

               $loggedIn = $this->check_login();

               if($loggedIn) {

                    $this->load->view('webinar/admin/admin_header');

                    $this->load->view('webinar/admin/add_banners');

                    $this->load->view('webinar/admin/admin_footer');

               }

          }



          /**

            * @desc method to view Banners info



          */

          public function viewBanners(){



               $loggedIn = $this->check_login(); //echo '<pre>'; print_r($loggedIn); //exit;

               if($loggedIn) {

                    $session_data = array();

                    $session_data = $this->session->userdata;

                    $zoneId = $session_data['session_zoneid']['userzoneid'];

                    $data['banners'] = $this->webinarmodel->get_banners($zoneId); //echo '<pre>'; print_r($data['banners']); exit;

                    $data['zoneId'] = $zoneId;

                    $data['url_exist'] = $_SERVER['DOCUMENT_ROOT'] ."/savingssites/assets/educationalwebinar/banner/zone_".$zoneId."/";

                    $data['url'] = base_url()."assets/educationalwebinar/banner/"; 

                    $this->load->view('webinar/admin/admin_header');

                    $this->load->view('webinar/admin/view_banners',$data);

                    $this->load->view('webinar/admin/admin_footer');

               }



          }

          /**

            * @desc method to add Banners 



          */

          public function insertBanners(){

               $session_data = array();

               $session_data = $this->session->userdata;

               $zoneId = $session_data['session_zoneid']['userzoneid'];

               $data['banners'] = $this->webinarmodel->insert_banners($zoneId); //echo '<pre>'; print_r($data['banners']); exit;

               if($data['banners']){                             

                    $this->session->set_flashdata('msg', 'Image Uploaded Successfully!');

               }else{

                    $this->session->set_flashdata('error_msg', 'Image does not save at that moment! Please try after some time.');

               }

               redirect(base_url('educational_webinar/viewBanners')); 

          }



          /**

            * @desc method to change status for Banners 



          */

          public function changeBannerStatus(){

               $bannerId = $this->input->post('banner_id');

               $status = $this->input->post('status');

               $data = $this->webinarmodel->change_banner_status($bannerId,$status);

               echo $data;

          }









          public function addPresenter(){



               $loggedIn = $this->check_login(); 

               if($loggedIn) {

                    $data['businessId'] = $loggedIn;

                    $this->load->view('webinar/admin/admin_header');

                    $this->load->view('webinar/admin/add_presenter', $data);

                    $this->load->view('webinar/admin/admin_footer');

               }

          }



           /**

            * @desc method to add a presenter 



          */



          public function insertPresenter(){

               $data = $this->webinarmodel->insert_presenter();

               if($data){                        

                    $this->session->set_flashdata('msg', 'Presenter information updated Successfully!');

                    redirect(base_url('educational_webinar/viewPresenter','refresh'));

               }else{

                    $this->session->set_flashdata('error_msg', 'Presenter Information does not save at that moment! Please try after some time.');

                    redirect(base_url('educational_webinar/addPresenter','refresh'));

               }    

          }



          /**

            * @desc method to view all presenter 



          */

          public function viewPresenter(){

               $loggedIn = $this->check_login();

               if($loggedIn) {

                    $data['businessId'] = $loggedIn;

                    $data['presenter'] = $this->webinarmodel->get_presenter_details($loggedIn);

                    $this->load->view('webinar/admin/admin_header');

                    $this->load->view('webinar/admin/view_presenter',$data);

                    $this->load->view('webinar/admin/admin_footer');

               }

          }



          public function changePresenterStatus(){



               $presenterId = $this->input->post('presenter_id');

               $status = $this->input->post('status');



               $data = $this->webinarmodel->change_presenter_status($presenterId,$status);

               echo $data;



          }



          public function addWebinar(){



               $session_data = array();

               $session_data = $this->session->userdata;

               $relatedId = $session_data['session_login_details']['id'];

               $loggedInType = $session_data['loggedInType'];

               $data['classes'] = $this->webinarmodel->get_all_class($loggedInType,$relatedId);

               //echo "<pre>";print_r($data); echo "</pre>";exit;

               $this->load->view('webinar/admin/admin_header');

               $this->load->view('webinar/admin/add_webinar',$data);

               $this->load->view('webinar/admin/admin_footer');

          }

          /**

            * @desc method to add a webinar



          */

          public function insertWebinar(){



               $link = $this->input->post('webinar_link');

               $date = $this->input->post('webinar_date');

               $class = $this->input->post('webinar_class');

                         

               $webinarData =array(

                    'webinar_class_id' => $class,

                    'webinar_link' => $link,

                    'timestamp' => strtotime($date),

                    'status' => 0          

               );

                    

               $wb_data = $this->webinarmodel->insert_webinar($webinarData);

               if($wb_data){                             

                    $this->session->set_flashdata('msg', 'Data inserted Successfully!');               

                    redirect(base_url('educational_webinar/viewWebinar/','refresh'));

               }

          }



          public function viewWebinar(){



               $session_data = array();

               $session_data = $this->session->userdata;

               $relatedId = $session_data['session_login_details']['id'];

               $loggedInType = $session_data['loggedInType'];

               $data['webinar_info'] = $this->webinarmodel->get_webinar_items($loggedInType,$relatedId);

               //echo "<pre>"; print_r($data); echo "</pre>"; exit;

               $this->load->view('webinar/admin/admin_header');

               $this->load->view('webinar/admin/view_webinar',$data);

               $this->load->view('webinar/admin/admin_footer');

          }



          public function addClass(){

               $loggedIn = $this->check_login();

               if($loggedIn) {

                    $data['categories'] = $this->webinarmodel->get_categories();

                    $data['presenter'] = $this->webinarmodel->get_presenter($loggedIn);



                    $this->load->view('webinar/admin/admin_header');

                    $this->load->view('webinar/admin/add_class',$data);

                    $this->load->view('webinar/admin/admin_footer');

               }

          }



          public function insertClass(){



               $classNmae = $this->input->post('class_name');

               $information = $this->input->post('webinar_info');

               $category = $this->input->post('category');

               $presenter = $this->input->post('presenter');



               $session_data = array();

               $session_data = $this->session->userdata;                    

               $relatedId = $session_data['session_login_details']['id'];



               $upload_path = './assets/educationalwebinar/uploads/';

               $config['upload_path'] = $upload_path;          

               $config['allowed_types'] = 'jpg|png|gif';           

               $config['max_size'] = '0';           

               $config['max_filename'] = '255';           

               $config['file_name'] = $relatedId.'_'.$_FILES['userfile']['name'];



               //echo $relatedId.'_'.$config['file_name']; exit;



               $image_data = array();

               $is_file_error = FALSE;

               //check if file was selected for upload

               if (!$_FILES) {

                     $is_file_error = TRUE;

                     //echo 'Select an image file.';

                     $this->session->set_flashdata('error_msg', 'Select an image file.');               

                     redirect(base_url('educational_webinar/addClass','refresh'));

               }



               if (!$is_file_error){

                    $this->load->library('upload', $config);

                    if(!$this->upload->do_upload('userfile')) {

                              //if file upload failed then catch the errors                         

                              $this->session->set_flashdata('error_msg', $this->upload->display_errors());               

                              redirect(base_url('educational_webinar/addClass','refresh'));

                              $is_file_error = TRUE;

                    }else{

                              $image_data = $this->upload->data();

                              $config['image_library'] = 'gd2';

                              $config['source_image'] = $image_data['full_path']; //get original image

                              $config['maintain_ratio'] = TRUE;

                              $config['width'] = 260;

                              $config['height'] = 250;



                              $this->load->library('image_lib', $config);

                              if (!$this->image_lib->resize()) {

                                  //echo $this->image_lib->display_errors();

                                  $this->session->set_flashdata('error_msg', $this->image_lib->display_errors());               

                                  redirect(base_url('educational_webinar/addClass','refresh'));

                              }

                    }

               }



               if ($is_file_error) {

                     if ($image_data) {

                         $file = $upload_path . $image_data['file_name'];

                         if (file_exists($file)) {

                             unlink($file);

                         }

                     }

               } else {

                    $data['resize_img'] = $upload_path . $image_data['file_name'];                    

                    $loggedInType = $session_data['loggedInType']; //echo $loggedInType ; exit;



                    if($loggedInType == 'business'){

                         $relatedType = 1;

                    }

                    $zoneId = $this->webinarmodel->get_zone($relatedId);

                    $classData =array(

                         'type' => 1,

                         'related_type' => $relatedType,

                         'related_id' => $relatedId,

                         'zone_id' => $zoneId,

                         'category_id' => $category,

                         'presenter_id' => $presenter,

                         'cover_photo' => $image_data['file_name'],

                         'class_name' => $classNmae,

                         'information' => $information,

                         'timestamp' => time()           

                    );



                    //print_r($classData);exit;

                    

                    $wb_data = $this->webinarmodel->insert_class($classData);

                    if($wb_data){                             

                         $this->session->set_flashdata('msg', 'Data inserted Successfully!');               

                         redirect(base_url('educational_webinar/viewClass','refresh'));

                    }

               }

          }



          public function viewClass(){



               $session_data = array();

               $session_data = $this->session->userdata;

               $relatedId = $session_data['session_login_details']['id'];

               $data['webinar_info'] = $this->webinarmodel->get_webinar_details($relatedId);



               $this->load->view('webinar/admin/admin_header');

               $this->load->view('webinar/admin/view_class',$data);

               $this->load->view('webinar/admin/admin_footer');

          }



          public function editClass($id){



               $classId = $id;

               $session_data = array();

               $session_data = $this->session->userdata;

               $relatedId = $session_data['session_login_details']['id'];

               $data['class'] = $this->webinarmodel->get_class_details($classId);

               $data['categories'] = $this->webinarmodel->get_categories();

               $data['presenter'] = $this->webinarmodel->get_presenter($relatedId);

               //echo "<pre>"; print_r($data); echo "</pre>"; exit;

               $this->load->view('webinar/admin/admin_header');

               $this->load->view('webinar/admin/edit_class',$data);

               $this->load->view('webinar/admin/admin_footer');

          }



          public function updateClassDetails(){



               $id = $this->input->post('classId');

               $classNmae = $this->input->post('class_name');

               $information = $this->input->post('webinar_info');

               $category = $this->input->post('category');

               $presenter = $this->input->post('presenter');



               $session_data = array();

               $session_data = $this->session->userdata;

               $relatedId = $session_data['session_login_details']['id'];



               $upload_path = './assets/educationalwebinar/uploads/';

               $config['upload_path'] = $upload_path;          

               $config['allowed_types'] = 'jpg|png|gif';           

               $config['max_size'] = '0';           

               $config['max_filename'] = '255';           

               $config['file_name'] = $relatedId.'_'.$_FILES['userfile']['name'];



               $image_data = array();

               $is_file_error = FALSE;

               //check if file was selected for upload

               if (!$_FILES) {

                     $is_file_error = TRUE;

                     //echo 'Select an image file.';

                     $this->session->set_flashdata('error_msg', 'Select an image file.');               

                     redirect(base_url('educational_webinar/editClass/'.$id,'refresh'));

               }



               if (!$is_file_error){

                   

                    $this->load->library('upload', $config);

                    if($this->upload->do_upload('userfile')) {

                          

                              //if file upload failed then catch the errors                         

                             /* $this->session->set_flashdata('error_msg', $this->upload->display_errors());               

                              redirect(base_url('educational_webinar/editClass/'.$id,'refresh'));

                              $is_file_error = TRUE;

                    }else{ */

                              $image_data = $this->upload->data();

                              $config['image_library'] = 'gd2';

                              $config['source_image'] = $image_data['full_path']; //get original image

                              $config['maintain_ratio'] = TRUE;

                              $config['width'] = 260;

                              $config['height'] = 250;



                              $this->load->library('image_lib', $config);

                              if (!$this->image_lib->resize()) {

                                  //echo $this->image_lib->display_errors();

                                  $this->session->set_flashdata('error_msg', $this->image_lib->display_errors());               

                                  redirect(base_url('educational_webinar/editClass/'.$id,'refresh'));

                              }

                    }

               }



               if ($is_file_error) {

                     if ($image_data) {

                         $file = $upload_path . $image_data['file_name'];

                         if (file_exists($file)) {

                             unlink($file);

                         }

                     }

               } else {

                    $data['resize_img'] = $upload_path . $image_data['file_name'];

                    $zoneId = $this->webinarmodel->get_zone($relatedId);

                    $loggedInType = $session_data['loggedInType']; //echo $loggedInType ; exit;



                    if($loggedInType == 'business'){

                         $relatedType = 1;

                    }

                    if($image_data['file_name'] == ''){



                               $classData =array(

                                   'type' => 1,

                                   'related_type' => $relatedType,

                                   'related_id' => $relatedId,

                                   'zone_id' => $zoneId,

                                   'category_id' => $category,

                                   'presenter_id' => $presenter,

                                   'class_name' => $classNmae,

                                   'information' => $information,

                                   'timestamp' => time()           

                              );



                    }else{



                              $classData =array(

                                   'type' => 1,

                                   'related_type' => $relatedType,

                                   'related_id' => $relatedId,

                                   'zone_id' => $zoneId,

                                   'category_id' => $category,

                                   'presenter_id' => $presenter,

                                   'cover_photo' => $image_data['file_name'],

                                   'class_name' => $classNmae,

                                   'information' => $information,

                                   'timestamp' => time()           

                              );





                    }

                   

                    

                    $wb_data = $this->webinarmodel->update_class($id,$classData);

                    if($wb_data){                             

                         $this->session->set_flashdata('msg', 'Data updated Successfully!');               

                         redirect(base_url('educational_webinar/viewClass','refresh'));

                    }

               }



               //$class_update = $this->webinarmodel->update_class($id,$classData);

          }

          /**

            * Method to insert a new rating

            * @access public

            * @return $updateStatus boolean

          */

          public function rating() {

               $classId       = isset($_REQUEST['classId']) ? $_REQUEST['classId'] : '';

               $currentRating = isset($_REQUEST['currentRating']) ? $_REQUEST['currentRating'] : '';

               $userId        = isset($_REQUEST['userId']) ? $_REQUEST['userId'] : '';

               $updateInsertStatus = false;

              $queryTocheckAlreadyRecordratingExists = "SELECT * FROM `wb_webinar_rating` WHERE `class_id` = ".$classId." AND `users_id` =".$userId;

               $query = $this->db->query($queryTocheckAlreadyRecordratingExists);

               $finalQuery = '';

               if($query->num_rows() > 0) {

                    $finalQuery = "UPDATE `wb_webinar_rating` SET `value` = ".$currentRating." WHERE `class_id` = ".$classId." AND `users_id` =".$userId;

               } else {

                    $finalQuery = "INSERT INTO `wb_webinar_rating` SET `value`=".$currentRating.",`class_id` =".$classId.",`users_id` =".$userId;

               }

               if($this->db->query($finalQuery)) {

                    $updateInsertStatus = true;

               }

               echo json_encode($updateInsertStatus);

          }



          public function test() {

               $url = 'http://development.savingssites.com/zone/488';

               $data = $this->getShortenUrl($url);

               if($data !== '') {

                $data = json_decode($data);

                echo "<pre>";

                print_r($data->id);

                echo "</pre>";



               }

              

          }



          /**

            * Method to shorten a url

            * @access public



          */

          public function getShortenUrl($url = 'http://development.savingssites.com/zone/488') {

               if(empty($url)) {

                    return;

               }

               $postArray = array('longUrl' => $url);

               $postString = json_encode($postArray);

               $headers = array('Content-Type:application/json');

               $curl = curl_init();

               curl_setopt($curl, CURLOPT_POST, 1);

               curl_setopt($curl, CURLOPT_URL, $this->_apiUrl);

               curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

               curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

               curl_setopt($curl, CURLOPT_POSTFIELDS, $postString);

               $result = curl_exec($curl);

               $info = curl_getinfo($curl); 

               curl_close($curl);

               return $result;

               exit();

          }

          /**

            * Method for fetch webinar details by  

            * @access public

          */

          public function getAllWebinarById() {

               $webinarId = isset($_REQUEST['classId']) ? $_REQUEST['classId'] : 0;

               $webinarTimeStamp = isset($_REQUEST['time']) ? $_REQUEST['time'] : 0;

               $webinarList = $this->webinarmodel->getWebinalByMonthClass($webinarId,$webinarTimeStamp);

               echo json_encode($webinarList);

               

           }    



          public function editWebinar($id){



               $webinarId = $id;

               //echo $webinarId; exit;

               $session_data = array();

               $session_data = $this->session->userdata;

               $relatedId = $session_data['session_login_details']['id'];

               $loggedInType = $session_data['loggedInType'];

               $data['classes'] = $this->webinarmodel->get_all_class($loggedInType,$relatedId);               

               $data['webinarsDetails'] = $this->webinarmodel->get_webinar_details_by_id($webinarId);         

               //echo "<pre>"; print_r($data); echo "</pre>"; exit;

               $this->load->view('webinar/admin/admin_header');

               $this->load->view('webinar/admin/edit_webinar',$data);

               $this->load->view('webinar/admin/admin_footer');



          }



          /**

            * Method to update webinar details

            * @access public

            * 

          */



          public function updateWebinarDetails(){



               $id = $this->input->post('wb_id');

               $url = $this->input->post('webinar_link');

               $date = $this->input->post('webinar_date');

               $class = $this->input->post('webinar_class');



               $webinarData =array(

                    'webinar_class_id' => $class,

                    'webinar_link' => $url,

                    'timestamp' => strtotime($date),

                    'status' => 0          

               );



               //print_r($webinarData); exit;

               $wb_data = $this->webinarmodel->update_webinar($id,$webinarData);

               if($wb_data){                             

                    $this->session->set_flashdata('msg', 'Data updated Successfully!');               

                    redirect(base_url('educational_webinar/viewWebinar','refresh'));

               }

               

          }



          public function showByStatus(){



               $session_data = $this->session->userdata;

               $relatedId = $session_data['session_login_details']['id'];

               $loggedInType = $session_data['loggedInType'];

               $status = $this->input->post('status');



               $dataByStatus = $this->webinarmodel->webinar_data_status($status,$relatedId,$loggedInType); //echo '<pre>'; print_r($dataByStatus); exit;



               echo json_encode($dataByStatus);



          }

          /**

            * Method to see webinar details in zone dashboard

            * @access public

            * 

          */

          public function viewZoneWebinars(){



               $session_data = array();

               $session_data = $this->session->userdata;

               $relatedId = $session_data['session_login_details']['id']; //exit;

               $loggedInType = $session_data['loggedInType']; 

               //echo $relatedId; echo $loggedInType; exit;

               $data['webinar_info'] = $this->webinarmodel->get_webinar_items($loggedInType,$relatedId);

               //echo "<pre>"; print_r($data); echo "</pre>"; exit;

               $this->load->view('webinar/admin/admin_header');

               $this->load->view('webinar/admin/view_zone_webinar',$data);

               $this->load->view('webinar/admin/admin_footer');

          }



          public function editZoneWebinar($id){

               $webinarId = $id;

               //echo $webinarId; exit;

               $session_data = array();

               $session_data = $this->session->userdata;

               $relatedId = $session_data['session_login_details']['id'];

               $loggedInType = $session_data['loggedInType'];

               $data['classes'] = $this->webinarmodel->get_all_class($loggedInType,$relatedId);

               //$data['classes'] = $this->webinarmodel->get_all_class();

               $data['webinarsDetails'] = $this->webinarmodel->get_webinar_details_by_id($webinarId);         

               //echo "<pre>"; print_r($data); echo "</pre>"; exit;

               $this->load->view('webinar/admin/admin_header');

               $this->load->view('webinar/admin/edit_zone_webinar',$data);

               $this->load->view('webinar/admin/admin_footer');

               

          }

           /**

            * Method to update webinar details in zone dashboard

            * @access public

            * 

          */



          public function updateZoneWebinarDetails(){



               $id = $this->input->post('wb_id');

               $url = $this->input->post('webinar_link');

               $date = $this->input->post('webinar_date');

               $class = $this->input->post('webinar_class');



               $webinarData =array(

                    'webinar_class_id' => $class,

                    'webinar_link' => $url,

                    'timestamp' => strtotime($date),

                    'status' => 0          

               );



               //print_r($webinarData); exit;

               $wb_data = $this->webinarmodel->update_webinar($id,$webinarData);

               if($wb_data){                             

                    $this->session->set_flashdata('msg', 'Data updated Successfully!');               

                    redirect(base_url('educational_webinar/viewZoneWebinars','refresh'));

               }

          }



          /**

            * Method to change webinar status by zone

            * @access public

            * 

          */



          public function changeWebinarStatus(){



               $webinarId = $this->input->post('wbinar_id');

               $status = $this->input->post('status');

               $url = $this->input->post('url');               

              

               $shortenUrl = $this->getShortenUrl($url);



               if($shortenUrl !== '') {

                    $data = json_decode($shortenUrl);                

               }



               $data = $this->webinarmodel->change_wbinar_status($webinarId,$status,$data->id);

               echo $data;

          }





          public function createZoneAdmin(){



               $zoneId = $this->input->post('zoneId');

               $userId = $this->input->post('userId');



               $response = array();



               if(!empty($zoneId) && !empty($userId)){

                    $checkUserExists = $this->checkUserExists($zoneId);

                    $randomToken = $this->generateRandomString(10);



                    if($checkUserExists){



                         $sqlUpdateToken = "UPDATE wb_admin SET `token` = '".$randomToken."' WHERE `id`=".$checkUserExists;

                         if($this->db->query($sqlUpdateToken)) {

                                $response['status'] = 1;                      

                                $response['zoneId'] = $zoneId;

                                $response['message'] = 'successfully updated';

                         }



                    }else{



                         $sqlInsertNewSql = "INSERT INTO wb_admin SET `user_id` = '".$userId."',`status`='active',`zone_id`=".$zoneId.",`token`='".$randomToken."'";



                         if($this->db->query($sqlInsertNewSql) && $this->insertbannerItems($zoneId)){

                              $response['status'] = 1;                 

                              $response['zoneId'] = $zoneId;

                              $response['message'] = 'successfully Inserted';

                         }else{



                              $response['status'] = 0;

                              $response['message'] = 'something went wrong';

                         }

                         

                    }

               }



               echo json_encode($response);          

          }



          public function checkUserExists($zoneId){



               $sqlCheckAdminExists = "SELECT id FROM wb_admin WHERE zone_id =".$zoneId;

               $query = $this->db->query($sqlCheckAdminExists);



               if($query->num_rows() > 0) {

                     $getResultedId = $query->row();

                     return $getResultedId->id;

               }

               return false;

          }



          public function generateRandomString($length = 10) {

               return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);

          }



          public function insertbannerItems($zoneId){



               $banner = "INSERT INTO wb_banner(`zone_id`,`photo`,`status`)

                          VALUES

                          (".$zoneId.",'webinarseriesbanner.jpg',1),

                          (".$zoneId.",'banner1.jpg',1),

                          (".$zoneId.",'banner2.jpg',1),

                          (".$zoneId.",'Services4.jpg',1),

                          (".$zoneId.",'banner_bg1.jpg',1),

                          (".$zoneId.",'banner_bg2.jpg',1),

                          (".$zoneId.",'slider1.jpg',1),

                          (".$zoneId.",'slider4-2.jpg',1)";



               $query = $this->db->query($banner);



               if($query){

                    return true;

               }

               return false;

          }



          public function webinarsUsers(){



               $session_data = array();

               $session_data = $this->session->userdata;

               $zoneId = $session_data['session_login_details']['id']; //exit;

               $loggedInType = $session_data['loggedInType']; 

               //echo $relatedId; exit;

               //$data['webinar_info'] = $this->webinarmodel->get_webinar_items($loggedInType,$relatedId);               

               $data['webinar_business'] = $this->webinarmodel->get_webinar_business($zoneId);

               //echo "<pre>"; print_r($data); echo "</pre>"; exit;

               $this->load->view('webinar/admin/admin_header');

               $this->load->view('webinar/admin/view_webinar_user',$data);

               $this->load->view('webinar/admin/admin_footer');

          }



          public function getClassFromBusiness(){



               $businessId = $this->input->post('businessId');

               $classes = $this->webinarmodel->class_by_business($businessId);

               

               echo json_encode($classes);



          }  



          public function getWebinarUsers(){



               $classId = $this->input->post('classId');

               $users = $this->webinarmodel->get_webinar_users($classId);

               //echo "<pre>"; print_r($users); echo "</pre>"; exit;

               echo json_encode($users);

          }



          public function sendEmailToUsers(){



               $response = array();

               $userId = $this->input->post('userId');

               $businessId = $this->input->post('businessId');

               $userEmail = $this->webinarmodel->get_user_email($userId);



               $fromemail="noreply@development.savingssites.com";

               $message_body="test msg body";



               $this->load->library('email');

               $template_subject="test subject";

               $this->email->clear();

               $this->email->from($fromemail);

               $this->email->subject($template_subject);

               $this->email->message($message_body);

               $this->email->to($userEmail);

               if($this->email->send()){



                     $response['status'] = 1; 

               }else{

                    $response['status'] = 0;

               }



               $businessEmail = $this->webinarmodel->get_business_email($businessId);



               echo json_encode($response);



          }	

}

