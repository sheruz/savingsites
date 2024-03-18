<div class="for-sepret-one">
	<!--<div class="for-tex-container"><a href="#" onclick="get_business_bulk();return false;">Business</a></div>
	<div class="for-tex-container"><a href="#" onclick="get_template_bulk();return false;">Template</a></div>-->
</div>       
<br/>
<?php
 
if(!empty($template) && $template=='template')
{
if(!empty($template_list)){?>
		<table align="center" class="pretty" width="950px" cellpadding="0" cellspacing="0">
                <thead>
                   <tr>
                        <th width="80px">Id</th>
						<th width="200px">Subject</th>
						<th width="250px">Content</th>
						<th width="250px">Admin</th>
                   </tr>
                </thead>
                <tbody>
                    <? foreach ($template_list as $business_types){?>
                    <tr>
						<td><?=$business_types['id']?></td>
						<td><?=$business_types['subject']?></td>
						<td><?=$business_types['content']?></td>
						<td>
						<button onclick="Edittemplate(<?=$business_types['id']?>)">Edit</button>
						<button onclick="Deletetemplate(<?=$business_types['id']?>, '<?=str_replace("'","\'",$business_types['subject'])?>')">Delete</button>
						</td>
					</tr>
					<?}?>
            	</tbody>
            </table>
            <button onclick="newtemplate_bulk()">New Template</button>
<?php
}else{?>
        <table align="center" class="pretty" width="950px" cellpadding="0" cellspacing="0">
                <thead>
                   <tr>
                        <th width="80px">Id</th>
						<th width="200px">Subject</th>
						<th width="250px">Content</th>
						<th width="250px">Admin</th>
                   </tr>
                </thead>
                <tbody>
                    <tr>
					    <td colspan="4">No Template Found</td>
				    </tr>
            	</tbody>
            </table>
            <button onclick="newtemplate_bulk()">New Template</button>
    <?php 
}?>
<?php 
}elseif(!empty($template) && $template=='newtemplate')
{
	?>
	<input type="hidden" name="hidden_temp_id" id="hidden_temp_id" value="<?php if(!empty($template_data->id)){echo $template_data->id;}else{ echo '-1';}?>" />
<p><label for="subscriber">Short codes : </label>
 	{first_name}, {last_name}, {phone}, {Address}, {City}, {Zip}
</p>

<p>
	<label for="template_subject">Subject</label>
	<input  type="text" id="template_subject" name="template_subject" value="<?php if(!empty($template_data->subject)){echo $template_data->subject;}?>"/><br/>
</p>
<p>
	<label for="addtemplate_content">Message</label>
	<textarea id="addtemplate_content" name="addtemplate_content"><?php if(!empty($template_data->content)){echo $template_data->content;}?></textarea>
	<?php echo display_ckeditor($ckeditor); ?>
</p>


<button onclick="save_template('0')">Save</button>
<button onclick="get_template_bulk()">Cancel</button>
<?php 
}
elseif(!empty($business_owner_bulk))
{?>
			<table align="center" class="pretty" width="950px" cellpadding="0" cellspacing="0">
	                <thead>
	                   <tr>
	                   		<th width="250px">Businesses Name</th>
							<th width="200px">User Name</th>							
                            <th width="80px">Action <input type="checkbox" onclick="return select_all(this);" name="article_news" id="article_news" value="all"  /></th>
	                   </tr>
	                </thead>
	                <tbody>
	                    <? foreach ($business_owner_bulk as $business_types){?>
	                    <tr>
                        	<td>
								<?=$business_types['name']?>								
							</td>
                            <td><?=$business_types['username']?></td>
	                    	<td>
								<input type="checkbox" class="zone_owner_check" name="zone_owner[<?=$business_types['userid']?>]" id="zone_owner_<?=$business_types['userid']?>" value="<?=$business_types['userid']?>" />
							</td>
					</tr>
						<? } ?>
	            	</tbody>
	            </table>
               <!-- <div class="for-tex-container"><a href="#" onclick="send_all_business_bulk();return false;">Send mail to all</a></div>-->
               <div class="for-tex-container" style="float:right;"><a class="text-default" href="javascript:void(0);" onclick="send_all_business_bulk_new();return false;">Send Mail to all</a></div>
	            <!--<button onclick="send_all_business_bulk()">Send mail to all</button>-->
	<?php
}else{
	?>
			<table align="center" class="pretty" width="950px" cellpadding="0" cellspacing="0">
	                <thead>
	                   <tr>
                       		<th width="250px">Businesses Name</th>
                            <th width="250px">User Name</th>
	                        <th width="80px">Action</th>		
	                   </tr>
	                </thead>
	                <tbody>
	                    <tr>
							<td colspan="3">No Business Found</td>
						</tr>
	            	</tbody>
	            </table>
	<?php

}
if(!empty($ajax) && $ajax=='ajax')
{
	exit;
}
