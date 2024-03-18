<?php
//session_start();
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
$user_sql = mysql_query("SELECT b.business_owner_id FROM business AS b INNER JOIN 
ads_setting_preferences AS a ON b.id = a.businessid WHERE a.settingszoneid = ".$zoneid) ; 
//$user_data = mysql_fetch_array($user_sql);
$count = 0; 
while ($row = mysql_fetch_array($user_sql)) {
  
  $update_users_sql = mysql_query("UPDATE users SET Zone_ID = $zoneid WHERE id = ".$row['business_owner_id']);
  //echo "zone id is updated for user".$row['business_owner_id'];
  $count++;
}
echo "Total ". $count." users updated";