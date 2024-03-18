<?php

class Webinarmodel extends CI_Model{

	public function __construct(){

		parent::__construct();

        $this->load->library('ion_auth');

		$this->load->helper('url');

        $this->load->database();

		$this->load->helper('array');

    }

	/**

	  * Method to fetch all Banners

      * @access public

      * @param $zoneId

      * @return $banners array

	*/

	function inderorder($mode = 'free' , $payerid= '0' , $packageid , $userid){

		$unique_id = time() . mt_rand() . $userid;
 
      $data =array('package_id' => $packageid,'user_id' => $userid,'order_id' => $unique_id , 'payer_id' => $payerid , 'payment_mode' =>  $mode); 
      $this->db->insert('webinar_orders',$data);
	}

	function get_banners(){

 

		$this->db->select('*');

    	$this->db->from('wb_banner');  

		$this->db->where('status','1');

		$query = $this->db->get();
 

	    return $query->result_array();

	}



	function get_dashboard_content(){

 
 
        $this->db->select('webinar_information.* '); 

        $this->db->from('webinar_information');              

        $this->db->where('created_by_userid', $_SESSION['edu_webinar']['userId']);
 

 
	    $query = $this->db->get();
	   

	        if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{
              
			    $user[] = $row;

			}
 
	        return $user;

	    }

 
	}


	function get_webinar_details_order($id){

         $this->db->select('webinar_information.* '); 

        $this->db->from('webinar_information');              

        $this->db->where('id', $id);

       // $this->db->where('created_by_userid', '522');


 
	    $query = $this->db->get();
	   

	        if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{
              
			    $user[] = $row;

			}
 
	        return $user;

	    }

	}

 function get_registration_content($pkg_id){

 	  $this->db->select('webinar_information.*  , wb_webinar_user.* , webinar_orders.*  '); 

        $this->db->from('webinar_orders');        

        $this->db->join('webinar_information','webinar_orders.package_id = webinar_information.id');  

        $this->db->join('wb_webinar_user','webinar_orders.user_id = wb_webinar_user.id');  

        // $this->db->where('webinar_orders.user_id', $_SESSION['edu_webinar']['userId']);

        $this->db->where('webinar_orders.package_id', $pkg_id);
 
 
	    $query = $this->db->get();
 

	        if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{
              
			    $user[] = $row;

			}
 
	        return $user;

	    }


 }


 function get_registration_history(){

 	  $this->db->select('webinar_information.*  , wb_webinar_user.* , webinar_orders.*  '); 

        $this->db->from('webinar_orders');        

        $this->db->join('webinar_information','webinar_orders.package_id = webinar_information.id');  

        $this->db->join('wb_webinar_user','webinar_information.created_by_userid = wb_webinar_user.id');  

        $this->db->where('webinar_orders.user_id', $_SESSION['edu_webinar']['userId']);

        // $this->db->where('webinar_orders.package_id', $pkg_id);
 
 
	    $query = $this->db->get();
 

	        if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{
              
			    $user[] = $row;

			}
 
	        return $user;

	    }


 }

	/**

	  * Method to insert banner 

      * @access public

      * @param $zoneId

      * @return $banners array

	*/

	function insert_banners($zoneId){

		$folderName = 'zone_'.$zoneId;

		$pathToUpload = './assets/educationalwebinar/banner/' . $folderName;

		$fileName = substr(rand(0,time()), 0, 6).$_FILES['userfile']['name'];       



		if (!file_exists($pathToUpload)){		     

			mkdir($pathToUpload , 0777, TRUE);

			mkdir($pathToUpload . '/thumbs', 0777, TRUE);

		}



		$config = array(

			'upload_path' => $pathToUpload,

			'allowed_types' => "gif|jpg|png|jpeg",

			'file_name' => $fileName,          

			'max_size' => "2048000", 

			'max_height' => "768",

			'max_width' => "1024"

		);

		$this->load->library('upload', $config);

		if($this->upload->do_upload()){ 	                     

           $img_data = array();

           $img_data = $this->upload->data();	           

           $data =array('zone_id' => $zoneId,'photo' => $fileName,'status' => 1); 

           return $this->db->insert('wb_banner',$data);

           //return $result;

	    }



	}


    function checkpackage($pid , $type){
 

        $this->db->select('webinar_information.* '); 

        $this->db->from('webinar_information');              

        $this->db->where('id', $pid);

         $this->db->where('room_type', $type);


	    $query = $this->db->get();

	    if ( $query->num_rows() > 0 )

	    {	        
           return true;

	    }else{
	    	return false;
	    }


    }

	  function owner_selected_option($zoneID){
      
        $this->db->select('wb_webinar_setting.* '); 

        $this->db->from('wb_webinar_setting');              

        $this->db->where('zone_id', $zoneID);

            $query = $this->db->get();

	        if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $user[] = $row;

			}

	        return $user;

	    }

	    

	  }

     function checkorder( $packageid , $userid){
 
        
        $this->db->select('webinar_orders.* '); 

        $this->db->from('webinar_orders');              

        $this->db->where('user_id', $userid);

        // if($from == 'paypal'){

        // 	 $this->db->where('payer_id', $payerid);
        // 	 $this->db->where('payment_mode', $from);
        // }
 
        $this->db->where('package_id', $packageid);

 
         // $this->db->where('purchased_on', date("Y-m-d"));

	    $query = $this->db->get();
 
	    if ( $query->num_rows() > 0 ){	   
  
           return true;

	    }else{

	    	return false;
	    }


    }


    function packageDetails($pid , $type){
 

        $this->db->select('webinar_information.* '); 

        $this->db->from('webinar_information');              

        $this->db->where('id', $pid);

        if($type){

           $this->db->where('room_type', $type);

        }

         


	    $query = $this->db->get();

	        if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $user[] = $row;

			}

	        return $user;

	    }


    }



	function change_banner_status($bannerId,$status){



		if($status == 1){

			$new_status = 0;

		}else{

			$new_status = 1;

		}



		$data = array(

			'status' => $new_status

		);



		$this->db->where('id',$bannerId);

		$result = $this->db->update('wb_banner',$data);



		if($result){



			return $new_status;

		}

	}



	/**

	  * Method to fetch about page content 

      * @access public

      * @param $zoneId

      * @return $aboutContent array

	*/

	function get_about_content(){



		$this->db->select('*');

    	$this->db->from('wb_cms');

    	//$this->db->where('zone_id',$zoneId);

	    $query = $this->db->get();

	    return $query->row();     

	}

	

	/**

	  * Method to update about page content 

      * @access public

      * @param $id

      * @return true

	*/

	function update_about_content($id){

		if($id !=''){

			$data =array('title' => $this->input->post('title'), 'details' => $this->input->post('details'), 'timestamp' => time()); 

			$this->db->where('id',$id);

			return $this->db->update('wb_cms',$data);

		}else{

			$data =array('zone_id' => $this->input->post('zone_id'), 'title' => $this->input->post('title'), 'details' => $this->input->post('details'), 'timestamp' => time()); 

			return $this->db->insert('wb_cms',$data);

		}		

	}





	/**

	  * Method to fetch logged in User name 

      * @access public

      * @param $user_id

      * @return $user array

	*/
 

    function get_userdata($user_id){



		$this->db->select('wb_webinar_user.*');

    	$this->db->from('wb_webinar_user');

    	$this->db->where('id',$user_id);



	    $query = $this->db->get();

	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $user[] = $row;

			}

	        return $user;

	    }

	}


	function get_username($user_id){



		$this->db->select('fname');

    	$this->db->from('wb_webinar_user');

    	$this->db->where('id',$user_id);



	    $query = $this->db->get();

	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $user[] = $row;

			}

	        return $user;

	    }

	}

	/**

	  * Method to fetch all categories in dropdown

      * @access public

      * @param 

      * @return $categories array

	*/

	function get_categories(){



		$this->db->select('*');

    	$this->db->from('wb_category');

    	

	    $query = $this->db->get();

	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $categories[] = $row;

			}

	        return $categories;

	    }

	}



	function get_presenter($related_id){



		$this->db->select('*');

    	$this->db->from('wb_presenter a');

    	$this->db->where('a.related_id',$related_id);

    	$this->db->where('a.status',1);



	    $query = $this->db->get();

	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $presenter[] = $row;

			}

	        return $presenter;

	    }

	}

	/**

	  * Method to fetch last three dates

      * @access public

      * @param 

      * @return $dates array

	*/

	function get_dates($zoneid){
 

		$this->db->select('webinar_information.* ,    wb_webinar_user.bus_id , wb_webinar_user.username as username ');

    	$this->db->from('webinar_information');

    	// $this->db->join('webinar_orders','webinar_orders.package_id = webinar_information.id'  , 'left');

    	  $this->db->join('wb_webinar_user','wb_webinar_user.id = webinar_information.created_by_userid'  , 'left');

   

    	$this->db->where('webinar_information.status', 1);
    	
        if($zoneid){
        	$this->db->where('webinar_information.zoneid', $zoneid);
        }
    	



	    $query = $this->db->get();

	    if ( $query->num_rows() > 0 )

	    {	        
           
           $i = 0;
	        foreach ($query->result() as $row)

			{  
			
					$this->db->select('webinar_orders.*  ');

                	$this->db->from('webinar_orders');

                	$this->db->where('package_id', $row->id);

	                $query = $this->db->get();

                	$countorders = $query->num_rows();
                    
                    $busname = '';
                    $common_logo_image = '';
                	if($row->bus_id){

                		$this->db->select('business.name  ,  business.common_logo_image ');

	                	$this->db->from('business');

	                	$this->db->where('id', $row->bus_id);

		                $query = $this->db->get();

	                	$busattr = $query->result();

	                	$busname = $busattr[0]->name;
	                	$common_logo_image = $busattr[0]->common_logo_image;


                	}


 
	 
 
			       // $dates[$i] = $row;
                   $dates[$i]['id'] = $row->id;
                   $dates[$i]['zoneid'] = $row->zoneid;
                   $dates[$i]['created_by_userid'] = $row->created_by_userid	;
                   $dates[$i]['link'] = $row->link;
                   $dates[$i]['description'] = $row->description;
                   $dates[$i]['status'] = $row->status;
                   $dates[$i]['joined_by_userid'] = $row->joined_by_userid;
                   $dates[$i]['type'] = $row->type;
                   $dates[$i]['start_time'] = $row->start_time;
                   $dates[$i]['end_time'] = $row->end_time;
                   $dates[$i]['timestamp'] = $row->timestamp;
                   $dates[$i]['room_type'] = $row->room_type;
                   $dates[$i]['recording_link'] = $row->recording_link;
                   $dates[$i]['webinarImage'] = $row->webinarImage;
                   $dates[$i]['totalpeople'] = $row->totalpeople;
                   $dates[$i]['price'] = $row->price;
                   $dates[$i]['paypal_id'] = $row->paypal_id;
                   $dates[$i]['busname'] = $busname;
                   $dates[$i]['username'] = $row->username;
                   $dates[$i]['common_logo_image'] = $common_logo_image;


			       $dates[$i]['totalcountorder'] = $countorders;
                   $i++;
			}
	 
	        return $dates;

	    }

	}



	/**

	  * Method to fetch all the webinar details 

      * @access public

      * @param $zoneid,$category,$date

      * @return $webinarInfo array

	*/



	function get_webinar_info($zoneid,$category,$date =''){



		$this->db->select('wb_webinar_class_info.*,wb_webinar_class_info.id as wbid,wb_webinar_class_info.information as wbinfo');

		$this->db->select('wb_presenter.*');

		$this->db->select('business.name as businessname');

        $this->db->from('wb_webinar_class_info');

        $this->db->join('wb_presenter','wb_webinar_class_info.presenter_id = wb_presenter.id');

        $this->db->join('business','wb_webinar_class_info.related_id = business.id');          

        $this->db->where('wb_webinar_class_info.zone_id', $zoneid);

        if($category!=""){

        	 $this->db->where('wb_webinar_class_info.category_id',$category);

        }

        if ($date!="") {

        	 $this->db->where('wb_webinar_class_info.timestamp',$date);

        }

        $this->db->order_by("wb_webinar_class_info.id", "asc");

        //$this->db->limit(3);

        

        $query = $this->db->get();



	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $content[] = array('info' => $row,'link' => $this-> getWebinarLink($row->wbid),'ratings'=> $this->getRating($row->wbid));

			    //$content[] = $row;			   

			}

		    /*echo "<pre>";

		    print_r($content);

		    echo "</pre>";

		    exit();*/

	        return $content;

	    }

	   

	}



	/*public function get_webinar_user_info(){



		$this->db->select('*');

		$this->db->from('wb_webinar_user');

		$query = $this->db->get();



		$wb_user = array();

	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $wb_user[] = $row;

			}

	        return $wb_user;

	    }

	}*/

	

	/**

	  * Method to fetch all the webinar link by webinar id

      * @access public

      * @param $webinarId

      * @return $webinarLink array

	*/

	public function getWebinarLink($webinarId) {

		

		$this->db->select('id,from_unixtime(timestamp) as item_date');

        $this->db->from('wb_webinar_item');

        $this->db->where('webinar_class_id',$webinarId);

        $this->db->group_by('MONTH(from_unixtime(timestamp)), YEAR(from_unixtime(timestamp))');



        $query = $this->db->get();

        return $query->result_array();



	}

	/**

	  * Method to fetch average rating by rating id

	  * @param $webinarId

	  * @return $ratingData

	*/

	public function getRating($webinarId =0) {

		if($webinarId ==0) {

			return;

		}

		$queryToFetchRating = "SELECT AVG(value) AS `rating` FROM `wb_webinar_rating` WHERE `class_id` = ".$webinarId;

		$query = $this->db->query($queryToFetchRating);

		return $query->row();

	}

	

	/**

	  * Method to auto register a user for Live Q&A Webinar

      * @access public

      * @param $webinar_class_id,$user_id

      * @return boolean

	*/

	function register_user($webinar_class_id,$user_id){		



		$conditions = array('webinar_class_id' => $webinar_class_id,'users_id' => $user_id);

		$this->db->where($conditions);

	    $query = $this->db->get('wb_webinar_user');



	    if ( $query->num_rows() > 0 ) 

	    {

	       return false;

	    } 

	    else {

	      

	       $data =array(

			'webinar_class_id' => $webinar_class_id,

			'webinar_items_id' => 0,

			'users_id' => $user_id,

			'status' => 1

			); 



		   $result = $this->db->insert('wb_webinar_user',$data);



		   if($result){

			  return true;

		    }

	    }		

		

	}

	

	/**

	  * Method to insert categories into database

	*/

	function insert_categories(){

		$data =array('name' => $this->input->post('category'),'status' => 1	); 

		return $this->db->insert('wb_category',$data);

	}





	function change_category_status($categoryId,$status){

		if($status == 1){

			$new_status = 0;

		}else{

			$new_status = 1;

		}



		$data = array(

			'status' => $new_status

		);

		$this->db->where('id',$categoryId);

		$result = $this->db->update('wb_category',$data);

		if($result){



			return $new_status;

		}

	}



	

	/**

	  * Method to insert presenter into database

	*/

	function insert_presenter(){



		$data =array(

			'related_id' => $this->input->post('business_id'),

			'name' => $this->input->post('presenter_name'),

			'information' => strip_tags($this->input->post('bio')),

			'status' => 1			

		); 

		return $this->db->insert('wb_presenter',$data);

	}



	/**

	  * Method to view presenter details

	*/

	function get_presenter_details($businessId){



		$presenter = array();

		$this->db->select('*');

    	$this->db->from('wb_presenter');

    	$this->db->where('related_id',$businessId);

	    $query = $this->db->get();

	    if($query->num_rows() > 0 ){     

	        foreach($query->result() as $row){

			    $presenter[] = $row;

			} 

	    }

	    return $presenter;

	}



	/**

	  * Method to status change of a presenter

	*/

	public function change_presenter_status($presenterId,$status){



		if($status == 1){

			$new_status = 0;

		}else{

			$new_status = 1;

		}



		$data = array(

			'status' => $new_status

		);



		$this->db->where('id',$presenterId);

		$result = $this->db->update('wb_presenter',$data);

		if($result){

			return $new_status;

		}

	}	



	public function insert_webinar($webinarData){



		$result = $this->db->insert('wb_webinar_item',$webinarData);



	    if($result){

	   		return true;

	    }



	}



	public function get_zone($relatedId){



		$this->db->select('settingszoneid');

    	$this->db->from('ads_setting_preferences');

    	$this->db->where('businessid',$relatedId);

    	

	    $query = $this->db->get();

	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $zone = $row->settingszoneid;

			}

	        return $zone;

	    }

	}



	public function get_webinar_details($relatedId){



		$this->db->select('c.name as category_name');

		$this->db->select('b.name as presenter_name');

		$this->db->select('a.*');

    	$this->db->from('wb_webinar_class_info a');

    	$this->db->join('wb_presenter b','a.presenter_id = b.id');

    	$this->db->join('wb_category c','a.category_id = c.id');

    	$this->db->where('a.related_id',$relatedId);

    	

	    $query = $this->db->get();

	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $webinarInfo[] = $row;

			}

	        return $webinarInfo;

	    }

	}





	function add_categories($name){



		$data =array(

			'name' => $name,

			'status' => 1			

			); 



		   $result = $this->db->insert('wb_category',$data);



		   if($result){

		   		return true;

		   }

	}





	function update_categories($id,$name){



		$data =array(

			'name' => $name

				

			); 



		   $this->db->where('id',$id);

		   $result = $this->db->update('wb_category',$data);



		   if($result){

		   		return true;

		   }else{

		   		return false;

		   }

	}



	function delete_categories($id){



		$this->db->where('id', $id);

		$result = $this->db->delete('wb_category');

		

		if($result){

		   		return true;

		   }else{



		   	return false;

		   }

	}



	function insert_class($classData){





		$result = $this->db->insert('wb_webinar_class_info',$classData);



	    if($result){

	   		return true;

	    }

	}



	function get_class_details($id){



		$this->db->select('wb_category.name as category_name');

		$this->db->select('wb_presenter.name as presenter_name');

		$this->db->select('wb_webinar_class_info.*');

    	$this->db->from('wb_webinar_class_info');

    	$this->db->join('wb_presenter','wb_webinar_class_info.presenter_id = wb_presenter.id');

    	$this->db->join('wb_category','wb_webinar_class_info.category_id = wb_category.id');

		$this->db->where('wb_webinar_class_info.id',$id);

		$query = $this->db->get();



		if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $classInfo[] = $row;

			}

	        return $classInfo;

	    }

	}



	function update_class($id,$classData){



		   $this->db->where('id',$id);

		   $result = $this->db->update('wb_webinar_class_info',$classData);



		   if($result){

		   		return true;

		   }else{

		   		return false;

		   }



	}



	function get_all_class($loggedInType,$id){



		if($loggedInType == 'business'){

			$loggedInType = 1;

		}else{

			$loggedInType = 2;

		}

		$this->db->select('*');		

    	$this->db->from('wb_webinar_class_info a');

    	$this->db->where('a.related_id',$id);

    	$this->db->where('a.related_type',$loggedInType);    	

		$query = $this->db->get();



		if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $classInfo[] = $row;

			}

	        return $classInfo;

	    }

	}



	function get_webinar_items($loggedInType,$id){



		$this->db->select('wb_webinar_class_info.class_name as class_name');

		$this->db->select('wb_webinar_item.*');

    	$this->db->from('wb_webinar_item');

    	$this->db->join('wb_webinar_class_info','wb_webinar_item.webinar_class_id = wb_webinar_class_info.id');

    	if($loggedInType == 'business'){

    		$this->db->where('wb_webinar_class_info.related_id',$id);

    	}else if($loggedInType == 'zone'){

    		$this->db->where('wb_webinar_class_info.zone_id',$id);

    	}

    	

    	

	    $query = $this->db->get();

	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $webinarInfo[] = $row;

			}

	        return $webinarInfo;

	    }



	}



	function get_webinar_details_by_id($id){



		$this->db->select('wb_webinar_class_info.class_name as class_name');

		$this->db->select('wb_webinar_item.*');

    	$this->db->from('wb_webinar_item');

    	$this->db->join('wb_webinar_class_info','wb_webinar_item.webinar_class_id = wb_webinar_class_info.id');

    	$this->db->where('wb_webinar_item.id',$id);

    	

	    $query = $this->db->get();

	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $webinarInfo[] = $row;

			}

	        return $webinarInfo;

	    }

	}



	function update_webinar($id,$webinarData){



		$this->db->where('id',$id);

	    $result = $this->db->update('wb_webinar_item',$webinarData);



	    if($result){

	   		return true;

	    }else{

	   		return false;

	    }

	}



	function webinar_data_status($status,$id,$loggedInType){



		$this->db->select('wb_webinar_class_info.class_name as class_name,business.name as business_name');

		$this->db->select('wb_webinar_item.*');

    	$this->db->from('wb_webinar_class_info');

    	$this->db->join('wb_webinar_item','wb_webinar_item.webinar_class_id = wb_webinar_class_info.id');

    	$this->db->join('business','business.id = wb_webinar_class_info.related_id');

    	if($status !=-1) {

    		$this->db->where('wb_webinar_item.status',$status);

    	}

    	if($loggedInType == 'business'){

    		$this->db->where('wb_webinar_class_info.related_id',$id);

    	}else if($loggedInType == 'zone'){

    		$this->db->where('wb_webinar_class_info.zone_id',$id);

    	}

    	



    	$query = $this->db->get();

	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $statusInfo[] = $row;

			}

	        return $statusInfo;

	    }

	}



	function change_wbinar_status($webinarId,$status,$shortenUrl){



		if($status == 1){

			$new_status = 2;

		}else if($status == 2){

			$new_status = 1;

		}else if($status == 0){

			$new_status = 1;

		}



		$data = array(

			'status' => $new_status,

			'trackable_link' => $shortenUrl

		);



		$this->db->where('id',$webinarId);

		$result = $this->db->update('wb_webinar_item',$data);



		if($result){



			return $new_status;

		}



	}



	function get_webinar_business($zoneId){



		$this->db->distinct();

		$this->db->select('business.name as business_name,business.id as business_id');

		$this->db->from('business');

		$this->db->join('wb_webinar_class_info','wb_webinar_class_info.related_id = business.id');

		$this->db->where('wb_webinar_class_info.zone_id',$zoneId);		

		$query = $this->db->get();



	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $business[] = $row;

			}

	        return $business;

	    }

	}



	function class_by_business($businessId){



		$this->db->select('id,class_name');

		$this->db->from('wb_webinar_class_info');		

		$this->db->where('related_id',$businessId);		

		$query = $this->db->get();



	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $class[] = $row;

			}

	        return $class;

	    }

	}



	function get_webinar_users($classId){



		$this->db->select('users.first_name,users.id');

		$this->db->from('users');

		$this->db->join('wb_webinar_user','wb_webinar_user.users_id = users.id');

		$this->db->where('wb_webinar_user.webinar_class_id',$classId);		

		$query = $this->db->get();



	    if ( $query->num_rows() > 0 )

	    {	        

	        foreach ($query->result() as $row)

			{

			    $users[] = $row;

			}

	        return $users;

	    }

	}



	function get_user_email($userId){



		$this->db->select('email');

		$this->db->from('users');		

		$this->db->where('id',$userId);		

		$query = $this->db->get();



	    $result = $query->row();

		return $result->email;

	}



	function get_business_email($businessId){



		$this->db->select('users.email');

		$this->db->from('users');

		$this->db->join('business','business.business_owner_id = users.id');

		$this->db->where('business.id',$businessId);		

		$query = $this->db->get();



		$result = $query->row();

		return $result->email;

	}



	

	######################################################################

}

?>