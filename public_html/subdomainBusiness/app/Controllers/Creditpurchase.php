<?php
class Creditpurchase extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model("Dialog_result", "dr");
        $this->load->database();
        $this->load->helper("time_helper");
        $this->load->config('security', TRUE);

        $this->tierI = $this->config->item('Tier_I');
        $this->tierII = $this->config->item('Tier_II');
        $this->tierIII = $this->config->item('Tier_III');

    }

    public function index(){
       
    }

    public function thanku(){

        $session_array = $this->session->all_userdata();
        $data['payment_details'] = $_POST;
        $user_id = $session_array['session_zoneid']['sesuserid'];      
        $form_details = json_encode($_POST);

        $getReceiverId = "SELECT `user_id` FROM `users_groups` WHERE `group_id` = 3";
        $getReceiverIdResult = $this->db->query($getReceiverId);
        $receiverIdResult = $getReceiverIdResult ->row();

        $receiver_id = $receiverIdResult->user_id;
       
        $sql = "INSERT INTO 
                        payment(payment_module,receiver_id,payer_id,amount,submission_id,form_id,form_details,time)
                        VALUES(9,".$_POST['zoneid'].",".$user_id.",".$_POST['price'][2].",'".$_POST['submission_id']."','".$_POST['formID']."','".$form_details."',NOW())";

        $result = $this->db->query($sql);

        $getCredits = "SELECT `peekabo_credits` FROM `users_credits` WHERE `payer_id` = ".$user_id." ORDER BY `id` DESC LIMIT 1 ";
        $getCreditsResult = $this->db->query($getCredits);
        $creditResult = $getCreditsResult ->row();
       
        //$credit_amount = $creditResult->peekabo_credits;
        //$newCredits = ( $creditResult->peekabo_credits + $_POST['choosecredit'] );
        $updateZoneOwnerCredits = "UPDATE `zone_owner_credits` SET `credits` = (`credits` + ".$_POST['choosecredit'].") WHERE `user_id` = ".$user_id." ";
        $this->db->query($updateZoneOwnerCredits);

        $updateCredits = "INSERT INTO `users_credits`(receiver_id,payer_id,peekabo_credits,payment_mode,submission_id,time) values(".$receiver_id.",".$user_id.",".$_POST['choosecredit'].",1,".$_POST['submission_id'].",NOW())";
        $updateCreditResult = $this->db->query($updateCredits);

        
        $data['right_container'] = $this->load->view("zone/thank_you",$data,true);
        
    } 
   
    
}