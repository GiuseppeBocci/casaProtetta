#include <Ethernet.h>
#include <EthernetClient.h>
#include <EthernetUdp.h>
#include <SPI.h>
#define PIR_PIN 2
#define LED_PIN 7

bool state = false;

EthernetClient mailservice;
String path = "/deindicizzati/carattericsuali/inviamail.php";
String host = "192.168.1.x";

byte mac[] = {..., ..., ..., ..., ..., ...};
byte ip[] = {192, 168, 1, x};
String richiesta;

void setup() {
  pinMode(LED_PIN, OUTPUT);
  pinMode(PIR_PIN, INPUT);
  Ethernet.begin(mac, ip);
}

void loop() {
  if(digitalRead(PIR_PIN) == HIGH){
    if(!state){
      digitalWrite(LED_PIN, HIGH);
      state = true;
      while(!inviamail("")){
        Serial.println("Invio fallito!");
      }
      Serial.println("Invio riuscito!");
    }
  }else{
    if(state){
      digitalWrite(LED_PIN, LOW);
      state = false;
    }
  }
  delay(10);
}

bool inviamail(String PostData){
  mailservice.connect(host, 80);
  if (mailservice.connected()) {
    String request = "POST ";
    request.concat(path);
    request.concat(" HTTP/1.1");
    mailservice.println(request);
    mailservice.print("Host: ");
    mailservice.println(host);
    mailservice.println("User-Agent: ArduinoBocci/1.0");
    mailservice.println("Connection: close");
    mailservice.println("Content-Type: application/x-www-form-urlencoded;");
    mailservice.print("Content-Length: ");
    mailservice.println(PostData.length());
    mailservice.println();
    mailservice.println(PostData);
    mailservice.flush();
    mailservice.stop();
    return true;
  }
    mailservice.flush();
    mailservice.stop();
    return false;
 }
