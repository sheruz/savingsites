<?php
 if(!defined('BASEPATH')) exit('No direct script access allowed');
 class Scrapdata extends CI_Controller {

 	// constructor function to load all library
 	public function __construct() {
 		parent::__construct();
 		$this->load->helper('url');
 		$this->load->library('session');
 		$this->load->library('excel');
        $this->load->model('scrapcontainer/Scraputill','scrap_model');
 		$this->load->database();
 	}
 	public function index(){
 		echo "hiii";
 	}
 	/**
 	  * @desc method to get all claimed zip details
 	  * @return csv formatted file
 	*/
 	public function getAllClaimedZips() {
 		$claimedZipDetails = $this->scrap_model->getAllClaimedZips();
 		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Snap_user_list');
		$users_header = array('zipcode'=>'zip code','zoneid'=>'zoneid of claimed zip','approvestatus' => '1 or 0');
		$this->excel->getActiveSheet()->fromArray(array_keys($users_header),NULL,'A1');
		$j=2;
 		foreach ($claimedZipDetails as $zipdetails) {
 			$this->excel->getActiveSheet()->setCellValue('A'.$j, $zipdetails['zipCode']);
 			$this->excel->getActiveSheet()->setCellValue('B'.$j, $zipdetails['zoneId']);
 			$this->excel->getActiveSheet()->setCellValue('C'.$j, $zipdetails['approvedStatus']);
 			$j++;
 		}
 		$filename='claimedzipdetails.csv';
		header("Content-Type: application/force-download");
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'CSV');
		$objWriter->save('php://output');

 		
 	}
 }


?>