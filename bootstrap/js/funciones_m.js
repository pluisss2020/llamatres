$(document).ready(function(){
 
    // Login Ajax:
    // Php mysql Ajax,
    // Copyright 2015 bloguero-ec.
    // Usese cómo mas le convenga no elimine estas líneas (http://www.bloguero-ec.com)
     
    // tiempo de el slide en segundos  
        var timeSlide =500;
    //posicionamos el puntero en el campo de usuario
        $('#rec_mesarname').focus();
    //posicionamos el tiempo de ajax en cero
        $('#timer').hide(0);
    //por el momento no mostramos el ajax
        $('#timer').css('display','none');
            
    //Abrir Mesa
    $('#rec_mesabttn').click(function(){
        // alert("hola mundo");
        //posicionamos el ajax de cero a 300 en fade
                $('#timer').fadeIn(300);
        //mostramos las clases creadas dentro del css para mostrar los mensajes
                $('.box-info, .box-success, .box-alert, .box-error').slideUp(timeSlide);
        //configuramos y creamos la condicion
                setTimeout(function(){
                    if ( $('#rec_mesaname').val() != "" ){
                         
                        $.ajax({
                            type: 'POST',
                            url: 'alta_m.php',
                            data: 'rec_mesaname=' + $('#rec_mesaname').val() ,
                             
        //si la sesion se inicia correctamente presentamos el mensaje
                            success:function(msj){
                                if ( msj == 1 ){
                                    $('#alertBoxes').html('<div class="box-success"></div>');
                                    $('.box-success').hide(0).html('Espera un momento…');
                                    $('.box-success').slideDown(timeSlide);
                                    setTimeout(function(){
                                        window.location.href = ".";
                                    },(timeSlide + 500));
                                    
                                }
                                 
        //caso contrario los datos son incorrectos
                                else{
                                    $('#alertBoxes').html('<div class="box-error"></div>');
                                    $('.box-error').hide(0).html('Lo sentimos, pero los datos son incorrectos: ' + msj);
                                    $('.box-error').slideDown(timeSlide);
                                    
                                }
                                $('#timer').fadeOut(300);
                            },
        //si se pierden los datos presentamos error de ejecucion.
                            error:function(){
                                $('#timer').fadeOut(300);
                                $('#alertBoxes').html('<div class="box-error"></div>');
                                $('.box-error').hide(0).html('Ha ocurrido un error durante la ejecución');
                                $('.box-error').slideDown(timeSlide);
                            }
                        });
                         
                    }
                     
        //caso cantrario si los campos estan vacios debemos llenarlos
                    else{
                        $('#alertBoxes').html('<div class="box-error"></div>');
                        $('.box-error').hide(0).html('Los campos estan vacios o Faltan Datos');
                        $('.box-error').slideDown(timeSlide);
                        $('#timer').fadeOut(300);
                    }
                },timeSlide);
                 
                return false;
                 
            });   
         
         });

         function ver_jugadores(id) {
                           
             $.ajax({
                 type: "POST",
                 url: "jugadores_mesa.php",
                 data: {operacion: 'ver', id_mesa: id}
             }).done(function (html) {
                 $('#capa_J').html(html);
             });
         }

         function unirse_mesa(nro_mesa,id_jugador) {
            //alert ("unirse a mesa "+nro_mesa+" el jugador "+id_jugador);           
            $.ajax({
                type: "POST",
                url: "unirse_mesa.php",
                data: {mesa: nro_mesa, jugador: id_jugador}
            }).done(function (html) {
                $('#capa_J').html(html);
            });
        }

        function salirse_mesa(nro_mesa,id_jugador,num_jugador) {
            alert ("salirse a mesa "+nro_mesa+" el jugador "+id_jugador+"En la posicion "+num_jugador);           
            $.ajax({
                type: "POST",
                url: "salirse_mesa.php",
                data: {mesa: nro_mesa, jugador: id_jugador,n_jug: num_jugador}
            }).done(function (html) {
                $('#capa_J').html(html);
            });
        }