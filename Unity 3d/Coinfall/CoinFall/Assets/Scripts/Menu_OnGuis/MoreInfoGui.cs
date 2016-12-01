using UnityEngine;
using System.Collections;

public class MoreInfoGui : MonoBehaviour {

	public GUISkin MoreInfoGuiSkin;
	public float oneofheight = 0;
	public float oneofwidth = 0;
	public Rect boxCreatedBy;
	public Rect boxspecialthanks;
	public Rect boxMoonQuote;
	public Rect boxSpew;
	public Rect boxDogeAddress;
	public Rect boxBitAddress;

	// Use this for initialization
	void Start () {
		if (Application.platform == RuntimePlatform.Android){
		//Enable the ads.
		//GameObject.Find("AdvertisementManager").GetComponent<AdController>().AdBool = true;
		}
		oneofheight = PercentHeight(1);
		oneofwidth = PercentWidth(1);
	
		boxCreatedBy = new Rect(PercentWidth(15) , PercentHeight(25), PercentWidth(70), PercentHeight(6));
		boxspecialthanks = new Rect(PercentWidth(15) , PercentHeight(31), PercentWidth(70), PercentHeight(30));
		boxMoonQuote = new Rect(PercentWidth(40) , PercentHeight(60), PercentWidth(20), PercentHeight(20));
		boxSpew = new Rect(PercentWidth(15) , PercentHeight(5), PercentWidth(70), PercentHeight(6));
		boxDogeAddress = new Rect(PercentWidth(5) , PercentHeight(11), PercentWidth(90), PercentHeight(6));
		boxBitAddress = new Rect(PercentWidth(5) , PercentHeight(17), PercentWidth(90), PercentHeight(6));


	}
	
	void OnGUI() {



		GUI.skin = MoreInfoGuiSkin;
		
		GUI.Label (boxCreatedBy, "Created By - Ed Evanosich");
		GUI.Label (boxspecialthanks, "Special Thanks to: \n "+
									 " StackOverFlow.com for Countless Help. -- "+"http://www.freesfx.co.uk for the awesome sound Effects.");

		if (GUI.Button (boxMoonQuote, "Go For The Moon!"))
		{
			Application.LoadLevel(1);

		}

		GUI.Label (boxSpew, "Help Buy Beer");

		GUI.contentColor = HexToColor("BA9F32"); //Color of a Dogecoin.
		GUI.TextField (boxDogeAddress, "Dogecoin : 1DsWtLUDhPdC6kVVrBPWDAA5Cd8nkFVoNf");

		GUI.contentColor = HexToColor("F7931A"); //Color of a bitcoin
		GUI.TextField (boxBitAddress, "Bitcoin : DQeNLk464g6szk3zpjDjFpwR2wHxtFsJsr");




	}



	// Update is called once per frame
	void Update () {
	
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
		Debug.Log("Screen Width1 "+ Widthofscreen);
		//get amount of pixals for out percentage. 
		float pixels = (float)( Widthofscreen * percentage * .01f);
		Debug.Log("Screen Width "+pixels);
		
		return pixels;
		
	}


	Color HexToColor(string hex)
	{
		byte r = byte.Parse(hex.Substring(0,2), System.Globalization.NumberStyles.HexNumber);
		byte g = byte.Parse(hex.Substring(2,2), System.Globalization.NumberStyles.HexNumber);
		byte b = byte.Parse(hex.Substring(4,2), System.Globalization.NumberStyles.HexNumber);
		return new Color32(r,g,b, 255);
	}
}
