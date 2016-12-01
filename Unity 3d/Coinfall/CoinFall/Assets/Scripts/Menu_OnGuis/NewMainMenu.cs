using UnityEngine;
using System.Collections;
using GooglePlayGames;
using UnityEngine.SocialPlatforms;
using System;
using System.Reflection;
using System.Security.Cryptography;
using System.IO;
using System.Text;
using System.Linq;
using SimpleJSON;


public class NewMainMenu : MonoBehaviour {


	//Images
	public Texture TitleImage; //LoGO
	public Texture CopyDogecoin; //Dogecoin Copy Adddress Image. 
	public Texture CopyBitcoin; //Bitcoin Copy Address Image.


	//GuiSkins
	public GUISkin FrontMenuSkin; //For general Use.
	public GUISkin NotSignedInSkin;
	public GUISkin SignedInSkin;
	public GUISkin FactSkin; //Fact Skin, controls only the Fact Box on the game over screen
	public GUISkin errorGuiSkin;
	public GUISkin DogeSignIn; //The Sign in form for Coinfall Giveaway.
	public GUISkin toright; //for telling labels to fall to right
	public GUISkin ChampDisplay;
	public GUISkin ChampDisplay2;


	//Boxes used in UI
	private Rect FrontLogoBox; 			//Rect that Holds Logo
	private Rect boxTimeRun;			//Rect that Holds TimeRun Button
	private Rect boxOptions;		//Rect that Holds Catch Them All Button
	private Rect boxMoreInfo;			//Rect that Holds More Info Button
	public Rect boxSpew;				//Rect that Holds 'FUND ME' Label
	public Rect boxDogeAddress;			//Rect that Holds Dogecoin Copy Address Button.
	public Rect boxBitAddress;			//Rect that Holds Bitcoin Copy Address Button. 
	public Rect boxSignIn;				//Rect that Holds Sign In Button
	public Rect rectUserError;			//Rect that Holds Toast Error Messages. 
	public Rect boxLeaderBoards;		//Rect that Holds LeaderBoards Button
	public Rect FactBox;				//Rect that Holds Fact or Quote about Bitcoin. 

	public string TimeRunAddress = "CgkIpNP00scDEAIQCQ"; //Address used to post score to Google Game Services.
	


	//Error Message Variables. 
	float ErrorMessageTimer = 3; //The amount of time Message will show for. 
	
	//The amount of time the message will show for [AGAIN!]
	float EMTleft;//[This is our working vairable. It is set at STart(). and time is subtracted from it. 
	bool EMbool = false; //Bool says whether the message should be showing. 
	string EMessage = "";
	
	public GameObject AdMobPlugin;
		
	public bool wasntwarned = true; //says wether or not player was warned. If true, the player has not been warned.
	public bool hasinfo = false;	//hasinfo -- Bool deteremines whether or not the player has filled out their  info.
	public string username = "4moves";  //Player's Username 
	public string quote = "Reddit.com/r/dogecoin"; //Player's Quote
	public string address = "D7WqVWHpVwqPbPEdhfYMEHqWU7XiHeGdSP";

	public string stats = "";


	//get Current Top Score and Data 
	public string champusername = "";
	public string champquote = ""; 
	public string champaddress = "";
	public string champscore = "";



	public WWW www = null;

























	void Start() {


		if (Application.platform == RuntimePlatform.Android){
		//Start the ads
			AdMobPlugin.GetComponent<AdMobPlugin>().Show();
		}

		AdMobPlugin.GetComponent<AdMobPlugin>().Show();
		//Messaging the user.
		EMTleft = ErrorMessageTimer;// 
		

		// recommended for debugging:
		//PlayGamesPlatform.DebugLogEnabled = true;
		
		// Activate the Google Play Games platform
		PlayGamesPlatform.Activate();


		
	
		//TOP
		//generate the box for front logo. Find where used by looking for --Box001.
		FrontLogoBox = new Rect(PercentWidth(5), PercentHeight(5), PercentWidth(40), PercentHeight(35));


		
		

		
		rectUserError = new Rect(PercentWidth(10), PercentHeight(90), PercentWidth(80), PercentHeight(10));


		
		
		//RIGHT SIDE
		//TIME RUN
		//generate the box for Time . Find where used by looking for --Box002.
		boxTimeRun = new Rect(PercentWidth(55), PercentHeight(10), PercentWidth(40), PercentHeight(15));
		//Catch Them All
		//generate the box for Catch Them All. Find where used by looking for --Box003.
		boxOptions = new Rect(PercentWidth(55), PercentHeight(30), PercentWidth(40), PercentHeight(15));



		//BOTTOM
		//Labels ERROr / Status messages.
		
		FactBox = new Rect(PercentWidth(7), PercentHeight(70), PercentWidth(86),  PercentHeight(20));
		






		//--------------CHECK PLAYER PREFS FOR INFO--------------------------------------
		//Prelimary check to see if person has all info needed to proceed.
		bool prefusername = PlayerPrefs.HasKey("username"); //check for username in save pref.
		bool prefquote = PlayerPrefs.HasKey("quote"); //check for username in save pref.
		bool prefaddress = PlayerPrefs.HasKey("address"); //check for username in save pref.


		//Check for username, quote, and dogecoin address. 
		//If any are false -- then set hasinfo to false
		if(prefusername == false || prefquote == false || prefaddress == false)
		{
			
			hasinfo = false;

		}
		else 
		{	hasinfo = true;			}



		//Check again if we need to set usernamer, quote, and dogeaddress
		if(prefusername)
		{
		username = PlayerPrefs.GetString("username");
		
		}
		if(prefquote)
		{
			quote = PlayerPrefs.GetString("quote");
			
		}
		if(prefaddress)
		{
			address = PlayerPrefs.GetString("address");
			
		}



		//-------------PULL DATA FROM SERVER-------------------------------
		string url = "http://coinfall.pw/pull/stats.php";
		www = new WWW(url);
		StartCoroutine(WaitForRequest(www));
		

		
		



		
	}


	void OnGUI() {

		//Recheck to see if Champ variables are empty. If they are, try to fill them.
		if(champaddress == "" || champquote == "" || champusername == "" || champscore == "")
		{

			
			//Debug.Log ("Stats : " + stats);
			//Parse string returned from our webpage

			if(www.error == null)
			{
			var N = JSON.Parse(stats);
			champusername = N["NAME"].Value;        // versionString will be a string containing "1.0"
			champquote = N["QUOTE"].Value;        // versionString will be a string containing "1.0"
			champaddress = N["ADDRESS"].Value;        // versionString will be a string containing "1.0"
			champscore = N["SCORE"].Value;        // versionString will be a string containing "1.0"
			//Debug.Log ("Website Data, nameis : " + champusername);

			
			
	
			}
			else 
			{
				champusername = "No Connection";
				champquote = "No Connection";

			}
			





		}




			
			
			





		//Debug.Log ("HasInfo: " + hasinfo);

		//check to see if the user has all their info by looking the hasinfo. If it doesn't present form 
		//for them to fill out.
		if (!hasinfo)
		{
			
			GUI.skin = DogeSignIn;

			//The begining of the Doge signup form.
			//Top of Label 
			Rect backgroundRect = new Rect(PercentWidth(5), PercentHeight(5), PercentWidth(90), PercentHeight(90));
			GUI.Box(backgroundRect, "");

			Rect square = new Rect(PercentWidth(10), PercentHeight(10), PercentWidth(80), PercentHeight(10));
			GUI.Label(square, "Fill Form to Board Rocket.");

			//Input Text Boxes
			//Username Input Box
			Rect square2 = new Rect(PercentWidth(40), PercentHeight(25), PercentWidth(50), PercentHeight(7));
			username = GUI.TextField(square2, username, 25);
			//Quote Input Box
			Rect square3 = new Rect(PercentWidth(40), PercentHeight(35), PercentWidth(50), PercentHeight(7));
			quote = GUI.TextField(square3, quote, 256);
			// Dogecoin Address input box
			Rect square4 = new Rect(PercentWidth(40), PercentHeight(45), PercentWidth(50), PercentHeight(7));
			address = GUI.TextField(square4, address, 34);

			GUI.skin = toright;

			//Labels
			//Username Input Box
			Rect square5 = new Rect(PercentWidth(5), PercentHeight(25), PercentWidth(35), PercentHeight(8));
			GUI.Label(square5, "Your Name");
			//Quote Input Box
			Rect square6 = new Rect(PercentWidth(5), PercentHeight(35), PercentWidth(35), PercentHeight(8));
			GUI.Label(square6, "Quote");
			// Dogecoin Address input box
			Rect square7 = new Rect(PercentWidth(5), PercentHeight(45), PercentWidth(35), PercentHeight(8));
			GUI.Label(square7, "Your Dogecoin Addresss");


			//Ready Button
			Rect square8 = new Rect(PercentWidth (30), PercentHeight(60), PercentWidth(40), PercentHeight(10));
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
				if (address == "D7WqVWHpVwqPbPEdhfYMEHqWU7XiHeGdSP" && wasntwarned)
				{
				
				toast("Please enter in YOUR Dogecoin Address");
				wasntwarned = false;

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
				hasinfo = true;


				}


			

			}

			GUI.skin = null;


			
		}
		else 
		{
		

		
	
			//ON GUI is broken up like start. The Main Focus is TOPside. RIGHT SIDE. LEFT SIDE.
			GUI.skin = FrontMenuSkin;
			//TOP SIDE
	
		
	
			GUI.skin = FrontMenuSkin;
			//Generating box with image. --Box002.
			if(GUI.Button( boxTimeRun, "Play For Doge"))
			{
				Application.LoadLevel(2);
			}
			
			
			//Generating box with image. --Box002.
			if(GUI.Button( boxOptions, "Options"))
			{
					Application.LoadLevel(5); //loading options menu
	
			}
	
	
			
			//Bottom
			GUI.skin = null;
	
	
	
			//Display the current champion's info
			GUI.skin = ChampDisplay;
			//The box
			Rect cbox4 = new Rect(PercentWidth(55), PercentHeight(45), PercentWidth(40), PercentHeight(40));
			GUI.Box(cbox4, "");
			
			GUI.skin = ChampDisplay2;
			//if here, we have the champion info from the webpage
			//Top Champ's user name
			Rect cbox1 = new Rect(PercentWidth(55), PercentHeight(50), PercentWidth(40), PercentHeight(8));
			GUI.Label(cbox1, "Champion :  " +champusername);
			Rect cbox6 = new Rect(PercentWidth(55), PercentHeight(58), PercentWidth(40), PercentHeight(8));
			GUI.Label(cbox6, "Top Score :  " +champscore);
			
			
			
			GUI.skin = ChampDisplay;
			//Top champ's Dogecoin address
			Rect cbox3 = new Rect(PercentWidth(55), PercentHeight(66), PercentWidth(40), PercentHeight(8));
			GUI.TextField(cbox3, champaddress);
			//Top champ's quote
			Rect cbox2 = new Rect(PercentWidth(55), PercentHeight(75), PercentWidth(40), PercentHeight(16));
			GUI.Label(cbox2, "Quote :  "+champquote);
	
	
	



		//Draw MockUp ad
		//GameObject.Find("AdMobPlugin").GetComponent<AdMobPluginMockup>().DrawAd();
//		GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().Load();
		}// end ELSE 




		


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


	

	IEnumerator WaitForRequest(WWW www)
	{
		yield return www;
		
		// check for errors
		if (www.error == null)
		{
			Debug.Log("WWW Ok!: " + www.data);
			stats = www.text; //setting data when available. 
		} else {
			Debug.Log("WWW Error: "+ www.error);
		}
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
