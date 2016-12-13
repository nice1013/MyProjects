using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BulletScript : MonoBehaviour {
    private float TotalAliveTime = 0;


	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
        TotalAliveTime += Time.deltaTime;

        if(TotalAliveTime > 2)
        {
            Destroy(gameObject);
        }
	}
}
