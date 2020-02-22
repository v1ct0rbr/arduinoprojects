/*
  *Verifica a medição de distância do sensor se for menos que 15, a lâmpada apaga. 
  *Caso contrário, a lâmpada acende.
 */

#include <Ultrasonic.h>

#define TRIGGER_PIN    44
#define ECHO_PIN       47
#define Lamp 7 //Define Lamp como 7
#define DISTANCIA 15.01
#define CICLOS 10

Ultrasonic ultrasonic(TRIGGER_PIN, ECHO_PIN);
boolean mensurar;
int contador;


// Only run 50 time so we can reburn the code easily.

void setup()
  {
  contador = CICLOS;
  mensurar = true;
  pinMode(Lamp,OUTPUT); //Define o pino 7 como saída
  Serial.begin(9600);
  Serial.println("Começando o teste de sensor....");
}

void loop()
  {

  if(contador < 1){
      Serial.println();
      mensurar = true;
      contador = CICLOS;
  }

  if(mensurar == true){
    float cmMsec;
    long microsec = ultrasonic.timing();

    cmMsec = ultrasonic.convert(microsec, Ultrasonic::CM);
    Serial.print("Distancia em cm: ");
    Serial.println(cmMsec);
  
    if(cmMsec < DISTANCIA){
      mensurar = false;
      digitalWrite(Lamp,LOW);
    }else{
      digitalWrite(Lamp,HIGH);
    }
  }else{
      contador--; 
      Serial.print(contador);
      Serial.print("...");
  }
   

  delay(1000);
}
