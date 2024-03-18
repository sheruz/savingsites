<?php
session_start();
require_once "config.php";
if(session_status() == PHP_SESSION_NONE || !isset($_SESSION['loggedin'])){
    header("Location: https://savingssites.com/scrap");  
}
    
$zoneid = (isset($_GET['zoneid']) && $_GET['zoneid'] != '') ? $_GET['zoneid'] : 0 ;

if($zoneid != 0){
    mysql_query("SET SESSION group_concat_max_len=10000000000000") ;

    $ads_setting_preferences = mysqli_query("SELECT `businessid` from `ads_setting_preferences` where `settingszoneid` = $zoneid");
    
    
    $businessid_arr = array();
    $business_owner_id = array();
    $ads_id = array();
    while($ads_setting_preferences_row = mysqli_fetch_array($ads_setting_preferences))
    {
        
        $businessid_arr[] = $ads_setting_preferences_row['businessid'];

        $businessid = $ads_setting_preferences_row['businessid'];

        $business = mysqli_fetch_array(mysqli_query("SELECT `business_owner_id` from `business` where `id` = $businessid"));
        $business_owner_id[] = $business['business_owner_id'];

        
    }
    $ad_to_zone = mysqli_fetch_array(mysqli_query("SELECT `adid` from `ad_to_zone` where `zoneid` = $zoneid"));
        $ads_id[] = $ad_to_zone['adid'];

    echo"<pre>";
    print_r(count($businessid_arr))."<br>";
    echo"a";
    print_r(count($business_owner_id))."<br>";
    echo"b";
    print_r(count($ads_id))."<br>";
    die;

}