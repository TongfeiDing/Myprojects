
import java.net.MalformedURLException;
import java.rmi.AlreadyBoundException;
import java.rmi.Naming;
import java.rmi.NotBoundException;
import java.rmi.RemoteException;
import java.rmi.registry.LocateRegistry;
import java.rmi.registry.Registry;
import java.rmi.server.UnicastRemoteObject;


public class BranchServer {
	
	protected String servername;
	protected int portnumber;
	protected String dbaddress;
	protected Registry reg;
	protected boolean isWorking;
	
	public BranchServer(String servername,int portnumber,String dbaddress){
		this.servername = servername;
		this.portnumber = portnumber;
		this.dbaddress =dbaddress;
		this.isWorking = false;
		
	}
	
	public String getName(){
		return this.servername;
	}
	
	public String getDatabaseUrl(){
		return this.dbaddress;
	}
	
	public int getPortNumber(){
		return this.portnumber;
	}
	/**
	 * make a server address according to inputting port number and bound service
	 */
	public String getAddress(){
		return "rmi://localhost:"+this.portnumber+"/BranchInterface";
	}
	/**
	 * bind the server with the service, start working
	 */
	public void startServer(){		
        try {
          reg = LocateRegistry.createRegistry(portnumber);
          Naming.bind(getAddress(), new BranchImp());
          System.out.println(servername+" Started");
          this.isWorking = true;
          
      } catch (RemoteException e) {
           e.printStackTrace();
      } catch (AlreadyBoundException e) {
           e.printStackTrace();
        } catch (MalformedURLException e) {
		// TODO Auto-generated catch block
		e.printStackTrace();
	} 
	}
	/**
	 * unbind the service,cancel the registry and stop listening
	 */
	public void closeServer(){
        try {
        	Naming.unbind(getAddress());
        	UnicastRemoteObject.unexportObject(reg, true);
        	System.out.println(servername+" Closed");
        	this.isWorking = false;
            
        } catch (RemoteException e) {
             e.printStackTrace();
		} catch (MalformedURLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (NotBoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} 
		
	}
	
}