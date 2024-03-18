<?php
session_start();
$hostname = 'localhost';
$username = 'savingssites_new';
$password = 'z9wlq2sOS8E6QU1P';
$database='savingssites';

$dbhandle = mysql_connect($hostname, $username, $password);
if($dbhandle){  
	$con=mysql_select_db($database,$dbhandle);
	if(!$con)
		echo 'Could not select database';
}else
	echo "Unable to connect MySQL database";

    //$business_query = mysql_query("SELECT * FROM `address` WHERE `phone_int` = ''") ;
    //$business_query = mysql_query("SELECT * FROM `address` WHERE `phone_int` = '   -   -    '") ;
    $business_query = mysql_query("SELECT * FROM `address` WHERE `phone_int` = '   -   -    '") ;

    if(mysql_num_rows($business_query) > 0)
    {
        while($address_row = mysql_fetch_row($business_query))
        {
            $addressid = $address_row[0];

            $business_id_sql = mysql_fetch_row(mysql_query("SELECT GROUP_CONCAT(business_owner_id),GROUP_CONCAT(id) FROM business WHERE addressid=".$address_row[0]));
            $user_id = $business_id_sql[0];
            $business_id = $business_id_sql[1];

            $add_id_sql = mysql_fetch_row(mysql_query("SELECT GROUP_CONCAT(id) FROM ads WHERE business_id=".$business_id));
            $addid = $add_id_sql[0];

            $delete_address_id = mysql_query("DELETE FROM address WHERE id IN(".$addressid.")");
            $delete_business_id = mysql_query("DELETE FROM business WHERE id IN(".$business_id.")");
            $delete_ads_setting_preferences = mysql_query("DELETE FROM ads_setting_preferences WHERE businessid IN(".$business_id.")");
            $delete_ads = mysql_query("DELETE FROM ads WHERE business_id IN(".$business_id.")");
            $delete_ad_to_zone = mysql_query("DELETE FROM ad_to_zone WHERE adid IN(".$addid.")");
            $delete_users = mysql_query("DELETE FROM users WHERE id IN(".$user_id.")");
            $delete_users = mysql_query("DELETE FROM users_groups WHERE user_id IN(".$user_id.")");
            
        }

        echo "Delete Successful";
    }