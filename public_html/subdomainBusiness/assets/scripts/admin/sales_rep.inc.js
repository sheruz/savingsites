function saveRep() {
    var dataToUse = {
        "id":$("#sales_rep_id").val(),
        "firstname":$("#sales_rep_firstname").val(),
        "lastname":$("#sales_rep_lastname").val(),
        "email":$("#sales_rep_email").val(),
        "addressid":$("#sales_rep_addressid").val(),
        "street1":$("#sales_rep_street1").val(),
        "street2":$("#sales_rep_street2").val(),
        "city":$("#sales_rep_city").val(),
        "state":$("#sales_rep_state").val(),
        "zipcode":$("#sales_rep_zipcode").val(),
        "phone":$("#sales_rep_phone").val()
    };
    PageMethod("sales_reps/save", "Saving Sales Rep<br/>This may take a minute.", dataToUse, repSaveSuccessful, null);

}
function setupUI() {
    var oTable = $('#tableHolder table').dataTable(
                {
                    "sDom": 't<"admin-footer-container"i>',
                    "iDisplayLength": -1,
                    "bSort": false,
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
    $("#salesrepEdit").dialog({ autoOpen: false, width: 460, title: "Sales Rep Edit",
        buttons: { "Save": function () {
            saveRep();
            $(this).dialog("close");
        },
            "Cancel": function () {
                $(this).dialog("close");
            } 
        }
    });
    setupButtons();
}
function setupButtons() {
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
$(document).ready(function () {
    setupUI();
});

function repSaveSuccessful(result) {
    $.unblockUI();
    $("#tableHolder").html(result.Tag);
    setupUI();
}
function newSalesRep() {
    $("#sales_rep_id").val(-1);
    $("#sales_rep_firstname").val("");
    $("#sales_rep_lastname").val("");
    $("#sales_rep_email").val("");
    $("#sales_rep_addressid").val("-1");
    $("#sales_rep_street1").val("");
    $("#sales_rep_street2").val("");
    $("#sales_rep_city").val("");
    $("#sales_rep_state").val("");
    $("#sales_rep_zipcode").val("");
    $("#sales_rep_phone").val("");
    $("#salesrepEdit").dialog("open");
}

function EditSalesRep(id) {
    PageMethod("sales_reps/json_result/" + id, "", null, ShowSalesRepEdit, null);
}
function DeleteSalesRep(id, title) {
    ConfirmDialog("Really delete : " + title, "Delete Sales Rep", "sales_reps/delete", "Deleting Rep<br/>This may take a minute",
        { "id": id }, repSaveSuccessful, null);
}
function ShowSalesRepEdit(result) {
    $.unblockUI();
    $("#sales_rep_id").val(result.repid);
    $("#sales_rep_firstname").val(result.firstname);
    $("#sales_rep_lastname").val(result.lastname);
    $("#sales_rep_email").val(result.email);
    $("#sales_rep_addressid").val(result.addressid);
    $("#sales_rep_street1").val(result.street_address_1);
    $("#sales_rep_street2").val(result.street_address_2);
    $("#sales_rep_city").val(result.city);
    $("#sales_rep_state").val(result.state);
    $("#sales_rep_zipcode").val(result.zip_code);
    $("#sales_rep_phone").val(result.phone);
    $("#salesrepEdit").dialog("open");
}