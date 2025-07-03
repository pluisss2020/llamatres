var AS_Popup = 'AS_Popup';
var AS_Popup_Window;


function AcomodarVentana(Ox,Oy,W,H)
{
 window.moveTo(Ox,Oy);
 window.resizeTo(W,H);
}

function ShowPopup(filepath,h,w){
   var width = 568;
   var height = 420;

   if(h > 0){
      height  = h;
   }
   if(w > 0){
      width = w;
   }
   var resize = "no";
   var scrollbars = "yes";
   var features = 'width='+width+',height='+height+',scrollbars='+scrollbars+',resize='+resize+'';
   AS_Popup_Window = window.open(filepath,AS_Popup,features);
   AS_Popup_Window.focus;

//   return false;
}


function NuevaVentana(url,name,MB,TB,LB,R,L,T,W,H)
{
  window.open(url,name,'menubar='+MB,'toolbar='+TB,'locationbar='+LB,'resizable='+R,'height='+H,'width='+W,'top='+T,'left='+L);
  //window.moveTo(Ox,Oy);

}
function str_busqueda(form)
{
var ir=form.sel_rubro.selectedIndex;
var is=form.sel_subrubro.selectedIndex;
var im=form.sel_marca.selectedIndex;

var marca=form.sel_marca.options;
var rubro=form.sel_rubro.options;
var subrubro=form.sel_subrubro.options;
var titulo="";
var logica="";

var query_sql="SELECT * FROM " + "articulo" + " WHERE ";

if(marca[im].text){
query_sql=query_sql + "marca = " + "'" + marca[im].text+ "'";
form.str_b.value=query_sql ;
logica=" AND ";
}
if(rubro[ir].text){
query_sql=query_sql + logica + "rubro = " + "'" + rubro[ir].text+ "'";
form.str_b.value=query_sql;
logica=" AND ";
}
if(subrubro[is].text){
query_sql=query_sql + logica + "subrubro = " + "'" + subrubro[is].text+ "'";
form.str_b.value=query_sql;
logica=" AND ";
}
form.str_b.value=form.str_b.value+" order by subrubro ";
titulo= rubro[ir].text + " " + subrubro[is].text + " " + marca[im].text;
form.titulo.value=titulo;

}

function str_busqueda_tema(form)
{
var it=form.sel_tema.selectedIndex;

var tema=form.sel_tema.options;



var query_sql="SELECT * FROM " + "clinicapc" + " WHERE ";

if(tema[it].text){
query_sql=query_sql + "tema = " + "'" + tema[it].text + "'";
form.str_b.value=query_sql;
}
form.str_b.value=form.str_b.value+" order by ID ";

}

function poner_tema(form)
{
var it=form.sel_tema.selectedIndex;
var tema=form.sel_tema.options;

if(tema[it].text)
form.tema.value=tema[it].text ;

}