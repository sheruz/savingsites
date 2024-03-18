<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class Statistics extends Model{
    var $table;
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
    } 
    
    public function get_top_level_stats($zone_id){
        $ret = new TopStats();
        $result = $this->db->query("SELECT Count(*) as AdCount ,(select Count(*) from business where id IN (select business_id from business_to_zone where zone_id = $zone_id)) as BizCount FROM `ads` WHERE business_id IN (select business_id from business_to_zone where zone_id = $zone_id)")->getResultArray();
        if(!empty($result)){
            $ret->totalAds = $result[0]['AdCount'];
            $ret->totalBusinesses = $result[0]['BizCount'];
        }
        return $ret;
    }

    public function get_most_popular_categories($zone_id, $start_date, $end_date, $max = false)
    {
        $sql = "SELECT t1.*,(select name from business_category where id = t1.category_id) as CategoryName, (select count(*) from statistics_category as t2 where t2.category_id = t1.category_id
AND t2.statistics_id IN (select id from statistics where date_time <= '$end_date' AND date_time > '$start_date')
) as ACount  FROM `statistics_category` as t1 WHERE t1.zone_id = $zone_id
AND t1.statistics_id IN (select id from statistics where date_time <= '$end_date' AND date_time > '$start_date')
group by t1.category_id
order by ACount DESC";
        if((!empty($max) && $max >=1 ))
        {
            $sql .= " limit 0,$max";
        }

        return $this->db->query($sql)->result_array();
    }

    public function get_most_popular_ads($zone_id,$start_date,$end_date, $max = false)
    {
        $sql = "SELECT t1.*,(select name from ads where id = t1.ad_id) as AdName, (select count(*) from statistics_adsend as t2 where t2.ad_id = t1.ad_id
                AND t2.statistics_id IN (select id from statistics where date_time <= '$end_date' AND date_time > '$start_date')
                ) as ACount  FROM `statistics_adsend` as t1 WHERE t1.zone_id = $zone_id
                AND t1.statistics_id IN (select id from statistics where date_time <= '$end_date' AND date_time > '$start_date')
                AND t1.sent_id > 0
                group by t1.ad_id
                order by ACount DESC";

        if((!empty($max) && $max >=1 ))
        {
            $sql .= " limit 0,$max";
        }

        return $this->db->query($sql)->result_array();
    }

    public function get_raw_hits($zone_id,$start_date,$end_date)
    {
        $sql = "SELECT count(*) as RawHits from statistics
                where date_time <= '$end_date' AND date_time > '$start_date'
                AND zone_id = $zone_id";
        return $this->db->query($sql)->result_array();
    }

    public function get_favorite_businesses_for_zone($zone_id)
    {
        $sql = "";

        return $this->db->query($sql)->result_array();
    }

    public function get_snap_businesses_for_zone($zone_id)
    {
        $sql = "SELECT t1.name, (select count(*) from business_approved where t1.id = business_id and approved = 1)
                as SNAPCount FROM `business` as t1 WHERE t1.id in (select business_id from business_to_zone where zone_id = $zone_id)";
        return $this->db->query($sql)->result_array();
    }
}

class TopStats
{
    var $totalBusinesses;
    var $totalAds;
    var $snapSubscribers;
}

