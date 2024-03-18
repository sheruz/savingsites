<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
<div class="content_container transfer_pboo_container">
<div class="pboo_credit_transfer cus-pboo bv_pboo_credit">

<div class="form-group">

	<label for="user_name">Enter pboo username you want to transfer pboo credits</label>

	<input type="text" name="user_name" id="user_namepboo" class="form-control">

</div>

<button class="btn btn-success" id="search_buttonpboo">Search</button>

<!--<div class="form-group pboo_button_submit">

	<button class="btn btn-success" id="search_button">Search</button>

</div>-->

<div id="account_details" class="pboo_credit_transfer">

</div>

<div id="message"></div>

</div>
</div>

<style type="text/css">

	.pboo_credit_transfer{

		max-width: 600px;

		padding-top: 50px;

		margin: 0px auto;



	}

	.pboo_button_submit{

		float: right;

		padding-top: 20px;

		margin-right: 55px;

	}

	.common_form_class{

		margin-top: 20px;

	}

	.error{

		border: 1px solid red !important;

	}

	/*.label_for_receiver_details{

		margin-left:255px;

	}*/

	input.common_class{

		margin-left: :50px;

	}

	label.common_class{

		width:340px;

		display: inline-block;

	}

	.form-control {

    display:initial !important;

}



</style>



<script type="text/javascript">

	 // $(document).ready(function(){

   // $("#organization_data_accordian").click();

   //      $("#organization_data_accordian").next().slideDown();

   //        $(".Paymentlistingpanel").click();

   //      $(".Paymentlistingpanel").next().slideDown();

   //      // $('#jotform').click();

   //      // $('#jotform').next().slideDown();

   //      // $('#view_listing').addClass('active');

   //      $(".Paymentlistingpanel").addClass('active');
   //      $("#transfer_pboo_credits").addClass('active');

   //      var payer_id = "<?= $organization_id; ?>";

   //      $("#search_button").click(function(){

   //      	var pboo_user_name = $("#user_name").val();

   //      	if(pboo_user_name){

   //      	var data_to_use = {username:pboo_user_name,payer_id:payer_id,payer_type:'org'};

   //      	PageMethod("<?=base_url('organizationdashboard/pboo_account_details')?>", "Getting account details... <br/>This may take a few minutes", data_to_use,account_details_data, null);

   //      	} else{

   //      		$("#user_name").addClass('error');

   //      		return false;

   //      	}

   //      });

   //  });

	 // function account_details_data(result){

	 // 	$.unblockUI();

	 // 	var total_string_content = "";

	 // 	if(result['status'] == 'success'){

	 // 		var name = result['receiver_details']['first_name'] + " " +result['receiver_details']['last_name'];

	 // 		var email = result['receiver_details']['email'];

	 // 		var address = result['receiver_details']['address1'] + "" +result['receiver_details']['address2'];

	 // 		var city_name = result['receiver_details']['city_name'];

	 // 		var country_name = result['receiver_details']['country_name'];

	 // 		var phone = result['receiver_details']['phone'];

	 // 		var id = result['receiver_details']['id'];

	 // 		var payer_id = result['payer_pboo_id'];

	 // 		   total_string_content = "<div class='form-group common_form_class'><label for='receiver_name' class='label_for_receiver_details common_class'>Receiver Name</label><input type='text' class='form-control' id='receiver_name' value='"+name+"' class='common_class' readonly></div><div class='form-group common_form_class'><label for='email' class='label_for_receiver_details common_class'>Email</label><input type='text' id='receiver_email' value='"+email+"' class='common_class' readonly></div><div class='form-group common_form_class'><label for='address' class='label_for_receiver_details common_class '>Address</label><textarea id='address' class='common_class'>"+address+"</textarea></div><div class='form-group common_form_class'><label for='city' class='label_for_receiver_details common_class'>City</label><input type='text' value='"+city_name+"' id='city' class='common_class'></div><div class='form-group common_form_class'><label for='country_name' class='label_for_receiver_details common_class'>Country Name</label><input type='text' class='common_class' id='country_name' name='country_name' value='"+country_name+"' readonly></div><div class='form-group common_form_class'><label for='phone' class='label_for_receiver_details common_class'>Phone No</label><input type='text' value='"+phone+"' class='common_class'></div><div class='form-group common_form_class'><label for='Credit' class='common_class'>Transfer Credit Quantity</label><input type='text' id='quantity' name='credit_quantity'></div><input type='hidden' value='"+id+"' id='receiver_id'><input type='hidden' id='payer_pboo_id' id='payer_id' value='"+payer_id+"' ><div class='form-group common_form_class'><button class='btn btn-success' id='transfer_credit_buttons'>Transfer Credits</button></div>"

	 		

	 // 	} else if(result['status'] == 'nousers'){

 	// 		total_string_content = "<p style='color:red'>Sorry No user Found with your search result</p>";

	 // 	} else if(result['status'] == 'your_pboo_not_exists'){

	 // 		total_string_content = "<p style='color:red'>Sorry you have no pboo account to transfer credits</p>";	

	 // 	}

	 // 	$("#account_details").html(total_string_content);



	 // }

	 // $(document).on('click','#transfer_credit_button',function(){

	 // 	var credits = $("#quantity").val();

	 // 	var check_valid_quantity = checkinteger(credits);

	 // 	var receiver_id = $("#receiver_id").val();

	 // 	var payer_pboo_id=$("#payer_pboo_id").val();

	 // 	if(check_valid_quantity){

	 // 	if(credits && receiver_id){

	 // 		var data_to_use = {credits:credits,receiver_id:receiver_id,payer_pboo_id:payer_pboo_id};

	 // 		PageMethod("<?=base_url('organizationdashboard/pboo_credit_transfer')?>", "Tranfering Pboo credits... <br/>This may take a few minutes", data_to_use,pboo_credit_transfer_result, null);



	 		

	 // 	} else{

	 // 		$("#quantity").addClass('error');

	 // 		return false;

	 // 	}

	 // }else {

	 // 	$("#message").html("<p style='color:red'>Please enter a valid credit</p>");



	 // }

	 // 	//alert(quantity);



	 // });

	 // function pboo_credit_transfer_result(result){

	 // 	$.unblockUI();

	 // 	var message_content = "";

	 // 	if(result['status'] == 'success'){

	 // 		message_content = "<p style='color:green'>Your credits has successfully transfered</p>";

	 // 	} else if(result['status'] == 'failed'){

	 // 		message_content = "<p style='color:red'>Sorry some error occurred,please try again</p>";

	 // 	}else if(result['status'] == 'insufficient_credits'){

	 // 		message_content = "<p style='color:red'>You have not enough credits to transfer,you have "+result['current_credit']+" credits left</p>";

	 // 	}

	 // 	$("#message").html(message_content);

	 // }

	 // function checkinteger(integerval){

	 // 	if (/^[0-9]{0,10}$/.test(+integerval)){

	 // 		return true;

	 // 	} else{

	 // 		return false;

	 // 	}

	 // }

</script>