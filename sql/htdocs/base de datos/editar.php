<?php 
include_once("conexion.php");
include_once("index.php");

$id_equipo = $_GET['id'];
 
$querybuscar = mysqli_query($conn, "SELECT * FROM usuarios WHERE id=$id_equipo");
 
while($mostrar = mysqli_fetch_array($querybuscar))
{
    $id_equipo = $mostrar['id'];
    $nombre = $mostrar['nom'];
    $cant_jugadores = $mostrar['cant'];
	$telefono = $mostrar['tel'];
    $email = $mostrar['email'];
}
?>
<html>
<head>    
		<title>t4</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="caja_popup2" id="formmodificar">
  <form method="POST" class="contenedor_popup" >
        <table>
		<tr><th colspan="2">Modificar equipo</th></tr>
		     <tr> 
                <td>Id_equipo</td>
                <td><input type="text" name="txtid_equipo" value="<?php echo $id_equipo;?>" required ></td>
            </tr>
            <tr> 
                <td>Nombre</td>
                <td><input type="text" name="txtnombre" value="<?php echo $nombre;?>" required></td>
            </tr>
            <tr> 
                <td>Cant_jugadores</td>
                <td><input type="text" name="txtcant_jugadores" value="<?php echo $cant_jugadores;?>" required></td>
            </tr>
            <tr> 
                <td>Teléfono</td>
                <td><input type="text" name="txttelefono" value="<?php echo $telefono;?>"required></td>
            </tr>
            <tr> 
                <td>Email</td>
                <td><input type="text" name="txtemail" value="<?php echo $email;?>"required></td>
            </tr>
            <tr>
				
                <td colspan="2">
				<a href="index.php">Cancelar</a>
				<input type="submit" name="btnmodificar" value="Modificar" onClick="javascript: return confirm('¿Deseas modificar a este equipo?');">
				</td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>

<?php
	
	if(isset($_POST['btnmodificar']))
{    
    $id_equipo1 = $_POST['txtid_equipo'];
	
	$nombre1 	= $_POST['txtnombre'];
    $cant_jugadores1 	= $_POST['txtcant_jugadores'];
    $telefono1 	= $_POST['txttelefono']; 
    $email1     = $_POST['txtemail']; 
      
    $querymodificar = mysqli_query($conn, "UPDATE usuarios SET nom='$nombre1',cant='$cant_jugadores1',tel='$telefono1',email='email1' WHERE id=$id_equipo1");

  	echo "<script>window.location= 'index.php' </script>";
    
}
?>