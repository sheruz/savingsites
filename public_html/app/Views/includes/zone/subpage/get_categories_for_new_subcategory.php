<p class="form-group-row">
  <label for="category" class="fleft w_300">Category</label>
  <select id="category" class="fleft w_315">
  <?php if(!empty($categories)){?>
  <?php foreach($categories as $categories){?>
  <option value="<?=$categories['id']?>"><?=$categories['name']?></option>
  <?php } }?>
  </select>
</p>	                
				
               
                
