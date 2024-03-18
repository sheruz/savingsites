<?php
namespace App\Models;

use CodeIgniter\Model;
#[\AllowDynamicProperties]
class Users extends Model
{
    public function __construct(){
        $this->db = \Config\Database::connect();
    } 

    public function get_all_users()
    {
        $query = $this->db->query('select * from users');
        $ret = array();
        foreach ($query->result_array() as $ra) {
            $ret[$ra['id']] = $ra['username'];
        }
        $ret['0'] = "Unassigned";
        return $ret;

    }
    public function get_user_list($active = false)
    {
        $sql = "select * from users where (first_name!='' and last_name!='') ";
        if(!empty($active)) { $sql .= " and active = 1 "; }
        $sql .= " order by last_name, first_name";
        
        /*$sql="select * from users a,users_groups b where a.id=b.user_id and a.first_name!='' and a.last_name!='' and a.active=1 and b.group_id=5 order by last_name, first_name";*/
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    /*function get_user_list_zone($users_all_zone){
        $j=0; $k=0; $result_final='';
        //var_dump($users_all_zone);        
        $users_all_zone_explode=explode(',',$users_all_zone);
        for($i=0; $i<count($users_all_zone_explode); $i++){
            $sql="select c.id,c.first_name,c.last_name from ads_setting_preferences a,business b,users c,users_groups d where a.businessid=b.id and b.business_owner_id=c.id and c.id=d.user_id and d.group_id=5 and c.active=1 and c.first_name!='' and c.last_name!='' and a.settingszoneid=".$users_all_zone_explode[$i]." group by c.id order by c.last_name asc";
            $query = $this->db->query($sql);
            $result=$query->result_array();
            //var_dump($result);
            for($k=0;$k<count($result);$k++){
                $result_final[$result[$k]['id']]['last_name'] = $result[$k]['last_name'] ;
                $result_final[$result[$k]['id']]['first_name'] = $result[$k]['first_name'] ;
                //$k=$j;
                $j++;
            }
        }
        //var_dump($result_final);
        return $result_final;   
    }*/
    function get_user_list_zone($users_all_zone=0){
        $sql="select c.id,c.username from ads_setting_preferences a,business b,users c,users_groups d where a.businessid=b.id and b.business_owner_id=c.id and c.id=d.user_id and d.group_id=5 and c.active=1 and a.settingszoneid IN(".$users_all_zone." ) group by c.id order by c.last_name asc";
        $query = $this->db->query($sql);
        $result=$query->result_array();
        return $result;
    }
    
    function get_zone_by_business($businessid=0){
        $sql = "select t1.businessid,t1.settingszoneid as zoneid ,t2.sales_rep_id as userid,t3.email from ads_setting_preferences as t1 inner join sales_zone as t2 on t1.settingszoneid = t2.id
inner join users as t3 on t2.sales_rep_id = t3.id where t1.businessid = ".$businessid;
        $query = $this->db->query($sql);
        $result=$query->result_array();
        return $result;
    }

    function get_user_list_zone_old($users_all_zone){
        $j=0; $k=0; $result_final='';
        //var_dump($users_all_zone); exit;      
        $users_all_zone_explode=explode(',',$users_all_zone);
        for($i=0; $i<count($users_all_zone_explode); $i++){
            $sql="select c.id,c.username from ads_setting_preferences a,business b,users c,users_groups d where a.businessid=b.id and b.business_owner_id=c.id and c.id=d.user_id and d.group_id=5 and c.active=1 and a.settingszoneid=".$users_all_zone_explode[$i]." group by c.id order by c.last_name asc";
            $query = $this->db->query($sql);
            $result=$query->result_array();
            //var_dump($result);
            for($k=0;$k<count($result);$k++){
                $result_final[$result[$k]['id']]['username'] = $result[$k]['username'] ;
                //$result_final[$result[$k]['id']]['first_name'] = $result[$k]['first_name'] ;
                //$k=$j;
                $j++;
            }
        }
        //var_dump($result_final);
        return $result_final;   
    }
    public function get_by_id($id)
    {
        $sql = "select t1.*, t2.id as securityId, t2.name as securityName from users as t1
                    LEFT JOIN users_groups as t3 on t1.id = user_id LEFT join groups as t2 on
                    t3.group_id = t2.id where t1.id =" . $id;

        $query = $this->db->query($sql);
        $result = $query->row();
        return $result;
    }

    public function adjust_zone_manager($zone_id, $manager_id, $add = false)
    {
        if(empty($zone_id) && $zone_id < 1){return;}
        if(empty($manager_id) && $manager_id < 1){return;}

        $data = array();
        $data['zone_id'] = $zone_id;
        $data['user_id'] = $manager_id;

        if(!empty($add) && $add == true){
            $this->db->insert('zone_managers', $data);
        }
        else
        {
            $this->db->delete('zone_managers', $data);

        }
    }

    public function is_user_zone_manager($zone_id, $user_id)
    {
        $result = $this->db->query("select * from zone_managers where zone_id = $zone_id AND user_id = $user_id")->result_array();
        return !empty($result);
    }
    public function get_zone_managers_in_zone($id){
        return $this->get_zone_managers($id, "IN");
    }

    public function get_zone_managers_not_in_zone($id){
        return $this->get_zone_managers($id, "NOT IN");
    }


    private function get_zone_managers($id, $in_text){
        $sql = "select * from users where id $in_text (select user_id from zone_managers where zone_id = $id)
        and id IN (select user_id from users_groups where group_id IN (3,4,7)) order by last_name";
        //echo $sql;
        
        return $this->db->query($sql)->result_array();
    }
    
    public function get_municiple_managers_in_zone($id){
        return $this->get_municiple_managers_active($id, "IN");
    }
    
    public function get_municiple_managers_not_in_zone($id){
        return $this->get_municiple_managers_deactive($id, "IN");
    }
    private function get_municiple_managers_active($id, $in_text){
        $sql = "select * from users where id $in_text (select municipal_owner_id from municipal_owners_in_zone where zone_id = $id and active = 1)
        and id IN (select user_id from users_groups where group_id = '8') order by last_name";
        return $this->db->query($sql)->result_array();
    }
    private function get_municiple_managers_deactive($id, $in_text){
        $sql = "select * from users where id $in_text (select municipal_owner_id from municipal_owners_in_zone where zone_id = $id and active = 0)
        and id IN (select user_id from users_groups where group_id = '8') order by last_name";
        return $this->db->query($sql)->result_array();
    }
    
    public function adjust_municiple_manager($zone_id, $manager_id, $add = false)
    {
        if(empty($zone_id) && $zone_id < 1){return;}
        if(empty($manager_id) && $manager_id < 1){return;}
        
        $data = array();
        $data['zone_id'] = $zone_id;
        $data['municipal_owner_id'] = $manager_id;
         
        
            if(!empty($add) && $add == true){
                $data['active'] = 1;
                $this->db->insert('municipal_owners_in_zone', $data);
            }
            else
            {
                $data_update['active'] = 0;
                $this->db->where('zone_id', $zone_id);
                $this->db->where('municipal_owner_id', $manager_id);
                $this->db->update('municipal_owners_in_zone', $data_update);
        
            }
    }
    public function adjust_municiple_manager_disable($zone_id, $manager_id, $add = false)
    {
        if(empty($zone_id) && $zone_id < 1){return;}
        if(empty($manager_id) && $manager_id < 1){return;}
    
            $data = array();
            $data['zone_id'] = $zone_id;
            $data['municipal_owner_id'] = $manager_id;
        
        if(!empty($add) && $add == true){
            $data_update['active'] = 1;
            $this->db->where('zone_id', $zone_id);
            $this->db->where('municipal_owner_id', $manager_id);
            $this->db->update('municipal_owners_in_zone', $data_update);
        }
        else
        {
            $data_update['active'] = 0;
            $this->db->where('zone_id', $zone_id);
            $this->db->where('municipal_owner_id', $manager_id);
            $this->db->update('municipal_owners_in_zone', $data_update);
    
        }
    }
    function check_username($username=false){ 
        $sql="select username from users where username='".addslashes($username)."'";
        $query = $this->db->query($sql); 
        $result_num = $query->num_rows(); //var_dump($result_num);
        if($result_num>=1){
            $result = '0';
        }else if($result_num==0){
            $result = $username;
        }
        //var_dump($result); exit;
        return $result;
    }
    
    public function add_business_check_username($username=false){ 
        $sql="select a.username from users a where a.username='".addslashes($username)."'";
        $query = $this->db->query($sql); 
        $result_num = $query->getResult(); 
        if(count($result_num) >= 1){
            $result = '0';
        }else if(count($result_num) == 0){
            $result = $username;
        }
        return $result;
    }
    
    
    
    
    
    function check_email($email=false, $type=0){
        if($type==10 ||$type==7 || $type==15){
            $sql="SELECT a.email FROM users a, users_groups b  WHERE a.id=b.user_id AND b.group_id=".$type." AND a.email='".addslashes($email)."'"; 
        }else{
            $sql="select email from users where email='".addslashes($email)."'";
        }
        $query = $this->db->query($sql);
        $result_num = $query->getResultArray();
        if(count($result_num) >=1){
            $result = '0';
        }else if(count($result_num)==0){
            $result = $email;
        }
        return $result;
    }
    
    function get_user_details($uid=false){
        $sql="SELECT * FROM users WHERE id=".$uid;
        $result=$this->db->query($sql)->getResultArray();
        return $result[0];
    }
    function update_users_for_business_owner($uid=false,$email=false,$fname=false,$lname=false,$phone=false,$address=false,$city=false,$state=false,$zip=false){
        $data = array('email' =>$email,'first_name' =>$fname,'last_name' =>$lname,'phone' =>$phone,'Address' =>$address,'City' =>$city,'State_Code' =>$state,'Zip' =>$zip,'status'=>1);
        $this->db->where('id', $uid);
        $this->db->update('users', $data);
    }

# + get_bus_details
    public function get_bus_state_phone($businessid=0){
        $sql = "SELECT b.* FROM business a , address b WHERE a.id=".$businessid." AND a.addressid = b.id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
        
    } 
# - get_bus_details     



function get_snap_org_in_zone($zoneid=false,$userid=false){
    $sql="select a.id,a.name,b.approval from zone_organization a 
    LEFT JOIN snap_organization b ON a.id=b.orgid and b.userid=".$userid." 
    where a.approval=1 and a.zoneid=".$zoneid;
    $query = $this->db->query($sql);
    $result_outer=$query->result_array();
    $result_inner=array();
    foreach($result_outer as $r){
        $r['approval']!='' ? ($r['approval']=1) : ($r['approval']=0);
        $result_inner[]=array(
            'id'=>$r['id'],
            'name'=>$r['name'],
            'approval'=>$r['approval']
        );
    }
    return $result_inner;
}

function update_status_email_from_org($orgid,$userid,$status){              
    if($status==1){
        $data = array();
        $data['orgid'] = $orgid;
        $data['userid'] = $userid;                      
        $this->db->delete('snap_organization', $data);
    }else if($status==0){
        $newdata = array(
        'userid' => $userid,
        'orgid' => $orgid,
        'approval' => 1
        );
        $this->db->insert('snap_organization', $newdata);

    }

}
function get_all_businesses_approved_in_snap($zone,$user){      
    $sql="SELECT a.user_id as user,a.email_status as approved,b.id,b.name,c.id as zoneid,c.name as zone_name from business_approved a,business b,sales_zone c where a.business_id=b.id and a.zoneid=c.id and a.user_id=".$user." order by a.id desc";
    $query = $this->db->query($sql);
    return $query->result_array();      
}
function update_snap_user_business_status($businessid,$zoneid,$userid,$status){             
    $data = array('email_status' => $status);
    $this->db->where('business_id', $businessid);
    $this->db->where('zoneid', $zoneid);
    $this->db->where('user_id', $userid);
    $this->db->update('business_approved', $data);

}
function get_all_businesses_approved_in_newsletter($zone,$user){        
        $sql="SELECT a.id as nid,a.user_id as user,a.status as approved,b.id,b.name,c.id as zoneid,c.name as zone_name from newsletter_approved a,business b,sales_zone c where a.business_id=b.id and a.zoneid=c.id and a.user_id=".$user." order by a.id desc";       
        $query = $this->db->query($sql);
        return $query->result_array();      
    }
    
    
function get_all_interest_group_for_user($zone,$user,$type){
    if($type==2){
        $table="business c,ads_setting_preferences e";
        $where=" and a.createdby_id=c.id and c.id=e.businessid and e.settingszoneid=d.id";
        $sel="c.name as name";      
    }else if($type==3){
        $table="organization c";
        $where=" and a.createdby_id=c.id and c.zoneid=d.id";
        $sel="c.name as org_name";      
    }
    $sql="SELECT a.id as u_ig_id,b.id as ig_id,b.name as ig_name,".$sel.",d.name as zone_name from 
user_group_interest a, group_interest b,".$table.",sales_zone d where a.interest_groupid=b.id ".$where." and a.user_id=".$user." and a.zone_id=".$zone." and a.type=".$type." order by c.name asc";     
    $query = $this->db->query($sql);
    return $query->result_array();      
}
function delete_interest_group_for_user($id){
        $data = array();
        $data['id'] = $id;        
        $this->db->delete('user_group_interest', $data);
}
function get_profile_update($id,$fn,$ln,$phone, $carrier){
    $data = array('first_name' => $fn, 'last_name'=>$ln , 'phone'=>$phone, 'carrier'=>$carrier);    //Added 'phone'=>$phone & 'carrier'=>$carrier on 28/5/14
    $this->db->where('id', $id);
    $this->db->update('users', $data);
    echo 'Successfully Updated.';
}
function delete_newsletter_user($id){
        $data = array();
        $data['id'] = $id;        
        $this->db->delete('newsletter_approved', $data);
}
}