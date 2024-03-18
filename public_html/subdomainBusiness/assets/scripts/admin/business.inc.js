function saveBusiness() {
    var dataToUse = {
        "id":$("#biz_id").val(),
        "name": $("#biz_name").val(),
        "website": $("#biz_website").val(),
        "contactlastname":$("#biz_lastname").val(),
        "contactfirstname":$("#biz_firstname").val(),
        "contactemail":$("#biz_email").val(),
        "business_owner_id":$("#biz_owner").val(),
        "addressid":$("#biz_addressid").val(),
        "street1":$("#biz_street1").val(),
        "street2":$("#biz_street2").val(),
        "city":$("#biz_city").val(),
        "state":$("#biz_state").val(),
        "zipcode":$("#biz_zipcode").val(),
        "phone": $("#biz_phone").val()
    };
    PageMethod("businesses/save", "Saving Business<br/>This may take a minute.", dataToUse, businessSaveSuccessful, null);

}
function businessSaveSuccessful(result) {
    $.unblockUI();
    $("#tableHolder").html(result.Tag);
    setupUI();
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
    $("#businessEdit").dialog({ autoOpen: false, width: 460, title: "Business Edit", show:"blind", hide : "explode",
        buttons: { "Save": function () {
            saveBusiness();
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


function newBusiness() {
    $("#biz_id").val("-1");
    $("#biz_name").val("");
    $("#biz_lastname").val("");
    $("#biz_firstname").val("");
    $("#biz_email").val("");
    $("#biz_owner").val("0");
    $("#biz_addressid").val("-1");
    $("#biz_street1").val("");
    $("#biz_street2").val("");
    $("#biz_city").val("");
    $("#biz_state").val("");
    $("#biz_zipcode").val("");
    $("#biz_phone").val("");

    $("#businessEdit").dialog("open");
}

function EditBusiness(id) {
    PageMethod("businesses/get/" + id, "", null, ShowBusinessEdit, null);
}
function DeleteBusiness(id, title) {
    ConfirmDialog("Really delete : " + title, "Delete Business", "/businesses/delete", "Deleting Business<br/>This may take a minute",
        { "id":id}, null, null);
}
function ShowBusinessEdit(result) {
    $.unblockUI();
    $("#biz_id").val(result.id);
    $("#biz_name").val(result.name);
    $("#biz_lastname").val(result.contactlastname);
    $("#biz_firstname").val(result.contactfirstname);
    $("#biz_email").val(result.contactemail);
    $("#biz_owner").val(result.business_owner_id);
    $("#biz_addressid").val(result.addressid);
    $("#biz_street1").val(result.street_address_1);
    $("#biz_street2").val(result.street_address_2);
    $("#biz_city").val(result.city);
    $("#biz_state").val(result.state);
    $("#biz_zipcode").val(result.zip_code);
    $("#biz_phone").val(result.phone);
    $("#businessEdit").dialog("open");
}