<?
  // No almacenar en el cache del navegador esta página.
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre página modificada
		header("Cache-Control: no-cache, must-revalidate");           		// HTTP/1.1
		header("Pragma: no-cache");                                   		// HTTP/1.0
?>
<html>
<title></title>
<style type="text/css">
<!--
.botones {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #0099FF; border-color: #000000 ; border-top-width: 1pix; border-right-width: 1pix; border-bottom-width: 1pix; border-left-width: 1pix}
.imputbox {  font-size: 10pt; color: #000099; background-color: #CCFFCC; font-family: Verdana, Arial, Helvetica, sans-serif; border: 1pix #000000 solid; border-color: #000000 solid; font-weight: normal}
-->
</style>

<body leftmargin="2">
<span class="botones"></span><span class="imputbox"></span>
        <form action="ingreso.php" method="post">
                         <?
                          // Mostrar error de Autentificación.
                          include ("aut_mensaje_error.inc.php");
                          if (isset($error_login)){
                              $error=$error_login;
                          echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1' color='#FF0000'>Error: $error_login_ms[$error]";
                          }
                         ?>

                       <font face="Tahoma" size="2"><b>usuario</b></font><br>
                       <input type="text" name="user" size="8" class="imputbox"><br>
                       <font face="Tahoma" size="2"><b>passord</b></font><br>
                       <input type="password" name="pass" size="8" class="imputbox"><br>
                <input name=submit type=submit value="  Entrar  " class="botones">
        </form>
</body>
</html>
