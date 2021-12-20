<?PHP
	require_once("../../config/config.php");
	require_once("../../comum/funcoes.php");
	$conexao=conectar($dados_conexao);
	$consulta = "
				SELECT e.id, e.sigla
				FROM estado e
			";
	$resultado_consulta = mysqli_query($conexao, $consulta);
	if (!$resultado_consulta) {
		sair("Consulta inválida: ".mysqli_error($conexao), $conexao);
	}
	$estados=array();
	while ($linha = mysqli_fetch_assoc($resultado_consulta)){
		$estados[$linha['id']] = $linha['sigla'];		
	}
	echo json_encode($estados);
?>