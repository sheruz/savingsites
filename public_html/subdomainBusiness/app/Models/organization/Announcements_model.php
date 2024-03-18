<?php
class Announcements_model extends CI_Model
{
    public function __construct(){
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->database();
    }
	function delete_announcements($id=0,$zoneid=0){
		if(!empty($id) || !empty($zoneid)){
			$data = array();
    		$data['id'] = $id;
    		$data['zoneid'] = $zoneid;						
    		$this->db->delete('organization_announcement', $data);
		}
	}
}