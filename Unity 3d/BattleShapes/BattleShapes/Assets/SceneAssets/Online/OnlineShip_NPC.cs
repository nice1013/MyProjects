using UnityEngine;
using System.Collections;

public class OnlineShip_NPC : MonoBehaviour {

	
	public GameObject destination;
	public float speed = 5f;
	public string owner = "";
	public float SelfDestructTime = 10;
	public float SelfDTLeft;
	public bool OnlineReady = false; //Says whether or not to start using it's update.
	
	float TimeToWaitTillDeath = 2f;
	bool CanDie = false;

	OnlineLevelManager OLM;
	
	Vector3 FrozenPosition = Vector3.zero;
	// Use this for initialization
	void Start () {
		//Get OnlineLevelmanager
		OLM = GameObject.Find("LevelManager").GetComponent<OnlineLevelManager>();
		//Setup SelfDestructTimer
		SelfDTLeft = SelfDestructTime; 
		//Setup color for this object.
		if(owner.ToLower() == "player1")
		{
			GetComponent<MeshRenderer>().materials[0].color = ColorHelper.hexToColor(OLM.player1Color);
		}
		else
		{
			GetComponent<MeshRenderer>().materials[0].color = ColorHelper.hexToColor(OLM.player2Color);
		}
		//Change the size of this ship by default.
		transform.localScale = new Vector3(.66f, .66f, .66f);



		//Correct Rotation for Ships.. If needed -- Verified by looking at game live.
		if(transform.name == "Cross(Clone)" || transform.name == "Star(Clone)" || transform.name == "Heart(Clone)")
		{
			transform.localEulerAngles = new Vector3(90, 0 , 0 );
		}

		//Correct Size for ships. 
		if(transform.name == "Diamond(Clone)" || transform.name == "Star(Clone)" )
		{
			transform.transform.localScale = new Vector3(1.25f, 1.25f, 1.25f);
		}	




	}




	
	// Update is called once per frame
	void Update () {
	
	if(OnlineReady) 
	{
		//Self destruct timer.
		if(SelfDTLeft <= 0) 
		{
			destination.GetComponent<OnlinePlanet_NPC>().shipHit(owner);
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
				if(GetComponent<NetworkView>().isMine)
				{
						Network.Destroy(GetComponent<NetworkView>().viewID);
				}
			}
		}
		
	}
	}
	


	[RPC] 
	public void setupThisShip(string _owner, string TargetName) 
	{
		destination = GameObject.Find(TargetName);
		transform.LookAt(destination.transform);
		owner = _owner;
	}


	[RPC] 
	public void setupUnitAttachedToThis(string FromName, string TargetName, string PathName) 
	{
		GameObject FROM = GameObject.Find(FromName);
		GameObject TO = GameObject.Find(TargetName);
		GetComponent<OnlineUnit> ().setUnit(FROM.transform, TO.transform);
		GetComponent<OnlineUnit>().pathName = PathName;
		GetComponent<OnlineUnit>().enabled = true;
		GetComponent<MeshRenderer>().enabled = true;
	}



	
	//Precedure for death for this object. 
	public void startDeathCycle() {
		if(GetComponent<NetworkView>().isMine)
		{
		GetComponent<NetworkView>().RPC("shipExploded", RPCMode.All, new object[] {});
		}
		CanDie = true;
	}
	
	[RPC]
	public void PlanetExplosion(string _name) {
		
		
		if(_name.ToLower() == destination.transform.name.ToLower()) 
		{
			startDeathCycle();
		}
		
	}

	[RPC] 
	public void shipExploded() {
		GetComponent<Renderer>().enabled = false;
		GetComponent<SphereCollider>().enabled = false;
		FrozenPosition = transform.position;
		transform.FindChild("Explosion").GetComponent<ParticleSystem>().Play();
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
				if(c.collider.gameObject.GetComponent<OnlinePlanet_NPC>().shipHit(owner) == false)
				{
					startDeathCycle();
				}
				else 
				{
					if(GetComponent<NetworkView>().isMine)
					{
						Network.Destroy(GetComponent<NetworkView>().viewID);
					}

				}
			}
		}
	}


	private void OnSerializeNetworkView(BitStream stream, NetworkMessageInfo info) {
		
		if (stream.isWriting) {
			//Network Owner is writing
			if(Network.isServer)
			{
			Vector3 pos = transform.position;
			stream.Serialize(ref pos);
			}
		} else {
			//We are recieving.
			Vector3 pos = Vector3.zero;
			stream.Serialize(ref pos);
			transform.position = pos;
		}
	}


}
