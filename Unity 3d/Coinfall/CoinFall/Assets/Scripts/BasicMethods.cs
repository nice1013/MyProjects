using UnityEngine;
using System.Collections;

public class BasicMethods : MonoBehaviour {

	public int valueondeath = 1; //Can and is set in plugin.
	public Transform dogecoin;
	private int scene;
	public GameObject Scripts;
	public float BonusTime = 3f;
	public float PenaltyTime = 5f;
	public int PenaltyPoints = 5;

	
	public float preventdoubletaptime = .1f; 
	public float pdttleft;
	

	void Start() {

		//get the level that is loaded.
		scene = Application.loadedLevel;
		Scripts = GameObject.Find("Scripts");

		pdttleft = 0; //set pdttleft to default

	}



	void Update() {

		//If preventdoubletap time is not at zero then take time away from it.
		if ( pdttleft >= 0)
		{
		pdttleft -= Time.deltaTime;
		}		



	}

	


	public void DestroyandCancelStreak() {

		
		Scripts.GetComponent<StreakCounter>().misses++;
		//Debug.Log("This level is :"+level);

		//Ask if we are in Time Run which is Level 1.
		if(scene == 2)
		{
		//we are in Time Run, Cancle the current streak. 
		GameObject.Find("Scripts").GetComponent<StreakCounter>().cancelStreak();
		}
		//Ask if we are in Survival. 
		else if(scene == 3)
		{
		
		GameObject.Find("Scripts").GetComponent<OnGui>().endGame = true;
		}

		MemSavingDestroy(); //Mem Saving Destroy. Puts the coin ba
		

	}	


	public void CancelStreak() {
		
		
		
		//Debug.Log("This level is :"+level);
		
		//Ask if we are in Time Run which is Level 2.
		if(scene == 2)
		{
			//we are in Time Run, Cancle the current streak. 
			GameObject.Find("Scripts").GetComponent<StreakCounter>().cancelStreak();
		}
		//Ask if we are in Survival. 
		else if(Application.loadedLevel == 3)
		{
			
			GameObject.Find("Scripts").GetComponent<OnGui>().endGame = true;
		}

		
	}	





	public void SelfDestruct() {
		
		Destroy(gameObject);
		
	}	
















	public void MemSavingDestroy() {

		//Memory Saving Destory (MemSavingDestroy) 
		//Handles the destroy for each game object. Good/Bad Coins or Guys
		//First it seperates the obejct by using its name
		//Since objects are a collection of children
		//It then takes that object and does the following to seperate children objects.
		//Turns off the renderer. 
		//Turns off the rotate 
		//Turns off the colider. 
		//Turns on the renderer for their particle. 
		//Turn on the self destruct bool in the 'ResetToNormal' script . It will turn off Renderer of the Particle-
		//System. and reset the position of that object in a certain amount of secs.
		//Finnally, Turn off the MoveBool in the Coin's Hal.


		if (transform.name == "Dogecoin_W_Particle(Clone)")
		{
			//this.transform.FindChild("ForceField").collider.enabled = false;
			this.transform.FindChild("Dogecoin").GetComponent<Collider>().enabled = false;
			this.transform.FindChild("Dogecoin").GetComponent<Renderer>().enabled = false;
			this.transform.FindChild("Dogecoin").GetComponent<rotate>().enabled = false;
			this.transform.FindChild("dogecoinParticle").GetComponent<Renderer>().enabled = true;
			this.transform.FindChild("dogecoinParticle").GetComponent<ResetToNormal>().isActive = true;
			this.transform.GetComponent<CoinHal>().MoveBool = false;
		}
		else if (transform.name == "Bitcoin1_W_Particle(Clone)")
		{
			this.transform.FindChild("Bitcoin").GetComponent<Collider>().enabled = false;
			this.transform.FindChild("Bitcoin").GetComponent<Renderer>().enabled = false;
			this.transform.FindChild("Bitcoin").GetComponent<rotate>().enabled = false;
			this.transform.FindChild("BitcoinParticle").GetComponent<Renderer>().enabled = true;
			this.transform.FindChild("BitcoinParticle").GetComponent<ResetToNormal>().isActive = true;
			this.transform.GetComponent<CoinHal>().MoveBool = false;
			
		}
	
		else if (transform.name == "Litecoin_W_Particle(Clone)")
		{
			this.transform.FindChild("Litecoin_Prefab").GetComponent<Collider>().enabled = false;
			this.transform.FindChild("Litecoin_Prefab").GetComponent<Renderer>().enabled = false;
			this.transform.FindChild("Litecoin_Prefab").GetComponent<rotate>().enabled = false;
			this.transform.FindChild("Litecoin_Particle").GetComponent<Renderer>().enabled = true;
			this.transform.FindChild("Litecoin_Particle").GetComponent<ResetToNormal>().isActive = true;
			this.transform.GetComponent<BonusCoinHal>().MoveBool = false;
		
			

		}

		else if (transform.name == "Scamcoin_W_Particle(Clone)")
		{	
			this.transform.FindChild("Scamcoin_Prefab").GetComponent<Collider>().enabled = false;
			this.transform.FindChild("Scamcoin_Prefab").GetComponent<Renderer>().enabled = false;
			this.transform.GetComponent<ParticleSystem>().GetComponent<Renderer>().enabled = false;
			this.transform.FindChild("Scamcoin_Prefab").GetComponent<rotate>().enabled = false;
			this.transform.FindChild("Scamcoin_Particle").GetComponent<Renderer>().enabled = true;
			this.transform.FindChild("Scamcoin_Particle").GetComponent<ResetToNormal>().isActive = true;
			this.transform.GetComponent<ScamCoinHal>().MoveBool = false;
			
		}
	}


















	public void CommitScamandDestroy() {
		

		//This function immediately takes the PenaltyTime away from TimeLeft iin ONGUi
		//It grabs the multiplier from StreakCounter. 
		//Checks to see if MUlti == 0 , if so, it just takes the penalty points away. 
		//if it is anything other than 0, it will take that, times the multi, and take that away 
		//from the persons points in 'OnGui'. Example > Points = Points - (penaltyPoints * Multi)
		//Then, it will call MemSavingDestroy, and Cancel the streak using StreakCounter.

		if(pdttleft <= 0)
		{		
			pdttleft = preventdoubletaptime;
		//NEEDNEED 
		//Gui pop up by time rect. RED showing lose of time.
		//

		GameObject.Find("Scam").GetComponent<AudioClipRandom>().playByScore();
		GameObject.Find("HudDamageIndicator").GetComponent<FlashGuiTexture>().ShowDamageImage = true;

		Scripts.GetComponent<OnGui>().TimeLeft -= PenaltyTime;

		int multi = Scripts.GetComponent<StreakCounter>().Multiplier;
		Scripts.GetComponent<StreakCounter>().addr("Scamcoin");

		//Check mult
		if(multi == 0) 
		{Scripts.GetComponent<OnGui>().Points -= PenaltyPoints;}
		 	else 
		{Scripts.GetComponent<OnGui>().Points -= (PenaltyPoints * multi);}
			

		MemSavingDestroy();

		Scripts.GetComponent<StreakCounter>().cancelStreak();
		}

	}
















	//This Function handle the destuctions of a Litecoin/ Bonus coin. 
	//It does a mem destory, and then adds the bonus time to onGui's Timeleft variable. 
	public void AddBonusandDestroy()	{

		if(pdttleft <= 0)
		{		
			pdttleft = preventdoubletaptime;
		//Play ring audio for bonus. -NEEDNEED
		GameObject.Find("Hiss").GetComponent<AudioSource>().Play();

		Scripts.GetComponent<StreakCounter>().addr("Litecoin");//add to litecoin record.

		MemSavingDestroy();
		Scripts.GetComponent<OnGui>().TimeLeft += BonusTime;

		}


	}
















	public void AddtoStreakandDestroy() {
		

			
			

			GameObject.Find("pindrop").GetComponent<AudioSource>().Play();
			
			MemSavingDestroy();
			
	
			bool endGame = Scripts.GetComponent<OnGui>().endGame;
	
			//Debug.Log ("We are in AddtoStreak, The Scene Number is"+ scene);
	
			


			if(pdttleft <= 0)
			{	

			pdttleft = preventdoubletaptime;
	
			if ((scene == 2 )||(scene == 3 && endGame == false))
			{
	
	
			
	
			Scripts.GetComponent<StreakCounter>().addtoStreakandPoints(valueondeath, transform.tag);
			Scripts.GetComponent<StreakCounter>().hits++;
			}
			
	
			Debug.Log("transform name :"+transform.name);


			

		}
		else
		Debug.Log("Blocked"+transform.tag);

		

		
	}	

}
