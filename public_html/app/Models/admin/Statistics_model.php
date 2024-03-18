<?php
class Statistics_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	public function get_all_zone()
	{
		$query=$this->db->query('SELECT * FROM sales_zone ORDER BY name ASC');
		return $query->result_array();
	}
	public function get_zone_wise_business($zone_id)
	{
		$query = $this->db->query("SELECT count(business_id) as count FROM business_to_zone WHERE `zone_id`=".$zone_id);
    	return $query->row()->count;
	}
	public function get_zone_adds($zone_id)
	{
		$query=$this->db->query("SELECT count(a.id) as count from business_to_zone as b LEFT JOIN ads as a ON a.business_id=b.business_id where zone_id=".$zone_id);
		return $query->row()->count;		
	}

	public function business_with_email($zone_id)
	{
		$query=$this->db->query("SELECT b.id,b.name,count(ba.id) as count FROM  business as b LEFT JOIN business_to_zone as bz ON b.id=bz.business_id LEFT JOIN business_approved as ba ON ba.business_id=b.id AND ba.approved=1 WHERE zone_id=".$zone_id." GROUP BY bz.business_id ORDER BY count DESC");
		return $query->result_array();
	}
	
	public function business_favourite($zone_id,$from_date,$to_date)
	{
		$date_sql='';
		if($from_date!='' && $to_date!='')
		{
			$date_sql=" CAST(st.date_time as DATE)<='$to_date' and CAST(st.date_time as DATE)>='$from_date' and";
		}
		$sql="select b.name,(SELECT COUNT(sc1.id) from statistics_favorites sc1 inner join statistics as st on st.id=sc1.statistics_id where ".$date_sql." 
		sc1.business_id=sf.`business_id` and sc1.zone_id='$zone_id') as total_hits from statistics_favorites as sf 
		inner join business as b on b.id=sf.business_id 
		inner join statistics as st on st.id=sf.statistics_id where ".$date_sql." sf.`zone_id`='$zone_id' group by sf.`business_id`";
		
		$query=$this->db->query($sql);
		return $query->result_array();
	}

    public function get_most_popular_ads($zone_id, $from_date, $to_date, $max = false)
    {
        $date_sql='';
        if($from_date!='' && $to_date!='')
        {
            $date_sql=" CAST(st.date_time as DATE)<='$to_date' and CAST(st.date_time as DATE)>='$from_date' and";
        }

        $sql="select a.id,a.name,a.category_id,(SELECT COUNT(sc1.id)
		from statistics_adsend sc1 inner join statistics as st on st.id=sc1.statistics_id  where ".$date_sql." sc1.ad_id=sa.`ad_id` and sc1.zone_id='$zone_id') as total_hits from ads as a
		inner join statistics_adsend as sa on sa.ad_id=a.id
		inner join statistics as st on st.id=sa.statistics_id
		where".$date_sql." sa.zone_id='$zone_id' group by sa.`ad_id` order by total_hits desc";
        if(!empty($max) && ($max > 0)){
             $sql .= "limit $max";
        }

        $query=$this->db->query($sql);
        return $query->result_array();
    }
	public function ads_populer($zone_id,$from_date,$to_date)
	{
		$date_sql='';
		if($from_date!='' && $to_date!='')
		{
			$date_sql=" CAST(st.date_time as DATE)<='$to_date' and CAST(st.date_time as DATE)>='$from_date' and";
		}
		
		$sql="select a.id,a.name,a.category_id,(SELECT COUNT(sc1.id) 
		from statistics_adsend sc1 inner join statistics as st on st.id=sc1.statistics_id  where ".$date_sql." sc1.ad_id=sa.`ad_id` and sc1.zone_id='$zone_id') as total_hits from ads as a 
		inner join statistics_adsend as sa on sa.ad_id=a.id 
		inner join statistics as st on st.id=sa.statistics_id 
		where".$date_sql." sa.zone_id='$zone_id' group by sa.`ad_id` order by total_hits desc limit 5";
		
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	 
	public function category_populer($category)
	{
		$query=$this->db->query("select id,name from business_category where id='$category'");
		return $query->row();
	}
}