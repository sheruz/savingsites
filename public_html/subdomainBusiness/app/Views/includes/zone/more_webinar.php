<?php /*?> <tbody id="showannouncement"> <?php */?>
<?php 
if(!empty($webinar_list)){
foreach($webinar_list as $ann){ ?>
    <tr id="<?=$ann['id']?>">
        
        <td width="15%"><?=$ann['link']?></td>
        
        <td width="40%" style="text-align:left;" class="responsive-image"><?=$ann['description']?></td>
        
        <td width="20%">
            <input type="hidden" name="org_ann_id" id="org_ann_id" value="<?=$ann['id']?>" />
            <a href="javascript:void(0);"><button class="editButton" onclick="Editwebinar(<?=$ann['id']?>);return false;">Edit</button></a>
            <button class="deleteButton m_top_10" onclick="delete_webinar(<?=$ann['id']?>);return false;">Delete</button>
        </td>

    </tr>
<? } }else{?>
<p><div id="not_found" class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No webinar information found.</div></p>
<?php }?>
<?php /*?> </tbody> <?php */?>