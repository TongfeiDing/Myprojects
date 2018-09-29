

import java.net.MalformedURLException;
import java.rmi.AlreadyBoundException;
import java.rmi.Naming;
import java.rmi.RemoteException;
import java.rmi.registry.LocateRegistry;

public class HQServer extends BranchServer{//reuse some method in BranchServer class 

	
	public HQServer(String servername, int portnumber, String dbaddress) {
		super(servername, portnumber, dbaddress);
		
	}
	
	@Override
	public String getAddress(){
		return "rmi://localhost:"+portnumber+"/ProductServerInterface";
	} 
	
	@Override
	public void startServer(){		
        try {
          reg = LocateRegistry.createRegistry(portnumber);
          Naming.bind(getAddress(), new ProductServerImp());
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

}
