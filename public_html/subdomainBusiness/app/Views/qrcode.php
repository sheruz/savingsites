<?=$this->extend("layout/master")?>

<?=$this->section("pageTitle")?>
  QR Code | Savingssites
<?=$this->endSection()?>
  
<?=$this->section("content")?>
<section class="qrcodescaner">
  <div class="container">
    <h2 class="titleqr">Login to Approve </h2>
    <?php if($busid == ''){ ?>
    <div class="row formgr">
      <div class="col-lg-12">
        <label>Business Username</label>
        <input type="text" name="username" class="form-control" id="validateusername"/>
      </div>
      <div class="col-lg-12">
        <label>Business Password</label>
        <input type="password" name="password" class="form-control" id="validatepassword"/>
      </div>
      <div class="col-lg-12">
       
        <input style="margin-top: 25px;height: 48px;" type="button" name="save" value="Validate User" class="btn btn-success" id="validatesubmit"/>
      </div>
    </div>
    <?php } ?>
    <div id="approverejectbutton" class="row <?= $hide;?>">
      <input type="hidden" id="userqrid" value="<?= $userid;?>"/>
      <input type="hidden" id="userqrfname" value="<?= $userfname;?>"/>
      <input type="hidden" id="userqrlname" value="<?= $userlname;?>"/>
      <input type="hidden" id="zoneqrId" value="<?= $zoneid;?>"/>
      <div class="col-lg-12 ddd" style="margin-top:50px;" id="buttondiv">
        <a href="<?= base_url()?>/approvalstatus?userid=<?= $userid;?>&userfname=<?= $userfname;?>&userlname=<?= $userlname;?>&businessid=<?= $busid;?>&businessname=<?= $businessName;?>&status=A&zoneId=<?= $zoneid;?>&via=QR&click=1" class="approvebtn">Approve</a>
      <a href="<?= base_url()?>/approvalstatus?userid=<?= $userid;?>&userfname=<?= $userfname;?>&userlname=<?= $userlname;?>&businessid=<?= $busid;?>&businessname=<?= $businessName;?>&status=N&zoneId=<?= $zoneid;?>&via=QR&click=1" class="rejectbtn">Reject</a>
      </div>
    </div>
  </div>
</section>
<?=$this->endSection()?>