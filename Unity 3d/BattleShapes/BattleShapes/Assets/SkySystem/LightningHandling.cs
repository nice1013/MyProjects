using UnityEngine;
using System.Collections;

public class LightningHandling : MonoBehaviour {

	public int MaxEmit = 45; 
	public int MinEmit = 1; 

	public float ChangeOfLargeLightning = 80f;

	public float[] MinMaxInterval = {0f, 5f};
	float runningtime = 0;

	public void emitLightning() 
	{
		float RndomValue = UnityEngine.Random.Range(0f, 100f); 


		if(RndomValue > ChangeOfLargeLightning) 
		{ 
			transform.GetChild(0).GetComponent<Light>().intensity = 7f;
			//Large Lightning Emit
			GetComponent<ParticleSystem>().Emit(MaxEmit);

		}
		else
		{
			transform.GetChild(0).GetComponent<Light>().intensity = 4f;
			GetComponent<ParticleSystem>().Emit(MinEmit);
		}
	}

	// Update is called once per frame
	void Update () {
		if(runningtime <= 0) 
		{ 
			float RndomValue = UnityEngine.Random.Range(MinMaxInterval[0], MinMaxInterval[1]); 
			runningtime = RndomValue;
			emitLightning();
		}
		else
		{
			runningtime -= Time.deltaTime;
		}
	}
}
