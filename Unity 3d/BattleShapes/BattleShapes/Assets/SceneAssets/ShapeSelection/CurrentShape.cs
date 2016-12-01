using UnityEngine;
using System.Collections;

public class CurrentShape : MonoBehaviour {

	OnlineCSManager CSM;

	void Start() {
		CSM = GameObject.Find ("ShapeManager").GetComponent<OnlineCSManager>();
	}

	// Use this for initialization
	void Update() {
		CSM.SimpleMPMM(this.gameObject);
	}

}
