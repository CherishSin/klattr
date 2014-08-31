// variables
var leftchannel = [];
var rightchannel = [];
var recorder = null;
var recording = false;
var recordingLength = 0;
var volume = null;
var audioInput = null;
var sampleRate = 44100;
var audioContext = null;
var context = null;
var outputElement = document.getElementById('output');
var outputString;
var timer;
var play_timer;
var play_length;
var progwidth;
var recorder;
var Storage = {
  AudioContext: audioContext = window.AudioContext || window.webkitAudioContext
}

function get_mic(){
// feature detection 
  if (!navigator.getUserMedia)
      navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||
                    navigator.mozGetUserMedia || navigator.msGetUserMedia;

  if (navigator.getUserMedia){
      navigator.getUserMedia({audio:true}, success, function(e) {
      alert('Error capturing audio.');
      });
  } else alert('getUserMedia not supported in this browser.');
}

function record(reclength){
  recording = true;
  leftchannel.length = rightchannel.length = 0;
  recordingLength = 0;
//  console.log(reclength)
//  console.log(recording)
  document.getElementById("instructions").style.visibility = 'hidden';
  recorder = setTimeout(function(){
    stop_recording();
    clearInterval(timer);
    document.getElementById("progress").style.backgroundImage = "url('/gfx/Still-progress.gif')";
    make_submit_form();
  }, reclength); 
  progwidth = 0;
  recint = reclength/470;
//  console.log(recint)
  timer = setInterval(function(){
    document.getElementById("progress").style.width = '' + progwidth + 'px';
    progwidth += 1;  
  }, recint)
}

function toggle_recording(){
  if (recording){
    document.getElementById("do_record").className = "stop_button";
    document.getElementById("do_record").style.top = "1px";
    document.getElementById("do_record").setAttribute( "onClick", "javascript: reset_recording();toggle_recording()" )
  } else if (!recording){
    document.getElementById("do_record").className = "rec_button";
    document.getElementById("do_record").setAttribute( "onClick", "javascript: record(19500);toggle_recording()" )
  }
 
}

function stop_recording(){
  recording = false;
//  console.log("stop recording")
}

function reset_recording(){
  if(document.getElementById("progress")){
    document.getElementById("progress").style.width = '0px';
    document.getElementById("progress").style.backgroundImage = "url('/gfx/progress.gif')";
  }
  clearInterval(timer);
  stop_recording();
  clearTimeout(recorder);
  recordingLength = 0;
  leftchannel = [];
  rightchannel = [];
  recorder = null;
  volume = null;
  audioInput = null;
  sampleRate = 44100;
  audioContext = null;
  context = null;
  outputElement = document.getElementById('output');
    navigator.getUserMedia({audio:true}, success, function(e) {
    alert('Error capturing audio.');
    });

}

function save_recording(){
  var interleaved = mergeBuffers ( leftchannel, recordingLength );
//  var rightBuffer = mergeBuffers ( rightchannel, recordingLength );
//  var interleaved = interleave ( leftBuffer, rightBuffer );

  var buffer = new ArrayBuffer(44 + interleaved.length * 2);
  var view = new DataView(buffer);

  writeUTFBytes(view, 0, 'RIFF');
  view.setUint32(4, 36 + interleaved.length * 2, true);
  writeUTFBytes(view, 8, 'WAVE');
  writeUTFBytes(view, 12, 'fmt ');
  view.setUint32(16, 16, true);
  view.setUint16(20, 1, true);
  view.setUint16(22, 1, true);
  view.setUint32(24, sampleRate, true);
  view.setUint32(28, sampleRate * 2, true);
  view.setUint16(32, 2, true);
  view.setUint16(34, 16, true);
  writeUTFBytes(view, 36, 'data');
  view.setUint32(40, interleaved.length * 2, true);

// write PCM samples

  var lng = interleaved.length;
  var index = 44;
  var volume = 1;
  for (var i = 0; i < lng; i++){
    view.setInt16(index, interleaved[i] * (0x7FFF * volume), true);
    index += 2;
  }
  var blob = new Blob ( [ view ], { type : 'audio/wav' } );
  //blob = "blobby blobby blobby"
  send_klattr_form(blob);
  //download_file(blob)
}

function download_file(blob){
  var url = (window.URL || window.webkitURL).createObjectURL(blob);
  var link = window.document.createElement('a');
  link.href = url;
  link.download = 'output.wav';
  var click = document.createEvent("Event");
  click.initEvent("click", true, true);
  link.dispatchEvent(click);
}


function interleave(leftChannel, rightChannel){
  var length = leftChannel.length + rightChannel.length;
  var result = new Float32Array(length);

  var inputIndex = 0;

  for (var index = 0; index < length; ){
    result[index++] = leftChannel[inputIndex];
    result[index++] = rightChannel[inputIndex];
    inputIndex++;
  }
  return result;
}

function mergeBuffers(channelBuffer, recordingLength){
  var result = new Float32Array(recordingLength);
  var offset = 0;
  var lng = channelBuffer.length;
  for (var i = 0; i < lng; i++){
    var buffer = channelBuffer[i];
    result.set(buffer, offset);
    offset += buffer.length;
  }
  return result;
}

function writeUTFBytes(view, offset, string){ 
  var lng = string.length;
  for (var i = 0; i < lng; i++){
    view.setUint8(offset + i, string.charCodeAt(i));
  }
}

function success(e){
    // creates the audio context
    var audioContext = Storage.AudioContext;
    
    if (!Storage.AudioContextConstructor)
      Storage.AudioContextConstructor = new audioContext();

    context = Storage.AudioContextConstructor;

    // creates a gain node
    if (!Storage.VolumeGainNode)
      Storage.VolumeGainNode = context.createGain();

    volume = Storage.VolumeGainNode;

    // creates an audio node from the microphone incoming stream
    if (!Storage.AudioInput)
      Storage.AudioInput = context.createMediaStreamSource(e);

    audioInput = Storage.AudioInput;

    // connect the stream to the gain node
    audioInput.connect(volume);

    /* From the spec: This value controls how frequently the audioprocess event is 
    dispatched and how many sample-frames need to be processed each call. 
    Lower values for buffer size will result in a lower (better) latency. 
    Higher values will be necessary to avoid audio breakup and glitches */
    var bufferSize = 4096;
    //recorder = context.createJavaScriptNode(bufferSize, 2, 2);
    recorder = context.createScriptProcessor(bufferSize, 1, 1);
    
    recorder.onaudioprocess = function(e){
        if (!recording) return;
        var left = e.inputBuffer.getChannelData (0);
//        var right = e.inputBuffer.getChannelData (1);
        // we clone the samples
        leftchannel.push (new Float32Array (left));
//        rightchannel.push (new Float32Array (right));
        recordingLength += bufferSize;
    }

    // we connect the recorder
    volume.connect (recorder);
    recorder.connect (context.destination); 
}

function play_klattr(klattr) {
  stop_all_klattrs();

  var song = document.getElementById(klattr);
  var progress_element = "progress_" + klattr;
  var button_element = "button_" + klattr;
  
  document.getElementById(button_element).className = "stop_button";
//  document.getElementById(button_element).style.left = '30px';
//  document.getElementById(button_element).style.float = 'right';
//  document.getElementById(button_element).style.top = '1px';
  document.getElementById(button_element).setAttribute( "onClick", "javascript: stop_playing('" + klattr + "')" );

  song.play();
  play_length = setTimeout(function(){
    clearInterval(play_timer);
    document.getElementById(progress_element).style.backgroundImage = "url('/gfx/Still-progress.gif')";
    stop_playing(klattr);
  }, 19500);
  var progresswidth = 0;
  var playint = 19500/300;
  play_timer = setInterval(function(){
    document.getElementById(progress_element).style.width = '' + progresswidth + 'px';
    progresswidth += 1;
  }, playint)
}

function stop_playing(klattr) {
  var progress_element = "progress_" + klattr;
  var button_element = "button_" + klattr;

  document.getElementById(button_element).className = "play_button";
  document.getElementById(button_element).setAttribute( "onClick", "javascript: play_klattr('" + klattr + "')" );


  kaudio = document.getElementById(klattr);
  kaudio.pause();
  kaudio.currentTime = 0;
  kaudio.load();
  document.getElementById(progress_element).style.width = "0px";
  clearInterval(play_timer);
  clearTimeout(play_length);

}

function stop_all_klattrs() {
  var button_element;
  var audios = document.getElementsByTagName('audio'),
        i = audios.length;
  while(i--) {
    button_element = "button_" + audios[i].id;
    document.getElementById(button_element).className = "play_button";
    document.getElementById(button_element).setAttribute( "onClick", "javascript: play_klattr('" + audios[i].id + "')" );

    audios[i].pause();
    //audios[i].src = audios[i].src;
    audios[i].currentTime = 0;
    if (audios[i].currentTime != 0)
      audios[i].load();
//console.log(audios[i].currentTime)
  }


  var players = document.getElementsByClassName('play_progress'),
        i = players.length;
  while(i--) {
    players[i].style.width = "0px";
    clearInterval(play_timer);
    clearTimeout(play_length);
  }
}
