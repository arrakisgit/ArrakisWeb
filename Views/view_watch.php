<html><head>

<title>Video/Audio</title>

<script type="text/javascript" src="https://cdn.jsdelivr.net/clappr/latest/clappr.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/clappr.chromecast-plugin/latest/clappr-chromecast-plugin.js"></script>
<script type="text/javascript" src="http://192.168.0.18/ArrakisWeb_Lib/libs_js/videoconverter.js-master/demo/terminal.js"></script>


</head>
<body>


<div id="player"></div>
    <script>
    <?php if ($typeVid=='avi')
    {
    	$js_ffmpeg_command='-i input.webm -vf showinfo -strict -2 output.mp4';
    	echo "<script type='text/javascript'>";
    	echo "retrieveVideo('".$urlEpisode."');";
    	echo "runCommand('".$js_ffmpeg_command."');";
    }
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
      
    </script>
<?php 

		//echo "<div class='container'><video width='700' height='400'><source src='".$urlEpisode."' type='application/x-mpegURL'></video></div>";
		//echo "<div><br>".$id.'|'.$Shows."|".$urlEpisode."</br></div>";
	//}
	
?>
</body></html>