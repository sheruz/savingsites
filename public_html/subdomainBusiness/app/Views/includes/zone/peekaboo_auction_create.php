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
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">

 

<input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>

<input type="hidden" id="businessdata" name="businessdata" value="<?php echo $zoneid;?>"/>

<div class="main_content_outer">

  <div class="content_container">
 <h2 class="text-center">All Auctions</h2><br/>
 <table id="table_id" class="display">
    <thead>
        <tr>
            <th>Business Name</th>
          
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

      <?php      foreach ($auctiondata as  $value) {       ?>
        <tr>
            <td style="text-align:left;"><?php echo $value['name'] ?></td>
          
            <td>
                <a href="<?php echo base_url() ?>/businessdashboard/peekaboo_createauction/<?php echo $value['businessid']; ?>/<?php echo $zoneid; ?>">Add Auction</a>   
            </td>
        </tr> 
      <?php      } ?>
        
       
    </tbody>
</table>
    
  
 

  </div>

</div>

<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script type="text/javascript">

$(document).ready(function () { //alert(1); 

    $('#zone_business_accordian').click();

    $('#business_data_accordian').click();
    
    $('#business_peekaboo_accordian').click();

    $('#business_peekaboo_accordian').next().slideDown();


    $('#peekaboo_section').addClass('active');

    $('.allbusinesssub').slideDown('slow');
 
    $("input[name=checkadfordelete]").attr('checked',false);

    $('#search_business').click();

});

$(document).ready( function () {

   table=   $('#table_id').DataTable( {
    responsive: true
} );
   
    $(".deleteAction").click(function(e){
        e.preventDefault();

        console.log('clicked');

        $productid = $(this).attr('data-id');

              $.ajax({

                  'type':"POST",

                   'url':"<?=base_url('Businessdashboard/deleteaction')?>",

                  'data': {'data_to_use': $productid   },                            

                  'success': function(response){   
                       
                       location.reload();    
                         
                  }

              });




    });

  

} );
  

</script>