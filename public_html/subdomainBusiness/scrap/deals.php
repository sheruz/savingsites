<?php
session_start();
require_once "config.php";

$cookie_name = "history_link";
$cookie_value = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
setcookie($cookie_name, $cookie_value, time()+3600, "/"); 


if(session_status() == PHP_SESSION_NONE || !isset($_SESSION['loggedin'])){
    header("Location: https://savingssites.com/scrap");  
}
 
?>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<style>
table.zone_login_data{ margin:0 auto; width:80%;}
table.zone_login_data tr{ width:100%;}
table.zone_login_data tr td{ width:20%; padding:7px;}
#DataTables_Table_0_filter{
  margin-bottom: 13px;
  margin-top: 28px;
  padding-right: 132px;
}
.dataTables_length{
      margin-bottom: 13px;
    margin-top: 28px;
        padding-left: 132px;
}
.dataTables_wrapper{    margin-bottom: 50px;}

</style>
<h1 style="text-align: center;    margin-bottom: 0;    margin-top: 46px;">All Deals </h1>

<table border="1" class="zone_login_data">
  <thead>
  <tr style=" text-align:center; font-size:18px; font-weight:bold;">
  	<td>Serial No.</td>
    <td>AddId</td>
    <td>BusinessId</td>
    <td>Dealtitle</td>
    
  </tr>
  </thead>
<?
$zoneid = $_GET['zoneid'];
$i=0;
$sql="SELECT a.id,a.business_id,a.deal_title FROM ads_setting_preferences asp LEFT JOIN ads a ON asp.businessid = a.business_id WHERE asp.settingszoneid =".$zoneid;
 

$query = mysqli_query($dbhandle ,$sql);
while($row=mysqli_fetch_array($query)){ $i++;
 
?>
   <tr>
  	<td><?php echo $i?></td>
  	<td><?php echo $row['id'];?></td>
  	<td><?php echo $row['business_id'];?></td>
    <td><?php echo $row['deal_title'];?></td>    
  </tr>
 

<?
}
?>
</table>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
  $(document).ready( function () {
    $('.zone_login_data').DataTable();
} );
</script>