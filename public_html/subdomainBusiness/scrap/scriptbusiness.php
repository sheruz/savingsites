<?php

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



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script>

function printPage() {

    window.print();

}

</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Business Script</title>

</head>



<body>

	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

	Please Enter Zone Id <input type="text" name="zoneid" id="zoneid" />

    <input type="submit" name="getbusiness" value="getbusiness" />

    </form>

    <div id="result">

    <?php   

	if(isset($_POST['getbusiness']) && $_POST['getbusiness'] != ''){

		$zoneid = (isset($_POST['zoneid']) && $_POST['zoneid'] != '') ? $_POST['zoneid'] : 0 ;

		$zone_owner = mysql_query("SELECT sales_rep_id FROM sales_zone WHERE id='".$zoneid."'") ;

			if(mysql_num_rows($zone_owner) > 0){

				$zone_row = mysql_fetch_array($zone_owner) ;		

			}

		$zone_userid = (isset($zone_row['sales_rep_id']) && $zone_row['sales_rep_id'] != '' ) ? $zone_row['sales_rep_id'] : 'Not Found' ;			

		echo 'Zone Owner Id: '.$zone_userid.'<br/>'; 

		

		if($zoneid != 0 && $zone_userid != 'Not Found'){

			mysql_query("SET SESSION group_concat_max_len=10000000000000") ;

			$business_query = mysql_query("SELECT SUBSTRING_INDEX(GROUP_CONCAT(businessid), ',', 500) as businessid FROM ads_setting_preferences WHERE settingszoneid = ".$zoneid." limit 0,6") ;

			if(mysql_num_rows($business_query) > 0){ //var_dump(mysql_fetch_array($business_query));exit;//var_dump(mysql_fetch_array($business_query)); exit;

				while($business_row = mysql_fetch_array($business_query)){//var_dump($business_row); exit;

					if($business_row['businessid'] != NULL && $business_row['businessid'] != ''){

						$allbusinessid = $business_row['businessid'] ; //var_dump($allbusinessid);exit;

						// Business Owner details

						$select_business_owner=mysql_fetch_array(mysql_query("SELECT GROUP_CONCAT(a.addressid) as addressid, GROUP_CONCAT(a.business_owner_id) as businessownerid from business a, ads_setting_preferences b where a.id=b.businessid and a.id IN(".$allbusinessid.") and  b.settingszoneid IN(".$zoneid.") AND a.business_owner_id NOT IN(".$zone_userid.") LIMIT 4 ")) ; 

						

						$businessownerid = $select_business_owner['businessownerid'] ; 

						$addressid = $select_business_owner['addressid'] ;

						$select_ads = mysql_query("SELECT GROUP_CONCAT(id) as adid FROM ads WHERE business_id IN(".$allbusinessid.") LIMIT 4 ") ;

						if(mysql_num_rows($select_ads) > 0){

							$ads_row = mysql_fetch_array($select_ads) ; 

							$allads = $ads_row['adid'] ; //var_dump($allads);exit;

						}else{

							$allads = '' ;

						}

						echo '<br/>Business Id: Total('.count(explode(',',$allbusinessid)).') <br/><textarea cols="160" rows="10" style="overflow:auto" onclick="this.select()" readonly="readonly">'.$allbusinessid.'</textarea>' ;

						echo '<br/>Business Owner Id: Total('.count(explode(',',$businessownerid)).') <br/><textarea cols="160" rows="10" style="overflow:auto" onclick="this.select()" readonly="readonly">'.$businessownerid.'</textarea>' ;

						echo '<br/>Business Owner\'s Address Id: Total('.count(explode(',',$addressid)).') <br/><textarea cols="160" rows="10" style="overflow:auto" onclick="this.select()" readonly="readonly">'.$addressid.'</textarea>' ;

						if($allads != ''){

							echo '<br/>Business ads: Total('.count(explode(',',$allads)).') <br/><textarea cols="160" rows="10" style="overflow:auto" onclick="this.select()" readonly="readonly">'.$allads.'</textarea>' ;

						}

						echo '<br/><form method="post" action="'.$_SERVER['PHP_SELF'].'">Want to delete business click here 

						<input type="hidden" name="allbusinessid" value="'.$allbusinessid.'" />

						<input type="hidden" name="businessownerid" value="'.$businessownerid.'" />

						<input type="hidden" name="addressid" value="'.$addressid.'" />

						<input type="hidden" name="allads" value="'.$allads.'" />

						<input type="hidden" name="zoneid" value="'.$zoneid.'" />

						<input type="submit" name="delbusiness" value="Delete Business" />

						</form><button onclick=window.location="scriptbusiness.php";>Don\'t Delete</button>' ;

					}else{

						echo 'NOTHING LEFT TO DELETE';

					}

				}

			}else{

				echo 'NO BUSINESS FOUND';

			}

		}else{

			echo 'No ID GIVEN' ;

		}

	}else if(isset($_POST['delbusiness']) && $_POST['delbusiness'] != ''){

		if(isset($_POST['allbusinessid']) && $_POST['allbusinessid'] != '' && isset($_POST['businessownerid']) && $_POST['businessownerid'] != '' && isset($_POST['addressid']) && $_POST['addressid'] != '' && isset($_POST['allads']) && $_POST['allads'] != '' && isset($_POST['zoneid']) && $_POST['zoneid'] != ''){

			$zoneid = $_POST['zoneid'] ;

			$allbusinessid = $_POST['allbusinessid'] ;

			$businessownerid = $_POST['businessownerid'] ;

			$addressid = $_POST['addressid'] ;

			$allads = $_POST['allads'] ;

			if($allads != ''){

				// Delete ad_to_zone

				$delete_adtozone = mysql_query("DELETE FROM ad_to_zone WHERE adid IN (".$allads.")"); 

				// Delete ad_category_subcategory

				$delete_ad_cat_subcat = mysql_query("DELETE FROM  ad_category_subcategory WHERE adid IN (".$allads.") and zoneid IN(".$zoneid.")");

				// Delete users_favorites

				$delete_adtofav = mysql_query("DELETE FROM users_favorites WHERE adid IN(".$allads.")") ;

				// Delete Ads

				$delete_ads = mysql_query("DELETE FROM ads WHERE id IN(".$allads.")") ;

			}

			// Delete users_groups

			$delete_user_group = mysql_query("DELETE FROM users_groups WHERE user_id IN(".$businessownerid.")") ;

			// Delete users

			$delete_users = mysql_query("DELETE FROM users WHERE id IN(".$businessownerid.")") ;

			// Delete Address

			$delete_address = mysql_query("DELETE FROM address WHERE id IN(".$addressid.")") ; 

			// Delete business_photos

			$delete_bus_image = mysql_query("DELETE FROM business_photos WHERE bus_id IN(".$allbusinessid.")") ;

			//// Delete businessphotos_display

			$delete_bus_image_display = mysql_query("DELETE FROM businessphotos_display WHERE bus_id IN(".$allbusinessid.")" ) ;

			// Delete business_operation_hour

			$delete_operation_hour = mysql_query("DELETE FROM business_operation_hour WHERE business_id IN (".$allbusinessid.") and zone_id IN(".$zoneid.")") ;

			

			// Delete business

			$delete_business = mysql_query("DELETE FROM business WHERE id IN(".$allbusinessid.")") ;

			// Delete ads_setting_preferences

			$delete_ads_setting = mysql_query("DELETE FROM ads_setting_preferences WHERE businessid IN(".$allbusinessid.")") ; 

			echo 'Delete Successful' ; 

			//echo 'Delete Code Currently Commented.' ;

		}

	}

	

	?>

    </div>

    <br /><button onclick="printPage()">Print this page</button>

</body>

</html>