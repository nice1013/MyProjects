using UnityEngine;
using System.Collections;
using GooglePlayGames;
using UnityEngine.SocialPlatforms;

//SignInScreen Simply ask the user whether or not he will sign in. If he doesn't His score will not be tracked. 
public class SignInScreen : MonoBehaviour {


	//Declare Three RECTS. BACKGROUND, SIGN IN, PWHS (Play without High Score). [Assigned Values in Start()]
	Rect rectBackground, rectSignIn, rectPWHS, rectUserError, rectadvice;
	







	//Error Message Variables. 
	float ErrorMessageTimer = 3; //The amount of time Message will show for. 

	//The amount of time the message will show for [AGAIN!]
	float EMTleft;//[This is our working vairable. It is set at STart(). and time is subtracted from it. 
	bool EMbool = false; //Bool says whether the message should be showing. 

	string EMessage = "Login Failed";
	//ENding ERROR meesge Variables. 





	//Gui Skin for this SignInScreen. 
	public GUISkin SignInScreenGuiSkin;

	public Texture TitleImage;//CoinFall Logo










	//In Start, We activate the playgamePlatform. Generate the RECTS for the SIGN IN Screen. 
	// Use this for initialization
	void Start () {




		if (Application.platform == RuntimePlatform.Android){
		//Start the ads. 
		//GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().Show();
		}

		

		

		EMTleft = ErrorMessageTimer;// 

		// Activate the Google Play Games platform
		PlayGamesPlatform.Activate();

		


		//We will need three rects. --These will be instantiated in the ONGUI function. 
		//ONE: BACKGROUND. 100 percent width and Height. 
		rectBackground = new Rect(PercentWidth(10), PercentHeight(5), PercentWidth(80), PercentHeight(40));

		//Buttons
		//TWO: SIGN IN. 50percent width, and 25-40 percent height. 
		rectSignIn = new Rect(PercentWidth(30), PercentHeight(45), PercentWidth(40), PercentHeight(15));
		//Three: SIGN IN. 50percent width, and 60-75 percent height.
		rectPWHS = new Rect(PercentWidth(30), PercentHeight(60), PercentWidth(40), PercentHeight(15));	



		//Labels
		rectUserError = new Rect(PercentWidth(30), PercentHeight(55), PercentWidth(40), PercentHeight(10));
		rectadvice = new Rect(PercentWidth(30), PercentHeight(65), PercentWidth(40), PercentHeight(10));

		//Check to see if user is already logged in. 
		//If he is, Send him to the next page. 
		if (Social.localUser.authenticated)
		{

			Application.LoadLevel(1); //zero is main menu

		}



	}



	void OnGUI() {


			
		










		
			//Draw Ad
			//Generate an Ad.
			//GameObject.Find("AdMobPlugin").GetComponent<AdMobPluginMockup>().DrawAd();
			//GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().Load();
			//GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().Show();
			//OnGUI is ordered like so:
			//Background, Sign In, Play Without High Scores, Error Message.
			
		
			//Change the Skin for this GUI.
			GUI.skin = SignInScreenGuiSkin;

			//Instantiating the Background. 
			GUI.Box(rectBackground, TitleImage);

			//bool online  =	GameObject.Find("AdvertisementManager").GetComponent<AdController>().AdBool;

			//Instantiating Sign In Button
		if(GUI.Button(rectSignIn, "Play For Doge")){
			
				//show loading screen.
				GameObject.Find("LoadingPlugin").GetComponent<LoadingPlugin>().showloading = true;	
				
				
				//if we are on an android phone, load in social network. if not, just load in. 
				if (Application.platform == RuntimePlatform.Android){
					//Is attempting to Sign in. 
					Social.localUser.Authenticate((bool success) => {
						// handle success or failure
						if (success)
						{
							//If here, The user signed in Successfully. We need to take him to the the front screen.
							Application.LoadLevel(1);
							
							
						}else 
						{
							//If here, we failed to sign in. 
							//Set EMbool to true, so Error Message appears. And Default the EMTleft.
							EMbool = true;
							
						}
						//turn off loading screen
						GameObject.Find("LoadingPlugin").GetComponent<LoadingPlugin>().showloading = true;
	
					});
				}//end of checking for android 
				else 
				{
					//We need to take him to the the front screen.
					Application.LoadLevel(1);


				}

			}


			GUI.Label(rectadvice, "Please have your Dogecoin address copied, and ready to paste. ");





		/*
			//Instantiate the [Play without HighScore Button].
			if(GUI.Button(rectPWHS, "Practice"))
			{
			
			Application.LoadLevel(1);
	
			}

		*/















			//Checking to see if we should be showing an Error message. 
			if(EMbool) {
				//If here we need to show the error message.
				GUI.Label(rectUserError, EMessage);
		
				//If there is no time left. (Set EMbool to false.) So message will not show no more. and Default EMTLEFT.
				//Otherwise, We need to take away time that has passed.
				if(EMTleft <= 0)
				{
				EMbool = false; 
				}
				else 
				{ EMTleft -= Time.deltaTime; 

				EMTleft = ErrorMessageTimer;}

			}

			GUI.skin = null;
		

			
	}



	
	// Update is called once per frame
	void Update () {
	
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
