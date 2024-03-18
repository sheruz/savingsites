<style xmlns="http://www.w3.org/1999/html">
    fieldset { border:1px solid green }
    legend {
        padding: 0.2em 0.5em;
        border:1px solid green;
        color:green;
        font-size:90%;
        text-align:right;
    }
</style>
<div id="main-header" class="main-header" >
    <div id="accordion">
        <h3><a href="#">Zone Data</a></h3>
        <div>
        <?if(empty($zone_manager)){?><input type="image" src="<?=base_url('assets/images/Actions-edit-rename-icon.png')?>" onclick="editName();return false;" title="Rename Zone" value="Rename Zone" class="img22 mb10"/><input type="image" src="<?=base_url('assets/images/Actions-shazam-icon.png')?>" onclick="newZone();return false;" title="Create Zone" value="Create Zone" class="img22 mb10"/>
            <span id="zoneNameEditButtons"><input type="image" src="<?=base_url('assets/images/Button-Save-icon.png')?>" onclick="saveZoneName();return false;" title="Rename Zone" value="Rename Zone" class="img22 mb10"/><input type="image" src="<?=base_url('assets/images/Button-Cancel-icon.png')?>" onclick="cancelEditName();return false;" title="Cancel Edit" value="Cancel Edit" class="img22 mb10"/></span>
            <br />
            <?}?>
        <? if(!empty($my_zones) && count($my_zones) > 1){?>
                <label for="myZones"><b>Change Zone</b></label>
                <select id="myZones">
                    <option value="-1" selected="selected" disabled="disabled">--- Select A Zone To Change To ---</option>
                    <?foreach($my_zones as $my_zone){ if($my_zone['id'] == $zone_id) { continue;}?>
                    <option value="<?=$my_zone['id']?>"><?=$my_zone['name']?></option>
                    <?}?>
                </select>
                </br>
            <?}?>
            <div id="zoneData">
            <b>Zone Name</b>: <span id="zoneNameDisplay"><?=$zone->name?></span> <span id="zoneNameEdit"><input type="text" id="zoneName" value="<?=$zone->name?>"/></span><br />
            <b>Zone Owner</b>: <?= $zone_owner->last_name ?> , <?= $zone_owner->first_name?><br />
            <?if(!empty($top_stats)){?>
            <b>Total Businesses</b>: <?=$top_stats->totalBusinesses?><br/>
            <b>Total Ads</b>: <?=$top_stats->totalAds?><br/>
            <b>Total SNAP Subscribers</b>: Coming Soon<br/>
            <?}?>
            <b>Zone Url (raw)</b>: <a target="_blank" href="http://www.savingssites.com/welcome/index/<?=$zone->id?>">http://www.savingssites.com/welcome/index/<?=$zone->id?></a><br />
            <b>Zone Url (pretty)</b>: <a target="_blank" href="http://www.savingssites.com/zone/load/<?=$zone->name?>">www.savingssites.com/zone/load/<?=$zone->name?></a><br />
            <b>Zone Url (pretty 2)</b>: <a target="_blank" href="http://www.savingssites.com/zone/load/<?=$zone->id?>">www.savingssites.com/zone/load/<?=$zone->id?></a><br />
            </div>
            <!--
            Template :

            <select>

                <option value="value">--- Default ---</option>

                <option value="Sup">Super Skin $1</option>

            </select>
            -->
    </div>
    <?if(empty($zone_manager)){?>
    <h3><a href="#">Category List</a></h3>
        <div>
            <b>Category Display:</b><span id="categoryDisplayDisplay"><span id="cdDisplay"></span>
            <input type="image" src="<?=base_url('assets/images/Actions-edit-rename-icon.png')?>" class="img16" title="Edit" onclick="showCategoryEdit();"/> </span>
            <span id="categoryDisplayEdit"><select  id="cat_option" name="cat_option" >
            <option value="0">Only Show Categories for Ads I have</option>
            <option value="1">Show All Categories</option>
            <option value="2">Show All Categories except those I exclude</option>
        </select><br/>
                <div id="categoryDisplayList">
                <?=empty($category_edit) ? "" : $category_edit?>
                </div>
                <br/>
                <input type="image" src="<?=base_url('assets/images/Button-Save-icon.png')?>" onclick="saveCategoryEdit();return false;" title="Rename Zone" value="Rename Zone" class="img22 mb10"/><input type="image" src="<?=base_url('assets/images/Button-Cancel-icon.png')?>" onclick="cancelCategoryEdit();return false;" title="Cancel Edit" value="Cancel Edit" class="img22 mb10"/></span>

        </div>
    <h3><a href="#">Zip Codes</a></h3>
        <div>
            <button onclick="window.location.href='<?=base_url('welcome/claim_zips')?>';" title="Claim Zips">Claim Zips</button><br/>
            <div id="zip_codes" style="background-color: #808080;">
            <select id="zipToAdd">
                <? foreach($not_zip_codes as $zip){?>
                <option value="<?=$zip['ZIP5']?>"><?=$zip['ZIP5']?>(<?=$zip['City']?>)</option>
            <?}?>
            </select>
            <input type="image" class="img16" src="<?=base_url('assets/images/Button-Add-icon.png')?>" onclick="addZipToZone(<?=$zone->id?>);return false;"/><br />

            <table width="100%">
                <? $i = 0;
                foreach($zip_codes as $zip){
                    if($i == 3) { echo("</tr>"); $i = 0;}
                    if($i == 0) { echo("<tr>");}
                    $i += 1;
                    ?>
                    <td><?=$zip['ZIP5']?>(<?=$zip['City']?>)<input type="image" class="img14" src="<?=base_url('assets/images/Actions-edit-delete-icon.png')?>" onclick="removeZipFromZone('<?=$zip['ZIP5']?>', <?=$zone->id?>,'<?=$zip['ZIP5']?>(<?=$zip['City']?>)' );return false;"/> </td>
                    <?}?>
                </tr>
            </table>
       </div>
        </div>
    <?}?>
<h3><a href="#">Statistics</a></h3>
<div>
    <div id="show_stats">
        <?if(!empty($statistics)){echo($statistics);}else{?>
        Coming Soon<?}?>
    </div>
</div>
        <h3><a href="#" id="business_label">Businesses (<?=count($businesses)?>)</a></h3>
        <div>
            <div id ="business_view" style="background-color: #808080;">
            <ul style="list-style-type: none;">
                <?if(!empty($businesses)){
                foreach($businesses as $business){
                    ?>
                    <li><?=$business['name']?> (<?=$business['ad_count']?> ads) <input type="image" class="img14" src="<?=base_url('assets/images/Actions-document-preview-icon.png')?>" onclick="showAds(<?=$business['biz_id']?>);return false;" value="View Ads" title="View Ads"/> <input type="image" src="<?=base_url('assets/images/Actions-edit-delete-icon.png')?>" onclick="removeBusinessFromZone(<?=$business['biz_id']?>,<?=$zone->id?>,'<?=str_replace('\'','\\\'',$business['name'])?>');return false;" class="img14" title="Remove Business"/></li>
                    <?}
            }?>
            </ul>

            Add Business

            <select id="biz_toAdd">

                <option value="-1" selected="selected">-- New Business --</option>

                <optgroup label="Unassigned Businesses">
                    <?foreach($missing_businesses as $business){?>
                    <option value="<?=$business['id']?>"><?=$business['name']?></option>
                    <?}?>
                </optgroup>

            </select>             <input type="image" class="img16" src="<?=base_url('assets/images/Button-Add-icon.png')?>" onclick="addBusinessToZone(<?=$zone->id?>);return false;" title="Add Business"/>

            </div>
            <div id="businessEdit" style="background-color: #808080;">
                <h2>Add New Business</h2>
                <?if(!empty($create_a_business)){ echo($create_a_business);}?>
            </div>
        <div id="ads_view">
            <button onclick="newAd()">New Ad</button>
            <div id="show_ads"></div>
        </div>
            <div id="editAd">
                <input type="hidden" id="ad_id" name="ad_id" value="-1"/>
                <input type="hidden" id="ad_business" name="ad_business" value=""/>
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
                    <?php echo display_ckeditor($ckeditor_2); ?>

                </p>
                <p><label for="text_message">Text Message</label>
	                <textarea rows="10" cols="45" style="width: 425px; height: 150px" id="text_message" name="text_message"></textarea>
	            </p>
                <button onclick="SaveAd()">Save</button><button onclick="CancelAdEdit()">Cancel</button>
            </div>

            <div id="ads_view_buttons">
            <button onclick="CancelAdEdit()">Back To Businesses...</button>
        </div>

        </div>

    <h3><a href="#">Announcements</a></h3>
    <div>

    <div id="announcements">
        <button onclick="newAnnouncement();">New</button>
        <div id="announce_table_holder">
        <?if(!empty($announcement_table)){ echo($announcement_table);}?>
        </div>
    </div>
        <div id="annoucement_edit">
            <input type="hidden" id="announcement_id" name="announcement_id" value="-1"/>
            <input type="hidden" id="announcement_zone" name="announcement_zone" value="<?=$zone->id?>"/>
            <p><label for="announcement_title">Title</label>
                <input type="text" id="announcement_title" name="announcement_title"/></p>
            <p><label for="announcement_text">Annoucement Text</label>
                <textarea id="announcement_text" name="announcement_text"></textarea>
                <?php echo display_ckeditor($ckeditor); ?>

            </p>
            <button onclick="SaveAnnouncement()">Save</button><button onclick="HideAnnouncementEditor()">Back To Annoucements</button>
        </div>
    </div>

    <h3><a href="#">Zone Managers</a></h3>
    <div>
        <div id="zone_manager_list">
            <?if(!empty($zone_manager_list)){echo($zone_manager_list);}?>
        </div>
    </div>


</div>


</div>

<script type="text/javascript">
    var default_zone = <?=$zone->id?>;
    var temp_zone_id = <?=$zone->id?>;

    function newZone(){
        $("#zoneNameEdit").show();
        $("#zoneNameDisplay").hide();
        $("#zoneNameEditButtons").show();
        $("#zoneName").val("");
        zone_id = -1;

    }

    <? if(!empty($my_zones) && count($my_zones) > 1){?>
    $("#myZones").change(function(){
        var zid = $(this).val();
        if(zid == -1){return;}
        window.location.href = "<?=base_url('dashboards/zone')?>/" + zid;
        });
    <?}?>

</script>
<script type="text/javascript">
    function ShowAnnouncementEdit(result) {
        $.unblockUI();
        ShowAnnouncementEditor();
        $("#announcement_id").val(result.id);
        $("#announcement_title").val(result.title);
        CKEDITOR.instances.announcement_text.setData( result.announcement_text );
    }

    function SaveAnnouncement(){
        var dataToUse = {
            "id":$("#announcement_id").val(),
            "title":$("#announcement_title").val(),
            "zone_id": $("#announcement_zone").val(),
            "announcement_text": CKEDITOR.instances.announcement_text.getData( )
    };

        PageMethod("<?=base_url('announcements/save')?>", "Saving Announcement<br/>This may take a minute.", dataToUse, announceSaveSuccessful, null);
    }

    function announceSaveSuccessful(result) {
        $.unblockUI();
        $("#announce_table_holder").html(result.Tag);
        $("#announce_table_holder table").dataTable({ "bPaginate" : false});
        HideAnnouncementEditor();
    }

    function newAnnouncement    () {
        $("#announcement_id").val("-1");
        $("#announcement_title").val("");
        CKEDITOR.instances.announcement_text.setData( "Your Announcement Here!" );
        ShowAnnouncementEditor();
    }

    function EditAnnouncement(id)
    {
        $("ad_business").val(id);
        PageMethod("<?=base_url('announcements/get')?>" + "/" + id, "", null, ShowAnnouncementEdit, null);
    }

    function ShowAnnouncementEditor()
    {
        $("#annoucement_edit").show();
        $("#announcements").hide();
    }
    function HideAnnouncementEditor(){
        $("#annoucement_edit").hide();
        $("#announcements").show();
    }

    function DeleteAnnouncement(id, title) {
        ConfirmDialog("Really delete : " + title, "Delete Announcement", "<?=base_url('announcements/delete')?>", "Deleting Announcement<br/>This may take a minute",
                { "id": id }, announceSaveSuccessful, null);
    }
</script>
<script type="text/javascript">
    function deleteAd(id, name){
        var data = { id : id, business_id : $("#ad_business").val()};
        ConfirmDialog("Really remove : " + name + "?", "Remove Ad", "<?=base_url('dashboards/deleteAd')?>",
                "Removing Ad<br/>This may take a minute", data, adsSaveSuccessful, null);

        PageMethod("<?=base_url('dashboards/saveAd')?>", "Saving Ad<br/>This may take a minute.", dataToUse, adsSaveSuccessful, null);

    }
    function newAd() {
        $("#ad_id").val("-1");
        $("#ad_name").val("");
        $("#ad_code").val("");
        //$("#ad_starttime").val("12:00 am");
        //$("#ad_stoptime").val("11:59 pm");
        $("#ad_category").val("0");
        CKEDITOR.instances.ad_text.setData( "Your Ad Here!" );
        ShowAdEditView();
        $("#show_ads").hide();
        $("#text_message").val("");
        $("#ad_startdatetime").val('');
        $("#ad_stopdatetime").val('');
        $( "#ad_startdatetime, #ad_stopdatetime" ).datetimepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:'yy-mm-dd'
		});
    }

    function ShowAdEditView(){
        $("#editAd").show();
        $("#showAds").hide();
        $("#viewAds").show();
        $("#ads_view").show();
        $("#ads_view_buttons").show();
        $("#business_view").hide();

    }
    function CancelAdEdit(){
        $("#editAd").hide();
        $("#viewAds").show();
        cancelAdView();
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
    		alert('please insert start date earlier than stop date');
    		return false;
    	}
        
        
        var dataToUse = {
            "id":$("#ad_id").val(),
            "offer_code" : $("#ad_code").val(),
            "name":$("#ad_name").val(),
            "biz_list" : "true",
            "ad_stopdatetime":$("#ad_stopdatetime").val(),
            "ad_startdatetime":$("#ad_startdatetime").val(),
            "business_id":$("#ad_business").val(),
            "adtext": CKEDITOR.instances.ad_text.getData(),
            "category_id": $("#ad_category").val(),
            "active" : "1",
            "text_message": $("#text_message").val(),
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
        //$("#ad_starttime").val(result.starttime);
        //$("#ad_stoptime").val(result.stoptime);
        //$("#ad_business").val(result.business_id);
        $("#ad_category").val(result.category_id);
        $("#ad_startdatetime").val(result.startdatetime);
        $("#ad_stopdatetime").val(result.stopdatetime);
        $("#text_message").val(result.text_message);
        //$("#ad_text").val(result.adtext);
        //$("textarea.editor").val(result.adtext);
        CKEDITOR.instances.ad_text.setData( result.adtext );
        ShowAdEditView();
        $("#show_ads").hide();
        $( "#ad_startdatetime, #ad_stopdatetime" ).datetimepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat:'yy-mm-dd'
		});
    }

    CancelAdEdit();
</script>
<script type="text/javascript">
    var currentSection = "business";
    var zone_id = <?=$zone->id?>;

    var create_biz = 0;
    $("#biz_zone_id").val(zone_id);

    updateCatOption(<?=$zone->category_option?>);

    function updateCatOption(copt)
    {
        $("#cat_option").val(copt);
        $("#cdDisplay").html($('#cat_option option:selected').text());
    }
    function saveZoneName(){
        var tempZone = zone_id;
        if(create_biz == 1)
        {
            tempZone = -1;
        }

        var data = { "zone_id": tempZone, "zone_name": $('#zoneName').val(), "category_option" : $("#cat_option").val() };
        $("#zoneNameDisplay").html($('#zoneName').val());
        $("#zoneNameEdit").hide();
        $("#zoneNameDisplay").show();
        $("#zoneNameEditButtons").hide();
        var title = "Renaming Zone";
        if(tempZone == -1) { title = "Creating Zone";}
        PageMethod("<?=base_url('dashboards/renameZone')?>", title, data, tempZone == -1 ? NewZoneSaved : null, null);
        $.unblockUI();

    }

    function NewZoneSaved(result){
        window.location.href = "<?=base_url('dashboards/zone')?>" + "/" + result.Tag;
    }
    function showAds(biz_id){
        $("#ad_business").val(biz_id);
        var data = { biz_id : biz_id};
        PageMethod("<?=base_url('dashboards/loadAdsForBusiness')?>", "Loading Ads For The Business", data, adsLoadSuccessful, null);

    }

    function CreateABusinessSaved(result)
    {
        $.unblockUI();
        $("#business_view").html(result.Tag);
        $("#business_label").html(result.Message);
        $("#businessEdit").hide();
        $("#business_view").show();
    }
    function cancelAdView()
    {
        $("#ads_view").hide();
        $("editAd").hide();
        $("#ads_view_buttons").hide();
        $("#business_view").show();

    }
    function adsLoadSuccessful(result)
    {
        $("#ads_view").show();
        $("#show_ads").html(result.Tag);
        $("table .pretty").dataTable({
            "bPaginate": false
        });

        $("#business_view").hide();
        $("#ads_view_buttons").show();
        $("#show_ads").show();
        $.unblockUI();

    }

    function saveAnnouncement() {
        var dataToUse = {
            "id":$("#announcement_id").val(),
            "title":$("#announcement_title").val(),
            "zone_id": $("#announcement_zone").val(),
            "announcement_text":nicEditors.findEditor('announcement_text').getContent()
        };

        PageMethod("<?=base_url('announcements/save')?>", "Saving Announcement<br/>This may take a minute.", dataToUse, announceSaveSuccessful, null);
    }


    function cancelEditName(){
        $("#zoneNameEdit").hide();
        $("#zoneNameDisplay").show();
        $("#zoneNameEditButtons").hide();
    }
    function editName(){
        $("#zoneNameEdit").show();
        $("#zoneNameDisplay").hide();
        $("#zoneNameEditButtons").show();
    }
    function createBusinessShow(){
        $("#businessEdit").show();
        $("#business_view").hide();
    }

    function saveNewBusiness(){
        $("#businessEdit").hide();
        $("#business_view").show();
        $("#business_form").ajaxSubmit();
    }
    function cancelEditBusiness(){
        $("#businessEdit").hide();
        $("#business_view").show();
    }
    function addBusinessToZone(zoneId){
        var biz_id = $('#biz_toAdd').val();
        if(biz_id == "-1"){
            //New Business
            createBusinessShow();
            return;
        }
        var data = { "zone_id": zoneId, "biz_id": biz_id };
        PageMethod("<?=base_url('dashboards/addBusinessToZone')?>", "Adding Business To Zone", data, UpdateBusinesses, null);

    }
    function removeBusinessFromZone(bizId, zoneId, title){
        var dataToUse = { "id": zoneId, "biz_id": bizId };
        ConfirmDialog("Really remove : " + title + " from zone?", "Remove Business From Zone", "<?=base_url('dashboards/removeBusinessFromZone')?>",
                "Removing From Zone<br/>This may take a minute", dataToUse, UpdateBusinesses, null);


    }
    function loadDashboardSection(section, zone){
        if(section == currentSection){
            alert('That section is already loaded!');
        }

        currentSection = section;
    }
    function removeZipFromZone(zip, zoneId, title) {
        var dataToUse = { "id": zoneId, "zipcode": zip };
        ConfirmDialog("Really remove : " + title + " from zone?", "Remove Zip From Zone", "<?=base_url('dashboards/removeZipFromZone')?>",
                "Removing From Zone<br/>This may take a minute", dataToUse, UpdateZips, null);
    }
    function addZipToZone(zoneId) {
        var zip_id = $("#zipToAdd").val();
        var data = { "zone_id": zoneId, "zipcode": zip_id };
        PageMethod("<?=base_url('dashboards/addZipToZone')?>", "Adding Zip Code To Zone", data, UpdateZips, null);

    }

    function UpdateBusinesses(result) {
        $.unblockUI();
        $("#business_view").html(result.Tag);
    }
    function UpdateZips(result) {
        $.unblockUI();
        $("#zip_codes").html(result.Tag);
    }
    //$(document).ready(function () {

        $("#ads_view").hide();
        $("#ads_view_buttons").hide();
        $("#zoneNameEdit").hide();
        $("#categoryDisplayEdit").hide();
        $("#stats").hide();
        $("#zoneNameEditButtons").hide();
        $("#businessEdit").hide();
        $("#annoucement_edit").hide();
        $('#business_form').ajaxForm(function() {
            alert("Thank you for your comment!");
        });
        $("table .pretty").dataTable({
            "bPaginate": false
        });
        $( "#accordion" ).accordion({autoHeight:false});

    //    });
</script>

<script type="text/javascript">
//zone manager code
    function addManagerToZone()
    {
            var manager_id = $("#managerToAdd").val();
            var data = { "zone_id": default_zone, "manager_id": manager_id };
            PageMethod("<?=base_url('dashboards/addManagerToZone')?>", "Adding Manager To Zone", data, UpdateManagers, null);
    }
    function UpdateManagers(result){
        $.unblockUI();
        $("#zone_manager_list").html(result.Tag);
    }

    function removeManagerFromZone(manager_id, title ){
        var data = { "zone_id": default_zone, "manager_id": manager_id };
        ConfirmDialog("Really remove : " + title + " from zone?", "Remove Manager From Zone", "<?=base_url('dashboards/removeManagerFromZone')?>",
                "Removing From Zone<br/>This may take a minute", data, UpdateManagers, null);

    }

</script>
<script type="text/javascript">
    //category editing

    function showCategoryEdit(){
        $("#categoryDisplayDisplay").hide();
        $("#categoryDisplayEdit").show();
    }

    function cancelCategoryEdit(){
        $("#categoryDisplayDisplay").show();
        $("#categoryDisplayEdit").hide();
    }

    function saveCategoryEdit(){
        var data = {"zone_id" : default_zone,
            "category_option" : $("#cat_option").val(),
            "categories" : $("#category").val()
        };

        PageMethod("<?=base_url('dashboards/SaveCategories')?>", "Saving Category", data, CategoriesSaved, null);
    }
    function CategoriesSaved(result){
        $.unblockUI();
        $("#categoryDisplayList").html(result.Tag);
        cancelCategoryEdit();
    }
</script>
