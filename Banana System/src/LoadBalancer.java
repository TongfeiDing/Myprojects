

import java.net.MalformedURLException;
import java.rmi.AlreadyBoundException;
import java.rmi.Naming;
import java.rmi.RemoteException;
import java.rmi.registry.LocateRegistry;

public class LoadBalancer extends BranchServer{
	public LoadBalancer(String servername,int portnumber,String dbaddress){
		super(servername,portnumber,dbaddress);
		
	}
	
	@Override
	public String getAddress(){
		return "rmi://localhost:"+portnumber+"/LoadBalancerInterface";
	} 
	
	@Override
	/**
	 *overide the startServer method. This server has different address and database
	 */
	public void startServer(){		
        try {
          reg = LocateRegistry.createRegistry(portnumber);
          Naming.bind(getAddress(), new LoadBalancerImp());
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
