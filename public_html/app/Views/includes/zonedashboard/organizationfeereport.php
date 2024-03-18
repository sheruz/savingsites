<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
      <div class="row" style=" margin-bottom: 80px;">
         <div class="top-title">
            <h2> View Organization Fee Month-Wise</h2>
            <hr class="center-diamond">
            <p>The organization fee month wise listed below:</p>
         </div>
         <div>
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
                  <th scope="col">Publisher Earning</th>
                  <th scope="col">Organization Earning</th>
                  <th scope="col">Month</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               if(count($totalsumfavorg) > 0){
                  foreach ($totalsumfavorg as $k => $v) {
                     echo '<tr><td>'.$v['useramountsum'].'$</td><td>'.number_format($v['orgfavsumfee'],2).'$</td><td>'.$monthArr[$k].'</td><td><button><a href="/downloadorgcsv?month='.$k.'&year=2022&zone_id='.$v['zone_id'].'&zoneuserid='.$uid.'">Download CSV</a></button></td></tr>';
                  }
               }
               ?>
            </tbody>
         </table>
      </div>
    </div>
    <script type="text/javascript">
       
    </script>