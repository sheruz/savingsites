<?php
set_time_limit(0);
session_start();

if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='127.0.0.1'){
	$hostname = 'localhost';
	$username = 'root';
	$password = '';
	$database='savingssites';
}else{
	$hostname = 'localhost';
	$username = 'savingssites_new';
	$password = 'z9wlq2sOS8E6QU1P';
	$database='savingssites';
}
$hide = 0 ;
$dbhandle = mysql_connect($hostname, $username, $password);
if($dbhandle){  
	$con=mysql_select_db($database,$dbhandle);
	if(!$con)
		echo 'Could not select database';
}else
	echo "Unable to connect MySQL database";






//$sql="SELECT * FROM users_groups WHERE group_id IN (6,8,9,10,11,12,13,14)";
/*$sql="SELECT * FROM `users` WHERE id!=154 and id NOT IN(SELECT sales_rep_id FROM sales_zone where sales_rep_id!=0) ORDER BY `users`.`id` ASC";

$query=mysql_query($sql) ; 

while($row=mysql_fetch_array($query)){	
	
	$del1="DELETE FROM users_groups where user_id=".$row['id'];

	mysql_query($del1);
	
	$del="DELETE FROM users where id=".$row['id'];

	mysql_query($del);

}*/

		$sql = "SELECT `name` FROM `category_sub_subcategory_new` WHERE `parent_id` IN (1,2,3)";
		$query=mysql_query($sql) ; 
       
        //$query_result = mysql_fetch_array($query);
        while($row=mysql_fetch_array($query)){

        //foreach ($query_result as $row)
        //{
           $sql_ins = "INSERT INTO `restaurantbooking_food_offered` (food_name) VALUES ('".$row['name']."')";
           mysql_query($sql_ins);
        }


exit;

?>

