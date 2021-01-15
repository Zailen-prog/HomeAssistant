#include <WiFiManager.h>
#include <ESP8266WiFi.h>
#include <ArduinoJson.h>
#include <WiFiClient.h>

#include <ESP8266HTTPClient.h>

byte humidity;

double temp;

String save_url = "http://192.168.1.2/db_handlers/save_data.php?",
       get_url = "http://192.168.1.2/db_handlers/send_to_esp.php?id=";

String output;
String id = "Test123";

void setup()
{
  Serial.begin(115200);
  Serial.setTimeout(5000);
  WiFiManager wm;
  wm.setDebugOutput(false);
  wm.autoConnect("ESP8266", "HomeAssistant");
}

void loop()
{
  if (handleIndex())
  {
    WiFiClient client;
    HTTPClient http;
    if (http.begin(client, output)) {
      int httpCode = http.GET();
      if (httpCode > 0) {
        if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) {
          String payload = http.getString();
          Serial.println(payload);
        }
      }
      http.end();
    }
  }
 
}

boolean handleIndex()
{
  if (Serial.available()) {
    DynamicJsonDocument doc(1024);
    DeserializationError error = deserializeJson(doc, Serial);
    if (error) {
      return 0;
    }
    if (doc["type"] == "save") {
      humidity = doc["Humidity"];
      temp = doc["Temp"];

      // Prepare the data for serving it over HTTP
      output = save_url + "id=" + id +
               "&Temp=" + String(temp) +
               "&Humidity=" + String(humidity);
      return 1;
    } else if(doc["type"] == "get"){
        output = get_url + id;
        return 1;
      }
    return 0;
  }
}
