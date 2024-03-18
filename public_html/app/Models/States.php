<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class States extends Model{ 
    var $table;
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->table = "states";
    } 
    
    public function get_all_states(){
        $builder = $this->db->table($this->table)->select('*');
        $data = $builder->get();
        $result = $data->getResultArray();
        return $result;
    }
    
    public function get_state_dropdown(){
        $options = array();
        $options['-1'] = '-- Select State --';
        foreach($this->get_all_states() as $state){
            extract($state);
            $options[$code] = "$name ($code)";
        }
        return $options;
    }
    
    public function get_all_states_zone(){
        $qry="select * from states order by id DESC";
        $query=$this->db->query($qry);
        return $query->result();
    }
    
    public function get_states_from_code($code){
        $query=$this->db->query("select * from states where code='".$code."'");
        if($query->num_rows()>=1){
            $row=$query->row();
            return $row;
        }else{
            return false;
        }
    }
    
    public function get_all_zone($code){
        $qry="select * from sales_zone where state='".$code."'";
        $query=$this->db->query($qry);
        return $query->result();
    }
    
    public function get_zip_code($code,$zone_radius){
        $query=$this->db->query("select * from zipcode where zip='".$code."'");
        if($query->num_rows()>=1){
            $row=$query->row();
            $latitude=deg2rad($row->latitude);
            $longitude=deg2rad($row->longitude);
            $radius_query='SELECT Zip_ID, zip, latitude, longitude, ACOS( SIN( '.$latitude.' ) * SIN( RADIANS( latitude ) ) + COS( '.$latitude.' ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - ( '.$longitude.' ) ) ) *6371 AS D FROM zipcode WHERE ACOS( SIN( '.$latitude.' ) * SIN( RADIANS( latitude ) ) + COS( '.$latitude.' ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - ( '.$longitude.' ) ) ) *6371 < '.$zone_radius.' ORDER BY D';
            $query=$this->db->query($radius_query);
            $result=$query->result();
            
            $zip_str='';
            foreach($result as $result){
                if($zip_str==''){
                    $zip_str.="'".$result->zip."'";
                }else{
                    $zip_str.=",'".$result->zip."'";
                }
            }
            
            $qry="select zz.zone_id,sz.name,sz.id from zip_code_zone as zz, sales_zone as sz where zz.zip_code in (".$zip_str.") and zz.zone_id=sz.id group by zz.zone_id";
            $query=$this->db->query($qry);
            return $query->result();
        }else{
            return false;
        }
    }
}