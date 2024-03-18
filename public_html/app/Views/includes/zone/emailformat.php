<style type="text/css">
  .box {
    float: left;
    width: 30%;
    /*height: 180px;*/
    text-align: center;
    margin-left: 9%;
    /*border: 1px solid #999;*/
    background: #fff;
}
.crosssign{
  position: absolute;
    right: 5px;
    top: 3px;
    color: red;
    font-size: 18px
    z-index: 9999999;
    cursor: pointer;
}
.slot1 {
    position: relative;
    width: 100%;
    min-height: 64px;
    margin-top: 2px;
    margin: 0 auto;
    border: 1px solid #ccc;
}

div#A1 {
    margin-top: 53px;
}


.slot2 {
   position: relative;
    width: 100%;
    min-height: 58px;
    margin: 0 auto;
    margin-bottom: 14px;
    border: 1px dotted #ccc;

  
}
.slot2  .searchResult{
      width: 100%;
    height: 41px;
    margin-top: 6px;
    margin-bottom: 11px!important;
}

.item {
    width: 100%;
    position: relative;
    margin: 0 auto;
    z-index: 1;
    background-color: #fff;
 
    padding: 20px;
    cursor: default;

    -webkit-box-shadow: 2px 2px 5px 0px rgb(191 194 235);
    -moz-box-shadow: 2px 2px 5px 0px rgba(191,194,235,1);
    box-shadow: 2px 2px 5px 0px rgb(191 194 235);
    text-transform: uppercase;
    height: 100%;
        padding-top: 18px;
    font-weight: 800;
}
.ui-selecting {
    background: #FECA40;
}
.ui-selected {
    background-color: #F90;
}
.green3 {
    background-color: #D9FFE2;
}


.loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}
.keysform p.form-group-row{
  width: 22%;
    display: inline-block;
}
.keysform p.form-group-row label.fleft.w_100.m_top_0i.cus-user{font-size: 15px;
    color: #333;}
 .keysform   input[type="text"] ,  .keysform   input[type="password"] ,  .keysform   input[type="username"]  {
    height: 37px;
}
.keysform {    padding-top: 20px; }
.container_tab_content{
      box-shadow: 0px 1px 11px rgb(0 0 0 / 9%);
    padding-bottom: 14px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>

<div class="main_content_outer"> 

  

<div class="content_container">

  <?php if($common['from_zoneid']!='0'){?>

 
   

<?php } 

if($common['where_from']=='zone'){?>

 


<?php } 

 
?>
  <div class="container_tab_header"> AWS SES SMTP Details</div>
 
  <div id="container_tab_content" class="container_tab_content">
     
   
    <div class="keysform">
         <p class="form-group-row">

                    <label for="username" class="fleft w_100 m_top_0i cus-user">Email : <b> <input type="text" name="email" value="<?php echo @$keyaws['email'] ?>"></b></label>

    </p>



    <p class="form-group-row">

                    <label for="username" class="fleft w_100 m_top_0i cus-user">Username : <b> <input type="text" name="username" value="<?php echo @$keyaws['username'] ?>"></b></label>

                    </p>

     <p class="form-group-row">

                    <label for="username" class="fleft w_100 m_top_0i cus-user">Password : <b> <input type="password" name="passowrd" value="<?php echo @$keyaws['password'] ?>"></b></label>

     </p>

    <p class="form-group-row">

                    <label for="username" class="fleft w_100 m_top_0i cus-user">Region : <b> <input type="text" name="region" value="<?php echo @$keyaws['region'] ?>"></b></label>

    </p>

   <input type="button" name="buttonsubmit" class="buttonsubmit btn" value="Submit">
 </div>


  </div>

  <br/>
  <br/>



  <div class="container_tab_header"> Deals Emails Format</div>

  <div id="container_tab_content" class="container_tab_content">
 

        

        <div id="tabs-1">
 
<div class="container_tab_header bv_assigned_zip" style="/*background-color:#d2e08f;*/ font-size:18px;margin-top:20px; margin-bottom:0px;"> </div>                
  

  <?php if(!empty($not_zip_codes)){ ?>

  <select id="zipToAdd">

  <? foreach($not_zip_codes as $zip){?>

  <option value="<?=$zip['ZIP5']?>">

  <?=$zip['ZIP5']?>

  (

  <?=$zip['City']?>

  )</option>

  <?}?>

  </select>

  <!--<input type="image" class="img16" src="<?=base_url('assets/images/Button-Add-icon.png')?>" onclick="addZipToZone(<?=$zoneid?>);return false;"/> 

  <input type="button" onclick="addZipToZone(<?=$zoneid?>);return false;" title="Add this zip code to <b><?=$zone->name?></b> zone" value='Add this zip code to <strong><?=$zone->name?></strong> zone'/>-->

  <button onclick="addZipToZone(<?=$zoneid?>);return false;"  title="Add this zip code to <?=$zone->name?> zone">Add this zip code to <strong><?=$zone->name?></strong> zone</button>

  <br />

  <?php } ?>

<!-- Athena eSolutions end -->

<?php  

  // echo "<pre>"; print_r(json_decode($resultdata['emailformat'])  );echo "</pre>";

$EmailformatingSaved = json_decode($resultdata['emailformat']); 



 

function search($items, $id, $key = null) {
  foreach( $items as $item ) {
    if( $item->value == $id ) {
      $key =  $item ;
      return $item;
      break;
    }
  }

  return null;
}

function searchposition($items, $id, $key = null) {
  foreach( $items as $item ) {
    if( $item->position == $id ) {
      $key =  $item ;
      return $item;
      break;
    }
  }

  return null;
}

$item = search($EmailformatingSaved, 'Snap', 'value');
 
 
?>

<div id="container">
  <div class="row text-right">  
      <input  style="margin-right: 15px;" class="sendemail" type="button" name="" value="Send Email"> 
  </div>
</div>
<br/>

 <div id="container">
    <div id="boxA" class="box">
        <div id="A1" data-position='1' class="slot1 slot ">
              <?php if(@$EmailformatingSaved){
                  $first = searchposition(@$EmailformatingSaved, '1', 'position'); 
                 if(@$first){
                    if(@$first->value !='business'){  ?>
                    <div id="b2"  data-id='<?php echo $first->value ?>'  class="item activeProp"><?php echo $first->value ?> List</div> 
                    <?php  }else if(@$first->value =='business'){  ?>
                       <div id="b2"  data-id="business" data-bid='<?php echo @$first->busid ?>' data-username='<?php echo @$first->username ?>'  class="item  activeProp"><?php echo $first->username ?><span class="crosssign"><i class="fa fa-times" aria-hidden="true"></i></span></div> 
                   <?php  } 
               }
              } ?>
        </div>
        <div id="A2"  data-position='2' class="slot1 slot">
           <?php if(@$EmailformatingSaved){
                  $first = searchposition(@$EmailformatingSaved, '2', 'position'); 
               if(@$first){
                 if(@$first->value !='business'){  ?>
                  <div id="b2"  data-id='<?php echo $first->value ?>'  class="item activeProp"><?php echo $first->value ?> List</div> 
                  <?php  }else if(@$first->value =='business'){  ?>
                     <div id="b2"  data-id="business" data-bid='<?php echo @$first->busid ?>' data-username='<?php echo @$first->username ?>'  class="item activeProp"><?php echo $first->username ?><span class="crosssign"><i class="fa fa-times" aria-hidden="true"></i></span></div> 
                 <?php  }  }
              } ?>
           
        </div>
        <div id="A3" data-position='3' class="slot1 slot">
          <?php if(@$EmailformatingSaved){
                  $first = searchposition(@$EmailformatingSaved, '3', 'position'); 
               if(@$first){
                  if(@$first->value !='business'){  ?>
                  <div id="b2"  data-id='<?php echo $first->value ?>'  class="item activeProp"><?php echo $first->value ?> List</div> 
                  <?php  } else if(@$first->value =='business'){  ?>
                     <div id="b2"  data-id="business" data-bid='<?php echo @$first->busid ?>' data-username='<?php echo @$first->username ?>'  class="item activeProp"><?php echo $first->username ?><span class="crosssign"><i class="fa fa-times" aria-hidden="true"></i></span></div> 
                 <?php  } 
               } 
              } ?>
        </div>
        <div id="A4" data-position='4' class="slot1 slot">
            <?php if(@$EmailformatingSaved){
                  $first = searchposition(@$EmailformatingSaved, '4', 'position'); 
               if(@$first){
                if(@$first->value !='business'){  ?>
                  <div id="b2"  data-id='<?php echo $first->value ?>'  class="item activeProp"><?php echo $first->value ?> List</div> 
                  <?php  } else if(@$first->value =='business'){  ?>
                     <div id="b2"  data-id="business" data-bid='<?php echo @$first->busid ?>' data-username='<?php echo @$first->username ?>'  class="item activeProp"><?php echo $first->username ?><span class="crosssign"><i class="fa fa-times" aria-hidden="true"></i></span></div> 
                 <?php  }  }
              } ?>
        </div>
        <div id="A5" data-position='5' class="slot1 slot">
            <?php if(@$EmailformatingSaved){
                  $first = searchposition(@$EmailformatingSaved, '5', 'position'); 
               if(@$first){

                     if(@$first->value !='business'){  ?>
                  <div id="b2"  data-id='<?php echo $first->value ?>'  class="item activeProp"><?php echo $first->value ?> List</div> 
                  <?php  } else if(@$first->value =='business'){  ?>
                     <div id="b2"  data-id="business" data-bid='<?php echo @$first->busid ?>' data-username='<?php echo @$first->username ?>'  class="item activeProp"><?php echo $first->username ?><span class="crosssign"><i class="fa fa-times" aria-hidden="true"></i></span></div> 
                 <?php  }  }
              } ?>
        </div>
          <div id="A6" data-position='6' class="slot1 slot ">       
               <?php   $first = searchposition(@$EmailformatingSaved, '6', 'position');   
 
                     if(@$first->value =='content'){ 

                        $val1 = @$first->dataValue;
                       }     ?>
                  <div id="b6"  data-id='content'  class="  activeProp"> 
                    <textarea style="width: 100%;font-weight: 100;" placeholder="Enter the Description"><?php echo @$val1; ?></textarea> 
                  </div> 
                 
        </div>

<br/>
        <input type="button" name="submitformat" value="Submit">

    </div>
    <div id="boxB" class="box">
         
         <h3  style="font-weight: 800;margin-bottom: 24px;">FILTERS</h3>

                  
                 <div id="B1" class="slot2 slot" data-text="Enter text here">      
                 <?php $Favourit = search(@$EmailformatingSaved, 'Favourities', 'value');  
                     if(!@$Favourit){    ?>    
                  <div id="b2"  data-id='Favourities'  class="item activeProp">Favourities List</div>       

                  <?php } ?>  
                </div>             
              
              <div id="B2" class="slot2 slot">
                   <?php $Snap = search(@$EmailformatingSaved, 'Snap', 'value');  
                     if(!@$Snap){    ?> 
                  <div id="b2" data-id='Snap'  class="item activeProp">Snap List</div>
                   <?php } ?>  
              </div>

              <div id="B3" class="slot2 slot">
                 <?php $Ranked = search(@$EmailformatingSaved, 'Ranked', 'value');  
                     if(!@$Ranked){    ?> 
                <div id="b2" data-id='Ranked'  class="item activeProp">Ranked</div><?php } ?>  
              </div>
           
      

            <div id="B5" class="slot2 slot"> 
             <input type="text" name="" placeholder ="Search Business Name" class="searchResult">
            <div class="searchresult"></div>            

          </div>

        
    </div>
</div>
 
            </div>

        </div>

    
    </div>

    

    

</div>



</div>


<div class="loader"></div>


<script type="text/javascript">

$(document).ready(function () { 

  $('#zone_data_accordian').click();

  $('#zone_data_accordian').next().slideDown();

  $('#zone_zip').addClass('active');

  $('#about_content1').hide();

});

 

$(function () {

    var dragOption = {
        delay: 10,
        distance: 5,
        opacity: 0.45,
        revert: "invalid",
        start: function (event, ui) {
            $(".ui-selected").each(function () {
                $(this).data("original", $(this).position());
            });
        },
        drag: function (event, ui) {
            var offset = ui.position;
            //console.log(ui, this)
            $(".ui-selected").not(this).each(function () {
                var current = $(this).offset(),
                    targetLeft = document.elementFromPoint(current.left - 1, current.top),
                    targetRight = document.elementFromPoint(current.left + $(this).width() + 1, current.top);
                $(this).css({
                    position: "relative",
                    left: offset.left,
                    top: offset.top
                }).data("target", $.unique([targetLeft, targetRight]));
                //console.log($.unique([targetLeft, targetRight]));
            });
        },
        stop: function (event, ui) {
            validate($(".ui-selected").not(ui.draggable));
        }
    }, dropOption = {
        accept: '.item',
        activeClass: "green3",
        greedy: true,
        drop: function (event, ui) {
         
 
 

            if ($(this).is(".slot") && !$(this).has(".item").length) {
              

                $(this).append(ui.draggable.css({
                    top: 0,
                    left: 0
                }));
            } else {
                console.log("reverting")
                ui.draggable.animate({
                    top: 0,
                    left: 0
                }, "slow");
            }
            validate($(".ui-selected").not(ui.draggable));
        }
    }

    $(".box").selectable({
        filter: ".item",
        start: function (event, ui) {
            $(".ui-selected").draggable("destroy");
        },
        stop: function (event, ui) {
            $(".ui-selected").draggable(dragOption)
        }
    });
    $(".slot").droppable(dropOption);

    function validate($draggables) {

        $draggables.each(function () {  
            console.log($($(this).data("target")));
            var $target = $($(this).data("target")).filter(function (i, elm) {
                console.log($(this).is(".slot") && !$(this).has(".item").length);
                return $(this).is(".slot") && !$(this).has(".item").length;
            });
            console.log($target);
            if ($target.length) {
                $target.append($(this).css({
                    top: 0,
                    left: 0
                }))
            } else {
                $(this).animate({
                    top: 0,
                    left: 0
                }, "slow");
            }

        });
        $(".ui-selected").data("original", null)
            .data("target", null)
            .removeClass("ui-selected");
    }
});

$(document).on('click','#claim_zip',function(){

  var zone_id=<?=$zoneid?>;

  window.location.href='<?=base_url('Zonedashboard/claim_zips')?>/'+zone_id;  

});



 
//setup before functions
var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example

//on keyup, start the countdown
$('.searchResult').keyup(function(){
    clearTimeout(typingTimer);
    if ($('.searchResult').val) {
        typingTimer = setTimeout(function(){
            //do stuff here e.g ajax call etc....
             var v = $.trim($(".searchResult").val());
   
         
              $.ajax({

                   type:"POST",

                   data:{'searchkey': v,'zoneid':zone_id},                   

                   url: "<?=base_url('/Zonedashboard/searchBusinessads/')?>",      

                   cache: false,

                   success: function(data){  
 
                        
                        $('.searchresult').html(data);
                        $('.searchResult').val(' ');

                      }

            });

        }, doneTypingInterval);
    }
});






function  check_authneticate(){ //alert(1);

  var is_authenticated=0;

  $.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');

    is_authenticated=data;

  }});  

  return is_authenticated;

}



function removeZipFromZone(zip, zoneId, title) {

  var authenticate=check_authneticate();

  if(authenticate=='0'){

    var zone_id = <?=$zoneid?>;      

    alert('You are currently logged out. Please log in to continue.');

    window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;      

  }else if(authenticate==1){

    var dataToUse = { "id": zoneId, "zipcode": zip };

    ConfirmDialog("Really remove : " + title + " from this zone?", "Warning", "<?=base_url('Zonedashboard/removeZipFromZone')?>",

      "Remove zip code from this zone<br/>This may take a few minute", dataToUse, UpdateZips, null);

   }

}



function UpdateZips(result) { 

    $.unblockUI();

  if(result.Tag==''){

    $("#tabs-1").html('Problem in Assign to Zip. Please Try again later.');

    window.location.reload;

  }else{

      $("#tabs-1").html(result.Tag);

      window.location.reload;

  }

}

function addZipToZone(zoneId) {

  var authenticate=check_authneticate();

  if(authenticate=='0'){

    var zone_id = <?=$zoneid?>;      

    alert('You are currently logged out. Please log in to continue.');

    window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;      

  }else if(authenticate==1){

    var zip_id = $("#zipToAdd").val(); 

    var data = { "zone_id": zoneId, "zipcode": zip_id };

    PageMethod("<?=base_url('Zonedashboard/addZipToZone')?>", "Add zip code to this zone...<br/>This may take a few minutes", data, UpdateZips, null);

  }

}

$(document).on('click' , '.crosssign' , function(e){
    e.preventDefault();
    $(this).parents('.item').remove();
    
});



$('input[name="submitformat"]').click(function(){
var splashArray = new Array();
$('#boxA .slot').each(function(){

   dataAttr = $(this).find('.activeProp').attr('data-id'); 
   dataPosition = $(this).attr('data-position'); 
   datausername = $(this).find('.activeProp').attr('data-username');
   databid = $(this).find('.activeProp').attr('data-bid');
 
      console.log(dataAttr , 'dataAttr');
    if(dataAttr == 'business'){
             
        splashArray.push({
                    value: dataAttr, 
                    position:  dataPosition ,
                    username: datausername,
                    busid: databid
                });  

    }else if(dataAttr == 'content'){
             
        splashArray.push({
                    value:dataAttr , 
                    dataValue:$(this).find('textarea').val().replace(/'/g, ' ').replace(/"/g, ' ')  , 
                    position:  dataPosition 
                });  

    }
  else if(typeof  dataAttr != 'undefined'){
             
        splashArray.push({
                    value: dataAttr, 
                    position:  dataPosition 
                });  

    }
  
})
       

   

              $.ajax({

                   type:"POST",

                   data:{'dataarray': splashArray,"zone_id": <?=$zoneid?>},                   

                   url: "<?=base_url('/Zonedashboard/addemailformat/')?>",      

                   cache: false,

                   success: function(data){  
 
                        
                        location.reload();


                      }

            });


});


$('.sendemail').click(function(e){
 e.preventDefault();
       $.ajax({

                   type:"POST",

                   data:{ "zone_id": '<?=$zoneid?>'},                   

                   url: "<?=base_url('/Zonedashboard/sendEmailSnapONUSer/')?>",      

                   cache: false,
                    beforeSend : function() {
                   // alert('I will run first');
                        // This will run before sending an Ajax request.
                        // Do whatever activity you want, like show loaded.
                    },

                   success: function(data){  
 
                        
                      // location.reload();


                      }

            });

})




$('.buttonsubmit').click(function(e){
 e.preventDefault();

   
       $.ajax({

                   type:"POST",

                   data:{ "zone_id": '<?=$zoneid?>' , 'username':$('.keysform').find('input[name=username]').val() ,'email':$('.keysform').find('input[name=email]').val()   ,   'password':$('.keysform').find('input[name=passowrd]').val() , 'region':$('.keysform').find('input[name=region]').val()},                   

                   url: "<?=base_url('/Zonedashboard/saveawskeys/')?>",      

                   cache: false,

                   success: function(data){  
 
                        
                       location.reload();


                      }

            });

})
</script>