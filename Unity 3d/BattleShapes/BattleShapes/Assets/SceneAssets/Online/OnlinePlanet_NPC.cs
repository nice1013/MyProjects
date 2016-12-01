using UnityEngine;
using UnityEngine.UI;
using System.Collections;
using System.Collections.Generic;

public class OnlinePlanet_NPC : MonoBehaviour {
	
	public int units = 0;
	public Text unitDisplay; 
	
	
	float TimeTillSpawn = 3f; 
	public float TimeLeftTillSpawn;

	public bool DONOTGROW = false;
	public string type = "player1"; //This determines which player this object is. 
	public string typeAtEndOfUpdate = "";
	public string LastHitBy = "";
	

	OnlineSpawnShips SSscript;
	OnlineSelector onlineselector;
	OnlineSpawnShips OSS;
	
	public bool CanExplode = true;
	public int ExplodeValue = 20;
	public int RunningExplodeValue = 0; //At Start() is set to ExplodeValue. At zero, this planet will self destruct.
	public float SDRunningTime = 0;
	
	public int planetSize = 1;
	public int[] scales = new int[] {3, 4, 5}; //The size of this game object. X Y and Z are all the same value.
	float[] SpawnRates = new float[] {3f, 2f, 1f}; //The rate a unit will spawn

	//Our Defense System is based of of popular board game dice rolling. 
	//With 1 Unit in the base, The player has a 33% chance of defending his planet. 
	float ChanceForBlockLow = 16.6f;
	//Our Highest Block rate, is 66%. This is when the planet is deemed full. 
	float ChanceForBlockHigh = 66.6f; 
	//Our Planet is deemed full at Planet Size * This Number 
	float ChanceFull = 15f;
	//Our Next Float Value, is our increment for Chance. It's calculated by dividing the difference of (ChanceForBlockHigh and ChanceForBlockLow) by ChanceFull;
	float ChanceIncrement = 0f;
	float[] SphereColliderSize = new float[] {.5f, .4f, .3f};


	
	NetworkView netview;

	void Awake() {
		TimeTillSpawn = SpawnRates[planetSize - 1];
		transform.localScale = new Vector3((float) scales[planetSize - 1], (float) scales[planetSize - 1], (float) scales[planetSize - 1]);
		type = type.ToLower();
		RunningExplodeValue = ExplodeValue * (2 + planetSize);
		SDRunningTime = TimeTillSpawn;
		SSscript = GetComponent<OnlineSpawnShips>();
		SSscript.owner = type;
		onlineselector = GetComponent<OnlineSelector>();
		netview = GetComponent<NetworkView>(); 
		OSS = GetComponent<OnlineSpawnShips>();
	}
	
	
	
	// Use this for initialization
	void Start () {
		
		TimeLeftTillSpawn = TimeTillSpawn;		
		GetComponent<SphereCollider>().radius = SphereColliderSize[planetSize];
		updateUnitDistplay();
	}
	
	// Update is called once per frame
	void Update () {
		
		
		//Check if planet exploded. 
		if(CanExplode) 
		{
			CheckForSelfDestruct();
			
			if(SDRunningTime <= 0)
			{
				SDRunningTime = TimeTillSpawn;
				
				if(RunningExplodeValue < ExplodeValue * (2 + planetSize))
				{
					RunningExplodeValue++;
				}
			}
			else
			{
				SDRunningTime -= Time.deltaTime;
			}
		}
		
		
		
		if(Network.isServer) 
		{
			//Remove time from respawn clock. 
			if (TimeLeftTillSpawn <= 0 && type != "blank" && DONOTGROW != true) {
				//Spawn time has ran out. Type does not equal "Blank", add 1 to units.
				AddAndcheckIfLostPlanet();	
				
				//If Self Destruct is enabled.
				
				TimeLeftTillSpawn = TimeTillSpawn;
			}
			else {
				TimeLeftTillSpawn -= Time.deltaTime;
			}
		}
		
		


		useTYPEtoFINDplanet();
		
		

		
		
		
	

	}
	

	void useTYPEtoFINDplanet()  {

		if(type != typeAtEndOfUpdate) 
		{
			//Check which shape is in control of planet. 
			if (type.ToLower() == "player1") { 
				transform.FindChild ("Blank").gameObject.GetComponent<Renderer>().enabled = false;
				transform.FindChild ("Player2").gameObject.GetComponent<Renderer>().enabled = false;
				transform.FindChild ("Player1").gameObject.GetComponent<Renderer>().enabled = true;
				if(Network.isServer) 
				{
					netview.RPC ("setPlanet", RPCMode.All, new object[] {type});
				}
			} else if (type.ToLower() == "player2") { 
				transform.FindChild ("Blank").gameObject.GetComponent<Renderer>().enabled = false;
				transform.FindChild ("Player1").gameObject.GetComponent<Renderer>().enabled = false;
				transform.FindChild ("Player2").gameObject.GetComponent<Renderer>().enabled = true;
				if(Network.isServer) 
				{
					netview.RPC ("setPlanet", RPCMode.All, new object[] {type});
				}
			} else if (type.ToLower() == "blank") { 
				transform.FindChild ("Player1").gameObject.GetComponent<Renderer>().enabled = false;
				transform.FindChild ("Player2").gameObject.GetComponent<Renderer>().enabled = false;
				transform.FindChild ("Blank").gameObject.GetComponent<Renderer>().enabled = true;
				if(Network.isServer) 
				{
					netview.RPC ("setPlanet", RPCMode.All, new object[] {type});
				}
			}
		}
		typeAtEndOfUpdate = type;
	}

	//Check to see if planet should self destruct from warfare. 
	public void CheckForSelfDestruct() {
		if(RunningExplodeValue <= 0)  
		{
			//Grab the list of ships currently active.
			GameObject[] player1ships = GameObject.FindGameObjectsWithTag("Player1Ship");
			GameObject[] player2ships = GameObject.FindGameObjectsWithTag("Player2Ship");
			List<GameObject> listOfShips = new List<GameObject>();
			foreach(GameObject obj in player1ships)
			{
				listOfShips.Add(obj);
			}
			foreach(GameObject obj in player2ships)
			{
				listOfShips.Add(obj);
			}

			//Check Each Object to see if their destination was this planet. 
			//If it was. Tell that planet to start it's death cycle. 
			foreach(GameObject obj in listOfShips) 
			{
				if(obj.GetComponent<Ship_NPC>().destination.name.ToLower() == transform.name.ToLower())
				{
					//We match this Ship_NPC's destination. Start the Ship_NPC's Death Cycle. 
					obj.GetComponent<Ship_NPC>().startDeathCycle();
				}
			}
			Destroy(this.gameObject);
		}
		
	}
	


	private void OnSerializeNetworkView(BitStream stream, NetworkMessageInfo info) {

		if (stream.isWriting) {
			//Network Owner is writing
			stream.Serialize(ref units);
		} else {
			//We are recieving.
			stream.Serialize(ref units);
			updateUnitDistplay();
		}
	}


	[RPC] 
	void setPlanet(string _planetType) 
	{ 
		type = _planetType;
		SSscript.owner = type;
	}

	[RPC]
	void setTypewithName(string _planetType, string _planetName) 
	{ 
		if(_planetName.ToLower() == transform.name.ToLower()) 
		{
			type = _planetType;
			SSscript.owner = type;
		}
	}

	
	void checkIfLostPlanet() {
		//If units are less than zero. Switch teams. 
		if (units < 0) {
			units = units * -1; //Fix count.


			type = LastHitBy;
			SSscript.owner = type;


			//If this planet is selected, tell inputManager to reset. 
			if(onlineselector.getIsSelected())
			{
				onlineselector.setIsSelected(false);
				GameObject.Find("InputManager").GetComponent<InputManager>().resetScript();
			}
			
		}
		
	}
	
	
	public void RemoveAndcheckIfLostPlanet() {
		//If units are less than zero. Switch teams. 
		units -= 1;
		
		if (units < 0) {
			units = 0;
			
			type = LastHitBy;
			SSscript.owner = type;
			
			//If this planet is selected, tell inputManager to reset. 
			if(onlineselector.getIsSelected())
			{
				onlineselector.setIsSelected(false);
				GameObject.Find("InputManager").GetComponent<InputManager>().resetScript();
			}
			
		}
		
		updateUnitDistplay();
		
	}
	
	
	public void AddAndcheckIfLostPlanet() {
		//If units are less than zero. Switch teams.
		if(Network.isServer) 
		{
			units += 1;
			netview.RPC("addUnitToClient", RPCMode.All, new object[] {units, transform.name});

		}

		updateUnitDistplay();
	}
	
	[RPC] 
	public void addUnitToClient(int _value, string _PlanetName) {
	
		if(Network.isClient)
		{
			if(transform.name == _PlanetName) 
			{
			units = _value;
			updateUnitDistplay();
			}
		}

	}
	
	//Resets the time TimeTillSpawn to its 
	public void resetSpawnTime(float input)  {
		
		TimeLeftTillSpawn = TimeTillSpawn ;
	}
	
	public bool shipHit(string owner) {
		LastHitBy = owner;
		//If ship is from our team. add units. if not, take away.
		if (owner.ToLower () == type.ToLower ()) {
			
			AddAndcheckIfLostPlanet();
			return true;
			
		} else {
			
			
			RunningExplodeValue--;
			//Get Random Number
			int tmpRndNum = Random.Range(0, 100);


			//Get Block Chance for this planet. 
			float BlockChance = GetBlockChance();
			
			
			if(tmpRndNum < BlockChance  && type.ToLower() != "blank" && units > 0) {
				//Ship Was Blocked.
				Debug.Log("Blocked!"+"Block Chance Was:"+BlockChance+" Over a random value of:"+tmpRndNum);
				return false;
			}
			else {
				//Ship Has Passed Through. 
				RemoveAndcheckIfLostPlanet();
				resetSpawnTime (2);
				return true;
			}
		}
	}


	
	public float GetBlockChance() {
		
		//Units are greater than our value for full. It's too high, return our max for block chance.
		if(units > (int) ChanceFull * planetSize) 
		{
			return ChanceForBlockHigh;
		}
		else
		{
			float tempInc = ChanceIncrement / planetSize;
			
			return ((tempInc * units) + ChanceForBlockLow);
		}
	}

	
	public void updateUnitDistplay() {
		unitDisplay.text = units.ToString ();
	}

	[RPC]
	public void setName(string _name) {
		transform.name = _name;
	}

	[RPC] 
	public void SpawnShips(bool isServerPlayer, string targetPlanetName){


		//Get Unit Values from the planet we are about to send troops from.
		int curUnits = (int) (units * GameObject.Find("UnitHandler").GetComponent<UnitPercentageHandler>().P1percentage);
		OSS.target = GameObject.Find(targetPlanetName); //Setting the targert planet
		//Telling script that there is units to deploy.
		if (isServerPlayer) {
			OSS.setDeployPlayer1Ships(curUnits);
		} else
		{
			OSS.setDeployPlayer2Ships(curUnits);
		}
	}
}
