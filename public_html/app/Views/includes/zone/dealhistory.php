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
 <h2 ><b>All Deals</b></h2><br/>

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
            <th>Business Name</th>
            <th>Deal Name</th>
            <th style="display: none;">Redemption Value</th>
            <th style="display: none;">Length of Time to Display</th>
            <th style="display: none;">Deal Start Date</th>
            <th style="display: none;">Deal End  Date</th>   
            <th style="display: none;">Page Title</th>
            <th style="display: none;">Publisher Fee</th>
            <th style="display: none;">Starting Price to Claim Redemption</th>
            <th style="display: none;">Deal Description</th>
           
            <th>Category Name</th>
            <th>PurchasedAt</th>
            
        </tr>
    </thead>
    <tbody>

      <?php        foreach ($dealsdata as  $value) {       ?>
        <tr>
            <td><?php echo $value['company_name'] ?></td>
            <td><?php echo $value['product_name'] ?></td>
            <td style="display: none;"> $<?php echo $value['buy_price_decrease_by'] ?></td>
            <td style="display: none;">30 </td>
            <td style="display: none;"> <?php echo $value['start_date'] ?></td>
            <td style="display: none;"> <?php echo $value['end_date'] ?></td>        
            <td style="display: none;">  <?php echo $value['page_title'] ?></td>
            <td style="display: none;"> $<?php echo $value['publisher_fee'] ?></td>

            <td style="display: none;"> $<?php echo $value['low_limit_price'] ?></td>
            <td style="display: none;"> <?php echo $value['tech_description'] ?></td>


         
            <td><?php echo $value['categoryname'] ?></td>    
            <td><?php echo $value['purchasedAt'] ?></td>    
        
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

  $('#business_deals_accordian').click();

  $('#business_deals_accordian').click();
    
    $('#business_deals_accordian').click();

    $('#business_deals_accordian').next().slideDown();


  $('#dealhistory').addClass('active');

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
        var GivenDate =  data[11];   
 
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