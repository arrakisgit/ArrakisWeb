<html><head>

<title>Video/Audio</title>

<link rel="stylesheet" type="text/css" href="http://192.168.0.18/ArrakisWeb_Lib/libs_css/style.css">
<style type="text/css">

</style>

<script src="http://192.168.0.18/ArrakisWeb_Lib/libs_js/jquery.js"></script>

<script src="http://192.168.0.18/ArrakisWeb_Lib/libs_js/jLecteur.js"></script>

<script type="text/javascript">

$(document).ready(function() {
	$('video').videoPlayer({
		'playerWidth' : 0.95,
		'videoClass' : 'video'	
	});
});

</script>

</head>
<body>

<?php 
	if($typeVid=="mp4")
	{
		echo "<div class='container'><video width='700' height='400'><source src='".$urlEpisode."' type='video/mp4'></video></div>";
		echo "<div><br>".$id.'|'.$Shows."|".$urlEpisode."</br></div>";
	}
	elseif ($typeVid=="FRTV")
	{
		//foreach ($Episodes as $labelShow=>$showID)
		//{
			//
			echo $Episodes;
			//echo "<br><a href='http://192.168.0.18/ArrakisWeb/index.php/Episodes/index/".$Channels."_".$Shows."_".$labelShow."'>".$showID."</a></br>";
		//}
		//echo "<div class='container'><video width='700' height='400'><source src='".$Episode."' type='application/x-mpegURL'></video></div>";
	}
?>

</body></html>