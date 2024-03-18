<?php
namespace App\Controllers;
use App\Libraries\IonAuth;
use App\Libraries\PHPMailer_Lib;
use Config\MyConfig;
use App\Models\zone\Zone_model;
use App\Models\admin\Business;
use App\Models\admin\Ads_model;
use App\Controllers\CommonController;
use App\Models\admin\Sales_zone;
use App\Models\admin\Category_management_model;
use App\Models\Statistics;
use App\Models\States;
use App\Models\banner\Banner_model;
use App\Models\Category_new_model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
#[\AllowDynamicProperties]
class CronController extends BaseController{
    public function __construct(){
		$this->myconfig = new MyConfig;
    	$this->db = \Config\Database::connect();
    	$this->email = \Config\Services::email();
    	$this->ion_auth = $this->ionAuth = new \IonAuth\Libraries\IonAuth();
    	$this->session = \Config\Services::session();
    	$this->Zone_model = new Zone_model();
    	$this->Business = new Business();
    	$this->SalesZone = new Sales_zone();
    	$this->CommonController = new CommonController();
    	$this->Ads_model = new Ads_model();
    	$this->Statistics = new Statistics();
    	$this->States = new States();
    	$this->Banner_model = new Banner_model();
    	$this->Category_new_model = new Category_new_model();
    	$this->Category_management_model = new Category_management_model();
    }

    public function rankbusiness($zoneid){
    	$month = date('m');
    	$day = date('d');
    	$via = isset($_REQUEST['via'])?$_REQUEST['via']:'';
    	$insertArr = [];
    	if(trim($day) == '01' || $via == 'zonedashboard'){
    		$rankquery = "SELECT business_id FROM business_bid_detail WHERE zone_id='".$zoneid."' AND month='".$month."' order by bid_amount DESC";
			$businessArr = $this->CommonController->SelectRawquery($rankquery);
			$bidsr = 0; $bidArr = [];
			$dealsr = 0; $dealArr = [];
			$ascsr = 0;
			$doscountArr = [];
			if(count($businessArr) > 0){
				foreach ($businessArr as $k => $v) {
					$bidsr++;
					$this->CommonController->updateData('business_sponsor_order',['display_order'=>$bidsr],['business_id' => $v['business_id'],'zoneid'=>$zoneid]);
					$bidArr[] = $v['business_id'];
					$insertArr[$v['business_id']] = $bidsr;
				}
			}
			$dealsr = $bidsr;

			$joinArr[] = ['table' => 'ads_setting_preferences as b','link' => 'a.id=b.businessid','type' => 'inner'];
			$joinArr[] = ['table' => 'users as c','link' => 'a.business_owner_id=c.id','type' => 'inner'];
			$joinArr[] = ['table' => 'tbl_member as d','link' => 'c.username=d.user_name','type' => 'inner'];
			$joinArr[] = ['table' => 'tbl_deals as e','link' => 'e.user_id=d.user_id','type' => 'inner'];
	  		
	  		$select = 'a.id,e.deal_id,e.buy_price_decrease_by,e.current_price';
   	   		$where = ['b.settingszoneid' => $zoneid];
   	   		if(count($bidArr) > 0){
   	   			$whereNotIn = ['a.id'=>$bidArr];
   	   		}else{
   	   			$whereNotIn = [];
   	   		}
   	   		$data = $this->CommonController->SelectJoinMulti('business as a', $joinArr,$where,[],[],$select,'','','',[],'','',$whereNotIn);
   	   		if(count($data) > 0){
   	   			foreach ($data as $k1 => $v1) {
   	   				$doscountArr[] =[
   	   					'business_id'=> $v1->id,
   	   					'maxdiscount' =>$v1->buy_price_decrease_by-$v1->current_price 
   	   				];
   	   			}
   	   			$price = array_column($doscountArr, 'maxdiscount');
        		array_multisort($price, SORT_DESC, $doscountArr);
        		foreach ($doscountArr as $k2 => $v2) {
        			$dealsr++;
					$this->CommonController->updateData('business_sponsor_order',['display_order'=>$dealsr],['business_id' => $v2['business_id'],'zoneid'=>$zoneid]);
					$dealArr[] = $v2['business_id'];
					$insertArr[$v2['business_id']] = $dealsr;
        		}
   	   		}
   	   		$ascsr = $dealsr;

			$joinArr1[] = ['table' => 'ads_setting_preferences as b','link' => 'a.id=b.businessid','type' => 'inner'];
			$joinArr1[] = ['table' => 'ads as c','link' => 'a.id=c.business_id','type' => 'inner'];
			$finalmerge = array_merge($dealArr,$bidArr);
			if(count($dealArr) > 0){
   	   			$whereNotIn = ['a.id'=>$finalmerge];
   	   		}else{
   	   			$whereNotIn = [];
   	   		}
	  		
	  		$select = 'a.id,a.name';
   	   		$where = ['b.settingszoneid' => $zoneid];
   	   		
   	   		$dataend = $this->CommonController->SelectJoinMulti('business as a', $joinArr1,$where,[],[],$select,'','','',[],'','',$whereNotIn);
   	   		if(count($dataend) > 0){
   	   			$name = array_column($dataend, 'name');
        		array_multisort($name, SORT_ASC, $dataend);
   	   			foreach ($dataend as $k3 => $v3) {
   	   				$ascsr++;
   	   				$this->CommonController->updateData('business_sponsor_order',['display_order'=>$ascsr],['business_id' => $v3->id,'zoneid'=>$zoneid]);
   	   				$insertArr[$v3->id] = $ascsr;
   	   			}
   	   		}
   	   		if(trim($day) == '01'){
   	   			if(count($insertArr) > 0){
		    		foreach ($insertArr as $busid => $srno) {
		    			if($busid != ''){
							$sql = "SELECT id FROM `ads` WHERE business_id = '".$busid."'";
							$adid = $this->CommonController->SelectRawquery($sql, 'result');
							if($adid = ''){
							  $this->rearrangesubcatbusiness($insertArr,$zoneid);
							}
		    			}
		    		}
    	        }
				// $this->rearrangesubcatbusiness($insertArr,$zoneid);
   	   		}
   	   		if($via == 'zonedashboard'){
   	   			echo json_encode(['msg'=>'Re-Arrange Successfully','type'=>'success']);
   	   		}
   	   	}
    }

    public function rearrangesubcatbusiness($arr,$zoneid){
    	if(count($arr) > 0){
    		foreach ($arr as $busid => $srno) {
    			if($busid != ''){
					$sql = "SELECT id FROM `ads` WHERE business_id = '".$busid."'";
					$adid = $this->CommonController->SelectRawquery($sql, 'row')->id;
					$this->CommonController->updateData('business_sponsor_order_cat',['display_order'=>$srno],['adid' => $adid,'zoneid'=>$zoneid]);
    			}
    		}
    	}
    }

    public function rankcategory($busarr,$zoneId){
    	$busArr1 = [];
    	foreach ($busarr as $k => $v) {
    		$busArr1[] = $v->businessid;	
    	}
    	$search = implode(',', $busArr1);
    	$sponserquery = "SELECT business_id as businessid,display_order FROM business_sponsor_order WHERE zoneid='".$zoneId."' AND business_id IN (".$search.")";
		$businessArr1 = $this->CommonController->SelectRawquery($sponserquery,'result');
		$order = array_column($businessArr1, 'display_order');
        array_multisort($order, SORT_ASC, $businessArr1);
    	return $businessArr1;
    }	
	
	public function rankSubCatbusiness($zoneid){
    	$month = date('m');
    	$day = date('d');
    	$via = isset($_REQUEST['via'])?$_REQUEST['via']:'';
    	$order = isset($_REQUEST['order'])?$_REQUEST['order']:'';
    	$subcat = isset($_REQUEST['subcat'])?$_REQUEST['subcat']:'';
    	$adidimplode = implode(',',$order);
    	if(trim($day) == '01' || $via == 'zonedashboard'){
    		$sql="SELECT b.id,b.business_id FROM business_bid_detail as a INNER JOIN ads as b ON a.business_id=b.business_id WHERE a.zone_id='".$zoneid."' AND a.month='".$month."' AND b.id IN (".$adidimplode.") order by bid_amount DESC";
			$businessArr = $this->CommonController->SelectRawquery($sql,'resultArray');
			
			$bidsr = 0; $bidArr = [];
			$dealsr = 0; $dealArr = [];
			$ascsr = 0;
			$doscountArr = [];
			if(count($businessArr) > 0){
				foreach ($businessArr as $k => $v) {
					$bidsr++;
					$this->CommonController->updateData('business_sponsor_order_cat',['display_order'=>$bidsr],['adid' => $v['id'],'zoneid'=>$zoneid,'subcatid'=>$subcat]);
					$bidArr[] = $v['id'];
				}
			}

			$dealsr = $bidsr;
			$joinArr[] = ['table' => 'ads_setting_preferences as b','link' => 'a.id=b.businessid','type' => 'inner'];
			$joinArr[] = ['table' => 'users as c','link' => 'a.business_owner_id=c.id','type' => 'inner'];
			$joinArr[] = ['table' => 'tbl_member as d','link' => 'c.username=d.user_name','type' => 'inner'];
			$joinArr[] = ['table' => 'tbl_deals as e','link' => 'e.user_id=d.user_id','type' => 'inner'];
			$joinArr[] = ['table' => 'ads as f','link' => 'a.id=f.business_id','type' => 'inner'];
	  		
	  		$select = 'f.id as adid,a.id,e.deal_id,e.buy_price_decrease_by,e.current_price';
   	   		$where = ['b.settingszoneid' => $zoneid];
   	   		if(count($bidArr) > 0){
   	   			$whereNotIn = ['f.id'=>$bidArr];
   	   		}else{
   	   			$whereNotIn = [];
   	   		}
   	   		$adiddiff = array_diff($order,$bidArr);
			$whereIN = ['f.id' => $adiddiff];
   	   		$data = $this->CommonController->SelectJoinMulti('business as a', $joinArr,$where,$whereIN,[],$select,'','','',[],'','',$whereNotIn);
   	   		if(count($data) > 0){
   	   			foreach ($data as $k1 => $v1) {
   	   				$doscountArr[] =[
   	   					'adid'=> $v1->adid,
   	   					'maxdiscount' =>$v1->buy_price_decrease_by-$v1->current_price 
   	   				];
   	   			}
   	   			$price = array_column($doscountArr, 'maxdiscount');
        		array_multisort($price, SORT_DESC, $doscountArr);
        		foreach ($doscountArr as $k2 => $v2) {
        			$dealsr++;
        			$this->CommonController->updateData('business_sponsor_order_cat',['display_order'=>$dealsr],['adid' => $v2['adid'],'zoneid'=>$zoneid,'subcatid'=>$subcat]);
					$dealArr[] = $v2['adid'];
        		}
   	   		}
   	   		$ascsr = $dealsr;

			$joinArr1[] = ['table' => 'ads_setting_preferences as b','link' => 'a.id=b.businessid','type' => 'inner'];
			$joinArr1[] = ['table' => 'ads as c','link' => 'a.id=c.business_id','type' => 'inner'];
			$finalmerge = array_merge($dealArr,$bidArr);
			$adiddiff1 = array_diff($order,$finalmerge);
			if(count($dealArr) > 0){
   	   			$whereNotIn = ['c.id'=>$finalmerge];
   	   		}else{
   	   			$whereNotIn = [];
   	   		}
	  		
	  		$select = 'a.id,a.name,c.id as adid';
   	   		$where = ['b.settingszoneid' => $zoneid];
   	   		$whereIN = ['c.id' => $adiddiff1];
   	   		$dataend = $this->CommonController->SelectJoinMulti('business as a', $joinArr1,$where,$whereIN,[],$select,'','','',[],'','',$whereNotIn);
   	   		if(count($dataend) > 0){
   	   			$name = array_column($dataend, 'name');
        		array_multisort($name, SORT_ASC, $dataend);
   	   			foreach ($dataend as $k3 => $v3) {
   	   				$ascsr++;
   	   				$this->CommonController->updateData('business_sponsor_order_cat',['display_order'=>$ascsr],['adid' => $v3->adid,'zoneid'=>$zoneid,'subcatid'=>$subcat]);
   	   			}
   	   		}
   	   		if($via == 'zonedashboard'){
   	   			echo json_encode(['msg'=>'Re-Arrange Successfully','type'=>'success']);
   	   		}
   	   	}
    }
}