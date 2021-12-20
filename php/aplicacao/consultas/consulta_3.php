<?php
	require_once("../../config/config.php");
	require_once("../../comum/funcoes.php");
	$conexao=conectar($dados_conexao);
	$consulta = "
				SELECT cc.id, tc.tipo, ST_AsText(cc.localizacao), ruc.nota

				FROM contribuicao_crime cc JOIN tipo_de_crime tc ON  cc.id_tipo_crime=tc.id JOIN r_usuario_identificado_contribuicao ruc
				ON ruc.id_contibuicao=cc.id 

				WHERE  ruc.nota IN (5)
				
				GROUP BY cc.id
				
				ORDER BY `cc`.`id` ASC;


			";
	$resultado_consulta = mysqli_query($conexao, $consulta);
	if (!$resultado_consulta){
		sair("Consulta inválida: ".mysqli_error($conexao), $conexao);
	}
	echo "<table class='tabela_resultado'>";
	echo "<tr><th>ID</th><th>Coordenadas da Contribuição</th><th>Descrição</th><th>Nota</th></tr>";
	while ($linha = mysqli_fetch_assoc($resultado_consulta)){
		echo "<tr>";
		echo "<td>".$linha["id"]."</td><td>".$linha["tipo"]."</td><td>".$linha["ST_AsText(cc.localizacao)"]."</td><td>".$linha["nota"]."</td>";
		echo "</tr>";
	}
	echo "</table>";
?>