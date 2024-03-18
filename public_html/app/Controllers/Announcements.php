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
use App\Models\admin\Announcement_model;
use App\Controllers\CommonController;
use App\Models\admin\Sales_zone;
use App\Models\admin\Category_management_model;
use App\Models\Statistics;
use App\Models\States;
use App\Models\banner\Banner_model;
use App\Models\organization\Organization_model;
use App\Models\Category_new_model;
use PHPMailer\PHPMailer\PHPMailer;
use App\Controllers\CronController;
use PHPMailer\PHPMailer\Exception;
#[\AllowDynamicProperties]
class Announcements extends BaseController{
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
    	$this->CronController = new CronController();
    	$this->Banner_model = new Banner_model();
    	$this->Category_new_model = new Category_new_model();
    	$this->Category_management_model = new Category_management_model();
    	$this->Organization_model = new Organization_model();
    	$this->Announcement_model = new Announcement_model();
    }
	
	function check_photo_upload(){
		$org_id = !empty($_REQUEST['org_id']) ? $_REQUEST['org_id'] : 0 ;
		$cat_id = !empty($_REQUEST['catid']) ? $_REQUEST['catid'] : 0 ;
		$result = $this->org_model->check_photo_upload($org_id,$cat_id);
		echo json_encode($result);
	}
	/* photo uploaded or not checking */
	
	function detail_org(){//echo "<pre>"; var_dump($_REQUEST);exit;
		$org_id=!empty($_REQUEST['org_id']) ? $_REQUEST['org_id'] : 0 ;
		$id=!empty($_REQUEST['id']) ? $_REQUEST['id'] : 0 ;
		$level=!empty($_REQUEST['level']) ? $_REQUEST['level'] : 0 ;
		$zoneid=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0 ;
		$userid=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0 ;
		//$link_path=!empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : '' ;
		$data = array();
		$data['org_id']=$org_id;
		//$data['link_path']=$link_path;
		//$this->load->view('directory/show_ogr_details', $data);
		if($this->session->userdata('session_normal_user_in_zone')!=''){
			$session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype']; 
		}else{
			$session_session_normal_user_type='';
		}
		$data['session_session_normal_user_type']=$session_session_normal_user_type;
		if($data['session_session_normal_user_type'] != 'resident_user'){//var_dump(11);exit;
			$detail_org=$this->org_model->detail_org($org_id,$id,$level);
		}
		else{
			$detail_org=$this->org_model->detail_org_user($org_id,$id,$level,$zoneid,$userid);
		}
		//var_dump($detail_org); exit;
		echo json_encode($detail_org);
		//var_dump($anish); exit; 
	}
	
# + detail_highschool_org
	function detail_highschool_org(){
		$org_id=!empty($_REQUEST['org_id']) ? $_REQUEST['org_id'] : 0 ;
		$id=!empty($_REQUEST['id']) ? $_REQUEST['id'] : 0 ;
		$level=!empty($_REQUEST['level']) ? $_REQUEST['level'] : 0 ;
		$zoneid=!empty($_REQUEST['zone_id']) ? $_REQUEST['zone_id'] : 0 ;
		$userid=!empty($_REQUEST['user_id']) ? $_REQUEST['user_id'] : 0 ;
		//$link_path=!empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : '' ;
		$data = array();
		$data['org_id']=$org_id;
		//$data['link_path']=$link_path;
		//$this->load->view('directory/show_ogr_details', $data);
		if($this->session->userdata('session_normal_user_in_zone')!=''){
			$session_normal_user_in_zone_arr=$this->session->userdata('session_normal_user_in_zone');
			$session_session_normal_user_type=$session_normal_user_in_zone_arr['sesusertype']; 
		}else{
			$session_session_normal_user_type='';
		}
		$data['session_session_normal_user_type']=$session_session_normal_user_type;
		if($data['session_session_normal_user_type'] != 'resident_user'){
			$detail_org=$this->org_model->detail_highschool_org($org_id,$id,$level);
			//$detail_org="statis content";
		}
		else{
			$detail_org=$this->org_model->detail_highschool_org_user($org_id,$id,$level,$zoneid,$userid);
		}
		//var_dump($detail_org); exit;
		echo json_encode($detail_org);
		//var_dump($anish); exit; 
	} 
# - detail_highschool_org
	
	function detail_org_announcement(){
		$org_id=!empty($_REQUEST['org_id']) ? $_REQUEST['org_id'] : 0 ;
		$id=!empty($_REQUEST['id']) ? $_REQUEST['id'] : 0 ; //var_dump($id); exit;
		//$link_path=!empty($_REQUEST['link_path']) ? $_REQUEST['link_path'] : '' ;
		$data = array();
		$data['org_id']=$org_id;
		//$data['link_path']=$link_path;
		//$this->load->view('directory/show_ogr_details', $data);
		$detail_org_announcement=$this->org_model->detail_org_announcement($org_id,$id);
		echo json_encode($detail_org_announcement);
		//var_dump($anish); exit; 
	}

    public function get($id)

    {

        echo(json_encode($this->announcements->get_announcement_by_id($id)));

    }



    public function loadZone($id){

       $data['announcement_list'] = $this->announcements->get_announcements_for_zone($id);

        

        $var = $this->load->view("admin/announcement.table.php",$data, true);

        echo($this->dr->GetDR("Save Successful", "The save was successful", $var, $height = "0"));

   



    }

    public function delete_old()

    {

       



        $id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

       $title = " Failed";

        $message = "There was no id set";

        if(!empty($id) && $id > 0)

        {

            $temp = $this->announcements->get_announcement_by_id($id)->zone_id;

            

            $this->announcements->delete_announcement($id);

            $data['announcement_list'] = $this->announcements->get_announcements_for_zone($temp );

            $var = $this->load->view("admin/announcement.table.php",$data, true);

            $title = " Succeeded";

            $message = "Delete is complete.";

        }

        echo($this->dr->GetDR("Delete " . $title, $message, $var, "0"));

		

		

		

		

    }

	 public function delete()

    {

      /* $title = " Failed";

        $message = "There was no id set";

        if(!empty($id) && $id > 0)

        {

            $temp = $this->announcements->get_announcement_by_id($id)->zone_id;

            

            $this->announcements->delete_announcement($id);

            $data['announcement_list'] = $this->announcements->get_announcements_for_zone($temp );

            $var = $this->load->view("admin/announcement.table.php",$data, true);

            $title = " Succeeded";

            $message = "Delete is complete.";

        }

        echo($this->dr->GetDR("Delete " . $title, $message, $var, "0"));*/

		$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];

		$announcements_category=$_REQUEST['announcements_category'];

		$announcements_type=$_REQUEST['announcements_type'];

		$zoneid=$_REQUEST['zoneid'];

		$this->org_model->delete_announcement($id);

		$data=array();

		$data['announcements_category']=$announcements_category;

		$data['announcements_type']=$announcements_type;

		$data['announcement_list'] = $this->org_model->get_announcements_for_zone($zoneid,$announcements_category,$announcements_type);

		//var_dump($data['announcement_list']);

        //$data['announcement_table'] = $this->load->view("admin/announcement.table_2.php",$data, true);

		if($announcements_category==0){

			$result = $this->load->view("dashboards/zone_parts/announcement_display.php",$data, true);

		}else if($announcements_category!=0){

			$result = $this->load->view("dashboards/zone_parts/announcement_display_by_organization.php",$data, true);

		}

		

		//var_dump($result); 

		echo($this->dr->GetDR("","", $result, "0"));

		

		

    }



    public function save()

    {

        //var_dump($_REQUEST); exit;

		$this->announcements->save_announcement($_REQUEST);

		$charval='';

        $data = array();

		$data['announcements_category']= $_REQUEST['announcements_category'];

		$data['announcements_type']= $_REQUEST['announcements_type'];

		//$data['announcement_list'] = $this->announcements->get_announcements_for_zone($id,$announcements_category,$announcements_type);

		

        $data['announcement_list'] = $this->announcements->get_announcements_for_zone($_REQUEST['zone_id'],$_REQUEST['announcements_category'],$_REQUEST['announcements_type'],$charval);

		$data['countallannouncements']=count($data['announcement_list']);

        //$data['announcement_list'] = $this->announcements->get_announcements_for_organization($_REQUEST['zone_id'],$_REQUEST['organization_id']);

        //$var = $this->load->view("dashboards/zone_parts/organization_announcement_display.php",$data, true);

		if($_REQUEST['announcements_category']==0){

			$result = $this->load->view("dashboards/zone_parts/announcement_display.php",$data, true);

		}else if($_REQUEST['announcements_category']!=0){

			$result = $this->load->view("dashboards/zone_parts/announcement_display_by_organization.php",$data, true);

		}

        echo($this->dr->GetDR("Save Successful", "The save was successful", $result, $height = "0"));

    }
	// Save new category
	public function save_category(){
		$orgid = isset($_REQUEST['org_id'])?$_REQUEST['org_id']:0;
		$category = isset($_REQUEST['category'])?$_REQUEST['category']:'';
		$result = $this->Announcement_model->save_category($orgid,$category);
		echo json_encode($result);
	}
	
	public function getallcategory(){
		$arr = '';
		$org_id = !empty($_REQUEST['id'])?$_REQUEST['id'] : 0 ; 
		$lowerlimit= !empty($_REQUEST['lowerlimit']) ? $_REQUEST['lowerlimit'] : 0;
		$upperlimit= !empty($_REQUEST['upperlimit']) ? $_REQUEST['upperlimit'] : 0; 
		$result = $this->announcements->getall_category($org_id,$_REQUEST['lowerlimit'],$_REQUEST['upperlimit']);
		$count = count($result);
		if($count<1){		// Added  on 26/5/14
			$count = 0;		// Added  on 26/5/14
		}
		$lowerlimit=$lowerlimit+5;				// Added  on 26/5/14
		$limit=$lowerlimit.','.$upperlimit;		// Added  on 26/5/14
		/*$arr .= '<table width="85%" class="pretty"><thead><tr><th>Category Name</th><th>Action </th></tr></thead><tbody><input type="hidden" id="stayhere" value="" >';*/
		if(!empty($result)){
			foreach($result as $k=>$v){
			// + Code is commented becuase organization has no subcatgories at that time according to client 
				/*$arr .= '<tr>
				<td style="text-align: center;">'.$v['id'].'</td>
				<td style="text-align: center;"><a href="javascript:void(0)" id="'.$v['id'].'" cat-name="'.$v['name'].'"
				 onclick="showmoresubcat(this.id);getcatname($(this).attr(\'cat-name\'));" style="color:black;">'.$v['name'].'</a><div class="editcategory'.$v['id'].'" style="display:none">
					<input type="text" id="cat_name'.$v['id'].'" value="'.$v['name'].'" maxlength="30" />
                    <input type="hidden" id="cat_id'.$v['id'].'" value="'.$v['id'].'" />
                    <button id="'.$v['id'].'" onclick="editCategory(this.id);">Update</button>
                    <button id="'.$v['id'].'" onclick="cancelEdit(this.id);">Cancel</button>
                </div>  <td style="text-align: center;"><button onclick="editCategoryDiv(this.id);" id="'.$v['id'].'_'.$v['name'].'">Edit</button>&nbsp;<button id="'.$v['id'].'" onclick="deleteCategory(this.id);">Delete</button></td></tr>';*/ 
			// - Code is commented becuase organization has no subcatgories at that time according to client 
			
			    $arr .= '<tr>
				<td style="text-align: center;">'.$v['id'].'</td>
				<td style="text-align: center;">'.$v['name'].'<div class="editcategory'.$v['id'].'" style="display:none">
					<input type="text" id="cat_name'.$v['id'].'" value="'.$v['name'].'" maxlength="30" />
                    <input type="hidden" id="cat_id'.$v['id'].'" value="'.$v['id'].'" />
                    <button id="'.$v['id'].'" onclick="editCategory(this.id);">Update</button>
                    <button id="'.$v['id'].'" onclick="cancelEdit(this.id);">Cancel</button>
                </div>  <td style="text-align: center;"><button onclick="editCategoryDiv(this.id);" id="'.$v['id'].'_'.$v['name'].'">Edit</button>&nbsp;<button id="'.$v['id'].'" onclick="deleteCategory(this.id);">Delete</button></td></tr>';
			}
		}
		else{
			$arr .= '<tr><td colspan="3"><div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Categories Found</div></td></tr>' ;
			//$arr .= '<tr><td align="center" colspan="2">No Categories Found</td></tr>';
		}
		/*$arr .= '</tbody></table>';*/
		echo($this->dr->GetDR($count, $limit, $arr, "0"));
	}

	public function getallcategory1(){
		$org_id = isset($_REQUEST['org_id'])?$_REQUEST['org_id'] : 0 ;
		$sql = "SELECT * FROM organization_category WHERE orgid=".$org_id." AND parent_id=0 ORDER BY name ASC";
		$categoryArr = $this->CommonController->SelectRawquery($sql);
		echo json_encode($categoryArr);
	}
	// Get More Subcategory // edited 2/4/14
	public function getmoresubcategory(){ 
		$data = array();	
		$arr = '';
		$data['orgid'] = !empty($_REQUEST['orgid']) ? $_REQUEST['orgid'] : 0; 			//Added !empty() check on 29/5/14
		$data['parentid'] = !empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;				//Added !empty() check on 29/5/14
		$data['id'] =!empty($_REQUEST['id']) ? $_REQUEST['id'] :0;						//Added !empty() check on 29/5/14
//var_dump($data['parentid'],$data['id']);exit; both are same
		$lowerlimit = $_REQUEST['lowerlimit'] ;
		$upperlimit = $_REQUEST['upperlimit'] ;
									
		$result = $this->announcements->show_subcategory($data,$lowerlimit,$upperlimit);

		$catname = $this->announcements->subcategoryname($data);

		$count = count($result);
		
		if($count<1){							// Added  on 27/5/14
			$count = 0;							// Added  on 27/5/14
		}
		$lowerlimit=$lowerlimit+5;				// Added  on 27/5/14
		$limit=$lowerlimit.','.$upperlimit;		// Added  on 27/5/14
		
		/*$arr .= '<div align="right"><input type="hidden" id="stayhere" value="'.$data['id'].'"></div><table width="85%" class="pretty"><thead><tr>
		<th style="text-align:center;">Sub-Categories of <a href="javascript:void(0)" id="'.$catname['id'].'" onclick="showmoresubcat(this.id);" >'.$catname['name'].'</a></th><th style="text-align:center;">Action </th></tr></thead><tbody>';*/
		if(!empty($result)){
			foreach($result as $k=>$v){
				/*$arr .= '<tr><td><a href="javascript:void(0)" id="'.$v['id'].'" onclick="showmoresubcat(this.id);" style="color:black;">'.$v['name'].'</a><div class="editcategory'.$v['id'].'" style="display:none">
					<input type="text" id="cat_name'.$v['id'].'" value="'.$v['name'].'" />
                    <input type="hidden" id="cat_id'.$v['id'].'" value="'.$v['id'].'" />
                    <button id="'.$v['id'].'" onclick="editCategory(this.id);">Update</button>
                    <button id="'.$v['id'].'" onclick="cancelEdit(this.id);">Cancel</button>
                </div>  <td><button onclick="editCategoryDiv(this.id);" id="'.$v['id'].'_'.$v['name'].'">Edit</button><button id="'.$v['id'].'" onclick="deleteCategory(this.id);">Delete</button></td></tr>'; */
				$arr .= '<tr><td style="text-align: center;">'.$v['name'].'<div class="editcategory'.$v['id'].'" style="display:none">
					<input type="text" id="cat_name'.$v['id'].'" value="'.$v['name'].'" />
                    <input type="hidden" id="cat_id'.$v['id'].'" value="'.$v['id'].'" />
                    <button id="'.$v['id'].'" onclick="editCategory(this.id);">Update</button>
                    <button id="'.$v['id'].'" onclick="cancelEdit(this.id);">Cancel</button>
                </div>  <td style="text-align: center;"><button onclick="editCategoryDiv(this.id);" id="'.$v['id'].'_'.$v['name'].'">Edit</button>&nbsp;<button id="'.$v['id'].'" onclick="deleteCategory(this.id);">Delete</button></td></tr>'; 
			}	
		}
		else{
			$arr .= '<tr><td colspan="2"><div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Sub-Categories Found</div></td></tr>';
			//$arr .= '<tr><td align="center" colspan="2">No Sub-Categories Found Yet</td></tr>';
		}
		//$arr .= '</tbody></table>';
		echo($this->dr->GetDR($count, $limit, $arr, "0"));
	}
	
	// Edit Category
	public function edit_category(){
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
		$name = isset($_REQUEST['name'])?$_REQUEST['name']:'';
		$result = $this->Announcement_model->edit_category($id, $name);
		echo json_encode($result);
	}
	// Delete Category
	public function delete_category(){
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
		$this->CommonController->deleteData('organization_category',$where = ['id'=>$id]);
		echo json_encode(['msg'=>'Category Deleted Successfully','type'=>'success']);
	}
	// Add Sub-Category
	public function show_allcategory(){ 
		$data = array();
		$arr = array();
		$data['orgid'] = $_REQUEST['id'] ; 
		$result = $this->Announcement_model->getall_category($_REQUEST['id'],0,0);
		echo json_encode($result);
	}
	public function getall_category_zone(){
		$data = array();
		$arr = '';
		$org_id = $_REQUEST['org_id'] ;
		$result = $this->announcements->getall_category($org_id,0,0);		
		echo json_encode($result);
		
	}
	public function show_subcategory(){ 
		$data = array();
		$arr = '';
		$data['org_id'] = $_REQUEST['org_id'] ;
		$data['parentid'] = $_REQUEST['parentid'];
		$result = $this->org_model->show_subcategory($data);
		echo json_encode($result);
		//print_r($result);
		/*if($result != NULL){
			$arr .= 'Sub Categories: <select class="multidiv" id="allsubcatshow_'.$data['parentid'].'"><option value="-1" selected>--Select Sub-Category--</option>';
			foreach($result as $k=>$v){
				$arr .= '<option value="'.$v['id'].'">'.$v['name'].'</option>'; 
			}
			$arr .= '</select><br />';
		}
		else{
			$arr = '';
		}
		echo($this->dr->GetDR("Sub-Category View Successful", $arr, $data['parentid'], "0"));*/
	}
	public function show_subcategory_ajax(){
		$data = array();
		$data['orgid'] = $_REQUEST['orgid'] ;
		$data['parentid'] = $_REQUEST['parentid'];
		$result = $this->announcements->show_subcategory($data);
		echo json_encode($result);
	}
	public function save_subcategory(){
		$data = array();
		$data['orgid'] = $_REQUEST['orgid'] ;
		$data['catname'] = $_REQUEST['catname'] ;
		$data['parentid'] = $_REQUEST['parentid'] ;
		//$data['id'] = $_REQUEST['id'];
		$result = $this->announcements->add_subcategory($data);
		if($result == 1){
			$msg = 1;
		}
		else{
			$msg = -1;
		}
		echo $msg; 
		//echo($this->dr->GetDR("Add Successful", $msg, "", "0"));
	}
	/* User Organization Delete Section Directory page */
	public function userdeleteorganization(){
		$data = array();	
		$data['userid'] = $_REQUEST['user_id'];
		$data['zoneid'] = $_REQUEST['zone_id'];
		$data['orgid'] = $_REQUEST['orgid'];
		$result = $this->announcements->user_deleteorganization($data);
		echo $result;
	}
	/* User category Delete Section Directory page */
	public function userdeletecategory(){
		$data = array();	
		$data['userid'] = $_REQUEST['user_id'];
		$data['zoneid'] = $_REQUEST['zone_id'];
		$data['catid'] = $_REQUEST['catid'];
		$data['orgid'] = $_REQUEST['orgid'];
		$result = $this->announcements->user_deletecategory($data);
		echo $result;
	}
	
	public function save_org() {    
		$this->Announcement_model->save_announcement_org($_REQUEST);
		echo json_encode(['msg'=>'Announcement Saved Successfully','type'=>'success']);
	}

	 public function delete_org(){
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:'';
		$this->Announcement_model->delete_announcement_org($id);
		echo json_encode(['msg'=>'Announcement Deleted Successfully','type'=>'success']);
	}
    
    public function save_broadcast(){
		$data=array();
		$data['announceId'] = isset($_REQUEST['announceId']) ? $_REQUEST['announceId'] : '';
		$data['zoneId'] = isset($_REQUEST['zone_id'])?$_REQUEST['zone_id']:0;
		$data['orgId'] = isset($_REQUEST['organization_id']) ? $_REQUEST['organization_id'] : 0;
		$data['announceTitle'] = isset($_REQUEST['title']) ? $_REQUEST['title'] : '';
		$data['announcement'] = isset($_REQUEST['announcement_text']) ? $_REQUEST['announcement_text'] : '';
		$data['categoryId'] = isset($_REQUEST['category']) ? $_REQUEST['category'] : 0;
		$data['announceDate'] = isset($_REQUEST['offer_date']) ? $_REQUEST['offer_date'] : date();
		$data['announceTime'] = isset($_REQUEST['offer_times']) ? $_REQUEST['offer_times'] : '';
		$data['announced'] = false;
		$save_broadcast=$this->Announcement_model->save_broadcast($data);
		echo json_encode($save_broadcast);
	}
	
	public function delete_broadcast(){
		$id = isset($_REQUEST['brodcastid']) ? $_REQUEST['brodcastid'] : 0 ;
		$is_delete=$this->Announcement_model->delete_broadcast($id);
		echo json_encode(['msg'=>'Announcement Deleted Successfully','type'=>'success']);
	}

	function display_all_broadcasts()
	{
		$data=array();
		$data['zoneId']=!empty($_REQUEST['zoneId']) ? $_REQUEST['zoneId'] : 0;
		$data['orgId']=!empty($_REQUEST['orgId']) ? $_REQUEST['orgId'] : 0;
		$data['display_all_broadcasts']=$this->announcements->display_all_broadcasts($_REQUEST['zoneId'],$data['orgId'],FALSE); 
		$result = $this->load->view('emailnotice/display_all_broadcasts', $data, true);
		echo($this->dr->GetDR("","", $result, "0"));
	}

	//++++++++++++++++++++++++++++++++++++++++++++Voice Broadcast Ends++++++++++++++++++++++++++++++++++++++++++++//

	###

	/*function SaveOrganization(){

		$this->announcements->save_announcement($_REQUEST);

		$data = array();

		$data['announcement_list'] = $this->announcements->get_announcements_for_zone($_REQUEST['zone_id']    );

		$var = $this->load->view("admin/announcement.table.php",$data, true);

        echo($this->dr->GetDR("Save Successful", "The save was successful", $var, $height = "0"));

	}*/

	###

    function index()

    {

        if (!$this->ion_auth->logged_in())

        {

            //redirect them to the login page
			redirect(base_url(), 'refresh');
            //redirect('auth/login', 'refresh');

        }

        elseif (!$this->ion_auth->in_group(array("Tier II", "Tier I" )))

        {

            redirect($this->config->item('base_url'), 'refresh');

        }

        

         if($this->ion_auth->in_group("Tier I"))

        {

            $tiers = "Tier I";

        }

            else if($this->ion_auth->in_group("Tier II"))

            {

                $tiers = "Tier II";

            }

            else

            {

                $tiers = "Tier III";

            }

        $data = array();

        $data['tier'] = $tiers;

        $data['business_list'] = $this->business->get_all_businesses();

        

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/announcement.inc.js");

        

        $data['sales_zone_list'] = $this->zone->get_zones_for_user($this->ion_auth->user()->row()->id);

        $data["scripts"] = $scripts;

        $data["firstName"] = $this->ion_auth->user()->row()->first_name;

        $data["page_name"] = "announcements";

        if(!empty($data['sales_zone_list']))

        {

            $zid = 0;

            foreach($data['sales_zone_list'] as $zn)

            {

                $zid = empty($zid) ? $zn['id'] : $zid;

            }

            $data['announcement_list'] = $this->announcements->get_announcements_for_zone($zid);

        }

        else

        {

            $data['announcement_list'] = array();

        }

        $data['zid'] = $zid;

        $this->load->view("admin/header", $data);

        $this->load->view("admin/admin_buttons", $data);

        $this->load->view("admin/announcements.inc.php", $data);

        $this->load->view("admin/announcement.table.php",$data);

        $this->load->view("admin/footer");

        

    }
	public function sendtextorg(){ 
    	isset($_REQUEST['anId']) ? $anId = $_REQUEST['anId'] :$adId='';
		isset($_REQUEST['emailAddress']) ? $emailAddress = $_REQUEST['emailAddress'] :$emailAddress='';
		isset($_REQUEST['text']) ? $text = $_REQUEST['text'] :$text='';
		$arr = explode(' ',trim($text));
		$firstname = $arr[0];
    	if(!empty($anId) && $anId > 0){
			$sql = "SELECT a.name,b.textme FROM organization a,organization_announcement b WHERE a.id = b.orgid AND b.id = ".$anId ;
            $query = $this->db->query($sql);
            $result = $query->row();
			if($result->textme==''){
				$_a='<p align="center" class="MsoNormal" style="text-align: center;">
	<b><span style="font-size: 18.0pt; color: #1F497D;">We don\'t have any message(s) presently. <br />
	</span>	
	</b></p>';
			}else{
				$_a=$result->textme;
			}
			$an_text=urldecode(stripslashes($_a));  
			// email sent
			$fromemail=$this->config->item('adminEmailId');
			$email_subject=stripslashes($result->name) ." Announcement ";
			$message_body="Hello ".$firstname.",<br />										
				".$an_text."<br/>
				<br /><br />
				savingssites.com</h3>" ;
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
            echo($this->dr->GetDR("Acknowledgement", $message, "", "0"));
        }
    }
	# + Live auction view simultaneously 
	function live_auction_view(){
		
		$data['aucid'] = !empty($_REQUEST['aucid']) ? (array)json_decode($_REQUEST['aucid']) : ''; //var_dump($data['aucid']);exit;
		$data['orgid'] = !empty($_REQUEST['orgid']) ? $_REQUEST['orgid'] : ''; 
		$data['zoneid'] = !empty($_REQUEST['zoneid']) ? $_REQUEST['zoneid'] : ''; 
		$orgid = $data['orgid']; 
        $val_auc = '';
		if(isset($data['aucid']) && !empty($data['aucid'])){ 
			foreach($data['aucid'] as $key => $val) {
				if ((int)$key == $orgid) {
					 $val_auc = $val;
					 break;
				}
			}
		}
		$all_aucval = explode(',',$val_auc);		
		$arr_auc = array();
		foreach($all_aucval as $val1){
			$arr_auc[] = $val1;
		}
		$this->db->select('c.user_name,c.company_name, e.product_name, d.*' );
		$this->db->from('organization a');
		$this->db->join('users b','b.id=a.userid');
		$this->db->join('tbl_member c', 'c.user_name=b.username');
		$this->db->join('tbl_auction d', 'c.user_id=d.user_id');
		$this->db->join('tbl_inventory_products e', 'd.product_id=e.product_id');
		$this->db->where('a.id',$orgid);
		$this->db->where_in('d.auc_id', $arr_auc);
		$this->db->group_by('d.auc_id');
		$query=$this->db->get();
		$result=$query->result_array();
		
		// + Coundown Organigation Auction  
		 foreach($result as $key=>$val){
				$startdate = strtotime('now');
				$stopdate = strtotime($val['end_date']);
				$diff = $stopdate - $startdate; //<-Time of countdown in seconds.  ie. 3600 = 1 hr. or 86400 = 1 day.
				$days = floor($diff / 86400);
				$diff = $diff % 86400;
				$hours = floor($diff / 3600);
				$diff = $diff % 3600;
				$minutes = floor($diff / 60);
				$diff = $diff % 60;
				$seconds = $diff;
				$arr = array('days'=>$days,'hours'=>$hours,'minutes'=>$minutes,'seconds'=>$seconds) ;
				$result[$key] = array_merge($val,$arr) ;
			 }	
		// - Coundown Organigation Auction  	 	
		echo json_encode($result);
	}
}

