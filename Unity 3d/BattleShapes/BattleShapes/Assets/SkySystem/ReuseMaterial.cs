using UnityEngine;
using System.Collections;

public class ReuseMaterial : MonoBehaviour {

	public Material MaterialToReUse;
	public Color colorToUse;

	// Use this for initialization
	void Start () {
		Material mat = new Material(MaterialToReUse);
		mat.color = colorToUse;
		GetComponent<ParticleSystemRenderer>().material = mat;

	}
	
	// Update is called once per frame
	void Update () {
	
	}
}
