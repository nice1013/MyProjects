using UnityEngine;
using System.Collections;

public class FlipTextForClient : MonoBehaviour {

	void Start() {
		if(Network.isClient)
		{
		RectTransform rectTransform = GetComponent<RectTransform>();
		rectTransform.Rotate( new Vector3( 0, 0, 180f ) );
		}
	}
}

