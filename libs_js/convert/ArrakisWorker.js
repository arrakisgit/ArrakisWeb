importScripts('/ArrakisWeb_Lib/libs_js/convert/build/ffmpeg-all-codecs.js');

function print(text) {
  postMessage({
    'type' : 'stdout',
    'data' : text
  });
}

onmessage = function(event) {
  var module = {
    files: event.data.files || [],
    arguments: event.data.arguments || [],
    print: print,
    printErr: print
  };
  postMessage({
    'type' : 'start',
    'data' : module.arguments
  });
  console.log(module);
  var result = ffmpeg_run(module);
  postMessage({
    'type' : 'done',
    'data' : result
  });
};

postMessage({
  'type' : 'ready'
});
