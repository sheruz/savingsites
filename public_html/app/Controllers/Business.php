<?php
namespace App\Controllers;
use App\Models\IonAuthModel;
use App\Models\Zips;
use App\Models\Category_new_model;
use App\Models\Organization_model;
use App\Models\banner\Banner_model;
use App\Models\zone\Zone_model;
use App\Models\admin\Business_type_model;
use App\Libraries\IonAuth;
use App\Models\Users;
use App\Controllers\CommonController;
use App\Models\admin\Sales_zone;
use App\Models\admin\Ads_model;
#[\AllowDynamicProperties]
class Business extends BaseController{
	private $arr_ad=array();
   	public function __construct(){
        $this->db = \Config\Database::connect();
        $this->cart = cart();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->Zips = new Zips();
        $this->Banner_model = new Banner_model();
        $this->Category_new_model = new Category_new_model();
        $this->CommonController = new CommonController();
        $this->SalesZone = new Sales_zone();
        $this->Zone_model = new Zone_model();
        $this->Users = new Users();
        $this->Organization_model = new Organization_model();
        $this->Ads_model = new Ads_model();
        $this->Business_type_model = new Business_type_model();
    } 

	// public function __construct(){
	// 	parent::__construct();
	// 	$this->load->library('ion_auth');
	// 	$this->load->library('session');
	// 	$this->load->library('image_lib');
	// 	$this->load->library('form_validation');	
	// 	$this->load->library('user_agent');	
	// 	$this->load->helper('url');
	// 	$this->load->model("Zips");
	// 	$this->load->helper("time_helper");
	// 	$this->load->model("admin/Category_model", "category");
	// 	$this->load->model("zone/zone_model", "zone_model");
	// 	$this->load->model("Organization_model", "org_model");
	// 	$this->load->model("admin/Announcement_model", "announcements");
	// 	$this->load->model("admin/Zonal_ads", "zonalads");
	// 	$this->load->model("admin/Ads_model", "ads");
	// 	$this->load->model("admin/Sales_zone", "sales_zone");
	// 	$this->load->model("States", "states");
	// 	$this->load->model("admin/Business_type_model", "business_type");
	// 	$this->load->model("admin/Category_management_model", "category_model");
	// 	$this->load->model("Category_new_model");
	// 	$this->load->model("onlinedelivery/Onlinedelivery","delivery");
	// 	$this->load->model("onlinedelivery/Managemenu","managemenu");
	// 	$this->load->database();
	// }







   public function index(){


	redirect(base_url(), 301);
   }



   



   public function login(){



	   $data = array(); 

	   $session_arr1 = array('business_login'=>'business_login');        			

		$this->session->set_userdata('session_login_from_mail',$session_arr1); 

	   redirect(base_url(), 'refresh');



   }



	



  function update_business_verification(){  



		$data=array();

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		$data['zoneid'] = empty($_REQUEST['zoneid'])? 0 : $_REQUEST['zoneid'];

		$data['adid'] = empty($_REQUEST['adid'])? 0 : $_REQUEST['adid'];

		$data['businessid'] = empty($_REQUEST['bid'])? 0 : $_REQUEST['bid'];

		$data['bus_name'] = empty($_REQUEST['bus_name'])? '' : $_REQUEST['bus_name'];

		$data['bus_fname'] = empty($_REQUEST['bus_fname'])? '' : $_REQUEST['bus_fname'];

		$data['bus_lname'] = empty($_REQUEST['bus_lname'])? '' : $_REQUEST['bus_lname'];

		$data['bus_email'] = empty($_REQUEST['bus_email'])? '' : $_REQUEST['bus_email'];

		$data['bus_phone'] = empty($_REQUEST['bus_phone'])? '' : $_REQUEST['bus_phone'];

		$data['bus_website'] = empty($_REQUEST['bus_website'])? '' : $_REQUEST['bus_website'];

		$data['bus_street_address_1'] = empty($_REQUEST['bus_street_address_1'])? '' : $_REQUEST['bus_street_address_1'];

		$data['bus_street_address_2'] = empty($_REQUEST['bus_street_address_2'])? '' : $_REQUEST['bus_street_address_2']; 

		$data['bus_city'] = empty($_REQUEST['bus_city'])? '' : $_REQUEST['bus_city'];

		$data['bus_state'] = empty($_REQUEST['bus_state'])? '' : $_REQUEST['bus_state'];

		$data['bus_zip'] = empty($_REQUEST['bus_state'])? '' : $_REQUEST['bus_zip'];

		$data['business_owner_id'] = empty($_REQUEST['business_owner_id'])? '0' : $_REQUEST['business_owner_id'];
 

		$data['ad_category']=empty($_REQUEST['ad_category'])? '' : $_REQUEST['ad_category'];

 
		$data['ad_sub_category']=empty($_REQUEST['ad_sub_category'])? '' : $_REQUEST['ad_sub_category'];

 
		$data['foodimage']=empty($_REQUEST['foodimage'])? '' : $_REQUEST['foodimage'];



		$data['ad_text']=empty($_REQUEST['ad_text'])? '' : $_REQUEST['ad_text'];

 



		$data['update_business_business_owner'] = $this->ads->update_business_from_business_verification($data['businessid'],$data['bus_name'],$data['bus_fname'],$data['bus_lname'],$data['bus_email'],$data['bus_phone'],$data['bus_website'],$data['bus_street_address_1'],$data['bus_street_address_2'],$data['bus_city'],$data['bus_state'],$data['bus_zip'],$data['ad_text'],$data['foodimage'],$data['business_owner_id']);


 

		$data['ads_save_cat_subcat'] = $this->Category_new_model->ads_save_cat_subcat($data['adid'],$data['ad_category'],$data['ad_sub_category'],$data['zoneid'],'business');

		$update_zone_menu=$this->menu_generator($data['zoneid']);

		



		$result=$data['businessid'];



		echo $result;
 

	}



	/** 

	* Log genarate for Zone category menu. According to log file details zone category menu view show into SS directory 

	* Model functiontional page - Category_new_model

	* Input Parameter - $zoneid

	*/



 function menu_generator($zoneid=0){  

		 

		$data=array();

		$data['category_list_food']=$this->Category_new_model->get_products_details($zoneid,1);  

		 

		$data['category_list']=$this->Category_new_model->get_products_details($zoneid,0);  

		$data['category_list_other']=$this->Category_new_model->get_products_details($zoneid,14);

		ob_start();

		$this->load->view('directory/generate_zone_menu', $data);

		$var=ob_get_contents(); 

		ob_clean();
		 

		$ourFileName = $zoneid.".txt";

		$from="uploads/zone_menu/".$ourFileName;

		$ourFileHandle = fopen($from, 'w') or die("can't open file");

		fwrite($ourFileHandle,$var);

		fclose($ourFileHandle);

	}
	
	public function businessdetail($bussid,$zoneid){
		$session_session_normal_user_in_zone = $session_session_normal_user_type = $session_type = $session_type_id= $email = $firstName = $lastName = $businessUser = $session_usertype = $refer_code = $orderonlineservice = $anewid = $busimage = $busimagetype = '';
		$countTotalImage = 0;
		$allBusimage = $addlist = [];
        if(empty($bussid)){ $this->CommonController->redirectPage(base_url());}
        if(empty($zoneid)){ $this->CommonController->redirectPage(base_url());}

 		$userid = $this->CommonController->getSession('user_id'); 
		$theme = $business_theme = "blue"; 
		$business_page = 'Old Glory'; 
		
		if($this->CommonController->getCookie('business_sstheme')){ 
			$business_theme = $this->CommonController->getCookie('business_sstheme');
			$business_page = $this->CommonController->getCookie('business_sstitle');
		}
    	
    	if($this->ionAuth->loggedIn()){ 
			$auser = $this->ionAuth->user()->row();
	 		if(!empty($auser)){ 
	 			$this->CommonController->setSession('get_email', $auser->email);
				$userid = $auser->user_id;
				$email = $auser->email; 
				$firstName = $auser->first_name;
				$lastName = $auser->last_name;
				$businessUser = $auser;
				$this->CommonController->SetCookie('user_id',$userid,time()+86500,'','/','','email');
			}
		}
 		
 		if($this->CommonController->getSession('session_usertype')){
			$session_usertype_arr=$this->CommonController->getSession('session_usertype');
			$session_usertype=$session_usertype_arr['usertype']; 
		}
		
		if($this->CommonController->getSession('session_normal_user_in_zone') !=''){
			$session_normal_user_in_zone_arr=$this->CommonController->getSession('session_normal_user_in_zone');
			$session_session_normal_user_in_zone=$session_normal_user_in_zone_arr['sesuserzone'];
			$session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype']; 
		}
		
		$busdata = $this->Business_type_model->get_all_bussdata($bussid); 
        $zone_logo = isset($busdata[0]['logo'])?$busdata[0]['logo']:'';
        $zone_name = isset($busdata[0]['name'])?$busdata[0]['name']:'';
		$adsdetailquery = "select a.businessid , f.*,b.name from ads_setting_preferences a INNER JOIN business b ON a.businessid=b.id INNER JOIN address c ON b.addressid=c.id INNER JOIN users d ON b.business_owner_id=d.id INNER JOIN users_groups e ON d.id=e.user_id LEFT JOIN ads f ON b.id=f.business_id LEFT JOIN ad_to_zone g ON f.id=g.adid LEFT JOIN ad_category_subcategory h ON f.id=h.adid where a.settingszoneid=".$zoneid." and a.type IN(1,2) and a.isdefault IN(0,1) and a.approval IN(1,2,3,-1,-2,-3) and  a.businessid = ".$bussid." GROUP BY a.businessid ORDER BY trim(b.name) asc ";
		$adsdata = $this->CommonController->SelectRawquery($adsdetailquery, 'resultArray');
		if(isset($adsdata) && is_array($adsdata) && count($adsdata) > 0){
			$adsdataid = $adsdata[0]['id'];
			$adsdatatitle = $adsdata[0]['deal_title'];
		}else{
			$adsdataid = '';
			$adsdatatitle = '';
		}


		$allBusimages ="
			select b.id as buid,f.adtext,tbld.card_img as dealimage,tbla.card_img as auctionimg from ads_setting_preferences a 
			
			INNER JOIN business b ON a.businessid=b.id 
			INNER JOIN users d ON b.business_owner_id=d.id 
			LEFT JOIN ads f ON b.id=f.business_id 
			left join tbl_member tblm on tblm.user_name =  d.username 
			left join tbl_deals_products  tbld on tbld.user_id = tblm.user_id 
			left join  tbl_inventory_products  tbla on tbla.user_id = tblm.user_id  
			where a.settingszoneid=".$zoneid." and a.type IN(1,2) and a.isdefault IN(0,1) and a.approval IN(1,2,3,-1,-2,-3) and  a.businessid = ".$bussid." GROUP BY a.businessid ORDER BY trim(b.name) asc";
		$allBusimages = $this->CommonController->SelectRawquery($allBusimages, 'resultArray');
		if(isset($allBusimages) && is_array($allBusimages) && count($allBusimages) > 0){
			// if($allBusimages[0]['dealimage'] != ''){ $countTotalImage = $countTotalImage+1;}
        	// if($allBusimages[0]['auctionimg'] != ''){ $countTotalImage = $countTotalImage+1;}
			// if($allBusimages[0]['auctionimg'] != ''){ $countTotalImage = $countTotalImage+1;}
       		$allBusimage[0]['dealimage'] = $allBusimages[0]['dealimage'];
        	$allBusimage[0]['auctionimg'] = $allBusimages[0]['auctionimg'];
        	$allBusimage[0]['adtext'] = $allBusimages[0]['adtext'];
        	
        	$allgalleryImages  = "Select * from  business_photos   where  business_photos.bus_id =".$bussid;
       		$allgalleryImages = $this->CommonController->SelectRawquery($allgalleryImages, 'resultArray');
        	if(count($allgalleryImages) != 0){ $countTotalImage = $countTotalImage+1;}

        	$certificate_sql_setting=$this->query="SELECT * FROM tlb_orderonlineservices  where businessid =".$bussid;		
     		$certificate_result_setting = $this->CommonController->SelectRawquery($certificate_sql_setting, 'resultArray');
       		$orderonlineservice = isset($certificate_result_setting[0]['data'])?$certificate_result_setting[0]['data']:'';
		
			foreach ($allgalleryImages as  $allgalleryImages) {          
         		$allBusimage[0]['galleryimage'][] = $allgalleryImages['image_name'];       
        	}
		}
        
        $get_paypal_info = $this->Zone_model->checkExistPaypalid($zoneid);
        $peekaboocredits = $this->Organization_model->getpeekaboocreditsofresidentuser($userid, $zoneid);
        $countTotalImage = $countTotalImage;
		$busimages = $allBusimage;
     	$deals = $this->Business_type_model->get_all_dealsdata($bussid,$zoneid);
 		$peekaboo_id = $this->allpeekabooId($bussid);
		$peekaboo_type = $this->allpeekabootype($bussid);
		if($peekaboo_type != ''){
			$auction_sql_setting = 'SELECT c.name as cat_name,ip.company_name ,ip.deal_product_id,ip.product_name,ip.image, a.deal_id,a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update FROM tbl_deals a LEFT JOIN tbl_deals_products ip ON ip.deal_product_id=a.product_id LEFT JOIN category_new c ON c.id=ip.cat_id WHERE a.user_id='.$peekaboo_id.' AND a.member_type='.$peekaboo_type.' AND a.auction_type="RTP" order by a.start_date ASC';
		}else{
			$auction_sql_setting = 'SELECT c.name as cat_name,ip.company_name ,ip.deal_product_id,ip.product_name,ip.image, a.deal_id,a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update FROM tbl_deals a LEFT JOIN tbl_deals_products ip ON ip.deal_product_id=a.product_id LEFT JOIN category_new c ON c.id=ip.cat_id WHERE a.user_id='.$peekaboo_id.' AND a.auction_type="RTP" order by a.start_date ASC';
		}
		$auction_result_setting = $this->CommonController->SelectRawquery($auction_sql_setting, 'resultArray');
		$zone= $this->Zone_model->get_zone($zoneid);
	   	$zone_owner = $this->ionAuth->user($zone['sales_rep_id'])->row();
	   	if(isset($_GET['adid']) && $_GET['adid'] > 0){
	   		$dealid = isset($_GET['dealid'])?$_GET['dealid']:'';
	   		$anewid = $_GET['adid'];
	   		$pbcashqry="SELECT a.*,b.* FROM tbl_deals as a INNER JOIN tbl_deals_products as b ON a.product_id=b.deal_product_id WHERE  a.deal_id='".$dealid."'";
			$addlist = $this->CommonController->SelectRawquery($pbcashqry);
			$dealimage = isset($addlist[0]['card_img'])?$addlist[0]['card_img']:'';
			if($dealimage != ''){
				$busimagetype = $ext = pathinfo($addlist[0]['card_img'], PATHINFO_EXTENSION);
				$busimage = base_url().'/assets/SavingsUpload/Business/'.$bussid.'/'.$addlist[0]['card_img'].'';
			}else{
				$adsqry="SELECT adtext FROM ads WHERE  id='".$anewid."'";
				$addtextarr = $this->CommonController->SelectRawquery($adsqry,'row');
				if($addtextarr != ''){
					$imagenew = $addtextarr->adtext;
					$busimagetype = $ext = pathinfo($addtextarr->adtext, PATHINFO_EXTENSION);
					$busimage = base_url().'/assets/SavingsUpload/Business/'.$bussid.'/'.$imagenew.'';	
				}else{
					$busimagetype = 'png';
					$busimage = 'https://savingssites.com/assets/SavingsUpload/images/new-savingssites3.png';
				}
			}
				// $meta_tag_details = $this->ionAuth->meta_tag_details($adidid);
				// $meta_tag_image = $this->ionAuth->meta_tag_image_details($adidid);
				// if(!empty($meta_tag_details)){ 
				// 	if($meta_tag_details[0]['deal_title']!=''){
				// 		$data['business_name']=$meta_tag_details[0]['deal_title'];
				// 		$bsname = $meta_tag_details[0]['business_name'];
				// 		$zone_name = $zone_name;
				// 		$business_id = $meta_tag_details[0]['business_id'];
				// 	}else
				// 		$business_name = $meta_tag_details[0]['business_name'];	
					
				// 	$bs_logo = $this->Business->business_logo($meta_tag_details[0]['business_id']);
				// 	if ($bs_logo->bs_logo) {		
				// 		$data['meta_business_image'][0] = ''.base_url().''.$bs_logo->bs_logo;
				// 	}elseif (isset($meta_tag_image[0]['image_name']) && $meta_tag_image[0]['image_name'] != ''){
				// 		$data['meta_business_image'][0] = base_url().'uploads/businessphoto/'. $meta_tag_details[0]['business_id'] .'/'. $meta_tag_image[0]['image_name'];
				// 	}else {
				// 		$data['meta_business_image'][0]= base_url()."assets/directory/images/ss-share-logo.jpg";
				// 	}
					
				// 	$image_type ='';// getimagesize($data['meta_business_image'][0]);
					
				// 	// if ($image_type[0] < 200 || $image_type[1] < 200 ) {
				// 	// 	$data['meta_business_image'][0]= base_url()."assets/directory/images/ss-share-logo.jpg";
				// 	// }
					
				// 	$meta_business_image_type = '';//$image_type['mime'];
				// 	$description=$meta_tag_details[0]['description'];
				// 	$description = urldecode(strip_tags($description));  
				// }
			

	   	}
		return view('businessSearchdetail',array('zoneid'=>$zoneid,'zone_id'=>$zoneid,'user_id' =>$userid,'userid' =>$userid,'busid'=>$bussid,'email'=>$email,'firstName'=>$firstName,'lastName'=>$lastName,'businessUser'=>$businessUser,'session_usertype'=> $session_usertype,'session_session_normal_user_in_zone'=>$session_session_normal_user_in_zone,'session_session_normal_user_type'=> $session_session_normal_user_type,'session_type'=>$session_type,'session_type_id'=> $session_type_id,'busdata'=>$busdata,'zone_logo'=> $zone_logo,'zone_name'=> $zone_name,'adsdata'=> $adsdata,'orderonlineservice'=>$orderonlineservice,'get_paypal_info'=>$get_paypal_info,'peekaboocredits'=> $peekaboocredits,'countTotalImage'=> $countTotalImage,'busimages'=> $busimages,'deals'=> $deals,'auction_result_setting'=> $auction_result_setting,'theme'=> $theme,'refer_code'=> $refer_code,'zone_owner'=> $zone_owner,'business_theme'=> $business_theme,'business_page'=> $business_page,'business_id'=> $bussid,'hidefooter' =>'hide','showfooter'=>'','adsdataid'=> $adsdataid,'adsdatatitle'=> $adsdatatitle,'bnamenew'=> $zone_name,'adid'=> $anewid,'addlist'=> $addlist,'busimage'=> $busimage,'busimagetype'=> $busimagetype));
	 
 

		


       

         
      



    
	   $data['header'] 			= $this->load->view("includes/landing_header",$data); 
      
                          $this->load->view('business/singlebuinessdetail', $data);
         $data['footer'] 			= $this->load->view("includes/landing_footer",$data); 
          

	 
 
	}
	
	public function allpeekabooId($userID){
    	$auction_sql_setting =  'select tbl_member.user_id from business inner join users on users.id = business.business_owner_id inner join tbl_member on tbl_member.user_name = users.username where business.id = '.$userID;
		$auction_result_setting = $this->CommonController->SelectRawquery($auction_sql_setting, 'resultArray');
		return $auction_result_setting[0]['user_id'];
    }

	public function allpeekabootype($userID){
    	$query =  'select tbl_member.member_type from business inner join users on users.id = business.business_owner_id inner join tbl_member on tbl_member.user_name = users.username where business.id = '.$userID;
    	$auction_result_setting = $this->CommonController->SelectRawquery($query, 'resultArray');
    	return $auction_result_setting[0]['member_type'];
   }


	public function fbeuiewfbewfe($bussid=0){

		//$data['theme'] = (strlen($theme_color->theme_color)!=0)? $theme_color->theme_color :"blue";
       //$data['css']            = 'style';

 		$data['head'] 				= $this->load->view("businessSearch/head",$data); 

        $data['header'] 			= $this->load->view("businessSearch/header", $data);
 
 		$data['content'] 			=$this->load->view('business/singlebuinessdetail', $data);

 		$data['footer'] 			= $this->load->view("businessSearch/footer", $data);
 
 
	}

	public function get_all_category_menu(){

		$zoneid=$_POST['zone_id'];

		$data=array();

	    $data['main_category_list']=$this->Category_new_model->get_main_category($zoneid);

	    echo json_encode($data);



	}



	public function save_businesss_logo($business_id){  

	$uploadedImage=$this->input->post('logo');  	

	$target = "uploads/ckeditor/$business_id/";

	

	if(is_dir($target)==false){

		mkdir($target,0777);

	}

	$outPutImage=$uploadedImage;

	$target=$target.basename($uploadedImage);

	$image_src='<image src='. base_url($target).' height=500px width=500px >';

	$pic=($this->input->post('logo'));



	$sourceUrl =  base_url()."image_gallery/app/web/upload/source/".$uploadedImage;

	if(copy($sourceUrl, $target))

	{

		$result=$this->business_type->update_business_logo($business_id,$outPutImage);

		if($result){

			$data=array('response'=>'success','path'=>$target);

			echo json_encode($data);

		}

	}else{

		echo json_encode(0);

	}

 }



 



 public function save_business_logo($business_id){ //var_dump($business_id);



	$upload_path_url = "uploads/ckeditor/$business_id/";

	$upload_new_path = $_SERVER['DOCUMENT_ROOT'] ."/uploads/ckeditor/$business_id/normal_image/";

    $config['upload_path'] = FCPATH . $upload_path_url;

    $config['allowed_types'] = 'jpg|jpeg|png|gif';

    $config['max_size'] = '300000';



    if(!file_exists($upload_new_path)){

		mkdir($upload_new_path,0777,true);

	}



	$source = FCPATH . "restaurantbooking/.htaccess";

	$destination = FCPATH ."uploads/ckeditor/$business_id/resized/.htaccess";
 

    $this->load->library('upload', $config);



    if (!$this->upload->do_upload('userfile','banner_image')) {

   			echo json_encode(0);    	

    }else {

            $data = $this->upload->data();

			

			$width = '689';

			$height = '334';

			$resize_target = "uploads/ckeditor/$business_id/normal_resize_image/";

		

			if(is_dir($resize_target)==false){

				mkdir($resize_target,0777);

			}

			$this->resize($resize_target,$data,$width,$height);



            //print_r($resize_config); exit;

            $outPutImage = $data['file_name'];

            $target=$resize_target.basename($outPutImage);

            //$result=$this->business_type->update_business_logo($business_id,$outPutImage);

			//$delete_prev_folder = $this->upload->rrmdir($upload_new_path);

            

			$data=array('response'=>'success','path'=>$target,'img_name'=> $outPutImage);

			echo json_encode($data);

    }



 }



 public function save_businesslogo($business_id)

 {

	

	$img_name = $_REQUEST['logo'];

	$this->load->library('upload');

	$upload_businesslogo_path = $this->config->item('upload_businesslogo_path');

	if(empty($upload_businesslogo_path))

	$upload_businesslogo_path = '/uploads/ckeditor/';

	$src = $upload_businesslogo_path.$business_id.'/normal_resize_image/';

	$dst = $_SERVER['DOCUMENT_ROOT'].$upload_businesslogo_path.$business_id.'/'.$img_name;

	

	

	//print_r($src);

	//print_r($dst);

	/*  die; */

	//$delete_prev_folder2 = $this->upload->rrmdir($src);

	//print_r($dst);

	$target=$dst.basename($img_name);

	

	$result=$this->business_type->update_business_logo($business_id,$img_name);

	//print_r($result);

	if($result){

		$data=array('response'=>'success','business_id'=> $business_id,'img_name'=>$img_name);

		echo json_encode($data);

	}

 }




 public function savebusinessImage($business_id)

 {

 

    $img_name = $_REQUEST['Iname'];

	$this->load->library('upload');

	$upload_businesslogo_path = $this->config->item('upload_businesslogo_path');

	if(empty($upload_businesslogo_path))

	$upload_businesslogo_path = '/uploads/ckeditor/';

	$src = $upload_businesslogo_path.$business_id.'/normal_resize_image/';

	$dst = $_SERVER['DOCUMENT_ROOT'].$upload_businesslogo_path.$business_id.'/'.$img_name; 

	$target=$dst.basename($img_name);	

	$result=$this->business_type->update_business_image_logo($business_id,$img_name); 

	if($result){

		$data=array('response'=>'success','business_id'=> $business_id,'img_name'=>$img_name);

		echo json_encode($data);

	}


 }

 

 public function resize($target,$image_data,$width,$height) {

		

		//$img = substr($image_data['full_path'], 51);

		$config['image_library'] = 'gd2';

		$config['source_image'] = $image_data['full_path'];

		$config['new_image'] = $target;

		$config['width'] = $width;

		$config['height'] = $height;



		//send config array to image_lib's  initialize function

		$this->image_lib->initialize($config);

		$src = $config['new_image'];

		$data['new_image'] = substr($src, 2);

		$data['img_src'] = base_url() . $data['new_image'];

		// Call resize function in image library.

		$this->image_lib->resize();

		// Return new image contains above properties and also store in "upload" folder.

		return $data;

	}



 public function delete_businesss_logo(){

 	$id=$this->input->post('data_id');

 	$result=$this->business_type->delete_logo($id);

 	if($result){

 		echo json_encode("success");

 	} else{

 		echo json_encode("failed");

 	}



 }

 public function business_sponsored() {

 	$zone_id = $this->input->post('zone_id');

 	$business_id = $this->input->post('business_id');

 	$result = $this->business_type->make_sponsered_business($zone_id,$business_id);

 	echo json_encode($result);

 	//echo json_encode($zone_id);

 }

 /**

 * Function to delete sponsor business

 */

 public function delete_business_sponsored() {

 	$zone_id = $this->input->post('zone_id');

 	$business_id = $this->input->post('business_id');

 	$result = $this->business_type->remove_sponsered_business($zone_id,$business_id);

 	echo json_encode($result);

 }

 public function get_subcategory_details(){

 	$zone_id = $this->input->post('zone_id');

 	$category_id = $this->input->post('category_id');

 	$category_list= $this->Category_new_model->fetch_subcategory_items($category_id,$zone_id);

 	echo json_encode($category_list);



 }



	



}











