<?PHP
	require_once("../../../config/config.php");
	require_once("../../../comum/funcoes.php");
	$valor = $_GET['valor'];
	$geometria = $_GET['geometria'];
	$geometria = "POLYGON((".$geometria."))";
	$conexao=conectar($dados_conexao);
	$consulta = "
					INSERT INTO regiao(geometria, valor_m2)
					VALUES(ST_GeomFromText(?, 4326), ?)
				";
	$stmt = mysqli_prepare($conexao, $consulta);
	if (!$stmt) {
		sair(mysqli_error($conexao), $conexao);
	}
	mysqli_stmt_bind_param($stmt, "sd", $geometria, $valor);
	$sucesso = mysqli_stmt_execute($stmt);
	if (!$sucesso){
		sair(mysqli_stmt_error($stmt), $conexao, $stmt);
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conexao);
	exit;
?>