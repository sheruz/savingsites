<?php include 'header.php';?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
  <div class="container pt-5">
    <h2> Change Password</h2>
    
        <input type="hidden" name="" id="username" value="<?= $username; ?>">
        <input type="hidden" name="" id="usertype" value="<?= $usertype; ?>">
      <p>

          <label for="new_pass" class="">New Password<span style="color:red;">*</span></label>

          <input type="password" class="new_pass" id="new_pass" name="new_pass" value="" />

      </p>

      <span id="error_new_password" style="margin:0px 0px 8px 0; background:#F00; font-weight:bold; color:#fff; padding:1px 8px; width:450px; display:block;  display:none;"></span>

      <p>

          <label for="confirm_pass" class="">Confirm Password<span style="color:red;">*</span></label>

          <input type="password" class="confirm_pass" id="confirm_pass" name="confirm_pass" value="" />

      </p>

      <span id="error_confirm_password" style="margin:0px 0px 8px 0px; background:#F00; font-weight:bold; color:#fff; padding:3px; width:450px; display:block; text-align:center; display:none; float:left"></span>

      <p>

          <label for="zip1">

              <button type="button" id="resetpass" class="btn btn-primary">Reset</button>

          </label>

      </p>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#resetpass").click(function(){
           var username = $('#username').val();
           var usertype = $('#usertype').val();
           var new_pass = $('#new_pass').val();
           var confirm_pass = $('#confirm_pass').val();
          $.ajax({   
            type: "POST",
            url: '/recover_pass_set',
            cache: false,
            data:{'username': username,'usertype': usertype,'new_pass': new_pass,'confirm_pass': confirm_pass },
            dataType:'json',
            success: function (res) {
              window.location.href = "https://savingssites.com/";
            }
          });
        });
      });
    </script>
  </div>  
</body>

</html>
<?php include 'footer.php';?>