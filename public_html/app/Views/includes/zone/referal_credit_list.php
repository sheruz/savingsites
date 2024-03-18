<div class="main_content_outer">
  <div class="content_container">
    <div class="container_tab_header">Businesses Having Refereal Credit</div>
    <div id="container_tab_content" class="container_tab_content">
      <div id="tabs-1">
        <div class="form-group">
        <div class="text-dafault container_tab_header" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:10px; margin-bottom:0px;">This shows the list of Businesses who have got the referal credit.</div>
          <input type="hidden" id="zoneid" name="zoneid" value="<?=$zoneid?>"/>
          <?php if(!empty($referal_credit_businesses)){?>
          <div id="referal_credit_businesses" style="margin-top: 5px;">
    			<table align="center" class="pretty" width="950px" cellpadding="0" cellspacing="0">
	                <thead>
	                   <tr>
	                   		<th width="90px">Business Name</th>
							<th width="50px">User Name</th>
                            <th width="80px">Email</th>
                            <th width="50px">Phone</th>							
                            <!--<th width="80px">Action</th>-->
	                   </tr>
	                </thead>
	                <tbody>
	                    <? foreach ($referal_credit_businesses as $business_list){?>
	                    <tr>
                        	<td><?=$business_list['name']?></td>
                            
                            <td><?=$business_list['username']?></td>
	                    	
                            <td><?=$business_list['contactemail']?></td>
                            
                            <td><?=$business_list['phone']?></td>
                            
                           <!-- <td>
								<input type="button" class="zone_owner_approve" name="zone_owner_approve[<?=$business_list['id']?>]" id="zone_owner_approve<?=$business_list['id']?>" value="Approve" />
							</td>-->
					</tr>
						<? } ?>
	            	</tbody>
	            </table>
            </div>
            <?php }else{?>
    	<div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Businesses Found.</div>
   	<?php }?>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () { 
	$('#zone_business_accordian').click();
	$('#zone_business_referal_credit').addClass('active');
});
</script> 


