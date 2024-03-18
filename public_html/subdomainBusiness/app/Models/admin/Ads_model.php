<?php
namespace App\Models\admin;

use CodeIgniter\Model;
use App\Controllers\CommonController;
use App\Controllers\CronController;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class Ads_model extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->CommonController = new CommonController();
    } 




// get userdata from tbl_member table 
  public function get_tbl_member_data($userId){

     
    $sql1 = "SELECT  tbl_member.user_id FROM users  
    LEFT JOIN tbl_member   ON users.username = tbl_member.user_name  
     WHERE  users.id=".$userId;
    

        $query2 = $this->db->query($sql1); 

        $row =$query2->row();

        return $row;
     

    }


    public function get_ad_id_from_deal_title($deal_title='')

    {

        $sql="SELECT id FROM  ads WHERE deal_title='$deal_title'";

        $query = $this->db->query($sql);

        $row=$query->row();

        return $row;

    }

    public function movers_details($phonearr='')

    {

        $phonelist = implode(',',$phonearr);

       $sql = "SELECT * FROM movers_details WHERE phone_number IN (".$phonelist.")";

        $query = $this->db->query($sql);

        $result = $query->result_array();

        if (!empty($result)){

            return $result;

        }else{

        return 0;

    }

    return $result;

    }

    public function check_business($userId='')

    {

        $sql = "select * from pbg_zips where business_id = ".$userId;

        $query = $this->db->query($sql);

        $result = $query->num_rows();

        return $result;
 
    }

    public function add_new_mover_credit($username='',$email='')

    {

        $sql = "UPDATE tbl_member SET balance = balance + 10 WHERE `user_name`= '".$username."' AND `email`= '".$email."';";

        $query = $this->db->query($sql);

        //return $sql;

    }

    public function mover_got_credit($createdby_id='',$user_id='')

    {

        $sql_option="select * from user_offer_status where user_id = '".$user_id."' and createdby_id = '".$createdby_id."' and new_movers_get_credit ='y' ";        
        $query_option=$this->db->query($sql_option);

        $result = $query_option->num_rows();

        return $result;

    }

    public function get_ads_from_id($adId, $zone = false)

    {

        $sql = "select t1.*,t1.id as ad_id,t2.id as bj_id, t2.name as biz_name, t2.website, t2.contactemail as email, t3.*,t4.timezone as timezone, t6.name as categroy, 

        t5.name as business_type from ads as t1 join business as t2 on t1.business_id = t2.id

        join address as t3 on t2.addressid = t3.id join zipcode as t4 on t4.zip = t3.zip_code join business_category as t6 on t6.id = t1.category_id 

        join business_type as t5 on t5.id = t6.business_type_id 

        where t1.active = 1 AND

        t1.id = $adId";

        if(!empty($zone)){

            $sql .= " AND t2.id in (select business_id from business_to_zone where zone_id = $zone)";

        }

        $query = $this->db->query($sql);

        $result = $query->result_array();

        $newresult = array();

    

        foreach ($result as $result1){

    

            date_default_timezone_set($result1['timezone']);

            $date = new DateTime();

            $interval = new DateInterval('PT1H');

    

            $date->add($interval);

            $today =  $date->format('Y-m-d H:i:s');

            $inow = strtotime($today);

    

            $inow_time =  $date->format('h:i a');

            $inow_time = convert_to_number($inow_time);

            

            if($result1['startdatetime']!='0000-00-00 00:00:00' && $result1['stopdatetime']!='0000-00-00 00:00:00')

            {

                if(strtotime($result1['startdatetime']) <= $inow && strtotime($result1['stopdatetime']) >= $inow){

                    $newresult[]=$result1;

                }

            }else{

                if($result1['starttime'] <= $inow_time && $result1['stoptime'] >= $inow_time){

                    $newresult[]=$result1;

                }

            }           

        }    

        return $newresult;

    }

    public function get_ads_for_category($category, $zone = false)

    {

        //echo 1;

        date_default_timezone_set('EST');

        $date = new DateTime();



        $interval = new DateInterval('PT1H');

        $date->add($interval);

        $inow =  $date->format('Y-m-d H:i:s');

        $inow = strtotime($inow);

        

        $inow_time =  $date->format('h:i a');

        $inow_time = convert_to_number($inow_time);

        $sql = "select t1.*,t1.id as ad_id,t2.id as bj_id, t2.name as biz_name, t2.website, t2.contactemail as email, t3.* from ads as t1

      join business as t2 on t1.business_id = t2.id

      join address as t3 on t2.addressid = t3.id

      where t1.active = 1 AND

      t1.categoryid = $category ";

        $query = $this->db->query($sql);

        $result = $query->result_array();

        return $result;

    }



    public function get_ads($ad_filter)



    {



        $user = $this->ion_auth->user()->row();



        $uid = $user->id;



        switch ($ad_filter) { 



            case "Tier I":



                { 



                    $sql = "select t1.*, t2.name as biz_name, t2.contactfirstname, t2.contactlastname, t2.contactemail from ads as t1 inner join business as t2 on t1.business_id = t2.id where t1.active = 1";



                    break;



                }



            case "Tier II":



                {



                //zone owner



                $sql = "select t1.*, t2.name as biz_name, t2.contactfirstname, t2.contactlastname, t2.contactemail from ads as t1



                        inner join business as t2 on



                        t1.business_id = t2.id



                        where t1.active = 1 and t1.business_id in (select business_id from



                        business_to_zone where zone_id IN (select id from



                        sales_zone where sales_rep_id = " . $uid . "))";



                break;



                }



            case "Tier III":



                {



                //business owner



                $sql = "select t1.*, t2.name as biz_name, t2.contactfirstname, t2.contactlastname, t2.contactemail from ads as t1



                        inner join business as t2 on



                        t1.business_id = t2.id



                        where t1.active = 1 and t2.business_owner_id = " . $uid;

                //echo $sql;



                break;



                }



        }

        if(empty($sql)){ return array();}

        $sql = $sql . " ";

        $query = $this->db->query($sql);

        return $query->result_array();

    }

    

    function add_favorites($data = array()){

        if($data){

            $this->db->insert('users_favorites', $data);

            return $this->db->insert_id();

        }

    }

    

    function delete_favorites($data = array()){

        if($data){

            $this->db->delete('users_favorites', $data);

            return true;

        }

    }

    

    function get_favorites_ads_ids($user_id, $format = 'object'){

        $output_ids = array();

        $query = $this->db->get_where('users_favorites', array('user_id' => $user_id));

        $output_ids = $query->result();

        

        if($format == 'array'){

            $output_ids_array = array();

            foreach($output_ids as $item){

                $output_ids_array[] = $item->adid;

            }

            return $output_ids_array;

        }

        

        return $output_ids;

    }

    

    function get_favorites_ads($user_id, $favorites_ads_ids, $zone = false){

        date_default_timezone_set('EST');

        $date = new DateTime();

        $interval = new DateInterval('PT1H');



        $date->add($interval);

        $inow =  $date->format('Y-m-d H:i:s');

        

        $inow = strtotime($inow);

        

        $inow_time =  $date->format('h:i a');

        $inow_time = convert_to_number($inow_time);

        $sql = "select t1.*,t1.id as ad_id, t2.name as biz_name, t2.website, t2.contactemail as email, t3.* from ads as t1 join business as t2 on t1.business_id = t2.id

        join address as t3 on t2.addressid = t3.id

        where t1.active = 1 AND

        t1.id in ( $favorites_ads_ids )";

        if(!empty($zone)){

            $sql .= " AND t2.id in (select business_id from business_to_zone where zone_id = $zone)";

        }

        $query = $this->db->query($sql);

        $result = $query->result_array();

        

        $newresult = array();

        foreach ($result as $result1)

        {

            if($result1['startdatetime']!='0000-00-00 00:00:00' && $result1['stopdatetime']!='0000-00-00 00:00:00')

            {

                if(strtotime($result1['startdatetime']) <= $inow && strtotime($result1['stopdatetime']) >= $inow){

                    $newresult[]=$result1;

                }

            }else{

                if($result1['starttime'] <= $inow_time && $result1['stoptime'] >= $inow_time){

                    $newresult[]=$result1;

                }

            }

        }

        return $newresult;

    }

    public function ad_to_favourites($ad_id, $user_id=false,$zone_id = 0, $status = ''){
        $sql_option="select favorites_id from users_favorites where user_id = $user_id and adid = $ad_id";        
                
        $data = $this->CommonController->SelectRawquery($sql_option,'resultArray');
        $arr = ['user_id' =>$user_id,'adid' => $ad_id,'zoneid' => $zone_id];
        if(count($data) > 0){
            $this->CommonController->deleteData('users_favorites',$arr);
        }else{
            $this->CommonController->InsertData('users_favorites', $arr);
        }
        return 1;
    }

    function get_ad_to_favourites($ad_id, $user_id=false)

    {

        $sql_option="select favorites_id from users_favorites where adid = $ad_id and user_id = $user_id";

        $query_option=$this->db->query($sql_option);

        if($query_option->row())

        {

            return $query_option->row()->favorites_id;

        }else{

            return '';

        }

    }

    function change_status_type($busid=0, $user_id=0, $status=1, $zone_id=0,$from=''){

        if($from=='newsletter'){

            $table='newsletter_approved';

        }

        $sql="select id from ".$table." where business_id = $busid and user_id = $user_id and zoneid=$zone_id";

        $query=$this->db->query($sql);

        $cnt = $query->num_rows(); 

        $data=array();

        $data['business_id']=$busid;

        $data['user_id']=$user_id;      

        $data['zoneid']=$zone_id;

        if($cnt==0){

            $data['approved']=$status;          

            $this->db->insert($table, $data);

        }/*else{                    

            $this->db->delete($table, $data);

        }*/

        

    }

    // this function currently not used

    function business_approved($bus_id, $user_id, $status, $zone,$from_where)

    {

        if($from_where=='snap'){

            $table='business_approved';

        }else if($from_where=='newsletter'){

            $table='newsletter_approved';

        }

        $sql_option="select id from ".$table." where business_id = $bus_id and user_id = $user_id and zoneid=$zone";

        $query_option=$this->db->query($sql_option);

        

        

        $data['business_id']=$bus_id;

        $data['user_id']=$user_id;

        $data['approved']=$status;

        $data['zoneid']=$zone;

        

        

        if($query_option->row())

        {

            $this->db->where('business_id', $bus_id);

            $this->db->where('user_id', $user_id);

            $this->db->where('zoneid', $zone);

            $this->db->update($table, $data);

        }

        else

        {

            $this->db->insert($table, $data);

        }

    }

    

    function get_business_approved($bj_id=0, $user_id=0)

    {

        $sql_option="select approved from business_approved where business_id = $bj_id and user_id = $user_id";

        $query_option=$this->db->query($sql_option);

        if($query_option->row())

        {

            return $query_option->row()->approved;

        }else{

            return false;

        }

    }
    
    public function get_offer_status_check($id=0, $user_id=0,$type=0,$zone_id = 0,$adid = 0){
        $status = 0;
        if($adid > 0){
            $sql_option="select status from user_offer_status where createdby_id = $id and user_id = $user_id and type=$type and adid=$adid";
        }else{
            $sql_option="select status from user_offer_status where createdby_id = $id and user_id = $user_id and type=$type";
        }
        $res = $this->CommonController->SelectRawquery($sql_option, 'resultArray');

        if(count($res) > 0){
            return $res[0]['status'];
        }else{
            $sqlGlobalSettingsQuery = "SELECT status FROM global_snap_settings WHERE user_id = ".$user_id." AND created_for_zone = ".$zone_id;
            $res = $this->CommonController->SelectRawquery($sqlGlobalSettingsQuery, 'row');
            if($res) {
                $status = $res->status;
            }
        }
        return $status;
    }

    

    function get_newsletter_approved($bj_id=0, $user_id=0)

    {

        $sql_option="select approved from newsletter_approved where business_id = $bj_id and user_id = $user_id";

        $query_option=$this->db->query($sql_option);

        if($query_option->row())

        {

            return $query_option->row()->approved;

        }else{

            return false;

        }

    }

    function get_favourite_business($ad_id)

    {

        $sql="select business_id from ads where id='".$ad_id."'";

        $query = $this->db->query($sql);

        return $query->row()->business_id;

    }

    

    function remove_favourite_business($zone_id,$ad_id,$user_id)

    {

        $sql = "delete from statistics_favorites WHERE ad_id ='".$ad_id."' and user_id='".$user_id."' and zone_id='".$zone_id."'";

        $this->db->query($sql) ;

    }

    

     public function get_ads_for_all($zone = false)

    {

        date_default_timezone_set('EST');

        $date = new DateTime();

        $interval = new DateInterval('PT1H');

    

        $date->add($interval);

        $inow =  $date->format('Y-m-d H:i:s');

        

        $inow = strtotime($inow);

        

        $inow_time =  $date->format('h:i a');

        $inow_time = convert_to_number($inow_time);

        $sql = "select t1.*,t1.id as ad_id,t2.id as bj_id, t2.name as biz_name, t2.website, t2.contactemail as email, t3.* from ads as t1 join business as t2 on t1.business_id = t2.id

        join address as t3 on t2.addressid = t3.id

        where t1.active = 1 ";

        

        if(!empty($zone)){

            $sql .= " AND t2.id in (select business_id from business_to_zone where zone_id = $zone)";

        }

    

        $sql .= " order by t1.last_update DESC";

        $query = $this->db->query($sql);

        $result = $query->result_array();

        

        $newresult = array();

        foreach ($result as $result1)

        {

            if($result1['startdatetime']!='0000-00-00 00:00:00' && $result1['stopdatetime']!='0000-00-00 00:00:00')

            {

                if(strtotime($result1['startdatetime']) <= $inow && strtotime($result1['stopdatetime']) >= $inow){

                    $newresult[]=$result1;

                }

            }else{

                if($result1['starttime'] <= $inow_time && $result1['stoptime'] >= $inow_time){

                    $newresult[]=$result1;

                }

            }

        }

        return $newresult;

        

    }

    

    function check_user_register($user_id)

    {

        $sql="select * from user_paypal where user_id='".$user_id."'";

        $query = $this->db->query($sql);

        return $query->row();

    }

    public function getResturentUser($businessId){

        $businessId = (int)$businessId;

        $sql = "SELECT

                    a.id

                FROM

                    restaurantbooking_users a

                WHERE

                    a.business_id=".$businessId;

        $query = $this->db->query($sql);

        return $query->row();

    }

    /**

      * @desc method to check if a business registered in time slot booking project

      * @param $businessId

      * @return boolean

    */

    public function getTimeSlotBookingStatus($ssId,$ssFrom) {

        $sql = "SELECT

                    id

                FROM

                    ts_booking_users

                WHERE

                    ss_id = ".$ssId."

                AND

                    ss_from_where = ".$ssFrom;

        $query = $this->db->query($sql);

        $result = $query->row();

        $status = false;

        if(count($result) > 0) {

            $status = true;

        }

        return $status;

    }

### Athena eSolutions start

    // this function is calling from dashboards.php in saveAd function --- 01.12.2012

    // this function is use for insert the ad into ad_to_zone table with respective zone. 

    function ads_save_zone($business_id='',$adid=''){

        $sql_select_ad_zone="SELECT settingszoneid,isdefault FROM ads_setting_preferences WHERE businessid=".$business_id;

        $query_sql_select_ad_zone = $this->db->query($sql_select_ad_zone);

        

        $query=$query_sql_select_ad_zone->result_array();

        $newdata=array();

        if(!empty($query)){

            foreach($query as $x){

                $newdata['adid'] = $adid;

                $newdata['zoneid'] = $x['settingszoneid'];      

                

                $sql_zone_pref="SELECT * FROM zone_preferences WHERE zoneid=".$x['settingszoneid'];

                $query_1 = $this->db->query($sql_zone_pref);

                $query=$query_1->result_array();

                if(!empty($query)){

                    

                    if($query[0]['autoapprove_newadd']==1){ // ads advertising in your zone

                        $newdata['approval'] = 1;

                    } else if($query[0]['autoapprove_newadd']==0){                      

                        if($x['isdefault']==0){

                            $newdata['approval'] = 0;

                        }else{

                            $newdata['approval'] = 0;

                        }

                    }

                    if($query[0]['autoapprovenewadd_business']==0){ // ads located in your zone

                        if($x['isdefault']==1){

                            $newdata['approval'] = 1;

                        }else{

                            $newdata['approval'] = 0;

                        }

                    }else if($query[0]['autoapprovenewadd_business']==1){

                        $newdata['approval'] = 1;

                    }

                }

                $this->db->insert('ad_to_zone', $newdata);              

            }

        }

    }

    function save_business_approval($id='',$zone_id='',$businesstype='',$grid=''){

        

        if($usertype==5){ // i.e, created by business owner                 

            $arr_zonepref=$this->getZonePpreferencesByZone($zone_id);

            

        }else{ // i.e, created by zone owner

            if($businesstype==1){ // i.e, Paid Business

                $data['approval']=1;

                $data['isdefault'] = 1;

            }else if($businesstype==2){ // i.e, Trial Business

                $data['approval']=2;

                $data['isdefault'] = 1;

            }else if($businesstype==3){ // i.e, Listed Business

                $data['approval']=3;

                $data['isdefault'] = 0;

            }

        }

        $data['businessid'] = $id;

        $data['settingszoneid'] = $zoneid;      

        $this->db->insert('ads_setting_preferences', $data);

    }

    function ads_save_zonetofromzone($zoneid='',$business_id='',$adid='',$from=''){

        $data['adid']=$adid;

        $data['zoneid']=$zoneid;

        if($from=='from_zone'){

            $data['approval']=1;

        }else{

            $arr_adsettingspref=$this->getAdSettingsPref($zoneid,$business_id);

            $arr_zonepref=$this->getZonePpreferencesByZone($zoneid); 

            

            if($arr_adsettingspref['isdefault']==1){

                if($arr_adsettingspref['approval']==1){

                    if($arr_zonepref['auto_approve_paid_ad_myzone']==1){

                        $data['approval']=1;

                    }else if($arr_zonepref['auto_approve_paid_ad_myzone']==0){

                        //check is specific business mathced with this business id

                        $matched=strpos(','.$arr_zonepref['auto_approve_paid_specific_ad_myzone'].',',','.$business_id.',');

                        if($matched!==false){

                            $data['approval']=1;

                        }else{

                            $data['approval']=0;

                        }

                    }

                }else if($arr_adsettingspref['approval']==2){

                    if($arr_zonepref['auto_approve_trial_ad_myzone']==1){

                        $data['approval']=1;

                    }else if($arr_zonepref['auto_approve_trial_ad_myzone']==0){

                        //check is specific business mathced with this business id

                        $matched=strpos(','.$arr_zonepref['auto_approve_trial_specific_ad_myzone'].',',','.$business_id.',');

                        if($matched!==false){

                            $data['approval']=1;

                        }else{

                            $data['approval']=0;

                        }

                    }

                }else{

                    $data['approval']=0;

                }

            }   

            else if($arr_adsettingspref['isdefault']==0){

                if($arr_adsettingspref['approval']==1){

                    if($arr_zonepref['auto_approve_paid_ad_locatedmyzone']==1){

                        $data['approval']=1;

                    }else if($arr_zonepref['auto_approve_paid_ad_locatedmyzone']==0){

                        //check is specific business mathced with this business id

                        $matched=strpos(','.$arr_zonepref['auto_approve_paid_specific_ad_locatedmyzone'].',',','.$business_id.',');

                        if($matched!==false){

                            $data['approval']=1;

                        }else{

                            $data['approval']=0;

                        }

                    }

                }else if($arr_adsettingspref['approval']==2){

                    if($arr_zonepref['auto_approve_trial_ad_locatedmyzone']==1){

                        $data['approval']=1;

                    }else if($arr_zonepref['auto_approve_trial_ad_locatedmyzone']==0){

                        //check is specific business mathced with this business id

                        $matched=strpos(','.$arr_zonepref['auto_approve_trial_specific_ad_locatedmyzone'].',',','.$business_id.',');

                        if($matched!==false){

                            $data['approval']=1;

                        }else{

                            $data['approval']=0;

                        }

                    }

                }else{

                    $data['approval']=0;

                }

            }

        }

        $this->db->insert('ad_to_zone',$data);

    }
    
    public function ads_save_zonefrombusiness($business_id='',$adid='',$where_from='',$fromzoneid=0,$subcategory_id = 0){ 
        $zones=$this->getZonesAsscocitedToBusiness($business_id);
        if(!empty($zones)){
            foreach($zones as $a){
                $zoneid=$a['settingszoneid'];
                $arr_adsettingspref=$this->getAdSettingsPref($zoneid,$business_id);
                $arr_zonepref=$this->getZonePpreferencesByZone($zoneid);   
                $data['adid']=$adid;        
                $data['zoneid']=$zoneid;    
                if($fromzoneid!='0'){
                    $sql = "SELECT approval from ads_setting_preferences where businessid =".$business_id;
                    $result = $this->CommonController->SelectRawquery($sql,'resultArray');
                    if($result[0]['approval'] < 0){
                        $data['approval']=-1;
                    }else{
                        $data['approval']=1;            
                        $subcategory_id_arr=explode(',',$subcategory_id);
                        foreach($subcategory_id_arr as $_x){
                            $subcatid = $_x;
                            $cat_subcat_ad_sql = "select a.subcatid,a.adid from ad_category_subcategory a, ad_to_zone b,ads c where a.adid=b.adid and a.adid=c.id and b.approval='1' and a.adid=c.id and c.business_id='$business_id'";
                            $cat_subcat_ad = $this->CommonController->SelectRawquery($cat_subcat_ad_sql,'resultArray');
                            foreach ($cat_subcat_ad as $approval_ads){
                                $subcategory_id_exists =$approval_ads['subcatid'];
                                if($subcategory_id_exists == $subcatid){
                                    // $data['approval'] =  -1;  
                                    $data['approval'] =  1;  
                                    break;
                                }
                            } 
                        }
                    }
                }else if($fromzoneid=='0'){
                    if($arr_adsettingspref['isdefault']==1){  
                        if($arr_adsettingspref['approval'] > 0){
                            $data['approval']=1;
                            $subcategory_id_arr=explode(',',$subcategory_id);
                            foreach($subcategory_id_arr as $_x){
                                $a=explode('!@#',$_x);
                                $subcatid = $a['2'];  
                                $cat_subcat_ad_sql = "select a.subcatid,a.adid from ad_category_subcategory a, ad_to_zone b,ads c where a.adid=b.adid and a.adid=c.id and b.approval='1' and a.adid=c.id and c.business_id='$business_id'";
                                $cat_subcat_ad = $this->CommonController->SelectRawquery($cat_subcat_ad_sql,'resultArray');
                                foreach ($cat_subcat_ad as $approval_ads){
                                    $subcategory_id_exists =$approval_ads['subcatid'];
                                    if($subcategory_id_exists == $subcatid){
                                        // $data['approval'] =  -1;  
                                        $data['approval'] =  1;  
                                        break;
                                    }
                                }
                            }
                        }else{
                            $data['approval']=-1;
                        }
                    }else if($arr_adsettingspref['isdefault']==0){  
                        if($arr_adsettingspref['approval'] > 0){
                            $data['approval']=1;
                        }else{
                            $data['approval']=-1;
                        }
                    }
                }
                $query1 = 'SELECT id FROM ad_to_zone WHERE adid='.$adid.' AND zoneid='.$zoneid;
                $r = $this->CommonController->SelectRawquery($query1,'resultArray');
                if(count($r) <= 0){
                    $this->CommonController->InsertData('ad_to_zone', $data);
                }else{
                    $this->CommonController->updateData('ad_to_zone',$data,['adid'=> $adid]);
                }
                unset($arr_adsettingspref);
                unset($arr_zonepref);
            }
        }
    }

    

    public function get_reason_for_ad($selectid='',$zoneId='',$businessId='',$adid=''){

        $sql_reason="SELECT reason FROM ads_edit_info WHERE adid=".$adid." AND usertype=6 ORDER BY id DESC LIMIT 0,1";

        $query_reason=$this->db->query($sql_reason);

        $result_reason = $query_reason->num_rows();

        if($result_reason >'0'){

            return $query_reason->result_array();

        }

    }

    //  For Old Zone Dashboard Ads

    public function get_ads_in_zone_for_approve($selectid='',$zoneId='',$businessId='',$charval='',$lowerlimit='',$upperlimit='')

    { 

        //var_dump($selectid);   //exit;

        $limit_where="";    

        $business_where = "" ;

        $selected_where = "" ;

        if($lowerlimit!='' && $upperlimit!=''){

            $limit_where=" limit ".$lowerlimit.",".$upperlimit;

        }else{

            $limit_where="";

        }

        if(trim($businessId) != "all"){

            $business_where = " AND c.id IN (".str_replace('-',',',$businessId).")";    // This portion must appear for particular business ads

            //!empty($business_where) ? " AND c.id IN (".str_replace('-',',',$businessId).")" : '';  // Added !empty() on 21/6/14 for database error on 649 line.

            $selected_where = " AND a.approval IN (".$selectid.",2)";

        

        $sql="SELECT a.adid,a.approval,a.stickyad,b.*,c.name as busname,d.last_name,d.first_name,d.username from ad_to_zone a,ads b,business c,users d WHERE a.adid=b.id AND b.business_id=c.id AND c.business_owner_id=d.id AND a.zoneid=".$zoneId.$selected_where.$business_where."ORDER BY b.timestamp DESC".$limit_where;

        $query= $this->db->query($sql);             

        $result=$query->result_array();

        }else{

            $result='';

        }

        return $result;

    }

    

    # + ads for zone by ad category type 

    public function get_ads_in_zone_by_ad_category($selectid='',$zoneId='',$businessId='',$charval='',$lowerlimit='',$upperlimit='',$ad_categorytype='')

    { 

        $limit_where="";    

        $business_where = "" ;

        $selected_where = "" ;

        $wh_type = "" ;

        if($lowerlimit!='' && $upperlimit!=''){

            $limit_where=" limit ".$lowerlimit.",".$upperlimit;

        }else{

            $limit_where="";

        }

        if($ad_categorytype!='' && $ad_categorytype == 0){      // For Non temp ads

            $wh_type=" and e.catid!='-99' and e.subcatid!='-99' and f.type=1";

        }

        else if($ad_categorytype!='' && $ad_categorytype == 1){ // For temp ads

            $wh_type=" and e.catid='-99' and e.subcatid='-99'";

        }

        else if($ad_categorytype!='' && $ad_categorytype == 2){ // For franchisee ads

            $wh_type=" and e.catid='14' and f.type=2";

        }

        

        

        if(trim($businessId) != "all"){

            $business_where = " AND c.id IN (".str_replace('-',',',$businessId).")";    // This portion must appear for particular business ads

            //!empty($business_where) ? " AND c.id IN (".str_replace('-',',',$businessId).")" : '';  // Added !empty() on 21/6/14 for database error on 649 line.

            $selected_where = " AND a.approval IN (".$selectid.",2)";

        

        $sql="SELECT a.adid,a.approval,a.stickyad,b.*,c.name as busname,d.last_name,d.first_name,d.username 

        FROM ad_to_zone a,ads b,business c,users d,ad_category_subcategory e, ads_setting_preferences f 

        WHERE a.adid=b.id AND 

        f.businessid=c.id AND

        b.business_id=c.id AND 

        b.id = e.adid AND 

        c.business_owner_id=d.id AND 

        a.zoneid=".$zoneId.$selected_where.$business_where.$wh_type." GROUP BY a.adid ORDER BY b.timestamp DESC".$limit_where; 

        $query= $this->db->query($sql);             

        $result=$query->result_array(); 

        $i=0;

            foreach($result as $arr){   // for cat name and subcat name on zone ads view

                $sql_cat_subcat = "SELECT a.name as catname, b.name as subcatname FROM  category_new a, category_sub_subcategory_new b, ad_category_subcategory c WHERE

                a.id = c.catid AND 

                b.id = c.subcatid AND 

                c.adid = ".$arr['adid']." LIMIT 1" ;

                $cat_subcat_result = $this->db->query($sql_cat_subcat);

                $query_cst_subcat = $cat_subcat_result->result_array();

                $result[$i]['catname'] = $query_cst_subcat[0]['catname'] ;

                $result[$i]['subcatname'] = $query_cst_subcat[0]['subcatname'] ;

                $i++;

            }

        }else{

            $result='';

        }

        

        return $result;

    }

    # - ads for zone by ad category type 

    

    function all_ads_status_change($businessid='',$status=''){

        if($status==1)

            $ups_status=-1;

        else if($status==-1)

            $ups_status=1;

        $this->db->query("SET SESSION group_concat_max_len=10000000000000") ;

        $sql_ad="SELECT group_concat(a.id) as adid from ads a, ad_to_zone b where a.business_id=".$businessid." AND a.id=b.adid and b.approval=".$status; 

        $query_ad=$this->db->query($sql_ad);

        $result_ad=$query_ad->result_array(); 

        if(!empty($result_ad)){

            $all_ad_ids= $result_ad[0]['adid']; 

        }

        if($all_ad_ids!=''){                        

            $ups="UPDATE ad_to_zone SET approval=".$ups_status." WHERE adid IN (".$all_ad_ids.")"; 

            $this->db->query($ups) ;            

        }

    }

    

    # + Change ads status for zone

    public function fn_ads_status_change($adid, $zoneid, $action_performed, $change_ads_status, $allorspecific, $ads_type, $businessid){

        if($action_performed == 1 && $allorspecific == 1){ // For specific advertisements

                $sql="UPDATE ad_to_zone SET approval = ".$change_ads_status." WHERE adid IN (". $adid.") AND zoneid = ".$zoneid;

                $this->db->query($sql); 

            

            return $adid;   

            

        }else if($action_performed == 1 && $allorspecific == 2){  // For all advertisements

                $sql_approval_list = "SELECT group_concat(b.adid) as adsid FROM ads a, ad_to_zone b WHERE a.id = b.adid AND a.business_id = ".$businessid;

                $result = $this->db->query($sql_approval_list);

                $ids_to_update = $result->result_array();

                $sql="UPDATE ad_to_zone SET approval = ".$change_ads_status." WHERE adid IN (". $ids_to_update[0]['adsid'].") AND zoneid = ".$zoneid;

                $this->db->query($sql);

                

        return 'all';

                    

        }

    }

    # - Change ads status for zone  

    

    # + Delete ads for zone     

    public function fn_ads_delete($adid, $zoneid, $action_performed, $change_ads_status, $allorspecific, $ads_type, $businessid){

        if($action_performed == 2 && $allorspecific == 1){ // For specific advertisements

            

            $check_adid = explode(',',$adid); $adid_other_zone = ''; $adid_same_zone = '';

            foreach($check_adid as $val){

                $query = $this->db->query("SELECT * FROM `ad_to_zone` WHERE adid =".$val);

                if($query->num_rows() > 1){

                    $adid_other_zone .= $val.',';

                }

                else{

                    $adid_same_zone .= $val.',';

                }

            }

            $adid_other_zone = rtrim($adid_other_zone,','); // not needed

            $adid_same_zone = rtrim($adid_same_zone,',');

            //var_dump($adid_other_zone,$adid_same_zone);

            //exit;

            if($adid_same_zone != ''){

                $sql_ads = "DELETE FROM ads WHERE id IN (".$adid_same_zone.") AND business_id=".$businessid ;   // Delete from ads table

                $this->db->query($sql_ads);

            



                $sql_cat_subcat = "DELETE FROM `ad_category_subcategory` WHERE adid IN (".$adid_same_zone.") "; // Delete from ad_category_subcategory

                $this->db->query($sql_cat_subcat);  

            }   

        

            $sql_ads_to_zone = "DELETE FROM ad_to_zone WHERE adid IN (".$adid.") AND zoneid=".$zoneid ; // Delete from ad_to_zone table

            $this->db->query($sql_ads_to_zone);

            

            return $adid;   

            



        }else if($action_performed == 2 && $allorspecific == 2){ // For all advertisements

            $result = $this->db->query("SELECT group_concat(b.adid) as adsid FROM ads a, ad_to_zone b WHERE a.id = b.adid AND b.approval=$ads_type AND a.business_id = ".$businessid);

            $ids_to_delete = $result->result_array();

            $check_adid = explode(',',$ids_to_delete[0]['adsid']); $adid_other_zone = ''; $adid_same_zone = '';

            

            foreach($check_adid as $val){

                $query = $this->db->query("SELECT * FROM `ad_to_zone` WHERE adid =".$val);

                if($query->num_rows() > 1){

                    $adid_other_zone .= $val.',';

                }

                else{

                    $adid_same_zone .= $val.',';

                }

            }

            $adid_other_zone = rtrim($adid_other_zone,','); // not needed

            $adid_same_zone = rtrim($adid_same_zone,',');

            //var_dump($adid_other_zone,$adid_same_zone);

            //exit;

            if($adid_same_zone != ''){

                $sql_ads = "DELETE FROM ads WHERE id IN (".$adid_same_zone.") AND business_id=".$businessid ;   // Delete from ads table

                $this->db->query($sql_ads); 

                

                $sql_cat_subcat = "DELETE FROM `ad_category_subcategory` WHERE adid IN (".$adid_same_zone.") "; // Delete from ad_category_subcategory

                $this->db->query($sql_cat_subcat);

            }

            $sql_ads_to_zone = "DELETE FROM ad_to_zone WHERE adid IN (".$ids_to_delete[0]['adsid'].") AND zoneid=".$zoneid ;    // Delete from ad_to_zone table

            $this->db->query($sql_ads_to_zone);

                

            return 'all';

                    

        }

    }



    # - Delete ads for zone     

    

    public function edit_ads_in_zone_for_approve($adid,$zoneId,$selectid,$businessId){

        $data = array('approval' => $selectid);

        $this->db->where('adid', $adid);

        $this->db->where('zoneid', $zoneId);

        $this->db->update('ad_to_zone', $data);

    }

    

    function edit_sticky_ads_in_zone_for_approve($adid,$zoneId,$selectid,$businessId){

        $data = array('stickyad' => $selectid);

        $this->db->where('adid', $adid);

        $this->db->where('zoneid', $zoneId);

        $this->db->update('ad_to_zone', $data);

    }

    

    public function delete_ads_in_zone_for_approve($adid,$zoneId){

        

        $sql="select id from ad_to_zone where adid=".$adid;

        $query_sel=$this->db->query($sql);

        $result_sel = $query_sel->num_rows();

        if($result_sel==1){

            $data1 = array();

            $data1['id'] = $adid;                   

            $this->db->delete('ads', $data1);

        }

        $data = array();

        $data['adid'] = $adid;

        $data['zoneid'] = $zoneId;                      

        $this->db->delete('ad_to_zone', $data);

        $this->db->delete('ad_category_subcategory',$data);

    }

    

    function delete_ads_in_zone_for_delete($adid,$zoneId){

        $explode_value=explode(',',$adid);

        for($i=0;$i<count($explode_value);$i++){

            $val[$i]=$explode_value[$i];

            $data = array();

            $data['adid'] = $val[$i];

            $data['zoneid'] = $zoneId;                      

            $this->db->delete('ad_to_zone', $data);

        }

    }
    
    public function get_activated_zones_ad($adid){
        $sql="SELECT b.name,b.id FROM ad_to_zone a,sales_zone b WHERE a.zoneid=b.id AND a.approval=1";
        $query= $this->db->query($sql);     
        return $query->result_array();
    }
    
    public function get_ads_for_business($id='',$uid='',$lowerlimit='',$upperlimit='') {
        $limit_where="";
        $i=0;       
        if($lowerlimit!='' && $upperlimit!=''){     
            $limit_where=" limit ".$lowerlimit.",".$upperlimit;
        }
        
        $sql="SELECT * FROM ads WHERE business_id=".$id." ORDER BY timestamp DESC".$limit_where;
        $result = $this->CommonController->SelectRawquery($sql,'resultArray');
        
        foreach($result as $arr_ads) {
            $activatedzones = $deactivatedzones = $pendingzones = "" ;
            $sql="SELECT a.id,a.approval,b.name FROM ad_to_zone a,sales_zone b WHERE a.zoneid=b.id  AND a.adid=".$arr_ads['id'];
            $result_inner = $this->CommonController->SelectRawquery($sql,'resultArray');
            
            foreach($result_inner as $arr_ad_to_zone_sales_zone) {
                if($arr_ad_to_zone_sales_zone['approval']==1){
                    $activatedzones.= $arr_ad_to_zone_sales_zone['name'].", " ;
                }else if($arr_ad_to_zone_sales_zone['approval']==0){
                    $pendingzones.= $arr_ad_to_zone_sales_zone['name'].", " ;
                }else if($arr_ad_to_zone_sales_zone['approval']==-1){
                    $deactivatedzones.= $arr_ad_to_zone_sales_zone['name'].", " ;
                }
            }

            $activatedzones = ($activatedzones != "") ? substr($activatedzones,0,strlen($activatedzones)-2) : "-" ;
            $deactivatedzones = ($deactivatedzones != "") ? substr($deactivatedzones,0,strlen($deactivatedzones)-2) : "-" ;
            $pendingzones = ($pendingzones != "") ? substr($pendingzones,0,strlen($pendingzones)-2) : "-" ;
            
            $result[$i]['activatedzone'] = $activatedzones ;
            $result[$i]['pendingdzone'] = $pendingzones ;
            $result[$i]['deactivatedzone'] = $deactivatedzones ;
            $sql_reason="SELECT reason,usertype FROM ads_edit_info WHERE adid=".$arr_ads['id']." AND usertype=5 ORDER BY id DESC LIMIT 0,1";
            $result_1 = $this->CommonController->SelectRawquery($sql_reason,'resultArray');
            
            if(count($result_1) >'0'){
                foreach ($result_1 as $result1){                    
                    $result[$i]['reason']=$result1['reason'];                   
                }
            }
            $i++;
        }
        return $result;
    }
    
    public function get_ads_for_business_new($id='',$uid='',$lowerlimit='',$upperlimit='',$approval='',$busname='',$insert_via_csv = 0,$datasubusername = '',$datasubuserzipcodesassign = ''){
        $limit_where="";
        $i=0;       
        if($lowerlimit!='' && $upperlimit!=''){    
            $limit_where=" limit ".$lowerlimit.",".$upperlimit;
        }
        if($datasubusername != '' && $datasubuserzipcodesassign != ''){
            $sql="SELECT a.* FROM ads a, ad_to_zone b,ad_category_subcategory c, business as d, address as e WHERE a.id = b.adid AND a.id=c.adid AND a.business_id=".$id." AND b.approval = ".$approval." AND c.catid!='-99' AND d.id=a.business_id AND d.addressid=e.id AND e.zip_code IN (".$datasubuserzipcodesassign.") GROUP BY a.id ORDER BY a.timestamp DESC".$limit_where;
        }else{
            $sql="SELECT a.* FROM ads a, ad_to_zone b,ad_category_subcategory c WHERE a.id = b.adid AND a.id=c.adid AND a.business_id=".$id." AND b.approval = ".$approval." AND c.catid!='-99' GROUP BY a.id ORDER BY a.timestamp DESC".$limit_where;
        }
        $result = $this->CommonController->SelectRawquery($sql,'resultArray');
        
        foreach($result as $arr_ads) {
            $activatedzones = $deactivatedzones = $pendingzones = $activatedcatsid = "" ;
            $sql="SELECT a.id,a.approval,b.name FROM ad_to_zone a,sales_zone b WHERE a.zoneid=b.id  AND a.adid=".$arr_ads['id'];
            $result_inner = $this->CommonController->SelectRawquery($sql,'resultArray');

            foreach($result_inner as $arr_ad_to_zone_sales_zone) {
                if($arr_ad_to_zone_sales_zone['approval']==1){
                    $activatedzones.= $arr_ad_to_zone_sales_zone['name'].", " ;
                }else if($arr_ad_to_zone_sales_zone['approval']==0){
                    $pendingzones.= $arr_ad_to_zone_sales_zone['name'].", " ;
                }else if($arr_ad_to_zone_sales_zone['approval']==-1){
                    $deactivatedzones.= $arr_ad_to_zone_sales_zone['name'].", " ;
                }
            }
            $activatedzones = ($activatedzones != "") ? substr($activatedzones,0,strlen($activatedzones)-2) : "-" ;
            $deactivatedzones = ($deactivatedzones != "") ? substr($deactivatedzones,0,strlen($deactivatedzones)-2) : "-" ;
            $pendingzones = ($pendingzones != "") ? substr($pendingzones,0,strlen($pendingzones)-2) : "-" ;
            
            $result[$i]['activatedzone'] = $activatedzones ;
            $result[$i]['pendingdzone'] = $pendingzones ;
            $result[$i]['deactivatedzone'] = $deactivatedzones ;
            $result[$i]['busname'] = $busname ;
            $result[$i]['insert_via_csv'] = $insert_via_csv ;
            
            $sql="SELECT * FROM ad_category_subcategory WHERE adid=".$arr_ads['id'];
            $result_inner = $this->CommonController->SelectRawquery($sql,'resultArray');
            foreach($result_inner as $arr_catid) {
                $catname=$this->fn_get_name($arr_catid['catid'],1); 
                $catgroupname=$this->fn_get_name($arr_catid['cat_group_id'],2);
                $subcatname=$this->fn_get_name($arr_catid['subcatid'],3);
                $activatedcatsid.= $catname."@@".$catgroupname."$$".$subcatname.", " ;
            }
            
            $activatedcatsid = ($activatedcatsid != "") ? substr($activatedcatsid,0,strlen($activatedcatsid)-2) : "-" ;
            $result[$i]['activatedcatid'] = $activatedcatsid ;
            
            $sql_reason="SELECT reason,usertype FROM ads_edit_info WHERE adid=".$arr_ads['id']." AND usertype=5 ORDER BY id DESC LIMIT 0,1";
            $result_1 = $this->CommonController->SelectRawquery($sql_reason,'resultArray');
            if(count($result_1) >'0'){
                foreach ($result_1 as $result1){                    
                    $result[$i]['reason']=$result1['reason'];                   
                }
            }
            $i++;
        }
        return $result;
    }
    
    public function fn_get_name($id='', $type=''){ 
        $sql = ''; $arr = array();
        $result='';
        if($type==1 ){
            $sql="SELECT name from category_new where id=".$id;
        }else if($type==2){
            $sql="SELECT name from category_subcategory_new where id=".$id;
        }else if($type==3){
            $sql="SELECT name from category_sub_subcategory_new where id=".$id;
        }

        $arr = $this->CommonController->SelectRawquery($sql,'resultArray');
        if(count($arr) > 0){
            $result=$arr[0]['name'];   
        }
        return $result;
    }

    

    

    

    

    

    

    

    

    

    # - For all ads for business by ad type(N E W) #    

    function ads_edit_for_approval($id,$uid,$reason){

        $sql="SELECT group_id FROM users_groups WHERE user_id=".$uid;

        $query_1= $this->db->query($sql);

        $query=$query_1->result_array();

        $newdata=array();

        foreach($query as $x){          

            if($x['group_id']==4){

                $newdata['usertype'] = 4;

            }else if($x['group_id']==5){

                $newdata['usertype'] = 5;

            }

            }

            $newdata['adid'] = $id;

            $newdata['userid'] = $uid;

            $newdata['reason'] = $reason;

            $this->db->insert('ads_edit_info', $newdata);

    }

    

    function get_ads_by_zoneid_adid_selectedid_businessid($zoneid,$adid,$businessid){

        $sql="SELECT * FROM ads WHERE id=".$adid;

        $result=$this->db->query($sql)->result_array(); 

        $new_result=array();

        foreach($result[0] as $k=>$v){

            $new_result[0][$k]=urldecode(stripslashes($v));

        }

        return $new_result;

    }

    function get_ads_by_zoneid_adid_selectedid_businessidnew($adid=0,$businessid=0,$zoneid=0){ 
        $new_result=[];

        $sql="SELECT a.*,b.type FROM ads a, ads_setting_preferences b WHERE a.business_id = b.businessid AND a.id=$adid ORDER BY a.timestamp DESC";
        $result = $this->CommonController->SelectRawquery($sql,'resultArray');
        foreach($result[0] as $k=>$v){
            $new_result[0][$k]=$v;
        }

        $sql_1="SELECT GROUP_CONCAT(catid) as catid,GROUP_CONCAT(subcatid) as subcatid FROM ad_category_subcategory WHERE adid=".$adid." and zoneid=".$zoneid;
        $result_1 = $this->CommonController->SelectRawquery($sql_1,'resultArray');
        
        $arr_catid_ex=explode(',',$result_1[0]['catid']); 
        $arr_catid_u=array_unique($arr_catid_ex);       
        $arr_catid=implode(',',$arr_catid_u);
        $new_result[0]['catid']=$arr_catid;
        $arr_subcatid_ex=explode(',',$result_1[0]['subcatid']); 
        $arr_subcatid_u=array_unique($arr_subcatid_ex);     
        $arr_subcatid=implode(',',$arr_subcatid_u);
        $new_result[0]['subcatid']=$arr_subcatid;
        return $new_result;
    }

    function getBusinessByID($id=0){

        $sql="SELECT * FROM business WHERE id=".$id;

        $result=$this->db->query($sql)->result_array();

        return $result[0];

    }

    function  getBusinessAddresByID($addressid){

        $sql="SELECT * FROM address WHERE id=".$addressid;

        $result=$this->db->query($sql)->result_array();

        //var_dump($result);

        return $result[0];

    }

    public function getZonePpreferencesByZone($zoneid){
        $sql="SELECT auto_approve_paid_ad_myzone,auto_approve_paid_specific_ad_myzone,auto_approve_paid_ad_locatedmyzone,auto_approve_paid_specific_ad_locatedmyzone,auto_approve_trial_ad_myzone,auto_approve_trial_specific_ad_myzone,auto_approve_trial_ad_locatedmyzone,auto_approve_trial_specific_ad_locatedmyzone,auto_approve_paid_business_myzone,auto_approve_paid_business_locatedmyzone,auto_approve_trial_business_myzone,auto_approve_trial_business_locatedmyzone,auto_approve_listed_business_myzone,auto_approve_listed_business_locatedmyzone,auto_approve_emergency_announcements,auto_approve_normal_announcements,auto_approve_ig_by_org,auto_approve_ig_by_business,auto_approve_offers_announcements,auto_approve_banner,auto_approve_csvupload,displayoffer,auto_approve_sticky_ad,ischangezonetheme,zonetheme,notification_day,trial_business_active,sponsor_ad_text FROM zone_preferences WHERE zoneid =".$zoneid;
        $arr = $this->CommonController->SelectRawquery($sql,'resultArray');
        if(!empty($arr))
            return $arr[0];
        else
            return array();
    }

    public function getAdSettingsPref($zoneid,$businessid){
        $sql="SELECT isdefault,approval FROM ads_setting_preferences WHERE businessid=".$businessid." AND settingszoneid=".$zoneid;
        $arr = $this->CommonController->SelectRawquery($sql,'resultArray');
        return $arr[0];
    }

    function getBusinessesOfMyZoneByZone($zoneid){

        $sql="SELECT b.id AS businessid,b.name AS businessname FROM ads_setting_preferences a,business b WHERE a.settingszoneid=".$zoneid." AND a.businessid=b.id AND a.approval=1"; 

        $arr=$this->db->query($sql)->result_array();

        return $arr;

    }

    function getBusinessesLocatedInMyZone($zoneid){

        $sql="SELECT b.id AS businessid,b.name AS businessname FROM ads_setting_preferences a,business b WHERE a.settingszoneid=".$zoneid." AND a.businessid=b.id AND a.approval=0";

        $arr=$this->db->query($sql)->result_array();

        return $arr;

    }

    public function getZonesAsscocitedToBusiness($businessid){
        $sql="SELECT settingszoneid,isdefault,approval FROM ads_setting_preferences WHERE businessid=".$businessid;
        $arr = $this->CommonController->SelectRawquery($sql,'resultArray');
        return $arr;
    }

    function get_adsbusiness($adid,$busid){

        $sql = "select * FROM ads where id=" .$adid;

        $arr=$this->db->query($sql)->result_array();

        return $arr;        

    }

    public function get_display_offer_in_zonepage($zoneId){
        $arr='';
        $sql = "select displayoffer FROM zone_preferences where zoneid='" .$zoneId."'";
        $arr=$this->db->query($sql)->getResultArray();
        if(!empty($arr)){
            $arr;       
        }
        return $arr;
    }

    function get_display_change_theme_in_zonepage($zoneId=false){

        $sql = "select ischangezonetheme,zonetheme FROM zone_preferences where zoneid='" .$zoneId."'";

        $arr=$this->db->query($sql)->result_array();

        if(!empty($arr)){

         return $arr;       

        }else{

            $arr='';

            return $arr;

        }

        

    }

    public function get_jobdetails($businessid){ // job details

        $sql = "select id,title,description,start_date,salary_range FROM job_listing where business_id=" .$businessid;

        $arr=$this->db->query($sql)->result_array();

        return $arr;

    }

    public function get_barterdetails($businessid){ // barter details

        $sql = "select id,title,description,start_date,salary_range FROM barter_listing where business_id=" .$businessid;

        $arr=$this->db->query($sql)->result_array();

        return $arr;

    }

    public function get_businesszone($businessid){ 

        $sql = "select settingszoneid FROM ads_setting_preferences where businessid=" .$businessid;

        $arr=$this->db->query($sql)->row();

        return $arr;

    }

    public function get_businessdetails($businessid){ 

        $sql="SELECT b.id AS bs_id,b.logo AS bs_logo,b.name AS bs_name,b.contactemail AS bs_contactemail,b.contactfirstname AS bs_contactf_name,b.contactlastname AS bs_contactl_name,b.website AS bs_website,e.street_address_1 AS bs_streetaddress1,e.street_address_2 AS bs_streetaddress2,e.city AS bs_city,e.state AS bs_state,e.zip_code AS bs_zipcode,e.phone AS bs_phone FROM business b,address e WHERE b.addressid=e.id AND  b.id=".$businessid;

        $arr=$this->db->query($sql)->result_array();

        return $arr;

    }

    public function get_all_ads_in_zone($zoneId='',$type='',$approval=''){       
        $business_type = $ad_approval = $where_category = '' ;
        $hide_adid = '0' ;
        
        if($type == 'all'){
            $business_type = '1,-1,2,-2,3,-3' ;
            $ad_approval = '1,-1' ;
            $arr = array() ;
            $hidead_query = $this->db->query("SELECT a.adid AS countad FROM ad_category_subcategory a,ads_setting_preferences b,ad_to_zone c,ads d WHERE b.businessid = d.business_id AND d.id = c.adid AND c.adid = a.adid AND b.approval NOT IN(3,-3) AND a.catid = -99 AND c.zoneid = $zoneId");
            $row = $hidead_query->getResultArray();
            
            foreach($row as $key=>$val){
                $arr[] = $val['countad'] ;

            }
            if(!empty($arr)){
                $hide_adid = implode(',',$arr) ;
            }
        }else if($type == 'comingsoon'){
            $business_type = '3,-3' ;
            if($approval == 'active'){
                $ad_approval = '1' ;
            }else{
                $ad_approval = '-1' ;
            }
            $where_category = ' AND a.catid = -99' ;
        }else if($type == 'realad'){
            $business_type = '1,-1,2,-2' ;
            if($approval == 'active'){
                $ad_approval = '1' ;
            }else{
                $ad_approval = '-1' ;
            }
            $where_category = ' AND a.catid != -99' ;
        }
        
        $query = "SELECT Count(distinct(a.adid)) AS countad FROM ad_category_subcategory a,ads_setting_preferences b,ad_to_zone c,ads d WHERE b.businessid = d.business_id AND d.id = c.adid AND c.adid = a.adid AND b.approval IN($business_type) AND c.approval IN($ad_approval) AND c.zoneid = $zoneId  AND a.adid NOT IN($hide_adid)$where_category" ;
        $sql = $this->db->query($query) ;
        return $result = $sql->getResultArray();
    }

    function save_stater_ad_business($busid=false, $zoneid=false, $stater_ad=false, $catid=0, $subcatid=0,$grid=false){

        //var_dump(0);var_dump($catid); var_dump($subcatid); exit;

        $data=array();

        $data['adtext'] = $stater_ad;

        $data['business_id'] = $busid;

        $data['categoryid'] = $catid;

        $data['subcategoryid'] = $subcatid;

        $data['active'] = 1;        

        $this->db->insert('ads', $data);

        $adid = $this->db->insert_id();

                

        $data1 = array('search_engine_title' => $adid);

        $this->db->where('id', $adid);

        $this->db->update('ads', $data1);

        

        $newdata=array();

        $newdata['adid'] = $adid;

        $newdata['zoneid'] = $zoneid;

        //$newdata['approval'] = 1;         

        if($grid==4){

            $newdata['approval'] = 1;  // commented on 3.6.14

            //$newdata['approval'] = 0;   // added on 3.6.14

        }else if($grid==5 || $grid==13){  // added on 9.6.14 for business type and franchise type business

            $newdata['approval'] = 0;

        }

        $this->db->insert('ad_to_zone', $newdata);

        return $adid;

    }

    function get_save_listed_cat_subcat($adid=false,$catid=false,$subcatid=false,$busid=false){

        $data = array('categoryid' => $catid ,'categoryid1'=>0,'subcategoryid1'=>0, 'subcategoryid' => $subcatid,'timestamp' => time());

        //$this->db->where('id', $adid);

        //echo $busid;exit;

        $this->db->where('business_id',$busid);

        $this->db->update('ads', $data);

    }

    

    public function get_selected_subcat_id_listed_business($listed_businessid){ // job details

        $sql = "select subcategoryid,subcategoryid1 FROM ads where business_id=" .$listed_businessid;

        $arr=$this->db->query($sql)->result_array();

        if(!empty($arr)){

            if($arr[0]['subcategoryid']==0){

                $id=$arr[0]['subcategoryid1'];

            }else{

                $id=$arr[0]['subcategoryid'];

            }

        }else{

            $id=0;

        }

        return $id;

    }

    

    function get_search_engine_title($search_engine_title=false){

        $sql="select count(*) as count from ads where search_engine_title='".$search_engine_title."'";

        $query=$this->db->query($sql);

        return $query->result_array();

    }
    
    public function get_requested_ad($zone=false,$deal_title=false,$from_sharing=false,$ad_id=0,$deal_title_type=''){
        if(!empty($ad_id) && !empty($deal_title_type) && $deal_title_type=="insert_deal_title"){   
            $data=array('deal_title'=>$deal_title);
            $this->db->where('id',$ad_id);
            $this->db->update('ads',$data);
        }
        
        $wh=" and a.deal_title='".$deal_title."'";
        $sql="select c.adid,c.categoryid,c.categoryid1,c.subcategoryid,c.subcategoryid1,c.zoneid,c.adtext,c.admessage,c.imagetype,c.docs_pdf, c.search_engine_title,c.audio_file,c.video_file,c.foodmenu as foodmenu,c.deal_title as deal_title,c.timestamp,c.stickyad, d.id AS bs_id, d.logo AS bs_logo,d.name AS bs_name,d.contactemail AS bs_contactemail,d.contactfirstname AS bs_contactf_name,d.contactlastname AS bs_contactl_name,d.website AS bs_website,d.motto as motto,d.israted,e.websitevisibility,e.emailvisibility,f.street_address_1 AS bs_streetaddress1,f.street_address_2 AS bs_streetaddress2,f.city AS bs_city,f.state AS bs_state,f.zip_code AS bs_zipcode,f.phone AS bs_phone,f.latitude,f.longitude,i.job,j.barter,k.approval, m.rate, n.cat_name1,o.subcat_name1,p.cat_name2,q.subcat_name2,sz.name as zone_name FROM (select a.id as adid,a.categoryid,a.categoryid1,a.subcategoryid,a.subcategoryid1,a.business_id,a.adtext,a.text_message AS admessage,a.imagetype,a.docs_pdf,a.search_engine_title,a.audio_file,a.video_file,a.foodmenu as foodmenu,a.deal_title as deal_title,a.timestamp,b.zoneid,b.stickyad from ads a,ad_to_zone b where a.id=b.adid and b.approval=1 and b.zoneid=$zone $wh) as c
        INNER JOIN (select id,name,addressid,business_owner_id,logo,contactemail,contactfirstname,contactlastname,website,motto,israted from business group by id) as d ON c.business_id = d.id 
        INNER JOIN ads_setting_preferences e ON d.id=e.businessid and e.settingszoneid=$zone
        INNER JOIN address f ON d.addressid = f.id
        INNER JOIN users g ON d.business_owner_id=g.id 
        INNER JOIN users_groups h ON g.id=h.user_id
        LEFT JOIN (SELECT count(distinct id) AS job,business_id from job_listing GROUP BY business_id) AS i ON i.business_id=d.id 
        LEFT JOIN (SELECT count(distinct id) AS barter,business_id from barter_listing GROUP BY business_id) AS j ON j.business_id=d.id 
        LEFT JOIN (select approval as approval,businessid from business_newsletter GROUP BY businessid ) AS k ON k.businessid=d.id 
        LEFT JOIN (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=$zone GROUP BY busId) AS m ON m.busId=d.id
        LEFT JOIN (SELECT id,name AS cat_name1 FROM category group by id) as n ON c.categoryid=n.id AND c.categoryid!=0 
        LEFT JOIN (SELECT id,name AS subcat_name1 FROM category_subcategory group by id) as o ON c.subcategoryid=o.id AND c.subcategoryid!=0
        LEFT JOIN (SELECT id,name AS cat_name2 FROM category group by id) as p ON c.categoryid1=p.id AND c.categoryid1!=0 
        LEFT JOIN (SELECT id,name AS subcat_name2 FROM category_subcategory group by id) as q ON c.subcategoryid1=q.id AND c.subcategoryid1!=0   
        INNER JOIN sales_zone sz ON c.zoneid=sz.id";
        $result = $this->CommonController->SelectRawquery($sql);
        if(count($result) > 0){
            return $result;
        }else{
            $result = '';
            return $result;
        }   
    }

    

    

    function get_requested_ad_old($zone=false,$adtext=false,$from_sharing='s'){

        $from_sharing=isset($from_sharing) ? 's' : '';

        

        if($from_sharing=='s'){

            $wh=" and a.id='".$adtext."'";

        }else{

            $wh=" and a.search_engine_title='".$adtext."'";

        }

        $sql_ad_count="SELECT 

        a.id AS adid,a.name AS adname,a.adtext,a.text_message AS admessage,a.imagetype,a.docs_pdf,a.search_engine_title,a.audio_file,a.video_file,c.id AS bs_id,c.logo AS bs_logo,c.name AS bs_name,c.contactemail AS bs_contactemail,c.contactfirstname AS bs_contactf_name,c.contactlastname AS bs_contactl_name,c.website AS bs_website,c.motto as motto,c.israted,d.street_address_1 AS bs_streetaddress1,d.street_address_2 AS bs_streetaddress2,d.city AS bs_city,d.state AS bs_state,d.zip_code AS bs_zipcode,d.phone AS bs_phone,d.latitude,d.longitude,b.stickyad,i.job,j.barter,k.approval,m.rate

        FROM (ads as a,ad_to_zone as b,business as c,address as d )

        LEFT JOIN (SELECT count(distinct id) AS job,business_id from job_listing GROUP BY business_id) AS i ON i.business_id=c.id 

            LEFT JOIN (SELECT count(distinct id) AS barter,business_id from barter_listing GROUP BY business_id) AS j ON j.business_id=c.id

            LEFT JOIN (select approval as approval,businessid from business_newsletter GROUP BY businessid ) AS k ON k.businessid=c.id

            LEFT JOIN (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=$zone GROUP BY busId) AS m ON m.busId=c.id

WHERE  a.id=b.adid AND a.business_id=c.id AND b.zoneid=".$zone." and c.addressid = d.id".$wh

            

            ;

            

            

            

            

            

            $query_inner=$this->db->query($sql_ad_count);

            $r=$query_inner->result_array(); 

            /*$i=0;

            foreach($r as $arr_r){

                $sql_sub_job="select count(id) as count_job from job_listing WHERE business_id=".$arr_r['bs_id'] ; // for job

                $query_sub_job=$this->db->query($sql_sub_job);

                $result_sub_job=$query_sub_job->result_array();

                $r[$i]['job'] = $result_sub_job[0]['count_job'] ;

                

                $sql_sub_barter="select count(id) as count_barter from barter_listing WHERE business_id=".$arr_r['bs_id'] ;  // for barter

                $query_sub_barter=$this->db->query($sql_sub_barter);

                $result_sub_barter=$query_sub_barter->result_array();

                $r[$i]['barter'] = $result_sub_barter[0]['count_barter'] ;

                

                $sql_sub_visibility="select websitevisibility,emailvisibility from ads_setting_preferences WHERE businessid=".$arr_r['bs_id'] ;  

                $query_sub_visibility=$this->db->query($sql_sub_visibility);

                $result_sub_visibility=$query_sub_visibility->result_array();

                $r[$i]['websitevisibility'] = $result_sub_visibility[0]['websitevisibility'] ;

                $r[$i]['emailvisibility'] = $result_sub_visibility[0]['emailvisibility'] ;

                

                $sql_newsletter="select approval from business_newsletter WHERE businessid=".$arr_r['bs_id'] ;  

                $query_newsletter=$this->db->query($sql_newsletter);

                $result_newsletter=$query_newsletter->result_array();

                if(!empty($result_newsletter)){

                    $r[$i]['approval'] = $result_newsletter[0]['approval'] ;

                }else{

                    $r[$i]['approval'] = 0 ;

                }

                $i++;

            }*/

            return $r;

    }

    

    function get_ads_by_business_id($bid){

        //$sql="select id,adtext,categoryid,categoryid1,subcategoryid,subcategoryid1,imagetype from ads where business_id=".$bid;

        $sql="select a.id,a.adtext,group_concat(b.catid) as categoryid,group_concat(b.subcatid) as subcategoryid,a.imagetype from ads a, ad_category_subcategory b where a.id=b.adid and  a.business_id=".$bid;

        return $this->db->query($sql)->row();

    }

    

    function update_business_from_business_verification($id=false,$bus_name=false,$bus_fname=false,$bus_lname=false,$bus_email=false,$bus_phone=false,$bus_website=false,$bus_street_address_1=false,$bus_street_address_2=false,$bus_city=false,$bus_state=false,$bus_zip=false,$adtext='',$foodimage='',$business_owner_id=''){

        

        /*$categoryid=''; $categoryid1=''; $subcategoryid=''; $subcategoryid1=''; 

        

        if($ad_category && $ad_category!='')

        {

            isset($ad_category[0]) ? $categoryid=$ad_category[0] : $categoryid='';

            $categoryid!='' ? $categoryid=$categoryid: $categoryid='';

            isset($ad_category[1]) ? $categoryid1=$ad_category[1] : $categoryid1='';

            $categoryid1 ? $categoryid11=$categoryid1: $categoryid11='';        

        }



        if($ad_sub_category && $ad_sub_category!='')

        {

            isset($ad_sub_category[0])!='' ? $subcategoryid=$ad_sub_category[0] : $subcategoryid='';

            $subcategoryid!='' ? $subcategoryid=$subcategoryid : $subcategoryid='';

        }

        if($ad_sub_category1 && $ad_sub_category1!='')

        {

            isset($ad_sub_category1[0]) ? $subcategoryid1=$ad_sub_category1[0] : $subcategoryid1='';

            $subcategoryid1!='' ? $subcategoryid1=$subcategoryid1: $subcategoryid1='';

        }*/



        $data = array('name' => $bus_name, 'contactfirstname' => $bus_fname, 'contactlastname' => $bus_lname, 'contactemail' => $bus_email, 'website' => $bus_website, 'isverified'=>1);

        $this->db->where('id', $id);

        $this->db->update('business', $data);

        

        $sql="select addressid from business where id=".$id;

        $query = $this->db->query($sql);

        $result=$query->result_array();

        //var_dump($result);

        $addressid=$result[0]['addressid'];

        if($bus_phone!=''){     

            $newdata = array('street_address_1' => $bus_street_address_1, 'street_address_2' => $bus_street_address_2,'city' => $bus_city, 'state' => $bus_state, 'zip_code' => $bus_zip, 'phone'=>$bus_phone);

        }else{

            $newdata = array('street_address_1' => $bus_street_address_1, 'street_address_2' => $bus_street_address_2, 'city' => $bus_city, 'state' => $bus_state, 'zip_code' => $bus_zip);

        }

        $this->db->where('id', $addressid);

        $this->db->update('address', $newdata);

        $datad=array('adtext'=>$adtext,'imagetype'=>$foodimage);

        $this->db->where('business_id',$id);

        $this->db->update('ads',$datad);

        if($bus_phone!=''){ 

            $datau=array('username'=>$bus_phone);

            $this->db->where('id',$business_owner_id);

            $this->db->update('users',$datau);

        }

    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////

    function fn_all_activated_business_in_zone($zoneid=0){

        $this->db->query("SET SESSION group_concat_max_len=10000000000000") ;               

        $sql_bus="SELECT group_concat(a.id) as bid from business a, ads_setting_preferences b where a.id=b.businessid AND b.settingszoneid IN(".$zoneid.") and b.approval IN(1,2,3)";

        $query_bus=$this->db->query($sql_bus);

        $result_bus=$query_bus->result_array(); 

        if(!empty($result_bus)){

            $all_bus_ids= $result_bus[0]['bid']; 

        } 

        return $all_bus_ids;

        

    }

    function get_ads_in_category($zoneid=0){

        $sql="Select count(b.id) as countid from ad_to_zone a, ads b,ads_setting_preferences c where a.adid=b.id and b.business_id=c.businessid and a.approval=1 and a.zoneid=$zoneid and b.categoryid!=-99 and c.settingszoneid=$zoneid";

        $query=$this->db->query($sql);

        $result=$query->result_array();

        return $result;

    }

    

    // this function shows all ads in home page 

    function get_ads_for_offer($zone=0,$lowerlimit=0,$upperlimit=0,$count_category=0){ 

        

        if($count_category>0){ 

            $sql="SELECT d.id AS adid,d.name AS adname,d.adtext,d.text_message AS admessage,d.imagetype,d.docs_pdf, d.search_engine_title,d.audio_file,d.video_file,d.foodmenu as foodmenu,d.deal_title as deal_title,c.id AS bs_id, c.logo AS bs_logo,c.name AS bs_name,c.contactemail AS bs_contactemail,c.contactfirstname AS bs_contactf_name,c.contactlastname AS bs_contactl_name,c.website AS bs_website,c.motto as 

motto,c.israted,f.street_address_1 AS bs_streetaddress1,f.street_address_2 AS bs_streetaddress2,f.city AS bs_city,f.state AS bs_state,f.zip_code AS bs_zipcode,f.phone AS bs_phone,e.stickyad,c.websitevisibility,c.emailvisibility,i.job,j.barter,k.approval,m.rate,f.latitude,f.longitude,c.name as businessname,n.name as zone_name

            FROM

            ((SELECT a.settingszoneid, a.websitevisibility,a.emailvisibility,b.id,b.name,b.addressid,b.business_owner_id,b.logo, b.contactemail, b.contactfirstname,b.contactlastname,b.website,b.motto,b.israted FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid=".$zone." AND a.approval IN(1,2,3)) ) AS c

            INNER JOIN ads d ON c.id=d.business_id AND (d.categoryid!=-99 AND d.categoryid1!=-99)  

            INNER JOIN ad_to_zone e ON d.id=e.adid AND c.settingszoneid=e.zoneid AND e.zoneid=".$zone." AND e.approval=1

            INNER JOIN address f ON c.addressid = f.id

            INNER JOIN users g ON c.business_owner_id=g.id

            INNER JOIN users_groups h ON g.id=h.user_id

            LEFT JOIN (SELECT count(distinct id) AS job,business_id from job_listing GROUP BY business_id) AS i 

                ON i.business_id=c.id

            LEFT JOIN (SELECT count(distinct id) AS barter,business_id from barter_listing GROUP BY business_id) AS j 

                ON j.business_id=c.id

            LEFT JOIN (select approval as approval,businessid from business_newsletter GROUP BY businessid ) AS k 

                ON k.businessid=c.id

            LEFT JOIN  (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=".$zone." GROUP BY busId) AS m

                ON m.busId=c.id

            INNER JOIN sales_zone n ON c.settingszoneid=n.id            

            ORDER BY businessname ASC LIMIT ".$lowerlimit.",".$upperlimit."

            ";

        

        //fwrite($fp,chr(10)."SQL:".$sql) ;

        

        $query=$this->db->query($sql);

        

        //$this->get_ads_for_offer($zone,$lowerlimit=0,$upperlimit=0,$count_category);

        

        //fwrite($fp,chr(10)."QUERY EXECUTED") ;

        

        $result=$query->result_array(); //var_dump($result);

        /*if(empty($result)){

            return $this->get_ads_for_offer($zone,$lowerlimit+$upperlimit,$upperlimit,$count_category);

        }*/

        }else{

            $result='';

        }

        /*if(!empty($result)){

            $result[0]['newadtext']=1;

        }*/

        //var_dump($a);

         //fwrite($fp,chr(10)."RESULT:".$result) ;

         //fclose($fp);

                

                

            /*foreach($result as $k=>$x){

                $result[$k]['newadtext']=1;

            }

            var_dump($result);  */

           return $result;

        }


        function get_coordinates_byZipCode($zipcode){

           $sql= "SELECT Latitude , Longitude from ZIPCodes  where ZipCode ='".$zipcode ."' Limit 1  ";


        $query=$this->db->query($sql);       
        

        $result=$query->result_array(); 

         return json_encode($result[0]);



        }

        //INNER JOIN ads d ON c.id=d.business_id

    public function get_ads_for_all_athena_latest_working_anishnew($zone_id=0,$lowerlimit=0,$upperlimit=0,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 0,$page=0,$page_dest = '',$type = '',$sortbyvalue = '',$albhabetvalue = '',$lat='',$lng=''){
        $searchbutton = !empty($_REQUEST['searchbutton']) ? $_REQUEST['searchbutton'] : 'false'; 
    /*snap sidding open or close*/
    $snapdinnig = isset($_REQUEST['snapdinnig'])?$_REQUEST['snapdinnig']:'close';
    $urlsubcat = isset($_REQUEST['urlsubcat'])?$_REQUEST['urlsubcat']:'';
    // date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');
    $newDate = date('l', strtotime($date));
    $currentday = strtolower($newDate); 
    /*snap sidding open or close*/
    $businessArr = $addressArr = $business_owner_idArr = $usersArr = $finalArr = $adsArr = $addressDataArr = $business_sponsor_orderArr = $business_sponsorArr = $business_sponsorcatArr = $busimageArr = $usernameArr = $usertblArr = $usertbldealsArr = $usertbldealsprodcutsArr =$atozone = $favArr = [];
     $userArr1 = $tblmember1 = $tbldeals1 = $tblproduct1 = $AdidArr = $businessArrcat = $d = $sortArr = $InArr = $OutArr = $datainsertArr = $azArr = $audioArr1 = $adsArrimage = $subimageArr1 = $subimageArr99 = $approvaldalArr = [];
    $totalcount = 0;
    /*get snap dinnig params*/
    $noOfPerson = !empty($_REQUEST['noOfPerson']) ? $_REQUEST['noOfPerson'] : 0;
    $searchDate = !empty($_REQUEST['searchDate']) ? $_REQUEST['searchDate'] : date('Y-m-d');
    $time = !empty($_REQUEST['time']) ? $_REQUEST['time'] : "";
    $foodType = !empty($_REQUEST['foodType']) ? $_REQUEST['foodType'] : "";
    $orderBy = !empty($_REQUEST['orderBy']) ? $_REQUEST['orderBy'] : "";
    $outDoorDining = !empty($_REQUEST['outDoorDining']) ? $_REQUEST['outDoorDining'] : 0;
    /*get snap dinnig params*/
    /*main data*/
    if($page_dest == 'show_ads_specific_category' && $charval == ''){
        if($urlsubcat != ''){
            $subcatjson = base64_decode($urlsubcat);
            $subcatArr = json_decode($subcatjson);
            $subcatimplode = implode(',', $subcatArr);
            $sql="SELECT business.*,business.id as businessid FROM business right JOIN ads ON ads.business_id=business.id INNER JOIN business_sponsor_order_cat ON business_sponsor_order_cat.adid=ads.id WHERE business_sponsor_order_cat.zoneid=".$zone_id." and business_sponsor_order_cat.subcatid IN (".$subcatimplode.") GROUP BY business.id   ORDER BY business_sponsor_order_cat.display_order ASC  ";
            $data = $this->CommonController->SelectRawquery($sql,'result'); 
        }else{
            if($lowerlimit == 1){
                $lowerlimit = 0;
            }
            if($cat_id != 1){
                $where = ['c.zoneid'=> $zone_id,'c.catid'=> $cat_id];
                $orderby = [];
                $joinArr[] = ['table' => 'ads as b','link' => 'a.businessid=b.business_id','type' => 'inner']; 
                $joinArr[] = ['table' => 'ad_category_subcategory as c','link' => 'b.id=c.adid','type' => 'inner'];
                $joinArr[] = ['table' => 'business as d','link' => 'a.businessid=d.id','type' => 'inner'];
                $joinArr[] = ['table' => 'users as f','link' => 'f.id=d.business_owner_id','type' => 'left'];
                $joinArr[] = ['table' => 'tbl_member as g','link' => 'g.user_name=f.username','type' => 'left'];
                $data = $this->CommonController->SelectJoinMulti('ads_setting_preferences as a', $joinArr,$where,[], $orderby,'a.businessid',$lowerlimit,$upperlimit,'',[],'','d.id');
            }else{
                $where = ['a.zoneid'=> $zone_id,'c.catid'=> $cat_id];
                $orderby = ['display_order'=> 'ASC'];
                $joinArr[] = ['table' => 'ads as b','link' => 'a.business_id=b.business_id','type' => 'inner']; 
                $joinArr[] = ['table' => 'ad_category_subcategory as c','link' => 'b.id=c.adid','type' => 'inner'];
                $joinArr[] = ['table' => 'business as d','link' => 'a.business_id=d.id','type' => 'inner'];
                $joinArr[] = ['table' => 'ads_setting_preferences as e','link' => 'a.business_id=e.businessid','type' => 'inner'];
                $joinArr[] = ['table' => 'users as f','link' => 'f.id=d.business_owner_id','type' => 'left'];
                $joinArr[] = ['table' => 'tbl_member as g','link' => 'g.user_name=f.username','type' => 'left'];
                $data = $this->CommonController->SelectJoinMulti('business_sponsor_order as a', $joinArr,$where,[], $orderby,'a.business_id as businessid',$lowerlimit,$upperlimit,'',[],'','d.id');
            }
        }   
    }
    if($charval == 'redemption_high' || $charval == 'redemption_low' || $charval == 'deal_price_high' || $charval == 'deal_price_low' || $charval == 'high to low' || $charval == 'low to high' || $charval == 'a-z' || $charval == 'z-a' || $charval == 'deal_left_high' || $charval == 'deal_left_low'){
        $order_by = '';
        if($charval == 'redemption_high' || $charval == 'high to low'){
            $order_by = '`buy_price_decrease_by` DESC';
        }
        if($charval == 'redemption_low' || $charval == 'low to high'){
            $order_by = '`buy_price_decrease_by` ASC';
        }
        if($charval == 'deal_price_high'){
            $order_by = '`current_price` DESC';
        }
        if($charval == 'deal_price_low'){
            $order_by = '`current_price` ASC';
        }
        if($charval == 'deal_left_high'){
            $order_by = '`numberofconsolation` DESC';
        }
        if($charval == 'deal_left_low'){
            $order_by = '`numberofconsolation` ASC';
        }
        if($charval == 'z-a' || $charval == 'a-z'){
            if($charval == 'a-z'){
                $order_by_1 = ' ASC';
            }
            if($charval == 'z-a'){
                $order_by_1 = ' DESC';
            }
            $sql="SELECT b.id,b.name from ads_setting_preferences as a INNER JOIN business as b ON a.businessid=b.id WHERE a.settingszoneid=".$zone_id." AND a.approval NOT IN (-1, -2, 3, -3) ORDER BY b.name ".$order_by_1."";
            $businessazarr = $this->CommonController->SelectRawquery($sql,'result');
            if($businessazarr != ''){
                foreach ($businessazarr as $kaz => $vaz) {
                    $azArr[] = $vaz->id;   
                }
                if($lowerlimit == 1){ $implodeArr = array_slice($azArr, 0, $upperlimit);
                }else{ $implodeArr = array_slice($azArr, $lowerlimit, $upperlimit);}
                    $inexplode = implode(',',$implodeArr);
            }
            $sql="SELECT `a`.* FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` JOIN `users` as `c` ON `b`.`business_owner_id`=`c`.`id` JOIN `tbl_member` as `d` ON `c`.`username`=`d`.`user_name` JOIN `tbl_deals` as `e` ON `d`.`user_id`=`e`.`user_id` WHERE `a`.`settingszoneid` = ".$zone_id." AND `a`.`approval` NOT IN(-1, -2, 3, -3) AND b.id IN (".$inexplode.")";
            if($albhabetvalue != ''){
                $sql .= " AND `b`.`name` LIKE '".trim($albhabetvalue)."%'";
            }
        }else{
            $sql="SELECT `a`.*, `e`.`current_price`, `e`.`start_date`, `e`.`end_date` FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` JOIN `users` as `c` ON `b`.`business_owner_id`=`c`.`id` JOIN `tbl_member` as `d` ON `c`.`username`=`d`.`user_name` JOIN `tbl_deals` as `e` ON `d`.`user_id`=`e`.`user_id` JOIN `tbl_deals_products` as `f` ON `d`.`user_id`=`f`.`user_id` JOIN `ads` as `g` ON `b`.`id`=`g`.`business_id` JOIN `ad_category_subcategory` as `h` ON `h`.`adid`=`g`.`id` WHERE `a`.`settingszoneid` = ".$zone_id." AND `a`.`approval` NOT IN(-1, -2, 3, -3)  and ('".date('Y-m-d')."' BETWEEN e.start_date AND DATE_FORMAT(e.end_date, '%Y-%m-%d'))";
            if($albhabetvalue != ''){
                $sql .= " AND `b`.`name` LIKE '".trim($albhabetvalue)."%'";
            }
            if($cat_id > 0){
                $sql .= " AND `h`.`catid`=".$cat_id."";
            }
            if($sub_cat_id > 0){
                $sql .= " AND `h`.`subcatid`=".$sub_cat_id."";
            }
            $sql .= " ORDER BY ".$order_by." LIMIT ".$lowerlimit.", ".$upperlimit;
        }
        $data = $this->CommonController->SelectRawquery($sql,'result');
    }
    if(!empty($user_id) && $page_dest == 'show_favorites_ads'){ // show_favorites_ads
        $tableArr[] = ['table' => 'business as b','link' => 'a.businessid=b.id','type' => 'left'];
        $tableArr[] = ['table' => 'ads as c','link' => 'b.id=c.business_id','type' => 'left'];
        $tableArr[] = ['table' => 'users_favorites as d','link' => 'c.id=d.adid','type' => 'left'];
        $data = $this->CommonController->SelectJoinMulti('ads_setting_preferences as a', $tableArr, ['a.settingszoneid'=> $zone_id,'d.zoneid' => $zone_id,'c.categoryid !=' => -99,'user_id' => $user_id],[], [], 'a.*','','','');
    }
    if($page_dest == 'show_all_offers'){
        if($charval == ''){
            if($lowerlimit == 1){
                $lowerlimit = 0;
            }
            $where = ['a.zoneid'=> $zone_id,'c.catid'=> $cat_id];
            $orderby = ['display_order'=> 'ASC'];
            $joinArr[] = ['table' => 'ads as b','link' => 'a.business_id=b.business_id','type' => 'left']; 
            $joinArr[] = ['table' => 'ad_category_subcategory as c','link' => 'b.id=c.adid','type' => 'left'];
            $data = $this->CommonController->SelectJoinMulti('business_sponsor_order as a', $joinArr,$where,[], $orderby,'a.business_id as businessid',$lowerlimit,$upperlimit);   
        }else{
            $words = explode("'",$charval);
            $charval =$words[0];
            
            if($searchbutton == 'true'){
                $albhabetsql="SELECT `a`.*,`b`.name FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` WHERE `b`.`name` LIKE '".trim($charval)."%' AND `a`.`settingszoneid` = ".$zone_id."";
            }else{
                $albhabetsql="SELECT `a`.*,`b`.name FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` JOIN `ads` as `c` ON `c`.`business_id`=`b`.`id` JOIN `ad_category_subcategory` as `d` ON `d`.`adid`=`c`.`id` WHERE `b`.`name` LIKE '".trim($charval)."%' AND `a`.`settingszoneid` = ".$zone_id."";
                if($cat_id > 0){
                    $albhabetsql .= " AND `d`.`catid`=".$cat_id."";
                }
                if($sub_cat_id > 0){
                    $albhabetsql .= " AND `d`.`subcatid`=".$sub_cat_id."";   
                }
                // $albhabetsql .= " LIMIT ".$lowerlimit.", ".$upperlimit."";
            }
            $data = $this->CommonController->SelectRawquery($albhabetsql,'result');
            if($lowerlimit == 1){ 
                $data = array_slice($data, 0, $upperlimit);
            }else{ 
                $data = array_slice($data, $lowerlimit, $upperlimit);
            }
        }
    }
    if($page == 'filter-for-pboo' && $charval == ''){
        $sql="SELECT `a`.*,`b`.name FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` WHERE  `a`.`settingszoneid` = ".$zone_id." LIMIT ".$lowerlimit.", ".$upperlimit."";
        $data = $this->CommonController->SelectRawquery($sql,'result');
    }
    
    if($page_dest == 'show_ads_specific_sub_category' && $sub_cat_id > 0){
        $tableArr = [];
        $CronController = new CronController();
        $day = date('d');
        $foodtypeArr = ['885','2','888','3','4','5','7','15','35','38','40','41','44','45','49','883','22'];
        if(!in_array($sub_cat_id, $foodtypeArr)){
            $sql="SELECT business.*,business.id as businessid FROM business right JOIN ads ON ads.business_id=business.id INNER JOIN business_sponsor_order_cat ON business_sponsor_order_cat.adid=ads.id WHERE business_sponsor_order_cat.zoneid=".$zone_id." and business_sponsor_order_cat.subcatid=".$sub_cat_id." and business_sponsor_order_cat.catid=".$cat_id." GROUP BY business.id   ORDER BY business_sponsor_order_cat.display_order ASC  ";
            $data = $this->CommonController->SelectRawquery($sql,'result');   
        }else{
           $sql="SELECT * , business.*,business.id as businessid FROM business_sponsor_order 
                    INNER JOIN business ON business_sponsor_order.business_id=business.id left JOIN business_sponsor_order_subcat ON business_sponsor_order_subcat.bussiness_id=business.id right JOIN ads ON ads.business_id=business.id INNER JOIN business_sponsor_order_cat ON business_sponsor_order_cat.adid=ads.id left JOIN business_sponsor ON business_sponsor.business_id=business_sponsor_order.business_id WHERE business_sponsor.zone_id=".$zone_id." and business_sponsor_order_cat.subcatid=".$sub_cat_id." and business_sponsor_order_cat.catid=".$cat_id." GROUP BY business.id   ORDER BY business_sponsor_order_cat.display_order ASC  ";
            $data = $this->CommonController->SelectRawquery($sql,'result');
        }
        if(trim($day) == '01'){
            $data = $CronController->rankcategory($data,$zone_id);
        }  
    }

    if($page_dest == 'sharing_offers'){
        $where = ['a.id'=> $deal_title_ad_id,'a.deal_title'=> $deal_title];
        
        $joinArr[] = ['table' => 'business as b','link' => 'a.business_id=b.id','type' => 'inner']; 
        $joinArr[] = ['table' => 'users as c','link' => 'b.business_owner_id=c.id','type' => 'inner'];
        $joinArr[] = ['table' => 'tbl_member as d','link' => 'c.username=d.user_name','type' => 'inner'];
        $joinArr[] = ['table' => 'tbl_deals as e','link' => 'd.user_id = e.user_id','type' => 'inner'];
        $joinArr[] = ['table' => 'tbl_deals_products as f','link' => 'e.product_id=f.deal_product_id','type' => 'left'];
        $data = $this->CommonController->SelectJoinMulti('ads as a', $joinArr,$where,[], [],'a.business_id as businessid','','','',[],'','');
    }
    if($page_dest == 'show_data_miles'){
        if($user_id == 0){
            if($lat != '' && $lng != ''){
                $residentlat = $lat;
                $residentlng = $lng;
            }else{
                $user_ip = $_SERVER['REMOTE_ADDR'];
                $json    = file_get_contents("http://ipinfo.io/$user_ip/geo");
                $json    = json_decode($json, true);
                $city    = $json['city'];
                $result = $this->CommonController->getLocationLatLong($city);
                $residentlat = $result['lat'];
                $residentlng = $result['lng'];
            }    
        }else if($user_id > 0){
            if($lat != '' && $lng != ''){
                $residentlat = $lat;
                $residentlng = $lng;
            }else{
                $where = ['a.id'=> $user_id];
                $joinArr[] = ['table' => 'tbl_member as g','link' => 'g.user_name=a.username','type' => 'left'];
                $data = $this->CommonController->SelectJoinMulti('users as a', $joinArr,$where,[],[],'a.id as userid, g.post_code as zipcode','','','',[],'','');
                $postalcode = isset($data[0]->zipcode)?$data[0]->zipcode:'';
                $result = $this->CommonController->getLocationLatLong($postalcode);
                $residentlat = $result['lat'];
                $residentlng = $result['lng']; 
            } 
        }
        
        $sql="SELECT b.id as businessid,b.name,c.zip_code,c.id as addressid,c.latitude,c.longitude from ads_setting_preferences as a INNER JOIN business as b ON a.businessid=b.id INNER JOIN address as c ON b.addressid=c.id JOIN `ads` as `d` ON `d`.`business_id`=`b`.`id` JOIN `ad_category_subcategory` as `e` ON `e`.`adid`=`d`.`id` WHERE a.settingszoneid=".$zone_id." AND a.approval NOT IN (-1, -2, 3, -3)";
        if($cat_id > 0){
            $sql .= " AND `e`.`catid`=".$cat_id."";
        }
        if($sub_cat_id > 0){
            $sql .= " AND `e`.`subcatid`=".$sub_cat_id."";   
        }
        if($albhabetvalue != ''){
            $sql .= " AND `b`.`name` LIKE '".trim($albhabetvalue)."%'";
        } 
        $businessazarr = $this->CommonController->SelectRawquery($sql,'result');
        if($type == 'total'){
            return $totalcount = count($businessazarr);
        }
        foreach ($businessazarr as $k => $v) {  
            $v->distance = 0;
            if($v->latitude != 0 && $v->longitude != 0 && $residentlat != 0 && $residentlng != 0){
                $v->distance = $this->getDistanceBetweenPointsNew($v->latitude, $v->longitude, $residentlat, $residentlng);
            }
            if($search_value == 10){if($v->distance < $search_value){unset($businessazarr[$k]);}
            }else{if($v->distance > $search_value){unset($businessazarr[$k]);}}
        }
        foreach ($businessazarr as $k => $v) {  
            $azArr[] = $v->businessid; 
        }
        if(count($azArr) > 0){
            if($lowerlimit == 1){ 
                $implodeArr = array_slice($azArr, 0, $upperlimit);
            }else{ 
                $implodeArr = array_slice($azArr, $lowerlimit, $upperlimit);
            }
            $inexplode = implode(',',$implodeArr);
            $sql="SELECT `a`.* FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` JOIN `users` as `c` ON `b`.`business_owner_id`=`c`.`id` JOIN `tbl_member` as `d` ON `c`.`username`=`d`.`user_name` JOIN `tbl_deals` as `e` ON `d`.`user_id`=`e`.`user_id` WHERE `a`.`settingszoneid` = ".$zone_id." AND `a`.`approval` NOT IN(-1, -2, 3, -3) AND b.id IN (".$inexplode.")";
            $data = $this->CommonController->SelectRawquery($sql,'result');
        }else{
            $data = [];
        }
    }

    $businesssettingdata = $data;
    if(count($businesssettingdata) <= 0){
        return $d;
    }
    foreach ($businesssettingdata as $k => $v) {
        $businessArr[] = $v->businessid; 
    }
    /*main data*/

    if(count($businessArr) > 0){
    //business table start
        $businessdata = $this->CommonController->SelectDataMultiWay('business','*','ArrayInR',[],array('column' => 'id','param' => $businessArr));
        foreach ($businessdata as $k1 => $v1) {
            $addressArr[] = $v1->addressid;   
            $business_owner_idArr[] = $v1->business_owner_id; 
            $businessAllDataArr[$v1->id] = $v1;  
        }     
        //business table end
        //ads table start
        $adsdata = $this->CommonController->SelectDataMultiWay('ads','*','ArrayInR',[],array('column' => 'business_id','param' => $businessArr));
        foreach ($adsdata as $k2 => $v2) { 
            $adsArrimage[] = $v2->id;
            $adsArr[$v2->business_id] = $v2;  
        }
        //ads table end
    }
    if(count($addressArr) > 0){
        //address table start
        $addressdata = $this->CommonController->SelectDataMultiWay('address','*','ArrayInR',[],array('column' => 'id','param' => $addressArr));
        foreach ($addressdata as $k3 => $v3) {
            $addressDataArr[$v3->id] = $v3;
        }
        //address table end
    }

    if(count($businessArr) > 0){
        //business_sponsor_order table start
        $business_sponsor_orderdata = $this->CommonController->SelectDataMultiWay('business_sponsor_order','*','ArrayInR',[],array('column' => 'business_id','param' => $businessArr));
        foreach ($business_sponsor_orderdata as $k4 => $v4) { 
            $business_sponsor_orderArr[$v4->business_id] = $v4;  
        }
        //business_sponsor_order table end
        
        //business_sponsor table start
        $business_sponsordata = $this->CommonController->SelectDataMultiWay('business_sponsor','*','ArrayInR',[],array('column' => 'business_id','param' => $businessArr));
        foreach ($business_sponsordata as $k5 => $v5) { 
            $business_sponsorArr[$v5->business_id] = $v5;  
        }
        //business_sponsor table end

        //business_sponsor_cat table start
        $business_sponsorcatdata = $this->CommonController->SelectDataMultiWay('business_sponsor_order_subcat','*','ArrayInR',[],array('column' => 'bussiness_id','param' => $businessArr));
        foreach ($business_sponsorcatdata as $k6 => $v6) { 
            $business_sponsorcatArr[$v6->bussiness_id] = $v6;  
        }
        //business_sponsor_cat table end

        //business_sponsor_cat table start
        $busimagedata = $this->CommonController->SelectDataMultiWay('business_photos','*','ArrayInR',[],array('column' => 'bus_id','param' => $businessArr));
        foreach ($busimagedata as $k7 => $v7) { 
            $busimageArr[$v7->bus_id] = $v7;  
        }
        //business_sponsor_cat table end
    }
    // users_group table start
    $saleszonedata = $this->CommonController->SelectDataMultiWay('sales_zone','*','ArrayInR',[],array('column' => 'id','param' => array($zone_id)));
    $zonename = isset($saleszonedata[0]->name)?$saleszonedata[0]->name:'';
    //users_group table end

    if(count($business_owner_idArr) > 0){
        //users table start
        $usersdata = $this->CommonController->SelectDataMultiWay('users','*','ArrayInR',[],array('column' => 'id','param' => $business_owner_idArr));
        foreach ($usersdata as $k8 => $v8) {
            $usersArr[] = $v8->id; 
            $usernameArr[] = $v8->username; 
            $userArr1[$v8->id] = $v8->username;
        }
        // users table end
    }
   
    if(count($usernameArr) > 0){
        //tbl_member table start
        $tbl_memberdata = $this->CommonController->SelectDataMultiWay('tbl_member','*','ArrayInR',[],array('column' => 'user_name','param' => $usernameArr));
        foreach ($tbl_memberdata as $k9 => $v9) {
            $usertblArr[] = $v9->user_id;  
            $tblmember1[$v9->user_name] = $v9->user_id;
        }
        // tbl_member table end
    }

    if(count($usertblArr) > 0){
        //tbl_deals table start
        $tbl_dealsdata = $this->CommonController->SelectDataMultiWay('tbl_deals','*','ArrayInR',[],array('column' => 'user_id','param' => $usertblArr));
        foreach ($tbl_dealsdata as $k10 => $v10) {
            $usertbldealsArr[] = $v10->user_id;  
            $tbldeals1[$v10->user_id] = $v10;
        }
        // tbl_deals table end   
    }
   
    if(count($usertblArr) > 0){
        //tbl_deals_product table start
        $tbl_dealsproductsdata = $this->CommonController->SelectDataMultiWay('tbl_deals_products','*','ArrayInR',[],array('column' => 'user_id','param' => $usertblArr));
        foreach ($tbl_dealsproductsdata as $k11 => $v11) {
            $usertbldealsprodcutsArr[] = $v11->user_id;  
            $tblproduct1[$v11->user_id] = $v11;
        }
        // tbl_deals_product table end
    }

    //ad_to_zone table start
    $adtozonedata = $this->CommonController->SelectDataMultiWay('ad_to_zone','*','result',['zoneid' => $zone_id,'approval' => 1],[]);
    foreach ($adtozonedata as $k12 => $v12) {  
        $atozone[$v12->adid] = $v12->stickyad;
    }
    // ad_to_zone table end

    //fav list  table start
    $favdata = $this->CommonController->SelectDataMultiWay('users_favorites','*','result',['zoneid' => $zone_id],[]);
    foreach ($favdata as $k13 => $v13) {  
        $favArr[$v13->adid][$v13->user_id] = $v13->favorites_id;
    }
    //fav list  table start

    // get a day and fill data
    
    $sql="SELECT * FROM `res_favfood_audio` WHERE `day`='".$currentday."'";
    $audioArr = $this->CommonController->SelectRawquery($sql,'resultArray');
    if(count($audioArr) > 0){
        foreach ($audioArr as $ak => $av) {
            $audioArr1[$av['business_id']] = $av;
        }
    }
    // get a day and fill data

    // get sub cat Array //
    if(count($adsArrimage) > 0){
        $subcatimageqry = $this->CommonController->SelectDataMultiWay('ad_category_subcategory','*','ArrayInR',[],array('column' => 'adid','param' => $adsArrimage));
        foreach ($subcatimageqry as $k15 => $v15) {
            if($v15->subcatid != -99){
                $subimageArr1[$v15->adid][] = $v15->subcatid;   
            }
        }

        if(count($subimageArr1) > 0){
            foreach ($subimageArr1 as $k16 => $v16) {
                foreach ($v16 as $v17) {
                    $sql99="SELECT * FROM `category_sub_subcategory_new` WHERE `id`='".$v17."'";
                    $image99 = $this->CommonController->SelectRawquery($sql99,'row'); 
                    $subcatimage99 = isset($image99->attachment_image)?$image99->attachment_image:'';
                    if($subcatimage99 != ''){
                        $subimageArr99[$k16][] = $subcatimage99;
                    }
                }
            }
        }
    }
    // get sub cat Array //
    foreach ($businesssettingdata as $k => $v) {
        $finalArr['adid'] = isset($adsArr[$v->businessid]->id)?$adsArr[$v->businessid]->id:'';
        $finalArr['adidsubcatimage'] = isset($subimageArr99[$finalArr['adid']])?$subimageArr99[$finalArr['adid']]:[];
        $finalArr['zoneid'] = $zone_id;
        $finalArr['adtext'] = isset($adsArr[$v->businessid]->adtext)?$adsArr[$v->businessid]->adtext:'';
        $finalArr['adtext'] = isset($adsArr[$v->businessid]->adtext)?$adsArr[$v->businessid]->adtext:'';
        $finalArr['deal_description'] = isset($adsArr[$v->businessid]->deal_description)?$adsArr[$v->businessid]->deal_description:'';
        $finalArr['deal_restriction'] = isset($adsArr[$v->businessid]->deal_restriction)?$adsArr[$v->businessid]->deal_restriction:'';
        $finalArr['admessage'] = isset($adsArr[$v->businessid]->text_message)?$adsArr[$v->businessid]->text_message:'';
        $finalArr['deal_restriction'] = isset($adsArr[$v->businessid]->deal_restriction)?$adsArr[$v->businessid]->deal_restriction:'';
        $finalArr['deliver'] = isset($adsArr[$v->businessid]->deliver)?$adsArr[$v->businessid]->deliver:'';
        $finalArr['deliver_zips'] = isset($adsArr[$v->businessid]->deliver_zips)?$adsArr[$v->businessid]->deliver_zips:'';
        $finalArr['imagetype'] = isset($adsArr[$v->businessid]->imagetype)?$adsArr[$v->businessid]->imagetype:'';
        $finalArr['docs_pdf'] = isset($adsArr[$v->businessid]->docs_pdf)?$adsArr[$v->businessid]->docs_pdf:'';
        $finalArr['search_engine_title'] = isset($adsArr[$v->businessid]->search_engine_title)?$adsArr[$v->businessid]->search_engine_title:'';
        $finalArr['audio_file'] = isset($adsArr[$v->businessid]->audio_file)?$adsArr[$v->businessid]->audio_file:'';
        $finalArr['video_file'] = isset($adsArr[$v->businessid]->video_file)?$adsArr[$v->businessid]->video_file:'';
        $finalArr['short_description'] = isset($adsArr[$v->businessid]->short_description)?$adsArr[$v->businessid]->short_description:'';
        $finalArr['foodmenu'] = isset($adsArr[$v->businessid]->foodmenu)?$adsArr[$v->businessid]->foodmenu:'';
        $finalArr['deal_title'] = isset($adsArr[$v->businessid]->deal_title)?$adsArr[$v->businessid]->deal_title:'';
        $finalArr['timestamp'] = isset($adsArr[$v->businessid]->timestamp)?$adsArr[$v->businessid]->timestamp:'';
        $finalArr['stickyad'] = isset($atozone[$finalArr['adid']])?$atozone[$finalArr['adid']]:'';
        $finalArr['bs_id'] = isset($businessAllDataArr[$v->businessid]->id)?$businessAllDataArr[$v->businessid]->id:$v->businessid;
        $finalArr['business_owner_id'] = isset($businessAllDataArr[$v->businessid]->business_owner_id)?$businessAllDataArr[$v->businessid]->business_owner_id:'';
        $finalArr['bs_logo'] = isset($businessAllDataArr[$v->businessid]->logo)?$businessAllDataArr[$v->businessid]->logo:'';
        $finalArr['bs_name'] = isset($businessAllDataArr[$v->businessid]->name)?$businessAllDataArr[$v->businessid]->name:'';
        $checkbs_slug = isset($businessAllDataArr[$v->businessid]->slugname)?$businessAllDataArr[$v->businessid]->slugname:'';
        $finalslug = $this->definebusinessdetailurl($checkbs_slug,$v);
        $finalArr['bs_slug'] = $finalslug;
        $finalArr['bs_commonimage'] = isset($businessAllDataArr[$v->businessid]->common_logo_image)?$businessAllDataArr[$v->businessid]->common_logo_image:'';
        $finalArr['bs_contactemail'] = isset($businessAllDataArr[$v->businessid]->contactemail)?$businessAllDataArr[$v->businessid]->contactemail:'';
        $finalArr['bs_contactf_name'] = isset($businessAllDataArr[$v->businessid]->contactfirstname)?$businessAllDataArr[$v->businessid]->contactfirstname:'';
        $finalArr['bs_contactl_name'] = isset($businessAllDataArr[$v->businessid]->contactlastname)?$businessAllDataArr[$v->businessid]->contactlastname:'';
        $finalArr['bs_website'] = isset($businessAllDataArr[$v->businessid]->website)?$businessAllDataArr[$v->businessid]->website:'';
        $finalArr['motto'] = isset($businessAllDataArr[$v->businessid]->motto)?$businessAllDataArr[$v->businessid]->motto:'';
        $finalArr['aboutus'] = isset($businessAllDataArr[$v->businessid]->aboutus)?$businessAllDataArr[$v->businessid]->aboutus:'';
        $finalArr['israted'] = isset($businessAllDataArr[$v->businessid]->israted)?$businessAllDataArr[$v->businessid]->israted:'';
        $finalArr['bs_type'] = isset($businessAllDataArr[$v->businessid]->type)?$businessAllDataArr[$v->businessid]->type:'';
        // $finalArr['websitevisibility'] = $v->websitevisibility;
        // $finalArr['emailvisibility'] = $v->emailvisibility;
        $address_idnew = isset($businessAllDataArr[$v->businessid]->addressid)?$businessAllDataArr[$v->businessid]->addressid:'';//address id
        $business_owner_id = isset($businessAllDataArr[$v->businessid]->business_owner_id)?$businessAllDataArr[$v->businessid]->business_owner_id:'';
        $username = isset($userArr1[$business_owner_id])?$userArr1[$business_owner_id]:''; 
        $tbl_user_id = isset($tblmember1[$username])?$tblmember1[$username]:'';
        $finalArr['username'] = $username;
        $finalArr['busid'] = $v->businessid;
        $finalArr['tbl_user_id'] = $tbl_user_id;
        $finalArr['user_idnew'] = $user_id;
        $finalArr['favresfinal'] = isset($favArr[$finalArr['adid']][$user_id])?$favArr[$finalArr['adid']][$user_id]:''; 
        $finalArr['bs_streetaddress1'] = isset($addressDataArr[$address_idnew]->street_address_1)?$addressDataArr[$address_idnew]->street_address_1:'';
        $finalArr['bs_streetaddress2'] = isset($addressDataArr[$address_idnew]->street_address_2)?$addressDataArr[$address_idnew]->street_address_2:'';
        $finalArr['bs_city'] = isset($addressDataArr[$address_idnew]->city)?$addressDataArr[$address_idnew]->city:'';
        $finalArr['bs_state'] = isset($addressDataArr[$address_idnew]->state)?$addressDataArr[$address_idnew]->state:'';
        $finalArr['bs_zipcode'] = isset($addressDataArr[$address_idnew]->zip_code)?$addressDataArr[$address_idnew]->zip_code:'';
        $finalArr['bs_phone'] = isset($addressDataArr[$address_idnew]->phone)?$addressDataArr[$address_idnew]->phone:'';
        $finalArr['bs_phone_int'] = isset($addressDataArr[$address_idnew]->phone_int)?$addressDataArr[$address_idnew]->phone_int:'';
        $finalArr['latitude'] = isset($addressDataArr[$address_idnew]->latitude)?$addressDataArr[$address_idnew]->latitude:'';
        $finalArr['longitude'] = isset($addressDataArr[$address_idnew]->longitude)?$addressDataArr[$address_idnew]->longitude:'';
        $finalArr['business_sponsor_status'] = isset($business_sponsorArr[$v->businessid]->status)?$business_sponsorArr[$v->businessid]->status:'';
        $finalArr['business_display_order'] = isset($business_sponsor_orderArr[$v->businessid]->display_order)?$business_sponsor_orderArr[$v->businessid]->display_order:100;
        $finalArr['business_display_order_cat'] = isset($business_sponsorcatArr[$v->businessid]->order_id)?$business_sponsorcatArr[$v->businessid]->order_id:1000;
        $finalArr['bus_image'] = isset($busimageArr[$v->businessid]->image_name)?$busimageArr[$v->businessid]->image_name:'';
        $finalArr['business_snap_status'] = isset($addressDataArr[$address_idnew]->snap_status)?$addressDataArr[$address_idnew]->snap_status:'';
        $finalArr['zone_name'] = $zonename;
        $finalArr['aucid'] = isset($tbldeals1[$tbl_user_id]->deal_id)?$tbldeals1[$tbl_user_id]->deal_id:'';
        $finalArr['company'] = isset($businessAllDataArr[$v->businessid]->name)?$businessAllDataArr[$v->businessid]->name:'';
        $finalArr['compfirstletter'] = strtolower(substr($finalArr['company'], 0, 1));
        $finalArr['starting_price'] = isset($tbldeals1[$tbl_user_id]->current_price)?$tbldeals1[$tbl_user_id]->current_price:0;
        $finalArr['redemptionvalue'] = isset($tbldeals1[$tbl_user_id]->buy_price_decrease_by)?$tbldeals1[$tbl_user_id]->buy_price_decrease_by:0;
        $finalArr['auction_start_day'] = isset($tbldeals1[$tbl_user_id]->start_date)?$tbldeals1[$tbl_user_id]->start_date:'';
        $finalArr['deal_id'] = isset($tbldeals1[$tbl_user_id]->deal_id)?$tbldeals1[$tbl_user_id]->deal_id:'';
        $finalArr['free_peeks'] = isset($tblproduct1[$tbl_user_id]->seller_credit)?$tblproduct1[$tbl_user_id]->seller_credit:0;
        $publisher_fee = isset($tblproduct1[$tbl_user_id]->publisher_fee)?$tblproduct1[$tbl_user_id]->publisher_fee:0;
        $finalArr['savings_ammount'] =  $finalArr['redemptionvalue']- $finalArr['starting_price']-$publisher_fee;
        $finalArr['deal_start_date'] = isset($tbldeals1[$tbl_user_id]->start_date)?$tbldeals1[$tbl_user_id]->start_date:'';
        $finalArr['deal_end_date'] = isset($tbldeals1[$tbl_user_id]->end_date)?$tbldeals1[$tbl_user_id]->end_date:'';
        $finalArr['service_number'] = isset($businessAllDataArr[$v->businessid]->service_number)?$businessAllDataArr[$v->businessid]->service_number:'';

        $adidnew = isset($adsArr[$v->businessid]->id)?$adsArr[$v->businessid]->id:'';
        $catidnew = $this->CommonController->SelectDataMultiWay('ad_category_subcategory','catid','rowArray',['adid'=> $adidnew,'zoneid' => $zone_id],[],'',[]);
        $finalArr['catidnew1'] = isset($catidnew['catid'])?$catidnew['catid']:0; 
        $finalArr['catidnew'] = isset($businessAllDataArr[$v->businessid]->type)?$businessAllDataArr[$v->businessid]->type:0; 
        $finalArr['insert_via_csv'] = isset($businessAllDataArr[$v->businessid]->insert_via_csv)?$businessAllDataArr[$v->businessid]->insert_via_csv:0;
        $finalArr['food_audio'] = isset($audioArr1[$v->businessid]['audio'])?$audioArr1[$v->businessid]['audio']:'';
        $finalArr['food_pdf'] = isset($audioArr1[$v->businessid]['pdf'])?$audioArr1[$v->businessid]['pdf']:''; 
        $finalArr['food_day'] = $newDate; 
        /*extra array*/
        $d[] = $finalArr;
        /*extra array*/
    }
    $emptyArr = [];
    /*main data*/
    if($charval == 'redemption_high' || $sortbyvalue == 'redemption_high'){
        $price = array_column($d, 'redemptionvalue');
        array_multisort($price, SORT_DESC, $d);
    }elseif($charval == 'redemption_low' || $sortbyvalue == 'redemption_low'){
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }    
        $price = array_column($fullarray, 'redemptionvalue');
        array_multisort($price, SORT_ASC, $fullarray);
        $d = array_merge($fullarray, $emptyArr); 
    }elseif($charval == 'deal_price_high' || $sortbyvalue == 'deal_price_high'){
        $price = array_column($d, 'starting_price');
        array_multisort($price, SORT_DESC, $d);
    }elseif($charval == 'deal_price_low' || $sortbyvalue == 'deal_price_low'){
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }  
        $price = array_column($fullarray, 'starting_price');
        array_multisort($price, SORT_ASC, $fullarray);  
        $d = array_merge($fullarray, $emptyArr);
    }elseif($charval == 'high to low' || $sortbyvalue == 'high to low'){
        $price = array_column($d, 'savings_ammount');
        array_multisort($price, SORT_DESC, $d);
    }elseif($charval == 'low to high' || $sortbyvalue == 'low to high'){
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }  
        $price = array_column($fullarray, 'savings_ammount');
        array_multisort($price, SORT_ASC, $fullarray);  
        $d = array_merge($fullarray, $emptyArr);
    }elseif($charval == 'a-z' || $sortbyvalue == 'a-z'){
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }  
        $price = array_column($fullarray, 'compfirstletter');
        array_multisort($price, SORT_ASC, $fullarray); 

        $price1 = array_column($emptyArr, 'compfirstletter');
        array_multisort($price1, SORT_ASC, $emptyArr); 
        $d = array_merge($fullarray, $emptyArr);
    }elseif($charval == 'z-a' || $sortbyvalue == 'z-a'){
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }  
        $price = array_column($fullarray, 'compfirstletter');
        array_multisort($price, SORT_DESC, $fullarray); 

        $price1 = array_column($emptyArr, 'compfirstletter');
        array_multisort($price1, SORT_DESC, $emptyArr); 
        $d = array_merge($fullarray, $emptyArr);
    }elseif(!empty($user_id) && $cat_id == ''){ // show_favorites_ads
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }    
        $price = array_column($fullarray, 'redemptionvalue');
        array_multisort($price, SORT_ASC, $fullarray);
        $d = array_merge($fullarray, $emptyArr); 
    }elseif($page_dest == 'show_all_offers'){
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }    
        $price = array_column($fullarray, 'redemptionvalue');
        array_multisort($price, SORT_ASC, $fullarray);
        $d = array_merge($fullarray, $emptyArr);
    }
    /*snap dining data*/
    $nopersonArr = $foodorderArr = $outDoorDiningArr = [];
    if($snapdinnig == 'open'){
        $snapdinnig = $this->diningmodel->getSearchQueryData($noOfPerson,$searchDate,$time,$foodType,0,0,false,$zone_id,$userId,'MAXDISCOUNT',$outDoorDining);
        if(count($snapdinnig['restaurantDetails']) > 0){
            foreach ($snapdinnig['restaurantDetails'] as $k => $v) {
                $dbusiness_id = ($v['basicInfo'])?$v['basicInfo']->business_id:'';
                    if($dbusiness_id > 0){ 
                        if(is_array($v['availableTable']['availableTableData'])){
                            foreach ($v['availableTable']['availableTableData'] as $k1 => $v1) {
                                if(isset($nopersonArr[$v1['business_id']])){
                                    $nopersonArr[$dbusiness_id] += $v1['seats'];
                                }else{
                                    $nopersonArr[$dbusiness_id] = $v1['seats'];
                                }
                            }
                        }
                    if(is_array($v['foodOffered'])){
                        foreach ($v['foodOffered'] as $k2 => $v2) {
                            $this->db->select('id');
                            $this->db->from('restaurantbooking_food_offered');
                            $this->db->where('food_name', $v2['foodName']);
                            $query = $this->db->get()->row();
                            $food_id = $query->id;
                            $foodorderArr[$dbusiness_id] = $food_id;
                        }
                    }
                    if($outDoorDining == 1){
                        $sql="SELECT * FROM restaurantbooking_options rop WHERE rop.key = 'o_outdoor_dining' and substring_index(rop.value, '::', -1) = 'Yes'";
                        $query=$this->db->query($sql);
                        $result = $query->result_array();
                        foreach ($result as $k3 => $v3) {
                            $outDoorDiningArr[$v3['business_id']] = 'yes';
                        }
                    }
                }
            }
        } 
        foreach ($d as $k6 => $v6) {
            $d[$k6]['noofperson'] = isset($nopersonArr[$v6['bs_id']])?$nopersonArr[$v6['bs_id']]:''; 
            $d[$k6]['foodtypeid'] = isset($foodorderArr[$v6['bs_id']])?$foodorderArr[$v6['bs_id']]:''; 
            $d[$k6]['outdoordinnig'] = isset($outDoorDiningArr[$v6['bs_id']])?$outDoorDiningArr[$v6['bs_id']]:''; 
        }
        foreach ($d as $k7 => $v7) {
            if($noOfPerson > $v7['noofperson']){
                unset($d[$k7]);
            }
            if($foodType > 0){
                if($foodType != $v7['foodtypeid']){
                    unset($d[$k7]);
                }
            }
        }
    }
    /*snap dining data*/
    return $d;
}

    public function definebusinessdetailurl($slug = '', $arr = []){
        $newslug = '';
        $businessid = $arr->businessid;
        if($slug != ''){
            $slug = str_replace("'","",$slug);
            $slugqry = "SELECT * FROM business as a LEFT JOIN address as b ON a.addressid=b.id WHERE a.slugname='".$slug."' ";
            $slugArr = $this->CommonController->SelectRawquery($slugqry);

            if(count($slugArr) > 0){
                $businessuserid = $slugArr[0]['business_owner_id'];
                $businessaddress = $slugArr[0]['street_address_1'];
                $businesszip_code = $slugArr[0]['zip_code'];

                $filterfirstuserid = substr($businessuserid, 0, 2);
                $filterlastuserid = substr($businessuserid, 3, 2);
                if(count($slugArr) > 1){
                    if($businessaddress != ''){
                        $street_address = str_replace(' ','_',$businessaddress);
                        $newslug = $slug.'_'.$street_address.time();
                    }else{
                        if($businesszip_code > 0){
                            $newslug = $slug.'_'.$businesszip_code.time();
                        }else{
                            $newslug = $slug.'_'.$filterlastuserid.date('Y').$filterfirstuserid;
                        }
                    }
                    $this->CommonController->updateData('business',array('slugname'=>$newslug),['id' =>$businessid]);
                }else{
                    $newslug = $slug;
                }
            }else{
                return $slug;        
            }
        }
        return $newslug;
    }

function get_ads_for_all_athena_latest_working_anishnewold($zone_id=0,$lowerlimit=0,$upperlimit=0,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 0,$page=0,$page_dest = 0){
    
    /*define empty Arr*/
    $businessArr = $addressArr = $business_owner_idArr = $usersArr = $finalArr = $adsArr = $addressDataArr = $business_sponsor_orderArr = $business_sponsorArr = $business_sponsorcatArr = $busimageArr = $usernameArr = $usertblArr = $usertbldealsArr = $usertbldealsprodcutsArr =$atozone =[];
     $userArr1 = $tblmember1 = $tbldeals1 = $tblproduct1 = [];
    $d = [];
    /*define empty Arr*/

    /*main data*/
    if($page_dest == 'show_ads_specific_category' && $charval == ''){
        $InArr = $OutArr = $datainsertArr = [];
        /*deal available date array*/    
        $inthedateArr ="SELECT `a`.*, `e`.`current_price`, `e`.`start_date`, `e`.`end_date`, `e`.`deal_id` FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` JOIN `users` as `c` ON `b`.`business_owner_id`=`c`.`id` JOIN `tbl_member` as `d` ON `c`.`username`=`d`.`user_name` JOIN `tbl_deals` as `e` ON `d`.`user_id`=`e`.`user_id` WHERE `a`.`settingszoneid` = ".$zone_id." AND `a`.`approval` NOT IN(-1, -2, 3, -3) and ('".date('Y-m-d')."' BETWEEN e.start_date AND DATE_FORMAT(e.end_date, '%Y-%m-%d'))";
        $inhdata = $this->CommonController->SelectRawquery($inthedateArr, 'result');
        foreach ($inhdata as $key => $v) { $InArr[] = $v->businessid; }
        $inexplodenew = implode(',',$InArr);
        /*deal not available date array*/
        if($inexplodenew != ''){
            $sql="SELECT `a`.*,`b`.name FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` WHERE `a`.`settingszoneid` = ".$zone_id." AND `b`.`id` NOT IN (".$inexplodenew.")";
            $data = $this->CommonController->SelectRawquery($sql, 'result');
        }else{
            $sql="SELECT `a`.*,`b`.name FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` WHERE `a`.`settingszoneid` = ".$zone_id." LIMIT ".$lowerlimit.", ".$upperlimit."";
            $data = $this->CommonController->SelectRawquery($sql, 'result');
        }
        
        foreach ($data as $k1 => $v1) { $OutArr[] = $v1->businessid;}
        /*deal not available date array*/
       
        $combineArr = array_merge(array_unique($InArr),$OutArr);  
       
        if($lowerlimit == 1){ $implodeArr = array_slice($combineArr, 0, $upperlimit);
        }else{ $implodeArr = array_slice($combineArr, $lowerlimit, $upperlimit);}
        
        $inexplode = implode(',',$implodeArr);

        $sql="SELECT `a`.* FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` JOIN `users` as `c` ON `b`.`business_owner_id`=`c`.`id`  WHERE `a`.`settingszoneid` = ".$zone_id." AND `a`.`approval` NOT IN(-1, -2, 3, -3)  and `b`.`id` IN(".$inexplode.")";
        $data1 = $this->CommonController->SelectRawquery($sql, 'result');
        foreach ($implodeArr as $ki => $vi) {
            foreach ($data1 as $ke => $va) {
                if($vi === $va->businessid){
                    $datainsertArr[$vi] = $va;
                }
            }
        }
        $data = $datainsertArr;
        
    }
    
    if($charval == 'redemption_high' || $charval == 'redemption_low' || $charval == 'deal_price_high' || $charval == 'deal_price_low' || $charval == 'high to low' || $charval == 'low to high' || $charval == 'a-z' || $charval == 'z-a'){
        $order_by = '';
        if($charval == 'redemption_high' || $charval == 'high to low'){
            $order_by = '`buy_price_decrease_by` DESC';
        }
        if($charval == 'redemption_low' || $charval == 'low to high'){
            $order_by = '`buy_price_decrease_by` ASC';
        }
        if($charval == 'deal_price_high'){
            $order_by = '`current_price` DESC';
        }
        if($charval == 'deal_price_low'){
            $order_by = '`current_price` ASC';
        }
        if($charval == 'a-z'){
            $order_by = '`name` ASC';
        }
        if($charval == 'z-a'){
            $order_by = '`name` DESC';
        }
        $sql="SELECT `a`.*, `e`.`current_price`, `e`.`start_date`, `e`.`end_date` FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` JOIN `users` as `c` ON `b`.`business_owner_id`=`c`.`id` JOIN `tbl_member` as `d` ON `c`.`username`=`d`.`user_name` JOIN `tbl_deals` as `e` ON `d`.`user_id`=`e`.`user_id` WHERE `a`.`settingszoneid` = ".$zone_id." AND `a`.`approval` NOT IN(-1, -2, 3, -3)  and ('".date('Y-m-d')."' BETWEEN e.start_date AND DATE_FORMAT(e.end_date, '%Y-%m-%d')) ORDER BY ".$order_by." LIMIT ".$lowerlimit.", ".$upperlimit."";
        $query_ads = $this->db->query($sql);
        $data = $query_ads->result();
    }
    if(!empty($user_id)){ // show_favorites_ads
        $this->db->select('a.*');
        $this->db->join('business as b', 'a.businessid=b.id');
        $this->db->join('ads as c', 'b.id=c.business_id');
        $this->db->join('users_favorites as d', 'c.id=d.adid');
        $this->db->where(['a.settingszoneid'=> $zone_id,'d.zoneid' => $zone_id]);
        $this->db->where('c.categoryid !=', -99);
        $data = $this->db->get('ads_setting_preferences as a')->result();
    }
    if($page_dest == 'show_all_offers' || $search_value == 'show_search_business'){
        if($charval == ''){
            $this->db->select('*');
            $this->db->join('business_sponsor_order as b', 'a.businessid=b.business_id');
            $this->db->where(['a.settingszoneid'=> $zone_id]);
            $this->db->where_not_in('a.approval', array(-1,-2, 3, -3));
            $this->db->order_by('display_order', 'ASC');
            $data = $this->db->get('ads_setting_preferences as a',$upperlimit, $lowerlimit)->result();    
        }else{
            $words = explode("'",$charval);
            $charval =$words[0];
            $sql="SELECT `a`.*,`b`.name FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` WHERE `b`.`name` LIKE '".trim($charval)."%' AND `a`.`settingszoneid` = ".$zone_id."";
            $query_ads = $this->db->query($sql);
            $data = $query_ads->result();   
        }
    }

    $businesssettingdata = $data;
    // echo "<pre>";print_r($businesssettingdata);die;
    foreach ($businesssettingdata as $k => $v) {
        $businessArr[] = $v->businessid; 
    }
    /*main data*/
    if(count($businesssettingdata) <= 0){
        return $d;
    }

    if(count($businessArr) > 0){
    //business table start
        $businessdata = $this->CommonController->SelectDataMultiWay('business','*','ArrayInR',[],array('column' => 'id','param' => $businessArr));
        foreach ($businessdata as $k1 => $v1) {
            $addressArr[] = $v1->addressid;   
            $business_owner_idArr[] = $v1->business_owner_id; 
            $businessAllDataArr[$v1->id] = $v1;  
        }     
        //business table end
        //ads table start
        $adsdata = $this->CommonController->SelectDataMultiWay('ads','*','ArrayInR',[],array('column' => 'business_id','param' => $businessArr));
        foreach ($adsdata as $k2 => $v2) { 
            $adsArr[$v2->business_id] = $v2;  
        }
        //ads table end
    }
    if(count($addressArr) > 0){
        //address table start
        $addressdata = $this->CommonController->SelectDataMultiWay('address','*','ArrayInR',[],array('column' => 'id','param' => $addressArr));
        foreach ($addressdata as $k3 => $v3) {
            $addressDataArr[$v3->id] = $v3;
        }
        //address table end
    }

    if(count($businessArr) > 0){
        //business_sponsor_order table start
        $business_sponsor_orderdata = $this->CommonController->SelectDataMultiWay('business_sponsor_order','*','ArrayInR',[],array('column' => 'business_id','param' => $businessArr));
        foreach ($business_sponsor_orderdata as $k4 => $v4) { 
            $business_sponsor_orderArr[$v4->business_id] = $v4;  
        }
        //business_sponsor_order table end
        
        //business_sponsor table start
        $business_sponsordata = $this->CommonController->SelectDataMultiWay('business_sponsor','*','ArrayInR',[],array('column' => 'business_id','param' => $businessArr));
        foreach ($business_sponsordata as $k5 => $v5) { 
            $business_sponsorArr[$v5->business_id] = $v5;  
        }
        //business_sponsor table end

        //business_sponsor_cat table start
        $business_sponsorcatdata = $this->CommonController->SelectDataMultiWay('business_sponsor_order_subcat','*','ArrayInR',[],array('column' => 'bussiness_id','param' => $businessArr));
        foreach ($business_sponsorcatdata as $k6 => $v6) { 
            $business_sponsorcatArr[$v6->bussiness_id] = $v6;
        }
        //business_sponsor_cat table end

        //business_sponsor_cat table start
        $busimagedata = $this->CommonController->SelectDataMultiWay('business_photos','*','ArrayInR',[],array('column' => 'bus_id','param' => $businessArr));
        foreach ($busimagedata as $k7 => $v7) { 
            $busimageArr[$v7->bus_id] = $v7;  
        }
        //business_sponsor_cat table end
    }
    // users_group table start
    $saleszonedata = $this->CommonController->SelectDataMultiWay('sales_zone','*','ArrayInR',[],array('column' => 'id','param' => array($zone_id)));
    $zonename = isset($saleszonedata[0]->name)?$saleszonedata[0]->name:'';
    //users_group table end

    if(count($business_owner_idArr) > 0){
        //users table start
        $usersdata = $this->CommonController->SelectDataMultiWay('users','*','ArrayInR',[],array('column' => 'id','param' => $business_owner_idArr));
        foreach ($usersdata as $k8 => $v8) {
            $usersArr[] = $v8->id; 
            $usernameArr[] = $v8->username; 
            $userArr1[$v8->id] = $v8->username;
        }
        // users table end
    }
   
    if(count($usernameArr) > 0){
        //tbl_member table start
        $tbl_memberdata = $this->CommonController->SelectDataMultiWay('tbl_member','*','ArrayInR',[],array('column' => 'user_name','param' => $usernameArr));
        foreach ($tbl_memberdata as $k9 => $v9) {
            $usertblArr[] = $v9->user_id;  
            $tblmember1[$v9->user_name] = $v9->user_id;
        }
        // tbl_member table end
    }

    if(count($usertblArr) > 0){
        //tbl_deals table start
        $tbl_dealsdata = $this->CommonController->SelectDataMultiWay('tbl_deals','*','ArrayInR',[],array('column' => 'user_id','param' => $usertblArr));
        foreach ($tbl_dealsdata as $k10 => $v10) {
            $usertbldealsArr[] = $v10->user_id;  
            $tbldeals1[$v10->user_id] = $v10;
        }
        // tbl_deals table end   
    }
   
    if(count($usertblArr) > 0){
        //tbl_deals_product table start
        $tbl_dealsproductsdata = $this->CommonController->SelectDataMultiWay('tbl_deals_products','*','ArrayInR',[],array('column' => 'user_id','param' => $usertblArr));
        foreach ($tbl_dealsproductsdata as $k11 => $v11) {
            $usertbldealsprodcutsArr[] = $v11->user_id;  
            $tblproduct1[$v11->user_id] = $v11;
        }
        //tbl_deals_product table end
    }

    //ad_to_zone table start
    $adtozonedata = $this->CommonController->SelectDataMultiWay('ad_to_zone','*','result',['zoneid' => $zone_id,'approval' => 1],[]);
    foreach ($adtozonedata as $k12 => $v12) {  
        $atozone[$v12->adid] = $v12->stickyad;
    }
    // ad_to_zone table end
    
    foreach ($businesssettingdata as $k => $v) {
        $finalArr['adid'] = isset($adsArr[$v->businessid]->id)?$adsArr[$v->businessid]->id:'';
        $finalArr['zoneid'] = $zone_id;
        $finalArr['adtext'] = isset($adsArr[$v->businessid]->adtext)?$adsArr[$v->businessid]->adtext:'';
        $finalArr['adtext'] = isset($adsArr[$v->businessid]->adtext)?$adsArr[$v->businessid]->adtext:'';
        $finalArr['deal_description'] = isset($adsArr[$v->businessid]->deal_description)?$adsArr[$v->businessid]->deal_description:'';
        $finalArr['deal_restriction'] = isset($adsArr[$v->businessid]->deal_restriction)?$adsArr[$v->businessid]->deal_restriction:'';
        $finalArr['admessage'] = isset($adsArr[$v->businessid]->text_message)?$adsArr[$v->businessid]->text_message:'';
        $finalArr['deal_restriction'] = isset($adsArr[$v->businessid]->deal_restriction)?$adsArr[$v->businessid]->deal_restriction:'';
        $finalArr['deliver'] = isset($adsArr[$v->businessid]->deliver)?$adsArr[$v->businessid]->deliver:'';
        $finalArr['deliver_zips'] = isset($adsArr[$v->businessid]->deliver_zips)?$adsArr[$v->businessid]->deliver_zips:'';
        $finalArr['imagetype'] = isset($adsArr[$v->businessid]->imagetype)?$adsArr[$v->businessid]->imagetype:'';
        $finalArr['docs_pdf'] = isset($adsArr[$v->businessid]->docs_pdf)?$adsArr[$v->businessid]->docs_pdf:'';
        $finalArr['search_engine_title'] = isset($adsArr[$v->businessid]->search_engine_title)?$adsArr[$v->businessid]->search_engine_title:'';
        $finalArr['audio_file'] = isset($adsArr[$v->businessid]->audio_file)?$adsArr[$v->businessid]->audio_file:'';
        $finalArr['video_file'] = isset($adsArr[$v->businessid]->video_file)?$adsArr[$v->businessid]->video_file:'';
        $finalArr['foodmenu'] = isset($adsArr[$v->businessid]->foodmenu)?$adsArr[$v->businessid]->foodmenu:'';
        $finalArr['deal_title'] = isset($adsArr[$v->businessid]->deal_title)?$adsArr[$v->businessid]->deal_title:'';
        $finalArr['timestamp'] = isset($adsArr[$v->businessid]->timestamp)?$adsArr[$v->businessid]->timestamp:'';
        $finalArr['stickyad'] = isset($atozone[$finalArr['adid']])?$atozone[$finalArr['adid']]:'';
        $finalArr['bs_id'] = isset($businessAllDataArr[$v->businessid]->id)?$businessAllDataArr[$v->businessid]->id:'';
        $finalArr['bs_logo'] = isset($businessAllDataArr[$v->businessid]->logo)?$businessAllDataArr[$v->businessid]->logo:'';
        $finalArr['bs_name'] = isset($businessAllDataArr[$v->businessid]->name)?$businessAllDataArr[$v->businessid]->name:'';
        $finalArr['bs_commonimage'] = isset($businessAllDataArr[$v->businessid]->common_logo_image)?$businessAllDataArr[$v->businessid]->common_logo_image:'';
        $finalArr['bs_contactemail'] = isset($businessAllDataArr[$v->businessid]->contactemail)?$businessAllDataArr[$v->businessid]->contactemail:'';
        $finalArr['bs_contactf_name'] = isset($businessAllDataArr[$v->businessid]->contactfirstname)?$businessAllDataArr[$v->businessid]->contactfirstname:'';
        $finalArr['bs_contactl_name'] = isset($businessAllDataArr[$v->businessid]->contactlastname)?$businessAllDataArr[$v->businessid]->contactlastname:'';
        $finalArr['bs_website'] = isset($businessAllDataArr[$v->businessid]->website)?$businessAllDataArr[$v->businessid]->website:'';
        $finalArr['motto'] = isset($businessAllDataArr[$v->businessid]->motto)?$businessAllDataArr[$v->businessid]->motto:'';
        $finalArr['aboutus'] = isset($businessAllDataArr[$v->businessid]->aboutus)?$businessAllDataArr[$v->businessid]->aboutus:'';
        $finalArr['israted'] = isset($businessAllDataArr[$v->businessid]->israted)?$businessAllDataArr[$v->businessid]->israted:'';
        $finalArr['bs_type'] = isset($businessAllDataArr[$v->businessid]->type)?$businessAllDataArr[$v->businessid]->type:'';
        $finalArr['websitevisibility'] = $v->websitevisibility;
        $finalArr['emailvisibility'] = $v->emailvisibility;
        $address_idnew = isset($businessAllDataArr[$v->businessid]->addressid)?$businessAllDataArr[$v->businessid]->addressid:'';//address id
        $business_owner_id = isset($businessAllDataArr[$v->businessid]->business_owner_id)?$businessAllDataArr[$v->businessid]->business_owner_id:'';
        $username = isset($userArr1[$business_owner_id])?$userArr1[$business_owner_id]:''; 
        $tbl_user_id = isset($tblmember1[$username])?$tblmember1[$username]:'';
        $finalArr['username'] = $username;
        $finalArr['busid'] = $v->businessid;
        $finalArr['tbl_user_id'] = $tbl_user_id;
        $finalArr['bs_streetaddress1'] = isset($addressDataArr[$address_idnew]->street_address_1)?$addressDataArr[$address_idnew]->street_address_1:'';
        $finalArr['bs_streetaddress2'] = isset($addressDataArr[$address_idnew]->street_address_2)?$addressDataArr[$address_idnew]->street_address_2:'';
        $finalArr['bs_city'] = isset($addressDataArr[$address_idnew]->city)?$addressDataArr[$address_idnew]->city:'';
        $finalArr['bs_state'] = isset($addressDataArr[$address_idnew]->state)?$addressDataArr[$address_idnew]->state:'';
        $finalArr['bs_zipcode'] = isset($addressDataArr[$address_idnew]->zip_code)?$addressDataArr[$address_idnew]->zip_code:'';
        $finalArr['bs_phone'] = isset($addressDataArr[$address_idnew]->phone)?$addressDataArr[$address_idnew]->phone:'';
        $finalArr['bs_phone_int'] = isset($addressDataArr[$address_idnew]->phone_int)?$addressDataArr[$address_idnew]->phone_int:'';
        $finalArr['latitude'] = isset($addressDataArr[$address_idnew]->latitude)?$addressDataArr[$address_idnew]->latitude:'';
        $finalArr['longitude'] = isset($addressDataArr[$address_idnew]->longitude)?$addressDataArr[$address_idnew]->longitude:'';
        $finalArr['business_sponsor_status'] = isset($business_sponsorArr[$v->businessid]->status)?$business_sponsorArr[$v->businessid]->status:'';
        $finalArr['business_display_order'] = isset($business_sponsor_orderArr[$v->businessid]->display_order)?$business_sponsor_orderArr[$v->businessid]->display_order:100;
        $finalArr['business_display_order_cat'] = isset($business_sponsorcatArr[$v->businessid]->order_id)?$business_sponsorcatArr[$v->businessid]->order_id:1000;
        $finalArr['bus_image'] = isset($busimageArr[$v->businessid]->image_name)?$busimageArr[$v->businessid]->image_name:'';
        $finalArr['zone_name'] = $zonename;
        $finalArr['aucid'] = isset($tbldeals1[$tbl_user_id]->deal_id)?$tbldeals1[$tbl_user_id]->deal_id:'';
        $finalArr['company'] = isset($businessAllDataArr[$v->businessid]->name)?$businessAllDataArr[$v->businessid]->name:'';
        $finalArr['compfirstletter'] = strtolower(substr($finalArr['company'], 0, 1));
        $finalArr['starting_price'] = isset($tbldeals1[$tbl_user_id]->current_price)?$tbldeals1[$tbl_user_id]->current_price:0;
        $finalArr['redemptionvalue'] = isset($tbldeals1[$tbl_user_id]->buy_price_decrease_by)?$tbldeals1[$tbl_user_id]->buy_price_decrease_by:0;
        $finalArr['auction_start_day'] = isset($tbldeals1[$tbl_user_id]->start_date)?$tbldeals1[$tbl_user_id]->start_date:'';
        $finalArr['free_peeks'] = isset($tblproduct1[$tbl_user_id]->seller_credit)?$tblproduct1[$tbl_user_id]->seller_credit:0;
        $publisher_fee = isset($tblproduct1[$tbl_user_id]->publisher_fee)?$tblproduct1[$tbl_user_id]->publisher_fee:0;
        $finalArr['savings_ammount'] =  $finalArr['redemptionvalue']- $finalArr['starting_price']-$publisher_fee;
        $finalArr['deal_start_date'] = isset($tbldeals1[$tbl_user_id]->start_date)?$tbldeals1[$tbl_user_id]->start_date:'';
        $finalArr['deal_end_date'] = isset($tbldeals1[$tbl_user_id]->end_date)?$tbldeals1[$tbl_user_id]->end_date:'';

        /*extra array*/
        $d[] = $finalArr;
        /*extra array*/
    }
    $emptyArr = [];
    
    /*main data*/
    if($charval == 'redemption_high'){
        $price = array_column($d, 'redemptionvalue');
        array_multisort($price, SORT_DESC, $d);
    }elseif($charval == 'redemption_low'){
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }    
        $price = array_column($fullarray, 'redemptionvalue');
        array_multisort($price, SORT_ASC, $fullarray);
        $d = array_merge($fullarray, $emptyArr); 
    }elseif($charval == 'deal_price_high'){
        $price = array_column($d, 'starting_price');
        array_multisort($price, SORT_DESC, $d);
    }elseif($charval == 'deal_price_low'){
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }  
        $price = array_column($fullarray, 'starting_price');
        array_multisort($price, SORT_ASC, $fullarray);  
        $d = array_merge($fullarray, $emptyArr);
    }elseif($charval == 'high to low'){
        $price = array_column($d, 'savings_ammount');
        array_multisort($price, SORT_DESC, $d);
    }elseif($charval == 'low to high'){
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }  
        $price = array_column($fullarray, 'savings_ammount');
        array_multisort($price, SORT_ASC, $fullarray);  
        $d = array_merge($fullarray, $emptyArr);
    }elseif($charval == 'a-z'){
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }  
        $price = array_column($fullarray, 'compfirstletter');
        array_multisort($price, SORT_ASC, $fullarray); 

        $price1 = array_column($emptyArr, 'compfirstletter');
        array_multisort($price1, SORT_ASC, $emptyArr); 
        $d = array_merge($fullarray, $emptyArr);
    }elseif($charval == 'z-a'){
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }  
        $price = array_column($fullarray, 'compfirstletter');
        array_multisort($price, SORT_DESC, $fullarray); 

        $price1 = array_column($emptyArr, 'compfirstletter');
        array_multisort($price1, SORT_DESC, $emptyArr); 
        $d = array_merge($fullarray, $emptyArr);
    }elseif(!empty($user_id)){ // show_favorites_ads
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }    
        $price = array_column($fullarray, 'redemptionvalue');
        array_multisort($price, SORT_ASC, $fullarray);
        $d = array_merge($fullarray, $emptyArr); 
    }elseif($page_dest == 'show_all_offers'){
        $fullarray = [];
        foreach ($d as $k21 => $v21) {
            if($v21['starting_price'] <= 0){$emptyArr[] = $v21;
            }else{$fullarray[] = $v21;}
        }    
        $price = array_column($fullarray, 'redemptionvalue');
        array_multisort($price, SORT_ASC, $fullarray);
        $d = array_merge($fullarray, $emptyArr);
    }
    return $d;
} 

public function get_ads_for_all_athena_latest_working_anishtotal($zone_id=0,$lowerlimit=0,$upperlimit=0,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 0,$page=0,$page_dest = 0,$type = '',$sortbyvalue = '',$albhabetvalue = ''){
    $busArr1 = [];
    if($page_dest == 'show_all_offers'){
        if($charval == ''){
            if($lowerlimit == 1){
                $lowerlimit = 0;
            }
            $where = ['a.zoneid'=> $zone_id,'c.catid'=> 1];
            $orderby = ['display_order'=> 'ASC'];
            $joinArr[] = ['table' => 'ads as b','link' => 'a.business_id=b.business_id','type' => 'left']; 
            $joinArr[] = ['table' => 'ad_category_subcategory as c','link' => 'b.id=c.adid','type' => 'left'];
            $data = $this->CommonController->SelectJoinMulti('business_sponsor_order as a', $joinArr,$where,[], $orderby,'a.business_id as businessid','','');   
        }else{
            $words = explode("'",$charval);
            $charval =$words[0];
            
            $albhabetsql="SELECT `a`.*,`b`.name FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` JOIN `ads` as `c` ON `c`.`business_id`=`b`.`id` JOIN `ad_category_subcategory` as `d` ON `d`.`adid`=`c`.`id` WHERE `b`.`name` LIKE '".trim($charval)."%' AND `a`.`settingszoneid` = ".$zone_id."";
            if($cat_id > 0){
                $albhabetsql .= " AND `d`.`catid` = ".$cat_id."";
            }
            if($sub_cat_id > 0){
                $albhabetsql .= " AND `d`.`subcatid` = ".$sub_cat_id."";   
            }
            $data = $this->CommonController->SelectRawquery($albhabetsql,'result');
        }
        $data = count($data);
    }
    if($page_dest == 'show_ads_specific_category' && $charval == ''){
        if($lowerlimit == 1){
            $lowerlimit = 0;
        }
        $where = ['a.zoneid'=> $zone_id,'c.catid'=> $cat_id];
        $orderby = ['display_order'=> 'ASC'];
        $joinArr[] = ['table' => 'ads as b','link' => 'a.business_id=b.business_id','type' => 'inner']; 
        $joinArr[] = ['table' => 'ad_category_subcategory as c','link' => 'b.id=c.adid','type' => 'left'];
        $joinArr[] = ['table' => 'business as d','link' => 'a.business_id=d.id','type' => 'inner'];
        $joinArr[] = ['table' => 'ads_setting_preferences as e','link' => 'a.business_id=e.businessid','type' => 'inner'];
        $joinArr[] = ['table' => 'users as f','link' => 'f.id=d.business_owner_id','type' => 'inner'];
        $joinArr[] = ['table' => 'tbl_member as g','link' => 'g.user_name=f.username','type' => 'inner'];
        $data = $this->CommonController->SelectJoinMulti('business_sponsor_order as a', $joinArr,$where,[], $orderby,'a.business_id as businessid',$lowerlimit,$upperlimit);

        $data = count($data);
    }

    if($page == 'filter-for-pboo'){
        $sql="SELECT `a`.*,`b`.name FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` WHERE  `a`.`settingszoneid` = ".$zone_id."";
        if($albhabetvalue != ''){
            $sql .= " AND `b`.`name` LIKE '".trim($albhabetvalue)."%'";
        }
        $data = $this->CommonController->SelectRawquery($sql,'result');
        $data = count($data);
    }
    if($page_dest == 'show_ads_specific_sub_category' || $sub_cat_id > 0){
        $tableArr = [];
        $adiddata = $this->CommonController->SelectDataMultiWay('ad_category_subcategory','adid','resultArray',['subcatid'=> $sub_cat_id,'zoneid' => $zone_id],[],'',[]);
        foreach ($adiddata as $as1 => $a1) {
            $AdidArr[] =  $a1['adid'];
        }
        
        $businessdatacat = $this->CommonController->SelectJoinMulti('ads',[],[],['id' => $AdidArr],[], 'business_id','','','');
        foreach ($businessdatacat as $ak2 => $as2) {
            $businessArrcat[] = $as2->business_id;
        }

        $tableArr[] = ['table' => 'business as b','link' => 'a.businessid=b.id','type' =>'left'];

        $data = $this->CommonController->SelectJoinMulti('ads_setting_preferences as a', $tableArr, ['a.settingszoneid'=> $zone_id],['b.id' => $businessArrcat], ['b.id'=> 'ASC'],'*','','','');
        $data = count($data);
    }
    return $data;
}

function get_ads_for_all_athena_latest_working_anish($zone_id=0,$lowerlimit=0,$upperlimit=0,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 0,$page=0,$page_dest = 0){


  // print_r($page_dest);


    $where_first=''; $not_business_coming=''; $join_11=''; $join_12=''; $join_13=''; $join_14='';  $join_16=''; $join_22=''; $join_23=''; $select_main_cond=''; $table_cond=''; $table_cond_query=''; $subcat_cond=''; $cat_cond=''; $where_search=''; $where_search1=''; $where_charval=''; $_for_bcs=''; $wh_sharing=''; $food_deliver_cond='';$join_r='';

    $join_27 = '';

    $join_28 = ''; $auction_condition=''; $bz_condtion='0'; $price_condition="0";

    $join_26="LEFT JOIN business_sponsor n ON d.id = n.business_id ";

    $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id "; //executing all times if show all offers not found

    $join_29 = 'LEFT JOIN business_sponsor_order_subcat os on os.bussiness_id = d.id'; 

    $current_date = date('Y-m-d');


    if(!empty($ad_id)){ // specific ad 
        
        $where_first="and a.id=$ad_id";

    }else if(!empty($buseness_id)){
        

        $where_first="and a.business_id=$buseness_id";

    }else if(!empty($user_id)){ // for fav ads
 

        $table_cond=",users_favorites u";

        $table_cond_query=" and a.id=u.adid and b.zoneid=u.zoneid and u.user_id=$user_id and u.zoneid=$zone_id";

        $other_cond=" ORDER BY timestamp DESC LIMIT $lowerlimit,$upperlimit";

    }else if(!empty($search_value)){  // for searching 
 

 
        $where_first='';    

        $remove_spaces = str_replace(' ', '', $search_value); // Replaces all spaces with hyphens.

        $remove_specialchar = preg_replace('/[^A-Za-z0-9\-]/', '', $remove_spaces); // Removes special chars.

        $remove_hyphens = preg_replace('/-+/', '', $remove_specialchar);

        $remove_all = $remove_hyphens;     

        if(is_numeric($remove_all)){ 

            $where_search1=" and f.phone = '".trim($search_value)."'";

        }else{ // echo "villa";exit;

        $where_search=" and d.name like '%".trim(addslashes($search_value))."%'"; //exit;

        }

                   

         /// url decode is removed

        $other_cond="  ORDER BY timestamp DESC  LIMIT $lowerlimit,$upperlimit";

     

    }else if(!empty($sub_cat_id) && !empty($cat_id)){ // for sub category, Businesses Uploaded

      

        $join_11=''; $join_12=''; $join_13=''; $join_14=''; $select_main_cond='';

        $other_cond=" GROUP BY c.business_id ORDER BY bs_name ASC LIMIT $lowerlimit,$upperlimit";

        $_for_bcs=" ORDER BY d.name ASC"; //var_dump($_for_bcs);exit;
 

    }else if(!empty($subcatparentid)){ 
 
        $table_cond=",ad_category_subcategory acd, subcategory_display s_d";

        $subcat_cond=" and a.id=acd.adid and acd.subcatid=s_d.subcatid and acd.zoneid=s_d.zoneid and acd.cat_group_id = $subcatparentid and acd.zoneid=$zone_id";

        $join_11=''; $join_12=''; $join_13=''; $join_14=''; $select_main_cond=''; $join_16='';

        $other_cond=" GROUP BY adid ORDER BY timestamp DESC LIMIT $lowerlimit,$upperlimit"; 

        //echo 3;exit;

    }else if(!empty($multiplesubcatid)){ //// + Displaying Ads For Multiple Subcategories.      
 
        $table_cond=",ad_category_subcategory acd, subcategory_display s_d";

        $subcat_cond=" and a.id=acd.adid and acd.subcatid=s_d.subcatid and acd.zoneid=s_d.zoneid and acd.subcatid IN ($multiplesubcatid) and  acd.zoneid=$zone_id";

        $join_11=''; $join_12=''; $join_13=''; $join_14=''; $select_main_cond=''; $join_16='';

        $other_cond=" GROUP BY adid ORDER BY timestamp DESC LIMIT $lowerlimit,$upperlimit";

           //echo 4;exit;

       }else if(!empty($sub_cat_id) && empty($cat_id)){ //for specific sub category

      
        $table_cond=",ad_category_subcategory acd, subcategory_display s_d";

        $subcat_cond=" and a.id=acd.adid and acd.subcatid=s_d.subcatid and acd.zoneid=s_d.zoneid and acd.subcatid=$sub_cat_id and  acd.zoneid=$zone_id";    

        

        $join_29= "LEFT JOIN business_sponsor_order_subcat os  on os.bussiness_id = d.id and os.subcat_id = $sub_cat_id";

        $join_11=''; $join_12=''; $join_13=''; $join_14=''; $select_main_cond=''; $join_16='';

        $other_cond=" GROUP BY adid ORDER BY business_display_order_cat ASC LIMIT $lowerlimit,$upperlimit";
 

    }else if(empty($sub_cat_id) && !empty($cat_id)){ // for specific  category      
 
        $table_cond=",ad_category_subcategory acd, category_display c_d";

        $cat_cond=" and a.id=acd.adid and acd.catid=c_d.catid and acd.zoneid=c_d.zoneid and acd.catid=$cat_id and  acd.zoneid=$zone_id";   

        $other_cond=" GROUP BY bs_id ORDER BY business_display_order ASC LIMIT $lowerlimit,$upperlimit";   

    }else if($deal_title!=''){  
  
        if($deal_title_type=="insert_deal_title"){          

            $data=array('deal_title'=>$deal_title);

            $this->db->where('id',$ad_id);

            $this->db->update('ads',$data);

        }

        $wh_sharing=" and a.deal_title='".$deal_title."'";

        $other_cond="  ORDER BY timestamp DESC  LIMIT $lowerlimit,$upperlimit";

        

    }


   if($business_sponsor == 1){ //sponsor business from home page on load
 
        $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";
 

        $join_26="LEFT JOIN business_sponsor n ON d.id = n.business_id AND n.status = 1 ";

        $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id ";
 

        $select_main_cond='';

        if($charval!=''){

            $where_charval=" and d.name like '".trim($charval)."%'";

        }

        $other_cond=" ORDER BY o.display_order ASC, timestamp DESC LIMIT $lowerlimit,$upperlimit"; // remove sponsor business limit for  home page on load
 

    }elseif($business_sponsor == 2){

        $search = ($food_deliver!=0)? "WHERE c.deliver = ".$food_deliver : "" ;



        if($charval!=0 && strlen($charval)!=0 ){

        $zip_search=" AND FIND_IN_SET('".$charval."',deliver_zips)";

        }

        else{

        $zip_search = "";

        }



        $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";

        $join_26="left JOIN business_sponsor n ON d.id = n.business_id AND n.status = 1 AND d.type = 1";

        $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id ".$search.$zip_search;

        $select_main_cond='';   

        $other_cond="  ORDER BY timestamp DESC  LIMIT $lowerlimit,$upperlimit"; 

 

    }elseif($business_sponsor == 3){ //sponsor business from home page on load


        $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";   

        $join_26="left JOIN business_sponsor n ON d.id = n.business_id AND n.status = 1 ";

        $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id ";

        $join_28="INNER JOIN pbg_zips z  ON  z.business_id = d.id group by c.adid";   

        $select_main_cond='';

        if($charval!=''){

            $where_charval=" and d.name like '".trim($charval)."%'";

        }

        $other_cond=" ORDER BY o.display_order ASC, timestamp DESC LIMIT $lowerlimit,$upperlimit ";

    

    }elseif($business_sponsor == 4){

     

          $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";
          
          $join_26="left JOIN business_sponsor n ON d.id = n.business_id AND n.status = 1 ";

         $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id ";

  

          $select_main_cond='';

          $group_cond = '';

         if($charval=='a-z'){

              $bz_condtion = 'z';

              // $group_cond =  "WHERE substring(company, 1, 1) NOT IN ('1','2','3','4','5','6','7','8','9')";

              $filterby=" company ASC, ";

          }

          elseif ($charval=='z-a') {

            $bz_condtion = 'a';

             // $group_cond =  "WHERE substring(company, 1, 1) NOT IN ('1','2','3','4','5','6','7','8','9')";

            $filterby=" company DESC, ";

          }elseif($charval == 'high to low'){

            $price_condition ='1';

            $filterby=" savings_ammount DESC, ";

          }elseif($charval == 'low to high'){

            $price_condition ='1000.00';

            $filterby=" -savings_ammount DESC, ";

          }elseif($charval == 'redemption_high'){

            $price_condition ='1';

            $filterby=" redemptionvalue DESC, ";

          }elseif($charval == 'redemption_low'){

            $price_condition ='1000.00';

            $filterby=" -redemptionvalue DESC, ";

          }elseif($charval == 'deal_price_low'){

            $price_condition ='1000.00';

            $filterby=" ISNULL(starting_price) , starting_price asc, ";

          }elseif($charval == 'deal_price_high'){

            $price_condition ='1000.00';

            $filterby=" starting_price  + 0  DESC, ";

          }elseif($charval == 'oldest to newest'){

            $filterby=" auction_start_day ASC, ";

          }elseif($charval == 'free peeks'){

            $filterby=" free_peeks DESC, ";

          }elseif($charval = 'started within 24 hrs'){

              $auction_condition =" AND a.start_date >= now() - INTERVAL 1 DAY";         

          }else{

              $filterby=" o.display_order ASC, ";

          }

          $other_cond= $group_cond." ORDER BY ".$filterby." aucid DESC ";

          $limit_cond = "LIMIT $lowerlimit,$upperlimit ";
 

          

    }else{ // show all ofers

        $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";

     

        $select_main_cond='';

        if($charval!=''){

            $where_charval=" and d.name like '".trim($charval)."%'";

        }

       

    }
    if($page_dest =='filter-for-pboo' || $page_dest='show_all_offers'){
      $limit_cond = " ";  
    }
    

    // if($other_cond == ''){
    //    $other_cond = "LIMIT $lowerlimit,$upperlimit";
    // }
    
    // echo $other_cond;

    $select="   c.adid,

                c.zoneid,                         

                c.adtext,

                c.deal_description,

                c.deal_restriction,

                c.admessage,

                c.deliver,

                c.deliver_zips,

                c.imagetype,

                c.docs_pdf, 

                c.search_engine_title,

                c.audio_file,

                c.video_file,

                c.foodmenu as foodmenu,

                c.deal_title as deal_title,

                c.timestamp,c.stickyad,



                d.id AS bs_id, 

                d.logo AS bs_logo,

                d.name AS bs_name,

                d.common_logo_image AS bs_commonimage,

                d.contactemail AS bs_contactemail,

                d.contactfirstname AS bs_contactf_name,

                d.contactlastname AS bs_contactl_name,

                d.website AS bs_website,

                d.motto as motto,

                d.aboutus as aboutus,

                d.israted,

                d.type AS bs_type,



                e.websitevisibility,

                e.emailvisibility,

        

                f.street_address_1 AS bs_streetaddress1,

                f.street_address_2 AS bs_streetaddress2,

                f.city AS bs_city,

                f.state AS bs_state,

                f.zip_code AS bs_zipcode,

                f.phone AS bs_phone,

                f.phone_int AS bs_phone_int,

                f.latitude,

                f.longitude, ";
 



  $select .="    IFNULL(n.status,0) AS business_sponsor_status,

                IFNULL(o.display_order,100) AS business_display_order,

                IFNULL(os.order_id,1000) AS business_display_order_cat,

                bp.bus_image,   ";        

               if($page_dest !='show_ads_specific_category'){ $select .="    sz.name as zone_name,  ";  }                

               $select .="    IFNULL(auction.deal_id,0) AS aucid,

                IFNULL(TRIM(d.name),'$bz_condtion') AS company,

               auction.current_price  AS starting_price,

                auction.buy_price_decrease_by AS redemptionvalue,

                IFNULL(auction.start_date,'z') AS auction_start_day,                                     

                auction.seller_credit AS free_peeks ,

                auction.buy_price_decrease_by  - auction.current_price -  auction.publisher_fee  as savings_ammount

               
                $select_main_cond"; 

                $select_first_inner_query=" a.id as adid, a.business_id,a.adtext,a.deal_description,a.text_message AS admessage,a.deliver      AS deliver,a.imagetype,a.docs_pdf, a.search_engine_title,a.audio_file,a.video_file,a.foodmenu as foodmenu,a.deal_title as deal_title,a.deliver_zips AS deliver_zips,a.timestamp,a.textmeoffer, a.categoryid,a.categoryid1,a.subcategoryid,a.subcategoryid1,b.zoneid,b.stickyad,a.deal_restriction";

                $cond_first_inner_query=" a.id=b.adid and b.approval=1 and b.zoneid=$zone_id and a.categoryid!='-99' and a.subcategoryid!='-99'";  

                

                $join_1="(select $select_first_inner_query from ads a,ad_to_zone b $table_cond where a.status=0 and $cond_first_inner_query $subcat_cond $cat_cond $food_deliver_cond $where_first   $table_cond_query $not_business_coming $wh_sharing   $limit_cond) as c";

                 
                $join_2=" INNER JOIN business d ON c.business_id = d.id $where_search $where_charval ";

                $join_3="INNER JOIN ads_setting_preferences e ON d.id=e.businessid and e.settingszoneid=$zone_id and e.approval NOT IN (-1,-2, 3, -3)";

                $join_4="INNER JOIN address f ON d.addressid = f.id $where_search1";
 
                $join_5="INNER JOIN users g ON d.business_owner_id=g.id ";
                    if($page_dest !='show_ads_specific_category'){
                         $join_6="INNER JOIN users_groups h ON g.id=h.user_id ";  
                    }else{
                        $join_6="";
                    }
                               
               if($page_dest !='show_ads_specific_category'){
                $join_9="LEFT JOIN (select approval as approval,businessid from business_newsletter GROUP BY businessid ) AS k ON k.businessid=d.id ";      
                  }else{
                 $join_9="";
                  }
                if($page_dest !='show_ads_specific_category'){
                   $join_15="INNER JOIN sales_zone sz ON c.zoneid=sz.id "; 
               }else{
                  $join_15="";
               }        

                


                if($page == 1){

                  $join_55="RIGHT JOIN (SELECT  status , business_id from menu_builder_products WHERE status='T') AS mb ON e.businessid = mb.business_id";

                }

                $join_17="";

                $join_21="";

                $join_tz = "";

                $join_22="LEFT JOIN (SELECT group_concat(abp.image_name ORDER BY bbp.order) AS bus_image , abp.ad_id FROM business_photos abp JOIN businessphotos_display bbp ON abp.id = bbp.busphotosid GROUP BY abp.ad_id) AS bp ON c.adid = bp.ad_id";

             

                $join_24="LEFT JOIN(SELECT a.*,c.user_name, ip.consolation_price  ,  ip.publisher_fee ,  ip.company_name,ip.seller_credit FROM tbl_deals a, users b, tbl_member c,tbl_deals_products ip WHERE b.username=c.user_name AND c.user_id=a.user_id  AND ip.user_id=c.user_id $auction_condition GROUP BY a.user_id) AS auction ON g.username=auction.user_name ";

            
                 
                $join_25="LEFT JOIN users_favorites AS u ON a.id=u.adid AND u.user_id=$user_id AND u.zoneid=$zone_id";
 

                if(!empty($sub_cat_id) && !empty($cat_id)){

                    $join_3 .= " and e.approval = 3" ;  //echo $join_3 ;exit ;

                }

                
                
            $sql="SELECT DISTINCT $select FROM  $join_1 $join_2 $join_3 $join_4 $join_5 $join_6 $join_7 $join_8 $join_9 $join_10 $join_r $join_11 $join_12 $join_13 $join_14  $join_55  $join_15   $join_16 $join_21 $join_17 $join_22 $join_23 $join_24 $join_26 $join_27 $join_28 $join_29  $join_tz $other_cond ";
              
                // die;

                 // echo $sql;die;

                $query=$this->db->query($sql);

              //  echo $this->db->last_query(); echo '<br/>'; exit; 

                $result=$query->result_array(); 

               

                $result=($result!='') ? $result : $result='';

                return $result; 

}   

 //      function getBusinessDetialsBySerachOnlineOrder($zone=0,$lowerlimit=0,$upperlimit=20,$search_value='',$food_deliver=1,$zipcode,$lat=0,$long=0 , $zone_id=0,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 0,$page=0){

 

 //    $where_first=''; $not_business_coming=''; $join_11=''; $join_12=''; $join_13=''; $join_14='';  $join_16=''; $join_22=''; $join_23=''; $select_main_cond=''; $table_cond=''; $table_cond_query=''; $subcat_cond=''; $cat_cond=''; $where_search=''; $where_search1=''; $where_charval=''; $_for_bcs=''; $wh_sharing=''; $food_deliver_cond='';$join_r='';

 //    $join_27 = '';

 //    $join_28 = ''; $auction_condition=''; $bz_condtion='0'; $price_condition="0";

 //    $join_26="LEFT JOIN business_sponsor n ON d.id = n.business_id ";

 //    $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id "; //executing all times if show all offers not found

 //    $join_29 = 'LEFT JOIN business_sponsor_order_subcat os on os.bussiness_id = d.id'; 

 //    $current_date = date('Y-m-d');


 //    if(!empty($ad_id)){ // specific ad 
        
 //        $where_first="and a.id=$ad_id";

 //    }else if(!empty($buseness_id)){
        

 //        $where_first="and a.business_id=$buseness_id";

 //    }else if(!empty($user_id)){  
 

 //        $table_cond=",users_favorites u";

 //        $table_cond_query=" and a.id=u.adid and b.zoneid=u.zoneid and u.user_id=$user_id and u.zoneid=$zone_id";

 //        $other_cond=" ORDER BY timestamp DESC LIMIT $lowerlimit,$upperlimit";

 //    }else if(!empty($search_value)){ // for searching 
 

 
 //        $where_first='';    

 //        $remove_spaces = str_replace(' ', '', $search_value); // Replaces all spaces with hyphens.

 //        $remove_specialchar = preg_replace('/[^A-Za-z0-9\-]/', '', $remove_spaces); // Removes special chars.

 //        $remove_hyphens = preg_replace('/-+/', '', $remove_specialchar);

 //        $remove_all = $remove_hyphens;     

 //        if(is_numeric($remove_all)){ 

 //            $where_search1=" and f.phone = '".trim($search_value)."'";

 //        }else{ // echo "villa";exit;

 //        $where_search=" and d.name like '%".trim(addslashes($search_value))."%'"; //exit;

 //        }

                   

 //         /// url decode is removed

 //        $other_cond="  ORDER BY timestamp DESC  LIMIT $lowerlimit,$upperlimit";

 //        /*$sql="select a.id,a.name from business a,address b,ads_setting_preferences c where a.addressid=b.id and a.id=c.businessid

 //         and c.settingszoneid=".$zone_id."".$where_search;    

 //        $query=$this->db->query($sql); */

 //        //echo 1;exit;

 //    }else if(!empty($sub_cat_id) && !empty($cat_id)){ // for sub category, Businesses Uploaded

      

 //        $join_11=''; $join_12=''; $join_13=''; $join_14=''; $select_main_cond='';

 //        $other_cond=" GROUP BY c.business_id ORDER BY bs_name ASC LIMIT $lowerlimit,$upperlimit";

 //        $_for_bcs=" ORDER BY d.name ASC"; //var_dump($_for_bcs);exit;
 

 //    }else if(!empty($subcatparentid)){ //// + Displaying Ads of Sub-Category header for 'By Industry & Start-up Cost'
 
 //        $table_cond=",ad_category_subcategory acd, subcategory_display s_d";

 //        $subcat_cond=" and a.id=acd.adid and acd.subcatid=s_d.subcatid and acd.zoneid=s_d.zoneid and acd.cat_group_id = $subcatparentid and acd.zoneid=$zone_id";

 //        $join_11=''; $join_12=''; $join_13=''; $join_14=''; $select_main_cond=''; $join_16='';

 //        $other_cond=" GROUP BY adid ORDER BY timestamp DESC LIMIT $lowerlimit,$upperlimit"; 

 //        //echo 3;exit;

 //    }else if(!empty($multiplesubcatid)){ //// + Displaying Ads For Multiple Subcategories.      
 
 //        $table_cond=",ad_category_subcategory acd, subcategory_display s_d";

 //        $subcat_cond=" and a.id=acd.adid and acd.subcatid=s_d.subcatid and acd.zoneid=s_d.zoneid and acd.subcatid IN ($multiplesubcatid) and  acd.zoneid=$zone_id";

 //        $join_11=''; $join_12=''; $join_13=''; $join_14=''; $select_main_cond=''; $join_16='';

 //        $other_cond=" GROUP BY adid ORDER BY timestamp DESC LIMIT $lowerlimit,$upperlimit";

 //           //echo 4;exit;

 //       }else if(!empty($sub_cat_id) && empty($cat_id)){ //for specific sub category

      
 //        $table_cond=",ad_category_subcategory acd, subcategory_display s_d";

 //        $subcat_cond=" and a.id=acd.adid and acd.subcatid=s_d.subcatid and acd.zoneid=s_d.zoneid and acd.subcatid=$sub_cat_id and  acd.zoneid=$zone_id";    

 //        //echo $join_16=" INNER JOIN subcategory_display s_d ON s_d.subcatid='$sub_cat_id' and (c.subcategoryid=s_d.subcatid OR c.subcategoryid1=s_d.subcatid) and (c.categoryid='$cat_id' or c.categoryid1='$cat_id') and (c.subcategoryid ='$sub_cat_id' OR c.subcategoryid1 ='$sub_cat_id') and s_d.zoneid=$zone_id";

 //        //echo $join_16=" INNER JOIN subcategory_display s_d ON s_d.subcatid='$sub_cat_id' and s_d.zoneid=$zone_id"; 

 //        $join_29= "LEFT JOIN business_sponsor_order_subcat os  on os.bussiness_id = d.id and os.subcat_id = $sub_cat_id";

 //        $join_11=''; $join_12=''; $join_13=''; $join_14=''; $select_main_cond=''; $join_16='';

 //        $other_cond=" GROUP BY adid ORDER BY business_display_order_cat ASC LIMIT $lowerlimit,$upperlimit";

 //        // $other_cond=" GROUP BY adid ORDER BY business_display_order ASC,business_sponsor_status  DESC,timestamp DESC LIMIT $lowerlimit,$upperlimit"; 

 //        //echo 5;exit;  

 //    }else if(empty($sub_cat_id) && !empty($cat_id)){ // for specific  category      
 
 //        $table_cond=",ad_category_subcategory acd, category_display c_d";

 //        $cat_cond=" and a.id=acd.adid and acd.catid=c_d.catid and acd.zoneid=c_d.zoneid and acd.catid=$cat_id and  acd.zoneid=$zone_id";

 //        // $food_deliver_cond=" and a.deliver=$food_deliver";

 //        $other_cond=" GROUP BY bs_id ORDER BY business_display_order ASC LIMIT $lowerlimit,$upperlimit"; 

 //        /*$where_first=" and (a.categoryid!=$cat_id AND a.categoryid1!=$cat_id) ";

 //        $other_cond=" LIMIT $lowerlimit,$upperlimit";*/

 //        //}else if(!empty($ad_id) && !empty($deal_title_type) && $deal_title!=''){

 //        //echo 6;exit;

 //    }else if($deal_title!=''){ //!empty($ad_id) && 
 
 //        //echo "55555";exit;

 //        if($deal_title_type=="insert_deal_title"){          

 //            $data=array('deal_title'=>$deal_title);

 //            $this->db->where('id',$ad_id);

 //            $this->db->update('ads',$data);

 //        }

 //        $wh_sharing=" and a.deal_title='".$deal_title."'";

 //        $other_cond="  ORDER BY timestamp DESC  LIMIT $lowerlimit,$upperlimit";

 //       // echo 7;exit;

 //    }


 //   if($business_sponsor == 1){ //sponsor business from home page on load
 
 //        $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";
 

 //        $join_26="INNER JOIN business_sponsor n ON d.id = n.business_id AND n.status = 1 ";

 //        $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id ";

        

 //        $select_main_cond='';

 //        if($charval!=''){

 //            $where_charval=" and d.name like '".trim($charval)."%'";

 //        }

 //        $other_cond=" ORDER BY o.display_order ASC, timestamp DESC"; // remove sponsor business limit for  home page on load

 

 //    }elseif($business_sponsor == 2){

 //        $search = ($food_deliver!=0)? "WHERE c.deliver = ".$food_deliver : "" ;



 //        if($charval!=0 && strlen($charval)!=0 ){

 //        $zip_search=" AND FIND_IN_SET('".$charval."',deliver_zips)";

 //        }

 //        else{

 //        $zip_search = "";

 //        }



 //        $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";

 //        $join_26="INNER JOIN business_sponsor n ON d.id = n.business_id AND n.status = 1 AND d.type = 1";

 //        $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id ".$search.$zip_search;

 //        $select_main_cond='';

        

 //        $other_cond="  ORDER BY timestamp DESC  LIMIT $lowerlimit,$upperlimit"; 

 

 //    }elseif($business_sponsor == 3){ //sponsor business from home page on load

 //        $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";

      

 //        $join_26="INNER JOIN business_sponsor n ON d.id = n.business_id AND n.status = 1 ";

 //        $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id ";

 //        $join_28="INNER JOIN pbg_zips z  ON  z.business_id = d.id group by c.adid";

   



 //        $select_main_cond='';

 //        if($charval!=''){

 //            $where_charval=" and d.name like '".trim($charval)."%'";

 //        }

 //        $other_cond=" ORDER BY o.display_order ASC, timestamp DESC LIMIT $lowerlimit,$upperlimit ";
 

 //    }elseif($business_sponsor == 4){

 //        //  echo $charval; exit;

 //          $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";
          
 //          $join_26="INNER JOIN business_sponsor n ON d.id = n.business_id AND n.status = 1 ";

 //         $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id ";

  

 //          $select_main_cond='';

 //         if($charval=='a-z'){

 //              $bz_condtion = 'z';

 //              $filterby=" company ASC, ";

 //          }

 //          elseif ($charval=='z-a') {

 //            $bz_condtion = 'a';

 //            $filterby=" company DESC, ";

 //          }elseif($charval == 'high to low'){

 //            $price_condition ='1';

 //            $filterby=" starting_price DESC, ";

 //          }elseif($charval == 'low to high'){

 //            $price_condition ='1000.00';

 //            $filterby=" starting_price ASC, ";

 //          }elseif($charval == 'oldest to newest'){

 //            $filterby=" auction_start_day ASC, ";

 //          }elseif($charval == 'free peeks'){

 //            $filterby=" free_peeks DESC, ";

 //          }elseif($charval = 'started within 24 hrs'){

 //              $auction_condition =" AND a.start_date >= now() - INTERVAL 1 DAY";

  

 //          }else{

 //              $filterby=" o.display_order ASC, ";

 //          }

 //          $other_cond=" ORDER BY ".$filterby." aucid DESC LIMIT $lowerlimit,$upperlimit ";

           

          

 //    }else{ // show all ofers

 //        $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";

     

 //        $select_main_cond='';

 //        if($charval!=''){

 //            $where_charval=" and d.name like '".trim($charval)."%'";

 //        }

 

 //    }

    

    

 //    $select="   c.adid,

 //                c.zoneid,                         

 //                c.adtext,

 //                c.deal_description,

 //                c.deal_restriction,

 //                c.admessage,

 //                c.deliver,

 //                c.deliver_zips,

 //                c.imagetype,

 //                c.docs_pdf, 

 //                c.search_engine_title,

 //                c.audio_file,

 //                c.video_file,

 //                c.foodmenu as foodmenu,

 //                c.deal_title as deal_title,

 //                c.timestamp,c.stickyad,



 //                d.id AS bs_id, 

 //                d.logo AS bs_logo,

 //                d.name AS bs_name,

 //                d.contactemail AS bs_contactemail,

 //                d.contactfirstname AS bs_contactf_name,

 //                d.contactlastname AS bs_contactl_name,

 //                d.website AS bs_website,

 //                d.motto as motto,

 //                d.aboutus as aboutus,

 //                d.israted,

 //                d.type AS bs_type,



 //                e.websitevisibility,

 //                e.emailvisibility,

        

 //                f.street_address_1 AS bs_streetaddress1,

 //                f.street_address_2 AS bs_streetaddress2,

 //                f.city AS bs_city,

 //                f.state AS bs_state,

 //                f.zip_code AS bs_zipcode,

 //                f.phone AS bs_phone,

 //                f.phone_int AS bs_phone_int,

 //                f.latitude,

 //                f.longitude, ";


  
 //  if($page != 1){
 // $select .="      i.job,

 //                j.barter,

 //                k.approval, 

 //                m.rate,

 //                w.latest_rate,   ";
 //            }



 //  $select .="    IFNULL(n.status,0) AS business_sponsor_status,

 //                IFNULL(o.display_order,100) AS business_display_order,

 //                IFNULL(os.order_id,1000) AS business_display_order_cat,

 //                bp.bus_image,           

 //                sz.name as zone_name,                    

 //                IFNULL(auction.auc_id,0) AS aucid,

 //                IFNULL(auction.company_name,'$bz_condtion') AS company,

 //                IFNULL(auction.low_limit_price,$price_condition) AS starting_price,

 //                IFNULL(auction.start_date,'z') AS auction_start_day,                                     

 //                auction.seller_credit AS free_peeks 

               
 //                $select_main_cond";

                

 //                $select_first_inner_query=" a.id as adid, a.business_id,a.adtext,a.deal_description,a.text_message AS admessage,a.deliver      AS deliver,a.imagetype,a.docs_pdf, a.search_engine_title,a.audio_file,a.video_file,a.foodmenu as foodmenu,a.deal_title as deal_title,a.deliver_zips AS deliver_zips,a.timestamp,a.textmeoffer, a.categoryid,a.categoryid1,a.subcategoryid,a.subcategoryid1,b.zoneid,b.stickyad,a.deal_restriction";

 //                $cond_first_inner_query=" a.id=b.adid and b.approval=1 and b.zoneid=$zone_id and a.categoryid!='-99' and a.subcategoryid!='-99'";  

                

 //                $join_1="(select $select_first_inner_query from ads a,ad_to_zone b $table_cond where a.status=0 and $cond_first_inner_query $subcat_cond $cat_cond $food_deliver_cond $where_first   $table_cond_query $not_business_coming $wh_sharing) as c";

                 
 //                $join_2=" INNER JOIN business d ON c.business_id = d.id $where_search $where_charval ";

 //                $join_3="INNER JOIN ads_setting_preferences e ON d.id=e.businessid and e.settingszoneid=$zone_id and e.approval NOT IN (-1,-2, 3, -3)";

 //                $join_4="INNER JOIN address f ON d.addressid = f.id $where_search1";

 //                $join_5="INNER JOIN users g ON d.business_owner_id=g.id ";

 //                $join_6="INNER JOIN users_groups h ON g.id=h.user_id ";

 //                 if($page != 1){

 //                $join_7="LEFT JOIN (SELECT count(distinct id) AS job,business_id from job_listing GROUP BY business_id) AS i ON i.business_id=d.id ";

 //                $join_8="LEFT JOIN (SELECT count(distinct id) AS barter,business_id from barter_listing GROUP BY business_id) AS j ON j.business_id=d.id ";
 //                 }

 //                $join_9="LEFT JOIN (select approval as approval,businessid from business_newsletter GROUP BY businessid ) AS k ON k.businessid=d.id ";

 //                if($page != 1){

 //                $join_10="LEFT JOIN (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=$zone_id GROUP BY busId) AS m ON m.busId=d.id ";

 //                $join_r="LEFT JOIN (SELECT id,rate AS latest_rate,busId from rating WHERE zone_id=$zone_id ORDER BY id DESC LIMIT 1) AS w ON w.busId=d.id";

 //                }

 //                $join_15="INNER JOIN sales_zone sz ON c.zoneid=sz.id ";


 //                if($page == 1){

 //                  $join_55="RIGHT JOIN (SELECT  status , business_id from menu_builder_products WHERE status='T' ) AS mb ON e.businessid = mb.business_id";

 //                }

 //                $join_17="";

 //                $join_21="";

 //                $join_tz = "";

 //                $join_22="LEFT JOIN (SELECT group_concat(abp.image_name ORDER BY bbp.order) AS bus_image , abp.ad_id FROM business_photos abp JOIN businessphotos_display bbp ON abp.id = bbp.busphotosid GROUP BY abp.ad_id) AS bp ON c.adid = bp.ad_id";


 //                $join_24="LEFT JOIN(SELECT a.*,c.user_name,ip.company_name,ip.seller_credit FROM tbl_auction a, users b, tbl_member c,tbl_inventory_products ip WHERE b.username=c.user_name AND c.user_id=a.user_id  AND ip.user_id=c.user_id AND a.status = 'Live' $auction_condition GROUP BY a.user_id) AS auction ON g.username=auction.user_name ";

               
 //                $join_25="LEFT JOIN users_favorites AS u ON a.id=u.adid AND u.user_id=$user_id AND u.zoneid=$zone_id";



 //                if(!empty($sub_cat_id) && !empty($cat_id)){

 //                    $join_3 .= " and e.approval = 3" ;  //echo $join_3 ;exit ;

 //                }

                
                
 //                $sql="SELECT DISTINCT $select FROM  $join_1 $join_2 $join_3 $join_4 $join_5 $join_6 $join_7 $join_8 $join_9 $join_10 $join_r $join_11 $join_12 $join_13 $join_14  $join_55  $join_15   $join_16 $join_21 $join_17 $join_22 $join_23 $join_24 $join_26 $join_27 $join_28 $join_29  $join_tz $other_cond ";

 //                $query=$this->db->query($sql);

 //                $result=$query->result_array(); 

 //                $result=($result!='') ? $result : $result='';

 //                return $result; 
 // $where_first=''; $not_business_coming=''; $join_11=''; $join_12=''; $join_13=''; $join_14='';  $join_16=''; $join_22=''; $join_23=''; $select_main_cond=''; $table_cond=''; $table_cond_query=''; $subcat_cond=''; $cat_cond=''; $where_search=''; $where_search1=''; $where_charval=''; $_for_bcs=''; $wh_sharing=''; $food_deliver_cond='';$join_r='';

 //    $join_27 = '';

 //    $join_28 = ''; $auction_condition=''; $bz_condtion='0'; $price_condition="0";

 //    $join_26="LEFT JOIN business_sponsor n ON d.id = n.business_id ";

 //    $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id "; //executing all times if show all offers not found

 //    $join_29 = 'LEFT JOIN business_sponsor_order_subcat os on os.bussiness_id = d.id'; 

 //    $current_date = date('Y-m-d');


 //    if(!empty($ad_id)){ // specific ad 
        
 //        $where_first="and a.id=$ad_id";

 //    }else if(!empty($buseness_id)){
        

 //        $where_first="and a.business_id=$buseness_id";

 //    }else if(!empty($user_id)){ // for fav ads
 

 //        $table_cond=",users_favorites u";

 //        $table_cond_query=" and a.id=u.adid and b.zoneid=u.zoneid and u.user_id=$user_id and u.zoneid=$zone_id";

 //        $other_cond=" ORDER BY timestamp DESC LIMIT $lowerlimit,$upperlimit";

 //    }else if(!empty($search_value)){ // for searching 
 

 
 //        $where_first='';    

 //        $remove_spaces = str_replace(' ', '', $search_value); // Replaces all spaces with hyphens.

 //        $remove_specialchar = preg_replace('/[^A-Za-z0-9\-]/', '', $remove_spaces); // Removes special chars.

 //        $remove_hyphens = preg_replace('/-+/', '', $remove_specialchar);

 //        $remove_all = $remove_hyphens;     

 //        if(is_numeric($remove_all)){ 

 //            $where_search1=" and f.phone = '".trim($search_value)."'";

 //        }else{ // echo "villa";exit;

 //        $where_search=" and d.name like '%".trim(addslashes($search_value))."%'"; //exit;

 //        }

                   

 //         /// url decode is removed

 //        $other_cond="  ORDER BY timestamp DESC  LIMIT $lowerlimit,$upperlimit";


 //    }else if(!empty($sub_cat_id) && !empty($cat_id)){ // for sub category, Businesses Uploaded

      

 //        $join_11=''; $join_12=''; $join_13=''; $join_14=''; $select_main_cond='';

 //        $other_cond=" GROUP BY c.business_id ORDER BY bs_name ASC LIMIT $lowerlimit,$upperlimit";

 //        $_for_bcs=" ORDER BY d.name ASC"; //var_dump($_for_bcs);exit;
 

 //    }else if(!empty($subcatparentid)){ //// + Displaying Ads of Sub-Category header for 'By Industry & Start-up Cost'
 
 //        $table_cond=",ad_category_subcategory acd, subcategory_display s_d";

 //        $subcat_cond=" and a.id=acd.adid and acd.subcatid=s_d.subcatid and acd.zoneid=s_d.zoneid and acd.cat_group_id = $subcatparentid and acd.zoneid=$zone_id";

 //        $join_11=''; $join_12=''; $join_13=''; $join_14=''; $select_main_cond=''; $join_16='';

 //        $other_cond=" GROUP BY adid ORDER BY timestamp DESC LIMIT $lowerlimit,$upperlimit"; 

 //        //echo 3;exit;

 //    }else if(!empty($multiplesubcatid)){ //// + Displaying Ads For Multiple Subcategories.      
 
 //        $table_cond=",ad_category_subcategory acd, subcategory_display s_d";

 //        $subcat_cond=" and a.id=acd.adid and acd.subcatid=s_d.subcatid and acd.zoneid=s_d.zoneid and acd.subcatid IN ($multiplesubcatid) and  acd.zoneid=$zone_id";

 //        $join_11=''; $join_12=''; $join_13=''; $join_14=''; $select_main_cond=''; $join_16='';

 //        $other_cond=" GROUP BY adid ORDER BY timestamp DESC LIMIT $lowerlimit,$upperlimit";

 //           //echo 4;exit;

 //       }else if(!empty($sub_cat_id) && empty($cat_id)){ //for specific sub category

      
 //        $table_cond=",ad_category_subcategory acd, subcategory_display s_d";

 //        $subcat_cond=" and a.id=acd.adid and acd.subcatid=s_d.subcatid and acd.zoneid=s_d.zoneid and acd.subcatid=$sub_cat_id and  acd.zoneid=$zone_id";    

 //        $join_29= "LEFT JOIN business_sponsor_order_subcat os  on os.bussiness_id = d.id and os.subcat_id = $sub_cat_id";

 //        $join_11=''; $join_12=''; $join_13=''; $join_14=''; $select_main_cond=''; $join_16='';

 //        $other_cond=" GROUP BY adid ORDER BY business_display_order_cat ASC LIMIT $lowerlimit,$upperlimit";

 //    }else if(empty($sub_cat_id) && !empty($cat_id)){ // for specific  category      
 
 //        $table_cond=",ad_category_subcategory acd, category_display c_d";

 //        $cat_cond=" and a.id=acd.adid and acd.catid=c_d.catid and acd.zoneid=c_d.zoneid and acd.catid=$cat_id and  acd.zoneid=$zone_id";

 //        $other_cond=" GROUP BY bs_id ORDER BY business_display_order ASC LIMIT $lowerlimit,$upperlimit"; 


 //    }else if($deal_title!=''){

 //        if($deal_title_type=="insert_deal_title"){          

 //            $data=array('deal_title'=>$deal_title);

 //            $this->db->where('id',$ad_id);

 //            $this->db->update('ads',$data);

 //        }

 //        $wh_sharing=" and a.deal_title='".$deal_title."'";

 //        $other_cond="  ORDER BY timestamp DESC  LIMIT $lowerlimit,$upperlimit";

 //       // echo 7;exit;

 //    }


 //   if($business_sponsor == 1){ //sponsor business from home page on load
 
 //        $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";
 

 //        $join_26="INNER JOIN business_sponsor n ON d.id = n.business_id AND n.status = 1 ";

 //        $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id ";

 //        $select_main_cond='';

 //        if($charval!=''){

 //            $where_charval=" and d.name like '".trim($charval)."%'";

 //        }

 //        $other_cond=" ORDER BY o.display_order ASC, timestamp DESC"; // remove sponsor business limit for  home page on load


 //    }elseif($business_sponsor == 2){

 //        $search = ($food_deliver!=0)? "WHERE c.deliver = ".$food_deliver : "" ;



 //        if($charval!=0 && strlen($charval)!=0 ){

 //        $zip_search=" AND FIND_IN_SET('".$charval."',deliver_zips)";

 //        }

 //        else{

 //        $zip_search = "";

 //        }



 //        $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";

 //        $join_26="INNER JOIN business_sponsor n ON d.id = n.business_id AND n.status = 1 AND d.type = 1";

 //        $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id ".$search.$zip_search;

 //        $select_main_cond='';

 //        $other_cond="  ORDER BY timestamp DESC  LIMIT $lowerlimit,$upperlimit"; 



 //    }elseif($business_sponsor == 3){ //sponsor business from home page on load

 //        $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";


 //        $join_26="INNER JOIN business_sponsor n ON d.id = n.business_id AND n.status = 1 ";

 //        $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id ";

 //        $join_28="INNER JOIN pbg_zips z  ON  z.business_id = d.id group by c.adid";


 //        $select_main_cond='';

 //        if($charval!=''){

 //            $where_charval=" and d.name like '".trim($charval)."%'";

 //        }

 //        $other_cond=" ORDER BY o.display_order ASC, timestamp DESC LIMIT $lowerlimit,$upperlimit ";



 //    }elseif($business_sponsor == 4){

 //        //  echo $charval; exit;

 //          $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";
          
 //          $join_26="INNER JOIN business_sponsor n ON d.id = n.business_id AND n.status = 1 ";

 //         $join_27="LEFT JOIN business_sponsor_order o  ON d.id = o.business_id ";

  

 //          $select_main_cond='';

 //         if($charval=='a-z'){

 //              $bz_condtion = 'z';

 //              $filterby=" company ASC, ";

 //          }

 //          elseif ($charval=='z-a') {

 //            $bz_condtion = 'a';

 //            $filterby=" company DESC, ";

 //          }elseif($charval == 'high to low'){

 //            $price_condition ='1';

 //            $filterby=" starting_price DESC, ";

 //          }elseif($charval == 'low to high'){

 //            $price_condition ='1000.00';

 //            $filterby=" starting_price ASC, ";

 //          }elseif($charval == 'oldest to newest'){

 //            $filterby=" auction_start_day ASC, ";

 //          }elseif($charval == 'free peeks'){

 //            $filterby=" free_peeks DESC, ";

 //          }elseif($charval = 'started within 24 hrs'){

 //              $auction_condition =" AND a.start_date >= now() - INTERVAL 1 DAY";

 //          }else{

 //              $filterby=" o.display_order ASC, ";

 //          }

 //          $other_cond=" ORDER BY ".$filterby." aucid DESC LIMIT $lowerlimit,$upperlimit ";


 //    }else{ // show all ofers

 //        $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";

     

 //        $select_main_cond='';

 //        if($charval!=''){

 //            $where_charval=" and d.name like '".trim($charval)."%'";

 //        }


 //    }

    

    

 //    $select="   c.adid,

 //                c.zoneid,                         

 //                c.adtext,

 //                c.deal_description,

 //                c.deal_restriction,

 //                c.admessage,

 //                c.deliver,

 //                c.deliver_zips,

 //                c.imagetype,

 //                c.docs_pdf, 

 //                c.search_engine_title,

 //                c.audio_file,

 //                c.video_file,

 //                c.foodmenu as foodmenu,

 //                c.deal_title as deal_title,

 //                c.timestamp,c.stickyad,



 //                d.id AS bs_id, 

 //                d.logo AS bs_logo,

 //                d.name AS bs_name,

 //                d.contactemail AS bs_contactemail,

 //                d.contactfirstname AS bs_contactf_name,

 //                d.contactlastname AS bs_contactl_name,

 //                d.website AS bs_website,

 //                d.motto as motto,

 //                d.aboutus as aboutus,

 //                d.israted,

 //                d.type AS bs_type,



 //                e.websitevisibility,

 //                e.emailvisibility,

        

 //                f.street_address_1 AS bs_streetaddress1,

 //                f.street_address_2 AS bs_streetaddress2,

 //                f.city AS bs_city,

 //                f.state AS bs_state,

 //                f.zip_code AS bs_zipcode,

 //                f.phone AS bs_phone,

 //                f.phone_int AS bs_phone_int,

 //                f.latitude,

 //                f.longitude, ";


  
 //  if($page != 1){
 // $select .="      i.job,

 //                j.barter,

 //                k.approval, 

 //                m.rate,

 //                w.latest_rate,   ";
 //            }



 //  $select .="    IFNULL(n.status,0) AS business_sponsor_status,

 //                IFNULL(o.display_order,100) AS business_display_order,

 //                IFNULL(os.order_id,1000) AS business_display_order_cat,

 //                bp.bus_image,           

 //                sz.name as zone_name,                    

 //                IFNULL(auction.auc_id,0) AS aucid,

 //                IFNULL(auction.company_name,'$bz_condtion') AS company,

 //                IFNULL(auction.low_limit_price,$price_condition) AS starting_price,

 //                IFNULL(auction.start_date,'z') AS auction_start_day,                                     

 //                auction.seller_credit AS free_peeks 

               
 //                $select_main_cond";

                

 //                $select_first_inner_query=" a.id as adid, a.business_id,a.adtext,a.deal_description,a.text_message AS admessage,a.deliver      AS deliver,a.imagetype,a.docs_pdf, a.search_engine_title,a.audio_file,a.video_file,a.foodmenu as foodmenu,a.deal_title as deal_title,a.deliver_zips AS deliver_zips,a.timestamp,a.textmeoffer, a.categoryid,a.categoryid1,a.subcategoryid,a.subcategoryid1,b.zoneid,b.stickyad,a.deal_restriction";

 //                $cond_first_inner_query=" a.id=b.adid and b.approval=1 and b.zoneid=$zone_id and a.categoryid!='-99' and a.subcategoryid!='-99'";  

                

 //                $join_1="(select $select_first_inner_query from ads a,ad_to_zone b $table_cond where a.status=0 and $cond_first_inner_query $subcat_cond $cat_cond $food_deliver_cond $where_first   $table_cond_query $not_business_coming $wh_sharing) as c";

                 
 //                $join_2=" INNER JOIN business d ON c.business_id = d.id $where_search $where_charval ";

 //                $join_3="INNER JOIN ads_setting_preferences e ON d.id=e.businessid and e.settingszoneid=$zone_id and e.approval NOT IN (-1,-2, 3, -3)";

 //                $join_4="INNER JOIN address f ON d.addressid = f.id $where_search1";

 //                $join_5="INNER JOIN users g ON d.business_owner_id=g.id ";

 //                $join_6="INNER JOIN users_groups h ON g.id=h.user_id ";

 //                 if($page != 1){

 //                $join_7="LEFT JOIN (SELECT count(distinct id) AS job,business_id from job_listing GROUP BY business_id) AS i ON i.business_id=d.id ";

 //                $join_8="LEFT JOIN (SELECT count(distinct id) AS barter,business_id from barter_listing GROUP BY business_id) AS j ON j.business_id=d.id ";
 //                 }

 //                $join_9="LEFT JOIN (select approval as approval,businessid from business_newsletter GROUP BY businessid ) AS k ON k.businessid=d.id ";

 //                if($page != 1){

 //                $join_10="LEFT JOIN (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=$zone_id GROUP BY busId) AS m ON m.busId=d.id ";

 //                $join_r="LEFT JOIN (SELECT id,rate AS latest_rate,busId from rating WHERE zone_id=$zone_id ORDER BY id DESC LIMIT 1) AS w ON w.busId=d.id";

 //                }

 //                $join_15="INNER JOIN sales_zone sz ON c.zoneid=sz.id ";


 //                if($page == 1){

 //                  $join_55="RIGHT JOIN (SELECT  status , business_id from menu_builder_products WHERE status='T' ) AS mb ON e.businessid = mb.business_id";

 //                }

 //                $join_17="";

 //                $join_21="";

 //                $join_tz = "";

 //                $join_22="LEFT JOIN (SELECT group_concat(abp.image_name ORDER BY bbp.order) AS bus_image , abp.ad_id FROM business_photos abp JOIN businessphotos_display bbp ON abp.id = bbp.busphotosid GROUP BY abp.ad_id) AS bp ON c.adid = bp.ad_id";

 //                //$join_23="LEFT JOIN tbl_member member ON g.username=member.user_name ";

 //                $join_24="LEFT JOIN(SELECT a.*,c.user_name,ip.company_name,ip.seller_credit FROM tbl_auction a, users b, tbl_member c,tbl_inventory_products ip WHERE b.username=c.user_name AND c.user_id=a.user_id  AND ip.user_id=c.user_id AND a.status = 'Live' $auction_condition GROUP BY a.user_id) AS auction ON g.username=auction.user_name ";

                

                

 //                $join_25="LEFT JOIN users_favorites AS u ON a.id=u.adid AND u.user_id=$user_id AND u.zoneid=$zone_id";





            
                

 //                if(!empty($sub_cat_id) && !empty($cat_id)){

 //                    $join_3 .= " and e.approval = 3" ;  //echo $join_3 ;exit ;

 //                }

                
                
 //                $sql="SELECT DISTINCT $select FROM  $join_1 $join_2 $join_3 $join_4 $join_5 $join_6 $join_7 $join_8 $join_9 $join_10 $join_r $join_11 $join_12 $join_13 $join_14  $join_55  $join_15   $join_16 $join_21 $join_17 $join_22 $join_23 $join_24 $join_26 $join_27 $join_28 $join_29  $join_tz $other_cond ";

 //                // echo "<pre>" . $sql."<br><br>";exit;

 //                $query=$this->db->query($sql);

 //              //  echo $this->db->last_query(); echo '<br/>'; exit; 

 //                $result=$query->result_array(); 

 //                //var_dump($result);exit;

 //                $result=($result!='') ? $result : $result='';

 //                return $result; 

      



 //      } 



    public function SearchByDeliveryCode($zone=0,$lowerlimit=0,$upperlimit=20,$search_value='',$food_deliver=1, $lat = 0 , $long = 0, $status = ''){ 

 // from == start
        // to == upto what time


       
        $currentday = strtolower(date("l") );    

        $sql = 'Select  DISTINCT  a.id as adid, 

        a.estimate_miles , 

        ad.zip_code , 

        a.business_id as bs_id, 

        a.smarturl as shareurl,

        z.zoneid, 

        b.addressid,

        zp.Latitude,

        zp.Longitude ,

        b.logo as bs_logo, 

        b.name as bs_name, 

        b.type as bs_type,

        (SELECT GROUP_CONCAT(bp.image_name) as "bimg" FROM business_photos as bp where bp.bus_id = b.id) as bus_image,

        b.aboutus as aboutus,

        a.search_engine_title,

        a.audio_file,

        a.video_file,

        a.foodmenu as foodmenu

        from ads as a 

        inner join ad_to_zone as z on z.adid = a.id 

        inner join business as b on b.id = a.business_id   

        left join (select * from restaurantbooking_working_times as rw  where  IF(rw.'.$currentday.'_dayoff="F" ,  (rw.'.$currentday.'_from <= rw.'.$currentday.'_to and curtime() between rw.'.$currentday.'_from and rw.'.$currentday.'_to) or
      (rw.'.$currentday.'_to < rw.'.$currentday.'_from and curtime() not between rw.'.$currentday.'_to and rw.'.$currentday.'_from) , "")  ) as rw on rw.business_id = a.business_id

        inner join menu_builder_products as  mbp on mbp.business_id = a.business_id     

        inner join address as ad on  b.addressid = ad.id 

        left join ZIPCodes as zp on   ad.zip_code  = zp.ZipCode 

        where  a.active = 1   and z.zoneid = '.$zone ;  
 


        if($status == 'delivery'){
           $sql .= ' AND a.deliver = 1  GROUP BY bs_id  Having   ROUND ( (((acos(sin(("'.round($lat , 6).'"*pi()/180)) * sin((zp.Latitude*pi()/180)) + cos(("'.round($lat , 6).'"*pi()/180)) * cos((zp.Latitude*pi()/180)) * cos((("'.round($long , 6).'"- zp.Longitude) * pi()/180)))) * 180/pi()) * 60 * 1.1515 ), 0 )  <= max(a.estimate_miles) ';
        }  else if($status == 'nolocation'){
           $sql .= ' GROUP BY bs_id ';
        }else if( $status == 'pickup'){
         $sql .=  '    GROUP BY bs_id' ;

        }else{

              $sql .=  'and   ROUND ( (((acos(sin(("'.round($lat , 6).'"*pi()/180)) * sin((zp.Latitude*pi()/180)) + cos(("'.round($lat , 6).'"*pi()/180)) * cos((zp.Latitude*pi()/180)) * cos((("'.round($long , 6).'"- zp.Longitude) * pi()/180)))) * 180/pi()) * 60 * 1.1515 ), 0 )  <= 5   GROUP BY bs_id' ;

        }   

     $sql .= ' limit '.$lowerlimit.','.$upperlimit;     
 
 
 
       $query=$this->db->query($sql); 

        $result=$query->result_array();

            //var_dump($result);

        $result=($result!='') ? $result : $result='';
 
   

        return $result;



    }

        

function get_ads_for_all_athena_working($zone=0,$lowerlimit=0,$upperlimit=0,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0){ 

    $wh1=''; $wh_subcat="";$wh_orderby="";$wh_orderby_subcat="";

    $not_business_coming=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";

    if(!empty($ad_id)){

        $wh1="and a.id=$ad_id";

    }elseif(!empty($buseness_id)){

        $wh1="and a.business_id=$buseness_id";

    }elseif(!empty($sub_cat_id)){

        $wh1="and a.subcategoryid=$sub_cat_id or a.subcategoryid1=$sub_cat_id";

        $wh_subcat="

            INNER JOIN subcategory_display s_d ON s_d.zoneid=c.zoneid and (c.subcategoryid=s_d.subcatid OR c.subcategoryid1=s_d.subcatid) and (c.categoryid=$catid or c.categoryid1=$catid) and (c.subcategoryid =$subCatId OR c.subcategoryid1 =$subCatId) and s_d.subcatid=$subCatId ";

        $wh_orderby_subcat=" ORDER BY bs_name ASC ";

    }elseif(!empty($cat_id)){

        $wh1="and a.categoryid=$cat_id or a.categoryid1=$cat_id";

        if($cat_id==-99){

            $not_business_coming="";

        }           

    }elseif(!empty($search_value)){

        $wh_subcat="and d.name like '%$search_value%'";

        $not_business_coming="";

    }

    

    $sql="select c.adid,c.categoryid,c.categoryid1,c.subcategoryid,c.subcategoryid1,c.zoneid,c.adtext,c.admessage,c.imagetype,c.docs_pdf, c.search_engine_title,c.audio_file,c.video_file,c.foodmenu as foodmenu,c.deal_title as deal_title,c.timestamp,c.stickyad,



d.id AS bs_id, d.logo AS bs_logo,d.name AS bs_name,d.contactemail AS bs_contactemail,d.contactfirstname AS bs_contactf_name,d.contactlastname AS bs_contactl_name,d.website AS bs_website,d.motto as motto,d.israted,



e.websitevisibility,e.emailvisibility,



f.street_address_1 AS bs_streetaddress1,f.street_address_2 AS bs_streetaddress2,f.city AS bs_city,f.state AS bs_state,f.zip_code AS bs_zipcode,f.phone AS bs_phone,f.latitude,f.longitude,



i.job,j.barter,k.approval, m.rate, n.cat_name1,o.subcat_name1,p.cat_name2,q.subcat_name2,sz.name as zone_name



FROM



(select a.id as adid,a.categoryid,a.categoryid1,a.subcategoryid,a.subcategoryid1,a.business_id,a.adtext,a.text_message AS admessage,a.imagetype,a.docs_pdf, a.search_engine_title,a.audio_file,a.video_file,a.foodmenu as foodmenu,a.deal_title as deal_title,a.timestamp,

b.zoneid,b.stickyad

from ads a,ad_to_zone b 

where 

a.id=b.adid and b.approval=1 and b.zoneid=$zone $wh1 $not_business_coming) as c



INNER JOIN (select id,name,addressid,business_owner_id,logo,contactemail,contactfirstname,contactlastname,website,motto,israted from business group by id) as d ON c.business_id = d.id 

INNER JOIN ads_setting_preferences e ON d.id=e.businessid and e.settingszoneid=$zone

INNER JOIN address f ON d.addressid = f.id

INNER JOIN users g ON d.business_owner_id=g.id 

INNER JOIN users_groups h ON g.id=h.user_id



LEFT JOIN (SELECT count(distinct id) AS job,business_id from job_listing GROUP BY business_id) AS i ON i.business_id=d.id 

LEFT JOIN (SELECT count(distinct id) AS barter,business_id from barter_listing GROUP BY business_id) AS j ON j.business_id=d.id 

LEFT JOIN (select approval as approval,businessid from business_newsletter GROUP BY businessid ) AS k ON k.businessid=d.id 

LEFT JOIN (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=$zone GROUP BY busId) AS m ON m.busId=d.id



LEFT JOIN (SELECT id,name AS cat_name1 FROM category group by id) as n ON c.categoryid=n.id AND c.categoryid!=0 

LEFT JOIN (SELECT id,name AS subcat_name1 FROM category_subcategory group by id) as o ON c.subcategoryid=o.id AND c.subcategoryid!=0

LEFT JOIN (SELECT id,name AS cat_name2 FROM category group by id) as p ON c.categoryid1=p.id AND c.categoryid1!=0 

LEFT JOIN (SELECT id,name AS subcat_name2 FROM category_subcategory group by id) as q ON c.subcategoryid1=q.id AND c.subcategoryid1!=0



INNER JOIN sales_zone sz ON d.id=sz.id 

$wh_subcat

ORDER BY timestamp DESC LIMIT $lowerlimit,$upperlimit

                ";



//echo 1;

    

    /*if($from_where=='show_all_offers'){

        $wh1=" and (a.categoryid!='-99' AND a.categoryid1!='-99') ";

        $wh_orderby=" ORDER BY a.timestamp DESC ";

    }else if($from_where=='subcategory'){

        $wh_subcat="

            INNER JOIN subcategory_display s_d ON s_d.zoneid=c.zoneid and (c.subcategoryid=s_d.subcatid OR c.subcategoryid1=s_d.subcatid) and (c.categoryid=$catid or c.categoryid1=$catid) and (c.subcategoryid =$subCatId OR c.subcategoryid1 =$subCatId) and s_d.subcatid=$subCatId 

        ";

        $wh_orderby_subcat=" ORDER BY bs_name ASC ";

    }*/



/*echo $sql="select c.adid,c.categoryid,c.categoryid1,c.subcategoryid,c.subcategoryid1,c.zoneid,c.adtext,c.admessage,c.imagetype,c.docs_pdf, c.search_engine_title,c.audio_file,c.video_file,c.foodmenu as foodmenu,c.deal_title as deal_title,c.timestamp,c.stickyad,



d.id AS bs_id, d.logo AS bs_logo,d.name AS bs_name,d.contactemail AS bs_contactemail,d.contactfirstname AS bs_contactf_name,d.contactlastname AS bs_contactl_name,d.website AS bs_website,d.motto as motto,d.israted,



e.websitevisibility,e.emailvisibility,



f.street_address_1 AS bs_streetaddress1,f.street_address_2 AS bs_streetaddress2,f.city AS bs_city,f.state AS bs_state,f.zip_code AS bs_zipcode,f.phone AS bs_phone,f.latitude,f.longitude,



i.job,j.barter,k.approval, m.rate, n.cat_name1,o.subcat_name1,p.cat_name2,q.subcat_name2



FROM



(select a.id as adid,a.categoryid,a.categoryid1,a.subcategoryid,a.subcategoryid1,a.business_id,a.adtext,a.text_message AS admessage,a.imagetype,a.docs_pdf, a.search_engine_title,a.audio_file,a.video_file,a.foodmenu as foodmenu,a.deal_title as deal_title,a.timestamp,

b.zoneid,b.stickyad

from ads a,ad_to_zone b 

where 

a.id=b.adid and b.approval=1 and b.zoneid=$zone $wh1) as c



$wh_subcat



INNER JOIN (select id,name,addressid,business_owner_id,logo,contactemail,contactfirstname,contactlastname,website,motto,israted from business group by id) as d ON c.business_id = d.id 

INNER JOIN ads_setting_preferences e ON d.id=e.businessid and e.settingszoneid=$zone

INNER JOIN address f ON d.addressid = f.id

INNER JOIN users g ON d.business_owner_id=g.id 

INNER JOIN users_groups h ON g.id=h.user_id



LEFT JOIN (SELECT count(distinct id) AS job,business_id from job_listing GROUP BY business_id) AS i ON i.business_id=d.id 

LEFT JOIN (SELECT count(distinct id) AS barter,business_id from barter_listing GROUP BY business_id) AS j ON j.business_id=d.id 

LEFT JOIN (select approval as approval,businessid from business_newsletter GROUP BY businessid ) AS k ON k.businessid=d.id 

LEFT JOIN (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=$zone GROUP BY busId) AS m ON m.busId=d.id



LEFT JOIN (SELECT id,name AS cat_name1 FROM category group by id) as n ON c.categoryid=n.id AND c.categoryid!=0 

LEFT JOIN (SELECT id,name AS subcat_name1 FROM category_subcategory group by id) as o ON c.subcategoryid=o.id AND c.subcategoryid!=0

LEFT JOIN (SELECT id,name AS cat_name2 FROM category group by id) as p ON c.categoryid1=p.id AND c.categoryid1!=0 

LEFT JOIN (SELECT id,name AS subcat_name2 FROM category_subcategory group by id) as q ON c.subcategoryid1=q.id AND c.subcategoryid1!=0   



$wh_orderby LIMIT $lowerlimit,$upperlimit

                ";*/

                

                $query=$this->db->query($sql);

            $result=$query->result_array();

            //var_dump($result);

        $result=($result!='') ? $result : $result='';

        return $result;

}

        

        

    // this function shows show all offers

    function get_ads_for_all_athena($zone=false,$lowerlimit=false,$upperlimit=false,$search_value=''){      

            if($search_value!=''){               

                $where_search=" and b.name like '%".trim(addslashes(urldecode($search_value)))."%'";                    

            }else{

                $where_search="";

            }           

                $sql="select c.adid,c.categoryid,c.categoryid1,c.subcategoryid,c.subcategoryid1,c.zoneid,c.adtext,c.admessage,c.imagetype,c.docs_pdf, c.search_engine_title,c.audio_file,c.video_file,c.foodmenu as foodmenu,c.deal_title as deal_title,c.timestamp,c.stickyad,



d.id AS bs_id, d.logo AS bs_logo,d.name AS bs_name,d.contactemail AS bs_contactemail,d.contactfirstname AS bs_contactf_name,d.contactlastname AS bs_contactl_name,d.website AS bs_website,d.motto as motto,d.israted,



e.websitevisibility,e.emailvisibility,



f.street_address_1 AS bs_streetaddress1,f.street_address_2 AS bs_streetaddress2,f.city AS bs_city,f.state AS bs_state,f.zip_code AS bs_zipcode,f.phone AS bs_phone,f.latitude,f.longitude,



i.job,j.barter,k.approval, m.rate, n.cat_name1,o.subcat_name1,p.cat_name2,q.subcat_name2,sz.name as zone_name



FROM



(select a.id as adid,a.categoryid,a.categoryid1,a.subcategoryid,a.subcategoryid1,a.business_id,a.adtext,a.text_message AS admessage,a.imagetype,a.docs_pdf, a.search_engine_title,a.audio_file,a.video_file,a.foodmenu as foodmenu,a.deal_title as deal_title,a.timestamp,

b.zoneid,b.stickyad

from ads a,ad_to_zone b 

where 

a.id=b.adid and b.approval=1 and b.zoneid=$zone and (a.categoryid!='-99' AND a.categoryid1!='-99') ) as c



INNER JOIN (select id,name,addressid,business_owner_id,logo,contactemail,contactfirstname,contactlastname,website,motto,israted from business group by id) as d ON c.business_id = d.id 

INNER JOIN ads_setting_preferences e ON d.id=e.businessid and e.settingszoneid=$zone

INNER JOIN address f ON d.addressid = f.id

INNER JOIN users g ON d.business_owner_id=g.id 

INNER JOIN users_groups h ON g.id=h.user_id



LEFT JOIN (SELECT count(distinct id) AS job,business_id from job_listing GROUP BY business_id) AS i ON i.business_id=d.id 

LEFT JOIN (SELECT count(distinct id) AS barter,business_id from barter_listing GROUP BY business_id) AS j ON j.business_id=d.id 

LEFT JOIN (select approval as approval,businessid from business_newsletter GROUP BY businessid ) AS k ON k.businessid=d.id 

LEFT JOIN (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=$zone GROUP BY busId) AS m ON m.busId=d.id



LEFT JOIN (SELECT id,name AS cat_name1 FROM category group by id) as n ON c.categoryid=n.id AND c.categoryid!=0 

LEFT JOIN (SELECT id,name AS subcat_name1 FROM category_subcategory group by id) as o ON c.subcategoryid=o.id AND c.subcategoryid!=0

LEFT JOIN (SELECT id,name AS cat_name2 FROM category group by id) as p ON c.categoryid1=p.id AND c.categoryid1!=0 

LEFT JOIN (SELECT id,name AS subcat_name2 FROM category_subcategory group by id) as q ON c.subcategoryid1=q.id AND c.subcategoryid1!=0 

INNER JOIN sales_zone sz ON c.zoneid=sz.id

ORDER BY timestamp DESC LIMIT $lowerlimit,$upperlimit

                ";

            

            

            $query=$this->db->query($sql);

            $result=$query->result_array();

            //var_dump($result);

        $result=($result!='') ? $result : $result='';

        return $result;     

    }

    function get_ads_for_all_athena_old($zone=false,$lowerlimit=false,$upperlimit=false,$search_value=''){      

            if($search_value!=''){               

                $where_search=" and b.name like '%".trim(addslashes(urldecode($search_value)))."%'";                    

            }else{

                $where_search="";

            }           

                $sql="SELECT c.adid AS adid,c.adname AS adname,c.deal_title as deal_title,c.adtext,c.admessage AS admessage,c.imagetype,c.docs_pdf, c.search_engine_title,c.audio_file,c.video_file,c.foodmenu as foodmenu,c.id AS bs_id, c.logo AS bs_logo,c.name AS bs_name,c.contactemail AS bs_contactemail,c.contactfirstname AS bs_contactf_name,c.contactlastname AS bs_contactl_name,c.website AS bs_website,c.motto as 

motto,c.israted,f.street_address_1 AS bs_streetaddress1,f.street_address_2 AS bs_streetaddress2,f.city AS bs_city,f.state AS bs_state,f.zip_code AS bs_zipcode,f.phone AS bs_phone,e.stickyad,c.websitevisibility,c.emailvisibility, i.job,j.barter,k.approval, m.rate,f.latitude,f.longitude,sz.name as zone_name

                FROM 

                (SELECT a.settingszoneid, a.websitevisibility,a.emailvisibility,b.id,b.name,b.addressid,b.business_owner_id,b.logo, b.contactemail, b.contactfirstname,b.contactlastname,b.website,b.motto,b.israted,

                d.id AS adid,d.name AS adname,d.adtext,d.text_message AS admessage,d.imagetype,d.docs_pdf, d.search_engine_title,d.audio_file,d.video_file,d.foodmenu as foodmenu,d.deal_title as deal_title

                 FROM ads_setting_preferences a,business b,ads d WHERE a.businessid=b.id AND b.id=d.business_id AND a.settingszoneid=$zone AND a.approval IN(1,2,3)".$where_search." ORDER BY a.approval ASC,d.timestamp DESC,b.name ASC,d.categoryid DESC LIMIT $lowerlimit,$upperlimit) AS c

                

                INNER JOIN ad_to_zone e ON c.adid=e.adid AND c.settingszoneid=e.zoneid AND e.zoneid=$zone AND e.approval=1

                INNER JOIN address f ON c.addressid = f.id

                INNER JOIN users g ON c.business_owner_id=g.id

                INNER JOIN users_groups h ON g.id=h.user_id

                LEFT JOIN (SELECT count(distinct id) AS job,business_id from job_listing GROUP BY business_id) AS i 

                    ON i.business_id=c.id

                LEFT JOIN (SELECT count(distinct id) AS barter,business_id from barter_listing GROUP BY business_id) AS j 

                    ON j.business_id=c.id

                LEFT JOIN (select approval as approval,businessid from business_newsletter GROUP BY businessid ) AS k 

                    ON k.businessid=c.id

                LEFT JOIN  (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=".$zone." GROUP BY busId) AS m

                ON m.busId=c.id

                            

                ";

            

            

            $query=$this->db->query($sql);

            $result=$query->result_array();

        $result=($result!='') ? $result : $result='';

        return $result;     

    }

    // this function shows all the sub categories ad

    function get_all_ads_in_a_category($subCatId=false,$catid=false,$zoneid=false,$lowerlimit=false,$upperlimit=false){     

            /*$sql="select b.id as adid,b.name,b.adtext,b.imagetype,b.text_message,b.docs_pdf,b.search_engine_title,b.audio_file,b.video_file,c.id as bj_id,b.foodmenu as foodmenu, c.name as biz_name, c.website, c.contactemail as email,c.motto as motto,c.israted,d.street_address_1 AS street_address_1,d.street_address_2 AS street_address_2,d.city AS city,d.state AS state,d.zip_code AS zip_code,d.phone AS phone,a.stickyad,g.websitevisibility,g.emailvisibility,h.job,i.barter,j.approval,m.rate 

            from (ad_to_zone a,ads b,business c,address d,subcategory_display f,ads_setting_preferences g)          

            Left JOIN (

                select count(distinct id) as job,business_id from job_listing group by business_id

            )as h ON h.business_id=c.id     

            Left JOIN (

                select count(distinct id) as barter,business_id from barter_listing group by business_id

            )as i ON i.business_id=c.id         

            Left JOIN (

                select approval as approval,businessid from business_newsletter group by businessid

            )as j ON j.businessid=c.id

            LEFT JOIN  (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=".$zoneid." GROUP BY busId) AS m

                ON m.busId=c.id         

            WHERE a.adid=b.id AND b.business_id=c.id AND c.addressid = d.id AND (b.subcategoryid=f.subcatid OR b.subcategoryid1=f.subcatid) AND a.zoneid=".$zoneid." AND a.zoneid=g.settingszoneid AND (b.subcategoryid =".$subCatId." OR b.subcategoryid1 =".$subCatId.") AND (b.categoryid =".$catid." OR b.categoryid1 =".$catid.") AND f.subcatid=".$subCatId." AND f.zoneid=".$zoneid." and b.business_id=g.businessid and c.id=g.businessid and a.approval=1 and g.approval IN(1,2,3) order by a.stickyad DESC,c.name ASC  limit ".$lowerlimit.",".$upperlimit;*/

            

            

            $sql="SELECT f.settingszoneid, 

e.adid,e.adtext,e.imagetype,e.text_message,e.docs_pdf,e.search_engine_title,e.audio_file,e.video_file,e.foodmenu as foodmenu,e.stickyad,e.deal_title as deal_title,

e.id as bj_id,e.name as biz_name, e.website, e.contactemail as email,e.motto as motto,e.israted,f.websitevisibility,f.emailvisibility,

g.street_address_1 AS street_address_1,g.street_address_2 AS street_address_2,g.city AS city,g.state AS state,g.zip_code AS zip_code,g.phone AS phone,

j.job,k.barter,l.approval, m.rate,g.latitude,g.longitude

 from

(select a.zoneid,a.stickyad,

b.id as adid,b.adtext,b.imagetype,b.text_message,b.docs_pdf,b.search_engine_title,b.audio_file,b.video_file,b.deal_title,c.id as bj_id,b.foodmenu,

d.id,d.name,d.addressid,d.business_owner_id,d.website, d.contactemail,d.motto,d.israted 

from ad_to_zone a,ads b,subcategory_display c,business d 

where a.adid=b.id and (b.subcategoryid=c.subcatid OR b.subcategoryid1=c.subcatid) and b.business_id=d.id  and a.zoneid=".$zoneid." and a.approval=1 and (b.categoryid=".$catid." or b.categoryid1=".$catid.") and (b.subcategoryid =".$subCatId." OR b.subcategoryid1 =".$subCatId.")  and c.subcatid=".$subCatId." and c.zoneid=".$zoneid." order by a.stickyad DESC,d.name asc  limit ".$lowerlimit.",".$upperlimit.") as e

INNER JOIN ads_setting_preferences f ON e.id = f.businessid and e.zoneid=f.settingszoneid and f.settingszoneid=".$zoneid." and f.approval IN(1,2,3)

INNER JOIN address g ON e.addressid = g.id

INNER JOIN users h ON e.business_owner_id=h.id

INNER JOIN users_groups i ON h.id=i.user_id

LEFT JOIN (SELECT count(distinct id) AS job,business_id from job_listing GROUP BY business_id) AS j ON j.business_id=e.id 

LEFT JOIN (SELECT count(distinct id) AS barter,business_id from barter_listing GROUP BY business_id) AS k ON k.business_id=e.id                 

LEFT JOIN (select approval as approval,businessid from business_newsletter GROUP BY businessid ) AS l ON l.businessid=e.id                  

LEFT JOIN  (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=".$zoneid." GROUP BY busId) AS m ON m.busId=e.id

            

INNER JOIN sales_zone sz ON f.settingszoneid=sz.id";            

            

            

            

            

            

            $query=$this->db->query($sql);

            $result=$query->result_array();

            return $result;

        

    }

    // this function shows all the main categories ad

    function get_all_ads_in_a_main_category($catid=false,$zoneid=false,$lowerlimit=false,$upperlimit=false){

            $sql="select b.id as adid,b.name,b.adtext,b.imagetype,b.text_message,b.docs_pdf,b.search_engine_title,b.audio_file,b.video_file,b.deal_title as deal_title,c.id as bj_id, c.name as biz_name, c.website, c.contactemail as email,c.motto as motto,c.israted,d.street_address_1 AS street_address_1,d.street_address_2 AS street_address_2,d.city AS city,d.state AS state,d.zip_code AS zip_code,d.phone AS phone,d.latitude,d.longitude,a.stickyad,e.websitevisibility,e.emailvisibility,h.job,i.barter,j.approval,m.rate  

            from (ad_to_zone a,ads b,business c,address d,ads_setting_preferences e)            

            Left JOIN (

                select count(distinct id) as job,business_id from job_listing group by business_id

            )as h ON h.business_id=c.id     

            Left JOIN (

                select count(distinct id) as barter,business_id from barter_listing group by business_id

            )as i ON i.business_id=c.id         

            Left JOIN (

                select approval as approval,businessid from business_newsletter group by businessid

            )as j ON j.businessid=c.id

            LEFT JOIN  (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=".$zoneid." GROUP BY busId) AS m

                ON m.busId=c.id  

            WHERE a.adid=b.id AND b.business_id=c.id AND a.zoneid=".$zoneid." and a.zoneid=e.settingszoneid and (b.categoryid=".$catid." or b.categoryid1=".$catid.") and c.addressid = d.id and c.id=e.businessid and b.business_id=e.businessid and a.approval=1 and e.approval IN(1,2,3) order by a.stickyad desc,c.name asc limit ".$lowerlimit.",".$upperlimit;

            $query=$this->db->query($sql);

            $result=$query->result_array();

        return $result;

    }

    // user favorites Ads Start

    function get_all_fav_ads($zone=false,$lowerlimit=false,$upperlimit=false,$userId=false,$from_where=''){

        $table_cond=''; $wh_cond='';

        if($from_where=='user_fav'){

            $table_cond=",users_favorites u";

            $wh_cond=" and a.id=u.adid and b.zoneid=u.zoneid and u.user_id=$userId";

        }

        $sql="select c.adid,c.categoryid,c.categoryid1,c.subcategoryid,c.subcategoryid1,c.zoneid,c.adtext,c.admessage,c.imagetype,c.docs_pdf, c.search_engine_title,c.audio_file,c.video_file,c.foodmenu as foodmenu,c.deal_title as deal_title,c.timestamp,c.stickyad,



d.id AS bs_id, d.logo AS bs_logo,d.name AS bs_name,d.contactemail AS bs_contactemail,d.contactfirstname AS bs_contactf_name,d.contactlastname AS bs_contactl_name,d.website AS bs_website,d.motto as motto,d.israted,



e.websitevisibility,e.emailvisibility,



f.street_address_1 AS bs_streetaddress1,f.street_address_2 AS bs_streetaddress2,f.city AS bs_city,f.state AS bs_state,f.zip_code AS bs_zipcode,f.phone AS bs_phone,f.latitude,f.longitude,



i.job,j.barter,k.approval, m.rate, n.cat_name1,o.subcat_name1,p.cat_name2,q.subcat_name2



FROM



(select a.id as adid,a.categoryid,a.categoryid1,a.subcategoryid,a.subcategoryid1,a.business_id,a.adtext,a.text_message AS admessage,a.imagetype,a.docs_pdf, a.search_engine_title,a.audio_file,a.video_file,a.foodmenu as foodmenu,a.deal_title as deal_title,a.timestamp,

b.zoneid,b.stickyad

from ads a,ad_to_zone b $table_cond 

where 

a.id=b.adid and b.approval=1 and b.zoneid=$zone and (a.categoryid!='-99' AND a.categoryid1!='-99') $wh_cond) as c



INNER JOIN (select id,name,addressid,business_owner_id,logo,contactemail,contactfirstname,contactlastname,website,motto,israted from business group by id) as d ON c.business_id = d.id 

INNER JOIN ads_setting_preferences e ON d.id=e.businessid and e.settingszoneid=$zone

INNER JOIN address f ON d.addressid = f.id

INNER JOIN users g ON d.business_owner_id=g.id 

INNER JOIN users_groups h ON g.id=h.user_id



LEFT JOIN (SELECT count(distinct id) AS job,business_id from job_listing GROUP BY business_id) AS i ON i.business_id=d.id 

LEFT JOIN (SELECT count(distinct id) AS barter,business_id from barter_listing GROUP BY business_id) AS j ON j.business_id=d.id 

LEFT JOIN (select approval as approval,businessid from business_newsletter GROUP BY businessid ) AS k ON k.businessid=d.id 

LEFT JOIN (SELECT AVG(rate) AS rate,busId from rating WHERE zone_id=$zone GROUP BY busId) AS m ON m.busId=d.id



LEFT JOIN (SELECT id,name AS cat_name1 FROM category group by id) as n ON c.categoryid=n.id AND c.categoryid!=0 

LEFT JOIN (SELECT id,name AS subcat_name1 FROM category_subcategory group by id) as o ON c.subcategoryid=o.id AND c.subcategoryid!=0

LEFT JOIN (SELECT id,name AS cat_name2 FROM category group by id) as p ON c.categoryid1=p.id AND c.categoryid1!=0 

LEFT JOIN (SELECT id,name AS subcat_name2 FROM category_subcategory group by id) as q ON c.subcategoryid1=q.id AND c.subcategoryid1!=0   



ORDER BY timestamp DESC LIMIT $lowerlimit,$upperlimit

                ";

                

                $query=$this->db->query($sql);

            $result=$query->result_array();

            //var_dump($result);

        $result=($result!='') ? $result : $result='';

        return $result; 

    }

    

    

    

    

    function get_all_fav_ads_old($zone=false,$userId=false,$lowerlimit=false,$upperlimit=false){        

        

        if($zone){

            date_default_timezone_set('EST');

            $date = new DateTime();

            $interval = new DateInterval('PT1H');

            $date->add($interval);

            $inow=$date->format('Y-m-d H:i:s');

            

            

            $query = $this->db->query("SELECT b.id,b.name FROM ads_setting_preferences a,business b WHERE a.businessid=b.id AND a.settingszoneid=".$zone."  and a.approval IN(1,2,3) GROUP BY b.id");

            $result= $query->result_array() ;

            //var_dump($result[0]);

            $allbusinessids = array() ;

            foreach($result as $arr_result)

                $allbusinessids[$arr_result['id']]=$arr_result['id'];

             $a = implode(',',$allbusinessids) ;

            if(!empty($a)){

                $sql_ad_count="select b.id AS adid,b.name AS adname,b.adtext,b.text_message AS admessage,b.imagetype,b.docs_pdf,b.deal_title as deal_title,c.id AS bs_id,c.logo AS bs_logo,c.name AS bs_name,c.contactemail AS bs_contactemail,c.contactfirstname AS bs_contactf_name,c.contactlastname AS bs_contactl_name,c.website AS bs_website,c.motto as motto,d.street_address_1 AS bs_streetaddress1,d.street_address_2 AS bs_streetaddress2,d.city AS bs_city,d.state AS bs_state,d.zip_code AS bs_zipcode,d.phone AS bs_phone,a.stickyad,b.search_engine_title,b.audio_file,b.video_file,c.israted,m.rate,d.latitude,d.longitude

                from (ad_to_zone a,ads b,business c,address d,users_favorites u)

                LEFT JOIN rating as m ON m.busId=b.business_id AND m.zone_id=".$zone." and m.userId=".$userId." 

                WHERE a.adid=b.id AND a.adid=u.adid AND b.id=u.adid AND b.business_id=c.id AND a.zoneid=u.zoneid AND u.user_id=".$userId." AND c.id IN(".$a.") and u.zoneid=".$zone." and c.addressid = d.id and a.approval IN(1)  ORDER BY a.stickyad DESC limit ".$lowerlimit.",".$upperlimit;

                

                $query_inner=$this->db->query($sql_ad_count);

                $r=$query_inner->result_array();

                $i=0;

                foreach($r as $arr_r){

                    $sql_sub_job="select count(id) as count_job from job_listing WHERE business_id=".$arr_r['bs_id'] ; // for job

                    $query_sub_job=$this->db->query($sql_sub_job);

                    $result_sub_job=$query_sub_job->result_array();

                    $r[$i]['job'] = $result_sub_job[0]['count_job'] ;

                    

                    $sql_sub_barter="select count(id) as count_barter from barter_listing WHERE business_id=".$arr_r['bs_id'] ;  // for barter

                    $query_sub_barter=$this->db->query($sql_sub_barter);

                    $result_sub_barter=$query_sub_barter->result_array();

                    $r[$i]['barter'] = $result_sub_barter[0]['count_barter'] ;

                    

                    $sql_sub_visibility="select websitevisibility,emailvisibility from ads_setting_preferences WHERE businessid=".$arr_r['bs_id'] ;  

                    $query_sub_visibility=$this->db->query($sql_sub_visibility);

                    $result_sub_visibility=$query_sub_visibility->result_array();

                    $r[$i]['websitevisibility'] = $result_sub_visibility[0]['websitevisibility'] ;

                    $r[$i]['emailvisibility'] = $result_sub_visibility[0]['emailvisibility'] ;

                    

                    $sql_newsletter="select approval from business_newsletter WHERE businessid=".$arr_r['bs_id'] ;  

                    $query_newsletter=$this->db->query($sql_newsletter);

                    $result_newsletter=$query_newsletter->result_array();

                    if(!empty($result_newsletter)){

                        $r[$i]['approval'] = $result_newsletter[0]['approval'] ;

                    }else{

                        $r[$i]['approval'] = 0 ;

                    }

                    $i++;

                }

            return $r;

            }

        }else{

            return "";

        }

    

    

        }

    

    

    //start of insert and update comment and rating

    function updaterating($user_id=0, $bus_id=0, $rate=0,$zone_id=0,$commentrating=false)

    {       

        if(empty($commentrating))

        {

            $data_ins=array('userId'=>$user_id,'busId'=>$bus_id,'rate'=>$rate,'zone_id'=>$zone_id,'timestamp'=>time());

        }

        

        if(!empty($user_id) && !empty($bus_id) && !empty($zone_id))

        {

            if(empty($commentrating))

            {

                $sql="SELECT busId,userId,zone_id,rate FROM rating WHERE userId=".$user_id." AND  busId=".$bus_id." AND zone_id=".$zone_id."" ;

                $query = $this->db->query($sql);

                $result = $query->result_array();

                

                if(!empty($result))

                {   

                    $this->db->where('zone_id',$zone_id);

                    $this->db->where('userId',$user_id);

                    $this->db->where('busId', $bus_id);

                    $this->db->update('rating', $data_ins);

                    

                }

                else

                {

                    

                    $this->db->insert('rating', $data_ins);

                    $ratingid = $this->db->insert_id();

                    $isratedarray=array('israted'=>1);

                    $this->db->where('id', $bus_id);

                    $this->db->update('business', $isratedarray);

                    

                }

            }

            else

            {   

                $datacomment=array('comment'=>$commentrating);

                $this->db->where('zone_id',$zone_id);

                $this->db->where('userId',$user_id);

                $this->db->where('busId', $bus_id);

                $this->db->update('rating', $datacomment);

            }

            $sql="SELECT avg(rate) as rate FROM rating WHERE  busId=".$bus_id." AND zone_id=".$zone_id."" ;

            $query = $this->db->query($sql);

            $rateresult = $query->result_array();

            

            foreach($rateresult as $rate)

            {

                $rate=$rate['rate'];

                

            }

            $ratedata=array('busId'=>$bus_id,'userId'=>$user_id,'rate'=>$rate,'zone_id'=>$zone_id);

            return $ratedata;               

        }

    }

    //end of insert and update comment and rating end

    

    //start of insert comment

    function insertcomment($user_id=0, $bus_id=0, $rate=0,$zone_id=0,$commentrating=false){

        $data_ins=array('userId'=>$user_id,'busId'=>$bus_id,'zone_id'=>$zone_id,'comment'=>$commentrating,'timestamp'=>time());

        $this->db->insert('comment_rating', $data_ins);

        $ratingid = $this->db->insert_id();

        return $data_ins;

        }

    //end of insert comment

    

    //start of view all rating and comment

    function viewallratingandcomment($business_id=0,$zoneid=0)

    {

        $sql="SELECT a.id,DATE_FORMAT(FROM_UNIXTIME(a.timestamp), '%M %e, %Y') AS 'timedate',a.comment as ratingcomment,a.rate,(CONCAT_WS(' ', c.first_name, c.last_name)) as full_name FROM rating a inner join users c on a.userId=c.id where a.zone_id=$zoneid AND a.busId=$business_id Group By a.id ORDER BY a.timestamp DESC";

        $query=$this->db->query($sql);

        $result=$query->result_array($query);   

        return $result;

    }

    //end of view all rating and comment

    

    //start of view all comment

    function viewallcomment($business_id=0,$zoneid=0)

    {

        $sql="SELECT a.id,DATE_FORMAT(FROM_UNIXTIME(a.timestamp), '%M %e, %Y') AS 'timedate',a.comment as ratingcomment,(CONCAT_WS(' ',c.first_name, c.last_name)) as full_name FROM comment_rating a inner join users c on a.userId=c.id where a.zone_id=$zoneid AND a.busId=$business_id Group By a.id ORDER BY a.timestamp DESC";

        $query=$this->db->query($sql);

        $result=$query->result_array($query);   //echo $this->db->last_query();print_r($result); exit;

        return $result;

    }

    //end of view all comment

    

    // Start of Sponsorship text on directory page

    function sponsorshiptext($zoneid=0){

        $sql = "SELECT sponsor_ad_text from zone_preferences WHERE zoneid=".$zoneid;

        $query=$this->db->query($sql);

        return $query->row()->sponsor_ad_text;

    }

    // End of Sponsorship text on directory page

    

    // Start : Editing ads will also update approval to '0' in ad_to_zone table // added on 19.6.14

    function update_adtozone_approval($adid=0,$zoneid=0,$business_id=0){

        $arr_zonepref=$this->getZonePpreferencesByZone($zoneid);

        $arr_adsettingspref=$this->getAdSettingsPref($zoneid,$business_id); 

            

            if($arr_adsettingspref['isdefault']==1){

                if($arr_adsettingspref['approval']==1){

                    if($arr_zonepref['auto_approve_paid_ad_myzone']==1){

                        $approval=1;

                    }else if($arr_zonepref['auto_approve_paid_ad_myzone']==0){

                        //check is specific business mathced with this business id

                        $matched=strpos(','.$arr_zonepref['auto_approve_paid_specific_ad_myzone'].',',','.$business_id.',');

                        if($matched!==false){

                            $approval=1;

                        }else{

                            $approval=0;

                        }

                    }

                }else if($arr_adsettingspref['approval']==2){

                    if($arr_zonepref['auto_approve_trial_ad_myzone']==1){

                        $approval=1;

                    }else if($arr_zonepref['auto_approve_trial_ad_myzone']==0){

                        //check is specific business mathced with this business id

                        $matched=strpos(','.$arr_zonepref['auto_approve_trial_specific_ad_myzone'].',',','.$business_id.',');

                        if($matched!==false){

                            $approval=1;

                        }else{

                            $approval=0;

                        }

                    }

                }else{

                    $approval=0;

                }

            }   

            else if($arr_adsettingspref['isdefault']==0){

                if($arr_adsettingspref['approval']==1){

                    if($arr_zonepref['auto_approve_paid_ad_locatedmyzone']==1){

                        $approval=1;

                    }else if($arr_zonepref['auto_approve_paid_ad_locatedmyzone']==0){

                        //check is specific business mathced with this business id

                        $matched=strpos(','.$arr_zonepref['auto_approve_paid_specific_ad_locatedmyzone'].',',','.$business_id.',');

                        if($matched!==false){

                            $approval=1;

                        }else{

                            $approval=0;

                        }

                    }

                }else if($arr_adsettingspref['approval']==2){

                    if($arr_zonepref['auto_approve_trial_ad_locatedmyzone']==1){

                        $approval=1;

                    }else if($arr_zonepref['auto_approve_trial_ad_locatedmyzone']==0){

                        //check is specific business mathced with this business id

                        $matched=strpos(','.$arr_zonepref['auto_approve_trial_specific_ad_locatedmyzone'].',',','.$business_id.',');

                        if($matched!==false){

                            $approval=1;

                        }else{

                            $approval=0;

                        }

                    }

                }else{

                    $approval=0;

                }

            }

            

            if($adid !=0 && $zoneid != 0){

                $sql = "UPDATE ad_to_zone SET approval=$approval WHERE adid=$adid AND zoneid=$zoneid" ;

                $query=$this->db->query($sql);

            }

    }

    // End  : Editing ads will also update approval to '0' in ad_to_zone table // added on 19.6.14

    

    // Start : added on 9.6.14 for changing non temp ads to temp ads

    function convert_to_active_upload($business_id='',$zoneid=''){ // added on 9.6.14 for changing non temp ads to temp ads

        //var_dump(1); exit;

        if($business_id!='' && $zoneid=!''){

            $sql1 = "UPDATE ads_setting_preferences SET approval=3, isdefault=0 WHERE businessid IN($business_id)" ; //added on 14.6.14 for uploaded business issue

            $this->db->query($sql1);

            

            $sql2 = "UPDATE ads SET category_id=0, categoryid=-99, categoryid1=0, subcategoryid=-99 WHERE business_id IN($business_id)" ;

            $this->db->query($sql2);

            $data = array(); $x='';

            $sql3 = "SELECT id FROM ads WHERE business_id IN($business_id)";

            $query = $this->db->query($sql3);

            $data = $query->result_array();

            foreach($data as $val){

                $x .= $val['id'].','; 

            }

            $adid = rtrim($x,',');

            if($adid != ''){

                $sql4 = "UPDATE ad_category_subcategory SET catid=-99, cat_group_id=0,subcatid=-99 WHERE adid IN($adid)" ;

                $this->db->query($sql4);

            }

        }

    }

    

    // End : added on 9.6.14 for changing non temp ads to temp ads

    

    // + business name for ads

    

        /*$sql="Select RPAD(c.name,'1','?') as nm from  ad_to_zone a,ads b,business c where a.adid=b.id and b.business_id=c.id and a.zoneid=".$zoneid." and a.approval=".$approval." group by nm order by c.name";*/

        

    function business_name_for_display_ads($zoneid=0,$approval=0,$bustype=0){       

        $wh_type = '';

        if($bustype == 0){  // for non temp

            //$approval_bustype = ' and d.approval IN (1,2)';

            $wh_type=" and d.catid!='-99' and d.subcatid!='-99' and d.catid!='14'";

        }else if($bustype == 1){    // for temp

            //$approval_bustype = ' and d.approval IN (3)';

            $wh_type=" and d.catid='-99' and d.subcatid='-99'";

        }else if($bustype == 2){    // for franchisee

            //$approval_bustype = ' and d.approval IN (3)';

            $wh_type=" and d.catid='14'";

        }



        $sql="Select RPAD(c.name,'1','?') as nm from  ad_to_zone a,ads b,business c,ad_category_subcategory d where

        a.adid=b.id and

        b.business_id=c.id and

        a.adid=d.adid and

        a.zoneid=".$zoneid." and

        a.approval=".$approval."

        ".$wh_type." and c.name!=''

        group by nm order by c.name";

        $query = $this->db->query($sql);

        return $query->result_array();

    }

    

    /*function business_name_for_display_ads($zoneid=0,$approval=0,$bustype=0){     //      C O M M E N T E D  O N  14.8.14 for non-temp business

        $wh_type = '';

        if($bustype == 0){  // for non temp

            $wh_type = ' and e.approval IN (1,2) and e.type=1';

            //$wh_type=" and d.catid!='-99' and d.subcatid!='-99' and d.catid!='14'";

        }else if($bustype == 1){    // for temp

            $wh_type = ' and e.approval IN (3) and e.type=1';

            //$wh_type=" and d.catid='-99' and d.subcatid='-99'";

        }else if($bustype == 2){    // for franchisee

            $wh_type = ' and e.approval IN (1,2) and e.type=2';

            //$wh_type=" and d.catid='14'";

        }



        $sql="Select RPAD(c.name,'1','?') as nm from  ad_to_zone a,ads b,business c,ad_category_subcategory d, ads_setting_preferences e where

        a.adid=b.id and

        b.business_id=c.id and

        b.business_id=e.businessid and

        a.adid=d.adid and

        a.zoneid=".$zoneid." and

        a.approval=".$approval."

        ".$wh_type."

        group by nm order by c.name";

        $query = $this->db->query($sql);

        return $query->result_array();

    }*/

    

# + Delete Ads from Business    

    function fn_business_ads_delete($adid='',$zoneid='',$allorspecific='',$from_zone='',$ads_type='',$businessid=''){

        //var_dump($adid,$zoneid,$allorspecific,$from_zone,$ads_type,$businessid); exit;

        if($allorspecific == 1){    ///////////////////////////// Delete Specific ads

            $check_adid = explode(',',$adid); $adid_other_zone = ''; $adid_same_zone = '';

            foreach($check_adid as $val){

                $query = $this->db->query("SELECT * FROM `ad_to_zone` WHERE adid =".$val);

                if($query->num_rows() > 1){

                    $adid_other_zone .= $val.',';

                }

                else{

                    $adid_same_zone .= $val.',';

                }

            }

            $adid_other_zone = rtrim($adid_other_zone,','); // not needed

            $adid_same_zone = rtrim($adid_same_zone,',');

            //var_dump($adid_other_zone,$adid_same_zone); exit;



            if($from_zone == 1){    // ###########for current zone ads delete

                if($adid_same_zone != ''){

                    $sql_ads = "DELETE FROM ads WHERE id IN (".$adid_same_zone.") AND business_id=".$businessid ;   // Delete from ads table

                    $this->db->query($sql_ads);

                

                    $sql_cat_subcat = "DELETE FROM `ad_category_subcategory` WHERE adid IN (".$adid_same_zone.") "; // Delete from ad_category_subcategory

                    $this->db->query($sql_cat_subcat);  

                }

                $sql_ads_to_zone = "DELETE FROM ad_to_zone WHERE adid IN (".$adid.") AND zoneid=".$zoneid ; // Delete from ad_to_zone table

                $this->db->query($sql_ads_to_zone);

            }else if($from_zone == 2){      // ###########for all others zone ads delete

        

                $sql_ads = "DELETE FROM ads WHERE id IN (".$adid.") AND business_id=".$businessid ; // Delete from ads table

                $this->db->query($sql_ads);

            

                $sql_cat_subcat = "DELETE FROM `ad_category_subcategory` WHERE adid IN (".$adid.") ";   // Delete from ad_category_subcategory

                $this->db->query($sql_cat_subcat);  

            

                $sql_ads_to_zone = "DELETE FROM ad_to_zone WHERE adid IN (".$adid.")" ; // Delete from ad_to_zone table

                $this->db->query($sql_ads_to_zone);

            }

            

            return $adid;           

            

        }else if($allorspecific == 2){      ///////////////////////// Delete All ads

            $result = $this->db->query("SELECT group_concat(DISTINCT b.adid) as adsid FROM ads a, ad_to_zone b WHERE a.id = b.adid AND b.approval=$ads_type AND a.business_id = ".$businessid);

            $ids_to_delete = $result->result_array(); //var_dump($ids_to_delete); exit;

            $check_adid = explode(',',$ids_to_delete[0]['adsid']); $adid_other_zone = ''; $adid_same_zone = '';

            

            foreach($check_adid as $val){

                $query = $this->db->query("SELECT * FROM `ad_to_zone` WHERE adid =".$val);

                if($query->num_rows() > 1){

                    $adid_other_zone .= $val.',';

                }

                else{

                    $adid_same_zone .= $val.',';

                }

            }

            $adid_other_zone = rtrim($adid_other_zone,','); // not needed

            $adid_same_zone = rtrim($adid_same_zone,',');

            //var_dump($adid_other_zone,$adid_same_zone); exit;

            

            if($from_zone == 1){        // #########for current zone ads delete

                if($adid_same_zone != ''){

                    $sql_ads = "DELETE FROM ads WHERE id IN (".$adid_same_zone.") AND business_id=".$businessid ;   // Delete from ads table

                    $this->db->query($sql_ads); 

                    

                    $sql_cat_subcat = "DELETE FROM `ad_category_subcategory` WHERE adid IN (".$adid_same_zone.") "; // Delete from ad_category_subcategory

                    $this->db->query($sql_cat_subcat);

                }

                $sql_ads_to_zone = "DELETE FROM ad_to_zone WHERE adid IN (".$ids_to_delete[0]['adsid'].") AND zoneid=".$zoneid ;    // Delete from ad_to_zone table

                $this->db->query($sql_ads_to_zone);

            }

            else if($from_zone == 2){   // ##########for all others zone ads delete

                

                    $sql_ads = "DELETE FROM ads WHERE id IN (".$ids_to_delete[0]['adsid'].") AND business_id=".$businessid ;    // Delete from ads table

                    $this->db->query($sql_ads); 

                    

                    $sql_cat_subcat = "DELETE FROM `ad_category_subcategory` WHERE adid IN (".$ids_to_delete[0]['adsid'].") ";  // Delete from ad_category_subcategory

                    $this->db->query($sql_cat_subcat);

                

                    $sql_ads_to_zone = "DELETE FROM ad_to_zone WHERE adid IN (".$ids_to_delete[0]['adsid'].")" ;    // Delete from ad_to_zone table

                    $this->db->query($sql_ads_to_zone); 

            }

            return 'all';



        }

    }

# - Delete Ads from Business    

    function fn_business_ads_copy($adid='',$zoneid='',$allorspecific='',$ads_type='',$businessid='',$zone_list=''){

        if($allorspecific == 1){

            

            

        }else if($allorspecific == 2){

            

        }

        

    }



# + webinar_information --> get the webinar details via business table using the ad id form the webinar information table

    public function webinar_information($adId,$zoneId){

        $sql = "SELECT a.*, b.business_id, c.business_owner_id FROM webinar_information as a , ads as b , business as c WHERE b.id = $adId AND b.business_id=c.id AND c.business_owner_id = a.created_by_userid AND a.zoneid=$zoneId"; 

        $query = $this->db->query($sql);

        $webinar_information = $query->result_array(); 

        return $webinar_information;

    }

    

    public function join_webinar($zoneId,$userid,$webinarid){

     $sql="SELECT * FROM joined_webinar_users where webinar_information_id=".$webinarid." AND joined_userid=".$userid." AND zoneid=".$zoneId; 

        $query=$this->db->query($sql);

        $join_webinar=$query->result_array();

        if(!empty($join_webinar))

        {

          return 0; 

        }

        else

        {

        $webinar=array(

           'joined_userid'=>$userid,

           'zoneid'=>$zoneId,

           'webinar_information_id'=>$webinarid,

           'timestamp'=>time(),

        );        

        $sql=$this->db->insert('joined_webinar_users',$webinar);

        $insert_id = $this->db->insert_id();

            if($insert_id != ''){

                return 1;

            }

        }

    }

    

    public function webinar_schedule_details($adId,$zoneId){

        $sql = "SELECT a.*, b.business_id, c.business_owner_id FROM webinar_information as a , ads as b , business as c WHERE b.id = $adId AND b.business_id=c.id AND c.business_owner_id = a.created_by_userid AND a.zoneid=$zoneId";

        $query = $this->db->query($sql);    

        $schedule_details = $query->result_array();

        return $schedule_details;

    }

# - webinar_information --> get the webinar details via business table using the ad id form the webinar information table

    

    

    function business_peekaboo($adId,$zoneId){

       $session_from_zone = $this->session->userdata('session_login_details'); 

       $session_from_zone_type = $session_from_zone['type'];

    $sql="select b.id, d.group_id,e.username  from business as a , ads as  b, sales_zone as c, users_groups d, users as e  where b.business_id=a.id and c.id='$zoneId' and b.id='$adId' and  d.user_id=a.business_owner_id and e.id=a.business_owner_id";       

        $query=$this->db->query($sql);

        $business_peekaboo=$query->row_array(); 

        return $business_peekaboo;

    

    }

    

    function business_peekaboo_bidder($zoneId){

        session_start();

        $session_normal_user_id = $this->session->userdata('user_id'); 

        $sql = "select a.id, a.username, b.group_id from users a, users_groups b, sales_zone c where a.id=b.user_id and a.id='".$session_normal_user_id."' and c.id='".$zoneId."' and b.group_id='10' ";

        

        $query = $this->db->query($sql);

        $bidder = $query->row_array();

        return $bidder;

        

    }
    
    public function show_popup($adId,$zoneId,$filter=''){
        $sql="select a.id as busid,e.username from business as a , ads as  b, users as e where b.business_id=a.id and e.id=a.business_owner_id and b.id='$adId'";
        $business_peekaboo = $this->CommonController->SelectRawquery($sql);
        $username = $business_peekaboo['0']['username']; 
        $busid = $business_peekaboo['0']['busid'];
        $current_date = date('Y-m-d');
        
        $peekaboo_popup_sql = "select c.id, b.*, a.company_name, d.product_name, d.nobypass,d.consolation_price,d.cert_accept,d.description,d.publisher_fee,d.card_img  , d.numberofconsolation from  tbl_member a,tbl_auction b, ads c, tbl_inventory_products d where a.user_id=b.user_id and a.user_name='$username' and a.user_id=d.user_id and b.status IN('Live','Public') and c.id='$adId' and b.product_id=d.product_id group by b.auc_id order by b.start_date ASC,d.product_name";
        $peekaboo_popup_show = $this->CommonController->SelectRawquery($peekaboo_popup_sql);
        foreach($peekaboo_popup_show as $key=>$val){
            $left_consolation = "SELECT   abs(count(so.order_id) - tp.numberofconsolation )  as totalconsolationleft FROM `tbl_inventory_products` as tp left join  tbl_auction as ac on tp.product_id =  ac.product_id inner join  tbl_sales_order as so on so.auc_id =  ac.auc_id where ac.product_id = ".$val['product_id'];
            $left_total_consolation = $this->CommonController->SelectRawquery($left_consolation);

            $startdate = strtotime('now');
            $stopdate = strtotime($val['end_date']);
            $diff = $stopdate - $startdate;
            $days = floor($diff / 86400);
            $diff = $diff % 86400;
            $hours = floor($diff / 3600);
            $diff = $diff % 3600;
            $minutes = floor($diff / 60);
            $diff = $diff % 60;
            $seconds = $diff;
            $arr = array('days'=>$days,'hours'=>$hours,'minutes'=>$minutes,'seconds'=>$seconds) ;
            $peekaboo_popup_show[$key] = array_merge($val,$arr ,  $left_total_consolation[0]) ;
        }
        return $peekaboo_popup_show;
    }



    // getting deals for business search
    public function show_dealsnew($adid,$zoneId,$filter='',$username = '', $busid = 0, $user_id = 0,$compname = '',$deal_id = 0,$insert_via_csv = 0){
        if($user_id != ''){
            $current_date = date('Y-m-d');
            if($insert_via_csv == 1){
                $peekaboo_popup_sql = "SELECT b.*, d.product_name, d.nobypass,d.consolation_price,d.cert_accept,d.description,d.publisher_fee,d.card_img  , d.numberofconsolation ,d.insert_via_csv FROM tbl_deals b INNER JOIN tbl_deals_products d ON b.user_id=d.user_id and b.status IN('Live') and b.user_id='$user_id' and d.user_id='$user_id' and b.product_id=d.deal_product_id group by b.deal_id";
            }else{
                $peekaboo_popup_sql = "SELECT b.*, d.product_name, d.nobypass,d.consolation_price,d.cert_accept,d.description,d.publisher_fee,d.card_img  , d.numberofconsolation , d.insert_via_csv FROM tbl_deals b
            INNER JOIN tbl_deals_products d 
            ON b.user_id=d.user_id  
            and b.status IN('Live') 
            and b.user_id='$user_id' 
            and d.user_id='$user_id' 
            and b.product_id=d.deal_product_id 
            and ('".$current_date."' BETWEEN b.start_date AND DATE_FORMAT( b.end_date, '%Y-%m-%d'))   
                group by b.deal_id";
            }   
            
            $peekaboo_popup_show = $this->CommonController->SelectRawquery($peekaboo_popup_sql, 'resultArray');  
            
            foreach($peekaboo_popup_show as $key=>$val){
                if($insert_via_csv == 1){
                    if(file_exists("/home/savingssites/public_html/assets/SavingsUpload/CSV/".$val['zone_id']."/images/".$val['card_img']."")){
                        $image_info = @getimagesize("https://savingssites.com/assets/SavingsUpload/CSV/".$val['zone_id']."/images/".$val['card_img']."");
                        if(is_array($image_info) && $image_info['bits'] <= 0){
                            $peekaboo_popup_show[$key]['card_img'] = '';    
                        }else if($image_info == ''){
                            $peekaboo_popup_show[$key]['card_img'] = '';
                        }
                    }else{
                        $peekaboo_popup_show[$key]['card_img'] = '';
                    }
                }else{
                    if(file_exists("/home/savingssites/public_html/assets/SavingsUpload/Business/".$busid."/".$val['card_img'])){
                        $image_info = @getimagesize(base_url()."/assets/SavingsUpload/Business/".$busid."/".$val['card_img']);
                        if(is_array($image_info) && $image_info['bits'] <= 0){
                            $peekaboo_popup_show[$key]['card_img'] = '';    
                        }else if($image_info == ''){
                            $peekaboo_popup_show[$key]['card_img'] = '';
                        } 
                    }else{
                        $peekaboo_popup_show[$key]['card_img'] = '';   
                    }  
                }
            } 
            foreach($peekaboo_popup_show as $key=>$val){
                $left_consolation = "SELECT   abs(count(so.order_id) - tp.numberofconsolation )  as totalconsolationleft FROM `tbl_deals_products` as tp  left join  tbl_deals as so on so.deal_id =  tp.deal_product_id where tp.deal_product_id = ".$val['product_id'];
                $left_total_consolation = $this->CommonController->SelectRawquery($left_consolation, 'resultArray');
                $startdate = strtotime('now');
                $stopdate = strtotime($val['end_date']);
                $diff = $stopdate - $startdate;
                $days = floor($diff / 86400);
                $diff = $diff % 86400;
                $hours = floor($diff / 3600);
                $diff = $diff % 3600;
                $minutes = floor($diff / 60);
                $diff = $diff % 60;
                $seconds = $diff;
                $arr = array('id' => $adid,'company_name' => $compname,'days'=>$days,'hours'=>$hours,'minutes'=>$minutes,'seconds'=>$seconds) ;
                $peekaboo_popup_show[$key] = array_merge($val,$arr,$left_total_consolation[0]) ;
            } 
        }else{
            $peekaboo_popup_show = [];  
        }
        return $peekaboo_popup_show;
    }

    function update_numberofconsolation(){
        echo"here";
    }


    function show_deals($adId,$zoneId,$filter=''){
        $sql="select b.id,a.id as busid, d.group_id,e.username  from business as a , ads as  b, sales_zone as c, users_groups d, users as e  where b.business_id=a.id and c.id='$zoneId' and b.id='$adId' and  d.user_id=a.business_owner_id and e.id=a.business_owner_id";
        $query=$this->db->query($sql);
        $business_peekaboo=$query->result_array();
        $username = $business_peekaboo['0']['username']; 
        $busid = $business_peekaboo['0']['busid'];
        $current_date = date('Y-m-d');

        $peekaboo_popup_sql = "select c.id, b.*, a.company_name, d.product_name, d.nobypass,d.consolation_price,d.cert_accept,d.description,d.publisher_fee,d.card_img  , d.numberofconsolation from  tbl_member a, tbl_deals b, ads c, tbl_deals_products d where a.user_id=b.user_id and a.user_name='$username' and a.user_id=d.user_id and b.status IN('Live') and c.id='$adId' and b.product_id=d.deal_product_id and ('".$current_date."' BETWEEN b.start_date AND DATE_FORMAT( b.end_date, '%Y-%m-%d'))   group by b.deal_id";
        $peekaboo_popup =$this->db->query($peekaboo_popup_sql);
        $peekaboo_popup_show= $peekaboo_popup->result_array();
        foreach($peekaboo_popup_show as $key=>$val){
            $left_consolation = "SELECT   abs(count(so.order_id) - tp.numberofconsolation )  as totalconsolationleft FROM `tbl_deals_products` as tp left join  tbl_auction as ac on tp.deal_product_id =  ac.product_id inner join  tbl_deals as so on so.deal_id =  ac.product_id where ac.product_id = ".$val['product_id'];
            $lefttotal_consolation =$this->db->query($left_consolation);
            $left_total_consolation = $lefttotal_consolation->result_array();
            $startdate = strtotime('now');
            $stopdate = strtotime($val['end_date']);
            $diff = $stopdate - $startdate;
            $days = floor($diff / 86400);
            $diff = $diff % 86400;
            $hours = floor($diff / 3600);
            $diff = $diff % 3600;
            $minutes = floor($diff / 60);
            $diff = $diff % 60;
            $seconds = $diff;
            $arr = array('days'=>$days,'hours'=>$hours,'minutes'=>$minutes,'seconds'=>$seconds) ;
            $peekaboo_popup_show[$key] = array_merge($val,$arr ,  $left_total_consolation[0]) ;
        }
        return $peekaboo_popup_show;
    }



      function show_serachDeliverypopup($adId,$zoneId){

        

   $sql="select b.id,a.id as busid, d.group_id,e.username  from business as a , ads as  b, sales_zone as c, users_groups d, users as e  where b.business_id=a.id and c.id='$zoneId' and b.id='$adId' and  d.user_id=a.business_owner_id and e.id=a.business_owner_id";
   
        $query=$this->db->query($sql);



        $business_peekaboo=$query->result_array();

        $username = $business_peekaboo['0']['username']; 

        $busid = $business_peekaboo['0']['busid'];

        $current_date = date('Y-m-d');
 

         // Remove stating date condition to how all auctions
            $peekaboo_popup_sql = "select c.id, b.*, a.company_name, d.product_name, d.nobypass,d.consolation_price,d.cert_accept,d.description,d.publisher_fee,d.card_img  , d.numberofconsolation from  tbl_member a,tbl_auction b, ads c, tbl_inventory_products d where a.user_id=b.user_id and a.user_name='$username' and a.user_id=d.user_id and b.status IN('Live','Public') and c.id='".$adId."' and b.product_id=d.product_id group by b.auc_id order by b.start_date ASC,d.product_name";


             $peekaboo_popup =$this->db->query($peekaboo_popup_sql);
               //echo "<pre>"; var_dump($peekaboo_popup);exit;

             $peekaboo_popup_show = $peekaboo_popup->result_array(); 
         

             // ++ Add remaining time of each auction
             if($peekaboo_popup_show){
             foreach($peekaboo_popup_show as $key=>$val){
 
             
                $left_consolation = "SELECT   abs(count(so.order_id) - tp.numberofconsolation )  as totalconsolationleft FROM `tbl_inventory_products` as tp left join  tbl_auction as ac on tp.product_id =  ac.product_id inner join  tbl_sales_order as so on so.auc_id =  ac.auc_id where ac.product_id = ".$val['product_id'];
                $lefttotal_consolation =$this->db->query($left_consolation);

                $left_total_consolation = $lefttotal_consolation->result_array();


                    // echo "<pre>"; var_dump( $left_total_consolation );



                $startdate = strtotime('now');

                $stopdate = strtotime($val['end_date']);

                $diff = $stopdate - $startdate; //<-Time of countdown in seconds.  ie. 3600 = 1 hr. or 86400 = 1 day.

                

                $days = floor($diff / 86400);

                $diff = $diff % 86400;

                $hours = floor($diff / 3600);

                $diff = $diff % 3600;

                $minutes = floor($diff / 60);

                $diff = $diff % 60;

                $seconds = $diff;

                $arr = array('days'=>$days,'hours'=>$hours,'minutes'=>$minutes,'seconds'=>$seconds) ;

                $peekaboo_popup_show[$key] = array_merge($val,$arr ,  $left_total_consolation[0]) ;

             }


 }
             // -- Add remaining time of each auction

             return $peekaboo_popup_show;

        

    }


    

    function show_auction_by_business($adId,$zoneId){

        

        $sql="select b.id,a.id as busid, d.group_id,e.username  from business as a , ads as  b, sales_zone as c, users_groups d, users as e  where b.business_id=a.id and c.id='$zoneId' and b.id='$adId' and  d.user_id=a.business_owner_id and e.id=a.business_owner_id";

        $query=$this->db->query($sql);

        $business_peekaboo=$query->result_array();

        $username = $business_peekaboo['0']['username']; 

        $busid = $business_peekaboo['0']['busid'];

        $current_date = date('Y-m-d');

              

            // $peekaboo_popup_sql = "select c.id, b.*, a.company_name, d.product_name from  tbl_member a,tbl_auction b, ads c, tbl_inventory_products d where a.user_id=b.user_id and a.user_name='$username' and a.user_id=d.user_id and b.status='Live' and c.id='$adId' order by b.auc_id DESC,d.product_name DESC limit 1"; 

              $peekaboo_popup_sql = "select c.id, b.*, a.company_name, d.product_name, d.nobypass,d.consolation_price,d.cert_accept,d.description,d.publisher_fee,d.card_img from  tbl_member a,tbl_auction b, ads c, tbl_inventory_products d where a.user_id=b.user_id and a.user_name='$username' and a.user_id=d.user_id and b.status IN('Live','Public') and c.id='$adId' and b.start_date<='$current_date' and b.product_id=d.product_id group by b.auc_id order by b.start_date ASC,d.product_name"; 

             $peekaboo_popup =$this->db->query($peekaboo_popup_sql);

             $peekaboo_popup_show = $peekaboo_popup->result_array();//echo "<pre>"; var_dump($peekaboo_popup_show);exit;

             // ++ Add remaining time of each auction

             foreach($peekaboo_popup_show as $key=>$val){

                $startdate = strtotime('now');

                $stopdate = strtotime($val['end_date']);

                $diff = $stopdate - $startdate; //<-Time of countdown in seconds.  ie. 3600 = 1 hr. or 86400 = 1 day.

                

                $days = floor($diff / 86400);

                $diff = $diff % 86400;

                $hours = floor($diff / 3600);

                $diff = $diff % 3600;

                $minutes = floor($diff / 60);

                $diff = $diff % 60;

                $seconds = $diff;

                $arr = array('days'=>$days,'hours'=>$hours,'minutes'=>$minutes,'seconds'=>$seconds) ;

                $peekaboo_popup_show[$key] = array_merge($val,$arr) ;

             }

             // -- Add remaining time of each auction

             return $peekaboo_popup_show;

    }



    function popup_content_show($adId,$zoneId,$busId,$auc_id){

        

        $sql="select b.id,a.id as busid, d.group_id,e.username  from business as a , ads as  b, sales_zone as c, users_groups d, users as e  where b.business_id=a.id and c.id='$zoneId' and b.id='$adId' and  d.user_id=a.business_owner_id and e.id=a.business_owner_id";

        $query=$this->db->query($sql);

        $business_peekaboo=$query->result_array();

        $username = $business_peekaboo['0']['username']; 

        $busid = $business_peekaboo['0']['busid'];

              

             $peekaboo_popup_sql = "select c.id,c.business_id, b.* from  tbl_member a,tbl_auction b, ads c where a.user_id=b.user_id and b.status='Live' and b.auc_id='$auc_id' and a.user_name='$username' and c.id='$adId'"; 

             $peekaboo_popup =$this->db->query($peekaboo_popup_sql);

             $peekaboo_popup_show = $peekaboo_popup->result_array();

             return $peekaboo_popup_show;

    }

    

    function zone_from_login($zoneId){

        session_start();

        

        $username = $this->session->userdata('username');

        $user_id = $this->session->userdata('user_id');

        $sql = "select a.id, a.username, b.group_id from users a, users_groups b, sales_zone c where a.id=b.user_id and a.id='".$user_id."' and a.username='".$username."' and c.id='".$zoneId."' and b.group_id='4' ";

        $query = $this->db->query($sql);

        $zone = $query->row_array();

        return $zone;

    }

    function check_blog_zone_owner($user_id,$zoneid, $busid){//var_dump($user_id);exit;

      $sql ="select sales_rep_id, id from sales_zone where sales_rep_id='".$user_id."' and id='".$zoneid."'";

      $result = $this->db->query($sql);

      $query = $result->result_array(); 

      if($query){

          $cookie = array(

                'name'   => 'set_blog_value',

                'value'  => 1,

                'expire' => time()+86500,

                'domain' => '',

                'path'   => '/',

                'prefix' => '',

            );

            set_cookie($cookie);

      }else{

          $cookie = array(

                'name'   => 'set_blog_value',

                'value'  => 0,

                'expire' => time()+86500,

                'domain' => '',

                'path'   => '/',

                'prefix' => '',

            );

            set_cookie($cookie);

      }

        

    }

    function check_blog_business_owner($user_id,$zoneid, $busid){ 

        $sql ="select a.business_owner_id,a.id from business a, ads b, ad_to_zone c where a.business_owner_id='".$user_id."' and a.id='".$busid."' and b.business_id=a.id and b.id=c.adid and c.zoneid='".$zoneid."'"; 

         $result = $this->db->query($sql);

      $query = $result->result_array(); 

      if($query){

          $cookie = array(

                'name'   => 'set_blog_value',

                'value'  => 1,

                'expire' => time()+86500,

                'domain' => '',

                'path'   => '/',

                'prefix' => '',

            );

            set_cookie($cookie);

      }else{

          $cookie = array(

                'name'   => 'set_blog_value',

                'value'  => 0,

                'expire' => time()+86500,

                'domain' => '',

                'path'   => '/',

                'prefix' => '',

            );

            set_cookie($cookie);

      }

        

    }



    function winner_list($zoneId){

        $sql = "SELECT m.user_name,ip.product_name,ip.company_name,a.low_limit_price,a.buy_price_decrease_by,a.auc_id,tso.order_id,tso.dispatched_status,tso.unit_price sold_for,tso.order_datetime FROM (tbl_auction a,tbl_member as m,users u, business b, ads_setting_preferences a_d_p) LEFT JOIN tbl_inventory_products ip ON ip.product_id=a.product_id LEFT JOIN tbl_sales_order tso ON  tso.auc_id=a.auc_id WHERE  tso.user_id=m.user_id AND tso.payment_status='Completed' AND u.username=m.user_name AND u.id=b.business_owner_id AND b.id=a_d_p.businessid AND settingszoneid=".$zoneId."  GROUP BY tso.order_id  ORDER BY tso.order_datetime DESC LIMIT 0,10";

        

        $query = $this->db->query($sql);

        $result = $query->result_array();

            if($result){

              return $result;           

            }else{

              return 1;

            }

    }



    function get_sponser_business($zone_id){



        $sql = "SELECT * FROM `business_sponsor` WHERE `zone_id` = '".$zone_id."' AND `status` = 1";

        $query = $this->db->query($sql);



        if ( $query->num_rows() > 0 )

        {           

            foreach ($query->result() as $row)

            {

                $business[] = $row->business_id;

                              

            }

           

            return $business;

        }

    }



   function get_all_gallery_images($business_id){



        $this->db->select('stivagallery_galleries.id');

        $this->db->from('stivagallery_galleries');

        //$this->db->join('stivagallery_galleries','stivagallery_plugin_gallery.foreign_id = stivagallery_galleries.id');

        $this->db->where('stivagallery_galleries.name',"photo");

        $this->db->where('stivagallery_galleries.business_id',$business_id);

        

        $query = $this->db->get();       

        return $query->result_array();        

    }



    function gallery($gallary_name,$business_id){



        $this->db->select('stivagallery_plugin_gallery.small_path,stivagallery_plugin_gallery.medium_path,stivagallery_plugin_gallery.large_path');

        $this->db->from('stivagallery_plugin_gallery');

        $this->db->join('stivagallery_galleries','stivagallery_plugin_gallery.foreign_id = stivagallery_galleries.id');

        $this->db->where('stivagallery_galleries.name',$gallary_name);

        $this->db->where('stivagallery_galleries.business_id',$business_id);

        if($gallary_name =="logo"){

            $this->db->limit(1);

        }



        $query = $this->db->get();        

        return $query->result_array();

    }



    function get_theme($business_id){



        $this->db->select('*');

        $this->db->from('menu_theme');

        $this->db->where('business_id',$business_id);



        $query = $this->db->get();

        return $query->row_array();

    }



    public function get_menu($business_id){
        return $this->CommonController->SelectDataMultiWay('menu_builder_categories','*','rowArray',['business_id' =>$business_id],[],'',array('column' => 'id','type'=> 'desc'));
    }
    
    public function get_latest_rating($business_id){
        return $this->CommonController->SelectDataMultiWay('rating','rate','rowArray',['busId' =>$business_id],[],'',array('column' => 'id','type'=> 'desc'));
    }
    
    public function is_food_category($adid){
        $finalTimeArray = array();
        $result = $this->CommonController->SelectDataMultiWay('ad_category_subcategory','*','resultArray',['adid' =>$adid,'catid' => 1],[],'',[]);
        foreach ($result as $value) {
            $finalTimeArray['foodCategory'] = $value['id'];
        }
        return $finalTimeArray;
    }

     


    function get_user_email($userId){



        $this->db->select('email,phone,first_name,last_name');

        $this->db->from('users');

        $this->db->where('id',$userId);         



        $query = $this->db->get();

        return $query->row_array();   

    }

    

    function snap_peeks($business_id){

        $this->db->select('display_status');

        $this->db->from('restaurantbooking_business_snap_status');

        $this->db->where('business_id',$business_id);         



        $query = $this->db->get();

        return $query->row_array();

    }



    function reservation_menu($business_id){

        $this->db->select('status');

        $this->db->from('restaurantbooking_working_times ');

        $this->db->where('business_id',$business_id);         



        $query = $this->db->get();

        return $query->row_array();

    }

    public function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'miles') {
        $longitude1 = floatval($longitude1);
        $longitude2 = floatval($longitude2);
        $theta = $longitude1 - $longitude2; 
        $distance = (sin(deg2rad(floatval($latitude1))) * sin(deg2rad(floatval($latitude2)))) + (cos(deg2rad(floatval($latitude1))) * cos(deg2rad(floatval($latitude2))) * cos(deg2rad(floatval($theta)))); 
        $distance = acos($distance);

        $distance = rad2deg($distance); 
        $distance = $distance * 60 * 1.1515; 
        switch($unit) { 
            case 'miles': 
            break; 
            case 'kilometers' : 
            $distance = $distance * 1.609344; 
        } 
        return (round($distance,2)); 
    }

}

