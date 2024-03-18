<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  Snap Deal Claim | Savingssites
<?=$this->endSection()?>
  
<?=$this->section("content")?>
<?=$this->include("includes/modals")?>
<?php 
	if($dealcertavailable == 1){
		$divshow 	= 'hide';
		$tableshow 	= '';
	}else{
		$tableshow 	= 'hide';
		$divshow 	= '';
	}

?>
<style>
  .section.footer-variant-2 {
    width: 100%;
    background: #dbdbdb;
    border-radius: 0;
    position: absolute;
    bottom: 0;
}
</style>
<section>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h2 style="padding: 50px;text-align: center;">Snap Deal Detail</h2>
        <table class="table table-bordered <?= $tableshow; ?>">
        	<thead>
        		<tr>
        			<th>Business Name</th>
              <th>Day</th>
        			<th>Start time</th>
        			<th>End time</th>
        			<th>No of people allowed</th>
        			<th>Action</th>
        		</tr>
        	</thead>
        	<tbody>
        	<?php if(count($finalsnapArr) > 0){
        		foreach ($finalsnapArr as $daysid => $v) {
        			foreach ($v as $k1 => $v1) {
        				echo '<tr><td>'.$bus_id_name.'</td><td>'.$v1->dayword.'</td><td>'.$v1->starttimeword.'</td><td>'.$v1->endtimeword.'</td><td>'.$v1->noofpeoplearr.'</td><td><button class="btn btn-info booksnapatable" dayid="'.$v1->dayarr.'" starttimeid="'.$v1->starttimearr.'" endtimeid="'.$v1->endtimearr.'" noofpeopleid="'.$v1->noofpeoplearr.'" snapsendtypeid="'.$v1->snapsendtypearr.'" daysid="'.$daysid.'" snapuserid="'.$snapuserid.'" snapzoneid="'.$zoneid.'" snapbusid="'.$bus_id.'">Book a table</button></td></tr>';
        			}
        		}
        	} 

        	?>
        	</tbody>
        </table>
        <div class="<?= $divshow; ?>"><h2>You dont have a Deal Certificate, Buy <a href='<?= $dealurl; ?>'><u>click here</u></a></h2></div>
      </div>
    </div>
  </div>
</section>


<?=$this->endSection()?>