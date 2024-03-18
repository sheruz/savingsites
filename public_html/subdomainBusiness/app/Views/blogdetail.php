<?=$this->extend("layout/master")?>
<?=$this->section("pageTitle")?>
  Blog Detail | Savingssites
<?=$this->endSection()?>
<?=$this->section("content")?>
<div id="about_content1" class="main_body" style="width: 95%;">
    <input type="hidden" name="zone_id" id="zone_id" value="<?= $zone_id ?>">
    <h1 style="text-align: center;margin-top: 0px;">Blog Detail</h1>
    <br>
    <div class="row">
        <?php foreach ($emailArr as $v) { ?>
        <div class="col-md-12">
            <p><?php echo $v['bodydata']; ?></p>
        </div>
        <?php   } ?>
        
    </div>
</div>
<?=$this->endSection()?>