<?php
include_once("libreria/config.php");
session_start();

if ( !isset($_SESSION['username']) && !isset($_SESSION['userid']) ){ //No hay ninguna sesion iniciada
    
    if ( $idcnx = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME) )
    { //la conexion a la base de datos es ok
        //if ( @mysql_select_db(DB_NAME,$idcnx) ){
       //LOGIN
	   if (isset($_POST['login_username'])){     //login
            $sql = 'SELECT nick,passwd,id,rol FROM usuarios WHERE nick="' . $_POST['login_username']. '" && passwd="' . md5($_POST['login_userpass']) . '" LIMIT 1';
            //echo $sql;
			if ( $res = mysqli_query($idcnx,$sql) ){	
                if ( mysqli_num_rows($res) == 1 ){
                        
                    $user = mysqli_fetch_array($res);
                         
                    $_SESSION['username']   = $user['nick'];
                    $_SESSION['userid'] = $user['id'];
					$_SESSION['rol'] = $user['rol'];
					echo 1;
                    //echo $user['rol'];     
                }
                else
                    echo 0;
            }
            else
                echo 0;
                 
        }                                      //login
		

		
	//REGISTRO
	if (isset($_POST['rec_username'])){   //registro
         
            $sql = 'insert into usuarios (nick,passwd,email,rol) 
			   values("' . $_POST['rec_username']. 
			      '","' . md5($_POST['rec_userpass']) .
				  '","' . $_POST['rec_email'] .
				  '","JUGADOR")';
                  
            @mysqli_query($idcnx,$sql);
                
            echo 1;
                 
        }                                //registro
		    
        mysqli_close($idcnx);
    }
    else                                      //la conexion a la base de datos es mala
        echo 0;
}
else{                                         //hay ninguna sesion iniciada
    echo 0;
    }
	//}
	
?>