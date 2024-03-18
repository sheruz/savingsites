<!--<script type="text/javascript">
var baseurl = "<?php echo base_url(); ?>";
//$(document).on('submit','form#update_banner',function(){	
function update_banner_function(image_name,order){  //alert(image_name); alert(order);return false; alert('pos=>'+$('#banner_id').val()); 
	if(image_name!='' && order!=''){
		$('.form_error').hide();
		var dataToUse=$('form#update_banner').serialize();
		PageMethod("<?=base_url('banner_controller/update_banner')?>", "Please wait ....", dataToUse, update_banner_success, null);
	}else{
		$('.form_error').show();
		var form_error='';
		if($('#uploadedInput').val()==''){
			form_error+="Please upload a file.</br>";
		}
		if($('#order').val()==''){
			form_error+="Please provide banner position no.";
		}		
		$('.form_error').html('<span style="color:#F00; font-weight:bold;font-size: 19px;margin-left: 35px;">'+form_error+'</span>');
		return false;
	}
}
function update_banner_success(){
	$.unblockUI();
	$('.form_error').show();
	$('.form_error').html('<span style="color:#008000;font-weight:bold;font-size: 19px;margin-left: 35px;">Update Successful.</span>');
	setTimeout(function(){
		$('.form_error').hide('slow');
	},3000);	
}
$(document).on('submit','#update_banner',function(){
	update_banner_function($('#uploadedInput1').val(),$('#order1').val());
});
function ajaxFileUpload(){
	//starting setting some animation when the ajax starts and completes
	 $.ajaxFileUpload(        		
	{
		url:'<?=base_url('banner_controller/save_banner_image/'.$zone_id.'')?>',
		secureuri:false,
		fileElementId:'imgfile',
		dataType: 'json',
		success: function (data, status)
		{
			//alert(data.uploadedImage);
			var zone = $('#zone_id').val();
			$('#uploadedInput').val(data.uploadedImage);
			$('#bannerimage').attr('src',baseurl+'uploads/banner/'+zone+'/'+data.uploadedImage);
			if(data!=0){}
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
			alert(e);
		}
	}
)       
return false;
}  
</script>-->
<script>
$('textarea#edittextarea').keyup(function(e){ //alert(123);
    if(e.keyCode == 13)
    {
        //$(this).trigger("enterKey");
		$('#edittextarea').val($('#edittextarea').val() + '<br />');
    }
});

function ajaxFileUpload2(){ //alert(1);
	//starting setting some animation when the ajax starts and completes
	$('#spinner1').show();
	 $.ajaxFileUpload(        		
	{
		url:'<?=base_url('banner_controller/edit_banner_imageformobile/'.$zone_id.'')?>',
		secureuri:false,
		fileElementId:'edit_banner',
		dataType: 'json',
		success: function (data, status)
		{   //alert(data.uploadedImage);
			//console.log(data); return false;
			$('#spinner1').hide();
			$('#uploadedfile').val(data.uploadedImage);
			$('#uploadedInput1').val(data.uploadedImage);
			//$('#show_banner1').attr('src','/new/image/src.jpg');
            //$('#bannerimage').html('<img src="'+baseurl+'uploads/zone_banner/'+data.zone_id+'/'+data.uploadedImage+'" style="width:300px;  margin-top: 8px;">');
            $('#bannerimage').attr('src',baseurl+'uploads/zone_mobile_resizeupload/'+<?=$zone_id?>+'/'+data.uploadedImage);
			//$('#bannerimage').attr('src',baseurl+'uploads/banner/'+<?=$zone_id?>+'/'+data.uploadedImage);
			if(data!=0){}
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
			alert(e);
		}
	}
)       
return false;
}
</script>
<?php //echo"<pre>";print_r($banner_view);die; ?>
<form name="update_banner" id="update_banner" method="post" enctype="multipart/form-data"  action="javascript:void(0);">
<input type="hidden" name="order1" id="order1" value="<?php echo $banner_view[0]['order'];?>"/>
<input type="hidden" name="uploadedInput1" id="uploadedInput1" value="<?php echo $banner_view[0]['image_name'];?>" />
<input type="hidden" name="uploadedby" id="uploadedby" value="<?php echo $banner_view[0]['uploaded_by']; ?>" />
  <table width="100%" border="0" align="left" cellpadding="1" cellspacing="1">
    <tr>
      <td  valign="top" bgcolor="#FFFFFF"><table width="95%" border="0" cellspacing="1" cellpadding="4" >
          <div class="form_error" style="display:none;"></div>
          <!--<tr>
            <td width="12%"  valign="middle" class="cat_block1">Banner Link:</td>
            <td width="88%" valign="middle" class="cat_block1"><input  name="banner_link" type="text" class="comment" id="banner_link" value="" size="50"></td>
          </tr>-->
          <tr id="image" >
					
					<?php if($banner_view[0]['uploaded_by'] != '0'): ?>
						<div style="background-color: rgb(19, 19, 18););height: 28px;border-radius: 5px;">
							<span style="font-size:15px;color:wheat;  padding: 4px;display: block;  margin-left: 55px;">
							For best results upload a 737 pixel wide x 1150 pixel high image
							</span>
						</div>
					<?php endif; ?>

            <td  valign="middle" class="title_content_block"><span class="cat_block1">Image</span>:</td>
            <td  valign="middle" class="title_content_block"><div id="uplodImage">
            <?php /*?><?php if ($banner_view[0]['uploaded_by']!=0) {?>
                <input type="file" id="imgfile" onchange ="ajaxFileUpload();" name="imgfile" value="" />
            <?php }?><?php */?>
                <input type="hidden" name="uploadedInput" id="uploadedInput" value="<?php echo $banner_view[0]['image_name'];?>" />
                <input type="hidden" id="zone_id" name="zone_id" value="<?php echo $zone_id;?>" />
                <input type="hidden" name="banner_id" value="<?php echo $banner_id;?>" />
								<input type="hidden" name="tab_id" value="<?php echo $tab_id;?>" />
								<input type="hidden" name="device_type" value="2" />
                <?php
				$uploaded_by=($banner_view[0]['uploaded_by']==0) ? "default" : $zone_id ; 
				
				?>
              <?php if ($banner_view[0]['uploaded_by']!=0) {?>
                <input type="file" id="edit_banner" onchange="ajaxFileUpload2();"  name="edit_banner"  value="" />
                <span style="display:none;   position: absolute;  right: 240px;margin-top: -24px;" id="spinner1"><img src="<?php echo base_url() ?>assets/images/loading.gif"></span>
                 <input type="hidden" name="uploadedfile" id="uploadedfile" value="" />
              <?php } ?>  
              <div style="clear:both"></div>
              
				<?php if($banner_view[0]['uploaded_by']==0){?>                
				<img style="width: 300px;" id="bannerimage" src="../../assets/directory/images/banner/<?php echo $banner_view[0]['image_name'];?>" />
				<?php }else {?>
				<img style="width: 300px;" id="bannerimage" src="../../uploads/zone_mobile_resizeupload/<?php echo $uploaded_by; ?>/<?php echo $banner_view[0]['image_name'];?>" />
				<?php } ?>
                <div id="show_banner1" style="width:300px;"></div>
                 <!--<p id="uploading">(Please select a file(950px*350px) to upload)</p>-->
              </div></td>
          </tr>
          <!--<tr>
            <td  valign="middle" class="cat_block1">Description:</td>
            <td><textarea id="edittextarea" name="description" <?php if ($banner_view[0]['uploaded_by']==0) {?> disabled="disabled" <?php }?> style="width:371px;height: 150px;"><?php echo $banner_view[0]['description'];?></textarea></td>
          </tr>-->
          <tr>
            <td  valign="middle" class="title_content_block">Status:</td>
            <td  valign="middle" class="title_content_block"><input type="radio" name="status" value="1" <?php if($banner_view[0]['status']==1) { ?>  checked="checked" <?php } ?>>
              Viewable
              <input type="radio" name="status" value="0" <?php if($banner_view[0]['status']==0) { ?>  checked="checked" <?php } ?> >
              Not viewable</td>
          </tr>

					<?php if($banner_view[0]['uploaded_by'] != '0'): ?>
					<tr>
						<td valign="top" class="title_content_block">Banner Link:</td>
						<td valign="top" class="title_content_block">
							<label style="margin-top:0;">
								<input type="text" name="set_banner" class="form-control" 
								value="<?=!empty($banner_view[0]['set_banner_url']) ? $banner_view[0]['set_banner_url'] : ''?>">
							</label>
							<br/>
							(Please use http:// or www before on url Link)
						</td>
					</tr>
				<?php endif; ?>

          <!--<tr>
            <td  valign="middle" class="title_content_block">Display At:</td>
            <td  valign="middle" class="title_content_block">
             <input type="checkbox" name="view_at[]" value="1" <?=(in_array('1',$total_checkbox)) ? 'checked' : 'unchecked' ?>>Directory                        
              
             <input type="checkbox" name="view_at[]" value="2" <?=(in_array('2',$total_checkbox)) ? 'checked' : 'unchecked' ?>>Business Search                              
             
             <input type="checkbox" name="view_at[]" value="3" <?=(in_array('3',$total_checkbox)) ? 'checked' : 'unchecked' ?>>Pekaboo
              
             <input type="checkbox" name="view_at[]" value="4" <?=(in_array('4',$total_checkbox)) ? 'checked' : 'unchecked' ?>>Dining
              
             <input type="checkbox" name="view_at[]" value="5" <?=(in_array('5',$total_checkbox)) ? 'checked' : 'unchecked' ?>>Webinar

             <input type="checkbox" name="view_at[]" value="6" <?=(in_array('6',$total_checkbox)) ? 'checked' : 'unchecked' ?>>Home
              
            </td>
          </tr>-->

          <!--<tr>
            <td  valign="middle" class="cat_block1">Banner position no:</td>
            <td><input type="text" name="order" id="order" value="<?php echo $banner_view[0]['order'];?>"/></td>
          </tr>-->
          <tr >
            <td  class="cat_block1">&nbsp;</td>
            <td  valign="middle" class="cat_block1"><input type="submit" name="Submit" value="Submit" class="bttn"  style="width:70px">
           <!-- <button type="button" id="goback" onclick="$('#banner_details').hide();$('#banner_list').show();">Back</button>-->
            
            <button type="button" id="goback" onclick="window.location.reload();">Back</button>
              <input type="reset" id="reset_banner" style="display:none;"/></td>
          </tr>
          
          <tr >
            <td colspan="2" class="err">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>