<?php
session_start();
require_once "config.php";
if(session_status() == PHP_SESSION_NONE || !isset($_SESSION['loggedin'])){
    header("Location: https://savingssites.com/scrap");  
}
  

//date_default_timezone_set('UTC');
$date = date("Y-m-d");
$time = date("H:i");

$sql="UPDATE `ads` SET `status` = 1 WHERE `enddate`= '$date'";
//$sql="UPDATE `ads` SET `status` = 1 WHERE `enddate`= '$date' AND `stoptime`= '$time'";
$query=mysqli_query($dbhandle , $sql)  ;

?>
 