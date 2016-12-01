
void setup(){
  Serial.begin(9600);

  analogReference(EXTERNAL);		// set if Aref pin wired to 3.3V source


  Serial.println("Test started!");
}


void loop(){
  int x,y,z;
 x =analogRead(A0);
  y =analogRead(A1);
  z =analogRead(A2);
  Serial.print(millis()) ;
  Serial.print(", x=");
  Serial.print(x) ;
  Serial.print(", y=");
  Serial.print(y) ;
  Serial.print(", z=");
  Serial.println(z) ;
  delay(5);
}
