using UnityEngine;
using System.Collections;


/* LevelManager stores the current Custom Prefabs for the level. 
 * It stores the player1 prefab and player2 prefab. 
 */
public class LevelManager : MonoBehaviour {

	//The planet NPC that will be used in the level. 
	public GameObject PlanetNPC; 
	//Their shape and color
	public GameObject player1; 
	public GameObject player2; //Player two must be entered on the fly. 

	public string Player2Object = "";



	Color_Shape_Manager CSM = new Color_Shape_Manager();
	CPU_Shape_Color CSC = new CPU_Shape_Color();

	public void Awake() {
		DontDestroyOnLoad(transform.gameObject);
	}



	public void setCPUplayer2(string _shape) {
		player2 = CSC.getCPUObject(_shape);

	}


	public void GenerateShapes(string _shape, GameObject PlanetNPC) {
		
		player1 = CSM.getPlayerShape();
		GameObject temp1 = Instantiate(player1, PlanetNPC.transform.position, Quaternion.identity) as GameObject;
		temp1.transform.name = "Player1";
		temp1.AddComponent<RandomRotate>();
		temp1.GetComponent<RandomRotate>().UseX = true;
		temp1.transform.parent = PlanetNPC.transform; 

		player2 = CSC.getCpuAsShape(_shape);
		GameObject temp2 = Instantiate(player2, PlanetNPC.transform.position, Quaternion.identity) as GameObject;
		temp2.transform.name = "Player2";
		temp2.AddComponent<RandomRotate>();
		temp2.GetComponent<RandomRotate>().UseX = true;
		temp2.transform.parent = PlanetNPC.transform; 


		
		
	}


	public void GenerateShapesForLevel(GameObject PlanetNPC) {

		GameObject Player1Obj = PlanetNPC.transform.FindChild("Player1").gameObject;
		GameObject Player2Obj = PlanetNPC.transform.FindChild("Player2").gameObject;

		CSM.SimpleMPMM(Player1Obj);
		CSC.SimpleMPMM(Player2Obj, Player2Object);		
	}

	public void createPlanetNPCPrefab() {
		//Blank plantet object
		GameObject basicPlanetPrefab = Resources.Load("Prefabs/PlanetPrefab") as GameObject;

		player1 = CSM.getPlayerShape();
		player1.transform.parent = basicPlanetPrefab.transform; 
		player2.transform.parent = basicPlanetPrefab.transform; 


		PlanetNPC = basicPlanetPrefab;


	}




}
