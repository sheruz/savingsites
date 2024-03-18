<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<section class="section section-sm bg-default text-md-left saving_business_reg">
  <div class="container">
    <div class="row ">      
      <div class="col-lg-12 col-md-12 col-sm-12">
        <h2 class="white" style="text-align: center;">Web Push Notification</h2>
        
      </div>
    </div>  
  </div>
</section>
<div class="insert-post-ads1" style="margin-top:20px;">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {  
    // if($('#loggedIn').length) {   
      getNotification();
      setInterval(function(){ getNotification(); }, 200000);
    // }
  });

  function getNotification() {  
    if (!Notification) {
      $('body').append('<h4 style="color:red">*Browser does not support Web Notification</h4>');
      return;
    }

    if (Notification.permission !== "granted") {    
      Notification.requestPermission();
    }else{    
      $.ajax({
        url : "/getnotificationdata",
        type: "GET",
        success: function(response, textStatus, jqXHR) {
          var response = jQuery.parseJSON(response);
            if(response.result == true) {
            var notificationDetails = response.notif;
            for (var i = notificationDetails.length - 1; i >= 0; i--) {
              var notificationUrl = notificationDetails[i]['url'];
              var notificationObj = new Notification(notificationDetails[i]['title'], {
                icon: notificationDetails[i]['icon'],
                body: notificationDetails[i]['message'],
              });
              
              notificationObj.onclick = function () {
                window.open(notificationUrl); 
                notificationObj.close();     
              };
              setTimeout(function(){
                notificationObj.close();
              }, 5000);
            };
          }else{
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {}
    }); 
  }
};
</script>
</body>
</html>