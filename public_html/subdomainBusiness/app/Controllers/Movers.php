<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 class Movers extends CI_Controller {
 	/**
 	  * @desc constructor function to load required data
 	*/
 	public function __construct() {
 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->library('session');
 		$this->load->model("admin/Ads_model", "ad");
		$this->load->model("Category_new_model");
		$this->load->model("banner/Banner_model", "banner");
 		$this->load->database();

 	}

 	public function temp_ads(){//calling from new_page

        $data = array();
        $zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
        $userId=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
        $lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0;
        $upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 0;
        $cost_limit=!empty($_REQUEST['cost_limit']) ? $_REQUEST['cost_limit'] : 0;
        $data['barter_button']=!empty($_REQUEST['barter_button']) ? $_REQUEST['barter_button'] : '';
        $data['job_button']=!empty($_REQUEST['job_button']) ? $_REQUEST['job_button'] : '';
        $subcat_id=!empty($_REQUEST['subcat_id']) ? $_REQUEST['subcat_id'] : 0;
        $cat_id=!empty($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 0;
        $from_where=!empty($_REQUEST['from_where']) ? $_REQUEST['from_where'] : '';
        $search_value=!empty($_REQUEST['search_value']) ? $_REQUEST['search_value'] : '';
//$search_value=urlencode(!empty($_REQUEST['search_value']) ? $_REQUEST['search_value'] : ''); //as search value is encoded in database.
        $user_id=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
        $charval=!empty($_REQUEST['charval']) ? $_REQUEST['charval'] : '';
        $deal_title_ad_id=!empty($_REQUEST['deal_title_ad_id']) ? $_REQUEST['deal_title_ad_id'] : 0;
        $deal_title_type=!empty($_REQUEST['deal_title_type']) ? $_REQUEST['deal_title_type'] : '';
        $deal_title=!empty($_REQUEST['deal_title']) ? $_REQUEST['deal_title'] : '';
        $food_deliver=!empty($_REQUEST['food_deliver']) ? $_REQUEST['food_deliver'] : 0;
        $subcatparentid = !empty($_REQUEST['subcatparentid']) ? $_REQUEST['subcatparentid'] : 0;
//var_dump($cat_id); echo $from_where; exit;
//$link_path = $this->config->item('link_path');
        $data['link_path']= !empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : "";
        if($from_where=='home_page_ads'){
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit);
        } else if($from_where=='show_all_offers'){ // show all offers
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0,0,0,0,$charval);
        }else if($from_where=='show_temp_ads'){ // business coming soon
            if($subcat_id==0){// 0 means business comming soon
                $subCatId=-99;
            }if($cat_id==0){
                $catId=-99;
            }
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',$catId,$subCatId);
        }else if($from_where=='show_ads_specific_sub_category'){ // show_ads_specific_sub_category
            $data['call_again'] = !empty($_REQUEST['call_again']) ? $_REQUEST['call_again'] : false;
            if($subcat_id == '45')
            {
                $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0);
            }
            else{
                $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,$subcat_id);
            }
            //$data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0);
            
        }else if($from_where=='show_ads_specific_category'){ // show_ads_specific_category
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',$cat_id,0,0,0,0,'',0,'','',$food_deliver);
        }else if($from_where=='show_search_business'){ // show_search_business
           // echo "form where ".$from_where;
           // exit;
            
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value);
        }else if($from_where=='show_favorites_ads'){ // show_favorites_ads
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0,$user_id);
        }else if($from_where=='sharing_offers'){ // sharing_offers
            //echo "22222222233"; exit;
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0,0,0,0,'',$deal_title_ad_id,$deal_title_type,$deal_title);
        }else if($from_where=='show_ads_specific_subcatparentid_category'){ // By Industry & Start-up Cost header link
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0,0,0,0,'',0,'','','',$subcatparentid);
        }else if($from_where=='show_ads_specific_startupcostlimit'){
            $multiplesubcatid = '' ;
            $multiplesubcatid = $this->Category_new_model->get_subcat_under_startupcost_limits($cost_limit);
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0,0,0,0,'',0,'','','','',$multiplesubcatid);
        }elseif($from_where=='sponsor_businesses_home_page'){
            $data['call_again'] = !empty($_REQUEST['call_again']) ? $_REQUEST['call_again'] : false;
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 1);
        }elseif($from_where=='sponsor_businesses_menu_home_page'){
            //echo "22222";exit;
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 2);
        }elseif($from_where=='show_mover_business'){
            /*for showing data on movers page*/
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 3);
        }
////var_dump($data['adlist']);
// ++ load peekaboo auctions on advertisement load
        if(!empty($data['adlist'])){
            $currentadid_arr = array() ;
            foreach($data['adlist'] as $key=>$addetails){
                $data['adlist'][$key]['peekaboolist'] = $this->ad->show_popup($addetails['adid'], $zone_id) ;
                $data['adlist'][$key]['isFoodCategory'] = $this->ad->is_food_category($addetails['adid']);
            }
            //echo '<pre>'; print_r($data['adlist']);
        }
// -- load peekaboo auctions on advertisement load
        $data['from_adspage']=0;
        $data['zone'] = $zone_id;
        $data["user_id"] = "";
        $data["restaurantTimeList"] = $this->diningmodel->getTimeListArray(); 
//$data['from_where'] = 'subcategory';
        $data['from_where'] = $from_where;
        if ($this->ion_auth->logged_in()){
            $auser = $this->ion_auth->user()->row();
            $data['user_info'] = $this->ion_auth->user()->row();
            $data["user_id"] = $auser->id;
            
        }
        // generate gallery array
        //$business_id = $this->ad->get_sponser_business($zone_id);        
        foreach($data['adlist'] as $key=>$adddetails){
            
            //$data['adlist'][$key]['gallerylist'] = $this->ad->get_all_gallery_images($adddetails['bs_id']);
            /*$data['adlist'][$key]['selectTheme'] = $this->ad->get_theme($adddetails['bs_id']);
            $data['adlist'][$key]['selectMenu'] = $this->ad->get_menu($adddetails['bs_id']);
            $data['adlist'][$key]['rating'] = $this->ad->get_latest_rating($adddetails['bs_id']);*/
            $data['adlist'][$key]['reservation'] = $this->ad->reservation_menu($adddetails['bs_id']);
			$data['adlist'][$key]['snapPeeks'] = $this->ad->snap_peeks($adddetails['bs_id']);
            $data['adlist'][$key]['useremail'] = $this->ad->get_user_email($userId);
            $data['adlist'][$key]['selectTheme'] = $this->ad->get_theme($adddetails['bs_id']);
            $data['adlist'][$key]['selectMenu'] = $this->ad->get_menu($adddetails['bs_id']);
            $data['adlist'][$key]['snap_status'] = $this->ad->get_offer_status_check($adddetails['bs_id'],$userId,2,$zone_id);
            $data['adlist'][$key]['isFoodCategory'] = $this->ad->is_food_category($addetails['adid']);
$data['adlist'][$key]['reservationdetail'] = $this->Category_new_model->get_category_subcategory($adddetails['adid'],$zone_id);
        }
/*            echo "<pre>";
            print_r($data['adlist']);
            echo "</pre>";
            echo $addetails['adid'];
            echo $zone_id;*/
        //echo "<pre>"; print_r($data); echo "</pre>"; exit;
        //$this->load->view('newadlist', $data);
        echo $_GET['callback']."(".json_encode($data).");";
    }
 	 	public function search($zoneId) {
 	 	$data['frompage'] = "movers"; 
 		$userId = $this->session->userdata('user_id'); 
		$data['link_path']			= $this->config->item('link_path');
    	$data['base_url'] 			= $this->config->item('base_url'); 		
 		$data['zoneid'] 			= $zoneId;
		$data['userid']				= $userId; 	

		$data['business_theme'] 	= "blue"; 
		$data['business_page'] 	= 'Old Glory'; 
		
    	if($this->input->cookie('business_sstheme',true)){
    		$data['business_theme'] 		= $this->input->cookie('business_sstheme',true);
    		$data['business_page'] 		= $this->input->cookie('business_sstitle',true);
		}
        if($this->ion_auth->logged_in()){ 
            $auser = $this->ion_auth->user()->row();
            

            if(!empty($auser)){ 
                $this->session->set_userdata('get_email',$auser->email);
                $data["user_id"] = $auser->user_id;
                $data["email"] = $auser->email; 
                $data["firstName"] = $auser->first_name;
                $data["lastName"] = $auser->last_name;
                # + Cookies set as user_id
                    $cookie = array(
                    'name'   => 'user_id',
                    'email'   => 'email',
                    'value'  => $data["user_id"],
                    'expire' => time()+86500,
                    'domain' => '',
                    'path'   => '/',
                    'prefix' => '',
                    );
                    set_cookie($cookie);
                # - Cookies set as user_id
            }
        }
        //session data set
        if($this->session->userdata('session_usertype')!=''){
            $session_usertype_arr=$this->session->userdata('session_usertype');
            $session_usertype=$session_usertype_arr['usertype']; 
        }else{
            $session_usertype='';
        }
        
        if($this->session->userdata('session_normal_user_in_zone')!=''){
            $session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
            $session_session_normal_user_in_zone=$session_normal_user_in_zone_arr['sesuserzone'];
            $session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype']; 
        }else{
            $session_session_normal_user_in_zone='';
            $session_session_normal_user_type='';
            $session_type='';
            $session_type_id='';
        }
        $data['session_usertype']=$session_usertype; 
        $data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;
        $data['session_session_normal_user_type']=$session_session_normal_user_type;	
		//$data['active_banner'] 		= $this->banner->active_banner($zoneId,'','2');	
		$data['active_banner_mobile'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','2','2');
		$data['active_banner_desktop'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','2','1');
 		$data['category_list_food']	= $this->Category_new_model->get_products_details($zoneId,1); 
 		$data['category_list']		= $this->Category_new_model->get_products_details($zoneId,0); 		
		$data['head'] 				= $this->load->view("businessSearch/head",$data); 
        $data['header'] 			= $this->load->view("businessSearch/header", $data);
       // $data['content'] 			= $this->load->view('businessSearch/search',$data);
       //$data['content'] 			= $this->load->view('businessSearch/slider',$data);
        //$data['content'] 			= $this->load->view('businessSearch/new_slider',$data);
        $data['content']            = $this->load->view('mover/new_slider',$data);
 		/*$data['content'] 			= $this->load->view('businessSearch/mslider',$data);*/
 		$data['content'] 			= $this->load->view('mover/offers',$data);
 		//$data['content'] 			= $this->load->view('directory',$data);
		$data['footer'] 			= $this->load->view("businessSearch/footer", $data);
		$data['modals'] 			= $this->load->view("includes/modals",$data); 
 	}
 	public function demofeedback($value='')
 	{
$arr = array();
$arr['userId'] = $_GET['userId'];
$arr['userName'] = $_GET['userName'];
echo $_GET['callback']."(".json_encode($arr).");";
 	}
 }
