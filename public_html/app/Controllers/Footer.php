<?php



class Footer extends  CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        $this->load->library('ion_auth');

        $this->load->libra("admin/Business", "business");

        $this->load->library('form_validation');

        $this->load->helper('url');

        $this->load->helper("time_helper");

        $this->load->model("admin/Category_model", "category");

        $this->load->model("admin/Announcement_model", "announcements");

        $this->load->model("admin/Ads_model", "ads");

        $this->load->model("admin/Sales_zone", "sales_zone");

        $this->load->model("admin/Business", "business");

        $this->load->database();

    }



    public function index()

    {

    }



    public function addbusiness($id)

    {

        $data = array();

        $data['right_container'] = $this->load->view("footer/addbusiness", $data, true);

        $data['zone'] =  $this->sales_zone->get_zone($id);

        $this->load->view("header", $data);

        $this->load->view("content", $data);

        $this->load->view("footer", $data);

    }

    public function contactus($id)

    {

        $data = array();

        $data['right_container'] = $this->load->view("footer/contactus", $data, true);

        $data['zone'] =  $this->sales_zone->get_zone($id);

        $this->load->view("header", $data);

        $this->load->view("content", $data);

        $this->load->view("footer", $data);

    }

    public function mobile($id)

    {

        $data = array();

        $data['right_container'] = $this->load->view("footer/mobile", $data, true);

        $data['zone'] =  $this->sales_zone->get_zone($id);

        $this->load->view("header", $data);

        $this->load->view("content", $data);

        $this->load->view("footer", $data);

    }

    public function legal($id)

    {

        $data = array();

        $data['right_container'] = $this->load->view("footer/legal", $data, true);

        $data['zone'] =  $this->sales_zone->get_zone($id);

        $this->load->view("header", $data);

        $this->load->view("content", $data);

        $this->load->view("footer", $data);

    }

    public function test($id)

    {

        $data = array();

        $data['left_container'] = "<b>This is on the left</b>";

        $data['right_container'] = "<b>This on the right</b>";

        $data['zone'] =  $this->sales_zone->get_zone($id);

        $this->load->view("header", $data);

        $this->load->view("content", $data);

        $this->load->view("footer", $data);

    }



}

