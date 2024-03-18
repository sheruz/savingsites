<?php
session_start();
require_once "config.php";
if(!isset($_SESSION['loggedin'])){
    header("Location: https://savingssites.com/scrap");  
}

 
$cookie_name = "history_link";
$cookie_value = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
setcookie($cookie_name, $cookie_value, time()+3600, "/"); 

  
if($_POST){
	$userid=$_POST['userid'];
	$username=$_POST['username'];
	$sql_1="select a.id,a.name,a.sales_rep_id,b.status,b.last_name as lastname, b.first_name as firstname from sales_zone a,users b where a.sales_rep_id=b.id and a.sales_rep_id=".$userid." limit 0,1";
	$query_1=mysqli_query($dbhandle , $sql_1);
	$row1=mysqli_fetch_array($query_1);
	$zoneid=$row1['id'];
	$zonename=$row1['name'];
	header('location:../auth/check_athena_login/'.$userid.'/'.$zoneid.'/'.$zonename); 
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
  padding-right: 34px;
}
.dataTables_length{
      margin-bottom: 13px;
    margin-top: 28px;
        padding-left: 36px;
}
.dataTables_wrapper{    margin-bottom: 50px;}
</style>
<!-- <caption style="font-size:24px; font-weight:normal; margin:20px 0; text-decoration:underline;">Savingssites Zone Login</caption> -->
<h1 style="text-align: center;    margin-bottom: 0;    margin-top: 46px;">All Directories / Users </h1>

<table border="1" class="zone_login_data">
   <thead>
  <tr style="  text-align:center; font-size:18px; font-weight:bold;">
  	<td>Id</td>
    <td>ZoneId</td>
    <td>Zonename</td>
    <td>Username</td>
    <td>Email</td>
    <td>First Name</td>
    <td>Last Name</td>
    <td>User Id</td>
    <td>Link</td>
    <td>Action</td>   
  </tr>
</thead>
<?
$i=0;
$sql="select   a.seo_zone_name , a.id as zoneid, b.last_name, a.name,b.id,b.username,b.email,b.first_name,b.last_name from sales_zone a,users b where a.sales_rep_id=b.id and b.username!='' group by a.sales_rep_id order by a.id asc";
//$sql="select a.id as zoneid, b.last_name, a.name,b.id,b.username,b.email,b.first_name,b.last_name from sales_zone a,users b where a.sales_rep_id=b.id and a.id= 577 group by a.sales_rep_id order by a.id asc";
$query=mysqli_query($dbhandle , $sql);
while($row=mysqli_fetch_array($query)){ $i++;
 
 $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/zone/".$row['seo_zone_name'];
   // $url = "http://savingssites.com/zone/".$row['seo_zone_name']."/";
?>
 
  <tr>
  	<td><?php echo $i?></td>
  	<td><?php echo $row['zoneid'];?></td>
  	<td><?php echo $row['name'];?></td>
    <td><input type="hidden" name="username" value="<?php echo $row['username'];?>"/><?php echo $row['username'];?></td>
    <td><?php echo $row['email'];?></td>
    <td><?php echo $row['first_name'];?></td>
    <td><?php echo $row['last_name'];?></td>
    <td><?php echo $row['id']?></td>  
    <td><a target="_blank" href="<?php echo $url; ?>"><?php echo $url ?></a></td>  
    <td style="text-align:center;"> <form name="" id="" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> <input type="hidden" name="userid" value="<?php echo $row['id'];?>"/><input type="submit" name="submit" value="Login" />  </form></td>
    
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