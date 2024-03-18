<input type="hidden" id="bus_adid" name="bus_adid" value="<?=$adid?>"/> 
<input type="hidden" id="bus_busid" name="bus_busid" value="<?=$zoneid?>"/> 
<input type="hidden" id="bus_zoneid" name="bus_zoneid" value="<?=$businessid?>"/>
<!--<select id="ad_subcategory_fromshowad" name="ad_subcategory_fromshowad[]" multiple="multiple">-->

<?php if(!empty($subcategory_category_zone)){?>
<?php foreach($subcategory_category_zone as $x1=>$y1){?>
<?php foreach($y1 as $x=>$y){?>
<?php foreach($y as $main_key=>$main_val){ ?> 
<p style="width:295px; float:left;"><label for="1" style="width:265px; float:left; display:block; padding-right:10px;"><strong><?php echo $main_key;?></strong></label>
    <select id="ad_subcategory_fromshowad@<?php echo $x?>" name="ad_subcategory_fromshowad" multiple="multiple" class="ad_subcategory_fromshowad" size="5" style="width:285px !important;">
	<?php foreach ($main_val as $key=>$value) {?>
    <?php if($key=='-100'){?>
    <?php foreach($value as $k1=>$v1) { ?>
    
    <?php echo("<option rel=".$k1." class=\"optiondropdown\" value=" .$x . "!@#0!@#".$k1.">" . $v1 . "</option>"); ?>
    <? } ?>
    <? } else {?>
    <?php /*?><?php echo("<option class=\"optiondropdown1\" value='" .$key . "'>" ."<strong>". $key."</strong>" . "</option>"); ?><?php */?>
    <?php $group_id_name=explode('###',$key);?>
    <option class="optiondropdown1" value="<?php echo $$group_id_name[1];?>" disabled="disabled"><?php echo $group_id_name[0];?></option>
    <?php foreach($value as $k1=>$v1) { ?>
    
    <?php echo("<option rel=".$k1." class=\"optiondropdown\" value=" .$x ."!@#".$group_id_name[1]. "!@#".$k1.">" . $v1 . "</option>"); ?> 
    <? } ?>
    <? } ?>	
	<?php } ?>
	</select>

</p>
<?php } ?>
<?php } ?>
<?php } ?>
<?php } ?>	
	
	