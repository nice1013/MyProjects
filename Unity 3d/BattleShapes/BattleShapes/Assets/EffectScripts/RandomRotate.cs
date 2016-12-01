using UnityEngine;
using System.Collections;

public class RandomRotate : MonoBehaviour {

	public float RandomMinSpeed = 25f; 	//The Minimum Random Rotation Speed. 
	public float RandomMaxSpeed = 50f;  //The Maximum Random Rotation Speed. 
	public float randomval = 0f;

	public bool UseY = false;
	public bool UseX = false;
	public bool UseZ = false;

	// Use this for initialization
	void Start () {
	


		randomval = Random.Range(RandomMinSpeed, RandomMaxSpeed); //generating the random value no matter what. 

		if(randomBoolean()) 
		{
			randomval = randomval * -1;
		}

	}
	
	// Update is called once per frame
	void Update () {

		if(UseX)
		{
		transform.Rotate(new Vector3(Time.deltaTime * randomval, 0, 0));
		}

     	if(UseY)
     	{
		transform.Rotate(new Vector3(0, Time.deltaTime * randomval, 0));
        }

		if(UseZ)
		{
		transform.Rotate(new Vector3(0, 0, Time.deltaTime * randomval));
		}

		
	}



	public bool randomBoolean ()
	{
		if (Random.value >= 0.5)
		{
			return true;
		}
		return false;
	}

}
