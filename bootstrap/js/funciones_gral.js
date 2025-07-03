  
   function cargar(div,desde)
   {
   $(div).load(desde);
   } 
   
   
   function poner_nombre(div,nombre)
   {
   $(div).text('');   
   $(div).text(nombre);
   } 

   function ocultarElem(elem) {
      elem.style.visibility = 'hidden';
    }
   function ocultarElemId(elemId) {
      elem = document.getElementById(elemId);
      elem.style.visibility = 'hidden';
    }
    
    function mostrarElemId(elemId) {
      elem = document.getElementById(elemId);
      elem.style.visibility = 'visible';
    }

  
   
