<?php 
  if($twilioaudiofle != ''){
    $audiourltwilio = 'https://savingssites.com/assets/SavingsUpload/Twilio/'.$zone_id.'/'.$zone_id.'.mp3';
    $hide = '';
  }else{
    $hide = 'hide';
    $audiourltwilio = '';
  }

?>
<div class="page-wrapper main-area toggled viewdeals everydayfoodspecial">
   <div class="container">
    <div class="row" style=" margin-bottom: 80px;">
      <div class="top-title">
        <h2>Twilio Account Setting</h2>
          <hr class="center-diamond">
      </div>
      <div class="row">
        <div class="col-md-4">
          
         
         
         
          <div class="row">
            <div class="col-md-12" style="padding:0;">
              <select class="form-control" id="twiliofileselect">
                <option value="">Select Audio Method</option>
                <option value="audio">Record Audio File</option>
                <option value="audioupload">Upload Audio File</option>
              </select>
            </div>
          </div> 
          <div class="row hide" id="newrecorddiv">
            <div class="col-md-12" style="background: #fff;border-radius: 10px;margin: 25px 0px;padding: 20px;">
              <div id="msg">Recording...</div>
              <p style="text-align: center;"><span id="minutes">00</span>:<span id="seconds">00</span>:<span id="tens">00</span></p>
              <div id="new_record">
                <div style="background:#fff;height: 100px;">
                  <button class="btnwidth" id="record"><img src="https://cdn.savingssites.com/play.png">Start</button>
                  <button class="btnwidth hide" id="stop" disabled><img src="https://cdn.savingssites.com/stop.png">Stop</button>
                  <button class="btnwidth hide" day="monday" audiourl="" id="save" disabled><img src="https://cdn.savingssites.com/save.png">Save</button>
                  <!-- <button class="btnwidth" id="reset2">Reset</button> -->
                  <button class="btnwidth hide"><a id="download" disabled><img src="https://cdn.savingssites.com/download.png">Download</a></button>
                </div>
                <div style="text-align: center;" class="hide">
                  <audio id="audio" controls></audio>
                </div>
              </div>
            </div>
        </div>
        <div class="row hide" id="newuploaddiv">
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
        <div class="row <?= $hide; ?>" id="alreadyuploadedfile">
          <audio id="existsaudio2" src="<?= $audiourltwilio; ?>" controls></audio> 
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
        <form class="form-horizontal1 cus-paypal">
          <div class="form-group center-block-table text_area_to_save_code">
            <p class="form-group-row">
              <label for="comment" class="fleft w_200">Twilio SSID:</label>
              <input type="hidden"  id="twilioeditid" value="<?= $twiliodbid; ?>"/>
              <input type="text" id="twiliossid" name="twiliossid" class="w_536" value="<?= $twiliossid;?>"/>
            </p>
          </div>
          
          <div class="form-group center-block-table  ">
            <p class="form-group-row">
              <label for="comment" class="fleft w_200">Twilio Auth Token:</label>
              <input type="text" id="twilioauthtoken" name="twilioauthtoken" class="w_536" value="<?= $twilioauthtoken; ?>" placeholder="Please Provide your Twilio Auth Token">
            </p>
          </div>
          
          <div class="form-group center-block-table  ">
            <p class="form-group-row">
              <label for="comment" class="fleft w_200">Twilio Number:</label>
              <input type="text" id="twiliono" name="twiliono" class="w_536" value="<?= $twiliophoneno; ?>" placeholder="Please Provide your Twilio Number with Country Code eg(+1)">
            </p>
          </div>
          
          <div class="form-group center-block-table  ">
            <p class="form-group-row">
              <label for="comment" class="fleft w_200">Twilio Account Status:</label>
              <input type="text" id="twilioAccountStatus" name="twilioAccountStatus" class="w_536" value="<?= $twiliodbactive; ?>" disabled>
            </p>
          </div>
          
          <div class=" col-md-12">
          <?php if($twiliodbid == ''){
            echo '<button type="button" id="submit_twilio_button" class="btn btn-success">Save</button>';
            }else{
            echo '<button type="button" id="submit_twilio_button" class="btn btn-success">Update</button>';
            } 
          ?>
            
          </div>
        </form>
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
      $(document).on('click','#upload',function(){
        var form_data = new FormData();                  
        var audiourl = $('#upload').attr('audiourl');  
        var audio_file_data = $('#audio_file').prop('files')[0];  
        if(audio_file_data == undefined && audiourl == undefined){
          savingalert('warning','Please Select Atleast one file type');
          return false; 
        }
        var zoneid = $('#zone_id').val();
        form_data.append('via', 'twilio');
        form_data.append('zoneid', zoneid);
        form_data.append('audiourl', audiourl);
        form_data.append('audio_file', audio_file_data);
        var baseurl = 'https://savingssites.com/assets/SavingsUpload/Twilio/'+zoneid+'/';
       
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
              savingalert(d.type,d.msg);  
              document.querySelector('#audio').setAttribute('src', ''); 
              $('#newuploaddiv').addClass('hide');
              $('#newrecorddiv').addClass('hide');
              $('#alreadyuploadedfile').removeClass('hide');
              var url = baseurl+'/'+zoneid+'.mp3';
              $('#existsaudio2').attr('src', url);
              $('#audio_file').val('');
            }          
          });
        
      });
    });
  
    (async () => {
      let leftchannel = [];
      let rightchannel = [];
      let context = null;
      let stream = null;
      let tested = false;
      var minutes = 00; 
      var seconds = 00; 
      var tens = 00; 
      var appendTens = document.getElementById("tens");
      var appendMinutes = document.getElementById("minutes");
      var appendSeconds = document.getElementById("seconds");
      var Interval ;
      try {
        window.stream = stream = await getStream();
        console.log('Got stream');  
      } catch(err) {
        alert('Issue getting mic', err);
      }  
      
      document.querySelector('#msg').style.visibility = 'hidden'
      
      document.querySelector('#record').onclick = (e) => {
        $('#stop').removeClass('hide');
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
      clearInterval(Interval);
      tens = "00";
      seconds = "00";
      minutes = "00";
      appendTens.innerHTML = tens;
      appendSeconds.innerHTML = seconds;
      appendSeconds.innerHTML = minutes;
      stop();
    }

    
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
    var zoneid = $('#zone_id').val();
    var save = document.getElementById("save");
    console.log('Stop')
    recording = false;
    var filename = zoneid;
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
    document.querySelector('#audio').setAttribute('src', audioUrl);
    const link = document.querySelector('#download');
    link.setAttribute('href', audioUrl);
    save.setAttribute('audiourl', audioUrl);
    link.download = 'output.wav';
    $('#upload').attr('audiourl',filename);
    var fd = new FormData();
    fd.append("audio_data", blob, filename);
    fd.append("zoneid",zoneid);
    
    xhr.open("POST", "/save_twilio_audio", true);
    xhr.send(fd);
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
