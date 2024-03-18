<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
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
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">

 

<input type="hidden" id="zoneid" name="zoneid" value="<?php echo $zoneid;?>"/>

<input type="hidden" id="businessdata" name="businessdata" value="<?php echo $zoneid;?>"/>

<div class="main_content_outer">

  <div class="content_container">
 <h2 ><b>All Deals</b></h2><div class="help_text">The deals created by all business are listed below:  </div><br/>
 <table id="table_id" class="display">
    <thead>
        <tr>
            <th>Business Name</th>
            <th>Auction Name</th>
            <th>Company Name</th>
             <th>Category Name</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>

      <?php        foreach ($auctiondata as  $vdataarray) {   foreach($vdataarray as $value){       ?>
        <tr>
            <td><?php echo $value['businessname'] ?></td>
            <td><?php echo $value['product_name'] ?></td>
            <td><?php echo $value['company_name'] ?></td>
            <td><?php echo $value['cat_name'] ?></td>
            <td><?php echo $value['status'] ?></td>
            <td>
                 <a href="<?php echo base_url() ?>/businessdashboard/createdeal/<?php echo $value['businessid']; ?>/<?php echo $zoneid; ?>?productid=<?php echo $value['product_id'] ?>&mode=edit">Edit</a>  

<a href="#" data-id='<?php echo $value['product_id'] ?>' class="reschedulebtn">Re-Schedule</a>
              <!--  <a href="#" data-id='<?php echo $value['product_id'] ?>' class="deleteAction">Delete</a>  -->
            </td>
        </tr> 
      <?php   }   } ?>
        
       
    </tbody>
</table>
    
  
 

  </div>

</div>

<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script type="text/javascript">

$(document).ready(function () { //alert(1); 

	$('#business_deals_accordian').click();

	$('#business_deals_accordian').click();
    
    $('#business_deals_accordian').click();

    $('#business_deals_accordian').next().slideDown();


	$('#viewdeals').addClass('active');

	$('.allbusinesssub').slideDown('slow');
 
	$("input[name=checkadfordelete]").attr('checked',false);

	$('#search_business').click();

});

$(document).ready( function () {

   table=   $('#table_id').DataTable( {
    responsive: true,
      dom: 'Bfrtip',
    buttons: [
            {
                text: 'Re-Schedule All',
                action: function ( e, dt, node, config ) {

                   var tags = [];
                    $('#table_id tr .reschedulebtn').each(function(e){ 
                          tags.push($(this).data('id'));
                    });  
                      
                    if (confirm('Are you sure?')) {
  $.ajax({

                          'type':"POST",

                           'url':"<?=base_url('Businessdashboard/alldeal_reschedule')?>",

                          'data': {'data_to_use': tags.join(', ') },                            

                          'success': function(response){   
                               
                                location.reload();  
                          }

                      }); 
} else {
     
}
                        
                     
                }
            }
        ]
} );


   
    $(".deleteAction").click(function(e){
        e.preventDefault();

      

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
  
   $(".reschedulebtn").click(function(e){
        e.preventDefault();


        if (confirm('Are you sure?')) {
  
        productid = jQuery(this).data('id');
   
        $.ajax({

              'type':"POST",

               'url':"<?=base_url('Businessdashboard/deal_reschedule')?>",

              'data': {'data_to_use': productid  },                            

              'success': function(response){   
                   
           
                      location.reload();  
              }

        });  
} else {
     
}




    });



</script>