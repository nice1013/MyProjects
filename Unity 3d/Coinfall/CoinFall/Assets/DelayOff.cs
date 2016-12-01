using UnityEngine;
using System.Collections;

public class DelayOff : MonoBehaviour {

	public float delayTime = 1f; 
	public float dtStatic;
	public bool LightIsOn = false;



	//This script just turns off the light attatched to the object. 

	// Use this for initialization
	void Start () {
	
		dtStatic = delayTime;	

	}

	

	
	// Update is called once per frame
	void Update () {


	//If we have new information or this is the first run then the if is true.
	if (LightIsOn)
	{

		

		//check to see if we have ran out of time and should turn off the lights, if not than jus ttake time off.
		if (dtStatic <= 0) 
		{
			LightIsOn = false;
			
			dtStatic = delayTime;

		}else 
		{

		dtStatic -= Time.deltaTime;

		}
	
		GetComponent<Light>().enabled = LightIsOn;

	}


	




	}

}
