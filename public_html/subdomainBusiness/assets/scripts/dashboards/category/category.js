function add_category(zoneid){ //alert($zoneid);
	var dataToUse = {
		"zoneid":zoneid
	};
	//alert(zoneid); return false;
	PageMethod("dashboards_1/add_new_cat_zone/"+zoneid, "Display The New Category...<br/>This may take a few minutes", null, requestZoneAddCategorySuccess, null);
}

function requestZoneAddCategorySuccess(result){
//alert(1);
	$.unblockUI();
	if(result.Tag!=''){	
		$("#new_cat").html(result.Tag);
		$("#edit_cat").html('');
		$("#new_subcat").html('');
		$("#edit_subcat").html('');		
	}
	//setupUI();
}