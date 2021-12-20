var tratar_dados_obtidos = function(dados_obtidos){
	analisar_dados(dados_obtidos);
	//var resultado = JSON.parse(dados_obtidos);
	document.getElementById("resultado_python").innerHTML = dados_obtidos;
};
carregar_dados("php/aplicacao/python/executa_python.php", tratar_dados_obtidos);