<?php 
$zone_id = end($this->uri->segment_array());
?>
<div class="content_container">
<?php if($common['from_zoneid']!='0'){?>
<div class="spacer"></div>
  <div class="businessname-heading">
      <div class="main main-large main-100">
          <div class="businessname-heading-main">
            <?php if($common['businessid']!='') {  //var_dump($common['approval_message']);exit;?> 
            <font color="#333333">Business Name : </font> 
      <?php } ?>  
             <?php if($common['realtorid']!='') {  //var_dump($common['approval_message']);exit;?> 
            Realtor : 
      <?php } ?>  
            
         <?php /*?>   <?php if($common['sub_header_name_from_zone']['id']!=''){ ?>
            Realtor : <?php echo urldecode($common['sub_header_name_from_zone']['name']); ?>
            <?php } ?>    <?php */?>
            <?php if($common['organizationid']!=''){//echo '<pre>';var_dump($common['zone'][0]['type']);exit;?> <?php /*if($common['zone'][0]['type'] == 2){ ?>High School Sports :<?php }else{ */?>Organization : <?php /*}*/ ?><?php } ?>  
      <?php
       echo urldecode($common['sub_header_name_from_zone']['name']);
       if($common['organizationid']!=''){
       ?> (<?php
        if($common['zone'][0]['type'] == 0){ ?>Others<?php }else if($common['zone'][0]['type'] == 1){ ?>Municipality<?php }else if($common['zone'][0]['type'] == 2){ ?>Schools<?php }else{ ?>High School Sports<?php } ?>)
            <?php }if($common['businessid']!='') { ?><?=' '.$common['approval_message']?> <?php } ?>
              <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>/0/1" class="fright" style="text-decoration:none">&#8592; Back to Zone Dashboard</a><br/>
                <?php 
        $x = $this->session->userdata('business_search_value');
        if($common['businessid']!='' && $x!= ''){ ?>
                <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>" class="fright">&#8592; Back to Previous Search</a><br/>
                <?php } ?>
      <?php /*?><?php if($common['view_next_previous'] == 1){ ?>
                <a href="javascript:void(0);" id="previous_ad_change_category_for_business" class="fleft" data-businessid="<?=$common['businessid']?>" data-zoneid="<?=$common['from_zoneid']?>">&#8592; Go To previous Business To Assign Category</a>
                <a href="javascript:void(0);" id="next_ad_change_category_for_business" class="fright" data-businessid="<?=$common['businessid']?>" data-zoneid="<?=$common['from_zoneid']?>">Go To Next Business To Assign Category &#8594;</a>
            <?php } ?> <?php */?>  
            <?php if($common['from_zoneid']!=0 && $common['businessid']!=''){?>
            <br>
            <select class="fright" style="margin-right: 54px; margin-top: -12px;  height: 26px;" id="goto_different_ads">
            <option value="1">Business Display Filter</option>
            <option value="2"><a href="<?=base_url()?>Zonedashboard/all_business/<?=$common['zoneid']?>" class="fright" style="text-decoration:none">All Business</a> </option>
            <option value="3">Active Real Ads</option>
            <option value="4">Business Coming Soon</option>
            <option value="5">Inactive Ads</option>
            </select>
            <button class="fright" id="different_ads" style="margin-right: -210px; margin-top: -12px;  height: 26px;  width: 38px;"><p style="  margin-top: -2px; margin-left: -6px;">Go</p></button>
         
         <?php 
          }?>
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
<div class="container_tab_header">Business Payment Certification</div>
<div class="container_tab_content ui-widget-content">
<div id="table_contet">

	<table class="pretty" border="0" cellpadding="0" cellspacing="0">
  <thead id="showhead" class="headerclass">
    <tr>
      <th width="10%">Payment Id</th>
      <th width="10%">Business Id</th>
      <th width="15%">Business Name</th>
      <th width="10%">Payment Purpose</th>
      <th width="10%">Users Paid</th>
      <th width="10%">Business Amount</th>
      <th width="15%">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php //var_dump($details_certificate_payment_list); ?>
  <?php foreach ($details_certificate_payment_list as $value) {
  	//var_dump($value);
  	$auction_array = json_decode($value['auction_details']);
  	$business_name=$auction_array->business_name ? $auction_array->business_name:'';
  	$business_id=$auction_array->business_id ? $auction_array->business_id:'';
  	$business_charged_amount = (8/100)*$value['buy_price_decrease_by'];
  	$business_amount = $value['amount']-$business_charged_amount;

  	//echo $business_amount;
   ?>
  	<tr>
      <td><?= $value['id']; ?></td>
  		<td><?= $business_id; ?></td>
  		<td><?= $business_name; ?></td>
  		<td>Payment for certification</td>
  		<td><?= $value['amount']; ?></td>
  		<td><?= $business_amount; ?></td>
  		<td>
        <?php if($value['status']){ ?>
        <button type="btn btn-success" class="view_business_payment_for_certificate" data-receiver-id="<?= $business_id; ?>" data-payer-id="<?= $zone_id; ?>" data-amount="<?= $business_amount; ?>" data-payment-id ="<?= $value['id']; ?>">Paid</button>
        <?php } else{ ?>
      <button type="btn btn-success" class="business_payment_for_certificate" data-receiver-id="<?= $business_id; ?>" data-payer-id="<?= $zone_id; ?>" data-amount="<?= $business_amount; ?>" data-payment-id ="<?= $value['id']; ?>">Pay Now</button>
      <?php } ?>
      </td>
  	</tr>
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
		$('#zone_payment_for_certificate').addClass('active');
		$(".business_payment_for_certificate").click(function(){
      var payment_id = $(this).attr('data-payment-id');
			var receiver_id = $(this).attr('data-receiver-id');
			var payer_id  = $(this).attr('data-payer-id');
			var amount = $(this).attr('data-amount');
			window.location.href="<?= base_url('Zonedashboard/business_payment_certification') ?>/"+payer_id+"/"+receiver_id+"/"+amount+"/"+payment_id;

		});
	});
</script>