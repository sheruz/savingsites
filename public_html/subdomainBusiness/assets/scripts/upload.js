function upload_Image(a,b,c){return form_action=$("#"+c).attr("action"),$("#"+c).get(0).setAttribute("action",b),$("#"+c).attr("target","upload_target"),""==$("#"+a).val()?($("#"+c).get(0).setAttribute("action",form_action),$("#"+c).removeAttr("target"),!1):($.blockUI({message:"Please wait while Uploading..."}),$("#"+c).submit(),!1)}stopUpload=function(a,b,c,d,e){return $.unblockUI(),"upload-success"==a?($("<div>I'm in a dialog</div>").html("Logo Uploaded successfully.").dialog({height:150,width:460,title:"Logo Upload",buttons:{Ok:function(){$(this).dialog("close")}}}),$("#"+d).val(""),$("#"+c).html(b).show()):"docs-upload-success"==a?($("<div>I'm in a dialog</div>").html("File uploaded successfully.").dialog({height:150,width:460,title:"Docs Upload",buttons:{Ok:function(){$(this).dialog("close")}}}),$("#"+d).val(""),$("#"+c).html(b).show()):$("<div>I'm in a dialog</div>").html(a).dialog({height:250,width:460,title:"Logo Upload : Error",buttons:{Ok:function(){$(this).dialog("close")}}}),$("#"+e).get(0).setAttribute("action",form_action),$("#"+e).removeAttr("target"),!1};
 