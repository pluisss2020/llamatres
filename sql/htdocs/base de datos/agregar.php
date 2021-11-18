<?php include_once("conexion.php"); 
    
	$nombre 	= $_POST['txtnombre'];
    $cant_jugadores 	= $_POST['txtcant_jugadores'];
    $telefono 	= $_POST['txttelefono'];
    $email 	= $_POST['txtemail'];
    
	mysqli_query($conn, "INSERT INTO usuarios(nom,cant,tel,email) VALUES('$nombre','$cant_jugadores','$telefono','email')");
    
header("Location:index.php");
	

?>