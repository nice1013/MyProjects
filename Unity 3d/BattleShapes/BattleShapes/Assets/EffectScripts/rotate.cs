using UnityEngine;
using System.Collections;

public class rotate : MonoBehaviour {

	public float rotateSpeed = 0.1f;   //Rotation speed.
	public bool UseRandomRotationSpeed = true; //boolean that says whether or not to use the random values. 
	public float RandomMinSpeed = -1f; 	//The Minimum Random Rotation Speed. 
	public float RandomMaxSpeed =  1f;  //The Maximum Random Rotation Speed. 
	private float randomval = 0f;

	public float Cooldown = 5f;
	private float cdLEFT;

	public bool up;
	public bool down;
	public bool left;
	public bool right;
	public bool forward;
	public bool back;

	private Vector3 direction;

	// Use this for initialization
	void Start () {
	
		randomval = Random.Range(RandomMinSpeed, RandomMaxSpeed); //generating the random value no matter what. 
		//Debug.Log("Rotate Speed: "+randomval);

		
		
	
		cdLEFT = Cooldown;
	
	}





	void rotateThis(float randomval) {
		
		//Do Up or Down

		if (up)
		{		transform.Rotate(Vector3.up * randomval);		}
		else if (down)
		{		transform.Rotate(Vector3.down * randomval);		}



		if (left)
		{		transform.Rotate(Vector3.left * randomval);		}
		else if (right)
		{		transform.Rotate(Vector3.right * randomval)	;	}


		if (forward)
		{		transform.Rotate(Vector3.forward * randomval);	}
		else if (back)
		{		transform.Rotate(Vector3.back * randomval);		}


	}

	
	// Update is called once per frame
	void Update () {
	
		
		if (cdLEFT <= 0) 
		{


			if (UseRandomRotationSpeed)
			{
				//if here, we are selecting random value from our ration min and max. 
				//now we set to the transform rotate command. 
				rotateThis(randomval);
	
			}
			else 
			{
				//if here we are using rotate set value. 
				rotateThis(rotateSpeed);;
	
			}

			cdLEFT = Cooldown;
		}

		cdLEFT -=Time.deltaTime;

	}
}
