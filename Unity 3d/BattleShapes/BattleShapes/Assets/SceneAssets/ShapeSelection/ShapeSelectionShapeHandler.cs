using UnityEngine;
using System.Collections;

public class ShapeSelectionShapeHandler : MonoBehaviour {

	OnlineCSManager CSM;

	// Use this for initialization
	void Start() {
		CSM = GameObject.Find ("ShapeManager").GetComponent<OnlineCSManager>();
		CSM.SimpleMPMM(this.gameObject);
	}
	
	// Update is called once per frame
	void Update () {
	
	}
}
