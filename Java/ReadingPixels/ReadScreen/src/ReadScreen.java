import java.awt.AWTException;
import java.awt.BorderLayout;
import java.awt.FlowLayout;
import java.awt.Graphics;
import java.awt.Graphics2D;
import java.awt.Rectangle;
import java.awt.RenderingHints;
import java.awt.Robot;
import java.awt.Toolkit;
import java.awt.image.BufferedImage;

import javax.swing.*;

public class ReadScreen {

	public static void main(String[] args) {
		// TODO Auto-generated method stub

		
		
		
		
		/*
		//Createing a JFrame 
		JFrame frame = new JFrame("JFrame Demo");
		
		frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		
		frame.pack();
		frame.setSize(600, 500);
		
		
		JPanel p = new JPanel();
		p.setLayout(new FlowLayout());
		
		
		frame.getContentPane().add(p, BorderLayout.CENTER);
		
		
		JLabel newLabel = new JLabel("Hello Bitches");
		
		p.add(newLabel, BorderLayout.CENTER);
		
		
		
		
		JLabel another = new JLabel("Nothing Yet!");
		p.add(another, BorderLayout.CENTER);
		
		
		
		
		
		
		
		try {
			Robot bot = new Robot();
			
			DrawBackground helloworld = new DrawBackground();
			helloworld.DrawItBitch(frame.getGraphics());
			
			
			
			
			for(int i = 0; i<100; i++)
			{
				try {
				    Thread.sleep(1);                 //1000 milliseconds is one second.
				} catch(InterruptedException ex) {
				    Thread.currentThread().interrupt();
				}
			bot.mouseMove(i * 2, i * 2);
			another.setText("Current Position "+i+".");
			}
			
			
			
		} catch (AWTException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		
		frame.setVisible(true);
		
		*/
	}

}


class DrawBackground extends JPanel 
{
	protected void DrawItBitch( Graphics g )
	{
		 super.paintComponent( g );
	     Graphics2D g2d = ( Graphics2D ) g;
	     g2d.setRenderingHint(RenderingHints.KEY_ANTIALIASING,
                 RenderingHints.VALUE_ANTIALIAS_ON);
	     
	     Robot bot2;
		try {
			bot2 = new Robot();
			
			 Rectangle rect = new Rectangle( Toolkit.getDefaultToolkit().getScreenSize() );
		     BufferedImage newImage = bot2.createScreenCapture(rect);
		     g2d.drawImage(newImage, 100, 100, null);
		} catch (AWTException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	     
	    
	}
	
}

