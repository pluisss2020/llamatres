<?php
session_start();
include_once("libreria/mesas.php");
$mesa =  $_POST['mesa'];
$jugador=  $_POST['jugador'];
//$t_jugadores=  $_POST['t_jugadores'];

//echo $jugador." se esta uniendo a ".$mesa;

$info=$_SESSION['username'].' Se sento a jugar en la mesa '.$mesa;
echo "<script>sendInfo('".$info."');</script>";

Mesa::act_mesa_unirse_jugar($mesa,$jugador);
$pm=Mesa::posicion_en_mesa($mesa,$jugador);
$_SESSION['nro_jugador']   = $pm;

$nw_status_mesa=Mesa::traer_status_mesa($mesa);
//echo $nw_status_mesa[0];


echo "<script>
  var nw_sts_mesa = [".$nw_status_mesa[0].",".$nw_status_mesa[1].",".$nw_status_mesa[2].",".$nw_status_mesa[3].",".$nw_status_mesa[4]."]; 
  console.log(nw_sts_mesa); 
  send_sts_mesa(nw_sts_mesa); 
</script>";
