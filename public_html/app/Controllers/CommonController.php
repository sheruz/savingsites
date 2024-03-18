<?php
namespace App\Controllers;
require 'vendor/autoload.php';
require_once APPPATH . "/Libraries/PHPMailer-master/src/PHPMailer.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/Exception.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/SMTP.php";
use App\Libraries\IonAuth;
use Config\MyConfig;
use App\Models\zone\Zone_model;
use App\Models\admin\Business;
use App\Controllers\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Aws\S3\S3Client;
use Predis\Client;
#[\AllowDynamicProperties]
class CommonController extends BaseController{
    public function __construct(){
		$this->myconfig = new MyConfig;
    	$this->db = \Config\Database::connect();
    	$this->email = \Config\Services::email();
    	$this->ionAuth = new \IonAuth\Libraries\IonAuth();
    	$this->session = \Config\Services::session();
    	$this->Zone_model = new Zone_model();
    	$this->Business = new Business();
    	$this->email = \Config\Services::email();
    	$this->PHPMailer = new PHPMailer();
    	$this->Redis = new Client([
    		'host' 		=> '127.0.0.1',
    		'password' 	=> 'TIPSm@rk3t1ng!',
    		'port'		=> 6379,
    		'timeout'	=>0,
    		'database'	=>0
    	]);
    }

    public function redirectPage($path){
    	return redirect()->to($path);
    }

    public function SetCookie($name,$value,$expire,$domain,$path,$prefix,$extraname=''){
    	$cookie = array(
				'name'   => $name,
				'value'  => $value,
				'expire' => $expire,
				'domain' => $domain,
				'path'   => $path,
				'prefix' => $prefix,
				$extraname = $extraname,
			);
		set_cookie($cookie);	
    }    

    public function getCookie($name){
    	if(isset($_COOKIE[$name])){
			return $item = $_COOKIE[$name];	
    	}else{
    		return $item = '';
    	}
    }
    
    public function setSession($key, $value){
		$this->session->set($key,$value);
    }

    public function getSession($name){
    	return $item = $this->session->get($name);
    }

    public function destroySession(){
    	$this->session->destroy();
    }

    public function unsetSession($name){
    	$this->session->remove($name);
    }

    public function InsertData($table, $arr){
    	$this->db->table($table)->insert($arr);
		$id = $this->db->insertID();
    	return $id;
    }

    public function updateData($table,$arr,$where){
    	$builder = $this->db->table($table);
    	$builder->update($arr, $where);
		return 1;
	}

	public function deleteData($table,$where = [],$wherein = [],$type = ''){
    	$builder = $this->db->table($table);
    	if($type == 'whereIn'){
    		if(count($where) > 0){
    			foreach ($where as $column => $field) {
    				$builder->where($column, $field);
    			}
    		}
    		if(count($wherein) > 0){
    			foreach ($wherein as $column => $field) {
    				$builder->whereIn($column, $field);
    			}
    		}	
    		$builder->delete();
    	}else{
    		$builder->delete($where);
    	}
		return 1;
	}

    public function SelectJoinMulti($table, $joinArr = [], $where = [],$wherein = [], $orderby = [], $select = '',$lowerlimit = '',$upperlimit = '', $count = '',$like = [],$resulttype='',$groupby = '',$whereNotIn = []){
    	$builder = $this->db->table($table);
    	$builder->select($select);
    	if(count($where) > 0){
    		foreach ($where as $column => $field) {
    			$builder->where($column, $field);
    		}
    	}
    	if(count($wherein) > 0){
    		foreach ($wherein as $column => $field) {
    			$builder->whereIn($column, $field);
    		}
    	}
    	if(count($whereNotIn) > 0){
    		foreach ($whereNotIn as $column => $field) {
    			$builder->whereNotIn($column, $field);
    		}
    	}
    	if(count($joinArr) > 0){
    		foreach ($joinArr as $jcolumn => $jval) {
    			$builder->join($jval['table'], $jval['link'], $jval['type']);
    		}
    	}
    	if(count($orderby) > 0){
    		foreach ($orderby as $column1 => $type) {
    			$builder->orderBy($column1, $type);
    		}
    	}
    	if($groupby != ''){
    		$builder->groupBy($groupby);
    	}
    	if(count($like) > 0){
    		foreach ($like as $lk => $lv) {
    			$builder->like($lv['column'], $lv['match'], $lv['type']);
			}
    	}
    	if($count == 'count'){
    		$data = $builder->countAllResults();
    	}else{
    		if($lowerlimit != '' && $upperlimit != ''){
    			$builder->limit($upperlimit, $lowerlimit);
    		}
			$query = $builder->get();
			if($resulttype == 'resultArray'){
				$data = $query->getResultArray();
			}else if($resulttype == 'row'){
				$data = $query->getRow();
			}else{
        		$data = $query->getResult();
        	}
    	}
       	return $data;
    }

    public function SelectDataMultiWay($table,$select,$type,$arr = [],$wherein = [], $groupby = '', $orderby = []){
    	if($type == 'column'){
    		$query = $this->db->table($table)->select($select)->where($arr)->get();
			return $column = $query->getRow($select);
		}
		if($type == 'rowArray'){
			if(count($orderby) > 0){
				$query = $this->db->table($table)->select($select)->where($arr)->groupBy($orderby['column'],$orderby['type'])->get();
				$data = $query->getRowArray();
				return $data;
			}else{
				$query = $this->db->table($table)->select($select)->where($arr)->get();
				$data = $query->getRowArray();
				return $data;
			}
		}
		if($type == 'result'){
			$query = $this->db->table($table)->select($select)->where($arr)->get();
			$data = $query->getResult();
			return $data;	
		}
		if($type == 'resultArray'){
			$query = $this->db->table($table)->select($select)->where($arr)->get();
			$data = $query->getResultArray();
			return $data;	
		}
		if($type == 'resultArrayG'){
			$query = $this->db->table($table)->select($select)->where($arr)->groupBy($groupby)->get();
			$data = $query->getResultArray();
			return $data;	
		}
		if($type == 'ArrayIn'){
			$query = $this->db->table($table)->select($select)->where($arr)->whereIn($wherein['column'],$wherein['param'])->get();
			$data = $query->getResultArray();
			return $data;	
		}
		if($type == 'ArrayInR'){
			if(count($arr) <= 0){
				$query = $this->db->table($table)->select($select)->whereIn($wherein['column'],$wherein['param'])->get();
				$data = $query->getResult();
				return $data;	
			}
		}
	}

    public function SelectRawquery($sql, $type = ''){
    	$query = $this->db->query($sql);
    	if($type == 'row'){
			return $result = $query->getRow();
    	}
    	if($type == 'rowArray'){
			return $result = $query->getRowArray();
    	}
    	if($type == 'result'){
			return $result = $query->getResult();
    	}
    	if($type == 'resultArray' || $type == ''){
			return $result = $query->getResultArray();
		}
		if($type == 'count'){
			return $result = $query->getNumRows();
		}
    }
	
	public function SendMail($fromemail,$to,$subject,$html){
		$mail_aws = $this->PHPMailer;
		$mail_aws->isSMTP();
		$mail_aws->setFrom('aws-marketplace@savingssites.com', 'SavingsSites');
		
		$mail_aws->Username   = 'aws-marketplace@savingssites.com';
		$mail_aws->Password   = 'romilisalsothebest@123';
		$mail_aws->Host       = 'smtp.office365.com';
		$mail_aws->Port       = 587;
		$mail_aws->SMTPAuth   = true;
		$mail_aws->SMTPSecure = 'tls';
		$mail_aws->addAddress($to);
		$mail_aws->msgHTML(true);
		$mail_aws->Subject    = $subject;
		$mail_aws->Body       =  $html;
		$mail_aws->CharSet="UTF-8";
		if($mail_aws->Send()){
			return 1;
		}else{
			return 0;
		}
		die;



















    	$fromemail= $this->myconfig->adminEmailId;
    	$this->email->setFrom($fromemail);
		$this->email->setTo($to);
		// $this->email->setCC('another@another-example.com');
		// $this->email->setBCC('them@their-example.com');
		$this->email->setSubject($subject);
		$this->email->setMessage($html);
		if($this->email->send()){
			return 1;
		}else{
			return 0;
		}
	}

	public function Uploadimage($zoneid,$location){
		$newfolder_name = $zoneid.'_'.time();
		$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
		$busid = isset($_REQUEST['busid'])?$_REQUEST['busid']:'';
		$deal_product_id = isset($_REQUEST['deal_product_id'])?$_REQUEST['deal_product_id']:'';
		if($type == 'business'){
			$locationpath = "./assets/SavingsUpload/".$location;
			if(is_dir($locationpath)==false){ mkdir($locationpath,0777);}

			$locationzonepath = "./assets/SavingsUpload/".$location."/".$busid."/";
			if(is_dir($locationzonepath)==false){mkdir($locationzonepath,0777);}
			$folder_path = "./assets/SavingsUpload/".$location."/".$busid."/";
			$folder_path1 = "./assets/SavingsUpload/".$location."/".$busid."/original/";
		}else{
			$locationpath = "./assets/SavingsUpload/".$location;
			if(is_dir($locationpath)==false){ mkdir($locationpath,0777);}
			$locationzonepath = "./assets/SavingsUpload/".$location."/".$zoneid."/";
			if(is_dir($locationzonepath)==false){mkdir($locationzonepath,0777);}
			$locationoriginal = "./assets/SavingsUpload/".$location."/".$zoneid."/original/";
			if(is_dir($locationoriginal)==false){mkdir($locationoriginal,0777);}
		
			$folder_path = "./assets/SavingsUpload/".$location."/".$zoneid."/";
			$folder_path1 = "./assets/SavingsUpload/".$location."/".$zoneid."/original/";	
		}
		$this->updateData('business',array('insert_via_csv'=> 0),['id'=>$busid]);
		$this->updateData('tbl_deals_products',array('insert_via_csv'=> 0),['deal_product_id'=>$deal_product_id]);
		$this->updateData('ads',array('insert_via_csv'=> 0),['business_id'=>$busid]);
		// foreach ($_FILES['file']['name'] as $k => $v) {
    		$filename = time().$_FILES['file']['name'];
    		$uploaded_file = $_FILES['file']['tmp_name'];
    		$img_ext = pathinfo($filename, PATHINFO_EXTENSION);
    		$size = getimagesize($uploaded_file);
    		$ratio = $size[0] / $size[1];
    		$dst_y = 0;
    		$dst_x = 0;
    		if($ratio > 1) {
      			$width = 700;
      			$height = 395;
     	 		$dst_y = (395 - $height) / 2;
    		} else {
      			$width = 700 * $ratio;
      			$height = 395;
      			$dst_x = (700 - $width) / 2;
    		}
    		// $src = imagecreatefromstring(file_get_contents($uploaded_file));
    		// $dst = imagecreatetruecolor($width, $height);
      //      		imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
      //      		imagejpeg($dst, $folder_path. $filename);
    		if(move_uploaded_file($uploaded_file, $folder_path.$filename)){

      			echo json_encode(['msg' => 'Image Uploaded Successfully','type' => 'success','data'=>$filename]);
      			die;
    		}
  		// }
  	}

  	public function downloadcsv(){
  		$csvpath = isset($_REQUEST['csvpath'])?$_REQUEST['csvpath']:'';
  		  $delimiter = ","; 
        $filename = "dealssellreport" . date('Y-m-d') . ".csv"; 
        $f = fopen('php://memory', 'w');
  			$pbcashqry="SELECT
			a.busId,e.userId,e.amountPrchased as purchasedprice,e.purchasedAt,e.user_type,a.id as metaid, a.totalamount as dealamounnt, a.discount as dealdiscount,a.amountPurchased as dealactual_price,a.dealId,b.start_date, b.end_date,b.created_date,b.auction_type,b.status,b.deal_title,b.deal_description,c.card_img,c.publisher_fee,c.seller_fee,d.email,d.first_name,d.last_name,d.Gender,d.phone,d.Address,c.numberofconsolation,b.current_price,b.buy_price_decrease_by,c.company_name FROM tbl_deals_purchased_meta as a 
 			INNER JOIN tbl_deals as b ON a.dealID=b.deal_id 
			INNER JOIN tbl_deals_products as c ON b.product_id=c.deal_product_id 
			INNER JOIN users as d ON d.id=a.userId
			INNER JOIN tbl_deals_purchased as e ON e.userId=a.userId
 			GROUP BY b.deal_id";
		$purchasedealArr = $this->SelectRawquery($pbcashqry,'resultArray');
		
		$fields = array('Business name', 'user name', 'Address', 'Email', 'Phone', 'Deal Id', 'Deal Title', 'Deal Description', 'Deal Start Date', 'Deal End Date', 'Deal Creation Date', 'Cert Value', 'Deal Auction Type', 'Deal Status', 'Deal Publisher Fee', 'Deal Seller Fee', 'Deal Price', 'Deal Purchased Date', 'Deal Amount', 'Deal Discount', 'Deal Actual Price'); 
        fputcsv($f, $fields, $delimiter); 
        foreach ($purchasedealArr as $k => $row) {
            $lineData = array($row['company_name'], $row['first_name'].' '.$row['last_name'], $row['Address'], $row['email'], $row['phone'], $row['dealId'], $row['deal_title'], $row['deal_description'], $row['start_date'], $row['end_date'], $row['created_date'], $row['buy_price_decrease_by'], $row['auction_type'], $row['status'], $row['publisher_fee'], $row['seller_fee'], $row['buy_price_decrease_by'], $row['purchasedAt'], $row['current_price'], $row['dealdiscount'], $row['dealamounnt']);  
            fputcsv($f, $lineData, $delimiter);  
        }
       
        
        fseek($f, 0); 
        header('Content-Type: text/csv'); 
        header('Content-Disposition: attachment; filename="' . $filename . '";'); 
        fpassthru($f); 
        exit;
  		
  	}

  	public function downloadorgcsv(){
  		$delimiter = ","; 
  		$csvmonth = $_REQUEST['month'];
  		$year=$_REQUEST['year'];
  		$zoneid=$_REQUEST['zone_id'];
  		$uid=$_REQUEST['zoneuserid'];
  		$nonfavperqry="SELECT nonfavorgper,id FROM  users WHERE  id='".$uid."'";
		$nonfavperArr = $this->SelectRawquery($nonfavperqry,'row');
		$nonfavper = isset($nonfavperArr->nonfavorgper)?$nonfavperArr->nonfavorgper:5;


		$filename = "organizationmonthlyfeereport_".$year."_".$csvmonth.".csv"; 
        $f = fopen('php://memory', 'w');
		
		$userorgquery="SELECT a.id as organization_id, a.name as orgname, b.first_name,b.last_name,b.phone,b.Address,b.City,b.email FROM organization as a INNER JOIN users as b ON a.userid=b.id WHERE b.Zone_ID = '".$zoneid."'";
		$userorgArr = $this->SelectRawquery($userorgquery);
		$resuserArr = $orgArr1 = [];
		$orgsr = 0;
		if(count($userorgArr) > 0){
			foreach ($userorgArr as $k => $v) {
				$userresqry="SELECT user_id as resuserid FROM  users_fav_org WHERE  org_id='".$v['organization_id']."' AND DATE_FORMAT(date,'%m') = '".$csvmonth."'";
				$userresArr = $this->SelectRawquery($userresqry,'row');
				$resuser = isset($userresArr->resuserid)?$userresArr->resuserid:'';
				if($resuser != ''){
					$resuserArr[] = $resuser;
				}else{
					$orgsr++;
				} 
				$favorgperqry="SELECT fee_per FROM  org_fee WHERE  zone_id='".$zoneid."' AND org_id='".$v['organization_id']."' AND user_id='".$resuser."'";
				$favorgperArr = $this->SelectRawquery($favorgperqry,'row');
				$orgper = isset($favorgperArr->fee_per)?$favorgperArr->fee_per:'';
				$userorgArr[$k]['resuser']  = $resuser;
				$userorgArr[$k]['orgper']  = $orgper;

				$pbcashqry="SELECT amountPurchased,purchasedAt FROM  tbl_deals_purchased_meta WHERE  zoneId='".$zoneid."' AND userId='".$resuser."' AND DATE_FORMAT(purchasedAt,'%m') = '".$csvmonth."'";
				$purchasedArr = $this->SelectRawquery($pbcashqry,'row');
				$userorgArr[$k]['resuserpurchasedAmount'] = isset($purchasedArr->amountPurchased)?$purchasedArr->amountPurchased:'';
				$userorgArr[$k]['purchasedAt'] = isset($purchasedArr->purchasedAt)?$purchasedArr->purchasedAt:'';
			}


			if(count($resuserArr) > 0){
				$implodeuser = implode(',', $resuserArr);
				$pbcashqry1="SELECT sum(amountPurchased) AS totalsum FROM  tbl_deals_purchased_meta WHERE  zoneId='".$zoneid."' AND userId NOT IN ('".$implodeuser."') AND DATE_FORMAT(purchasedAt,'%m') = '".$csvmonth."' GROUP BY zoneId";
			}else{
				$pbcashqry1="SELECT sum(amountPurchased) AS totalsum FROM  tbl_deals_purchased_meta WHERE  zoneId='".$zoneid."' AND DATE_FORMAT(purchasedAt,'%m') = '".$csvmonth."' GROUP BY zoneId";
			}
			
			$purchasedArr1 = $this->SelectRawquery($pbcashqry1,'row');
			$totaldealsamount = isset($purchasedArr1->totalsum)?$purchasedArr1->totalsum:0;
			$perorgcost1 = $totaldealsamount*$nonfavper/100;
			// echo $purchasedArr1->totalsum;
			// echo "<br>";
			// echo $nonfavper;
			// echo "<br>";
			// echo $orgsr;
			// die;
			$perorgcost = number_format($perorgcost1/$orgsr,2);
		}
		
		$fields = array('Organization Name','Organization Email','Organization Phone','Organization Fee'); 
        fputcsv($f, $fields, $delimiter); 
        foreach ($userorgArr as $k => $row) {
        	if($row['orgper'] > 0 && $row['resuserpurchasedAmount'] > 0){
        		$feeorg = $row['resuserpurchasedAmount']*$row['orgper']/100;
        	}else{
        		$feeorg = $perorgcost;
        	}
        	$lineData = array($row['orgname'], $row['email'],$row['phone'], number_format($feeorg,2));  
            fputcsv($f, $lineData, $delimiter);  
        }
        fseek($f, 0); 
        header('Content-Type: text/csv'); 
        header('Content-Disposition: attachment; filename="' . $filename . '";'); 
        fpassthru($f); 
        exit;
  	}

  	public function getLocationLatLong($address){
  		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&key=AIzaSyCvpVpr64JO4z3XY-sMoe2nX4wsKRxI-Zw";
        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);
        $latitude = $result['results'][0]['geometry']['location']['lat'];
        $longitude = $result['results'][0]['geometry']['location']['lng'];
        return array('lat'=>$latitude,'lng'=>$longitude);  
  	}

  	public function genEncCode(){
  		$sql = "SELECT distinct(settingszoneid ) as zoneId FROM ads_setting_preferences";
  		$data = $this->SelectRawquery($sql);
  		foreach ($data as $k => $v) {
  			$uniqid = uniqid();
			$rand_start = rand(1,5);
			$rand_8_char = substr($uniqid,$rand_start,8);

			$sql = "SELECT name FROM sales_zone WHERE id=".$v['zoneId']."";
			$d = $this->SelectRawquery($sql,'row');
			
			$sql = "SELECT zone_ecrypt_code FROM zoneEncrypt WHERE zone_id=".$v['zoneId']."";
  			$en = $this->SelectRawquery($sql,'row');
  			
  			$zoneName = isset($d->name)?$d->name:'';
  			$existsecryptcode = isset($en->zone_ecrypt_code)?$en->zone_ecrypt_code:'';
  			if($existsecryptcode != ''){
				$this->InsertData('zoneencrypt', ['zone_id'=>$v['zoneId'],'zone_name'=>$zoneName,'zone_ecrypt_code'=> $rand_8_char]);
  			}
  		}	
  	}

  	public function getAutoLogin(){
  		$Auth = new Auth();
  		$zoneid = $this->getCookie('subDomainZone');
  		$password = $this->getCookie('subDomainUserPass');
  		$username = $this->getCookie('subDomainUsername');
  		$password = base64_decode($password);
  		$user = $this->ionAuth->user()->row();
		$uid = 0;
		if(empty($user) && isset($username)){
  			$Auth->login_from_zone_page($username,$password,$zoneid,'commoncontroller');	
		}
	}

	public function delete_zone(){
		$zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:'';
		if($zoneid > 0){
			$srno = 0;
			$zonesql = "SELECT * FROM ads_setting_preferences WHERE settingszoneid=".$zoneid."";
  			$zonedata = $this->SelectRawquery($zonesql,'result');	
  			if(count($zonedata) > 0){
  				foreach ($zonedata as $k => $v) {
  					$srno++;
  					$bussql = "SELECT * FROM business WHERE id=".$v->businessid."";
  					$busArr = $this->SelectRawquery($bussql,'result');
					$this->deleteData('businesscreditcheck',['business_id' => $v->businessid]);
					$this->deleteData('businessphotos_display',['bus_id' => $v->businessid]);
					$this->deleteData('business_bid_detail',['business_id' => $v->businessid]);
					$this->deleteData('business_deal_approval',['businessId' => $v->businessid]);
					$this->deleteData('business_get_order',['businessid' => $v->businessid]);
					$this->deleteData('business_multiple_emails',['businessid' => $v->businessid]);
					$this->deleteData('business_newsletter',['businessid' => $v->businessid]);
					$this->deleteData('business_operation_hour',['business_id' => $v->businessid]);
					$this->deleteData('business_order_status',['businessid' => $v->businessid]);
					$this->deleteData('business_photos',['bus_id' => $v->businessid]);
					$this->deleteData('business_sponsor',['business_id' => $v->businessid]);
					$this->deleteData('business_sponsor_order',['business_id' => $v->businessid]);
					$this->deleteData('business_sponsor_order_subcat',['bussiness_id' => $v->businessid]);
					$adssql = "SELECT * FROM ads WHERE business_id=".$v->businessid."";
  					$adsArr = $this->SelectRawquery($adssql,'result');
  					if(count($adsArr) > 0){
  						$adid = isset($adsArr[0]->id)?$adsArr[0]->id:'';
  						if($adid != ''){
  							$this->deleteData('ads',['id' => $adid]);
  							$this->deleteData('business_sponsor_order_cat',['adid' => $adid]);
  						}
  					}
					if(count($busArr) > 0){
						$addressid = isset($busArr[0]->addressid)?$busArr[0]->addressid:'';
						if($addressid != ''){
							$this->deleteData('address',['id' => $addressid]);	
						}

  						$userid = isset($busArr[0]->business_owner_id)?$busArr[0]->business_owner_id:'';
  						if($userid != ''){
							$usersql = "SELECT * FROM users WHERE id=".$userid."";
  							$userArr = $this->SelectRawquery($usersql,'result');
  							if(count($userArr) > 0){
  								$username = isset($userArr[0]->username)?$userArr[0]->username:'';
  								if($username != ''){
  									$tblsql = "SELECT * FROM tbl_member WHERE user_name=".$username."";
  									$tblArr = $this->SelectRawquery($tblsql,'result');
  									if(count($tblArr) > 0){
  										$user_id = isset($tblArr[0]->user_id)?$tblArr[0]->user_id:'';
  										if($user_id != ''){
  											$this->deleteData('tbl_deals',['user_id' => $user_id]);
  											$this->deleteData('tbl_deals_products',['user_id' => $user_id]);
  										}
  										$this->deleteData('tbl_member',['user_id' => $user_id]);
  									}
  								}

  								$this->deleteData('tbl_deals_purchased',['userId' => $userid]);
  								$this->deleteData('tbl_deals_purchased_meta',['userId' => $userid]);
  								$this->deleteData('users',['id' => $userid]);
  								$this->deleteData('users_groups',['user_id' => $userid]);
  							}
  						}
  					}
  				}
  				$this->deleteData('ads_setting_preferences',['settingszoneid' => $zoneid]);
  				echo $srno;
  			}
		}


		if($zoneid > 0){
			$salessql = "SELECT * FROM sales_zone WHERE id=".$zoneid."";
  			$salessqlArr = $this->SelectRawquery($salessql,'result');
  			if(count($salessqlArr) > 0){
  				$salesuserid = isset($salessqlArr[0]->sales_rep_id)?$salessqlArr[0]->sales_rep_id:'';
  				if($salesuserid > 0){
					$salesusersql = "SELECT * FROM users WHERE id=".$salesuserid."";
  					$salesuserArr = $this->SelectRawquery($salesusersql,'result');
  					if(count($salesuserArr) > 0){
  						$salesusername = isset($salesuserArr[0]->username)?$salesuserArr[0]->username:'';
  						if($salesusername != ''){
  							$salestblsql = "SELECT * FROM tbl_member WHERE user_name='".$salesusername."'";
  							$salestblArr = $this->SelectRawquery($salestblsql,'result');
  							if(count($salestblArr) > 0){
  								$salesuser_id = isset($salestblArr[0]->user_id)?$salestblArr[0]->user_id:'';
  								if($salesuser_id != ''){
  									$this->deleteData('tbl_deals',['user_id' => $salesuser_id]);
  									$this->deleteData('tbl_deals_products',['user_id' => $salesuser_id]);
  								}
  								$this->deleteData('tbl_member',['user_id' => $salesuser_id]);
  							}
  						}
						$this->deleteData('tbl_deals_purchased',['userId' => $salesuserid]);
  						$this->deleteData('tbl_deals_purchased_meta',['userId' => $salesuserid]);
  						$this->deleteData('users',['id' => $salesuserid]);
  						$this->deleteData('users_groups',['user_id' => $salesuserid]);
  					}
  					$this->deleteData('sales_zone',['id' => $zoneid]);
  				}
  			}
		}
		echo "Please select Zone ID";
	}

	public function getStoreCache($sql,$type,$key,$time){
		$key = $this->Redis->get($key);
		if($key === null){
			$data = $this->SelectRawquery($sql,$type);
			$dataserialize = serialize($data);
			$this->Redis->setex($key,$time,$dataserialize);
		}else{
			$datajson = $this->Redis->get($key);
			$data = unserialize($datajson);
		}
		return $data;
	}
}

