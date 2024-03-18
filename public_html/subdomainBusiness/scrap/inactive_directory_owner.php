<html>
<head>

<style type="text/css">

.data-table {
			border-collapse: collapse;
			font-size: 14px;
			min-width: 537px;
		}
.data-table caption {
			margin: 7px;
		}
table {
			margin: auto;
			font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
			font-size: 12px;
}
.data-table th, 
		.data-table td {
			border: 1px solid #e1edff;
			padding: 7px 17px;
		}
table td {
			transition: all .5s;
		}
.data-table thead th {
			background-color: #508abb;
			color: #FFFFFF;
			border-color: #6ea1cc !important;
			text-transform: uppercase;
		}

</style>
</head>
<body>

<?php 
	# + for LOCAL connection
if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='athena9:19547'){
		$hostname = 'localhost';
		$username = 'root';
		$password = '';
		$database = 'savingssites';
	}
	# + for LOCAL connection
	# + for LIVE connection
	else{
		$hostname = 'localhost';
		$username = 'savingssites_new';
		$password = 'z9wlq2sOS8E6QU1P';
		$database ='savingssites';
	}
	# + for LIVE connection
$dbhandle = mysql_connect($hostname, $username, $password);

if($dbhandle){  
	$con=mysql_select_db($database,$dbhandle);
	if(!$con)
		echo 'Could not select the database';
	}else
		echo "Unable to connect to MySQL database";

$query = "SELECT * FROM `users` AS `us` INNER JOIN `sales_zone` AS `sz` ON `us`.`id` = `sz`.`sales_rep_id` WHERE `us`.`active` = 0 AND `us`.`status` = 1 AND `sz`.`active` = 1";
$result = mysql_query($query);
?>

<table class="data-table">
<caption class="title">List of Directory Owners</caption>
<thead>
<tr>
<th>SL No.</th>
<th>Zone Name</th>
<th>Email</th>
<th>Website Url</th>
</tr>
</thead>
<tbody>
<?php
$count = 1;
if(mysql_num_rows($result) > 0){		
	while($row = mysql_fetch_array($result)){ 
		$url = "http://savingssites.com/zone/".$row['seo_zone_name']."/";
		echo '<tr>
					<td>'.$count.'</td>
					<td>'.$row['name'].'</td>
					<td>'.$row['email'].'</td>
					<td><a target="_blank" href="'.$url.'">'.$url.'</a></td>
					
				</tr>';
		$count++;		
	}
}
?>
</tbody>
</table>
</body>
</html>
