<?php
### Created by Athena eSolutions
?>

<div class="form-group center-block-table">
<form name="editgroupzone" id="edit_group_zone" method="post" action="">
	<input type="hidden" name="zoneid" id="zoneid" value="<?php echo $zoneid?>">
    <input type="hidden" name="createdby_id" id="createdby_id" value="<?php echo $createdby_id?>">
    <input type="hidden" name="createdby_type" id="createdby_type" value="<?php echo $createdby_type?>">
    <input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id?>">
    <p class="form-group-row">
          <label for="gr_name" class="fleft w_200">Group Name</label>
          <input type="text" id="group_name" class="w_300" name="group_name" value="<?=$group_details[0]['name']?>" />
    </p>
    <p class="form-group-row">
          <label for="add_description" class="fleft w_200">Description</label>
          <textarea id="add_desc" name="add_desc" class="w_300"><?=$group_details[0]['description']?></textarea>
    </p>
   
    <input class="m_left_200" name="interestgroup" type="submit" value="Update">
    
         <!-- <button class="m_left_200" onclick="save_group(<?php echo $zoneid?>,<? echo $createdby_id;?>,<? echo $createdby_type;?>,<? echo $group_id;?>,$('#group_name').val(),$('#add_desc').val());">Save Group</button>-->
   
</form>    
</div>
                        <!--<table align="center" class="admin-table" cellpadding="4" cellspacing="6">
                              <tr>
                              	<td width="50%"><label for="group_name" class="fleft w_100">Group Name</label></td>
								<td width="40%"><input  type="text" id="group_name" class="w_300" name="group_name" value="<?=$group_details[0]['name']?>"/>
			 					<br/></td>
                              </tr>
                              
                              <tr>
                              	<td width="50%"><label for="add_desc" class="fleft w_100"> Description</label></td>
								<td width="40%"><textarea id="add_desc" name="add_desc"><?=$group_details[0]['description']?></textarea></td>
                              </tr>
                              
                              <tr>
                                <td width="50%"></td>
                                <td width="40%"><button onclick="save_group(<?php echo $zoneid?>,<? echo $createdby_id;?>,<? echo $createdby_type;?>,<? echo $group_id;?>,$('#group_name').val(),$('#add_desc').val());">Save Group</button></td>
                              </tr>
                        </table>-->
