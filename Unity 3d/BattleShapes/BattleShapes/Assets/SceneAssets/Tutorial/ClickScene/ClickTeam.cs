using UnityEngine;
using UnityEngine.UI; 
using System.Collections;

public class ClickTeam : MonoBehaviour {

	public Text TextAbove;

	public GameObject[] StopObjects;
	public GameObject[] StartObjects;

	// Use this for initialization
	void Start () {
	
	}
	
	// Update is called once per frame
	void Update () {
	

		if(Input.GetButtonDown("Fire1"))
		{
			Vector3 mosPos = Camera.main.ScreenToWorldPoint(Input.mousePosition);
			mosPos.y = 0;

			Collider[] hits = Physics.OverlapSphere(mosPos, 3f);



			
			if(hits.Length > 0) 
			{
				if(hits[0].gameObject.transform.name == "Planet3")
				{
					TextAbove.GetComponent<Text>().text = "Excellent!";

					foreach(GameObject obj in StopObjects)
					{
						obj.SetActive(false);
					}


					foreach(GameObject obj in StartObjects)
					{
						obj.SetActive(true);
					}

				}
			}


		}

	}
}
