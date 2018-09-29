

import javax.swing.*;




import java.awt.*;
import java.awt.event.*;
/**
 *User interface - login
 * 
 * @Tongfei Ding
 * @1.0
 */
public class ServerGUI extends JFrame
{
    // fields
    private JPanel jp1,jp2,jp3;

    private JButton startHQ,closeHQ,startA,startB,closeA,closeB;

    /**
     * Constructor for objects of class ServerGUI
     */
    public ServerGUI()
    {
        // initialise instance variables
        jp1 = new JPanel();
        jp2 = new JPanel();
        jp3 = new JPanel();
        startHQ = new JButton("Start HQ server");
        closeHQ = new JButton("Close HQ server");
        startA = new JButton("Start serverA");
        startB = new JButton("Start serverB");
        closeA = new JButton("Close serverA");
        closeB = new JButton("Close serverB");
    /*    this.addWindowListener(new WindowAdapter(){
        	public void windowClosing(WindowEvent e){
        		System.exit(0);
        	}
        });*/
        makeFrame();
    }

    /**
     * Make a login frame and set it visible 
     */
    public void makeFrame()
    {
        this.setLayout(new GridLayout(3,1));
        jp1.add(startA);
        jp1.add(closeA);
        closeA.setEnabled(false);
        
        jp2.add(startB);
        jp2.add(closeB);
        closeB.setEnabled(false);
        
        jp3.add(startHQ);
        jp3.add(closeHQ);
        closeHQ.setEnabled(false);
        
        startHQ.addActionListener(new ServerListener());
        startA.addActionListener(new ServerListener());
        startB.addActionListener(new ServerListener());
        closeHQ.addActionListener(new ServerListener());
        closeA.addActionListener(new ServerListener());
        closeB.addActionListener(new ServerListener());
        
        
        this.add(jp1);
        this.add(jp2);
        this.add(jp3);
        this.pack();
        this.setVisible(true);
        this.setTitle("Server Terminal");
    }
    
    /**
     *
     */
    private class ServerListener implements ActionListener
    {
        /*
         * 
           */
        public void actionPerformed(ActionEvent e)
        {//action listener to bind events to buttons
        	String com = e.getActionCommand();
        	if(com.equals("Start serverA")){        		
        		ServerConsole.bsA.startServer();
        		startA.setEnabled(false);
        		closeA.setEnabled(true);
        	}; 
        	if(com.equals("Start serverB")){       		
        		ServerConsole.bsB.startServer();
        		startB.setEnabled(false);
        		closeB.setEnabled(true);
        	}; 
        	if(com.equals("Start HQ server")){        		
        		ServerConsole.LB.startServer();
        		ServerConsole.psA.startServer();
        		ServerConsole.psB.startServer();
        		ServerConsole.psC.startServer();
        		startHQ.setEnabled(false);
        		closeHQ.setEnabled(true);
        	}; 
        	if(com.equals("Close serverA")){
        		ServerConsole.bsA.closeServer();
        		startA.setEnabled(true);
        		closeA.setEnabled(false);
        	}; 
        	if(com.equals("Close serverB")){
        		ServerConsole.bsB.closeServer();
        		startB.setEnabled(true);
        		closeB.setEnabled(false);
        	}; 
        	if(com.equals("Close HQ server")){
        		ServerConsole.LB.closeServer();
        		ServerConsole.psA.closeServer();
        		ServerConsole.psB.closeServer();
        		ServerConsole.psC.closeServer();
        		startHQ.setEnabled(true);
        		closeHQ.setEnabled(false);
        	}; 
        	

        }
        
    }
}
