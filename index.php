<?php

include("menu_bs.php");
echo'
<style> 
.HDR{
  padding-right: 20px;
  border-radius: 5px;
  border-style: solid;
  border-width: 0px;
  text-align: center;
  color: blue;
  font-size: 25px;
  background-color: rgba(128, 128, 0, 0.3);
}
.HDRH{
  visibility: visible;
}
.NOMBRE{
  padding: 5px;
  border-radius: 5px;
  border-style: solid;
  border-width: 0px;
  text-align: center;
  color: white;
  font-size: 18px;
  background-color: rgba(128, 0, 128, 0.3);
}
.NJ {
  width: 75px;
  height: 100px;
  transition: width 1s, height 1s;
}
.CJ {
  width: 75px;
  height: 100px;
}

.NJ:hover {
  width: 90px;
  height: 120px;
}
.boton {
  background-color: #008CBA;
  border: none;
  color: white;
  padding: 10px 10px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 2px 2px;
  cursor: pointer;
}
#MESAS {
  padding-left: 20px;	
}
#HDR_MESAS {
  padding-left: 20px;
  border-radius: 5px;
  border-style: solid;
  border-width: 2px;
  background-color: rgba(0, 255, 0, 0.3);
}

</style>';

echo '
<script>
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

let Id_naipes_0 = new Array("#NJ1","#NJ2","#NJ3","#NJ4","#NJ5","#NJ6","#NJ7","#NJ8");
let Id_naipes_1 = new Array("NJ1","NJ2","NJ3","NJ4","NJ5","NJ6","NJ7","NJ8");

let Id_jugada = new Array("#N1","#N2","#N3","#N4","#N5");

var conn = new WebSocket("ws://localhost:9069");

$(document).ready(function(){

conn.onopen = function (event){
    console.log("Conectado");
};

conn.onmessage = function (event){
   var respuesta = JSON.parse(event.data);
   if(respuesta.numerocarta != undefined || respuesta.imagen != undefined)
   {
   console.log("numerocarta: " + respuesta.numerocarta + " imagen: " + respuesta.imagen);
   var cartaelegida = respuesta.numerocarta;
    switch(cartaelegida)
    {
      case "N1":
        $("#N1").attr("src",respuesta.imagen);
        break;
      case "N2":
        $("#N2").attr("src",respuesta.imagen);
        break;
      case "N3":
        $("#N3").attr("src",respuesta.imagen);
        break;
      case "N4":
        $("#N4").attr("src",respuesta.imagen);
        break;
      case "N5":
        $("#N5").attr("src",respuesta.imagen);
        break;
    }
  }
};

  $(".ver_cartas_jugador").click(function(){
  	var p=LLAMATRES.select_player.selectedIndex;
  	var j= p+1;
    
    var nj; 
  	document.cookie = "NJ="+encodeURIComponent(j)+";secure";
    nj = readCookie("NJ");
  	//alert(nj);
  	//alert(j);
  	for(var i=1 ;i< 9;i++)
    $(Id_naipes_0[i-1]).replaceWith(\'<img id="\'+Id_naipes_1[i-1]+ \'" onClick="jugar_carta(\'+ i + \');ocultarElem(this);" class="NJ"  src="\'+ Img_carta[Player[p][i-1]] +\'" >\');
   });

   

  });


function jugar_carta(nro_carta){

  	var nj = readCookie("NJ");
    //alert(nj);
  	
  	$(Id_jugada[nj-1]).attr("src",Img_carta[Player[nj-1][nro_carta-1]]);

  	switch(nj){
    case "1": 
    var imagen = Img_carta[Player[nj-1][nro_carta-1]];
    var carta = "N1";
    var datos = {"numerocarta": carta,"imagen": imagen};
     cambio = $("#N1").attr("src",Img_carta[Player[nj-1][nro_carta-1]]);
     conn.send(JSON.stringify(datos));
     break;
    case "2": 
      var imagen = Img_carta[Player[nj-1][nro_carta-1]];
      var carta = "N2";
      var datos = {"numerocarta": carta,"imagen": imagen};
     cambio = $("#N2").attr("src",Img_carta[Player[nj-1][nro_carta-1]]);
     conn.send(JSON.stringify(datos));
     break;
    case "3": 
      var imagen = Img_carta[Player[nj-1][nro_carta-1]];
      var carta = "N3";
      var datos = {"numerocarta": carta,"imagen": imagen};
     cambio = $("#N3").attr("src",Img_carta[Player[nj-1][nro_carta-1]]);
     conn.send(JSON.stringify(datos));
     conn.send("HOLA??");
     break;  
    case "4": 
      var imagen = Img_carta[Player[nj-1][nro_carta-1]];
      var carta = "N4";
      var datos = {"numerocarta": carta,"imagen": imagen};
     cambio = $("#N4").attr("src",Img_carta[Player[nj-1][nro_carta-1]]);
     conn.send(JSON.stringify(datos));
     break;
    case "5": 
      var imagen = Img_carta[Player[nj-1][nro_carta-1]];
      var carta = "N5";
      var datos = {"numerocarta": carta,"imagen": imagen};
     cambio = $("#N5").attr("src",Img_carta[Player[nj-1][nro_carta-1]]);
     conn.send(JSON.stringify(datos));
     break;    
    default:
    console.log(nj); 

    }
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
    $(Id_naipes_0[i-1]).replaceWith(\'<img id="\'+Id_naipes_1[i-1]+ \'" class="CJ" src="images/atras.jpg" >\');	
//for (var i=0 ; i<8 ; i++){
// document.images[i].src="images/atras.jpg";
/*    
 $("#NJ1").replaceWith(\'<img id="NJ1" src="images/atras.jpg" width="60" height="80">\');
 $("#NJ2").replaceWith(\'<img id="NJ2" src="images/atras.jpg" width="60" height="80">\');
 $("#NJ3").replaceWith(\'<img id="NJ3" src="images/atras.jpg" width="60" height="80">\');
 $("#NJ4").replaceWith(\'<img id="NJ4" src="images/atras.jpg" width="60" height="80">\');
 $("#NJ5").replaceWith(\'<img id="NJ5" src="images/atras.jpg" width="60" height="80">\');
 $("#NJ6").replaceWith(\'<img id="NJ6" src="images/atras.jpg" width="60" height="80">\');
 $("#NJ7").replaceWith(\'<img id="NJ7" src="images/atras.jpg" width="60" height="80">\');
 $("#NJ8").replaceWith(\'<img id="NJ8" src="images/atras.jpg" width="60" height="80">\');
 */
 //document.write(Img_carta[i]);
 //}
}

function VerCartas(){
var j=LLAMATRES.select_player.selectedIndex;
//var selec=form.sel_img.options;
//form.Imagen.value=selec[i].text;

/*
for (var i=0 ; i<8 ; i++){
 document.images[i].src=Img_carta[Player[j][i]];
}
*/ 
}

function Mezclar()
{
// C cartas que quedan arriba en el corte
var C = 0;
var L1 = 0 ;
var M = 0 ;
var i, j, k;
var Aux = new Array(40);

initArray();
TaparCartas();
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
/*
Text1.Text = M
List1.Clear
For i = 0 To 39
List1.AddItem Img_carta(Cartas(i))
Next
*/
}

function Cortar()
{
// C cartas que quedan arriba en el corte
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
var i, j, k , l;
var Aux = new Array(40);

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


}


</script>
';
?>

<div class="container-fluid" >
	<div class="row">
	 
	  <div class="col-sm-3" id="capa_A">
		  <H3>CAPA A</H3>
		  <H4>LLAMATRES</H4><br>
		  <div id="capa_n"></div>
	  </div>
	  
	  <div class="col-sm-6" div id="capa_B">
		  
	  	

<table border="1" width="95%" cellspacing="0" cellpadding="0" height="319">
  <tr>
    <td width="6%" height="66" valign="top"> </td>
    <td width="20%" height="66">&nbsp;&nbsp;&nbsp; <input type="text" name="T1" size="11"><img class="CJ" id="N1" src="images/atras.jpg" ><span class="badge">1</span><span class="NOMBRE" id="name_j1"></span>
    </td>
    <td width="40%" colspan="2" height="66">
      <div class="HDR" id="name_mesa"></div>
      <span class="HDRH" id="nro_mesa"></span>
      <span class="HDRH" id="id_jugador"></span>
      <span class="HDRH" id="pos_jugador"></span>
    </td>
    
  </tr>
  <tr>
    <td width="6%" height="253" valign="top" rowspan="2">&nbsp;
      <p><input type="text" name="T2" size="12"><img class="CJ" id="N2" src="images/atras.jpg" ><span class="badge">2</span><span class="NOMBRE" id="name_j2"></span></p>
      <p>&nbsp;</p>
      <p>&nbsp; <input type="text" name="T3" size="12"><img class="CJ" id="N3" src="images/atras.jpg" ><span class="badge">3</span><span class="NOMBRE" id="name_j3"></span></td>
    <td width="20%" height="187" ><img src="images/mesa.gif" width="281" height="276" align="absmiddle">
    </td>
    
    <td width="6%" valign="top">
      <p>&nbsp;&nbsp; <input type="text" name="T5" size="12"></p>
      <p>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <img class="CJ" id="N5" src="images/atras.jpg" ><span class="badge">5</span><span class="NOMBRE" id="name_j5"></span>
      </p>
      <p>&nbsp;</p>
      <p>&nbsp;</td>

       	
     <td width="34%" height="1" valign="top">
      
    </td> 
    	
  
  </tr>
  <tr>
    <td width="32%" height="66" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="T4" size="13"><img class="CJ" id="N4" src="images/atras.jpg" ><span class="badge">4</span><span class="NOMBRE" id="name_j4"></span>
    </td>
    <td></td>
  </tr>
</table>

	
	  </div>
    <div class="col-sm-3" >
    <div class="row">
	  	<div id="capa_M">
      <div id="HDR_MESAS">	
     <H3 style="margin-top:2px;margin-bottom:2px;">MESAS ACTIVAS&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<a href="abrir_mesa.php"  data-toggle="modal" data-target="#myModal">+</a></H3>
     </div>
     <div id="MESAS">
     <table style="width:100%">
       <tr>
         <th>Nombre</th>
         <th>Estatus</th>
       </tr>
       <tr>
         <td>Beraza</td>
         <td>J</td>
      </tr>
      <tr>
         <td>Cacamo</td>
         <td>C</td>
      </tr>
      </table>
     </div>  

      </div>
    </div>
    <div class="row">
	  	<div id="capa_J"></div>
    </div>


	  </div>
	</div>
	
	<div class="row">  
	  <div class="col-sm-3" >
	  	<div id="capa_C"><H6>CAPA C</H6></div>
	  </div>
	  <H6>CAPA D</H6>
	  <div class="col-sm-9" id="capa_D">
<script>init_cartas();</script>	  	
<FORM NAME="LLAMATRES" >
    <table border="0" width="100%" cellspacing="0" cellpadding="0" height="1">
      <tr>
        <td width="90%" height="1" valign="top">
          <p style="margin-top: 0; margin-bottom: 0">
          <img onClick="jugar_carta(1)" class="NJ" id="NJ1" src="images/atras.jpg" width="60" height="80">
          <img class="NJ" id="NJ2" src="images/atras.jpg" onclick="ocultarElem(this)";> 
          <img class="NJ" id="NJ3" src="images/atras.jpg" >
          <img class="NJ" id="NJ4" src="images/atras.jpg" > 
          <img class="NJ" id="NJ5" src="images/atras.jpg" >
          <img class="NJ" id="NJ6" src="images/atras.jpg" > 
          <img class="NJ" id="NJ7" src="images/atras.jpg" >
          <img class="NJ" id="NJ8" src="images/atras.jpg" >
        </td>
        <td height="120px">
          <p style="margin-top: 0; margin-bottom: 0"> <select  name="select_player">
		      <option class="ver_cartas_jugador">1</option>
		      <option class="ver_cartas_jugador">2</option>
		      <option class="ver_cartas_jugador">3</option>
		      <option class="ver_cartas_jugador">4</option>
		      <option class="ver_cartas_jugador">5</option>
		      </select>
		</td>

	    <td height="120px"><INPUT class="boton" TYPE="button" VALUE="Mezclar" onClick="Mezclar()"></td>
	    <td height="120px"><INPUT class="boton" TYPE="button" VALUE="Cortar" onClick="Cortar()"></td>
	    <td height="120px"><INPUT class="boton" TYPE="button" VALUE="Repartir" onClick="Repartir()"></td>
	     </tr>
    </table>
</FORM>



	  </div>

	</div>
 </div>
 



<?php
echo "<script>";
echo "cargar('#capa_M','mesas_activas.php');";
echo "</script>";
echo "<script>";
//echo "cargar('#capa_B','mesa.html');";
echo "</script>";
echo "<script>";
//echo "cargar('#capa_D','llamatres.html');";
echo "</script>";
?>

