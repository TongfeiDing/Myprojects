

import java.net.MalformedURLException;
import java.rmi.Naming;
import java.rmi.NotBoundException;
import java.rmi.RemoteException;
import java.rmi.server.UnicastRemoteObject;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;

public class LoadBalancerImp extends UnicastRemoteObject implements LoadBalancerInterface{

	protected LoadBalancerImp() throws RemoteException {
		super();
		// TODO Auto-generated constructor stub
	}


	@Override
	/**
	 * The loadbalancer sends a query to every product server and uses responses to make information
	 * of all products in HQ 
	 */
	public String showHQStock() throws RemoteException {
		String stock = "";
		try {
			ProductServerInterface psa = (ProductServerInterface) Naming.lookup("rmi://localhost:38002/ProductServerInterface");
			ProductServerInterface psb = (ProductServerInterface) Naming.lookup("rmi://localhost:38003/ProductServerInterface");
			ProductServerInterface psc = (ProductServerInterface) Naming.lookup("rmi://localhost:38004/ProductServerInterface");
			stock = psa.showHQStock("jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaPSA")+psb.showHQStock("jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaPSB")
					+psc.showHQStock("jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaPSC")+"\n";
		} catch (MalformedURLException | NotBoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		return stock;
	}

	@Override
	/**
	 * The loadbalancer search its database to identify what type the product with inputting ID is
	 */
	public String findProductServer(int productID) throws RemoteException {
		String type = null;
	       try
	       {
	           Connection con = DBUtil.getConnection("jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_LoadBalancer");
	           Statement stmt = con.createStatement();
	           String sql = "select * from ProductIDList where productID = "+ productID;
	           ResultSet rs = stmt.executeQuery(sql);
	           if(rs.next())
	           {
	        	   type = rs.getString(2);
	           }
	           
	           else return null;

	           
	        }
	       catch(Exception e)
	       {
	           e.printStackTrace();
	        }
	       
	       finally
	       {
	           DBUtil.Clse();
	        }
	       return type;
	}



	@Override
	/**
	 * Depends on the product type, the loadbalancer sends request to corresponding product server 
	 */
	public String requestAdditionalStock(int productID, int amount,boolean isCurrentStockedItem) throws RemoteException {
		
		String type = findProductServer(productID);
		try{
	    if(type!=null){
		if(type.equals("smartphone")){
			ProductServerInterface psa = (ProductServerInterface) Naming.lookup("rmi://localhost:38002/ProductServerInterface");
			return psa.request(productID,amount,isCurrentStockedItem,"jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaPSA");
			}
		else if(type.equals("laptop")){
			ProductServerInterface psb = (ProductServerInterface) Naming.lookup("rmi://localhost:38002/ProductServerInterface");
			return psb.request(productID,amount,isCurrentStockedItem,"jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaPSB");
		}
		else if(type.equals("desktop")){
			ProductServerInterface psc = (ProductServerInterface) Naming.lookup("rmi://localhost:38002/ProductServerInterface");
			return psc.request(productID,amount,isCurrentStockedItem,"jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaPSC");
		}
	    }
		}
		catch (MalformedURLException | NotBoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return null;
	}




}
