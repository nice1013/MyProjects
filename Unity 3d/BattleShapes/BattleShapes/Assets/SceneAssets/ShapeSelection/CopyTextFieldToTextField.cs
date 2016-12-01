using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class CopyTextFieldToTextField : MonoBehaviour {

	public Text TextToCopyFrom;


	// Use this for initialization
	void Start () {
		GetComponent<Text>().text = TextToCopyFrom.text;
	}

}
