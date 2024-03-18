<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<?php
$cookie_name = "history_link";
$cookie_value = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); 


class Operation
{
	public $mysqli;
	public $userid;
    public $zoneid;
    function __construct()
    {
    session_start();
  require_once "config.php";
  if(session_status() == PHP_SESSION_NONE || !isset($_SESSION['loggedin'])){
      header("Location: https://savingssites.com/scrap");  
  }

 
      if (isset($_SESSION["zoneid"])) {
        echo "Last created zone URL <a target='_blank' href='http://savingssites.com/zone/".$_SESSION["zoneid"]."/'>savingssites.com/zone/".$_SESSION["zoneid"]."/</a> | Username: ".$_SESSION['username']." | Password: ".$_SESSION['password']." <br />Plsease change password after login to dashboard.<br />";
      }
    }

    function destroysession()
    {
    	session_destroy();
      header("Refresh:0");
    }
      function remove_element($array,$item) {
        $index = array_search($item, $array);
  if ( $index !== false ) {
    unset( $array[$index] );
  }

  return $array;
      }
    function viewzonearea()
    {
     echo '<form class="zone_form" style="text-align: center;" method="POST" action="">
	<div class="form-group"><input type="text" class="form-control" placeholder="Directory name" name="directoryname" id="directoryname"></div>
	<div class="form-group"><input type="text" class="form-control" placeholder="Frist name" name="fname" id="fname"></div>
	<div class="form-group"><input type="text" class="form-control" placeholder="Last name" name="lname" id="lname"></div>
	<div class="form-group"><input type="text" class="form-control" placeholder="Email" name="email" id="email"></div>
	<div class="form-group"><input type="text" class="form-control" placeholder="Phone" name="phone" id="phone"></div>
	<div class="form-group"><input type="text" class="form-control" placeholder="Address" name="address" id="address"></div>
	<div class="form-group"><input type="text" class="form-control" placeholder="City" name="city" id="city"></div>
	<div class="form-group"><input type="text" class="form-control" placeholder="Zip code" name="zip" id="zip"></div>
	<div class="form-group"><input type="submit" class="form-control btn btn-success" name="createzone" value="Create zone"></div>
</form>';
    }
    function viewziparea()
    {
    	echo '<form  class="zip_form" style="text-align: center;" method="POST" action="">
	<input type="text" placeholder="Zone id" name="usserid" value="'.$_SESSION["zoneid"].'">
	<input type="text" placeholder="Enter Zip code one at a time" name="zipcode" id="zipcode">
  <input type="submit" class="btn_zonezip" name="addziptozone" value="add zip to zone">
</form>';
    }
    function insertzip($opzipcode="",$type="",$primarycity="",$acceptcities="",$unacceptcities="",$state="",$county="",$timezone="",$area_codes="",$latitude="",$longitude="",$decommission="",$estpopulation="",$mode="")
    {
    	$sql_bdins = "INSERT INTO `zipcode` (`zip`,`type`,`primarycity`,`acceptcities`,`unacceptcities`,`state`,`county`,`timezone`,`area_codes`,`latitude`,`longitude`,`decommission`,`estpopulation`,`mode`)VALUES ('$opzipcode','$type','$primarycity','$acceptcities','$unacceptcities','$state','$county','$timezone','$area_codes','$latitude','$longitude','$decommission','$estpopulation','$mode');";
/*      echo $sql_bdins;
      exit;*/
    	$getid = $this->mysqli->query($dbhandle ,$sql_bdins);
    	$zipid = $this->mysqli->insert_id;
    if ($zipid>0){
    $zipstoupload= $_SESSION["zipstoupload"];
    $result = $this->remove_element($zipstoupload,$opzipcode);
    $_SESSION["zipstoupload"] =$result;    
    if (!empty($_SESSION["zipstoupload"])){
    echo "Last inerted zip: ".$opzipcode;
     $this->createzip(/*$a*/);
    }
    else{
      echo "all zip inserted..";
      $this->viewziparea();
    }
    }

    }
   function createzip(/*$zips=""*/){
    $zipstoupload= $_SESSION["zipstoupload"];
echo '<form style="text-align: center;" method="POST" action="">';
   	echo "<select name='opzipcode'>";
   	foreach ($zipstoupload as $value) {
   		echo "<option value='".$value."'>".$value."</option>";
   	}
   	echo "</select>";
    echo '<input type="text" placeholder="Type" name="type" id="type">';
    echo '<input type="text" placeholder="primarycity" name="primarycity" id="primarycity">';
    echo '<input type="text" placeholder="acceptcities" name="acceptcities" id="acceptcities">';
    echo '<input type="text" placeholder="unacceptcities" name="unacceptcities" id="unacceptcities">';
    echo '<input type="text" placeholder="state" name="state" id="state">';
    echo '<input type="text" placeholder="county" name="county" id="county">';
    echo '<input type="text" placeholder="timezone" name="timezone" id="timezone">';
    echo '<input type="text" placeholder="area_codes" name="area_codes" id="area_codes">';
    echo '<input type="text" placeholder="latitude" name="latitude" id="latitude">';
    echo '<input type="text" placeholder="longitude" name="longitude" id="longitude">';
    echo '<input type="text" placeholder="decommission" name="decommission" id="decommission">';
    echo '<input type="text" placeholder="estpopulation" name="estpopulation" id="estpopulation">';
    echo '<input type="text" placeholder="mode" name="mode" id="mode">';
    echo '<input type="submit" name="insertzip" value="insert zip">';
    echo '</form>';
    }
   function createzone($directoryname="",$fname="",$lname="",$email="",$phone="",$address="",$city="",$zip="",$password="")
    {

    	$username = strtolower($fname);
    	/*$password = sha1($password);*/
    	$seo_zone_name = str_replace(" ","-",ucfirst($directoryname));
    	//$seo_zone_name = strtolower($seo_zone_name);
    	$sql_bdins = "INSERT INTO `users` (`username`,`password`,`email`,`active`,`first_name`,`last_name`,`phone`,`Address`,`City`,`Zip`,`status`)VALUES ('$username','$password','$email','1','$fname','$lname','$phone','$address','$city','$zip','1');";
/*    	echo $sql_bdins; exit;*/
      $getid = $this->mysqli->query($sql_bdins);
    	$userid = $this->mysqli->insert_id;
    	if ($userid!=0) {
    		$sales_zone = "INSERT INTO `sales_zone` (`name`,`seo_zone_name`,`sales_rep_id`,`active`)VALUES ('$directoryname','$seo_zone_name','$userid','1');";
/*        echo $sales_zone;
        exit;*/
    		$sales_zone_insert = $this->mysqli->query($dbhandle ,$sales_zone);
    		$zoneid = $this->mysqli->insert_id;

    		$users_groups = "INSERT INTO `users_groups` (`user_id`,`group_id`)VALUES ('$userid','4');";
    		$users_groups_insert = $this->mysqli->query($dbhandle ,$users_groups);
    	}
    $_SESSION["userid"] = $userid;
		$_SESSION["zoneid"] =$zoneid;
    $_SESSION["username"] = $username;
    $_SESSION["password"] = '1qaz2wsx!@';
    header("Refresh:0");
    }
    function addziptozone($zipcode="",$zoneid="")
    {
      $response = array('status'=>0, 'message'=>'');
      try {
        $qry = "SELECT * FROM zipcode WHERE  zip  = '$zipcode';";
        $checkzip = $this->mysqli->query($dbhandle ,$qry);
        $rowcount=mysqli_num_rows($checkzip);
        if ($rowcount==0) {
         throw new Exception('This zip is not exist on our database.');
        }
        $qry = "SELECT * FROM tblClaimedZips WHERE  zip  = '$zipcode';";
        $checkzip = $this->mysqli->query($dbhandle ,$qry);
        $rowcount=mysqli_num_rows($checkzip);
        if ($rowcount!=0) {
         throw new Exception('This zip is already assigned to another user. Please contact to admin with this issue.');
        }
        $qry = "SELECT * FROM sales_zone WHERE  id  = $zoneid;";
        $checkusers = $this->mysqli->query($dbhandle ,$qry);
        $rowcount=mysqli_num_rows($checkusers);
        if ($rowcount==0) {
         throw new Exception('Zone ID is not valid.');
        }
        while ($row = $checkusers->fetch_assoc()) {
          $userid = $row['sales_rep_id'];
          $tbl_zips = "INSERT INTO `tblClaimedZips` (`zip`,`uid`,`approved`)VALUES ('$zipcode','$userid','1');";
          $tbl_zips_insert = $this->mysqli->query($dbhandle ,$tbl_zips);
          
          $zip_code_zone = "INSERT INTO `zip_code_zone` (`zip_code`,`zone_id`,`latitude`,`longitude`)VALUES ('$zipcode','$zoneid',0,0);";
          $zip_code_zone_insert = $this->mysqli->query($dbhandle ,$zip_code_zone);
          
          $response['status'] = 1;
          $response['message'] = 'Zip inserted sucessfully';
        }
      } catch (Exception $e) {
          $response['message'] = $e->getMessage();
      }
		  return $response;
    }

function createnewzip($zoneid,$zipcode){
  echo $zipcode."<br/>";
  $getid = "SELECT * FROM tblClaimedZips WHERE  zip  = '$zipcode';";
  $getuserid = $this->mysqli->query($dbhandle ,$getid);
  $rowwcount=mysqli_num_rows($getuserid);
  echo $rowwcount."<br/>";
  if ($rowwcount==0){
      $getid = "SELECT * FROM sales_zone WHERE  zip  = '$zipcode';";
      $getuserid = $this->mysqli->query($dbhandle ,$getid);
  }
}
} 
?>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<link rel="stylesheet" href="https://savingssites.com/assets/scrap/css/custom-scrap.css">
<script>
</script>
<!DOCTYPE html>
<html>
<body>
<div class="zone_row">
<div class="container">
  <div class="craete_zone_col">
<!-- <a style="float:right" href="<?php echo strtok($_SERVER["REQUEST_URI"],'?'); ?>">Home</a> -->
<?php
$Operationobj = new Operation;
if(isset($_REQUEST['destroy']))
{
	$Operationobj->destroysession();
}
if(isset($_REQUEST['viewzone']))
{
	$Operationobj->viewzonearea();
}
if(isset($_REQUEST['viewzip']))
{
	$Operationobj->viewziparea();
}
if(isset($_REQUEST['createzone']))
{
  $directoryname = isset($_REQUEST['directoryname']) ? $_REQUEST['directoryname'] : '';
  $fname 		 = isset($_REQUEST['fname']) ? $_REQUEST['fname'] : '';
  $lname 		 = isset($_REQUEST['lname']) ? $_REQUEST['lname'] : '';
  $email 		 = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
  $phone 		 = isset($_REQUEST['phone']) ? $_REQUEST['phone'] : '';
  $address 		 = isset($_REQUEST['address']) ? $_REQUEST['address'] : '';
  $city 		 = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';
  $zip 			 = isset($_REQUEST['zip']) ? (int)$_REQUEST['zip'] : 0;
  $password		 = isset($_REQUEST['password']) ? $_REQUEST['password'] : '708930d2ffce09d17fadce17ababdd29bf477004';
  if ($fname=='' || $lname=='' || $email=='' || $zip==0|| strlen($zip)!=5) {
    echo "Please provide correct all data";
  }else{
    $Operationobj->createzone($directoryname,$fname,$lname,$email,$phone,$address,$city,$zip,$password);
  }
}
if(isset($_REQUEST['addziptozone']))
{
$usserid = isset($_REQUEST['usserid']) ? (int)$_REQUEST['usserid'] : 0;
$zipcode = isset($_REQUEST['zipcode']) ? (int)$_REQUEST['zipcode'] : 0;
if ($usserid==0 || $zipcode==0 || strlen($zipcode)!=5) {
  echo "Enter valid zipcode or zoneid.";
}
else{
  $response = $Operationobj->addziptozone($zipcode,$usserid);
  echo $response['message'];
}
}
if(isset($_REQUEST['insertzip']))
{
  $opzipcode		  =	(strlen($_REQUEST['opzipcode'])!=0) ? $_REQUEST['opzipcode'] : '';
  $type 		  = (strlen($_REQUEST['type'])!=0) ? $_REQUEST['type'] : 'STD';
  $primarycity 	  = (strlen($_REQUEST['primarycity'])!=0) ? $_REQUEST['primarycity'] : '';
  $acceptcities   = (strlen($_REQUEST['acceptcities'])!=0) ? $_REQUEST['acceptcities'] : '';
  $unacceptcities = (strlen($_REQUEST['unacceptcities'])!=0) ? $_REQUEST['unacceptcities'] : '';
  $state 		  = (strlen($_REQUEST['state'])!=0) ? $_REQUEST['state'] : '';
  $county 		  = (strlen($_REQUEST['county'])!=0) ? $_REQUEST['county'] : 'null';
  $timezone 	  = (strlen($_REQUEST['timezone'])!=0) ? $_REQUEST['timezone'] : '';
  $area_codes 	  = isset($_REQUEST['area_codes']) ? strlen($_REQUEST['area_codes'])==0 ? '0' : $_REQUEST['area_codes'] : '';
  $latitude		  = isset($_REQUEST['latitude']) ? strlen($_REQUEST['latitude'])==0 ? '0' : $_REQUEST['latitude'] : '0';
  $longitude 	  = isset($_REQUEST['longitude']) ? strlen($_REQUEST['longitude'])==0 ? '0' : $_REQUEST['longitude'] : '0';
  $decommission   = isset($_REQUEST['decommission']) ? strlen($_REQUEST['decommission'])==0 ? '0' : $_REQUEST['decommission'] : '0';
  $estpopulation  = isset($_REQUEST['estpopulation']) ? strlen($_REQUEST['estpopulation'])==0 ? '0' : $_REQUEST['estpopulation'] : '0';
  $mode 		  = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : '';

  $Operationobj->insertzip($opzipcode,$type,$primarycity,$acceptcities,$unacceptcities,$state,$county,$timezone,$area_codes,$latitude,$longitude,$decommission,$estpopulation,$mode);
}
?>
<!-- <div class="border-top my-3"></div> -->
<div class="border-0 border-primary row">
<div class="col-sm-6">
<form style="text-align: left;" method="POST" action="">
  <input type="submit" class="btn btn-primary" name="viewzone" value="Add zone">
</form>
</div>
<div class="col-sm-6">
<form style="text-align: right;" method="POST" action="">
  <input type="submit" class="btn btn-primary" name="viewzip" value="Add zip">
</form>
</div>
<div class="msg-box"></div>
</div>
</div>
</div>
</div>
</body>
</html>
