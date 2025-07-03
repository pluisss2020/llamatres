<?
require($HTTP_SERVER_VARS['DOCUMENT_ROOT']."/global.php");
require($HTTP_SERVER_VARS['DOCUMENT_ROOT']."/aut_verifica.inc.php"); // incluir motor de autentificación.
$nivel_acceso=5; // definir nivel de acceso para esta página.
if ($nivel_acceso < $HTTP_SESSION_VARS['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}

require ($HTTP_SERVER_VARS['DOCUMENT_ROOT']."/aut_config.inc.php"); // incluir configuracion.
$pag=$HTTP_SERVER_VARS['PHP_SELF'];  // el nombre y ruta de esta misma página.
$db_conexion=mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
mysql_select_db("$sql_db") or die(mysql_error());
$id_player=$HTTP_SESSION_VARS['usuario_id'];
$en_mesa = mysql_query("SELECT * FROM $sql_tabla WHERE Id=$id_player") or die("No se pudo realizar la consulta a la Base de datos");
$resultado = mysql_fetch_array($en_mesa);
$nro_mesa=$resultado['en_mesa'];

//echo $nro_mesa;
mysql_free_result($en_mesa);
mysql_close();
?>
<?
//define('m','minichat.txt') ;
//$fil=fopen(m,"r");
//$data=fread($fil,filesize(m));
//fclose($fil);
//print("<p>$data</p>");
#*****************************
#*** MiniChat v1.5         ***
#*** Creado por: Electros  ***
#*** Web: www.electros.net ***
#*****************************

# * Se muestran todos los errores
@error_reporting(E_ALL) ;

#*********************
#*** Configuración ***
#*********************

# Mensajes a mostrar (0 para mostrar todos)
$mostrar = 30 ;
# Maximo de caracteres por nick
$max_nick = 20 ;
# Maximo de caracteres por web
$max_web = 50 ;
# Maximo de caracteres por mensaje
$max_mensaje = 200 ;
# Maximo de caracteres por palabra (palabras muy grandes pueden descuadrar el diseño y
# ocasionar que el minichat no se vea correctamente), si no deseas esta opción pon 0.
$max_palabra = 30 ;
# ¿Mostrar caretos en los mensajes? (SI / NO)
$caretos = 'SI' ;
# ¿Mostrar fecha en los mensajes? (SI / NO)
$fecha_mensajes = 'NO' ;
# ¿Mostrar IP en los mensajes? (SI / NO)
$ip_mensajes = 'NO' ;
# Estilo (archivo que contiene el estilo del minichat, tipo de letra, tamaño, color, fondo, étc.)
$estilo = 'estilo.css' ;
# ¿Activar filtro Anti-SPAM? (para evitar el envío excesivo de direcciones webs, busca cualquier
# dirección web contenida en el mensaje y mostrará el aviso indicado) (SI / NO)
$antispam = 'SI' ;
# Aviso que se mostrará cuando alguien realice SPAM (sólo si el filtro Anti-SPAM está activado)
$antispam_aviso = '<i>SPAM</i>' ;
# ¿Censurar palabras altisonantes? (SI / NO)
$censura = 'NO' ;
# Permitir código HTML (se recomienda que esté desactivado) (SI / NO)
$codigo = 'NO' ;
# Altura de la tabla de mensajes (cuando los mensajes mostrados rebasan la altura marcada
# aparece una barra de desplazamiento)
$altura = 250 ;
# ¿Mostrar enlace hacia la web del autor? (SI / NO)
$publicidad = 'NO' ;

# ***********************************
# *** Fin de configuración básica ***
# ***********************************

# Lo que sigue modificalo bajo tu propia responsabilidad.

# *** Caretos ***
function caretos($texto) {
	# --> Inicio caretos
	$lista_caretos = array(
	':D'   => 'alegre.gif',
	':P'   => 'burla.gif',
	':(1'  => 'demonio.gif',
	':?'   => 'duda.gif',
	';)'   => 'guino.gif',
	':lol' => 'lol.gif',
	':|'   => 'neutral.gif',
	':-)'  => 'sonrisa.gif',
	':O'   => 'sorprendido.gif',
	':8'   => 'asustado.gif',
	':S'   => 'confundido.gif',
	':(2'  => 'demonio2.gif',
	':-('  => 'enojado.gif',
	':\'(' => 'llorar.gif',
	':M'   => 'moda.gif',
	':)'   => 'risa.gif',
	':R'   => 'sonrojado.gif',
	':('   => 'triste.gif'
	) ;
	# --> Fin caretos
	foreach($lista_caretos as $a => $b) $texto = str_replace($a,'<img src="caretos/'.$b.'" width="15" height="15" alt="Careto" align="top">',$texto) ;
	return $texto ;
}

# *** Palabras censuradas ***
function censura($texto) {
	# --> Inicio palabras
	$lista_censura = array(
	'insulto1' => '*****',
	'insulto2' => '*****',
	'insulto3' => '*****'
	) ;
	# --> Fin palabras
	foreach($lista_censura as $a => $b) $texto = str_replace($a,$b,$texto) ;
	return $texto ;
}

#*******************************
#*** Fin de la configuración ***
#*******************************


$file_chat="chat".$nro_mesa.".txt";
define('m',$file_chat) ;
//define('m','minichat.txt') ;
$newti=filemtime(m);
//print("Newti: $newti");

# * Comprobar si existe el archivo y si se puede escribir en él
if(file_exists(m)) {
	if(!is_writable(m)) exit('El archivo <b>'.m.'</b> debe tener el permiso CHMOD 666.') ;
}
else {
	# Se intenta crear el archivo, si no se avisa al usuario
	if(!@fopen(m,'w')) exit('El directorio del MiniChat debe tener el permiso CHMOD 777.') ;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>MiniChat v1.5</title>
<link rel="stylesheet" type="text/css" href="<?=$estilo?>">
<base target="_blank">
</head>
<body>
<div style="height: <?=$altura?>px ; overflow: auto">
<?
# * Mostrar los mensajes
$mensajes = file(m) ;
$total = count($mensajes) - 1 ;
if(!$mostrar || $total < $mostrar) {
	$maximo = 0 ;
}
else {
	$maximo = $total - $mostrar ;
}
?>
<table width="100%" border="0" cellpadding="1" cellspacing="1">
<?
for($i = $total ; $i >= $maximo ; $i--) {
	# Se obtienen todos los datos partiendo cada línea del archivo mediante el separador " | "
	list($nick,$web,$mensaje,$fecha,$ip) = explode(' | ',$mensajes[$i]) ;
	# Se aplican las funciones según la configuración
	if($codigo == 'SI') $mensaje = html_entity_decode($mensaje) ;
	if($censura == 'SI') {
		$nick = censura($nick) ;
		$web = censura($web) ;
		$mensaje = censura($mensaje) ;
	}
	if($antispam == 'SI') $mensaje = preg_replace('/(http:\/\/|www.)[^\s]+/i',$antispam_aviso,$mensaje) ;
	# Si el usuario escribió un email o web, se crea el enlace correspondiente dentro del nick
	if(!$web) $nick = '<b>&lt;'.$nick.'&gt;</b>' ;
	else {
		if(eregi('^[0-9a-z_.-]+@[0-9a-z_.-]+[a-z]{2,3}$',$web)) $web = 'mailto:'.$web ;
		$nick = "<a href=\"$web\"><b>&lt;$nick&gt;</b></a>" ;
	}
	# Se cortan las palabras que excedan la longitud máxima por palabra
	if(strlen($mensaje) > $max_palabra) {
		$palabras = explode(' ',$mensaje) ;
		$total_palabras = count($palabras) ;
		for($a = 0 ; $a < $total_palabras ; $a++) {
			if(strlen($palabras[$a]) > $max_palabra) $palabras[$a] = wordwrap($palabras[$a],$max_palabra,' ',1) ;
		}
		$mensaje = implode($palabras,' ') ;
	}
	if($caretos == 'SI') $mensaje = caretos($mensaje) ;
	$n = $i % 2 ? 1 : 2 ;
?>
<tr>
<td class="mensaje<?=$n?>">
<?=$nick.' '.$mensaje?>
<?
if($fecha_mensajes == 'SI') echo '<div class="fecha">'.$fecha.'</div>' ;
if($ip_mensajes == 'SI') echo '<div class="ip">'.$ip.'</div>' ;
?>
</td>
</tr>
<?
}
?>
</table>
</div>


</body>
</html>


