function savebranches(){
    var dataToUse = {
        "id" : $("#branches_id").val(),
        "address_id" : $("#address_id").val(),
        "business_id":$("#business").val(),
        "branches_name" : $("#branches_name").val(),
        "branches_number" : $("#branches_number").val(),
        "branches_address1" : $("#branches_address1").val(),
        "branches_address2" : $("#branches_address2").val(),
        "branches_city" : $("#branches_city").val(),
        "branches_state" : $("#branches_state").val(),
        "branches_zipcode" : $("#branches_zipcode").val(),
    };
    
    PageMethod("branches/save_branche", "Saving branche type<br/>This may take a minute.", dataToUse, business_typeSaveSuccessful,null);

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
    $("#editModal").dialog({ autoOpen: false, width: 460, title: "Branche Edit", show: "blind", hide: "explode",
        buttons: { "Save": function () { savebranches(); $(this).dialog("close"); },
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
function newbranches()
{
    $("#branches_id").val(-1);
    $("#address_id").val(-1);
    $("#business").val(0);
    $("#branches_name").val("");
    $("#branches_number").val("");
    $("#branches_address1").val("");
    $("#branches_address2").val("");
    $("#branches_city").val("");
    $("#branches_state").val("");
    $("#branches_zipcode").val("");
    $("#editModal").dialog("open");
}

function EditBranches(id){
    PageMethod("branches/json_business_type/" + id, "", null, ShowEdit, null);
}
function DeleteBranches(id, title){
    ConfirmDialog("Really delete : " + title, "Delete Branch", "branches/delete_branche", "Deleting Branches<br/>This may take a minute",
        { "id": id }, business_typeSaveSuccessful, null);
}
function ShowEdit(result){
    $.unblockUI();
    var cat = result;
    
    $("#branches_id").val(cat.b_id);
    $("#address_id").val(cat.address_id);
    $("#business").val(cat.business_id);
    $("#branches_name").val(cat.branch_name);
    $("#branches_number").val(cat.branch_identifier);
    
    $("#branches_address1").val(cat.street_address_1);
    $("#branches_address2").val(cat.street_address_2);
    $("#branches_city").val(cat.city);
    $("#branches_state").val(cat.state);
    $("#branches_zipcode").val(cat.zip_code);
    
    $("#editModal").dialog("open");
 }


