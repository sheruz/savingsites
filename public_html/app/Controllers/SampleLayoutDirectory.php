<?php 

### This page is modified by Athena eSolutions

if (!defined('BASEPATH')) exit('No direct script access allowed');

class SampleLayoutDirectory extends CI_Controller{

	var $arr_product;

	var $arr_category;

	var $arr_subcategory;

	var $arr_business;

	var $arr_ad;

	var $arr_randomnum_product;

    public function __construct()

    {
("admin/Business", "business");
        parent::__construct();

       /* $this->load->library('session');*/

        $this->load->helper('url');

        $this->load->helper("time_helper");

		$this->load->library('ion_auth');

		$this->load->library('session');

       /* $this->load->model("admin/Category_model", "category");

        $this->load->model("admin/Announcement_model", "announcements");

        $this->load->model("admin/Ads_model", "ads");

        $this->load->model("admin/Sales_zone", "sales_zone");

		$this->load->model("States", "states");

		$this->load->model("admin/Business", "business");

		$this->load->model("admin/Ads_model", "ad");*/

		$this->load->model("Zips", "zip");

		$this->load->model("admin/Category_management_model", "category_model");

		$this->load->model("Samplelayoutmodel","obj_samplelayoutmodel"); // Added Athena eSolutions

        $this->load->database();

    }



    public function index(/*$zone = false*/){

		/*$user = $this->ion_auth->user()->row(); // add 29.01.2013

		//var_dump($user);

		$data['user']=$user;

		$data["user_id"] = $user->user_id;

		if($auser->first_name!=''){

		$data["firstName"] = $user->first_name;

		}else{

			$data["firstName"] = $user->username;

		}*/

		

		

		$theme_cookie_value=''; $zoneid_cookie_value='';

		$theme_cookie_value=$this->input->cookie('theme', TRUE);

		$zoneid_cookie_value=$this->input->cookie('zoneid', TRUE);

		//var_dump($theme_cookie_value);

		

		if($theme_cookie_value != '' ){ //var_dump(1); exit;

			if($theme_cookie_value=='DT'){

				$data['css_value']="assets/stylesheets/up_styles.css";

				$data['css_vertical_value']="assets/stylesheets/up_vertical_menu.css";

				$data['css_value_for_blue']="";

				$data['barter_button']='green'; $data['job_button']='green';

			}else if($theme_cookie_value=='MT'){

				$data['css_value']="assets/stylesheets/styles_maroon_skin.css";

				$data['css_vertical_value']="assets/stylesheets/maroon_vertical_menu.css";

				$data['css_value_for_blue']="";

				$data['barter_button']='red'; $data['job_button']='red';

			}else if($theme_cookie_value=='BT'){

				$data['css_value']="assets/stylesheets/up_styles_blue.css";

				$data['css_value_for_blue']="assets/stylesheets/styles_blue_skin.css";

				$data['css_vertical_value']="assets/stylesheets/blue_vertical_menu.css";

				$data['barter_button']='blue'; $data['job_button']='blue';

			}

			

		}

		$data['theme_cookie_value']=$theme_cookie_value;

		

		

		

		

		

		

		

		

		

		

		

		

		$data['category_list_food'] = $this->category_model->get_category_subcategory_food_sample_layout();

		$data['category_list'] = $this->category_model->get_category_subcategory_sample_layout();

		//var_dump($data['category_list']);

		

		$this->arr_product=$this->obj_samplelayoutmodel->getAllProducts(); //var_dump($this->arr_product);

       	foreach($this->arr_product as $val){

			$this->arr_category[]=array('categoryid'=>$val['categoryid'],'categoryname'=>$val['categoryname']);

			$this->arr_subcategory[]=array('categoryid'=>$val['categoryid'],'subcategoryid'=>$val['subcategoryid'],'subcategoryname'=>$val['subcategoryname']);

			$this->arr_business[]=array('categoryid'=>$val['categoryid'],'subcategoryid'=>$val['subcategoryid'],'businessid'=>$val['businessid'],'businessname'=>$val['businessname'],'businessaddress1'=>$val['businessaddress1'],'businessaddress2'=>$val['businessaddress2'],'businesscity'=>$val['businesscity'],'businessstate'=>$val['businessstate'],'businesszipcode'=>$val['businesszipcode'],'businessphone'=>$val['businessphone'],'businesslogo'=>$val['businesslogo']);

			$this->arr_ad[]=array('categoryid'=>$val['categoryid'],'subcategoryid'=>$val['subcategoryid'],'subcategoryname'=>$val['subcategoryname'],'businessid'=>$val['businessid'],'adid'=>$val['adid'],'adname'=>$val['adname'],'adtext'=>$val['adtext'],'admessage'=>$val['admessage'],'businessowenerid'=>$val['businessowenerid'],'businessowener_fname'=>$val['businessowener_fname'],'businessowener_lname'=>$val['businessowener_lname'],'businessoweneraddress'=>$val['businessoweneraddress'],'dw_email'=>$val['dw_email'],'dw_phone'=>$val['dw_phone']);

		}

		

        $this->load->view('SampleLayoutDirectory',$data);

    }

	

	

	function change_theme(){

		//$zoneid=$_REQUEST['zoneid'];

		$themeid=$_REQUEST['themeid'];

		//var_dump($themeid); exit;

		if (!get_cookie('')) {

			// cookie not set, first visit



			// create cookie to avoid hitting this case again

			$cookie = array(

				'name'   => 'theme',

				'value'  => $themeid,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			/*$cookie = array(

				'name'   => 'zoneid',

				'value'  => $zoneid,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);*/

			set_cookie($cookie);

			

			/*$cookie = array(

				'name'   => 'zoneid',

				'value'  => $zoneid,

				'expire' => time()+86500,

				'domain' => '',

				'path'   => '/',

				'prefix' => '',

			);

			set_cookie($cookie);*/

			

			//var_dump($_COOKIE);

		} 

		$result = 1;

		//echo($this->dr->GetDR("","", $result, "0"));

		echo $result;

	}

	

	function zip_to_zone(){

		$zip =(!empty($_REQUEST['zip']))? $_REQUEST['zip'] : "";

		$zone = $this->zip->zip_to_zone($zip);

		if(!empty($zone)){

			$_zone_id=$zone[0]['id'];

		}else{

			$_zone_id=0;

		}

		echo $_zone_id;

	}

}



