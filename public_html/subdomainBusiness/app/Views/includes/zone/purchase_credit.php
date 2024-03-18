<div class="content_container">

<?php if($common['from_zoneid']!='0'){?>

<div class="spacer"></div>

  <div class="businessname-heading">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <?php if($common['businessid']!='') {  //var_dump($common['approval_message']);exit;?> 

            <div style="float:left;"><font color="">Business Name : </font> <div class="oswald" style="font-size:26px; line-height:initial;">

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

            <?php }if($common['businessid']!='') { ?><?= ' '.$common['approval_message']?> <?php } ?>

          </div>

          </div>

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

            <select class="fright" style="margin-right: 36px; margin-top: -12px;  height: 26px;" id="goto_different_ads">

            <option value="1">Business Display Filter</option>

            <option value="2"><a href="<?=base_url()?>Zonedashboard/all_business/<?=$common['zoneid']?>" class="fright" style="text-decoration:none">All Business</a> </option>

            <option value="3">Active Real Ads</option>

            <option value="4">Business Coming Soon</option>

            <option value="5">Inactive Ads</option>

            </select>

            <button class="fright" id="different_ads" style="margin-right: -256px; margin-top: -12px;  height: 26px;  width: 38px; background: #7b498f; border: none;"><p style="margin-top: -4px; margin-left: -6px;">Go</p></button>

         

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



<?php

$zoneName = $zone_name[0]['name'];

$zone_owner_name = $zone_name[0]['first_name']." ".$zone_name[0]['last_name'];

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



<script>

 $(document).ready(function(){

   //alert('Test');

  //$("#success").show().delay(5000).fadeOut();

  $("#success").show();

  setTimeout(function() { $("#success").hide(); }, 5000);



  $("#error").show();

  setTimeout(function() { $("#error").hide(); }, 5000);



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

    $("#item_number").val(choose_credit);

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

			//window.open('https://www.paypal.com', '_blank');

			//return false;

      var credit_price_value = $("#credit_price").val();

      

      $("#amount").val(parseInt(credit_price_value)*0.2);

			$("#paypalpayment").submit();

		}

		else{

			return false;

		}



	});

 });

</script>


  <div class="row">
    <div class="col-md-6 bv_align_center">
      <img src="https://cdn.savingssites.com/credit.jpg">
    </div>
    <div class="col-md-6">
      
  <?php if(isset($payment_status) && $payment_status == "Completed"){?>

  <span id="success" style="color:green;"><h4>Payment Successful</h4></span>

  <?php }else if(isset($payment_status) && $payment_status == "Pending"){ ?>

  <span id="error" style="color:red;"><h4>Payment Pending</h4></span>

  <?php } ?>

<div class="cus-box  credit_pp_box">
  <h2>Purchase credit</h2>

    <div class="form-group">

      <label style="color: #000;" for="email">Zone Name:</label>

      <div>

        <input type="text" class="form-control form-control-sm" id="zone_name" placeholder="Enter zone name" name="zone_name" value="<?php echo $zoneName;?>">

      </div>

    </div>



    <div class="form-group">

      <label for="pwd" style="color: #000;">Zone owner Name:</label>

      <div>          

        <input type="text" class="form-control form-control-sm" id="zone_owner_name"

     placeholder="Enter zone owner Name" name="zone_owner_name" value="<?php echo $zone_owner_name; ?>">

      </div>

    </div>



    <div class="form-group">

      <label style="color: #000;" for="choose_credit">Choose 
      credit:</label>

      <select class="form-control form-control-sm" style="width:100%" id="choose_credit">

        <option value="">select credit</option>

        <option value="200">200</option>

        <option value="300">300</option>

        <option value="400">400</option>

      </select>

    </div>



    <div class="form-group">

        <label style="color: #000;" class="control-label" for="pwd">Price:</label>

        <div class="cus-usd-main">          

          <input type="text" class="form-control form-control-sm" id="credit_price"

      placeholder="Enter Price" name="credit_price"><label style="color: #000;" class="cus-usd">USD</label>

        </div>

      </div>

      

      <div class="form-group">        

        <div class="col-sm-offset-02">

          <button type="submit" class="btn btn-primary" id="credit_purchase">Submit</button>

        </div>

      </div>

  </div>
    </div>

  </div>



  

  <div class="modal-body">

        <?php //print_r($_SESSION);

            

        ?>

      <form name="paypal_form" class="text-center" id="paypalpayment" method="post" action="https://www.paypal.com/cgi-bin/webscr">

          <input type="hidden" name="business" value="ajdmm@optonline.net" />

           <!-- <input type="hidden" name="business" value="prabal.dey-buyer@outlook.com" /> -->

          <!-- <input type="hidden" name="return" value="<?=base_url()?>Zonedashboard/paypalcreditipn"> -->

          <input type="hidden" name="return" value="<?=base_url()?>Zonedashboard/buy_pekaboo_credits/<?=$common['zoneid']?>">

          <input type="hidden" name="cancel_return" value="<?=base_url()?>Zonedashboard/buy_pekaboo_credits/<?=$common['zoneid']?>">

          <input type="hidden" name="notify_url" value="<?=base_url()?>Zonedashboard/paypalCreditPayment/<?=$common['zoneid']?>">

          <input type="hidden" name="rm" value="2" />

          <input type="hidden" name="lc" value="" />

          <input type="hidden" name="no_shipping" value="1" />

          <input type="hidden" name="no_note" value="1" />

          <input type="hidden" name="currency_code" value="USD" />

          <input type="hidden" name="page_style" value="paypal" />

          <input type="hidden" name="charset" value="utf-8" />

          <input type="hidden" id="item_name" name="item_name" value="12" />

          <input type="hidden" name="cbt" value="Back to Purchase credit" />

          <input type="hidden" value="_xclick" name="cmd"/>

          <input type="hidden" name="amount" id="amount" value="0.15" />

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

          <input type="hidden" name="custom" value="<?//=$auc_id?>">

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

        <!-- <p>If you registered in Savings Sites Directory, a Peekaboo bidder account has already been created for you and 3 free peeking credits added to your account. If you are not logged in, then simply login and play Peekaboo! </p> -->

  </div>



</div>

<script type="text/javascript">

$(document).ready(function(){

	$("#adv_tools").click();

	$("#adv_tools").next().slideDown();

	$('#pekaboo_credits').click();

	$('#pekaboo_credits').next().slideDown();

	$('#buy_pekaboo_credits').addClass('active');
 
	var zone_id =  "<?php echo $zoneId; ?>";

});

</script>

