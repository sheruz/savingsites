<?php
class Claimzips extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('time_helper');
        $this->load->model("Dialog_result", "dr");
        $this->load->model("admin/Ads_model", "ad");
    
        $this->load->model("admin/Category_model", "category");
        $this->load->model("Zips");
        $this->load->model("admin/Users", "users");
        $this->load->model("admin/Business_type_model", "business_type");
        $this->load->model("admin/Sales_rep", "sales_reps");
        $this->load->model("admin/Business", "business");
        $this->load->model("admin/Sales_zone", "zone");
        $this->load->config('security', TRUE);
        $this->load->database();

        $this->tierI = $this->config->item('Tier_I');
        $this->tierII = $this->config->item('Tier_II');
        $this->tierIII = $this->config->item('Tier_III');

    }

    function index()
    {
        $data = array();

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/claimzips/claimzips.js");
        
        $data['scripts'] = $scripts;
        $data['title'] = "Welcome to Your Local Savings Sites; I-Coupons";   
        $data["admin"] = "";
        $data["referred" ] = "claimzips/claimedzips";
        if ($this->ion_auth->logged_in())
        {
            $data["firstName"] = $this->ion_auth->user()->row()->first_name;
            $data["full_name"] = $data['firstName'] . " " . $this->ion_auth->user()->row()->last_name;
            $data["admin"] = $this->ion_auth->in_group(array( "Tier I")) ? "yes" : "";
        }
        $this->load->view("claimzips/header", $data);
        $this->load->view("claimzips/buttons", $data);
        $this->load->view("claimzips/main", $data);
    
    }

    function approveuser()
    {
        //var_dump(1); exit;
		$userid = $this->input->post('userid'); //var_dump($userid); exit;
        $cmd = $this->input->post('comm');
        $zips = $this->input->post('zips');
        $approved = ($cmd === 'reject')?  0 : 1;
        if(!is_array($zips))
        {
            $zips = array($zips);
        }

        $data = array();

        foreach($zips as $zip)
        {
            if(empty($approved))
            {
                $this->db->where('zip', $zip);
                $this->db->delete('tblClaimedZips');
            }
            else
            {
                //update
            
                $data = array( 'approved' => $approved);
                $this->db->where('zip', $zip);
                $this->db->update('tblClaimedZips', $data);
            }
            
        }
        if(empty($approved)){
            foreach($zips as $zip)
            {
                $this->db->delete('tblClaimedZips', array('zip' => $zip)); 
            }
        }
        $zipData = array();
        $zipData['checkbox'] = "Approve";
        $zipData['claim_status'] = 0;
        $zipData['approve_status'] = "";
        $zips = $this->zips->get_full_zip_list(array(), $userid, true);
        $outzip = array();
        foreach($zips as $zip){
             $zip->available = 1;
             $outzip[] = $zip;
        }
        $zipData['zips'] = $outzip;
		
		$sql="Select email,first_name,last_name from users where id=".$userid;
		$query=$this->db->query($sql);
		$result=$query->result_array();
		if(!empty($result)){
			$u_email=$result[0]['email'];
			$u_name=$result[0]['first_name']." ".$result[0]['last_name'];
		}
		
		$path = base_url();
		$link = base_url()."welcome/zone_registration_step_2/".$userid;
		
		$message="<div style='border:1px solid #900; padding:5px;'>Dear ".$u_name.",<br /><br />
				Thank you for registering on SavingsSites. Your zip codes have been approved by the admin. To learn more about SavingsSites and it's benefits, please click <a href='".$path."'>HERE</a><br/><br/>										
				
				To complete your registration, simple click the following link<br> <a href='".$link."'>Continue Signup</a> .<br/><br/>
				If the link does not work for you, then copy/paste the following link in your browser address bar:<br/><br/>".$link."<br/><br/>
									
				You can login into your account and change this information at your convenience.<br /><br />
				We are constantly trying to improve the application and will notify you of future updates as and when they are available. If you have any queries in the meantime then please email us at <a href='mailto:support@savingssites.com'>support@savingssites.com</a> and we will get back to you promptly.<br /><br />
				Best Regards,<br />
				Savings Sites Support" ;
		$fromemail=$this->config->item('adminEmailId');
		$this->load->library('email');
		$template_subject="Savings Sites Zip Approval";
		$this->email->clear();
		$this->email->from($fromemail);
		$this->email->subject($template_subject);
		$this->email->message($message);
		if($u_email!='')
		{
			$this->email->to($u_email);
			$this->email->send();
			$to[]=$u_email;
		}
		
		
        $this->load->view("claimzips/zipdata", $zipData);
        
    }
    function about()
    {
       $data = array();

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/claimzips/claimzips.js");
        
        $data['scripts'] = $scripts;
        $data['title'] = "Savings Sites: About Us";   
        $data["admin"] = "";
        $data["referred" ] = "claimzips/claimedzips";
        if ($this->ion_auth->logged_in())
        {
            $data["firstName"] = $this->ion_auth->user()->row()->first_name;
            $data["full_name"] = $data['firstName'] . " " . $this->ion_auth->user()->row()->last_name;
            $data["admin"] = $this->ion_auth->in_group(array( "Tier I")) ? "yes" : "";
        }
        $this->load->view("claimzips/header", $data);
        $this->load->view("claimzips/buttons", $data);
        $this->load->view("claimzips/about", $data);
    
    }

    function contact(){
       $data = array();

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/claimzips/claimzips.js");
        
        $data['scripts'] = $scripts;
        $data['title'] = "Savings Sites: Contact Us";   
        $data["firstName"] = "";
        $data["email"] = "";
        $data["full_name"] = "";
        $data["phone"] = "";
        $data["admin"] = "";
        $data["referred" ] = "claimzips/claimedzips";
        if ($this->ion_auth->logged_in())
        {
            $user = $this->ion_auth->user()->row();
            $data["firstName"] = $user->first_name;
            $data["email"] = $user->email;
            $data["full_name"] = $user->first_name . " " . $user->last_name;
            $data["admin"] = $this->ion_auth->in_group(array( "Tier I")) ? "yes" : "";
        }
        $this->load->view("claimzips/header", $data);
        $this->load->view("claimzips/buttons", $data);
        $this->load->view("claimzips/contact", $data);
    

    }

    function loadusertable(){
       $data = array();

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/claimzips/claimzips.js");
        
        $data['scripts'] = $scripts;
        $data['title'] = "Savings Sites Zip Code Admin Form";   
        $data["admin"] = "";
        if ($this->ion_auth->logged_in())
        {
            $data["firstName"] = $this->ion_auth->user()->row()->first_name;
            $data["full_name"] = $data['firstName'] . " " . $this->ion_auth->user()->row()->last_name;
            $data["admin"] = $this->ion_auth->in_group(array( "Tier I")) ? "yes" : "";
        }
        if(empty($data['admin'])) {
            echo("No Items Found.");
        }

        $zipData = array();
        $zipData['checkbox'] = "Approve";
        $zipData['claim_status'] = 0;
        $zipData['approve_status'] = "";
        $user_id = $this->input->post('user_id');
        $user_id  = ($user_id < 1) ? 0 : $user_id;
        $zips = $this->zips->get_full_zip_list(array(), $user_id, ($this->input->post('pageAction')==='revoke') ? false : true);
		$user_details=$this->users->get_user_details($user_id);
		//echo '<pre>';print_r($user_details);
        $zipData['phone']=$user_details['phone'];
		$zipData['email']=$user_details['email'];
		
		$outzip = array();
        foreach($zips as $zip){
             $zip->available = 1;
             $outzip[] = $zip;
        }
        $zipData['zips'] = $outzip;
        $this->load->view("claimzips/zipdata", $zipData);
        
        


    }
    function zipadmin($action){
        
        //var_dump($action);
		$data = array();

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/claimzips/claimzips.js");
        
        $data['scripts'] = $scripts;
        $data['title'] = "Savings Sites Zip Code Admin Form";   
        $data["admin"] = "";
        if ($this->ion_auth->logged_in())
        {
            $data["firstName"] = $this->ion_auth->user()->row()->first_name;
            $data["full_name"] = $data['firstName'] . " " . $this->ion_auth->user()->row()->last_name;
            $data["admin"] = $this->ion_auth->in_group(array( "Tier I")) ? "yes" : "";
        }
        if(empty($data['admin'])) { redirect('claimzips/index'); return ;}

        $data["pageAction"] = $action;
        $data["pageType"] = ($action == "approve") ? "Approve Zips" : "Revoke Zips";
        $data["user_list"] = $this->zips->get_user_drop_down(($action === "approve")? false : true);
		//$data["user_list"] = $this->zips->get_user_drop_down("approve");
        $this->load->view("claimzips/header", $data);
        $this->load->view("claimzips/buttons", $data);
        $this->load->view("claimzips/zipadmin", $data);
    }

    function doclaim(){

        $user = $this->ion_auth->user()->row();
        $id =  $user->id;
        if(empty($id)){redirect("auth/login");return;}
        
        $this->zips->claim_zips($this->input->post('zips'), $id);
        
        $mailData =  array('zipCodes' => $this->zips->get_full_zip_list($this->input->post('zips')));
        $mailData['mailUser'] = $this->ion_auth->user()->row();
        $headers = "From: \"Savings Sites Website\"<savings@savingssites.com>\r\n";
		$headers .="Reply-To:  \"No Reply\"<a@a.com>";
        $to = $this->config->item('email_admins');
		$body = $this->load->view("email_templates/user_claimed_zips", $mailData, true);
        
        $mtest = mail($to, "Zip Codes Were Claimed", $body, $headers);
        
        $data = array();

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js");
        $data['user'] = $user;
		$data['where_from']='';
        $data['scripts'] = $scripts;
        $data['title'] = "Savings Sites Zips Claimed. [$to]";   
        $data["admin"] = "";
        if ($this->ion_auth->logged_in())
        {
            $data["firstName"] = $this->ion_auth->user()->row()->first_name;
            $data["full_name"] = $data['firstName'] . " " . $this->ion_auth->user()->row()->last_name;
            $data["admin"] = $this->ion_auth->in_group(array( "Tier I")) ? "yes" : "";
        }

        //$this->load->view("claimzips/header", $data);
        //$this->load->view("claimzips/buttons", $data);
        $data['content'] = $this->load->view('claimzips/successclaimed', $data,true);
        $this->load->view('default/blank', $data);
        
    }
    function claimedzips()
    {
        $data = array();

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/claimzips/claimzips.js");
        
        $data['scripts'] = $scripts;
        $data['title'] = "Savings Sites Zip Code Claiming Form";   
        $data["admin"] = "";
        if ($this->ion_auth->logged_in())
        {
            $data["firstName"] = $this->ion_auth->user()->row()->first_name;
            $data["full_name"] = $data['firstName'] . " " . $this->ion_auth->user()->row()->last_name;
            $data["admin"] = $this->ion_auth->in_group(array( "Tier I")) ? "yes" : "";
        }

        $data["stateList"] = $this->db->query("SELECT * FROM states order by name")->result_array();
        $data["boxesperrow"] = 8;
        $data["totalboxes"] = 40;
        $data["referred" ] = "claimzips/claimedzips";
        $this->load->view("claimzips/header", $data);
        $this->load->view("claimzips/buttons", $data);
        $this->load->view("claimzips/claimed", $data);
        $this->load->view("claimzips/savingsform", $data);
   
    }

    function claim(){
        $zipcount = $this->zips->get_full_zip_list($this->input->post('txtZip'));
        $data = array();
        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/claimzips/check_claim.js");
        
        $data['scripts'] = $scripts;
        $data['title'] = "Savings Sites Zip Code Claiming Form";   
        $data["admin"] = "";
        if ($this->ion_auth->logged_in())
        {
            $data["firstName"] = $this->ion_auth->user()->row()->first_name;
            $data["full_name"] = $data['firstName'] . " " . $this->ion_auth->user()->row()->last_name;
            $data["admin"] = $this->ion_auth->in_group(array( "Tier I")) ? "yes" : "";
        }

        $data["stateList"] = $this->db->query("SELECT * FROM states order by name")->result_array();
        $data['zips'] = $zipcount;
        $data['claim_status'] = 1;
        $this->load->view("claimzips/header", $data);
        $this->load->view("claimzips/buttons", $data);
        $this->load->view("claimzips/claimtop", $data);
        $data['checkbox'] = "Claim";
        $data['approve_status'] = "Approval Status";
        $this->load->view("claimzips/zipdata", $data);
        $this->load->view("claimzips/claimmiddle", $data);
        $data['checkbox'] = 0;
        $data['claim_status'] = 0;
        $data['zips'] = $this->zips->get_full_zip_list($this->input->post('txtZip'), $this->ion_auth->user()->row()->id);
        $this->load->view("claimzips/zipdata", $data);
        $this->load->view("claimzips/claimbottom", $data);

    }
    function getZipCounts($zipArray){
        $ziparr = (is_array($zipArray) ? $zipArray : array($zipArray));
        //$submiturl = "http://dbeint.databaseemailer.com/api/remote_api_search_savingssites_zipsARRAY.php";
		$submiturl = "http://databaseemailer.com/api/remote_api_search_savingssites_zipsARRAY.php";
	    $arrData = array(
			'search' => 'oingoboingo$$%%66',
			'txtZip' => $zipArray
		);
      $zipcount = $this->GetDatacURL($submiturl, $arrData);
      $zipcount = str_replace('$arrZipCounts = array(', '', $zipcount);
      $zipcount = str_replace(' );','',$zipcount);
      $zipcount = str_replace('\'','',$zipcount);
      $tempArray = explode(',',$zipcount);
      $retArray = array();
      foreach($tempArray as $temp)
      {
        $varArr = explode(' => ',$temp);
        $retArray[$varArr[0]] = $varArr[1];
      }
      return $retArray;
     
    }
    function get_zip_data_array($zipstart)
    {
       if(is_array(($zipstart))){
        $this->db->where_in('zip', $zipstart);
        }
        else
        {
            $this->db->where('zip', $zipstart);
        }
        $this->db->from('zipcode');
        $query = $this->db->get()->result_array();
        $zipToCity = array();
        foreach($query as $cityZip)
        {
            extract($cityZip);
            $zipToCity[$zip] = $primarycity;
        }

        $zips = array();
        foreach(array_keys($zipstart) as $zip)
        {
            $zc = new ZipData();
            $zc->zipCode = $zip;
            $zc->registeredEmails = $zipstart[$zip];
            $zc->city = $zipToCity[$zip];
            $zips[] = $zc;
        }
        return $zips;
    }
   function get_zip_table(){
        $zipArray = $this->getZipCounts($this->input->post('txtZip'));

        if(is_array(($this->input->post('txtZip')))){
        $this->db->where_in('zip', $this->input->post('txtZip'));
        }
        else
        {
            $this->db->where('zip', $this->input->post('txtZip'));
        }
        $this->db->from('zipcode');
        $query = $this->db->get()->result_array();
        $zipToCity = array();
        foreach($query as $cityZip)
        {
            extract($cityZip);
            $zipToCity["$zip"] = $primarycity;
        }

        $zips = array();
        foreach(array_keys($zipArray) as $zip)
        {
            $zc = new ZipData();
            $zc->zipCode = $zip;
            $zc->registeredEmails = $zipArray[$zip];
            $zc->city = $zipToCity[$zip];
            $zips[] = $zc;
        }
        $data = array();
        $data['zips'] = $zips;
        $viewData = $this->load->view("claimzips/zipdata", $data, true);
        echo($this->dr->GetDR("Get Successful", "The get was successful", $viewData, "0"));;

    }

    function GetDatacURL($submiturl, &$arrData)
	{
		if(is_array($arrData))
	       $postdata = http_build_query( $arrData);
		$ch = curl_init(); /// initialize a cURL session
		curl_setopt ($ch, CURLOPT_URL,$submiturl);  //live server
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

		//Un comment the next line to write the response to the rates and services request to a file.
		//curl_setopt ($ch, CURLOPT_FILE, $fp);

		//Check to see if this code is on a windows machine or a unix
		$filename = "c:\\windows\\system32\\ca-bundle.crt";
		if (file_exists($filename))
		{
			curl_setopt ($ch, CURLOPT_CAINFO, "c:\windows\system32\ca-bundle.crt");
			curl_setopt ($ch, CURLOPT_CAPATH, "c:\windows\system32\ca-bundle.crt");
			//curl_setopt ($ch, CURL_CA_BUNDLE, "c:\windows\system32\ca-bundle.crt");
		}
		$data = curl_exec ($ch);
		if (curl_errno($ch))
		{
			  return curl_error($ch);
		}
		else
			return $data;
  	  curl_close ($ch);
	}

    function csv(){

        //command can be either 'unclaimed' or 'mine'
        $cmd = $this->input->post('command');
        $sc = ($cmd === 'mine') ? 'my' : $this->input->post('state');
        $cmd = ($cmd === 'mine') ? 'claimed' : 'unclaimed';
        $filename = $sc . '_' . $cmd . '_zipcodes';
        header('Content-type: text/csv');
        header("Content-disposition: attachment;filename=$filename.csv");
        echo "ZipCode,Type,Primary City,State,Time Zone,Estimated Population".PHP_EOL;
            
        switch($cmd)
        {
            case "unclaimed":
            {
                $sql="SELECT *,  zipcode.zip  AS ZIP5  FROM  zipcode LEFT OUTER JOIN  `tblClaimedZips` USING(zip) WHERE  state='$sc' AND  ISNULL(uid) ;    ";
                break;
            }
            case "claimed":
            {
                $User_ID = $this->ion_auth->user()->row()->id;
                $sql="SELECT  *, zipcode.zip  AS ZIP5  FROM `tblClaimedZips`, zipcode WHERE `tblClaimedZips`.`uid` = $User_ID AND `tblClaimedZips`.zip =  zipcode.zip  ORDER BY ZIP5, state, primarycity   ;   ";
                break;
            }
            default:
            {
                $sql = '';
                break;
            }
        }
        if(!empty($sql))
        {
            $query = $this->db->query($sql)->result_array();
            foreach($query as $row)
            {

                extract($row);
                echo "$ZIP5,$type,$primarycity,$state,$timezone,$estpopulation".PHP_EOL;
            }
        }
        else
        {
            echo "No ZipCodes Found".PHP_EOL;
        }
    }

}
//ZipCode	type	primarycity	State	Time Zone	Estimated Population   <-- Proposed Layout
//ZipCode	type	primarycity	Accepted Cities	Unaccepted Cities	State	County	Time Zone	Area	Latitude	Longitude	World Region	Country	Decommission	Estimated Population	Notes <-- Current Layout

class ZipData{

    var $zipCode;
    var $city;
    var $registeredEmails;

}