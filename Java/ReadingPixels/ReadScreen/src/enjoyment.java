import java.util.ArrayList;


public class enjoyment {

	
	public static int mood = 0;
	public static ArrayList<String> actions = new ArrayList<String>();
	
	//Add Value of action. 
	public static void addepoint(int reaction)
	{
		mood += reaction;
		
	}
	
	//Add action to list of actions. 
	public static void addAction(String action)
	{
		
		actions.add(action);
		
	}
	
	
	
	
	
}
