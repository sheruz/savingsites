<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\IonAuth;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class QR_model extends Model{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->CommonController = new CommonController();
    	$this->tbl_qr = 'tbl_qr';
    } 
    
    public function fetch_datas(){
    	$query = $this->db->get($this->tbl_qr);
		return $query->result_array();
	}

  	public function fetch_data($id){
    	$this->db->where('id', $id);
		$query = $this->db->get($this->tbl_qr);
		return $query->row_array();
	}
	
	public function insert_data($qr,$userid){
		$location = "./assets/SavingsUpload/QRCode/";
    	if(is_dir($location)==false){ mkdir($location,0777);}
    	$resname = $this->CommonController->uploadtoaws($location, $qr);
    	$this->CommonController->updateData('users',['qrimage'=>$resname],['id' => $userid]);
		return 1;
    }

  	public function update_data($id, $old_file, $qr){
        unlink($old_file);
		$this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update($this->tbl_qr, $qr);
        $this->db->trans_complete();
		return $this->db->affected_rows() || $this->db->trans_status();
    }

    public function delete_data($id, $qr_file){
    	unlink($qr_file);
		$this->db->where('id', $id);
        $this->db->delete($this->tbl_qr);
		return $this->db->affected_rows();
    }
}