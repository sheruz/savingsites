function saveAnnouncement() {
    var dataToUse = {
        "id":$("#announcement_id").val(),
        "title":$("#announcement_title").val(),
        "zone_id": $("#announcement_zone").val(),
        "announcement_text":nicEditors.findEditor('announcement_text').getContent()
    };

    PageMethod("announcements/save", "Saving Announcement<br/>This may take a minute.", dataToUse, announceSaveSuccessful, null);
}

function announceSaveSuccessful(result) {
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
    $("#announcementEdit").dialog({ autoOpen: false, width: 500, title: "Announcement Edit", show: "blind", hide: "explode",
        buttons: { "Save": function () {
            saveAnnouncement();
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
    new nicEditor({ buttonList: ['fontSize', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'bgcolor', 'forecolor'] }).panelInstance('announcement_text');
    setupUI();
});

function newAnnouncement    () {
    $("#announcement_id").val("-1");
    $("#announcement_title").val("");
    $("#announcement_zone").val("0");
    nicEditors.findEditor('announcement_text').setContent("");
    $("#announcementEdit").dialog("open");
}

function loadZone() {
    PageMethod("announcements/loadZone/" + $("#zone_select").val(), "Loading Zone", null, announceSaveSuccessful, null);
}

function EditAnnouncement(id) {
    PageMethod("announcements/get/" + id, "", null, ShowAnnouncementEdit, null);
}
function DeleteAnnouncement(id, title) {
    ConfirmDialog("Really delete : " + title, "Delete Announcement", "announcements/delete", "Deleting Announcement<br/>This may take a minute",
        { "id": id }, announceSaveSuccessful, null);
}
function ShowAnnouncementEdit(result) {
    $.unblockUI();
    $("#announcement_id").val(result.id);
    $("#announcement_title").val(result.title);
    $("#announcement_zone").val(result.zone_id);
    nicEditors.findEditor('announcement_text').setContent(result.announcement_text);
    $("#announcementEdit").dialog("open");
}