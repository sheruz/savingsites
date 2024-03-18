 <style type="text/css">
 	.paid{
 		display: inline-block;
    width: 100%;
 	}
  div.dataTables_wrapper{
    background-color: #fff;
  }
  .dataTables_wrapper table.dataTable thead .sorting_asc{
    background-image:none!important;
  }
 </style>

<script type="text/javascript">
 

function save_other_referral(){
 
		var dataToUse = {

		"zoneid":$("#zoneid").val(),

    "hugegroup_referralid":$('#hugegroup_referralid').val(),

    "emailing_referralid":$('#emailing_referralid').val(),

    "usagroup_referralid":$('#usagroup_referralid').val()

		}; 

 

  PageMethod("<?=base_url('Zonedashboard/save_others_website_id')?>", "Processing...<br/>This may take a minute.", dataToUse, weblinkSuccess, null);

}



function weblinkSuccess(result){

	$.unblockUI();

	var message = result.Message;

	var title = result.Title;

	var txt = '';

	  $("#msg").html(txt).show();

	  $("#msg").show();

	  $("#webinar_link").val('');

	  $("#description").val('');

	  $('html,body').animate({scrollTop:0},"slow");

	  setTimeout(function(){$("#msg").hide('slow');},3000);

}

</script>
 

<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />

<input type="hidden" name="zoneid" id= "business_id" value="<?= $common['businessid']?>">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">


<?php 

$condition_1 = $common['approval']['approval'] ;  // Represents the approval status of the business

$condition_2 = $common['usergroup']->group_id ;	  // Represents the user group id--> for zone_owner -> 4 ;for business_owner -> 5	

	

 

if(($condition_1==1 || $condition_1==2 || $condition_1==3) || ($condition_2==4)){

?>



<div class="content_container">

				 <?php if($common['from_zoneid']!='0'){ ?>

<div class="spacer"></div>

  <div class="businessname-heading">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <?php if($common['businessid']!='') {  ?> 

            <div style="float:left;"><font color="">Business Name : </font> <div class="oswald" style="font-size:26px; line-height:initial;">

      <?php } ?>  

             <?php if($common['realtorid']!='') {   ?> 

            Realtor : 

      <?php } ?>  

            
 

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
 

            <?php if($common['from_zoneid']!=0 && $common['businessid']!=''){ ?>

            <br>
 
 

         <?php 

          } ?>

            </div>

        </div>

    </div>

<?php } 

if($common['where_from']=='zone'){?>

  <div class="spacer"></div>

    <div class="businessname-heading" style="overflow:hidden;">

 

        <div id="view_global_bus_search_div" style="width:1130px; margin:10px auto 0; background-color:#d2e08f; display:none; overflow:hidden; padding:10px;">

            <div id="view_global_bus_search" class="fleft" style="width:1080px;"></div>

            <a style="margin:-10px 20px 0 0;" href="javascript:void(0)" class="close" onClick="$('#view_global_bus_search_div').slideToggle();"><img src="<?=base_url('assets/images/close_pop.png') ?>" class="btn_close global_search_close" title="Close Window" alt="Close" ></a>

      </div>

    </div>



<?php } ?>



	<div class="container_tab_header">All Referral Users</div>

    <div id="msg"></div>
 

	<div id="container_tab_content" class="container_tab_content">

        <div id="tabs-2_y">

        	<div id="msg" style="display:none;margin-top:7px;"></div>

   <div class="pretty_new_col">                  
<table class="pretty all_business_show_table" border="0" cellpadding="0" cellspacing="0">
  <thead id="showhead" class="headerclass">
    <tr>
      <th width="20%">User Name</th>
      <th width="15%">Email</th>
      <th width="15%"> Name </th>
       <th width="15%"> Referrer Code  </th>
     
    </tr>
  </thead>
  <tbody>
   
        <?php 
        foreach($referaldata as $referal_data){  ?>
         <tr  class="uploadbusiness displaytableview_odd">

          <td style="text-align:justify;" width="10%"><b><?php echo $referal_data['username']  ?></b><br></td>     
           <td width="15%"><b>       <?php echo $referal_data['email']  ?></b><br></td>
           <td width="15%"><b>       <?php echo $referal_data['first_name'].' '.$referal_data['last_name']   ?></b></td>
     <td width="15%"><b>       <?php echo $referal_data['referral_code']  ?></b><br></td>
       
      </tr>

        <?php   } ?>
     
       
       
        
        
        
        
        
        
         </tbody>
</table>
</div>

        </div>

    	</div>

    </div>

</div>



 <?php }else if(($condition_1==-1 || $condition_1==-2 || $condition_1==-3) || $condition_2==5){ ?>

<div class="main_content_outer"> 

<div class="content_container">

				 <?php if($common['from_zoneid']!='0'){?>

<div class="spacer"></div>

  <div class="businessname-heading">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <?php if($common['businessid']!='') {   ?> 

            <div style="float:left;"><font color="">Business Name : </font> <div class="oswald" style="font-size:26px; line-height:initial;">

      <?php } ?>  

             <?php if($common['realtorid']!='') {    ?> 

            Realtor : 

      <?php } ?>  

            
  

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

if($common['where_from']=='zone'){ ?>

  <div class="spacer"></div>

    <div class="businessname-heading" style="overflow:hidden;">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <div class="center" style="width:100%">

             <font style="">Search All Businesses (Real Active Ads, Businesses Uploaded, Biz Opp Providers, Inactive Ads)</font> 

            <input type="text" id="global_bus_search" name="global_bus_search" class="text-input" placeholder="Exact business name or phone no. or id" style="" value="<?php echo $this->session->userdata('business_search_value') ?>" />

            <button class="btn-sm"  id="global_bus_search_btn" type="button" style="">Search</button>

          

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

	<div class="container_tab_header">Enter Webinar Information</div>

    <div style="font-size:20px; line-height:25px; color:red;">Your business is currently inactive. Please contact your Directory Manager for more details.

        	</div>

     </div>

  </div>

     <?php } ?>


 
<script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>
 


 <script type="text/javascript">

$(document).ready(function () {  
 
    $('.all_business_show_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
              'csv' 
        ]
    });
 
 

  $('#zone_data_other_accordian').click();

  $('#zone_data_other_accordian').next().slideDown();

  $('#zone_data_other_accordian').addClass('active');

  $("#referral").addClass('active');

 
 

});



</script>