using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class CountDown : MonoBehaviour {

	public Text TextBox;

	public float startTime = 6f;
	public int LastBeep = 6;

	void Awake() {
		TextBox.enabled = true;
	}

	// Update is called once per frame
	void Update () {
	
		//Wait for startTime to dwindle from Time.delaTime and then destroy self and Gameobject.
		if(startTime > 1)
		{
			if((int) startTime < LastBeep)
			{
				LastBeep = (int) startTime;
				PlayBeep(0);
			}

			TextBox.text = (int) startTime + ""; 
		}
		else
		{
			if((int) startTime < LastBeep)
			{
				LastBeep = (int) startTime;
				PlayBeep(1);
				StartGame();
			}

			TextBox.text = ":)";
		}

		startTime -= Time.deltaTime;

		if(startTime < 0) 
		{
			Destroy(this.gameObject);
		}

	}

	void PlayBeep(int _Input) {
		Object[] audioClipObjects = Resources.LoadAll("SFX/CountDown/");
		AudioClip[] audioClip = new AudioClip[audioClipObjects.Length];
		
		int i = 0;
		foreach(Object audioObject in audioClipObjects)
		{
			audioClip[i] = audioObject as AudioClip;
			i++;
		}

		GetComponent<AudioSource>().PlayOneShot(audioClip[_Input]);

	}

	void StartGame() {
		//Get All Planets
		GameObject[] planets = GameObject.FindGameObjectsWithTag("Planet");
		
		//cycle and start game for each
		foreach(GameObject gameobj in planets)
		{
			gameobj.GetComponent<Planet_NPC>().StartedGame = true;
		}
		
		
		GameObject.Find("InputManager").GetComponent<InputManager>().StartedGame = true;
	}
}
