using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class OnExitScript : MonoBehaviour {

	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
		
	}

    void OnCollisionExit(Collision collision)
    {

        Debug.Log("Hello ");
        if (collision.gameObject.tag == "Respawn")
        {
           Destroy(gameObject);
        }
    }
}
