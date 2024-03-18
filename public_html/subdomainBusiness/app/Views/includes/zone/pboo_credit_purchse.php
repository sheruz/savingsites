<?php

//print_r($zone_name);

/* $zone_id = $zone_id;

$zoneName = $zone_name[0]['name'];

$zone_owner_name = $zone_name[0]['first_name']." ".$zone_name[0]['last_name'];



echo stripcslashes($jotform_embed_code[0] ->code);*/



?>

<!--<script type="text/javascript">



	var zone_id = "<?= $zone_id; ?>";

	var zone_name = "<?= $zoneName; ?>";

	var zone_owner_name = "<?= $zone_owner_name; ?>";



	var zone_id_input = document.querySelectorAll('[name$="zoneId"]');

	zone_id_input[0].value =  zone_id;

	zone_id_input[0].readOnly  = true;



	var zone_name_input = document.querySelectorAll('[name$="zoneName"]');

	zone_name_input[0].value =  zone_name;

	zone_name_input[0].readOnly  = true;



	var zone_owner_name_input = document.querySelectorAll('[name$="zoneOwner"]');

	zone_owner_name_input[0].value = zone_owner_name;

	zone_owner_name_input[0].readOnly  = true;



	var amount_input = document.querySelectorAll('[name$="price[price]"]');

	amount_input[0].readOnly  = true;



	$(document).ready(function(){				

		$(document).on('change','[name$="chooseCredit"]',function(){

			var selectval = document.querySelectorAll('[name$="chooseCredit"]')[0].value;

			if(selectval == 200){

				document.getElementById('input_6_donation').value = 20;

			}else if(selectval == 300){

				document.getElementById('input_6_donation').value = 30;

			}else if(selectval == 400){				

				document.getElementById('input_6_donation').value = 40;

			}

		});

		

	});

</script>-->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"

 integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>

 $(document).ready(function(){

	 //alert('Test');

	$("#choose_credit").on("click",function(){

		var current_credit = $(this).val();



		

		if(current_credit == '')

		{

			$(this).css({'border':'1px solid red'});

		}else{

			$(this).css({'border':''});

			$("#credit_price").val(current_credit/10);

		}

		

		

	});



	$("#credit_purchase").on("click",function(){

		var zone_name 		= $("#zone_name").val();

		var zone_owner_name = $("#zone_owner_name").val();

		var choose_credit 	= $("#choose_credit").val();

		var credit_price 	= $("#credit_price").val();

		//alert(zone_name);

		var count = 0;



		if(zone_name == '')

		{

			//alert(zone_name);

			$("#zone_name").css({'border':'1px solid red'});

			//return false;

			count++;

		}else{

			$("#zone_name").css({'border':''});

		}



		if(zone_owner_name == '')

		{

			$("#zone_owner_name").css({'border':'1px solid red'});

			count++;

		}else{

			$("#zone_owner_name").css({'border':''});

		}



		if(choose_credit == '')

		{

			$("#choose_credit").css({'border':'1px solid red'});

			count++;

		}else{

			$("#choose_credit").css({'border':''});

		}



		if(credit_price == '')

		{

			$("#credit_price").css({'border':'1px solid red'});

			count++;

		}else{

			$("#credit_price").css({'border':''});

		}



		if(count == 0)

		{

			//window.location.href = "http://stackoverflow.com";

			window.open('https://www.paypal.com', '_blank');

			return false;

		}

		else{

			return false;

		}



	});

 });

</script>

<div class="container">

  <h2>Purchase credit</h2>

  <hr>

  <form class="form-horizontal" action="https://www.google.com/">



    <div class="form-group">

      <label for="email">Zone Name:</label>

      <div>

        <input type="text" class="form-control form-control-sm" id="zone_name" placeholder="Enter zone name" name="zone_name">

      </div>

    </div>



    <div class="form-group">

      <label for="pwd">Zone owner Name:</label>

      <div>          

        <input type="text" class="form-control form-control-sm" id="zone_owner_name"

		 placeholder="Enter zone owner Name" name="zone_owner_name">

      </div>

    </div>



	<div class="form-group">

		<label for="choose_credit">Choose credit:</label>

		<select class="form-control form-control-sm" style="width:50%" id="choose_credit">

			<option value="">select credit</option>

			<option value="200">200</option>

			<option value="300">300</option>

			<option value="400">400</option>

		</select>

	</div>



	<div class="form-group">

      <label class="control-label" for="pwd">Price:</label>

      <div>          

        <input type="text" class="form-control form-control-sm" id="credit_price"

		 placeholder="Enter Price" name="credit_price">USD

      </div>

    </div>

    

    <div class="form-group">        

      <div class="col-sm-offset-2">

        <button type="submit" class="btn btn-primary" id="credit_purchase">Submit</button>

      </div>

    </div>

  </form>

</div>

 

<div class="modal-body">

	<?php

			if ($_GET['page']!='checkout') {

		?>

		<form name="paypal_form" class="text-center" id="paypalpayment" method="post" action="https://www.sandbox.paypal.com/cgi-bin/webscr">

					<input type="hidden" name="business" value="prabal.dey@outlook.com" />

				<input type="hidden" name="return" value="http://peekabooauctions.com/index.php?page=paypalcreditipn"> 

				<input type="hidden" name="cancel_return" value="http://peekabooauctions.com/index.php?zoneid=<?php echo $zoneId?>&category=1">

				<input type="hidden" name="notify_url" value="http://peekabooauctions.com/index.php?page=paypalCreditPayment&userId=<?php echo $userId ?>&zoneId=<?php echo $zoneId?>">

				<input type="hidden" name="rm" value="2" />

				<input type="hidden" name="lc" value="" />

				<input type="hidden" name="no_shipping" value="1" />

				<input type="hidden" name="no_note" value="1" />

				<input type="hidden" name="currency_code" value="USD" />

				<input type="hidden" name="page_style" value="paypal" />

				<input type="hidden" name="charset" value="utf-8" />

				<input type="hidden" id="item_name" name="item_name" value="" />

				<input type="hidden" name="cbt" value="Back to FormGet" />

				<input type="hidden" value="_xclick" name="cmd"/>

				<input type="hidden" id="amount" name="amount" value="" />

				<!-- Product Information -->

				<input type="hidden" name="quantity" value="1">

				<input type="hidden" id="item_number" name="item_number" value="">

				<input type="hidden" name="undefined_quantity" value="">

				<input type="hidden" name="on0" value="">

				<input type="hidden" name="os0" value="">

				<input type="hidden" name="on1" value="">

				<input type="hidden" name="os1" value="">

				<!-- Shipping and Misc Information -->

				<input type="hidden" name="shipping" value="">

				<input type="hidden" name="shipping2" value="">

				<input type="hidden" name="handling" value="">

				<input type="hidden" name="tax" value="">

				<input type="hidden" name="custom" value="<?=$auc_id?>">

				<input type="hidden" name="invoice" value="">

				<!-- Customer Information -->

				<input type="hidden" name="first_name" value="">

				<input type="hidden" name="last_name" value="">

				<input type="hidden" name="address" value="">

				<input type="hidden" name="city" value="" >

				<input type="hidden" name="state" value="">

				<input type="hidden" name="zip" value="">

				<input type="hidden" name="email" value="">

				<input type="hidden" name="charset" value="utf-8">

				<!--<input type="submit" class="btn btn-primary" name="submit" value="Buy now">-->

			</form>

		<?php } ?>

			<!-- <p>If you registered in Savings Sites Directory, a Peekaboo bidder account has already been created for you and 3 free peeking credits added to your account. If you are not logged in, then simply login and play Peekaboo! </p> -->

</div>