
<?php if($org_name[0]['name']!=''){ ?>
        <div  id="newadzone" class="container_tab_header" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; overflow:hidden;"> <strong>Organization Name: </strong><?=$org_name[0]['name']?>
            <?php if($selectid==0){?>
                    <div id="newannouncement" style="float:right"><button onclick="allactivate_announcements();">Activate All Announcements</button> <button onclick="alldeactivate_announcements();">Deactivate All Announcements</button></div>
            <? } else if($selectid==1){?>
                    <div id="deactivateadd" style="float:right"><button onclick="all_status_change_announcements(<?=$selectid?>);">Deactivate All Announcements</button></div>
            <? } else if($selectid==-1){?>
                    <div id="activateadd" style="float:right"><button onclick="all_status_change_announcements(<?=$selectid?>);">Activate All Announcements</button></div>
            <? } ?>
            
        </div>

<?php   } ?>

<input type="hidden" id="all_bus_id" name="all_bus_id" value="<?=$org_id?>" />  
<input type="hidden" id="current_zoneid" name="current_zoneid" value="<?=$zoneid?>" />