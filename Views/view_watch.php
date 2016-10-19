<html><head>

<title>Video/Audio</title>

<script type="text/javascript" src="https://cdn.jsdelivr.net/clappr/latest/clappr.min.js"></script>
<script src="https://cdn.jsdelivr.net/clappr.chromecast-plugin/latest/clappr-chromecast-plugin.js"></script>

</head>
<body>


<div id="player"></div>
    <script>
      var typeVid = <?php echo "\"".$typeVid."\";\n" ?>
      if (typeVid=="mp4")
      {
            alert('ok');
	      	var player = new Clappr.Player({
	        source: <?php echo "'".$urlEpisode."',\n"?>
	        plugins: [ChromecastPlugin],
	        parentId: '#player',
	        chromecast: {
	          appId: '9DFB77C0',
	          contentType: 'video/mp4',
	          media: {
	            type: ChromecastPlugin.None,
	            title: 'Awesome Hot Air Balloon Slackline',
	            subtitle: 'You won\'t get much closer to Skylining than this!'
	          }
	        }
	      });
      }
      else
      {
    	  var player = new Clappr.Player({source: source: <?php echo "'".$urlEpisode."',"?> parentId: "#player"});
      }
    </script>
<?php 

		//echo "<div class='container'><video width='700' height='400'><source src='".$urlEpisode."' type='application/x-mpegURL'></video></div>";
		echo "<div><br>".$id.'|'.$Shows."|".$urlEpisode."</br></div>";
	//}
	
?>
</body></html>