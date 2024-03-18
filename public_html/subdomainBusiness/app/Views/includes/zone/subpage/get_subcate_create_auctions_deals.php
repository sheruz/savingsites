 <?php if(!empty($sub_category_list)){?>
 
<label for="SubCategory">Sub Category<i class="required">*</i></label>
 <p>Select the Sub category for this deal certificate.</p>
 			
<?php foreach($sub_category_list as $x=>$y){ ?>
 
<?php foreach($y as $main_key=>$main_val){   ?> 
 
    <select id="subcatID@<?php echo $x?>" name="subcatID"  class="subcatID " >
         <option value=''>Select a Sub Category</option>
	<?php foreach ($main_val as $key=>$value) { //var_dump($key); exit;?>
    <?php if($key=='-100'){?>
    <?php foreach($value as $k1=>$v1) { ?>
    
    <option rel="<?php echo $k1; ?>"  <?php if(@$selectedSubcatId){  if($selectedSubcatId == $k1){ echo "selected='selected'"; } } ?>  class="optiondropdown\" value="<?php echo $k1 ?> "><?php echo $v1 ?> </option>
    <? } ?>
    <? } else {?>
   
    <?php $group_id_name=explode('###',$key);?>

    <option class="optiondropdown1"  <?php if(@$selectedSubcatId){  if($selectedSubcatId == $k1){ echo "selected='selected'"; } } ?>     value="<?php echo $group_id_name[1];?>" disabled="disabled"><?php echo $group_id_name[0];?></option>
    <?php foreach($value as $k1=>$v1) { ?>
    
   <option rel="<?php echo $k1; ?>"  <?php if(@$selectedSubcatId){  if($selectedSubcatId == $k1){ echo "selected='selected'"; } } ?>  class="optiondropdown\" value="<?php echo $k1 ?> "><?php echo $v1 ?> </option>
    <? } ?>
    <? } ?>	
	<?php } ?>
	</select>

 
<?php } ?>
<?php } ?>
 
 
<?php } ?>	 

 	



                
