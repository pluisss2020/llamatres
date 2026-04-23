let newti;
let ti;
let mesa;
let user;
let id_user;
let status="V";
newti=0;
ti=0;
mesa=0;
user=0;
id_user=0;
let Cartas = new Array();
let Img_carta = new Array();

let Id_Jug = 1;

let Player = new Array(
        new Array(0,0,0,0,0,0,0,0),
        new Array(0,0,0,0,0,0,0,0),
        new Array(0,0,0,0,0,0,0,0),
        new Array(0,0,0,0,0,0,0,0),
        new Array(0,0,0,0,0,0,0,0));

let sts_mesa = [];

let Id_naipes_0 = new Array("#NJ1","#NJ2","#NJ3","#NJ4","#NJ5","#NJ6","#NJ7","#NJ8");
let Id_naipes_1 = new Array("NJ1","NJ2","NJ3","NJ4","NJ5","NJ6","NJ7","NJ8");

let Id_jugada = new Array("#N1","#N2","#N3","#N4","#N5");

var conn = new WebSocket("ws://localhost:9069");

//var conn = new WebSocket("ws://llamatres.tecnica4berazategui.edu.ar:9069");


function ver_cartas_jugador(){
   	var p=LLAMATRES.select_player.selectedIndex;
  	var j= p+1;
    
    var nj; 
  	document.cookie = "NJ="+encodeURIComponent(j)+";secure";
    nj = readCookie("NJ");
  	alert(nj);
  	//alert(j);
  	for(var i=1 ;i< 9;i++){
    //$(Id_naipes_0[i-1]).replaceWith('<img id="'+Id_naipes_1[i-1]+ '" onClick="jugar_carta('+ i + ');ocultarElem(this);" class="NJ"  src="'+ Img_carta[Player[p][i-1]] +'" >');
    //$("#NJ1").replaceWith('<img id="NJ1" onClick="jugar_carta(1);ocultarElem(this);" class="NJ"  src="'+ Img_carta[Player[p][i-1]] +'" >');
    //$("#NJ2").replaceWith('<img id="NJ2" onClick="jugar_carta(2);ocultarElem(this);" class="NJ"  src="'+ Img_carta[Player[p][i-1]] +'" >');
    //$("#NJ3").replaceWith('<img id="NJ3" onClick="jugar_carta(3);ocultarElem(this);" class="NJ"  src="'+ Img_carta[Player[p][i-1]] +'" >');

  }
}

function jugar_carta(nro_carta){

  	var nj = document.getElementById("pos_jugador").innerText;
   
  	let n_mesa=document.getElementById("name_mesa").innerText;
    var nc=Player[nj-1][nro_carta];

    //alert('NJ: '+nj+'    Orden carta:'+nro_carta+'     carta :'+nc);

  	$(Id_jugada[nj-1]).attr("src",Img_carta[Player[nj-1][nro_carta]]);
    
    var datos = {"mesa":n_mesa,"tipo":'CartaJugada',"jugador": nj,"carta": Player[nj-1][nro_carta]};
    conn.send(JSON.stringify(datos));
 }


 function send_sts_mesa(status){

  	var nj = document.getElementById("pos_jugador").innerText;
   
  	let nro_mesa=document.getElementById("nro_mesa").innerText;

    let id_jugador=document.getElementById("id_jugador").innerText;

    let nombre_mesa=document.getElementById("name_mesa").innerText;

    console.log(status);
    
  	
    var datos = {"mesa":nombre_mesa,"tipo":'StatusMesa',"status": status};
    conn.send(JSON.stringify(datos));

    
 }


function readCookie(name) {

  var nameEQ = name + "="; 
  var ca = document.cookie.split(";");

  for(var i=0;i < ca.length;i++) {

    var c = ca[i];
    while (c.charAt(0)==" ") c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) {
      return decodeURIComponent( c.substring(nameEQ.length,c.length) );
    }

  }

  return null;

}


function initArray(){
   for(var i=0 ;i< 40;i++)
    Cartas[i]=i;
}

function TaparCartas(){
for(var i=1 ;i< 9;i++)
    $(Id_naipes_0[i-1]).replaceWith('<img id="'+Id_naipes_1[i-1]+ '" class="CJ" src="images/atras.jpg" >');	
}

function VerCartas(){

j=document.getElementById("pos_jugador").innerText;
//alert(j);
j--;

if(j>=0 && j<5){
for (var i=0 ; i<8 ; i++){
 //document.getElementById(Id_naipes_1[i]).src = Img_carta[Player[j][i]];
  $(Id_naipes_0[i]).replaceWith('<img id="'+Id_naipes_1[i]+ '" class="CJ" src="'+Img_carta[Player[j][i]]+'" onClick="jugar_carta('+ i + ');ocultarElem(this);">');
}
}
 
}

function Mezclar()
{
// C cartas que quedan arriba en el corte
//$("#Mezclar").click(function(){
var C = 0;
var L1 = 0 ;
var M = 0 ;
var i, j, k;
var Aux = new Array(40);

initArray();
TaparCartas();
//init_cartas();
M=Math.round(100 * Math.random() + 20,0);
//M = 25;
for(k = 0; k < M ; k++){
Cortar();
    for (i=0;i<40;i++){
     Aux[i] = Cartas[i];
    }

    C = 20;
    L1 = Math.round(10 * Math.random() + 5,0);
    //document.write("<p>"+"L1= "+L1+"</p>");
    for (i = L1 ;i<40 - L1;i=i+ 2){
     Cartas[i + 1] = Aux[i];
     Cartas[i] = Aux[i + 1];

  }
}
}


function Cortar()
{
// C cartas que quedan arriba en el corte
//$("#Cortar").click(function(){
var C = 0;
var L1 = 0 ;
var M = 0 ;
var i, j, k;
var Aux = new Array(40);
var R = 0;

for( i = 0; i< 40 ; i++){
 Aux[i] = Cartas[i];
}
C = Math.round(20 * Math.random() + 10);
R = 40 - C ;

//document.write("<p>"+"R="+R+"C="+C+"</p>");

for (i = 0 ; i< R  ; i++){
 Cartas[i] = Aux[C + i];
}
for( i = 0;i< C ;i++){
 Cartas[R + i] = Aux[i];
}
//   for(var i=0 ;i< 40;i++){
//    document.write("<p>"+ Cartas[i]+"</p>");
//   }
}

function init_cartas(){

var Palo = Array(4);
var i, j, k;



initArray();
Palo[0] = "O";
Palo[1] = "C";
Palo[2] = "E";
Palo[3] = "B";

for (i = 0 ; i < 4 ; i++){
    for (j = 0 ; j < 7 ; j++ )
          Img_carta[i * 10 + j] = "images/" + Palo[i] + [j + 1] + ".jpg";

}
for (i = 0 ;i < 4; i++){
    for (j = 7 ; j < 10 ; j++)
      Img_carta[i * 10 + j] = "images/" + Palo[i] + [j + 1 + 2] + ".jpg";

}
//alert("CARTAS");
for (i=0 ; i<10 ; i++){
//document.images[i].src=Img_carta[i];
 //document.write(Img_carta[i]);
}

}

function Repartir()
{
//$("#Repartir").click(function(){
var i, j, k , l;
var Aux = new Array(40);

//init_cartas();

for (i = 0 ;i< 40;i++){
  Aux[i] = Cartas[i];
}
l=0;

   for (k = 0 ;k < 4 ;k++){ //4 cartas por jugador
    for (j = 0 ; j < 5 ; j++){   //5 jugadores
       for (i = 0 ; i < 2 ; i++){      //2 rondads de cartas
         Cartas[l]=Aux[i * 20 + j * 4 + k];
         Player[j][(i*4)+k]=Cartas[l];
     //document.write("<p>"+ "PLayer = "+ j +"   X="+(i * 4 + k) +"</p>");
     l++;
    }
  }
}
 var n_mesa=document.getElementById("name_mesa").innerText;
 var paquete = {
  mesa: n_mesa,
  tipo: "Repartir",
  jugadores: []   // ← acá guardaremos los datos de cada jugador
};
for (let j = 0; j < 5; j++) {
  paquete.jugadores.push({
    jugador: j,
    cartas: Player[j]
  });
}
conn.send(JSON.stringify(paquete));
/*
 var datos = {"mesa":n_mesa,"tipo": 'Repartir'};
 conn.send(JSON.stringify(datos));
 for (j = 0 ; j < 5 ; j++){   //5 jugadores 
  var datos = {"mesa":n_mesa,"jugador": j,"cartas":Player[j]};
      conn.send(JSON.stringify(datos));
 }
*/
}

function PonerMsj(msj){
  document.getElementById("msj_ws").innerText=msj;
}

function log(msg){ $("#log").html(msg); }

function jn(jugador,msg){ 
	$(jugador).innerHTML=msg;	
}

function onkey(event){ if(event.keyCode==13){ sendChat(); } }

function J_habla(J,event){ if(event.keyCode==13){ sendHabla(J); } }

function VerMisCartas(cartas){

j=document.getElementById("pos_jugador").innerText;
//alert(j);
j--;

if(j>=0 && j<5){
for (var i=0 ; i<8 ; i++){
 //document.getElementById(Id_naipes_1[i]).src = Img_carta[Player[j][i]];
  Player[j][i]=cartas[i];
  //console.log("cartas Player:",Player[j][i]);
  $(Id_naipes_0[i]).replaceWith('<img id="'+Id_naipes_1[i]+ '" class="CJ" src="'+Img_carta[Player[j][i]]+'" onClick="jugar_carta('+ i + ');ocultarElem(this);">');
}
}
 
}


function logChat(msg){
   document.getElementById("log_CHAT").innerHTML+="<br><br>"+msg; 
   const chat = document.getElementById("log_CHAT");
   chat.scrollTop = chat.scrollHeight;
  }

  function ponerHabla(msg,tbox){
  /*  
  document.getElementById('T1').value="";
  document.getElementById('T2').value="";
  document.getElementById('T3').value="";
  document.getElementById('T4').value="";
  document.getElementById('T5').value="";
  */
   const habla=document.getElementById(tbox); 
   habla.value=msg;

  }

function sendChat(){
	var txt,msg;
	txt = document.getElementById("msg_CHAT").value;
  
	msg = txt;
  console.log(msg);
	if(!msg) { 
		alert("Message can not be empty"); 
		return; 
	}
	document.getElementById("msg_CHAT").value="";
	document.getElementById("msg_CHAT").focus();
	try { 
		//socket.send(msg); 
		//logChat( ': '+ msg);
    let n_mesa=document.getElementById("name_mesa").innerText;
    let name_jugador=document.getElementById("nombre_jugador").innerText;
    var datos = {"mesa":n_mesa,"tipo":'Chat',"jugador": name_jugador,"mensaje": msg};
    conn.send(JSON.stringify(datos)); 
	} catch(ex) { 
		logChat(ex); 
	}
}
  
function sendHabla(nj){
	var txt,msg;
  var TJ="T"+nj;
	txt = document.getElementById(TJ).value;
  
	msg = txt;
  console.log(msg);
	if(!msg) { 
		alert("Message can not be empty"); 
		return; 
	}
	//document.getElementById("msg_CHAT").value="";
	//document.getElementById("msg_CHAT").focus();
	try { 
		//socket.send(msg); 
		//logChat( ': '+ msg);
    let n_mesa=document.getElementById("name_mesa").innerText;
    let name_jugador=document.getElementById("nombre_jugador").innerText;
    var datos = {"mesa":n_mesa,"tipo":'Habla',"jugador": name_jugador,"mensaje": msg,"Nro_jugador":nj};
    conn.send(JSON.stringify(datos)); 
	} catch(ex) { 
		logChat(ex); 
	}
}

function sendInfo(msg){
	
  console.log("sendInfo:");
	if(!msg) { 
		alert("Message can not be empty"); 
		return; 
	}
	
	try { 
		
    let n_mesa=document.getElementById("name_mesa").innerText;
    let name_jugador=document.getElementById("nombre_jugador").innerText;
    var datos = {"mesa":n_mesa,"tipo":'Info',"jugador": name_jugador,"mensaje": msg};
    conn.send(JSON.stringify(datos)); 
	} catch(ex) { 
		logChat(ex); 
	}
}

function init_ws_client() {
	// Apuntar a la IP/Puerto configurado en el contructor del WebServerSocket, que es donde está escuchando el socket.
	var host = "ws://localhost:9069";
	//var host = "ws://llamatres.tecnica4berazategui.edu.ar:9069";
  try {
		socket = new WebSocket(host);
		logChat('WebSocket - Estatus '+socket.readyState);
		socket.onopen    = function(msg) { 
							   logChat("Bienvenido - Estatus "+this.readyState); 
                 //console.log("Bienvenido - Estatus "+this.readyState);
						   };
		socket.onmessage = function(msg) { 

      let idJugador = document.getElementById("pos_jugador").innerText-1;
      let n_mesa=document.getElementById("name_mesa").innerText;
      const mensaje = JSON.parse(msg.data);
      console.log(mensaje.mesa+"  "+mensaje.tipo);
      console.log(n_mesa+"  "+idJugador);

      if (mensaje.tipo === "Unirse"){
        if(mensaje.mesa === n_mesa){
          logChat(mensaje.mensaje);
          if(mensaje.posicion != idJugador+1)
            PonerStsJugador(n_mesa,mensaje.posicion,mensaje.jugador);

        }

      }
      if(mensaje.tipo=="StatusMesa"){
        var status=mensaje.status;
        if(mensaje.mesa === n_mesa)
         PonerStsJugador(mensaje.mesa,status);


      }
      if (mensaje.tipo === "Salirse"){
        if(mensaje.mesa === n_mesa){
          logChat(mensaje.mensaje);
        }
      }

      if (mensaje.tipo === "Repartir") {

        if(mensaje.mesa === n_mesa){
        // buscar solo las cartas de este jugador
        const misDatos = mensaje.jugadores.find(j => j.jugador === idJugador);
        console.log(misDatos);
        if (misDatos) {
          //console.log("Mis cartas:", misDatos.cartas);
          VerMisCartas(misDatos.cartas);  // tu función de visualización
        } else {
          console.warn("No hay datos para este jugador");
        }
      }
      }

      if (mensaje.tipo === "CartaJugada") {

        if(mensaje.mesa === n_mesa){
                
        if (mensaje.carta) {
          console.log("carta:"+mensaje.carta+"   Jugador:"+mensaje.jugador);
          $(Id_jugada[mensaje.jugador-1]).attr("src",Img_carta[mensaje.carta]);
        } else {
          console.warn("No hay datos para este jugador");
        }
      }
      }

      if (mensaje.tipo === "Info") {

        if(mensaje.mesa === n_mesa  ){
                
        if (mensaje.mensaje) {
          var msg_dato= mensaje.mensaje;
          logChat(msg_dato);
          console.log(msg_dato);
          
        } else {
          console.warn("No hay datos para este jugador");
        }
      }
      }
      
      if (mensaje.tipo === "Chat") {

        if(mensaje.mesa === n_mesa  ){
                
        if (mensaje.mensaje) {
          var msg_dato=mensaje.jugador + " : " + mensaje.mensaje;
          logChat(msg_dato);
          console.log(msg_dato);
          
        } else {
          console.warn("No hay datos para este jugador");
        }
      }
      }


      if (mensaje.tipo === "Habla") {
        
        if(mensaje.mesa === n_mesa  ){
                
        if (mensaje.mensaje) {
          var t_box="T"+mensaje.Nro_jugador;
          var msg_dato=mensaje.mensaje;
          ponerHabla(msg_dato,t_box);
          console.log(msg_dato);
          logChat(msg_dato);
          
        } else {
          console.warn("No hay datos para este jugador");
        }
      }
      }

      if (mensaje.tipo === "UnirseMesa") {

        if(mensaje.mesa === n_mesa){
                
        if (mensaje.jugador) {
          //console.log("carta:"+mensaje.carta+"   Jugador:"+mensaje.jugador);
          $(Id_jugada[mensaje.jugador-1]).attr("src",Img_carta[mensaje.carta]);
        } else {
          console.warn("No hay datos para este jugador");
        }
      }
      }




	};
		socket.onclose   = function(msg) { 
							   logChat("Desconectado - Estatus "+this.readyState); 
						   };
	}
	catch(ex){ 
		logChat(ex); 
	}
	
}

function PonerStsJugador(nombre_mesa,sts_mesa){

  var pos="";
  var n_mesa_actual=document.getElementById("name_mesa").innerHTML;
  console.log(nombre_mesa);
  console.log(n_mesa_actual);
  console.log(sts_mesa);
  //alert (pos);
  //alert (name_mesa);
if(nombre_mesa==n_mesa_actual)
    for(var k=1;k<6;k++)
    {
    pos="name_j"+k;
    console.log(pos,sts_mesa[k-1]);
    if(sts_mesa[k-1]==0)
      document.getElementById(pos).style.backgroundColor="BLUE";
    else
      document.getElementById(pos).style.backgroundColor="GREEN";

    }

  /*
  var color=document.getElementById(pos).style.backgroundColor;
  

  if(color == "blue"){
    //console.log("Bien"+color);
    document.getElementById(pos).style.backgroundColor="green";
    var msg= name_jugador + " Se unió a " + name_mesa;
    var datos = {"mesa":name_mesa,"tipo":'Unirse',"jugador": name_jugador,"mensaje": msg,"posicion":pos_mesa};
    conn.send(JSON.stringify(datos));
  } 
  else{
    //console.log("mal"+color);
    document.getElementById(pos).style.backgroundColor="blue";
    var msg= name_jugador + " Salio de " + name_mesa;
    var datos = {"mesa":name_mesa,"tipo":'Salirse',"jugador": name_jugador,"mensaje": msg,"posicion":pos_mesa};
    conn.send(JSON.stringify(datos)); 
  }
  */
}
/*
const botonM = document.getElementById("Mezclar"); // Selecciona el elemento HTML

botonM.addEventListener("click", function() { // Asigna el evento 'click' a la función anónima
  Mezclar();
});

window.addEventListener("DOMContentLoaded", () => {
  // Initialize the UI.
  const mesa = document.querySelector("#capa_B");
  //createBoard(mesa);
  // Open the WebSocket connection and register event handlers.
  //const websocket = new WebSocket("ws://localhost:8001/");
  //initGame(websocket);
  //receiveMoves(board, websocket);
  //sendMoves(board, websocket);
});
*/

