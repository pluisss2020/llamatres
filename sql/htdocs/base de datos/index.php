<?php
include_once("conexion.php"); 
?>

<html>
<head>    
		<title>CAMPEONATO</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
</head>
<body>
    <table>
	<img src="logo1.png">
			<div id="barrabuscar">
		<form method="POST">
		<input type="submit" value="Buscar" name="btnbuscar"><input type="text" name="txtbuscar" id="cajabuscar" placeholder="&#128270;Ingresar nombre de equipo">
		</form>
		</div>
			<tr><th colspan="6"><h1>LISTAR EQUIPOS</h1><th><a style="font-weight: normal; font-size: 14px;" onclick="abrirform()">Agregar</a></th></tr>
			<tr>
		    <th>Nro</th>
			<th>Id_Equipo</th>
            <th>Nombre</th>
            <th>Cant_jugadores</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Acción</th>
			</tr>
        <?php 

if(isset($_POST['btnbuscar']))
{
$buscar = $_POST['txtbuscar'];
$queryusuarios = mysqli_query($conn, "SELECT id,nom,cant,tel,email FROM usuarios where nom like '".$buscar."%'");
}
else
{
$queryusuarios = mysqli_query($conn, "SELECT * FROM equipos ORDER BY id asc");
}
		$numerofila = 0;
        while($mostrar = mysqli_fetch_array($queryusuarios))
		{    $numerofila++;    
            echo "<tr>";
			echo "<td>".$numerofila."</td>";
            echo "<td>".$mostrar['id']."</td>";
            echo "<td>".$mostrar['nom']."</td>";
            echo "<td>".$mostrar['cant']."</td>";    
			echo "<td>".$mostrar['tel']."</td>"; 
            echo "<td>".$mostrar['email']."</td>"; 
            echo "<td style='width:26%'>
            <a href=\"editar.php?cod=$mostrar[cod]\">Modificar</a> | <a href=\"eliminar.php?cod=$mostrar[cod]\" onClick=\"return confirm('¿Estás seguro de eliminar a $mostrar[nom]?')\">Eliminar</a></td>";           
}
        ?>
    </table>
	 <script>
function abrirform() {
  document.getElementById("formregistrar").style.display = "block";
  
}

function cancelarform() {
  document.getElementById("formregistrar").style.display = "none";
}

</script>
<div class="caja_popup" id="formregistrar">
  <form action="agregar.php" class="contenedor_popup" method="POST">
        <table>
		<tr><th colspan="2">Nuevo equipo</th></tr>
            <tr> 
                <td>Nombre___</td>
                <td><input type="text" name="txtnombre" required></td>
            </tr>
            <tr> 
                <td>Cant_jugadores</td>
                <td><input type="text" name="txtcant_jugadores" required></td>
            </tr>
            <tr> 
                <td>Teléfono</td>
                <td><input type="text" name="txttelefono" required></td>
            </tr>
            <tr> 
                <td>Email</td>
                <td><input type="email" name="txtemail" required></td>
            </tr>
            <tr> 	
               <td colspan="2">
				   <button type="button" onclick="cancelarform()">Cancelar</button>
				   <input type="submit" name="btnregistrar" value="Registrar" onClick="javascript: return confirm('¿Deseas registrar a este equipo?');">
			</td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>