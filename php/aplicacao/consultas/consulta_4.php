<?php
	
	require_once("../../config/config.php");
	require_once("../../comum/funcoes.php");
	$conexao=conectar($dados_conexao);
	$consulta = "
				SELECT cc.id as id_cc, t.id as id_t, t.nome as nome, tc.tipo as tipo


				FROM (SELECT u.id, ui.nome

						FROM usuario u JOIN usuario_identificado ui	ON u.id=ui.id
					) as t 
					
					JOIN contribuicao_crime cc ON cc.id_usuario=t.id 
					JOIN tipo_de_crime tc ON tc.id=cc.id_tipo_crime  
			
				ORDER BY `id_cc` ASC






			";
	$resultado_consulta = mysqli_query($conexao, $consulta);
	if (!$resultado_consulta){
		sair("Consulta inválida: ".mysqli_error($conexao), $conexao);
	}
	echo "<table class='tabela_resultado'>";
	echo "<tr><th>ID da Contribuição</th><th>ID do Usuário</th><th>Nome do Usuário</th><th>Tipo de Crime</th></tr>";
	while ($linha = mysqli_fetch_assoc($resultado_consulta)){
		echo "<tr>";
		echo "<td>".$linha["id_cc"]."</td><td>".$linha["id_t"]."</td><td>".$linha["nome"]."</td><td>".$linha["tipo"]."</td>";
		echo "</tr>";
	}
	echo "</table>";
	
?>