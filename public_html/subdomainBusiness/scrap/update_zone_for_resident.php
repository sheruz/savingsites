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
$user_sql = mysql_query("SELECT u.id FROM users AS u INNER JOIN 
zone_residentuser AS zr ON u.id = zr.zone_residentuser_userid WHERE 
zr.zone_residentuser_zoneid = ".$zoneid) ; 
//$user_data = mysql_fetch_array($user_sql);
$count = 0; 
while ($row = mysql_fetch_array($user_sql)) {
  
  $update_users_sql = mysql_query("UPDATE users SET Zone_ID = $zoneid WHERE id = ".$row['id']);
  //echo "zone id is updated for user".$row['business_owner_id'];
  $count++;
}
echo "Total ". $count." users updated";