<?php
include_once("libreria/mesas.php");
session_start();
$mesa = new Mesa();


if (isset($_SESSION['username']) && isset($_SESSION['userid'])) { //hay sesion iniciada
  		
	//Abrir Mesa
	if (isset($_POST['rec_mesaname'])){   //
        $mesa->nombre=$_POST['rec_mesaname'];
        $mesa->abrir_mesa($_SESSION['userid']);
        echo 1;
        }
}

	
?>