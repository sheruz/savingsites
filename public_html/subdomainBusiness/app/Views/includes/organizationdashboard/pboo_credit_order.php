<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/2.2.2/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js"></script>

<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
<?php if(count($pboo_credit_payment_data) > 0){ ?>

<div id="table_contet" style="width:75%; float:right;">


    <table class="pretty" border="0" cellpadding="0" cellspacing="0" id="table_payment">

        <thead id="showhead" class="headerclass">

        <tr>

            <th width="10%">Users Id</th>

            <th width="15%">Users Name</th>

            <th width="20%">Submission Id</th>

            <th width="10%">Payment Purpose</th>

            <th width="10">Form Id</th>

            <th width="10%">Credits</th>

            <th width="10%">Amount</th>

            <th width="15%">Payment Time</th>

            <th width="15%">Action</th>

        </tr>

        </thead>

        <tbody>

        <?php

            //var_dump($pboo_credit_account_id[0]->pboo_credit_account_id);

            $pboo_credit_account_id = $pboo_credit_account_id[0]->pboo_credit_account_id;

            foreach ($pboo_credit_payment_data as $value) {

                //var_dump($value);

                $credits = 200;

                if($value['amount'] == 9.95){

                    $credits = 20;

                }

                $user_full_name = $value['first_name']." ".$value['last_name'];

                $action_button = "<button class='btn pay_pboo_credits' data-user-id='".$value['payer_id']."' data-amount='".$value['amount']."' data-credits='".$credits."' data-payment-id='".$value['payment_id']."' data-ac-id='".$pboo_credit_account_id."' onClick='pay_pboo_credits(this);'>Pay Now</button>";

                if($value['pboo_credit_status']){

                    $action_button = "<button class='btn'>Paid</button>";

                }

                

                ?>

                <tr class="headerclass_sub">

                    <td><?= $value['payer_id']; ?></td>

                    <td><?= $user_full_name; ?></td>

                    <td><?= $value['submission_id']; ?></td>

                    <td>Buy Bekaboo credits</td>

                    <td><?= $value['form_id']; ?></td>

                    <td><?= $credits; ?></td>

                    <td><?= $value['amount']; ?></td>

                    <td><?= $value['time']; ?></td>

                    <td id="button_id_<?= $value['payment_id']; ?>"><?= $action_button; ?></td>

                </tr>

                <?php

            }

        } else{?>

        
            <div class="content_container credit_order_container">
            <div id="tab1_content"><div style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;" class="container_tab_header">No Payment Data Found</div>

            </div>
        </div>



        <?php } ?>

        </tbody>

    </table>

</div>

<div class="modal fade" id="insufficient_fund_modal" role="dialog" data-backdrop="false">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <div class="modal-body" id="insufficient_fund_modal_body">

        </div>

        <div class="modal-footer">

        </div>

      </div>

      

    </div>

  </div>

<script type="text/javascript">

    // $(document).ready(function(){

    //   $("#organization_data_accordian").click();

    //     $("#organization_data_accordian").next().slideDown();

    //       $(".Paymentlistingpanel").click();

    //     $(".Paymentlistingpanel").next().slideDown();

    //     // $('#jotform').click();

    //     // $('#jotform').next().slideDown();

    //     // $('#view_listing').addClass('active');

    //     $(".Paymentlistingpanel").addClass('active');
    //     $("#organization_credit_request").addClass('active');



    // });

    // function pay_pboo_credits(element){

    //     var credits = $(element).attr('data-credits');

    //     var amount = $(element).attr('data-amount');

    //     var user_id = $(element).attr('data-user-id');

    //     var payment_id = $(element).attr('data-payment-id');

    //     var account_id = $(element).attr('data-ac-id');

    //     current_credit_remains_in_payer_account(account_id,credits,amount,user_id,payment_id);

    // }

    // function current_credit_remains_in_payer_account(account_id,credits,amount,user_id,payment_id){

    //     var data_to_use ={user_id:user_id,payment_id:payment_id,account_id:account_id,credits:credits,amount:amount};

    //     $.ajax({

    //         type:'POST',

    //         url:"<?= base_url('organizationdashboard/current_pboo_credit');?>",

    //         data:{account_id:account_id},

    //         success:function(result){

    //             credit_balance = JSON.parse(result);

    //             credit_balance = parseInt(credit_balance);

    //             if(credit_balance >= credits){

    //             PageMethod("<?=base_url('organizationdashboard/pay_pboo_credit')?>", "Paying pboo credit... <br/>This may take a few minutes", data_to_use,payment_result, null);

    //             } else{

    //                 //alert("you do not have sufficient credits");

    //                 $("#insufficient_fund_modal_body").html("<p>Sorry,you do not have suficient balance</p>");

    //                 $("#insufficient_fund_modal").modal("show");

    //             }

    //         },

    //         error:function(error){

    //             console.log(error);

    //         }

    //     });

    //     //alert(credit_balance);

    //     //return credit;

    // }

    // function payment_result(result){

    //     $.unblockUI();

    //     if(result){

    //         var id = JSON.parse(result);

    //         id = "#button_id_"+id;

    //         $(id).html("<button class='btn'>Paid</button>");

    //     }



    // }

</script>