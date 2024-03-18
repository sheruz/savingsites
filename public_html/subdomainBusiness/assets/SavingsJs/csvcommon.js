$(document).ready(function(){
    var csvcheck = $('#csvcheck').val();
    var unrestype = $('#unrestype').val();
    if(csvcheck == 1){
        window.location.href = "/csvdownload?unrestype="+unrestype+"";   
    }
	$("#csvForm").on('submit',(function(e) {
		var zone_id = $('#zoneidcsv').val();
		var file = $('#file').val();
        var restype = $('.restype').val();
        if(zone_id == '' || zone_id == undefined || zone_id == 'Select Zone'){
			savingalert('warning','Please Select Zone ID');
			return false;
		}
        if(file == '' || file == undefined){
			savingalert('warning','Please Select File');
			return false;
		}
        var fd = new FormData(this);
        fd.append('zone_id',zone_id);
        fd.append('restype',restype);
    	e.preventDefault();
        $.ajax({
            url: "/csvimportmap",
            type: "POST",
            data:  fd,
            contentType: false,
            cache: false,
            processData:false,
            dataType:'json',
            beforeSend : function(){
            	$('#loading').css('display','block');
            },
            success: function(d){
           		if(d.status == 1){
                    setTimeout(function() {
                       window.location.href = "/import/map";
                    }, 3500);
           		}else{
                    if(d.type == 'warning'){
                        $('#loading').css('display','none');
                        savingalert(d.type,d.msg);
                        location.reload();
                    }
                }
            }          
        });
    }));
    $(document).on('click','#mapUpload', function(){
    	var zone_id = $('#zoneidmap').attr('zone');
    	var mapvalue = [];
        var restype = $('#restype').val();
    	$('.csvcolindex').each(function(){
    		var value = $(this).find('option:selected').val(); 
    		mapvalue.push(value); 
    	});
    	if($('#oldcheck').is(':checked') == true){
			deleteolddata(zone_id,mapvalue);
			return false;
		}else{
			$.ajax({
            	url: "/csvimportcount",
            	type: "POST",
            	data:  {'mapvalue':mapvalue,'zone_id':zone_id,'restype':restype},
           		dataType:'json',
            	beforeSend : function(){
            		$('.w3-light-grey').removeClass('hide');
                    $('.w3-light-grey').css('background','green');
            		$('#actiontext').html('Uploading Business');
            		$('#actiontext').removeClass('hide');	
            		$('#mapUpload').prop('disabled', true);
            	},
            	success: function(d){
            		settransactiondata(d.data,d.count,0,10,zone_id);
            	}          
        	});
		}
    });
});

var totalinsert = 0;
function settransactiondata(data, count, start,end,zone_id){
    var restype = $('#restype').val();
    if(restype == 1){
        var url = '/csvimport';
    }else if(restype == 3){
        var url = '/csvimportorganization';
    }
	var dataArr = data.slice(start, end);
	$.ajax({
        url: url,
        type: "POST",
        data:{'dataArr':dataArr,'zone_id':zone_id},
        dataType:'json',
        success: function(d){
        	if(d.insert == 1){
				totalinsert = parseInt(totalinsert)+parseInt(d.insertedtotal);
        		var startnew = parseInt(start)+10;
        		var endnew = parseInt(startnew)+10;
        		if(totalinsert < count){
        			var per = parseInt(totalinsert)/parseInt(count)*100;
        			per = Math.round(per);
        			$('.w3-green').css('width',per+'%');
        			$('#percount').html(per+' %');
        			settransactiondata(data, count, startnew,endnew,zone_id);	
        		}else{
        			$('.w3-light-grey').addClass('hide');
        			$('#actiontext').addClass('hide');
        			$('#mapUpload').prop('disabled', false);
        			$('.w3-green').css('width','0%');
        			$('#percount').html('0%');
                    if(restype == 3){
                        savingalert('success','Organization Imported Successfully');
                    }else{
                        savingalert('success','Business Imported Successfully');
                    }
        			setTimeout(function() {
                        window.location.href = "/import?csv=1";
                    }, 2500);
        		}
        	}
        }
    });
}

function deleteolddata(zone_id,mapvalue){
	totaldelcount = 0;
	$.ajax({
        url: "/getbusinesscount",
        type: "POST",
        data:  {'zone_id':zone_id},
        dataType:'json',
        beforeSend : function(){
           	$('#deleterow').removeClass('hide');
           	$('#actiontext').html('Delete Business');
           	$('#actiontext').removeClass('hide');
            $('.w3-light-grey').removeClass('hide');
            $('.w3-green').css('background','red');
        },
        success: function(d){
            var ddata = d.data;
            if(ddata.length > 0){
                deletebusinessdata(d.data,d.count,0,10,zone_id,mapvalue);
            }else{
                savingalert('warning','Business not available. Business Uploading Start');
                uploading_start(mapvalue,zone_id);
            }
       	}          
   	});
   	
}

function uploading_start(mapvalue,zone_id){
    $.ajax({
        url: "/csvimportcount",
        type: "POST",
        data:{'mapvalue':mapvalue,'zone_id':zone_id},
        dataType:'json',
        beforeSend : function(){
            $('.w3-light-grey').removeClass('hide');
            $('#actiontext').html('Uploading Business');
            $('#actiontext').removeClass('hide');   
            $('#mapUpload').prop('disabled', true);
        },
        success: function(d){
            settransactiondata(d.data,d.count,0,10,zone_id);
        }          
    });   
}

var totaldelcount = 0;
function deletebusinessdata(data, count, start,end,zone_id,mapvalue){
	var dataArr = data.slice(start,end);
	$.ajax({
        url: "/delbusinessdata",
        type: "POST",
        data:{'dataArr':dataArr,'zone_id':zone_id},
        dataType:'json',
        success: function(d){
        	if(d.deleted == 1){
				totaldelcount = parseInt(totaldelcount)+parseInt(d.deletedtotal);
        		var startnew = parseInt(start)+10;
        		var endnew = parseInt(startnew)+10;
        		console.log(totaldelcount);
        		console.log(count);
        		if(totaldelcount < count){
        			var per = parseInt(totaldelcount)/parseInt(count)*100;
        			per = Math.round(per);
        			$('.w3-green').css('width',per+'%');
        			$('#percount').html(per+' %');
        			deletebusinessdata(data, count, startnew,endnew,zone_id,mapvalue);	
        		}else{
        			$('.w3-light-grey').addClass('hide');
        			$('.w3-green').css('width','0%');
        			$('#percount').html('0%');
        			savingalert('success','Business Deleted Successfully');
        			uploading_start(mapvalue,zone_id);
        		}
        	}
        }
    });
}

function savingalert(type = '',msg = ''){
	var msg = '<div class="alert alert-'+type+' alert-dismissible fade show" role="alert"><strong>'+msg+'</strong></button></div>';
	$('#alert_msg').html(msg).css('display','block');
	setTimeout(hidealert, 3000);
}
function hidealert(){
    $('#alert_msg').css('display','none');	
}