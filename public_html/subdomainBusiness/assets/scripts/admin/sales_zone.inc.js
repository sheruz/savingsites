function saveZone() {

    var dataToUse = {

        "id": $("#sales_zone_id").val(),

        "name": $("#sales_zone_name").val(),

        "state": $("#sales_zone_state").val(),

        "sales_rep_id": $("#sales_zone_repid").val(),
		"cat_option": $("#cat_option").val(),
        "category": $("#category").val()

    };



    PageMethod("sales_zones/save", "Saving Sales Zone<br/>This may take a minute.", dataToUse, zoneSaveSuccessful, null);



}

function downloadSalesZone(zoneId){

    window.open ("http://www.savingssites.com/businesses/get_businesses_for_zone_csv/" + zoneId,"mywindow");

}

function zoneSaveSuccessful(result) {

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

    $("#salesZoneEdit").dialog({ autoOpen: false, width: 640, title: "Zone Edit", show: "blind", hide: "explode",

        buttons: { "Save": function () { saveZone(); $(this).dialog("close"); },

            "Cancel": function () { $(this).dialog("close"); }

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

    $(".downloadButton").button({ icons: {

        primary: "ui-icon-disk"

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



function newSalesZone() {

    $("#sales_zone_id").val("-1");

    $("#sales_zone_name").val("");

    $("#sales_zone_state").val("");

    $("#sales_zone_repid").val(defaultId);
	
	$("#cat_option").val('');
	
    $("#salesZoneEdit").dialog("open");
	

}



function EditSalesZone(id) {

    PageMethod("sales_zones/get/" + id, "", null, ShowSalesZoneEdit, null);

}

function DeleteSalesZone(id, title) {

    ConfirmDialog("Really delete : " + title, "Delete Sales Zone", "sales_zones/delete", "Deleting Zone<br/>This may take a minute",

        { "id": id }, null, null);

}

function ShowSalesZoneEdit(result) {

    $("#sales_zone_id").val(result.id);

    $("#sales_zone_name").val(result.name);

    $("#sales_zone_state").val(result.state);

    $("#sales_zone_repid").val(result.sales_rep_id);
	
	$("#cat_option").val(result.cat_option);



    UpdateBusinesses(result);

    UpdateZips(result);

    $("#salesZoneEdit").dialog("open");

}



function RemoveFromZone(bizId, zoneId, title) {

    var dataToUse = { "id": zoneId, "bizId": bizId };

    ConfirmDialog("Really remove : " + title + " from zone?", "Remove Business From Zone", "sales_zones/removeFromZone",

        "Removing From Zone<br/>This may take a minute", dataToUse, UpdateBusinesses, null);

}



function removeZipFromZone(zip, zoneId, title) {

    var dataToUse = { "id": zoneId, "zipcode": zip };

    ConfirmDialog("Really remove : " + title + " from zone?", "Remove Zip From Zone", "sales_zones/removeZipFromZone",

        "Removing From Zone<br/>This may take a minute", dataToUse, UpdateZips, null);

}



function addBusinessToZone(zoneId) {

    var biz_id = $("#bizToAdd").val();

    var data = { "zone_id": zoneId, "biz_id": biz_id };

    PageMethod("sales_zones/addBusinessToZone", "Adding Business To Zone", data, UpdateBusinesses, null);

}



function addZipToZone(zoneId) {

    var zip_id = $("#zipToAdd").val();

    var data = { "zone_id": zoneId, "zipcode": zip_id };

    PageMethod("sales_zones/addZipToZone", "Adding Zip Code To Zone", data, UpdateZips, null);



}



function UpdateUI(result) {

    $.unblockUI();

    $("#biz_listing").html(result.biz_list);

    $("#zip_listing").html(result.zip_list);
	
	$("#cat_exclude").html(result.category_html);
    setupButtons();



}

function UpdateBusinesses(result) {

    UpdateUI(result); 

}

function UpdateZips(result) {

    UpdateUI(result);

}

function get_category(cat_option)
{
	if(cat_option==2)
	{
		$.post("sales_zones/get_category", '',
			function(data) {
				$("#cat_exclude").html(data);
	    });
	}else{
		$("#cat_exclude").html('');
	}
}
