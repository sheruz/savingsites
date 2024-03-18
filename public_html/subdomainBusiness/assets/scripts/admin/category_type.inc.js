function saveCategory_types(){
    var dataToUse = {
        "id" : $("#category_type_id").val(),
        "cat_name" : $("#category_name").val(),
		"sub_cat_name" : $("#subcategory_name").val(),
		"status" : $("#category_status").val(),
    };
    PageMethod("category_management/save_category_type", "Saving business type<br/>This may take a minute.", dataToUse, category_typeSaveSuccessful,null);

}


function saveSubCategory_types(){ //alert(1); return false;
    var dataToUse = {
        /*"id" : $("#category_type_id").val(),*/
        "cat_id" : $("#category_select").val(),
		"sub_cat_name" : $("#subcategory_name").val(),
		"subcat_status" : $("#category_status").val(),
    };
    PageMethod("category_management/save_sub_category_type", "Saving business type<br/>This may take a minute.", dataToUse, category_typeSaveSuccessful,null);

}


function category_typeSaveSuccessful(result) {
	//alert(result);
    $.unblockUI();
    $("#tableHolder1").html(result.Tag);
    setupUI();
}
$(document).ready(function () {
    setupUI();
});
function setupUI() {
    var oTable = $('#tableHolder table').dataTable(
                {
                    "sDom": 't<"admin-footer-container"i>',
                    "iDisplayLength": -1,
                    "bSort" : false,
                    "aoColumnDefs":
                    [
                            { "bSearchable": false, "bVisible": false, "aTargets": [0] }
                    ]
                });

    $("#searchText").change(function () {
        oTable.fnFilter($("#searchText").val());
    });

    $("#searchText").keyup(function () {
        oTable.fnFilter($("#searchText").val());
    });
    $("#editModal").dialog({ autoOpen: false, width: 600, title: "Category Edit", show: "blind", hide: "explode",
        buttons: { "Save": function () { saveCategory_types(); $(this).dialog("close"); },
            "Cancel": function () { $(this).dialog("close"); }
        }
    });
	
	// for sub category
	 $("#editsubcatModal").dialog({ autoOpen: false, width: 600, title: "Category Edit", show: "blind", hide: "explode",
        buttons: { "Save": function () { saveSubCategory_types(); $(this).dialog("close"); },
            "Cancel": function () { $(this).dialog("close"); }
        }
    });
	
	
    $(".editButton").button({ icons: {
        primary: "ui-icon-pencil"
    },
        text: false
    });
    $(".deleteButton").button({ icons: {
        primary: "ui-icon-trash"
    },
        text: false
    });
    $(".newButton").button({ icons: {
        primary: "ui-icon-plusthick"
    },
        text: false
    });
}
function newCategory() 
{
    $("#category_type_id").val(-1);
    $("#category_name").val("");
	$("#subcategory_name").val("");
    $("#editModal").dialog("open");
}

function newsubCategory() 
{
   // alert(1); return false;
	$("#category_type_id").val(-1);
    $("#category_name").val("");
	$("#subcategory_name").val("");
    $("#editsubcatModal").dialog("open");
}

function EditCategory_types(id){ alert(1); return false;
    PageMethod("category_management/json_category_type/" + id, "", null, ShowEdit, null);
}
function DeleteBusiness_types(id, title){
    ConfirmDialog("Really delete : " + title, "Delete Business Type", "business_type/delete_business_type", "Deleting Business Type<br/>This may take a minute",
        { "id": id }, business_typeSaveSuccessful, null);
}
function ShowEdit(result){
	//alert(JSON.stringify(result));
    $.unblockUI();
    var cat = result;
	//alert(cat);
    $("#category_type_id").val(cat.id);
    $("#category_name").val(cat.name);
	$("#subcategory_name").val(cat.name);
    $("#editModal").dialog("open");
 }
 
function getsubcat(id){ //alert(id); return false;
	
	PageMethod("category_management/subcat/" + id, "", null, "null", null);
}
/*function show_sub_category(result) {
	//alert(result);
    $.unblockUI();
    $("#tableHolder1").html(result.Tag);
    setupUI();
}*/