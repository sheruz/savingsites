

<div class="main_content_outer"> 

  

<div class="content_container">
<br/>
 <h2>Report Management</h2>
<br/>

<div id="container_tab_content" class="container_tab_content ui-tabs ui-widget ui-widget-content ui-corner-all"> 
 
<?php if($_SESSION['user_id']=="" && $_SESSION['user_name']==""){  header("Location: index.php?page=login");exit; }?>

 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css">
<!-- 
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>



<div class='report_link'>
  
	Report Upto Date:  <input type="text" id="datepicker" class="datepicker" autocomplete="off"  style="width: 250px;"> <br/>
<br/>
  <a class='gen_link btn btn-default' >Generate Reports</a>​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​
  <br/><br/>
</div>
 <script type="text/javascript">
 	
 	$( function() {
$('#zone_data_accordian').click();
 		$('#datepicker').daterangepicker({ 
 			  timePicker: true,
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
      format: 'YYYY/MM/DD hh:mm:ss  '
    }

 	});

    // $( "#datepicker" ).datepicker({
    //             isRTL: true,
    //             dateFormat: "yy-mm-dd 12:34:35",
    //             changeMonth: true,
    //             changeYear: true

    //         });

    $('.gen_link').click(function(e){
       e.preventDefault();
     var datepicker =  $(".datepicker").val(); 
    $valesplited =  datepicker.split("-");

 
    fristdate = $valesplited[1].toString().replace(/\//g, '-');
    enddate = $valesplited[0].toString().replace(/\//g, '-');
 

        $.ajax({

      type     : 'POST',

      url      : '<?= base_url("Zonedashboard/exported_data") ?>',

      data     : {'firstdate' : fristdate , 'seconddate' : enddate },

      async    : false,

      success  : function(result) { 

        var userid = result.Title; 

        //var userid = result['Title']; alert(userid); return false;

        //var url = "<?php echo base_url(); ?>EventCalendarD/index.php?controller=pjAdmin&action=pjActionLogin&userid="+userid+"&role_id=1";

        //newWindow.location = url;

      },

      error    : function(error) {

          //console.log(error);

      }



    });


    });



  } );



 </script>
 
	 
 

 

          <!--</div>-->

          </div>

          </div>

       

        

         </div>