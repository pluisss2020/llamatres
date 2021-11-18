<?php
include_once("conexion.php");
 
$id_equipo = $_GET['id'];
 
mysqli_query($conn, "DELETE FROM usuarios WHERE id=$id_equipo") or die("problemas en el select".mysqli_error($conn));
mysqli_close($conn); 
header("Location:index.php");

?>