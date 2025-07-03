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
//$n_mesa=$HTTP_SESSION_VARS['usuario_mesa'];

//function ver_en_que_mesa() {
//require($HTTP_SERVER_VARS['DOCUMENT_ROOT']."/aut_config.inc.php");
$db_conexion=mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
mysql_select_db("$sql_db") or die(mysql_error());
$id_player=$HTTP_SESSION_VARS['usuario_id'];
$nombre=$HTTP_SESSION_VARS['usuario_login'];
$en_mesa = mysql_query("SELECT * FROM $sql_tabla WHERE Id=$id_player") or die("No se pudo realizar la consulta a la Base de datos");
$resultado = mysql_fetch_array($en_mesa);
$nro_mesa=$resultado['en_mesa'];

mysql_free_result($en_mesa);
mysql_close();
//}
//ver_en_que_mesa();
//print("ID-USER: $id_player MESA: $nro_mesa NOMBRE : $nombre" );
//pasando un valor de javascript a PHP , de la variable user
//$id_user = "<script language=javascript>document.write(top.id_user);</script>";
//$nro_mesa = "<script language=javascript>document.write(top.mesa);</script>";
//$nombre = "<script language=javascript>document.write(top.user);</script>";
//print("ID-USER: $id_user MESA: $nro_mesa US: $nombre ");
//$name=print("$nombre");
?>
<?
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
# * Definir el nombre del archivo donde se guardarán los mensajes
$file_chat="chat".$nro_mesa.".txt";
define('m',$file_chat) ;
# * Guardar mensaje
if(isset($HTTP_POST_VARS['enviar'])) {
	function quitar_etiq($a) {
		$a = preg_replace('/<.*>/iU','',$a) ;
		return $a ;
	}
	function quitar($a) {
		$a = trim($a) ;
		$a = stripslashes($a) ;
		# Se elimina el separador de datos en caso de que alquien malintencionado lo inserte
		$a = str_replace('|','',$a) ;
		# Se elimina el caractér especial ASCII 160 (es un espacio en blanco que no puede ser eliminado por trim())
		$a = str_replace(chr(160),'',$a) ;
		$a = htmlspecialchars($a) ;
		return $a ;
	}
	$nick = quitar(quitar_etiq($HTTP_POST_VARS['nick'])) ;
	$web = quitar(quitar_etiq($HTTP_POST_VARS['web'])) ;
	$mensaje = quitar($HTTP_POST_VARS['mensaje']) ;
	# * Se comprueba que los datos no excedan las longitudes fijadas en la configuración
	switch(true) {
		case strlen($nick) > $max_nick :
			$error = 'El nick no debe ser mayor de '.$max_nick.' caractéres.' ;
			break ;
		case strlen($web) > $max_web :
			$error = 'El email o web no debe ser mayor de '.$max_web.' caractéres.' ;
			break ;
		case strlen($mensaje) > $max_mensaje :
			$error = 'El mensaje no debe ser mayor de '.$max_mensaje.' caractéres.' ;
			break ;
		case !$nick || $nick == 'Tu nick' :
			$error = 'Debes escribir un nick.' ;
			break ;
		case !$mensaje || $mensaje == 'Tu mensaje' :
			$error = 'Debes escribir un mensaje.' ;
			break ;
		default:
			if($web && $web != 'Email o web (opcional)') {
				if(eregi('^www.',$web)) $web = 'http://'.$web ;
			}
			else $web = false ;
	}
	if(isset($error)) exit($error) ;
	# * El formato de fecha local se aplica con "spanish" para que sea compatible con entornos UNIX y Windows
	setlocale(LC_TIME,'spanish') ;
	$fecha = strftime('%d %b %Y %H:%M',time()) ;
	$archivo = fopen(m,'a') ;
	fwrite($archivo,"$nick | $web | $mensaje | $fecha | $_SERVER[REMOTE_ADDR]\n") ;
	fclose($archivo) ;
}

?>
<script type="text/javascript">
enviando = 0 ;
function limpiar(campo) {
	if(campo.value == 'Tu nick') campo.value = '' ;
	if(campo.value == 'Email o web (opcional)') campo.value = '' ;
	if(campo.value == 'Tu mensaje') campo.value = '' ;
}
function validar() {
	if(formulario.nick.value == '' || formulario.nick.value == 'Tu nick') {
		alert('Debes escribir un nick') ;
		return false ;
	}
	if(formulario.mensaje.value == '' || formulario.mensaje.value == 'Tu mensaje') {
		alert('Debes escribir un mensaje') ;
		return false ;
	}
	if(enviando == 0) enviando++ ;
	else {
		alert('El mensaje se está enviando') ;
		return false ;
	}
}

</script>



<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>MENSAJES EN LLAMATRES</title>
</head>

<body topmargin="0" leftmargin="0" bgcolor="#669999">
<form  name="formulario"  method="post"  target="_self" onsubmit="return validar()">
<input type="hidden" name="nick" size="15" maxlength="<?=$max_nick?>" value="<?print("$nombre");?>" onfocus="limpiar(this)" class="formulario"><br>
<input type="hidden" name="web" size="22" maxlength="<?=$max_web?>" value="Email o web (opcional)" onfocus="limpiar(this)" class="formulario"><br>
<input type="text" name="mensaje" size="22" maxlength="<?=$max_mensaje?>" value="Tu mensaje" onfocus="limpiar(this)" class="formulario"><br>
<input type="submit" name="enviar" value="Enviar" class="formulario">
</form>
</body>

</html>



<? if($publicidad == 'SI') echo '<center><a href="http://www.electros.net">MiniChat v1.5</a></center>' ; ?>