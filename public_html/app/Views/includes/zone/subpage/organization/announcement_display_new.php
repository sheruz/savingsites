<?php /*?><table class="pretty announcement_display" border="0" cellpadding="0" cellspacing="0" style="margin-top:-15px;">
    <!--<thead><tr><th>Ad Details</th><th>StartDateTime<br />StopDateTime</th><th>Business Details</th><th>Action</th></tr></thead>-->
    <tbody><?php */?>
    <?php if(!empty($announcement_approve_zone)) {  
     foreach($announcement_approve_zone as $announcementApproveZone){	//var_dump($announcementApproveZone['orgid']); exit;?>
        <tr id="<?=$announcementApproveZone['id']?>" class="ads_row">
        
            <td style="text-align:justify;" width="25%">
				<?php /*?><?=urldecode($announcementApproveZone['adtext'])?><br /><?php */?>
                <?=$announcementApproveZone['title']?><br /><br />
               <?php /*?> <?php if(!empty($reason[$announcementApproveZone['id']])){?><i>This ad was edited because: <br /></i> <?=$reason[$announcementApproveZone['id']]?><?php }?><?php */?>
            </td>
            
            <td width="45%" class="responsive-image"> <?=$announcementApproveZone['announcement']?><br />
            	
            </td>
            
            <td	width="25%">        
               <?php /*?> <button onclick="showeditform(<?=$announcementApproveZone['id']?>,<?=$zoneid?>,<?=$announcementApproveZone['orgid']?>);">Edit</button><br /><br /><?php */?>
             
                <?php if($announcementApproveZone['approval']==0 || $announcementApproveZone['approval']==2){ ?>
                    
                    <button class="ad_approval_activate" onclick="announcement_approval(<?=$announcementApproveZone['id']?>,<?=$zoneid?>,1,<?=$announcementApproveZone['orgid']?>);">Activate</button><br /><br />
                    
                    <button class="ad_approval_deactivate" onclick="announcement_approval(<?=$announcementApproveZone['id']?>,<?=$zoneid?>,-1,<?=$announcementApproveZone['orgid']?>);">Deactivate</button><br /><br />
                    
                    <button onclick="ad_approval_delete(<?=$announcementApproveZone['id']?>,<?=$zoneid?>,5,<?=$announcementApproveZone['orgid']?>);">Delete</button>
                <?php } else if($announcementApproveZone['approval']==1){?>
                
                    <button class="ad_approval_deactivate" onclick="announcement_approval(<?=$announcementApproveZone['id']?>,<?=$zoneid?>,-1,<?=$announcementApproveZone['orgid']?>);">Deactivate</button><br /><br />
                    
                    <button onclick="ad_approval_delete(<?=$announcementApproveZone['id']?>,<?=$zoneid?>,5,<?=$announcementApproveZone['orgid']?>);">Delete</button>
                <?php } else if($announcementApproveZone['approval']=='-1'){?>
                
                    <button class="ad_approval_activate" onclick="announcement_approval(<?=$announcementApproveZone['id']?>,<?=$zoneid?>,1,<?=$announcementApproveZone['orgid']?>);">Activate</button><br /><br />
                    
                    <button onclick="ad_approval_delete(<?=$announcementApproveZone['id']?>,<?=$zoneid?>,5,<?=$announcementApproveZone['orgid']?>);">Delete</button>
                <?php } ?><br/>
            </td>
        </tr>
    <? } } ?>
<?php /*?>    </tbody>
</table><?php */?>
<?php /*?><div style="float:right"><a id="my_business_limit" href="javascript:void(0)" onclick="showAdvertisement(<?=$zoneid?>,'<?=$charval?>',this);" rel="0,0">Display more ad</a> </div><?php */?>