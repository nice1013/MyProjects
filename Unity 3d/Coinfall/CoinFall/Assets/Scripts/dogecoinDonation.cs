using UnityEngine;
using System.Collections;

public class dogecoinDonation : MonoBehaviour {

	//test URL 
	//https://www.dogeapi.com/checkout?payment_address=DMLDjPLV4qM2GryzBKSu7T8ChU6VinZhsw&amount_doge=500&widget_type=donation

	//URL Parameters
	public string paymentAddress = "DMLDjPLV4qM2GryzBKSu7T8ChU6VinZhsw";
	public int donationAmount = 500;
	private string URLBase = "https://www.dogeapi.com/checkout?";
	private string URLAddress = "payment_address=";
	private string URLAmount = "&amount_doge=";
	private string URLType = "&widget_type=donation";

	//DogeCoinPlacement
	public Placement _placement;
	public enum Placement{None, UpperLeft, UpperRight, LowerLeft, LowerRight};

	//GUITextures
	public Texture2D dogeCoin;

	// Use this for initialization
	void Start () {
	
	}
	
	private void sendDoge () {

		Application.OpenURL(URLBase+URLAddress+paymentAddress+URLAmount+donationAmount+URLType);
	}

	public static void donateDogeCoin (int amount, string key)
	{
		string _URLBase = "https://www.dogeapi.com/checkout?";
		string _URLAddress = "payment_address=";
		string _URLAmount = "&amount_doge=";
		string _URLType = "&widget_type=donation";

		Application.OpenURL(_URLBase+_URLAddress+key+_URLAmount+amount+_URLType);
	}

	void OnGUI () {

		switch(_placement)
		{
			case Placement.LowerLeft:
			{
				GUILayout.BeginArea(new Rect(0, Screen.height-50, 50, 50));
					if(GUILayout.Button(dogeCoin, GUILayout.Height(50), GUILayout.Width(50)))
					{
						sendDoge();
					}
				GUILayout.EndArea();
			}
			break;
			case Placement.LowerRight:
			{
				GUILayout.BeginArea(new Rect(Screen.width-50, Screen.height-50, 50, 50));
					if(GUILayout.Button(dogeCoin, GUILayout.Height(50), GUILayout.Width(50)))
					{
						sendDoge();
					}
				GUILayout.EndArea();
			}
			break;
			case Placement.UpperLeft:
			{
				GUILayout.BeginArea(new Rect(0, 0, 50, 50));
					if(GUILayout.Button(dogeCoin, GUILayout.Height(50), GUILayout.Width(50)))
					{
						sendDoge();
					}
				GUILayout.EndArea();
			}
			break;
			case Placement.UpperRight:
			{
				GUILayout.BeginArea(new Rect(Screen.width-50, 0, 50, 50));
					if(GUILayout.Button(dogeCoin, GUILayout.Height(50), GUILayout.Width(50)))
					{
						sendDoge();
					}
				GUILayout.EndArea();
			}
			break;
			case Placement.None:
			{
				
			}
			break;
		}
	}
}
