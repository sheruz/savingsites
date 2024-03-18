<?php
set_time_limit(1200);
if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='127.0.0.1'){
	$hostname='localhost';
	$database='savingssites';
	$username='root';
	$password='';
	$hide = 0 ;
}else{
	$hostname = 'localhost';
	$username = 'savingssites_new';
	$password = 'z9wlq2sOS8E6QU1P';
	$database='savingssites';
}
$dbhandle = mysql_connect($hostname, $username, $password);
if($dbhandle){  
	$con=mysql_select_db($database,$dbhandle);
	if(!$con)
		echo 'Could not select database';
}else
	echo "Unable to connect MySQL database";
	
	$sql = "select * FROM ad_category_subcategory a where a.zoneid=308 AND a.adid NOT IN ( SELECT a.adid FROM ad_category_subcategory a, ads_setting_preferences b, ads c WHERE a.adid=c.id and c.business_id=b.businessid and a.zoneid=308 )";
	$query=mysql_query($sql); 
	
	while($row=mysql_fetch_array($query)){ //echo "<pre>";var_dump($row);exit;
	
	$adid =$row['adid'];
	
	              // Delete Reduandant Adid from ad_category_subcategory table
				  
				  $delete_adid = "DELETE from ad_category_subcategory where adid=".$adid;
				  
				  $query_delete_adid = mysql_query($delete_adid);
				  
						 if($query_delete_adid)
							  {
   								 echo "<pre>";  echo "Successful delete from ad_category_subcategory";
							  }
							  else
							  {
								 echo "<pre>"; echo "Unsuccessful delete from ad_category_subcategory";	  
							  }
	
	}
	

	
?>