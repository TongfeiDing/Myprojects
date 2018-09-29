

import java.rmi.Remote;
import java.rmi.RemoteException;

public interface LoadBalancerInterface extends Remote{
	String showHQStock()throws RemoteException;
	String findProductServer(int productID)throws RemoteException;
	String requestAdditionalStock(int productID,int amount,boolean isCurrentStockedItem)throws RemoteException;

}
