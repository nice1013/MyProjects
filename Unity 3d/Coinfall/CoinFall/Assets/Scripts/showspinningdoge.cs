using UnityEngine;
using System.Collections;

public class showspinningdoge : MonoBehaviour {

	public Texture dogecoin;
	Rect DogecoinRect;
	float sendtoRotateGui;
	float angle;
	public bool showloading = false;


	// Use this for initialization
	void Start () {

		//Configure the Loading Images and how it will be displayed.
		DogecoinRect = new Rect( PercentWidth(40),  PercentHeight(40),  PercentHeight(20), PercentHeight(20));
		
		angle = 0;



	
	}


	void OnGUI() {

		if (showloading)
		HandleGuiTextures(); //Handles displaying the images (dogecoin and loa-ing), and rotating Dogecoin. 
		

	}
	


		void HandleGuiTextures() {

		
		
		
		angle++;
		
		
		Vector2 pivot = new Vector2(DogecoinRect.xMin + DogecoinRect.width * 0.5f, DogecoinRect.yMin + DogecoinRect.height * 0.5f);
		Matrix4x4 matrixBackup = GUI.matrix;
		GUIUtility.RotateAroundPivot(angle, pivot);
		GUI.DrawTexture(DogecoinRect, dogecoin);
		GUI.matrix = matrixBackup;
	
		}


		
		float PercentHeight(int percentage)
		{
			
			//get amount of pixals in height.
			int Heightofscreen = Screen.height;
			//get amount of pixals for out percentage. 
			float pixels = (float)(Heightofscreen * percentage * .01f);
			
			return pixels;
			
		}
		
		float PercentWidth(int percentage)
		{
			
			//get amount of pixals in height.
			int Widthofscreen = Screen.width;
			//Debug.Log("Screen Width1 "+ Widthofscreen);
			//get amount of pixals for out percentage. 
			float pixels = (float)( Widthofscreen * percentage * .01f);
			//Debug.Log("Screen Width "+pixels);
			
			return pixels;
			
		}
		
}
