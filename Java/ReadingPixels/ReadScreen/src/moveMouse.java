import java.awt.AWTException;
import java.awt.Robot;
import java.util.Random;


public class moveMouse extends Thread{

	
	Robot bot = null;
	
	static int mouseMinWidth = 0;
	static int mouseMaxWidth = 0;
	
	static int mouseMaxHeight = 0; 
	static int mouseMinHeight = 0;
	
	static int MaxPixelSpeed = 10;
	
	public moveMouse(int startWidth, int startHeight, int CaptureWidth, int CaptureHeight, int Padding)
	{
		//Setting min and max widths and heights for mouse positions. 
		mouseMinWidth = startWidth + Padding; 
		mouseMaxWidth = startWidth + CaptureWidth - Padding;
		
		mouseMinHeight = startHeight + Padding; 
		mouseMaxHeight = startHeight + CaptureHeight - Padding; 
		
		
	}
	
	
	public void run() {
		
		start();
		
	}
	
	public void start() {
		
	  
	    	try {
				bot = new Robot();
			} catch (AWTException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
	    
	   
	    	RandomMouse();
	    
		
	}
	
	
	
	
	public void RandomMouse() {
		
		Random rand = new Random();

	    // nextInt is normally exclusive of the top value,
	    // so add 1 to make it inclusive
	    int RandomWidth = rand.nextInt((mouseMaxWidth - mouseMinWidth) + 1) + mouseMinWidth;
	    int RandomHeight = rand.nextInt((mouseMaxHeight - mouseMinHeight) + 1) + mouseMinHeight;

	   
		
		bot.mouseMove(RandomWidth, RandomHeight);
		
	}
	
	
	
	
	
	
}
