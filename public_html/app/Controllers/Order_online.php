<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');
 class Order_online extends CI_Controller {
    /**
      * @desc constructor function to load required data
    */
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->model("onlinedelivery/Onlinedelivery","delivery");
        $this->load->model("onlinedelivery/Managemenu","managemenu");
        $this->load->model("zone/Zone_model", "get_zone");
        $this->load->database();

    }

    public function fetchCategorySubcategory($zoneid ="",$businessid ="",$limit=0,$value="")
    {
        $data['businessDetails'] = $this->delivery->get_business_by_id($businessid);
        $data['zonedetails']    = $this->get_zone->get_zone($zoneid); 
        $data['category_list'] = $this->delivery->get_category($zoneid,$businessid,6,$value);
        
        $data['category_subcat_list'] = $data['category_list'];
        $data['subcategory_list'] = $this->delivery->get_subcategory($zoneid,$businessid,6);
        foreach($data['category_subcat_list'] as $key => $value){
            $data['category_subcat_list'][$key]['subcategory'] = array();
            foreach($data['subcategory_list'] as $key2 => $value2){
                if($value['id'] === $value2['parent_id']){
array_push($data['category_subcat_list'][$key]['subcategory'],$data['subcategory_list'][$key2]);
                }               
            }
        }
        return $data['category_subcat_list'];
    }

    public function index($zoneid =0,$businessid =0)
    {
    	var_dump($businessid);
        $data['businessDetails'] = $this->delivery->get_business_by_id($businessid);
        var_dump($zoneid);
        $data['zonedetails']    = $this->get_zone->get_zone($zoneid); 
        var_dump($businessid);
        $data['zoneid']=$zoneid;
        $data['businessid']=$businessid;
        $data['category_subcat_list'] = $this->fetchCategorySubcategory($zoneid,$businessid,6,"");
        echo "<pre>";
        print_r($data['category_subcat_list']);
        echo "</pre>";
        $this->load->view('online_delivery/header', $data);
        $this->load->view('online_delivery/orderonline', $data);
        $this->load->view('online_delivery/footer', $data);
    }

    public function callfunction($zoneid ="",$businessid ="")
    {
        $data['businessDetails'] = $this->delivery->get_business_by_id($businessid);
        $data['zonedetails']    = $this->get_zone->get_zone($zoneid); 
        $data['zoneid']=$zoneid;
        $data['businessid']=$businessid;
        $this->load->view('online_delivery/function', $data);
    }

    public function checkout($zoneid ="",$businessid ="")
    { 

            echo "dsfsdfdsfsd";die('sdfsdfsdfsfd'); 
        $data['businessDetails'] = $this->delivery->get_business_by_id($businessid);
        $data['zonedetails']    = $this->get_zone->get_zone($zoneid); 
        if($this->ion_auth->logged_in()){ 
        $auser = $this->ion_auth->user()->row();
        if(!empty($auser)){ 
        $this->session->set_userdata('get_email',$auser->email);
        $data['user_id'] = $auser->user_id;
        $data["email"] = $auser->email; 
        $data["firstName"] = $auser->first_name;
        $data["lastName"] = $auser->last_name;
        # + Cookies set as user_id
        $cookie = array(
        'name'   => 'user_id',
        'email'   => 'email',
        'value'  => $user_id,
        'expire' => time()+86500,
        'domain' => '',
        'path'   => '/',
        'prefix' => '',
        );
        set_cookie($cookie);
        # - Cookies set as user_id
        }
        /*echo "You loged in<br />";
        echo "User id ".$data["user_id"]."<br />";
        echo "Business id ".$businessid."<br />";*/
        }
        else{
        /*echo "You are not logged in<br />";
        echo "Business id ".$businessid."<br />";*/
        }
        $session_type_arr=$this->session->userdata('session_normal_user_in_zone');
        /*echo "<pre>";
        print_r($session_type_arr);
        echo "</pre>";*/
        $data['zoneid']=$zoneid;
        $data['businessid']=$businessid;
        $this->load->view('online_delivery/header', $data);
        $this->load->view('online_delivery/checkout', $data);
        $this->load->view('online_delivery/footer', $data);
    }

    public function placeorder($zoneid ="",$businessid ="")
    {   
/*        echo "<pre>";
        print_r($_REQUEST);
        echo "</pre>";
        /*exit;*/
        if ($_REQUEST['businessid']==''||strlen($_REQUEST['businessid'])==0) {
          redirect('/online-delivery/'.$zoneid, 'refresh');
          exit;
        }
        $data['businessDetails'] = $this->delivery->get_business_by_id($businessid);
        $data['zonedetails']    = $this->get_zone->get_zone($zoneid); 
        $data['zoneid']=$zoneid;
        $data['businessid']=$businessid;
        $data['orderid'] =rand();
        $insertdata = array(
        'order_id'      => $data['orderid'], 
        'first_name'    => $_POST['first_name'],
        'last_name'     => $_POST['last_name'],
        'email'         => $_POST['email'],
        'telephone'     => $_POST['telephone'],
        'address_1'     => $_POST['address']['address_1'],
        'address_2'     => $_POST['address']['address_2'],
        'city'          => $_POST['address']['city'],
        'state'         => $_POST['address']['state'],
        'postcode'      => $_POST['address']['postcode'],
        'comment'       => strlen($_POST['comment'])==0?$_POST['comment']:"empty",
        'price'         => $_POST['price'],
        'user_id'       => strlen($_POST['user_id'])==0?0:$_POST['user_id'],
        'product'       => $_POST['product'],
        'qnty'          => $_POST['qnty'],
        'business_id'   => $data['businessid'],
        'time'          => time()
    );
         $this->delivery->placeorder($insertdata,'online_order');

        if ($_POST['validcertificate']==1&&$_POST['tbl_sales_order_id']!=0){
        $price = $_POST['totalprice'];
        switch ($price) {
        case $price >0 && $price <20:
            $credit=2;
        break;

        case $price >=20 && $price <=30:
            $credit=3;
        break;

        case $price >=30 && $price <=40:
            $credit=4;
        break;

        case $price >=40 && $price <=50:
            $credit=5;
        break;
        case $price >=50 && $price <=60:
            $credit=6;
        break;
        case $price >=60 && $price <=70:
            $credit=7;
        break;

        case $price >=70 && $price <=80:
            $credit=8;
        break;

        case $price >=80 && $price <=90:
            $credit=9;
        break;
        case $price >=90 && $price <=100:
            $credit=10;
        break;
        case $price >=100 && $price <=150:
            $credit=20;
        break;
        case $price >150:
            $credit=30;
        break;
        }
            $this->delivery->getpboocredit($_POST['user_id'],$_POST['tbl_sales_order_id'],$credit,$_POST['order_id']);
        }

      $catname = $this->delivery->catNameByID($_POST['product']);
      $pprice = explode(',', $_POST['price']);
      $qunty =  explode(',', $_POST['qnty']);or
      $oderdetails = '';
      $allTotal = 3;
      foreach($catname as $key => $value){
      $catname[$key]['price'] = $pprice[$key];
      $catname[$key]['qnty'] = $qunty[$key];
      $catname[$key]['total'] = $qunty[$key]*$pprice[$key];
      $allTotal = $allTotal + $catname[$key]['total']; 
      $oderdetails .= '<tr style="border-collapse:collapse;"> 
<td style="padding:5px 10px 5px 0;Margin:0;" width="80%" align="left"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$value['content'].' ('.$catname[$key]['qnty'].')</p> </td> 
<td style="padding:5px 0;Margin:0;" width="20%" align="left"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">$'.$catname[$key]['total'].'</p> </td> 
</tr>'; 
      }



        $send_to = $this->delivery->send_email($zoneid,$businessid);
        
        $from = $_POST['email'];
        $tomail= empty($send_to[0]['contactemail']) ? $send_to[0]['email'] : $send_to[0]['contactemail'];
        $fullname = $_POST['fullname'];
        $email =  $_POST['email'];
        $phone = $_POST['phone'];
        $message_body='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html style="width:100%;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
 <head> 
  <meta charset="UTF-8"> 
  <meta content="width=device-width, initial-scale=1" name="viewport"> 
  <meta name="x-apple-disable-message-reformatting"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta content="telephone=no" name="format-detection"> 
  <title>demo_a5e26864-961e-4018-a772-c87a017df8af</title> 
  <!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]--> 
  <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
  <!--[if !mso]><!-- --> 
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet"> 
  <!--<![endif]--> 
  <style type="text/css">
@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:32px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:32px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:inline-block!important } a.es-button { font-size:16px!important; display:inline-block!important; border-width:15px 30px 15px 30px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
#outlook a {
    padding:0;
}
.ExternalClass {
    width:100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
    line-height:100%;
}
.es-button {
    mso-style-priority:100!important;
    text-decoration:none!important;
}
a[x-apple-data-detectors] {
    color:inherit!important;
    text-decoration:none!important;
    font-size:inherit!important;
    font-family:inherit!important;
    font-weight:inherit!important;
    line-height:inherit!important;
}
.es-desk-hidden {
    display:none;
    float:left;
    overflow:hidden;
    width:0;
    max-height:0;
    line-height:0;
    mso-hide:all;
}
</style> 

  <div class="es-wrapper-color" style="background-color:#EEEEEE;"> 
   <!--[if gte mso 9]>
            <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                <v:fill type="tile" color="#eeeeee"></v:fill>
            </v:background>
        <![endif]--> 
   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;"> 
     <tr style="border-collapse:collapse;"> 
      <td valign="top" style="padding:0;Margin:0;"> 
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
         </tr> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-header-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#044767;" width="600" cellspacing="0" cellpadding="0" bgcolor="#044767" align="center"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="Margin:0;padding-top:35px;padding-bottom:35px;padding-left:35px;padding-right:35px;"> 
               <!--[if mso]><table width="530" cellpadding="0" cellspacing="0"><tr><td width="340" valign="top"><![endif]--> 
               <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td class="es-m-p0r es-m-p20b" width="340" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;"> <h1 style="Margin:0;line-height:36px;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;font-size:36px;font-style:normal;font-weight:bold;color:#FFFFFF;">saving online delivery</h1> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> 
               <!--[if mso]></td><td width="20"></td><td width="170" valign="top"><![endif]--> 
               <!--[if mso]></td></tr></table><![endif]--> </td> 
             </tr> 
           </table> </td> 
         </tr> 
       </table> 
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-left:35px;padding-right:35px;padding-top:40px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="530" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="Margin:0;padding-top:25px;padding-bottom:25px;padding-left:35px;padding-right:35px;"> <a target="_blank" href="https://viewstripo.email/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;font-size:16px;text-decoration:none;color:#ED8E20;"> <img src="https://mchrd.stripocdn.email/content/guids/CABINET_75694a6fc3c4633b3ee8e3c750851c02/images/67611522142640957.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="120"> </a> </td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;padding-bottom:10px;"> <h2 style="Margin:0;line-height:36px;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;font-size:30px;font-style:normal;font-weight:bold;color:#333333;">A new order placed!</h2> </td> 
                     </tr>
                   </table> </td> 
                 </tr> 
               </table> </td> 
             </tr> 
           </table> </td> 
         </tr> 
       </table> 
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:35px;padding-right:35px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="530" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td bgcolor="#eeeeee" align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;"> 
                       <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left"> 
                         <tr style="border-collapse:collapse;"> 
                          <td width="80%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;">Order Confirmation #</h4></td> 
                          <td width="20%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;">'.$data['orderid'].'</h4></td> 
                         </tr> 
                       </table> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> </td> 
             </tr> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-left:35px;padding-right:35px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="530" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;"> 
                       <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left"> 
                         <tr style="border-collapse:collapse;">'.$oderdetails.'
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:5px 10px 5px 0;Margin:0;" width="80%" align="left"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">Delivery Charges</p> </td> 
                          <td style="padding:5px 0;Margin:0;" width="20%" align="left"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">$3.00</p> </td> 
                         </tr>
                       </table> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> </td> 
             </tr> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-left:35px;padding-right:35px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="530" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-top:3px solid #EEEEEE;border-bottom:3px solid #EEEEEE;" width="100%" cellspacing="0" cellpadding="0"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px;"> 
                       <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left"> 
                         <tr style="border-collapse:collapse;"> 
                          <td width="80%" style="padding:0;Margin:0;"> <h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;">TOTAL</h4> </td> 
                          <td width="20%" style="padding:0;Margin:0;"> <h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;">$'.$_POST['totalprice'].'</h4> </td> 
                         </tr> 
                       </table> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> </td> 
             </tr> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="Margin:0;padding-left:35px;padding-right:35px;padding-top:40px;padding-bottom:40px;"> 
               <!--[if mso]><table width="530" cellpadding="0" cellspacing="0"><tr><td width="255" valign="top"><![endif]--> 
               <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td class="es-m-p20b" width="255" align="left" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;padding-bottom:15px;"> <h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;">Delivery Address</h4> </td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;padding-bottom:10px;"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$_POST['address']['address_1'].'</p> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$_POST['address']['address_2'].'</p> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$_POST['address']['city'].', '.$_POST['address']['state'].' '.$_POST['address']['postcode'].'</p> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> 
               <!--[if mso]></td><td width="20"></td><td width="255" valign="top"><![endif]--> 
               <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="255" align="left" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;padding-bottom:15px;"> <h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;">Customer Information<br></h4> </td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$_POST['first_name'].' '.$_POST['last_name'].'</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$_POST['email'].'</p> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$_POST['telephone'].'</p></td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> 
               <!--[if mso]></td></tr></table><![endif]--> </td> 
             </tr> 
           </table> </td> 
         </tr> 
       </table> 
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;" width="600" cellspacing="0" cellpadding="0" align="center"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="560" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;display:none;"></td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> </td> 
             </tr> 
           </table> </td> 
         </tr> 
       </table> </td> 
     </tr> 
   </table>' ;

        $fromemail=$this->config->item('adminEmailId');
        $this->load->library('email');
    
        //$this->email->from($_POST['email'],$fullname);
        $this->email->from($fromemail);
        $this->email->to($tomail);
        //$this->email->cc('krishanu@athenaehosting.com');
        $this->email->subject('New order on savingssites online order');
        $this->email->message($message_body);

        if($this->email->send()){

                  $message_body='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html style="width:100%;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
 <head> 
  <meta charset="UTF-8"> 
  <meta content="width=device-width, initial-scale=1" name="viewport"> 
  <meta name="x-apple-disable-message-reformatting"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta content="telephone=no" name="format-detection"> 
  <title>demo_a5e26864-961e-4018-a772-c87a017df8af</title> 
  <!--[if (mso 16)]>
    <style type="text/css">
    a {text-decoration: none;}
    </style>
    <![endif]--> 
  <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]--> 
  <!--[if !mso]><!-- --> 
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet"> 
  <!--<![endif]--> 
  <style type="text/css">
@media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:32px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:32px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:inline-block!important } a.es-button { font-size:16px!important; display:inline-block!important; border-width:15px 30px 15px 30px!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0px!important } .es-m-p0r { padding-right:0px!important } .es-m-p0l { padding-left:0px!important } .es-m-p0t { padding-top:0px!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } .es-desk-hidden { display:table-row!important; width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } .es-desk-menu-hidden { display:table-cell!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } }
#outlook a {
    padding:0;
}
.ExternalClass {
    width:100%;
}
.ExternalClass,
.ExternalClass p,
.ExternalClass span,
.ExternalClass font,
.ExternalClass td,
.ExternalClass div {
    line-height:100%;
}
.es-button {
    mso-style-priority:100!important;
    text-decoration:none!important;
}
a[x-apple-data-detectors] {
    color:inherit!important;
    text-decoration:none!important;
    font-size:inherit!important;
    font-family:inherit!important;
    font-weight:inherit!important;
    line-height:inherit!important;
}
.es-desk-hidden {
    display:none;
    float:left;
    overflow:hidden;
    width:0;
    max-height:0;
    line-height:0;
    mso-hide:all;
}
</style> 

  <div class="es-wrapper-color" style="background-color:#EEEEEE;"> 
   <!--[if gte mso 9]>
            <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
                <v:fill type="tile" color="#eeeeee"></v:fill>
            </v:background>
        <![endif]--> 
   <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;"> 
     <tr style="border-collapse:collapse;"> 
      <td valign="top" style="padding:0;Margin:0;"> 
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
         </tr> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-header-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#044767;" width="600" cellspacing="0" cellpadding="0" bgcolor="#044767" align="center"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="Margin:0;padding-top:35px;padding-bottom:35px;padding-left:35px;padding-right:35px;"> 
               <!--[if mso]><table width="530" cellpadding="0" cellspacing="0"><tr><td width="340" valign="top"><![endif]--> 
               <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td class="es-m-p0r es-m-p20b" width="340" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td class="es-m-txt-c" align="left" style="padding:0;Margin:0;"> <h1 style="Margin:0;line-height:36px;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;font-size:36px;font-style:normal;font-weight:bold;color:#FFFFFF;">saving online delivery</h1> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> 
               <!--[if mso]></td><td width="20"></td><td width="170" valign="top"><![endif]--> 
               <!--[if mso]></td></tr></table><![endif]--> </td> 
             </tr> 
           </table> </td> 
         </tr> 
       </table> 
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-left:35px;padding-right:35px;padding-top:40px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="530" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="Margin:0;padding-top:25px;padding-bottom:25px;padding-left:35px;padding-right:35px;"> <a target="_blank" href="https://viewstripo.email/" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;font-size:16px;text-decoration:none;color:#ED8E20;"> <img src="https://mchrd.stripocdn.email/content/guids/CABINET_75694a6fc3c4633b3ee8e3c750851c02/images/67611522142640957.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;" width="120"> </a> </td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;padding-bottom:10px;"> <h2 style="Margin:0;line-height:36px;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;font-size:30px;font-style:normal;font-weight:bold;color:#333333;">Thankyou, your oreder has been placed!</h2> </td> 
                     </tr>
                   </table> </td> 
                 </tr> 
               </table> </td> 
             </tr> 
           </table> </td> 
         </tr> 
       </table> 
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:35px;padding-right:35px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="530" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td bgcolor="#eeeeee" align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;"> 
                       <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left"> 
                         <tr style="border-collapse:collapse;"> 
                          <td width="80%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;">Order Confirmation #</h4></td> 
                          <td width="20%" style="padding:0;Margin:0;"><h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;">'.$data['orderid'].'</h4></td> 
                         </tr> 
                       </table> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> </td> 
             </tr> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-left:35px;padding-right:35px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="530" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px;"> 
                       <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left"> 
                         <tr style="border-collapse:collapse;">'.$oderdetails.'
                         <tr style="border-collapse:collapse;"> 
                          <td style="padding:5px 10px 5px 0;Margin:0;" width="80%" align="left"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">Delivery Charges</p> </td> 
                          <td style="padding:5px 0;Margin:0;" width="20%" align="left"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">$3.00</p> </td> 
                         </tr>
                       </table> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> </td> 
             </tr> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-left:35px;padding-right:35px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="530" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-top:3px solid #EEEEEE;border-bottom:3px solid #EEEEEE;" width="100%" cellspacing="0" cellpadding="0"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px;"> 
                       <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px;" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left"> 
                         <tr style="border-collapse:collapse;"> 
                          <td width="80%" style="padding:0;Margin:0;"> <h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;">TOTAL</h4> </td> 
                          <td width="20%" style="padding:0;Margin:0;"> <h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;">$'.$_POST['totalprice'].'</h4> </td> 
                         </tr> 
                       </table> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> </td> 
             </tr> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="Margin:0;padding-left:35px;padding-right:35px;padding-top:40px;padding-bottom:40px;"> 
               <!--[if mso]><table width="530" cellpadding="0" cellspacing="0"><tr><td width="255" valign="top"><![endif]--> 
               <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td class="es-m-p20b" width="255" align="left" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;padding-bottom:15px;"> <h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;">Delivery Address</h4> </td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;padding-bottom:10px;"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$_POST['address']['address_1'].'</p> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$_POST['address']['address_2'].'</p> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$_POST['address']['city'].', '.$_POST['address']['state'].' '.$_POST['address']['postcode'].'</p> </td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> 
               <!--[if mso]></td><td width="20"></td><td width="255" valign="top"><![endif]--> 
               <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="255" align="left" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;padding-bottom:15px;"> <h4 style="Margin:0;line-height:120%;mso-line-height-rule:exactly;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;">Customer Information<br></h4> </td> 
                     </tr> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="left" style="padding:0;Margin:0;"> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$_POST['first_name'].' '.$_POST['last_name'].'</p><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$_POST['email'].'</p> <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:open sans, helvetica neue, helvetica, arial, sans-serif;line-height:24px;color:#333333;">'.$_POST['telephone'].'</p></td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> 
               <!--[if mso]></td></tr></table><![endif]--> </td> 
             </tr> 
           </table> </td> 
         </tr> 
       </table> 
       <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;"> 
         <tr style="border-collapse:collapse;"> 
          <td align="center" style="padding:0;Margin:0;"> 
           <table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;" width="600" cellspacing="0" cellpadding="0" align="center"> 
             <tr style="border-collapse:collapse;"> 
              <td align="left" style="Margin:0;padding-left:20px;padding-right:20px;padding-top:30px;padding-bottom:30px;"> 
               <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                 <tr style="border-collapse:collapse;"> 
                  <td width="560" valign="top" align="center" style="padding:0;Margin:0;"> 
                   <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;"> 
                     <tr style="border-collapse:collapse;"> 
                      <td align="center" style="padding:0;Margin:0;display:none;"></td> 
                     </tr> 
                   </table> </td> 
                 </tr> 
               </table> </td> 
             </tr> 
           </table> </td> 
         </tr> 
       </table> </td> 
     </tr> 
   </table>' ;

        $fromemail=$this->config->item('adminEmailId');
        $this->load->library('email');
    
        //$this->email->from($_POST['email'],$fullname);
        $this->email->from($tomail);
        $this->email->to($_POST['email']);
        //$this->email->cc('krishanu@athenaehosting.com');
        $this->email->subject('New order on savingssites online order');
        $this->email->message($message_body);
        $this->email->send();
        $this->load->view('online_delivery/header', $data);
        $this->load->view('online_delivery/thankyou', $data);
        $this->load->view('online_delivery/footer', $data);
        }
    }

    public function menuitems()
    {

        $data['cat_id']=$_REQUEST['cat_id'];
        $data['zone_id']=$_REQUEST['zone_id'];
        $data['business_id']=$_REQUEST['business_id'];
        $data['fromwhere']=$_REQUEST['fromwhere'];
        $data['menuitem'] = $this->managemenu->get_menu_items($data['zone_id'],$data['business_id'],$data['cat_id'],$data['fromwhere']);

        if(empty($data['menuitem'])){
            echo "No items for this category";
        }else{
        $this->load->view('online_delivery/menu-items', $data);
        }
    }
    
    public function searchCategory($zoneid ="",$businessid ="")
    {
        $data['businessDetails'] = $this->delivery->get_business_by_id($businessid);
        $data['zonedetails']    = $this->get_zone->get_zone($zoneid); 
       $category_subcat_list = $this->fetchCategorySubcategory($zoneid,$businessid,6,$_REQUEST['searchval']);
        foreach ($category_subcat_list as $key => $value) { ?>
        <div class="toggle-content">
        <h5 data-catid="<?=$value['id']?>" class="toggle-title"><?=$value['content']?></h5>
        <?php if (array_key_exists("subcategory",$value)){?>
        <ul class="list-unstyled">
        <li>
        <?php foreach ($value['subcategory'] as $key => $value2) { ?>
        <span class="checkbox-input">
        <input name="subcategory[]" data-subcatid="<?=$value2['id']?>" type="checkbox" class="filter-product" id="<?=$value['content']."-".$key?>"/>
        <label for="<?=$value['content']."-".$key?>"><?=$value2['content']?></label>
        </span>
        <?php } ?>
        </li>
        </ul>
        <? } ?>
        </div>
        <?php }
        /*echo "<pre>";
        print_r($category_subcat_list);
        echo "</pre>";*/

    }
}