using UnityEngine;
[ExecuteInEditMode()]
public class RotateGui : MonoBehaviour {
	
	public Texture2D texture = null;
	public float angle = 0;
	public Vector2 size = new Vector2(128, 128);
	public Vector2 pos ;
	public Rect rect;
	Vector2 pivot;
	
	void Start() {
		UpdateSettings();
		//rect = new Rect(pos.x - size.x * 0.5f, pos.y - size.y * 0.5f, size.x, size.y);
		pos = new Vector2( Screen.width / 2, Screen.height / 2);
		pivot = new Vector2(rect.xMin + rect.width * 0.5f, rect.yMin + rect.height * 0.5f);
	}
	
	void UpdateSettings() {
		//pos = new Vector2(transform.localPosition.x, transform.localPosition.y);
		
		//pivot = new Vector2(rect.xMin + rect.width * 0.5f, rect.yMin + rect.height * 0.5f);
	}
	
	void OnGUI() {

		angle++;		
		//pivot = new Vector2(rect.xMin + rect.width * 0.5f, rect.yMin + rect.height * 0.5f);

		//if (Application.isEditor) { UpdateSettings(); }
		//Matrix4x4 matrixBackup = GUI.matrix;
		//GUIUtility.RotateAroundPivot(angle, pivot);
		GUI.DrawTexture(rect, texture);
		//GUI.matrix = matrixBackup;
	}
}