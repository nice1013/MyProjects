using UnityEngine;
using System.Collections;

public class OnlineSelector : MonoBehaviour {

	public bool isSelected = false;
	public GameObject psobject;
	
	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
		
		//Check whether the planet is selected. Turn on/off the particle system.
		if (isSelected) {
			if(psobject.GetComponent<ParticleSystem>().isPlaying == false)
			{
				
				psobject.GetComponent<ParticleSystem>().Clear();
				psobject.GetComponent<ParticleSystem>().Play ();
			}
			
		} else {
			psobject.GetComponent<ParticleSystem>().Stop ();
		}
		
	}

	public bool getIsSelected() {
		return isSelected;
	}
	public void setIsSelected(bool _input) {
		isSelected = _input;
	}
}
