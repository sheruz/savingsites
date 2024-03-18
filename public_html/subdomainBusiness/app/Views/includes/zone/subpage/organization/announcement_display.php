  	<table align="center" id="<?= $uId = str_replace(".","",uniqid('', true)); ?>" class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top: -31px;">  
        <tbody>      
        <? foreach($announcement_list as $ann){ ?>         
            <tr class="ann_row">               
                <td width="25%"><?=$ann['title']?></td>                
                </td>
                <td width="45%"><?=$ann['announcement_text']?></td>
                <td width="25%"><button class="editButton" onclick="EditAnnouncement(<?=$ann['id']?>);return false;">Edit</button>
                   
				<?php if($ann['approval']==0 || $ann['approval']==2){ ?>
                    <button class="announcement_activate" onclick="announcement_approval(<?=$ann['id']?>,1,<?=$announcements_category?>,<?=$announcements_type?>);">Activate</button><br /><button class="announcement_deactivate" onclick="announcement_approval(<?=$ann['id']?>,-1,<?=$announcements_category?>,<?=$announcements_type?>);">Deactivate</button><br /><button onclick="DeleteAnnouncement(<?=$ann['id']?>,'<?=str_replace("'","\'",$ann['title'])?>',<?=$announcements_category?>,<?=$announcements_type?>);">Delete</button>
                <?php } else if($ann['approval']==1){?>
                    <button class="announcement_deactivate" onclick="announcement_approval(<?=$ann['id']?>,-1,<?=$announcements_category?>,<?=$announcements_type?>);">Deactivate</button><button onclick="DeleteAnnouncement(<?=$ann['id']?>,'<?=str_replace("'","\'",$ann['title'])?>',<?=$announcements_category?>,<?=$announcements_type?>);">Delete</button>
                <?php } else if($ann['approval']=='-1'){?>
                    <button class="announcement_activate" onclick="announcement_approval(<?=$ann['id']?>,1,<?=$announcements_category?>,<?=$announcements_type?>);">Activate</button><button onclick="DeleteAnnouncement(<?=$ann['id']?>,'<?=str_replace("'","\'",$ann['title'])?>',<?=$announcements_category?>,<?=$announcements_type?>);">Delete</button>
                <?php } ?>                  
                </td>
            </tr>
       <? } ?>
        </tbody>
    </table>
