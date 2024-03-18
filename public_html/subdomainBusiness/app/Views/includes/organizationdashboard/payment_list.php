<?php
//var_dump($details_payment_list);
 ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.js"></script>
<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
<div class="content_container payment_list_container">
<?php if($common['from_zoneid']!='0'){?>
<div class="spacer"></div>
  <div class="businessname-heading">
      <div class="main main-large main-100">
          <div class="businessname-heading-main">
  
            </div>
        </div>
    </div>
<?php } 
if($common['where_from']=='zone'){?>
  <div class="spacer"></div>
    <div class="businessname-heading" style="overflow:hidden;">
      <div class="main main-large main-100">
          <div class="businessname-heading-main">
            <div class="center" style="width:100%">
             <font style="">Search All Businesses (Real Active Ads, Businesses Uploaded, Biz Opp Providers, Inactive Ads)</font> 
            <input type="text" id="global_bus_search" name="global_bus_search" class="text-input" placeholder="Exact business name or phone no. or id" style="" value="<?php echo $this->session->userdata('business_search_value') ?>" />
            <button class="btn-sm"  id="global_bus_search_btn" type="button" style="">Search</button>
            <?php /*?><span style="margin:-10px 20px 0 0; display:none" class="close"><button class="btn-sm global_search_close" type="button" style="padding:7px; width:115px; margin-top:7px;  margin-top: 10px;margin-left: -36px;">Clear Search</button></span><?php */?>
            <button class="btn-sm global_search_close hide_search_result" type="button" style="display:none">Clear Search</button>
            </div>
      <div id="no_bus_found" style="margin-left:15px;" class="fleft w_300"></div>
            </div>
        </div>
        <div id="view_global_bus_search_div" style="width:1130px; margin:10px auto 0; background-color:#d2e08f; display:none; overflow:hidden; padding:10px;">
          <div id="view_global_bus_search" class="fleft" style="width:1080px;"></div>
            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="https://cdn.savingssites.com/close_pop.png" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>
      </div>
    </div>

<?php } ?>
      <div class="top-title">
        <h2>Payment Details</h2>
         <hr class="center-diamond">
      </div>
<div class="container_tab_content ui-widget-content">
<div id="table_contet">

	<table class="pretty" border="0" cellpadding="0" cellspacing="0">
  <thead id="showhead" class="headerclass">
    <tr>
      <th width="10%">Business Id</th>
      <th width="15%">Business Name</th>
      <th width="15%">Submission Id</th>
      <th width="15%">Payment Purpose</th>
      <th width="10%">Form Id</th>
      <th width="10%">Amount</th>
      <th width="15%">Payment Time</th>
    </tr>
  </thead>
  <tbody>
  <?php if(count($details_payment_list) > 0){
    
  	foreach ($details_payment_list as $value) {
  	?>
    <tr class="headerclass_sub">
     	<td><?= $value['payer_id']; ?></td>
     	<td><?= $value['business_name']; ?></td>
     	<td><?= $value['submission_id']; ?></td>
     	<td><?= $value['payment_purpose']; ?></td>
     	<td><?= $value['form_id']; ?></td>
     	<td><?= $value['amount']; ?></td>
     	<td><?= $value['payment_creation_time']; ?></td>
    </tr> 
    <?php
		}
     	} else{?>
     	<div id="tab1_content"><div style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;" class="container_tab_header">No Payment Data Found</div>
		</div>

    <?php } ?>
  </tbody>
</table>
</div>
</div>
</div>
<script type="text/javascript">
       $(document).ready(function(){
		$("#zone_data_accordian").click();
		$("#zone_data_accordian").next().slideDown();
		$('#jotform').click();
		$('#jotform').next().slideDown();
		$('#view_listing').addClass('active');
	});
</script>