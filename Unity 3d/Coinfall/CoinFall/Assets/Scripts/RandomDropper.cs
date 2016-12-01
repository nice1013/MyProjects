using UnityEngine;
using System.Collections;

public class RandomDropper : MonoBehaviour {

	//Well need instantiated objects. Bitcoin and Dogecoin.
	public Transform dogecoin; 
	public Transform bitcoin;
	//Temp Value -Spawn Control 
	public int SpawnMax = 5; 
	public int SpawnCount = 0;

	public float TimeInbetween = 1f; //The Time inbetween Objects being Spawned. 
	private float StaticTimeInbetween = 1f; //The Time inbetween Objects being Spawned. 
	public float TimeIBleft = 0f; //This is the Time that is left between the spawn. --This is set to Timeinbetween at Start()
	private float AbsolutexRange = 12.5f;
	public float timeIncrements = .01f;







	// Use this for initialization
	void Start () {
	TimeIBleft = TimeInbetween; //Assigning Timeinbetween to TimeIBleft --We'll use to tell when were ready to spawn. 
	StaticTimeInbetween = TimeInbetween;

	//Here is where we WILL instantiate our objects. 20 dogecoin prefabs and 8 bitcoin prefabs. 
	

	//We also will instantiate particles. 10 dogecoin particles prefabs, 8 bitcoin particles.
	//There components should be turned off. 



	}//Ending Starting. 
	







	// Update is called once per frame
	void Update () {
	
		//Taking the time That Elaspe off of TimeIBleft. 
		TimeIBleft -= Time.deltaTime;

		if(TimeIBleft <= 0) {
		//If here we have no timeleft in between spawns. So well instantiate a new object.

		//We will Spawn A new object using this Function 
		SpawnRandomObject();

		//Adjust Time In Between Spawns. 
		adjustTimeInbetween();
		
		//Reset our TimeIBleft. 
		TimeIBleft = TimeInbetween;
		}

	}//Ending Update();
	



	//this will adjust the TimeInbetween each spawn based on the current streak we have.
	//To find Steaks look at Scirpts object, or StreakCounter.cs .
	void adjustTimeInbetween() {

		//we grab our streak from the scripts object
		int currentstreak = GameObject.Find ("Scripts").GetComponent<StreakCounter>().Streak;
		//if current streak is more than zero. 		
		if (currentstreak != 0 )
		{

			
		if (TimeInbetween <= .20f)	
			{


				TimeInbetween = .20f - (.0001f * currentstreak);// - (.001f * currentstreak);

			} 
			else 
			{			
			float timetotakeoff = timeIncrements * currentstreak;
			TimeInbetween = StaticTimeInbetween - timetotakeoff;
			}



		} else 
		{
		
			TimeInbetween = StaticTimeInbetween;

		}
		

	}



	void SpawnRandomObject() {

		//Instantiations need to be made from X[12.5f];
		//But inorder to make sure we use a full range of the screen. 
		//So we random a 2 more than needed and readjust it if neccesary. 
		float newDropx = Random.Range((-1 * AbsolutexRange) - 3, AbsolutexRange + 3);
		


		//Adjust NewDropx to the correct range, if needed.
		if (newDropx > AbsolutexRange)
			newDropx = AbsolutexRange;
		else if (newDropx < AbsolutexRange * -1)
			newDropx = AbsolutexRange * -1;
		//End Adjustments to newDropx

		

		//We are going to take Dropx and create follower plans. 
		



		//create a new vector3 with the newDropx as it's x co-ords. 
		Vector3 dropPoint = new Vector3( newDropx, 15, 0);
		
		
		//Call a random bool 
		int randomNum = Random.Range(0,100);
		
		
			
			if (randomNum < 80) {
				//If here --Randomly
				//-- We need to Instantiate a dogecoin. 
				Instantiate(dogecoin, dropPoint, Quaternion.identity);
				
			} else
			{
				
				//if here --Randomly 
				//--We need to Instaniate a Bitcoin.
				Instantiate(bitcoin, dropPoint, Quaternion.identity);
				
			}
			
			SpawnCount++;
			//Ending Temp if Statement	
		
	

	}



}
