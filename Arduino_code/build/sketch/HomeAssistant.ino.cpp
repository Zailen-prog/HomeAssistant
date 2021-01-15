#include <Arduino.h>
#line 1 "d:\\Semestr 5\\Semestr 5\\IT\\IT PROJECT\\HomeAssistant\\HomeAssistant\\HomeAssistant.ino"
#include <SerialESP8266wifi.h>
#include <SoftwareSerial.h>
#include <OneWire.h>
#include <DallasTemperature.h>

#define tempPin 5
#define lightPin A0

//Add your data: SSID + KEY + host + location + id + password
//////////////////////////////////////////////
const char SSID_ESP[] = "NETIA 41 2,4";                 //Give EXACT name of your WIFI
const char SSID_KEY[] = "@5ddQrE7mFrU7@";               //Add the password of that WIFI connection
const char *host = "ithomeassistant.000webhostapp.com"; //Add the host without "www"
String ID = "Test123";                                  // ID the device so we can distinguish beetwen data from each device if we had more
// I set it to the user name of the account we gonna use on website

String url = "GET https://ithomeassistant.000webhostapp.com/getdata.php?";
unsigned long checkWifi = 0;
unsigned long sendTimer = 0;

float temperature; // temperatura
byte light_int;

/* deklaracja czujnika temperatury*/
OneWire oneWire(tempPin);
DallasTemperature temp_sensor(&oneWire);
DeviceAddress tempDeviceAddress;

SoftwareSerial ESP(3, 2); // rx tx
SerialESP8266wifi ESP8266(ESP, ESP, 4);

#line 32 "d:\\Semestr 5\\Semestr 5\\IT\\IT PROJECT\\HomeAssistant\\HomeAssistant\\HomeAssistant.ino"
void setup();
#line 51 "d:\\Semestr 5\\Semestr 5\\IT\\IT PROJECT\\HomeAssistant\\HomeAssistant\\HomeAssistant.ino"
void loop();
#line 91 "d:\\Semestr 5\\Semestr 5\\IT\\IT PROJECT\\HomeAssistant\\HomeAssistant\\HomeAssistant.ino"
void CollectData();
#line 100 "d:\\Semestr 5\\Semestr 5\\IT\\IT PROJECT\\HomeAssistant\\HomeAssistant\\HomeAssistant.ino"
void CreateURL();
#line 32 "d:\\Semestr 5\\Semestr 5\\IT\\IT PROJECT\\HomeAssistant\\HomeAssistant\\HomeAssistant.ino"
void setup()
{
  pinMode(tempPin, INPUT);
  pinMode(lightPin, INPUT);

  ESP.begin(9600);
  Serial.begin(9600);

  temp_sensor.begin();
  temp_sensor.getAddress(tempDeviceAddress, 0);
  temp_sensor.setResolution(tempDeviceAddress, 12);
  temp_sensor.setWaitForConversion(false);

  ESP8266.endSendWithNewline(true);
  Serial.println("Starting wifi");
  ESP8266.begin();
  ESP8266.connectToAP(SSID_ESP, SSID_KEY);
}

void loop()
{
  if (!ESP8266.isStarted())
    ESP8266.begin();

  if (millis() - checkWifi >= 30000)
  {
    if (!ESP8266.isResponding())
    {
      Serial.println("Not responding");
      ESP8266.begin();
    }
    else if (!ESP8266.isConnectedToAP())
    {
      ESP8266.begin();
      ESP8266.connectToAP(SSID_ESP, SSID_KEY);
    }
    checkWifi = millis();
  }

  if (millis() - sendTimer >= 1000)
  {
    CollectData();
    CreateURL();
    ESP8266.connectToServer(host, "80");
    ESP8266.send(SERVER, url);
    sendTimer = millis();
  }

  WifiMessage in = ESP8266.listenForIncomingMessage(1000);
  if (in.hasData)
  {
    if (in.channel == SERVER)
      Serial.println("Message from the server:");
    else
      Serial.println("Message a local client:");
    Serial.println(in.message);
  }
}

void CollectData()
{
  // pomiar temperatury
  temperature = temp_sensor.getTempC(tempDeviceAddress);
  temp_sensor.requestTemperatures();
  // pomiar natężenia światła
  light_int = (analogRead(lightPin) / 1024.0) * 100;
}

void CreateURL()
{
  url += "id=";
  url += ID;
  url += "&t1=";
  url += String(temperature);
  url += "&l1=";
  url += String(light_int);
}

