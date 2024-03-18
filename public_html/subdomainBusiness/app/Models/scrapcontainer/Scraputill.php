<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
  * This class is used for
  * All scrap functionality
*/
class Scraputill extends CI_Model {

  public function __construct() {
  	parent::__construct();
  	$this->load->database();
  }
  /**
    * @desc method to get claimedzip details
    * @return $claimedZipArray
  */
  public function getAllClaimedZips() {
  	$sql = "SELECT 
  				a.zip AS zipCode,
  				a.uid AS userId,
          a.approved AS approvedStatus,
  				b.id AS zoneId
  			FROM tblClaimedZips a INNER JOIN sales_zone b
  			ON (a.uid = b.sales_rep_id)";
   $queryClaimedZip = $this->db->query($sql);
   return $queryClaimedZip->result_array();
  }
	
}

?>