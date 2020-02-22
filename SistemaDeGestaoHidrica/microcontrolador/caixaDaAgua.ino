#include <MemoryFree.h>
#include <TimeLib.h>
#include <SD.h>
#include <SPI.h>
#include <Ethernet.h>
#include <EthernetUdp.h>
#include <Ultrasonic.h>
#include <stdlib.h>
//////////// ARQUIVOS DE CONFIGURACAO ///////////////
#define CONFIG_ARQ "config.txt"
#define IPCONFIG_ARQ "ipconfig.txt"
#define CONTAINER_CONFIG_ARQ "ppconfig.txt"
////////////// SENSOR DE DISTANCIA //////////////////
#define TRIGGER_PIN 44
#define ECHO_PIN 45
#define PUMP 7 //Define PUMP como 7
#define LED_OFF 6
////////////// SD///////////////////
#define CS_PIN 4
#define SS_PIN 53
#define SD_OUTPUT_PIN 10
#define CHAR_BUFFER  512
#define MSG_SIZE 1024
///////////////////////////////////
Ultrasonic ultrasonic(TRIGGER_PIN,ECHO_PIN);
IPAddress ipLocal(0, 0, 0, 0); 
IPAddress timeServer(0, 0, 0, 0); 
IPAddress gateway(0,0,0,0);
IPAddress masksubnet(0,0,0,0);
IPAddress dnsServer(0,0,0,0);
byte mac[6] = {0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED};
EthernetUDP Udp;
const unsigned int localPort = 8888;  // porta para ouvir os pacotes UDP
const unsigned int PORTA_SERVIDOR = 8081;  // porta para comunicação com o servidor

// --------Variáreis Sensor de Distância---------
boolean mensurar;
int contador;
char msg[2];
//////////////////////////////////////////////////
int timezone = 3;     // Central European Time
int TEMP_MAX_INATIVIDADE = 600;

struct WaterPump{
  time_t ultima_vez_desligado = now(); // when the digital clock was displayed
  time_t ultima_vez_ligado = now(); // when the digital clock was displayed
  char ultimo_evento[100];  
  bool bombaLigada = false;
  bool permitirLigamentoAutomatico = true;
  float vazao; // em L/min
  int ciclos_espera = 0;
} waterPump;

struct Container {
  float volume;
  float area_base;
  float altura;
  float distancia_correcao;
  float nivel_minimo;
  float nivel_maximo;
} container;

struct Usuario {
  String login = "";
  String senha = "";
  String hash;
  boolean logado = false;
  time_t hora_login;
  time_t ultima_acao;
} usuario;

EthernetServer * server;
/********************************/

////////////////////////////////////////////////////////////////////////////////////////

  /*
   *  ================================= UTILS===========================================
   */
   
////////////////////////////////////////////////////////////////////////////////////////



void displayIP(){
  Serial.println("================================");
  Serial.print("IP: ");
  Serial.println(ipLocal);
  Serial.print("NTP server: ");
  Serial.println(timeServer);
  Serial.print("dns server: ");
  Serial.println(dnsServer);
  Serial.print("gateway: ");
  Serial.println(gateway);
  Serial.println("================================");
}

void printDigits(int digits){
  // utility for digital clock display: prints preceding colon and leading 0
  Serial.print(":");
  if(digits < 10)
    Serial.print('0');
  Serial.print(digits);
}

void digitalClockDisplay(){
  // digital clock display of the time
  Serial.print(hour());
  printDigits(minute());
  printDigits(second());
  Serial.print(" ");
  Serial.print(day());
  Serial.print(" ");
  Serial.print(month());
  Serial.print(" ");
  Serial.print(year()); 
  Serial.println(); 
}

String getValue(String data, char separator, int index)
{
 int found = 0;
  int strIndex[] = {0, -1 };
  int maxIndex = data.length()-1;
  for(int i=0; i<=maxIndex && found<=index; i++){
  if(data.charAt(i)==separator || i==maxIndex){
  found++;
  strIndex[0] = strIndex[1]+1;
  strIndex[1] = (i == maxIndex) ? i+1 : i;
  }
 }
  return found>index ? data.substring(strIndex[0], strIndex[1]) : "";
}

String addDigitoZero(String valor){
    String result;
    if(valor.length() == 1){
      result = "0"+valor;
    }else{
      result = valor;
    }
    return result;
}

int contaChar(const char *str) 
{ 
    int i = 0;
    for(;str[i] != 0; ++i);
    return i; 
}

char * stringToCharArray(String value){
     char result[value.length()+1];
     value.toCharArray(result, sizeof(result));
     return result;
}

void logOffUsuario(){
     usuario.login = "";
     usuario.senha = "";
     usuario.hora_login = 0;
     usuario.logado = false;
}

void atualizaUltimaAcaoUsuario(){
  time_t log_usuario = now();
  if(log_usuario - usuario.ultima_acao <= TEMP_MAX_INATIVIDADE ){
    usuario.ultima_acao = log_usuario;
  }
}

void verificaUltimaAcaoUsuario(){
  time_t log_usuario = now();
  if(log_usuario - usuario.ultima_acao > TEMP_MAX_INATIVIDADE ){
    logOffUsuario();
  }
}

String status_view(){
  String statusBomba = "{";
  statusBomba += "\"volume\":\"";
  statusBomba += container.volume;
  statusBomba += "\", \"volume_total\":\"";
  statusBomba += (container.altura*container.area_base)/1000;
  statusBomba += "\", \"volume_minimo\":\"";
  statusBomba += (container.nivel_minimo*container.area_base)/1000;
  statusBomba += "\", \"volume_maximo\":\"";
  statusBomba += (container.nivel_maximo*container.area_base)/1000;
  statusBomba += "\", \"estado_atual\":\"";
  statusBomba += waterPump.bombaLigada;
  statusBomba += "\", \"ultimo_evento\":\"";
  statusBomba += waterPump.ultimo_evento;
  statusBomba += "\"";
  statusBomba += "}";
  return statusBomba;
}

String configuration_view(){
  String configPump = "{";
  configPump += "\"area_base\":\"";
  configPump += container.area_base;
  configPump += "\", \"altura\":\"";
  configPump += container.altura;
  configPump += "\", \"distancia_correcao\":\"";
  configPump += container.distancia_correcao;
  configPump += "\", \"nivel_minimo\":\"";
  configPump += container.nivel_minimo;
  configPump += "\", \"nivel_maximo\":\"";
  configPump += container.nivel_maximo;
  configPump += "\", \"vazao\":\"";
  configPump += waterPump.vazao;
  configPump += "\", \"estado_atual\":\"";
  configPump += waterPump.bombaLigada;
  configPump += "\", \"permitir_ligamento_automatico\":\"";
  configPump += waterPump.permitirLigamentoAutomatico;
  configPump += "\", \"tempo_espera\":\"";
  configPump += waterPump.ciclos_espera;
  configPump += "\", \"timezone\":\"";
  configPump += timezone;
  configPump +=  "\"";
  configPump += "}";
  return configPump;
}

IPAddress ipV4Configuration(String settingValue){
    byte ip_temp[4] = {0,0,0,0};
    int Index = settingValue.indexOf('.');
    int secondIndex = settingValue.indexOf('.', Index+1);
    int thirdIndex = settingValue.indexOf('.', secondIndex+1);
    String firstValue = settingValue.substring(0, Index);
    String secondValue = settingValue.substring(Index+1, secondIndex);
    String thirdValue = settingValue.substring(secondIndex+1, thirdIndex); //To the end of the string
    String forthValue = settingValue.substring(thirdIndex+1); //To the end of the string
    ip_temp[0] = firstValue.toInt();
    ip_temp[1] = secondValue.toInt();
    ip_temp[2] = thirdValue.toInt();
    ip_temp[3] = forthValue.toInt();
    IPAddress ipAddress(ip_temp[0],ip_temp[1],ip_temp[2],ip_temp[3]);
    return ipAddress;
}


void printDirectory(File dir, int numTabs) {
  while (true) {

    File entry =  dir.openNextFile();
    if (! entry) {
      // no more files
      break;
    }
    for (uint8_t i = 0; i < numTabs; i++) {
      Serial.print('\t');
    }
    Serial.print(entry.name());
    if (entry.isDirectory()) {
      Serial.println("/");
      printDirectory(entry, numTabs + 1);
    } else {
      // files have sizes, directories do not
      Serial.print("\t\t");
      Serial.println(entry.size(), DEC);
    }
    entry.close();
  }
}

void viewFileContent(EthernetClient cl, String myFile){
  File dataFile;
  char * file;
  
  Serial.print("Arquivo requisitado: ");
  file = new char[myFile.length() + 1];
  strcpy(file, myFile.c_str());
  Serial.println(file);
  
  dataFile = SD.open(file);
  // if the file is available, write to it:
  if (dataFile) {
      while (dataFile.available()) {
        cl.write(dataFile.read());
      }
      dataFile.close();
  }  
   // if the file isn't open, pop up an error:
  else {
    cl.write("erro: arquivo não encontrado");
  }
  free(file);
}

/*-------- NTP code ----------*/

const int NTP_PACKET_SIZE = 48; // NTP time is in the first 48 bytes of message
byte packetBuffer[NTP_PACKET_SIZE]; //buffer to hold incoming & outgoing packets

void sendNTPpacket(IPAddress &address)
{
  // set all bytes in the buffer to 0
  memset(packetBuffer, 0, NTP_PACKET_SIZE);
  // Initialize values needed to form NTP request
  // (see URL above for details on the packets)
  packetBuffer[0] = 0b11100011;   // LI, Version, Mode
  packetBuffer[1] = 0;     // Stratum, or type of clock
  packetBuffer[2] = 6;     // Polling Interval
  packetBuffer[3] = 0xEC;  // Peer Clock Precision
  // 8 bytes of zero for Root Delay & Root Dispersion
  packetBuffer[12]  = 49;
  packetBuffer[13]  = 0x4E;
  packetBuffer[14]  = 49;
  packetBuffer[15]  = 52;
  
  // all NTP fields have been given values, now
  // you can send a packet requesting a timestamp:
  Udp.beginPacket(address, 123); //NTP requests are to port 123
  Udp.write(packetBuffer, NTP_PACKET_SIZE);
  Udp.endPacket();
}

time_t getNtpTime()
{
  while (Udp.parsePacket() > 0) ; // discard any previously received packets
  Serial.println("Transmit NTP Request");
  sendNTPpacket(timeServer);
  uint32_t beginWait = millis();
  while (millis() - beginWait < 1500) {
    int size = Udp.parsePacket();
    if (size >= NTP_PACKET_SIZE) {
      Serial.println("Receive NTP Response");
      Udp.read(packetBuffer, NTP_PACKET_SIZE);  // read packet into the buffer
      unsigned long secsSince1900;
      // convert four bytes starting at location 40 to a long integer
      secsSince1900 =  (unsigned long)packetBuffer[40] << 24;
      secsSince1900 |= (unsigned long)packetBuffer[41] << 16;
      secsSince1900 |= (unsigned long)packetBuffer[42] << 8;
      secsSince1900 |= (unsigned long)packetBuffer[43];
      return secsSince1900 - 2208988800UL + timezone * SECS_PER_HOUR;
    }
  }
  Serial.println("No NTP Response :-(");
  return 0; // return 0 if unable to get the time
}

// send an NTP request to the time server at the given address


///////////////////////////////////////////////////////////////////////

void readSDSettings(char *file){
    char character;
    String settingName;
    String settingValue;
    String nameFile;
    File myFile;

    if (!SD.exists(file)) {
        myFile = SD.open(file,FILE_WRITE);
        myFile.close();     
        if (!SD.exists(file)) {
          Serial.print("O arquivo '");
          Serial.print(file);
          Serial.println("' nao pode ser criado");
        }else{
          Serial.print("O arquivo '");
          Serial.print(file);
          Serial.println("' foi criado com sucesso");
        }
    } 
       
    myFile = SD.open(file, FILE_READ);
    
    if (myFile) {
    while (myFile.available()) {
      character = myFile.read();
      while((myFile.available()) && (character != '[')){
        character = myFile.read();
      }
      character = myFile.read();
      while((myFile.available()) && (character != '=')){
        settingName = settingName + character;
        character = myFile.read();
      }
      character = myFile.read();
      while((myFile.available()) && (character != ']')){
        settingValue = settingValue + character;
        character = myFile.read();
      }
      if(character == ']'){
         char *cstr = new char[settingName.length() + 1];
         strcpy(cstr, settingName.c_str());
         if(strcmp(file,IPCONFIG_ARQ) == 0){
                if(strcmp(cstr,"IP") == 0){
                    ipLocal = ipV4Configuration(settingValue);
                }else if(strcmp(cstr,"GATEWAY") == 0){
                    gateway = ipV4Configuration(settingValue);
                }else if(strcmp(cstr,"SUBNET_MASK") == 0){
                    masksubnet = ipV4Configuration(settingValue);
                }else if(strcmp(cstr,"IP_SERVER") == 0){
                    timeServer = ipV4Configuration(settingValue);
                }else if(strcmp(cstr,"DNS_SERVER") == 0){
                    dnsServer = ipV4Configuration(settingValue);
                }
         }
         else if(strcmp(file,CONFIG_ARQ) == 0){
                if(strcmp(cstr,"TIMEZONE") == 0){
                      timezone = settingValue.toInt();
                }else if(strcmp(cstr,"HASH_CONN") == 0){
                      usuario.hash = settingValue;
                }
         }
         else if(strcmp(file,CONTAINER_CONFIG_ARQ) == 0){
                if(strcmp(cstr,"DISTANCIA_CORRECAO") == 0){
                      container.distancia_correcao = settingValue.toFloat();
                      Serial.print("Distancia de correcao: ");
                      Serial.println(container.distancia_correcao);
                }else if(strcmp(cstr,"AREA_BASE") == 0){
                      container.area_base = settingValue.toFloat();   
                      Serial.print("Area da base do container: ");
                      Serial.println(container.area_base);
                }else if(strcmp(cstr,"ALTURA") == 0){
                      container.altura = settingValue.toFloat();
                      Serial.print("Altura do container: ");
                      Serial.println(container.altura);
                }else if(strcmp(cstr,"NIVEL_MINIMO") == 0){
                      container.nivel_minimo = settingValue.toFloat();
                      Serial.print("Nivel minimo do container: ");
                      Serial.println(container.nivel_minimo);
                }else if(strcmp(cstr,"NIVEL_MAXIMO") == 0){
                      container.nivel_maximo = settingValue.toFloat();
                      Serial.print("Nivel maximo do container: ");
                      Serial.println(container.nivel_maximo);
                }else if(strcmp(cstr,"VAZAO") == 0){
                      waterPump.vazao = settingValue.toFloat();
                      Serial.print("Vazao da bomba: ");
                      Serial.println(waterPump.vazao);                      
                }else if(strcmp(cstr,"PERMITIRLIGAMENTOAUTOMATICO") == 0){
                      Serial.print("Ligamento Automatico: ");
                      if (settingValue.toInt() == 1){
                        waterPump.permitirLigamentoAutomatico = true;
                        Serial.println("Sim");              
                      }else{
                        waterPump.permitirLigamentoAutomatico = false;            
                        Serial.println("Não");              
                      }
                }else if(strcmp(cstr,"TEMPO_ESPERA") == 0){
                      waterPump.ciclos_espera = settingValue.toInt();
                }
         } 
         free(cstr);
                 
     }
     settingName = "";
     settingValue = "";
    }
    myFile.close();
   }
   else {
 // if the file didn't open, print an error:
      Serial.println("Erro na configuracao de parametros");
   }
}

bool iniciar_sd_card(int cs_pin, int sd_output_pin){
    int tentativa = 1;
    Serial.println("Inicializando o cartao SD...");
    //pinMode(sd_output_pin, OUTPUT);
    //digitalWrite(sd_output_pin,HIGH);
    pinMode (SS_PIN,OUTPUT);
    digitalWrite(SS_PIN,HIGH);
    while(!SD.begin(cs_pin)){
         Serial.print("Tentativa: ");
         Serial.print(tentativa);
         Serial.println(" (FALHOU)");
         Serial.println("Tentando novamente em 2 segundos....");
         tentativa++;
         delay(2000);
    }
    Serial.println("SD inicializado com sucesso.");
    return true;
}

void salvarLog(String statusBomba){
      String ano = String(year(),DEC);
      String mes = addDigitoZero(String(month(), DEC));
      String dia =  addDigitoZero(String(day(), DEC));
      String hora = addDigitoZero(String(hour(), DEC));
      String minuto = addDigitoZero(String(minute(), DEC));
      String segundo = addDigitoZero(String(second(), DEC));
      float quantidade_gasta = 0;
      String temp_path = "datalogs/" + ano;
      String temp_file = temp_path + "/"+ mes + ".txt";
      String mensagem = "";
      
      char *path = new char[temp_path.length() + 1];
      strcpy(path, temp_path.c_str());
    
      char *filename = new char[temp_file.length() + 1];
      strcpy(filename, temp_file.c_str());
            
      if(!SD.exists(path)){
        if(SD.mkdir(path)){
          Serial.print("Pasta de log criada com sucesso: ");
        }
        Serial.println(path);
      }
               
      mensagem = "["+ano+"-"+mes+"-"+dia+" "+hora+":"+minuto+":"+segundo+";"+statusBomba;
      if(waterPump.bombaLigada == false){
        quantidade_gasta = waterPump.vazao*((waterPump.ultima_vez_desligado - waterPump.ultima_vez_ligado)/60);
        mensagem += ";";
        mensagem += quantidade_gasta;
      }
      
      File dataFile = SD.open(filename, FILE_WRITE);
      mensagem += "]";
      //waterPump.ultimo_evento = new char[mensagem.length()+1];
      strcpy(waterPump.ultimo_evento, mensagem.c_str());
      if(dataFile){
        dataFile.println(waterPump.ultimo_evento);
        dataFile.flush();
        dataFile.close();
        // print to the serial port too:
        Serial.println(mensagem);
      }else{
        Serial.println("Erro ao salvar o log!");
      }
      free(path);
      free(filename);
}

///////////////////////////////////////LAN CONNECTION CONFIG/////////////////////////////////////////

void iniciar_ethernet(){
  //int porta = 8081;
 
  Ethernet.begin(mac, ipLocal, dnsServer, gateway, masksubnet);
  displayIP();
  Serial.print("Aguardando sincronizacao");
   //Ethernet.begin(mac);
  Serial.println("...");
  Udp.begin(localPort);
  int ano = 0;
  while(ano < 2016){
    setSyncProvider(getNtpTime);
    ano = year();
    if(ano < 2016){
      Serial.println("Erro na sincronizacao da data...");
      Serial.print("Verifique sua conexao com o servidor NTP: ");
      Serial.println(timeServer);
      Serial.println("Tentando novamente em 5 segundos....");
      delay(5000);
    }
  }
  server = new EthernetServer(PORTA_SERVIDOR);
  server->begin();
}

void comandaControlador(EthernetClient cl, String parametros){
      String dados_temp = "";
      String login_temp = "";
      String senha_temp = "";
      String hash_temp = "";
      char * dados;
          
      Serial.print("Chegou o comando: ");
      Serial.print(msg[0]);
      Serial.println(msg[1]);
      //COMANDO FOI ENVIADO
          
      if (msg[0] == '#'){
        if(usuario.logado){
          //for(int i = 2; msg[i] != '\0'; i++){
           //   parametros += msg[i];
          //}
          login_temp = getValue(parametros, ';', 1);
          senha_temp = getValue(parametros, ';', 2);
          hash_temp = getValue(parametros, ';', 3);
                  
          if(login_temp.equals(usuario.login) && senha_temp.equals(usuario.senha) && usuario.hash.equals(hash_temp)){
              switch(msg[1]) {
                  case 'L':
                        digitalWrite(PUMP,HIGH);
                        digitalWrite(LED_OFF,LOW);
                        waterPump.ultima_vez_ligado = now();
                        waterPump.bombaLigada = true;
                        salvarLog("Ligada manualmente");
                        mensurar = false;
                        contador = 2;
                        cl.write("true");
                        break;
                  case 'D':
                        digitalWrite(PUMP,LOW);
                        digitalWrite(LED_OFF,HIGH);
                        waterPump.ultima_vez_desligado = now();
                        waterPump.bombaLigada = false;
                        salvarLog("Desligada manualmente");
                        mensurar = false;
                        contador = 2;
                        cl.write("true");
                        break;
                  case 'S':
                        dados_temp = status_view();
                        dados = new char[dados_temp.length() + 1];
                        strcpy(dados, dados_temp.c_str());
                        //dados_temp.toCharArray(dados, dados_temp.length()+1);
                        cl.write(dados);
                        free(dados);
                        break;
                  case 'C':
                        dados_temp =  configuration_view();
                        dados = new char[dados_temp.length() + 1];
                        strcpy(dados, dados_temp.c_str());
                        cl.write(dados);
                        free(dados);
                        break;
                  
                  default:
                        cl.write("erro: comando incorreto");
                        break;  
               }
               
               atualizaUltimaAcaoUsuario();
           }else{
              dados_temp = "erro: outro usuário logado. (usuario: "+usuario.login+")";
              dados = new char[dados_temp.length() + 1];
              strcpy(dados, dados_temp.c_str());
              cl.write(dados);
              free(dados);
           }
        }else{
             cl.write("erro: não logado");
        }
        
    }
    else if(msg[0] == '&'){
      if(usuario.logado){
          File novoArquivo;
          char * message;
          //for(int i = 2; msg[i] != '\0'; i++){
          //    parametros += msg[i];
          //}
          login_temp = getValue(parametros, ';', 1);
          senha_temp = getValue(parametros, ';', 2);
          hash_temp = getValue(parametros, ';', 3);
          dados_temp = getValue(parametros, ';', 4);
         
          Serial.println(dados_temp);
          
          if(login_temp.equals(usuario.login) && senha_temp.equals(usuario.senha) && usuario.hash.equals(hash_temp)){
              switch(msg[1]) {
                 case 'B':
                      if(SD.exists(CONTAINER_CONFIG_ARQ)){
                          SD.remove(CONTAINER_CONFIG_ARQ);
                          novoArquivo = SD.open(CONTAINER_CONFIG_ARQ, FILE_WRITE);
                          novoArquivo.print(dados_temp);
                          novoArquivo.close();
                          if(SD.exists(CONTAINER_CONFIG_ARQ)){
                            Serial.println("Lendo novos parametros da bomba d'agua..."); 
                            readSDSettings(CONTAINER_CONFIG_ARQ);
                            Serial.println("Parametros da bomba atualizados!");
                          }
                      }
                      cl.write("Atualizado");
                      break;
                case 'L':
                      viewFileContent(cl, dados_temp);
                      break;
                case 'G':
                      if(SD.exists(CONFIG_ARQ)){
                          SD.remove(CONFIG_ARQ);
                          novoArquivo = SD.open(CONFIG_ARQ, FILE_WRITE);
                          novoArquivo.print(dados_temp);
                          novoArquivo.close();
                          if(SD.exists(CONFIG_ARQ)){
                            Serial.println("Lendo novos parametros da bomba d'agua..."); 
                            readSDSettings(CONFIG_ARQ);
                            setSyncProvider(getNtpTime);
                            Serial.println("Parametros da bomba atualizados!");
                          }
                      }
                      cl.write("Atualizado");
                      break;
                case 'X':
                      message = new char(dados_temp.length()+ 1);
                      strcpy(message, dados_temp.c_str());
                      if(SD.exists(message)){
                          if(SD.remove(message)){
                            cl.write("arquivo excluido com sucesso");
                          }else{
                            cl.write("erro na exclusao do arquivo");
                          }
                      }else{
                        cl.write("erro: arquivo nao encontrado");
                      }
                      free(message);
                      break;                          
                default:
                      cl.write("erro: comando incorreto");
                  break;
              }
              atualizaUltimaAcaoUsuario();
          }else{
             dados_temp = "erro: Usuario incorreto. (usuario: "+usuario.login+")";
             strcpy(dados, dados_temp.c_str());
             cl.write(dados);
             free(dados);
          }
      }else{
        cl.write("erro: nao_logado");
      }
    }else if(msg[0] == '!'){
         //for(int i = 2; msg[i] != '\0'; i++){
         //     parametros += msg[i];
         //}
         login_temp = getValue(parametros, ';', 1);
         senha_temp = getValue(parametros, ';', 2);
         hash_temp = getValue(parametros, ';', 3);            
         
         switch(msg[1]){
            case 'A':
                Serial.println(" -= Tentativa de Login no dispositivo =-");
                if(hash_temp.equals(usuario.hash)){
                    usuario.login = getValue(parametros, ';', 1);
                    usuario.senha = getValue(parametros, ';', 2);
                    usuario.hora_login = now();
                    usuario.logado = true;
                    usuario.ultima_acao = now();
                    Serial.println(usuario.login);
                    cl.write("true");
                }else{
                    Serial.println("erro na autenticacao");
                    cl.write("erro: não logado");
                }
                break;
            case 'V':
                Serial.println(" -= Verificacao de cliente =-");
                if(usuario.logado){
                    dados = new char[usuario.login.length()+1];
                    strcpy(dados, usuario.login.c_str());
                    //usuario.login.toCharArray(dados, usuario.login.length()+1);                
                    cl.write(dados);
                    free(dados);
                }else{
                    cl.write("erro: não logado");
                }
                break;
            case 'X':
                if((login_temp.equals(usuario.login) && senha_temp.equals(usuario.senha) && usuario.hash.equals(dados_temp))){
                    logOffUsuario();
                    cl.write("true");
                }else{
                    cl.write("erro: sem permissão para deslogar outro usuário");
                }
                break;
           default:
                break;
         } 
        
    }else{
        cl.write("dado incorreto");
    }
    
}


 void exec_ethernet(){
 
  EthernetClient client = server->available();
  Serial.println("\n\n -= Verificando clientes =-");
  char c;
  String content = "";
  if (client) {
    msg[0] = client.read();
    msg[1] = client.read();
    for(int i = 0; client.available() > 0; i++){
          c = client.read();
          content = content + c;
          //msg[i] = client.read();
    }
  
    //client.write(msg);
    //comando = client.read();
    Serial.println("=>    :) Chegou um cliente      <=");
    comandaControlador(client, content);
        // give the web browser time to receive the data
    
  }else{
    Serial.println(" :( Sem clientes*");
  }
   // give the web browser time to receive the data
    delay(1);
    client.stop();
  Serial.println("=======================================");
}

/////////////////////////////////////////////////////////////////////////////

/*
 *  Sensor UltraSonico
 */

void atualizarContainer(float distanciaSensor){
  //Volume em litros
  container.volume = ((container.altura - (distanciaSensor - container.distancia_correcao))*(container.area_base))/1000;
  if(container.volume < 0){
      container.volume = 0;
  }
}

void visualizarDadosContainer(){
  float volume_total;
  volume_total = ((container.altura)*(container.area_base))/1000;
  Serial.println("=============DADOS DO CONTAINER=============");
  Serial.print("Volume total: ");
  Serial.println(volume_total);
  Serial.println("--------------------------------------------");
  Serial.print("Volume atual: ");
  Serial.print(container.volume);
  Serial.println(" litros");
  Serial.println("--------------------------------------------");
}

void medicaoUltrasom(){
  
 
    bool mudouStatus = false;
    if(contador < 1){
        Serial.println();
        mensurar = true;
        contador = waterPump.ciclos_espera;     
    }
    if(mensurar == true){
      float cmMsec;
      long microsec = ultrasonic.timing();
   
      cmMsec = ultrasonic.convert(microsec, Ultrasonic::CM);
      atualizarContainer(cmMsec);
     
      visualizarDadosContainer();
      Serial.print("Distancia em cm: ");
      Serial.println(cmMsec);
  
      float distancia_max = container.distancia_correcao + container.altura - container.nivel_minimo;
      float distancia_min = container.distancia_correcao + container.altura - container.nivel_maximo;
  
      String mensagem = "";
      String statusBomba;
       if(cmMsec < distancia_min && waterPump.bombaLigada == true){
            mensurar = false;
            digitalWrite(PUMP,LOW);
            digitalWrite(LED_OFF,HIGH);
            waterPump.ultima_vez_desligado = now();
            waterPump.bombaLigada = false;
            statusBomba = "Desligada";
            mudouStatus = true;
             //if(waterPump.permitirLigamentoAutomatico){
       }else if(cmMsec > distancia_max && waterPump.bombaLigada == false && waterPump.permitirLigamentoAutomatico == true){
            mensurar = false;
            digitalWrite(PUMP,HIGH);
            digitalWrite(LED_OFF,LOW);
            waterPump.ultima_vez_ligado = now();
            waterPump.bombaLigada = true;
            statusBomba = "Ligada";
            mudouStatus = true;
       }
            
       if(mudouStatus == true){
          salvarLog(statusBomba);
       }
      
    }
    else{
        contador--; 
        Serial.print(contador);
        Serial.print("...");
    }
  
  
  delay(1000);
}

/*
 *  ======================  SD CARD FUNCTIONS ======================================
 */


////////////////////////////////////////////////////////////////////////////////////////////////////////////

void cria_arquivo(char * arqcriar, bool pasta = false){
    if(!SD.exists(arqcriar)){
        if(pasta){
          SD.mkdir(arqcriar);
        }else{
          File arqSite;
          arqSite = SD.open(arqcriar, FILE_WRITE);
          arqSite.close();
        }
        Serial.print(" -= O arquivo/pasta '");
        Serial.print(arqcriar);
        if(!SD.exists(arqcriar)){
           Serial.println("' nao pode ser criado(a) =-");
        }else{
          Serial.println("' foi criado(a) com exito =-");
        }
    }else{
        Serial.print(" -= O arquivo/pasta '");
        Serial.print(arqcriar);
        Serial.println("' ja existe");
    }
}

/////////////////////////////////////////////////////
//================ EXECUÇÃO PRINCIPAL

void setup() {
  mensurar = true;
  pinMode(PUMP,OUTPUT);
  pinMode (LED_OFF,OUTPUT);
  
  Serial.begin(9600);
  if(iniciar_sd_card(CS_PIN,SD_OUTPUT_PIN)){
     
     Serial.println("Lendo os parametros gerais..."); 
     readSDSettings(CONFIG_ARQ);
     Serial.println("Lendo os parametros da bomba d'agua..."); 
     readSDSettings(CONTAINER_CONFIG_ARQ);
     Serial.println("Lendo os parametros de configuracao IP..."); 
     readSDSettings(IPCONFIG_ARQ);
     
     delay(5000);
  }
  contador = waterPump.ciclos_espera;
  iniciar_ethernet();
  
}

time_t prevDisplay = 0; // when the digital clock was displayed

void loop() {

  Serial.print("-= Free RAM: ");
  Serial.print(freeMemory());
  Serial.println(" =-"); 
  if (timeStatus() != timeNotSet) {
    if (now() != prevDisplay) { //update the display only if time has changed
      prevDisplay = now();
    }
  }
  medicaoUltrasom();
  exec_ethernet();
  
  
  verificaUltimaAcaoUsuario();

}



