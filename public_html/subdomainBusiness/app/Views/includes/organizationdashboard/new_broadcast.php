<?php 
	if(!isset($_REQUEST['brodcastid'])){
		$announcement_list = [];		
	}
?>
<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />
<input type="hidden" name="orgnid" id="orgnid" value="<?=$common['organizationid']?>" />
<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />

<?php if(($common['organization_status']==1 || $common['usergroup']->group_id==4)){?>
<div class="main_content_outer"> 
	<div class="content_container">
		<div class="top-title">
        	<h2>Create SNAP Voice Broadcast Options</h2>
         	<hr class="center-diamond">
      	</div>
		<div id="msg"></div>	
		<div id="container_tab_content" class="container_tab_content bv_annoucement_edit">
			<div id="annoucement_edit" class="form-group">
				<input type="hidden" id="announcement_id" name="announcement_id" value="<?= isset($announcement_list[0]['announceId'])?$announcement_list[0]['announceId']:'-1'; ?>"/>
				<input type="hidden" id="announcement_subcat_id" name="announcement_subcat_id" value="-1"/>
				<input type="hidden" class="usersubcat" value="">
				<p class="form-group-row">
					<label for="announcement_title" class="fleft w_200">Title</label>
	<input type="text" id="announcement_title" name="announcement_title" value="<?= isset($announcement_list[0]['announceTitle'])?$announcement_list[0]['announceTitle']:''; ?>" class="w_536" placeholder="Title"/>
				</p>
				<div class="spacer"></div>

				<p class="form-group-row main_cat">
					<label for="announcement_title" class="fleft w_200">Category</label>
					<select id="all_categories" name="all_categories" style="width:555px;">
						<option value="0">Select Category</option>
						<?php foreach($getall_category as $val){
							if(isset($announcement_list[0]['categoryId']) && $announcement_list[0]['categoryId'] == $val['id']){
								$selected = 'selected';
							}else{
								$selected = '';
							}
							?>
							<option <?= $selected; ?> value="<?php echo $val['id'];?>"><?php echo $val['name'];?></option>
						<?php }?>
					</select>
				</p>

				<div class="row margin-bottom-sm">
					<label style="margin-bottom:6px;">Date of Broadcast:</label>
					<div id="" class="relative">
						<span class="input-group-addon">
							<i class="fa fa-calendar-o fa-fw"></i>
						</span>
						<input  required="required" value="<?= isset($announcement_list[0]['announceDate'])?$announcement_list[0]['announceDate']:''; ?>" class="form-control" autocomplete="off" id="bookdate_picker" type="text" placeholder="Date"/>
						<input name="offer_date" id="offer_date" type="hidden" value="Today" />
					</div>
					<div class="col-sm-5"></div>
				</div><hr />
				
				<div class="row margin-bottom-sm margin-top-sm">
					<label style="margin-bottom:6px;">Time of Broadcast:</label>
					<div class="row baroadcast_row">
						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '6 AM'){ echo "checked";} ?>  value="6 AM"/> 6 AM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '7 AM'){ echo "checked";} ?>  value="7 AM"/> 7 AM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '8 AM'){ echo "checked";} ?>  value="8 AM"/> 8 AM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '9 AM'){ echo "checked";} ?>  value="9 AM"/> 9 AM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '10 AM'){ echo "checked";} ?> value="10 AM"/> 10 AM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '11 AM'){ echo "checked";} ?> value="11 AM"/> 11 AM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '12 PM'){ echo "checked";} ?> value="12 PM"/> 12 PM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '1 PM'){ echo "checked";} ?> value="1 PM"/> 1 PM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '2 PM'){ echo "checked";} ?> value="2 PM"/> 2 PM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '3 PM'){ echo "checked";} ?> value="3 PM"/> 3 PM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '4 PM'){ echo "checked";} ?>  value="4 PM"/> 4 PM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '5 PM'){ echo "checked";} ?> value="5 PM"/> 5 PM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '6 PM'){ echo "checked";} ?>  value="6 PM"/> 6 PM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '7 PM'){ echo "checked";} ?>  value="7 PM"/> 7 PM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '8 PM'){ echo "checked";} ?> value="8 PM"/> 8 PM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '9 PM'){ echo "checked";} ?> value="9 PM"/> 9 PM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '10 PM'){ echo "checked";} ?> value="10 PM"/> 10 PM
							</span>
						</div>

						<div class="col-md-2 col-sm-3 col-xs-3">
							<span class="input_left margin-bottom-sm">
								<input type="radio" name="bookTime" class="offer_times" <?php if(isset($announcement_list[0]['announceTime']) && $announcement_list[0]['announceTime'] == '11 PM'){ echo "checked";} ?> value="11 PM"/> 11 PM
							</span>
						</div>
					</div>
				</div>
				<hr />
				<div class="spacer" ></div>
				
				<p class="form-group-row">
					<label for="announcement_text" class="fleft w_200">Annoucement Text<br />(100 Characters)</label>
					<span class="fleft dis_block">
						<textarea id="announcement_text" name="announcement_text" rows="3" cols="45" style="width: 536px;" maxlength="100"><?= isset($announcement_list[0]['announcement'])?$announcement_list[0]['announcement']:''; ?></textarea>
					</span>
				</p>
				<div class="spacer"></div>
				<button class="m_left_200" onclick="saveBroadcast()" style="cursor:pointer">Save</button>
			</div>
		</div>
	</div>
</div>

<?php  }?>
<script type="text/javascript">
  $('#bookdate_picker').datetimepicker();
</script>