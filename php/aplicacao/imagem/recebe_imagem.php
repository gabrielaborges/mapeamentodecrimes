<?PHP
	require_once("../../config/config.php");
	require_once("../../comum/funcoes.php");
	$erros = [];
	if(isset($_FILES) && isset($_POST["titulo"]) && isset($_POST["estado"])){
		$foto = $_FILES['arquivo']['tmp_name'];
		$foto_nome = $_FILES['arquivo']['name'];
		$foto_tamanho = $_FILES["arquivo"]["size"];
		$diretorio = "../../../media/img/";
		$diretorio_arquivo = $diretorio.basename($foto_nome);
		$tamanho_imagem = getimagesize($foto);
		if($tamanho_imagem == false){
			$erros["erro_arquivo_tipo"] = 1;
		}
		if(file_exists($diretorio_arquivo)){
			$erros["erro_arquivo_existe"] = 1;
		}
		if($foto_tamanho > 5000000){
			$erros["erro_arquivo_tamanho"] = 1;
		}
		$extensao_arquivo = strtolower(pathinfo($diretorio_arquivo,PATHINFO_EXTENSION));
		if($extensao_arquivo != "jpg" && $extensao_arquivo != "png" && $extensao_arquivo != "jpeg" && $extensao_arquivo != "gif" ){
			$erros["erro_arquivo_extensao"] = 1;
		}
		if(!$erros){
			$exif = exif_read_data($foto, 0, true);
			if(move_uploaded_file($foto, $diretorio_arquivo)){
				$conexao=conectar($dados_conexao);
				$consulta = "INSERT INTO imagem(titulo, estado, imagem, latitude, longitude, local)
							 VALUES(?, ?, ?, ?, ?, ST_GeomFromText(?, 4326))";
				$stmt = mysqli_prepare($conexao, $consulta);
				if($stmt){
					$titulo = $_POST["titulo"];
					$estado = $_POST["estado"];
					$imagem_path = $diretorio_arquivo;
					$imagem_path = $path_projeto.str_replace("/", "\\", substr($imagem_path, 9));
					$latitude = null;
					$longitude = null;
					$local = null;
					//print_r($exif);
					if(isset($exif["GPS"])){
						$ponto_graus_decimais = converter_coordenada_exif_mysql($exif["GPS"]);
						$latitude = $ponto_graus_decimais["latitude"];
						$longitude = $ponto_graus_decimais["longitude"];
						$local = "POINT(".$latitude." ".$longitude.")";
					}
					mysqli_stmt_bind_param($stmt, "sissss", $titulo, $estado, $imagem_path, $latitude, $longitude, $local);
					$sucesso = mysqli_stmt_execute($stmt);
						if(!$sucesso){
						unlink($diretorio_arquivo);
						$erros["erro_mysqli_stmt"] = 1;
						escrever_log(mysqli_stmt_error($stmt));
					}
					mysqli_stmt_close($stmt);
				}
				else{
					$erros["erro_mysqli"] = 1;
					escrever_log(mysqli_error($conexao));
				}
				mysqli_close($conexao);
			}
			else{
				$erros["erro_arquivo_upload"] = 1;
			}
		}
	}
	else{
		$erros["erro_dados_incompletos"] = 1;
	}
	echo json_encode($erros);
?>