<?PHP
	require_once("../../../config/config.php");
	require_once("../../../comum/funcoes.php");
	function parseToXML($htmlStr){
		$xmlStr=str_replace('<','&lt;',$htmlStr);
		$xmlStr=str_replace('>','&gt;',$xmlStr);
		$xmlStr=str_replace('"','&quot;',$xmlStr);
		$xmlStr=str_replace("'",'&#39;',$xmlStr);
		$xmlStr=str_replace("&",'&amp;',$xmlStr);
		return $xmlStr;
	}
	$conexao=conectar($dados_conexao);
	$consulta = "
				SELECT i.boletim_ocorrencia ,t.tipo, i.momento_acontecimento, i.descricao, ST_LONGITUDE(i.localizacao) as longitude, ST_LATITUDE(i.localizacao) as latitude, i.momento_contribuicao
				FROM contribuicao_crime i, tipo_de_crime t
				WHERE i.id_tipo_crime=t.id
			";
	$resultado_consulta = mysqli_query($conexao, $consulta);
	if (!$resultado_consulta){
		sair("Consulta inválida: ".mysqli_error($conexao), $conexao);
	}

	header("Content-type: text/xml");

	$xml = new DOMDocument("1.0");
	$xml->formatOutput=true;

	$contribuicoes=$xml->createElement("contribuicoes");
	$xml->appendChild($contribuicoes);

	while ($linha = mysqli_fetch_assoc($resultado_consulta)){
		$contribuicao_crime=$xml->createElement("contribuicao_crime");
		$contribuicoes->appendChild($contribuicao_crime);

		$boletim_ocorrencia =$xml->createElement("boletim_ocorrencia", $linha["boletim_ocorrencia"]);
		$contribuicao_crime->appendChild($boletim_ocorrencia );

		$momento_acontecimento=$xml->createElement("momento_acontecimento", $linha["momento_acontecimento"]);
		$contribuicao_crime->appendChild($momento_acontecimento);
		
		$descricao=$xml->createElement("descricao", $linha["descricao"]);
		$contribuicao_crime->appendChild($descricao);
		
		$tipo=$xml->createElement("tipo", $linha["tipo"]);
		$contribuicao_crime->appendChild($tipo);

		$longitude=$xml->createElement("longitude", $linha["longitude"]);
		$contribuicao_crime->appendChild($longitude);

		$latitude=$xml->createElement("latitude", $linha["latitude"]);
		$contribuicao_crime->appendChild($latitude);
		
		$momento_contribuicao=$xml->createElement("momento_contribuicao", $linha["momento_contribuicao"]);
		$contribuicao_crime->appendChild($momento_contribuicao);

	}
	echo $xml->saveXML();
?>