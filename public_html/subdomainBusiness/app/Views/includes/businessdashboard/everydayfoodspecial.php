<div class="page-wrapper main-area toggled viewdeals everydayfoodspecial">
   <div class="container">
    <input type="hidden" id="businessid" name="businessid" value="<?php echo $businessid;?>"/>
    <input type="hidden" id="business_id" name="businessid" value="<?php echo $businessid;?>"/>
    <input type="hidden" id="deal_product_id" name="deal_product_id" value=""/>
    <div class="row" style=" margin-bottom: 80px;">
      <div class="top-title">
        <h2>Create Daily Specials</h2>
          <hr class="center-diamond">
          <p>Everyday Food Special by business are listed below:</p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <br>
          <div class="row">
            <div class="col-md-12" style="padding: 8px 40px;border-bottom: 1px solid #ecb5e9;">
              <div class="row">
                <div class="col-md-6">
                  <input name="weekday" type="checkbox" day="monday" class="weekday"/> Monday <br>
              <input name="weekday" type="checkbox" day="tuesday" class="weekday"/> Tuesday <br>
             <input name="weekday" type="checkbox" day="wednesday" class="weekday"/> Wednesday <br>
               <input name="weekday" type="checkbox" day="thursday" class="weekday"/> Thursday
                </div>
                <div class="col-md-6">
                   <input name="weekday" type="checkbox" day="friday" class="weekday"/> Friday<br>
               <input name="weekday" type="checkbox" day="saturday" class="weekday"/> Saturday<br>
               <input name="weekday" type="checkbox" day="sunday" class="weekday"/> Sunday
                </div>
              </div>
              
              
            </div>
          </div> 
          <br>
          <div class="row" id="uploadpdfrow">
            <div class="col-md-4"><label>Upload PDF File</label></div>
            <div class="col-md-8"><input type="file" name="pdf_file" id="pdf_file" class="pdf_file form-control"/></div>
          </div>
          <div class="row hide" id="showpdfrow">
            <div class="col-md-12">
              <img src="https://cdn.savingssites.com/pdf.png" class="pdf-img">
              <div id="showpdf" class="text-capitalize">
              </div>
            </div>  
          </div>
          <br>
          <div class="row">
            <div class="col-md-12" style="padding:0;">
               Record Audio File <input name="filesaveformat" type="checkbox" recordtype="audio" class="filesaveformat"/>
               Upload Audio File <input name="filesaveformat" type="checkbox" recordtype="audioupload" class="filesaveformat"/>
             
            </div>
          </div> 
          <div class="row hide" id="audiorecorddiv">
            <div class="col-md-12" style="background: #fff;border-radius: 10px;margin: 25px 0px;padding: 20px;">
              <div id="msg">Recording...</div>
              <p style="text-align: center;"><span id="minutes">00</span>:<span id="seconds">00</span>:<span id="tens">00</span></p>
              <div id="new_record">
                <div style="background:#fff;height: 100px;">
                  <button class="btnwidth" id="record"><img src="https://cdn.savingssites.com/play.png">Start</button>
                  <button class="btnwidth hide" id="stop" disabled><img src="https://cdn.savingssites.com/stop.png">Stop</button>
                  <button class="btnwidth hide" day="" audiourl="" id="save" disabled><img src="https://cdn.savingssites.com/save.png">Save</button>
                  <!-- <button class="btnwidth" id="reset2">Reset</button> -->
                  <button class="btnwidth hide"><a id="download" disabled><img src="https://cdn.savingssites.com/download.png">Download</a></button>
                </div>
                <div style="text-align: center;" class="hide">
                  <audio id="audio" controls></audio>
                </div>
              </div>
              <div id="exists_record" class="hide" style="text-align: center;">
                <div style="width: 70%;float: left;">
                  <audio id="recorded_audio" controls></audio>
                </div>
                <div style="width: 30%;float: left;font-size: 25px;margin-top: 10px;">
                  <i class="fa fa-trash deleterecord" aria-hidden="true"></i>
                </div>
              </div>
            </div>
        </div>
        <div class="row hide" id="audiouploaddiv">
          <div class="col-md-12" style="background: #fff;border-radius: 10px;margin: 25px 0px;padding: 20px;height: 185px;">
            <label>Upload Audio File</label>
            <input type="file" name="audio_file" id="audio_file" class="audio_file form-control"/>
          </div>
        </div>
        <br>
        <div class="row hide" id="existsuploaddiv">
          <audio id="existsaudio" controls></audio> 
          <div id="deleteaudiorow"></div> 
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">
            <button class="btn btn-success" id="upload">Upload</button>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Day</th>
              <th>Audio File</th>
              <th>PDF File</th>
              <th>Action</th>
              <!-- <th>Action</th> -->
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Monday</td>
              <td id="recorded_audio_monday">No Special Today</td>
              <td id="recorded_pdf_monday">PDF Not Exists</td>
              <td id="delete_record_monday"></td>
            </tr>
            <tr>
              <td>Tuesday</td>
              <td id="recorded_audio_tuesday">No Special Today</td>
              <td id="recorded_pdf_tuesday">PDF Not Exists</td>
              <td id="delete_record_tuesday"></td>
            </tr>
            <tr>
              <td>Wednesday</td>
              <td id="recorded_audio_wednesday">No Special Today</td>
              <td id="recorded_pdf_wednesday">PDF Not Exists</td>
              <td id="delete_record_wednesday"></td>
            </tr>
            <tr>
              <td>Thursday</td>
              <td id="recorded_audio_thursday">No Special Today</td>
              <td id="recorded_pdf_thursday">PDF Not Exists</td>
              <td id="delete_record_thursday"></td>
            </tr>
            <tr>
              <td>Friday</td>
              <td id="recorded_audio_friday">No Special Today</td>
              <td id="recorded_pdf_friday">PDF Not Exists</td>
              <td id="delete_record_friday"></td>
            </tr>
            <tr>
              <td>Saturday</td>
              <td id="recorded_audio_saturday">No Special Today</td>
              <td id="recorded_pdf_saturday">PDF Not Exists</td>
              <td id="delete_record_saturday"></td>
            </tr>
            <tr>
              <td>Sunday</td>
              <td id="recorded_audio_sunday">No Special Today</td>
              <td id="recorded_pdf_sunday">PDF Not Exists</td>
              <td id="delete_record_sunday"></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="deleteAudiomodal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">     
      <h2><center>Delete Daily Specials Recordings</center></h2>      
      <div class="modal-body">
        <div>
          <select class="form-control" id="modalaudiofiledelete">
            <option>Select File to Delete</option>
            <option value="pdf">Pdf File</option>
            <option value="audio">Audio File</option>
            <option value="pdfaudio">Both Pdf & Audio File </option>
          </select>
          <button class="btn btn-info" id="deletesinglefile">Delete File</button>
        </div>
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript">
    $(document).ready(function(){
      getAllrecording();
      $('#weekday').select2();
      $('#filesaveformat').select2();
      $(document).on('click','.weekday', function(){
        $('.weekday').prop('checked', false);
        $(this).prop('checked', true);
        var day = '';
        $('.weekday').each(function(){
          if($(this).prop('checked') == true){
            day = $(this).attr('day');
          }    
        });
        var business_id = $('#businessid').val();
        var baseurl = window.location.origin+'/assets/SavingsUpload/Audio/'+business_id+'/';
        var pdfurl = window.location.origin+'/assets/SavingsUpload/PDF/'+business_id+'/';
        $('#pdf_file').val('');
        $('#audio_file').val('');
        if(day){
          $.ajax({
            url: "/get_audio_day",
            type: "GET",
            data:  {'day':day,'business_id':business_id},
            dataType:'json',
            beforeSend : function(){
              $("#loading").css('display','block');
            },
            complete: function() {
              $("#loading").css('display','none');
            },
            success: function(d){
              if(d == '' || d == null || d == 'null'){
                $("#uploadpdfrow").removeClass('hide');
                $("#showpdfrow").addClass('hide');
                $('#showpdf').html('');
                savingalert('warning','No record Found');
                $("#audiouploaddiv").addClass('hide');
                $("#audiorecorddiv").addClass('hide');
                $("#existsuploaddiv").addClass('hide');
                $("#existsaudio").attr('src','');
                $('#filesaveformat').html('<option value="">Select Upload File</option><option value="audio">Record Audio File</option><option value="audioupload">Upload Audio File</option');
                $("#existsuploaddiv").find('#deleteaudiorow').html('');
                return false;
              }
              $('#exists_record').addClass('hide');
              $('#new_record').removeClass('hide');
              $('#save').attr('day',day);
              $('#recorded_audio').attr('src','');
              if(d.pdf != ''){
                $("#uploadpdfrow").addClass('hide');
                $("#showpdfrow").removeClass('hide');
                $('#showpdf').html('<a target="_blank" href="'+pdfurl+''+d.pdf+'">'+d.day+' Special</a><i day="'+d.day+'" business_id="'+business_id+'" audio="" pdf="'+d.pdf+'" class="fa fa-trash deleterecord" aria-hidden="true"></i>');
              }else{
                $("#uploadpdfrow").removeClass('hide');
                $("#showpdfrow").addClass('hide');
                $('#showpdf').html('');
              }
              if(d.audio != ''){
                $("#existsuploaddiv").removeClass('hide');
                $("#audiouploaddiv").addClass('hide');
                $("#audiorecorddiv").addClass('hide');
                $("#existsaudio").attr('src',baseurl+d.audio);  
                $("#existsuploaddiv").find('#deleteaudiorow').html('<i day="'+d.day+'" business_id="'+business_id+'" audio="'+d.audio+'" pdf="" class="fa fa-trash deleterecord" aria-hidden="true"></i>');
              }else{
                $("#audiouploaddiv").addClass('hide');
                $("#audiorecorddiv").addClass('hide');
                $("#existsuploaddiv").addClass('hide');
                $("#existsuploaddiv").find('#deleteaudiorow').html('');
                $("#existsaudio").attr('src','');
              }
              if(d.audiotype != '' && d.audio != ''){
                if(d.audiotype == 1){
                  $('#filesaveformat').html('<option value="">Select Upload File</option><option selected value="audio">Record Audio File</option><option value="audioupload">Upload Audio File</option');
                }else{
                  $('#filesaveformat').html('<option value="">Select Upload File</option><option value="audio">Record Audio File</option><option selected value="audioupload">Upload Audio File</option>');
                }
              }
            }          
          });    
        }
        
      });

      $(document).on('change','#business_id', function(){
        var baseurl = window.location.origin;
        var business_id = $(this).val();
        $('#exists_record').addClass('hide');
        $('#new_record').removeClass('hide');
        $('#recorded_audio').attr('src','');
        $('#weekday').val('').trigger('change');
        getAllrecording();
      });

      

      $(document).on('click','.deleterecord', function(){
        var day = $(this).attr('day');
        var business_id = $(this).attr('business_id');
        var audio = $(this).attr('audio');
        var pdf = $(this).attr('pdf');
        var msg = '';
        if(audio != '' && pdf != ''){
          $('#modalaudiofiledelete').attr('day',day);
          $('#modalaudiofiledelete').attr('business_id',business_id);
          $('#modalaudiofiledelete').attr('audio',audio);
          $('#modalaudiofiledelete').attr('pdf',pdf);
          $('#deleteAudiomodal').modal('show');
        }else{
          if(audio != '' && pdf == ''){
            msg = 'Are You Sure to Delete Audio ?';
            var all = 'audio';
            $('#existsuploaddiv').addClass('hide');
            $('#audiouploaddiv').addClass('hide');
            $('#audiorecorddiv').addClass('hide');
            $('#filesaveformat').val('').trigger('change');
          }else if(audio == '' && pdf != ''){
            msg = 'Are You Sure to Delete PDF ?';
            var all = 'pdf';
            $('#uploadpdfrow').removeClass('hide');
            $('#showpdfrow').addClass('hide');
          }
          if (confirm(msg)) {
            deletefile(day,business_id,audio,pdf,all);
          }else{
            $('#uploadpdfrow').addClass('hide');
            $('#showpdfrow').removeClass('hide');
            savingalert('success','Audio Safe...');
          }
        }
      });

      $(document).on('click','#deletesinglefile', function(){
        var day = $('#modalaudiofiledelete').attr('day');
        var business_id = $('#modalaudiofiledelete').attr('business_id');
        var audio = $('#modalaudiofiledelete').attr('audio');
        var pdf = $('#modalaudiofiledelete').attr('pdf'); 
        var fileval = $('#modalaudiofiledelete').val(); 
        deletefile(day,business_id,audio,pdf,fileval);
      });

      $(document).on('click','.filesaveformat', function(){
        $('#stop').addClass('hide');
        $('#audio').addClass('hide');
        $('#download').addClass('hide');
        $('.filesaveformat').prop('checked', false);
        $(this).prop('checked', true);
        var business = $('#business_id').val();
        var day = '';
        var file = $(this).val();
        var file = '';
        if($(this).prop('checked') == true){
          file = $(this).attr('recordtype');
        }

        
        $('.weekday').each(function(){
          if($(this).prop('checked') == true){
            day = $(this).attr('day');
          }  
        });

        if(business == '' || business == undefined || business == 'undefined'){
          savingalert('warning','Please Select Business');
          document.getElementById("business_id").focus();
          $(this).val('').trigger('change.select2');
          return false;
        }
        if(day == '' || day == undefined || day == 'undefined'){
          $('.filesaveformat').prop('checked', false);
          savingalert('warning','Please Select Day');
          document.getElementById("weekday").focus();
          $(this).val('').trigger('change.select2');
          return false;
        }  
        if(file == 'audio'){
          $('#upload').text('Save Recording');
          $('#audiorecorddiv').removeClass('hide');
          $('#audiouploaddiv').addClass('hide');
        }else if(file == 'audioupload'){
          $('#upload').text('Upload');
          $('#audiorecorddiv').addClass('hide');
          $('#audiouploaddiv').removeClass('hide'); 
        }else{
          $('#audiouploaddiv').addClass('hide');
          $('#audiorecorddiv').addClass('hide');
        }  
      });
      
      /*new segment*/
      $(document).on('click','#upload',function(){
        var form_data = new FormData(); 
        var day = '';                 
        $('.weekday').each(function(){
          if($(this).prop('checked') == true){
            day = $(this).attr('day');
          }  
        });
        var business_id = $('#business_id').val();
        var audiourl = $('#save').attr('audiourl');
        var file_data = $('#pdf_file').prop('files')[0];  
        var audio_file_data = $('#audio_file').prop('files')[0];  
        
        if(audio_file_data == undefined){audio_file_data = '';}
        form_data.append("day",day);
        form_data.append("business_id", business_id);                    
        form_data.append('pdf_file', file_data);
        form_data.append('audiourl', audiourl);
        form_data.append('audio_file', audio_file_data);
        
        if(day){
          $.ajax({
            url: "/saveaudiomultiple",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            dataType:'json',
            beforeSend : function(){
              $("#loading").css('display','block');
            },
            complete: function() {
              $("#loading").css('display','none');
            },
            success: function(d){

              $('#recorded_audio_'+day).html('');
              $('.filesaveformat').prop('checked',false);
              $('.weekday').prop('checked',false);
              $('#audiorecorddiv').addClass('hide');
              $('#audiouploaddiv').addClass('hide');
              $('#existsuploaddiv').addClass('hide');
              $('#showpdfrow').addClass('hide');
              $('#uploadpdfrow').removeClass('hide');
              $(d).each(function(k,v){
                savingalert(v.type,v.msg);  
              });
              document.querySelector('#audio').setAttribute('src', ''); 
              getAllrecording();
              if(d.length > 0){
                // location.reload();
                // setTimeout(getAllrecording, 5000);
              } 
            }          
          });
        }else{
          savingalert('warning','Please Select Day First'); 
        }
      });
     /*new segment*/
      $(document).on('change','#pdf_file', function(){
        var file_data = $('#pdf_file').prop('files')[0];
        $('#save').attr('audiourl','');
        $('#upload').text('Upload');
        if (file_data.type != 'application/pdf') {
          savingalert('warning','Only Pdf File Allowed');
          $('#pdf_file').val('');
          return false;
        }
      });
    });

    function deletefile(day = '',business_id = '',audio = '',pdf = '',all = ''){
      if(all == 'Select File to Delete'){
        savingalert('warning','Please Select File');
        return false;
      }
      $.ajax({
        url: "/delete_audio_day",
        type: "POST",
        data:  {'day':day,'business_id':business_id,'audio':audio,'pdf':pdf,'all':all},
        dataType:'json',
        beforeSend : function(){
          $("#loading").css('display','block');
        },
        complete: function() {
          $("#loading").css('display','none');
        },
        success: function(d){
          savingalert(d.type,d.msg);
          $('#deleteAudiomodal').modal('hide');
          // document.querySelector('#audio').setAttribute('src', '');
          // $('#weekday').val('').trigger('change');
          // $('#exists_record').addClass('hide');
          // $('#new_record').removeClass('hide');

          getAllrecording();
        }          
      });  
    }

    function resetday(){
      $('#recorded_audio_monday').html('No Special Today');
      $('#recorded_audio_tuesday').html('No Special Today');
      $('#recorded_audio_wednesday').html('No Special Today');
      $('#recorded_audio_thursday').html('No Special Today');
      $('#recorded_audio_friday').html('No Special Today');
      $('#recorded_audio_saturday').html('No Special Today');
      $('#recorded_audio_sunday').html('No Special Today');
      $('#recorded_pdf_monday').html('PDF Not Exists');
      $('#recorded_pdf_tuesday').html('PDF Not Exists');
      $('#recorded_pdf_wednesday').html('PDF Not Exists');
      $('#recorded_pdf_thursday').html('PDF Not Exists');
      $('#recorded_pdf_friday').html('PDF Not Exists');
      $('#recorded_pdf_saturday').html('PDF Not Exists');
      $('#recorded_pdf_sunday').html('PDF Not Exists');
      $('#delete_record_monday').html('');
      $('#delete_record_tuesday').html('');
      $('#delete_record_wednesday').html('');
      $('#delete_record_thursday').html('');
      $('#delete_record_friday').html('');
      $('#delete_record_saturday').html('');
      $('#delete_record_sunday').html('');

    }

    function filedata(){
      $('#audio_file').val('');
      $('#pdf_file').val('');
      $('#weekday').val('').trigger('change.select2');
      $('#filesaveformat').val('').trigger('change.select2');
      $('#audiouploaddiv').addClass('hide');
      $('#audiorecorddiv').addClass('hide');
    }
    function getAllrecording(bus_id = 0){
      var business_id = $('#business_id').val();
      if(business_id == ''){
        business_id = bus_id;
      }
      var url = baseurl+'/assets/SavingsUpload/Audio/'+business_id+'/';
      var pdfurl = baseurl+'/assets/SavingsUpload/PDF/'+business_id+'/';
      resetday();
      $.ajax({
        url: "/get_all_audio",
        type: "GET",
        data:  {'business_id':business_id},
        dataType:'json',
        beforeSend : function(){
              $("#loading").css('display','block');
            },
            complete: function() {
              $("#loading").css('display','none');
            },
        success: function(d){
          if(d.length > 0){
            $(d).each(function(k,v){
              if(v.day == 'monday'){
                if(v.audio){
                  $('#recorded_audio_monday').html('<audio id="recorded_audio" src="'+url+''+v.audio+'" controls></audio>');
                }
                if(v.pdf != ''){
                  $('#recorded_pdf_monday').html('<a target="_blank" href="'+pdfurl+''+v.pdf+'">Monday Special</a>');
                }
                if(v.audio || v.pdf){
                  $('#delete_record_monday').html('<i day="'+v.day+'" business_id="'+business_id+'" audio="'+v.audio+'" pdf="'+v.pdf+'" class="fa fa-trash deleterecord" aria-hidden="true"></i>');
                }
              }
              if(v.day == 'tuesday'){
                if(v.audio){
                  $('#recorded_audio_tuesday').html('<audio id="recorded_audio" src="'+url+''+v.audio+'" controls></audio>');
                }
                if(v.pdf != ''){
                  $('#recorded_pdf_tuesday').html('<a target="_blank" href="'+pdfurl+''+v.pdf+'">Tuesday Special</a>');
                }
                if(v.audio || v.pdf){
                  $('#delete_record_tuesday').html('<i day="'+v.day+'" business_id="'+business_id+'" audio="'+v.audio+'" pdf="'+v.pdf+'" class="fa fa-trash deleterecord" aria-hidden="true"></i>');
                }
              }
              if(v.day == 'wednesday'){
                if(v.audio){
                  $('#recorded_audio_wednesday').html('<audio id="recorded_audio" src="'+url+''+v.audio+'" controls></audio>');
                }
                if(v.pdf != ''){
                  $('#recorded_pdf_wednesday').html('<a target="_blank" href="'+pdfurl+''+v.pdf+'">Wednesday Special</a>');
                }
                if(v.audio || v.pdf){
                  $('#delete_record_wednesday').html('<i day="'+v.day+'" business_id="'+business_id+'" audio="'+v.audio+'" pdf="'+v.pdf+'" class="fa fa-trash deleterecord" aria-hidden="true"></i>');
                }
              }
              if(v.day == 'thursday'){
                if(v.audio){
                  $('#recorded_audio_thursday').html('<audio id="recorded_audio" src="'+url+''+v.audio+'" controls></audio>');
                }
                if(v.pdf != ''){
                  $('#recorded_pdf_thursday').html('<a target="_blank" href="'+pdfurl+''+v.pdf+'">Thursday Special</a>');
                }
                if(v.audio || v.pdf){
                  $('#delete_record_thursday').html('<i day="'+v.day+'" business_id="'+business_id+'" audio="'+v.audio+'" pdf="'+v.pdf+'" class="fa fa-trash deleterecord" aria-hidden="true"></i>');
                }
              }
              if(v.day == 'friday'){
                if(v.audio){
                  $('#recorded_audio_friday').html('<audio id="recorded_audio" src="'+url+''+v.audio+'" controls></audio>');
                }
                if(v.pdf != ''){
                  $('#recorded_pdf_friday').html('<a target="_blank" href="'+pdfurl+''+v.pdf+'">Friday Special</a>');
                }
                if(v.audio || v.pdf){
                  $('#delete_record_friday').html('<i day="'+v.day+'" business_id="'+business_id+'" audio="'+v.audio+'" pdf="'+v.pdf+'" class="fa fa-trash deleterecord" aria-hidden="true"></i>');
                }
              }
              if(v.day == 'saturday'){
                if(v.audio){
                  $('#recorded_audio_saturday').html('<audio id="recorded_audio" src="'+url+''+v.audio+'" controls></audio>');
                }
                if(v.pdf != ''){
                  $('#recorded_pdf_saturday').html('<a target="_blank" href="'+pdfurl+''+v.pdf+'">Saturday Special</a>');
                }
                if(v.audio || v.pdf){
                  $('#delete_record_saturday').html('<i day="'+v.day+'" business_id="'+business_id+'" audio="'+v.audio+'" pdf="'+v.pdf+'" class="fa fa-trash deleterecord" aria-hidden="true"></i>');
                }
              }
              if(v.day == 'sunday'){
                if(v.audio){
                  $('#recorded_audio_sunday').html('<audio id="recorded_audio" src="'+url+''+v.audio+'" controls></audio>');
                }
                if(v.pdf != ''){
                  $('#recorded_pdf_sunday').html('<a target="_blank" href="'+pdfurl+''+v.pdf+'">Sunday Special</a>');
                }
                if(v.audio || v.pdf){
                  $('#delete_record_sunday').html('<i day="'+v.day+'" business_id="'+business_id+'" audio="'+v.audio+'" pdf="'+v.pdf+'" class="fa fa-trash deleterecord" aria-hidden="true"></i>');
                }
              }
            });
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





  (async () => {
    let leftchannel = [];
    let rightchannel = [];
    let context = null;
    let stream = null;
    let tested = false;
    var minutes = 00; 
    var seconds = 00; 
    var tens = 00; 
    var appendTens = document.getElementById("tens")
    var appendMinutes = document.getElementById("minutes")
    var appendSeconds = document.getElementById("seconds")
    var Interval ;
    
    try {
      window.stream = stream = await getStream();
      console.log('Got stream');  
    } catch(err) {
      alert('Issue getting mic', err);
    }  
    
    document.querySelector('#msg').style.visibility = 'hidden'
    
    document.querySelector('#record').onclick = (e) => {
      var business = document.getElementById("business_id").value;
      var day = '';
      var filesaveformat = '';

      $('.weekday').each(function(){
        if($(this).prop('checked') == true){
          day = $(this).attr('day');
        }  
      });

      $('.filesaveformat').each(function(){
        if($(this).prop('checked') == true){
          filesaveformat = $(this).attr('recordtype');
        }  
      });
      
      
      
      $('#stop').removeClass('hide');
      if(business == '' || business == undefined || business == 'undefined'){
        savingalert('warning','Please Select Business');
        document.getElementById("business_id").focus();
        return false;
      }
      if(day == '' || day == undefined || day == 'undefined'){
        savingalert('warning','Please Select Day');
        document.getElementById("weekday").focus();
        return false;
      }
      if(filesaveformat == '' || filesaveformat == undefined || filesaveformat == 'undefined'){
        savingalert('warning','Please Select File Type');
        document.getElementById("filesaveformat").focus();
        return false;
      }
      
      $("#stop").prop('disabled', false);
      $("#save").prop('disabled', false);
      $("#download").prop('disabled', false);
      console.log('Start recording')
      clearInterval(Interval);
      Interval = setInterval(startTimer, 10);
      start();
    }
    
    document.querySelector('#stop').onclick = (e) => {
      $("#download").closest('button').removeClass('hide');
      $('#audio').closest('div').removeClass('hide');
      $('#audio').removeClass('hide');
      $('#download').removeClass('hide');
      clearInterval(Interval);
      tens = "00";
      seconds = "00";
      minutes = "00";
      appendTens.innerHTML = tens;
      appendSeconds.innerHTML = seconds;
      appendSeconds.innerHTML = minutes;
      stop();
    }

    // document.querySelector('#reset2').onclick = (e) => {
    //   e.preventDefault();
    //   clearInterval(Interval);
    //   tens = "00";
    //   seconds = "00";
    //   minutes = "00";
    //   appendTens.innerHTML = tens;
    //   appendSeconds.innerHTML = seconds;
    //   appendSeconds.innerHTML = minutes;
    //   reset();
    // }

    function start() {
      recording = true;
      document.querySelector('#msg').style.visibility = 'visible'
      leftchannel.length = rightchannel.length = 0;
      recordingLength = 0;
      if (!context) setUpRecording();
    }

    function setUpRecording() {
      context = new AudioContext();
      sampleRate = context.sampleRate;
      volume = context.createGain();
      audioInput = context.createMediaStreamSource(stream);
      analyser = context.createAnalyser();
      audioInput.connect(analyser);
      
      let bufferSize = 2048;
      let recorder = context.createScriptProcessor(bufferSize, 2, 2);
          analyser.connect(recorder);
          recorder.connect(context.destination); 
          recorder.onaudioprocess = function(e) {
      if (!recording) return;
      console.log('recording');
      let left = e.inputBuffer.getChannelData(0);
      let right = e.inputBuffer.getChannelData(1);
      if (!tested) {
        tested = true;
        // if this reduces to 0 we are not getting any sound
        if ( !left.reduce((a, b) => a + b) ) {
          alert("There seems to be an issue with your Mic");
          // clean up;
          stop();
          stream.getTracks().forEach(function(track) {
            track.stop();
          });
          context.close();
        }
      }
      // we clone the samples
      leftchannel.push(new Float32Array(left));
      rightchannel.push(new Float32Array(right));
      recordingLength += bufferSize;
    };
  }

  function getStream(constraints) {
    if (!constraints) {
      constraints = { audio: true, video: false };
    }
    return navigator.mediaDevices.getUserMedia(constraints);
  }

  function stop() {
    var day = '';
    $('.weekday').each(function(){
      if($(this).prop('checked') == true){
        day = $(this).attr('day');
      }  
    });
    var business_id = $('#business_id').val();
    var save = document.getElementById("save");
    console.log('Stop')
    recording = false;
    var filename = day+'_'+business_id;
    var xhr = new XMLHttpRequest();
    document.querySelector('#msg').style.visibility = 'hidden'
    
    let leftBuffer = mergeBuffers ( leftchannel, recordingLength );
    let rightBuffer = mergeBuffers ( rightchannel, recordingLength );
    let interleaved = interleave ( leftBuffer, rightBuffer );
    let buffer = new ArrayBuffer(44 + interleaved.length * 2);
    let view = new DataView(buffer);
    
    writeUTFBytes(view, 0, 'RIFF');
    view.setUint32(4, 44 + interleaved.length * 2, true);
    writeUTFBytes(view, 8, 'WAVE');
    writeUTFBytes(view, 12, 'fmt ');
    view.setUint32(16, 16, true);
    view.setUint16(20, 1, true);
    view.setUint16(22, 2, true);
    view.setUint32(24, sampleRate, true);
    view.setUint32(28, sampleRate * 4, true);
    view.setUint16(32, 4, true);
    view.setUint16(34, 16, true);
    writeUTFBytes(view, 36, 'data');
    view.setUint32(40, interleaved.length * 2, true);
    
    let lng = interleaved.length;
    let index = 44;
    let volume = 1;
    for (let i = 10; i < lng; i++){
      view.setInt16(index, interleaved[i] * (0x7FFF * volume), true);
      index += 2;
    }

    const blob = new Blob ( [ view ], { type : 'audio/wav'});
    const audioUrl = URL.createObjectURL(blob);
    console.log('BLOB ', blob);
    console.log('URL ', audioUrl);
    document.querySelector('#audio').setAttribute('src', audioUrl);
    const link = document.querySelector('#download');
    link.setAttribute('href', audioUrl);
    save.setAttribute('audiourl', audioUrl);
    link.download = 'output.wav';
    $('#save').attr('audiourl',filename);
    var fd = new FormData();
    fd.append("audio_data", blob, filename);
    fd.append("day",day);
    fd.append("business_id", business_id);
    xhr.open("POST", "/save_record_audio", true);
    xhr.send(fd);
    setTimeout(getAllrecording, 5000);
  }

  function reset() {
    console.log('reset');
    document.querySelector('#msg').style.visibility = 'hidden'
    document.querySelector('#audio').setAttribute('src', '');
    const link = document.querySelector('#download');
    link.setAttribute('href', '');
    return false;
  }

  function mergeBuffers(channelBuffer, recordingLength) {
    let result = new Float32Array(recordingLength);
    let offset = 0;
    let lng = channelBuffer.length;
    for (let i = 0; i < lng; i++){
      let buffer = channelBuffer[i];
      result.set(buffer, offset);
      offset += buffer.length;
    }
    return result;
  }

  function interleave(leftChannel, rightChannel){
    let length = leftChannel.length + rightChannel.length;
    let result = new Float32Array(length);
    let inputIndex = 0;
    
    for (let index = 0; index < length; ){
      result[index++] = leftChannel[inputIndex];
      result[index++] = rightChannel[inputIndex];
      inputIndex++;
    }
    return result;
  }
  
  function writeUTFBytes(view, offset, string){ 
    let lng = string.length;
    for (let i = 0; i < lng; i++){
      view.setUint8(offset + i, string.charCodeAt(i));
    }
  }

  function startTimer () {
      tens++; 
      if(tens <= 9){
          appendTens.innerHTML = "0" + tens;
      }
      if (tens > 9){
          appendTens.innerHTML = tens;
        } 
      if (tens > 99) {
          console.log("seconds");
          seconds++;
          appendSeconds.innerHTML = "0" + seconds;
          tens = 0;
          appendTens.innerHTML = "0" + 0;
      }
      if (seconds > 9){
          appendSeconds.innerHTML = seconds;
      }
      
      if (seconds > 99) {
          console.log("minutes");
          minutes++;
          appendMinutes.innerHTML = "0" + minutes;
          seconds = 0;
          appendSeconds.innerHTML = "0" + 0;
      }
      if (minutes > 9){
          appendMinutes.innerHTML = minutes;
      }
    }

  })()
  </script>
