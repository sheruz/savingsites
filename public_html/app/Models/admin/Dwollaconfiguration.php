<?php
class Dwollaconfiguration extends CI_Model
{
    var $id;
	var $dwolla_facilitator_details;
	public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
    function setid($id){
		$this->id=$id;
	}
	function getId(){
		return $this->id;
	}
	function setdwolla_facilitator_details(){
		$query = $this->db->query("select * from dwollasellerfacilitatoraccount WHERE userid=".$this->id);
		//echo $query;
    	$this->dwolla_facilitator_details=$query->row();
	}
	function getdwolla_facilitator_details(){
		return $this->dwolla_facilitator_details;
	}
}
