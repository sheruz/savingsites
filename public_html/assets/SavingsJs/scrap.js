$(document).ready(function(){
	$("#loading").hide();
	$('.zone_login_data').DataTable();
  $('#zone_deals_data').DataTable();
  $('#project_data').DataTable();
  $('#zonelistscrap').select2();
  $('#scrapcategory').select2();
  $('#scrapsubcategory').select2();
  $('#inscat').select2();
  ajaxcall();
  ajaxcallCategory();
  ajaxcallCategorysubcategory();
  emailajaxcall();
	$(document).on('click','#checkuserpassscrap', function(){
	 	var username = $('#scrapusername').val(); 
	 	var password = $('#scrappassword').val();
	 	if(username == '' && password == ''){
	 		savingalert('warning','Please Fill Required Fields');
	 		return false;
	 	}
	 	$.ajax({
        	type:"POST",
            url:'/checkuserpassscrap',
            data:{'username': username,'password':password},
            dataType:'json',
            beforeSend:function(){
            	$("#loading").removeClass('hide');
            },
            complete: function() {
        		$("#loading").addClass('hide');
      		},
            success: function (res) {
              if(res.type == 'success'){
              	window.location.href = "/welcome";
              }else{
              	savingalert(res.type,res.msg);
	 							return false;
              }  
            }
        });
	});

	$(document).on('click','#savedata',function(){
    var username = $(".username").val();
    var firstname = $(".firstname").val();
    var lastname = $(".lastname").val();
    var address = $(".address").val();
    var email = $(".email").val();
    var phone = $(".phone").val();
    var city = $(".city").val();
    var zonename = $(".zonename").val();
    var dealpage = $(".zonesubdomaindealname").val();
    var zonepage = $(".zonesubdomainname").val();
    var zip = $(".zip").val();
    if(username == '' || firstname == '' || lastname == '' || address == '' || email == '' || phone == '' || city == '' || zonename == '' || zip == ''){
    	savingalert('warning','Please Select All Fields.');
	 		return false;
    }
    $.ajax({
      type: 'POST',
      url: '/create_zone_users',
      dataType: 'json',
      data: {'username':username,'fname':firstname,'lname':lastname,'address':address,'email': email,'phone': phone,'zonename': zonename,'city': city,'zip':zip,'dealpage':dealpage,'zonepage':zonepage},
      beforeSend:function(){
      	$("#loading").removeClass('hide');
      },
      complete: function() {
       	$("#loading").addClass('hide');
      },
      success: function(d) {
      	if(d.type == 'warning'){
      		savingalert(d.type,d.msg);	
      	}else{
      		var zipdata = d.data.zipArr;
      		if(zipdata != ''){
      			$('#zonedetaildiv').addClass('hide');
      			$('#headertitle').html('Zip Exists Detail');
      			$('#genusername').val(d.data.username)
      			$('.existszip').val(d.data.zipArr)
      			$('#genusername').attr('existsuserId',d.data.userId);
      			$('#genusername').attr('existszoneId',d.data.zoneid);
      			$('#genusername').attr('zoneuser',d.data.username);
      			$('#genusername').attr('zonepass',d.data.password);
      			$('#zipexistsdiv').removeClass('hide');
						$('#zoneresultmodal').modal('show');
      		}else{
      			$("#zonename").text('Zone Id : '+d.data.zoneid);
      			$("#zoneuser").text('Username : '+d.data.username);
      			$("#zonepass").text('Password : '+d.data.password);
      			$('#headertitle').html('Zone Detail');
      			$('#zonedetaildiv').removeClass('hide');
      			$('#zipexistsdiv').addClass('hide');
						$('#zoneresultmodal').modal('show');
						zipformreset();
      		}
      	}
      }
    });
  });

  $(document).on('change','#zonelistscrap',function(){
    var zone = $(this).val();
    window.location.href = "/scrap/deals?zoneid="+zone+"";
  });

  $('.closeprev').click(function(){
    $('#imagepreview').css('display','none'); 
    $('#imagepreview').addClass('fade'); 
  });
  
  $("#image").change(function () {
    imagePreview(this);
  });

  $("#scrapcatimage").change(function () {
    imagePreviewscrap(this);
  });
  
  $('.closeupdate').click(function(){
    $('#snapPop9').css('display','none'); 
    $('#snapPop9').addClass('fade'); 
  });

  $('.closeupdate').click(function(){
    $('#snapPop9catsub').css('display','none'); 
    $('#snapPop9catsub').addClass('fade'); 
    $('#emailhistorymodal').css('display','none'); 
    $('#emailhistorymodal').addClass('fade'); 
  });

  $(document).on('click','#saveImage', function(){
      var catid = $('#inscat option:selected').val();
      var image = $('#insimage').val();
      if(catid == '' || catid == undefined){
        savingalert('warning','Please Select Category.');
        return false;
      }
      if(image == '' || image == undefined){
        savingalert('warning','Please Select Image.');
        return false;
      }
      var fd = new FormData();
      var totalfiles = document.getElementById('insimage').files.length;
      for (var index = 0; index < totalfiles; index++) {
        fd.append("image[]", document.getElementById('insimage').files[index]);
      }
      fd.append('insertImage',1);
      fd.append('category',catid);
      $.ajax({ 
        type:'POST',
        url :"/insertscrapimage",
        data: fd,
        contentType: false,
        processData: false,
        dataType:'json',
        beforeSend: function() {
          $('.loader-wrapperdiv').removeClass('hide');
        },
        complete: function() {
          $('.loader-wrapperdiv').addClass('hide');
        },
        success: function(r) {
          $('#inscat').val('');
          $('#insimage').val('');
          savingalert('success',r.msg);
          var table = $('#example').DataTable();
          table.destroy();
          ajaxcall();
        }
      });
    });
    
  $(document).on('click', '.catsave', function(){
    var newcat = $('#imagecategory').val();
    if(newcat == ''){
      savingalert('warning','Please enter Category');
      return false;
    }
    if(!isNaN(newcat)){
      savingalert('warning','Only Caracter Allowed');
      return false;
    }
    var type = 'newcatadd';
    $.ajax({ 
      type:'POST',
      url :"/insertupdatecategory",
      data:  {'newcat':newcat,'type':type},
      dataType:'json',
      success: function(r) {
        savingalert('success',r.msg);
        $('#imagecategory').val('');
        var table = $('#categorytable').DataTable();
        table.destroy();
        ajaxcallCategory();
      }
    })
  });

  $(document).on('click','.updatecategory', function(){
    var catname = $('#updateimagecategory').val();
    var catid = $('#updateimagecategory').attr('catid');
    var type = 'updatecatadd';
    if(catname == ''){
      savingalert('warning','Please enter Category');
      return false;
    }
    if(!isNaN(catname)){
      savingalert('warning','Only Caracter Allowed');
      return false;
    }
    $.ajax({ 
      type:'POST',
      url :"/insertupdatecategory",
      data:  {'catname':catname,'catid':catid,'type':type},
      dataType:'json',
      success: function(r) {
        savingalert('success',r.msg);
        $('#updateimagecategory').val('');
        $('#updateimagecategory').attr('catid','');
        $('#snapPop9').addClass('fade');
        $('#snapPop9').css('display', 'none');
        var table = $('#categorytable').DataTable();
        table.destroy();
      }
    }) 
  })

  $(document).on('click','.updateImagcategory',function(){
    var id = $(this).attr('rowid');
    var name = $(this).attr('rowname');
    $('#updateimagecategory').val(name);
    $('#updateimagecategory').attr('catid', id);
    $('#preview').addClass('hide');
    $('#snapPop9category').removeClass('fade');
    $('#snapPop9category').css('display', 'block');
  });

  $(document).on('click','#reassign', function(){
  	var existszip = $('.existszip').val();
    var existsuserId = $('#genusername').attr('existsuserId');
    var existszoneId = $('#genusername').attr('existszoneId');
    var zoneuser = $('#genusername').attr('zoneuser');
    var zonepass = $('#genusername').attr('zonepass');
    $.ajax({
    	type:"POST",
      url:'/reassignzip',
      data:{'existszip': existszip,'existsuserId':existsuserId,'existszoneId':existszoneId},
      dataType:'json',
      beforeSend:function(){
      	$("#loading").removeClass('hide');
      },
      complete: function() {
       	$("#loading").addClass('hide');
     	},
      success: function (res) {
      	if(res.type == 'success'){
					savingalert('success','Zip Re-assign to User Successfully.');
					$("#zonename").text('Zone Id : '+existszoneId);
      		$("#zoneuser").text('Username : '+zoneuser);
      		$("#zonepass").text('Password : '+zonepass);
      		$('#headertitle').html('Zone Detail');
      		$('#zonedetaildiv').removeClass('hide');
      		$('#zipexistsdiv').addClass('hide');
					$('#zoneresultmodal').modal('show');
					zipformreset();
      	}
      }
    });
  });

  $('#updateImage').click(function(){
    var catid = $('#updatecategory option:selected').val();
    var imageID = $('#imageID').val();
    var image = $('#image').val();
    if(catid == '' || catid == undefined){
      savingalert('warning','Please Select Category');
      return false;
    }
    var fd = new FormData();
    var totalfiles = document.getElementById('image').files.length;
    for (var index = 0; index < totalfiles; index++) {
      fd.append("image[]", document.getElementById('image').files[index]);
    }
    fd.append('updateImage',1);
    fd.append('category',catid);
    fd.append('imageID',imageID);
    $.ajax({ 
      type:'POST',
      url :"/scrapImageUpdate",
      data: fd,
      contentType: false,
      processData: false,
      dataType:'json',
      beforeSend: function() {
        $('.loader-wrapperdiv').removeClass('hide');
      },
      complete: function() {
        $('.loader-wrapperdiv').addClass('hide');
      },
      success: function(r) {
        $('#updatecategory').val('');
        $('#image').val('');
        $('#image').val('');
        $('#snapPop9').css('display','none'); 
        $('#snapPop9').addClass('fade');
        savingalert('success',r.msg);
        var table = $('#example').DataTable();
        table.destroy();
        ajaxcall();
      }
    });
  });
});

$(document).on('click','#addeditemail',function(){
  $('#emailhistorymodal').removeClass('fade');
  $('#emailhistorymodal').css('display', 'block');
});

$(document).on('click','.saveemaildata',function(){
  var emailtype = $('#emailcategory').val();
  var email = $('#email').val();
  var emaildetail = $('#emaildetail').val();
  var editid = $('#emailid').val();
  if(emailtype == '' || emailtype == undefined){
    savingalert('warning','Please Select Email Category.');
    return false;
  }
  if(email == '' || email == undefined){
    savingalert('warning','Please Enter Email Address.');
    return false;
  }
  if(emaildetail == '' || emaildetail == undefined){
    savingalert('warning','Please Enter Email text.');
    return false;
  }
  $.ajax({ 
      type:'POST',
      url :"/setemailhistory",
      data: {'editid':editid,'emailtype':emailtype,'email':email,'emaildetail':emaildetail},
      dataType:'json',
      beforeSend: function() {
        $("#loading").removeClass('hide');
      },
      complete: function() {
        $("#loading").addClass('hide');
      },
      success: function(r) {
        savingalert(r.type,r.msg);
        $('#emailhistorymodal').addClass('fade');
        $('#emailhistorymodal').css('display', 'none');
        $('#emailcategory').val('');
        $('#email').val('');
        $('#emaildetail').val('');
        emailajaxcall();
      }
    })
});

$(document).on('change','#scrapcategory',function(){
  var html = '';
  var cat = $(this).val();
  var child_type = $('#scrapcategory').find(":selected").attr('child_type');
  if(cat){
    $.ajax({ 
      type:'GET',
      url :"/getscrapsubcategory",
      data: {'cat':cat,'child_type':child_type},
      dataType:'json',
      beforeSend: function() {
        $("#loading").removeClass('hide');
      },
      complete: function() {
        $("#loading").addClass('hide');
      },
      success: function(r) {
        html += '<option value>Select Sub Category</option>';
        $.each(r, function(key,v) {
          html += '<option value="'+v.id+'">'+v.name+'</option>';
        });
        $('#scrapsubcategory').html(html);
      }
    })
  }
});



$(document).on('click','#savescrapcategoryimage', function(){
  var cat = $('#scrapcategory option:selected').val();
  var subcat = $('#scrapsubcategory option:selected').val();
  var image = $('#scrapcatimage').val();
  if(cat == '' || cat == undefined){
    savingalert('warning','Please Select Category.');
    return false;
  }
  if(subcat == '' || subcat == undefined){
    savingalert('warning','Please Select Sub Category.');
    return false;
  }
  if(image == '' || image == undefined){
    savingalert('warning','Please Select Image.');
    return false;
  }
  var fd = new FormData();
  var totalfiles = document.getElementById('scrapcatimage').files.length;
  for (var index = 0; index < totalfiles; index++) {
    fd.append("image[]", document.getElementById('scrapcatimage').files[index]);
  }
  fd.append('category',cat);
  fd.append('subcategory',subcat);
  insertscrapimagecatsubcat(fd);
});

$('#updatecatsubImage').click(function(){
  var cat = $('#scrapcategoryinput').val();
  var subcat = $('#scrapsubcategoryinput').val();
  var image = $('#scrapcatimage').val();
  if(cat == '' || cat == undefined){
    savingalert('warning','Please Select Category.');
    return false;
  }
  if(subcat == '' || subcat == undefined){
    savingalert('warning','Please Select Sub Category.');
    return false;
  }
  if(image == '' || image == undefined){
    savingalert('warning','Please Select Image.');
    return false;
  }
  var fd = new FormData();
  var totalfiles = document.getElementById('scrapcatimage').files.length;
  for (var index = 0; index < totalfiles; index++) {
    fd.append("image[]", document.getElementById('scrapcatimage').files[index]);
  }
  fd.append('category',cat);
  fd.append('subcategory',subcat);
  insertscrapimagecatsubcat(fd);
  });

$(document).on('click','#savemacrocsv', function(){
  var zipcsv = $('#zipcsv').val();
  var ypcsv = $('#ypcsv').val();
  var dbcsv = $('#dbcsv').val();
  if(zipcsv == '' || zipcsv == undefined){
    savingalert('warning','Please Select Zip Code File.');
    return false;
  }
  if(ypcsv == '' || ypcsv == undefined){
    savingalert('warning','Please Select YP CSV File.');
    return false;
  }
  if(dbcsv == '' || dbcsv == undefined){
    savingalert('warning','Please Select DB CSV File.');
    return false;
  }
  var zipres = uploaddataonebyone('zipcsv');
  console.log(zipres);
  console.log("Sdcsdcsdc");
  if(zipres == 1){
    var ypres = uploaddataonebyone('ypcsv');
    if(ypres == 1){
      var dbres = uploaddataonebyone('dbcsv');
      if(dbres == 1){
        $('#macrocsvnonfood').removeClass('hide');
        $('#savemacrocsv').addClass('hide');
        $('#zipcsv').val('');
        $('#ypcsv').val('');
        $('#dbcsv').val('');
        savingalert('success','File Uploaded Successfully');
      }
    }
  }
});


$(document).on('click','#saveawsImage', function(){
  $.ajax({
    url: "/insertscrapawsimage",
    type: "POST",
    dataType:'json',
    beforeSend: function() {$('.loader-wrapperdiv').removeClass('hide');},
    complete: function() {$('.loader-wrapperdiv').addClass('hide');},
    success: function(d){
      settransactiondata(d.data,d.count,0,2);
    }          
  });
});


var totalinsert = 0;
function settransactiondata(data, count, start,end){
  var dataArr = data.slice(start, end);
  $.ajax({
    url: '/insertscrapawsimageinsert',
    type: "POST",
    data:{'dataArr':dataArr},
    dataType:'json',
    success: function(d){
      if(d.insert == 1){
        totalinsert = parseInt(totalinsert)+parseInt(d.insertedtotal);
        var startnew = parseInt(start)+2;
        var endnew = parseInt(startnew)+2;
        if(totalinsert < count){
          var per = parseInt(totalinsert)/parseInt(count)*100;
          per = Math.round(per);
          settransactiondata(data, count, startnew,endnew); 
        }else{
          $('.w3-light-grey').addClass('hide');
          $('#actiontext').addClass('hide');
          $('#mapUpload').prop('disabled', false);
          $('.w3-green').css('width','0%');
          $('#percount').html('0%');
        }
      }
    }
  });
}
















function uploaddataonebyone(id){
  var res = 0;
  var file_data = $('#'+id).prop('files')[0];
  var fd = new FormData();
  fd.append(''+id+'', file_data);
  $.ajax({ 
    type:'POST',
    url :"/insertscrapmacrocsv",
    data: fd,
    contentType: false,
    processData: false,
    async:false,
    dataType:'json',
    beforeSend: function() {$('.loader-wrapperdiv').removeClass('hide');},
    complete: function() {$('.loader-wrapperdiv').addClass('hide');},
    success: function(r) {
      res = 1;
    }
  });
  return res;
}

$(document).on('click','#savemacrofoodcsv', function(){
  var ziptxt = $('#ziptxt').val();
  var freshcsv = $('#freshcsv').val();
  var ypcsv = $('#ypcsv').val();
  var dbcsv = $('#dbcsv').val();
  if(ziptxt == '' || ziptxt == undefined){
    savingalert('warning','Please Select Zip Code txt File.');
    return false;
  }
  if(freshcsv == '' || freshcsv == undefined){
    savingalert('warning','Please Select Fresh CSV File.');
    return false;
  }
  if(ypcsv == '' || ypcsv == undefined){
    savingalert('warning','Please Select YP CSV File.');
    return false;
  }
  if(dbcsv == '' || dbcsv == undefined){
    savingalert('warning','Please Select DB CSV File.');
    return false;
  }
  var ziptxt = uploaddataonebyonefood('ziptxt');
  if(ziptxt == 1){
    var freshres = uploaddataonebyonefood('freshcsv');
    if(freshres == 1){
      var ypres = uploaddataonebyonefood('ypcsv');
      if(ypres == 1){
        var dbres = uploaddataonebyonefood('dbcsv');  
        if(dbres == 1){
          $('#macrocsvfood').removeClass('hide');
          $('#savemacrofoodcsv').addClass('hide');
          $('#ziptxt').val('');
          $('#freshcsv').val('');
          $('#ypcsv').val('');
          $('#dbcsv').val('');
          savingalert('success','File Uploaded Successfully');
        }
      } 
    }
  }
});

function uploaddataonebyonefood(id){
  var res = 0;
  var file_data = $('#'+id).prop('files')[0];
  var fd = new FormData();
  fd.append(''+id+'', file_data);
  $.ajax({ 
    type:'POST',
    url :"/insertscrapmacrofoodcsv",
    data: fd,
    contentType: false,
    processData: false,
    async:false,
    dataType:'json',
    beforeSend: function() {$('.loader-wrapperdiv').removeClass('hide');},
    complete: function() {$('.loader-wrapperdiv').addClass('hide');},
    success: function(r) {
      res = 1;
    }
  });
  return res;
}

function insertscrapimagecatsubcat(fd){
  $.ajax({ 
    type:'POST',
    url :"/insertscrapimagecatsubcat",
    data: fd,
    contentType: false,
    processData: false,
    dataType:'json',
    beforeSend: function() {
      $("#loading").removeClass('hide');
    },
    complete: function() {
      $("#loading").addClass('hide');
    },
    success: function(r) {
      // $('#scrapcategory').val('').trigger('change.select2');
      // $('#scrapsubcategory').val('').trigger('change.select2');
      $('#scrapcatimage').val('');
      savingalert('success',r.msg);
      $('#snapPop9catsub').css('display','none'); 
      $('#snapPop9catsub').addClass('fade');
      var table = $('#scrapimagetable').DataTable();
      table.destroy();
      ajaxcallCategorysubcategory();
    }
  }); 
}

function ajaxcallCategory(){
  var html = '';
  $.ajax({ 
    type:'GET',
    url :"/fetchcategory",
    dataType:'json',
    success: function(r) {
      $.each(r, function(key,v) {
        html += '<tr>';
        html += '<td>'+v.id+'</td>';
        html += '<td>'+v.foodCategoryName+'</td>';
        html += '<td width="10%"><i rowid="'+v.id+'" rowname="'+v.foodCategoryName+'" class="fa-solid fa-pen-to-square font updateImagcategory"></i></td>';
        html += '</tr>';
      });
      $('#categorydata').html(html); 
      datatablecategory(); 
    }
  })
}

function ajaxcallCategorysubcategory(){
  var html = '';
  var $this = $(this);
  $.ajax({ 
    type:'GET',
    url :"/fetchscrapcatsubimage",
    dataType:'json',
    success: function(r) {
      $.each(r, function(key,v) {
        if(v.subimage != ''){
          var deldiv = `<i onclick="catsubtrashdata(`+v.subsubcatid+`)" class="fa-solid fa-trash font trashdata"></i>`;
        }else{
          var deldiv = '';
        }
        html += `<tr type="catsubcat">`;
        html += `<td width="10%">`+v.subsubcatid+`</td>`;
        html += `<td width="30%">`+v.subimage+`</td>`;
        html += `<td width="20%">`+v.catname+`</td>`;
        html += `<td width="20%">`+v.subsubcatname+`</td>`;
        html += `<td width="10%">`+deldiv+` <i rowid=`+v.subsubcatid+` onclick="updatecatsubImage(`+v.subsubcatid+`,`+v.catid+`)" class="fa-solid fa-pen-to-square font updateImage"></i></td>`;
        html += `</tr>`;
      });
      $('#imagecatsubcatediv').html(html); 
      datatablecatsubcateimage(); 
    }
  })
}

function datatablecatsubcateimage(){
  $('#scrapimagetable').DataTable({
    "dom": '<"dt-buttons"Bf><"clear">lirtp',
    "paging": true,
    "autoWidth": true,
    "buttons": [
      'colvis',
      'copyHtml5',
      'csvHtml5',
      'excelHtml5',
      'pdfHtml5',
      'print'
    ]
  });
}

function datatablecategory(){
  $('#categorytable').DataTable({
    "dom": '<"dt-buttons"Bf><"clear">lirtp',
    "paging": true,
    "autoWidth": true,
    "buttons": [
      'colvis',
      'copyHtml5',
      'csvHtml5',
      'excelHtml5',
      'pdfHtml5',
      'print'
    ]
  });
}

function trashdata(id){
  var $this = $(this);  
  if (confirm('Are You Sure To Delete')) {
    $.ajax({ 
      type:'POST',
      url :"/scrapdelimage",
      data:  {'delid': id,'type':type},
      dataType:'json',
      beforeSend: function() {
        $('.loader-wrapperdiv').removeClass('hide');
      },
      complete: function() {
        $('.loader-wrapperdiv').addClass('hide');
      },
      success: function(r) {
        if(r == 1){
          $this.closest('tr').remove();
            var table = $('#example').DataTable();
            table.destroy();
            ajaxcall();
        }
      }
    }); 
  }else{
    savingalert('success','Image Safe');
  }
}

function emailtrashdata(id){
  var $this = $(this);  
  if (confirm('Are You Sure To Delete')) {
    $.ajax({ 
      type:'POST',
      url :"/delemail",
      data:  {'delid': id},
      dataType:'json',
      beforeSend: function() {
        $('.loader-wrapperdiv').removeClass('hide');
      },
      complete: function() {
        $('.loader-wrapperdiv').addClass('hide');
      },
      success: function(r) {
        savingalert(r.type,r.msg);
        $this.closest('tr').remove();
        var table = $('#emailexample').DataTable();
        table.destroy();
        emailajaxcall();
      }
    }); 
  }else{
    savingalert('success','Image Safe');
  }
}

function catsubtrashdata(id){
  var $this = $(this);  
  if (confirm('Are You Sure To Delete')) {
    $.ajax({ 
      type:'POST',
      url :"/scrapdelimage",
      data:  {'delid': id,'type':'catsubcat'},
      dataType:'json',
      beforeSend: function() {
        $('.loader-wrapperdiv').removeClass('hide');
      },
      complete: function() {
        $('.loader-wrapperdiv').addClass('hide');
      },
      success: function(r) {
        if(r == 1){
          $this.closest('tr').remove();
          var table = $('#scrapimagetable').DataTable();
          table.destroy();
          ajaxcallCategorysubcategory();
        }
      }
    }); 
  }else{
    savingalert('success','Image Safe');
  }
}

function imagePreview(fileInput) {
  $("#updateprev").addClass('hide');
  $("#preview").removeClass('hide');
  if(fileInput.files && fileInput.files[0]) {
    var fileReader = new FileReader();
    fileReader.onload = function (event) {
      $('#preview').html('<img style="width:100%;height:250px;" src="'+event.target.result+'"/>');
    };
    fileReader.readAsDataURL(fileInput.files[0]);
  }
}

function imagePreviewscrap(fileInput) {
  $("#updateprevcatsub").addClass('hide');
  $("#previewscrap").removeClass('hide');
  if(fileInput.files && fileInput.files[0]) {
    var fileReader = new FileReader();
    fileReader.onload = function (event) {
      $('#previewscrap').html('<img style="width:100%;height:250px;" src="'+event.target.result+'"/>');
    };
    fileReader.readAsDataURL(fileInput.files[0]);
  }
}

function updateImage(id){
  $('#preview').addClass('hide');
  $.ajax({ 
    type:'POST',
    url :"/scrapupdateimage",
    data:  {'updateid': id},
    dataType:'json',
    beforeSend: function() {
      $('.loader-wrapperdiv').removeClass('hide');
    },
    complete: function() {
      $('.loader-wrapperdiv').addClass('hide');
    },
    success: function(r) {
      selectcategoryajaxcall(r.category);
      $("#updateprev").attr('src','https://savingssites.com/assets/CommonImages/'+r.image+'');
      $('#snapPop9').removeClass('fade');
      $('#snapPop9').css('display', 'block');
      $('#imageID').val(r.id);
    }
  })
}

function updateemail(id){
  $.ajax({ 
    type:'GET',
    url :"/getemailhistory",
    data:  {'id': id},
    dataType:'json',
    beforeSend: function() {
      $('.loader-wrapperdiv').removeClass('hide');
    },
    complete: function() {
      $('.loader-wrapperdiv').addClass('hide');
    },
    success: function(r) {
      $('#emailcategory').val(r[0].category).trigger('change');
      $('#email').val(r[0].email);
      $('#emaildetail').val(r[0].emailtext);
      $('#emailid').val(r[0].id);
      $('#emailhistorymodal').removeClass('fade');
      $('#emailhistorymodal').css('display', 'block');
    }
  })
}

function updatecatsubImage(id,catid){
  $('#preview').addClass('hide');
  $("#scrapcategoryinput").val(catid);
  $("#scrapsubcategoryinput").val(id);
  var base_url = window.location.origin;
  $.ajax({ 
    type:'POST',
    url :"/scrapupdateimage",
    data:  {'updateid': id,'type':'catsubcat'},
    dataType:'json',
    beforeSend: function() {
      $('.loader-wrapperdiv').removeClass('hide');
    },
    complete: function() {
      $('.loader-wrapperdiv').addClass('hide');
    },
    success: function(r) {
      console.log(r);
      // selectcategoryajaxcall(r.category);
      $("#updateprevcatsub").attr('src',base_url+'/subdomainBusiness/assets/CommonImages/CategorySubcategory/demo/'+r.attachment_image+'');
      $('#snapPop9catsub').removeClass('fade');
      $('#snapPop9catsub').css('display', 'block');
      $('#scrapcatimage').val(r.id);
    }
  })
}

function selectcategoryajaxcall(id){
  var html = '';
  var selected ="";
  $.ajax({ 
    type:'POST',
    url :"/scrapcategory",
    dataType:'json',
    success: function(r) {
      $.each(r, function(key,v) {
        if(id == v.id){
          var selected ="selected";
        }
        html += '<option '+selected+' value="'+v.id+'">'+v.foodCategoryName+'</option>' 
      });
      $('#updatecategory').html(html); 
    }
  })
}

function ajaxcall(){
  var html = '';
  var base_url = window.location.origin;
  $.ajax({ 
    type:'GET',
    url :"/uploadimagefunction",
    dataType:'json',
    success: function(r) {
      $.each(r, function(key,v) {
        html += '<tr>';
        html += '<td width="10%">'+v.id+'</td>';
        html += '<td width="30%"><img onclick="imagepreview1($(this))" class="imageSize" src="'+base_url+'/assets/CommonImages/'+v.image+'"/></td>';
        html += '<td width="20%">'+v.catname+'</td>';
        html += '<td width="10%"><i onclick="trashdata('+v.id+')" class="fa-solid fa-trash font trashdata"></i> <i rowid='+v.id+' onclick="updateImage('+v.id+')" class="fa-solid fa-pen-to-square font updateImage"></i></td>';
        html += '</tr>';
      });
      $('#imagediv').html(html); 
      datatable(); 
    }
  })
}

function emailajaxcall(){
  var html = '';
  var base_url = window.location.origin;
  $.ajax({ 
    type:'GET',
    url :"/getemailhistory",
    dataType:'json',
    success: function(r) {
      $.each(r, function(key,v) {
        html += '<tr>';
        html += '<td width="10%">'+v.id+'</td>';
        html += '<td width="30%">'+v.category+'</td>';
        html += '<td width="20%">'+v.email+'</td>';
        html += '<td width="10%">'+v.emailtext+'</td>';
        html += '<td width="10%"><i onclick="emailtrashdata('+v.id+')" class="fa-solid fa-trash font trashdata"></i> <i rowid='+v.id+' onclick="updateemail('+v.id+')" class="fa-solid fa-pen-to-square font updateImage"></i></td>';
        html += '</tr>';
      });
      $('#emaildiv').html(html); 
      datatable(); 
    }
  })
}

function imagepreview1($this){
  var src = $this.attr('src');
  $("#previmg").attr('src',src);
  $('#imagepreview').removeClass('fade');
  $('#imagepreview').css('display', 'block');
}

function datatable(){
  $('#example').DataTable(
    {
      "dom": '<"dt-buttons"Bf><"clear">lirtp',
      "paging": true,
      "autoWidth": true,
      "buttons": [
        'colvis',
        'copyHtml5',
        'csvHtml5',
        'excelHtml5',
        'pdfHtml5',
        'print'
      ]
    }
  );
}

function emaildatatable(){
  $('#emailexample').DataTable(
    {
      "dom": '<"dt-buttons"Bf><"clear">lirtp',
      "paging": true,
      "autoWidth": true,
      "buttons": [
        'colvis',
        'copyHtml5',
        'csvHtml5',
        'excelHtml5',
        'pdfHtml5',
        'print'
      ]
    }
  );
}

function zipformreset(){
	$('.firstname').val('');
	$('.lastname').val('');
	$('.phone').val('');
	$('.email').val('');
	$('.city').val('');
	$('.address').val('');
	$('.zonename').val('');
	$('.zip').val('');
}

function savingalert(type = '',msg = ''){
	var msg = '<div class="alert alert-'+type+' alert-dismissible fade show" role="alert"><strong>'+msg+'</strong></button></div>';
	$('#alert_msg').html(msg).css('display','block');
	setTimeout(hidealert, 3000);
}
function hidealert(){
    $('#alert_msg').css('display','none');	
}







            


     