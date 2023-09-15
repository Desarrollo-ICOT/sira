#include <Arduino.h>

// Librerías
#include <SPI.h>
#include <MFRC522.h>

// Pines SPI
#define RST_PIN 9
#define SS_PIN 10
 
// Instancia a la clase MFRC522
MFRC522 mfrc522(SS_PIN, RST_PIN);

const int MILISEGUNDOS_ESPERA = 500;

// put function declarations here:
int myFunction(int, int);

void setup()
{
  // put your setup code here, to run once:
  // int result = myFunction(2, 3);
  pinMode(LED_BUILTIN, OUTPUT);
}

void loop()
{
  // put your main code here, to run repeatedly:
  digitalWrite(LED_BUILTIN, HIGH);
  delay(MILISEGUNDOS_ESPERA);
  digitalWrite(LED_BUILTIN, LOW);
  delay(MILISEGUNDOS_ESPERA);
}

// put function definitions here:
int myFunction(int x, int y)
{
  return x + y;
}