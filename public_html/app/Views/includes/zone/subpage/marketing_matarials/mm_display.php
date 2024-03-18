
<?php if(!empty($market_materials)) {?>
<table class="pretty"  cellpadding="0" cellspacing="0" style="margin-top:10px">
 <thead>
 	<th width="30%">Uploaded Marketing Material</th>
    <th width="20%">Uploaded By</th>
    <th	width="20%">Date</th>
    <th	width="15%">Action</th>
 </thead>	
  <tbody>
    <?php foreach($market_materials as $mm){?>
    <tr id="mm_<?=$mm['id']?>">
      <td style="text-align:justify;" width="30%"><?=$mm['display_name']?>
        <br/>
        <br/>
        <?php if($mm['description']!=''){?>
        Description:
        <?=$mm['description']?>
        <? } ?></td>
      <?php if($mm['status']==2){?>
      <td style="text-align:center; " width="20%"></td>
      <? }else{?>
      <?php if($mm['last_name']=='' && $mm['first_name']==''){?>
      <td style="text-align:center;" width="20%"><?=$mm['username']?></td>
      <? }else {?>
      <td style="text-align:center;" width="20%">
        <?=$mm['first_name']?> <?=$mm['last_name']?>
      </td>
      <? } }?>
      <td width="20%" style="text-align:center;"><?=date('Y-m-d',$mm['timestamp'])?></td>
      <td width="15%" style="text-align:center;"><a href="<?=base_url('pdf_download/market_materials_zone')?>/<?=$mm['id']?>" target="_blank">
        <button>Download</button>
        </a>
        <?php if($mm['createdby']==$uid){?>
        <button class="m_top_10" onclick="mm_delete(<?=$mm['id']?>,<?=$mm['zoneid']?>);">Delete</button>
        <? } ?></td>
    </tr>
    <? } ?>
  </tbody>
  <? }  else { ?>
  <div class="container_tab_header" style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;">No Market Materials found.</div>
  <? } ?>
</table>
