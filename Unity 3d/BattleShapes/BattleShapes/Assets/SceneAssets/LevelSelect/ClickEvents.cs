using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class ClickEvents : MonoBehaviour {

	public float MouseSelectionArea = 3f;

	Vector3 worldPos = Vector3.zero;


	float ClickTimer = .2f; //How fast a person mush press and then lift their finger. 
	float CTLeft = 0;

	// Use this for initialization
	void Start () {
		CTLeft = ClickTimer;
	}
	
	// Update is called once per frame
	void Update () {


		if(Input.GetButtonDown("Fire1"))
		{


			//We did click. Reset the click timer. 
			CTLeft  = ClickTimer;

		}


		if(Input.GetButtonUp("Fire1"))
		{
			//Checks to see if person let go withit the CTLEft (.1seconds).
			if(CTLeft > 0)
			{

				Vector3 mousePos = Input.mousePosition;
				mousePos.z = 20;
				worldPos = Camera.main.ScreenToWorldPoint (mousePos);
				//Debug.Log("Mouse Position: " + mousePos);
				
				
				Debug.Log("Mouse Click Poss: "+worldPos);
				
				Collider[] hits = Physics.OverlapSphere(worldPos, MouseSelectionArea);
				
				Debug.Log("Hit Amount: "+hits.Length);
				
				if(hits.Length > 0) 
				{
					//Get object name we hit.
					string[] namethenlevel = hits[0].gameObject.transform.name.Split('.');
					Debug.Log("0: " + namethenlevel[0] + " 1: " + namethenlevel[1]);
					string levelToLoad = namethenlevel[1].ToString();
					//Set level manager player2 object name to the object name.
					GameObject.Find("LevelManager").GetComponent<LevelManager>().Player2Object = namethenlevel[0].ToString();

					//LoadLevel.
					Application.LoadLevel(levelToLoad);
					
				}
			}
			
		}

		if(CTLeft > 0) 
		{
			CTLeft -= Time.deltaTime;
		}

	
	}


	void OnDrawGizmos() {

		Gizmos.DrawSphere(worldPos, MouseSelectionArea);

	}
}
