using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class Ship_NPC : MonoBehaviour {

	public GameObject destination;
	public float speed = 5f;
	public string owner = "";
	public float SelfDestructTime = 10;
	public float SelfDTLeft;

	float TimeToWaitTillDeath = 2f;
	bool CanDie = false;


	Vector3 FrozenPosition = Vector3.zero;
	// Use this for initialization
	void Start () {
		SelfDTLeft = SelfDestructTime; 
	}
	
	// Update is called once per frame
	void Update () {

		//Self destruct timer.
		if(SelfDTLeft <= 0) 
		{
			destination.GetComponent<Planet_NPC>().shipHit(owner);
			Destroy(gameObject);
		}
		else
		{
			SelfDTLeft -= Time.deltaTime; 
		}


		if(CanDie)
		{ 	TimeToWaitTillDeath -= Time.deltaTime;

			transform.position = FrozenPosition;

			if(TimeToWaitTillDeath < 0) 
			{ 
				Destroy(this.gameObject);
			}
		}

	}



	//Precedure for death for this object. 
	public void startDeathCycle() {
		GetComponent<Renderer>().enabled = false;
		GetComponent<SphereCollider>().enabled = false;
		FrozenPosition = transform.position;
		transform.FindChild("Explosion(Clone)").GetComponent<ParticleSystem>().Play();
		CanDie = true;
	}

	[RPC]
	public void PlanetExplosion(string _name) {


		if(_name.ToLower() == destination.transform.name.ToLower()) 
		{
			startDeathCycle();
		}

	}


	void OnCollisionEnter(Collision c) 
	{
		//See if object matches our destination.
		if(c != null) 
		{
			if (c.transform.name == destination.name) {
				//Destroy Self. 


				//If returns false, Object did not make it. 
				//If returns true. Object successfully penatrated the base.
				if(c.collider.gameObject.GetComponent<Planet_NPC>().shipHit(owner) == false)
				{
					Object[] audioClipObjects = Resources.LoadAll("SFX/ShipExplosion/");
					AudioClip[] audioClip = new AudioClip[audioClipObjects.Length];

					int i = 0;
					foreach(Object audioObject in audioClipObjects)
					{
						audioClip[i] = audioObject as AudioClip;
						i++;
					}

					int randomIntValueForAudioClip = UnityEngine.Random.Range(0, audioClip.Length);

					AudioSource audio = gameObject.AddComponent < AudioSource > ();
					audio.PlayOneShot(audioClip[randomIntValueForAudioClip]);
					//c.collider.gameObject.GetComponent<AudioSource>().Play();
					startDeathCycle();
				}
				else 
				{
					Destroy(this.gameObject);
				}
			}
		}
	}

}
