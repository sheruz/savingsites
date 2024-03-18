<?php
namespace App\Controllers;
use App\Models\IonAuthModel;
use App\Models\Zips;
use App\Models\Organization_model;
use App\Models\zone\Zone_model;
use App\Models\admin\Ads_model;
use App\Models\admin\Users;
use App\Models\Category_new_model;
use App\Models\dining\Diningmodel;
use App\Libraries\IonAuth;
use App\Models\admin\Sales_zone;
use App\Models\banner\Banner_model;
use App\Controllers\CommonController;
#[\AllowDynamicProperties]
class Api extends BaseController{
    var $tierI;
    var $tierII;
    var $tierIII;
    
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
        $this->SalesZone = new Sales_zone();
        $this->Banner_model = new Banner_model();
        $this->CommonController = new CommonController();
    } 
    
    public function getUser(){
        $contact = isset($_REQUEST['customerContact'])?$_REQUEST['customerContact']:'';
        $usercertArr = $finalArr = $resFavlistArr = [];
        if($contact == ''){
            $msg = json_encode(array('status' => 403,'type'=>'warning','msg' => 'Contact Number Should not be Empty','data' => ''));
            echo $msg;
            die;
        }

        $sql="select * from users where phone = '".$contact."'"; //get user data
        $query=$this->db->query($sql);
        $userArr = $query->result_array();
        $userid = $userArr[0]['id'];
        if(count($userArr) <= 0){
            $msg = json_encode(array('status' => 404,'type'=>'warning','msg' => 'Data Not Found.','data' => ''));
            echo $msg;
            die;    
        }

        $sql="select * from tbl_deals_purchased where userId = '".$userArr[0]['id']."'"; //get user data
        $query=$this->db->query($sql);
        $freecertsArr = $query->result_array();
        foreach ($freecertsArr as $k => $v) {
            $usercertArr[$v['userId']][] = array('certificateId' => $v['id'],'amountPrchased' => $v['amountPrchased'],'certificate_verify' => $v['certificate_verify']);
        }

        /*get fav res*/
        $this->db->select('business.name as resname,users_favorites_restaurant.*');
        $this->db->from('business');
        $this->db->where('users_favorites_restaurant.userid', $userid);
        $this->db->join('users_favorites_restaurant', 'business.id = users_favorites_restaurant.restaurant', 'left');
        $query = $this->db->get(); 
        $resfavArr = $query->result_array();
        foreach ($resfavArr as $key => $value) {
            /*get dish name*/
            $this->db->select('content');
            $this->db->from('menu_builder_multi_lang');
            $this->db->where('foreign_id', $value['fav_res']);
            $this->db->where(['model'=>'pjProduct','field' => 'name']);
            $query = $this->db->get()->row();
            $resfavArr[$key]['dishname'] = $query->content;  
            /**get dish name*/
            /*get dish price*/
            $this->db->select('price,image,status');
            $this->db->from('menu_builder_products');
            $this->db->where('id', $value['fav_res']);
            $this->db->where(['business_id'=>$value['restaurant']]);
            $query = $this->db->get()->row();
            $resfavArr[$key]['dishprice'] = $query->price;  
            $resfavArr[$key]['dishimage'] = $query->image;  
            $resfavArr[$key]['status'] = $query->status;  
            /**get dish price*/
        }
        foreach ($resfavArr as $fk => $fv) {
            $available = ($fv['status'] == 'T')?'available':'not available';
            $resFavlistArr[$fv['userid']][$fv['resname']][] = array(
                'restaurant_id'=> $fv['restaurant'],
                'restaurant_name'=> $fv['resname'],
                'dishid'=> $fv['fav_res'],
                'dishname'=> $fv['dishname'],
                'price'=> $fv['dishprice'],
                'image'=> $fv['dishimage'],
                'status'=> $available,

            );
        }
        /*get fav res*/

        foreach ($userArr as $k1 => $v1) {
            $finalArr['id'] = $v1['id'];
            $finalArr['username'] = $v1['username'];
            $finalArr['email'] = $v1['email'];
            $finalArr['first_name'] = $v1['first_name'];
            $finalArr['last_name'] = $v1['last_name'];
            $finalArr['countrycode'] = isset($v1['countrycode'])?$v1['countrycode']:'';
            $finalArr['phone'] = $v1['phone'];
            $finalArr['fav_res_list'] = isset($resFavlistArr[$v1['id']])?$resFavlistArr[$v1['id']]:[];
            // $finalArr['free_certs'] = isset($usercertArr[$v1['id']])?$usercertArr[$v1['id']]:[];
        }

        $data = json_encode(array('status' => 200,'type'=>'success','msg' => 'Customer Info ','data' => $finalArr));
        echo $data;
        die;
    }

    public function addServiceNumber(){
        $serviceno = isset($_REQUEST['serviceno'])?$_REQUEST['serviceno']:'';
        $restuarantno = isset($_REQUEST['restuarantContactno'])?$_REQUEST['restuarantContactno']:'';
        if($serviceno == '' || $restuarantno == ''){
            $msg = json_encode(array('status' => 403,'type'=>'warning','msg' => 'Service Number and Restuarant Number Should not be Empty','data' => ''));
            echo $msg;
            die;
        }
        /*check if exists*/
       $this->db->select('address.*,business.*');
        $this->db->from('business');
        $this->db->where('business.service_number', $serviceno);
        $this->db->join('address', 'business.addressid = address.id', 'left');
        $query = $this->db->get()->row(); 
        $phone = $query->phone; 
        if($phone > 0){
            if($phone != $restuarantno){
                $msg = json_encode(array('status' => 403,'type'=>'warning','msg' => 'Service Number Used in another Restaurant.','data' => ''));
                echo $msg;
                die;    
            }    
        }
        /*check if exists*/
        /*get rest ID*/
        $this->db->select('address.*,business.*');
        $this->db->from('business');
        $this->db->where('address.phone', $restuarantno);
        $this->db->join('address', 'business.addressid = address.id', 'left');
        $query = $this->db->get(); 
        $resArr = $query->result_array();
        if(count($resArr) <= 0){
            $msg = json_encode(array('status' => 404,'type'=>'warning','msg' => 'Restuarant Data Not Found.','data' => ''));
            echo $msg;
            die;    
        }
        $restuarant_id = isset($resArr[0]['id'])?$resArr[0]['id']:'';
        $this->db->where('id', $restuarant_id);
        $this->db->update('business', array('service_number' => $serviceno));
        $msg = json_encode(array('status' => 200,'type'=>'success','msg' => 'Service Number Updated Successfully','data' => array('service_nubmer' => $serviceno)));
            echo $msg;
            die;
    }

    public function get_business(){
        $serviceno = isset($_REQUEST['restuarantServiceno'])?$_REQUEST['restuarantServiceno']:'';
        $finalArr = $wrkArr = [];

        if($serviceno == ''){
            $msg = json_encode(array('status' => 403,'type'=>'warning','msg' => 'Service Number Can not be Empty','data' => ''));
            echo $msg;
            die;
        }

        $sql="select * from business where service_number = '".$serviceno."'"; //get user data
        $query=$this->db->query($sql);
        $resArr = $query->result_array();
        if(count($resArr) <= 0){
            $msg = json_encode(array('status' => 404,'type'=>'warning','msg' => 'Restuarant Data Not Found.','data' => ''));
            echo $msg;
            die;    
        }
        /*get business data*/
        $this->db->select('address.*,business.*');
        $this->db->from('business');
        $this->db->where('business.service_number', $serviceno);
        $this->db->join('address', 'business.addressid = address.id', 'left');
        $query = $this->db->get(); 
        $result = $query->result_array(); 
        if($result[0]['credits'] <= 0){
            $data = json_encode(array('status' => 403,'type'=>'warning','msg' => 'Restuarant has no credits','data' => ''));
            echo $data;
            die;
        }else{
            $res_id = isset($result[0]['id'])?$result[0]['id']:'';
            /*get ads*/
            $this->db->select('business_id,deal_title,deal_description,deliver_zips,deliver,timestamp,delivery_charges,delivery_time');
            $this->db->from('ads');
            $this->db->where('business_id', $res_id);
            $query = $this->db->get(); 
            $adsArr = $query->result_array();
            foreach ($adsArr as $ka => $va) {
                $adsArr1[$va['business_id']] = $va;
            }
            
            /*get ads*/
            /*get working time*/
            $this->db->select('*');
            $this->db->from('restaurantbooking_working_times');
            $this->db->where('business_id', $res_id);
            $query = $this->db->get(); 
            $workingArr = $query->result_array();
            $wrkArr = $wrkfinalArr = $menuArr1 = $menufinalArr = [];
            foreach ($workingArr as $ka => $va) {
                $wrkArr['monday'] = array('from' => $va['monday_from'],'to' => $va['monday_to'],'status'=> ($va['monday_dayoff'] == 'T'?'close':'open'));
                $wrkArr['tuesday'] = array('from' => $va['tuesday_from'],'to' => $va['tuesday_to'],'status'=> ($va['tuesday_dayoff'] == 'T'?'close':'open'));
                $wrkArr['wednesday'] = array('from' => $va['wednesday_from'],'to' => $va['wednesday_to'],'status'=> ($va['wednesday_dayoff'] == 'T'?'close':'open'));
                $wrkArr['thursday'] = array('from' => $va['thursday_from'],'to' => $va['thursday_to'],'status'=> ($va['thursday_dayoff'] == 'T'?'close':'open'));
                $wrkArr['friday'] = array('from' => $va['friday_from'],'to' => $va['friday_to'],'status'=> ($va['friday_dayoff'] == 'T'?'close':'open'));  
                $wrkArr['saturday'] = array('from' => $va['saturday_from'],'to' => $va['saturday_to'],'status'=> ($va['saturday_dayoff'] == 'T'?'close':'open'));
                $wrkArr['sunday'] = array('from' => $va['sunday_from'],'to' => $va['sunday_to'],'status'=> ($va['sunday_dayoff'] == 'T'?'close':'open'));   
                $wrkfinalArr[$va['business_id']][] = $wrkArr;
                // $wrkArr[$va['business_id']] = $va;
            }
            /*get working time*/

            /*get menu data*/
            $this->db->select('menu_builder_products.*');
            $this->db->from('menu_builder_categories');
            $this->db->where('menu_builder_categories.business_id', $res_id);
            $this->db->where('menu_builder_products.business_id', $res_id);
            $this->db->join('menu_builder_products', 'menu_builder_categories.id = menu_builder_products.category_id', 'left');
            $query = $this->db->get(); 
            $menuArr = $query->result_array();
            foreach ($menuArr as $key => $value) {
                /**get category name*/
                $this->db->select('content');
                $this->db->from('menu_builder_multi_lang');
                $this->db->where('foreign_id', $value['category_id']);
                $this->db->where(['model'=>'pjCategory','field' => 'name']);
                $query = $this->db->get()->row();
                $menuArr[$key]['categoryname'] = $query->content;     
                /**get category name*/

                /**get dish name*/
                $this->db->select('content');
                $this->db->from('menu_builder_multi_lang');
                $this->db->where('foreign_id', $value['id']);
                $this->db->where(['model'=>'pjProduct','field' => 'name']);
                $query = $this->db->get()->row();
                $menuArr[$key]['dishname'] = $query->content;  
                /**get dish name*/
            }
            foreach ($menuArr as $key => $value) {
                $menufinalArr[$value['business_id']][$value['categoryname']][] = array(
                    'dishname' => $value['dishname'],
                    'price' => $value['price'],
                    'image' => $value['image'],
                    'status' => ($value['status'] == 'T')?'available':'not available',
                );
            }
            /*get menu data*/

          


            foreach ($result as $k1 => $v1) {
                if($v1[' free_cert_dis_availability'] == 1){
                    $availavle = 'true';
                }else{
                    $availavle = 'false';
                }
                $ads = isset($adsArr1[$v1['id']])?$adsArr1[$v1['id']]:[];
                $workArr = isset($wrkfinalArr[$v1['id']])?$wrkfinalArr[$v1['id']]:[];
                $finalArr['res_id'] = $v1['id'];
                $finalArr['type'] = $v1['type'];
                $finalArr['name'] = $v1['name'];
                $finalArr['addressid'] = $v1['addressid'];
                $finalArr['contactemail'] = $v1['contactemail'];
                $finalArr['contactfirstname'] = $v1['contactfirstname'];
                $finalArr['contactlastname'] = $v1['contactlastname'];
                $finalArr['business_owner_id'] = $v1['business_owner_id'];
                $finalArr['motto'] = $v1['motto'];
                $finalArr['street_address_1'] = $v1['street_address_1'];
                $finalArr['street_address_2'] = $v1['street_address_2'];
                $finalArr['city'] = $v1['city'];
                $finalArr['zip_code'] = $v1['zip_code'];
                $finalArr['countrycode'] = isset($v1['countrycode'])?$v1['countrycode']:'';
                $finalArr['phone'] = $v1['phone'];
                $finalArr['audio_greetings'] = base_url().'/assets/audio/'.$v1['audio_greetings'];
                if($availavle == 'true'){
                    $finalArr['dicount'] = array('online_order_dicount' => $v1['online_order_dicount'],'cash_discount' => $v1['cash_discount'],'card_discount' => $v1['card_discount'],'pickup_discount' => $v1['pick_discount'],'delivery_discount' => $v1['delivery_discount'],'free_cert_dis_availability' => $availavle);
                }else{
                    $finalArr['dicount'] = array('cash_discount' => $v1['cash_discount'],'card_discount' => $v1['card_discount'],'pickup_discount' => $v1['pick_discount'],'delivery_discount' => $v1['delivery_discount'],'free_cert_dis_availability' => $availavle);
                }
                $finalArr['delivery'] = array('delivery_charges' => $ads['delivery_charges'],'delivery_time'=> $ads['delivery_time']);
                $finalArr['workingTime'] = $workArr;
                $finalArr['menu'] = isset($menufinalArr[$v1['id']])?$menufinalArr[$v1['id']]:[];
            }
            $data = json_encode(array('status' => 200,'type'=>'success','msg' => 'available','data' => $finalArr));
            echo $data;
            die;
        }
        /*get free certificate data*/

    }

    public function getDisCoupon(){
        $contact = isset($_REQUEST['customerContact'])?$_REQUEST['customerContact']:'';
        $restuarantno = isset($_REQUEST['restuarantServiceno'])?$_REQUEST['restuarantServiceno']:'';
        $finalArr = [];

        if($contact == '' || $restuarantno == ''){
            $msg = json_encode(array('status' => 403,'type'=>'warning','msg' => 'Customer Contact Number and Restuarant Number Should not be Empty','data' => ''));
            echo $msg;
            die;
        }

        /*get user id and res id*/
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('phone', $contact);
        $query = $this->db->get()->row();
        $userid = $query->id; 
        if($userid == ''){
            $msg = json_encode(array('status' => 404,'type'=>'warning','msg' => 'Customer Contact Number not Found','data' => ''));
            echo $msg;
            die;   
        }

        $this->db->select('address.*,business.*');
        $this->db->from('business');
        $this->db->where('business.service_number', $restuarantno);
        $this->db->join('address', 'business.addressid = address.id', 'left');
        $query = $this->db->get()->row();  
        $resid = $query->id; 
        if($resid == ''){
            $msg = json_encode(array('status' => 404,'type'=>'warning','msg' => 'Restuarant Contact Number not Found','data' => ''));
            echo $msg;
            die;   
        }
        /*get user id and res id*/
        
        $this->db->select('*');
        $this->db->from('tbl_deals_purchased');
        $this->db->where(['userId' => $userid,'busId' => $resid,'certificate_verify' => 0]);
        $query = $this->db->get(); 
        $result = $query->result_array();
        $disdataArr = [];
        foreach ($result as $k1 => $v1) {
            $disdataArr[$v1['userId']][$contact][] = array('dealId' =>$v1['dealId'],'user_type' => $v1['user_type'],'status' => 'available','discountAmount' => $v1['amountPrchased']);
           
        }
        

        /*get fav res*/
        $resFavlistArr1 = [];
        $this->db->select('business.name as resname,users_favorites_restaurant.*');
        $this->db->from('business');
        $this->db->where('users_favorites_restaurant.userid', $userid);
        $this->db->where('business.id', $resid);
        $this->db->join('users_favorites_restaurant', 'business.id = users_favorites_restaurant.restaurant', 'left');
        $query = $this->db->get(); 
        $resfavArr1 = $query->result_array();
        foreach ($resfavArr1 as $key => $value) {
            /*get dish name*/
            $this->db->select('content');
            $this->db->from('menu_builder_multi_lang');
            $this->db->where('foreign_id', $value['fav_res']);
            $this->db->where(['model'=>'pjProduct','field' => 'name']);
            $query = $this->db->get()->row();
            $resfavArr1[$key]['dishname'] = $query->content;  
            /**get dish name*/
            /*get dish price*/
            $this->db->select('price,image,status');
            $this->db->from('menu_builder_products');
            $this->db->where('id', $value['fav_res']);
            $this->db->where(['business_id'=>$value['restaurant']]);
            $query = $this->db->get()->row();
            $resfavArr1[$key]['dishprice'] = $query->price;  
            $resfavArr1[$key]['dishimage'] = $query->image;  
            $resfavArr1[$key]['status'] = $query->status;  
            /**get dish price*/
        }
        foreach ($resfavArr1 as $fk => $fv) {
            $available = ($fv['status'] == 'T')?'available':'not available';
            $resFavlistArr1[$fv['userid']][$fv['resname']][] = array(
                'restaurant_id'=> $fv['restaurant'],
                'restaurant_name'=> $fv['resname'],
                'dishid'=> $fv['fav_res'],
                'dishname'=> $fv['dishname'],
                'price'=> $fv['dishprice'],
                'image'=> $fv['dishimage'],
                'status'=> $available,
            );
        }
       
        /*get data in  array*/
        $userArr = array($userid);
        $finaldataArr = [];
        if(count($disdataArr) <= 0 && count($resFavlistArr1) <= 0){
            $msg = json_encode(array('status' => 404,'type'=>'warning','msg' => 'Records Not Found.','data' => ''));
            echo $msg;
            die;   
        }
        foreach ($userArr as $key => $value) {
            $finaldataArr['customerInfo'] = isset($disdataArr[$value])?$disdataArr[$value]:[];
            $finaldataArr['fav_res'] = isset($resFavlistArr1[$value])?$resFavlistArr1[$value]:[];
        }
        /*get data in  array*/
        $data = json_encode(array('status' => 200,'type'=>'success','msg' => 'available','data' => $finaldataArr));
        echo $data;
        die;
    }

    public function orderStatus(){
        $orderid = isset($_REQUEST['orderid'])?$_REQUEST['orderid']:'';
        $contact = isset($_REQUEST['customercontact'])?$_REQUEST['customercontact']:'';
        $serviceno = isset($_REQUEST['businessserviceno'])?$_REQUEST['businessserviceno']:'';
        $greeting = isset($_REQUEST['audioFromCustomer'])?$_REQUEST['audioFromCustomer']:'';
        $ordername = isset($_REQUEST['itemname'])?$_REQUEST['itemname']:'';
        $status = isset($_REQUEST['status'])?$_REQUEST['status']:'';
        $usedcashcertId = isset($_REQUEST['usedcashcertId'])?$_REQUEST['usedcashcertId']:'';
        if($contact == '' || $serviceno == ''){
            $msg = json_encode(array('status' => 403,'type'=>'warning','msg' => 'Customer Contact Number and Restuarant Service Number Should not be Empty','data' => ''));
            echo $msg;
            die;
        }
        if($status != 'complete'){
            $msg = json_encode(array('status' => 403,'type'=>'warning','msg' => 'Order Not Completed','data' => ''));
            echo $msg;
            die;
        }

        /*get user id and res id*/
        $this->db->select('id');
        $this->db->from('users');
        $this->db->where('phone', $contact);
        $query = $this->db->get()->row();
        $userid = $query->id; 
        if($userid == ''){
            $msg = json_encode(array('status' => 404,'type'=>'warning','msg' => 'Customer Contact Number not Found','data' => ''));
            echo $msg;
            die;   
        }

        $this->db->select('address.*,business.*');
        $this->db->from('business');
        $this->db->where('business.service_number', $serviceno);
        $this->db->join('address', 'business.addressid = address.id', 'left');
        $query = $this->db->get()->row();  
        $resid = $query->id; 
        $balacecredits = $query->credits; 
        if($resid == ''){
            $msg = json_encode(array('status' => 404,'type'=>'warning','msg' => 'Restuarant Contact Number not Found','data' => ''));
            echo $msg;
            die;   
        }
        /*get user id and res id*/

        /*check order id already exists*/
        $this->db->select('*');
        $this->db->from('business_order_status');
        $this->db->where('orderid', $orderid);
        $query = $this->db->get()->row();  
        $exists = $query->orderid;
        if($exists > 0){
            $msg = json_encode(array('status' => 404,'type'=>'warning','msg' => 'Order Already Exists, Use Another Order.','data' => ''));
            echo $msg;
            die;   
        }
        /*check order id already exists*/

        /*insert credit info in business_order_status*/
        $status1 = ($status == 'complete')?1:0;
        $data = array(
            'orderid'=>$orderid,
            'userid'=>$userid,
            'businessid'=>$resid,
            'audiogreeting'=>$greeting,
            'itemname'=>$ordername,
            'status'=>$status1,
            'credits'=>1,
        );
        $this->db->insert('business_order_status',$data);
        if($this->db->affected_rows()){
            $crdit = $balacecredits-1;
            $updateData=array("credits"=>$crdit);
            $this->db->where("id",$resid);
            $this->db->update("business",$updateData);
            if($this->db->affected_rows()){
                $certused=array("certificate_verify"=>1);
                $this->db->where("id",$usedcashcertId);
                $this->db->update("tbl_deals_purchased",$certused);
                $msg = json_encode(array('status' => 200,'type'=>'success','msg' => 'Credit Updated Successfully.','data' => ''));
                echo $msg;
                die;   
            }
        }
        /*insert credit info in business_order_status*/
    }
    public function getOrder(){
        $contact = isset($_REQUEST['customercontact'])?$_REQUEST['customercontact']:'';
        $serviceno = isset($_REQUEST['businessserviceno'])?$_REQUEST['businessserviceno']:'';
        $ordername = isset($_REQUEST['ordername'])?$_REQUEST['ordername']:'';
        $orderqty = isset($_REQUEST['orderqty'])?$_REQUEST['orderqty']:'';
        $orderprice = isset($_REQUEST['orderprice'])?$_REQUEST['orderprice']:'';
        if($contact == '' || $serviceno == ''){
            $msg = json_encode(array('status' => 403,'type'=>'warning','msg' => 'Customer Contact Number and Restuarant Service Number Should not be Empty','data' => ''));
            echo $msg;
            die;
        }

        /*get user id and res id*/
        $sql = "SELECT * FROM users WHERE phone=".$contact."";
        $query = $this->CommonController->SelectRawquery($sql,'row');
        $userid = isset($query->id)?$query->id:'';
        if($userid == ''){
            $msg = json_encode(array('status' => 404,'type'=>'warning','msg' => 'Customer Contact Number not Found','data' => ''));
            echo $msg;
            die;   
        }
        
        $sql = "SELECT address.*,business.* FROM business INNER JOIN address ON business.addressid = address.id WHERE  business.service_number='".$serviceno."'";
		$query = $this->CommonController->SelectRawquery($sql,'row');
        $resid = isset($query->id)?$query->id:''; 
        $balacecredits = isset($query->credits)?$query->credits:''; 
        if($resid == ''){
            $msg = json_encode(array('status' => 404,'type'=>'warning','msg' => 'Restuarant Contact Number not Found','data' => ''));
            echo $msg;
            die;   
        }
        /*get user id and res id*/
        $sql = "SELECT MAX(counter) as counter FROM business_get_order WHERE  userid='".$userid."' AND businessid='".$resid."'";
		$query = $this->CommonController->SelectRawquery($sql,'row');
        $counter = isset($query->counter)?$query->counter:0; 
        // echo $counter;die;
        
        /*insert credit info in business_get_order*/
        $data = array(
            'userid'=>$userid,
            'businessid'=>$resid,
            'counter'=>$counter+1,
            'itemname'=>$ordername,
            'itemqty'=>$orderqty,
            'itemprice'=>$orderprice,
            'status'=>0,
        );
        $id = $this->CommonController->InsertData('business_get_order', $data);
        if($id > 0){
            $msg = json_encode(array('status' => 200,'type'=>'success','msg' => 'Order placed sucessfully waiting for approval','data' => ''));
            echo $msg;
            die;   
        }
        /*insert credit info in business_order_status*/
    } 
}