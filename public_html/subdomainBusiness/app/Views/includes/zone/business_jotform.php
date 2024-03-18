<div class="jot_form_embed_code">
 	<?php echo $jotform_embed_code[0]->code; ?>
</div>
<?php 
	//var_dump($business_details[0]->name);

 ?>
<script type="text/javascript">
	var business_name = "<?= $business_details[0]->name; ?>";
	var business_id = "<?= $business_id; ?>";
	var amount = "<?= $amount; ?>";
	var business_name_input = document.querySelectorAll('[name$="businessName"]');
	 business_name_input[0].value=business_name;
	 business_name_input[0].readOnly   = true;
	var business_id_input = document.querySelectorAll('[name$="businessId"]');
		business_id_input[0].value = business_id;
		business_name_input[0].readOnly   = true;
	var amount_input =  document.querySelectorAll('[name$="amount[price]"]');
		amount_input[0].value = amount;
		amount_input[0].readOnly = true;


</script>