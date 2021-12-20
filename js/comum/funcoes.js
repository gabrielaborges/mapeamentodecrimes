var nome_pasta_website = "mapeamentodecrimes";
document.addEventListener("DOMContentLoaded", function(event){
	var caminho_atual=window.location.pathname;
	if(caminho_atual=="/mapeamentodecrimes/"){
		caminho_atual="index.php";
	}
	var nome_paginal_atual = caminho_atual.split("/").pop().split(".");
	nome_paginal_atual = nome_paginal_atual[nome_paginal_atual.length-2];
	document.getElementById("menu_"+nome_paginal_atual).classList.add("active");
});
function carregar_dados(pagina, tratar_resultado_carregar_dados, metodo="GET", dados_para_enviar=null){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState == 4 && this.status == 200){
			tratar_resultado_carregar_dados(this.responseText);
		}
	};
	xhttp.open(metodo, pagina, true);
	if(dados_para_enviar){
		xhttp.send(dados_para_enviar);
	}
	else{
		xhttp.send();
	}
}
function parse_xml(str){
	if(window.DOMParser){
		parser = new DOMParser();
		xmlDoc = parser.parseFromString(str, "text/xml");
	}
	else{
		xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
		xmlDoc.async = false;
		xmlDoc.loadXML(str);
	}
	return xmlDoc;
}
function analisar_dados(dados){
	alert(dados);
	console.log(dados);
}