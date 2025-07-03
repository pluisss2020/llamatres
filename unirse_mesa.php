<?php
session_start();
include_once("libreria/mesas.php");
$mesa =  $_POST['mesa'];
$jugador=  $_POST['jugador'];
//$t_jugadores=  $_POST['t_jugadores'];

//echo $jugador." se esta uniendo a ".$mesa;

Mesa::act_mesa_unirse($mesa,$jugador);
$pm=Mesa::posicion_en_mesa($mesa,$jugador);
$_SESSION['nro_jugador']   = $pm;

?>
<script>
   cargar('#capa_M','mesas_activas.php');
   ver_jugadores(getElementById('#nro_mesa'));
</script>   