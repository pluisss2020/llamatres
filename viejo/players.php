<?
//require("aut_verifica.inc.php"); // incluir motor de autentificación.
$nivel_acceso=10; // definir nivel de acceso para esta página.

if ($nivel_acceso < $HTTP_SESSION_VARS['usuario_nivel']){
  header ("Location: $redir?error_login=5");exit;
}


require ("aut_config.inc.php"); // incluir configuracion.
$pag=$HTTP_SERVER_VARS['PHP_SELF'];  // el nombre y ruta de esta misma página.

function PlayersHTML(){
echo <<< HTML
<html>
 <head>
  <title>Jugando LLamatres</title>
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
$error_accion_ms[0]= "error 0";
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
<p><b><font face="Verdana">Jugadores</font></b></p>
HTML;

//CARGAR Jugadores MESA 1

$pedido_consulta = mysql_query("SELECT ID_user,usuario,status FROM $sql_tabla_logs WHERE sala='1' ") or die("No se pudo realizar la consulta a la Base de datos");
while($resultados = mysql_fetch_array($pedido_consulta)) {
if ($resultados[status]==1)
echo <<< HTML
    <p><b>$resultados[usuario]</b></p>
HTML;
if ($resultados[status]==0)
echo <<< HTML
    <p>$resultados[usuario]</p>
HTML;
}

mysql_free_result($pedido_consulta);
mysql_close();
}


?>
</BODY>
</HTML>
