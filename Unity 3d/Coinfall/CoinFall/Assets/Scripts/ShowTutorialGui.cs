using UnityEngine;
using System.Collections;

public class ShowTutorialGui : MonoBehaviour {

	public bool showTutorial1 = true; //tells this script and onGui whether or not we are showing a tutorial. 

	//Rect needed for tutorial menu. 
	//Tutorial for Arcade mode. 
	public Rect rectBackground ;
	

	//Textures for tutorial. 
	public Texture bitcoinTexture;
	public Texture dogecoinTexture; 
	public Texture litecoinTexture;
	public Texture scamcoinTexture;

 

	//GuiSkin for tutorial
	public GUISkin tutorialSkin;

	// Use this for initialization
	void Start () {
	

	//First we find out if ShowTutorial's 1 has been set. If not, we set it to one to signify we will continue to show tutorial.
	//Else, we already have 'ShowTutorial1' as a Key. We will simply retrieve the value. 
	if(!PlayerPrefs.HasKey("ShowTutorial1"))
	{
		PlayerPrefs.SetInt("ShowTutorial1", 1);
			showTutorial1 = true;
	
	} else 
	{
			showTutorial1 = (PlayerPrefs.GetInt("ShowTutorial1") == 1) ? true : false;
		
	}

	

	
	//Telling Sciprts whether or not we will be showing a tutorial.
	GameObject.Find("Scripts").GetComponent<OnGui>().ShowingTutorial = showTutorial1;
	




	//handle rects 
		rectBackground = new Rect(PercentWidth(5), PercentHeight(1), PercentWidth(90), PercentHeight(90));


	}
	
	void OnGUI() {


			GUI.skin = tutorialSkin;
		if (showTutorial1)
		{
			Time.timeScale = 0;

			
			GUI.Box(rectBackground, "How to Play");

			Rect RectSummaryOfGame = new Rect(PercentWidth(10), PercentHeight(10), PercentWidth(80), PercentHeight(20));


			//coin desrciptions. 
			Rect RectBitcoinImage  = new Rect(PercentWidth(15), PercentHeight(33), PercentWidth(10), PercentHeight(12));
			Rect RectBitcoinLabel  = new Rect(PercentWidth(30), PercentHeight(30), PercentWidth(60), PercentHeight(15));

			Rect RectDogecoinImage  = new Rect(PercentWidth(15), PercentHeight(48), PercentWidth(10), PercentHeight(12));
			Rect RectDogecoinLabel = new Rect(PercentWidth(30), PercentHeight(45), PercentWidth(60), PercentHeight(15));

			Rect RectLitecoinImage  = new Rect(PercentWidth(15), PercentHeight(63), PercentWidth(10), PercentHeight(12));
			Rect RectLitecoinLabel = new Rect(PercentWidth(30), PercentHeight(60), PercentWidth(60), PercentHeight(15));

			Rect RectScamcoinImage  = new Rect(PercentWidth(15), PercentHeight(78), PercentWidth(10), PercentHeight(12));
			Rect RectScamcoinLabel = new Rect(PercentWidth(30), PercentHeight(75), PercentWidth(60), PercentHeight(20));



			//Buttons. 
			Rect RectPlayGame = new Rect(PercentWidth(75), PercentHeight(40), PercentWidth(20), PercentHeight(10));
			Rect RectShowNextTime = new Rect(PercentWidth(75), PercentHeight(60), PercentWidth(20), PercentHeight(10));



			GUI.Label(RectSummaryOfGame, "Catch the coins as they fall. Earn a multiplier and try to keep up the pace."+
										"If you miss one or hit a scam coin, your streak ends. Good Luck Shibes!"); 
			
			
			GUI.DrawTexture(RectBitcoinImage, bitcoinTexture);
			GUI.Label(RectBitcoinLabel, "Bitcoin -- Gain 3 points * multiplier");

			GUI.DrawTexture(RectDogecoinImage, dogecoinTexture);
			GUI.Label(RectDogecoinLabel, "Dogecoin -- Gain 1 point * multiplier");

			GUI.DrawTexture(RectLitecoinImage, litecoinTexture);
			GUI.Label(RectLitecoinLabel, "Litecoin -- Gain 1 seconds");

			GUI.DrawTexture(RectScamcoinImage, scamcoinTexture);
			GUI.Label(RectScamcoinLabel, "Scam coins -- Sacrifice 5 seconds and (5 points * multiplier). Yes, you lose times and points"+
										 ". Its Modeled after the crypto-currency market. Don't end your streak with a scam coin.");


			//buttons. GO!, and Dont Show Again. 
			if(GUI.Button(RectPlayGame, "GO!"))
			{
			GameObject.Find("Scripts").GetComponent<OnGui>().ShowingTutorial = false;
			showTutorial1 = false; 
			Time.timeScale = 1;
			}
	
			if(GUI.Button(RectShowNextTime, "Dont Show Again")){ PlayerPrefs.SetInt("ShowTutorial1", 0);}


			GUI.skin = null;

		}
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
		//Debug.Log("Screen Width1 "+ Widthofscreen);
		//get amount of pixals for out percentage. 
		float pixels = (float)( Widthofscreen * percentage * .01f);
		//Debug.Log("Screen Width "+pixels);
		
		return pixels;
		
	}
}
