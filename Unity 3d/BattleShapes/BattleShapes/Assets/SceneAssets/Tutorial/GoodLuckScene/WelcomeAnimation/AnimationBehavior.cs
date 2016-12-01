using UnityEngine;
using System.Collections;

public class AnimationBehavior : MonoBehaviour {

	public bool turnOff = false;

	// Use this for initialization
	void Start () {


	}
	
	// Update is called once per frame
	void Update () {
	
		if(turnOff)
		{GetComponent<Animator>().enabled = false;
		}
		
	}
}
