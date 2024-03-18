<html>

<head>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />


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
ini_set( "display_errors", 0); 
	# + for LOCAL connection
require_once "config.php";
if(session_status() == PHP_SESSION_NONE || !isset($_SESSION['loggedin'])){
    header("Location: https://savingssites.com/scrap");  
}

$cookie_name = "history_link";
$cookie_value = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
setcookie($cookie_name, $cookie_value, time()+3600, "/"); 




$query = "SELECT * FROM `users` AS `us` INNER JOIN `sales_zone` AS `sz` ON `us`.`id` = `sz`.`sales_rep_id` WHERE `us`.`active` = 1 AND `us`.`status` = 1 AND `sz`.`active` = 1";

$result = mysqli_query($dbhandle ,$query);

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

if(mysqli_num_rows($result) > 0){		

	while($row = mysqli_fetch_array($result)){ 
 $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/zone/".$row['seo_zone_name'];

		//$url = "https://savingssites.com/zone/".$row['seo_zone_name']."/";

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

