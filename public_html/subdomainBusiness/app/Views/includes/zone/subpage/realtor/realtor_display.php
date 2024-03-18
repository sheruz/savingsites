<input type="hidden" class="organization_type" value="<?=$organization_type?>"/>
<?php if(!empty($organization_list )){ ?>
<table class="pretty" border="0" cellpadding="0" cellspacing="0" style="margin-top:-13px;">   
    <tbody>
    <?php 
     foreach($organization_list as $org){ //var_dump($org);exit;
	 ?>
        <tr class="org_row" id="<?=$org['id']?>">
            
            <td width="20%"><b>
				<?=$org['name']?>
                </b><br/>
            </td>
            <?php if(empty($org['email'])){?>
            	<td width="20%"> Email: Not Provided
            <?php } else{?>
            	<td width="20%"> Email: <?=$org['email']?>
            <?php }?>
            <br />
            <?php if(!empty($org['phone'])){?>
                Phone: 
                <?php /*?><?=$org['unapproved']?><?php */?>
                <?=$org['phone']?>
            <?php }else{?>
            	Phone: Not Provided
            <?php }?>
            </td>
            
            <td width="30%">
                <a href="<?=base_url()?>realtordashboard/realtordetail/<?=$org['id']?>/<?=$org['zoneid'];?>" class="link-underlined text-default"><b>&#x2192; Go To Realtor Dashboard</b>
                </a><br />
                
                <a class="link-underlined text-default" onclick="EditRealtor(<?=$org['id']?>);" href="javascript:void(0)" id="edit_org" rel="<?=$org['id']?>" data-zoneid="<?=$org['zoneid'];?>" <?php /*?>data-businesstype="<?=$business_type?>" data-charvalname="<?=$charval_name?>"<?php */?> title="Edit <?=stripslashes($org['name'])?> Realtor"><b>&#x2192; Edit Realtor</b>
                </a><br />
               <?php /*?> <a href="<?=base_url()?>csvuploader_organization/index.php?csvuploaderzoneid=<?=$org['id'];?>&v=1" target="_blank" class="link-underlined text-default"><b>&#x2192; Upload Users From CSV File</b>
                </a><br/><?php */?>
                <!--<a href="javascript:void(0);" id="uploader_org" rel="<?=$org['id']?>" class="link-underlined text-default"><b>&#x2192; Upload Organization Members</b><br/>
                </a>-->
        	</td>
           
            <td width="12%"> 
            <input type="checkbox" name="checkadforchange" id="individual_checkbox_organization" class="display_checkbox1" value="<?=$org['id']?>"/>

            </td>
        </tr>
    <? } ?>
    </tbody>
</table>
<?php }else{ ?>

<div style="background-color:#222; color:#CCC; font-size:13px; text-align:center; margin-top:10px; margin-bottom:0px;" class="container_tab_header">No Realtor Found</div>

<?php } ?>



<script type="text/javascript">
$(document).on('click','#uploader_org',function(){
	var org_id=$(this).attr('rel');
	//$.cookie("csvuploaderzoneid", org_id);	
	var url='<?=base_url('csvuploader_organization/index.php?csvuploaderorgid=')?>'+org_id+'&v=1';
	window.open(url,'_blank');	
});
</script>




<!--<script type="text/javascript">

// + check_authneticate
function  check_authneticate(){ //alert(1);
	var is_authenticated=0;
	$.ajax({'url':'<?=base_url('/auth/check_authentication')?>',async:false, 'success':function(data){ //alert('success');
		is_authenticated=data;
	}});	
	return is_authenticated;
}
// - check_authneticate

// + Variable Initialization
// - Variable Initialization

// + goto_organization_dashboard/Success
function goto_organization_dashboard(orgid,zoneid){	
	var authenticate=check_authneticate();
	if(authenticate=='0'){
		var zone_id = <?=$zone_id?>;			 
		alert('You are currently logged out. Please log in to continue.');
		window.location.href = "<?=base_url('/index.php?zone=')?>" +  zone_id;			
	}else if(authenticate==1){
		window.location.href = "<?=base_url('Zonedashboard/organization')?>/" + orgid+"/"+zoneid;
	 }
}
// - goto_organization_dashboard/Success

</script>-->