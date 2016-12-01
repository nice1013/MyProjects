using UnityEngine;
using System.Collections;

public class LoadingPlugin : MonoBehaviour {

	public Texture dogecoin;
	public Texture loading;
	Rect DogecoinRect, LoadingRect;
	float sendtoRotateGui;
	float angle;
	public bool showloading = false;


	// Use this for initialization
	void Start () {

		//Configure the Loading Images and how it will be displayed.
		LoadingRect = new Rect( PercentWidth(30),  PercentHeight(40), PercentWidth(40), PercentHeight(20));
		DogecoinRect = new Rect( PercentWidth(47),  PercentHeight(45),  PercentHeight(10), PercentHeight(10));
		
		angle = 0;



	
	}


	void OnGUI() {

		if (showloading)
		HandleGuiTextures(); //Handles displaying the images (dogecoin and loa-ing), and rotating Dogecoin. 
		

	}
	


		void HandleGuiTextures() {

		//this.GetComponentInChildren<RotateGui>().rect = DogecoinRect;
		GUI.DrawTexture(LoadingRect, loading);
		
		
		
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
