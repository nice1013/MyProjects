using UnityEngine;
using System.Collections;

public class MouseRayCast : MonoBehaviour {

	// Use this for initialization
	void Start () {
	
	}
	
	// Update is called once per frame
	void Update () {

		if (Input.GetButtonDown("Fire1")) {

			Ray rayfromcamera = Camera.main.ScreenPointToRay(Input.mousePosition);
			RaycastHit Hit;
 				
			if(Physics.Raycast(rayfromcamera, out Hit))
			{
          
			if (Time.timeScale != 0)
			{
					Debug.Log("We hit"+Hit.transform.name);

		
					//Tags are stored in the High Parent of the object. 
					string hittag = Hit.transform.parent.transform.tag;

					//We use the tag to find what object we hit, and what function to call for it. 
					//If we hit a dogecoin or bitcoin, blow it up and add the points to game
					if(hittag == "Dogecoin" || hittag == "Bitcoin")
					{	
					Hit.transform.parent.GetComponent<BasicMethods>().AddtoStreakandDestroy();
					}
					//If it is the litecoin / Bonus Coin -- Tell Basic method, to BonusandDestroy
					else if(hittag == "Litecoin")
					{ 
					Hit.transform.parent.GetComponent<BasicMethods>().AddBonusandDestroy();
					}
					//If it is the ScamCoin / Bad Coin -- Tell Basic method, to cancel Streak. take point. 
					else if(hittag == "Scamcoin") 
					{
						Hit.transform.parent.GetComponent<BasicMethods>().CommitScamandDestroy();

					}
					//tell the The object we hit, to add one to the streak.
					//-- add the values to the points, and destroy itself. 
			
					//Hit.transform.GetComponentInParent<CoinHal>().coinParticle.SetActive(true); 
			}
			
			}
		
		
		}
	}

	



}
