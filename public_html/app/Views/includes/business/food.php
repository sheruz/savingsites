<?php
    if(!empty($category_list_food)){  
    $k=0; 
    foreach($category_list_food as $key1=>$val1){
        $category=explode('#',$key1);
?>
        <li class="fooditem"><a href="#" data-toggle="tab" class="food_tab" id="food_tab">  
            <?php if($category_list_food[$category[0].'#'.$category[1]]['attachment_image'] != ''){ ?>
                <img src="<?php echo base_url(); ?>/assets/category_images/<?php echo $category_list_food[$category[0].'#'.$category[1]]['attachment_image'] ?>"/>
            <?php } ?>
                <strong><?php echo $category[0];?></strong></a>
            <div class="foodsearch stabbed-menu-content_drop container" style="width: 540px;">
                <div style="background-color: #fff" class="row">
                <?php 
                    $j=0;
                    $count =0;
                    foreach($val1 as $key2=>$val2){ 
                        $subcat_arr = explode('#@#',$key2);
                        $subcat_header = $subcat_arr[0];
                        $i=0;   
                        if($subcat_header != 'attachment_image'){
                            $subcat_headerid = $subcat_arr[1];
                ?>
                            <div class="col-sm-4 col-sm-4  col-xs-6">  
                <?php
                    if($count == '0'){
                        echo '  <div><a class="show_ads_specific_category" href="javascript:void(0);" rel="'.$category[1].'" id="'.$category[1].'">Show all Deals within this Panel!</a></div>';
                    }
                ?>
                    <h3 style="font-weight: bold;"><?php echo $subcat_header;?></h3>
                <?  }
                    if(is_array($val2)){
                    foreach($val2 as $key3=>$val3) { 
                        $sub_category=explode('#',$val3);
                        $i++;
                ?>
                        <div>
                            <a class="show_ads_specific_sub_category" href="javascript:void(0);" rel="<?php echo $sub_category[1];?>" id="<?php echo $sub_category[1];?>"><?php echo $sub_category[0]; ?><?php echo $sub_category[2]; ?></a>
                        </div>                
                <?php
                    }
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
<?php } ?> 
<?php } ?>