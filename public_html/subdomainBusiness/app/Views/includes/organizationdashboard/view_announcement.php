<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />
<input type="hidden" name="orgnid" id="orgnid" value="<?=$common['organizationid']?>" />
<input type="hidden" name="fromzoneid" id="fromzoneid" value="<?=$fromzoneid?>" />
<input type="hidden" name="organization_id" id="organization_id" value="<?=$organizationid?>" />
<input type="hidden" id="announcement_limit" value="<?//=$limit ?>" />
<input type="hidden" id="countallannouncements" value="<?=$countallannouncements ?>" />
<input type="hidden" id="right_contain" value="<?//=$right_container ?>" />

<?php if(($common['organization_status']==1 || $common['usergroup']->group_id==4)){?>
<div class="main_content_outer"> 
    <div class="content_container announce_ment_container">
        <div class="top-title">
            <h2>View Announcements</h2>
            <hr class="center-diamond">
        </div>
        <div id="msg"></div>
        <div id="helpdiv" class="container_tab_header header-default-message bv_head_wraper" margin-top:10px;>
            <p>To edit an announcement click on the "Edit" button of the respective announcement. To delete an announcement click on the "Delete" button of the respective announcement. </p>
        </div>
        
        <div id="container_tab_content" class="container_tab_content">   
            <div id="tabs-1_x">
                <div>
                    <table class="pretty header" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
                        <thead id="showhead">
                            <tr>
                                <th width="20%">Title</th>            
                                <th width="60%">Announcement Details</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="showannouncement" border="0" cellpadding="0" cellspacing="0"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>