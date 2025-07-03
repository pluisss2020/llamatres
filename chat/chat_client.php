<?php
session_start();
?>
<html><head><title>WebSocket</title>
<style type="text/css">
html,body {
	font:normal 0.9em arial,helvetica;
}
#log {
	width:250px; 
	height:200px; 
	border:1px solid #7F9DB9; 
	overflow:auto;
}
#msg {
	width:200px;
}
</style>
<script type="text/javascript">
var socket;

function init() {
	// Apuntar a la IP/Puerto configurado en el contructor del WebServerSocket, que es donde está escuchando el socket.
	var host = "ws://localhost:9000";
	try {
		socket = new WebSocket(host);
		log('WebSocket - Estatus '+socket.readyState);
		socket.onopen    = function(msg) { 
							   log("Bienvenido - Estatus "+this.readyState); 
						   };
		socket.onmessage = function(msg) { 
							   log("-"+msg.data); 
				               var partes=msg.data.split(" : ");
							   jn(partes[0],partes[1]);
							   alert(partes[0]);
						   };
		socket.onclose   = function(msg) { 
							   log("Desconectado - Estatus "+this.readyState); 
						   };
	}
	catch(ex){ 
		log(ex); 
	}
	$("msg").focus();
}

function send(){
	var txt,msg,alias,mensaje;
	alias=$("nikname");
	txt =$("msg");
	//alert(alias.value + " : " + txt.value);
	msg = txt.value;
	mensaje = alias.value + " : " + txt.value;
	if(!msg) { 
		alert("El mensaje no puede estar vacio"); 
		return; 
	}
	txt.value="";
	txt.focus();
	try { 
		socket.send(mensaje);
		log(mensaje); 
		jn(alias.value,msg);
		//log('Sent: '+mensaje); 
	} catch(ex) { 
		log(ex); 
	}
}
function quit(){
	if (socket != null) {
		log("Goodbye!");
		socket.close();
		socket=null;
	}
}

function reconnect() {
	quit();
	init();
}

// Utilities
function $(id){ return document.getElementById(id); }
function log(msg){ $("log").innerHTML+="<br>"+msg; }
function jn(jugador,msg){ 
	$(jugador).innerHTML=msg;	
/*	
  if(jugador=="j1")
	$("j1").innerHTML=msg;
	if(jugador=="j2")
	$("j2").innerHTML=msg; 
	if(jugador=="j3")
	$("j3").innerHTML=msg; */
}
function onkey(event){ if(event.keyCode==13){ send(); } }
</script>

</head>
<body >
<h3></h3>
<div id="log" onload="init()"></div>
<?php
echo '<input id="nikname" type="hidden" value="'.$_SESSION['username'].'" />';
?>
<p><input id="msg" type="textbox" onkeypress="onkey(event)"/>
<button onclick="send()">Enviar</button>
<button onclick="quit()">Salir</button>
<button onclick="reconnect()">Reconectar</button>
<p id="j1"></p>
<p id="j2"></p>
<p id="j3"></p>
<p id="j4"></p>
<p id="j5"></p>
</body>
</html>