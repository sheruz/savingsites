<input type="hidden" class="realtor_type" value="1"/>
<?php if(!empty($homesold_list )){ ?>
<table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:-13px;">   
    <tbody>
    <?php 
     foreach($homesold_list as $org){ //var_dump($org);var_dump($org['bedrooms']);var_dump($org['amountsoldprice']);exit;
	 ?>
        <tr class="org_row" id="<?=$org['id']?>">
            
            <td width="15%" style="text-align:center;"><b>
				<?=$org['streetnumber']?>
                </b><br/>
            </td>
            
            <td width="10%" style="text-align:center;"><b>
				<?=$org['city']?>
                </b><br/>
            </td>
            
            <td width="10%" style="text-align:center;"><b>
                <?=$org['amountsoldprice']?>
				<!--<?=$org['dateclosed']?>-->
                </b><br/>
            </td>
            
            <td width="15%" style="text-align:center;"><b>
				<!--<?=$org['amountsoldprice']?>-->
                <?php echo date('d F Y',$org['dateclosed']);?>
               <!-- <?=$org['dateclosed']?>-->
                </b><br/>
            </td>
            
            <td width="10%" style="text-align:center;"><b>
				<?=$org['bedrooms']?>
                </b><br/>
            </td>
            <td width="10%" style="text-align:center;"><b>
				<?=$org['bathrooms']?>
                </b><br/>
            </td>
            
            
            <!--<td width="30%">
                <a href="<?=base_url()?>realtordashboard/realtordetail/<?=$org['id']?>/<?=$org['zoneid'];?>" class="link-underlined text-default"><b>&#x2192; Go To Realtor Dashboard</b>
                </a><br />
                
                <a class="link-underlined text-default" onclick="EditRealtor(<?=$org['id']?>);" href="javascript:void(0)" id="edit_org" rel="<?=$org['id']?>" data-zoneid="<?=$org['zoneid'];?>" <?php /*?>data-businesstype="<?=$business_type?>" data-charvalname="<?=$charval_name?>"<?php */?> title="Edit <?=stripslashes($org['name'])?> Realtor"><b>&#x2192; Edit Realtor</b>
                </a><br />
               <?php /*?> <a href="<?=base_url()?>csvuploader_organization/index.php?csvuploaderzoneid=<?=$org['id'];?>&v=1" target="_blank" class="link-underlined text-default"><b>&#x2192; Upload Users From CSV File</b>
                </a><br/><?php */?>
                <!--<a href="javascript:void(0);" id="uploader_org" rel="<?=$org['id']?>" class="link-underlined text-default"><b>&#x2192; Upload Organization Members</b><br/>
                </a>
        	</td>-->
            <?php if($approve_csv[0]['auto_approve_csvupload']==1){ ?>
            <td width="10%" style="text-align:center;"> 
            <input type="checkbox" name="checkadforchange" id="individual_checkbox_organization" class="display_checkbox1" value="<?=$org['id']?>"/>

            </td>
            <?php } ?>
        </tr>
    <? } ?>
    </tbody>
</table>
<?php }else{ ?>

<div style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;" class="container_tab_header">No Home Sold Found</div>

<?php } ?>



<script type="text/javascript">
$(document).on('click','#uploader_org',function(){
	var org_id=$(this).attr('rel');
	//$.cookie("csvuploaderzoneid", org_id);	
	var url='<?=base_url('csvuploader_organization/index.php?csvuploaderorgid=')?>'+org_id+'&v=1';
	window.open(url,'_blank');	
});
</script>

