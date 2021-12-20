var mapa_google;
var marcador_google;
var infowindow_contribuicao;
var marcadores_carregados=[];
var infowindow_dado_carregado;
var geometria_desenhada_atual;
function inicializar(){
	var latlng = new google.maps.LatLng(-22.4419, -43.1419);
	var options = {
		zoom: 13,
		center: latlng,
		scaleControl: true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	mapa_google = new google.maps.Map(document.getElementById("map_canvas"), options);
	infowindow_dado_carregado = new google.maps.InfoWindow();
	carregar_contribuicoes();
	google.maps.event.addListener(mapa_google, "click", function(event){
		if(infowindow_dado_carregado){
			infowindow_dado_carregado.close();
		}
		if(infowindow_contribuicao){
			infowindow_contribuicao.close();
		}
		if(marcador_google){
			marcador_google.setMap(null);
		}
		if(geometria_desenhada_atual){
			geometria_desenhada_atual.setMap(null);
		}
		var html =	
		/*
		'<link rel="stylesheet" href="css/gmaps.css">'+		
					'<div id="teste">'+
						'<form action="/action_page.php">'+
							'<label for="fname">First Name</label>'+
							'<input type="text" id="fname" name="firstname" placeholder="Your name..">'+
							'<label for="lname">Last Name</label>'+
							'<input type="text" id="lname" name="lastname" placeholder="Your last name..">'+
							'<label for="country">Country</label>'+
							'<select id="country" name="country">'+
							  '<option value="australia">Australia</option>'+
							  '<option value="canada">Canada</option>'+
							  '<option value="usa">USA</option>'+
							'</select>'+			  
							'<input type="submit" value="Submit">'+
						 ' </form>'+
					 '<div>';
		*/
		"<link rel='stylesheet' href='css/gmaps.css'>"+
			"<div id='teste'>"+
				"<form action='/mapeamentodecrimes/php/aplicacao/gmaps/insere/insere_dados.php'>"+
					"Boletim de Ocorrência:<input name='boletim_ocorrencia' type='text' id='boletim_ocorrencia'><br><br>"+
					"Momento do Acontecimento: <input name='momento_acontecimento' type='text' id='momento_acontecimento'><br><br>"+
					"ID do Usuário: <input name='id_usuario' type='text' id='id_usuario'><br><br>"+
					"Tipo de Crime: <input name='id_tipo_crime' type='text' id='id_tipo_crime'><br><br>"+
					"<br> Descreva o que aconteceu: <br><br> <textarea value='oi' id='descricao' name='descricao' rows='4' cols='50'></textarea><br>"+
					"<br> <input type='button' value='Salvar' onclick='salvar_dados(\"ponto\")'/> <br>"+
				"</form>"+
			"<div>";
					 
		infowindow_contribuicao = new google.maps.InfoWindow({
			content: html
		});
		marcador_google = new google.maps.Marker({
			position: event.latLng,
			map: mapa_google
		});
		infowindow_contribuicao.open(mapa_google, marcador_google);
		google.maps.event.addListener(marcador_google, "click", function(){
			infowindow_contribuicao.open(mapa_google, marcador_google);
		});
	});
	var drawingManager = new google.maps.drawing.DrawingManager({
		drawingMode: google.maps.drawing.OverlayType.NULL,
		drawingControl: true,
		drawingControlOptions:{
			position: google.maps.ControlPosition.TOP_CENTER,
			drawingModes: ['polygon', 'polyline']
		},
		polygonOptions: {
			clickable: true,
			draggable: true,
			editable: true
		}
	});
	drawingManager.setMap(mapa_google);
	google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event){
		if(geometria_desenhada_atual){
			geometria_desenhada_atual.setMap(null);
		}
		geometria_desenhada_atual=event.overlay;
		if (marcador_google){
			marcador_google.setMap(null);
		}
		var html="";
		if (event.type == 'polygon' || event.type == 'polyline'){
			var vertices = event.overlay.getPath();
			var string_pontos="";
			for (var i =0; i < vertices.getLength(); i++){
				var xy = vertices.getAt(i);
				html += '<br>'+'Coordinate '+i+':<br>'+xy.lng()+','+xy.lat();
				string_pontos += xy.lat()+" "+xy.lng()+",";
			}
			string_pontos += vertices.getAt(0).lat()+" "+vertices.getAt(0).lng();
			//analisar_dados(string_pontos);
			html += "<br><br>Valor M2: <input type='text' id='valor'><br><br>"+
					"<input type='button' value='Salvar' onclick='salvar_dados(\"linha_ou_poligono\", "+'"'+string_pontos+'"'+")'/>";
		}
		if(infowindow_contribuicao){
			infowindow_contribuicao.close();
		}
		infowindow_contribuicao = new google.maps.InfoWindow({
			content: html
		});
		infowindow_contribuicao.setPosition(xy);
		infowindow_contribuicao.open(mapa_google);
		google.maps.event.addListener(event.overlay, 'click', function(event){
			infowindow_contribuicao.open(mapa_google);
		});
	});
}
function carregar_contribuicoes(){
	limpar_marcadores();
	carregar_dados("php/aplicacao/gmaps/carrega/carrega_dados.php", function(data){
		alert(data);
		analisar_dados(data);
		var xml = parse_xml(data);
		contribuicoes = xml.getElementsByTagName("contribuicao_crime");
		for(var i = 0; i < contribuicoes.length; i++){
			var boletim_ocorrencia = contribuicoes[i].getElementsByTagName("boletim_ocorrencia")[0].textContent;
			var momento_acontecimento = contribuicoes[i].getElementsByTagName("momento_acontecimento")[0].textContent;
			var descricao = contribuicoes[i].getElementsByTagName("descricao")[0].textContent;
			var id_usuario = contribuicoes[i].getElementsByTagName("id_usuario")[0].textContent;
			var id_tipo_crime = contribuicoes[i].getElementsByTagName("id_tipo_crime")[0].textContent;
			var point = new google.maps.LatLng(
				parseFloat(contribuicoes[i].getElementsByTagName("latitude")[0].textContent),
				parseFloat(contribuicoes[i].getElementsByTagName("longitude")[0].textContent)
			);
			var html =	"<b>boletim_ocorrencia: </b>" + boletim_ocorrencia + "<br><br>"+
						"<b>momento_acontecimento: </b>" + momento_acontecimento + "<br><br>"+
						"<b>descricao: </b>" + descricao + "<br><br>"+
						"<b>id_tipo_crime: </b>" + id_tipo_crime + "<br><br>";

			var marcador_contribuicao_carregado = new google.maps.Marker({
				position: point,
				map: mapa_google
			});
			marcadores_carregados.push(marcador_contribuicao_carregado);
			bind_infowindow(marcador_contribuicao_carregado, infowindow_dado_carregado, html);
		}
	});
}
function bind_infowindow(marcador_contribuicao_carregado, infowindow_dado_carregado, html){
	google.maps.event.addListener(marcador_contribuicao_carregado, 'click', function (){
		infowindow_dado_carregado.setContent(html);
		if (marcador_google){
			marcador_google.setMap(null);
		}
		infowindow_dado_carregado.open(mapa_google, marcador_contribuicao_carregado);
		google.maps.event.addListenerOnce(infowindow_dado_carregado, 'domready', function(){
			recuperar_endereco(marcador_contribuicao_carregado.position.lng(), marcador_contribuicao_carregado.position.lat());
		});
	});
	return true;
}
function salvar_dados(tipo, string_pontos=""){
	var url;
	if(tipo=="ponto"){
		var boletim_ocorrencia = document.getElementById("boletim_ocorrencia").value;
		var momento_acontecimento = document.getElementById("momento_acontecimento").value;
		var id_usuario = document.getElementById("id_usuario").value;
		var id_tipo_crime = document.getElementById("id_tipo_crime").value;
		var lat = marcador_google.getPosition().lat();
		var lng = marcador_google.getPosition().lng();
		var localizacao = lat+" "+lng;
		url = "php/aplicacao/gmaps/insere/insere_dados.php?boletim_ocorrencia=" + boletim_ocorrencia + "&localizacao=" + localizacao +
			  "&momento_acontecimento=" + momento_acontecimento + "&id_usuario=" + id_usuario+ "&id_tipo_crime=" + id_tipo_crime;
	}
	else if(string_pontos){
		var localizacao = string_pontos;
		var valor = document.getElementById("valor").value;
		url = "php/aplicacao/gmaps/insere/insere_dados_extra.php?localizacao=" + localizacao +
			  "&valor=" + valor;
	}
	else{
		alert("Contribução não Enviada!");
		return;
	}
	carregar_dados(url, function(data){
		//analisar_dados(data);
		infowindow_contribuicao.close();
		alert("Contribução Realizada com Sucesso!");
		carregar_contribuicoes();
	});
}
function limpar_marcadores(){
	for (let i=0; i<marcadores_carregados.length; i++){
		marcadores_carregados[i].setMap(null);
	}
}
function recuperar_endereco(lng, lat){
	var url = "https://nominatim.openstreetmap.org/reverse?format=geojson&lat="+lat+"&lon="+lng;
	//analisar_dados(url);
	carregar_dados(url, function tratar_endereco_geojson(data){
		var dados_json = JSON.parse(data);
		document.getElementById("cidade_infowindows").innerHTML+=dados_json.features[0].properties.address.city;
		document.getElementById("estado_infowindows").innerHTML+=dados_json.features[0].properties.address.state;
	});
}
function recuperar_endereco_texto(){
	var texto_da_pesquisa = document.getElementById("endereco").value;
	var texto_da_pesquisa = encodeURI(texto_da_pesquisa);
	var url = "https://nominatim.openstreetmap.org/search?q="+texto_da_pesquisa+"&format=geojson";
	//analisar_dados(url);
}