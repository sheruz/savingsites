function save_zone_for_ad_pref(bus_id){    	   
	var zone_id=$("#contactZone_pref").val();	  
	//alert(bus_id); alert(zone_id); return false;	  
	if(zone_id=='val2'){	
		alert('Please select zone');
		return false;
	}
            	
	PageMethod("<?=base_url('dashboards/save_zone_for_ad_pref')?>/"+bus_id+"/"+zone_id, "Saving Zone for Ad Preference Settings...<br/>This may take a few minutes", null, requestZoneAddSettingSuccess, null);
}

function requestZoneAddSettingSuccess(result){
	$.unblockUI();
	if(result.Tag!=''){	
		$("#ad_setting_preferences").html(result.Tag);
	}
}

function delete_zone_for_ad_pref(bus_id,zone_id){	
	if(zone_id=='val2'){			
		return false;
	}
	PageMethod("<?=base_url('dashboards/delete_zone_for_ad_pref')?>/"+bus_id+"/"+zone_id, "Delete Zone for Ad Preference Settings...<br/>This may take a few minutes", null, requestZoneAddSettingSuccess, null);
}

function myname(){
	alert(1);
}