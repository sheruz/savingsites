function saveAd() {
	
	var ad_startdatetime = Date.parse($("#ad_startdatetime").val());
	var ad_stopdatetime = Date.parse($("#ad_stopdatetime").val());
	
	if(ad_startdatetime==null || ad_stopdatetime==null)
	{
		alert('please insert start date and stop date');
		return false;
	}
	
	if(ad_startdatetime.compareTo(ad_stopdatetime)>=0)
	{
		alert('please insert start date small than stop date');
		return false;
	}
	
    var dataToUse = {
        "id":$("#ad_id").val(),
        "name":$("#ad_name").val(),
        "ad_stopdatetime":$("#ad_stopdatetime").val(),
        "ad_startdatetime":$("#ad_startdatetime").val(),
        //"starttime":$("#ad_starttime").val(),
        //"stoptime":$("#ad_stoptime").val(),
        "business_id":$("#ad_business").val(),
        "adtext":nicEditors.findEditor('ad_text').getContent(),
        "category_id": $("#ad_category").val(),
        "active" : "1",
        "text_message": $("#text_message").val(),
		
		/* + Athena eSolutions */		
		"rebate": $("#rebate").val(),
		"istipavailable": $("#istipavailable").val(),
		"price": $("#price").val(),
		/* - Athena eSolutions */
    };
	/*alert($("#price").val()); */
    PageMethod("ads/save", "Saving Ad<br/>This may take a minute.", dataToUse, adsSaveSuccessful, null);
	/*PageMethod("ads/save_new", "Saving Ad<br/>This may take a minute.", dataToUse, adsSaveSuccessful, null);*/
    $("#adsEdit").dialog("close");
}

function adsSaveSuccessful(result) {
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
    $("#adsEdit").dialog({ autoOpen: false, width: 500, title: "Ad Edit", show: "blind", hide: "explode",
        buttons: { "Save": function () {
			//alert(2); //return false;
			
            saveAd();
            //$(this).dialog("close");
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
    new nicEditor({ fullPanel: true }).panelInstance('ad_text');
    setupUI();
    $( "#ad_startdatetime, #ad_stopdatetime" ).datetimepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat:'yy-mm-dd'
	});
});

function newAd() { //alert(1); 
    $("#ad_id").val("-1");
    $("#ad_name").val("");
    //$("#ad_starttime").val("12:00 am");
    //$("#ad_stoptime").val("11:59 pm");
    $("#ad_startdatetime").val('');
    $("#ad_stopdatetime").val('');
    $("#ad_business").val("0");
    nicEditors.findEditor('ad_text').setContent("");
    $("#text_message").val("");
    $("#ad_category").val("0");
    $("#adsEdit").dialog("open");
}

function EditAd(id) { //alert(id); 
    PageMethod("ads/get/" + id, "", null, ShowAdEdit, null);
}
function DeleteAd(id, title) {
    ConfirmDialog("Really delete : " + title, "Delete Ad", "ads/delete", "Deleting Ad<br/>This may take a minute",
        { "id":id}, null, null);
}
function ShowAdEdit(result) { 
    $.unblockUI();
    $("#ad_id").val(result.id);
    $("#ad_name").val(result.name);
    //$("#ad_starttime").val(result.starttime);
    //$("#ad_stoptime").val(result.stoptime);
    $("#ad_startdatetime").val(result.startdatetime);
    $("#ad_stopdatetime").val(result.stopdatetime);
    $("#ad_business").val(result.business_id);
    $("#ad_category").val(result.category_id);
    nicEditors.findEditor('ad_text').setContent(result.adtext);
    $("#text_message").val(result.text_message);
    $("#adsEdit").dialog("open");
	
	/*  + Athena eSolutions */
	$("#rebate").val(result.rebate);
	$("#istipavailable").val(result.istipavailable);
	$("#price").val(result.price);
	/*  - Athena eSolutions */
}