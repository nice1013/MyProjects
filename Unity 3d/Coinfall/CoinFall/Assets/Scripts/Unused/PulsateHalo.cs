using UnityEngine;
using System.Collections;


//This script grabs hold of the halo that is on the same object. 
//it will grow from small to large and back. Then Repeat. 
public class PulsateHalo : MonoBehaviour {

		//Pulsate Rate
		public float pulsateRate = 1f;
		//The max it can grow.
		public float max = 5f;
		//The min it can grow.  
		public float min = 1f;

		//the current Range of the light
		public float current = 1f;

		


		//The Amount of Time inbetween Changes 
		public float PauseTime = .01f;
		
		//The amount of Pause Time Left. 
		public float ptLeft = 0;

		//Says whether we should be growing or shrinking the halo light. 
		public bool grow = true;

	// Use this for initialization
	void Start () {
		
		
		
	
	}
	
	// Update is called once per frame
	void Update () {
	//Update functions perform a straigh forward set of task. 
	//First it checks to see if we need to adjust the Range of light, based on how much time is left.
    //Then we increase/decrease value of 'current'/'range of light'. 
	 

		
		//Check to see if we need to adjust the halo / LIGHT. 
		if (ptLeft <= 0){
		//If here, we do need to adjust the lights.
		

		if(grow){
		//if here, we need the object grow
			
				// we need to increase the size of the halo. 
				current += pulsateRate; //Thats is what this is. 
	
				//next we check to see if we went over our max. If so, we will change the range to the max. and turn 'grow' OFF. 
				if(current > max) {
					current = max;
					this.GetComponent<Light>().range = max;		
					grow = !grow;

				}else
				{//if here, we are not over the max, and can set the new current to range. 
					this.GetComponent<Light>().range = current;
				}
				
		}
		else //end for grow
		{
		//if here, 'grow' is false. Which means we want the light range to decrease. 

			//Decrease the value of current. Remember*** Current will become the value of this object's Light's Range. 
			current -= pulsateRate;

			//Check to see if we under our min. If so, we will change the range to the min. and turn 'grow' ON. 
			if(current < min) {
					current = min;
					this.GetComponent<Light>().range = min;
					grow = !grow;
			}else 
			{//if Here, we are not lower than the min and can set Range to current. 
					this.GetComponent<Light>().range = current;

			}
		


		}//end if GROW

			ptLeft = PauseTime; //Reset the wait clock

		}//ENDING ptLeft <= 0



		ptLeft -= Time.deltaTime;




	}//ending update()

		



	
}
