<?php 
if(!empty($category_list)){ 
    $k=0;
    $sr = 0;
    foreach($category_list as $key1=>$val1){
        $j = $i = 0; 
        $sr++;
        $category=explode('#',$key1);
?>
        <li class="fooditem">
            <a data-toggle="tab" href="#" count="<?= $sr; ?>"  class="food_tab productfood">
    <?php if($category_list[$category[0].'#'.$category[1]]['attachment_image'] != ''){ ?>   
            <img src="<?php echo base_url(); ?>/assets/category_images/<?php echo $category_list[$category[0].'#'.$category[1]]['attachment_image'] ?>"/>
    <?php } ?>
                <strong><?php echo  $category[0];?></strong>
            </a>        
            <div class="stabbedt_drop otherproduct container">
                <div style="background-color: #fff" class="row">
    <?php 
                $j = $count = 0;
                foreach($val1 as $key2=>$val2){ 
                    $subcat_arr = explode('#@#',$key2);
                    $subcat_header = $subcat_arr[0] ;
                    $i=0; 
                    if($subcat_header != 'attachment_image'){
    ?>
                        <div class="col-sm-12 col-sm-12  col-xs-12">  
    <?php  }
        if($subcat_header != 'attachment_image'){
            if($count == '0'){
                echo '  <div style="text-align:left;"><a style="font-size:13px;" class="show_ads_specific_category" href="javascript:void(0);" rel="'.$category[1].'" id="'.$category[1].'">Show all Deals within this Panel!</a></div>';
            }
        }
        if ($subcat_header!=-100) {
            if($subcat_header != 'attachment_image'){
    ?>
            <h3 style="font-weight: bold;font-size: 16px;text-align: left;"><?php echo $subcat_header; ?></h3>
    <? } }
    if(is_array($val2)){
        foreach($val2 as $key3=>$val3) { 
            $sub_category=explode('#',$val3);
            $i++;
    ?>
            <div style="text-align: left;"><a style="font-size: 13px;" class="show_ads_specific_sub_category" href="javascript:void(0);" rel="<?php echo $sub_category[1]; ?>" id="<?php echo $sub_category[1];?>"> <?php echo $sub_category[0]; ?>

                      <?php echo $sub_category[2]; ?></a></div>                
    <?php }
        }
        if($subcat_header != 'attachment_image'){    ?>
        </div>
    <?php }
        $j=$i; 
        $count++;
        }

    ?> 
        </div>
    </div>
</li>
<?php  } ?> 
<?php } ?>


