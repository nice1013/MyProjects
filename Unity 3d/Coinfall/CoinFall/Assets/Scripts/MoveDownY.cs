using UnityEngine;
using System.Collections;

public class MoveDownY : MonoBehaviour {

	public float yspeed = .5f; //Speed in which objects falls.
	private float yspeedStatic; //hold the yspeed at run. Start().
	public bool Down = true;	//bool helps auto correct the direction of object.
	public float speedIncrements; //speed increments will use to adjust the spawn.

	private bool addaspoints; //bool, helps debug.Transforms Deaths into Hits. it is Set by DebugHelper. on <Scripts>. 
	public float heightboundary; //says what heigh the object needs to be to die. 
	public GameObject Scripts;

	// Use this for initialization
	void Start () {
		setUpDown(); //change the y speed to the currect orrientation based on down. 
		yspeedStatic = yspeed; //Get object speed so we have it for use. 
		AdjustSpeedForStreak();
		Scripts = GameObject.Find("Scripts");
		addaspoints = GameObject.Find("Scripts").GetComponent<OnGui>().ConvertDeathsToPoints;
		heightboundary = GameObject.Find("Scripts").GetComponent<OnGui>().HeightObjectsDie;
		GameObject.Find("Scripts").GetComponent<OnGui>().MostRecentYSpeed = yspeed;
	
	}
	
	// Update is called once per frame
	void Update () {


		Debug.Log("We Are Updating");
		//If time is running normal. 
		if (Time.timeScale == 1)
		{
			Debug.Log("We Are Unpaused and Still Updating");
			//Get current streak.Adjust speed for it. 
			AdjustSpeedForStreak();
			//Now that speed has been changed, apply it to vector. 
			Vector3 yspeedvector = new Vector3(0f, yspeed, 0f);
			//and translate it to the object. 
			transform.Translate(yspeedvector);
		
			
	
			//if position have passed the boundary. Boundary based on down. Destroy Streak. BasicMethods.cs
			if(transform.position.y < heightboundary)
			{
				Debug.Log("We have Violated The Boundaries.");
				//if our addaspoints is false. We are running normal. 
				if (addaspoints == false)
				{
				Debug.Log("HERE");
				//Destorying the object cancling the Streak. (Depending on Level it will preform different actions).
				transform.GetComponent<BasicMethods>().DestroyandCancelStreak();
				//Tally the miss
				
				}
				else
				{
				//If here, we must be debugging. We act as if we hit the object and recieve the points. 
				transform.GetComponentInParent<BasicMethods>().AddtoStreakandDestroy();
				}		
			}


		}
	}

	
	//we use this function to addspeed onto the yspeed based on StreakCounter's Streak. 
	public void AdjustSpeedForStreak() {

		//first we grab the streak.
		int streak = GameObject.Find("Scripts").GetComponent<StreakCounter>().Streak;
		
		if (streak ==0 )
		{
			//if here the streak is zero. Reset the speed. 
			yspeed = yspeedStatic;

		}else
		{


			if (streak < 5)
			{
				//if here we need to ajust the speed in which objects fall. 
				float speedtoaddon = streak * speedIncrements + (streak * speedIncrements * .005f);
				yspeed = yspeedStatic + speedtoaddon;

			}
			else if (streak < 20)
			{
			
				//if here we need to ajust the speed in which objects fall. 
				float speedtoaddon = streak * speedIncrements + (streak * speedIncrements * .001f);
				yspeed = yspeedStatic + speedtoaddon;

			}
			else 
			{
				
				//if here we need to ajust the speed in which objects fall. 
				float speedtoaddon = streak * speedIncrements + (streak * speedIncrements * .02f);
				yspeed = yspeedStatic + speedtoaddon;
				
			}

		}	

	}



	public void Changespeed(float speed)
	{
		yspeed = speed;

	}




	//Set whether or not the values are positve or neg.
	public void setUpDown() {

		if(Down == true)
		{
			//If here we want our direction to go down. 
			//Which means we need neg Y values. 
			//Now well multiply -1 against our yspeed and redeclare it .  
			yspeed = yspeed * -1;
			speedIncrements = speedIncrements * -1;

		}

	}


}
