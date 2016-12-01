using UnityEngine;
using System.Collections;

public class ResetToNormal : MonoBehaviour {


	public float timetillreset = .3f;
	public float TTRworkingVar;
	public bool isActive = false;


	//sreset to normal is
	// Use this for initialization
	void Start () {
	
	TTRworkingVar = timetillreset;
	transform.GetComponent<Renderer>().enabled = false;
	


	}
	
	// Update is called once per frame
	void Update () {
	
			if (isActive != false)
			{
				TTRworkingVar -= Time.deltaTime;
				
				if (TTRworkingVar <= 0)
				{

				transform.GetComponent<Renderer>().enabled =false;
				transform.parent.transform.position = new Vector3(0f, 17f, 0f);
				transform.parent.GetChild(0).GetComponent<Renderer>().enabled = true;
				transform.parent.GetChild(0).GetComponent<Collider>().enabled = true;

				//if scam coin we needd to turn on the particle emitter for the halo effect
				if (transform.parent.tag == "Scamcoin") 
				{

				transform.parent.GetComponent<ParticleSystem>().GetComponent<Renderer>().enabled = true;

				}

		
				TTRworkingVar = timetillreset;
				isActive = false;
	
				}

			}
	}
}
