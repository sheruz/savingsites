<?php
namespace App\Controllers;
use App\Models\IonAuthModel;
use App\Models\Zips;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class Ad extends BaseController{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->Zips = new Zips();
    } 
	
	public function index(){
		echo("Index works..");
	}
	
	public function get($ad = false){
		$data = array();
		$data['ad']=$ad;
		$data['zone']=$this->sales_zone->get_zone_id_againest_title($ad); //var_dump($data['zoneid']);
		$zoneId=$data['zone']->id;
		$auser = $this->ion_auth->user()->row();
		if(!empty($auser)){ 
			$data["user_id"] = $auser->user_id;
			$data["email"] = $auser->email; 
			$data["firstName"] = $auser->first_name;
			$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";
			$data["user_id"] = $auser->id;
			$data["accept_email_notice"] = $this->ion_auth->in_group(array( "accept_email_notice")) ? "yes" : "";
			$newsessiondata = array('usergrid'=>$data["user_id"],'userzoneid'=>$zoneId);
		}
		$data['barter_button']='red'; $data['job_button']='red';
		$data['displayoffer'] = $this->ad->get_display_offer_in_zonepage($zoneId); 
		$this->load->view('ad', $data);
	}
	
	public function requested_ad($zone=false,$ad=false,$barter_button=false,$job_button=false){ 
		$data = array();
		$data['zone'] = $zone;
		$data["user_id"] = "";
		if ($this->ion_auth->logged_in()){
			$auser = $this->ion_auth->user()->row(); 
			$data["user_favorites_ads_ids"] = $this->ads->get_favorites_ads_ids($auser->id, 'array');
			$data["user_id"] = $auser->id;
		}
		$data['adlist'] = $this->ads->get_requested_ad($zone,$ad);
		$data['barter_button']=$barter_button;
		$data['job_button']=$job_button;
		if(!empty($data['adlist'])){
			$this->load->view('new_page_offer', $data);
		}
	}
}



