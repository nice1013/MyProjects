#include <SPI.h>

int speaker = 10;  //pin number for speaker
int whiteled = 11; // pin number for whiteled
int const limit = 10; // limit for measurement array
int marray[limit]; //measurement array.
int tracker = 0; //tracker for telling which array we are on.


void setup() {

  
  pinMode (2,OUTPUT);//attach pin 2 to vcc
  pinMode (5,OUTPUT);//attach pin 5 to GND
  pinMode(speaker, OUTPUT);// attach pin 3 to Tri
  pinMode(whiteled, OUTPUT);// attach pin 3 to Tri
  // initialize serial communication:
  Serial.begin(9600);
}

void loop()
{
  
  
  
digitalWrite(2, HIGH);
  // establish variables for duration of the ping,
  // and the distance result in inches and centimeters:
  long duration, inches, cm;



  // The PING))) is triggered by a HIGH pulse of 2 or more microseconds.
  // Give a short LOW pulse beforehand to ensure a clean HIGH pulse:
  pinMode(3, OUTPUT);// attach pin 3 to Trig
  digitalWrite(3, LOW);
  delayMicroseconds(2);
  digitalWrite(3, HIGH);
  delayMicroseconds(5);
  digitalWrite(3, LOW);

  

  // The same pin is used to read the signal from the PING))): a HIGH
  // pulse whose duration is the time (in microseconds) from the sending
  // of the ping to the reception of its echo off of an object.
  pinMode (4, INPUT);//attach pin 4 to Echo
  duration = pulseIn(4, HIGH);

  // convert the time into a distance
  inches = microsecondsToInches(duration);
  cm = microsecondsToCentimeters(duration);
 
  //insert measurement into array
  marray[tracker] = inches;
  
  //sum for, for loop. 
  int sum = 0; 
  
  for (int i = 0; i <= limit; i++)
  {

    sum += marray[i];
    
    
    Serial.print("Sum");
     Serial.print(i);
     Serial.print(":");
     Serial.print(marray[i]);
    Serial.print(", ");
    Serial.print("Total:");
    Serial.print(sum);
    Serial.print(", ");
    Serial.println();
  }
  

 double avg = sum / limit;
 

   
 
  Serial.print(inches);
  Serial.print("in, ");
  Serial.print(avg);
  Serial.print("avg");
  Serial.println();
 
  delay(100);
  
  
  
  

  
if (inches > 20)
{
  

  digitalWrite(whiteled, HIGH);
  noTone(speaker);
 

  
}  
 else  {
  
  digitalWrite(whiteled, LOW);
  tone(speaker, (inches * -1 + 35) * 20);
  


}
















//if tracker is lower than limit.
if (tracker < limit) 
{

tracker++;
}
else 
{
//if not reset it to 0; 
tracker = 0;
  
}
  
}



long microsecondsToInches(long microseconds)
{
  // According to Parallax's datasheet for the PING))), there are
  // 73.746 microseconds per inch (i.e. sound travels at 1130 feet per
  // second).  This gives the distance travelled by the ping, outbound
  // and return, so we divide by 2 to get the distance of the obstacle.
  // See: http://www.parallax.com/dl/docs/prod/acc/28015-PING-v1.3.pdf
  return microseconds / 74 / 2;
}

long microsecondsToCentimeters(long microseconds)
{
  // The speed of sound is 340 m/s or 29 microseconds per centimeter.
  // The ping travels out and back, so to find the distance of the
  // object we take half of the distance travelled.
  return microseconds / 29 / 2;
}



