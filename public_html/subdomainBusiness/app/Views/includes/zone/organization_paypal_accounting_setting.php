<div class="container paypal-zone-tab" id="jotfrom_upload_form">

	<div class="content_container bv_paypal_setup">

		<h1 class="container_tab_header">Paypal Account Setting</h1>

		<div id="success_msg" style="font-size:17px;margin-bottom:8px;color:green;"></div>

		<div class="container_tab_content ui-widget-content">
			<div class="row">

				<div class="col-md-6">
						<img src="https://cdn.savingssites.com/paypal.jpg" class="cus-radius">
				</div>
			<div class="col-md-6">
				
			<form class="form-horizontal1 cus-paypal">

				<div class="form-group center-block-table text_area_to_save_code">
					<p class="form-group-row">
						<label for="comment" class="fleft w_200">Paypal Account:<?//=$zone_id?></label>
						<input type="text" id="paypal_url" name="paypal_url" class="w_536" value="<?=(!empty($get_paypal_info['paypal_url']) ? $get_paypal_info['paypal_url'] : '')?>" placeholder="Please Provide your PayPal Acount Email Address">
					</p>
				</div>
				

				<div class="form-group center-block-table  ">

					<p class="form-group-row">

						<label for="comment" class="fleft w_200">Braintree Merchant ID:<?//=$zone_id?></label>

						<input type="text" id="braintree_merchantid" name="braintree_merchantid" class="w_536" value="<?=(!empty($get_paypal_info['paypal_url']) ? $get_paypal_info['braintree_merchantid'] : '')?>" placeholder="Please Provide your Braintree Acount Merchant ID">

					</p>

				</div>

					<div class="form-group center-block-table  ">

					<p class="form-group-row">

						<label for="comment" class="fleft w_200">Braintree Public Key:<?//=$zone_id?></label>

						<input type="text" id="braintree_public_key" name="braintree_public_key" class="w_536" value="<?=(!empty($get_paypal_info['braintree_public_key']) ? $get_paypal_info['braintree_public_key'] : '')?>" placeholder="Please Provide your Braintree Acount Public Key">

					</p>

				</div>

				<div class="form-group center-block-table  ">

					<p class="form-group-row">

						<label for="comment" class="fleft w_200">Braintree Private Key:<?//=$zone_id?></label>

						<input type="text" id="braintree_private_key" name="braintree_private_key" class="w_536" value="<?=(!empty($get_paypal_info['braintree_private_key']) ? $get_paypal_info['braintree_private_key'] : '')?>" placeholder="Please Provide your Braintree Acount Private Key">

					</p>

				</div>



				<div class="" style="text-align: left;

			margin-top: 20px;" id="submit_code">

					<div class=" col-sm-10">

						<button  id="submit_code_button" class="">Save</button>

					</div>

				</div>

			</form>
			</div>
			
		</div>


		</div>

	</div>

</div>

<script type="text/javascript">

$('div.text_area_to_save_code').not(':eq(0)').hide();

	$(document).ready(function(){

		$("#zone_data_accordian").click();

		$("#zone_data_accordian").next().slideDown();

		$('#payment').click();

		$('#payment').next().slideDown();

		$('#organization_paypal_accounting_setting').addClass('active');

        $("#submit_code_button").click(function(event){

            event.preventDefault();

            var zone_id ="<?= $zone_id; ?>";
            var category_id = $("#paypal_url").val();
            var braintree_merchantid = $("#braintree_merchantid").val();
            var braintree_public_key = $("#braintree_public_key").val();
            var braintree_private_key = $("#braintree_private_key").val();



            var dataToUse = {'paypal_url':category_id,'braintree_merchantid':braintree_merchantid,'braintree_public_key':braintree_public_key , 'braintree_private_key':braintree_private_key,zone_id:zone_id};

            PageMethod("<?=base_url('Zonedashboard/update_paypal_accounting_setting')?>", "Processing...<br/>This may take a minute.", dataToUse,updateStatus, null);

			$("#success_msg").html("Set Successfully");

        });



	});

    function updateStatus(response){

        $.unblockUI();

        

    }

</script>