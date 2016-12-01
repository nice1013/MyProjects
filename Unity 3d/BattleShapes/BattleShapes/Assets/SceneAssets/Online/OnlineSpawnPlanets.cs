using UnityEngine;
using System.Collections;
public class OnlineSpawnPlanets : MonoBehaviour {

	GameObject PlanetPrefab;

	[RPC]
	public void SpawnPlanet() {
		if(Network.isServer) 
		{
			PlanetPrefab = GameObject.Find("LevelManager").GetComponent<OnlineLevelManager>().PlanetNPCAfterEverything as GameObject;
			GameObject newPP = Network.Instantiate(PlanetPrefab, new Vector3(0, 0, 0), Quaternion.identity, 0) as GameObject;
		}
	}



}
