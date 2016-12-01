using UnityEngine;
using System.Collections;

/*

-----Ad manager controls whether or not Ad Manager will be active. 

This has 2 main Variables 
String displayAds = "true" or "false" 
String password   = "Shibe" 

In start we check prefecenes and set data. 


*/
public class Admanager : MonoBehaviour {



	public string displayAds = "true"; 
	public string password = "shibe";
	



	// Use this for initialization
	void Start () {


		//check to see if the player pref has adsbool already in their prefences
		//If not, add displayAds to pref with the default value of true. 
		if(!PlayerPrefs.HasKey("displayAds"))
		{
		
			PlayerPrefs.SetString("displayAds", "true");		

	
		}
		else 
		{
			displayAds = PlayerPrefs.GetString("displayAds");

		}

	
	}
	

	//This will stitch the state of display ads from true to false based on the password entered
	public void adswitch(string userpassword){
			
		if(userpassword == password)
		{
			
			if(displayAds == "true")
			{  displayAds = "false";}
			else 
			{  displayAds = "true";}


		}



	}


	/*This function automates the process of turning on ads.
	First it checks to see if a person has ads, on or off. 
	If ads are on or "true", we activate it by calling the admobplugin
	*/
	public void maybeturnadson() {

		if(displayAds == "true")
		{

			bool isAdsOn = GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().IsVisible();
			if (isAdsOn == false)
			{
				
				GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().Show();
				
				
			}

		}
		else 
		{ /* Do Nothing */ }



	}


	/*This function automates the process of turning on ads.
	we activate the ads by calling the admobplugin
	*/
	public void turnadson() {
		bool isAdsOn = GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().IsVisible();
		if (isAdsOn == false)
		{
			
			GameObject.Find("AdMobPlugin").GetComponent<AdMobPlugin>().Show();
			
			
		}

	}




	// Update is called once per frame
	void Update () {
	
	}
}
