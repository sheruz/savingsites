<?php
class Display_stats extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model("Dialog_result", "dr");
        $this->load->database();
        $this->load->helper("time_helper");
        $this->load->config('security', TRUE);
   
        $this->load->model("admin/display_stats_model", "display_stats");
        
        $this->tierI = $this->config->item('Tier_I');
        $this->tierII = $this->config->item('Tier_II');
        $this->tierIII = $this->config->item('Tier_III');
    }

    function index($zone = false)
    {
       if (!$this->ion_auth->logged_in())
        {
            //redirect them to the login page
            //redirect('auth/login', 'refresh');
			redirect(base_url(), 'refresh');
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
        $scripts = array ("assets/scripts/jquery.blockUI.js","assets/scripts/jquery.dialogresult.js","assets/scripts/admin/display_stats.inc.js");
        $data['zone_list'] = $this->display_stats->get_all_zones();
        $data["scripts"] = $scripts;
        $data["firstName"] = $this->ion_auth->user()->row()->first_name;
        $data["page_name"] = "display_stats";
        $this->load->view("admin/header", $data);
        $this->load->view("admin/admin_buttons", $data);
        $this->load->view("admin/display_stats.table.php",$data);
        $this->load->view("admin/footer");
     //   redirect("admin");
    }
    
    function get_display_state_date($div,$zone=false)
    {
    	$from_date = empty($_REQUEST['from_date']) ? "-1" : $_REQUEST['from_date'];
    	$to_date = empty($_REQUEST['to_date']) ? "-1" : $_REQUEST['to_date'];
    	
    	if($div=='time_category_loaded'){
    	$category_load = $this->display_stats->get_category_load($zone,$from_date,$to_date);
    	?>
    	<div class="sepret-main-area">
	    <?php 
			$i=1;
			foreach($category_load as $category_load)
			{?>
                  <div class="sepret-one-area">
	                  <div class="sepret-two-area"><?=$category_load['name']?></div>
	                  <div class="sepret-three-area"><?=$category_load['total_hits']?></div>
	              </div>
            <?php 
			if($i%3==0){ echo '</div><div class="sepret-main-area">';}
			$i++;
			}?>
	    </div>
    	<?php }elseif($div=='time_ads_loaded')
    	{
    		$ads_load = $this->display_stats->get_ads_load($zone,$from_date,$to_date);
    	?>
    		<div class="sepret-main-area">
            <?php
			$i=1;
			foreach($ads_load as $category_load)
			{?>
	            <div class="sepret-one-area">
		            <div class="sepret-two-area"><?php if(empty($category_load['name'])){echo $category_load['id'];}else{echo $category_load['name'];}?></div>
		            <div class="sepret-three-area"><?=$category_load['total_hits']?></div>
	            </div>
	            <?php 
				if($i%3==0){ echo '</div><div class="sepret-main-area">';}
				$i++;
			}?>
            </div><?php 
    		
    	}elseif($div=='time_ads_sent')
    	{
    		$ads_sent = $this->display_stats->get_ads_sent($zone,$from_date,$to_date);
    	?>
    		<div class="sepret-main-area">
                                <?php
							$i=1;
							foreach($ads_sent as $category_load)
							{?>
                                	<div class="sepret-one-area">
                                    	<div class="sepret-two-area"><?php if(empty($category_load['name'])){echo $category_load['id'];}else{echo $category_load['name'];}?></div>
                                        <div class="sepret-three-area"><?=$category_load['total_hits']?></div>
                                    </div>
                                    <?php 
								if($i%3==0){ echo '</div><div class="sepret-main-area">';}
								$i++;
							}?>
                                 </div><?php 
    		
    	}exit;
    }
    
    function get_display_state($zone=false)
    {
    	$from_date='';
    	$to_date='';
    	
    	$noofhits = $this->display_stats->get_no_of_hits($zone);
    	$noofcategory = $this->display_stats->get_no_of_category($zone);
    	$noofadssent = $this->display_stats->get_no_of_adssent($zone);
    	$noofadsload = $this->display_stats->get_no_of_adsload($zone);
    	
    	$category_load = $this->display_stats->get_category_load($zone,$from_date,$to_date);
    	$ads_load = $this->display_stats->get_ads_load($zone,$from_date,$to_date);
    	$ads_sent = $this->display_stats->get_ads_sent($zone,$from_date,$to_date);
    	?>
    	
    	<table align="center" id="" class="admin-table" width="950px" cellpadding="0" cellspacing="0">
	    	<tr>
		    	<th  width="300px">Raw Number Of Hits</th>
	    	</tr>
	        <tr class="odd">
	    		<td align="center" width="300px"><?=$noofhits?></td>
			</tr>

			<?php //print_r($category_load);
			if(count($category_load)>0)
			{
				?>
                <tr>
                	<td align="left" valign="top">
               			<table align="center" id="" class="admin-table" width="950px" cellpadding="0" cellspacing="0">
               				<tr>
                				<th>Times A Category Is Loaded</th>
                			</tr>
                			<tr>
                            	<td>
                            		From date : <input type="text" name="from_date" id="from_date" value="" />
                            		To Date : <input type="text" name="to_date" id="to_date" value="" />
                            		<div class="for-g-link"><a href="#" onClick="get_display_state_date('time_category_loaded','<?php echo $zone;?>');return false;">Go</a></div>
                            	</td>
                            </tr>
							<tr>
                            	<td>
                            		<div id="time_category_loaded">
	                                	<div class="sepret-main-area">
			                                <?php 
											$i=1;
											foreach($category_load as $category_load)
											{?>
			                                	<div class="sepret-one-area">
			                                    	<div class="sepret-two-area"><?=$category_load['name']?></div>
			                                        <div class="sepret-three-area"><?=$category_load['total_hits']?></div>
			                                    </div>
		                                    <?php 
											if($i%3==0){ echo '</div><div class="sepret-main-area">';}
											$i++;
											}?>
	                                    </div>
                                    </div>
                                </td>
                             </tr>
						</table>
					</td>
				</tr><?php
			}else{
				?>
                <tr>
                	<td align="left" valign="top">
               			<table align="center" id="" class="admin-table" width="950px" cellpadding="0" cellspacing="0">
               				<tr>
                				<th>Times A Category Is Loaded</th>
                			</tr>
                			<tr>
                            	<td>
                            		From date : <input type="text" name="from_date" id="from_date" value="" />
                            		To Date : <input type="text" name="to_date" id="to_date" value="" />
                            		<div class="for-g-link"><a href="#" onClick="get_display_state_date('time_category_loaded','<?php echo $zone;?>');return false;">Go</a></div>
                            	</td>
                            </tr>
							<tr>
                            	<td>
                            		<div id="time_category_loaded">
	                                	<div class="sepret-main-area">
			                                		No records Founds
	                                    </div>
                                    </div>
                                </td>
                             </tr>
						</table>
					</td>
				</tr><?php
			}
			?>
			
			<?php //print_r($category_load);
			if(count($ads_load)>0)
			{
				?>
                <tr>
                	<td align="left" valign="top">
               			<table align="center" id="" class="admin-table" width="950px" cellpadding="0" cellspacing="0">
               				<tr>
                				<th>Times A Ads Is Loaded</th>
                			</tr>
                			<tr>
                            	<td>
                            		From date : <input type="text" name="from_date_Ads_times" id="from_date_Ads_times" value="" />
                            		To Date : <input type="text" name="to_date_Ads_times" id="to_date_Ads_times" value="" />
                            		<div class="for-g-link"><a href="#" onClick="get_display_state_date('time_ads_loaded','<?php echo $zone;?>');return false;">Go</a></div>
                            	</td>
                            </tr>
							<tr>
                            	<td>
                            		<div id="time_ads_loaded">
	                                	<div class="sepret-main-area">
			                                <?php
											$i=1;
											foreach($ads_load as $category_load)
											{?>
			                                	<div class="sepret-one-area">
			                                    	<div class="sepret-two-area"><?php if(empty($category_load['name'])){echo $category_load['id'];}else{echo $category_load['name'];}?></div>
			                                        <div class="sepret-three-area"><?=$category_load['total_hits']?></div>
			                                    </div>
			                                    <?php 
												if($i%3==0){ echo '</div><div class="sepret-main-area">';}
												$i++;
											}?>
	                                    </div>
                                    </div>
                                </td>
                             </tr>
						</table>
					</td>
				</tr><?php
			}else{
				?>
                <tr>
                	<td align="left" valign="top">
               			<table align="center" id="" class="admin-table" width="950px" cellpadding="0" cellspacing="0">
               				<tr>
                				<th>Times A Ads Is Loaded</th>
                			</tr>
                				<tr>
                            	<td>
                            		<div id="time_ads_loaded">
	                                	<div class="sepret-main-area">
			                                		No records Founds
	                                    </div>
                                    </div>
                                </td>
                             </tr>
						</table>
					</td>
				</tr><?php
			}
			?>
			
			<?php //print_r($category_load);
			if(count($ads_sent)>0)
			{
				?>
                <tr>
                	<td align="left" valign="top">
               			<table align="center" id="" class="admin-table" width="950px" cellpadding="0" cellspacing="0">
               				<tr>
                				<th>Times A Ads Is Sent</th>
                			</tr>
                			<tr>
                            	<td>
                            		From date : <input type="text" name="from_date_sent" id="from_date_sent" value="" />
                            		To Date : <input type="text" name="to_date_sent" id="to_date_sent" value="" />
                            		<div class="for-g-link"><a href="#" onClick="get_display_state_date('time_ads_sent','<?php echo $zone;?>');return false;">Go</a></div>
                            	</td>
                            </tr>
							<tr>
                            	<td>
	                            	<div id="time_ads_sent">
	                                	<div class="sepret-main-area">
			                                <?php
											$i=1;
											foreach($ads_sent as $category_load)
											{?>
			                                	<div class="sepret-one-area">
			                                    	<div class="sepret-two-area"><?php if(empty($category_load['name'])){echo $category_load['id'];}else{echo $category_load['name'];}?></div>
			                                        <div class="sepret-three-area"><?=$category_load['total_hits']?></div>
			                                    </div>
			                                    <?php 
												if($i%3==0){ echo '</div><div class="sepret-main-area">';}
												$i++;
											}?>
		                                 </div>
	                                </div>
                                </td>
                             </tr>
						</table>
					</td>
				</tr><?php
			}else{
				?>
                <tr>
                	<td align="left" valign="top">
               			<table align="center" id="" class="admin-table" width="950px" cellpadding="0" cellspacing="0">
               				<tr>
                				<th>Times A Ads Is Sent</th>
                			</tr>
							<tr>
                            	<td>
	                            	<div id="time_ads_sent">
	                                	<div class="sepret-main-area">
			                                    	No records Founds
		                                 </div>
	                                </div>
                                </td>
                             </tr>
						</table>
					</td>
				</tr><?php
			}
			?>
			
		</table><?php
    	
    	
    	exit;
    }
}



