//#include <SPI.h>
#include <ArduinoJson.h>
#include "DHTesp.h" 
#include <ESP8266WiFi.h>
#define delayTime 300  // Time in seconds beetwen sendings
#define RELAY D4 //Relay que prende o apaga la bomba de agua
bool modoSTA = false;

//-----------------------------------------Access Point--------------------------------------
#include <EEPROM.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266mDNS.h>

ESP8266WebServer server(80); 

char* host = "";
const char* ssidAP = "iotplant";
const char* passwordAP = "12345678"; 
const char* host3="192.168.10.20"; //Dirección IP de la maquina local o servidor

char* el_ssid = "";
char* el_pass = "";

String ssid="", pass="", host1="";//reciben datos de formulario

const String INDEX_HTML =
"<!DOCTYPE html>"
"<html>"
"<head>"
  "<title>Datos</title>"
"</head>"
"<body>"
  "<form action='http://192.168.4.1/submit' method='POST'>"
    "<label>Enter ssid</label></br>"
    "<input type=\"text\" name=\"ssid\"><br>"
    "<label>Enter password</label></br>"
    "<input type=\"text\" name=\"pass\"><br>"
    "<input type=\"submit\" value=\"Submit\">" 
  "</form>"
"</body>"
"</html>";

const String MENSAJE =
"<!DOCTYPE html>"
"<html>"
"<head>"
  "<title>Datos ingresados</title>"
"</head>"
"<body>"
  "<h2><center>Conecte el pc a la red ingresada</center></h2>"
"</body>"
"</html>";


void returnOK(){
  Serial.println("--returnOK--");
  server.sendHeader("Connection","close");
  server.sendHeader("Access-Control-Allow-Origin","*");
  delay(3000);
  server.send(200, "text/html", MENSAJE); 
  modoSTA=true;
}

void handleSubmit(){
  if (server.args() > 0 ) {
      if (server.argName(0) == "ssid") {
        ssid= server.arg(0);
        Serial.print("ssid: ");
        Serial.println(ssid);
      }
      if(server.argName(1) == "pass"){
        pass = server.arg(1);
        Serial.print("pass: ");
        Serial.println(pass);
      } 
        returnOK();
  } else {
    returnFail("ERROR: Enter ssid and password");
  }
} 

void returnFail(String msg){
    server.sendHeader("Connection","close");
    server.sendHeader("Access-Control-Allow-Origin","*");
    server.send(500, "text/plain",msg+"\r\n");
}

void demon(){
    while(modoSTA==false){
          delay(2); 
          server.handleClient();
    }
    Serial.println("Sali del demon");
}

void handleRoot() {
    server.send(200, "text/html", INDEX_HTML);
} 
//-----------------------------------------Access Point--------------------------------------

unsigned long tiempo0 = 0; 
unsigned long tiempo4 = 0; 
unsigned long tiempo1 = 0; 
unsigned long tiempo2 = 0; 
unsigned long tiempo3 = 0; 
unsigned long tiempoFinal = 0;
bool releOn = false;
bool tEnvio1 = false;
bool tEnvio3 = false;

DHTesp dht;

const int httpPort = 80;
String PostData = "/iotplanta/web/index.php/me";//cambiar el hume    
String PostData2 = "/iotplanta/web/index.php/co";    
String response = "";
float consumo;
float bombeo = 0.01555;
String clave = "ABC123";//mykey que se debe generar random

//Setup
void setup() {
//-----------------------------------------Access Point--------------------------------------  
  Serial.begin(115200);
  Serial.println("--IF: Access Point--");                       //inicializamos el servidor
        WiFi.mode(WIFI_AP);
        WiFi.softAP(ssidAP, passwordAP);
        server.on("/", handleRoot);
        server.on("/submit", handleSubmit);
        server.begin();  
        demon();
        WiFi.disconnect();
        delay(100);
        WiFi.mode(WIFI_STA);
    
        WiFi.begin(ssid.c_str(), pass.c_str()); 
        while (WiFi.status() != WL_CONNECTED) {
          delay(1000);
          Serial.print("-");
        }
        Serial.print("WiFi conectado --> IP: "); 
        Serial.println(WiFi.localIP());
        Serial.println("Fin setup()");
//-----------------------------------------Access Point--------------------------------------
  dht.setup(D3, DHTesp::DHT11);//D3 es el sensor de humedad y temperatura ambiente
  pinMode(A0, INPUT); //A0 es el sensor de de humedad de la tierra
  pinMode(RELAY, OUTPUT);
  digitalWrite(RELAY, HIGH);
  // We start by connecting to a WiFi network
  Serial.println();
  Serial.print("Conectandose a la red: ");
  Serial.println(ssid);
 
}

//Loop
void loop(){
  if(tEnvio1==false){
    tiempo0 = millis();
    tEnvio1=true;
  }
  
  int hum_tierra = analogRead(A0);
  //Serial.print("Humedad Tierra:"); 
  //Serial.println(hum_tierra);
  float hum_aire = dht.getHumidity();
  float temp_aire = dht.getTemperature();

  if(hum_tierra>800){
    if(releOn==false){
      tiempo1 = millis();//tiempo desde que se enciende el rele
    }
    releOn = true;
    digitalWrite(RELAY, LOW);   // poner el Pin en HIGH 
    //Serial.println("Bomba encendida");
  }else{
    if(releOn==true){
      tiempo2 = millis(); 
      tiempoFinal = (tiempo2 - tiempo1)/1000;
      if(tiempoFinal!=0){
        Serial.print("Tiempo de riego: ");
        consumo = tiempoFinal*bombeo;//velocidad --> 120L/H
        Serial.println(tiempoFinal);
      }
      tiempo1=0;
      tiempo2=0;
    }      
      releOn = false;
      digitalWrite(RELAY, HIGH);
      //Serial.println("Bomba apagada"); 
  }
 
  tiempo3=millis();
  
  if(((tiempo3-tiempo0)/1000)>=30){
    tiempo0=0;
    tEnvio1=false;
    tiempo3 =0;
    //Create TCP connections
    WiFiClient client;
    if (!client.connect(host3, httpPort)) {
      Serial.println("Fallo en la conexion!!");
      return;
    }
    
      StaticJsonBuffer<200> jsonBuffer;
      char jsonn[300];//es de largo fijo
      JsonObject& root = jsonBuffer.createObject();
      root["humedad_tierra"] = hum_tierra;
      root["humedad_aire"] = hum_aire;
      root["temperatura_aire"] = temp_aire;
      root["mykey"] = clave;
      root.printTo(jsonn, sizeof(jsonn));
      Serial.println(jsonn);
      int largo = strlen(jsonn);
      Serial.print("largo json: ");
      Serial.println(largo);

      StaticJsonBuffer<200> jsonBuffer2;
      char jsonn2[300];//es de largo fijo
      JsonObject& root2 = jsonBuffer2.createObject();
      root2["consumo"] = consumo;
      root2["mykey"] = clave;
      root2.printTo(jsonn2, sizeof(jsonn2));
      
      if (client.connect(host3, 80)) {
        Serial.println("entre al json"); 
        client.println("POST "+PostData+" HTTP/1.1");
        client.print("Host: ");
        client.println(host3);
        client.println("Cache-Control: no-cache");
        client.println("Accept: application/json");
        client.println("Content-Type: application/json");//x-www-form-urlencoded
        //Serial.println("6");
        client.print("Content-Length: ");   
        //Serial.println("7"); 
        client.println(largo);
        //Serial.println("8"); 
        client.println();
        //Serial.println("9"); 
        client.println(jsonn);
        //Serial.println("10");     
        Serial.println("Medicion enviada..."); 

        if(consumo!=0){
            //envio del segundo json
            client.println("POST "+PostData2+" HTTP/1.1");
            client.print("Host: ");
            client.println(host3);
            client.println("Cache-Control: no-cache");
            client.println("Accept: application/json");
            client.println("Content-Type: application/json");//x-www-form-urlencoded
            client.print("Content-Length: ");    
            int largo2 = strlen(jsonn2);
            client.println(largo2);
            client.println();
            client.println(jsonn2);
            consumo = 0;
            Serial.println("Consumo enviado..."); 
        }
        
        long interval = 30000;
        unsigned long currentMillis = millis(), previousMillis = millis();
        while(!client.available()){
          if( (currentMillis - previousMillis) > interval ){
            Serial.println("Timeout");
            client.stop();     
            return;
          }
          currentMillis = millis();
        }
    }
  }  
}
