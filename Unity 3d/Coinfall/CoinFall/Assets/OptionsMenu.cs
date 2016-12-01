using UnityEngine;
using System.Collections;

/*
Options Menu 
-------------------------------------

This will present options for users. 
Options include :

Gameplay Ads : Turn off with secret password. 
More Info    : This is the boring credits, give to the developer part. 


*/
using System.Linq;
using System;

public class OptionsMenu : MonoBehaviour {

	public string username = "";
	public string quote = "";
	public string address = "";

	public GUISkin toright;
	public GUISkin errorGuiSkin;
	public GUISkin optionsheaderskin;
	public GUISkin optionslabelskin;


	//Moving this to here. 
	//Error Message Variables. 
	float ErrorMessageTimer = 3; //The amount of time Message will show for. 
	
	//The amount of time the message will show for [AGAIN!]
	float EMTleft;//[This is our working vairable. It is set at STart(). and time is subtracted from it. 
	bool EMbool = false; //Bool says whether the message should be showing. 
	string EMessage = "";
	public Rect rectUserError;














	// Use this for initialization
	void Start () {
		rectUserError = new Rect(PercentWidth(10), PercentHeight(90), PercentWidth(80), PercentHeight(10));

		username = PlayerPrefs.GetString("username");
		quote = PlayerPrefs.GetString("quote");
		address = PlayerPrefs.GetString("address");
		
	}
	


	void OnGUI() {


		
		GUI.skin = optionsheaderskin;
		//The begining of the Doge signup form.
		//Top of Label 
		Rect square = new Rect(PercentWidth(50), PercentHeight(10), PercentWidth(45), PercentHeight(10));
		GUI.Label(square, "Fill Form to Board Rocket.");
		

		
		GUI.skin = optionslabelskin;


		//Username Label Box
		Rect square5 = new Rect(PercentWidth(50), PercentHeight(20), PercentWidth(45), PercentHeight(8));
		GUI.Label(square5, "Your Name");
		//Username Input Box
		Rect square2 = new Rect(PercentWidth(50), PercentHeight(28), PercentWidth(45), PercentHeight(7));
		username = GUI.TextField(square2, username, 25);



		//Quote Label Box
		Rect square6 = new Rect(PercentWidth(50), PercentHeight(36), PercentWidth(45), PercentHeight(8));
		GUI.Label(square6, "Quote");
		//Quote Input Box
		Rect square3 = new Rect(PercentWidth(50), PercentHeight(44), PercentWidth(45), PercentHeight(7));
		quote = GUI.TextField(square3, quote, 256);



		// Dogecoin Address Label box
		Rect square7 = new Rect(PercentWidth(50), PercentHeight(52), PercentWidth(45), PercentHeight(8));
		GUI.Label(square7, "Your Dogecoin Addresss");
		// Dogecoin Address input box
		Rect square4 = new Rect(PercentWidth(50), PercentHeight(60), PercentWidth(45), PercentHeight(7));
		address = GUI.TextField(square4, address, 34);
		
		GUI.skin = toright;
		
		//Labels
		
		

		//Ready Button
		Rect square8 = new Rect(PercentWidth (50), PercentHeight(80), PercentWidth(45), PercentHeight(10));
		if(GUI.Button(square8, "Ready!")) 
		{
			
			//Next we check the values entered and compare them to our standard values. If the are the same we remove. 
			Debug.Log("button was pressed");
			
			
			
			
			
			//CHheck to see if username has only letters and numbers. 
			//if false we will warn user to fix the problem. 
			//We will also check to see if user has not changed their name
			//If not, we will again warn user to fix the problem. 
			if (username.All(Char.IsLetterOrDigit) == false || address.All(Char.IsLetterOrDigit) == false)
			{
				toast("Remove Special Characters From UserName and Address");
				//Debug.Log("Special Characters are present");
				
				
			}
			else 
				//Next verification step 
				//Check to see if the user has entered default data
				if (address == "D7WqVWHpVwqPbPEdhfYMEHqWU7XiHeGdSP")
			{
				
				toast("Please enter in YOUR Dogecoin Address");
				
			}
			else
				//Next Verification step
				//Check to see if the address is 34 digits. 
				if (address.Length != 34)
			{
				toast("Please enter in a Valid Dogecoin address");
				
			}
			else 
				//if It made it to this step, we can create a save pref with the users data. 
			{
				PlayerPrefs.SetString("username", username);
				PlayerPrefs.SetString("address", address);
				PlayerPrefs.SetString("quote", quote);
				
				
				toast("Your Info has beeen updated!");
				
				Application.LoadLevel(1);
			}
			
			
			
			
		}
		
		GUI.skin = null;
	

		//Checking to see if we should be showing an Error message. 
		if(EMbool) {
			GUI.skin = errorGuiSkin;
			//If here we need to show the error message.
			GUI.Label(rectUserError, EMessage);
			
			//If there is no time left. (Set EMbool to false.) So message will not show no more. and Default EMTLEFT.
			//Otherwise, We need to take away time that has passed.
			if(EMTleft <= 0)
			{
				EMbool = false; 
				EMTleft = ErrorMessageTimer;
			}
			else 
			{ EMTleft -= Time.deltaTime; 
			}
			
			GUI.skin = null;
			
		}

	}
























	public void toast(string message) {
		
		EMessage = message;
		EMbool = true;
		EMTleft = ErrorMessageTimer;
		
		
	}
	
	




	float PercentHeight(int percentage)
	{
		
		//get amount of pixals in height.
		int Heightofscreen = Screen.height;
		//get amount of pixals for out percentage. 
		float pixels = (float)(Heightofscreen * percentage * .01f);
		
		return pixels;
		
	}
	
	float PercentWidth(int percentage)
	{
		
		//get amount of pixals in height.
		int Widthofscreen = Screen.width;
		//	Debug.Log("Screen Width1 "+ Widthofscreen);
		//get amount of pixals for out percentage. 
		float pixels = (float)( Widthofscreen * percentage * .01f);
		//	Debug.Log("Screen Width "+pixels);
		
		return pixels;
		
	}
	
	Color HexToColor(string hex)
	{
		byte r = byte.Parse(hex.Substring(0,2), System.Globalization.NumberStyles.HexNumber);
		byte g = byte.Parse(hex.Substring(2,2), System.Globalization.NumberStyles.HexNumber);
		byte b = byte.Parse(hex.Substring(4,2), System.Globalization.NumberStyles.HexNumber);
		return new Color32(r,g,b, 255);
	}





}
