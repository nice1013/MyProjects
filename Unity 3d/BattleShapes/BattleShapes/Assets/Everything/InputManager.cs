using UnityEngine;
using System.Collections;

public class InputManager : MonoBehaviour {

	public bool wasSelected = false;
	public string team = "";
	public string lastSelectedName = "";

	public bool ControlBothTeams = false;
	public GameObject AIobject;
	public string ourTeam = "";
	public string TeamOwnerName = "player1";
	public bool StartedGame = false;

	public float MouseSelectionArea = 3f;

	// Use this for initialization
	void Start () {
		//ourTeam = AIobject.GetComponent<AI_PlanetControl>().TYPE_theirPlanet;
		ourTeam = TeamOwnerName;
	}
	
	// Update is called once per frame
	void Update () {





		//Mouse Clicked
		if (Input.GetMouseButtonDown (0)) {

			Vector3 mousePos = Camera.main.ScreenToWorldPoint (Input.mousePosition);
			//Debug.Log("Mouse Position: " + mousePos);
			mousePos.y = 0;
				
			Collider[] hits = Physics.OverlapSphere(mousePos, MouseSelectionArea);



			//Check to see if we hit anything. If not clear everything.
			if(hits.Length > 0) {

				//else more code
				//Did mouse click hit a planet
				if(hits[0].gameObject.transform.tag.ToString() == "Planet")
				{
					//Was there something already selected.
					if(wasSelected)
					{


						if(lastSelectedName == hits[0].gameObject.name)
						{
							//This is the same object.
							GameObject lastObject = GameObject.Find(lastSelectedName).gameObject;
							//SpawnShips 
							//Clear Everything 
							//Cancle old selected
							lastObject.GetComponent<Planet_NPC>().isSelected = false;
							//Clear Everything.
							resetScript();
						}
						else 
						{
							//Check to see if StartedGame == true
							if(StartedGame)
							{
								//This is a different object. Please send troops.
								GameObject lastObject = GameObject.Find(lastSelectedName).gameObject;
								//SpawnShips 
								lastObject.GetComponent<SpawnShips>().SpawnShip(team, hits[0].gameObject);
								//Clear Everything 
								//Cancle old selected
								lastObject.GetComponent<Planet_NPC>().isSelected = false;
								//Clear Everything.
								resetScript();
							}
						}

					}
					else 
					{

						string hitTeam = hits[0].gameObject.GetComponent<Planet_NPC>().type;
						
						//If its our team. It will ring false and go through. 
						//If its their team and its false. We can't control the other team, so do nothing. 
						//If its their team and its true. We can control both team, so it rings false and we head to selection.
						if(hitTeam.ToLower() != ourTeam.ToLower()   && ControlBothTeams == false)
						{//Do nothing
						}
						else 
						{
						//Nothing has been selected. We can simply select this item.
						wasSelected = true; //This is the first item we selected.
						team  = hits[0].gameObject.GetComponent<Planet_NPC>().type; //Store the team
						lastSelectedName = hits[0].name; //Store the planet name
						hits[0].gameObject.GetComponent<Planet_NPC>().isSelected = true;
						}
					}
				}
				else 
				{
					//If there was something selected.
					if(wasSelected) 
					{
						//Mouse didn't hit anything. Clear Everything.
						//Cancle old selected
						GameObject.Find(lastSelectedName).gameObject.GetComponent<Planet_NPC>().isSelected = false;
						//Clear Everything.
						resetScript();
					}
					

				}
				
			}
			else
			{
				//If there was something selected.
				if(wasSelected) 
				{
					//Nothing was hit.
					//Mouse didn't hit anything. Clear Everything.
					//Cancle old selected
					GameObject.Find(lastSelectedName).gameObject.GetComponent<Planet_NPC>().isSelected = false;
					//Clear Everything.
					resetScript();
				}

				
			}
		}
		
	}



	public void resetScript() { 

		wasSelected = false;
		team = "";
		lastSelectedName = "";

	}

}
