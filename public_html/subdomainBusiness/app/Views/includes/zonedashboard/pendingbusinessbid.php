<div class="page-wrapper main-area toggled myzonebusinesses">
   <div class="container">
    <div class="row" style=" margin-bottom: 80px;">
      <div class="top-title">
        <h2>Pending Bidding Business</h2>
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
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody id="myzonebusinesdata">
          <?php foreach ($businessArr as $bk => $bv) { ?>
            <tr>
            <th><?= $bv->id; ?></th>
            <td><?= $bv->name; ?></td>
            <td><button class="btn btn-success bidinfosend" action="email" busid="<?= $bv->id; ?>" busname="<?= $bv->name; ?>">Email</button> <button class="btn btn-success bidinfosend" action="phone" busid="<?= $bv->id; ?>" busname="<?= $bv->name; ?>">Phone</button></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
   </div>
</div>
