<p class="form-group-row">
<label for="biz_zone" class="fleft w_200">Zone</label>
<? if($zip_to_zone!=0){ ?>
<select id="zip_to_zone" name="zip_to_zone" class="fleft w_315" onchange="select_zone_value(this)">
	<? foreach ($zip_to_zone as $zip_to_zone) {
	echo("<option value='" . $zip_to_zone['id'] . "'>" . $zip_to_zone['name'] . "</option>");
}
	?>
</select>

<? }else{ ?>
<select id="zip_to_zone" name="zip_to_zone" class="fleft w_315" onchange="select_zone_value(this)">
	<? echo("<option value='-1'>Zone not Specified</option>");?>
</select>
<? } ?>
</p>