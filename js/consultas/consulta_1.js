var tratar_dados_obtidos = function(dados_obtidos){
	document.getElementById("local_consulta_1").innerHTML = dados_obtidos;
};
carregar_dados("php/aplicacao/consultas/consulta_1.php", tratar_dados_obtidos);

