<?php
	$organization_name=$organization_details->name;
	if($jotform_embed_code[0]->code){
		echo $jotform_embed_code[0]->code;
	} else{
		echo "<h4>This Organization has not uploaded any form for payment</h4>";
	}
?>
<script type="text/javascript">
	var organization_name = "<?= $organization_name; ?>";
	var organization_id = "<?= $organizatifon_id; ?>";
	var amount = "<?= $amount; ?>";
	var organization_name_input = document.querySelectorAll('[name$="organizationName"]');
	 organization_name_input[0].value=organization_name;
	 organization_name_input[0].readOnly   = true;
	 var organization_id_input = document.querySelectorAll('[name$="organizationId"]');
	 	organization_id_input[0].value = organization_id;
	 	organization_id_input[0].readOnly = true;
	 var amount_input_field = document.querySelectorAll('[name$="amount[price]"]');
	 	 amount_input_field[0].value = amount;
	 	 amount_input_field[0].readOnly = true;

</script>