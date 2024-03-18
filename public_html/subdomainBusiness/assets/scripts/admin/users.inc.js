function saveRole(){
    var dataToUse = {
        "id":$("#role_user_id").val(),
        "user_role":$("#role_role").val()
    };
    PageMethod("users_controller/save_role", "Saving User Role<br/>This may take a minute.", dataToUse, null, null);
}

function saveUser() {
    var dataToUse = {
        "id":$("#user_id").val(),
        "username":$("#user_name").val(),
        "firstname":$("#user_firstname").val(),
        "lastname":$("#user_lastname").val(),
        "email":$("#user_email").val()
    };

    PageMethod("users_controller/save", "Saving User<br/>This may take a minute.", dataToUse, userSaveSuccessful, null);

}

function UpdateUserView(result){
    $.unblockUI();
    $("#users").html(result.Tag);
    $("#userEdit").dialog({ autoOpen:false, width:500, title:"Ad Edit",
        buttons:{ "Save":function () {
            saveAd();
            $(this).dialog("close");
        },
            "Cancel":function () {
                $(this).dialog("close");
            }}  });
    $("#userRoleEdit").dialog({ autoOpen:false, width:500, title:"Edit User Role", modal:true,
        buttons:{ "Save":function () {
            saveRole();
            $(this).dialog("close");
        },
            "Cancel":function () {
                $(this).dialog("close");
            }}  });
    $('#users table').dataTable(
        {
            "sPaginationType": "full_numbers",
            "bSort": false,
            "bPaginate": false,
            "iDisplayLength": 25,
            "bJQueryUI": true
        }
    );
    $('#users button').button();

}

function userSaveSuccessful(result) {
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
    $("#userEdit").dialog({ autoOpen: false, width: 500, title: "User Edit", modal: true, show: "blind", hide: "explode",
        buttons: { "Save": function () {
            saveUser();
            $(this).dialog("close");
        },
            "Cancel": function () {
                $(this).dialog("close");
            }
        }
    });
    $("#userRoleEdit").dialog({ autoOpen: false, width: 500, title: "User Edit", modal: true, show: "blind", hide: "explode",
        buttons: { "Save": function () {
            saveRole();
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

function newUser() {
    $("#user_id").val("-1");
    $("#user_username").val("");
    $("#user_firstname").val("");
    $("#user_lastname").val("");
    $("#user_email").val("");
    $("#user_security_level").val("0");
    $("#userEdit").dialog("open");
}

function EditUserRoles(id){
    PageMethod("users_controller/get_role/" + id, "", null, ShowUserRoleEdit, null);
}
function ShowUserRoleEdit(result){
    $.unblockUI();
    $("#role_user_id").val(result.id);
    $("#role_user_name").val(result.username);
    var secId = 0;
    if(result.securityId != null) { secId = result.securityId;}
    $("#role_role").val(secId);
    $("#userRoleEdit").dialog("open");

}
function EditUser(id) {
    PageMethod("users_controller/get/" + id, "", null, ShowUserEdit, null);
}
function DeleteUser(id, title) {
    ConfirmDialog("Really delete : " + title, "Delete User", "users_controller/delete", "Deleting User<br/>This may take a minute",
        { "id":id}, userSaveSuccessful, null);
}
function ShowUserEdit(result) {
    $.unblockUI();
    $("#user_id").val(result.id);
    $("#user_username").val(result.name);
    $("#user_firstname").val(result.first_name);
    $("#user_lastname").val(result.last_name);
    $("#user_email").val(result.email);
    $("#user_security_level").val(result.securityId);
    $("#userEdit").dialog("open");
}