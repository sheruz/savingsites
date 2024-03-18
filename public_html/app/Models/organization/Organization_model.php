<?php
namespace App\Models\organization;

use CodeIgniter\Model;
use App\Controllers\CommonController;
use App\Libraries\IonAuth;
#[\AllowDynamicProperties]
class Organization_model extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->CommonController = new CommonController();
    } 
	
	public function organization_details($organizationid){
		$result = $this->CommonController->SelectDataMultiWay('organization','id,name','resultArray',['id'=> $organizationid]);
		$arr=(!empty($result[0])) ? $result[0] : 0; 
		return $arr;
	}

	public function organization_owner_details($organizationid){		
		$joinArr[] = ['table' => 'users as b','link' => 'a.userid = b.id','type' => 'left'];
	  	$result = $this->CommonController->SelectJoinMulti('organization as a', $joinArr,['a.id'=>$organizationid],[], [],'b.*','','','',[],'resultArray','');
	  	$arr=(!empty($result[0])) ? $result[0] : 0; 
		return $arr;
	}

	

# + get_all_org_members   --> To get all the members under one organization for Bulk Email ; Added on 21/8/14

	public function get_all_org_members($org_id,$zoneid){

		$sql = "SELECT a.* b.* FROM org_members a , organization b WHERE a.org_id=b.id AND b.id=".$org_id." AND b.zoneid=".$zoneid." AND a.zoneid=b.zoneid";

		$query = $this->db->query($sql);

		$result = $query->result_array();

		return $result;		

	}

# -	get_all_org_members	



# + Insert new organization photo

	public function save_org_photo_new($image_name='', $org_id=0, $cat_id=0, $status=1, $description=''){
		$sql = "SELECT (MAX(`order`)+1) as neworder FROM organizationphotos_display WHERE `org_id` =".$org_id." AND cat_id=".$cat_id;
		$order = $this->CommonController->SelectRawquery($sql);
		$order_val = !empty($order[0]['neworder']) ? $order[0]['neworder'] : 1;
		
		$data = array(
			'image_name'=>$image_name,
			'org_id'=>$org_id,
			'cat_id'=>$cat_id,
			'description'=>$description,
			'timestamp'=>time()
		);
		$org_photo_id = $this->CommonController->InsertData('organization_photos', $data);
		
		$display_data = array(
			'orgphotosid'=>$org_photo_id,
			'org_id'=>$org_id,
			'cat_id'=>$cat_id,
			'order'=>$order_val,
			'status'=>$status
		);
		$org_photo_display_id = $this->CommonController->InsertData('organizationphotos_display', $display_data);
		
		$return_data=array('orgphotosid'=>$org_photo_id,'banner_display_id'=>$org_photo_display_id);
		return $return_data;
	}

# - Insert new organization photo



# + View all org photo by cat id

	public function org_photo_by_catid($catid=0,$orgnid=0){
		$sql = "SELECT b.order, b.status, b.orgphotosid as pid, b.org_id as oid, a.* FROM organization_photos as a LEFT JOIN organizationphotos_display as b ON a.org_id=b.org_id WHERE a.org_id = $orgnid AND a.cat_id = '".$catid."' ORDER BY b.order ASC";



		
		$result = $this->CommonController->SelectRawquery($sql);;
		return $result;		
	}



# - View all org photo by cat id



# + Change order of the org photos

	public function org_photo_order_change($updateRecords = '',$org_id = '',$cat_id=''){

		if ($updateRecords != '' && $org_id != '' && $cat_id != ''){

			

			$trimvalue = rtrim($updateRecords,','); 

			$updateRecordsArray = explode(',',$trimvalue);

			

			foreach ($updateRecordsArray as $key=>$banner_data) {	

				$banner_value = explode('_',$banner_data);

				$banner_display_data=array('order'=>$key+1);

				$banner_display_where = array('orgphotosid'=>$banner_value[1],'org_id'=>$org_id);

				$this->db->where($banner_display_where);

				$this->db->update('organizationphotos_display',$banner_display_data);

	

			}

		}

	}

# - Change order of the org photos



# + Delete org photo

	public function delete_org_photo($photo_id=0,$org_id=0,$cat_id=0,$image_name=''){
		if($photo_id!=0){
			$data_where=array('id'=>$photo_id,'org_id'=>$org_id);
			$this->CommonController->deleteData('organization_photos',$data_where);
			$path = $_SERVER['DOCUMENT_ROOT'].'/assets/SavingsUpload/org_logo/'.$image_name;
			unlink($path);
			
			$display_data_where=array('orgphotosid'=>$photo_id,'org_id'=>$org_id);
			$this->CommonController->deleteData('organizationphotos_display',$display_data_where);
		}
	}

# - Delete org photo



# + Org photo details by photo id

	public function org_photo_by_id($photo_id=0,$org_id=0){

		$sql = "SELECT a.*,b.status FROM organization_photos a, organizationphotos_display b WHERE a.id = b.orgphotosid AND a.id=$photo_id AND a.org_id=$org_id";

		$query = $this->db->query($sql);

		$result=$query->result_array();

		return $result;

	}

# - Org photo details by photo id



# + update org photo

	public function update_org_photo($photo_id=0,$org_id=0,$description='',$status=0,$cat_id=0){ 
		$photo_data=array('description'=>$description,'cat_id'=>$cat_id);
		$photo_where = array('id'=>$photo_id,'org_id'=>$org_id);
		$this->CommonController->updateData('organization_photos',$photo_data,$photo_where);
		
		$photo_display_data=array('status'=>$status,'cat_id'=>$cat_id);
		$photo_display_where = array('orgphotosid'=>$photo_id,'org_id'=>$org_id);
		$this->CommonController->updateData('organizationphotos_display',$photo_display_data,$photo_display_where);
	}

	

	function getall_webinar_info($zoneid=0,$webinar_id=0){

      	$sql = "SELECT * FROM webinar_information WHERE zoneid=".$zoneid." AND id=".$webinar_id." ORDER BY id ASC";

		$query = $this->db->query($sql);	

		return $query->result_array();

	}
	
	public function show_webinar($zone_id = false,$organization_owner_id=0,$lowerlimit=0,$upperlimit=0){
		$sql = "SELECT * FROM webinar_information WHERE zoneid=".$zone_id." AND created_by_userid=".$organization_owner_id." order by id ASC";
		return $this->CommonController->SelectRawquery($sql);
	}

	

	

	function org_status_view($zoneid){ //var_dump($zoneid);exit;

      	$sql = "SELECT * FROM organization WHERE zoneid=".$zoneid;

		$query = $this->db->query($sql);	

		return $query->result_array();

	}

	

	

	

	

# - update org photo







# + Organization Peekaboo auction view on PEEKABOO sites 



 function auction_view($zoneid,$organizationid){

    // + Get info about this organization

	$this->db->select('d.group_id,e.username,a.name');

	$this->db->from('organization as a,sales_zone as c');

	$this->db->join('users_groups d', 'd.user_id=a.userid');

	$this->db->join('users as e', 'e.id=a.userid');

	$this->db->where('c.id', $zoneid);

	$this->db->where('a.id', $organizationid);

	$this->db->group_by('username'); 

	$query = $this->db->get();

	$result=$query->result_array();

	 

		  $data['peekaboo_other_page'] = $result; 

		  $group_id = $result['0']['group_id'];

		  $username =$result['0']['username'];

		  $org_name = $result['0']['name'];	  

					

				// + Peekaboo account already created or not of this organization 

		  			$this->db->select('a.username');

		  			$this->db->from('users a');

		  			$this->db->join('tbl_member b', 'b.user_name=a.username');

					$this->db->where('b.user_name', $username);

					$query2 = $this->db->get();

					$result2=$query2->result_array();

					$peekaboo_username = $result2['0']['username'];

				// + Peekaboo account already created or not of this organization 

					

					

				// + organization who has no peekaboo account then peekaboo account create with same username and password. 

				

					if($peekaboo_username == ''){

												

						$this->db->select('*');

						$this->db->from('users');

						$this->db->where('username', $username);

						$query3 = $this->db->get();

						$ss_user_result=$query3->result_array();

						

						  $peekaboo_username_exists = $ss_user_result['0']['username'];

						  $peekaboo_password_exists = $ss_user_result['0']['password'];

						  $peekaboo_email_exists = $ss_user_result['0']['email'];

						  $peekaboo_first_name_exists = $ss_user_result['0']['first_name'];

						  $peekaboo_last_name_exists = $ss_user_result['0']['last_name'];

						  $peekaboo_phone_exists = $ss_user_result['0']['phone'];

						  $peekaboo_Address_exists = $ss_user_result['0']['Address'];

						  $peekaboo_City_exists = $ss_user_result['0']['City'];

						  $peekaboo_company_exists = $ss_user_result['0']['company'];

						  $peekaboo_phone_exists = $ss_user_result['0']['phone'];

						  $peekaboo_Zip_exists = $ss_user_result['0']['Zip'];

						  $peekaboo_State_Code_exists = $ss_user_result['0']['State_Code'];

					

					

						     $data_peekaboo=array(

										 'fName'=>$peekaboo_first_name_exists,

										 'lName'=>$peekaboo_last_name_exists,

										 'email'=>$peekaboo_email_exists,

										 'address1'=>$peekaboo_Address_exists,

										 'company_name'=>$org_name,

										 'city_name'=>$peekaboo_City_exists,

										 'state_name'=>$peekaboo_State_Code_exists,

										 'post_code'=>$peekaboo_Zip_exists,

										 'phone'=>$peekaboo_phone_exists,

										 'user_name'=>$peekaboo_username_exists,

										 'password'=>sha1($peekaboo_password_exists),

										 'activated'=>'yes',

										 'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),

										 'member_type'=>2

									);

	 

							$data_peekaboo_insert= array_filter($data_peekaboo);

							$this->db->insert('tbl_member', $data_peekaboo_insert);

							$peekaboo_id = $this->db->insert_id();	

						} 

						

					// - organization who has no peekaboo account then peekaboo account create with same username and password. 	

						

			return $username.','.$group_id;						

 }

 

# - Organization Peekaboo auction view on PEEKABOO sites





// + Get username for this organization calendar auto loggin purpose

			

	 function get_username($orgid,$zoneid){

		 $this->db->select('a.username,a.id');

		 $this->db->from('users as a');

		 $this->db->join('organization b','a.id=b.userid');

		 $this->db->where('b.id',$orgid);

		 $this->db->where('b.zoneid',$zoneid);

		 $query = $this->db->get();

		 $result = $query->result_array();

		 

		 $last_login = date("Y-m-d H:i:s");

		 

		 // update last login time

		 

		 

		 // update last login time

		 

		 

		// $defaultUser = "admin_user";

		// $_SESSION[$defaultUser];

		 

		 

		 

		 

		// $url = "http://127.0.0.1/savingssites/EventCalendar/app/controller=pjAdmin&action=pjActionIndex";

		 //http://127.0.0.1/savingssites/EventCalendar/index.php?controller=pjAdmin&action=pjActionIndex

		 return $result['0']['id'];

	 }		

// + Get username for this organization calendar auto loggin purpose





	function geteventcalendarhistory($org_id = ''){

		$this->db->distinct() ;

		$this->db->select('a.category_id, b.name') ;

		$this->db->from('calendarphpeventcalendar_events a') ;

		$this->db->join('organization_category b','a.category_id = b.id') ;

		$this->db->where('b.orgid',$org_id) ;

		$query 		= $this->db->get() ;

		$result 	= $query->result_array() ;

		$response 	= array() ;

		if(!empty($result)){

			foreach($result as $categoryid){													// categories of current organization

				$this->db->select('a.id, a.first_name, a.last_name, a.email') ;

				$this->db->from('users a') ;

				$this->db->join('resident_interestedcategory b','a.id = b.resident_userid') ;

				$this->db->like(array('b.activecategory'=> ','.$categoryid['category_id'].',')) ;

				$aciverows 	= $this->db->get();

				$rowcount 	= $aciverows->num_rows();

				if($rowcount > 0){

					$userdetails = $aciverows->result_array() ;

					foreach($userdetails as $row){ 												// active category of a user

						if(!isset($response[$row['id']]['name']) && !isset($response[$row['id']]['email'])){echo $row['id'] ;

							$response[$row['id']]['name']	 = $row['first_name'].' '.$row['last_name'] ;

							$response[$row['id']]['email']	 = $row['email'] ;

						}

						$response[$row['id']]['category']	 .= ($response[$row['id']]['category'] == '') ? $categoryid['name'] : ', '.$categoryid['name'] ;

					}

				}

			}

		}

		return $response ;

	}

    /** function to fetch organization category

     * @param organization id integer

     * @return array

     */

    public function fetch_jotform_organizationcategory($organizationid){
        $data =[];
		$sql = "SELECT * FROM payment_module WHERE receiver_type='organization'";
		$category  = $this->CommonController->SelectRawquery($sql);
      	
      	$fetch_form_category_query = "SELECT a.code_id, a.code, a.payment_module_receiver_id AS zone_id, b.id AS payment_module_id, b.value AS payment_form_type, b.receiver_type, b.payer_type FROM payment_module AS b LEFT JOIN jot_form_embed_code AS a ON a.payment_module_id=b.id AND a.payment_module_receiver_id=".$organizationid." WHERE b.receiver_type = 'organization'";
      	$form_codes = $this->CommonController->SelectRawquery($fetch_form_category_query);
        
        if(count($form_codes) > 0){
        	foreach ($form_codes as $value) {
        		$type_id = $value['payment_module_id'];
        		$data['form_codes'][$type_id] = $value;
        	}
        }
        return $data;
    }

    public function update_jotformcode_data($form_type_id,$codes,$organization_id){

        $organization_id = (int)$organization_id;

        $form_type_id=(int)$form_type_id;

        $sql = "SELECT * FROM jot_form_embed_code WHERE payment_module_id=".$form_type_id." AND payment_module_receiver_id=".$organization_id;

        $query = $this->db->query($sql);

        $code_result =false;

        if($query->row()){

            $update_codes="UPDATE jot_form_embed_code SET code='".$codes."' WHERE payment_module_id=".$form_type_id." AND payment_module_receiver_id=".$organization_id;

            $update_result = $this->db->query($update_codes);

            $code_result=$update_result;

        } else{

            $inserted_sql = "INSERT INTO jot_form_embed_code(code,payment_module_id,payment_module_receiver_id) VALUES('".$codes."',".$form_type_id.",".$organization_id.")";

            $inserted_query = $this->db->query($inserted_sql);

            $code_result = $inserted_query;



        }

        return $code_result;



    }

    public function get_payment_details($organization_id){
		$sql = "SELECT 

	 				  a.payer_id,

	 				  a.amount,

	 				  a.submission_id,

	 				  a.form_id,

	 				  a.time AS payment_creation_time,

	 				  b.name AS business_name,

	 				  c.value AS payment_purpose

	 			   FROM

	 			   	  payment AS a

	 			   INNER JOIN business AS b

	 			   		ON a.payer_id=b.id

	 			   INNER JOIN payment_module AS c

	 			   		ON a.payment_module = c.id

	 			   WHERE a.receiver_id=".$organization_id."

	 			   ORDER BY a.time ASC";
	 			   
	 			   return $this->CommonController->SelectRawquery($sql);
	}
	
	public function get_org_pboo_credit_request($organization_id,$payment_module_id){
		$sql = "SELECT a.id AS payment_id, a.payer_id, a.amount, a.submission_id, a.pboo_credit_status, a.form_id, a.time, b.first_name, b.last_name FROM payment a INNER JOIN users b ON a.payer_id=b.id WHERE a.receiver_id=".$organization_id." AND a.payment_module=".$payment_module_id; 
		return $this->CommonController->SelectRawquery($sql);
	}

    public function get_org_pboo_credit_account($organization_id){
		$organization_id =(int)$organization_id;
		$sql = "SELECT c.user_id AS pboo_credit_account_id FROM organization a,users b,tbl_member c WHERE a.userid=b.id AND b.username=c.user_name AND a.id=".$organization_id;
		return $this->CommonController->SelectRawquery($sql);
	}

    public function update_pboo_credits($user_id,$payment_id,$account_id,$credits){

    	$sql = "SELECT

    				a.email,

    				b.user_id

    			FROM users a

    			INNER JOIN tbl_member b

    			ON 

    				a.username=b.user_name

    			WHERE

    				a.id=".$user_id;

    	$query = $this->db->query($sql);

    	$result = $query->row();

    	//return $result;

    	$user_pboo_id = $result->user_id;

    	$user_email  = $result->email;

    	$this->db->trans_begin();

    	$this->trans_update($user_pboo_id,$credits,1);

    	$this->update_pboo_credits_auction_status($payment_id);

    	$this->trans_update($account_id,$credits,0);

    	if ($this->db->trans_status() === FALSE){

        	$this->db->trans_rollback();

        	return false;

		}

		else{

        	$this->db->trans_commit();

        	return true;

		}

    }

    public function update_pboo_credits_auction_status($payment_id){

    	$payment_id = (int)$payment_id;

    	$sql_status_update ="UPDATE payment SET pboo_credit_status=1 WHERE id=".$payment_id;

    	$result_update = $this->db->query($sql_status_update);

    	return $result_update;

    }

    public function trans_update($user_id,$credits,$status){

    	$sql = "SELECT 

    				a.balance

    				FROM tbl_member a

    				WHERE a.user_id=".$user_id;

    	$query = $this->db->query($sql);

    	$result = $query->row();

    	$balance = (int)$result->balance;

    	if($status == 1){

    		$balance =$balance+$credits;

    	} else if($status == 0){

    		$balance =$balance-$credits;

    	}

    	$sql_update = "UPDATE tbl_member SET balance=".$balance." WHERE user_id=".$user_id;

    	$result = $this->db->query($sql_update);

    	return $result;

    }

    public function current_credit($id){

    	$sql = "SELECT

    				 a.balance,

    				 a.fName AS first_name,

    				 a.lName AS last_name,

    				 a.email

    			FROM 

    				tbl_member a

    			WHERE user_id=".$id;

    	$query = $this->db->query($sql);

    	return $query->row();

    }

    public function get_pboo_account_details($username){
		$sql = "SELECT a.user_id AS id,a.fName AS first_name,a.lName AS last_name,a.email,a.address1,a.address2,a.city_name,a.country_name,a.state_name,a.post_code,a.phone FROM tbl_member a WHERE user_name='".$username."'";
    	return $this->CommonController->SelectRawquery($sql,'row');
    }

    public function get_pboo_account_id($id,$type){
		$id =(int)$id; $sql = "";
		if($type =="org"){
			$sql = "SELECT c.user_id AS pboo_credit_account_id FROM organization a,users b,tbl_member c WHERE a.userid=b.id AND b.username=c.user_name AND a.id=".$id;
		}else if($type == "users"){
			$sql = "SELECT b.user_id AS pboo_credit_account_id FROM users a, tbl_member b WHERE a.username = b.user_name AND a.id=".$id;
		}else if($type == "business"){
			$sql = "SELECT c.user_id AS pboo_credit_account_id FROM business a, users b, tbl_member c WHERE a.business_owner_id=b.id AND b.username=c.user_name AND a.id=".$id;
		}
        $account_id = 0;

		$result = $this->CommonController->SelectRawquery($sql,'row');
		if($result!= ''){
			$account_id = $result->pboo_credit_account_id;
		}
		return $account_id;
	}

    public function pboo_credit_transfer($payer_id,$receiver_id,$credits){

    	$this->db->trans_begin();

    	$this->trans_update($receiver_id,$credits,1);

    	$this->trans_update($payer_id,$credits,0);

    	if ($this->db->trans_status() === FALSE){

        	$this->db->trans_rollback();

        	return false;

		}

		else{

        	$this->db->trans_commit();

        	//$this->db->credit_receive_mail($payer_id,$receiver_id,$credits);

        	return true;

		}



    }

    public function credit_receive_mail($payer_id,$receiver_id,$credits){

    	$payer_details = $this->current_credit($payer_id);

    	$receiver_details = $this->current_credit($receiver_id);

    	$payer_name = $payer_details->first_name." ".$payer_details->last_name;

    	$receiver_name = $receiver_details->first_name." ".$receiver_details->last_name;

    	$receiver_mail = $receiver_details->email;

    	date_default_timezone_set('Asia/Kolkata');

		$currentDateTime=date('m/d/Y H:i:s');

		$current_time = date('h:i A', strtotime($currentDateTime));

		$current_date = date('m/d/y',strtotime($currentDateTime));

    	$mail_content = "<p>The account of </p>".$payer_name." has transferred at ".$current_time." on".$current_date." a quantity of ".$credits." to the account of ".$receiver_name;

    	$subject = "Transfer pboo Credits Confirmation mail";

    	$headers.= "From:savingssites.com";

    	$headers .= "MIME-Version: 1.0\r\n";

		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

		$mail_result= mail($receiver_mail, $subject, $mail_content, $headers);



		return $mail_result;

    }

    public function spread_sheet_data($requestor_id,$type){
	
    	$sql = "";

    	if($type == "org"){

	    	$sql = "SELECT

	    				 a.payment_id,

	    				 b.auction_id,

	    				 c.fName,

	    				 c.lName,

	    				 c.phone,

	    				 c.state_name,

	    				 c.city_name,

	    				 c.address1,

	    				 c.address2,

	    				 c.country_name

	    			FROM

	    				certificate_benificary_organization a,

	    				payment b,

	    				tbl_member c

	    			WHERE

	    				a.payment_id = b.id

	    			AND

	    				b.payer_id = c.user_id

	    			AND

	    				b.payment_module = 2

	    			AND

	    				a.organization_id=".$requestor_id;

	    } else if($type == "business") {

	    	$sql = "SELECT

	    				 a.payment_id,

	    				 b.auction_id,

	    				 b.amount,

	    				 b.time,

	    				 c.fName,

	    				 c.lName,

	    				 c.phone,

	    				 c.state_name,

	    				 c.city_name,

	    				 c.address1,

	    				 c.address2,

	    				 c.country_name

	    			FROM

	    				business_payment_for_certificate a,

	    				payment b,

	    				tbl_member c

	    			WHERE

	    				a.payment_id = b.id

	    			AND

	    				b.payer_id = c.user_id

	    			AND

	    				b.payment_module = 2

	    			AND

	    				a.business_id=".$requestor_id;



	    }
        
	    return $this->CommonController->SelectRawquery($sql);
	}





    /*public function get_organization_details($org_id){

    	

    }

*/

###############################################################################################################################################



														/*Organization Model Ends Here*/



###############################################################################################################################################



}