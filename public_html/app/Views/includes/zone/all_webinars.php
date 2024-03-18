<style>

.ui-widget.success-dialog {

    font-family: Verdana,Arial,sans-serif;

    font-size: .8em;

}

a.deleteaction{
  background-color: #fff;
    text-decoration: none;
    padding: 1px 6px;
    border-width: 2px;
    -webkit-box-shadow: rgb(0 0 0 / 20%) 0 1px 0 0;
    -moz-box-shadow: rgba(0,0,0,0.2) 0 1px 0 0;
    box-shadow: rgb(0 0 0 / 20%) 0 1px 0 0;
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

<?php //echo $all_zone_business; //exit;?>

<input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>

<input type="hidden" id="businessdata" name="businessdata" value="<?php echo $zoneid;?>"/>

<div class="main_content_outer">

  <div class="content_container">

  <?php if($common['from_zoneid']!='0'){ ?>

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
   <div class="container_tab_header">All webinars </div>
    <div class="businessname-heading" style="overflow:hidden;">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <div class="center" style="width:100%">

             <font style="">Search All Businesses (Real Active Ads, Businesses Uploaded, Biz Opp Providers, Inactive Ads)</font> 

            <input type="text" id="global_bus_search" name="global_bus_search" class="text-input" placeholder="Business name or phone no. or id" style="" value="<?php echo $this->session->userdata('business_search_value') ?>" />

            <button class="btn-sm"  id="global_bus_search_btn" type="button"  data-search-type="2" style="">Search</button>

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
 

      <div class="pretty_new_col">                  
<table class="pretty all_business_show_table" border="0" cellpadding="0" cellspacing="0">
  <thead id="showhead" class="headerclass">
    <tr>
      <th width="20%">Webinar Name</th>
 
      <th width="15%">Role</th>
      
      <th width="10%">Room Type</th>
      <th width="10">Total People </th>
      <th width="10%">Price</th>
       <th width="10%">Action</th>
  
   
 
    </tr>
  </thead>
  <tbody>
   

        <?php 
        foreach($allwebinar as $allwebinar){ 
   
 
           ?>

            <tr id="1555710" class="uploadbusiness displaytableview_odd">
   
   
      <td width="15%"><b>       <?php echo $allwebinar['link']  ?>      </b><br>    </td>
           <td width="15%"><b>       <?php echo $allwebinar['role']  ?>      </b><br>    </td>
         
      <td width="20%"><?php echo $allwebinar['room_type']  ?></td>       
      <td width="10"> <?php echo $allwebinar['totalpeople']  ?>             </td>         
       <td width="10"> <?php  if($allwebinar['room_type'] == 'free'){  echo "-"; }else{  echo '$'.$allwebinar['price'];  }     ?>      </td>
        <td><a class="deleteaction" data-id="<?php echo $allwebinar['id'] ?>" href="#">Delete</a></td> 
 
                </tr>

        <?php   } ?>
     
       
       
        
        
        
        
        
        
         </tbody>
</table>
</div>

          
          <!-- Search Part End -->

          <div class="view_non_temp_business" style="display:none;"></div>

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

$(document).ready(function () { 


$('.deleteaction').click(function(e){    
      e.preventDefault();

if(confirm("Are you sure you want to delete this?")){
      $id = $(this).attr('data-id');  
  
      
      $.ajax({
          url: '<?=base_url('/auth/deleteaction')?>',
          type: 'POST',
          dataType:'json', 
          data: ({ zoneID:'<?php echo $zoneid; ?>' , 'form': $id }),
          success: function(data) {            
            location.reload();

          }

        }); 

}
    else{
        return false;
    }



});



$('#zonewebinar_allwebinars').addClass('active');
  $('#zonewebinar').click();

  // $('#zone_business_accordian').next().slideDown();

  // $('#get_all_business').addClass('active');

 $('.webinarsection').slideDown('slow');

 $('#adv_tools').next().slideDown();

   

  $("input[name=checkadfordelete]").attr('checked',false);

  // $('#adv_tools').click();

});



</script>