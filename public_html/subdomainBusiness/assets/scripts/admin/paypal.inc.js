function paypalconfig(){
    var dataToUse = {
        "id" : $("#hidden_id").val(),
        "paypal_url" : $("#paypal_url").val(),
        "business_email" : $("#business_email").val()
    };
    
    PageMethod("paypal/save_paypal_config", "Saving paypal configuration<br/>This may take a minute.", dataToUse, business_typeSaveSuccessful,null);

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




