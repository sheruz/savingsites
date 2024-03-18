<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Keith
 * Date: 9/8/12
 * Time: 9:11 AM
 * To change this template use File | Settings | File Templates.
 */
?>
    <div id="accordion">
        <h3><a href="#">Business Data</a></h3>
        <div>
            <? if(!empty($my_businesses) && count($my_businesses) > 1){?>
            <label for="myBusinesses"><b>Change Business</b></label>
            <select id="myBusinesses">
                <option value="-1" selected="selected" disabled="disabled">--- Select A Business To Change To ---</option>
                <?foreach($my_businesses as $my_business){ if($my_business['id'] == $business_id) { continue;}?>
                <option value="<?=$my_business['id']?>"><?=$my_business['name']?></option>
                <?}?>
            </select>
            </br>
            <?}?>
            <div class="for-sepret-one">
                <div class="for-tex-container"><a href="#" onclick="$('#businessDataView').hide();$('#businessDataEdit').show();" class="act">Edit</a></div>
            </div>
            <div id="bp_dv">
                <?=$business_part_data_view?>
            </div>
        </div>
    <h3><a href="#">Zones</a></h3>
    <div>
        <table width="85%" class="pretty">

            <tbody>
            <?foreach($business_zones as $businessZone){ ?>
                <tr>
                    <td><label style="width:200px;float: left;"><?=$businessZone['name']?></label>  <button onclick="contactOwner(<?=$businessZone['id']?>, 2)">Contact Zone Owner</button></td>
                </tr>
            <?}?>
                <tr>
                    <td>
                        <select id="contactZone">

                            <option value="val2">-- Select zone --</option>
                            <?foreach($no_business_zones as $businessZone){?>
                            <option value="<?=$businessZone['id']?>"><?=$businessZone['name']?></option>
                            <?}?>
                        </select> <button onclick="contactOwner($('#contactZone').val(), 2);">Contact Zone Owner</button> <button onclick="$('#contactType').val(1);requestZoneAdd();return false;">Request Add To Zone</button>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <h3><a href="#">Ads</a></h3>
    <div>
        <div id="viewAds">
            <div class="for-sepret-one">
                <div class="for-tex-container"><a href="#" onclick="newAd();return false;" class="act">New Ad</a></div>
            </div>

    <div id="tableHolder">
         <?if(!empty($ad_table)){ echo($ad_table);}?>
    </div>
        </div>
        <div id="editAd">
        <?=form_open_multipart("dashboards/saveAd", "name='businesses_form22' id='businesses_form22'");?>
                <input type="hidden" id="ad_id" name="ad_id" value="-1"/>
                <input type="hidden" id="ad_business" name="ad_business" value=""/>
                
                <input type="file" id="docx" name="docx" onchange="return upload_Image('docx','<?php echo site_url("dashboards/upload_docs/docx/businesses_form22");?>','businesses_form22');"/>
				<p>Allowed  formats : (<?php echo strtoupper('docx|doc|pdf');?>)</p>
				<p>Max Size : ( 1 MB)</p>
				
				<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
				<div id="logo_image22">
					<input type="hidden" id="docs_pdf" name="docs_pdf" />
				</div>
            <input type="hidden" id="ad_id" name="ad_id" value="-1"/>
            <input type="hidden" id="ad_business" name="ad_business" value="<?=$business->id?>"/>
            <p><label for="ad_name">Name</label>
                <input type="text" id="ad_name" name="ad_name"/></p>
            <p><label for="ad_code">Offer Code</label>
                <input type="text" id="ad_code" name="ad_code"/></p>
            <!-- <p><label for="ad_starttime">Start Time</label>
                <input type="text" id="ad_starttime" name="ad_starttime"/></p>
            <p><label for="ad_stoptime">Stop Time</label>
                <input type="text" id="ad_stoptime" name="ad_stoptime"/></p> -->
                
             <!-- date time custom -->
	        <p><label for="ad_startdatetime">Start Date Time</label>
	        <input type="text" id="ad_startdatetime" name="ad_startdatetime"/></p>
	        
	        <p><label for="ad_stopdatetime">Stop Date Time</label>
	        <input type="text" id="ad_stopdatetime" name="ad_stopdatetime"/></p>
	        <!-- date time custom -->    
                
            <p><label" for="ad_category">Category</label>
                <select id="ad_category" name="ad_category">
                    <?foreach ($category_list as $category) {
                    echo("<option value='" . $category['id'] . "'>" . $category['name'] . "</option>");
                }
                    ?>

                </select></p>
            <p><label for="ad_text">Ad Text</label>
                <textarea id="ad_text" name="ad_text"></textarea>
                <?php echo display_ckeditor($ckeditor); ?>

            </p>
            <p><label for="text_message">Text Message</label>
                <textarea rows="10" cols="45" style="width: 425px; height: 150px" id="text_message" name="text_message"></textarea>
            </p>
            <?=form_close()?>
            <div class="for-sepret-one">
                <div class="for-tex-container"><a href="#" onclick="SaveAd();return false;" class="act">Save</a></div>
                <div class="for-tex-container"><a href="#" onclick="CancelAdEdit();return false;" class="act">Cancel</a></div>
            </div>
        </div>
    </div>
    <h3><a href="#">Locations</a></h3>
        <div>
        <button onclick="newLocation();">New</button><br />
        <div id="locations">
            <?if(!empty($business_part_location_view)){ echo($business_part_location_view);}?>
        </div>
    </div>
    <h3><a href="#">Job Offers</a></h3>
        <div>
            <div id="job_view">
                <div class="for-sepret-one">
                    <div class="for-tex-container"><a href="#" onclick="NewJob();return false;" class="act">New Job</a></div>
                </div>
                <div id="job_container">
                    <?=empty($jobs) ? "Coming Soon" : $jobs;?>
                    <!--<input type="image" src="<?=base_url('assets/images/Actions-job-offer.png')?>" title="Click for Information On Job : {Job Title}"/>-->
                </div>
            </div>
            <div id="job_edit">
                <input type="hidden" id="job_id"/>
                <label for="job_title">Title</label><input type="text" id="job_title"><br/>
                <label for="offer_start_date">Offer Start Date</label><input type="text" id="offer_start_date"><br/>
                <label for="salary_range">Salary Range</label><input type="text" id="salary_range"><br/>
                <label for="job_description">Description</label><br/>
                <textarea id="job_description" name="job_description"></textarea>
                <?php echo display_ckeditor($ckeditor_jd); ?><br/>
                <div class="for-sepret-one">
                    <div class="for-tex-container"><a href="#" onclick="SaveJob();return false;" class="act">Save</a></div>
                    <div class="for-tex-container"><a href="#" onclick="CancelJobEdit();return false;" class="act">Cancel</a></div>
                </div>
            </div>
        </div>
    <h3><a href="#">Short Notice Email</a></h3>
    <div>
        <div id="snap_div">
        	<?if(!empty($snap)){ echo($snap);}?>
        </div>
    </div>
</div>

    <div id="contactOwnerDialog">
        Please Enter Message for Zone Owner:<br/>
        <input type="hidden" id="contactType" name="contactType" value="1"/>
        <input type="hidden" id="business_zone" name="business_zone" value="1"/>
        <textarea rows="10" cols="40" id="sendMessage"></textarea><br/>
        <button onclick="performContactZoneOwner($('#contactZone').val(), $('#sendMessage').val(), <?=$business->id?>);$('#contactOwnerDialog').dialog('close');">
        Ok
        </button>
        <button onclick="$('#contactOwnerDialog').dialog('close');">Cancel</button>
    </div>
<script type="text/javascript" src="<?=base_url('assets/ckeditor/adapters/jquery.js')?>"></script>
<script type="text/javascript">
	
	function get_template_content(id)
	{
		$.post("<?=base_url('dashboards/get_template_content')?>/" + id, '',
				function(data) {
						var template = data.split('####');
						$("#template_subject").val(template[0]);
						CKEDITOR.instances.template_content.setData( template[1] );
		});
	}
	function set_category(id)
	{
		$.post("<?=base_url('dashboards/set_category')?>/"+id, '',
				function(data) {
					$("#snap_div").html(data);
					if(CKEDITOR.instances['template_content'])
				    {
				    	CKEDITOR.instances['template_content'].destroy();
				    }
					if(CKEDITOR.instances['addtemplate_content'])
				    {
				    	CKEDITOR.instances['addtemplate_content'].destroy();
				    }
		});
	}
	
	function save_category()
	{
		var dataToUse = {
				"business_category": $("#business_category_select").val(),
				"bus_id":$("#hidden_bus_id").val()
		    };

		$.post("<?=base_url('dashboards/save_category')?>/", dataToUse,
				function(data) {
					$("#snap_div").html(data);
					if(CKEDITOR.instances['template_content'])
				    {
				    	CKEDITOR.instances['template_content'].destroy();
				    }
					if(CKEDITOR.instances['addtemplate_content'])
				    {
				    	CKEDITOR.instances['addtemplate_content'].destroy();
				    }
		});
	}
	
	function Deletehostory(id, title,bus_id){

		$.post("<?=base_url('dashboards/deletehostory')?>/"+id, { "id": id,"bus_id":bus_id },
				function(data) {
					$("#snap_div").html(data);
					if(CKEDITOR.instances['template_content'])
				    {
				    	CKEDITOR.instances['template_content'].destroy();
				    }
					if(CKEDITOR.instances['addtemplate_content'])
				    {
				    	CKEDITOR.instances['addtemplate_content'].destroy();
				    }
		});
	}
	function resend_email(id){
		
		var hidden_bus_id=$("#hidden_bus_id").val();
		
		$.post("<?=base_url('dashboards/set_subscriber_resend')?>/"+hidden_bus_id+"/"+id, '',
				function(data) {
					$("#snap_div").html(data);
					if(CKEDITOR.instances['addtemplate_content'])
				    {
				    	CKEDITOR.instances['addtemplate_content'].destroy();
				    }
		});
	}
	function get_history(bus_id)
	{
		$.post("<?=base_url('dashboards/get_history')?>/"+bus_id, '',
				function(data) {
					$("#snap_div").html(data);
		});
	}
                    
	function Edittemplate(id){
		var dataToUse = {
		        "bus_id":$("#hidden_bus_id").val()
		};
		$.post("<?=base_url('dashboards/json_business_type')?>/"+id, dataToUse,
				function(data) {
					$("#snap_div").html(data);
					if(CKEDITOR.instances['template_content'])
				    {
				    	CKEDITOR.instances['template_content'].destroy();
				    }
		});
	}

	function Deletetemplate(id, title,bus_id){
		$.post("<?=base_url('dashboards/delete_template')?>/"+id, { "id": id,"bus_id":bus_id },
				function(data) {
					$("#snap_div").html(data);
					if(CKEDITOR.instances['template_content'])
				    {
				    	CKEDITOR.instances['template_content'].destroy();
				    }
					if(CKEDITOR.instances['addtemplate_content'])
				    {
				    	CKEDITOR.instances['addtemplate_content'].destroy();
				    }
		});
	}
                  
	function save_template(status)
	{
		var hidden_temp_id = $("#hidden_temp_id").val();
		var dataToUse = {
				"id":$("#hidden_temp_id").val(),
				"status":status,
		        "bus_id":$("#hidden_bus_id").val(),
		        "template_subject":$("#template_subject").val(),
		        "addtemplate_content":CKEDITOR.instances.addtemplate_content.getData()
		};
		if(status==1)
		{
			if(hidden_temp_id>0)
			{
				$.post("<?=base_url('dashboards/save_template_edit')?>/"+hidden_bus_id, dataToUse,
						function(data) {
							$("#snap_div").html(data);
							if(CKEDITOR.instances['template_content'])
						    {
						    	CKEDITOR.instances['template_content'].destroy();
						    }
				});
				//PageMethod("business_dashboard/save_template_edit", "Saving Template<br/>This may take a minute.", dataToUse, set_subscriber_edit, null);
			}else{
				$.post("<?=base_url('dashboards/save_template')?>/", dataToUse,
						function(data) {
							$("#snap_div").html(data);
							 if(CKEDITOR.instances['addtemplate_content'])
							    {
							    	CKEDITOR.instances['addtemplate_content'].destroy();
							    }
				});
			}
		}else{
			$.post("<?=base_url('dashboards/save_template')?>/", dataToUse,
					function(data) {
						$("#snap_div").html(data);
						 if(CKEDITOR.instances['addtemplate_content'])
						    {
						    	CKEDITOR.instances['addtemplate_content'].destroy();
						    }
			});
		}
		
	}
                    
	function newtemplate()
	{
		var hidden_bus_id=$("#hidden_bus_id").val();
		$.post("<?=base_url('dashboards/newtemplate')?>/"+hidden_bus_id, '',
				function(data) {
					$("#snap_div").html(data);
					if(CKEDITOR.instances['template_content'])
				    {
				    	CKEDITOR.instances['template_content'].destroy();
				    }
		});
	}
	function get_template(bus_id)
	{
		$.post("<?=base_url('dashboards/get_template')?>/"+bus_id, '',
				function(data) {
					$("#snap_div").html(data);
					
				    if(CKEDITOR.instances['template_content'])
				    {
				    	CKEDITOR.instances['template_content'].destroy();
				    }
				    if(CKEDITOR.instances['addtemplate_content'])
				    {
				    	CKEDITOR.instances['addtemplate_content'].destroy();
				    }
		});
	}
	
	function send_email()
	{
		checkboxes = document.getElementById("check_all").checked;//get main check box
		if(checkboxes)
		{
			check_all=1;
		}else{
			check_all=0;
		}
		
		    var dataToUse = {
		    "resend":$("#resend").val(),
		    "check_all":check_all,
			"bus_id":$("#hidden_bus_id").val(),
			"subscriber":$("#subscriber").val(),
			"template":$("#template").val(),
			"template_subject":$("#template_subject").val(),
			"template_content":CKEDITOR.instances.template_content.getData()
	    };

		    $.post("<?=base_url('dashboards/send_email')?>", dataToUse,
					function(data) {
						$("#snap_div").html(data);
						if(CKEDITOR.instances['template_content'])
					    {
					    	CKEDITOR.instances['template_content'].destroy();
					    }
					    if(CKEDITOR.instances['addtemplate_content'])
					    {
					    	CKEDITOR.instances['addtemplate_content'].destroy();
					    }
			});
	}
	function get_subscriber(bus_id,page)
	{
		
		if(bus_id!=0){
			$.post("<?=base_url('dashboards/get_subscriber')?>/"+bus_id, {"page":page},
				function(data) {
					$("#snap_div").html(data);
					if(CKEDITOR.instances['template_content'])
				    {
				    	CKEDITOR.instances['template_content'].destroy();
				    }
				    if(CKEDITOR.instances['addtemplate_content'])
				    {
				    	CKEDITOR.instances['addtemplate_content'].destroy();
				    }
			});
		}else{
			return true;
		}
	}
	function set_subscriber(hidden_bus_id)
	{
		if(hidden_bus_id==''){
			var hidden_bus_id=$("#hidden_bus_id").val();
		}
		
		$.post("<?=base_url('dashboards/set_subscriber')?>/"+hidden_bus_id, '',
				function(data) {
					$("#snap_div").html(data);
					
				    if(CKEDITOR.instances['addtemplate_content'])
				    {
				    	CKEDITOR.instances['addtemplate_content'].destroy();
				    }
		});
	}
	
    $("#contactOwnerDialog").dialog({autoOpen : false, modal: true, width:500});
    $("#businessDataEdit").hide();

    $('#example').dataTable( {
        "bPaginate": false
    } );
    $("#location_view table").dataTable( {
        "bPaginate": false
    } );
    $( "#accordion" ).accordion({autoHeight : false});
    //$("#ad_text").ckeditor();
    $("#editAd").hide();
    $("#businessDataEdit label").css("display", "block");
    $("#businessDataEdit label").css("float", "left");
    $("#businessDataEdit label").css("width", "150px");
    $("#businessDataEdit input").width("300");

    $("#locationEditor label").css("display", "block");
    $("#locationEditor label").css("float", "left");
    $("#locationEditor label").css("width", "150px");
    $("#locationEditor input").width("300");
    $("#locationEditor").hide();

    function deleteAd(id, name){
        var data = { id : id, business_id : <?=$business->id?>};
        ConfirmDialog("Really remove : " + name + "?", "Remove Ad", "<?=base_url('dashboards/deleteAd')?>",
                "Removing Ad<br/>This may take a minute", data, adsSaveSuccessful, null);

        PageMethod("<?=base_url('dashboards/saveAd')?>", "Saving Ad<br/>This may take a minute.", dataToUse, adsSaveSuccessful, null);

    }
    function newAd() {
        $("#ad_id").val("-1");
        $("#ad_name").val("");
        $("#ad_code").val("");
        $("#ad_startdatetime").val('');
        $("#ad_stopdatetime").val('');
        $("#ad_category").val("0");
        CKEDITOR.instances.ad_text.setData( "Your Ad Here!" );
        $("#text_message").val("");
        $("#viewAds").hide();
        $("#editAd").show();

        $( "#ad_startdatetime, #ad_stopdatetime" ).datetimepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:'yy-mm-dd'
		});
    }

    function CancelAdEdit(){
        $("#editAd").hide();
        $("#viewAds").show();
    }
    function SaveAd(){

    	var ad_startdatetime = Date.parse($("#ad_startdatetime").val());
    	var ad_stopdatetime = Date.parse($("#ad_stopdatetime").val());

    	if(ad_startdatetime==null || ad_stopdatetime==null)
    	{
    		alert('please insert start date and stop date');
    		return false;
    	}
    	
    	if(ad_startdatetime.compareTo(ad_stopdatetime)>=0)
    	{
    		alert('please insert start date small than stop date');
    		return false;
    	}
        
        var dataToUse = {
            "id":$("#ad_id").val(),
            "docs_pdf":$("#docs_pdf").val(),
            "offer_code" : $("#ad_code").val(),
            "name":$("#ad_name").val(),
            "ad_stopdatetime":$("#ad_stopdatetime").val(),
            "ad_startdatetime":$("#ad_startdatetime").val(),
            "business_id": <?=$business->id?>,
            "adtext": CKEDITOR.instances.ad_text.getData(),
            "category_id": $("#ad_category").val(),
            "active" : "1",
            "text_message": $("#text_message").val()
        };

        PageMethod("<?=base_url('dashboards/saveAd')?>", "Saving Ad<br/>This may take a minute.", dataToUse, adsSaveSuccessful, null);

    }
    function adsSaveSuccessful(result) {
        $.unblockUI();
        $("#tableHolder").html(result.Tag);
        CancelAdEdit();
        $('#tableHolder table').dataTable({
            "bPaginate": false
        });



    }
    function editAd(adId)
    {
        PageMethod("<?=base_url('ads/get/')?>" +  "/" + adId, "", null, ShowAdEdit, null);
    }
    function ShowAdEdit(result) {
        $.unblockUI();
        $("#ad_id").val(result.id);
        $("#ad_name").val(result.name);
        $("#ad_code").val(result.offer_code);
        $("#ad_business").val(result.business_id);
        $("#ad_category").val(result.category_id);
        $("#ad_startdatetime").val(result.startdatetime);
        $("#ad_stopdatetime").val(result.stopdatetime);
        $("#text_message").val(result.text_message);
        CKEDITOR.instances.ad_text.setData( result.adtext );
        $("#viewAds").hide();
        $("#editAd").show();
        $( "#ad_startdatetime, #ad_stopdatetime" ).datetimepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:'yy-mm-dd'
		});

    }
    function contactOwner(zoneId, contactType)
    {
        $('#contactType').val(contactType);
        $("#business_zone").val(zoneId);
        $('#contactOwnerDialog').dialog('open');
    }
    function newLocation(){
        $("#loc_id").val("-1");
        $("#loc_address_id").val("-1");
        $("#loc_name").val("");
        $("#loc_ident").val("");
        $("#loc_contact_email").val("");
        $("#loc_contactfirstname").val("");
        $("#loc_contactlastname").val("");
        $("#loc_state").val("");
        $("#loc_street_1").val("");
        $("#loc_street_2").val("");
        $("#loc_city").val("");
        $("#loc_zip_code").val("");
        $("#loc_phone").val("");
        $("#loc_website").val("");
        ShowBranchEdit();
    }
    function ShowBranchEdit(){
        $("#locationEditor").show();
        $("#location_view").hide();
    }
    function saveBranchInfo(){
        
     var data = {
        id : $("#loc_id").val(),
        addressid : $("#loc_address_id").val(),
        business_id : <?=$business->id?>,
        name: $("#loc_name").val(),
        ident : $("#loc_ident").val(),
         state : $("#loc_state").val(),
        street1 : $("#loc_street_1").val(),
        street2 : $("#loc_street_2").val(),
        city : $("#loc_city").val(),
        zipcode : $("#loc_zip_code").val(),
        phone : $("#loc_phone").val()
    };
    PageMethod("<?=base_url('dashboards/saveBranch')?>", "Saving Branch Data<br/>This may take a few minutes", data, BranchSaveSuccessful, null);
    }
	
	function create_bus_owner(user)
	{
		if(user<0)
		{
			document.getElementById('new_user_detail').style.display='block';
			$("#biz_owner_id").val(-1);
		}else{
			document.getElementById('new_user_detail').style.display='none';
			$("#biz_owner_id").val(user);
		}
	}
	
    function saveBusinessInfo(){
        var data = {
            id : "<?=$business->id?>",
			logo : $("#logo").val(),
            addressid : $("#biz_address_id").val(),
            name: $("#biz_name").val(),
            contactemail : $("#biz_contact_email").val(),
            contactfirstname : $("#biz_contactfirstname").val(),
            contactlastname : $("#biz_contactlastname").val(),
            business_owner_id : $("#biz_owner_id").val(),
            state : $("#biz_state").val(),
            street1 : $("#biz_street_1").val(),
            street2 : $("#biz_street_2").val(),
            city : $("#biz_city").val(),
            zipcode : $("#biz_zip_code").val(),
            phone : $("#biz_phone").val(),
            website : $("#biz_website").val(),
			username : $("#userName").val(),
            password : $("#password").val()
        };
        PageMethod("<?=base_url('dashboards/saveBusiness')?>", "Saving Business Data<br/>This may take a few minutes", data, BizSaveSuccessful, null);

    }

    function EditLocation(id)
    {
        var data = {id : id};
        PageMethod("<?=base_url('dashboards/LoadLocation')?>", "Getting Location Data<br/>This may take a few minutes", data, LocationLoadSuccessful, null);

    }
    function LocationLoadSuccessful(result)
    {
        $.unblockUI();
        $("#loc_id").val(result.id);
        $("#loc_address_id").val(result.address_id);
        $("#loc_name").val(result.branch_name);
        $("#loc_ident").val(result.branch_identifier);
        $("#loc_state").val(result.state);
        $("#loc_street_1").val(result.street_address_1);
        $("#loc_street_2").val(result.street_address_2);
        $("#loc_city").val(result.city);
        $("#loc_zip_code").val(result.zip_code);
        $("#loc_phone").val(result.phone);
        ShowBranchEdit();
    }
    function RemoveLocation(id, name)
    {
        var data = { id : id, business_id : <?=$business->id?>};
        ConfirmDialog("Really remove : " + name + "?", "Remove Branch", "<?=base_url('dashboards/RemoveLocation')?>",
                "Removing Location<br/>This may take a minute", data, BranchSaveSuccessful, null);
    }
    function BranchSaveSuccessful(result)
    {
        $("#locations").html(result.Tag);
        $("#locations table").dataTable( {
            "bPaginate": false
        } );
        $("#locationEditor").hide();
        $.unblockUI();
    }
    function BizSaveSuccessful(result)
    {
        $("#bp_dv").html(result.Tag);
        $("#businessDataEdit").hide();
        $.unblockUI();

    }
    function requestZoneAdd()
    {
        performContactZoneOwner($("#contactZone").val(), "Test", <?=$business->id?>, "none");
    }

    function performContactZoneOwner(zoneId, message, businessId, fromEmail)
    {
        message = $("#sendMessage").val();
        var ct = $("#contactType").val();
        if(ct == 2){
            zoneId = $("#business_zone").val();
        }
        var data = { zoneId: zoneId,
                 message : message,
                 businessId : businessId,
                 from : fromEmail,
                 contactType : $("#contactType").val()
        };

        PageMethod("<?=base_url('dashboards/contactZoneOwner')?>", "Contacting Zone Owner", data, null, null);
    }

    <? if(!empty($my_businesses) && count($my_businesses) > 1){?>
    $("#myBusinesses").change(function(){
        var zid = $(this).val();
        if(zid == -1){return;}
        window.location.href = "<?=base_url('dashboards/business')?>/" + zid;
    });
        <?}?>

</script>
<!-- Job Edit Begin -->
<script type="text/javascript">
    $("#job_edit").hide();

    function NewJob()
    {
        var d = new Date();
        var curr_date = d.getDate();
        var curr_month = d.getMonth();
        curr_month++;
        var curr_year = d.getFullYear();

        var result = {
            Tag : {
                id : "-1",
                title : "new job",
                salary_range : "$0-$10 / hour",
                start_date : curr_year + "-" + curr_month + "-" + curr_date
            }
        };
        BindJob(result);
    }

    function BindJob(result)
    {

        var job = result.Tag;
        $("#job_edit label").css("display", "block");
        $("#job_edit label").css("float", "left");
        $("#job_edit label").css("width", "150px");
        $("#job_edit input").width("300");

        $("#offer_start_date").val(job.start_date);
        $( "#offer_start_date" ).datepicker({
            changeMonth: true,
            numberOfMonths: 3,
            altFormat: "yy-mm-dd",
            dateFormat: "yy-mm-dd"
        });
        $("#job_id").val(job.id);
        $("#job_title").val(job.title);
        $("#salary_range").val(job.salary_range);
        $("#job_view").hide();
        $("#job_edit").show();
    }
    function EditJob(jobId)
    {
        var data = { id : jobId , business_id : <?=$business->id?> };
        PageMethod("<?=base_url('dashboards/loadJob')?>", "Loading Job To Edit", data, BindJob, null);

    }

    function DeleteJob(jobId, jobTitle)
    {
        var data = { id : jobId , business_id : <?=$business->id?> };
        ConfirmDialog("Really remove : " + jobTitle + "?", "Remove Job", "<?=base_url('dashboards/RemoveJob')?>",
                "Removing Job<br/>This may take a minute", data, JobSaveCompleted, null);

    }
    function SaveJob()
    {
        var data = {
            id : $("#job_id").val(),
            business_id : <?=$business->id?>,
            title : $("#job_title").val(),
            start_date : $("#offer_start_date").val(),
            salary_range : $("#salary_range").val(),
            description : CKEDITOR.instances.job_description.getData( )
        };

        PageMethod("<?=base_url('dashboards/saveJob')?>", "Contacting Zone Owner", data, JobSaveCompleted, null);

    }

    function JobSaveCompleted(result){
        $.unblockUI();
        $("#job_container").html(result.Tag);
        CancelJobEdit();
    }

    function CancelJobEdit()
    {
        $("#job_view").show();
        $("#job_edit").hide();
    }

</script>

<!-- Job Edit End -->