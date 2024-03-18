<table class="pretty"  cellpadding="0" cellspacing="0" style="margin-top:10px">
	<?php if(!empty($uploaded_letters)) {?>
  	<thead>
    	<tr><th style="width:300px !important;">Uploaded Letters Name</th>
        	<th style="width:250px !important;">Uploaded By</th>
            <th>Uploaded Date</th><th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($uploaded_letters as $mm){?>
    	<tr id="ul_<?=$mm['id']?>">
    		<td style="text-align:justify;width:300px !important;">
            <?=$mm['display_name']?><br/><br/><?php if($mm['description']!=''){?>Description: <?=$mm['description']?><? } ?> 
            </td>
            <?php if($mm['status']==2){?>
            <td style="text-align:center; width:250px !important;"></td>
            <? }else{?>
            <?php if($mm['last_name']=='' && $mm['first_name']==''){?>
			 <td style="text-align:center; width:250px !important;">
            	<?=$mm['username']?>
            </td>	
			
            <? }else {?>
            <td style="text-align:center;">
            <?=$mm['first_name']?> <?=$mm['last_name']?>  
            </td>
            <? } }?>
            <td style="text-align:center;">
            <?=date('Y-m-d',$mm['timestamp'])?>
            </td>
             <td style="text-align:center;">
             <button onclick="edit_uploaded_letters(<?=$mm['id']?>,<?=$mm['zoneid']?>);">Edit</button>
             <?php if($mm['createdby']==$uid){?>
             <button class="m_top_10" onclick="delete_uploaded_letters(<?=$mm['id']?>,<?=$mm['zoneid']?>);">Delete</button>
             <? } ?>
             </td>
    	</tr>
        <? } ?>
    </tbody>
</table>
    <? }  else { ?>
    	<div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Uploaded Letters found.</div>
    <? } ?>
                
                
               