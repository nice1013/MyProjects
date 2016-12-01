using UnityEngine;
using System.Collections;
using System.Collections.Generic;//This is added so we can use the lisT Constructor

public class BitcoinAdvantages : MonoBehaviour {

	
	 public List<string> Btcads = new List<string>();
	 public string BTCfact;
	 private int tenseconds = 10;
	 private float timeleft;
	

	// Use this for initialization
	void Start () {
		
		timeleft = 10;

		
		Btcads.Add("People can create new Dogecoins and Bitcoins by mining.");
		Btcads.Add("Bitcoin and Dogecoin are two Different Types of Digital Money.");
		Btcads.Add("An advid Dogecoin User, is sometimes called a Shibe. ('pronounced Sheeb'). ");
		Btcads.Add("Visit Reddit.com/R/dogecoin to meet more Shibes.");
		Btcads.Add("You can send and recieve Bitcoin, anywhere in the world, at any given time.");
		Btcads.Add("You can send and recieve Dogecoin, anywhere in the world, at any given time.");
		Btcads.Add("Bitcoin and Dogecoin are Decentralized, and are not Controlled by Banks.");
		Btcads.Add("Bitcoin uses a Public Ledger to protect against Counterfeiting.");
		Btcads.Add("Dogecoin uses a Public Ledger to protect against Counterfeiting.");
		Btcads.Add("Bitcoin Users can check the status of their transaction on the Bitcoin BlockChain.");
		Btcads.Add("Dogecoin Users can check the status of their transaction on the Dogecoin BlockChain.");
		Btcads.Add("Crypto-Currencies, Digital Currencies, and Digital Money, are terms used to describe Bitcoin, Dogecoin, and Litecoin.");
		Btcads.Add("'BTC' and 'DOGE' are the Market Symbols for Bitcoin and Dogecoin.");
		Btcads.Add("Bitcoin and Dogecoin, Dont require fees to transfer money.");
		Btcads.Add("With Dogecoin, Transactions Are Quick. The average time is 1 Minute.");
		Btcads.Add("With Bitcoin, Transactions Are Quick. The average time is 10 Minutes.");

		int randnum = Random.Range(0, Btcads.Count); //this will generate a random selection.
	
		BTCfact = Btcads[randnum];
		
		
	}
	

	// Update is called once per frame
	void Update () {
		

		if ( timeleft <= 0)
		{

		int randnum = Random.Range(0, Btcads.Count);
		BTCfact = Btcads[randnum];
		timeleft = tenseconds;
		}

		else

		{

		timeleft -= Time.deltaTime;
		}

	
	}
}
