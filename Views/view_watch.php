<html><head>

<title>ArrakisWeb Player</title>

<script type="text/javascript" src="https://cdn.jsdelivr.net/clappr/latest/clappr.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/clappr.chromecast-plugin/latest/clappr-chromecast-plugin.js"></script>



</head>
<body>


<div id="player"></div>
    <script>
    <?php if ($typeVid=='avi')
    {
    	$js_ffmpeg_command='-i input.avi -vf showinfo -strict -2 output.mp4';?>
    	var worker = new Worker("http://192.168.0.18/ArrakisWeb_Lib/libs_js/convert/ArrakisWorker.js");
    	worker.onmessage = function (event) {
    		var message = event.data;
    		if (message.type == "ready") {
    			document.writeln("Loaded\n");
    			worker.postMessage({
    				type: 'command',
    				arguments: ['-help']
    			})
    		} else if (message.type == "stdout") {
    			document.writeln(message.data+"\n");
    		} else if (message.type == "start") {
    			document.writeln("Worker has received command\n");
    		}
    	};
    		var sampleVideoData;
    		function retrieveSampleVideo() {
    		  var oReq = new XMLHttpRequest();
    		  oReq.open("GET", <?php echo '"'.$urlEpisode.'"'?>, true);
    		  oReq.responseType = "arraybuffer";

    		  oReq.onload = function (oEvent) {
    		    var arrayBuffer = oReq.response;
    		    if (arrayBuffer) {
    		      sampleVideoData = new Uint8Array(arrayBuffer);
    		    }
    		  };

    		  oReq.send(null);
    		}
    		function getDownloadLink(fileData, fileName) {
    			  var a = document.createElement('a');
    			  a.download = fileName;
    			  var blob = new Blob([fileData]);
    			  var src = window.URL.createObjectURL(blob);
    			  a.href = src;
    			  a.textContent = 'Click here to download ' + fileName + "!";
    			  return a;
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

    		var args = parseArguments(<?php echo '"'.$js_ffmpeg_command.'"'?>);
    		    console.log(args);
    		    worker.postMessage({
    		      type: "command",
    		      arguments: args,
    		      files: [
    		        {
    		          "name": "input.avi",
    		          "data": sampleVideoData
    		        }
    		      ]
    		    });

    	
    <?php
    //$js_ffmpeg_command='-i input.webm -vf showinfo -strict -2 output.mp4';
    //echo "runCommand('".$urlEpisode."','".$js_ffmpeg_command."');\n";
	}
	else 
	{
    	?>
    	
        var player = new Clappr.Player({
            							source: <?php echo "'".$urlEpisode."',\n"?>
        								parentId: "#player", 
            							plugins: {'core': [ChromecastPlugin],
                							playback: [Clappr.HLS]},
            							baseUrl: '/latest',
            							chromecast: {
            						          appId: '9DFB77C0'
            						        }
            							});
     <?php }?> 
    </script>
</body></html>