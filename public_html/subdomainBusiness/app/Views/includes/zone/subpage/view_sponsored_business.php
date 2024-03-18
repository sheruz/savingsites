    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script> 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet"> -->
<?php if(!empty($data)) { 
  /*var_dump($data);
  exit();*/
  ?>
<div class="show_business_msg" style="color:green;"> Business Status Updated </div>
<table class="pretty" border="0" cellpadding="0" cellspacing="0">
  <thead id="showhead" class="headerclass">
    <tr>
      <!--<th width="10%">Sl. No</th>-->
      <th width="10%">Business Id</th>
      <th width="15%">Business Name</th>
      <th width="10%">Contact Name</th>
      <th width="10">Telephone</th>
      <th width="10%">Zip Code</th>
      <th width="10%">Change Status</th>
      <th width="10%">Action</th>
    </tr>
  </thead>
  <tbody>
  
  <?php
   $i=1;
   foreach($data as $sponsor_business){
    $business_status = '';
    $trial_remaining = '';
  ?>
    <tr id="<?=$sponsor_business['business_id']?>" class="uploadbusiness <?=$displaytableview_class?>" >
      <!--<td><?= $i; ?></td>-->
      <td style="text-align:justify;" width="10%"><b>
        <?= $sponsor_business['business_id']; ?>
        </b><br/>
      </td>
     
      <td width="15%"><b>
        <?= $sponsor_business['name']; ?>
        </b><br/>
       
        </td>
      <td width="20%"><?= $sponsor_business['contactfullname']; ?></td>
        
      <td width="10">
      <?= $sponsor_business['phone']; ?> 
       </td>
         
       <td width="10">
      
        <?= $sponsor_business['zip_code']; ?>
       </td>
       <td width="10">
       <input type="radio" name="status_change_<?= $i ?>" class="status_change" data-id="<?= $sponsor_business['business_id'] ?>" value="1" <?php if($sponsor_business['status'] == 1){ ?> checked <?php } ?>> Active<br>
       <input type="radio" name="status_change_<?= $i ?>" class="status_change" data-id="<?= $sponsor_business['business_id'] ?>" value="0" <?php if($sponsor_business['status'] == 0){ ?> checked <?php } ?>> Not Active<br>
       
       <!-- <?php if($sponsor_business['status'] ==1){?>
        <button class="btn btn-default status_change" id="business_<?= $sponsor_business['business_id'] ?>" data-id="<?= $sponsor_business['business_id'] ?>" data-update="2">Deactivate</button>
       <?php } else if($sponsor_business['status'] ==0){ ?>
       <button class="btn btn-default status_change" id="business_<?= $sponsor_business['business_id'] ?>" data-id="<?= $sponsor_business['business_id'] ?>" data-update="1">Activate</button>
       <?php } else if($sponsor_business['status'] ==2){?>
       <button class="btn btn-default status_change" id="business_<?= $sponsor_business['business_id'] ?>" data-id="<?= $sponsor_business['business_id'] ?>" data-update="1">Activate</button>
       <?php } ?> -->
       </td>
       <td width="50"><a href="<?=base_url()?>businessdashboard/viewad/<?= $sponsor_business['business_id'] ?>/<?=$sponsor_business['zone_id']?>" class="link-underlined text-default"><b>&#x2192; Go to this Business AD profile</b></a></td>

    </tr>
    <?php $displaytableview_class=''; 
    $i++;

    } ?>
   
  </tbody>
</table>
<!-- <div class="display_more_business" style="float: right;"><a class="more_non_temp_business" style=" color:#000;" href="javascript:void(0)" rel="0,0" data-zoneid="<?=$zoneid?>" data-businesstype="<?=$business_type?>" data-businesstypebycategory="<?=$business_type_by_category?>" data-businesszone="<?=$business_zone?>" data-charvalname="<?=$charval_name?>" data-charvalalphabet="<?=$charval_alphabet?>"><strong>Display more businesses</strong></a> </div> -->
 <?php } else{ ?>
    <div class="container_tab_header" id="not_found" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Sponsor Business Found</div>
    <?php } ?>
  
    <script type="text/javascript">
  $(document).ready(function () {
    $(".show_business_msg").hide();
    $('#action_performed').change(function() {   // available all business drop down only for delete
      if ($(this).val() == 3) {
        $('#status_all').show();
      } else {
      $('#business_delete_all_or_specific>option:eq(0)').attr('selected', true);
          $('#status_all').hide();
     }
    });

    $(".status_change").change(function(){ //alert(11);
      var data_id=$(this).attr('data-id');
      var data_update = $(this).val(); //alert(data_update);
      var data={data_id:data_id,data_update:data_update};
      $.ajax({
        type:"POST",
        url:"<?php echo base_url('Zonedashboard/change_sponsored_business_status');?>",
        data:data,
        success:function(data){
          data=JSON.parse(data);
          //alert(data);
          if(data == "activated"){
            $(".show_business_msg").show();
            setTimeout(function() { $(".show_business_msg").hide(); }, 5000);
          }else if(data == "deactivated"){
            $(".show_business_msg").show();
            setTimeout(function() { $(".show_business_msg").hide(); }, 5000);
          }
        },
        error:function(error){
          console.log(error);
        }
      });
    });
    // $(".status_change").click(function(){
    //   var data_id=$(this).attr('data-id');
    //   var data_update=$(this).attr('data-update');
    //   var data={data_id:data_id,data_update:data_update};
    //   $.ajax({
    //     type:"POST",
    //     url:"<?php echo base_url('Zonedashboard/change_sponsored_business_status');?>",
    //     data:data,
    //     success:function(data){
    //        var id="business_"+data_id;          
    //        change_status(id,data);         

    //     },
    //     error:function(error){
    //       console.log(error);
    //     }
    //   });
    // });


  });

  // function change_status(id,data){
  //   data=JSON.parse(data);
  //   id="#"+id;
  //   if(data =="activated"){      
  //     $(id).text("Deactivate");
  //     $(id).attr('data-update',2);
  //   } else if(data =="deactivated"){     
  //     $(id).text("Activate");
  //     $(id).attr('data-update',2);
  //   } else if(data =="decliened"){
  //     $(id).text("Activate");
  //     $(id).attr('data-update',1);
  //   }
  // }

</script>