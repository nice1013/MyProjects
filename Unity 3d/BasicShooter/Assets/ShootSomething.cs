using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class ShootSomething : MonoBehaviour {
    public GameObject bullet;
    

	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
		
        if(Input.GetKeyDown(KeyCode.Q))
        {
            GameObject TempBullet = Instantiate(bullet, transform.position+(transform.forward*2)+new Vector3(0,1,0), Quaternion.identity);
            Rigidbody RigBody = TempBullet.GetComponent<Rigidbody>();
            RigBody.AddForce(transform.forward * 1000);
        }

	}
}
