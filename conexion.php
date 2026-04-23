<?php
//define ('DB_HOST','localhost');
//define ('DB_USER','root');
//define ('DB_PASS','lp4458');
//define ('DB_NAME','p40');
//PRODUCCION
define('DB_HOST', 'db.tecnica4berazategui.edu.ar');
define('DB_USER', 'lperconti_llamatres');
define('DB_PASS', '11deBasto');
define('DB_NAME', 'lperconti_llamatres');

// Clase que extiende mysqli correctamente
class Conexion extends mysqli {
    function __construct() {
        parent::__construct(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connect_error) {
            die("Conexión fallida: " . $this->connect_error);
        }
    }
}


