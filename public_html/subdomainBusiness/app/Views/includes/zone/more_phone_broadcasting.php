<?php /*?> <tbody id="showannouncement"> <?php */?>
<?php 
if(!empty($coupon_list)){
foreach($coupon_list as $ann){ ?>
    <tr id="<?=$ann['id']?>">
  
        <td width="15%"><a href="<?=$ann['phone_broadcasting']?>" style="color:#000" target="_blank" > <?=$ann['phone_broadcasting']?></a></td>
        
       <!-- <td width="40%" style="text-align:left;" class="responsive-image"><?=$ann['phone_description']?></td>-->
        
        <td width="20%">
            <input type="hidden" name="org_ann_id" id="org_ann_id" value="<?=$ann['id']?>" />
            <a href="javascript:void(0);"><button class="editButton" onclick="Editphone_broadcasting(<?=$ann['id']?>);return false;">Edit</button></a>
            <button class="deleteButton" onclick="deletephone_broadcasting(<?=$ann['id']?>);return false;">Delete</button>
        </td>

    </tr>
<? } }else{?>
<p><div id="not_found" class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No phone broadcasting found.</div></p>
<?php }?>
<?php /*?> </tbody> <?php */?>