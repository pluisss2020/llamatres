<?php
include_once("libreria/mesas.php");
include("libreria/persona.php");
session_start(); //mantiene activa la sesion
/*
$P=Persona::traer_datos($_SESSION['userid']);
if($P['id_mesa'] !=0 && $P['nro_jugador'] !=0 )
  Mesa::act_mesa_salirse($P['id_mesa'],$_SESSION['userid'],$P['nro_jugador']);
*/
session_destroy(); //destruye la sesion iniciada
header('Location: ./'); //posicionamos la cabecera
exit(0); //salida
?>