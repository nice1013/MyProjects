using UnityEngine;
using System.Collections;
using System;

public class AddWinLevel : MonoBehaviour {

	int[] golds = new int[] 
						{	 30,  30,  30,   30,  30,  15,   
							 5,  5,  5,   30,  30,  30,   
							 30,  30,  30,   30,  30,  30,  
							 30,  30,  30,   30,  30,  30,
							 30,  30,  30,   30,  30,  30
						};


	int[] silvers = new int[] 
						{	60,  60,  60,   60,  60,  60,   
							60,  60,  60,   60,  60,  60,   
							60,  60,  60,   60,  60,  60,  
							60,  60,  60,   60,  60,  60,
							60,  60,  60,   60,  60,  60
						};



	public void Win() {

	/*
	-Name : "LevelProgress"
			-Info : Array of play progress through the levels. 
				0 = Hidden, 1 = CanPlay, 2 = Bronze Win, 3 = Silver Win, 4 = Gold Win. 
			int[] dummyArray = new int[] {1,1,1, 0,0,0,  0,0,0, 0,0,0, 0,0,0, 0,0,0,0,0, 0,0,0,0,0, 0,0,0,0,0};
		PlayerPrefsX.SetIntArray("LevelProgress", dummyArray);
	*/
		/*
		Getting Our Level Progress
		Get The Name and LevelNumber of our loaded level.
		Get the time since the level has been loaded.*/
		int[] levelProgress = PlayerPrefsX.GetIntArray("LevelProgress");
		string name =  Application.loadedLevelName.Replace("Level", "");
		int levelNum = Int32.Parse(name);
		float SinceLevelLoaded = Time.timeSinceLevelLoad;

		Debug.Log("Level Is:"+levelNum);


		//Finding our row. 
		//Take LevelNum - 1, to get our Element value, Divide by three and parse to int. 
		//Then Multiply elto3 by three. This is our base. 
		//Add 0, 1, 2, to get our level element ids. 
		//Add 3, 4, 5, to get the next row of ids above our current one. We need to check to see if they are unlocked. 
		int elto3 = (int) ((levelNum - 1) / 3);
		int ourBase = elto3 * 3; 
		int[] rowElements = new int[] {ourBase, ourBase + 1, ourBase + 2};
		int[] rowAboveElements = new int[] {ourBase + 3, ourBase + 4, ourBase + 5};

		//Create locked Var. 
		//If any level is not '0' slash 'Locked', then the levels have already been unlocked. 
		bool locked = true; 
		foreach(int levelId in rowAboveElements)
		{
			if(levelProgress[levelId] != 0)
			{
				locked = false; //Level is not 0, so it is not locked.
			}
		}



		//Check Against SinceLevelLoaded to see how well we did. 
		//Check for gold, then silver, then bronze. Only one can be used.
		Debug.Log("Silver value:"+silvers[levelNum - 1]);
	
		//If Time is greater than silvers then we are bronze. && LevelProgress is not Gold, or Silver already.
		if(SinceLevelLoaded >  (float) silvers[levelNum - 1] && levelProgress[levelNum - 1] != 3 && levelProgress[levelNum - 1] != 4 )
		{
			Debug.Log("Since Level Loaded:"+SinceLevelLoaded+" Bronze:"+silvers[levelNum - 1]);
			//Give this man a silver star.
			levelProgress[levelNum - 1] = 3;
		}


		if(SinceLevelLoaded <  (float) silvers[levelNum - 1] && levelProgress[levelNum - 1] != 4 )
		{
			Debug.Log("Since Level Loaded:"+SinceLevelLoaded+" Silver:"+silvers[levelNum - 1]);
			//Give this man a silver star.
			levelProgress[levelNum - 1] = 3;
		}


		if(SinceLevelLoaded < (float) golds[levelNum - 1])
		{
			Debug.Log("Since Level Loaded:"+SinceLevelLoaded+" Gold:"+golds[levelNum - 1]);
			//Give this man a gold star. 
			levelProgress[levelNum - 1] = 4;
		}





		//If locked we need to check if all levels on this row have been completed. 
		//We will loop threw rowElements and check to see if all are greater than 1. 
		//If 'completed' all three. We will set each rowAboveElements to 1. 
		if(locked)
		{
			bool completed = true; 
			foreach(int levelId in rowElements)
			{
				if(levelProgress[levelId] <= 1)
				{
					completed = false; //Level is not 0, so it is not locked.
				}
			}

			if(completed)
			{
				foreach(int levelId in rowAboveElements)
				{
					levelProgress[levelId] = 1; //Setting level to 1. 
				}
			}
		}








		PlayerPrefsX.SetIntArray("LevelProgress", levelProgress);














	}



}
