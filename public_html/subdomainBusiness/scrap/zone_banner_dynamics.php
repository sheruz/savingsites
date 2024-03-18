<?php
session_start();
$hostname = 'localhost';
$username = 'savingssites_new';
$password = 'z9wlq2sOS8E6QU1P';
$database='savingssites';   
/*$hostname = 'localhost';
$username = 'root';
$password = '';
$database='savingssites';*/
$hide = 0 ;
$dbhandle = mysql_connect($hostname, $username, $password);
if($dbhandle){  
	$con=mysql_select_db($database,$dbhandle);
	if(!$con)
		echo 'Could not select database';
}else
	echo "Unable to connect MySQL database";
?>

<form method="post" action="">
	<table>
		<tr><td>Zone Id:-</td><td><input type="text" name="zone_id"></td></tr>
		<tr><td>Viewable At:-</td><td><input type="text" name="viewable_at"> (1- Directory page 2- Business search page Submit twice with each value)</td></tr>
		<tr><td><input type="submit" name="update_banner_display"></td><tr>
	</table>
</form>

<?php
$arr = array();
/*if($_POST){
	$userid=$_POST['userid'];
	$username=$_POST['username'];
	$sql_1="select a.id,a.name,a.sales_rep_id,b.status,b.last_name as lastname, b.first_name as firstname from sales_zone a,users b where a.sales_rep_id=b.id and a.sales_rep_id=".$userid." limit 0,1";
	$query_1=mysql_query($sql_1);
	$row1=mysql_fetch_array($query_1);
	$zoneid=$row1['id'];
	$zonename=$row1['name'];
	header('location:../auth/check_athena_login/'.$userid.'/'.$zoneid.'/'.$zonename); 
}*/
if($_POST)
{
	$get_all_lists = array('849','851','850','858','848','852','853','870',
	'871','872','873','874','875','878');
	
	$zone_id = $_POST['zone_id'];
	$viewable_at = $_POST['viewable_at'];

	$sql_1="select * from banner_display where zone_id='$zone_id' and
	 viewable_at='$viewable_at' and
	 device_type!='0'";
	 
	$query_1=mysql_query($sql_1);
	//$row1=mysql_fetch_array($query_1);

	$sql_bd="select * from banner_display where zone_id='$zone_id'";
	$query_bd=mysql_query($sql_bd);
	$num_row_bd = mysql_num_rows($query_bd);
	

	while($row1 = mysql_fetch_assoc($query_1))
	{
		
		$arr[]=$row1['banner_id'];
		//echo"<pre>";
		//print_r($row1);
		
		
	}
	
	foreach($get_all_lists as $get_all_list)
		{
			if(!in_array($get_all_list,$arr))
			{
				$count = 1;
				for($i=1;$i<=2;$i++)
				{
					//$all_banner_id[] = $get_all_list;
					$sql_bdins = "INSERT INTO `banner_display` (`banner_id`,`zone_id`,`order`,`status`,`view`,`viewable_at`,`device_type`)
					VALUES ($get_all_list,$zone_id,$num_row_bd,'1','0',$viewable_at,$i);";
					
					$query_bdins = mysql_query($sql_bdins);
					$num_row_bd++;
					//echo $query_bdins;
					$count++;
				}
			}
		}
		//echo $query_bdins;
	if($query_bdins > 0)
	{
		echo"Added in banner table";
	}
		
	/*$get_all_lists = array('849','851','850','858','848','852','853','870',
	'871','872','873','874','875','878','890');


	foreach($get_all_lists as $get_all_list)
	{
		$sql = "INSERT into banner_display (banner_id,zone_id,order,status,view,viewable_at)
		VALUES ($get_all_list,$zone_id,$get_order,'1','0','');";
	}*/
}
?>