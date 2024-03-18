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
mysql_query("SET SESSION group_concat_max_len=10000000000000") ;	
$sel_address = mysql_fetch_array(mysql_query("SELECT GROUP_CONCAT(id) as addressid FROM address WHERE id NOT IN(SELECT addressid FROM business) and state = 'NM' ")) ;	

$del_address = mysql_query("DELETE FROM address WHERE id IN(".$sel_address['addressid'].")") or die(mysql_error()) ; 
if($del_address && mysql_affected_rows() > 0){
	echo 'Delete Successful - Total '.mysql_affected_rows().' rows deleted<br>';
	echo 'They are - '.$sel_address['addressid'].'<br>' ; 
}
?>
<button onclick="myFunction()">Print this page</button>

<script>
function myFunction() {
    window.print();
}
</script>