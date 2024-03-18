<?php
namespace App\Controllers;
require_once APPPATH . "/Libraries/PHPMailer-master/src/PHPMailer.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/Exception.php";
require_once APPPATH . "/Libraries/PHPMailer-master/src/SMTP.php";
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
#[\AllowDynamicProperties]
class Images extends BaseController{
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
    
    public function index(){
        $zoneid = $theme = '';
        $header = 'homeheader';
        $footer = 'homefooter';
       return view('commonimage',array('zoneid'=>$zoneid,'zone_id'=>$zoneid,'theme'=>$theme,'header'=>$header,'footer'=>$footer));
    }

    public function getimage(){
        $catid = isset($_REQUEST['catid'])?$_REQUEST['catid']:'';
        if($catid == 'all'){
            $sql_get_categories = "SELECT * FROM `multipurposeImage`";
        }else{
            $sql_get_categories = "SELECT * FROM `multipurposeImage` WHERE `category` = '".$catid."' ";
        }
        $ImagesArr = $this->CommonController->SelectRawquery($sql_get_categories);
        echo json_encode($ImagesArr);
        die;
    }

    public function loadCat(){
        $sql1="SELECT * FROM `multiPurFoodCategory`";
        $row = $this->CommonController->SelectRawquery($sql1);
        echo json_encode($row);
        die;
    }
}