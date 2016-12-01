using UnityEngine;
using UnityEngine.UI;
using System.Collections;
using System.Linq;

public class LevelSelectGenerator : MonoBehaviour {


	//Grid Details
	public float NextWidth = .5f; 
	public float NextHeight = .5f; 

	public int perRow = 3; //Objects per row


	public int RepeatObjects = 3; //How many times we will repeat object.

	public GameObject[] ResourceObjs = null;
	public Mesh HiddenMesh;



	// Use this for initialization
	void Awake() {
		GameObject holder = new GameObject();

		holder.AddComponent<ScrollScript>();
		//Get list of shapes
		ResourceObjs = Resources.LoadAll("Levels", typeof(GameObject)).Cast<GameObject>().ToArray();
		//GameObject[] ResourceObjs = (GameObject[])Resources.LoadAll("Shapes", typeof(GameObject));

		//System.Array.Reverse(ResourceObjs);

		int i = 0;
		int heightNum = 0;
		int curLevel = 0;

		foreach(GameObject gameobj in ResourceObjs)
		{

			//Debug.Log("Object Name: "+gameobj.name);

			//Repeat item. 
			for(int p = 0; p < RepeatObjects; p++)
			{

				i++;

				//If i equals 1 we are in a new row. Increase the heightNum
				if(i == 1) 
				{
					heightNum++;
				}

				//if the current level isn't available break. 
				if(getLevelValue(curLevel) == 0) 
				{
					//break;
				}







				//Where object will spawn
				float x = i * NextWidth;
				float y = heightNum * NextHeight * -1;
				float z = 0;


				//Setting the rotation for objects and the torus object
				Quaternion rotation = Quaternion.identity;
				if(gameobj.name.ToLower() == "Torus".ToLower())
				{
					rotation = Quaternion.Euler(new Vector3(90, 0, 0));
					
				}
			


				//instantiate object.
				GameObject tempobj = (GameObject) Instantiate(gameobj, Vector3.zero, rotation);
				//Push object underparent.
				tempobj.name = tempobj.name.Replace("(Clone)", "") + ".Level"+(curLevel+1) ;
				tempobj.transform.parent = holder.transform;
				//Set object position under partent.
				tempobj.transform.position = new Vector3(x, y, z);


				//Add rotation.
				tempobj.AddComponent<RandomRotate>(); 
				if(gameobj.name.ToLower() == "Torus".ToLower())
				{
					tempobj.GetComponent<RandomRotate>().UseZ = true; 
				}
				else
				{
					tempobj.GetComponent<RandomRotate>().UseY = true; 
				}



				//Adjust Tag for selection purposes.
				tempobj.tag = "LevelSelection";



				//Create a material. 

				Material material = new Material (Shader.Find("Standard"));
				material.SetFloat("_Metallic", 1f);
				material.SetFloat("Smoothness", 1f);
				//Get and assign material. 
				//if the current level isn't available break. 
				if(getLevelValue(curLevel) == 0) 
				{
					//break;
					material.color = SetLevelColor(curLevel);
					tempobj.GetComponent<MeshFilter>().mesh = HiddenMesh;
					tempobj.GetComponent<Renderer>().material = material;

					foreach( Transform child in tempobj.transform )
					{
						child.gameObject.SetActive(false);
					} 
				}
				else
				{
				material.color = SetLevelColor(curLevel);
				tempobj.GetComponent<Renderer>().material = material;
				
				//Add Object Collision 
				tempobj.AddComponent<SphereCollider>();
				

				Text text = tempobj.transform.GetChild(0).GetChild(0).GetChild(0).GetComponent<Text>();
				text.fontSize = 4;
				text.text = ""+ (curLevel + 1);


				}








				//If greater than perRow, we need to reset to start a new row. 
				if(i == perRow) {
					i = 0;
				}
				curLevel++;
			}
		}


		//holder.transform.position = new Vector3((float)(perRow * .5 * NextWidth * -1 - 1), (float)(heightNum * .5 * NextHeight), 0);
		holder.transform.position = new Vector3((float)(perRow * .5 * NextWidth * -1 - (NextWidth / 2)), 13f, 0);


	}
	
	// Update is called once per frame
	void Update () {
	
	}






	// Use this for initialization
	public static int getLevelValue(int _level) {
		int[] levelProgress = PlayerPrefsX.GetIntArray("LevelProgress");
		return levelProgress[_level];
	}


	// Use this for initialization
	public static Color SetLevelColor(int _level) {




		Color hidden = ColorHelper.hexToColor("#111111");//0 - Hidden
		Color canPlay = ColorHelper.hexToColor("#00ff00");//1 - Can Play
		Color Won1 = ColorHelper.hexToColor("#5f3b17");//2 - Play and Won -- Level 1
		Color Won2 = ColorHelper.hexToColor("#A8A8A8");//3 - Play and Won -- Level 2 
		Color Won3 = ColorHelper.hexToColor("#FFDF00");//4 - Play and Won -- Level 3
		
		
		Color[] colorsList = new Color[] {hidden, canPlay, Won1, Won2, Won3};
		
		int[] levelProgress = PlayerPrefsX.GetIntArray("LevelProgress");
		
		return colorsList[levelProgress[_level]];
	}





}
