<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />
<input type="hidden" name="zoneid" id= "business_id" value="<?= $common['businessid']?>">
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css">
 <script type="text/javascript">   
function ajaxFileUpload(){ 


  //starting setting some animation when the ajax starts and completes
  $('#spinner').show();
   $.ajaxFileUpload(            
  {
    url:'<?=base_url('Businessdashboard/save_banner_imagemobile/'.$common['zoneid'].'')?>',
    secureuri:false,
    fileElementId:'card_img',
    dataType: 'json',
    success: function (data, status)
    {
     
      $('#spinner').hide();
      $('#uploadedInput').val(data.clientImage);
      $('#show_banner').html('<img src="'+baseurl+'uploads/zone_mobile_resizeupload/'+data.zone_id+'/'+data.clientImage+'" style="width:300px;  margin-top: 8px;">');
     
      if(data!=0){}
      if(typeof(data.error) != 'undefined')
      {
        if(data.error != '')
        {
          alert(data.error);
        }else
        {
          alert(data.msg);
        }
      }
    },
    error: function (data, status, e)
    {
      alert(e);
    }
  }
)       
return false;
}   
 </script>



<!-- listing  -->
<div class="content_container">

<div class="container_tab_header">   Create Auction</div>
<div id="msg"></div>
<div id="container_tab_content" class="container_tab_content">

        <div id="tabs-2_y">

        	<div id="msg" style="display:none;margin-top:7px;"></div>

        <div class="form-group  ">

<form name="auctioncreate" method="post" class="auctioncreate" enctype="multipart/form-data"  action="">
    

<div class="form-control row"  >
      <div class="col-sm-3"><label for="Category">Select offer</label></div>    
      <div class="col-sm-9">

        <ul class="sort_list">

            <?php  foreach ($pbcashcert as $key ) {
         
                echo '<li><a href="#" class="sortlist_tags tooltips" tooltip="Start Date:'.$key['start_date'].' <br/> 
End Date:   '.$key['end_date'].'<br/>
Redemption Value:'.$key['redemption_val'].' <br/>
Starting Price:'.$key['starting_price'].' <br/>
Consolation Cash Cert:'.$key['consolation_cash_cert'].'    <br/>
Max Sold Per Auction:'.$key['max_sold_per_auction'].'<br/>
Business Credits Given On Redemption:'.$key['bussiness_credit'].'<br/>
Auto Renewal  1 and 2 for Manual:'.$key['auto_renewal'].'<br/>
Donation Fee: '.$key['donantion_fee'].'<br/>
Credits:'.$key['credit_claim'].'<br/>
                " tooltip-position="right"   data-id="'.$key['id'].'">'.$key['options'].'</a></li>';
            } ?>
             
        </ul>
       

      </div>
</div>

      

      <div class="form-control row">

    <div class="col-sm-3"><label for="Category">Category<i class="required">*</i></label></div>

    <div class="col-sm-9">

      <input type="hidden" name="zone_id" value="<?=$common['zoneid']?>">

      <input type="hidden" name="login_type" value="<?=$common['login_type']?>">



        <input name="product_name" type="hidden"  class="comment" id="product_name" value="">
                            




    <select name="cat_id" id="catID">

      <option value=''>Select a Category</option>

      <?php foreach($categories as $cdata){ ?>

      <option 

      <?php if(@$editdataresponse == 1){     if($editdata[0]['cat_id'] == $cdata['cat_id']){ echo "selected='selected'"; } } ?> 

      value="<?php echo $cdata['cat_id'];?>"  > <?php echo $cdata['cat_name']?> </option>

      <?php } ?>

    </select>

    </div>

  </div>

   <div class="form-control row"> <br/>

    <div class="col-sm-3"><label for="id_contact">Business Name<i class="required">*</i></label><br /></div>
 <div class="col-sm-9">

  <input name="company_name"  readonly type="text" class="comment" id="company_name" value="<?php echo $common['sub_header_name_from_zone']['name']; ?>" size="50" />
 </div>

   </div>


<br/>
 


   <div class="form-control row">

    <div class="col-sm-3"><label for="card_img">Deal Image upload</label>    

    </div>


     <div class="col-sm-9">



       <input  type="file" class="comment" onchange="ajaxFileUpload();" id="card_img" name="card_img" /> 

         <input type="hidden" name="uploadedInput" id="uploadedInput" value="    <?php  if(@$editdataresponse == 1){   echo trim($editdata[0]['card_img']);  }   ?>" />
         <input type="hidden" name="zone_id" value="<?=$common['zoneid']?>">
        <input type="hidden" name="business_id" value="<?=$common['businessid']?>">



        <span style="display:none;right: 240px;" id="spinner"><img src="<?php echo base_url() ?>assets/images/loading.gif"></span>
        
        <div id="show_banner" style="width: 300px;">
          <?php  if(@$editdataresponse == 1){   if($editdata[0]['card_img']) { ?>
          <img src="<?php echo base_url() ?>uploads/zone_mobile_resizeupload/<?php  echo $zoneid; ?>/<?php echo trim($editdata[0]['card_img']) ?>" style="width:300px;  margin-top: 8px;">
          <?php } } ?> 
        </div>  

       <span class="error_img_msg" style="color:red;"></span>

     </div>   

 </div>
 
<br/>


  <div class="form-control row">

  

    <div class="col-sm-3"><label for="Start Date">Auction Start Date<i class="required">*</i></label></div>

     <div class="col-sm-9" style="position: relative;">

    <input name="start_date" type="text"  class="comment" id="start_date" value=" <?php  if(@$editdataresponse == 1){ echo $editdata[0]['start_date'];   } ?>  ">

 
 

    </div> 

  </div> 

  <br/>


    <div class="form-control row">

    <div class="col-sm-3"><label for="End Date">Auction End Date<i class="required">*</i></label></div>

    <div class="col-sm-9">

     <input name="end_date" type="text"  class="comment " id="end_date" value=" <?php  if(@$editdataresponse == 1){ echo $editdata[0]['end_date'];   } ?> ">

    

 </div>

  </div> 


<br/>


  <div class="form-control row">

    <div class="col-sm-3"><label for="Redeemption Value">Redemption($)<i class="required">*</i></label></div>

    <div class="col-sm-9">

    <input name="buy_price_decrease_by" type="text"  class="comment redemption" id="buy_price_decrease_by" value="<?php  if(@$editdataresponse == 1){ echo $editdata[0]['buy_price_decrease_by'];   } ?>" size="10" />

    <span id="errmsg"></span>

    <input name="redemption_val" type="hidden"  id="redemption_val" value=""/>

    </div>

  </div>



  <div  <?php if($common['login_type'] != '4'){ echo 'style="display: none;"';} ?>   class="form-control row">

    <div class="col-sm-3"><label for="Publisher Value">Publisher Fee(<?php echo '$'; ?>)</label></div>

    <div class="col-sm-9"><input name="publisher_fee" type="text"  class="comment publisher_fee" id="publisher_fee" value="<?php  if(@$editdataresponse == 1){ echo $editdata[0]['publisher_fee'];   } ?>  " <?php if($common['login_type']!= '4'){ echo'readonly';} ?> size="10"/>

 

    </div>

   </div>  



   <div class="form-control row">

    <div class="col-sm-3"><label for="Seller">Peeking Credit %</label></div>

    <div class="col-sm-9">

    <select name="seller_fee" id="seller_fee">

      <option value=''>Select value</option>

      <?php $i =1;

        for($i=1;$i<=20;$i++){

      ?>

      <option value='<?= $i ?>' <?php  if(@$editdataresponse == 1){      if($editdata[0]['seller_fee'] == $i){ ?> Selected <?php } }?>><?= $i ?>%</option>

      <?php }?>

    </select>

    </div>

  </div> 



    <div class="form-control row">

    <div class="col-sm-3"><label for="Publisher Value">Peeking Credit</label></div>

    <div class="col-sm-9"><input name="seller_credit" type="text"  class="comment seller_credit" id="seller_credit" value="<?php if(@$editdataresponse == 1){    echo  $editdata[0]['seller_credit'];  }   ?>" size="10" readonly/>

    </div>

   </div> 



  <div class="form-control row">

    <div class="col-sm-3"><label for="Starting Price">Starting Price to Claim Redemption Value(<?php echo CURRENCY_SIGN?>)<i class="required">*</i></label></div>

     <div class="col-sm-9"><input name="low_limit_price" type="text"  class="comment low_limit_price" id="low_limit_price" value="<?php if(@$editdataresponse == 1){    echo  $editdata[0]['low_limit_price'];  }   ?>  " size="10" >

    </div>

  </div>


     <div class="form-control row notes">
        <div class="col-sm-12">
        <strong>Example</strong> :$60 Redemption Value. Buyers pay you $30.  Buyers pay us a donation/claim fee of $15 to access your deal. <br/>

When you verify each deal is redeemed, we auto add <strong> 1 credit</strong> to your account for <strong>every dollar</strong> you discount!   <br/>

<strong>MATH:</strong> $30 discount x 1 credits=<strong> 30 credits per customer</strong>! ($15 Value)  <br/>

<strong>  VALUE: </strong>The greater your discount the more valuable credits you receive, that go buyers <strong> as an incentive</strong> to redeem your deal. 
</div>
</div>
 
  <div class="form-control  row">
<div class="col-sm-12">
    <label for="Automate Create">Auto Create and Start the Next Auction</label>

    <p>Once an auction ends you may auto create and start a new auction. Your same auction offer settings of the last auction will be used for the auto created new auction.</p>

    <div id="accept_val">
<div class="col-sm-12">
    <input type="radio" name="automate_create" class="automate_create" value="accepted" <?php echo ($editdata[0]['automate_create']== 0 || $_POST['automate_create']== 0) ? 'checked' :'' ?> <?php if($editdata[0]['automate_create']== 0){ ?> disabled="disabled" <?php } ?> /> Yes keep auto creating new auctions with the same settings as the auction that just ended and keep selling! <br/>

    <input type="radio" name="automate_create" class="automate_create" value="notaccepted" <?php echo ($editdata[0]['automate_create']== 1 || $_POST['automate_create']== 1)?'checked':'' ?> <?php if($editdata[0]['automate_create']== 1){ ?> disabled="disabled" <?php } ?> /> No, I may want to make adjustments, so I will manually create new auctions.

    </div>
</div>
  </div></div>


     <div class="form-control row">
<div class="col-sm-12">
    <label for="Starting Price">Consolation Certificates Available?</label>

    <p>Do you want to sell only the 1 winner, or do you want to sell consolation certificates?</p>

    <div id="accept_val">
 
    <input type="radio" name="cert_accept" class="cert_accept_yes sell_certificates" id="cert_accept_yes" value="accepted"  checked   /> Sell Consolation Certificates <br/>

<!--     <input type="radio" name="cert_accept" class="cert_accept_yes" value="notaccepted" <?php echo (@$editdata[0]['cert_accept']=='notaccepted' || $_POST['cert_accept']=='notaccepted')?'checked':'' ?> <?php if($editdata[0]['cert_accept']=='accepted'){ ?> disabled="disabled" <?php } ?> /> I want to sell to the 1 winner -->

    </div>

  </div> </div>

  <div class="form-control row  consolation_view <?php if($_POST['cert_accept']!='accepted' && $editdata[0]['cert_accept']!='accepted'){ ?>certificate_view <?php } ?>">

 

    <div class="col-sm-3"><label for="Starting Price">Consolation Winners can buy at: <i class="required">*</i></label></div>

    <div class="col-sm-9"><?php echo '$'; ?>
    <input name="consolation_price" type="text"  class="comment consolation_price" id="consolation_price" style="width: 490px;margin-left: 4px;" value="<?php if(@$editdataresponse == 1){    echo  $editdata[0]['consolation_price'];  }   ?>     " size="10"   >
 <p class="text">


    <input name="nobypass" id="nobypass" type="hidden" max="99" maxlength="90" class="comment nobypass" id="nobypass" value="0" />   

  </p> 
    </div>
 
 </div>


  <div class="form-control row">

    <div class="col-sm-3"><label>

        The maximum number of consolation certificates that we are willing to sell for this auction is: 

    </label></div>


    <div class="col-sm-9"><strong  > CAP: </strong> <input type="number" name="numberofconsolation" class="numberconsoval noofconsolation_textbox" value="<?php if(@$editdataresponse == 1){ echo  trim($editdata[0]['numberofconsolation']);  }   ?>" id="max_sold_per_auction" min="1" style="width: 120px;margin-left: 4px;" />

    <span style="margin-left:10px; margin-right:10px;">OR</span>

    <input type="checkbox" name="numberofconsolation" class="numberconsoval noofconsolation_checkbox" value="NO" <?php echo ($editdata[0]['numberofconsolation'] == '0') ? 'checked' :'' ?>  />  <span  >Unlimited/No Cap</span>

    </div>

  </div>



 




  <div class="form-control row">

    <div class="col-sm-3"><label for="Page Title">Page Title <i class="required">*</i> (It is only used only for social sharing)</label></div>

    <div class="col-sm-9"><input name="page_title" type="text"  class="comment" id="page_title" value="<?php  if(@$editdataresponse == 1){ echo $editdata[0]['page_title'];   } ?>    " size="10" /></div>

 </div>


  <div class="form-control row">

     <div class="col-sm-3"><label for="Meta Description">Meta Description <i class="required">*</i></label></div>

    <div class="col-sm-9"><textarea name="meta_description"  rows="5" cols="5"><?php  if(@$editdataresponse == 1){ echo $editdata[0]['deal_description'];   } ?> </textarea></div>

  </div>

  

  <div class="form-control row">

    <div class="col-sm-3"><label for="Deal Title">Short Url <i class="required">*</i></label></div>

    <div class="col-sm-9"><input name="deal_title" type="text"  class="comment" id="deal_title" value="<?php  if(@$editdataresponse == 1){ echo $editdata[0]['deal_title'];   } ?>  

 " maxlength="100" />

    <span id="deal_title_msg"></span>

    <br/><span id="deal_title_feedback"></span></div>

 </div>

 
 <div class="form-control row">

    <div class="col-sm-3"><label for="Seller">Status<i class="required">*</i></label></div>

    <div class="col-sm-9">

    <select name="status_auction" id="status">

      <option value=''>Select value</option>

      <option value='setup' <?php  if(@$editdataresponse == 1){ if($editdata[0]['status'] == 'setup'){ echo 'selected="selected"'; }   } ?>  >Setup</option>     

      <option value='Public' <?php  if(@$editdataresponse == 1){ if($editdata[0]['status'] == 'Public'){ echo 'selected="selected"'; }   } ?>  >Public Viewable</option>  

      <option value="Live" <?php  if(@$editdataresponse == 1){ if($editdata[0]['status'] == 'Live'){ echo 'selected="selected"'; }   } ?> >Live</option>   


      </select>

    </div>

  </div> 




 <div class="form-control row">

    <div class="col-sm-3">

        <label for="Deal Description">Deal Description<i class="required">*</i>
 
          

        </label>

        <div id="loginconfirm4" class="infobox" >


        </div> 

    </div>  

    <div class="col-sm-9">

        <input name="deal_description" type="text"  class="comment" id="deal_description" value="<?php  if(@$editdataresponse == 1){ echo $editdata[0]['deal_description'];   } ?>     " maxlength="70" />

        <br/><span id="deal_description_feedback"></span>

    </div>

    <div >

    <div class="col-sm-3"></div>

    <div class="col-sm-9">

    

        <span id="deal_description_link"></span>

 

 

   

 
 <div class="form-control row btn_row">
     
    <div class="col-sm-12">
        
  <p class="text" style="display:none;">

    <label for="id_contact">Upload Gift Certificate<i class="required">*</i><br/>

      <span>(*.jpg,*.gif,*.png format only) Better display size 600px X 400px</span></label>

    <?php if($data['image']){?>

    <img src="<?php echo UPLOAD_THUMB_IMG_DIR.$data['image']?>" />

    <?php }?>

    <input name="image1" type="file" id="image1" value="<?php echo ($_FILES['image1']['tmp_name']);?>" size="30" maxlength="30">

  </p>


  <p class="text" style="display:none;">

    <label for="id_contact">Image 1<br/>

      <span>(*.jpg,*.gif,*.png format only) Better display size 600px X 400px</span></label>

    <?php if($data['image2']){?>

    <img src="<?php echo UPLOAD_THUMB_IMG_DIR.$data['image2']?>" />&nbsp;&nbsp;<a href="index.php?page=productmanagement&pagetype=addproducts&product_id=<?php echo $_GET['product_id']?>&delete=image&imagename2=<?php echo $data['image2']?>"><img src="admin/images/delete.gif" alt="delete" border="0" /></a>

    <?php }?>

    <input name="image2" type="file" id="image2" value="<?php echo ($_FILES['image2']['tmp_name']);?>" size="30" maxlength="30">

  </p>


   <p class="text" style="display:none;">

    <label for="id_contact">Image 2<br/>

      <span>(*.jpg,*.gif,*.png format only) Better display size 600px X 400px</span></label>

    <?php if($data['image3']){?>

    <img src="<?php echo UPLOAD_THUMB_IMG_DIR.$data['image3']?>" />&nbsp;&nbsp;<a href="index.php?page=productmanagement&pagetype=addproducts&product_id=<?php echo $_GET['product_id']?>&delete=image&imagename3=<?php echo $data['image3']?>"><img src="admin/images/delete.gif" alt="delete" border="0" /></a>

    <?php }?>

    <input name="image3" type="file" id="image3" value="<?php echo ($_FILES['image3']['tmp_name']);?>" size="30" maxlength="30">

  </p>



  <p class="textarea" style="display:none;">

    <label for="message" style="float:none;">Technical Description<i class="required">*</i></label>

    <?php 

if($_POST['tech_description']){$message_body2= $_POST['tech_description'];}else{ $message_body2= $data['tech_description'];}

?>

 
  </p>

<p class="textarea" style="display:none;">

    <label for="message" style="float:none;">Other Description<i class="required">*</i></label>

    <?php 

if($_POST['other_description']){$other_description= $_POST['other_description'];}else{ $other_description= $data['other_description'];}

?>

  



  </p>
 <input type="hidden" name="member_type" value="<?php echo $common['login_type'];?>" />

  <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'];?>" />



  <?php

   if($_REQUEST['mode'] == 'edit'){

    $mode = 'edit';
   }


   if($_REQUEST['status'] != 'new'){ ?>

    <input type="hidden" name="status" value="Public" />

  <?php } ?>

  <?php if($_REQUEST['status'] != 'new'){ ?>

    <input type="hidden" name="request_status" value="new" />

  <?php } ?>

 

  <p class="submit ap-submit-btns">

 

    <input type="button" name="Submit" id="preview_auction" value="Preview Auction" class="button_large" onclick="">

    <input type="button" name="Submit" id="submitMessage" value="SAVE CHANGES" class="button_large" >
   

  </p>


  <input name="mode" type="hidden"  value="<?php echo $mode; ?>">

  <input name="product_id" type="hidden" value="<?php echo $_GET['productid'];?>">



    </div>

 </div>




   

     </div> 

     </div> 

     </div>

        

 </div>








</form>
                        

 

        </div>

        </div>

    	</div>

    </div>

</div>
 

 

<div id="dialog" title="Auction Preview" class="bv_auction_modal" style="display:none;">

    <div class="peekaboo_popup_inner">

        <div class="popup_certificate_area">
          <div class="bv_auction_heading">
          <span class="ui-dialog-title bv_title" id="ui-dialog-title-dialog">Auction Preview</span>
          <span class="bv_close"><i class="fa fa-close"></i></span>
          </div>

            <div class="popup_certificate_heading_top"><span id="popup">Popup Heading</span></div>

            <div><img src="<?php echo base_url() ?>/assets/images/gift_certificate.jpg" title="Gift Certificate" alt="Gift Certificate" style="width:250px;" /></div>

        <div class="popup_certificate_heading_bottom">
 

        </div>

    </div>

    <div class="other-details false_case">

        <p id="first" style="margin: 0 0 0px; padding-bottom: 0px;"><b>Redemption Value: $50.00</b></p>

        <p id="second" style="margin: 0 0 0px; padding-bottom: 0px;"><b>Initial Asking Price: $35.00</b></p>

        <p id="third" style="margin: 0 0 0px; padding-bottom: 0px;"><b>Start Date: 09 / 28 / 2015</b></p>

        <!--<p id="fourth"><b>End Date: 10/28/2015</b></p>-->

        <p id="fourth" style="margin: 0 0 0px; padding-bottom: 0px;"><b style="font-size: 11px;">Claim at Current Asking Price Before:</b></p>

        <p class="extrapadb" id="countdown"><span id="countdown_value"></span> 



</p>

        

    </div>

    

    <div class="current-asking-link">

        <a class="peekaboo_more_details" data-addid="" rel="" data-head="" style="cursor:pointer">

        <!--<a href="http://development.peekabooauctions.com/index.php?page=category&cid=all" style="cursor:text">-->

        

            <span>Current Asking Price $???</span><br />

            <span>Price Peek Uses 2 Credits</span><br />

            <small>You will have 10 seconds to buy!</small>

        </a>

    </div>

     <p id="consolation_first"></p>

    <div class="link-icons">

        <a  style="cursor:text;"><span><img src="<?php echo base_url() ?>/assets/images/wishlist_icon2.png" alt="Wishlist"  /></span> Add to My Auctions</a>

        <a  style="cursor:text;"><span><img src="<?php echo base_url() ?>/assets/images/autobid.png" alt="Autobid"  /></span> Auto Bid & Buy</a>

        <a  style="cursor:text;"><span><img src="<?php echo base_url() ?>/assets/images/alerts.png" alt="Alerts"  /></span> New Auction Alerts</a>

    </div>

  

</div>


<!-- Ending div -->

<!-- Preview popup-->

</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript">


    $(function(){

    $('#hidden_browse').click(function(){

        $('#card_img').click();

    }); 

});

 
function youtubeUrlValidation(a){

    var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;

    var v = /^.*(vimeo\.com\/)((channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;

    if(!a.match(p) && !a.match(v)){

        $('.loginconfirm_link').show();

        $('#deal_description_link').val('');

    }

}



    
$(document).ready(function () { 


        $(document).on('blur','#buy_price_decrease_by',function(){
        console.log($(this).val());

            var redemption = $(this).val();

            var data_to_use = {price:redemption,zoneid:$('#zone_id').val()};

            $.ajax({

                'type':"POST",
 
                 'url':"<?=base_url('Businessdashboard/publisher_fee')?>",

                'data': data_to_use,    

                'cache':false,          

                'success': function(response){ 

                    //alert(response);

                    if(response!=""){

                        $("#redemption_val").val(redemption);

                        $("#publisher_fee").val(response);

                        $("#seller_fee").change();

                    }

                    

                }

            });

    });


// on Redemption input clicked
    $(document).on('keypress','#buy_price_decrease_by',function(e){

        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

        

                $("#errmsg").html("Digits Only").show().fadeOut("slow");

                       return false;

            }

    });

    // on card image changed
    $(document).on('change','#card_img',function(){     

        var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];

        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {            

            $('.error_img_msg').text("Only formats are allowed : "+fileExtension.join(', '));

        }else{

            $('.error_img_msg').text("");

        }

    });


    // On Peeking Credit % changed
    $(document).on('change','#seller_fee',function(){
             

            var seller_fee = $(this).val();

            var redemption = $('.redemption').val();

            //alert(redemption);

            var percentage = (seller_fee * redemption)/100;

            var seller_credit = percentage / 0.25;

            $("#seller_credit").val(Math.round(seller_credit));

    });



$(document).on('click','#popcalend',function(e){

  
        var start_date = $('#start_date').val(); 

        if(start_date == ''){

            alert('Please select start date') ;

        }else{

            var start = new Date(start_date);

            var end = new Date(start_date);

            end.setDate(end.getDate() + 364);

            

            var dates = [] ;

            dates[0] = [start.getFullYear(), start.getMonth(), start.getDate()] ;

            dates[1] = [end.getFullYear(), end.getMonth() + 1, end.getDate()] ;

            dates[2] = [start.getFullYear(), start.getMonth()] ;

            
 

            

            for(i = 0; i < start.getDate() - 1; i++){ // get disable dates of the current month 

                dates.push([start.getFullYear(),(start.getMonth() + 1),(start.getDate() - (i+1))]) ;

            }

            

            for(i = 0; i < start.getMonth(); i++){ // get disable dates of the previous months

                for(j = 0; j <= 30 ; j++){

                    dates.push([start.getFullYear(),(i+1),(j+1)]) ;

                }

            }

            

            //console.log(dates) ;

            gfPop.fPopCalendar(document.frm.end_date, dates);

        }

    })



    $(document).on('click','#popcal',function(e){
 
             
 console.log(document.frm.start_date);

            gfPop.fPopCalendar(document.frm.start_date);

     
    })



    // ++ close preview popup

    $(document).on('click','.close',function(){

        $('#sucess_peekaboo_popup').hide() ;

        clearInterval(timer) ; //stop setinterval

        return false ;

    })


    // -- close preview popup

    // ++ character counter for additional restriction

     var text_max = 100;

    $('#textarea_feedback').html(text_max + ' characters remaining');



    $('#additional_restriction').keyup(function() {

        var text_length = $('#additional_restriction').val().length;

        var text_remaining = text_max - text_length;

        if(text_remaining < 100){

            $('#textarea_feedback').attr('style','color:red ;margin-left: 35px;') ;

        }else{

            $('#textarea_feedback').attr('style','margin-left: 35px;') ;

        }

        $('#textarea_feedback').html(text_remaining + ' characters remaining');

    });

    // -- character counter for additional restriction

    

    

    // # + Deal Condition section Start

        

        var text_conditionmax = 20;

        $('#deal_condition_feedback').html(text_conditionmax + ' characters remaining');

        

        $("#deal_condition").keyup(function () {

            var text_length = this.value.length;

            var text_remaining = text_conditionmax - text_length;

            if(text_remaining < 20){

                $('#deal_condition_feedback').attr('style','color:red;') ;

            }else{

                $('#deal_condition_feedback').attr('style','color:#666;') ;

            }

            $('#deal_condition_feedback').html(text_remaining + ' characters remaining');

        });

    

    

    // # + Deal Description section Start


        var text_descriptionmax = 20;

        $('#deal_description_feedback').html(text_descriptionmax + ' characters remaining');

        

        $("#deal_description").keyup(function () {

            var text_length = this.value.length;

            var text_remaining = text_descriptionmax - text_length;

            if(text_remaining < 20){

                $('#deal_description_feedback').attr('style','color:red;') ;

            }else{

                $('#deal_description_feedback').attr('style','color:#666;') ;

            }

            $('#deal_description_feedback').html(text_remaining + ' characters remaining');

        });

    

    

    // # + Deal Title section Start

        

        var text_max = 100;

        $('#deal_title_feedback').html(text_max + ' characters remaining');

        

        $("#deal_title").keyup(function () {

            this.value = this.value.replace(/ /g, "-");

            var text_length = this.value.length;

            var text_remaining = text_max - text_length;

            

            if(text_remaining < 100){

                $('#deal_title_feedback').attr('style','color:red;') ;

            }else{

                $('#deal_title_feedback').attr('style','color:#666;') ;

            }

            $('#deal_title_feedback').html(text_remaining + ' characters remaining');

        });

        

        // On Short Url  

        $('#deal_title').bind("blur",function () {  

          var deal_title = this.value;

          var product_id = $("input[name='product_id']").val(); 

          var data_to_use = {deal_title:deal_title, product_id:product_id};

            $.ajax({

                'type':"POST",

                 'url':"<?=base_url('Businessdashboard/deal_title')?>",

                'data': data_to_use,    

                'cache':false,          

                'success': function(response){ 

                    if(response == 2){

                         var text_remaining = 100;

                         $('#deal_title').val('');

                         $("#deal_title_msg").html("<h4 style='color:#090'>These Deal title has already existed so give you unique deal title.</h4>").show();

                         setTimeout(function(){

                             $("#deal_title_msg").hide('slow');

                             $('#deal_title_feedback').html(text_remaining + ' characters remaining');

                         },5000);

                    }

                }

            });

        });



 $(function() {

    var text_max = 100;

    var deal_title = $('#deal_title').val();
    if(typeof deal_title  !== "undefined"){
        var text_length = deal_title.length;
    }
    

    var text_remaining = text_max - text_length; //alert(text_remaining);

    if(deal_title!='' && text_remaining<100){

        $('#deal_title_feedback').html(text_remaining + ' characters remaining');

        $('#deal_title_feedback').attr('style','color:red;') ;

    }

    

    // + - Deal Condition value section

    var text_maxcondition = 70;
 

    var dealdescription_maxtext = 70;
    var text_descriptionlength = 0;
    var text_descriptionlength = 0;

    var deal_description = $('#deal_description').val();

    if (deal_description) {
        var text_descriptionlength = deal_description.length;

        var text_conditionremaining = dealdescription_maxtext - text_descriptionlength; //alert(text_remaining);
    }

    

    if(deal_description!='' && text_conditionremaining<70){

        $('#deal_description_feedback').html(text_conditionremaining + ' characters remaining');

        $('#deal_description_feedback').attr('style','color:red;') ;

    }

    // - - Deal Description value section

    

    // + Consolation Cap Value Checking
 
     $(document).on('click','.numberconsoval',function(){

            if($(this).is(":checked")){

              if($(this).val() == 'NO'){

                 $('.noofconsolation_textbox').val(''); 

                 $('input:checkbox').attr('checked',true);

              }

           }else{

               $(this).keyup(function(){

                  var value = $(this).val();

                  if(value!=0){

                     $('input:checkbox').attr('checked',false);

                  }

                });

           }

     });
 

});




        // preview button when clicked
    $(document).on('click','#preview_auction',function(){ 

  
        // $('#sucess_peekaboo_popup').show() ;
         $( "#dialog" ).dialog();

        var timer;

        var business_name = $('#company_name').val() ;

        var certificate_name = $('#product_name').val() ;

        var redemption_value = $('#redemption_val').val() ;

        var asking_value = $('#low_limit_price').val() ;

        var start_date = $('#start_date').val() ;

        var end_date = $('#end_date').val() ;

        var date = new Date(start_date);//alert(start_date) ;alert(date) ;return false ;

        var enddate = new Date(end_date);

        var consolation_price = $('#consolation_price').val();

        var nobypass = $('#nobypass').val() ; 

        

        $('#popup').html(business_name+'<br>'+certificate_name) ;

        $('#first').html('<b>Redemption Value: $'+redemption_value+'</b>') ;

        $('#second').html('<b>Initial Asking Price: $'+asking_value+'</b>') ;

        $('#consolation_first').html('<p class="extrapadbcert new2">Consolation Certificate Available?<br>Yes after '+nobypass+' Bypasses. Buy at $'+consolation_price+'</p>')

        if(start_date != '' && end_date != ''){

            $('#countdown').show() ;

            $('#third').html('<b>Start Date: '+(date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear()+'</b></br>') ;

            $('#third').append('<b>End Date: '+(enddate.getMonth() + 1) + '/' + enddate.getDate() + '/' +  enddate.getFullYear()+'</b>') ;

            CountDownTimer("countdown_value");

        }else{

            $('#third').html('<b>Start Date: </b></br>') ;

            $('#third').append('<b>End Date: </b>') ;

            $('#countdown').hide() ;

        }

    });

    $('#business_peekaboo_accordian').click();

    $('#business_peekaboo_accordian').next().slideDown();




    $('#peekaboo_details').click();

    $('#peekaboo_details').next().slideDown();

    $('#peekaboo_access_link').addClass('active');

    //$('#webinar_infoinformation1').addClass('active');

});

// + countdown function

function CountDownTimer(id){//alert(id) ;

        //var end = new Date($('#start_date').val());

        //end.setDate(end.getDate() + 365);// set end date

        var end = new Date($('#end_date').val());

        var _second = 1000;

        var _minute = _second * 60;

        var _hour = _minute * 60;

        var _day = _hour * 24;



        function showRemaining() {

            var now = new Date(); 

            // change to UTC 

            //var now_utc = new Date(now.getUTCFullYear(), now.getUTCMonth(), now.getUTCDate(),  (now.getUTCHours()+1), now.getUTCMinutes(), now.getUTCSeconds());  console.log(end) ;console.log(now) ;// organize date format

            var distance = end - now;

            if (distance < 0) {

                clearInterval(timer);

                document.getElementById(id).innerHTML = 'EXPIRED!';

                return;

            }

            var days = Math.floor(distance / _day);

            var hours = Math.floor((distance % _day) / _hour);

            var minutes = Math.floor((distance % _hour) / _minute);

            var seconds = Math.floor((distance % _minute) / _second);



            document.getElementById(id).innerHTML = days + ':';

            document.getElementById(id).innerHTML += hours + ':';

            document.getElementById(id).innerHTML += minutes + ':';

            document.getElementById(id).innerHTML += seconds + '';

        }

        timer = setInterval(showRemaining, 1000);

}


     $(".sortlist_tags").click(function(e){
        e.preventDefault();
    

    $('.loadersave').css('display','inline-block');
 
      var auction_id = $(this).attr('data-id');
      var data_to_use = {auction_id:auction_id};
      $.ajax({
        type:"POST",
        url:"<?=base_url('Businessdashboard/upload_auction_list')?>",
        data:data_to_use,
        success:function(data){
          data = JSON.parse(data);

          if(data){

         var  endindatecount =parseFloat(data[0].end_date) + parseFloat(data[0].start_date);
       

           $('.redemption').val(data[0].redemption_val);
            $('#redemption_val').val(data[0].redemption_val);
            $('#publisher_fee').val(data[0].donantion_fee);
            $('#max_sold_per_auction').val(data[0].max_sold_per_auction);
            $('#seller_credit').val(data[0].credit_claim);

             $("#cert_accept_yes").prop("checked", true);
             $('.consolation_view').slideDown(1000);
           
           $('.low_limit_price').val(data[0].starting_price);
           $('.consolation_price').val(data[0].consolation_cash_cert);

           
            var startdates = new Date(new Date().getTime()+(parseFloat(data[0].start_date)*24*60*60*1000));

                var starttime =   startdates.getFullYear() + "-"
                + (startdates.getMonth()+1)  + "-" 
                + startdates.getDate() + " "  
                + startdates.getHours() + ":"  
                + startdates.getMinutes()               



           $('#start_date').val(starttime);     
        

            var currentdate = new Date(new Date().getTime()+(endindatecount*24*60*60*1000));

       var datetime =   currentdate.getFullYear() + "-"
                + (currentdate.getMonth()+1)  + "-" 
                + currentdate.getDate() + " "  
                + currentdate.getHours() + ":"  
                + currentdate.getMinutes() 
               

           $('#end_date').val(datetime);

$('.loadersave').css('display','none');
           //  alert("Congratulations! Values got populated");
            // $("#organization_modal").mod al("hide");
          } else{
           // swal("Error", "Sorry some error occurred,please try again", "error");

          }

        },
        error:function(error){

        }
      });
    


$(function() {

    $('#color_card').on('click',function(){

        $('#loginconfirm1').show();

        $('#loginconfirm2').hide();

        $('#loginconfirm3').hide();

        $('#loginconfirm4').hide();

    });

    

    $('#card_upload').on('click',function(){

        $('#loginconfirm2').show();

        $('#loginconfirm1').hide();

        $('#loginconfirm3').hide();

        $('#loginconfirm4').hide();

    });

    

    $('#deal_condition_popup').on('click',function(){

        $('#loginconfirm3').show();

        $('#loginconfirm1').hide();

        $('#loginconfirm2').hide();

        $('#loginconfirm4').hide();

    });

    

    $('#deal_description_popup').on('click',function(){

        $('#loginconfirm4').show();

        $('#loginconfirm1').hide();

        $('#loginconfirm2').hide();

        $('#loginconfirm3').hide();

    });

    

    

    $('.closeloginconfirm').on('click',function(){ 

        $('#loginconfirm1').hide();

        $('#loginconfirm2').hide();

        $('#loginconfirm3').hide();

        $('#loginconfirm4').hide();

        //$('.loginconfirm_link').hide();

        $(this).parent('div').hide();

    });



    

});



$(document).on('change','.cert_accept_yes',function(){ 

   if ($(this).val() == 'accepted') {

    $('.consolation_view').slideDown(1000);

   }else  if ($(this).val() == 'notaccepted'){

    $('.consolation_view').slideUp(1000);

    //$('#consolation_price').val('');

    //$('#nobypass').val('');

   }



});







$(document).on('click','.video',function(){

    $('.loginconfirm_link').hide();

});





$('input:radio[name="postage"]').change(

    function(){

        if ($(this).val() == 'Yes') {

            $(appended).appendTo('body');

        }

        else {

            $(appended).remove();

        }

    });



    });






$("#submitMessage").click(function(e){
   e.preventDefault();
     if($("#catID").val() =='' || $("#start_date").val() =='' || $("#end_date").val() =='' || $("#low_limit_price").val() =='' || $("#consolation_price").val() ==''  || $("#page_title").val() ==''  || $("#deal_title").val() =='' || $("#deal_description").val() ==''){
       alert('Please Enter all required fields');

     }else{    

 
              // var form_data = new FormData();
              // form_data.append('file', $('#card_img').get(0).files);

              var form_data = new FormData($('.auctioncreate')[0]);


   
               $.ajax({

                  'type':"POST",

                   'url':"<?=base_url('Businessdashboard/insert_peekaboo_auction')?>",

                  'data': {'data_to_use': $(".auctioncreate").serialize()  },    

                         

                  'success': function(response){ 

                     window.location.href = "https://savingssites.com/businessdashboard/allauctions/<?php echo $businessid ?>/<?php echo $zoneid ?>";
                         
                  }

              });


     }
});

 $( "#start_date" ).datetimepicker({ format:'Y-m-d H:s' });
  $( "#end_date" ).datetimepicker({ format:'Y-m-d H:s' });

$('.tooltips').append("<span class='bv_toolkit'></span>");
$('.tooltips:not([tooltip-position])').attr('tooltip-position','bottom');


$(".tooltips").mouseenter(function(){
 $(this).find('span').empty().append($(this).attr('tooltip'));
});

$('body').addClass('bv_create_auction');

$( ".bv_close" ).click(function() {
  $( ".ui-dialog" ).toggleClass('remove');
});




$( "#preview_auction" ).click(function() {
  $( ".ui-dialog" ).removeClass('remove');
});

</script>