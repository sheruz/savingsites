<?php

session_start();

$hostname = 'localhost';

$username = 'savingssites_new';

$password = 'z9wlq2sOS8E6QU1P';

$database='savingssites';

/*$hostname = 'localhost';

$username = 'root';

$password = '';

$database='savingssites';*/

$hide = 0 ;

$dbhandle = mysql_connect($hostname, $username, $password);

if($dbhandle){  

	$con=mysql_select_db($database,$dbhandle);

	if(!$con)

		echo 'Could not select database';

}else

	echo "Unable to connect MySQL database";



$zoneid = (isset($_GET['zoneid']) && $_GET['zoneid'] != '') ? $_GET['zoneid'] : 0 ; 

 $zone_owner = mysql_query("SELECT sales_rep_id FROM sales_zone WHERE id=".$zoneid) ; 

 $zone_row = mysql_fetch_array($zone_owner) ; 

 $zone_userid = (isset($zone_row['sales_rep_id']) && $zone_row['sales_rep_id'] != '' ) ? $zone_row['sales_rep_id'] : '' ; echo '<br/>';



if($zoneid != 0 && $zone_userid != ''){

	mysql_query("SET SESSION group_concat_max_len=10000000000000") ;

	$business_query = mysql_query("SELECT GROUP_CONCAT(businessid) as businessid FROM ads_setting_preferences WHERE settingszoneid = ".$zoneid) ;

	if(mysql_num_rows($business_query) > 0){ //echo mysql_num_rows($business_query); exit;

		while($business_row = mysql_fetch_array($business_query)){

			// Business Owner details

			$select_business_owner=mysql_fetch_array(mysql_query("SELECT GROUP_CONCAT(a.addressid) as addressid, GROUP_CONCAT(a.business_owner_id) as businessownerid from business a, ads_setting_preferences b where a.id=b.businessid and a.id IN(".$business_row['businessid'].") and  b.settingszoneid IN(".$zoneid.") AND a.business_owner_id NOT IN(".$zone_userid.")")) ; 

			echo $businessownerid = $select_business_owner['businessownerid'] ; echo '<br/>';

			echo $addressid = $select_business_owner['addressid'] ;

			

			$select_ads = mysql_query("SELECT GROUP_CONCAT(id) as adid FROM ads WHERE business_id IN(".$business_row['businessid'].")") ;

			if(mysql_num_rows($select_ads) > 0){

				

				$ads_row = mysql_fetch_array($select_ads) ;

				echo '<br/>'; echo $ads_row['adid']; echo '<br/>';

				// Delete Ads

				$delete_ads = mysql_query("DELETE FROM ads WHERE id IN(".$ads_row['adid'].")") ;

				// Delete ad_to_zone

				$delete_adtozone = mysql_query("DELETE FROM ad_to_zone WHERE adid IN (".$ads_row['adid'].")"); 

				// Delete ad_category_subcategory

				////$delete_ad_cat_subcat = mysql_query("DELETE FROM  ad_category_subcategory WHERE adid IN (".$ads_row['adid'].") and zoneid IN(".$zoneid.")");

				// Delete users_favorites

				////$delete_adtofav = mysql_query("DELETE FROM users_favorites WHERE adid IN(".$ads_row['adid'].")") ;

			}

			// Delete business_photos

			//$delete_bus_image = mysql_query("DELETE FROM business_photos WHERE bus_id IN(".$business_row['businessid'].")") ;

			//// Delete businessphotos_display

			//$delete_bus_image_display = mysql_query("DELETE FROM businessphotos_display WHERE bus_id IN(".$business_row['businessid'].")" ) ;

			// Delete business_operation_hour

			//$delete_operation_hour = mysql_query("DELETE FROM business_operation_hour WHERE business_id IN (".$business_row['businessid'].") and zone_id IN(".$zoneid.")") ;

			

			// Delete business

			$delete_business = mysql_query("DELETE FROM business WHERE id IN(".$business_row['businessid'].")") ;

			// Delete ads_setting_preferences

			$delete_ads_setting = mysql_query("DELETE FROM ads_setting_preferences WHERE businessid IN(".$business_row['businessid'].")") ; // Delete Address

			$delete_address = mysql_query("DELETE FROM address WHERE id IN(".$addressid.")") ;

			// Delete users

			$delete_users = mysql_query("DELETE FROM users WHERE id IN(".$businessownerid.")") ;

			// Delete users_groups

			$delete_user_group = mysql_query("DELETE FROM users_groups WHERE user_id IN(".$businessownerid.")") ; 

			echo 'Delete Successful' ; 

		}

	}else{

		echo 'NO BUSINESS FOUND';

	}

}else{

	echo 'No ID GIVEN' ;

}