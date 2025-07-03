<?
require("aut_verifica.inc.php"); // incluir motor de autentificación.
$nivel_acceso=5; // definir nivel de acceso para esta página.

if ($nivel_acceso < $HTTP_SESSION_VARS['usuario_nivel']){
  header ("Location: $redir?error_login=5");exit;
}

require ("aut_config.inc.php"); // incluir configuracion.
$pag=$HTTP_SERVER_VARS['PHP_SELF'];  // el nombre y ruta de esta misma página.

function PedidoHTML(){
echo <<< HTML
<html>
 <head>
  <title>Usuarios - www.felino-hnos.com.ar</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <style type="text/css">
  <!--
 .botones {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #0099FF; border-color: #000000 ; border-top-width: 1pix; border-right-width: 1pix; border-bottom-width: 1pix; border-left-width: 1pix}
 .imputbox {  font-size: 10pt; color: #000099; background-color: #FFFFFF; font-family: Verdana, Arial, Helvetica, sans-serif; border: 1pix #000000 solid; border-color: #000000 solid; font-weight: normal}
 A:VISITED  { font-weight: normal; color: #0000CC; TEXT-DECORATION:none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt}
 A:LINK     { font-weight: normal; color: #0000CC; TEXT-DECORATION:none; font-family: Verdana, Arial, Helvetica, sans-serif; border-color: #33FF33 #66FF66; clip:  rect(   ); font-size: 10pt}
 A:ACTIVE   { font-weight: normal; color: #FF3333; TEXT-DECORATION:none; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10pt}
 A:HOVER    { font-weight: normal; color: #0000CC; font-family: Verdana, Arial, Helvetica, sans-serif;  font-weight: normal; text-decoration: underline; font-size: 10pt}
-->
 </style>
 </head>
 <body bgcolor="#FFFFFF">
HTML;
}
//si hay error
if (isset($HTTP_GET_VARS['error'])){
//definir variable mensajes de error
$error_accion_ms[0]= "No se puede borrar el Usuario, debe existir por lo menos uno.<br>Si desea borrarlo, primero cree uno nuevo.";
//si hay error mostrar el mensaje
$error_cod = $HTTP_GET_VARS['error'];
 echo "<div align='center'>$error_accion_ms[$error_cod]</div><br>";
}

//conexion a la base de datos
$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
mysql_select_db("$sql_db") or die(mysql_error());

//si no hay ninguna accion definida
if (!isset($HTTP_GET_VARS['accion'])){
echo <<< HTML
<p><b><font face="Verdana">FELINO HNOS - LISTA DE PRECIOS PARCIAL</font></b></p>
HTML;

//CARGAR RUBROS
echo <<< HTML
<form method="POST" action="$PHP_SELF?accion=listar">

<p>RUBRO <select size="1" name="sel_rubro">
HTML;
echo <<< HTML
  <option></option>
HTML;
$pedido_consulta = mysql_query("SELECT DISTINCT rubro FROM $sql_tabla_art ORDER by rubro") or die("No se pudo realizar la consulta a la Base de datos");
while($resultados = mysql_fetch_array($pedido_consulta)) {  
echo <<< HTML
    <option>$resultados[rubro]</option>
HTML;
}

//CARGAR SUBRUBRO
echo <<< HTML
  </select></p>
  <p>SUBRUBRO <select size="1" name="sel_subrubro">
HTML;
echo <<< HTML
  <option></option>
HTML;
$pedido_consulta = mysql_query("SELECT DISTINCT subrubro FROM $sql_tabla_art ORDER by subrubro") or die("No se pudo realizar la consulta a la Base de datos");
while($resultados = mysql_fetch_array($pedido_consulta)) {    
echo <<< HTML
  <option>$resultados[subrubro]</option>
HTML;
}  

echo <<< HTML
  &nbsp;
  </select> 
  <input type="submit" value="Listar" name="listar"></p>
</form>
HTML;


mysql_free_result($pedido_consulta);
mysql_close();
}


//si accion listar subrubro
if ($HTTP_GET_VARS['accion']=="listar" && $HTTP_POST_VARS['sel_subrubro']!=""){
pedidoHTML();
//conexion a la base de datos
$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
mysql_select_db("$sql_db") or die(mysql_error());

$selsubrubro=$HTTP_POST_VARS['sel_subrubro'];

$pedido_consulta = mysql_query("SELECT * FROM $sql_tabla_art WHERE subrubro='$selsubrubro' ") or die("No se pudo realizar la consulta a la Base de datos");


echo <<< HTML


<p><b><font face="Verdana">FELINO HNOS - LISTA DE PRECIOS PARCIAL </font></b></p>
<p><b><font face="Verdana">$selsubrubro </font></b></p>
HTML;



echo <<< HTML
<table border="1" width="100%" bgcolor="#00FFFF" cellspacing="0" cellpadding="0">
  <tr>
    <td width="15%"><b><font face="Verdana">CODIGO</font></b></td>
    <td width="32%"><b><font face="Verdana">SUBRUBRO</font></b></td>
    <td width="39%"><b><font face="Verdana">ARTICULO</font></b></td>
    <td width="14%"><b><font face="Verdana">PRECIO</font></b></td>
  </tr>
<font face="Verdana" size="2">
HTML;

while($resultados = mysql_fetch_array($pedido_consulta)) {  
$precio=number_format($resultados["precio"]*1.21,2);
echo <<< HTML
  <tr>
    <td width="15%"><font face="Verdana" size="1">$resultados[cod]</font></td>
    <td width="32%"><font face="Verdana" size="1">$resultados[subrubro]</font></td>
    <td width="39%"><font face="Verdana" size="1">$resultados[descripcion]</font></td>
    <td width="14%" align="right"><font face="Verdana" size="1">$precio</font></td>
  </tr>
HTML;
}
exit;
}

if ($HTTP_GET_VARS['accion']=="listar" && $HTTP_POST_VARS['sel_rubro']!=""){
$sub_ant="";
$sub="";
pedidoHTML();
//conexion a la base de datos
$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
mysql_select_db("$sql_db") or die(mysql_error());

$selrubro=$HTTP_POST_VARS['sel_rubro'];

$pedido_consulta = mysql_query("SELECT subrubro,cod,descripcion,precio FROM $sql_tabla_art WHERE rubro='$selrubro' order by subrubro ") or die("No se pudo realizar la consulta a la Base de datos");


echo <<< HTML
<p><b><font face="Verdana">FELINO HNOS - LISTA DE PRECIOS PARCIAL </font></b></p>
HTML;

echo $selrubro;

echo <<< HTML
<table border="1" width="100%" bgcolor="#00FFFF" cellspacing="0" cellpadding="0">
  <tr>
    <td width="33%"><b><font face="Verdana">SUBRUBRO</font></b></td>
    <td width="12%"><b><font face="Verdana">CODIGO</font></b></td>
    <td width="41%"><b><font face="Verdana">ARTICULO</font></b></td>
    <td width="14%" align="right"><b><font face="Verdana" >PRECIO</font></b></td>
  </tr>
<font face="Verdana" size="2">
HTML;

while($resultados = mysql_fetch_array($pedido_consulta)) {  

if($resultados["subrubro"]==$sub_ant)
 $sub="";
else
 $sub=$resultados["subrubro"];
 $precio=number_format($resultados["precio"]*1.21,2);
echo <<< HTML
  <tr>
    <td width="33%"><font face="Verdana" size="2">$sub</font></td>
    <td width="12%"><font face="Verdana" size="2">$resultados[cod]</font></td>
    <td width="41%"><font face="Verdana" size="2">$resultados[descripcion]</font></td>
    <td width="14%" align="right"><font face="Verdana" size="2" >$precio</font></td>
  </tr>
HTML;
$sub_ant=$resultados["subrubro"];
}
echo <<< HTML
</table>
HTML;
mysql_free_result($pedido_consulta);
mysql_close();
}
//fin accion listar

echo("<br><br><b><font face=Verdana><a href=pag1_restringido.php>Salir</a></b></font>");
exit;
?>
</BODY>
</HTML>

