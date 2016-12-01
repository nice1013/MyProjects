using UnityEngine;
using System.Collections;

public class OnlineSpawnShips : MonoBehaviour {

	public GameObject Player1ShipObj;
	public GameObject Player2ShipObj; 
	
	public GameObject ShipExplosion; 
	
	int DeployPlayer1Ships = 0;
	int DeployPlayer2Ships = 0;
	
	public float percentage = 1f;
	
	float TimeBetweenSpawns = .25f; 
	float TimeLeftBetweenSpawns = 0;
	
	public GameObject target;
	
	public string owner = "";
	
	float distanceFromSpawn = 4.5f;
	
	public int planetSize = 1;
	int ShipPositionRotation = 1;
	
	void Start() {
		Player1ShipObj = GameObject.Find("LevelManager").GetComponent<OnlineLevelManager>().player1;
		Player2ShipObj = GameObject.Find("LevelManager").GetComponent<OnlineLevelManager>().player2;
		planetSize = GetComponent<OnlinePlanet_NPC>().planetSize;
		
		ShipExplosion = Resources.Load("Prefabs/Explosion") as GameObject;
	}
	
	
	private void Update() { 
		//If there is ships to deploy and there is an object that exist.
		if ((DeployPlayer2Ships > 0 || DeployPlayer1Ships > 0) && target != null) { 
			//If it is time for another spawn. 
			if(TimeLeftBetweenSpawns <= 0) 
			{
				TimeLeftBetweenSpawns = TimeBetweenSpawns / planetSize; //Resetting the clock. 
				//Create the spawn location for this.
				//Create Var to hold the spawn position. 				
				//Instatiating ships if needed.
				if(DeployPlayer1Ships > 0) {
					SpawnAShip(Player1ShipObj, 1);
					
					GetComponent<OnlinePlanet_NPC>().RemoveAndcheckIfLostPlanet();
					DeployPlayer1Ships -= 1;
					GetComponent<OnlinePlanet_NPC>().updateUnitDistplay();
				} else
				if (DeployPlayer2Ships > 0) { 
					SpawnAShip(Player2ShipObj, 2);

					GetComponent<OnlinePlanet_NPC>().RemoveAndcheckIfLostPlanet();
					DeployPlayer2Ships -= 1;
					GetComponent<OnlinePlanet_NPC>().updateUnitDistplay();
				}
			}
			else 
			{
				//Remove Time from TimeLeftBetweenSpawns 
				TimeLeftBetweenSpawns -= Time.deltaTime;
			}
		}
	}

	public void SpawnAShip(GameObject PlayerObject, int player) {

		Vector3 startPos;
		startPos = Vector3.MoveTowards(transform.position, target.transform.position, distanceFromSpawn);

		GameObject prefab = Network.Instantiate (PlayerObject, startPos, Quaternion.identity, 0) as GameObject;

		if(player == 1) 
		{
		prefab.tag = "Player1Ship";
		} 
		else 
		{
		prefab.tag = "Player2Ship";
		}

		/* First check to see what the planet size
	 * If one: Do what we been doing
	 * If two: Check what shipPositionRotation we are at. If one. Do a half Distance from spawn to left. If two: Do the same to right. 
	 * if Three: Check ShipPositionRotation. If one: do what we have been doing. If two: do full to left. if three: do full to right. 
	 */
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

		string pathName = "From"+transform.name+"PS"+planetSize+"SPR"+ShipPositionRotation+"To"+target.name;
		
		prefab.GetComponent<NetworkView>().RPC ("setupThisShip", RPCMode.All, new object[] {owner, target.name});
		prefab.GetComponent<NetworkView>().RPC ("setupUnitAttachedToThis", RPCMode.All, new object[] {transform.name, target.name, pathName});

		 
	}

	public void setDeployPlayer1Ships(int _units){
		DeployPlayer1Ships = _units;
	}

	public void setDeployPlayer2Ships(int _units){
		DeployPlayer2Ships = _units;
	}

}
