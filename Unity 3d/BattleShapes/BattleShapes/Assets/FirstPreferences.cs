using UnityEngine;
using System.Collections;

public class FirstPreferences : MonoBehaviour {

	// Use this for initialization
	void Start () {



		//Check for level progression. 
		int[] levelprogress = PlayerPrefsX.GetIntArray("LevelProgress");
		if(levelprogress.Length == 0)
		{
			int[] dummyArray = new int[] {1,1,1,  0,0,0,  0,0,0,  0,0,0,  0,0,0,  0,0,0,  0,0,0,  0,0,0,  0,0,0,  0,0,0};
			PlayerPrefsX.SetIntArray("LevelProgress", dummyArray);
		}

		string color = PlayerPrefs.GetString("My_Color");
		string shape = PlayerPrefs.GetString("My_Shape");
		
		if(shape == "") 
		{
			PlayerPrefs.SetString("My_Shape", "Cube");
		}
		
		if(color == "") 
		{
			PlayerPrefs.SetString("My_Color", "#0000ff");
		}


	
	}
}
