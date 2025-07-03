<?

//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada
//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre página modificada
//header("Cache-Control: no-cache, must-revalidate");           		// HTTP/1.1
//header("Pragma: no-cache");
require($HTTP_SERVER_VARS['DOCUMENT_ROOT']."/aut_verifica.inc.php");
require ($HTTP_SERVER_VARS['DOCUMENT_ROOT']."/aut_config.inc.php"); // incluir configuracion.
//require($HTTP_SERVER_VARS['DOCUMENT_ROOT']."/global.php");
$db_conexion=mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
mysql_select_db("$sql_db") or die(mysql_error());
$id_player=$HTTP_SESSION_VARS['usuario_id'];
$en_mesa = mysql_query("SELECT * FROM $sql_tabla WHERE Id=$id_player") or die("No se pudo realizar la consulta a la Base de datos");
$resultado = mysql_fetch_array($en_mesa);
$nro_mesa=$resultado['en_mesa'];
mysql_free_result($en_mesa);
mysql_close();

?>



<?
// Aqui verificar si el archivo ha cambiado
//define('m','minichat.txt') ;


$file_chat="chat".$nro_mesa.".txt";
define('m',$file_chat) ;
$newti=filemtime(m);
//pasando un valor de javascript a PHP , de la variable user
$user = "<script language=javascript>document.write(top.user);</script>";

print("NT: $newti MESA: $nro_mesa US: $user ");
?>
<script>
top.newti=<?print($newti);?>;
if(top.newti==top.ti) {
top.newti=top.newti;
} else {
top.ti=top.newti;
if(top.push) {
top.push.location.reload();
}
}
</script>
<?
?>
<body onLoad="window.setInterval('location.reload()',3000);">
</body>
