using UnityEngine;
using System.Collections;

public class StoredPrefrences : MonoBehaviour {

	/* Remember to use PlayerPrefsX
	 * 
	 * Stored Prefrences 
	 * 

	-Name : "LevelProgress"
	-Info : Array of play progress through the levels. 
			0 = Hidden, 1 = CanPlay, 2 = Bronze Win, 3 = Silver Win, 4 = Gold Win. 
	int[] dummyArray = new int[] {1,1,1, 0,0,0,  0,0,0, 0,0,0, 0,0,0, 0,0,0,0,0, 0,0,0,0,0, 0,0,0,0,0};
	PlayerPrefsX.SetIntArray("LevelProgress", dummyArray);

	-Name : "My_Color" 
	-Info : Player choosen Color 
	string color = PlayerPrefs.GetString("My_Color");
	PlayerPrefs.SetString("My_Color", "#0000ff");


	-Name : "My_Shape"
	-Info : Player choosen Shape 
	string shape = PlayerPrefs.GetString("My_Shape");
	PlayerPrefs.SetString("My_Shape", "Cube");


	if(shape == "") 
	{
		PlayerPrefs.SetString("My_Shape", "Cube");
	}
	
	if(color == "") 
	{
		PlayerPrefs.SetString("My_Color", "#0000ff");
	}










	--Future Ones 
	--Username 
	--Password


	 */
}
