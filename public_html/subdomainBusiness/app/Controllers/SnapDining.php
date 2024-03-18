<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');

 class SnapDining extends CI_Controller {

 	/**

 	  * @desc constructor function to load required data

 	*/

 	public function __construct() {

 		parent::__construct();

 		$this->load->helper('url');

 		$this->load->model('dining/Diningmodel','snapDining');

		 $this->load->model("admin/Ads_model", "ad");

		 $this->load->model('webinar/Webinarmodel','webinarmodel');

		 $this->load->model("banner/Banner_model", "banner");

		 $this->load->model("zone/Zone_model", "get_zone");

 		$this->load->database();



 	}

 	/**

 	  * @desc method to load snap dining view



 	*/

 	public function dining($zoneId) {

 		// load snap dining  view with specific zoneId

 		$data['zonedetails']	= $this->get_zone->get_zone($zoneId); 

 		$data['snapDiningData']   = $this->snapDining->getAllCommonSnapData();

 		$data['snapCurrentTheme'] = $this->getCurrentThemeOption($zoneId);

	 	$data['zoneId']           = $zoneId;

	 	$data['base_url'] 			= $this->config->item('base_url'); 	


        $data['resultdata']=[];

    

        if($this->ion_auth->logged_in()){ 

            $auser = $this->ion_auth->user()->row();



               $sql="select * from others_referral_id where zoneid=".$zoneId;

                $query=$this->db->query($sql);

                $refferalcode = $query->result_array();

                $data['resultdata']=$refferalcode[0];



			



            if(!empty($auser)){ 
 
				$this->session->set_userdata('get_email',$auser->email);

				$data["user_id"] = $auser->user_id;

                $data["email"] = $auser->email; 

                $data["firstName"] = $auser->first_name;

				$data["lastName"] = $auser->last_name;

				$data['businessUser'] = $auser;

				$data['username'] = $auser->username;

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

		$data['user_type'] = $this->session->userdata("session_login_details");

    	$data['session_usertype']=$session_usertype; 

		$data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;

		$data['session_session_normal_user_type']=$session_session_normal_user_type;

		 //$data['banner'] = $this->snapDining->get_banners();

		 //$data['banner'] = $this->webinarmodel->get_banners();

		 //$data['active_banner'] 	= $this->banner->active_banner($zoneId,'','4');

		 $data['active_banner_mobile'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','4','2');

		 $data['active_banner_desktop'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','4','1');

 		$this->load->view('dining/snap_dining',$data);

 		

 	}



 	public function booktable($zoneId, $busId) {




 		$data['zonedetails']	= $this->get_zone->get_zone($zoneId); 

 	    $data['busID']	= $busId;

 		$data['snapDiningData']   = $this->snapDining->getAllCommonSnapData();

 		$data['snapCurrentTheme'] = $this->getCurrentThemeOption($zoneId);

	 	$data['zoneId']           = $zoneId;

	 	$data['base_url'] 			= $this->config->item('base_url'); 	



        if($this->ion_auth->logged_in()){ 

            $auser = $this->ion_auth->user()->row();
 

            if(!empty($auser)){ 

				$this->session->set_userdata('get_email',$auser->email);

				$data["user_id"] = $auser->user_id;

                $data["email"] = $auser->email; 

                $data["firstName"] = $auser->first_name;

				$data["lastName"] = $auser->last_name;

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

        }else{
            
        	header( 'Location:'.$this->config->item('base_url').'snapDining/dining/'.$zoneId);
        	die;
        }

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

		$data['user_type'] = $this->session->userdata("session_login_details");

    	$data['session_usertype']=$session_usertype; 

		$data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;

		$data['session_session_normal_user_type']=$session_session_normal_user_type;

		$response['people'] =$this->input->get('noofperson');

		$response['price'] = $this->snapDining->checkBookingPrice($busId);

		$data['STORE']['table_id'] = $_SESSION['table_id'];


		$data['userid']= $this->input->get('userId'); 	

		$data['noofperson']= $this->input->get('noofperson'); 

		$data['date']=  $this->input->get('searchDate');

		$data['time']=  $this->input->get('time');  



		

       
 

         $data['tpl'] = $response;
 

	 
 

 
 		$this->load->view('dining/booktable',$data);

 		

 	}


public function dashboard($zoneId) {




 		$data['zonedetails']	= $this->get_zone->get_zone($zoneId); 

 		$data['snapDiningData']   = $this->snapDining->getAllCommonSnapData();

 		$data['snapCurrentTheme'] = $this->getCurrentThemeOption($zoneId);

	 	$data['zoneId']           = $zoneId;

	 	$data['base_url'] 			= $this->config->item('base_url'); 	



        if($this->ion_auth->logged_in()){ 

            $auser = $this->ion_auth->user()->row();



            if(!empty($auser)){ 

				$this->session->set_userdata('get_email',$auser->email);

				$data["user_id"] = $auser->user_id;

                $data["email"] = $auser->email; 

                $data["firstName"] = $auser->first_name;

				$data["lastName"] = $auser->last_name;

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

        }else{
            
        	header( 'Location:'.$this->config->item('base_url').'snapDining/dining/'.$zoneId);
        	die;
        }

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

		$data['user_type'] = $this->session->userdata("session_login_details");

    	$data['session_usertype']=$session_usertype; 

		$data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;

		$data['session_session_normal_user_type']=$session_session_normal_user_type;


	 	$data['booking'] = $this->db->query('select restaurantbooking_bookings.*, business.name from restaurantbooking_bookings left join business On business.id = restaurantbooking_bookings.business_id where user_id ='.$auser->user_id )->result();

 		// $data['booking'] = 'ede';
 		// print_r($data['booking']);die;
 

 
 		$this->load->view('dining/dashboard',$data);

 		

 	}





 	public function bookcheckout($zoneId, $busId) {




 		$data['zonedetails']	= $this->get_zone->get_zone($zoneId); 

 	    $data['busID']	= $busId;

 		$data['snapDiningData']   = $this->snapDining->getAllCommonSnapData();

 		$data['snapCurrentTheme'] = $this->getCurrentThemeOption($zoneId);

	 	$data['zoneId']           = $zoneId;

	 	$data['base_url'] 			= $this->config->item('base_url'); 	



        if($this->ion_auth->logged_in()){ 

            $auser = $this->ion_auth->user()->row();
 

            if(!empty($auser)){ 

				$this->session->set_userdata('get_email',$auser->email);

				$data["user_id"] = $auser->user_id;

                $data["email"] = $auser->email; 

                $data["firstName"] = $auser->first_name;

				$data["lastName"] = $auser->last_name;

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

        }else{
            
        	header( 'Location:'.$this->config->item('base_url').'snapDining/dining/'.$zoneId);
        	die;
        }

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

		$data['user_type'] = $this->session->userdata("session_login_details");

    	$data['session_usertype']=$session_usertype; 

		$data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;

		$data['session_session_normal_user_type']=$session_session_normal_user_type;

		$response['people'] =$this->input->get('noofperson');

		$response['price'] = $this->snapDining->checkBookingPrice($busId);

		$data['STORE']['table_id'] = $_SESSION['table_id'];


		$data['userid']= $this->input->get('userId'); 	

		$data['noofperson']= $this->input->get('noofperson'); 

		$data['date']=  $this->input->get('searchDate');

		$data['time']=  $this->input->get('time');  



		$data['check_result'] =  $response['check_result'] = $this->snapDining->getRestaurantAvailableTable(

															 $busId,	

															 $this->input->get('userId'), 

															 $this->input->get('noofperson'),

															  $this->input->get('searchDate'),

															 $this->input->get('time')
															 

															);

       
 

         $data['tpl'] = $response;
 

 
 

 
 		$this->load->view('dining/bookingcheckout',$data);

 		

 	}




	public function setTableSelected() {	 

 	  $_SESSION['table_id'] = $_POST['tableID'];
 	}




 	/**

 	  * @desc method to get special offer list

 	  * @access public

 	  * @return $specialOfferDate jsonobject

 	*/

 	public function getSpecialOffer() {

 		if($this->input->post('zoneId')) {

 			$response['specialOfferList'] = $this->snapDining->getAllSpecialOfferList($this->input->post('zoneId'),$this->input->post('orderBy'));



 			$response['status'] = 1;

 		} else {

        	$response['status'] = 0;

 		}

 		echo json_encode($response);

 	}

 	/**

 	  * @desc method to get snapdining search data

 	  * @access public

 	  * @return $seachData array

 	*/

 	public function searchDiningQuery() {

 		$response = array();

 		$date = date('Y-m-d',strtotime($this->input->post('searchDate')));


 		$response['searchData'] = $this->snapDining->getSearchQueryData(

															 $this->input->post('noOfPerson'),

															 $date,

															 $this->input->post('time'),

															 $this->input->post('foodType'),

															 $this->input->post('discountPercentage'),

															 $this->input->post('snapSettingsType'),

															 $this->input->post('isDelivaryRequired'),

															 $this->input->post('zoneId'),

															 $this->input->post('userId'),

															 $this->input->post('orderBy'),

															  $this->input->post('outDoorDining')

															);

 
          echo json_encode($response);

 	}

 	/**

 	  * @desc method to get current theme option

 	  * @param $zoneId

 	*/

     public function getCurrentThemeOption($zoneId) {

     	//return $_COOKIE;

     	$data['snapAssetsBaseUrl'] = 'assets/snapdining/theme/purple/'; // This is set for defualt theme

     	if(isset($_COOKIE['zoneid_zone']) && $_COOKIE['zoneid_zone'] == $zoneId) {

     		if(!empty($_COOKIE['theme_zone']) && $_COOKIE['theme_zone'] == 'BLT') {

     			$data['snapAssetsBaseUrl'] = 'assets/snapdining/theme/blue/';

     		} else if(!empty($_COOKIE['zoneid_zone']) && $_COOKIE['theme_zone'] == 'LT') {

     			$data['snapAssetsBaseUrl'] = 'assets/snapdining/theme/light/';

     		} else if(!empty($_COOKIE['zoneid_zone']) && $_COOKIE['theme_zone'] == 'RT') {

     			$data['snapAssetsBaseUrl'] = 'assets/snapdining/theme/purple/';

     		} else if(!empty($_COOKIE['zoneid_zone']) && $_COOKIE['theme_zone'] == 'BRT') {

     			$data['snapAssetsBaseUrl'] = 'assets/snapdining/theme/brown/';

     		}

     	}

     	return $data;

     }

 }