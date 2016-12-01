using UnityEngine;
using System.Collections;

public class ScamCoinHal : MonoBehaviour {
	
	public bool MoveBool = false; //Determines if Object will move. Is Controlled By Hal, On Object 'Scripts'
	public float Yspeed = 0.0f;  //The speed in which the object falls. Is Controlled By Hal, On Object 'Scripts'
	public float heightboundary = -15f; //The Height in which an Action will be initiated. (Death/ Moved to Original Position.)
	public GameObject Scripts;
	private bool AddAsPoints;
	public bool Killself = false;
	public Transform coinParticle;
	public Transform DogecoinChildObject;
	public Transform forceField;
	
	
	
	
	
	void Start() {
		
		Scripts = GameObject.Find("Scripts");
		AddAsPoints = Scripts.GetComponent<Hal>().AddAsPoints;
		heightboundary = Scripts.GetComponent<Hal>().heightboundary;
		coinParticle = transform.FindChild("dogecoinParticle");
		DogecoinChildObject = transform.FindChild("Dogecoin");
		forceField = transform.FindChild("ForceField");
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//Original Design for Dogecoin. Changing for enemy
	// Update is called once per frame
	void Update () {
		
		//If time is running normal. 
		if (Time.timeScale == 1)
		{
			
			//Check to see if object should be moving and at what speed. 
			if (MoveBool == true)
			{
				//Now that speed has been changed, apply it to vector. 
				Vector3 yspeedvector = new Vector3(0f, Yspeed, 0f);
				//and translate it to the object. 
				transform.Translate(yspeedvector);
			}
			
			
			
			//if position have passed the boundary. Boundary based on down. 
			if(transform.position.y < heightboundary)
			{
				
				//if our addaspoints is false. We are running normal. 
				if (AddAsPoints == false)
				{

					//Move Object
					this.transform.position  = new Vector3(0f, 17f, 0f);
					this.transform.GetComponentInChildren<rotate>().enabled = false;
					MoveBool = false;
					//Instead of Destroying, we will Move the Object. 
					
				}
				else
				{
					//If here, we must be debugging. We act as if we hit the object and recieve the points. 
					this.transform.GetComponent<BasicMethods>().AddtoStreakandDestroy();
					
					this.transform.position  = new Vector3(0f, 17f, 0f);
					
					MoveBool = false;
					
				}		
			}
			
			
			
			
			
			
			
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
