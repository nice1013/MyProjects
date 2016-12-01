using UnityEngine;
using System.Collections;
using System.Collections.Generic;

public class Grid : MonoBehaviour {

	public bool DisplayGridGizmos;
	public LayerMask unwalkableMask; //The physics layer where you cannot walk. 
	public Vector2 gridWorldSize; //How much area the grid will cover
	public float nodeRadius; //How much space each individual node covers. 
	public float nodeRadiusExtra = 0;
	Node[,] grid; //Two dimensional node array. 

	float nodeDiameter; 
	int gridSizeX, gridSizeY; //Basically, The amount of nodes that fit into the world. 


	List<string> plots = new List<string>();
	List<Vector3[]> paths = new List<Vector3[]>();

	public string ignoreTag = "";

	void Awake() {

		nodeDiameter = nodeRadius * 2; 
		gridSizeX = Mathf.RoundToInt(gridWorldSize.x/nodeDiameter);
		gridSizeY = Mathf.RoundToInt(gridWorldSize.y/nodeDiameter);

		CreateGrid();

	}

	public int MaxSize { 
		get { 
			return gridSizeX * gridSizeY;
		}
	}



	

	void CreateGrid() { 
		grid = new Node[gridSizeX,gridSizeY]; //Instantiated a new Node array. 
		Vector3 worldBottomLeft = transform.position - Vector3.right * gridWorldSize.x/2 - Vector3.forward * gridWorldSize.y/2; 

		for( int x = 0; x < gridSizeX; x++) {
			for( int y = 0; y < gridSizeY; y++) {
				bool walkable = false;
				Vector3 worldPoint = worldBottomLeft + Vector3.right * ( x * nodeDiameter + nodeRadius) + Vector3.forward * (y * nodeDiameter + nodeRadius);
				walkable = !(Physics.CheckSphere(worldPoint, nodeRadius + nodeRadiusExtra, unwalkableMask)); 


				RaycastHit hit = new RaycastHit();

				if(walkable == false) 
				{
					Collider[] colliders = Physics.OverlapSphere(worldPoint, nodeRadius, unwalkableMask);
					
					foreach (Collider c in colliders) {

						if(c.tag.ToString() == ignoreTag)
						{
							walkable = true;
						}

					}

				}

				grid[x,y] = new Node(walkable, worldPoint, x, y);
			}
		}
	}



	public void CreateGridWithOutName(string _name, string _destName) { 
		grid = new Node[gridSizeX,gridSizeY]; //Instantiated a new Node array. 
		Vector3 worldBottomLeft = transform.position - Vector3.right * gridWorldSize.x/2 - Vector3.forward * gridWorldSize.y/2; 
		
		for( int x = 0; x < gridSizeX; x++) {
			for( int y = 0; y < gridSizeY; y++) {
				bool walkable = false;
				Vector3 worldPoint = worldBottomLeft + Vector3.right * ( x * nodeDiameter + nodeRadius) + Vector3.forward * (y * nodeDiameter + nodeRadius);
				walkable = !(Physics.CheckSphere(worldPoint, nodeRadius, unwalkableMask)); 
				
				
				RaycastHit hit = new RaycastHit();
				
				if(walkable == false) 
				{
					Collider[] colliders = Physics.OverlapSphere(worldPoint, nodeRadius, unwalkableMask);
					
					foreach (Collider c in colliders) {
						
						if(c.name.ToString() == _name || c.name.ToString() == _destName)
						{
							walkable = true;
						}
						
					}
					
				}
				
				grid[x,y] = new Node(walkable, worldPoint, x, y);
			}
		}
	}

	public List<Node> getNeighbours(Node node) { 
		List<Node> neighbours = new List<Node>();

		for (int x = -1; x <=1; x++) {
			for ( int y = -1; y <= 1; y++) {
				if ( x == 0 && y ==0)
					continue;

				int checkX = node.gridX + x; 
				int checkY = node.gridY + y; 

				if(checkX >= 0 && checkX < gridSizeX && checkY >= 0 && checkY < gridSizeY) {
					neighbours.Add(grid[checkX, checkY]);
				}
			}
		}

		return neighbours; 
	}


	//Convert world position to grid position. (Check where player/object is on grid
	public Node NodeFromWorldPoint(Vector3 worldPosition) {
		float percentX = (worldPosition.x + gridWorldSize.x/2) / gridWorldSize.x;
		float percentY = (worldPosition.z + gridWorldSize.y/2) / gridWorldSize.y;
		percentX = Mathf.Clamp01(percentX);
		percentY = Mathf.Clamp01(percentY);

		int x = Mathf.RoundToInt((gridSizeX - 1) * percentX);
		int y = Mathf.RoundToInt((gridSizeY - 1) * percentY);
		return grid[x,y];
	}




	//Path Functions
	public bool isPath(string name) {
		return plots.Contains(name);
	}
	
	public void AddNewPath(string _name, Vector3[] _position) {
		
		plots.Add(_name);
		paths.Add(_position);
		
	}
	
	public Vector3[] getPath(string _name) {
		int el = 0;
		
		for(int i = 0; i < plots.Count; i++)
		{
			if(plots[i].ToString().ToLower() == _name.ToLower())
			{
				el = i;
			}
		}
		
		if(plots.Contains(_name))
			return paths[el];
		else 
			return null;
	}









	void OnDrawGizmos()  { 
		Gizmos.DrawWireCube(transform.position, new Vector3(gridWorldSize.x, 1, gridWorldSize.y));
		if(grid != null && DisplayGridGizmos) { 
			foreach(Node n in grid) {
				Gizmos.color = (n.walkable)?Color.white:Color.red;
				Gizmos.DrawCube(n.worldPosition, Vector3.one * (nodeDiameter - .1f));
			}

		}

	}

}
