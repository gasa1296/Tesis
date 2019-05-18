function direct(obj) {
	console.log(obj)
	document.getElementById("panel-video").style.visibility = "visible";
	direccion = obj.previousSibling;
	camara = direccion.previousSibling;
	inning = camara.previousSibling;
	fecha = inning.previousSibling;
	vs = fecha.previousSibling;

	direccion = direccion.value;
	camara = camara.value;
	inning = inning.value;
	fecha = fecha.value;
	vs = vs.value;

	document.getElementById("titulo").innerHTML = "VS " + vs + " Date: " + fecha;

	video = document.getElementById("video");
	if (video.childNodes[0]) {
		video.removeChild(video.childNodes[0]);
	}
	let videotag = document.createElement("video");
	videotag.setAttribute("controls", true);

	let source = document.createElement("source");
	source.setAttribute("src", "../videos/videos/" + direccion);

	videotag.appendChild(source);
	video.appendChild(videotag);
}

function buscar() {
	busqueda = document.getElementById("busqueda").value;
	let xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			resultados = JSON.parse(this.responseText);
			document.getElementById("lista_jugadores").innerHTML = resultados.listaResultados;
			document.getElementById("nro_resultados").innerHTML = resultados.nroResultados;
		}
	};
	xmlhttp.open("GET", "busquedaInteligente.php?jugador=" + busqueda, true);
	xmlhttp.send();
}

function loadDoc() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("comenzar").innerHTML = this.responseText;
		}
	};
	xhttp.open("GET", "exec.php", false);
	xhttp.send();
}