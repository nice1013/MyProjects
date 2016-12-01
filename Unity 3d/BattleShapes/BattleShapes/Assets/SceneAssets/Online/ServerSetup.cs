using UnityEngine;
using System.Collections;

public class ServerSetup : MonoBehaviour {


	public string connectionIP 			= "127.0.0.1";
	int portNumber = 8888; 

	public static bool connected {get; private set;}

	public static bool TriedForServer = false;

	private void OnConnectedToServer() 
	{
		// A Client has just connected
		connected = true;
	}


	private void OnServerInitialized() 
	{
		// The server has initialized
		connected = true;
	}


	private void OnDisconnectedFromServer() 
	{
		//The Connections has been lost or disconnected
		connected = false;
	}



	private void OnGUI() 
	{
		if (!connected)
		{
			
			connectionIP 		= GUILayout.TextField(connectionIP); 
			int.TryParse( GUILayout.TextField(portNumber.ToString()), out portNumber) ;
			
			if (GUILayout.Button("Connect"))
				Network.Connect(connectionIP, portNumber); 
			
			if (GUILayout.Button("Host"))
				Network.InitializeServer(32, portNumber, true);
			
		}

		if(connected)
		{
			string who = ""; 
			if(Network.isClient)
			{ who = "client"; }
			else 
			{ who = "server"; }

			GUILayout.Label("Connections: "+ Network.connections.Length.ToString() + "     Who : "+ who ); 
		}
			


		
			


	}

	public bool getConnected() {
		return connected;
	}
}
