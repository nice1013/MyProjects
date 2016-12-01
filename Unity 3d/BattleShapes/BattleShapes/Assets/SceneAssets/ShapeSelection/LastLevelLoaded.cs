using UnityEngine;
using System.Collections;

public class LastLevelLoaded : MonoBehaviour {

	// Use this for initialization
	void Awake () {
		Debug.Log(Application.loadedLevelName);
		PlayerPrefs.SetString("LastLevel", PlayerPrefs.GetString("ThisLevel"));
		PlayerPrefs.SetString("ThisLevel", Application.loadedLevelName);
	}
	
	// Update is called once per frame
	void Update () {
	
	}
}
