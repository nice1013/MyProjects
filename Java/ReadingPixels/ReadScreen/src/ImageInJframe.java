import java.awt.AWTException;
import java.awt.Color;
import java.awt.Dimension;
import java.awt.Graphics;
import java.awt.Image;
import java.awt.MouseInfo;
import java.awt.Point;
import java.awt.PointerInfo;
import java.awt.Rectangle;
import java.awt.Robot;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.image.BufferedImage;
import java.awt.image.DataBufferByte;
import java.awt.image.DataBufferInt;
import java.awt.image.WritableRaster;
import java.io.ByteArrayInputStream;
import java.io.File;
import java.io.IOException;

import javax.imageio.ImageIO;
import javax.swing.ImageIcon;
import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;



public class ImageInJframe extends JFrame
{
	
	public static void main(String args[])
	{
		new ImageInJframe().start();
	}
	
	public void start()
	{
		
		Graphics bufG;
		 Robot bot2 = null;
		 JFrame jframe = new JFrame("Testing Image");
		 JPanel panel = new JPanel();
		 JLabel picLabel;
		 
		 
		 
		 try {
			bot2 = new Robot();
		} catch (AWTException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		 
		Dimension screenSize =  Toolkit.getDefaultToolkit().getScreenSize();
		double w = screenSize.getWidth();
		double h = screenSize.getHeight();
		     
		int nw = (int) ((w * .5) - 50);
		int nh = (int) ((h * .5) - 50);
		 
		Rectangle rect = new Rectangle( Toolkit.getDefaultToolkit().getScreenSize() );
		Rectangle rect2 = new Rectangle(nw, nh, 100, 100);
		Rectangle rect3 = new Rectangle(nw, nh, 300, 100);
		
		
		
	     BufferedImage newImage = bot2.createScreenCapture(rect2);
	     BufferedImage newImage2 = bot2.createScreenCapture(rect3);
	     
	     
	     /*
	     JLabel jLabel = new JLabel(new ImageIcon(newImage2));
         
         JPanel jPanel = new JPanel();
         jPanel.add(jLabel);
         jframe.add(jPanel);
         jframe.setVisible(true);
         jframe.setSize(500, 500);
        */
	     
	     RunImageCapture ric = new RunImageCapture();
	     
	     
	     (new Thread(ric)).start();
	     
	              
         
	     
	    File outputfile = new File("Images/saved.png");
	    try {
			ImageIO.write(newImage, "png", outputfile);
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	     
	    
	    int[] arrayofrgb =  newImage.getRGB(0, 0,  newImage.getWidth(), newImage.getHeight(), null, 0, (int) newImage.getWidth());
	    
	    
	    
	    Color mycolor = new Color(arrayofrgb[0]);
	    
		ImageImplement panel3 = new ImageImplement(newImage);
		
		  add(panel3);
		  add(new JLabel("Array Count"+arrayofrgb.length));
		  setVisible(true);
		  setSize(400,400);
		  setDefaultCloseOperation(EXIT_ON_CLOSE);
		  
		
	}

}


class RunImageCapture extends Thread {
	
	private static final int EXIT_ON_CLOSE = 0;
	JFrame jframe = new JFrame();
	JPanel jpanel = new JPanel(); 
	
	Dimension screenSize =  Toolkit.getDefaultToolkit().getScreenSize();
	double w = screenSize.getWidth();
	double h = screenSize.getHeight();
	     
	final int widthOfCapture = 500;
	final int heightOfCapture =500;
	int PIXELS = widthOfCapture * heightOfCapture;
	int mouseWidthandHeight = 10;
	
	//Start positions for mouse width an dheight.
	int nw = (int) ((w * .5) - (widthOfCapture * .5));
	int nh = (int) ((h * .5) - (heightOfCapture * .5));
	 
	
	
	Rectangle rect3 = new Rectangle(nw, nh, widthOfCapture, heightOfCapture);
	
	boolean running = true;
	int runtimes = 0;
	
	public void run() {
        Start();
    }
	
	public void Start() {
		
		while(running) 
		{
			try {
			    Thread.sleep(33);      //1000 milliseconds is one second.     
			    DisplayImage();
			} catch(InterruptedException ex) {
			    Thread.currentThread().interrupt();
			}
		}
		
	}
	
	public void DisplayImage() {
		
		jpanel.removeAll();
		jframe.getContentPane().removeAll();
		
		
		
		
			runtimes++;
			Robot bot2 = null;
			
			try {
				bot2 = new Robot();
			} catch (AWTException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		
			
			//Generating color and width of mouse for emulation purpose Since screen can't capute mouse.
			 Color color = new Color(0,0,0);
			 int arrayofrgb = color.getRGB();
			 int[] rgbarray = new int[widthOfCapture];
			 
			 //Inserting color into an array of colors. 
			 for(int r = 0; r<widthOfCapture; r++)
			 {
			
				 rgbarray[r] = arrayofrgb;
			 }	
			
		 //Capture the screen. 
		 BufferedImage newImage2 = bot2.createScreenCapture(rect3);
		 
		 int[][] doublePixels = getDoublePixels(newImage2, newImage2.getWidth(), newImage2.getHeight());
		 //Color values for value. 
		 //Blue = 256; 
		 //Green = 65535;
		 //Red = 16777215;
		 
		 
		 for(int i = 0; i < widthOfCapture ; i++)
		 {
			 
			 for(int r = 0; r<heightOfCapture; r++)
			 {
			
				 System.out.println("Value for x/y = "+ i + " / "+ r + "  -- Int : "+this.getRed(doublePixels[i][r]) );
				 
			 }
			 
		 }
		 
		 
		 //Press Green onto the image
		 for(int i = 0; i < heightOfCapture; i++)
		 {
			 //Every 10 frames put green on screen.
			 if(i % 10 == 0 || i == 0)
			 {
				 int p = i;
				 if(p > 254)
				 {
					 p -= 250;
					 
				 }
				 
				 Color myc = new Color(0, p, 0);
				 int arrayofrgb2 = myc.getRGB();
				 int[] rgbarray2 = new int[widthOfCapture];
				 
				 //Inserting color into an array of colors. 
				 for(int r = 0; r<widthOfCapture; r++)
				 {
				
					 rgbarray2[r] = arrayofrgb2;
				 }
				 
				 
			 newImage2.setRGB(0, i, widthOfCapture, 1, rgbarray2, 0, 0);	 
				 
			 }
			 else 
			 {
			 newImage2.setRGB(0, i, widthOfCapture, 1, doublePixels[i], 0, 0);
			 }
				 
		 }
		 
		 PointerInfo a = MouseInfo.getPointerInfo();
		 Point b = a.getLocation();
		 
		 int pointerx = 0;
		 int pointery = 0;
		 
		 System.out.println("Width="+nw+" Height="+nh);
		
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
		 
		 
		 
		 System.out.println("X="+b.x+" Y="+b.y+"PointerWidth="+pointerx+" PointH="+pointery);
		 
		 
		 
		 //Setting mouse over top image. Starting with the current pixel/position.
		 if( pointery > 0 && pointerx > 0 )
		 {
		 newImage2.setRGB(pointerx, pointery, 10, 10, rgbarray, 0, 0);
		 }

		 //Refreshing to jpanel.
		 jpanel.add( new JLabel( new ImageIcon(newImage2)));
		 jpanel.add( new JLabel(""+runtimes));
		 
		 JButton close = new JButton("Close!");
		 
		 close.addActionListener(new CloseListener());
		 
		 jpanel.add(close);
		 
		 
		 jframe.add(jpanel);
		 
		 if(jframe.isVisible() == false)
		 {	 
		 jframe.setLocationRelativeTo(null);
		 }
		 
		 
		 jframe.setVisible(true);
		 jframe.setSize(600,600);
		 
		
		 
	}
	
	
	
	public static int[][] getDoublePixels(BufferedImage image, int width, int height)
	{
		
		int[][] pixels = new int[height][width];
		
		for( int i = 0; i < height ; i++ )
		    for( int j = width - 1; j > 0; j--)
		        pixels[i][j] = image.getRGB( j, i );
		
		return pixels;
		
	}
	
	public static int[] getSinglePixels(BufferedImage image, int width, int height)
	{
		
		int[] pixels = new int[width * height];
		int counter = 0;
		
		for( int i = 0; i < width; i++ )
		{
		    for( int j = 0; j < height; j++ )
		    {
		    	Color c = new Color(image.getRGB(j, i), false);
		    	pixels[counter] = c.getRGB();
		    	counter++;
		    }
		}
		return pixels;
		
	}
		
		
	public static BufferedImage getImageFromArray(int[] pixels, int width, int height) {
        BufferedImage image = new BufferedImage(width, height, BufferedImage.TYPE_INT_ARGB);
        image.setRGB(0, 0, width, height, pixels, 0, 0);
        return image;
    }
	
	
	/*
	          * Returns the red component in the range 0-255 in the default sRGB
	          * space.
	          * @return the red component.
	          * @see #getRGB
	*/
	public int getRed(int thing) {
	  return (thing >> 16) & 0xFF;
	}
	  
	  
	/*
	  * Returns the green component in the range 0-255 in the default sRGB
	  * space.
	  * @return the green component.
	  * @see #getRGB
	*/
	public int getGreen(int thing) {
	  return (thing >> 8) & 0xFF;
	}
	
	
	/*
	  Returns the blue component in the range 0-255 in the default sRGB
	  space.
	  @return the blue component.
	  @see #getRGB
	*/
	public int getBlue(int thing) {
		return (thing >> 0) & 0xFF;
	}
	
}


class CloseListener implements ActionListener {
	
    @Override
    public void actionPerformed(ActionEvent e) {
        System.exit(0);
    }
    
}


class ImageImplement extends JPanel {

	  private Image img;


	  public ImageImplement(Image img) {
	    this.img = img;
	    Dimension size = new Dimension(img.getWidth(null), img.getHeight(null));
	    setPreferredSize(size);
	    setMinimumSize(size);
	    setMaximumSize(size);
	    setSize(size);
	    setLayout(null);
	  }

	  public void paintComponent(Graphics g) {
	    g.drawImage(img, 0, 0, null);
	  }

}




