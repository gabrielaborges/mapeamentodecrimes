<html>
	<head>
		<?php require_once("php/config/config.php"); ?>
		<?php require_once("inc/head.php"); ?>
	</head>
	<body>
		<?php require_once("inc/header.php"); ?>
		<hr>
		<h3> Quais 4 contribuições estão localizadas a menos de 10km ou mais que 80km uma da outra?</h3>
		<div id="local_conculta_2"></div>
		<br>
	</body>
	<script src="js/comum/funcoes.js?versao=<?php echo $versao; ?>"></script>
	<script src="js/consultas/consulta_2.js?versao=<?php echo $versao; ?>"></script>
</html>