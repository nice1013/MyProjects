﻿using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class DieBoundary : MonoBehaviour {

	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
		
        if(gameObject.transform.position.y < -5) {
            gameObject.transform.position = new Vector3(0, 1, 0);
        }

	}
}
