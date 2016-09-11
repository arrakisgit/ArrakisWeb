<html><head>

<title>Video/Audio</title>

<link rel="stylesheet" type="text/css" href="http://192.168.1.20/ArrakisWeb_Lib/libs_css/style.css">
<style type="text/css">

</style>

<script src="http://192.168.1.20/ArrakisWeb_Lib/libs_js/jquery.js"></script>

<script src="http://192.168.1.20/ArrakisWeb_Lib/libs_js/jLecteur.js"></script>

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

<div class="container">
	<video width="700" height="400">
	<source src='citrons.mp4' type='video/mp4'>
	</video>
</div>


</body></html>