<html><head>

<title>Video/Audio</title>

<script type="text/javascript" src="https://cdn.jsdelivr.net/clappr/latest/clappr.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/clappr.chromecast-plugin/latest/clappr-chromecast-plugin.js"></script>


</head>
<body>


<div id="player"></div>
    <script>
        var player = new Clappr.Player({
            							source: <?php echo "'".$urlEpisode."',\n"?>
        								parentId: "#player", 
            							plugins: {'core': [ChromecastPlugin],
                							playback: [Clappr.HLS]},
            							baseUrl: '/latest',
            							chromecast: {
            						          appId: '9DFB77C0',
            						          media: {
            						            title: 'Awesome Hot Air Balloon Slackline',
            						            subtitle: 'You won\'t get much closer to Skylining than this!'
            						          }
            						        }
            							});
      
    </script>
<?php 

		//echo "<div class='container'><video width='700' height='400'><source src='".$urlEpisode."' type='application/x-mpegURL'></video></div>";
		//echo "<div><br>".$id.'|'.$Shows."|".$urlEpisode."</br></div>";
	//}
	
?>
</body></html>