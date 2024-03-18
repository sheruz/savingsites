<?php if(!empty($category_list)){?>
<p class="form-group-row">
	<label for="biz_main_category" class="fleft w_200">Main Category</label>
     <select class="w_315" id="main_category">
     <?php  foreach($category_list as $val){?>
     	<option class="normal" value="<?=$val['id']?>"><?=$val['name']?> </option>
     <?php } ?>
     </select>
<?php } ?>	                
				
               
                
