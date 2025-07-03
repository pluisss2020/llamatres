<?php
include_once("libreria/mesas.php");
session_start();

echo'
<style> 

#MESAS {
  padding-right: 20px;	
}
#HDR_MESAS {
  padding-right: 20px;
  border-radius: 5px;
  border-style: solid;
  border-width: 0px;
  background-color: rgba(0, 255, 0, 0.3);
}
.am:link, .am:visited {
  background-color: #f44336;
  color: white;
  padding: 3px 6px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

.am:hover, .am:active {
  background-color: red;
}
title {
  background-color: blue;
}
</style>';

$mesas_a=Mesa::traer_activas();

?>

<?php
if ( isset($_SESSION['username']) && $_SESSION['nro_jugador']==0 &&  $_SESSION['nro_jugador']==0)
  $link_add='<a class="am" title="Crer una Nueva Mesa" href="abrir_mesa.php"  data-toggle="modal" data-target="#myModal">+</a>';
else
$link_add='';
if (isset($mesas_a)){
?>
<script src="bootstrap/js/funciones_m.js"></script>
<div class="row">
	  	<div id="capa_M"><H4></H4>
      <div id="HDR_MESAS">	
     <H3 style="margin-top:2px;margin-bottom:2px;">MESAS ACTIVAS&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $link_add; ?></H3>
     </div>
     <div id="MESAS">
     <table style="width:100%">
       <tr>
         <th>Nombre</th>
         <th>Est.</th>
         <th>Creador</th>
         <th>N.J.</th>
         <th>Ver</th>
       </tr>
       <?php
		  foreach($mesas_a as $mesas_activas){
           $c=Mesa::traer_nro_jugadores($mesas_activas['id_mesa']);   
		   echo "
		   <tr>
		   <td>$mesas_activas[nombre]</td>
		   <td>$mesas_activas[status_M]</td>
		   <td>$mesas_activas[CREADOR]</td>
		   <td>$c</td>";
	   
	     echo '<td><button title="Ver ó Unirse a la Mesa" class="btn btn-primary btn-xs" onclick="ver_jugadores(' . $mesas_activas['id_mesa'] . ')" >V</button></td>';
		 
         
		  echo " </tr> ";
		   }
	  ?>


       
      
      </table>
     </div>  

      </div>
    </div>
<?php
}
?>