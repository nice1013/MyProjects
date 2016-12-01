int analogPin = 3;     // Infrared Sensor (Right lead) connected to analog pin 3
                                    // outside leads to ground and +5V
double val = 0;                  // variable to store the value read
double avg = 0;
double sum = 0;
double count = 0;

void setup()
{
  Serial.begin(9600);          //  setup serial
}

void loop()
{
  
  
  

  
  //grab ir sensor reading
  val = analogRead(analogPin);    // read the input pin
  
  sum = sum + val; 
  
  count++; 
  
  avg = sum / count; 
  
  
  
  tone(9,avg);
  
  
  Serial.print("Value:");                           // debug value
  Serial.println(val);

   Serial.print("Average:");                           // debug value
  Serial.println(avg);
  
  delay(2);
  
}
