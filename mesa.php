<?
require("aut_verifica.inc.php"); // incluir motor de autentificación.
$nivel_acceso=5; // definir nivel de acceso para esta página.
if ($nivel_acceso < $HTTP_SESSION_VARS['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}

require ("aut_config.inc.php"); // incluir configuracion.
$pag=$HTTP_SERVER_VARS['PHP_SELF'];  // el nombre y ruta de esta misma página.
$J1="";
$J2="";
$J3="";
$J4="";
$J5="";

?>
<?
function ver_mesa($cod_mesa,$id_player){
global $J1;
global $J2;
global $J3;
global $J4;
global $J5;
require ("aut_config.inc.php");


$nro_mesa=$cod_mesa;

$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
//cargar estado de la mesa
mysql_select_db("$sql_db") or die(mysql_error());
$estado_mesa = mysql_query("SELECT * FROM $sql_tabla_mesas WHERE Id_mesa=$cod_mesa ") or die("No se pudo realizar la consulta a la Base de datos");
$resultado = mysql_fetch_array($estado_mesa);

if( $resultado['id_mesa']!=""){
if($resultado['j1'])
  $J1=$resultado['j1'];
if($resultado['j2'])
  $J2=$resultado['j2'];
if($resultado['j3'])
  $J3=$resultado['j3'];
if($resultado['j4'])
  $J4=$resultado['j4'];
if($resultado['j5'])
  $J5=$resultado['j5'];

}
mysql_free_result($estado_mesa);
//poner al juagdor en la mesa
$stat="V";
mysql_query("UPDATE $sql_tabla SET en_mesa='$cod_mesa',status='$stat' Where ID=$id_player") or die(mysql_error());

mysql_close();

}

function ponerse_en_mesa($cod_mesa,$id_player){
global $J1;
global $J2;
global $J3;
global $J4;
global $J5;
require ("aut_config.inc.php");


$nro_mesa=$cod_mesa;

$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
//cargar estado de la mesa
mysql_select_db("$sql_db") or die(mysql_error());
$estado_mesa = mysql_query("SELECT * FROM $sql_tabla_mesas WHERE Id_mesa=$cod_mesa ") or die("No se pudo realizar la consulta a la Base de datos");
$resultado = mysql_fetch_array($estado_mesa);

for($k=0;$k<5;$k++){
  if(!$resultado[$k])
    break;
}
$puesto_libre=$k+1;
mysql_free_result($estado_mesa);
//poner al juagdor en la mesa
$stat="J";
mysql_query("UPDATE $sql_tabla SET en_mesa='$cod_mesa',status='$stat' WHERE ID=$id_player") or die(mysql_error());

mysql_close();

}

?>
<?
if($HTTP_GET_VARS['accion']=="ver" && isset($HTTP_GET_VARS['id'])){
//echo ("MESA " & $HTTP_GET_VARS['id']);
//echo $HTTP_GET_VARS['nom'];

$cod_mesa=$HTTP_GET_VARS['id'];
$id_player=$HTTP_SESSION_VARS['usuario_id'];
ver_mesa($cod_mesa,$id_player);
//buscar datos de la mesa
?>
<script>
top.static.location.reload();
</script>

<script>
top.mesa = <?echo $cod_mesa;?>
</script>

<?
echo <<< HTML
<html>

<head>
<title>
</title>
<style type="text/css">
<!--
.nameplayer {  font-size: 10pt; color: #000099; background-color: #CCFFCC; font-family: Verdana, Arial, Helvetica, sans-serif; border: 0pix #000000 solid; border-color: #000000 solid; font-weight: normal}
.botones {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #0099FF; border-color: #000000 ; border-top-width: 1pix; border-right-width: 1pix; border-bottom-width: 1pix; border-left-width: 1pix}
.imputbox {  font-size: 10pt; color: #000099; background-color: #CCFFCC; font-family: Verdana, Arial, Helvetica, sans-serif; border: 1pix #000000 solid; border-color: #000000 solid; font-weight: normal}
.VM{ font-family: TAHOMA; font-weight:bold;font-size: 12pt; color: #F000FF; background-color: #FFFFFF; border-color: #000000 ; border-top-width: 0pix; border-right-width: 0pix; border-bottom-width: 0pix; border-left-width: 0pix}
.p1 {font-family: TAHOMA; font-size: 9pt; color: #F000FF;margin-top: 2; margin-bottom: 1}
-->
</style>

</head>

<body leftmargin="2" topmargin="0" marginwidth="0" marginheight="0">
<p style="margin-top: 0; margin-bottom: 0"><b><font face="Tahoma" size="3">MESA-
HTML;
echo ($HTTP_GET_VARS['id']);
echo <<< HTML
</font></b></p>
<form name="form1" method="post" action="">
<table border="0" width="61%" cellspacing="0" cellpadding="0" height="117">
  <tr>
    <td width="7%" height="47" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
    <td width="31%" height="47">&nbsp;&nbsp;&nbsp;
    <input class="VM" type="text" name="T1"  size="8" value=
HTML;
echo ($J1);
echo <<< HTML
    ><img src="images/atras.jpg" width="50" height="60">
    </td>
    <td width="24%" height="47"></td>
  </tr>
  <tr>
    <td width="7%" height="253" valign="top" rowspan="2">&nbsp;
      <p><input class="VM" type="text" name="T2" size="8" value=
HTML;
echo ($J2);
echo <<< HTML
      ><img src="images/atras.jpg" width="50" height="60"></p>
      <p>&nbsp;</p>
      <p>&nbsp;<input class="VM" type="text" name="T3" size="8" value=
HTML;
echo ($J3);
echo <<< HTML
      ><img src="images/atras.jpg" width="50" height="60"></td>
    <td width="31%" height="187" ><img src="images/mesa.gif" width="169" height="162" align="absmiddle">
    </td>
    <td width="24%" height="1" valign="top">
    <p>&nbsp;&nbsp;<input class="VM" type="text" name="T4" size="8" value=
HTML;
echo ($J4);
echo <<< HTML
      ></p>
      <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/atras.jpg" width="50" height="60">
      </p>
      <p>&nbsp;</p>
      <p>&nbsp;</td>
    </tr>
    <tr>
    <td width="55%" height="66" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input class="VM" type="text" name="T5" size="8" value=
HTML;
echo ($J5);
echo <<< HTML
      ><img src="images/atras.jpg" width="50" height="60">
      </td>
  </tr>
</table>
</form>
<p> &nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
HTML;
}
?>