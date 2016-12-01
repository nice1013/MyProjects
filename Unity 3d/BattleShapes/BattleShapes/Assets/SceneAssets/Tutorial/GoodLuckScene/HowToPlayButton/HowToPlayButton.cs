using UnityEngine;
using System.Collections;

public class HowToPlayButton : MonoBehaviour {

	public GameObject[] StartObject;
	public GameObject[] StopObject;


	public void StartHowToPlay() {

		foreach(GameObject obj in StartObject) 
		{
			obj.SetActive(true);
		}

		foreach(GameObject obj in StopObject) 
		{
			obj.SetActive(false);
		}


		Destroy(this.gameObject);

	}

}
