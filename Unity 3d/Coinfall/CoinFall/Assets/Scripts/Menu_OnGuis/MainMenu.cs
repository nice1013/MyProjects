using UnityEngine;
using System.Collections;
using GooglePlayGames;
using UnityEngine.SocialPlatforms;
using System;
using System.Reflection;


public class MainMenu : MonoBehaviour {


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


	//Boxes used in UI
	private Rect FrontLogoBox; 			//Rect that Holds Logo
	private Rect boxTimeRun;			//Rect that Holds TimeRun Button
	private Rect boxCatchThemAll;		//Rect that Holds Catch Them All Button
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
		

	public bool hasinfo = false;	//hasinfo -- Bool deteremines whether or not the player has filled out their  info.



































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


		
		

		
		//LEFT
		//3 boxes.
		//Generate a box for Sign in
		boxSignIn = new Rect(PercentWidth(5), PercentHeight(40), PercentWidth(40), PercentHeight(10));
		//Donation Addresses.
		boxSpew = new Rect(PercentWidth(5) , PercentHeight(50), PercentWidth(40), PercentHeight(6));
		boxDogeAddress = new Rect(PercentWidth(6) , PercentHeight(56), PercentWidth(18), PercentHeight(10));
		boxBitAddress = new Rect(PercentWidth(26) , PercentHeight(56), PercentWidth(18), PercentHeight(10));
		rectUserError = new Rect(PercentWidth(5), PercentHeight(66), PercentWidth(40), PercentHeight(10));


		
		
		//RIGHT SIDE
		//TIME RUN
		//generate the box for Time . Find where used by looking for --Box002.
		boxTimeRun = new Rect(PercentWidth(55), PercentHeight(10), PercentWidth(40), PercentHeight(30));
		//Catch Them All
		//generate the box for Catch Them All. Find where used by looking for --Box003.
		//boxCatchThemAll = new Rect(PercentWidth(55), PercentHeight(25), PercentWidth(40), PercentHeight(15));
		//LEADERBOARDS
		//Generate the box for leaderboards.
		boxLeaderBoards = new Rect(PercentWidth(55), PercentHeight(40), PercentWidth(40), PercentHeight(15));
		//MORE INFO
		//generate the box for More Info. Find where used by looking for --Box004.
		boxMoreInfo = new Rect(PercentWidth(55), PercentHeight(55), PercentWidth(40), PercentHeight(15));



		//BOTTOM
		//Labels ERROr / Status messages.
		
		FactBox = new Rect(PercentWidth(7), PercentHeight(70), PercentWidth(86),  PercentHeight(20));
		
		
	}


	void OnGUI() {

		

		if (hasinfo == false)
		{
			string place = "hello";
			bool check = PlayerPrefs.HasKey(place);

			if(!check)
			{
			GUI.skin = DogeSignIn;

			Rect square = new Rect(PercentWidth(10), PercentHeight(10), PercentWidth(80), PercentHeight(80));
			GUI.Label(square, "Fill Form to Board Rocket.");
			
			


			GUI.skin = null;
			}






			
		}
		else 
		{
		

		//WE still need to draw add bottom. 


		//ON GUI is broken up like start. The Main Focus is TOPside. RIGHT SIDE. LEFT SIDE.
		GUI.skin = FrontMenuSkin;
		//TOP SIDE
		//Generating box with image. --Box001.
		GUI.Box( FrontLogoBox , TitleImage);








		//LEFT SIdE
		//We are instantiating Sign in button. 
		//First we find out if the user is signed in. 
		if ( Social.localUser.authenticated == false ) {

			//If here the user has 'NOT' signed in. 
			//Use SignInSkin2
			GUI.skin = NotSignedInSkin;
			GUI.contentColor = HexToColor("BA9F32"); //Change Color to the Same as Dogecoin

			if (GUI.Button( boxSignIn, "Login (Offline)"))
			{
				Social.localUser.Authenticate((bool success) => {
					// handle success or failure
					if (success)
					{
						Debug.Log("We authenticated Us.");
						//Social.localUser.ToString
						
						
					}else 
					{
						Debug.Log ("We didn't get athenticated");
					}
					
					
					
				});
			}
			GUI.contentColor = HexToColor("FFFFFF"); 
			GUI.skin = null;

		}
		else 
		{
			//If here the user has signed in. 
			GUI.skin = SignedInSkin;
			GUI.contentColor = HexToColor("F7931A");  //Change Text to the same Color as Bitcoins
			if (GUI.Button( boxSignIn, "Logged In"))
			{

			EMessage = "You are Already Signed In";
			EMbool = true;


			}
			GUI.contentColor = HexToColor("FFFFFF"); 
			GUI.skin = null;


		}

		

	

		GUI.skin = FrontMenuSkin;
		//Generating box with image. --Box002.
		if(GUI.Button( boxTimeRun, "Arcade"))
		{

			Application.LoadLevel(2);

		}
		


		/*
		//Generating box for Catch Them All. --Box003.
		if(GUI.Button( boxCatchThemAll, "Catch Them All"))
		{
			Debug.Log("Catch Them All, Has Been Pressed");
			Application.LoadLevel(3);
			
		}

		*/









		//RIGHT SIDE
		//button for leaderboards.
		if (GUI.Button( boxLeaderBoards, "Leaderboards"))
		{
			Social.ShowLeaderboardUI();
		}
		
		//Generating box for more info. --Box004.
		if(GUI.Button( boxMoreInfo, "More Info"))
		{
			
			Application.LoadLevel(4);
			
		}

		
		GUI.Label (boxSpew, "Help fund Me!");
		
		//GUI.contentColor = HexToColor("BA9F32"); //Color of a Dogecoin.
		//GUI.Label (boxDogeAddress, "Dogecoin : 1DsWtLUDhPdC6kVVrBPWDAA5Cd8nkFVoNf");
		
		
		
		//GUI.contentColor = HexToColor("F7931A"); //Color of a bitcoin
		//GUI.Label (boxBitAddress, "Bitcoin : DQeNLk464g6szk3zpjDjFpwR2wHxtFsJsr");
		#if UNITY_ANDROID



				//Here we create our Copy address to Clipboard. for Dogecoin and Bitcoin. 
				if(GUI.Button(boxDogeAddress, CopyDogecoin))
				{
					ClipBoard.ExportString("1DsWtLUDhPdC6kVVrBPWDAA5Cd8nkFVoNf");		
					
		
					EMessage = "Copied Dogecoin Address";
					EMbool = true;
					EMTleft = ErrorMessageTimer;
		
				}

				//Here we create our Copy address to Clipboard. for Dogecoin and Bitcoin. 
				if(GUI.Button(boxBitAddress, CopyBitcoin))
				{
					ClipBoard.ExportString("DQeNLk464g6szk3zpjDjFpwR2wHxtFsJsr");
					
					EMessage = "Copied Bitcoin Address";
					EMbool = true;
					EMTleft = ErrorMessageTimer;
					
				}




		#endif

		




		//Bottom
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
		
		
		

		GUI.skin = null;

		//setting the gui skin for the label; BITCOIN FACTS
		GUI.skin = FactSkin; 
		
		//get the btc quote we will show to the user.
		string quote = GameObject.Find("Scripts").GetComponent<BitcoinAdvantages>().BTCfact;
		
		
		//generate the new label. with points 
		GUI.Label(FactBox, "Did You Know? "+quote);
		
		GUI.skin = null;


		//Draw MockUp ad
		//GameObject.Find("AdMobPlugin").GetComponent<AdMobPluginMockup>().DrawAd();
//		GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().Load();
		}// end ELSE 

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
			Debug.Log("Screen Width1 "+ Widthofscreen);
			//get amount of pixals for out percentage. 
			float pixels = (float)( Widthofscreen * percentage * .01f);
			Debug.Log("Screen Width "+pixels);
			
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
