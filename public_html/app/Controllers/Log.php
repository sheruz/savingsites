<?php
 if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log extends CI_Controller {

	//private $_logviewer;

	public function __construct() {
		parent::__construct();
		/*require_once(APPPATH.'third_party/Classes/LogViewer/src/CILogViewer.php');
		$this->_logviewer = new \CILogViewer\CILogViewer();*/

	}
	/**
	  * Method to view logviewer

	*/
	public function index() {
		//echo $this->_logviewer->showLogs();
		$filename = 'log-'.date('Y-m-d').'.php';
		echo $filename;
		/*if(file_exists(APPPATH.'logs/'.$filename)) {
			$fileData = file_get_contents(APPPATH.'logs/'.$filename);

		} else {
			$fileData = 'No file found';
		}
		
		echo $fileData;*/
	}
}


?>