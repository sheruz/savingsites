<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Snap_profile extends CI_Controller

{



    public function __construct()

    {

        parent::__construct();

       $this->load->library('ion_auth');

        $this->load->library('session');

        $this->load->library('form_validation');

		

		$this->load->library('user_agent');

		

        $this->load->helper('url');

        $this->load->model("Zips");

        $this->load->helper("time_helper");

		//$this->load->helper("translate_helper");

        $this->load->model("admin/Category_model", "category");

        $this->load->model("admin/Announcement_model", "announcements");

		$this->load->model("admin/Zonal_ads", "zonalads");//added by koushik chhetri to fetch the ads against the zoneid

        $this->load->model("admin/Ads_model", "ads");

        $this->load->model("admin/Sales_zone", "sales_zone");

		$this->load->model("States", "states");

		$this->load->model("admin/Business", "business");

		$this->load->model("admin/Ads_model", "ad");

		$this->load->model("admin/Business_type_model", "business_type");

		$this->load->model("admin/Category_management_model", "category_model");

		$this->load->model("emailnotice/Snap_email_notification","snap_email");

        $this->load->database();

    }





    function load($zone)

    {}

	

	function change_theme(){

		$zoneid=$_REQUEST['zoneid'];

		$themeid=$_REQUEST['themeid'];

		//var_dump($zoneid); var_dump($themeid);

		if (!get_cookie('')) {

			// cookie not set, first visit



			// create cookie to avoid hitting this case again

			$cookie = array(

				'name'   => 'theme',

				'value'  => $themeid,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			/*$cookie = array(

				'name'   => 'zoneid',

				'value'  => $zoneid,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);*/

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

			

			//var_dump($_COOKIE);

		} 

		$result = $zoneid;

		//echo($this->dr->GetDR("","", $result, "0"));

		echo $result;

	}

	

  

    

    public function index($zone = false){

		

		var_dump($zone); exit;

       

	    if(!is_numeric($zone))

        {

            //lookup zone by name

            $zone_details = $this->sales_zone->get_zone_by_name(urldecode($zone));

        }

        else

        {

            //lookup zone by id

            $zone_details = $this->sales_zone->get_zone($zone);

        }

	   //var_dump($data['zone']);

	   $zoneId =$zone_details->id;

	   //var_dump($zoneId);

	   $data = array();

	   $data['server_host']=$_SERVER['HTTP_HOST'];

        if(!empty($zone))

        {

            $zoneId = $zoneId;

        }

        $data['zone_owner_new'] = array();

		$data['zone_id'] = $zoneId;

		

        if(empty($zoneId))

        {

           $data['class']="home";



            if ($this->ion_auth->logged_in())

            {

                $auser = $this->ion_auth->user()->row();

				//var_dump($auser);

                $data['user'] = $auser;

				$data['userid_zone']=$auser->id;

                if(!empty($auser)){ //var_dump($auser);

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

            $data['content'] = $this->load->view('default/index', $data, true);

            $this->load->view('default/blank', $data);

            return;

        }

		 //var_dump($data); exit;

		/*$data['baner']=1;

		$data['anouncement_offer']=3;*/

		

		/*if (!get_cookie('')) {

			// cookie not set, first visit



			// create cookie to avoid hitting this case again

			$cookie = array(

				'name'   => 'theme',

				'value'  => 'DT',

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($cookie);

			//var_dump($_COOKIE);

		}*/

		

		/*var_dump($theme_cookie_value);*/

		$theme_cookie_value=''; $zoneid_cookie_value='';

		$data['change_theme'] = $this->ad->get_display_change_theme_in_zonepage($zoneId);

		//$theme_cookie_value=''; $zoneid_cookie_value='';		

		//var_dump($data['change_theme']);

		if(!empty($data['change_theme'])){

		if($data['change_theme'][0]['ischangezonetheme']==0){

			delete_cookie("theme"); delete_cookie("zoneid");

			$theme_cookie_value=''; $zoneid_cookie_value='';

			//var_dump($_COOKIE);

		}else{

			$theme_cookie_value=$this->input->cookie('theme', TRUE);

			$zoneid_cookie_value=$this->input->cookie('zoneid', TRUE);

		}

		}

		

		

		//$data['css_value']="assets/stylesheets/up_styles.css";

		$data['css_value']=''; $data['css_vertical_value']=''; //$data['css_value_for_blue'];

		if($theme_cookie_value != '' && $zoneid_cookie_value!=''){ //var_dump(1); exit;

			if($theme_cookie_value=='DT' && $zoneid_cookie_value==$zoneId){

				$data['css_value']="assets/stylesheets/up_styles.css";

				$data['css_vertical_value']="assets/stylesheets/up_vertical_menu.css";

				$data['css_value_for_blue']="";

				$data['barter_button']='green'; $data['job_button']='green';

			}else if($theme_cookie_value=='MT' && $zoneid_cookie_value==$zoneId){

				$data['css_value']="assets/stylesheets/styles_maroon_skin.css";

				$data['css_vertical_value']="assets/stylesheets/maroon_vertical_menu.css";

				$data['css_value_for_blue']="";

				$data['barter_button']='red'; $data['job_button']='red';

			}else if($theme_cookie_value=='BT' && $zoneid_cookie_value==$zoneId){

				$data['css_value']="assets/stylesheets/up_styles_blue.css";

				$data['css_value_for_blue']="assets/stylesheets/styles_blue_skin.css";

				$data['css_vertical_value']="assets/stylesheets/blue_vertical_menu.css";

				$data['barter_button']='blue'; $data['job_button']='blue';

			}

			



		}else{ //var_dump(2); exit;		

			$change_theme = $this->ad->get_display_change_theme_in_zonepage($zoneId);

			//var_dump($change_theme);

			if(!empty($change_theme)){

				if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='DT'){

					$data['css_value']="assets/stylesheets/up_styles.css";

					$data['css_vertical_value']="assets/stylesheets/up_vertical_menu.css";

					$data['css_value_for_blue']="";

					$data['barter_button']='green'; $data['job_button']='green';

				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='MT'){

					$data['css_value']="assets/stylesheets/styles_maroon_skin.css";

					$data['css_vertical_value']="assets/stylesheets/maroon_vertical_menu.css";

					$data['css_value_for_blue']="";

					$data['barter_button']='red'; $data['job_button']='red';

				}else if($change_theme[0]['ischangezonetheme']==0 && $change_theme[0]['zonetheme']=='BT'){

					$data['css_value']="assets/stylesheets/up_styles_blue.css";

					$data['css_value_for_blue']="assets/stylesheets/styles_blue_skin.css";

					$data['css_vertical_value']="assets/stylesheets/blue_vertical_menu.css";

					$data['barter_button']='blue'; $data['job_button']='blue';

				}else if($change_theme[0]['ischangezonetheme']==1 && $change_theme[0]['zonetheme']==''){

					$data['css_value']="assets/stylesheets/styles_maroon_skin.css";

					$data['css_vertical_value']="assets/stylesheets/maroon_vertical_menu.css";

					$data['css_value_for_blue']="";

					$data['barter_button']='red'; $data['job_button']='red';

				}

				

			}

		}

		

		$data['theme_cookie_value']=$theme_cookie_value;

		//var_dump($data['css_value']); var_dump($data['css_vertical_value']); var_dump($data['css_value_for_blue']);

		//echo 1; 

		

		$data['displayoffer'] = $this->ad->get_display_offer_in_zonepage($zoneId); 

		//var_dump($data['displayoffer']);

		////$data['category_list'] = $this->category_model->get_category_subcategory($zoneId);

		

		////$data['category_list_food'] = $this->category_model->get_category_subcategory_for_food($zoneId);

		

		//var_dump($data['category_list_food']);

		

		//$data['category_list'] = $this->category_model->get_category_subcategory_details($zoneId); 

		//$data['category_list_for_food'] = $this->category_model->get_category_subcategory_details_for_food($zoneId);

		//var_dump($data['category_list']);

		//var_dump($data['category_list']);

        //$data['category_list'] = $this->category_model->get_category_subcategory_new($zoneId); 

		//var_dump($data['category_list']);

		//if($temp==1){

			//var_dump($zoneId);

        	$data['announcement_list'] = $this->announcements->get_announcements_for_zonepage($zoneId);

			//var_dump($data['announcement_list']);

			//var_dump($data['announcement_list']);

			//$data['zone'] = $zoneId;

			//$data['from_adspage'] = 1;

			//$data['adlist'] = $this->ad->get_ads_for_all_athena($zoneId);

			//if($data['adlist']!=''){

			//$this->load->view('adlist', $data);

			//}

			//var_dump($data['adlist']);

			$data['zone_pref_setting']=$this->sales_zone->get_default_settings_in_zone($zoneId);

			//var_dump($data['zone_pref_setting']);

			//$data['adlist'] = $this->ad->get_ads_for_all_athena($zoneId);

			//var_dump($data['adlist']);

			//var_dump($data['announcement_list']);

			

       		/*foreach($this->zonalads->getAllProducts($zoneId) as $val){

				$this->arr_ad[]=array('businessid'=>$val['businessid'],'adid'=>$val['adid'],'adname'=>$val['adname'],'adtext'=>$val['adtext'],'admessage'=>$val['admessage'],'businessowenerid'=>$val['businessowenerid'],'businessowener_fname'=>$val['businessowener_fname'],'businessowener_lname'=>$val['businessowener_lname'],'businessoweneraddress'=>$val['businessoweneraddress']);

			}

			$data['zonalads']=$this->arr_ad; */

		//} 

		//var_dump($data['zonalads']);

		//$data['temp'] = $temp;

        $data['zone'] = $this->sales_zone->get_zone($zoneId);

        $data["firstName"] = "";



        $data['zone_id'] = $zoneId;

        $data["email"] = "";

        $data["admin"] = "";

        $data["user_id"] = "";

		

		//echo 2; //exit;

		/*$data['loadurl']=base_url();

		var_dump($data['loadurl']);*/

		

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

		

		//$mtime = microtime();

//		$mtime = explode(" ",$mtime);

//		$mtime = $mtime[1] + $mtime[0];

//		$endtime = $mtime;

//		$totaltime = ($endtime - $starttime);

//

//		echo "Page execution time::".$totaltime." seconds";

        

        if($query->row())

        {

        	$data['style_tags']=$query->row();

        	$data['style_tags1']=$this->load->view('style_tags', $data, true);

        }

		//var_dump($data);

		$scripts = array("assets/scripts/jquery-1.7.2.min_1.js");

		/*$scripts = array ("assets/scripts/jquery-1.7.2.min_1.js","assets/scripts/jquery.blockUI.js","assets/scripts/new/jquery.nivo.slider.js","");*/

		$data['scripts'] = $scripts;

		//var_dump($data);

        $this->load->view('new_page', $data);



    }
    /**
      * @description method to fetch global snap profile data
      * @method POST
      * @param $zoneId,$userId
      * @return json_encoded snap global data 
    */
    public function getGlobalSnapProfileData() {
    	$zoneId                   = $this->input->post('zoneId');
    	$userId                   = $this->input->post('userId');
    	$snapEmailCriteria        = $this->snap_email->getGlobalSnapEmailData($userId,$zoneId);
    	$snapPercentageCriteria   = $this->snap_email->getPercentageCriteria();
    	$snpStartTimeData         = $this->snap_email->getSnapStartTime();
    	$snapWeekDays             = $this->snap_email->getSnapWeekDays();
    	$totalArray               = array (
    										'globalSnapEmailCriteria'=> $snapEmailCriteria,
    										'snapPercentageCriteria'=> $snapPercentageCriteria,
    										'snapStartTimeData'	=> $snpStartTimeData,
    										'snapWeekDays'      => $snapWeekDays
    									  );
    	echo json_encode($totalArray);

    }
    /**
      * @description method to update global snap data
      * @method post
      * @param $userId,$zoneId,$snapStatus,$snapWeekdays,$snapStartTime
      * @return update status
    */
    public function updateGlobalSettings() {
    	$snapStatus             = $_REQUEST['snapStatus'] ? $_REQUEST['snapStatus'] : 0;
    	$snapType               = $_REQUEST['snapReceiveType'] ? $_REQUEST['snapReceiveType'] : 0;
    	$snapDiscountPercentage = $_REQUEST['snapDiscountPercentage'] ? $_REQUEST['snapDiscountPercentage'] : 0;
    	$snapWeekDays           = $_REQUEST['globalSnapWeekdaysdata'] ? $_REQUEST['globalSnapWeekdaysdata'] : 0;
    	$snapStartTime          = $_REQUEST['globalSnapStartTime'] ? $_REQUEST['globalSnapStartTime'] : '';
    	$snapUserId             = $_REQUEST['userId'] ? $_REQUEST['userId'] : 0;
    	$snapZoneId             = $_REQUEST['zoneId'] ? $_REQUEST['zoneId'] : 0;
     	$globalSnapUpdateStatus = $this->snap_email->updateGlobalSnapStatus($snapType,$snapWeekDays,$snapStartTime,$snapDiscountPercentage,$snapUserId,$snapZoneId,$snapStatus);
     	echo json_encode($globalSnapUpdateStatus);   

    }
    /**
      * @description method to deactivate global snap data
      * @method POST,
      * @param $snapStatus,$userId,$zoneId
      * @return update status boolean
    */
    public function deActiveGlobalSettings() {
    	$snapStatus = $_REQUEST['snapStatus'] ? $_REQUEST['snapStatus'] : 0;
    	$userId     = $_REQUEST['userId'] ? $_REQUEST['userId'] : 0;
    	$zoneId     = $_REQUEST['zoneId'] ? $_REQUEST['zoneId'] : 0;

    	$updateStatus = $this->snap_email->deActiveGlobalSnapStatus($snapStatus,$userId,$zoneId);

    	echo json_encode($updateStatus);


    }

}



