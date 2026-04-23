<?php
class Conexion {

    public $enlace;

    function __construct() {
        $this->enlace = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->enlace->connect_errno) {
            error_log("ERROR MySQL: " . $this->enlace->connect_error);
        }
    }

    function __destruct() {
        if ($this->enlace) {
            $this->enlace->close();
        }
    }
}
