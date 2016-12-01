import java.awt.BorderLayout;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.FlowLayout;
import java.awt.Image;
import java.awt.Rectangle;
import java.awt.Robot;
import java.awt.Toolkit;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;
import java.util.Arrays;

import javax.imageio.ImageIO;
import javax.swing.BoxLayout;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;


public class CompareImages extends Thread {

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
		
		
		//Reset Frame and Panel
				jpanel.removeAll();
				jframe.getContentPane().removeAll();

				String[] files = look.getFileList(Last30FramesDir);
				
				BufferedImage image = null; 
				BufferedImage image2 = null; 
				
				try {
					image = ImageIO.read(new File(Last30FramesDir+files[files.length - 1]));
					image2 = ImageIO.read(new File(Last30FramesDir+files[files.length - 2]));
				}
				catch (IOException e) {
					
					
				}
				
				
				
				
				
				//Grab fib data from images. 
				int[][] image1Data = look.getRGBArray(image, widthOfCapture, heightOfCapture);
				int[] fibImage1Data = getPixelvalues(image1Data);
				image1Data = analyzeImage.applyAllMaps(image1Data);
				
				
				int[][] image2Data = look.getRGBArray(image2, widthOfCapture, heightOfCapture);
				int[] fibImage2Data = getPixelvalues(image2Data);
				image2Data = analyzeImage.applyAllMaps(image2Data);
				
				
				image = look.setRGBArray(image, image1Data);
				image2 = look.setRGBArray(image2, image2Data);
				
				if(isViewPerfectMatch(fibImage2Data, fibImage1Data))
				{
					//Straight match. ---Green
					look.AddBoxToImage(image2, 10, 10, 20, 10, new Color(0,255,0));
					
				}
				else 
				{
					//Straight match. --Red
					look.AddBoxToImage(image2, 10, 10, 20, 10, new Color(255,0,0));
					
				}
				
				
				double[] matchpercentage = PercentageMatch(fibImage2Data, fibImage1Data);
				//System.out.println("Floa2t : "+matchpercentage);
					//Straight match.
				
				if( matchpercentage[0] <= .90)
				{
					int green = (int) (255 * (matchpercentage[0] * .25));
					int red = (int) (255 * matchpercentage[0]);
					look.AddBoxToImage(image2, 50, 10, 20, 10, new Color(red ,green,0));
					
				}
				else 
				if( matchpercentage[0] > .90)
				{
					int green = (int) (255 * (matchpercentage[0]));
					int red = (int) (255 - (255 * matchpercentage[0]));
					look.AddBoxToImage(image2, 50, 10, 20, 10, new Color(red ,green,0));
					
				}
				
				
				
				//Add image to jlabel and jpanel. 
				jpanel.add( new JLabel( new ImageIcon(image) ));
				jpanel.add( new JLabel( new ImageIcon(image2) ));
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
					jframe.setLocation( 0 , 0 );
					jframe.setExtendedState(JFrame.MAXIMIZED_BOTH);
					jframe.setSize(1200,600);
				 // jframe.setLocation((int) (w * 1.6), (int) (h * .25) );
				}
				 
				//Set visibility to true, and set it size. 
				jframe.setVisible(true);
				
				
				
		
		
		
		
	}
	
	
	public static void main(String args[]) {
	
		//Reset Frame and Panel
		jpanel.removeAll();
		jframe.getContentPane().removeAll();

		String[] files = look.getFileList(Last30FramesDir);
		
		/*
		for(int i = 0; i < files.length; i++){
			
			//System.out.println("File Name "+i+":"+files[i]);
		}
		*/
		
		
		//Get Images
		BufferedImage image = null; 
		BufferedImage image2 = null; 
		
		try {
			image = ImageIO.read(new File(Last30FramesDir+files[14]));
			image2 = ImageIO.read(new File(Last30FramesDir+files[ 14])); //was 25
		}
		catch (IOException e) {
			
			
		}
		
		
		
		
		//Grab fib data from images. 
		//Rgb Array == [W][H];
		int[][] image1Data = look.getRGBArray(image, widthOfCapture, heightOfCapture);
		//Array as wide as image1data with spaces for each color. 
		int sizeofimage = image1Data.length;
		
		//Get the sum of all pixels by each row, and column.
		int[][] firstRowValues1 = getTotalColorFromEdge("w", image1Data);
		int[][] firstColoumnValues1 = getTotalColorFromEdge("h", image1Data);
		
		
		
		//Custom Image for our arrays. -- To be used later.
		int[][] CustomImage = new int[sizeofimage][image1Data[0].length];
		
		
		//Convert Raw values to an average value.
		firstRowValues1 = getAverageColorFromEdge(firstRowValues1, sizeofimage);
		firstColoumnValues1 = getAverageColorFromEdge(firstColoumnValues1, sizeofimage);
		
		
		
		
		
		int[] firstRowInts = new int[firstRowValues1.length + firstColoumnValues1.length];
		
		CustomImage = getImagefromACFE(firstRowValues1, firstColoumnValues1, image1Data);
		
		
		

		
		//Rgb Array == [W][H];
		int[][] image2Data = look.getRGBArray(image2, widthOfCapture, heightOfCapture);
		
		
		
		
		
		//image1Data = analyzeImage.applyAllMaps(image1Data);
		//image2Data = analyzeImage.applyAllMaps(image2Data);
		
		//Get data in applyAllMaps. Positions of widths and Heights, where data may have been altered. 
		int[][] listofpixelPositions = analyzeImage.getPixelList(analyzeImage.w, analyzeImage.h);
		
		
		int jump = listofpixelPositions[1][0] - listofpixelPositions[0][0];
		
		
		
		
		
		
		
		image = look.setRGBArray(image, CustomImage);
		image2 = look.setRGBArray(image2, image2Data);
		
		
		
		int matchesEven = 0;
		int matchesOdd = 0;
		
		
		
		
		
		
		int[] fibImage1Data = getPixelvalues(image1Data);
		int[] fibImage2Data = getPixelvalues(image2Data);
		
		if(isViewPerfectMatch(fibImage2Data, fibImage1Data))
		{
			look.AddBoxToImage(image2, 10, 10, 20, 10, new Color(0,255,0));
			
		}
		else 
		{
			look.AddBoxToImage(image2, 10, 10, 20, 10, new Color(255,0,0));
			
			
		}
		
		
		//int[] data = image.getRGB(0, 0, look.widthOfCapture, look.heightOfCapture, null, 0, 0);
		double[] matchpercentage = PercentageMatch(fibImage1Data, fibImage2Data);
		//System.out.println("Floa2t : "+matchpercentage);
		//Straight match.
		
		System.out.println("EvenPasses :"+matchpercentage[0]+"  OddPasses :"+matchpercentage[1]);
		
		
		if( matchpercentage[0] <= .90)
		{
			int green = (int) (255 * (matchpercentage[0] * .25));
			int red = (int) (255 * matchpercentage[0]);
			look.AddBoxToImage(image2, 50, 10, 20, 10, new Color(red ,green,0));
			
		}
		else 
		if( matchpercentage[0] > .90)
		{
			int green = (int) (255 * (matchpercentage[0]));
			int red = (int) (255 - (255 * matchpercentage[0]));
			look.AddBoxToImage(image2, 50, 10, 20, 10, new Color(red ,green,0));
			
		}
		
		JPanel anotherpanel = new JPanel();
		anotherpanel.setLayout(new BorderLayout() );
		
		
		jpanel.setLayout( new FlowLayout());
		
		//Add image to jlabel and jpanel. 
		jpanel.add( new JLabel( new ImageIcon(image) ));
		jpanel.add( new JLabel( new ImageIcon(image2) ));
		//Add the button for close. 
		JButton close = new JButton("Close!");
		
		close.addActionListener(new CloseHelper());
		anotherpanel.add(close);
		 
		//jpanel.setLayout(new BoxLayout(jpanel, BoxLayout.Y_AXIS));
		//Add panel to jframe
		jframe.add(jpanel, "North");
		jframe.add(anotherpanel, "South");
		
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
		jframe.setExtendedState(JFrame.MAXIMIZED_BOTH);
		
		
	}

	//Returns a rgb array[widths][heights]
	//Inputs are two Arrays from getAverageColorFromEdge();
	public static int[][] getImagefromACFE(int[][] WidthArray1, int[][] HeightArray2, int[][] image)
	{
				int[][] CustomImage = new int[WidthArray1.length][HeightArray2.length];
				int red = 0;
				int green = 0;
				int blue = 0;
				
				//Run Widths, for heights. Get green value. 
				for(int widths = 0; widths < image.length; widths++)
				{
					
					
					//Run Widths, for heights. Get green value. 
					for(int heights = 0; heights < image.length; heights++)
					{
						
						
						
						if(WidthArray1[widths][0] > HeightArray2[heights][0])
							red = WidthArray1[widths][0];
						else
							red =	HeightArray2[heights][0];
							
						
						if( WidthArray1[widths][1] > HeightArray2[heights][1])
							green = WidthArray1[widths][1];
						else
							green =	HeightArray2[heights][1];	
						
						
						if( WidthArray1[widths][2] > HeightArray2[heights][2])
							blue = WidthArray1[widths][2];
						else
							blue =	HeightArray2[heights][2];	
						
						
						
						/*
						 * Start by gathering the common colors. 
						 * 
						 * 
						 * 
						 * 
						 */
						
						
						
						/* Original
						int red = (WidthArray1[widths][0] + HeightArray2[heights][0]) / 2;
						int green = (WidthArray1[widths][1] + HeightArray2[heights][1]) / 2;
						int blue = (WidthArray1[widths][2] + HeightArray2[heights][2]) / 2;
						*/
						CustomImage[widths][heights] = look.getIntFromColor(red, green, blue );
						
				
					}

				}	
		
				return CustomImage;
	}
	
	
	//Returns the average array of colors [Element][Color-1=red, 2=green, 3=blue]
	//Inputs are an array from getTotalColorFromEdge(), and the size of the image.
	public static int[][] getAverageColorFromEdge(int[][] TotalColorValue, int sizeofimage)
	{
		
		//Run through each object and divide it by its image size. 
		for(int i = 0; i < TotalColorValue.length; i++)
		{
			TotalColorValue[i][0] = (int) ((double) TotalColorValue[i][0] / (double) sizeofimage);
			TotalColorValue[i][1] = (int) ((double) TotalColorValue[i][1] / (double) sizeofimage);
			TotalColorValue[i][2] = (int) ((double) TotalColorValue[i][2] / (double) sizeofimage);
			
		}
		
		return TotalColorValue;
	}
	
	//Returns the an array of total values for colors.[Element][Color-1=red, 2=green, 3=blue]
	//Inputs are a string input 'w' is for width side, 'h' for heigth side. and image1data[w][h]
	public static int[][] getTotalColorFromEdge(String input, int[][] image1Data)
	{
		
		int[][] arrayforcolor = new int[image1Data.length][3];
		
		if(input == "w")
		{
			//Run Widths, for heights. Get green value. 
			for(int widths = 0; widths < image1Data.length; widths++)
			{
				
				//Run Widths, for heights. Get green value. 
				for(int heights = 0; heights < image1Data.length; heights++)
				{
					arrayforcolor[widths][0] += look.getRed(image1Data[widths][heights]); //Get Red
					arrayforcolor[widths][1] += look.getGreen(image1Data[widths][heights]); //Get Green
					arrayforcolor[widths][2] += look.getBlue(image1Data[widths][heights]); //Get Blue
				
			
			
				}

			}	
			
			
			
			
		}
		else
		if(input == "h")
		{
			//Run Widths, for heights. Get green value. 
			for(int heights = 0; heights < image1Data.length; heights++)
			{
				
				//Run Widths, for heights. Get green value. 
				for(int widths = 0; widths < image1Data.length; widths++)
				{
					arrayforcolor[heights][0] += look.getRed(image1Data[widths][heights]); //Get Red
					arrayforcolor[heights][1] += look.getGreen(image1Data[widths][heights]); //Get Green
					arrayforcolor[heights][2] += look.getBlue(image1Data[widths][heights]); //Get Blue
			
				}

			}	
			
			
		}
		
		
		
		return arrayforcolor;
		
	}
	
	public static int[] getPixelvalues(int[][] imgRGB){
		
		int width = imgRGB.length;
		int height = imgRGB[0].length;
		
		//Getting target pixel list
		int[][] pixelTargetList = analyzeImage.getPixelList(width, height);
		//Creating a blank pixelvalue list. 
		int[] pixelvalues = new int[pixelTargetList.length];
		
		
		//Get values for pixels from imgRGB
		for(int i = 0; i < pixelvalues.length; i++)
		{
			pixelvalues[i] = imgRGB[pixelTargetList[i][0]][pixelTargetList[i][1]];
			
		}
		
		return pixelvalues;
		
	}
	
	//Function determines if a square view, matches perfectly.
	public static boolean isViewPerfectMatch(int[] pixelList1, int[] pixelList2){
		
		boolean test = true;
		
		//Run through list. 
		for(int i = 0; i < pixelList1.length; i++){
			
			//System.out.println("G:R:B -"+look.getBlue(pixelList1[i])+":"+look.getGreen(pixelList1[i])+":"+look.getRed(pixelList1[i]));
			
			if(look.compareColors(pixelList1[i], pixelList2[i]) == false)
			{
				test = false;
			}
			
			
			
		}
		
		return test;
		
	}
	
	
	//Function determines if a square view, matches perfectly.
		public static double[] PercentageMatch(int[] pixelList1, int[] pixelList2){
			
			
			int passesEven = 0;
			int EvenTestTaken = 0;
			
			int passesOdd = 0;
			int OddTestTaken = 0;
			
			//Run through list. 
			for(int i = 0; i < pixelList1.length; i+=2){
				
				EvenTestTaken++;
				//System.out.println("G:R:B -"+look.getBlue(pixelList1[i])+":"+look.getGreen(pixelList1[i])+":"+look.getRed(pixelList1[i]));
				
				if(look.compareColors(pixelList1[i], pixelList2[i]) == false)
				{
					
				}
				else
				{
					passesEven++; //Test passed.
				}
				
				
				
			}
			
			
			
			//Run through list. 
			for(int i = 1; i < pixelList1.length; i+=2){
				
				OddTestTaken++;
				//System.out.println("G:R:B -"+look.getBlue(pixelList1[i])+":"+look.getGreen(pixelList1[i])+":"+look.getRed(pixelList1[i]));
				
				if(look.compareColors(pixelList1[i], pixelList2[i]) == false)
				{
					
				}
				else
				{
					passesOdd++; //Test passed.
				}
				
				
				
			}
			System.out.println("EvenPasses :"+passesOdd+"  Test :"+OddTestTaken);
			
			
			double[] pecentages = new double[2];
			pecentages[0] =    ((double) passesEven / (double)EvenTestTaken);
			pecentages[1] =  ((double)passesOdd /  (double)OddTestTaken);
			//float value =  ((double) passesOdd) /  ((float) OddTestTaken);
			
			//System.out.println("percentage ="+percentage+" Passes ="+passes+"  tests="+tests.length);
			
			
			return pecentages;
			
		}
	
	
}

 class getDirection {
	
	public final String UP = "UP";
	public final String DOWN = "DOWN";
	public final String LEFT = "LEFT";
	public final String RIGHT = "RIGHT";
	public final String TOP_LEFT = "TOP_LEFT";
	public final String TOP_RIGHT = "TOP_RIGHT";
	public final String BOT_LEFT = "BOT_LEFT";
	public final String BOT_RIGHT = "BOT_RIGHT";
}
