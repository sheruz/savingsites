<?php
set_time_limit(1200);
require_once "config.php";
if(session_status() == PHP_SESSION_NONE || !isset($_SESSION['loggedin'])){
    header("Location: https://savingssites.com/scrap");  
}

$header=array(array('Zip Code'));
$file="sample.csv";
$fp = fopen($file, 'w');
foreach ($header as $fields) {
    fputcsv($fp, $fields);
}
$sql="select zip from tblClaimedZips";
$query=mysqli_query($dbhandle , $sql) ;
while($row=mysqli_fetch_array($query)){
	 fputcsv($fp,array($row['zip']));

}
if (file_exists($file)) {
	
 header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename='.$file);
 exit;
}