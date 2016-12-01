using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class AudioClipRandom : MonoBehaviour {

	public List<AudioClip> AudioList = new List<AudioClip>(); 
	public bool playOnAwake = false;


	public void playRandom() {

		GetComponent<AudioSource>().clip = AudioList[Random.Range(0, AudioList.Count)];

		GetComponent<AudioSource>().Play();


	}


	public void playByScore() {

		int streak = GameObject.Find("Scripts").GetComponent<StreakCounter>().Streak;

		if (streak > 25)
		{
			//Play --DOWN AT THE 50-- audio clip.
			GetComponent<AudioSource>().clip = AudioList[1];
			GetComponent<AudioSource>().Play();

		}
		else if (streak > 35)
		{
			GetComponent<AudioSource>().clip = AudioList[2];
			GetComponent<AudioSource>().Play();

		}else 
		{
			if(Random.Range(0, 2) == 0) 
			{
				GetComponent<AudioSource>().clip = AudioList[0];
				GetComponent<AudioSource>().Play();

			}

			else { GetComponent<AudioSource>().clip = AudioList[3];
				GetComponent<AudioSource>().Play();
			}

		}

	}

	// Use this for initialization
	void Start () {

	//If play on awake is true, play a random sound.
	if (playOnAwake)
	{	playRandom();	}

	}
	
	// Update is called once per frame
	void Update () {
	
	}
}
