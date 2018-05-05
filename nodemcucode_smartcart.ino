/*
Author: Rajat Bullakkanavar
Project: Smart Cart
Hardware Used: Node MCU,RFID Scanner,RFID Tags
*/



#define SS_PIN 4 //D2
#define RST_PIN 5 //D1
#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266WiFi.h>

String c;
MFRC522 mfrc522(SS_PIN, RST_PIN); // Create MFRC522 instance.
int statuss = 0;
int out = 0;

//WIFI PART
const char* ssid = "";
const char* password = "";
// Create an instance of the server
// specify the port to listen on as an argument
WiFiServer server(80);
String user_name = "test"; //Put here your username
String item_id = "3"; //Put the ID here, this should be same as the one put in cato table.
String payloadss = "username=" + user_name + "&" + "id=" + item_id ;//Dont change here

void setup()
{
  Serial.begin(115200); // Initiate a serial communication
  SPI.begin(); // Initiate SPI bus
  mfrc522.PCD_Init(); // Initiate MFRC522
  // pinMode(thro, OUTPUT);
  delay(3000);

  //WIFI PART
  delay(100);
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);
  WiFi.mode(WIFI_STA);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  Serial.print("Netmask: ");
  Serial.println(WiFi.subnetMask());
  Serial.print("Gateway: ");
  Serial.println(WiFi.gatewayIP());
}


const char* host = "198.54.115.190";
String PostData = "username=test";
String id;
String namee;
String price;

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
  String content = "";
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
}

  if (content.substring(1) == "70 25 38 2B") //change UID of the card that you want to give access
  {
    id = "2";
    namee = "iPhoneX";
    price = "100000";
    Serial.println(" id is 2 ");
  }
  else if (content.substring(1) == "E1 44 42 83")
  {
    id = "3";
    namee = "Lays";
    price = "10";
    Serial.println(" id is 3 ");
  }

  else if (content.substring(1) == "CB 9A F5 66")
  {
    id = "1";
    namee = "abcbiscuits ";
    price = "25 ";
    Serial.println(" id is 1 ");
  }
 else if (content.substring(1) == "6B 06 F2 66")
  {
    id = "4";
    namee = "bulb";
    price = "100";
    Serial.println(" id is 4 ");
  }

 else if (content.substring(1) == "BB B1 FB 66")
  {
    id = "5";
    namee = "menscasual";
    price = "5000";
    Serial.println(" id is 5");
  }
 else if (content.substring(1) == "0B 94 08 99")
  {
    id = "6 ";
    namee = "womenscasual";
    price = "6000 ";
    Serial.println(" id is 6 ");
  }

  else {
    Serial.println(" Access Denied ");
    delay(3000);
  }

  Serial.print("connecting to ");
  Serial.println(host);
  WiFiClient client;
  const int httpPort = 80;
  delay(6000);
  int stass = client.connect(host, httpPort);
  if (!stass) {
    Serial.println(stass);
    Serial.println("connection failed");
    return;
  }

  PostData += "&id=" + id;
  PostData += "&name=" + namee;
  PostData += "&price=" + price;
  client.println("POST /add.php HTTPS/1.1");
  client.println("Host: rajatmb.network");
  client.println("Cache-Control: no-cache");
  client.println("Content-Type: application/x-www-form-urlencoded");
  client.print("Content-Length: ");
  client.println(PostData.length());
  client.println();
  client.println(PostData);

  while (client.available()) {
    String line = client.readStringUntil('\r');
    Serial.print(line);
  }

  while (client.connected())
  {
    if ( client.available() )
    {
      char str = client.read();
      Serial.print(str);
    }
  }

  Serial.println();
  Serial.println("closing connection");
  client.stop();
  delay(3000);

 
  delay(8000);
}
