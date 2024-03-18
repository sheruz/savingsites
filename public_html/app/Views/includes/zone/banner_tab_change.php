<!-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> -->
<div class="form-group">
    <div class="container_tab_header header-default-message" style="/*background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px; overflow:hidden;*/">
      <p>Drag and Drop Images To Change Banner Position</p>
    </div>
    <div class="banner_details" style="display:none; margin-top:10px;"></div>
        <div class="banner_list" style="margin-top:10px;">
            <div id="contentRights" class="contentRights">
                <ul>
                  <?php if(!empty($all_banner)) { $count = 1;?>
                  <?php foreach($all_banner as $ab){ //echo '<pre>';var_dump($ab);exit;//var_dump($ab['status']);
                      $banner_path=!empty($ab['zone_id']) ? $ab['zone_id'] : "default";
                      $imageName = $ab['image_name'];
                      //$imageUrl  = base_url().'uploads/banner/'.$banner_path.'/'.$imageName;
                      $isEditable = true;
                     /* if (
                              $imageName == 'slider_default_0.jpg' ||
                              $imageName == 'slider_default_1.jpg' ||
                              $imageName == 'slider_default_2.jpg' ||
                              $imageName == 'slider_default_3.jpg' ||
                              $imageName == 'slider_default_4.jpg' ||
                              $imageName == 'slider_default_5.jpg' ||
                              $imageName == 'slider_default_snapdining.jpg'||
                              $imageName == 'blog-banner.jpg' ||
                              $imageName == 'cal-banner.jpg' ||
                              $imageName == 'circular-banner.jpg' ||
                              $imageName == 'classifieds-banner.jpg' ||
                              $imageName == 'grocery-banner.jpg' ||
                              $imageName == 'hs-banner.jpg' ||
                              $imageName == 'webinar-banner.jpg' ||
                        $imageName == 'webinar-banner1.jpg'

                           ) {*/
                           if($ab['zone_id']==0){
                                 /*$imageUrl=base_url()."assets/banner/$imageName";                          
                                 $banner_path = "default";*/
                                 
                       $imageUrl=base_url()."assets/directory/images/banner/$imageName";
                           }else{
                              $isEditable  = false;
                        //$imageUrl=base_url()."assets/directory/images/banner/$imageName";
                        $imageUrl  = base_url().'uploads/zone_banner/'.$banner_path.'/'.$imageName;
                    }




                  ?>
                  <?php if($ab['status'] == 0){ ?>
                  <li id="banner_<?=$ab['id']?>" style="position:relative;">
                  <span class="img-inactive"><div>Not Viewable</div></span>
                    <?php }else{ ?>
                     <li id="banner_<?=$ab['id']?>" style="position:relative;">
                     <?php } ?>
                    <span class="dragdropimage"><img src="<?= $imageUrl ?>" width="220px" style="width:100%;"/>
                    <button id="counter_<?=$ab['id']?>" class="counter" title="Banner Order" style="top: 0px; position:absolute; right: 0px;  padding: 3px 7px; border-radius: 15px;"><?php echo $count ?></button>
                    </span>
                    <div style="margin-top:5px;">
                    <button id="<?=$ab['id']?>" class="editgrp" onclick="edit_banner1(<?=$ab['id']?>,<?=$zone_id?>,'<?=$banner_path?>');">Edit</button>
                    <?php if($ab['zone_id']!=0) { ?>
                    <button id="<?=$ab['id']?>" class="deletegrp" onclick="delete_banner(<?=$ab['id']?>,<?=$zone_id?>,'<?=$banner_path?>','<?=$ab['image_name']?>')">Delete</button>
                    <?php }  ?>
                    
                      
                     
                      </div>
                  </li>
                  <? $count ++ ;} }
                  else
                  {
                  ?>
                      
                        <li>No Banner Found.</li>
                      
                      <?php   
                  }
                   ?>
               </ul>
            </div>
        </div>
</div>

<script type="text/javascript">
$(document).ready(function () { 
  $('#zone_data_accordian').click();
  $('#zone_data_accordian').next().slideDown();
  $('#jotform').click();
  $('#jotform').next().slideDown();
  $('#manage_banner').addClass('active');
  
  
/*$(function() {var a='';
    $(".contentRight ul").sortable({ 
    opacity: 0.6, 
    cursor: 'move',
    
    update: function() {
      var order = '';
      $('div#contentRight1 ul li').each(function(i){
        order+=$(this).attr('id')+",";
        console.log(i);
        $('#'+$(this).attr('id')).find('.counter').text(i+1);
      });
      
      var data={order:order, zone_id : $('#zone_id').val()};
      //PageMethod("<?=base_url('banner_controller/banner_order_change')?>", "Saving Business Data<br/>This may take a few minutes", data, null, null);
      $.post("<?=base_url('banner_controller/banner_order_change')?>/", data, function(){
        console.log(null);
        
      });                            
    }                 
    });
  });*/
  // + Banner Position Ordering Code
  $(function() {var a='';

    var tab_idhref = $(".ui-state-active a").attr('href');
    var split_tab = tab_idhref.split('-');
    var tab_id = split_tab[1];

    $('.contentRights ul').sortable({ 
    opacity: 0.6, 
    cursor: 'move',
    
    update: function() {
      var contentRight_id = $('.contentRights').attr('id');
      //alert(contentRight_id);
      
      var order = '';
      
        $('div#'+contentRight_id+' ul li').each(function(i){
        //alert($(this).attr('id'));
        order+=$(this).attr('id')+",";
        //console.log($(this).attr('id'));
        //$('#'+$(this).attr('id')).find('.counter').text(i+1);

        var str_split = $(this).attr('id');
        var get_counter_arr = str_split.split('_');
        var get_counter_id  = get_counter_arr[1];
        $('#counter_'+get_counter_id).text(i+1);
        //$('button#counter_'+$(this).attr('id')).text(i+1);
      });
      
      var data={order:order, zone_id : $('#zone_id').val(),'tab_id':tab_id,'device_type':'1'};
      //PageMethod("<?=base_url('banner_controller/banner_order_change')?>", "Saving Business Data<br/>This may take a few minutes", data, null, null);
      $.post("<?=base_url('banner_controller/banner_order_change')?>/", data, function(){
        console.log(null);
        
      });                            
    }                 
    });
  });
  
  // + Banner Position Ordering Code 
});

function edit_banner1(banner_id,zone_id){ //alert(banner_id);
  var tab_idhref = $(".ui-state-active a").attr('href');
  var split_tab = tab_idhref.split('-');
  var tab_id = split_tab[1];

  var dataToUse={'banner_id':banner_id,'zone_id':zone_id,'tab_id':tab_id,'device_type':'1'};
  
  //$("#edit_banner").attr('name','edit_banner'+);
  PageMethod("<?=base_url('banner_controller/edit_banner_new')?>", "Please wait ....", dataToUse,edit_banner_success, null);
  //$(".edit_banner").empty();
}
function edit_banner_success(result){
  $.unblockUI();
  $('#banner_list').hide();
  //$('#banner_details').show();
  $('.banner_list').hide();
  $('.banner_details').show();
  $('.banner_details').html(result.Tag);
  //$('#banner_details').html(result.Tag);
  //$("#update_banner").empty();
}

</script>