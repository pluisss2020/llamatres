<?
if(isset($_POST['enviar'])) {
	if($_POST['version'] == 1) {
		$contenido = false ;
		$mensajes = file('minichat.txt') ;
		$total = count($mensajes) ;
		for($i = 0 ; $i < $total ; $i++) {
			list($nick,$mensaje) = explode(' | ',$mensajes[$i]) ;
			$n_nick = preg_replace('/<b>&lt;(.+)&gt;<\/b>/',"\\1",$nick) ;
			if($n_nick == $nick) {
				preg_match('/<a href="(.+)">&lt;(.+)&gt;<\/a>/',$n_nick,$a) ;
				$n_nick = $a[2] ;
				$n_web = ereg_replace('^mailto:','',$a[1]) ;
			}
			else {
				$n_web = false ;
			}
			$n_mensaje = stripslashes(trim($mensaje)) ;
			if(!$contenido) {
				$contenido = "$n_nick | $n_web | $n_mensaje |  | " ;
			}
			else {
				$contenido .= "\n$n_nick | $n_web | $n_mensaje |  | " ;
			}
		}
		rename('minichat.txt','minichat_res.txt') ;
		$minichat = fopen('minichat.txt','w') ;
		fwrite($minichat,$contenido) ;
		fclose($minichat) ;
		echo '<p>Se ha actualizado el archivo <b>minichat.txt</b><p><a href="minichat.php">Ir al MiniChat</a>' ;
	}
	if($_POST['version'] == 2) {
		$contenido = false ;
		$mensajes = file('minichat.txt') ;
		$total = count($mensajes) ;
		for($i = 0 ; $i < $total ; $i++) {
			list($nick,$mensaje,$n_fecha,$ip) = explode(' | ',$mensajes[$i]) ;
			$n_nick = preg_replace('/<b>&lt;(.+)&gt;<\/b>/',"\\1",$nick) ;
			if($n_nick == $nick) {
				preg_match('/<a href="(.+)">&lt;(.+)&gt;<\/a>/',$n_nick,$a) ;
				$n_nick = $a[2] ;
				$n_web = ereg_replace('^mailto:','',$a[1]) ;
			}
			else {
				$n_web = false ;
			}
			$n_mensaje = stripslashes($mensaje) ;
			$n_ip = trim($ip) ;
			if(!$contenido) {
				$contenido = "$n_nick | $n_web | $n_mensaje | $n_fecha | $n_ip" ;
			}
			else {
				$contenido .= "\n$n_nick | $n_web | $n_mensaje | $n_fecha | $n_ip" ;
			}
		}
		rename('minichat.txt','minichat_res.txt') ;
		$minichat = fopen('minichat.txt','w') ;
		fwrite($minichat,$contenido) ;
		fclose($minichat) ;
		echo '<p>Se ha actualizado el archivo <b>minichat.txt</b><p><a href="minichat.php">Ir al MiniChat</a>' ;
	}
}
?>
<style>
body {
font-family: verdana ;
font-size: 10pt ;
margin: 10px ;
}
</style>
<p style="font-size: 12pt"><b>Actualizar</b>
<p><b>Instrucciones:</b>
<p>Selecciona el número de la versión de tu antiguo MiniChat, pulsa el botón <b>Actualizar</b> y espera unos segundos. Aparecerá un nuevo archivo llamado
<b>minichat_res.txt</b> que será el respaldo de la versión antigua en caso de que haya un error durante la actualización.
<p>Recuerda que la carpeta "minichat" deberá tener permiso CHMOD 777, esto es necesario sólo durante el proceso de actualización,
terminando puedes restaurar el permiso anterior que por lo general es 744.
<form method="post" action="actualizar.php">
<b>Selecciona la versión:</b><br>
<input type="radio" name="version" value="1" id="a"> <label for="a">v1.2 y anteriores</label>
<input type="radio" name="version" value="2" id="b" checked> <label for="b">v1.3 y superiores</label><br><br>
<input type="submit" name="enviar" value="Actualizar">
</form>
