<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />
<input type="hidden" name="orgnid" id="orgnid" value="<?=$common['organizationid']?>" />
<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />


<?php if(($common['organization_status']==1 || $common['usergroup']->group_id==4)){ ?>
<div class="main_content_outer"> 
    <div class="content_container category_container">
    <?php if($common['from_zoneid']!='0'){?>
        <div class="spacer"></div>
    <?php }?>
    <div class="top-title">
        <h2>Suggest New Category</h2>
        <hr class="center-diamond">
    </div>
    <div id="container_tab_content" class="container_tab_content bv_new_category">
        <div class="row">
		    <div class="col-sm-6">
                <img src="<?php echo base_url() ?>/assets/images/suggest_category.jpg" />
            </div>
            <div class="col-sm-6">
                <div id="tabs-2_y">
                    <div id="msg" style="display:none;margin-top:7px;"></div>
                    <div class="form-group center-block-table">
                    <p>
                        <div id="new_category">
                            <label for="category_text" class="fleft w_150">Category Name</label>
                            <input type="text" id="category_text" name="category_text" class="w_300" maxlength="30"/>
                            <div class="max_word">(Maximum 30 characters)</div>
                            <p>
                                <button class="m_left_150" onclick="saveCategory()">Save</button>
                            </p>
                        </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php }else if($common['organization_status']==-1 && $common['usergroup']->group_id==8){?>
<div class="main_content_outer"> 
    <div class="content_container">
        <div class="container_tab_header">Suggest New Category</div>	
        <div style="font-size:20px; line-height:25px; color:red;">Your organization is currently deactivated. Please contact your Zone Owner for more details.</div>
    </div>
</div>
<?php }?>