var tratar_dados_obtidos = function(dados_obtidos){
	document.getElementById("local_conculta_2").innerHTML = dados_obtidos;
};
carregar_dados("php/aplicacao/consultas/consulta_2.php", tratar_dados_obtidos);