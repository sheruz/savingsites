<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
class Directory_ss extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
		$this->load->library('session');
        $this->load->library('ion_auth');        
        $this->load->library('form_validation');				
		$this->load->library('user_agent');		
        $this->load->helper('url');
		$this->load->helper('cookie');
        $this->load->model("Zips");
        $this->load->helper("time_helper");
		//$this->load->helper("translate_helper");
        $this->load->model("admin/Category_model", "category");
        $this->load->model("admin/Announcement_model", "announcements");
		$this->load->model("admin/Zonal_ads", "zonalads");//added by koushik chhetri to fetch the ads against the zoneid
        $this->load->model("admin/Ads_model", "ads");
        $this->load->model("admin/Sales_zone", "sales_zone");
		$this->load->model("States", "states");
		$this->load->model("admin/Business", "business");
		$this->load->model("admin/Ads_model", "ad");
		$this->load->model("admin/Business_type_model", "business_type");
		$this->load->model("admin/Category_management_model", "category_model");
		$this->load->model("admin/Users", "users");
		$this->load->model("Category_new_model");
		$this->load->model("Organization_model", "org_model");
		$this->load->model("Directory_model", "dir_model");

        $this->load->database();
    }
	function view_user_category(){
		$userid=!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		//if($userid!='' && $zoneid!=''){
			$arr=$this->dir_model->view_user_category($userid,$zoneid); //var_dump($arr);
			echo json_encode($arr);
		//}
	}
	function category_add(){
		$data = array();
		$cat_name=!empty($_REQUEST['cat_name']) ? $_REQUEST['cat_name'] : 0 ;
		$userid=!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;


		//if($userid!='' && $zoneid!=''){
			$cat_id=$this->dir_model->insert_user_category($userid,$zoneid,$cat_name); //var_dump($arr);
			
			echo json_encode($cat_id);
		//}
	}

	function userfav_add(){
		$data = array();
		$site_name=!empty($_REQUEST['site_name']) ? $_REQUEST['site_name'] : 0 ;
		$site_category=!empty($_REQUEST['site_category']) ? $_REQUEST['site_category'] : 0 ;
		$site_link=!empty($_REQUEST['site_link']) ? $_REQUEST['site_link'] : 0 ;
		$site_comments=!empty($_REQUEST['site_comments']) ? $_REQUEST['site_comments'] : 0 ;
		$userid=!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;


		//if($userid!='' && $zoneid!=''){
			$data['cat_id']=$this->dir_model->insert_user_favourite($userid,$zoneid,$site_name,$site_category,$site_link,$site_comments); //var_dump($arr);
			echo json_encode($data);
		//}
	}

	function view_all_favourite()
	{
		$data = array();
		$userid=!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$data['fav_arrs'] = $this->dir_model->getFavouritelinks($userid,$zoneid);
		/*echo"<pre>";
		print_r($fav_arrs);
		die;*/
		//$html = $this->load->view('favourite_list_show',$fav_arr,TRUE);
		echo json_encode($this->load->view('favourite_list_show',$data,TRUE));
	}
	function delete_favourite(){
		$fav_id=!empty($_REQUEST['fav_id']) ? $_REQUEST['fav_id'] : 0 ;
		$userid=!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;


		//if($userid!='' && $zoneid!=''){
		$del_fav = $this->dir_model->user_delete_sites($fav_id); //var_dump($arr);
		if($del_fav == 1)
		{
			echo json_encode(array('response' => 'Success'));
		}
		//}
	}

	function delete_category(){
		$cat_id=!empty($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 0 ;
		$userid=!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		//if($userid!='' && $zoneid!=''){
		$del_fav = $this->dir_model->delete_category($cat_id); //var_dump($arr);
		if($del_fav == 1)
		{
			echo json_encode(array('response' => 'Success'));
		}
		//}
	}

	function view_user_quick_access(){
		$userid=!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		//if($userid!='' && $zoneid!=''){
			$arr=$this->dir_model->view_user_quick_access($userid,$zoneid); //var_dump($arr);
			echo json_encode($arr);
		//}
	}
	// insert user category start 
	function insert_user_category(){ //var_dump($_REQUEST);exit;
		$userid=!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$catname=!empty($_REQUEST['catname']) ? $_REQUEST['catname'] : 0 ;
		$category_id=!empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : 0 ;
		//if($id!='0'){
			$id=$this->dir_model->insert_user_category($userid,$zoneid,$catname,$category_id);
			echo $id;
			/*if(!empty($id)){
				echo trim($id).'!@#'.trim($catname);
			}else{
				echo '';
			}*/
		//}
	}
	function user_quick_access(){//var_dump($_REQUEST);exit;
		$userid=!empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$cat_id=!empty($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 0 ;  //exit;
		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$sitename=!empty($_REQUEST['sitename']) ? $_REQUEST['sitename'] : '' ;
		$sitelink=!empty($_REQUEST['sitelink']) ? $_REQUEST['sitelink'] : '' ;
		$sitecomments=!empty($_REQUEST['sitecomments']) ? $_REQUEST['sitecomments'] : '' ;
		$from_where=!empty($_REQUEST['from_where']) ? $_REQUEST['from_where'] : '' ;
		$quick_access_id=!empty($_REQUEST['quick_access_id']) ? $_REQUEST['quick_access_id'] : '-1' ;
		$create=!empty($_REQUEST['create']) ? $_REQUEST['create'] : '' ;
		$id=$this->dir_model->user_quick_access($userid,$cat_id,$zoneid,$sitename,$sitelink,$sitecomments,$from_where,$quick_access_id,$create);
		echo $id;
	}
	// insert user category end
	function user_fav_zone(){
		$userid = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$arr=$this->dir_model->user_fav_zone($userid,$zoneid);
		echo json_encode($arr);
	}
	function fetch_user_fav_zone(){
		$id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : 0 ;
		$userid = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;		
		$arr=$this->dir_model->fetch_user_fav_zone($userid,$zoneid,0,$id);
		echo json_encode($arr);
	}
	function get_user_fav_cat(){
		
		$userid = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
			
		$arr=$this->dir_model->get_user_fav_cat($userid,$zoneid);
		echo json_encode($arr);
	}
	function fetch_user_fav_cat(){
		$id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : 0 ;
		$userid = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$catid = !empty($_REQUEST['catid']) ? $_REQUEST['catid'] : 0 ;		
		$arr=$this->dir_model->fetch_user_fav_zone($userid,$zoneid,trim($catid),$id);
		echo json_encode($arr);
	}

	function update_category()
	{
		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;
		$userid = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : 0 ;
		$user_category_id = !empty($_REQUEST['user_category_id']) ? $_REQUEST['user_category_id'] : 0 ;
		$cat_text = !empty($_REQUEST['cat_text']) ? $_REQUEST['cat_text'] : 0 ;

		$data_arr = array('name' => $cat_text);

		$arr=$this->dir_model->update_category($data_arr,$user_category_id);

		echo json_encode(array('response' => 'Success'));
	}
	
	// user news letter delete start
	function get_user_newsletter_delete(){
		$id=!empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;
		$this->users->delete_newsletter_user($id); 		
	}
	// user news letter delete end
	
	
	function get_user_ig_delete($zoneid=0,$id=0,$type=0){
		
		$data = array();
		$data['zone_id']=$zoneid;
		$auser = $this->ion_auth->user()->row();
		$this->users->delete_interest_group_for_user($id); 
		$data['approved_bus'] = $this->users->get_all_interest_group_for_user($zoneid,$auser->user_id,$type);
		//var_dump($data['approved_bus']);
		if($type==2)				
			$this->load->view('ig_bus_details', $data);
		else if($type==3)
			$this->load->view('ig_org_details', $data);
	}
	// Deleting fav. zone by resident user
	function user_delete_zone(){	
		$id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : 0 ;
		$res = $this->dir_model->user_delete_zone($id);
		echo json_encode($res);
	}
	function user_delete_sites(){	
		$id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : 0 ;
		$res = $this->dir_model->user_delete_sites($id);
		echo json_encode($res);
	}
	function view_specific_links(){
		$arr = array() ;
		$id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : 0 ;
		$res = $this->dir_model->view_specific_links($id) ;
		/*$arr['userid'] = $res['userid'];
		$arr['catid'] = $res['catid'];
		$arr['zoneid'] = $res['zoneid'];
		$arr['sitename'] = $res['sitename'];
		$arr['sitelink'] = $res['sitelink'];
		$arr['sitecomments'] = $res['sitecomments'];
		$arr['timestamp'] = date("d-m-Y",$res['timestamp']);*/
		echo json_encode($res) ;
	}
}
?>