/*
Author: Rajat Bullakkanavar
Project: Smart Cart
Hardware Used: Node MCU,RFID Scanner,RFID Tags
*/


#define SS_PIN 4  //D2
#define RST_PIN 5 //D1

#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266WiFi.h>

IPAddress staticIP701_10(192,168,43,79);
IPAddress gateway701_10(192,168,1,1);
IPAddress subnet701_10(255,255,255,0);
String c;
WiFiServer server(80);

MFRC522 mfrc522(SS_PIN, RST_PIN);   // Create MFRC522 instance.
int statuss = 0;
int out = 0;
void setup() 
{
  Serial.begin(115200);   // Initiate a serial communication
  SPI.begin();      // Initiate  SPI bus
  mfrc522.PCD_Init();   // Initiate MFRC522
  

    WiFi.disconnect();
  delay(3000);
  Serial.println("START");
   WiFi.begin("qwerty","");
  while ((!(WiFi.status() == WL_CONNECTED))){
    delay(300);
    Serial.print("...");
}
  Serial.println("Connected");
  WiFi.config(staticIP701_10, gateway701_10, subnet701_10);
  Serial.println("your ip is");
  Serial.println((WiFi.localIP()));
  server.begin();
  
}
void loop() 
{
  // Look for new cards
  if ( ! mfrc522.PICC_IsNewCardPresent()) 
  {
    return;
  }
  // Select one of the cards
  if ( ! mfrc522.PICC_ReadCardSerial()) 
  {
    return;
  }
  //Show UID on serial monitor
  Serial.println();
  Serial.print(" UID tag :");
  String content= "";
  byte letter;
  for (byte i = 0; i < mfrc522.uid.size; i++) 
  {
     Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " ");
     Serial.print(mfrc522.uid.uidByte[i], HEX);
     content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " "));
     content.concat(String(mfrc522.uid.uidByte[i], HEX));
  }
  content.toUpperCase();
  Serial.println();
  if (content.substring(1) == "70 25 38 2B") //change UID of the card that you want to give access
  {
    statuss = 1;
     WiFiClient client = server.available();
    if (!client) { return; }
    while(!client.available()){  delay(1); }
    client.flush();
    client.println("HTTP/1.1 200 OK");
    client.println("Content-Type: text/html");
    client.println("");
    client.println("<!DOCTYPE HTML>");
    client.println("<html>");
    client.println("123");
    client.println("</html>");
    client.stop();
    delay(1);

  }
  
  else if(content.substring(1) == "E1 44 42 83")   {
   
   
    statuss = 1;
     WiFiClient client = server.available();
    if (!client) { return; }
    while(!client.available()){  delay(1); }
    client.flush();
    client.println("HTTP/1.1 200 OK");
    client.println("Content-Type: text/html");
    client.println("");
    client.println("<!DOCTYPE HTML>");
    client.println("<html>");
    client.println("180");
    client.println("</html>");
    client.stop();
    delay(1);

  }
    
  else{
     Serial.println(" Access Denied ");
    delay(3000);
  }
 
