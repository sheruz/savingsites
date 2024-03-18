<!---error div-->
<div id="alert_msg">
</div>
<!---error div-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>/assets/home/customjs/maskedinput.js?v=<?= time();?>"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://use.fontawesome.com/2557f322e0.js"></script>
<script src="<?= base_url(); ?>/assets/SavingsJs/ZonedashboardCommon.js?v=<?= time();?>"></script>
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script type="text/javascript">

	jQuery(function ($) {

    $(".sidebar-dropdown > a").click(function() {
  $(".sidebar-submenu").slideUp(200);
  if (
    $(this)
      .parent()
      .hasClass("active")
  ) {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
      .parent()
      .removeClass("active");
  } else {
    $(".sidebar-dropdown").removeClass("active");
    $(this)
      .next(".sidebar-submenu")
      .slideDown(200);
    $(this)
      .parent()
      .addClass("active");
  }
});

$("#close-sidebar").click(function() {
  $(".page-wrapper").removeClass("toggled");
});
$("#show-sidebar").click(function() {
  $(".page-wrapper").addClass("toggled");
});


   
   
});
	

  // Show the first tab and hide the rest
$('#tabs-nav li:first-child').addClass('active');
$('.tab-content').hide();
$('.tab-content:first').show();

// Click function
$('#tabs-nav li').click(function(){
  $('#tabs-nav li').removeClass('active');
  $(this).addClass('active');
  $('.tab-content').hide();
  
  var activeTab = $(this).find('a').attr('href');
  $(activeTab).fadeIn();
  return false;
});


    $(".cus-sub-menu > a").click(function() {
  $("li.cus-sub-menu ul").slideUp(200);
  if (
    $(this)
      .parent()
      .hasClass("subactive")
  ) {
    $(".sidebar-dropdown").removeClass("subactive");
    $(this)
      .parent()
      .removeClass("subactive");
  } else {
    $(".sidebar-dropdown").removeClass("subactive");
    $(this)
      .next("li.cus-sub-menu ul")
      .slideDown(200);
    $(this)
      .parent()
      .addClass("subactive");
  }
});



    $(document).on('click','.main-area',function() {
    $(window).on("resize", function (e) {
        checkScreenSize();
    });

    checkScreenSize();
    
    function checkScreenSize(){
        var newWindowWidth = $(window).width();
        if (newWindowWidth < 1025) {
               var exists =  $('#vardum').hasClass('toggled');
    
 if (exists == true){
     $('#vardum').removeClass('toggled')
 }
        }
       
    }
});


</script>