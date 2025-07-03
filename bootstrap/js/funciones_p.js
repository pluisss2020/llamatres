     
     $(document).ready(function(){
        var consulta;
        //hacemos focus al campo de búsqueda
        $("#txt_b").focus();

		  
          $("#btn_b").click(function(e){
                                      
              //obtenemos el texto introducido en el campo de búsqueda
              consulta = $("#txt_b").val();
			  //alert (consulta);
              //hace la búsqueda                                                                                  
              $.ajax({
                    type: "POST",
                    url: "busqueda_p.php",
                    data: "b="+consulta,
                    dataType: "html",
                    beforeSend: function(){
                    //imagen de carga
                    $("#capa_L").html("<p align='center'><img src='images/ajax-loader.gif' /></p>");
					},
                    error: function(){
                    alert("error petición ajax");
                    },
                    success: function(data){                                                    
                    $("#capa_L").empty();
                    $("#capa_L").append(data);                                                             
                    }
              });                                                                         
        });                                                     

	    
        //comprobamos si se pulsa una tecla
        $("#txt_b").keyup(function(e){
		  if (e.which != 13
                        )return;           
              //obtenemos el texto introducido en el campo de búsqueda
              consulta = $("#txt_b").val();
              //hace la búsqueda                                                                                  
              $.ajax({
                    type: "POST",
                    url: "busqueda_p.php",
                    data: "b="+consulta,
                    dataType: "html",
                    beforeSend: function(){
                    //imagen de carga
                    $("#capa_L").html("<p align='center'><img src='images/ajax-loader.gif' /></p>");
                    },
                    error: function(){
                    alert("error petición ajax");
                    },
                    success: function(data){                                                    
                    $("#capa_L").empty();
                    $("#capa_L").append(data);                                                             
                    }
              });                                                                         
        });                                                     

	    
  		
		});             
    

  
   function cargar(div,desde)
   {
   $(div).load(desde);
   }
 

 
function editar(id) {
   //alert('EDITAR '+id);
		
    $.ajax({
        type: "POST",
        url: "edit_p.php",
        data: {operacion: 'edicion', id_pers: id}
    }).done(function (html) {
        $('#capa_d').html(html);
    });
}

function borrar(id) {
   //alert('BORRAR '+id);
		
    $.ajax({
        type: "POST",
        url: "edit_p.php",
        data: {operacion: 'baja', id_pers: id}
    }).done(function (html) {
        $('#capa_d').html(html);
    });
}

function no_grabar(id) {
   //alert('GRABAR '+id);
		
    $.ajax({
        type: "POST",
        url: "edit_p.php",
        data: {operacion: 'actualizar', id_pers: id}
    }).done(function (html) {
        $('#capa_d').html(html);
    }).false(function () {
        alert('Error al cargar modulo');
    });
}

function upload_image(id){//Funcion encargada de enviar el archivo via AJAX
    var msg=[".upload-msg",".upload-msg1"];
    var dest=["fileToUpload","fileToUpload1"];
    $(msg[id]).text('Cargando...');
    var inputFileImage = document.getElementById(dest[id]);
    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append(dest[id],file);
    
    /*jQuery.each($('#fileToUpload')[0].files, function(i, file) {
        data.append('file'+i, file);
    });*/
                
    $.ajax({
        url: "subir_img_p.php",        // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,        // To send DOMDocument or non processed data file it is set to false
        success: function(data)   // A function to be called if request succeeds
        {
            $(msg[id]).html(data);
            window.setTimeout(function() {
            $(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
            });	}, 5000);
        }
    });
    
}
