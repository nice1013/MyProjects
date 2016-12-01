using UnityEngine;
using System.Collections;

public class OneVectorAnimationHelper : MonoBehaviour {

	public float Z = 0f;
	public float X = 0f;
	public float Y = 0f;

	//Values from Previous update.
	float PZ = 0f;
	float PX = 0f;
	float PY = 0f;


	// Use this for initialization
	void Start () {
	


	}
	
	// Update is called once per frame
	void LateUpdate () {

		transform.position = new Vector3(transform.position.x + X  - PX , transform.position.y + Y - PY, transform.position.z + Z - PZ);


		PZ = Z;
		PX = X;
		PY = Y;
	
	}
}
