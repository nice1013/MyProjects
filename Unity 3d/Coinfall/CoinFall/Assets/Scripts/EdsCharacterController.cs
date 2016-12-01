using UnityEngine;
using System.Collections;

public class EdsCharacterController : MonoBehaviour {

	public Transform player; // Drag your player here
	private Vector2 fp; // first finger position
	private Vector2 lp; // last finger position
	
	public string Message = "Nothing Yet";
	
	void Update () {
		
		
		
		
		foreach(Touch touch in Input.touches)
		{
			if (touch.phase == TouchPhase.Began)
			{
				fp = touch.position;
				lp = touch.position;
			}
			if (touch.phase == TouchPhase.Moved )
			{
				lp = touch.position;
			}
			if(touch.phase == TouchPhase.Ended)
			{
				if((fp.x - lp.x) > 80) // left swipe
				{
					Debug.Log("Left Swipe");
					Message = "Left Swipe";
					player.Rotate(0,-90,0);
				}
				else if((fp.x - lp.x) < -80) // right swipe
				{
					Debug.Log("Right Swipe");
					Message = "Right Swipe";
					player.Rotate(0,90,0);
				}
				else if((fp.y - lp.y) < -80 ) // up swipe
				{
					Debug.Log("Up Swipe");
					Message = "Up Swipe";
					// add your jumping code here
				}
				else if((fp.y - lp.y) > 80 ) //Down swipe
				{
					Debug.Log("Down Swipe");
					Message = "Down Swipe";
					
				}
				
				
				
			}
		}
		
		
		Rect Left = new Rect(0, 0, Screen.width/3, Screen.height);
		Rect Right = new Rect(Screen.width/3 * 2, 0, Screen.width/3, Screen.height);
		
		// Any build other then iphone or android
		if ( Input.GetMouseButton(0) && Left.Contains(Input.mousePosition))
		{ 
			Message = "Pew Pew! Left was pressed";
			
		}
		
		if ( Input.GetMouseButton(0) && Right.Contains(Input.mousePosition))
		{ 
			Message = "Pew Pew! Right was pressed";
			
		}
		
		
		
		
	}
	
	
	
	
	void OnGUI() {
		
		Rect debugRect = new Rect(10, 10, 100, 100);
		
		GUI.Label(debugRect, Message);
		
		
		
	}
	
	
	
	
}