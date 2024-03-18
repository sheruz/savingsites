<?php

$server   = "localhost";

$userName = "savingssites_new";

$password = "z9wlq2sOS8E6QU1P";

$db       = "savingssites";

/*$userName = "root";

$password = "";

$db       = "savingssites";*/

// db connection

$connection = new mysqli($server,$userName,$password,$db);



// fetch all existing zone_id



$sql = "SELECT zone_id FROM banner_display GROUP BY zone_id";



// existing zone data



$result = $connection->query($sql);



// Default Banner id Array,i,e the  banner id which should be inserted inserted into banner display table

/*$bannerIdArray = array(848,849,850,851,852,853);

$orderArray    = array(-2,-5,-3,-4,-1,0);*/

$bannerIdArray = array(849,851,850,858,848,852,853);

$orderArray    = array(-6,-5,-4,-3,-2,-1,0);



if($result->num_rows > 0) {

	while ($row = $result->fetch_assoc()) {

		$zoneId = (int)$row['zone_id'];

		$i = 0;

		foreach ($bannerIdArray as $bannerId) {

			$bannerId = (int)$bannerId;

			$sqlInsert = "INSERT INTO banner_display SET banner_id = ".$bannerId.",zone_id =".$zoneId.",`order` = ".$orderArray[$i].",status = 1";

			//echo $sqlInsert;

			$connection->query($sqlInsert);

			$i++;

			//echo $sqlInsert;



			

		}

		

	}

}

//var_dump($zoneIdArray);





?>