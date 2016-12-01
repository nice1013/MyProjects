using UnityEngine;
using System.Collections;

public class StartChildrenOnAwake : MonoBehaviour {

	// Use this for initialization
	void Start () {
	
		int AmountOfchildren = transform.childCount;

		for(int i = 0; i < AmountOfchildren; i++) 
		{ 
			transform.GetChild(i).gameObject.SetActive(true);
		} 

	}

}
