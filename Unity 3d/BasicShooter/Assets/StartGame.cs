using UnityEngine;
using System.Collections;
using UnityStandardAssets.Characters.ThirdPerson;



public class StartGame : MonoBehaviour {
    public GameObject Prefab;
    private GameObject newObject;
    private float CurRuntime = 0;
    private float minx = -60;
    private float minz = -12;
    private float maxx = 30;
    private float maxz = 18;
    private int lasttimespawnedsomething = 0;


    // Use this for initialization
    void Start()
    {
        
        




    }

	// Update is called once per frame
	void Update () {
        float RandXVal = Random.RandomRange(minx, maxx);
        float RandZVal = Random.RandomRange(minz, maxz);

        int currentRealTime = (int)Time.realtimeSinceStartup;

        if (currentRealTime % 3 == 0)
        {
            //Check to see if we spawned recently
            if (currentRealTime != lasttimespawnedsomething)
            {
                lasttimespawnedsomething = currentRealTime;
                Instantiate(Prefab, new Vector3(RandXVal, 1, RandZVal), Quaternion.identity);
            }

            
        }

    }
}
