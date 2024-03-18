<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />
<input type="hidden" name="orgnid" id="orgnid" value="<?=$common['organizationid']?>" />
<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
<?php if(($common['organization_status']==1 || $common['usergroup']->group_id==4)){?>
<div class="main_content_outer"> 
	<div class="content_container new_container_annoucement">
	<?php if($common['from_zoneid']!='0'){?>

	<?php }?>
		 <div class="top-title">
        <h2>Create Announcement</h2>
         <hr class="center-diamond">
      </div>

	<div id="container_tab_content" class="container_tab_content bv_announcement">
		<div class="col-md-6 announcement_col">
			<img src="https://cdn.savingssites.com/announcement.jpg" style="width: 100%;"/>
			<img src="https://cdn.savingssites.com/announcement_icon.png" class="announcement_icon" style=" width: 300px; margin: 10px auto; ">
		</div>
		<div class="col-md-6 announcement_col_right">
			<div id="annoucement_edit" class="form-group">
				<input type="hidden" id="announcement_id" name="announcement_id" value="-1"/>
				<input type="hidden" id="announcement_subcat_id" name="announcement_subcat_id" value="-1"/>
				<input type="hidden" class="usersubcat" value="">
				<p class="form-group-row main_cat">
					<label for="announcement_title" class="fleft w_200">Category</label>
					<select id="all_categories" name="all_categories" style="width:555px;">
						<option value="0">Select Category</option>
						<?php foreach($getall_category as $val){?>							
							<option value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
						<?php }?>
					</select>
				</p>

                

            	<p class="form-group-row">

                    <label for="announcement_title" class="fleft w_200">Title</label>

                    <input type="text" id="announcement_title" name="announcement_title" class="w_536" placeholder="Specify Announcement Name"/>

              	</p>


                 

              	<p class="form-group-row">

                    <label for="announcement_text" class="fleft w_200">Announcement Text</label>

                    <span class="fleft dis_block">

                    	<textarea id="announcement_text" name="announcement_text"></textarea>

                    </span>

                    <?php //echo display_ckeditor($ckeditor); ?>

              	</p>

                

                

                 

      

                <div class="spacer" style="display: none;"></div>

                <p class="form-group-row" style="display: none;">

                    <label for="announcement_textme" class="fleft w_200">Annoucement Textme Text<br />(100 Characters)</label>

                    <span class="fleft dis_block">

                        <textarea id="announcement_textme" name="announcement_textme" rows="3" cols="45" style="width: 536px;" maxlength="100"></textarea>

                    </span>

              	</p>

                <div class="spacer"></div>

            <button class="m_left_200" onclick="SaveAnnouncement()" style="cursor:pointer">Save</button>

        </div>

        </div>

    </div>

    

    

</div>



</div>

<?php }else if($common['organization_status']==-1 && $common['usergroup']->group_id==8)

{?>

<div class="main_content_outer"> 

  <div class="content_container">

  	<div class="container_tab_header">Create Announcement</div>	

  	<div style="font-size:20px; line-height:25px; color:red;">Your organization is currently deactivated. Please contact your Zone Owner for more details.</div>

  </div>

</div>

<?php }?>

<div class="modal fade" id="dialog" role="dialog" data-backdrop="false" style="max-width: 560px;">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h5 class="modal-title" style="margin: 7px 0;">SUCCESS</h5>

        </div>

        <div class="modal-body msg" >

      </div>

   </div>

 </div>

</div>



<script type="text/javascript">



//

/*$(document).ready(function () { 

	$('#organization_announcement_accordian').click();

	$('#organization_new_announcement').addClass('active');

});

*/



// $(document).ready(function () { 

// 	$('#adv_tools').click();

// 	$('#adv_tools').next().slideDown();

// 	$('#organization_announcement_accordian').click();

// 	$('#organization_announcement_accordian').next().slideDown();

// 	$('#organization_new_announcement').addClass('active');

// });









//



//

//var zoneid = <?=$common['zoneid']?>;

//var orgnid = <?=$common['organizationid']?>;

//



//

// function  check_authneticate(){ //alert(1);

// 	var is_authenticated=0;

// 	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

// 		is_authenticated=data;

// 	}});	

// 	return is_authenticated;

// }

//



// function show_category(){

// 	var org_id= $('#orgnid').val(); //alert(org_id);

// 	var cat_id=$('#all_categories').val(); //alert(cat_id);

// }



// +  Only announcment section exists on category, no subcatgories are here that's why we have commented this code. 



/*$(document).on('change','#all_categories',function(){ //alert($(this).val());//alert(6);  alert();

	if($(this).val() != 0){

			var org_id= $('#orgnid').val();

			var parentid= $(this).val(); //alert(org_id); alert(parentid);

			var user_subcat = $('.usersubcat').val();

			data_to_use={org_id:org_id,parentid:parentid};

			$.ajax({

				'url':"<?=base_url('announcements/show_subcategory')?>",

				'data':data_to_use,

				'dataType':'json',

				'beforeSend': function(){

					$('#subcatdiv_ann').empty();

					$('#subcatdiv_ann').hide();

					$(".main_cat").append($('<div id="loader1"><img src="'+baseurl+'assets/images/loading.gif"></div>'));

				},

				'success':function(result){ //console.log(result); 

					$("div#loader1").remove();

					if(result!=''){						

						$('#subcatdiv_ann').show();				

						var first_subcat_content='';

						first_subcat_content='<div class="ann_first_list_'+parentid+'">';					

						first_subcat_content+='<label id="sub_category_title" class="fleft w_200">Sub-Categories</label><select id="ann_allsubcatshow_'+parentid+'" class="show_subcat_ann w_536" rel="'+parentid+'">';

						first_subcat_content+='<option value="-1" rel="'+parentid+'">--Select Sub-Category--</option>'; 					

						$.each(result,function(i,j){ //console.log(j);

							//var selected=(j.id==25) ? 'selected="selected"':'';

							var selected='';

							first_subcat_content+='<option value="'+j.id+'" '+selected+'>';

							first_subcat_content+=j.name;

							first_subcat_content+='</option>'; 

						});

						first_subcat_content+='</select>'; 

						first_subcat_content+='</div>';

						first_subcat_content+='<input type="hidden" id="prev_id" value="'+parentid+'"/>';

						$('#subcatdiv_ann').empty();

						$('#subcatdiv_ann').append(first_subcat_content);

						if(user_subcat != ''){ // Set subcat value for edit announcement // edited 14.5.14

							$('#ann_allsubcatshow_'+parentid).val(user_subcat);

						}

						//$('#category').val(parentid+','); //alert(parentid); Add sub cat value(parent id)

					}else{

						$('#subcatdiv_ann'+parentid).empty();

						$('#subcatdiv_ann').show();

						$('#subcatdiv_ann').html('<h4>There are no Sub-Categories present under the selected category. Either create Sub-Categories under the selected category from the Category/Sub-Category section or select another Category. Without Sub-Categories you cannot create your announcement.</h4>');	

						//$('#category').val(''); // Add sub cat value(parent id)

					}

				}

			});

	}else{

		$("div#loader1").remove();

		$('#subcatdiv_ann').empty();

		$('#subcatdiv_ann').hide();

		//$('#category').val('');

	}

	//alert(org_id+'---'+parentid);

});*/



// -  Only announcment section exists on category, no subcatgories are here that's why we have commented this code. 



// function SaveAnnouncement(){ //alert(1); return false;

// 	var authenticate=check_authneticate();

// 	var authenticate=1;		

// 	if(authenticate=='0'){

// 		var zone_id = <?=$common['zoneid']?>;			 

// 		alert('You are currently logged out. Please log in to continue.');

// 		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			

// 	}else if(authenticate==1){

// 		 var check_subcat=1;									

// 		 var main_cat=$('#all_categories').val(); 

// 		 //var sub_cat = $('.show_subcat_ann').val();				

// 		 var str='';											

// 		/* var xyz=$('#subcatdiv_ann').html();					

// 		 if($('#subcatdiv_ann').html()=='<h4>There are no Sub-Categories present under the selected category. Either create Sub-Categories under this or select another Category. Without Sub-Categories you cannot create your announcement.</h4>'){

// 			 alert('Sub-Categories are needed to post Announcement.');

// 			 return false;

// 		 }*/

// 		 /*$.each($('#subcatdiv_ann').find('.show_subcat_ann'),function(index,val){ 

// 		 	var select_id=val.id; 

// 			var check_id=$('#'+select_id).val();

			

// 			if(check_id!='-1'){

// 				str+=check_id+',';

// 			}else{

// 				check_subcat=check_id;

// 			}

		

// 		});

// 		*/

// 		/*var cat_str=str.substring(0,str.length-1);

// 		if(cat_str!=''){

// 			var final_cat_str=main_cat+','+cat_str;

// 			var last_subcat_id=final_cat_str.split(',').pop();

// 		}else{

// 			var final_cat_str='0'; var last_subcat_id='0';

// 		}*/

// 		if(main_cat=='0'){

// 			alert('Please Select Category.');

// 			return false;

// 		}

// 		/*if(check_subcat=='-1' || main_cat=='0'){

// 			alert('Please Select Sub-Category.');

// 			return false;

// 		}

// 		if(last_subcat_id=='0'){

// 			alert("There are no Sub-Categories present under the selected category. Either create Sub-Categories under the selected category from the Category/Sub-Category section or select another Category. Without Sub-Categories you cannot create your announcement."); 

// 			return false;

// 		}*/



// 		// added the following condition for empty Sub-categpries on 20-10-14

// 		/*if($('#subcatdiv_ann').html('<h4>There are no Sub-Categories present under the selected category. Either create Sub-Categories under the selected category from the Category/Sub-Category section or select another Category. Without Sub-Categories you cannot create your announcement.</h4>')){

// 			alert("There are no Sub-Categories present under the selected category. Either create Sub-Categories under the selected category from the Category/Sub-Category section or select another Category. Without Sub-Categories you cannot create your announcement."); return false;

// 		}*/

	

// 		var dataToUse = {

// 			"id":$("#announcement_id").val(),

// 			"zone_id": $('#zoneid').val(),				//"zone_id": $("#announcement_zone").val(),

// 			"organization_id": $("#orgnid").val(),

// 			"title":$("#announcement_title").val(),

// 			"announcement_text": CKEDITOR.instances.announcement_text.getData( ),

// 			"announcement_type": $("#announcement_type").val(),

// 			"category": main_cat,

// 			"textme":$('#announcement_textme').val()

// 		};	

// 		PageMethod("<?=base_url('announcements/save_org')?>", "Saving Announcement<br/>This may take a minute.", dataToUse, announceSaveSuccessful, null);

// 	 }

}



// function announceSaveSuccessful(result) { //alert(JSON.stringify(result));

// 	$.unblockUI({onUnblock : function(){

// 		//if(result.Message != -1){

// 			$('.msg').html('<span style="color:#008000;font-weight:bold;font-size: 19px;margin-left: 35px;">Announcement has been saved successfully</span>');

// 			$("#dialog").modal("show");

// 			setTimeout(function(){

// 				window.location.reload();

// 			},3000);

// 		//}

// 	}});



// 	/*$.unblockUI();

// 	if(result.Message != -1){

// 		$('#msg').html('<h4 style="color:#090">New announcement successfully created</h4>').show();

// 		//$("#showannouncement").html(result.Tag);				// error here

// 		//$("#showannouncement")[0].reset();

// 		$('#announcement_title').val('');

// 		$('.show_subcat_ann').hide();

// 		$('#sub_category_title').hide();

// 		CKEDITOR.instances.announcement_text.setData('');

// 		$('html,body').animate({scrollTop:0},"slow");

// 			setTimeout(function(){$("#msg").hide('slow');

// 		},3000);

		

// 	}*/

}





</script>

 

