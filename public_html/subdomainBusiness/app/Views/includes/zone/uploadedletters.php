<div class="main_content_outer">
  <div class="content_container">
    <div class="container_tab_header">Uploaded Letters Shared Between Zone Owners & Organization Owners</div>
    <div id="container_tab_content" class="container_tab_content">
      <ul>
        <li><a href="#tabs-1" id="tab1" onclick="view_letters_display(<?=$zone_id?>);">Library of Uploaded Letters</a></li>
        <li><a href="#tabs-2" id="tab2" onclick="create_letters_display(<?=$zone_id?>);">Upload Letters</a></li>
      </ul>
      <div id="msg" style="display:none;"></div>
      <div id="tabs-1">
      	<div id ="view_letters"></div>
        <div id ="view_edit_letters"></div>
      </div>
      
      <div id="tabs-2">
      	<div id ="view_create_letters"></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () { 
	$('#adv_tools').click();
	$('#adv_tools').next().slideDown();
	$('#zonemarket').click();
	$('#zonemarket').next().slideDown();
	$('#zone_uploaded_letters').addClass('active');
	$('#tab1').click();
});

function  check_authneticate(){ 
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}

// + View All Uploaded Letters
function view_letters_display(zoneid){
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zone_id?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		 $('#view_edit_letters').html('');
		var data={'zoneid':zoneid};
		PageMethod("<?=base_url('Zonedashboard/view_uploaded_letters')?>", "", data, viewuploadedletterssuccess, null);
	}
}
function viewuploadedletterssuccess(result) {
	$.unblockUI();
	if(result.Tag!=''){ //alert(JSON.stringify(result));	
		$("#view_letters").show();
		$("#view_letters").html(result.Tag);
	}
}
// - View All Uploaded Letters

// + Create Uploaded letters Display
function create_letters_display(zoneid){
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zone_id?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		 var dataToUse = {zoneid : zoneid};
		 PageMethod("<?=base_url('Zonedashboard/create_upload_letters_view')?>", "", dataToUse, createUploadLettersViewSuccessful, null); 
	 }
}
function createUploadLettersViewSuccessful(result){
$.unblockUI();
	if(result.Tag!=''){	
		$('#view_create_letters').html(result.Tag);
	}
}
// - Create Uploaded letters Display

// + Edit Uploaded Letters
function edit_uploaded_letters(id,zoneid){
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zone_id?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		$('#view_create_letters').html('');
		$('#view_letters').hide();	// hiding for edit view
		var dataToUse = {id : id, zoneid : zoneid};
		PageMethod("<?=base_url('Zonedashboard/create_upload_letters_view')?>", "", dataToUse, editUploadLettersViewSuccessful, null); 
	}
}
function editUploadLettersViewSuccessful(result){
	$.unblockUI();
	var id = result.Title;
	if(result.Tag!='' && id != ''){	
		$('#view_edit_letters').html(result.Tag).show();
	}
	edit_uploaded_letters_action(id);
}
function edit_uploaded_letters_action(id){
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zone_id?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		PageMethod("<?=base_url('Zonedashboard/edit_uploaded_letters')?>" + "/" + id, "", null, UploadedLettersEdit, null);
	 }
}
function UploadedLettersEdit(result) {
	//alert(JSON.stringify(result));
	//alert(result.display_name);
	$.unblockUI();		
	//$("#view_letters").hide();
	//$('#add_letters').show();
	$('.uploaded_letters_file').hide();
	$("input[class=upload_letters_checkbox]:Checked").attr('checked',false);		
	$("#letter_id").val(result.id);
	$("#ul_name").val(result.display_name);
	$("#ul_desc").val(result.description);
	var organizationid=result.organizationid;
	var organizationid_split=organizationid.split(',');
	$.each(organizationid_split,function(i,item){ 
		$(".upload_letters_checkbox").filter(function(){
			if($(this).val()==item)
				return true;
			else
				return false;
		}).attr('checked','checked');
	});
	if($('#letter_id').val() != '-1'){
		$('#cancel_edit').show();
	}	
}

// - Edit Uploaded Letters

// + for individual org selection
function individual_checkbox_upload_letters(){ 
	var total_checkbox=$("input[class=upload_letters_checkbox]").length ;
	var total_checked_checkbox=$("input[class=upload_letters_checkbox]:checked").length; //alert(total_checkbox); alert(total_checked_checkbox);
	if(total_checkbox!=total_checked_checkbox){ 
		 $('#upload_letters_checkbox_0').attr('checked', false);		
	}else if(total_checkbox==total_checked_checkbox){
		 $('#upload_letters_checkbox_0').attr('checked', true);		
	}	
}
// - for individual org selection

// + Seleting all org from org list
function select_all_category(ele){ 
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
// - Seleting all org from org list

// + Save Uploaded Letters
function save_letters(tag){
var check_up=$('#ups_letter').val(); //alert(check_up);
	if(typeof check_up!='undefined'  && $('#ul_name').val()!='' && $('#ul_desc').val()!='')
	{
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zone_id?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		var display_checkbox='';		
		$("input[class=upload_letters_checkbox]:Checked").each(function(i,item){ //alert(2);
			display_checkbox+=$(item).val()+',';
		});			
		display_checkbox=display_checkbox.substring(0,display_checkbox.length-1);	
		
		var _f=$(tag).closest('form');
		if($("#ups_letter").val()=='' && $('#letter_id').val() == '-1'){
			alert('Please Upload the File');
			return false;
		}
		if(display_checkbox==''){
			alert('Please Select Organization');
			return false;
		}
		var dataToUse = {
			"ul_id":$("#letter_id").val(),		
			"ul_file":$("#ups_letter").val(),
			"ul_display_name":$("#ul_name").val(),
			"ul_desc":$("#ul_desc").val(),
			"ul_org":display_checkbox,
			'zoneid':$('#iszoneid').val()		
		};
		
		PageMethod("<?=base_url('Zonedashboard/save_upload_letters')?>", "", dataToUse, lettersSaveSuccessful, null);
	 }
	}
	else
	{
		alert ('All fields are mandatory.');
	}
}
function lettersSaveSuccessful(result) {
	//alert(JSON.stringify(result));
	$.unblockUI();	
	 if($('#letter_id').val() == '-1'){
	 	$('#ul_form').trigger("reset");	
		$('#upload_letters').empty();
		var ul_text = 'saved';
	 }else{
		var ul_text = 'edited'; 
	}
	$('html,body').animate({scrollTop:0},"slow");
	$('#msg').html('<h4 style="color:#0C0">Uploaded Letters has been '+ul_text+' successfully.</h4>').show();
	setTimeout(function(){
		$('#msg').hide('slow');
	},3000);	
	//$('#add_letters').hide();
	//$("#view_letters").show();		
	//var zoneid=$('#iszoneid').val();
	//view_letters_display(zoneid);
}

// - Save Uploaded Letters



// + Delete Uploaded Letters
function delete_uploaded_letters(id,zoneid){	
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zone_id?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		var data = { id : id, zoneid : zoneid};
		ConfirmDialog("Really remove this from this zone?", "Warning", "<?=base_url('Zonedashboard/delete_uploaded_letters')?>",
				"Successfully Remove ...<br/>This may take a minute", data, DeleteLettersSuccess, null);		
	 }
}
function DeleteLettersSuccess(result){
$.unblockUI();
	if(result.Title!=''){	
		$("#ul_"+result.Title).hide();
	}
}
// - Delete Uploaded Letters

// + Cancel Edit
function cancel_edit(){
	//$('#view_letters').show(); // show when cancel clicked
	//$('#view_edit_letters').html('').hide();
	$('#tab1').click();
}

// - Cancel Edit

</script>