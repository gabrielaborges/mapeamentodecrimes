var tratar_dados_obtidos = function(dados_obtidos){
	//analisar_dados(dados_obtidos);
	var resultado = JSON.parse(dados_obtidos);
	var k=1;
	for (i in resultado) {
		var nova_opcao = document.createElement("option");
		nova_opcao.text = resultado[i];
		nova_opcao.value = i;
		document.getElementById("estado").options.add(nova_opcao, k);
		k++;
	}
};
carregar_dados("php/aplicacao/imagem/gera_estados.php", tratar_dados_obtidos);
var tratar_resultado_envio_imagem = function(dados_obtidos){
	analisar_dados(dados_obtidos);
	if(dados_obtidos.length === 0){
		alert("Imagem inserida com sucesso!");
	}
}
var formulario = document.forms.namedItem("formulario_envio");
formulario.addEventListener('submit', function(ev){
	ev.preventDefault();
	var dados_formulario = new FormData(this);
	carregar_dados("php/aplicacao/imagem/recebe_imagem.php", tratar_resultado_envio_imagem, "POST", dados_formulario);
}, false);