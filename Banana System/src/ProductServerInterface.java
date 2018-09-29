

import java.rmi.Remote;
import java.rmi.RemoteException;

public interface ProductServerInterface extends Remote{
	String showHQStock(String url)throws RemoteException;

	String request(int productID, int amount, boolean isCurrentStockedItem,String url)throws RemoteException;

}
