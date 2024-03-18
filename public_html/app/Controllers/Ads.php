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
class Ads extends BaseController{
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
    
    public  function remove_non_numeric($string) {
        return preg_replace('/\D/', '', $string);
    }
    
    public function account_verification($email = false){
        $email = $_REQUEST['emailAddress'];
        $path = "http://savingssites.com";
        $login_path = "http://savingssites.com/";
        $link="http://savingssites.com/";
        $message="<div style='border:1px solid #900;padding:5px'>Dear ".$username.",<br /><br />
            Thank you for register in SavingsSites. To learn more about SavingsSites and it's benefits, please click <a href='".$path."'>HERE</a><br/><br/>
            To complete your registration, simple click the following link<br> <a href='".$path."'>Here</a> .<br/><br/>
            If the link does not work for you, then copy/paste the following link in your browser address bar:<br/><br/>".$link."<br/><br/>
            You can login into your account and change this information at your convenience.<br /><br />
            We are constantly trying to improve the application and will notify you of future updates as and when they are available. If you have any queries in the meantime then please email us at <a href='mailto:support@savingssites.com'>support@savingssites.com</a> and we will get back to you promptly.<br /><br />
            Best Regards,<br />Savings Sites Support" ;
        
        $fromemail=$this->config->item('adminEmailId');
        $this->load->library('email');
        $template_subject="Savings Sites Account verification";
        $this->email->clear();
        $this->email->from($fromemail);
        $this->email->subject($template_subject);
        $this->email->message($message);
        
        if($email!=''){
            $this->email->to($email);
            $this->email->send();
            $to[]=$email;
        }
    }
    
    public function display_all_category(){
        $zoneId=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
        $current_url=!empty($_REQUEST['home_url']) ? $_REQUEST['home_url'] : '';
        if($zoneId!=0){
            $file="uploads/zone_menu/".$zoneId.".txt";
            if(file_exists($file)){
                echo file_get_contents($file);
            }
        }
    }
    
    public function get_categories($zoneid = 0){
        $categories = $this->Category_new_model->get_all_categories_zone_anish($zoneid);
        if(!empty($categories)){
            echo json_encode(array('status' => 1, 'categories' => $categories));
        }else{
            echo json_encode(array('status' => 0));
        }
    }
    
    public function get_blog(){
        $zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0 ;
        $link_path=!empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : '' ;
        $data = array();
        $data['zone_id']=$zone_id;
        $data['link_path']=$link_path;
        $this->load->view('directory/show_blog', $data);
    }
    
    public function get_certificate_verify(){
        $sql="UPDATE tbl_deals_purchased_meta SET certificate_verify = '1'  WHERE id = ".$_REQUEST['id'];
        $this->CommonController->updateData('tbl_deals_purchased_meta',['certificate_verify' => '1'],['id' => $_REQUEST['id']]);
        echo json_encode(['msg'=>'Certificate Verified Successfully','type'=>'success']);
    }
    
    public function get_certificate(){
        $html = '';
        $zone_id = (isset($_REQUEST['zoneid'])) ? $_REQUEST['zoneid'] : '' ;
        $deal_id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : '' ;
        $purchaseID = (isset($_REQUEST['purchaseID'])) ? $_REQUEST['purchaseID'] : '' ;
        $userid = (isset($_REQUEST['userid'])) ? $_REQUEST['userid'] : '' ;
        if($zone_id != '' && $userid != ''){
            $peekaboodeals = $this->Organization_model->getuserdealsbyid($zone_id,$userid,$deal_id ,$purchaseID);
            if(count($peekaboodeals) > 0){
                $check_certficate = $peekaboodeals[0];
                $html .= '<style>.col-md-6.cerfied_left_col img,.col-md-6.cerfied_right_col img{width: 150px;}.col-md-6.cerfied_left_col img{margin-top: 10px;}.row.bv_issued_row {font-size: 13px;}.bv_cerfied_row{padding-top: 10px; padding-bottom: 20px; border-bottom: 2px solid #004680;}
            .bv_issued_row
            { 
                margin-top: 0px; 
                padding-top: 20px; 
                padding-bottom: 20px; 
                border-bottom: 2px solid #004680;  
            }
            .bv_redemption_row
            { 
                margin-top: 0px; 
                padding-top: 20px;  
            }
            .bv_verfied_row
            { 
                margin-top: 0px;  
            }
            .bv_verfied_row .button1
            { 
                width: 60%; 
                margin: 0px auto; 
                display: block; 
                line-height: 52px; 
                padding: 8px 10px;  
            }
            .issued_col
            { 
                font-weight: bold; 
                text-transform: uppercase; 
            }
            .bv_verfied_row .button1 ,.bv_verfied_row .button1:hover  { color: #fff;  }
            .cetrtificate-outer
            {
                background: #ffffff;
                padding: 20px;
                border: 4px double #004680;
                border-radius: 12px;
            }
            .row.bv_verfied_row 
            {
                display: block;
                margin: 0 auto;
                text-align: center;
                padding: 15px;
                color: #dc143c;
            }
            .div_deal_desc h4{ color: #000; }
            .cetrtificate-outer input[type=text] 
            {
                width: 98%;
                padding: 12px 20px;
                margin: 8px 0;
                box-sizing: border-box;
                border: none;
                border-bottom: 2px solid #000080;
                margin-left: 10px;
                resize: vertical;
                pointer-events: none;
                font-size: 17px;
            }
            .box{
                background-color: #004680; 
        color: white;
        /*width: 28%; 
        margin-left: 20px; */
        text-align: center;
        line-height: 3; 
        font-size:18px;
        display: inline-block;
    }   
    .row.deal_row {
    margin-top: -30px;
}
    .div_deal_desc{
        text-align: center;
        border: 2px solid #004680;
        border-top-right-radius: 25px;
        border-top-left-radius: 25px;
        padding-bottom: 25px;
        overflow: hidden; margin-top: 14px; 
    }
    .div_deal_desc h4{
        margin-top: 20px;
    }
    .deal_desc{
    background-color: #004680;
    color: #ffff;
    line-height: 35px;
    font-size: 16px;
    font-weight: bold;
    letter-spacing: 1px;
    padding: 0;
    margin-top: 0;
    }
    .imp{
        background-color: #DC143C;
        /*width: 8%;*/ padding: 2px 10px;
        text-align: 
        center;
        color: #fff;
        font-size: 16px;
        display: inline;
    }
    .imp_desc{
        display: inline;
        color: #004680; font-weight: bold; 
        font-size: 14px;
    }
    .button_outer{
        padding-top: 20px;
        text-align: center;
        font-size: 22px;
        padding-bottom: 20px;
        width: 100%;
    }
    .button1 {
        border-radius: 15px;
        line-height: 80px;
        width: 30%;
        background-color: #DC143C;
        color: #fff;
    }
    .btn-block{
        text-align: center;
        width: 50%;
    }
    .issued{
     
        padding-bottom: 15px;
        color: #000080;
        margin-right: 0px;
    }
    .msg.green{
        color: green;
    }


@media (max-width:991px){  

.bv_cerfied_row .cerfied_left_col{ width: 50%; float: left;  }
.bv_cerfied_row .cerfied_right_col{ width: 50%; float: right;  }
.bv_issued_row .col-md-6{ text-align: center !important; }
.bv_issued_row .col-md-3{ text-align: center !important; }
.authorized_row .col-md-5{ padding-top: 0px !important;   }
.deal_row{ margin-top: 20px;  }
.div_deal_desc{ border-radius: 0px !important;  }
.footer_cerfied_col .col-md-6{ text-align: center;   }
.footer_cerfied_col .col-md-6{ text-align: center;   }
.footer_cerfied_col .issued{text-align: center; width: 100%; float: left; margin: 0px;  }
.bv_redemption_row .col-md-6{ word-break: break-word; }


}

@media (max-width:640px){

.bv_redemption_row .col-md-6{ width: 100%;  text-align: center !important; }
.bv_redemption_row .col-md-6.box{ margin-bottom: 10px;  }
.footer_cerfied_col .col-md-6{ word-break: break-word; }
}

@media (max-width:480px){

.bv_verfied_row .button1{ width: 100%; font-size: 30px; line-height: 36px;  }   

}

    </style>';
    if ($check_certficate['certificate_verify'] == 1) {
        $html .= '<p class="msg green" style="text-align: center;font-size: 25px">
        Certificate successfully Verified
        </p>
        <script type="text/javascript">
            setTimeout(function(){
            $(".msg.green").fadeOut(400);
        }, 7000)
        </script>';
    }   
    
$html .='<div class="cetrtificate-outer">
<div style="width: 100%;" class="container">
   <div class="row bv_cerfied_row">
      <div class="col-md-6 cerfied_left_col">
         <img src="https://savingssites.com/assets/businessSearch/images/logo.png" width="300";>
      </div>
      <div class="col-md-6 cerfied_right_col" style="text-align: right;">
         <img src="https://peekabooauctions.com/assets/images/ccertificate.png" width="250";>
      </div>
   </div>
   <div class="row bv_issued_row"> 
      <!-- <input type="text" name=""  > --> 
      <div class="col-md-6 issued_col" >ISSUED TO: '.$check_certficate['first_name'].' '.$check_certficate['last_name'].'</div>
      <div class="col-md-3" style="text-align: center;color: #DC143C;">Deal ID:'.$check_certficate['dealId'].'</div>
      <div class="col-md-3" style="margin-left: 0px; text-align: right;color: #DC143C;">Auction End Date:<br /> '.$check_certficate['end_date'].'</div></div>
      <!-- <input type="text" name=""  > -->
      <div class="row bv_redemption_row">   
      <div class="col-md-6 box">REDEMPTION VALUE: $'.$check_certficate['buy_price_decrease_by'].'</div>
      <div class ="col-md-6  "margin-left:0; style="float: right; color:#004680;text-align: center;font-weight: bold; font-size: 16px;">TO BE REDEEMED AT:

        '.$check_certficate['first_name'].'" "'.$check_certficate['last_name'].'"<br />"'.$check_certficate['email'].' 
      </div>
   </div>
   <div class="row authorized_row">
      <div class ="col-md-7"></div>
      <div class ="col-md-5" style="text-align: left;padding-top: 80px;font-size: 16px; font-weight: bold;">Authorized By:  </div>
   </div>
   <div class="row deal_row">
      <div class ="col-md-7" style="font-weight: bold;">Deal Price : $'.$check_certficate['amountPurchased'].'</div>
      

   </div>
   <div class ="div_deal_desc">
      <p class="deal_desc">DEAL DESCRIPTION:</p>
      <h4>'.$check_certficate['deal_description'].'
     
      </h4>
   </div>';

   if($check_certficate['username']==""){
            $html .='<div class="row bv_verfied_row">
                <div class="button_outer"><button class="button1">Please login to verify the certificate</button>
            </div>';
   }elseif($check_certficate['certificate_verify'] != 1 ){
            $html .= '<div style="padding-top: 10px;text-align: center">
              <p class="imp">IMPORTANT:</p>
              <p class="imp_desc">CLICK BELOW TO VERIFY 1 TIME USE <span style="text-decoration: underline;">IN PRESENCE OF BUSINESS</span></p>
           </div>
           <div class="row bv_verfied_row">
               <div class="button_outer">
                <a href="'.basename($_SERVER['REQUEST_URI']).'"  data-dealid="'.$check_certficate['id'].'"  class="verifyme button1">VERIFY USE</a>
               </div>
            </div>';
   }elseif($check_certficate['certificate_verify'] == 1 ){ 
            $html .= '<div class="row bv_verfied_row">
                <div class="button_outer">
                    <button class="button1" > Certificate Already Used</button>
                </div>
            </div>';
    } 
   $html .= '<div style="width: 100%;" class="container footer_cerfied_col">
       
      <div class="col-md-12 text-center">
         <span class="issued"><span style="color:#DC143C;text-decoration: none ">*</span>1-time use. Never expires. Issued at: '.date('d-m-Y', strtotime($check_certficate['purchasedAt'])).'</span>
      </div>

   </div>
</div>
</div>
        '; 
            }
        }






      echo json_encode(array('html' => $html,'count' => 0));
            die;
    }
    
    public function get_org(){
        $this->load->model("Organization_model", "org_model");
        $zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0 ;
        $link_path=!empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : '' ;
        $zone_setting_offers=!empty($_REQUEST['zone_setting_offers']) ? $_REQUEST['zone_setting_offers'] : 0 ;
        $data = array();
        $user = $this->ion_auth->user()->row();
        $uid = 0;
        $user_type = 0;
        
        if(!empty($user)){ 
            $uid = $user->id;
            $user_type_data = $this->users_model->get_user_type($uid);
            
            if($user_type_data){
                $user_type = $user_type_data->member_type;
            }
        }
        
        $data['zone_id']=$zone_id;
        $data['user_id']=$uid;
        $data['user_type'] = $user_type;
        $data['link_path']=$link_path;
        $data['zone_pref_setting']=$zone_setting_offers;
        
        if($this->session->userdata('session_normal_user_in_zone')!=''){
            $session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
            $session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype'];
        }else{
            $session_session_normal_user_type='';
        }
        
        $data['session_session_normal_user_type']=$session_session_normal_user_type;
        if($data['session_session_normal_user_type'] != 'resident_user'){   
            $data['announcement_list'] = $this->org_model->get_org_details($zone_id);
            $data['auction_list'] = $this->org_model->get_auction_list($zone_id);
        }else{
            $data['announcement_list'] = $this->org_model->get_org_details_user($zone_id,$uid);
            $data['auction_list'] = $this->org_model->get_auction_list($zone_id);
        }
        
        $this->load->view('directory/show_org', $data);
    }
    
    public function get_neighbourclassified(){
        $this->load->model("Organization_model", "org_model");
        $zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0 ;
        $link_path=!empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : '' ;
        $zone_setting_offers=!empty($_REQUEST['zone_setting_offers']) ? $_REQUEST['zone_setting_offers'] : 0 ;
        $user = $this->ion_auth->user()->row();
        $uid = 0;
        
        if(!empty($user)){ 
            $uid = $user->id;
        }
        $data['zone_id']=$zone_id;
        $data['user_id']=$uid;
        $data['link_path']=$link_path;  
        $data['zone_pref_setting']=$zone_setting_offers;
        
        if($this->session->userdata('session_normal_user_in_zone')!=''){
            $session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
            $session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype'];
        }else{
            $session_session_normal_user_type='';
        }
            
        $data['session_session_normal_user_type']=$session_session_normal_user_type;
        $this->load->view('directory/show_neighbourclassify', $data);
    }
    
    public function get_homesold(){
        $data = array();
        $data['zoneId']=(!empty($_REQUEST['zone_id'])) ? $_REQUEST['zone_id'] : "" ;
        
        if($this->session->userdata('session_normal_user_in_zone')!=''){
            $session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
            $session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype'];
        }else{
            $session_session_normal_user_type='';
        }
        $data['session_session_normal_user_type']=$session_session_normal_user_type;
        $this->load->view('directory/show_homesold', $data);
    }
    
    public function get_highschool_org(){
        $this->load->model("Organization_model", "org_model");
        $zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0 ;
        $link_path=!empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : '' ;
        $zone_setting_offers=!empty($_REQUEST['zone_setting_offers']) ? $_REQUEST['zone_setting_offers'] : 0 ;
        $data = array();
        $user = $this->ion_auth->user()->row();
        $uid = 0;
        if(!empty($user)){ $uid = $user->id;}
            $data['zone_id']=$zone_id;
            $data['user_id']=$uid;
            $data['link_path']=$link_path;
            $data['zone_pref_setting']=$zone_setting_offers;
        if($this->session->userdata('session_normal_user_in_zone')!=''){
            $session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
            $session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype'];
        }else{
            $session_session_normal_user_type='';
        }
        
        $data['session_session_normal_user_type']=$session_session_normal_user_type;
        if($data['session_session_normal_user_type'] != 'resident_user'){
            $data['announcement_list'] = $this->org_model->get_highschool_org_details($zone_id);
        }else{
            $data['announcement_list'] = $this->org_model->get_highschool_org_details_user($zone_id,$uid);
        }
        
        $this->load->view('directory/show_highschool_org', $data);
    }
    
    public function get_pboo_banner(){//calling from new_page



        $zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0 ;



        $link_path=!empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : '' ;



        $data = array();



        $data['zone_id']=$zone_id;



        $data['link_path']=$link_path;



        $this->load->view('directory/show_peekaboo_baner', $data);



    }



    /**



     * This function is displaying baner panel on zone directory page.



     *



     * This function is accessable from the zone directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * </ol>



     * <br>



     * view page: <b>views/directory/show_baner</b>



     */



    public function get_baner($cssvalue=false){ //calling from new_page



        $data = array();



        $a=uri_string($cssvalue);



        $link_path=!empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : '' ;



        $data['css_value']=substr($a,14);



        $data['zone_id']=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;



        $data['link_path']=$link_path;



        $data['active_banner']=$this->banner->active_banner($data['zone_id']);



        $data['mobile_banner']=$this->banner->active_mobile_banner();




        $this->load->view('directory/show_baner', $data);



    }



    /**



     * This function is displaying peekaboo control panel on zone directory page.



     *



     * This function is accessable from the zone directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * </ol>



     * <br>



     * view page: <b>views/directory/show_pboo_control_panel</b>



     */



    public function get_pboo_control_panel($cssvalue=false){ //calling from new_page



        $this->load->model('peekaboo/peekaboo_model','peekaboo');



        $data = array();



        $a=uri_string($cssvalue);



        $data['css_value']=substr($a,14);



        $zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0 ;



        $link_path=!empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : '' ;



        $data['zone_id']=$zone_id;



        $peekaboo_password_redirect = array('zone_id_peekaboo'=>$zone_id);



        $this->session->set_userdata('peekaboo_password_redirect',$peekaboo_password_redirect);



        $data['active_peekaboo_auction']=$this->peekaboo->active_peekaboo_auction($zone_id);


        $data['pboo_categories']=$this->peekaboo->get_categories();



        $data['all_active_zone']=$this->peekaboo->get_active_zone();



        $data['peekaboo_zone']=$this->peekaboo->peekaboo_zone();



        $this->load->view('peekaboo/show_pboo_control_panel', $data);



    }



    /**



     * This function is displaying directory feature on zone directory page.



     *



     * This function is accessable from the zone directory page.



     * <br>



     * view page: <b>views/directory/directory_feature_coming</b>



     */



    public function directory_feature(){//calling from new_page



        $data = array();



        $this->load->view('directory_feature_coming', $data);



    }



    /**



     * This function is displaying advertise business feature on zone directory page.



     *



     * This function is accessable from the zone directory page.



     * <br>



     * view page: <b>views/directory/advertise_business</b>



     */



    public function advertise_business($zoneid=0,$userid=0){//calling from new_page



        $data = array();



        $data['zoneid']=$zoneid;



        $data['userid']=$userid;



        $this->load->view('advertise_business', $data);



    }



// tamal



    public function submit_contact(){//calling from new_page



        



        $subject=$_REQUEST['subject'];



        $name=$_REQUEST['name'];



        $email=$_REQUEST['email'];



        $phone=trim(str_replace(' ','',$_REQUEST['phone']));



        $message=$_REQUEST['message'];



        $zoneid=$_REQUEST['zoneid'];



        $sql="select a.name,b.* from sales_zone a, users b where a.sales_rep_id=b.id and a.id=".$zoneid;



        $query = $this->db->query($sql);



        $result = $query->row();



        $c=is_numeric($phone);



        if($c)



            $phone_format='('.substr($phone,0,3).') '.substr($phone,3,3).'-'.substr($phone,6);



        else



            $phone_format=$phone;


        $message_body= '<body style="background-color:#FFF;font-family:Arial,Helvetica,sans-serif">



<div style="width:960px;margin:0 auto!important">



<div style="background-color:#f2f2f2;border-radius:4px;width:650px;margin:5px auto;padding:15px">



<div style="background-color:#3f3f3f;height:70px"><img src="http://www.savingssites.com/assets/images/logo_white.png" style="margin:10px 202px" alt="logo"/></div>



<div style="clear:both"></div>



<div style="background-color:#FFF;margin-top:10px;margin-bottom:10px;min-height:300px;padding:15px">



<h2 style="text-align:left">Hello'." ".$result->first_name.',



</h2><h3 style="text-align:left;display:block;color:#666">'.$name.' sent you a message regarding: '.$result->name.'</h3>



<h3><p style="text-align:left;display:block;color:#333">Subject: '.$subject.'</p></h3>



<h3><p style="text-align:left;display:block;color:#333">Name: '." ".$name.'</p></h3>



<h3><p style="text-align:left;display:block;color:#333">Email Address: '.$email.'</p></h3>



<h3><p style="text-align:left;display:block;color:#333">Telephone: '.$phone_format.'</p></h3>



<h3><p style="text-align:left;display:block;color:#333">Message: '.$message.'</p></h3>



</div>



<div style="background-color:#999;height:60px"></div>



</div>



</div>



</body>';



        $fromemail=$email;



        $this->load->library('email');



        $template_subject=$result->name." Inquiry";



        $this->email->clear();



        $this->email->from($fromemail);



        $this->email->subject($template_subject);



        $this->email->message($message_body);



        if($result->email!='')



        {



            $this->email->to($result->email);



            $this->email->send();



            $to[]=$result->email;



        }



        $message = "Thank You!<br/>We will be contacting you shortly";



        echo($this->dr->GetDR("Acknowledgement", $message, "", "0"));



    }



    /**



     * This function is displaying Contact The Business Owner Information directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Table use in this function : ads ,business ,users ,sales_zone .



     * <br>



     * After completing all this process email will be send to the Business Owner.



     */



// tamal



    public function submit_starter_ad(){ //callinf from new_page



        $name=$_REQUEST['name']? $_REQUEST['name'] : '';



        $email=$_REQUEST['ad_email']? $_REQUEST['ad_email'] :'';



        $business_id=$_REQUEST['business_id'] ? $_REQUEST['business_id'] : '';



        $ad_id=$_REQUEST['ad_id'] ? $_REQUEST['ad_id'] : '';



        $content=$_REQUEST['content'] ? $_REQUEST['content'] : '';



        $zoneid = $_REQUEST['zoneid'] ? $_REQUEST['zoneid'] : '';



        $result=0; $smart_url = '' ;



        if( $business_id!=''){



// Ad Info



            $sql_ads="SELECT * FROM ads WHERE id = ".$ad_id ;



            $query_ads = $this->db->query($sql_ads);



            $result = $query_ads->row();



            if($zoneid != '' && $business_id != '' && $result->deal_title != ''){



                $smart_url = base_url('zone'.'/'.$zoneid.'/'.$business_id.'/'.$result->deal_title) ;



            }else{



                $smart_url = 'Not provided' ;



            }



// Business Info



            $sql_bus = "SELECT a.contactemail, b.email, b.City ,b.username FROM business a, users b WHERE a.business_owner_id = b.id AND a.id = ".$business_id ;



            $query_bus = $this->db->query($sql_bus);



            $result_bus = $query_bus->row();



            if($result_bus->contactemail!=''){



                $to_email=$result_bus->contactemail;



            }else{



                $to_email=$result_bus->email;



            }



            $sql_zone = "SELECT a.name, b.first_name, b.last_name, b.phone FROM sales_zone a, users b WHERE a.sales_rep_id = b.id AND a.id = ".$zoneid ;



            $query_zone = $this->db->query($sql_zone);



            $result_zone = $query_zone->row();



            $message_body= '<body style="background-color:#FFF;font-family:Arial,Helvetica,sans-serif">



<div style="width:960px;margin:0 auto!important">



<div style="background-color:#f2f2f2;border-radius:4px;width:650px;margin:5px auto;padding:15px">



<div style="background-color:#3f3f3f;height:70px"><img src="'.base_url('assets/images/logo_white.png').'" style="margin:10px 202px" alt="logo"/></div>



<div style="clear:both"></div>



<div style="background-color:#FFF;margin-top:10px;margin-bottom:10px;min-height:300px;padding:15px">



<h3><p style="text-align:left;display:block;color:#333">Sent by : '.$name." ".'('.$email.')'.' </p></h3>



<h2 style="text-align:left">Dear Business Owner,'.



                '</h2><br><h3 style="text-align:left;display:block;color:#666"> '.$content.' <br></h3><br>



<h3><p style="text-align:left;display:block;color:#333">Ad URL :'." ".'<a target="_blank" href="'.$smart_url.' ">'.$smart_url .'</a></p></h3>



<h3><p style="text-align:left;display:block;color:#333">Zone Name :'." ".$result_zone->name.'</p></h3>



<h3><p style="text-align:left;display:block;color:#333">Zone Owner Contact Information :'." ".$result_zone->first_name.' '.$result_zone->last_name.', '.$result_zone->phone.'</p></h3>



</div>



<div style="background-color:#999;height:60px"></div>



</div>



</div>



</body>';



            if($result_bus->City!=''){



                $template_subject="Message From local Resident of $result_bus->City";



            }else{



                $template_subject="Message From local Resident";



            }



            $fromemail=$this->config->item('adminEmailId');



            $this->load->library('email');



            $this->email->clear();



            $this->email->from($fromemail);



            $this->email->subject($template_subject);



            $this->email->message($message_body);



            $this->email->bcc('anish.sett@gmail.com');



            if($to_email!='')



            {



                $this->email->to($to_email);



                $this->email->send();



                $to[]=$to_email;



//$result=1;



            }



        }



        $message = "Thank You!<br/>We will be contacting you shortly";



        echo($this->dr->GetDR("Acknowledgement", $message, "", "0"));



    }



    /**



     * This function use for sending email to the user from directory page.



     * This function is accessable from the directory page.



     * <br>



     * Table use in this function : ads ,business ,ad_to_zone .



     * <br>



     * After completing all this process email will be send to the User.



     */



// tamal



    public function email_offer($adId = false,$emailAddress = false,$text = false,$captcha_code = false){//calling from new_page



        isset($_REQUEST['adId']) ? $adId = $_REQUEST['adId'] :$adId='';



        isset($_REQUEST['emailAddress']) ? $emailAddress = $_REQUEST['emailAddress'] :$emailAddress='';



        isset($_REQUEST['text']) ? $text = $_REQUEST['text'] :$text='';



        session_start();



        /*if(isset($_REQUEST['captcha_code']) && $_REQUEST['captcha_code'] !="" && $_SESSION['captcha']==$_REQUEST['captcha_code']){



        $message_status = 1 ;



        }else{



        $message_status = 0 ;



        }*/



        $message_status = 1 ;



        $arr = explode(' ',trim($text));



        $firstname = $arr[0];



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



 


            if($message_status == 1){







                $ad_text=urldecode(stripslashes(str_replace("&nbsp;"," ",$deal_description)));



// email sent



                $fromemail=$this->config->item('adminEmailId');



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



            }else{



                $message = "Message not sent, Wrong Captcha!";



            }



            echo($this->dr->GetDR("Acknowledgement", $message, $message_status, $adId));



//echo($this->dr->GetDR("Acknowledgement", $message, $message_status, "0"));



        }



    }



    /**



     * This function use for sending email to the user through the mobile number from directory page.
     * This function is accessable from the directory page.
     * <br>
     * Table use in this function : ads ,business ,ad_to_zone .
     * <br>
     * After completing all this process email will be send to the User through mobile number.
     */

    public function mailad($adId = false,$emailAddress = false,$text = false,$captcha_code = false){//calling from new page

        isset($_REQUEST['adId']) ? $adId = $_REQUEST['adId'] :$adId='';
        isset($_REQUEST['emailAddress']) ? $emailAddress = $_REQUEST['emailAddress'] :$emailAddress='';
        isset($_REQUEST['text']) ? $text = $_REQUEST['text'] :$text='';

        session_start();
        $arr = explode(' ',trim($text));
        $firstname = $arr[0];

        if(!empty($adId) && $adId > 0){

            $sql="select t1.adtext,t1.deal_description,t1.textmeoffer,t1.id,t1.deal_title, t2.name as biz_name, t2.contactfirstname, t2.contactlastname, t2.contactemail , t3.zoneid from ads as t1 inner join business as t2 on t1.business_id = t2.id inner join ad_to_zone as t3 on t1.id = t3.adid where t1.id = ". $adId;

            $query = $this->db->query($sql);
            $result = $query->row();
            $result1=$query->row('id');
            $url_details = $this->ion_auth->meta_tag_details($result1);
            $status = 0;

            if(!empty($url_details)){

                if($url_details[0]['deal_title']!=''){

                    $data=array();
                    $data['business_name']=$url_details[0]['deal_title'];
                    $data['bsname']=$url_details[0]['business_name'];
                    $data['business_id']=$url_details[0]['business_id'];
                }
            }

            $text_me_offer = $result->textmeoffer;;
            $deal_title = $result->deal_title;  

                
                $fromemail='DoNotReply@HGD.deals';
                $email_subject=stripslashes($result->biz_name) . " Special Offer";
                $message_body= 'Offer From:'." ".stripslashes($result->biz_name)." - ".'<a target="_blank" href="'.base_url($result->deal_title).'">'.base_url($result->deal_title).'</a>'."\r\n \r\n".$text_me_offer;
                $message_body = nl2br($message_body);


                $this->load->library('email');
                $this->email->clear();
                $this->email->from($fromemail);
                $this->email->subject($email_subject);
                $this->email->message($message_body);

                if($emailAddress!=''){
                    $this->email->to($emailAddress);

                    if ($this->email->send()) {
                        $message = "Successfully Sent!";
                        $status = 1;
                    }else{
                        $message = "Message not sent!";
                    }

                    $to[]=$emailAddress;
                }
                else{
                    $message = "Message not sent!";
                }
                
            }
            else{
                
            }

           echo json_encode(['message' => $message, 'status' => $status]);
            die;

            // echo($this->dr->GetDR("Acknowledgement", $message, $message_status, $adId));


        }
    



    /**



     * This function use for sending email to the friend's email from directory page.



     * This function is accessable from the directory page.



     * <br>



     * Table use in this function : users ,ads ,business .



     * <br>



     * After completing all this process email will be send to the friend's emai through mobile number.



     */



// tamal



    function mailad_to_friend(){//calling from new_page



        isset($_REQUEST['adId']) ? $adId = $_REQUEST['adId'] :$adId='';



        isset($_REQUEST['name']) ? $name = $_REQUEST['name'] :$name='';



        isset($_REQUEST['email']) ? $email = $_REQUEST['email'] :$email='';



        $message_status = '' ;







        session_start();



    


        $arr = explode(' ',trim($name));



        $sender_name = $arr[0];



// + Get the zone owner name and email address to keep the email address in the from field when sent to afriend



        $sess_userid = $this->session->all_userdata();



        if(isset($sess_userid['user_id'])){



            $uid = $sess_userid['user_id'];







            $user_data_sql = $this->db->query("SELECT * FROM users WHERE id=".$uid);



            $user_data = $user_data_sql->row();



            $email_zone = $user_data->email;



            $first_name_zone = $user_data->first_name;



            $last_name_zone = $user_data->last_name;



            $full_name_zone = $first_name_zone.' '.$last_name_zone;



            $phone_zone = $user_data->phone;







            if(!empty($adId) && $adId > 0){



                $sql = "select t1.adtext,t1.deal_description,t1.deal_title,t2.name as biz_name, t2.contactfirstname, t2.contactlastname, t2.contactemail from ads as t1



inner join business as t2 on t1.business_id = t2.id where t1.id = " . $adId;



                $query = $this->db->query($sql);



                $result = $query->row();



                $deal_description = !empty($result->deal_description) ? $result->deal_description : '';



               



                $ad_text=urldecode(stripslashes(str_replace("&nbsp;"," ",$deal_description)));



 



                $fromemail = $email_zone;



                $email_subject=stripslashes($result->biz_name) . " Special Offer";



                if($deal_description!='')



                {



                    $message_body= '<body style="background-color:#FFF;font-family:Arial,Helvetica,sans-serif">



<div style="width:960px;margin:0 auto!important">



<div style="background-color:#f2f2f2;border-radius:4px;width:650px;margin:5px auto;padding:15px">



<div style="background-color:#3f3f3f;height:70px"><img src="'.base_url('assets/images/logo_white.png').'" style="margin:10px 202px" alt="logo"/></div>



<div style="clear:both"></div>



<div style="background-color:#FFF;margin-top:10px;margin-bottom:10px;min-height:300px;padding:15px">



<h2 style="text-align:left">Hello'." ".$sender_name.',</h2>



<h3 style="text-align:left;display:block">I thought of you when I saw this great offer from'." ".$result->biz_name.'. </h3>



<h3><p style="text-align:left;display:block">Link To Deal: '.'<a target="_blank" href="'.base_url($result->deal_title).'">'.base_url($result->deal_title).'</a></p></h3>



<h3 style="text-align:left;display:block">DEAL DESCRIPTION: </h3>



<p style="text-align:left;display:block;color:#333"><h3 style="text-align:left">



' .$ad_text.'</h3></p><h3 style="text-align:left">Best Regards,<br />'.$full_name_zone.



                        '</h3>



</div>



<div style="background-color:#999;height:60px"></div>



</div>



</div>



</body>';



                }else {



                    $message_body= '<body style="background-color:#FFF;font-family:Arial,Helvetica,sans-serif">



<div style="width:960px;margin:0 auto!important">



<div style="background-color:#f2f2f2;border-radius:4px;width:650px;margin:5px auto;padding:15px">



<div style="background-color:#3f3f3f;height:70px"><img src="'.base_url('assets/images/logo_white.png').'" style="margin:10px 202px" alt="logo"/></div>



<div style="clear:both"></div>



<div style="background-color:#FFF;margin-top:10px;margin-bottom:10px;min-height:300px;padding:15px">



<h2 style="text-align:left">Hello'." ".$sender_name.',</h2>



<h3 style="text-align:left;display:block">I thought of you when I saw this great offer from'." ".$result->biz_name.' </h3>



<h3><p style="text-align:left;display:block">Link To Deal: '.'<a target="_blank" href="'.base_url($result->deal_title).'">'.base_url($result->deal_title).'</a></p></h3>



<h3 style="text-align:left">Best Regards,<br />'.$full_name_zone.



                        '</h3>



</div>



<div style="background-color:#999;height:60px"></div>



</div>



</div>



</body>';



                }







                $this->load->library('email');



                $this->email->clear();



                $this->email->from($fromemail);



                $this->email->subject($email_subject);



                $this->email->message($message_body);



                if($email!=''){



                    $this->email->to($email);



                    $this->email->send();



                    $to[]=$email;



                }



                $message = "Successfully sent ";







            }



        }else{







            $message = "Message not sent";



        }



        echo($this->dr->GetDR($adId, $message, 1 , "0"));



    }











    function refer_mail_to_friend(){





        isset($_REQUEST['name']) ? $name = $_REQUEST['name'] :$name='';



        isset($_REQUEST['email']) ? $email = $_REQUEST['email'] :$email='';



        isset($_REQUEST['serverUrl']) ? $serverUrl = $_REQUEST['serverUrl']:$serverUrl='';



        $message_status = '' ;






        session_start();



  



        $arr = explode(' ',trim($name));



        $sender_name = $arr[0];



// + Get the zone owner name and email address to keep the email address in the from field when sent to afriend



        $sess_userid = $this->session->all_userdata();



        if(isset($sess_userid['user_id'])){



            $uid = $sess_userid['user_id'];







            $user_data_sql = $this->db->query("SELECT * FROM users WHERE id=".$uid);



            $user_data = $user_data_sql->row();



            $email_zone = $user_data->email;



            $first_name_zone = $user_data->first_name;



            $last_name_zone = $user_data->last_name;



            $full_name_zone = $first_name_zone.' '.$last_name_zone;



            $phone_zone = $user_data->phone;



// - Get the zone owner name and email address to keep the email address in the from field when sent to afriend



            

 



                $fromemail = $email_zone;



                $email_subject="Special Offer";



                



                    $message_body= '<body style="background-color:#FFF;font-family:Arial,Helvetica,sans-serif">



<div style="width:960px;margin:0 auto!important">



<div style="background-color:#f2f2f2;border-radius:4px;width:650px;margin:5px auto;padding:15px">



<div style="background-color:#3f3f3f;height:70px"><img src="'.base_url('assets/images/logo_white.png').'" style="margin:10px 202px" alt="logo"/></div>



<div style="clear:both"></div>



<div style="background-color:#FFF;margin-top:10px;margin-bottom:10px;min-height:300px;padding:15px">



<h2 style="text-align:left">Hello'." ".$sender_name.',</h2>



<h3 style="text-align:left;display:block">Look at <a href="'.$serverUrl.'">'.$serverUrl.'</a>. You have never seen anything like this. It\'s a very innovative Online Town Newspaper of Local Events & Savings Directory.</h3>



<h3 style="text-align:left;display:block">They have this Short Notice Alert Program (SNAP) filter system that emails savings offers for <strong>only the businesses you choose</strong>; and further filters by <strong>your availability</strong> and <strong>minimum discount</strong> you want.</h3>



<h3 style="text-align:left;display:block">You can also buy deeply discounted, non-expiring cash certificates, that help your favorite organization.</h3>



<h3 style="text-align:left;display:block">Lot\'s more. You can simultaneously search for <strong>discounted</strong> restaurant reservations.  Local Educational Webinars from professionals and contractors. They have this Events Calendar system where local events are <strong>filtered by your interest</strong>, so you only see what you care about, and the filtered events can flow right to your phone! There\'s Local Blogs, Local Classifieds, and so much more. Everything local, all in one site.</h3>



<p style="text-align:left;display:block;color:#333"><h3 style="text-align:left">



</h3></p><h3 style="text-align:left">Best Regards,<br />'.$full_name_zone.



                        '</h3>



</div>



<div style="background-color:#999;height:60px"></div>



</div>



</div>



</body>';



  



// $message_body = str_replace("&nbsp;"," ",$message_body);



                $this->load->library('email');



                $this->email->clear();



                $this->email->from($fromemail);



                $this->email->subject($email_subject);



                $this->email->message($message_body);



                $this->email->to($email); 



                $to[]=$email;



                if($this->email->send()){



                     $message = "Successfully sent ";



                     $message_status = 1 ;







                } else {



                    $message = "Something went wrong";



                     $message_status = 0;



                }     



        }else{



            $message_status = 0 ;



            $message = "You need to login first";



        }



        echo($this->dr->GetDR('sitereferresponse', $message, $message_status ));











    }



    function index(){



        if (!$this->ion_auth->logged_in()){



            redirect(base_url(), 'refresh');



        }



        elseif (!$this->ion_auth->in_group(array( "Tier I", "Tier II", "Tier III" )))



        {



            redirect($this->config->item('base_url'), 'refresh');



        }



        $data = array();



        $data['business_list'] = $this->business->get_all_businesses();



        if($this->ion_auth->in_group("Tier I")){



            $tiers = "Tier I";



        }



        else if($this->ion_auth->in_group("Tier II"))



        {



            $tiers = "Tier II";



        }



        else



        {



            $tiers = "Tier III";



            $data['business_list'] = $this->business->get_all_businesses_for_user();



        }



        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/ads.inc.js");



        $data['users_list'] = $this->users->get_all_users();



        $data['sales_rep_list'] = $this->sales_reps->get_sales_reps();



        $data['tier'] = $tiers;



        $data['category_list'] = $this->category->get_categories();



        $data['sales_zone_list'] = $this->zone->get_all_zones();



        $data["scripts"] = $scripts;



        $data["firstName"] = $this->ion_auth->user()->row()->first_name;



        $data["page_name"] = "ads";



        $data['ad_list'] = $this->ad->get_ads($tiers);



        $this->load->view("admin/header", $data);



        $this->load->view("admin/admin_buttons", $data);



        $this->load->view("admin/ads.inc.php", $data);



        $this->load->view("admin/ads.table.php",$data);



        $this->load->view("admin/footer");



    }



    /**



     * This function use for text me offer and email me offer.



     *



     */



// tamal



    function record_ads($text=false,$zone=false,$adId=false)//calling from new_page



    {



        return true;



    }



    /**



     *



     *



     *



     */



    function sendcontactform(){ 



        //echo "2222";exit;



        isset($_REQUEST['adId']) ? $adId = $_REQUEST['adId'] :$adId='';



        isset($_REQUEST['form_data']) ? $form_data = $_REQUEST['form_data'] :$form_data='';



        isset($_REQUEST['emailId']) ? $emailId = $_REQUEST['emailId'] :$emailId='';



        isset($_REQUEST['directaccess']) ? $directaccess = $_REQUEST['directaccess'] :$directaccess='';



        isset($_REQUEST['busname']) ? $busname = $_REQUEST['busname'] :$busname='';



        $email_info = array();



        $phoneno = '';



        $sql = '';



        if($form_data!=''){



            $varname = explode('&',$form_data);



            $count = count($varname);



            $i = 1;



            $sql = 'INSERT into email_contact_form SET ';



            foreach($varname as $val){



                if($i!=$count){



                    $speficval = explode('=',$val);



                    $name = $speficval[0];



                    $value = $speficval[1];



                    if($name == 'contact_submission_phone1' || $name == 'contact_submission_phone2' || $name == 'contact_submission_phone3'){



                        $phoneno.=$value;



                    }else{



                        $email_info[$name]= urldecode($value);



                        if($value!=''){



                            if(($count-1) == $i){



                                $sql.= $name."='".urldecode($value)."',";



                                $sql.= "contact_submission_phone='".$phoneno."'";



                            }else{



                                $sql.= $name."='".urldecode($value)."',";



                            }



                        }



                    }



                    $i++;



                }



            }







            if(!empty($email_info)){



                $fromemail = $this->config->item('adminEmailId');



                $email_subject = 'Email Contact Info';



                $message_body= '<body style="background-color:#FFF;font-family:Arial,Helvetica,sans-serif">



                <div style="width:960px;margin:0 auto!important">



                <div style="background-color:#f2f2f2;border-radius:4px;width:650px;margin:5px auto;padding:15px">



                <div style="background-color:#3f3f3f;height:70px"><img src="'.base_url('assets/images/logo_white.png').'" style="margin:10px 202px" alt="logo"/></div>



                <div style="clear:both"></div>



                <div style="background-color:#FFF;margin-top:10px;margin-bottom:10px;min-height:300px;padding:15px">



                <h2 style="text-align:left">Dear Business Owner,'.



                                    '</h2><br>



                <h3 style="text-align:left;display:block;color:#666">'.$email_info['contact_submission_name'].' tried to contact you regarding: '.$busname.'</h3><br>



                <h3><p style="text-align:left;display:block;color:#333">Name: '." ".$email_info['contact_submission_name'].'</p></h3>



                <h3><p style="text-align:left;display:block;color:#333">Email Address: '.$email_info['contact_submission_email'].'</p></h3>



                <h3><p style="text-align:left;display:block;color:#333">Telephone: '.$phoneno.'</p></h3>



                <h3><p style="text-align:left;display:block;color:#333">Comments: '.$email_info['contact_submission_comments'].'</p></h3>



                </div>



                <div style="background-color:#999;height:60px"></div>



                </div>



                </div>



                </body>';



                //var_dump($message_body);



                $this->load->library('email');



                $this->email->clear();



                $this->email->from($fromemail);



                $this->email->subject($email_subject);



                $this->email->message($message_body);



                if($emailId!=''){



                    $this->email->to($emailId);



                    $to[]=$emailId;



                    if($this->email->send()){



                        $query = $this->db->query($sql);



                        $id = $this->db->insert_id();



                        if($id!=0){



                            echo $id;



                        }else{



                            echo 0;



                        }



                    }else{



                        echo 0;



                    }



                }else{



                    echo 0;



                }



            }else{



                echo 0;



            }



        }



    }



    /**



     * This function is displaying job_offers features on directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> busid</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>get_businessdetails</b> (Model Name: ad)</li>



     * <li><b>get_jobdetails</b> (Model Name: ad)</li>



     * </ol>



     * view page: <b>views/job_offers</b>



     */



// tamal



    public function job_offers($busid=false){//calling from new_page



        $data = array();



        $data['theme_id'] = $_REQUEST['theme_id'];



        $data['businessdetails']=$this->ad->get_businessdetails($busid); // get business details



        $data['jobdetails'] = $this->ad->get_jobdetails($busid); // get job details



        $this->load->view('job_offers', $data);



    }



    /**



     * This function is displaying barter offers features on directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> busid</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>get_businessdetails</b> (Model Name: ad)</li>



     * <li><b>get_barterdetails</b> (Model Name: ad)</li>



     * </ol>



     * view page: <b>views/barter_offers</b>



     */



 


    public function barter_offers($busid=false){//var_dump($_REQUEST);exit;//calling from new_page



        $data = array();



        $data['theme_id'] = $_REQUEST['theme_id'];



        $data['businessdetails']=$this->ad->get_businessdetails($busid); // get business details



        $data['barterdetails'] = $this->ad->get_barterdetails($busid); // get barter details



        $this->load->view('barter_offers', $data);



    }



    /**



     * This function is displaying Webinar Link and Webinar Description on directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> adId</li>



     * <li> zoneId</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>webinar_information</b> (Model Name: ad)</li>



     * </ol>



     */



 



    function get_webniar(){ //calling from new_page offer



        $data = array();



        $adId = $_REQUEST['addid'];



        $zoneId = $_REQUEST['zoneid'];



        $data['webinar_information'] = $this->ad->webinar_information($adId,$zoneId);



        if(!empty($data['webinar_information'])){



            $data['webinar_information'][0]['webinarlink'] = $data['webinar_information'][0]['link'] ;



        }



        echo json_encode(isset($data['webinar_information'][0]) ? $data['webinar_information'][0] : '');



    }



    /**



     * This function use because whenever a user/business owner/zone owner click Webinar Link then webinar link open in a new tab .



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneId</li>



     * <li> userid</li>



     * <li> userid</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>join_webinar</b> (Model Name: ad)</li>



     * </ol>



     */



// tamal



    function join_webinar(){ //calling from new_page offer



        $zoneId=(!empty($_REQUEST['zoneid'])) ? $_REQUEST['zoneid'] : "" ;



        $userid=(!empty($_REQUEST['userid'])) ? $_REQUEST['userid'] : "" ;//var_dump($userid);exit;



        $webinarlink=(!empty($_REQUEST['webinarlink'])) ? $_REQUEST['webinarlink'] : "" ;



        $webinarid=(!empty($_REQUEST['webinarid'])) ? $_REQUEST['webinarid'] : "" ;



        $response = $this->ad->join_webinar($zoneId,$userid,$webinarid);



        echo $response;



    }



    /**



     * This function is displaying webinar schedule features on directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> adId</li>



     * <li> zoneId</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>webinar_schedule_details</b> (Model Name: ad)</li>



     * </ol>



     */



// tamal



    function webinar_schedule(){ //calling from new_page offer



        $data = array();



        $adId = $_REQUEST['addid'];



        $zoneId = $_REQUEST['zoneid'];



        $data['schedule_details'] = $this->ad->webinar_schedule_details($adId,$zoneId);



        echo json_encode(isset($data['schedule_details'][0]) ? $data['schedule_details'][0] : '');



    }



    /**



     * This function is displaying (display coupon) in left panel on directory page.



     *



     * This function is accessable from the directory page.



     */



    function display_coupon(){//var_dump($_REQUEST);exit;//calling from new_page



// $data['coupon_view']=$this->announcements->coupon_view();



        $this->load->view('coupon_img');



    }



    function coupon_directory(){



        $zoneid = $_REQUEST['zoneid'];



        $link = $this->announcements->coupon_view($zoneid);



        echo($this->dr->GetDR("", "", $link, "0"));



    }



    function get_grocerycoupon(){



        $data = array();



        $data['zoneId']=(!empty($_REQUEST['zone_id'])) ? $_REQUEST['zone_id'] : "" ;



        $data['link'] = $this->announcements->coupon_view($data['zoneId']);//var_dump($data['link']);exit;



        $this->load->view('coupon_img', $data);



        /*if($data['link']==1)



        $this->load->view('coupon_img');



        else



        $this->load->view('coupon_img');*/



    }



    /**



     * This function is used for Add rating.



     *



     * This function is accessable from the zone directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * <li> userid</li>



     * <li> rating value</li>



     * <li> other parameters from view page.</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>updaterating</b> (Model Name: ad)</li>



     * </ol>



     */



    public function ratead(){



        isset($_REQUEST['user_id']) ? $user_id=$_REQUEST['user_id'] : $user_id='';



        isset($_REQUEST['bus_id']) ? $bus_id=$_REQUEST['bus_id'] : $bus_id='';



        isset($_REQUEST['rate']) ? $rate=$_REQUEST['rate'] : $rate='';



        isset($_REQUEST['zone_id']) ? $zone_id=$_REQUEST['zone_id'] : $zone_id='';



        isset($_REQUEST['commentrating']) ? $commentrating=$_REQUEST['commentrating'] : $commentrating='';



        $result=$this->ad->updaterating($user_id, $bus_id, $rate,$zone_id,$commentrating);



        $message = "Your Rating is successfully stored in database.";



        echo json_encode($result);



    }



    /**



     * This function is used for comment part for Add rating.



     *



     * This function is accessable from the zone directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * <li> userid</li>



     * <li> business id</li>



     * <li> other parameters from view page.</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>insertcomment</b> (Model Name: ad)</li>



     * </ol>



     */



    public function commentadd(){



        isset($_REQUEST['user_id']) ? $user_id=$_REQUEST['user_id'] : $user_id='';



        isset($_REQUEST['bus_id']) ? $bus_id=$_REQUEST['bus_id'] : $bus_id='';



        isset($_REQUEST['rate']) ? $rate=$_REQUEST['rate'] : $rate='';



        isset($_REQUEST['zone_id']) ? $zone_id=$_REQUEST['zone_id'] : $zone_id='';



        isset($_REQUEST['commentrating']) ? $commentrating=$_REQUEST['commentrating'] : $commentrating='';



        $result=$this->ad->insertcomment($user_id, $bus_id, $rate,$zone_id,$commentrating);



        $message = "Your comment is successfully stored in database.";



        echo json_encode($result);



    }



    /**



     * This function is used to displaying ratings.



     *



     * This function is accessable from the zone directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * <li> business id</li>



     * <li> other parameters from view page.</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>viewallratingandcomment</b> (Model Name: ad)</li>



     * </ol>



     */



    public function viewallrating(){



        isset($_REQUEST['business_id']) && $_REQUEST['business_id']!='' ? $business_id=$_REQUEST['business_id'] : $business_id=0;



        isset($_REQUEST['zoneid']) && $_REQUEST['zoneid']!='' ? $zoneid=$_REQUEST['zoneid'] : $zoneid=0;



        $data=array();



        $data['viewallrating']=$this->ad->viewallratingandcomment($business_id, $zoneid);



        echo json_encode($data['viewallrating']);



    }



    /**



     * This function is used to displaying comments.



     *



     * This function is accessable from the zone directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * <li> business id</li>



     * <li> other parameters from view page.</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>viewallcomment</b> (Model Name: ad)</li>



     * </ol>



     */



    public function viewallcomment(){ 



        isset($_REQUEST['business_id']) && $_REQUEST['business_id']!='' ? $business_id=$_REQUEST['business_id'] : $business_id=0;



        isset($_REQUEST['zoneid']) && $_REQUEST['zoneid']!='' ? $zoneid=$_REQUEST['zoneid'] : $zoneid=0;



        $data=array();



        $data['viewallcomment']=$this->ad->viewallcomment($business_id, $zoneid);



        echo json_encode($data['viewallcomment']);



    }



    /**



     * This is the controller function of displaying All types of ads on directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * <li> other parameters from view page.</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>get_ads_for_all_athena_latest_working_anish</b> (Model Name: ad)</li>



     * </ol>



     * <br>



     * view page: <b>views/new_page_offer</b>



     */


      public function temp_ads_ajax(){

 

 
        $data = array();

 
        $config['uri_segment'] = 4; 



        $config['enable_query_strings'] = TRUE;



        $config['page_query_string'] = TRUE;



        $config['query_string_segment'] = 'per-post-onpage';


        $config['per_page'] = 20;


        $order_online = isset($_REQUEST['order_online']) ? $_REQUEST['order_online'] : 0;        



        $zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;



        $userId=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;



        $config['base_url'] = base_url().'businessSearch/search/'+$zone_id;



        $lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0; //limit 

     

        $upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 0;  // offset 

    
        $cost_limit=!empty($_REQUEST['cost_limit']) ? $_REQUEST['cost_limit'] : 0;



        $data['barter_button']=!empty($_REQUEST['barter_button']) ? $_REQUEST['barter_button'] : '';



        $data['job_button']=!empty($_REQUEST['job_button']) ? $_REQUEST['job_button'] : '';



        $subcat_id=!empty($_REQUEST['subcat_id']) ? $_REQUEST['subcat_id'] : 0;



        $cat_id=!empty($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 0;



        $from_where='show_favorites_ads';



        $search_value=!empty($_REQUEST['search_value']) ? $_REQUEST['search_value'] : '';


 
        $user_id=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;



        $charval=!empty($_REQUEST['charval']) ? $_REQUEST['charval'] : '';



        $deal_title_ad_id=!empty($_REQUEST['deal_title_ad_id']) ? $_REQUEST['deal_title_ad_id'] : 0;


        $deal_title_type=!empty($_REQUEST['deal_title_type']) ? $_REQUEST['deal_title_type'] : '';



        $deal_title=!empty($_REQUEST['deal_title']) ? $_REQUEST['deal_title'] : '';



        $food_deliver=!empty($_REQUEST['food_deliver']) ? $_REQUEST['food_deliver'] : 0;



        $subcatparentid = !empty($_REQUEST['subcatparentid']) ? $_REQUEST['subcatparentid'] : 0;



        $ads_view = !empty($_REQUEST['ads_view']) ? $_REQUEST['ads_view'] : 'full';

 

        $data['link_path']= !empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : "";
 

        if($from_where=='home_page_ads'){



            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit);



            $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000);



        } else if($from_where=='show_all_offers'){ // show all offers



            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0,0,0,0,$charval,'show_all_offers');



            $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,0,0,0,0,$charval,'show_all_offers');



        }else if($from_where=='show_temp_ads'){ // business coming soon



            if($subcat_id==0){ // 0 means business comming soon



                $subCatId=-99;



            }if($cat_id==0){



                $catId=-99;



            }



            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',$catId,$subCatId);

 

            $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',$catId,$subCatId);



        }else if($from_where=='show_ads_specific_sub_category'){ // show_ads_specific_sub_category



            $data['call_again'] = !empty($_REQUEST['call_again']) ? $_REQUEST['call_again'] : false;



            if($subcat_id == '45')



            {



                $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0);



                $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,0);



            }



            else{



            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,$subcat_id);

            $total_post =  $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,$subcat_id);



            }

 



        }else if($from_where=='show_ads_specific_category'){ // show_ads_specific_category
            

 
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',$cat_id,0,0,0,0,'',0,'','',$food_deliver);

            $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',$cat_id,0,0,0,0,'',0,'','',$food_deliver);

 

        }else if($from_where=='show_search_business'){ // show_search_business



            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value);

            $total_post=  $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,$search_value);





        }else if($from_where=='show_favorites_ads'){ // show_favorites_ads



            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0,$user_id);



            $total_post= $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,0,$user_id);





        }else if($from_where=='sharing_offers'){ // sharing_offers



           $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0,0,0,0,'',$deal_title_ad_id,$deal_title_type,$deal_title);



           $total_post= $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,0,0,0,0,'',$deal_title_ad_id,$deal_title_type,$deal_title);



        }else if($from_where=='show_ads_specific_subcatparentid_category'){ // By Industry & Start-up Cost header link



            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0,0,0,0,'',0,'','','',$subcatparentid);



           $total_post=  $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,0,0,0,0,'',0,'','','',$subcatparentid);







        }else if($from_where=='show_ads_specific_startupcostlimit'){



            $multiplesubcatid = '' ;



            $multiplesubcatid = $this->Category_new_model->get_subcat_under_startupcost_limits($cost_limit);



            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0,0,0,0,'',0,'','','','',$multiplesubcatid);



            $total_post=  $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,0,0,0,0,'',0,'','','','',$multiplesubcatid);







        }elseif($from_where=='sponsor_businesses_home_page'){



            $data['call_again'] = !empty($_REQUEST['call_again']) ? $_REQUEST['call_again'] : false;



            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 1);



            $total_post= $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 1);



        }elseif($from_where=='sponsor_businesses_menu_home_page'){ 

             



            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value,$cat_id=0,$subcat_id,$user_id='',$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 1,$order_online);



            $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,$search_value,$cat_id=0,$subcat_id,$user_id='',$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 1,$order_online);



        }elseif($from_where=='show_mover_business'){



            /*for showing data on movers page*/



            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 3);



            $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 3);





        }else if($from_where=='filter-for-pboo'){ 



            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval,$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 4);



             $total_post =  $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000 ,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval,$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 4);



        }elseif($from_where =='sponsor_businesses_menu_online_delievry_order'){ 





            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval,$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 4);



            $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval,$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 4);



        } 
 

        $config['total_rows'] =count($total_post); 

        $config['cur_tag_open'] = '<a href="'.base_url().'businessSearch/search/'.$zone_id.'" data-paginat=""  >';          

        $config['cur_tag_close'] = '</a>';

        $config['next_link'] = '&gt;';

       

        $config['prev_link'] = '&gt;';    

        $config['reuse_query_string'] = TRUE;   

      

        $config['num_links']=count($total_post);

        $config['full_tag_open'] = '<ul class="pagination">';

        $config['full_tag_close'] = '</ul>';

        $config['attributes'] = array('data-attr' => 'posted_pagination'  );

        if ($_REQUEST['embed'] == 1) { 

            $config['suffix'] = '&embed=1';
            $config['first_url'] = base_url().'businessSearch/search/'.$zone_id.'?embed=1';

        }else{
                      $config['first_url'] = base_url().'businessSearch/search/'.$zone_id.'?per-post-onpage=0';

        }
 
        $this->pagination->initialize($config);

         echo   '<div class="headpgination">'.$this->pagination->create_links().'</div>';

        $data['links'] = $this->pagination->create_links();
     
  
 


// ++ load peekaboo auctions on advertisement load


        if(!empty($data['adlist'])){



            $currentadid_arr = array();

            foreach($data['adlist'] as $key=>$addetails){


                     if($from_where=='filter-for-pboo'){ 
                     
                         $data['adlist'][$key]['peekaboolist'] = $this->ad->show_popup($addetails['adid'], $zone_id,$charval) ;

                    }else{

                      $data['adlist'][$key]['peekaboolist'] = $this->ad->show_popup($addetails['adid'], $zone_id) ;

                    }


                   $data['adlist'][$key]['isFoodCategory'] = $this->ad->is_food_category($addetails['adid']);



            }

 



        }



// -- load peekaboo auctions on advertisement load



        $data['from_adspage']=0;



        $data['zone'] = $zone_id;



        $data["user_id"] = "";



        $data['order_online'] = $order_online;



        $data["restaurantTimeList"] = $this->diningmodel->getTimeListArray();  



        $data['from_where'] = $from_where;



        if ($this->ion_auth->logged_in()){



            $auser = $this->ion_auth->user()->row();



            $data['user_info'] = $this->ion_auth->user()->row();



            $data["user_id"] = $auser->id;



        }

 
 



        foreach($data['adlist'] as $key=>$adddetails){


 

         $data['adlist'][$key]['selectMenu'] = $this->ad->get_menu($adddetails['bs_id']);

 

          $data['adlist'][$key]['reservationdetail']   = $this->Category_new_model->get_category_subcategory($adddetails['adid'],$zone_id);

        }


        $data_html = $this->load->view('includes/directory_offer_compact', $data);  

        return $data_html;



    }






    public function temp_ads(){
        $data = array();
        $config['uri_segment'] = 4; 
        $config['enable_query_strings'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'per-post-onpage';
        $config['per_page'] = 10;

        $order_online = isset($_REQUEST['order_online']) ? $_REQUEST['order_online'] : 0;        
        $zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;
        $userId=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
        $config['base_url'] = base_url().'businessSearch/search/'.$zone_id;
        $lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0; //limit 
        $upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 0;  // offset 
        $cost_limit=!empty($_REQUEST['cost_limit']) ? $_REQUEST['cost_limit'] : 0;
        $data['barter_button']=!empty($_REQUEST['barter_button']) ? $_REQUEST['barter_button'] : '';
        $data['job_button']=!empty($_REQUEST['job_button']) ? $_REQUEST['job_button'] : '';
        $subcat_id=!empty($_REQUEST['subcat_id']) ? $_REQUEST['subcat_id'] : 0;
        $cat_id=!empty($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 0;
        $from_where=!empty($_REQUEST['from_where']) ? $_REQUEST['from_where'] : '';
        $search_value=!empty($_REQUEST['search_value']) ? $_REQUEST['search_value'] : '';
        $user_id=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;
        $charval=!empty($_REQUEST['charval']) ? $_REQUEST['charval'] : '';
        $deal_title_ad_id=!empty($_REQUEST['deal_title_ad_id']) ? $_REQUEST['deal_title_ad_id'] : 0;
        $deal_title_type=!empty($_REQUEST['deal_title_type']) ? $_REQUEST['deal_title_type'] : '';
        $deal_title=!empty($_REQUEST['deal_title']) ? $_REQUEST['deal_title'] : '';
        $food_deliver=!empty($_REQUEST['food_deliver']) ? $_REQUEST['food_deliver'] : 0;
        $subcatparentid = !empty($_REQUEST['subcatparentid']) ? $_REQUEST['subcatparentid'] : 0;
        $ads_view = !empty($_REQUEST['ads_view']) ? $_REQUEST['ads_view'] : 'full';
        $data['link_path']= !empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : "";
        
        if($from_where=='home_page_ads'){
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit);
            $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000);
        } else if($from_where=='show_all_offers'){ // show all offers
            $data['adlist'] = $this->Ads_model->get_ads_for_all_athena_latest_working_anishnew($zone_id,$lowerlimit,$upperlimit,'',0,0,0,0,0,$charval,0,0,0,0,0,0,0,0,'show_all_offers');
            $data['total_post'] = $this->Ads_model->get_ads_for_all_athena_latest_working_anishtotal($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,0,0,0,0,$charval,0,0,0,0,0,0,0,0,'show_all_offers');
        }else if($from_where=='show_temp_ads'){ // business coming soon
            if($subcat_id==0){  // 0 means business comming soon
                $subCatId=-99;
            }
            if($cat_id==0){
                $catId=-99;
            }
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',$catId,$subCatId);
            $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',$catId,$subCatId);
        }else if($from_where=='show_ads_specific_sub_category'){ // show_ads_specific_sub_category
            $data['call_again'] = !empty($_REQUEST['call_again']) ? $_REQUEST['call_again'] : false;
            $data['adlist'] = $this->Ads_model->get_ads_for_all_athena_latest_working_anishnew($zone_id,$lowerlimit,$upperlimit,'',0,$subcat_id,0,0,0,'',0,'','',$food_deliver,0,0,0,0,'show_ads_specific_sub_category');
            $data['total_post'] =  $this->Ads_model->get_ads_for_all_athena_latest_working_anishtotal($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,$subcat_id);
        }else if($from_where=='show_ads_specific_category'){ // show_ads_specific_category
            $data['adlist'] = $this->Ads_model->get_ads_for_all_athena_latest_working_anishnew($zone_id,$lowerlimit,$upperlimit,'',$cat_id,$subcat_id,$user_id,0,0,'',0,'','',$food_deliver,0,0,0,0,'show_ads_specific_category');
            $data['total_post'] = $this->Ads_model->get_ads_for_all_athena_latest_working_anishtotal($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',$cat_id,$subcat_id,0,0,0,'',0,'','',$food_deliver,0,0,0,0,'show_ads_specific_category');
        }else if($from_where=='show_search_business'){ // show_search_business
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anishnew($zone_id,$lowerlimit,$upperlimit,$search_value);
            $total_post=  $this->ad->get_ads_for_all_athena_latest_working_anishtotal($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,$search_value);
        }else if($from_where=='show_favorites_ads'){ // show_favorites_ads
            $data['adlist'] = $this->Ads_model->get_ads_for_all_athena_latest_working_anishnew($zone_id,$lowerlimit,$upperlimit,'',0,0,$user_id,0,0,'',0,'','',$food_deliver,0,0,0,0,'show_favorites_ads');
            $data['total_post'] = count($data['adlist']);//$this->Ads_model->get_ads_for_all_athena_latest_working_anishtotal($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,0,$user_id);
        }else if($from_where=='sharing_offers'){ // sharing_offers
            $data['adlist'] = $this->Ads_model->get_ads_for_all_athena_latest_working_anishnew($zone_id,$lowerlimit,$upperlimit,'',0,0,0,0,0,'',$deal_title_ad_id,$deal_title_type,$deal_title,0,0,0,0,0,'sharing_offers');
            // $total_post= $this->Ads_model->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,0,0,0,0,'',$deal_title_ad_id,$deal_title_type,$deal_title);

            $total_post= count($data['adlist']);
        }else if($from_where=='show_ads_specific_subcatparentid_category'){ // By Industry & Start-up Cost header link
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0,0,0,0,'',0,'','','',$subcatparentid);
            $total_post=  $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,0,0,0,0,'',0,'','','',$subcatparentid);
        }else if($from_where=='show_ads_specific_startupcostlimit'){
            $multiplesubcatid = '' ;
            $multiplesubcatid = $this->Category_new_model->get_subcat_under_startupcost_limits($cost_limit);
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,'',0,0,0,0,0,'',0,'','','','',$multiplesubcatid);
            $total_post=  $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',0,0,0,0,0,'',0,'','','','',$multiplesubcatid);
        }elseif($from_where=='sponsor_businesses_home_page'){
            $data['call_again'] = !empty($_REQUEST['call_again']) ? $_REQUEST['call_again'] : false;
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 1);
            $total_post= $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 1);
        }elseif($from_where=='sponsor_businesses_menu_home_page'){ 
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value,$cat_id=0,$subcat_id,$user_id='',$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 1,$order_online);
            $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,$search_value,$cat_id=0,$subcat_id,$user_id='',$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 1,$order_online);
        }elseif($from_where=='show_mover_business'){//for showing data on movers page
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 3);
            $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval='',$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 3);
        }else if($from_where=='filter-for-pboo'){ 
            $data['adlist'] = $this->Ads_model->get_ads_for_all_athena_latest_working_anishnew($zone_id,$lowerlimit,$upperlimit,$search_value='',$cat_id=0,$subcat_id,$user_id=0,$buseness_id=0,$ad_id=0,$charval,$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 4,'filter-for-pboo');
            
            $data['total_post'] =  $this->Ads_model->get_ads_for_all_athena_latest_working_anishtotal($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000 ,$search_value='',$cat_id=0,$subcat_id,$user_id=0,$buseness_id=0,$ad_id=0,$charval,$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 4,'filter-for-pboo');
        }elseif($from_where =='sponsor_businesses_menu_online_delievry_order'){ 
            $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit,$upperlimit,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval,$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 4);
            $total_post = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,$search_value='',$cat_id=0,$sub_cat_id=0,$user_id=0,$buseness_id=0,$ad_id=0,$charval,$deal_title_ad_id=0,$deal_title_type='',$deal_title='',$food_deliver=0, $subcatparentid=0 , $multiplesubcatid = 0, $business_sponsor = 4);
        }elseif($from_where =='show_data_miles'){ 
            $data['adlist'] = $this->Ads_model->get_ads_for_all_athena_latest_working_anishnew($zone_id,$lowerlimit,$upperlimit,$search_value,$cat_id,$subcat_id,$user_id,0,0,'',0,'','',$food_deliver,0,0,0,0,'show_data_miles');
            $data['total_post'] = $this->Ads_model->get_ads_for_all_athena_latest_working_anishnew($zone_id,$lowerlimit= 0  ,$upperlimit = 10000000,'',$cat_id,$subcat_id,$user_id,0,0,'',0,'','',$food_deliver,0,0,0,0,'show_data_miles','total');
        } 
        
     
        // $data['peekaboocredits'] = $this->Organization_model->getpeekaboocreditsofresidentuser($userId, $zone_id);
        //load peekaboo auctions on advertisement load
        
        if(!empty($data['adlist'])){
            $currentadid_arr = array() ;
            if($zone_id == 598){
                // echo "<pre>";print_r($data['adlist']);die;
            }
            foreach($data['adlist'] as $key=>$addetails){
                if($from_where=='filter-for-pboo'){ 
                    $data['adlist'][$key]['peekaboolist'] = $this->Ads_model->show_dealsnew($addetails['adid'], $zone_id,$charval,$addetails['username'], $addetails['busid'],$addetails['tbl_user_id'],$addetails['bs_name']) ;
                    $data['adlist'][$key]['fullview'] = $this->Ads_model->show_dealsnew($addetails['adid'], $zone_id,$charval,$addetails['username'], $addetails['busid'],$addetails['tbl_user_id'],$addetails['bs_name']) ;
                }else{
                    $data['adlist'][$key]['peekaboolist'] = $this->Ads_model->show_dealsnew($addetails['adid'], $zone_id,'',$addetails['username'], $addetails['busid'],$addetails['tbl_user_id'],$addetails['bs_name'],$addetails['aucid']) ;
                    $data['adlist'][$key]['fullview'] = $this->Ads_model->show_dealsnew($addetails['adid'], $zone_id,'',$addetails['username'], $addetails['busid'],$addetails['tbl_user_id'],$addetails['bs_name']) ;
                }
                $data['adlist'][$key]['isFoodCategory'] = $this->Ads_model->is_food_category($addetails['adid']);
            }
        }
       
        //load peekaboo auctions on advertisement load
        // echo "<pre>";print_r($data['adlist']);die;
        $data['from_adspage']=0;
        $data['zone'] = $zone_id;
        $data["user_id"] = $user_id;
        $data['order_online'] = $order_online;
        $data["restaurantTimeList"] = $this->Diningmodel->getTimeListArray();  
        $data['from_where'] = $from_where;
        
        foreach($data['adlist'] as $key=>$adddetails){
            $data['adlist'][$key]['selectMenu'] = $this->Ads_model->get_menu($adddetails['bs_id']);
            $data['adlist'][$key]['snap_status'] = $this->Ads_model->get_offer_status_check($adddetails['bs_id'],$userId,2,$zone_id,$adddetails['adid']);
            $data['adlist'][$key]['reservationdetail']   = $this->Category_new_model->get_category_subcategory($adddetails['adid'],$zone_id);
        }
        if($from_where=='sharing_offers'){
            if ($this->ionAuth->loggedIn()){
                $auser = $this->ionAuth->user()->row();
                $data['user_info'] = $auser;
                $data["user_id"] = $auser->id;
            }else{
                $data['user_info'] = '';
                $data["user_id"] = '';
            }
            $html = view('includes/directory_offer', $data);
            echo  "<pre>";print_r($html);die;
        }else{
            echo json_encode($data);
            die;
        }
    }






    



    public function searchAdsByDeliverCode(){




        $data = array();        



        $order_online = isset($_REQUEST['order_online']) ? $_REQUEST['order_online'] : 0;

 

        $zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;



        $userId=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;



        $lowerlimit=!empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0;



        $upperlimit=!empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 0;



        $cost_limit=!empty($_REQUEST['cost_limit']) ? $_REQUEST['cost_limit'] : 0;



        $subcat_id=!empty($_REQUEST['subcat_id']) ? $_REQUEST['subcat_id'] : 0;



        $cat_id=!empty($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 0;



         $user_id=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;



        $lat=!empty($_REQUEST['lat']) ? $_REQUEST['lat'] : 0;



        $long=!empty($_REQUEST['long']) ? $_REQUEST['long'] : 0;



        $charval=!empty($_REQUEST['charval']) ? $_REQUEST['charval'] : '';



        $food_deliver=!empty($_REQUEST['food_deliver']) ? $_REQUEST['food_deliver'] : 0;



        $ads_view = !empty($_REQUEST['ads_view']) ? $_REQUEST['ads_view'] : 'compact';



        $deliver_status = !empty($_REQUEST['deliver_status']) ? $_REQUEST['deliver_status'] : 0;



        $data['link_path']= !empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : "";



      



          $data['adlist'] = $this->ad->SearchByDeliveryCode($zone_id,$lowerlimit,$upperlimit,$charval,$food_deliver, $lat , $long , $deliver_status);



     



        if(!empty($data['adlist'])){



            $currentadid_arr = array() ;



 

            foreach($data['adlist'] as $key=>$addetails){



               



             $data['adlist'][$key]['peekaboolist'] = $this->ad->show_serachDeliverypopup($addetails['adid'], $zone_id) ;



           



             $data['adlist'][$key]['isFoodCategory'] = $this->ad->is_food_category($addetails['adid']);

 

 

            }



    



 



        }



// -- load peekaboo auctions on advertisement load



        $data['from_adspage']=0;



        $data['zone'] = $zone_id;



        $data["user_id"] = "";
       

     


        $data['order_online'] = $order_online;



        $data["restaurantTimeList"] = $this->diningmodel->getTimeListArray(); 



//$data['from_where'] = 'subcategory';



        $data['from_where'] = $from_where;



        if ($this->ion_auth->logged_in()){



            $auser = $this->ion_auth->user()->row();


            $data['user_info'] = $this->ion_auth->user()->row();



                $data["user_id"] = $auser->id;


                $data["email"] = $auser->email; 
                $data["firstName"] = $auser->first_name;
                $data["lastName"] = $auser->last_name;
                $data['businessUser'] = $auser;
                $data['UserZip'] = $auser->Zip;                
                $data['username'] = $auser->username;
 
        }

 


        if('compact' == $ads_view){
 
        	$this->load->view('includes/online_order_offer', $data);
 
        }else {



        	$this->load->view('includes/directory_offer', $data);



        }



        



    }



    public function searchCordsByDeliverCode(){



       $zipcode=!empty($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : 0 ;  

       

        $result=  $this->ad->get_coordinates_byZipCode($zipcode);



        echo $result;





    }



    public function single_ad(){  //calling from new_page







        $data = array();



        $zone_id=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0;



        $userId=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0;



        $bus_id=!empty($_REQUEST['bus_id']) ? $_REQUEST['bus_id'] : 0;



        $ad_id=!empty($_REQUEST['ad_id']) ? $_REQUEST['ad_id'] : 0;

       // $publisgerEmail= $this->getpublisherEmail();




        $data['adlist'] = $this->ad->get_ads_for_all_athena_latest_working_anish($zone_id,0,100,'',0,0,$userId,$bus_id,$ad_id);



        $data['link_path']= !empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : "";



        if(!empty($data['adlist'])){



            $currentadid_arr = array() ;



            foreach($data['adlist'] as $key=>$addetails){



                $data['adlist'][$key]['peekaboolist'] = $this->ad->show_deals($addetails['adid'], $zone_id) ;



                $data['adlist'][$key]['isFoodCategory'] = $this->ad->is_food_category($addetails['adid']);



            }



        }



        $data['zone'] = $zone_id;



        $data["user_id"] = "";



        $data["restaurantTimeList"] = $this->diningmodel->getTimeListArray(); 



        if ($this->ion_auth->logged_in()){



            $auser = $this->ion_auth->user()->row();



            $data['user_info'] = $this->ion_auth->user()->row();



            $data["user_id"] = $auser->id;            



        }



                $data['get_paypal_info'] = $this->zone_model->checkExistPaypalid($zone_id);

                $data['peekaboocredits'] = $this->org_model->getpeekaboocreditsofresidentuser($userId, $zone_id);



        foreach($data['adlist'] as $key=>$adddetails){



           
          


            $data['adlist'][$key]['reservation'] = $this->ad->reservation_menu($adddetails['bs_id']);



            $data['adlist'][$key]['snapPeeks'] = $this->ad->snap_peeks($adddetails['bs_id']);



            $data['adlist'][$key]['useremail'] = $this->ad->get_user_email($userId);



            $data['adlist'][$key]['selectTheme'] = $this->ad->get_theme($adddetails['bs_id']);



            $data['adlist'][$key]['selectMenu'] = $this->ad->get_menu($adddetails['bs_id']);



            $data['adlist'][$key]['snap_status'] = $this->ad->get_offer_status_check($adddetails['bs_id'],$userId,2,$zone_id,$adddetails['adid']);



            $data['adlist'][$key]['isFoodCategory'] = $this->ad->is_food_category($addetails['adid']);



			$data['adlist'][$key]['reservationdetail'] = $this->Category_new_model->get_category_subcategory($adddetails['adid'],$zone_id);



			$data['adlist'][$key]['menuCategoryList'] = $this->delivery->get_category($zone_id,$adddetails['bs_id'],6);



			$data['adlist'][$key]['menuSubcategoryList'] = $this->delivery->get_subcategory($zone_id,$adddetails['bs_id'],6);



        }



      // var_dump($data['peekaboolist']);die;



        $this->load->view('includes/directory_offer_single', $data);



        



    }



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    /**



     * This function displayed category value on directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> adid</li>



     * <li> zoneid</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>display_cat_subcat_for_directory</b> (Model Name: Category_new_model)</li>



     * </ol>



     */



    public function display_cat_subcat_for_directory(){//calling from new_page offer



        $adid=!empty($_REQUEST['adid']) ? $_REQUEST['adid'] : 0 ;



        $zoneid=!empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0 ;



        $result= $this->Category_new_model->display_cat_subcat_for_directory($adid,$zoneid);



        echo $result;



    }



    /**



     * This functio not in used



     */



    public function display_specific_cat_subcat_for_directory(){//calling from new_page



        $subcat_id=!empty($_REQUEST['subcat_id']) ? $_REQUEST['subcat_id'] : 0 ;



        $result= $this->Category_new_model->display_specific_cat_subcat_for_directory($subcat_id);



        echo $result;



    }



    /**



     * This functio not in used



     */



    public function display_specific_cat_for_directory(){//calling from new_page



        $cat_id=!empty($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : 0 ;



        $result= $this->Category_new_model->display_specific_cat_for_directory($cat_id);



        echo $result;



    }



// + Sub-Category header for 'By Industry & Start-up Cost'



    public function display_specific_subcatparentid_for_directory(){//calling from new_page



        $subcat_id=!empty($_REQUEST['subcat_id']) ? $_REQUEST['subcat_id'] : 0 ;



        $result= $this->Category_new_model->display_specific_subcatparentid_for_directory($subcat_id); //var_dump($result);



        echo $result;



    }



    /**



       * Get all organization details within zone



       * @param zone id 



       * return organization list







    */



    public function get_organization_list(){



        $zone_id = $this->input->post('zoneid');



        $org_details = $this->org_model->get_all_active_org_list_except_highschool($zone_id);



        echo json_encode($org_details);







    }



// - Sub-Category header for 'By Industry & Start-up Cost'



##################################################################################################################################



    /**



     * This function displayed Normal User Profile Account on directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * <li> user_id</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>get_all_businesses_approved</b> (Model Name: business)</li>



     * </ol>



     */



    public function get_normal_user_profile($zoneId=0){//calling from new_page



        $data = array();



        $data['zoneid']=$zoneId;



        if ($this->ion_auth->logged_in()){



            $auser = $this->ion_auth->user()->row();



            if(!empty($auser)){



                $data["user_id"] = $auser->user_id;



                $data["email"] = $auser->email;



                $data["firstName"] = $auser->first_name;



                $data["phone"] = $auser->phone;



                $data['all_zone']=$this->sales_zone->get_all_zones();



                $data['approved_bus'] = $this->business->get_all_businesses_approved($zoneId,$auser->user_id); 



            }



        }

// print_r($data);

        $this->load->view('user_profile', $data);



    }



// Res User Account Business Offer and Organization Offer (TAB)



    /**



     * This is the controller function of displaying All types of ads on directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * <li> other parameters from view page.</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>get_ads_for_all_athena_latest_working_anish</b> (Model Name: ad)</li>



     * </ol>



     * <br>



     * view page: <b>views/new_page_offer</b>



     */



    function get_user_ig($zoneid=0, $userid = 0 , $type=0){ //calling from new_page


       if($userid == 0){
           $userid =  $auser->user_id;
        }

 
 
        
        $data = array();



        $data['zone_id']=$zoneid;



        $auser = $this->ion_auth->user()->row();



        $data['approved_bus'] = $this->users->get_all_interest_group_for_user($zoneid,$userid,$type);



        



//var_dump($data['approved_bus']);



        if($type==2)



            $this->load->view('ig_bus_details', $data);



        else if($type==3)



            $this->load->view('ig_org_details', $data);



    }



// Res User Profile Update (TAB)



    /**



     * This is the controller function of displaying All types of ads on directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> userid</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>get_user_details</b> (Model Name: users)</li>



     * </ol>



     * <br>



     * view page: <b>views/user_details</b>



     */



    // function user_profile_update($zoneid=0,$userid=0){//calling from new_page



    //     $data = array();



    //     $data['zone_id']=$zoneid;



    //     $data['user'] = $this->users->get_user_details($userid);



    //     $this->load->view('user_details', $data);



    // }



// Res User Account Business Newsletter (TAB)



    /**



     * This is the controller function of displaying All types of ads on directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * </ol>



     * <ol>



     * <li> $auser</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>get_all_businesses_approved_in_newsletter</b> (Model Name: users)</li>



     * </ol>



     * <br>



     * view page: <b>views/newsletter_list_details</b>



     */



    function display_newsletter_list_in_zone($zoneid=false){ //calling from new_page



        $data = array();



        $data['zone_id']=$zoneid;



        $auser = $this->ion_auth->user()->row();



        $data['approved_bus'] = $this->users->get_all_businesses_approved_in_newsletter($zoneid,$auser->user_id);



        $this->load->view('newsletter_list_details', $data);



    }



// User Profile Update
    public function profile_update($id=0,$fn='',$ln='',$phone='',$carrier=''){
        $id = isset($_REQUEST['id'])?$_REQUEST['id']:$id;
        $fn = isset($_REQUEST['fn'])?$_REQUEST['fn']:$fn;
        $ln = isset($_REQUEST['ln'])?$_REQUEST['ln']:$ln;
        $phone = isset($_REQUEST['phone'])? str_replace("-", "", $_REQUEST['phone']):$phone;
        $carrier = isset($_REQUEST['carrier'])?$_REQUEST['carrier']:$carrier;
        $alternatephone = isset($_REQUEST['alternatephone'])?$_REQUEST['alternatephone']:[];
        $this->Users->get_profile_update($id,$fn,$ln,$phone,$carrier,$alternatephone); 
    }



// Organization settings for Directory page (TAB)



    /**



     * This is the controller function of displaying organization on directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * </ol>



     * <ol>



     * <li> auser</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>get_all_businesses_approved_in_newsletter</b> (Model Name: users)</li>



     * </ol>



     * <br>



     */



    function manage_organizations($zoneid=0,$userid=0){//calling from new_page



        $data = array();



        $data['zone_id'] = $_REQUEST['zoneid'];



        $data['userid'] = $_REQUEST['userid'];



        $zoneid= $_REQUEST['zoneid'];



        $userid = $_REQUEST['userid'];



        $data['org_details'] = $this->org_model->get_all_deleted_organization($zoneid,$userid);



        $this->load->view('user_org_settings',$data);



    }



// Adding organizations for resident user



    /**



     * This is the controller function of displaying organization on directory page for resident user.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> userid</li>



     * </ol>



     * <ol>



     * <li> zoneid</li>



     * </ol>



     * <ol>



     * <li> orgid</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>adduserorganization</b> (Model Name: organization_model)</li>



     * </ol>



     * <br>



     */



    function add_userorganization($userid=0,$zoneid=0,$orgid=0){//calling from new_page



        $orgid = $_REQUEST['orgid'];



        $userid = $_REQUEST['userid'];



        $zoneid = $_REQUEST['zoneid'];



        $this->org_model->adduserorganization($userid,$zoneid,$orgid);



        echo 1;



    }



    /**



     * This is the controller function of displaying All types of ads on directory page.



     *



     * This function is accessable from the directory page.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * </ol>



     * <ol>



     * <li> adId</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>zone_from_login</b> (Model Name: ads_model)</li>



     * <li><b>business_peekaboo_bidder</b> (Model Name: ads_model)</li>



     * <li><b>business_peekaboo</b> (Model Name: ads_model)</li>



     * </ol>



     * <br>



     */



    /*function peekIcon(){



    $session_zoneid_from_bus = $this->session->userdata('session_zoneid_from_bus');



    $session_zoneid = $this->session->userdata('session_zoneid');



    $session_from_zone = $this->session->userdata('session_login_details');



    $session_normal_user_id = $this->session->userdata('user_id');



    $session_normal_user_in_zone = $this->session->userdata('session_normal_user_in_zone');



    $session_normal_user_in_zone1 = $session_normal_user_in_zone['sesusertype'];



    $data = array();



    $data['peekabooauctions'] = "http://127.0.0.1/peekabooauctions/";



    $adId = $_REQUEST['addid'];



    $zoneId = $_REQUEST['zoneid'];



    if($session_zoneid!=''){



    $zone_from_login = $this->ad->zone_from_login($zoneId);



    echo json_encode($zone_from_login);



    }else if($session_normal_user_in_zone1!=''){



    $bidder_peekaboo = $this->ad->business_peekaboo_bidder($zoneId);



    echo json_encode($bidder_peekaboo);



    }else{



    $business_peekaboo = $this->ad->business_peekaboo($adId,$zoneId);



    echo json_encode($business_peekaboo);



    }



    }



    */



    function peekIcon(){ //var_dump($_REQUEST);exit;



        $data = array();



        $adId = $_REQUEST['addid'];



        $zoneId = $_REQUEST['zoneid'];



        $data['show_popup'] = $this->ad->show_popup($adId,$zoneId);//var_dump($data['show_popup']);exit;



        echo json_encode($data['show_popup']);



    }



    /**



     * Peekaboo Auction details of only particullar business ad respective which has has exists on peekaboo sites.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> zoneid</li>



     * <li> business id</li>



     * <li> other parameters from view page.</li>



     * </ol>



     * After getting all the parameters from the view page, these values passes through the function in related model.



     * <br>



     * <ol>



     * <li><b>popup_content_show</b> (Model Name: ads_model)</li>



     * </ol>



     * <br>



     */



    function popup_content(){



        $data = array();



        $adId =$_REQUEST['addid'];



        $busId = $_REQUEST['bus_id'];



        $zoneId = $_REQUEST['zoneid'];



        $auc_id = $_REQUEST['auc_id'];



        $data['content_show'] = $this->ad->popup_content_show($adId,$zoneId,$busId,$auc_id);



        echo json_encode($data['content_show']);



    }



    function setcookieforblog(){



        $blog_response_arr = array();



        $username = $this->session->userdata('username');



        $busid = $_REQUEST['busid'];



        $zoneid = $_REQUEST['zoneid'];



        $user_type = $_REQUEST['user_type'];



        $user_id = $_REQUEST['user_id'];







        /*$blog_zoneId     = isset($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : 0;



        $blog_businessId = isset($_REQUEST['busid']) ? $_REQUEST['busid'] : 0;







        $_SESSION["blog_zoneid"] = $blog_zoneId;



        $_SESSION["blog_businessid"] = $blog_businessId; 



        $cookie1 = array(



            'name' => 'bblog_zoneId',



            'value' => $blog_zoneId,



            'expire' => time()+86500,



            'domain' => '',



            'path' => '/',



            'prefix' => '',



        );



        set_cookie($cookie1);



        delete_cookie($cookie1);



        $cookie2 = array(



            'name' => 'bblog_businessId',



            'value' => $blog_businessId,



            'expire' => time()+86500,



            'domain' => '',



            'path' => '/',



            'prefix' => '',



        );



        set_cookie($cookie2);



        delete_cookie($cookie2);*/



        if($busid == 0){



            $check_blog_zone_owner = $this->ad->check_blog_zone_owner($user_id,$zoneid, $busid);



        }else{



            $check_blog_business_owner = $this->ad->check_blog_business_owner($user_id,$zoneid, $busid);



        }



        $cookie1 = array(



            'name' => 'blog_businessid',



            'value' => $busid,



            'expire' => time()+86500,



            'domain' => '',



            'path' => '/',



            'prefix' => '',



        );



        set_cookie($cookie1);



        //delete_cookie($cookie);



        $cookie2 = array(



            'name' => 'blog_zoneid',



            'value' => $zoneid,



            'expire' => time()+86500,



            'domain' => '',



            'path' => '/',



            'prefix' => '',



        );



        set_cookie($cookie2);



        $blog_response_arr['response'] = 'Set';



        echo json_encode($blog_response_arr);



       // delete_cookie($cookie);



    }



    /**



     * Pab panel banner forgot password section in zone directory.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> username</li>



     * </ol>



     * <br>



     * Email to get user through their email if this email match on peekaboo sites.



     * <br>



     */



    function forget_password(){



        $username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';//var_dump($username);exit;



        $forget_password_sql = "select * from tbl_member where user_name='".$username."' ";



        $forget_password_query = $this->db->query($forget_password_sql);



        if($forget_password_query->num_rows() > 0){



            $result = $forget_password_query->result_array();//echo "<pre>";var_dump($result);exit;



            $fName = $result['0']['fName'];



            $email = $result['0']['email'];



            $user_name = $result['0']['user_name'];



            $activation_number = $result['0']['activation_number'];



            $user_id = $result['0']['user_id'];



            $message_body= '<body style="background-color:#FFF;font-family:Arial,Helvetica,sans-serif">



<div style="width:960px;margin:0 auto!important">



<div style="background-color:#f2f2f2;border-radius:4px;width:650px;margin:5px auto;padding:15px">



<div style="background-color:#3f3f3f;height:70px"><img src="http://www.savingssites.com/assets/images/logo_white.png" style="margin:10px 202px" alt="logo"/></div>



<div style="clear:both"></div>



<div style="background-color:#FFF;margin-top:10px;margin-bottom:10px;min-height:300px;padding:15px">



<h2 style="text-align:left">Hi'." ".$user_name.',



</h2><h3 style="text-align:left;display:block;color:#666">Here is the login information that you requested:</h3>



<h3><p style="text-align:left;display:block;color:#333">Username: '.$user_name.'</p></h3>



<h3><p style="text-align:left;display:block;color:#333">User Id: '.$user_id.'</p></h3>



<h3><p style="text-align:left;display:block;color:#333">To reset your password, please click here:</p></h3>



<h3><p style="text-align:left;display:block;color:#333"><a target="_blank" href="http://savingssites.com/ads/confirm_peekaboopassword/'.$user_name.'/'.$email.'/'.$activation_number.'">http://www.savingssites.com/ads/confirm_peekaboopassword/'.$user_name.'/'.$email.'/'.$activation_number.'</a></p></h3>



<h3><p style="text-align:left;display:block;color:#333">Best Regards,</p></h3>



<h3><p style="text-align:left;display:block;color:#333">Peek A Boo Auction Team!</p></h3>



</div>



<div style="background-color:#999;height:60px"></div>



</div>



</div>



</body>';



            $fromemail = $this->config->item('adminEmailId');



            $email_subject = 'Forgot Password';



            $this->load->library('email');



            $this->email->clear();



            $this->email->from($fromemail);



            $this->email->subject($email_subject);



            $this->email->message($message_body);



            if($email!=''){



                $this->email->to($email);



                if($this->email->send()){



                    $message = "Email successfully sent ";



                }else{



                    $message = "Email Successfully not sent";



                }



//$to[]=$email;



            }else{



                $message = "Email id not found";



            }



        }else{



            $message = "User not found";



        }



        echo $message;



    }



    /**



     * Pab panel banner forgot username section for resident user in zone directory.



     * <br>



     * Input Parameters:



     * <ol>



     * <li> email</li>



     * </ol>



     * <br>



     * Email to get user through their email if this email match on peekaboo sites.



     * <br>



     */



    function forgot_username(){



        $email = !empty($_REQUEST['email']) ? $_REQUEST['email'] : '';



// Fetching username of a resident user respect to user email.



        $forget_username_sql = "SELECT a.* FROM users a, users_groups b WHERE a.id = b.user_id AND a.email = '".$email."' AND b.group_id = 10";



        $forget_username_query = $this->db->query($forget_username_sql);



        if($forget_username_query->num_rows() > 0){



            $result = $forget_username_query->result_array();



            $fName = $result['0']['first_name'];



            $lName = $result['0']['last_name'];



            $email = $result['0']['email'];



            $user_name = $result['0']['username'];



            $message_body= '<body style="background-color:#FFF;font-family:Arial,Helvetica,sans-serif">



<div style="width:960px;margin:0 auto!important">



<div style="background-color:#f2f2f2;border-radius:4px;width:650px;margin:5px auto;padding:15px">



<div style="background-color:#3f3f3f;height:70px"><img src="http://www.savingssites.com/assets/images/logo_white.png" style="margin:10px 202px" alt="logo"/></div>



<div style="clear:both"></div>



<div style="background-color:#FFF;margin-top:10px;margin-bottom:10px;min-height:300px;padding:15px">



<h2 style="text-align:left">Hi'." ".$fName." ".$lName.',



</h2><h3 style="text-align:left;display:block;color:#666">Here is the login information that you requested:</h3>



<h3><p style="text-align:left;display:block;color:#333">Username: '.$user_name.'</p></h3>



<h3><p style="text-align:left;display:block;color:#333">Best Regards,</p></h3>



<h3><p style="text-align:left;display:block;color:#333">Savingssites Team!</p></h3>



</div>



<div style="background-color:#999;height:60px"></div>



</div>



</div>



</body>';



            $fromemail = $this->config->item('adminEmailId');



            $email_subject = 'Forgot Username';



            $this->load->library('email');



            $this->email->clear();



            $this->email->from($fromemail);



            $this->email->subject($email_subject);



            $this->email->message($message_body);



            if($email!=''){



                $this->email->to($email);



                if($this->email->send()){



                    $message = "Email successfully sent ";



                }else{



                    $message = "Email not sent";



                }



//$to[]=$email;



            }else{



                $message = "Email id not found";



            }



        }else{



            $message = "<span style='color:red'>You are not a resident user</span>";



        }



        echo $message;



    }



    /**



     * Confirm peekaboo password.



     * <br>



     */



    function confirm_peekaboopassword(){



        $a = $_REQUEST['q'];



        $data = array();



        $peekaboo_userdetails = explode("/",$a);



        $data['username'] = $peekaboo_userdetails[2];



        $data['email'] = $peekaboo_userdetails[3];



//$data['activation_number'] = $peekaboo_userdetails[4];



        $this->load->view('peekaboo/forgotpassword',$data);



    }



    /**
     * New password will be stored on peekaboo sites
     * Update query on the forgot password
     */



    function peekaboo_password(){



        $username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';



        $password = !empty($_REQUEST['password']) ? $_REQUEST['password'] : '';



        $confirm_password = !empty($_REQUEST['confirm_password']) ? $_REQUEST['confirm_password'] : '';



        $update_peekaboo_sql = "update tbl_member set password='".sha1($password)."' where user_name='".$username."'";



        $update_peekaboo_query = $this->db->query($update_peekaboo_sql);



    }



    /*
    * Get organization calendar category
    *
    */



    function getselectedcalendarcategory(){ //calling from new_page



        $data = array();



        $data['zone_id'] = (isset($_REQUEST['zoneid'])) ? $_REQUEST['zoneid'] : '' ;



        $data['userid'] = (isset($_REQUEST['userid'])) ? $_REQUEST['userid'] : '' ;



        $data['organization_category'] 	= 	$this->email_notice->getcategoryofcreatedannouncement($data['zone_id']) ;



        if($data['zone_id'] != '' && $data['userid'] != ''){



            $data['calendar_details'] = $this->org_model->get_residentuserselectedorgcategory($data['zone_id'],$data['userid']);



        }else{



            $data['calendar_details'] = array() ;



        }



//print_r($data) ;exit ;



        $this->load->view('organization/org_calendarcategorylist',$data);



    }



    /*



    * Change event calendar selected category



    *



    */



    function changeeventcalendarcategory(){ //calling from new_page



        $data = array();



        $zoneid = (isset($_REQUEST['zoneid'])) ? $_REQUEST['zoneid'] : '' ;



        $userid = (isset($_REQUEST['userid'])) ? $_REQUEST['userid'] : '' ;



        $catid = (isset($_REQUEST['catid'])) ? $_REQUEST['catid'] : '' ;



        if($zoneid != '' && $userid != '' && $catid != ''){



            echo $changecategory = $this->org_model->change_selectedcalendarcategory($zoneid, $userid, $catid);



        }else{



            echo false ;



        }



    }



    /*



    * Get organization calendar category



    *



    */



    function getemailoffercriteriaforresidentuser(){ //calling from new_page



        $data = array();



        $data['zone_id'] = (isset($_REQUEST['zoneid'])) ? $_REQUEST['zoneid'] : '' ;



        $data['userid'] = (isset($_REQUEST['userid'])) ? $_REQUEST['userid'] : '' ;



        //print_r($data); exit;



        if($data['zone_id'] != '' && $data['userid'] != ''){



            $data['email_offers_criteria'] = $this->org_model->getemailoffercriteria(); // get all criteria



            $data['selected_email_offers_criteria'] = $this->org_model->getselectedemailoffercriteria($data['userid'],$data['zone_id']); // selected criteria



          



        }else{



            $data['email_offers_criteria'] = array() ;



            $data['selected_email_offers_criteria'] = array() ;



        }


  // print_r($data);
        $this->load->view('organization/org_emailoffercriteria',$data);



    }



    /*



    * Edit user email offer criteria



    *



    */



    function updateemailoffercriteria(){



        $data = array();



        $userid = (isset($_REQUEST['userid'])) ? $_REQUEST['userid'] : '' ;



        $zoneid = (isset($_REQUEST['zoneid'])) ? $_REQUEST['zoneid'] : '' ;



        $user_age = (isset($_REQUEST['user_age'])) ? $_REQUEST['user_age'] : '' ;



        $user_gender = (isset($_REQUEST['user_gender'])) ? $_REQUEST['user_gender'] : '' ;



        $user_renter = (isset($_REQUEST['user_renter'])) ? $_REQUEST['user_renter'] : '' ;



        $action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : '' ;



        if($userid != ''){



            $updateinfo = $this->org_model->updateemailoffercriteriaofuser($userid, $zoneid, $user_age, $user_gender, $user_renter, $action);



        }else{



            $updateinfo = false ;



        }



        echo $updateinfo ;



    }



    /*
    * Get peekaboo credits of resident user
    *
    */

    function getpeekaboocredits(){



        $data = array();



        $data['zone_id'] = (isset($_REQUEST['zoneid'])) ? $_REQUEST['zoneid'] : '' ;



        $data['userid'] = (isset($_REQUEST['userid'])) ? $_REQUEST['userid'] : '' ;



        if($data['zone_id'] != '' && $data['userid'] != ''){



            $data['peekaboocredits'] = $this->org_model->getpeekaboocreditsofresidentuser($data['userid'], $data['zone_id']);



        }else{



            $data['peekaboocredits'] = array() ;



        }



        $this->load->view('organization/org_peekaboocredits',$data);



    }

    function refer_code_html(){
        $data = array();
        $data['zone_id'] = (isset($_REQUEST['zoneid'])) ? $_REQUEST['zoneid'] : '' ;
        $data['userid'] = (isset($_REQUEST['userid'])) ? $_REQUEST['userid'] : '' ;
        if($data['zone_id'] != '' && $data['userid'] != ''){
            $data['peekaboocredits'] = $this->org_model->getpeekaboocreditsofresidentuser($data['userid'], $data['zone_id']);
        }else{
            $data['peekaboocredits'] = array() ;
        }
        $this->load->view('zone/refer_generate_dashboard',$data);
    }




  /*
    * Get peekaboo autions of resident user
    *
    */

    public function getpeekaboodeals($zoneId){
        $session_session_normal_user_type = '';
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('/', $url);
        if($zoneId){
            $zoneId = $zoneId;
        }else{
            $zoneId = $url[3];
        }
        if ($this->ionAuth->loggedIn()){        
        }else{
            redirect(base_url().'zone/'.$zoneId,'location', 301);
        }
        $header = 'residentloginheader';
        $footer = 'residentfooter';

        $page = 'Old Glory';
        $auser = $this->ionAuth->user()->row();
        $theme_color = $this->SalesZone->changeTheme("all",$zoneId);
        $zone= $this->Zone_model->get_zone($zoneId);
        $theme = (strlen($theme_color->theme_color)!=0)? $theme_color->theme_color :"blue";
        $zone_logo = $this->Banner_model->getZonelogo($zoneId);
        $announcements = $this->Organization_model->get_announcements_by_zone($zoneId,0,10); 
        $zone_logo = $zone_logo['image_name'];
        $zone_details =  $this->SalesZone->get_zone($zoneId);
        $zone_name=$zone_details->seo_zone_name;
        $zone_name=str_replace(' ','-',htmlentities(urldecode($zone_name)));
        $zone_owner = $this->ionAuth->user($zone['sales_rep_id'])->row();
        $user_id = $auser->user_id;
        $email = $auser->email;
        $firstName = $auser->first_name;
        $lastName = $auser->last_name;
        $user_name = $auser->username;
        $referralCode =  $this->SalesZone->get_referral_resident_code($auser->user_id);
        if ($this->CommonController->getSession('session_normal_user_in_zone') !='') {
            $session_normal_user_in_zone_arr=$this->CommonController->getSession('session_normal_user_in_zone');
            $session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype'];
        }
        if ($this->ionAuth->loggedIn()){
            $session_login_details = $this->CommonController->getSession('session_login_details');
            $user_type = $this->CommonController->getSession('session_login_details');
            $user_id = $session_login_details['id'];
        }
        $peekaboodeals = $this->Organization_model->getuserdeals($zoneId,$user_id);
        return view('/zone/claimdeals',array('zoneid' => $zoneId,'zone_id' => $zoneId,'zone_name' => $zone_name,'theme' => $theme,'header' => $header,'footer' =>$footer,'zone_logo' => $zone_logo,'session_session_normal_user_type' => $session_session_normal_user_type,'user_id' =>$user_id,'email' => $email,'firstName' =>$firstName,'lastName' => $lastName,'user_name' => $user_name,'page' => $page,'zone_owner' => $zone_owner,'announcements' => $announcements,'user_type' => $user_type,'referralCode' => $referralCode,'peekaboodeals' => $peekaboodeals));


















        $data = array();
        $data['zone_id'] = (isset($_REQUEST['zoneid'])) ? $_REQUEST['zoneid'] : '' ;
        $data['userid'] = (isset($_REQUEST['userid'])) ? $_REQUEST['userid'] : '' ;
        if($data['zone_id'] != '' && $data['userid'] != ''){
            $data['peekaboodeals'] = $this->org_model->getuserdeals($data['zone_id'],$data['userid']);
        }else{
            $data['peekaboodeals'] = array() ;
        }

        $zone_name = '';



         return view('zone/claimdeals',array('zoneid'=>$zoneid,'zone_name'=> $zone_name));
    }




    /*
    * Show peekaboo credit details
    *
    */



    function showpeekaboocreditdetails(){



        $data = array();



        $userid = (isset($_REQUEST['userid'])) ? $_REQUEST['userid'] : '' ;



        $earnbalance = (isset($_REQUEST['earnbalance'])) ? $_REQUEST['earnbalance'] : '' ;



        if($userid != ''){

            $data['credit_details'] = $this->org_model->showpeekaboocreditdetails($userid, $earnbalance);

        }else{

            $data['credit_details'] = array() ;

        }



        echo json_encode($data['credit_details']) ;


    }



    /**

     * Pekaboo Winner List details value show in SS directory

     *

     */



    function pboo_winner_list(){



        $data = array();



        $zoneid = (isset($_REQUEST['zoneid'])) ? $_REQUEST['zoneid'] : '' ;



        if($zoneid != ''){



            $data['winner_list'] = $this->ad->winner_list($zoneid);



        }



        echo json_encode($data['winner_list']) ;



    }


    public function fetchMyAccountData(){
        $type = isset($_REQUEST['type'])?$_REQUEST['type']:'';
        $zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:'';
        $user_id = isset($_REQUEST['user_id'])?$_REQUEST['user_id']:'';
        $peekaboodeals = $this->Organization_model->getuserdeals($zone_id,$user_id);
        $referdata = $this->get_refer_link();
        $code = $referdata;
        $link = base_url().'/zone/'.$zone_id.'?refer='.$code;
        $html = '';
        $sr = 0;
        if($type == 'userupdate'){
            $user = $this->Users->get_user_details($user_id);
            $phone = str_replace("%20"," ",$user['phone']);
            $firstname = str_replace("%20"," ",$user['first_name']);
            $last_name = str_replace("%20"," ",$user['last_name']);
            $count = count($user['alternateno']);
            $html .= '<input type="hidden" name="zoneid" id="zoneid" value="'.$zone_id.'"/>
                    <div class="row gggg">
                        <div class="col-md-12 offset-md-30">
                            <div class="update_profile_form cus-bg-update">
                                <div class="update_profile_form_inner"> 
                                    <span id="success" style="font-weight:bold; color:#090;display:block; text-align:center; display:none;"></span>
                                    <div class="form-group">
                                        <div class="cus-user-name-update">
                                            <label>Username : </label>
                                            <span class="fleft" style="margin-left: 10px;"><strong>'.$user['username'].' </strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group">  
                                        <span><label style="display:block;">Phone:</label>
                                            <input style="width: 93%;margin-right: 10px;float: left;" type="text" id="cell_phone" count="'.$count.'" texttype="updatemyaccount" class="form-control" value="'.$phone.'" required/>
                                        </span>
                                        <button style="width: 5%;float: left;height:49px;" type="button" class="btn btn-info" id="multiplePhone">+</button>
                                    </div>';
                        foreach($user['alternateno'] as $v){ 
                            $sr++;
                            $html .='<div class="form-group aComment">  
                                        <span> <label>Cell Phone Alternative:</label>
                                            <input style="width: 93%;float: left;margin-right: 10px;" type="text" id="phone_alternate'.$sr.'" name="phone_alternate[]" class="form-control phone_alternate" value="'.$v['phone'].'" required/>
                                        </span>
                                        <button style="width: 5%;float: left;height:49px;" type="button" class="btn btn-danger rcellpalt">X</button>
                                    </div>';
                        }
                            $html .= '<div class="form-group">
                                        <span><label  class="m_top_8i">First Name:</label>
                                            <input type="text" id="fn_pro" class="form-control" value="'.$firstname.'" />
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <span><label class="m_top_8i">Last Name:</label>
                                            <input type="text" id="ln_pro" class="form-control" value="'.$last_name.'"/>
                                        </span>
                                    </div>
                                    <div class="form-group">  
                                        <span><div class="for-r-btn" style="padding:0; margin:0 0px 0 0;">                        
                                                <div class="stop-btn">
                                                    <button class="btn btn-danger profile_update" data-id="'.$user['id'].'">Update</button>
                                                </div>
                                        </div></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                    echo json_encode(array('html' => $html,'count' => $count));
                    die;
        }else if($type == 'claimdeal'){
            $html .= '<input type="hidden" name="zoneid" id="zoneid" value="'.$zone_id.'"/>
            <div class="row gggg">
                <div class="col-md-12 offset-md-30">
                    <div class="update_profile_form cus-bg-update">
                        <div class="update_profile_form_inner"> 
                            <span id="success" style="font-weight:bold; color:#090;display:block; text-align:center; display:none;"></span>
                                <h2>All Claimed Deals</h2>
                                <p>The deals claimed by you are listed below:</p>            
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Purcahsed At</th>
                                            <th>Certificate</th>
                                            <th>Certificate Verify</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    if(count($peekaboodeals) > 0){
                                        foreach($peekaboodeals as $peekaboodeals){
                                        $html .= '<tr id="certificate'.$peekaboodeals['id'].'">
                                        <td>'.$peekaboodeals['page_title'].'</td>
                                        <td>$ '.$peekaboodeals['amount_purchased'].'</td>
                                        <td>'.$peekaboodeals['purchasedAt'].'</td>
                                        <td class="verifylink"> <a href="#" class="clickview" data-productid="'.$peekaboodeals["deal_id"].'" data-porchaseid="'.$peekaboodeals["purchaseid"].'">Click to view</a></td>
                                        <td class="verified">'.$peekaboodeals['certificate_verify'].'</td>
                                        </tr>';
                                        }
                                    }
                            $html .= '</tbody></table></div></div></div></div>';
                    echo json_encode(array('html' => $html,'count' => 0));
                    die;
        }else if($type == 'refergenlink'){
            $html .= '<input type="hidden" name="zoneid" id="zoneid" value="'.$zone_id.'"/>
            <div class="row gggg">
                <div class="col-md-12 offset-md-30">
                    <div class="update_profile_form cus-bg-update">
                        <div class="update_profile_form_inner"> 
                            <div class="main_content_outer"> 
                                <div class="content_container">
                                    <div class="refer_code_note">2 Free Discounted Cash Certificates<br>for Every New Sign-Up You Refer!,Both you the Referrer and your new referred sign-up each get one free one!<br>We will even apply the free ones towards the most expensive cash certs!</div>
                                    <div class="refer_code_note">Your refer Code is:- <strong><span class="refertext">'.$code.'</span></strong></div>
                                    <div class="refer_invite_col">
                                        <div class="bv_referal_left">
                                            <img src="https://i.postimg.cc/tgy1Xb9q/tied-working.png"/>
                                        </div>
                                        <div class="bv_referal_right">
                                            <div class="container_tab_header">Invite Your Friends by Email</div>
                                            <div class="bv_pbg_col"><input type="email"  id="referlinkmail" placeholder="Enter Email Address"/> <button class="btn btn-info" type="button" id="mailsend">Send Mail</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bv_share_link">
                                        <div class="bv_sharelink_left">
                                            <img src="https://i.postimg.cc/Bbk9J2Pr/based-learning.jpg">
                                        </div>
                                        <div class="bv_sharelink_right">
                                            <div class="container_tab_header">Share Your Invite Link</div>
                                            <div class="bv_pbg_col"><input type="text"  id="referlinktext" style="width:300px;" readonly value="'.$link.'"/> 
                                                <div class="bv_referal_btn">
                                                    <button class="btn btn-info" type="button" id="copytoclip">copy</button>
                                                        <a class="btn btn-info" id="fb" href="https://www.facebook.com/sharer.php?u='.$link.'" target="_blank">Share on facebook</a> 
                                                        <a class="btn btn-info" id="twitter" href="http://www.twitter.com/share?url='.$link.'" target="_blank">Share on Twitter</a> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
            echo json_encode(array('html' => $html,'count' => 0));
            die;
        }
    }

    public function get_refer_link(){
        $auser = $this->ionAuth->user()->row();
        $user_id = $auser->id;
        $msg = [];
        if($user_id != ''){
            $data = $this->CommonController->SelectDataMultiWay('users','refer_code_link','column',['username' => $auser->username,'password' => $auser->password]);
            
            if($data == ''){
                $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'; 
                $code =  substr(str_shuffle($str_result), 0, 10);

                $updateData=array("refer_code_link"=>$code);
                $this->CommonController->updateData('users',$updateData,['id'=> $user_id]);
                return $code;
            }else{
                return $data;
            }
        }
    }
}
