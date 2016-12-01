using UnityEngine;
using System.Collections;

public class Color_Shape_Manager : MonoBehaviour {

	string[] Shapes = new string[] {"Cross","Cube","Diamond","Heart3D","Hexagon","HollowCube","Icosphere","Pyramid","Star","Torus"};
	string[] Mesh_Names = new string[] {"Cross3d","Cube","Diamond","Heart3D","HexagonalPrism","HollowCube","Icosphere","Pyramid","Star3d","Torus","TriangularPrism"};
	string[] Color_Names = new string[] {	"Black", 	"White", 	"Red", 		"Pink", 	"Blue", 	"Green", 	"Orange", 	"Yellow", 	"Purple", 	"Hot_Pink"};
	string[] Color_Values = new string[] {	"#000000", 	"#ffffff", 	"#ff0000", 	"#ffc0cb", 	"#0000ff", 	"#008080", 	"#ffa500", 	"#ffd700", 	"#660066", 	"#ff00ff"};

	GameObject PlayerObject;

	public string ObjName = "";
	public string ObjColor = "";



	public void setColor(string _color){
		PlayerPrefs.SetString("My_Color", _color);
	}

	public void setShape(string _shape) {
		PlayerPrefs.SetString("My_Shape", _shape);
	}


	
	public string getColor(){
		return PlayerPrefs.GetString("My_Color");
	}
	
	public string getShape() {
		return PlayerPrefs.GetString("My_Shape");
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

	//Offline
	public GameObject getPlayerShape() {

		string color = PlayerPrefs.GetString("My_Color");
		string shape = PlayerPrefs.GetString("My_Shape");

		
		ObjName = shape;
		ObjColor = color;


		//Grabbing our shape name. 
		string ourshape = PlayerPrefs.GetString("My_Shape");
		Debug.Log(" ShapeName:"+ourshape);
		//Load all shapes and find our shape name and set it to a gameobject. 
		Object[] gobjs = Resources.LoadAll("Shapes"); 

		foreach(Object obj in gobjs)
		{
			GameObject tmp = (GameObject) obj;
			//Debug.Log(" tmpName:"+tmp.name);
			if(tmp.name.ToString().ToLower() == ourshape.ToLower())
			{

				Material material = new Material (Shader.Find("Legacy Shaders/Lightmapped/Bumped Specular"));
				material.color  = ColorHelper.hexToColor(PlayerPrefs.GetString("My_Color"));
				tmp.GetComponent<Renderer>().material = material;

				return tmp;
			}

		}


		return null;

	}


	public GameObject getPlayerShape(string _shape, string _color) {

		ObjName = _shape;
		ObjColor = _color;
		
		
		//Grabbing our shape name. 
		string ourshape = PlayerPrefs.GetString("My_Shape");
		Debug.Log(" ShapeName:"+ourshape);
		//Load all shapes and find our shape name and set it to a gameobject. 
		Object[] gobjs = Resources.LoadAll("Shapes"); 
		
		foreach(Object obj in gobjs)
		{
			GameObject tmp = (GameObject) obj;
			//Debug.Log(" tmpName:"+tmp.name);
			if(tmp.name.ToString().ToLower() == ourshape.ToLower())
			{
				
				Material material = new Material (Shader.Find("Legacy Shaders/Lightmapped/Bumped Specular"));
				material.color  = ColorHelper.hexToColor(PlayerPrefs.GetString("My_Color"));
				tmp.GetComponent<Renderer>().material = material;
				
				return tmp;
			}
			
		}
		
		
		return null;
		
	}



	public GameObject getShape(string _name){

		
		Object[] gobjs = Resources.LoadAll("Shapes"); 
		
		foreach(Object obj in gobjs)
		{
			GameObject tmp = (GameObject) obj;
			
			if( tmp.transform.name.ToLower() == _name.ToLower())
			{
				return tmp;
			}
			
		}
		
		return null;
	}


	//Inputs are a GameObject, and Shape, and Color. 
	//The shape and color will be added to the 'ObjectToModify' GameObject, then returned. 
	public void ModifyPlayerMeshAndMaterial(GameObject ObjectToModify, string _shape, string _color) {
		
		//Get Mesh and Set mesh
		int playerMeshint= GameObject.Find ("MeshList").GetComponent<MeshLister>().getMeshInt(_shape);
		ObjectToModify.GetComponent<MeshFilter>().mesh = GameObject.Find("MeshList").GetComponent<MeshLister>().meshlist[playerMeshint];
		//Set Material 
		ObjectToModify.GetComponent<MeshRenderer>().materials[0].color = ColorHelper.hexToColor(_color);
	}
	
	//Inputs are a GameObject, and Shape, and Color. 
	//The shape and color will be added to the 'ObjectToModify' GameObject, then returned. 
	public GameObject MPMM(GameObject ObjectToModify, string _shape, string _color) {
		//Get Mesh and Set mesh
		int playerMeshint= GameObject.Find ("MeshList").GetComponent<MeshLister>().getMeshInt(_shape);
		ObjectToModify.GetComponent<MeshFilter>().mesh = GameObject.Find("MeshList").GetComponent<MeshLister>().meshlist[playerMeshint];
		//Set Material 
		ObjectToModify.GetComponent<MeshRenderer>().materials[0].color = ColorHelper.hexToColor(_color);
		return ObjectToModify;
	}
	
	public void SimpleMPMM(GameObject ObjectToModify) {
		
		//Get Mesh and Set mesh
		int playerMeshint= GameObject.Find ("MeshList").GetComponent<MeshLister>().getMeshInt(getShape());
		ObjectToModify.GetComponent<MeshFilter>().mesh = GameObject.Find("MeshList").GetComponent<MeshLister>().meshlist[playerMeshint];
		//Set Material 
		ObjectToModify.GetComponent<MeshRenderer>().materials[0].color = ColorHelper.hexToColor(getColor());
	}


}
