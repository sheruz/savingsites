<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Pdf_download extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->library('ion_auth');

        $this->load->library('session');

        $this->load->library('form_validation');

        $this->load->helper('url');

        $this->load->helper("time_helper");

        $this->load->model("admin/Category_model", "category");

        $this->load->model("admin/Announcement_model", "announcements");

        $this->load->model("admin/Ads_model", "ads");

        $this->load->model("admin/Sales_zone", "sales_zone");

        $this->load->model("States", "states");

        $this->load->database();

		$this->load->helper('download');

    }

    public function index($zone = false){

		

	}

	function municipality(){

		$data =file_get_contents("downloads/Letter_to_the_Municipality.docx");

		$name = 'Letter_to_the_Municipality.docx';

		force_download($name, $data); 

	}

	function presentation_on_demand($adid=false){

		//$presentation_on_demand=$_REQUEST['presentation_on_demand'];

		//var_dump($id); exit;

		$sql="select id,docs_pdf from ads where id=".$adid;

		$query = $this->db->query($sql);

		$result= $query->result_array();

		//var_dump($result);

		$_docs_pdf=$result[0]['docs_pdf'];

		//var_dump($_docs_pdf);

		$data =file_get_contents("uploads/docs/".$_docs_pdf);

		$name = $_docs_pdf;

		force_download($name, $data); 

	}
	function food_menu($adid=false){
		
		$sql="select id,foodmenu from ads where id=".$adid;

		$query = $this->db->query($sql);

		$result= $query->result_array();

		//var_dump($result);

		$foodmenu=$result[0]['foodmenu'];

		//var_dump($_docs_pdf);

		$data =file_get_contents("uploads/food_menu/".$foodmenu);

		$name = $foodmenu;

		force_download($name, $data); 

	}
	function market_materials_zone($id=false){		

		$sql="select * from marketing_materials where id=".$id;

		$query = $this->db->query($sql);

		$result= $query->result_array();

		$name='mm_'.$result[0]['zoneid'].'~!~'.$result[0]['timestamp'].'~!~'.$result[0]['name'];

		$data=file_get_contents("uploads/market_materials/".$name);

		force_download($result[0]['name'], $data); 

	}

	function download_letters_by_organization($id=false){		

		$sql="select * from uploaded_letters where id=".$id;

		$query = $this->db->query($sql);

		$result= $query->result_array();

		$name=$result[0]['zoneid'].'~!~'.$result[0]['timestamp'].'~!~'.$result[0]['name'];

		$data=file_get_contents("uploads/upload_letters/".$name);

		force_download($result[0]['name'], $data); 

	}
	
}



