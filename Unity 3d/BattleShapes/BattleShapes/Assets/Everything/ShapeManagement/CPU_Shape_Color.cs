using UnityEngine;
using System.Collections;

public class CPU_Shape_Color : MonoBehaviour {

	public string[] possible_colors = new string[] {"#ff0000", "#ffa500"};


	public void SimpleMPMM(GameObject ObjectToModify, string CPUshape) {
		
		//Get Mesh and Set mesh
		int playerMeshint= GameObject.Find ("MeshList").GetComponent<MeshLister>().getMeshInt(CPUshape);
		ObjectToModify.GetComponent<MeshFilter>().mesh = GameObject.Find("MeshList").GetComponent<MeshLister>().meshlist[playerMeshint];
		//Set Material 
		ObjectToModify.GetComponent<MeshRenderer>().materials[0].color = ColorHelper.hexToColor(possible_colors[0]);
	}



	public GameObject getCPUObject(string _name){

		//Create return obj
		GameObject returnObj = null;

		//Get list of shapes
		object[] ResourceObjs = Resources.LoadAll("Shapes");

		//Find our cube object
		foreach(object gameobj in ResourceObjs)
		{
			GameObject tempobj = (GameObject) gameobj;
			if(tempobj.name.ToString().ToLower() == _name.ToLower())
			{
				returnObj = tempobj;
			}
		}


		Material material = new Material (Shader.Find("Legacy Shaders/Lightmapped/Bumped Specular"));
	

		//Add the color that is not being used by the player. 
		if(PlayerPrefs.GetString("My_Color").ToLower() == possible_colors[0].ToLower()) 
		{
			material.color = hexToColor(possible_colors[1]);
		}
		else
		{
			material.color = hexToColor(possible_colors[0]);
		}

		returnObj.GetComponent<Renderer>().material = material;

		//Return the new GameObject.
		return returnObj;


	}


	public GameObject getCpuAsShape(string _shape) {

			//Create return obj
			GameObject returnObj = null;
			
			//Get list of shapes
			object[] ResourceObjs = Resources.LoadAll("Shapes");
			
			//Find our cube object
			foreach(object gameobj in ResourceObjs)
			{
				
				GameObject tempobj = (GameObject) gameobj;
				//Debug.Log("tempobj"+tempobj.name+"_shape:"+_shape);
				if(tempobj.name.ToString().ToLower() == _shape.ToLower())
					{
						returnObj = tempobj;
					} 
				}
			

			
			Material material = new Material (Shader.Find("Legacy Shaders/Lightmapped/Bumped Specular"));
			//Add the color that is not being used by the player. 
			if(PlayerPrefs.GetString("My_Color").ToLower() == possible_colors[0].ToLower()) 
			{
				material.color = hexToColor(possible_colors[1]);
			}
			else
			{
				material.color = hexToColor(possible_colors[0]);
			}
			
			returnObj.GetComponent<Renderer>().material = material;
			
			//Return the new GameObject.
			return returnObj;
	}






	public static Color hexToColor(string hex)
	{
		hex = hex.Replace ("0x", "");//in case the string is formatted 0xFFFFFF
		hex = hex.Replace ("#", "");//in case the string is formatted #FFFFFF
		byte a = 255;//assume fully visible unless specified in hex
		byte r = byte.Parse(hex.Substring(0,2), System.Globalization.NumberStyles.HexNumber);
		byte g = byte.Parse(hex.Substring(2,2), System.Globalization.NumberStyles.HexNumber);
		byte b = byte.Parse(hex.Substring(4,2), System.Globalization.NumberStyles.HexNumber);
		//Only use alpha if the string has enough characters
		if(hex.Length == 8){
			a = byte.Parse(hex.Substring(4,2), System.Globalization.NumberStyles.HexNumber);
		}
		return new Color32(r,g,b,a);
	}


}
