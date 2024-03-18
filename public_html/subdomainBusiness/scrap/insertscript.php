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
	
	

/*$sql="select * from ads_setting_preferences_05062015 where settingszoneid=488";
$query1=mysql_query($sql) ;
if(!empty($query1)){
	while($row1=mysql_fetch_array($query1)){
		$sql_ins="INSERT INTO ads_setting_preferences(id,businessid,settingszoneid,isdefault,approval) VALUES (".$row1['id'].",".$row1['businessid'].",".$row1['settingszoneid'].",".$row1['isdefault'].",".$row1['approval'].")";
		mysql_query($sql_ins); 
	}
}*/


/*$sql="select b.* from ads_setting_preferences_2_6_15 a,business_2_6_15 b where a.businessid=b.id and a.settingszoneid=488";
$query1=mysql_query($sql) ;
if(!empty($query1)){
	while($row1=mysql_fetch_array($query1)){
		echo $sql_ins="INSERT INTO business(id,logo,name,addressid,contactemail,contactfirstname,contactlastname,contactfullname,business_owner_id,website,motto,note,timestamp,starttime,stoptime,isverified,siccode,created_by,audio_presentation,video_presentation,israted,referal_credit) VALUES ('".$row1['id']."','".$row1['logo']."','".mysql_real_escape_string($row1['name'])."','".$row1['addressid']."','".mysql_real_escape_string($row1['contactemail'])."','".mysql_real_escape_string($row1['contactfirstname'])."','".mysql_real_escape_string($row1['contactlastname'])."','".mysql_real_escape_string($row1['contactfullname'])."','".$row1['business_owner_id']."','".$row1['website']."','".$row1['motto']."','".$row1['note']."','".$row1['timestamp']."','".$row1['starttime']."','".$row1['stoptime']."','".$row1['isverified']."','".$row1['siccode']."','".$row1['created_by']."','".$row1['audio_presentation']."','".$row1['video_presentation']."','".$row1['israted']."','".$row1['referal_credit']."')"; echo '<br>';  
		mysql_query($sql_ins); 
	}
}*/

/*$sql="select c.* from ads_setting_preferences_2_6_15 a,business_2_6_15 b,address_05062015 c where a.businessid=b.id and b.addressid=c.id and a.settingszoneid=488";
$query1=mysql_query($sql) ;
if(!empty($query1)){
	while($row1=mysql_fetch_array($query1)){
		echo $sql_ins="INSERT INTO address(id,street_address_1,street_address_2,city,state,zip_code,phone,phone_int,fax,latitude,longitude,isphoneempty) VALUES ('".$row1['id']."','".mysql_real_escape_string($row1['street_address_1'])."','".mysql_real_escape_string($row1['street_address_2'])."','".mysql_real_escape_string($row1['city'])."','".mysql_real_escape_string($row1['state'])."','".$row1['zip_code']."','".mysql_real_escape_string($row1['phone'])."','".$row1['phone_int']."','".mysql_real_escape_string($row1['fax'])."','".$row1['latitude']."','".$row1['longitude']."','".$row1['isphoneempty']."')"; echo '<br>';
		mysql_query($sql_ins); 
	}
}*/
/*$sql="select c.* from ads_setting_preferences_2_6_15 a,business_2_6_15 b,users_05062015 c where a.businessid=b.id and b.business_owner_id=c.id and a.settingszoneid=488";
$query1=mysql_query($sql) ;
if(!empty($query1)){
	while($row1=mysql_fetch_array($query1)){
		echo $sql_ins="INSERT INTO users(id,ip_address,username,password,salt,uploaded_business_password,email,refer_code,activation_code,forgotten_password_code,forgotten_password_time,remember_code,created_on,last_login,active,first_name,last_name,company,phone,carrier,Address,City,State_Code,Zip,status) VALUES ('".$row1['id']."','".$row1['ip_address']."','".mysql_real_escape_string($row1['username'])."','".$row1['password']."','".$row1['salt']."','".mysql_real_escape_string($row1['uploaded_business_password'])."','".mysql_real_escape_string($row1['email'])."','".mysql_real_escape_string($row1['refer_code'])."','".$row1['activation_code']."','".$row1['forgotten_password_code']."','".$row1['forgotten_password_time']."','".$row1['remember_code']."','".$row1['created_on']."','".$row1['last_login']."','".$row1['active']."','".mysql_real_escape_string($row1['first_name'])."','".mysql_real_escape_string($row1['last_name'])."','".mysql_real_escape_string($row1['company'])."','".$row1['phone']."','".mysql_real_escape_string($row1['carrier'])."','".mysql_real_escape_string($row1['Address'])."','".mysql_real_escape_string($row1['City'])."','".$row1['State_Code']."','".$row1['Zip']."','".$row1['status']."')"; echo '<br>';
		mysql_query($sql_ins); 
	}
}*/

$sql="select d.* from ads_setting_preferences_2_6_15 a,business_2_6_15 b,users_05062015 c,users_groups_05062015 d where a.businessid=b.id and b.business_owner_id=c.id and c.id=d.user_id and a.settingszoneid=488";
$query1=mysql_query($sql) ;
if(!empty($query1)){
	while($row1=mysql_fetch_array($query1)){
		echo $sql_ins="INSERT INTO users_groups(id,user_id,group_id) VALUES (".$row1['id'].",".$row1['user_id'].','.$row1['group_id'].')';
		mysql_query($sql_ins); echo '<br>'; 
	}
}
?>