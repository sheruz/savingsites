<?php
namespace App\Models;

use CodeIgniter\Model;
#[\AllowDynamicProperties]
class Ion_auth_model extends Model
{
	
 

 
	/**

	 * Holds an array of tables used

	 *

	 * @var string

	 **/
 
	public $tables = array();


	/**

	 * activation code

	 *

	 * @var string

	 **/



	public $activation_code;

 
	/**

	 * forgotten password key



	 *



	 * @var string



	 **/



	public $forgotten_password_code;



	/**

	 * new password

	 *

	 * @var string

	 **/

	public $new_password;
 
	/**



	 * Identity



	 *



	 * @var string



	 **/



	public $identity;







	/**



	 * Where



	 *



	 * @var array



	 **/



	public $_ion_where = array();







	/**



	 * Select



	 *



	 * @var string



	 **/



	public $_ion_select = array();







	/**



	 * Limit



	 *



	 * @var string



	 **/



	public $_ion_limit = NULL;







	/**



	 * Offset



	 *



	 * @var string



	 **/



	public $_ion_offset = NULL;







	/**



	 * Order By



	 *



	 * @var string



	 **/



	public $_ion_order_by = NULL;







	/**



	 * Order



	 *



	 * @var string



	 **/



	public $_ion_order = NULL;







	/**



	 * Hooks



	 *



	 * @var object



	 **/



	protected $_ion_hooks;







	/**



	 * Response



	 *



	 * @var string



	 **/



	protected $response = NULL;







	/**



	 * message (uses lang file)



	 *



	 * @var string



	 **/



	protected $messages;







	/**



	 * error message (uses lang file)



	 *



	 * @var string



	 **/



	protected $errors;







	/**



	 * error start delimiter



	 *



	 * @var string



	 **/



	protected $error_start_delimiter;







	/**



	 * error end delimiter



	 *



	 * @var string



	 **/



	protected $error_end_delimiter;







	public function __construct()



	{

		$this->db = \Config\Database::connect();

		parent::__construct();



		$this->load->database();



		$this->load->config('ion_auth', TRUE);



		$this->load->helper('cookie');



		$this->load->helper('date');



		$this->load->library('session');



		$this->lang->load('ion_auth');







		//initialize db tables data



		$this->tables  = $this->config->item('tables', 'ion_auth');







		//initialize data



		$this->identity_column = $this->config->item('identity', 'ion_auth');



		$this->identity_column_zone = $this->config->item('identityzone', 'ion_auth');

		

		$this->identity_column_business = $this->config->item('identitybusiness', 'ion_auth');

		

		$this->identity_column_org = $this->config->item('identityorg', 'ion_auth');

		

		$this->identity_column_user = $this->config->item('identityuser', 'ion_auth');



		$this->store_salt      = $this->config->item('store_salt', 'ion_auth');



		$this->salt_length     = $this->config->item('salt_length', 'ion_auth');



		$this->join			   = $this->config->item('join', 'ion_auth');




		//initialize hash method options (Bcrypt)



		$this->hash_method = $this->config->item('hash_method', 'ion_auth');	



		$this->default_rounds = $this->config->item('default_rounds', 'ion_auth');			



		$this->random_rounds = $this->config->item('random_rounds', 'ion_auth');



		$this->min_rounds = $this->config->item('min_rounds', 'ion_auth');				



		$this->max_rounds = $this->config->item('max_rounds', 'ion_auth');	



		
		//initialize messages and error



		$this->messages = array();



		$this->errors = array();



		$this->message_start_delimiter = $this->config->item('message_start_delimiter', 'ion_auth');



		$this->message_end_delimiter   = $this->config->item('message_end_delimiter', 'ion_auth');



		$this->error_start_delimiter   = $this->config->item('error_start_delimiter', 'ion_auth');



		$this->error_end_delimiter     = $this->config->item('error_end_delimiter', 'ion_auth');







		//initialize our hooks object



		$this->_ion_hooks = new stdClass;







		//load the bcrypt class if needed



		if ($this->hash_method == 'bcrypt') {



			if ($this->random_rounds)



			{



				$rand = rand($this->min_rounds,$this->max_rounds);



				$rounds = array('rounds' => $rand);



			}



			else



			{



				$rounds = array('rounds' => $this->default_rounds);



			}







			$this->load->library('bcrypt',$rounds);



		}



		



		$this->trigger_events('model_constructor');



	}



	



	/**



	 * Misc functions



	 *



	 * Hash password : Hashes the password to be stored in the database.



	 * Hash password db : This function takes a password and validates it



	 * against an entry in the users table.



	 * Salt : Generates a random salt value.



	 *



	 * @author Mathew



	 */







    public function update_user_ex($id, $first, $last, $email, $phone, $address, $city, $state,$zip)



    {



       $data = array(



            'first_name' => $first,



            'last_name' => $last,



            'email' => $email,



            'phone' => $phone,



            'Address' => $address,



            'City' => $city,



            'State_Code' => $state,



            'Zip' => $zip



        );







        $this->db->update('users', $data, array('id' => $id));







        $return = $this->db->affected_rows() == 1;



        if ($return)



        {



            $this->set_message('user update successful');



        }



        else



        {



            $this->set_error('user update unsuccessful');



        }







        return $return;







    }



    public function update_user($id,$first, $last, $email)



    {



        $data = array(



            'first_name' => $first,



            'last_name' => $last,



            'email' => $email



        );







        $this->db->update('users', $data, array('id' => $id));







        $return = $this->db->affected_rows() == 1;



        if ($return)



        {



            $this->set_message('user update successful');



        }



        else



        {



            $this->set_error('user update unsuccessful');



        }







        return $return;



    }



	/**



	 * Hashes the password to be stored in the database.



	 *



	 * @return void



	 * @author Mathew



	 **/



	public function hash_password($password, $salt=false, $use_sha1_override=FALSE)



	{



		if (empty($password))



		{



			return FALSE;



		}



		//var_dump($salt); exit;



		//bcrypt



		if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt')



		{



			return $this->bcrypt->hash($password);



		}











		if ($this->store_salt && $salt)



		{



			return  sha1($password . $salt);



		}



		else



		{



			$salt = $this->salt();

			

			return  $salt . substr(sha1($salt . $password), 0, -$this->salt_length);



		}



	}







	/**



	 * This function takes a password and validates it



	 * against an entry in the users table.



	 *



	 * @return void



	 * @author Mathew



	 **/



	public function hash_password_db($id, $password, $use_sha1_override=FALSE)



	{



		if (empty($id) || empty($password))



		{



			return FALSE;



		}







		$this->trigger_events('extra_where');







		$query = $this->db->select('password, salt')



		                  ->where('id', $id)



		                  ->limit(1)



		                  ->get($this->tables['users']);







		$hash_password_db = $query->row();





		//echo $this->db->last_query(); exit;

		if ($query->num_rows() !== 1)



		{



			return FALSE;



		}







		// bcrypt



		if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt')



		{ 



			if ($this->bcrypt->verify($password,$hash_password_db->password))



			{



				return TRUE;



			}



			



			return FALSE;



		}







		// sha1



		if ($this->store_salt)



		{ 

 

			$db_password = sha1($password . $hash_password_db->salt);



		}



		else



		{ 



			$salt = substr($hash_password_db->password, 0, $this->salt_length);



			



			$db_password =  $salt . substr(sha1($salt . $password), 0, -$this->salt_length);



		}







		if($db_password == $hash_password_db->password)



		{



			return TRUE;



		}



		else



		{



			return FALSE;



		}



	}







	/**



	 * Generates a random salt value for forgotten passwords or any other keys. Uses SHA1.



	 *



	 * @return void



	 * @author Mathew



	 **/



	public function hash_code($password)



	{



		return $this->hash_password($password, FALSE, TRUE);



	}







	/**



	 * Generates a random salt value.



	 *



	 * @return void



	 * @author Mathew



	 **/



	public function salt()



	{



		return substr(md5(uniqid(rand(), true)), 0, $this->salt_length);



	}







	/**



	 * Activation functions



	 *



	 * Activate : Validates and removes activation code.



	 * Deactivae : Updates a users row with an activation code.



	 *



	 * @author Mathew



	 */







	/**



	 * activate



	 *



	 * @return void



	 * @author Mathew



	 **/



	public function activate($id, $code = false)



	{



		$this->trigger_events('pre_activate');







		if ($code !== FALSE)



		{



			$query = $this->db->select($this->identity_column)



			                  ->where('activation_code', $code)



			                  ->limit(1)



			                  ->get($this->tables['users']);







			$result = $query->row();







			if ($query->num_rows() !== 1)



			{



				$this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));



				$this->set_error('activate_unsuccessful');



				return FALSE;



			}







			$identity = $result->{$this->identity_column};







			$data = array(



			    'activation_code' => NULL,



			    'active'          => 1



			);







			$this->trigger_events('extra_where');



			$this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));



		}



		else



		{



			$data = array(



			    'activation_code' => NULL,



			    'active'          => 1



			);











			$this->trigger_events('extra_where');



			$this->db->update($this->tables['users'], $data, array('id' => $id));



		}











		$return = $this->db->affected_rows() == 1;



		if ($return)



		{



			$this->trigger_events(array('post_activate', 'post_activate_successful'));



			$this->set_message('activate_successful');



		}



		else



		{



			$this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));



			$this->set_error('activate_unsuccessful');



		}











		return $return;



	}











	/**



	 * Deactivate



	 *



	 * @return void



	 * @author Mathew



	 **/



	public function deactivate($id = NULL)



	{



		$this->trigger_events('deactivate');







		if (!isset($id))



		{



			$this->set_error('deactivate_unsuccessful');



			return FALSE;



		}







		$activation_code       = sha1(md5(microtime()));



		$this->activation_code = $activation_code;







		$data = array(



		    'activation_code' => $activation_code,



		    'active'          => 0



		);







		$this->trigger_events('extra_where');



		$this->db->update($this->tables['users'], $data, array('id' => $id));







		$return = $this->db->affected_rows() == 1;



		if ($return)



			$this->set_message('deactivate_successful');



		else



			$this->set_error('deactivate_unsuccessful');







		return $return;



	}







	public function clear_forgotten_password_code($code) {



		



		if (empty($code))



		{



			return FALSE;



		}



		



		$this->db->where('forgotten_password_code', $code);







		if ($this->db->count_all_results($this->tables['users']) > 0)



		{



			$data = array(



			    'forgotten_password_code' => NULL,



			    'forgotten_password_time' => NULL



			);







			$this->db->update($this->tables['users'], $data, array('forgotten_password_code' => $code));



			



			return TRUE;



		}



		



		return FALSE;



	}







	/**



	 * reset password



	 *



	 * @return bool



	 * @author Mathew



	 **/



	public function reset_password($identity, $new) {



		$this->trigger_events('pre_change_password');







		if (!$this->identity_check($identity)) {



			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));



			return FALSE;



		}



		



		$this->trigger_events('extra_where');







		$query = $this->db->select('id, password, salt')



		                  ->where($this->identity_column, $identity)



		                  ->limit(1)



		                  ->get($this->tables['users']);



		



		if ($query->num_rows() !== 1)



		{



			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));



			$this->set_error('password_change_unsuccessful');



			return FALSE;



		}







		$result = $query->row();



		



		$new = $this->hash_password($new, $result->salt);



		



		//store the new password and reset the remember code so all remembered instances have to re-login



		//also clear the forgotten password code



		$data = array(



		    'password' => $new,



		    'remember_code' => NULL,



		    'forgotten_password_code' => NULL,



		    'forgotten_password_time' => NULL,



		);







		$this->trigger_events('extra_where');



		$this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));







		$return = $this->db->affected_rows() == 1;



		if ($return)



		{



			$this->trigger_events(array('post_change_password', 'post_change_password_successful'));



			$this->set_message('password_change_successful');



		}



		else



		{



			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));



			$this->set_error('password_change_unsuccessful');



		}







		return $return;



	}







	/**



	 * change password



	 *



	 * @return bool



	 * @author Mathew



	 **/



	public function change_password($identity, $old, $new)



	{

	 
		$this->trigger_events('pre_change_password');

 

		$this->trigger_events('extra_where');


 
		$query = $this->db->select('id, password, salt')



		                  ->where($this->identity_column, $identity)



		                  ->limit(1)



		                  ->get($this->tables['users']);



		//echo $this->db->last_query();

		if ($query->num_rows() !== 1)



		{

			

			$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));

 

            $this->set_error('password_change_unsuccessful');



			return FALSE;



		}







		$result = $query->row();


		$db_password = $result->password;									//var_dump('db_password=='.$db_password);



		$old         = $this->hash_password_db($result->id, $old);			//var_dump('old=='.$old); 



		$new         = $this->hash_password($new, $result->salt);			//var_dump('new=='.$new); 







		if ($old === TRUE)



		{



			//store the new password and reset the remember code so all remembered instances have to re-login



			$data = array(



			    'password' => $new,



			    'remember_code' => NULL,

				

				'uploaded_business_password' => '',



			);







			$this->trigger_events('extra_where');



			$this->db->update($this->tables['users'], $data, array($this->identity_column => $identity));



			$return = $this->db->affected_rows() == 1;



			if ($return)



			{				

				$this->trigger_events(array('post_change_password', 'post_change_password_successful'));



				$this->set_message('password_change_successful');

			

			}



			else



			{



				$this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));



				$this->set_error('password_change_unsuccessful');



			}



			return $return;



		}

		
 


		$this->set_error('password_change_unsuccessful');



		return FALSE;



	}







	/**



	 * Checks username



	 *



	 * @return bool



	 * @author Mathew



	 **/



	public function username_check($username = '')



	{



		$this->trigger_events('username_check');







		if (empty($username))



		{



			return FALSE;



		}







		$this->trigger_events('extra_where');







		return $this->db->where('username', $username)



		                ->count_all_results($this->tables['users']) > 0;



	}







	/**



	 * Checks email



	 *



	 * @return bool



	 * @author Mathew



	 **/



	public function email_check($email = '')



	{



		$this->trigger_events('email_check');







		if (empty($email))



		{



			return FALSE;



		}







		$this->trigger_events('extra_where');







		return $this->db->where('email', $email)



		                ->count_all_results($this->tables['users']) > 0;



	}







	/**



	 * Identity check



	 *



	 * @return bool



	 * @author Mathew



	 **/



	public function identity_check($identity = '')



	{



		$this->trigger_events('identity_check');







		if (empty($identity))



		{



			return FALSE;



		}







		return $this->db->where($this->identity_column, $identity)



		                ->count_all_results($this->tables['users']) > 0;



	}







	/**



	 * Insert a forgotten password key.



	 *



	 * @return bool



	 * @author Mathew



	 * @updated Ryan



	 **/



	public function forgotten_password($identity,$usertype)
   
	{
       die('here2');

		$identity = "'".$identity."'";

		$identity_column_x = 'username';	 

 
	   $sql="SELECT a.id FROM users a, users_groups b  WHERE a.id=b.user_id AND b.group_id=".$usertype." AND $identity_column_x=".$identity; 

		$query = $this->db->query($sql);

    	if($query->row())

    	{

    		$id = $query->row()->id;

    	}else{

    		return false;

    	}


		if (empty($identity))



		{

			$this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_unsuccessful'));

			return FALSE;

		}





		$key = $this->hash_code(microtime().$identity);



		$this->forgotten_password_code = $key;



		$this->trigger_events('extra_where');


		$update = array(

		    'forgotten_password_code' => $key,

		    'forgotten_password_time' => time()

		);


		$this->db->update($this->tables['users'], $update, array('id' => $id));

		$return = $this->db->affected_rows() == 1;


		if ($return){
			$this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_successful'));
		}else{
			$this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_unsuccessful'));
        }

 
		return $return;



	}







	/**



	 * Forgotten Password Complete



	 *



	 * @return string



	 * @author Mathew



	 **/



	public function forgotten_password_complete($code, $salt=FALSE)



	{


		$this->trigger_events('pre_forgotten_password_complete');

		if (empty($code))
		{
			$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
			return FALSE;

		}



		$profile = $this->where('forgotten_password_code', $code)->users()->row(); 







		if ($profile) {


			if ($this->config->item('forgot_password_expiration', 'ion_auth') > 0) {



				//Make sure it isn't expired



				$expiration = $this->config->item('forgot_password_expiration', 'ion_auth');



				if (time() - $profile->forgotten_password_time > $expiration) {



					//it has expired



					$this->set_error('forgot_password_expired');



					$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));



					return FALSE;



				}



			}



			$password = $this->salt();


			$data = array(

			    'password'                => $this->hash_password($password, $salt),

			    'forgotten_password_code' => NULL,

			    'active'                  => 1,

			 );




			$this->db->update($this->tables['users'], $data, array('forgotten_password_code' => $code));



			$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_successful'));



			return $password;



		}







		$this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));



		return FALSE;



	}



	



	



	/*public function change_password($userid,$password){



	$salt       = $this->store_salt ? $this->salt() : FALSE;



	$password   = $this->hash_password($password, $salt);



	



	



	$data = array(



		    'password'   => $password		    



	);



	



	if ($this->store_salt)



	{



		$data['salt'] = $salt;



	}



	



	$this->db->where('id', $userid);







    $this->db->update('users', $userData);



	



}*/



	



	



	



	/**



	 * register



	 *



	 * @return bool



	 * @author Mathew



	 **/


	public function registerreferal($username, $password, $email, $additional_data = array(), $groups = array(), $userid_for_registration='', $emailnotice_phone='' , $carrier='',$cellPhone='',$referraluser='',$zone_id='')  // Added $emailnotice_phone & $carrier in the last on 28/5/14



	{

		
		

		$this->trigger_events('pre_register');





		$ip_address = $this->_prepare_ip($this->input->ip_address());



		$salt       = $this->store_salt ? $this->salt() : FALSE;



		$password   = $this->hash_password($password, $salt);






		$data = array(



		    'username'   => $username,



		    'password'   => $password,



		    'email'      => $email,

	 

			'phone'		=> $additional_data['phone'],	



			'cell_phone' =>	$cellPhone,				// Added 'phone'=> $emailnotice_phone on 28/5/14



		    'carrier'	=> $carrier,       // Added 'phone'=> $emailnotice_phone on 29/5/14 for text messages

			

			'ip_address' => $ip_address,



		    'created_on' => time(),



		    'last_login' => time(),

 

			'active' =>1,

			

			'company' => $additional_data['company'],

			

			'status'     => 0,


			'referral_code' =>$referraluser,

			'Zone_ID'=>$zone_id



		);

 

		if ($this->store_salt)



		{



			$data['salt'] = $salt;



		}
 

		//filter out any data passed that doesnt have a matching column in the users table

		//and merge the set user data and the additional data

 

		$user_data = array_merge($this->_filter_data($this->tables['users'], $additional_data), $data);

 

		$this->trigger_events('extra_set');

 

		if($userid_for_registration=='')

		{ 	 

			$this->db->insert($this->tables['users'], $user_data);

			$id = $this->db->insert_id();

		}

		else if($userid_for_registration !='')

		{ 											 

			$this->db->where('id', $userid_for_registration);

            $this->db->update('users', $user_data);

			$id = $userid_for_registration;

		}

		if(!empty($groups))

		{	

	

			foreach ($groups as $group)

			{	

				$this->add_to_group($group, $id);

			}

		

		}






		$this->trigger_events('post_register');







		return (isset($id)) ? $id : FALSE;

	}
 





	public function register($username, $password, $email, $additional_data = array(), $groups = array(), $userid_for_registration='', $emailnotice_phone='' , $carrier='',$cellPhone='',$fromwhere='',$refer_code = ''){  
		die("dvsd");
		$user_ID = $db->table('users')->select('id')->where('refer_code_link', $refer_code);
		echo "<pre>";print_r($user_ID);die;





		$this->db->select('id');
    	$this->db->from('users');
    	$this->db->where(['refer_code_link' => $refer_code]);
    	$user_ID = $this->db->get()->row()->id;
    	$this->db->select('free_cert');
    	$this->db->from('users');
    	$this->db->where(['refer_code_link' => $refer_code]);
    	$free_certrecord = $this->db->get()->row()->free_cert;
    	$userid = isset($user_ID)?$user_ID:'';
    	if($refer_code !=''){
    		$free_cert = $free_certrecord+1;
    	}else{
    		$free_cert = 0;
    	}
    	echo "here2";
		/*get  refer user id*/
		$this->trigger_events('pre_register');
		$ip_address = $this->_prepare_ip($this->input->ip_address());
		$salt       = $this->store_salt ? $this->salt() : FALSE;
		$password   = $this->hash_password($password, $salt);
		$data = array(
			'username'   => $username,
			'password'   => $password,
			'email'      => $email, 
			'phone'		 => $additional_data['phone'],	
			'alternate_phone' => $additional_data['alternate_phone'],	
			'cell_phone' =>	$cellPhone,		 
			'carrier'	 => $carrier,       			
			'ip_address' => $ip_address,
			'created_on' => time(),
			'last_login' => time(), 
			'active'     =>1,			
			'company'    => $additional_data['company'],			
			'status'     => 0,
			'from_user_refer' => $userid,
			'free_cert' => $free_cert,
			'user_from'  => strval($fromwhere),
			'user_from'  => strval($fromwhere),
			'user_from'  => strval($fromwhere),
		);
		echo "here3";
		if ($this->store_salt){
			$data['salt'] = $salt;
		}
		//filter out any data passed that doesnt have a matching column in the users table
		//and merge the set user data and the additional data
		$user_data = array_merge($this->_filter_data($this->tables['users'], $additional_data), $data);
		$this->trigger_events('extra_set');
		if($userid_for_registration==''){ 	 
			$this->db->insert($this->tables['users'], $user_data);
			$id = $this->db->insert_id();
		}else if($userid_for_registration !=''){ 											 
			$this->db->where('id', $userid_for_registration);
			$this->db->update('users', $user_data);
			$id = $userid_for_registration;
		}
		echo "here4";
		if(!empty($groups)){	
			foreach ($groups as $group){	
				$this->add_to_group($group, $id);
			}
		}
		echo "here6";
		$this->trigger_events('post_register');
		echo "<pre>";print_r($id);die;
		return (isset($id)) ? $id : FALSE;
	}







	/**

	 * login

	 * @return bool

	 * @author Mathew

	 **/



	public function login($identity, $password, $remember=FALSE){
		$this->trigger_events('pre_login');
		if (empty($identity) || empty($password)){
			$this->set_error('login_unsuccessful');
			return FALSE;
		}
		
		$this->trigger_events('extra_where');
		if($password =='change'){
			$sql="SELECT username, email, id, password, active, last_login, first_name, last_name FROM users WHERE username='$identity' and uploaded_business_password='$password'"; 
			$query = $this->db->query($sql);
			if($query->num_rows() == 0){
				$sql="SELECT username, email,id,active, last_login FROM users WHERE username='$identity'"; 
				$query = $this->db->query($sql);
				$user = $query->row(); 
				$usersId = $user->id;
			}
		}else{
			if (!filter_var($this->db->escape_str($identity), FILTER_VALIDATE_EMAIL)) {
		  		$identity_column = "username";
			}else{
		  		$identity_column = "email";
			}
			
			$query = $this->db->select($identity_column . ', username, email, id, password, active, last_login, first_name, last_name')
				->where($identity_column, $this->db->escape_str($identity))
				->limit(1)
				->get($this->tables['users']);
		}
		
		log_message('custom', '<br/>------------------------ LOGIN QUERY START ---------------------------------- <br/>');
		log_message('custom', $sql);
		log_message('custom', '<br/>------------------------------------ LOGIN QUERY END -------------------------------- <br/>');
		if ($query->num_rows() === 1 || $usersId!= ''){
			$user = $query->row(); 
			log_message('custom', '<br/>----------------------------------- LOGIN USER DETAILS START ---------------------------------- <br/>');
			log_message('custom', json_encode($user));
			log_message('custom', '<br/>------------------------------------ LOGIN  LOGIN USER DETAILS END -------------------------------- <br/>');
			
			if($password =='change'){
				$password = TRUE;
			}else{
				$password = $this->hash_password_db($user->id, $password);
			}
			
			log_message('custom', '<br/>----------------------------------- HASH PASSWORD START---------------------------------- <br/>');
			log_message('custom', $password);
			log_message('custom', '<br/>------------------------------------ HASH PASSWORD END-------------------------------- <br/>');
			
			if ($password === TRUE){
				if ($user->active == 0){	
					$this->trigger_events('post_login_unsuccessful');
					$this->set_error('login_unsuccessful_not_active');
					return FALSE;
				}
				
				$session_data = array(
					'identity' => $user->{$this->identity_column},
					'username' => $user->username,
					'email'    => $user->email,
					'user_id'  => $user->id,
					'old_last_login' => $user->last_login
				);
				
				log_message('custom', '<br/>----------------------------------- session_data START---------------------------------- <br/>');
				log_message('custom', json_encode($session_data));
				log_message('custom', '<br/>------------------------------------ LOGIN QUERY END-------------------------------- <br/>');
				
				$this->update_last_login($user->id);
				$this->clear_login_attempts($identity);
				$this->session->set_userdata($session_data);
				
				if ($remember && $this->config->item('remember_users', 'ion_auth')){
					$this->remember_user($user->id);
				}
				
				$this->trigger_events(array('post_login', 'post_login_successful'));
				$this->set_message('login_successful');	
				return TRUE;
			}
		}
		
		$this->hash_password($password);
		$this->increase_login_attempts($identity);
		$this->trigger_events('post_login_unsuccessful');
		$this->set_error('login_unsuccessful');
		return FALSE;
	}





public function login_event_fromsocial($username,$email,$from)
	{

 

		    $sql="SELECT users.* , users_groups.group_id  FROM users inner join users_groups on users_groups.user_id = users.id  where users.username LIKE '%".$username."' and users.email='".$email."' and users.user_from='".$from."'"; 

			$query=$this->db->query($sql);

			$result=$query->result_array();

  


		if (count($result) === 1 || $usersId!= '')
 
		{
 
				$session_data = array(

				    'identity'             => $user->{$this->identity_column},

				    'username'             => $result[0]['username'],

				    'email'                => $result[0]['email'],

				    'user_id'              => $result[0]['id'], //everyone likes to overwrite id so we'll use user_id

				    'old_last_login'       => $result[0]['last_login']

				);



                 if($result[0]['group_id'] == 10){
                 	 $_SESSION['session_normal_user_in_zone']['sesusertype'] = 'resident_user';
                 }
	 
			 
 
 

				$this->update_last_login($result[0]['id']);


 
				$this->session->set_userdata($session_data);


 


				$this->trigger_events(array('post_login', 'post_login_successful'));



				$this->set_message('login_successful');

 

				return TRUE;



	 



		}else{

			    $this->trigger_events('post_login_unsuccessful');



				$this->set_error('login_unsuccessful');


				return false;



		}

 

	}










	/**



	 * is_max_login_attempts_exceeded



	 * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)



	 * 



	 * @param string $identity



	 * @return boolean



	 **/



	public function is_max_login_attempts_exceeded($identity) {



		if ($this->config->item('track_login_attempts', 'ion_auth')) {



			$max_attempts = $this->config->item('maximum_login_attempts', 'ion_auth');



			if ($max_attempts > 0) {



				$attempts = $this->get_attempts_num($identity);



				return $attempts >= $max_attempts;



			}



		}



		return FALSE;



	}







	/**



	 * Get number of attempts to login occured from given IP-address or identity



	 * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)



	 * 



	 * @param	string $identity



	 * @return	int



	 */



	function get_attempts_num($identity)



	{



		if ($this->config->item('track_login_attempts', 'ion_auth')) {



			$ip_address = $this->_prepare_ip($this->input->ip_address());;



			



			$this->db->select('1', FALSE);



			$this->db->where('ip_address', $ip_address);



			if (strlen($identity) > 0) $this->db->or_where('login', $identity);







			$qres = $this->db->get($this->tables['login_attempts']);



			return $qres->num_rows();



		}



		return 0;



	}







	/**



	 * increase_login_attempts



	 * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)



	 * 



	 * @param string $identity



	 **/



	public function increase_login_attempts($identity) {



		if ($this->config->item('track_login_attempts', 'ion_auth')) {



			$ip_address = $this->_prepare_ip($this->input->ip_address());



			return $this->db->insert($this->tables['login_attempts'], array('ip_address' => $ip_address, 'login' => $identity, 'time' => time()));



		}



		return FALSE;



	}







	/**



	 * clear_login_attempts



	 * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)



	 * 



	 * @param string $identity



	 **/



	public function clear_login_attempts($identity, $expire_period = 86400) {



		if ($this->config->item('track_login_attempts', 'ion_auth')) {



			$ip_address = $this->_prepare_ip($this->input->ip_address());



			



			$this->db->where(array('ip_address' => $ip_address, 'login' => $identity));



			// Purge obsolete login attempts



			$this->db->or_where('time <', time() - $expire_period, FALSE);







			return $this->db->delete($this->tables['login_attempts']);



		}



		return FALSE;



	}







	public function limit($limit)



	{



		$this->trigger_events('limit');



		$this->_ion_limit = $limit;







		return $this;



	}







	public function offset($offset)



	{



		$this->trigger_events('offset');



		$this->_ion_offset = $offset;







		return $this;



	}







	public function where($where, $value = NULL)



	{



		$this->trigger_events('where');







		if (!is_array($where))



		{



			$where = array($where => $value);



		}







		array_push($this->_ion_where, $where);







		return $this;



	}







	public function select($select)



	{



		$this->trigger_events('select');







		$this->_ion_select[] = $select;







		return $this;



	}







	public function order_by($by, $order='desc')



	{



		$this->trigger_events('order_by');







		$this->_ion_order_by = $by;



		$this->_ion_order    = $order;







		return $this;



	}







	public function row()



	{



		$this->trigger_events('row');







		$row = $this->response->row();



		$this->response->free_result();







		return $row;



	}







	public function row_array()



	{



		$this->trigger_events(array('row', 'row_array'));







		$row = $this->response->row_array();



		$this->response->free_result();







		return $row;



	}







	public function result()



	{



		$this->trigger_events('result');







		$result = $this->response->result();



		$this->response->free_result();







		return $result;



	}







	public function result_array()



	{



		$this->trigger_events(array('result', 'result_array'));







		$result = $this->response->result_array();



		$this->response->free_result();







		return $result;



	}







	/**



	 * users



	 *



	 * @return object Users



	 * @author Ben Edmunds



	 **/



	public function users($groups = NULL)



	{



		$this->trigger_events('users');







		//default selects



		$this->db->select(array(



		    $this->tables['users'].'.*', 



		    $this->tables['users'].'.id as id', 



		    $this->tables['users'].'.id as user_id'



		));







		if (isset($this->_ion_select))



		{



			foreach ($this->_ion_select as $select)



			{



				$this->db->select($select);



			}







			$this->_ion_select = array();



		}







		//filter by group id(s) if passed



		if (isset($groups))



		{



			//build an array if only one group was passed



			if (is_numeric($groups))



			{



				$groups = Array($groups);



			}







			//join and then run a where_in against the group ids



			if (isset($groups) && !empty($groups))



			{



				$this->db->distinct();



				$this->db->join(



				    $this->tables['users_groups'], 



				    $this->tables['users_groups'].'.user_id = ' . $this->tables['users'].'.id', 



				    'inner'



				);







				$this->db->where_in($this->tables['users_groups'].'.group_id', $groups);



			}



		}







		$this->trigger_events('extra_where');







		//run each where that was passed



		if (isset($this->_ion_where))



		{



			foreach ($this->_ion_where as $where)



			{



				$this->db->where($where);



			}







			$this->_ion_where = array();



		}







		if (isset($this->_ion_limit) && isset($this->_ion_offset))



		{



			$this->db->limit($this->_ion_limit, $this->_ion_offset);







			$this->_ion_limit  = NULL;



			$this->_ion_offset = NULL;



		}



		else if (isset($this->_ion_limit)) 



		{



			$this->db->limit($this->_ion_limit);



			



			$this->_ion_limit  = NULL;



		}







		//set the order



		if (isset($this->_ion_order_by) && isset($this->_ion_order))



		{



			$this->db->order_by($this->_ion_order_by, $this->_ion_order);







			$this->_ion_order    = NULL;



			$this->_ion_order_by = NULL;



		}







		$this->response = $this->db->get($this->tables['users']);







		return $this;



	}







	/**



	 * user



	 *



	 * @return object



	 * @author Ben Edmunds



	 **/



	public function user($id = NULL)



	{



		$this->trigger_events('user');







		//if no id was passed use the current users id



		$id || $id = $this->session->userdata('user_id');







		$this->limit(1);



		$this->where($this->tables['users'].'.id', $id);







		$this->users();





		return $this;



	}







	/**



	 * get_users_groups



	 *



	 * @return array



	 * @author Ben Edmunds



	 **/




 




	public function get_users_groups($id=FALSE)



	{



		$this->trigger_events('get_users_group');







		//if no id was passed use the current users id



		$id || $id = $this->session->userdata('user_id');







		return $this->db->select($this->tables['users_groups'].'.'.$this->join['groups'].' as id, '.$this->tables['groups'].'.name, '.$this->tables['groups'].'.description')



		                ->where($this->tables['users_groups'].'.'.$this->join['users'], $id)



		                ->join($this->tables['groups'], $this->tables['users_groups'].'.'.$this->join['groups'].'='.$this->tables['groups'].'.id')



		                ->get($this->tables['users_groups']);



	}







	/**



	 * add_to_group



	 *



	 * @return bool



	 * @author Ben Edmunds



	 **/



	public function add_to_group($group_id, $user_id=false)



{	

		$this->trigger_events('add_to_group');







		//if no id was passed use the current users id



		$user_id || $user_id = $this->session->userdata('user_id');







		return $this->db->insert($this->tables['users_groups'], array( $this->join['groups'] => (int)$group_id, $this->join['users'] => (int)$user_id));



	}







	/**



	 * remove_from_group



	 *



	 * @return bool



	 * @author Ben Edmunds



	 **/



	public function remove_from_group($group_ids=false, $user_id=false)



	{



		$this->trigger_events('remove_from_group');



		



		// user id is required



		if(empty($user_id))



		{



			return FALSE;



		}



		



		// if group id(s) are passed remove user from the group(s)



		if( ! empty($group_ids))



		{



			if(is_array($group_ids))



			{



				foreach($group_ids as $group_id)



				{



					$this->db->delete($this->tables['users_groups'], array($this->join['groups'] => (int)$group_id, $this->join['users'] => (int)$user_id));



				}



			



				return TRUE;



			}



			else



			{



				return $this->db->delete($this->tables['users_groups'], array($this->join['groups'] => (int)$group_ids, $this->join['users'] => (int)$user_id));



			}



		}



		// otherwise remove user from all groups



		else



		{



			return $this->db->delete($this->tables['users_groups'], array($this->join['users'] => (int)$user_id));



		}



	}







	/**



	 * groups



	 *



	 * @return object



	 * @author Ben Edmunds



	 **/



	public function groups()



	{



		$this->trigger_events('groups');







		//run each where that was passed



		if (isset($this->_ion_where))



		{



			foreach ($this->_ion_where as $where)



			{



				$this->db->where($where);



			}



			$this->_ion_where = array();



		}







		if (isset($this->_ion_limit) && isset($this->_ion_offset))



		{



			$this->db->limit($this->_ion_limit, $this->_ion_offset);







			$this->_ion_limit  = NULL;



			$this->_ion_offset = NULL;



		}



		else if (isset($this->_ion_limit)) 



		{



			$this->db->limit($this->_ion_limit);



			



			$this->_ion_limit  = NULL;



		}







		//set the order



		if (isset($this->_ion_order_by) && isset($this->_ion_order))



		{



			$this->db->order_by($this->_ion_order_by, $this->_ion_order);



		}







		$this->response = $this->db->get($this->tables['groups']);







		return $this;



	}







	/**



	 * group



	 *



	 * @return object



	 * @author Ben Edmunds



	 **/



	public function group($id = NULL)



	{



		$this->trigger_events('group');







		if (isset($id))



		{



			$this->db->where($this->tables['groups'].'.id', $id);



		}







		$this->limit(1);







		return $this->groups();



	}







	/**



	 * update



	 *



	 * @return bool



	 * @author Phil Sturgeon



	 **/



	public function update($id, array $data)



	{



		$this->trigger_events('pre_update_user');







		$user = $this->user($id)->row();







		$this->db->trans_begin();







		if (array_key_exists($this->identity_column, $data) && $this->identity_check($data[$this->identity_column]) && $user->{$this->identity_column} !== $data[$this->identity_column])



		{



			$this->db->trans_rollback();



			$this->set_error('account_creation_duplicate_'.$this->identity_column);







			$this->trigger_events(array('post_update_user', 'post_update_user_unsuccessful'));



			$this->set_error('update_unsuccessful');







			return FALSE;



		}







		// Filter the data passed



		$data = $this->_filter_data($this->tables['users'], $data);







		if (array_key_exists('username', $data) || array_key_exists('password', $data) || array_key_exists('email', $data))



		{



			if (array_key_exists('password', $data))



			{



				if( ! empty($data['password']))



				{



					$data['password'] = $this->hash_password($data['password'], $user->salt);



				}



				else



				{



					// unset password so it doesn't effect database entry if no password passed



					unset($data['password']);



				}



			}



		}







		$this->trigger_events('extra_where');



		$this->db->update($this->tables['users'], $data, array('id' => $user->id));







		if ($this->db->trans_status() === FALSE)



		{



			$this->db->trans_rollback();







			$this->trigger_events(array('post_update_user', 'post_update_user_unsuccessful'));



			$this->set_error('update_unsuccessful');



			return FALSE;



		}







		$this->db->trans_commit();







		$this->trigger_events(array('post_update_user', 'post_update_user_successful'));



		$this->set_message('update_successful');



		return TRUE;



	}







	/**



	* delete_user



	*



	* @return bool



	* @author Phil Sturgeon



	**/



	public function delete_user($id)



	{



		$this->trigger_events('pre_delete_user');







		$this->db->trans_begin();







		// delete user from users table



		$this->db->delete($this->tables['users'], array('id' => $id));



		



		// remove user from groups



		$this->remove_from_group(NULL, $id);







		if ($this->db->trans_status() === FALSE)



		{



			$this->db->trans_rollback();



			$this->trigger_events(array('post_delete_user', 'post_delete_user_unsuccessful'));



			$this->set_error('delete_unsuccessful');



			return FALSE;



		}







		$this->db->trans_commit();







		$this->trigger_events(array('post_delete_user', 'post_delete_user_successful'));



		$this->set_message('delete_successful');



		return TRUE;



	}







	/**



	 * update_last_login



	 *



	 * @return bool



	 * @author Ben Edmunds



	 **/



	public function update_last_login($id)



	{



		$this->trigger_events('update_last_login');







		$this->load->helper('date');







		$this->trigger_events('extra_where');







		$this->db->update($this->tables['users'], array('last_login' => time()), array('id' => $id));







		return $this->db->affected_rows() == 1;



	}







	/**



	 * set_lang



	 *



	 * @return bool



	 * @author Ben Edmunds



	 **/



	public function set_lang($lang = 'en')



	{



		$this->trigger_events('set_lang');







		// if the user_expire is set to zero we'll set the expiration two years from now.



		if($this->config->item('user_expire', 'ion_auth') === 0)



		{



			$expire = (60*60*24*365*2);



		}



		// otherwise use what is set



		else



		{



			$expire = $this->config->item('user_expire', 'ion_auth');



		}







		set_cookie(array(



			'name'   => 'lang_code',



			'value'  => $lang,



			'expire' => $expire



		));







		return TRUE;



	}







	/**



	 * remember_user



	 *



	 * @return bool



	 * @author Ben Edmunds



	 **/



	public function remember_user($id)



	{



		$this->trigger_events('pre_remember_user');







		if (!$id)



		{



			return FALSE;



		}







		$user = $this->user($id)->row();







		$salt = sha1($user->password);







		$this->db->update($this->tables['users'], array('remember_code' => $salt), array('id' => $id));







		if ($this->db->affected_rows() > -1)



		{



			// if the user_expire is set to zero we'll set the expiration two years from now.



			if($this->config->item('user_expire', 'ion_auth') === 0)



			{



				$expire = (60*60*24*365*2);



			}



			// otherwise use what is set



			else



			{



				$expire = $this->config->item('user_expire', 'ion_auth');



			}



			



			set_cookie(array(



			    'name'   => 'identity',



			    'value'  => $user->{$this->identity_column},



			    'expire' => $expire



			));







			set_cookie(array(



			    'name'   => 'remember_code',



			    'value'  => $salt,



			    'expire' => $expire



			));







			$this->trigger_events(array('post_remember_user', 'remember_user_successful'));



			return TRUE;



		}







		$this->trigger_events(array('post_remember_user', 'remember_user_unsuccessful'));



		return FALSE;



	}







	/**



	 * login_remembed_user



	 *



	 * @return bool



	 * @author Ben Edmunds



	 **/



	public function login_remembered_user()



	{



		$this->trigger_events('pre_login_remembered_user');







		//check for valid data



		if (!get_cookie('identity') || !get_cookie('remember_code') || !$this->identity_check(get_cookie('identity')))



		{



			$this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_unsuccessful'));



			return FALSE;



		}







		//get the user



		$this->trigger_events('extra_where');



		$query = $this->db->select($this->identity_column.', id')



		                  ->where($this->identity_column, get_cookie('identity'))



		                  ->where('remember_code', get_cookie('remember_code'))



		                  ->limit(1)



		                  ->get($this->tables['users']);







		//if the user was found, sign them in



		if ($query->num_rows() == 1)



		{



			$user = $query->row();







			$this->update_last_login($user->id);







			$session_data = array(



			    $this->identity_column => $user->{$this->identity_column},



			    'id'                   => $user->id, //kept for backwards compatibility



			    'user_id'              => $user->id, //everyone likes to overwrite id so we'll use user_id



			);







			$this->session->set_userdata($session_data);











			//extend the users cookies if the option is enabled



			if ($this->config->item('user_extend_on_login', 'ion_auth'))



			{



				$this->remember_user($user->id);



			}







			$this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_successful'));



			return TRUE;



		}







		$this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_unsuccessful'));



		return FALSE;



	}







	public function set_hook($event, $name, $class, $method, $arguments)



	{



		$this->_ion_hooks->{$event}[$name] = new stdClass;



		$this->_ion_hooks->{$event}[$name]->class     = $class;



		$this->_ion_hooks->{$event}[$name]->method    = $method;



		$this->_ion_hooks->{$event}[$name]->arguments = $arguments;



	}







	public function remove_hook($event, $name)



	{



		if (isset($this->_ion_hooks->{$event}[$name]))



		{



			unset($this->_ion_hooks->{$event}[$name]);



		}



	}







	public function remove_hooks($event)



	{



		if (isset($this->_ion_hooks->$event))



		{



			unset($this->_ion_hooks->$event);



		}



	}







	protected function _call_hook($event, $name)



	{



		if (isset($this->_ion_hooks->{$event}[$name]) && method_exists($this->_ion_hooks->{$event}[$name]->class, $this->_ion_hooks->{$event}[$name]->method))



		{



			$hook = $this->_ion_hooks->{$event}[$name];







			return call_user_func_array(array($hook->class, $hook->method), $hook->arguments);



		}







		return FALSE;



	}







	public function trigger_events($events)



	{



		if (is_array($events) && !empty($events))



		{



			foreach ($events as $event)



			{



				$this->trigger_events($event);



			}



		}



		else



		{



			if (isset($this->_ion_hooks->$events) && !empty($this->_ion_hooks->$events))



			{



				foreach ($this->_ion_hooks->$events as $name => $hook)



				{



					$this->_call_hook($events, $name);



				}



			}



		}



	}







	/**



	 * set_message_delimiters



	 *



	 * Set the message delimiters



	 *



	 * @return void



	 * @author Ben Edmunds



	 **/



	public function set_message_delimiters($start_delimiter, $end_delimiter)



	{



		$this->message_start_delimiter = $start_delimiter;



		$this->message_end_delimiter   = $end_delimiter;







		return TRUE;



	}







	/**



	 * set_error_delimiters



	 *



	 * Set the error delimiters



	 *



	 * @return void



	 * @author Ben Edmunds



	 **/



	public function set_error_delimiters($start_delimiter, $end_delimiter)



	{



		$this->error_start_delimiter = $start_delimiter;



		$this->error_end_delimiter   = $end_delimiter;







		return TRUE;



	}







	/**



	 * set_message



	 *



	 * Set a message



	 *



	 * @return void



	 * @author Ben Edmunds



	 **/



	public function set_message($message)



	{



		$this->messages[] = $message;







		return $message;



	}







	/**



	 * messages



	 *



	 * Get the messages



	 *



	 * @return void



	 * @author Ben Edmunds



	 **/



	public function messages()



	{



		$_output = '';



		foreach ($this->messages as $message)



		{



			$messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';



			$_output .= $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;



		}







		return $_output;



	}







	/**



	 * set_error



	 *



	 * Set an error message



	 *



	 * @return void



	 * @author Ben Edmunds



	 **/



	public function set_error($error)



	{



		$this->errors[] = $error;







		return $error;



	}







	/**



	 * errors



	 *



	 * Get the error message



	 *



	 * @return void



	 * @author Ben Edmunds



	 **/



	public function errors()



	{



		$_output = '';



		foreach ($this->errors as $error)



		{



			$errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';



			$_output .= $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;



		}







		return $_output;



	}







	protected function _filter_data($table, $data)



	{



		$filtered_data = array();



		$columns = $this->db->list_fields($table);







		if (is_array($data))



		{



			foreach ($columns as $column)



			{



				if (array_key_exists($column, $data))



					$filtered_data[$column] = $data[$column];



			}



		}







		return $filtered_data;



	}



	



	protected function _prepare_ip($ip_address) {



		if ($this->db->platform() === 'postgre')



		{



			return $ip_address;



		}



		else



		{



			return inet_pton($ip_address);



		}



	}



	



	function change_user_group($id){



		$data['group_id']=8;



		$this->db->where('user_id', $id);



    	$this->db->update('users_groups', $data);



		return true;



	}

	

	function getuserid($id){

		$this->db->select('id');	

		$this->db->where('user_id', $id);

		$this->db->from('users_groups');

		$query = $this->db->get();

		$result=$query->result_array();

		return $result['0']['id'];		

	}	



	function check_organization($userid){



		//$sql="SELECT b.* FROM users_groups a,organization_owners_in_zone b where a.user_id=b.userid and a.group_id=8 and a.user_id=".$userid; 

		$sql="SELECT b.* FROM users_groups a,organization b where a.user_id=b.userid and a.group_id=8 and a.user_id=".$userid; 

		$query=$this->db->query($sql);



		$result=$query->result_array();



		return $result;



	}



# + check_realtor -> added on 21.01.15 to check the realtor	

	function check_realtor($userid){

		$sql="SELECT b.* FROM users_groups a,realtor b where a.user_id=b.userid and a.group_id=14 and a.user_id=".$userid; 

		$query=$this->db->query($sql);

		$result=$query->result_array();

		return $result;

	}

# - check_realtor -> added on 21.01.15 to check the realtor	



	function user_account_verification($uid){



		$data['status']=1;



		$this->db->where('id', $uid);



		//$this->db->where('active', $code);



    	$this->db->update('users', $data);



		return 1;



	}



	function check_user_type($userid){



		$sql="SELECT group_id FROM users_groups where user_id=".$userid; 



		$query=$this->db->query($sql);



		$result=$query->result_array();



		return $result;



	}






	function edit_business_from_zonepage($uid=false,$uname=false,$pwd=false){ 





		$salt=$this->store_salt ? $this->salt() : FALSE;



		$username=$uname;



		$password=$this->hash_password($pwd, $salt);




		$data['username']=$username;



		$data['password']=$password;



		$this->db->where('id', $uid);



    	$this->db->update('users', $data);



	}



	function update_user_info_for_organization($orgid=false,$uname=false,$pwd=false,$email=false,$zoneid=false){

		$_sql="select userid from organization where id=".$orgid;

		$_query=$this->db->query($_sql);

		$_result=$_query->result_array();

		if(!empty($_result)){

			$_user_id=$_result[0]['userid'];

		}else{

			$_user_id=0;

		}

		if($pwd!=''){

			$salt=$this->store_salt ? $this->salt() : FALSE;		

			$password=$this->hash_password($pwd, $salt);

		}else{

			$password=$pwd;

		}

		if($_user_id!=0){

			$data=array();

	

			$data['username']=$uname;

			if($password!=''){

				$data['password']=$password;

			}

	

			$data['email']=$email;

	

			$this->db->where('id',$_user_id);

	

			$this->db->update('users', $data);

		}

	}

	

# + update_user_info_for_realtor

	function update_user_info_for_realtor($orgid=false,$uname=false,$pwd=false,$email=false,$zoneid=false){

		$_sql="select userid from realtor where id=".$orgid;

		$_query=$this->db->query($_sql);

		$_result=$_query->result_array();

		if(!empty($_result)){

			$_user_id=$_result[0]['userid'];

		}else{

			$_user_id=0;

		}

		if($pwd!=''){

			$salt=$this->store_salt ? $this->salt() : FALSE;		

			$password=$this->hash_password($pwd, $salt);

		}else{

			$password=$pwd;

		}

		if($_user_id!=0){

			$data=array();

	

			$data['username']=$uname;

			if($password!=''){

				$data['password']=$password;

			}

	

			$data['email']=$email;

	

			$this->db->where('id',$_user_id);

	

			$this->db->update('users', $data);

		}

	} 

# -	update_user_info_for_realtor



	function update_user_info_for_organization_old($orgid=false,$uname=false,$pwd=false,$email=false,$zoneid=false){



		$_sql="select userid from organization_owners_in_zone where orgid=".$orgid;



		$_query=$this->db->query($_sql);



		$_result=$_query->result_array();



		$_user_id=$_result[0]['userid'];


		$_sql_zone="select sales_rep_id from sales_zone a where id=".$zoneid;



		$_query_zone=$this->db->query($_sql_zone);



		$_result_zone=$_query_zone->result_array();



		$_zone_id=$_result_zone[0]['sales_rep_id'];




		$_sql_1="select username from users where id=".$_zone_id;



		$_query_1=$this->db->query($_sql_1);



		$_result_1=$_query_1->result_array();



		$_user_name=$_result_1[0]['username'];




		if($_user_name!=$uname){



		



		if($pwd!=''){



			$salt=$this->store_salt ? $this->salt() : FALSE;		



			$password=$this->hash_password($pwd, $salt);



			if($_user_id==$_zone_id){



				



					$additional_data='';



					$organization_owner_id1 = $this->ion_auth->register($uname, $password, $email, $additional_data);



					$this->ion_auth->change_user_group($organization_owner_id1);



					



					$data1=array();



					$data1['userid']=$organization_owner_id1;



					$this->db->where('orgid',$orgid);



					$this->db->update('organization_owners_in_zone', $data1);



				



			}else{



				



					$data=array();



					$data['username']=$uname;



					$data['password']=$password;



					$data['email']=$email;



					$this->db->where('id',$_user_id);



					$this->db->update('users', $data);



				



			}



		}else{



			



			if($_user_id==$_zone_id){



				$additional_data='';



				$organization_owner_id1 = $this->ion_auth->register($uname, $pwd, $email, $additional_data);



				$this->ion_auth->change_user_group($organization_owner_id);



				



				$data1=array();



				$data1['userid']=$organization_owner_id1;



				$this->db->where('orgid',$orgid);



				$this->db->update('organization_owners_in_zone', $data1);



			}else{



				$data=array();



				$data['username']=$uname;



				$data['email']=$email;



				$this->db->where('id',$_user_id);



				$this->db->update('users', $data);



			}







		}



		}



	}



	



	function create_zone_org_announcement($id=false, $saleszoneid=false){

		$org_password='organization';

		$org_email='';

		$additional_data='';

		$org_arr=array();

		$org_arr[0]='Municipality';

		$org_arr[1]='Elementary School';

		$org_arr[2]='Middle School';

		$org_arr[3]='High School';

		$org_arr[4]='Girl Scouts';

		$org_arr[5]='Boy Scouts';

		$org_arr[6]='Historical Society';

		$org_arr[7]='Lions Club';

		$org_arr[8]='Knights of Columbus';		

		$org_arr[9]='Garden Club';

		$org_arr[10]='VFW';

		$org_arr[11]='Kiwanis Club';

		$org_arr[12]='Parents Teachers Association';

		$org_arr[13]='UNICO';

		$org_arr[14]='ELKS Club';		



		foreach($org_arr as $_key=>$_val){

			$_sql_zone="select b.username as name from sales_zone a,users b where a.sales_rep_id=b.id and a.id=".$saleszoneid;

			$_query_zone=$this->db->query($_sql_zone);

			$_result_zone=$_query_zone->result_array();

			if(!empty($_result_zone)){

				$_zone_name=$_result_zone[0]['name'];

			}

			$_org_name=substr($_val,0,3);

			$org_username=strtolower($_zone_name).''.strtolower($_org_name).rand(1000,9999);

			$newdata=array();

			$newdata['name']=$_val;

			$newdata['zoneid']=$saleszoneid;

			$newdata['ownerid']=$id;

			if($_key==0){

				$newdata['type']=1;

			}else{

				$newdata['type']=0;

			}

			$newdata['approval']=1;

			$this->db->insert('organization', $newdata);

			$orgid = $this->db->insert_id();

			$newdata1=array();

			$newdata1['zone_id']=$saleszoneid;

			$newdata1['title']="Organization's Info Coming Soon";

			$newdata1['date_modified']=date('Y-m-d');		

			$newdata1['announcement_text']="Organization's Info Coming Soon";

			$newdata1['announcement_type']=0;

			$newdata1['organizationid']=$orgid;		

			$newdata1['approval']=1;

			$this->db->insert('zone_announcement', $newdata1);

			$additional_data='';

			$organization_owner_id = $this->ion_auth->register($org_username, $org_password, $org_email, $additional_data);

			$this->ion_auth->change_user_group($organization_owner_id);

			$data=array('orgid' => $orgid,'userid' => $organization_owner_id,'zoneid' => $saleszoneid,'approval'=>1);

			$this->db->insert('organization_owners_in_zone', $data);

		}



	}



	



	function get_snap_user_zone($userid){



		$sql="SELECT zoneid FROM snap_user_in_zone where userid=".$userid; 



		$query=$this->db->query($sql);



		$result=$query->result_array();



		return $result;



	}

	

	function site_authentication(){

		if($this->session->userdata('usersessiondata')){  // zone owner

			$usersession_data = $this->session->userdata('usersessiondata');

			$ugid = $usersession_data['usergrid'];

			$uzid = $usersession_data['userzoneid']; 

			redirect('/index.php?zone='.$uzid, 'refresh');

		}else if($this->session->userdata('session_zoneid_from_bus')){  // business owner

			$usersession_data = $this->session->userdata('session_zoneid_from_bus');

			$uzid = $usersession_data['buszoneid']; 

			redirect('/index.php?zone='.$uzid, 'refresh');

		}else if($this->session->userdata('session_normal_user_in_zone')){  // normal user session_normal_user_in_zone

			$usersession_data = $this->session->userdata('session_normal_user_in_zone');

			$uzid = $usersession_data['sesuserzone']; //echo 'normal user-'.$uzid; exit; 

			redirect('/index.php?zone='.$uzid, 'refresh');

		}else{

			return 1;

		}

	}

	function meta_tag_details($adid=0){


		 $sql="SELECT b.id as business_id, b.name as business_name,a.short_description as description,a.deal_title as deal_title,a.adtext as image FROM ads as a,business as b WHERE a.business_id=b.id and a.id=$adid";

		$query = $this->db->query($sql);

    	$result = $query->result_array();

		return $result;

	}

	function meta_tag_image_details($adid=0){

		$sql="SELECT bus_id,image_name FROM business_photos WHERE ad_id=".$adid;

		$query = $this->db->query($sql);

    	$result = $query->result_array();

		if(!empty($result)){

			return $result;

		}else{

			return false;

		}

	}

	/* Password Update For Uploaded Business */

	function update_uploadbusiness_password($id=0,$password=''){

		if($id != 0 && $password != ''){	

			$sql = "UPDATE users SET uploaded_business_password='".$password."' WHERE id=".$id;

			$this->db->query($sql);

		}

	}

	function check_user_type_forgot_password($username){

		$sql="SELECT b.group_id FROM users a, users_groups b WHERE a.id = b.user_id AND a.username='".$username."'";

		$query = $this->db->query($sql);

    	$result = $query->result_array();

		return $result;

	}

	

	function check_valid_url($userid, $zoneid ){

		$sql="SELECT id from sales_zone WHERE id=".$zoneid." and sales_rep_id=".$userid;

		$query = $this->db->query($sql);

    	$count = $query->num_rows(); 

		return $count;

	}

	

	function check_valid_url_other($userid,$userzoneid,$id,$fromzoneid,$where_from){

      if($fromzoneid!=0 && $where_from == 'business'){

		$sql="SELECT a.id from sales_zone a, ads_setting_preferences b , business c WHERE a.id='$fromzoneid' and a.sales_rep_id='$userid' and b.businessid='$id' and b.businessid=c.id and b.settingszoneid=a.id"; 

		$query = $this->db->query($sql);

    	$count = $query->num_rows(); 

		return $count;

	  }else if($fromzoneid==0 && $where_from == 'business'){

		$sql="SELECT c.id from ads_setting_preferences b , business c, users d WHERE  d.id='$userid' and b.businessid='$id' and c.business_owner_id=d.id and b.businessid=c.id ";

		$query = $this->db->query($sql);

    	$count = $query->num_rows(); 

		return $count;

	  }else if($fromzoneid!=0 && $where_from == 'organization'){

		  $sql="SELECT a.id from sales_zone a, organization b WHERE a.id='$fromzoneid' and a.sales_rep_id='$userid' and b.id='$id' and b.zoneid=a.id"; //echo $sql;exit;

		$query = $this->db->query($sql);

    	$count = $query->num_rows(); 

		return $count;

		  

	  }else if($fromzoneid==0 && $where_from == 'organization'){

		$sql="SELECT a.id from sales_zone a, organization b, users c WHERE  c.id='$userid' and b.id='$id' and a.id=b.zoneid and b.userid=c.id"; //echo $sql;exit;

		$query = $this->db->query($sql);

    	$count = $query->num_rows(); 

		return $count;

	  }else if($fromzoneid!=0 && $where_from == 'realtor'){

		  $sql="SELECT a.id from sales_zone a, realtor b WHERE a.id='$fromzoneid' and a.sales_rep_id='$userid' and b.id='$id' and b.zoneid=a.id"; //echo $sql;exit;

		  $query = $this->db->query($sql);

    	  $count = $query->num_rows(); 

		  return $count;

		  

	  }else if($fromzoneid==0 && $where_from == 'realtor'){

		$con ='' ;

		if($id!=''){

			$con = " and b.id='$id'"; 

		} 

		  

		$sql="SELECT a.id from sales_zone a, realtor b, users c WHERE  c.id='$userid' and a.id=b.zoneid and b.userid=c.id ".$con; //echo $sql;exit;

		$query = $this->db->query($sql);

    	$count = $query->num_rows(); 

		return $count;

	  }

	}

	function encryptpassword($userid,$password){

		return $password = $this->hash_password_db($userid, $password);

	}

	// + checking user is present or not

	function checkPeekabooUser($username,$password){

		$password = sha1($password) ;

		$sql="SELECT * from tbl_member WHERE  user_name='".$username."' and password ='".$password."'"; //echo $sql;exit;

		$query = $this->db->query($sql);

		$count = $query->num_rows();//var_dump($count);exit ;

		return $count;

	}

	// - checking user is present or not

	function check_login_type($username,$login_type,$zoneid=0){
 

		// if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
		  $emailParameter = "a.username='".$username."'";
		// }else{
		//   $emailParameter = "a.email='".$username."'";
		// }

		

		 $sql="SELECT a.id ";		 

		 $sql .=" FROM users a, users_groups b ";	 

		  $sql .="where a.id=b.user_id   and b.group_id=".$login_type." and ".$emailParameter;


 
 
		$query=$this->db->query($sql);

		$result=$query->result_array();



		if(!empty($result)){	
 
			return 1;

		}else{ 				  

				
			return 0;

		}

	}




	function sendEmailAddress($to, $subject, $message) {

	    require_once("class.phpmailer.php");
	    $mail = new PHPMailer(); // create a new object
	    $mail->IsSMTP(); // enable SMTP
	    $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
	    $mail->SMTPAuth = true; // authentication enabled
	    
	    $mail->Host = SMTP_HOST;
	    $mail->Port = SMTP_PORT;

	    $mail->IsHTML(true);
	    $mail->Username = SMTP_USERNAME;
	    $mail->Password = SMTP_PASSWORD;
	  
	    $mail->SetFrom(FROM_EMAIL, FROM_NM);

	    $mail->AddReplyTo(FROM_EMAIL, FROM_NM);
	    $mail->Subject = $subject;
	    $mail->Body = $message;
	    $mail->AddAddress($to);
	    $result = true;

	    if (!$mail->Send()) {
	        $result = false;
	    }

	    return $result;
    }




}



