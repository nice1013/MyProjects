using UnityEngine;
using System.Collections;
using GooglePlayGames;
using UnityEngine.SocialPlatforms;
using System;
using System.Text;
using System.Security.Cryptography;
using System.IO;
using SimpleJSON;




public class OnGui : MonoBehaviour {
	
	public float TimeLimit = 60f;  //How many seconds the game last. 
	public float TimeLeft = 0; //How many seconds are left in the game. --Is Set in Start();
	
	public int Points = 0;
	public bool ShowOnGUI = true;  //this says whether or not to HUD
	public bool ShowGameOver = false;  //this says whether or not to show game over. --Will only turn on when HUD is off.
	
	bool dropperbool = true;//bool to say whether or not RandomDropper Is enabled.
	float timetowait = 2;
	
	//grab the gui skins. 
	public GUISkin customSkin; //Custom Skin is Meant for All things in The Game Over Menu.
	public GUISkin HudSkin;  // Hud Skin is meant for all Objects that are displayed during GamePlay.
	public GUISkin FactSkin; //Fact Skin, controls only the Fact Box on the game over screen
	public GUISkin StatsSkin; //Stats when the menu is paused, and at game over
	public GUISkin MultiSkin; //Skin for time run.
	public GUISkin BlankButtonSkin;
	public GUISkin statheaderskin; //The header that says Stats on the CryptoBeggin Section
	
	float eightyPercentWidth; //This is meant to save on Calculations of 80 percent of the width.
	
	
	

	public Texture PauseImage; //This is obivously a Texture for a Pause Image. 
	public Texture dogecoinkingimage; //This is Kabusu King Image at end of game, if Player wins. 


	
	public bool endGame = false; //This bool will allow any script to stop game.
	
	public bool ConvertDeathsToPoints = false;
	
	public float HeightObjectsDie = -15f;
	
	public float MostRecentYSpeed = .25f;


	//Amount of time the level has been runnign
	public float timeElaspe = 0;
	//Amount of time the level has been runnign
	public float gameplayElaspe = 0;
	//CoolDown for poll resubmitting. 
	private float tecooldown = 3f;
	
	private GameObject scripts;
	
	
	private int scene; //what scene is loaded into the script.



	//Addresses for LeaderBoards. 
	public string TimeRunAddress = "CgkIpNP00scDEAIQCQ";
	public string CTAllAddress = "CgkIpNP00scDEAIQAQ";

	//Current Champion addresses. 
	public string champquote = "";
	public string champaddress = "";
	public string champusername = "";
	public string champscore = "";






	//Rect Boxes for Stamina Menu
	public Rect MenuBox;
	public Rect RetryBox;
	public Rect LeaderboardBox;
	public Rect ScoreBox;
	public Rect BackgroundBox;
	public Rect FactBox;
	public Rect MessageBox; 
	public Rect championUserNameBox; 
	public Rect championscorebox; 
	public Rect championquotebox;
	public Rect championaddressbox;


	public Rect FrontScreenBox;



	public Rect hitbox;
	public Rect missbox;
	public Rect highstreakbox;
	public Rect statbox;
	//End Rect Boxes for Stamina Menu
	

	//Rect Boxes For Pause Menu 
	GameObject AdManager;


	//bool that is accesed by tutorialGui. says whether or not a tutorial is showing. 	
	//will cause the pause menu not to show up, when time.scale == 0. 
	public bool ShowingTutorial;
	

	//stats holds the string of the website when we check the score. 
	public string stats = "";
	public WWW www; //for checking the results of a game 
	public WWW statswww; //for checking the champion stats. 


	//siteHolder for game id from server. 
	public WWW gameidrequestwww;
	public string gameidrequeststring = "";
	private string gameid = "";


	//Bool -- Says whether or not we have sent URL to check highscore 
	public bool senturl = false;



	//public response was made 
	public string response = "";


	

	//Bool says status of whether the game is =paused.
	public bool ispaused = false;



	
	void Awake() {
		Application.targetFrameRate = 60;
	}
	
	
	
	
	
	
	
	
	
	//Was adding addtopoints and height level to here, and then set movedowny to fetch it. 
	

	
	
	
	// Use this for initialization
	void Start () {


		Application.runInBackground = true;

		//check to see if practive level or play for doge level. 
		if(Application.loadedLevel == 3)
		{

		//For Stamina Menu. 
		MenuBox = new Rect(PercentWidth(55), PercentHeight(30), PercentWidth(35), PercentHeight(15));
		RetryBox = new Rect(PercentWidth(55), PercentHeight(45), PercentWidth(35), PercentHeight(15));
		LeaderboardBox = new Rect(PercentWidth(55), PercentHeight(15), PercentWidth(35), PercentHeight(15));
		ScoreBox = new Rect(PercentWidth(20), PercentHeight(15), PercentWidth(30), PercentHeight(50));
		BackgroundBox = new Rect(PercentWidth(5), PercentHeight(5), PercentWidth(90), PercentHeight(90));
		FactBox = new Rect(PercentWidth(10), PercentHeight(60), PercentWidth(80),  PercentHeight(20));
		MessageBox = new Rect(PercentWidth(10), PercentHeight(10), PercentWidth(80),  PercentHeight(50));
		FrontScreenBox = new Rect(PercentWidth(10), PercentHeight(60), PercentWidth(80),  PercentHeight(20));
		//END for Stamina Menu
		}
		else if (Application.loadedLevel == 2)
		{
		//For Stamina Menu. 
		//Score
		ScoreBox = new Rect(PercentWidth(5), PercentHeight(5), PercentWidth(40), PercentHeight(50));
		
		//Buttons Right Side
		MenuBox = new Rect(PercentWidth(55), PercentHeight(10), PercentWidth(40), PercentHeight(15));
		RetryBox = new Rect(PercentWidth(55), PercentHeight(25), PercentWidth(40), PercentHeight(15));
		
		//Show Stat senction
		hitbox = new Rect(PercentWidth(5), PercentHeight(55), PercentWidth(40), PercentHeight(10));
		missbox = new Rect(PercentWidth(5), PercentHeight(65), PercentWidth(40), PercentHeight(10));
		highstreakbox = new Rect(PercentWidth(5), PercentHeight(45), PercentWidth(40), PercentHeight(10));
		
		MessageBox = new Rect(PercentWidth(55), PercentHeight(43), PercentWidth(40),  PercentHeight(10));
		//championUserNameBox = new Rect(PercentWidth(55), PercentHeight(40), PercentWidth(20),  PercentHeight(10)); 
		championscorebox = new Rect(PercentWidth(55), PercentHeight(50), PercentWidth(40),  PercentHeight(10)); 
		championquotebox = new Rect(PercentWidth(55), PercentHeight(60), PercentWidth(40),  PercentHeight(20));



		FrontScreenBox = new Rect(PercentWidth(10), PercentHeight(60), PercentWidth(80),  PercentHeight(20));
		
		FactBox = new Rect(PercentWidth(10), PercentHeight(90), PercentWidth(80),  PercentHeight(10));
		//END for Stamina Menu
		}




		
		
		



		//Values we will need to show the user.
		int Hits = this.GetComponent<StreakCounter>().hits;
		int misses = this.GetComponent<StreakCounter>().misses;
		int HighestStreak = this.GetComponent<StreakCounter>().HighestStreak;
		
		
		
		
		
		
		
		
		
		Time.timeScale = 1;
		TimeLeft = TimeLimit;
		float eightyPercentWidth = PercentWidth(80);
		scripts = GameObject.Find("Scripts");
		scene = Application.loadedLevel;

		//Debug.Log("HELLO");
		//Debug.Log("Scene number is "+ scene);
		
		

		//-------------PULL DATA FROM SERVER-------------------------------
		string url = "http://coinfall.pw/pull/stats.php";
		statswww = new WWW(url);
		StartCoroutine(WaitForRequest(statswww));
		
	
		//If here we are grabing the gameID
		url = "http://coinfall.pw/gg.php";
		gameidrequestwww = new WWW(url);
		StartCoroutine(getGameId(gameidrequestwww));
		
		
		
	}
	





	
	
	//On gui does a few thinggs. 
	//First it as 'scene' for the current scene. If it CCTA, OR Time run, show the right hud. 
	//then it ask if it should run the pause menu, and game over. 
	void OnGUI() {
		

		
		



		//check to see if we have a game id. 
		if(gameid == "")
		{

			//Parse string returned from our webpage
			if(gameidrequeststring != "")
			{
				var N = JSON.Parse(gameidrequestwww.text);
				gameid = N["gameid"].Value;    
				Debug.Log("We have a game id :"+gameid);   
				//Debug.Log ("Website Data, nameis : " + champusername);
			}
			


		}










		//Recheck to see if Champ variables are empty. If they are, try to fill them with the stats of the current champion
		if(champaddress == "" || champquote == "" || champusername == "" || champscore == "")
		{
			
			
			//Parse string returned from our webpage
			if(statswww.error == null)
			{
				var N = JSON.Parse(statswww.text);
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





		if(!ShowingTutorial)
		{



			//Decide if 'TIME RUN' or 'CTA'
			if (scene == 2)
			{
				ShowHudScreenfortime(); //show the hud screen for the time run game.
			}
			else 
			{
				ShowHudScreenforStamina();
			}
	




			//If game is still running then check pause menu, if not run game over creens.
			if (TimeLeft <= 0 || endGame == true)
			{
				//check to see if game is over. 
				showGameOverScreen();
			}
			else 
			{
			
				//Check to see if menu is paused.
				PauseMenuWatcher();
			}		





		}
		
		
	}
	
	
	
	
	
	
	// Update is called once per frame
	void Update () {
		

		
			
	
		
		




		
		//int[,] recarray = scripts.GetComponent<StreakCounter>().record;
		//string holdrec = convertRec(recarray);
		
		//Debug.Log("Hold Rec"+holdrec);		


		//Every 10 seconds of run time, create poll for game. 


		if(scene == 2)
		{
			//Check to see if Time has ran out. 
			if (TimeLeft <= 0) 
			{
				//if here time has ran out. 
				//Debug.Log("Time Has Ran Out");
				
				
				//We check to see if the dropper bool is true, if so 
				//we can turn off RandomDropper
				//Next time through, we wont do anything. 
				if (dropperbool == true)
				{
					GameObject.Find("Scripts").GetComponent<Hal>().enabled = false;
					dropperbool = false;
					ShowOnGUI = false;
				}
				
				//We Are waiting for OBjects to go. 
				//Gave them two seconds.
				if (timetowait < 0) 
				{
					ShowGameOver = true;
				}
				
				timetowait -= Time.deltaTime;
				
			}
			else 
			{
				//Adjust Time Left.
				TimeLeft -= Time.deltaTime;

				//Debug.Log (" Test TimeElaspe : "+timeElaspe);
				//Keep track of time that has elaspe in game.
				timeElaspe += Time.unscaledDeltaTime;
				gameplayElaspe += Time.deltaTime;
				tecooldown -= Time.unscaledDeltaTime;			
				
				
				int te = (int) timeElaspe;
				
				//Every %% Seconds poll the database. 
				if(te % 17 == 0) 
				{
					
					
					if(tecooldown <= 0 ) 
					{
						//If here we are grabing the gameID
						WWWForm pollform = new WWWForm();
						string url = "http://coinfall.pw/pp.php";
						pollform.AddField("gameid", gameid);
						pollform.AddField("score", Points);
						gameidrequestwww = new WWW(url, pollform);
						
						
						
						StartCoroutine(poll(gameidrequestwww));
					}
					
					tecooldown = 3;
					
					
				}
				


			}

		}
		else if (scene == 3)
		{

			//Check to see if Time has ran out. 
			if (endGame == true) 
			{
				//if here time has ran out. 
				Debug.Log("You missed One!");
				
				
				//We check to see if the dropper bool is true, if so 
				//we can turn off RandomDropper
				//Next time through, we wont do anything. 
				if (dropperbool == true)
				{
					GameObject.Find("Scripts").GetComponent<Hal>().enabled = false;
					dropperbool = false;
					ShowOnGUI = false;
				}
				
				//We Are waiting for OBjects to go. 
				//Gave them two seconds.
				if (timetowait < 0) 
				{
					ShowGameOver = true;
				}
				
				timetowait -= Time.deltaTime;
				
			}
			



		}
		
		
		
		
		
	}
	
	
	



	void PauseMenuWatcher() {

		



		//If timescale == 0, then we are paused. Show the menu
		if(Time.timeScale == 0)
		{


			//If here, game is paused. Change ispaused status to represent that the game is paused. 
			ispaused = true;


			
			if (Application.platform == RuntimePlatform.Android)
			{

				
				//We are paused, we need to turn ads on.
				
				if (GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().IsVisible() == false)
				{
					
					GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().Show();
					
					
				}
				
			}




			//Generate an Ad.
			//GameObject.Find("AdMobPlugin").GetComponent<AdMobPluginMockup>().DrawAd();
			//GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().Load();
			
			//Get the custom Skin for box background
			GUI.skin = customSkin;
			
			
			//generate the background box. [Used Only for its Background. 
			GUI.Box(new Rect(PercentWidth(10),
			                 PercentHeight(10),
			                 eightyPercentWidth,
			                 PercentHeight(80)), "");
			
		
			//set skin to null so that it doesn't affect the next gui item. 
			GUI.skin = null;
			GUI.skin = BlankButtonSkin;
			
			//generate the button for Resume
			if(GUI.Button(new Rect(PercentWidth(55),
			                       PercentHeight(15),
			                       PercentWidth(35),
			                       PercentHeight(15)), "Resume"))
			{
				//loading up the Level again
				Time.timeScale = 1;
				
			}
	
	
	
			//generate the button for Retry
			if(GUI.Button(new Rect(PercentWidth(55),
			                       PercentHeight(30),
			                       PercentWidth(35),
			                       PercentHeight(15)), "Retry"))
			{
				//loading up the Level again
				Application.LoadLevel(Application.loadedLevel);
				Time.timeScale = 1;
				
			}
		
			
			//generate the button for returning back to the main menu.
			if(GUI.Button(new Rect(PercentWidth(55),
			                       PercentHeight(45),
			                       PercentWidth(35),
			                       PercentHeight(15)), "Return To Main Memu"))
			{
				//loading up the main menu.
				Application.LoadLevel(1);
				Time.timeScale = 1;
				
			}
			
		
	
			//DISPLAY STATS BY SCene
	
			//Check Scene to Determine what score to show. 
			//Is scene CTA
			if (scene == 3)
			{
	
	
	
	
				//STATS
				//get skin for out next item. Label. Mainly makes the font bigger, and centered.
				GUI.skin = customSkin;
				
				int HighestStreak = GameObject.Find("Scripts").GetComponent<StreakCounter>().HighestStreak;
				
				//generate the new label. with points 
				GUI.Label(new Rect(PercentWidth(20),
				                   PercentHeight(15),
				                   PercentWidth(30),
				                   PercentHeight(50)), ""+HighestStreak);
				//Reset skin to null so it doesnt affect the next gui item.
				GUI.skin = null;
	
	
	
	
	
	
			}
			else if (scene == 2) //Is scene Time Run
			{
			
	
	
	
				//Values we will need to show the user.
				int Hits = GameObject.Find("Scripts").GetComponent<StreakCounter>().hits;
				int misses = GameObject.Find("Scripts").GetComponent<StreakCounter>().misses;
				int Points = GameObject.Find("Scripts").GetComponent<OnGui>().Points;
				int HighestStreak = GameObject.Find("Scripts").GetComponent<StreakCounter>().HighestStreak;
				
				
				GUI.skin = customSkin;
				
				
				
				//generate the new label. with points 
				GUI.Label(new Rect(PercentWidth(20),
				                   PercentHeight(15),
				                   PercentWidth(30),
					               PercentHeight(50)), ""+Points);
				//Reset skin to null so it doesnt affect the next gui item.
				
				GUI.skin = null;
				GUI.skin = StatsSkin;
				//Create the small stats along the bottom of Points. 
				//Hits - Misses - HS
				GUI.Label(new Rect(PercentWidth(20),
				                   PercentHeight(50),
				                   PercentWidth(15),
					               PercentHeight(5)), "Hits:"+Hits);
	
				GUI.Label(new Rect(PercentWidth(35),
				                   PercentHeight(50),
				                   PercentWidth(15),
					               PercentHeight(5)), "Misses:"+misses);
					GUI.skin = null;
	
			}
				    









		

		
		
		
		
			//setting the gui skin for the label; BITCOIN FACTS
			GUI.skin = FactSkin; 
			
			//get the btc quote we will show to the user.
			string quote = GameObject.Find("Scripts").GetComponent<BitcoinAdvantages>().BTCfact;
			
			
			//generate the new label. with points 
			GUI.Label(new Rect(PercentWidth(10),
			                   PercentHeight(65),
			                   PercentWidth(80),
			                   PercentHeight(20)), "Did You Know? "+quote);
			
			GUI.skin = null;






		}//end time scale == 0
		else //Else Game is not paused, time is still moving, ads need to be turned off.
		{


			//The game is not paused, update ispaused to show that status.
			ispaused = false;










			if (Application.platform == RuntimePlatform.Android)
			{

				//We need to turn ads off.
				if (GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().IsVisible())
				{
					GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().Hide();
						
				}

			}



		}




	}
	
	
	






	void ShowHudScreenforStamina() {


		//This if statement holds our HUD. 
		if (ShowOnGUI == true)
		{
			GUI.skin = HudSkin;		
			
	
			
			//Get Highest Streak. 
			int HighStreak = scripts.GetComponent<StreakCounter>().HighestStreak;
			GUI.Label(new Rect(15, 15, 125, 30), "Highest :"+HighStreak);
			GUI.skin = null; 
			if(GUI.Button(new Rect(PercentWidth(85), 15, 75, 75), PauseImage))
			{
				
				if (Time.timeScale == 1)
				{
					Time.timeScale = 0;

					

				}else
				{
					Time.timeScale = 1;
				}
				
			}
			
			
			//Change the GUI.skin to null to normalize the rest of fonts.
		}		
		
	
	
	}








	
	void ShowHudScreenfortime() {
		
		//This if statement holds our HUD. 
		if (ShowOnGUI == true)
		{
			GUI.skin = HudSkin;		
			
			//Say how much time is left in game. 
			GUI.Label(new Rect(15, 15, 125, 30), "Time: "+(int)TimeLeft);
			//Say how much time is in points. 
			GUI.Label(new Rect(15, 50, 125, 30), "Points: "+Points);
			
			//grab the multiplier from StreakCounter. 
			int Multi = scripts.GetComponent<StreakCounter>().Multiplier;
			if (Multi > 0) 
			{
			//If there is actually a multiplier, show  them.
			//Show The multi plier. 
			GUI.skin = MultiSkin;
			GUI.Label(new Rect(PercentWidth(88), PercentHeight(80), PercentWidth(15), PercentHeight(15)), Multi+"x");
			
			}			

			GUI.skin = null;
			GUI.skin = BlankButtonSkin;
			//Get Highest Streak. 
			//int HighStreak = scripts.GetComponent<StreakCounter>().HighestStreak;
			//GUI.Label(new Rect(15, 120, 125, 30), "Highest :"+HighStreak);
			
			if(GUI.Button(new Rect(PercentWidth(85), 15, 75, 75), PauseImage))
			{
				
				if (Time.timeScale == 1)
				{
					Time.timeScale = 0;
				}else
				{
					Time.timeScale = 1;
				}
				
			}
			
			
			GUI.skin = null; //Change the GUI.skin to null to normalize the rest of fonts.
		}		
		
	}
	




	
	void showGameOverScreen() {

		

		if (Application.platform == RuntimePlatform.Android)
		{
			//Turning ads on
			if (GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().IsVisible())
			{
				
				GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().Show();
				
				
			}
		}

		//This functions shows the game over scene. It houses both gameover menus. Showtime, and ShowStamina
		//If Show game over == true, then we need to show a game over screen. 
		if (ShowGameOver == true)
		{

			if(!GameObject.Find("Applause").GetComponent<AudioSource>().isPlaying)
			{
			GameObject.Find("Applause").GetComponent<AudioSource>().Play();
			}

			//if our current scene is 2, we Show, ShowtimeGame over. 
			if(scene == 2)
			{
			//this is the play for Doge game 
			//We have to send info the server, turn on loading screen.
			

			ShowTimeGameOver();
			}
			//If our current scene is 3, we show, ShowStaminaGameOver();
			else if (scene == 3)
			{
			ShowStaminaGameOver();
			}


		}
			
	}










	
	void ShowStaminaGameOver() {
		
		//First Do Operations that involve ADMOB, and LEADERBOARDs. //Then Do Screen Apperance. 

		//We grab the highest steak, for that is the game that is over. 
		int HighestStreak = GameObject.Find("Scripts").GetComponent<StreakCounter>().HighestStreak;
		//We generate a statement that should be immediately replaced.
		string postScoreStatement = "Sorry! Your Score didn't get sent.";
		
		//Generate an Ad.
		//GameObject.Find("AdMobPlugin").GetComponent<AdMobPluginMockup>().DrawAd();
		//GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().Load();
		
		if(Social.localUser.authenticated)
		{
		//Send the Score the Leaderboards.
		Social.ReportScore(HighestStreak,  CTAllAddress, (bool success2) => {
			// handle success or failure
			if (success2)
			{
				postScoreStatement = "We have attempted to sign in, SUCCESS! and Posted a score.";
				
			}
			else {
				postScoreStatement = "We have attempted to sign in, SUCCESS! and failed to post a score..";
			}
			
		});
		}
		else 
		{
		Debug.Log("Sorry, We dont work");
		}





		//Generate The background
		//Get the custom Skin for box background
		GUI.skin = customSkin;
		//generate the background box. [Used Only for its Background. 
		GUI.Box(BackgroundBox, "");
		//set skin to null so that it doesn't affect the next gui item. 
		GUI.skin = null;
		

		
		//get skin for out next item. Label. Mainly makes the font bigger, and centered.
		GUI.skin = customSkin;


		//Generate The Left Side of the screen, MainMenu, Retry, and LeaderBoards. 
		//generate the button for returning back to the main menu.
		if(GUI.Button(MenuBox, "Main Memu"))
		{
			//loading up the main menu.
			Application.LoadLevel(0);
			
		}

		//generate the button for Retry
		if(GUI.Button( RetryBox, "Retry"))
		{
			//loading up the Level again
			Application.LoadLevel(Application.loadedLevel);
			
		}
		
		//Generate button for loading the LeaderShip Boards
		if(GUI.Button(LeaderboardBox, "View HighScores"))
		{
			
			((PlayGamesPlatform) Social.Active).ShowLeaderboardUI("CgkIpNP00scDEAIQAQ");
			

		}

		



		
		
		
	

		//generate the new label. with points 
		GUI.Label(ScoreBox, ""+HighestStreak);


		

		




		//Reset skin to null so it doesnt affect the next gui item.
		GUI.skin = null;
		
		
		
		
		//setting the gui skin for the label; BITCOIN FACTS
		GUI.skin = FactSkin; 
		
		//get the btc quote we will show to the user.
		string quote = GameObject.Find("Scripts").GetComponent<BitcoinAdvantages>().BTCfact;
		
		
		//generate the new label. with points 
		GUI.Label(FactBox, "Did You Know?  "+quote);
		
		GUI.skin = null;
		
		
		
	}
	
	
	



























	
	void ShowTimeGameOver() {
		
		
		//We will handle any Ad Plugins or Google Play services stuff, In the biggining, then we will handle the Menu UI. 

		//Debug.Log("Time Game Over: "+timeElaspe);
		
		


		//Herre we will send the data to be verified by the server. 
		//check to see if have sent a url already.
		if(senturl == false) 	
		{

			int[,] rec = scripts.GetComponent<StreakCounter>().record;
			

			string url = "http://coinfall.pw/gs.php";
			//string url = "127.0.0.1/cf/gs.php";

			senturl = true;

			
			string uaddress = PlayerPrefs.GetString("address");
			string uquote = PlayerPrefs.GetString("quote");
			string uname = PlayerPrefs.GetString("username");
			string upoints = "" + Points;
			string urec = convertRec(rec);
			string utime = "" + gameplayElaspe;
			
			

			Debug.Log ("Record being Sent: " + urec);



			WWWForm form = new WWWForm();
			form.AddField("ua", uaddress);  //User Address
			form.AddField("uq", uquote);	//User Quote
			form.AddField("un", uname);		//User Name
			form.AddField("us", upoints);	//User Points
			form.AddField("ur", urec);		//User Record
			form.AddField("ut", utime);		//User Game play Duration.
			form.AddField("ugid", gameid);		//User Game play Duration.

			www = new WWW(url, form);



			//Debug.Log("PointsUnecrypted : "+Points);
			//Debug.Log("tosend: "+tosend);
			
			StartCoroutine(WaitForRequest(www));

			


			


			
		}
		else 
		{

			

			//if stats doesn't equal null, then that means we got a response from the website.
			if(stats != "")
			{

				if(stats == "nothing")
				{
					//Debug.Log("Failed To Submit Score");
				}
				else 
				{
					Debug.Log("Response"+www.text);

					var array = JSON.Parse(stats);
					response = array["status"].Value;    


				}


				

				
				

			}

			

		}
		
	
		
			//First we Build the Background, Then Right Side... -Main Menu, Retry, View HighScores. 
			//Then Leftside and Bottom (facts)
			
			//Building Background.
			GUI.skin = customSkin;//Get the custom Skin for box background
			GUI.Box(BackgroundBox, ""); //generate the background box.
			//set skin to null so that it doesn't affect the next gui item. 
			GUI.skin = null;
			



			

			//Building Right Side.
			//Main Menu, Retry, View Highscores. 
	
			//get skin for out next item. Label. Mainly makes the font bigger, and centered.
			GUI.skin = customSkin;

			//generate the button for returning back to the main menu.
			if(GUI.Button(MenuBox, "Main Memu"))
			{
				//loading up the main menu.
				Application.LoadLevel(1);
				
			}
			
			//generate the button for Retry
			if(GUI.Button(RetryBox, "Retry"))
			{
				//loading up the main menu.
				Application.LoadLevel(Application.loadedLevel);
				
			}

		
			
			
			//Values we will need to show the user.
			int Hits = this.GetComponent<StreakCounter>().hits;
			int misses = this.GetComponent<StreakCounter>().misses;
			int HighestStreak = this.GetComponent<StreakCounter>().HighestStreak;
		
			//Now Left Side, "SCORE"& other stats. 
			//generate the new label. with points 
			GUI.Label(ScoreBox, ""+Points);
			//Reset skin to null so it doesnt affect the next gui item.
			GUI.skin = null;
			
				
			
			//setting the gui skin for the label; BITCOIN FACTS
			GUI.skin = FactSkin; 
			//get the btc quote we will show to the user.
			string quote = GameObject.Find("Scripts").GetComponent<BitcoinAdvantages>().BTCfact;
			//generate the new label. with points 
			GUI.Label(FactBox, "Did You Know?  "+quote);
			//Reset skin to null so it doesnt affect the next gui item.
			GUI.skin = null;
			

		
			
			GUI.skin = StatsSkin;
			//Create the small stats along the bottom of Points. 
			//Hits - Misses - HS
			
			GUI.Label(hitbox , "Hits:"+Hits);
			GUI.Label(missbox, "Misses:"+misses);
			GUI.Label(highstreakbox, "Highest Streak: "+HighestStreak);
		
			GUI.skin = null;


			//The champion details --OR-- the congradulations table		
			GUI.skin = statheaderskin; 			

			if(response == "") 
			{
			GUI.Label(MessageBox, "Connecting");
			}
			else 
			if(response == "winner") 
			{

				GUI.Label(MessageBox, champusername+" is King");
			GUI.Label(championscorebox, "- "+champscore+" -");
				GUI.Label(championquotebox, champquote);
			
			}
			else if (response == "congrats")
			{
				GUI.Label(MessageBox, "You are the Coinfall King!");
				GameObject.Find("kingImage").GetComponent<GUITexture>().enabled = true;	

			}
		
			GUI.skin = null;

	}



	public string convertRec(int[,] array)
	{

		string stringholder = "";

		//loop rows
		for(int i = 0; i < 6 ; i++)
		{
		
			
			
			//loop columns
			for(int j = 0; j < 4 ; j++)
			{
				
				
				//builddebuglog += "Record --- I:"+i+" - J:"+j+" - Value :"+record[i][j].ToString+" ---";
				stringholder += array[i , j]+"-";
					
			}//ending for(int j = 0; j < 4 ; j++) -- columns
			
		}// ending for(int i = 0; i < 6 ; i++) -- rows

		return stringholder;

	}

	





	public string populate(string input)
	{

		string populatedstring = "";

		for(int i=0; i < input.Length; i++)
		{
		
			populatedstring += input[i] + GetUniqueKey(1);
			//Debug.Log ("TestingPopulatedString :"+populatedstring+" :Current I = "+i);

		}

		return populatedstring;

	}

	public static string GetUniqueKey(int maxSize)
	{
		char[] chars = new char[62];
		chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890=!@#$".ToCharArray();
		byte[] data = new byte[1];
		RNGCryptoServiceProvider crypto = new RNGCryptoServiceProvider();
		crypto.GetNonZeroBytes(data);
		data = new byte[maxSize];
		crypto.GetNonZeroBytes(data);
		StringBuilder result = new StringBuilder(maxSize);
		foreach (byte b in data)
		{
			result.Append(chars[b % (chars.Length)]);
		}
		return result.ToString();
	}


	public string checkscore(int score){


			return "";

	}

	public static string Reverse(string input)
	{
		if (input == null)
			throw new ArgumentNullException("input");
		
		// allocate a buffer to hold the output
		char[] output = new char[input.Length];
		for (int outputIndex = 0, inputIndex = input.Length - 1; outputIndex < input.Length; outputIndex++, inputIndex--)
		{
			// check for surrogate pair
			if (input[inputIndex] >= 0xDC00 && input[inputIndex] <= 0xDFFF &&
			    inputIndex > 0 && input[inputIndex - 1] >= 0xD800 && input[inputIndex - 1] <= 0xDBFF)
			{
				// preserve the order of the surrogate pair code units
				output[outputIndex + 1] = input[inputIndex];
				output[outputIndex] = input[inputIndex - 1];
				outputIndex++;
				inputIndex--;
			}
			else
			{
				output[outputIndex] = input[inputIndex];
			}
		}
		
		return new string(output);
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
			stats = "nothing";
		}
	}
	
	IEnumerator getGameId(WWW www)
	{
		yield return www;
		
		// check for errors
		if (www.error == null)
		{
			Debug.Log("Poll Checked :" + www.data);
			gameidrequeststring = www.text; //setting data when available. 
			//stats = www.text; //setting data when available. 
		} else {
			Debug.Log("Poll Checked -- Error :" + www.error);
			//stats = "nothing";
		}
	}


	IEnumerator poll(WWW www)
	{
		yield return www;
		
		// check for errors
		if (www.error == null)
		{
			//Debug.Log("Poll Checked :" + www.data);
			//stats = www.text; //setting data when available. 
		} else {
			//Debug.Log("Poll Checked -- Error :" + www.error);
			//stats = "nothing";
		}
	}
	







































	
	public string encrypt(string input) 
	{


		byte[] encodedbytes = System.Text.ASCIIEncoding.ASCII.GetBytes(input);

		Debug.Log("encoded byte 1: " + encodedbytes[0]);

		string encodedpoints = System.Convert.ToBase64String(encodedbytes);
		
		
		
		string holdthis = populate(encodedpoints);
		holdthis = populate(holdthis);
		
		holdthis = Reverse(holdthis);
		
		holdthis = populate(holdthis);
		
		return holdthis;

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
		//Debug.Log("Screen Width1 "+ Widthofscreen);
		//get amount of pixals for out percentage. 
		float pixels = (float)( Widthofscreen * percentage * .01f);
		//Debug.Log("Screen Width "+pixels);
		
		return pixels;
		
	}
	
	
	
	
}
