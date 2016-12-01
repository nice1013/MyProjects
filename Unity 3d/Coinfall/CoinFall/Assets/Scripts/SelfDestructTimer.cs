using UnityEngine;
using System.Collections;

public class SelfDestructTimer : MonoBehaviour {

	public float timer = 1;
	public float timeleft;

	// Use this for initialization
	void Start () {
	
		timeleft = timer;

	}
	
	// Update is called once per frame
	void Update () {

		timeleft -= Time.deltaTime;
	
		if(timeleft <= 0)
		{

		Destroy(gameObject);

		}


	
	}
}
