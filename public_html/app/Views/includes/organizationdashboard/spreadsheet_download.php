<div class="content_container transfer_pboo_container">
<div class="download_file bv_download_file" style="width:600px;margin:0px auto;">

<p>To download Certificate Beneficary Business list,click on download button</p>

<button class="btn btn-success" id="spreadsheet_download_button" data-organization-id="<?= $organization_id; ?>">Download</button>

</div>
</div>
<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />

<script type="text/javascript">

	// $(document).ready(function(){

	//    $("#organization_data_accordian").click();

  //       $("#organization_data_accordian").next().slideDown();

  //         $(".Paymentlistingpanel").click();

  //       $(".Paymentlistingpanel").next().slideDown();

  //       // $('#jotform').click();

  //       // $('#jotform').next().slideDown();

  //       // $('#view_listing').addClass('active');

  //       $(".Paymentlistingpanel").addClass('active');
  //       $("#certificate_benificary_organization_spread_sheet").addClass('active');

  //       $("#spreadsheet_download_button").click(function(){

  //       	var organization_id = $(this).attr('data-organization-id');

  //       	window.location ="<?= base_url('organizationdashboard/speradsheet_list_data'); ?>/"+organization_id+"/org";

  //       });

	// });

	// function spreadshett_list(request){

	// 	$.unblockUI();

	// 	alert(request);

	// }

</script>