function businessSaveSuccessful(result) {
    $.unblockUI();
    $("#tableHolder").html(result.Tag);
    setupUI();
}

function setupUI() {
    var oTable = $('#tableHolder table').dataTable(
                {
                    "sDom": 't<"admin-footer-container"i>',
                    "iDisplayLength": 10,
                    "bSort": false,
                    "aoColumnDefs":
                    [
                            { "bSearchable": false, "bVisible": false, "aTargets": [0] }
                    ]
                });

      $("#business_dashboardEdit").dialog({ autoOpen: false, width: 1000, title: "Business Dashboard", show:"blind", hide : "explode",
        buttons: { "Send": function () {
        	set_subscriber('');
            $(this).dialog("close");
        },
            "Cancel": function () {
                $(this).dialog("close");
            } 
        }
    });
      
      $("#business_templateEdit").dialog({ autoOpen: false, width: 1000, title: "Business Template", show:"blind", hide : "explode",
          buttons: { "Cancel": function () {
                  $(this).dialog("close");
              } 
          }
      });
      
      $("#business_emailEdit").dialog({ autoOpen: false, width: 560, title: "Compose Mail", show:"blind", hide : "explode",
          buttons: { "Send": function () {
              send_email();
              $(this).dialog("close");
          },
              "Cancel": function () {
                  $(this).dialog("close");
              } 
          }
      });
      
      $("#addtemplateEdit").dialog({ autoOpen: false, width: 560, title: "Add Template", show:"blind", hide : "explode",
          buttons: { "Send": function () {
        	  save_template('1');
              $(this).dialog("close");
          },
          "Save": function () {
              save_template('0');
              $(this).dialog("close");
          },
              "Cancel": function () {
                  $(this).dialog("close");
              } 
          }
      });
      
      $("#historyEdit").dialog({ autoOpen: false, width: 1000, title: "History", show:"blind", hide : "explode",
          buttons: {
              "Cancel": function () {
                  $(this).dialog("close");
              } 
          }
      });
      
      $("#setcategoryEdit").dialog({ autoOpen: false, width: 560, title: "Set Category", show:"blind", hide : "explode",
          buttons: { "Save": function () {
              save_category();
              $(this).dialog("close");
          },
              "Cancel": function () {
                  $(this).dialog("close");
              } 
          }
      });
    
    setupButtons();
}

function save_template(status)
{
	var hidden_temp_id = $("#hidden_temp_id").val();
	var dataToUse = {
			"id":$("#hidden_temp_id").val(),
			"status":status,
	        "bus_id":$("#hidden_bus_id").val(),
	        "template_subject":$("#template_subject").val(),
	        "addtemplate_content":nicEditors.findEditor('addtemplate_content').getContent()
	};
	if(status==1)
	{
		if(hidden_temp_id)
		{
			PageMethod("business_dashboard/save_template_edit", "Saving Template<br/>This may take a minute.", dataToUse, set_subscriber_edit, null);
		}else{
			PageMethod("business_dashboard/save_template", "Saving Template<br/>This may take a minute.", dataToUse, set_subscriber, null);
		}
	}else{
		PageMethod("business_dashboard/save_template", "Saving Template<br/>This may take a minute.", dataToUse, get_template, null);
	}
	
}

function set_subscriber_edit(result)
{
	var hidden_bus_id=result.bus_id;
	var id=result.id;
	if(hidden_bus_id==''){
		var hidden_bus_id=$("#hidden_bus_id").val();
	}else{
		$.unblockUI();
	}
	
	$.post("business_dashboard/set_subscriber/"+hidden_bus_id+"/"+id, '',
			function(data) {
				$("#business_email").html(data);
				setupButtons();
	});
	

	
	$("#business_templateEdit").dialog("destroy");
	$("#business_dashboardEdit").dialog("destroy");
	$("#addtemplateEdit").dialog("destroy");
	$("#historyEdit").dialog("destroy");
	$("#setcategoryEdit").dialog("destroy");
	$("#business_emailEdit").dialog("open");	
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
    $(".emailButton").button({ icons: {
        primary: "ui-icon-email"
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


function Edittemplate(id){
	var dataToUse = {
	        "bus_id":$("#hidden_bus_id").val()
	};
	
    PageMethod("business_dashboard/json_business_type/" + id, "", dataToUse, ShowEdit, null);
}
function ShowEdit(result)
{
	$("#addtemplate").html(result.edit_template);
	setupButtons();
	$.unblockUI();
	setupUI();
	
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$("#business_emailEdit").dialog("destroy");
	$("#business_templateEdit").dialog("destroy");
	$("#business_dashboardEdit").dialog("destroy");
	$("#historyEdit").dialog("destroy");
	$("#setcategoryEdit").dialog("destroy");
	$("#addtemplateEdit").dialog("open");
	
}

function set_subscriber(hidden_bus_id)
{
	if(hidden_bus_id==''){
		var hidden_bus_id=$("#hidden_bus_id").val();
	}else{
		$.unblockUI();
	}
	
	$.post("business_dashboard/set_subscriber/"+hidden_bus_id, '',
			function(data) {
				$("#business_email").html(data);
				setupButtons();
				$.unblockUI();
				setupUI();
	});
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$("#business_templateEdit").dialog("destroy");
	$("#business_dashboardEdit").dialog("destroy");
	$("#addtemplateEdit").dialog("destroy");
	$("#historyEdit").dialog("destroy");
	$("#setcategoryEdit").dialog("destroy");
	$("#business_emailEdit").dialog("open");
	
}

function get_subscriber(bus_id,page)
{
	if(bus_id!=0){
		$.post("business_dashboard/get_subscriber/"+bus_id, {"page":page},
				function(data) {
					$("#business_subscriber").html(data);
					setupButtons();
					$.unblockUI();
					setupUI();
		    });
		
			$( "#dialog:ui-dialog" ).dialog( "destroy" );
		$("#business_emailEdit").dialog("destroy");
		$("#business_templateEdit").dialog("destroy");
		$("#addtemplateEdit").dialog("destroy");
		$("#historyEdit").dialog("destroy");
		$("#setcategoryEdit").dialog("destroy");
		$("#business_dashboardEdit").dialog("open");
		
	}else{
		return true;
	}
}

function get_template(bus_id)
{
	$.post("business_dashboard/get_template/"+bus_id, '',
			function(data) {
				$("#business_template").html(data);
				setupButtons();
				$.unblockUI();
				setupUI();
	});
	
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$("#business_emailEdit").dialog("destroy");
	$("#setcategoryEdit").dialog("destroy");
	$("#business_dashboardEdit").dialog("destroy");
	$("#addtemplateEdit").dialog("destroy");
	$("#historyEdit").dialog("destroy");
	$("#business_templateEdit").dialog("open");
}
function Deletetemplate(id, title,bus_id){
    ConfirmDialog("Really delete : " + title, "Delete Branch", "business_dashboard/delete_template", "Deleting template<br/>This may take a minute",
        { "id": id,"bus_id":bus_id }, get_template, null);
}
function newtemplate()
{
	var hidden_bus_id=$("#hidden_bus_id").val();
	$.post("business_dashboard/newtemplate/"+hidden_bus_id, '',
			function(data) {
				$("#addtemplate").html(data);
				setupButtons();
				$.unblockUI();
				setupUI();
	});
	$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$("#business_emailEdit").dialog("destroy");
	$("#business_templateEdit").dialog("destroy");
	$("#business_dashboardEdit").dialog("destroy");
	$("#setcategoryEdit").dialog("destroy");
	$("#historyEdit").dialog("destroy");
	$("#addtemplateEdit").dialog("open");
}

function send_email()
{
	checkboxes = document.getElementById("check_all").checked;//get main check box
	if(checkboxes)
	{
		check_all=1;
	}else{
		check_all=0;
	}
	
	    var dataToUse = {
	    "resend":$("#resend").val(),
	    "check_all":check_all,
		"bus_id":$("#hidden_bus_id").val(),
		"subscriber":$("#subscriber").val(),
		"template":$("#template").val(),
		"template_subject":$("#template_subject").val(),
		"template_content":nicEditors.findEditor('template_content').getContent()
    };

	PageMethod("business_dashboard/send_email", "Sending Emails<br/>This may take a minute.", dataToUse, businessSaveSuccessful,null);
}
function get_template_content(id)
{
	$.post("business_dashboard/get_template_content/" + id, '',
			function(data) {
					var template = data.split('####');
					$("#template_subject").val(template[0]);
					 nicEditors.findEditor('template_content').setContent(template[1]);
	});
}

function get_history(bus_id)
{
	$.post("business_dashboard/get_history/"+bus_id, '',
			function(data) {
				$("#history").html(data);
				setupButtons();
				$.unblockUI();
				setupUI();
	});
	
	
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$("#business_emailEdit").dialog("destroy");
	$("#addtemplateEdit").dialog("destroy");
	$("#business_templateEdit").dialog("destroy");
	$("#business_dashboardEdit").dialog("destroy");
	$("#setcategoryEdit").dialog("destroy");
	$("#historyEdit").dialog("open");
}

function Deletehostory(id, title,bus_id){
    ConfirmDialog("Really delete : " + title, "Delete History", "business_dashboard/deletehostory", "Deleting History<br/>This may take a minute",
        { "id": id,"bus_id":bus_id }, get_history, null);
}

function resend_email(id){
	
	var hidden_bus_id=$("#hidden_bus_id").val();
	
	$.post("business_dashboard/set_subscriber_resend/"+hidden_bus_id+"/"+id, '',
			function(data) {
				$("#business_email").html(data);
				setupButtons();
				$.unblockUI();
				setupUI();
	});

		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$("#historyEdit").dialog("destroy");
	$("#business_templateEdit").dialog("destroy");
	$("#business_dashboardEdit").dialog("destroy");
	$("#addtemplateEdit").dialog("destroy");
	
	$("#setcategoryEdit").dialog("destroy");
	$("#business_emailEdit").dialog("open");
}


function get_history_content(id)
{
	$.post("business_dashboard/get_history_content/" + id, '',
			function(data) {
					var template = data.split('####');
					
					$("#template_subject").val(template[0]);
					 nicEditors.findEditor('template_content').setContent(template[1]);
	});
}

function set_category(id)
{
	$.post("business_dashboard/set_category/"+id, '',
			function(data) {
				$("#setcategory").html(data);
				setupButtons();
				$.unblockUI();
				setupUI();
	});
	
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	$("#business_emailEdit").dialog("destroy");
	$("#business_templateEdit").dialog("destroy");
	$("#business_dashboardEdit").dialog("destroy");
	$("#addtemplateEdit").dialog("destroy");
	$("#historyEdit").dialog("destroy");
	$("#setcategoryEdit").dialog("open");
}

function save_category()
{
	var dataToUse = {
			"business_category": $("#business_category_select").val(),
			"bus_id":$("#hidden_bus_id").val()
	    };

		PageMethod("business_dashboard/save_category", "saving categories Emails<br/>This may take a minute.", dataToUse, businessSaveSuccessful,null);
}



