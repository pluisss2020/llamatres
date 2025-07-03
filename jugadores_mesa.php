<?php
include_once("libreria/mesas.php");
include("libreria/persona.php");
session_start();
echo'
<style> 

#JUGADORES {
  padding-right: 20px;	
}
#HDR_JUGADORES {
  padding-right: 20px;
  border-radius: 5px;
  border-style: solid;
  border-width: 0px;
  background-color: rgba(128, 128, 0, 0.3);
}
.JUGADOR1 {
  padding: 10px;
  border-radius: 5px;
  background-color: rgba(51, 255, 196, 0.5);
}
.JUGADOR2 {
  padding: 10px;
  border-radius: 5px;
  background-color: rgba(51, 206, 255, 0.5);
}
.JUGADOR3 {
  padding: 10px;
  border-radius: 5px;
  background-color: rgba(246, 252, 113, 0.5);
}
.JUGADOR4 {
  padding: 10px;
  border-radius: 5px;
  background-color: rgba(150, 0, 0, 0.3);
}
.JUGADOR5 {
  padding: 10px;
  border-radius: 5px;
  background-color: rgba(0, 10, 200, 0.3);
}
</style>';
$str_b =  $_POST['id_mesa'];
//$str_nombre =  $_POST['id_nombre'];
//echo $str_b;
$M=Mesa::traer_datos_mesa($str_b);
$str_nombre = $M['nombre'];
if($M['id_j1'] != 0 ){
  $P=Persona::traer_datos($M['id_j1']);
  $n1=$P['nick'];
}
if($M['id_j2'] != 0 ){
  $P=Persona::traer_datos($M['id_j2']);
  $n2=$P['nick'];
}
if($M['id_j3'] != 0 ){
  $P=Persona::traer_datos($M['id_j3']);
  $n3=$P['nick'];
}
if($M['id_j4'] != 0 ){
  $P=Persona::traer_datos($M['id_j4']);
  $n4=$P['nick'];
}
if($M['id_j5'] != 0 ){
  $P=Persona::traer_datos($M['id_j5']);
  $n5=$P['nick'];
}

?>

<?php
$c=Mesa::traer_nro_jugadores($str_b);
if(isset($_SESSION['username'])){
  $jem=MESA::ver_jugador_en_mesa($str_b,$_SESSION['userid']);
  //echo "Jugador en mesa  ".$jem;
}  
if (!isset($_SESSION['username']))
  $link_add='';
else{ 
      if ( isset($_SESSION['username']) && $c < 5 &&  $_SESSION['nro_jugador']==0){
      //$link_add='<a class="am" title="Unirse para jugar en esta mesa" href="unirse_mesa.php?mesa='.$str_b.'&jugador='.$_SESSION["userid"].'&t_jugadores='.$c.'">+</a>';
      $link_add='<a class="am" title="Unirse para jugar en esta mesa" href="#" onclick="unirse_mesa('.$str_b.','.$_SESSION["userid"].')">+</a>';
      //$link_add = '<button title="Unirse para jugar en esta mesa" class="btn btn-primary btn-xs" onclick="ver_jugadores(' . $mesas_activas['id_mesa'] . ')" >V</button></td>';

    }
      else{
        $link_add='';
        $jem=MESA::ver_jugador_en_mesa($str_b,$_SESSION['userid']);
        if($jem>0)
        $link_add='<a class="am" title="Salir-Dejar de jugar en esta mesa" href="#" onclick="salirse_mesa('.$str_b.','.$_SESSION["userid"].','.$_SESSION["nro_jugador"].')">-</a>';

      }
  }
if (isset($M)){
?>

<div class="row">
	  	<div id="capa_J"><H4></H4>
      <div id="HDR_JUGADORES">	
     <H3 style="margin-top:2px;margin-bottom:2px;">Mesa&nbsp;<?php echo $str_nombre; ?>&nbsp; &nbsp<?php echo $link_add; ?></H3>
     </div>
     <div id="JUGADORES">
     <table style="width:100%">
       <tr>
         <th>No.</th>
         <th>Jugador</th>
         <th>Puntos</th>
       </tr>

       <?php
        echo "<script>poner_nombre('#name_mesa','".$str_nombre."');</script>" ; 
        echo "<script>poner_nombre('#nro_mesa','".$str_b."');</script>" ;
        if(isset($_SESSION['userid']))
         echo "<script>poner_nombre('#id_jugador','".$_SESSION['userid']."');</script>" ;
         if(isset($_SESSION['nro_jugador']) && $jem == 1)
           echo "<script>poner_nombre('#pos_jugador','".$_SESSION['nro_jugador']."');</script>" ;
         else
         echo "<script>poner_nombre('#pos_jugador','0');</script>" ;
		   if(isset($n1)){
         $pts1=$M['pts1'];
         echo " <tr class='JUGADOR1'><th>".$M['id_j1']."</th><th>".$n1."</th><th>".$pts1."</th></tr>";
         echo "<script>poner_nombre('#name_j1','".$n1."');</script>" ;
        }
        echo "<script>poner_nombre('#name_j2','');</script>" ; 
       if(isset($n2)){
        $pts2=$M['pts2'];
        echo " <tr class='JUGADOR2'><th>".$M['id_j2']."</th><th>".$n2."</th><th>".$pts2."</th></tr>";
        echo "<script>poner_nombre('#name_j2','".$n2."');</script>" ; 
      }
      echo "<script>poner_nombre('#name_j3','');</script>" ;
       if(isset($n3)){
        $pts3=$M['pts3'];
        echo " <tr class='JUGADOR3'><th>".$M['id_j3']."</th><th>".$n3."</th><th>".$pts3."</th></tr>";
        echo "<script>poner_nombre('#name_j3','".$n3."');</script>" ; 
      }
      echo "<script>poner_nombre('#name_j4','');</script>" ;
       if(isset($n4)){
        $pts4=$M['pts4'];
        echo " <tr class='JUGADOR4'><th>".$M['id_j4']."</th><th>".$n4."</th><th>".$pts4."</th></tr>";
        echo "<script>poner_nombre('#name_j4','".$n4."');</script>" ;
      }
      echo "<script>poner_nombre('#name_j5','');</script>" ;
       if(isset($n5)){
        $pts5=$M['pts5'];
        echo " <tr class='JUGADOR5'><th>".$M['id_j5']."</th><th>".$n5."</th><th>".$pts5."</th></tr>";
        echo "<script>poner_nombre('#name_j5','".$n5."');</script>" ; 
      }
       ?>


       
      
      </table>
     </div>  

      </div>
    </div>
<?php
}
?>