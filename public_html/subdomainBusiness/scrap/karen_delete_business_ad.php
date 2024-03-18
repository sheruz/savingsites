<?php
set_time_limit(0);
session_start();

if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='127.0.0.1'){
	$hostname = 'localhost';
	$username = 'root';
	$password = '';
	$database='savingssites';
}else{
	$hostname = 'localhost';
	$username = 'savingssites_new';
	$password = 'z9wlq2sOS8E6QU1P';
	$database='savingssites';
}
$hide = 0 ;
$dbhandle = mysql_connect($hostname, $username, $password);
if($dbhandle){  
	$con=mysql_select_db($database,$dbhandle);
	if(!$con)
		echo 'Could not select database';
}else
	echo "Unable to connect MySQL database";



//echo 1; exit;

/*$sql="select b.id from ads_setting_preference a,ads b where a.businessid=b.business_id and a.settingszoneid=125";

$query=mysql_query($sql) ;



	while($row=mysql_fetch_array($query1)){

		//echo $row1['id']; echo '<br>';

		echo $sql_ins="INSERT INTO ads_setting_preferences(businessid,settingszoneid,isdefault,approval,paymenttype,websitevisibility,emailvisibility) VALUES (".$row1['businessid'].",".$row1['settingszoneid'].",".$row1['isdefault'].",".$row1['approval'].",".$row1['paymenttype'].",".$row1['websitevisibility'].",".$row1['emailvisibility'].");"; echo '<br>';

	}*/

/**/





/*$sql1="select * from ad_to_zone_final25113 where zoneid=96";

$query1=mysql_query($sql1) ;

//if(!empty($query1)){

	while($row1=mysql_fetch_array($query1)){

		//echo $row1['id']; echo '<br>';

		echo $sql_ins="INSERT INTO ad_to_zone(adid,zoneid,approval,stickyad) VALUES (".$row1['adid'].",".$row1['zoneid'].",".$row1['approval'].",".$row1['stickyad'].");"; echo '<br>';

	}

//}

*/

/*echo 1;

exit;*/

/*$sql_1="select a.id as atz_id,b.id as aid from ad_to_zone a,ads b where a.adid=b.id and a.zoneid IN(308)";

$query1=mysql_query($sql_1) ; 

while($row1=mysql_fetch_array($query1)){ //var_dump($row1); echo '<br/>';

	$del2="DELETE FROM ad_to_zone where id=".$row1['atz_id'];

	mysql_query($del2);

	$del12="DELETE FROM ads where id=".$row1['aid'];

	mysql_query($del12);

}*/





 $sql="select a.id as asp_id,b.id as bid from ads_setting_preferences a,business b where a.businessid=b.id and a.settingszoneid IN(509)";

$query=mysql_query($sql) ; 

while($row=mysql_fetch_array($query)){	
	
	$del1="DELETE FROM business where id=".$row['bid'];

	mysql_query($del1);
	
	$del="DELETE FROM ads_setting_preferences where id=".$row['asp_id'];

	mysql_query($del);

	

	/*$del2="DELETE FROM address where id=".$row['addressid'];

	mysql_query($del2);

	$del3="DELETE FROM users where id=".$row['uid'];

	mysql_query($del3);

	$del4="DELETE FROM users_groups where user_id=".$row['uid'];

	mysql_query($del4);*/

	

}



	//var_dump($row); echo '<br/>';

	/*$ups="update users SET password='1c3922c88733184b9b66cbf6f0ca694abe3672b9' where id=".$row['business_owner_id'];

	mysql_query($ups);

	$sql1="select id,adtext from ads where business_id=".$row['id'];

	$query1=mysql_query($sql1) ;

	if(mysql_num_rows($query1)>0){

		while($row1=mysql_fetch_array($query1)){

			$adids=$row1['id'];

			$adstxt=urlencode(stripslashes(str_replace('systemâ€"','system',$row1['adtext'])));

			echo $ups1="update ads SET adtext=".$adstxt." where id=".$adids;echo '<br/>';

			mysql_query($ups1);

		}

	}*/

//}

exit;

?>

