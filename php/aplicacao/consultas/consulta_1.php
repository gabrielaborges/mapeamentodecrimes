<?php
	require_once("../../config/config.php");
	require_once("../../comum/funcoes.php");
	$conexao=conectar($dados_conexao);
	$consulta = "
				SELECT cc.id, tc.tipo, cc.momento_acontecimento, cc.descricao, ST_Latitude(cc.localizacao), ST_Longitude(cc.localizacao), cc.boletim_ocorrencia
				
				FROM contribuicao_crime cc JOIN tipo_de_crime tc ON tc.id=cc.id_tipo_crime 
				
				WHERE cc.momento_acontecimento BETWEEN '2021-12-01 00:00:00' AND '2021-12-31 23:59:59' 
					AND tc.id=1 
					AND descricao LIKE '%celular%'
				
				ORDER BY boletim_ocorrencia DESC;
			";
	$resultado_consulta = mysqli_query($conexao, $consulta);
	if (!$resultado_consulta) {
		sair("Consulta inválida: ".mysqli_error($conexao), $conexao);
	}
	echo "<table class='tabela_resultado'>";
	echo "<tr><th>ID Contribuição</th><th>Tipo de Crime</th><th>Momento do Ocorrido</th><th>Descrição do Ocorrido</th><th>Latitude</th><th>Longitude</th><th>B.O.</th></tr>";
	while ($linha = mysqli_fetch_assoc($resultado_consulta)){
		echo "<tr>";
		echo "<td>".$linha["id"]."</td><td>".$linha["tipo"]."</td><td>".$linha["momento_acontecimento"]."</td><td>".$linha["descricao"]."</td><td>".$linha["ST_Latitude(cc.localizacao)"]."</td><td>".$linha["ST_Longitude(cc.localizacao)"]."</td><td>".$linha["boletim_ocorrencia"]."</td>";
		echo "</tr>";
	}
	echo "</table>";
?>