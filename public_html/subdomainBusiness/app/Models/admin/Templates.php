<?php
class Templates extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
    function get_all_template_admin()
    {
    	$query = $this->db->query('select * from template where admin=1 order by id desc');
    	return $query->result_array();
    }
    
   	function get_all_template()
   	{
   		$query = $this->db->query('select * from template where admin=0 order by id desc');
   		return $query->result_array();
   	}
   	function get_template($id)
   	{
   		$query = $this->db->query("select content from template where id=".$id);
   		return $query->row()->content;
   	}
   	function get_all_history($bus_id)
   	{
   		$query = $this->db->query('select * from save_email where business_id="'.$bus_id.'" order by id desc');
   		return $query->result_array();
   	}
   	function get_history($bus_id,$id)
   	{
   		$query = $this->db->query("select * from save_email where id=".$id);
   		return $query->row();
   	}
}
