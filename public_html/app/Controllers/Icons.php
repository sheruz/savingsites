<?php

class Icons extends CI_Controller {



    function __construct()

    {

        parent::__construct();

        $this->load->library('ion_auth');

        $this->load->library('session');

        $this->load->library('form_validation');

        $this->load->helper('url');

        $this->load->helper('time_helper');

        $this->load->model("Dialog_result", "dr");

        $this->load->model("admin/Ads_model", "ad");

   		$this->load->model("admin/Announcement_model", "announcements");
        $this->load->model("admin/Sales_zone", "sales_zone");
        $this->load->model("States", "states");
		

        $this->load->model("admin/Category_model", "category");

        $this->load->model("admin/Users", "users");

        $this->load->model("admin/Business_type_model", "business_type");

        $this->load->model("admin/Sales_rep", "sales_reps");

        $this->load->model("admin/Business", "business");

        $this->load->model("admin/Sales_zone", "zone");

        $this->load->config('security', TRUE);

        $this->load->database();



        $this->tierI = $this->config->item('Tier_I');

        $this->tierII = $this->config->item('Tier_II');

        $this->tierIII = $this->config->item('Tier_III');

        @set_magic_quotes_runtime(0); // Kill magic quotes

        

    }
	

    public function load($category, $subcategory, $isBlack = false)
    {
        $blackCode = empty($isBlack) ? "white" : "black";

        if(!$this->load->image("assets/icons/$category/$blackCode/$subcategory" . ".png"))
        {
            $this->load->image("assets/icons/others" . (empty($isBlack) ? "_white" : "") . ".png");
        }

    }
    
    public function load_menu_image($subcategory_id, $isBlack = false)

    {

    	$blackCode = empty($isBlack) ? "white" : "black";

    
    	$sql = "select t1.name as SubCategory, t1.icon_directory as SubCategory_Directory, t2.name as Category, t2.icon_directory as Category_Directory from business_category as t1 
    	join business_type as t2 on t2.id = t1.business_type_id

    	where t1.id = $subcategory_id";
    	
    	$query = $this->db->query($sql);

    	$subcatDir = '';
    	$catDir = '';

    	if($query->num_rows()==1)

    	{

    		$result = $query->row();
    		$subcatDir = empty($result->SubCategory_Directory) ? strtolower($result->SubCategory) : $result->SubCategory_Directory;

    		$catDir = empty($result->Category_Directory) ? strtolower($result->Category) : $result->Category_Directory;

    	}
    	

    	if(!$this->load->image("assets/icons/".$catDir."/".$blackCode."/".$subcatDir.".png"))

    	{

    		$this->load->image("assets/icons/others" . (empty($isBlack) ? "_white" : "") . ".png");

    	}

    

    }

    

}



