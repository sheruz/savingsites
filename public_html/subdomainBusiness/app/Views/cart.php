<?=$this->extend("layout/master")?>
<?=$this->section("pageTitle")?>
Business Search Cart | Savingssites
<?=$this->endSection()?>
<?=$this->section("content")?>
<?=$this->include("includes/modals")?>
<?php   foreach ($cartdata as $key => $value) {
            if($zoneid == $value['options']['zone']){ $status = 1; }else{ $status = 0;}
        }
        if($free_cert > 0 && $final_data_sum == 0){
            $class = 'addheight';
            $hide = 'hide';
            $show = '';
        }else{
            $class = '';
            $hide = '';
            $show = 'hide';
        }     
?>
<div class="container-fluid cart_bg">
    <input type="hidden" id="emptytotal" value="<?= $total; ?>"/>
<div id="cart_page" class="card">
            <div class="row">
                <div class="col-md-8 cart">
                    <div class="title">
                        <div class="row">
                            <div class="col"><h4><b>Shopping Cart</b></h4></div>
                            <div class="col align-self-center text-right text-muted"><? if($total > 1){ echo $total.' Items';}else{echo $total.' Item';} ?></div>
                        </div>
                    </div>   
                    <?php 
                        $countIndex= 1;  $deaid = '';   $busid = '';
                        $disamountim = ''; 
                        $amountArr = $businessArr = $dealidArr = $subtotalArr = $disArr3doller =  [];
                    foreach ($cartdata as $k => $v) {
                        /*get data into Arr*/
                        $businessArr[] = $v['options']['busid'];
                        $dealidArr[] = $v['options']['dealid'];
                        $amountArr[] = $v['price'];
                        $subtotalArr[] = $v['subtotal'];
                        $disArr3doller[] = isset($disAmountArr[$v['options']['busid']])?$disAmountArr[$v['options']['busid']]:0;
                        /*get data into Arr*/
                        $busid = $v['options']['busid'];
                        $deaid .= $v['options']['dealid'];
                        if ($k != key($cartdata)) {
                            $deaid .= ':';
                        }
                       
                        echo '<div class="row border-top border-bottom">
                                <div class="row main align-items-center">
                                    <div class="col-2"><img class="img-fluid" src="https://cdn.savingssites.com/'.$v['options']['cardimg'].'"></div>
                                    <div class="col">
                                        <div class="row text-muted">'.$v['name'].'</div>
                                        <div class="row">'.$v['options']['item'].'</div>
                                    </div>
                                    <div class="col">$ '.$v['price'].' <span data-remove1ID="'.$v['rowid'].'" class="remove-item">&#10005;</span></div>
                                    </div>
                            </div>';    
                        $countIndex++;   
                    }
                    $disamount3 = array_sum($disArr3doller);
                    if($disamount3 > 0){
                        $disamount3 = number_format($disamount3,"2",".","");
                    }else{
                        $disamount3 = 0.00;  
                    } 
                    ?> 
                        <div class="back-to-shop"><a href="<?= base_url();?>/businessSearch/search/<?= $zone_id ?>">&leftarrow;</a><span class="text-muted">Back to shop</span>
                        </div>
                        <div class="row">
                            <div class="col-md-3">Gift Certificate</div>
                            <div class="col-md-9"><input placeholder="Enter Email Address" type="email" id="giftemail" class="giftemail"/></div>
                        </div>
                </div>
                <div class="col-md-4 summary cart0">
                    <div><h5><b>Summary</b></h5></div>
                    <hr>
                    <div class="row" style="padding: 2vh 0;">
                        <div class="col" style="padding-left:0;"><? if($total > 1){ echo 'ITEMS '. $total;}else{echo 'ITEM '.$total;} ?></div>
                        <?php   
                            $totalprice = 0; $maxsubtotal = [];
                            foreach ($cartdata as   $value) {
                                if($status == 1){
                                    $totalprice  = $totalprice + $value['subtotal'];
                                    $maxsubtotal[] = $value['subtotal'];
                                }
                            }
                            $credit_to_pay = 0;//$peekaboocredits['totalcredits'];
                            $creditStatus = 'deduc';
                            $credit_to_pays = 0;
                            if($credit_to_pay <= 3){
                                $totalCredit =  3 - $credit_to_pay ;
                                $credit_to_pays = $totalCredit*0.5;
                                $creditStatus = 'paid';
                            }
                        
                            if($credit_to_pays){$finalprice = $totalprice; }else{ ?>
                                <strong>$<?php $finalprice = number_format($credit_to_pays+$totalprice,"2",".",""); ?></strong>     
                        <?php } ?>
                            <div class="col text-right">$<?= $totalprice;?></div>
                        </div>
                        
                        <?php if($discount){  ?>
                        <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                            <div class="col" style="padding-left:0;">Discount:</div>
                            <div class="col text-right"><?= $discount; ?>% OFF</div>
                        </div>
                        <?php } ?>

                        <?php if($credit_to_pays){ ?>
                        <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                            <div class="col" style="padding-left:0;">Credit's Pay:</div>
                            <div class="col text-right"><?= '$'.$credit_to_pays; ?></div>
                        </div>
                        <?php } ?> 

                        <!------------->
                        <?php if($free_cert > 0){ ?>
                        <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                            <div class="col" style="padding: 0;">Total Payable Amount:</div>
                            <div class="col text-right">$<?php  $finalprice = (int)$totalprice-(int)$totalprice*((int)$discount/100); 
                            echo number_format($credit_to_pays+$finalprice,"2",".","");?></div>
                        </div>
                        
                        <!-- <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                            <div class="col" style="padding: 0;">You Have <? //= $free_cert; ?> Free Certificate</div>
                            <?php //$maxvalue = $maxvalue1; 
                                //if($total > 1){?>
                                    <div class="col text-right">-$<?php //echo number_format($maxvalue,"2",".","");?></div>
                                <?php //}else{ ?>    
                                    <div class="col text-right">-$<?php  //$finalprice = (int)$totalprice-(int)$totalprice*((int)$discount/100); 
                                            //echo number_format($credit_to_pays+$finalprice,"2",".","");?></div>
                                <?php //} ?>
                        </div> -->

                        <?php 
                            if($total > 1){
                                $checkfinal3dolleramount = ((int)$totalprice-(int)$totalprice*((int)$discount/100)); 
                                $checkfinal3dolleramount = ($credit_to_pays+$finalprice)-$maxvalue;
                                if($checkfinal3dolleramount > 3){
                                    echo '<div class="row" style="border-top: 1px solid rgba(0,0,0,.1);padding: 2vh 0;"><div class="col" style="padding: 0;">Discount Amount</div>$ '.$disamount3.'</div>' ; 
                                }else{
                                    if($disamount3 > 0){
                                        echo '<div class="row" style="border-top: 1px solid rgba(0,0,0,.1);padding: 2vh 0;"><div class="col" style="padding: 0;">Discount Amount<br><span style="font-size:10px;color:red;">(Discount not applicble for this order)</span></div>$ '.$disamount3.'</div>' ;
                                    }
                                }
                            }else{
                                if($disamount3 > 0){
                                    echo '<div class="row" style="border-top: 1px solid rgba(0,0,0,.1);padding: 2vh 0;"><div class="col" style="padding: 0;">Discount Amount<br><span style="font-size:10px;color:red;">(Discount not applicble for this order)</span></div>$ '.$disamount3.'</div>' ;
                                }  
                            }
                            if($dealcertamount > 0){
                                echo '<div class="row" style="border-top: 1px solid rgba(0,0,0,.1);padding: 2vh 0;"><div class="col" style="padding: 0;">Deal Referal Amount</div>$ '.$dealcertamount.'</div>' ;    
                            }
                        ?>
                        <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                            <div class="col" style="padding: 0;">Total amount:</div>
                            <?php if($total > 1){ ?>
                                <div class="col text-right" max="<?= $maxvalue; ?>">
                                    <?php  $finalprice = ((int)$totalprice-(int)$totalprice*((int)$discount/100)); 
                                        if($disamount3 >= 3 && $finalprice >= 3){
                                            $disamountimArr[] = $disamount3;
                                            $finalprice = (($credit_to_pays+$finalprice)-$maxvalue)-$disamount3; 
                                        }else{
                                            $disamountimArr[] = 'notusefreecert';
                                            $finalprice = ($credit_to_pays+$finalprice)-$maxvalue;
                                        }
                                        if($dealcertamount > 0){
                                            echo number_format($finalprice-$dealcertamount,"2",".","");
                                        }else{
                                            echo number_format($finalprice,"2",".",""); 
                                        }
                                    ?>
                                </div>
                            <?php }else{ 
                               $disamountimArr[] = 'notusefreecert';
                                ?>
                                <div class="col text-right">$0.00</div>
                            <?php } ?>  
                        </div>
                        <?php }else{ 
                            $finalprice = (int)$totalprice-(int)$totalprice*((int)$discount/100);
                            $disamount3 = array_sum($disArr3doller);
                            
                            if($finalprice >= 3 && $disamount3 >= 3){
                                $finalprice = $finalprice- $disamount3;
                                $disamountimArr[] = $disamount3;
                                echo '<div class="row" style="border-top: 1px solid rgba(0,0,0,.1);padding: 2vh 0;"><div class="col" style="padding: 0;">Discount Amount</div>$ '.$disamount3.'</div>' ; 
                            }else{
                                $finalprice = $finalprice;
                                $disamountimArr[] = 'notuse';
                                if($disamount3 > 0){
                                    echo '<div class="row" style="border-top: 1px solid rgba(0,0,0,.1);padding: 2vh 0;"><div class="col" style="padding: 0;">Discount Amount<br><span style="font-size:10px;color:red;">(Discount not applicble for this order)</span></div>$ '.$disamount3.'</div>' ;
                                }
                            }
                            if($dealcertamount > 0){
                                echo '<div class="row" style="border-top: 1px solid rgba(0,0,0,.1);padding: 2vh 0;"><div class="col" style="padding: 0;">Deal Referal Amount</div>$ '.$dealcertamount.'</div>' ;    
                                $total_amount = number_format(($credit_to_pays+$finalprice)-$dealcertamount,"2",".",""); 
                            
                            }else{
                                $total_amount = number_format($credit_to_pays+$finalprice,"2",".","");   
                            }
                        ?>

                        <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                            <div class="col" style="padding-left:0;">Total amount:</div>
                            <div class="col text-right">$<?= $total_amount; ?></div>
                        </div>  
                        <?php } ?> 

                    <?php if (!empty($user_id)) { 
                        //https://www.sandbox.paypal.com
                        // https://www.paypal.com
                        $businessim = implode(',', $businessArr);    
                        $dealidim = implode(',', $dealidArr);    
                        $amountim = implode(',', $amountArr);    
                        $subtotalim = implode(',', $subtotalArr);   
                        $disamountim = implode(',', $disamountimArr);   
                        $disim = isset($discount)?$discount:0;  
                        $creditim = isset($credit_to_pays)?$credit_to_pays:0;
                        $dealcertamount = isset($dealcertamount)?$dealcertamount:0;
                        
                        if($get_paypal_info['paypal_url'] != ''){ 
                            $alldata="businessim=".$businessim."&dealidim=".$dealidim."&amountim=".$amountim."&subtotalim=".$subtotalim."&disim=".$disim."&creditim=".$creditim."&user_type='free'&disamountim=".$disamountim;
                            ?>
                            <input class="<?= $show; ?>" userid="<?= $user_id; ?>" zoneid="<?= $zoneid; ?>" busid="<?= $busid; ?>" deaid="<?= $deaid; ?>" alldata="<?= $alldata;?>" creditStatus="<?= $creditStatus; ?>" usedcert="<?= $used_certificate;?>"  type="button" name="" id="free_Certbutton" value="CHECKOUT"/>
                            <form class="<?= $hide; ?>" name="_xclick " action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                <input type="hidden" name="cmd" value="_xclick">
                                <input type="hidden" name="business" value="<?php echo $get_paypal_info['paypal_url'] ?>">
                                <input type="hidden" name="currency_code" value="USD">
                                
                                <input type="hidden" name="return" value="<?= base_url();?>/thankyou?UserId=<?= $user_id ?>&Amount=<?php echo  $finalprice; ?>&creditStatus=<?php echo $creditStatus ?>&AucId=<?php echo $deaid;  ?>&token=<?php echo time(); ?>&busid=<?php echo $busid;  ?>&zoneid=<?php echo $zoneid;  ?>&usedcert=<?php echo $used_certificate;  ?>&businessim=<?= $businessim;?>&dealidim=<?= $dealidim;?>&amountim=<?= $amountim;?>&subtotalim=<?= $subtotalim;?>&disim=<?= $disim;?>&creditim=<?= $creditim;?>&disamountim=<?= $disamountim;?>&user_type=&dealcertamount=<?= $dealcertamount; ?>"> 
                                <input type="hidden" name="cancel_return" value=""> 
                                <input type="hidden" name="item_name" value="Savingssites Order">
                                <input type="hidden" name="amount" value="<?php echo  $finalprice+$credit_to_pays; ?>">
                                <input type="image"  border="0" name="submit" onerror="this.style.display='none'"/ class="<?php echo $class  ?>" > 
                            </form>
                    <?php } } ?>    
                </div>
            </div>
        </div>
    </div>
<?=$this->endSection()?>