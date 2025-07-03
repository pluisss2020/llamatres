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

    $operacion = isset($_POST['operacion']) ? $_POST['operacion'] : 'actualizar' ;
	//echo $operacion;
	if ($operacion == 'edicion'){
	  
	  
	  $id=$_POST['id_pers'];
	  
	  $A=Persona::traer_datos($id);
	  
	    $nick=$A['nick'];
		$email=$A['email'];
		$passwd=$A['passwd'];
		$rol=$A['rol'];
		$imagen=$A['imagen'];
 		$puntos=$A['puntos'];
		$status=$A['status'];
 		$id_mesa=$A['id_mesa'];
 		$nro_jugador=$A['nro_jugador'];
 		$passwd=$A['passwd'];
 		$foto=$A['foto'];

		
		$accion=$_SERVER['HTTP_REFERER'].'?operacion=actualizar&id_pers='. $id;
		$btn_txt='Actualizar';
		$leyenda='Modificar datos ';
		
	}
	
	if ($operacion == 'baja'){
	  
	  
	  $id=$_POST['id_pers'];
	  
	  $A=Persona::traer_datos($id);
	  
	  $nick=$A['nick'];
	  $email=$A['email'];
	  $passwd=$A['passwd'];
	  $rol=$A['rol'];
		
		$accion=$_SERVER['HTTP_REFERER'].'?operacion=borrar&id_pers='. $id;
		$btn_txt='Borrar';
		$leyenda='Eliminar';
	}
	
	
	
    
}

?>

<div id="capa_d"> 
<div class="container">
  
<div class="row" >
 
<div class="col-sm-6">
  <legend><?php echo $leyenda;?></legend>
  <form  role="form" method="POST" action="<?php echo $accion;?>">
  <div class="row"> 
      <div class="col-xs-2">
        
        
     <?php 
	 if (isset($operacion)){
			if ($operacion == 'edicion' || $operacion == 'baja' ) {
			    /*echo $nombre;*/
				?>
				<label for="id_usuario" >ID:</label>
				<input id="id_pers" name="id_pers" type="text" class="form-control" disabled value="<?php echo $id; ?>"/>
				<?php
			}
		}	
        ?> 
      </div>  	   
      <div class="col-xs-5">
			 <div class="form-group">
			 <label for="ejemplo_apellido">Nick</label>
			   <input type="text"  size="20" name="txtNombre" class="form-control" id="ejemplo_nombre"
					   placeholder="Introduce el nick" value="<?php echo $nick; ?>" />	 
			   
			 </div>
	   </div>		   
	  
	   <div class="col-xs-5">
			 <div class="form-group">
			   <label for="ejemplo_email">email</label>
			   <input type="text"  size="20" name="txtEmail" class="form-control" id="ejemplo_email"
					   placeholder="correo electronico" value="<?php echo $email; ?>"/>
			 </div> 
	   </div>  
	  </div>
	  
	 <div class="row">   
		   <div class="col-xs-6">
			 <div  class="form-group">
			
						 
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
			 <label>Rol</label>
			   <select class="form-control" name="txtRol" >
			         <option><?php echo $rol; ?></option>
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
					   placeholder="Cambiar Pass" value=""/>
			 </div>
		   </div>	
	
	 <div class="col-xs-6">
			 <div class="form-group">
			   <label for="ejemplo_pass1">Repetir Pass</label>
			   <input type="password"  size="20" name="txtPass1" class="form-control" id="ejemplo_pass1"
					   placeholder="Cambiar Pass" value=""/>
			 </div>
		   </div>	
	
	 
	 </div>
	
 <div class="row">  

          	   
<div class="col-xs-3">
   <div  class="form-group">   
   <label for="e_puntos">puntos</label>
	 <input type="text"  size="10" name="txtPuntos" class="form-control" id="e_puntos"
			 placeholder="" value="<?php echo $puntos; ?>"/>
   </div>   
  </div> 

  <div class="col-xs-3">
   <div  class="form-group">   
   <label for="e_nromesa">Nro Mesa</label>
	 <input type="text"  size="10" name="txtIdMesa" class="form-control" id="e_nromesa"
			 placeholder="" value="<?php echo $id_mesa; ?>"/>
   </div>   
   </div>   
  

  <div class="col-xs-3">
   <div  class="form-group">   
   <label for="e_nrojugador">Nro Jugador</label>
	 <input type="text"  size="10" name="txtNroJugador" class="form-control" id="e_nrojugador"
			 placeholder="" value="<?php echo $nro_jugador; ?>"/>
   </div>   
  </div>   

	   
 
 <div class="col-xs-3">
   <div class="form-group">
   <label for="e_status">Estatus</label>
	 <input type="text"  size="10" name="txtEstatus" class="form-control" id="e_status"
			 placeholder="" value="<?php echo $status; ?>"/>
   </div>
 </div>		   
</div>

<div class="form-group">
	<div class="row">	
	    <div class="col-xs-12">
	     <label>Imagen</label>
		 <input  id="t_file" type="text"   name="txtImagen" class="form-control" 
			  value="<?php echo $imagen; ?>">
	  </div>
	</div>  
  
  <button method="post" type="submit" class="btn btn-default" ><?php echo $btn_txt;?></button>
   
  </form>
  <form>
  <div class="row">
  	<div class="col-xs-12">
		<div class="form-group">
			<label>Imagen</label>
				<input type="file"  id="fileToUpload" onchange="upload_image(0);PonerNombreArchivo(0);">
			
		</div>
		<div class="upload-msg"></div><!--Para mostrar la respuesta del archivo llamado via ajax -->
	</div>
	</div>
	</form>
 </div>
</div>
  

</div>


</div>
