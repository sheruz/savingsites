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
}else{
	echo "Unable to connect MySQL database";
}
$sql = "SELECT id FROM `ads` where adtext!=''";
$query = mysql_query($sql);
while($row=mysql_fetch_array($query)){
	$ad_id = $row['id'];
	$ad_sql = "select adtext from ads where adtext!='' and id=".$ad_id;
	$ad_query = mysql_query($ad_sql);
	$row1= mysql_fetch_array($ad_query);
	$adtext = $row1['adtext'];
	//$style = str_replace('style="height:250px; width:400px" >', 'style="max-width:100%; height:auto;">', $adtext);
	// $style = str_replace('style=', 'style="max-width:100%;', $adtext);
	preg_match( '@src="([^"]+)"@' , $adtext, $match );
	$image = array_pop($match);//var_dump($image);exit;
	$style = '<img src='.$image.' style="max-width:100%; height:auto;">';
	// $style = str_replace(">", 'style="max-width:100%;">', $adtext);//var_dump($style);exit;
	// $style = str_replace('style="height:250px; width:400px" >', 'style="max-width:100%; height:auto;">', $adtext);
	$update_sql = "update ads set adtext='".stripslashes($style)."' where adtext!='' and id='".$ad_id."' ";//echo $update_sql;//exit;
	$update_query = mysql_query($update_sql);
	if($update_query)
	  {
		echo "<pre>";  echo "Update Image Style successful";
	  }
	  else
	  {
		 echo "<pre>"; echo "Update Image Style was not successful";	  
	  }
}
?>	
	