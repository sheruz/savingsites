<div class="page-wrapper main-area toggled viewdeals">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
    <input type="hidden" id="business_id" name="businessid" value="<?php echo $businessid;?>"/>
    <input type="hidden" id="deal_product_id" name="deal_product_id" value=""/>
    <div class="row" style=" margin-bottom: 80px;">
      <div class="top-title">
        <h2>Business Orders Status</h2>
          <hr class="center-diamond">
          <p>The orders completed by business are listed below:</p>
      </div>
      <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="managecat">
        <thead>
          <tr>
            <th scope="col">Username</th>
            <th scope="col">Item Name</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($OrderstatusArr as $k => $v) {
          echo '<tr><td>'.$v['firstname'].' '.$v['lastname'].'</td><td>'. $v['itemname'].'</td>';
          if($v['status'] == 1){
            echo '<td>Completed</td>';
          }else{
            echo '<td></td>';
          }
          echo '</tr>';
        } ?>
        </tbody>
      </table>
    </div>
  </div>
