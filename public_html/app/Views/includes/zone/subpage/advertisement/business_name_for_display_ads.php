<?php
if(!empty($bus_name)){
	$business_name = urldecode($bus_name);
?>
<select name="alpha_bus_search" id="alpha_bus_search<?=$approval?>" onchange="get_bus_list();" class="alpha_bus_search fleft" style="margin-right:10px;">

<?php foreach($business_name as $key=>$val){?>
<?php foreach($val as $key_1=>$val_1){?>
<option value="<?=strtoupper($val_1)?>"><?=strtoupper($val_1)?></option>
<?php } ?>
<?php } ?>
</select>

<?php
}else{	
	echo '<div style="margin-top:7px; float:left;"> : No Business Found</div>';
}
?>