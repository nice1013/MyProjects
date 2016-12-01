using UnityEngine;
using System.Collections;

public class FlipCameraForClient : MonoBehaviour {

	public void OnConnectedToServer() {
		transform.localEulerAngles = new Vector3(90f, 180f, 0f);
	}
}
