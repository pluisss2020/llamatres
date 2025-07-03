<?php
include_once("motor.php");


class Mesa{
 public $id_mesa;
 public $nombre;
 public $fecha_i;
 public $fecha_f;
 public $status_M;
 public $id_j1;
 public $id_j2;
 public $id_j3;
 public $id_j4;
 public $id_j5;
 public $pts1;
 public $pts2;
 public $pts3;
 public $pts4;
 public $pts5;
 
 static function ver_si_valida($str){
    $sql="select * from mesas where nombre = '$str' and status_M <> 'I' ";
    //$rs=mysql_query($sql);
	$objConn = new Conexion();
	$result=$objConn->enlace->query($sql);
	$rc=mysqli_num_rows($result);
    if ($rc > 0) //hay mesas con el mismo nombre y Activas
	 return 0;
    else
     return 1; 
 
 } 
 
 function abrir_mesa($nro_j=0){  // nueva mesa
   $hoy=date('y-m-d h:i:s');
   if($this->ver_si_valida($this->nombre) == 1){
   $sql="insert into mesas(nombre,status_M,fecha_i,fecha_f,id_j1,id_j2,id_j3,id_j4,id_j5,pts1,pts2,pts3,pts4,pts5)
   values('$this->nombre','A','$hoy','$hoy','$nro_j',0,0,0,0,0,0,0,0,0)";
   //mysql_query($sql);
   $objConn = new Conexion();
   $objConn->enlace->query($sql);
	
   $sql="select max(id_mesa) as N from mesas";
   $result=$objConn->enlace->query($sql);
   $row=mysqli_fetch_array($result);
   $n_mesa=$row['N'];
   
   echo "mesa nueva ".$n_mesa;


   $sql="UPDATE usuarios set status_M = 'J', id_mesa = '$n_mesa',nro_jugador='1' 
			where id='$nro_j'";
   $objConn->enlace->query($sql);

 }
 }

 static function traer_activas() 
	{
		$sql="select mesas.id_mesa,nombre,mesas.status_M,usuarios.nick as CREADOR from mesas,usuarios where (mesas.status_M = 'A' or mesas.status_M = 'J') 
		AND id_j1 = id ";
		
		$objConn = new Conexion();
		$rs=$objConn->enlace->query($sql);
		$m_activas=array();
		
		while($fila=mysqli_fetch_assoc($rs)){
		  $m_activas[]=$fila;
		}return $m_activas;
	 
		
	}

	static function traer_nro_jugadores($nro=0) 
	{
		if ($nro!=0)
		{
			$c=0;
			$sql="select * from mesas where id_mesa = $nro";
			
			$objConn = new Conexion();
            $result = $objConn->enlace->query($sql);
			$recs=mysqli_num_rows($result);
			$row=mysqli_fetch_array($result);
			if($row['id_j1'] != 0)
			  $c=$c+1;
			if($row['id_j2'] != 0)
			  $c=$c+1;
			if($row['id_j3'] != 0)
			  $c=$c+1;
			if($row['id_j4'] != 0)
			  $c=$c+1;
			if($row['id_j5'] != 0)
			  $c=$c+1; 
			return $c;
		}
	}	
	static function traer_datos_mesa($nro=0) 
	{
		if ($nro!=0)
		{
			$sql="select * from mesas where id_mesa = $nro";
			//$result=mysql_query($sql);
			$objConn = new Conexion();
            $result = $objConn->enlace->query($sql);
			$recs=mysqli_num_rows($result);
			$row=mysqli_fetch_array($result);
			$id=$row['id_mesa'];
			
			return $row;
		}
	}
	
	static function ver_jugador_en_mesa($nro_mesa,$id_jugador) 
	{
		$recs=0;
		if ($nro_mesa!=0 && $id_jugador !=0)
		{
			$sql="select * from mesas where id_mesa = $nro_mesa AND (id_j1=$id_jugador OR 
			id_j2=$id_jugador OR id_j3=$id_jugador OR id_j4=$id_jugador OR id_j5=$id_jugador)";
			//$result=mysql_query($sql);
			$objConn = new Conexion();
            $result = $objConn->enlace->query($sql);
			$recs=mysqli_num_rows($result);
			
		}
		return $recs;
	}
	static function posicion_en_mesa($nro_mesa,$id_jugador) 
	{
		$pm=0;
		if ($nro_mesa!=0 && $id_jugador !=0)
		{
			$M=self::traer_datos_mesa($nro_mesa); 
			if($M['id_j1'] == $id_jugador){
			  $pm=1;
			  return $pm;
			}
			if($M['id_j2'] == $id_jugador){
				$pm=2;
				return $pm;
			}  
			if($M['id_j3'] == $id_jugador){
				$pm=3;
				return $pm;
			}
			if($M['id_j4'] == $id_jugador){
				$pm=4;
				return $pm;
			}  
			if($M['id_j5'] == $id_jugador){
				$pm=5;
				return $pm;
			}
			
		}
		
	}
	static function lugar_libre_en_mesa($nro_mesa) 
	{
		$jlm=0;
		if ($nro_mesa!=0 )
		{
			$M=self::traer_datos_mesa($nro_mesa); 
			if($M['id_j1'] == 0){
			  $jlm=1;
			  return $jlm;
			}
			if($M['id_j2'] == 0){
				$jlm=2;
				return $jlm;
			}  
			if($M['id_j3'] == 0){
				$jlm=3;
				return $jlm;
			}
			if($M['id_j4'] == 0){
				$jlm=4;
				return $jlm;
			}  
			if($M['id_j5'] == 0){
				$jlm=5;
				return $jlm;
			}
		}
	}

	static function act_mesa_unirse($nro_mesa,$id_jugador)	
	{       //echo "unirse_ mesa ".$nro_mesa;
	       
			//Actualizar el estado de la mesa
            $nj=self::lugar_libre_en_mesa($nro_mesa);
			$sql="update mesas set id_j".$nj."='$id_jugador', pts".$nj."=0  where id_mesa = '$nro_mesa'";
			    

			$objConn = new Conexion();
            $objConn->enlace->query($sql);
            //Actualizar el estado del usuario
			$sql1="UPDATE usuarios set status_J = 'J', id_mesa = '$nro_mesa',nro_jugador='$nj' 
			where id='$id_jugador'";

			//echo $sql1;
			
			$objConn = new Conexion();
			$objConn->enlace->query($sql1);
            			
	}

	static function act_mesa_salirse($nro_mesa,$id_jugador,$n_jug)	
	{       //echo "unirse_ mesa ".$nro_mesa;
		
		$sql="update mesas set id_j".$n_jug."=0, pts".$n_jug."=0  where id_mesa = '$nro_mesa'";	

			$objConn = new Conexion();
            $objConn->enlace->query($sql);

			$sql1="UPDATE usuarios set status_J = 'I', id_mesa = 0,nro_jugador=0 
			where id='$id_jugador'";

			//echo $sql1;
			
			$objConn = new Conexion();
			$objConn->enlace->query($sql1);


            			
	}

 function actualizar($nro=0)	// actualiza cartel
	{
	        
			$sql="update carteles set categoria='$this->categoria', titulo='$this->titulo',texto='$this->texto'
			,imagen='$this->imagen',plantilla='$this->plantilla',v_desde='$this->v_desde'
			,v_hasta='$this->v_hasta',activo='$this->activo',link='$this->link' 
			,texto1='$this->texto1',texto2='$this->texto2',imagen1='$this->imagen1' 
			 where id_cartel = $nro";
			//mysql_query($sql); // ejecuta la consulta para actualizar
			$objConn = new Conexion();
            $objConn->enlace->query($sql);
            			
	}
	
 
 function borrar($nro=0)	
	{
	        echo $nro;
			$sql="delete from carteles where id_cartel = $nro";
			$objConn = new Conexion();
            $objConn->enlace->query($sql);
			
	
	}	
	

 
 
 
 static function buscar($str){
    $sql="select * from carteles where categoria like '%$str%' or titulo like '%$str%' or texto like '%$str%' or link like '%$str%' or id_cartel='$str' ";
    //$rs=mysql_query($sql);
	$objConn = new Conexion();
	$rs=$objConn->enlace->query($sql);
	$est=array();
	//while($fila=mysql_fetch_assoc($rs) > 0){
	while($fila=mysqli_fetch_assoc($rs)){
	  $est[]=$fila;
	}return $est;
 
 }
 
 static function seleccionar($str){
    $sql="select * from carteles where categoria = '$str' AND activo = 1 ";
    if(is_numeric($str)){
	 $sql="select * from carteles where id_cartel = '$str' ";
	}
	//echo $sql;
    
    //$rs=mysql_query($sql);
	$objConn = new Conexion();
	$rs=$objConn->enlace->query($sql);
	$est=array();
	//while($fila=mysql_fetch_assoc($rs) > 0){
	while($fila=mysqli_fetch_assoc($rs)){
	  $est[]=$fila;
	}return $est;
 
 }
 
 static function categorias(){
    $sql="select categoria,count(id_cartel) from carteles where activo=1 group by categoria";
    
	//echo $sql;
    
    $objConn = new Conexion();
	$rs=$objConn->enlace->query($sql);
	$est=array();
	//while($fila=mysql_fetch_assoc($rs) > 0){
	while($fila=mysqli_fetch_assoc($rs)){
	  $est[]=$fila;
	}return $est;
 
 }
 
 
 
 }

