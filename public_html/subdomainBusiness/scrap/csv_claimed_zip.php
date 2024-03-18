<?php

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

	
$header=array(array('Claimed Zip Code'));
$file="Claimed_Zip.csv";
$fp = fopen($file, 'w');
foreach ($header as $fields) {
    fputcsv($fp, $fields);
}
$sql="select zip from tblClaimedZips where approved=1 order by zip asc";
$query=mysql_query($sql) ;
while($row=mysql_fetch_array($query)){
	fputcsv($fp,array($row['zip']));
}
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.$file);
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
	@unlink($file);
    exit;
}



?>