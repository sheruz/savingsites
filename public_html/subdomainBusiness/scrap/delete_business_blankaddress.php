<?php
session_start();
session_start();
require_once "config.php";
if(session_status() == PHP_SESSION_NONE || !isset($_SESSION['loggedin'])){
    header("Location: https://savingssites.com/scrap");  
}

$address_id = (isset($_GET['address_id']) && $_GET['address_id'] != '') ? $_GET['address_id'] : 0 ;

//echo 'Tesg fghfgh Shfgfg';
//exit;

$address_id_businesssql = mysqli_query($dbhandle , "SELECT addressid FROM business");

$arr2 = array();
while($all_addressid_frombusiness = mysqli_fetch_row($address_id_businesssql))
{
    $arr2[] = $all_addressid_frombusiness[0];
    
}

$address_id_sql = mysqli_query($dbhandle , "SELECT id FROM address");

$arr = array();

while($all_address_id = mysqli_fetch_row($address_id_sql))
{
    //$arr[] = $all_address_id[0];
    if(!in_array($all_address_id[0],$arr2))
    {
        //$delete_address_id = mysqli_query($dbhandle , "DELETE FROM address WHERE id =".$all_address_id[0]);
        echo '<br/>'; echo $all_address_id[0]; echo '<br/>';
        //echo "Delete Successfully";
    }
}
