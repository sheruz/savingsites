<?php if($announcement_org_ids != ''){ 	?>

    <select id="<?php if($select_id == 1){ echo 'all_organization'; } else if($select_id == 0){ echo 'all_organization1'; } else if($select_id == -1){ echo 'all_organization2'; }?>"> 

		<?php foreach($announcement_organization as $all_business){ //var_dump($all_business); exit;?>
    
        <option value="<?=$all_business['id'];?>">
    
        <?=$all_business['name']?>
    
        </option>
    
        <? } ?>

    </select>

<button onclick="announcement_submenu(<?=$zoneid?>);" class="showad view_showad">Show</button>
<?php }else{ ?>
	<div style="margin-top:7px;">No Organizations Found</div>
<?php } ?>

