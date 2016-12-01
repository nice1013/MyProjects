using UnityEngine;
using System.Collections;
using System;
using System.Collections.Generic;

public class StreakCounter : MonoBehaviour {

	/*
	This manages score, and keeps a record of the score. 


	*/


	public int Streak = 0;
	public int HighestStreak = 0;
	public int Multiplier = 0;
	public int hits = 0;
	public int misses = 0;


	//Record Array is a numeric multi array to keep track of score and prevent slipnot from breaking the game. 
	//{0x}{2x}{3x}{4x}{5x}{10x}{bitcoin, litecoin, Dogecoin, scamcoin}
	//public int[,] record = new int[6, 4] { {0, 0, 0, 0}, {0, 0, 0, 0}, {0, 0, 0, 0}, {0, 0, 0, 0}, {0, 0, 0, 0}, {0, 0, 0, 0} };
	
	public int[ , ] record = 		
								{	{0, 0, 0, 0},
									{0, 0, 0, 0},
									{0, 0, 0, 0},		
									{0, 0, 0, 0},	
									{0, 0, 0, 0},			
									{0, 0, 0, 0}	};
	//public List<int[]> record = new List<int[]>();

	


	// Use this for initialization
	void Start () {

		int nothing = getmultiplier(Streak);
		
	
	}

	
	void Awake() {
		Application.targetFrameRate = 60;
	}

	
	// Update is called once per frame
	void Update () {
	
	}

	//using multiplier find out what element we would be insert our records
	public int getrelement() {

		//If multi = a certain number bring back the element value.
		if(Multiplier == 0)
		{
			return 0;
		}
		else
			if(Multiplier == 2)
		{
			return 1;
		}
		else
			if(Multiplier == 3)
		{
			return 2;
		}
		else
			if(Multiplier == 4)
		{
			return 3;
		}
		else
			if(Multiplier == 5)
		{
			return 4;
		}
		else
			if(Multiplier == 10)
		{
			return 5;
		}
		else 
		{
			return 0;
		}


	}

	public void addr(string coin) {

		if(coin == "Bitcoin")
		{
			int element = getrelement();
			record[element , 0]++; //increase the bitcoin value for record.
			
		}
		if(coin == "Dogecoin")
		{
			int element = getrelement();
			record[element , 2]++; //increase the bitcoin value for record.
			
		}
		if(coin == "Scamcoin")
		{
			int element = getrelement();
			record[element , 3]++; //increase the bitcoin value for record.

		}
		if(coin == "Litecoin")
		{
			int element = getrelement();
			record[0 , 1]++; //increase the bitcoin value for record.
			
		}

	}





































	public void checkHighestStreak() {
		
		if (Streak > HighestStreak)	{

			HighestStreak = Streak;		

		}

	}





	public string returnrecord(int[,] record) 
	{
		
		string builddebuglog = "";
		int tally = 0;
		int multi = 0;

		//Calculate Tally from Record.
		//loop rows
		for(int i = 0; i < 6 ; i++)
		{
			
			//Grab multi for record rebuilding.
			if(i == 0)
			{	multi = 1;  }
			else 
				if(i == 1)
			{	multi = 2;  }	
			else 
				if(i == 2)
			{	multi = 3;  }
			else 
				if(i == 3)
			{	multi = 4;  }
			else 
				if(i == 4)
			{	multi = 5;  }
			else 
				if(i == 5)
			{	multi = 10;  }
			
			
			//loop columns
			for(int j = 0; j < 4 ; j++)
			{
				
				
				//builddebuglog += "Record --- I:"+i+" - J:"+j+" - Value :"+record[i][j].ToString+" ---";
				builddebuglog += "The Record for :I"+i+"-J"+j+" : "+record[i , j]+"\n";
				
				
				//IF record[multilevel, coin] != 0 then add a score. 
				if(record[i, j] != 0)
				{
					
					
					
					//If Bitcoin OR Dogecoin OR Scamcoin
					if(j == 0)//if Bitcoin
					{
						//add value to tally.
						tally += record[i, j] * multi * 3;
						
					}
					else 
						if(j == 2)//if dogecoin
					{
						//add value to tally
						tally += record[i, j] * multi * 1;
						
					}
					else 
						if(j == 3)//if dogecoin
					{
						//add value to tally
						tally -= record[i, j] * multi * 5;
						
					}
					
					
					
					
				}
				
				
				
				
				
				
			}//ending for(int j = 0; j < 4 ; j++) -- columns
			
		}// ending for(int i = 0; i < 6 ; i++) -- rows
		//End Calculating Records
		
		return builddebuglog;
	}	



	public void addtoStreakandPoints(int amount, string coin) {

		Streak++;
		checkHighestStreak();
		amount = getmultiplier(amount);
		addr(coin);
		GameObject.Find("Scripts").GetComponent<OnGui>().Points += amount; //get scripts object and update points. 

	}
	

	public void cancelStreak() {

		Streak = 0;
		Multiplier = 0;
	
	}
	

	public int getmultiplier(int amount) {

		int amounttoreturn = 0;

		

		//Check streak against solid numbes and does a simple 1+ x multiplier to the amount in.
		if (Streak > 34)//10x
		{
		amounttoreturn = amount * 10;
		Multiplier = 10;
		}
		else if (Streak > 29)//5x
		{
		amounttoreturn = amount * 5;
		Multiplier = 5;
		}
		else if (Streak > 24)//4x
		{
		amounttoreturn = amount * 4;	
		Multiplier = 4;
		}
		else if (Streak > 14)//3x
		{
		amounttoreturn = amount * 3;	
		Multiplier = 3;
		}
		else if (Streak > 9)//2x
		{
		amounttoreturn = amount * 2;
		Multiplier = 2;
		}
		else //1x
		{
		amounttoreturn = amount;
		Multiplier = 0;
		}

		

		return amounttoreturn;


	}
	

}
