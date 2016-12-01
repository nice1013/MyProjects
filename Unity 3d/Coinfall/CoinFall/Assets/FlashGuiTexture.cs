using UnityEngine;
using System.Collections;

public class FlashGuiTexture : MonoBehaviour {
	
	public float delayTime = 1f; 
	public float dtStatic;
	public bool ShowDamageImage = false;
	public Texture DamageImage;
	private Rect DamageRect;
	
	//This script just turns off the light attatched to the object. 
	
	// Use this for initialization
	void Start () {
		
		dtStatic = delayTime;	
		DamageRect = new Rect(0f, 0f, PercentWidth(100), PercentHeight(100));
		
		
	}
	
	
	void OnGUI() {

	
		//If we have new information or this is the first run then the if is true.
		if (ShowDamageImage)
		{
			GUI.DrawTexture(DamageRect, DamageImage);
			//GUI.DrawTexture(DamageRect, DamageImage);
			
			//check to see if we have ran out of time and should turn off the lights, if not than jus ttake time off.
			if (dtStatic <= 0) 
			{
				ShowDamageImage = false;
				
				dtStatic = delayTime;
				
			}else 
			{
				
				dtStatic -= Time.deltaTime;
				
			}
			
			
			
		}

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
