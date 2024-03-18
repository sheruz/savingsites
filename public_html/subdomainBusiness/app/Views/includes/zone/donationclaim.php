<?php //echo '<pre>'; var_dump($delete_cat_byindustry);exit; ?>

<input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>

<input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>

<div class="main_content_outer">   

<div class="content_container">

<?php if($common['from_zoneid']!='0'){?>

<div class="spacer"></div>

  <div class="businessname-heading ggg">

      <div class="main main-large main-100">

          <div class="businessname-heading-main">

            <?php if($common['businessid']!='') {  //var_dump($common['approval_message']);exit;?> 

            <font color="#333333">Business Name : </font> 

            <?php } 

            if($common['realtorid']!='') {  //var_dump($common['approval_message']);exit;?> 

            Realtor : 

            <?php } 

            if($common['organizationid']!=''){?> 

              Organization : 

            <?php } ?>  

      <?php

       echo urldecode($common['sub_header_name_from_zone']['name']);

       if($common['organizationid']!=''){

       ?> (<?php

        if($common['zone'][0]['type'] == 0){ ?>Others<?php }else if($common['zone'][0]['type'] == 1){ ?>Municipality<?php }else if($common['zone'][0]['type'] == 2){ ?>Schools<?php }else{ ?>High School Sports<?php } ?>)

            <?php }if($common['businessid']!='') { ?><?=' '.$common['approval_message']?> <?php } ?>

              <a href="<?=base_url()?>Zonedashboard/zonedetail/<?=$common['from_zoneid']?>/0/1" class="fright" style="text-decoration:none">&#8592; Back to Zone Dashboard</a><br/>

                <?php 

        $x = $this->session->userdata('business_search_value'); ?>

     
       

         

            </div>

        </div>

    </div>

<?php } 

if($common['where_from']=='zone'){?>

  <div class="spacer"></div>

    <div class="businessname-heading fff" style="overflow:hidden;">

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




	<div class="container_tab_header">Enter the Organisation Fee</div>

	<div id="container_tab_content" class="container_tab_content bv_create_bussines">
 
        <div id="tabs-1_x" class="form-group">

        	<div class="form-group ">
 
                <div id="msg"></div>

                <div class="container_tab_header failure" style="background-color:#d01b13; display:none;">Sorry! Try Again Later.</div>

                <div class="page-subheading">Organisation Fee in percentage   <?php if($payment_creditprice){ ?> : <?php echo $payment_creditprice ?>% <?php } ?></div>

                <form id="credittobusiness" class="form-validate" name="" method="post" action="">
 
                 <p>
                   <label>Enter the percentage value</label>
                   <input type="text" name="price">
                   <input type="submit" name="submit" class="submitprice" value="Update">
                 </p>     

                   

              	</form>

              </div>



        </div>

        

        

    </div>

    

    

</div>



</div>

 



<script type="text/javascript">

$(document).ready(function () {
 $('#zone_business_accordian').click();

    $('#business_data_accordian').click();
    
    $('#adv_tools').click();

    $('#adv_tools').next().slideDown();


  $('#organizationfee').addClass('active');
 
  var zone_id =  "<?php echo $zoneId; ?>";




  $('.submitprice').click(function(e){
         e.preventDefault();
     $formData =  $("#credittobusiness").serialize();
      
      $.ajax({
          url: '<?=base_url('/Zonedashboard/updateClaimfee')?>',
          type: 'POST',
          dataType:'json', 
          data: ({ zoneID:'<?php echo $zoneId; ?>' , 'form': $formData }),
          success: function(data) {            
             location.reload();

          }

        }); 

  });

});






 </script>