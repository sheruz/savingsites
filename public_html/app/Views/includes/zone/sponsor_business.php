<style>

.ui-widget.success-dialog {

    font-family: Verdana,Arial,sans-serif;

    font-size: .8em;

}



.ui-widget-content.success-dialog {

    background: #F9F9F9;

    border: 2px solid #ACB2A5;;

    color: #222222;

}



.ui-dialog.success-dialog {

    left: 0;

    outline: 0 none;

    padding: 0 !important;

    position: absolute;

    top: 0;

}



.ui-dialog.success-dialog .ui-dialog-content {

    background: none repeat scroll 0 0 transparent;

    border: 0 none;

    overflow: auto;

    position: relative;

    padding: 0 !important;

    margin: 0;

}



.ui-dialog.success-dialog .ui-widget-header {

    background: lightgrey;

    border: 0;

    color: #000;

    font-weight: normal;

}



.ui-dialog.success-dialog .ui-dialog-titlebar {

    /*padding: 0.1em .5em;*/

    position: relative;

      font-size: 19px;

	  height: 25px;

}

#tab_view li{

	display: inline-block;

}

.draggable_div{

	width:150px !important;

	height:100px !important;

	background: #5f6e87;

	margin-left: 20px !important;

	text-align: center;

	color: white;

	cursor:grab;

	

}

</style>    



<ul id="tab_view" style="display: none">

	<li id="tab_1_list"><a style="cursor:pointer;text-decoration:none;">Sponsored Business List</a></li>

</ul>

<input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>

<input type="hidden" id="businessdata" name="businessdata" value="<?php echo $zoneid;?>"/>

<div class="main_content_outer">

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

            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="<?=base_url('assets/images/close_pop.png') ?>" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>

      </div>

    </div>



<?php } ?>



  	<div class="container_tab_header" style="position:relative;">

			Sponsor Business List

		</div>



    <div id="container_tab_content" class="container_tab_content">

    

      <!-- + Trial Businesses With Non Temp Category -->

      <div id="tabs-1">

        <div class="form-group">

  

            <div class="container_filter" id="trial_biz" style="  color:#fff; font-size:13px;margin-top:10px; margin-bottom:0px;">

          	<div align="center" class="bus_search_tbntc_active">

            <input type="hidden" id="text_bus_search" name="text_bus_search" placeholder=" Search Within The Results Below"  style="width:260px;" />

            <div style="display:none;"><strong>Search Your Businesses</strong></strong>

            <select name="bus_search_by_alphabet" id="bus_search_by_alphabet">

                <option value="-1">By Alphabetical Order</option>

                <option value="15">15 days</option>

                <option value="10">10 days</option>

                <option value="5">5 days</option>

                <option value="61">Already over</option>

            </select>

            <button class="btn-sm businesscheck"  id="search_business" type="button">Search</button> </div>

            </div>

            

          </div>

          <!-- Search Part End -->

          <div class="view_non_temp_business bv_temp_business" id="view_sponsored_business" style="display:none;"></div>

          <div class="edit_non_temp_business" style="display:none;"></div>

        </div>

      </div>

     <!--  <div id="tabs-2" style="display: none;">

      <ul id="sortable">

      </ul>

      </div> -->

    </div>

  </div>

</div>

<div id="dialog-confirm" style="display:none">

<textarea id="status_popup" style="height: 70px;width: 300px;margin-top: 20px;margin-left: 20px;"></textarea>

</div>





<script type="text/javascript">

$(document).ready(function () { //alert(1); 

	  console.log("fgdfgd_12");

	$('#zone_business_accordian').click();

	$('#zone_business_accordian').next().slideDown();

	$("#sponsor_business").click();

	$('#sponsor_business').next().slideDown();

	$('#details_sponsor_business').addClass('active');

    $('#search_business').click();



});









$(document).on('click','.more_non_temp_business',function(){ //alert(5);

	var typeofbusinesses = $("input[name=typeofbusinesses]:checked").val() ;

	var typeofadds = $("input[name=typeofadds]:checked").val() ;

	var paymentstatus = $("input[name=paymentstatus]:checked").val() ;

	var activestatus = $("input[name=activestatus]:checked").val() ;

	var businessmode = $("input[name=businessmode]:checked").val() ;

	

	var zoneid=$('#zoneid').val();

	var bus_search_by_name=$('#text_bus_search').val(); 

	var bus_search_by_alphabet = $('#bus_search_by_alphabet').val() ;

	$('.edit_non_temp_business').hide();

	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){

		alert('Please Select One Search Criteria..');

		return false;

	}

	

	var limit=$(this).attr('rel'); 

	limit_final=limit.split(',');

	var lowerlimit=limit_final[0];

	var upperlimit=limit_final[1];

	var zoneid=$(this).attr('data-zoneid'); //alert(zoneid);

	var businesstype=$(this).attr('data-businesstype'); //alert(businesstype);

	var businesstypebycategory=$(this).attr('data-businesstypebycategory'); //alert(businesstypebycategory);

	var businesszone=$(this).attr('data-businesszone'); //alert(businesszone);

	var charvalname=$(this).attr('data-charvalname'); //alert(charvalname);

	var charvalalphabet=$(this).attr('data-charvalalphabet'); //alert(charvalalphabet);



	var data={'zoneid':zoneid,

				  'typeofbusinesses':typeofbusinesses,

				  'typeofadds':typeofadds,

				  'paymentstatus':paymentstatus,

				  'activestatus':activestatus,

				  'businessmode':businessmode,

				  'bus_search_by_name':bus_search_by_name,

				  'bus_search_by_alphabet':bus_search_by_alphabet,

				  'lowerlimit':lowerlimit,

				  'upperlimit':upperlimit

				  };

	PageMethod("<?=base_url('Zonedashboard/get_all_sponsored_business_data')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);

});





/////////////////////////////////////////////// SEARCH BUTTON FOR TRIAL BUSINESS CHECKING ////////////////////////////////////////////////



$(document).on('click','#back_to_business',function(){

	$('#search_business').click();

});



	$(document).on('click','.businesscheck',function(){ 

		var zoneid=$('#zoneid').val();

		var bus_search_by_name=$('#text_bus_search').val(); 

		var bus_search_by_alphabet = $('#bus_search_by_alphabet').val() ;

		$('.edit_non_temp_business').hide();

	if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){

		alert('Please Select One Search Criteria..');

		return false;

	}

		

		var data={'zoneid':zoneid,

				  'bus_search_by_alphabet':bus_search_by_alphabet,

				  'bus_search_by_name':bus_search_by_name

				  };

		PageMethod("<?=base_url('Zonedashboard/get_all_sponsored_business_data')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);

	

	});

	function successdata(result){  

		$.unblockUI();

		console.log(result);

		//alert(result);

		$(".view_non_temp_business").html('');

		$(".view_non_temp_business").show();

		$(".view_non_temp_business").append(result);

		if(result.Tag!=''){		

			var total_result=result.Title; 	

			var limit=result.Message;

			limit_final=limit.split(',');

			lowerlimit=limit_final[0];

			if(limit=='10,10' || lowerlimit=='0'){ 

				$(".view_non_temp_business").html('');

				$(".view_non_temp_business").show();

				$(".view_non_temp_business").append(result.Tag);

				

			}else{

				$(".view_non_temp_business").show();

				$(".view_non_temp_business").append(result.Tag);

			}		

			if(total_result<10){

				$('.display_more_business').hide();			

			}else{

				$('.display_more_business').show();

			}

			$('.view_non_temp_business').find('thead.headerclass:not(:first)').hide();

			$('.view_non_temp_business').find('tr.headerclass_sub:not(:first)').hide();

			$('.view_non_temp_business').find('div.display_more_business:not(:last)').hide();

			$('.more_non_temp_business').attr('rel',limit);

			//$('.view_non_temp_business').find('div.container_tab_header').hide();	

			var default_message= $('.view_non_temp_business').find('table.pretty').length; 

			if(default_message==0){

				$('.view_non_temp_business').find('div.container_tab_header').show();

			}

		}

	}



/////////////////////////////////////////////// SEARCH BUTTON FOR TRIAL BUSINESS CHECKING ////////////////////////////////////////////////

function tabshow(tab_id) {

	if(tab_id == 'tab1') {

      $("#tabs-1").show();

      $("#tabs-2").hide();

	} else {

	  $("#tabs-1").hide();

      $("#tabs-2").show();



	}

}

$("#tab_2_li").click(function(){

	$.ajax({

		type:"POST",

		url:"<?php echo base_url('Zonedashboard/get_ordered_sponsored_business_data');?>",

		success:function(data){

			data=JSON.parse(data);

			alert(data.length);

			var html_content="";

			if(data){

				var j=1;

				for(i=0;i<data.length;i++){

					var id="item_"+j;

					html_content+="<li id='"+id+"' class='draggable_div' style='position:relative;'><p>"+data[i].name+"</p> <button class='counter' title='sponsor Order' style='top: 0px; position:absolute; right: 0px;  padding: 3px 7px; border-radius: 15px;'>"+j+"</button></li>";

					j++;

				}

				$("#sortable").html(html_content);



			}





		},

		error:function(error){

			console.log(error);

		}





	});



});

/*$("#tabs-2 #sortable").sortable({ 

		opacity: 0.6, 

		cursor: 'move',

		revert: true

});*/

$(document).ready(function(){

$('#sortable').sortable({

	update: function(event, ui){

		alert("hiii");

	}

});

});



</script>

<style type="text/css">
	#trial_biz {
    display: none;
}
</style>