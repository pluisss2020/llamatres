<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {

    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo "server iniciado"; //si el server inicia bien imprimira en la consola
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn); //guardamos la conexion

        echo "New connection! ({$conn->resourceId})\n"; //imprimimos en consola el id
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        foreach ($this->clients as $client) { //recorremos todos los clientes conectados
            if ($from !== $client) { //si es distinto al que lo emite, lo envia a los otros
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn); //si se desconecta rompe la conexion

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n"; //si el servidor tiene un error, es obligado a cerrar

        $conn->close();
    }

}
