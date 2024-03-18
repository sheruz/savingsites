<?php
namespace App\Controllers;
use App\Models\IonAuthModel;
use App\Models\Zips;
use App\Models\Organization_model;
use App\Models\zone\Zone_model;
use App\Models\admin\Ads_model;
use App\Models\admin\Users;
use App\Models\business\Business_model;
use App\Models\admin\Business;
use App\Models\banner\Banner_model;
use App\Controllers\CronController;
use App\Models\States;
use App\Models\admin\Sales_zone;
use App\Models\Category_new_model;
use App\Models\dining\Diningmodel;
use App\Libraries\IonAuth;
use App\Controllers\CommonController;
use App\Controllers\BusinessSearch;
use Config\MyConfig;
#[\AllowDynamicProperties]
class Businessdashboard extends BaseController{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ion_auth = $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->pager = \Config\Services::pager();
        $this->Zips = new Zips();
        $this->Zone_model = new Zone_model();
        $this->Ads_model = new Ads_model();
        $this->Organization_model = new Organization_model();
        $this->Diningmodel = new Diningmodel();
        $this->Category_new_model = new Category_new_model();
        $this->Users = new Users();
        $this->States = new States();
        $this->Banner_model = new Banner_model();
        $this->SalesZone = new Sales_zone();
        $this->Business_model = new Business_model();
        $this->CronController = new CronController();
        $this->Business = new Business();
        $this->CommonController = new CommonController();
        $this->BusinessSearch = new BusinessSearch();
        $this->myconfig = new MyConfig;
    } 
	
	function clear_cache(){    

        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");

        $this->output->set_header("Pragma: no-cache");

    }

    public function index(){  

        $this->load->view("dashboards/zone_dashboard");		

    }


    function deal_title(){


		$deal_title= urldecode($_REQUEST['deal_title']);
		$product_id=$_REQUEST['product_id'];
			$extraquery = '';
			if($deal_title !=""){
				if($product_id !="")
				{
					$extraquery = " and product_id NOT IN (".$product_id.")";
				}
				$sql = "SELECT deal_title from tbl_auction where deal_title='".$deal_title."' $extraquery";
				$result =  $this->db->query($sql);	
				$rows_count = $result->result_array();	

					if(count($rows_count) == 0){
						echo 1;
					} else {
						echo 2;
					}
			}



    }


 


	function deletedeal(){
 

	     $auction_sql_setting =  'delete ip.* , a.*  FROM tbl_deals a LEFT JOIN tbl_deals_products ip ON ip.deal_product_id=a.product_id LEFT JOIN tbl_category c ON c.cat_id=ip.cat_id WHERE a.product_id='.$_POST['data_to_use'];

    	$auction_result_setting= $this->db->query($auction_sql_setting);	


	}

		function deleteaction(){
 

	     $auction_sql_setting =  'delete ip.* , a.*  FROM tbl_auction a LEFT JOIN tbl_inventory_products ip ON ip.product_id=a.product_id LEFT JOIN tbl_category c ON c.cat_id=ip.cat_id WHERE a.product_id='.$_POST['data_to_use'].'  AND a.auction_type="RTP"  ';

    	$auction_result_setting= $this->db->query($auction_sql_setting);	


	}
	public function allpeekabooId($userID){
       $auction_sql_setting =  'select tbl_member.user_id from business inner join users on users.id = business.business_owner_id inner join tbl_member on tbl_member.user_name = users.username where business.id = '.$userID;
		$auction_result_setting = $this->CommonController->SelectRawquery($auction_sql_setting, 'resultArray');
    	return isset($auction_result_setting[0]['user_id'])?$auction_result_setting[0]['user_id']:0;
        die;
    }
	
	public function allpeekabootype($userID){
    	$auction_sql_setting =  'select tbl_member.member_type from business inner join users on users.id = business.business_owner_id inner join tbl_member on tbl_member.user_name = users.username where business.id = '.$userID;
    	$auction_result_setting = $this->CommonController->SelectRawquery($auction_sql_setting, 'resultArray');
    	return isset($auction_result_setting[0]['member_type'])?$auction_result_setting[0]['member_type']:'';
        die;
    }

    function allauctions($businessid,$fromzoneid){     


          $user = $this->ion_auth->user()->row(); 

          $peekaboo_id = $this->allpeekabooId($businessid);
		 $peekaboo_type = $this->allpeekabootype($businessid);

 

         $auction_sql_setting = 'SELECT c.name as cat_name,ip.company_name ,ip.product_id,ip.product_name,ip.image, a.auc_id,a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update FROM tbl_auction a LEFT JOIN tbl_inventory_products ip ON ip.product_id=a.product_id LEFT JOIN category_new c ON c.id=ip.cat_id WHERE a.user_id='.$peekaboo_id.' AND a.member_type='.$peekaboo_type.' AND a.auction_type="RTP" and a.status <> "Deleted"  order by a.start_date ASC';

       


    	$auction_result_setting= $this->db->query($auction_sql_setting);	
			$auction_result_setting =   $auction_result_setting->result_array();

		$data['auctiondata']= $auction_result_setting;



        $data['common']=$this->common_first($businessid,$fromzoneid);
        $data['payment_creditprice'] = $this->business->business_credit($fromzoneid);
        $data['zoneid']=$fromzoneid;
        $data['businessid']=$businessid;
        $data['right_container'] = $this->load->view("business/allauctions", $data, true);
        $this->common($data);		
    }
	
	public function alldeals($zoneid=false,$usersid=0){
		$memberquery = 'select b.user_id from users a INNER JOIN tbl_member b ON a.username=b.user_name  where a.id='.$usersid.'';
	  	$member_id = $this->CommonController->SelectRawquery($memberquery,'row')->user_id;
	  	
	  	$auction_sql_setting = 'SELECT  ip.* , a.*,  c.name as cat_name,ip.company_name ,ip.deal_product_id,ip.product_name,   a.deal_id ,a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update FROM tbl_deals a LEFT JOIN tbl_deals_products ip ON ip.deal_product_id=a.product_id LEFT JOIN category_new c ON c.id=ip.cat_id WHERE a.user_id='.$member_id.'  order by a.start_date ASC';   
		return $this->CommonController->SelectRawquery($auction_sql_setting,'resultArray');
	}

	public function allorderApprovals($businessid=0){
		$businessid = isset($_REQUEST['busId'])?$_REQUEST['busId']:$businessid;
		$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
		$sql = 'select * from business_get_order where businessid='.$businessid.'';
		if($type == 'jspage'){
			$sql .= ' AND status=0';
		}else{
			$sql .= ' AND status!=0';
		}
	  	$data = $this->CommonController->SelectRawquery($sql);
	  	foreach ($data as $k => $v) {
	  		$sqluser = 'select * from users where id='.$v['userid'].'';
	  		$userArr = $this->CommonController->SelectRawquery($sqluser,'row');
	  		$data[$k]['firstname'] = isset($userArr->first_name)?$userArr->first_name:'';
	  		$data[$k]['lastname'] = isset($userArr->first_name)?$userArr->last_name:'';
	  		$data[$k]['phone'] = isset($userArr->first_name)?$userArr->phone:'';
	  	}
	  	if($type == 'jspage'){
	  		echo json_encode($data);
	  	}else{
			return $data;
	  	}
	}

	public function setorderApprovals(){
		$orderid = isset($_REQUEST['orderid'])?$_REQUEST['orderid']:'';
		$ordertype = isset($_REQUEST['ordertype'])?$_REQUEST['ordertype']:'';
	  	if($ordertype == 'A'){
	  		$type = 'Approved';
	  		$status = 1;
	  	}else{
	  		$type = 'Rejected';
	  		$status = 2;
	  	}
	  	$this->CommonController->updateData('business_get_order',['status'=> $status],['id'=>$orderid]);
		echo json_encode(['msg'=>'Order '.$type.' Successfully','type'=>'success']);
	}

	public function setorderreject(){
		$busid = isset($_REQUEST['busid'])?$_REQUEST['busid']:'';
		$orderId = isset($_REQUEST['orderId'])?$_REQUEST['orderId']:'';
		$status = 2;
		$orderexplode = explode(',', $orderId);
		if(count($orderexplode) > 0){
			foreach($orderexplode as $k => $v){
				$this->CommonController->updateData('business_get_order',['status'=> $status],['id'=>$v,'businessid'=>$busid]);
			}
		}
	  	
		echo json_encode(['msg'=>'All Order Rejected Successfully','type'=>'success']);
	}

	public function allorderstatus($businessid=0){
		$sql = 'select * from business_order_status where businessid='.$businessid.'';
	  	$data = $this->CommonController->SelectRawquery($sql);
	  	foreach ($data as $k => $v) {
	  		$sqluser = 'select * from users where id='.$v['userid'].'';
	  		$userArr = $this->CommonController->SelectRawquery($sqluser,'row');
	  		$data[$k]['firstname'] = isset($userArr->first_name)?$userArr->first_name:'';
	  		$data[$k]['lastname'] = isset($userArr->first_name)?$userArr->last_name:'';
	  		$data[$k]['phone'] = isset($userArr->first_name)?$userArr->phone:'';
	  	}
		return $data;
	}



	function save_banner_imagemobile($zone_id){
	 
		$newfolder_name = $zone_id.'_'.time();
		
		$target = "./assets/directory/images";
		
		if(is_dir($target)==false){
			mkdir($target,0777);
		}
		
    	$result = '';
    	$output_image_data = '';
		
    	$file_config = array();
    	$file_config['upload_path'] = $target;
    	$file_config['max_size'] = "";
    	$file_config['allowed_types'] = "jpg|png|jpeg";
   
     
    	$this->load->library('upload', $file_config);
   
		
		
    	if ( ! $this->upload->do_upload('card_img','banner_image'))
    	{
    		$result = $this->upload->display_errors();	 
			echo $result;
    	}else{


    		$data['upload_data'] = $this->upload->data();
			$img = $data['upload_data']['file_name'];
			
			$resize_mob_width = '737';
			$resize_mob_height = '1150';
			$resize_mob_target = "./uploads/zone_mobile_resizeupload/$zone_id";
		
			if(is_dir($resize_mob_target)==false){
				mkdir($resize_mob_target,0777);
			}
			$this->resize1($resize_mob_target,$data['upload_data'],$resize_mob_width,$resize_mob_height);
			
		 
			$img_display = substr($img,16);
			
			$picarray=array(
			'clientImage'=>$img,
			'uploadedImage'=>'',
			'zone_id'=>$zone_id,
			);
			echo json_encode($picarray);
    	}
	}
 

 function allauction_reschedule(){
  

 	 date_default_timezone_set('Pacific/Auckland');
		$current_date_time=date('Y-m-d');     

        $end_date_time=date('Y-m-d H:i:s',strtotime('+30 days',strtotime($current_date_time))) . PHP_EOL;

 	 $query_auction= "UPDATE tbl_auction SET  start_date='".$current_date_time."', end_date='".$end_date_time."', created_date='".$current_date_time."', status='Live'  where 	product_id  IN (".$_REQUEST['data_to_use'].")";  
        $this->db->query($query_auction); 

 

 	die;
 }

 function saveorderonlineservice(){
 



 	$certificate_sql_setting=$this->query="delete   FROM tlb_orderonlineservices  where businessid =".$_REQUEST['business_id'];		
	$certificate_result_setting= $this->db->query($certificate_sql_setting);		
  
 

 	  $this->query_certificate="INSERT INTO tlb_orderonlineservices  SET  data='".json_encode($_REQUEST['data'])."'  , businessid =".$_REQUEST['business_id'];  
	  $this->db->query($this->query_certificate);

 

 	  die;
 }

function deleteorderonlineservice(){

		$certificate_sql_setting=$this->query="delete   FROM tlb_orderonlineservices  where businessid =".$_REQUEST['business_id'];		
	$certificate_result_setting= $this->db->query($certificate_sql_setting);		
  
}
 
   function auction_reschedule(){
         
        date_default_timezone_set('Pacific/Auckland');
		$current_date_time=date('Y-m-d');     

        $end_date_time=date('Y-m-d H:i:s',strtotime('+30 days',strtotime($current_date_time))) . PHP_EOL;

        $query_auction= "UPDATE tbl_auction SET  start_date='".$current_date_time."', end_date='".$end_date_time."', created_date='".$current_date_time."', status='Live'  where 	product_id = ".$_REQUEST['data_to_use'];  




	   $this->db->query($query_auction); 


              die;

   }




    function alldeal_reschedule(){
  

 	 date_default_timezone_set('Pacific/Auckland');
		$current_date_time=date('Y-m-d');     

        $end_date_time=date('Y-m-d H:i:s',strtotime('+30 days',strtotime($current_date_time))) . PHP_EOL;

    $query_auction= "UPDATE tbl_deals SET  start_date='".$current_date_time."', end_date='".$end_date_time."', created_date='".$current_date_time."', status='Live'  where 	product_id  IN (".$_REQUEST['data_to_use'].")";  

         $this->db->query($query_auction); 

 

 	die;
 }

   function deal_reschedule(){
         
        date_default_timezone_set('Pacific/Auckland');
		$current_date_time=date('Y-m-d');     

        $end_date_time=date('Y-m-d H:i:s',strtotime('+30 days',strtotime($current_date_time))) . PHP_EOL;

        $query_auction= "UPDATE tbl_deals SET  start_date='".$current_date_time."', end_date='".$end_date_time."', created_date='".$current_date_time."', status='Live'  where 	product_id = ".$_REQUEST['data_to_use'];  




	    $this->db->query($query_auction); 


              die;

   }





	function online_order_services($businessid,$fromzoneid){

         
        $certificate_sql_setting=$this->query="SELECT * FROM tlb_orderonlineservices  where businessid =".$businessid;		
     	$certificate_result_setting= $this->db->query($certificate_sql_setting);		
        $data['order_online'] =   $certificate_result_setting->result_array();

        $data['common']=$this->common_first($businessid,$fromzoneid);   
        $data['zoneid']=$fromzoneid;
        $data['businessid']=$businessid;
        $data['right_container'] = $this->load->view("business/onlineorderservices", $data, true);
        $this->common($data);	

	}

	function online_order_discount($businessid,$fromzoneid){
		$certificate_sql_setting=$this->query="SELECT * FROM tlb_orderonlineservices  where businessid =".$businessid;		
     	$certificate_result_setting= $this->db->query($certificate_sql_setting);		
        $data['order_online'] =   $certificate_result_setting->result_array();
        /*get discouint value*/
        $businessquery=$this->query="SELECT `cash_discount`,`card_discount`,`pick_discount`,`delivery_discount`,`online_order_dicount`,`free_cert_dis_availability` FROM business  where id =".$businessid;		
     	$business_result= $this->db->query($businessquery);		
        $data['businessDis'] = $business_result->result_array();
        /*get discouint value*/

        $data['common']=$this->common_first($businessid,$fromzoneid);   
        $data['zoneid']=$fromzoneid;
        $data['businessid']=$businessid;
        $data['right_container'] = $this->load->view("business/onlinediscount", $data, true);
        $this->common($data);	

	}




	 function resize1($target,$image_data,$width,$height) {
		
	
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
	
	public function insert_deals(){

		$this->product_code = '';
		$this->units_in_stock = 1;
		$this->unit_price = '';
		$this->shipping_cost = '';
		$this->description = '';
		$this->model = '';
		$this->purchase_price = '';
		$certificate_approval_status = '';
		$this->color_code = '';
		$this->cert_accept = '';
		$this->consolation_price = '';
		$this->seller_fee = '';
		$this->seller_credit = '';
		$this->bid_increment = '';
		$this->max_user_bids = '';
		$this->max_bid_at_time = '';
		$this->show_price_charge = '';
		$this->price_decrease_by = '';
		$this->restriction_price = '';
		$this->automate_create = '';
		$this->meta_key = '';
		$this->additional_restriction = '';
		$this->current_order_id = '';
		$auction_approval_status = '';
		$this->choose_auction = '';



		$params = array();
		parse_str($_POST['data_to_use'], $params);
		$peekaboo_id = $this->allpeekabooId($params['business_id']);
		$peekaboo_type = $this->allpeekabootype($params['business_id']);

        
        if($params['login_type'] =='' || $params['login_type']=='0'){
			$certificate_approval_status=1;
			$auction_approval_status=1;
			$certificate_status='available';
		}

        $this->peekaboo_id = $peekaboo_id;
        $this->peekaboo_type = $peekaboo_type;
        date_default_timezone_set('Pacific/Auckland');
		$this->current_date_time=date('Y-m-d H:i:s');
		$this->product_id=trim($params['product_id']);		
		$this->cat_id=trim($params['cat_id']);		 
		$this->subcatID=trim($params['subcatID']);	
		$this->product_name=str_replace("'", "\'", trim($params['page_title']) );
		$this->company_name= str_replace("'", "\'", trim($params['company_name']));  
    	
		
		
		$this->tech_description=str_replace("'", "\'", trim($params['deal_description']));
		$this->other_description=str_replace("'", "\'", trim($params['meta_description']));
		$this->user_id= trim($params['user_id']);
		$this->member_type=trim($params['member_type']);
		
		$this->start_date=trim($params['start_date']);
		$this->selected_deal = trim($_REQUEST['deal_id']);
		$this->created_date = date("Y-m-d");
		$this->end_date=trim($params['end_date']);
		$this->publisher_fee=trim($params['publisher_fee']);
		
		

		$this->buy_price_decrease_by = trim($params['buy_price_decrease_by']);
		$this->current_price = trim($params['low_limit_price']);
		$this->low_limit_price = trim($params['low_limit_price']);
		
		
		
		$this->deal_description_link = $this->deal_title = $this->page_title = str_replace("'", "\'", trim($params['page_title']) );
		
		$this->meta_description = str_replace("'", "\'", trim($params['meta_description']));
		
		
		$this->zone_id = trim($params['zone_id']);		 
		$this->deal_description = str_replace("'", "\'", trim($params['deal_description']));
		
		
		$this->certificate_status = trim($params['status']);
		$this->status = trim($params['status']);		
		$this->status_auction = trim($params['status']);
	  	$this->start_date = date('Y-m-d', strtotime($this->start_date));
		$this->display = isset($params['live_status'])?$params['live_status']:'';
		$this->banner = 'Yes';
		$this->hot_auction = 'Yes';
		$this->auc_type = 'RTP';
	 	$this->card_img = trim($params['uploadedInput']);
		
		
		
		$this->nobypass					=	trim($params['nobypass']);
		$this->buy_price_charge = 3; 	

		if($params['numberofconsolation'] == 'on'){
			$this->numberofconsolation = trim('-1') ;
		}else{
			$this->numberofconsolation =  trim($params['numberofconsolation']) ;
		}	 
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
		if($params['mode'] == 'edit'){
			$this->query_certificate="UPDATE   tbl_deals_products SET  cat_id='$this->cat_id',  subcat_id='$this->subcatID', product_name='$this->product_name',product_code='$this->product_code',company_name='$this->company_name',units_in_stock='$this->units_in_stock',unit_price='$this->unit_price',shipping_cost='$this->shipping_cost',last_modify_date='$this->current_date_time',card_img='$this->card_img',description='$this->description',model='$this->model',tech_description='$this->tech_description',other_description='$this->other_description',status='$this->status',purchase_price='$this->purchase_price',member_type='$this->member_type',approval_status='$certificate_approval_status',color_code='$this->color_code',cert_accept='$this->cert_accept',consolation_price='$this->consolation_price',nobypass='$this->nobypass', numberofconsolation = '$this->numberofconsolation', publisher_fee = '$this->publisher_fee', seller_fee = '$this->seller_fee',seller_credit = '$this->seller_credit',parent_id= 0,zone_id ='$this->zone_id' where deal_product_id = ".$this->product_id;  
			$this->db->query($this->query_certificate); 

			$this->query_auction= "UPDATE tbl_deals SET bid_increment='$this->bid_increment',max_user_bids='$this->max_user_bids',max_bid_at_time='$this->max_bid_at_time',show_price_charge='$this->show_price_charge',buy_price_charge='$this->buy_price_charge',rtp_price_decrease_by='$this->price_decrease_by', selected_deal = '$this->selected_deal' , buy_price_decrease_by='$this->buy_price_decrease_by',current_price='$this->current_price',restriction_price='$this->restriction_price',low_limit_price='$this->low_limit_price',start_date='$this->start_date',end_date='$this->end_date',created_date='$this->created_date',auction_type='$this->auc_type',status='$this->status',automate_create='$this->automate_create',display='$this->display',banner='$this->banner',hot_auction='$this->hot_auction',last_update='$this->current_date_time',page_title='$this->page_title',meta_key='$this->meta_key',meta_description='$this->meta_description',deal_title='$this->deal_title',deal_condition='$this->deal_description',deal_description_link='$this->deal_description_link',deal_description='$this->deal_description',additional_restriction='$this->additional_restriction',order_id='$this->current_order_id' ,approval_status='$auction_approval_status',closedauction_value='$this->choose_auction',zone_id='$this->zone_id'  where 	product_id = ".$this->product_id;  
			$this->db->query($this->query_auction);
			if($zonesubuser != ''){
				$dealarrsubuser = ['dealid'=>$this->product_id];
				$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Update Deal',serialize($dealarrsubuser));
			}
		}else{
			$arr=['cat_id'=>$this->cat_id, 'subcat_id' =>$this->subcatID,'product_name'=>$this->product_name,'product_code'=>$this->product_code,'company_name'=>$this->company_name,'units_in_stock'=>$this->units_in_stock,'unit_price'=>$this->unit_price,'shipping_cost'=>$this->shipping_cost,'last_modify_date'=>$this->current_date_time,'card_img'=>$this->card_img,'description'=>$this->description,'model'=>$this->model,'tech_description'=>$this->tech_description,'status'=>$this->status, 'other_description'=>$this->other_description,'purchase_price'=>$this->purchase_price,'user_id'=>$this->peekaboo_id,'member_type'=>$this->member_type,'approval_status'=>$certificate_approval_status,'color_code'=>$this->color_code,'cert_accept'=>$this->cert_accept,'consolation_price'=>$this->consolation_price,'nobypass'=>$this->nobypass, 'numberofconsolation' => $this->numberofconsolation, 'publisher_fee' => $this->publisher_fee, 'seller_fee' => $this->seller_fee,'seller_credit' =>$this->seller_credit,'parent_id'=>0,'zone_id' =>$this->zone_id];  
			$this->product_id = $this->CommonController->InsertData('tbl_deals_products', $arr);
			
			$this->query_auction="INSERT INTO tbl_deals SET product_id='$this->product_id',bid_increment='$this->bid_increment',max_user_bids='$this->max_user_bids',max_bid_at_time='$this->max_bid_at_time',show_price_charge='$this->show_price_charge',buy_price_charge='$this->buy_price_charge', selected_deal = '$this->selected_deal'   , rtp_price_decrease_by='$this->price_decrease_by',buy_price_decrease_by='$this->buy_price_decrease_by',current_price='$this->current_price',restriction_price='$this->restriction_price',low_limit_price='$this->low_limit_price',start_date='$this->start_date',end_date='$this->end_date',created_date='$this->created_date',auction_type='$this->auc_type',status='$this->status',automate_create='$this->automate_create',display='$this->display',banner='$this->banner',hot_auction='$this->hot_auction',last_update='$this->current_date_time',page_title='$this->page_title',meta_key='$this->meta_key',meta_description='$this->meta_description',deal_title='$this->deal_title',deal_condition='$this->deal_description',deal_description_link='$this->deal_description_link',deal_description='$this->deal_description',additional_restriction='$this->additional_restriction',order_id='$this->current_order_id',user_id='$this->peekaboo_id',member_type='$this->peekaboo_type',approval_status='$auction_approval_status',closedauction_value='$this->choose_auction',zone_id='$this->zone_id'";
			$this->db->query($this->query_auction);
			if($zonesubuser != ''){
				$dealarrsubuser = ['dealid'=>$this->product_id];
				$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Insert Deal',serialize($dealarrsubuser));
			}
		}
    }



   function publisherfee(){
         print_r($_REQUEST);

		// $get_percentage_sql = "select `percentage` from `publisher_fee` where `zone_id` = ".$_SESSION['zoneid']; 
		// $get_percentage_query = $this->db->query($get_percentage_sql);
		// $result = $get_percentage_query->result_array();
		// $percenatge = $result['percentage'];
		// $publisher_fee = ($_POST['price'] * $percenatge)/100;
		// echo $publisher_fee;

   }


    function insert_peekaboo_auction(){



		$params = array();
		parse_str($_POST['data_to_use'], $params);    

 
 
		 $peekaboo_id = $this->allpeekabooId($params['business_id']);
		 $peekaboo_type = $this->allpeekabootype($params['business_id']);

		 
        
		if($params['login_type'] =='' || $params['login_type']=='0'){
			$certificate_approval_status=1;
			$auction_approval_status=1;
			$certificate_status='available';
		}else{

			// ++ certificate setting
			$certificate_sql_setting=$this->query="SELECT auto_approve_product FROM tbl_settings where 1";		
			$certificate_result_setting= $this->db->query($certificate_sql_setting);		
             $certificate_result_setting =   $certificate_result_setting->result_array();	

			$certificate_auto_approve_product=$certificate_result_setting[0]['auto_approve_product'];
			if($certificate_auto_approve_product==1){
				$certificate_approval_status=1;
				$certificate_status='available';
			}else{
				$certificate_approval_status=0;
				$certificate_status='pending';
				$certificate_status='available';
			}
			// -- certificate setting
			// ++ auction setting
			$auction_sql_setting=$this->query="SELECT auto_approve_auction FROM tbl_settings where 1";		
			$auction_result_setting= $this->db->query($auction_sql_setting);	
			$auction_result_setting =   $auction_result_setting->result_array();
		 	
			$auction_auto_approve_auction=$auction_result_setting[0]['auto_approve_auction'];
			if($auction_auto_approve_auction==1){
				$auction_approval_status=1;
			}else{
				$auction_approval_status=0;
			}
			
		}

 
 
        $this->job=$params['job'];

        $this->peekaboo_id = $peekaboo_id;

        $this->peekaboo_type = $peekaboo_type;

        date_default_timezone_set('Pacific/Auckland');

		$this->current_date_time=date('Y-m-d H:i:s');


 
		$this->product_id=trim($params['product_id']);		
		$this->cat_id=trim($params['cat_id']);
		$this->subcatID=trim($params['subcatID']);		 
		$this->product_name="CC-0-1";
		$this->model=trim($params['model']);
		$this->product_code=trim($params['product_code']);

		$this->company_name= str_replace("'", "\'", trim($params['company_name']));  
		$this->units_in_stock=empty($post['units_in_stock']) ? 1 : $params['units_in_stock'];
		$this->unit_price=trim($params['unit_price']);
		$this->purchase_price=trim($params['purchase_price']);
		$this->shipping_cost=trim($params['shipping_cost']);
		$this->automate_create=trim($params['automate_create']);
		$this->description=trim($params['certificate_description']); 
		$this->tech_description=str_replace("'", "\'", trim($params['deal_description']));
		$this->other_description=str_replace("'", "\'", trim($params['meta_description']));
		$this->user_id= trim($params['user_id']);
		$this->member_type=trim($params['member_type']);
		$this->product_status=mysql_real_escape_string($params['product_status']);
		$this->start_date=trim($params['start_date']);
		$this->selected_deal = trim($_REQUEST['deal_id']);
		 
    	$this->created_date = date("Y-m-d");
		$this->end_date=trim($params['end_date']);
		$this->publisher_fee=trim($params['publisher_fee']);
		$this->seller_fee=trim($params['seller_fee']);
		$this->seller_credit=trim($params['seller_credit']);
		// ++ for auction table
		$this->buy_price_decrease_by=trim($params['buy_price_decrease_by']);
		$this->current_price= trim($params['low_limit_price']);
		$this->low_limit_price= trim($params['low_limit_price']);
		$this->restriction_price= trim($params['restriction_price']);
		$this->additional_restriction= trim($params['additional_restriction']);
		$this->choose_auction=trim($params['choose_auction']);
		$this->page_title=str_replace("'", "\'", trim($params['page_title']) );
		$this->user_member_type=trim($params['user_member_type']);
		$this->meta_description=str_replace("'", "\'", trim($params['meta_description']));
		$this->deal_title=str_replace("'", "\'", trim($params['page_title']) );
		$this->deal_condition=trim($params['deal_condition']);

		$this->zone_id= trim($params['zone_id']);
		 
		$this->deal_description=str_replace("'", "\'", trim($params['deal_description']));
		$this->deal_description_link= str_replace("'", "\'", trim($params['page_title']) );
		$this->request_status = trim($params['request_status']);

		$this->certificate_status=trim($params['status_auction']);

		$this->status=trim($params['status_auction']);		
		$this->status_auction=trim($params['status_auction']);
	 
		// $this->start_date = date('Y-m-d', strtotime($this->start_date. ' + 3 days'));
		$this->start_date = date('Y-m-d', strtotime($this->start_date));

        $this->min_bid_cost = trim($params['min_bid_cost']);
		$this->display='Yes';
		$this->banner='Yes';
		$this->hot_auction='Yes';
		$this->auc_type='RTP';
	 
		$this->card_img= trim($params['uploadedInput']);
		$this->color_code=trim($params['color_code']);
		$this->cert_accept=trim($params['cert_accept']);

		if($this->cert_accept == 'accepted'){
		$this->consolation_price		=	trim($params['consolation_price']);
		$this->nobypass					=	trim($params['nobypass']);
		$this->buy_price_charge=3; 
		}else{
		$this->consolation_price='';
		$this->nobypass='';
		$this->buy_price_charge=1;
		}
		$this->numberofconsolation =  trim($params['numberofconsolation']) ;
 
           
         if($params['mode'] == 'edit'){




          $this->query_certificate="UPDATE   tbl_inventory_products SET  cat_id='$this->cat_id', subcat_id='$this->subcatID',product_name='$this->product_name',product_code='$this->product_code',company_name='$this->company_name',
						units_in_stock='$this->units_in_stock',unit_price='$this->unit_price',shipping_cost='$this->shipping_cost',
						last_modify_date='$this->current_date_time',card_img='$this->card_img',description='$this->description',model='$this->model',tech_description='$this->tech_description',other_description='$this->other_description',status='$certificate_status',purchase_price='$this->purchase_price',member_type='$this->member_type',approval_status='$certificate_approval_status',color_code='$this->color_code',cert_accept='$this->cert_accept',consolation_price='$this->consolation_price',nobypass='$this->nobypass', numberofconsolation = '$this->numberofconsolation', publisher_fee = '$this->publisher_fee', seller_fee = '$this->seller_fee',seller_credit = '$this->seller_credit',parent_id= 0,zone_id ='$this->zone_id' where product_id = ".$this->product_id;  

	    $this->db->query($this->query_certificate);

	 



	     $this->query_auction= "UPDATE tbl_auction SET bid_increment='$this->bid_increment',max_user_bids='$this->max_user_bids',max_bid_at_time='$this->max_bid_at_time',min_bid_cost='$this->min_bid_cost',show_price_charge='$this->show_price_charge',buy_price_charge='$this->buy_price_charge',rtp_price_decrease_by='$this->price_decrease_by', selected_deal = '$this->selected_deal' , buy_price_decrease_by='$this->buy_price_decrease_by',current_price='$this->current_price',restriction_price='$this->restriction_price',low_limit_price='$this->low_limit_price',start_date='$this->start_date',end_date='$this->end_date',created_date='$this->created_date',auction_type='$this->auc_type',status='$this->status',automate_create='$this->automate_create',display='$this->display',banner='$this->banner',hot_auction='$this->hot_auction',last_update='$this->current_date_time',page_title='$this->page_title',meta_key='$this->meta_key',meta_description='$this->meta_description',deal_title='$this->deal_title',deal_condition='$this->deal_description',deal_description_link='$this->deal_description_link',deal_description='$this->deal_description',additional_restriction='$this->additional_restriction',order_id='$this->current_order_id' ,approval_status='$auction_approval_status',closedauction_value='$this->choose_auction',zone_id='$this->zone_id'  where product_id = ".$this->product_id;  


	 
		$this->db->query($this->query_auction);




         }else{




	         $this->query_certificate="INSERT INTO tbl_inventory_products SET  cat_id='$this->cat_id',  subcat_id='$this->subcatID' ,product_name='$this->product_name',product_code='$this->product_code',company_name='$this->company_name',
							units_in_stock='$this->units_in_stock',unit_price='$this->unit_price',shipping_cost='$this->shipping_cost',
							last_modify_date='$this->current_date_time',card_img='$this->card_img',description='$this->description',model='$this->model',tech_description='$this->tech_description',other_description='$this->other_description',status='$certificate_status',purchase_price='$this->purchase_price',user_id='$this->peekaboo_id',member_type='$this->member_type',approval_status='$certificate_approval_status',color_code='$this->color_code',cert_accept='$this->cert_accept',consolation_price='$this->consolation_price',nobypass='$this->nobypass', numberofconsolation = '$this->numberofconsolation', publisher_fee = '$this->publisher_fee', seller_fee = '$this->seller_fee',seller_credit = '$this->seller_credit',parent_id= 0,zone_id ='$this->zone_id'";  
 
		    $this->db->query($this->query_certificate);

		    $this->product_id = $this->db->insert_id();



		    $this->query_auction="INSERT INTO tbl_auction SET product_id='$this->product_id',bid_increment='$this->bid_increment',max_user_bids='$this->max_user_bids',max_bid_at_time='$this->max_bid_at_time',min_bid_cost='$this->min_bid_cost',show_price_charge='$this->show_price_charge',buy_price_charge='$this->buy_price_charge', selected_deal = '$this->selected_deal'   , rtp_price_decrease_by='$this->price_decrease_by',buy_price_decrease_by='$this->buy_price_decrease_by',current_price='$this->current_price',restriction_price='$this->restriction_price',low_limit_price='$this->low_limit_price',start_date='$this->start_date',end_date='$this->end_date',created_date='$this->created_date',auction_type='$this->auc_type',status='$this->status',automate_create='$this->automate_create',display='$this->display',banner='$this->banner',hot_auction='$this->hot_auction',last_update='$this->current_date_time',page_title='$this->page_title',meta_key='$this->meta_key',meta_description='$this->meta_description',deal_title='$this->deal_title',deal_condition='$this->deal_description',deal_description_link='$this->deal_description_link',deal_description='$this->deal_description',additional_restriction='$this->additional_restriction',order_id='$this->current_order_id',user_id='$this->peekaboo_id',member_type='$this->peekaboo_type',approval_status='$auction_approval_status',closedauction_value='$this->choose_auction',zone_id='$this->zone_id'";

		 
			$this->db->query($this->query_auction);





         }






	 


    }
	
	public function publisher_fee(){
		$get_percentage_sql = "select `percentage` from `publisher_fee` where `zone_id` = ".$_REQUEST['zoneid']; 
		$result = $this->CommonController->SelectRawquery($get_percentage_sql,'resultArray');
		$percenatge = $result[0]['percentage'];
		$publisher_fee = ($_REQUEST['price'] * $percenatge)/100;
		echo $publisher_fee;
	}


	function upload_auction_list(){

 
	    $auction_id = $_POST['auction_id']; 

	    $sql = "select * from pb_cashcert where id =".$auction_id;

		$result = $this->db->query($sql);

	    $result1 = $result->result_array();	 

	    echo json_encode($result->result_array);



	}
	
	public function upload_deal_list(){
		$auction_id = $_POST['auction_id']; 
		$sql = "select * from deal_cashcert where id =".$auction_id;
		$result1 = $this->CommonController->SelectRawquery($sql,'resultArray');
		echo json_encode($result1);
	}

	    function createdeal($businessid=0,$fromzoneid=0){

       
       $data['businessid']=$businessid;

		$data['zoneid']=$data['common']['zoneid']; 

		$data['fromzoneid']=$fromzoneid;

		$user = $this->ion_auth->user()->row()->id;

        
        if($_REQUEST['mode'] =='edit' && $_REQUEST['productid'] ){        	    	

	   $auction_sql_setting =  'SELECT ip.* , a.* , c.cat_id , c.cat_name,ip.deal_product_id,ip.product_name,  a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update FROM tbl_deals a LEFT JOIN tbl_deals_products ip ON ip.deal_product_id=a.product_id LEFT JOIN tbl_category c ON c.cat_id=ip.cat_id WHERE a.product_id='.$_REQUEST['productid'].'   order by a.start_date ASC';

	    	$auction_result_setting= $this->db->query($auction_sql_setting);	
			$auction_result_setting =   $auction_result_setting->result_array();

			
			if(count($auction_result_setting) == 0){
                $data['editdata'] = 'No Auction Found';
                $data['editdataresponse'] = '0';
			}else{
 
				$data['editdata'] = $auction_result_setting;	 
                $data['editdataresponse'] = '1';
                
            }
 

        }




        $allcatgories = "SELECT * FROM tbl_category ORDER BY cat_id ASC";	
		$all_catgories = $this->db->query($allcatgories);
		$result_zone_mail[] = $all_catgories->row_array();
		// $data['categories'] = $all_catgories->result_array;
        
         $data['categories'] = $this->category_model->get_category_display_for_zone($fromzoneid);


		$pbcashcert = "SELECT * FROM `deal_cashcert`";	
		$pbcashcert =$this->db->query($pbcashcert);
		$result_zone_mail[] = $pbcashcert->row_array();
		$data['pbcashcert'] = $pbcashcert->result_array;
 

        $data['common']=$this->common_first($businessid,$fromzoneid);
        $data['businessid']=$businessid;
        $data['zoneid']=$fromzoneid;
        $data['payment_creditprice'] = $this->business->business_credit($fromzoneid);
        $data['right_container'] = $this->load->view("business/create_deals", $data, true);
        $this->common($data);
 
    }



    function peekaboo_createauction($businessid=0,$fromzoneid=0){

       
       $data['businessid']=$businessid;

		$data['zoneid']=$data['common']['zoneid']; 

		$data['fromzoneid']=$fromzoneid;

		$user = $this->ion_auth->user()->row()->id;

		
        if($_REQUEST['mode'] =='edit' && $_REQUEST['productid'] ){        	    	

	      $auction_sql_setting =  'SELECT ip.* , a.* , c.cat_id , c.cat_name,ip.product_id,ip.product_name,  a.auc_id,a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update FROM tbl_auction a LEFT JOIN tbl_inventory_products ip ON ip.product_id=a.product_id LEFT JOIN tbl_category c ON c.cat_id=ip.cat_id WHERE a.product_id='.$_REQUEST['productid'].'  AND a.auction_type="RTP" order by a.start_date ASC';

	    	$auction_result_setting= $this->db->query($auction_sql_setting);	
			$auction_result_setting =   $auction_result_setting->result_array();

			
			if(count($auction_result_setting) == 0){
                $data['editdata'] = 'No Auction Found';
                $data['editdataresponse'] = '0';
			}else{
 
				$data['editdata'] = $auction_result_setting;	 
                $data['editdataresponse'] = '1';
                
            }
 

        }

	    $data['categories'] = $this->category_model->get_category_display_for_zone($fromzoneid);
	      //print_r( $data['categories']);


        $allcatgories = "SELECT * FROM tbl_category ORDER BY cat_id ASC";	
		$all_catgories = $this->db->query($allcatgories);
		$result_zone_mail[] = $all_catgories->row_array();
		//$data['categories'] = $all_catgories->result_array;


		$pbcashcert = "SELECT * FROM `pb_cashcert`";	
		$pbcashcert =$this->db->query($pbcashcert);
		$result_zone_mail[] = $pbcashcert->row_array();
		$data['pbcashcert'] = $pbcashcert->result_array;

		$data['sub_header_name_from_zone']=$this->business_model->business_details($businessid);

         if($data['sub_header_name_from_zone']['type'] == 0){
         	$Buscat= 2;
         }else{
           $Buscat= 1;
         }
        // $data['categories']=$this->Category_new_model->get_all_subcategories_zone($Buscat,$fromzoneid,'create_business'); 
        // print_r($data['categories']);

        $data['common']=$this->common_first($businessid,$fromzoneid);
        $data['businessid']=$businessid;
        $data['zoneid']=$fromzoneid;
        $data['payment_creditprice'] = $this->business->business_credit($fromzoneid);
        $data['right_container'] = $this->load->view("business/peekaboo_auction_create", $data, true);
        $this->common($data);


         

 
	
    }


    function get_subcategories(){
  

		$data['sub_category_list'] = $this->Category_new_model->get_all_subcategories_zone($_REQUEST['cat_id'],$_REQUEST['iszoneid'],'create_business');
		$data['selectedSubcatId'] = $_REQUEST['selectedSubcatId'];
        $result = $this->load->view('zone/subpage/get_subcate_create_auctions_deals', $data, true);
       echo $result;
		 
		 
	}


	function common_first($businessid=0,$fromzoneid=0){



		$data=array();

		$user = $this->ion_auth->user()->row();

	 

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

        if (empty($user)) {

        	redirect('/', 'refresh');

        }	

        if (empty($user)) {

        	redirect('/', 'refresh');

        }			


		

		$data['from_zoneid']=isset($fromzoneid) ? $fromzoneid : 0; 

		$data['where_from']='business';

		/*if($data['from_zoneid']==0){

			 $data['businessname']=$this->business_model->business_details($businessid); 			

		}else{

			$data['businessname']=$this->zone_model->get_zone($data['from_zoneid']);

		}*/

		if($data['from_zoneid']!=0){

			$data['top_header_name']=$this->zone_model->get_zone($data['from_zoneid']); //var_dump($data['top_header_name']);

			$data['sub_header_name_from_zone']=$this->business_model->business_details($businessid);

			$data['from_where']='zone_business';			 

		}else{

			$data['top_header_name']=$this->business_model->business_details($businessid); //var_dump($data['top_header_name']);

			$data['sub_header_name_from_zone']=$this->business_model->business_details($businessid); 

			$data['from_where']='';

		}

		$data['user'] = $user;		

		$data['uid']= $uid; 

		$data["usergroup"]=$this->business->get_user_group1($uid);

		$usergrid=$data["usergroup"]->group_id;



        if(!empty($user)){

        	$data["email"] = $user->email;

        	$data["firstName"] = $user->first_name;

        	$data["admin"] = $this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III")) ? "yes" : "";

        }

		$data['businessid']=$businessid;  

		$data['zone']=$this->sales_zone->business_zone($businessid); 

		/* + Trial period remaining code + */ 

		if(isset($data['zone'][0]['zoneid'])){

			$zonepref=$this->ads->getZonePpreferencesByZone($data['zone'][0]['zoneid']);	

		}else{

			$zonepref = '';

		} 

		$trial_remaining = '' ;  

		/* - Trial period remaining code - */ 

 // This is added to get the APPROVAL of the businesses from  the as_settings_preference table.  -> 28/7/14

		$data['approval'] = $this->zone_model->get_approval_of_businesses($businessid); //var_dump($data['approval']['approval']);

		if($data['approval']['approval']==1) {

			$data['approval_message']= '(Viewable Paid Business)';

		}else if($data['approval']['approval']==-1) {

			$data['approval_message']= '(Not Viewable Paid Business)';

		}else if($data['approval']['approval']==2) {

			/* + Trial period remaining code + */ 

/*			$totaldayssecond = (isset($zonepref['trial_business_active']) ? $zonepref['trial_business_active'] : 0) * 86400 ;

			$starttimestamp = isset($data['sub_header_name_from_zone']['trialstarted']) ? $data['sub_header_name_from_zone']['trialstarted'] : 0;

			$totaldaystimestamp = $totaldayssecond + $starttimestamp ;

			$currenttimestamp = time() ;

			if($currenttimestamp < $totaldaystimestamp){

				$numDays = floor(abs($totaldaystimestamp - $currenttimestamp)/60/60/24);

				if($numDays != '' && $numDays != 0){

					$trial_remaining =  '-'.$numDays.' days Remaining' ;

					$data['trial_remaining'] = $trial_remaining ;

				}

			}*/

			/* - Trial period remaining code - */ 

			$data['approval_message']= '(Viewable Free Trial Business)'.$trial_remaining;

		}else if($data['approval']['approval']==-2) {

			$data['approval_message']= '(Not Viewable Free Trial Business)';

		}else if($data['approval']['approval']==3) {

			$data['approval_message']= '(Not Viewable, Businesses Uploaded)';

		}else if($data['approval']['approval']==-3) {

			$data['approval_message']= '(Not Viewable, Businesses Uploaded)';

		}

 // This is added to get the APPROVAL of the businesses from  the as_settings_preference table.	 -> 28/7/14

 		// + next prev edit section only for active paid business coming soon view

		$data['view_next_previous'] = $this->business->active_paid_trial_and_temp_cat($businessid);

 		// - next prev edit section only for active paid business coming soon view		

		$userzoneid=$data['zone'][0]['zoneid'];

		$data['zoneid']=$userzoneid; //var_dump($data['zoneid']); exit;

		//$data['zoneid']='';

		//var_dump($data['businessid']); var_dump($data['zoneid']);   

		/*$organization_status= $this->announcements->organization_status($businessid); 

		$data['organization_status']=$organization_status[0]['approval'];

		$data['zone']=$this->announcements->organization_zone($businessid);

		$userzoneid=$data['zone'][0]['zoneid']; 

		$data['org_name']=$data['zone'][0]['name'];

		$data['org_owner_id']=$data['zone'][0]['userid']; 

		$data['zoneid']=$userzoneid; 

		// newly added

		$data['getall_category']=$this->announcements->getall_category($businessid); */

		//$zone_userid = $this->session->userdata('session_zoneid');

		//$valid_zone_userid =$zone_userid['sesuserid'];

		//if($data['from_zoneid']!=0){
		

 


			$session_login_details=$this->session->userdata('session_login_details');

			

		$data['login_type']=$session_login_details['type'];

		$data['login_id']=$session_login_details['id'];

		$check_valid_url= $this->ion_auth->check_valid_url_other($uid,$userzoneid,$businessid,$fromzoneid,$data['where_from']);

		//var_dump($check_valid_url);//exit;

		$check_zoneid = $this->session->userdata('session_zoneid');

		$valid_zoneid = $check_zoneid['userzoneid'];



			if($check_valid_url==0){//var_dump(base_url('/index.php?zone='.$valid_zoneid));exit;

				//redirect(base_url('/index.php?zone='.$valid_zoneid), 'refresh');

				if($data['from_zoneid']!=0){ 

				   // $modified_url = base_url('/businessdashboard/businessdetail/'.$businessid.'/'.$valid_zoneid);

					$modified_url = base_url('/Zonedashboard/zonedetail/'.$valid_zoneid);

			        redirect($modified_url, 'location', 301);

				}else{ 

				   
				   if ($data['login_id']) {
				   	  $modified_url = base_url('/Zonedashboard/zonedetail/'.$data['login_id']);
				   }
				   elseif($user->Zone_ID) {
				   		$modified_url = base_url('/zone/'.$user->Zone_ID);
					}
					else{
						$modified_url = base_url();
					}

 
			       redirect($modified_url, 'location', 301);

				}

				//echo $modified_url;

			}

		//}

		//var_dump($data);

		

		$newsessiondata = array(

                   'usergrid'=>$usergrid,

                   'userzoneid'=>$userzoneid

        );
 
 


 

		$this->session->set_userdata('usersessiondata',$newsessiondata); //var_dump($data);  

		return $data;

	}

	

	function common($info){

		$info['from_zoneid']=$info['common']['from_zoneid'];		 

		$data['side_dashboard_container'] = $this->load->view("default/common/left_panel_business", $info, true); 

        $data['content'] = $this->load->view("content_new", $data, true); 

		$data['header']= $this->load->view("default/common/header", $data);

		

	}



	////////////  ++++++ Start categories menu list genarate in zone diretory left menu section in top ++++++   ////////////////////

	public function menu_generator($zoneid=0){ 
		$data=array();
		$data['category_list_food']=$this->Category_new_model->get_products_details($zoneid,1); 
		$data['category_list']=$this->Category_new_model->get_products_details($zoneid,0); 
		$data['category_list_other']=$this->Category_new_model->get_products_details($zoneid,14);
		ob_start();
		$this->load->view('directory/generate_zone_menu', $data);

		$var=ob_get_contents(); 

		ob_clean();

 
	}

	////////////  ++++++ End categories menu list genarate in zone diretory left menu section in top ++++++   ////////////////////

	

	################################################  Business Registration From Zone Locator Start  #################################################

	// added On 7.11.14

	function createABusiness($msg=false)

	{

		isset($_REQUEST['curr_url']) ? setcookie("cur_url", $_REQUEST['curr_url']) : '';

		$cur_url=$_COOKIE['cur_url'];

		// this session variables set in zone function, it's value is zoneid

		$session_cb_arr=$this->session->userdata('create_business_ses_id');

		$session_create_business_zoneid=$session_cb_arr['create_business_sesid'];

		//var_dump($session_create_business_zoneid);

		

		if(is_object($session_create_business_zoneid)){				

			$zoneid=$session_create_business_zoneid->id;			

		}else{		

			$zoneid=$session_create_business_zoneid;

		}

		

		if($this->ion_auth->logged_in()){

        $data = array();

		$data['cur_url']=$cur_url;

		

		if($this->session->userdata('session_zoneid_from_bus')){ //echo 1; // business owner

			$data['business_exist']=1;

			$usersession_data = $this->session->userdata('session_zoneid_from_bus');

     		$session_type_id=$usersession_data['busid']; //var_dump($session_type_id); //exit;

			$data['req_url']=base_url().'businessdashboard/businessdetail/'.$session_type_id;

		} else if($this->session->userdata('usersessiondata')!=''){ //echo 2;  // zone owner 

			$data['business_exist']=1;

			$session_type_arr=$this->session->userdata('usersessiondata');

			$session_type_id=$session_type_arr['userzoneid']; //var_dump($session_type_id);

			$data['req_url']=base_url().'Zonedashboard/zonedetail/'.$session_type_id;

		}else{ //echo 3;

			$data['business_exist']=0; $data['req_url']=0;

		}	

		

		

		//$data['business_exist']=$zoneid; 

        $auser = $this->ion_auth->user()->row();	

        if(!empty($auser)){

	        $uid = $auser->id;

			$data["uid"]=$uid;

			$data["email"] = $auser->email;

	        $data["firstName"] = $auser->first_name;

			//$data["company"] = $auser->company;				// added on 12.11.14 to get teh company name given at the time of registration

			$data["usergroup"]=$this->business->get_user_group1($uid);

	//var_dump($data["usergroup"]);

        }

		

		$data['category_list']=$this->Category_new_model->get_all_categories_zone($zoneid,'create_business',$data["usergroup"]->group_id);

	//var_dump($data['category_list']); exit;

        $data['msg']=$msg;

        $data['user'] = $auser;

        

        $data['zone_null'] = 'create_business';

        

        $data['referrer'] = !empty($_REQUEST['Referrer']) ? $_REQUEST['Referrer'] : 'dashboards';

        $data['state_list'] = $this->states->get_state_dropdown();

        //$data['users_list'] = $this->users->get_user_list(true);

		

		$users_all_zone = $this->sales_zone->users_all_zone($uid); //var_dump($users_all_zone);

		if($data["usergroup"]->group_id==4){

			$data['users_list'] = $this->users->get_user_list_zone($users_all_zone);

			$data['where_from']='from_zone';

		}else{

			$data['where_from']='from_business';

		}



		$data['ckeditor_staterad'] = array(

            //ID of the textarea that will be replaced

            'id' 	=> 	'stater_ad_message',

            'path'	=>	'assets/ckeditor',

            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"550px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height

        ));

		

        $data['hideSlider'] = true;		

        //$data['right_container'] = $this->load->view("dashboards/create_a_business", $data, true);

		$data['right_container'] = $this->load->view("business/create_a_business", $data, true);

        $data['content'] = $this->load->view("content", $data, true); 

        $this->load->view("default/blank", $data);

	}else{

		header("Location: ".base_url());

		}	

	}

	################################################  Business Registration From Zone Locator End  #################################################

	

	

	

	

	################################################  Business Data Part Start #################################################################

	

# + businessdetail 

	public function businessdetail($businessid=0, $page = ''){
    	$editsnap = isset($_REQUEST['edit'])?$_REQUEST['edit']:'';
	  	$snapday = isset($_REQUEST['day'])?$_REQUEST['day']:'';
		$amazonurl = $this->myconfig->AWSimageurl;
		$buinessshareurl = $this->myconfig->buinessshareurl;
		$fromzoneid = $this->CommonController->redirectToZone();
		$subuserpageArr = ['zs1'=>'businessdetail','zs2'=>'dealreport','zs3'=>'businessbidrank','zs4'=>'singleusermultiplelogin','zsuser1'=>'zonecreatesubuser','zsuser2'=>'zoneshowsubuser','zma1'=>'makenewadvertisement','zma2'=>'viewads','zcd1'=>'create_deal','zcd2'=>'viewdeals','zco1'=>'orderapproval','zco2'=>'orderstatus','zes1'=>'everydayfoodspecial'];


		
		$this->CronController->rankbusiness($fromzoneid);
		$businessArr = $pbcashcert = $categories = $keyaws = $EmailformatingSaved = $subcatnew = $all_sponsored_business_details = $selected_display_categories = $display_categories =  $display_categories = $adsarr = $get_paypal_info = $approval_message = $adsarr = $loginbuttondata = $paypal_info = $datasubuserArr1 = $businessrankbid = $snaptimeArr = $snapbusArr = $finalsnapbusArr = $htmladdsnapArr = $snapdealsArr = [];
	   	$login_type = $login_id = $refer_code = $user_id = $buttonhtml = $businessshorturl = '';

	   	$bid = 1;
	   	$snapupdatebutton = 'hide';
		$user = $this->ionAuth->user()->row();
	   	$uid = $business_first_password_change = $nonofusersnapfilteron =  0;
	   	$subuser = isset($_GET['subuser'])?$_GET['subuser']:'';
	   	$subuserid = isset($_GET['subuserid'])?$_GET['subuserid']:'';
  	 	$pagesidebar = isset($page)?$page:'businessdetail';
	  	$subusersession = $this->CommonController->getSession('subuserlogin');
	   	if($subuser != ''){
	   		$scrapresponse = $this->CommonController->getAutoLoginbusiness($subuser);
	  		$this->CommonController->setSession('subuserlogin', $subuser);
	  	}
	  	if($subusersession != ''){
			$subuserquery="SELECT * FROM zone_users WHERE username='".$subusersession."' AND type='business'";
			$subuserArr = $this->CommonController->SelectRawquery($subuserquery);
			$datasubuser = isset($subuserArr[0]['data'])?$subuserArr[0]['data']:'';
			if($datasubuser != ''){
				$combineArrsubuser = [];
				$datasubuserArr1 = unserialize($datasubuser);
				foreach ($datasubuserArr1 as $sk => $sv) {
					if(isset($subuserpageArr[$sv])){
						$combineArrsubuser[] = $subuserpageArr[$sv]; 
					}
				}
				if(!in_array($pagesidebar, $combineArrsubuser)){
					echo "<div style='width:50%;height: 250px;margin: auto;background: #c6c6c6;'><p style='padding: 90px;font-size: 25px;'>You dont have a Permission to Excess this page</p></div>";
					die;
				}
				
			}
	  	}

	   	if(!empty($user)){ 
	   		$uid = $user->id;
	   		$business_first_password_change = $user->password_change;
	   	} 
        if (empty($uid)) {
           	return redirect()->to(base_url().'/zone/'.$fromzoneid.'/');
	   	}else{
	   		$session_login_details = $this->CommonController->getSession('session_login_details');
	   		$login_type = $session_login_details['type'];
	   		$login_id = $session_login_details['id'];
	   		if($login_type != 5 && $login_type != 16){
		   		return redirect()->to(base_url());
        	}
	   	}
  	 	$zone=$this->SalesZone->business_zone($businessid);
  	 	$zoneid=isset($zone[0]['zoneid'])?$zone[0]['zoneid']:$fromzoneid;
  	 	$zone_name = $this->CommonController->SelectDataMultiWay('sales_zone','name','column',['id' => $zoneid]); 
  	 	$approval = $this->Zone_model->get_approval_of_businesses($businessid);
  	 	if($approval['approval']==1) {
			$approval_message = '(Viewable Paid Business)';
		}else if($approval['approval']==-1) {
			$approval_message = '(Not Viewable Paid Business)';
		}else if($approval['approval']==2) {
			$approval_message = '(Viewable Free Trial Business)';
		}else if($approval['approval']==-2) {
			$approval_message = '(Not Viewable Free Trial Business)';
		}else if($approval['approval']==3) {
			$approval_message = '(Not Viewable, Businesses Uploaded)';
		}else if($approval['approval']==-3) {
			$approval_message = '(Not Viewable, Businesses Uploaded)';
		}



		$usergroup=$this->Business->get_user_group1($uid);
		$group_id=$usergroup->group_id;
		$business_sponsored_status = $this->Business_model->get_sponsor_business_status($businessid);
		if($fromzoneid!=0){
			$top_header_name = $this->Zone_model->get_zone($fromzoneid); 
			$sub_header_name_from_zone = $this->Business_model->business_details($businessid);
			$from_where = 'zone_business';			 
		}else{
			$top_header_name = $this->Business_model->business_details($businessid); 
			$sub_header_name_from_zone = $this->Business_model->business_details($businessid); 
			$from_where = '';
		}
		$business_search_value = '';//pending isset($this->CommonController->getSession('business_search_value'))?$this->CommonController->getSession('business_search_value'):'';
		$businessowner_zoneowner = $this->Business->business_owner_zone_owner($businessid);
		$business = $this->Business->get_business_by_id($businessid);
		$addressdata = $this->Business->addressdata($businessid);
		if($addressdata != ''){
			$adsemail = $addressdata->contactemail;	
			$adsfirstname = $addressdata->contactfirstname;
			$adslastname = $addressdata->contactlastname;
			$adsaddress_1 = $addressdata->street_address_1;
			$adsaddress_2 = $addressdata->street_address_2;
			$adscity = $addressdata->city;
			$adszip_code = $addressdata->zip_code;
			$adswebsite = $addressdata->website;
			$adsphone = $addressdata->phone;
			$adsservice_number = $addressdata->service_number;
			$adsaudio_greetings = $addressdata->audio_greetings;
			$adsaudio_presentation = $addressdata->audio_presentation;
			$adsvideo_presentation = $addressdata->video_presentation;
			$business_owner_id = $addressdata->business_owner_id;
			$logo = $addressdata->logo;
		}else{
			$adsemail = '';	
			$adsfirstname ='';
			$adslastname = '';
			$adsaddress_1 = '';
			$adsaddress_2 = '';
			$adscity = '';
			$adszip_code = '';
			$adswebsite = '';
			$adsservice_number = '';
			$adsaudio_greetings = '';
			$adsaudio_presentation = '';
			$adsvideo_presentation = '';
			$adsphone = '';	
			$business_owner_id = '';
			$logo = '';
		}
		$state_list = $this->States->get_state_dropdown();
		$business_type = $this->Business->get_business_type_by_id($businessid,$zoneid);
		$operation = $this->Business->getOperationHour($businessid,$zoneid);
		$userid = $sub_header_name_from_zone['business_owner_id'];
		$business_owner_details = $this->Users->get_user_details($userid);
		$zone= $this->Zone_model->get_zone($zoneid);
		$zone_owner = $this->ion_auth->user($zone['sales_rep_id'])->row();
		$pbcashqry = "SELECT * FROM `deal_cashcert`";	
	   	$pbcashcert = $this->CommonController->SelectRawquery($pbcashqry,'resultArray');
		
		$subqry = 'SELECT  a.id as subcatid,a.catid,a.name as subcatname,b.id as subsubid,b.name as subsubname FROM category_subcategory_new as a LEFT JOIN category_sub_subcategory_new as b on a.id=b.parent_id where a.catid=1 AND b.parent_type ="s" ORDER BY a.id';
   	   	$subcategory = $this->CommonController->SelectRawquery($subqry,'resultArray');
   	   	foreach ($subcategory as $k => $v) {
   	   		$subcatnew[$v['subcatname']][] = $v;
   	   	}
   	   	$dealArr = $this->alldeals($zoneid,$userid);
   	   	$businessArr = $this->create_deal($zoneid,$businessid);
 
   	   	foreach ($businessArr as $key => $value) {
   	   		$lowerlimit=0; $upperlimit=1000; 
		   	$adsarr[] = $this->Ads_model->get_ads_for_business_new($value['businessid'],$uid,$lowerlimit,$upperlimit,1,$value['name'],$value['insert_via_csv']); 
   	   	}
   	   	if(!empty($business_owner_id)){
   	   		$alternate_phone = $subcategory = $this->CommonController->SelectRawquery("SELECT `alternate_phone` FROM users WHERE id=".$business_owner_id."",'row')->alternate_phone;
		}

		$pbcashqry="SELECT a.*,b.start_date,b.end_date,b.created_date,b.deal_title,b.deal_description,b.status,c.card_img,d.email,d.first_name,d.last_name,d.phone,e.purchasedAt FROM tbl_deals_purchased_meta as a 
 			INNER JOIN tbl_deals as b ON a.dealID=b.deal_id 
			INNER JOIN tbl_deals_products as c ON b.product_id=c.deal_product_id 
			INNER JOIN users as d ON d.id=a.userId
			INNER JOIN tbl_deals_purchased as e ON e.userId=a.userId
 			WHERE a.busId=".$businessid." GROUP BY b.deal_id";
		$purchasedealArr = $this->CommonController->SelectRawquery($pbcashqry,'resultArray');
	   	$get_paypal_info = $this->Zone_model->checkExistPaypalid($zoneid);
		if(is_array($get_paypal_info) && count($get_paypal_info) > 0){
			$paypal_info = $get_paypal_info[0];
		}
		$OrderApprovalArr = $this->allorderApprovals($businessid);
		$OrderstatusArr = $this->allorderstatus($businessid);
    	
    	$all_claimed_zip = [];
    	if($pagesidebar == 'singleusermultiplelogin'){
   			$groupArr1 = $this->CommonController->getbusinessloginbutton($uid);
      		if(count($groupArr1) > 0){
       			$phonelogin = $groupArr1['phonelogin'];
        		$emaillogin = $groupArr1['emaillogin'];
        		$groupArr = $groupArr1['groupArr'];
        		foreach ($groupArr as $gv) {
          			if($gv == 5){
          				$buttonhtml .= '<li class="loginbutton"><button type="button" phone="'.$phonelogin.'" email="'.$emaillogin.'" group="5" class="btn btn-info singlelogin">Login as Business</button></li>';
          			}
          			if($gv == 10){
          				$buttonhtml .= '<li class="loginbutton"><button type="button"  phone="'.$phonelogin.'" email="'.$emaillogin.'" group="10" class="btn btn-info singlelogin">Login as Resident</button></li>';
          			}
          			if($gv == 8){
          				$buttonhtml .= '<li class="loginbutton"><button type="button" phone="'.$phonelogin.'" email="'.$emaillogin.'" group="8" class="btn btn-info singlelogin">Login as Organization</button></li>';
          			}
          			if($gv == 15){
          				$buttonhtml .= '<li class="loginbutton"><button type="button"  phone="'.$phonelogin.'" email="'.$emaillogin.'" group="15" class="btn btn-info singlelogin">Login as Employee</button></li>';
          			}
          			if($gv == 7){
          				$buttonhtml .= '<li class="loginbutton"><button type="button"  phone="'.$phonelogin.'" email="'.$emaillogin.'" group="7" class="btn btn-info singlelogin">Login as Visitor</button></li>';
          			}
        		}
      		}else{
      			$buttonhtml .= '<li>No Data Found</li>'; 	
      		}
   		}

   		if($pagesidebar == 'zoneshowsubuser'){
			$userquery="SELECT * FROM zone_users WHERE zoneowner='".$userid."' AND type='business'";
			$businessrankbid = $this->CommonController->SelectRawquery($userquery);
		}

		if($pagesidebar == 'zonecreatesubuser'){
			if($subuserid > 0){
				$userquery="SELECT * FROM zone_users WHERE id='".$subuserid."' AND type='business'";
				$businessrankbid = $this->CommonController->SelectRawquery($userquery);
			}
		}

		if($pagesidebar == 'businessshorturl'){
			$shorturlqry = "SELECT * FROM business as a LEFT JOIN address as b ON a.addressid=b.id WHERE a.id=".$businessid."";
			$shorturlArr = $this->CommonController->SelectRawquery($shorturlqry,'row');
	   		$businessshorturl = isset($shorturlArr->shorturl)?$shorturlArr->shorturl:'';
	   		if($businessshorturl == ''){
	   			$businessshorturl = $this->genbusinessshorturl($shorturlArr); 
	   			$this->CommonController->updateData('business', ['shorturl'=>$businessshorturl],['id'=>$businessid]);
	   		}else{
	   			$businessshorturl = $shorturlArr->shorturl;
	   		}
	  	}

	  	if($pagesidebar == 'add_business_snap'){
			$snaptimeqry = "SELECT * FROM snap_start_time Order by id";
			$snaptimeArr = $this->CommonController->SelectRawquery($snaptimeqry);
			if($editsnap == 1){
				$snapupdatebutton = '';
				$datasnaptime = $this->getsnapbussdata($businessid,$snapday);
				if(count($datasnaptime) > 0){
					foreach ($datasnaptime as $k => $v) {
						if(isset($v->snap_time) && count($v->snap_time) > 0){
							foreach ($v->snap_time as $k1 => $v1) {
								if($v1->dayarr == 1){$v1->dayword = 'M';}
								if($v1->dayarr == 2){$v1->dayword = 'T';}
								if($v1->dayarr == 3){$v1->dayword = 'W';}
								if($v1->dayarr == 4){$v1->dayword = 'Th';}
								if($v1->dayarr == 5){$v1->dayword = 'F';}
								if($v1->dayarr == 6){$v1->dayword = 'Sa';}
								if($v1->dayarr == 7){$v1->dayword = 'Su';}

								$htmladdsnapArr[] = '<div class="snaplistsubmaindiv">
        							<div class="snaplistsubdiv" dayid="'.$v1->dayarr.'" starttime="'.$v1->starttimearr.'" endtime="'.$v1->endtimearr.'" noofpeople="'.$v1->noofpeoplearr.'" snapsendtype="'.$v1->snapsendtypearr.'">'.$v1->dayword.' '.$v1->starttimeword.'-'.$v1->endtimeword.' '.$v1->noofpeoplearr.'<span class="snaplistsubspan">X</span></div>
    							</div>';
							}
						}
					}
				}
			}
			// $snaponuserqry = "SELECT * FROM global_snap_userbusiness_settings WHERE bus_id=".$businessid."";
			// $nonofusersnapfilteron = $this->CommonController->SelectRawquery($snaponuserqry,'count');
			$snapdealsArr = $this->CommonController->getdealsbybusiness($businessid);
	   	}
	   	if($pagesidebar == 'show_business_snap'){
	   		$snaponuserqry = "SELECT * FROM global_snap_business_settings WHERE bus_id=".$businessid." GROUP By dealId";
			$finalsnapbusArr = $this->CommonController->SelectRawquery($snaponuserqry,'result');
			// $finalsnapbusArr = $this->getsnapbussdata($businessid);
			if(count($finalsnapbusArr) > 0){
				foreach ($finalsnapbusArr as $k => $v) {
					$v->dealname = $this->CommonController->getsinglecolumndata('tbl_deals','deal_title','deal_id',$v->dealId);
					if($v->dealname == ''){
						$v->dealname = $this->CommonController->getsinglecolumndata('tbl_deals','deal_description_link','deal_id',$v->dealId);	
					}
					if($v->dealname == ''){
						$v->dealname = $this->CommonController->getsinglecolumndata('tbl_deals','deal_description','deal_id',$v->dealId);	
					}	
				}
			}
	   	}
	   	if($pagesidebar == 'claim_business_snap'){
			$sql = "SELECT * FROM global_snap_user_claim_time where bus_id='".$businessid."' GROUP By dealID";
            $finalsnapbusArr = $this->CommonController->SelectRawquery($sql,'result');
            if(count($finalsnapbusArr) > 0){
            	foreach ($finalsnapbusArr as $k => $v) {
            		$useridArr = $this->CommonController->getuserdetail($v->user_id);
            		$v->dayword = $this->CommonController->getsinglecolumndata('snap_week_days','day','id',$v->day);	
					$v->starttimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v->snaptimeIn);	
					$v->endtimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v->snaptimeout);
					$v->date = date('d-m-Y', strtotime($v->created_at));
					$v->first_name = $useridArr->first_name;
					$v->last_name =  $useridArr->last_name;
					$v->email = $useridArr->email;
					$v->phone = $useridArr->phone;
            	}
            }
	   	}
	   	return view('businessdashboard',array('zoneid' => $zoneid,'zone_id' => $zoneid,'fromzoneid' => $fromzoneid,'zone_name' => $zone_name,'pagesidebar' => $pagesidebar,'approval' => $approval,'group_id' => $group_id,'business_sponsored_status' => $business_sponsored_status,'businessid' => $businessid,'top_header_name' => $top_header_name,'sub_header_name_from_zone' => $sub_header_name_from_zone,'from_where' => $from_where,'approval_message' => $approval_message,'business_search_value' => $business_search_value,'businessowner_zoneowner' => $businessowner_zoneowner,'business' => $business,'addressdata' => $addressdata,'state_list' => $state_list,'business_type' => $business_type,'operation' => $operation,'business_owner_details' => $business_owner_details,'user_id' => $userid,'refer_code'=>'','zone_owner'=>$zone_owner,'pbcashcert'=>$pbcashcert,'login_type'=> $login_type,'via' => 'businessdashboard','subcatnew' => $subcatnew,'dealArr' => $dealArr,'adsarr' => $adsarr,'addapproval'=> 1,'adsemail'=> $adsemail,'adsfirstname' => $adsfirstname,'adslastname'=>$adslastname ,'adsaddress_1'=>$adsaddress_1 ,'adsaddress_2'=>$adsaddress_2 ,'adscity'=>$adscity ,'adszip_code'=>$adszip_code ,'adswebsite'=>$adswebsite ,'adsservice_number'=>$adsservice_number ,'adsaudio_greetings'=>$adsaudio_greetings ,'adsaudio_presentation'=>$adsaudio_presentation ,'adsvideo_presentation'=>$adsvideo_presentation,'adsphone'=>$adsphone,'alternate_phone'=>$alternate_phone,'logo'=>$logo,'purchasedealArr'=>$purchasedealArr,'business_first_password_change'=>$business_first_password_change,'paypal_info'=>$paypal_info,'get_paypal_info'=>$get_paypal_info,'bid'=>$bid,'OrderApprovalArr'=>$OrderApprovalArr,'OrderstatusArr'=>$OrderstatusArr,'all_claimed_zip'=>$all_claimed_zip,'buttonhtml'=>$buttonhtml,'businessrankbid'=>$businessrankbid,'subuser'=>$subuser,'datasubuserArr1'=>$datasubuserArr1,'subusersession'=>$subusersession,'amazonurl'=>$amazonurl,'businessshorturl'=>$businessshorturl,'buinessshareurl'=>$buinessshareurl,'snaptimeArr'=>$snaptimeArr,'uid'=>$uid,'finalsnapbusArr'=>$finalsnapbusArr,'htmladdsnapArr'=>$htmladdsnapArr,'snapupdatebutton'=>$snapupdatebutton,'editsnap'=>$editsnap,'snapday'=>$snapday,'nonofusersnapfilteron'=>$nonofusersnapfilteron,'snapdealsArr'=>$snapdealsArr));
  	}

  	public function getcountsnapuseremaillist(){
  		$zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:'';
    	$busid = isset($_REQUEST['busid'])?$_REQUEST['busid']:'';
		$daydb = $this->CommonController->getcurrentdayid();
		$finalsnapbusArr = [];
		$totalusers = 0;
		$sql = "SELECT * FROM global_snap_business_settings where bus_id=".$busid." AND created_for_zone=".$zoneid." AND snap_week_days=".$daydb."";
        $snapbusArr = $this->CommonController->SelectRawquery($sql,'result');
        if(count($snapbusArr) > 0){
        	foreach($snapbusArr as $k => $v) {
				$snaptimejson = $v->snap_time;
				$snaptimeArr  = json_decode($snaptimejson);
				foreach ($snaptimeArr as $k1 => $v1){
					$finalsnapbusArr[$busid][$v1->dayarr][$v1->starttimearr][$v1->endtimearr] = $v->status;
					
				} 
			}
			$snap_users_settings_sql = "SELECT * FROM users where Zone_ID=".$zoneid." AND snap_settings IN (1,2)";
        	$snap_users_settings_Arr = $this->CommonController->SelectRawquery($snap_users_settings_sql,'result');
        	if(count($snap_users_settings_Arr) > 0){
        		foreach ($snap_users_settings_Arr as $k => $v) {
        			if($v->snap_settings == 1){
        				$totaluserscount = $this->CommonController->getsnaptimearr('global_snap_userbusiness_settings',$v->id,$zoneid,$finalsnapbusArr,$busid);	
        			}else if($v->snap_settings == 2){
        				$totaluserscount = $this->CommonController->getsnaptimearr('global_snap_business_settings',$v->id,$zoneid,$finalsnapbusArr,$busid);
        			}
        			$totalusers = $totalusers+$totaluserscount;
        		}
        	}
        }
        echo json_encode(['msg'=>'data fetch','type'=>'success','data'=>$totalusers]);
        die;
    }

  	public function getsnapbussdata($businessid,$day = ''){
  		$snapbusqry = "SELECT * FROM global_snap_business_settings WHERE bus_id=".$businessid."";
		if($day != ''){
  			$snapbusqry .= " AND snap_week_days=".$day."";
  		}
  		$snapbusqry .= " Order by id"; 
		$snapbusArr = $this->CommonController->SelectRawquery($snapbusqry,'result');
		if(count($snapbusArr) > 0){
			foreach ($snapbusArr as $k => $v) {
				$snaptimejson = $v->snap_time;
				$snaptimeArr  = json_decode($snaptimejson);
				$snaptimeArr1 = [];
				foreach ($snaptimeArr as $k1 => $v1){
					$v1->dayword = $this->CommonController->getsinglecolumndata('snap_week_days','day','id',$v1->dayarr);	
					$v1->starttimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v1->starttimearr);	
					$v1->endtimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v1->endtimearr);
					$snaptimeArr1[] = $v1;
				} 
				$v->snap_time = $snaptimeArr;
				$finalsnapbusArr[$v->snap_week_days] = $v;	
			}
		}
		return $finalsnapbusArr;
  	}

	/** This function is generating business short url and show on business dashboard section. **/

  	public function genbusinessshorturl($arr = [], $busId = 0){
		$businessname = $arr->name;
		$explodebusname = explode(' ', $businessname);
		$businessuserid = $arr->business_owner_id;
		$businesszipcode = $arr->zip_code;

		$filtername = $explodebusname[0];
		
		$filterfirstuserid = substr($businessuserid, 0, 3);
		$filterlastuserid = substr($businessuserid, 3, 3);

		$filterfirstzipcode = substr($businesszipcode, 0, 3);
		$filterlastzipcode = substr($businesszipcode, 3, 3);
		
		$firsturl = $filtername.''.$filterfirstuserid;
		$secondurl = $filtername.''.$filterlastuserid;
		$thirdurl = $filtername.''.$filterfirstuserid.''.$filterfirstzipcode;
		$fourthurl = $filtername.''.$filterfirstuserid.''.$filterlastzipcode;
		$fifthurl = $filtername.''.$filterlastzipcode.''.$filterfirstuserid.''.$filterfirstzipcode;
		$finalurl = $fifthurl;

		$existsfirsturl = $this->CommonController->SelectDataMultiWay('business','shorturl','column',['shorturl' => $firsturl]); 

		if($existsfirsturl != ''){
  	 		$existssecondurl = $this->CommonController->SelectDataMultiWay('business','shorturl','column',['shorturl' => $secondurl]);
  	 		if($existssecondurl != ''){
  	 			if($existsthirdurl != ''){
  	 				$existsfourthurl = $this->CommonController->SelectDataMultiWay('business','shorturl','column',['shorturl' => $fourthurl]);
  	 				if($existsfourthurl != ''){
  	 					$existsfifthhurl = $this->CommonController->SelectDataMultiWay('business','shorturl','column',['shorturl' => $fifthurl]);
  	 					if($existsfifthhurl != ''){
  	 						return $finalurl;
  	 					}else{
  	 						return $fifth;	
  	 					}
  	 				}else{
  	 					return $fourthurl;	
  	 				}
  	 			}else{
  	 				return $thirdurl;		
  	 			}
  	 		}else{
  	 			return $secondurl;	
  	 		}
  	 	}else{
  	 		return $firsturl;
  	 	}
  	}

  	public function getzipcodes(){
    	$search = isset($_REQUEST['q'])?$_REQUEST['q']:'';
    	if($search != ''){
      	$sql_get_categories = "SELECT *  FROM tblClaimedZips WHERE zip LIKE '%".$search."%' LIMIT 20";
      	$all_claimed_zip = $this->CommonController->SelectRawquery($sql_get_categories, 'result');
		if(count($all_claimed_zip) > 0){
        foreach ($all_claimed_zip as $k => $v) {
          $v->items = $v->zip;
        }
      }
      echo json_encode($all_claimed_zip);
      die;
    }
  	}

  	public function getStates(){
    	$search = isset($_REQUEST['q'])?$_REQUEST['q']:'';
    	$stateArr = [];
    	if($search != ''){
      		$sql_get_categories = "SELECT a.state as state_id,a.primarycity, b.zone_id,b.zip_code,c.name as state_name FROM zipcode as a LEFT JOIN zip_code_zone as b ON a.zip = b.zip_code LEFT JOIN states as c ON a.state = c.code LIMIT 20";
      		$all_claimed_zip = $this->CommonController->SelectRawquery($sql_get_categories, 'result');
			if(count($all_claimed_zip) > 0){
        		foreach ($all_claimed_zip as $k => $v) {
          			$v->items = $v->state_name;
        		}
        		foreach ($all_claimed_zip as $k => $v) {
        			$stateArr[$v->state_id] = $v;	
        		}
      		}
      		echo json_encode($stateArr);
      		die;
    	}
  	}

	public function create_deal($zoneid=false,$fromzoneid=0){   
    	$listbusiness = 'select a.businessid ,b.id,b.name,b.contactfirstname,b.contactlastname,b.contactemail,c.phone,c.zip_code ,b.insert_via_csv from ads_setting_preferences a INNER JOIN business b ON a.businessid=b.id INNER JOIN address c ON b.addressid=c.id LEFT JOIN ads f ON b.id=f.business_id LEFT JOIN ad_to_zone g ON f.id=g.adid LEFT JOIN ad_category_subcategory h ON f.id=h.adid where a.settingszoneid='.$zoneid.' and b.id='.$fromzoneid.' and a.type IN(1,2) and a.isdefault IN(0,1) and a.approval IN(1,2,3,-1,-2,-3) GROUP BY a.businessid ORDER BY trim(b.name) asc';
		return $this->CommonController->SelectRawquery($listbusiness,'resultArray');
    }

	public function getMyZoneBusiness($zoneid = 0,$lowerlimit = 1,$upperlimit = 10){
		$like = [];
	   $zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:$zoneid;
	   $catoption = isset($_REQUEST['catoption'])?$_REQUEST['catoption']:'';
	   $selectcatsubcat = isset($_REQUEST['selectcatsubcat'])?$_REQUEST['selectcatsubcat']:'';
   	   $joinArr[] = ['table' => 'ads_setting_preferences as b','link' => 'a.id=b.businessid','type' => 'left'];
	   $joinArr[] = ['table' => 'address as c','link' => 'c.id=a.addressid','type' => 'left'];
   	   $joinArr[] = ['table' => 'ads as d','link' => 'd.business_id=a.id','type' => 'left'];
   	   $joinArr[] = ['table' => 'ad_to_zone as e','link' => 'd.id=e.adid','type' => 'left'];
   	   $select = 'a.id,a.name,a.contactfirstname,a.contactlastname,c.phone,c.zip_code';
   	   $where = ['b.settingszoneid' => $zoneid];
   	   
   	   if($catoption != ''){
   	   	if($catoption == 'category'){
		   $joinArr[] = ['table' => 'ad_category_subcategory as f','link' => 'd.id=f.adid','type' => 'left'];
		   $where = ['b.settingszoneid' => $zoneid,'f.catid' => $selectcatsubcat];	
   	   	}
   	   	if($catoption == 'subcategory'){
		   $joinArr[] = ['table' => 'ad_category_subcategory as f','link' => 'd.id=f.adid','type' => 'left'];
		   $where = ['b.settingszoneid' => $zoneid,'f.subcatid' => $selectcatsubcat];	
   	   	}
   	   	if($catoption == 'contains'){
   	   		$like[] = ['column' => 'a.name','match' => $selectcatsubcat,'type' => 'both'];
   	   	}
   	   	if($catoption == 'startwith'){
   	   		$like[] = ['column' => 'a.name','match' => $selectcatsubcat,'type' => 'after'];
   	   	}
   	   }
	   $data = $this->CommonController->SelectJoinMulti('business as a', $joinArr,$where,[],['a.name' => 'ASC'],$select,'','','',$like);
   	   if($catoption != ''){
   	   	echo json_encode($data);die;
   	   }else{
   	   	return $data;
   	   }
	}



	public function buycredits($businessid=false,$fromzoneid=0){
 		$data['common']=$this->common_first($businessid,$fromzoneid);
        $data['payment_creditprice'] = $this->business->business_credit($fromzoneid);
		$data['right_container'] = $this->load->view("business/buycredits", $data, true); 
		$this->common($data);
	}





# - businessdetail

	public function jot_form_view_code($payer_id,$reciver_id){

		$data['embed_jotform_code'] = $this->business_model->fetch_embed_jotform_code($reciver_id);



		$this->load->view("business/zone_jot_form_view",$data);



	}



	

	public function SaveBusinessFromBusiness(){
		$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id']; 
		$zoneids = empty($_REQUEST['zoneids']) ? 0 : $_REQUEST['zoneids'];
		$zone_id = empty($_REQUEST['zoneids']) ? 0 : $_REQUEST['zoneids'];
		$name = stripslashes($_REQUEST['name']);
		$addressid = $_REQUEST['addressid'];
		$restaurant_type = $_REQUEST['restaurant_type'];
		$contactemail = $_REQUEST['contactemail'];
		$website = !empty($_REQUEST['website']) ? $_REQUEST['website'] : '';
		$contactfirstname = stripslashes($_REQUEST['contactfirstname']);
		$contactlastname = stripslashes($_REQUEST['contactlastname']);
		$contactfullname = $contactfirstname." ".$contactlastname;
		$business_owner_id = $_REQUEST['business_owner_id'];
		$street1 = stripslashes($_REQUEST['street1']);
		$street2 = stripslashes($_REQUEST['street2']);
		$audio_presentation = ($_REQUEST['audio'] != '') ? $_REQUEST['audio'] : '';
		$video_presentation = ($_REQUEST['video'] != '') ? $_REQUEST['video'] : '';
		$city = stripslashes($_REQUEST['city']);
		$state = $_REQUEST['state'];
		$zipcode = str_pad($_REQUEST['zipcode'], 5, '0', STR_PAD_LEFT);

		$phone1 = $_REQUEST['phone'];
		preg_match_all('/\d+/', $phone1, $matches);
		$matches[0]; 
		$phone=implode('',$matches[0]);
		
		$alternate_phone = !empty($_REQUEST['alternate_phone']) ? str_replace("-", "", $_REQUEST['alternate_phone']) : '' ;
		$logo = $_REQUEST['logo'];
		$biz_type = $_REQUEST['biz_type'];
		$motto = stripslashes($_REQUEST['biz_motto']);
		$biz_about = stripslashes($_REQUEST['biz_about']);
		$siccode=isset($_REQUEST['siccode']) ? $_REQUEST['siccode'] : '' ;
		$zone_ids = empty($_REQUEST['zone_ids']) ? 0 : $_REQUEST['zone_ids'] ;
		
		/* Business Operation Hours Data */
		$business_appointment=isset($_REQUEST['business_appointment']) ? $_REQUEST['business_appointment'] : '' ;
		$monday_timing_from=!empty($_REQUEST['monday_timing_from']) ? $_REQUEST['monday_timing_from'] : '';
		$monday_timing_to=!empty($_REQUEST['monday_timing_to']) ? $_REQUEST['monday_timing_to'] : '';
		$monday_add_text=!empty($_REQUEST['monday_add_text']) ? $_REQUEST['monday_add_text'] : '';
		$tuesday_timing_from=!empty($_REQUEST['tuesday_timing_from']) ? $_REQUEST['tuesday_timing_from'] : '';
		$tuesday_timing_to=!empty($_REQUEST['tuesday_timing_to']) ? $_REQUEST['tuesday_timing_to'] : '';
		$tuesday_add_text=!empty($_REQUEST['tuesday_add_text']) ? $_REQUEST['tuesday_add_text'] : '';
		$wednessday_timing_from=!empty($_REQUEST['wednessday_timing_from']) ? $_REQUEST['wednessday_timing_from'] : '';
		$wednessday_timing_to=!empty($_REQUEST['wednessday_timing_to']) ? $_REQUEST['wednessday_timing_to'] : '';
		$wednessday_add_text=!empty($_REQUEST['wednessday_add_text']) ? $_REQUEST['wednessday_add_text'] : '';
		$thursday_timing_from=!empty($_REQUEST['thursday_timing_from']) ? $_REQUEST['thursday_timing_from'] : '';
		$thursday_timing_to=!empty($_REQUEST['thursday_timing_to']) ? $_REQUEST['thursday_timing_to'] : '';
		$thursday_add_text=!empty($_REQUEST['thursday_add_text']) ? $_REQUEST['thursday_add_text'] : '';
		$friday_timing_from=!empty($_REQUEST['friday_timing_from']) ? $_REQUEST['friday_timing_from'] : '';
		$friday_timing_to=!empty($_REQUEST['friday_timing_to']) ? $_REQUEST['friday_timing_to'] : '';
		$friday_add_text=!empty($_REQUEST['friday_add_text']) ? $_REQUEST['friday_add_text'] : '';
		$saturday_timing_from=!empty($_REQUEST['saturday_timing_from']) ? $_REQUEST['saturday_timing_from'] : '';
		$saturday_timing_to=!empty($_REQUEST['saturday_timing_to']) ? $_REQUEST['saturday_timing_to'] : '';
		$saturday_add_text=!empty($_REQUEST['saturday_add_text']) ? $_REQUEST['saturday_add_text'] : '';
		$sunday_timing_from=!empty($_REQUEST['sunday_timing_from']) ? $_REQUEST['sunday_timing_from'] : '';
		$sunday_timing_to=!empty($_REQUEST['sunday_timing_to']) ? $_REQUEST['sunday_timing_to'] : '';
		$sunday_add_text=!empty($_REQUEST['sunday_add_text']) ? $_REQUEST['sunday_add_text'] : '';
		$timezoneid = !empty($_REQUEST['timezoneid']) ? $_REQUEST['timezoneid'] : '';
		$audio_greetings= !empty($_REQUEST['audio_greetings']) ? $_REQUEST['audio_greetings'] : '' ;
		$service_number = !empty($_REQUEST['service_number']) ? $_REQUEST['service_number'] : '' ;
		
		$time_of_operation_data=array('zone_id'=>$zone_ids,'business_id'=>$id,'business_appointment'=>$business_appointment,'monday_timing_from'=>$monday_timing_from,'monday_timing_to'=>$monday_timing_to,'monday_add_text'=>$monday_add_text,'tuesday_timing_from'=>$tuesday_timing_from,'tuesday_timing_to'=>$tuesday_timing_to,'tuesday_add_text'=>$tuesday_add_text,'wednessday_timing_from'=>$wednessday_timing_from,'wednessday_timing_to'=>$wednessday_timing_to,'wednessday_add_text'=>$wednessday_add_text,'thursday_timing_from'=>$thursday_timing_from,'thursday_timing_to'=>$thursday_timing_to,'thursday_add_text'=>$thursday_add_text,'friday_timing_from'=>$friday_timing_from,'friday_timing_to'=>$friday_timing_to,'friday_add_text'=>$friday_add_text,'saturday_timing_from'=>$saturday_timing_from,'saturday_timing_to'=>$saturday_timing_to,'saturday_add_text'=>$saturday_add_text,'sunday_timing_from'=>$sunday_timing_from,'sunday_timing_to'=>$sunday_timing_to,'sunday_add_text'=>$sunday_add_text,'timezoneid'=>$timezoneid);
		
		$this->db->from('business_operation_hour')->where('business_id', $id);
		if ($this->db->count_all_results() == 0) {
			$query = $this->db->insert('business_operation_hour', $time_of_operation_data);
		}else{
			$query = $this->db->update('business_operation_hour', $time_of_operation_data, array('business_id'=>$id));
		}
		
		$data = array(
			'type' => $restaurant_type,
			'logo' => $logo,
			'name' => $name,
			'contactemail' => $contactemail,
			'contactfirstname' => $contactfirstname,
			'contactlastname' => $contactlastname,
			'contactfullname' =>$contactfullname,
			'motto' => $motto,
			'aboutus' => $biz_about,
			'website'=> $website,
			'siccode' => $siccode,
			'audio_presentation' => $audio_presentation,
			'video_presentation' => $video_presentation,
			'audio_greetings' => $audio_greetings,
			'service_number' => $service_number,
		);
		
		// For converting address into lattitude and longitude
		$address_maps = '';
		if ($street1 != '') { $address_maps .= $street1; }
		
		if ($street2 != '') {
			if ($address_maps != '') { $address_maps .= ',' . $street2;
			} else { $address_maps .= $street2; }
		}
		
		if ($city != '') {
			if ($address_maps != '') { $address_maps .= ',' . $city;
			} else { $address_maps .= $city; }
		}

        if ($state != '') {
			if ($address_maps != '') {
				$address_maps .= ',' . $state;
			} else {
				$address_maps .= $state;
			}
		}

        if ($zipcode != '') {
			if ($address_maps != '') { $address_maps .= ',' . $zipcode;
			} else { $address_maps .= $zipcode; }
		}
		
		$address_maps = urlencode($address_maps);
		$url = "http://maps.google.com/maps/api/geocode/json?address=$address_maps&sensor=false";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		$response_a = json_decode($response);
		$lat = $long='';
		
		if(is_object($response_a) && isset($response_a->results[0])){
			$lat = $response_a->results[0]->geometry->location->lat;
			$long = $response_a->results[0]->geometry->location->lng;
		}
		//For converting address into lattitude and longitude
		
		$addressData = array(
			'street_address_1' => $street1,
			'street_address_2' => $street2,
			'city' => $city,
			'state' => $state, 
			'zip_code' => $zipcode,           
			'phone' => $phone,
			'latitude' => $lat,
			'longitude' => $long
		);

		if($zipcode!=''){ $addressData['zip_code'] = $zipcode; }
		
		if (!empty($id) && $id > 0) {
			if (!empty($addressid) && $addressid > 0) {
				$this->db->where('id', $addressid);
				$this->db->update('address', $addressData);
			}
			
			$this->db->where('id', $id);
			$this->db->update('business', $data);
		}
		/*update user data number*/
		$data = array('phone' => $phone,'alternate_phone' => $alternate_phone);
		$this->db->where('id', $business_owner_id);
		$this->db->update('users', $data);
		/*update user data number*/
		$data['business'] = $this->business->get_business_by_id($id);
		$data['zonename'] = $this->business->get_zonename($id);
		$data['business_owner'] = $this->users->get_by_id($data['business']->business_owner_id);
		$data['business_type']=$this->business->get_business_type_by_id($id,$zoneids);
		$data['result']=$this->ads->getBusinessByID($id);
		$data['address']=$this->ads->getBusinessAddresByID($data['result']['addressid']);
		$data['state_list']=$this->states->get_state_dropdown();
		
		//Business Operation Hours For Business Dashboard(Business Owner)
		$data['operation']=$this->business->getOperationHour($id,$zone_ids);
		$data["business_part_data_view"] = $this->load->view("dashboards/business_parts/data_view", $data, true);
		echo($this->dr->GetDR("Save Complete", "Save Completed...", $data["business_part_data_view"], "0"));
	}

	

	public function businesscreate($businessid=false,$fromzoneid=0){ 	

		

		$data['common']=$this->common_first($businessid,$fromzoneid); //var_dump($data['common']);

		$data['state_list'] = $this->states->get_state_dropdown();		 	

		$data['ckeditor_staterad'] = array(

		//ID of the textarea that will be replaced

			'id' 	=> 	'stater_ad_message',

			'path'	=>	'assets/ckeditor',

			//Optional values

			'config' => array(

				'toolbar' 	=> 	"Full", 	//Using the Full toolbar

				'width' 	=> 	"550px",	//Setting a custom width

				'height' 	=> 	'100px',	//Setting a custom height

	    ));

		$data['businessid']=$businessid;

		$data['zoneid']=$data['common']['zoneid']; //var_dump($data['common']['zoneid']); 

		$data['category_list']=$this->Category_new_model->get_all_categories_zone($data['zoneid'],'business',2); 

		$data['right_container'] = $this->load->view("business/create_business", $data, true); 

		$this->common($data);

			

	}

	function zip_to_zone($zip){

		$data=array();

		$data['zip_to_zone']=$this->zip->zip_to_zone($zip); 

		$result = $this->load->view('business/subpage/zip_to_zone', $data, true);

		echo($this->dr->GetDR("","", $result, "0"));

	}

	function subcat_for_create_business(){ //anishsett

		$catid=!empty($_REQUEST['catid']) ? $_REQUEST['catid'] : 0 ;

		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$data=array();

		$data['sub_category_list']=$this->Category_new_model->get_all_subcategories_zone($catid,$zoneid,'create_business'); 

		$result = $this->load->view('business/subpage/get_subcat_create_business', $data, true);

		echo($this->dr->GetDR('','', $result, "0"));

	}

	function create_business(){ 	

		//$data=array();

		//var_dump($_REQUEST); exit;

		$auser = $this->ion_auth->user()->row();

	    $uid = $auser->id;

		$zipcode = !empty($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : 0 ;

		$zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;

		$name = !empty($_REQUEST['name'])? stripslashes($_REQUEST['name']) : '';

		$motto = !empty($_REQUEST['motto']) ? $_REQUEST['motto'] : '' ;

		$contactemail = !empty($_REQUEST['contactemail']) ? $_REQUEST['contactemail'] : '';

		$contactfirstname = !empty($_REQUEST['contactfirstname']) ? stripslashes($_REQUEST['contactfirstname']): '' ;

        $contactlastname = !empty($_REQUEST['contactlastname']) ? stripslashes($_REQUEST['contactlastname']) : '' ;

		$contactfullname = !empty($_REQUEST['contactfullname']) ? stripslashes($_REQUEST['contactfullname']) : '' ; 

		$street1 = !empty($_REQUEST['street1']) ? stripslashes($_REQUEST['street1']) : '' ;

        $street2 =  !empty($_REQUEST['street2']) ? stripslashes($_REQUEST['street2']) : '' ;

		$city = !empty($_REQUEST['city']) ? stripslashes($_REQUEST['city']) : '' ;

        $state = !empty($_REQUEST['city']) ? $_REQUEST['state'] : '' ;

		$phone = !empty($_REQUEST['phone']) ? $_REQUEST['phone'] : '' ;

		$website = !empty($_REQUEST['website']) ? $_REQUEST['website'] : '';

		$siccode = !empty($_REQUEST['siccode']) ? $_REQUEST['siccode'] : '';

		$audio_presentation = !empty($_REQUEST['audio_presentation']) ? $_REQUEST['audio_presentation'] : 0 ;

		$video_presentation = !empty($_REQUEST['video_presentation']) ? $_REQUEST['video_presentation'] : 0 ;

		$stater_ad = !empty($_REQUEST['stater_ad']) ? stripslashes($_REQUEST['stater_ad']) : '';

		$catid=!empty($_REQUEST['catid']) ? $_REQUEST['catid'] : '-99';

		$subcatid=!empty($_REQUEST['subcatid']) ? $_REQUEST['subcatid'] : '-99';

		$ad_startdatetime = !empty($_REQUEST['ad_startdatetime']) ? $_REQUEST['ad_startdatetime'] : '';

        $ad_stopdatetime = !empty($_REQUEST['ad_stopdatetime']) ? $_REQUEST['ad_stopdatetime'] : '';		

		//$deliver = !empty($_REQUEST['deliver']) ? $_REQUEST['deliver'] : 0;

		//$deliver = 0;

		

		$address = '';

        if ($street1 != '') {

            $address .= $street1;

        }

        if ($street2 != '') {

            if ($address != '') {

                $address .= ',' . $street2;

            } else {

                $address .= $street2;

            }



        }

        if ($city != '') {

            if ($address != '') {

                $address .= ',' . $city;

            } else {

                $address .= $city;

            }



        }

        if ($state != '') {

            if ($address != '') {

                $address .= ',' . $state;

            } else {

                $address .= $state;

            }



        }

        if ($zipcode != '') {

            if ($address != '') {

                $address .= ',' . $zipcode;

            } else {

                $address .= $zipcode;

            }

        }

		$address = urlencode($address);

        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);

        curl_close($ch);

        $response_a = json_decode($response);



		$lat='';

		$long='';



		if(is_object($response_a) && isset($response_a->results[0])){

			$lat = $response_a->results[0]->geometry->location->lat;

			$long = $response_a->results[0]->geometry->location->lng;

		}

		

		$data = array(

            'name' => $name,

            'contactemail' => $contactemail,

            'contactfirstname' => $contactfirstname,

            'contactlastname' => $contactlastname,

			'contactfullname' => $contactfullname,

			'motto' => $motto ,

			'siccode' =>$siccode,

			'created_by' =>$uid,

			'business_owner_id' => $uid,					

			'audio_presentation'=>$audio_presentation,

			'video_presentation'=> $video_presentation,

			'website'=> $website,

        ); 

		$addressData = array(

            'street_address_1' => $street1,

            'street_address_2' => $street2,

            'city' => $city,

            'state' => $state,

            'zip_code' => $zipcode,

            'phone' => $phone,

            'latitude' => $lat,

            'longitude' => $long

        );



		$this->db->insert('address', $addressData);

        $data['addressid'] = $this->db->insert_id();

        

		$this->db->insert('business', $data);

        $id = $this->db->insert_id();

	

		$newsletterData = array('businessid' => $id,'approval' => 1);        

		$this->db->insert('business_newsletter', $newsletterData);

		

		//$grid=5; $businesstype='';

		//$data['save_default_zone_ads_pref'] = $this->business->save_business_approval($id,$zone_id,$businesstype,$grid);

		//$grid=5; $businesstype='';

		$user_mode=5; $biz_type=0; $grid=5; 

		$data['save_default_zone_ads_pref'] = $this->zone_model->save_business_approval($id,$zone_id,$user_mode,$biz_type,$grid); 

		//var_dump($data['save_default_zone_ads_pref']); exit;

		//$data['stater_ad']=$this->ads->save_stater_ad_business($id,$zone_id,$stater_ad,$catid,$subcatid,$grid);

		$data['stater_ad']=$this->zone_model->save_stater_ad_business($id,$zone_id,$stater_ad,$catid,$subcatid,$user_mode,$ad_startdatetime,$ad_stopdatetime,$deliver);

		//$data['add_cat_subcat']

		$ad_id=$data['stater_ad']; 

		$data['ads_save_cat_subcat'] = $this->Category_new_model->ads_save_cat_subcat($ad_id,$catid,$subcatid,$zone_id,'create_business'); 

		//$message='You Successfully Created The Business.';

		echo($this->dr->GetDR('','', 1, "0"));

	}

	

########################### Business Create Section added on 7.11.14 when the user first logs in as Business Owner Start ###############################

public function createBusiness()

	{ 	

		$name = !empty($_REQUEST['name'])? stripslashes($_REQUEST['name']) : '';

		//var_dump($name); exit;

        $addressid = !empty($_REQUEST['addressid']) ? $_REQUEST['addressid'] : '';

        $contactemail = !empty($_REQUEST['contactemail']) ? $_REQUEST['contactemail'] : '';

        $website = !empty($_REQUEST['website']) ? $_REQUEST['website'] : '';

		$siccode = !empty($_REQUEST['siccode']) ? $_REQUEST['siccode'] : '';

        $contactfirstname = !empty($_REQUEST['contactfirstname']) ? stripslashes($_REQUEST['contactfirstname']): '' ;

        $contactlastname = !empty($_REQUEST['contactlastname']) ? stripslashes($_REQUEST['contactlastname']) : '' ;

		$contactfullname = !empty($_REQUEST['contactfullname']) ? stripslashes($_REQUEST['contactfullname']) : '' ;   // add 05.02.2013

        //$business_owner_id = $_REQUEST['business_owner_id']; //var_dump($business_owner_id);  exit;

        $street1 = !empty($_REQUEST['street1']) ? stripslashes($_REQUEST['street1']) : '' ;

        $street2 =  !empty($_REQUEST['street2']) ? stripslashes($_REQUEST['street2']) : '' ;

        $city = !empty($_REQUEST['city']) ? stripslashes($_REQUEST['city']) : '' ;

        $state = !empty($_REQUEST['city']) ? $_REQUEST['state'] : '' ;

        $zipcode = !empty($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : 0 ;

        $phone = !empty($_REQUEST['phone']) ? $_REQUEST['phone'] : '' ;

		$motto = !empty($_REQUEST['motto']) ? $_REQUEST['motto'] : '' ;

		$audio_presentation = !empty($_REQUEST['audio_presentation']) ? $_REQUEST['audio_presentation'] : 0 ;

		$video_presentation = !empty($_REQUEST['video_presentation']) ? $_REQUEST['video_presentation'] : 0 ;

		$logo = $_REQUEST['logo'];

		//$current_zone_id = $_REQUEST['current_zone_id'];		

		//$zone_id_null = $_REQUEST['zone_id_null'];

		$zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;

		$is_stater_ad = !empty($_REQUEST['is_starter_ad']) ? $_REQUEST['is_starter_ad'] : 0;

		$stater_ad = !empty($_REQUEST['stater_ad']) ? stripslashes($_REQUEST['stater_ad']) : '';

		$catid=0;

		$subcatid=0;

		$business_exist = !empty($_REQUEST['business_exist_value']) ? $_REQUEST['business_exist_value'] : 0; 	//Added on 22/5/14

		$franchisor_type = !empty($_REQUEST['franchisor_type']) ? $_REQUEST['franchisor_type'] : ''; // Added on 2.6.14 for franchisor type bus create by zone owner

//var_dump($business_exist);exit;

		if($is_stater_ad!='0'){

			/*$catid=$_REQUEST['catid'];

			$subcatid=$_REQUEST['subcatid'];*/

			$catid=!empty($_REQUEST['catid']) ? $_REQUEST['catid'] : '-99';

			$subcatid=!empty($_REQUEST['subcatid']) ? $_REQUEST['subcatid'] : '-99';

		}else{

			$catid=0;

			$subcatid=0;

		}


		if($zone_id!='-1'){

		if($zipcode!='' && $zipcode!='0'){

		$auser = $this->ion_auth->user()->row();

	    $uid = $auser->id;							//user id

	

		$data = array(

			'logo' => $logo,

            'name' => $name,

            'contactemail' => $contactemail,

            'contactfirstname' => $contactfirstname,

            'contactlastname' => $contactlastname,

			'contactfullname' => $contactfullname,

			'motto' => $motto ,

			'siccode' =>$siccode,

			'created_by' =>$uid,

			'business_owner_id' => $uid,					// Added on 21/5/14

			'audio_presentation'=>$audio_presentation,

			'video_presentation'=> $video_presentation 

			//'stater_ad' => $stater_ad

        ); 

	

        if (!empty($website)) {

            $data['website'] = $website;

        }

        $address = '';

        if ($street1 != '') {

            $address .= $street1;

        }

        if ($street2 != '') {

            if ($address != '') {

                $address .= ',' . $street2;

            } else {

                $address .= $street2;

            }



        }

        if ($city != '') {

            if ($address != '') {

                $address .= ',' . $city;

            } else {

                $address .= $city;

            }



        }

        if ($state != '') {

            if ($address != '') {

                $address .= ',' . $state;

            } else {

                $address .= $state;

            }



        }

        if ($zipcode != '') {

            if ($address != '') {

                $address .= ',' . $zipcode;

            } else {

                $address .= $zipcode;

            }



        }

        $address = urlencode($address);

        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($ch);

        curl_close($ch);

        $response_a = json_decode($response);



		$lat='';

		$long='';



		if(is_object($response_a) && isset($response_a->results[0])){

			$lat = $response_a->results[0]->geometry->location->lat;

			$long = $response_a->results[0]->geometry->location->lng;

		}



        $addressData = array(



            'street_address_1' => $street1,



            'street_address_2' => $street2,



            'city' => $city,



            'state' => $state,



            'zip_code' => $zipcode,



            'phone' => $phone,



            'latitude' => $lat,



            'longitude' => $long



        );



		if (!empty($addressid)) {

            $data['addressid'] = $addressid;

        }

		

		$a=$this->business->get_user_group1($uid);  	// users_groups table  -> group_id retreived

		$grid=$a->group_id;

		//var_dump($grid); exit;

		if($grid==5 || $grid==13){																		

			$session_zoneid_arr=$this->session->userdata('create_business_ses_id');

			$seszoneid=$session_zoneid_arr['sesbusid'];

			//echo '1'.var_dump($seszoneid);

		}else{

			$session_zoneid_arr=$this->session->userdata('create_business_ses_id');

			$seszoneid=$session_zoneid_arr['create_business_sesid'];

			if(is_object($seszoneid))

			{

				$seszoneid=$seszoneid->id;

			}

			else

			{

				$seszoneid=$seszoneid;

			}

			//echo '2'.var_dump($seszoneid);

	

		}

		if($grid!=5 || $grid!=13){ // 4 = zone owner, 5 = business owner, 13 = Franchisee Owner

			$owner_account_type = $_REQUEST['owner_account_type']; 

			if($owner_account_type==1){

				$data['business_owner_id']=$uid;

			}else if($owner_account_type==2){

				$username = $_REQUEST['username'];

        		$password = $_REQUEST['password'];

				$data['business_owner_id']=0;

			}else if($owner_account_type==3){

				$data['business_owner_id']=$_REQUEST['existing_owner_id'];

			}

			$businesstype=$_REQUEST['businesstype'];



		}else{

		$businesstype='0';

		$owner_account_type=0;

		//var_dump($businesstype); 

		$data['business_owner_id']=$uid;

		}

       

		

		if($owner_account_type==2 && $data['business_owner_id']==0){ //var_dump($owner_account_type); var_dump($data['business_owner_id']); //exit;

			$additional_data = array('first_name' => $contactfirstname,'last_name' => $contactlastname);

			

            //var_dump($additional_data); var_dump($username); var_dump($password); var_dump($businesstype); exit;

			$franchise_arr = array();

			$franchise_arr['franchisor'] = ($franchisor_type == 1) ? 13 : '' ;

			if($franchise_arr['franchisor'] == 13){

				$business_owner_id_1 = $this->ion_auth->register($username, $password, $contactemail, $additional_data, $franchise_arr);

			}

			else{

				$business_owner_id_1 = $this->ion_auth->register($username, $password, $contactemail, $additional_data);

			}

			//var_dump($business_owner_id_1); exit;

			/* Password Update For Uploaded Business */

			if($business_owner_id_1 != '' && $businesstype == 3 && $password != ''){

				$this->ion_auth->update_uploadbusiness_password($business_owner_id_1,$password);

			}

			$data['business_owner_id'] = $business_owner_id_1;

			//var_dump($data['business_owner_id']); exit;

			if($data['business_owner_id']==0){

				$data['business_owner_id']=$uid;

			}

			

			

			if($contactfullname!='')

				$bowner_full_name=$contactfullname;

			else

				$bowner_full_name='User';

			if($businesstype==1){

				$message_business_type='Active Paid';

			}else if($businesstype==2){

				$message_business_type='Active Trial';

			}else if($businesstype==3){

				$message_business_type='Active Upload';

			}

			$zoneinformation = $this->announcements->get_zoneinformation($zone_id); // get zone informations	

			$zonename=$zoneinformation->zname;

			$zoneowneremail=$zoneinformation->email; 

			$zoneownerfname=$zoneinformation->first_name; 

			$zoneownerlname=$zoneinformation->last_name;

			

			$login_path = base_url()."welcome/account_updates/business";	

			$message_body="<div style='border:1px solid #900; padding:5px;'>Dear ".$bowner_full_name.",<br /><br />

				Your business is presently under ".$message_business_type." on SavingsSites by <strong>".$zoneownerfname." ".$zoneownerlname."</strong> (".$zoneowneremail.").<br/><br/>

				Your business information below listed by <strong>".$zoneownerfname." ".$zoneownerlname."</strong> is as below:<br/><br/>

				Business Name: ".$name."<br/>

				Login URL: <a href='".$login_path."'>http://www.savingssites.com/welcome/account_updates/business</a><br/>

				Username: ".$username."<br/>

				Password: ".$password."<br/><br/>

				

									

				You can login into your account and change this information at your convenience.<br /><br />

				We are constantly trying to improve the application and will notify you of future updates as and when they are available. If you have any queries in the meantime then please email us at <a href='mailto:support@savingssites.com'>support@savingssites.com</a> and we will get back to you promptly.<br /><br />

				Best Regards,<br />

				Savings Sites Support." ;

				$template_subject='New Business Information';

				$fromemail=$contactemail;

				$this->load->library('email');

				$this->email->clear();

				$this->email->from($fromemail);

				$this->email->subject($template_subject);

				$this->email->message($message_body);

				if($contactemail!='')

				{

					$this->email->to($contactemail);

					$this->email->send();

					$to[]=$contactemail;

				}

			

		}

		

        $this->db->insert('address', $addressData);

        $data['addressid'] = $this->db->insert_id();

        

		$this->db->insert('business', $data);

        $id = $this->db->insert_id();

	

		$newsletterData = array('businessid' => $id,'approval' => 1);        

		$this->db->insert('business_newsletter', $newsletterData);

		

		$bu_detail=$this->business->get_all_business_details($zone_id);

		if(!empty($bu_detail)){		

			$zone_owner_details=$this->users->get_user_details($uid);

			if(!empty($zone_owner_details)){

				$_zone_owner_email=$zone_owner_details['email'];

				$_zone_owner_name=$zone_owner_details['last_name'].','.$zone_owner_details['first_name'];

			}

			$a='<table>

					<tr>

						<td width="275">

							<table>

								<tr>

									<td  colspan="2" valign="top">Zone Details</td>

								</tr>

	

								<tr>                

									<td width="140" height="42">UserName</td>

									<td width="113">'.$bu_detail[0]['username'].'</td>                          

								</tr>

								<tr>                   

									<td width="140" height="42">Email</td>

									<td width="113">'.$bu_detail[0]['email'].'</td>                          

								</tr>

								<tr>

									<td colspan="2">Buisness Details</td> 

								</tr>';

								$b=array();

									foreach($bu_detail as $key=>$bus)

									{ 

									$x='           

									<tr>

										<td width="140">UserName</td>

										<td width="113">'.$bus['buisness_name'].'</td>

									</tr>	

									<tr>

										<td>Email</td>

										<td>'.$bus['email'].'</td>

									';	

									$b[$key]=$x;							

									}

							$c='		

						</td>

					</tr>

				</table>

			';		

			$s=$a.implode('</tr>',$b).$c;

			$message_body=$s;

		}

		

		$businesszonedata = array('buszoneid'=>$zone_id);

		$this->session->set_userdata('businesszonedata',$businesszonedata); // assign session for create business from particular zone  29.01.2013

		$data['save_default_zone_ads_pref'] = $this->business->save_business_approval($id,$zone_id,$businesstype,$grid);

		//$data['save_default_zone_ads_pref'] = $this->ads->save_business_approval($id,$zone_id,$businesstype,$grid);

		

		if($business_exist==1){

			if($is_stater_ad==1){ //var_dump($catid); var_dump($subcatid); exit;

				$data['stater_ad']=$this->ads->save_stater_ad_business($id,$zone_id,$stater_ad,$catid,$subcatid,$grid);

				//$data['add_cat_subcat']

				$ad_id=$data['stater_ad']; 

				$data['ads_save_cat_subcat'] = $this->Category_new_model->ads_save_cat_subcat($ad_id,$catid,$subcatid,$zone_id,'create_business'); 

			}		

		}$message='2';

		}

		

		}else{

			$message='';

		}

		//var_dump($message);

		//$update_zone_menu=$this->category_model->update_zone_menu($zone_id);

		$update_zone_menu=$this->menu_generator($zone_id);

		if($grid==5 || $grid==13){

		if(!($this->session->userdata('session_zoneid_from_bus'))){

			$session_zoneid_from_bus = array(                   		

				'buszoneid'=>$zone_id,

				'busid'=>$id,

				'type'=>'business'

			);

			$this->session->set_userdata('session_zoneid_from_bus',$session_zoneid_from_bus);

		}

		}

        echo($this->dr->GetDR("Success", $message, "", "0"));

    }

####################################### Business Create Section when the user first log in as Business Owner Start ###########################################

	

################################################## Business Default Settings #############################################################

	

	public function businessdefaultsetting($businessid=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['business_id']=$businessid;

		$data['my_zones'] = $this->sales_zone->get_zones_for_user($data['common']['uid']); 

		$data['view_default_ad_setting_pref'] = $this->sales_zone->get_default_zones_for_ad_pref($businessid); 

		$data['view_ad_setting_pref'] = $this->sales_zone->get_all_zones_for_ad_pref($businessid); 

		//$data['zone_where_ads_are_visible'] = $this->sales_zone->zone_where_ads_are_visible($businessid)

		

		/*To get the approval status of the businesses so as to modify the view and  the messages*/

		//$data['get_business_ads_approval'] = $this->sales_zone->get_business_ads_approval($businessid,$data['zoneid']); var_dump($data['get_business_ads_approval']); exit;

		

		$data['zoneid'] = $data['common']['zoneid'];

		$data['select_all_ziped_zone_for_ad_pref'] = $this->sales_zone->get_all_ziped_zone_for_ad_pref($businessid); 

		$data['count_select_all_ziped_zone_for_ad_pref']=count($data['select_all_ziped_zone_for_ad_pref']); 

		$data['right_container'] = $this->load->view("business/default_setting", $data, true); 

		$this->common($data);

	}

	

# + save_zone_for_ad_pref -> to copy the ads from one zone to another zone.

	/*public function save_zone_for_ad_pref($business_id,$zone_id,$send_to_zone_id){ 

		$data['get_all_from_ad_setting_pref'] = $this->business->get_all_from_ad_setting_pref($business_id,$zone_id,$send_to_zone_id);

		$data['get_ad_to_zone_and_insert'] = $this->business->get_ad_to_zone_and_insert($business_id,$zone_id,$send_to_zone_id);

		$echo($this->dr->GetDR("","", $result, "0"));

	}*/

	function save_zone_for_ad_pref($id,$zone,$checkbox_value,$current_zoneid){

		//var_dump($id); var_dump($zone); var_dump($checkbox_value); var_dump($current_zoneid); exit;

		$data = array();

		$user = $this->ion_auth->user()->row();

		$uid = 0;

        if(!empty($user)){ $uid = $user->id;}

		if(!empty($user)){

			$data["status"] = $user->status;

        }

		

		$data['business'] = $this->business->get_business_by_id($id);

		$data['business_id'] = $id;

		$data['zone_id'] = $zone;		

		$data['save_zone_ads_pref'] = $this->sales_zone->save_zone_ads_pref($id,$zone,$checkbox_value,$current_zoneid);		

		/*$data['select_all_ziped_zone_for_ad_pref'] = $this->sales_zone->get_all_ziped_zone_for_ad_pref($id);

		$data['count_select_all_ziped_zone_for_ad_pref']=count($data['select_all_ziped_zone_for_ad_pref']);

		$data['view_ad_setting_pref'] = $this->sales_zone->get_all_zones_for_ad_pref($id);

		$data['view_default_ad_setting_pref'] = $this->sales_zone->get_default_zones_for_ad_pref($id);

		$result = $this->load->view('dashboards/ad_setting_pref_to_zone', $data, true); 

		echo($this->dr->GetDR("","", $result, "0"));*/

		$echo($this->dr->GetDR("","", 1, "0"));

	} 

# - save_zone_for_ad_pref



# + delete_zone_for_ad_pref

	public function delete_zone_for_ad_pref($business_id,$zone_id){ 

		$data['from_ad_setting_pref'] = $this->business->from_ad_setting_pref($business_id,$zone_id);

		$data['from_ad_to_zone'] = $this->business->from_ad_to_zone($business_id,$zone_id);

		$to_delete = $business_id.'_'.$zone_id;

		echo($this->dr->GetDR($to_delete,"", $result, "0"));

	}

# - delete_zone_for_ad_pref



################################################## Business Default Settings #############################################################



################################################## Business Referral added on 10-11-14 start ####################################################

	public function businessreferral($businessid=false,$fromzoneid=0){

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['zoneid']=$data['common']['from_zoneid'];

		$data['business_id']=$businessid;

		$data['my_zones'] = $this->sales_zone->get_zones_for_user($data['common']['uid']); 

		$data['right_container'] = $this->load->view("business/businessreferral", $data, true); 

		$this->common($data);

		

	}

	public function send_referral(){//var_dump($_REQUEST);exit;

		$businessid = !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : '' ;

		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '' ;

		$contact_person = !empty($_REQUEST['contact_person']) ? $_REQUEST['contact_person'] : '' ;

		$user_email = !empty($_REQUEST['user_email']) ? $_REQUEST['user_email'] : '' ;

		$user_phone = !empty($_REQUEST['user_phone']) ? $_REQUEST['user_phone'] : '' ;

	

		$businessid_encryted = random_string('alnum',5); 		// Alpha numeric. For this added $this->load->helper('string'); 

		$refer_code =  $businessid_encryted."_".$businessid; 	// to be entered in the db

		$current_time = time();

		$unique_refer_code = $refer_code."_".$current_time; 	// will go to the users as unique 1qaz2_93_64523

		// + Check if refer code already exist

			$check_sql = "SELECT a.business_owner_id , a.name, a.contactemail , a.contactfirstname , a.contactlastname , b.refer_code FROM business as a , users as b WHERE a.business_owner_id = b.id AND a.id = ".$businessid;

			$query_check = $this->db->query($check_sql);

			$result_check = $query_check->row_array();

			

			$business_owner_id = $result_check["business_owner_id"];

			$from_business_name = $result_check["name"];

			$from_mail = $result_check["contactemail"];

			$from_name = $result_check["contactfirstname"].' '.$result_check["contactlastname"];

			$existing_refer_code = $result_check['refer_code']; //var_dump($existing_refer_code); exit;

		// + Check if refer code already exists

		

			if(empty($existing_refer_code) && $existing_refer_code==''){

				// + Insert the refer code in the user table

				$sql = "UPDATE users SET refer_code ='".$refer_code."' WHERE id=".$business_owner_id;

				$query = $this->db->query($sql);

				$result = $this->db->result_array($query);

				// + Insert the refer code in the user table

				

				// + Mail to the referred user----- Need to provide the referer details in the mail

				$register_path = "http://development.savingssites.com/welcome/business_registration?refer_code=".$unique_refer_code;

				//$link="http://savingssites.com/";  // CAN BE USED TO MAKE A LINK OF DIRECTORY PAGE WHICH NEEDS A ZONE ID 

				

				$message="<div style='border:1px solid #900; padding:5px;'>Dear ".$contact_person.",<br /><br />

				You have have been referred by ".$from_name." owner of ".$from_business_name.".<br/><br/>

				

				Please click <a href='".$register_path."'>Here</a> to register into Savings Sites. <br/><br/>

				

				If you are not interested in registration in Savings Sites then ignore this mail.<br /><br />

				

				Best Regards,<br />

				Savings Sites Support" ;

				

				$this->load->library('email');

				$this->email->clear();

				$this->email->from($from_mail, $from_name);

				$this->email->to($user_email);

				//$this->email->cc('another@another-example.com');

				//$this->email->bcc('them@their-example.com');

				$this->email->subject('You have been referred by '.$from_business_name);

				$this->email->message($message);

				if($user_email!='')

				{

					$this->email->to($user_email);

					$this->email->send();

					$to[]=$user_email;

				}

				// + Mail to the referred user

				

				// + Mail to the Zone Owner

				$get_zone_owner_mail = "SELECT a.email , a.first_name , a.last_name , b.sales_rep_id FROM users a , sales_zone b WHERE b.id = ".$zoneid." AND b.sales_rep_id = a.id";	

				$query_zone_mail = $this->db->query($get_zone_owner_mail);

				$result_zone_mail = $query_zone_mail->row_array(); //var_dump($result_zone_mail[0]['email']); exit;

				

				$zone_owner_mail = $result_zone_mail['email'];

				$zone_first_name = $result_zone_mail['first_name'];

				$zone_last_name = $result_zone_mail['last_name'];

				

				$message1="<div style='border:1px solid #900; padding:5px;'>Dear ".$zone_first_name.",<br /><br />

				

				Business named ".$from_business_name." referred a new user.<br /><br />

				

				Best Regards,<br />

				Savings Sites Support" ;

				

				$this->load->library('email');

				$this->email->clear();

				$this->email->from($from_mail, $from_name);

				$this->email->to($zone_owner_mail);

				$this->email->subject($from_business_name.' referred a new user');

				$this->email->message($message1);

				if($zone_owner_mail!='')

				{

					$this->email->to($zone_owner_mail);

					$this->email->send();

					$to[]=$zone_owner_mail;

				}

				// + Mail to the Zone Owner 

			}

			else{

				// + Mail to the referred user if refer code already exists.

				$register_path = "http://development.savingssites.com/welcome/business_registration?refer_code=".$existing_refer_code."_".$current_time;

				//$link="http://savingssites.com/";  // CAN BE USED TO MAKE A LINK OF DIRECTORY PAGE WHICH NEEDS A ZONE ID 

				

				$message="<div style='border:1px solid #900; padding:5px;'>Dear ".$contact_person.",<br /><br />

				You have have been referred by ".$from_name." owner of ".$from_business_name.".<br/><br/>

				

				Please click <a href='".$register_path."'>Here</a> to register into Savings Sites. <br/><br/>

				

				If you are not interested in registration in Savings Sites then ignore this mail.<br /><br />

				

				Best Regards,<br />

				Savings Sites Support" ;

				var_dump($user_email);exit;

				$this->load->library('email');

				$this->email->clear();

				$this->email->from($from_mail, $from_name);

				$this->email->to($user_email);

				$this->email->subject('You have been referred by '.$from_business_name);

				$this->email->message($message);

				if($user_email!='')

				{

					$this->email->to($user_email);

					$this->email->send();

					$to[]=$user_email;

				}

				// + Mail to the referred user if refer code already exists.

				

				// + Mail to the Zone Owner

				$get_zone_owner_mail = "SELECT a.email , a.first_name , a.last_name , b.sales_rep_id FROM users a , sales_zone b WHERE b.id = ".$zoneid." AND b.sales_rep_id = a.id";	

				$query_zone_mail = $this->db->query($get_zone_owner_mail);

				$result_zone_mail = $query_zone_mail->row_array(); //var_dump($result_zone_mail[0]['email']); exit;

				

				$zone_owner_mail = $result_zone_mail['email'];

				$zone_first_name = $result_zone_mail['first_name'];

				$zone_last_name = $result_zone_mail['last_name'];

				

				$message1="<div style='border:1px solid #900; padding:5px;'>Dear '".$zone_first_name."',<br /><br />

				

				Business named '".$from_business_name."' referred a new user.<br /><br />

				

				Best Regards,<br />

				Savings Sites Support" ;

				//var_dump($from_mail);var_dump($from_name); var_dump($zone_owner_mail); exit; 

				/*$this->load->library('email');

				$this->email->clear();

				$this->email->from($from_mail, $from_name);

				$this->email->to($zone_owner_mail);

				$this->email->subject($from_business_name.' referred a new user');

				$this->email->message($message1);

				if($zone_owner_mail!='')

				{

					$this->email->to($zone_owner_mail);

					$this->email->send();

					$to[]=$zone_owner_mail;

				}*/

            	$this->load->library('email');

				$this->email->clear();

				$this->email->from($from_mail, $from_name);

				$this->email->subject($from_business_name.' referred a new user');

				$this->email->message($message1);

				if($result->email!='')

				{

					$this->email->to($zone_owner_mail);

					$this->email->send();

					$to[]=$zone_owner_mail;

				}

				// + Mail to the Zone Owner 

			} 

		 	echo($this->dr->GetDR("Success", "1", "1", "0"));

		

	}

################################################## Business Referral added on 10-11-14 end ####################################################	

	

# + businessownerdetails 

// Business deatils , Business owner details, change password section view 

	public function businessownerdetails($businessid=0,$fromzoneid=0){

		$data['common']=$this->common_first($businessid,$fromzoneid); //echo '<pre>';echo print_r($data['common']);echo '</pre>'; exit;

		$zoneid = $data['common']['zoneid'];	

		$userid = $data['common']['sub_header_name_from_zone']['business_owner_id'];//$data['common']['businessid'];

		//var_dump($userid);

		$data['state_list'] = $this->states->get_state_dropdown();	

		$data['business_owner_details']=$this->users->get_user_details($userid); //var_dump($data['business_owner_details']);  	

		$data['right_container'] = $this->load->view("business/business_owner_information", $data, true); 

		$this->common($data);

	}

# - businessownerdetails



# + update_businessprofile	
	public function update_businessprofile(){ 
		$userid 		= $_REQUEST['userid'];
		$email 			= isset($_REQUEST['email'])?$_REQUEST['email']:'';
		$firstname 		= isset($_REQUEST['firstname'])?$_REQUEST['firstname']:'';
		$lastname 		= isset($_REQUEST['lastname'])?$_REQUEST['lastname']:'';
		$phone 			= isset($_REQUEST['phone'])?$_REQUEST['phone']:'';
		$gender 		= isset($_REQUEST['busgender'])?$_REQUEST['busgender']:'';
		$zonesubuser 	= isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
		$userData = array('email'=> $email,'first_name'=> $firstname,'last_name'=> $lastname,'phone'=> $phone,'gender'=> $gender
		);
		
		$this->CommonController->updateData('users',$userData,['id' =>$userid]);
		if($zonesubuser != ''){
			$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Update Business Owner Information',serialize($userData));
		}
		echo json_encode(['msg' => 'Updated Successfully', 'type'=>'success']);
	}

	public function UpdateBusinessPassword(){
		$userid = $_REQUEST['userid'];
		$zoneid = $_REQUEST['zoneid'];
		$current_pass = $_REQUEST['current_pass'];
		$new_pass = $_REQUEST['new_pass'];
		$confirm_pass = $_REQUEST['confirm_pass'];
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';
		$business_first_password_change = isset($_REQUEST['business_first_password_change'])?$_REQUEST['business_first_password_change']:0;

		$sql= "SELECT id FROM business WHERE business_owner_id=$userid";
		$result = $this->CommonController->SelectRawquery($sql);
		$businessId = $result[0]['id'];
		$this->CommonController->updateData('ads_setting_preferences',['approval' => 2],['settingszoneid' => $zoneid, 'businessid'=>$businessId]);
		
		$sql= "SELECT username FROM users WHERE id=$userid";
		$result = $this->CommonController->SelectRawquery($sql);
		$identity = $result[0]['username'];
		
		$change = $this->ion_auth->change_password($identity, $current_pass, $new_pass); 
		if ($change == true){
			if($business_first_password_change == 1){
				$this->CommonController->updateData('users',['password_change' => 2,'uploaded_business_password' => $new_pass],['id' => $userid]);
			}
			$msg = ['msg'=> 'Password Updated Successfully','type' =>'success'];
		}else{
			$msg = ['msg'=> 'No Changes Made!','type' =>'warning'];
		}
		if($zonesubuser != ''){
			$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Change Password Business',serialize(['new_pass'=> $new_pass,'msg'=>$msg]));
		}
		echo json_encode($msg);
	}

# - update_businessprofile



# + UpdateBusinessPassword

	/*public function UpdateBusinessPassword(){ 

		$userid = $_REQUEST['userid'];

		$current_pass = $_REQUEST['current_pass'];

		$new_pass = $_REQUEST['new_pass'];

		$confirm_pass = $_REQUEST['confirm_pass'];

		if($new_pass != $confirm_pass){

			$message = "Your New Password and Confirm Password are not same. For this No Changes Made!";

		}else{

			if($current_pass !=  $new_pass || $new_pass == $confirm_pass)

			{//var_dump(1111);exit;

				$message = "Update Successful";//var_dump($current_pass);exit;

			}

			else

			{

				$message = "No Changes Made!";

			}

			//print_r($this->session->userdata); exit;

			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));//var_dump($identity);exit;

			////$change = $this->ion_auth->change_password($identity, $current_pass, $new_pass);

			//$change = "";

			

			}

		echo($this->dr->GetDR("Update Password", $message, "", "0"));

		//echo($this->dr->GetDR($message, "Update Password", $var , $height = "0"));

	}*/


# - UpdateBusinessPassword



# - AddAnotherBusiness



	public function AddAnotherBusiness(){



		$zoneid = $_REQUEST['zoneid'];

		$business_id = $_REQUEST['business_id'];;

		$business_name = $_REQUEST['business_name'];

		$slogan = $_REQUEST['slogan'];

		$street_address = $_REQUEST['street_address'];

		$contact_phone = $_REQUEST['contact_phone'];

		$flag = 0;



		//print_r($_REQUEST); exit;

		$sql ="INSERT INTO `address`(street_address_1,phone) VALUES('".$street_address."','".$contact_phone."')";

		$query = $this->db->query($sql);

		$address_id = $this->db->insert_id();



		$sql = "SELECT * FROM `business` WHERE `id` = $business_id ";

		$query = $this->db->query($sql);

		$result = $query->result_array();

		//print_r($result);

		//echo $result[0]['id']."tyty"; exit;

		$businessData = array(

			'logo' => $result[0]['logo'],

			'name' => $business_name,

			'addressid' => $address_id,

			'contactemail' => $result[0]['contactemail'],

			'contactfirstname' => $result[0]['contactfirstname'],

			'contactlastname' => $result[0]['contactlastname'],

			'contactfullname' => $result[0]['contactfullname'],

			'business_owner_id' => $result[0]['business_owner_id'],

			'website' => $result[0]['website'],

			'motto' => $slogan,

			'note' => $result[0]['note'],

			'timestamp' => $result[0]['timestamp'],

			'starttime' => $result[0]['starttime'],

			'stoptime' => $result[0]['stoptime'],

			'isverified' => $result[0]['isverified'],

			'siccode' => $result[0]['siccode'],

			'created_by' => $result[0]['created_by'],

			'audio_presentation' => $result[0]['audio_presentation'],

			'video_presentation' => $result[0]['video_presentation'],

			'israted' => $result[0]['israted'],

			'referal_credit' => $result[0]['referal_credit'],

			'trialstarted' => $result[0]['trialstarted'],

			'business_peekaboo_id' => $result[0]['business_peekaboo_id'],

			'business_information' => $result[0]['business_information']



		);



		//print_r($businessData); exit;

		$businessInsert = $this->db->insert('business',$businessData);

		$last_business_id = $this->db->insert_id();		



		$sql = "SELECT * FROM `ads_setting_preferences` WHERE `businessid` = $business_id ";

		$query = $this->db->query($sql);

		$ads_setting_result = $query->result_array();



		$ad_settings= array(

			 'businessid'=> $last_business_id,

			 'settingszoneid'=> $zoneid,

			 'isdefault'=> $ads_setting_result[0]['isdefault'],

			 'approval'=> $ads_setting_result[0]['approval'],

			 'type'=> $ads_setting_result[0]['type'],

			 'paymenttype' => $ads_setting_result[0]['paymenttype'],

			 'websitevisibility' => $ads_setting_result[0]['websitevisibility'],

			 'emailvisibility' => $ads_setting_result[0]['emailvisibility'],

			 'isverified_businessowner' => $ads_setting_result[0]['isverified_businessowner'],

			 'is_duplicate'=> $ads_setting_result[0]['is_duplicate'],

			 'remaining_trial_period' => $ads_setting_result[0]['remaining_trial_period'],

			 'statuschangingtimestamp' => $ads_setting_result[0]['statuschangingtimestamp']

		);



		$adsSettiingInsert = $this->db->insert('ads_setting_preferences',$ad_settings);

		$last_ad_settings_id = $this->db->insert_id();



		if($last_business_id && $last_ad_settings_id){



			$flag = 1;

		}



		if($flag == 1){



			$message = "<h4 style='color:#090'>"."business added Successful"."</h4>";

		}else{



			$message = "<h4 style='color:#090'>"."No business Added"."</h4>";

		}





		echo($this->dr->GetDR("Add Business", $message, "", "0"));



	}

	

	################################################  Business Data Part End #################################################################

	

	

	################################################  Business Advertisement Part Start #######################################################

	

	# + View ad section

	public function viewad($businessid=false,$fromzoneid=0){ 

		$data['common']=$this->common_first($businessid,$fromzoneid); 

		/*echo "<pre>";

		print_r ($data['common']);

		echo "</pre>";*/				 	

		$data['businessid']=$businessid;

		$data['zoneid']=$data['common']['zoneid']; 

		$data['fromzoneid']=$fromzoneid;

		$user = $this->ion_auth->user()->row()->id;

		//$lowerlimit=0; $upperlimit=1000; 

		//$data['ads'] = $this->ads->get_ads_for_business($businessid,$user,$lowerlimit,$upperlimit); 

		$data['business'] = $this->business->get_business_by_id($businessid);

		$data['adSetting']=$this->business->get_ad_setting_by_id($businessid);

		$data['pbgbusinessdetails']=$this->business->get_business_for_pbg($businessid);

		$data['right_container'] = $this->load->view("business/view_ad", $data, true); 

		$this->common($data);

	}

	# - View ad section

	

	# + view ads by adtype

	public function view_all_ad(){ 	
	$data = [];		 	
		$data['businessid'] = !empty($_REQUEST['businessid']) ? $_REQUEST['businessid']:'';
		$data['zoneid'] = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid']:'';
		$data['fromzoneid'] = !empty($_REQUEST['fromzoneid']) ? $_REQUEST['fromzoneid']:0;
		$approval = $_REQUEST['approval'];
		$businessid = $data['businessid'] ;
		$user = $this->ionAuth->user()->row()->id;
		$lowerlimit=0; $upperlimit=1000; 
		$data['ads'] = $this->Ads_model->get_ads_for_business_new($businessid,$user,$lowerlimit,$upperlimit,$approval); 
		$data['business'] = $this->Business->get_business_by_id($businessid);
		$data['adSetting']=$this->Business->get_ad_setting_by_id($businessid);
		$data['addapproval'] = $approval;
		echo json_encode($data);
		

	}

	# - view ads by adtype

	

	# + For Food menu

	function upload_docs_foodmenu($filename, $form_id){ 

    	//loading file upload library and setting up variables

    	//var_dump($filename); exit;

		$new_filename = 'busi_'.time();

    	$result = '';

    	$output_image_data = '';

   		

		$new_filename='busi_'.time().'_'.$_REQUEST['docx'];

		

		

    	$file_config = array();

    	$file_config['upload_path'] = "./uploads/food_menu/";

    	$file_config['max_size'] = "1024";

    	$file_config['allowed_types'] = "docx|doc|pdf"; 

    	$file_config['max_width'] = 0;

    	$file_config['max_height'] = 0; 

    	$this->load->library('upload', $file_config);    

    	if ( ! $this->upload->do_upload($filename))

    	{
    		$result = $this->upload->display_errors();

    	}else{

    		$data['upload_data'] = $this->upload->data();

    		$img = $data['upload_data']['file_name'];			 

			$img_display = substr($img,16);    			

    		$output_image_data = '<p class="form-group-row" style="margin-left:200px;color:#859731">New Uploaded file : <b>'.$img_display."</b></p>";

    		$output_image_data .= '<input type="hidden" name="docs_foodmenu" id="docs_foodmenu" value="'.$img.'" />';

    		$result = 'docs-upload-success';    		

    	}

    

    	sleep(1);

    	?>

    		<script language="javascript" type="text/javascript">window.top.window.stopUpload('<?php echo $result; ?>', '<?php echo $output_image_data;?>', 'logo_image222', '<?php echo $filename;?>', '<?php echo $form_id;?>');</script>   

    		<?php

	}

	# - For Food menu

	# + For Presentation On Deemand

	function upload_docs($filename, $form_id){ 

    	//loading file upload library and setting up variables

    	//var_dump($filename); exit;

		$new_filename = 'busi_'.time();

    	$result = '';

    	$output_image_data = '';

   		

		$new_filename='busi_'.time().'_'.$_REQUEST['docx'];

		

		

    	$file_config = array();

    	$file_config['upload_path'] = "./uploads/docs/";

    	$file_config['max_size'] = "1024";

    	$file_config['allowed_types'] = "docx|doc|pdf";

    	//$file_config['file_name'] = $new_filename;

    	$file_config['max_width'] = 0;

    	$file_config['max_height'] = 0;

		//var_dump($filename);var_dump($file_config); var_dump($_FILES); exit;

    	$this->load->library('upload', $file_config);     

    	if ( ! $this->upload->do_upload($filename))

    	{

    		$result = $this->upload->display_errors();

    	}else{

    		$data['upload_data'] = $this->upload->data();

    		$img = $data['upload_data']['file_name'];		 

			$img_display = substr($img,16);    			

    		$output_image_data = '<p class="form-group-row" style="margin-left:200px;color:#859731">New Uploaded file : <b>'.$img_display."</b></p>";

    		$output_image_data .= '<input type="hidden" name="docs_pdf" id="docs_pdf" value="'.$img.'" />'; //var_dump($output_image_data);

    		$result = 'docs-upload-success';

    		

    	}

    

    	sleep(1);

    	?>

    		<script language="javascript" type="text/javascript">window.top.window.stopUpload('<?php echo $result; ?>', '<?php echo $output_image_data;?>', 'logo_image22', '<?php echo $filename;?>', '<?php echo $form_id;?>');</script>   

    		<?php

	}

	# - For Presentation On Deemand

	# + For Audio Presentation 

	function upload_audio($filename, $form_id){ 

		$file_config = array();

		$file_config['upload_path'] = "./uploads/audio/";

		$file_config['max_size'] = "1024";

		$file_config['allowed_types'] = "mp3";

		$file_config['max_width'] = 0;

		$file_config['max_height'] = 0;

		$this->load->library('upload', $file_config);

		if ( ! $this->upload->do_upload($filename,'audio')){	 

			$result = $this->upload->display_errors();

		}else{

			$data['upload_data'] = $this->upload->data(); 

			$img = $data['upload_data']['file_name'];

			$img_display = explode('~!~',$img);			

			$output_image_data = '<p class="form-group-row" style="margin-left:200px;color:#859731">New Uploaded file : <b>'.$img_display[2]."</b></p>";

			$output_image_data .= '<input type="hidden" name="audio_disp" id="audio_disp" value="'.$img.'" />';

			$result = 'docs-upload-success';

			

		}

		sleep(1);

			?>

				<script language="javascript" type="text/javascript">window.top.window.stopUpload('<?php echo $result; ?>', '<?php echo $output_image_data;?>', 'div_audio_disp', '<?php echo $filename;?>', '<?php echo $form_id;?>');</script>   

				<?php

	}

	# - For Audio Presentation 

	

	# + upload_image_page

	public function upload_image_page($businessid=false,$adsid=false,$fromzoneid=0){

		$data['common']=$this->common_first($businessid,$fromzoneid); 

		$data['zoneid']=$data['common']['zoneid'];

		$data['businessid'] = $businessid;

		$data['adsid'] = $adsid;

		$data['right_container'] = $this->load->view("business/upload_image_page", $data, true); //var_dump($data['right_container']);exit;

		$this->common($data);		

	}

	

	// view bus photo

	public function view_bus_photo(){

		$data = array();

		$businessid = $_REQUEST['businessid'] ;

		$adsid = $_REQUEST['adsid'] ;

		$data['zoneid'] = $_REQUEST['zoneid'] ;

		$data['all_banner'] = $this->business->get_bus_photo_details($businessid,$adsid);  //var_dump($data['all_banner']); exit;

		$result = $this->load->view('business/subpage/viewphotos', $data, true);

		//echo(json_encode($result));

		echo($this->dr->GetDR("","", $result, "0"));	

	}

	

	public function bus_photo_order_change(){ //var_dump($_REQUEST); exit;

		$order = $_REQUEST['order'];

		$bus_id = $_REQUEST['bus_id'];

		$ad_id = $_REQUEST['ad_id'];

		$this->business->bus_photo_order_change($order,$bus_id,$ad_id);

	}

	

	// save uploaded image into folder

	public function save_banner_image($bus_id,$zoneid){ //var_dump($bus_id);exit;

		$uploadedImage=$_FILES['imgfile']['name'];

		$var = explode('.',$uploadedImage);

		$ext = pathinfo($_FILES['imgfile']['name'], PATHINFO_EXTENSION);//$ext = strtolower(array_pop($var));

		

		$imagename=time().rand().'.'.$ext;

		$rand = mt_rand( 100, 999 );

		$target = "uploads/businessphoto/$bus_id/";

		

		if(is_dir($target)==false){

			mkdir($target,0777);

		}

		$outPutImage=$imagename;

		$target=$target.basename($outPutImage);

		$pic=($_FILES['imgfile']['name']);

	

		if(move_uploaded_file($_FILES['imgfile']['tmp_name'], $target))

		{

			$picarray=array(

			'clientImage'=>$pic,

			'uploadedImage'=>$outPutImage,

			'org_id'=>$org_id

			);

			echo json_encode($picarray);

		}else{

			echo json_encode(0);

		}

	}

	// save uploaded image into database

	public function save_bus_photo(){ 

		$data=array();

		$data['image_name']=!empty($_REQUEST['uploadedInput']) ? $_REQUEST['uploadedInput'] : '';

		$data['bus_id']=!empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : 0;

		$data['ad_id']=!empty($_REQUEST['adid']) ? $_REQUEST['adid'] : '';		

		//$data['status']=($_REQUEST['status'] != '') ? $_REQUEST['status'] : 1;		

		//$data['description']=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';

		$data['save_banner']=$this->business->save_bus_photo_new($data['image_name'],$data['bus_id'],$data['ad_id']);

	}

	

	// 

	function delete_bus_photo(){ 

		$data=array();

		$data['photo_id']=!empty($_REQUEST['photo_id']) ? $_REQUEST['photo_id'] : 0;

		$data['bus_id']=!empty($_REQUEST['bus_id']) ? $_REQUEST['bus_id'] : 0;

		$data['ad_id']=!empty($_REQUEST['ad_id']) ? $_REQUEST['ad_id'] : 0;

		$data['image_name']=!empty($_REQUEST['image_name']) ? $_REQUEST['image_name'] : '';

		$data['zoneid']=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

		$data['banner_view']=$this->business->delete_bus_photo($data['photo_id'],$data['bus_id'],$data['ad_id'],$data['image_name'],$data['zoneid']);

		echo($this->dr->GetDR($data['photo_id'],"", "", "0"));

	}

	 /**

	* This function is displaying additional photos in directory page on 'photos' tab. 

	*

	* This function is accessable from the businessdashboard. 

	* <br>

	* Input Parameters:

	* <ol>

	* <li> adid</li>

	* <li> business id</li>

	* <li> business photo details</li>

	* </ol>

	* After getting all the  parameters from the view page('new_page_offer' and 'new_page'), these values passes through the function in related model.

	* <br>

	* <ol>

	* <li><b>get_bus_photo_details</b> (Model Name: business, Utility: photos order maintenance)</li>

	* </ol>

	* <br>

	* view page: <b>views/new_page</b>

	*/



	// getting business ads image details 

	function ads_image_fancybox(){ 

		$result = array();

		$data['ad_id']=!empty($_REQUEST['ad_id']) ? $_REQUEST['ad_id'] : 0;	

		$data['bus_id']=!empty($_REQUEST['bus_id']) ? $_REQUEST['bus_id'] : 0;

		$data['photo_details'] = $this->business->get_bus_photo_details($data['bus_id'],$data['ad_id']);

		

		echo(json_encode($data['photo_details']));	

	}

	# - upload_image_page

	

	

	

	public function newad($businessid=false,$fromzoneid=0){ //var_dump($_REQUEST); exit;

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['business_name']=$data['common']['sub_header_name_from_zone']['name'];		 	

		$data['is_audio_presentation']=$data['common']['sub_header_name_from_zone']['audio_presentation'];

		$data['is_video_presentation']=$data['common']['sub_header_name_from_zone']['video_presentation']; 

		$data['businessid']=$businessid;

		$data['from_zoneid']=$data['common']['from_zoneid']; //var_dump($data['from_zoneid']);

		$data['zoneid'] = $data['common']['zoneid']; //var_dump($data['zoneid']); //exit;

		

		$data['business_type']=$this->business->get_business_type_by_id($businessid,$data['zoneid']);

		$data['business_restaurant_type']=$this->business->get_business_details_by_id($businessid);  

		$bustype = $data['business_type']['approval']; //var_dump($bustype);

		//$busmode = $data['business_type']['type']; //var_dump($busmode);

		$busmode = $data['business_restaurant_type']['type']; //var_dump($busmode);

		$data['category_list_bus'] = $this->Category_new_model->get_all_categories_business($businessid,'business',$bustype,$busmode); 

		$data['gallery_images'] = $this->business_model->get_gallery_images($businessid); 

		//var_dump($data['business_type']); exit;

		$data['ckeditor_businessad'] = array(

		//ID of the textarea that will be replaced

		'id' 	=> 	'deal_description',

		'path'	=>	'assets/ckeditor',



		//Optional values

		'config' => array(

			'toolbar' 	=> 	"Full", 	//Using the Full toolbar

			'width' 	=> 	"675px",	//Setting a custom width

			'height' 	=> 	'200px',	//Setting a custom height



		));

		

		//echo "<pre>"; print_r($data['gallery_images']); echo "</pre>"; exit;		

		$data['right_container'] = $this->load->view("business/new_ad", $data, true); 

		$this->common($data);

	}

	

	public function check_title(){ 
		
	    $ad_deal_title = !empty($_REQUEST['ad_title']) ? $_REQUEST['ad_title'] : '' ;
	    $qry = "select id,deal_title from ads where deal_title='".$ad_deal_title."'";
 		$ads_arr = $this->CommonController->SelectRawquery($qry, 'row');
 		$deal_title=$ads_arr->deal_title;
 		echo json_encode(['type'=>'success','msg'=>'Dealtitle Exist']);
		// $ad_title = !empty($_REQUEST['ad_title']) ? $_REQUEST['ad_title'] : '' ;
		// $ad_id = !empty($_REQUEST['ad_id']) ? $_REQUEST['ad_id'] : '' ;
		// $ad_title= preg_replace('/[^A-Za-z0-9\-]/', '', $ad_title);                     
		// $from_where = !empty($_REQUEST['from_where']) ? $_REQUEST['from_where'] : '' ;
		// $check_title = $this->Business_model->check_title($ad_title,$ad_id);
		// echo json_encode($check_title);
		

	}

	# - check_title

	// deal title edit in edit ad 

	public function check_deal_title_in_edit(){

		$deal_title = !empty($_REQUEST['deal_title']) ? $_REQUEST['deal_title'] : '';

		$deal_title= preg_replace('/[^A-Za-z0-9\-]/', '', $deal_title);                 //if special characters use in deal_title  on 6.4.15

		$data['check_deal_title_in_edit'] = $this->business_model->check_deal_title_in_edit($deal_title);

		echo($this->dr->GetDR($data['check_deal_title_in_edit'],"", "", "0"));

	}

	# + Search engine created on the ad creation.

	function make_search_engine_title(){

		$adid=!empty($_REQUEST['adid']) ? $_REQUEST['adid'] : 0 ;

		$zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;

		$business_id=!empty($_REQUEST['business_id']) ? $_REQUEST['business_id'] : 0 ;

		$deal_title=!empty($_REQUEST['deal_title']) ? $_REQUEST['deal_title'] : '' ;

		$deal_title= preg_replace('/[^A-Za-z0-9\-]/', '-', $deal_title); 

		$deal_title_newad= !empty($_REQUEST['deal_title']) ? $_REQUEST['deal_title'] : '' ;//var_dump($deal_title_newad);exit;

		$make_search_engine_title=$this->sales_zone->make_search_engine_title($zoneid,$business_id,$deal_title,$deal_title_newad,$adid);

		echo $make_search_engine_title;

	}

	public function get_zip_details()

	{

		$response = array();

		$zone_id = $_REQUEST['zoneId'];

		$ad_id = $_REQUEST['ad_id'];

		if (!empty($_REQUEST['ad_id'])&&($_REQUEST['ad_id']!=0)) {

			$selected = $this->zip->selected_zip_for_delivery($zone_id,$ad_id);

			$response['selected_zip'] = explode(",",$selected[0]['deliver_zips']);

		}

		$response['zipcode'] = $this->zip->get_zip_for_zone($zone_id);

		echo json_encode($response);

	}

	public function get_miles_details()

	{

		$response = array();

		$zone_id = $_REQUEST['zoneId'];

		$ad_id = $_REQUEST['ad_id'];

		if (!empty($_REQUEST['ad_id'])&&($_REQUEST['ad_id']!=0)) {

			$selected = $this->sales_zone->get_ads_miles($zone_id,$ad_id);
 
			$response['selected_zip'] = $selected;

		}

		//$response['zipcode'] = $this->sales_zone->get_ads_miles($zone_id);

		echo json_encode($response);

	}

	function subcategories_in_a_category_zone(){ 		

		$adid = !empty($_REQUEST['adid']) ? $_REQUEST['adid'] : '';		

		$catid=$_REQUEST['cat_id'];  

		$zoneid=$_REQUEST['iszoneid']; 

		$subcat_id_foredit=$_REQUEST['subcat_id_foredit'];

		$busid = $_REQUEST['busid'];

		$data=array();

		$data['subcategory_category_zone']=$this->Category_new_model->get_all_subcategories_zone($catid,$zoneid,'business');

		$data['subcategory_exists'] = $this->Category_new_model->subcategory_exists($catid,$zoneid,$busid,$adid);

		$data['adid']=0; $data['zoneid']=0; $data['businessid']=0; $data['subcat_id_foredit']=$subcat_id_foredit;

		$result = $this->load->view('business/subpage/ad_subcategory_zone', $data, true);		

		echo($this->dr->GetDR($data['subcategory_exists'],$subcat_id_foredit, $result, "0"));

	}

	

	

	function subcategories_in_a_category_zone_newad(){ 

		

		$catid=$_REQUEST['cat_id']; //var_dump($_REQUEST);  

		$zoneid=$_REQUEST['iszoneid']; 

		$subcat_id_foredit=$_REQUEST['subcat_id_foredit'];

		$busid = $_REQUEST['busid'];

		$data=array();

		$data['subcategory_category_zone']=$this->Category_new_model->get_all_subcategories_zone($catid,$zoneid,'business');

		$data['subcategory_exists'] = $this->Category_new_model->subcategory_exists($catid,$zoneid,$busid);

		$data['adid']=0; $data['zoneid']=0; $data['businessid']=0; $data['subcat_id_foredit']=$subcat_id_foredit;

		$result = $this->load->view('business/subpage/ad_subcategory_zone', $data, true);		

		echo($this->dr->GetDR($data['subcategory_exists'],$subcat_id_foredit, $result, "0"));

	}





# + to check the start and stop in the database		

	public function check_ad_start_time(){

		$business_id = $_REQUEST['business_id'];

		$start_date = !empty($_REQUEST['start_date']) ? $_REQUEST['start_date'] : '';

		$end_date = !empty($_REQUEST['end_date']) ? $_REQUEST['end_date'] : '';

		$start_time = !empty($_REQUEST['start_time']) ? $_REQUEST['start_time'] : '';

		$end_time = !empty($_REQUEST['end_time']) ? $_REQUEST['end_time'] : '';

		//$type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';

		$data['check_date_time'] = $this->business_model->check_time_slot($business_id,$start_date,$end_date,$start_time,$end_time); 

		//var_dump($data['check_date_time']);

		if($data['check_date_time']==0){

			$msg = 0;

		}else{

			$msg = 1;

		}

		//echo json_encode($msg);

		echo($this->dr->GetDR($msg,"", "1", "0"));	

	}
	
	public function savead(){
		$deal = '' ;
		$adid = $_REQUEST['adid']==-1 ? "-1" : $_REQUEST['adid'];
		$business_id = $_REQUEST['business_id'];
		$zoneid=$_REQUEST['zoneid'];
		$fromzoneid=$_REQUEST['fromzoneid'];
		$name = !empty($_REQUEST['name']) ? $this->db->escape_str($_REQUEST['name']) : '';
		$offerCode = !empty($_REQUEST['offer_code']) ? $this->db->escape_str($_REQUEST['offer_code']) : '';
		$deal_description = !empty($_REQUEST['deal_description']) ? $_REQUEST['deal_description'] : '';
		$arr = explode('\n',$deal_description) ;
		foreach( $arr as $val ){ $deal .= $val ;}
		$deal_description = $deal ;
		$adtext = !empty($_REQUEST['adtext']) ? $_REQUEST['adtext'] : '' ;
		$multiimage = !empty($_REQUEST['multiimage']) ? $_REQUEST['multiimage'] : '';
		$short_description = !empty($_REQUEST['short_description']) ? $_REQUEST['short_description'] :strip_tags($_REQUEST['deal_description']);
		$number_of_deal = !empty($_REQUEST['number_of_deal']) ? $_REQUEST['number_of_deal'] : '';
		$deal_restriction = !empty($_REQUEST['deal_restriction']) ? $_REQUEST['deal_restriction'] : '';
		$deal_information = !empty($_REQUEST['deal_information']) ? $this->db->escape_str($_REQUEST['deal_information']) : '';
		$category_id = !empty($_REQUEST['category_id']) ? $_REQUEST['category_id'] : 0;
		$subcategory_id = !empty($_REQUEST['subcategory_id']) ? $_REQUEST['subcategory_id'] : 0 ; 
		$showreservation = !empty($_REQUEST['showreservation']) ? $_REQUEST['showreservation'] : 0 ;
		$showmenutab = !empty($_REQUEST['showmenutab']) ? $_REQUEST['showmenutab'] : 0 ;
		$ad_startdatetime = !empty($_REQUEST['ad_startdatetime']) ? $_REQUEST['ad_startdatetime'] : '';
		$ad_stopdatetime = !empty($_REQUEST['ad_stopdatetime']) ? $_REQUEST['ad_stopdatetime'] : '';
		$ad_starttime = !empty($_REQUEST['ad_starttime']) ? $_REQUEST['ad_starttime'] : '';
		$ad_stoptime = !empty($_REQUEST['ad_stoptime']) ? $_REQUEST['ad_stoptime'] : '';
		$text_message = !empty($_REQUEST['text_message']) ? $_REQUEST['text_message'] : '' ;        
		$docs_pdf = !empty($_REQUEST['docs_pdf']) ? $_REQUEST['docs_pdf'] : '';
		$docs_pdf_show_val = !empty($_REQUEST['docs_pdf_show_val']) ? $_REQUEST['docs_pdf_show_val'] : '';
		$docs_pdf_foodmenu = !empty($_REQUEST['docs_pdf_foodmenu']) ? $_REQUEST['docs_pdf_foodmenu'] : '' ;
		$docs_foodmenu_show_val = !empty($_REQUEST['docs_foodmenu_show_val']) ? $_REQUEST['docs_foodmenu_show_val'] : '' ;
		$text_reason = !empty($_REQUEST['text_reason']) ? $_REQUEST['text_reason'] : '' ;
		$business_zone_id = !empty($_REQUEST['business_zone_id']) ? $_REQUEST['business_zone_id'] : 0 ; 
		$where_from= !empty($_REQUEST['where_from']) ? $_REQUEST['where_from'] : '';
		$imagetype= !empty($_REQUEST['imagetype']) ? $_REQUEST['imagetype'] : '';		
		$search_engine_title= !empty($_REQUEST['search_engine_title']) ? $_REQUEST['search_engine_title'] : '' ; 
		$audio_file_val = !empty($_REQUEST['audio_file_val']) ? $_REQUEST['audio_file_val'] : '';
		$deliver = !empty($_REQUEST['deliver']) ? $_REQUEST['deliver'] : 0;				
		$deliver_zips = !empty($_REQUEST['deliver_zips']) ? implode(",",$_REQUEST['deliver_zips']) : 0;
		$deal_title= !empty($_REQUEST['deal_title']) ? $_REQUEST['deal_title'] : '' ;
		$deal_title=str_replace(' ','-',trim($deal_title));
		$textmeoffer= !empty($_REQUEST['textmeoffer']) ? $_REQUEST['textmeoffer'] : '' ;
		$business_name=!empty($_REQUEST['business_name']) ? $_REQUEST['business_name'] : '' ;
		$smart_url= base_url()."zone/".$zoneid.'/'.str_replace(' ','%20',$business_name).'/'.$deal_title;
		$miles= !empty($_REQUEST['miles']) ? $_REQUEST['miles'] : '' ; 
		$deliveryCharges= !empty($_REQUEST['deliveryCharges']) ? $_REQUEST['deliveryCharges'] : '' ;
		$subcatimagebutton= !empty($_REQUEST['subcatimagebutton']) ? $_REQUEST['subcatimagebutton'] : '' ;
		$zonesubuser = isset($_REQUEST['subusereixsts'])?$_REQUEST['subusereixsts']:'';

		/*set longtitute and latitute*/
		// $sql="SELECT c.id as addressid,c.latitude,c.longitude,c.zip_code from business as b  INNER JOIN address as c ON b.addressid=c.id WHERE b.id=".$business_id."";
		// $longArr = $this->CommonController->SelectRawquery($sql);
		// $longzip = isset($longArr[0]['zip_code'])?$longArr[0]['zip_code']:0;
		// $addressid = isset($longArr[0]['addressid'])?$longArr[0]['addressid']:0;
		// die('jj');
		// if($longzip > 0){
		// 	$lonlngArr = $this->CommonController->getLocationLatLong($longzip);
		// 	$address_updatedata=array(
        //         'latitude'=>$lonlngArr['lat'],           
        //         'longitude'=>$lonlngArr['lng']            
        //     );  
		// 	$this->CommonController->updateData('address',$address_updatedata,['id'=>$addressid]);
		// }
            
		/*set longtitute and latitute*/
 		
 		if($search_engine_title!=''){
			$search_engine_title_arr=explode('/',$search_engine_title);
			$search_engine_title=$search_engine_title_arr[1];
		}else{
			$search_engine_title=$search_engine_title;
		}
		
		if(!empty($_REQUEST['audio_file'])){
			$upload_audio_file=$_REQUEST['audio_file'];
		}else{
			$upload_audio_file='';
		} 

		if(!empty($_REQUEST['video'])){
			$upload_video_file=$_REQUEST['video']; 
		}else{
			$upload_video_file='';
		}
		
		if($docs_pdf==''){
			$docs_pdf=$docs_pdf_show_val;
		}
		
		if($docs_pdf_foodmenu==''){
			$docs_pdf_foodmenu=$docs_foodmenu_show_val;
		}
		
		if($upload_audio_file==''){
			$upload_audio_file=$audio_file_val;
		}
		$data = array(
			'short_description'=> $short_description,
			'number_of_deal'=> $number_of_deal,
			'deal_restriction'=> $deal_restriction,
			'deal_information'=> $deal_information,
			'deal_description'=> $deal_description,
			'adtext' => stripslashes($adtext),
			'categoryid' => 0,
			'categoryid1' => 0,
			'subcategoryid' => 0,
			'subcategoryid1' => 0,
			'active' => '1',
			'startdate' => $ad_startdatetime,
			'enddate' => $ad_stopdatetime,
			'starttime' => $ad_starttime,
			'stoptime' => $ad_stoptime,
			'text_message' => '',
			'docs_pdf' => $docs_pdf,
			'foodmenu' => $docs_pdf_foodmenu,
			'imagetype' => $imagetype,
			'search_engine_title' => $search_engine_title,
			'audio_file'=>$upload_audio_file,
			'video_file'=>$upload_video_file,
			'deal_title'=>  $deal_title,		
			'deliver'=>$deliver,
			'deliver_zips'=>$deliver_zips,
			'textmeoffer' => $textmeoffer,
			'smarturl'=>$smart_url,
			'estimate_miles'=> $miles,
			'delivery_charges'=> $deliveryCharges,
			'show_subcat_image'=> $subcatimagebutton
		);
		
		if(!empty($offerCode)){
			$data['offer_code'] = stripslashes($offerCode);
		}

        if(!empty($business_id)){        
        	$data['business_id'] = $business_id;
        }

		$data['timestamp']=time();
		
		if($adid>0){
			$deal_title= preg_replace('/[^A-Za-z0-9\-]/', '', $deal_title);
			if($deal_title==''){
				$deal_title = $adid;
				$smart_url= base_url()."zone/".$zoneid.'/'.str_replace(' ','%20',$business_name).'/'.$deal_title;
			}
			$data_update = array(
				'short_description'=> $short_description,
				'number_of_deal'=> $number_of_deal,
				'deal_restriction'=> $deal_restriction,
				'deal_information'=> $deal_information,
				'deal_description'=> $deal_description,
				'adtext' => stripslashes($adtext),
				'active' => '1',
				'startdate' => $ad_startdatetime,
				'enddate' => $ad_stopdatetime,
				'starttime' => $ad_starttime,
				'stoptime' => $ad_stoptime,
				'deal_title' => $search_engine_title,
				'search_engine_title' => $search_engine_title,
				'deal_title'=>  $deal_title,
				'text_message' => '',
				'docs_pdf' => $docs_pdf,
				'foodmenu' => $docs_pdf_foodmenu,
				'imagetype' => $imagetype,
				'audio_file'=>$upload_audio_file,
				'video_file'=>$upload_video_file,
				'deliver'=>$deliver,
				'timestamp' => time(),
				'textmeoffer' => $textmeoffer,
				'smarturl'=>$smart_url,
				'estimate_miles'=> $miles , 
				'delivery_charges'=> $deliveryCharges,
				'show_subcat_image'=> $subcatimagebutton
			); 
			if($deliver!=0){$data_update['deliver_zips'] = $deliver_zips;}
				$sql = "SELECT a.approval from ads_setting_preferences a ,ad_category_subcategory b ,ads c WHERE b.adid = c.id AND c.business_id = a.businessid AND b.adid =".$adid;
				$result = $this->CommonController->SelectRawquery($sql,'resultArray');
				
				$approval = $result[0]['approval'];
				$this->CommonController->updateData('ads',$data_update,['id'=>$adid]);
				$data['ads_save_cat_subcat'] = $this->Category_new_model->ads_save_cat_subcat($adid,$category_id,$subcategory_id,$zoneid,'business',$business_id,$subcategory_id,$showreservation,$showmenutab); 

				if($fromzoneid == '0' || empty($fromzoneid)){
					$this->ads->update_adtozone_approval($adid,$zoneid,$business_id);    
				}
				
				if($zonesubuser != ''){
					$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'update Ads By Zonedashboard',serialize($data_update));
				}

				$data['ads_save_approval'] =  $this->Category_new_model->ads_save_approval($adid,$category_id,$subcategory_id,$zoneid,'business',$business_id,$subcategory_id);
			}else {	
				$adid = $this->CommonController->InsertData('ads', $data);
				if($deal_title==''){
					$insert_deal_title="UPDATE ads SET deal_title=".$adid.",smarturl='".base_url()."zone/".$zoneid."/".str_replace(' ','%20',$business_name)."/".$adid."' WHERE id=".$adid;                                                                
					$query=$this->db->query($insert_deal_title);	
				}
				if(!empty($multiimage)){
					$seperate_images= explode(',',$multiimage);
					foreach($seperate_images as $sp_img){
						$data['save_image']=$this->Business->save_bus_photo_new($sp_img,$business_id,$adid);
					}
				}
				$data['ads_save_zone'] = $this->Ads_model->ads_save_zonefrombusiness($business_id,$adid,$where_from,$fromzoneid,$subcategory_id);
				$data['ads_save_cat_subcat'] = $this->Category_new_model->ads_save_cat_subcat($adid,$category_id,$subcategory_id,$zoneid,'business',$business_id,$subcategory_id,$showreservation,$showmenutab); 
				if($zonesubuser != ''){
					$this->CommonController->InsertSubUserData('subuserlogs',$zonesubuser,'Add Ads By Zonedashboard',serialize($data));
				}
			}
			
			if(isset($image_test_name) && $image_test_name != ''){
				$sql_order = $this->db->query("SELECT (MAX(`order`)+1) as neworder FROM businessphotos_display WHERE `bus_id` =".$business_id." AND ad_id=".$adid);
				$order = $sql_order->result_array();
				$order_val = !empty($order[0]['neworder']) ? $order[0]['neworder'] : 1;
				
				$sql_insert = "INSERT INTO business_photos(image_name, ad_id, bus_id,timestamp) VALUES ('".$image_test_name."',".$adid.",".$business_id.",".time().")";
				
				$this->db->query($sql_insert);
				$bus_photo_id= $this->db->insert_id();
				$data_photo_display=array('busphotosid'=>$bus_photo_id , 'bus_id'=>$business_id,'ad_id'=>$adid, 'order'=>$order_val,'status'=>1);
				$this->db->insert('businessphotos_display',$data_photo_display);
			}
		// $update_zone_menu=$this->menu_generator($zoneid);
		echo json_encode($adid);	
	}

	# +  Delete Ad from business section 

	public function deleteAd(){	
		$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
		$business_id = !empty($_REQUEST['business_id']) ? $_REQUEST['business_id'] : 0 ;
		$zone_id = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;
		
		
		$this->CommonController->deleteData('ads',['id'=> $id]);
		$this->CommonController->deleteData('ad_to_zone',['adid'=> $id]);
		$this->CommonController->deleteData('ad_category_subcategory',['adid'=> $id]);
		$data = array();
		$data['ads'] = $this->Ads_model->get_ads_for_business($business_id);
		$data['business'] = $this->Business->get_business_by_id($business_id);
		$data['adSetting']=$this->Business->get_ad_setting_by_id($business_id);
		// $update_zone_menu=$this->menu_generator($zone_id);
		$data['zoneid'] =0;
		echo json_encode(1);

    }

	# -  Delete Ad from business section 

	public function editad($businessid,$fromzoneid,$adid,$zoneid){
		$data['adid']=$adid;
		$data['businessid']=$businessid;
		$data['zoneid']=$zoneid;
		$data['fromzoneid']=$fromzoneid;
		$data['zone_name_arr']=$this->Zone_model->get_zone($zoneid); 
		$data['zone_name']=$data['zone_name_arr']['seo_zone_name'];
		$data['business_type']=$this->Business->get_business_type_by_id($businessid,$data['zoneid']); 
		$bustype = $data['business_type']['approval']; 
		$data['business_restaurant_type']=$this->Business->get_business_details_by_id($businessid);
		$busmode = $data['business_restaurant_type']['type']; 

		if((int)$bustype != 3 && (int)$bustype != -3){
			$data['get_category_subcategory'] = $this->Category_new_model->get_category_subcategory($adid,$zoneid);
			$catid=$data['get_category_subcategory']['catid'];
		}

		$data['category_list_bus'] = $this->Category_new_model->get_all_categories_business($businessid,'business',$bustype,$busmode,$catid); 
		$data['gallery_images'] = $this->Business_model->get_gallery_images($businessid); 
		$data['business_images_gallery'] = $this->Business_model->business_images_gallery($adid); 
		$data['ckeditor_businessad'] = array(
			'id' 	=> 	'ad_text_fromshowad',
			'path'	=>	'assets/ckeditor',
			
			'config' => array(
				'toolbar' 	=> 	"Full", 	
				'width' 	=> 	"675px",	
				'height' 	=> 	'200px',
			)
		);
		
		$data['addetails']=$this->Ads_model->get_ads_by_zoneid_adid_selectedid_businessidnew($adid,$businessid,$zoneid);
		$data[0]['zoneid']=$zoneid;
		echo json_encode($data);
	}

	function next_ad_change_category(){

		$zone_id = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;

		$business_id = !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : 0;

		$result=$this->business_model->go_to_next_business($zone_id,$business_id); //var_dump($result); exit;

		if(!empty($result)){

			$adid=$result['adid'];

			$businessid=$result['businessid'];

		

		echo($this->dr->GetDR($zone_id, $adid, $businessid, "0"));

		}

	}

	function previous_ad_change_category(){

		$zone_id = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;

		$business_id = !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : 0;

		$result=$this->business_model->go_to_previous_business($zone_id,$business_id); //var_dump($result); exit;

		if(!empty($result)){

			$adid=$result['adid'];

			$businessid=$result['businessid'];

		

		echo($this->dr->GetDR($zone_id, $adid, $businessid, "0"));

		}

	}

	

# + remove_menu added on 25.11.14 to delete the menu

	function remove_menu(){

		$ad_id = !empty($_REQUEST['ad_id']) ? $_REQUEST['ad_id'] : 0;

		$docs_foodmenu_show_val = !empty($_REQUEST['docs_foodmenu_show_val']) ? $_REQUEST['docs_foodmenu_show_val'] : 0;

		$business_id = !empty($_REQUEST['business_id']) ? $_REQUEST['business_id'] : 0;

		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;

		$fromzoneid = !empty($_REQUEST['fromzoneid']) ? $_REQUEST['fromzoneid'] : 0;

		$sql_update_menu_blank = "UPDATE ads SET foodmenu = '' WHERE id = ".$ad_id." AND business_id=".$business_id;

		//$sql_delete_menu = "DELETE FROM ads WHERE business_id = ".$business_id." AND id=".$ad_id." AND foodmenu = ".$docs_foodmenu_show_val;

		$query_sql_update_menu = $this->db->query($sql_update_menu_blank);

		echo($this->dr->GetDR("Success", "Success", "", "0"));

	}

# - remove_menu



# + remove_business_overview to remove remove_business_overview file

	function remove_business_overview(){ 

		$ad_id = !empty($_REQUEST['ad_id']) ? $_REQUEST['ad_id'] : 0;

		$docs_foodmenu_show_val = !empty($_REQUEST['docs_pdf_show_val']) ? $_REQUEST['docs_pdf_show_val'] : 0;

		$business_id = !empty($_REQUEST['business_id']) ? $_REQUEST['business_id'] : 0;

		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;

		$fromzoneid = !empty($_REQUEST['fromzoneid']) ? $_REQUEST['fromzoneid'] : 0;

		$sql_update_business_overview = "UPDATE ads SET docs_pdf = '' WHERE id = ".$ad_id." AND business_id=".$business_id;

		$query_update_business_overview = $this->db->query($sql_update_business_overview);

		echo($this->dr->GetDR("Success", "Success", "", "0"));

	}

# - remove_business_overview



# + remove_audio_presentation to remove remove_audio_presentation file

	function remove_audio_presentation(){ 

		$ad_id = !empty($_REQUEST['ad_id']) ? $_REQUEST['ad_id'] : 0;

		$ad_pdf_val = !empty($_REQUEST['ad_pdf_val']) ? $_REQUEST['ad_pdf_val'] : 0;

		$business_id = !empty($_REQUEST['business_id']) ? $_REQUEST['business_id'] : 0;

		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;

		$fromzoneid = !empty($_REQUEST['fromzoneid']) ? $_REQUEST['fromzoneid'] : 0;

		$sql_update_audio_presentation = "UPDATE ads SET audio_file = '' WHERE id = ".$ad_id." AND business_id=".$business_id;

		$query_update_audio_presentation = $this->db->query($sql_update_audio_presentation);

		echo($this->dr->GetDR("Success", "Success", "", "0"));

	}

# - remove_audio_presentation



# + Sending email to SNAP subscribers

	function adupdatemailtosnapsubscribers($businessid = 0, $zoneid = 0, $adid = 0,$deal_title=0){

		$sub = ''; $msg =''; $ad_dlink = base_url().'zone/'.$zoneid.'/'.$businessid.'/'.$deal_title.'/' ; $data = array(); 

		$data['business'] = (array)($this->business->get_business_by_id($businessid));  // Business Owner details 

		/*$data['addetails']=$this->ads->get_ads_by_zoneid_adid_selectedid_businessidnew($adid,$businessid,$zoneid); // Add Details

		if(!empty($data['addetails'])){

			$ad_dlink = !empty($data['addetails'][0]['deal_title']) ? $data['addetails'][0]['deal_title'] : '';

		}*/

		$sql = "SELECT b.* FROM user_offer_status a, users b WHERE a.user_id = b.id AND a.zone_id = ".$zoneid." AND a.createdby_id = ".$businessid." AND a.status = 1" ;

		$result = $this->db->query($sql)->result_array();

		if(!empty($result)){

			foreach($result as $key=>$val){ 

				$sub = 'Ad updated by '.$data['business']['name'] ;

				$msg = "<div style='border:1px solid #900; padding:5px;'><font size='4'>Dear ".$val['first_name'].' '.$val['last_name'].",<br /><br />

					Existing Advertisement has been updated by ".urldecode($data['business']['name']).".  

					<br/><br/>

					Please click the link below:<br /><br />

					<a href='".$ad_dlink."' target='_blank'>CLICK HERE</a><br/><br/>

					Best Regards,<br />

					Savings Sites<br/>

					<a href='savingssites.com' target='_blank'>savingssites.com</a>

					<hr>

					</font><br><br><br>" ;

					

				$uemailid=$val['email'] ; 

				$fromemail=$this->config->item('adminEmailId');

				$this->load->library('email');

				$this->email->clear();

				$this->email->from($fromemail);

				$this->email->subject($sub);

				$this->email->message($msg);

				$this->email->to($uemailid);

				$this->email->send();

				$to[]=$uemailid;

			}

		}

		//exit;

		//$message="Email send successfully ";

		//echo($this->dr->GetDR("Successfully", $message, "", "0"));	

		

	}

# - Sending email to SNAP subscribers

	

	################################################  Business Advertisement Part ends #######################################################

	

	

	################################################  Business Offers Part Start #############################################################

	

	public function jobview($businessid=false,$fromzoneid=0){ 

		$data['common']=$this->common_first($businessid,$fromzoneid);	 //var_dump($data); exit;	

		$data['zone_id']=$data['common']['zoneid']; 	

		$data['ckeditor_jd'] = array(

		//ID of the textarea that will be replaced

		'id' 	=> 	'job_description',

		'path'	=>	'assets/ckeditor',



		//Optional values

		'config' => array(

			'toolbar' 	=> 	"Full", 	//Using the Full toolbar

			'width' 	=> 	"560px",	//Setting a custom width

			'height' 	=> 	'100px',	//Setting a custom height



		));

		$data['edit_job_description'] = array(

		//ID of the textarea that will be replaced

			'id' 	=> 	'ckeditor_edit_jd',

			'path'	=>	'assets/ckeditor',

		//Optional values

			'config' => array(

				'toolbar' 	=> 	"Full", 	//Using the Full toolbar

				'width' 	=> 	"560px",	//Setting a custom width

				'height' 	=> 	'100px',	//Setting a custom height

			));	

		

		$data['job_listing'] = $this->db->query("select * from job_listing where business_id = " . $businessid)->result_array();

		$data['right_container'] = $this->load->view("business/job_view", $data, true); 

		$this->common($data);

	}

	

# + saveJob function 

	public function saveJob(){	 

        $id = $_REQUEST['id'];

        $business_id = $_REQUEST['business_id'];

        $title = $_REQUEST['title'];

        $start_date = $_REQUEST['start_date'];

        $salary_range = $_REQUEST['salary_range'];

        $description = $_REQUEST['description'];

        $data = array(

            "business_id" => $business_id,

            "title" => $title,

            "description" => $description,

            "start_date" => $start_date,

            "salary_range" => $salary_range

        );

        //need a jobs model with CRUD + List

        if($id == "-1")

        {

            //new create

            $this->db->insert('job_listing', $data);

        }

        else

        {

            //save

            $this->db->where('id', $id);

            $this->db->update('job_listing', $data);

        }



        $updata = array();

		$updata['business'] = $this->business->get_business_by_id($business_id);

        $updata['job_listing'] = $this->db->query("select * from job_listing where business_id = " . $business_id)->result_array();

        //$data['jobs'] = $this->load->view("dashboards/business_parts/job_view", $updata, true);

		$data['jobs'] = $this->load->view("business/job_view", $updata, true);

		echo($this->dr->GetDR("Success", "Success", $data['jobs'], "0"));

	}

# - saveJob function 



# + view_jobs  --> This will show the jobs already present in the system

	public function view_jobs($businessid,$fromzoneid){ 

		$data['common']=$this->common_first($businessid,$fromzoneid);	 //var_dump($data); exit;	

		$data['zone_id']=$data['common']['zoneid']; 	

		$data['ckeditor_jd'] = array(

		//ID of the textarea that will be replaced

		'id' 	=> 	'job_description',

		'path'	=>	'assets/ckeditor',



		//Optional values

		'config' => array(

			'toolbar' 	=> 	"Full", 	//Using the Full toolbar

			'width' 	=> 	"560px",	//Setting a custom width

			'height' 	=> 	'100px',	//Setting a custom height



		));

		$data['edit_job_description'] = array(

		//ID of the textarea that will be replaced

			'id' 	=> 	'ckeditor_edit_jd',

			'path'	=>	'assets/ckeditor',

		//Optional values

			'config' => array(

				'toolbar' 	=> 	"Full", 	//Using the Full toolbar

				'width' 	=> 	"560px",	//Setting a custom width

				'height' 	=> 	'100px',	//Setting a custom height

			));	

		

		$data['job_listing'] = $this->db->query("select * from job_listing where business_id = " . $businessid)->result_array();

		//var_dump($data['job_listing']);exit;

		$data['right_container'] = $this->load->view("business/view_job", $data, true); 

		//var_dump($data['right_container']);exit;

		if(!empty($data['right_container']))

		echo($this->dr->GetDR("Success", "Success", $data['right_container'], "0"));

	}

# - view_jobs



# + Load Job -> For editing the job offer created

	public function loadJob(){        			

        $id = $_REQUEST['id'];

        $result = $this->db->query("select * from job_listing where id = " .$id); 

        echo(json_encode($result->row()));

    }

# - Load Job -> For editing the job offer created



# + RemoveJob -> to delete the created job

	public function RemoveJob(){    

        $id = $_REQUEST['id'];

        $business_id = $_REQUEST['business_id'];

        $this->db->where('id', $id);

        $this->db->delete('job_listing');

        $updata = array();

		$updata['business'] = $this->business->get_business_by_id($business_id);

        $updata['job_listing'] = $this->db->query("select * from job_listing where business_id = " . $business_id)->result_array();

        //$result = $this->load->view("dashboards/business_parts/job_view", $updata, true);

		$data['jobs'] = $this->load->view("business/job_view", $updata, true);

        echo($this->dr->GetDR($id, "n/a", $data['jobs'], "0"));

    } 

# - RemoveJob -> to delete the created job



/////////////////////////////////////////////////////// For barter Jobs



# + Barter jobs	

	public function barter($businessid=false,$fromzoneid=0){   

		$data['common']=$this->common_first($businessid,$fromzoneid);//echo "<pre>";var_dump($data['common']['zone'][0]['zoneid']);exit;

		$data['zone_id'] = $data['common']['zone'][0]['zoneid']; 

		$data['business'] = $this->business->get_business_by_id($businessid); 

		$data['ckeditor_barterdescription'] = array(

            //ID of the textarea that will be replaced

            'id' 	=> 	'barter_description',

            'path'	=>	'assets/ckeditor',

            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"560px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



        ));

		$data['ckeditor_barterdescription_edit'] = array(

            //ID of the textarea that will be replaced

            'id' 	=> 	'barter_description_edit',

            'path'	=>	'assets/ckeditor',

            //Optional values

            'config' => array(

                'toolbar' 	=> 	"Full", 	//Using the Full toolbar

                'width' 	=> 	"560px",	//Setting a custom width

                'height' 	=> 	'100px',	//Setting a custom height



        ));

		$data['barter_listing'] = $this->db->query("select * from barter_listing where business_id = " . $businessid)->result_array();

        //$data['barter'] = $this->load->view("dashboards/business_parts/barter_view", $data, true);       

		//echo($this->dr->GetDR("Success", "Success", $data['barter'], "0"));		 	

		$data['right_container'] = $this->load->view("business/barter_view", $data, true); 

		$this->common($data);

	}	

# - Barter jobs	



# + view_barter  --> This will show the barter already present in the system

	public function view_barter($businessid,$fromzoneid){ 

		$data['common']=$this->common_first($businessid,$fromzoneid);	 //var_dump($data); exit;	

		$data['zone_id']=$data['common']['zoneid']; 	

		$data['ckeditor_jd'] = array(

		//ID of the textarea that will be replaced

		'id' 	=> 	'job_description',

		'path'	=>	'assets/ckeditor',



		//Optional values

		'config' => array(

			'toolbar' 	=> 	"Full", 	//Using the Full toolbar

			'width' 	=> 	"560px",	//Setting a custom width

			'height' 	=> 	'100px',	//Setting a custom height



		));

		$data['edit_job_description'] = array(

		//ID of the textarea that will be replaced

			'id' 	=> 	'ckeditor_edit_jd',

			'path'	=>	'assets/ckeditor',

		//Optional values

			'config' => array(

				'toolbar' 	=> 	"Full", 	//Using the Full toolbar

				'width' 	=> 	"560px",	//Setting a custom width

				'height' 	=> 	'100px',	//Setting a custom height

			));	

		

		$data['barter_listing'] = $this->db->query("select * from barter_listing where business_id = " . $businessid)->result_array();

		$data['right_container'] = $this->load->view("business/view_barter", $data, true); 

		if(!empty($data['right_container']))

		echo($this->dr->GetDR("Success", "Success", $data['right_container'], "0"));

	}

# - view_barter





# + SaveBarter 

	public function SaveBarter(){                                            

        $id = $_REQUEST['id']; 

        $business_id = $_REQUEST['business_id'];

        $title = $_REQUEST['title'];

        $start_date = $_REQUEST['start_date'];

        $salary_range = $_REQUEST['salary_range'];

        $description = $_REQUEST['description'];

        $data = array(

            "business_id" => $business_id,

            "title" => $title,

            "description" => $description,

            "start_date" => $start_date,

            "salary_range" => $salary_range

        );	

		//var_dump($_REQUEST); var_dump($data); exit;	

        if($id == "-1")

        {

            //new create

            $this->db->insert('barter_listing', $data);

        }

        else

        {

            //save

            $this->db->where('id', $id);

            $this->db->update('barter_listing', $data);

        }

        $updata = array();

		$updata['business'] = $this->business->get_business_by_id($business_id);

        $updata['barter_listing'] = $this->db->query("select * from barter_listing where business_id = " . $business_id)->result_array();

        $data['barter'] = $this->load->view("business/barter_view", $updata, true);

		echo($this->dr->GetDR("Success", "Success", $data['barter'], "0"));

	}

	public function SaveBarter1(){                                     

        $id = $_REQUEST['id']; 

        $business_id = $_REQUEST['business_id'];

        $title = $_REQUEST['title'];

        $start_date = $_REQUEST['start_date'];

        $salary_range = $_REQUEST['salary_range'];

        $description = $_REQUEST['description'];

        $data = array(

            "business_id" => $business_id,

            "title" => $title,

            "description" => $description,

            "start_date" => $start_date,

            "salary_range" => $salary_range

        );	

		//var_dump($_REQUEST); var_dump($data); exit;	

        if($id == "-1")

        {

            //new create

            $this->db->insert('barter_listing', $data);

        }

        else

        {

            //save

            $this->db->where('id', $id);

            $this->db->update('barter_listing', $data);

        }

        $updata = array();

		$updata['business'] = $this->business->get_business_by_id($business_id);

        $updata['barter_listing'] = $this->db->query("select * from barter_listing where business_id = " . $business_id)->result_array();

        $data['barter'] = $this->load->view("business/barter_view", $updata, true);

		echo($this->dr->GetDR("Success", "Success", $data['barter'], "0"));

	}

# - SaveBarter



# - SaveBarter



# + loadBarter

	public function loadBarter(){    

        $id = $_REQUEST['id'];

        $result = $this->db->query("select * from barter_listing where id = " .$id);

        echo(json_encode($result->row()));

    }

# - loadBarter



# + RemoveBarter

	public function RemoveBarter(){    

        $id = $_REQUEST['id'];

        $business_id = $_REQUEST['business_id'];

        $this->db->where('id', $id);

        $this->db->delete('barter_listing');

        $updata = array();

		$updata['business'] = $this->business->get_business_by_id($business_id);

        $updata['barter_listing'] = $this->db->query("select * from barter_listing where business_id = " . $business_id)->result_array();

		//$data['barter'] = $this->load->view("business/barter_view", $updata, true);

        echo($this->dr->GetDR($id, "n/a",$updata['barter_listing'], "0"));

    }

# - RemoveBarter



	

	################################################  Business Offers Part End ##############################################################

	

	

	################################################  Business News Letter Part Start #######################################################	

	

	public function changestatus($businessid=false,$fromzoneid=0){ 

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['zone_id'] = $data['common']['zoneid'];

		$data['businessid']=$businessid;

		$data['newsletter_status'] = $this->business->get_newsletter_by_business($businessid);		 	

		$data['right_container'] = $this->load->view("business/view_news_letter_status", $data, true); 

		$this->common($data);

	}

	function update_newsletter_status($id,$status){

		$data['update_newsletter_status'] = $this->business->update_newsletter_by_business($id,$status);

	}

	public function viewnewlettersusers($businessid=false,$fromzoneid=0){ 

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['zone_id'] = $data['common']['zoneid'];	

		$data['newsletter_user']= $this->business->get_newsletter_users_by_business($businessid);

		$data['total_newsletter']= $this->business->total_newsletter($businessid);

		//$data['count_username']=$this->business->total_business($businessid);

		$data['newsletter'] = $this->load->view("default/common/left_panel_business", $data, true); 

		$data['right_container'] = $this->load->view("business/view_news_letter_users", $data, true); 

		$this->common($data);

	}	

	/* + Sending email to the newsletter subscribers + */

	

	/*public function total_business_subscriber($businessid=false,$fromzoneid=0){

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['zone_id'] = $data['common']['zoneid'];	

		$data['total_newsletter']= $this->business->total_newsletter($businessid);

		$data['right_container'] = $this->load->view("default/common/left_panel_business", $data, true); 

		$this->common($data);

	}*/

	

	

	

	

	public function sendnewsletteruseremails(){

		$userids = empty($_REQUEST['uid']) ? 0 : $_REQUEST['uid'];

		$sub = $_REQUEST['subject'];

		$msg = str_replace("\n","<br>",$_REQUEST['message']);

		//echo $userids ;exit;

		$uid_arr=explode(',',$userids);

		//var_dump($uid_arr);exit;

		foreach($uid_arr as $uid){

			$sql_u="SELECT b.email as email FROM newsletter_approved a,users b WHERE a.user_id=b.id and a.id=".$uid;

			$query_u1 = $this->db->query($sql_u);	

			$useremail=$query_u1->result_array();

			//var_dump($useremail); exit;

			if(!empty($useremail)){

				$uemailid=$useremail[0]['email']; 

				$fromemail=$this->config->item('adminEmailId');

				$this->load->library('email');

				$this->email->clear();

				$this->email->from($fromemail);

				$this->email->subject($sub);

				$this->email->message($msg);

				$this->email->to($uemailid);

				$this->email->send();

				$to[]=$uemailid;

			}

		}

		//exit;

		$message="Email sent successfully";

		echo($this->dr->GetDR("Successfully", $message, "", "0"));	

	}

	/* - Sending email to the newsletter subscribers - */

	################################################  Business News Letter Part End #########################################################

	

	################################################  Business Interest Group Part Start ####################################################

	

	public function newinterestgroup($businessid=false,$fromzoneid=0){

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['zone_id'] = $data['common']['zoneid'];	

		$data['right_container'] = $this->load->view("business/add_interest_group", $data, true); 

		$this->common($data);

	}

	

	public function viewinterestgroup($businessid=false,$fromzoneid=0){

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['zone_id'] = $data['common']['zoneid'];	

		$data['right_container'] = $this->load->view("business/view_interest_group", $data, true); 

		$this->common($data);

	}

	

	public function viewinterestgroupvisibility($businessid=false,$fromzoneid=0){

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['zone_id'] = $data['common']['zoneid'];	

		$data['right_container'] = $this->load->view("business/interest_group_visibility", $data, true); 

		$this->common($data);

	}

	

	################################################  Business Interest Group Part End ######################################################

	

	################################################  Business Email Notice Part Start ######################################################

	

	public function createemailnotice($businessid=false,$fromzoneid=0){ 

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['zone_id'] = $data['common']['zoneid'];	

		$data['right_container'] = $this->load->view("business/create_email_notice", $data, true); 

		$this->common($data);

	}

	public function viewemailnotice($businessid=false,$fromzoneid=0){

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['zone_id'] = $data['common']['zoneid'];	

		$data['right_container'] = $this->load->view("business/view_email_notice", $data, true); 

		$this->common($data);

	}

	


	public function sendemailnotice($businessid=false,$fromzoneid=0){ 

		$data['common']=$this->common_first($businessid,$fromzoneid);

	# + Added on 09/07/14

		$data['zoneid'] = $data['common']['zoneid'];

		$data['createdby_id'] = $data['common']['businessid'];

		$data['createdby_type'] = 2;

		$data['ig_group']=$this->email_notice->active_subscribed_group_display($data['zoneid'],$data['createdby_id'],$data['createdby_type']); 

		$data['all_bus_notice']=$this->email_notice->all_notices($data['zoneid'],$data['createdby_id'],$data['createdby_type']);

	# - Added on 09/07/14	

		$data['right_container'] = $this->load->view("business/send_email_notice", $data, true); 

		$this->common($data);

	}

	public function historyemailnotice($businessid=false,$fromzoneid=0){

		$data['common']=$this->common_first($businessid,$fromzoneid);

	# + Added on 09/07/14

		$data['zoneid'] = $data['common']['zoneid'];

		$data['createdby_id'] = $data['common']['businessid'];

		$data['createdby_type'] = 2;

		$data['email_history']=$this->email_notice->view_email_notice_history($data['createdby_id'],$data['zoneid'],$data['createdby_type']);	

	# - Added on 09/07/14

		$data['right_container'] = $this->load->view("business/history_email_notice", $data, true); 

		$this->common($data);

	}

	

	function veiw_email_notice(){

		$data=array();

		$data['id']=!empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;

		$data['zoneid']=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;

		$data['businessid']=!empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : 0;

		$data['createdby_type'] = 2;

		$data['veiw_email_notice']=$this->email_notice->email_notice_history($data['id'],$data['zoneid'],$data['businessid'],$data['createdby_type']); 

		$data['right_container'] = $this->load->view("business/veiw_email_notice",$data, true);

		echo($this->dr->GetDR($data['id'],$data['veiw_email_notice'], $data['right_container'], "0"));

	}



	function delete_history(){

		$id=!empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;

		$businessid=!empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : 0;

		//$delete_history=$this->email_notice->delete_notice_history($id,$businessid);

		  $sql = "delete from email_notice_history where id='".$id."' and createdby_id='".$businessid."'";

	      $query = $this->db->query($sql); 

	      echo($this->dr->GetDR($id,"", "", "0"));

	}

	

	################################################  Business Voice Broadcast Start ######################################################

	

	public function createBroadcast($businessid=false,$fromzoneid=0){ 

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['zone_id'] = $data['common']['zoneid'];	

		$data['right_container'] = $this->load->view("business/create_broadcast", $data, true); 

		$this->common($data);

	}

	

	public function viewBroadcast($businessid=false,$fromzoneid=0){

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['zone_id'] = $data['common']['zoneid'];	

		$data['right_container'] = $this->load->view("business/view_broadcast", $data, true); 

		$this->common($data);

	}

	

	

	################################################ Business Webinar Start ################################################################

	

	public function webinar_information($businessid=false,$fromzoneid=0){ 	

		$data['common']=$this->common_first($businessid,$fromzoneid);		

		$data['zoneid'] = $data['common']['zoneid'] ;	

        $data['businessinfo'] = $this->business->get_business_by_id($businessid);  

		$data['right_container'] = $this->load->view("business/webinar_information", $data, true); 
 
		$this->common($data);

	}

	

	public function get_business_owner_id($business_id){

		$get_bus_owner_id = "SELECT business_owner_id FROM business WHERE id=".$business_id;

		$query = $this->db->query($get_bus_owner_id);

		$result = $query->result_array();

		$business_owner_id = $result[0]['business_owner_id'];

		return $business_owner_id;

	}

	

	public function save_webinar_link(){



		 

		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

		$status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : '';

		$business_id = !empty($_REQUEST['business_id']) ? $_REQUEST['business_id'] : ''	;

		$business_owner_id = $this->get_business_owner_id($business_id);

		$user_id= $this->session->userdata('user_id');

		$webinar_link=!empty($_REQUEST['webinar_link']) ? $_REQUEST['webinar_link'] : '';

		$description=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';

		$start_time=!empty($_REQUEST['ad_startdatetime']) ? $_REQUEST['ad_startdatetime'] : '';

		$end_time=!empty($_REQUEST['ad_stopdatetime']) ? $_REQUEST['ad_stopdatetime'] : '';


		$room_type=!empty($_REQUEST['room_type']) ? $_REQUEST['room_type'] : '';

		$desImage=!empty($_REQUEST['desImage']) ? $_REQUEST['desImage'] : '';

		$totalpeople=!empty($_REQUEST['totalpeople']) ? $_REQUEST['totalpeople'] : '';


		$price=!empty($_REQUEST['price']) ? $_REQUEST['price'] : '';

		$pemail=!empty($_REQUEST['pemail']) ? $_REQUEST['pemail'] : '';

		$category=!empty($_REQUEST['main_cat_selected']) ? $_REQUEST['main_cat_selected'] : '';

		$subcategory=!empty($_REQUEST['main_subcat_selected']) ? $_REQUEST['main_subcat_selected'] : '';

		$descrirecordinglinkption=!empty($_REQUEST['recordinglink']) ? $_REQUEST['recordinglink'] : '';

	
 
	    $sql1="select * from wb_webinar_user where bus_id =".$_REQUEST['business_id']." and role='business'";

	   	$query1 = $this->db->query($sql1);

		$result1 = $query1->result_array();

  
       if(count($result1) == 0 ){

			$sql="select * from business where id =".$_REQUEST['business_id'];
			$query = $this->db->query($sql);
			$result = $query->result_array();
 

			$userData=array(		 

				 'status'=> $business_email_id,

				 'role'=> 'business',

				 'username'=>$result[0]['name'], 

				 'fname' => $result[0]['contactfirstname'],

				 'email'=> $result[0]['contactemail'],

				 'lname'=>$result[0]['contactlastname'],

				 'zoneid'=> $zoneid,

				 'bus_id'=> $result[0]['id'],

							);

							

			$userData= array_filter($userData);		

			$this->db->insert('wb_webinar_user', $userData);

			$user_bus_id = $this->db->insert_id();
 
       }else{

       	$user_bus_id = $result1[0]['id'];
       }


 
 

		$sql="select id from webinar_information where created_by_userid=".$business_owner_id." AND zoneid=".$zoneid;

		$query=$this->db->query($sql);

		$result=$query->num_rows(); 

		// if($result > 0){

		// 	$message = 1;

		// } 

		// else

		// {

		// + Insert the values into the db

		$webinar=array(

			 'zoneid'=>$zoneid,

			 'link'=>$webinar_link,

			 'description'=>$description,

			 'created_by_userid'=>$user_bus_id,

			 'status'=>$status,

			 'type'=>2,

			 'start_time'=>$start_time,

			 'end_time'=>$end_time,

			 'timestamp'=>time(),

			 'room_type' => $room_type ,

			 'recording_link' => $descrirecordinglinkption ,

			 'webinarImage' => $desImage,

			 'totalpeople' => $totalpeople,

			 'price' => $price,

			 'sub_category' => $subcategory,

			 'category' => $category,

		);

		// - Insert the values int the db

		$this->db->insert('webinar_information', $webinar);

		$inserted_id = $this->db->insert_id();

		$message=2;

       	// }

			echo($this->dr->GetDR($message, "The save was successful", $var , $height = "0"));

    }

	public function webinar_details($businessid=false,$fromzoneid=0){//var_dump($fromzoneid);exit;

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['fromzoneid']=$fromzoneid;

		$business_owner_id = $this->get_business_owner_id($businessid);
 
		$data['webinar_list'] = $this->business_model->show_webinar($data['common']['zoneid'], $businessid);
		// print_r($data['webinar_list']);

		$data['right_container'] = $this->load->view("business/webinar_details1", $data, true);

		$this->common($data);

	}

	public function working_details($businessid=false,$fromzoneid=0){//var_dump($fromzoneid);exit;

		$data['common']=$this->common_first($businessid,$fromzoneid);

		$data['fromzoneid']=$fromzoneid;

		$business_owner_id = $this->get_business_owner_id($businessid);

		$data['webinar_list'] = $this->business_model->show_webinar($data['common']['zoneid'], $business_owner_id);

		$data['right_container'] = $this->load->view("business/working_details", $data, true);

		$this->common($data);

	}

	

	public function viewmorewebinar($businessid=0,$lowerlimit=0,$upperlimit=0,$zoneid=0){ 

		$data = array();

		$data['zoneid']=$zoneid; //var_dump($zoneid);exit;

		$session_zone = $this->session->userdata('usersessiondata');

		$userzoneid = $session_zone['userzoneid'];

		$business_owner_id = $this->get_business_owner_id($businessid);

		$data['webinar_list'] = $this->business_model->show_webinar($userzoneid,$businessid,$lowerlimit,$upperlimit);

		$data['countallwebinar']=count($data['webinar_list']);

		if($data['countallwebinar']<1){		

			$data['countallwebinar'] = 0;		

		}

		$lowerlimit=$lowerlimit+5;				

		$limit=$lowerlimit.','.$upperlimit;	

		$result = $this->load->view("business/more_webinar",$data, true);

		echo($this->dr->GetDR($data['countallwebinar'],$limit,$result,"0"));

	}

	

	public function edit_webinar($zoneid=false,$businessid=false,$webinar_id=false){ //var_dump($zoneid);exit;

		$data['common']=$this->common_first($businessid,$zoneid); 

		$data['getall_webinar']=$this->business_model->getall_webinar_info($zoneid,$webinar_id);

		$data['zoneid']=$zoneid;

		$data['right_container'] = $this->load->view("business/edit_webinar", $data, true);



		$this->common($data);

	}

	

	public function update_webinar_link(){


	 

		$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';	

		$status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : '';

		$webinar_id = !empty($_REQUEST['webinar_id']) ? $_REQUEST['webinar_id'] : '';

		$webinar_link=!empty($_REQUEST['webinar_link']) ? $_REQUEST['webinar_link'] : '';

		$description=!empty($_REQUEST['description']) ? $_REQUEST['description'] : '';

		$start_time=!empty($_REQUEST['ad_startdatetime']) ? $_REQUEST['ad_startdatetime'] : '';

		$end_time=!empty($_REQUEST['ad_stopdatetime']) ? $_REQUEST['ad_stopdatetime'] : '';

		$category=!empty($_REQUEST['main_cat_selected']) ? $_REQUEST['main_cat_selected'] : '';

		$subcategory=!empty($_REQUEST['main_subcat_selected']) ? $_REQUEST['main_subcat_selected'] : '';

		$descrirecordinglinkption=!empty($_REQUEST['recordinglink']) ? $_REQUEST['recordinglink'] : '';




		$room_type=!empty($_REQUEST['room_type']) ? $_REQUEST['room_type'] : '';

		$desImage=!empty($_REQUEST['desImage']) ? $_REQUEST['desImage'] : '';

		$totalpeople=!empty($_REQUEST['totalpeople']) ? $_REQUEST['totalpeople'] : '';

		$descrirecordinglinkption=!empty($_REQUEST['recordinglink']) ? $_REQUEST['recordinglink'] : '';

		$price=!empty($_REQUEST['price']) ? $_REQUEST['price'] : '';

		$pemail=!empty($_REQUEST['pemail']) ? $_REQUEST['pemail'] : '';


		$current_time = time();

		$sql_update= "UPDATE webinar_information SET link='".$webinar_link."',description ='".$description."',status =".$status.",start_time='".$start_time."',end_time='".$end_time."',timestamp=".$current_time."  , room_type='".$room_type."' ,webinarImage='".$desImage." ',totalpeople='".$totalpeople."' ,recording_link='".$descrirecordinglinkption." ' ,   price = '".$price."' , sub_category = '".$subcategory."', category  = '".$category."'   WHERE zoneid=".$zoneid." AND id=".$webinar_id;

		$query = $this->db->query($sql_update);

		echo($this->dr->GetDR("","success","","0"));		

	}

	

	public function delete_webinar(){

		$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

		$zoneid = $_REQUEST['zoneid'];

		$sql_delete = "DELETE FROM `webinar_information` WHERE zoneid=".$zoneid." AND id=".$id;

		$query = $this->db->query($sql_delete);

		echo($this->dr->GetDR($id,"", "success", "0"));

    }

	

	             /////////////////////  UPLOAD  ADVERTISEMENT  IMAGE  ///////////////////////

	

	function save_image($business_id){ //var_dump($business_id);exit;//alert(1);exit;//

		//$uploadedImage=$_FILES['imgfile']['name']; //echo $uploadedImage; 

		$uploadedImage = $this->input->post('imagename'); //echo $uploadedImage; exit;

		//$var = explode('.',$uploadedImage);

		//$ext = pathinfo($this->input->post('imagename'), PATHINFO_EXTENSION);

		//$imagename=time().'.'.$ext;

		//$rand = mt_rand( 100, 999 );

		$target = "uploads/ckeditor/$business_id/";

		

		if(is_dir($target)==false){

			mkdir($target,0777);

		}

		$outPutImage=$imagename;

		//$target=$target.basename($outPutImage);  

		$target=$target.basename($uploadedImage);  

		$image_src='<image src='. base_url($target).' height=500px width=500px >';

		$pic=($this->input->post('imagename'));

		

		$sourceUrl =  base_url()."image_gallery/app/web/upload/source/".$uploadedImage;

		if(copy($sourceUrl, $target))

		{	//echo "111";exit;

			$picarray=array(

			'clientImage'=>$pic,

			'uploadedImage'=>$uploadedImage,

			'business_id'=>$business_id

			);

			echo json_encode($picarray);

		}else{ //echo "222";exit;

			echo json_encode(0);

		}

		/*if(move_uploaded_file($this->input->post('imagename'), $target))

		{	echo "111";exit;

			$picarray=array(

			'clientImage'=>$pic,

			'uploadedImage'=>$outPutImage,

			'business_id'=>$business_id

			);

			echo json_encode($picarray);

		}else{ echo "222";exit;

			echo json_encode(0);

		}*/

	}



	public function do_upload_images($business_id) {

        $upload_path_url = "uploads/ckeditor/$business_id/";



        $config['upload_path'] = FCPATH . 'uploads/ckeditor/'.$business_id.'/';

        $config['allowed_types'] = 'jpg|jpeg|png|gif';

        $config['max_size'] = '30000';

		$upload_new_path = $_SERVER['DOCUMENT_ROOT'] ."/uploads/ckeditor/'.$business_id.'/normal_image/";

		if(!file_exists($upload_new_path)){

			mkdir($upload_new_path,0777,true);

		}

		

        $this->load->library('upload', $config);



        if (!$this->upload->do_upload()) {

            //$error = array('error' => $this->upload->display_errors());

            //$this->load->view('upload', $error);



            //Load the list of existing files in the upload directory

            $existingFiles = get_dir_file_info($config['upload_path']);

            $foundFiles = array();

            $f=0;

            foreach ($existingFiles as $fileName => $info) {

              if($fileName!='thumbs'){//Skip over thumbs directory

                //set the data for the json array   

                $foundFiles[$f]['name'] = $fileName;

                $foundFiles[$f]['size'] = $info['size'];

                $foundFiles[$f]['url'] = $upload_path_url . $fileName;

                $foundFiles[$f]['thumbnailUrl'] = $upload_path_url . 'thumbs/' . $fileName;

                $foundFiles[$f]['deleteUrl'] = base_url() . 'upload/deleteImage/' . $fileName;

                $foundFiles[$f]['deleteType'] = 'DELETE';

                $foundFiles[$f]['error'] = null;



                $f++;

              }

            }

            echo json_encode(array('files' => $foundFiles));

        } else {

            $data = $this->upload->data();

            $config = array();

            $config['image_library'] = 'gd2';

            $config['source_image'] = $data['full_path'];

            $config['create_thumb'] = TRUE;

            $config['new_image'] = $data['file_path'] . 'thumbs/';

            $config['maintain_ratio'] = TRUE;

            $config['thumb_marker'] = '';

            $config['width'] = 75;

            $config['height'] = 50;

            $this->load->library('image_lib', $config);

            $this->image_lib->resize();





            //set the data for the json array

            $info = new StdClass;

            $info->name = $data['file_name'];

            $info->size = $data['file_size'] * 1024;

            $info->type = $data['file_type'];

            $info->url = $upload_path_url . $data['file_name'];

            // I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$data['file_name']

            $info->thumbnailUrl = $upload_path_url . 'thumbs/' . $data['file_name'];

            $info->deleteUrl = base_url() . 'upload/deleteImage/' . $data['file_name'];

            $info->deleteType = 'DELETE';

            $info->error = null;



            $files[] = $info;

            //this is why we put this in the constants to pass only json data

            echo json_encode(array("files" => $files));

        }

    }



	function save_image_btn_click($business_id){ //var_dump($business_id);exit;//alert(1);exit;//

	

		$upload_path_url = "uploads/ckeditor/$business_id/";

		$upload_new_path = $_SERVER['DOCUMENT_ROOT'] ."/uploads/ckeditor/$business_id/normal_image/";

		$config['upload_path'] = FCPATH . $upload_path_url;

		$config['allowed_types'] = 'jpg|jpeg|png|gif';

		$config['max_size'] = '300000';

		

		if(!file_exists($upload_new_path)){

			mkdir($upload_new_path,0777,true);

		}

		//echo "1";

		//copy($source,$destination);

		 

		//echo $destination; 	

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('imgfile','banner_image')) {	

			echo json_encode(0);    	

		}else {

			$resize_target = "uploads/ckeditor/$business_id/";

			$data = $this->upload->data();			

			$width = '587';

			$height = '587';

			

			//echo $resize_target;

			if(is_dir($resize_target)==false){

				mkdir($resize_target,0777);

			}

			//echo "2";

			$this->resize($resize_target,$data,$width,$height);

			//echo "3";

			//print_r($resize_config); exit;

			$outPutImage = $data['file_name'];

			$target=$resize_target.basename($outPutImage);

			//$result=$this->business_type->update_business_logo($business_id,$outPutImage);

			

			//$delete_prev_folder = $this->upload->rrmdir($upload_new_path);

			$picarray=array(

				'clientImage'=>'',

				'uploadedImage'=>$outPutImage,

				'business_id'=>$business_id

			);

			echo json_encode($picarray);

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

		             /////////////////////  UPLOAD  ADDITIONAL  IMAGE  ///////////////////////



	function multi_image_upload($business_id,$adid){ 

		$uploadedImage=$this->input->post('imagename'); 

		foreach($uploadedImage as $key){

		$ext = pathinfo($key, PATHINFO_EXTENSION);

		$imagename=time().rand().'.'.$ext;

		$rand = mt_rand( 100, 999 );

		$target = "uploads/businessphoto/$business_id/";

		

		if(is_dir($target)==false){

			mkdir($target,0777);

		}

		$outPutImage=$imagename;

		$target=$target.basename($outPutImage);

		$image_src='<image src='. base_url($target).' height=500px width=500px >';

		$pic=$key; 

		$sourceUrl =  base_url()."image_gallery/app/web/upload/source/".$key;

		

		//echo $target; exit; 

			

		if(copy($sourceUrl, $target))

		{ 	

			$picarray[]=array(

			'clientImage'=>$pic,

			'uploadedImage'=>$outPutImage,

			'business_id'=>$business_id

			);			

			

		}else{ 

			// echo json_encode("0");

		}

		/*if(!empty($adid)){ 

	

		$data['save_banner']=$this->business->save_bus_photo_new($imagename,$business_id,$adid);

	    }*/

	   }

			echo json_encode($picarray);

	}

	

	function multi_image_upload_on_click($business_id,$adid){ 

		$uploadedImage=$_FILES['files']['name']; 

		foreach($uploadedImage as $key){

		$ext = pathinfo($key, PATHINFO_EXTENSION);

		$imagename=time().rand().'.'.$ext;

		$rand = mt_rand( 100, 999 );

		$target = "uploads/businessphoto/$business_id/";

		

		if(is_dir($target)==false){

			mkdir($target,0777);

		}

		$outPutImage=$imagename;

		$target=$target.basename($outPutImage);

		$image_src='<image src='. base_url($target).' height=500px width=500px >';

		$pic=$key; 

		$tmp_name=$_FILES['files']['tmp_name']; 

	

		if(move_uploaded_file($tmp_name[0], $target))

		{ 

			$picarray=array(

			'clientImage'=>$pic,

			'uploadedImage'=>$outPutImage,

			'business_id'=>$business_id

			);

			echo json_encode($picarray);

		}else{

			echo json_encode(0);

		}

		if(!empty($adid)){ 

	

		$data['save_banner']=$this->business->save_bus_photo_new($imagename,$business_id,$adid);

	    }

	   }

	}

		             /////////////////////  DELETE  ADVERTISEMENT  IMAGE  ///////////////////////



	 function delete_front_image($image_name,$ad_id,$business_id){ //var_dump($_REQUEST['business_id']);exit;

		$data=array();

		$image_name=!empty($_REQUEST['uploadedInput']) ? $_REQUEST['uploadedInput'] : '';

		$ad_id=!empty($_REQUEST['ad_id']) ? $_REQUEST['ad_id'] : '';

		$business_id=!empty($_REQUEST['business_id']) ? $_REQUEST['business_id'] : '';

		$data['banner_view']=$this->business_model->delete_front_photo($image_name,$ad_id,$business_id); 

		echo($this->dr->GetDR($data['banner_view'],"", "", "0"));

		

	}

	

	 ///////////////////////////  UNLINK  ADVERTISEMENT  IMAGE  ///////////////////////////

	 

	public function unlink_adsimage(){

		$img_name = isset($_REQUEST['img_name']) ? $_REQUEST['img_name'] : '' ;

		$businessid = isset($_REQUEST['businessid']) ? $_REQUEST['businessid'] : '' ;

		

		$file = 'uploads/ckeditor/'.$businessid.'/'.$img_name; 

		if (!unlink($file))

		  {

			$title = 0 ;

		  }

		else

		  {

			$title = 1 ;

		  }

		echo($this->dr->GetDR($title, $img_name, "", "0"));

	}

	

		 ///////////////////////////  UNLINK  ADDITIONAL  IMAGE  ///////////////////////////

	/*public function jot_form_ad_payment_code($business_id,$zone_id,$ad_id,$user_id){

		$data['business_id'] = $business_id;

		$data['zone_id'] = $zone_id;

		$data['ad_id'] = $ad_id;

		//$_SESSION['ad_id'] = $ad_id;

		$this->session->set_userdata('ad_id',$ad_id);

		$data['users_id'] = $user_id;

		$data['form_container'] = $this->business_model->get_jotform_code($business_id,$zone_id);

		$this->load->view('business/organization_jot_form',$data);

	}*/

	/**

	  * Jotform secure payment

	  * @param getdata

	  * return jotformview

	*/

	public function secureJotForm($businessId,$zoneId,$adId,$source,$user_id){

		if($source == "securePayment"){

			$paymentModuleId = 7;

			$data['formCode'] = $this->zone_model->get_jotform_code($businessId,$paymentModuleId);

			$data['businessDetails'] = $this->business_model->business_details($businessId);

			if($user_id =='' || empty($user_id)){

				$user_id = 0;

			}

			$data['user_details'] = $this->user->get_user_details($user_id);

			$data['ad_id'] = $adId;

			$this->load->view('business/businessAdditionalServiceJotform',$data);

		}



	}

	public function jot_form_ad_payment_code(){

		$data['business_id'] = $_POST['business_id'];

		$data['zone_id'] = $_POST['zone_id'];

		$data['ad_id'] = $_POST['ad_id'];

		$data['users_id'] = $_POST['user_id'];

		$data['amount'] = $_POST['amount'];

		$data['form_container'] = $this->business_model->get_jotform_code($data['business_id'],$data['zone_id']);

		$data['form_conatiner'] = $this->load->view('business/organization_jot_form',$data);

		//$data['response_data'] = "<iframe>".$data['form_conatiner']."</iframe>";

		echo $data['form_conatiner'];





	}

	/*

	 * secure payment for business additoonal service by residance

	 * @param $_post data;



	*/

	public function additionalservicePaymentBusiness(){

		$paymentStatus = $this->business_model->insertPaymentData($_POST,7);

		$this->load->view('business/additionalServiceJotformThanku',array('postData'=>$_POST,'paymentStatus'=>$paymentStatus));

	}

	public function customerthanku($thankyouData){

		//var_dump($thankyouData);

	    $zone_id = $thankyouData['zone_id'];

	    $page_url= $thankyouData['pageurl'];

	    $ad_id = $thankyouData['ad_id'];

	    $business_id_array = explode('?', $page_url);

	    $business_id_string_array = explode('=', $business_id_array[1]);

	    $business_id = $business_id_string_array[1];

	    $users_id = $thankyouData['users_id'];

	    $result = $this->business_model->residence_payment_data($zone_id,$ad_id,$business_id,$users_id,$_POST);

	    echo $result;

	}



	public function unlinkimage(){

		$img_name = isset($_REQUEST['img_name']) ? $_REQUEST['img_name'] : '' ;

		$businessid = isset($_REQUEST['businessid']) ? $_REQUEST['businessid'] : '' ;

		

		$file = 'uploads/businessphoto/'.$businessid.'/'.$img_name; 

		if (!unlink($file))

		  {

			$title = 0 ;

		  }

		else

		  {

			$title = 1 ;

		  }

		echo($this->dr->GetDR($title, $img_name, "", "0"));

	}
	
	public function setpagecookievalue(){ 

		$business_value=!empty($_REQUEST['business_value']) ? $_REQUEST['business_value'] : '';

		$this->session->set_userdata('business_value',$business_value);

		echo($this->dr->GetDR($business_value, "", "", "0"));

	}

	///////////////////////////////  redirect another page for peekaboo /////////////////////////////////////////

	

	    function other_redirect_peekaboo($businessid,$fromzoneid){//var_dump($fromzoneid);exit;

		  $data=array();

		  $data['common']=$this->common_first($businessid,$fromzoneid); //echo "<pre>";var_dump($data['common']);exit; //var_dump(  $data['common']['zone']['0']['zoneid']);exit;

		  //$zoneid =  $data['common']['zone']['0']['zoneid']; var_dump($zoneid);exit;

		 // $sql="select d.group_id,e.username  from business as a , ads as  b, sales_zone as c, users_groups d, users as e, ads_setting_preferences f  where  c.id=f.settingszoneid and  d.user_id=a.business_owner_id and e.id=a.business_owner_id and a.id='$businessid' group by e.username"; //echo $sql;exit;

		  

		   $sql="select d.group_id,e.username from business as a , ads as b, sales_zone as c, users_groups d, users as e where d.user_id=a.business_owner_id and e.id=a.business_owner_id and a.id='$businessid' group by e.username"; 

		  $query = $this->db->query($sql);

		  $result = $query->result_array();

		  $data['peekaboo_other_page'] = $result; 

		  //$data['business_peekaboo'] = $this->ad->tamaldutta($businessid,$zoneid);

		  $data['right_container'] = $this->load->view("business/peekaboo_redirect", $data, true);

	      $this->common($data);		

	

			

		}

		

		// FROM LEFT PANEL DASH BOARD

		

		//////////////////////////  ++++++++++ Start Left business panel peekaboo banner section (Create Auction button)     +++++++++++   //////////////////////////////

		

		

		function peekaboo_access(){ 

		   $data = array();

		   $businessid =  !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : '';

		   $zoneid = !empty($_REQUEST['zoneid']) ?  $_REQUEST['zoneid'] : ''; 

		   $approval = !empty($_REQUEST['approval']) ? $_REQUEST['approval'] : '';

		   $sql="select d.group_id,e.username,a.name from business as a , ads as b, sales_zone as c, users_groups d, users as e where d.user_id=a.business_owner_id and e.id=a.business_owner_id and c.id='$zoneid' and a.id='$businessid' group by e.username"; 

		  $query = $this->db->query($sql);

		  $result = $query->result_array();

		  $data['peekaboo_other_page'] = $result; 

		  $group_id = $result['0']['group_id'];

		  $username =$result['0']['username'];

		  $business_name = $result['0']['name'];

		  

		  		$peekaboo_username_sql = "Select a.username from users a,tbl_member b where a.username=b.user_name and b.user_name='".$username."'";

				$peekaboo_username_query = $this->db->query($peekaboo_username_sql);

				$peekaboo_username_result = $peekaboo_username_query->result_array();

				$peekaboo_username = $peekaboo_username_result['0']['username'];

				// Checking savingssites business owner doesn't exist the peekaboo account with same their business username and passrord. Those business will create peekaboo account with same same savingssites username and password.   

				if($peekaboo_username==''){

				

				      $ss_user_sql = "Select * from users where username='".$username."'";

					  $ss_user_query = $this->db->query($ss_user_sql);

					  $ss_user_result = $ss_user_query->result_array(); 

					  

					  $peekaboo_username_exists = $ss_user_result['0']['username'];

					  $peekaboo_password_exists = $ss_user_result['0']['password'];

					  $peekaboo_email_exists = $ss_user_result['0']['email'];

					  $peekaboo_first_name_exists = $ss_user_result['0']['first_name'];

					  $peekaboo_last_name_exists = $ss_user_result['0']['last_name'];

					  $peekaboo_phone_exists = $ss_user_result['0']['phone'];

					  $peekaboo_Address_exists = $ss_user_result['0']['Address'];

					  $peekaboo_City_exists = $ss_user_result['0']['City'];

					  $peekaboo_company_exists = $ss_user_result['0']['company'];

					  $peekaboo_phone_exists = $ss_user_result['0']['phone'];

					  $peekaboo_Zip_exists = $ss_user_result['0']['Zip'];

					  $peekaboo_State_Code_exists = $ss_user_result['0']['State_Code'];

					  

						  if($approval!=3){

								  $data_peekaboo=array(

									 'fName'=>$peekaboo_first_name_exists,

									 'lName'=>$peekaboo_last_name_exists,

									 'email'=>$peekaboo_email_exists,

									 'address1'=>$peekaboo_Address_exists,

									 'company_name'=>$business_name,

									 'city_name'=>$peekaboo_City_exists,

									 'state_name'=>$peekaboo_State_Code_exists,

									 'post_code'=>$peekaboo_Zip_exists,

									 'phone'=>$peekaboo_phone_exists,

									 'user_name'=>$peekaboo_username_exists,

									 'password'=>sha1($peekaboo_password_exists),

									 'activated'=>'yes',

									 'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),

									 'member_type'=>2,

									 'zone_id'=>$zoneid

								);

						  }else{

								  $data_peekaboo=array(

										 'fName'=>$peekaboo_first_name_exists,

										 'lName'=>$peekaboo_last_name_exists,

										 'email'=>$peekaboo_email_exists,

										 'address1'=>$peekaboo_Address_exists,

										 'company_name'=>$business_name,

										 'city_name'=>$peekaboo_City_exists,

										 'state_name'=>$peekaboo_State_Code_exists,

										 'post_code'=>$peekaboo_Zip_exists,

										 'phone'=>$peekaboo_phone_exists,

										 'user_name'=>$peekaboo_username_exists,

										 'password'=>sha1('changepasword'),

										 'activated'=>'yes',

										 'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),

										 'member_type'=>2,

										 'zone_id'=>$zoneid

									);

						  }

						$data_peekaboo_insert= array_filter($data_peekaboo);

						$this->db->insert('tbl_member', $data_peekaboo_insert);

						$peekaboo_id = $this->db->insert_id();	

				}

		  

		 

		  

		  $url = "http://peekabooauctions.com/ss_userlogin_from_peekaboo.php?peekaboo_username=".$username."&group_id=".$group_id."&zoneid=".$zoneid; //var_dump($url);exit;

		  

		  echo($this->dr->GetDR($username, $group_id, $zoneid, "0"));



		}

	//////////////////////////  ++++++++++ End Left business panel peekaboo banner section (Create Auction button)     +++++++++++   //////////////////////////////

	

	///////////////////////////////  redirect another page for peekaboo /////////////////////////////////////////

	

	function ad_status_change(){

			$data = array();

			$businessid =  !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : '';

			$adid =  !empty($_REQUEST['adid']) ? $_REQUEST['adid'] : '';

			$zoneid =  !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

			$status =  ($_REQUEST['status'] != '') ? $_REQUEST['status'] : '-1';//var_dump($status);exit;

			$response = 0 ; 

			if($adid != '' && $zoneid != ''){

				//////////////////////////////////////////////////

				$other_sql = "select a.id,b.subcatid,a.business_id from ads a, ad_category_subcategory b where a.business_id='$businessid' and b.adid= a.id group by a.id";

				$query1 = $this->db->query($other_sql) ;

				$other_adid_update = $query1->result_array();

				$particullar_subcat_id = "select b.subcatid from ads a, ad_category_subcategory b where a.business_id='$businessid' and b.adid='$adid' group by b.subcatid";

				$query2 = $this->db->query($particullar_subcat_id) ;

				$particullar_subcat_id_in_onead = $query2->result_array();// var_dump($particullar_subcat_id_in_onead);

				foreach ($other_adid_update as $a){

				 foreach($particullar_subcat_id_in_onead as $b){

					 $particullar_subcat = $b['subcatid'];

				     $all_adid = $a['id'];

				     $all_subcatid = $a['subcatid'];

				     $bus_id = $a['business_id'];

				     $particullar_adid_sql = "select a.adid from ad_category_subcategory a,ads b where a.subcatid='$particullar_subcat'  and a.adid=b.id and b.business_id='$businessid' group by adid"; 

					 $particullar_adid_result = $this->db->query($particullar_adid_sql);

					 $particullar_adid1 = $particullar_adid_result->result_array();				

				//////////////////////////////////////////////////

				//if($status == 1){

				if($particullar_subcat == $all_subcatid && $status == 1 )	{

				$sql = "UPDATE ad_to_zone SET approval='".$status."' WHERE adid='".$adid."' AND zoneid='".$zoneid."'" ;

				$query = $this->db->query($sql) ;

				if($query){

					$response++;

				  }

				if($bus_id == $businessid){



						$approval_update = "UPDATE ad_to_zone a, ads b,ad_category_subcategory  c SET approval='-1' WHERE a.zoneid='".$zoneid."' and a.adid=b.id and b.business_id='$businessid' and  a.adid NOT IN ($adid) and c.subcatid IN ($particullar_subcat) and a.adid=c.adid and c.subcatid='".$all_subcatid."' ";

						

						$approval_update_query = $this->db->query($approval_update);

				}



			}else  if($particullar_subcat == $all_subcatid && $status == -1 ){

				$sql = "UPDATE ad_to_zone SET approval='".$status."' WHERE adid='".$adid."' AND zoneid='".$zoneid."'" ;

				$query = $this->db->query($sql) ;

				if($query){

					$response++;

				  }

		/*		  if($bus_id == $businessid){

						

		$unique_active_subcat_id_sql = "select a.adid from ad_to_zone a, ad_category_subcategory b where a.adid=b.adid and b.subcatid='$all_subcatid' and  a.adid NOT IN ($adid) order by a.adid DESC limit 1 ";

		$query3 = $this->db->query($unique_active_subcat_id_sql);

		

		$unique_active_subcat_id = $query3->result_array(); 

		$adid_active =	$unique_active_subcat_id['0']['adid'];		

						

						

						$approval_update = "UPDATE ad_to_zone a, ads b,ad_category_subcategory  c SET approval='1' WHERE a.zoneid='".$zoneid."' and a.adid=b.id and b.business_id='$businessid' and a.adid NOT IN ($adid) and c.subcatid IN ($particullar_subcat) and a.adid=c.adid and a.adid='".$adid_active."' ";

						$approval_update_query = $this->db->query($approval_update);

				}*/

			}

		   }

	  }//exit;/////////////////

		 echo($this->dr->GetDR($adid, $status, "", "0"));

		}

		 

	}	

	

	//////// Make all inactive ads from businessdashboard //////////

	

	    function all_inactive_ads(){ 

		    $data = array();

			$businessid =  !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : '';

			$zoneid =  !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

			

			$data['all_inactive_ads']=$this->business_model->all_inactive_ads($businessid,$zoneid);

			return true;

		   }

		   

	# + Peekaboo Access Link Redirect to another link 

	

		public function peekaboo_access_link($businessid=false,$fromzoneid=0){

			$data['common']=$this->common_first($businessid,$fromzoneid);		

			$data['zoneid'] = $data['common']['zoneid'] ;	

			$data['right_container'] = $this->load->view("business/peekaboo_access_link", $data, true); 

			$this->common($data);

			

		}

		public function business_jot_form_view($businessid=false,$fromzoneid=0){

			$data['common']=$this->common_first($businessid,$fromzoneid);		

			$data['zoneid'] = $data['common']['zoneid'] ;

			$data['business_id'] = $data['common']['businessid'];

			$data['business_view_jotform'] = $this->business_model->view_business_jotform($data['business_id'],$data['zoneid']);

			$data['right_container'] = $this->load->view("business/business_payment_view", $data, true); 

			$this->common($data);



		}

		public function business_payment_listing($businessid=false,$fromzoneid=0){

			$data['common']=$this->common_first($businessid,$fromzoneid);		

			$data['zoneid'] = (int)$data['common']['zoneid'];

			$data['business_id'] = (int)$data['common']['businessid'];

			$data['details_payment_list'] = $this->business_model->get_all_payment_details($data['business_id']);

			$data['right_container'] = $this->load->view("business/business_payment_list", $data, true); 

			$this->common($data);



		}

		public function business_pboo_credit_transfer($businessid=false,$fromzoneid=0){

			$data['common'] = $this->common_first($businessid,$fromzoneid);

			$data['zoneid'] = $data['common']['zoneid'];

			$data['business_id'] = (int)$data['common']['businessid'];

			$data['right_container'] = $this->load->view("business/business_pboo_credit_transfer",$data,true);

			$this->common($data);

		}

		public function business_certificate_beneficary_spreadsheet($businessid=false,$fromzoneid=0){

			$data['common'] = $this->common_first($businessid,$fromzoneid);

			$data['zoneid'] = $data['common']['zoneid'];

			$data['business_id'] = (int)$data['common']['businessid'];

			$data['right_container'] = $this->load->view("business/business_certificate_spreadsheet",$data,true);

			$this->common($data);

		}

		

		public function save_peekaboo_link(){

			$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

			$business_id = !empty($_REQUEST['business_id']) ? $_REQUEST['business_id'] : ''	;

			$business_owner_id = $this->get_business_owner_id($business_id);

			$user_id= $this->session->userdata('user_id');

			$peekaboo_link=!empty($_REQUEST['peekaboo_link']) ? $_REQUEST['peekaboo_link'] : '';

		

			$sql="select username from users where id=".$business_owner_id;

			$query=$this->db->query($sql);

			$result = $query->result_array(); 

			$username = $result[0]['username'];

				if($username != ''){

					

					$this->db->select('peekaboo_link') ;

					$this->db->from('tbl_member') ;

					$this->db->where_not_in('user_name', $username);

					$this->db->where('peekaboo_link', $peekaboo_link);

					$result1 = $this->db->get() ;

					$username_exits_rows=$result1->num_rows(); 

					//var_dump($username_exits_rows);exit;

					

						if($username_exits_rows > 0 ) {

							$message = 1;

						} else {

							$this->db->from('tbl_member');

							$this->db->where('user_name', $username);

							$is_updated	= $this->db->update('tbl_member', array('peekaboo_link'=>$peekaboo_link));

							$message = 2;

						}

				}

			echo($this->dr->GetDR($message, "The save was successful", $var , $height = "0"));

    }

		

		

		

		

		

		

	# - Peekaboo Access Link Redirect to another link 	

			   

		

	##############################  ++++ Peekaboo Users Free Email Credit ++++ #########################################	

	

	    public function emailcreditaccount($businessid=false,$fromzoneid=0){

				$data['common']=$this->common_first($businessid,$fromzoneid);

			# + Added on 27/09/16

				$data['zoneid'] = $data['common']['zoneid'];

				$data['businessid'] = $data['common']['businessid']; //var_dump($data['createdby_id']);exit;			

			# + Fetch data resident dropdown info

				$data['email_credit_package'] = $this->email_notice->email_credit_package($businessid) ;//echo "<pre>"; var_dump($data['email_credit_package']);exit;

			# - Fetch data resident dropdown info	

			# - Added on 27/09/16

				$data['right_container'] = $this->load->view("business/emailcredit_account", $data, true); 

				$this->common($data);

		}

		

		public function purchasecredit_business(){ 

			$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

			$businessid = !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : '';

			$email_credit_package_id = !empty($_REQUEST['email_credit_package_id']) ? $_REQUEST['email_credit_package_id'] : '';

			$packageval = !empty($_REQUEST['packageval']) ? $_REQUEST['packageval'] : '';

			$data['get_userid'] = $this->email_notice->get_userid($businessid) ;

			$data['purchasecredit'] = $this->email_notice->email_credit_purchase($zoneid,$businessid,$email_credit_package_id,$data['get_userid'],$packageval) ;

			echo($this->dr->GetDR("","", $data['purchasecredit'], "0"));	

		}

		

		

		public function bulkemailresident($businessid=false,$fromzoneid=0){

			$data['common']=$this->common_first($businessid,$fromzoneid);

		# + Added on 27/09/16

			$data['zoneid'] = $data['common']['zoneid'];

			$data['createdby_id'] = $data['common']['businessid']; //var_dump($data['createdby_id']);exit;			

		# + Fetch data resident dropdown info

		 	$data['email_offers_criteria'] = $this->email_notice->email_offers_criteria() ;//echo "<pre>"; var_dump($data['email_ageoffers_criteria']);exit;

		# - Fetch data resident dropdown info	

		# - Added on 27/09/16

			$data['right_container'] = $this->load->view("business/bulk_email_resident", $data, true); 

			$this->common($data);

			

		}

		/** 

		  @description method to view snap notification page

		  @param $businessId and $zoneId

		  @return array of snapnotification



		*/

		  public function snapemailnotification($businessId = false,$fromzoneId = 0) {

		  	$data['common']                = $this->common_first($businessId,$fromzoneId);

		  	$data['zoneId']                = $data['common']['zoneid'];

		  	$data['businessId']            = $data['common']['businessid'];

		  	$data['totalSnapCriteria']     = $this->snap_email->fetchSnapCriteria();

		  	$data['right_container']       = $this->load->view("business/snap_email_notification",$data,true);

		  	$this->common($data);

		  }

		  /**

		  	* @description function to fetch data for frontend 

		  	* @return json_encode data 

		  */

		  function getSnapCriteriaData() {

		  	$result = $this->snap_email->fetchSnapCriteria();

		  	echo json_encode($result);

		  }

		  /**

		  	* @description function to fetch data for businessdashboard

		  	* @param accept $businessId,$zoneId,$snapWeekDays,$snapTime,$minPercenage as post method

		  	* @return $dataArray

		  */

		  	public function userSnapData(){

		  		$businessId         = $_REQUEST['businessid'] ? $_REQUEST['businessid'] : 0;

		  		$zoneId             = $_REQUEST['zoneid'] ? $_REQUEST['zoneid'] : 0;

		  		$snapWeekDays       = $_REQUEST['snapWeekDays'] ? $_REQUEST['snapWeekDays'] : 0;

		  		$snapTime           = $_REQUEST['snapTime'] ? $_REQUEST['snapTime'] : 0;

		  		$minPercentage      = $_REQUEST['minPercentage'] ? $_REQUEST['minPercentage'] : 0;

		  		$data['lowerLimit'] = $_REQUEST['lowerLimit'] ? $_REQUEST['lowerLimit'] : 0;

		  		$data['upperLimit'] = $_REQUEST['upperLimit'] ? $_REQUEST['upperLimit'] : 10;

		  		$limit = $data['lowerLimit'].','.$data['upperLimit'];

		  		// snap_model to fetch data

		  		$data['businessId']     = $businessId;

		  		$data['zoneId']         = $zoneId;

		  		$data['snapResult']     = $this->snap_email->getSeachSnapData($businessId,$zoneId,$snapWeekDays,$snapTime,$minPercentage,$data['lowerLimit'],$data['upperLimit']);

		  		$data['lowerLimit']     = $data['upperLimit'];

		  		$data['upperLimit']     = ($data['upperLimit'] + 10);

		  		$data['snapWeekDays']   = $this->snap_email->getSnapWeekDays();

		  		$data['snapTime']       = $this->snap_email->getSnapStartTime();

		  		$data['snapPercentage'] = $this->snap_email->getPercentageCriteria();

		  		$criteriaMatchingCount = count($data['snapResult']);

                $result = $this->load->view('business/subpage/user_snap_email',$data,true);

                echo($this->dr->GetDR($criteriaMatchingCount,$limit,$result,"0"));

		  		//echo json_encode($data['snapResult']);



		  	}

		  	/**

		  	  * @description method for filtering data

		  	  * @param $businessId,$zoneId....

		  	  * @return table tbody content

		  	*/

		  	public function userSnapFilterData(){

		  		$businessId     = $_REQUEST['businessId'] ? $_REQUEST['businessId'] : 0;

		  		$zoneId         = $_REQUEST['zoneId'] ? $_REQUEST['zoneId'] : 0;

		  		$lowerLimit     = $_REQUEST['lowerLimit'] ? $_REQUEST['lowerLimit'] : 0;

		  		$upperLimit     = $_REQUEST['upperLimit'] ? $_REQUEST['upperLimit'] : 10;

		  		$nextUpperLimit = ($upperLimit + 10);

		  		$limit          = $upperLimit.','.$nextUpperLimit;

		  	

		  		$snapWeekDays   = $_REQUEST['selectedWeekdays'] ? $_REQUEST['selectedWeekdays'] : 0;

		  		$snapTime       = $_REQUEST['selectedSnapTime'] ? $_REQUEST['selectedSnapTime'] : 0;

		  		$snapPercentage = $_REQUEST['percentageCriteriariteria'] ? $_REQUEST['percentageCriteriariteria'] : 0;



		  		$data['snapResult'] = $this->snap_email->getSeachSnapData($businessId,$zoneId,$snapWeekDays,$snapTime,$snapPercentage,$lowerLimit,$upperLimit);

		  		$data['snapWeekDays']   = $this->snap_email->getSnapWeekDays();

		  		$data['snapTime']       = $this->snap_email->getSnapStartTime();

		  		$data['snapPercentage'] = $this->snap_email->getPercentageCriteria();

		  		$resultCount           = count($data['snapResult']);

		  		$filterData             = $this->load->view('business/subpage/user_filter_snap_email',$data,true);

		  		echo($this->dr->GetDR($resultCount,$limit,$filterData,"0"));

		  	}

		  	/**

		  	  * @description method to create csv file and download csv file

		  	  * @param $snamWeekdaysId,$snapTimeId,$snapPercentageId,$businessId,$zoneId

		  	  * @return downloadable  csv formatted file

		  	*/

		  	public function downloadSnapCsvFile($serachWeekDays,$serachTimeId,$searchPercentage,$businessId,$zoneId) {

		  		$data['snapResult']     = $this->snap_email->getSeachSnapData($businessId,$zoneId,$serachWeekDays,$serachTimeId,$searchPercentage,0,0);



		  		$data['snapWeekdays']   = $this->snap_email->getSnapWeekDays();

		  		$data['snapTime']       = $this->snap_email->getSnapStartTime();

		  		$data['snapPercentage'] = $this->snap_email->getPercentageCriteria();

		  		$this->excel->setActiveSheetIndex(0);

				$this->excel->getActiveSheet()->setTitle('Snap_user_list');

				$users_header = array('Name'=>'Snap users name','Minimum Discount %'=>'Minimum Discount %','Available Days of week'=>'Available Days of week','Available Times of Day'=>'Available Times of Day');

				$this->excel->getActiveSheet()->fromArray(array_keys($users_header),NULL,'A1');

				$j=2;

				if(count($data['snapResult']) > 0){

					for($i=0;$i<count($data['snapResult']);$i++){

						$minimumDiscountPercentageId = (int)$data['snapResult'][$i]['snap_percentage'];

						//$minimumDiscountPercentage   = $data['snapPercentage'][$minimumDiscountPercentageId];

						$minimumDiscountPercentage   = "";

						$availableDaysOfWeek         = $data['snapResult'][$i]['snap_day'];

						//var_dump($availableDaysOfWeek);

						$availableTimeData           = $data['snapResult'][$i]['snap_time'];

						$availableDayString          = "";

						$availableTimeString         = "";

						if($availableDaysOfWeek == 0) {

							$availableDayString = "All Day";

							//var_dump("hiiii");

						} else {

							$availableDayIdArray = explode(',', $availableDaysOfWeek);

							foreach ($availableDayIdArray as $key => $value) {

								$availableDayString.=$data['snapWeekdays'][$value].',';	

							}

							$availableDayString = rtrim($availableDayString,',');

						}

						if($availableTimeData == 0) {

							$availableTimeString = "Any Time";

						} else {

							$availableTimeStringArray = explode(',', $availableTimeData);

							foreach ($availableTimeStringArray as $key => $value) {

								$availableTimeString.=$data['snapTime'][$value].',';

							}

							$availableTimeString = rtrim($availableTimeString,',');

						}

						if($minimumDiscountPercentageId == 0) {

							$minimumDiscountPercentage = "Any Discount";

						} else {

							$minimumDiscountPercentage   = $data['snapPercentage'][$minimumDiscountPercentageId];

						}





						$this->excel->getActiveSheet()->setCellValue('A'.$j, $data['snapResult'][$i]['name']);

						$this->excel->getActiveSheet()->setCellValue('B'.$j,$minimumDiscountPercentage.'%');

						$this->excel->getActiveSheet()->setCellValue('C'.$j, $availableDayString);

						$this->excel->getActiveSheet()->setCellValue('D'.$j, $availableTimeString);

						$j++;

					}

			  } else {

			  	 $this->excel->getActiveSheet()->setCellValue('A2','No Result Found');

			  }



				$filename='usersnaplist.csv';

				header("Content-Type: application/force-download");

				header('Content-Type: application/vnd.ms-excel');

				header('Content-Disposition: attachment;filename="'.$filename.'"');

				header('Cache-Control: max-age=0');

				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'CSV');

				$objWriter->save('php://output');

		  		

		  	}



	# + Start according to email offer drop down value resident users will show up

		public function usersemailofferview(){ 

		    $zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

			$businessid = !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : '';

			$age_residentuser = !empty($_REQUEST['age_residentuser']) ? $_REQUEST['age_residentuser'] : '';

			$resident_gender = !empty($_REQUEST['resident_gender']) ? $_REQUEST['resident_gender'] : '';

			$resident_info = !empty($_REQUEST['resident_info']) ? $_REQUEST['resident_info'] : '';

			$dropdownval = !empty($_REQUEST['dropdownval']) ? $_REQUEST['dropdownval'] : '';

			

			$lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0 ;

		    $upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 10 ; 

			

			   # + View user email offer fetch all data 

					$data['users_email_offers'] = $this->email_notice->users_email_offers($zoneid,$age_residentuser,$resident_gender,$resident_info,$lowerlimit,$upperlimit,$dropdownval) ; //echo "<pre>";var_dump($data['users_email_offers']);exit;

			   # - View user email offer fetch all data 

			 $lowerlimit_new=$lowerlimit+$upperlimit;

		     $limit=$lowerlimit_new.','.$upperlimit; 

			 $data['zoneid']=$zoneid; 

			 $data['businessid']=$businessid ; 

			 $data['count_emailoffer_in_zone']=count($data['users_email_offers']); 

			 $result = $this->load->view('business/subpage/view_all_email_offer', $data, true);

			 echo($this->dr->GetDR($data['count_emailoffer_in_zone'],$limit, $result, "0"));	

		}

	# + End according to email offer drop down value resident users will show up

		

	# + Start email info details as structure view content when business user want to email to resident user at that time. Ck editor view also applying. 	

	  public function sendemail_to_users(){

		  $data=array();

		  // print_r($_REQUEST);die;

		  $data['busid'] = !empty($_REQUEST['busid']) ? $_REQUEST['busid'] : ''; 

		  $data['zoneid'] = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

		  $data['from']   = !empty($_REQUEST['from']) ? $_REQUEST['from'] : '';

		  $data['display_checkbox'] = !empty($_REQUEST['display_checkbox']) ? $_REQUEST['display_checkbox'] : ''; 

		  $data['display_email'] = !empty($_REQUEST['display_email']) ? $_REQUEST['display_email'] : '';

		  $data['display_userid'] = !empty($_REQUEST['display_userid']) ? $_REQUEST['display_userid'] : '';

		  $data['display_contactname'] = !empty($_REQUEST['display_contactname']) ? $_REQUEST['display_contactname'] : '';

		  $data['business_emailid'] = $this->email_notice->businessid($data['busid']);

		  $data['textmsg_editor'] = array(

										//ID of the textarea that will be replaced  

											'id' 	=> 	'business_email_offer',

											'path'	=>	'assets/ckeditor',

											//Optional values

											'config' => array(

												'toolbar' 	=> 	"Full", 	//Using the Full toolbar

												'width' 	=> 	"800px",	//Setting a custom width

												'height' 	=> 	'250px',	//Setting a custom height

										));	
 
		  $result=$this->load->view('business/show_email_usersend',$data,true);

		  echo($this->dr->GetDR("","", $result, "0"));

	  }

	 # + Emd email info details as structure view content when business user want to email to resident user at that time. Ck editor view also applying. 

	  

		

	# + Start business user emaills selective email credit offer users 	

		public function sendemail_from_business(){	

			 $data=array();

			 $data['all_email'] = !empty($_REQUEST['all_email']) ? $_REQUEST['all_email'] : ''; 

			 $data['all_contactname'] = !empty($_REQUEST['all_contactname']) ? $_REQUEST['all_contactname'] : ''; 

			 $data['all_users_info'] = !empty($_REQUEST['all_users_info']) ? $_REQUEST['all_users_info'] : ''; 

			 $data['bus_emailid'] = !empty($_REQUEST['bus_emailid']) ? $_REQUEST['bus_emailid'] : ''; 

			 $data['busid'] = !empty($_REQUEST['busid']) ? $_REQUEST['busid'] : ''; 

			 $data['userid'] = !empty($_REQUEST['userid']) ? $_REQUEST['userid'] : ''; //var_dump($data['userid']);exit;

			 $data['business_email_subject'] = !empty($_REQUEST['business_email_subject']) ? $_REQUEST['business_email_subject'] : ''; 

			 $data['business_email_offer'] = !empty($_REQUEST['business_email_offer']) ? $_REQUEST['business_email_offer'] : ''; 

			 $timestamp = time();

			 $info_arr = array();

			 $user_arr = array();

			 $info = explode('#',$data['all_users_info']); 

				foreach($info as $explode_val){

					$all_info_explode = explode(',',$explode_val);

						foreach($all_info_explode as $explode_val1){ 

							$info_arr[] = $explode_val1;

						}

				}

				

			$userinfo = explode(',',$data['userid']); 	

				foreach($userinfo as $user_info){

					$user_arr[] = $user_info;

				}

			

			 $all_email_id = explode(',',$data['all_email']);

			 

				$business_email_data=array(

											 'business_email_subject'=>$data['business_email_subject'],

											 'business_email_offer' => $data['business_email_offer'],

											 'business_email_status'=>1,

											 'business_email_timestamp'=>$timestamp,

										  );

				$business_email_insert= array_filter($business_email_data);	

				$this->db->insert('business_email', $business_email_insert);

				$business_email_id = $this->db->insert_id();

			 

				 $email_arr = array();

				 $offer_valarr = array();

				 $email_send_info = array();

				 $email_offers_criteria_value = array();

			        $this->db->select('a.id,a.email,a.first_name,a.last_name,b.*,c.email_offers_criteria_value');

					$this->db->from('users a');

					$this->db->join('users_email_offers b', 'b.usersid=a.id'); 

					$this->db->join('email_offers_criteria c', 'c.email_offers_criteria_id=b.email_offers_criteria_id');

					$this->db->where_in('b.email_offers_criteria_id',$info_arr); 

					$this->db->where_in('b.usersid',$user_arr); 

					$query = $this->db->get();

					$result = $query->result_array(); 

					

					foreach($result as $val){

						$business_email_to_users_data=array(

											 'businessid'=> $data['busid'],

											 'business_email_id'=>$business_email_id,

											 'usersid' => $val['usersid'],

											 'users_email_offers_id'=>$val['users_email_offers_id'],

											 'business_email_to_users_timestamp'=>$timestamp,

										);

										

						$business_email_to_user_insert= array_filter($business_email_to_users_data); 

						$this->db->insert('business_email_to_users', $business_email_to_user_insert);

						$business_email_to_users_id = $this->db->insert_id();



						$name = $val['first_name'].' '.$val['last_name']; 

						$email_send_info[$val['email'].'##'.$name.'##'.$val['usersid']] .= $val['email_offers_criteria_value'].', ';

				   } 

					

					$mail_specific_info = $email_send_info; //echo "<pre>"; var_dump($mail_specific_info);	exit;

					

						foreach($mail_specific_info as $userinfo => $user_mail_offer){

							$splitinfo = explode('##',$userinfo);

							$user_email = $splitinfo[0];

							$user_name = $splitinfo[1];

							$user_id = $splitinfo[2];

							

						################################################################

						

							$email_credit_balance=array(

												 'usersid'=> $user_id,

												 'businessid'=> $data['busid'],

												 'business_email_id'=> $business_email_id,

												 'email_credit_package_id'=> '-99',

												 'email_credit_package_transaction_id'=>'-99', 

												 'email_credit_balance_type' => 'D',

												 'email_credit_balance_value'=> '1',

												 'email_credit_balance_timestamp'=>$timestamp,

												 'email_credit_balance_status'=> '0',

												 'email_credit_balance_earn'=> '0',

							);

							

							$email_credit_balance= array_filter($email_credit_balance);		

							$this->db->insert('email_credit_balance', $email_credit_balance);

							$email_credit_balance_id = $this->db->insert_id();

							

							   $this->db->select('usersid');

							   $this->db->from('email_credit_balance');

							   $this->db->where('email_credit_balance_status', '0');

							   $this->db->where('usersid',$user_id);

							   $query1 = $this->db->get();

							   $num = $query1->num_rows();

							

									if($num == 12){

										$data = array(

											'email_credit_balance_status' => '1',

											'email_credit_balance_earn' => $email_credit_balance_id.'_'.$timestamp,

										);

										

										$this->db->where('email_credit_balance_status', '0');

							            $this->db->where('usersid',$user_id);

										$this->db->update('email_credit_balance', $data); //echo $this->db->last_query();

										

									 	   $this->db->select('username');

										   $this->db->from('users');

										   $this->db->where('id',$user_id);

										   $query2 = $this->db->get();

										   $result2 = $query2->result_array();

										   $username = $result2[0]['username'];

										   

											    $this->db->set('balance', 'balance+2',FALSE);

												$this->db->where('member_type', '1');

												$this->db->where('user_name',$username);

												$this->db->update('tbl_member'); //echo $this->db->last_query();

							 	  }

									

						

						   ##################################################################	

							

							# + Start User will get Email from business

								$message_body =	'<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">

									<div style="width:960px; margin:0 auto !important;">

									<div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">

									<div style="background-color:#3f3f3f; height:70px;"><img src="http://www.savingssites.com/assets/images/logo_white.png"   

									 style="margin:10px 202px;" alt="logo"/></div>

									<div style="clear:both"></div>

									<div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:300px; padding:15px;">

									<h2 style="text-align:left;">Hello'." ".$user_name.', 

									  </h2>

									<h3><p style="text-align:left; display:block; color:#333;">Offers criteria value: '.substr($user_mail_offer,0,-1).'</p></h3>  

									<h3><p style="text-align:left; display:block; color:#333;">Message: '.$data['business_email_offer'].'</p></h3>

									</div>

									<div style="background-color:#999; height:60px;"></div>

									</div>

									</div>

									</body>';	 

								

								$fromemail=$this->config->item('adminEmailId');

								$template_subject= $data['business_email_subject'];

								$this->email->clear();

								$this->email->from($fromemail);

								$this->email->subject($template_subject);

								$this->email->message($message_body);

								if($user_email!=''){		

									$this->email->to($user_email);

									$this->email->send();

									$to[]=$user_email;

								}

							# - End User will get Email from business	

						}

						

					echo($this->dr->GetDR($business_email_id, "The save was successful", "" , $height = "0"));

	

		}




		/**

		  * @description method to send snap email

		  * @param $userEmail,$contactName,$subject,$messageContent

		  * @return boolean

		*/

		public function sendSnapMailToUsers() {

			$usersEamail      = $_REQUEST['all_email'] ? $_REQUEST['all_email'] : '';

			$userContactName  = $_REQUEST['all_contactname'] ? $_REQUEST['all_contactname'] : '';

			$subject          = $_REQUEST['subject'] ? $_REQUEST['subject'] : '';

			$content          = $_REQUEST['content'] ? $_REQUEST['content'] : '';

			$userEmailArray   = explode(',', $usersEamail);

			$contactNameArray = explode(',', $userContactName);

			$fromEmail        = "noreply@savingsites.com";

			$status           = 0;

			foreach ($userEmailArray as $key => $value) {

				$messageBody      = '<body style="background-color:#FFF; font-family:Arial, Helvetica, sans-serif;">

									<div style="width:960px; margin:0 auto !important;">

									<div style="background-color:#f2f2f2; border-radius:4px; width:650px; margin:5px auto; padding:15px;">

									<div style="background-color:#3f3f3f; height:70px;"><img src="<?= base_url() ?>assets/images/logo_red_ss.png"   

									 style="margin:10px 202px; display:block" alt="logo" width="200" height="30"/></div>

									<div style="clear:both"></div>

									<div style="background-color:#FFF; margin-top:10px; margin-bottom:10px; min-height:300px; padding:15px;">

									<h2 style="text-align:left;">Hello'." ".$contactNameArray[$key].', 

									  </h2>

									<h3><p style="text-align:left; display:block; color:#333;">Message: '.$content.'</p></h3>

									</div>

									<div style="background-color:#999; height:60px;"></div>

									</div>

									</div>

									</body>';



				$this->email->clear();

				$this->email->from($fromEmail);

				$this->email->subject($subject);

				$this->email->message($messageBody);



				if(!empty($value)){

					$this->email->to($value);

					$status = $this->email->send();

					//$status = $value;

				}	

			}

			echo json_encode($status);

		}

	# + End business user emaills selective email credit offer users 	

	

		public function creditemailhistory($businessid=false,$fromzoneid=0){

			$data['common']=$this->common_first($businessid,$fromzoneid);

		# + Added on 27/09/16

			$data['zoneid'] = $data['common']['zoneid'];

			$data['createdby_id'] = $data['common']['businessid'];

			$data['createdby_type'] = 2;

		# + Fetch data resident dropdown info

		 	$data['email_offers_criteria'] = $this->email_notice->email_offers_criteria() ;

		# - Fetch data resident dropdown info	

		# - Added on 27/09/16

			$data['right_container'] = $this->load->view("business/credit_email_history", $data, true); 

			$this->common($data);

	}  

	

	# + Start search on credit email history users records from dropdown value

		public function send_emailcredit_history_dropdown(){

			$zoneid = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : '';

			$businessid = !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : '';

			$age_residentuser = !empty($_REQUEST['age_residentuser']) ? $_REQUEST['age_residentuser'] : '';

			$resident_gender = !empty($_REQUEST['resident_gender']) ? $_REQUEST['resident_gender'] : '';

			$resident_info = !empty($_REQUEST['resident_info']) ? $_REQUEST['resident_info'] : '';

			

			$lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0 ;

			$upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 10 ; //var_dump($upperlimit);exit;

			

				$data['all_email_criteria_id'] = $this->email_notice->all_email_criteria_id($age_residentuser,$resident_gender,$resident_info);//var_dump($data['all_email_criteria_id']);exit;

			

			# + View user email offer fetch all data 

				$data['view_emailcredit_offer'] = $this->email_notice->view_emailcredit_offer($zoneid,$businessid,'','',$lowerlimit,$upperlimit,$age_residentuser,$resident_gender,$resident_info) ; //echo "<pre>";var_dump($data['view_emailcredit_offer']);exit;

			# - View user email offer fetch all data 

			  $lowerlimit_new=$lowerlimit+$upperlimit;

			  $limit=$lowerlimit_new.','.$upperlimit; 

			  $data['zoneid']=$zoneid; 

			  $data['businessid']=$businessid ; 

			  $data['count_emailoffer']=count($data['view_emailcredit_offer']); 

			

			$result=$this->load->view('business/show_credit_email_history',$data,true);

			echo($this->dr->GetDR($data['count_emailoffer'],$limit, $result, $data['all_email_criteria_id']));

		}

	# + End search on credit email history users records from dropdown value

	

	# + Start show all users email Credit history info section 

		public function view_emailcredit_history(){

			$data['businessid'] = !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : ''; 

			$data['zoneid'] = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : ''; 

			$data['criteriaid'] = !empty($_REQUEST['criteriaid']) ? $_REQUEST['criteriaid'] : ''; 

			

			$lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0 ;

			$upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 10 ; 

			

			$data['view_emailcredit_offer'] = $this->email_notice->view_emailcredit_offer($data['zoneid'],$data['businessid'],$data['criteriaid'],'all',$lowerlimit,$upperlimit) ;//echo "<pre>"; var_dump($data['view_emailcredit_offer']);exit;

			

		   $lowerlimit_new=$lowerlimit+$upperlimit;

		   $limit=$lowerlimit_new.','.$upperlimit;  

		   $data['count_emailoffer']=count($data['view_emailcredit_offer']); 

			

			$result=$this->load->view('business/show_credit_email_history',$data,true);

			echo($this->dr->GetDR($data['count_emailoffer'],$limit, $result, $data['criteriaid']));

		}

	# + Start show all users email Credit history info section 

	

	

	# + Start Show email free credits history display for a indivisual resident user 

		public function view_email_specificinfo(){ //echo "<pre>"; var_dump($_REQUEST);exit; // business_email_id

			$data['business_email_to_users_id'] = !empty($_REQUEST['business_email_to_users_id']) ? $_REQUEST['business_email_to_users_id'] : ''; 

			$data['businessid'] = !empty($_REQUEST['businessid']) ? $_REQUEST['businessid'] : ''; 

			$data['business_email_id'] = !empty($_REQUEST['business_email_id']) ? $_REQUEST['business_email_id'] : ''; 

			$data['zoneid'] = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : ''; 

			$data['user_contact_name'] = $this->email_notice->usercontactname($data['business_email_to_users_id']);

			$data['view_email_specificinfo'] = $this->email_notice->view_email_specificinfo($data['business_email_to_users_id'],$data['businessid'],$data['business_email_id']);

			$data['right_container'] = $this->load->view("business/history_view_email_specificinfo", $data, true); 

			echo($this->dr->GetDR($data['business_email_to_users_id'],$data['view_email_specificinfo'], $data['right_container'], "0"));

		}

	# + End Show email free credits history display for a indivisual resident user 

		public function thankuview(){

			$data['payment_details'] = $_POST ? $_POST : '';

			$data['result'] = $this->business_model->save_payment($_POST);

			$this->load->view('thanku',$data);

			



		}

		public function restaurentBookingAutoLogin($businessId,$zoneId,$fromZone){

			$password = isset($_COOKIE['blog_password']) ? $_COOKIE['blog_password'] : 0;

			$userId = $this->business_model->getRestaurentUserId($businessId,$zoneId,$password);

			 $url = base_url('snapdining/index.php?controller=pjBase&action=pjActionLogin&user_id='.$userId.'&business_id='.$businessId.'&zone_id='.$zoneId.'&from_zone='.$fromZone);

			redirect($url,'refresh');
		
		}



		public function imageGalleryAutoLogin($businessId,$zoneId,$fromZone){

			//var_dump($_COOKIE);			

			$password = isset($_COOKIE['blog_password']) ? $_COOKIE['blog_password'] : 0;

			$userId = $this->business_model->getGalleryUserId($businessId,$zoneId,$password);

			$url = base_url('image_gallery/index.php?controller=pjAdmin&action=pjActionLogin&user_id='.$userId.'&business_id='.$businessId.'&zone_id='.$zoneId.'&from_zone='.$fromZone);

			redirect($url,'refresh');

		}



		public function restaurantMenuMakerAutoLogin($businessId,$zoneId,$fromZone){



			$password = isset($_COOKIE['blog_password']) ? $_COOKIE['blog_password'] : 0;

			$userId = $this->business_model->getMenuMakerUserId($businessId,$zoneId,$password);

			$url = base_url('restaurantMenuMaker/index.php?controller=pjAdmin&action=pjActionLogin&user_id='.$userId.'&business_id='.$businessId.'&zone_id='.$zoneId.'&from_zone='.$fromZone);

			redirect($url,'refresh');

		}

		/**

		  * Method to update business information status

		  * @access public

		  * @return $status boolean

		*/

		public function updateBusinessInformationStatus() {

			$businessId = isset($_REQUEST['businessId']) ? $_REQUEST['businessId'] : 0;

			$changedStatus = isset($_REQUEST['updateStatus']) ? $_REQUEST['updateStatus'] : 0;

			$businessInformationUpdateStatus = $this->business_model->updateBusinessInformation($businessId,$changedStatus);

			echo json_encode($businessInformationUpdateStatus);

		}

	

		

	##############################  ---- Peekaboo Free Email Credit ---- #########################################		
		public function save_discount(){
			$cashDis = isset($_REQUEST['cashDis'])?$_REQUEST['cashDis']:''; 
			$cardDis = isset($_REQUEST['cardDis'])?$_REQUEST['cardDis']:''; 
			$pickDis = isset($_REQUEST['pickDis'])?$_REQUEST['pickDis']:''; 
			$deliveryDis = isset($_REQUEST['deliveryDis'])?$_REQUEST['deliveryDis']:''; 
			$onlineorderDis = isset($_REQUEST['onlineorderDis'])?$_REQUEST['onlineorderDis']:''; 
			$dis_refuse_cash_cert = isset($_REQUEST['dis_refuse_cash_cert'])?$_REQUEST['dis_refuse_cash_cert']:''; 
			$dis_use_cash_cert = isset($_REQUEST['dis_use_cash_cert'])?$_REQUEST['dis_use_cash_cert']:''; 
			$businessid = isset($_REQUEST['businessid'])?$_REQUEST['businessid']:'';
			if($dis_use_cash_cert == 1){
				$dis_refer_cert = 1;
			}else{
				$dis_refer_cert = 0;
			}
			// update business discount data
			$data = array( 
    			'cash_discount'     => $cashDis , 
    			'card_discount'     => $cardDis, 
    			'pick_discount'     => $pickDis,
    			'delivery_discount' => $deliveryDis,
    			'online_order_dicount' => $onlineorderDis,
    			'free_cert_dis_availability' => $dis_refer_cert
			);
			$this->db->where('id', $businessid);
			$this->db->update('business', $data);
			if($this->db->affected_rows()){
				echo json_encode(array('type' => 'success','msg' => 'Discount Updated Successfully'));
			}else{
				echo json_encode(array('type' => 'warning','msg' => 'Something Went Wrong'));
			}
			die;
		}

	public function editdealdata(){
		$msg = ['editdata' => 'No Auction Found','editdataresponse' => 0];
		$auction_sql_setting =  'SELECT ip.* , a.*,ip.deal_product_id,ip.product_name,  a.page_title ,a.auction_type,a.status,a.display,a.start_date,a.last_update,bu.name as company_name FROM tbl_deals a 

		LEFT JOIN tbl_deals_products ip ON ip.deal_product_id=a.product_id

		LEFT JOIN tbl_member m ON m.user_id = a.user_id 
		LEFT JOIN users u ON u.username=m.user_name 
		LEFT JOIN business bu ON bu.business_owner_id=u.id 


		WHERE a.product_id='.$_REQUEST['productid'].' order by a.start_date ASC';








   	    $auction_result_setting = $this->CommonController->SelectRawquery($auction_sql_setting,'resultArray');
   	    $msg = ['editdata' => $auction_result_setting,'editdataresponse' => 1];
   	    echo json_encode($msg);
	}

	public function showdealdata(){
		$dealmetaid = $_REQUEST['dealmeta'];
		$busid = $_REQUEST['busid'];
		
		$pbcashqry="SELECT
			a.busId,e.userId,e.amountPrchased as purchasedprice,e.purchasedAt,e.user_type,a.id as metaid, a.totalamount as dealamounnt, a.discount as dealdiscount,a.amountPurchased as dealactual_price,a.dealId,b.start_date, b.end_date,b.created_date,b.auction_type,b.status,b.deal_title,b.deal_description,c.card_img,c.publisher_fee,c.seller_fee,d.email,d.first_name,d.last_name,d.Gender,d.phone,d.Address,c.numberofconsolation,b.current_price,b.buy_price_decrease_by
		  

		 FROM tbl_deals_purchased_meta as a 
 			INNER JOIN tbl_deals as b ON a.dealID=b.deal_id 
			INNER JOIN tbl_deals_products as c ON b.product_id=c.deal_product_id 
			INNER JOIN users as d ON d.id=a.userId
			INNER JOIN tbl_deals_purchased as e ON e.userId=a.userId
 			WHERE a.busId=".$busid." AND a.id=".$dealmetaid."";
		$purchasedealArr = $this->CommonController->SelectRawquery($pbcashqry,'resultArray');
		$msg = ['data' => $purchasedealArr,'response' => 1];
   	    echo json_encode($msg);
	}

	public function saveaudiomultiple(){
		$res = [];
		$day = isset($_REQUEST['day'])?$_REQUEST['day']:'';
		$business_id = isset($_REQUEST['business_id'])?$_REQUEST['business_id']:'';
		$audiourl = isset($_REQUEST['audiourl'])?$_REQUEST['audiourl']:'';
		$pdf_temp_name = isset($_FILES['pdf_file']['tmp_name'])?$_FILES['pdf_file']['tmp_name']:'';
		$audio_temp_name = isset($_FILES['audio_file']['tmp_name'])?$_FILES['audio_file']['tmp_name']:'';
		$via = isset($_REQUEST['via'])?$_REQUEST['via']:'';
		$zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:'';
		if($via == 'twilio'){
			if($audio_temp_name != ''){
				$AudioPath = '/home/savingssites/public_html/assets/SavingsUpload/Twilio/';
        		if(is_dir($AudioPath)==false){mkdir($AudioPath,0777);}
        		$saveAudioPath = '/home/savingssites/public_html/assets/SavingsUpload/Twilio/'.$zoneid;
        		if(is_dir($saveAudioPath)==false){mkdir($saveAudioPath,0777);}
        		$input = $_FILES['audio_file']['tmp_name'];
        		$output = $saveAudioPath.'/'.$zoneid.".mp3";  
				move_uploaded_file($input, $output);
				$files = $zoneid.'.mp3';
				$this->CommonController->updateData('twilioZoneAccount',['filename'=> $files],['zoneid' => $zoneid]);	
			}else{
				$files = $audiourl.'.mp3';
				$this->CommonController->updateData('twilioZoneAccount',['filename'=> $files],['zoneid' => $audiourl]);
			}

			
			echo json_encode(['msg'=>'Upload Audio Updated Successfully','type'=>'success']);	
			die;
		}
		if($audiourl != ''){
			$res[] = $this->save_audio_day($day,$business_id,$audiourl);	
		}
		if($pdf_temp_name != ''){
			$res[] = $this->save_pdf_day($day,$business_id,$_FILES['pdf_file']);	
		}
		if($audio_temp_name != ''){
			$res[] = $this->save_uploadAudio_day($day,$business_id,$_FILES['audio_file']);	
		}
		echo json_encode($res);	
	}

	public function save_uploadAudio_day($day,$business_id,$files){
		$msg = ['msg'=>'Something Went Wrong','type'=>'warning'];
		$Path = $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/Audio/";
        if(is_dir($Path)==false){mkdir($Path,0777);}
        $savePath = $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/Audio/".$business_id;
        if(is_dir($savePath)==false){mkdir($savePath,0777);}
		$temp_name = $files['tmp_name'];
		$ext = pathinfo($files["name"], PATHINFO_EXTENSION);
		$type = trim($files["type"]);
		$audio_file = $savePath.'/'.$day.'_'.$business_id.'.'.$ext;
		if($type == "audio/mp3" || $type == "audio/mpeg" || $type == "audio/wav" || $type = "audio/x-wav"){
			if(move_uploaded_file($temp_name, $audio_file)){
				$this->deleteallfiles($business_id,'audio');
				$filename = $day.'_'.$business_id.'.'.$ext;
				$sql="SELECT *  FROM `res_favfood_audio` where business_id = '".$business_id."' AND day='".$day."'";
				$result=$this->CommonController->SelectRawquery($sql,'resultArray');
				if(count($result) > 0){
					$updateArr = array('audio'=>$filename);
					$this->CommonController->updateData('res_favfood_audio',$updateArr,['business_id' => $business_id,'day'=>$day]);
					$msg = ['msg'=>'Upload Audio Updated Successfully','type'=>'success'];
				}else{
					$dataArr = array('business_id'=>$business_id,'day'=>$day,'audio'=>$filename,'audiotype'=>2);
					$this->CommonController->InsertData('res_favfood_audio', $dataArr);	
					$msg = ['msg'=>'Upload Audio Successfully','type'=>'success'];
				}	
			}

		}else{
			return array('msg'=>'File Format not Allowed','type'=>'warning');
			die;
		}
		
		return $msg;		
	}

	public function save_pdf_day($day,$business_id,$files){
		$msg = ['msg'=>'Something Went Wrong','type'=>'warning'];
		$PdfPath = $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/PDF/";
        if(is_dir($PdfPath)==false){mkdir($PdfPath,0777);}
        $savepdfPath = $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/PDF/".$business_id;
        if(is_dir($savepdfPath)==false){mkdir($savepdfPath,0777);}
        
		$temp_name = $files['tmp_name'];
        $pdf_file = $savepdfPath.'/'.$day.'_'.$business_id.'.pdf'; 
		$pdf_type = $files["type"];
		if($pdf_type != "application/pdf"){
			return array('msg'=>'File Format Not Supported','type'=>'warning');
		}
		if(move_uploaded_file($temp_name, $pdf_file)){
			$filename = $day.'_'.$business_id.'.pdf';
			$sql="SELECT *  FROM `res_favfood_audio` where business_id = '".$business_id."' AND day='".$day."'";
			$result=$this->CommonController->SelectRawquery($sql,'resultArray');
			if(count($result) > 0){
				$updateArr = array('pdf'=>$filename);
				$this->CommonController->updateData('res_favfood_audio',$updateArr,['business_id' => $business_id,'day'=>$day]);
				$msg = ['msg'=>'Pdf Updated Successfully','type'=>'success'];;
			}else{
				$dataArr = array('business_id'=>$business_id,'day'=>$day,'pdf'=>$filename);
				$this->CommonController->InsertData('res_favfood_audio', $dataArr);	
				$msg = ['msg'=>'Pdf Uploaded Successfully','type'=>'success'];
			}	
		}
		return $msg;		
	}

	public function save_audio_day($day,$business_id,$audiourl){
		$this->deleteallfiles($business_id,'audio');
		$msg = ['msg'=>'Something Went Wrong','type'=>'warning'];
		$filename = $audiourl.'.mp3';
		$sql="SELECT *  FROM `res_favfood_audio` where business_id = '".$business_id."' AND day='".$day."'";
		$result=$this->CommonController->SelectRawquery($sql,'resultArray');
		if(count($result) > 0){
			$updateArr = array('audio'=>$filename);
			$this->CommonController->updateData('res_favfood_audio',$updateArr,['business_id' => $business_id,'day'=>$day]);
			$msg = ['msg'=>'Record Audio Updated Successfully','type'=>'success'];
		}else{
			$dataArr = array('business_id'=>$business_id,'day'=>$day,'audio'=>$filename,'audiotype'=>1);
			$this->CommonController->InsertData('res_favfood_audio', $dataArr);	
			$msg = ['msg'=>'Record Audio Uploaded Successfully','type'=>'success'];
		}
		return $msg;
	}

	public function save_record_audio(){
		$day = isset($_REQUEST['day'])?$_REQUEST['day']:'';
		$business_id = isset($_REQUEST['business_id'])?$_REQUEST['business_id']:'';
		$audiourl = isset($_REQUEST['audiourl'])?$_REQUEST['audiourl']:'';
		$via = isset($_REQUEST['via'])?$_REQUEST['via']:'';
		$input = $_FILES['audio_data']['tmp_name']; 
		$AudioPath = $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/Audio/";
        if(is_dir($AudioPath)==false){mkdir($AudioPath,0777);}
        $saveAudioPath = $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/Audio/".$business_id;
        // echo $saveAudioPath;
        if(is_dir($saveAudioPath)==false){mkdir($saveAudioPath,0777);}
        $output = $saveAudioPath.'/'.$_FILES['audio_data']['name'].".mp3"; 
        move_uploaded_file($input, $output);	
    }

	public function deleteallfiles($business_id,$type){
		$saveAudioPath = $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/Audio/";
		$files = glob($saveAudioPath.'/*'); 
		foreach($files as $file) { 
   			if(is_file($file))  
   				unlink($file);  
		} 
	}

	public function save_twilio_audio(){
		$zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:'';
		$audiourl = isset($_REQUEST['audiourl'])?$_REQUEST['audiourl']:'';
		$input = $_FILES['audio_data']['tmp_name']; 
		$AudioPath = '/home/savingssites/public_html/assets/SavingsUpload/Twilio/';
        if(is_dir($AudioPath)==false){mkdir($AudioPath,0777);}
        $saveAudioPath = '/home/savingssites/public_html/assets/SavingsUpload/Twilio/'.$zoneid;
        if(is_dir($saveAudioPath)==false){mkdir($saveAudioPath,0777);}
        $output = $saveAudioPath.'/'.$_FILES['audio_data']['name'].".mp3";  
		move_uploaded_file($input, $output);	
    }

	

	

	public function get_audio_day(){
		$day = isset($_REQUEST['day'])?$_REQUEST['day']:'';
		$business_id = isset($_REQUEST['business_id'])?$_REQUEST['business_id']:'';
		$sql="SELECT *  FROM `res_favfood_audio` where business_id = '".$business_id."' AND day='".$day."'";
		$result=$this->CommonController->SelectRawquery($sql,'row');	
		echo json_encode($result);
		die;
	}

	public function delete_audio_day(){
		$day = isset($_REQUEST['day'])?$_REQUEST['day']:'';
		$business_id = isset($_REQUEST['business_id'])?$_REQUEST['business_id']:'';
		$audio = isset($_REQUEST['audio'])?$_REQUEST['audio']:'';
		$pdf = isset($_REQUEST['pdf'])?$_REQUEST['pdf']:'';
		$all = isset($_REQUEST['all'])?$_REQUEST['all']:'';
		$msg = '';
		$audiopath = $_SERVER['DOCUMENT_ROOT'].'/assets/SavingsUpload/Audio/'.$business_id.'/'.$audio;
		$pdfpath = $_SERVER['DOCUMENT_ROOT'].'/assets/SavingsUpload/PDF/'.$business_id.'/'.$pdf;
		if($all == 'pdfaudio'){
			$updateArr = array('pdf'=>'','audio' =>'');
			$msg = 'PDF & Audio File Deleted Successfully';
			unlink($audiopath);  
        	unlink($pdfpath); 
        	$this->CommonController->deleteData('res_favfood_audio',['business_id' => $business_id,'day'=>$day]); 
		}else if($all == 'pdf'){
			$updateArr = array('pdf'=>'');
			$msg = 'PDF File Deleted Successfully';
			unlink($pdfpath);
			$this->CommonController->updateData('res_favfood_audio',$updateArr,['business_id' => $business_id,'day'=>$day]);
		}else if($all == 'audio'){
			$updateArr = array('audio'=>'','audiotype'=>'');
			$msg = 'Audio File Deleted Successfully';
			unlink($audiopath);
			$this->CommonController->updateData('res_favfood_audio',$updateArr,['business_id' => $business_id,'day'=>$day]);
		}
		echo json_encode(['msg'=>$msg,'type'=>'success']);
		die;
	}

	public function get_all_audio(){
		$business_id = isset($_REQUEST['business_id'])?$_REQUEST['business_id']:'';	
		$sql="SELECT *  FROM `res_favfood_audio` where business_id = '".$business_id."'";
		$result=$this->CommonController->SelectRawquery($sql,'resultArray');	
		echo json_encode($result);
		die;
	}

	public function updateshorturl(){
		$shorturl = $_REQUEST['shorturl'];
		$businessid = $_REQUEST['businessid'];
		
		$shorturlqry = "SELECT * FROM business as a LEFT JOIN address as b ON a.addressid=b.id WHERE a.shorturl='".$shorturl."' ";
		$shorturlArr = $this->CommonController->SelectRawquery($shorturlqry,'row');
	   	$businessshorturl = isset($shorturlArr->shorturl)?$shorturlArr->shorturl:'';
	   	if($businessshorturl == ''){ 
	   		$this->CommonController->updateData('business', ['shorturl'=>$shorturl],['id'=>$businessid]);
	   		$msg = ['msg'=>'Short url updated successfully','type'=>'success'];
	   	}else{
	   		$msg = ['msg'=>'Short url already Used, Try Different url ','type'=>'warning'];
	   	}
	   	echo json_encode($msg);
	   	die;
	}

	public function save_business_snap_filter(){
		$table 				= 'global_snap_business_settings';
		$bus_id 			= isset($_REQUEST['businessid'])?$_REQUEST['businessid']:'';
		$user 				= isset($_REQUEST['businessuser'])?$_REQUEST['businessuser']:'';
		$zone_id 			= isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:'';
		$snap_filter_arr 	= isset($_REQUEST['snap_filter_arr'])?$_REQUEST['snap_filter_arr']:'';
		$buseditsnap 		= isset($_REQUEST['buseditsnap'])?$_REQUEST['buseditsnap']:'';
		$dealId 			= isset($_REQUEST['dealId'])?$_REQUEST['dealId']:'';
		$dataArr = [];
		
		$dealexistsqry =  'SELECT * FROM business a LEFT JOIN users b ON a.business_owner_id=b.id LEFT JOIN tbl_member c ON c.user_name=b.username LEFT JOIN tbl_deals_products d ON c.user_id=d.user_id WHERE a.id='.$bus_id.' AND d.status="Live" AND d.numberofconsolation <> ""';
		$dealexistsArr = $this->CommonController->SelectRawquery($dealexistsqry, 'resultArray');
		$numberofconsolation = isset($dealexistsArr[0]['numberofconsolation'])?$dealexistsArr[0]['numberofconsolation']:'';
		if($numberofconsolation <= 0){
			echo json_encode(['msg'=>'Sorry you can not email/text short notice alerts because you are sold out of deals. Please approve a deal option to authorize a new batch of deals, so you will be able to send short notice alerts to members on your list.','type'=>'warning']);
			die;
		}
		
		if(count($snap_filter_arr) > 0){
			foreach ($snap_filter_arr as $k => $v){
				$eachday = $eachstarttime = $eachendtime = $eachnoofpeople = $eachsnapsendtype = $eachsnapdealid =  '';

				foreach ($v as $k1 => $v1) {
					if($k1 == 'day'){ $eachday = $v1;}
					if($k1 == 'starttime'){	$eachstarttime = $v1;}
					if($k1 == 'endtime'){ $eachendtime = $v1;}
					if($k1 == 'noofpeople'){ $eachnoofpeople = $v1;}
					if($k1 == 'snapsendtype'){ $eachsnapsendtype = $v1;}
					if($k1 == 'snapdealid'){ $eachsnapdealid = $v1;}
				}
				
				$dataArr[$eachday][] = [
					'dayarr' 			=> $eachday,
					'starttimearr' 		=> $eachstarttime,
					'endtimearr' 		=> $eachendtime,
					'noofpeoplearr' 	=> $eachnoofpeople,
					'snapsendtypearr'	=> $eachsnapsendtype,
					'snapdealidarr'		=> $eachsnapdealid,
					'snapdatearr'		=> date('m-d-y'),
				];
			}
		}

		if(count($dataArr) > 0){
			foreach ($dataArr as $dayk2 => $v2) {
				$qry = "SELECT * FROM ".$table." WHERE user_id=".$user." AND bus_id=".$bus_id." AND snap_week_days=".$dayk2."";
				$exists = $this->CommonController->SelectRawquery($qry,'result');
				$oldsnap_time = isset($exists[0]->snap_time)?$exists[0]->snap_time:'';
				if($buseditsnap == 1){
					$oldsnap_time = '';
				}
				if(count($exists) > 0){
					$this->CommonController->deleteData($table,['user_id'=>$user,'bus_id'=>$bus_id,'snap_week_days'=>$dayk2]);
				}
				if($oldsnap_time != ''){
					$oldsnap_timeArr = json_decode($oldsnap_time);
					$oldnewfinalsnaptimeArr = array_merge($oldsnap_timeArr,$v2); 
					$snaptimeimplode = json_encode($oldnewfinalsnaptimeArr);
				}else{
					$snaptimeimplode = json_encode($v2);	
				}
				$insertArr = array('user_id'=>$user,'bus_id'=>$bus_id,'dealId'=>$dealId,'snap_week_days'=>$dayk2,'snap_time'=>$snaptimeimplode,'created_for_zone'=>$zone_id,'status'=>1);
				$this->CommonController->InsertData($table, $insertArr);	
				$msg = ['msg'=>'SNAP Addded Successfully','type'=>'success'];
			}
		}
		echo json_encode($msg);
	   	die;
	}	

	public function confirm_business_snap_filter(){
		$msg = ['msg'=>'Something went wrong','type'=>'warning'];
		$business_snap_table  = 'global_snap_business_settings';
		$user_claim_snap_time = 'global_snap_user_claim_time';
		$recieveruser 		= isset($_REQUEST['recieveruser'])?$_REQUEST['recieveruser']:'';
		$snapbusid 			= isset($_REQUEST['snapbusid'])?$_REQUEST['snapbusid']:'';

		$snapdayid 			= isset($_REQUEST['snapdayid'])?$_REQUEST['snapdayid']:'';
		$snapstarttimeid 	= isset($_REQUEST['snapstarttimeid'])?$_REQUEST['snapstarttimeid']:'';
		$snapendtimeid 		= isset($_REQUEST['snapendtimeid'])?$_REQUEST['snapendtimeid']:'';
		$snapnoofpeopleid 	= isset($_REQUEST['snapnoofpeopleid'])?$_REQUEST['snapnoofpeopleid']:'';
		$snapsendtypeid 	= isset($_REQUEST['snapsendtypeid'])?$_REQUEST['snapsendtypeid']:'';
		$snapzoneid 	= isset($_REQUEST['snapzoneid'])?$_REQUEST['snapzoneid']:'';
		$dealurl = $this->CommonController->getdealurlusingzone($snapzoneid);

		$business_snapqry = "SELECT * FROM ".$business_snap_table." WHERE bus_id=".$snapbusid." AND snap_week_days=".$snapdayid."";
		$business_snapArr = $this->CommonController->SelectRawquery($business_snapqry,'row');
		if($business_snapArr != ''){
			$snap_business_timeArr = json_decode($business_snapArr->snap_time);
			if(count($snap_business_timeArr) > 0){
				foreach ($snap_business_timeArr as $k1 => $v1) {
					if($v1->dayarr == $snapdayid && $v1->starttimearr == $snapstarttimeid && $v1->endtimearr == $snapendtimeid){
						if($v1->noofpeoplearr <= 0){
							break;
							echo json_encode(['msg'=>'Table not available','type'=>'warning','url'=>'']);
							die;
						}else{
							$v1->noofpeoplearr = $v1->noofpeoplearr-1;
						}
					}
				}
				$userclaimArr = array('user_id'=>$recieveruser,'bus_id'=>$snapbusid,'day'=>$snapdayid,'snaptimeIn'=>$snapstarttimeid,'snaptimeout'=>$snapendtimeid);
				$claimid = $this->CommonController->InsertData($user_claim_snap_time, $userclaimArr);
				$snaptimeimplode = json_encode($snap_business_timeArr);
				$this->CommonController->updateData($business_snap_table,['snap_time'=> $snaptimeimplode],['bus_id'=>$snapbusid,'snap_week_days'=>$snapdayid]);	
				
				/* email to business */
				
 				$userArr = $this->CommonController->getuserdetail($recieveruser);
				$busArr  = $this->CommonController->getbusinessdetaildata($snapbusid);

				$busownerid = isset($busArr->business_owner_id)?$busArr->business_owner_id:'';
				$busidArr = $this->CommonController->getuserdetail($busownerid);
				$business_email = isset($busidArr->email)?$busidArr->email:'';

				$dayword = $this->CommonController->getsinglecolumndata('snap_week_days','day','id',$snapdayid);
				$starttimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$snapstarttimeid); 
                $endtimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$snapendtimeid);

                $insertedsnapclaimqry = "SELECT * FROM ".$user_claim_snap_time." WHERE id=".$claimid."";
				$insertedsnapclaimArr = $this->CommonController->SelectRawquery($insertedsnapclaimqry,'row');
				$createdtime = isset($insertedsnapclaimArr->created_at)?$insertedsnapclaimArr->created_at:'';
				$subject = 'Booking Confirmation on resident '.$userArr->first_name.' '.$userArr->last_name;
				$html = 'Dear '.$busArr->name.',<br>A '.$userArr->first_name.' '.$userArr->last_name.',<br> phone number is '.$userArr->phone.' booking a table on <br>'.$starttimeword.' to '.$endtimeword.' on '.$dayword.' on '.date('d-m-Y', strtotime($createdtime)).'';
				$this->CommonController->SendMail('',$business_email,$subject,$html);
				$msg = ['msg'=>'Bookiing confirmed successfully','type'=>'success','url'=>$dealurl];
			}
		}
		echo json_encode($msg);
	   	die;
	}

	public function delete_business_snap_filter(){
		$busid = isset($_REQUEST['busid'])?$_REQUEST['busid']:'';
		$daycount = isset($_REQUEST['daycount'])?$_REQUEST['daycount']:'';
		$this->CommonController->deleteData('global_snap_business_settings',['bus_id'=> $busid,'snap_week_days'=> $daycount]);
		$msg = ['msg'=>'SNAP Day Deleted Successfully','type'=>'success'];
	}

	public function sendsnapemailuser(){
		$busid = isset($_REQUEST['busid'])?$_REQUEST['busid']:'';
		$zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:'';
		$daydb = $this->CommonController->getcurrentdayid();
		$finalsnapbusArr = [];
		$totalusers = 0;
		$sql = "SELECT * FROM global_snap_business_settings where bus_id=".$busid." AND created_for_zone=".$zoneid." AND snap_week_days=".$daydb."";
        $snapbusArr = $this->CommonController->SelectRawquery($sql,'result');
        if(count($snapbusArr) > 0){
        	foreach($snapbusArr as $k => $v) {
				$snaptimejson = $v->snap_time;
				$snaptimeArr  = json_decode($snaptimejson);
				foreach ($snaptimeArr as $k1 => $v1){
					$finalsnapbusArr[$busid][$v1->dayarr][$v1->starttimearr][$v1->endtimearr] = $v->status;
					
				} 
			}
			$snap_users_settings_sql = "SELECT * FROM users where Zone_ID=".$zoneid." AND snap_settings IN (1,2)";
        	$snap_users_settings_Arr = $this->CommonController->SelectRawquery($snap_users_settings_sql,'result');
        	if(count($snap_users_settings_Arr) > 0){
        		foreach ($snap_users_settings_Arr as $k => $v) {
        			if($v->snap_settings == 1){
        				$totaluserscount = $this->CommonController->getsnaptimearr('global_snap_userbusiness_settings',$v->id,$zoneid,$finalsnapbusArr,$busid);	
        			}else if($v->snap_settings == 2){
        				$totaluserscount = $this->CommonController->getsnaptimearr('global_snap_business_settings',$v->id,$zoneid,$finalsnapbusArr,$busid);
        			}
        			if($totaluserscount > 0){
        				$totalusers = 1;
        				$busidArr = [$busid];
        				$this->BusinessSearch->sendsnapemailuser($zoneid,$v->id,$busidArr,$daydb);	
        			}
        		}
        	}
        }
        if($totalusers > 0){
			echo json_encode(['msg'=>'email send successfully','type'=>'success']);
        }else{
			echo json_encode(['msg'=>'email not send','type'=>'warning']);
		}
		die;












		// $busidArr = [$busid];
		// $snaponuserqry = "SELECT * FROM global_snap_userbusiness_settings WHERE bus_id=".$busid."";
		// $nonofusersnapfilteron = $this->CommonController->SelectRawquery($snaponuserqry,'result');
		// if(count($nonofusersnapfilteron) > 0){
		// 	foreach ($nonofusersnapfilteron as $k => $v) {
		// 		$this->BusinessSearch->sendsnapemailuser($zoneid,$v->user_id,$busidArr,$daydb);		
		// 	}
		// }
		// echo json_encode(['msg'=>'email send successfully','type'=>'success']);
		// die;
	}

	public function explore_snap_business_data(){


		










		$snaptimeArr1 = [];
		$dealid = isset($_REQUEST['dealid'])?$_REQUEST['dealid']:'';
		$busid = isset($_REQUEST['busid'])?$_REQUEST['busid']:'';
		$snapbusqry = "SELECT * FROM global_snap_business_settings WHERE bus_id=".$busid." AND dealId=".$dealid." Order By snap_week_days ASC";
		$snapbusArr = $this->CommonController->SelectRawquery($snapbusqry,'result');
		if(count($snapbusArr) > 0){
			foreach ($snapbusArr as $k => $v) {
				$snaptimejson = $v->snap_time;
				$snaptimeArr  = json_decode($snaptimejson);
				foreach ($snaptimeArr as $k1 => $v1){
					$v1->dayword = $this->CommonController->getsinglecolumndata('snap_week_days','day','id',$v1->dayarr);	
					$v1->starttimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v1->starttimearr);	
					$v1->endtimeword = $this->CommonController->getsinglecolumndata('snap_start_time','time','id',$v1->endtimearr);
					$snaptimeArr1[$v1->dayword][] = $v1;
				}
			}
		}







		echo json_encode($snaptimeArr1);
		die;
	}
}

?>	