
import java.rmi.Remote;
import java.rmi.RemoteException;

public interface BranchInterface extends Remote{
	
	String showStock(String url) throws RemoteException;
	String findProductbyID(int productID, String url) throws RemoteException;
	String findCustomerbyID(int customerID, String url) throws RemoteException;	
	String sayHi()throws RemoteException;    
    String purchase(int productID, int customerID, int amount,String url)throws RemoteException;
	String requestAdditionalStock(int productID, int amount, String dbaddress)throws RemoteException;
	

}
