<?php
	function escrever_log($mensagem){
		if($mensagem){
			$arquivo = fopen($GLOBALS['local_logs'].'erros.log', 'a');
			fwrite($arquivo, date('d-m-Y H:i:s').$mensagem."\n");
			fclose($arquivo);
		}
	}
	function sair($mensagem=null, $conexao=null, $stmt=null){
		if($stmt){
			mysqli_stmt_close($stmt);
		}
		if($conexao){
			mysqli_close($conexao);
		}
		if($mensagem){
			escrever_log($mensagem);
		}
		exit;
	}
	function conectar($dados_conexao){
		$conexao_mysql = mysqli_connect($dados_conexao["nome_servidor"], $dados_conexao["usuario_mysql"], $dados_conexao["senha_usuario_mysql"]);
		if (!$conexao_mysql){
			sair("A conexão falhou: " . utf8_encode(mysqli_connect_error()));
		}
		$db_selected = mysqli_select_db($conexao_mysql, $dados_conexao["nome_banco_de_dados"]);
		if (!$db_selected){
			$nome_banco_de_dados = $dados_conexao["nome_banco_de_dados"];
			sair("Problema ao acessar o Banco de Dados \"$nome_banco_de_dados\": " . utf8_encode(mysqli_error()));
		}
		return $conexao_mysql;
	}
	function ajustar_coordenada_exif($coordenada_exif){
		$partes = explode('/', $coordenada_exif);
		if(count($partes) <= 0){
			return 0;
		}
		if(count($partes) == 1){
			return $partes[0];
		}
		return floatval($partes[0])/floatval($partes[1]);
	}
	function converter_coordenada_exif_mysql($dados_gps_exif){
		$latitude_sinal = $dados_gps_exif["GPSLatitudeRef"];
		$latitude =	ajustar_coordenada_exif($dados_gps_exif["GPSLatitude"][0])+
					ajustar_coordenada_exif($dados_gps_exif["GPSLatitude"][1])/60+
					ajustar_coordenada_exif($dados_gps_exif["GPSLatitude"][2])/3600;
		if($latitude_sinal=="S" || $latitude_sinal=="s"){
			$latitude = -$latitude;
		}
		$longitude_sinal = $dados_gps_exif["GPSLongitudeRef"];
		$longitude = ajustar_coordenada_exif($dados_gps_exif["GPSLongitude"][0])+
					 ajustar_coordenada_exif($dados_gps_exif["GPSLongitude"][1])/60+
					 ajustar_coordenada_exif($dados_gps_exif["GPSLongitude"][2])/3600;
		if($longitude_sinal=="W" || $longitude_sinal=="w"){
			$longitude = -$longitude;
		}
		$ponto_graus_decimais["latitude"] = $latitude;
		$ponto_graus_decimais["longitude"] = $longitude;
		return $ponto_graus_decimais;
	}
	
?>