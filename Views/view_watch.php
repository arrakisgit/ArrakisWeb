<html><head>

<title>Video/Audio</title>

<script type="text/javascript" src="https://cdn.jsdelivr.net/clappr/latest/clappr.min.js"></script>

</head>
<body>


<div id="player"></div>
    <script>
        var player = new Clappr.Player({source: <?php echo "'".$urlEpisode."',"?> parentId: "#player" plugins: { playback: [Clappr.HLS] }, baseUrl: '/latest',});
      
    </script>
<?php 

		//echo "<div class='container'><video width='700' height='400'><source src='".$urlEpisode."' type='application/x-mpegURL'></video></div>";
		//echo "<div><br>".$id.'|'.$Shows."|".$urlEpisode."</br></div>";
	//}
	
?>
</body></html>