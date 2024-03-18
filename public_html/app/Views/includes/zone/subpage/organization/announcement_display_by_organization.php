<!--<input type="hidden" name="announcements_category" value="<?=$announcements_category?>" /> 
<input type="hidden" name="announcements_type" value="<?=$announcements_type?>" />-->
﻿<table align="center" id="<?= $uId = str_replace(".","",uniqid('', true)); ?>" class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top: -31px;">
    <tbody>   
    <? 
	foreach($announcement_list as $ann){ 
	?>
        <tr class="ann_row">                
           
            <td width="25%"><?=$ann['title']?></td>                
            </td>
            <td width="45%"><?=$ann['announcement']?><br /><strong>Organization Name :</strong> <?=$ann['organization_name']?>
            <td width="25%">
                <?php if($ann['approval']==0 || $ann['approval']==2){ ?>
        	<button class="announcements_activate_by_org" onclick="announcement_approval(<?=$ann['id']?>,1,<?=$announcements_category?>,<?=$announcements_type?>);">Activate</button><br /><br /><button class="announcements_deactivate_by_org" onclick="announcement_approval(<?=$ann['id']?>,-1,<?=$announcements_category?>,<?=$announcements_type?>);">Deactivate</button><br /><br /><button onclick="DeleteAnnouncement(<?=$ann['id']?>,'<?=str_replace("'","\'",$ann['title'])?>',<?=$announcements_category?>,<?=$announcements_type?>);">Delete</button>
        <?php } else if($ann['approval']==1){?>
            <button class="announcements_deactivate_by_org" onclick="announcement_approval(<?=$ann['id']?>,-1,<?=$announcements_category?>,<?=$announcements_type?>);">Deactivate</button>&nbsp;<button onclick="DeleteAnnouncement(<?=$ann['id']?>,'<?=str_replace("'","\'",$ann['title'])?>',<?=$announcements_category?>,<?=$announcements_type?>);">Delete</button>
        <?php } else if($ann['approval']=='-1'){?>
        	<button class="announcements_activate_by_org" onclick="announcement_approval(<?=$ann['id']?>,1,<?=$announcements_category?>,<?=$announcements_type?>);">Activate</button>&nbsp;<button onclick="DeleteAnnouncement(<?=$ann['id']?>,'<?=str_replace("'","\'",$ann['title'])?>',<?=$announcements_category?>,<?=$announcements_type?>);">Delete</button>
        <?php } ?>                   
            </td>
        </tr>
   <? } ?>
    </tbody>
</table>
