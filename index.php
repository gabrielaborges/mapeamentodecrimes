<html>
	<head>
		<?php
		require_once("php/config/config.php");
		require_once("inc/head.php");
		?>
		<script src="js/gmaps/gmaps.js?versao=<?php echo $versao; ?>"></script>
	</head>
	<body>
		<?php require_once("inc/header.php"); ?>
		<hr>
		<div id="map_canvas"></div>
		<div id="message"></div>
		<input id="endereco" type="textbox" value="">
		<input type="button" value="Encode" onclick="recuperar_endereco_texto()">
		<hr>
		<script src="https://maps.googleapis.com/maps/api/js?callback=inicializar&libraries=drawing" async defer></script>
	</body>
</html>