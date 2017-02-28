<html><head>

<title>ArrakisWeb Player</title>

<script type="text/javascript" src="https://cdn.jsdelivr.net/clappr/latest/clappr.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/clappr.chromecast-plugin/latest/clappr-chromecast-plugin.js"></script>



</head>
<body>


<div id="player"></div>
    <script>
    <?php if ($typeVid=='avi')
    {?>
    	var worker = new Worker("http://192.168.0.18/ArrakisWeb_Lib/libs_js/convert/ArrakisWorker.js");
    	worker.onmessage = function (event) {
    		var message = event.data;
    		if (message.type == "ready") {
    			outputElement.textContent = "Loaded";
    			worker.postMessage({
    				type: 'command',
    				arguments: ['-help']
    			})
    		} else if (message.type == "stdout") {
    			outputElement.textContent += message.data + "\n";
    		} else if (message.type == "start") {
    			outputElement.textContent = "Worker has received command\n";
    		}
    	};
    	
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