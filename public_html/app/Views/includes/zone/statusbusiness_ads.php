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

</style>



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

            <input type="text" id="global_bus_search" name="global_bus_search" class="text-input" placeholder="Business name or phone no. or id" style="" value="<?php echo $this->session->userdata('business_search_value') ?>" />

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

  


    <div id="container_tab_content" class="container_tab_content">

      <ul style="display:none;">

        <li><a href="#tabs-1" id="tabs-title_1">Trial Businesses</a></li>

        <li><a href="#tabs-2" id="tabs-title_2">Paid Businesses</a></li>

      </ul>

      <!-- + Trial Businesses With Non Temp Category -->

      <div id="tabs-1">

        <div class="form-group">

        <!--<div class="container_tab_header" style="background-color:#D2E08F; color:#222; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">These Business always having other than 'Businesses Uploaded' Category/Subcategory.</div>-->

          <div class="container_tab_header" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;display:none;">

               <!-- <span style="padding-left:5px;"><strong>Filter</strong></span>

                <select style="width:390px; margin-right:53px;" name="business_zone_tbntc" id="business_zone_tbntc">

                    <option value="0">Businesses advertising in my zone but located outside my zone</option>

                    <option value="1">Businesses in my zone and located in my zone</option>

                    

                </select>-->

                <button class="btn-sm active_tbntc active" type="button" id="2###tbntc" style="display:none;">Search for Active Businesses</button>

                <button class="btn-sm deactive_tbntc" type="button" id="-2###tbntc" style="display:none;">Search for Inactive Businesses</button>

                <!--<button class="btn-sm " type="button" style="background-color:green">Search</button>-->                

                <a href="javascript:void(0);" onclick="$('#trial_biz').slideToggle('slow')"><img src="<?=base_url()?>assets/images/find.png" style="margin:7px 0 0 240px" width:"20px" height="20px" alt="Search Businesses" title="Search Businesses"/></a>

                

                <a class="fright new-help-button" href="javascript:void(0);" onclick="$('#helpdiv1').slideToggle('slow')">HELP<!--<img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" style="margin:3px 0 0 4px" width:"28px" height="28px"/>--></a>

            </div>

            <div id="helpdiv1" class="container_tab_header header-default-message" style="display:none;">

        <p>This shows the "Trial Businesses with Non Temp Category". It has the following:</p>

        <p>To view the active trial businesses located in your zone or outside your zone select the desired option from "Filter" dropdown and then click on "Active Biz." option.</p>

         <p>To view the deactive trial businesses located in your zone or outside your zone select the desired option from "Filter" dropdown and then click on "Deactive Biz." option.</p>

        <p>Search your business directly by entering the name inside "Direct search by business name" text box and click on the "Search" option. Or search businesses alphabetically by selecting the desired alphabet and then click on the "Search" option.</p>

        </div>

          <!-- Search Part Start -->

            <div class="container_filter bv_trial_biz" id="trial_biz">

            

            <div align="" class="bus_search_tbntc_active">

            <input type="text" id="text_bus_search" name="text_bus_search" placeholder=" Search Within The Results Below"  style="width:260px;" />

          <button class="btn-sm businesscheck"  id="btn_bus_search_by_name" type="button">Search</button>

            <strong style="margin-left: 28px;">Search Your Businesses </strong></strong>

            

           

                <select name="bus_search_results" id="bus_search_results" style="width: 100px;">

                    <option value="contains">Contains</option>

                    <option value="startwith">Starts With </option>             

                </select>

            

            <select name="bus_search_by_alphabet" id="bus_search_by_alphabet" style="width: 190px;">

                <option value="-1">By Alphabetical Order</option><option value="all">ALL</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option><option value="H">H</option><option value="I">I</option><option value="J">J</option><option value="K">K</option><option value="L">L</option><option value="M">M</option><option value="N">N</option> <option value="O">O</option><option value="P">P</option><option value="Q">Q</option><option value="R">R</option><option value="S">S</option><option value="T">T</option><option value="U">U</option> <option value="V">V</option><option value="W">W</option><option value="X">X</option><option value="Y">Y</option><option value="Z">Z</option>               

            </select>

            <button class="btn-sm businesscheck"  id="search_business" type="button" style="">Search</button>

            </div>

            

            

            

            

            

            

            <div class="bus_search_tbntc_deactive" style="display:none;">

            <input type="text" id="text_bus_search_tbntc_deactive" name="text_bus_search_tbntc_deactive" placeholder="Direct search by business name, phone "  style="width:260px;" />

          <button class="btn-sm"  id="btn_bus_search_by_name_tbntc_deactive" type="button">Search</button>

            <strong>Search Your Businesses </strong></strong>

            <select name="select_bus_search_tbntc_deactive" id="select_bus_search_tbntc_deactive">

                <option value="-1">By Alphabetical Order</option><option value="all">ALL</option><option value="A">A</option><option value="B">B</option><option value="C">C</option><option value="D">D</option><option value="E">E</option><option value="F">F</option><option value="G">G</option><option value="H">H</option><option value="I">I</option><option value="J">J</option><option value="K">K</option><option value="L">L</option><option value="M">M</option><option value="N">N</option> <option value="O">O</option><option value="P">P</option><option value="Q">Q</option><option value="R">R</option><option value="S">S</option><option value="T">T</option><option value="U">U</option> <option value="V">V</option><option value="W">W</option><option value="X">X</option><option value="Y">Y</option><option value="Z">Z</option>               

            </select>

            <button class="btn-sm"  id="btn_bus_search_by_alphabet_tbntc_deactive" type="button">Search</button>

            </div>

          </div>

          <!-- Search Part End -->

          <div class="view_non_temp_business bv_temp_business" style="display:none;"></div>

          <div class="edit_non_temp_business" style="display:none;"></div>

        </div>

      </div>

    </div>

  </div>

</div>

<div id="dialog-confirm" style="display:none">

<textarea id="status_popup" style="height: 70px;width: 300px;margin-top: 20px;margin-left: 20px;"></textarea>

</div>





<script type="text/javascript">

$(document).ready(function () { //alert(1); 

  $('#zone_business_accordian').click();

  $('#zone_business_accordian').next().slideDown();

  $('#zone_status_ads_business').addClass('active');

 $('.allbusinesssub_ads').slideDown('slow');

  

  

  //$('#business_zone_pbntc_x').change(); 

  //$('#business_zone_pbntc').change();

  $("input[name=checkadfordelete]").attr('checked',false);

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

  var bus_search_results = $('#bus_search_results').val();

  

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

  

  //var data={'zoneid':zoneid,'business_zone':businesszone,'business_type':businesstype,'business_type_by_category':businesstypebycategory,'bus_search_by_name':charvalname,'bus_search_by_alphabet':charvalalphabet,lowerlimit:lowerlimit,upperlimit:upperlimit};

  var data={'zoneid':zoneid,

          'typeofbusinesses':typeofbusinesses,

          'typeofadds':typeofadds,

          'paymentstatus':paymentstatus,

          'activestatus':activestatus,

          'businessmode':businessmode,

          'bus_search_by_name':bus_search_by_name,

          'bus_search_by_alphabet':bus_search_by_alphabet,

          'bus_search_results':bus_search_results,

          'lowerlimit':lowerlimit,

          'upperlimit':upperlimit

          };

  PageMethod("<?=base_url('Zonedashboard/business_by_status')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);

});

////////////////////////////////////////////// Change Business Part Start ///////////////////////////////////////////////

// + To Show/Hide in Update menu

$(document).on('change','#action_performed',function(){ 

  var tag=$(this).val();//alert(tag);

  if(tag==6){ 

    $('select#change_business_status').show();

    $('select#action_performed_in_where').hide();

  }else if(tag==3){ 

    $('select#change_business_status').hide();

    $('select#action_performed_in_where').show();

  }

});

$(document).on('change','select#business_delete_all_or_specific',function(){

  var tag=$(this).val(); 

  if(tag==2){   

    $("input[name=checkadfordelete]").attr('disabled','disabled');

    $("input[name=select_all_business_non_temp]").attr('disabled','disabled');

  }else{ 

    $("input[name=checkadfordelete]").attr('disabled',false);

    $("input[name=select_all_business_non_temp]").attr('disabled',false);

  }

});

// - To Show/Hide in Update menu

// + To Select All from header

$(document).on('click','#select_all_business_non_temp',function(){ //alert(1);

   $('.display_checkbox1').attr('checked', this.checked);

 

}); // - To Select All from header

// + To click on individual checkbox, uncheck the 'Select All' checkbox

$(document).on('click','#individual_checkbox_business',function(){

  var total_checkbox=$("input[name=checkadfordelete]").length ;

  var total_checked_checkbox=$("input[name=checkadfordelete]:checked").length; 

  //alert(total_checkbox); alert(total_checked_checkbox); //return false;   

  if(total_checkbox!=total_checked_checkbox){ //alert(1);

     $('#select_all_business_non_temp').attr('checked', false);   

  }else if(total_checkbox==500){ //alert(2);

     $('#select_all_business_non_temp').attr('checked', true);    

  }

}); // - To click on individual checkbox, uncheck the 'Select All' checkbox

///////////////////////////////////////////////////////////////////////////////////////////////////////

function uniqueArr(arr) {

arr1 = new Array();

for (i = 0; i < arr.length; i++) {

if (!checkstatus(arr1, arr[i])) {

arr1.length += 1;

arr1[arr1.length - 1] = arr[i];

}

}

return arr1;

}

function checkstatus(arr, e) {

for (j = 0; j < arr.length; j++) if (arr[j] == e) return true;

return false;

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////

$('#update_non_temp_business').live('click',function(){



  var action_performed = $(this).parents('#action_performed_div').find('#action_performed').val();

  var change_business_status=$(this).parents('#action_performed_div').find('#change_business_status').val();

  var action_performed_in_where=$(this).parents('#action_performed_div').find('#action_performed_in_where').val(); 

  var business_delete_all_or_specific=$(this).parents('#action_performed_div').find('#business_delete_all_or_specific').val();

  var display_checkbox='';//alert(action_performed);return false;

  var status_popup_value ='';

  

  $("input[name=checkadfordelete]:Checked").each(function(i,item){ //console.log(item);

    display_checkbox+=$(item).val()+',';

  }); 

  display_checkbox=display_checkbox.substring(0,display_checkbox.length-1); 

  var a= display_checkbox.split(',');

  var b=uniqueArr(a);

  var display_checkbox=b.join(','); //alert(display_checkbox); return false;

  

  if(display_checkbox=='' && business_delete_all_or_specific==1){

    alert('Please Select At Least One Business.');

    return false;

  }

  var business_type=$(this).attr('data-businesstype'); //alert(business_type);

  var business_type_by_category=$(this).attr('data-businesstypebycategory');// alert(business_type_by_category); return false;

  var business_zone=$(this).attr('data-businesszone');  

  var businessmode=$(this).attr('data-businessmode');//alert(businessmode);return false;

  var typeofadds=$(this).attr('data-typeofadds');

  var paymentstatus=$(this).attr('data-paymentstatus');

  var activestatus=$(this).attr('data-activestatus');

  var typeofbusinesses=$(this).attr('data-typeofbusinesses');

  var business_id=$(this).attr('data-busid'); 



  data={businessid:display_checkbox,zoneid:$('#zoneid').val(),action_performed:action_performed,change_business_status:change_business_status,action_performed_in_where:action_performed_in_where,business_delete_all_or_specific:business_delete_all_or_specific,business_type:business_type,business_type_by_category:business_type_by_category,business_zone:business_zone,businessmode:businessmode,typeofadds:typeofadds,paymentstatus:paymentstatus,activestatus:activestatus,typeofbusinesses:typeofbusinesses,business_id:business_id}

  

  $('#businessdata').val(JSON.stringify(data)); 

   
    if(change_business_status ==1){

     $("#dialog-confirm").html($("#dialog-confirm").html());

        $("#dialog-confirm").dialog({

        resizable: false,

        modal: true,

        title: "Status Changing Reason",

        height: 200,

        width: 400,

        dialogClass: 'no-close success-dialog',

        buttons: {

          "Yes": function () {

            $(this).dialog('close');

              callback(true);
 
            

          },

        }

      });

        function callback(value) {

        if (value) {

          status_popup_value = $('#status_popup').val();//alert(status_popup_value);return false;

          data['status_popup_value'] = status_popup_value;

         PageMethod("<?=base_url('Zonedashboard/action_performed_all_ads')?>", "Action Performed...<br/>This may take a few minutes", data, businesssuccess, null);
         

        } 

    }

    

  }else{

    data['status_popup_value'] = '';

    PageMethod("<?=base_url('Zonedashboard/action_performed_all_ads')?>", "Action Performed...<br/>This may take a few minutes", data, businesssuccess, null);

       

  }

 

});

//  live section completed

function businesssuccess(result){  //alert(JSON.stringify(result)); //alert(result);//alert(msg);return false;

  $.unblockUI();



  var business_delete_all_or_specific=result.Title;

 // var delete_response = result.Message;           //  receive deleting response

  var data =  JSON.parse($('#businessdata').val());

  var changingstatus = $('#update_non_temp_business').parents('#action_performed_div').find('#change_business_status').val(); 

  var paymentstatus = $('#update_non_temp_business').attr('data-paymentstatus');

  var activestatus = $('#update_non_temp_business').attr('data-activestatus'); 

 
}

////////////////////////////////////////////// Change Business Part End ///////////////////////////////////////////////

/////////////////////////////////////////////// Edit Business Part start ////////////////////////////////////////////////

 
 

$(document).on('click','#back_to_business',function(){

  $('#search_business').click();

});

/////////////////////////////////////////////// Edit Business Part end ////////////////////////////////////////////////



///////////////////////////////////////////////  N  E  W        S  E  C  T  I  O  N  /////////////////////////////////////////////////////



  $(document).on('click','.businesscheck',function(){ 

    var typeofbusinesses = $("input[name=typeofbusinesses]:checked").val() ;

    var typeofadds = $("input[name=typeofadds]:checked").val() ;

    var paymentstatus = $("input[name=paymentstatus]:checked").val() ;

    var activestatus = $("input[name=activestatus]:checked").val() ;

    var businessmode = $("input[name=businessmode]:checked").val() ;

    var search_txt = '' ;

  
    if(paymentstatus == 3){

      search_txt += 'Businesses Uploaded, ' ;

    }else if(paymentstatus == 2){

      search_txt += 'Free Trial, ' ;

    }else if(paymentstatus == 1){

      search_txt += 'Paid, ' ;

    }

    else if(paymentstatus == 4){

      search_txt += 'Businesses Uploaded, Free Trial, Paid, ' ;

    }

    

    if(activestatus == 1){

      search_txt += 'Viewable, ' ;

    }else if(activestatus == 2){

      search_txt += 'Not Viewable, ' ;

    }else if(activestatus == 3){

      search_txt += 'Viewable, Not Viewable, ' ;

    }

    

    if(businessmode == 1){

      search_txt += 'All Businesses ' ;

    }else if(businessmode == 2){

      search_txt += 'Business Opportunity Providers ' ;

    }

    if(search_txt != ''){//alert(search_txt);

      $('#search_category').html(search_txt);

    }

    var zoneid=$('#zoneid').val();

    var bus_search_by_name=$('#text_bus_search').val(); 

    var bus_search_by_alphabet = $('#bus_search_by_alphabet').val() ;//alert(bus_search_by_alphabet);

    var bus_search_results = $('#bus_search_results').val();    

    if(bus_search_by_name!='' && bus_search_by_alphabet!='-1'){

      alert('Please Select One Search Criteria..');

      return false;

    }

    var export_str = paymentstatus + ',' + activestatus + ',' + businessmode + ',' + bus_search_by_name + ',' + bus_search_by_alphabet + ',' + bus_search_results;

    $('#exportpattern').val(export_str) ;

    $('.edit_non_temp_business').hide();

    var data={'zoneid':zoneid,

          'typeofbusinesses':typeofbusinesses,

          'typeofadds':typeofadds,

          'paymentstatus':paymentstatus,

          'activestatus':activestatus,

          'businessmode':businessmode,

          'bus_search_by_name':bus_search_by_name,

          'bus_search_by_alphabet':bus_search_by_alphabet,

          'bus_search_results' :bus_search_results

          };

          

    PageMethod("<?=base_url('Zonedashboard/all_ads_by_filtering')?>", "Displaying Businessess...<br/>This may take a few minutes", data, successdata, null);

  

  });

  function successdata(result){ 

    $.unblockUI();  

    if(result.Tag!=''){ 

      var total_result=result.Title; //alert(total_result);   

      var limit=result.Message;

      limit_final=limit.split(',');

      lowerlimit=limit_final[0];
 

      if(limit=='500,500' || lowerlimit=='0'){ 

        $(".view_non_temp_business").html('');

        $(".view_non_temp_business").show();

        $(".view_non_temp_business").append(result.Tag);

        

      }else{

        $(".view_non_temp_business").show();

        $(".view_non_temp_business").find('.all_business_show_table  tbody').append(result.Tag);

      }   

      if(total_result<500){

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
 
  

  $(document).ready(function(){

         $(document).on('blur','#biz_name',function(){

       //$('#biz_name').focusout(function(){

         if($('#biz_name').val()== ''){

             var txt = '<h5 style="color:#FF0000">Please enter business name.</h5>';

           $('#error_contact_name').html(txt);

           $('#error_contact_name').show();

           $('#error_contactbiz_name').html(txt);

           $('#error_contactbiz_name').show();

           

           return false;

         }else{

           $('#biz_name').val();

           //$('#error_contact_name').hide();

           setTimeout(function(){

              $('#error_contact_name').hide('slow');

            }, 1000);

           setTimeout(function(){

              $('#error_contactbiz_name').hide('slow');

            }, 1000);

         }

        });



      $(document).on('blur','#biz_phone',function(){      

        if($('#biz_phone').val()== ''){

            var txt = '<h5 style="color:#FF0000">Please enter contact number.</h5>';

            $('#error_contact_phone').html(txt);

            $('#error_contact_phone').show();

            $('#error_contactbiz_phone').html(txt);

            $('#error_contactbiz_phone').show();

            return false;

          }else{

            $('#biz_phone').val();

            setTimeout(function(){

                $('#error_contact_phone').hide('slow');

              }, 1000);

            setTimeout(function(){

                $('#error_contactbiz_phone').hide('slow');

              }, 1000);

          } 

      });

      
 

      $(document).on('blur','#biz_first_name',function(){  

          if($('#biz_first_name').val()== ''){

             var txt = '<h5 style="color:#FF0000">Please enter first name.</h5>';

           $('#error_contact_first_name').html(txt);

           $('#error_contact_first_name').show();

           $('#error_contactbiz_first_name').html(txt);

           $('#error_contactbiz_first_name').show();

           return false;

         }else{

           $('#biz_first_name').val();

           //$('#error_contact_name').hide();

           setTimeout(function(){

              $('#error_contact_first_name').hide('slow');

            }, 1000);

           setTimeout(function(){

              $('#error_contactbiz_first_name').hide('slow');

            }, 1000);

         }

      });

      

  $(document).on('blur','#biz_last_name',function(){      

       if($('#biz_last_name').val()== ''){

             var txt = '<h5 style="color:#FF0000">Please enter last name.</h5>';

           $('#error_contact_last_name').html(txt);

           $('#error_contact_last_name').show();

           $('#error_contactbiz_last_name').html(txt);

           $('#error_contactbiz_last_name').show();

           return false;

         }else{

           $('#biz_last_name').val();

           //$('#error_contact_name').hide();

           setTimeout(function(){

              $('#error_contact_last_name').hide('slow');

            }, 1000);

          setTimeout(function(){

              $('#error_contactbiz_last_name').hide('slow');

            }, 1000);

         }

  

          });

    

    });

  

  



///////////////////////////////////////////////  N  E  W        S  E  C  T  I  O  N  /////////////////////////////////////////////////////

</script>