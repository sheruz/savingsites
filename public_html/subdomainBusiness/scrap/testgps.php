<?php

if(isset($_POST) && !empty($_POST)){
		$lattitude = $_POST['lattitude']; 
		$longitude = $_POST['longitude'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lattitude,$longitude&sensor=true");
		/*curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);*/
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0); 
	    curl_setopt($ch, CURLOPT_TIMEOUT, 4000);
		$data = curl_exec($ch);
		curl_close($ch);
	
		echo '<pre>'; var_dump($data);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form method="post">
Lat <input type="text" name="lattitude" value="41.3947" />
Long <input type="text" name="longitude" value="73.4544" />
<input type="submit" value="Submit" />
</form>
</body>
</html>
