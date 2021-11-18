function estereos(){ 
let dato = document.getElementById('input').value;

let sub = document.getElementById('form').addEventListener('submit', function(e){
    if(dato == ''){
        alert('llenar datos');
    }
    else{
        alert('el formulario se completo correctamente');
    }
    e.preventDefault();
    });
}
