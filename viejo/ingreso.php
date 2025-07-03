<?
  //  Autentificator
  //  Gestión de Usuarios PHP+Mysql+sesiones
  //  by Pedro Noves V. (Cluster)
  //  clus@hotpop.com
  // ------------------------------------------
require("aut_verifica.inc.php");

require($HTTP_SERVER_VARS['DOCUMENT_ROOT']."/global.php");
$nivel_acceso=10; // Nivel de acceso para esta página.
  // se chequea si el usuario tiene un nivel inferior
  // al del nivel de acceso definido para esta página.
  // Si no es correcto, se mada a la página que lo llamo con
  // la variable de $error_login definida con el nº de error segun el array de
  // aut_mensaje_error.inc.php
if ($nivel_acceso <= $HTTP_SESSION_VARS['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}

function act_mesa($id_mesa,$id_usuario,$tipo) {
require("aut_config.inc.php");
#tipo=='u' ,unirse a la mesa , tipo=='s' salir de la mesa
$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la
Base de datos") or die(mysql_error());
mysql_select_db("$sql_db") or die(mysql_error());
}

?>
<script>
/*<---Pasando un valor de PHP a Javascript--->*/
top.user=<?print("'".$HTTP_SESSION_VARS['usuario_login']."'");?>;
top.id_user=<?print("'".$HTTP_SESSION_VARS['usuario_id']."'");?>;
</script>


<?
//pasando un valor de javascript a PHP , de la variable user
$user = "<script language=javascript>document.write(top.user);</script>";
if(isset($HTTP_GET_VARS['accion']) && $HTTP_GET_VARS['accion']=="unirse" && $HTTP_POST_VARS['nmesa']!=""){
//unirse a la mesa
$nmesa=$HTTP_POST_VARS['nmesa'];
$id_user=$HTTP_SESSION_VARS['usuario_id'];
act_mesa($nmesa,$id_user,'u');
$usuario_mesa=$nmesa;
}
?>
<html>
<head>
<SCRIPT LANGUAGE="JavaScript">
function poner_nro_mesa(form,nro)
{
form.nmesa.value="";
form.nmesa.value=nro;
top.mesa=nro;
top.loader.location.reload();
//top.push.location.reload();
//top.static.location.reload();
}
</SCRIPT>
<title>Ingreso Salas de LLamatres</title>
<style type="text/css">
<!--
.botones {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #000000; background-color: #0099FF; border-color: #000000 ; border-top-width: 1pix; border-right-width: 1pix; border-bottom-width: 1pix; border-left-width: 1pix}
.imputbox {  font-size: 10pt; color: #000099; background-color: #CCFFCC; font-family: Verdana, Arial, Helvetica, sans-serif; border: 1pix #000000 solid; border-color: #000000 solid; font-weight: normal}
.VM{ font-family: TAHOMA; font-weight:bold;font-size: 12pt; color: #F000FF; background-color: #FFFFFF; border-color: #000000 ; border-top-width: 0pix; border-right-width: 0pix; border-bottom-width: 0pix; border-left-width: 0pix}
.p1 {font-family: TAHOMA; font-size: 7pt; color: #F000FF;margin-top: 2; margin-bottom: 2}
-->
</style>
</head>

<body leftmargin="2" bgcolor="#999966" onLoad="window.resizeTo(100,200)">

<p align="left"><b><font size="2" face="Verdana" color="#0000FF">
<? echo $HTTP_SESSION_VARS['usuario_login'] ?><br>
</font></b></p>
<br>


<?
if ($HTTP_SESSION_VARS['usuario_nivel']==0){
echo <<< HTML
<p align="center"><font face="Verdana" color="#0000FF">
<b>
<table border="1" width="96%" bordercolor="#0000FF" cellspacing="0" cellpadding="0" bgcolor="#FFFFCC">
  <tr>
    <td width="60%" colspan="3">
      <p align="center">ADMINISTRADOR</td>
  </tr>
</b>
<td width="20%" align="left">
<a href="aut_gestion_usuarios.php" target="_blank">Gestionar usuarios</a>
</td>
</table>
<p>&nbsp;</p>
HTML;
}
?>

<?
if (!isset($HTTP_GET_VARS['Jugar']) && !isset($HTTP_GET_VARS['Salir']) && $HTTP_SESSION_VARS['usuario_nivel']>0){
echo <<< HTML
<form method="POST" name="mesas" action="$PHP_SELF?accion=unirse">
<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">

    <td width="40%" align="center" valign="middle">
    <p class="p1"><a onClick='poner_nro_mesa(mesas,"1");' href="mesa.php?accion=ver&id=1" target="f_mesa"><b><font face="Verdana" size="2" >mesa 1</b></a></p>
    <p class="p1"><a onClick='poner_nro_mesa(mesas,"2");' href="mesa.php?accion=ver&id=2" target="f_mesa"><b><font face="Verdana" size="2" >mesa 2</b></a></p>
    <p class="p1"><a onClick='poner_nro_mesa(mesas,"3");' href="mesa.php?accion=ver&id=3" target="f_mesa"><b><font face="Verdana" size="2" >mesa 3</b></a></p>
    <p class="p1"><a onClick='poner_nro_mesa(mesas,"4");' href="mesa.php?accion=ver&id=4" target="f_mesa"><b><font face="Verdana" size="2" >mesa 4</b></a></p>

    </td>


</table>


 <p>
 <input  name="nmesa" type="text" size="4"  value=""  class="VM"></p>
 <p><input type="Submit" value=" Jugar " name="Jugar" class="botones"></p>
 <p><input type="button" value="  Salir  " name="Salir" class="botones"></p>
 </form>

HTML;
}
?>

</b>
</font>

</body>
</html>
