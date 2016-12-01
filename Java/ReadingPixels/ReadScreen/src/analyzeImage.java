import java.awt.Color;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.image.BufferedImage;

import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;


public class analyzeImage {
	
	static int POIh = 0; 
	static int POIw = 0; 
	
	
	//Size of screen. 
	static int h = 500; 
	static int w = 500; 
	
	
	static int wjump = (int) (w * .10); 
	static int hjump = (int) (h * .10); 
	
	static int possibleWJumps = (int) (w / (wjump)) - 1;
	static int possibleHJumps = (int) (h / (hjump)) - 1;
	
	
	static //Mapping COlor.
	Color mappingcolor = new Color(11,11,11);
	static int mapValue = mappingcolor.getRGB();
	

	public static double pixelSpace = 0.1;
	
	
	public static void main(String args[])
	{
		showMap();
		
		
	}
	
	
	//get both square list and the fib pixel list. 
	public static int[][] getPixelList(int w, int h)
	{
		//get square list
		//int[][] SquareList = getSquareList(w, h);
		
		//get fib list. 
		//int[][] FibList = getFibList(w, h);
		
		//get Dynamic Edge List 
		//int[][] EdgeList = getEdgeList(w, h);
		
		int[][] DottedList = getDottedList(w, h, pixelSpace);
		
		System.out.println("Pixels="+DottedList.length);
		
		//combine list. 		
		//int[][] completelist = new int[SquareList.length + FibList.length + EdgeList.length + DottedList.length][2];
		int[][] completelist = new int[ DottedList.length][2];
		
		
		int elementHolder = 0;
		//Compile List 
		//First Square list. 
		/*
		for(int i = 0; i < SquareList.length; i++)
		{
			
			//completelist[elementHolder++] = SquareList[i];
			
		}
		
		//Then FibList 
		for(int i = 0; i < FibList.length; i++)
		{
			
			//completelist[elementHolder++] = FibList[i];
			
		}
		
		//Then FibList 
		for(int i = 0; i < EdgeList.length; i++)
		{
			
			completelist[elementHolder++] = EdgeList[i];
			
		}
		*/
		//Then FibList 
		for(int i = 0; i < DottedList.length; i++)
		{
			
			completelist[elementHolder++] = DottedList[i];
			
		}
		
		
		//We're Done!. 
		return completelist;
		
		
		
	}
	
	
	//Gets the list of pixel positions for the standard square/rect view.
	public static int[][] getDottedList(int w, int h, double percentageSpace){
		
		int[][] fibtargets = null;
		boolean useW = false;
		
		if(w>h)
		{
			useW = true;
		}
		else
		{
			useW = false;
		//fibtargets = new int[h][2];	
		}
		
		
		//Space bewteen pixels.
		int jump =  (int) (w * percentageSpace);
		int maxpixels = 0;
		
		
		//Is w or height greater. Generate max pixels based on that info. 
		if(useW)
		{
			
			jump = (int) (w * percentageSpace);
			int temppixelcount = (int)  (  Math.pow((double) (w / jump), 2) );
			maxpixels = (int) (temppixelcount + (temppixelcount * .25));
			
		
		}
		else
		{
			
			jump = (int) (h * percentageSpace);
			int temppixelcount = (int)  (  Math.pow((double) (h / jump), 2) );
			maxpixels = (int) (temppixelcount + (temppixelcount * .25));
			
		}
				
		
		
		fibtargets = new int[maxpixels][2];			
				
		
		//System.out.println("Jump="+jump);
		//System.out.println("maxpixels="+maxpixels);
		int[] widths = new int[fibtargets.length];
		
		//Loop to fill width points to place pixels. 
		for(int i = 0; i < w; i++)
		{
			//Check if loop * jump value is greater than width.
			if(i * jump < w)
			{
				
				widths[i] = i * jump;
			}
			else
			{
				widths[i] = w - 1;
				i = w;
				
			}
			
			
		}
		
		int[] heights = new int[fibtargets.length];
		
		//Loop to fill width points to place pixels. 
		for(int i = 0; i < h; i++)
		{
			//Check if loop * jump value is greater than width.
			if(i * jump < h)
			{
				
				heights[i] = i * jump;
			}
			else
			{
				heights[i] = h - 1;
				i = h;
				
			}
			
			
		}
		
		boolean still = true;
		int widthElements = 0;
		
		//check when width values run out.
		for(int i = 0; still; i++)
		{
			if(widths[i] == 0 && i > 0)
			{
				
				widthElements = i;
				still = false;
			}
			
		}
		
		still = true;
		int heightElements = 0;
		
		//check when width values run out.
		for(int i = 0; still; i++)
		{
			if(heights[i] == 0 && i > 0)
			{
				
				heightElements = i;
				still = false;
			}
			
		}
		
		
		int currentElement = 0;
		
		//Run throught both widths and heights and fill pixel points/targets. 
		for(int i = 0; i < widthElements; i++)
		{
			
			
			
			for(int j = 0; j < heightElements; j++)
			{
				
				//System.out.println("I="+i+"  J="+j+"Width ="+widths[i]+" Height ="+heights[j]);
				fibtargets[currentElement][0] = widths[i];
				fibtargets[currentElement++][1] = heights[j];
				
				
			}
			
			
		}
		
		
		//Condesning the list to a smaller array.
		int[][] returnTargetList = new int[currentElement][2];
		
		for(int i = 0; i < currentElement; i++)
		{
			returnTargetList[i][0] = fibtargets[i][0];
			returnTargetList[i][1] = fibtargets[i][1];
			
		}
		
		
		return returnTargetList;
			
	}
	
	
	//Gets the list of pixel positions for the standard square/rect view.
	public static int[][] getSquareList(int w, int h){
		
		int[][] fibtargets = null;
		
		if(w>h)
		{
		fibtargets = new int[w][2] ;
		}
		else
		{
		fibtargets = new int[h][2];	
		}
		
		
		int[] fibNumbers = {0,1,1,2,3,5,8,13,21,34,55,89,144,233,377,610,987};
		//Where our fib scan will start. 
		int wstartpos = getstartpos(w);
		int hstartpos = getstartpos(h);
		
		
		int fibCurrentElement = 0;
		
		//Set corners pixel to black
		fibtargets[fibCurrentElement][0] = 0;
		fibtargets[fibCurrentElement++][1] = 0;
		
		fibtargets[fibCurrentElement][0] = 0;
		fibtargets[fibCurrentElement++][1] = h - 1;
		
		fibtargets[fibCurrentElement][0] = w - 1;
		fibtargets[fibCurrentElement++][1] = 0;
		
		fibtargets[fibCurrentElement][0] = w - 1;
		fibtargets[fibCurrentElement++][1] = h  - 1;
		//and center 
		fibtargets[fibCurrentElement][0] = wstartpos;
		fibtargets[fibCurrentElement++][1] = hstartpos;
		
				
		
		//Set side pixels to black
		for(int i = 1; i <= possibleWJumps; i++)
		{
		//get jumps from corners. 
		//Top left corner. right-> --Width movement
		fibtargets[fibCurrentElement][0] = wjump * i;
		fibtargets[fibCurrentElement++][1] = 0;
		
		//Top Right corner going left. --Width movement
		fibtargets[fibCurrentElement][0] = w - (wjump * i);
		fibtargets[fibCurrentElement++][1] = 0;
		
		//bottom right corner going left --Width movement
		fibtargets[fibCurrentElement][0] = w - (wjump * i);
		fibtargets[fibCurrentElement++][1] = h - 1;
		
		//Bottom left corner going right-> --Width movement
		fibtargets[fibCurrentElement][0] = wjump * i;
		fibtargets[fibCurrentElement++][1] = h  - 1;
		}
		
		//Set side pixels to black
		for(int i = 1; i <= possibleHJumps; i++)
		{
		//Top left corner down.    --Height movement
		fibtargets[fibCurrentElement][0] = 0;
		fibtargets[fibCurrentElement++][1] = hjump * i;
		
		//Bottom corner going up   --Height movement
		fibtargets[fibCurrentElement][0] = 0;
		fibtargets[fibCurrentElement++][1] = h - (hjump * i);
		
		//bottom right corner goign up --Height movement
		fibtargets[fibCurrentElement][0] = w - 1;
		fibtargets[fibCurrentElement++][1] = h - (hjump * i);
		
		//Top Right corner going down. --Height movement
		fibtargets[fibCurrentElement][0] = w  - 1;
		fibtargets[fibCurrentElement++][1] = hjump * i;
		}
		
		
		int[][] returnTargetList = new int[fibCurrentElement][2];
		
		for(int i = 0; i < fibCurrentElement; i++)
		{
			returnTargetList[i][0] = fibtargets[i][0];
			returnTargetList[i][1] = fibtargets[i][1];
			
		}
		
		
		return returnTargetList;
		
	}
	
	
	
	
	
	
	//Get a of position for what pixels are  needed to scan. 
	public static int[][] getFibList(int w, int h)
	{
		int[][] fibtargets = null;
		
		if(w>h)
		{
		fibtargets = new int[w][2];
		}
		else
		{
		fibtargets = new int[h][2];	
		}
		
		int[] fibNumbers = {0,1,1,2,3,5,8,13,21,34,55,89,144,233,377,610,987};
		//Where our fib scan will start. 
		int wstartpos = getstartpos(w);
		int hstartpos = getstartpos(h);
		
		int fibtargetsElement = 0;

		//Set fibinacci pixels.
		for(int i = 0; i < fibNumbers.length; i++)
		{
			
			
			//Direction is up. 
			//If fibnumber breaks widght or height barrier. 
			if(fibNumbers[i] > w / 3|| fibNumbers[i] > h / 3)
			{
				i = fibNumbers.length;
			}
			else
			{
			//Applying black to fibnumbers
				
			//LEFT	
			//Left Bot Corner "-, -"
			//W
			fibtargets[fibtargetsElement++][0] = wstartpos - fibNumbers[i];
			//H
			fibtargets[fibtargetsElement++][1] = hstartpos - fibNumbers[i];
			
			//Left "-, 0"
			//W
			fibtargets[fibtargetsElement++][0] = wstartpos - fibNumbers[i];
			//H
			fibtargets[fibtargetsElement++][1] = hstartpos;
			
			
			
			//Left top corner "-, +"
			//W
			fibtargets[fibtargetsElement++][0] = wstartpos - fibNumbers[i];
			//H
			fibtargets[fibtargetsElement++][1] = hstartpos + fibNumbers[i];
			
			
			
			//RIGHT
			//Right Bot Corner "+, -"
			//W
			fibtargets[fibtargetsElement++][0] = wstartpos + fibNumbers[i];
			//H
			fibtargets[fibtargetsElement++][1] =  hstartpos - fibNumbers[i];
			
			//Right "+, 0"
			//W
			fibtargets[fibtargetsElement++][0] = wstartpos + fibNumbers[i];
			//H
			fibtargets[fibtargetsElement++][1] = hstartpos ;
			
			
			
			//Right top corner "+, +"
			//W
			fibtargets[fibtargetsElement++][0] = wstartpos + fibNumbers[i];
			//H
			fibtargets[fibtargetsElement++][1] = hstartpos + fibNumbers[i];
			
			//TOP 
			//TOP "0, +"
			//W
			fibtargets[fibtargetsElement++][0] = wstartpos;
			//H
			fibtargets[fibtargetsElement++][1] = hstartpos + fibNumbers[i];
			
			//BOTTOM
			//Bottom "0, -"
			//W
			fibtargets[fibtargetsElement++][0] = wstartpos;
			//H
			fibtargets[fibtargetsElement++][1] = hstartpos - fibNumbers[i];
			
			}
		
				
				
		}
		
		
		
		//Condensing the list.
		int[][] returnTargetList = new int[fibtargetsElement][2];
		
		for(int i = 0; i < fibtargetsElement; i++)
		{
			returnTargetList[i][0] = fibtargets[i][0];
			returnTargetList[i][1] = fibtargets[i][1];
			
		}
		
		
		return returnTargetList;
		
		
	}
	
	
	
	
	
	
	
	
	
	
	public static void showMap() {
		
		//Create empty pixel array.
		int[][] maparray = new int[w][h]; 
		
		
		maparray = applyAllMaps(maparray);
		maparray = applyWhiteSpace(maparray);
		
		
		BufferedImage image = new BufferedImage(w, h, BufferedImage.TYPE_INT_RGB);
		
		image = look.setRGBArray(image, maparray);
		
		JFrame jframe = new JFrame("Showing Map");
		JPanel jpanel = new JPanel(); 
		
		jpanel.add( new JLabel( new ImageIcon(image)));
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

		
	}
	
	public static int[][] applyWhiteSpace(int [][] maparray){
		
		Color white = new Color(254, 254, 254);
		int whiteint = white.getRGB();
		
		
		
		//Run through map array and any value that is empty fill with this color. 
		for(int i = 0; i < maparray.length; i++)
		{
			
			for(int p = 0; p < maparray[0].length; p++)
			{
				
				
				
				if(maparray[i][p] != mapValue) 
				{
					maparray[i][p] = whiteint;
					
				}
				
				
			}
			
			
			
		}
		
		return maparray;
		
	}
	
	//Lays out a map that starts from the cent and moves outward. 
	public static int[][] getEdgeList(int w, int h){
		
		int[][] fibtargets = null;
		
		if(w>h)
		{
		fibtargets = new int[w][2];
		}
		else
		{
		fibtargets = new int[h][2];	
		}
		
		int[] fibNumbers = {1,2,3,5,8,13,21,34,55,89,144,233,377,610,987};
		//Where our fib scan will start. 
		int wstartpos = getstartpos(w);
		int hstartpos = getstartpos(h);
		
		int fibtargetsElement = 0;
		
		for(int i = 0; i < w; i++)
		{
			
			if(i % 2 == 0)
			{
				//EVEN i
				//Target width and height -- point 1;
				fibtargets[fibtargetsElement][0] = wstartpos + (fibNumbers[i] * 1);
				fibtargets[fibtargetsElement++][1] = hstartpos + 0;
				//Point 2
				fibtargets[fibtargetsElement][0] = wstartpos + (fibNumbers[i]  * 1);
				fibtargets[fibtargetsElement++][1] = hstartpos + (fibNumbers[i]  * 1);
				//Point 3
				fibtargets[fibtargetsElement][0] = wstartpos + 0;
				fibtargets[fibtargetsElement++][1] = hstartpos + (fibNumbers[i]  * 1);
				//Point 4
				fibtargets[fibtargetsElement][0] = wstartpos - (fibNumbers[i]  * 1);
				fibtargets[fibtargetsElement++][1] = hstartpos - (fibNumbers[i]  * 1);
				
				//Test to see if we may break barrier.
				if(wstartpos + fibNumbers[i+1] > w || hstartpos + fibNumbers[i+1] > h  )
				{
					i = w;
				}
			}else
			{
				//ODD i 
				//Target width and height -- point 1;
				fibtargets[fibtargetsElement][0] = wstartpos - (fibNumbers[i]  * 1);
				fibtargets[fibtargetsElement++][1] = hstartpos - 0;
				//Point 2
				fibtargets[fibtargetsElement][0] = wstartpos - (fibNumbers[i]  * 1);
				fibtargets[fibtargetsElement++][1] = hstartpos - (fibNumbers[i]  * 1);
				//Point 3
				fibtargets[fibtargetsElement][0] = wstartpos - 0;
				fibtargets[fibtargetsElement++][1] = hstartpos - (fibNumbers[i]  * 1);
				//Point 4
				fibtargets[fibtargetsElement][0] = wstartpos + (fibNumbers[i]  * 1);
				fibtargets[fibtargetsElement++][1] = hstartpos + (fibNumbers[i]  * 1);
				
				
				//Test to see if we may break barrier.
				if(wstartpos + fibNumbers[i+1] > w || hstartpos + fibNumbers[i+1] > h  )
				{
					i = w;
				}
			}
				
		}
		
		

		return fibtargets;
	}
	

	
	
	public static int[][] applyEdgeMap(int[][] maparray)
	{
		
		
		int[][] pixelList = getEdgeList(w, h);
		
		
		for(int i = 0; i < pixelList.length; i++)
		{
			
			maparray[pixelList[i][0]] [pixelList[i][1]] = mapValue;
			
		}
		
		return maparray;
	}
	
	
	
	public static int[][] applySquareMap(int[][] maparray)
	{
		
		
		int[][] pixelList = getSquareList(w, h);
		
		
		for(int i = 0; i < pixelList.length; i++)
		{
			
			maparray[pixelList[i][0]] [pixelList[i][1]] = mapValue;
			
		}
		
		return maparray;
	}
	
	
	//ApplyAllMaps -- Inputs : RGBarray [Width][Height] = maparray
	//Returns an altered version of maparray.
	public static int[][] applyAllMaps(int[][] maparray)
	{
		
		
		int[][] pixelList = getPixelList(w, h);
		
		
		for(int i = 0; i < pixelList.length; i++)
		{
			
			maparray[pixelList[i][0]] [pixelList[i][1]] = mapValue;
			
		}
		
		return maparray;
	}
	
	
	
	public static int[][] applyFibMap(int[][] maparray)
	{
		
		
		int[] fibNumbers = {0,1,1,2,3,5,8,13,21,34,55,89,144,233,377,610,987};
		//Where our fib scan will start. 
		int wstartpos = getstartpos(w);
		int hstartpos = getstartpos(h);
		
		
		
		
		//Set corners pixel to black. 
		maparray[0][0] = mapValue;
		maparray[0][h - 1] = mapValue;
		maparray[w - 1][0] = mapValue;
		maparray[w - 1][h  - 1] = mapValue;
		//and center 
		maparray[wstartpos][hstartpos] = mapValue;
				
		
		//Set side pixels to black
		for(int i = 1; i <= possibleWJumps; i++)
		{
		//get jumps from corners. 
		//Top left corner. right-> --Width movement
		maparray[wjump * i][0] = mapValue;
		
		//Top Right corner going left. --Width movement
		maparray[w - (wjump * i)][0] = mapValue;
		
		//bottom right corner going left --Width movement
		maparray[w - (wjump * i)][h - 1] = mapValue;
		
		//Bottom left corner going right-> --Width movement
		maparray[(wjump * i)][h  - 1] = mapValue;
		}
		
		//Set side pixels to black
		for(int i = 1; i <= possibleHJumps; i++)
		{
		//Top left corner down.    --Height movement
		maparray[0][hjump * i] = mapValue;
		
		//Bottom corner going up   --Height movement
		maparray[0][h - (hjump * i)] = mapValue; 
		
		//bottom right corner goign up --Height movement
		maparray[w - 1][h - (hjump * i)] = mapValue;
		
		//Top Right corner going down. --Height movement
		maparray[w  - 1][hjump * i] = mapValue;
		}
		
		
		
		
		
		//Set fibinacci pixels.
		for(int i = 0; i < fibNumbers.length; i++)
		{
			
			
				//Direction is up. 
				//If fibnumber breaks widght or height barrier. 
				if(fibNumbers[i] > w / 3|| fibNumbers[i] > h / 3)
				{
					i = fibNumbers.length;
				}
				else
				{
				//Applying black to fibnumbers
					
				//LEFT	
				//Left Bot Corner "-, -"
				maparray[ wstartpos - fibNumbers[i] ] [ hstartpos - fibNumbers[i]] = mapValue;
				//Left "-, 0"
				maparray[ wstartpos - fibNumbers[i] ] [ hstartpos ] = mapValue;
				//Left top corner "-, +"
				maparray[ wstartpos - fibNumbers[i] ] [ hstartpos + fibNumbers[i] ] = mapValue;
				
				//RIGHT
				//Right Bot Corner "+, -"
				maparray[ wstartpos + fibNumbers[i] ] [ hstartpos - fibNumbers[i] ] = mapValue;
				//Right "+, 0"
				maparray[ wstartpos + fibNumbers[i] ] [ hstartpos ] = mapValue;
				//Right top corner "+, +"
				maparray[ wstartpos + fibNumbers[i] ] [ hstartpos + fibNumbers[i] ] = mapValue;
				
				//TOP 
				//TOP "0, +"
				maparray[ wstartpos ] [ hstartpos + fibNumbers[i] ] = mapValue;
				//BOTTOM
				//Bottom "0, -"
				maparray[ wstartpos ] [ hstartpos - fibNumbers[i] ] = mapValue;
				
				}
			
				
				
		}
		
		return maparray;
	}
	
	
	public Boolean isBlankPixel(int w, int h, int[][]rgbarray) {
		
		int color = rgbarray[w][h];
		
		if(color == 111111111)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	
	public static int getstartpos(int pos) {
		
		if(w % 2 == 1)
		{
			//Start Position for width if the number is odd. 
			pos = ((pos - 1) / 2) + 1;
		}
		else
		{	//Number is even. 
			pos = (pos / 2);
		}
		
		return pos;
	
	}
}


