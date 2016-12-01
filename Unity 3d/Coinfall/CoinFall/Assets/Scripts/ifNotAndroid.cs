using UnityEngine;
using System.Collections;

public class ifNotAndroid : MonoBehaviour {

	// Use this for initialization
	void Start () {

		
	if (Application.platform != RuntimePlatform.Android)
	{
		//this.active = false;

	}

	}
	
	// Update is called once per frame
	void Update () {
	
	}
}
