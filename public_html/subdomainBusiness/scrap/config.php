<?php 
$hostname = 'localhost';
$username = 'savingssites_db';
$password = '@6tZ(rH]]WM^';
$database='savingssites';   
$conn = mysqli_connect($hostname, $username, $password , $database);
if(!$conn){
	echo 'Could not select database'; 
}else{
	echo "Connected";
}
 
 
 
