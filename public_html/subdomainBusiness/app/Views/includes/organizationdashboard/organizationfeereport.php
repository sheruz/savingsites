<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2> View Organization Fee Month-Wise</h2>
            <hr class="center-diamond">
            <p>The organization fee month wise listed below:</p>
         </div>
         <div>
            <input type="hidden" name="orgzoneid" id="orgzoneid" value="<?= $fromzoneid; ?>" />
            <input type="hidden" name="org_id" id="org_id" value="<?= $org_id; ?>" />
            <span>Total Earninig: <?= number_format(array_sum($orgyearsum),2); ?> $</span>
            <select class="form-control" style="width: 15%;float: right;margin-bottom: 10px;">
               <option>Select Year</option>
               <?php 
                  $selected = 'selected';
                  $unselect = '';
               ?>
               <option <?php if(date('Y') == 2022){echo $selected;}else{echo $unselect;} ?> value="2022">2022</option>
               <option<?php if(date('Y') == 2023){echo $selected;}else{echo $unselect;} ?> value="2023">2023</option>
               <option<?php if(date('Y') == 2024){echo $selected;}else{echo $unselect;} ?> value="2024">2024</option>
               <option<?php if(date('Y') == 2025){echo $selected;}else{echo $unselect;} ?> value="2025">2025</option>
               <option<?php if(date('Y') == 2026){echo $selected;}else{echo $unselect;} ?> value="2026">2026</option>
            </select>
         </div>
         <table class="display responsive-table" cellspacing="0" width="100%">
            <thead>
               <tr>
                  <!-- <th scope="col">Publisher Email</th> -->
                  <th scope="col">Month</th>
                  <th scope="col">Organization Earning</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>January</td>
                  <td>
                     <?php if(isset($totalsumfavorg['01']['orgfavsumfee']) && $totalsumfavorg['01']['orgfavsumfee'] > 0){ echo number_format($totalsumfavorg['01']['orgfavsumfee'],2).' $';
                     }else{echo $sum = '0.00 $';}?>
                  </td>
               </tr> 
               <tr>
                  <td>February</td>
                  <td>
                     <?php if(isset($totalsumfavorg['02']['orgfavsumfee']) && $totalsumfavorg['02']['orgfavsumfee'] > 0){ echo number_format($totalsumfavorg['02']['orgfavsumfee'],2).' $';
                     }else{echo $sum = '0.00 $';}?>
                  </td>
               </tr> 
               <tr>
                  <td>March</td>
                  <td>
                     <?php if(isset($totalsumfavorg['03']['orgfavsumfee']) && $totalsumfavorg['03']['orgfavsumfee'] > 0){ echo number_format($totalsumfavorg['03']['orgfavsumfee'],2).' $';
                     }else{echo $sum = '0.00 $';}?>
                  </td>
               </tr> 
               <tr>
                  <td>April</td>
                  <td>
                     <?php if(isset($totalsumfavorg['04']['orgfavsumfee']) && $totalsumfavorg['04']['orgfavsumfee'] > 0){ echo number_format($totalsumfavorg['04']['orgfavsumfee'],2).' $';
                     }else{echo $sum = '0.00 $';}?>
                  </td>
               </tr> 
               <tr>
                  <td>May</td>
                  <td>
                     <?php if(isset($totalsumfavorg['05']['orgfavsumfee']) && $totalsumfavorg['05']['orgfavsumfee'] > 0){ echo number_format($totalsumfavorg['05']['orgfavsumfee'],2).' $';
                     }else{echo $sum = '0.00 $';}?>
                  </td>
               </tr> 
               <tr>
                  <td>June</td>
                  <td>
                     <?php if(isset($totalsumfavorg['06']['orgfavsumfee']) && $totalsumfavorg['06']['orgfavsumfee'] > 0){ echo number_format($totalsumfavorg['06']['orgfavsumfee'],2).' $';
                     }else{echo $sum = '0.00 $';}?>
                  </td>
               </tr> 
               <tr>
                  <td>July</td>
                  <td>
                     <?php if(isset($totalsumfavorg['07']['orgfavsumfee']) && $totalsumfavorg['07']['orgfavsumfee'] > 0){ echo number_format($totalsumfavorg['07']['orgfavsumfee'],2).' $';
                     }else{echo $sum = '0.00 $';}?>
                  </td>
               </tr> 
               <tr>
                  <td>August</td>
                  <td>
                     <?php if(isset($totalsumfavorg['08']['orgfavsumfee']) && $totalsumfavorg['08']['orgfavsumfee'] > 0){ echo number_format($totalsumfavorg['08']['orgfavsumfee'],2).' $';
                     }else{echo $sum = '0.00 $';}?>
                  </td>
               </tr> 
               <tr>
                  <td>September</td>
                  <td>
                     <?php if(isset($totalsumfavorg['09']['orgfavsumfee']) && $totalsumfavorg['09']['orgfavsumfee'] > 0){ echo number_format($totalsumfavorg['09']['orgfavsumfee'],2).' $';
                     }else{echo $sum = '0.00 $';}?>
                  </td>
               </tr> 
               <tr>
                  <td>October</td>
                  <td>
                     <?php if(isset($totalsumfavorg['10']['orgfavsumfee']) && $totalsumfavorg['10']['orgfavsumfee'] > 0){ echo number_format($totalsumfavorg['10']['orgfavsumfee'],2).' $';
                     }else{echo $sum = '0.00 $';}?>
                  </td>
               </tr> 
               <tr>
                  <td>November</td>
                  <td>
                     <?php if(isset($totalsumfavorg['11']['orgfavsumfee']) && $totalsumfavorg['11']['orgfavsumfee'] > 0){ echo number_format($totalsumfavorg['11']['orgfavsumfee'],2).' $';
                     }else{echo $sum = '0.00 $';}?>
                  </td>
               </tr> 
               <tr>
                  <td>December</td>
                  <td>
                     <?php if(isset($totalsumfavorg['12']['orgfavsumfee']) && $totalsumfavorg['12']['orgfavsumfee'] > 0){ echo number_format($totalsumfavorg['12']['orgfavsumfee'],2).' $';
                     }else{echo $sum = '0.00 $';}?>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
    </div>
    <script type="text/javascript">
       
    </script>