<?php
namespace App\Models\csv;

use CodeIgniter\Model;
use App\Controllers\CommonController;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class Csv extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->CommonController = new CommonController();
    }
    
    public function checkbycompanyandzip($bname,$zip_code){
        if(trim($bname)!=''){  
            $sql="SELECT COUNT(a.id) AS id FROM business a,address b WHERE a.addressid=b.id AND a.name='".$bname."' AND b.zip_code='".$zip_code."'";
            $e = $this->CommonController->SelectRawquery($sql);
            if(count($e) > 0){ $id=1;}
            else{ $id=0;}
        }else{ $id=2;}
        return $id;
    }

    public function I_Address($street_address_1,$city,$state,$zip_code,$phone,$fax = '',$street_address_2 =''){
        $phone_int=$phone;
        $q = '';
        if($phone==1){
            $q="SELECT id FROM address WHERE street_address_1='".$street_address_1."'  AND city='".$city."' AND state='".$state."' AND zip_code='".$zip_code."' ORDER BY id DESC LIMIT 0,1";
        } 
        if($q != ''){
            $e = $this->CommonController->SelectRawquery($sql, 'row');
            $id=$e->id;
        }else{
            $addressData = array(
                'street_address_1' => $street_address_1,
                'street_address_2' => $street_address_2,
                'city' => $city,
                'state' => $state,
                'zip_code' => $zip_code,
                'phone' => $phone,
                'phone_int' => $phone_int,
                'fax' => $fax
            );
            $id = $this->CommonController->InsertData('address', $addressData);
        }
        return $id;
    }

    public function I_Business($bname = '',$addressid = '',$firstname = '', $lastname = '', $email = '', $website = '', $about = '',$logourl = '',$vicinity = '', $hours_of_operation ='',$history ='',$categoryid = ''){
        if(trim($bname) == ""){
            $q="SELECT id FROM business WHERE contactfirstname='".$firstname."' AND contactlastname='".$lastname."' AND addressid='".$addressid."'";
        }else{
            $q="SELECT id FROM business WHERE name='".$bname."' AND addressid='".$addressid."'";
        }
        
        if($categoryid == 1){
            $type = 1;
        }else{
            $type = 0;
        }
        $e = $this->CommonController->SelectRawquery($q, 'row');
        if($e != ''){
            $id=$e->id;
        }else{
            $businessData = array(
                'type' => $type,
                'name' => $bname,
                'addressid' => $addressid,
                'contactemail' => $email,
                'siccode' => 0,
                'contactfirstname' => $firstname,
                'contactlastname' => $lastname,
                'contactfullname' => $firstname.' '.$lastname,
                'website' => $website,
                'starttime' => 0,
                'stoptime' => 0,
                'business_owner_id' => 0,
                'aboutus' => $about,
                'vicinity' => $vicinity,
                'hours_of_operation' => $hours_of_operation,
                'history' => $history,
                'logo' => $logourl,
                'insert_via_csv'=> 1
            );
            $id = $this->CommonController->InsertData('business', $businessData);
            
            // $url = $logourl;
            // $parsedUrl = parse_url($url);
            // $pathInfo = pathinfo($parsedUrl['path']);
            // $saveImagePath =   $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/Business/".$id;  
            // if(is_dir($saveImagePath)==false){mkdir($saveImagePath,0777);}
            // $businessimagedirectory = $saveImagePath.'/'.$pathInfo['filename'].'.'.$pathInfo['extension'];
            // $content = file_get_contents($url); 
            // file_put_contents($businessimagedirectory, $content);
            // $imagePath = $pathInfo['filename'].'.'.$pathInfo['extension'];

            // $this->CommonController->updateData('business',['logo' =>$imagePath],['id'=>$id]);
        }
        return $id;
    }

    public function I_User($username,$email,$firstname, $lastname,$password,$salt,$pass,$zone_id,$alemail, $alfname,$allname){
        $q="SELECT id FROM users  WHERE username='".$username."' AND email='".$email."'";
        $e = $this->CommonController->SelectRawquery($q, 'row');
        if($e != ''){
            $id=$e->id;
        }else{
            $usersData = array(
                'username' => $username,
                'email' => $email,
                'first_name' => $firstname,
                'last_name' => $lastname,
                'password' => $password,
                'salt' => $salt,
                'uploaded_business_password' => $pass,
                'active' => 1,
                'Zone_ID' => $zone_id,
                'password_change' => 1,
                'alemail' => $alemail,
                'alfname' => $alfname,
                'allname' => $allname
            );
            $id = $this->CommonController->InsertData('users', $usersData);
            $this->I_UserGroup($id,5);
        }
        return $id;
    }

    public function I_UserGroup($userid,$type){
        $q = "SELECT id FROM users_groups WHERE user_id='".$userid."' AND group_id='".$type."'";
        $e = $this->CommonController->SelectRawquery($q, 'row');
        if($e == ''){
            $usersgroupData = array(
                'user_id' => $userid,
                'group_id' => $type
            );
            $id = $this->CommonController->InsertData('users_groups', $usersgroupData);
        }
    } 

    public function I_Peekaboo_User($username,$password,$pass,$email,$fName,$lName,$company_name){
        $register_date = date("Y-m-d H:i:s");
        $last_login = date("Y-m-d H:i:s");
        $q="SELECT user_id FROM tbl_member  WHERE user_name='".$username."'";
        $e = $this->CommonController->SelectRawquery($q, 'row');
        if($e != ''){
            $id=$e->user_id;   
        }else{
            $activated = 'yes';
            $peekaboo_pass=sha1($pass);

            $tbl_memberData = array(
                'user_name' => $username,
                'email' => $email,
                'phone' => $username,
                'fName' => $fName,
                'lName' => $lName,
                'password' => $peekaboo_pass,
                'activated' => $activated,
                'company_name' => $company_name,
                'register_date' => $register_date,
                'last_login' => $last_login
            );
            $id = $this->CommonController->InsertData('tbl_member', $tbl_memberData);
        }
        return $id;
    }

    public function U_BussinessOwner($bussinessid,$userid){
       $this->CommonController->updateData('business',['business_owner_id' =>$userid],['id'=>$bussinessid]);
    }
    
    public function I_Addsetting($zoneid,$businessid,$bizstatus,$ranking){ 
        $q= "SELECT id FROM ads_setting_preferences  WHERE businessid='".$businessid."' AND settingszoneid='".$zoneid."'";
        $e = $this->CommonController->SelectRawquery($q, 'row');
        if($e != ''){
            $id=$e->id;   
        }else{
            $ads_setting_preferencesdata = array(
                'businessid' => $businessid,
                'settingszoneid' => $zoneid,
                'isdefault' => $bizstatus,
                'approval' => 2
            );
            $id = $this->CommonController->InsertData('ads_setting_preferences', $ads_setting_preferencesdata);
            $this->CommonController->InsertData('business_sponsor',['business_id' => $businessid,'status' => 1,'zone_id' => $zoneid]);
            $this->CommonController->InsertData('business_sponsor_order',['business_id' => $businessid,'display_order' => $ranking,'zoneid' => $zoneid]);
        }
        return $id;
    }
    
    public function I_Deal($userid,$zoneid,$businessid,$dealId, $image,$subcat,$dealDescription,$businessname){ 
        $auction_sql_setting = 'select tbl_member.user_id from business inner join users on users.id = business.business_owner_id inner join tbl_member on tbl_member.user_name = users.username where business.id = '.$businessid;
        $e = $this->CommonController->SelectRawquery($auction_sql_setting, 'row');
        $userid = $e->user_id;  
        
        $businessData="SELECT * FROM business where id =".$businessid;
        $business_Data = $this->CommonController->SelectRawquery($businessData, 'rowArray');  
        if($dealId != ''){
            if(!in_array($dealId,array(1,2,3,4,5,6,7,8,9,10,11))){
                $dealidqry="SELECT * FROM category_sub_subcategory_new where id =".$subcat;
                $dealidArr = $this->CommonController->SelectRawquery($dealidqry, 'row'); 
                $dealId =  $dealidArr->dealId;
            }
        }else{
            $dealidqry="SELECT * FROM category_sub_subcategory_new where id =".$subcat;
            $dealidArr = $this->CommonController->SelectRawquery($dealidqry, 'row'); 
            $dealId =  $dealidArr->dealId;
        }
        // $url = $image;
        // $parsedUrl = parse_url($url);
        // $pathInfo = pathinfo($parsedUrl['path']);
        // $saveImagePath = $_SERVER['DOCUMENT_ROOT']."/assets/SavingsUpload/Business/".$businessid;

        // if(is_dir($saveImagePath)==false){mkdir($saveImagePath,0777);}
        // $ckeditor_directory = $saveImagePath.'/'.$pathInfo['filename'].'.'.$pathInfo['extension'];
        // // $content = file_get_contents($url); 
        // // file_put_contents($ckeditor_directory, $content);
        // $filename =  $pathInfo['filename'].'.'.$pathInfo['extension'];
        $current_date_time=date('Y-m-d H:i:s');

        $q= "SELECT * FROM deal_cashcert  where id =".$dealId;
        $row = $this->CommonController->SelectRawquery($q, 'rowArray');  
        if($row != ''){
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d', strtotime('+30 days')); 
            $tbl_deals_productsData = array( 
                'cat_id' => '1', 
                'subcat_id' => $subcat, 
                'product_name'=>'CC-0-1', 
                'company_name'=> $business_Data['name'],    
                'units_in_stock'=>'1', 
                'last_modify_date'=>$current_date_time,
                'card_img'=>$image,
                'status'=>'available',
                'user_id'=>$userid,
                'member_type'=>'4',
                'approval_status'=>'1',
                'cert_accept'=>'accepted',
                'nobypass'=>'0',   
                'publisher_fee' =>$row['donationClaimingFee'], 
                'numberofconsolation' => $row['numberOfDeals'], 
                'tech_description'=>$dealDescription,
                'other_description'=>$dealDescription,
                'description'=>$dealDescription,
                'seller_fee'=>$row['donationClaimingFee'],
                'parent_id'=> '0',
                'zone_id'=>$zoneid, 
                'insert_via_csv'=>1 
            ); 
            $product_id = $this->CommonController->InsertData('tbl_deals_products', $tbl_deals_productsData);
            if($product_id){
                $tbl_dealsData = array(  
                    'product_id'=>$product_id,
                    'buy_price_charge'=>$row['dealRedemption'], 
                    'selected_deal' =>$dealId, 
                    'buy_price_decrease_by'=>$row['dealRedemption'],
                    'current_price'=>$row['discountedPrice'], 
                    'low_limit_price'=>$row['discountedPrice'],
                    'start_date'=>$start_date,
                    'end_date'=>$end_date,
                    'created_date'=>$current_date_time,
                    'auction_type'=>'RTP',
                    'status'=>'Live',
                    'automate_create'=>'0',
                    'display'=>'yes',
                    'banner'=>'yes',
                    'hot_auction'=>'yes',
                    'last_update'=>$current_date_time,
                    'page_title'=>$dealDescription,
                    'deal_title'=>$dealDescription,
                    'deal_description'=>$dealDescription, 
                    'meta_description'=>$dealDescription, 
                    'deal_description_link'=>$businessname, 
                    'user_id'=>$userid,
                    'approval_status'=>'1',
                    'zone_id'=>$zoneid
                );
                $this->CommonController->InsertData('tbl_deals', $tbl_dealsData);
            }
        }
    }
    
    public function I_Ad($image,$businessid,$starterad,$categoryid,$subcategoryid,$deal_title= '',$zone_id= ''){
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime('+30 days'));
        if($categoryid=='0'){
            $categoryid='0';
            $subcategoryid='0';
        }
        if($categoryid=='-99'){
            $categoryid='-99';
        }
        if($subcategoryid=='select' || $subcategoryid=='-99'){
            $subcategoryid='-99';
        }
        $deal_title="Deal Title";
        // $adtext = $pathInfo['filename'].'.'.$pathInfo['extension'];
        $short_description = 'We have not had a chance to post all our offers in the system- Please Contact Us for Our Offer!';
        $starterad = $deal_title;
        
        $adsdata = array(  
            'adtext'=>$image,
            'active'=>1, 
            'business_id' =>$businessid, 
            'categoryid'=>$categoryid,
            'subcategoryid'=>$subcategoryid, 
            'startdatetime'=>$start_date,
            'stopdatetime'=>$end_date,
            'deal_title'=>$deal_title,
            'deal_description'=>$starterad,
            'short_description'=>$short_description,
            'insert_via_csv'=>1
        );
        $id = $this->CommonController->InsertData('ads', $adsdata);
        $this->CommonController->updateData('ads',['search_engine_title' =>$id],['id'=>$id]);  

        $q= "SELECT id FROM category_display  WHERE catid='".$categoryid."' AND zoneid='".$zone_id."'";
        $exists = $this->CommonController->SelectRawquery($q,'count');
        if($exists <= 0){
            $this->CommonController->InsertData('category_display', ['catid'=>$categoryid,'zoneid'=>$zone_id]);
        }
        $this->CommonController->updateData('category_new',['status' =>1],['id'=>$categoryid]);
        return $id;
    }

    public function I_AdToZone($adid,$zoneid,$adstatus){
        $q= "SELECT id FROM ad_to_zone  WHERE adid='".$adid."' AND zoneid='".$zoneid."'";
        $e = $this->CommonController->SelectRawquery($q, 'row');
        if($e != ''){
            $id = $e->id;
        }else{
            $ad_to_zonedata = array(  
                'adid'=>$adid,
                'zoneid'=>$zoneid, 
                'approval' =>$adstatus, 
                
            );
            $id = $this->CommonController->InsertData('ad_to_zone', $ad_to_zonedata);
        }
        return $id;
    }
    
    public function I_AdToCategory_Subcategory($adid,$zoneid,$subcatid,$categoryid){
        $explode = explode(',',$subcatid);
        if(count($explode) > 0){
            foreach ($explode as $sub) {
                $ad_category_subcategorydata = array(  
                    'adid'=>$adid,
                    'catid'=>$categoryid, 
                    'subcatid' =>$sub, 
                    'zoneid' =>$zoneid, 
                    'display_zone' =>1
                );   
                $id = $this->CommonController->InsertData('ad_category_subcategory', $ad_category_subcategorydata);
                $q= "SELECT id FROM subcategory_display  WHERE subcatid='".$sub."' AND catid='".$categoryid."' AND zoneid='".$zoneid."'";
                $exists = $this->CommonController->SelectRawquery($q,'count');
                if($exists <= 0){
                    $this->CommonController->InsertData('subcategory_display',['subcatid'=>$sub,'catid'=>$categoryid,'zoneid'=>$zoneid]);
                }
                $this->CommonController->InsertData('business_sponsor_order_cat',['adid'=>$adid,'catid'=>$categoryid,'subcatid'=>$sub,'zoneid'=>$zoneid,'display_order'=>1]);
            }
        }
        return $id;
    }
    
    public function I_Addealtitle($addressid , $adid){  
        $q= "SELECT a.street_address_1,b.name FROM address a, business b  WHERE a.id=b.addressid and a.id=".$addressid;
        $row = $this->CommonController->SelectRawquery($q, 'rowArray');
        if(count($row) > 0){
            $address_name_1=str_replace(' ','-',$row['street_address_1']);
            $business_name_1=str_replace(' ','-',$row['name']);
            $address_name=preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ', '-',htmlentities(trim($address_name_1))));
            $business_name=preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ', '-',htmlentities(trim($business_name_1))));
            $deal_title=$business_name.'-'.$address_name;
            $deal_title = str_replace('--','-',$deal_title);
            $deal_title_val = rtrim($deal_title,'-');

            $deal_checksql = "select deal_title from ads where deal_title='".$deal_title_val."' OR deal_title='".$deal_title."'";
            $deal_query = $this->CommonController->SelectRawquery($deal_checksql, 'row');
            if($deal_query != ''){
                $this->I_Addealtitle1($addressid,$adid,$deal_title_val);
            }else{
                $this->CommonController->updateData('ads',['deal_title' =>$deal_title_val],['id'=>$adid]);
            }
        }
    }

    public function I_Addealtitle1($addressid,$adid,$deal_title_val){ 
        $deal_checksql = "select deal_title from ads where deal_title='".$deal_title_val."'";
        $deal_query = $this->CommonController->SelectRawquery($deal_checksql, 'row');   
        if($deal_query != ''){
            $deal_title_val = $deal_title_val.'1';
            $this->CommonController->updateData('ads',['deal_title' =>$deal_title_val],['id'=>$adid]);
            $this->I_Addealtitle1($addressid , $adid,$deal_title_val);
        }else{
            $this->CommonController->updateData('ads',['deal_title' =>$deal_title_val],['id'=>$adid]);
        }
    }
}