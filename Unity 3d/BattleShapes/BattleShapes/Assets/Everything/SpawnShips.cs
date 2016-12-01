using UnityEngine;
using System.Collections;

public class SpawnShips : MonoBehaviour {

	public GameObject Player1ShipObj;
	public GameObject Player2ShipObj; 

	public GameObject ShipExplosion;

	int DelpoyPlayer1Ships = 0;
	int DelpoyPlayer2Ships = 0;
	
	public float percentage = 1f;

	float TimeBetweenSpawns = .25f; 
	float TimeLeftBetweenSpawns = 0;

	public GameObject target;

	public string owner = "";

	float distanceFromSpawn = 4.5f;

	public int planetSize = 1;
	int ShipPositionRotation = 1;

	void Start() {
		if(GameObject.Find("LevelManager") != null)
		{
			Player1ShipObj = GameObject.Find("LevelManager").GetComponent<LevelManager>().player1;
			Player2ShipObj = GameObject.Find("LevelManager").GetComponent<LevelManager>().player2;
		}
		else
		if(GameObject.Find("LevelManagerForLevelTesting") != null)
		{
			Player1ShipObj = GameObject.Find("LevelManagerForLevelTesting").GetComponent<LevelManagerForLevelTesting>().player1;
			Player2ShipObj = GameObject.Find("LevelManagerForLevelTesting").GetComponent<LevelManagerForLevelTesting>().player2;
		}


		planetSize = GetComponent<Planet_NPC>().planetSize;

		ShipExplosion = Resources.Load("Prefabs/Explosion") as GameObject;
	}


	private void Update() { 



			//If there is ships to deploy and there is an object that exist.
			if ((DelpoyPlayer2Ships > 0 || DelpoyPlayer1Ships > 0) && target != null) { 

				//If it is time for another spawn. 
				if(TimeLeftBetweenSpawns <= 0) 
				{

				TimeLeftBetweenSpawns = TimeBetweenSpawns / planetSize; //Resetting the clock. 

				//Create the spawn location for this.
				//Create Var to hold the spawn position. 

				/* First check to see what the planet size
				 * If one: Do what we been doing
				 * If two: Check what shipPositionRotation we are at. If one. Do a half Distance from spawn to left. If two: Do the same to right. 
				 * if Three: Check ShipPositionRotation. If one: do what we have been doing. If two: do full to left. if three: do full to right. 
				 */

				Vector3 startPos;
				startPos = Vector3.MoveTowards(transform.position, target.transform.position, distanceFromSpawn);
				//startPos = startPos + new Vector3(2f, 0f, 0f);



					//Instatiating ships if needed.
					if(DelpoyPlayer1Ships > 0) {


						GameObject prefab = Instantiate (Player1ShipObj, startPos, Quaternion.identity) as GameObject;
						prefab.GetComponent<Renderer>().material.color = transform.FindChild("Player1").GetComponent<Renderer>().material.color;
						prefab.tag = "Player1Ship";
						prefab.transform.localScale = new Vector3(.66f, .66f, .66f);
						prefab.transform.LookAt(target.transform);

						//Correct Rotation for Ships.. If needed -- Verified by looking at game live.
						if(prefab.name == "Cross(Clone)" || prefab.name == "Star(Clone)" || prefab.name == "Heart(Clone)")
						{
						prefab.transform.localEulerAngles = new Vector3(90, 0 , 0 );
						}

						//Correct Size for ships. 
						if(prefab.name == "Diamond(Clone)" || prefab.name == "Star(Clone)" )
						{
						prefab.transform.localScale = new Vector3(1.25f, 1.25f, 1.25f);
						}	
					

						//Calculate  the position of ships being spawned.
						if(planetSize == 2)
						{
							if(ShipPositionRotation == 1) 
							{
								prefab.transform.localPosition += prefab.transform.right * (distanceFromSpawn / 4) ;
								ShipPositionRotation = 2; 
							} 
							else 
							{ 
								prefab.transform.localPosition -= prefab.transform.right * (distanceFromSpawn / 4) ;
								ShipPositionRotation = 1;
							}
						}
						else
						if(planetSize == 3)
						{
							if(ShipPositionRotation == 1)
						   	{ 
							ShipPositionRotation = 2; 
							}
							else
							if(ShipPositionRotation == 2) 
							{
								prefab.transform.localPosition += prefab.transform.right * (distanceFromSpawn / 2) ;
								ShipPositionRotation = 3; 
							} 
							else 
							{ 
								prefab.transform.localPosition -= prefab.transform.right * (distanceFromSpawn / 2) ;
								ShipPositionRotation = 1;
							}
						}


						
						prefab.AddComponent<Unit>();
						prefab.AddComponent<Ship_NPC>();
						prefab.AddComponent<SphereCollider>();
						prefab.layer = 8;
						prefab.AddComponent<Rigidbody>();
						prefab.GetComponent<Rigidbody>().useGravity = false;
						prefab.AddComponent<Pathfinding>(); 
						prefab.AddComponent<PathRequestManager>();
						prefab.GetComponent<Unit> ().setUnit(this.transform, target.transform);
						prefab.GetComponent<Ship_NPC> ().destination =  target;
						prefab.GetComponent<Ship_NPC> ().owner = owner;
						prefab.GetComponent<Unit>().pathName = "From"+transform.name+"PS"+planetSize+"SPR"+ShipPositionRotation+"To"+target.name;
						//Remove 1 from Unit Count
						GetComponent<Planet_NPC>().RemoveAndcheckIfLostPlanet();
						DelpoyPlayer1Ships -= 1;


						//Add Explosion under prefab. 
						GameObject explos = Instantiate(ShipExplosion, prefab.transform.position, Quaternion.identity) as GameObject;
						explos.transform.parent = prefab.transform;
						explos.transform.localPosition = new Vector3(0, 0, 0);
						
						GetComponent<Planet_NPC>().updateUnitDistplay();
						
					} else
					if (DelpoyPlayer2Ships > 0) { 
						
						

						
						GameObject prefab = Instantiate (Player2ShipObj, startPos, Quaternion.identity) as GameObject;
						prefab.GetComponent<Renderer>().material.color = transform.FindChild("Player2").GetComponent<Renderer>().material.color;
						prefab.tag = "Player2Ship";
						prefab.transform.localScale = new Vector3(.66f, .66f, .66f);
						prefab.transform.LookAt(target.transform);
						if(prefab.name == "Cross(Clone)"  || prefab.name == "Star(Clone)" || prefab.name == "Heart(Clone)")
						{
							prefab.transform.localEulerAngles = new Vector3(90, 0 , 0 );
						}

						
						if(prefab.name == "Diamond(Clone)"  || prefab.name == "Star(Clone)")
						{
						prefab.transform.localScale = new Vector3(1.25f, 1.25f, 1.25f);
						}	
					
					
						if(planetSize == 2)
						{
							if(ShipPositionRotation == 1) 
							{
								prefab.transform.localPosition += prefab.transform.right * (distanceFromSpawn / 4) ;
								ShipPositionRotation = 2; 
							} 
							else 
							{ 
								prefab.transform.localPosition -= prefab.transform.right * (distanceFromSpawn / 4) ;
								ShipPositionRotation = 1;
							}
						}
						else
							if(planetSize == 3)
						{
							if(ShipPositionRotation == 1)
							{ 
								ShipPositionRotation = 2; 
							}
							else
								if(ShipPositionRotation == 2) 
							{
								prefab.transform.localPosition += prefab.transform.right * (distanceFromSpawn / 2) ;
								ShipPositionRotation = 3; 
							} 
							else 
							{ 
								prefab.transform.localPosition -= prefab.transform.right * (distanceFromSpawn / 2) ;
								ShipPositionRotation = 1;
							}
						}


						Unit prefabUnit = prefab.AddComponent<Unit>();
						Ship_NPC prefabShipNPC = prefab.AddComponent<Ship_NPC>();
						prefab.AddComponent<SphereCollider>();
						prefab.layer = 8;
						prefab.AddComponent<Rigidbody>();
						prefab.GetComponent<Rigidbody>().useGravity = false;
						prefab.AddComponent<Pathfinding>(); 
						prefab.AddComponent<PathRequestManager>();
						prefabUnit.setUnit(this.transform, target.transform);
						prefabShipNPC.destination =  target;
						prefabShipNPC.owner = owner;
						prefabUnit.pathName = "From"+transform.name+"PS"+planetSize+"SPR"+ShipPositionRotation+"To"+target.name;

					

						//Remove 1 from Unit Count
						GetComponent<Planet_NPC>().RemoveAndcheckIfLostPlanet();
						DelpoyPlayer2Ships -= 1;

						//Add Explosion under prefab. 
						GameObject explos = Instantiate(ShipExplosion, prefab.transform.position, Quaternion.identity) as GameObject;
						explos.transform.parent = prefab.transform;
						explos.transform.localPosition = new Vector3(0, 0, 0);

						
					}










				}
				else 
				{
				//Remove Time from TimeLeftBetweenSpawns 
				TimeLeftBetweenSpawns -= Time.deltaTime;
				}

				

			}


	}





	[RPC] 
	public void SpawnShip(string type, GameObject targetPlanet){

			target = targetPlanet; //Setting the targert planet
			

			//Get Current Units. Find out what percentage will be sent away. 
			//Update the curUnit value 
			//Then instatiate the
			int curUnits = GetComponent<Planet_NPC> ().units;

			curUnits = (int) (curUnits * GameObject.Find("UnitHandler").GetComponent<UnitPercentageHandler>().P1percentage);

			//Telling script that there is units to deploy.
			if (type.ToLower () == "player1") {
			DelpoyPlayer1Ships = curUnits;
			} else
			if (type.ToLower () == "player2") {
			DelpoyPlayer2Ships = curUnits;
			}


			

	}


	[RPC] 
	public void CPUSpawnShip(string type, GameObject targetPlanet){
		
		target = targetPlanet; //Setting the targert planet
		
		
		//Get Current Units. Find out what percentage will be sent away. 
		//Update the curUnit value 
		//Then instatiate the
		int curUnits = GetComponent<Planet_NPC> ().units;

		//Add Code to change percentage for cpu.
		 curUnits = (int) (curUnits * 1); 

		
		//Telling script that there is units to deploy.
		if (type.ToLower () == "player1") {
			DelpoyPlayer1Ships = curUnits;
		} else
		if (type.ToLower () == "player2") {
			DelpoyPlayer2Ships = curUnits;
		}
		
		
		
		
	}

}
