using UnityEngine;
using System.Collections;

public class ColorPickingShape : MonoBehaviour {

	public GameObject picker;
	public Color currentColor;

	OnlineCSManager CSM;
	
	void Start() {
		CSM = GameObject.Find ("ShapeManager").GetComponent<OnlineCSManager>();
		CSM.SimpleMPMM(this.gameObject);
	}

	// Use this for initialization
	public void Update() {
		GetComponent<MeshRenderer>().materials[0].color = picker.GetComponent<HSVPicker>().currentColor;
		currentColor = GetComponent<MeshRenderer>().materials[0].color;
	}

}
