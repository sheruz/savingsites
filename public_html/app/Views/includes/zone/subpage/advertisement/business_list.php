<?php if($advertising_businesses_ids != ''){ ?>

    <select id="<?php if($select_id == 1){ echo 'all_business'; } else if($select_id == 0){ echo 'all_business1'; } else if($select_id == -1){ echo 'all_business2'; }?>"> 

		<?php foreach($advertising_businesses as $all_business){ ?>
    
        <option value="<?=$all_business['id'];?>">
    
        <?=$all_business['name']?>
    
        </option>
    
        <? } ?>

    </select>

<button onclick="advertisement_submenu(<?=$zoneid?>);" class="showad view_showad">Show</button>
<?php }else{ ?>
	<div style="margin-top:7px;">No Business Found</div>
<?php } ?>

