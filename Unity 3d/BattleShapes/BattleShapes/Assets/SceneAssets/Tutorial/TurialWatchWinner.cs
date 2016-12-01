using UnityEngine;
using System.Collections;

public class TurialWatchWinner : MonoBehaviour {

	public int player1Amount = 0; 
	public int player2Amount = 0; 
	public int player1Ships = 0;
	public int player2Ships = 0;
	
	
	public GameObject[] StopObjects; 
	public GameObject[] StartObjects;
	
	
	// Use this for initialization
	void Start () {
		InvokeRepeating("checkforwinner", 0, 1.0f);
	}
	
	// Update is called once per frame
	void Update () {
		
	}
	
	
	
	public void checkforwinner() { 
		
		GameObject[] planets = GameObject.FindGameObjectsWithTag ("Planet");
		
		int player1bases = 0;
		int player2bases = 0;
		
		
		GameObject[] ships = GameObject.FindGameObjectsWithTag ("Player1Ship");
		player1Ships = ships.Length;
		
		GameObject[] ships2 = GameObject.FindGameObjectsWithTag ("Player2Ship");
		
		player2Ships = ships2.Length;
		
		//Look through every planet, and count each planet for each team.
		for (int i = 0; i < planets.Length; i++) {
			
			if(planets[i].GetComponent<Planet_NPC>().type.ToLower() == "player1")
			{
				player1bases++;
			}
			else 
				if(planets[i].GetComponent<Planet_NPC>().type.ToLower() == "player2")
			{
				player2bases++;
			}
			
			
		}
		
		//If a team has less than 0.
		if (player1bases == 0 || player2bases == 0) {
			
			if(player1bases == 0 && player1Ships == 0)
			{ 	Debug.Log("Cpu Wins!");
				
			}
			
			if(player2bases == 0 && player2Ships == 0)
			{ 	Debug.Log("Player1 Wins!!");

				foreach(GameObject obj in StopObjects)
				{
					obj.SetActive(false);
				}
				
				
				foreach(GameObject obj in StartObjects)
				{
					obj.SetActive(true);
				}



			}
			
			
		}
		
		
		
		player1Amount = player1bases; 
		player2Amount = player2bases; 
		
	}
}
