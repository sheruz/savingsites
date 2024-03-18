<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style type="text/css">
body {
        background: url('') #f5f5f5;
        background-repeat: repeat;
        background-attachment: scroll;
        background-position: center top;
        background-size: auto;

        font-family: 'Lucida Grande', sans-serif;
        font-size: 14px;
        color: #555;
        text-align:center;
      }
 .form-all {
        background: url('') #fff;
        background-repeat: repeat;
        background-attachment: scroll;
        background-position: center top;
        background-size: auto;
        max-width: 690px;
        height: 400px;
        margin: 0px auto;
        padding: 29px 29px ;
        -webkit-box-shadow: 0 4px 4px -1px rgba(0,0,0,0.1);
        box-shadow: 0 4px 4px -1px rgba(0,0,0,0.1);
      }

</style>
<?php if($status == 'success'){?>
 <div id="stage" class="form-all"><p style="text-align: center;"><img src="https://cdn.jotfor.ms/img/check-icon.png" alt="" width="128" height="128"></p>
<div style="text-align: center;">
<h1 style="text-align: center;">Thank You!</h1>
<p style="text-align: center;">Your payment has been received.</p>
<p style="text-align: center;"><span style="font-size: 10pt;">Your Submission ID:</span><?php echo $payment_details['submission_id']  ?></p>
<p style="text-align: center;"><span>Amount :</span><?php echo $payment_details['price'][2]  ?></p>
</div>
</div>

<?php }else if($status == 'fail'){?>

<div id="stage" class="form-all"><p style="text-align: center;"><span class="glyphicon glyphicon-warning-sign" style="color: chocolate;font-size: 20px;"></span></p>
<div style="text-align: center;">
<h1 style="text-align: center;">Payment Error</h1>
<p style="text-align: center;">Payment was unsuccessful</p>
</div>            
</div>

<?php } ?>

<script type="text/javascript">
$(document).ready(function(){
    $("#adv_tools").click();
    $("#adv_tools").next().slideDown();
    $('#pekaboo_credits').click();
    $('#pekaboo_credits').next().slideDown();
    $('#buy_pekaboo_credits').addClass('active');
       
});
</script>