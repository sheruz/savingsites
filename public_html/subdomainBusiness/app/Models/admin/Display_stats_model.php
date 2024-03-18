<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Display_stats_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_zones()
    {
    	$query = $this->db->query('select * from  sales_zone order by name');
    	return $query->result_array();
    }
    
    public function get_no_of_hits($zone)
    {
    	$query = $this->db->query('select count(id) as count from  statistics order by id');
    	return $query->row()->count;
    }
    
    public function get_no_of_category($zone)
    {
    	$query = $this->db->query('select count(id) as count from  statistics_category order by id');
    	return $query->row()->count;
    }
    
    public function get_no_of_adssent($zone)
    {
    	$query = $this->db->query('select count(id) as count from  statistics_adsend order by id');
    	return $query->row()->count;
    }
    public function get_no_of_adsload($zone)
    {
    	$query = $this->db->query('select count(id) as count from  statistics_adsend order by id');
    	return $query->row()->count;
    }
    
    public function get_category_load($zone,$from_date,$to_date)
    {
    	$date_sql='';
    	if($from_date!='' && $to_date!='')
    	{
    		$date_sql=" CAST(st.date_time as DATE)<='$to_date' and CAST(st.date_time as DATE)>='$from_date' and";
    	}
    	
    	$sql = "SELECT bc.name,(SELECT COUNT(sc1.id) from statistics_category sc1 inner join statistics as st on st.id=sc1.statistics_id where".$date_sql." sc1.category_id=sc.`category_id` and sc1.zone_id='$zone') as total_hits 
    	FROM `statistics_category` sc inner join business_category bc on bc.id=sc.`category_id` inner join statistics as st on st.id=sc.statistics_id
    	 where".$date_sql." sc.`zone_id`='$zone' group by sc.`category_id`";
    	
    	$query = $this->db->query($sql);
    	return  $query->result_array();
    }
    public function get_ads_load($zone,$from_date,$to_date)
    {
    	$date_sql='';
    	if($from_date!='' && $to_date!='')
    	{
    		$date_sql=" CAST(st.date_time as DATE)<='$to_date' and CAST(st.date_time as DATE)>='$from_date' and";
    	}
    	
    	$sql = "SELECT bc.id,bc.name,(SELECT COUNT(sc1.id) from statistics_adsend sc1 inner join statistics as st on st.id=sc1.statistics_id where".$date_sql." sc1.ad_id=sc.`ad_id` and sc1.sent_id='0' and sc1.zone_id='$zone') as total_hits FROM 
    	`statistics_adsend` sc inner join ads bc on bc.id=sc.`ad_id`
    	 inner join statistics as st on st.id=sc.statistics_id
    	 where".$date_sql." sc.`zone_id`='$zone' and sc.sent_id='0' group by sc.`ad_id`";
    
    	$query = $this->db->query($sql);
    	return  $query->result_array();
    }
    public function get_ads_sent($zone,$from_date,$to_date)
    {
    	$date_sql='';
    	if($from_date!='' && $to_date!='')
    	{
    		$date_sql=" CAST(st.date_time as DATE)<='$to_date' and CAST(st.date_time as DATE)>='$from_date' and";
    	}
    	 
    	$sql = "SELECT bc.id,bc.name,sc.sent_id,(SELECT COUNT(sc1.id) from statistics_adsend sc1 inner join statistics as st on st.id=sc1.statistics_id where".$date_sql." sc1.ad_id=sc.`ad_id` and sc1.sent_id>'0' and sc1.zone_id='$zone') as total_hits FROM 
    	`statistics_adsend` sc inner join ads bc on bc.id=sc.`ad_id` 
    	inner join statistics as st on st.id=sc.statistics_id
    	 where".$date_sql." sc.`zone_id`='$zone' and sc.sent_id>'0' group by sc.`ad_id`";
    	
    
    	$query = $this->db->query($sql);
    	return  $query->result_array();
    }
    
   
    
}