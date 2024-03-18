 <?php if(!empty($sub_category_list)){?>
<p class="form-group-row">
<label for="biz_zone" class="fleft w_200">Subcategories </label>
				
<?php foreach($sub_category_list as $x=>$y){ ?>
<?php /*?><?php foreach($y1 as $x=>$y){?><?php */?>
<?php foreach($y as $main_key=>$main_val){  ?> 
<!--<p style="width:295px; float:left;"><label for="ad_subcategory_fromshowad1" style="width:265px; float:left; display:block; padding-right:10px;"></label>-->
    <select id="ad_subcategory_fromshowad@<?php echo $x?>" name="ad_subcategory_fromshowad"  class="ad_subcategory_fromshowad fleft w_315 select2" >
	<?php foreach ($main_val as $key=>$value) { //var_dump($key); exit;?>
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

<!--</p>-->
<?php } ?>
<?php } ?>
<?php /*?><?php } ?><?php */?>
</p> 
<?php } ?>	 

<script type="text/javascript">
    $( document ).ready(function() {
        $('.select2').multipleSelect({});
    });
</script>               
				



                
