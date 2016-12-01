using UnityEngine;
using System.Collections;

public class ResetLight : MonoBehaviour {

	public float Intensity = .5f; 
	public float Decrement = .1f;
	public Light directionalLight;

	// Use this for initialization
	void Start () {
	
	}
	
	// Update is called once per frame
	void Update () {
	
		if(directionalLight.intensity > Intensity)
		{
			if(directionalLight.intensity - Decrement < Intensity)
			{
				directionalLight.intensity = Intensity;
			}
			else
			{
			directionalLight.intensity -= Decrement; 
			}
		}

	}
}
