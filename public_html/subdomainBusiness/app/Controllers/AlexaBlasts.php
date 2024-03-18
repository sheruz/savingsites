<?php
namespace App\Controllers;
use App\Models\IonAuthModel;
use App\Models\Zips;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class AlexaBlasts extends BaseController{
   
    
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->Zips = new Zips();
    } 
	
	public function blasts($zoneId) {
		if (!$zoneId) {
 			redirect(base_url());
 		}
		
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
				$data['username'] = $auser->username;
				
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
			$session_type='';
			$session_type_id='';
		}
		
		$data['user_type'] = $this->session->userdata("session_login_details");
		$data['session_usertype']=$session_usertype; 
		$data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;
		$data['session_session_normal_user_type']=$session_session_normal_user_type;
		$data['active_banner_mobile'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','4','2');	
		$data['active_banner_desktop'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','4','1');
		$this->load->view('blasts/index',$data);
	}

 	/* @desc method to load Alexa Blast contact view*/
	public function contact($zoneId) {
		if (!$zoneId) {
 			redirect(base_url());
 		}
		
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
				$data['username'] = $auser->username;
				
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
			$session_type='';
			$session_type_id='';
		}
		
		$data['user_type'] = $this->session->userdata("session_login_details");
		$data['session_usertype']=$session_usertype; 
		$data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;
		$data['session_session_normal_user_type']=$session_session_normal_user_type;
		$data['active_banner_mobile'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','4','2');
		$data['active_banner_desktop'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','4','1');
		$this->load->view('blasts/contact',$data);
	}
	
	/**
		* @desc method to get current theme option
		* @param $zoneId
	*/
	public function getCurrentThemeOption($zoneId) {
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