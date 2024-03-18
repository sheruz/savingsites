<style type="text/css">
    .col-md-3 .row {
    border: 1px solid #eee;
    padding: 10px 0;
}
#ajaxemail p {
    margin: 5px 0 10px;
    word-break: break-all;
}
</style>

<?=$this->extend("layout/master")?>
<?=$this->section("pageTitle")?>
  Email Blog | Savingssites
<?=$this->endSection()?>
<?=$this->section("content")?>

<?php   if($emailArr) { ?>

<div id="about_content1" class="main_body cusnews">
    <input type="hidden" name="zone_id" id="zone_id" value="<?= $zone_id ?>">
    <h1 style="text-align: center;margin-top: 0px;"></h1>
    <div class="row">
        <div class="col-md-6">
            <select class="form-control" id="blogsearchcat">
                <option>Select Category</option>
                <option value="activities" <?php if($search == 'activities'){echo 'selected';} ?>>Activities</option>
                <option value="events" <?php if($search == 'events'){echo 'selected';} ?>>Events</option>
                <option value="development" <?php if($search == 'development'){echo 'selected';} ?>>Planning development</option>
                <option value="police" <?php if($search == 'police'){echo 'selected';} ?>>Police</option>
                <option value="health" <?php if($search == 'health'){echo 'selected';} ?>>Health</option>
                <option value="updates" <?php if($search == 'updates'){echo 'selected';} ?>>Updates</option>
            </select>
        </div>
        <div class="col-md-6">
            <input type="text"  class="form-control" id="searchemail" placeholder="Search Event" />
        </div>
    </div>
    <div class="row" id="ajaxemailss">
        <?php foreach ($emailArr as $k => $v) { ?>
        <div class="col-md-3">
           <div class="border">
                <a target="_blank" href="/blogdetail?id=<?= $v['id'];  ?>">
                     <div class="row" style="margin: 15px;">
                    <div class="col-md-12">
                        <?php if($v['image']!='') { ?>
                        <img src="<?= $v['image']; ?>" />
                    <?php   } ?>
                    </div>
                    <div class="col-md-12">
                        <h2 style="font-size: 18px;font-weight: 700;"><?php echo $v['subject']; ?></h2>
                        <p class="text-wrap"><?php echo $v['sender']; ?><br></p>
                    </div>
                    </div>
                </a>
            </div>
        </div>
        <?php }  ?>
    </div>
</div>


<?php }else{   ?>

<div id="about_content1" class="main_body cusnews">


    <div class="no_content">
        <p>No content found</p>
    </div>

</div>

<?php } ?>
<?=$this->endSection()?>