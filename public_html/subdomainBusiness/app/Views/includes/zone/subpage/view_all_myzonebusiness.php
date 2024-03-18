 <?php 


if(!empty($non_temp_business_in_zone)) { 

        if($lowerLimit <= 10){

  ?>

<input type="hidden" id="business_type" value="<?=$business_type?>"/> <input type="hidden" id="business_type_by_category" value="<?=$business_type_by_category?>"/> <input type="hidden" id="business_zone" value="<?=$business_zone?>"/>

<table class="pretty all_business_show_table" border="0" cellpadding="0" cellspacing="0">

  <thead id="showhead" class="headerclass">

    <tr>

      <th width="10%">Business Id</th>

      <th width="15%">Business Name</th>

      <th width="20%">Business Status</th>

      <th width="10%">Contact Name</th>

      <th width="10">Telephone</th>

      <th width="10%">Zip Code</th>

      <th width="15%">Action</th>

      <th width="10%">Select/<br/>Deselect All<br/><input type="checkbox" class="get_businesses" name="select_all_business_non_temp" id="select_all_business_non_temp"  value="all" title="Select/Deselect All" alt="Select/Deselect All" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>"></th> 

    </tr>

  </thead>

  <tbody>

    <tr class="headerclass_sub">

      <td colspan="8"><div id="action_performed_div" class="fright">

          <select name="action_performed" id="action_performed" class="w_215 select_style_sm">

          <?php /*?><?php if($activestatus==3 || $paymentstatus==4){?>

            <option value="3">Delete</option>             

            <?php } else {?>

            <option value="6">Change Public Display Status</option>

            <option value="3">Delete</option>

            <?php } ?>

<?php */?>         

      <option value="6">Change Public Display Status</option>

            <option value="3">Delete</option> 

    </select>

          <!--<select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">-->

          <?php if($activestatus==3 || $paymentstatus==4){ // When 'all' is selected in the left pannel ?>

            <select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">    

                <option value="2">Free Trial Businesses - Ad is viewable</option>

                <option value="-2">Free Trial Businesses - Ad is Not viewable</option>

                <option value="1">Paid Businesses - Ad is viewable</option>  

                <option value="-1">Paid Businesses - Ad is Not viewable</option>  

            </select>

          <?php }else {?> 

              <select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">

              <?php if($activestatus==1){?>     

              <option value="-<?php echo $paymentstatus?>">Not Viewable - Disable public view of ads</option> 

              <?php  } ?>

               <?php if($activestatus==2){?>      

              <option value="<?php echo $paymentstatus?>">Viewable - Enable public view of ads</option> 

              <?php  } ?>

              <?php /*?><?php if($paymentstatus == 1){?>      

                <option value="2">Active Trial Businesses - Ad is viewable</option>   

              <?php } else if($paymentstatus == 2 ){  ?>        

                <option value="1">Active Paid Businesses - Ad is viewable</option>  

              <?php } else if($paymentstatus == 3){ ?>         

                <option value="2">Active Trial Businesses - Ad is viewable</option>

                <option value="1">Active Paid Businesses - Ad is viewable</option>  

             <?php } ?><?php */?>

             <?php if($paymentstatus==2){?>

          <?php }else {?>

             <option value="2">Free Trial Businesses - Ad is viewable</option>

             <?php }if($paymentstatus==1){?>

             <?php }else{?>

             <option value="1">Paid Businesses - Ad is viewable</option>  

             <?php } ?>

              </select>

         <?php } ?>

          

          

          <?php /*?><?php if($typeofadds == 1){ // for temp ads?>

        <?php if($typeofbusinesses == 0 || $typeofbusinesses == 1 || $typeofbusinesses == 2){?>

              <select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">

              <?php if($activestatus == 1){?>

          <?php if($typeofbusinesses != 2){ ?>

                        <option value="-3">Deactivate - Disable public view of ads</option>

                    <?php }else{ 

                            if($paymentstatus == 2){ ?>

                                <option value="-2">Deactivate - Disable public view of ads</option>

                        <?php }else if($paymentstatus == 1){ ?> 

                                <option value="-1">Deactivate - Disable public view of ads</option>

                        <?php } ?>    

                    <?php } ?>    

                    <?php if($paymentstatus == 3){?>

                        <option value="2">Active Trial Businesses - Ad is viewable</option>

                        <option value="1">Active Paid Businesses - Ad is viewable</option>

                    <?php }else if($paymentstatus == 2){ ?>

                        <option value="3">Active uploaded Businesses - Ad is viewable</option>

                        <option value="1">Active Paid Businesses - Ad is viewable</option>

                    <?php }else if($paymentstatus == 1){ ?>

                        <option value="3">Active uploaded Businesses - Ad is viewable</option>

                        <option value="2">Active trial Businesses - Ad is viewable</option>

                    <?php } ?>  

                <?php }else{ ?>

                <?php if($typeofbusinesses != 2){ ?>

                        <option value="3">Active uploaded Businesses - Ad is viewable</option>

                    <?php }else{ 

                            if($paymentstatus == 2){ ?>

                                <option value="2">Active uploaded Businesses - Ad is viewable</option>

                        <?php }else if($paymentstatus == 1){ ?> 

                                <option value="1">Active uploaded Businesses - Ad is viewable</option>

                        <?php } ?>    

                    <?php } ?> 

                     

                <?php if($paymentstatus == 3){?>

                    <option value="2">Active Trial Businesses - Ad is viewable</option>

                    <option value="1">Active Paid Businesses - Ad is viewable</option>

                <?php }else if($paymentstatus == 2){ ?>

                    <option value="3">Active uploaded Businesses - Ad is viewable</option>

                    <option value="1">Active Paid Businesses - Ad is viewable</option>

                <?php }else if($paymentstatus == 1){ ?>

                    <option value="3">Active uploaded Businesses - Ad is viewable</option>

                    <option value="2">Active trial Businesses - Ad is viewable</option>

                <?php } ?> 

                <?php } ?>

                <?php } ?>

           </select>             

              <?php } else if($typeofadds== 2){?>

          <?php if($typeofbusinesses == 2){?>

                      <select name="change_business_status" id="change_business_status" class="w_285 select_style_sm">

                      <?php if($activestatus == 1){?>

                          <option value="-2">Deactivate - Disable public view of ads</option>

                        <?php if($paymentstatus == 2){ ?>

                          <option value="1">Active Paid Businesses - Ad is viewable</option>

                        <?php }else if($paymentstatus == 1){ ?>

                          <option value="2">Active trial Businesses - Ad is viewable</option>

                        <?php } ?>   

                        <?php }else{ ?> 

                             <option value="3">Active uploaded Businesses - Ad is viewable</option>

                        <?php if($paymentstatus == 2){ ?>

                          <option value="1">Active Paid Businesses - Ad is viewable</option>

                        <?php }else if($paymentstatus == 1){ ?>

                          <option value="2">Active trial Businesses - Ad is viewable</option>

                        <?php } ?> 

                        <?php } ?>

                        </select>

                    <?php } ?>

                <?php } ?><?php */?>

              

              <!--<option value="3">Active Upload Businesses - Ad is viewable</option>

           </select>-->

          <select name="business_delete_all_or_specific" id="business_delete_all_or_specific" class="w_215 select_style_sm">

            <option value="1">Selected Businesses</option>

            <option value="2" style="display:none" id="status_all">All Businesses</option>

          </select>

          <select name="action_performed_in_where" id="action_performed_in_where" class="w_215 select_style_sm" style="display:none;">

            <option value="0">Current Zone</option>

          <!--  <option value="1" disabled="disabled">All Zones</option>-->

          </select> 

          <?php if(isset($all_zone_business) && $all_zone_business == ''){ ?>

          <button class="btn-sm"  id="update_non_temp_business" type="button" data-typeofadds="<?=$typeofadds?>" data-paymentstatus="<?=$paymentstatus?>" data-activestatus="<?=$activestatus?>" data-businessmode="<?=$businessmode?>" data-zoneid="<?=$zoneid?>" data-typeofbusinesses="<?=$typeofbusinesses?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-busid="<?=$busid?>" data-businesszone="<?=$business_zone?>">Update</button>

          <?php } ?>

          <?php if(isset($all_zone_business) && $all_zone_business != ''){ ?>

            <button class="btn-sm"  id="add_to_my_zone" type="button" data-zoneid="<?=$zoneid?>" data-typeofbusinesses="<?=$typeofbusinesses?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-busid="<?=$busid?>" data-businesszone="<?=$business_zone?>">Add to my zone</button>    

           <?php }else if(isset($all_zone_business) && $all_zone_business == ''){ ?>

            <button class="btn-sm"  id="delete_from_my_zone" type="button" data-zoneid="<?=$zoneid?>" data-typeofbusinesses="<?=$typeofbusinesses?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-busid="<?=$busid?>" data-businesszone="<?=$business_zone?>">Delete from my zone</button>

           <?php } ?>

        </div></td>

    </tr>

    <?php } ?>

    

  <?php foreach($non_temp_business_in_zone as $key1=>$business){

    $business_status = '';

    $trial_remaining = '';

    if(isset($business['approval'])){

      if($business['approval'] == 1){

        $business_status = 'Viewable Paid' ;

      }else if($business['approval'] == -1){

        $business_status = 'Not Viewable Paid' ;

      }else if($business['approval'] == 2){

        /*$totaldayssecond = (($trial_business_active != 0) ? $trial_business_active : 0) * 86400 ;

        $starttimestamp = isset($business['trialstarted']) ? $business['trialstarted'] : 0 ;

        $totaldaystimestamp = $totaldayssecond + $starttimestamp ;

        $currenttimestamp = time() ;

        if($currenttimestamp < $totaldaystimestamp){

          $numDays = floor(abs($totaldaystimestamp - $currenttimestamp)/60/60/24);

          if($numDays != '' && $numDays != 0){

            $trial_remaining =  '<br>('.$numDays.' days Remaining)' ;

          }

        }*/

        

        $business_status = 'Viewable Free Trial'.$trial_remaining ;

      }else if($business['approval'] == -2){    

        $business_status = ' Not Viewable Free Trial' ;

      }else if($business['approval'] == 3){

        $business_status = 'Not Viewable, Businesses Uploaded' ;

      }else if($business['approval'] == -3){  

        $business_status = 'Not Viewable, Businesses Uploaded' ;

      }else if($business['approval'] == 0){

        $business_status = 'Waiting For Approval' ;

      }

    }

    

  //echo $key_count=($key1)%2;

  $key_count=($key1)%2;

  if($key_count==0){

    $displaytableview_class='displaytableview_odd';

  }else if($key_count==1){

    $displaytableview_class=='displaytableview_even';

  } 


$adsapprovalclass= 'inactiveClass';
if(@$business['adsapproval'] == 1){
   $adsapprovalclass= 'activeClass';
}else if(@$business['adsapproval'] == -1){
$adsapprovalclass= 'inactiveClass';
}else{
$adsapprovalclass= 'noadClass';

}


  ?>

    <tr id="<?=$business['businessid']?>" class="uploadbusiness <?=$displaytableview_class?>" >

      <td style="text-align:justify;" width="10%"><b>

        <?=urldecode($business['id'])?>

        </b><br/>

      </td>

     

      <td width="15%"><b>

        <?=urldecode(stripslashes($business['name']))?>

        </b><br/>

        <?php /*?><button class="m_left_100" style="background-color:#859731">Go To <b>

        <?=$business['name']?>

        </b> Dashboard</button><?php */?>

        

        </td>

        <td width="20%" class="samestatus" data-samestatus="<?php echo $business['approval']; ?>"><b>

        <?=$business_status?>

        </b><br/>

        </td>

      <td width="20%"><?=urldecode(stripslashes($business['first_name']))?>&nbsp;<?=urldecode(stripslashes($business['last_name']))?></td>

        

      <td width="10">

      <?=$business['phone']?> 

        <?php /*?>Activated:<?=$business['approved']?>

        <br />

        Deactivated:

        <?=$business['unapproved']?><?php */?>

        </td>

         

       <td width="10">

      

        <?=str_pad(urldecode($business['zip_code']), 5, '0', STR_PAD_LEFT)?>

       </td>
 

       <?php if(isset($all_zone_business) && $all_zone_business == ''){     ?>

        <td  width="30%">        

        <a target="_blank" href="<?=base_url()?>businessdashboard/viewad/<?=$business['id']?>/<?=$zoneid?>" title="Go to this Business AD profile." class="editlinks_link <?php echo $adsapprovalclass ?>  linkadvertisemnt link-underlined text-default"><b> AD</b></a> 

        <a class="link-underlined text-default edit_business editlinks_link edit_linksbusiness   "  title="Edit Business contact info." href="javascript:void(0)" id="edit_business" rel="<?=$business['id']?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>"  title="Edit <?=stripslashes($business['name'])?> Business"><i class="fa fa-id-card" aria-hidden="true"></i></a> 

         <a href="javascript:void(0)" data-busid="<?=$business['id']?>"  class="editlinks_link trashlink"><i class="fa fa-trash" aria-hidden="true"></i></a>

        </td>

        <?php } ?> 

      <td  width="10%"><input type="checkbox" name="checkadfordelete" id="individual_checkbox_business" class="display_checkbox1 <?=$business_type_by_category?>" value="<?=$business['businessid']?>" data-businesstype="<?=$business_type?>"  data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>"/></td>

 

    
    </tr>

    <?php $displaytableview_class=''; } ?>

   <?php if($lowerLimit <= 10){ ?>

  </tbody>

</table>

<?php } ?>

<?php /*?><?php if($count_non_temp_business_in_zone>2){?><?php */?>

<div class="display_more_business" style="float: right; display: none;">
  <a class="more_non_temp_business" style=" color:#000;" href="javascript:void(0)" rel="0,0" data-zoneid="<?=$zoneid?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>" data-charvalname="<?=$charval_name?>" data-charvalalphabet="<?=$charval_alphabet?>">
    <strong>Display more businesses</strong>
  </a> 
  </div>

<?php 
 
 $totalbus = count($totalbus);
  $limit = 10;
 $total_pages = $totalbus / $limit;  

?>

<div class="clearfix">             
          <ul class="pagination">
                    <?php 
                      if(!empty($total_pages)){
                        for($i=1; $i<=$total_pages; $i++){
                            if($i == 1){
                              ?>
                            <li class="pageitem active" id="<?php echo $i;?>"><a href="javascript:void(0)" data-lower="1" data-upper="<?php echo $i*$limit;?>" class="more_non_temp_business" data-zoneid="<?=$zoneid?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>" data-charvalname="<?=$charval_name?>" data-charvalalphabet="<?=$charval_alphabet?>" ><?php echo $i;?></a></li>
                                          
                            <?php 
                            }
                            else{
                              ?>
                            <li class="pageitem" id="<?php echo $i;?>"><a href="javascript:void(0)"  class="more_non_temp_business" data-lower="<?php echo $i*$limit-$limit;?>" data-upper="<?php echo $i*$limit;?>" data-zoneid="<?=$zoneid?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>" data-charvalname="<?=$charval_name?>" data-charvalalphabet="<?=$charval_alphabet?>" ><?php echo $i;?></a></li>

                            <?php
                            }
                        }
                      }
                ?>
          </ul>
            </div>


<?php /*?><?php } ?><?php */?>

 <?php } else{ ?>

    <div class="container_tab_header" id="not_found" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Businesses are Found</div>

    <?php } ?>

  

    <script type="text/javascript">

  $(document).ready(function () {

    $('#action_performed').change(function() {   // available all business drop down only for delete

      if ($(this).val() == 3) {

        $('#status_all').show();

      } else {

        $('#business_delete_all_or_specific>option:eq(0)').attr('selected', true);

        $('#status_all').hide();

     }

    });



    $(".display_checkbox1 ").click(function(){

        //alert(1233435);

        //var business = $(this).val();

        //alert(business);       

    });



    $("#add_to_my_zone").click(function(){

      var business = [];

      $.each($("input[name='checkadfordelete']:checked"), function(){            

        business.push($(this).val());

      });     

      var data={businessid:business,zoneId:<?=$zoneid?>}

      PageMethod("<?=base_url('Zonedashboard/add_business_to_zone')?>", "Action Performed...", data, addBusinessSuccess, null);

    });



    $("#delete_from_my_zone").click(function(){   

      var business = [];

      $.each($("input[name='checkadfordelete']:checked"), function(){            

        business.push($(this).val());

      });    

      var data={businessid:business,zoneId:<?=$zoneid?>}

      PageMethod("<?=base_url('Zonedashboard/delete_business_from_zone')?>", "Action Performed...", data, deleteBusinessSuccess, null);

    });



    function addBusinessSuccess(result){  

      $.unblockUI();

      if(result.Tag!=''){

        $('input:checkbox[name=checkadfordelete]').attr('checked',false);

        $(".success").show();

      }

    }



    function deleteBusinessSuccess(result){ //alert(111111);

      $.unblockUI();

      if(result.Tag!=''){        

        $('#search_business').click();

        $(".success").show();

      }

    }



  });


  $totalbus = '<?php echo $totalbus ?>';

 
   if($totalbus >= 10){

  $('.pagination').paginate({
  perPage: 10,   
  useHashLocation: false        
});

   }


</script>