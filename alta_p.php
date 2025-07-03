<?php
//include("libreria/motor.php");
include_once("libreria/persona.php");

$persona = new Persona();
$nick="";
$email="";
$rol="";
$imagen;
$puntos;
$status;
$id_mesa;
$nro_jugador;
$passwd;
$foto;



if (!empty($_POST)) {
    
    //$operacion = $_GET['operacion']  ;
	$operacion = isset($_GET['operacion']) ? $_GET['operacion'] : 'alta' ;
	
	//echo "*".$operacion."*";
	
	if ($operacion == 'alta' && !isset($_GET['id_est'])){
	    //echo '1-alta';
		$persona->nick=$_POST['txtNombre'];
		$persona->email=$_POST['txtEmail'];
		$persona->rol=$_POST['txtRol'];
		if($_POST['txtPass'] != "" && $_POST['txtPass1'] != "" && ($_POST['txtPass'] == $_POST['txtPass1'])){
		  $persona->passwd=$_POST['txtPass'];
		}
        else{
		  $persona->passwd="";
		}	
		
		
		$persona->guardar();
	}
}
?>

<div id="capa_d"> 
<div class="container">
  
<div class="row" >
 
<div class="col-sm-6" > 
   
  <form  role="form" method="POST" action="">
  <legend>Agregar Usuario</legend>
     
     <div class="row">  	   
		   <div class="col-xs-6">
			 <div class="form-group">
			   <label for="ejemplo_apellido">Nick</label>
			   <input type="text"  size="20" name="txtNombre" class="form-control" id="ejemplo_nombre"
					   placeholder="Introduce el nick" />
			 </div>
		 </div>		   
			<div class="col-xs-6">
					<div class="form-group">
					<label for="ejemplo_email">email</label>
					<input type="text"  size="20" name="txtEmail" class="form-control" id="ejemplo_email"
							placeholder="correo electronico" />
					</div>
			</div>
		   
	  </div>
	  
	 
	  	  
	 <div class="row">		
		<div class="col-xs-6">
			 <div  class="form-group">   
				<label>Rol</label>
			   <select class="form-control" name="txtRol" >
			         <option>Jugador</option>
					 <option>Moderador</option>
					 <option>administrador</option>
					 <option>Invitado</option>
				</select> 
			 </div>   
		</div>  
	  	<div class="col-xs-6">
			 <div class="form-group">
			   	  
			 </div>
		</div>		   
	</div>
	

<div class="row">		
	 
	 <div class="col-xs-6">
			 <div class="form-group">
			   <label for="ejemplo_pass">Password</label>
			   <input type="password"  size="20" name="txtPass" class="form-control" id="ejemplo_pass"
					   placeholder="Cambiar Pass" />
			 </div>
		   </div>	
	
	 <div class="col-xs-6">
			 <div class="form-group">
			   <label for="ejemplo_pass1">Repetir Pass</label>
			   <input type="password"  size="20" name="txtPass1" class="form-control" id="ejemplo_pass1"
					   placeholder="Cambiar Pass" />
			 </div>
		   </div>	
	
	 
	 </div>
		 
  		
  
  <button method="post" type="submit" class="btn btn-default" >Guardar</button>
   
  </form>
  </div>
  </div>
  

</div>
</div>
