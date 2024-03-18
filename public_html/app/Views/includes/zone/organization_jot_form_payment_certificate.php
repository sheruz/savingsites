<div id="jotform" style="width:100%;height:500px !important" >
<iframe src="<?php echo base_url()?>Zonedashboard/organization_jot_form_view/<?php echo $receiver_id; ?>/<?php echo $zone_id; ?>/<?php echo $amount; ?>/5" width="70%" height="100%" frameborder="0"></iframe> 
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#zone_data_accordian").click();
	$("#zone_data_accordian").next().slideDown();
	$('#jotform').click();
	$('#jotform').next().slideDown();
	$('#organization_payment_for_certificate').addClass('active');
});
</script>