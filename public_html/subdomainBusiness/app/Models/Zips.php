<?php
namespace App\Models;

use CodeIgniter\Model;
#[\AllowDynamicProperties]
class Zips extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->table = "tblClaimedZips";
    } 
	
	public function get_zips($id = false, $approved = false){
        if( (!empty($id)) && ($id > 0))
        {
            //filtered by user
            $this->db->where('uid', $id);
        }
        if(!empty($approved))
        {
            //yes only = 1, no only = 2
            $this->db->where('approved', ($approved == 2) ? 0 : 1); 
        }

        return $this->db->get($this->table)->result_array();

    }

     function getZipCounts($zipArray){
        if(empty($zipArray)){return Array();}
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
        if( (is_array($varArr) && (count($varArr) > 1)))
        {

            $retArray[$varArr[0]] = $varArr[1];
        }
      }
      return $retArray;
     
    }
    
    function get_user_drop_down($approved = false){

		//var_dump($approved); //exit;
        $options = array();
        $options['-2'] = '-- Select User --';
        
        $arr = $this->get_users_zips($approved);
		//var_dump($arr);

         foreach(array_keys($arr) as $key)
        {
            if(isset($arr[$key][0])){
			$a = $arr[$key][0];
			if($a['last_name']=='' &&  $a['first_name']==''){
				$options[$key] = "(" . $a['username'] . ")";
			}else{
				$options[$key] = $a['last_name'] . " , " . $a['first_name'] . "(" . $a['username'] . ")";
			}
			}
        }
        return $options;
    }
	public function selected_zip_for_delivery($zoneId='',$adId='')
	{
	$sql="SELECT deliver_zips FROM ads WHERE id=".$adId;
	$query = $this->db->query($sql);
	$count_query= $query->num_rows();
	if($count_query>0){
	return $query->result_array();
	}else{
	return 0;
	}
	}
    function get_users_zips($approved=false){
        $sql = "SELECT t1.*, t1.zip as ZIP5, t2.* FROM `tblClaimedZips` as t1 join users as t2 on t1.uid = t2.id WHERE approved = ";
        $sql .= empty($approved) ? "0" : "1";
        $sql .= " order by t2.last_name, t2.first_name";
        $result = $this->db->query($sql)->result_array();
        $resultArray = array();
        $userid = 0;
        $tempArray = array();
        foreach($result as $res){
            if(empty($userid) || ($userid != $res['uid'])){
                if(!empty($userid)){ $resultArray[$userid] = $tempArray;}
                $userid = $res['uid'];
                $tempArray = array();
            }
            $tempArray[] = $res;

        }
         $resultArray[$userid] = $tempArray;
        return $resultArray;
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

    public function get_unapproved_zips(){


    }
    public function claim_zips($ziparray, $uid){
        //var_dump($ziparray);
		if(empty($ziparray))
			return;
        if(!is_array($ziparray)){ $ziparray = array($ziparray);}

        $data = array();

        foreach($ziparray as $zip)
        {
            //var_dump($zip);
			
			
			$data[] = array(
              'zip' => $zip ,
              'uid' => $uid ,
              'approved' => 0
            );
        
 		}
        $this->db->insert_batch('tblClaimedZips', $data);
		

        //after email user...
    }
    public function get_full_zip_list($ziparray, $uid = false, $approved = false)
    {
        if(!is_array($ziparray)){
            $ziparray = array($ziparray);
        }
        $temp_zip_array = array();
        foreach($ziparray as $zz_temp)
        {
            if(!empty($zz_temp))
            {
                $temp_zip_array[] = $zz_temp;
            }
        }
        $ziparray = $temp_zip_array;
        $sql = "SELECT t1.Zip_ID as zipid, t1.state,t1.primarycity as city, t1.zip, 
t3.id as user_id, t3.first_name, t3.last_name,t2.approved, t2.DateEntered FROM  zipcode as t1 LEFT OUTER JOIN  `tblClaimedZips` as t2 USING(zip)
left outer join users as t3 on t2.uid = t3.id  WHERE ";
        
        if(empty($uid))
        {
            if(!empty($approved))
            {
                $sql .= "t2.approved = 0";
            }
            else
            {
                $sql .= "t1.zip in ('";
                $in_data = implode('\',\'', $ziparray);
                $sql .= $in_data . '\')';
            }
			$sql.=" group by t1.zip";
            $zip_temp = $this->db->query($sql, $ziparray)->result_array();
        }
        else
        {
            $sql .= "t2.uid = $uid ";
            if(!empty($approved)){ $sql .= " AND t2.approved = 0";}
			$sql.=" group by t1.zip";
			//echo $sql;
            $zip_temp = $this->db->query($sql, $ziparray)->result_array();
            $ziparray = array();
            foreach($zip_temp as $zz_temp)
            {
                $ziparray[]= $zz_temp['zip'];
            }
        }

        $zip_lookup = $this->getZipCounts($ziparray);
		//var_dump($zip_lookup);
        
        $ret = array();

        foreach($zip_temp as $temp)
        {
            extract($temp);
            $fzd = new FullZipData();
            $fzd->zipCode = $zip;
            $fzd->id = $zipid;
            $fzd->city = $city;
            $fzd->state = $state;
            $fzd->approved = empty($approved) ? 0 : $approved;
            $fzd->registeredEmails = array_key_exists($zip, $zip_lookup) ? $zip_lookup[$zip] : "Unknown";
			//$fzd->registeredEmails = $zip;
            $fzd->available = empty($user_id) ? 1 : 0;
            $fzd->ownerid = $user_id;
            $fzd->owner_name = empty($user_id) ? "" : $first_name . " " . $last_name;
            $fzd->dateSubmitted = empty($user_id) ? "" : $DateEntered;
            $ret[] = $fzd;

        }
            return $ret;
    }
    public function get_zip_report($id)
    {
        $sql = "select t1.*, t2.zip as ZIP5, t2.primarycity as City from tblClaimedZips as t1 join zipcode as t2 on
t1.zip = t2.zip where t1.uid = ?";
        return $this->db->query($sql, array($id))->result_array();
    }

    public function get_zips_for_zone($zoneId)
    {
        // commented by Athena eSolutions - 29.11.2012
		/*$sql = "select t1.*, t2.zip as ZIP5, t2.primarycity as City from tblClaimedZips as t1 join zipcode as t2 on
                t1.zip = t2.zip where t2.zip in (select zip_code from zip_code_zone where zone_id = ?)";*/
		// Athena eSolutions start - 29.11.2012		
		$sql = "select t1.*, t2.zip as ZIP5, t2.primarycity as City from tblClaimedZips as t1 join zipcode as t2 on
                t1.zip = t2.zip where t2.zip in (select zip_code from zip_code_zone where zone_id = ?) and t1.approved=1 GROUP BY t1.zip";
				//echo $sql;
        // Athena eSolutions end
		return $this->db->query($sql, array($zoneId))->result_array();
    }

    public function get_zips_not_in_zone($zoneId, $uid)
    {
		// commented by Athena eSolutions - 29.11.2012
        /*$sql = "select t1.*, t2.zip as ZIP5, t2.primarycity as City from tblClaimedZips as t1 join zipcode as t2 on
                t1.zip = t2.zip where t2.zip not in (select zip_code from zip_code_zone where zone_id = ?) and t1.uid=? ";*/
		
		// Athena eSolutions start - 29.11.2012
		$sql = "select t1.*, t2.zip as ZIP5, t2.primarycity as City from tblClaimedZips as t1 join zipcode as t2 on
                t1.zip = t2.zip where t2.zip not in (select zip_code from zip_code_zone where zone_id = ? and zip_code = t1.zip) and t1.uid=? and t1.approved=1 GROUP BY t1.zip";
		// Athena eSolutions end
        //echo $sql; 
		return $this->db->query($sql, array($zoneId, $uid))->result_array();
    }


    /*public function remove_zip_from_zone($zoneId, $zipcode){
        if(!empty($zoneId) && $zoneId > 0)
        {
            $this->db->delete('zip_code_zone', array('zip_code' => $zipcode, 'zone_id' => $zoneId));
            return $this->get_zips_for_zone($zoneId);
        }
    }*/
	
	public function remove_zip_from_zone($zoneId, $zipcode){
        if(!empty($zoneId) && $zoneId > 0)
        {
           /* $sql1="SELECT a.business_id FROM business_to_zone a,zip_code_zone b WHERE a.zone_id=b.zone_id and a.zone_id=".$zoneId." and b.zip_code=".$zipcode;*/
			
			$sql1="SELECT a.* FROM business_to_zone a,business b,address c WHERE a.zone_id=".$zoneId." and a.business_id=b.id and b.addressid=c.id and c.zip_code=".$zipcode;
			$query1 = $this->db->query($sql1);
			$result_check_sqlquery1 = $query1->num_rows();
			//echo $result_check_sqlquery1;
			if($result_check_sqlquery1==0){
				$this->db->delete('zip_code_zone', array('zip_code' => $zipcode, 'zone_id' => $zoneId));
            	return $this->get_zips_for_zone($zoneId);
			}
			
			//$this->db->delete('zip_code_zone', array('zip_code' => $zipcode, 'zone_id' => $zoneId));
            //return $this->get_zips_for_zone($zoneId);
        }
    }

    public function add_zip_to_zone($zoneId=0, $zipcode=0){
		$lat='';$long='';
        if(!empty($zoneId) && $zoneId > 0){
            // + for assign latitude and longitude againest zip code
			if(!empty($zipcode) && $zipcode > 0){
				$zip_code = trim($zipcode);
				$url = "http://maps.google.com/maps/api/geocode/json?address=$zip_code&sensor=false";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$response = curl_exec($ch);
				curl_close($ch);
				$response_a = json_decode($response);				
				if(is_object($response_a) && isset($response_a->results[0])){
					$lat = $response_a->results[0]->geometry->location->lat; 
					$long = $response_a->results[0]->geometry->location->lng;
				}
			}
			// - for assign latitude and longitude againest zip code
			$this->db->insert('zip_code_zone', array('zip_code' => $zipcode, 'zone_id' => $zoneId, 'latitude'=>$lat, 'longitude'=>$long));
            return $this->get_zips_for_zone($zoneId);
        }
    }
	
	public function get_zip_for_zone($zoneId){
		if(!empty($zoneId) && $zoneId>0){
			$sql="SELECT b.name ,a.zip_code FROM zip_code_zone a,sales_zone b WHERE a.zone_id=b.id AND a.zone_id=".$zoneId;
			$query = $this->db->query($sql);
			$count_query= $query->num_rows();
			if($count_query>0){
				//$result_query = $query->result_array();
				//var_dump($result_query);
				return $query->result_array();
			}else{
				return 0;
			}
			
			
		}
	}
	
	public function zip_to_zone($zip){		
		$newzip=is_numeric($zip); 
		if($newzip== false){
			return 0;
		}else if($newzip== true){
			$sql="SELECT b.seo_zone_name,b.id,b.name FROM zip_code_zone a,sales_zone b WHERE a.zone_id=b.id AND a.zone_id=".$zip;
			$query = $this->db->query($sql);
			$count_query= $query->getNumRows();
 			
 			if($count_query>0){
				return $query->getResultArray();
			}else{			
		 		$zipsql="SELECT b.seo_zone_name,b.id,b.name FROM zip_code_zone a,sales_zone b WHERE a.zone_id=b.id AND a.zip_code=".$zip;
				$zip_sql = $this->db->query($zipsql) ;
				$count_zipsql = $zip_sql->getNumRows() ;
				 			 	
				if($count_zipsql>0){
					return $zip_sql->getResultArray();
				}else{
					return 0 ;
				}
			}
		}
	}
	
	#######################################################################################
	function get_zip_details($zips=0,$uid=0){
		//echo $zips;
		$w1='';
		if($zips!=0){
			/*if($uid!=0){
				$w1=" and b.uid=$uid";
			}*/
			/*$sql="SELECT a.Zip_ID as zipid,a.zip,a.state,a.primarycity as city,b.approved, b.DateEntered,c.id as user_id,c.first_name, c.last_name from zipcode a
			left join tblclaimedzips as b on a.zip=b.zip $w1
			left join users as c on b.uid=c.id
			where a.zip IN($zips)";*/
			$sql="SELECT a.Zip_ID as zipid,a.zip,a.state,a.primarycity as city,b.zip as bzip,b.approved, b.DateEntered
			from zipcode a
			left join tblClaimedZips as b on a.zip=b.zip
			where a.zip IN($zips) group by a.zip";//exit;
			$query = $this->db->query($sql);
			$result=$query->result_array(); //print_r($result);
			$i=0;
			if(!empty($result)){		
				foreach($result as $x){
					if($x['bzip']!=''){
						$result[$i]['showclaimbtn']=0;
					}else{
						$result[$i]['showclaimbtn']=1;
					}
					$i++;
				}
				return $result;
			}
		}else
			return '';
	}
	
	function get_zip_claim($zips=0,$uid=0){
		if($uid!=0){
			$sql="select zip from tblClaimedZips where zip IN($zips)";
			$query=$this->db->query($sql);
			if($query->num_rows()==0){
				$arr_zips=explode(',',$zips);
				//var_dump($arr_zips); var_dump($uid); exit;
				foreach($arr_zips as $v1){
					$data_ins = array('zip' => $v1,'uid' => $uid,'approved'=>0);
					$this->db->insert('tblClaimedZips', $data_ins);
				}
			}
		}
	}
	function get_zip_claim_by_user($zips=0,$useremail='',$get_fname='',$get_lname=''){ //var_dump($zips);var_dump($useremail); exit;
	if($zips!='0' && $useremail!=''){
		$sql="select id from users where email='".$useremail."'";
		$query=$this->db->query($sql);
		if($query->num_rows()==0){
			$data_ins = array('email' => $useremail, 'first_name'=>$get_fname, 'last_name'=>$get_lname);
			$this->db->insert('users', $data_ins);
			$uid=$this->db->insert_id(); //var_dump($uid); //exit;
			if($uid!='0'){
				$this->get_zip_claim($zips,$uid);
				$message="<div style='border:1px solid #900; padding:5px;'>Dear Administrator,<br /><br />
				The following zips have been claimed. Please login to your admin panel to approve/reject them.<br><br>
				Claimed Zips:".$zips."<br><br>
				Requestor Name:".$get_fname." ".$get_lname."<br><br>
				Requestor Email:".$useremail."
				</div>" ;
				$fromemail='noreply@savingssites.com';
				$this->load->library('email');
				$template_subject="Savings Sites Zip Approval";
				$this->email->clear();
				$this->email->from($fromemail);
				$this->email->subject($template_subject);
				$this->email->message($message);
				//$admin_email='ajdmm@optonline.net';
				$admin_email='anish.sett@gmail.com';		
				if($admin_email!='')
				{
					$this->email->to($admin_email);
					$this->email->send();
					$to[]=$admin_email;
				}
			}
		}
		
	}
}
	
}


class FullZipData{

    var $id;
    var $approved;
    var $zipCode;
    var $city;
    var $state;
    var $registeredEmails;
    var $available;
    var $ownerid;
    var $owner_name;
    var $dateSubmitted;

}