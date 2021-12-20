<?php
	require_once("../../config/config.php");
	require_once("../../comum/funcoes.php");
	$conexao=conectar($dados_conexao);
	$consulta = "
				SELECT cc.id as id_cc, ST_AsText(cc.localizacao), cc2.id as id_cc2, ST_AsText(cc2.localizacao), ST_Distance(cc.localizacao, cc2.localizacao, 'metre'), ST_SRID(cc.localizacao)

				FROM contribuicao_crime cc JOIN contribuicao_crime cc2 ON cc.id<cc2.id  

				WHERE 
					 ST_Distance(cc.localizacao, cc2.localizacao, 'metre')<10000 OR ST_Distance(cc.localizacao, cc2.localizacao, 'metre')>80000
					
				ORDER BY cc.id ASC 
				
				LIMIT 4; ;
			";
	$resultado_consulta = mysqli_query($conexao, $consulta);
	if (!$resultado_consulta){
		sair("Consulta inválida: ".mysqli_error($conexao), $conexao);
	}
	echo "<table class='tabela_resultado'>";
	echo "<tr><th>ID Ponto 1</th><th>Ponto 1</th><th>ID Ponto 2 </th><th>Ponto 2</th><th>Distância entre os pontos (metros)</th><th>Sistema de Referência</th></tr>";
	while ($linha = mysqli_fetch_assoc($resultado_consulta)){
		echo "<tr>";
		echo "<td>".$linha["id_cc"]."</td><td>".$linha["ST_AsText(cc.localizacao)"]."</td><td>".$linha["id_cc2"]."</td><td>". $linha["ST_AsText(cc2.localizacao)"]."</td><td>". $linha["ST_Distance(cc.localizacao, cc2.localizacao, 'metre')"]."</td><td>". $linha["ST_SRID(cc.localizacao)"]."</td>";
		echo "</tr>";
	}
	echo "</table>";
?>