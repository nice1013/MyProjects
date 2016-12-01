using UnityEngine;
using System.Collections;

public class OnlineUnit : MonoBehaviour {

	public Transform target; 
	public Transform Creator;
	float speed = 6f; 
	public Vector3[] path; 
	int targetIndex; 
	
	OnlinePathfinding pathfinding; 
	GameObject gridObject;
	Grid ourgrid;
	
	public string pathName = "test";
	
	void Start() {
		
		if(GetComponent<NetworkView>().isMine) 
		{
			gridObject = GameObject.Find("A*");
			ourgrid = gridObject.GetComponent<Grid>();
			
			
			//PathRequestManager.RequestPath(transform.position, target.position, OnPathFound);
			//Debug.Log("Have Path? " + pathHolder.GetComponent<Paths>().isPath(pathName));
			if(!ourgrid.isPath(pathName))
			{
				ourgrid.CreateGridWithOutName(Creator.name ,target.name);
				pathfinding = GetComponent<OnlinePathfinding>();
				pathfinding.StartFindPath(transform.position, target.position);
			}
			else 
			{
				path = ourgrid.getPath(pathName);
				StopCoroutine("FollowPath");
				StartCoroutine("FollowPath");
			}
		}
	}
	
	public void setUnit(Transform _creator, Transform _target) {
		this.target = _target;
		this.Creator = _creator;
	}
	
	public void OnPathFound(Vector3[] newPath, bool pathSuccessful) {
		if(pathSuccessful) {
			path = newPath;
			StopCoroutine("FollowPath");
			StartCoroutine("FollowPath");
		}
	}
	
	IEnumerator FollowPath() {
		Vector3 currentWaypoint = path[0]; 
		
		if(!ourgrid.isPath(pathName))
		{
			ourgrid.AddNewPath(pathName, path);
		}
		
		while(true) {
			if (transform.position == currentWaypoint) {
				targetIndex++; 
				if (targetIndex >= path.Length) {
					transform.position = target.position;
					yield break;
				}
				currentWaypoint = path[targetIndex];
			}
			
			transform.position = Vector3.MoveTowards(transform.position, currentWaypoint, speed * Time.deltaTime);
			//GetComponent<Rigidbody>().AddForce((currentWaypoint - transform.position).normalized * speed * Time.smoothDeltaTime);
			yield return null;
			
		}
		
	}
	
	
	public void OnDrawGizmos(){ 
		
		if(path != null) {
			for(int i = targetIndex; i < path.Length; i++) {
				Gizmos.color = Color.black; 
				Gizmos.DrawCube(path[i], Vector3.one);
				
				if(i == targetIndex) {
					Gizmos.DrawLine (transform.position, path[i]);
				}
				else {
					
					Gizmos.DrawLine (path[i-1], path[i]);
				}
				
			}
		}
		
	}
}
