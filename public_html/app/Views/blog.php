<?=$this->extend("layout/master")?>
<?=$this->section("pageTitle")?>
  Blog
<?=$this->endSection()?>
<?=$this->section("content")?>
<div id="about_content1" class="main_body" style="width: 95%;">
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
    <div class="row" id="ajaxemail">
        <?php foreach ($emailArr as $v) { ?>
        <div class="col-md-6">
            <div class="row" style="margin: 15px;">
                <a target="_blank" href="/blogdetail?id=<?= $v['id'];  ?>">
                    <div class="col-md-4">
                        <img src="<?= $v['image'] ?>" />
                    </div>
                    <div class="col-md-8">
                        <h2 style="font-size: 18px;font-weight: 700;"><?php echo $v['subject'] ?></h2>
                        <p><?php echo $v['sender'] ?><br></p>
                    </div>
                </a>
            </div>
        </div>
        <?php   } ?>
    </div>
</div>
<?=$this->endSection()?>