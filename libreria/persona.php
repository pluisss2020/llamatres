<?php
include_once("motor.php");

//ESTE CODIGO FUE MIGRADO DESDE LA EXTENSION ANTIGUA MYSQL A LA NUEVA MYSQLi
//UTILIZANDO LA INTERFAZ ORIENTADA A OBJETOS (http://php.net/manual/es/mysqli.quickstart.dual-interface.php)

class Persona{
 public $id;
 public $nick;
 public $email;
 public $rol;
 public $imagen;
 public $puntos;
 public $status_J;
 public $id_mesa;
 public $nro_jugador;
 public $passwd;
 public $foto;

 static $recs;


 function guardar(){  // crea la Persona
    
   //$pass=md5($this->passwd);
   if($this->passwd !=""){
	$pass=md5($this->passwd);
  }
  if($this->passwd ==""){
	$pass=md5("1234");
  }

   $sql="insert into usuarios(nick,email,rol,imagen,puntos,status_J,id_mesa,nro_jugador,passwd,foto)
   values('$this->nick','$this->email','$this->rol','$this->imagen','$this->puntos',
   '$this->status_J','$this->id_mesa','$this->nro_jugador','$pass','$this->foto')";
   //mysql_query($sql);
   $objConn = new Conexion();
   $objConn->enlace->query($sql);
 }
 
 function actualizar($nro=0)	// actualiza la Persona
	{
	        if($this->passwd !=""){
			  $pass=md5($this->passwd);
			}
			if($this->passwd ==""){
			  $pass=md5("1234");
			}
			$sql="update usuarios set nick='$this->nick', email='$this->email',rol='$this->rol'
			,imagen='$this->imagen',puntos='$this->puntos',status_J='$this->status_J'
			,id_mesa='$this->id_mesa',nro_jugador='$this->nro_jugador',passwd='$pass'
			,foto='$this->foto' where id = $nro";
			//mysql_query($sql); // ejecuta la consulta para actualizar
			$objConn = new Conexion();
            $objConn->enlace->query($sql);
            			
	}
	
 function borrar($nro=0)	// elimina la Persona
	{
			$sql="delete from usuarios where id=$nro";
			//mysql_query($sql); // ejecuta la consulta para eliminar
			$objConn = new Conexion();
            $objConn->enlace->query($sql);
			
	
	}	
	
static function traer_datos($nro=0) // declara el constructor, si trae el numero de persona lo busca 
	{
		if ($nro!=0)
		{
			$sql="select * from usuarios where id = $nro";
			//$result=mysql_query($sql);
			$objConn = new Conexion();
            $result = $objConn->enlace->query($sql);
			$recs=mysqli_num_rows($result);
			$row=mysqli_fetch_array($result);
			$id=$row['id'];
			return $row;
		}
	}	
 
 
 
 static function buscar($str){
    $sql="select * from usuarios where nick like '%$str%' OR email like '%$str%'";
    //$rs=mysql_query($sql);
	$objConn = new Conexion();
	$rs=$objConn->enlace->query($sql);
	$est=array();
	//while($fila=mysql_fetch_assoc($rs) > 0){
	while($fila=mysqli_fetch_assoc($rs)){
	  $est[]=$fila;
	}return $est;
 
 }
 
 function actualizar_mesa($nro=0,$mesa)	
	{
	        $sql="update usuarios set id_mesa='$mesa' where id = $nro";
			$objConn = new Conexion();
            $objConn->enlace->query($sql);
            			
	}
function actualizar_puntos($nro=0,$puntos)	
	{
	        $sql="update usuarios set puntos=puntos+'$puntos' where id = $nro";
			$objConn = new Conexion();
            $objConn->enlace->query($sql);
            			
	}

function actualizar_status($nro=0,$status)	
	{
	        $sql="update usuarios set status_J='$status' where id = $nro";
			$objConn = new Conexion();
            $objConn->enlace->query($sql);
            			
	}
 }