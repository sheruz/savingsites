<?php

set_time_limit(0);

class Pbg_management extends CI_Controller {



    function __construct()

    {

        parent::__construct();

        $this->load->library('ion_auth');

        $this->load->library('session');

        $this->load->library('form_validation');

        $this->load->helper('url');

        $this->load->model("admin/Category_model", "category");

        $this->load->model("Dialog_result", "dr");

        $this->load->database();

        $this->load->helper("time_helper");

        $this->load->model("admin/Users", "users");

        //$this->load->model("admin/Business_type_model", "business_type");

		$this->load->model("admin/Category_management_model", "category_management");

        $this->load->model("admin/Sales_rep", "sales_reps");

        $this->load->model("admin/Business", "business");

        $this->load->model("admin/Ads_model", "ads");

        $this->load->model("admin/Sales_zone", "sales_zone");
        $this->load->model("admin/Uploadmovers", "uploadmovers");
        $this->load->config('security', TRUE);

   

        $this->tierI = $this->config->item('Tier_I');

        $this->tierII = $this->config->item('Tier_II');

        $this->tierIII = $this->config->item('Tier_III');

   

    }

  

    function index($zone = false,$msg="")

    {

       if (!$this->ion_auth->logged_in())

        {

            //redirect them to the login page

            redirect('auth/login', 'refresh');

        }

        elseif (!$this->ion_auth->in_group(array( "Tier I", "Tier II" )))

        {

            //redirect them to the home page because they must be an administrator to view this

            redirect($this->config->item('base_url') . (!empty($zone) ? "index.php?zone=".$zone : ""), 'refresh');

        }

        

        if($this->ion_auth->in_group("Tier I"))

        {

            $tiers = "Tier I";

        }

        else if($this->ion_auth->in_group("Tier II"))

        {

            $tiers = "Tier II";

        }

        else

        {

            $tiers = "Tier III";

        }



     

        $data = array();

        $data['tier'] = $tiers;

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/category_type.inc.js");

        //$data['business_types'] = $this->business_type->get_all_business_types_name();

		//$data['categories'] = $this->category_management->get_all_categories();

		$data['categories'] = $this->category_management->get_all_categories();
        $data['local_directory_sales'] = $this->uploadmovers->local_directory_sales_dup();
		//var_dump($data['categories']);		
        /*$data['getpaidzips'] = $this->uploadmovers->getpaidzips();*/
        $data["scripts"] = $scripts;

        $data["firstName"] = $this->ion_auth->user()->row()->first_name;

        $data["page_name"] = "category_management";
        $data['msg'] = " ";
        $this->load->view("admin/header", $data);

        $this->load->view("admin/admin_buttons", $data);

        $this->load->view("admin/pbg.inc.php", $data);

		//$this->load->view("admin/subcategory_type.inc.php", $data);

        //$this->load->view("admin/category_type.table.php",$data);//var_dump($data);

        $this->load->view("admin/footer");

		//var_dump($data);

     //   redirect("admin");

    }

	
public function do_upload()
        {
       if (!$this->ion_auth->logged_in())

        {

            //redirect them to the login page

            redirect('auth/login', 'refresh');

        }

        elseif (!$this->ion_auth->in_group(array( "Tier I", "Tier II" )))

        {

            //redirect them to the home page because they must be an administrator to view this

            redirect($this->config->item('base_url') . (!empty($zone) ? "index.php?zone=".$zone : ""), 'refresh');

        }

        

        if($this->ion_auth->in_group("Tier I"))

        {

            $tiers = "Tier I";

        }

        else if($this->ion_auth->in_group("Tier II"))

        {

            $tiers = "Tier II";

        }

        else

        {

            $tiers = "Tier III";

        }



     

        $data = array();

        $data['tier'] = $tiers;

        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/category_type.inc.js");

        //$data['business_types'] = $this->business_type->get_all_business_types_name();

		//$data['categories'] = $this->category_management->get_all_categories();

		$data['categories'] = $this->category_management->get_all_categories();

		//var_dump($data['categories']);		

        $data["scripts"] = $scripts;

        $data["firstName"] = $this->ion_auth->user()->row()->first_name;

        $data["page_name"] = "category_management";

        $this->load->view("admin/header", $data);

        $this->load->view("admin/admin_buttons", $data);
        	$cur_dir = getcwd();
                $config['upload_path']          = $cur_dir.'/uploads/docs';
                $config['allowed_types']        = 'csv';
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('userfile'))
                {
                        $error = array('error' => $this->upload->display_errors());

                        $this->load->view('admin/pbg.inc', $error);
                }
                else
                {
                        $uploaddata = array('upload_data' => $this->upload->data());
                        $string = fopen($uploaddata['upload_data']['full_path'], "r");
                        $data['full_path_file'] =$uploaddata['upload_data']['full_path'];

                        while(! feof($string)){$line_of_text[] = fgetcsv($string, 1024);}
                        fclose($string);
						$data['allcsv'] = $line_of_text;
					 $this->load->view('admin/upload_movers', $data);

					 
						
                }
                $this->load->view("admin/footer");
        }

public function uploadcsv($value='')
{
    $string = fopen($_REQUEST['fullfilename'], "r");
    while(! feof($string)){$line_of_text[] = fgetcsv($string, 1024);}
    $b=array_flip(array('first_name'=>$_REQUEST['first_name'],'last_name'=>$_REQUEST['last_name'],'postal_address'=>$_REQUEST['postal_address'],'zip'=>$_REQUEST['zip'],'month_moved'=>$_REQUEST['month_moved'],'phone_number'=>$_REQUEST['phone_number']));
    foreach (array_slice($line_of_text,1) as $value1) {
        
    if (!empty($value1)) {
    $name_age_map = array_combine($line_of_text[0],$value1);
    $new_array = array();
    foreach($b as $key=>$value){if(array_key_exists($key, $name_age_map)){$new_array[$value] = $name_age_map[$key];}}
    
    $data['business_types'] = $this->uploadmovers->insertmovers($new_array);
    }
    }
    $pbgmsg = array('text'=>'<p>Your file sucessfully uploaded.</p>','color'=>'#228B22','display_id'=>"uploadmovers");
    $this->session->set_flashdata('pbg_msg',$pbgmsg);
  redirect('pbg_management', 'refresh');

}
public function downloadcsv($value='')
{
    $datetimearr = explode("-",$_REQUEST['moversdownloaddate']);
    if (!empty($_REQUEST['moversdownloaddate'])) {
    $data['getpaidzips'] = $this->uploadmovers->getpaidzips($datetimearr[1],$datetimearr[0]);
    $list = array("First name","Last name","Postal address","Zip","Month moved","Phone number","Movers URL");
    $cur_dir = getcwd(); $datetime = $_REQUEST['moversdownloaddate']."_".date('mdY', time());
    $downloadurl =$cur_dir."/uploads/docs/movers_details_". $datetime .".csv";
    $getfile = base_url()."uploads/docs/movers_details_". $datetime .".csv";
    $file = fopen($downloadurl,"w");
    fputcsv($file,$list);
    foreach ($data['getpaidzips'] as $line)
    {
    $multipleWhere = array('id' => $line['movers_id']);
    $data= array('downloaded' => 'y',
                'download_at' =>date('y-m-d h:i:s'));
    $this->uploadmovers->changestatus($multipleWhere,$data);
    array_shift($line);
    fputcsv($file,$line);
    }
    fclose($file);
    header("Location: $getfile");
    }
    else{
    $pbgmsg = array('text'=>'<p>Select month of download.</p>','color'=>'#228B22','display_id'=>"downloadcsv");
    $this->session->set_flashdata('pbg_msg',1);
    redirect('pbg_management', 'refresh'); 
    }
}
function postcarddelivered($value='')
{
    $datetimearr = explode("-",$_REQUEST['moversdeliverdddate']);
    $month = $datetimearr[1]/*date("m")*/;
    $year  = $datetimearr[0]/*date("Y")*/;
   if ($_REQUEST['delivered'] == '1'){
        $multipleWhere = array('month' => $month, 'year' => $year);
    echo "Checked";
    $value = array('delivered' => 'y',
        'delivered_at' =>date('y-m-d h:i:s'),
        'status'    =>'0');
    $lastqry = $this->uploadmovers->changestatus($multipleWhere,$value);
    $debitpbgcredit = $this->uploadmovers->debitpbgcredit($month,$year);
    redirect('pbg_management', 'refresh'); 
   }else{
    redirect('pbg_management', 'refresh'); 
   }
}
public function pbgdeliverdornot()
{
    $datetimearr = explode("-",$_REQUEST['date']);
    $month = $datetimearr[1];
    $year  = $datetimearr[0];
    $multipleWhere = array('month' => $month, 'year' => $year,'delivered'=>'n');
    $data = $this->uploadmovers->deliverdorno($multipleWhere);
    if(empty( $data )) {
        echo '0';
    }else{
        echo '1';
    }
/*    if (!empty($lastqry)){
       return "haveto";
    }
    else{
        return 'not_haveto';
    }*/
}
public function updatepackage($value='')
{
	$user_id=0;
	$content = "<strong>Already included in your cost</strong> are the 10 free cash certificate credits that have a residential retail value of $5.00 used to get the new mover to join your free SNAP emailing list. If the new mover does not join your free SNAP email list ";
/*	echo "<pre>";
	print_r($_REQUEST);
	echo "</pre>";*/
    $chkpkgarr = array();
	for ($i=0; $i< sizeof($_REQUEST['packagename']); $i++) {
		if ($_REQUEST['packagename'][$i]=="gold level") {
			$popular = "y";
		}
		else{
			$popular = "n";
		}
$chkpkgarr[$i] = $_REQUEST['packagename'][$i];
$data1 = array(
    'meta_key' => $_REQUEST['packagename'][$i],
    'price' => $_REQUEST['price'][$i],
    'postcard' => $_REQUEST['postcard'][$i],
    'single' => $_REQUEST['single'][$i],
    'payammount' => $_REQUEST['payammount'][$i],
    'content' =>$content,
    'popular' =>$popular,
    'user_id' => $user_id
     );
     $this->uploadmovers->updatepackages($data1);
	}
    $this->uploadmovers->chkpkgarr($chkpkgarr);
    $pbgmsg = array('text'=>'<p>Package updated.</p>','color'=>'#228B22','display_id'=>"managepackages");
    $this->session->set_flashdata('pbg_msg',$pbgmsg);
     redirect('pbg_management', 'refresh');
}

}