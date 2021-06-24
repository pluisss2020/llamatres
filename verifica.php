<?php
// Motor autentificaci�n usuarios.

// Cargar datos conexion y otras variables.
require ("config.php");
include ("global_func.php");
//ini_set("display_errors","1");
	



// 1)Chequeamos si se est� autentificandose un usuario por medio del formulario
if (isset($_POST['user']) && isset($_POST['pass'])) {
//echo $_POST['user'];
// Conexi�n base de datos.
// si no se puede conectar a la BD salimos del scrip con error 0 y
// redireccionamos a la pagina de error.
$db_conexion= mysqli_connect("$sql_host", "$sql_usuario", "$sql_pass","$sql_db") or die(header ("Location:  $redir?error_login=0"));
//mysql_select_db("$sql_db");

// realizamos la consulta a la BD para chequear datos del Usuario.
$usuario_consulta = mysqli_query($db_conexion,"SELECT * FROM $sql_tabla WHERE usuario='".$_POST['user']."'") or die(header ("Location:  $redir?error_login=1"));

 // 2)miramos el total de resultado de la consulta (si es distinto de 0 es que existe el usuario)
 if (mysqli_num_rows($usuario_consulta) != 0) {

    // eliminamos barras invertidas y dobles en sencillas
    $login = stripslashes($_POST['user']);
    // encriptamos el password en formato md5 irreversible.
    $password = md5($_POST['pass']);

    // almacenamos datos del Usuario en un array para empezar a chequear.
 	$usuario_datos = mysqli_fetch_array($usuario_consulta,MYSQLI_BOTH);
  
    // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.
    mysqli_free_result($usuario_consulta);
    // cerramos la Base de dtos.
    mysqli_close($db_conexion);
    
    // chequeamos el nombre del usuario otra vez contrastandolo con la BD
    // esta vez sin barras invertidas, etc ...
    // si no es correcto, salimos del script con error 4 y redireccionamos a la
    // p�gina de error.
    if ($login != $usuario_datos['usuario']) {
       	Header ("Location: $redir?error_login=4");
		exit;}

    // si el password no es correcto ..
    // salimos del script con error 3 y redireccinamos hacia la p�gina de error
    if ($password != $usuario_datos['pass']) {
        Header ("Location: $redir?error_login=3");
	    exit;}

    // Paranoia: destruimos las variables login y password usadas
    unset($login);
    unset ($password);
	
	$time_ck = time() + 24 * 60 * 60;
	//COOKIES USUARIOS
	if(!isset($_COOKIE['usuario_id']))
    setcookie('usuario_id',$usuario_datos['ID'] , $time_ck);
    
	if(!isset($_COOKIE['usuario_nivel']))
	setcookie('usuario_nivel',$usuario_datos['nivel_acceso'] , $time_ck);

    if(!isset($_COOKIE['usuario_login']))
    setcookie('usuario_login',$usuario_datos['usuario'] , $time_ck);

    if(!isset($_COOKIE['usuario_nombre']))
    setcookie('usuario_nombre',$usuario_datos['nombre'].' '. $usuario_datos['apellido'] , $time_ck);
    
	if(!isset($_COOKIE['usuario_email']))
    setcookie('usuario_email',$usuario_datos['email'] , $time_ck);

    if(!isset($_COOKIE['usuario_id']))
    setcookie('usuario_milink',$usuario_datos['mi_link'] , $time_ck);

    if(!isset($_COOKIE['usuario_IdEmpresa']))
    setcookie('usuario_IdEmpresa',$usuario_datos['Id_empresa'] , $time_ck);
     
	if(!isset($_COOKIE['usuario_nro_lista']))
    setcookie('usuario_nro_lista',$usuario_datos['nro_lista'] , $time_ck);

    if(!isset($_COOKIE['usuario_usa_img']))
    setcookie('usuario_usa_img',$usuario_datos['usa_img'] , $time_ck);

    if(!isset($_COOKIE['usuario_cod_precios']))
    setcookie('usuario_cod_precios',$usuario_datos['cod_precios'] , $time_ck);


    $cp=$usuario_datos['cod_precios'];
	$ide=$usuario_datos['Id_empresa'];
    $d=porc_dto($cp,$ide,$sql_host,$sql_usuario,$sql_pass,$sql_db);
	

    if(!isset($_COOKIE['usuario_porc']))
    setcookie('usuario_porc',$d , $time_ck);

    if(!isset($_COOKIE['usuario_margen']))
    setcookie('usuario_margen',$usuario_datos['margen'] , $time_ck);

    if(!isset($_COOKIE['usuario_ver_precios']))
    setcookie('usuario_ver_precios',$usuario_datos['ver_precios'] , $time_ck);


    // En este punto, el usuario ya esta validado.
    // Grabamos los datos del usuario en una sesion.
	
    // Paranoia: decimos al navegador que no "cachee" esta p�gina.
    //session_cache_limiter('nocache,private');
    
	

     // le damos un mobre a la sesion.
    //session_name($usuarios_sesion);


    //DATOS SESION USUARIO
    // incia sessiones
	/*
	ini_set("session.cookie_lifetime","14400");
    ini_set("session.gc_maxlifetime","14400");
    session_start();
    */
    // Asignamos variables de sesi�n con datos del Usuario para el uso en el
    // resto de p�ginas autentificadas.
     
    // definimos usuarios_id como IDentificador del usuario en nuestra BD de usuarios
    $usuario_id=$usuario_datos['ID'];
	$usuario_IdEmpresa=$usuario_datos['Id_empresa'];
	/*
	$_SESSION['usuario_id']=$usuario_datos['ID'];
	
    // definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
    //$usuario_nivel=$usuario_datos['nivel_acceso'];
    $_SESSION['usuario_nivel']=$usuario_datos['nivel_acceso'];
	
    //definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
    //$usuario_login=$usuario_datos['usuario'];
    
    $_SESSION['usuario_login']=$usuario_datos['usuario'];
    //definimos usuario_password con el password del usuario de la sesi�n actual (formato md5 encriptado)
    //$usuario_password=$usuario_datos['pass'];
    //$_SESSION['usuario_password']=$usuario_datos['pass'];
	
    //definimos usuario_vendedor con el codigo de vendedor del usuario de la sesi�n actual (formato md5 encriptado)
    //$usuario_nombre=$usuario_datos['nombre'].' '. $usuario_datos['apellido'];
    $_SESSION['usuario_nombre']=$usuario_datos['nombre'].' '. $usuario_datos['apellido'];
	
    //$usuario_email=$usuario_datos['email'];
    $_SESSION['usuario_email']=$usuario_datos['email'];
    //$usuario_milink=$usuario_datos['mi_link'];
	$_SESSION['usuario_milink']=$usuario_datos['mi_link'];
    
    $usuario_IdEmpresa=$usuario_datos['Id_empresa'];
	$_SESSION['usuario_IdEmpresa']=$usuario_datos['Id_empresa'];
    
    //$usuario_nro_lista=$usuario_datos['nro_lista'];
    $_SESSION['usuario_nro_lista']=$usuario_datos['nro_lista'];
    //$usuario_usa_img=$usuario_datos['usa_img'];
	$_SESSION['usuario_usa_img']=$usuario_datos['usa_img'];
	$usuario_cod_precios=$usuario_datos['cod_precios'];
	$_SESSION['usuario_cod_precios']=$usuario_datos['cod_precios'];
	
	//$usuario_porc=porc_dto($usuario_cod_precios,$usuario_IdEmpresa,$sql_host,$sql_usuario,$sql_pass,$sql_db);
	$_SESSION['usuario_porc']=porc_dto($usuario_cod_precios,$usuario_IdEmpresa,$sql_host,$sql_usuario,$sql_pass,$sql_db);
	
	//$usuario_margen=$usuario_datos['margen'];
	$_SESSION['usuario_margen']=$usuario_datos['margen'];
	
	//$usuario_ver_precios=$usuario_datos['ver_precios'];
	$_SESSION['usuario_ver_precios']=$usuario_datos['ver_precios'];
    */

    // registramos las variables en la sesi�n:
	/*
    session_register("usuario_id");
    session_register("usuario_nivel");
    session_register("usuario_login");
    session_register("usuario_password");
    session_register("usuario_nombre");
    session_register("usuario_email");
    session_register("usuario_milink");
    session_register("usuario_IdEmpresa");
    session_register("usuario_nro_lista");
    session_register("usuario_usa_img");
	session_register("usuario_cod_precios");
	session_register("usuario_porc");
	session_register("usuario_margen");
	session_register("usuario_ver_precios");
	*/
//EMPRESA	
	$db_conexion= mysqli_connect("$sql_host", "$sql_usuario", "$sql_pass","$sql_db") or die(header ("Location:  $redir?error_login=0"));
    //mysql_select_db("$sql_db");

// realizamos la consulta a la BD para Tener los dato s de empresa
$empresa_consulta = mysqli_query($db_conexion,"SELECT * FROM $sql_tabla_emp WHERE ID='".$usuario_IdEmpresa."'") or die(header ("Location:  $redir?error_login=1"));

 // 2)miramos el total de resultado de la consulta (si es distinto de 0 es que existe el usuario)
 if (mysqli_num_rows($empresa_consulta) != 0) {

    $empresa_datos = mysqli_fetch_array($empresa_consulta,MYSQLI_BOTH);
  
    // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.
    mysqli_free_result($empresa_consulta);
    // cerramos la Base de dtos.
    mysqli_close($db_conexion);
	
	//COOKIES EMPRESA
	if(!isset($_COOKIE['empresa_nombre']))
    setcookie('empresa_nombre',$empresa_datos['nombre'] , $time_ck);
    
	if(!isset($_COOKIE['empresa_dir']))
	setcookie('empresa_dir',$empresa_datos['direccion'] , $time_ck);

    if(!isset($_COOKIE['empresa_loc']))
    setcookie('empresa_loc',$empresa_datos['localidad'] , $time_ck);

    if(!isset($_COOKIE['empresa_tel'])) 
    setcookie('empresa_tel',$empresa_datos['telefono'] , $time_ck);

    if(!isset($_COOKIE['empresa_mail']))
    setcookie('empresa_mail',$empresa_datos['email'] , $time_ck);

    if(!isset($_COOKIE['empresa_contacto'])) 
    setcookie('empresa_contacto',$empresa_datos['contacto'] , $time_ck);

    $h=$empresa_datos['nombre']." - ".$empresa_datos['telefono']." - ".$empresa_datos['email'];
    if(!isset($_COOKIE['empresa_header']))
	setcookie('empresa_header',$h , $time_ck);
	
	//DATOS SESION EMPRESA
	/*
    $empresa_nombre=$empresa_datos['nombre'];
	$_SESSION['empresa_nombre']=$empresa_datos['nombre'];
	//$empresa_dir=$empresa_datos['direccion'];
	$_SESSION['empresa_dir']=$empresa_datos['direccion'];
	//$empresa_loc=$empresa_datos['localidad'];
	$_SESSION['empresa_loc']=$empresa_datos['localidad'];
	$empresa_tel=$empresa_datos['telefono'];
	$_SESSION['empresa_tel']=$empresa_datos['telefono'];
	$empresa_mail=$empresa_datos['email'];
	$_SESSION['empresa_mail']=$empresa_datos['email'];
	//$empresa_contacto=$empresa_datos['contacto'];
	$_SESSION['empresa_contacto']=$empresa_datos['contacto'];
	//$empresa_header=$empresa_nombre." - ".$empresa_tel." - ".$empresa_mail;
	$_SESSION['empresa_header']=$empresa_nombre." - ".$empresa_tel." - ".$empresa_mail;
	*/
	/*
	session_register("empresa_nombre");
	session_register("empresa_dir");
	session_register("empresa_loc");
	session_register("empresa_tel");
	session_register("empresa_mail");
	session_register("empresa_contacto");
	session_register("empresa_header");
	*/
    }
$db_conexion= mysqli_connect("$sql_host", "$sql_usuario", "$sql_pass","$sql_db") or die("No se pudo conectar a la Base de datos") or die(mysqli_error($db_conexion));
//mysql_select_db("$sql_db") or die(mysql_error());
$fecha=LaFecha_F();
$hora=LaHora();
mysqli_query($db_conexion,"INSERT INTO log_user values(NULL,'$usuario_id','$fecha','$hora')") or die(mysqli_error($db_conexion));
mysqli_close($db_conexion);


    // Hacemos una llamada a si mismo (scritp) para que queden disponibles
    // las variables de session en el array asociado $HTTP_...
    $pag=$_SERVER['PHP_SELF'];
    Header ("Location: $pag?");
    exit;
    
   } else {
      // si no esta el nombre de usuario en la BD o el password ..
      // se devuelve a pagina q lo llamo con error
      Header ("Location: $redir?error_login=2");
      exit;
    }
} else {

// -------- Chequear sesi�n existe -------

//// usamos la sesion de nombre definido.
//session_name($usuarios_sesion);


 // le damos un mobre a la sesion.
 //session_name($usuarios_sesion);//linea agregada 04/10/2019



// Iniciamos el uso de sesiones
/*
ini_set("session.cookie_lifetime","14400");
ini_set("session.gc_maxlifetime","14400");
session_start();
*/
// Chequeamos si estan creadas las variables de sesi�n de identificaci�n del usuario,
// El caso mas comun es el de una vez "matado" la sesion se intenta volver hacia atras
// con el navegador.

/*
if (!isset($_SESSION['usuario_login']) && !isset($_SESSION['usuario_password'])){
// Borramos la sesion creada por el inicio de session anterior
session_destroy();
die ("Error cod.: 2 - Acceso incorrecto!");
exit;
}
*/

}

if (!isset($_POST['user']) && !isset($_POST['pass'])) {
/*	
ini_set("session.cookie_lifetime","14400");
ini_set("session.gc_maxlifetime","14400");	
session_start();
*/
//echo session_name()."-".$_SESSION['usuario_login'];	
//return;
}
?>