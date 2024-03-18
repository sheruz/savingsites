<?php if(!empty($local_stores)) {?>
<table class="pretty commonformattedtable"  cellpadding="0" cellspacing="0" style="margin-top:10px;table-layout: fixed;width: 100%;">
 <thead>
 	<th width="30%">Store Name</th>
    <th width="20%">Store Link</th>
    <th	width="20%">Date</th>
    <th	width="15%">Actions</th>
 </thead>	
  <tbody>
    <?php foreach($local_stores as $store){?>
    <tr id="local_store_<?=$store['id']?>">
      <td style="text-align:justify;" width="30%"><?=$store['store_name']?></td>
      <td style="text-align:justify;width:150px;word-wrap:break-word;"><?=$store['store_link']?></td>
      <td width="20%" style="text-align:center;"><?=date('Y-m-d',$store['timestamp'])?></td>
      <td width="20%" style="text-align:center;">
            <input type="hidden" name="store_id" id="store_id" value="<?=$store['id']?>" />
            <a href="javascript:void(0);"><button class="editButton" onclick="store_edit(<?=$store['id']?>);return false;">Edit</button></a>
            <button class="m_top_10" onclick="store_delete(<?=$store['id']?>,<?=$store['zone_id']?>);">Delete</button>
      </td>
    </tr>
    <?php } ?>
  </tbody>
  <?php } else { ?>
  <div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Local Stores found.</div>
  <?php } ?>
</table>
