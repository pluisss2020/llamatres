<?
require("aut_verifica.inc.php"); // incluir motor de autentificaci�n.
$nivel_acceso=0; // definir nivel de acceso para esta p�gina.
if ($nivel_acceso < $HTTP_SESSION_VARS['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}

require ("aut_config.inc.php"); // incluir configuracion.
$pag=$HTTP_SERVER_VARS['PHP_SELF'];  // el nombre y ruta de esta misma p�gina.

function cabeceraHTML(){
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

<body bgcolor="#FFFFFF" onLoad="window.resizeTo(800,300)">

HTML;
}


if (isset($HTTP_GET_VARS['error'])){

$error_accion_ms[0]= "No se puede borrar el Usuario, debe existir por lo menos uno.<br>Si desea borrarlo, primero cree uno nuevo.";
$error_accion_ms[1]= "Faltan Datos.";
$error_accion_ms[2]= "Passwords no coinciden.";
$error_accion_ms[3]= "El Nivel de Acceso debe ser num�rico.";
$error_accion_ms[4]= "El Usuario ya est� registrado.";

$error_cod = $HTTP_GET_VARS['error'];
echo "<div align='center'>$error_accion_ms[$error_cod]</div><br>";

}

$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
mysql_select_db("$sql_db") or die(mysql_error());

if (!isset($HTTP_GET_VARS['accion'])){

$usuario_consulta = mysql_query("SELECT ID,usuario,nivel_acceso FROM $sql_tabla") or die("No se pudo realizar la consulta a la Base de datos");

cabeceraHTML();

echo <<< HTML
<table width="300" border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" align="center">
  <tr>
    <td colspan="4" bgcolor="#0099FF">
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><font color="#FFFFFF">.:
        Gesti&oacute;n Usuarios :.</font></b></font><br>
        <a href="aut_logout.php">LogOut (salir)</a>
        </div>
    </td>
  </tr>
  <tr bgcolor="#00CCCC">
    <td width="5%">
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">ID
        </font></b></div>
    </td>
    <td width="10%">
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">Usuario
        </font></b></div>
    </td>
    <td width="5%">
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">Nivel
        </font></b></div>
    </td>
    <td width="55%" bgcolor="#CCFFCC">
    <div align="center"><font color="#FFFFFF"><a href="$pag?accion=nuevo">Registrar usuario</a></font></div></td>
  </tr>

HTML;

while($resultados = mysql_fetch_array($usuario_consulta)) {

echo <<< HTML
<tr>
    <td width="10%" bgcolor="#FFFFEA"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">$resultados[ID]</font></div></td>
    <td width="25%" bgcolor="#FFFFEA"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">$resultados[usuario]</font></div></td>
    <td width="10%" bgcolor="#FFFFEA"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">$resultados[nivel_acceso]</font></div></td>
    <td width="55%" bgcolor="#CCFFCC">
      <div align="center">
         <a href="$pag?accion=borrar&id=$resultados[ID]"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Borrar</font></a><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        | <a href="$pag?accion=nivel&id=$resultados[ID]">Nivel acceso</a></font>
        | </td>
  </tr>
HTML;
}
echo "</table>";
mysql_free_result($usuario_consulta);
mysql_close();
}

if (isset($HTTP_GET_VARS['id'])){

if ($HTTP_GET_VARS['accion']=="borrar"){
$usuarios_consulta = mysql_query("SELECT ID FROM $sql_tabla") or die(mysql_error());
$total_registros = mysql_num_rows ($usuarios_consulta);
mysql_free_result($usuarios_consulta);

if ($total_registros == 1){
header ("Location: $pag?error=0");
exit;
}

$id_borrar= $HTTP_GET_VARS['id'];
mysql_query("DELETE FROM $sql_tabla WHERE id=$id_borrar") or die(mysql_error());
mysql_close();

header ("Location: $pag");
exit;

}

if ($HTTP_GET_VARS['accion']=="nivel"){

cabeceraHTML();

$id_mod_nivel= $HTTP_GET_VARS['id'];
$usuario_consulta = mysql_query("SELECT ID,usuario,nivel_acceso FROM $sql_tabla WHERE id=$id_mod_nivel") or die("No se pudo realizar la consulta a la Base de datos");

while($resultados = mysql_fetch_array($usuario_consulta)) {

echo <<< HTML
<form method="post" action="$pag?accion=editarnivel">
<input type="hidden" name="id" value="$resultados[ID]">
<table width="399" border="1" cellspacing="0" cellpadding="4" align="center">
    <tr>
      <td colspan="2" height="30" bgcolor="#0099FF">
        <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">.:
          Modificar Nivel Acceso Usuario :.</font></b></div>
      </td>
    </tr>
    <tr bgcolor="#FFFFCC">
      <td width="185">
        <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Usuario
          : </font></div>
      </td>
      <td width="192"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#0000CC">$resultados[usuario]</font>
        </font></b></td>
    </tr>
    <tr bgcolor="#FFFFCC">
      <td width="185"><div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nivel
        Acceso actual : </font></div></td>
      <td width="192"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#0000CC">$resultados[nivel_acceso]</font>
        </font></b></td>
    </tr>
    <tr bgcolor="#FFFFCC">
      <td width="185">
        <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nuevo
          Nivel de Acceso : </font></div>
      </td>
      <td width="192"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="nuevonivelacceso" class="imputbox" size="4" maxlength="4">
        </font></b></td>
    </tr>
    <tr bgcolor="#FFFFCC">
      <td colspan="2" height="40">
        <div align="center">
          <input type="submit" name="Submit" value="  Actualizar  " class="botones" >
        </div>
      </td>
    </tr>
  </table>
</form>
HTML;
}
mysql_free_result($usuario_consulta);
mysql_close();
}

//AGREGADO
//FIN AGREGADO


}


if ($HTTP_GET_VARS['accion']=="editarnivel"){

$id=$HTTP_POST_VARS['id'];
$nivelnuevo=$HTTP_POST_VARS['nuevonivelacceso'];

if ($nivelnuevo==""){
header ("Location: $pag?accion=nivel&id=$id&error=1");
exit;
}

mysql_query("UPDATE $sql_tabla SET nivel_acceso='$nivelnuevo' WHERE ID=$id") or die(mysql_error());
mysql_close ();
header ("Location: $pag");
exit;
}

//AGREGADO
//FIN AGREGADO

if ($HTTP_GET_VARS['accion']=="nuevo"){

cabeceraHTML();

echo <<< HTML
<form method="post" action="$PHP_SELF?accion=hacernuevo">

  <table width="350" border="1" cellspacing="0" cellpadding="4" align="center">
    <tr>
      <td colspan="2" height="30" bgcolor="#0099FF">
        <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">.:
          Registro de Usuarios :.</font></b></div>
      </td>
    </tr>
    <tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Usuario
          : </font></div>
      </td>
      <td width="170"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="usuarionombre" class="imputbox" maxlength="15">
        </font></b></td>
    </tr>
    <tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password
          : </font></div>
      </td>
      <td width="170"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="password" name="password1" class="imputbox" maxlength="15">
        </font></b></td>
    </tr>
    <tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password
          (repitalo) : </font></div>
      </td>
      <td width="170"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="password" name="password2" class="imputbox" maxlength="15">
        </font></b></td>
    </tr>
    <tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nivel
          de Acceso : </font></div>
      </td>
      <td width="270"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="nivelacceso" class="imputbox" size="4" maxlength="4">
        </font></b></td>
    </tr>
    
    <tr bgcolor="#FFFFCC">
      <td width="158">
        <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Vendedor </font></div>
      </td>
      <td width="270"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
        <input type="text" name="vendedor" class="imputbox" size="4" maxlength="4">
        </font></b></td>
    </tr>
    
    <tr bgcolor="#FFFFCC">
      <td colspan="2" height="40">
        <div align="center">
          <input type="submit" name="Submit" value="  Registrar  " class="botones" >
        </div>
      </td>
    </tr>
  </table>
</form>
HTML;
}

if ($HTTP_GET_VARS['accion']=="hacernuevo"){

$usuario=$HTTP_POST_VARS['usuarionombre'];
$pass1=$HTTP_POST_VARS['password1'];
$pass2=$HTTP_POST_VARS['password2'];
$nivel=$HTTP_POST_VARS['nivelacceso'];


if ($pass1=="" or $pass2=="" or $usuario=="" or $nivel=="") {
header ("Location: $pag?accion=nuevo&error=1");
exit;
}

if ($pass1 != $pass2){
header ("Location: $pag?accion=nuevo&error=2");
exit;
}

if (!eregi("[0-9]",$nivel)){
header ("Location: $pag?accion=nuevo&error=3");
exit;
}

$usuarios_consulta = mysql_query("SELECT ID FROM $sql_tabla WHERE usuario='$usuario'") or die(mysql_error());
$total_encontrados = mysql_num_rows ($usuarios_consulta);
mysql_free_result($usuarios_consulta);

if ($total_encontrados != 0) {
header ("Location: $pag?accion=nuevo&error=4");
exit;
}

$usuario=stripslashes($usuario);
$pass1 = md5($pass1);
mysql_query("INSERT INTO $sql_tabla values('','$usuario','$pass1','$nivel','','')") or die(mysql_error());
mysql_close();

header ("Location: $pag");
exit;


}

?>
</BODY>
</HTML>

