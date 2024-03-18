<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ss_classifieds extends CI_Controller {



  // constructor function to load dependency

  public function __construct() {

  	parent::__construct();

    $this->load->helper('url');

    $this->load->library('ion_auth');

    $this->load->database();

    $this->load->model('User','user');

  }

  /**

    * @desc method to create a new url

    * For neighbors classifieds login

    * @accept post data

    * @return unique url for neighbors classifieds admin login

  */

  public function createNeighborsAdmin() {

    // check if cookie exists during zone login

	//echo json_encode($_POST);

    $userName = isset($_COOKIE['neighbors_classifieds_username']) ? $_COOKIE['neighbors_classifieds_username'] : '';

    $password = isset($_COOKIE['neighbors_classifieds_password']) ? $_COOKIE['neighbors_classifieds_password'] : '';

    $zoneId   = isset($_COOKIE['neighbors_classifieds_zoneid']) ? $_COOKIE['neighbors_classifieds_zoneid'] : '';

    $userId   = isset($_COOKIE['neighbors_classifieds_userid']) ? $_COOKIE['neighbors_classifieds_userid'] : '';

    //$email    = isset($_COOKIE['neighbors_classifieds_email']) ? $_COOKIE['neighbors_classifieds_email'] : '';

   // echo $email; 

    $response = array();

    if (!empty($userName) && !empty($password) && !empty($zoneId) && !empty($userId)) {

      //$response['status'] = $this->input->post('userId');

      if(($zoneId != $this->input->post('zoneId')) || ($userId != $this->input->post('userId'))) {

        $response['status'] = 0;

        $response['message'] = 'You are not authorized to access classifieds admin panel';

      } 

      else {

         $password = md5($password);

         $checkUserExists = $this->checkNeighborsClassifiedsAdminExists($zoneId);

         $checkUserExistsFlaccount = $this->checkNeighborsClassifiedsAdminFlaccountsExists($zoneId);

         $randomToken = $this->generateRandomString(10);

         //$response['token'] = 10;

         if($checkUserExists && $checkUserExistsFlaccount) {

          // update random token 

          $sqlUpdateToken = "UPDATE fl_admins SET `token` = '".$randomToken."' WHERE `id`=".$checkUserExists;

          if($this->db->query($sqlUpdateToken)) {

            $response['status'] = 1;

            $response['token'] = $randomToken;

            $response['zoneId'] = $this->input->post('zoneId');

            $response['message'] = 'successfully updated';

          }

         } else {

           $sqlInsertNewSql = "INSERT INTO fl_admins SET `User` = '".$userName."',`Pass`= '".$password."',`Type` = 'super',`Status`='active',`ZoneId`=".$zoneId;

           if($this->db->query($sqlInsertNewSql) && $this->insertConfig($zoneId,$userId)) {

            $sqlInsertNewSqlFlaccount = "INSERT INTO fl_accounts SET `Type` = 'dealer',`Username`= '".$userName."',`Own_address` = '".$userName."',`Password`='".$password."',`First_name`='".$userName."'";

            $this->db->query($sqlInsertNewSqlFlaccount);

            $response['status'] = 1;

            $response['token'] = $randomToken;

            $response['zoneId'] = $this->input->post('zoneId');

            $response['message'] = 'successfully Inserted';

           } else {

            $response['status'] = 0;

            $response['message'] = 'something went wrong during creation new admin';

           }

         }

      }

    }

    echo json_encode($response);

  }

  /**

    * @desc method to check all set cookie

  */

  public function checkAllSetCookie() {

    echo "<pre>";

    print_r($_COOKIE);

  }

  /**

    * @desc method to check if admin exists for this zone

    * @param $zoneId

    * @return boolean

  */

  public function checkNeighborsClassifiedsAdminExists($zoneId) {

    $sqlCheckAdminExists = "SELECT id FROM fl_admins WHERE ZoneId =".$zoneId;

    $queryCheckAdminExists = $this->db->query($sqlCheckAdminExists);

    if($queryCheckAdminExists->num_rows() > 0) {

      $getResultedId = $queryCheckAdminExists->row();

      return $getResultedId->id;

    }

    return false;

  }

  /**

    * @desc method to check if admin exists for this zone

    * @param $zoneId

    * @return boolean

  */

  public function checkNeighborsClassifiedsAdminFlaccountsExists($zoneId) {

    $sqlCheckAdminExists = "SELECT id FROM fl_accounts WHERE ZoneId  =".$zoneId;

    $queryCheckAdminExists = $this->db->query($sqlCheckAdminExists);

    if($queryCheckAdminExists->num_rows() > 0) {

      $getResultedId = $queryCheckAdminExists->row();

      return $getResultedId->id;

    }

    return false;

  }

  /**

    * @desc method to generate a random string

    * @param void length

    * @return $randomString

  */

  public function generateRandomString($length = 10) {

    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);

  }



/**

  * @desc method to insert in config table

  *

*/

  public function insertConfig($zoneId,$userId){

    $userDetails = $this->user->get_user_details($userId);

    $adminEmail = $userDetails['email'];

    $adminName  = $userDetails['first_name'].' '.$userDetails['last_name'];

    $configSql = "INSERT INTO fl_config(`Group_ID`,`Position`,`Key`,`Default`,`Type`,`Data_type`,`ZoneId`,`display`)

                  VALUES

                    (7,2,'notifications_email','$adminEmail','text','varchar',".$zoneId.",1),

                    (7,2,'site_main_email','$adminEmail','text','varchar',".$zoneId.",1),

                    (7,2,'owner_name','$adminName','text','varchar',".$zoneId.",1),

					          (1,36,'facebook_page','demofacebook.com','text','varchar',".$zoneId.",1),

                    (1,2,'timezone','','select','varchar',".$zoneId.",1),

                    (1,32,'system_currency','$','text','varchar',".$zoneId.",1),

                    (1,32,'system_currency_code','USD','text','varchar',".$zoneId.",1),

                    (1,36,'twitter_page','','text','varchar',".$zoneId.",1)";

    if($this->db->query($configSql)) {

      return true;

    }

    return false;

  }



}





?>