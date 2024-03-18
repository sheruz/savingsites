<?php

class Business_exporter extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

        $this->load->database();

    }

	function get_business_export($zoneid=false,$business_type=false,$business_kind=false){

		/*$sql="select name from sales_zone where id=$zoneid";

		$query=mysql_query($sql);

		$row=mysql_fetch_array($query);*/

		//var_dump($zoneid);

		$csvheader=array(

			array('Business Name','Business Email','SIC Code','Contact First Name','Contact Last Name','Contact Full Name','Business Website','Address','Address1','City','State','Postal Code','Phone')

		);

		$file='file123.csv';

		$fp = fopen($file, 'w');

		foreach ($csvheader as $fields) {

			fputcsv($fp, $fields);

		}

		

		$sql="select b.name as business_name,b.contactemail as business_email,b.siccode,b.contactfirstname,b.contactlastname,b.contactfullname,b.website,c.street_address_1,c.street_address_2,c.city,c.state,c.zip_code,c.phone 

from ads_setting_preferences a,business b,address c where a.businessid=b.id and b.addressid=c.id and a.settingszoneid=".$zoneid;

$query=mysql_query($sql);



while($row=mysql_fetch_array($query)){

	fputcsv($fp,array(stripcslashes($row['business_name']),$row['business_email'],$row['siccode'],$row['contactfirstname'],$row['contactlastname'],$row['contactfullname'],$row['website'],$row['street_address_1'],$row['street_address_2'],$row['city'],$row['state'],$row['zip_code'],$row['phone']));

}

		fclose($fp);

		

		return $file;

		

		/*$name=$file;

		$data=file_get_contents($name);

		force_download($name, $data); */

		

		/*if (file_exists($file)) {

			header('Content-Description: File Transfer');

			header('Content-Type: text/csv');

			header('Content-Disposition: attachment; filename='.basename($file));

			header('Content-Transfer-Encoding: binary');

			header('Expires: 0');

			header('Cache-Control: must-revalidate');

			header('Pragma: public');

			header('Content-Length: ' . filesize($file));

			ob_clean();

			flush();

			readfile($file);

			exit;

		}*/

		

	}

}

?>