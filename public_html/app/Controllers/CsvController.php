<?php
namespace App\Controllers;
use App\Models\IonAuthModel;
use App\Models\Zips;
use App\Models\Organization_model;
use App\Models\zone\Zone_model;
use App\Models\admin\Ads_model;
use App\Models\admin\Users;
use App\Models\csv\Csv;
use App\Models\Category_new_model;
use App\Models\dining\Diningmodel;
use App\Controllers\CommonController;
use App\Controllers\Zonedashboard;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class CsvController extends BaseController{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->session = \Config\Services::session();
        $this->pager = \Config\Services::pager();
        $this->Zips = new Zips();
        $this->Zone_model = new Zone_model();
        $this->Ads_model = new Ads_model();
        $this->Organization_model = new Organization_model();
        $this->Diningmodel = new Diningmodel();
        $this->Category_new_model = new Category_new_model();
        $this->Users = new Users();
        $this->Csv = new Csv();
        $this->CommonController = new CommonController();
        $this->Zonedashboard = new Zonedashboard();
    }

    public function Import(){
        $csv = isset($_GET['csv'])?$_GET['csv']:0;
        $restype = 0;
        if($csv == 1){
            $path = $_SERVER['DOCUMENT_ROOT'].'/assets/SavingsUpload/CSV/'.$this->CommonController->getSession('zoneid').'/'.$this->CommonController->getSession('csvfilename');
            $restype = $this->CommonController->getSession('restype');
            $this->CommonController->unsetSession('csvpath');
            $this->CommonController->unsetSession('zoneid');
            $this->CommonController->unsetSession('csvfilename');
            $this->CommonController->unsetSession('restype');
            unlink($path);  
            $this->CommonController->destroySession();
        }
        if($restype == 3){
            $sql = "SELECT * FROM csverrororganization  WHERE `date`='".date('Y-m-d')."'";
        }else{
            $sql = "SELECT * FROM csverror  WHERE `date`='".date('Y-m-d')."'";
        }
        $errordata = $this->CommonController->SelectRawquery($sql);
        if(count($errordata) <= 0){
            $csv = 0;
        }
        $zone_name = '';
        $header= 'homeheader';
        $footer = 'homefooter';
        $theme  = "blue"; 
        $page = 'Old Glory';
        $zoneid = $zone_id = 213;
        $sql = 'SELECT id from sales_zone';
        $zoneIddata = $this->CommonController->SelectRawquery($sql);
        return view('Import', array('zoneid' => $zoneid,'zone_id'=> $zone_id,'header'=> $header,'footer'=> $footer,'zone_name'=> $zone_name,'theme'=> $theme,'page'=> $page,'zone_name'=> $zone_name,'zoneIddata'=> $zoneIddata,'csv'=> $csv,'restype'=> $restype));
    } 

    public function map(){
        $this->CommonController->deleteData('csverror',['date'=> date('Y-m-d')]);
        $zone_name = '';
        $header= 'homeheader';
        $footer = 'homefooter';
        $theme  = "blue"; 
        $page = 'Old Glory';
        $zoneid = $zone_id = $this->CommonController->getSession('zoneid');
        if($zoneid == '' || $zoneid == 'undefined'){
            return redirect()->to(base_url().'/import/');
        }
        $restype = $this->CommonController->getSession('restype');
        $arrfilecolumns= $this->GetFileColumns($this->CommonController->getSession('csvpath'));
        $arrtablecolmuns=$this->GetTableColumns('csv_uploader_allcolumns',$restype);
        return view('includes/csv/map', array('zoneid' => $zoneid,'zone_id'=> $zone_id,'header'=> $header,'footer'=> $footer,'zone_name'=> $zone_name,'theme'=> $theme,'page'=> $page,'zone_name'=> $zone_name,'arrtablecolmuns'=> $arrtablecolmuns,'arrfilecolumns'=> $arrfilecolumns,'restype'=> $restype));
    } 
    
    public function csvimportcount(){
        $path = $this->CommonController->getSession('csvpath');
        $zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:'';
        $mapheader = $_REQUEST['mapvalue'];
        $restype = $_REQUEST['restype'];
        $arr = [];
        $arrtablecolmuns=$this->GetTableColumns('csv_uploader_allcolumns',$restype);
        foreach ($arrtablecolmuns as $k => $v) {
            foreach ($mapheader as $k1 => $v1) {
                $v1 = preg_replace('/\x{EF}\x{BB}\x{BF}/', '', $v1);
                if($restype == 1){
                    if($v=="firstname" and in_array(strtolower($v1),['first name','firstname','first_name','firstname','fname','f_name'])){
                        $arr[$k1] = $v; 
                    }if($v=="lastname" and in_array(strtolower($v1),['last name','last_name','lname','lastname','name','l_name'])){
                        $arr[$k1] = $v;
                    }if($v=="contactfullname" and in_array(strtolower($v1),['contactname','contact name','contact_name','contactfullname','contact_full_name'])){
                        $arr[$k1] = $v;
                    }if($v=="companyname" and in_array(strtolower($v1),['company name','company_name','businessname','business_name','bus_name','companyname'])){
                        $arr[$k1] = $v;
                    }if($v=="zip" and in_array(strtolower($v1),['zip','zip_code','zip code','zipcode'])){
                        $arr[$k1] = $v;
                    }if($v=="image" and in_array(strtolower($v1),['image url','imageurl','image','image_url'])){
                        $arr[$k1] = $v;
                    }if($v=="category" and in_array(strtolower($v1),['main category','maincategory','main_category','category'])){
                        $arr[$k1] = $v;
                    }if($v=="dealid" and in_array(strtolower($v1),['deal id','dealid','deal_id','did'])){
                        $arr[$k1] = $v;
                    }if($v=="dealtitle" and in_array(strtolower($v1),['deal title','dealtitle','deal_title','dtitle'])){
                        $arr[$k1] = $v;
                    }if($v=="logourl" and in_array(strtolower($v1),['logo url','logo_url','logourl','logo'])){
                        $arr[$k1] = $v;
                    }if($v=="address" and in_array(strtolower($v1),['address'])){
                        $arr[$k1] = $v;
                    }if($v=="city" and in_array(strtolower($v1),['city'])){
                        $arr[$k1] = $v;
                    }if($v=="state" and in_array(strtolower($v1),['state'])){
                        $arr[$k1] = $v;
                    }if($v=="phone" and in_array(strtolower($v1),['phone','cell_phone','mobile','tel','telephone'])){
                        $arr[$k1] = $v;
                    }if($v=="website" and in_array(strtolower($v1),['website','link','url','site'])){
                        $arr[$k1] = $v;
                    }if($v=="email" and in_array(strtolower($v1),['email','emailaddress','e_mail','mail','e-mail'])){
                        $arr[$k1] = $v;
                    }if($v=="cuisines" and in_array(strtolower($v1),['cuisines','sub_category','sub-category','subcategory','scategory','subcat'])){
                        $arr[$k1] = $v;
                    }if($v=="ranking" and in_array(strtolower($v1),['ranking'])){
                        $arr[$k1] = $v;
                    }if($v=="about" and in_array(strtolower($v1),['about','aboutus','about_us','aboutme'])){
                        $arr[$k1] = $v;
                    }if($v=="vicinity" and in_array(strtolower($v1),['vicinity'])){
                        $arr[$k1] = $v;
                    }if($v=="hours_of_operation" and in_array(strtolower($v1),['hours of operation','hours_of_operation','hoursofoperation'])){
                        $arr[$k1] = $v;
                    }if($v=="history" and in_array(strtolower($v1),['history'])){
                        $arr[$k1] = $v;
                    }if($v=="alemail" and in_array(strtolower($v1),['alemail','al email','al_email','alternate email','alternate email','alternate_email','alternateemail'])){
                        $arr[$k1] = $v;
                    }if($v=="alfname" and in_array(strtolower($v1),['alfname','al fname','al_fname','alternate fname','alternate fname','alternate_fname','alternatefname','alternate firstname'])){
                        $arr[$k1] = $v;
                    }if($v=="allname" and in_array(strtolower($v1),['allname','al lname','al_lname','alternate lname','alternate lname','alternate_lname','alternatelname','alternate lastname'])){
                        $arr[$k1] = $v;
                    }
                }else if($restype == 3){
                    if($v=="zipcode" and in_array(strtolower($v1),['zip','zip_code','zip code','zipcode'])){
                        $arr[$k1] = $v;
                    }if($v=="state" and in_array(strtolower($v1),['state'])){
                        $arr[$k1] = $v;
                    }if($v=="city" and in_array(strtolower($v1),['city'])){
                        $arr[$k1] = $v;
                    }if($v=="accounttype" and in_array(strtolower($v1),['accounttype','account_type','account type'])){
                        $arr[$k1] = $v;
                    }if($v=="organizationname" and in_array(strtolower($v1),['organizationname','organization name','organization_name'])){
                        $arr[$k1] = $v;
                    }if($v=="username" and in_array(strtolower($v1),['uname','username','user name','user_name'])){
                        $arr[$k1] = $v;
                    }if($v=="email" and in_array(strtolower($v1),['email','emailaddress','e_mail','mail','e-mail'])){
                        $arr[$k1] = $v;
                    }if($v=="firstname" and in_array(strtolower($v1),['first name','firstname','first_name','firstname','fname','f_name'])){
                        $arr[$k1] = $v; 
                    }if($v=="lastname" and in_array(strtolower($v1),['last name','last_name','lname','lastname','name','l_name'])){
                        $arr[$k1] = $v;
                    }if($v=="phone" and in_array(strtolower($v1),['phone','cell_phone','mobile','tel','telephone'])){
                        $arr[$k1] = $v;
                    }if($v=="address" and in_array(strtolower($v1),['address'])){
                        $arr[$k1] = $v;
                    }
                }
            }
        }
        $csv_file = fopen($path, "r");
        while (($line = fgetcsv($csv_file)) !== FALSE){
            $rows[] = array_combine($arr, $line);
        }
        echo json_encode(['msg' =>'totalcount','count'=>count($rows),'data'=>$rows]); 
        die;
    }

    public function csvimportcountbackup(){
        $allowed =  array('csv');
        $zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:'';
        $locationpath = "./assets/SavingsUpload/CSV/".$zone_id;
        if(is_dir($locationpath)==false){ mkdir($locationpath,0777);}
        $filename = $_FILES['file']['name'];
        if(isset($_FILES['file'])){
            $name = $_FILES['file']['name'];
            $uploaded_file = $_FILES['file']['tmp_name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if(!in_array($ext,$allowed) ) {
                echo json_encode(['msg'=>'Only CSV File Allowed','type'=>'warning']);
                die;
            }
            if(move_uploaded_file($uploaded_file, $locationpath.'/'.$filename)){
                $csv_file_header = fopen(base_url().'/assets/SavingsUpload/CSV/'.$zone_id.'/'.$filename.'', "r");
                $csv_file = fopen(base_url().'/assets/SavingsUpload/CSV/'.$zone_id.'/'.$filename.'', "r");

                $header = fgetcsv($csv_file_header,1000,",");
                fgetcsv($csv_file);
                while (($line = fgetcsv($csv_file)) !== FALSE) {
                    $rows[] = array_combine($header, $line);
                }
            }
        }
        echo json_encode(['msg' =>'totalcount','count'=>count($rows),'data'=>$rows]); 
    }

    public function get_remote_file_info($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, TRUE);
    $data = curl_exec($ch);
    $fileSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [
        'fileExists' => (int) $httpResponseCode == 200,
        'fileSize' => (int) $fileSize
    ];
}

    public function csvimport(){
        $categoryid= $starterad = '1';
        $zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:'';
        $dataArr = isset($_REQUEST['dataArr'])?$_REQUEST['dataArr']:[];
        $arr_pass = array() ;
        $arr_pass[] = $this->TryvaryRandomString(10);
        $r = rand(0,count($arr_pass)-1) ;
        $pass = $arr_pass[$r] ;
        $salt=substr(md5(uniqid(rand(), true)), 0, 10);
        $password=$salt.substr(sha1($salt.$pass),0,-10);
        $srcheck = 0;
        if(count($dataArr) > 0){
            foreach ($dataArr as $k => $v) {
                $srcheck++;
                if($v['phone'] == 'Phone' && $v['email'] == 'email' && $v['address'] == 'Address'){
                    continue;
                }
                $errorArr = $imageappendimages = [];
                if($v['companyname'] == ''){$errorArr[] = 'company name empty';}
                if($v['phone'] == ''){$errorArr[] = 'phone empty';}
                if($v['email'] == ''){$errorArr[] = 'email empty';}
                // if($v['firstname'] == ''){$errorArr[] = 'firstname empty';}
                // if($v['lastname'] == ''){$errorArr[] = 'lastname empty';}
                if($v['address'] == ''){$errorArr[] = 'address empty';}
                
                $image = '';
                if($v['image'] != ''){
                    if(is_numeric($v['image'])){
                        $imagequery="SELECT image FROM multipurposeImage WHERE id='".$v['image']."'";
                        $imageexists = $this->CommonController->SelectRawquery($imagequery, 'row');
                        if($imageexists != ''){
                            $image = $imageexists->image;   
                        }else{
                            $imageappendimages[] = 'Image not Exists';
                        }  
                    }else{
                        $parsedUrl = parse_url($v['image']);
                        $pathInfo = pathinfo($parsedUrl['path']);
                        if(isset($pathInfo['extension']) && in_array($pathInfo['extension'], array('png','jpg','jpeg'))){
                            /*image download here*/
                            $imagenew = time().$pathInfo['filename'].'.'.$pathInfo['extension'];
                            $saveImagePath = $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/CSV/".$zone_id.'/images';
                            if(is_dir($saveImagePath)==false){mkdir($saveImagePath,0777);}
                            $locationpath = $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/CSV/".$zone_id.'/images/'.$imagenew;

                            $fp = fopen ($locationpath, 'w+');
                            $ch = curl_init($v['image']);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout
                            curl_setopt($ch, CURLOPT_FILE, $fp); 
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                            curl_exec($ch);
                            curl_close($ch);
                            fclose($fp);
                          
                            $imgsize=filesize($locationpath); 
                            if($imgsize <= 0){
                                $imageappendimages[] = 'Image not Downloadable '.$pathInfo['filename'].'.'.$pathInfo['extension'];
                                unlink($locationpath); 
                            }   
                            $image = $imagenew;
                        }else{
                            $imageappendimages[] = 'Image not Supported'; 
                        }
                    }
                }
                $logourl = '';
                if($v['logourl'] != ''){
                    if(is_numeric($v['logourl'])){
                        $imagequery="SELECT image FROM multipurposelogo WHERE id='".$v['logourl']."'";
                        $imageexists = $this->CommonController->SelectRawquery($imagequery, 'row');
                        if($imageexists != ''){
                            $logourl = $imageexists->image;   
                        }else{
                            $imageappendimages[] = 'Logo Image not Exists';
                        }
                    }else{
                        $parsedUrl = parse_url($v['logourl']);
                        $pathInfo = pathinfo($parsedUrl['path']);
                        if(isset($pathInfo['extension']) &&  in_array($pathInfo['extension'], array('png','jpg','jpeg'))){
                            $logonew = time().$pathInfo['filename'].'.'.$pathInfo['extension'];
                            $saveImagePath = $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/CSV/".$zone_id.'/logo';
                            if(is_dir($saveImagePath)==false){mkdir($saveImagePath,0777);}
                            $locationpath = $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/CSV/".$zone_id.'/logo/'.$logonew;

                            $fp = fopen ($locationpath, 'w+');
                            $ch = curl_init($v['logourl']);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout
                            curl_setopt($ch, CURLOPT_FILE, $fp); 
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                            curl_exec($ch);
                            curl_close($ch);
                            fclose($fp);
                          
                            $imgsize=filesize($locationpath); 
                            if($imgsize <= 0){
                                $imageappendimages[] = 'Image not Downloadable '.$pathInfo['filename'].'.'.$pathInfo['extension'];
                                unlink($locationpath); 
                            }  
                            $logourl = $logonew;
                        }else{
                            $imageappendimages[] = 'Logo Image not Supported';   
                        }
                    }
                }
                if($v['category'] == '' && $v['cuisines'] != ''){
                    $catqry =  'select a.id from category_new as a inner join category_subcategory_new as b on a.id=b.catid inner join category_sub_subcategory_new as c on b.id=c.parent_id where c.id = '.$v['cuisines'];
                    $catArr = $this->CommonController->SelectRawquery($catqry, 'row'); 
                    if($catArr != ''){
                        $v['category'] = isset($catArr->id)?$catArr->id:'';
                    }else{
                        $catqry =  'select a.id from category_new as a inner join category_sub_subcategory_new as c on a.id=c.parent_id where c.id = '.$v['cuisines'];
                        $catArr = $this->CommonController->SelectRawquery($catqry, 'row');
                        $v['category'] = isset($catArr->id)?$catArr->id:'';
                    } 
                }else{
                    $errorArr[] = 'subctegory not found';   
                }
                if($v['phone'] != ''){
                    if(!is_numeric($v['phone'])){
                        $errorArr[] = 'phone number must be numeric';
                    }
                    if(strlen($v['phone']) > 10){
                        $errorArr[] = 'phone number must be 10 digits';
                    }
                    $addquery="SELECT phone_int FROM address WHERE phone_int='".$v['phone']."'";
                    $exists = $this->CommonController->SelectRawquery($addquery, 'count');
                    if($exists > 0){
                        $errorArr[] = 'phone number already registered';   
                    }
                }
                if(count($errorArr) > 0){
                    $errorimplode = implode(',', $errorArr);
                    $errordata = array(  
                    'phone'           => $v['phone'],  
                    'email'           => $v['email'],
                    'companyname'     => $v['companyname'], 
                    'vicinity'        => $v['vicinity'], 
                    'contactfullname' => $v['contactfullname'], 
                    'firstname'       => $v['firstname'],
                    'lastname'        => $v['lastname'], 
                    'address'         => $v['address'], 
                    'city'            => $v['city'],
                    'state'           => $v['state'], 
                    'zip'             => $v['zip'], 
                    'website'         => $v['website'], 
                    'dealid'          => $v['dealid'], 
                    'dealtitle'       => $v['dealtitle'], 
                    'image'           => $v['image'], 
                    'category'        => $v['category'], 
                    'cuisines'        => $v['cuisines'], 
                    'ranking'         => $v['ranking'],
                    'logourl'         => $v['logourl'], 
                    'about'           => $v['about'],
                    'hours_of_operation' =>$v['hours_of_operation'], 
                    'history' =>$v['history'], 
                    'alEmail' =>$v['alemail'], 
                    'alFname' =>$v['alfname'], 
                    'alLname' =>$v['allname'], 
                    'errorStatus' =>$errorimplode,
                    'date' =>date('Y-m-d'), 
                );
                    if(count($imageappendimages) > 0){
                        $errordata['rowinsert'] = 'yes'; 
                    }
                    if(count($errorArr) > 0){
                        $errordata['rowinsert'] = 'no';   
                    }   
                        $this->CommonController->InsertData('csverror', $errordata);
                    if(count($errorArr) > 0){
                        continue;
                    }
                }
                $checkbycompanyandzip=$this->Csv->checkbycompanyandzip($v['companyname'],$v['zip']);
                $addressid=$this->Csv->I_Address($v['address'],$v['city'],$v['state'],$v['zip'],$v['phone'],''); 
                if(!empty($addressid)){ 
                    $businessid=$this->Csv->I_Business($v['companyname'],$addressid, $v['firstname'], $v['lastname'], $v['email'], $v['website'], $v['about'], $logourl, $v['vicinity'], $v['hours_of_operation'], $v['history'],$v['category']);
                    
                    if(!empty($businessid)){
                        $userid=$this->Csv->I_User($v['phone'],$v['email'],$v['firstname'], $v['lastname'],$password,$salt,$pass,$zone_id,$v['alemail'], $v['alfname'], $v['allname']);
                        $peekaboo_user=$this->Csv->I_Peekaboo_User($v['phone'],$password,$pass,$v['email'],$v['firstname'],$v['lastname'],$v['companyname']);
                        
                        if(!empty($userid)){
                            $this->Csv->U_BussinessOwner($businessid,$userid);
                            $this->Csv->I_Addsetting($zone_id,$businessid,1,$v['ranking']); 
                            
                            if(!empty($v['dealid'])){
                                $this->Csv->I_Deal($userid,$zone_id,$businessid,$v['dealid'],$image,$v['cuisines'],$v['dealtitle'],$v['companyname']);
                            }
                            
                            $adid=$this->Csv->I_Ad($image,$businessid,$starterad,$v['category'],$v['cuisines'],$v['dealtitle'],$zone_id);
                            if(!empty($adid)){
                                $this->Csv->I_AdToZone($adid,$zone_id,1);
                                $this->Csv->I_AdToCategory_Subcategory($adid,$zone_id,$v['cuisines'],$v['category']);
                                $this->Csv->I_Addealtitle($addressid,$adid); 
                            }
                        }
                    }
                }
            }
        }
        echo json_encode(['insertedtotal'=>count($dataArr),'insert' => 1,'srcheck' => $srcheck]);
    }

    public function csvimportorganization(){
        $categoryid= $starterad = '1';
        $zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:''; 
        $dataArr = isset($_REQUEST['dataArr'])?$_REQUEST['dataArr']:[];
        $arr_pass = array() ;
        $arr_pass[] = $this->TryvaryRandomString(10);
        $r = rand(0,count($arr_pass)-1) ;
        $pass = $arr_pass[$r] ;
        $salt=substr(md5(uniqid(rand(), true)), 0, 10);
        $password=$salt.substr(sha1($salt.$pass),0,-10);
        $srcheck = 0;
        if(count($dataArr) > 0){
            //echo"<pre>";print_r($dataArr);die('here');
            foreach ($dataArr as $k => $v) {
                $srcheck++;
                if(strtolower($v['phone']) == strtolower('Phone') && strtolower($v['email']) == strtolower('email') && strtolower($v['address']) == strtolower('Address')){
                    continue;
                }
                $replace_number='.';
                $phone_no=str_replace($replace_number, '',$v['phone']);
                //print_r($v['phone']);die('here1');
                //print_r($phone_no);die('here1');
                $errorArr = [];
                if($v['zipcode'] == ''){$errorArr[] = 'Zipcode empty';}
                // if($v['state'] == ''){$errorArr[] = 'State empty';}
                // if($v['city'] == ''){$errorArr[] = 'City empty';}
                //if($v['accounttype'] == ''){$errorArr[] = 'Account Type empty';}
                // if($v['organizationname'] == ''){$errorArr[] = 'Organization Name empty';}
                // if($v['username'] == ''){$errorArr[] = 'Username empty';}
                // if($v['email'] == ''){$errorArr[] = 'Email empty';}
                // if($v['firstname'] == ''){$errorArr[] = 'Firstname empty';}
                // if($v['lastname'] == ''){$errorArr[] = 'lastname empty';}
                if($phone_no == ''){$errorArr[] = 'Phone empty';}
                // if($v['address'] == ''){$errorArr[] = 'Address empty';}
                if($phone_no != ''){
                    if(!is_numeric($phone_no)){
                        $errorArr[] = 'phone number must be numeric';
                    }
                    if(strlen($phone_no) > 10){
                        $errorArr[] = 'phone number must be 10 digits';
                    }
                    $addquery="SELECT phone FROM users WHERE phone='".$phone_no."'";
                    $exists = $this->CommonController->SelectRawquery($addquery, 'count');
                    if($exists > 0){
                        $errorArr[] = 'phone number already registered';   
                    }
                }
                if(count($errorArr) > 0){
                    $errorimplode = implode(',', $errorArr);
                    $errordata = array(  
                    'zipcode'           => $v['zipcode'],  
                    'state'           => $v['state'],
                    'city'     => $v['city'], 
                    'accounttype'        => $v['accounttype'], 
                    'organizationname' => $v['organizationname'], 
                    'username'       => $v['username'],
                    'email'        => $v['email'], 
                    'firstname'         => $v['firstname'], 
                    'lastname'            => $v['lastname'],
                    'phone'           => $phone_no, 
                    'address'             => $v['address'],  
                    'errorStatus' =>$errorimplode,
                    'date' =>date('Y-m-d'), 
                );
                    $this->CommonController->InsertData('csverrororganization', $errordata);
                    continue;
                }
                if(count($errorArr) <= 0){
                    if($v['zipcode'] != ''){
                        $sql = 'SELECT * from zip_code_zone WHERE zip_code= '.$v['zipcode'].'';
                        $zipArr = $this->CommonController->SelectRawquery($sql,'row');
                        $zone_id = isset($zipArr->zone_id)?$zipArr->zone_id:213;
                        if($v['username'] == ''){
                            $username = $v['firstname'].$v['lastname'];
                        }else{
                            $username = $v['username'];
                        } 
                        $this->Zonedashboard->organization_registration(-1,$v['organizationname'],$v['accounttype'],$v['email'],$username,$v['zipcode'],$v['state'],$v['city'],$v['firstname'],$v['lastname'],$phone_no,$v['address'],$password,$salt,$pass,$zone_id,1);
                    }
                }
            }
        }
        echo json_encode(['insertedtotal'=>count($dataArr),'insert' => 1,'srcheck' => $srcheck]);
    }

    public function getbusinesscount(){
        $zone_id = $_REQUEST['zone_id'];
        $sql = 'SELECT businessid from ads_setting_preferences WHERE settingszoneid= '.$zone_id.'';
        $businesidArr = $this->CommonController->SelectRawquery($sql);
        $busArr = [];
        foreach ($businesidArr as $k => $v) {
            $busArr[] = $v['businessid'];   
        }
        echo json_encode(['msg' =>'businesscount','count'=>count($busArr),'data'=>$busArr]);
    }

    public function delbusinessdata(){
        $zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:'';
        $busArr = isset($_REQUEST['dataArr'])?$_REQUEST['dataArr']:[]; 
        $address1 = $useridArr = $usernameArr1 = $tbl_idArr1 = [];
        $addressArr = $this->CommonController->SelectDataMultiWay('business','addressid,business_owner_id','ArrayInR',[],['column'=>'id','param'=>$busArr],'',[]);
        if(count($addressArr) > 0){
            foreach ($addressArr as $k => $v) {
                $address1[] = $v->addressid;   
                $useridArr[] = $v->business_owner_id;
            }
        }
        $usernameArr = $this->CommonController->SelectDataMultiWay('users','username','ArrayInR',[],['column'=>'id','param'=>$useridArr],'',[]);
        if(count($usernameArr) > 0){
            foreach ($usernameArr as $k => $v) {
                $usernameArr1[] = $v->username;   
            }
        }
        $tbl_idArr = $this->CommonController->SelectDataMultiWay('tbl_member','user_id','ArrayInR',[],['column'=>'user_name','param'=>$usernameArr1],'',[]);
        if(count($tbl_idArr) > 0){
            foreach ($tbl_idArr as $k => $v) {
                $tbl_idArr1[] = $v->user_id;   
            }
        }
        $this->CommonController->deleteData('ads_setting_preferences',['settingszoneid'=> $zone_id]);
        $this->CommonController->deleteData('business',[],['id'=>$busArr],'whereIn');
        $this->CommonController->deleteData('ads',[],['business_id'=>$busArr],'whereIn');
        $this->CommonController->deleteData('ad_to_zone',['zoneid'=>$zone_id]);
        $this->CommonController->deleteData('business_sponsor',['zone_id'=>$zone_id]);
        $this->CommonController->deleteData('business_sponsor_order',['zoneid'=>$zone_id]);
        $this->CommonController->deleteData('ad_category_subcategory',['zoneid'=>$zone_id]);
        $this->CommonController->deleteData('address',[],['id'=>$address1],'whereIn');
        $this->CommonController->deleteData('users',[],['id'=>$useridArr],'whereIn');
        $this->CommonController->deleteData('tbl_member',[],['user_id'=>$tbl_idArr1],'whereIn');
        $this->CommonController->deleteData('tbl_deals_products',[],['user_id'=>$tbl_idArr1],'whereIn');
        $this->CommonController->deleteData('tbl_deals',[],['user_id'=>$tbl_idArr1],'whereIn');
        echo json_encode(['deletedtotal'=>count($busArr),'deleted' => 1]); 
    }














    public function csvimportbackup(){
        $allowed =  array('csv');
        $zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:'';
        $locationpath = "./assets/SavingsUpload/CSV/".$zone_id;
        $dataArr = [];
        $categoryid= $starterad = '1';
        if(is_dir($locationpath)==false){ mkdir($locationpath,0777);}
        $filename = $_FILES['file']['name'];
        $uploaded_file = $_FILES['file']['tmp_name'];

        $arr_pass = array() ;
        $arr_pass[] = "changepassword" ;
        $r = rand(0,count($arr_pass)-1) ;
        $pass = $arr_pass[$r] ;
        $salt=substr(md5(uniqid(rand(), true)), 0, 10);
        $password=$salt.substr(sha1($salt.$pass),0,-10);


       

        if(isset($_FILES['file'])){
            $name = $_FILES['file']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if(!in_array($ext,$allowed) ) {
                echo json_encode(['msg'=>'Only CSV File Allowed','type'=>'warning']);
                die;
            }
            if(move_uploaded_file($uploaded_file, $locationpath.'/'.$filename)){
                $csv_file_header = fopen(base_url().'/assets/SavingsUpload/CSV/'.$zone_id.'/'.$filename.'', "r");
                $csv_file = fopen(base_url().'/assets/SavingsUpload/CSV/'.$zone_id.'/'.$filename.'', "r");

                $header = fgetcsv($csv_file_header,1000,",");
                fgetcsv($csv_file);
                while (($line = fgetcsv($csv_file)) !== FALSE) {
                    $rows[] = array_combine($header, $line);
                }
                if(count($rows) > 0){
                    foreach ($rows as $k => $v) {
                        $checkbycompanyandzip=$this->Csv->checkbycompanyandzip($v['company name'],$v['ZIP']);
                        


                        $addressid=$this->Csv->I_Address($v['Address'],$v['City'],$v['State'],$v['ZIP'],$v['Phone'],''); 
                        if(!empty($addressid)){ 
                            $businessid=$this->Csv->I_Business($v['company name'],$addressid, $v['first name'], $v['last name'], $v['email'], $v['website'], $v['About'], $v['LOGO URL'], $v['Vicinity'], $v['Hours of operation']);
                            if(!empty($businessid)){
                                $userid=$this->Csv->I_User($v['Phone'],$v['email'],$v['first name'], $v['last name'],$password,$salt,$pass,$zone_id);
                                $peekaboo_user=$this->Csv->I_Peekaboo_User($v['Phone'],$password,$pass,$v['email'],$v['first name'],$v['last name'],$v['company name']);
                                if(!empty($userid)){
                                    $this->Csv->U_BussinessOwner($businessid,$userid);
                                    $this->Csv->I_Addsetting($zone_id,$businessid,1,$v['Ranking']); 
                                    if(!empty($v['Deal ID'])){
                                        $this->Csv->I_Deal($userid,$zone_id,$businessid,$v['Deal ID'],$v['Image URL'],$v['Cuisines'],$v['Deal Title'],$v['company name']);
                                    }
                                    $adid=$this->Csv->I_Ad($v['Image URL'],$businessid,$starterad,$v['Main Category'],$v['Cuisines'],$v['Deal Title']);
                                    if(!empty($adid)){
                                        $this->Csv->I_AdToZone($adid,$zone_id,1);
                                        $this->Csv->I_AdToCategory_Subcategory($adid,$zone_id,$v['Cuisines']);
                                        $this->Csv->I_Addealtitle($addressid,$adid); 
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }
    }

    public function csvimportmap(){
        $allowed =  array('csv');
        $zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:1000001;
        $restype = isset($_REQUEST['restype'])?$_REQUEST['restype']:'';
        $locationpath1 = "./assets/SavingsUpload/CSV/";
        if(is_dir($locationpath1)==false){ mkdir($locationpath1,0777);}

        $locationpath = "./assets/SavingsUpload/CSV/".$zone_id;
        if(is_dir($locationpath)==false){ mkdir($locationpath,0777);}

        $filename = $_FILES['file']['name'];
        if(isset($_FILES['file'])){
            $name = $_FILES['file']['name'];
            $uploaded_file = $_FILES['file']['tmp_name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if(!in_array($ext,$allowed) ) {
                echo json_encode(['msg'=>'Only CSV File Allowed','type'=>'warning']);
                die;
            }
            if(move_uploaded_file($uploaded_file, $locationpath.'/'.$filename)){
                $path = base_url().'/assets/SavingsUpload/CSV/'.$zone_id.'/'.$filename;
                $csv_file_header = fopen($path, "r");
                $header = fgetcsv($csv_file_header,1000,",");
                
                $arrtablecolmuns=$this->GetTableColumns('csv_uploader_allcolumns',$restype);
                $arrfilecolumns= $this->GetFileColumns($path);
                /*check column in upload file*/
                if(count($arrfilecolumns) != count($arrtablecolmuns)){
                    $unlinkpath = $_SERVER['DOCUMENT_ROOT'].'/assets/SavingsUpload/CSV/'.$zone_id.'/'.$filename;
                    unlink($unlinkpath);
                    echo json_encode(['msg'=>'Please Upload Right CSV','type'=>'warning']);
                    die;
                }
                /*check column in upload file*/
                foreach ($arrtablecolmuns as $k => $v) {
                    foreach ($header as $k1 => $v1) {
                        $v1 = preg_replace('/\x{EF}\x{BB}\x{BF}/', '', $v1);
                        if($restype == 1){
                            if($v=="firstname" and in_array(strtolower($v1),['first name','firstname','first_name','firstname','fname','f_name'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="lastname" and in_array(strtolower($v1),['last name','last_name','lname','lastname','name','l_name'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="contactfullname" and in_array(strtolower($v1),['contactname','contact name','contact_name','contactfullname','contact_full_name'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="companyname" and in_array(strtolower($v1),['company name','company_name','businessname','business_name','bus_name','companyname'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="zip" and in_array(strtolower($v1),['zip','zip_code','zip code','zipcode'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="image" and in_array(strtolower($v1),['image url','imageurl','image','image_url'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="category" and in_array(strtolower($v1),['main category','maincategory','main_category','category'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="dealid" and in_array(strtolower($v1),['deal id','dealid','deal_id','did'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="dealtitle" and in_array(strtolower($v1),['deal title','dealtitle','deal_title','dtitle'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="logourl" and in_array(strtolower($v1),['logo url','logo_url','logourl','logo'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="address" and in_array(strtolower($v1),['address'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="city" and in_array(strtolower($v1),['city'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="state" and in_array(strtolower($v1),['state'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="phone" and in_array(strtolower($v1),['phone','cell_phone','mobile','tel','telephone'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="website" and in_array(strtolower($v1),['website','link','url','site'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="email" and in_array(strtolower($v1),['email','emailaddress','e_mail','mail','e-mail'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="cuisines" and in_array(strtolower($v1),['cuisines','sub_category','sub-category','subcategory','scategory','subcat'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="ranking" and in_array(strtolower($v1),['ranking'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="about" and in_array(strtolower($v1),['about','aboutus','about_us','aboutme'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="vicinity" and in_array(strtolower($v1),['vicinity'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="hours_of_operation" and in_array(strtolower($v1),['hours of operation','hours_of_operation','hoursofoperation'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="history" and in_array(strtolower($v1),['history'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="alemail" and in_array(strtolower($v1),['alemail','al email','al_email','alternate email','alternate email','alternate_email','alternateemail'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="alfname" and in_array(strtolower($v1),['alfname','al fname','al_fname','alternate fname','alternate fname','alternate_fname','alternatefname','alternate firstname'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="allname" and in_array(strtolower($v1),['allname','al lname','al_lname','alternate lname','alternate lname','alternate_lname','alternatelname','alternate lastname'])){
                                $this->updateindex($k1,$v,$restype);
                            }
                        }else if($restype == 3){
                            if($v=="state" and in_array(strtolower($v1),['state'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="city" and in_array(strtolower($v1),['city'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="username" and in_array(strtolower($v1),['uname','username','user name','user_name'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="email" and in_array(strtolower($v1),['email','emailaddress','e_mail','mail','e-mail'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="organizationname" and in_array(strtolower($v1),['organizationname','organization name','organization_name'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="firstname" and in_array(strtolower($v1),['first name','firstname','first_name','firstname','fname','f_name'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="accounttype" and in_array(strtolower($v1),['accounttype','account_type','account type'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="lastname" and in_array(strtolower($v1),['last name','last_name','lname','lastname','name','l_name'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="zipcode" and in_array(strtolower($v1),['zip','zip_code','zip code','zipcode'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="phone" and in_array(strtolower($v1),['phone','cell_phone','mobile','tel','telephone'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="address" and in_array(strtolower($v1),['address'])){
                                $this->updateindex($k1,$v,$restype);
                            }if($v=="salezone" and in_array(strtolower($v1),['salezone','sale zone','sale_zone'])){
                                $this->updateindex($k1,$v,$restype);
                            }
                        }
                    }
                }
                $this->CommonController->setSession('csvpath', $path);
                $this->CommonController->setSession('zoneid', $zone_id);
                $this->CommonController->setSession('csvfilename', $filename);
                $this->CommonController->setSession('restype', $restype);
            }
        }
        echo json_encode(['msg' =>'file Uploaded','type'=>'success','status'=>1]);    
    }

    public function GetFileColumns($file){
        $csv_file_header = fopen($file, "r");
        $header = fgetcsv($csv_file_header,1000,",");
        return $header;
    }

    public function GetTableColumns($table, $type){
        $columns=array();
        $sql="select columns from ".$table." where visibility = 1 AND type=".$type." ORDER BY mapindex";
        $row = $this->CommonController->SelectRawquery($sql);
        foreach ($row as $v) {
            $columns[]=$v['columns'];
        }
        return $columns;
    }

    public function updateindex($index,$columns, $type){
         $this->CommonController->updateData('csv_uploader_allcolumns',['mapindex' =>$index],['columns'=>$columns,'type'=> $type]);
    }

    public function download_error_csv(){
        $unrestype = isset($_GET['unrestype'])?$_GET['unrestype']:0;
        if($unrestype == 3){
            $filename = "organization_upload_error_" . date('Y-m-d') . ".csv"; 
            $sql = "SELECT * FROM csverrororganization  WHERE `date`='".date('Y-m-d')."'";
            $headerFileds = array('id', 'phone', 'accounttype', 'organizationname', 'username', 'email', 'firstname', 'lastname', 'address', 'city', 'state', 'zipcode','errorStatus', 'date'); 
        }else{
            $filename = "business_upload_error_" . date('Y-m-d') . ".csv"; 
            $sql = "SELECT * FROM csverror  WHERE `date`='".date('Y-m-d')."'";
            $headerFileds = array('id', 'phone', 'email', 'companyname', 'vicinity', 'contactfullname', 'firstname', 'lastname', 'address', 'city', 'state', 'zip', 'website', 'dealid', 'dealtitle', 'image', 'category', 'cuisines', 'ranking', 'logourl', 'about', 'hours_of_operation', 'history', 'alEmail', 'alFname', 'alLname', 'errorStatus','Upload status', 'date'); 
        }
        $errordata = $this->CommonController->SelectRawquery($sql);
        if(count($errordata) > 0){
            $delimiter = ","; 
            $f = fopen('php://memory', 'w'); 
            $fields = $headerFileds;
            fputcsv($f, $fields, $delimiter); 
            if($unrestype == 3){
                foreach ($errordata as $k => $row) {
                    $lineData = array($row['id'], $row['phone'], $row['accounttype'], $row['organizationname'], $row['username'], $row['email'], $row['firstname'], $row['lastname'], $row['address'], $row['city'], $row['state'], $row['zipcode'], $row['errorStatus'], $row['date']);
                    fputcsv($f, $lineData, $delimiter);   
                }
            }else{
                foreach ($errordata as $k => $row) {
                    if($row['rowinsert'] == 'no'){
                        $insertrow = 'No';
                    }else{
                        $insertrow = 'Yes';
                    }
                    $lineData = array($row['id'], $row['phone'], $row['email'], $row['companyname'], $row['vicinity'], $row['contactfullname'], $row['firstname'], $row['lastname'], $row['address'], $row['city'], $row['state'], $row['zip'], $row['website'], $row['dealid'], $row['dealtitle'], $row['image'], $row['category'], $row['cuisines'], $row['ranking'], $row['logourl'], $row['about'], $row['hours_of_operation'],$row['history'],$row['alemail'],$row['alfname'],$row['allname'], $row['errorStatus'],$insertrow, $row['date']);
                    fputcsv($f, $lineData, $delimiter);   
                }    
            }
            
        
            fseek($f, 0); 
            header('Content-Type: text/csv'); 
            header('Content-Disposition: attachment; filename="' . $filename . '";'); 
            fpassthru($f);
        }
        exit;
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

    public function uploadorganization(){
        $filenamedd = isset($_GET['filenamedd'])?$_GET['filenamedd']:''; 
        $arr_pass = array() ;
        $arr_pass[] = $this->TryvaryRandomString(10);
        $r = rand(0,count($arr_pass)-1) ;
        $pass = $arr_pass[$r] ;
        $salt=substr(md5(uniqid(rand(), true)), 0, 10);
        $password=$salt.substr(sha1($salt.$pass),0,-10);
        $csv_file = fopen(base_url().'/assets/SavingsUpload/CSV/'.$filenamedd.'.csv', "r");
        $n = 0; 
        while(($row = fgetcsv($csv_file)) !== FALSE) { 
            $zip = $row[0];
            $state = $row[1];
            $city = $row[2];
            $accounttype = $row[3];
            $organization_name = $row[4];
            $username = $row[5];
            $email = $row[6];
            $first_name = $row[7];
            $last_name = $row[8];
            $phone_no = $row[9];
            $address = $row[10];
            if($n > 0){
                echo $n."<br>";
            $errorArr = [];
            $replace_number='.';
            $phone_no=str_replace($replace_number, '',$phone_no);
            $phone_no=str_replace('(', '',$phone_no);
            $phone_no=str_replace(')', '',$phone_no);
            $phone_no=str_replace('-', '',$phone_no);
            if($phone_no == ''){$errorArr[] = 'Phone empty';}
            if($phone_no != ''){
                if(!is_numeric($phone_no)){
                    $errorArr[] = 'phone number must be numeric';
                }
                if(strlen($phone_no) > 10){
                    $errorArr[] = 'phone number must be 10 digits';
                }
                $addquery="SELECT phone FROM users WHERE phone='".$phone_no."'";
                $exists = $this->CommonController->SelectRawquery($addquery, 'count');
                if($exists > 0){$errorArr[] = 'phone number already registered';}
            }
            if(count($errorArr) > 0){
                $errorimplode = implode(',', $errorArr);
                $errordata = array('zipcode' => $zip,'state' => $state,'city' => $city,'accounttype' => $accounttype,'organizationname' => $organization_name,'username' => $username,'email' => $email,'firstname' => $first_name,'lastname' => $last_name,'phone' => $phone_no,'address' => $address,'errorStatus' =>$errorimplode,
                    'date' =>date('Y-m-d'));
                $this->CommonController->InsertData('csverrororganization', $errordata);
                continue;
            }
            if(count($errorArr) <= 0){
                if($zip != '' && $zip != 0){
                    $sql = 'SELECT * from zip_code_zone WHERE zip_code= '.$zip.'';
                    $zipArr = $this->CommonController->SelectRawquery($sql,'row');
                    $zone_id = isset($zipArr->zone_id)?$zipArr->zone_id:213;
                    if($username == ''){
                        $username = $first_name.$last_name;
                    }else if($firstname == '' || $last_name == ''){
                        $username = str_replace(' ', '-', $organization_name); 
                        $username = preg_replace('/[^A-Za-z0-9\-]/', '', $username);
                        $username = preg_replace('/-+/', '-', $username);
                    }else{
                        $username = $username;
                    } 
                    $sql = 'SELECT * from organization WHERE name LIKE "'.trim($organization_name).'" AND zip= '.$zip.'';
                    $existArr = $this->CommonController->SelectRawquery($sql);
                    if(count($existArr) <= 0){
                        $this->Zonedashboard->organization_registration(-1,$organization_name,$accounttype,$email,$username,$zip,$state,$city,$first_name,$last_name,$phone_no,$address,$password,$salt,$pass,$zone_id,1);
                    }
                }
            }
        }$n++;
    }  
    fclose($csv_file); 
    echo "uploaded";
    die;
    }
}