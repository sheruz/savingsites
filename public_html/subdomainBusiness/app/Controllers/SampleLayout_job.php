<?php 

### This page is modified by Athena eSolutions

if (!defined('BASEPATH')) exit('No direct script access allowed');

class SampleLayout_job extends CI_Controller{

	var $arr_product;

	var $arr_category;

	var $arr_subcategory;

	var $arr_business;

	var $arr_ad;

	var $arr_randomnum_product;

    public function __construct()

    {
        $this->load->model("admin/Business_type_model", "business_type");
        parent::__construct();

       /* $this->load->library('session');*/

        $this->load->helper('url');

        $this->load->helper("time_helper");

       /* $this->load->model("admin/Category_model", "category");

        $this->load->model("admin/Announcement_model", "announcements");

        $this->load->model("admin/Ads_model", "ads");

        $this->load->model("admin/Sales_zone", "sales_zone");

		$this->load->model("States", "states");

		$this->load->model("admin/Business", "business");

		$this->load->model("admin/Ads_model", "ad");

		$this->load->model("admin/Business_type_model", "business_type");*/

		$this->load->model("Samplelayoutmodel","obj_samplelayoutmodel"); // Added Athena eSolutions

        $this->load->database();

    }



    public function index(/*$zone = false*/){

        /*$zoneId = empty($_REQUEST['zone']) ? 0 : $_REQUEST['zone'];



        $data = array();

        if(!empty($zone))

        {

            $zoneId = $zone;

        }*/

		$this->arr_product=$this->obj_samplelayoutmodel->getAllProducts();

       	foreach($this->arr_product as $val){

			$this->arr_category[]=array('categoryid'=>$val['categoryid'],'categoryname'=>$val['categoryname']);

			$this->arr_subcategory[]=array('categoryid'=>$val['categoryid'],'subcategoryid'=>$val['subcategoryid'],'subcategoryname'=>$val['subcategoryname']);

			$this->arr_business[]=array('categoryid'=>$val['categoryid'],'subcategoryid'=>$val['subcategoryid'],'businessid'=>$val['businessid'],'businessname'=>$val['businessname'],'businessaddress1'=>$val['businessaddress1'],'businessaddress2'=>$val['businessaddress2'],'businesscity'=>$val['businesscity'],'businessstate'=>$val['businessstate'],'businesszipcode'=>$val['businesszipcode'],'businessphone'=>$val['businessphone'],'businesslogo'=>$val['businesslogo']);

			$this->arr_ad[]=array('categoryid'=>$val['categoryid'],'subcategoryid'=>$val['subcategoryid'],'subcategoryname'=>$val['subcategoryname'],'businessid'=>$val['businessid'],'adid'=>$val['adid'],'adname'=>$val['adname'],'adtext'=>$val['adtext'],'admessage'=>$val['admessage'],'businessowenerid'=>$val['businessowenerid'],'businessowener_fname'=>$val['businessowener_fname'],'businessowener_lname'=>$val['businessowener_lname'],'businessoweneraddress'=>$val['businessoweneraddress'],'dw_email'=>$val['dw_email'],'dw_phone'=>$val['dw_phone']);

		}

        $this->load->view('sampleLayout_job');

    }

}



class Category

{

    var $id;

    var $categoryName;

    var $ads;

    var $biz_type_id;

    var $biz_type_name;

}