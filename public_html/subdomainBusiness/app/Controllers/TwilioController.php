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



    public function addtwilioaccount(){
    	$twiliossid = isset($_REQUEST['twiliossid'])?$_REQUEST['twiliossid']:'';
    	$twilioauthtoken = isset($_REQUEST['twilioauthtoken'])?$_REQUEST['twilioauthtoken']:'';
    	$zone_id = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:'';
    	$twiliono = isset($_REQUEST['twiliono'])?$_REQUEST['twiliono']:'';
        $twilioeditid = isset($_REQUEST['twilioeditid'])?$_REQUEST['twilioeditid']:'';
        $msg = 'Congratulation Zone Owner Activate Twilio Account';
        if($zone_id){
            $salezone_id="SELECT id,sales_rep_id FROM sales_zone WHERE id='".$zone_id."'";
            $sale_zoneid = $this->CommonController->SelectRawquery($salezone_id,'row');
            $sales_repid = json_decode(json_encode($sale_zoneid), TRUE);
            $sales_rep_id=$sales_repid['sales_rep_id'];
            
            $users_phone="SELECT id,phone FROM users WHERE id='".$sales_rep_id."'";
            $Users_phone = $this->CommonController->SelectRawquery($users_phone,'row');
            $user_phone = json_decode(json_encode($Users_phone), TRUE);
            $ownerno=$user_phone['phone'];
        }
        if($twilioeditid > 0){
            $twilioqry="SELECT * FROM twilioZoneAccount WHERE id='".$twilioeditid."'";
            $twilioArr = $this->CommonController->SelectRawquery($twilioqry,'row');
            $editflowid = $twilioArr->twilioflowid;
            $editssid = $twilioArr->twiliossid;
            $editauthtoken = $twilioArr->twilioauthtoken;
            $this->CommonController->deleteData('twilioZoneAccount',['id' => $twilioeditid]);
            $twilio = new Client($editssid, $editauthtoken);
            $twilio->studio->v2->flows($editflowid)
                   ->delete();
            $msg = 'Zone Owner '.$zone_id.' Update Twilio Account';
        }
    	$twilio = new Client($twiliossid, $twilioauthtoken);
        $this->createIVR1($twiliossid,$twilioauthtoken,$zone_id,$twiliono);
		try {
    		$twilio->messages->create(
        		$ownerno,
        		[
            		'from' => $twiliono,
            		'body' => $msg
        		]
    		);
    		// $this->createIVR1($twiliossid,$twilioauthtoken,$zone_id,$twiliono);
		}catch (\Twilio\Exceptions\RestException $e) {
            // die('here1');
			echo json_encode(['msg'=>'Please Insert Correct Credential','type'=>'warning']);
		}
    }

    public function createIVR1($twiliossid,$twilioauthtoken,$zone_id,$twiliono){
        $source_file = '/home/savingssites/public_html/subdomainBusiness/assets/SavingsUpload/twiliosample/audiosample.mp3';
        $destination_path = '/home/savingssites/public_html/assets/SavingsUpload/Twilio/'.$zone_id.'/';
        if(is_dir($destination_path)==false){mkdir($destination_path,0777);}
        copy($source_file, $destination_path .$zone_id.'.mp3');
        $arr = array(
            'twiliossid'=>$twiliossid,
            'twilioauthtoken'=>$twilioauthtoken,
            'twilioflowid'=>'',
            'twiliophoneno'=>$twiliono,
            'zoneid'=>$zone_id,
            'filename'=>$zone_id.'.mp3',
            'status'=>'pending',
        );
        $this->CommonController->InsertData('twilioZoneAccount', $arr);
        $twilio = new Client($twiliossid, $twilioauthtoken);
        $flow = $twilio->studio->v2->flows
            ->create("create ".$zone_id." IVR Business", // friendlyName
                "published", // status
                [
                    "states" => [
                        [
                            "name" => "Trigger",
                            "type" => "trigger",
                            "transitions" => [
                                ["event" => "incomingMessage"],
                                ["event" => "incomingCall"],
                                ["event" => "incomingConversationMessage"],
                                [
                                    "next" => "call_business",
                                    "event" => "incomingRequest"
                                ],
                                ["event" => "incomingParent"],
                            ],
                            "properties" => [
                                "offset" => [
                                    "x" => 122,
                                    "y" => 320
                                ]
                            ]
                        ],
                        [
                            "name"=> "call_business",
                            "type"=> "make-outgoing-call-v2",
                            "transitions"=> [
                                [
                                    "next"=> "audio_play",
                                    "event"=> "answered"
                                ],
                                ["event"=> "busy"],
                                [
                                    "next"=> "rejectdealurl",
                                    "event"=> "noAnswer"
                                ],
                                ["event"=> "failed"]
                            ],
                            "properties"=> [
                                "machine_detection_speech_threshold"=> "2400",
                                "detect_answering_machine"=> false,
                                "send_digits"=> "",
                                "sip_auth_username"=> "",
                                    "offset"=> [
                                        "x"=> 930,
                                        "y"=> 50
                                    ],
                                    "recording_status_callback"=> "",
                                    "sip_auth_password"=> "",
                                    "recording_channels"=> "mono",
                                    "timeout"=> 60,
                                    "machine_detection"=> "Enable",
                                    "trim"=> "do-not-trim",
                                    "record"=> false,
                                    "machine_detection_speech_end_threshold"=> "1200",
                                    "machine_detection_timeout"=> "30",
                                    "from"=> "{{flow.channel.address}}",
                                    "to"=> "{{contact.channel.address}}",
                                    "machine_detection_silence_timeout"=> "5000"
                            ]
                        ],
                        [
                            "name"=> "audio_play",
                            "type"=> "say-play",
                            "transitions"=> [
                                [
                                    "next"=> "business_no",
                                    "event"=> "audioComplete"
                                ]
                            ],
                            "properties"=> [
                                "play"=> "https://savingssites.com/assets/SavingsUpload/Twilio/".$zone_id."/".$zone_id.".mp3",
                                "offset"=> [
                                    "x"=> 520,
                                    "y"=> 270
                                ],
                                "loop"=> 1
                            ]
                        ],
                        [
                            "name"=> "business_no",
                            "type"=> "gather-input-on-call",
                            "transitions"=> [
                                [
                                    "next"=> "phone_no_match",
                                    "event"=> "keypress"
                                ],
                                ["event"=> "speech"],
                                ["event"=> "timeout"]
                            ],
                            "properties"=> [
                                "voice"=> "woman",
                                "number_of_digits"=> 10,
                                "speech_timeout"=> "auto",
                                    "offset"=> [
                                        "x"=> 510,
                                        "y"=> 490
                                    ],
                                    "loop"=> 1,
                                    "finish_on_key"=> "#",
                                    "say"=> "Please Input 10 digits mobile number",
                                    "language"=> "en-US",
                                    "stop_gather"=> true,
                                    "gather_language"=> "en",
                                    "profanity_filter"=> "true",
                                    "timeout"=> 5
                            ]
                        ],
                        [
                            "name"=> "phone_no_match",
                            "type"=> "split-based-on",
                            "transitions"=> [
                                ["event"=> "noMatch"],
                                [
                                    "next"=> "say_play_2",
                                    "event"=> "match",
                                    "conditions"=> [
                                        [
                                            "friendly_name"=> "If value less_than 10",
                                            "arguments"=> ["{{widgets.business_no.Digits}}"],
                                            "type"=> "less_than",
                                            "value"=> "10"
                                        ]
                                    ]
                                ],
                                [
                                    "next"=> "say_play_3",
                                    "event"=> "match",
                                    "conditions"=> [
                                        [
                                            "friendly_name"=> "If value greater_than 10",
                                            "arguments"=> ["{{widgets.business_no.Digits}}"],
                                            "type"=> "greater_than",
                                            "value"=> "10"
                                        ]
                                    ]
                                ],
                                [
                                    "next"=> "say_play_5",
                                    "event"=> "match",
                                    "conditions"=> [
                                        [
                                            "friendly_name"=> "If value greater_than 11",
                                            "arguments"=> ["{{widgets.business_no.Digits}}"],
                                            "type"=> "greater_than",
                                            "value"=> "11"
                                        ]
                                    ]
                                ]
                            ],
                            "properties"=> [
                                "input"=> "{{widgets.business_no.Digits}}",
                                "offset"=> [
                                    "x"=> 340,
                                    "y"=> 710
                                ]
                            ]
                        ],
                        [
                            "name"=> "say_play_2",
                            "type"=> "say-play",
                            "transitions"=> [
                                [
                                    "next"=> "business_no",
                                    "event"=> "audioComplete"
                                ]
                            ],
                            "properties"=> [
                                "offset"=> [
                                    "x"=> 140,
                                    "y"=> 950
                                ],
                                "loop"=> 1,
                                "say"=> "no less than 10"
                            ]
                        ],
                        [
                            "name"=> "say_play_3",
                            "type"=> "say-play",
                            "transitions"=> [
                                [
                                    "next"=> "confirm_phone",
                                    "event"=> "audioComplete"
                                ]
                            ],
                            "properties"=> [
                                "voice"=> "woman",
                                "offset"=> [
                                    "x"=> 520,
                                    "y"=> 950
                                ],
                                "loop"=> 1,
                                "say"=> "<speak><say-as interpret-as=\"digits\"{{widgets.business_no.Digits}}</say-as></speak>",
                                "language"=> "en-US"
                            ]
                        ],
                        [
                            "name"=> "say_play_5",
                            "type"=> "say-play",
                            "transitions"=> [
                                [
                                    "next"=> "business_no",
                                    "event"=> "audioComplete"
                                ]
                            ],
                            "properties"=> [
                                "offset"=> [
                                    "x"=> 900,
                                    "y"=> 950
                                ],
                                "loop"=> 1,
                                "say"=> "jyada hai digits"
                            ]
                        ],
                        [
                            "name"=> "confirm_phone",
                            "type"=> "gather-input-on-call",
                            "transitions"=> [
                                [
                                    "next"=> "phoneinput",
                                    "event"=> "keypress"
                                ],
                                ["event"=> "speech"],
                                ["event"=> "timeout"]
                            ],
                            "properties"=> [
                                "speech_timeout"=> "auto",
                                "offset"=> [
                                    "x"=> 490,
                                    "y"=> 1210
                                ],
                                "loop"=> 1,
                                "finish_on_key"=> "#",
                                "say"=> "press 1 to confirm your number .press 2 to type phone number again",
                                "stop_gather"=> true,
                                "gather_language"=> "en",
                                "profanity_filter"=> "true",
                                "timeout"=> 5
                            ]
                        ],
                        [
                            "name"=> "phoneinput",
                            "type"=> "split-based-on",
                            "transitions"=> [
                                ["event"=> "noMatch"],
                                [
                                    "next"=> "send_PDF_to_Business",
                                    "event"=> "match",
                                    "conditions"=> [
                                        [
                                            "friendly_name"=> "If value equal_to 1",
                                            "arguments"=> ["{{widgets.confirm_phone.Digits}}"],
                                            "type"=> "equal_to",
                                            "value"=> "1"
                                        ]
                                    ]
                                ],
                                [
                                    "next"=> "business_no",
                                    "event"=> "match",
                                    "conditions"=> [
                                        [
                                            "friendly_name"=> "If value equal_to 2",
                                            "arguments"=> ["{{widgets.confirm_phone.Digits}}"],
                                            "type"=> "equal_to",
                                            "value"=> "2"
                                        ]
                                    ]
                                ]
                            ],
                            "properties"=> [
                                "input"=> "{{widgets.confirm_phone.Digits}}",
                                "offset"=> [
                                    "x"=> 150,
                                    "y"=> 1420
                                ]
                            ]
                        ],
                        [
                            "name"=> "send_PDF_to_Business",
                            "type"=> "send-message",
                            "transitions"=> [
                                [
                                    "next"=> "businessownerpresskey",
                                    "event"=> "sent"
                                ],
                                ["event"=> "failed"]
                            ],
                            "properties"=> [
                                "offset"=> [
                                    "x"=> 70,
                                    "y"=> 1640
                                ],
                                "service"=> "{{trigger.message.InstanceSid}}",
                                "channel"=> "{{trigger.message.ChannelSid}}",
                                "from"=> "{{flow.channel.address}}",
                                "to"=> "+91{{widgets.business_no.Digits}}",
                                "body"=> "Congratulation to support non-profit organization. click link to download benefit pdf",
                                "media_url"=> "https://savingssites.com/assets/SavingsUpload/Twilio/".$zone_id."/PDF/".$zone_id.".pdf"
                            ]
                        ],
                        [
                            "name"=> "businessownerpresskey",
                            "type"=> "gather-input-on-call",
                            "transitions"=> [
                                [
                                    "next"=> "buttonpressoncall",
                                    "event"=> "keypress"
                                ],
                                ["event"=> "speech"],
                                ["event"=> "timeout"]
                            ],
                            "properties"=> [
                            "voice"=> "woman",
                            "speech_timeout"=> "auto",
                                "offset"=> [
                                    "x"=> -170,
                                    "y"=> 1850
                                ],
                                "loop"=> 1,
                                "finish_on_key"=> "#",
                                "say"=> "Hello User, Support non profit organization, to approve deal press1, press 2 for reject",
                                "language"=> "en-US",
                                "stop_gather"=> true,
                                "gather_language"=> "en",
                                "profanity_filter"=> "true",
                                "timeout"=> 10
                            ]
                        ],
                        [
                            "name"=> "buttonpressoncall",
                            "type"=> "split-based-on",
                            "transitions"=> [
                                ["event"=> "noMatch"],
                                [
                                    "next"=> "approv_Message_Play",
                                    "event"=> "match",
                                    "conditions"=> [
                                        [
                                            "friendly_name"=> "If value equal_to 1",
                                            "arguments"=> ["{{widgets.businessownerpresskey.Digits}}"],
                                            "type"=> "equal_to",
                                            "value"=> "1"
                                        ]
                                    ]
                                ],
                                [
                                    "next"=> "reject_Message_Play",
                                    "event"=> "match",
                                    "conditions"=> [
                                        [
                                            "friendly_name"=> "If value equal_to 2",
                                            "arguments"=> ["{{widgets.businessownerpresskey.Digits}}"],
                                            "type"=> "equal_to",
                                            "value"=> "2"
                                        ]
                                    ]
                                ]
                            ],
                            "properties"=> [
                                "input"=> "{{widgets.businessownerpresskey.Digits}}",
                                "offset"=> [
                                    "x"=> -510,
                                    "y"=> 2060
                                ]
                            ]
                        ],
                        [
                            "name"=> "approv_Message_Play",
                            "type"=> "say-play",
                            "transitions"=> [
                                [
                                    "next"=> "approvedealurl",
                                    "event"=> "audioComplete"
                                ]
                            ],
                            "properties"=> [
                                "voice"=> "woman",
                                "offset"=> [
                                    "x"=> -600,
                                    "y"=> 2260
                                ],
                                "loop"=> 1,
                                "say"=> "Thank you for Support non profit",
                                "language"=> "en-US"
                            ]
                        ],
                        [
                            "name"=> "reject_Message_Play",
                            "type"=> "say-play",
                            "transitions"=> [
                                [
                                    "next"=> "rejectdealurl",
                                    "event"=> "audioComplete"
                                ]
                            ],
                            "properties"=> [
                                "voice"=> "woman",
                                "offset"=> [
                                    "x"=> -190,
                                    "y"=> 2260
                                ],
                                "loop"=> 1,
                                "say"=> "Thank you for your feedback",
                                "language"=> "en-US"
                            ]
                        ],
                        [
                            "name"=> "approvedealurl",
                            "type"=> "make-http-request",
                            "transitions"=> [
                                ["event"=> "success"],
                                ["event"=> "failed"]
                            ],
                            "properties"=> [
                                "offset"=> [
                                    "x"=> -650,
                                    "y"=> 2480
                                ],
                                "method"=> "POST",
                                "content_type"=> "application/x-www-form-urlencoded;charset=utf-8",
                                "parameters"=> [
                                    [
                                        "value"=> "{{contact.channel.address}}",
                                        "key"=> "phone"
                                    ]
                                ],
                                "url"=> "https://savingssites.com/approvedealoncall"
                            ]
                        ],
                        [
                            "name"=> "rejectdealurl",
                            "type"=> "make-http-request",
                            "transitions"=> [
                                ["event"=> "success"],
                                ["event"=> "failed"]
                            ],
                            "properties"=> [
                                "offset"=> [
                                    "x"=> 220,
                                    "y"=> 2500
                                ],
                                "method"=> "POST",
                                "content_type"=> "application/x-www-form-urlencoded;charset=utf-8",
                                "parameters"=> [
                                    [
                                        "value"=> "{{contact.channel.address}}",
                                        "key"=> "phone"
                                    ]
                                ],
                                "url"=> "https://savingssites.com/rejectdealoncall"
                            ]
                        ]
                    ],
                    "initial_state" => "Trigger",
                    "flags" => ["allow_concurrent_calls" => true],
                    "description" => "free $5 Program",
                ], // definition
                ["commitMessage" => "First draft"]
            );
        $this->CommonController->updateData('twilioZoneAccount',['twilioflowid'=>$flow->sid,'status'=>'active'],['zoneid'=>$zone_id,'twiliophoneno'=>$twiliono]);
        echo json_encode(['msg'=>'Account Inserted Successfully','type'=>'success']);
    }    

    // public function createIVR($twiliossid,$twilioauthtoken,$zone_id,$twiliono){
	// 	$arr = array(
    // 		'twiliossid'=>$twiliossid,
    // 		'twilioauthtoken'=>$twilioauthtoken,
    // 		'twilioflowid'=>'',
    // 		'twiliophoneno'=>$twiliono,
    // 		'zoneid'=>$zone_id,
    // 		'status'=>'pending',
    // 	);
    // 	$this->CommonController->InsertData('twilioZoneAccount', $arr);
		
	// 	$twilio = new Client($twiliossid, $twilioauthtoken);
	// 	$flow = $twilio->studio->v2->flows
    //     	->create("create ".$zone_id." IVR", // friendlyName
    //         	"published", // status
    //             [
    //                 "states" => [
    //                 	[
    //                     	"name" => "Trigger",
    //                         "type" => "trigger",
    //                         "transitions" => [
    //                             ["event" => "incomingMessage"],
    //                             ["event" => "incomingCall"],
    //                             ["event" => "incomingConversationMessage"],
    //                             [
    //                                 "next" => "Call_Business",
    //       							"event" => "incomingRequest"
    //                             ],
    //                             ["event" => "incomingParent"],
    //                         ],
    //                         "properties" => [
    //                             "offset" => [
    //                                 "x" => 122,
    //                                 "y" => 320
    //                             ]
    //                         ]
    //                     ],
    //                     [
    //                         "name"=> "Call_Business",
    //                         "type"=> "make-outgoing-call-v2",
    //                         "transitions"=> [
    //                             [
    //                                 "next"=> "Audio_Play",
    //                                 "event"=> "answered"
    //                             ],
    //                             ["event"=> "busy"],
    //                             ["event"=> "noAnswer"],
    //                             ["event"=> "failed"]
    //                         ],
    //                         "properties"=> [
    //                             "machine_detection_speech_threshold"=> "2400",
    //                             "detect_answering_machine"=> false,
    //                             "send_digits"=> "",
    //                             "sip_auth_username"=> "",
    //                             "offset"=> [
    //                                 "x"=> 50,
    //                                 "y"=> 200
    //                             ],
    //                             "recording_status_callback"=> "",
    //                             "sip_auth_password"=> "",
    //                             "recording_channels"=> "mono",
    //                             "timeout"=> 60,
    //                             "machine_detection"=> "Enable",
    //                             "trim"=> "do-not-trim",
    //                             "record"=> false,
    //                             "machine_detection_speech_end_threshold"=> "1200",
    //                             "machine_detection_timeout"=> "30",
    //                             "from"=> "{{flow.channel.address}}",
    //                             "to"=> "{{contact.channel.address}}",
    //                             "machine_detection_silence_timeout"=> "5000"
    //                         ]
    //                     ],
    //                     [
    //                         "name"=> "Audio_Play",
    //                         "type"=> "say-play",
    //                         "transitions"=> [
    //                             [
    //                                 "next"=> "confirm_business_number",
    //                                 "event"=> "audioComplete"
    //                             ]
    //                         ],
    //                         "properties"=> [
    //                             "play"=> "https://savingssites.com/assets/SavingsUpload/Twilio/".$zone_id."/".$zone_id.".mp3",
    //                             "offset"=> [
    //                                 "x"=> -10,
    //                                 "y"=> 430
    //                             ],
    //                             "loop"=> 1
    //                         ]
    //                     ],
    //                     [
    //                         "name"=> "confirm_business_number",
    //                         "type"=> "gather-input-on-call",
    //                         "transitions"=> [
    //                             [
    //                                 "next"=> "Mobile_Number_Check",
    //                                 "event"=> "keypress"
    //                             ],
    //                             ["event"=> "speech"],
    //                             ["event"=> "timeout"]
    //                         ],
    //                         "properties"=> [
    //                         "voice"=> "woman",
    //                         "speech_timeout"=> "auto",
    //                         "offset"=> [
    //                                 "x"=> -10,
    //                                 "y"=> 670
    //                             ],
    //                             "loop"=> 1,
    //                             "finish_on_key"=> "#",
    //                             "say"=> "Please Input 10 digits mobile number",
    //                             "language"=> "en-US",
    //                             "stop_gather"=> true,
    //                             "gather_language"=> "en",
    //                             "profanity_filter"=> "true",
    //                             "timeout"=> 5
    //                         ]
    //                     ],
    //                     [
    //                         "name"=> "Mobile_Number_Check",
    //                         "type"=> "split-based-on",
    //                         "transitions"=> [
    //                             ["event"=> "noMatch"],
    //                             [
    //                                 "next"=> "send_PDF_to_Business",
    //                                 "event"=> "match",
    //                                 "conditions"=> [
    //                                     [
    //                                         "friendly_name"=> "If value contains 10",
    //                                         "arguments"=> ["{{widgets.confirm_business_number.Digits}}"],
    //                                         "type"=> "contains",
    //                                         "value"=> "10"
    //                                     ]
    //                                 ]
    //                             ],
    //                             [
    //                                 "next"=> "mobilenonotcorrect",
    //                                 "event"=> "match",
    //                                 "conditions"=> [
    //                                     [
    //                                         "friendly_name"=> "If value does_not_contain 10",
    //                                         "arguments"=> ["{{widgets.confirm_business_number.Digits}}"],
    //                                         "type"=> "does_not_contain",
    //                                         "value"=> "10"
    //                                     ]
    //                                 ]
    //                             ]
    //                         ],
    //                         "properties"=> [
    //                             "input"=> "{{widgets.confirm_business_number.Digits}}",
    //                             "offset"=> [
    //                                 "x"=> -30,
    //                                 "y"=> 880
    //                             ]
    //                         ]
    //                     ],
    //                     [
    //                         "name"=> "send_PDF_to_Business",
    //                         "type"=> "send-message",
    //                         "transitions"=> [
    //                             [
    //                                 "next"=> "businessownerpresskey",
    //                                 "event"=> "sent"
    //                             ],
    //                             ["event"=> "failed"]
    //                         ],
    //                         "properties"=> [
    //                             "offset"=> [
    //                                 "x"=> -40,
    //                                 "y"=> 1130
    //                             ],
    //                             "service"=> "{{trigger.message.InstanceSid}}",
    //                             "channel"=> "{{trigger.message.ChannelSid}}",
    //                             "from"=> "{{flow.channel.address}}",
    //                             "to"=> "{{contact.channel.address}}",
    //                             "body"=> "Congratulation to support non-profit organization. click link to download benefit pdf",
    //                             "media_url"=> "https://savingssites.com/assets/SavingsUpload/Twilio/PDF/"$zone_id"/".$zone_id.".pdf"
    //                         ]
    //                     ],
    //                     [
    //                         "name"=> "businessownerpresskey",
    //                         "type"=> "gather-input-on-call",
    //                         "transitions"=> [
    //                             [
    //                                 "next"=> "buttonpressoncall",
    //                                 "event"=> "keypress"
    //                             ],
    //                             ["event"=> "speech"],
    //                             ["event"=> "timeout"]
    //                         ],
    //                         "properties"=> [
    //                             "voice"=> "woman",
    //                             "speech_timeout"=> "auto",
    //                             "offset"=> [
    //                             "x"=> -40,
    //                             "y"=> 1370
    //                         ],
    //                             "loop"=> 1,
    //                             "finish_on_key"=> "#",
    //                             "say"=> "Hello User, Support non profit organization, to approve deal press1, press 2 for reject",
    //                             "language"=> "en-US",
    //                             "stop_gather"=> true,
    //                             "gather_language"=> "en",
    //                             "profanity_filter"=> "true",
    //                             "timeout"=> 5
    //                         ]
    //                     ],
    //                     [
    //                         "name"=> "buttonpressoncall",
    //                         "type"=> "split-based-on",
    //                         "transitions"=> [
    //                             ["event"=> "noMatch"],
    //                             [
    //                                 "next"=> "approv_Message_Play",
    //                                 "event"=> "match",
    //                             "conditions"=> [
    //                                 [
    //                                     "friendly_name"=> "If value equal_to 1",
    //                                     "arguments"=> ["{{widgets.Call_Business.To}}"],
    //                                     "type"=> "equal_to",
    //                                     "value"=> "1"
    //                                 ]
    //                             ]
    //                         ],
    //                         [
    //                             "next"=> "reject_Message_Play",
    //                             "event"=> "match",
    //                             "conditions"=> [
    //                                 [
    //                                     "friendly_name"=> "If value equal_to 2",
    //                                     "arguments"=> ["{{widgets.Call_Business.To}}"],
    //                                     "type"=> "equal_to",
    //                                     "value"=> "2"
    //                                 ]
    //                             ]
    //                         ]
    //                     ],
    //                     "properties"=> [
    //                         "input"=> "{{widgets.Call_Business.To}}",
    //                         "offset"=> [
    //                             "x"=> -50,
    //                             "y"=> 1640
    //                         ]
    //                     ]
    //                 ],
    //                 [
    //                     "name"=> "approv_Message_Play",
    //                     "type"=> "say-play",
    //                     "transitions"=> [
    //                         [
    //                             "next"=> "approvedealurl",
    //                             "event"=> "audioComplete"]
    //                     ],
    //                     "properties"=> [
    //                         "offset"=> [
    //                             "x"=> -130,
    //                             "y"=> 1880
    //                         ],
    //                         "loop"=> 1,
    //                         "say"=> "Thank you for Support non profit"
    //                     ]
    //                 ],
    //                 [
    //                     "name"=> "reject_Message_Play",
    //                     "type"=> "say-play",
    //                     "transitions"=> [
    //                         [
    //                             "next"=> "rejectdealurl",
    //                             "event"=> "audioComplete"]
    //                     ],
    //                     "properties"=> [
    //                         "offset"=> [
    //                             "x"=> 240,
    //                             "y"=> 1890
    //                         ],
    //                         "loop"=> 1,
    //                         "say"=> "Thank you for your feedback"
    //                     ]
    //                 ],
    //                 [
    //                     "name"=> "mobilenonotcorrect",
    //                     "type"=> "say-play",
    //                     "transitions"=> [
    //                         [
    //                             "next"=> "confirm_business_number",
    //                             "event"=> "audioComplete"]
    //                     ],
    //                     "properties"=> [
    //                         "offset"=> [
    //                             "x"=> 550,
    //                             "y"=> 1090
    //                         ],
    //                         "loop"=> 1,
    //                         "say"=> "Input digits less than 10 digits .please input 10 digits mobile number"
    //                     ]
    //                 ],
    //                 [
    //                     "name"=> "approvedealurl",
    //                     "type"=> "make-http-request",
    //                     "transitions"=> [
    //                         ["event"=> "success"],
    //                         ["event"=> "failed"]
    //                     ],
    //                     "properties"=> [
    //                         "offset"=> [
    //                             "x"=> -180,
    //                             "y"=> 2150
    //                         ],
    //                         "method"=> "POST",
    //                         "content_type"=> "application/x-www-form-urlencoded;charset=utf-8",
    //                         "parameters"=> [
    //                             [
    //                                 "value"=> "{{contact.channel.address}}",
    //                                 "key"=> "phone"
    //                             ]
    //                         ],
    //                         "url"=> "https://savingssites.com/approvedealoncall"
    //                     ]
    //                 ],
    //                 [
    //                     "name"=>"rejectdealurl",
    //                     "type"=> "make-http-request",
    //                     "transitions"=> [
    //                         ["event"=> "success"],
    //                         ["event"=> "failed"]
    //                     ],
    //                     "properties"=> [
    //                         "offset"=> [
    //                             "x"=> 210,
    //                             "y"=> 2150
    //                         ],
    //                         "method"=> "POST",
    //                         "content_type"=> "application/x-www-form-urlencoded;charset=utf-8",
    //                         "parameters"=> [
    //                             [
    //                                 "value"=> "{{contact.channel.address}}",
    //                                 "key"=> "phone"
    //                             ]
    //                         ],
    //                         "url"=> "https://savingssites.com/rejectdealoncall"
    //                     ]
    //                 ]
    //                 ],
    //                 "initial_state" => "Trigger",
    //                 "flags" => ["allow_concurrent_calls" => true],
    //                 "description" => "free $5 Program",
    //             ], // definition
    //             ["commitMessage" => "First draft"]
    //         );
  	// 	$this->CommonController->updateData('twilioZoneAccount',['twilioflowid'=>$flow->sid,'status'=>'active'],['zoneid'=>$zone_id,'twiliophoneno'=>$twiliono]);
	// 	echo json_encode(['msg'=>'Account Inserted Successfully','type'=>'success']);
	// }
}