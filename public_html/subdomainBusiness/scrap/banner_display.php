<?php 

 require_once "config.php";
if(session_status() == PHP_SESSION_NONE || !isset($_SESSION['loggedin'])){
    header("Location: https://savingssites.com/scrap");  
}
  



$query = "SELECT * FROM `sales_zone`";
 
$result = mysqli_query($dbhandle , $query);



if(mysqli_num_rows($result) > 0){		

	while($row = mysqli_fetch_array($result)){ 



		$zone_id = $row['id'];

		//echo $zone_id;

		$banner_query = "INSERT INTO `banner_display`(`banner_id`,`zone_id`,`order`,`status`)

					VALUES(890,".$zone_id.",0,1)";

		mysqli_query($banner_query);

	}

}





?>