<?PHP
	require_once("../../../config/config.php");
	require_once("../../../comum/funcoes.php");
	$conexao=conectar($dados_conexao);
	$boletim_ocorrencia = $_GET['boletim_ocorrencia'];
	$momento_acontecimento = $_GET['momento_acontecimento'];
	$descricao = $_GET['descricao'];
	$id_usuario = $_GET['id_usuario'];
	$id_tipo_crime = $_GET['id_tipo_crime'];
	$localizacao = $_GET['localizacao'];
	echo $localizacao;
	$ip =10;
	//$fgdfsd = date("Y-m-d H:i:s");
	//echo $geometria;
	$localizacao = "POINT(".$localizacao.")";
	
	$consulta = "
					INSERT INTO contribuicao_crime(localizacao, boletim_ocorrencia, momento_acontecimento, id_usuario, id_tipo_crime)
					VALUES(ST_GeomFromText(?,4326),?,?,?,?)
				";
	$stmt = mysqli_prepare($conexao, $consulta);
	if (!$stmt) {
		sair(mysqli_error($conexao), $conexao);
	}
	mysqli_stmt_bind_param($stmt, "sssii", $localizacao, $boletim_ocorrencia, $momento_acontecimento, $id_usuario, $id_tipo_crime);
	$sucesso = mysqli_stmt_execute($stmt);
	if (!$sucesso){
		sair(mysqli_stmt_error($stmt), $conexao, $stmt);
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conexao);
	exit;
	
	
?>