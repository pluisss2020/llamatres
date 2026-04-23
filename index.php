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
  background-color: #0000FF;
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
#capa_A{
/*background-color: rgba(167, 103, 43, 0.99);
border:1px solid #0f1010cf;*/
}
#capa_B{
/*background-color: rgba(162, 162, 150, 0.95);
border:1px solid #0f1010cf;*/
}
#capa_D{
background-color: rgba(167, 168, 149, 0.84);
border:1px solid #0f1010cf;
}
#capa_E{
background-color: rgba(10, 33, 244, 0.95);
border:1px solid #0f1010cf;
} 
#capa_J{
/*background-color: rgba(89, 45, 39, 0.95);
border:1px solid #0f1010cf;*/
}
#capa_M{
/*background-color: rgba(228, 244, 10, 0.95);
border:1px solid #0f1010cf;*/
}


 

#HDR_MESAS {
  padding-left: 20px;
  border-radius: 5px;
  border-style: solid;
  border-width: 2px;
  background-color: rgba(0, 255, 0, 0.3);
}
#capa_COM {
	height:100%; 
	border:1px solid #7F9DB9; 
	overflow:auto;
  background-color:rgba(0, 255, 0, 0.72);
}
  #log_CHAT {
	width:400px; 
	height:350px; 
	border:1px solid #7F9DB9; 
  border-radius: 5px;
  background-color:white;
  overflow-y:auto;
  padding: 10px;
}
#msg_CHAT {
	width:300px;
  height:40px;
  border:1px solid #7F9DB9;
  border-radius: 5px;
  padding: 10px;
  }
</style>';


?>

<div class="container-fluid" >
	<div class="row">
	 
	  <div class="col-sm-3" id="capa_A">
		  <H3>LLAMATRES</H3>
		  <H4></H4><br>
		  <div id="capa_n">
          <div id="log_CHAT"></div>
          <input id="msg_CHAT" type="textbox" onkeypress="onkey(event)"/>
          <button onclick="sendChat()">Send</button>



      </div>
	  </div>
	  
	  <div class="col-sm-5" id="capa_B">
		  
	  	

<table border="1" width="95%" cellspacing="0" cellpadding="0" height="319">
  <tr>
    <td width="6%" height="66" valign="top"> </td>
    <td width="20%" height="66">&nbsp;&nbsp;&nbsp; <input type="text" name="T1" size="11" id="T1" onkeypress="J_habla(1,event)"><img class="CJ" id="N1" src="images/atras.jpg" ><span class="badge">1</span><span class="NOMBRE" id="name_j1" style="background-color: blue;"></span>
    </td>
    <td width="40%" colspan="2" height="66">
      <div class="HDR" id="nombre_jugador"></div>
      <div class="HDR" id="name_mesa"></div>
      <span class="HDRH" id="msj_ws"></span>
      <span class="HDRH" id="nro_mesa"></span>
      <span class="HDRH" id="id_jugador"></span>
      <span class="HDRH" id="pos_jugador"></span>
      <span class="HDRH" id="cant_jugadores"></span>
      <span class="HDRH" id="log"></span>
    </td>
    
  </tr>
  <tr>
    <td width="6%" height="253" valign="top" rowspan="2">&nbsp;
      <p><input type="text" name="T2" size="12"><img class="CJ" id="N2" src="images/atras.jpg" ><span class="badge">2</span><span class="NOMBRE" id="name_j2" style="background-color: blue;"></span></p>
      <p>&nbsp;</p>
      <p>&nbsp; <input type="text" name="T3" size="12"><img class="CJ" id="N3" src="images/atras.jpg" ><span class="badge">3</span><span class="NOMBRE" id="name_j3" style="background-color: blue;"></span></td>
    <td width="20%" height="187" ><img src="images/mesa.gif" width="281" height="276" align="absmiddle">
    </td>
    
    <td width="6%" valign="top">
      <p>&nbsp;&nbsp; <input type="text" name="T5" size="12"></p>
      <p>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <img class="CJ" id="N5" src="images/atras.jpg" ><span class="badge">5</span><span class="NOMBRE" id="name_j5" style="background-color: blue;"></span>
      </p>
      <p>&nbsp;</p>
      <p>&nbsp;</td>

       	
     <td width="34%" height="1" valign="top">
      
    </td> 
    	
  
  </tr>
  <tr>
    <td width="32%" height="66" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="text" name="T4" size="13"><img class="CJ" id="N4" src="images/atras.jpg" ><span class="badge">4</span><span class="NOMBRE" id="name_j4" style="background-color: blue;"></span>
    </td>
    <td></td>
  </tr>
</table>

	
	  </div>
    
    
    <div class="col-sm-4" >
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
         <td></td>
         <td></td>
      </tr>
      <tr>
         <td></td>
         <td></td>
      </tr>
      </table>
     </div>  

      </div>
    </div>
    <div class="row">
	  	<div id="capa_J"></div>
    </div>
    <div class="row" id="capa_COM">COMANDOS</div>

	  </div>
	</div>
	
	<div class="row">  
	  <!---div class="col-sm-3" >
	  	<div id="capa_D"><H6>CAPA D</H6></div>
	  </div--->
	  <H6>CAPA E</H6>
	  <div class="col-sm-9" id="capa_E">
<!--script>init_cartas();</script-->	  	
<FORM NAME="LLAMATRES" >
    <table border="0" width="100%" cellspacing="0" cellpadding="0" height="1">
      <tr>
        <td width="90%" height="1" valign="top">
          <p style="margin-top: 0; margin-bottom: 0">
          <img class="NJ" id="NJ1" src="images/atras.jpg" width="60" height="80">
          <img class="NJ" id="NJ2" src="images/atras.jpg" > 
          <img class="NJ" id="NJ3" src="images/atras.jpg" >
          <img class="NJ" id="NJ4" src="images/atras.jpg" > 
          <img class="NJ" id="NJ5" src="images/atras.jpg" >
          <img class="NJ" id="NJ6" src="images/atras.jpg" > 
          <img class="NJ" id="NJ7" src="images/atras.jpg" >
          <img class="NJ" id="NJ8" src="images/atras.jpg" >
        </td>
        
      <td height="120px"><INPUT class="boton" id="btnIniciar" TYPE="button" VALUE="Iniciar Juego" onclick="Iniciar()"></td>
	    <td height="120px"><INPUT class="boton" id="btnMezclar" TYPE="button" VALUE="Mezclar" onclick="Mezclar()"></td>
	    <td height="120px"><INPUT class="boton" id="btnCortar" TYPE="button" VALUE="Cortar" onclick="Cortar()"></td>
	    <td height="120px"><INPUT class="boton" id="btnRepartir" TYPE="button" VALUE="Repartir" onclick="Repartir()"></td>
	    <?php
      if (isset($_SESSION['userid']))
       echo '<td height="120px"><INPUT class="boton" id="btnVer" TYPE="button" VALUE="Ver" onclick="VerCartas()"></td>';
      ?> 
	       
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
echo "<script>";
echo "init_cartas();";
echo "</script>";
echo "<script>";
echo "init_ws_client();";
echo "</script>";
//echo "<script>";
//echo 'import * as llamatres from "/bootstrap/js//llamatres.js";';
//echo "</script>";
?>

