<?php
namespace App\Controllers;
require_once APPPATH . "/Libraries/PHPMailer-master/src/PHPMailer.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/Exception.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/SMTP.php";
require_once FCPATH . 'dompdf/autoload.inc.php';
use App\Models\IonAuthModel;
use App\Models\Zips;
use Config\MyConfig;
use App\Models\Category_new_model;
use App\Models\Organization_model;
use App\Models\banner\Banner_model;
use App\Models\zone\Zone_model;
use App\Libraries\IonAuth;
use App\Controllers\CronController;
use App\Models\Users;
use App\Controllers\CommonController;
use App\Controllers\Zonedashboard;
use App\Models\admin\Sales_zone;
use App\Models\admin\Ads_model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;
#[\AllowDynamicProperties]
class BusinessSearch extends BaseController{
   	public function __construct(){
        $this->db = \Config\Database::connect();
        $this->cart = cart();
        $this->ion_auth = $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->Zips = new Zips();
        $this->Banner_model = new Banner_model();
        $this->Category_new_model = new Category_new_model();
        $this->CommonController = new CommonController();
        $this->SalesZone = new Sales_zone();
        $this->Zone_model = new Zone_model();
        $this->Users = new Users();
        $this->CronController = new CronController();
        $this->Organization_model = new Organization_model();
        $this->Ads_model = new Ads_model();
        $this->PHPMailer = new PHPMailer();
        $this->myconfig = new MyConfig;
    } 
	public function searchnew($zoneId){
		return redirect()->to(base_url().'/deals/'.$zoneId);
	}
	public function search($page = '') {
		// $this->notificationtousersnaptime();
    		$user_snap_settings = '';
		$amazonurl = $this->myconfig->AWSimageurl;
		$refdealuser = isset($_GET['dealrefer'])?$_GET['dealrefer']:''; 
		$referdealid = 0;
		$dealsuserid = '';
		if($refdealuser > 0){
			$qry = "select * from users where refer_code_link='".$_GET['dealrefer']."'";
			$dealuserdata = $this->CommonController->getStoreCache($qry,'row','businesssearchdealrefer',3600);
			$dealsuserid = isset($dealuserdata->id)?$dealuserdata->id:'';

			$qry = "select * from user_refer_meta where from_user='".$dealsuserid."'";
			$preuserdata = $this->CommonController->getStoreCache($qry,'row','businesssearchpreuserdata',3600);
 			$datainserted = isset($preuserdata->datainserted)?$preuserdata->datainserted:0;
 			if($datainserted == 0){
				$referdealid = 1;
			}
		}
		$urlsubcat = isset($_REQUEST['subcatid'])?$_REQUEST['subcatid']:'';
	    	$zoneId = $this->CommonController->redirectToBusiness();
	    	$zonedetails = $this->Zone_model->get_zone($zoneId,'businesssearchzonedetail'); 
		$subdomainZoneget =$zonedetails['subdomainZone'];
		if($page == 'groceryStore'){
			$url = $_SERVER['HTTP_HOST'];
			$urlArr = explode('.', $url);
			$zoneurlgrocery = 'https://'.$subdomainZoneget.'.'.$urlArr[1].'.'.$urlArr[2].'/'.$page;
			header("Location:".$zoneurlgrocery);
		}
	   	$current_date_time=date('Y-m-d');     
	   	$end_date_time=date('Y-m-d H:i:s',strtotime('+30 days',strtotime($current_date_time))) . PHP_EOL;
		$data = ['start_date' => $current_date_time,'end_date' => $end_date_time,'created_date' => $current_date_time,'status' => 'Live'];
	   	$this->CommonController->updateData('tbl_deals',$data,['zone_id' => $zoneId]);
	   	$loginzonename = $this->CommonController->getsinglecolumndata('sales_zone','subdomainZone','id',$zoneId);
	   	$loginzonenamenew = $this->CommonController->getsinglecolumndata('sales_zone','name','id',$zoneId);
 		if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
  			$pagesidebar = 'https://'.$loginzonename.'.savingssites.loc/';
		}else{
			$pagesidebar = 'https://'.$loginzonename.'.savingssites.com/';
		}

		$this->CommonController->getAutoLogin();
		$this->CronController->rankbusiness($zoneId);
 		$session_usertype = $session_session_normal_user_in_zone = $session_session_normal_user_type = $session_type = $session_type_id= $user_id = $email = $firstName = $lastName = $businessUser = $refferalcode = $session_session_type_id = $from_where = $username = $member_type = $baseloginUrl =  '';
		$business_theme = "blue"; 
		$business_page 	= 'Old Glory'; 

		$business_theme = 'green';//$this->CommonController->getCookie('business_sstheme');
		$business_page = 'Save Green';//$this->CommonController->getCookie('business_sstitle');
		
		$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
 		$segments = explode('/', rtrim($_SERVER['REQUEST_URI_PATH'], '/')); 	 
		$userId = $this->CommonController->getSession('user_id');
		
		if(count($segments) == 5){
 	    		$valid_referrer = $this->SalesZone->validate_referral($segments[4]);	 
 		   	if($valid_referrer == 1){
 		   		$refferalcode = $segments[4]; 
 		   	}
 		}
		
		if($this->CommonController->getCookie('business_sstheme')){
			$business_theme = $this->CommonController->getCookie('business_sstheme');
			$business_page = $this->CommonController->getCookie('business_sstitle');

			$business_theme = 'green';//$this->CommonController->getCookie('business_sstheme');
			$business_page = 'Save Green';//$this->CommonController->getCookie('business_sstitle');
		}
		
		if($this->ionAuth->loggedIn()){ 
			$auser = $this->ionAuth->user()->row();
			if(isset($_GET['dealrefer']) && $_GET['dealrefer'] > 0){
				$qry = "select * from users where refer_code_link='".$_GET['dealrefer']."'";
				$dealuserdata = $this->CommonController->getStoreCache($qry,'row','businesssearchdealrefer',3600);

				$dealsuserid = isset($dealuserdata->id)?$dealuserdata->id:'';
 				if($auser->id != $dealsuserid){
					$this->CommonController->get1dealreferdata($auser->id,$dealsuserid);
 				}
				$referdealid = 0;
			}
			if(!empty($auser)){ 
				$this->CommonController->setSession('get_email', $auser->email);
				$user_id = $auser->user_id;
				$email = $auser->email; 
				$firstName = $auser->first_name;
				$lastName = $auser->last_name;
				$businessUser = $auser;
				$username = $auser->username;
				$user_snap_settings = $auser->snap_status;
				$this->CommonController->SetCookie('user_id',$user_id,time()+86500,'','/','');
				if($this->CommonController->getSession('session_zoneid') !=''){
				$userzone_arr = $this->CommonController->getSession('session_zoneid');
				$loginzoneid = $userzone_arr['userzoneid'];
				$loginzonename = $this->CommonController->getsinglecolumndata('sales_zone','subdomainZone','id',$loginzoneid);
				$baseloginUrl = $this->CommonController->getzoneurlusingzone($loginzoneid);
			}
				
		}
		}

		if($this->CommonController->getSession('session_usertype') !=''){
			$session_usertype_arr = $this->CommonController->getSession('session_usertype');
			$session_usertype=$session_usertype_arr['usertype']; 
		}
		
		$check_zone_logo = $this->Banner_model->checkZonelogo($zoneId,'businesssearchzonelogo');
		$zone= $this->Zone_model->get_zone($zoneId);
		$announcements = $this->Organization_model->get_announcements_by_zone($zoneId,0,10,'businesssearchannouncements'); 
		$zone_owner = (object)$this->Users->get_user_details($zone['sales_rep_id'],'businesssearchuserdetail');
		$refferalcode = $this->CommonController->SelectDataMultiWay('others_referral_id','*','resultArray',array('zoneid'=> $zoneId));
		$user_type = $this->CommonController->getSession('session_login_details');
		$active_banner_mobile = $this->Banner_model->active_banner_desktopmobile($zoneId,'','2','2','busiesssearchactivebannermobile');
		$active_banner_desktop = $this->Banner_model->active_banner_desktopmobile($zoneId,'','2','1','busiesssearchactivebannerdesktop');
		$category_list_food = $this->Category_new_model->get_products_details($zoneId,1); 
		$theme_color = $this->SalesZone->changeTheme("all",$zoneId);
		$category_list = $this->Category_new_model->get_products_details($zoneId,0); 	
		$rows = count($this->cart->contents());
		ksort($category_list); 
		$combinefood = array_merge($category_list_food,$category_list);
		return view('businessSearch',array('zoneid'=> $zoneId,'zone_id'=> $zoneId,'subdomainZoneget'=>$subdomainZoneget,'zoneId'=> $zoneId, 'userid'=> $userId,'business_theme' => $business_theme,'business_page' => $business_page,'user_id' => $user_id,'email' => $email,'firstName' => $firstName,'lastName' => $lastName,'businessUser' => $businessUser,'refferalcode' => $refferalcode,'resultdata' => $refferalcode,'user_type' => $user_type,'session_usertype' => $session_usertype,'session_session_normal_user_in_zone' => $session_session_normal_user_in_zone, 'session_session_normal_user_type' => $session_session_normal_user_type,'active_banner_mobile' => $active_banner_mobile,'active_banner_desktop' => $active_banner_desktop,'category_list_food' => $category_list_food,'theme_color' => $theme_color,'zonedetails' => $zonedetails,'category_list' => $category_list,'rows' => $rows,'session_session_type_id' => $session_session_type_id,'from_where' => $from_where,'username'=>$username,'member_type' => $member_type,'combinefood' => $combinefood,'refer_code' => '','refferalcode' => '','count_banner' => '','barter_button' => '','job_button' => '','css_value' => '','zone_owner'=> $zone_owner,'announcements'=>$announcements,'check_zone_logo'=>$check_zone_logo,'urlsubcat'=>$urlsubcat,'referdealid'=>$referdealid,'dealsuserid'=>$dealsuserid,'amazonurl'=>$amazonurl,'baseloginUrl'=>$baseloginUrl,'pagesidebar'=>$pagesidebar,'user_snap_settings'=>$user_snap_settings,'loginzonenamenew'=>$loginzonenamenew));
 	}
	function is_in_array($array, $key, $key_value){
	      $within_array = 'no';
	      foreach( $array as $k=>$v ){
	        if( is_array($v) ){
	            $within_array = is_in_array($v, $key, $key_value);
	            if( $within_array == 'yes' ){
	                break;
	            }
	        } else {
	                if( $v == $key_value && $k == $key ){
	                        $within_array = 'yes';
	                        break;
	                }
	        }
	      }
	      return $within_array;
	}
	public function removeProductCart(){
    	$this->cart->remove($_REQUEST['dataremoveID']);
  		die;
	}

	public function addCart($zoneid){
		$existsqry = "select * from business_deal_approval where businessId=".$_REQUEST['busid']." AND userId=".$_REQUEST['dataUSerid']." AND zoneId=".$_REQUEST['dataZone'];
		$exists = $this->CommonController->SelectRawquery($existsqry, 'row');
		$statusapproval = isset($exists->status)?$exists->status:'';
		if($statusapproval == 'P' || $statusapproval == 'N'){
			echo json_encode(['msg'=>'Business Disabled By Zone Owner, Status Pending','type'=>'warning']);
			die;
		}
	    $insert_new = TRUE;
		$checkData = 'Select * from tbl_deals inner join tbl_deals_products on tbl_deals_products.deal_product_id = tbl_deals.product_id  where tbl_deals.deal_id ="'.$_REQUEST['dealid'].'" ';
		$checkData = $this->CommonController->getStoreCache($checkData,'resultArray','businesssearchaddcartcheckData',3600);

		$peekaboocredits = $this->Organization_model->getpeekaboocreditsofresidentuser($_REQUEST['dataUSerid'], $_REQUEST['dataZone']);
		$total_cost = number_format($checkData[0]['publisher_fee'],"2",".","");
		$bagCart = $this->cart->contents();
		foreach ($bagCart as $item) {
			$itemid = 'sku_'.$_REQUEST['dealid'];
			if ($item['id']==$itemid) {  
				$insert_new = FALSE;
			}
	        if($item['options']['zone'] != $_REQUEST['dataZone']){
	        	$this->cart->destroy();
	        }
	    }
		if($insert_new) {
			$deal_description = $checkData[0]['deal_description'];
			if($checkData[0]['deal_description'] == ''){
				$deal_description = $checkData[0]['deal_description_link'];
			}
			$checkDescription = str_replace("'","",$deal_description);
			$checkDescription = str_replace("&"," and ",$checkDescription);
			$data12 = array(
				'id' => 'sku_123ABC',
				'qty' => 1,
				'price' => $total_cost,
				'name' => $checkDescription,
				'options' => array(
					'dealid' => $_REQUEST['dealid'] , 
					'item' =>$_REQUEST['itemname'] , 
					'busid' =>$_REQUEST['busid'] , 
					'zone' =>  $_REQUEST['dataZone'] , 
					'cardimg'=> $checkData[0]['card_img'],
					'busid'=> $_REQUEST['busid'],
				)
			);
			$this->cart->insert($data12);
			$rows = count($this->cart->contents());
			echo json_encode($rows);
		}
	}
	
	public function addCartold($zoneid){
		$checkData = 'Select * from tbl_deals inner join tbl_deals_products on tbl_deals_products.deal_product_id = tbl_deals.product_id  where tbl_deals.deal_id ="'.$_REQUEST['dealid'].'" ';
		$checkData = $this->CommonController->getStoreCache($checkData,'resultArray','businesssearchaddcartoldcheckData',3600);
		$peekaboocredits = $this->Organization_model->getpeekaboocreditsofresidentuser($_REQUEST['dataUSerid'], $_REQUEST['dataZone']);
		$total_cost = number_format($checkData[0]['publisher_fee'],"2",".","");
		$insert_new = TRUE;
        	if($insert_new) {
        	if($checkData[0]['deal_description'] == ''){
        		$deal_desc = $checkData[0]['deal_description_link'];
        	}else{
        		$deal_desc = $checkData[0]['deal_description'];
			}
        	$checkDescription = str_replace("'","",$deal_desc);
			$checkDescription = str_replace("&"," and ",$checkDescription);
			$data12 = array(
				'id'      => 'sku_123ABC',
				'qty'     => 1,
				'price'   => $total_cost,
				'name'    => $checkDescription,
				'options' => array(
					'dealid' => $_REQUEST['dealid'] , 
					'item' =>$_REQUEST['itemname'] , 
					'busid' =>$_REQUEST['busid'] , 
					'zone' =>  $_REQUEST['dataZone'] , 
					'cardimg'=> $checkData[0]['card_img'],
				)
			);
			$this->cart->insert($data12);
			return 1;
		}
	}
   	
   	public function cart(){
   		$zoneid = $this->CommonController->redirectToBusiness();
   		$session_usertype = $session_session_normal_user_in_zone = $session_session_normal_user_type = $session_type = $session_type_id= $user_id = $email = $firstName = $lastName = $businessUser = $refferalcode = $session_session_type_id = $from_where = $username = $member_type = $userid = $zone_name = $zone_logo = $refer_code =  '';
   		$used_certificate = 1;
   		$final_data_sum = $maxvalue1 = 0;
    	$maxsubtotal = $paypal_info =$disAmountArr =  [];
		$theme = "blue"; 
		$page 	= 'Old Glory';
		$footer = 'zonefooter';
		$header = 'loginheader';
   		$userId = $this->CommonController->getSession('user_id'); 
		$total = count($this->cart->contents());
		if($total <= 0){
			return redirect()->to(base_url());	
		}

		$zone= $this->Zone_model->get_zone($zoneid);
		$zone_owner = (object)$this->Users->get_user_details($zone['sales_rep_id']);
		$check_zone_logo = $this->Banner_model->checkZonelogo($zoneid);
		$display_zone_details = $this->SalesZone->get_zone($zoneid);
		$zone_name = $display_zone_details->name;

		$discount = '';
		$sql = 'Select * from tbl_zone_discount where zoneid ="'.$zoneid.'"';
		$checkDiscount = $this->CommonController->getStoreCache($checkData,'resultArray','businesssearchcheckDiscount',3600);


		$sql = 'Select * from businesscreditcheck where user_id ="'.$userId.'" AND amount_used=0';
		$disamountqry = $this->CommonController->getStoreCache($sql,'resultArray','businesssearchdisamountqry',3600);
		if(count($disamountqry) > 0){
			foreach ($disamountqry as $k => $v) {
				$disAmountArr[$v['business_id']] = $v['dis_amount'];
			}
		}
		if(count($checkDiscount) > 0){
 			foreach (json_decode($checkDiscount[0]['discount']) as   $value2) {
				if($total >= $value2->value){      	   
					$discount =  $value2->key;
                }
            }
		}
		$free_cert = $this->CommonController->SelectDataMultiWay('users','free_cert','column',['id' => $userId],[],'',[]);;
		
		foreach ($this->cart->contents() as   $value) {
            if($zoneid == $value['options']['zone']){  
            	$maxsubtotal[] = $value['subtotal'];
        	}
        }
		if($total > 1 && $free_cert == 1){
    		$totalsum = array_sum($maxsubtotal);
    		$maxvalue1 = max($maxsubtotal);
    		$disdata = $totalsum-(($totalsum*$discount)/100);
    		$final_data_sum =$disdata - $maxvalue1;
    		$used_certificate = 1;
    	}else if($total > 1 && $free_cert > 1){
    		$totalsum = array_sum($maxsubtotal);
    		$disdata = $totalsum-(($totalsum*$discount)/100);
    		if($total == $free_cert){
    			$used_certificate = $free_cert;
    			// $final_data_sum = 0;
    			$final_data_sum =$disdata - $maxvalue1;
    			$maxvalue1 = $disdata+1.5;	
    		}else{
    			$a = $maxsubtotal;
				rsort($a);
				$largest = array_slice($a, 0, $free_cert);
				$maxvalue1 = array_sum($largest);
				$final_data_sum =$disdata - $maxvalue1;
				if($total > $free_cert){
					$used_certificate = $free_cert;	
				}else{
					$used_certificate = $free_cert- $total;
				}	
    		}
    	}
		
		if($this->ionAuth->loggedIn()){ 
			$auser = $this->ionAuth->user()->row();
			if(!empty($auser)){ 
				$user_id = $auser->user_id;
				$email = $auser->email; 
				$firstName = $auser->first_name;
				$lastName = $auser->last_name;
				$businessUser = $auser;
				$username = $auser->username;
			}
		}
		
		$get_paypal_info = $this->Zone_model->checkExistPaypalid($zoneid);
		if(count($get_paypal_info) > 0){
			$paypal_info = $get_paypal_info[0];
		}
		$cartdata = $this->cart->contents();
		/*get check deal discount amount*/
		$qry = "select * from users where id=".$user_id."";

		$dealcertdataArr = $this->CommonController->SelectRawquery($qry, 'row');
 		$dealcertamount = isset($dealcertdataArr->free_cert_amount)?$dealcertdataArr->free_cert_amount:0;
		/*get check deal discount amount*/
		return view('cart',['user_id' => $user_id,'email'=>$email,'firstName'=>$firstName,'lastName' => $lastName,'businessUser' => $businessUser,'username' => $username,'zoneid' => $zoneid,'userid'=> $userid,'theme' => $theme,'page' => $page,'header' => $header,'footer' => $footer,'zone_name' => $zone_name,'zone_id' => $zoneid,'zone_logo' => $zone_logo,'session_session_normal_user_type'=> $session_session_normal_user_type,'get_paypal_info' => $paypal_info,'free_cert' => $free_cert,'total' => $total,'maxvalue1' => $maxvalue1,'final_data_sum' => $final_data_sum,'final_data_sum'=> $final_data_sum,'cartdata' => $cartdata,'discount' =>$discount,'used_certificate' =>$used_certificate,'refer_code' => $refer_code,'zone_owner' => $zone_owner,'disAmountArr' => $disAmountArr,'dealcertamount' => $dealcertamount,'zone_name'=>$zone_name,'check_zone_logo'=>$check_zone_logo]);
   	}

    public function thankyou($busid,$zoneid){
		$userID = @$_GET["UserId"];
        $tokenId = @$_GET['PayerID'];
        $amountPaid = @$_GET['Amount'];
        $AucId =@$_GET['AucId'];


        $checkData = $this->db->query('Select * from tbl_deals_purchased where tokenId ="'.$tokenId.'"');

		   // prevent duplicate data
		   if($checkData->num_rows() == 0){

                // recording the history in DB 
				 $getCredits = "INSERT INTO tbl_deals_purchased (userId, zoneId, tokenId,busId , amountPrchased,dealId)
				VALUES ( '".$userID."', '".$zoneid."', '".$tokenId."', '".$busid."', '".$amountPaid."', '".$AucId."' );";

			    $getCreditsResult = $this->db->query($getCredits);


			    // if creditStatus = paid , then users has less credit and its paid in amount
			    //  if creditStatus = deduct, then credit need to be deduct from user credit

			    if(@$_GET['creditStatus'] == 'deduct'){
			    	
			    	$checkData = $this->db->query('UPDATE tbl_member SET views_credit=(views_credit-3) WHERE  user_id='.$userID);

			    }

			    //  updating the certificates

			    $concolation_certificatedetails = "SELECT a.numberofconsolation  , count(so.id)   as totalconsolationleft FROM tbl_deals_products a,  tbl_deals c , tbl_deals_purchased  so WHERE a.deal_product_id=c.product_id  and so.dealId =  c.product_id and a.deal_product_id=".$AucId;

		        $certificate_data = $this->db->query($concolation_certificatedetails);

		        
		        $certidcateleft_data = $certificate_data->row();

		        if($certidcateleft_data->numberofconsolation != -1 && $certidcateleft_data->numberofconsolation != 0){
		        	
		        	$this->db->query("UPDATE tbl_deals_products SET numberofconsolation= numberofconsolation - 1 WHERE deal_product_id=".$AucId);

		        }else if($certidcateleft_data->numberofconsolation == 0){

		         $this->db->query("UPDATE tbl_deals SET status='Closed' WHERE deal_id=".$AucId);

		        }


			   
                // giving free 3 credits to user

		        $checkData = $this->db->query('UPDATE tbl_member SET views_credit=(views_credit+3) WHERE  user_id='.$userID);
 

		   }
        $data['head'] 				= $this->load->view("businessSearch/head",$data); 

        $data['header'] 			= $this->load->view("businessSearch/header", $data);

       // $data['content'] 			= $this->load->view('businessSearch/search',$data);

       //$data['content'] 			= $this->load->view('businessSearch/slider',$data);

        $data['content'] 			= $this->load->view('businessSearch/new_slider',$data);

 		/*$data['content'] 			= $this->load->view('businessSearch/mslider',$data);*/

 		$data['content'] 			= $this->load->view('admin/thankyou',$data);

 		//$data['content'] 			= $this->load->view('directory',$data);

		$data['footer'] 			= $this->load->view("businessSearch/footer", $data);

		$data['modals'] 			= $this->load->view("includes/modals",$data); 
    }

 	public function embedlink($zoneId) { 

 		
 		$_SERVER['REQUEST_URI_PATH'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
 		$segments = explode('/', rtrim($_SERVER['REQUEST_URI_PATH'], '/'));
 		
 		$userId = $this->session->userdata('user_id'); 

		$data['link_path']			= $this->config->item('link_path');

    	$data['base_url'] 			= $this->config->item('base_url'); 		

 		$data['zoneid'] 			= $zoneId;

		$data['userid']				= $userId; 	

	    if(count($segments) == 5){
 	    	
 		 $valid_referrer = $this->sales_zone->validate_referral($segments[4]);	 
 		   if($valid_referrer == 1){
 		   	$data['refferalcode']	 = $segments[4]; 
 		   }
 		 
 		}

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

				$data['businessUser'] = $auser;


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


		$sql="select * from others_referral_id where zoneid=".$zoneId;

		$query=$this->db->query($sql);

	    $refferalcode = $query->result_array();

	    $data['resultdata']=$refferalcode[0];



		$data['user_type'] = $this->session->userdata("session_login_details");

    	$data['session_usertype']=$session_usertype; 

		$data['session_session_normal_user_in_zone']=$session_session_normal_user_in_zone;

		$data['session_session_normal_user_type']=$session_session_normal_user_type;

		//$data['active_banner'] 		= $this->banner->active_banner($zoneId,'','2');	

		$data['active_banner_mobile'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','2','2');

		$data['active_banner_desktop'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','2','1');

 		$data['category_list_food']	= $this->Category_new_model->get_products_details($zoneId,1); 



		$data['theme_color'] = $this->sales_zone->changeTheme("all",$zoneId);

 		$data['zonedetails']	= $this->get_zone->get_zone($zoneId); 

 		 



 		$data['category_list']		= $this->Category_new_model->get_products_details($zoneId,0); 	


		$data['head'] 				= $this->load->view("businessSearch/head",$data); 

        $data['header'] 			= $this->load->view("businessSearch/header", $data);

       // $data['content'] 			= $this->load->view('businessSearch/search',$data);

       //$data['content'] 			= $this->load->view('businessSearch/slider',$data);

        $data['content'] 			= $this->load->view('businessSearch/new_slider',$data);

 		/*$data['content'] 			= $this->load->view('businessSearch/mslider',$data);*/

 		$data['content'] 			= $this->load->view('businessSearch/offersembed',$data);

 		//$data['content'] 			= $this->load->view('directory',$data);

		$data['footer'] 			= $this->load->view("businessSearch/footer", $data);

		$data['modals'] 			= $this->load->view("includes/modals",$data); 
 	}

 	
 	public function getSubDropdown(){
 
		$zoneid = $_POST['zoneID'];
		$category_list_food=$this->Category_new_model->get_products_details_selected($_POST['zoneID'] ,$_POST['catid']); 
		 

		if(!empty($category_list_food)){   
		 $k=0; foreach($category_list_food as $key1=>$val1){
		$category=explode('#',$key1);

		  $html = '   ';            
		  $j=0;
            $count =0;

            foreach($val1 as $key2=>$val2){ 

                $subcat_arr = explode('#@#',$key2);

                $subcat_header = $subcat_arr[0] ;

                $subcat_headerid = $subcat_arr[1] ;

                $i=0; 

             if($subcat_header != 'attachment_image'){   

              if($count == '0'){

                 $html .= '<option class="show_ads_specific_category" href="javascript:void(0);" data-catid="'.$category[1].'"  rel="'.$category[1].'" id="'.$category[1].'" >Types of Businesses  </option>';
              } 
               if($subcat_header != '-100'){
               $html .=  '<option disabled="true" class="sub_heading_cat" ><h3 style="font-weight: bold;">'.$subcat_header.'</h3></option>';
           }

              }

             foreach($val2 as $key3=>$val3) { 

                 $sub_category=explode('#',$val3);

                 $i++;

             
                $html .=  '<option data-catid="'.$sub_category[1].'" rel="'.$sub_category[1].'" id="'.$sub_category[1].'"><a class="show_ads_specific_sub_category" href="javascript:void(0);" rel="'.$sub_category[1].'" id="'.$sub_category[1].'">'.$sub_category[0].' '.$sub_category[2].'</a></option>';               
 
            }
              
            $j=$i; 
           
           $count++;

            }  }   }  
            echo  $html;
       die();

   }

 	function moverssnapdeal()
 	{

 	$response_arr = array();
				
 	$userId = $_REQUEST['userId'];

 	$user_dataa = json_decode($_REQUEST['user_data']);

	$cell_phonee = $user_dataa->cell_phone;

	$phonee = $user_dataa->phone;

	$phonearr = array(0 =>preg_replace("/[^0-9]/", "", $cell_phonee),

						1=>preg_replace("/[^0-9]/", "", $phonee));

	$data['moversdetails'] 	= $this->ad->movers_details($phonearr);

	$data['check_business'] 	= $this->ad->check_business($createdbyid);

		if ($data['check_business']>0) {

			 		if ($data['moversdetails']!=0){

 			$data['mover_got_credit'] 	= $this->ad->mover_got_credit($createdbyid,$userId);

 			$response_arr['extra'] = $createdbyid." ".$userId." ".$data['mover_got_credit'];

 			if ($data['mover_got_credit']==0) {

 				$data['moversdetails'] 	= $this->ad->add_new_mover_credit($user_dataa->username,$user_dataa->email);

 			$response_arr['status'] = '1';

 			$response_arr['msg'] = "Congratulations 10 free Peekaboo credits have been added to your Peekaboo account. We have also added this business to your SNAP emailing list to have Savings Sites email their offers only if their offers meet your SNAP Filters. SNAP Filters can be set to meet your minimum discount percentage required and your time availability by clicking the SNAP Filter image in this ad.";

 			}else{

 				$response_arr['status'] = '1';

 			$response_arr['msg'] = "You already got credit from this business. We have turned SNAP Email status to ON” for this business. Your email will be protected as you will receive filtered offers from Savings Sites for this business. You can further filter your offers by your minimum discount requirement and time availability by clicking the SNAP image for this business.";

 			}

 			

 		}else{

 			$response_arr['status'] = '0';

 			$response_arr['msg'] = "Only new movers recently mailed a postcard receive free credits from this business, if your registered zip code matches the zip code the postcard was mailed to. We have turned SNAP Email status to ON” for this business. Your email will be protected as you will receive filtered offers from Savings Sites for this business. You can further filter your offers by your minimum discount requirement and time availability by clicking the SNAP image for this business.";

 		}

		}

		else{

			$response_arr['status'] = '0';

 			$response_arr['msg'] = "This business is not registered for movers. We have turned SNAP Email status to ON” for this business. Your email will be protected as you will receive filtered offers from Savings Sites for this business. You can further filter your offers by your minimum discount requirement and time availability by clicking the SNAP image for this business.";

		}

 		 echo json_encode($response_arr);

 	}

 	function getslider(){

 		$zoneId = $_REQUEST['zone_id'];

 		$data['zoneid'] 			= $zoneId;

 		$data['active_banner_mobile'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','2','2');

		$data['active_banner_desktop'] 	= $this->banner->active_banner_desktopmobile($zoneId,'','2','1');

 		$data['content'] 			= $this->load->view('businessSearch/slider',$data);

 		echo $data['content'];

 	}

	public function changetheme(){
		$this->CommonController->SetCookie('business_sstheme',$_REQUEST['business_theme'],time()+86500,'','/','');
		$this->CommonController->SetCookie('business_sstitle',$_REQUEST['business_title'],time()+86500,'','/','');
	}


	public function change_status_type(){
		$user_id=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
		$zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
		$createdby_id=!empty($_REQUEST['createdby_id']) ? $_REQUEST['createdby_id'] : 0;
		$type=!empty($_REQUEST['type']) ? $_REQUEST['type'] : 0;
		$status=!empty($_REQUEST['status']) ? $_REQUEST['status'] : 0; //var_dump($status);
		$adid=!empty($_REQUEST['adid']) ? $_REQUEST['adid'] : 0;		
		$result = $this->Ads_model->ad_to_favourites($adid, $user_id, $zone_id, $status);
		echo $result;
	}


 	

 	function new_email_offer_new(){

		

		$adId = $_REQUEST['adId'];

		$emailAddress = $_REQUEST['emailAddress'];

        session_start();

        

        $message_status = 1 ;

        

		$recArr = array();

        if(!empty($adId) && $adId > 0){

            $sql="select t1.adtext,t1.deal_description,t1.textmeoffer,t1.adtext,t1.id,t1.deal_title, t2.name as biz_name, t2.contactfirstname, t2.contactlastname, t2.contactemail , t3.zoneid from ads as t1 inner join business as t2 on t1.business_id = t2.id

			inner join ad_to_zone as t3 on t1.id = t3.adid where t1.id = ". $adId;

            $query = $this->db->query($sql);

            $result = $query->row();

            $result1=$query->row('id');

            $deal_description = !empty($result->deal_description) ? $result->deal_description : '';

            $adtext = !empty($result->adtext) ? $result->adtext : '';

//var_dump($deal_description);exit;

            $url_details = $this->ion_auth->meta_tag_details($result1); //var_dump($deal_description);exit;

            if(!empty($url_details)){

                if($url_details[0]['deal_title']!=''){

                    $data=array();

                    $data['business_name']=$url_details[0]['deal_title'];

                    $data['bsname']=$url_details[0]['business_name'];

                    $data['business_id']=$url_details[0]['business_id'];

                }

            }

            $deal_link = base_url().'short_url/index.php?deal_title='.$result->deal_title;

			//var_dump($result->deal_description);exit;

						/*if($result->deal_description==''){

						$_a='<p align="center" class="MsoNormal" style="text-align:center"><b><span style="font-size:18.0pt;color:#1f497d">We have not had a chance to post all our offers in the system-<br><br>Please Contact Us for Our Offer!</span></b><br><br><br><span style="color:#000;font-size:20px">If you would like SavingsSites to contact the business on your behalf to ask them to post their offer, </span><span style="font-size:18px"><a href="#starter-ad-popup" style="text-decoration:underline" class="starter_ad_click"><span style="color:red">click here</span></a></span></p>';

						}else{

						$_a=$result->deal_description;

						}*/

			if($message_status == 1){

			//$ad_text=urldecode(stripslashes($_a));

			//$ad_text= urldecode(stripslashes(strip_tags($_a))); var_dump($ad_text);exit;

				$ad_text=urldecode(stripslashes(str_replace("&nbsp;"," ",$deal_description)));

			// email sent

				$fromemail='DoNotReply@snap.deals';

				$email_subject=stripslashes($result->biz_name) . " Special Offer";

			////////////////////////////////////////// ++++++ change Email Format start //////////////////////////////////

				if($deal_description!=''){

					$message_body= '<body style="background-color:#FFF;font-family:Arial,Helvetica,sans-serif">

						<div style="width:960px;margin:0 auto!important">

						<div style="background-color:#f2f2f2;border-radius:4px;width:650px;margin:5px auto;padding:15px">

						<div style="background-color:#3f3f3f;height:70px"><img src="'.base_url('assets/images/logo_white.png').'" style="margin:10px 202px" alt="logo"/></div>

						<div style="clear:both"></div>

						<div style="background-color:#FFF;margin-top:10px;margin-bottom:10px;min-height:300px;padding:15px">

						<h2 style="text-align:left">Dear'." ".$emailAddress.

												'</h2><br><h3 style="text-align:left;display:block;color:#666">Below is the deal email you requested</h3><br>

						<h3><p style="text-align:left;display:block;color:#333">Posted By: '." ".stripslashes($result->biz_name) .'</p></h3>

						<h3><p style="text-align:left;display:block;color:#333">To see the Deal '.'<a target="_blank" href="'.$deal_link.'">CLICK HERE</a></p></h3><h3 style="text-align:left;display:block;color:#666">DEAL DESCRIPTION: </h3>

						<p style="text-align:left;display:block;color:#333"><h3 style="text-align:left">

						' .$ad_text.'</h3></p>

						</div>

						<div style="background-color:#999;height:60px"></div>

						</div>

						</div>

						</body>';

					}else{

						$message_body= '<body style="background-color:#FFF;font-family:Arial,Helvetica,sans-serif">

						<div style="width:960px;margin:0 auto!important">

						<div style="background-color:#f2f2f2;border-radius:4px;width:650px;margin:5px auto;padding:15px">

						<div style="background-color:#3f3f3f;height:70px"><img src="'.base_url('assets/images/logo_white.png').'" style="margin:10px 202px" alt="logo"/></div>

						<div style="clear:both"></div>

						<div style="background-color:#FFF;margin-top:10px;margin-bottom:10px;min-height:300px;padding:15px">

						<h2 style="text-align:left">Dear'." ".$emailAddress.

												'</h2><br><h3 style="text-align:left;display:block;color:#666">Below is the deal email you requested</h3><br>

						<h3><p style="text-align:left;display:block;color:#333">Posted By: '." ".stripslashes($result->biz_name) .'</p></h3>

						<h3><p style="text-align:left;display:block;color:#333">To see the Deal '.'<a target="_blank" href="'.$deal_link.'">CLICK HERE</a></p></h3>

						</div>

						<div style="background-color:#999;height:60px"></div>

						</div>

						</div>

						</body>';

					}

// $message_body= str_replace("&nbsp;"," ",$message_body);

////////////////////////////////////////// ++++++ change Email Format end //////////////////////////////////

                $this->load->library('email');

                $this->email->clear();

                $this->email->from($fromemail);

                $this->email->subject($email_subject);

                $this->email->message($message_body);

                if($emailAddress!=''){

                    $this->email->to($emailAddress);

                    $this->email->send();

                    $to[]=$emailAddress;

                }

                $message = "Successfully Sent!";

				$recArr['message'] = $message;

				$recArr['get_login_details'] = $url_details;

            }else{

                $message = "Message not sent, Wrong Captcha!";

            }
 
			
			echo json_encode($recArr);

        }      

    }

    public function checkEmail($userId = '',$businessId = '',$type = 0){
		$userId = isset($_REQUEST['userId'])?$_REQUEST['userId']:$userId;
 		$businessId = isset($_REQUEST['businessId'])?$_REQUEST['businessId']:$businessId;
 		$data = $this->CommonController->SelectDataMultiWay('businesscreditcheck','credit','rowArray',['user_id' => $userId,'business_id' => $businessId],[],'',[]);
 		if(is_array($data)){
 			$data = $data['credit'];
 		}else{
 			$data = 0;
 		}
 		if($type == 1){
 			return $data;
 		}else{
			echo json_encode(array('type' => 'success','msg' => 'already sent a mail','data' => $data));
 		}
 	}
	
	public function sendEmail($zoneid = '',$userid = '',$busid = '',$busname = '',$via = '', $action = 0,$check= 1){
		$emailArr = [];
 		$zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:$zoneid;
		$userId = isset($_REQUEST['userId'])?$_REQUEST['userId']:$userid;
 		$businessId = isset($_REQUEST['businessId'])?$_REQUEST['businessId']:$busid;
 		$businessname = isset($_REQUEST['businessname'])?$_REQUEST['businessname']:$busname;
 		$check = $this->checkEmail($userId,$businessId,1);
 		if($check == 1){
 			echo json_encode(array('type' => 'success','msg' => 'Email Sent','data' => $check));
 			die;	
 		}
 		/*check communication method*/
		$commmethodsql="select * from business where id=".$businessId;

		$commres = $this->CommonController->SelectRawquery($commmethodsql, 'row');
 		if($via != 'functioncall'){
 			$comm_method = isset($commres->comm_method)?$commres->comm_method:''; // 1 = email 2 = phone
 		}else{
 			$comm_method = $action; // 1 = email 2 = phone
 		}
 		$comm_business_owner_id = isset($commres->business_owner_id)?$commres->business_owner_id:''; // 1 = email 2 = phone
		/*query start*/
 		$joinArr[] = ['table' => 'tbl_member as b','link' => 'a.username = b.user_name','type' => 'left'];
		$user = $this->CommonController->SelectJoinMulti('users as a', $joinArr,['a.id'=>$userId],[],[],'a.*,b.*','','','',[],'row','');
		/*query start*/
 		if($comm_method == ''){
 			$msg = $this->sendemailtozoneowner($commres,$zone_id);
 			echo json_encode($msg);
 			die;
 		}
		if($comm_method == 2){
			$this->CommonController->deleteData('business_deal_approval',['businessId'=>$businessId]);
			$this->approvalstatus($user->id,$user->first_name,$user->last_name,$businessId,$businessname,'P',$zone_id);
 			$this->buisnessIVRcall($zone_id,$userId,$businessId,$businessname,$check,$comm_business_owner_id);
 			echo json_encode(['msg'=>'Please wait we will call Business shortly','type'=>'success']);
 			die;
 		}
 		/*check communication method*/
		/*check aws smtp configure*/
 		$sql="select * from tbl_keys_awssmtp where zoneid=".$zone_id;
 		$awsres = $this->CommonController->SelectRawquery($sql, 'resultArray');
		/*check aws smtp configure*/

 		
 		/*get publisher data*/
 		$sql="select seo_zone_name from sales_zone where id=".$zone_id;
 		$seo_zone_name = $this->CommonController->SelectRawquery($sql, 'row')->seo_zone_name;;
 		
		/*get publisher data*/

 		/*get customer and business email*/
 		$bus = $this->CommonController->SelectDataMultiWay('business','*','rowArray',['id'=>$businessId]);
 		$emailcount = $bus['emailLimit'];

		/*get multiple emails to send*/
        $query = 'SELECT email FROM business_multiple_emails where `zoneid`= '.$zone_id.' and	`businessid`= '.$businessId;
        $multiemail = $this->CommonController->SelectRawquery($query, 'resultArray');
 		
		foreach ($multiemail as $k => $v) {
       		$emailArr[] = $v['email'];
       	}
       	if(count($emailArr) > 0){
       		$businessemil = implode(',', $emailArr);	
       	}else{
			$businessemil = $bus['contactemail']; 
       	}
        /*get multiple emails to send*/
        $customeremail = $user->email;
 		$customerusername = $user->username;
 		$creditbalance = $user->balance;
 		$link = "<a href='https://www.foodordersavings.com'>www.foodordersavings.com</a>";
 		/*get customer and business email*/
 		$fromemail="donotreply@hgd.deals";
 		$sub = 'Hi I’m '.$user->first_name.' '.$user->last_name.'. At no cost, promote your business in a new Town Newspaper/ Business directory.'; 

 		$body = '<div style="color:#000;background: #fff;width: 70%;margin: 50px auto;padding: 11px;border: 1px solid #ccc;font-size: 14px;line-height: 26px;box-shadow: 0px 1px 11px rgb(111 110 122 / 52%);"><div style="text-align: center;background: #f2f2f2;padding: 17px;margin-bottom: 20px"><img style="width: 240px;" src="https://cdn.savingssites.com/logo-green.png"/></div><p style="color:#000;font-size:20px;font-weight:700;margin:0px;padding:0px;">Dear '.$businessname.'</p>
 		<div style="color: #000;font-size: 17px;line-height: 28px;"> 
 		<br>
 		At no cost, and on a month-to-month commitment, please approve participation in an innovative new community Business Directory. It was developed by the largest email data company in the USA, which is partners with Microsoft, Amazon, QuickBooks, Fiserv, etc. <br>

 		<ul>
		  <li>Opted-in emails from over "90%" of all homes and businesses have already been collected to promote your business at no cost</li><br>
		  <li>Also, the municipality, schools, nonprofits, residents, and local supermarkets are all being compensated to promote local businesses. A huge number of local restaurants, including yours, is already listed. </li>
		  <li>At NO COST, your business also receives thousands of dollars per month in valuable benefits:</li>
		    <ol type="A">
			  <li>Free unlimited emailing,</li>
			  <li>Free online ordering with customer data collected, powered by our partner Amazon.</li>
			  <li>Free promotion of your daily specials. </li>
			  <li>Access to a daily feed of new movers that normally costs $1,000 a month!</li>
			  <li>Mobile responsive website.</li>
			  <li>much more! </li>
			</ol>
		</ul><br>
		<h3>How it Works: </h3><br>
		Instead of your business providing local nonprofits with outright donations, the following innovative solution has been developed. Everyone Benefits!
		<ul>
		  <li>Your business has no money out of pocket and no risk! </li>
		  <li>No time commitment!</li>
		  <li>You supply on a month-to-month basis a very small number of deals to help the local nonprofits raise money. </li>
		  <li>You’re paid for your services directly by customers.</li>
		  <li>Residents/local employees (buyers) pay the directory publisher a donation claiming fee to access your deal. We share that deal access fee with the nonprofit chosen by the buyers.</li>
		  <li>Our admin dashboard will give you access to a detailed tracking system with your customers’ contact data.</li>
		  <li>Because the buyers must pay your business a certain minimum to obtain the full discount, your average transaction is now increased!</li>
		  <li>Because there is no discount above the deal value the actual discount percentage you supply is much less than what appears. </li>
		  <li>To make sure you’re not just giving a discount to existing customers, we charge first-time customers of your business $5 less to access your deals.</li>
		  <li>Mobile responsive website! You can add images, upload a menu, etc. Use hundreds of social media networks!</li>
		  <li>Free referred orders powered by Amazon.</li>
		</ul><br>
		<h3><center>HUGE MARKETING PUSH:</center></h3><br>
		<ul>
		  <li><b>Nonprofits:</b> The local nonprofits are emailing members and imploring them to pay the Directory publisher a "donation claiming fee" to get access to deals. Save by Giving! Members are aware that their favorite nonprofit gets a report each month, showing who is buying deals to help the nonprofit! Members therefore buy the deals to get off the sh*t list and onto the nonprofits good list!</li><br>
		  <li><b>Municipal Promotion:</b> The municipalities are normally subjected to Open Public Records Act disclosure laws in which residents email addresses must be provided to anyone at no cost! Working with our partners Microsoft and Amazon we have developed a way to protect the residents’ email data from forced disclosure. We also substantially increase the municipalities’ ability to contact residents by email! We provide this incredible municipality benefit at NO COST!</li><br>
		  <li><b>Residents Promotion:</b> Residents are compensated to email others or post on social media to get others to buy access to the deals.</li><br>
		  <li><b>Supermarkets:</b> We promote supermarkets daily, weekly, and monthly specials! In exchange the supermarkets put a banner in their entrance that says it is a proud supporter of the new community fundraising system. The banner promotes the directory website. Massive directory promotion is quickly obtained.</li><br>
		  <li><b>Activities/Entertainment Search:</b> The municipalities, schools, nonprofits, private businesses all freely promote activities, events, entertainment. Residents at no cost can search for all the fun things to do! It causes huge website traffic!</li><br>
		  <li><b>New Movers:</b> Daily new mover deed recordings are mailed and emailed to promote the Town Newspaper / Business Directory.</li>
		</ul><br>

		<b>Build Your Free Email List:</b><br> We give you a page that does not promote any other business and does not promote any deal. Restaurants use this with in restaurant customers or delivery to get the residents to opt-into your free email list.<br>
		<b>NO ABUSE!!!</b><br>
        Your business is presented with the deal and a simple button on the user’s phone or in your online admin dashboard will record and verify only one-time use! All the customer data appears in your admin dashboard.<br>
        <b>Please Approve Participation:</b><br> 
         A suggested deal for your business is already on the website and it shows the maximum number of buyers allowed for the month. You can decide to increase the number of deals if deals are sold out.<br> 

 			Home Site: <a href="'.base_url().'/zone/'.$user->Zone_ID.'">'.base_url().'/zone/'.$user->Zone_ID.'</a><br> 
 			Deals Site <a href="'.base_url().'/deals/'.$user->Zone_ID.'">'.base_url().'/deals/'.$user->Zone_ID.'</a><br>
        <b>Please Approve </b><br>
        <a href="'.base_url().'/approvalstatus?userid='.$user->id.'&userfname='.$user->first_name.'&userlname='.$user->last_name.'&businessid='.$businessId.'&businessname='.$businessname.'&status=A&zoneId='.$zone_id.'" style="color: #fff;text-align: center;margin: 0 auto;width: 236px;display: block;position: relative;top: -17px;text-decoration: none;font-size: 26px;font-weight: 700;background: #15c;padding: 10px;border-radius: 4px;">Approve</a><br>
			<br>

			If you’re not ready to approve participation, email your questions to the directory publisher:<br> 

		    Resident Name: '.$user->first_name.' '.$user->last_name.'<br>
		    Resident Email: '.$user->email.'<br>
		     Thank you! <br>
			
				<div style="background: #000;color: #fff;text-align: center;padding: 1px 0 1px;line-height: 0;margin-top: 15px;"><p>© 2023 SS Businesses Search . All Rights Reserved.</p>
				</div>';

		if(count($awsres) > 0){
			$emailArr1 = explode(',',$businessemil);
			foreach ($emailArr1 as $e) {
				$send = $this->awsemail($awsres[0]['username'],$awsres[0]['password'],'email-smtp.'.$awsres[0]['region'].'.amazonaws.com',587,$awsres[0]['email'],$e,$sub,$body,$emailcount);
			}
		}else{
			if($emailcount < 100){
				$send = $this->CommonController->SendMail($fromemail,$businessemil,$sub,$body);
			}
		}
		if($send > 0){
			// if(count($awsres) > 0){
			// 	$senduser = $this->awsemail($awsres[0]['username'],$awsres[0]['password'],'email-smtp.'.$awsres[0]['region'].'.amazonaws.com',587,$awsres[0]['email'],$customeremail,'Credit Reward','Congratulations<br>You Have earned 3 Credit',1);
			// }else{
			// 	$senduser = $this->CommonController->SendMail($fromemail,$businessemil,$sub,$body);
			// 	// $senduser = $this->CommonController->SendMail($fromemail,$customeremail,'Credit Reward','Congratulations<br>You Have earned 3 Credit');
			// }
			// if($senduser > 0){
			// 	if($check == 0){
			// 		$insertArr = array('user_id' => $userId,'business_id' => $businessId,'credit' => 1,'dis_amount' => 3,'amount_used'=>0,'createdAt'=>date('Y-m-d'));
			// 		$this->CommonController->updateData('tbl_member',array('balance'=> $creditbalance+1),['user_name' =>$customerusername]);
			// 		$this->CommonController->InsertData('businesscreditcheck', $insertArr);
			// 		if($emailcount < 100){
			// 			$this->CommonController->updateData('business',array('emailLimit'=>$emailcount+1),['id' =>$businessId]);	
			// 		}
			// 	}

			
			// 	echo json_encode(array("type" => "success","msg" => "Email Sent"));

			// } 
		}else{
			echo json_encode(array("type" => "warning","msg" => "Email Not Sent"));
		}
 	}
	
	public function sendemailtozoneowner($busArr,$zone_id){
		$busid = isset($busArr->id)?$busArr->id:'';
		$busname = isset($busArr->name)?$busArr->name:'';
		$existsqry = "select * from email_zone_owner where business_id=".$busid." AND zone_id=".$zone_id;

		$exists = $this->CommonController->SelectRawquery($existsqry, 'count');
 		
 		if($exists > 0){
 			return ['msg'=>'Communication Method Not define by Zone Owner','type'=>'warning'];
 		}
		$bususerqry = "select * from sales_zone where id=".$zone_id;
		$commres = $this->CommonController->SelectRawquery($bususerqry, 'row');
 		$salesid = isset($commres->sales_rep_id)?$commres->sales_rep_id:'';
 		$bususerqry1 = "select * from users where id=".$salesid;

 		$commres1 = $this->CommonController->SelectRawquery($bususerqry1, 'row');
 		$emailzone = isset($commres1->email)?$commres1->email:'';
 		$insertArr = array('business_id' => $busid,'business_name' => $busname,'zone_id' => $zone_id,'methodemail' => 1,'date'=>date('Y-m-d'));
 		$subject= 'I’m your Buisness Owner "'.$busname.'" Please Set Communication Method For DPA program';
 		$body = 'I’m your Buisness Owner '.$busname.' Please Set Communication Method For DPA program. So i am participate in DPA program'; 
 		$send = $this->CommonController->SendMail('',$emailzone,$subject,$body);
 		$res = $this->CommonController->InsertData('email_zone_owner', $insertArr);
 		if($res > 0){
 			return ['msg'=>'Email Send to Zone Owner waiting for Approval','type'=>'success'];
 		}
	}

 	public function buisnessIVRcall($zone_id,$userId,$businessId,$businessname,$check,$bususerid){
 		$sql = "SELECT * FROM twilioZoneAccount WHERE zoneid='".$zone_id."'";
 		$arr = $this->CommonController->SelectRawquery($sql);
		if(count($arr) > 0){
			$twiliossid = $arr[0]['twiliossid'];
			$twilioauthtoken = $arr[0]['twilioauthtoken'];
			$twiliophoneno = $arr[0]['twiliophoneno'];
			$twilioflowid = $arr[0]['twilioflowid'];
			$saql = "SELECT * FROM users WHERE id='".$bususerid."'";
            		$arr1 = $this->CommonController->SelectRawquery($saql,'row');

			$busphone = '+91'.$arr1->username;
			$this->generatePDF($busphone,$zone_id);
			header("Access-Control-Allow-Origin: *");
			$tonumber = $busphone;
			$fromnumber = $twiliophoneno;
			$url = 'https://studio.twilio.com/v2/Flows/'.$twilioflowid.'/Executions';
			$curl = curl_init();
			$public_key = $twiliossid;
			$private_key = $twilioauthtoken;
		
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => "To=".$tonumber."&From=".$fromnumber."",
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_HTTPHEADER => array(
					"Content-Type: application/x-www-form-urlencoded",
					"Authorization: Basic ".base64_encode($public_key.":".$private_key)
				),
			));
			$response = curl_exec($curl);
			curl_close($curl);
		}
	}

	public function generatePDF($phoneno = '+919888198501', $zoneid = ''){
       	$phone = substr($phoneno, -10);
        $joinArr[] = ['table' => 'tbl_member as b','link' => 'a.username = b.user_name','type' => 'left'];
        $user = $this->CommonController->SelectJoinMulti('users as a', $joinArr,['a.username'=>$phone],[],[],'a.*,b.*','','','',[],'row','');
        $sqlprefer = 'select * from business where business_owner_id='.$user->id.'';
        $rprefer = $this->CommonController->SelectRawquery($sqlprefer,'row');
        $businessId  = $rprefer->id;
        $businessname = $rprefer->name;
        $link = "<a href='https://www.foodordersavings.com'>www.foodordersavings.com</a>";
        // $html = '<div>I’m your customer '.$user->first_name.' '.$user->last_name.' Please help the nonprofits raise money.</div>'; 

        $html = '<div style="color:#000;background: #fff;width: 100%;margin: 0px auto;padding: 0px;font-size: 14px;line-height: 26px;"><div style="text-align: center;background: #f2f2f2;padding: 17px;margin-bottom: 20px"><img style="width: 240px;" src="'.base_url().'/assets/directory/images/logo-green.png"/></div><p style="color:#000;font-size:20px;font-weight:700;margin:0px;padding:0px;">Dear '.$businessname.'</p><div style="    color: #000;
    font-size: 17px;
    line-height: 28px;"> No Cost!!! I want you to take part in a new Community project.<br> It’s a combination Town Information Business Directory.

            Home Site: <a href="'.base_url().'/zone/'.$user->Zone_ID.'">'.base_url().'/zone/'.$user->Zone_ID.'</a>
            Deals Site <a href="'.base_url().'/deals/'.$user->Zone_ID.'">'.base_url().'/deals/'.$user->Zone_ID.'</a>
            Your Site <a href="'.base_url().'/business/businessdetail/'.$businessId.'/'.$user->Zone_ID.'">'.base_url().'/business/businessdetail/'.$businessId.'/'.$user->Zone_ID.'</a>

            Free promotion of your deals by municipality, nonprofits, and directory publisher.Helps many local nonprofits raise funds and helps the municipality. ree referred orders powered by Amazon. See '.$link.'

            All the restaurants are already listed with a suggested deal, which you can change. They are only asking you to approve a limited number of deals to help the local nonprofits.

            Opted-in emails from over "90%" of all homes and businesses have already been collected. Massive promotion of your business will soon be starting.

            You are only going to get emailed requests to participate from only 100 residents. Without the 100 cap you would get a massive number of emails! Huge Exposure! No Marketing Cost!

            See the many restaurants <a href="'.base_url().'/zone/'.$user->Zone_ID.'">'.base_url().'/zone/'.$user->Zone_ID.'</a>" and their suggested deal is already there waiting for your approval before official launch. The number of deals is substantially limited.

            The publisher and nonprofits are also giving an additional $5 out of their fee to incentivize residents to try different restaurants. So, you’re not just giving a discount to existing customers.
            
            How It Works: Your business has no money out of pocket and no risk!
            
            Many local nonprofits are emailing their members and telling nonprofit members to pay the Directory publisher a "donation claiming fee" to get access to your discounted cash certificate.<br>
            
            The Directory publisher and the nonprofits share that donation claiming fee!<br>
            
            Your business is presented the cash certificate and a simple button on the phone records and verifies one time use. All the data shows up in your admin dashboard.
            
            Your paid directly by customers. A detailed tracking system gives you access to all customers contact data.
            
            Unlimited Free Emails! No time commitment! Mobile responsive website! You can add images, upload a menu, etc. Use hundreds social media networks
            
            Your business has always helped nonprofits with outright donations. But now with this fundraiser you have no money out of pocket! Everyone Benefits! Just email the directory publisher and say your business would be happy to help the local nonprofits by donating a limited number of deals.<br>

            Publisher Name: '.$user->first_name.' '.$user->last_name.'<br>
            Publisher Email: '.$user->email.'<br>
            
            Thank you for supporting the local nonprofits!<br>
            '.$user->first_name.' '.$user->last_name.'<br>'.$user->post_code.'</p></div>';

            $dompdf = new Dompdf();
            $dompdf->load_html($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

        	$destination_path = '/home/savingssites/public_html/assets/SavingsUpload/Twilio/'.$zoneid.'/PDF/';
        	// if(is_dir($destination_path)==false){mkdir($destination_path,0777);}
        	// file_put_contents($destination_path .$zoneid.'.pdf', $dompdf->output());
       		// copy($output, $destination_path .$zoneid.'.pdf');
    }


	public function awsemail($usernameSmtp,$passwordSmtp,$host,$port,$sender,$recipient,$subject,$html,$emailcount){
 		if($emailcount < 100){
			$senderName = 'SavingsSites';
			$mail_aws = $this->PHPMailer;
 			$mail_aws->isSMTP();
			try {
				$mail_aws->isSMTP();
	    		$mail_aws->setFrom($sender, $senderName);
	    		$mail_aws->SMTPOptions = array(
		    		'ssl' => array(
		        		'verify_peer' => false,
		        		'verify_peer_name' => false,
		        		'allow_self_signed' => true
		    		)
				);
				$mail_aws->Username   = $usernameSmtp;
	    		$mail_aws->Password   = $passwordSmtp;
	    		$mail_aws->Host       = $host;
	    		$mail_aws->Port       = $port;
	    		$mail_aws->SMTPAuth   = true;
	    		$mail_aws->SMTPSecure = 'tls';
				$mail_aws->addAddress($recipient);
	    		$mail_aws->msgHTML(true);
	    		$mail_aws->Subject    = $subject;
	    		$mail_aws->Body       =  $html;
	    		$mail_aws->CharSet="UTF-8";
	    		$mail_aws->Send();
	    		return 1;
	    	} catch (phpmailerException $e) {
	    		echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
	    	} catch (Exception $e) {
	    		echo "Email not sent. {$mail_aws->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
			}
		}else{
			return 1;
		}
 	}


	
	public function getfavres(){

 		$userId = $_REQUEST['userId']?$_REQUEST['userId']:'';
 		$restaurant = $_REQUEST['businessId']?$_REQUEST['businessId']:'';
 		
 		if($restaurant != ''){
 			$resArr = $this->CommonController->SelectDataMultiWay('users_favorites_restaurant as a','*','resultArray',['a.userid'=> $userId,'a.restaurant' => $restaurant],[], '',[]);
        }else{
			$resArr = $this->CommonController->SelectDataMultiWay('users_favorites_restaurant as a','*','resultArray',['a.userid'=> $userId],[], '',[]);
        }
		
		if(count($resArr) > 0){
			foreach ($resArr as $key => $v) {
        		$resArr[$key]['fav_edittitle'] = 'yes';
            	if($v['fav_title'] == ''){
                	$this->db->select('content');
            		$this->db->from('menu_builder_multi_lang');
            		$this->db->where('foreign_id', $v['fav_res']);
            		$this->db->where(['model'=>'pjProduct','field' => 'name']);
            		$query = $this->db->get()->row();
            		$resArr[$key]['fav_title'] = $query->content;
        			$resArr[$key]['fav_edittitle'] = 'no';
            	}
            	
            	$resArr[$key]['restaurant'] = $this->CommonController->SelectDataMultiWay('business','name','column',['id'=> $v['restaurant']],[], '',[]);  
        	}
        }else{
        	$resArr = [];
        }
		echo json_encode($resArr);
        die;
 	}

 	public function approvalstatus($userid = '',$first_name = '',$last_name = '',$businessId = '',$businessname = '', $status = '',$zoneId = '',$via = '',$click = 0){
 		$userid= isset($_REQUEST['userid'])?$_REQUEST['userid']:$userid;
 		$userfname= isset($_REQUEST['userfname'])?$_REQUEST['userfname']:$first_name;
 		$userlname= isset($_REQUEST['userlname'])?$_REQUEST['userlname']:$last_name;
		$businessid = isset($_REQUEST['businessid'])?$_REQUEST['businessid']:$businessId;
 		$businessname= isset($_REQUEST['businessname'])?$_REQUEST['businessname']:$businessname;
 		$status= isset($_REQUEST['status'])?$_REQUEST['status']:$status;
 		$zoneId= isset($_REQUEST['zoneId'])?$_REQUEST['zoneId']:$zoneId;
 		$via= isset($_REQUEST['via'])?$_REQUEST['via']:$via;
 		$click= isset($_REQUEST['click'])?$_REQUEST['click']:$click;
 		$existsqry = "select * from business_deal_approval where businessId=".$businessid." AND userId=".$userid;
 		$exists = $this->CommonController->SelectRawquery($existsqry, 'row');
 		if($via == 'QR'){
 			$businessname = base64_decode($businessname);	
 		}
 		if($exists != ''){
 			$click = isset($exists->click)?$exists->click:0;
 			if($click == 0){
				$this->CommonController->updateData('business_deal_approval',array('status'=>$status,'updated_at'=>date('Y-m-d'),'click'=>1),['userId' =>$userid,'businessId'=>$businessid]);
 			}
		}else{
			$this->CommonController->InsertData('business_deal_approval', 
 				[
 					'userId'=>$userid,
 					'userfname'=>$userfname,
 					'userlname'=>$userlname,
 					'businessId'=>$businessid,
 					'businessname'=>$businessname,
 					'status'=>$status,
 					'zoneId'=>$zoneId,
 					'via'=>$via,
 					'updated_at'=>'',
 					'click'=>$click
 				]
 			);
		}
		$this->sendemailtoresident($userid,$businessname);
		return redirect()->to(base_url());
	}
 	
	public function sendemailtoresident($userid,$businessname){
	    $sql = "SELECT * FROM users WHERE id LIKE '%".$userid."%'";
	    $data = $this->CommonController->SelectRawquery($sql,'rowArray');

	    $getemail = $data; 
	    $first_name=$getemail['first_name'];
	    $last_name=$getemail['last_name'];
	    $zone_id=$getemail['Zone_ID'];
	    $resd_email=$getemail['email'];
	    $sqlzone = "SELECT * FROM sales_zone WHERE id='".$zone_id."'";
	    $datazone = $this->CommonController->SelectRawquery($sqlzone,'row');

	   	$zonename = $datazone->subdomainZone;
	    $zonedealname = $datazone->subdomain;
	    $fromemail = 'donotreply@hgd.deals';
	    
            $sub = "Hey ".$first_name.' '.$last_name."  Quick ".$businessname." just approved a limited number of deals.";

            $body= "<div style='color:#000;background: #fff;width: 70%;margin: 50px auto;padding: 11px;border: 1px solid #ccc;font-size: 14px;line-height: 26px;box-shadow: 0px 1px 11px rgb(111 110 122 / 52%);'><div style='text-align: center;background: #f2f2f2;padding: 17px;margin-bottom: 20px'><img style='width: 240px;' src='https://cdn.savingssites.com/logo-green.png'/></div><br><br>
            Hey ".$first_name.' '.$last_name."<br><br> 

            ".$businessname." has just approved participation with a very limited number of cash certificate deals.<br>

            Login Link:<a href='https://".$zonename.".savingssites.com'>https://".$zonename.".savingssites.com</a><br>
            Deal Link: <a href='https://".$zonedealname.".savingssites.com'>https://".$zonedealname.".savingssites.com</a><br>
            <br>   

            Since you clicked the Free $5 button, you’ll now get an extra $5 discount for first time use! However, everyone who clicked the Free $5 button is also being alerted that this business has just approved participation! So, act quickly and grab one of the cash certificates deals now, before they’re sold out!<br><br>  


            Thank you for helping support your favorite nonprofit!<br> 

            Also remember, your cash certificate purchases are enabling your municipality to email residents unlimited valuable updates, with none of your taxpayer money used! Additionally, your email address is not being subjected under the OPEN PUBLIC RECORDS ACT law to disclosure to anyone!<br>

             
            Please thank the business for participating, which enables all these benefits! <br><br>  

            Enjoy the savings!<br>
            <div style='background: #000;color: #fff;text-align: center;padding: 1px 0 1px;line-height: 0;margin-top: 15px;'><p>© 2023 SS Businesses Search . All Rights Reserved.</p></div>";
        
       
	    $send = $this->CommonController->SendMail($fromemail,$resd_email,$sub,$body);//$get_email mail
	   
	}

	public function deal($refercode){
		$url = $_SERVER['SERVER_NAME'];
        $parsedUrl = parse_url($url);
        $host = explode('.', $parsedUrl['path']);
        $subdomain = $host[0];
        $zonename = $subdomain;
        $sql = "SELECT * FROM sales_zone WHERE subdomainZone LIKE '%".$zonename."%'";
        $data = $this->CommonController->SelectRawquery($sql,'row');

        if($data == ''){
        	throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        	die;
        }
        $name = isset($data->subdomain)?$data->subdomain:'';
		return redirect()->to('https://'.$name.'.savingssites.com?dealrefer='.$refercode);
	}
	
	public function grocery_Store(){
		$grocerystore = 1;
		$zoneid = $this->CommonController->redirectToZone();
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header = 'zoneheader';
        $footer = "homefooter";
        $show = 'hide';
       	$zone_name = $uid = $first_name = $last_name = $residentlat = $residentlng = $zip_code = $user_id = $refer_code = $zone_owner = $hide = $session_session_normal_user_in_zone = $session_session_normal_user_type = $firstName = $lastName = '';
		$user = $this->ion_auth->user()->row();
        $zone= $this->Zone_model->get_zone($zoneid);
	  	$zone_owner = $this->ion_auth->user($zone['sales_rep_id'])->row();
	  	$check_zone_logo = $this->Banner_model->checkZonelogo($zoneid);
		if(!empty($user)){ 
			$hide = 'hide';
			$show = '';
			$uid = $user->id;
			$first_name = $user->first_name;
			$last_name = $user->last_name;
			$residentlat = $user->latitude;
			$residentlng = $user->longitude;
			$zip_code = $user->Zip;
		} 
		
		if($residentlat == '' || $residentlng == ''){
			if($zip_code == ''){
				$user_ip = getenv('REMOTE_ADDR');
        		$json = file_get_contents("http://ipinfo.io/$user_ip/geo");
        		$json = json_decode($json, true);
        		$city = $json['city'];
        		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($city)."&sensor=false&key=AIzaSyCmfZY4Q7-doQAZCt73n1hZfjMjRzdpIlk";
        		$result_string = @file_get_contents($url);
        		$resident_ip = json_decode($result_string, true);	
			}else{
				$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zip_code)."&sensor=false&key=AIzaSyCmfZY4Q7-doQAZCt73n1hZfjMjRzdpIlk";
        		$result_string = file_get_contents($url);
        		$resident_ip = json_decode($result_string, true);
			}
			$residentlat = isset($resident_ip['results'][0]['geometry']['location']['lat'])?$resident_ip['results'][0]['geometry']['location']['lat']:'';
        	$residentlng = isset($resident_ip['results'][0]['geometry']['location']['lng'])?$resident_ip['results'][0]['geometry']['location']['lng']:''; 
        	$this->CommonController->updateData('users',array('latitude'=>$residentlat,'longitude'=>$residentlng),['id' =>$uid]);
        }
		
		$query = $this->db->table('tblClaimedZips')->select('*')->where('approved', 1)->orderBy('zip', 'ASC')->get();
        $all_claimed_zip = $query->getResult(); 

        $builder = $this->db->table('zipcode as a');
        $builder->select('a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name');
        $builder->join('zip_code_zone as b', 'a.zip = b.zip_code');
        $builder->join('states as c', 'a.state = c.code');
        $builder->orderBy('state', 'ASC');
        $builder->groupBy('zip_code');
        $query = $builder->get();
        $all_zip_code = $query->getResult();

        $builder = $this->db->table('zipcode as a');
        $builder->select('a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name');
        $builder->join('zip_code_zone as b', 'a.zip = b.zip_code');
        $builder->join('states as c', 'a.state = c.code');
        $builder->orderBy('state', 'ASC');
        $builder->groupBy('state');
        $query = $builder->get();
        $get_all_states = $query->getResult();
        
        $sqlcount = "select * from grocery_store";

        $rowcountArr = $this->CommonController->SelectRawquery($sqlcount,'count');

        $sql = "select * from grocery_store LIMIT 0, 20";
        $result = $this->CommonController->SelectRawquery($sql,'result');
 		 		
 		if($result){
 			foreach ($result  as $k1 => $v1){ 
 				if(strlen($v1->zip) == 4){
 			   		$zip_code= '0'.$v1->zip;
 			    	$this->CommonController->updateData('grocery_store',array('zip'=>$zip_code),['id' =>$v1->id]);
 			    }
 			}
	 		
	 		foreach ($result  as $k2 => $v2){
	 			if($v2->latitude == '' || $v2->longitude == ''){
	 				$googlemap= $this->CommonController->getLocationLatLong($v2->zip);	
	 				$latitude=$googlemap['lat'];
	 			    $longitude=$googlemap['lng'];
	 			    $this->CommonController->updateData('grocery_store',array('latitude'=>$latitude,'longitude'=>$longitude),['id' =>$v2->id]);
	 			} 
 			}

         	foreach ($result as $k3 => $v3){
 			   	$v3->mileslat= $this->Ads_model->getDistanceBetweenPointsNew($v3->latitude,$v3->longitude,$residentlat,$residentlng);
	        }
        }
        if($this->ionAuth->loggedIn()){ 
			$auser = $this->ionAuth->user()->row();
 			if(!empty($auser)){ 
				$this->session->set('get_email',$auser->email);
				$user_id = $auser->user_id;
				$email = $auser->email; 
				$firstName = $auser->first_name;
				$lastName = $auser->last_name;
				$businessUser = $auser->username;
				
				//Cookies set as user_id
				$cookie = array(
					'name'   => 'user_id',
					'email'  => 'email',
					'value'  => $user_id,
					'expire' => time()+86500,
					'domain' => '',
					'path'   => '/',
					'prefix' => '',
				);
				set_cookie($cookie);
				
				$user_type1 = $this->ionAuth->check_user_type($auser->user_id);
		  		$user_type = $user_type1[0]['group_id']; 
		  		$header = 'loginheader';
		  	}
		  	if($this->session->get('session_normal_user_in_zone')!=''){
            	$session_normal_user_in_zone_arr=$this->session->get('session_normal_user_in_zone');
            	if(!empty($session_normal_user_in_zone_arr['sesuserzone'])){
                	$session_session_normal_user_in_zone=$session_normal_user_in_zone_arr['sesuserzone'];
                	$session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype']; 
            	}
        	}
        	if($this->CommonController->getCookie('business_sstheme')){
				$theme = $this->CommonController->getCookie('business_sstheme');
				$page = $this->CommonController->getCookie('business_sstitle');
			}
		}
		$zonebusinessname = '';
      	return view('grocery_store',array('uid'=>$uid,'zone'=>$zone,'result'=>$result,'zoneid' => $zoneid,'zone_id' => $zoneid,'zone_name' => $zone_name,'theme' => $theme,'page' => $page,'footer' => $footer,'all_claimed_zip' => $all_claimed_zip,'all_zip_code' => $all_zip_code,'get_all_states' => $get_all_states,'header' => $header,'user_id' => $user_id,'refer_code' => $refer_code,'zone_owner' => $zone_owner,'first_name' => $first_name,'last_name' => $last_name,'rowcountArr' => $rowcountArr,'hide' => $hide,'show' => $show,'zonebusinessname' => $zonebusinessname,'grocerystore' => $grocerystore,'firstName' => $firstName,'lastName' => $lastName,'session_session_normal_user_in_zone' => $session_session_normal_user_in_zone,'session_session_normal_user_type' => $session_session_normal_user_type,'check_zone_logo' => $check_zone_logo));
  	}

  	public function getgrocerydata(){
  		$lowerlimit = isset($_REQUEST['lowerlimit'])?$_REQUEST['lowerlimit']:'';
  		$upperlimit = isset($_REQUEST['upperlimit'])?$_REQUEST['upperlimit']:'';
  		$grocerystoreuid = isset($_REQUEST['grocerystoreuid'])?$_REQUEST['grocerystoreuid']:'';
  		$searchmiles = isset($_REQUEST['searchmiles'])?$_REQUEST['searchmiles']:'';
  		$sessiondata = isset($_REQUEST['sessiondatagrocery'])?$_REQUEST['sessiondatagrocery']:'';
		
		$decodedata = base64_decode($sessiondata);
    	$decodedata = json_decode($decodedata);
    	if($decodedata!= ''){
			$session_data = array(
      			'identity' => $decodedata->identity,
        		'username' => $decodedata->username,
        		'email' => $decodedata->email,
        		'user_id' => $decodedata->user_id,
        		'old_last_login' => $decodedata->old_last_login
      		);
      		$this->session->set($session_data);
      		$this->CommonController->setSession('session_zoneid', array('userzoneid'=>$decodedata->session_zoneid->userzoneid,'sesuserid'=>$decodedata->session_zoneid->sesuserid), 'array');
      		$this->CommonController->setSession('session_login_details', array('type'=>$decodedata->session_login_details->type,'id'=>$decodedata->session_login_details->id), 'array');
    	}
    	
		$user = $this->ion_auth->user()->row();
		$residentlat = $user->latitude;
		$residentlng = $user->longitude;
		
		if($searchmiles != ''){
			$finalArr1 = [];
			$sql = "select * from grocery_store";
			$result = $this->CommonController->SelectRawquery($sql,'result');

 			foreach ($result as $k3 => $v3){
 				$mileslat= $this->Ads_model->getDistanceBetweenPointsNew($v3->latitude,$v3->longitude,$residentlat,$residentlng);
 				$v3->mileslat = $this->Ads_model->getDistanceBetweenPointsNew($v3->latitude,$v3->longitude,$residentlat,$residentlng);
 				if($searchmiles != ''){
					if($mileslat > $searchmiles){
	        			unset($result[$k3]);
	        		}
 				}
	   		}
	   		foreach ($result as $k3 => $v3){
 				$finalArr1[] = $v3;
	   		}
	   		if(count($finalArr1) > 0){
	   			if($lowerlimit == 1){ 
	   				$finalArr = array_slice($finalArr1, 0, $upperlimit);
                }else{ 
                	$finalArr = array_slice($finalArr1, $lowerlimit, $upperlimit);
                }
	   		}
		}else{
			$finalArr = [];
			$sql = "select * from grocery_store LIMIT ".$lowerlimit.", ".$upperlimit."";
			$result = $this->CommonController->SelectRawquery($sql,'result');
 			foreach ($result as $k3 => $v3){
 				$mileslat= $this->Ads_model->getDistanceBetweenPointsNew($v3->latitude,$v3->longitude,$residentlat,$residentlng);
 				$v3->mileslat = $this->Ads_model->getDistanceBetweenPointsNew($v3->latitude,$v3->longitude,$residentlat,$residentlng);
	   		}
	   		foreach ($result as $k3 => $v3){
 				$finalArr[] = $v3;
	   		}
		}
	   	
	   	echo json_encode($finalArr);
	   	die;
	}

    public function showoffers(){
    	echo"<pre>";print_r($_REQUEST);die;
    	//$idget[0] =$_REQUEST;
    	$sql = "select * from grocery_store where refer_code_link='".$__REQUEST['id']."LIMIT 20'";
    	$result = $this->CommonController->SelectRawquery($sql, 'resultArray');
        echo"<pre>";print_r($sql);die('gfh');

    	$zoneid = !empty($zoneId) ? $zoneId : 213;
        $theme  = "blue"; 
        $page   = 'Old Glory';
        $header= 'homeheader';
        $footer = "homefooter";
        $zone_name = "";
        
        $query = $this->db->table('tblClaimedZips')->select('*')->where('approved', 1)->orderBy('zip', 'ASC')->get();
        $all_claimed_zip = $query->getResult(); 

        $builder = $this->db->table('zipcode as a');
        $builder->select('a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name');
        $builder->join('zip_code_zone as b', 'a.zip = b.zip_code');
        $builder->join('states as c', 'a.state = c.code');
        $builder->orderBy('state', 'ASC');
        $builder->groupBy('zip_code');
        $query = $builder->get();
        $all_zip_code = $query->getResult();

        $builder = $this->db->table('zipcode as a');
        $builder->select('a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name');
        $builder->join('zip_code_zone as b', 'a.zip = b.zip_code');
        $builder->join('states as c', 'a.state = c.code');
        $builder->orderBy('state', 'ASC');
        $builder->groupBy('state');
        $query = $builder->get();
        $get_all_states = $query->getResult();
        
        return view('showoffers',array('zoneid' => $zoneid,'zone_owner' => $zone_owner,'zone_id' => $zoneid,'zone_name' => $zone_name,'theme' => $theme,'page' => $page,'footer' => $footer,'all_claimed_zip' => $all_claimed_zip,'all_zip_code' => $all_zip_code,'get_all_states' => $get_all_states,'header' => $header));
    	
    }

    public function notificationtousersnaptime(){
    	$zoneArr = $useridArr = $busidArr = $businessfinalArr = $userfinalArr = [];
    	$daydb = $this->CommonController->getcurrentdayid();
	$usertable 		= 'users';
	$businesstable 		= 'global_snap_business_settings';	
    	$partialsnaptable 	= 'global_snap_userbusiness_settings';	
    	$globalsnaptable 	= 'global_snap_user_settings';	

    	$businessqry = "SELECT * FROM ".$businesstable." WHERE snap_week_days=".$daydb."";
    	$businessArr = $this->CommonController->SelectRawquery($businessqry,'result');

        if(count($businessArr) > 0){
        	foreach ($businessArr as $k => $v) {
        		$zoneArr[] = $v->created_for_zone;	
        		$busidArr[] = $v->bus_id;	
        		if(isset($v->snap_time) && $v->snap_time != ''){
        			$snaptimeArrdata = json_decode($v->snap_time);
        			foreach ($snaptimeArrdata as $k1 => $v1) {
        				$businessfinalArr[$v->bus_id][$v1->dayarr][$v1->starttimearr][$v1->endtimearr] = $v1->snapsendtypearr; 
        				$userfinalArr[$v1->dayarr][$v1->starttimearr][$v1->endtimearr] = $v1->snapsendtypearr; 
        			}
        		}
        	}

        	$zoneimplode = implode(',', $zoneArr);
        	$userqry = "SELECT * FROM ".$usertable." WHERE snap_settings IN (1,2) AND Zone_ID IN ($zoneimplode)";
        	$userArr = $this->CommonController->SelectRawquery($userqry,'result');
        	if(count($userArr) > 0){
        		foreach ($userArr as $k1 => $v1) {
        			if($v1->snap_settings == 1){
        				$this->sendpartialnotification($v1->id,$businessfinalArr,$partialsnaptable,$daydb,$busidArr,$zoneArr);
        			}else if($v1->snap_settings == 2){
        				$this->sendglobalnotification($v1->id,$userfinalArr,$globalsnaptable,$daydb,$busidArr,$zoneArr);
        			}	
        		}
        	}
        }
    }

    public function sendpartialnotification($user_id, $businesssnapArr,$table,$daydb,$busidArr,$zoneArr){
    	$busidimplode = implode(',', $busidArr);
    	$qry = "SELECT * FROM ".$table." WHERE user_id=".$user_id." AND bus_id IN (".$busidimplode.") AND snap_week_days=".$daydb."";
    	$partialArr = $this->CommonController->SelectRawquery($qry,'result');
        if(count($partialArr) > 0){
        	foreach ($partialArr as $k => $v) {
        		if(isset($v->snap_time) && $v->snap_time != ''){
        			$snaptimeArrdata = json_decode($v->snap_time);
        			foreach ($snaptimeArrdata as $k1 => $v1) {
        				$sendtype = isset($businessfinalArr[$v->bus_id][$v1->dayarr][$v1->starttimearr][$v1->endtimearr])?$businessfinalArr[$v->bus_id][$v1->dayarr][$v1->starttimearr][$v1->endtimearr]:'';
        				if($sendtype != ''){
        					if($v->sendtype == 1){
        						$this->sendsnapemailuser($v->created_for_zone,$v->user_id,$busidArr,$daydb);
        					}else if($v->sendtype == 2){
        						
        					}
        				} 
        			}
        		}
        	}
        }else{
        	foreach ($zoneArr as $k => $v) {
        		$this->sendsnapemailuser($v,$user_id,$busidArr,$daydb);		
        	}
        }
    }
	
	public function sendglobalnotification($user_id,$userfinalArr,$table,$daydb,$busidArr,$zoneArr){
    	$Zonedashboard = new Zonedashboard();
    	$busidimplode = implode(',', $busidArr);
    	$qry = "SELECT * FROM ".$table." WHERE user_id=".$user_id." AND snap_week_days=".$daydb."";
    	$partialArr = $this->CommonController->SelectRawquery($qry,'result');
		if(count($partialArr) > 0){
        	foreach ($partialArr as $k => $v) {
        		if(isset($v->snap_time) && $v->snap_time != ''){
        			$snaptimeArrdata = json_decode($v->snap_time);
        			foreach ($snaptimeArrdata as $k1 => $v1) {
        				$sendtype = isset($userfinalArr[$v1->dayarr][$v1->starttimearr][$v1->endtimearr])?$userfinalArr[$v1->dayarr][$v1->starttimearr][$v1->endtimearr]:'';
        				if($sendtype != ''){
        					if($v1->snapsendtypearr == 1){
        						$this->sendsnapemailuser($v->created_for_zone,$v->user_id,$busidArr,$daydb);
        					}else if($v1->snapsendtypearr == 2){
        						
        					}
        				} 
        			}
        		}
        	}
        }else{
        	foreach ($zoneArr as $k => $v) {
        		$this->sendsnapemailuser($v,$user_id,$busidArr,$daydb);		
        	}
        }	
    }
	
	public function set_business_snap_status(){
		$cat_id 		= isset($_REQUEST['placecatid'])?$_REQUEST['placecatid']:'';
		$sub_cat_id 	= isset($_REQUEST['subcategory'])?$_REQUEST['subcategory']:'';
		$status 		= isset($_REQUEST['status'])?$_REQUEST['status']:'';
		$zone_id 		= isset($_REQUEST['userzone'])?$_REQUEST['userzone']:'';
		$user_id 		= isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';

		$foodtypeArr = ['885','2','888','3','4','5','7','15','35','38','40','41','44','45','49','883','22'];
        if(!in_array($sub_cat_id, $foodtypeArr)){
        	$sql="SELECT business.id as businessid FROM business right JOIN ads ON ads.business_id=business.id INNER JOIN business_sponsor_order_cat ON business_sponsor_order_cat.adid=ads.id WHERE business_sponsor_order_cat.zoneid=".$zone_id." and business_sponsor_order_cat.subcatid=".$sub_cat_id." and business_sponsor_order_cat.catid=".$cat_id." GROUP BY business.id   ORDER BY business_sponsor_order_cat.display_order ASC  ";
             
        }else{
           $sql="SELECT business.id as businessid FROM business_sponsor_order INNER JOIN business ON business_sponsor_order.business_id=business.id left JOIN business_sponsor_order_subcat ON business_sponsor_order_subcat.bussiness_id=business.id right JOIN ads ON ads.business_id=business.id INNER JOIN business_sponsor_order_cat ON business_sponsor_order_cat.adid=ads.id left JOIN business_sponsor ON business_sponsor.business_id=business_sponsor_order.business_id WHERE business_sponsor.zone_id=".$zone_id." and business_sponsor_order_cat.subcatid=".$sub_cat_id." and business_sponsor_order_cat.catid=".$cat_id." GROUP BY business.id   ORDER BY business_sponsor_order_cat.display_order ASC  ";
        }
        $data = $this->CommonController->SelectRawquery($sql,'result');
        if(count($data) > 0){
        	foreach ($data as $k => $v) {
        		$this->CommonController->updateData('business',['snap_status'=>$status],['id'=>$v->businessid]);
        	}
        }
        if($user_id != ''){
        	$this->CommonController->updateData('users',['snap_settings'=>$status],['id'=>$user_id]);
        }
        echo json_encode(['msg'=>'Snap status updated','type'=>'success']);
        die;
	}

	public function set_business_user_snap_status(){
		$businessid = isset($_REQUEST['businessid'])?$_REQUEST['businessid']:'';
		$status 	= isset($_REQUEST['status'])?$_REQUEST['status']:'';
		$this->CommonController->updateData('business',['snap_status'=>$status],['id'=>$businessid]);
      	echo json_encode(['msg'=>'Snap status updated','type'=>'success']);
        die;
	}

	public function sendsnapemailuser($zoneid,$user_id,$busidArr,$daydb){
		$dealurl = $this->CommonController->getzoneurlusingzone($zoneid);
		if(count($busidArr) > 0){
			foreach ($busidArr as $k => $v) {
				$bussql = "select * from business as a INNER JOIN address as b ON b.id=a.addressid where a.id = ".$v;
				$busArr = $this->CommonController->SelectRawquery($bussql,'row');

				$zonesql = "select * from sales_zone where id=".$zoneid;
 				$zoneArr = $this->CommonController->SelectRawquery($zonesql,'row');
				
				$usersql="select * from users where id=".$user_id;
 				$userArr = $this->CommonController->SelectRawquery($usersql,'row');
 				$useremail = isset($userArr->email)?$userArr->email:'';
 				$useremail = isset($userArr->first_name)?$userArr->first_name:'';
 				$userefirst_name = isset($userArr->first_name)?$userArr->first_name:'';
 				$userelast_name = isset($userArr->last_name)?$userArr->last_name:'';

 				$businessname = isset($busArr->name)?$busArr->name:'';
 				$businesszipcode = isset($busArr->zip_code)?$busArr->zip_code:'';
 				$businessphone = isset($busArr->phone)?$busArr->phone:'';
 				$businessuserid = isset($busArr->business_owner_id)?$busArr->business_owner_id:'';
 				
 				$businessusersql="select * from users where id=".$businessuserid;
 				$businessuserArr = $this->CommonController->SelectRawquery($businessusersql,'row');
 				$business_owner_first_name = isset($businessuserArr->first_name)?$businessuserArr->first_name:'';
 				$business_owner_last_name = isset($businessuserArr->last_name)?$businessuserArr->last_name:'';

 				$businesssnaptimeqry = "SELECT * FROM global_snap_business_settings WHERE bus_id=".$v." AND snap_week_days=".$daydb."";
    				$businesssnaptimeArr = $this->CommonController->SelectRawquery($businesssnaptimeqry,'row');
    				$snap_business_time = isset($businesssnaptimeArr->snap_time)?$businesssnaptimeArr->snap_time:'';
    				$snap_business_timeArr = json_decode($snap_business_time);

    			

                		$htmlsnapemaildata = $this->snapemaildesigntemplate($busArr,$snap_business_timeArr,$userefirst_name,$userelast_name,$dealurl,$user_id,$v,$zoneid,$businessname,$business_owner_first_name,$business_owner_last_name,$businessphone,$businesszipcode);
                		$subject = 'Hey '.$userefirst_name.', '.$businessname.' deals meet you snap filters. Quick claim SNAP Dollars.';
				$this->CommonController->SendMail('',$useremail,$subject,$htmlsnapemaildata);
			}
		}
	}
	
	public function snapemaildesigntemplate($busArr,$snap_business_timeArr,$userefirst_name,$userelast_name,$dealurl,$user_id,$v,$zoneid,$businessname,$business_owner_first_name,$business_owner_last_name,$businessphone,$businesszipcode){
		$snaptimehtml = '<table style="width: 100%;border: 1px solid #000;border-collapse: collapse;padding: 10px;">
		<tr style="background:#000;color:#fff;">
		<th style="border: 1px solid #fff;border-collapse: collapse;padding: 10px;">Day</th>
		<th style="border: 1px solid #fff;border-collapse: collapse;padding: 10px;">Snap Starts</th>
		<th style="border: 1px solid #fff;border-collapse: collapse;padding: 10px;">Snap Ends</th>
		<th style="border: 1px solid #fff;border-collapse: collapse;padding: 10px;">Deal</th>
		<th style="border: 1px solid #fff;border-collapse: collapse;padding: 10px;">Number Available</th>
		<th style="border: 1px solid #fff;border-collapse: collapse;padding: 10px;">Snap Dollars</th>
		</tr>';
		$sponserbanner = $this->CommonController->getsinglecolumndata('businesssponsorbannerlist','image','businessid',$v);
    		foreach ($snap_business_timeArr as $k1 => $v1){
    			$dealid = isset($v1->snapdealidarr)?$v1->snapdealidarr:0;
    			$snapdate = isset($v1->snapdatearr)?$v1->snapdatearr:0;
    			$dealtitle = $snapnotice= '';
    			if($dealid > 0){
    			   $dealtitle = $this->CommonController->getsinglecolumndata('tbl_deals','deal_title','deal_id',$dealid); 
    			   $dealcurrentprice = $this->CommonController->getsinglecolumndata('tbl_deals','current_price','deal_id',$dealid); 
    			   $dealprice = $this->CommonController->getsinglecolumndata('tbl_deals','buy_price_decrease_by','deal_id',$dealid);
                    		if($dealtitle == ''){
                        		$dealtitle = $this->CommonController->getsinglecolumndata('tbl_deals','deal_description','deal_id',$dealid);
                        		if($dealtitle == ''){
                            		  $dealtitle = $this->CommonController->getsinglecolumndata('tbl_deals','deal_description_link','deal_id',$dealid);
                            		   if($dealtitle == ''){
                                		$productid = $this->CommonController->getsinglecolumndata('tbl_deals','product_id','deal_id',$dealid);
                                		$dealtitle = $this->CommonController->getsinglecolumndata('tbl_deals','product_name','deal_product_id',$productid);
                            	            }
                        		}
                    		}
                    		$selected_deal = $this->CommonController->getsinglecolumndata('tbl_deals','selected_deal','deal_id',$dealid); 
                    		$snapnotice = $this->CommonController->getsinglecolumndata('deal_cashcert','short_notice','id',$selected_deal);
                    	}
                    	$dayword = $this->CommonController->getsinglecolumndata('snap_week_days','day','id',$v1->dayarr); 
			$starttimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v1->starttimearr); 
			$starttimeword = date('h:i a', strtotime($starttimeword));
                    	$endtimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v1->endtimearr);
                    	$endtimeword = date('h:i a', strtotime($endtimeword));
                    	$snaptimehtml .= '</tr>
                    		<td style="border: 1px solid #000;border-collapse: collapse;padding: 10px;text-align:center;">'.$snapdate.'</td>
				<td style="border: 1px solid #000;border-collapse: collapse;padding: 10px;text-align:center;">'.$starttimeword.'</td>
				<td style="border: 1px solid #000;border-collapse: collapse;padding: 10px;text-align:center;">'.$endtimeword.'</td>
				<td style="border: 1px solid #000;border-collapse: collapse;padding: 10px;text-align:center;">$'.$dealcurrentprice.' for $'.$dealprice.'</td>
				<td style="border: 1px solid #000;border-collapse: collapse;padding: 10px;text-align:center;">'.$v1->noofpeoplearr.'</td>
				<td style="border: 1px solid #000;border-collapse: collapse;padding: 10px;text-align:center;">$'.$snapnotice.'</td>
				</tr>';
                	} 
                $snaptimehtml .= '</table>';


	$snaptimehtmlmobile1 = '<table style="width: 100%;border: 1px solid #000;border-collapse: collapse;padding: 10px;">
		<tr style="background:#000;color:#fff;">
		<th style="border: 1px solid #fff;border-collapse: collapse;padding: 10px;width:30%;">Day</th>
		<th style="border: 1px solid #fff;border-collapse: collapse;padding: 10px;width:30%;">Snap Starts</th>
		<th style="border: 1px solid #fff;border-collapse: collapse;padding: 10px;width:30%;">Snap Ends</th>
		</tr>';
    		foreach ($snap_business_timeArr as $k1 => $v1){
    			$dealid = isset($v1->snapdealidarr)?$v1->snapdealidarr:0;
    			$snapdate = isset($v1->snapdatearr)?$v1->snapdatearr:0;
    			$dealtitle = $snapnotice= '';
    			if($dealid > 0){
    			   $dealtitle = $this->CommonController->getsinglecolumndata('tbl_deals','deal_title','deal_id',$dealid); 
                    		if($dealtitle == ''){
                        		$dealtitle = $this->CommonController->getsinglecolumndata('tbl_deals','deal_description','deal_id',$dealid);
                        		if($dealtitle == ''){
                            		  $dealtitle = $this->CommonController->getsinglecolumndata('tbl_deals','deal_description_link','deal_id',$dealid);
                            		   if($dealtitle == ''){
                                		$productid = $this->CommonController->getsinglecolumndata('tbl_deals','product_id','deal_id',$dealid);
                                		$dealtitle = $this->CommonController->getsinglecolumndata('tbl_deals','product_name','deal_product_id',$productid);
                            	            }
                        		}
                    		}
                    		$selected_deal = $this->CommonController->getsinglecolumndata('tbl_deals','selected_deal','deal_id',$dealid); 
                    		$snapnotice = $this->CommonController->getsinglecolumndata('deal_cashcert','short_notice','id',$selected_deal);
                    	}
                    	$dayword = $this->CommonController->getsinglecolumndata('snap_week_days','day','id',$v1->dayarr); 
			$starttimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v1->starttimearr); 
			$starttimeword = date('h:i a', strtotime($starttimeword));
                    	$endtimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v1->endtimearr);
                    	$endtimeword = date('h:i a', strtotime($endtimeword));
                    	$snaptimehtmlmobile1 .= '</tr>
                    		<td style="border: 1px solid #000;border-collapse: collapse;padding: 10px;width:30%;text-align:center;">'.$snapdate.'</td>
				<td style="border: 1px solid #000;border-collapse: collapse;padding: 10px;width:30%;text-align:center;">'.$starttimeword.'</td>
				<td style="border: 1px solid #000;border-collapse: collapse;padding: 10px;width:30%;text-align:center;">'.$endtimeword.'</td>
				</tr>';
                	} 
                $snaptimehtmlmobile1 .= '</table>';

                $snaptimehtmlmobile2 = '<table style="width: 100%;border: 1px solid #000;border-collapse: collapse;padding: 10px;">
		<tr style="background:#000;color:#fff;">
		<th style="border: 1px solid #fff;border-collapse: collapse;padding: 10px;width:30%;">Deal</th>
		<th style="border: 1px solid #fff;border-collapse: collapse;padding: 10px;width:30%;">Number Available</th>
		<th style="border: 1px solid #fff;border-collapse: collapse;padding: 10px;width:30%;">Snap Dollars</th>
		</tr>';
    		foreach ($snap_business_timeArr as $k1 => $v1){
    			$dealid = isset($v1->snapdealidarr)?$v1->snapdealidarr:0;
    			$snapdate = isset($v1->snapdatearr)?$v1->snapdatearr:0;
    			$dealtitle = $snapnotice= '';
    			if($dealid > 0){
    			   $dealtitle = $this->CommonController->getsinglecolumndata('tbl_deals','deal_title','deal_id',$dealid); 
    			   $dealcurrentprice = $this->CommonController->getsinglecolumndata('tbl_deals','current_price','deal_id',$dealid); 
    			   $dealprice = $this->CommonController->getsinglecolumndata('tbl_deals','buy_price_decrease_by','deal_id',$dealid); 
                    		if($dealtitle == ''){
                        		$dealtitle = $this->CommonController->getsinglecolumndata('tbl_deals','deal_description','deal_id',$dealid);
                        		if($dealtitle == ''){
                            		  $dealtitle = $this->CommonController->getsinglecolumndata('tbl_deals','deal_description_link','deal_id',$dealid);
                            		   if($dealtitle == ''){
                                		$productid = $this->CommonController->getsinglecolumndata('tbl_deals','product_id','deal_id',$dealid);
                                		$dealtitle = $this->CommonController->getsinglecolumndata('tbl_deals','product_name','deal_product_id',$productid);
                            	            }
                        		}
                    		}
                    		$selected_deal = $this->CommonController->getsinglecolumndata('tbl_deals','selected_deal','deal_id',$dealid); 
                    		$snapnotice = $this->CommonController->getsinglecolumndata('deal_cashcert','short_notice','id',$selected_deal);
                    	}
                    	$dayword = $this->CommonController->getsinglecolumndata('snap_week_days','day','id',$v1->dayarr); 
			$starttimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v1->starttimearr); 
			$starttimeword = date('h:i a', strtotime($starttimeword));
                    	$endtimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v1->endtimearr);
                    	$endtimeword = date('h:i a', strtotime($endtimeword));
                    	$snaptimehtmlmobile2 .= '</tr>
				<td style="border: 1px solid #000;border-collapse: collapse;padding: 10px;width:30%;text-align:center;">$'.floatval($dealcurrentprice).' for $'.floatval($dealprice).'</td>
				<td style="border: 1px solid #000;border-collapse: collapse;padding: 10px;width:30%;text-align:center;">'.$v1->noofpeoplearr.'</td>
				<td style="border: 1px solid #000;border-collapse: collapse;padding: 10px;width:30%;text-align:center;">$'.$snapnotice.'</td>
				</tr>';
                	} 
                $snaptimehtmlmobile2 .= '</table>';

		$html = '<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title></title>
			<style>
				.desktopview{display:block;}
				.mobileview{display:none;}
				@media (max-width: 767px){
					.desktopview{display:none;}
					.mobileview{display:block;}
				}					
			</style>
		</head>
		<body>
			<div class="desktopview hide " style="width:90%;margin:auto;">
			   <div style="color:#000;background: #fff;width: 100%;margin: 50px auto;padding: 11px;border: 1px solid #ccc;font-size: 14px;line-height: 26px;box-shadow: 0px 1px 11px rgb(111 110 122 / 52%);""><div style="text-align: center;padding: 17px;margin-bottom: 20px"><img style="width: 240px;"" src="https://cdn.savingssites.com/logo-green.png"/></div><br>
			   <div style="width:100%;padding:5px;text-align:center;">';
			   	if($sponserbanner != ''){
			   	  $html .= '<h2 style="font-size:12px;">Our sponsor helps us support nonprofits:</h2></div><div style="width: 100%;height: 85px;margin-bottom: 20px;text-align:center"><img style="height: 80px;padding: 5px 0px;" src="https://cdn.savingssites.com/sponsorsample.png"/></div><hr>';	
			   	}
			   	$html .= '
                		<div style="padding:5px;text-align:center;"> 
                			<h2 style="font-size:24px;">Get SNAP Dollars by using your Deal during SNAP times!</h2>
                		</div><br>

                		  <div style="padding:5px;text-align:left;font-size:24px;">
					'.$snaptimehtml.'<br><br>
					
					<a style="text-decoration:none;background: #5f9900;color: #fff;padding: 10px;position: relative;top: -5px;" href="'.$dealurl.'/snapdealclaim?userid='.$user_id.'&bus_id='.$v.'&zoneid='.$zoneid.'">Claim SNAP Dollars</a><br><br>

					<img style="width:auto;height: 60px;margin:-8px;" src="https://cdn.savingssites.com/logo-green.png"/><br>
					Authorized by: '.$business_owner_first_name.' '.$business_owner_last_name.'<br>
					Street: '.$busArr->street_address_1.'<br>
					City State: '.$busArr->city.', '.$busArr->state.'<br>
					Zip: '.$businesszipcode.'<br>
					Phone: '.$businessphone.'<br>
					Website: '.$busArr->website.'<br><br>
				Claims to obtain SNAP Dollars <u><b>read more</b></u>
				</div>
				<div style="background: #000;color: #fff;text-align: center;padding: 1px 0 1px;line-height: 0;margin-top: 15px;""><p>© "'.date("Y").'" SS Businesses Search . All Rights Reserved.</p></div>
			</div>
			</div>

			<div class="mobileview" style="width:100%;margin:auto;">
				<div style="color:#000;background: #fff;width: 100%;margin: 50px auto;padding: 11px;border: 1px solid #ccc;font-size: 14px;line-height: 26px;box-shadow: 0px 1px 11px rgb(111 110 122 / 52%);"">
					<div style="width:100%;height:80px;border-bottom:1px solid #000;">
						<div style="width:30%;float:left;padding:25px 0px 0px 0px;text-align:left;">
						<img style="width: 110px;"" src="https://cdn.savingssites.com/logo-green.png"/>

						</div>
						<div style="width:40%;float:left;text-align:center;">
							<h2 style="font-size:15px;margin-bottom:0px;">Save by Giving<br><span style="color:#5f9900;">Give by Saving</span></h2>
						</div>
						<div style="width:30%;float:right;padding:10px 0px 0px 0px;text-align:right;">
						<img style="width: 110px;"" src="https://cdn.savingssites.com/new-savingssites3.png"/>

						</div>
					</div>
					<br>



				<div style="width:100%;padding:5px;text-align:left;">';
				if($sponserbanner != ''){
			   	  $html .= '<h2 style="font-size:15px;float:left;width:46%;text-align:center;">Our sponsor helps<br> us support nonprofits:</h2></div><div style="width: 100%;height: 85px;margin-bottom: 20px;text-align:center"><img style="height: 80px;padding: 0px 0px;max-width:819px;float:left;width:auto;margin-left:0%;margin-top:-10px;" src="https://cdn.savingssites.com/sponsorsample.png"/></div><hr>';	
			   	}
			   	$html .= '

                		<div style="padding:5px;text-align:center;"> 
                			<h2 style="font-size:12px;">Get SNAP Dollars by using your Deal during SNAP times!</h2>
                		</div>



                		 <div style="padding:5px;font-size:18px;"> 
					
					'.$snaptimehtmlmobile1.'<br>
					'.$snaptimehtmlmobile2.'<br>
					
					<div style="text-align:center;"><a style="text-align:center;text-decoration:none;background: #5f9900;color: #fff;padding: 10px;position: relative;top: -5px;" href="'.$dealurl.'/snapdealclaim?userid='.$user_id.'&bus_id='.$v.'&zoneid='.$zoneid.'"><strong>Claim SNAP Dollars</strong></a></div><br><br>

					<img style="width:auto;height: 50px;margin:-8px;padding-left:10px;text-align:left;" src="https://cdn.savingssites.com/logo-green.png"/><br>
					Authorized by: '.$business_owner_first_name.' '.$business_owner_last_name.'<br>
					Street: '.$busArr->street_address_1.'<br>
					City State: '.$busArr->city.', '.$busArr->state.'<br>
					Zip: '.$businesszipcode.'<br>
					Phone: '.$businessphone.'<br>
					Website: '.$busArr->website.'<br><br>
				Claims to obtain SNAP Dollars <u><b>read more</b></u>
				</div>
				<div style="background: #000;color: #fff;text-align: center;padding: 1px 0 1px;line-height: 0;margin-top: 15px;font-size:12px !important;"><p>© "'.date("Y").'" SS Businesses Search . All Rights Reserved.</p></div>



			</div>
		</body>
		</html>';
		return $html;
	}
	public function snapdealclaim(){
		$businesssnaptable = 'global_snap_business_settings';
	    	$userid = isset($_REQUEST['userid'])?$_REQUEST['userid']:'';	
	    	$bus_id = isset($_REQUEST['bus_id'])?$_REQUEST['bus_id']:'';
	    	$zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:'';
	    	$daydb = $this->CommonController->getcurrentdayid();
		$refer_code = $zone_name = '';
	    	$dealcertavailable = $sr = 0;
	    	$finalsnapArr = [];	
		$amazonurl = $this->myconfig->AWSimageurl;
        	$zoneid = $this->CommonController->redirectToZone();
        
        	$sqlsubdomain = "SELECT * FROM sales_zone WHERE id='".$zoneid."'";
        	$subdomaindata = $this->CommonController->SelectRawquery($sqlsubdomain,'row');
        	$subdomain = isset($subdomaindata->subdomain)?$subdomaindata->subdomain:'';
        	$header= 'homeheader';
        	$footer = 'homefooter';
        	$theme  = "blue"; 
        	$page = 'Old Glory';
        	$data['user_type']['type'] = '';
        	
        	$zone= $this->Zone_model->get_zone($zoneid);
        	$zone_owner = (object)$this->Users->get_user_details($zone['sales_rep_id']);
        	
	    	$peekaboodeals = $this->Organization_model->getuserdeals($zoneid,$userid);
	    	$dealurl = $this->CommonController->getdealurlusingzone($zoneid);
		
		if(count($peekaboodeals) > 0){
	    		foreach ($peekaboodeals as $k => $v) {
	    	   		if($v['certificate_verify'] == 'Not Verify'){
	    	   			$sr++;
	    	   			$dealcertavailable = $sr;	
	    	   		}
	    		}
			if($dealcertavailable > 0){
	    			$dealcertavailable = 1;
	    		}else{
	    			$dealcertavailable = 0;	
	    		}
	    	}
	   
        	$snapbusqry = "SELECT * FROM ".$businesssnaptable." WHERE bus_id=".$bus_id." AND snap_week_days=".$daydb."";
        	$snapbusArr = $this->CommonController->SelectRawquery($snapbusqry,'result');
        	$bus_id_name = $this->CommonController->getsinglecolumndata('business','name','id',$bus_id);
        	if(count($snapbusArr) > 0){
        		foreach ($snapbusArr as $k => $v) {
        			$snap_business_timeArr = json_decode($v->snap_time);
				foreach ($snap_business_timeArr as $k1 => $v1){
                			$v1->dayword = $this->CommonController->getsinglecolumndata('snap_week_days','day','id',$v1->dayarr);   
                    			$v1->starttimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v1->starttimearr); 
                    			$v1->starttimeword = date('h:i a', strtotime($v1->starttimeword));
                    			$v1->endtimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v1->endtimearr);
                    			$v1->endtimeword = date('h:i a', strtotime($v1->endtimeword));
                    			$finalsnapArr[$v1->dayarr][] = $v1;
                		} 
        		}
        	}
        	return view('snapdealclaim', array('zoneid'=>$zoneid,'zone_owner'=>$zone_owner,'zone_id'=>$zoneid,'user_id'=>'','refer_code'=>$refer_code,'zone_name'=>$zone_name,'theme'=>$theme,'header'=>$header,'footer'=>$footer,'finalsnapArr'=>$finalsnapArr,'snapuserid'=>$userid,'dealcertavailable'=>$dealcertavailable,'dealurl'=>$dealurl,'bus_id'=>$bus_id,'bus_id_name'=>$bus_id_name));	
	}

	public function getlocationdeal(){
	    $search = isset($_REQUEST['search'])?$_REQUEST['search']:'';
	    if($search){
	    	$placesArr = $this->CommonController->getplaces($search);	
	    }
	    echo json_encode($placesArr);
	    die;
	}
}

?>