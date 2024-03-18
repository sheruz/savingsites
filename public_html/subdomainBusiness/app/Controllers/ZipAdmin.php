<?php
namespace App\Controllers;
use App\Models\IonAuthModel;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class Zipadmin extends BaseController{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
    }
    
    public function authorize($zone = false){
        if (!$this->ion_auth->logged_in()){
            redirect('auth/login' . (!empty($zone) ? "/".$zone : ""), 'refresh');
        }elseif (!$this->ion_auth->in_group(array( "Tier I")))
        {
            redirect('ads', 'refresh');
        }
        $data = array();
        $data['authorizeZips'] = $this->zips->get_users_zips(0);
        
        foreach(array_keys($data['authorizeZips']) as $key){
            foreach($data['authorizeZips'][$key] as $item){
                echo("&nbsp;&nbsp;" . $item['first_name'] . " " . $item['last_name'] . " " . $item['ZIP5'] . "<br/>");
            }
        }
    }
}