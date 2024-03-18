<div class="page-wrapper main-area toggled myzonebusinesses">
	<div class="container">
    <div class="row" style=" margin-bottom: 80px;">
      <div class="top-title">
        <h2> Communication Method </h2>
        <p>This page authorizes users to obtain a $5 certificate by emailing or calling a business</p>
        <hr class="center-diamond">
      </div>
    </div>
		
    <div class="row" style="position: relative;">
      <!-- <button class="down_data">Download Data</button> -->
      <table class="display responsive-table datatable-all" cellspacing="0" width="100%" id="myzonebusinesstable">
        <thead>
          <tr>
            <th scope="col">Business Id</th>
            <th scope="col">Business Name</th>
            <th scope="col">Communication Method</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody id="myzonebusinesdata">
          <?php foreach ($businessArr as $bk => $bv) { 
            if($bv->comm_method == 1){
              $checkval = '<input type="radio" class="compmethod1 compmethod" value="1"  checked="checked"/> Email <input type="radio"  class="compmethod2 compmethod"  value="2"/> Phone';
            }else if($bv->comm_method == 2){
              $checkval = '<input type="radio" class="compmethod1 compmethod" value="1"/> Email <input type="radio" class="compmethod2 compmethod" value="2" checked="checked"/> Phone';
            }else{
              $checkval = '<input type="radio" class="compmethod1 compmethod" value="1" checked="checked"/> Email <input type="radio" class="compmethod2 compmethod"  value="2"/> Phone';
            }
          ?>
            <tr>
            <th><?= $bv->id; ?></th>
            <td><?= $bv->name; ?></td>
            <td><?= $checkval; ?></td>
            <td><button class="btn btn-success savecommumethod" busid="<?= $bv->id; ?>">Save</button></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
	</div>
</div>
