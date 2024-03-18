<?php if(!empty($real_estates)) {?>
<table class="pretty commonformattedtable"  cellpadding="0" cellspacing="0" style="margin-top:10px">
 <thead>
 	<th width="30%">Real Estate Name</th>
    <th width="20%">Real Estate Link</th>
    <th	width="20%">Date</th>
    <th	width="15%">Actions</th>
 </thead>	
  <tbody>
    <?php foreach($real_estates as $estate){?>
    <tr id="real_estate_<?=$estate['id']?>">
      <td style="text-align:justify;" width="30%"><?=$estate['real_estate_name']?></td>
      <td style="text-align:justify;" width="30%"><?=$estate['real_estate_link']?></td>
      <td width="20%" style="text-align:center;"><?=date('Y-m-d',$estate['timestamp'])?></td>
      <td width="20%" style="text-align:center;">
            <input type="hidden" name="realestate_id" id="realestate_id" value="<?=$estate['id']?>" />
            <a href="javascript:void(0);"><button class="editButton" onclick="realestate_edit(<?=$estate['id']?>);return false;">Edit</button></a>
            <button class="m_top_10" onclick="realestate_delete(<?=$estate['id']?>,<?=$estate['zone_id']?>);">Delete</button>
      </td>
    </tr>
    <?php } ?>
  </tbody>
  <?php } else { ?>
  <div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Real Estates found.</div>
  <?php } ?>
</table>
