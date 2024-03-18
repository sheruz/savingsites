function dwolla_facilitator(){
    var dataToUse = {
        "faci_id" : $("#hidden_id").val(),        
		"faci_email" : $("#faci_email").val(),
        "faci_phone" : $("#faci_phone").val(),
		"isupdate" : $("#isupdate").val(),
    };
   
    PageMethod("dwollaconfig/save_dwolla_facilitator_config", "Saving dwolla facilitator configuration<br/>This may take a minute.", dataToUse, business_typeSaveSuccessful,null);

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




