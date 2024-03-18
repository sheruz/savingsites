<?php
namespace App\Controllers;
use App\Models\IonAuthModel;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class Welcome extends BaseController{
	private $arr_ad=array();
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
    }
	
	public function index($zone ='',$temp='',$adid=0){  
		$data = array();
 		$zoneId = empty($_REQUEST['zone']) ? 525 : $_REQUEST['zone'];
		$sessionZoneId = $this->session->userdata('zoneId') ? $this->session->userdata('zoneId') : 525;  
		$data['session_zone_id'] = $sessionZoneId;
		$data['zoneId'] = $zoneId;
 		$adid=!empty($_REQUEST['adid']) ? $_REQUEST['adid'] : 0;
		
		if(!empty($adid)){
			if(!is_numeric($_REQUEST['adid'])){
				$ad_det=$this->ad->get_ad_id_from_deal_title($_REQUEST['adid']);
			}else{
				$adid=$adid;
			}
		}
		$data['adid']=$adid;
		if($adid>0){  
			$this->load->helper('url');
 			$meta_tag_details = $this->ion_auth->meta_tag_details($adid);  
			if(!empty($meta_tag_details)){
				if($meta_tag_details[0]['deal_title']!='')
					$data['business_name']=$meta_tag_details[0]['deal_title'];
				else
					$data['business_name']=$meta_tag_details[0]['business_name'];
				
				$meta_tag_image_details = $this->ion_auth->meta_tag_image_details($adid);
				$meta_tag_business_id=$meta_tag_image_details[0]['bus_id'];
				$meta_tag_img=$meta_tag_image_details[0]['image_name'];
 				$ckeditor_img = '';
				$image_url = preg_match('/<img.+src=[\'"](?P<src>.+)[\'"].*>/i', $meta_tag_details[0]['description'], $image);
				if(!empty($image['src'])){
					$ckeditor_img= $image['src'];
				}
	 			if(!empty($meta_tag_image_details)){  
					$data['meta_business_image'][0]="http://www.savingssites.com/uploads/".$zoneId."/businessphoto/".$meta_tag_business_id."/".$meta_tag_img; 
				}else if($ckeditor_img != ''){
					$data['meta_business_image'][0] = $ckeditor_img;
				}else{ 
					$data['meta_business_image'][0]="http://savingssites.com/assets/images/slides/slide-1_fb.jpg";
				}
				
				$description=$meta_tag_details[0]['description'];
				$data['description']=urldecode(strip_tags($description));
			}			
		}
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
			$req_url=base_url().'zone/'.$session_type_id;
		}
		$link_path = $this->config->item('link_path');
		$link_path = !empty($link_path) ? $link_path : '';  
		$data['link_path']= $link_path ; 
		$zoneId = empty($_REQUEST['zone']) ? 0 : $_REQUEST['zone'];	 
		$temp=empty($_REQUEST['temp']) ? 0 : $_REQUEST['temp'];
		
		if(!empty($zone)){
			$zoneId = $zone;
		}
		$data['zone_owner_new'] = array();
		$data['zone_id'] = $zoneId;	
		if(base_url()!=current_url()){
			$data['home_url']=current_url();	
		}else{
			$data['home_url']=current_url().'zone/'.$data['zone_id'].'';
		}
		
		$data['where_from']='';
		$data['zone_type']=$zoneId ;
		$data['uid_admin']='';
		$data['login_from_mail']='';
		$data['userid_for_registration']='';
		$uid=0;
		
		if(empty($zoneId) ){
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

					$data['uid']=$uid;

                    $data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

                    $data['business_owner_new'] = $this->business->business_owner_user($uid);

                }

		 

            }

			$data['uid']=$uid;  

			if($this->session->userdata('session_login_from_mail')!=''){

				$login_from_mail_arr=$this->session->userdata('session_login_from_mail');				

				$data['login_from_mail']=$login_from_mail_arr['business_login'];

			}

		

			$scripts = array("/assets/scripts/superfish.js");

			$data['scripts'] = $scripts; 

			//$this->load->view('default/default_content', $data);

			$link_path = $this->config->item('link_path');

			if($link_path=='')	

				$data['link_path']="../";

			else

				$data['link_path']=$link_path;

			$data['content']=$this->load->view("default/show_content_home",$data,TRUE);	



        	$this->load->view("default/default_content", $data);

            return;

        }



		$theme_cookie_value=''; $zoneid_cookie_value='';

		$data['change_theme'] = $this->ad->get_display_change_theme_in_zonepage($zoneId); //var_dump($data['change_theme']);

		 

		if(!empty($data['change_theme'])){

		if($data['change_theme'][0]['ischangezonetheme']==0){

			delete_cookie("theme"); delete_cookie("zoneid");

			$theme_cookie_value=''; $zoneid_cookie_value='';

			 

		}else{

			$theme_cookie_value=$this->input->cookie('theme_zone', TRUE);

			$zoneid_cookie_value=$this->input->cookie('zoneid_zone', TRUE);

		}

		}

		

 

		$data['css_value']=''; $data['css_vertical_value']=''; //$data['css_value_for_blue'];

		if($theme_cookie_value != '' && $zoneid_cookie_value!=''){ //echo 1; exit;  

			if($theme_cookie_value=='DT' && $zoneid_cookie_value==$zoneId){ // Blue Theme

		 

				$data['css_value']="assets/stylesheets/blue_theme/up_styles_blue.css";

				$data['css_value_for_blue']="assets/stylesheets/blue_theme/styles_blue_skin.css";

				$data['css_vertical_value']="assets/stylesheets/blue_theme/blue_vertical_menu.css";

				

				$data['barter_button']='green'; $data['job_button']='green';

			}else if($theme_cookie_value=='MT' && $zoneid_cookie_value==$zoneId){ // Tan Theme, this is Default Theme

				$data['css_value']="assets/stylesheets/styles_maroon_skin.css";

				$data['css_vertical_value']="assets/stylesheets/maroon_vertical_menu.css";

				$data['css_value_for_blue']="";

				$data['barter_button']='red'; $data['job_button']='red';

			}else if($theme_cookie_value=='BT' && $zoneid_cookie_value==$zoneId){ // Blue-R Theme

		 

				$data['css_value']="assets/stylesheets/blue_theme/up_styles_blue.css";

				$data['css_value_for_blue']="assets/stylesheets/blue_theme/styles_blue-r_skin.css";

				$data['css_vertical_value']="assets/stylesheets/blue_theme/blue_vertical_menu.css";

				$data['barter_button']='blue'; $data['job_button']='blue';

			}else if($theme_cookie_value=='ET' && $zoneid_cookie_value==$zoneId){ // Blue-R Theme

				 

				$data['css_value']="assets/stylesheets/style_3/styles_dark_skin.css?time=".time();

				$data['css_value_for_blue']="assets/stylesheets/style_3/styles_dark_skin.css?time=".time();

				$data['css_vertical_value']="assets/stylesheets/dark_vertical_menu.css?time=".time();

				$data['barter_button']='dark'; $data['job_button']='dark';

			}

			

		}else{ //var_dump(2); exit;		

			$change_theme = $this->ad->get_display_change_theme_in_zonepage($zoneId);

			//var_dump($change_theme);

			if(!empty($change_theme)){

				if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='DT'){

					/*$data['css_value']="assets/stylesheets/up_styles.css";

					$data['css_vertical_value']="assets/stylesheets/up_vertical_menu.css";*/

					$data['css_value']="assets/stylesheets/blue_theme/up_styles_blue.css";

					$data['css_value_for_blue']="assets/stylesheets/blue_theme/styles_blue_skin.css";

					$data['css_vertical_value']="assets/stylesheets/blue_theme/blue_vertical_menu.css";

					//$data['css_value_for_blue']="";

					$data['barter_button']='green'; $data['job_button']='green';

				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='ET'){

					$data['css_value']="assets/stylesheets/style_3/styles_dark_skin.css?time=".time();

					/*$data['css_value_for_blue']="assets/stylesheets/styles_blue_skin.css?time=".time();*/

					$data['css_vertical_value']="assets/stylesheets/dark_vertical_menu.css?time=".time();

					$data['barter_button']='dark'; $data['job_button']='dark';

				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='MT'){

					$data['css_value']="assets/stylesheets/styles_maroon_skin.css";

					$data['css_vertical_value']="assets/stylesheets/maroon_vertical_menu.css";

					$data['css_value_for_blue']="";

					$data['barter_button']='red'; $data['job_button']='red';

				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='BT'){

				

					$data['css_value']="assets/stylesheets/blue_theme/up_styles_blue.css";

					$data['css_value_for_blue']="assets/stylesheets/styles_blue-r_skin.css";

					$data['css_vertical_value']="assets/stylesheets/blue_theme/blue_vertical_menu.css";

					$data['barter_button']='blue'; $data['job_button']='blue';

				}else if($change_theme[0]['ischangezonetheme']==1 && $change_theme[0]['zonetheme']==''){

				

					$data['css_value']="assets/stylesheets/blue_theme/up_styles_blue.css";

					$data['css_value_for_blue']="assets/stylesheets/blue_theme/styles_blue_skin.css";

					$data['css_vertical_value']="assets/stylesheets/blue_theme/blue_vertical_menu.css";

				}

				

			}

		}

		

		if($theme_cookie_value==''){

			$data['barter_button']='red'; $data['job_button']='red';

		}

		


		$data['theme_cookie_value']=$theme_cookie_value;


		

		$data['displayoffer'] = $this->ad->get_display_offer_in_zonepage($zoneId); 

		

        	$data['announcement_list'] = $this->announcements->get_announcements_for_zonepage($zoneId);

		

			$data['zone_pref_setting']=$this->sales_zone->get_default_settings_in_zone($zoneId);

			

		$cookie = array(

				'name'   => 'back_to_blog',

				'value'  => 1,

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

		

		$data['temp'] = $temp;

        $data['zone'] = $this->sales_zone->get_zone($zoneId);

        $data["firstName"] = "";



        $data['zone_id'] = $zoneId;

        $data["email"] = "";

        $data["admin"] = "";

        $data["user_id"] = "";

		

		//echo 2; //exit;

		

		

		

        if ($this->ion_auth->logged_in())

        {

            $auser = $this->ion_auth->user()->row();



            if(!empty($auser)){ 

				$data["user_id"] = $auser->user_id;

                $data["email"] = $auser->email; 



                $data["firstName"] = $auser->first_name;

                $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

				$data["user_id"] = $auser->id;

				$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";

            }

        }

		

		//var_dump($data["user_id"]);

		

		if(isset($_COOKIE['email']) && !empty($_COOKIE['email']))

        {

        	$sql="select id from users where email='".$_COOKIE['email']."'";

        	$query = $this->db->query($sql);

        	 

        	if($query->num_rows()>=1)

        	{

        		$user_favorite = $query->row()->id;

        		$data["zone_locator"] = $this->category->zone_locator($zoneId,$user_favorite);

        		$data["zone_locator_all"] = $this->category->zone_locator_all($user_favorite);

        	}

        }

		

		$sql="select * from zone_style_tag where zone_id='".$zoneId."'";

        $query = $this->db->query($sql);

		


        

        if($query->row())

        {

        	$data['style_tags']=$query->row();

        	$data['style_tags1']=$this->load->view('style_tags', $data, true);

        }



		$scripts = array("assets/scripts/jquery-1.7.2.min.js");



		$data['scripts'] = $scripts;

		$data['session_usertype']=$session_usertype;

		$data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;

		$data['session_session_normal_user_type']=$session_session_normal_user_type;

		//var_dump($data['session_session_normal_user_in_zone']); var_dump($data['session_session_normal_user_type']);

		$data['session_session_type']= !empty($session_type) ? $session_type : '';			// added !empty on 3/7/14

		$data['session_session_type_id']= !empty($session_type_id) ? $session_type_id : '';	// added !empty on 3/7/14

		$data['req_url']= !empty($req_url) ? $req_url : '';									// added !empty on 3/7/14

		$data['get_adid']=$adid; //echo $_REQUEST['type']; exit;

		$this->load->view('new_page', $data);

		if(empty($_REQUEST['type'])){ 

			if(!empty($_GET['adid']))

				redirect('zone/'.$_GET['zone'].'/business/'.$_GET['adid'], 'location', 301);

			else if(!empty($_GET['zone'])){

			 $zone_details = $this->sales_zone->get_zone($_GET['zone']);

			 $zone_name=str_replace(' ','-',$zone_details->name);	

				redirect('zone/'.$zone_name, 'location', 301);

			}

		}

		       



    }

	

	 function change_theme(){//calling from new_page

		$zoneid_zone=$_REQUEST['zoneid'];

		$themeid_zone=$_REQUEST['themeid'];

		

		//var_dump($zoneid_zone); var_dump($themeid_zone);

		//if (!get_cookie('')) {

			// cookie not set, first visit



			// create cookie to avoid hitting this case again

			/*$cookie = array(

				'name'   => 'theme_zone',

				'value'  => $themeid_zone,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($cookie);*/

			setcookie("theme_zone",$themeid_zone,time()+86500,'/');

			

			/*$cookie = array(

				'name'   => 'zoneid',

				'value'  => $zoneid,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);*/

			

			

			/*$cookie = array(

				'name'   => 'zoneid_zone',

				'value'  => $zoneid_zone,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($cookie);*/

			setcookie("zoneid_zone",$zoneid_zone,time()+86500,'/');

			

			//var_dump($_COOKIE);

			//exit;

		//} 

		$result = $zoneid_zone;

		//echo($this->dr->GetDR("","", $result, "0"));

		echo $result;

	}

	

	function change_theme_sample_lay_out(){

		$sample_layout_theme_cookie=$_REQUEST['SampleLayouttheme_1'];//var_dump($themeid_1); //exit;

			setcookie("sample_layout_theme_cookie",$sample_layout_theme_cookie,time()+86500,'/');

		$result = 1;

		echo $result;



	}	

 	// home page content start

	function get_navigation(){

		$data=array();

		$link_path = $this->config->item('link_path');

		$link_path = !empty($link_path) ? $link_path : '';  

		$data['link_path']= $link_path ; 

		$this->load->view('default/show_navigation', $data);

	}

  // saingsite contact page  
	 function contactformsubmit(){
	 		 $params = array();
	 		parse_str($_REQUEST['data'], $params);
	 			// print_r($params);die;
            // zone owner email
            $zone_data = "SELECT users.email FROM `sales_zone` inner join users on users.id = sales_zone.sales_rep_id where sales_zone.id = ".$_REQUEST['zoneid'] ;
			$query_zone_name = $this->db->query($zone_data);
			$zoneemail = $query_zone_name->result_array()[0]['email'];

         


 
		    $zone_name = "INSERT INTO contact_form (name, email, phone, message,zoneId)
		VALUES ('".$params['name']."', '".$params['email']."', '".$params['phone']."', '".$params['message']."' ,  '".$_REQUEST['zoneid']."')" ;

			$query_zone_name = $this->db->query($zone_name);


            $emailAddress =  $params['email'];
   
	        $this->load->library('email');


			$this->email->clear();

			$message = '<h2>Here is one more query:</h2> <br/><h2>Name: '.$params['name'].'</h2><h3>Phone:'.$params['phone'].'</h3><h3>Email:'.$params['email'].'</h3><h3>Message: '.$params['message'].'</h3>';

			$this->email->to($zoneemail);

			$this->email->cc($this->config->item('adminEmailId'));

			$this->email->from('DoNotReply@HGD.deals');

			$this->email->subject('Contact Us Query');

			$this->email->message($message);	

			 if ($this->email->send()) {
            echo 'Your Email has successfully been sent.';
		        } else {
		 
		        }

  

    }




	function get_footer($zoneId = ''){

		$userid_for_registration=!empty($_REQUEST['userid_for_registration']) ? $_REQUEST['userid_for_registration'] : '';

		$zoneId_new  = ($zoneId!='') ? $zoneId : '525';

		$data=array();

		$data['userid_for_registration']=$userid_for_registration;

		$data['zone_id'] = $zoneId_new;

		$this->load->view('includes/home_footer', $data);

	}

	function get_main_header($zoneId = ''){



		$zoneId  = !empty($zoneId) ? $zoneId : 525;

		//echo $zoneId;

		$data=array();

		//$zoneId = 525;		

		$zone_name = "SELECT seo_zone_name FROM sales_zone WHERE id =".$zoneId;



		$query_zone_name = $this->db->query($zone_name);

		$data['get_zone_name'] = $query_zone_name->result_array();

		$zoneName = $data['get_zone_name'][0]['seo_zone_name'];	    

	    $url =  base_url()."zone/".$zone_name."/"; 

		

		$data['displayoffer'] = $this->ad->get_display_offer_in_zonepage($zoneId); 

		//echo "<pre>";print_r($data['displayoffer']); echo "</pre>";exit;

		$auser = $this->ion_auth->user()->row();        

		

		if(!empty($auser)){

    			$data["user_id"] = $auser->user_id;

    		}else{

    			$data["user_id"] = "";

    		}

		$data['zone_id'] = $zoneId;

		$data['zone_name'] = $zoneName;

		$data['home_url'] = $url;

		$data['link_path'] = "./";	

		$this->load->view('includes/home_header', $data);



	}

	

	/**

	* SS home page about us view

	* view page -> default/default_content

	*/

	

	function about_us(){



			 $zoneId = $this->session->userdata('zoneId');		

			 if(!empty($zoneId)){

			 	$zone = $zoneId;

			 }elseif(empty($zoneId)){

			 	$zone = 525;

			 }

			$data=array();

			$data['zoneId'] = $zone;

			$data['uid_admin']='';

			$data['uid']='';

			$data['login_from_mail']='';

			$data['userid_for_registration']='';

			$link_path = $this->config->item('link_path'); //var_dump($link_path);

			//$link_path = !empty($link_path) ? $link_path : '';  

			//$data['link_path']= $link_path ;

			if($link_path=='')	

				$data['link_path']="../";

			else

				$data['link_path']=$link_path;

			$data['content']=$this->load->view("default/show_content_about_us",$data,TRUE);		

			$this->load->view("default/default_content", $data);

		//}

	}

	

	/**

	* SS home page contact us view

	* view page -> default/default_content

	*/

	

	function contact_us(){

		$zoneId = $this->session->userdata('zoneId');

		if(!empty($zoneId)){

		 	$new_zone = $zoneId;

		 }elseif(empty($zoneId)){

		 	$new_zone = 525;

		 }

		$data=array();

		$data['zoneId'] = $new_zone;

		$data['uid_admin']='';

		$data['uid']='';

		$data['login_from_mail']='';

		$data['userid_for_registration']='';

		$link_path = $this->config->item('link_path'); //var_dump($link_path);

		//$link_path = !empty($link_path) ? $link_path : '';  

		//$data['link_path']= $link_path ;

		if($link_path=='')	

			$data['link_path']="../";

		else

			$data['link_path']=$link_path;

		$data['content']=$this->load->view("default/show_content_contact_us",$data,TRUE);		

        $this->load->view("default/default_content", $data);

	}

	function business_advertise(){



		$zoneId = $this->session->userdata('zoneId');

		if(!empty($zoneId)){

		 	$new_zone = $zoneId;

		 }elseif(empty($zoneId)){

		 	$new_zone = 525;

		 }



		$data=array();

		$data['zoneId'] = $new_zone;

		$data['uid_admin']='';

		$data['uid']='';

		$data['login_from_mail']='';

		$data['userid_for_registration']='';

		$link_path = $this->config->item('link_path');

		if($link_path=='')	

			$data['link_path']="../";

		else

			$data['link_path']=$link_path;

		//echo "1111111111111"; exit;

		$data['content']=$this->load->view("default/show_content_to_advertise",$data,TRUE);		

        $this->load->view("default/default_content", $data);

	}		

	

	/**

	* SS Home page 4 users login credential into dropdown 

	*

	* Zone user type = 4,   Business user type = 5, Organiztion user type = 8, Resident user type = 14

	*

	* Sub View page -  default/show_content_zone_login "OR" default/login_verification

	*

	* This sub page loaded into main pages - default/default_content

	*/

	

	function account_updates($logintype=''){

		//echo '<pre>'; print_r($this->session->userdata); exit;

		$session_type=''; $session_type_id=''; $req_url='';

		//var_dump($this->session->userdata('usersessiondata'));exit;

		if($this->session->userdata('usersessiondata')!=''){ 			

			$session_type_arr=$this->session->userdata('usersessiondata');

			$session_type=$session_type_arr['usergrid']; 

		}else if($this->session->userdata('session_normal_user_in_zone')!=''){

			$session_type_arr=$this->session->userdata('session_normal_user_in_zone');

			$session_type=$session_type_arr['sesusertype']; 

		}else{

			$session_type=''; $session_type_id=''; $req_url='';

		}

		//echo $session_type; exit;

		if($session_type==4){

			 $session_type_id=$session_type_arr['userzoneid'];

			 $req_url=base_url().'Zonedashboard/zonedetail/'.$session_type_id;

		}else if($session_type==5){

			 if($this->session->userdata('session_zoneid_from_bus')!=''){ 							 			

				$session_type_arr=$this->session->userdata('session_zoneid_from_bus');

				$session_type_id=$session_type_arr['busid'];

				$session_type=$session_type_arr['type'];

				$req_url=base_url().'businessdashboard/businessdetail/'.$session_type_id;

				/*if($session_type=='business'){

					$req_url=base_url().'businessdashboard/businessdetail/'.$session_type_id;

				}else if($session_type=='listed'){

					$req_url=base_url().'auth/listed_business_verification/'.$session_type_id;

				}*/

			}

		}else if($session_type==8){ 

			if($this->session->userdata('session_orgid')!=''){ 			

				$session_type_arr=$this->session->userdata('session_orgid');

				$session_type_id=$session_type_arr['sesorgid'];

				$req_url=base_url().'organizationdashboard/organizationdetail/'.$session_type_id;

			}

		}else if($session_type==14){

 			if($this->session->userdata('session_zoneid_from_realtor')!=''){ 	

				$session_type_arr=$this->session->userdata('session_zoneid_from_realtor'); 

				$session_type_id=$this->session->userdata('user_id');

				$req_url=base_url().'realtordashboard/realtor_directory/'.$session_type_id;

			}

		}else if($session_type=='resident_user'){

			$session_type_id=$session_type_arr['sesuserzone'];

			$req_url=base_url().'index.php?zone='.$session_type_id;

		}

        $this->load->library('session');

		$zoneId = $this->session->userdata('zoneId');

		if(!empty($zoneId)){

		 	$new_zone = $zoneId;

		 }elseif(empty($zoneId)){

		 	$new_zone = 525;

		 }

		$data=array();

		$data['zoneId'] = $new_zone;

		$scripts = array ("assets/scripts/new/jquery.jqtransform.js");

		$data['scripts'] = $scripts;

		$data['zip_claimed_by_user']=''; $data['login_from_mail']='';

			

		$data['uid_admin']='';

		$data['uid']='';

		$data['login_from_mail']='';

		$data['userid_for_registration']='';

		$data['logintype']=$logintype; //var_dump($data['logintype']);

		$data['req_url']=$req_url;

		$data['session_type_id']=$session_type_id;

		$link_path=	$this->config->item('link_path');

		if($link_path=='')	

			$data['link_path']="../../";

		else

			$data['link_path']=$link_path;	

		$data['allzone'] = $this->sales_zone->get_all_zone();	

		if($session_type=='' && $session_type_id==''){

			$data['content']=$this->load->view("default/show_content_zone_login",$data,TRUE);

		}else{

			$data['content']=$this->load->view("default/login_verification",$data,TRUE);

		}

		$link_path = $this->config->item('link_path');

			if($link_path=='')	

				$data['link_path']="../";

			else

				$data['link_path']=$link_path;

        $this->load->view("default/default_content", $data);

	}

	function new_zone_owners($uid=0){



		$zoneId = $this->session->userdata('zoneId');		

		 if(!empty($zoneId)){

		 	$zone = $zoneId;

		 }elseif(empty($zoneId)){

		 	$zone = 525;

		 }

		$data=array();

		$data['uid_admin']='';

		$data['zoneId'] = $zone;

		$data['login_from_mail']='';

		$data['userid_for_registration']='';

		$data['uid']=$uid;

		if($this->session->userdata('zip_claimed_by_user')){

			$this->session->unset_userdata('zip_claimed_by_user');				

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

			 //$req_url=base_url().'dashboards/zone/'.$session_type_id;

			 $req_url=base_url().'Zonedashboard/zonedetail/'.$session_type_id;

		}else if($session_type==5){ 

			 if($this->session->userdata('session_zoneid_from_bus')!=''){ 							 			

				$session_type_arr=$this->session->userdata('session_zoneid_from_bus');

				$session_type_id=$session_type_arr['busid'];

				$session_type=$session_type_arr['type'];

				if($session_type=='business'){

					//$req_url=base_url().'dashboards/business/'.$session_type_id;

					$req_url=base_url().'businessdashboard/businessdetail/'.$session_type_id;

				}else if($session_type=='listed'){

					$req_url=base_url().'auth/listed_business_verification/'.$session_type_id;

				}

			}

		}else if($session_type==8){

			if($this->session->userdata('session_orgid')!=''){ 			

				$session_type_arr=$this->session->userdata('session_orgid');

				$session_type_id=$session_type_arr['sesorgid'];

				$req_url=base_url().'organizationdashboard/organizationdetail/'.$session_type_id;

				//$req_url=base_url().'dashboards/organization/'.$session_type_id;

			}

		}else if($session_type=='resident_user'){

			$session_type_id=$session_type_arr['sesuserzone'];

			$req_url=base_url().'index.php?zone='.$session_type_id;

			//$req_url=base_url().'realtordashboard/realtor_directory/'.$session_type_id;

		}

		$data['req_url']=$req_url; $data['session_type']=$session_type; $data['session_type_id']=$session_type_id;

		$link_path = $this->config->item('link_path');

		if($link_path=='')	

			$data['link_path']="../";

		else

			$data['link_path']=$link_path;

		if($session_type=='' && $session_type_id==''){

			$data['content']=$this->load->view("default/show_content_claim_zips",$data,TRUE);

		}else{

			$data['content']=$this->load->view("default/login_verification",$data,TRUE);

		}

		//$data['content']=$this->load->view("default/show_content_claim_zips",$data,TRUE);	

		$link_path = $this->config->item('link_path');

			if($link_path=='')	

				$data['link_path']="../";

			else

				$data['link_path']=$link_path;	

        $this->load->view("default/default_content", $data);

		//$this->load->view('default/show_content_claim_zips', $data);

	}

	function new_zone_owners_about(){

		$zoneId = $this->session->userdata('zoneId');

		if(!empty($zoneId)){

		 	$new_zone = $zoneId;

		 }elseif(empty($zoneId)){

		 	$new_zone = 525;

		 }

		$data=array();

		$data['zoneId'] = $new_zone;

		$data['uid_admin']='';

		

		$data['login_from_mail']='';

		$data['userid_for_registration']='';

		$data['uid']=0;

		$link_path = $this->config->item('link_path');

		if($link_path=='')	

			$data['link_path']="../";

		else

			$data['link_path']=$link_path;

		$data['content']=$this->load->view("default/show_content_about_claim_zips",$data,TRUE);	

		$link_path = $this->config->item('link_path');

			if($link_path=='')	

				$data['link_path']="../";

			else

				$data['link_path']=$link_path;	

        $this->load->view("default/default_content", $data);

		//$this->load->view('default/show_content_claim_zips', $data);

	}





	/**

	* SS home page Business Registration view

	*

	* Some subview page loaded into main pages. 

	*

	* Main view page -> default/default_content

	*/

	function business_registration_authentication($zoneId = ''){

       $data=array();
	    $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
 		$segments = explode('/', rtrim($_SERVER['REQUEST_URI_PATH'], '/'));	
 

	    if(count($segments) == 5){
 	    	
 		 $valid_referrer = $this->sales_zone->validate_referral($segments[4]);	 
 		   if($valid_referrer == 1){
 		   $data['refferalcode']	 = $segments[4]; 
 		   }
 		 
 		}




		$this->session->set_userdata('zoneId', $zoneId);

		

		$data['uid_admin']='';

		$data['login_from_mail']='';

		$data['userid_for_registration']='';

		$data['uid']=0;

		$data['zoneId'] = !empty($zoneId) ? $zoneId : 525;

		$link_path = $this->config->item('link_path');

		if($link_path=='')	

			$data['link_path']="../../";

		else

			$data['link_path']=$link_path;

		$data['content']=$this->load->view("default/show_content_business_authentication",$data,TRUE);		

        $this->load->view("default/default_content", $data);

		//$this->load->view('default/show_content_claim_zips', $data);

	}



	

	/**

	* SS home page Business Registration view

	*

	* Some subview page loaded into main pages. 

	*

	* Main view page -> default/default_content

	*/

	

	function business_registration($zoneId=""){



		 $data=array();
	    $_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
 		$segments = explode('/', rtrim($_SERVER['REQUEST_URI_PATH'], '/'));	
 

	    if(count($segments) == 5){
 	    	
 		 $valid_referrer = $this->sales_zone->validate_referral($segments[4]);	 
 		   if($valid_referrer == 1){
 		   $data['refferalcode']	 = $segments[4]; 
 		   }
 		 
 		}



		$data['zoneId'] = !empty($zoneId) ? $zoneId : 525;

		$data['refer_code'] = isset($_REQUEST['refer_code']) ? $_REQUEST['refer_code'] : '';

		$data['userid_for_registration']=''; $data['users_email']=''; $data['users_fn']=''; $data['users_ln']=''; $data['user_already_exist']=''; $data['type']='';

		$data['uid_admin']='';

		$data['uid']='';

		$data['login_from_mail']='';

		//$type=!empty($_REQUEST['type']) ? $_REQUEST['type'] : '';

		//$userid_for_registration=!empty($_REQUEST['uid_admin']) ? $_REQUEST['uid_admin'] : '';

		//$data['state_list'] = $this->states->get_state_dropdown();									---> Not Needed for now

		//print_r($this->session->all_userdata());

		

		// + Get all the claimed zip codes added on 18.11.14  															

			$all_claimed_zip = "SELECT * FROM tblClaimedZips WHERE approved = 1 ORDER BY zip ASC";

			$query_all_claimed_zip = $this->db->query($all_claimed_zip);

			$data['all_claimed_zip'] = $query_all_claimed_zip->result_array();

		// - Get all the claimed zip codes

		

		// + Get all the states added on 19.11.14

			/*$all_states = "SELECT a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name FROM zipcode as a INNER JOIN zip_code_zone as b ON a.zip=b.zip_code INNER JOIN states as c ON a.state=c.code GROUP BY state ORDER BY state asc";

			$query_all_states = $this->db->query($all_states);

			$data['get_all_states'] = $query_all_states->result_array();*/

		// - Get all the states

		

			// + Get all the zipcode added on 31.08.2015

			$all_zip_code = "SELECT a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name FROM zipcode as a INNER JOIN zip_code_zone as b ON a.zip=b.zip_code INNER JOIN states as c ON a.state=c.code GROUP BY zip_code ORDER BY state asc";

			$query_zip_code = $this->db->query($all_zip_code);

			$data['all_zip_code'] = $query_zip_code->result_array(); 

		// - Get all the zipcode

			// + Get all state added on 5.11.2015 cr7

				$all_states = "SELECT a.id, a.code, a.name FROM states a, sales_zone b, zip_code_zone c, zipcode d WHERE b.id = c.zone_id AND c.zip_Code = d.zip AND d.state = a.code AND b.active = 1 GROUP BY d.state "; 

				$query_all_state = $this->db->query($all_states) ;

				$data['all_state_name'] = $query_all_state->result_array() ;//var_dump($data['all_zone_name']);exit ;

			// - Get all state added on 5.11.2015 cr7

			//var_dump($this->session->all_userdata());exit;

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

			 //$req_url=base_url().'dashboards/zone/'.$session_type_id;

			 $req_url=base_url().'Zonedashboard/zonedetail/'.$session_type_id;

		}else if($session_type==5){

			 if($this->session->userdata('session_zoneid_from_bus')!=''){ 							 			

				$session_type_arr=$this->session->userdata('session_zoneid_from_bus');

				$session_type_id=$session_type_arr['busid'];

				$session_type=$session_type_arr['type'];

				if($session_type=='business'){

					//$req_url=base_url().'dashboards/business/'.$session_type_id;

					$req_url=base_url().'businessdashboard/businessdetail/'.$session_type_id;

				}else if($session_type=='listed'){

					$req_url=base_url().'auth/listed_business_verification/'.$session_type_id;

				}

			}

		}else if($session_type==8){

			if($this->session->userdata('session_orgid')!=''){ 			

				$session_type_arr=$this->session->userdata('session_orgid');

				$session_type_id=$session_type_arr['sesorgid'];

				$req_url=base_url().'organizationdashboard/organizationdetail/'.$session_type_id;

				//$req_url=base_url().'dashboards/organization/'.$session_type_id;

			}

		}else if($session_type=='resident_user'){

			$session_type_id=$session_type_arr['sesuserzone'];

			$req_url=base_url().'index.php?zone='.$session_type_id;

		}

		$data['req_url']=$req_url; $data['session_type']=$session_type; $data['session_type_id']=$session_type_id;

		$link_path = $this->config->item('link_path');

		if($link_path=='')	

			$data['link_path']="../../";

		else

			$data['link_path']=$link_path;

		if($session_type=='' && $session_type_id==''){

			$data['content']=$this->load->view("default/show_content_create_user_link",$data,TRUE);

		}else{

			$data['content']=$this->load->view("default/login_verification",$data,TRUE);

		}

		

		//$data['content']=$this->load->view("default/show_content_create_user_link",$data,TRUE);

		/*echo "<pre>";

		print_r($data);

		echo "</pre>";	exit;*/	

        $this->load->view("default/default_content", $data);

	}

	

# + getCity for the State added on 19.11.14

	// function getCity(){ 

	// 	$state_code = $_REQUEST['state_code']; 

	// 	$data = array(); 

	// 	if($state_code != -1){

	// 		$get_all_cities = "SELECT distinct(c.primarycity) AS city FROM sales_zone a, zip_code_zone b, zipcode c WHERE a.id = b.zone_id AND b.zip_Code = c.zip AND c.state = '$state_code'  AND a.active = 1 ";

	// 		$query_get_all_cities = $this->db->query($get_all_cities);

	// 		$data['query_get_all_cities'] = $query_get_all_cities->result_array(); 

	// 		echo json_encode($data['query_get_all_cities']);

	// 	}

	// }

# - getCity for the State



# + getZone for the city and state added on 19.11.14

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

# - getZone for the city and state



# + getZip for selected zone added on 09.nov.2015

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

# - getZip for selected zone



# + Added on 17.11.14 to get the zone names for that zip code ---> Not Needed

	/*function zip_for_zone(){

		$zip = $_REQUEST['zip_code']; 

		$data=array();

		// Get the zone name form the seleted zip code

		$sql_get_id="SELECT b.id , b.name FROM zip_code_zone a,sales_zone b WHERE a.zone_id=b.id AND a.zip_code=".$zip;

		$query_sql_get_id = $this->db->query($sql_get_id);

		$data['sql_get_id'] = $query_sql_get_id->result_array();

			//$data['zip_to_zone']=$this->zips->zip_to_zone($zip); //var_dump($data['zip_to_zone']);

			//$result = $this->load->view('dashboards/zip_to_zone', $data, true);

		// Get the zone name form the seleted zip code

		echo json_encode($data['sql_get_id']);

	}*/

# - Added on 17.11.14 to get the zone names for that zip code	



# + Added on 25.11.14 for organization registration

	function organization_registration(){//var_dump($this->session->all_userdata());exit;//calling from new_page



		$zoneId = $this->session->userdata('zoneId');


		$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
 		$segments = explode('/', rtrim($_SERVER['REQUEST_URI_PATH'], '/'));
 	 	

	   

 

		if(!empty($zoneId)){

		 	$new_zone = $zoneId;

		 }elseif(empty($zoneId)){

		 	$new_zone = 525;

		 }

		$data=array();

		$data['zoneId'] = $new_zone;

		//$data['refer_code'] = isset($_REQUEST['refer_code']) ? $_REQUEST['refer_code'] : '';

		 $data['userid_for_registration']='';
		 $data['users_email']=''; 
		 $data['users_fn']=''; 
		 $data['users_ln']=''; 
		 $data['user_already_exist']=''; 
		 $data['type']='';

		$data['uid_admin']='';

		$data['uid']='';

		$data['login_from_mail']='';

	 

		

		// + Get all the claimed zip codes added on 18.11.14  															

			$all_claimed_zip = "SELECT * FROM tblClaimedZips WHERE approved = 1 ORDER BY zip ASC";

			$query_all_claimed_zip = $this->db->query($all_claimed_zip);

			$data['all_claimed_zip'] = $query_all_claimed_zip->result_array();

		// - Get all the claimed zip codes

		

			// + Get all the zipcode added on 31.08.2015

			$all_zip_code = "SELECT a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name FROM zipcode as a INNER JOIN zip_code_zone as b ON a.zip=b.zip_code INNER JOIN states as c ON a.state=c.code GROUP BY zip_code ORDER BY state asc";

			$query_zip_code = $this->db->query($all_zip_code);

			$data['all_zip_code'] = $query_zip_code->result_array(); 

		// - Get all the zipcode

		

		// + Get all the states added on 19.11.14

		   //  $all_states = "SELECT a.state as state_id,c.name as state_name FROM zipcode as a INNER JOIN zip_code_zone as b ON a.zip=b.zip_code INNER JOIN states as c ON a.state=c.code GROUP BY state ORDER BY state asc";

		     $all_states = "SELECT a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name FROM zipcode as a INNER JOIN zip_code_zone as b ON a.zip=b.zip_code INNER JOIN states as c ON a.state=c.code GROUP BY state ORDER BY state asc";

			

			$query_all_states = $this->db->query($all_states);

			$data['get_all_states'] = $query_all_states->result_array();//var_dump($data['get_all_states']);exit;

		// - Get all the states

		

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

			 $req_url=base_url().'Zonedashboard/zonedetail/'.$session_type_id;

			 //$req_url=base_url().'dashboards/zone/'.$session_type_id;

		}else if($session_type==5){

			 if($this->session->userdata('session_zoneid_from_bus')!=''){ 							 			

				$session_type_arr=$this->session->userdata('session_zoneid_from_bus');

				$session_type_id=$session_type_arr['busid'];

				$session_type=$session_type_arr['type'];

				if($session_type=='business'){

					$req_url=base_url().'businessdashboard/businessdetail/'.$session_type_id;

					//$req_url=base_url().'dashboards/business/'.$session_type_id;

				}else if($session_type=='listed'){

					$req_url=base_url().'auth/listed_business_verification/'.$session_type_id;

				}

			}

		}else if($session_type==8){

			if($this->session->userdata('session_orgid')!=''){ 			

				$session_type_arr=$this->session->userdata('session_orgid');

				$session_type_id=$session_type_arr['sesorgid'];

				$req_url=base_url().'organizationdashboard/organizationdetail/'.$session_type_id;

				//$req_url=base_url().'dashboards/organization/'.$session_type_id;

			}

		}else if($session_type=='resident_user'){

			$session_type_id=$session_type_arr['sesuserzone'];

			$req_url=base_url().'index.php?zone='.$session_type_id;

		}

		$data['req_url']=$req_url; $data['session_type']=$session_type; $data['session_type_id']=$session_type_id;

		// $link_path = "/";

		 if(count($segments) == 5){
 		   $data['refferalcode'] = $segments[4]; 		 
 		}


		$data['link_path']="/";

		$data['base_url'] = "http://savingssites.com/";

        $data['zoneid'] = '';

        $data['user_id'] = '';

        $data['user_type']['type'] = '';

		$data['adid'] = '';

        $data['deal_title'] = '';

        $data['theme']  = "blue"; 

        $data['page']   = 'Old Glory'; 

        $data['css'] = 'style_home';

        $data['head'] = $this->load->view("includes/head",$data); 

        // $data['header']         = $this->load->view("includes/home_header", $data);  

/*		if($link_path=='')	

			$data['link_path']="../";

		else*/

			

		if($session_type=='' && $session_type_id==''){

			$data['content']=$this->load->view("default/organization_registration",$data,TRUE);

		}else{

			$data['content']=$this->load->view("default/login_verification",$data,TRUE);

		}

		

		//$data['content']=$this->load->view("default/show_content_create_user_link",$data,TRUE);		

        $this->load->view("default/default_content", $data);

        // $data['footer']         = $this->load->view("includes/home_footer", $data);

       // $data['modals']         = $this->load->view("includes/modals",$data);

	

	} 

# - organization registration



	/**

	* SS home page section view

	*

	* Claim zip for zone create or existing zone

	*

	*/

	

	function claim_zip_step_1(){

		$get_zip=$_REQUEST['display_checkbox'];

		$uid=0;

		if ($this->ion_auth->logged_in()){

			$auser = $this->ion_auth->user()->row();

			if(!empty($auser)){

				$uid = $auser->id;

			}

		}

		$data=array();

		$data['uid']=$uid;

		$data['get_zip_details']=$this->zips->get_zip_details($get_zip,$uid);

		//print_r($data['get_zip_details']); exit;

		if(empty($data['get_zip_details'])){

			$data['get_zip_details']=0;

		}else{

		$data['showbtn']=0;

		foreach($data['get_zip_details'] as $x){

		if($x['showclaimbtn']==1)

			$data['showbtn']=1; 

		}

		}

		//print_r($data['showbtn']);

		$data['content'] =  $this->load->view("claimzips/claimed_zip_details", $data, true);

		echo json_encode($data);

		//$a=json_encode($get_zip);

		//echo $a; 

	}

	function claim_zip_step_2(){

		$get_zip=$_REQUEST['display_checkbox'];

		$uid=$_REQUEST['uid'];

		$data=array();

		$data['zip_claim']=$this->zips->get_zip_claim($get_zip,$uid);

		//$data['msg']='Your Zip Codes Have been submitted. You should recieve an approval within a day or two.';

		echo 1;

	}

	// presently not used

	function claim_zip_step_3(){

		$get_zip=$_REQUEST['display_checkbox'];

		$session_zip_claimed_by_user = array('zip_claimed_by_user'=>$get_zip);

		$this->session->set_userdata('session_zip_claimed_by_user',$session_zip_claimed_by_user);

		//print_r($this->session->all_userdata());

		echo 1;

	}

	function claim_zip_step_4(){ 

		$get_zip =(!empty($_REQUEST['zip']))? $_REQUEST['zip'] : "";

		$get_email_address =(!empty($_REQUEST['claim_zip_user_email']))? $_REQUEST['claim_zip_user_email'] : "";

		$get_fname =(!empty($_REQUEST['claim_zip_user_fname']))? $_REQUEST['claim_zip_user_fname'] : "";

		$get_lname =(!empty($_REQUEST['claim_zip_user_lname']))? $_REQUEST['claim_zip_user_lname'] : "";

		//var_dump($get_zip); var_dump($get_email_address); var_dump($get_fname); var_dump($get_lname); exit;

		$this->zips->get_zip_claim_by_user($get_zip,$get_email_address,$get_fname,$get_lname);

		echo 1;

	}

	public function zone_registration_step_2($uid=false){ //anish25

		$data=array();

		$data['refer_code'] = '';

		$data['uid_admin']=$uid;

		$data['uid']='';

		$data['login_from_mail']='';

		$data['userid_for_registration']=$uid;

		$data['users_email']=''; $data['users_fn']=''; $data['users_ln']=''; $data['user_already_exist']=''; $data['type']='';

		//$data['userid_for_registration']=!empty($_REQUEST['uid_admin']) ? $_REQUEST['uid_admin'] : '';

		$users_email=$this->users->get_user_details($uid);

		// + Changed the variable init and added !empty condition on 10.12.2014

		$data['users_email']=(!empty($users_email['email']))? $users_email['email'] : "";

		$data['users_fn']=(!empty($users_email['first_name']))? $users_email['first_name'] : "";

		$data['users_ln']=	(!empty($users_email['last_name']))? $users_email['last_name'] : "";		//$users_email['last_name'];

		$data['username']=	(!empty($users_email['username']))? $users_email['username'] : "";			//$users_email['username'];

		$data['password']=	(!empty($users_email['password']))? $users_email['password'] : "";			//$users_email['password'];

		$data['state_list'] = $this->states->get_state_dropdown();

		$link_path = $this->config->item('link_path');

		if($link_path=='')	

			$data['link_path']="../../";

		else

			$data['link_path']=$link_path;

		$data['content']=$this->load->view("default/show_content_create_user_link",$data,TRUE);

		$this->load->view('default/default_content', $data);

	}	

	public function account_verification($uid=false){		

		$data = array();

		$data['uid_admin']=$uid;

		$data['uid']='';

		$data['login_from_mail']='';

		$data['userid_for_registration']='';

		$data['users_email']=''; $data['users_fn']=''; $data['users_ln']=''; $data['user_already_exist']=''; $data['type']='';

		$data['userid']=$uid;

		$link_path = $this->config->item('link_path');

		if($link_path=='')	

			$data['link_path']="../";

		else

			$data['link_path']=$link_path;

		$data['user_account_verification'] = $this->ion_auth->user_account_verification($uid);		

		//$data['content'] = $this->load->view('default/account_verification', $data, true);

		$data['header']='Account Verification';

		$link=base_url().'welcome/account_updates/zone';

		$data['content']='Your account is successfully verified. <a style="color:#fff;" href="'.$link.'"><strong>Click here</strong></a> to login in SavingsSites.';

        $this->load->view('default/default_content', $data);

	}

	function get_forgot_password($id){  //caling from new_page

		$data=array();

		$data['uid_admin']='';

		$data['uid']='';

		$data['login_from_mail']='';

		$data['userid_for_registration']='';

		

		$data['link_path']= base_url();

	    $data['base_url'] =  base_url();



	    $zoneid = 213;
	    $zone_name = '';
	    $theme = 'old glory';
	    $header  = 'homeheader';
	    $footer  = 'homefooter';


	    return view('get_forgot_password',array('typeid'=> $id,'zoneid'=> $zoneid,'zone_id'=> $zoneid,'zone_name'=> $zone_name,'theme'=> $theme,'header'=> $header,'footer'=> $footer));

		$data['content']=$this->load->view("default/show_content_forgot_password",$data,TRUE);		

        $this->load->view("default/default_content", $data);



	}

	

	/** 

		* Forgot username for resident user

		*

	*/

	function get_forgot_username(){//calling from new_page

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

		$data['content']=$this->load->view("default/show_content_forgot_username",$data,TRUE);		

        $this->load->view("default/default_content", $data);



	}

	// home page content ends

 	

	

	

	

	

	

	

	

	function get_menu(){

		$data=array();

		

		$this->load->view('default/show_menu', $data);

	}

	

	

	

	function get_content(){

		$data=array();

		$this->load->view('default/show_content_home', $data);

	}

	function get_about_us(){ 

		$data=array();

		

		//$this->load->view('default/ss_main_content', $data);

		//$data['content']=$this->load->view('default/show_content_about_us', $data); var_dump($data['content']);

		$this->load->view('default/show_content_about_us', $data);

	}

	

	function get_to_advertise(){

		$data=array();

		$this->load->view('default/show_content_to_advertise', $data);

	}

	function get_ad_changes(){

		$data=array();

		$this->load->view('default/show_content_ad_changes', $data);

	}

	function get_contact_us(){

		$data=array();

		$this->load->view('default/show_content_contact_us', $data);

	}

	

	function get_zone_login(){

		$this->load->library('session');

		$data=array();

		//$type=$_REQUEST['type']; //print_r($type); exit;

		$type=!empty($_REQUEST['type']) ? $_REQUEST['type'] : '';

		$scripts = array ("assets/scripts/new/jquery.jqtransform.js");

		$data['scripts'] = $scripts;

		if($type==2){

			//if($this->session->userdata('zip_claimed_by_user')){

				//$this->session->unset_userdata('session_zip_claimed_by_user');

				//$session_zip_claimed_by_user=''; $data['zip_claimed_by_user']='';				

			//}

			//print_r($this->session->all_userdata());

			$session_zip_claimed_by_user_1=$this->session->userdata('session_zip_claimed_by_user');

			$data['zip_claimed_by_user']=$session_zip_claimed_by_user_1['zip_claimed_by_user'];

			//$this->session->unset_userdata('zip_claimed_by_user');

			//print_r($data['zip_claimed_by_user']); //exit;

		}else if($type==1){

			$data['zip_claimed_by_user']='';

			if($this->session->userdata('zip_claimed_by_user')){

				$this->session->unset_userdata('zip_claimed_by_user');				

			}

			if($this->session->userdata('session_login_from_mail')){

				$login_from_mail_arr=$this->session->userdata('session_login_from_mail');

				$data['login_from_mail']=$login_from_mail_arr['business_login'];		

			}else{

				$data['login_from_mail']='';

			}

			if($this->session->userdata('session_login_from_mail')){

				$this->session->unset_userdata('session_login_from_mail');				

			}

			

		}

		$this->load->view('default/show_content_zone_login', $data);

	}

	function get_claim_zips($uid=0){

		$data=array();

		$data['uid']=$uid;

		if($this->session->userdata('zip_claimed_by_user')){

			$this->session->unset_userdata('zip_claimed_by_user');				

		}

		$this->load->view('default/show_content_claim_zips', $data);

	}

	

	function get_create_user_link(){

		//var_dump($_COOKIE); 

		//var_dump($this->session->all_userdata());

		$this->session->sess_destroy();

		$data=array();

		$type=!empty($_REQUEST['type']) ? $_REQUEST['type'] : '';

		$userid_for_registration=!empty($_REQUEST['uid_admin']) ? $_REQUEST['uid_admin'] : '';

		$data['state_list'] = $this->states->get_state_dropdown();

		//$this->session->unset_userdata('session_zip_claimed_by_user');

		if($type==2){

			/*$session_zip_claimed_by_user=$this->session->userdata('session_zip_claimed_by_user');

			$data['zip_claimed_by_user']=$session_zip_claimed_by_user['zip_claimed_by_user'];*/

			$data['userid_for_registration']=$userid_for_registration;

			$users_email=$this->users->get_user_details($userid_for_registration);

			$data['users_email']=$users_email['email'];

			$data['users_fn']=$users_email['first_name'];

			$data['users_ln']=$users_email['last_name'];

			$data['user_already_exist']=$users_email['username'];

		}else if($type==1){

			$data['userid_for_registration']=''; $data['users_email']=''; $data['users_fn']=''; $data['users_ln']=''; $data['user_already_exist']=''; 

			/*if($this->session->userdata('zip_claimed_by_user')){

				$this->session->unset_userdata('zip_claimed_by_user');				

			}*/

		}

		//var_dump($data);

		$this->load->view('default/show_content_create_user_link', $data);

	}

	function get_navigation_login(){

		$data=array();

		$this->load->view('default/show_navigation_login', $data);

	}

	function business_owner_login(){

		$data=array();

		$this->load->view('default/business_owner_login', $data);

	}

	function get_to_advertise_business(){

		$data=array();

		$this->load->view('default/show_to_advertise_business', $data);

	}	

	function get_contact_us_business(){

		$data=array();

		$this->load->view('default/show_content_contact_us_business', $data);

	}

	function zip_to_zone($zip){

		$zone = $this->zips->zip_to_zone($zip);  
 

		if($zone == -1){

			$_zone_id = -1 ;

		}elseif(!empty($zone)){

			$_zone_id=$zone[0]['id'];
 

		}else{

			$_zone_id=0;		

		}

		echo $_zone_id;

	}

	

	function contact(){

		//echo "123";exit;

		$businessid =(!empty($_REQUEST['businessid']))? $_REQUEST['businessid'] : "";

		$name =(!empty($_REQUEST['name']))? $_REQUEST['name'] : "";

		$email = (!empty($_REQUEST['email']))? $_REQUEST['email'] : "";

		$phone =(!empty($_REQUEST['phone']))? $_REQUEST['phone'] : "";

		$subject = (!empty($_REQUEST['subject']))? str_replace('_',' ',$_REQUEST['subject']) : "";

		$message =(!empty($_REQUEST['message']))? $_REQUEST['message'] : "";
 
		$message_body="<div style='border:1px solid #900; padding:5px;'>Dear Administrator,<br /><br />
 
		My Contact Information is as bellows: <br/><br/>

		Name:".$name." <br/><br/>

		Email:".$email." <br/><br/>

		Phone:".$phone." <br/><br/>

		Subject:".$subject." <br/><br/>

		Message:".$message." <br/><br/>";

		

		$fromemail=$email;

		//$admin_mail='ajdmm@optonline.net';

		$businessdetails=$this->users->get_zone_by_business($businessid);

		echo "<pre>";

		print_r($businessdetails);

		echo "</pre>";

		$admin_mail=$businessdetails[0]['email'];

		$this->load->library('email');

		$template_subject="Contact Details";

		$this->email->clear();

		$this->email->from($fromemail);

		$this->email->subject($template_subject);

		$this->email->message($message_body);

		if($email!='')

		{

			$this->email->to($admin_mail);

			$this->email->send();

			$to[]=$admin_mail;

			echo 1;

		}

		else 

			echo 0;

	  //echo 1;

	}

	

	function forgot_password(){ 

		$name =(!empty($_REQUEST['name']))? $_REQUEST['name'] : ""; //var_dump($name);

		$usertype =(!empty($_REQUEST['usertype']))? $_REQUEST['usertype'] : "";

		$forgotten = $this->ion_auth->forgotten_password($name,$usertype); 
	 

		if (is_bool($forgotten) ){

			$message = '<div class="succ_messs_form">Thank you for submitting your reset request. A reset code should be emailed to the email address you registered under.</div>';

		}else{

			$message='<div class="error_messs_form">Sorry! Unable to get your request. Please Try again later.</div>';

		}

		echo $message;

	}

	

	

### new part end ##########################################################

// Claim Zip Part Start

public function claim_zips(){

	$data = array();

	$data['class']="claim_zips";

	$data['zone_owner_new'] = array();

	if ($this->ion_auth->logged_in()){	

		$auser = $this->ion_auth->user()->row();

		$data['user'] = $auser;

		if(!empty($auser)){

			$data["email"] = $auser->email;

			$data["firstName"] = $auser->first_name;

			$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";			

			$uid = $auser->id;

			$data['uid']=$uid;

			$data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

			$data['business_owner_new'] = $this->business->business_owner_user($uid);

		}

	}else{

		redirect(base_url(),'refresh');

	}

	//var_dump($uid);

	$data['where_from']='';

	//$data['content'] = $this->load->view('default/claim_zips', $data, true);

	$data['content'] = $this->load->view('default/show_content_claim_zips', $data, true);

	$this->load->view('default/blank', $data);

	/*$data=array();

	$data['content'] = $this->load->view('default/show_content_claim_zips', $data, true);

	$this->load->view('default/blank', $data);*/

	//$this->load->view('default/show_content_claim_zips', $data);

}

### old part #############

    public function send_contact(){ //exit;

	//var_dump($_POST); exit;

	

        $data = array();

        $data['class']="contact";

        $data['zone_owner_new'] = array();

        if ($this->ion_auth->logged_in())

        {

            $auser = $this->ion_auth->user()->row();

            $data['user'] = $auser;

            if(!empty($auser)){

                $data["email"] = $auser->email;

                $data["firstName"] = $auser->first_name;

                $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

                

                $uid = $auser->id;

                $data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

                $data['business_owner_new'] = $this->business->business_owner_user($uid);

            }

        }else{

			$data['user']='';

			$data["email"]='';

			$data["admin"]='';

			$data['zone_owner_new']='';

			$data['business_owner_new']='';

		}

        if(isset($_POST['sendemail']))

        {//

            //var_dump($_POST); exit;

		   

		    extract($_POST);

            $headers = "From: \"Savings Sites Website\"<savings@savingssites.com>\r\n";

            $headers .= 'MIME-Version: 1.0' . "\r\n";

            $headers .= 'X-Mailer: PHP/' . phpversion()." \r\n";

            

            

            if(filter_var($email, FILTER_VALIDATE_EMAIL))

            {

                $headers .="Reply-To: \"$name\"<$email> \r\n";

                $confirm = 1;

            }

            else

                $headers .="Reply-To:  \"No Reply\"<a@a.com> \r\n";



            

            if($zone_owner!='')

            {

            	//$headers .= "Cc: ajdmm@optonline.net \r\n";

				$headers .= "Cc: anish.sett@gmail.com \r\n";

            	

            	if($zone_owner==01){ 

					$sql="select t1.email from users where id=154"; 

				}else{

					$sql="select t1.email from users as t1 join sales_zone as t2 on t2.sales_rep_id = t1.id where t2.id=$zone_owner"; 

				}

				$query=$this->db->query($sql);

            	 

            	if($query->row())

            	{

            		$row = $query->row();

            		if($subject=="Website")

            			$to = "Savings Sites Webmaster <".$row->email.">";

            		else

            			$to = "Savings Sites Owner <".$row->email.">";

            	}

            }

            else

            {

            	if($subject=="Website")

            		$to = "Savings Sites Webmaster <ajdmm@optonline.net>";

            	else

            		$to = "Savings Sites Owner <ajdmm@optonline.net>";

            }

            

            

            $body = date("l, m/d/Y h:i  A")."\nE-Mail from Savings Sites Website: \n\tName: $name \n\t Email: $email \n\t Phone: $phone \n\t Message:\n\t $messageBody";

            $data['mtest'] = mail($to, $subject, $body, $headers);

        }

        $data['content'] = $this->load->view('default/successful_contact', $data, true);

        $this->load->view('default/blank', $data);



    }

    private function check_login_status($return_page)

    {

    	if (!$this->ion_auth->logged_in())

    	{

    		//redirect them to the login page

    		$this->session->set_userdata('return_page', $return_page);

    		redirect('auth/login', 'refresh');

    	}

    }

    public function contact_old($zoneid=false){

    	

    	//var_dump(1); //exit;

		//$this->check_login_status("welcome/contact/");

		//var_dump(2);

    	$user = $this->ion_auth->user();

    	/*if (empty($user)) {

    		redirect('welcome/index', 'refresh');

    	}*/

    	//var_dump(3);

        $data = array();

        $data['class']="contact";

        $data['zone_owner_new'] = array();

        if ($this->ion_auth->logged_in())

        {

            $auser = $this->ion_auth->user()->row();

            $data['user'] = $auser;

            if(!empty($auser)){

                $data["email"] = $auser->email;

                $data["firstName"] = $auser->first_name;

				$data["lastName"] = $auser->last_name;

				$data['full_name']=$auser->last_name.', '.$auser->first_name;

				$data["phone"] = $auser->phone;

                $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

                

                $uid = $auser->id;

                $data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

                $data['business_owner_new'] = $this->business->business_owner_user($uid);

                if($zoneid!=''){

					$data['zid']=$zoneid;

				}

				//var_dump($data['zid']);

                if(!empty($data['zone_owner_new']))

                {

                	$data['zone_owner_user'] = $this->business->zone_owner_user($uid);

                }

            }

        }

		else{

				$data['user']='';

				$data["email"]='';

				$data["firstName"]='';

				$data["lastName"]='';

				$data['full_name']='';

				$data["phone"] ='';

				$data["admin"]='';

				$data['zone_owner_new']='';

				$data['business_owner_new']='';

				$data['zone_owner_user']='';

				$data['zid']='';

			}

       // var_dump($data["email"]);

        $data['all_zone'] = $this->business->get_zone_all();

        

        $data['content'] = $this->load->view('default/contact', $data, true);

        $this->load->view('default/blank', $data);

    }

	

	public function account_verification_user($uid=false,$bsid=false){

		$data = array();

		$data['userid']=$uid;

		$data['bsid']=$bsid;

		$newdata = array('status' => 1);

        $this->db->where('id', $uid);

        $this->db->update('users', $newdata);

		

		

		//$data['user_account_verification'] = $this->ion_auth->user_account_verification($uid);

		$data['content'] = $this->load->view('default/account_verification_from_buser', $data, true);

        $this->load->view('default/blank', $data);

	}

	public function business_verification_user($id=false){ //30.01.13

		$data['isverified']=1;

		$this->db->where('id', $id);

		$this->db->update('business', $data);

		$data['content'] = $this->load->view('default/zone_login', $data, true);

        $this->load->view('default/blank', $data);

	}

	

    public function zone_login(){

        $data = array();

        $data['hideSlider'] = true;

        $data['class']="login";



        if ($this->ion_auth->logged_in())

        {

            $auser = $this->ion_auth->user()->row();

            $data['user'] = $auser;

            if(!empty($auser)){

                $data["email"] = $auser->email;

                $data["firstName"] = $auser->first_name;

                $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

                

                $uid = $auser->id;

                $data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

                $data['business_owner_new'] = $this->business->business_owner_user($uid);

            }

        }

        $data['content'] = $this->load->view('default/zone_login', $data, true);

        $this->load->view('default/blank', $data);

    }

    function forgot_password_final_before_design()

    {

        $data = array();

        $this->form_validation->set_rules('identity', 'User Name', 'required');

        if ($this->form_validation->run() == false)

        {

            //setup the input

            $this->data['identity'] = array('name' => 'identity',

                'id' => 'identity',

            );

            //set any errors and display the form

            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['hideSlider'] = true;

            $data['content'] = $this->load->view('default/forgot_password', $this->data, true);

            $this->load->view('default/blank', $data);

        }

        else

        {

            //run the forgotten password method to email an activation code to the user

            $forgotten = $this->ion_auth->forgotten_password($this->input->post('identity'));



            if ($forgotten)

            { //if there were no errors

                $this->session->set_flashdata('message', $this->ion_auth->messages());

                $this->data['hideSlider'] = true;

                $data['content'] = $this->load->view('default/thank_you', $this->data, true);

                $this->load->view('default/blank', $data);

            }

            else

            {

                $this->session->set_flashdata('message', $this->ion_auth->errors());

                redirect("welcome/forgot_password", 'refresh');

            }

        }

    }

	public function directory_owners(){

		$data = array();

		$data['content'] = $this->load->view('default/directory_owners', $data, true);

        $this->load->view('default/blank', $data);

	}

	public function business_presentation(){

		$data = array();

		$data['where_from']='';

		$data['content'] = $this->load->view('default/business_presentation', $data, true);

        $this->load->view('default/blank', $data);

	}

	public function compare_advertising(){

		$data = array();

		$data['content'] = $this->load->view('default/compare_advertising', $data, true);

        $this->load->view('default/blank', $data);

	}

    

    public function marketing(){

        $data = array();

        $data['class']="marketing";

        $data['zone_owner_new'] = array();

        if ($this->ion_auth->logged_in())

        {

            $auser = $this->ion_auth->user()->row();

            $data['user'] = $auser;

            if(!empty($auser)){

                $data["email"] = $auser->email;

                $data["firstName"] = $auser->first_name;

                $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

                $uid = $auser->id;

                $data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

                $data['business_owner_new'] = $this->business->business_owner_user($uid);

            }

        }

        $data['content'] = $this->load->view('default/marketing', $data, true);

        $this->load->view('default/blank', $data);

    }

    public function claimzips(){

		

        $data = array();

		$data['where_from']='';

        $data['class']="claim_zips";

        $data['zone_owner_new'] = array();

        

        if ($this->ion_auth->logged_in())

        {

            $auser = $this->ion_auth->user()->row();

            $data['user'] = $auser;

            if(!empty($auser)){

                $data["email"] = $auser->email;

                $data["firstName"] = $auser->first_name;

                $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

                

                $uid = $auser->id;

                $data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

                $data['business_owner_new'] = $this->business->business_owner_user($uid);

            }

        }



        $data['zips'] = $this->zips->get_full_zip_list($this->input->post('txtZip'));

		//var_dump($data['zips']);

        $data['checkbox'] = "Claim";

        $data['approve_status'] = "Approval Status";

        $data['content'] =  $this->load->view("claimzips/claimtop", $data, true);

        $data['content'] .= $this->load->view("claimzips/zipdata", $data, true);

        $data['content'] .= $this->load->view("claimzips/claimmiddle", $data, true);

        $data['checkbox'] = 0;

        $data['claim_status'] = 0;

        $data['zips'] = $this->zips->get_full_zip_list($this->input->post('txtZip'), $this->ion_auth->user()->row()->id);

		//var_dump($data['zips']);

        $data['content'] .= $this->load->view("claimzips/zipdata", $data,true);

        $data['content'] .= $this->load->view("claimzips/claimbottom", $data, true);

        $this->load->view('default/blank', $data);

    }

   

    public function new_index(){ //exit;

        $data = array();

        $data['class']="home";

        $data['zone_owner_new'] = array();

        

        if ($this->ion_auth->logged_in())

        {

           $auser = $this->ion_auth->user()->row();

            $data['user'] = $auser;

            if(!empty($auser)){

                $data["email"] = $auser->email;

                $data["firstName"] = $auser->first_name;

                $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

                $uid = $auser->id;

                $data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

                $data['business_owner_new'] = $this->business->business_owner_user($uid);

            }

        }

        //$data['content'] = $this->load->view('default/index', $data, true);

        $this->load->view('default/header', $data);

    }

	

	

	

   

	

	/*function get_announcements_by_ogr(){

		$orgid=$_REQUEST['orgid'];

		$data['org_announcement_list'] = $this->announcements->get_org_announcements_for_zonepage($orgid);

		//var_dump($data['org_announcement_list']);

		$result = $this->load->view('dashboards/announcement_parts/org_announcement', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}*/

	

	

    public function oldindex($zone=false)

    {

        $zoneId = empty($_REQUEST['zone']) ? 99 : $_REQUEST['zone'];

        if(!empty($zone)) { $zoneId = $zone;}

        

        $data = array();

        $data['category_list'] = $this->category->get_category_subcategory($zoneId);

		

        //$data['announcement_list'] = $this->announcements->get_announcements_for_zone($zoneId);

        $data['zone'] = $this->sales_zone->get_zone($zoneId);

        $data["firstName"] = "";



        $data["email"] = "";



        $data['zone_id'] = $zoneId;



        $data["admin"] = "";



            



        if ($this->ion_auth->logged_in())



        {



            $auser = $this->ion_auth->user()->row();



            if(!empty($auser)){



                $data["email"] = $auser->email; 



                $data["firstName"] = $auser->first_name;



                $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";



            }



        }

        $this->load->view('mail_page', $data);

    }



    public function testmail()

    {

        $this->load->library('email');







        $this->email->from('savings@savingssites.com', 'Savings Sites Website');



        $this->email->to('turnbullindustries@gmail.com');







        $this->email->subject('Email Test');



        $this->email->message('Testing the <b>email</b> class.');







        $this->email->send();







        echo $this->email->print_debugger();

    }

	

	/*20-09-2012*/

	 function cancel_email_notice($zone)

    {

    	if(isset($_POST['user_id']) && $_POST['user_id'])

    	{

    		$status=$_POST['status'];

    		$user_id=$_POST['user_id'];

    		

    		$query = $this->db->query("select * from user_paypal where user_id=".$user_id."");

    		$complete_user=$query->row();

    		

    		if($complete_user->success!='completed')

    		{

				$data=array("cancel" => $status,"success"=>"completed");

				$this->db->where('user_id', $user_id);

				$this->db->update('user_paypal', $data);

				

    			/*$sql_paypal="select * from paypal_configuration LIMIT 1";

				$query_paypal=$this->db->query($sql_paypal);

				$paypal = $query_paypal->row();



				$posturl=$paypal->paypal_url;

				$business_email=$paypal->business_email;*/

				?>

<!--

				<form name="frm_payment_method" id="frm_payment_method" action="<?php echo $posturl;?>" method="post">

				    <input type="hidden" name="cmd" value="_xclick-subscriptions">

				    <input type="hidden" name="custom" value="<?php echo $user_id; ?>">

				    <input type="hidden" name="business" value="<?php echo $business_email?>">

				    <input type="hidden" name="return" value="<?php echo base_url();?>welcome/paypal_success/<?php echo $zone;?>">

				    <input type="hidden" name="cancel_return" value="<?php echo base_url();?>welcome/paypal_cancel/<?php echo $zone;?>">

				    <input type="hidden" name="notify_url" value="<?php echo base_url();?>welcome/paypal_ipn/<?php echo $zone;?>">

				    <input type="hidden" name="currency_code" value="USD">

				    <input type="hidden" name="no_shipping" value="1">

				    <input type="hidden" name="rm" value="2">

				    <input type="hidden" value="subscription" name="item_name"/>

				    <input type="hidden" name="item_number" value="<?php echo $zone;?>">

				    <input type="hidden" name="a3" value="12">

				    <input type="hidden" name="p3" value="1">

				    <input type="hidden" name="t3" value="M">

				    <input type="hidden" name="src" value="1">

				    <input type="hidden" name="sra" value="1">

				</form>

				<script type="text/javascript">

					document.getElementById('frm_payment_method').submit();

				</script>-->

<?php //exit;

    		}else{

				$data=array("cancel" => $status,"success"=>"cancel");

				$this->db->where('user_id', $user_id);

				$this->db->update('user_paypal', $data);

			}

    		

    		if($status)

    		{?>



<a href="#" onclick='cancel_email_notice("<?=$user_id?>","0");return false;'>Join Now</a> ####

<div class="for-top-title1">

  <div class="cancel-notice-title">Subscription Cancel</div>

  <div class="cancel-notice-desc">Your subscription has canceled, please cancel your transaction in your paypal account</div>

</div>

<?php

    		}else{?>

<a href="#" onclick='cancel_email_notice("<?=$user_id?>","1");return false;'>Cancel Now</a>

<?php

    		}

    		exit;

    	}

    	exit;

    }

    

    

    function search_businesses($zone,$id,$user_id)

    {

    	$data['user_id']=$user_id;

    	$data['zone']=$zone;

    	$data['business'] = $this->business->get_all_businesses_business_type($zone,$id);

    	

    	$data['approved_bus'] = $this->business->get_all_businesses_approved_business_type($zone,$id,$user_id);

    	

    	$query = $this->db->query("select t1.*,t2.success,t2.cancel from users as t1 left join user_paypal as t2 on t2.user_id=t1.id where t1.id=".$user_id."");

    	$data['complete_user']=$query->row();

    	

    	$this->load->view('profile_approve', $data);

    }

    

    function profile_approve($status=0)

    {

    	//var_dump(1);

		$bus_id='';

    	$user_id='';

    	$zone='';

    	

    	if(isset($_POST['bus_id']) && $_POST['bus_id']!='' && isset($_POST['user_id']) && $_POST['user_id'])

    	{

    		$bus_id=$_POST['bus_id'];

    		$user_id=$_POST['user_id'];

    	}

    	

    	$zone=$_POST['zone'];

    	//var_dump($bus_id);

    	$this->ad->business_approved($bus_id, $user_id, $status, $zone);

    	

    	$data['user_id']=$user_id;

    	$data['zone']=$zone;

		//$data['business_all'] = $this->business->get_all_businesses_zone($zone,$user_id);

		//$data['approved_bus'] = $this->business->get_all_businesses_approved($zone,$user_id);

		$this->load->view('profile_approve', $data);

    }

    

    function snap_profile($zone = false){

    	//var_dump($zone);

		//$zone=14;

		if (!$this->ion_auth->logged_in())

        {

            //redirect them to the login page

            redirect('auth/login' . (!empty($zone) ? "/".$zone : ""), 'refresh');

        }

       $zoneId=$zone;

	   

		 $data = array();

		if ($this->ion_auth->logged_in())

        {

        	$auser = $this->ion_auth->user()->row(); 

        	if(!empty($auser)){

        		$data["user_id"] = $auser->user_id;

        		$data["email"] = $auser->email;

        		$data["firstName"] = $auser->first_name;

        		$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

        		$data["admin_tier"] = $this->ion_auth->in_group(array( "accept_email_notice" )) ? "yes" : "";

        		$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";

        		

				

				/*$allzones_arr=$this->sales_zone->get_all_zone_for_snap_user($auser->user_id); 

				$zoneId=$allzones_arr[0]['zoneid']; */

        		//$data['business_all'] = $this->business->get_all_businesses_zone($zoneId,$auser->user_id);

        		$data['approved_bus'] = $this->business->get_all_businesses_approved($zoneId,$auser->user_id);

				

        		

        		$query = $this->db->query("select t1.*,t2.success,t2.cancel from users as t1 left join user_paypal as t2 on t2.user_id=t1.id where t1.id=".$auser->user_id."");

        		$data['complete_user']=$query->row();

        	}

        }

		

		

		$data['all_zone']=$this->sales_zone->get_all_zones();

		$data['displayoffer'] = $this->ad->get_display_offer_in_zonepage($zoneId); 

		

        	$data['announcement_list'] = $this->announcements->get_announcements_for_zonepage($zoneId);

			

			$data['zone_pref_setting']=$this->sales_zone->get_default_settings_in_zone($zoneId);

			

        $data['zone'] = $this->sales_zone->get_zone($zoneId);

        $data["firstName"] = "";



        $data['zone_id'] = $zoneId;

        $data["email"] = "";

        $data["admin"] = "";

        $data["user_id"] = "";

		

		

		

		

		

        if ($this->ion_auth->logged_in())

        {

            $auser = $this->ion_auth->user()->row();



            if(!empty($auser)){ 

				$data["user_id"] = $auser->user_id;

                $data["email"] = $auser->email; 



                $data["firstName"] = $auser->first_name;

                $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

				$data["user_id"] = $auser->id;

				$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";

            }

        }

		

		

		

		$data['barter_button']='red'; $data['job_button']='red';

		

		$newsessiondata = array('usergrid'=>$data["user_id"],'userzoneid'=>$zoneId);        

		$this->session->set_userdata('usersessiondata',$newsessiondata);   // assign session for logout redirection

		

        $this->load->view('snap_profile', $data);



    }

    

	function welcome_profile($user_id=false){

		echo $user_id;exit;

	}

	

    function paypal_ipn($zone = false)

    {

    	$fp_log = fopen("./log_paypal_sandbox.txt", 'a');

		fwrite($fp_log,"\r\nhello ".date('Y-m-d H:i:s')."\r\n");

		fwrite($fp_log,"start here\r\n");

		fwrite($fp_log,"*****************************************************************\r\n");

		  //reading raw POST data from input stream. reading pot data from $_POST may cause serialization issues since POST data may contain arrays

		  $raw_post_data = file_get_contents('php://input');

		  

		  $raw_post_array = explode('&', $raw_post_data);

		  

		  foreach($raw_post_array as $key1=>$value1)

			{

				fwrite($fp_log,"\r\n response ".$key1.' => '.$value1."\r\n");

			}

		  

		  $myPost = array();

		  foreach ($raw_post_array as $keyval)

		  {

		      $keyval = explode ('=', $keyval);

		      if (count($keyval) == 2)

		         $myPost[$keyval[0]] = urldecode($keyval[1]);

		  }

		  // read the post from PayPal system and add 'cmd'

		  $req = 'cmd=_notify-validate';

		  if(function_exists('get_magic_quotes_gpc'))

		  {

		       $get_magic_quotes_exits = true;

		  } 

		  foreach ($myPost as $key => $value)

		  {        

		       if($get_magic_quotes_exits == true && get_magic_quotes_gpc() == 1)

		       { 

		            $value = urlencode(stripslashes($value)); 

		       }

		       else

		       {

		            $value = urlencode($value);

		       }

		       $req .= "&$key=$value";

		  }

		 

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://www.sandbox.paypal.com/cgi-bin/webscr');

		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www.sandbox.paypal.com'));

		$res = curl_exec($ch);

		curl_close($ch);

		 

		if (strcmp ($res, "VERIFIED") == 0) {

					

					fwrite($fp_log,"\r\nhello ".date('Y-m-d H:i:s')."\r\n");

					fwrite($fp_log,"VERIFIED\r\n");

					fwrite($fp_log,"*****************************************************************\r\n");

					

					$user_id = $myPost['custom'];

					$bus_id = $myPost['item_name'];

					$txn_id = $myPost['txn_id'];

					$payment_status       = strtolower($myPost['payment_status']);

					$payment_type         = $myPost['payment_type'];

					$payment_date         = $myPost['payment_date'];

					$txn_type             = strtolower($myPost['txn_type']);

					

					fwrite($fp_log,"\r\ntransaction type => ".$txn_type."\r\n");

					fwrite($fp_log,"*****************************************************************\r\n");

		

					$txn_type             = strtolower($_POST['txn_type']);

					

					fwrite($fp_log,"\r\ntransaction type => ".$txn_type."\r\n");

					fwrite($fp_log,"*****************************************************************\r\n");

					

					

					switch($txn_type){

						case 'subscr_signup':

								fwrite($fp_log,"\r\nhello ".date('Y-m-d H:i:s')."\r\n");

								fwrite($fp_log,"subscr_signup\r\n");

								fwrite($fp_log,"*****************************************************************\r\n");

								

							break;

						case 'subscr_cancel':

								fwrite($fp_log,"\r\nhello ".date('Y-m-d H:i:s')."\r\n");

								fwrite($fp_log,"subscr_cancel\r\n");

								fwrite($fp_log,"*****************************************************************\r\n");

								$status=$payment_status;

								$this->business->upadte_user_paypal($user_id,$status);

							break;

						case 'subscr_failed':

							

								fwrite($fp_log,"\r\nhello ".date('Y-m-d H:i:s')."\r\n");

								fwrite($fp_log,"subscr_failed\r\n");

								fwrite($fp_log,"*****************************************************************\r\n");

								$status=$payment_status;

								$this->business->upadte_user_paypal($userid,$status);

							break;

						case 'subscr_eot':

							

								fwrite($fp_log,"\r\nhello ".date('Y-m-d H:i:s')."\r\n");

								fwrite($fp_log,"subscr_eot\r\n");

								fwrite($fp_log,"*****************************************************************\r\n");

								$status=$payment_status;

								$this->business->upadte_user_paypal($user_id,$status);

							break;

						case 'subscr_payment':

							

							fwrite($fp_log,"\r\nhello ".date('Y-m-d H:i:s')."\r\n");

							fwrite($fp_log,"subscr_payment\r\n");

							fwrite($fp_log,"*****************************************************************\r\n");

							

							if($payment_status=='completed'){

								

								fwrite($fp_log,"\r\nhello ".date('Y-m-d H:i:s')."\r\n");

								fwrite($fp_log,"completed\r\n");

								fwrite($fp_log,"*****************************************************************\r\n");

								

								$status=$payment_status;

								$this->business->upadte_user_paypal($user_id,$status);

							}

							break;

						case 'subscr_modify':

							

								fwrite($fp_log,"\r\nhello ".date('Y-m-d H:i:s')."\r\n");

								fwrite($fp_log,"subscr_modify\r\n");

								fwrite($fp_log,"*****************************************************************\r\n");

							break;

						default:

							break;

					}	

		}

		else if (strcmp ($res, "INVALID") == 0) {

			fwrite($fp_log,"\r\ninvalid\r\n");

			fwrite($fp_log,"*****************************************************************\r\n");

								

		}

		fclose($fp_log);

    }

    

    function paypal_success($zone = false)

    {

    	$zoneId = empty($_REQUEST['item_number']) ? 0 : $_REQUEST['item_number'];

    	

    	$data = array();

    	

    	

    	if(!empty($zone))

    	{

    		$zoneId = $zone;

    	}

    	if(empty($zoneId))

    	{

    		$data['class']="home";

    		$data['zone_owner_new'] = array();

    		if ($this->ion_auth->logged_in())

    		{

    			$auser = $this->ion_auth->user()->row();

    			$data['user'] = $auser;

    			if(!empty($auser)){

    				$data["email"] = $auser->email;

    				$data["firstName"] = $auser->first_name;

    				$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

    				

    				$uid = $auser->id;

    				$data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

    				$data['business_owner_new'] = $this->business->business_owner_user($uid);

    			}

    		}

    		$data['content'] = $this->load->view('default/index', $data, true);

    		$this->load->view('default/blank', $data);

    		return;

    	}

    	$data['category_list'] = $this->category->get_category_subcategory($zoneId);

    	//$data['announcement_list'] = $this->announcements->get_announcements_for_zone($zoneId);

    	$data['zone'] = $this->sales_zone->get_zone($zoneId);

    	$data["firstName"] = "";

    

    	$data['zone_id'] = $zoneId;

    

    	$data["email"] = "";

    

    	$data["admin"] = "";

    

    	$data["user_id"] = "";

    

    	if ($this->ion_auth->logged_in())

    

    	{

    

    		$auser = $this->ion_auth->user()->row();

    

    		if(!empty($auser)){

    			$data["user_id"] = $auser->user_id;

    			$data["email"] = $auser->email;

    

    			$data["firstName"] = $auser->first_name;

    

    			$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

    

    			$data["user_id"] = $auser->id;

    			$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";

    

    		}

    

    	}

    	$this->load->view('success', $data);

    }

    

    function paypal_cancel($zone = false)

    {

    	$zoneId = empty($_REQUEST['zone']) ? 0 : $_REQUEST['zone'];

    	

    	$data = array();

    	if(!empty($zone))

    	{

    		$zoneId = $zone;

    	}

    	if(empty($zoneId))

    	{

    		$data['class']="home";

    		$data['zone_owner_new'] = array();

    		if ($this->ion_auth->logged_in())

    		{

    			$auser = $this->ion_auth->user()->row();

    			$data['user'] = $auser;

    			if(!empty($auser)){

    				$data["email"] = $auser->email;

    				$data["firstName"] = $auser->first_name;

    				$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

    				

    				$uid = $auser->id;

    				$data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

    				$data['business_owner_new'] = $this->business->business_owner_user($uid);

    			}

    		}

    		$data['content'] = $this->load->view('default/index', $data, true);

    		$this->load->view('default/blank', $data);

    		return;

    	}

    	$data['category_list'] = $this->category->get_category_subcategory($zoneId);

    	//$data['announcement_list'] = $this->announcements->get_announcements_for_zone($zoneId);

    	$data['zone'] = $this->sales_zone->get_zone($zoneId);

    	$data["firstName"] = "";

    	

    	$data['zone_id'] = $zoneId;

    	

    	$data["email"] = "";

    	

    	$data["admin"] = "";

    	

    	$data["user_id"] = "";

    	

    	if ($this->ion_auth->logged_in())

    	

    	{

    	

    		$auser = $this->ion_auth->user()->row();

    	

    		if(!empty($auser)){

    			$data["user_id"] = $auser->user_id;

    			$data["email"] = $auser->email;

    	

    			$data["firstName"] = $auser->first_name;

    	

    			$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

    	

    			$data["user_id"] = $auser->id;

    			$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";

    	

    		}

    	}

    	$this->load->view('cancel', $data);

    }

    

    function login($submit=0,$share=0)//calling from new_page

    {

		isset($_REQUEST['login']) && $_REQUEST['login']==3 ? $submit=3 : $submit;

		isset($_REQUEST['type']) && !empty($_REQUEST['type']) ? $type=$_REQUEST['type'] : $type='';

		//echo $submit; exit;

		//echo '<pre>'; print_r($_REQUEST); exit;

		//echo $_POST['login'];exit;

    	//$submit; echo $share; exit;

		$identity='';

    	$password='';

    	$zone='';

    	$ad_id='';

    	$data=array();

    	$zone=(!empty($_REQUEST['zone']))? $_REQUEST['zone']:'';

    	$ad_id=(!empty($_POST['ad_id'])) ? $_POST['ad_id'] : ''; 

    	$bus_id=(!empty($_REQUEST['bus_id']))? $_REQUEST['bus_id'] :'';

    	

    	$data['login']='';

    	$data['zone']=$zone;

    	$data['ad_id']=$ad_id;

    	$data['bus_id']=$bus_id;

    	$data['state_list'] = $this->states->get_state_dropdown();

		//var_dump($data);

    	$chk_status=true;

		

    	if($submit)

    	{

    		//var_dump($_POST['login']); exit;

			if(isset($_REQUEST['login']) && $_REQUEST['login']=='1')

    		{

    			//var_dump(1); exit; 

				$data['login']='login';

    			$identity=$_REQUEST['identity'];

    			$password=$_REQUEST['password']; //var_dump($identity); var_dump($password);

    			if ($this->ion_auth->login($identity, $password, ''))

    			{ //var_dump(2); exit;

    				

					if (!$this->ion_auth->logged_in())

			        {

	    				//var_dump(4);exit;

						$data['error']='yes';

	    				$this->load->view('approved_login', $data);

				 	}

			        

			        	$auser = $this->ion_auth->user()->row();

			        	//var_dump(3);

			        	if(!empty($auser)){ //var_dump($auser);

			        		$user_id = $auser->id;

			        		$data["user_id"] = $auser->user_id;

							if($auser->first_name!=''){

			        		$data["firstName"] = $auser->first_name;

							}else{

								$data["firstName"] = $auser->username;

							}

							//var_dump($data["firstName"]); exit;

			        		$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";

			        		$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

			        		

			        		/*$sql_address="select * from business_approved where business_id = $bus_id and user_id = $user_id";

			        		$query_address=$this->db->query($sql_address);

			        		$approved = $query_address->row();

							//var_dump($approved); 

			        		if(!empty($approved))

			        		{

				        		if($approved->approved==0)

				        		{

				        			$this->ad->business_approved($bus_id, $user_id, 1);

				        		}else{

				        			$data['approved']='yes';

				        		}

			        		}else

			        		{

			        			$this->ad->business_approved($bus_id, $user_id, 1);

			        		}*/

							//var_dump(5); //exit;

			        		//$data['adlist'] = $this->ad->get_ads_for_all($zoneId); commented by koushik chhetri

							$data['adlist'] = $this->ad->get_ads_for_all_athena($zone,0,5);

							//var_dump($data['adlist']);exit;

							//$data['from_adspage'] = 1;

						

							$data['zone'] = $zone;

							//$data["user_id"] = "";

							/*$data["user_favorites_ads_ids"] = array();

						

							if ($this->ion_auth->logged_in())

							{

								$auser = $this->ion_auth->user()->row();

								if(!empty($auser) && $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III"))){

									$data["user_favorites_ads_ids"] = $this->ad->get_favorites_ads_ids($auser->id, 'array');

									$data["user_id"] = $auser->id;

								}

								$data["user_id"] = $auser->id;

							}*/

							//var_dump($data); exit;

							

							$this->load->view('new_page_offer', $data);



			        		/*$data['zone'] = $zone;

							var_dump($data['adlist']);

							//redirect("dashboards/zone/$zone", 'refresh');

							//redirect('welcome/index', 'refresh');

			        		$this->load->view('new_page_offer', $data);*/

			        	}

			        

    			}

    			else

    			{

    				//var_dump(3); exit;

					$data['error']='yes';

    				$this->load->view('approved_login', $data);

    			}

    		}

    		elseif(isset($_REQUEST['login']) && $_REQUEST['login']=='2')

    		{ //var_dump(3); //exit; // new registration

    			$data['login']='register';

    			if(isset($_REQUEST['Username']) && $_REQUEST['Username']=='')

    			{

    				$chk_status=false;

    				$data['Username']='Please enter a username';

    			}

    			if(isset($_REQUEST['new_password']) && $_REQUEST['new_password']=='')

    			{

    				$chk_status=false;

    				$data['new_password']='Please enter a username';

    			}

    			elseif(isset($_REQUEST['new_password']) && isset($_REQUEST['password_confirm']) && $_REQUEST['new_password']!=$_REQUEST['password_confirm'])

    			{

    				$chk_status=false;

    				$data['password_confirm']='Password not matched';

    			}

    			

    			if(isset($_REQUEST['Email']) && $_REQUEST['Email']!='')

    			{

    				if($this->emailvalidation($_REQUEST['Email'])==false)

    				{

    					$chk_status=false;

    					$data['Email']="Please insert valid email address";

    				}

    			}

    			else

    			{

    				$chk_status=false;

    				$data['Email']='Please enter a email';

    			}

    			

    			

    			if($chk_status)

    			{ //var_dump(4); //exit;

					$data['login']='login';

					$identity=$_REQUEST['Username'];

					$password=$_REQUEST['new_password'];

					$new=$this->ion_auth->login($identity, $password, '');

					//var_dump($new);

					if ($this->ion_auth->login($identity, $password, ''))

					{ //var_dump(5);

						if (!$this->ion_auth->logged_in())

						{

							//var_dump(7); 

							$data['error']='yes';

							$this->load->view('approved_login', $data);

						}

						

							$auser = $this->ion_auth->user()->row(); //var_dump($auser);

							//var_dump(7); //exit;

							if(!empty($auser)){ //var_dump($auser);

								$user_id = $auser->id;

								$data["user_id"] = $auser->user_id;

								$data["firstName"] = $auser->first_name;

								$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";

								$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

								

								$sql_address="select * from business_approved where business_id = $bus_id and user_id = $user_id";

								$query_address=$this->db->query($sql_address);

								$approved = $query_address->row();

								if(!empty($approved))

								{

									if($approved->approved==0)

									{

										$this->ad->business_approved($bus_id, $user_id, 1);

									}else{

										$data['approved']='yes';

									}

								}else

								{

									$this->ad->business_approved($bus_id, $user_id, 1);

								}

	

								if($share)

								{

									$data['adlist'] = $this->ad->get_ads_from_id($ad_id, $zone);

								}

								else

								{

									$sql_add="select category_id from ads where id = $ad_id";

									$query_add=$this->db->query($sql_add);

									$catId = $query_add->row()->category_id;

									$data['adlist'] = $this->ad->get_ads_for_category($catId, $zone);

								}

								$data["user_favorites_ads_ids"] = $this->ad->get_favorites_ads_ids($user_id, 'array');

	

								$data['zone'] = $zone;

								$this->load->view('adlist', $data);

							}

						

					}

					else

					{

						//var_dump(5);

						//$data['error']='yes';

						//$this->load->view('approved_login', $data);

					}

					//var_dump($zone); exit;

					

    				$email = $_REQUEST['Email'];

    				$password = $_REQUEST['new_password'];

					$username = $_REQUEST['Username'];

					$firstname=$_REQUEST['Firstname'];

					$lastname=$_REQUEST['Lastname'];

					

					$accountGroups = array();

		            $accountGroups[] = "6";

					$additional_data = array('first_name'=>$firstname,'last_name'=>$lastname);

					

					$accountGroups[] = "6";

					

					$register=$this->ion_auth->register($username, $password, $email, $additional_data,$accountGroups);

					

					if($register!='')

					{

						

						$snap_user=$this->snap->register_snap_user($register,$zone);

						//var_dump(9);

						$status='CANCEL';

						$this->business->upadte_user_paypal($register,$status);

						

						$sql_paypal="select * from paypal_configuration LIMIT 1";

						$query_paypal=$this->db->query($sql_paypal);

						$paypal = $query_paypal->row();



						$posturl=$paypal->paypal_url;

						$business_email=$paypal->business_email;

						?>

<!--

						<form name="frm_payment_method" id="frm_payment_method" action="<?php echo $posturl;?>" method="post">

						    <input type="hidden" name="cmd" value="_xclick-subscriptions">

						    <input type="hidden" name="custom" value="<?php echo $register; ?>">

						    <input type="hidden" name="business" value="<?php echo $business_email?>">

						    <input type="hidden" name="return" value="<?php echo base_url();?>welcome/paypal_success/<?php echo $zone;?>">

						    <input type="hidden" name="cancel_return" value="<?php echo base_url();?>welcome/paypal_cancel/<?php echo $zone;?>">

						    <input type="hidden" name="notify_url" value="<?php echo base_url();?>welcome/paypal_ipn/<?php echo $zone;?>">

						    <input type="hidden" name="currency_code" value="USD">

						    <input type="hidden" name="no_shipping" value="1">

						    <input type="hidden" name="rm" value="2">

						    <input type="hidden" value="subscription" name="item_name"/>

						    <input type="hidden" name="item_number" value="<?php echo $zone;?>">

						    <input type="hidden" name="a3" value="12">

						    <input type="hidden" name="p3" value="1">

						    <input type="hidden" name="t3" value="M">

						    <input type="hidden" name="src" value="1">

						    <input type="hidden" name="sra" value="1">

						</form>

						<script type="text/javascript">

							document.getElementById('frm_payment_method').submit();

						</script>-->



<?php 

						$data['error']='no';

						$this->load->view('approved_login', $data);

						exit;

					}

					else

					{

						$data['message']=$this->ion_auth->errors();

						$this->load->view('approved_login', $data);

					}

    			}

    			else

    			{ //var_dump(4); //exit;

    				$this->load->view('approved_login', $data);

    			}

    		}

			else if(isset($_REQUEST['login']) && $_REQUEST['login']=='3')

			{

    			

				$data['login']='login';

				$identity=$_REQUEST['Username'];

				$password=$_REQUEST['new_password'];

				$new=$this->ion_auth->login($identity, $password, '');

				$email = $_REQUEST['Email'];

				$password = $_REQUEST['new_password'];

				$username = $_REQUEST['Username'];

				$firstname=$_REQUEST['Firstname'];

				$lastname=$_REQUEST['Lastname'];

				

				$accountGroups = array();

				if($type=='favorites')

				{

					$accountGroups[] = "12";

				}

				else if($type=='rating')

				{

					$accountGroups[] = "9";

				}

				$additional_data = array('first_name'=>$firstname,'last_name'=>$lastname);

				

				//$accountGroups[] = "9";

				//echo '<pre>';print_r($accountGroups);exit;

				

				$register=$this->ion_auth->register($username, $password, $email, $additional_data,$accountGroups);

				//echo '<pre>'; print_r($register);exit;

				

				if($register!='')

				{

					

				}

				else

				{

					$data['message']=$this->ion_auth->errors();

					$this->load->view('approved_login', $data);

				}  			

    		

			} 

			

    		else{ //var_dump(5); //exit;

    			$data['error']='yes';

    			$this->load->view('approved_login', $data);

    		}

    	}else{ // this is without login, i.e, signup

    		$this->load->view('approved_login', $data);

    	}

    	exit;

    }

    

    function emailvalidation( $email )

    {

    	return preg_match( '/[.+a-zA-Z0-9_-]+@[a-zA-Z0-9-]+.[a-zA-Z]+/', $email );

    }

    

	function change_status_type(){//var_dump($_REQUEST);exit;//calling from new_page

		$user_id=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;

		$zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;

		$createdby_id=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;

		$type=!empty($_REQUEST['type']) ? $_REQUEST['type'] : 0;

		$status=!empty($_REQUEST['status']) ? $_REQUEST['status'] : 0; //var_dump($status);

		$from=!empty($_REQUEST['from']) ? $_REQUEST['from'] : '';

		$adid=!empty($_REQUEST['adid']) ? $_REQUEST['adid'] : 0;

		$dynamiImageUrl = isset($_COOKIE['themeImageUrl']) ? $_COOKIE['themeImageUrl'] : '<?= base_url("assets/stylesheets/blue_theme") ?>';

		//var_dump($from); exit;

		if($from=='snap'){

			if($status==1){ ?>

            

            

			<a href="javascript:void(0);" onclick='emailnoticepopup(<?=$user_id;?>,<?=$createdby_id?>,<?=$zone_id?>,"<?=$type;?>","",<?=$adid?>);return false;'><img src="<?= $dynamiImageUrl ?>/images/turn-on.png" style="width:100%" class="for-img-shedow" /></a>

			<?

			}else { ?>

            

		    <a href="javascript:void(0);" onclick='emailnoticepopup(<?=$user_id;?>,<?=$createdby_id?>,<?=$zone_id?>,"<?=$type;?>","",<?=$adid?>);return false;'><img src="<?= $dynamiImageUrl ?>/images/turn-off.png" style="width:100%" class="for-img-shadow"></a>

             

			<?

			}

		}else if($from=='newsletter'){

			$this->ad->change_status_type($createdby_id, $user_id, $status, $zone_id,$from);

			if($status==1){ ?>

			<a href="javascript:void(0)" onclick='stop_accepting_email_notices("<?=$createdby_id?>","<?=$adid?>","<?=$zone_id?>","<?=$user_id?>","newsletter");return false;' class="snapbutton emailIcon"><div class="offerSmallTxt">Subscribed to</div> <div class="offerBigTxt">Newsletter</div></a>

			<?

			}else { ?>

				<?php /*?><a href="javascript:void(0)" onclick='accept_email_notice("<?=$createdby_id?>","<?=$adid?>","<?=$zone_id?>","<?=$user_id?>","newsletter");return false;' class="adbutton adbutton1 emailIcon">News Letter to Subscribe</a><?php */?>

				<a href="javascript:void(0)" onclick='stop_accepting_email_notices("<?=$createdby_id?>","<?=$adid?>","<?=$zone_id?>","<?=$user_id?>","newsletter");return false;' class="snapbutton emailIcon"><div class="offerSmallTxt">Subscribed to</div> <div class="offerBigTxt">Newsletter</div></a>

				<?

			}

			

		}else if($from=='ad_favourites'){

			$this->ad->ad_to_favourites($adid, $user_id, $zone_id, $status);

			if($status){?>

                <!--<a href="javascript:void(0)" class="snapbutton favIcon"  onclick='stop_accepting_email_notices("<?=$createdby_id?>","<?=$adid?>","<?=$zone_id?>","<?=$user_id?>","ad_favourites");return false;'>

                <div class="offerSmallTxt">Remove</div>

                <div class="offerBigTxt">Favorites</div>

                </a>-->

                	 <li><a  href='javascript:void(0)' onclick='stop_accepting_email_notices("<?=$createdby_id?>","<?=$adid?>","<?=$zone_id?>","<?=$user_id?>","ad_favourites");return false;'><span>Remove<strong>Favorites</strong></span></a></li>

                <?php } else { ?>

                <!--<a href="javascript:void(0)" class="snapbutton favIcon"  onclick='accept_email_notice("<?=$createdby_id?>","<?=$adid?>","<?=$zone_id?>","<?=$user_id?>","ad_favourites");return false;'>

                <div class="offerSmallTxt">Add to</div>

                <div class="offerBigTxt">Favorites</div>

                </a>-->

                     <li><a  href='javascript:void(0)' onclick='accept_email_notice("<?=$createdby_id?>","<?=$adid?>","<?=$zone_id?>","<?=$user_id?>","ad_favourites");return false;'><span>Add to<strong>Favorites</strong></span></a></li>

				<?               

                }

          }

	}

	

    function approved_business($status=0)

    { 

		//var_dump($status); exit;

    	$bus_id='';

    	$user_id='';

    	$zone='';

    	$ad_id='';

    	if(isset($_REQUEST['bus_id']) && $_REQUEST['bus_id']!='' && isset($_REQUEST['user_id']) && $_REQUEST['user_id'])

    	{

    		$bus_id=$_REQUEST['bus_id'];

    		$user_id=$_REQUEST['user_id'];

    	}

    	

    	$zone=$_REQUEST['zone'];

    	$ad_id=$_REQUEST['ad_id'];

		$from_where=$_REQUEST['where_from'];

    	//var_dump($bus_id); var_dump($user_id); var_dump($zone); var_dump($ad_id); var_dump($from_where); exit;

		if($from_where=='snap'){

    		$this->ad->business_approved($bus_id, $user_id, $status, $zone,$from_where);

		}else if($from_where=='newsletter'){

			$this->ad->business_approved($bus_id, $user_id, $status, $zone,$from_where);

		}else if($from_where=='ad_favourites'){

			$this->ad->ad_to_favourites($ad_id, $user_id, $zone, $status);

			//$status=1;

		}

		//var_dump($a); exit;

		if($from_where=='snap'){

			if($status) { ?>

			

<a href="#" onclick='stop_accepting_email_notices("<?=$bus_id?>","<?=$ad_id?>","<?=$zone?>","<?=$user_id?>","snap");return false;'><img src="<?php echo base_url("assets/stylesheets/images/turn-off.png"); ?>"  class="for-img-shedow" /></a>

<?php 

			} else { ?>

<a href="#" onclick='accept_email_notice("<?=$bus_id?>","<?=$ad_id?>","<?=$zone?>","<?=$user_id?>","snap");return false;'><img src="<?php echo base_url("assets/stylesheets/images/turn-on.png"); ?>" class="for-img-shedow" /></a>

<?php 

			}

		}else if($from_where=='newsletter'){

			if($status){ ?>

<a href="javascript:void(0)" onclick='stop_accepting_email_notices("<?=$bus_id?>","<?=$ad_id?>","<?=$zone?>","<?=$user_id?>");return false;' class="adbutton adbutton1 emailIcon">News Letter Activated</a>

<?php } else { ?>

<a href="javascript:void(0)" onclick='accept_email_notice("<?=$bus_id?>","<?=$ad_id?>","<?=$zone?>","<?=$user_id?>","newsletter");return false;' class="adbutton adbutton1 emailIcon">Get Our News Letter</a>

<?php

			 }

		}else if($from_where=='ad_favourites'){

			if($status){?>

<a href="javascript:void(0)" class="adbutton favIcon"  onclick='stop_accepting_email_notices("<?=$bus_id?>","<?=$ad_id?>","<?=$zone?>","<?=$user_id?>","ad_favourites");return false;'>

<div class="offerSmallTxt">Remove</div>

<div class="offerBigTxt">Favorites</div>

</a>

<?php } else { ?>

<a href="javascript:void(0)" class="adbutton favIcon"  onclick='accept_email_notice("<?=$bus_id?>","<?=$ad_id?>","<?=$zone?>","<?=$user_id?>"                     ,"ad_favourites");return false;'>

<div class="offerSmallTxt">Add to</div>

<div class="offerBigTxt">Favorites</div>

</a>

<?php

			 }

		}

    	exit;

    }

    function zone_locator($zone=false)

    {

    	if($zone!='')

    	{

    		$data=array();

    		$data['zone']=$zone;

    		$email=$_REQUEST['email'];

    		

    		$sql="select id from users where email='".$email."'";

    		$query = $this->db->query($sql);

    			

    		if($query->num_rows()>=1)

    		{

    			$data['user'] = $query->row()->id;

    			

    			$zone_locator = $this->category->zone_locator($data['zone'],$data['user']);

    			

    			if(empty($zone_locator))

    			{

    				$this->db->insert('zone_locator', $data);

    			}

    			$data['zone_locator_all'] = $this->category->zone_locator_all($data['user']);

    		}

    		

    		$data['zone_all'] = $this->category->get_all_zone_state();

    		

    		 

    		echo ($this->load->view('zone-locator', $data));

    	}

    	exit;

    }

    

    

    function edit_zone($zone=false,$user=false)

    {

    	if($zone!='' && $user!='')

    	{

    		$data=array();

    		$data['zone']=$zone;

    		$data['user']=$user;

    		$data['$zone_all'] = $this->category->get_all_zone_state();

    	    $data['$zone_locator_all'] = $this->category->zone_locator_all($user);

            echo($this->load->view("favorites/edit_zone.php", $data, true));

    	}

    	exit;

    }

    

    function zone_remove($zone=false,$user=false)

    {

    	if($zone!='' && $user!='')

    	{

    		$data=array();

    		$data['zone']=$zone;

    		$data['user']=$user;

    		

    		$sql = "delete from zone_locator WHERE user ='".$user."' and zone='".$zone."'";

    		$this->db->query($sql) ;



            $data['$zone_all'] = $this->category->get_all_zone_state();

            $data['$zone_locator_all'] = $this->category->zone_locator_all($user);

            echo($this->load->view("favorites/edit_zone.php", $data, true));

        	}

        	exit;

        }

    

    function check_zone_locator($zone=false)

    {

    	if(isset($_COOKIE['email']) && !empty($_COOKIE['email']))

		{

			$sql="select id from users where email='".$_COOKIE['email']."'";

			$query = $this->db->query($sql);

			

			if($query->num_rows()>=1)

			{

				$user = $query->row()->id;

				

				$sql="select * from zone_locator where zone='".$zone."' and user='".$user."'";

				$query = $this->db->query($sql);

				

				if($query->num_rows()<1)

		    	{?>

<div class="for-two-btn-main" id=""><a href="#" onclick="set_favorite_zone('<?php echo $zone;?>','<?php echo $_COOKIE['email'];?>');">Zone Locator</a></div>

<div class="for-go-btn-main"><a href="<?=base_url("welcome/index/" . $zone)?>">Go</a></div>

<?php 

		    		exit;

		    	}else{?>

<div class="for-go-btn-main"><a href="<?=base_url("welcome/index/" . $zone)?>">Go</a></div>

<?php

		    	}

			}

    	}

    	else{?>

<div class="for-two-btn-main" id=""><a href="#" onclick="openVoteBox('favorite');">Zone Locator</a></div>

<div class="for-go-btn-main"><a href="<?=base_url("welcome/index/" . $zone)?>">Go</a></div>

<?php 

    		exit;

    	}

    	exit;

    }

    

    function find_state_zone($zone=false)

    {

    	if(isset($_COOKIE['email']) && !empty($_COOKIE['email']))

    	{

    		$sql="select id from users where email='".$_COOKIE['email']."'";

    		$query = $this->db->query($sql);

    			

    		if($query->num_rows()>=1)

    		{

    			$user = $query->row()->id;

    	

    			$sql="select * from zone_locator where zone='".$zone."' and user='".$user."'";

    			$query = $this->db->query($sql);

    	

    			if($query->num_rows()<1)

    			{?>

<div class="five-two-btn-main" id=""><a href="#" onclick="set_favorite_zone('<?php echo $zone;?>','<?php echo $_COOKIE['email'];?>');">Zone Locator</a></div>

<div class="seven-go-btn-main"><a href="<?=base_url("welcome/index/" . $zone)?>">Go</a></div>

<?php 

    				exit;

    			}else{?>

<div class="seven-go-btn-main"><a href="<?=base_url("welcome/index/" . $zone)?>">Go</a></div>

<?php

    			}

    		}

    	}

    	else{?>

<div class="five-two-btn-main" id=""><a href="#" onclick="openVoteBox('favorite');">Zone Locator</a></div>

<div class="seven-go-btn-main"><a href="<?=base_url("welcome/index/" . $zone)?>">Go</a></div>

<?php 

    	   	exit;

    	}

    	exit;

     }

    

    function presentation_demand()//calling from new_page

    {

    	

		$ad_id=$_REQUEST['adId'];

		//$email=$_REQUEST['emailAddress'];

		

		

		//var_dump($ad_id); var_dump($email); exit;

		$sql="select a.docs_pdf,a.business_id,b.business_owner_id,u.email from ads as a join business as b on b.id=a.business_id join users as u on u.id=b.business_owner_id where a.id='$ad_id'";

    	 

    	$query = $this->db->query($sql);

    	 

    	if($query->num_rows()>=1)

    	{

    		$sender = $query->row();

    		

    		$email=$_REQUEST['emailAddress'];

    		

    		$this->load->library('email');

    		$this->email->clear();

    		$this->email->from($sender->email, $sender->email);

    		 

    		$message="Presentation on demand";

    		$this->email->subject('Presentation on demand');

    		$this->email->message('Presentation on demand');

    

    		$this->email->attach(FCPATH."uploads/docs/" . $sender->docs_pdf);

    

    		$this->email->to($email);

    		$this->email->send();

    		//echo $this->email->print_debugger();

    	}

    	 

    	exit;

    }

    

	    function manage_favourite_zone()

	    {

	    	$data=array();

        	

	    	if(isset($_COOKIE['email']) && !empty($_COOKIE['email']))

	    	{

	    		$sql="select id from users where email='".$_COOKIE['email']."'";

	    		$query = $this->db->query($sql);

	    	

	    		if($query->num_rows()>=1)

	    		{

	    			$user_favorite = $query->row()->id;

	    			$data["zone_locator_all"] = $this->category->zone_locator_all($user_favorite);

	    		}

	    	}

        	echo ($this->load->view('favorite_view', $data));

    		exit;

        }

        

        function delete_favorite_zone()

        {

        	$zone_array=$_REQUEST['zone_array'];

        	

        	$data=array();

        	

        	if(isset($_COOKIE['email']) && !empty($_COOKIE['email']))

        	{

        		$sql="select id from users where email='".$_COOKIE['email']."'";

        		$query = $this->db->query($sql);

        	

        		if($query->num_rows()>=1)

        		{

        			$user_favorite = $query->row()->id;

        			

        			foreach($zone_array as $zone_array){

        				$sql = "delete from zone_locator WHERE user ='".$user_favorite."' and id='".$zone_array."'";

        				$this->db->query($sql) ;

        			}

        			$data['zone_locator_all'] = $this->category->zone_locator_all($user_favorite);

        		}

        	}

        	

        	$this->load->view('favorite_view', $data);

        	exit;

        }

		

		function showad($zoneId){

			/*$data['zone'] = $zoneid;

			$data['from_adspage'] = 1;

			$data['adlist'] = $this->ad->get_ads_for_all_athena($zoneid);*/

			

			$data = array();

			//$data['adlist'] = $this->ad->get_ads_for_all($zoneId); commented by koushik chhetri

			$data['adlist'] = $this->ad->get_ads_for_all_athena($zoneId);

			//var_dump($data['adlist']);

			$data['from_adspage'] = 1;

		

			$data['zone'] = $zoneId;

			$data["user_id"] = "";

			$data["user_favorites_ads_ids"] = array();

		

			if ($this->ion_auth->logged_in())

			{

				$auser = $this->ion_auth->user()->row();

				if(!empty($auser) && $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III"))){

					$data["user_favorites_ads_ids"] = $this->ad->get_favorites_ads_ids($auser->id, 'array');

					$data["user_id"] = $auser->id;

				}

				$data["user_id"] = $auser->id;

			}

			

			

			$result = $this->load->view('adlist', $data, true);

			//var_dump($result);

			echo($this->dr->GetDR("","", $result, "0"));

		}

public function job($businessid = false, $temp=''){

		//$zoneId = 229;

		

		$theme_cookie_value=$this->input->cookie('theme', TRUE);

		$zoneid_cookie_value=$this->input->cookie('zoneid', TRUE);

		

		//echo $theme_cookie_value; echo $zoneid_cookie_value;

		

		$temp=empty($_REQUEST['temp']) ? 0 : $_REQUEST['temp'];



        $data = array();

		$data['theme_cookie_value']=$theme_cookie_value;

		$data['zoneid']=$this->ad->get_businesszone($businessid); // get zoneid

		$zoneId=$data['zoneid']->settingszoneid;

        if(!empty($zone))

        {

            $zoneId = $zone;

        }

        $data['zone_owner_new'] = array();

        if(empty($zoneId))

        {

           $data['class']="home";



            if ($this->ion_auth->logged_in())

            {

                $auser = $this->ion_auth->user()->row();

                $data['user'] = $auser;

                if(!empty($auser)){

                    $data["email"] = $auser->email;

                    $data["firstName"] = $auser->first_name;

                    $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

                    

                    $uid = $auser->id;

                    $data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

                    $data['business_owner_new'] = $this->business->business_owner_user($uid);

                }

            }

            $data['content'] = $this->load->view('default/index', $data, true);

            $this->load->view('default/blank', $data);

            return;

        }



		$data['displayoffer'] = $this->ad->get_display_offer_in_zonepage($zoneId); 

        $data['category_list'] = $this->category_model->get_category_subcategory($zoneId);

		$data['category_list_food'] = $this->category_model->get_category_subcategory_for_food($zoneId); 

        $data['announcement_list'] = $this->announcements->get_announcements_for_zonepage($zoneId);

			

			

			$data['zone_pref_setting']=$this->sales_zone->get_default_settings_in_zone($zoneId);

			$data['businessdetails']=$this->ad->get_businessdetails($businessid); // get business details

			$data['jobdetails'] = $this->ad->get_jobdetails($businessid);  // get job details

			//var_dump($data['businessdetails']);

       		foreach($this->zonalads->getAllProducts($zoneId) as $val){

				$this->arr_ad[]=array('businessid'=>$val['businessid'],'adid'=>$val['adid'],'adname'=>$val['adname'],'adtext'=>$val['adtext'],'admessage'=>$val['admessage'],'businessowenerid'=>$val['businessowenerid'],'businessowener_fname'=>$val['businessowener_fname'],'businessowener_lname'=>$val['businessowener_lname'],'businessoweneraddress'=>$val['businessoweneraddress']);

			}

			$data['zonalads']=$this->arr_ad; 

		//} 

		//var_dump($data['zonalads']);

		$data['temp'] = $temp;

        $data['zone'] = $this->sales_zone->get_zone($zoneId);

        $data["firstName"] = "";



        $data['zone_id'] = $zoneId;

        $data["email"] = "";

        $data["admin"] = "";

        $data["user_id"] = "";

        if ($this->ion_auth->logged_in())

        {

            $auser = $this->ion_auth->user()->row();



            if(!empty($auser)){ 

				$data["user_id"] = $auser->user_id;

                $data["email"] = $auser->email; 



                $data["firstName"] = $auser->first_name;

                $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

				$data["user_id"] = $auser->id;

				$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";

            }

        }

		

		if(isset($_COOKIE['email']) && !empty($_COOKIE['email']))

        {

        	$sql="select id from users where email='".$_COOKIE['email']."'";

        	$query = $this->db->query($sql);

        	 

        	if($query->num_rows()>=1)

        	{

        		$user_favorite = $query->row()->id;

        		$data["zone_locator"] = $this->category->zone_locator($zoneId,$user_favorite);

        		$data["zone_locator_all"] = $this->category->zone_locator_all($user_favorite);

        	}

        }

		

		$sql="select * from zone_style_tag where zone_id='".$zoneId."'";

        $query = $this->db->query($sql);

        

        if($query->row())

        {

        	$data['style_tags']=$query->row();

        	$data['style_tags1']=$this->load->view('style_tags', $data, true);

        }

        $this->load->view('new_job', $data);

}

public function barter($businessid = false, $temp=''){

		//$zoneId = 229;

		$temp=empty($_REQUEST['temp']) ? 0 : $_REQUEST['temp'];



        $data = array();

		$data['zoneid']=$this->ad->get_businesszone($businessid); // get zoneid

		$zoneId=$data['zoneid']->settingszoneid;

        if(!empty($zone))

        {

            $zoneId = $zone;

        }

        $data['zone_owner_new'] = array();

        if(empty($zoneId))

        {

           $data['class']="home";



            if ($this->ion_auth->logged_in())

            {

                $auser = $this->ion_auth->user()->row();

                $data['user'] = $auser;

                if(!empty($auser)){

                    $data["email"] = $auser->email;

                    $data["firstName"] = $auser->first_name;

                    $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

                    

                    $uid = $auser->id;

                    $data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

                    $data['business_owner_new'] = $this->business->business_owner_user($uid);

                }

            }

            $data['content'] = $this->load->view('default/index', $data, true);

            $this->load->view('default/blank', $data);

            return;

        }



		$data['displayoffer'] = $this->ad->get_display_offer_in_zonepage($zoneId); 

        $data['category_list'] = $this->category_model->get_category_subcategory($zoneId); 

        	//$data['announcement_list'] = $this->announcements->get_announcements_for_zone($zoneId);

			$data['zone_pref_setting']=$this->sales_zone->get_default_settings_in_zone($zoneId);

			$data['businessdetails']=$this->ad->get_businessdetails($businessid); // get business details

			$data['barterdetails'] = $this->ad->get_barterdetails($businessid);  // get barter details

			//var_dump($data['businessdetails']);

       		foreach($this->zonalads->getAllProducts($zoneId) as $val){

				$this->arr_ad[]=array('businessid'=>$val['businessid'],'adid'=>$val['adid'],'adname'=>$val['adname'],'adtext'=>$val['adtext'],'admessage'=>$val['admessage'],'businessowenerid'=>$val['businessowenerid'],'businessowener_fname'=>$val['businessowener_fname'],'businessowener_lname'=>$val['businessowener_lname'],'businessoweneraddress'=>$val['businessoweneraddress']);

			}

			$data['zonalads']=$this->arr_ad; 

		//} 

		//var_dump($data['zonalads']);

		$data['temp'] = $temp;

        $data['zone'] = $this->sales_zone->get_zone($zoneId);

        $data["firstName"] = "";



        $data['zone_id'] = $zoneId;

        $data["email"] = "";

        $data["admin"] = "";

        $data["user_id"] = "";

        if ($this->ion_auth->logged_in())

        {

            $auser = $this->ion_auth->user()->row();



            if(!empty($auser)){ 

				$data["user_id"] = $auser->user_id;

                $data["email"] = $auser->email; 



                $data["firstName"] = $auser->first_name;

                $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

				$data["user_id"] = $auser->id;

				$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";

            }

        }

		

		if(isset($_COOKIE['email']) && !empty($_COOKIE['email']))

        {

        	$sql="select id from users where email='".$_COOKIE['email']."'";

        	$query = $this->db->query($sql);

        	 

        	if($query->num_rows()>=1)

        	{

        		$user_favorite = $query->row()->id;

        		$data["zone_locator"] = $this->category->zone_locator($zoneId,$user_favorite);

        		$data["zone_locator_all"] = $this->category->zone_locator_all($user_favorite);

        	}

        }

		

		$sql="select * from zone_style_tag where zone_id='".$zoneId."'";

        $query = $this->db->query($sql);

        

        if($query->row())

        {

        	$data['style_tags']=$query->row();

        	$data['style_tags1']=$this->load->view('style_tags', $data, true);

        }

        $this->load->view('new_barter', $data);

}



function languages()

	{

	   extract($_POST);

	   $this->session->set_userdata('language', $dlang);

	   $redirect_url = base_url().$current;

	   $data['lang'] = $this->session->userdata('language');

	   //var_dump($redirect_url); exit;

	   redirect($redirect_url);	

	

	}







function claim_zip_step1($a){

	    

		$data = array();

		$data['where_from']='';

        $data['class']="claim_zips";

        $data['zone_owner_new'] = array();

        

        if ($this->ion_auth->logged_in())

        {

            $auser = $this->ion_auth->user()->row();

            $data['user'] = $auser;

            if(!empty($auser)){

                $data["email"] = $auser->email;

                $data["firstName"] = $auser->first_name;

                $data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

                

                $uid = $auser->id;

                $data['zone_owner_new'] = $this->business->get_zone_byuser($uid);

                $data['business_owner_new'] = $this->business->business_owner_user($uid);

            }

        }



        $data['zips'] = $this->zips->get_full_zip_list($this->input->post('txtZip'));

		//var_dump($data['zips']);

        $data['checkbox'] = "Claim";

        $data['approve_status'] = "Approval Status";

        $data['content'] =  $this->load->view("claimzips/claimtop", $data, true);

        $data['content'] .= $this->load->view("claimzips/zipdata", $data, true);

        $data['content'] .= $this->load->view("claimzips/claimmiddle", $data, true);

        $data['checkbox'] = 0;

        $data['claim_status'] = 0;

        $data['zips'] = $this->zips->get_full_zip_list($this->input->post('txtZip'), $this->ion_auth->user()->row()->id);

		//var_dump($data['zips']);

}



	///////////////////////////////  redirect another page for peekaboo /////////////////////////////////////////

	

	    function other_redirect_peekaboo_register($username){var_dump($_REQUEST);exit;

		  $data=array();

		 // $data['common']=$this->common_first($businessid,$zoneid); //var_dump(  $data['common']['zone']['0']['zoneid']);exit;

		//  $zoneid =  $data['common']['zone']['0']['zoneid'];

		 $sql="select d.group_id,e.username from business as a , ads as  b, sales_zone as c, users_groups d, users as e  where  d.user_id=a.business_owner_id and e.id=a.business_owner_id  and e.username='$username' group by e.username"; //echo $sql;exit; 



		  $query = $this->db->query($sql);

		  $result = $query->result_array(); 

		  $data['peekaboo_other_page'] = $result; 

		  //$data['business_peekaboo'] = $this->ad->tamaldutta($businessid,$zoneid);

		  $data['right_container'] = $this->load->view("peekaboo_site", $data, true);	

	

			

		}

	

	public function log(){

        //echo("Index works..");



       // $this->load->view("Zonedashboard/zonedetail");

       $filename = 'log-custom'.date('Y-m-d').'.php';

       //unlink(APPPATH.'logs/'.$filename); 

		//echo $filename;

		if(file_exists(APPPATH.'logs/'.$filename)) {

			$fileData = file_get_contents(APPPATH.'logs/'.$filename);



		} else {

			$fileData = 'No file found';

		}

		

		echo $fileData;		

    }

	///////////////////////////////  redirect another page for peekaboo /////////////////////////////////////////















function publisher(){

      

    $this->load->view('web_page');



  }



}



class Category

{

    var $id;

    var $categoryName;

    var $ads;

    var $biz_type_id;

    var $biz_type_name;

}

