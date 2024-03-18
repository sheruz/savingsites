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
   <?php  ////echo 1;exit; 
	/*$a='';$b='';$c='';$d='';$e='';$f='';$g='';$h='';$i='';$j='';
	$sql = mysql_query("select * from ad_to_zone_05062015 where zoneid = 488");
	while($result = mysql_fetch_array($sql)){// print_r($result['businessid']);exit;
	$a = $result['id'];
	$b = $result['adid'];
	$c = $result['zoneid'];
	$d = $result['approval'];
	$e = $result['stickyad'];
	$f = $result['is_displayed'];
	//$g = $result['websitevisibility'];
	//$h= $result['emailvisibility'];
	//$i = $result['isverified_businessowner'];
	//$j = $result['is_duplicate'];
	echo $sql_ins="insert into ad_to_zone(id,adid,zoneid,approval,stickyad,is_displayed) values('$a','$b','$c','$d','$e','$f')"; echo '<br>';
	mysql_query($sql_ins);
	//$qr=mysql_fetch_array($query);
	}*/
	?>
    <?php 
	 /*?>$a='';$b='';$c='';$d='';$e='';$f='';$g='';$h='';$i='';$j='';$k='';$l='';$m='';$n='';$o='';$p='';$q='';$r='';$s='';$t='';
	$aa='';$bb='';$cc='';$dd='';$ee='';$ff='';$gg='';$hh='';$ii='';$jj='';$kk='';$ll='';$mm='';$nn='';$oo='';
	
	$sql = mysql_query("select a.adid as adid from ad_to_zone_05062015 a,ads_05062015 b where a.zoneid = 488 and a.adid=b.id");
	/*while($result = mysql_fetch_array($sql)){
		$a .=$result['adid'].',';
	}
	//print_r($a);exit;
	while($result = mysql_fetch_array($sql)){// print_r($result['adid']);exit;
	$adid = $result['adid'];
	$qr=mysql_query("select * from ads_05062015 where id=$adid");
	$res= mysql_fetch_array($qr);//print_r($res['adtext']);exit;
	$a = $res['id'];
	$b = mysql_real_escape_string($res['name']);
	$c = mysql_real_escape_string($res['adtext']);
	$d = $res['active'];
	$e = mysql_real_escape_string($res['startdate']);
	$f = mysql_real_escape_string($res['enddate']);
	$g = mysql_real_escape_string($res['starttime']);
	$h = mysql_real_escape_string($res['stoptime']);
	$i = $res['business_id'];
	$j = $res['category_id'];
	$k = $res['categoryid'];
	$l = $res['categoryid1'];
	$m = $res['subcategoryid'];
	$n = $res['subcategoryid1'];
	$o = mysql_real_escape_string($res['last_update']);
	$p = $res['offer_code'];
	$q = mysql_real_escape_string($res['startdatetime']);
	$r= mysql_real_escape_string($res['stopdatetime']);
	$s = mysql_real_escape_string($res['text_message']);
	$t = mysql_real_escape_string($res['docs_pdf']);
	$aa = $res['imagetype'];
	$bb = mysql_real_escape_string($res['search_engine_title']);
	$cc = mysql_real_escape_string($res['audio_file']);
	$dd = mysql_real_escape_string($res['video_file']);
	$ee = $res['foodmenu'];
	$ff = mysql_real_escape_string($res['short_description']);
	$gg = $res['number_of_deal'];
	$hh = mysql_real_escape_string($res['deal_restriction']);
	$ii = mysql_real_escape_string($res['deal_information']);
	$jj = mysql_real_escape_string($res['deal_description']);
	$kk = mysql_real_escape_string($res['deal_title']);
	$ll = mysql_real_escape_string($res['deliver']);
	$mm = $res['timestamp'];
	$nn = mysql_real_escape_string($res['textmeoffer']);
	$oo = mysql_real_escape_string($res['smarturl']);
	
	$query = mysql_query("insert into ads values('$a','$b','$c','$d','$e','$f','$g','$h','$i','$j','$k','$l','$m','$n','$o','$p','$q','$r','$s','$t','$aa','$bb','$cc','$dd','$ee','$ff','$gg','$hh','$ii','$jj','$kk','$ll','$mm','$nn','$oo')");
	//$qr=mysql_fetch_array($query);
	}
	<?php */?>
	
    
    <?php
    /*$sql1 = mysql_query("select a.adid as adid from ad_to_zone_05062015 a,ads_05062015 b where a.zoneid = 488 and a.adid=b.id");
    while($result1 = mysql_fetch_array($sql1)){
		$adid1 = $result1['adid'];
		$sql2 = mysql_query("SELECT * FROM ad_category_subcategory_05062015 WHERE zoneid = 488") ;
		if(mysql_num_rows($sql2) > 0){
			$row1 = mysql_fetch_array($sql2) ;
			$insert_sql = mysql_query("INSERT INTO ad_category_subcategory SET 
			id =".$row1['id'].",
			adid = ".$adid1.", 
			catid = ".$row1['catid'].", 
			cat_group_id = ".$row1['cat_group_id'].",
			subcatid = ".$row1['subcatid'].",
			zoneid = ".$row1['zoneid'].", 
			display_zone = ".$row1['display_zone'].", 
			imagetype = ".$row1['imagetype'] ) ;
			}
	}*/
	?>
    
    <?php
	$sql="select * from ad_category_subcategory_05062015 where zoneid=488";
	$query1=mysql_query($sql) ;
	if(!empty($query1)){
		while($row1=mysql_fetch_array($query1)){
			echo $sql_ins="INSERT INTO ad_category_subcategory(id,adid,catid,cat_group_id,subcatid,zoneid,display_zone,imagetype) VALUES ('".$row1['id']."','".$row1['adid']."','".$row1['catid']."','".$row1['cat_group_id']."','".$row1['subcatid']."','".$row1['zoneid']."','".$row1['display_zone']."','".$row1['imagetype']."')"; echo '<br>';
			mysql_query($sql_ins); 
		}
	}
	?>
    
    </div>
    <br /><button onclick="printPage()">Print this page</button>
</body>
</html>