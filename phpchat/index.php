<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>chat </title>
        
        <script>
            $(document).ready(function (e) {
                var chatconn = new WebSocket('ws://localhost:9000'); //conectara con el websocket

                chatconn.onopen = function (e) { //si la conexion es existossa
                    console.log("Conexion exitosa");

                };

                chatconn.onmessage = function (e) {
                    var respuesta = JSON.parse(e.data); //recibimos la respuesta y como es json la parseamos
                    if(respuesta.nombre != undefined || respuesta.mensaje != undefined)
                    {
                        console.log("nombre: " + respuesta.nombre + " mensaje: " + respuesta.mensaje); //imprimimos en consola

                        $('#mensaje-div').append("<p><h3>" + respuesta.nombre + "</h3> " + respuesta.mensaje + "</p>"); //imprimimos en el div

                    }
                };

                $('#btn').click(function (e) { //si clickea el boton enviar
                    var nombre = $('#nombre').val(); //recibimos el input nombre
                    var mensaje = $('#mensaje').val(); //recibimos el textarea mensaje

                    var enviar = {'nombre': nombre, 'mensaje': mensaje}; //lo guardamos en un array

                    chatconn.send(JSON.stringify(enviar));//enviamos el array atraves de json

                    $('#mensaje-div').append("<p><h3>Tu:</h3> " + mensaje + "</p>");  //imprimimos en el div para mi


                });



                //conn.send('Hello World!');
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="offset-md-3 col-md-6">
                    <input type="text" placeholder="nombre" name="nombre" id="nombre" class="form-control" /> <!-- NOMBRE -->
                    <br>
                    <textarea name="mensaje" id="mensaje" class="form-control"></textarea> <!-- TEXTAREA mensaje -->
                    <br>
                    <button id="btn" class="btn btn-info">Enviar</button> <!-- BOTON A ENVIAR -->
                </div>
            </div>
            <div class="row">
                <div class="offset-md-3 col-md-6" id="mensaje-div"> <!-- div donde van los mensajes -->

                </div>
            </div>
        </div>
    </body>
    <style>
        .container{
           
        }
    </style>
</html>
