using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class TeleAtANumber : MonoBehaviour {
    int currentCoinCount = 0;
    int teleNumber = 3;


	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
		
	}


    //Check to see if cap was collided with. 
    //Move the level if we have collected more than 3 caps.
    void OnCollisionEnter(Collision collision)
    {
        if (collision.gameObject.tag == "Cap")
        {
            Destroy(collision.gameObject);
            currentCoinCount += 1;

            if (currentCoinCount >= teleNumber)
            {
                int currentLevel = SceneManager.GetActiveScene().buildIndex;

                if(currentLevel == 0)
                {
                    Application.LoadLevel(1);
                }
                else
                {
                    Application.LoadLevel(0);
                }
            }

        }
    }

}
