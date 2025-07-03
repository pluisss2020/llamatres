<?
//  Autentificator
//  Gestión de Usuarios PHP+Mysql
//  by Pedro Noves V. (Cluster)
//  clus@hotpop.com
//  ------------------------------
require("aut_verifica.inc.php"); // incluir motor de autentificación.
$nivel_acceso=8; // definir nivel de acceso para esta página.
if ($nivel_acceso < $HTTP_SESSION_VARS['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}

require ("aut_config.inc.php"); // incluir configuracion.
$pag=$HTTP_SERVER_VARS['PHP_SELF'];  // el nombre y ruta de esta misma página.

function cabeceraHTML($BackColor){
echo <<< HTML
<html>
<head>
<title>Catalogo de Productos - www.felino-hnos.com.ar</title>
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

<body bgcolor=$BackColor>

<form method="post" name="frm" action="$pag?accion=Ver">
HTML;
//<input type="submit" value="Ver Seleccion" name="BotonVer" class="botones">
}


if (isset($HTTP_GET_VARS['error'])){

$error_accion_ms[0]= "No se puede borrar el articulo, debe existir por lo menos uno.<br>Si desea borrarlo, primero cree uno nuevo.";
$error_accion_ms[1]= "Faltan Datos.";
$error_accion_ms[2]= "Passwords no coinciden.";
$error_accion_ms[3]= "El Nivel de Acceso debe ser numérico.";
$error_accion_ms[4]= "El Usuario ya está registrado.";

$error_cod = $HTTP_GET_VARS['error'];
echo "<div align='center'>$error_accion_ms[$error_cod]</div><br>";

}

$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die("No se pudo conectar a la Base de datos") or die(mysql_error());
mysql_select_db("$sql_db") or die(mysql_error());

if (!isset($HTTP_GET_VARS['accion'])){
//probar un script
echo <<< HTML

<SCRIPT language=JavaScript>
function check()
{
  document.writeln(document.frm.name);
  document.writeln(document.frm.length);
  document.writeln(document.frm.elements.length);
  for (var i = 0; i <document.frm.elements.length ; i++){
   document.writeln(document.frm.elements[i].name);
   document.writeln(document.frm.elements[i].value);
   document.writeln("HOLA MUNDO");
  }
}
</script>
HTML;
//fin script



$usuario_consulta = mysql_query("SELECT * from $sql_tabla_cat") or die("No se pudo realizar la consulta a la Base de datos");

cabeceraHTML("#00CCCC");

echo <<< HTML
<input type="submit" value="Ver Seleccion" name="BotonVer" class="botones">
<table width="750" border="1" cellspacing="0" cellpadding="4" bordercolor="#CCCCCC" align="center">
  <tr>
    <td colspan="4" bgcolor="#0099FF">
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><font color="#FFFFFF">
        Catalogo de productos </font></b></font><br>
        <a href="aut_logout.php">LogOut (salir)</a>
        </div>
    </td>
  </tr>
  <tr bgcolor="#00CCCC">
    <td width="5%">
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">Articulo
        </font></b></div>
    </td>
    <td width="20%">
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">Imagen
        </font></b></div>
    </td>
    <td width="65%">
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFFF">Linea 1
        </font></b></div>
    </td>

    <td width="10%" bgcolor="#CCFFCC">
    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#0000CF">SELECCION</a></font></div></td>
  </tr>

HTML;

while($resultados = mysql_fetch_array($usuario_consulta)) {
$IMG="images/cat/".$resultados['Imagen'];
echo <<< HTML
<tr>
    <td width="5%" bgcolor="#FFFFEA"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">$resultados[Cod_art]</font></div></td>
    <td width="20%" bgcolor="#FFFFEA"><img border="1" src="$IMG" width="100" height="100"><div align="center"></div></td>
    <td width="65%" bgcolor="#FFFFEA"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">$resultados[Linea1]
    <p>$resultados[Linea2]</p>
    <p>$resultados[Linea3]</p>
    </font></div></td>
    </div></td>
    <td width="10%" bgcolor="#CCFFCC">
      <div align="center">
      <input type="checkbox" name="selec[]" value="$resultados[Cod_art]">
         </div>
         </td>
  </tr>
HTML;
}

echo "</table>";
echo "</form>";

//echo "<script language=\"javascript\">\n";
//echo " check(); ";
//echo "</script>\n";

mysql_free_result($usuario_consulta);
mysql_close();
}


//AGRAGADO VISTA PREVIA
if ($HTTP_GET_VARS['accion']=="Ver"){
cabeceraHTML("#FFFFFF");



foreach ($HTTP_POST_VARS['selec'] as $id_art){
//   echo $id_art."<br>";
   

  $articulo_consulta = mysql_query("SELECT descripcion,precio FROM $sql_tabla_art WHERE cod=$id_art") or die("No se pudo realizar la consulta a la Base de datos");
  while($resul = mysql_fetch_array($articulo_consulta)) {
  $desc="Art"." (".$id_art.") ".$resul['descripcion']."  $ ".$resul['precio']*1.2;
  }
  mysql_free_result($articulo_consulta);
  
  $catalogo_consulta = mysql_query("SELECT * FROM $sql_tabla_cat  WHERE cod_art=$id_art") or die("No se pudo realizar la consulta a la Base de datos");
  
  while($resultados = mysql_fetch_array($catalogo_consulta)) {
  //$desc="Art"." (".$id_art.") ".$resul['descripcion']."  $ ".$resul['precio'];
  $IMG="images/cat/".$resultados['Imagen'];



echo <<< HTML

<p align="center"><font face="Verdana" size="$resultados[Size1]">$resultados[Linea1]</font></p>
<table border="0" width="100%" bgcolor="#FFFFFF">
  <tr>
    <td width="100%">
     <div align="right">
      <table border="1" width="90%" cellspacing="0" cellpadding="0">
          <tr>
          <td width="42%"><img border="0" src="$IMG" width="303" height="300">
          <p align="Left"><font face="Verdana" size="2">$desc</font></p></td>
          <td width="58%" valign="top" align="left">
            <p align="center">&nbsp;</p>
            <p align="center"><font face="Verdana" size="$resultados[Size2]">$resultados[Linea2]</font></p>
            <p align="center">&nbsp;</p>
            <p align="center"><font face="Verdana" size="$resultados[Size3]">$resultados[Linea3]</font></p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p align="Left"><font face="Verdana" size="2"><b>$resultados[Observaciones]</b></td>
        </tr>
      </table>
      </div>
    </td>
  </tr>
</table>
<hr>
<p>&nbsp;</p>
HTML;
}
mysql_free_result($catalogo_consulta);

}



mysql_close();
}
//FIN AGRAGADO VISTA PREVIA


?>
</BODY>
</HTML>

