<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />

<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />

<input type="hidden" name="orgnid" id="orgnid" value="<?=$common['organizationid']?>" />



<?php if(($common['organization_status']==1 || $common['usergroup']->group_id==4)){?>		<!--This is to check that if the organization is  deactivated then the particular will not show up in when logged in as Organziation Dashboard--><div class="main_content_outer"> 

  

<div class="content_container view_category_container">

	<?php if($common['from_zoneid']!='0'){?>


	<?php }?>


	      <div class="top-title">
        <h2>View All Categories/Sub-Categories</h2>
         <hr class="center-diamond">
      </div>

	<div id="container_tab_content" class="container_tab_content">

        

<!---------------------------------------------------------------------Help Tips------------------------------------------------------------->

				<!--<div class="container_tab_header header-default-message"  style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">

            		<div class="btn-group-2" align="left">

                    	This section will show the created Announcements.

						<a href="javascript:void(0);" class="fright" onclick="$('#helpdiv').slideToggle('slow')"><img alt="Help Tips" title="Help Tips" src="<?=base_url()?>assets/images/help.png" style="margin:3px 0 0 10px" width:"28px" height="28px"/></a>

                    </div>

            	</div>

                	-->

                <div id="helpdiv" class="container_tab_header header-default-message bv_head_wraper" margin-top:10px;>

                    <p>To edit a category click on the "Edit" button of the respective category.To view the sub-categories under a category click on category name. To edit/delete a sub-category click on the "Edit"/"Delete" button of the respective sub-category.After visiting the sub-category page if you want to go back to the category view then click on the "Back To Main Categories. "To delete a category click on the "Delete" button of the respective a category.</p>

                </div>

                

<!---------------------------------------------------------------------Help Tips------------------------------------------------------------->

        

        <div id="tabs-1_x">

        <p>

            <div id="allcategory">

                        <!--<label for="all_category" style="vertical-align:top">Category Names</label>

                        <select id="all_category" name="all_category" onchange="" >

                        </select>-->

                      <div id="test_category">

                      <input type="hidden" id="catname" value="" />

                      <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">

                      <thead id="subcatheading" style="display:none;"><tr><th id="subcatnameof"></th><th>Action</th></tr></thead>

                      <thead id="maincatheading"><tr><th align="">Category Id</th><th align="">Category Name</th><th>Action</th></tr></thead>

                      

                      <button onclick="showallCategory();" style="display:none;" id="gotoallcategory">Back To Main Categories</button>

                      

                      <tbody id="all_category"><input type="hidden" id="stayhere" value="" ></tbody></table>

                      </div>

                      <div id="more_subcategory" style="float:right;display:none;"><a id="my_subcategory_limit" class="text-default" href="javascript:void(0);" cat-data="0" onclick="showmoresubcat($(this).attr('cat-data'),this);"rel="0,0">Display more sub-categories</a></div> 

                      

                      <div id="more_category" style="float:right;display:none;"><a id="my_category_limit" class="text-default" href="javascript:void(0);" onclick="showallCategory(this);" rel="0,0">Display more categories</a> </div>                      

            </div>

       

        </p>

        </div>

        



        

    </div>

    

    

</div>



</div>

<?php }else if($common['organization_status']==-1 && $common['usergroup']->group_id==8)

{?>

<div class="main_content_outer"> 

  <div class="content_container">

  	<div class="container_tab_header">View All Category Subcategory</div>	

  	<div style="font-size:20px; line-height:25px; color:red;">Your organization is currently deactivated. Please contact your Zone Owner for more details.</div>

  </div>

</div>

<?php }?>





<script type="text/javascript">

// window.onload = function() {

//   showallCategory();

// };

// /*$(document).ready(function () { 

// 	$('#organization_category_accordian').click();

// 	$('#organization_view_category_subcategory').addClass('active');

// });

// */



// $(document).ready(function () { 

//     $('#organization_data_accordian').click();

// 	$('#organization_data_accordian').next().slideDown();

// 	$('#organization_category_accordian').click();

// 	$('#organization_category_accordian').next().slideDown();

// 	$('#organization_view_category_subcategory').addClass('active');

// });

// function  check_authneticate(){ //alert(1);

// 	var is_authenticated=0;

// 	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

// 		is_authenticated=data;

// 	}});	

// 	return is_authenticated;

// }



// 	/* Show all category*/	



// function showallCategory(tag){ 

// var authenticate=check_authneticate();

// if(authenticate=='0'){

// 		var zone_id = <?=$common['zoneid']?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){ 

//  // Added on 26/5/14 for pagination

// 	var lowerlimit=''; var upperlimit=''; 

// 	var $this=$(tag); 

// 	var limit=$this.attr('rel'); 

// 	if(limit=='' || limit==undefined){ 

// 		lowerlimit=0; upperlimit=5;

// 	}else{

// 		limit_final=limit.split(',');

// 		lowerlimit=limit_final[0]; upperlimit=limit_final[1];

// 	}

//  // Added on 26/5/14 for pagination



// 	$('#maincatheading').show();

// 	$('#gotoallcategory').hide(); 					

// 	$('#subcatheading').hide(); 					

// 	var dataToUse = {

// 		"id":$('#orgnid').val(),

// 		"lowerlimit":lowerlimit,

// 		"upperlimit":upperlimit

// 	};

											

// 	PageMethod("<?=base_url('announcements/getallcategory')?>", "Showing all Categories<br/>This may take few minutes", dataToUse, showallCategorySuccessful, null);

//  }

// }

// function showallCategorySuccessful(result){

// 	$.unblockUI();

// 	//alert(JSON.stringify(result)); 

// 	var category_no = result.Title;

// 		if(category_no>4){

// 			$('#more_category').show();

// 			$('#more_subcategory').hide();

// 		}else{

// 			$('#more_category').hide();

// 			$('#more_subcategory').hide();

// 		}

// 	var limit = result.Message; 

// 		if(result.Tag!=''){

// 			if(limit=='5,5'){ 

// 				$("#all_category").html(' ');

// 				$("#all_category").append(result.Tag);

// 			}else{ 

// 				$("#all_category").append(result.Tag);

// 			}

// 		}

// 	$('#my_category_limit').attr('rel',limit);

// }

// function getcatname(clicked_name){

// 	var str = 'Sub-Categories of ' +clicked_name;

// 	$('#subcatnameof').html(str);

// }

// function editCategoryDiv(clicked_id){

// 	 var catdata = clicked_id.split('_') ;

// 	 $('#cat_id').val(catdata[0]);

// 	 $('#cat_name').val(catdata[1]);

// 	$('.editcategory'+catdata[0]).show();

// }



// function cancelEdit(clicked_id){ 

// 	$('.editcategory'+clicked_id).hide();

// }



// /* Edit all Category */

// function editCategory(clicked_id){   

// 	if($('#cat_name'+clicked_id).val() == ''){

// 		alert('This field can not be blank'); return false;

// 	}

// 	var authenticate=check_authneticate();

// 	if(authenticate=='0'){

// 		var zone_id = <?=$common['zoneid']?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){ 

// 		var dataToUse = {

// 			"id":$('#cat_id'+clicked_id).val(),

// 			"name":$('#cat_name'+clicked_id).val()

// 		}; 											

// 		PageMethod("<?=base_url('announcements/edit_category')?>", "Processing...<br/>This may take a minute.", dataToUse, editCategorySuccessful, null);

// 	 }

// }

// function editCategorySuccessful(result){

// 	$.unblockUI();

// 	$('#editcategory').hide(); 

// 	showallCategory();									

	

// }

// /* Delete Category */

// function deleteCategory(delid){

// 	var authenticate=check_authneticate();

// 	if(authenticate=='0'){

// 		var zone_id = <?=$common['zoneid']?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){	

// 		var dataToUse = {

// 			"id":delid

// 		};

// 		PageMethod("<?=base_url('announcements/delete_category')?>", "Processing...<br/>This may take a minute.", dataToUse, deleteCategorySuccessful, null);

// 	 }

// }

// function deleteCategorySuccessful(){

// 	showallCategory();

// 	$('#maincatheading').show();

// }

// /* More sub categories*/

// function showmoresubcat(clicked_id,tag){ //alert(clicked_id);

// 	//var val=$(this).attr('cat-data'); alert('cat-data'+val);

// 	if(clicked_id == 0){

// 		showallCategory(); return false;

// 	}

// 	var authenticate=check_authneticate();

// 	if(authenticate=='0'){

// 		var zone_id = <?=$common['zoneid']?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){

// 	// Added on 26/5/14 for pagination

// 		$('#my_subcategory_limit').attr('cat-data',clicked_id);

// 		var lowerlimit = '' ; var upperlimit = '';

// 		var $this=$(tag);

// 		var limit=$this.attr('rel');

// 		if(limit=='' || limit==undefined){ 

// 			lowerlimit=0; upperlimit=5;

// 		}else{

// 			limit_final=limit.split(',');

// 			lowerlimit=limit_final[0]; upperlimit=limit_final[1];

// 		}

// 	 // Added on 26/5/14 for pagination 

// 	 	$('#subcatheading').show(); 					// edited on 27.5.14

// 		$('#gotoallcategory').show(); 					// edited on 27.5.14

// 		$('#maincatheading').hide(); 					// edited on 27.5.14

// 		$("#new_category").hide();

// 		$('#new_subcategory').hide();

// 		$('#allcategory').show();

// 		var dataToUse = {

// 			"orgid":$('#organization_id').val(),

// 			"id":clicked_id,

// 			"lowerlimit":lowerlimit,

// 			"upperlimit":upperlimit

// 		};										//console.log(dataToUse); return false;

// 		PageMethod("<?=base_url('announcements/getmoresubcategory')?>", "Showing all Sub-Categories<br/>This may take few minutes.", dataToUse, showmoresubcatSuccessful, null);

// 	 }

// }

// function showmoresubcatSuccessful(result){

// 	$.unblockUI();

// 	//alert(JSON.stringify(result));

// 	var subcategory_no = result.Title;

// 		if(subcategory_no>4){

// 			$('#more_subcategory').show();

// 			$('#more_category').hide();

// 		}else{

// 			$('#more_subcategory').hide();

// 			$('#more_category').hide();

// 		}

// 	var limit = result.Message; 

// 		if(result.Tag!=''){

// 			if(limit=='5,5'){ 

// 				$("#all_category").html(' ');

// 				$("#all_category").append(result.Tag);

// 			}else{ 

// 				$("#all_category").append(result.Tag);

// 			}

// 		}

// 	$('#my_subcategory_limit').attr('rel',limit);

// 	//$("#all_category").html(result.Tag);

// }





</script>



 

