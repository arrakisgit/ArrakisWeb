
var worker;
var sampleImageData;
var sampleVideoData;
var outputElement;
var filesElement;
var running = false;
var isWorkerLoaded = false;
var isSupported = (function() {
  return document.querySelector && window.URL && window.Worker;
})();

function isReady() {
  alert("sampleVideoData = "+sampleVideoData);
  return !running && isWorkerLoaded && sampleVideoData;
}

function startRunning() {
  running = true;
}

function stopRunning() {
  running = false;
}

function retrieveVideo(videosPath) {
  alert(videosPath);
  var oReq = new XMLHttpRequest();
  oReq.open("GET", videosPath, true);
  oReq.responseType = "arraybuffer";
  oReq.send();
  oReq.addEventListener('readystatechange', function() {
	    if (oReq.readyState === XMLHttpRequest.DONE) { 
	    	sampleVideoData = new Uint8Array(this.response);
	    	alert('fini');
	    	console.log(sampleVideoData);
	    }
	    else
	    	{
	    	console.log(oReq.readyState);
	    	}

	});
    
}

function parseArguments(text) {
	console.log("parser");
	console.log(text);
  text = text.replace(/\s+/g, ' ');
  var args = [];
  // Allow double quotes to not split args.
  text.split('"').forEach(function(t, i) {
    t = t.trim();
    if ((i % 2) === 1) {
      args.push(t);
    } else {
      args = args.concat(t.split(" "));
    }
  });
  console.log(args);
  return args;
}


function runCommand(videosPath,text) {
	initWorker();
	retrieveVideo(videosPath);
  if (isReady()) {
	  alert("go");
    startRunning();
    var args = parseArguments(text);
    console.log(args);
    worker.postMessage({
      type: "command",
      arguments: args,
      files: [
        {
          "name": "input.webm",
          "data": sampleVideoData
        }
      ]
    });
  }
}

function getDownloadLink(fileData, fileName) {
  if (fileName.match(/\.jpeg|\.gif|\.jpg|\.png/)) {
    var blob = new Blob([fileData]);
    var src = window.URL.createObjectURL(blob);
    var img = document.createElement('img');

    img.src = src;
    return img;
  }
  else {
    var a = document.createElement('a');
    a.download = fileName;
    var blob = new Blob([fileData]);
    var src = window.URL.createObjectURL(blob);
    a.href = src;
    a.textContent = 'Click here to download ' + fileName + "!";
    return a;
  }
}

function initWorker() {
  worker = new Worker("worker-asm.js");
  isWorkerLoaded = true;
  

 // alert("worker");
  /*worker.onmessage = function (event) {
    var message = event.data;
    if (message.type == "ready") {
      isWorkerLoaded = true;
      worker.postMessage({
        type: "command",
        arguments: ["-help"]
      });
    } else if (message.type == "stdout") {
      outputElement.textContent += message.data + "\n";
    } else if (message.type == "start") {
      outputElement.textContent = "Worker has received command\n";
    } else if (message.type == "done") {
      stopRunning();
      var buffers = message.data;
      if (buffers.length) {
        outputElement.className = "closed";
      }
      buffers.forEach(function(file) {
        filesElement.appendChild(getDownloadLink(file.data, file.name));
      });
    }
  };*/
}



