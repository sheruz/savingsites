<?php
require_once "config.php";
if(session_status() == PHP_SESSION_NONE || !isset($_SESSION['loggedin'])){
    header("Location: https://savingssites.com/scrap");  
}

 
$address_id = (isset($_GET['address_id']) && $_GET['address_id'] != '') ? $_GET['address_id'] : 0 ;

if(!empty($address_id))
{
    $address_id_sql = mysqli_fetch_row(mysqli_query("SELECT id FROM address WHERE id=".$address_id));
    $addressid = $address_id_sql[0];

    $business_id_sql = mysqli_fetch_row(mysqli_query("SELECT business_owner_id,id FROM business WHERE addressid=".$addressid));
    $user_id = $business_id_sql[0];
    $business_id = $business_id_sql[1];

    $add_id_sql = mysqli_fetch_row(mysqli_query("SELECT id FROM ads WHERE business_id=".$business_id));
    $addid = $add_id_sql[0];


    $delete_address_id = mysqli_query("DELETE FROM address WHERE id =".$addressid);
    $delete_business_id = mysqli_query("DELETE FROM business WHERE id =".$business_id);
    $delete_ads_setting_preferences = mysqli_query("DELETE FROM ads_setting_preferences WHERE businessid =".$business_id);
    $delete_ads = mysqli_query("DELETE FROM ads WHERE business_id =".$business_id);
    $delete_ad_to_zone = mysqli_query("DELETE FROM ad_to_zone WHERE adid =".$addid);
    $delete_users = mysqli_query("DELETE FROM users WHERE id =".$user_id);
    $delete_users = mysqli_query("DELETE FROM users_groups WHERE user_id =".$user_id);

    //echo "SELECT id FROM address WHERE id=".$address_id;
    //echo"<pre>";
    //print_r($owner_id.'a');
    //print_r($business_id);
    //die;
    echo "Deleted Successfull";
}