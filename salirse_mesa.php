<?php
include_once("libreria/mesas.php");
session_start();
$mesa =  $_POST['mesa'];
$jugador=  $_POST['jugador'];
$n_jug=  $_POST['n_jug'];

//echo $jugador." se esta uniendo a ".$mesa;
Mesa::act_mesa_salirse($mesa,$jugador,$n_jug);
$_SESSION['nro_jugador']   = 0;
?>
<script>
   cargar('#capa_M','mesas_activas.php');
   ver_jugadores(getElementById('#nro_mesa'));
</script>   