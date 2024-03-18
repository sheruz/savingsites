<?php
namespace App\Models;

use CodeIgniter\Model;
#[\AllowDynamicProperties]
class Ion_Auth extends Model
{
	public function __construct(){
		$this->db = \Config\Database::connect();
	}
	
	public function register($username, $password, $email, $additional_data = array(), $groups = array(), $userid_for_registration='', $emailnotice_phone='' , $carrier='',$cellPhone='',$fromwhere='',$refer_code = ''){  
		
		$query = $this->db->table('users')->select('id')->where(['refer_code_link' => $refer_code])->get();
		$user_ID = $query->getRow()->id;

		$query = $this->db->table('users')->select('free_cert')->where(['refer_code_link' => $refer_code])->get();
		$free_certrecord = $query->getRow()->free_cert;
		$userid = isset($user_ID)?$user_ID:'';
    	if($refer_code !=''){
    		$free_cert = $free_certrecord+1;
    	}else{
    		$free_cert = 0;
    	}
		/*get  refer user id*/
		$this->trigger_events('pre_register');
		echo "herein";die("fvdfv");
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
		echo "here3";die;
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

	public function trigger_events($events){
		if (is_array($events) && !empty($events)){
			foreach ($events as $event){
				$this->trigger_events($event);
			}
		}else{
		echo "here2";
			if (isset($this->_ion_hooks->$events) && !empty($this->_ion_hooks->$events)){
		echo "here3";die;
				foreach ($this->_ion_hooks->$events as $name => $hook){
					$this->_call_hook($events, $name);
				}
			}
		}
	}

	protected function _prepare_ip($ip_address) {
		if ($this->db->platform() === 'postgre'){
			return $ip_address;
		}else{
			return inet_pton($ip_address);
		}
	}

	public function hash_password($password, $salt=false, $use_sha1_override=FALSE){
		if (empty($password)){
			return FALSE;
		}
		if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt'){
			return $this->bcrypt->hash($password);
		}
		if ($this->store_salt && $salt){
			return  sha1($password . $salt);
		}else{
			$salt = $this->salt();
			return  $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
		}
	}

	public function set_hook($event, $name, $class, $method, $arguments){
		$this->_ion_hooks->{$event}[$name] = new stdClass;
		$this->_ion_hooks->{$event}[$name]->class     = $class;
		$this->_ion_hooks->{$event}[$name]->method    = $method;
		$this->_ion_hooks->{$event}[$name]->arguments = $arguments;
	}

	public function remove_hook($event, $name){
		if (isset($this->_ion_hooks->{$event}[$name])){
			unset($this->_ion_hooks->{$event}[$name]);
		}
	}

	public function remove_hooks($event){
		if (isset($this->_ion_hooks->$event)){
			unset($this->_ion_hooks->$event);
		}
	}

	protected function _call_hook($event, $name){
		echo "here1";
		if (isset($this->_ion_hooks->{$event}[$name]) && method_exists($this->_ion_hooks->{$event}[$name]->class, $this->_ion_hooks->{$event}[$name]->method)){
			$hook = $this->_ion_hooks->{$event}[$name];
			return call_user_func_array(array($hook->class, $hook->method), $hook->arguments);
		}
		return FALSE;
	}

}