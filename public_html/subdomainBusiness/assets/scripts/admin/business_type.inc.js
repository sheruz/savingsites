function saveBusiness_types(){
    var dataToUse = {
        "id" : $("#business_type_id").val(),
        "name" : $("#business_type").val(),
    };
    PageMethod("business_type/save_business_type", "Saving business type<br/>This may take a minute.", dataToUse, business_typeSaveSuccessful,null);

}

function business_typeSaveSuccessful(result) {
    $.unblockUI();
    $("#tableHolder").html(result.Tag);
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
    $("#editModal").dialog({ autoOpen: false, width: 460, title: "Business Type Edit", show: "blind", hide: "explode",
        buttons: { "Save": function () { saveBusiness_types(); $(this).dialog("close"); },
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
function newBusiness_types()
{
    $("#business_type_id").val(-1);
    $("#business_type").val("");
    $("#editModal").dialog("open");
}

function EditBusiness_types(id){
    PageMethod("business_type/json_business_type/" + id, "", null, ShowEdit, null);
}
function DeleteBusiness_types(id, title){
    ConfirmDialog("Really delete : " + title, "Delete Business Type", "business_type/delete_business_type", "Deleting Business Type<br/>This may take a minute",
        { "id": id }, business_typeSaveSuccessful, null);
}
function ShowEdit(result){
    $.unblockUI();
    var cat = result;
    $("#business_type_id").val(cat.id);
    $("#business_type").val(cat.name);
    $("#editModal").dialog("open");
 }