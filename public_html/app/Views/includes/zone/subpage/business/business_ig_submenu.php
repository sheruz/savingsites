<?php if(!empty($advertising_businesses)){ ?>
	<div class="container_tab_header" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:10px;">
        <select class="all_business" name="all_business" >
           <?php /*?> <option value="<?php echo str_replace(',','-',$advertising_businesses_ids) ; ?>"> </option> <?php */?>               
            <? foreach($advertising_businesses as $all_business){ ?>
            <option value="<?=$all_business['id']?>">
            <?=$all_business['name']?>
            </option>
            <? } ?>
        </select>
        <button onclick="display_ig_for_business_by_zone(<?=$zoneid?>);" class="showig view_ig">Show</button>
    </div>
    
    <table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
    	<thead><tr><th width="65%">Interest Group</th><th width="30%">Action</th></tr></thead>
	</table>
    
<?php }else {?>
	<div style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;" class="container_tab_header">No interest groups found</div>
<?php } ?>