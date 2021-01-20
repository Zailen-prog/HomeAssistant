#include <DHT.h>

#include <ArduinoJson.h>

#define dht11 2
#define DHTTYPE DHT11
#define relay1 3
#define relay2 4
#define relay3 5
#define relay4 6
#define relay5 7
#define relay6 8
#define relay7 9
#define relay8 10
#define relay9 11
#define relay10 12

unsigned long Send_data_Timer = 0,
              collect_relays_state_Timer = 0,
              delay_timer = 0;

String message;
byte state;

DHT dht(dht11, DHTTYPE);

void setup()
{
  pinMode(relay1, OUTPUT);
  pinMode(relay2, OUTPUT);
  pinMode(relay3, OUTPUT);
  pinMode(relay4, OUTPUT);
  pinMode(relay5, OUTPUT);
  pinMode(relay6, OUTPUT);
  pinMode(relay7, OUTPUT);
  pinMode(relay8, OUTPUT);
  pinMode(relay9, OUTPUT);
  pinMode(relay10, OUTPUT);
  for (int i = 3; i < 13; i++)
  {
    digitalWrite(i, HIGH);
  }
  dht.begin();

  Serial.begin(115200);
  Serial.setTimeout(5000);
}

void loop()
{

  if (millis() - Send_data_Timer >= 15000)
  {
    Send_data_Timer = millis();
    if (Serial.available())
      Serial.readString();
    SendData();
  }

  if (millis() - collect_relays_state_Timer >= 2000)
  {
    if (Serial.available())
      Serial.readString();

    CollectRelaysState();
    collect_relays_state_Timer = millis();
  }
}

void SendData()
{
  DynamicJsonDocument doc(1024);
  doc["type"] = "save";
  doc["Humidity"] = dht.readHumidity();
  doc["Temp"] = dht.readTemperature();
  serializeJson(doc, Serial);
  Serial.println();
  deserializeJson(doc, Serial);
}

void CollectRelaysState()
{
  DynamicJsonDocument doc(1024);
  doc["type"] = "get";
  serializeJson(doc, Serial);
  Serial.println();
  DeserializationError error = deserializeJson(doc, Serial);
  if (error || doc[10]["send"] != 1)
  {
    return;
  }
  int i;
  for (i = 0; i < 10; i++)
  {
    state = doc[i]["state"];
    digitalWrite(i + 3, 1 - state);
  }
}
