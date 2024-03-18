<?php

### This page is created by Athena eSolutions

class Zonal_ads extends CI_Model{

	var $tables;

	var $columns;

	var $conditions;

	var $orderby;

  	public function __construct(){

        parent::__construct();

        $this->load->database();

		$this->tables='ads_product_info a,

						ads b,

						business c,

						business_category f,

						address h,

						users i,ad_to_zone j';

						

		$this->conditions='a.adid=b.id AND

						b.business_id=c.id AND

						b.category_id=f.id AND

						c.addressid=h.id AND

						i.id=c.business_owner_id AND

						b.id=j.adid AND j.approval=1';

						

		$this->columns='f.id AS subcategoryid,

						f.name AS subcategoryname,

						c.id AS businessid,

						c.name AS businessname,

						h.street_address_1 AS businessaddress1,

						h.street_address_2 AS businessaddress2,

						h.city AS businesscity,

						h.state AS businessstate,

						h.zip_code AS businesszipcode,

						h.phone AS businessphone,

						c.logo AS businesslogo,

						b.id AS adid,

						b.name AS adname,

						a.price AS adprice,

						a.isrebateavailable AS adisrebateavailable,

						a.rebate AS adrebate,

						a.istipavailable AS adistipavailable,

						a.tip AS adtip,

						b.adtext,

						b.text_message AS admessage,

						b.startdatetime AS adstarttime,

						b.stopdatetime AS adstopstime,

						b.offer_code AS adoffercode,

						i.id AS businessowenerid,

						i.first_name AS businessowener_fname,

						i.last_name AS businessowener_lname,

						i.Address AS businessoweneraddress,

						i.phone AS businessowenerphone';

						

		$this->orderby=" ORDER BY f.name ASC";				

																	

    }

	public function getAllProducts($zoneid=""){

		

		$q="SELECT ".$this->columns." FROM ".$this->tables." WHERE ".$this->conditions." AND j.zoneid=".$zoneid.$this->orderby;

		//echo $q; 		

		$r=$this->db->query($q)->result_array();

		//var_dump($r); exit;

		return $r;

	}

	

	



}



