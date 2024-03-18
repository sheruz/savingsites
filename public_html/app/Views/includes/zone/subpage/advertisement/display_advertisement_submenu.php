<br/>
<?php if($bus_name[0]['name']!=''){?>
<div  id="newadzone" class="container_tab_header" style="background-color:#d2e08f; color:#222; font-size:13px;margin-top:-7px; margin-bottom:0px;">
	<!-- <button onclick="newadview()"  id="newad">post new ad under<strong> <?=$bus_name[0]['name']?></strong></button> -->
    Business Name : <strong> <?=urldecode($bus_name[0]['name'])?></strong>
    
    <a href="<?=base_url()?>businessdashboard/viewad/<?=$businessid?>/<?=$zoneid?>" class="link-underlined text-default fright"><b>&#x2192; Go To Business Dashboard</b></a>
	<!-- <?php if($selectid==0){?>
    <div id="newadd" style="float:right"><button onclick="allactivate_ads();">Activate All Ads</button> <button onclick="alldeactivate_ads();">Deactivate All Ads</button></div>
    <? } else if($selectid==1){?>
    <div id="deactivateadd" style="float:right"><button onclick="all_status_change_ads(<?=$selectid?>);">Deactivate All Ads</button></div>
    <? } else if($selectid==-1){?>
    <div id="activateadd" style="float:right"><button onclick="all_status_change_ads(<?=$selectid?>);">Activate All Ads</button></div>
    <? } ?> -->
</div>

<?php   } ?>
<input type="hidden" id="all_bus_id" name="all_bus_id" value="<?=$businessid?>" />  <input type="hidden" id="current_zoneid" name="current_zoneid" value="<?=$zoneid?>" />