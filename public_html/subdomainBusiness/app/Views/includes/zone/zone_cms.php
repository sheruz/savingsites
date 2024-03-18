<div class="main_content_outer">   

<div class="content_container">

<?php //echo"<pre>";print_r($get_zone_cms);?>

    <div class="container_tab_header">Zone Cms Creation</div>

    <div id="container_tab_content" class="container_tab_content">

       

        <div id="tabs-1_x" class="form-group">

            <div class="form-group ">

                <!--<div class="container_tab_header success" style="background-color:#859731; display:none;"><strong>You have successfully created the business.</strong></div>-->

                <div id="msg"></div>

                <div class="container_tab_header failure" style="background-color:#d01b13; display:none;">Sorry! Try Again Later.</div>

                <div id="show_succ_msg" style="margin-bottom: 10px;"></div>

                <div class="page-subheading">Cms Left Panel</div>

                <form id="create_business_form" class="form-validate vc_business_form" name="create_business" method="post" action="" onsubmit="save_banner()">

                    <input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>

                    

                    <div class="spacer"></div>

                    <p class="form-group-row">

                      <label for="email" class="fleft w_200">Top Position</label>

                      

                      <input type="text" id="leftpanel_text1_name" name="leftpanel_text1_name" class="w_536"  value="<?=(!empty($get_zone_cms['left_panel_first_text']) ? $get_zone_cms['left_panel_first_text'] : 'Huge Savings from Local Businesses!')?>"/>

                      <div id="error_contact_name"></div>

                    </p>



                    <div class="spacer"></div>

                    <p class="form-group-row">

                        <div class="cus-bg-color bv_bg_col">

							<span>

								<span class="bv_best_result">For best results upload a 20 pixel wide x 20 pixel high image</span>

							</span>

						</div><br>



                        <div id="uplodImage">

                        <label for="email" class="fleft w_200 bv_top_logo">Top Position Logo</label>

                            <input type="file" id="lefttop" onchange="ajaxFileUpload('lefttop|leftpanel_firstlogo_urllink|remove_toplogo_img|show_banner_lefttop|left_panel_first_logo');"  name="imgfile" value="" />

                            <input type="hidden" name="uploadedInput_lefttop" id="uploadedInput_lefttop" value="<?=!empty($get_zone_cms['left_panel_first_logo']) ? $get_zone_cms['left_panel_first_logo'] : ''?>" />

                            <input type="hidden" name="logo_position" value="lefttop" />

                            <input type="hidden" name="folder_name_lefttop" id="folder_name_lefttop" value="" />

                            <span style="display:none;right: 240px;" id="spinner_lefttop"><img src="https://cdn.savingssites.com/loading.gif"></span>

                            

                            <!--<p id="uploading">(Please select a file(1526px*471px) to upload)</p>-->

                        </div>



                      <div id="error_contact_name"></div>

                    </p>



                    <div class="form-group-row">

                      <label for="email" class="fleft w_200">Logo Preview</label>

                        <div id="show_banner_lefttop" style="float: left;">

                            <?php if(!empty($get_zone_cms['left_panel_first_logo'])): ?>

                                <img src="<?=base_url();?>/uploads/zone_logo/<?=$zoneid?>/normal_image/<?=$get_zone_cms['left_panel_first_logo'];?>"

                                    >

                           

                            <a class="remove_img" id="remove_toplogo_img" data-id="show_banner_lefttop" data-img="left_panel_first_logo" style="margin-left: 10px;" href="jascript:void(0);">Remove</a>

                            <?php endif; ?>

                        </div>

                        

                      

                    </div>



                    <div class="form-group-row" id="leftpanel_firstlogo_urllink" style="<?=!empty($get_zone_cms['left_panel_first_logo']) ? : 'display:none;'?>">

                        <label for="email" class="fleft w_200">Logo Url Link</label>

                        <input type="text" id="leftpanel_firstlogourl_link" name="leftpanel_firstlogourl_link" class="w_536"  

                        value="<?=!empty($get_zone_cms['leftpanel_firstlogourl_link']) ? $get_zone_cms['leftpanel_firstlogourl_link'] : ''?>"/>
                        <br>

                        <span class="sub_line_text bv_url_new">(Please use http:// or www before on url Link) </span>

                    </div>



                    <hr>

                    



                    <div class="spacer"></div>

                    <p class="form-group-row">

                      <label for="email" class="fleft w_200">Bottom Position</label>

                      

                      <input type="text" id="leftpanel_text2_name" name="leftpanel_text2_name" class="w_536"  value="<?=(!empty($get_zone_cms['left_panel_second_text']) ? $get_zone_cms['left_panel_second_text'] : 'Timely and Targeted Info and Events!')?>"/>

                      <div id="error_contact_name"></div>

                    </p>



                    <div class="spacer"></div>

                    <p class="form-group-row">

                        <div class="cus-bg-color bv_bg_col">

							<span>

								<span class="bv_best_result">For best results upload a 20 pixel wide x 20 pixel high image</span>

							</span>

						</div><br>



                        <div id="uplodImage">

                        <label for="email" class="fleft w_200 bv_top_logo">Top Position Logo</label>

                            <input type="file" id="leftbottom" onchange="ajaxFileUpload('leftbottom|leftpanel_secondlogo_urllink|remove_bottomlogo_img|show_banner_leftbottom|left_panel_second_logo');"  name="imgfile" value="" />

                            <input type="hidden" name="uploadedInput_leftbottom" id="uploadedInput_leftbottom" value="<?=!empty($get_zone_cms['left_panel_second_logo']) ? $get_zone_cms['left_panel_second_logo'] : ''?>" />

                            <input type="hidden" name="logo_position" value="leftbottom" />

                            <input type="hidden" name="folder_name_leftbottom" id="folder_name_leftbottom" value="" />

                            <span style="display:none;right: 240px;" id="spinner_leftbottom"><img src="https://cdn.savingssites.com/loading.gif"></span>

                            

                            <!--<p id="uploading">(Please select a file(1526px*471px) to upload)</p>-->

                        </div>



                      <div id="error_contact_name"></div>

                    </p>



                    <div class="form-group-row">

                      <label for="email" class="fleft w_200">Logo Preview</label>

                        <div id="show_banner_leftbottom" style="float: left;">

                             <?php if(!empty($get_zone_cms['left_panel_second_logo'])): ?>

                                <img src="<?=base_url();?>/uploads/zone_logo/<?=$zoneid?>/normal_image/<?=$get_zone_cms['left_panel_second_logo'];?>"

                                 >

                            

                            <a class="remove_img" id="remove_bottomlogo_img" data-img="left_panel_second_logo" data-id="show_banner_leftbottom" style="margin-left: 10px;" href="jascript:void(0);">Remove</a>    

                            <?php endif; ?>

                        </div>

                        

                      

                    </div>



                    <div class="form-group-row" id="leftpanel_secondlogo_urllink" style="<?=!empty($get_zone_cms['left_panel_second_logo']) ? : 'display:none;'?>">

                        <label for="email" class="fleft w_200">Logo Url Link</label>

                        <input type="text" id="leftpanel_secondlogourl_link" name="leftpanel_secondlogourl_link" class="w_536"  

                        value="<?=!empty($get_zone_cms['leftpanel_secondlogourl_link']) ? $get_zone_cms['leftpanel_secondlogourl_link'] : ''?>"/>
                        <br>

                        <span class="sub_line_text bv_url_new">(Please use http:// or www before on url Link)</span>

                    </div>

                    

                    <!-- <span id="error_pname" style="margin:0px 85px 8px 0; background:#F00; font-weight:bold; color:#fff; padding:3px; width:550px; display:block; text-align:center; display:none; float:right"></span> <span id="success_pname" style="font-weight:bold; color:#fff; margin:0 0 0 232px; background:#063; padding:3px; width:550px; display:block; text-align:center;display:none"></span> -->

                    

                    <div class="spacer"></div>

                    <div class="page-subheading" style="padding-top:15px;">Cms Right Panel</div>



                    <div class="spacer"></div>

                    <p class="form-group-row">

                      <label for="email" class="fleft w_200">Top Position</label>

                      

                      <input type="text" id="rightpanel_text1_name" name="rightpanel_text1_name" class="w_536"  value="<?=(!empty($get_zone_cms['right_panel_first_text']) ? $get_zone_cms['right_panel_first_text'] : 'Supports Your Favorite Organization!')?>"/>

                      <div id="error_contact_name"></div>

                    </p>



                    <div class="spacer"></div>

                    <p class="form-group-row">

                        <div class="cus-bg-color bv_bg_col">

							<span>

								<span class="bv_best_result">For best results upload a 20 pixel wide x 20 pixel high image</span>

							</span>

						</div><br>

                        <div id="uplodImage">

                        <label for="email" class="fleft w_200 bv_top_logo">Top Position Logo</label>

                            <input type="file" id="righttop" onchange="ajaxFileUpload('righttop|rightpanel_firstlogo_urllink|remove_righttoplogo_img|show_banner_righttop|right_panel_first_logo');"  name="imgfile" value="" />

                            <input type="hidden" name="uploadedInput_righttop" id="uploadedInput_righttop" value="<?=!empty($get_zone_cms['right_panel_first_logo']) ? $get_zone_cms['right_panel_first_logo'] : ''?>" />

                            <input type="hidden" name="logo_position" value="righttop" />

                            <input type="hidden" name="folder_name_righttop" id="folder_name_righttop" value="" />

                            <span style="display:none;right: 240px;" id="spinner_righttop"><img src="<?php echo base_url() ?>assets/images/loading.gif"></span>

                            

                            <!--<p id="uploading">(Please select a file(1526px*471px) to upload)</p>-->

                        </div>



                      <div id="error_contact_name"></div>

                    </p>



                    <div class="form-group-row">

                      <label for="email" class="fleft w_200">Logo Preview</label>

                        <div id="show_banner_righttop" style="float: left;">

                            <?php if(!empty($get_zone_cms['right_panel_first_logo'])): ?>

                                <img src="<?=base_url();?>/uploads/zone_logo/<?=$zoneid?>/normal_image/<?=$get_zone_cms['right_panel_first_logo'];?>"

                                 >

                            

                            <a class="remove_img" data-id="show_banner_righttop" data-img="right_panel_first_logo" style="margin-left: 10px;" id="remove_righttoplogo_img" href="jascript:void(0);">Remove</a>

                            <?php endif; ?>

                        </div>

                        

                      

                    </div>



                    <div class="form-group-row" id="rightpanel_firstlogo_urllink" style="<?=!empty($get_zone_cms['right_panel_first_logo']) ? : 'display:none;'?>">

                        <label for="email" class="fleft w_200">Logo Url Link</label>

                        <input type="text" id="rightpanel_firstlogourl_link" name="rightpanel_firstlogourl_link" class="w_536"  

                        value="<?=!empty($get_zone_cms['rightpanel_firstlogourl_link']) ? $get_zone_cms['rightpanel_firstlogourl_link'] : ''?>"/>
                        <br>

                        <span class="sub_line_text bv_url_new">(Please use http:// or www before on url Link)</span> 

                    </div>



                    <hr>



                    <div class="spacer"></div>

                    <p class="form-group-row">

                      <label for="email" class="fleft w_200">Bottom Position</label>

                      

                      <input type="text" id="rightpane2_text2_name" name="rightpane2_text2_name" class="w_536"  value="<?=(!empty($get_zone_cms['right_panel_second_text']) ? $get_zone_cms['right_panel_second_text'] : 'We Help Municipality Protect Your Data!')?>"/>

                      <div id="error_contact_name"></div>

                    </p>

                    

                    <div class="spacer"></div>

                    <p class="form-group-row">

                        <div class="cus-bg-color bv_bg_col">

							<span>

								<span class="bv_best_result">For best results upload a 20 pixel wide x 20 pixel high image</span>

							</span>

						</div><br>

                        <div id="uplodImage">

                        <label for="email" class="fleft w_200 bv_top_logo">Top Position Logo</label>

                            <input type="file" id="rightbottom" onchange="ajaxFileUpload('rightbottom|rightpanel_secondlogo_urllink|remove_rightbottomlogo_img|show_banner_rightbottom|right_panel_second_logo');"  name="imgfile" value="" />

                            <input type="hidden" name="uploadedInput_rightbottom" id="uploadedInput_rightbottom" value="<?=!empty($get_zone_cms['right_panel_second_logo']) ? $get_zone_cms['right_panel_second_logo'] : ''?>" />

                            <input type="hidden" name="logo_position" value="rightbottom" />

                            <input type="hidden" name="folder_name_rightbottom" id="folder_name_rightbottom" value="" />

                            <span style="display:none;right: 240px;" id="spinner_rightbottom"><img src="<?php echo base_url() ?>assets/images/loading.gif"></span>

                            

                            <!--<p id="uploading">(Please select a file(1526px*471px) to upload)</p>-->

                        </div>



                      <div id="error_contact_name"></div>

                    </p>



                    <div class="form-group-row">

                      <label for="email" class="fleft w_200">Logo Preview</label>

                        <div id="show_banner_rightbottom" style="float: left;">

                            <?php if(!empty($get_zone_cms['right_panel_second_logo'])): ?>

                                <img src="<?=base_url();?>/uploads/zone_logo/<?=$zoneid?>/normal_image/<?=$get_zone_cms['right_panel_second_logo'];?>"

                                 >

                            

                            <a class="remove_img" data-id="show_banner_rightbottom" data-img="right_panel_second_logo" id="remove_rightbottomlogo_img" href="jascript:void(0);">Remove</a>

                            <?php endif; ?>

                        </div>

                        

                      

                    </div>

                         

                    <div class="form-group-row" id="rightpanel_secondlogo_urllink" style="<?=!empty($get_zone_cms['right_panel_second_logo']) ? : 'display:none;'?>">

                        <label for="email" class="fleft w_200">Logo Url Link</label>

                        <input type="text" id="rightpanel_secondlogourl_link" name="rightpanel_secondlogourl_link" class="w_536"  

                        value="<?=!empty($get_zone_cms['rightpanel_secondlogourl_link']) ? $get_zone_cms['rightpanel_secondlogourl_link'] : ''?>"/>
                        <br>

                        <span class="sub_line_text bv_url_new">(Please use http:// or www before on url Link) </span>

                    </div>



                       

                    <p class="form-group-row">

                      <label for="button_save">

                        <button class="m_left_200" type="button" id="create_zone_cms">Submit</button>

                        <!--<button id="reset" type="button">Reset</button>-->

                      </label>

                    </p>

                    <div class="spacer"></div>

                   <!-- <div class="container_tab_header success" style="background-color:#859731; display:none;">You have successfully created the business.</div>-->

                    <div class="container_tab_header failure" style="background-color:#d01b13; display:none;">Sorry! Try Again Later.</div>

                    <div class="spacer"></div>

                </form>

              </div>



        </div>

        

        

    </div>

    

    

</div>



</div>





<script type="text/javascript">



$(document).on('click','#create_zone_cms',function(){

    //alert('Test');

    var dataToUse=$('form#create_business_form').serialize();

    $.ajax({

        type:"POST",

        url:"<?=base_url('Zonedashboard/create_zonecms')?>",

        dataType:'json',

        data:dataToUse,

        success:function(data)

        {

            if(data.response == 'success')

            {

                $('#show_succ_msg').html('<span style="color:#008000;font-weight:bold;font-size: 19px;">Save Successful.</span>');

            }

        }

    });

    /*$('.form_error').hide();

    var dataToUse=$('form#create_business_form').serialize();

    PageMethod("<?=base_url('Zonedashboard/create_zonecms')?>", "Adding banner please wait ....", dataToUse, add_banner_insert, null);*/

    

});



$(document).on('click','.remove_img',function(){

    var remove_icon_id = $(this).attr('id');

    var remove_img_id = $(this).attr('data-id');

    var remove_column_name = $(this).attr('data-img');

    var zoneid = <?=$zoneid?>;

    //alert(remove_icon_id);

    //alert(remove_img_id);

    //alert(zoneid);

    //return false;

    $.ajax({

        type:"POST",

        url:'<?=base_url('Zonedashboard/zone_logo_remove')?>',

        dataType:'json',

        data:

        {

            zoneid:zoneid,

            remove_column_name:remove_column_name

        },

        success:function(response)

        {

            //alert(response.remove);

            if(response.remove == 'Exist')

            {

                $("#"+remove_icon_id).hide();

                $("#"+remove_img_id).hide();

            }

        },

    });

    return false;

})



function ajaxFileUpload(get_ids){

    //starting setting some animation when the ajax starts and completes

    var explode_ids = get_ids.split('|');



    var current_val = explode_ids[0];

    var link_url = explode_ids[1];

    var remove_icon_id = explode_ids[2];

    var remove_icon_dataid = explode_ids[3];

    var remove_icon_dataimg = explode_ids[4];

    //alert(explode_ids[0]);

    //return false;

    

	$('#spinner_'+current_val).show();

   

	 $.ajaxFileUpload(        		

	{

		type:"POST",

		url:'<?=base_url('banner_controller/save_zonecms_logo/'.$zoneid.'')?>',

		secureuri:false,

		fileElementId:current_val,

		dataType: 'json',

		success: function (data, status)

		{

			$('#spinner_'+current_val).hide();

			$('#uploadedInput_'+current_val).val(data.clientImage);

            $('#folder_name_'+current_val).val(data.folder_name);

            $('#'+link_url).show();

            $('#'+remove_icon_dataid).show();

			$('#show_banner_'+current_val).html('<img src="'+baseurl+'uploads/zone_logo/temp_folder/'+data.uploadedImage+'/normal_image/'+data.clientImage+'"><a style="margin-left: 10px;" class="remove_img" id="'+remove_icon_id+'" data-id="'+remove_icon_dataid+'" data-img="'+remove_icon_dataimg+'" href="jascript:void(0);">Remove</a>');

            //if(data!=0){}

            

			if(typeof(data.error) != 'undefined')

			{

				if(data.error != '')

				{

					alert(data.error);

				}else

				{

					alert(data.msg);

				}

			}

		},

		error: function (data, status, e)

		{

			//alert(e);

		}

	}

)       

return false;

}



function add_banner_insert(result){

    $.unblockUI();

    $('.form_error').show();

    $('.form_error').html('<span style="color:#008000;font-weight:bold;font-size: 19px;margin-left: 35px;">Save Successful.</span>');

    $('#reset_banner').click();

    $('#uploadedInput').val('');

}



$(document).ready(function () {

    $('#zone_data_accordian').click();

    $('#zone_data_accordian').next().slideDown();

    $('#zone_cms').addClass('active');

});



// + Datepicker for start time stop time

$("#ad_startdatetime,#ad_stopdatetime").live('focus',function(){

    $(this).datetimepicker({

        changeMonth: true,

        changeYear: true,

        dateFormat:'mm-dd-yy'

    });

});

// - Datepicker for start time stop time



// + Displaying Zone againest Zip Code

$(document).on('change','#biz_zip_code',function(){ 

    var zip=$(this).val(); 

    if(zip==''){

      $('#zip_error').slideDown();

      $('#biz_zip_code').focus();

      $("#biz_zone_select").hide();

            return false;

        }

    $.ajax({

        type:'POST',

        url:"<?=base_url('Zonedashboard/zip_to_zone')?>",        

        data:{'zip': zip},

        success: function(data) { 

          $.unblockUI();

          $('#zip_error').slideUp('slow');

           if(data==''){

            $("#biz_zone_select").show();

            $("#biz_zone_select").html(data);

            $("#biz_zone_id").val('')

          }else if(data!=''){ 

            $("#biz_zone_select").show();

            $("#biz_zone_select").html(data);     

            $('#biz_zone_id').val($('#zip_to_zone option:selected').val());

          }

        }

    });



// check for valid email checking

$('#biz_email').blur(function(){ 

     $('#biz_email').filter(function(){

        var email=$('#biz_email').val();

        // var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var emailReg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        if( !emailReg.test(email)){

           $('#email_notice').slideDown();

           //$('#email_notice').fadeOut(6000);

           $('#biz_email').focus();

           //$('#email_notice').fadeToggle();

       }else{

         $('#email_notice').slideUp('slow');

       } 

    })

});



// + for verify Username

// + For concat first and last name

// not needed - 09.07.2018

/*$(document).on('blur','.biz_full_name',function(){  

  var fname=$('#biz_first_name').val();

  var lname=$('#biz_last_name').val();

  //alert(fname+'---'+lname);

  var fullname='';

  if(fname!='' && lname!=''){

    fullname=fname+' '+lname;

  }else if(fname==''){

    fullname=lname;

  }else if(lname==''){

    fullname=fname;

  }

  $('#biz_full_name').val(fullname);

});*/

// - For concat first and last name





});



// + for changing Business Owner part start

$(document).on('change','input[name=owner_account]',function(){ 

    var tag=$(this).val();

    if(tag==1){

        $('.bona').hide();

        $('.boea').hide();

        $('#biz_username').val('');

        $('#biz_password').val('');

        $('span#error_uname').hide();

        $('span#success_uname').hide();

    }else if(tag==2){

        $('.bona').show();

        $('.boea').hide();

    }else if(tag==3){

        $('.bona').hide();

        $('.boea').show();

    }

});

$(document).on('click','#owner_account_existing',function(){

    var zoneid=$('#zoneid').val(); //alert(zoneid);

    var data={'zoneid':$('#zoneid').val()};

    PageMethod("<?=base_url('Zonedashboard/existing_business_owner_for_zone')?>", "", data, EBOSuccess, null); 

});

function EBOSuccess(result){

    $.unblockUI();

    if(result.Tag!=''){

        $('.boea').show();

        $(".boea").html(result.Tag);        

    }

}

// - for changing Business Owner part end

// + for Business Mode part start

$(document).on('click','input[name=biz_mode]',function(){   

    var biz_mode=$(this).val(); //alert(biz_mode); return false; 

    var zoneid=$('#zoneid').val();

    var data={'zoneid':zoneid,'biz_mode':biz_mode};

    PageMethod("<?=base_url('Zonedashboard/business_mode_for_create_business')?>", "", data, BizModeSuccess, null);

    

});

function BizModeSuccess(result){

    $.unblockUI();

    if(result.Tag!=''){

        $("div#get_business_mode").show();

        $("div#get_business_mode").html(result.Tag);

        $('#biz_type').change();

    }

}

// + for Business Mode part end



$(document).on('change','#business_is_restaurant',function(){

  $('#biz_type').change();

});



// + for Business Type part start

$(document).on('change','#biz_type',function(){

    var tag=$(this).val();

    var zoneid=$('#zoneid').val();

  var business_is_restaurant=$('#business_is_restaurant').val(); 

    var biz_mode=$("input[name=biz_mode]:checked").val(); //alert(biz_mode); alert(tag); alert(zoneid); alert(business_is_restaurant); //return false;

    if(tag != 3){

        CKEDITOR.instances.stater_ad_message.setData('');

    }else{

        CKEDITOR.instances.stater_ad_message.setData('<p align="center" class="MsoNormal" style="text-align: center;"><b><span  style="font-size: 18.0pt; color: #1F497D;">We have not had a chance to post all our offers in the system-<br><br>Please Contact Us for Our Offer!</span></b><br><br><br><span style="color:#000; font-size:20px">If you would like SavingsSites to contact the business on your behalf to ask them to post their offer, </span><span style="font-size:18px"><a href="#starter-ad-popup" style="text-decoration: underline;" class="starter_ad_click"><span style="color:red">click here</span></a></span></p>');

    }

    var data={'biz_type':tag,'zoneid':zoneid,'biz_mode':biz_mode,'business_is_restaurant':business_is_restaurant};  

    PageMethod("<?=base_url('Zonedashboard/category_for_create_business')?>", "", data, CatCreateBusinessSuccess, null);

    

});

function CatCreateBusinessSuccess(result){ //alert(JSON.stringify(result));

    $.unblockUI();

    if(result.Tag!=''){

        $("div#get_category").show();

        $("div#get_category").html(result.Tag);

        $('#main_category').change();

    }

}

// + for getting subcategory againest any category

// + for getting subcategory againest any category

$(document).on('change','#main_category',function(){ 

    var catid=$('#main_category').val(); 

    var zoneid=$('#zoneid').val();

    var data={'catid':catid,'zoneid':zoneid};   

    if(catid!=undefined)

        PageMethod("<?=base_url('Zonedashboard/subcat_for_create_business')?>", "", data, catsuccess, null);

});

function catsuccess(result){ //alert(JSON.stringify(result));   

    $.unblockUI();

  if(result.Title ==1){

    $('#main_category').attr('disabled', true);

  }else{

    $('#main_category').attr('disabled', false);

  }

    if(result.Tag!=''){

        $("div#get_subcategory").show();

        $("div#get_subcategory").html(result.Tag);

        var catid = result.Title; //alert(catid); //return false;

        if(catid==1){

            $('#deliver').hide();

        }else{

            $('#deliver').hide();

        }

    }

}

// - For Create Business

// + for verify Username



function showusername(result){

        $.unblockUI();

        if(result.Tag=='0'){

            $('#error_uname').html('This Username is already exist.<br/> Please try with another user name.' );

            $('#error_uname').show();

            $('#success_uname').hide();

            $("#userName").val(''); 

            $("#password").val('');

            $('#biz_username').focus();

            return false;

        }else{

            $('#error_uname').hide();

        }

    }



// + For Phone Number Display in Username

$(document).on('blur','#biz_phone',function(){

    var phone_int=$(this).val().replace(/[^0-9]/gi, ''); //alert(phone_int);  return false;

    if(phone_int==''){

        //$('#error_uname').hide();

    $('#phone_error').slideDown();

    $('p.phone_error').html('Please specify phone number');

    $('#biz_phone').focus();

    $('#biz_username').val('');

        return false;

    }



   $.ajax({

        type:'POST',

        url:"<?=base_url('Zonedashboard/add_business_check_username')?>",        

        data:{'user_name': phone_int},

        success: function(result) { 

          $.unblockUI();          

          if(result=='0'){

            $('#phone_error').slideDown();

            $('p.phone_error').html('This phone number is already exist');

            $('#biz_phone').focus();

            $('#biz_username').val('');

            return false;

          }else{

            $('#phone_error').slideUp('slow');

            $('p.phone_error').html('');

            var phone_int=$('#biz_phone').val();//alert(phone_int);

            $('#biz_username').val(phone_int);

          }

          

          /* if(data!=''){ 

            $("#biz_zone_select").show();

            $("#biz_zone_select").html(data);     

            $('#biz_zone_id').val($('#zip_to_zone option:selected').val());

          }*/

        }

    });





    //var data = { "user_name": phone_int};     //alert(zonename); //return false;

    //PageMethod("<?=base_url('Zonedashboard/add_business_check_username')?>", "Verify the username <br/>This may take a few minutes", data, showPhoneSuccess, null);

    

});

/*function showPhoneSuccess(result){

    $.unblockUI();

    if(result.Tag=='0'){

        $('#error_pname').html('This Phone No. is already exist.<br/> Please try with another Phone No.' );

        $('#error_pname').show();

        $('#success_pname').hide();     

        return false;

    }else{

        $('#success_pname').html('Congratulations your user name has been accepted' );

        $('#success_pname').show();

        $('#error_pname').hide();

        //var phone_int=$('#biz_phone').val().replace(/[^0-9]/gi, '');

        var phone_int=$('#biz_phone').val();//alert(phone_int);

        $('#biz_username').val(phone_int);

    }

}*/

// - For Phone Number Display in Username

$(document).on('click','#create_generate_password',function(){ 

    PageMethod("<?=base_url('Zonedashboard/create_generate_password_org')?>", "Creating The Password...<br/>This may take a few minutes", null, showPasswordBus, null);

});

function showPasswordBus(result){

    $.unblockUI();

    if(result.Tag!=''){             

        $("#biz_password").val(result.Tag);

    }

}

function select_zone_value(){

    var zoneid = $('#zip_to_zone').val();

    $('#biz_zone_id').val(zoneid);

}

$(document).on('click','#create_business',function(){//alert($('#stater_ad_message').val()) ;return false ; 

    //alert(CKEDITOR.instances.stater_ad_message.getData());return false ;

    //alert($("input[name=biz_mode]:checked").val()); return false;

    if($("#biz_zip_code").val()=='' || $("#biz_zone_id").val()=='-1'){

        alert(' Please specify valid Zip Code');

        return false;       

    }else if($("#biz_name").val()==''){

        alert(' Please specify Business Name');

        return false;

    }

    

    if($("#biz_first_name").val()==''){

        alert("Please specify first name.");

        return false;

    }

    

    if($("#biz_last_name").val()==''){

        alert("Please specify last name.");

        return false;

    }

    

    if($("#biz_phone").val()!=''){

        //alert($("#biz_phone").val().length);

        if($("#biz_phone").val().length<12){

            alert("Please specify valid phone no.");

            return false;

        }

    }else{

        alert("Please specify phone no.");

        return false;

    }

    if($("input[name=owner_account]:checked").val()==2 && $('#biz_username').val()==''){

        alert("Please specify Username.");

        return false;

    }

    if($("input[name=owner_account]:checked").val()==2 && $('#biz_password').val()==''){

        alert("Please specify Password.");

        return false;

    }

    

    

    var audio_presentation=$("input[name=biz_audio_presentation]:checked").val(); 

    if(audio_presentation==undefined){

        audio_presentation=0;

    }

    var video_presentation=$("input[name=biz_video_presentation]:checked").val(); 

    if(video_presentation==undefined){

        video_presentation=0;

    }

    var display_cat_subcat='';  

    $('.optiondropdown:selected').each(function(i, j){          

        display_cat_subcat+=$(j).val()+',';

    });

    display_cat_subcat=display_cat_subcat.substring(0,display_cat_subcat.length-1);

    //alert($('#main_category').val()); alert(display_cat_subcat); //return false;

    if($('#main_category').val()=='' || display_cat_subcat==''){

        alert("Please specify Category/Sub-category.");

        return false;

    }

    if(CKEDITOR.instances.stater_ad_message.getData() == ''){

        alert("Please specify Starter Ad.");

        return false;

    }

    

    var deliver ;                                   // Added on 14/8/14 ; 1-> Home Delivery -> 0 -> No Delivery

    if($('#yes').prop('checked') ){

        deliver = 1;

    }else if($('#no').prop('checked')){

        deliver = 0;

    } 

    

    var phone_int=$("#biz_phone").val().replace(/[^0-9]/gi, ''); 

    

    

    

/*     if($('#biz_name').val()== ''){

                     var txt = '<h5 style="color:#090">Please enter business name.</h5>';

                     $('#error_contact_name').html(txt);

                     $('#error_contact_name').show();

                     return false;

                 }else{

                     $('#biz_name').val();

                     //$('#error_contact_name').hide();

                     setTimeout(function(){

                            $('#error_contact_name').hide('slow');

                        }, 1000);

                 }

    

    

     if($('#biz_first_name').val()== ''){

                     var txt = '<h5 style="color:#090">Please enter first name.</h5>';

                     $('#error_contact_firstname').html(txt);

                     $('#error_contact_firstname').show();

                     return false;

                 }else{

                     $('#biz_first_name').val();

                      setTimeout(function(){

                            $('#error_contact_firstname').hide('slow');

                        }, 1000);

                 }

      if($('#biz_last_name').val()== ''){

                     var txt = '<h5 style="color:#090">Please enter last name.</h5>';

                     $('#error_contact_lastname').html(txt);

                     $('#error_contact_lastname').show();

                     return false;

                 }else{

                     $('#biz_contactlastname').val();

                      setTimeout(function(){

                            $('#error_contact_lastname').hide('slow');

                        }, 1000);

                 }*/

    

    

    

    

    var data = {

        id : "-1",

        zipcode : $("#biz_zip_code").val(),

        zone_id : $("#biz_zone_id").val(),

        name: $("#biz_name").val(),

        motto: $("#biz_motto").val(),

        contactemail : $("#biz_email").val(),

        contactfirstname : $("#biz_first_name").val(),

    contactlastname : $("#biz_last_name").val(),

        contactfullname : $("#biz_full_name").val(),

        street1 : $("#biz_address_1").val(),

    street2 : $("#biz_address_2").val(),

        city : $("#biz_city").val(),

        state : $("#biz_state").val(),

        phone : $("#biz_phone").val(),

        phone_int : phone_int,

    website : $("#biz_website").val(),

    restaurant_type:$('#business_is_restaurant').val(),

        siccode : $("#biz_sic").val(),

        audio_presentation : audio_presentation,

        video_presentation : video_presentation, 

        owner_account : $("input[name=owner_account]:checked").val(),

        biz_username : $('#biz_username').val(),

        biz_password : $('#biz_password').val(),

        existing_bo : $('#ebo').val(),

        biz_mode : $("input[name=biz_mode]:checked").val(), 

        biz_type : $('#biz_type').val(),

        catid : $('#main_category').val(),  

        subcatid : display_cat_subcat,

        stater_ad : CKEDITOR.instances.stater_ad_message.getData(),

        //stater_ad : $('#stater_ad_message').val(),

        ad_stopdatetime:$("#ad_stopdatetime").val(),

        ad_startdatetime:$("#ad_startdatetime").val(),

        deliver : deliver

    };//console.log(data) ;return false ;

    $('#create_business').attr("disabled",true) ;

    PageMethod("<?=base_url('Zonedashboard/create_business')?>", "Saving Business Data<br/>This may take a few minutes", data, BizSaveSuccessful, null);

});

function BizSaveSuccessful(result){//alert(JSON.stringify(result));

    $.unblockUI();

    if(result.Tag!=''){

        $('#create_business').removeAttr("disabled", false);

        $("#biz_zip_code").val('');$("#biz_zone_id").val('');$('#biz_zone_select').val(''); $("#biz_name").val('');$("#biz_motto").val('');

        $("#biz_email").val('');

         $("#biz_first_name").val(''); $("#biz_first_name").val(''); $("#biz_last_name").val('');$("#biz_full_name").val('');$("#biz_address_1").val('');         $("#biz_address_2").val(''); $("#biz_city").val(''),

        $("#biz_state").val(''); $("#biz_phone").val(''); $("#biz_website").val('');$("#biz_sic").val(''); 

        $("input[name=owner_account]:checked").val('');

        $('#biz_username').val('');$('#biz_password').val(''); $('#ebo').val('');

        $("input[name=biz_mode]:checked").val('');$('#biz_type').val('');$('#main_category').val('');$("#ad_stopdatetime").val('');

         $("#ad_startdatetime").val('');$('#biz_zone_id').val($('#zip_to_zone option:selected').remove(''));CKEDITOR.instances.stater_ad_message.setData('');

         $('#biz_zone_select').find('p').hide() ;

        $('#msg').html('<h4 style="color:#090">You have successfully created the business.</h4>').show();

        $('html,body').animate({scrollTop:0},"slow");

        setTimeout(function(){$("#msg").hide('slow'); 

        //window.location.reload();

        },3000); // reload page after submission

        //$(".success").show();

        //$("#get_subcategory").html(result.Tag);

    }

    



}





// - For Create Business

$(document).on('click','#reset',function(){

    location.reload();

});

$(function (){

   $("#biz_phone").mask("999-999-9999",{placeholder:' '});

});



$(document).on('blur','#biz_password',function(){

    //alert($(this).val());

    var password = $(this).val();

  if(password==''){

    //$('#error_uname').hide();

    $('#password_error').slideDown();

    //$('p.phone_error').html('Please specify phone number');

    $('#biz_password').focus();

    //$('#biz_username').val('');

    return false;

  }

    var regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%#&])[A-Za-z\d$@$!%#&]{5,}$/; 

    if(password.length < 5 || password.length > 18){

      $('#password_error').slideDown();

          $('p.password_error').html("Password should be between 5 to 18 characters");

            //$('#error_password').show();

            $('#biz_password').focus();

            return false;

    }else if(!regex.test(password)){ 

          $('#password_error').slideDown();

      $('p.password_error').html("Password should be combination of letters, numbers and special characters (!, @, #, $, %, &)");

      /*$('#error_password').html("Password should be combination of letters, numbers and special characters (!, @, #, $, %, &)");

            $('#error_password').show();*/

            $('#biz_password').focus();

            return false;

        }else{  

            //$('#error_password').hide();

      $('#password_error').slideUp('slow');

        }

});





/*$(document).on('blur','#biz_username',function(){

    var username = $(this).val();

    var regex = /^[a-zA-Z0-9\-]+$/i; 

    if(username.length < 6 || username.length > 18){

        $('#error_username').html("Business username should be limited character 6-18 ");

            $('#error_username').show();

            $('#biz_username').focus();

            return false;

    }else{  

            $('#error_username').hide();

        }

});*/







</script>

<style type="text/css">
input#lefttop,input#leftbottom,input#righttop,input#rightbottom {
    max-width: 100%!important;
    width: 61%!important;
    margin-right: 7px;
}
span.sub_line_text {
    margin-left: 201px !important;
    display: block;
}
@media (max-width: 480px){
    .form-group label {
  
    margin-top: 0 !important;
}
}
</style>