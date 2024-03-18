<input type="hidden" name="orgzoneid" id="orgzoneid" value="<?=$fromzoneid;?>" />
<input type="hidden" name="org_id" id="org_id" value="<?=$org_id;?>" />
<input type="hidden" name="orguser_id" id="orguser_id" value="<?=$uid;?>" />
<input type="hidden" name="zoneid" id="zoneid" value="<?=$common['zoneid']?>" />
<input type="hidden" name="orgnid" id="orgnid" value="<?=$common['organizationid']?>" />
<?php if(($common['organization_status']==1 || $common['usergroup']->group_id==4)){?>		
	<div class="main_content_outer"> 
		<div class="content_container">
		<div class="top-title">
        	<h2>View Webinar Information</h2>
         	<hr class="center-diamond">
      	</div>
		<div id="msg"></div>		
		<div id="container_tab_content" class="container_tab_content">   
			<div id="tabs-1_x">
				<div>
					<table class="pretty header datatable-all" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px;">
						<thead id="showhead">
							<tr>
								<th width="15%">Room link</th>            
								<th width="40%">Description</th>
								<th width="20%">Action</th>
							</tr>
						</thead>
						<tbody id="showannouncement" border="0" cellpadding="0" cellspacing="0"></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php }else if($common['organization_status']==-1 && $common['usergroup']->group_id==8) {?>
	<div class="main_content_outer">
		<div class="content_container">
			<div class="container_tab_header">View Webinar Information</div>
			<div style="font-size:20px; line-height:25px; color:red;">Your organization is currently deactivated. Please contact your Zone Owner for more details.</div>
		</div>
	</div>
<?php } ?>