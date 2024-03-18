<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Joblistings extends CI_Controller
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
    }

    public function load($style)
    {
        $this->output->set_content_type('text/css');
        $this->load->view("styles/stylesheets/$style");
    }

    //Testing Source Control
    public function load_job($business_id)
    {
        $data = array();
        $data['some_dood'] = "Some Dude";

        $result = $this->load->view("default/job_listing", $data, true);
    }

    public  function send_job($job_id, $mailto)
    {

    }


}

