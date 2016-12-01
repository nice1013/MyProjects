
public class brain {

	static Boolean running = true;
	
	public static void main(String args[])
	{
		look lookInstance = new look();
		CompareImages CI = new CompareImages();
		//(new Thread(lookInstance)).start();
		
		//moveMouse MMInstance = new moveMouse(lookInstance.nw, lookInstance.nh, lookInstance.widthOfCapture, lookInstance.heightOfCapture, 10); 
		
		
		
		
		
		while(running)
		{
			
			try { 
			    Thread.sleep(1000);      //1000 milliseconds is one second.    
			    //(new Thread(MMInstance)).start();
			    (new Thread(lookInstance)).start();
			    (new Thread(CI)).start();
			    
			    
			    
			    
			} catch(InterruptedException ex) {
			    Thread.currentThread().interrupt();
			}
			
		}
		/*
		try {
		    Thread.sleep(2000);      //1000 milliseconds is one second.     
		    (new Thread(lookInstance)).start();
		    
		} catch(InterruptedException ex) {
		    Thread.currentThread().interrupt();
		}
		*/
	}
	
	

}
