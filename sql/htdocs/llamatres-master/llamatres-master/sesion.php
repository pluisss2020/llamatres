<?php
require("verifica.php");

$x_id=$_COOKIE['usuario_id'];
$ID=$_COOKIE['usuario_id'];
$x_nombre=$_COOKIE['usuario_nombre'];
$x_nivel=$_COOKIE['usuario_nivel'];
$cod_user=$_COOKIE['usuario_id'];
$nro_lista=$_COOKIE['usuario_nro_lista'];
$x_emp_id=$_COOKIE['usuario_IdEmpresa'];
$x_id_empresa=$_COOKIE['usuario_IdEmpresa'];
$x_usa_img=$_COOKIE['usuario_usa_img'];
$emp_titulo=$_COOKIE['empresa_header'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";
$FONDO="images/".trim($x_emp_id)."/sitio/fondo_barra.png";
$cod_precios=$_COOKIE['usuario_cod_precios'];
$usuario_porc=$_COOKIE['usuario_porc'];
$margen=$_COOKIE['usuario_margen'];
$ver_precios=$_COOKIE['usuario_ver_precios'];
$ID=$_COOKIE['usuario_id'];
$nombre=$_COOKIE['usuario_nombre'];
$nivel=$_COOKIE['usuario_nivel'];
$titulo="Mi Pedido";
$emp_nombre=$_COOKIE['empresa_nombre'];
$x_emp_mail=$_COOKIE['empresa_mail'];
$x_email=$_COOKIE['usuario_email'];
$x_emp_nombre=$_COOKIE['empresa_nombre'];


//echo '<b>CP : '.$cod_precios.' ..... ID EMP :'.$x_emp_id.' .... porc_dto : '.$usuario_porc.'</b>';

/*
//menu.php
$ID=$_SESSION['usuario_id'];
$nombre=$_SESSION['usuario_nombre'];
$nivel=$_SESSION['usuario_nivel'];
$emp_titulo=$_SESSION['empresa_header'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";
$FONDO="images/".trim($x_emp_id)."/sitio/fondo_barra.png";
$ip=$_SERVER['REMOTE_ADDR'];

//gestion_perfil.php
$ID=$_SESSION['usuario_id'];
$nombre=$_SESSION['usuario_nombre'];
$id=$_SESSION['usuario_id'];
//$pass=$_SESSION['usuario_password'];
$nivel=$_SESSION['usuario_nivel'];
$emp_titulo=$_SESSION['empresa_header'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";
$FONDO="images/".trim($x_emp_id)."/sitio/fondo_barra.png";

//mis_margenes.php
$x_id=$_SESSION['usuario_id'];
$x_nombre=$_SESSION['usuario_nombre'];
$x_nivel=$_SESSION['usuario_nivel'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$emp_titulo=$_SESSION['empresa_header'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";


//ver_lista_parcial.php
$x_id=$_SESSION['usuario_id'];
$x_nombre=$_SESSION['usuario_nombre'];
$x_nivel=$_SESSION['usuario_nivel'];
$cod_user=$_SESSION['usuario_id'];
$nro_lista=$_SESSION['usuario_nro_lista'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$x_usa_img=$_SESSION['usuario_usa_img'];
$emp_titulo=$_SESSION['empresa_header'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";
$FONDO="images/".trim($x_emp_id)."/sitio/fondo_barra.png";
$cod_precios=$_SESSION['usuario_cod_precios'];
$usuario_porc=$_SESSION['usuario_porc'];
$margen=$_SESSION['usuario_margen'];
$ver_precios=$_SESSION['usuario_ver_precios'];

//ver_mi_presupuesto
$x_id=$_SESSION['usuario_id'];
$x_nombre=$_SESSION['usuario_nombre'];
$x_nivel=$_SESSION['usuario_nivel'];
$cod_user=$_SESSION['usuario_id'];
$nro_lista=$_SESSION['usuario_nro_lista'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$x_emp_mail=$_SESSION['empresa_mail'];
$x_emp_nombre=$_SESSION['empresa_nombre'];
$titulo="Mi Pedido";
$emp_titulo=$_SESSION['empresa_header'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";
$FONDO="images/".trim($x_emp_id)."/sitio/fondo_barra.png";
$cod_precios=$_SESSION['usuario_cod_precios'];
$usuario_porc=$_SESSION['usuario_porc'];

//consulta_user.php
$ID=$_SESSION['usuario_id'];
$nombre=$_SESSION['usuario_nombre'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$titulo="Consulta";
$emp_titulo=$_SESSION['empresa_header'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";
$FONDO="images/".trim($x_emp_id)."/sitio/fondo_barra.png";
$x_nivel=$_SESSION['usuario_nivel'];
$x_emp_mail=$_SESSION['empresa_mail'];

//bajar_lista_txt.php
$x_id=$_SESSION['usuario_id'];
$x_nombre=$_SESSION['usuario_nombre'];
$x_nivel=$_SESSION['usuario_nivel'];
$cod_user=$_SESSION['usuario_id'];
$nro_lista=$_SESSION['usuario_nro_lista'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$emp_titulo=$_SESSION['empresa_header'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";

//cartelera.php
$id_emp=$_SESSION['usuario_IdEmpresa'];
$x_id=$_SESSION['usuario_id'];
$x_nombre=$_SESSION['usuario_nombre'];
$x_nivel=$_SESSION['usuario_nivel'];
$x_id_empresa=$_SESSION['usuario_IdEmpresa'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$emp_titulo=$_SESSION['empresa_header'];
$emp_nombre=$_SESSION['empresa_nombre'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";

//nivel 5 - empresa ....

//gestion_mis_usuarios.php
$x_id=$_SESSION['usuario_id'];
$x_nombre=$_SESSION['usuario_nombre'];
$x_nivel=$_SESSION['usuario_nivel'];
$x_id_empresa=$_SESSION['usuario_IdEmpresa'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$emp_titulo=$_SESSION['empresa_header'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";

//subir_archivos.php
$x_id=$_SESSION['usuario_id'];
$x_nombre=$_SESSION['usuario_nombre'];
$x_nivel=$_SESSION['usuario_nivel'];
$x_id_empresa=$_SESSION['usuario_IdEmpresa'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$emp_titulo=$_SESSION['empresa_header'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";

//gestion_cod_precios.php
$x_id=$_SESSION['usuario_id'];
$x_nombre=$_SESSION['usuario_nombre'];
$x_nivel=$_SESSION['usuario_nivel'];
$x_id_empresa=$_SESSION['usuario_IdEmpresa'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$emp_titulo=$_SESSION['empresa_header'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";

//gestion_mensajes.php
$x_id=$_SESSION['usuario_id'];
$x_nombre=$_SESSION['usuario_nombre'];
$x_nivel=$_SESSION['usuario_nivel'];
$x_id_empresa=$_SESSION['usuario_IdEmpresa'];
$x_email=$_SESSION['usuario_email'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$emp_titulo=$_SESSION['empresa_header'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";

//abm_c.php , abm_m.php
$x_id=$_SESSION['usuario_id'];
$x_nombre=$_SESSION['usuario_nombre'];
$x_nivel=$_SESSION['usuario_nivel'];
$x_id_empresa=$_SESSION['usuario_IdEmpresa'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$emp_titulo=$_SESSION['empresa_header'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";

//gestion_usuario.php
$x_id=$_SESSION['usuario_id'];
$x_nombre=$_SESSION['usuario_nombre'];
$x_nivel=$_SESSION['usuario_nivel'];
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
$emp_titulo=$_SESSION['empresa_header'];
$LOGO="images/".trim($x_emp_id)."/sitio/logo.png";

//busqueda_c.php , busqueda_m.php , edit_m.php , edit_c.php , 
$x_emp_id=$_SESSION['usuario_IdEmpresa'];
*/
?>