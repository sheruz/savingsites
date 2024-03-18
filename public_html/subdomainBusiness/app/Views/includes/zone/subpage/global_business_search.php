<?php if(!empty($search_value)){?>

<?php foreach($search_value as $val){ ?>

<a class="business_search_result_style" href="<?=base_url()?>businessdashboard/businessdetail/<?=$val['id']?>/<?=$zone_id?>"> <?=urldecode($val['name'])?></a>

<?php } } else{ 
	echo 1;
}?>	                		
               
                
