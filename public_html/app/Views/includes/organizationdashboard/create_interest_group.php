<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />

<input type="hidden" name="orgnid" id="orgnid" value="<?=$common['organizationid']?>" />
<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />


<?php if(($common['organization_status']==1 || $common['usergroup']->group_id==4)){?>		<!--This is to check that if the organization is  deactivated then the particular will not show up in when logged in as Organziation Dashboard-->



<div class="main_content_outer"> 

  

<div class="content_container">

    <div class="top-title">
          <h2>Add Interest Group</h2>
          <hr class="center-diamond">
        </div>
	<div id="container_tab_content" class="container_tab_content group">

    	<div><h4 id="msg" style="color:#090;"></h4></div>

<div class="row">
		<div class="col-sm-6 interest_new_col">
			
		<img src="<?php echo base_url() ?>/assets/images/interest_new.jpg">				

		</div>

			<div class="col-sm-6">

		 <div class="form-group center-block-table org bv_group_form interest_group">
		<p>
		  <input type="hidden" id="group_id" name="group_id" value="-1" />
			<label for="grpname" class="fleft w_100">Group Name</label>
				<input  type="text" id="group_name" class="w_300" name="group_name"/>
			</p>
			<p>
			<label for="description" class="fleft w_100">Description</label>
				<textarea id="add_descgroup" name="add_desc" class="w_300"	></textarea>
			</p>


			<button onclick="save_group(<?=$common['zoneid']?>,<?=$common['organizationid']?>,3)">Save Group</button>


		</div>
</div>
       </div> 

    </div>

    

    

</div>



</div>

<?php }else if($common['organization_status']==-1 && $common['usergroup']->group_id==8)

{?>

<div class="main_content_outer"> 

  <div class="content_container">

  	<div class="container_tab_header">Add Interest Group</div>	

  	<div style="font-size:20px; line-height:25px; color:red;">Your organization is currently deactivated. Please contact your Zone Owner for more details.</div>

  </div>

</div>

<?php }?>





<!-- New functions addded on 25/6/14-->

<script type="text/javascript">

// /*$(document).ready(function () {

// 	$('#organization_ig_accordian').click();

// 	$('#organization_new_ig').addClass('active');

// });

// */

// $(document).ready(function () { 

// 	$('#adv_tools').click();

// 	$('#adv_tools').next().slideDown();

// 	$('#organization_ig_accordian').click();

// 	$('#organization_ig_accordian').next().slideDown();

// 	$('#organization_new_ig').addClass('active');

// });



// function  check_authneticate(){ //alert(1);

// 	var is_authenticated=0;

// 	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

// 		is_authenticated=data;

// 	}});	

// 	return is_authenticated;

// }



// function save_group(zoneid,createdby_id,createdby_type,group_id,group_name,add_desc){ 

// 		var authenticate=check_authneticate();

// 		if(authenticate=='0'){

// 		var zone_id = <?=$common['zoneid']?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){

// 			if($('#group_name').val()==''){

// 				alert("Please Provide Group Name");

// 				return false;

// 			}

// 			var dataToUse = {

// 				"zoneid":zoneid,

// 				"createdby_id":createdby_id,

// 				"createdby_type":createdby_type,

// 				"group_id":group_id,

// 				"group_name":group_name,

// 				"group_desc":add_desc,

// 			 };

// 			PageMethod("<?=base_url('emailnotice/save_group')?>", "Saving the new Group...<br/>This may take a few minutes", dataToUse, requestGroupSuccess, null);

// 		 }

// 	}

// 	function requestGroupSuccess(result){

// 		//alert(JSON.stringify(result));

// 		$.unblockUI();

// 		if(result.Tag!='update')

// 		{

// 			$("#group_name").val('');

// 			$('textarea#add_desc').val('');

// 		}

// 		$("#msg").html(result.Message);

// 		$('html,body').animate({scrollTop:0},"slow");

// 		setTimeout(function(){

// 		$('#msg').hide('slow');

// 		},3000);

// 	}

</script>











 







