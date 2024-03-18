<?php if(!empty($autos)) {?>
<table class="pretty commonformattedtable"  cellpadding="0" cellspacing="0" style="margin-top:10px">
 <thead>
 	<th width="30%">Auto Name</th>
    <th width="20%">Auto Link</th>
    <th	width="20%">Date</th>
    <th	width="15%">Actions</th>
 </thead>	
  <tbody>
    <?php foreach($autos as $auto){?>
    <tr id="autos_<?=$auto['id']?>">
      <td style="text-align:justify;" width="30%"><?=$auto['autos_name']?></td>
      <td style="text-align:justify;" width="30%"><?=$auto['autos_link']?></td>
      <td width="20%" style="text-align:center;"><?=date('Y-m-d',$auto['timestamp'])?></td>
      <td width="20%" style="text-align:center;">
            <input type="hidden" name="autos_id" id="autos_id" value="<?=$auto['id']?>" />
            <a href="javascript:void(0);"><button class="editButton" onclick="autos_edit(<?=$auto['id']?>);return false;">Edit</button></a>
            <button class="m_top_10" onclick="autos_delete(<?=$auto['id']?>,<?=$auto['zone_id']?>);">Delete</button>
      </td>
    </tr>
    <?php } ?>
  </tbody>
  <?php } else { ?>
  <div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Autos found.</div>
  <?php } ?>
</table>
