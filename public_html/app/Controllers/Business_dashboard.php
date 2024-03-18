<?php
class Business_dashboard extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model("Dialog_result", "dr");
        $this->load->helper("time_helper");
        $this->load->model("admin/Business", "business");
        $this->load->config('security', TRUE);
        $this->load->model("admin/Templates", "template");
        $this->load->model("admin/Business_type_model", "business_type");        
        //$this->load->model("admin/business_dashboard1", "business_dashboard1");
        $this->tierI = $this->config->item('Tier_I');
        $this->tierII = $this->config->item('Tier_II');
        $this->tierIII = $this->config->item('Tier_III');
        $this->load->database();
        @set_magic_quotes_runtime(0); // Kill magic quotes
       
    }
	
    function index()
    {
        if (!$this->ion_auth->logged_in())
        {
            //redirect('auth/login', 'refresh');
			redirect(base_url(), 'refresh');
        }
        elseif (!$this->ion_auth->in_group(array( "Tier I", "Tier II" )))
        {
            redirect($this->config->item('base_url'), 'refresh');
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
        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/business_dashboard.inc.js");
        $data['business_list'] = $this->business->get_all_businesses();
        $data['template_list'] = $this->template->get_all_template();
        $data["scripts"] = $scripts;
        $data["firstName"] = $this->ion_auth->user()->row()->first_name;
        $data["page_name"] = "business_dashboard";
        $this->load->view("admin/header", $data);
        $this->load->view("admin/admin_buttons", $data);
        $this->load->view("admin/business_dashboard.inc.php", $data);
        $this->load->view("admin/business_dashboard.table.php",$data);
        $this->load->view("admin/footer");
    }
    
    function get_subscriber($bus_id)
    {
    	$business_subscriber = $this->business_dashboard1->get_all_subscriber($bus_id);
    	$total=count($business_subscriber);
    	
    	$sitesperpage = 10;
    	$currentpage = 1;
    	$index_limit = 10;
    	$current=1;

    	
    	if (isset($_REQUEST['page']) && ($_REQUEST['page'] + 0) > 0) {
    		$currentpage = $_REQUEST['page'] + 0;
    		$current = $_REQUEST['page'] + 0;
    	}
    	
    	if ($currentpage <= 1) {
    		$LIMIT_CLAUSE = sprintf("LIMIT 0, %s", $sitesperpage);
    	}
    	
    	else
    	{
    		$firstresult = (($currentpage - 1) * $sitesperpage);
    		$LIMIT_CLAUSE = sprintf("LIMIT %s, %s", $firstresult, $sitesperpage);
    	}
    	
    	$business_subscriber = $this->business_dashboard1->get_all_subscriber_page($bus_id,$LIMIT_CLAUSE);
    	
    	$total_pages=ceil($total/$sitesperpage);
    	
    	$start=max($currentpage-intval($index_limit/2), 1);
    	$end=$start+$index_limit-1;
    	
    	
    	
    	$pagination='';
    	$pagination.='<div class="pagination"><ul class="pag_list">';
    	
    	if($current==1) {
    		$pagination.='<li><a class="button light_blue_btn" href="#"><span><span>Previous</span></span></a></li> ';
    	} else {
    		$i = $current-1;
    		$pagination.='<li><a class="button light_blue_btn" title="go to page '.$i.'" rel="nofollow" onclick="get_subscriber('.$bus_id.','.$i.');return false;" href=""><span><span>Previous</span></span></a></li> ';
    		$pagination.='<li><span><span>...</span></span></li> ';
    	}
    	
    	if($start > 1) {
    		$i = 1;
    		$pagination.='<li><a title="go to page '.$i.'" onclick="get_subscriber('.$bus_id.','.$i.');return false;" href="">'.$i.'</a></li> ';
    	}
    	
    	for ($i = $start; $i <= $end && $i <= $total_pages; $i++){
    		if($i==$current) {
    			$pagination.='<li><a class="current_page" href="#"><span><span>'.$i.'</span></span></a></li> ';
    		} else {
    			$pagination.='<li><a title="go to page '.$i.'" onclick="get_subscriber('.$bus_id.','.$i.');return false;" href="">'.$i.'</a></li> ';
    		}
    	}
    	
    	if($total_pages > $end){
    		$i = $total_pages;
    		$pagination.='<li><a title="go to page '.$i.'"  onclick="get_subscriber('.$bus_id.','.$i.');return false;" href="">'.$i.'</a></li> ';
    	}
    	
    	if($current < $total_pages) {
    		$i = $current+1;
    		$pagination.='<li><span><span>...</span></span></li> ';
    		$pagination.='<li><a class="button light_blue_btn" title="go to page '.$i.'" rel="nofollow" onclick="get_subscriber('.$bus_id.','.$i.');return false;" href=""><span><span>Next</span></span></a></li> ';
    	} else {
    		$pagination.='<li><a class="button light_blue_btn" href="#"><span><span>Next</span></span></a></li>';
    	}
    	
    	
    	
    	
    	if(!empty($business_subscriber)){
    		
    		$count=$this->business->subscribe_count($bus_id);
    		$email_count=$this->business->email_count($bus_id);
    		$hot="";
    		
    		if(!empty($email_count))
    		{
    			$email_date = strtotime($email_count->date_time);
    			$pre_tday = strtotime('-2 day');
    			$pre_month = strtotime('-1 month');
    			$current_tday = strtotime('now');
    		
    			if($email_date>$pre_tday && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Hot) </a></div>';
    			}elseif($email_date>$pre_month && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Super) </a></div>';
    			}
    		}
    	?>
    		<input type="hidden" name="hidden_bus_id" id="hidden_bus_id" value="<?php echo $bus_id;?>" />
    		
            
            <div class="sepret-one">
		    				<div class="two-tex-container"><a href="#" onclick="get_subscriber('<?php echo $bus_id;?>','1');return false;" class="act">Short Notice Email(<?php echo $count;?>)</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_template('<?php echo $bus_id;?>');return false;">Template</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_history('<?php echo $bus_id;?>');return false;">History</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="set_category('<?php echo $bus_id;?>');return false;">Category</a></div>
		    				<?php echo $hot;?>
	    				</div><br/>
            <table align="center" id="" class="admin-table" width="950px" cellpadding="0" cellspacing="0">
		        <thead>
		            <tr>
		                <th width="80px">
		                    Id
		                </th>
		                <th width="200px">
		                    First name
		                </th>
		                <th width="250px">
		                    Last name
		                </th>
		                <th width="250px">
		                    Email
		                </th>
		            </tr>
		        </thead>
		        <tbody>
		           <? foreach($business_subscriber as $business_subscriber){?>
		            <tr>
		                <td><?=$business_subscriber['id']?></td>
		                <td><?=$business_subscriber['first_name']?></td>
		                <td><?=$business_subscriber['last_name']?></td>
		                <td><?php echo $business_subscriber['email'];?></td>
		
		            </tr>
		            <?}?>
		            <tr>
		                <td colspan="4"><?=$pagination;?></td>
		            </tr>
		        </tbody>
		    </table>
            
    	<?php 
    	}
    	else{
    	
    		$count=$this->business->subscribe_count($bus_id);
    		$email_count=$this->business->email_count($bus_id);
    		$hot="";
    		
    		if(!empty($email_count))
    		{
    			$email_date = strtotime($email_count->date_time);
    			$pre_tday = strtotime('-2 day');
    			$pre_month = strtotime('-1 month');
    			$current_tday = strtotime('now');
    		
    			if($email_date>$pre_tday && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Hot) </a></div>';
    			}elseif($email_date>$pre_month && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Super) </a></div>';
    			}
    		}
    		?>
    		<div class="sepret-one">
		    				<div class="two-tex-container"><a href="#" onclick="get_subscriber('<?php echo $bus_id;?>','1');return false;" class="act">Short Notice Email(<?php echo $count;?>)</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_template('<?php echo $bus_id;?>');return false;">Template</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_history('<?php echo $bus_id;?>');return false;">History</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="set_category('<?php echo $bus_id;?>');return false;">Category</a></div>
		    				<?php echo $hot;?>
	    				</div><br/>
    		<table align="center" cellpadding="0" cellspacing="0">
	    		<tr>
		               <td colspan="3">No Subscriber Found</td>
	            </tr>
            </table><?php 
    	}exit;
    }
    
    function json_business_type($id)
    {
    	$bus_id = empty($_REQUEST['bus_id']) ? "-1" : $_REQUEST['bus_id'];
    	
    	
    	$count=$this->business->subscribe_count($bus_id);
    	$email_count=$this->business->email_count($bus_id);
    	$hot="";
    	
    	if(!empty($email_count))
    	{
    		$email_date = strtotime($email_count->date_time);
    		$pre_tday = strtotime('-2 day');
    		$pre_month = strtotime('-1 month');
    		$current_tday = strtotime('now');
    	
	    	if($email_date>$pre_tday && $current_tday>$email_date && $email_count->emai_count>=4)
	    	{
	    		$hot='<div class="three-tex-container"><a href="javascript:void()"> (Hot) </a></div>';
	    	}elseif($email_date>$pre_month && $current_tday>$email_date && $email_count->emai_count>=4)
	    	{
	    		$hot='<div class="three-tex-container"><a href="javascript:void()"> (Super) </a></div>';
	    	}
    	}
    	
    	
    	$sql_address="select * from template where id = $id";
    	$query_address=$this->db->query($sql_address);
    	
    	$row = $query_address->row();
    	$edit_template='';
    	$edit_template.='<input type="hidden" name="hidden_temp_id" id="hidden_temp_id" value="'.$id.'" />';
    	$edit_template.='<input type="hidden" name="hidden_bus_id" id="hidden_bus_id" value="'.$bus_id.'" />';
    	
    	$edit_template.='<div class="sepret-one">
    	<div class="two-tex-container"><a href="#" onclick="get_subscriber('.$bus_id.',"1");return false;" class="act">Short Notice Email('.$count.')</a></div>
    	<div class="two-tex-container"><a href="#" onclick="get_template('.$bus_id.');return false;">Template</a></div>
    	<div class="two-tex-container"><a href="#" onclick="get_history('.$bus_id.');return false;">History</a></div>
    	<div class="two-tex-container"><a href="#" onclick="set_category('.$bus_id.');return false;">Category</a></div>'.$hot.'</div><br/>';
    	
    	$edit_template.='<fieldset>
	    	<legend>Short codes</legend>
	    	<table width="100%">
	    		<tr><td>{link}, {first_name}, {last_name}, {phone}, {Address}, {City}, {Zip}, {business_name}</td></tr>
	    	</table>
    	</fieldset>
    	
    	<fieldset>
	    	<legend>Email</legend>
	    	<table width="100%">
		    	<tr>
		    		<td>Subject</td>
			    	<td>
			    		<input  type="text" id="template_subject" name="template_subject" value="'.$row->subject.'"/><br/>
			    	</td>
		    	</tr>
		    	<tr>
			    	<td>Message</td>
			    	<td><script type="text/javascript">new nicEditor({ fullPanel: true }).panelInstance("addtemplate_content");</script>
			    		<textarea rows="10" cols="45" style="width: 400px; height: 150px" id="addtemplate_content" name="addtemplate_content">'.$row->content.'</textarea>
			    	</td>
		    	</tr>
	    	</table>
    	</fieldset>';
    	
    	$row->edit_template = $edit_template;
    	echo(json_encode($query_address->row()));
    	exit;
    }
    
    function get_template($bus_id)
    {
    	$template_list = $this->template->get_all_template();
    	
    	$count=$this->business->subscribe_count($bus_id);
    	$email_count=$this->business->email_count($bus_id);
    	$hot="";
    	
    	if(!empty($email_count))
    	{
    		$email_date = strtotime($email_count->date_time);
    		$pre_tday = strtotime('-2 day');
    		$pre_month = strtotime('-1 month');
    		$current_tday = strtotime('now');
    	
    	if($email_date>$pre_tday && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Hot) </a></div>';
    			}elseif($email_date>$pre_month && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Super) </a></div>';
    			}
    	}?>
    	<div class="sepret-one">
		    				<div class="two-tex-container"><a href="#" onclick="get_subscriber('<?php echo $bus_id;?>','1');return false;">Short Notice Email(<?php echo $count;?>)</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_template('<?php echo $bus_id;?>');return false;" class="act">Template</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_history('<?php echo $bus_id;?>');return false;">History</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="set_category('<?php echo $bus_id;?>');return false;">Category</a></div>
		    				<?php echo $hot;?>
		    				<div class="four-tex-container"><button class="newButton" onclick="newtemplate();return false;">New Template</button></div>
	    				</div><br/>
    		<table align="center" id="" class="admin-table" width="950px" cellpadding="0" cellspacing="0">
    		<input type="hidden" name="hidden_bus_id" id="hidden_bus_id" value="<?php echo $bus_id;?>" /><?php
    		 
    	if(!empty($template_list)){
    		?>
    		
    		
		        <thead>
		            <tr>
		                <th width="80px">
		                    Id
		                </th>
		                <th width="200px">
		                    Subject
		                </th>
		                <th width="250px">
		                    Content
		                </th>
		                <th width="250px">
		                    Admin
		                </th>
		            </tr>
		        </thead>
		        <tbody>
		           <? foreach ($template_list as $business_types) { ?>
		            <tr>
		                <td><?=$business_types['id']?></td>
		                <td><?=$business_types['subject']?></td>
		                <td><?=$business_types['content']?></td>
		                <td><button class=" editButton" onclick="Edittemplate(<?=$business_types['id']?>);return false;">Edit</button><button class="deleteButton" onclick="Deletetemplate(<?=$business_types['id']?>, '<?=str_replace("'","\'",$business_types['subject'])?>','<?php echo $bus_id;?>');return false;">Delete</button><button class="newButton" onclick="newtemplate();return false;">New Template</button></td>
		
		            </tr>
		            <?}?>
		        </tbody>
		    </table>
    		
		    
	    <?php }exit;
    }
    function save_template()
    {
    	$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
    	$status = $_REQUEST['status'];
    	$bus_id = $_REQUEST['bus_id'];
    	 
    	$template_subject = $_REQUEST['template_subject'];
    	$template_content = $_REQUEST['addtemplate_content'];
    	
    	$data = array(
    			"subject" => $template_subject,
    			"content" => $template_content
    	);
    	
    	if(!empty($id) && $id > 0)
    	{
    		//update
    		$this->db->where('id', $id);
    		$this->db->update('template', $data);
    	}
    	else
    	{
    		//insert
    		$this->db->insert('template', $data);
    	}
    	echo $bus_id;exit;
    }
    
    function save_template_edit()
    {
    	$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
    	$status = $_REQUEST['status'];
    	$bus_id = $_REQUEST['bus_id'];
    
    	$template_subject = $_REQUEST['template_subject'];
    	$template_content = $_REQUEST['addtemplate_content'];
    
    	$data = array(
    			"subject" => $template_subject,
    			"content" => $template_content
    	);
    
    	if(!empty($id) && $id > 0)
    	{
    		//update
    		$this->db->where('id', $id);
    		$this->db->update('template', $data);
    	}
    	else
    	{
    		//insert
    		$this->db->insert('template', $data);
    	}
    	
    	$sql_address="select * from template where id = $id";
    	$query_address=$this->db->query($sql_address);
    	
    	$row = $query_address->row();
    	
    	$row->id = $id;
    	$row->bus_id = $bus_id;
    	
    	echo(json_encode($query_address->row()));
    	exit;
    
    }
    
    function newtemplate($bus_id)
    {
    	$business_subscriber = $this->business_dashboard1->get_all_subscriber($bus_id);
    	$template_list = $this->template->get_all_template();
    	
    	$count=$this->business->subscribe_count($bus_id);
    	$email_count=$this->business->email_count($bus_id);
    	$hot="";
    	
    	if(!empty($email_count))
    	{
    		$email_date = strtotime($email_count->date_time);
    		$pre_tday = strtotime('-2 day');
    		$pre_month = strtotime('-1 month');
    		$current_tday = strtotime('now');
    	
    	if($email_date>$pre_tday && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Hot) </a></div>';
    			}elseif($email_date>$pre_month && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Super) </a></div>';
    			}
    	}
    	?>
    	<input type="hidden" name="hidden_temp_id" id="hidden_temp_id" value="-1" />
    	<input type="hidden" name="hidden_bus_id" id="hidden_bus_id" value="<?php echo $bus_id;?>" />
    	<div class="sepret-one">
		    				<div class="two-tex-container"><a href="#" onclick="get_subscriber('<?php echo $bus_id;?>','1');return false;">Short Notice Email(<?php echo $count;?>)</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_template('<?php echo $bus_id;?>');return false;" class="act">Template</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_history('<?php echo $bus_id;?>');return false;">History</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="set_category('<?php echo $bus_id;?>');return false;">Category</a></div>
		    				<?php echo $hot;?>
	    				</div><br/>
    	<fieldset>
	    	<legend>Short codes</legend>
	    	<table width="100%">
	    		<tr><td>{link}, {first_name}, {last_name}, {phone}, {Address}, {City}, {Zip}, {business_name}</td></tr>
	    	</table>
    	</fieldset>
    	
    	<fieldset>
	    	<legend>Email</legend>
	    	<table width="100%">
		    	<tr>
			    	<td>Subject</td>
			    	<td>
			    		<input  type="text" id="template_subject" name="template_subject" value=""/><br/>
			    	</td>
			    </tr>
			    <tr>
			    	<td>Message</td>
			    	<td><script type="text/javascript">new nicEditor({ fullPanel: true }).panelInstance('addtemplate_content');</script>
			    		<textarea rows="10" cols="45" style="width: 400px; height: 150px" id="addtemplate_content" name="addtemplate_content"></textarea>
			    	</td>
		    	</tr>
	    	</table>
    	</fieldset>
    	<?php
    }
    function delete_template()
    {
    	$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
    	$bus_id = empty($_REQUEST['bus_id']) ? "-1" : $_REQUEST['bus_id'];
    	$title = " Failed";
    	$message = "There was no id set";
    	if(!empty($id) && $id > 0)
    	{
    		$this->db->delete('template', array('id' => $id));
    		$title = " Succeeded";
    		$message = "Delete is complete.";
    	}
    	return $bus_id;
    }
    function set_subscriber($bus_id,$id=-1)
    {
    	$business_subscriber = $this->business_dashboard1->get_all_subscriber($bus_id);
    	$template_list = $this->template->get_all_template();
    	
    	$count=$this->business->subscribe_count($bus_id);
    	$email_count=$this->business->email_count($bus_id);
    	$hot="";
    	
    	if(!empty($email_count))
    	{
    		$email_date = strtotime($email_count->date_time);
    		$pre_tday = strtotime('-2 day');
    		$pre_month = strtotime('-1 month');
    		$current_tday = strtotime('now');
    	
    	if($email_date>$pre_tday && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Hot) </a></div>';
    			}elseif($email_date>$pre_month && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Super) </a></div>';
    			}
    	}
    	?>
    	<input type="hidden" name="hidden_bus_id" id="hidden_bus_id" value="<?php echo $bus_id;?>" />
    	<div class="sepret-one">
		    				<div class="two-tex-container"><a href="#" onclick="get_subscriber('<?php echo $bus_id;?>','1');return false;" class="act">Short Notice Email(<?php echo $count;?>)</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_template('<?php echo $bus_id;?>');return false;">Template</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_history('<?php echo $bus_id;?>');return false;">History</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="set_category('<?php echo $bus_id;?>');return false;">Category</a></div>
		    				<?php echo $hot;?>
	    				</div><br/>
    	<fieldset>
	        <legend>Short codes</legend>
	        <table width="100%">
	        	<tr><td>{link}, {first_name}, {last_name}, {phone}, {Address}, {City}, {Zip}, {business_name}</td></tr>
	         </table>
	    </fieldset>
    	<fieldset>
	        <legend>Subscribers</legend>
	        <table width="100%">
	        	<tr>
	        		<td>Select Subscribers</td>
			        <td>
		        		<select id="subscriber" name="subscriber[]" multiple="multiple">
			             <?foreach ($business_subscriber as $user) {?>
			                        <option value="<?= $user['email'] ?>" selected="selected"><?php echo $user['email'];?></option>
			             <?}?>
			        	</select><br />
			        	<input type="checkbox" name="check_all" id="check_all" value="1" /> Select All
			        </td>
			    </tr>
	         </table>
	    </fieldset>
	    
	    <fieldset>
	        <legend>Template</legend>
	        <table width="100%">
	        	<tr>
	        		<td>Select Template</td>
			        <td>
			        	<?php 
			        		$template_count=count($template_list);
			        		$i=0;
			        	?>
		        		<select id="template" name="template" onchange="get_template_content(this.value);;return false;" >
			             <?foreach ($template_list as $user) {?>
			                        <option <?php if($id==$user['id']){echo 'selected="selected"';}elseif($template_count==$i){echo 'selected="selected"';}?> value="<?= $user['id'] ?>"><?php echo $user['subject'];?></option>
			             <?$i++;}?>
			        	</select>
			        </td>
			    </tr>
	         </table>
	    </fieldset>
	    <fieldset>
	        <legend>Email</legend>
	        <table width="100%">
	        <?foreach ($template_list as $user) {$i=0;
		        if($id='' && $id!=$user['id'])
		        {
		        	continue;
		        }
	        ?>
	            <tr>
	               <td>Subject</td>
	               <td>
		                <input  type="text" id="template_subject" name="template_subject" value="<?php echo $user['subject'];?>"/><br/>
	               </td>
	            </tr>
	            <tr>
	               <td>Message</td>
	               <td><script type="text/javascript">new nicEditor({ fullPanel: true }).panelInstance('template_content');</script>
		                <textarea rows="10" cols="45" style="width: 400px; height: 150px" id="template_content" name="template_content"><?php echo $user['content'];?></textarea>
	               </td>
	            </tr>
	         <?php 
	         if($id && $id==$user['id'])
	         {
	         	break;
	         }
	         if($i==0){break;}}?>
	         </table>
	    </fieldset>
	   <?php 
    }
    function send_email()
    {
    	$saveid = empty($_REQUEST['resend']) ? "-1" : $_REQUEST['resend'];
    	$id = empty($_REQUEST['bus_id']) ? "-1" : $_REQUEST['bus_id'];
    	$business_subscriber = $_REQUEST['subscriber'];
    	
    	$business_template = $_REQUEST['template'];
    	$template_subject = $_REQUEST['template_subject'];
    	$template_content = $_REQUEST['template_content'];
    	$check_all = empty($_REQUEST['check_all']) ? "-1" : $_REQUEST['check_all'];
    	
    	if($check_all)
    	{
    		$business_subscriber=array();
    		$query = $this->db->query("select t1.email from users as t1 left join business_approved as t2 on t2.user_id=t1.id left join user_paypal as t3 on t3.user_id=t1.id where t2.business_id=".$id." and t2.approved=1 and t3.success='completed'");
    		$business_subscriber_all=$query->result_array();
    		foreach($business_subscriber_all as $business_subscriber_all)
    		{
    			$business_subscriber[]=$business_subscriber_all['email'];
    		}
    		
    	}
    	
    	$business = $this->db->query("select t1.*,t2.email as from_email from business as t1 left join users as t2 on t2.id=t1.business_owner_id where t1.id=$id");
    	$business=$business->row();
    	$this->load->library('email');
    	
    	$template=$template_content;
    	
    	$shortcode=array('{link}','{first_name}','{last_name}','{phone}','{Address}','{City}','{Zip}','{business_name}');
    	
    	$to=array();
    	if(is_array($business_subscriber) && !empty($business_subscriber))
    	{
    		foreach($business_subscriber as $user_id)
    		{
    			$message='';
    			$query = $this->db->query("select * from users where email='".$user_id."'");
    			$user=$query->row();
    			if(!empty($user))
    			{
    				$business_query = $this->db->query("select * from business_to_zone where business_id='".$id."'");
    				$business_zone=$business_query->row();
    				
    				$this->email->clear();
    				$this->email->from($business->from_email, $business->from_email);
    				$replace[]=base_url("welcome/index/" . $business_zone->zone_id);
    				$replace[]=$user->first_name;
    				$replace[]=$user->last_name;
    				$replace[]=$user->phone;
    				$replace[]=$user->Address;
    				$replace[]=$user->City;
    				$replace[]=$user->Zip;
    				$replace[]=$business->name;
    	
    				$message=str_replace($shortcode, $replace, $template);
    				$this->email->subject($template_subject);
    				$this->email->message($message);
    	
    				$this->email->to($user->email);
    				$this->email->send();
    				$to[]=$user->email;
    			}
    		}
    	
    		$comma_separated = implode("####", $to);
    	
    		$data = array(
    				"business_id" => $id,
    				"subject" => $template_subject,
    				"date_time" => date('Y-m-d H:i:s'),
    				"message" => $template,
    				"to" => $comma_separated
    		);
    		if(!empty($saveid) && $saveid > 0)
    		{
    			//update
    			$this->db->where('id', $saveid);
    			$this->db->update('save_email', $data);
    		}
    		else
    		{
    			//insert
    			$this->db->insert('save_email', $data);
    		}
    	
    		$sql = "select * from hot_email_count where business_id = " . $id;
    		$query = $this->db->query($sql);
    	
    		$row = $query->row();
    		//print_r($row);
    		$count='';
    		
    	
    		$emai_data=array('date_time'=>date('Y-m-d H:i:s'),'emai_count'=>1,'business_id'=>$id);
    	
    		if(!empty($row))
    		{
    			$count=$row->emai_count;
    			$count=$count+1;
    			$emai_data1=array('emai_count'=>$count,'business_id'=>$id);
    			$this->db->where('business_id', $id);
    			$this->db->update('hot_email_count', $emai_data1);
    	
    		}else{
    			$this->db->insert('hot_email_count', $emai_data);
    		}
    	}
    	
    	
    	//echo $this->email->print_debugger();
    }
    
    function get_template_content($id)
    {
    	$sql_address="select * from template where id = $id";
    	$query_address=$this->db->query($sql_address);
    	$query_address=$query_address->row();
    	echo $query_address->subject.'####'.$query_address->content;
    	
    }
    
    
    function get_history($bus_id)
    {
    	$query = $this->db->query("select * from save_email where business_id=".$bus_id);
    	$row = $query->result_array();
    	
    	$count=$this->business->subscribe_count($bus_id);
    	$email_count=$this->business->email_count($bus_id);
    	$hot="";
    	
    	if(!empty($email_count))
    	{
    		$email_date = strtotime($email_count->date_time);
    		$pre_tday = strtotime('-2 day');
    		$pre_month = strtotime('-1 month');
    		$current_tday = strtotime('now');
    	
    	if($email_date>$pre_tday && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Hot) </a></div>';
    			}elseif($email_date>$pre_month && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Super) </a></div>';
    			}
    	}?>
    	<input type="hidden" name="hidden_bus_id" id="hidden_bus_id" value="<?php echo $bus_id;?>" />
    	<?php 
    
    	if(!empty($row)){
    		?>
		    
		    <div class="sepret-one">
		    				<div class="two-tex-container"><a href="#" onclick="get_subscriber('<?php echo $bus_id;?>','1');return false;">Short Notice Email(<?php echo $count;?>)</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_template('<?php echo $bus_id;?>');return false;">Template</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_history('<?php echo $bus_id;?>');return false;" class="act">History</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="set_category('<?php echo $bus_id;?>');return false;">Category</a></div>
		    				<?php echo $hot;?>
	    				</div><br/>
		    <table align="center" id="" class="admin-table" width="950px" cellpadding="0" cellspacing="0">
			    <thead>
				    <tr>
					    <th width="80px">
					    	Id
					    </th>
					    <th width="200px">
					    	Subject
					    </th>
					    <th width="200px">
					    	To
					    </th>
					    <th width="250px">
					    	Admin
					    </th>
				    </tr>
			    </thead>
			    <tbody>
			    <? foreach ($row as $business_types) {

			    	$pieces = explode("####", $business_types['to']);
			    	
			    	$comma_separated = implode(", ", $pieces);
			    	?>
			    <tr>
				    <td><?=$business_types['id']?></td>
				    <td><?=$business_types['subject']?></td>
				    <td><?=$comma_separated?></td>
				    <td>
				    <button class="emailButton" onclick="resend_email(<?=$business_types['id']?>);return false;">Edit</button>
				    <button class="deleteButton" onclick="Deletehostory(<?=$business_types['id']?>, '<?=str_replace("'","\'",$business_types['subject'])?>','<?php echo $bus_id;?>');return false;">Delete</button></td>
			    
			    </tr>
			    <?}?>
			    </tbody>
		    </table>
    <?php }else{?>
		    	<div class="sepret-one">
			    	<div class="two-tex-container"><a href="#" onclick="get_subscriber('<?php echo $bus_id;?>','1');return false;">Short Notice Email(<?php echo $count;?>)</a></div>
			    	<div class="two-tex-container"><a href="#" onclick="get_template('<?php echo $bus_id;?>');return false;">Template</a></div>
			    	<div class="two-tex-container"><a href="#" onclick="get_history('<?php echo $bus_id;?>');return false;" class="act">History</a></div>
			    	<div class="two-tex-container"><a href="#" onclick="set_category('<?php echo $bus_id;?>');return false;">Category</a></div>
			    	<?php echo $hot;?>
		    	</div><br/>
		    	<table align="center" id="" class="admin-table" width="950px" cellpadding="0" cellspacing="0">
			    	<thead>
				    	<tr>
					    	<th width="80px">
						    	Id
					    	</th>
					    	<th width="200px">
						    	Subject
					    	</th>
					    	<th width="200px">
						    	To
					    	</th>
					    	<th width="250px">
						    	Admin
					    	</th>
				    	</tr>
			    	</thead>
			    	<tbody>
				    	<tr>
				    		<td colspan="4">No template found</td>
				    	</tr>
			    	</tbody>
		    	</table><?php 
	    }exit;
    }
    
    function deletehostory()
    {
    	
    	$id = empty($_REQUEST['id']) ? "-1" : $_REQUEST['id'];
    	$bus_id = empty($_REQUEST['bus_id']) ? "-1" : $_REQUEST['bus_id'];
    	
    	$title = " Failed";
    	$message = "There was no id set";
    	if(!empty($id) && $id > 0)
    	{
    		$this->db->delete('save_email', array('id' => $id));
    		$title = " Succeeded";
    		$message = "Delete is complete.";
    	}
    	echo $bus_id;
    }
    
	function set_subscriber_resend($bus_id,$id=-1)
    {
    	$business_subscriber = $this->business_dashboard1->get_all_subscriber($bus_id);
    	$template_list = $this->template->get_all_history($bus_id);
    	
    	$history = $this->template->get_history($bus_id,$id);
    	
    	$count=$this->business->subscribe_count($bus_id);
    	$email_count=$this->business->email_count($bus_id);
    	$hot="";
    	$pieces=array();
    	if(!empty($email_count))
    	{
    		$email_date = strtotime($email_count->date_time);
    		$pre_tday = strtotime('-2 day');
    		$pre_month = strtotime('-1 month');
    		$current_tday = strtotime('now');
    	
    	if($email_date>$pre_tday && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Hot) </a></div>';
    			}elseif($email_date>$pre_month && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Super) </a></div>';
    			}
    	}
    	
    	$pieces = explode("####", $history->to);
    	?>
    	<input type="hidden" name="resend" id="resend" value="<?php echo $id;?>" />
    	<input type="hidden" name="hidden_bus_id" id="hidden_bus_id" value="<?php echo $bus_id;?>" />
    	<div class="sepret-one">
		    				<div class="two-tex-container"><a href="#" onclick="get_subscriber('<?php echo $bus_id;?>','1');return false;">Short Notice Email(<?php echo $count;?>)</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_template('<?php echo $bus_id;?>');return false;">Template</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_history('<?php echo $bus_id;?>');return false;" class="act">History</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="set_category('<?php echo $bus_id;?>');return false;">Category</a></div>
		    				<?php echo $hot;?>
	    				</div><br/>
    	<fieldset>
	        <legend>Short codes</legend>
	        <table width="100%">
	        	<tr><td>{link}, {first_name}, {last_name}, {phone}, {Address}, {City}, {Zip}, {business_name}</td></tr>
	         </table>
	    </fieldset>
    	<fieldset>
	        <legend>Subscribers</legend>
	        <table width="100%">
	        	<tr>
	        		<td>Select Subscribers</td>
			        <td>
		        		<select id="subscriber" name="subscriber[]" multiple="multiple">
			             <?foreach ($business_subscriber as $user) {
			             	$select='';
			             	if(in_array($user['email'], $pieces))
			             	{
			             		$select='selected="selected"';
			             	}
			             	?>
			                        <option <?php echo $select;?> value="<?= $user['email'] ?>"><?php echo $user['email'];?></option>
			             <?}?>
			        	</select><br />
			        	<input type="checkbox" name="check_all" id="check_all" value="1" /> Select All
			        	
			        </td>
			    </tr>
	         </table>
	    </fieldset>
	    
	    <fieldset>
	        <legend>Template</legend>
	        <table width="100%">
	        	<tr>
	        		<td>Select Template</td>
			        <td>
			        	<?php 
			        		$template_count=count($template_list);
			        		$i=0;
			        	?>
		        		<select id="template" name="template" onchange="get_history_content(this.value);;return false;" >
			             <?foreach ($template_list as $user) {?>
			                        <option <?php if($id==$user['id']){echo 'selected="selected"';}elseif($template_count==$i){echo 'selected="selected"';}?> value="<?= $user['id'] ?>"><?php echo $user['subject'];?></option>
			             <?$i++;}?>
			        	</select>
			        </td>
			    </tr>
	         </table>
	    </fieldset>
	    <fieldset>
	        <legend>Email</legend>
	        <table width="100%">
	        <?foreach ($template_list as $user) {$i=0;
		        if($id='' && $id!=$user['id'])
		        {
		        	continue;
		        }
	        ?>
	            <tr>
	               <td>Subject</td>
	               <td>
		                <input  type="text" id="template_subject" name="template_subject" value="<?php echo $user['subject'];?>"/><br/>
	               </td>
	            </tr>
	            <tr>
	               <td>Message</td>
	               <td><script type="text/javascript">new nicEditor({ fullPanel: true }).panelInstance('template_content');</script>
		                <textarea rows="10" cols="45" style="width: 400px; height: 150px" id="template_content" name="template_content"><?php echo $user['message'];?></textarea>
	               </td>
	            </tr>
	         <?php 
	         if($id && $id==$user['id'])
	         {
	         	break;
	         }
	         if($i==0){break;}}?>
	         </table>
	    </fieldset>
	   <?php 
    }
    
    function get_history_content($id)
    {
    	$sql_address="select * from save_email where id = $id";
    	$query_address=$this->db->query($sql_address);
    	$query_address=$query_address->row();
    	echo $query_address->subject.'####'.$query_address->message;
    
    }

    
    function set_category($bus_id)
    {
    	$business_type = $this->business_type->get_all_business_types_name();
    	$count=$this->business->subscribe_count($bus_id);
    	$email_count=$this->business->email_count($bus_id);
    	$hot="";
    	
    	if(!empty($email_count))
    	{
    		$email_date = strtotime($email_count->date_time);
    		$pre_tday = strtotime('-2 day');
    		$pre_month = strtotime('-1 month');
    		$current_tday = strtotime('now');
    	
    	if($email_date>$pre_tday && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Hot) </a></div>';
    			}elseif($email_date>$pre_month && $current_tday>$email_date && $email_count->emai_count>=4)
    			{
    				$hot='<div class="three-tex-container"><a href="javascript:void()"> (Super) </a></div>';
    			}
    	}
    	
    	
    	
    	$sql = "select * from business_business_type where business_id = $bus_id";
    	$query_type = $this->db->query($sql);
    	$row_type = $query_type->result();
    	
    	$pieces=array();
    	foreach($row_type as $row_type)
    	{
    		$pieces[]=$row_type->business_type_id;
    	}
    	
    	?>
    	<input type="hidden" name="hidden_bus_id" id="hidden_bus_id" value="<?php echo $bus_id;?>" />
    	<div class="sepret-one">
		    				<div class="two-tex-container"><a href="#" onclick="get_subscriber('<?php echo $bus_id;?>','1');return false;">Short Notice Email(<?php echo $count;?>)</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_template('<?php echo $bus_id;?>');return false;">Template</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="get_history('<?php echo $bus_id;?>');return false;" class="act">History</a></div>
		    				<div class="two-tex-container"><a href="#" onclick="set_category('<?php echo $bus_id;?>');return false;">Category</a></div>
		    				<?php echo $hot;?>
	    				</div><br/>
    	
	        <table width="100%">
	        	<tr>
	        		<td>Select Category</td>
			        <td>
		        		<div id="business_category_div">
			        		<select id="business_category_select" name="business_category[]" multiple="multiple">
				             <?foreach ($business_type as $user) {
				             	$select='';
				             	if(in_array($user['id'], $pieces))
				             	{
				             		$select='selected="selected"';
				             	}
				             	?>
				                        <option <?php echo $select;?> value="<?= $user['id'] ?>"><?=$user['name']?></option>
				                    <?}?>
				
				        	</select>
			        	</div>
			        </td>
			    </tr>
	         </table>
	    <?php 
    }

    function save_category()
    {
    	$business_category = $_REQUEST['business_category'];
    	$id = $_REQUEST['bus_id'];
    	
    	$this->db->delete('business_business_type', array('business_id' => $id));
    	
    	foreach($business_category as $business_category)
    	{
    		$business_type = array(
    				'business_type_id' => $business_category,
    				'business_id' => $id,
    		);
    		$this->db->insert('business_business_type', $business_type);
    	}
    	exit;
    }
    
    
}