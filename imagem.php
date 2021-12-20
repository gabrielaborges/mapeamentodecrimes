<html>
	<head>
		<?php
		require_once("php/config/config.php");
		require_once("inc/head.php");
		?>
		<link rel="stylesheet" type="text/css" href="css/imagem.css?versao=<?php echo $versao; ?>">
	</head>
	<body>
		<?php require_once("inc/header.php"); ?>
		<br>
		<div class="container">
			<form id="formulario_envio" enctype="multipart/form-data">
				<label for="titulo">Título da imagem:</label>
				<input type="text" id="titulo" name="titulo" placeholder="Título da imagem...">
				<label for="estado">Estado:</label>
				<select id="estado" name="estado" placeholder="Escolha um estado...">
				</select>
				<label for="arquivo">Imagem:</label>
				<br><br>
				<input type="file" id="arquivo" name="arquivo" placeholder="Arquivo da imagem...">
				<br><br>
				<input type="submit" value="Enviar">
			</form>
		</div>
	</body>
	<script src="js/imagem/imagem.js?versao=<?php echo $versao; ?>"></script>
</html>