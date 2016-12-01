using UnityEngine;
using System.Collections;

public class KeepChildOrientation : MonoBehaviour {

	Quaternion myRotation;

	// Update is called once per frame
	void Update () {
		//myRotation = transform.parent.rotation;
		transform.LookAt(2 * transform.position - Camera.main.transform.position);
	}


	void LateUpdate()  {
		//transform.LookAt(Camera.main.transform);
	}

}
