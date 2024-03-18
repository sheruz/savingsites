<?php
namespace App\Controllers;
require_once APPPATH . "/Libraries/PHPMailer-master/src/PHPMailer.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/Exception.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/SMTP.php";
require_once FCPATH . "vendor/autoload.php";
require './twilio-php-main/src/Twilio/autoload.php';
require_once FCPATH . 'dompdf/autoload.inc.php';
use App\Libraries\IonAuth;
use App\Libraries\PHPMailer_Lib;
use Config\MyConfig;
use App\Models\zone\Zone_model;
use App\Models\admin\Business;
use App\Models\admin\Ads_model;
use App\Controllers\CommonController;
use App\Controllers\CronController;
use App\Models\admin\Sales_zone;
use App\Models\admin\Category_management_model;
use App\Models\Statistics;
use App\Models\States;
use App\Models\banner\Banner_model;
use App\Models\Category_new_model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;
use Dompdf\Dompdf;
#[\AllowDynamicProperties]
class TwilioController extends BaseController{
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
    }	

    public function makemessage(){
    	$client = new Client($this->myconfig->twilioSSID, $this->myconfig->twilioAuthToken);
    	$tonumber = '+919888198501';
    	$textmessage = 'test';
		$client->messages->create($tonumber,  
		    [
		        'from' => $this->myconfig->twilioNumber,
		        'body' => $textmessage
		    ] 
		);
		echo "Message Send Successfully";
    }
	
	public function makecalls(){
    	$client = new Client('AC77fd66e881125d73a5d9fcaee31d30c1', 'e8d3ad9028639084c675f84d5a394015');
    	$tonumber = '+919888198501';
    	$text = 'Ahoy, World!';
		$call = $client->calls->create($tonumber,'+15856288770',
        	["twiml" => "<Response><Say>".$text."</Say></Response>"]
       	);
       	echo "Call Starting";
    }
	
	public function IVR(){
		header("Access-Control-Allow-Origin: *");
		$tonumber = '+919888198501';
		$fromnumber = $this->myconfig->twilioNumber;
		$url = 'https://studio.twilio.com/v2/Flows/FWe9a5b934498eb893be603ba391bb2a2d/Executions';
		$curl = curl_init();
		$public_key = $this->myconfig->twilioSSID;
		$private_key = $this->myconfig->twilioAuthToken;
		
		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => "To=".$tonumber."&From=".$fromnumber."",
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/x-www-form-urlencoded",
				"Authorization: Basic ".base64_encode($public_key.":".$private_key)
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		echo $response;
	}

    public function approvedealoncall(){
    	$phoneno = isset($_REQUEST['phone'])?$_REQUEST['phone']:'+919888198501';
    	// $this->CommonController->InsertData('testdealphone', ['phone'=>$phoneno]);
    	$phone = substr($phoneno, -10);
    	$sql = 'select * from users where username='.$phone.'';
    	$r = $this->CommonController->SelectRawquery($sql,'row');
    	$sqlbus = 'select * from business where business_owner_id='.$r->id.'';
    	$rbus = $this->CommonController->SelectRawquery($sqlbus,'row');
    	$this->CommonController->updateData('business_deal_approval',array('via'=>'Phone Call','status'=>'A','updated_at'=>date('Y-m-d'),'click'=>1),['businessId'=>$rbus->id]);
 		echo json_encode(['msg'=>'Record Updated Successfully','type'=>'success','status' =>200]);
    }

    public function generatePDF(){
    	$phoneno = '+919888198501';//isset($_REQUEST['phone'])?$_REQUEST['phone']:'';

    	$phone = substr($phoneno, -10);
		$joinArr[] = ['table' => 'tbl_member as b','link' => 'a.username = b.user_name','type' => 'left'];
		$user = $this->CommonController->SelectJoinMulti('users as a', $joinArr,['a.username'=>$phone],[],[],'a.*,b.*','','','',[],'row','');
		$sqlprefer = 'select * from business where business_owner_id='.$user->id.'';
    	$rprefer = $this->CommonController->SelectRawquery($sqlprefer,'row');
		$businessId  = $rprefer->id;
		$businessname = $rprefer->name;
		$link = "<a href='https://www.foodordersavings.com'>www.foodordersavings.com</a>";
		$html = '<div>I’m your customer '.$user->first_name.' '.$user->last_name.' Please help the nonprofits raise money.</div>'; 

 		$html .= '<div>Dear '.$businessname.'<br> No Cost!!! I want you to take part in a new Community project.<br> It’s a combination Town Information Business Directory. <br>

 			Home Site: <a href="'.base_url().'/zone/'.$user->Zone_ID.'">'.base_url().'/zone/'.$user->Zone_ID.'</a><br> 
 			Deals Site <a href="'.base_url().'/deals/'.$user->Zone_ID.'">'.base_url().'/deals/'.$user->Zone_ID.'</a><br>
 			Your Site <a href="'.base_url().'/business/businessdetail/'.$businessId.'/'.$user->Zone_ID.'">'.base_url().'/business/businessdetail/'.$businessId.'/'.$user->Zone_ID.'</a><br>

 			Free promotion of your deals by municipality, nonprofits, and directory publisher. <br>Helps many local nonprofits raise funds and helps the municipality. <br>Free referred orders powered by Amazon. See '.$link.'<br>

 			All the restaurants are already listed with a suggested deal, which you can change. <br>They are only asking you to approve a limited number of deals to help the local nonprofits.

 			Opted-in emails from over "90%" of all homes and businesses have already been collected. Massive promotion of your business will soon be starting.<br>

 			You are only going to get emailed requests to participate from only 100 residents. Without the 100 cap you would get a massive number of emails! Huge Exposure! No Marketing Cost!<br>

 			See the many restaurants <a href="'.base_url().'/zone/'.$user->Zone_ID.'">'.base_url().'/zone/'.$user->Zone_ID.'</a>" and their suggested deal is already there waiting for your approval before official launch. The number of deals is substantially limited.<br>

 			The publisher and nonprofits are also giving an additional $5 out of their fee to incentivize residents to try different restaurants. So, you’re not just giving a discount to existing customers.<br>
			
			How It Works: Your business has no money out of pocket and no risk!<br>
			
			Many local nonprofits are emailing their members and telling nonprofit members to pay the Directory publisher a "donation claiming fee" to get access to your discounted cash certificate.<br>
			
			The Directory publisher and the nonprofits share that donation claiming fee!<br>
			
			Your business is presented the cash certificate and a simple button on the phone records and verifies one time use. All the data shows up in your admin dashboard.<br>
			
			Your paid directly by customers. A detailed tracking system gives you access to all customers contact data.<br>
			
			Unlimited Free Emails! No time commitment! Mobile responsive website! You can add images, upload a menu, etc. Use hundreds social media networks!<br>
			
			Your business has always helped nonprofits with outright donations. But now with this fundraiser you have no money out of pocket! Everyone Benefits! Just email the directory publisher and say your business would be happy to help the local nonprofits by donating a limited number of deals.<br>

			Publisher Name: '.$user->first_name.' '.$user->last_name.'<br>
			Publisher Email: '.$user->email.'<br>
			
			Thank you for supporting the local nonprofits!<br>
			'.$user->first_name.' '.$user->last_name.'<br>'.$user->post_code.'</div>';

			$dompdf = new Dompdf();
			$dompdf->load_html($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->render();
			$output = $dompdf->output();
			// $dompdf->stream('avc.pdf', array('Attachment' => 1));
			$fromemail="donotreply@hgd.deals";
			$to = 'salmannexusfleck@gmail.com';
			
		$mail_aws = $this->PHPMailer;
		$mail_aws->isSMTP();
		$mail_aws->setFrom('donotreply@hgd.deals', 'SavingsSites');
		$mail_aws->SMTPOptions = array(
			'ssl' => array(
			    'verify_peer' => false,
			    'verify_peer_name' => false,
			   	'allow_self_signed' => true
			)
		);
		$mail_aws->Username   = 'donotreply@hgd.deals';
		$mail_aws->Password   = 'romilisalsothebest@123';
		$mail_aws->Host       = 'smtp.office365.com';
		$mail_aws->Port       = 587;
		$mail_aws->SMTPAuth   = true;
		$mail_aws->SMTPSecure = 'tls';
		$mail_aws->addAddress($to);
		$mail_aws->msgHTML(true);
		$mail_aws->Subject    = 'I’m your customer '.$user->first_name.' '.$user->last_name.' Please help the nonprofits raise money.';
		$mail_aws->Body       =  'Thank you for support non profit, PLease find attachment below program benefits';
		$mail_aws->CharSet="UTF-8";
		if($mail_aws->Send()){
			return 1;
		}else{
			return 0;
		}
		die;
	}

	public function checktwilioaccount(){
		echo "<pre>";print_r($_REQUEST);die("SDcsdcsdcsdc");
    	$this->CommonController->InsertData('testdealphone', ['phone'=> $_REQUEST['phone']]);
    	$this->CommonController->InsertData('testdealphone', ['phone'=> $_REQUEST['flowsid']]);
    	$this->CommonController->InsertData('testdealphone', ['phone'=> $_REQUEST['flowphone']]);
    }

	public function rejectdealoncall(){
    	$phoneno = isset($_REQUEST['phone'])?$_REQUEST['phone']:'';

    	$phone = substr($phoneno, -10);
    	$sql = 'select * from users where username='.$phone.'';
    	$r = $this->CommonController->SelectRawquery($sql,'row');

    	$sqlbus = 'select * from business where business_owner_id='.$r->id.'';
    	$rbus = $this->CommonController->SelectRawquery($sqlbus,'row');

    	$sqlprefer = 'select * from ads_setting_preferences where businessid='.$rbus->id.'';
    	$rprefer = $this->CommonController->SelectRawquery($sqlprefer,'row');
    	$existsqry = "select * from business_deal_approval where businessId=".$rbus->id;
 		$exists = $this->CommonController->SelectRawquery($existsqry, 'row');
 		if($exists != ''){
 			$click = isset($exists->click)?$exists->click:0;
 			if($click == 0){
				$this->CommonController->updateData('business_deal_approval',array('via'=>'Phone Call','status'=>'N','updated_at'=>date('Y-m-d'),'click'=>1),['businessId'=>$rbus->id]);
 			}
 		}
    	// $arr = [
    	// 	'userId'=> $r->id,
    	// 	'userfname'=> $r->first_name,
    	// 	'userlname'=> $r->last_name,
    	// 	'businessId'=> $rbus->id,
    	// 	'businessname'=> $rbus->name,
    	// 	'zoneId'=> $rprefer->settingszoneid,
    	// 	'via'=> 'Phone Call',
    	// 	'status'=> 'A'
    	// ];
    	// $this->CommonController->InsertData('business_deal_approval', $arr);
    	echo json_encode(['msg'=>'Record Updated Successfully','type'=>'success','status' =>200]);
    }

    
}