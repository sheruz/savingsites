<?php
namespace App\Controllers;
require_once APPPATH . "/Libraries/PHPMailer-master/src/PHPMailer.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/Exception.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/SMTP.php";
require 'vendor/autoload.php';
// require 'aws-sdk-php-master/src/S3/S3Client.php';

use App\Libraries\IonAuth;
use Config\MyConfig;
use App\Models\zone\Zone_model;
use App\Models\admin\Business;
use App\Models\admin\Sales_zone;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\admin\Category_management_model;
use App\Models\Organization_model;
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
    public function InsertSubUserData($table,$username,$meta_key,$meta_value){
    	$this->db->table($table)->insert(['username'=>$username,'meta_key'=>$meta_key,'meta_value'=>$meta_value]);
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

    public function getsinglecolumndata($table,$column,$wherecolumn,$wheredata){
    	$sql = "SELECT ".$column." FROM ".$table." WHERE ".$wherecolumn."=".$wheredata."";
		$arr = $this->SelectRawquery($sql,'row');
		return $singlecolumn = isset($arr->$column)?$arr->$column:'';
    }
	
	public function SendMail($fromemail,$to,$subject,$html){
		$mail_aws = $this->PHPMailer;
		$mail_aws->isSMTP();
		$mail_aws->clearAllRecipients();
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
			// $mail_aws->clearAllRecipients();
			return 1;
		}else{
			return 0;
		}
		die;

	}

	public function sendemailssl($fromemail,$email,$template_subject,$message_body){
		$fromemail=$this->myconfig->adminEmailId;
        $this->email->setFrom($fromemail);
		$this->email->setSubject($template_subject);
		$this->email->setMessage($message_body);
		$this->email->setTo($email);
		$this->email->send();
	}

	public function Uploadimage($zoneid,$location){
		$type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
		$busid = isset($_REQUEST['busid'])?$_REQUEST['busid']:'';
		$deal_product_id = isset($_REQUEST['deal_product_id'])?$_REQUEST['deal_product_id']:'';
		if($type == 'business'){
			$locationpath = "./assets/SavingsUpload/".$location;
			if(is_dir($locationpath)==false){ mkdir($locationpath,0777);}
			$locationzonepath = "./assets/SavingsUpload/".$location."/".$busid."/";
			if(is_dir($locationzonepath)==false){mkdir($locationzonepath,0777);}
			$locationzonepath1 = "./assets/SavingsUpload/".$location."/".$busid."/resizeimages";
			if(is_dir($locationzonepath1)==false){mkdir($locationzonepath1,0777);}
			$folder_path = "./assets/SavingsUpload/".$location."/".$busid."/";
			$delete_folder_path = "/assets/SavingsUpload/".$location."/".$busid."/";
			$folder_path1 = "./assets/SavingsUpload/".$location."/".$busid."/resizeimages/";
		}else{
			$locationpath = "./assets/SavingsUpload/".$location;
			if(is_dir($locationpath)==false){ mkdir($locationpath,0777);}
			$locationzonepath = "./assets/SavingsUpload/".$location."/".$zoneid."/";
			if(is_dir($locationzonepath)==false){mkdir($locationzonepath,0777);}
			$locationoriginal = "./assets/SavingsUpload/".$location."/".$zoneid."/resizeimages/";
			if(is_dir($locationoriginal)==false){mkdir($locationoriginal,0777);}
			$folder_path = "./assets/SavingsUpload/".$location."/".$zoneid."/";
			$delete_folder_path = "/assets/SavingsUpload/".$location."/".$zoneid."/";
			$folder_path1 = "./assets/SavingsUpload/".$location."/".$zoneid."/resizeimages/";	
		}
		$this->updateData('business',array('insert_via_csv'=> 0),['id'=>$busid]);
		$this->updateData('tbl_deals_products',array('insert_via_csv'=> 0),['deal_product_id'=>$deal_product_id]);
		$this->updateData('ads',array('insert_via_csv'=> 0),['business_id'=>$busid]);
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
    	}else{
      		$width = 700 * $ratio;
      		$height = 395;
      		$dst_x = (700 - $width) / 2;
    	}
    	$src = imagecreatefromstring(file_get_contents($uploaded_file));
    	$dst = imagecreatetruecolor($width, $height);
           	imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
           	// imagejpeg($dst, $resizeimages. $filename);
    	if(move_uploaded_file($uploaded_file, $folder_path.$filename)){
    		$resname = $this->uploadtoaws($folder_path, $filename);
    		unlink($_SERVER['DOCUMENT_ROOT'].$delete_folder_path.$filename);
      		echo json_encode(['msg' => 'Image Uploaded Successfully','type' => 'success','data'=>$filename,'awsname'=> $resname]);
      		die;
    	}
  	}

  	public function uploadtoaws($path, $image_name){
  		$name = '';
  		$s3Client = new S3Client([
      		'version' => 'latest',
      		'region'  => 'us-east-1',
      		'credentials' => [
        	'key'    => 'AKIAUHVG6DYZU6ONYGTZ',
        	'secret' => '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'
      		]
    	]);
		
		$supported_format = array('gif','jpg','jpeg','png','webp','svg');
        $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $bucket = 'savingssites';
        $file_Path = $path.$image_name;
        $k = basename($file_Path);
        $key = str_replace(' ', '', $k);
		
		try {
        	$result = $s3Client->putObject([
              'Bucket' => $bucket,
              'Key'    => $key,
              'Body'   => fopen($file_Path, 'r'),
            ]);
            $name = basename($result->get('ObjectURL'));
        }catch(Aws\S3\Exception\S3Exception $e) {}
        return $name;
  	}

  	public function deletetoaws($image_name){
  		$bucket = 'savingssites';
  		$s3Client = new S3Client([
    		'version'     => 'latest',
    		'region'      => 'us-east-1',
    		'credentials' => [
        		'key'    => 'AKIAUHVG6DYZU6ONYGTZ',
        		'secret' => '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',
    		],
    	]);
		try {
    		$result = $s3Client->deleteObject(array(
        		'Bucket' => $bucket,
        		'Key'    => $image_name
        	)); 
        	return 1;
    	} catch (S3Exception $e) {
        	return $e->getMessage() . PHP_EOL;
    	}
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
  		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false&key=AIzaSyAEQMa2LNksZ5nY-BbeiyZyaSa-IplsE8M";
        $result_string = @file_get_contents($url);
        $result = json_decode($result_string, true);
        if(count($result['results'])!= 0){
        	$latitude = $result['results'][0]['geometry']['location']['lat'];
	        $longitude = $result['results'][0]['geometry']['location']['lng'];
	        return array('lat'=>$latitude,'lng'=>$longitude);  	
        }
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
  	public function redirectToBusiness(){
		$url = $_SERVER['SERVER_NAME'];
        $parsedUrl = parse_url($url);
        $host = explode('.', $parsedUrl['path']);
        $subdomain = $host[0];
        $zonename = $subdomain;
        $sql = "SELECT * FROM sales_zone WHERE subdomain LIKE '%".$zonename."%'";
        $data = $this->SelectRawquery($sql,'row');
        if($data == ''){
        	throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        	die;
        }
        return $id = isset($data->id)?$data->id:'';
    }

    public function redirectToZone(){
		$url = $_SERVER['SERVER_NAME'];
        $parsedUrl = parse_url($url);
        $host = explode('.', $parsedUrl['path']);
        $subdomain = $host[0];
        $zonename = $subdomain;
        $sql = "SELECT * FROM sales_zone WHERE subdomainZone='".$zonename."'";
        $data = $this->getStoreCache($sql,'row','subdomainzonename',3600);
        if($data == ''){
        	throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        	die;
        }
        return $id = isset($data->id)?$data->id:'';
    }
	
	public function redirectToBusinessdetail(){
		$url = $_SERVER['SERVER_NAME'];
        $parsedUrl = parse_url($url);
        $host = explode('.', $parsedUrl['path']);
        $subdomain = $host[0];
        $zonename = $subdomain;
        $sql = "SELECT * FROM sales_zone WHERE subdomain = '".$zonename."'";
        $data = $this->SelectRawquery($sql,'row');
        if($data == ''){
        	throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        	die;
        }
        return $id = isset($data->id)?$data->id:'';
    }

    public function getAutoLogin($subuseremail = ''){
  		$Auth = new Auth();
  		$zoneid = $this->getCookie('subDomainZone');
  		$password = $this->getCookie('subDomainUserPass');
  		$username = $this->getCookie('subDomainUsername');
  		$userId = $this->getCookie('subDomainUserId');
  		$zoneName = $this->getCookie('subDomainZoneName');
  		$password = base64_decode($password);
  		$userscrapId = isset($_REQUEST['userId'])?$_REQUEST['userId']:'';
  		$userscrapzoneName = isset($_REQUEST['zoneName'])?$_REQUEST['zoneName']:'';

  		$user = $this->ionAuth->user()->row();
		$uid = 0;
		$SalesZone = new Sales_zone();
	 
		if(empty($user) && $userscrapzoneName != ''){
			$sql="SELECT username, email, id, password, active, last_login, first_name, last_name FROM users WHERE id='".$userscrapId."'";
			$user = $this->SelectRawquery($sql,'row');
			$sales_zonesql="SELECT * FROM sales_zone WHERE sales_rep_id='".$user->id."'";
			$sales_zonedata = $this->SelectRawquery($sales_zonesql,'row');
			$zone_id = isset($sales_zonedata->id)?$sales_zonedata->id:'';
			if($user != ''){
				$session_data = array(
					'identity' => '',
					'username' => $user->username,
					'email' => $user->email,
					'user_id' => $user->id,
					'old_last_login' => $user->last_login
				);

				$this->session->set($session_data);
			}
			$zones = $SalesZone->zone_owner_login($userscrapId);

			if(!empty($zones)){
				$session_zoneid = array(                   		
					'userzoneid'=>$zone_id,
					'sesuserid'=>$userscrapId
				);
				$this->setSession('session_zoneid', $session_zoneid);
			}
			$this->setSession('session_login_details', array('type'=>4,'id'=>$zone_id));
			if($subuseremail != ''){
				$scrapurl = base_url().'/Zonedashboard/zoneinformation?subuser='.$subuseremail.'';
			}else{
				$scrapurl = base_url().'/Zonedashboard/zoneinformation/'.$zone_id;
			}
			return $scrapurl;
		}

		if(empty($user) && isset($username)){
			$Auth->login_from_zone_page($username,$password,$zoneid,'commoncontroller');	
		}	
  	}

  	public function getAutoLoginbusiness($subuseremail = ''){
  		$SalesZone = new Sales_zone();
  		$userquery="SELECT * FROM zone_users WHERE username='".$subuseremail."' AND type='business'";
		$businessrankbid = $this->SelectRawquery($userquery);
		$userId = isset($businessrankbid[0]['zoneowner'])?$businessrankbid[0]['zoneowner']:'';
		if($userId != ''){
  			$user = $this->ionAuth->user()->row();
  			if(empty($user)){
  				$sql="SELECT username, email, id, password, active, last_login, first_name, last_name FROM users WHERE id='".$userId."'";
				$user = $this->SelectRawquery($sql,'row');
				$sales_zonesql="SELECT * FROM sales_zone WHERE sales_rep_id='".$user->id."'";
				$sales_zonedata = $this->SelectRawquery($sales_zonesql,'row');
				$zone_id = isset($sales_zonedata->id)?$sales_zonedata->id:'';
				if($user != ''){
					$session_data = array(
						'identity' => '',
						'username' => $user->username,
						'email' => $user->email,
						'user_id' => $user->id,
						'old_last_login' => $user->last_login
					);
					$this->session->set($session_data);
				}
				$zones = $SalesZone->zone_owner_login($userId);
				if(!empty($zones)){
					$session_zoneid = array(                   		
						'userzoneid'=>$zone_id,
						'sesuserid'=>$userId
					);
					$this->setSession('session_zoneid', $session_zoneid);
				}

				$businessDetails = $this->Business->getBusinessByOwnerUserId($userId);
				$businesses = $this->Business->get_all_businesses_for_user($userId);
				if(!empty($businesses)){				
					$bid = $businesses[0]['id'];
					$zoneid=$businesses[0]['id'];
					$business_authentication=$this->Business->check_business_authentication($bid); 
					$session_login_details = array('type'=>16,'id'=>$bid);
					$this->setSession('session_zoneid', $zoneid);
					$this->setSession('session_login_details', $session_login_details);
				}
  			}
  		}
  	}
	
	public function check_athena_multiplelogin($arr = []){
		$SalesZone = new Sales_zone();
		$session_data = array(
			'identity' => 'username',
			'username' => $arr->username,
			'email' => $arr->email,
			'user_id' => $arr->user_id,
			'old_last_login' => $arr->last_login
		);
		$this->session->set($session_data);			
		$zones = $SalesZone->zone_owner_login($arr->user_id);
		if(!empty($zones)){
			$session_zoneid = array(                   		
				'userzoneid'=>$zid,
				'sesuserid'=>$arr->user_id
			);
			$this->setSession('session_zoneid', $session_zoneid);
		}
	}

	public function getbusinessloginbutton($user_id){
		$groupArr = [];
		$userqry = "select a.*,b.*,a.id as useraid from users as a inner join users_groups as b on a.id = b.user_id where a.id = ".$user_id."";
        $userres = $this->SelectRawquery($userqry,'row');
        if($userres != ''){
            $phonelogin = isset($userres->phone)?$userres->phone:'';
            $emaillogin = isset($userres->email)?$userres->email:'';
            $group_idlogin = isset($userres->group_id)?$userres->group_id:'';
            if($phonelogin != '' && $emaillogin != ''){
            	$userphoneqry = "select a.id,b.group_id from users as a inner join users_groups as b on a.id = b.user_id where a.phone = ".$phonelogin." and a.email='".$emaillogin."' and b.group_id Not IN (".$group_idlogin.")";
            }else if($phonelogin == '' && $emaillogin != ''){
            	$userphoneqry = "select a.id,b.group_id from users as a inner join users_groups as b on a.id = b.user_id where a.email='".$emaillogin."' and b.group_id Not IN (".$group_idlogin.")";
            }else if($phonelogin != '' && $emaillogin == ''){
            	$userphoneqry = "select a.id,b.group_id from users as a inner join users_groups as b on a.id = b.user_id where a.phone = ".$phonelogin." and b.group_id Not IN (".$group_idlogin.")";
            }
            $userphoneres = $this->SelectRawquery($userphoneqry);
            foreach ($userphoneres as $k1 => $v1) {
                $groupArr[$v1['group_id']] = $v1['group_id'];
            }
        }
        return array('groupArr'=>$groupArr,'phonelogin'=>$phonelogin,'emaillogin'=>$emaillogin);
	}

	
	public function singleloginmultiuser(){
		$zoneid = $this->redirectToZone();
		$msg = ['msg'=>'Something Went Wrong','type'=>'warning','id'=>'','zone'=>''];
		$phone = isset($_REQUEST['phone'])?$_REQUEST['phone']:'';
		$email = isset($_REQUEST['email'])?$_REQUEST['email']:'';
		$group = isset($_REQUEST['group'])?$_REQUEST['group']:'';
		$Category_management_model = new Category_management_model();
		$qry="SELECT a.id as user_id,a.username,a.email,a.id,a.last_login,b.group_id,c.id as zoneid,c.name FROM users as a INNER JOIN  users_groups as b ON a.id=b.user_id LEFT JOIN sales_zone as c ON a.id=c.sales_rep_id where a.phone = ".$phone." and a.email='".$email."' and b.group_id=".$group."";
		$data = $this->SelectRawquery($qry,'row');
		$this->check_athena_multiplelogin($data);
		$auser = $this->ionAuth->user()->row();
		$this->ionAuth->update_last_login($auser->id);
		$this->ionAuth->increase_login_attempts($auser->username);
		if($group==5){ 
			$businessDetails = $this->Business->getBusinessByOwnerUserId($auser->id);
			$businesses = $this->Business->get_all_businesses_for_user($auser->id);
			$bid = $businesses[0]['id'];
			$zoneid=$businesses[0]['id'];
			$business_authentication=$this->Business->check_business_authentication($bid); 
			$session_login_details = array('type'=>$group,'id'=>$bid);
			$this->setSession('session_zoneid', $zoneid);
			$this->setSession('session_login_details', $session_login_details);
			$msg = ['msg'=>'Login Successful Redirect to Business Dashboard','type'=>'success','id'=>$bid,'zone'=>''];
		}else if($group==10 || $group==7 || $group==15){ 
			$this->setSession('session_normal_user_in_zone', array('sesuserzone'=>$zoneid,'sesusertype'=>'resident_user' , 'usertype' =>$group), 'array');
			$this->setSession('session_login_details', array('id'=>$auser->id,'type'=>'resident_user' ,'type' =>$group,'zone' =>$zoneid,'sesuserzone'=>$zoneid), 'array');
			$this->setSession('session_zoneid', $zoneid);
			$update_zone_menu=$Category_management_model->update_zone_menu($zoneid);	
			$msg = ['msg'=>'Login Successful','type'=>'success','id'=>'','zone'=>''];
		}else if($group==8){
			$Organization_model = new Organization_model();
			$organization=$this->ionAuth->check_organization($auser->id);	
			$session_zoneid = array(                   		
				'userzoneid'=>$zoneid,
				'sesuserid'=>$auser->id
			);
			$this->setSession('session_zoneid', $session_zoneid);
			$this->setSession('session_orgid', array('sesorgid'=>$organization[0]['id']));
			$this->setSession('session_login_details', array('type'=>$group,'id'=>$organization[0]['id']));
			$organizationDetails = $Organization_model->getOrganizationDetailsByOwnerId($auser->id);
			$msg = ['msg'=>'Login Successful Redirect to Organization Dashboard','type'=>'success','id'=>$organization[0]['id'],'zone'=>$organization[0]['zoneid']];
		}
		echo json_encode($msg);
	}

	public function get1dealreferdata($auser_id =  '',$olduser = ''){
		$olduser = isset($_REQUEST['refdealuser'])?$_REQUEST['refdealuser']:$olduser;
		$username = isset($_REQUEST['username'])?$_REQUEST['username']:$auser_id;
		$logintype = isset($_REQUEST['logintype'])?$_REQUEST['logintype']:'';

		if($logintype == 10){
			$qry = "select * from users where username='".$username."'";
 			$preuserdata = $this->SelectRawquery($qry, 'row');
 			$auser_id = isset($preuserdata->id)?$preuserdata->id:'';	
		}
		$check_refer = "select * from user_refer_meta where gen_user_id=".$auser_id." AND from_user=".$olduser."";
		$preinsertdata = $this->SelectRawquery($check_refer, 'count');
		if($preinsertdata <= 0){
			$insertArr = array('gen_user_id' => $auser_id,'from_user' => $olduser,'receive_amount' => 1,'amountused'=>'no','datainserted'=>1);
			$getprev_amount = "select * from users where id=".$olduser;
 			$preuserdata = $this->SelectRawquery($getprev_amount, 'row');
 			$prev_amount = isset($preuserdata->free_cert_amount)?$preuserdata->free_cert_amount:0;
			$this->InsertData('user_refer_meta', $insertArr);
			$refdealuser = 0;
		}
	}

	public function getsponserdata($zoneid,$no){
  		$sectiondata = '';
		$sql1="select * from tbl_keys_awssponser where zoneid=".$zoneid." AND counter=".$no." AND sponseractive=1 LIMIT 5";
 		$sponserbannerdata = $this->SelectRawquery($sql1,'row');
 		
 		$bannerimage = isset($sponserbannerdata->image)?$sponserbannerdata->image:'';
  		$bannertext = isset($sponserbannerdata->text)?$sponserbannerdata->text:'';
  		if($bannerimage != ''  && $bannertext != ''){
  			$sectiondata = "<div style='width:100%;max-width: 650px;margin:0px auto 30px;'>
            	<p><img style='width:100%;height:250px;object-fit: cover;' src='https://cdn.savingssites.com/".$bannerimage."'/></p>
        		<p class='police-ttl2 fontkaint' style='padding: 0;margin: 0; text-align: left;color: #000;font-size: 25px; font-weight: 500;'>Message From The Publisher</p>
        		<p class='police-ttl fontkaint' style='padding: 0;margin: 0;text-align: left;color: #333;font-size: 17px; font-weight: 400;'>".$bannertext."</p>
    		</div>";
  		}else if($bannerimage != ''  && $bannertext == ''){
  			$sectiondata = "<div style='width:100%;max-width: 650px;margin:0px auto 30px;'>
            	<p><img style='width:100%;height:250px;object-fit: cover;' src='https://cdn.savingssites.com/".$bannerimage."'/></p>
    		</div>";
  		}else if($bannerimage == ''  && $bannertext != ''){
  			$sectiondata = "<div style='width:100%;max-width: 650px;margin:0px auto 30px;'>
        		<p class='police-ttl2 fontkaint' style='padding: 0;margin: 0; text-align: left;color: #000;font-size: 25px; font-weight: 500;'>Message From The Publisher</p>
        		<p class='police-ttl fontkaint' style='padding: 0;margin: 0;text-align: left;color: #333;font-size: 17px; font-weight: 400;'>".$bannertext."</p>
    		</div>";
  		}
  		return $sectiondata;
  	}

  	public function getStoreCache($sql,$type,$key,$time){
  		// return $data = $this->SelectRawquery($sql,$type);
  		// $key = $this->Redis->get($key);
		// if($key === null){
			$data = $this->SelectRawquery($sql,$type);
		// 	$dataserialize = serialize($data);
		// 	$this->Redis->setex($key,$time,$dataserialize);
		// }else{
		// 	$datajson = $this->Redis->get($key);
		// 	$data = unserialize($datajson);
		// }
		return $data;
	}

	public function getcurrentdayid(){
		$date = strtotime(date('Y-m-d'));
		$day = date('l', $date);
		if($day == 'Monday')	{$daydb = 1;}
		if($day == 'Tuesday')	{$daydb = 2;}
		if($day == 'Wednesday')	{$daydb = 3;}
		if($day == 'Thursday')	{$daydb = 4;}
		if($day == 'Friday')	{$daydb = 5;}
		if($day == 'Saturday')	{$daydb = 6;}
		if($day == 'Sunday')	{$daydb = 7;}

		return $daydb;
	}

	public function getdealurlusingzone($zoneid){
		$qry = "select * from sales_zone where id='".$zoneid."'";
	    $zonedata = $this->getStoreCache($qry,'row','businesssearchdealuserzonedata',3600);
	    $subdomaindeal = $zonedata->subdomain;
	    $host = $_SERVER['HTTP_HOST'];
        $explodehost = explode('.', $host);
        if(in_array('loc', $explodehost)){
        	$dealurl = 'https://'.$subdomaindeal.'.savingssites.loc';
        }else if(in_array('qa', $explodehost)){
       		$dealurl = 'https://'.$subdomaindeal.'.qa.savingssites.com';
        }else{
        	$dealurl = 'https://'.$subdomaindeal.'.savingssites.com';
        } 
		return $dealurl;
	}	

	public function getzoneurlusingzone($zoneid){
		$qry = "select * from sales_zone where id='".$zoneid."'";
	    $zonedata = $this->getStoreCache($qry,'row','businesssearchdealuserzonedata',3600);
	    $subdomaindeal = $zonedata->subdomainZone;
	    $host = $_SERVER['HTTP_HOST'];
        $explodehost = explode('.', $host);
        if(in_array('loc', $explodehost)){
        	$dealurl = 'https://'.$subdomaindeal.'.savingssites.loc';
        }else if(in_array('qa', $explodehost)){
       		$dealurl = 'https://'.$subdomaindeal.'.qa.savingssites.com';
        }else{
        	$dealurl = 'https://'.$subdomaindeal.'.savingssites.com';
        } 
		return $dealurl;
	}

	public function getuserdetail($id){
		$sql="select * from users where id=".$id;
 		return $this->SelectRawquery($sql,'row');
	}

	public function getbusinessdetaildata($id){
		$sql = "select * from business as a INNER JOIN address as b ON b.id=a.addressid where a.id = ".$id;
		return $this->SelectRawquery($sql,'row');
	}

	public function getsnaptimearr($table,$userid,$zoneid,$finalsnapbusArr,$busid){
		$daydb = $this->getcurrentdayid();
		$qry = "SELECT * FROM ".$table." WHERE user_id=".$userid." AND created_for_zone=".$zoneid." AND snap_week_days=".$daydb."";
    	$arr = $this->SelectRawquery($qry,'result');
    	$sendtype = [];
    	$total = 0;
    	if(count($arr) > 0){
    		foreach ($arr as $k => $v) {
        		if(isset($v->snap_time) && $v->snap_time != ''){
        			$snaptimeArrdata = json_decode($v->snap_time);
        			foreach ($snaptimeArrdata as $k1 => $v1) {
        				$sendtype[] = isset($finalsnapbusArr[$busid][$daydb][$v1->starttimearr][$v1->endtimearr])?$finalsnapbusArr[$busid][$daydb][$v1->starttimearr][$v1->endtimearr]:'';
        			}
        		}
        	}
        }
        if(count($sendtype) > 0){
        	$total = array_sum($sendtype);
        }
        return $total;
	}

	public function check_user_type($id){
		$sql = "SELECT group_id FROM users_groups where user_id=".$id;
		return $this->SelectRawquery($sql);
	}

	public function getdealsbybusiness($busid){
		$current_date = date('Y-m-d');
		$finalArr = [];
		$userid = $this->getsinglecolumndata('business','business_owner_id','id',$busid);
		if($userid > 0){
			$username = $this->getsinglecolumndata('users','username','id',$userid);
			if($username != ''){
				$tbl_userid = $this->getsinglecolumndata('tbl_member','user_id','user_name',$username);
				if($tbl_userid != ''){
					$qry = "SELECT * FROM tbl_deals b INNER JOIN tbl_deals_products d ON b.user_id=d.user_id and b.status IN('Live') and b.user_id=".$tbl_userid." and d.user_id=".$tbl_userid." and b.product_id=d.deal_product_id and ('".$current_date."' BETWEEN b.start_date AND DATE_FORMAT( b.end_date, '%Y-%m-%d')) group by b.deal_id";
						$finalArr = $this->SelectRawquery($qry, 'resultArray');  
            
				}
			}
		}
		return $finalArr;
	}

	public function getplaces($search){
		$dataArr = [];
		$data = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=".urlencode($search)."&key=AIzaSyAEQMa2LNksZ5nY-BbeiyZyaSa-IplsE8M";
        $result_string = @file_get_contents($data);
        $result = json_decode($result_string, true);
        if(count($result) > 0){
        	foreach ($result['results'] as $k => $v) {
        		$dataArr[] = [
        			'formatted_address' => $v['formatted_address'],
        			'lat' => $v['geometry']['location']['lat'],
        			'lng' => $v['geometry']['location']['lng'],
        		];
        	}
        }
        return $dataArr;

	}

	public function getzonebusiness(){
		$search = isset($_REQUEST['search'])?$_REQUEST['search']:'';
		$zoneid = isset($_REQUEST['zoneid'])?$_REQUEST['zoneid']:'';
		$qry = "SELECT b.id,b.name FROM `ads_setting_preferences` as `a` JOIN `business` as `b` ON `a`.`businessid`=`b`.`id` WHERE `b`.`name` LIKE '".trim($search)."%' AND `a`.`settingszoneid` = ".$zoneid." GROUP By b.name";
        $busArr = $this->SelectRawquery($qry,'result');
        echo json_encode($busArr);die;
	}
}

