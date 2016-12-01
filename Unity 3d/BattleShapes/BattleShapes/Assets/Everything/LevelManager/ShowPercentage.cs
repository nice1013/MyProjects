using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class ShowPercentage : MonoBehaviour {


	
	// Update is called once per frame
	void Update () {
		GetComponent<Text>().text = (GameObject.Find("UnitHandler").GetComponent<UnitPercentageHandler>().P1percentage * 100) + "%";
	}
}
