import java.awt.AWTException;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.MouseInfo;
import java.awt.Point;
import java.awt.PointerInfo;
import java.awt.Rectangle;
import java.awt.Robot;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.attribute.BasicFileAttributes;
import java.util.Arrays;
import java.util.Date;

import javax.imageio.ImageIO;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;


public class look extends Thread{
	
	static JFrame jframe = new JFrame();
	static JPanel jpanel = new JPanel(); 
	
	static Dimension screenSize =  Toolkit.getDefaultToolkit().getScreenSize();
	static double w = screenSize.getWidth();
	static double h = screenSize.getHeight();
	     
	static final int widthOfCapture = 500;
	static final int heightOfCapture =500;
	static int PIXELS = widthOfCapture * heightOfCapture;
	static int mouseWidthandHeight = 10;
	
	static int nw =  (int) (w * 1.25);
    static int nh =  (int) (h * .25);
			
	//static int nw = (int) ((w * .5) - (widthOfCapture * .5));
	//static int nh = (int) ((h * .5) - (heightOfCapture * .5));
	
	static Rectangle rect3 = new Rectangle(nw, nh, widthOfCapture, heightOfCapture);
	static Robot bot = null;
	
	//Directory that stores that last 30 frames taken. 
	static String Last30FramesDir = "Last30Frames/";
	
	//Max amount of frame in Last30FramesDir.
	static int Maxframes = 30;
	
	public void run() {
        Start();
    }
	
	
	
	
	public void Start() {
			
		try {
			bot = new Robot();
			//ShowLook();
			//--OR--
			BlankLook();

			
		} catch (AWTException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		
		
		
		
				
			
	}
	
	
	public static void BlankLook() {
		
		
		
		//Capture an image. 
		BufferedImage image = pullImage();
		//If curser was near by, add it to the image. 
		image = addCursorToImage(image);
		
		//Grab the array of colors. 
		int[][] arrayOfRGB = getRGBArray(image, widthOfCapture, heightOfCapture);
		
		//Put back colors in IMage. 
		image = setRGBArray(image, arrayOfRGB);
		
	    // display time and date using toString()
	    PushToMemory(image);
	    Flush30Frames();
	    
	    
	}
	
	
	
	public static void ShowLook() {
		//Reset Frame and Panel
		jpanel.removeAll();
		jframe.getContentPane().removeAll();
		
		
		//Capture an image. 
		BufferedImage image = pullImage();
		//If curser was near by, add it to the image. 
		image = addCursorToImage(image);
		
		//Grab the array of colors. 
		int[][] arrayOfRGB = getRGBArray(image, widthOfCapture, heightOfCapture);
		
		//Put back colors in IMage. 
		image = setRGBArray(image, arrayOfRGB);
		
		//Add image to jlabel and jpanel. 
		jpanel.add( new JLabel( new ImageIcon(image) ));
		
		//Add the button for close. 
		JButton close = new JButton("Close!");
		close.addActionListener(new CloseHelper());
		jpanel.add(close);
		 
		 
		//Add panel to jframe
		jframe.add(jpanel);
		 
		//Check if frame is visible, arrange its location if it is not. 
		if(jframe.isVisible() == false)
		{
		  //Center
		  //jframe.setLocationRelativeTo(null);
		  jframe.setLocation((int) (w * 1.6), (int) (h * .25) );
		}
		 
		//Set visibility to true, and set it size. 
		jframe.setVisible(true);
		jframe.setSize(600,600);
		 
	    
	    // display time and date using toString()
	    PushToMemory(image);
	    Flush30Frames();
	    
	    
	}
	
	
	public static void Flush30Frames() {
		
		
		
		//Get Dir and list of files.
		File directory = new File(Last30FramesDir);
	    String[] fileList = directory.list();
	    long[] fileListTimes = new long[fileList.length];
	    
	    
	    for(int i = 0; i < fileList.length; i++)
	    {
	    	//System.out.println("Name "+i+" :"+fileList[i]);
	    	fileListTimes[i] = Long.parseLong(fileList[i].replace(".png", ""));
	    	
	    }
		
		Arrays.sort(fileListTimes);
		
		if( fileListTimes.length > Maxframes )
		{
			for(int i = 0; i < fileListTimes.length - Maxframes; i++)
		    {
		    	//System.out.println("File List Times "+i+" :"+fileListTimes[i]);
		    	File fileToDelete = new File(Last30FramesDir+fileListTimes[i]+".png");
		    	fileToDelete.delete();
		    }
			
		}
		
	}
	
	
	public static String[] getFileList(String Last30FramesDir) {
		
		//Get Dir and list of files.
		File directory = new File(Last30FramesDir);
		String[] fileList = directory.list();
		String[] ReturnList = new String[fileList.length];
		long[] fileListTimes = new long[fileList.length];
			   
		
		//Remove png from each item.
	    for(int i = 0; i < fileList.length; i++)
	    {
	    	fileListTimes[i] = Long.parseLong(fileList[i].replace(".png", ""));
	    	
	    }
		
	    //Sort the array by time.
		Arrays.sort(fileListTimes);
		
		
		//Add png to each item. 
	    for(int i = 0; i < ReturnList.length; i++)
	    {
	    	ReturnList[i] = fileListTimes[i]+".png";
	    	
	    }
		
	    return 	ReturnList;
	    
	}
	
	public static void PushToMemory(BufferedImage image) {
		
		// Instantiate a Date object
	    Date date = new Date();
	    long time = date.getTime();
	    // display time and date using toString()
	    String dateS = ""+time;
		saveMemory(image, dateS);
		
		int numOfFiles = new File(Last30FramesDir).listFiles().length;
		
		//System.out.println("File Count ="+numOfFiles);
	}
	
	
	public static BufferedImage setRGBArray(BufferedImage image, int[][] RGBarray)
	{
		
		 //Press Green onto the image
		 for(int i = 0; i < heightOfCapture; i++)
		 {
			 
			 {
				 image.setRGB(0, i, widthOfCapture, 1, RGBarray[i], 0, 0);
			 }
				 
		 }
		 
		 return image;
		 
	}
	
	public static BufferedImage setRGBArrayWithValidate(BufferedImage image, int[][] RGBarray)
	{
		
		 //Press Green onto the image
		 for(int i = 0; i < heightOfCapture; i++)
		 {
			 
			 {
				 
				 image.setRGB(0, i, widthOfCapture, 1, RGBarray[i], 0, 0);
				 
				 
				
			 }
				 
		 }
		 
		 return image;
		 
	}
	
	
	//Returns an array of pixels. int[Width][Height];
	public static int[][] getRGBArray(BufferedImage image, int width, int height)
	{
		
		int[][] pixels = new int[height][width];
		
		for( int i = 0; i < height ; i++ )
		    for( int j = width - 1; j > 0; j--)
		        pixels[i][j] = image.getRGB( j, i );
		
		return pixels;
		
	}
	
	
	//Add a cursur to a standard image. 
	public static BufferedImage addCursorToImage(BufferedImage image)
	{
		//Width and height of mouse. 
		int mouseWidthandHeight = 10;
		
		//Color of mouse.
		Color color = new Color(0,0,0);
		int arrayofrgb = color.getRGB();
		int[] rgbarray = new int[widthOfCapture];
		
		 //Inserting color into an array of colors. 
		 for(int r = 0; r<widthOfCapture; r++)
		 {
			 rgbarray[r] = arrayofrgb;
		 }	
		
		
		//Get Mouse Info
		PointerInfo a = MouseInfo.getPointerInfo();
		Point b = a.getLocation();
	 
		int pointerx = 0;
		int pointery = 0;
		
		
		 //Calculate the current x position of mouse in pixels.
		 if(b.x > nw + mouseWidthandHeight && b.x < nw + widthOfCapture - mouseWidthandHeight)
		 {
			 pointerx = b.x - nw;
			 
			
		 }else {
			 pointerx = 0;
		 }
		 
		//Calculate the current y position of mouse in pixels.
		 if(b.y > nh + mouseWidthandHeight && b.y < nh + heightOfCapture - mouseWidthandHeight)
		 {
			 
			 pointery = b.y - nh;
			 
		 }else 
		 {
			 pointery = 0;
		 }
		
		 
		 
		 
		 //Setting mouse over top image. Starting with the current pixel/position.
		 if( pointery > 0 && pointerx > 0 )
		 {
			 image.setRGB(pointerx, pointery, 10, 10, rgbarray, 0, 0);
		 }
		 
		 
		return image;
	}
	
	
	public static BufferedImage AddBoxToImage(BufferedImage image, int x, int y, int pixWidth, int pixHeight, Color color)
	{
		
		
		//Color of mouse.
		int arrayofrgb = color.getRGB();
		int[] rgbarray = new int[widthOfCapture];
		
		 //Inserting color into an array of colors. 
		 for(int r = 0; r<widthOfCapture; r++)
		 {
			 rgbarray[r] = arrayofrgb;
		 }	
		
		 
		 image.setRGB(x, y, pixWidth, pixHeight, rgbarray, 0, 0);
		 
		 
		 
		return image;
	}
	
	
	//Save image and 
	public static void saveMemory(BufferedImage image, String name) {
		
		
		
		File outputfile = new File(Last30FramesDir+name+".png");
		
		
	    try {
	    	
	    	ImageIO.write(image, "png", outputfile);
	    	
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
	}
	
	
	//Pulls an Image. 
	public static BufferedImage pullImage()
	{
		return bot.createScreenCapture(rect3);
		
	}
	
	
	


	/*
	          * Returns the red component in the range 0-255 in the default sRGB
	          * space.
	          * @return the red component.
	          * @see #getRGB
	*/
	public static int getRed(int thing) {
	  return (thing >> 16) & 0xFF;
	}
	  
	  
	/*
	  * Returns the green component in the range 0-255 in the default sRGB
	  * space.
	  * @return the green component.
	  * @see #getRGB
	*/
	public static int getGreen(int thing) {
	  return (thing >> 8) & 0xFF;
	}
	
	
	/*
	  Returns the blue component in the range 0-255 in the default sRGB
	  space.
	  @return the blue component.
	  @see #getRGB
	*/
	public static int getBlue(int thing) {
		return (thing >> 0) & 0xFF;
	}
	
	
	public static int getIntFromColor(int Red, int Green, int Blue){
	    Red = (Red << 16) & 0x00FF0000; //Shift red 16-bits and mask out other stuff
	    Green = (Green << 8) & 0x0000FF00; //Shift Green 8-bits and mask out other stuff
	    Blue = Blue & 0x000000FF; //Mask out anything not blue.

	    return 0xFF000000 | Red | Green | Blue; //0xFF000000 for 100% Alpha. Bitwise OR everything together.
	}
	
	public static boolean compareColors(int color1, int color2)
	{
		boolean test = true;
		
		
		if(look.getBlue(color1) != look.getBlue(color2))
		{
			test = false;
		}
		
		if(look.getGreen(color1) != look.getGreen(color2))
		{
			test = false;
		}
		
		
		if(look.getRed(color1) != look.getRed(color2))
		{
			test = false;
		}
			
		
		
		return test;
		
	}
	
	public static boolean compareColorList(int[] pixelList1, int[] pixelList2)
	{
		boolean test = true;
		
		//Run through list. 
		for(int i = 0; i < pixelList1.length; i++){
			
			//System.out.println("G:R:B -"+look.getBlue(pixelList1[i])+":"+look.getGreen(pixelList1[i])+":"+look.getRed(pixelList1[i]));
			
			if(look.getBlue(pixelList1[i]) != look.getBlue(pixelList2[i]))
			{
				test = false;
			}
			
			if(look.getGreen(pixelList1[i]) != look.getGreen(pixelList2[i]))
			{
				test = false;
			}
			
			
			if(look.getRed(pixelList1[i]) != look.getRed(pixelList2[i]))
			{
				test = false;
			}
			
			
			
		}
		
		return test;
		
	}
	
	
}

class CloseHelper implements ActionListener {
	
    @Override
    public void actionPerformed(ActionEvent e) {
        System.exit(0);
    }
    
}
