using UnityEngine;
using System.Collections;

public class MeshLister : MonoBehaviour {

	public Mesh[] meshlist = new Mesh[] {};
	string[] Mesh_Names = new string[] {"Cross3D","Cube","Diamond","Heart3D","HexagonalPrism","HollowCube","Icosphere","Pyramid","Star3D","Torus"};
	string[] Shapes = new string[] {"Cross","Cube","Diamond","Heart3D","Hexagon","HollowCube","Icosphere","Pyramid","Star","Torus"};

	public Mesh getMesh(int _number) 
	{ 
		return meshlist[_number];
	}


	//Given a shape name, this will return the corresponding mesh int. 
	public string getShapeNameWithMeshInt(int _number) {
		return Shapes[_number];
	}

	//Given a shape name, this will return the corresponding mesh name. 
	public string getMeshName(string _name) {
		int counter = 0;
		foreach(string name in Shapes){
			if(name == _name) 
			{ return Mesh_Names[counter]; }
			counter++;
		}
		return null;
	}

	//Given a shape name, this will return the corresponding mesh int. 
	public int getMeshInt(string _name) {
		int counter = 0;
		foreach(string name in Shapes){
			if(name == _name) 
			{ return counter; }
			counter++;
		}
		return 0;
	}

	//Given a Mesh Name, this will output the Mesh int.
	public int getMeshIntUsingMesh(string _meshName) 
	{
		int counter = 0;
		foreach(string name in Mesh_Names){
			if(name.Trim().ToLower() == _meshName.Trim().ToLower()) 
			{ return counter; }
			counter++;
		}
		return 0;
	}


	public int getCycleMeshIntUsingMeshName(string _meshName, int _value)
	{
		int MeshValue = getMeshIntUsingMesh(_meshName);
		int maxValue = Mesh_Names.Length - 1;

		//If we are increasing value by one.
		if(_value == 1) 
		{
			if(MeshValue == maxValue)
			{
				//If max value is already max value. We're going have to reset value. 
				return 0;
			}
			else 
			{
				int val = MeshValue + _value;
				return val;
			}
		}
		else
		//If we are decreasing the value by one.
		if (_value == -1) 
		{
			if(MeshValue == 0)
			{
				//If Mesh Value is at 0, we need to reset it to max.
				return maxValue;
			}
			else
			{
				int val = MeshValue + _value;
				return val; 
			}

		}

		return 0;

	}


	void start() { 

		if(transform.name == "Player1" && Network.isServer) 
		{ 
			//Get Mesh and Set mesh
			int playerMeshint= getMeshInt(PlayerPrefs.GetString("My_Shape"));
			GetComponent<MeshFilter>().mesh = GameObject.Find("MeshList").GetComponent<MeshLister>().meshlist[playerMeshint];
			
			//Create Material. 
			Material material_A = new Material (Shader.Find("Legacy Shaders/Lightmapped/Bumped Specular"));
			material_A.color  = ColorHelper.hexToColor(PlayerPrefs.GetString("My_Color"));
			
			//Set Material 
			GetComponent<MeshRenderer>().material = material_A;
			
		}
		else
		if(transform.name == "Player2" && Network.isClient) 
		{
			//Get Mesh and Set mesh
			int playerMeshint= getMeshInt(PlayerPrefs.GetString("My_Shape"));
			GetComponent<MeshFilter>().mesh = GameObject.Find("MeshList").GetComponent<MeshLister>().meshlist[playerMeshint];
			
			//Create Material. 
			Material material_A = new Material (Shader.Find("Legacy Shaders/Lightmapped/Bumped Specular"));
			material_A.color  = ColorHelper.hexToColor(PlayerPrefs.GetString("My_Color"));
			
			//Set Material 
			GetComponent<MeshRenderer>().material = material_A;
		}

	}
}
