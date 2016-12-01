using UnityEngine;
using System.Collections;

public class UnitPercentageHandler : MonoBehaviour {

	public float P1percentage = 1f; 
	public float P2percentage = 1f; 


	int P1counter = 1; 
	int P2counter = 1; 

	public void switchP1Percentage() {

		if(P1counter == 4) 
		{
		P1counter = 1;
		} 
		else 
		{
		P1counter++;
		}

		if(P1counter == 1) 
		{ P1percentage = 1f; }
		else
		if(P1counter == 2) 
		{ P1percentage = .25f; }
		else
		if(P1counter == 3) 
		{ P1percentage = .5f; }
		else
		if(P1counter == 4) 
		{ P1percentage = .75f; }
	}



	public void switchP2Percentage() {
		
		if(P2counter == 4) 
		{
			P2counter = 1;
		} 
		else 
		{
			P2counter++;
		}
		
		if(P2counter == 1) 
		{ P2percentage = 1f; }
		else
			if(P2counter == 2) 
		{ P2percentage = .25f; }
		else
			if(P2counter == 3) 
		{ P2percentage = .5f; }
		else
			if(P2counter == 4) 
		{ P2percentage = .75f; }
	}



}
