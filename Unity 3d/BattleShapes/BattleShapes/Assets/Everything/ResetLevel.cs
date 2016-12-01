using UnityEngine;
using System.Collections;

public class ResetLevel : MonoBehaviour {

	void Start() {
		//Application.LoadLevel(0);  
	}

	// Update is called once per frame
	void Update () {
	
		if(Input.GetKeyDown(KeyCode.W)) 
		{
			Application.LoadLevel (0);  
		}

	}


	public void HardReset() {
		Application.LoadLevel (0);  
	}
}
