using UnityEngine;
using System.Collections;



/* SpawnGrow will upon start(). Make the object grow into a size*/
public class SpawnGrow : MonoBehaviour {

	//Size Object will start, and end at. 
	float startSize = .01f;  			
	public float endSize = 1f; 

	//Speed 	- The rate the object will grow each update(). 
	public float growSpeed = 1f;

	public float AngleItsAt = 15f;

	// Use this for initialization
	void Start () {
	

		transform.localScale = new Vector3(startSize, startSize, startSize);

	}
	
	// Update is called once per frame
	void Update () {



		startSize += growSpeed * Time.deltaTime;

		if(startSize > endSize) 
		{

			transform.localScale = new Vector3(endSize, endSize, endSize);
			Destroy(this);
		
		}
		else
		{
		transform.localScale = new Vector3(startSize, startSize, startSize);
		}
	}
}
