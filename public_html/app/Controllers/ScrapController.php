<?php
namespace App\Controllers;
require  ROOTPATH . 'vendor/autoload.php';

use Aws\S3\S3Client;
use App\Libraries\IonAuth;
use App\Libraries\PHPMailer_Lib;
use Config\MyConfig;
use App\Models\zone\Zone_model;
use App\Models\admin\Business;
use App\Models\admin\Ads_model;
use App\Controllers\CommonController;
use App\Controllers\CronController;
use App\Controllers\Auth;
use App\Models\admin\Sales_zone;
use App\Models\Users;
use App\Models\admin\Category_management_model;
use App\Models\Statistics;
use App\Models\States;
use App\Models\banner\Banner_model;
use App\Models\Category_new_model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
#[\AllowDynamicProperties]
class ScrapController extends BaseController{
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
    $this->CronController = new CronController();
    $this->PHPMailer = new PHPMailer();
    $this->Users = new Users();
  }
	
	public function scrap(){
    $res = $this->checkuserlogin();
    if($res == 1){
      return redirect()->to(base_url().'/welcome');
    }
  	$header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    return view('scrap', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme));
  }	

  public function checkuserpass(){
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $sql = "SELECT id, username, password FROM  scap_admin where  username ='".$username."'";
    $result = $this->CommonController->SelectRawquery($sql,'row');
    $hashed_password = $result->password;
    $isPasswordCorrect = password_verify($password, $hashed_password);
    if($isPasswordCorrect == 1){
      $this->CommonController->setSession('scrapuserlogin',$username);
			echo json_encode(['msg'=>'login Success','type'=>'success']);
			die;   		
    }else{
    	echo json_encode(['msg'=>'Username and Password Invalid','type'=>'warning']);
    	die;
    }
  }

  public function welcome(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
  	$header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    return view('includes/scrap/welcome', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme));
  }

  public function users(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
  	$header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    $sql="select a.subdomain,a.subdomainZone,a.seo_zone_name,a.id as zoneid,b.last_name,a.name,b.id,b.username,b.email,b.first_name,b.last_name from sales_zone a,users b where a.sales_rep_id=b.id and b.username!='' group by a.sales_rep_id order by a.id asc";
    $result = $this->CommonController->SelectRawquery($sql,'resultArray');
    return view('includes/scrap/users', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme,'result'=>$result));
  }

  public function incomingemail(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
    $header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    $sql="select a.subdomain,a.subdomainZone,a.seo_zone_name,a.id as zoneid,b.last_name,a.name,b.id,b.username,b.email,b.first_name,b.last_name from sales_zone a,users b where a.sales_rep_id=b.id and b.username!='' group by a.sales_rep_id order by a.id asc";
    $result = $this->CommonController->SelectRawquery($sql,'resultArray');
    return view('includes/scrap/incomingemail', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme,'result'=>$result));
  }

  public function logintozone(){
    $response = '';
    $userId = $_REQUEST["userId"];
    $zip_claimed_by_user = (!empty($_REQUEST['zip_claimed_by_user']))? $_REQUEST['zip_claimed_by_user'] : ""; 
    $sql="select b.last_login,a.subdomain,b.password,a.subdomainZone,a.name as zoneName,a.seo_zone_name,a.id as zoneid,b.last_name,a.name,b.id,b.username,b.email,b.first_name,b.last_name from sales_zone a,users b where a.sales_rep_id=b.id and b.username!='' and b.id='".$userId."'";
    $r = $this->CommonController->SelectRawquery($sql,'row');

    $user_type1=$this->ionAuth->check_user_type($userId);
    $user_type = $user_type1[0]['group_id'];
    $username = $r->username;
    $password = $r->password;
    $first_name = $r->first_name;
    $last_name = $r->last_name;
    $email = $r->email;
    $zoneid = $r->zoneid;
    $last_login = $r->last_login;
    $zoneName = $r->zoneName;
    echo json_encode($r);
    die;
  }

  public function create_zone(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
    $header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    return view('includes/scrap/create_zone', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme));
  }

  public function imagecategory(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
    $header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    $catget = "SELECT * FROM  multiPurFoodCategory";
    $data = $this->CommonController->SelectRawquery($catget,'resultArray');
    return view('includes/scrap/addcategory', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme,'data'=>$data));
  }

  public function projects(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
    $header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    $query = "SELECT * FROM `users` AS `us` INNER JOIN `sales_zone` AS `sz` ON `us`.`id` = `sz`.`sales_rep_id` WHERE `us`.`active` = 1 AND `us`.`status` = 1 AND `sz`.`active` = 1";
    $projectdata = $this->CommonController->SelectRawquery($query,'resultArray');
    return view('includes/scrap/projects', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme,'projectdata'=>$projectdata));
  }

  public function uploadImage(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
    $header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    $sqlget = "SELECT * FROM  multipurposeImage";
    $res = $this->CommonController->SelectRawquery($sqlget,'resultArray');

    $catget = "SELECT * FROM  multiPurFoodCategory";
    $catres = $this->CommonController->SelectRawquery($catget,'resultArray');

    return view('includes/scrap/uploadImage', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme,'res'=>$res,'catres'=>$catres));
  }  

  public function uploadtoAWS(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
    $header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    $sqlget = "SELECT * FROM  multipurposeImage";
    $res = $this->CommonController->SelectRawquery($sqlget,'resultArray');

    $catget = "SELECT * FROM  multiPurFoodCategory";
    $catres = $this->CommonController->SelectRawquery($catget,'resultArray');

    return view('includes/scrap/uploadtoAWS', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme,'res'=>$res,'catres'=>$catres));
  }

  public function macrononfoodcsv(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
    $header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    return view('includes/scrap/macrocsv', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme));
  }

  public function macrofoodcsv(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
    $header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    return view('includes/scrap/macrofoodcsv', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme));
  }

  public function emailhistory(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
    $header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    $sqlget = "SELECT * FROM  multipurposeImage";
    $res = $this->CommonController->SelectRawquery($sqlget,'resultArray');

    $catget = "SELECT * FROM  multiPurFoodCategory";
    $catres = $this->CommonController->SelectRawquery($catget,'resultArray');

    return view('includes/scrap/emailHistory', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme,'res'=>$res,'catres'=>$catres));
  }

  public function CatSubCategoryImage(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
    $header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    $sqlget = "SELECT * FROM  multipurposeImage";
    $res = $this->CommonController->SelectRawquery($sqlget,'resultArray');

    $catget = "SELECT * FROM  category_new where status=1 and id Not in ('-99')";
    $catres = $this->CommonController->SelectRawquery($catget,'resultArray');
    return view('includes/scrap/CatSubCategoryImage', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme,'res'=>$res,'catres'=>$catres));
  }

  public function deals(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
    $header = 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    $zoneid = isset($_GET['zoneid'])?$_GET['zoneid']:'';
    $data = [];
    if($zoneid != ''){
      $sql="SELECT a.id,a.business_id,a.deal_title FROM ads_setting_preferences asp LEFT JOIN ads a ON asp.businessid = a.business_id WHERE asp.settingszoneid =".$zoneid."";
      $data = $this->CommonController->SelectRawquery($sql,'resultArray');
    }
    $zonesql="SELECT distinct(id) FROM sales_zone where id != '0' AND id != ''";
    $zonedata = $this->CommonController->SelectRawquery($zonesql,'resultArray');
    return view('includes/scrap/deals', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme,'data'=>$data,'zonedata'=>$zonedata));
  }

  public function TryvaryRandomString($length = 10){
    $randomCharacters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ=-$&@';
    $stringLength = strlen($randomCharacters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $randomCharacters[rand(0, $stringLength - 1)];
    }
    return $randomString;
  }

  public function create_zone_users(){
    $zipArr = [];
    $zipdata = '';
    $username = $_REQUEST['username'];
    $fname = $_REQUEST['fname'];
    $lname = $_REQUEST['lname'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $city = $_REQUEST['city'];
    $address = $_REQUEST['address'];
    $zname = $_REQUEST['zonename'];
    $dealpage = $_REQUEST['dealpage'];
    $zonepage = $_REQUEST['zonepage'];
    $zip = $_REQUEST['zip'];
    $zipexpArr = explode(',', $_REQUEST['zip']);
    $sql="SELECT * FROM users WHERE username='".$username."'";
    $exists = $this->CommonController->SelectRawquery($sql,'count');
    if($exists){
      echo json_encode(['msg' => 'Username Already Exists', 'type' => 'warning']);
      die;  
    }
    
    $arr_pass[] = $this->TryvaryRandomString(10);
    $r = rand(0,count($arr_pass)-1) ;
    $pass = $arr_pass[$r] ;
    $salt=substr(md5(uniqid(rand(), true)), 0, 10);
    $password=$salt.substr(sha1($salt.$pass),0,-10);
    
    $genUser = [
      'username' => $username,
      'password' => $password,
      'first_name' => $fname,
      'last_name' => $lname,
      'phone' => $phone,
      'Address' => $address,
      'email' => $email,
      'City' => $city,
      'Zip' => $zip,
      'active' => 1,
      'status' => 1
    ];
    $userId = $this->CommonController->InsertData('users', $genUser);

    $gensalesRep = [
      'name' => $zname,
      'seo_zone_name' => str_replace(' ', '', $zname),
      'sales_rep_id' => $userId,
      'subdomain' => $dealpage,
      'subdomainZone' => $zonepage,
      'active' => 1,
    ];
    $zoneId = $this->CommonController->InsertData('sales_zone', $gensalesRep);
    
    $gengenuserGroup = [
      'user_id' => $userId,
      'group_id' => 4
    ];
    $this->CommonController->InsertData('users_groups', $gengenuserGroup);
    
    if (count($zipexpArr) > 0) {
      foreach ($zipexpArr as $zipv) {
        $this->CommonController->deleteData('tblClaimedZips',['zip'=>$zipv]);
      }
      foreach ($zipexpArr as $zipv) {
        $sql="SELECT * FROM tblClaimedZips WHERE zip=".$zipv."";
        $existszip = $this->CommonController->SelectRawquery($sql,'count');
        if($existszip > 0){
          $zipArr[] = $zipv;
        }else{
          $this->CommonController->InsertData('tblClaimedZips',['zip' => $zipv, 'uid' => $userId, 'approved' => '1']);
          $this->CommonController->InsertData('zip_code_zone',['zip_code' => $zipv, 'zone_id' => $zoneId, 'latitude' => 0, 'longitude' => 0]);
        }
      }
    }
    if(count($zipArr) > 0){
      $zipdata = implode(',', $zipArr);
    }
    $resData = ['username' => $username,'userId' => $userId,'password'=>$pass,'zoneid'=>$zoneId,'zipArr'=>$zipdata];
    echo json_encode(['msg'=>'Zone Created Successfully','type'=>'success','data'=>$resData]);
    die;
  }

  public function reassignzip(){
    $existszip = $_REQUEST['existszip'];
    $existsuserId = $_REQUEST['existsuserId'];  
    $existszoneId = $_REQUEST['existszoneId'];  
    $zipexpArr = explode(',', $existszip);
    if (count($zipexpArr) > 0) {
      foreach ($zipexpArr as $zipv) {
        $this->CommonController->updateData('tblClaimedZips',['zip' => $zipv],['uid' => $existsuserId]);
        $this->CommonController->updateData('zip_code_zone',['zip_code' => $zipv],['zone_id' => $existszoneId]);
        
      }
    }
    echo json_encode(['msg'=>'Re Assign Zip Successfully','type'=>'success']);
    die;
  }

  public function uploadimagefunction(){
    $dataArr = $datacatArr = [];
    $sqlget = "SELECT * FROM  multipurposeImage";
    $res = $this->CommonController->SelectRawquery($sqlget,'resultArray');
    foreach ($res as $k => $v) {
      $dataArr[] = ['id' => $v['id'],'category'=> $v['category'],'image' => $v['image']];
    }
    
    $sqlgetcat = "SELECT * FROM  multiPurFoodCategory";
    $rescat = $this->CommonController->SelectRawquery($sqlgetcat,'resultArray');
    foreach ($rescat as $k1 => $v1) {
      $datacatArr[$v1['id']] = $v1['foodCategoryName'];
    }

    foreach ($dataArr as $k2 => $v2) {
      $dataArr[$k2]['catname'] = isset($datacatArr[$v2['category']])?$datacatArr[$v2['category']]:'';
    }
    echo json_encode($dataArr);
    die;
  }

  public function scrapupdateimage(){
    $type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
    if($type == 'catsubcat'){
      $sqlget = "SELECT * FROM  category_sub_subcategory_new WHERE id = '".$_REQUEST['updateid']."' ";  
    }else{
      $sqlget = "SELECT * FROM  multipurposeImage WHERE id = '".$_REQUEST['updateid']."' ";
    }
    $result = $this->CommonController->SelectRawquery($sqlget,'row');
    echo json_encode($result);
    die;
  }

  public function scrapcategory(){
    $dataArr = [];
    $sqlget = "SELECT * FROM  multiPurFoodCategory";
    $result = $this->CommonController->SelectRawquery($sqlget,'resultArray');
    
    foreach ($result as $k => $v) {
      $dataArr[] = ['id' => $v['id'],'foodCategoryName'=> $v['foodCategoryName']];
    }
    echo json_encode($dataArr);
    die;
  }

  public function scrapImageUpdate(){
    if(isset($_REQUEST['imageID']) && $_REQUEST['imageID'] > 0){
      $this->CommonController->updateData('multipurposeImage',['category'=>$_REQUEST['category']],['id'=>$_REQUEST['imageID']]);
    }  
    if(isset($_FILES['image']['name'])){
      foreach ($_FILES['image']['name'] as $k => $v) {
        $uploaded_file = $_FILES['image']['tmp_name'][$k];
        $size = getimagesize($uploaded_file);
        if($size[0] < 700 && $size[1] <= 395){
          echo json_encode(['msg' => 'Image resolution must be 700x395','type' => 'error']);
          die;
        }
      }
      
      foreach ($_FILES['image']['name'] as $k => $v) {
        $filename = $v;
        $uploaded_file = $_FILES['image']['tmp_name'][$k];
        $img_ext = pathinfo($v, PATHINFO_EXTENSION);
        $folder_path = "/home/savingssites/public_html/assets/CommonImages/";
        $folder_path1 = "/home/savingssites/public_html/assets/CommonImages/demo/";
        $size = getimagesize($uploaded_file);
        $ratio = $size[0] / $size[1];
        $dst_y = 0;
        $dst_x = 0;
        if ($ratio > 1) {
          $width = 700;
          // $height = 395 / $ratio;
          $height = 395;
          $dst_y = (395 - $height) / 2;
        } else {
          $width = 700 * $ratio;
          $height = 395;
          $dst_x = (700 - $width) / 2;
        }
        $src = imagecreatefromstring(file_get_contents($uploaded_file));
        $dst = imagecreatetruecolor($width, $height);
              imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
              imagejpeg($dst, $folder_path. $filename);
        if(move_uploaded_file($uploaded_file,$folder_path1.$v)){
          $this->CommonController->updateData('multipurposeImage',['image'=>$filename],['id'=>$_REQUEST['imageID']]);
          echo json_encode(['msg' => 'Image Updated Successfully','type' => 'success']);
          die;
        }
      }  
    }
  }

  public function resize(){
    $directory = "/home/savingssites/public_html/assets/SavingsUpload/CSV/679/images";
    $images = glob($directory . "/*.jpeg");
    foreach($images as $image){
          $info = pathinfo($image);
          $image_name =  basename($image,'.'.$info['extension']);
          $filename = $image_name.'.'.$info['extension'];
          $folder_path = "/home/savingssites/public_html/assets/SavingsUpload/CSV/679/resizeimages";
          $size = @getimagesize($image);
          if(is_array($size)){
            $ratio = $size[0] / $size[1];
            $dst_y = 0;
            $dst_x = 0;
            if ($ratio > 1) {
              $width = 700;
              $height = 395;
              $dst_y = (395 - $height) / 2;
            }else{
              $width = 700 * $ratio;
              $height = 395;
              $dst_x = (700 - $width) / 2;
            }
            $src = imagecreatefromstring(file_get_contents($image));
            $dst = imagecreatetruecolor($width, $height);
           imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
           imagejpeg($dst, $folder_path. $filename);
          }
        }
        die;



























  //   $directories = glob($directory . '/*' , GLOB_ONLYDIR);
  //   if(count($directories) > 0){
  //     $i = 20;
  //     foreach(array_chunk($directories, 20) as $dir ) {
  //       foreach ($dir as $k => $v) {
  //       $images = glob($v . "/*.svg");
  //       $locationpath = $v.'/resizeimages';
  //       if(is_dir($locationpath)==false){ mkdir($locationpath,0777);}
  //       foreach($images as $image){
  //         $info = pathinfo($image);
  //         $image_name =  basename($image,'.'.$info['extension']);
  //         $filename = $image_name.'.'.$info['extension'];
  //         $folder_path = $folder_path = "/home/savingssites/public_html/assets/CommonImages/";."/";
  //         $size = @getimagesize($image);
  //         if(is_array($size)){
  //           $ratio = $size[0] / $size[1];
  //           $dst_y = 0;
  //           $dst_x = 0;
  //           if ($ratio > 1) {
  //             $width = 700;
  //             $height = 395;
  //             $dst_y = (395 - $height) / 2;
  //           }else{
  //             $width = 700 * $ratio;
  //             $height = 395;
  //             $dst_x = (700 - $width) / 2;
  //           }
  //           $src = imagecreatefromstring(file_get_contents($image));
  //           $dst = imagecreatetruecolor($width, $height);
  //          imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
  //          imagejpeg($dst, $folder_path. $filename);
  //         }
  //       }
  //       echo "complete"; 
  //     }
  //     echo $i+20;
  //     }
  //   }
  // }

  // public function insertscrapimage(){
  //   $category = $_POST['category']; 
  //   foreach ($_FILES['image']['name'] as $k => $v) {
  //     $uploaded_file = $_FILES['image']['tmp_name'][$k]; 
  //     $size = getimagesize($uploaded_file);
  //     if($size[0] < 700 && $size[1] <= 395){
  //       echo json_encode(['msg' => 'Image resolution must be 700x395','type' => 'warning']);
  //       die;
  //     }
  //   }
    
  //   foreach ($_FILES['image']['name'] as $k => $v) {
  //     $filename = $v;
  //     $uploaded_file = $_FILES['image']['tmp_name'][$k];
  //     $img_ext = pathinfo($v, PATHINFO_EXTENSION);
  //     $folder_path = "/home/savingssites/public_html/assets/CommonImages/";
  //     $folder_path1 = "/home/savingssites/public_html/assets/CommonImages/demo/";
  //     $size = getimagesize($uploaded_file);
  //     $ratio = $size[0] / $size[1];
  //     $dst_y = 0;
  //     $dst_x = 0;
  //     if ($ratio > 1) {
  //       $width = 700;
  //       // $height = 395 / $ratio;
  //       $height = 395;
  //       $dst_y = (395 - $height) / 2;
  //     }else{
  //       $width = 700 * $ratio;
  //       $height = 395;
  //       $dst_x = (700 - $width) / 2;
  //     }
  //     $src = imagecreatefromstring(file_get_contents($uploaded_file));
  //     $dst = imagecreatetruecolor($width, $height);
  //          imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
  //          imagejpeg($dst, $folder_path. $filename);
  //     if(move_uploaded_file($uploaded_file, $folder_path1.$v)){
  //       $this->CommonController->InsertData('multipurposeImage',['image' => $filename,'category'=>$category]);
  //       echo json_encode(['msg' => 'Image Uploaded Successfully','type' => 'success']);
  //       die;
  //     }
  //   }
  }
  
  public function insertscrapawsimage(){
    $directory = "/home/savingssites/public_html/subdomainBusiness/assets/images/img/dealsimg";
    $directories = glob($directory . "/*.*");  
   // $directories = glob($directory . '/*' , GLOB_ONLYDIR);  
    echo json_encode(['msg' =>'totalcount','count'=>count($directories),'data'=>$directories]);
  }  

  public function insertscrapawsimageinsert(){
    $directories = isset($_REQUEST['dataArr'])?$_REQUEST['dataArr']:[];
    $uploadimageArr = [];
    $s3Client = new S3Client([
      'version' => 'latest',
      'region'  => 'us-east-1',
      'credentials' => [
        'key'    => 'AKIAUHVG6DYZU6ONYGTZ',
        'secret' => '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'
      ]
    ]);
   //print_r($directories);die('here');
    if(count($directories) > 0){
      foreach ($directories as $k => $v) {
        $image_name = $v;
        $supported_format = array('gif','jpg','jpeg','png','webp','svg');
        $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        
        // if (in_array($ext, $supported_format)){
          $bucket = 'savingssites';
          $file_Path = $image_name;
          $k = basename($file_Path);
          $key = str_replace(' ', '', $k);
          try {
            $result = $s3Client->putObject([
              'Bucket' => $bucket,
              'Key'    => $key,
              'Body'   => fopen($file_Path, 'r'),
            ]);
              $uploadimageArr[] = "attachment_image='".$result->get('ObjectURL')."' WHERE ".$v." attachment_image='".$k."'@&";
            $resname = basename($result->get('ObjectURL'));

            // $this->CommonController->updateData('business',['logo'=>$resname],['logo'=>$k]);
            // $this->CommonController->updateData('tbl_deals_products',['card_img'=>$resname],['card_img'=>$k]);
            // $this->CommonController->updateData('ads',['adtext'=>$resname],['adtext'=>$k]);
          }catch(Aws\S3\Exception\S3Exception $e) {
            // echo "There was an error uploading the file.\n";
            // echo $e->getMessage();
          }
        // }
      }
    }
    echo json_encode(['insertedtotal'=>count($directories),'insert' => 1,'srcheck' => $uploadimageArr]);
    die;

    
    if(count($directories) > 0){
      foreach ($directories as $k => $v) {
        //echo"<pre>";print_r($v);die;
        $all_files = glob($v . "/*.*");
        for ($i=0; $i<count($all_files); $i++){
          $image_name = $all_files[$i];
          $supported_format = array('gif','jpg','jpeg','png','webp','svg','mp3','pdf');
          $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
          
          if (in_array($ext, $supported_format)){
            $bucket = 'savingssites';
            $file_Path = $image_name;
            $k = basename($file_Path);
            $key = str_replace(' ', '', $k);
            try {
              $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => $key,
                'Body'   => fopen($file_Path, 'r'),
              ]);
              $uploadimageArr[] = "attachment_image='".$result->get('ObjectURL')."' WHERE ".$v." attachment_image='".$k."'@&";
              $resname = basename($result->get('ObjectURL'));

              // $this->CommonController->updateData('business',['logo'=>$resname],['logo'=>$k]);
              // $this->CommonController->updateData('tbl_deals_products',['card_img'=>$resname],['card_img'=>$k]);
              // $this->CommonController->updateData('ads',['adtext'=>$resname],['adtext'=>$k]);
            }catch(Aws\S3\Exception\S3Exception $e) {
              // echo "There was an error uploading the file.\n";
              // echo $e->getMessage();
            }
          }
        }
      }
    }

    echo json_encode(['insertedtotal'=>count($directories),'insert' => 1,'srcheck' => $uploadimageArr]);
  }

  public function scrapdelimage(){
    $type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
    if($type == 'category'){
      $this->CommonController->deleteData('multiPurFoodCategory',['id'=>$_REQUEST['delid']]);
    }else if($type == 'catsubcat'){
      $this->CommonController->updateData('category_sub_subcategory_new',['attachment_image'=>''],['id'=>$_REQUEST['delid']]);
    }else{
      $this->CommonController->deleteData('multipurposeImage',['id'=>$_REQUEST['delid']]);
    }
    echo json_encode(1);
    die;
  }

  public function fetchcategory(){
    $dataArr = [];
    $sqlget = "SELECT * FROM  multiPurFoodCategory";
    $res = $this->CommonController->SelectRawquery($sqlget,'resultArray');
    foreach ($res as $k => $v) {
      $dataArr[] = ['id' => $v['id'],'foodCategoryName'=> $v['foodCategoryName']];
    }
    echo json_encode($dataArr);
    die;
  }

  public function insertupdatecategory(){
    $msg = array('msg' => 'something went wrong', 'type' => 'warning');
    if($_POST['type'] == 'updatecatadd'){
      $this->CommonController->updateData('multiPurFoodCategory',['foodCategoryName'=>$_POST['catname']],['id'=>$_POST['catid']]);
      $msg = array('msg' => 'Category Updated Successfully', 'type' => 'success');
    }else{
      $this->CommonController->InsertData('multiPurFoodCategory',['foodCategoryName' => $_POST['newcat']]);
      $msg = array('msg' => 'Category Inserted Successfully', 'type' => 'success');  
    }
    echo json_encode($msg);
    die; 
  }


  public function checkuserlogin(){
    $username = $this->CommonController->getSession('scrapuserlogin');
    if($username == ''){
      return 0;
    }else{
      return 1;
    }
  }

  public function getscrapsubcategory(){
    $category = isset($_REQUEST['cat'])?$_REQUEST['cat']:''; 
    $child_type = isset($_REQUEST['child_type'])?$_REQUEST['child_type']:''; 
    if($child_type == 'y'){
      $subcatget = "SELECT b.id,b.name FROM category_subcategory_new as a LEFT JOIN category_sub_subcategory_new as b ON a.id = b.parent_id where a.status=1 and b.status=1 and a.id Not in ('-99') and b.id Not in ('-99') and a.catid='".$category."' and parent_type='s'";
    }else if($child_type == 'n'){
      $subcatget = "SELECT * FROM category_sub_subcategory_new where status=1 and id Not in ('-99') and parent_id='".$category."' and parent_type='c' ";
    }
    $res = $this->CommonController->SelectRawquery($subcatget,'resultArray');
    echo json_encode($res);
  }

  public function insertscrapimagecatsubcat(){
    $category = isset($_POST['category'])?$_POST['category']:'';
    $subcategory = isset($_POST['subcategory'])?$_POST['subcategory']:'';
    
    // foreach ($_FILES['image']['name'] as $k => $v) {
    //   $uploaded_file = $_FILES['image']['tmp_name'][$k]; 
    //   $size = getimagesize($uploaded_file);
    //   if($size[0] < 700 && $size[1] <= 395){
    //     echo json_encode(['msg' => 'Image resolution must be 700x395','type' => 'warning']);
    //     die;
    //   }
    // }
    
    foreach ($_FILES['image']['name'] as $k => $v) {
      $filename = $v;
      $uploaded_file = $_FILES['image']['tmp_name'][$k];
      $img_ext = pathinfo($v, PATHINFO_EXTENSION);
      $folder_path = "/home/savingssites/public_html/subdomainBusiness/assets/CommonImages/CategorySubcategory/";
      $folder_path1 = "/home/savingssites/public_html/subdomainBusiness/assets/CommonImages/CategorySubcategory/demo/";
      $size = getimagesize($uploaded_file);
      $ratio = $size[0] / $size[1];
      $dst_y = 0;
      $dst_x = 0;
      if ($ratio > 1) {
        $width = 700;
        // $height = 395 / $ratio;
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
           imagejpeg($dst, $folder_path. $filename);
      if(move_uploaded_file($uploaded_file, $folder_path1.$v)){
        $this->CommonController->updateData('category_sub_subcategory_new',['attachment_image'=>$filename],['id'=>$subcategory]);
        echo json_encode(['msg' => 'Image Uploaded Successfully','type' => 'success']);
        die;
      }
    }
  }

  public function fetchscrapcatsubimage(){
    $subcatget = "SELECT a.id as catid, a.name as catname, c.id as subsubcatid, c.name as subsubcatname, c.attachment_image as subimage FROM category_new as a LEFT JOIN category_subcategory_new as b ON a.id = b.catid LEFT JOIN category_sub_subcategory_new as c ON b.id = c.parent_id where a.status=1 and b.status=1 and a.id Not in ('-99') and b.id Not in ('-99') and parent_type='s'";
    $res = $this->CommonController->SelectRawquery($subcatget,'resultArray');
    // echo "<pre>";print_r($res);die;
    
    $subsubcatget = "SELECT a.id as catid, a.name as catname, c.id as subsubcatid, c.name as subsubcatname,c.attachment_image as subimage FROM category_new as a LEFT JOIN category_sub_subcategory_new as c ON a.id = c.parent_id where c.status=1 and a.id Not in ('-99') and c.id Not in ('-99')";
    $subres = $this->CommonController->SelectRawquery($subsubcatget,'resultArray');
    $data = array_merge($res,$subres);
    if(count($data) > 0){
      foreach ($data as $k => $v) {
        if($v['subimage'] != '' &&  $v['subimage'] != 'null' && $v['subimage'] != null){
          $data[$k]['subimage'] ='<img src="'.base_url().'/subdomainBusiness/assets/CommonImages/CategorySubcategory/demo/'.$v['subimage'].'" />';
        }else{
          $data[$k]['subimage'] = '';
        }
      }
    }
    echo json_encode($data); 
  }

  public function setemailhistory(){
    $emailtype = $_REQUEST['emailtype'];
    $email = $_REQUEST['email'];
    $emaildetail = $_REQUEST['emaildetail'];
    $editid = isset($_REQUEST['editid'])?$_REQUEST['editid']:0;
    if($editid > 0){
       $this->CommonController->updateData('emailHistory',['category' => $emailtype,'email'=>$email,'emailtext'=>$emaildetail],['id'=>$editid]);
       $msg = array('msg' => 'Email Data Updated Successfully', 'type' => 'success');
    }else{
      $this->CommonController->InsertData('emailHistory',['category' => $emailtype,'email'=>$email,'emailtext'=>$emaildetail]);
      $msg = array('msg' => 'Email Data Inserted Successfully', 'type' => 'success');
    }
      echo json_encode($msg);
  }

  public function getemailhistory(){
    $id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
    if($id != ''){
      $sqlget = "SELECT * FROM  emailHistory WHERE id=".$id."";
    }else{
      $sqlget = "SELECT * FROM  emailHistory";
    }
    $res = $this->CommonController->SelectRawquery($sqlget,'resultArray');
    echo json_encode($res);
    die;
  }

  public function delemail(){
    $this->CommonController->deleteData('emailHistory',['id'=>$_REQUEST['delid']]);
    $res = array('msg' => 'Email Data Deleted Successfully', 'type' => 'success');
    echo json_encode($res);
    die;
  }

  public function scrapchat(){
    $res = $this->checkuserlogin();
    if($res == 0){
      return redirect()->to(base_url().'/scrap');
    }
    $header= 'homeheader';
    $footer = 'homefooter';
    $zoneid = '598';
    $theme  = "blue"; 
    $page = 'Old Glory';
    $zone_name = '';
    return view('includes/scrap/scrapchat', array('header'=>$header,'footer'=>$footer,'zoneid'=>$zoneid,'zone_id'=>$zoneid,'zone_name'=>$zone_name,'theme'=>$theme));
  } 

  public function testcron(){
    $data = 'cron working'.date('H:i:s');
    $this->CommonController->InsertData('testdealphone',['phone' => $data]);
  }

  public function testservertimedate(){
    echo date_default_timezone_get();
    echo "<br>";
    echo date('d-m-Y');
    echo "<br>";
    echo date('H:i:s');
  }

  public function insertscrapmacrocsv(){
    $zipcodes = isset($_FILES['zipcsv'])?$_FILES['zipcsv']:[];
    $ypnonfoodcsv = isset($_FILES['ypcsv'])?$_FILES['ypcsv']:[];
    $dbnonfoodcsv = isset($_FILES['dbcsv'])?$_FILES['dbcsv']:[];
    $locationpath = '/home/savingssites/public_html/assets/SavingsUpload/macrouploadfile/'.date('d-m-Y').'/';
    if(is_dir($locationpath)==false){ mkdir($locationpath,0777);}
    if(count($zipcodes) > 0){
      $tempname = $_FILES['zipcsv']['tmp_name'];
      move_uploaded_file($tempname, $locationpath.'nonfoodzipcodes.txt');  
    }
    if(count($ypnonfoodcsv) > 0){
      $tempname = $_FILES['ypcsv']['tmp_name'];
      move_uploaded_file($tempname, $locationpath.'nonfoodyp.csv');  
    }
    if(count($dbnonfoodcsv) > 0){
      $tempname = $_FILES['dbcsv']['tmp_name'];
      move_uploaded_file($tempname, $locationpath.'nonfooddb.csv');  
      // $data = $this->setdatatogencsvnonfood($locationpath);
    }
    echo json_encode(['msg'=>'File Uploaded Successfully','type'=>'success']);
  }

  public function insertscrapmacrofoodcsv(){
    $ziptxt = isset($_FILES['ziptxt'])?$_FILES['ziptxt']:[];
    $freshcsv = isset($_FILES['freshcsv'])?$_FILES['freshcsv']:[];
    $ypnonfoodcsv = isset($_FILES['ypcsv'])?$_FILES['ypcsv']:[];
    $dbnonfoodcsv = isset($_FILES['dbcsv'])?$_FILES['dbcsv']:[];
    $locationpath = '/home/savingssites/public_html/assets/SavingsUpload/macrouploadfoodfile/'.date('d-m-Y').'/';
    if(is_dir($locationpath)==false){ mkdir($locationpath,0777);}
    if(count($ziptxt) > 0){
      $tempname = $_FILES['ziptxt']['tmp_name'];
      move_uploaded_file($tempname, $locationpath.'ziptxt.txt');  
    }
    if(count($freshcsv) > 0){
      $tempname = $_FILES['freshcsv']['tmp_name'];
      move_uploaded_file($tempname, $locationpath.'fresh.csv');  
    }
    if(count($ypnonfoodcsv) > 0){
      $tempname = $_FILES['ypcsv']['tmp_name'];
      move_uploaded_file($tempname, $locationpath.'foodyp.csv');  
    }
    if(count($dbnonfoodcsv) > 0){
      $tempname = $_FILES['dbcsv']['tmp_name'];
      move_uploaded_file($tempname, $locationpath.'fooddb.csv');  
      // $data = $this->setdatatogencsvnonfood($locationpath);
    }
    echo json_encode(['msg'=>'File Uploaded Successfully','type'=>'success']);
  }

    public function setdatatogencsvfoodold($locationpath = ''){
    $date = isset($_REQUEST['date'])?$_REQUEST['date']:date('d-m-Y');
    $secondlastArr = [];
    $location = '/home/savingssites/public_html/assets/SavingsUpload/macrouploadfoodfile/'.$date.'/'; 
    $locationsubcat = '/home/savingssites/public_html/assets/SavingsUpload/macrouploadfoodfile/'; 
    $ziptext = $location.'ziptxt.txt';
    $freshcsv = $location.'fresh.csv';
    $foodyp = $location.'foodyp.csv';
    $fooddb = $location.'fooddb.csv';
    $foodsubcatbus = $locationsubcat.'companysubcategory.csv';
    $foodnewrules = $locationsubcat.'newrules.csv';
    $ziptxtcsvArr = $this->genfoodziptextArr($ziptext);
    $freshcsvArr = $this->genfoodfreshArr($freshcsv);
    $foodYPArr = $this->genfoodypArr($foodyp);
    $foodDBArr = $this->genfooddbArr($fooddb);
    $foodSubcatArr = $this->genfoodsubcatArr($foodsubcatbus);
    $foodnewrulesArr = $this->genfoodnewrulesArr($foodnewrules);
    echo "<pre>";print_r($foodYPArr);die;
    if(count($ziptxtcsvArr) > 0 && count($foodYPArr) > 0){
      foreach ($foodYPArr as $k1 => $v1) {
        if(count($v1) > 0){
          foreach ($v1 as $k2 => $v2) {
            $ziplength = strlen($v2['zip']);
            if($ziplength == 4){
              if(!in_array('0'.$v2['zip'], $ziptxtcsvArr)){
                unset($foodYPArr[$k2]);
              }
            }else{
              if(!in_array($v2['zip'], $ziptxtcsvArr)){
                unset($foodYPArr[$k2]);
              }
            }    
          }
        }
      }
    }

    $businessaddrArr = [];
    if(count($foodYPArr) > 0){
      foreach ($foodYPArr as $k3 => $v3) {
        if(count($v3) > 0){
          foreach ($v3 as $k4 => $v4) {
            $companyfirstname = isset($foodDBArr[$v4['phone']]['companyname'])?$foodDBArr[$v4['phone']]['companyname']:'';
            $subcategoryfirst = isset($foodSubcatArr[$companyfirstname]['subcatid'])?$foodSubcatArr[$companyfirstname]['subcatid']:'';
            $subcategoryfirst = isset($foodSubcatArr[$companyfirstname]['subcatid'])?$foodSubcatArr[$companyfirstname]['subcatid']:'';
            
            $businessaddrArr[$v4['address']]['category'] = $v4['category'];
            $businessaddrArr[$v4['address']]['name'] = $v4['name'];
            $businessaddrArr[$v4['address']]['address'] = $v4['address'];
            $businessaddrArr[$v4['address']]['city'] = $v4['city'];
            $businessaddrArr[$v4['address']]['state'] = $v4['state'];
            $businessaddrArr[$v4['address']]['zip'] = $v4['zip'];
            $businessaddrArr[$v4['address']]['phone'] = $v4['phone'];
            $businessaddrArr[$v4['address']]['website'] = $v4['website'];
            $businessaddrArr[$v4['address']]['deal_id'] = isset($foodSubcatArr[$companyfirstname]['dealid'])?$foodSubcatArr[$companyfirstname]['dealid']:'';
            $businessaddrArr[$v4['address']]['logoid'] = isset($foodSubcatArr[$companyfirstname]['logoid'])?$foodSubcatArr[$companyfirstname]['logoid']:'';
            $businessaddrArr[$v4['address']]['aboutid'] = isset($foodSubcatArr[$companyfirstname]['aboutid'])?$foodSubcatArr[$companyfirstname]['aboutid']:'';
            $businessaddrArr[$v4['address']]['ourhistoryid'] = isset($foodSubcatArr[$companyfirstname]['ourhistoryid'])?$foodSubcatArr[$companyfirstname]['ourhistoryid']:''; 

            if($subcategoryfirst != ''){
              $subcatquery='SELECT b.dealId,b.attachment_image,a.name as catname FROM category_new as a INNER JOIN category_sub_subcategory_new as b ON a.id=b.parent_id WHERE b.id='.$subcategoryfirst;
              $subcatArr = $this->CommonController->SelectRawquery($subcatquery, 'resultArray');
              if(count($subcatArr) <= 0){
                $subcatquery='SELECT b.id as subcatidnew, b.dealId,b.attachment_image,a.name as catname FROM category_subcategory_new as a INNER JOIN category_sub_subcategory_new as b ON a.id=b.parent_id WHERE b.id='.$subcategoryfirst;
                $subcatArr = $this->CommonController->SelectRawquery($subcatquery, 'resultArray');
              }
              $businessaddrArr[$v4['address']]['image_url'] = isset($subcatArr[0]['subcatidnew'])?$subcatArr[0]['subcatidnew']:'';
              $businessaddrArr[$v4['address']]['categoryname'] = isset($subcatArr[0]['catname'])?$subcatArr[0]['catname']:'';
              $businessaddrArr[$v4['address']]['subcategory'] = isset($subcatArr[0]['subcatidnew'])?$subcatArr[0]['subcatidnew']:'';
            }else{
              if(count($foodnewrulesArr) > 0){
                $subcatnewrules = 0;
                foreach ($foodnewrulesArr as $subk => $subv){
                  if($subv != ''){
                    $subrulesArr = explode(',', $subv);
                    if(count($subrulesArr) > 0){
                      foreach ($subrulesArr as $k3 => $v3) {
                        $strFindMe = $v3;
                        $strPar  = $v4['name'];
                        if(strpos($strPar, $strFindMe)){
                          $subcatnewrules = $subk;
                          break;
                        }
                      }
                    }
                  }
                }
                
                if($subcatnewrules > 0){
                  $subcatquery='SELECT b.id as subcatidnew,b.dealId,b.attachment_image,a.name as catname FROM category_new as a INNER JOIN category_sub_subcategory_new as b ON a.id=b.parent_id WHERE b.id='.$subcatnewrules;
                  $subcatArr = $this->CommonController->SelectRawquery($subcatquery, 'resultArray');
                  if(count($subcatArr) <= 0){
                    $subcatquery='SELECT b.dealId,b.attachment_image,a.name as catname FROM category_subcategory_new as a INNER JOIN category_sub_subcategory_new as b ON a.id=b.parent_id WHERE b.id='.$subcatnewrules;
                    $subcatArr = $this->CommonController->SelectRawquery($subcatquery, 'resultArray');
                  }
                  $businessaddrArr[$v4['address']]['image_url'] = isset($subcatArr[0]['subcatidnew'])?$subcatArr[0]['subcatidnew']:'';
                  $companyfirstname = isset($subcatArr[0]['catname'])?$subcatArr[0]['catname']:''; 
                  $businessaddrArr[$v4['address']]['categoryname'] = isset($subcatArr[0]['catname'])?$subcatArr[0]['catname']:''; 
                  $businessaddrArr[$v4['address']]['subcategory'] = isset($subcatArr[0]['subcatidnew'])?$subcatArr[0]['subcatidnew']:'';
                  $businessaddrArr[$v4['address']]['deal_id'] = isset($foodSubcatArr[$companyfirstname]['dealid'])?$foodSubcatArr[$companyfirstname]['dealid']:'';
                  $businessaddrArr[$v4['address']]['logoid'] = isset($foodSubcatArr[$companyfirstname]['logoid'])?$foodSubcatArr[$companyfirstname]['logoid']:'';
                  $businessaddrArr[$v4['address']]['aboutid'] = isset($foodSubcatArr[$companyfirstname]['aboutid'])?$foodSubcatArr[$companyfirstname]['aboutid']:'';
                  $businessaddrArr[$v4['address']]['ourhistoryid'] = isset($foodSubcatArr[$companyfirstname]['ourhistoryid'])?$foodSubcatArr[$companyfirstname]['ourhistoryid']:'';
                }else{
                  $businessaddrArr[$v4['address']]['deal_id'] = '';
                  $businessaddrArr[$v4['address']]['logoid'] = '';
                  $businessaddrArr[$v4['address']]['aboutid'] = '';
                  $businessaddrArr[$v4['address']]['ourhistoryid'] = '';
                  $businessaddrArr[$v4['address']]['image_url'] = '';
                  $businessaddrArr[$v4['address']]['categoryname'] = '';
                  $businessaddrArr[$v4['address']]['subcategory'] = ''; 
                }
              }else{
                $businessaddrArr[$v4['address']]['deal_id'] = '';
                $businessaddrArr[$v4['address']]['logoid'] = '';
                $businessaddrArr[$v4['address']]['aboutid'] = '';
                $businessaddrArr[$v4['address']]['ourhistoryid'] = '';
                $businessaddrArr[$v4['address']]['image_url'] = '';
                $businessaddrArr[$v4['address']]['categoryname'] = '';
                $businessaddrArr[$v4['address']]['subcategory'] = ''; 
              }
            }
            $businessaddrArr[$v4['address']]['company'] = isset($foodDBArr[$v4['phone']]['companyname'])?$foodDBArr[$v4['phone']]['companyname']:'';
            $businessaddrArr[$v4['address']]['firstname'] = isset($foodDBArr[$v4['phone']]['firstname'])?$foodDBArr[$v4['phone']]['firstname']:'';
            $businessaddrArr[$v4['address']]['lastname'] = isset($foodDBArr[$v4['phone']]['lastname'])?$foodDBArr[$v4['phone']]['lastname']:'';
            $businessaddrArr[$v4['address']]['contactfullname'] = isset($foodDBArr[$v4['phone']]['contactname'])?$foodDBArr[$v4['phone']]['contactname']:'';
            $businessaddrArr[$v4['address']]['email'] = isset($foodDBArr[$v4['phone']]['email'])?$foodDBArr[$v4['phone']]['email']:'';
          }
        }
      }
    }

    echo "<pre>";print_r($businessaddrArr);die;

    return $this->downloadfoodcsv($foodYPArr);




      
        
        
    








  }

  public function setdatatogencsvfood($locationpath = ''){
    $date = isset($_REQUEST['date'])?$_REQUEST['date']:date('d-m-Y');
    $secondlastArr = [];
    $location = '/home/savingssites/public_html/assets/SavingsUpload/macrouploadfoodfile/'.$date.'/'; 
    $locationsubcat = '/home/savingssites/public_html/assets/SavingsUpload/macrouploadfoodfile/'; 
    $ziptext = $location.'ziptxt.txt';
    $freshcsv = $location.'fresh.csv';
    $foodyp = $location.'foodyp.csv';
    $fooddb = $location.'fooddb.csv';
    $foodsubcatbus = $locationsubcat.'companysubcategory.csv';
    $foodnewrules = $locationsubcat.'newrules.csv';
    $ziptxtcsvArr = $this->genfoodziptextArr($ziptext);
    $freshcsvArr = $this->genfoodfreshArr($freshcsv);
    $foodYPArr = $this->genfoodypArr($foodyp);
    $foodDBArr = $this->genfooddbArr($fooddb);
    $foodSubcatArr = $this->genfoodsubcatArr($foodsubcatbus);
    $foodnewrulesArr = $this->genfoodnewrulesArr($foodnewrules);
    if(count($ziptxtcsvArr) > 0 && count($foodYPArr) > 0){
      foreach ($foodYPArr as $k1 => $v1) {
        $ziplength = strlen($v1['zip']);
        if($ziplength == 4){
          if(!in_array('0'.$v1['zip'], $ziptxtcsvArr)){
            unset($foodYPArr[$k1]);
          }
        }else{
          if(!in_array($v1['zip'], $ziptxtcsvArr)){
            unset($foodYPArr[$k1]);
          }
        }
      }
    }
    
    if(count($foodYPArr) > 0){
      foreach ($foodYPArr as $k => $v) {
        $companyfirstname = isset($foodDBArr[$v['phone']]['companyname'])?$foodDBArr[$v['phone']]['companyname']:'';
        $subcategoryfirst = isset($foodSubcatArr[$companyfirstname]['subcatid'])?$foodSubcatArr[$companyfirstname]['subcatid']:'';
        
        $subcategoryfirst = isset($foodSubcatArr[$companyfirstname]['subcatid'])?$foodSubcatArr[$companyfirstname]['subcatid']:'';
        $foodYPArr[$k]['deal_id'] = isset($foodSubcatArr[$companyfirstname]['dealid'])?$foodSubcatArr[$companyfirstname]['dealid']:'';
        $foodYPArr[$k]['logoid'] = isset($foodSubcatArr[$companyfirstname]['logoid'])?$foodSubcatArr[$companyfirstname]['logoid']:'';
        $foodYPArr[$k]['aboutid'] = isset($foodSubcatArr[$companyfirstname]['aboutid'])?$foodSubcatArr[$companyfirstname]['aboutid']:'';
        $foodYPArr[$k]['ourhistoryid'] = isset($foodSubcatArr[$companyfirstname]['ourhistoryid'])?$foodSubcatArr[$companyfirstname]['ourhistoryid']:'';
        if($subcategoryfirst != ''){
          $subcatquery='SELECT b.dealId,b.attachment_image,a.name as catname FROM category_new as a INNER JOIN category_sub_subcategory_new as b ON a.id=b.parent_id WHERE b.id='.$subcategoryfirst;
          $subcatArr = $this->CommonController->SelectRawquery($subcatquery, 'resultArray');
          if(count($subcatArr) <= 0){
            $subcatquery='SELECT b.id as subcatidnew, b.dealId,b.attachment_image,a.name as catname FROM category_subcategory_new as a INNER JOIN category_sub_subcategory_new as b ON a.id=b.parent_id WHERE b.id='.$subcategoryfirst;
            $subcatArr = $this->CommonController->SelectRawquery($subcatquery, 'resultArray');
          }
          $foodYPArr[$k]['image_url'] = isset($subcatArr[0]['subcatidnew'])?$subcatArr[0]['subcatidnew']:'';
          $foodYPArr[$k]['categoryname'] = isset($subcatArr[0]['catname'])?$subcatArr[0]['catname']:'';
          $foodYPArr[$k]['subcategory'] = isset($subcatArr[0]['subcatidnew'])?$subcatArr[0]['subcatidnew']:'';
        }else{
          if(count($foodnewrulesArr) > 0){
            $subcatnewrules = 0;
            foreach ($foodnewrulesArr as $subk => $subv){
              if($subv != ''){
                $subrulesArr = explode(',', $subv);
                if(count($subrulesArr) > 0){
                  foreach ($subrulesArr as $k3 => $v3) {
                    $strFindMe = $v3;
                    $strPar  = $v['name'];
                    if(strpos($strPar, $strFindMe)){
                      $subcatnewrules = $subk;
                      break;
                    }
                  }
                }
              }
            }
            if($subcatnewrules > 0){
              $subcatquery='SELECT b.id as subcatidnew,b.dealId,b.attachment_image,a.name as catname FROM category_new as a INNER JOIN category_sub_subcategory_new as b ON a.id=b.parent_id WHERE b.id='.$subcatnewrules;
              $subcatArr = $this->CommonController->SelectRawquery($subcatquery, 'resultArray');
              if(count($subcatArr) <= 0){
                $subcatquery='SELECT b.dealId,b.attachment_image,a.name as catname FROM category_subcategory_new as a INNER JOIN category_sub_subcategory_new as b ON a.id=b.parent_id WHERE b.id='.$subcatnewrules;
                $subcatArr = $this->CommonController->SelectRawquery($subcatquery, 'resultArray');
              }
              $foodYPArr[$k]['image_url'] = isset($subcatArr[0]['subcatidnew'])?$subcatArr[0]['subcatidnew']:'';
              $companyfirstname = isset($subcatArr[0]['catname'])?$subcatArr[0]['catname']:''; 
              $foodYPArr[$k]['categoryname'] = isset($subcatArr[0]['catname'])?$subcatArr[0]['catname']:''; 
              $foodYPArr[$k]['subcategory'] = isset($subcatArr[0]['subcatidnew'])?$subcatArr[0]['subcatidnew']:'';
              $foodYPArr[$k]['deal_id'] = isset($foodSubcatArr[$companyfirstname]['dealid'])?$foodSubcatArr[$companyfirstname]['dealid']:'';
              $foodYPArr[$k]['logoid'] = isset($foodSubcatArr[$companyfirstname]['logoid'])?$foodSubcatArr[$companyfirstname]['logoid']:'';
              $foodYPArr[$k]['aboutid'] = isset($foodSubcatArr[$companyfirstname]['aboutid'])?$foodSubcatArr[$companyfirstname]['aboutid']:'';
              $foodYPArr[$k]['ourhistoryid'] = isset($foodSubcatArr[$companyfirstname]['ourhistoryid'])?$foodSubcatArr[$companyfirstname]['ourhistoryid']:'';
            }else{
              $foodYPArr[$k]['deal_id'] = '';
              $foodYPArr[$k]['logoid'] = '';
              $foodYPArr[$k]['aboutid'] = '';
              $foodYPArr[$k]['ourhistoryid'] = '';
              $foodYPArr[$k]['image_url'] = '';
              $foodYPArr[$k]['categoryname'] = '';
              $foodYPArr[$k]['subcategory'] = ''; 
            }
          }else{
            $foodYPArr[$k]['deal_id'] = '';
            $foodYPArr[$k]['logoid'] = '';
            $foodYPArr[$k]['aboutid'] = '';
            $foodYPArr[$k]['ourhistoryid'] = '';
            $foodYPArr[$k]['image_url'] = '';
            $foodYPArr[$k]['categoryname'] = '';
            $foodYPArr[$k]['subcategory'] = ''; 
          }
        }
        $foodYPArr[$k]['company'] = isset($foodDBArr[$v['phone']]['companyname'])?$foodDBArr[$v['phone']]['companyname']:'';
        $foodYPArr[$k]['firstname'] = isset($foodDBArr[$v['phone']]['firstname'])?$foodDBArr[$v['phone']]['firstname']:'';
        $foodYPArr[$k]['lastname'] = isset($foodDBArr[$v['phone']]['lastname'])?$foodDBArr[$v['phone']]['lastname']:'';
        $foodYPArr[$k]['contactfullname'] = isset($foodDBArr[$v['phone']]['contactname'])?$foodDBArr[$v['phone']]['contactname']:'';
        $foodYPArr[$k]['email'] = isset($foodDBArr[$v['phone']]['email'])?$foodDBArr[$v['phone']]['email']:'';
      }
      return $this->downloadfoodcsv($foodYPArr);
    }
  }

  public function genfoodziptextArr($ziptext){
    $handle = fopen($ziptext, "r");
    $ziptextlist = ''; 
    while (($raw_string = fgets($handle)) !== false) {$ziptextlist .= $raw_string;}
    fclose($handle);
    $zipcodeArr = explode(',', $ziptextlist);
    return $zipcodeArr;
  }

  public function genfoodfreshArr($freshcsv){
    $genypArr = [];
    $handle = fopen($freshcsv, "r");
    $header = fgetcsv($handle, 2048, ',');
    $lineNumber = 1;
    while (($raw_string = fgets($handle)) !== false) {
      $row[$lineNumber] = str_getcsv($raw_string);
      $lineNumber++;
    }
    fclose($handle);
    foreach ($row as $k => $v) {
      $company = $firstname = $lastname = $contactfullname = $email = $phone = $website = $address = $city = $state = $zip = $subcategory = '';
      foreach ($header as $k1 => $v1) {
        if(trim($v1) == "Company"){
          $company = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "First Name"){
          $firstname = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Last Name"){
          $lastname = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Contact Full Name"){
          $contactfullname = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Email"){
          $email = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Phone"){
          $phone = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Website"){
          $website = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Address"){
          $address = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "City"){
          $city = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "State"){
          $state = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Zip"){
          $zip = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Menu Type"){
          $subcategory = isset($v[$k1])?$v[$k1]:'';
        }
      }
      $phone = str_replace('(','',$phone);
      $phone = str_replace(')','',$phone);
      $phone = str_replace('-','',$phone);
      $phone = str_replace(' ','',$phone);
        $genypArr[$phone] = array(
          'company' => $company,
          'firstname' => $firstname,
          'lastname' => $lastname,
          'contactfullname' => $contactfullname,
          'email' => $email,
          'phone' => $phone,
          'website' => $website,
          'address' => $address,
          'city' => $city,
          'state' => $state,
          'zip' => $zip,
          'subcategory' => $subcategory
        );  
    }
    return $genypArr;
  }

  public function genfoodypArr($foodyp){
    $genypArr = [];
    $handle = fopen($foodyp, "r");
    $header = fgetcsv($handle, 2048, ',');
    $lineNumber = 1;
    while (($raw_string = fgets($handle)) !== false) {
      $row[$lineNumber] = str_getcsv($raw_string);
      $lineNumber++;
    }
    fclose($handle);
    foreach ($row as $k => $v) {
      $category = $name = $address = $city = $state = $zip = $phone = $website = '';
      foreach ($header as $k1 => $v1) {
        if(trim($v1) == "Category" || trim($v1) == "category" || trim($v1) == "Main Category"){
          $category = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Business Name" || trim($v1) == "name" || trim($v1) == "Company Name"){
          $name = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Address" || trim($v1) == "address"){
          $address = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "City" || trim($v1) == "city"){
          $city = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "State" || trim($v1) == "state"){
          $state = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Postal Code" || trim($v1) == "zip"){
          $zip = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Phone" || trim($v1) == "phone"){
          $phone = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Website" || trim($v1) == "website"){
          $website = isset($v[$k1])?$v[$k1]:'';
        }
      }
      $phone = str_replace('(','',$phone);
      $phone = str_replace(')','',$phone);
      $phone = str_replace('-','',$phone);
      $phone = str_replace(' ','',$phone);
        $genypArr[$name.'_'.$address] = array(
          'category' => $category,
          'name' => $name,
          'address' => $address,
          'city' => $city,
          'state' => $state,
          'zip' => $zip,
          'phone' => $phone,
          'website' => $website
        );  
    }
    return $genypArr;
  }

  public function genfooddbArr($fooddb){
    $genypArr = [];
    $handle = fopen($fooddb, "r");
    $header = fgetcsv($handle, 2048, ',');
    $lineNumber = 1;
    while (($raw_string = fgets($handle)) !== false) {
      $row[$lineNumber] = str_getcsv($raw_string);
      $lineNumber++;
    }
    fclose($handle);
    foreach ($row as $k => $v) {
      $email = $companyname = $contactname = $firstname = $lastname = $address = $city = $state = $zip = $phone = $website = '';
      foreach ($header as $k1 => $v1) {
        if(trim($v1) == "email"){
          $email = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "company name"){
          $companyname = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "contact name"){
          $contactname = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "first name"){
          $firstname = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "last name"){
          $lastname = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "address"){
          $address = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "city"){
          $city = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "state"){
          $state = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "zip"){
          $zip = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "phone"){
          $phone = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "website"){
          $website = isset($v[$k1])?$v[$k1]:'';
        }
      }
      $phone = str_replace('(','',$phone);
      $phone = str_replace(')','',$phone);
      $phone = str_replace('-','',$phone);
      $phone = str_replace(' ','',$phone);
        $genypArr[$phone] = array(
          'email' => $email,
          'companyname' => $companyname,
          'contactname' => $contactname,
          'firstname' => $firstname,
          'lastname' => $lastname,
          'address' => $address,
          'city' => $city,
          'state' => $state,
          'zip' => $zip,
          'phone' => $phone,
          'website' => $website
        );  
    }
    return $genypArr;
  }

  public function genfoodsubcatArr($foodsubcatbus){
    $genypArr = [];
    $handle = fopen($foodsubcatbus, "r");
    $header = fgetcsv($handle, 2048, ',');
    $lineNumber = 1;
    while (($raw_string = fgets($handle)) !== false) {
      $row[$lineNumber] = str_getcsv($raw_string);
      $lineNumber++;
    }
    fclose($handle);
    foreach ($row as $k => $v) {
      $companyname = $logoid = $aboutid = $subcatid = $ourhistoryid = $dealid = '';
      foreach ($header as $k1 => $v1) {
        if(trim($v1) == "company name"){
          $companyname = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Logo ID or URL"){
          $logoid = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "About ID or Info"){
          $aboutid = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "CUISINE ID"){
          $subcatid = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "Our History"){
          $ourhistoryid = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "DEAL ID"){
          $dealid = isset($v[$k1])?$v[$k1]:'';
        }
      }
        $genypArr[$companyname] = array(
          'companyname' => $companyname,
          'logoid' => $logoid,
          'aboutid' => $aboutid,
          'subcatid' => $subcatid,
          'ourhistoryid' => $ourhistoryid,
          'dealid' => $dealid
        );  
    }
    return $genypArr;
  }

  public function genfoodnewrulesArr($foodnewrules){
    $genypArr = [];
    $handle = fopen($foodnewrules, "r");
    $header = fgetcsv($handle, 2048, ',');
    $lineNumber = 1;
    while (($raw_string = fgets($handle)) !== false) {
      $row[$lineNumber] = str_getcsv($raw_string);
      $lineNumber++;
    }
    fclose($handle);
    foreach ($row as $k => $v) {
      $companyname = '';
      foreach ($header as $k1 => $v1) {
        if(trim($v1) == "CUISINES ID's"){
          $subcatid = isset($v[$k1])?$v[$k1]:'';
        }
        if(!is_numeric($v[$k1]) && $v[$k1] != ''){
          $companyname .= "," . $v[$k1];
        }
      } 
      $genypArr[$subcatid] = $companyname;
    }
    return $genypArr;
  }

  public function setdatatogencsvnonfood($locationpath = ''){
    $date = $_REQUEST['date'];
    $secondlastArr = [];
    $location = '/home/savingssites/public_html/assets/SavingsUpload/macrouploadfile/'.$date.'/'; 
    $locationsubcat = '/home/savingssites/public_html/assets/SavingsUpload/macrouploadfoodfile/';
    $zipcodes = $location.'nonfoodzipcodes.txt';
    $nonfoodyp = $location.'nonfoodyp.csv';
    $nonfooddb = $location.'nonfooddb.csv';
    $foodsubcatbus = $locationsubcat.'companysubcategory.csv';
    $ziptxtcsvArr = $this->genfoodziptextArr($zipcodes);
    $nonfoodYPArr = $this->gennonfoodypArr($nonfoodyp);
    $nonfoodDBArr = $this->gennonfooddbArr($nonfooddb);
    $foodSubcatArr = $this->genfoodsubcatArr($foodsubcatbus);

    if(count($ziptxtcsvArr) > 0 && count($nonfoodYPArr) > 0){
      foreach ($nonfoodYPArr as $k1 => $v1) {
        $ziplength = strlen($v1['zip']);
        if($ziplength == 4){
          if(!in_array('0'.$v1['zip'], $ziptxtcsvArr)){
            unset($nonfoodYPArr[$k1]);
          }
        }else{
          if(!in_array($v1['zip'], $ziptxtcsvArr)){
            unset($nonfoodYPArr[$k1]);
          }
        }
      }
    }
    if(count($nonfoodYPArr) > 0){
      foreach ($nonfoodYPArr as $k => $v) {
        $subcat = str_replace('+',' ',$v['sub_cat']);
        $subcatquery='SELECT b.id as subcatid,b.dealId,b.attachment_image,a.name as catname FROM category_new as a INNER JOIN category_sub_subcategory_new as b ON a.id=b.parent_id WHERE b.name LIKE "%'.$subcat.'%"';
        $subcatArr = $this->CommonController->SelectRawquery($subcatquery, 'resultArray');
        if(count($subcatArr) <= 0){
          $subcatquery='SELECT a.id as subcatidnew,b.dealId,b.attachment_image,a.name as catname FROM category_subcategory_new as a INNER JOIN category_sub_subcategory_new as b ON a.id=b.parent_id WHERE b.name LIKE "%'.$subcat.'%"';
          $subcatArr = $this->CommonController->SelectRawquery($subcatquery, 'resultArray');
        }
        $nonfoodYPArr[$k]['email'] = isset($nonfoodDBArr[$v['phone']]['email'])?$nonfoodDBArr[$v['phone']]['email']:'';
        $nonfoodYPArr[$k]['contact_name'] = isset($nonfoodDBArr[$v['phone']]['contact_name'])?$nonfoodDBArr[$v['phone']]['contact_name']:'';
        $nonfoodYPArr[$k]['first_name'] = isset($nonfoodDBArr[$v['phone']]['first_name'])?$nonfoodDBArr[$v['phone']]['first_name']:'';
        $nonfoodYPArr[$k]['last_name'] = isset($nonfoodDBArr[$v['phone']]['last_name'])?$nonfoodDBArr[$v['phone']]['last_name']:'';
        $nonfoodYPArr[$k]['company_name'] = isset($nonfoodDBArr[$v['phone']]['company_name'])?$nonfoodDBArr[$v['phone']]['company_name']:'';
        $nonfoodYPArr[$k]['deal_id'] = isset($subcatArr[0]['dealId'])?$subcatArr[0]['dealId']:'';
        $nonfoodYPArr[$k]['image_url'] = isset($subcatArr[0]['subcatidnew'])?$subcatArr[0]['subcatidnew']:'';
        $nonfoodYPArr[$k]['categoryname'] = isset($subcatArr[0]['catname'])?$subcatArr[0]['catname']:'';
        $nonfoodYPArr[$k]['logoid'] = isset($foodSubcatArr[$v['name']]['logoid'])?$foodSubcatArr[$v['name']]['logoid']:'';
        $nonfoodYPArr[$k]['aboutid'] = isset($foodSubcatArr[$v['name']]['aboutid'])?$foodSubcatArr[$v['name']]['aboutid']:'';
        $nonfoodYPArr[$k]['ourhistoryid'] = isset($foodSubcatArr[$v['name']]['ourhistoryid'])?$foodSubcatArr[$v['name']]['ourhistoryid']:'';
      }
      return $this->downloadcsv($nonfoodYPArr);
    }
  }
  
  public function downloadcsv($arr){
    $delimiter = ","; 
    $filename = "macrononfoodcsv" . date('Y-m-d') . ".csv"; 
    $f = fopen('php://memory', 'w');
    
    $fields = array('Business Name', 'Website', 'Subcategory', 'Deal Id', 'Ranking', 'Vicinity', 'LOGO URL', 'img_url_1', 'img_url_2', 'img_url_3','img_url_4','img_url_5','About','Our History Id','Category','Address','City','State','Postal Code','Phone','Contact Name','First Name','Last Name','Last Name','Email','Email2','Email3','Email4','Email5');
    fputcsv($f, $fields, $delimiter);
    foreach ($arr as $k => $row) {
      $lineData = array($row['name'], $row['website'],$row['sub_cat'], $row['deal_id'], '', '', $row['logoid'], $row['image_url'],'','','','',$row['aboutid'],$row['ourhistoryid'],$row['categoryname'],$row['address'],$row['city'],$row['state'],$row['zip'],$row['phone'],$row['contact_name'],$row['first_name'],$row['last_name'],$row['email'],'','','','');  
      fputcsv($f, $lineData, $delimiter);  
    }
    fseek($f, 0); 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
    fpassthru($f); 
    exit;
  }

  public function downloadfoodcsv($arr){
    $delimiter = ","; 
    $filename = "Monmountfoodcsv" . date('Y-m-d') . ".csv"; 
    $f = fopen('php://memory', 'w');
    
    $fields = array('Business Name', 'Website', 'Subcategory', 'Deal Id', 'Ranking', 'Vicinity', 'LOGO URL', 'img_url_1', 'img_url_2', 'img_url_3','img_url_4','img_url_5','About','Our History Id','Category','Address','City','State','Postal Code','Phone','Contact Name','First Name','Last Name','Email','Email2','Email3','Email4','Email5');
    
    fputcsv($f, $fields, $delimiter);
    foreach ($arr as $k => $row) {
       $lineData = array($row['name'], $row['website'],$row['subcategory'], $row['deal_id'], '', '', $row['logoid'], $row['image_url'],'','','','',$row['aboutid'],$row['ourhistoryid'],$row['category'],$row['address'],$row['city'],$row['state'],' '.$row['zip'],$row['phone'],$row['contactfullname'],$row['firstname'],$row['lastname'],$row['email'],'','','',''); 
      fputcsv($f, $lineData, $delimiter);  
    }
    fseek($f, 0); 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
    fpassthru($f); 
    exit;
  }

  public function gennonfoodypArr($nonfoodyp){
    $genypArr = [];
    $handle = fopen($nonfoodyp, "r");
    $header = fgetcsv($handle, 2048, ',');
    $lineNumber = 1;
    while (($raw_string = fgets($handle)) !== false) {
      $row[$lineNumber] = str_getcsv($raw_string);
      $lineNumber++;
    }
    fclose($handle);
    foreach ($row as $k => $v) {
      $category = $name = $address = $city = $state = $zip = $phone = $website = $sub_cat = '';
      foreach ($header as $k1 => $v1) {
        if(trim($v1) == "category"){
          $category = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "name"){
          $name = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "address"){
          $address = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "city"){
          $city = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "state"){
          $state = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "zip"){
          $zip = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "phone"){
          $phone = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "website"){
          $website = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "sub_cat"){
          $sub_cat = isset($v[$k1])?$v[$k1]:'';
        }
      }
      $phone = str_replace('(','',$phone);
      $phone = str_replace(')','',$phone);
      $phone = str_replace('-','',$phone);
      $phone = str_replace(' ','',$phone);
        $genypArr[] = array(
          'category' => $category,
          'name' => $name,
          'address' => $address,
          'city' => $city,
          'state' => $state,
          'zip' => $zip,
          'phone' => $phone,
          'website' => $website,
          'sub_cat' => $sub_cat
        );  
    }
    return $genypArr;
  }

  public function gennonfooddbArr($nonfooddb){
    $gendbArr = [];
    $handle = fopen($nonfooddb, "r");
    $header = fgetcsv($handle, 2048, ',');
    $lineNumber = 1;
    while (($raw_string = fgets($handle)) !== false) {
      $row[$lineNumber] = str_getcsv($raw_string);
      $lineNumber++;
    }
    fclose($handle);
    foreach ($row as $k => $v) {
      $email = $sac_code = $company_name = $contact_name = $first_name = $last_name = $address = $city = $state = $zip = $phone = $website = '';
      foreach ($header as $k1 => $v1) {
        if(trim($v1) == "email"){
          $email = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "sic code"){
          $sac_code = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "company name"){
          $company_name = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "contact name"){
          $contact_name = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "first name"){
          $first_name = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "last name"){
          $last_name = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "address"){
          $address = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "city"){
          $city = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "state"){
          $state = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "zip"){
          $zip = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "phone"){
          $phone = isset($v[$k1])?$v[$k1]:'';
        }
        if(trim($v1) == "website"){
          $website = isset($v[$k1])?$v[$k1]:'';
        }
      }
        $gendbArr[$phone] = array(
          'email' => $email,
          'sac_code' => $sac_code,
          'company_name' => $company_name,
          'contact_name' => $contact_name,
          'first_name' => $first_name,
          'last_name' => $last_name,
          'address' => $address,
          'city' => $city,
          'state' => $state,
          'zip' => $zip,
          'phone' => $phone,
          'website' => $website,
        );  
    }
    return $gendbArr;
  }

  public function createawsfolder(){
    $s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
            'credentials' => array(
                'key' => 'AKIAUHVG6DYZU6ONYGTZ',
                'secret' => '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'
            )
        ]);
    $objects = $s3->ListObjects(['Bucket' => 'savingssites', 'Delimiter'=>'/']);
    echo "<pre>";print_r($objects);die;

    die;











    echo "here";
    $s3Client = new S3Client([
      'version' => 'latest',
      'region'  => 'us-east-1',
      'credentials' => [
        'key'    => 'AKIAUHVG6DYZU6ONYGTZ',
        'secret' => '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'
      ]
    ]);
    $result = $s3Client->putObject([
      'Bucket' => 'savingssites',
      'Key'    => 'assets/',
      'Body'   => '',
    ]);
    echo "folder created";die;
    
  }
  public function recoverpassword(){
    $username = isset($_GET['username'])?$_GET['username']:'';
    $usertype = isset($_GET['usertype'])?$_GET['usertype']:'';


    return view('recoverpassword', array('username'=>$username,'usertype'=>$usertype));
  }
  
  public function recover_pass_set(){
    $username = $_REQUEST['username'];
    $usertype = $_REQUEST['usertype'];
    $new_pass = $_REQUEST['new_pass'];
    $newpassword = $this->ion_auth->hash_password($new_pass);

    $this->CommonController->updateData('users',['password' => $newpassword,'uploaded_business_password'=> $new_pass],['username' => $username]);

    echo json_encode(1);
  }
} 