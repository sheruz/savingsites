<?php
namespace App\Controllers;
use App\Models\IonAuthModel;
use App\Models\Zips;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class Admin extends BaseController{
    var $tierI;
    var $tierII;
    var $tierIII;
    
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->Zips = new Zips();
    } 
    
    public function index($zone = false){
        if (!$this->ion_auth->logged_in()){
            redirect('auth/login' . (!empty($zone) ? "/".$zone : ""), 'refresh');
        }elseif ($this->ion_auth->in_group(array( "accept_email_notice"))){
            redirect("welcome/profile". (!empty($zone) ? "/".$zone : ""));
        }elseif (!$this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III"))){
            redirect($this->config->item('base_url'), 'refresh');
        }
        
        $auser = $this->ion_auth->user()->row();
        $user_id = $auser->id;
        
        if($this->ion_auth->in_group(array("Tier II"))){
            $zones = $this->sales_zone->get_zones_for_user($user_id);
            if(empty($zones)){
                redirect("dashboards/zone" .(!empty($zone) ? "/".$zone : ""));
            }else{
                if($this->session->userdata('businesszonedata')){
                    $businesszone_data = $this->session->userdata('businesszonedata');
                    $buszoneid = $businesszone_data['buszoneid'];
                    if($buszoneid==-1){
                        $buszoneid = $zones[0]['id'];
                    }
                    
                    $this->session->unset_userdata('businesszonedata');
                    redirect("dashboards/zone/$buszoneid", 'refresh');
                }else{
                    $zid = $zones[0]['id'];
                    redirect("dashboards/zone/$zid", 'refresh');
                }
            }
        }
        
        if($this->ion_auth->in_group(array("Tier III"))){
            $businesses = $this->business->get_all_businesses_for_user($user_id);
            if(empty($businesses)){
                redirect("dashboards/business");
            }else{
                $bid = $businesses[0]['id'];
                redirect("dashboards/business/$bid", 'refresh');
            }
        }
        redirect("category". (!empty($zone) ? "/".$zone : ""));
    }
}