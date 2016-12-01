using UnityEngine;
using System.Collections;

public class ScrollScript : MonoBehaviour {

	Vector3 lastInputPosition;

	float timeTillClickReset = .5f; //This is the value of timeLeft when ever the object is clicked. 
	float timeLeft = 0; //


	float MaxHeight = 60f; 
	float MinHeight = 13f; 

	float UpSpeed = 0;
	float DownSpeed = 0;


	float velocity = 0;
	float DV = 0;//Amount taken from velocity each update
	float ReturnVelocity = .25f;

	float smoothingTime = .1f; 
	float STLEFT = 0;

	// Use this for initialization
	void Start () {
		STLEFT = smoothingTime;
	}
	
	// Update is called once per frame
	void Update () {
	
		if(Input.GetButton("Fire1"))
		{
			//Take Mouse and get world position of click
			Vector3 mousePos = Input.mousePosition;
			mousePos.Set(mousePos.x, mousePos.y, 20f);
			Vector3 worldPos = Camera.main.ScreenToWorldPoint (mousePos);

			//Debug.Log("World Pos: "+worldPos);

			if(timeLeft <= 0) 
			{
				lastInputPosition = worldPos; 
				timeLeft = timeTillClickReset;
			}
			else
			if(lastInputPosition != worldPos) 
			{

				Vector3 movement = lastInputPosition - worldPos;


				velocity = movement.y;
				DV = velocity * .1f;

				//moving the object while staying within min and max heights. 
				if((-1 * movement.y) >= 0 && transform.position.y <= MaxHeight + 5f)
				{
				//transform.position += new Vector3(0, (-1 * movement.y) , (-1 * movement.y * .1f));
				transform.position += new Vector3(0, (-1 * movement.y) , 0);
				}
				else 
				if((-1 * movement.y) <= 0 && transform.position.y  >= MinHeight - 5f)
				{
				//transform.position += new Vector3(0, (-1 * movement.y) , (-1 * movement.y * .1f));
				transform.position += new Vector3(0, (-1 * movement.y) , 0);
				}



				Debug.Log("Movement was :"+ movement.y);
				//Log last position.
				lastInputPosition = worldPos; 

			}


		}
		else
		{


			if(velocity > 0 && transform.position.y  >= MinHeight - 5f)
			{
				transform.position += new Vector3(0, -velocity , 0);
			}
			else 
			if(velocity < 0  && transform.position.y <= MaxHeight + 5f)
			{
				transform.position += new Vector3(0, -velocity , 0);
			}

			Debug.Log("Velocity "+velocity);


			//Move Velocity closer to zero, until it should be zero.
			if(velocity > 0)
			{
				velocity -= DV;

				if(velocity < 0) 
				{
					velocity = 0;
				}
			}
			else
			if(velocity < 0)
			{
				velocity -= DV;
				
				if(velocity > 0) 
				{
					velocity = 0;
				}
			}


			if(transform.position.y > MaxHeight)
			{
				transform.position += new Vector3(0, -ReturnVelocity , 0);
			}
			
			if(transform.position.y < MinHeight)
			{
				transform.position += new Vector3(0, ReturnVelocity , 0);
			}

		}





		//Remove time.
		if(timeLeft > 0) 
		{
			timeLeft -= Time.deltaTime;
		}

		if(STLEFT > 0) 
		{
			STLEFT -= Time.deltaTime;
		}





	}
}
