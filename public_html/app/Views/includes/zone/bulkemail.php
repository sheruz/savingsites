

<div class="main_content_outer"> 
  
<div class="content_container form-group">
	<div class="container_tab_header">Bulk Email For Business</div>
	<div id="container_tab_content" class="container_tab_content">
    	<div style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:10px;" class="container_tab_header">
        <select name="bulk_email_zone" id="bulk_email_zone" onchange="bulk_zone_business_allbusiness()">
          <option value="2">All businesses in my zone or outside my zone</option>
          <option value="0">Businesses in my zone and located in my zone</option>
          <option value="1">Businesses advertising in my zone but located outside my zone</option>
          <option value="3">All businesses which are not assigned to any zone</option>
        </select>
       
        <select name="bulk_email_type" id="bulk_email_type" style="display:none">
          <option value="0">New Business - Not Yet Approved</option>
          <option value="1">Active Paid Business - Ad is viewable</option>
          <option value="-1">Expired Paid Business - Ad is not viewable</option>
          <option value="2">Active Trial Business - Ad is viewable</option>
          <option value="-2">Expired Trial Business - Ad is not viewable</option>
        </select>
        <button class="showbulkemail" onclick="get_business_bulk(<?=$zoneid?>,'all');">Show</button>
        </div>
        
        <div id="bulk_email" style="margin-top: -35px;"> <?php echo $templates;?> </div>
        <div id="body_email" style="display:none;">
          <input type="hidden" id="eids" name="eids" value=""/>
          <p>
            <label for="email_subject" style="width:150px; float:left; padding-right:10px;">Subject</label>
            <input type="text" id="email_subject" name="email_subject" style="width:425px;"/>
          </p>
          <p>
            <label for="mail_content" id="mail_content" style="width:150px; float:left; display:block; padding-right:10px;">Text Message</label>
            <textarea rows="10" cols="45" style="width: 425px; height: 150px" id="mail_content" name="text_message_email"></textarea>
          </p>
          <button class="sendmail" onclick="sendallemail();" style="margin-left:160px;">Send Mail</button>
          <button class="back" onclick="email_back();" style="margin-left:10px;">Back</button>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function () { 
	$('#adv_tools').click();
	$('#adv_tools').next().slideDown();
	$('#enotice').click();
	$('#enotice').next().slideDown();
	$('#zone_org_ig').addClass('active');
	$('#zone_bulk_email').addClass('active');
	$('.showbulkemail').click();
});

// + check_authneticate
function  check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}    
// - check_authneticate

function bulk_zone_business_allbusiness(){ 
	if($('#bulk_email_zone').val()==2 ){
		$('#bulk_email_type').hide();
	}else{
		$('#bulk_email_type').show();
	}
}

function get_business_bulk(zone_id)
{
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		var bulk_email_select_value=$("#bulk_email_zone").val();
		if(bulk_email_select_value!=2){
			var bulk_email_type_select_value=$("#bulk_email_type").val();
			$('#bulk_email_type').show();
		}else{
			var bulk_email_type_select_value=5;
		}
		if(bulk_email_select_value==3){
			zone_id=-1;
		}
		$.post("<?=base_url('Zonedashboard/get_business_bulk')?>/"+zone_id+"/"+bulk_email_select_value+"/"+bulk_email_type_select_value, '',
			function(data) {
			$("#bulk_email").html(data);
		});
	 }
}

function get_template_bulk()
{
	$.post("<?=base_url('Zonedashboard/get_template_bulk')?>", '',
		function(data) {
		$("#bulk_email").html(data);
	});
}
function Edittemplate(id){	
	$.post("<?=base_url('Zonedashboard/edit_template_bulk')?>/"+id, '',
		function(data) {
		if(CKEDITOR.instances['template_content'])
		{
			CKEDITOR.instances['template_content'].destroy();
		}
		if(CKEDITOR.instances['addtemplate_content'])
		{
			CKEDITOR.instances['addtemplate_content'].destroy();
		}
		$("#bulk_email").html(data);			
	});
}
function Deletetemplate(id, title){
	$.post("<?=base_url('Zonedashboard/delete_template_bulk')?>/"+id,'',
			function(data) {
			$("#bulk_email").html(data);
	});
}
function newtemplate_bulk()
{
    $.post("<?=base_url('Zonedashboard/newtemplate_bulk')?>/", '',
		function(data) {
			$("#bulk_email").html(data);
	});
}
function save_template(status)
{
		var hidden_temp_id = $("#hidden_temp_id").val();
		var dataToUse = {
				"id":$("#hidden_temp_id").val(),
				"zone":default_zone,
				"status":status,
		        "template_subject":$("#template_subject").val(),
		        "addtemplate_content":CKEDITOR.instances.addtemplate_content.getData()
		};
		if(status==1)
		{
			$.post("<?=base_url('Zonedashboard/save_template_bulk')?>/", dataToUse,
				function(data) {
					if(CKEDITOR.instances['template_content'])
				    {
				    	CKEDITOR.instances['template_content'].destroy();
				    }
				    if(CKEDITOR.instances['addtemplate_content'])
				    {
				    	CKEDITOR.instances['addtemplate_content'].destroy();
				    }
					$("#bulk_email").html(data);
			});
		}else{
			$.post("<?=base_url('Zonedashboard/save_template_bulk')?>/", dataToUse,
					function(data) {
						if(CKEDITOR.instances['template_content'])
					    {
					    	CKEDITOR.instances['template_content'].destroy();
					    }
					    if(CKEDITOR.instances['addtemplate_content'])
					    {
					    	CKEDITOR.instances['addtemplate_content'].destroy();
					    }
						$("#bulk_email").html(data);
			});
		}
}

function select_all(ele)
{ 
	checkboxes = document.getElementsByTagName("input");//get main check box
	if(ele.checked==true)//check main check box is checked or non checked
	{
		state = true;//set status
	}else{
		state = false;//set status
	}
	for (i=0; i<checkboxes.length ; i++)//chck all other checkbox and set their status
	{
	  if (checkboxes[i].type == "checkbox") 
	  {
		checkboxes[i].checked=state;
	  }
	}
}
function get_all_business(user)
{
	$.post("<?=base_url('Zonedashboard/get_all_business')?>/"+user+"/"+default_zone, '',
			function(data) {
			//alert(data);
				$("#contactOwnerDialog").html(data);
				$('#contactOwnerDialog').dialog('open');
		});
	
}

$("#contactOwnerDialog").dialog({autoOpen : false, modal: true, width:500});
function send_all_business_bulk()
{
	//alert(1);
	var zone_owner=new Array();
	var i=0;
	$('.zone_owner_check').each(function (){
    	if($(this).is(':checked'))
    	{
			//alert($(this).val());
    		zone_owner[i] = $(this).val();
    		i++;
        }
    });
	var dataToUse = {
		    "zone_owner":zone_owner
	    };
    
	$.post("<?=base_url('Zonedashboard/set_subscriber_bulk')?>/"+default_zone, dataToUse,
			function(data) {
				$("#bulk_email").html(data);
		});
}

function send_email()
{
    var dataToUse = {
	    "zone":default_zone,
		"subscriber":$("#subscriber").val(),
		"template":$("#template").val(),
		"template_subject":$("#template_subject").val(),
		"template_content":CKEDITOR.instances.template_content.getData()
    };

	    $.post("<?=base_url('dashboards/send_email_bulk')?>", dataToUse,
				function(data) {
					
					if(CKEDITOR.instances['template_content'])
				    {
				    	CKEDITOR.instances['template_content'].destroy();
				    }
				    if(CKEDITOR.instances['addtemplate_content'])
				    {
				    	CKEDITOR.instances['addtemplate_content'].destroy();
				    }
				    $("#bulk_email").html(data);
		});
}
/* Bulk email portion end */

// email part start partha 18.01.2013
function send_all_business_bulk_new(){
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		var id= Array();
		$('.zone_owner_check').each(function (){
			if($(this).is(':checked')){
				id.push($(this).val());
			}
		});
	
		var ids=id.join(',');
		if(ids==''){
			alert('Please select at least one business to send a mail');
			return false;
		}
		$('#eids').val(ids);
		$('#bulk_email').hide();
		$('#body_email').show();
	 }
}
function email_back(){
	$('.zone_owner_check').each(function (){
		if($(this).is(':checked')){
			$(this).attr('checked', false);
		}
	});
	$("#email_subject").val('');
    $("#text_message_email").val('');
	$('#bulk_email').show();
	$('#body_email').hide();
}
function sendallemail(){ 
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zoneid?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){ 
		if($("#email_subject").val()==''){
			alert('Please give subject');
			return false;
		}
		if($("#text_message_email").val()==''){
			alert('Please give message');
			return false;
		}
			var dataToUse = {
				"uid":$("#eids").val(),
				"subject":$("#email_subject").val(),
				"message": $("#text_message_email").val()
			};
			PageMethod("<?=base_url('Zonedashboard/sendallemails')?>", "Sending email<br/>This may take a minute.", dataToUse, emailSendSuccessful, null);
	 }
    }
	function emailSendSuccessful(result) {
        $.unblockUI();
		$('.zone_owner_check').each(function (){
			if($(this).is(':checked')){
				$(this).attr('checked', false);
			}
		});
		$("#email_subject").val('');
        $("#text_message_email").val('');
		$('#bulk_email').show();
		$('#body_email').hide();
	}
</script>


