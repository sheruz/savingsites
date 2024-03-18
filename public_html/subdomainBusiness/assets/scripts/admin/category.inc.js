function saveCategory(){
    var dataToUse = {
        "id" : $("#cat_id").val(),
        "name" : $("#cat_name").val(),
        "ord" : $("#cat_ordinal").val(),
        "business_type" : $("#cat_businessType").val()
    };
    PageMethod("category/save_category", "Saving Category<br/>This may take a minute.", dataToUse, categorySaveSuccessful,null);

}

function categorySaveSuccessful(result) {
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
    $("#editModal").dialog({ autoOpen: false, width: 460, title: "Category Edit", show: "blind", hide: "explode",
        buttons: { "Save": function () { saveCategory(); $(this).dialog("close"); },
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
    $("#cat_id").val(-1);
    $("#cat_name").val("");
    $("#cat_ordinal").val(1);
    $("#cat_business_type").val(1);
    $("#editModal").dialog("open");
}

function EditCategory(id){
    PageMethod("category/json_category/" + id, "", null, ShowEdit, null);
}
function DeleteCategory(id, title){
    ConfirmDialog("Really delete : " + title, "Delete Category", "category/delete_category", "Deleting Category<br/>This may take a minute",
        { "id": id }, categorySaveSuccessful, null);
}
function ShowEdit(result){
    $.unblockUI();
    var cat = result;
    $("#cat_id").val(cat.id);
    $("#cat_name").val(cat.name);
    $("#cat_ordinal").val(cat.ordinal);
    $("#cat_business_type").val(cat.business_type_id);
    $("#editModal").dialog("open");
 }