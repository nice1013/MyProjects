using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using System;
/* IDEA 
 * Making a move will now involve.
 * Collect Units from AI Planets. Have Total, and Seperate. 
 * Collect Units from Opponent, Have Total and Serperate. 
 * Find a pl
 */
public class AI_PlanetControl : MonoBehaviour {
	
	List<GameObject> planets = new List<GameObject>();  //Total List. 
	List<GameObject> myPlanets = new List<GameObject>(); //This script's planets
	List<GameObject> theirPlanets = new List<GameObject>(); //The opponents players.
	List<GameObject> neutralPlanets = new List<GameObject>(); //The opponents players.
	List<GameObject> AllOtherPlanets = new List<GameObject>(); //The opponents players.
	
	public int Player_Spot = 1; //If two it will switch teams. 
	//List of teams
	public string TYPE_myPlanet = "Player2";
	public string TYPE_theirPlanet = "Player1"; 
	public string TYPE_neutralPlanet = "Blank";
	GameObject OurPlanet;
	
	GameObject LastAttackedPlanet; 
	
	float timeleft = 0;
	
	public float TIMETILLMOVE = 5f;
	public bool useRandomTime = false;
	public float[] RandomRanges = new float[] {1.0f, 5.0f};

	bool CountDownIsDead = false;
	public bool canmove = false;

	void Awake(){ 
		CheckPlayerSpots();
	}
	
	// Update is called once per frame
	void Update () {
		if(CountDownIsDead == false) 
		{
			if(GameObject.Find("CountDown") == null)
			{
				CountDownIsDead  = true;
				canmove = true;
			}
		}
		else
		{
		checkMoveTime();
		IfCanMove();
		}
	}
	
	//Checks if the AI can move. If it can, it executes the MakeMove function.
	void IfCanMove() {
		if(canmove){
			MakeMove();
			canmove = false;
		}
	}
	
	//Checks if we are using a random or constant time. Also Deducts delta time from the running clock variable timelft. 
	void checkMoveTime() {
		
		if(timeleft <= 0) 
		{
			canmove = true;
			
			if(useRandomTime){
				timeleft = UnityEngine.Random.Range(RandomRanges[0], RandomRanges[1]);
			}
			else 
			{
				timeleft = TIMETILLMOVE;
			}
		}
		else 
		{
			timeleft -= Time.deltaTime;
			
		}
	}
	

	//Checks if cpu, is player two. If so, it switches the values for myPlanet, and theirPlanet. 
	void CheckPlayerSpots() {
		if(Player_Spot == 2) 
		{
			string tmp = TYPE_myPlanet; 
			string tmp2 = TYPE_theirPlanet;
			
			TYPE_myPlanet = tmp2;
			TYPE_theirPlanet = tmp;
		}
	}
	
	
	
	//Seperates the objects with the tag planet into three catagories. 
	void organizeTeams() {
		
		GameObject[] planets = GameObject.FindGameObjectsWithTag("Planet");
		
		myPlanets.Clear();
		theirPlanets.Clear();//The opponents players.
		neutralPlanets.Clear();//The opponents players.
		AllOtherPlanets.Clear();



		foreach(GameObject planet in planets) 
		{
			string tmpObjOwner = planet.GetComponent<Planet_NPC>().type.ToLower();
			
			//If this planet is our planet. Add to list. 
			if(tmpObjOwner == TYPE_myPlanet.ToLower()) 
			{
				myPlanets.Add(planet);
			}
			else 
				if(tmpObjOwner == TYPE_neutralPlanet.ToLower())
			{
				neutralPlanets.Add(planet);
				AllOtherPlanets.Add(planet);
			}
			else 
				if(tmpObjOwner == TYPE_theirPlanet.ToLower())
			{
				theirPlanets.Add(planet);
				AllOtherPlanets.Add(planet);
			}
		}

	}
	
	
	void MakeMove() {

		//Organize teams into Ours, Theirs, and neithers. 
		organizeTeams();

		//Make Sure we have a planet before we try to make a move.
		if(myPlanets.Count > 0)
		{
			//Make Sure they have a planet, before we try to make a move.
			if(theirPlanets.Count > 0) 
			{ 


				//Try to find easy opponent, and attack it with our just barely stronger opponenet.
				//Else Attack the other player. 
				GameObject OtherPlanet = FindEasiestOpponent();
				OurPlanet = GetRandomPlanetHigherThan(OtherPlanet.GetComponent<Planet_NPC>().units);


				if(OurPlanet != null && OtherPlanet != null)
				{
					string ourPlanetType = OurPlanet.GetComponent<Planet_NPC>().type; //Set Type.
					LastAttackedPlanet = OtherPlanet;
					OurPlanet.GetComponent<SpawnShips>().CPUSpawnShip(ourPlanetType, OtherPlanet);
				}
				else
				{
					//We didn't have anyone strong enough. 
					OurPlanet = GetRandomPlanetHigherThan(0);
					string ourPlanetType = OurPlanet.GetComponent<Planet_NPC>().type; //Set Type.

					if(OtherPlanet != null) 
					{
						LastAttackedPlanet = OtherPlanet;
						OurPlanet.GetComponent<SpawnShips>().CPUSpawnShip(ourPlanetType, OtherPlanet);
					}
				}
				//Create a spot for our planet with largest amount of units.


				



			}
		}
	
	}
	
	
	
	//This will fetch either it's highest planet.
	public GameObject GetOurBestPlanet() { 
		GameObject tempObj;
		GameObject oldtempObj;
		int RandomNum = UnityEngine.Random.Range(1,100);


		if(myPlanets.Count == 1) 
		{
			return myPlanets[0];
		}
		else 
		if(myPlanets.Count != 0) 
		{
			tempObj = myPlanets[0];
			oldtempObj =  myPlanets[0];
			//Go through list of planets.
			for(int i = 1; i < myPlanets.Count; i++)
			{
				//Check if this 'theirplanets' has less units.
				if(myPlanets[i].GetComponent<Planet_NPC>().units > tempObj.GetComponent<Planet_NPC>().units)
				{
					oldtempObj = tempObj;
					tempObj = myPlanets[i];
				}
			}
			return tempObj;
		}
		else 
		{	return null; 
		}
	}

	public GameObject GetAPlanetHigherThan(int _input) { 

		GameObject sendBack = null; 
		List<GameObject> PassGameObjects = new List<GameObject>();

		if(myPlanets.Count == 1) 
		{
			return myPlanets[0];
		}
		else 
		if(myPlanets.Count != 0) 
		{

			//Check each planet if they are greater than our input value.
			foreach(GameObject planet in myPlanets) 
			{
				if(planet.GetComponent<Planet_NPC>().units > _input)
				{
					PassGameObjects.Add(planet);
				}
			}

			int LowestUnit = 0;

			//Check to see if there is any PassGameObjects.
			if(PassGameObjects.Count > 0) 
			{
				//Now take our list of planets that are higher than our input. 
				foreach(GameObject planet in PassGameObjects)
				{
					if(LowestUnit == 0)
					{
						LowestUnit = planet.GetComponent<Planet_NPC>().units;
						sendBack = planet;
					}
				}

				if(sendBack != null)
				{
					return sendBack;
				}
				else
				{
					return null;
				}
			}
			else 
			{
				return null;
			}


		}
		else 
		{	return null; 
		}
	}



	public GameObject GetRandomPlanetHigherThan(int _input) { 
		
		GameObject sendBack = null; 
		List<GameObject> PassGameObjects = new List<GameObject>();
		
		if(myPlanets.Count == 1) 
		{
			return myPlanets[0];
		}
		else 
			if(myPlanets.Count != 0) 
		{
			
			//Check each planet if they are greater than our input value.
			foreach(GameObject planet in myPlanets) 
			{
				if(planet.GetComponent<Planet_NPC>().units > _input)
				{
					PassGameObjects.Add(planet);
				}
			}
			
			int LowestUnit = 0;
			
			//Check to see if there is any PassGameObjects.
			if(PassGameObjects.Count > 0) 
			{
				sendBack = PassGameObjects[UnityEngine.Random.Range(0, PassGameObjects.Count)];
				
				if(sendBack != null)
				{
					return sendBack;
				}
				else
				{
					return null;
				}
			}
			else 
			{
				return null;
			}
			
			
		}
		else 
		{	return null; 
		}
	}
	
	
	GameObject FindMVP() { 

		if(myPlanets.Count > 0) 
		{ 
			GameObject tempTheirObj;
			tempTheirObj = getMVP(AllOtherPlanets);
			return tempTheirObj;
		} 
		else
		{
			return null;
		}
	}



	/* GetMVP will check all the objects given. Check to see which is the biggest. 
	 * Then it will find the distance and add that to it.
	 */
	GameObject getMVP(List<GameObject> _PlanetList) {


		//Holds the values that will determine which planet is selected.
		int[] PlanetValues = new int[_PlanetList.Count];
		float[] PlanetDistances = new float[_PlanetList.Count];
		int[] ValuesToUseForDistances = new int[] {9, 8, 7, 6, 5, 4, 3, 2, 1};

		int PlaceHolderForPlanetList = 0;
		float PlaceHolderForShortestDistance = 0f;

		int i = 0;
		//Cycle ValuesToUseForDistances 
		foreach(GameObject planet in _PlanetList)
		{

			PlanetDistances[i] = Vector3.Distance(OurPlanet.transform.position, planet.transform.position);
			i++;
		}
		//SetUp Arrar
		float[] PlanetDistancesORDERED = PlanetDistances;
		//Sort Array 
		Array.Sort(PlanetDistancesORDERED);

		int[] LowToHighElements = new int[_PlanetList.Count];
		i = 0;
		int h = 0;
		int p = 0;

		foreach(float value in PlanetDistancesORDERED) 
		{
			foreach(float matchValue in PlanetDistances)
			{
				if(value == matchValue && h == p)
				{
					LowToHighElements[h] = i;
					h++;
				}
				i++;
			}
			p++;
			i = 0;
		}

		i = 0; 

		foreach(int value in ValuesToUseForDistances)
		{
			if(i < PlanetValues.Length)
			{
			PlanetValues[LowToHighElements[i]] = value;
			i++;
			}
			else
			{
				break;
			}
		}


		i = 0;
		//Cycle ValuesToUseForDistances 
		foreach(GameObject planet in _PlanetList)
		{
			int val = planet.GetComponent<Planet_NPC>().planetSize;
			PlanetValues[i] += val * val;
			i++;
		}

		int TopVal = 0; 
		int TopEl = 0; 
		i = 0;
		foreach(int value in PlanetValues)
		{
			if(value > TopVal)
			{
				TopVal = value;
				TopEl  = i;
			}
			i++;
		}

		return _PlanetList[TopEl];
	}
	

	public GameObject FindClosestPlanet(List<GameObject> _planets) 
	{
		//Holds the values that will determine which planet is selected.
		int[] PlanetValues = new int[_planets.Count];
		float[] PlanetDistances = new float[_planets.Count];
		
		int PlaceHolderForPlanetList = 0;
		float PlaceHolderForShortestDistance = 0f;
		
		int i = 0;
		//Cycle ValuesToUseForDistances 
		foreach(GameObject planet in _planets)
		{
			if(OurPlanet == null)
			{
				if(myPlanets.Count == 0) 
				{ return null;}
				else
				{
					PlanetDistances[i] = Vector3.Distance(myPlanets[0].transform.position, planet.transform.position);
				}

			
			} 
			else
			{
			PlanetDistances[i] = Vector3.Distance(OurPlanet.transform.position, planet.transform.position);
			}
			i++;
		}
		
		float[] PlanetDistancesORDERED = PlanetDistances;
		Array.Sort(PlanetDistancesORDERED);
		
		int[] LowToHighElements = new int[_planets.Count];
		i = 0;
		int h = 0;
		int p = 0;
		
		foreach(float value in PlanetDistancesORDERED) 
		{
			foreach(float matchValue in PlanetDistances)
			{
				if(value == matchValue && h == p)
				{
					LowToHighElements[h] = i;
					h++;
				}
				i++;
			}
			p++;
			i = 0;
		}

		return _planets[LowToHighElements[0]];
				
	}



	GameObject FindEasiestOpponent() { 
		//Holds the lowest Unit Value.
		if(neutralPlanets.Count > 0)
		{
			
			Debug.Log("theirPlanets"+theirPlanets.Count);
			Debug.Log("neutralPlanets"+neutralPlanets.Count);
			Debug.Log("AllOtherPlanets"+AllOtherPlanets.Count);
			
			
			int LowestUnits = 0;
			string LowestUnitType  = "";
			//Go through list of planets and find what our lowest unit is. 
			foreach(GameObject planet in neutralPlanets)
			{
				if(planet.GetComponent<Planet_NPC>().units < LowestUnits || LowestUnits == 0)
				{
					LowestUnits = planet.GetComponent<Planet_NPC>().units;
				}
			}
			
			//Create a var to hold all the Planets that have the same 'LowestUnits'
			List<GameObject> LowestValueObjects = new List<GameObject>();
			//Using our LowestUnit Value, search through AllOtherPlanets for matches, then add them to their GameObject Array.
			foreach(GameObject planet in neutralPlanets)
			{
				if(planet.GetComponent<Planet_NPC>().units == LowestUnits)
				{
					LowestValueObjects.Add(planet);
				}
			}
			int  RandInt = UnityEngine.Random.Range(0, LowestValueObjects.Count);
			Debug.Log("Length"+LowestValueObjects.Count+"Value"+RandInt);
			GameObject ReturnObject = LowestValueObjects[RandInt];
			return ReturnObject;
		}

		if(AllOtherPlanets.Count > 0)
		{

			Debug.Log("theirPlanets"+theirPlanets.Count);
			Debug.Log("neutralPlanets"+neutralPlanets.Count);
			Debug.Log("AllOtherPlanets"+AllOtherPlanets.Count);


			int LowestUnits = 0;
			string LowestUnitType  = "";
			//Go through list of planets and find what our lowest unit is. 
			foreach(GameObject planet in AllOtherPlanets)
			{
				if(planet.GetComponent<Planet_NPC>().units < LowestUnits || LowestUnits == 0)
				{
					LowestUnits = planet.GetComponent<Planet_NPC>().units;
				}
			}

			//Create a var to hold all the Planets that have the same 'LowestUnits'
			List<GameObject> LowestValueObjects = new List<GameObject>();
			//Using our LowestUnit Value, search through AllOtherPlanets for matches, then add them to their GameObject Array.
			foreach(GameObject planet in AllOtherPlanets)
			{
				if(planet.GetComponent<Planet_NPC>().units == LowestUnits)
				{
					LowestValueObjects.Add(planet);
				}
			}
			int  RandInt = UnityEngine.Random.Range(0, LowestValueObjects.Count);
			Debug.Log("Length"+LowestValueObjects.Count+"Value"+RandInt);
			GameObject ReturnObject = LowestValueObjects[RandInt];
			return ReturnObject;
		}
		else
		{
			return null;
		}
	}



	GameObject FindPlanetLowestUnits() { 
		GameObject tempObj;
		tempObj = theirPlanets[0];
		//Go through list of planets.
		for(int i = 1; i < theirPlanets.Count; i++)
		{
			//Check if this 'theirplanets' has less units.
			if(theirPlanets[i].GetComponent<Planet_NPC>().units < tempObj.GetComponent<Planet_NPC>().units)
			{
				tempObj = theirPlanets[i];
			}
		}
		return tempObj;
	}


	GameObject FindPlanetHighestUnits() { 
		GameObject tempObj;
		tempObj = theirPlanets[0];
		//Go through list of planets.
		for(int i = 1; i < theirPlanets.Count; i++)
		{
			//Check if this 'theirplanets' has less units.
			if(theirPlanets[i].GetComponent<Planet_NPC>().units > tempObj.GetComponent<Planet_NPC>().units)
			{
				tempObj = theirPlanets[i];
			}
		}
		return tempObj;
	}
	
	
	
}
