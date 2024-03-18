<?php class Util extends CI_Controller { 
    function __construct(){ 
        parent::__construct(); 
        $this->load->library('ion_auth');
        $this->load->library('session');
       
        $this->load->helper('url');
        $this->load->model("Dialog_result", "dr");
        $this->load->model("admin/Ads_model", "ad");
        $this->load->model("admin/Users", "users");
        $this->load->model("admin/Sales_rep", "sales_reps");
        $this->load->model("admin/Business", "business");
        $this->load->model("admin/Sales_zone", "zone");
        $this->load->model("User","users_model");
        $this->load->config('security', TRUE);
        $this->load->database();        
        @set_magic_quotes_runtime(0); // Kill magic quotes
        $config['charset'] = 'utf-8';       
    }
        
    // For peekaboo access from Savings Sites
    function peekaboo_access(){
        $data = array();
        $usersid =  !empty($_REQUEST['usersid']) ? $_REQUEST['usersid'] : '';
        $type_id = !empty($_REQUEST['type_id']) ?  $_REQUEST['type_id'] : ''; 
        $zoneId = !empty($_REQUEST['zoneId']) ? $_REQUEST['zoneId'] : ''; // This is group id
        $group_type = !empty($_REQUEST['group_type']) ? $_REQUEST['group_type'] : '';
        if($usersid == '' || $group_type ==''){
            $username = ''; $group_id =''; $zoneid = $zoneId;
        }else{
            if($group_type ==4){
                $member_type= 3;
                $zoneid = $type_id;
                $select =" a.username";
                $table =" users as a, sales_zone as b";
                $where1 =" a.id = b.sales_rep_id and";
                $where2 =" a.id =".$usersid." and b.id=".$type_id;
                $where = $where1.' '.$where2; 
            }else if($group_type =='resident_user'){
                $member_type= 1;
                $group_type = 10;
                $zoneid = $zoneId;
                $select =" a.username";
                $table =" users as a";
                $where1 ="";
                $where2 =" a.id =".$usersid;
                $where = $where1.' '.$where2; 
            }else if($group_type =='business'){
                $member_type= 2;
                $group_type = 5;
                $zoneid = $zoneId;
                $select =" e.username";
                $table =" business as a , ads as b, users_groups d, users as e";
                $where1 =" d.user_id=a.business_owner_id and e.id=a.business_owner_id and";
                $where2 =" a.id=".$type_id;
                $where = $where1.' '.$where2.' group by e.username'; 
            }

            //$sql="select d.group_id,e.username,a.name from business as a , ads as b, sales_zone as c, users_groups d, users as e where d.user_id=a.business_owner_id and e.id=a.business_owner_id and c.id='$zoneid' and a.id='$businessid' group by e.username";

            $sql="select $select from $table where $where"; 
            $query = $this->db->query($sql);
            $result = $query->result_array();
            $data['peekaboo_other_page'] = $result; 
           //$group_id = $result['0']['group_id'];
            $group_id = $group_type;
            $username =$result['0']['username'];
            $business_name = $result['0']['name'];
              
            $peekaboo_username_sql = "Select a.username from users a,tbl_member b where a.username=b.user_name and b.user_name='".$username."'"; 
            $peekaboo_username_query = $this->db->query($peekaboo_username_sql);
            $peekaboo_username_result = $peekaboo_username_query->result_array();
            $peekaboo_username = $peekaboo_username_result['0']['username'];
            if($peekaboo_username==''){                
                $ss_user_sql = "Select * from users where username='".$username."'";
                $ss_user_query = $this->db->query($ss_user_sql);
                $ss_user_result = $ss_user_query->result_array(); 

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
                          
                /*if($approval!=3){
                      $data_peekaboo=array(
                         'fName'=>$peekaboo_first_name_exists,
                         'lName'=>$peekaboo_last_name_exists,
                         'email'=>$peekaboo_email_exists,
                         'address1'=>$peekaboo_Address_exists,
                         'company_name'=>$business_name,
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
                }else{*/
                      $data_peekaboo=array(
                             'fName'=>$peekaboo_first_name_exists,
                             'lName'=>$peekaboo_last_name_exists,
                             'email'=>$peekaboo_email_exists,
                             'address1'=>$peekaboo_Address_exists,
                             'company_name'=>$business_name,
                             'city_name'=>$peekaboo_City_exists,
                             'state_name'=>$peekaboo_State_Code_exists,
                             'post_code'=>$peekaboo_Zip_exists,
                             'phone'=>$peekaboo_phone_exists,
                             'user_name'=>$peekaboo_username_exists,
                             'password'=>sha1('changepasword'),
                             'activated'=>'yes',
                             'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),
                             'member_type'=> $member_type,
                             'zone_id'=> $zoneId
                        );
                //}
                $data_peekaboo_insert= array_filter($data_peekaboo);
                $this->db->insert('tbl_member', $data_peekaboo_insert);
                $peekaboo_id = $this->db->insert_id();  
            }
        }
        $url = "http://peekabooauctions.com/ss_userlogin_from_peekaboo.php?peekaboo_username=".$username."&group_id=".$group_id."&zoneid=".$zoneid; //var_dump($url);exit;
        //echo($this->dr->GetDR($username, $group_id, $zoneid, "0"));
        $dataArr = array("username"=>$username, "group"=>$group_id, "zone"=>$zoneid);
        echo json_encode($dataArr); 
    }


    public function get_peekaboo_credits(){

        $usersid =  !empty($_REQUEST['usersid']) ? $_REQUEST['usersid'] : '';

        $ss_user_sql = "Select bonus_credit from tbl_member where user_id='".$usersid."'";
        $ss_user_query = $this->db->query($ss_user_sql);
        $ss_user_result = $ss_user_query->row_array(); 
        $credit = $ss_user_result['bonus_credit'];
        echo $credit;
        //echo json_encode($ss_user_result); 
    }

    








     //echo 1; 
        /*$data = array();
        $usersid =  !empty($_REQUEST['usersid']) ? $_REQUEST['usersid'] : '';
        $zoneid = !empty($_REQUEST['zoneid']) ?  $_REQUEST['zoneid'] : ''; 
        $approval = !empty($_REQUEST['approval']) ? $_REQUEST['approval'] : ''; // This is group id
        $group_type = !empty($_REQUEST['group_type']) ? $_REQUEST['group_type'] : '';
        //$sql="select d.group_id,e.username,a.name from business as a , ads as b, sales_zone as c, users_groups d, users as e where d.user_id=a.business_owner_id and e.id=a.business_owner_id and c.id='$zoneid' and a.id='$businessid' group by e.username";
        if($usersid == '' || $group_type ==''){
            $username = ''; $group_id ='';
        }else{
            if($group_type ==4){
                $table =" users as a, sales_zone as b";
                $where1 =" a.id = b.sales_rep_id and";
                $where2 =" a.id =".$usersid." and b.id=".$zoneid;
                $where = $where1.' '.$where2; 
            }else if($group_type ==10){
                $table =" users as a";
                $where1 ="";
                $where2 =" a.id =".$usersid;
                $where = $where1.' '.$where2; 
            }
            $sql="select a.username from $table where $where"; 
            $query = $this->db->query($sql);
            $result = $query->result_array();
            $data['peekaboo_other_page'] = $result; 
           //$group_id = $result['0']['group_id'];
            $group_id = $group_type;
            $username =$result['0']['username'];
            $business_name = $result['0']['name'];
              
            $peekaboo_username_sql = "Select a.username from users a,tbl_member b where a.username=b.user_name and b.user_name='".$username."'"; 
            $peekaboo_username_query = $this->db->query($peekaboo_username_sql);
            $peekaboo_username_result = $peekaboo_username_query->result_array();
            $peekaboo_username = $peekaboo_username_result['0']['username'];
            // Checking savingssites business owner doesn't exist the peekaboo account with same their business username and passrord. Those business will create peekaboo account with same same savingssites username and password.   
            if($peekaboo_username==''){
                    
                $ss_user_sql = "Select * from users where username='".$username."'";
                $ss_user_query = $this->db->query($ss_user_sql);
                $ss_user_result = $ss_user_query->result_array(); 

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
                          
                if($approval!=3){
                      $data_peekaboo=array(
                         'fName'=>$peekaboo_first_name_exists,
                         'lName'=>$peekaboo_last_name_exists,
                         'email'=>$peekaboo_email_exists,
                         'address1'=>$peekaboo_Address_exists,
                         'company_name'=>$business_name,
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
                }else{
                      $data_peekaboo=array(
                             'fName'=>$peekaboo_first_name_exists,
                             'lName'=>$peekaboo_last_name_exists,
                             'email'=>$peekaboo_email_exists,
                             'address1'=>$peekaboo_Address_exists,
                             'company_name'=>$business_name,
                             'city_name'=>$peekaboo_City_exists,
                             'state_name'=>$peekaboo_State_Code_exists,
                             'post_code'=>$peekaboo_Zip_exists,
                             'phone'=>$peekaboo_phone_exists,
                             'user_name'=>$peekaboo_username_exists,
                             'password'=>sha1('changepasword'),
                             'activated'=>'yes',
                             'activation_number'=>str_shuffle('dGhKYW4wNlR1ZUphbjIwMTYyZHlqb3UxNjAxMDUwNjAxMDA'),
                             'member_type'=>2
                        );
                }
                $data_peekaboo_insert= array_filter($data_peekaboo);
                $this->db->insert('tbl_member', $data_peekaboo_insert);
                $peekaboo_id = $this->db->insert_id();  
            }
        }
        $url = "http://peekabooauctions.com/ss_userlogin_from_peekaboo.php?peekaboo_username=".$username."&group_id=".$group_id."&zoneid=".$zoneid; //var_dump($url);exit;
        //echo($this->dr->GetDR($username, $group_id, $zoneid, "0"));
        $dataArr = array("username"=>$username, "group"=>$group_id, "zone"=>$zoneid);
    }

        echo json_encode($dataArr); 

    }*/
}