using UnityEngine;
using System.Collections;


/* LevelManager stores the current Custom Prefabs for the level. 
 * It stores the Planet for both players to use, and stores the Player1Ship, and Player2Ship. 
 */
public class OnlineLevelManager : MonoBehaviour {

	//The planet NPC that will be used in the level. 
	public GameObject PlanetNPC; 
	public GameObject PlanetNPCAfterEverything; 
	//Their shape and color
	public GameObject player1; 
	public GameObject player2; //Player two must be entered on the fly. 

	public string Player2Object = "";

	public string player1Color = "";
	public string player2Color = ""; 
	string player1Shape = ""; 
	string player2Shape = ""; 


	//Connection Section
	bool ConnectClient = false;
	bool isClient = false;
	bool UsingTS = false;
	float[] TIMEOUTSECONDS = new float[] {25f, 25f}; //Amount of time before we cancle connection. [0] Static Time. [1] Working Time. --To use for counter.
	int StepCounter = 0; //Keeps track of which point we are in our connection.
	int LastStepCounter = -1; //Keeps track of our last preformed step, so we do not accidentally commit a task twice.


	OnlineCSManager CSM = new OnlineCSManager();

	NetworkView netview;



	void Awake() { 
		netview = GetComponent<NetworkView>(); 
	}


	void Update() { 

		if(Network.isClient)
		{
		if(ConnectClient) 
		{
			HandleClientConnection();
			//Take time from timeout.
			if(UsingTS)
			{ TIMEOUTSECONDS[1] -= Time.deltaTime; }
		}
		}


	}




	//Upon connection to the server, we have to set up visuals for both our client, and server. 
	//To do this, we use StepCounter to keep track of what to do, and that we do each thing at the right time. 
	//As each step increases, the TIMEOUTSECONDS[0] is reseted, to prevent timeout. 
	public void HandleClientConnection() {
		if(Network.isClient)
		{
			if(TIMEOUTSECONDS[1] > 0) 
			{
				Debug.Log("Inside HandleClientConnection() Current StepCounter:"+StepCounter);
				//Our First 2 Steps are Provided by the server as it sets the their players types on their(server) device, and our's(client).
				if(StepCounter == 0 && LastStepCounter != 0) 
				{

					LastStepCounter = StepCounter;
				}

				//Our next 2 Steps are Provided by the client as it sets the their players types on (server) device, and our's(client).
				if(StepCounter == 2 && LastStepCounter != 2) 
				{
					TIMEOUTSECONDS[1] = TIMEOUTSECONDS[0]; //Reseting TIMOUTSECONDS
					LastStepCounter = StepCounter;
					//Set player color and ship in Both Player's OnlineLevelManager
					string shape = PlayerPrefs.GetString("My_Shape");
					string color = PlayerPrefs.GetString("My_Color");
					//RPC Call to both players, (IsServer Bool, String Shape, String Color)
					netview.RPC ("setPlayer", RPCMode.AllBuffered, new object[] {false, shape, color});
				}

				//Our next 1 step involves calling the server to setup the planets. 
				if(StepCounter == 4 && LastStepCounter != 4) 
				{
					TIMEOUTSECONDS[1] = TIMEOUTSECONDS[0]; //Reseting TIMOUTSECONDS
					LastStepCounter = StepCounter;

					netview.RPC ("SetupPlanet", RPCMode.Server, new object[] {});
				}

				//Our next two steps involve setting up the appereance of both players on their devices.
				if(StepCounter == 5 && LastStepCounter != 5) 
				{
					TIMEOUTSECONDS[1] = TIMEOUTSECONDS[0]; //Reseting TIMOUTSECONDS
					LastStepCounter = StepCounter;


					//Clear Our Seeds.
					GameObject[] seeds = GameObject.FindGameObjectsWithTag("seed");
					foreach(GameObject seed in seeds) 
					{seed.transform.GetChild(0).GetComponent<MeshRenderer>().enabled = false;}
					netview.RPC ("GeneratePlayerShapesUnderPlanetNPC", RPCMode.AllBuffered, new object[] {});
				}

				//We are done.
				if(StepCounter == 7 && LastStepCounter != 7) 
				{
					TIMEOUTSECONDS[1] = TIMEOUTSECONDS[0]; //Reseting TIMOUTSECONDS
					LastStepCounter = StepCounter;

					Debug.Log("Ready To Play!");
					ConnectClient = false;
				}

			}
			else
			{
				//Close Connection.
				Network.Disconnect();

			}

		}
	}



	//CLIENT - SERVER - CLIENT - SERVER - CLIENT - SERVER - CLIENT - SERVER - CLIENT - SERVER - CLIENT - SERVER - CLIENT - SERVER - CLIENT - SERVER - 
	private void OnConnectedToServer() 
	{
		// A Client has just connected
		isClient = true;
		ConnectClient = true;
	
	}

	private void OnServerInitialized() 
	{
		// The server has initialized
		
		//Set player color and ship in Both Player's OnlineLevelManager
		string shape = PlayerPrefs.GetString("My_Shape");
		string color = PlayerPrefs.GetString("My_Color");
		//RPC Call to both players, (IsServer Bool, String Shape, String Color)
		netview.RPC ("setPlayer", RPCMode.AllBuffered, new object[] {true, shape, color});
		
		
	}
	//CLIENT - SERVER - CLIENT - SERVER - CLIENT - SERVER - CLIENT - SERVER - CLIENT - SERVER - CLIENT - SERVER - CLIENT - SERVER - CLIENT - SERVER - 






	//SetupPlanet() --- Takes our OnlinePlanet prefab and replaces our seeds
	[RPC]
	public void SetupPlanet() {
		//Grab our basic planet. We will make this change later when prefabs are concrete.
		GameObject basicPlanetPrefab = Resources.Load("Prefabs/Online/OnlinePlanet") as GameObject;



		//Go through seeds and instantiate whereever a seed is.
		GameObject[] seeds = GameObject.FindGameObjectsWithTag("seed");
		foreach(GameObject seed in seeds) 
		{
			//Create Planet name. Using seed values, seed1, seed2, seed3... remove "seed", and leave the number.

			GameObject tempPlanet = Network.Instantiate(basicPlanetPrefab, seed.transform.position, Quaternion.Euler(new Vector3(75,0,0)), 0) as GameObject;
			//Setting the planet's name on both client and server.
			tempPlanet.GetComponent<NetworkView>().RPC("setName", RPCMode.AllBuffered, new object[] {"Planet"+seed.transform.name.Replace("seed", "")});
			tempPlanet.GetComponent<NetworkView>().RPC ("setTypewithName", RPCMode.All, new object[] {seed.GetComponent<seedInfo>().type, tempPlanet.transform.name});
			//Setting the tempPlanet's type using the value from the seed, and then units. 
			tempPlanet.GetComponent<OnlinePlanet_NPC>().units = seed.GetComponent<seedInfo>().units ;		
		}

		foreach(GameObject seed in seeds) 
		{
			seed.transform.GetChild(0).GetComponent<MeshRenderer>().enabled = false;
		}

		netview.RPC ("increaseStepCounter", RPCMode.AllBuffered, new object[] {});
	}




	//Checks to see if the obejct we submitted is named for diamonds. Diamonds object is too small, and it's size needs to be increase 
	//by 2x. This method is ran as we modify our planet objects in GeneratePlayerShapesUnderPlanetNPC().
	[RPC]
	void ChangeIfDiamond(GameObject _ChildObject) 
	{ 
		if(Network.isServer) 
		{ 
			if(_ChildObject.transform.name == "Diamond")
			{
				//This should double the size.
				_ChildObject.transform.localScale = new Vector3(2f, 2f, 2f);
			}
		}
	}



	//Generate Shapes for under PlanetNPC for both players
	[RPC]
	public void GeneratePlayerShapesUnderPlanetNPC() {
	
			//Grab the inner objects within a 'planet' for 'player1' and 'player2'.
			GameObject[] player1s = GameObject.FindGameObjectsWithTag("InnerObjectPlayer1");
			GameObject[] player2s = GameObject.FindGameObjectsWithTag("InnerObjectPlayer2");	
			//Change Each Object's appearence for both players.
			foreach(GameObject playerObj in player1s) 
			{
			CSM.ModifyPlayerMeshAndMaterial(playerObj, player1Shape, player1Color);
			ChangeIfDiamond(playerObj); 
			}
			//Change Each Object's appearance for both players.
			foreach(GameObject playerObj in player2s) 
			{
			CSM.ModifyPlayerMeshAndMaterial(playerObj, player2Shape, player2Color);
			ChangeIfDiamond(playerObj); 
			}
			//Increase Step for connection.
			netview.RPC ("increaseStepCounter", RPCMode.AllBuffered, new object[] {});
	}



	//setPlayer() -- Sets both players Color, and Shape Strings, then  gets the SHIP objects ready by using ColorShapeManager.
	[RPC] 
	public void setPlayer(bool _isServer, string _shape, string _color) 
	{ 
		//Check to see if we are the server, is so, set the colors and shape for player one. 
		//Set the colors an shape for player2 if not. (Since we are the client.) 
		if(_isServer)
		{
			player1Color = _color;
			player1Shape = _shape;
		}
		else
		{
			player2Color = _color;
			player2Shape = _shape;
		}

		//If Our colors match, we need to remedy that, for each device independently, so both players can use their colors. 
		if(player1Color.ToLower() == player2Color.ToLower()) 
		{
			//Check to see if we are the server(player1).
			//Else we are the client(player2).
			if(Network.isServer)
			{
				//Check to see if 'player1Color'(SERVER) color matches blue, cause if so, we can't make the (player2 || Client) player blue. 
				if(player1Color.ToLower() == "#0000ff")
				{
					//Change player2(Client) color to red. 
					player2Color = "#ff0000";
				}
				else
				{
					//Client color, doesn't match blue. Therefore it can be blue.
					player2Color = "#0000ff";
				}
			}
			else
			{
				//we are the client(player2).
				//Check to see if 'player2Color'(Client) color matches blue, cause if so, we can't make the (player1 || Server) player blue. 
				if(player2Color.ToLower() == "#0000ff")
				{
					//Change player2 color to red. 
					player1Color = "#ff0000";
				}
				else
				{
					//Server color, doesn't match blue. Therefore it can be blue.
					player1Color = "#0000ff";
				}
			}
		}

		//Setting the player's Ship objects.
		if(_isServer)
		{
			player1 = CSM.getPlayerShip(player1Shape, player1Color);
		}
		else
		{
			player2 = CSM.getPlayerShip(player2Shape, player2Color);
		}


		netview.RPC ("increaseStepCounter", RPCMode.AllBuffered, new object[] {});
	}

	[RPC]
	public void increaseStepCounter() {
		StepCounter++;
	}


}
