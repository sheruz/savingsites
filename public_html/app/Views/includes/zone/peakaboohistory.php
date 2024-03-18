<style>

.ui-widget.success-dialog {

    font-family: Verdana,Arial,sans-serif;

    font-size: .8em;

}



.ui-widget-content.success-dialog {

    background: #F9F9F9;

    border: 2px solid #ACB2A5;;

    color: #222222;

}



.ui-dialog.success-dialog {

    left: 0;

    outline: 0 none;

    padding: 0 !important;

    position: absolute;

    top: 0;

}



.ui-dialog.success-dialog .ui-dialog-content {

    background: none repeat scroll 0 0 transparent;

    border: 0 none;

    overflow: auto;

    position: relative;

    padding: 0 !important;

    margin: 0;

}



.ui-dialog.success-dialog .ui-widget-header {

    background: lightgrey;

    border: 0;

    color: #000;

    font-weight: normal;

}



.ui-dialog.success-dialog .ui-dialog-titlebar {

    /*padding: 0.1em .5em;*/

    position: relative;

      font-size: 19px;

    height: 25px;

}

</style>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
 

<link href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.css" rel="stylesheet" type="text/css" />

<input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid; ?>"/>

<input type="hidden" id="businessdata" name="businessdata" value="<?php echo $zoneid;?>"/>

<div class="main_content_outer">

  <div class="content_container">
 <h2 ><b>All Auctions </b></h2><br/>

<div class="cus_div">
    <div class="cus_div-child">
<div class="datecolumnsection">   
<label>Sort:</label>
</div>
 <div class="datecolumnsection">              
  <input class="form-control" placeholder="Start Date" type="text" id="min" />
</div>  
  
   
 <div class="datecolumnsection">
    <input class="form-control" placeholder="End Date" type="text" id="max" />
</div>

</div>
     

 <table id="table_id" class="display mk">
    <thead>
        <tr>
            <th>Invoice</th>
            <th style="display: none;">Auction ID</th>
            <th style="display: none;">Auction Name</th>  
            <th style="display: none;">Seller Name</th>
            <th style="display: none;">Seller Address</th>
            <th style="display: none;">Seller City</th>
            <th style="display: none;">Seller Zip Code</th>
            <th style="display: none;">Seller Phone</th>
            <th style="display: none;">Seller Email</th>
            <th>Business Name</th>
            <th>Page Title</th>

            <th style="display: none;">Redemption Value</th>  

            <th style="display: none;">Buyer Name</th>
            <th style="display: none;">Buyer Address</th>
            <th style="display: none;">Buyer City</th>
            <th style="display: none;">Buyer State</th>
            
            <th style="display: none;">Buyer Email</th>
            <th style="display: none;">Buyer Phone</th>   

            <th style="display: none;">Start Date</th>
            <th style="display: none;">End  Date</th>         
            <th style="display: none;">Publisher Fee</th>
            <th style="display: none;">Starting Price to Claim Redemption</th>
            <th style="display: none;">Description</th>
            <th>PurchasedAt</th>
            
        </tr>
    </thead>
    <tbody>

      <?php       foreach ($dealsdata as  $value) {      ?>
        <tr>
            <td><?php echo $value['invoice'] ?></td>
            <td style="display: none;"><?php echo $value['auc_id'] ?></td>         
            <td style="display: none;"><?php echo $value['auc_name'] ?></td>



            <td style="display: none;"><?php echo $value['seller_name'] ?></td>
            <td style="display: none;"><?php echo $value['seller_address'] ?></td>
            <td style="display: none;"><?php echo $value['seller_city'] ?></td>
          
            <td style="display: none;"><?php echo $value['seller_phone'] ?></td>
            <td style="display: none;"><?php echo $value['seller_email'] ?></td>


            <td><?php echo $value['business_name'] ?></td>
            <td><?php echo $value['page_title'] ?></td>

            <td style="display: none;"> $<?php echo $value['buy_price_decrease_by'] ?></td>
    


            <td style="display: none;"><?php echo $value['buyer_name'] ?></td>
            <td style="display: none;"><?php echo $value['buyer_address'] ?></td>
            <td style="display: none;"><?php echo $value['buyer_city'] ?></td>
            <td style="display: none;"><?php echo $value['buyer_state_name'] ?></td>
            <td style="display: none;"><?php echo $value['buyer_post_code'] ?></td>
            <td style="display: none;"><?php echo $value['buyer_email'] ?></td>
            <td style="display: none;"><?php echo $value['buyer_phone'] ?></td>


            <td style="display: none;"> <?php echo $value['start_date'] ?></td>
            <td style="display: none;"> <?php echo $value['end_date'] ?></td>     
            <td style="display: none;"> $<?php echo $value['publisher_fee'] ?></td>
            <td style="display: none;"> $<?php echo $value['low_limit_price'] ?></td>
            <td style="display: none;"> <?php echo $value['deal_description'] ?></td>         
            <td><?php echo $value['pay_time'] ?></td>       
        </tr> 
      <?php  } ?>
        
       
    </tbody>
</table>
    </div>
  
 

  </div>

</div>
 

<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.js"></script>    
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>    
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>    
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script> 

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script type="text/javascript">

$(document).ready(function () { 

  $('#business_peekaboo_accordian').click();

  $('#business_peekaboo_accordian').click();
    
    $('#business_peekaboo_accordian').click();

    $('#business_peekaboo_accordian').next().slideDown();


  $('#peekaboohistory').addClass('active');

  $('.allbusinesssub').slideDown('slow');
 
  $("input[name=checkadfordelete]").attr('checked',false);

  $('#search_business').click();

});




 
  $( "#min" ).datepicker({ dateFormat: "yy-mm-dd" });
  $( "#max" ).datepicker({ dateFormat: "yy-mm-dd" });

 
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {    
        var min = $('#min').val()
        var max = $('#max').val();
        var GivenDate =  data[8];   
 
 GivenDate = new Date(GivenDate);
 MiniDate = new Date(min);
  MaxiDate = new Date(max);



 
    
     if( (min != '') && (max != '')  ){

 
        if ( (MiniDate <= GivenDate) && (MaxiDate >= GivenDate))
        {
            
           return true;
            
        } 
      
     }else if( (min == '') && (max != '')  ){

        if (MaxiDate >= GivenDate)
        {
           
            return true;
            
        } 
     }else if( (min != '') && (max == '')  ){

        if ( MiniDate <= GivenDate )
        {
             
          return true;
            
        } 
     }else if( (min == '') && (max == '')  ){
           return true;
     }else{
        return false
     }
        
 
         
       
    }
);


 
$(document).ready(function() {

    var table = $('#table_id').DataTable({
        dom: 'Bfrtip',
        searching: true,
        buttons: [           
            'csvHtml5'            
        ]
});
     
    
 $( "#min" ).datepicker()
    .on("input change", function (e) {
    table.draw();
});
$( "#max" ).datepicker()
    .on("input change", function (e) {
     table.draw();
});


} );
  
 

 

</script>