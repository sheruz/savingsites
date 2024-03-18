<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
<div class="content_container content_webiner_information"> 
<div class="container jotfrom_container" id="jotfrom_upload_form">
<div class="content_container">
<?php if($common['from_zoneid']!='0'){?>
<div class="spacer"></div>

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
      <div class="top-title">
        <h2>Embed Jot Form</h2>
         <hr class="center-diamond">
      </div>
<div class="container_tab_content ui-widget-content">
  <div class="row">
    <div class="col-md-6">
      <img src="/assets/images/payment_wraper.jpg" style="width: 100%;">
    </div>
    <div class="col-md-6">
          <form class="form-horizontal">
        <div class="form-group center-block-table">
            <p class="form-group-row">
            <label for="sel1" class="fleft w_200">Select list (select one):</label>
            <select class="form-control" id="sel1">
             <?php foreach ($jotform_category_data['form_codes'] as $category) { ?>
                <option value="<?= $category['payment_module_id'] ?>"><?= $category['payment_form_type'] ?></option> 
           <?php   } ?>
                
            </select>
        </p>
        </div>
        <div class="form-group center-block-table text_area_to_save_code" data-category="<?//= $category['id']; ?>" >
            <p class="form-group-row">
            <label for="comment" class="fleft w_200">Payment Form Code:</label>
            <textarea  rows="18" cols="100" class="form-control" id="embed_code" name="codes_details" class="embed_codes" value="<?//= $codes; ?>"><?//= $codes; ?></textarea>
        </p>
        </div>
        <?php //} ?>

        <div class="form-group center-block-table" style="text-align: center;
    margin-top: 20px;" id="submit_code">
            <div class="col-sm-offset-2 col-sm-12">
                <button  id="submit_code_button" class="">Save</button>
            </div>
        </div>
    </form>
    </div>
  </div>

</div>
    </div>
</div>
</div>
<script type="text/javascript">
// $('div.text_area_to_save_code').not(':eq(0)').hide();
// 	$(document).ready(function(){
// 		$("#zone_data_accordian").click();
// 		$("#zone_data_accordian").next().slideDown();
// 		$('#jotform').click();
// 		$('#jotform').next().slideDown();
// 		$('#upload_jot_form').addClass('active');
        
//         $("#sel1").change(function(){
//            var category_type_id = $(this).val();
//            dynamically_show_hide_div(category_type_id);

//         });
//         $("#submit_code_button").click(function(event){
//             event.preventDefault();
//             var zone_id ="<?= $zoneid; ?>";
//             var category_id = $("#sel1").val();
//             var code_value = $('div[data-category="'+category_id+'"]').find('textarea').val();
//             var dataToUse = {'form_type_id':category_id,'codes':code_value,zone_id:zone_id};
//             PageMethod("<?=base_url('Zonedashboard/updatejotformcodes')?>", "Processing...<br/>This may take a minute.", dataToUse,updateStatus, null);
//         });

// 	});
//     function updateStatus(response){
//         $.unblockUI();
        
//     }
//     function dynamically_show_hide_div(category_type_id) {
//         $(".text_area_to_save_code").hide();
//         $('div[data-category="'+category_type_id+'"]').show();

//     }
</script>