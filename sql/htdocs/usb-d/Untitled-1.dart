#include <Wire.h>
const int interval = 3000; //Intervalo muestreo sensor ASC217
unsigned long millisPrevio=0;
//Definimos variables para el sensor ASC217
float sensibilidad = 0.100;
float ruido = 0.000;
const int sensorIntensidad = A1;
float valorReposo = 2.50;
float intensidadPico=0;
float potencia=0;
float tensioneDeRed = 230.0;
int cont_tx=0;
boolean tablaD[][2]= //Tabla pines digitales. primero si HIGH=true,
segundo si output=true
{
{false, true}, //Luz entrada = D2. A nivel bajo, con los cables como
están estaría apagada.
};
int asociacionD[]={2};
String valoresIN_D[] =
{
};
int asociacionA[]={0}; //Si usamos sólo analog pins con analogRead,
podemos poner 0,1... en vez de A0...
String valoresIN_A[]=
{
"+A011-9999", //Corriente sensor ASC217 - Entrada
"+A012-9999" //Potencia sensor ASC217 - Entrada
};
void setup() {
Wire.begin(2);
Wire.onReceive(cambiarValor); //Registramos la funcion a ejecutar cuando
recivamos un evento
Wire.onRequest(solicitanDatos); //Funcion a ejecutar cuando el maestro
nos solicite datos
configPinout();
}
void loop() {
if((unsigned long)(millis() - millisPrevio) >= interval){
 millisPrevio=millis();
 leerCorriente();
 String aux = "";
 aux=intensidadPico*0.707; //Irms = intensidad pico*0.707
 valoresIN_A[0]="+A011-"+aux.substring(0,4);
 aux=potencia;
 valoresIN_A[1]="+A012-"+aux.substring(0,4);
}
}
void cambiarValor(size_t howmany){
String cadena = "";
while(Wire.available()){
 cadena += (char)Wire.read();
}
int separador = cadena.indexOf('-');
String pin = "";
if(cadena[1]=='0') //.toInt() no es capaz de traducir 04 a 4
 pin = cadena.substring(2, separador-1); //Empezamos despues del: D
hasta el caracter -
else
 pin = cadena.substring(1, separador-1); //Empezamos despues del: D
hasta el caracter -

separador = cadena.indexOf('-', separador); //Porque la cadena ahora es
del tipo: XXXX-A-Y. Donde A es el codigo de la placa

String valor = cadena.substring(separador+3); //Empezamos desde el
caracter siguiente a -

int aux=pin.toInt();
switch (cadena.charAt(0)){
 case 'D':
 switch (valor.toInt()){
 case 1:
 digitalWrite(pin.toInt(), HIGH);
 break;
 case 0:
 digitalWrite(pin.toInt(), LOW);
 break;
 }
 break;
}
}
void solicitanDatos(){
int valoresD = sizeof(valoresIN_D)/sizeof(valoresIN_D[0]);
int valoresA = sizeof(valoresIN_A)/sizeof(valoresIN_A[0]);
int contador=0;
while(contador<3){
 if(cont_tx < valoresD){
 Wire.write(valoresIN_D[cont_tx].c_str());
 cont_tx++; //contador con todas las entradas enviadas
 contador++; //Contador de entradas máximas por transmision
 }

 else if((cont_tx-valoresD) < valoresA){
 Wire.write(valoresIN_A[cont_tx-valoresD].c_str());
 cont_tx++;
 contador++;
 }
 else{
 cont_tx=0;
 contador=3;
 }
}
}
void configPinout(){
int filasD = sizeof(tablaD)/sizeof(tablaD[0]); //Obtenemos el numero de
filas de la tabla de pines Digitales
for(int i=0; i<filasD; i++){
 if(tablaD[i][1]==true){
 pinMode(asociacionD[i], OUTPUT);
 if(tablaD[i][0]==true)
 digitalWrite(asociacionD[i], HIGH);
 else
 digitalWrite(asociacionD[i], LOW);
 }
 else{
 pinMode(asociacionD[i], INPUT);
 }
}
}
void resetearValores(){
valoresIN_A[0] = "+A001-";
valoresIN_A[1] = "+A002-";
}
void leerCorriente(){
float valorVoltajeSensor;
float corriente=0;
long tiempo=millis();
float intensidadMaxima=0;
float intensidadMinima=0;
while(millis()-tiempo<500){//realizamos mediciones durante 0.5 segundos
 valorVoltajeSensor = analogRead(sensorIntensidad)*(5.0 /
1023.0);//lectura del sensor en voltios
 corriente=0.9*corriente+0.1*((valorVoltajeSensorvalorReposo)/sensibilidad);
 if(corriente>intensidadMaxima){
 intensidadMaxima=corriente;
 }
 if(corriente<intensidadMinima){
 intensidadMinima=corriente;
 }
}
intensidadPico = (((intensidadMaxima-intensidadMinima)/2)-ruido);
potencia = intensidadPico*0.707*230.0; //Intensidad RMS = Ipico/(2^1/2)
, P=I*V watts.
}