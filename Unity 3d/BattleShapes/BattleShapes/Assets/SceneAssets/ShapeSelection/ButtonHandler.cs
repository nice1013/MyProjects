using UnityEngine;
using System.Collections;

public class ButtonHandler : MonoBehaviour {

	public GameObject startMenu;
	public GameObject ColorSelectMenu;
	public GameObject ShapeSelectMenu;
	public GameObject MeshList;



	//Front menu Buttons.
	public void OnPickShape() {
		//Pick Shape Button Click.
		startMenu.SetActive(false);
		ShapeSelectMenu.SetActive(true);
	}

	public void OnPickColor() {
		//Pick Color Button Click.
		//Close StartMenu, and Open Color Menu.
		startMenu.SetActive(false);
		ColorSelectMenu.SetActive(true);
	}

	public void OnDoneButton() {
		//Done Button Click. Front Menu
	}
	//Ending Front Menu Buttons.








	//Color Select Menu 
	public void OnSaveColor() {
		//Save button within ColorSelection menu.
		Color color = GameObject.Find("Picker").GetComponent<HSVPicker>().currentColor;
		string hexColor = "#"+ColorHelper.ColorToHex(color);
		PlayerPrefs.SetString("My_Color", hexColor);
	}

	public void OnCancelColor() {
		//Cancel bunnton within ColorSelection menu.
		//Close Color menu, Start, Start Menu.
		ColorSelectMenu.SetActive(false);
		startMenu.SetActive(true);
	}
	//End Color Select Menu Buttons.








	
	//ShapeSelection Menu 
	public void OnSaveShape() {
		//Save Button within Shape Selection Menu.
		GameObject shapeToMinipulate = ShapeSelectMenu.transform.FindChild("Cross").gameObject;
		string meshName = shapeToMinipulate.GetComponent<MeshFilter>().mesh.name;
		meshName = meshName.Replace(" Instance", "");
		Debug.Log("MyMeshName:"+meshName);
		int MeshPosition = MeshList.GetComponent<MeshLister>().getMeshIntUsingMesh(meshName);
		Debug.Log("MeshPosition:"+MeshPosition);
		string ShapeName = MeshList.GetComponent<MeshLister>().getShapeNameWithMeshInt(MeshPosition);
		Debug.Log("MyShapeName:"+ShapeName);
		PlayerPrefs.SetString("My_Shape", ShapeName);

	}

	public void OnDoneShape() {
		//Done Button within Shape Selection Menu.
		ShapeSelectMenu.SetActive(false);
		startMenu.SetActive(true);

	}

	public void OnPrev() {
		//Prev Button within Shape Selection Menu.
		GameObject shapeToMinipulate = ShapeSelectMenu.transform.FindChild("Cross").gameObject;
		string meshName = shapeToMinipulate.GetComponent<MeshFilter>().mesh.name;
		meshName = meshName.Replace(" Instance", "");
		int NextMeshPosition = MeshList.GetComponent<MeshLister>().getCycleMeshIntUsingMeshName(meshName, -1);
		Mesh mesh = MeshList.GetComponent<MeshLister>().getMesh(NextMeshPosition);
		shapeToMinipulate.GetComponent<MeshFilter>().mesh =  mesh;
	}

	public void OnNext() {
		//Next Button within Shape Selection Menu.
		GameObject shapeToMinipulate = ShapeSelectMenu.transform.FindChild("Cross").gameObject;
		string meshName = shapeToMinipulate.GetComponent<MeshFilter>().mesh.name;
		meshName = meshName.Replace(" Instance", "");
		int NextMeshPosition = MeshList.GetComponent<MeshLister>().getCycleMeshIntUsingMeshName(meshName, 1);
		Mesh mesh = MeshList.GetComponent<MeshLister>().getMesh(NextMeshPosition);
		mesh.name = mesh.name.Replace(" Instance", "");
		shapeToMinipulate.GetComponent<MeshFilter>().mesh =  mesh;
	}
	//End Shape Selection Menu Buttons.








}
