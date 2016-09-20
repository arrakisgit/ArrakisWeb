<?php
/*Auteur      : Amine El Ouazzani
 *Projet      : Arrakis
 *Date        : 20/08/2016 2:35 PM
 *Licence     : GNU GPL v3
 *Description : Fonctions de gestion des fichiers HTML/JSON
 *git         : https://github.com/arrakisgit/ArrakisWeb.git
 */

session_start();
$UrlPath=$_SESSION['URLVIDEO'];

?>
<html><head>

<title>Video/Audio</title>

<link rel="stylesheet" type="text/css" href="/libs_css/style.css">
<style type="text/css">

</style>

<script src="/libs_js/jquery.js"></script>

<script src="/libs_js/jLecteur.js"></script>

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
		<?php
		echo '<source src="'.$UrlPath.'" type="video/mp4">';
		?>
	</video>
</div>


</body></html>