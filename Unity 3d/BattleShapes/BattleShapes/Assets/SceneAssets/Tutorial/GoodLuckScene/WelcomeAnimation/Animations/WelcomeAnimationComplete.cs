using UnityEngine;
using System.Collections;

public class WelcomeAnimationComplete : MonoBehaviour {

	public bool Complete = false;


	public GameObject[] ObjectsToTurnOn;


	// Use this for initialization
	void Start () {
	
	}
	
	// Update is called once per frame
	void Update () {


		if(Complete) 
		{

			foreach(GameObject obj in ObjectsToTurnOn)
			{
				obj.SetActive(true);
			}

			Destroy(this);
		}
	
	}
}
