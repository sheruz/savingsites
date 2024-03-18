<?php



set_time_limit(0);



class Category_management extends CI_Controller {







    function __construct()



    {

    	die;
	
        parent::__construct();



        $this->load->library('ion_auth');



        $this->load->library('session');



        $this->load->library('form_validation');



        $this->load->helper('url');



        $this->load->model("admin/Category_model", "category");



        $this->load->model("Dialog_result", "dr");



        $this->load->database();



        $this->load->helper("time_helper");



        $this->load->model("admin/Users", "users");



        //$this->load->model("admin/Business_type_model", "business_type");



		$this->load->model("admin/Category_management_model", "category_management");



        $this->load->model("admin/Sales_rep", "sales_reps");



        $this->load->model("admin/Business", "business");



        $this->load->model("admin/Ads_model", "ads");



        $this->load->model("admin/Sales_zone", "sales_zone");



        $this->load->config('security', TRUE);



   



        $this->tierI = $this->config->item('Tier_I');



        $this->tierII = $this->config->item('Tier_II');



        $this->tierIII = $this->config->item('Tier_III');



   



    }



   function save_sub_category_type(){



		$cat_id = $_REQUEST['cat_id'];



		$sub_cat_name = $_REQUEST['sub_cat_name'];



		$subcat_status = $_REQUEST['subcat_status'];



    	



    	$data = array(



    			'name' => $sub_cat_name,



				'ordinal' =>$cat_id,



				'status' => $subcat_status,



    	);



    	$this->db->insert('category', $data);



	}

	

	function update_category_status(){

		$data=array();

		$data['category_id']=!empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '-1';

		$data['status']=!empty($_REQUEST['status']) ? $_REQUEST['status'] : 0;

		$data['status_update_line']=$data['status']==1 ? 'Active' : 'Inactive';

		$data['update_category_status']=$this->category_management->update_category_status($data['category_id'],$data['status']);

		echo($this->dr->GetDR("Update Successful", '', $data, "0"));;

	}

	

    function save_category_type() // 13



    {



    	$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];



    	$cat_name = $_REQUEST['cat_name'];



		//$sub_cat_name = $_REQUEST['sub_cat_name'];



		$status = $_REQUEST['status'];



    	//echo ' --- id ---- '.$id.' -- cat name --- '.$cat_name.' -- status --'.$status; exit;



		$check_category_created_zoneowner=$this->category_management->check_category_created_zoneowner($id);



		//var_dump($check_category_created_zoneowner); exit;



		if($check_category_created_zoneowner==0){		



			$data = array(



					'name' => $cat_name,



					//'ordinal' => 0,



					'status' => $status,



			);



    



			if(!empty($id) && $id > 0)



			{



				//update



				$this->db->where('id', $id);



				$this->db->update('category', $data);



			}



		}else if($check_category_created_zoneowner!=0){ 



			$_category_zone_assign = $this->category_management->assign_category_created_zoneowner($id,$cat_name,$status,$check_category_created_zoneowner);



		}



    	/*else



    	{



    		//insert



    		$this->db->insert('category', $data);



			$cat_id= $this->db->insert_id();



			$newdata=array(



				'name' => $sub_cat_name,



				'ordinal' => $cat_id,



				'status' => $status,



			);



			$this->db->insert('category', $newdata);



    	}*/



    	$data['categories'] = $this->category_management->get_all_categories();



		//var_dump($data['categories']);



			



    	$newTable1 = $this->load->view("admin/category_type.table.php", $data, true);



    	echo($this->dr->GetDR("Save Successful", "The save was successful", $newTable1, "0"));



    }



	



	function json_category_type($id)



    {



    	$query = $this->db->get_where('category', array('id' => $id));



    	echo(json_encode($query->row()));



    }



    



   function subcat($id){ echo 1; exit;



   		$data['id']=$id;



	   $this->load->view("admin/subcategory_type.table.php",$data, true); exit;



   }



    



	public function save_category(){

		

		$id=!empty($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 0;  

		$catname=!empty($_REQUEST['cat_name']) ? $_REQUEST['cat_name'] : '';

		$subcatname=!empty($_REQUEST['sub_cat_name']) ? $_REQUEST['sub_cat_name'] : '';



		if($id==-1){



			$data = array(



    			'name' => $catname,



				'status' => 1,



    		);



    		$this->db->insert('category', $data);



			$cat_id= $this->db->insert_id();



			$newdata=array(



				'catid' => $cat_id,



				'name' => $subcatname,



				'status' => 1,



			);



			$this->db->insert('category_subcategory', $newdata);



			//echo($this->dr->GetDR("Save Successful", "The save was successful", "", "0"));



		}



	}



	function delete_category(){

		$data=array();

		$data['cat_id']=!empty($_REQUEST['cat_id']) ?  $_REQUEST['cat_id'] : 0;

		$data['cat_name']=!empty($_REQUEST['cat_name']) ?  $_REQUEST['cat_name'] : '';

		$data['categories'] = $this->category_management->delete_category($data['cat_id']);

		echo($this->dr->GetDR("","", $data, "0"));

	}



	public function save_subcategory(){

		

		$catid=!empty($_REQUEST['cat_id']) ?  $_REQUEST['cat_id'] : 0;

		$subcatname=!empty($_REQUEST['sub_cat_name1']) ?  $_REQUEST['sub_cat_name1'] : '';

		$subcatstatus=!empty($_REQUEST['status']) ?  $_REQUEST['status'] : '';



		//if($id==-1){



			/*$data = array(



    			'name' => $catname,



				'status' => 1,



    		);



    		$this->db->insert('category', $data);



			$cat_id= $this->db->insert_id();*/



			$newdata=array(



				'catid' => $catid,



				'name' => $subcatname,



				'status' => $subcatstatus,



			);



			$this->db->insert('category_subcategory', $newdata);



			//echo($this->dr->GetDR("Save Successful", "The save was successful", "", "0"));



		//}



	}



	



	public function edit_category_subcategory(){ 



		 $data = array();



        //$data['tier'] = $tiers;



        /*$scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/category_type.inc.js");



		$data["scripts"] = $scripts;*/



		$data['categories'] = $this->category_management->get_all_categories();



		//var_dump($data['categories']);



		$result = $this->load->view("admin/category_type.table.php",$data, true);



		echo($this->dr->GetDR("","", $result, "0"));



	}



    



	public function display_subcategory($id){



		//echo $id; exit;



		//$id = $_REQUEST['id'];



		//var_dump($id);



		$data['categorydetails'] = $this->category_management->get_individual_category_details($id); 



		$data['subcategories'] = $this->category_management->get_all_subcategories($id);



		//var_dump($data['subcategories']);exit;



		$result = $this->load->view("admin/subcategory_type.table.php",$data, true);



		echo($this->dr->GetDR("","", $result, "0"));



	}



	



	public function display_subcategory_zone($id){



		//echo $id; exit;



		//$id = $_REQUEST['id'];



		//var_dump($id);



		//$data['categorydetails'] = $this->category_management->get_individual_category_details($id); 



		//$data['subcategories'] = $this->category_management->get_all_subcategories($id);



		//var_dump($data['subcategories']);exit;



		$data['zone_categorydetails'] = $this->category_management->get_individual_category_details($id);



		//var_dump($data['zone_categorydetails']);



		//$data['zonecategories'] = $this->category_management->get_all_zone_subcategories($id);



		



		/*$data['category_type']=$this->category_management->get_category_type($id);



		//var_dump($data['category_type']);



		if($data['category_type'][0]['zoneassigntype']==1){



			$data['zonecategories'] =$this->sales_zone->get_all_zones();



		}else if($data['category_type'][0]['zoneassigntype']==2){



			$data['zonecategories'] = $this->category_management->get_all_zone_subcategories($id);



		}*/



		$data['zonecategories'] = $this->category_management->get_all_zone_subcategories($id);



		//var_dump($data['zonecategories']);		







		//var_dump($data['zonecategories']);



		$data['allzones_cat'] = $this->category_management->get_all_zone_subcategories1($id);



		//var_dump($data['allzones_cat']);



		$result = $this->load->view("admin/zone_sub_category_type.table.php",$data, true);



		echo($this->dr->GetDR("","", $result, "0"));



	}



	



	function json_subcategory_type($id)



    {



    	$query = $this->db->get_where(' category_subcategory', array('id' => $id));



    	echo(json_encode($query->row()));



    }



	



	function save_sub_category_details() // 13



    {



    	$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];



    	$subcat_name = $_REQUEST['subcat_name'];



		//$sub_cat_name = $_REQUEST['sub_cat_name'];



		$subcatstatus = $_REQUEST['subcatstatus'];



    	//echo ' --- id ---- '.$id.' -- sub cat name --- '.$subcat_name.' -- status --'.$subcatstatus; exit;



		$check_sub_category_created_zoneowner=$this->category_management->check_sub_category_created_zoneowner($id);



		//var_dump($check_sub_category_created_zoneowner); exit;



		if($check_sub_category_created_zoneowner==0){



			$data = array(



    			'name' => $subcat_name,



				//'ordinal' => 0,



				'status' => $subcatstatus,



			);



    



			if(!empty($id) && $id > 0)



			{



				//update



				$this->db->where('id', $id);



				$this->db->update('category_subcategory', $data);



			}



		} else if($check_sub_category_created_zoneowner!=0){



				$_sub_category_zone_assign = $this->category_management->assign_sub_category_created_zoneowner($id,$subcat_name,$subcatstatus,$check_sub_category_created_zoneowner);



		}		



    	



    	/*else



    	{



    		//insert



    		$this->db->insert('category', $data);



			$cat_id= $this->db->insert_id();



			$newdata=array(



				'name' => $sub_cat_name,



				'ordinal' => $cat_id,



				'status' => $status,



			);



			$this->db->insert('category', $newdata);



    	}*/				



		$a=$this->category_management->get_individual_subcategory_details($id);	



		$data['categorydetails'] = $this->category_management->get_individual_category_details($a[0]['catid']); 



		$data['subcategories'] = $this->category_management->get_all_subcategories($a[0]['catid']);					



    	$newTable2 = $this->load->view("admin/subcategory_type.table.php", $data, true);



    	echo($this->dr->GetDR("Save Successful", "The save was successful", $newTable2, "0"));;



    }



	



	public function view_zone_owner_category(){ 



		 $data = array();



        //$data['tier'] = $tiers;



        /*$scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/category_type.inc.js");



		$data["scripts"] = $scripts;*/



		$data['zonecategories'] = $this->category_management->get_all_active_categories();



		//var_dump($data['zonecategories']);



		$data['allzones']= $this->sales_zone->get_all_zones();



		$data['zoneselect']= $this->category_management->getbb();



		//var_dump($data['zoneselect']);



		



		//var_dump($data['allzones']);



		//var_dump($data['allzones']);



		/*$data['zoneassign']=$this->category_management->get_category_zone();



		var_dump($data['zoneassign']);*/



		//$data['zoneassign']=$this->category_management->get_category_zone($zonecategories[id]);



		//var_dump($data['zoneassign']);



		$result = $this->load->view("admin/zone_category_type.table.php",$data, true);



		echo($this->dr->GetDR("","", $result, "0"));



	}



	



	function assignzonecat()



    {



    	$catid=$_REQUEST['catid'];



		$zonetype=$_REQUEST['zonetype'];



		$selectedzone=$_REQUEST['selectedzone'];



		$_all_zones='';$all_subcats=''; 		



		if($zonetype==1){



			$all_zones= $this->sales_zone->get_all_zones();



			foreach($all_zones as $_x){



				$_all_zones.=$_x['id'].',';



			}



			$_all_zones=substr($_all_zones,0,strlen($_all_zones)-1);			



			$all_subcat=$this->category_management->get_all_subcat_in_category($catid);



			foreach($all_subcat as $_y){



				$all_subcats.=$_y['id'].',';



			}



			$all_subcats=substr($all_subcats,0,strlen($all_subcats)-1); 



			$add_cat_to_zone=$this->category_management->add_cat_to_zone($catid,$zonetype,$_all_zones,$all_subcats);



			



		}else if($zonetype==2){ 



			if($selectedzone!=''){//echo ' -- zone type ---'.$selectedzone; exit;



				$add_cat_to_zone=$this->category_management->add_cat_to_zone($catid,$zonetype,$selectedzone);				



			}



		}



		



    }



	



	



    function index($zone = false)



    {


        

       if (!$this->ion_auth->logged_in())



        {


            //redirect them to the login page



            redirect('auth/login', 'refresh');



        }



        elseif (!$this->ion_auth->in_group(array( "Tier I", "Tier II" )))



        {



            //redirect them to the home page because they must be an administrator to view this



            redirect($this->config->item('base_url') . (!empty($zone) ? "index.php?zone=".$zone : ""), 'refresh');



        }



        



        if($this->ion_auth->in_group("Tier I"))



        {



            $tiers = "Tier I";



        }



        else if($this->ion_auth->in_group("Tier II"))



        {



            $tiers = "Tier II";



        }



        else



        {



            $tiers = "Tier III";



        }







     



        $data = array();



        $data['tier'] = $tiers;



        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/category_type.inc.js");



        //$data['business_types'] = $this->business_type->get_all_business_types_name();



		//$data['categories'] = $this->category_management->get_all_categories();



		$data['categories'] = $this->category_management->get_all_categories();



		//var_dump($data['categories']);		



        $data["scripts"] = $scripts;



        $data["firstName"] = $this->ion_auth->user()->row()->first_name;



        $data["page_name"] = "category_management";



        $this->load->view("admin/header", $data);



        $this->load->view("admin/admin_buttons", $data);



        $this->load->view("admin/category_type.inc.php", $data);



		//$this->load->view("admin/subcategory_type.inc.php", $data);



        //$this->load->view("admin/category_type.table.php",$data);//var_dump($data);



        $this->load->view("admin/footer");



		//var_dump($data);



     //   redirect("admin");



    }



	



	function display_zone_cat_selected($catid){



		$data['spcat'] = $catid;



		$data['allzones']= $this->sales_zone->get_all_zones();



		//var_dump($data['allzones']);



		$data['selectedzone']=$this->category_management->getcc($catid);



		//var_dump($data['selectedzone']);



		//var_dump($data['display_zone_cat_selected']);



		//$data['zonecategories'] = $this->category_management->get_all_active_categories();



		//$data['categories123']=$catid;



		//var_dump($data['categories']);



		$result = $this->load->view("admin/zone_category_specifictype.table.php",$data, true);



		echo($this->dr->GetDR("","", $result, "0"));



	}



	function display_zone_subcat_selected($catid,$subcatid,$val){



		//echo $catid.'--'.$subcatid.'--'.$val; exit;



		$data['subcat'] = $subcatid;



		if($val!=1)



			$data['allzones']= $this->sales_zone->get_all_spzones($catid,$val);



		else if($val==1)



			$data['allzones']= $this->sales_zone->get_all_zones();



		$data['selectedzone']=$this->category_management->getsubcatforzone($subcatid);



		//var_dump($data['allzones']);



		//$data['selectedzone']=$this->category_management->getcc($catid);



		//var_dump($ppg);



		//var_dump($data['display_zone_cat_selected']);



		//$data['zonecategories'] = $this->category_management->get_all_active_categories();



		//$data['categories123']=$catid;



		//var_dump($data['categories']);



		$result = $this->load->view("admin/zone_subcategory_specifictype.table.php",$data, true);



		echo($this->dr->GetDR("","", $result, "0"));



	}



	function assignzonesubcat()



    {



    	$subcatid=$_REQUEST['subcatid'];



		$subzonetype=$_REQUEST['subzonetype'];



		$selectedsubzone=$_REQUEST['selectedsubzone'];



		$catid=$_REQUEST['catid'];



		//echo ' cat id --- '.$catid.' -- subcatid - '.$subcatid.' -- subzonetype ---'.$subzonetype.' -- selectedsubzone -- '.$selectedsubzone; exit;



		



		if($subzonetype==1){



			$all_zones= $this->sales_zone->get_all_zones();



			//var_dump($all_zones);//exit;



			foreach($all_zones as $_x){ //echo $_x['id']; echo '<br>'; 



				$add_cat_to_zone=$this->category_management->add_subcat_to_zone($subcatid,$subzonetype,$_x['id'],$catid);



			}



			



		}else if($subzonetype==2){ 



			//if($selectedsubzone!=''){//echo ' -- zone type ---'.$selectedsubzone; exit;



				$add_cat_to_zone=$this->category_management->add_subcat_to_zone($subcatid,$subzonetype,$selectedsubzone,$catid);				



			//}



		}



		



    }







}