using UnityEngine;
using System.Collections;
using System.Collections.Generic;

/*Default Setting Should be.
Time In Bewteen Spawns = .65; 
Time IBleft = 0; 
Time Increments 


*/

//This Class Handles Every Thing. 
//It controls Coin Spawns, Coin Speeds, 
public class Hal : MonoBehaviour {

	//Different Types of Vars 
	//-- Time, Objects, Managing Objects, Speeds, Debugging, Height, 


	//Well need instantiated objects. Bitcoin and Dogecoin.
	public Transform dogecoin; 
	public Transform bitcoin;
	public Transform litecoin; 
	public Transform scamcoin;


	//Time Related Vars
	public float TimeInbetween = .65f; //The Time inbetween Objects being Spawned. 
	private float StaticTimeInbetween = 1f; //The Time inbetween Objects being Spawned. 
	public float TimeIBleft = 0f; //This is the Time that is left between the spawn. --This is set to Timeinbetween at Start()
	private float AbsolutexRange = 12.5f; //The range on 'x' where objects will fall. 
	public float timeIncrements = .01f; //the amount of time that will be shaven off of TimeInbetween.

	//Coin Vars -- Managing The Coin Objects
	public int DogeToPreBuild = 20; //The amount of DogePrefabs to spawn out of sight.
	public int BtcToPreBuild = 10; //The amount of BTC Prefabs to spawn out of sight.
	public int LtcToPreBuild = 5; //The amount of LTC Prefabs to spawn out of sight.
	public int ScamToPreBuild = 5;//The amount of scam Coins to spawn. 

	private int currentDogeObject = 0;
	private int currentBtcObject = 0;
	private int currentLtcObject = 0;
	private int currentScamObject = 0;
	

	//These will hold a list of all their game objects. 
	public List<GameObject> DogePrefabList = new List<GameObject>(); 
	public List<GameObject> BtcPrefabList = new List<GameObject>();
	public List<GameObject> LtcPrefabList = new List<GameObject>();
	public List<GameObject> ScamPrefabList = new List<GameObject>();


	//Height the object will Die.
	public float heightboundary = -15f;




	//Speed Vars
	public float Yspeed = .25f;
	private float YspeedStatic; //hold the Yspeed at run. Start().
	public bool OtherWay = false;
	public float speedIncrements = .003f; //speed increments will use to adjust the spawn.

	//Debuging Vars
	public bool AddAsPoints = false;

	//Lowest speed before taper. 
	public float BetweenSpawnTimeTaperMin = 0.3f;
	public float TaperValue = .0001f;


	//Speed Controls - At what streak number will we user the cooresponding teir1speed.
	public int teir1 = 5; //Teir 1 -- Corresponds with speed
	public int teir2 = 20; 

	public float teir1Speed = .005f;
	public float teir2Speed = .001f;
	public float teir3Speed = .001f; //Even through there is only  2 teirs. teir3 is the last and final teir and didn't need to be said.




	// Use this for initialization
	void Start () {

	//Time Related. 
	TimeIBleft = TimeInbetween; //Assigning Timeinbetween to TimeIBleft --We'll use to us tell when were ready to spawn. 
	StaticTimeInbetween = TimeInbetween; //

	//Speed Stuff. 
	YspeedStatic = Yspeed; //Get object speed so we have it for use. 


	//SPAWN STUFF
	SpawnCoins();
	
	
	
	}

	
	void Awake() {
		Application.targetFrameRate = 60;
	}



	
	// Update is called once per frame
	void Update () {

		//Taking the time That Elaspe off of TimeIBleft. 
		TimeIBleft -= Time.deltaTime;
		
		if(TimeIBleft <= 0) {
			
			
			//We need to adjust coin for speed based on streak.			
			AdjustSpeedForStreak();
			setUpDown();


			//We need to create an Adjuster for time inbetwee. 
			//Adjust Time In Between Spawns. 
			adjustTimeInbetween();

			SendRandomCoin();


			
			//Use if statement and tell the next Coin to go. 
			
			//Reset our TimeIBleft. 
			TimeIBleft = TimeInbetween;
		}
		


	
	}


	

	//Takes a random coin from Doge, Btc, LTc, and scam, and start to move it 
	public void SendRandomCoin() {


	//Get X coord for this drop.
	float RandomXCoord = GetDropX( AbsolutexRange );
	
	
	GameObject tempPrefab = null;
	//If here we have no timeleft in between spawns. 
	//So well random a Object from the prefab list. 
	//Random odds for our Bitcoin and Dogecoin. 
		int ThisRandomNum = Random.Range(0,100); //Grab random range	

	//--DOGECOIN
	if (ThisRandomNum < 60)
	{
		//If we are greater than 20, then spawn a dogecoin. 
		
		//If here, we are going to spawn a Dogecoin prefab by, 
		//first moving it to a new generated x coords, y 15, z 0. 
		//next we tell the coin hal it can move, next we tell it the speed in which to move, 
		//then we tell it the height boundary to die at. 
		tempPrefab = GameObject.FindGameObjectsWithTag("Dogecoin")[currentDogeObject];
		
		tempPrefab.transform.position = new Vector3(RandomXCoord, 17f , 0f);
		tempPrefab.GetComponentInChildren<rotate>().enabled = true;
		tempPrefab.GetComponent<CoinHal>().MoveBool = true;
		tempPrefab.GetComponent<CoinHal>().Yspeed = Yspeed;
		tempPrefab.GetComponent<CoinHal>().heightboundary = heightboundary;
		
		
		if (currentDogeObject == DogeToPreBuild - 1)
		{
			currentDogeObject =0;
			
			
		}else 
		{
			
			currentDogeObject++;
		}
		
		
	}
	//--BITCOIN
	else if(ThisRandomNum < 80)//We are less than 20 and should spawn a bitcoin.
	{
		tempPrefab = GameObject.FindGameObjectsWithTag("Bitcoin")[currentBtcObject];
		
		tempPrefab.transform.position = new Vector3(RandomXCoord, 17f , 0f);
		tempPrefab.GetComponentInChildren<rotate>().enabled = true;
		tempPrefab.GetComponent<CoinHal>().MoveBool = true;
		tempPrefab.GetComponent<CoinHal>().Yspeed = Yspeed;
		tempPrefab.GetComponent<CoinHal>().heightboundary = heightboundary;
		
		if (currentBtcObject == BtcToPreBuild - 1)
		{
			currentBtcObject =0;
			
			
		}else 
		{
			
			currentBtcObject++;
		}
		

	}
	//--LITECOIN
	else if(ThisRandomNum < 90)//We are less than 20 and should spawn a bitcoin.
	{
		tempPrefab = GameObject.FindGameObjectsWithTag("Litecoin")[currentLtcObject];
		
		tempPrefab.transform.position = new Vector3(RandomXCoord, 17f , 0f);
		tempPrefab.GetComponentInChildren<rotate>().enabled = true;
		tempPrefab.GetComponent<BonusCoinHal>().MoveBool = true;
		tempPrefab.GetComponent<BonusCoinHal>().Yspeed = Yspeed;
		tempPrefab.GetComponent<BonusCoinHal>().heightboundary = heightboundary;
		
		if (currentLtcObject == LtcToPreBuild - 1)
		{
			currentLtcObject =0;
			
			
		}else 
		{
			
			currentLtcObject++;
		}
		

	}
	//--SCAMCOIN
	else if(ThisRandomNum <= 100)//We are less than 20 and should spawn a bitcoin.
	{
		tempPrefab = GameObject.FindGameObjectsWithTag("Scamcoin")[currentScamObject];
		
		tempPrefab.transform.position = new Vector3(RandomXCoord, 17f , 0f);
		tempPrefab.GetComponentInChildren<rotate>().enabled = true;
		tempPrefab.GetComponent<ScamCoinHal>().MoveBool = true;
		tempPrefab.GetComponent<ScamCoinHal>().Yspeed = Yspeed;
		tempPrefab.GetComponent<ScamCoinHal>().heightboundary = heightboundary;
		
		if (currentScamObject == ScamToPreBuild - 1)
		{
			currentScamObject =0;
			
			
		}else 
		{
			
			currentScamObject++;
		}
		

	}

















}






	//this will adjust the TimeInbetween each spawn based on the current streak we have.
	//To find Steaks look at Scirpts object, or StreakCounter.cs .
	void adjustTimeInbetween() {
		
		//we grab our streak from the scripts object
		int currentstreak = transform.GetComponent<StreakCounter>().Streak;
		//if current streak is more than zero. 		
		if (currentstreak != 0 )
		{
			
			
			if (TimeInbetween <= BetweenSpawnTimeTaperMin)	
			{
				
				
				TimeInbetween = BetweenSpawnTimeTaperMin - (TaperValue * currentstreak);// - (.001f * currentstreak);
				
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




	//Get Random Drop X. 
	float GetDropX (float AbsolutePosition)
	{

		//Instantiations need to be made from X[12.5f];
		//But inorder to make sure we use a full range of the screen. 
		//So we random a 2 more than needed and readjust it if neccesary. 
		float newDropx = Random.Range((-1 * AbsolutePosition) - 3, AbsolutePosition + 3);
		
		
		
		//Adjust NewDropx to the correct range, if needed.
		if (newDropx > AbsolutexRange)
			newDropx = AbsolutexRange;
		else if (newDropx < AbsolutexRange * -1)
			newDropx = AbsolutexRange * -1;
		//End Adjustments to newDropx
		
	
		return newDropx;

	}





	//we use this function to addspeed onto the Yspeed based on StreakCounter's Streak. 
	public void AdjustSpeedForStreak() {
		

		//Is streak = 0. If so, set the static speed.
		//Else, is the streak less than five. 

		//first we grab the streak.
		int streak = transform.GetComponent<StreakCounter>().Streak;
	
		if (streak == 0)
		{
			//if here the streak is zero. Reset the speed. 
			Yspeed = YspeedStatic;
			
		}else
		{
			
			//The next three are teirs for speed leveling. 
			if (streak < teir1)
			{
				//if here we need to ajust the speed in which objects fall. 
				float speedtoaddon = streak * speedIncrements + (streak * speedIncrements * teir1Speed);
				Yspeed = YspeedStatic + speedtoaddon;
				
			}
			else if (streak < teir2)
			{
				
				//if here we need to ajust the speed in which objects fall. 
				float speedtoaddon = streak * speedIncrements + (streak * speedIncrements * teir2Speed);
				Yspeed = YspeedStatic + speedtoaddon;
				
			}
			else 
			{
				
				//if here we need to ajust the speed in which objects fall. 
				float speedtoaddon = streak * speedIncrements + (streak * speedIncrements * teir3Speed);
				Yspeed = YspeedStatic + speedtoaddon;
				
			}
			
		}	
		
	}





	//SPEED STUFF
	//Set whether or not the values are positve or neg.
	public void setUpDown() {
		
		if(OtherWay == true)
		{
			//If here we want our direction to go down. 
			//Which means we need neg Y values. 
			//Now well multiply -1 against our Yspeed and redeclare it .  
			Yspeed = Yspeed * -1;
			
		}
		
	}
	




















	//Spawn Stuff.
	//Used to spawn all the coins needed in the beginning of the game. 
	//Will find all the coins by their tags, and inserts them into a list for use later on. 
 	void SpawnCoins() {
	
		int numzero = 0; //this is the number zero, used as control variable for while loops. For didn't work for some reason.
		
		GameObject TempDogePrefab = null;
		



		//--DOGECOIN--
		//Instantiate Dogecoins, and add it to Dogecoin list of objects.
		while (numzero < DogeToPreBuild)
		{
			
			TempDogePrefab = GameObject.Instantiate(dogecoin, new Vector3(0, 17, 0), Quaternion.identity) as GameObject;
			
			DogePrefabList.Add(TempDogePrefab);
			
			numzero++;
			
		}
		


		numzero = 0;
		
		//--BITCOIN--
		//Instantiate Bitcoin, and add it to Bitcoin list of objects
		while (numzero < BtcToPreBuild)
			
		{
			
			TempDogePrefab = GameObject.Instantiate(bitcoin, new Vector3(0, 17, 0), Quaternion.identity) as GameObject;
			
			BtcPrefabList.Add(TempDogePrefab);
			
			numzero++;
			
		}
		
		numzero = 0;



		//--LITECOIN--
		//Instantiate LITECOIN, and add it to LITECOIN list of objects
		while (numzero < LtcToPreBuild)
			
		{
			
			TempDogePrefab = GameObject.Instantiate(litecoin, new Vector3(0, 17, 0), Quaternion.identity) as GameObject;
			
			LtcPrefabList.Add(TempDogePrefab);
			
			numzero++;
			
		}
		
		numzero = 0;

		//--SCAMCOIN--
		//Instantiate SCAMCOIN, and add it to the SCAMCOIN list of objects
		while (numzero < ScamToPreBuild)
			
		{
			
			TempDogePrefab = GameObject.Instantiate(scamcoin, new Vector3(0, 17, 0), Quaternion.identity) as GameObject;
			
			ScamPrefabList.Add(TempDogePrefab);
			Debug.Log("HELLO, We have "+ScamPrefabList.Count+" Scam Prefabs");
			numzero++;
			
		}
		
		numzero = 0;





		


	}


}
