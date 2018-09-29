

import java.rmi.RemoteException;
import java.rmi.server.UnicastRemoteObject;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;

public class ProductServerImp extends UnicastRemoteObject implements ProductServerInterface{

	protected ProductServerImp() throws RemoteException {
		super();
		// TODO Auto-generated constructor stub
	}

	@Override
	/**
	 * Show the client all the items in this shop by inputting database address
	 */
	public String showHQStock(String url) throws RemoteException {
		String stocklevel = "";
	       try
	       {
	           Connection con = DBUtil.getConnection(url);
	           Statement stmt = con.createStatement();
	           String sql = "select * from Products";
	           ResultSet rs = stmt.executeQuery(sql);
	           while(rs.next())
	           {
	        	   stocklevel +=rs.getInt(1)+" "+rs.getString(2)+" "+rs.getString(3)+" "+rs.getInt(4)+"\n";
	           }
	           

	           
	        }
	       catch(Exception e)
	       {
	           e.printStackTrace();
	        }
	       
	       finally
	       {
	           DBUtil.Clse();
	        }
	       return stocklevel;
	}

	@Override
	/**
	 * proceed requests from branch servers,if HQ stocks enough products,permit their requests.
	 * minus the HQ's stock and make a sql sentence to add branch's stock
	 */
	public String request(int productID, int amount,
			boolean isCurrentStockedItem, String url) throws RemoteException {
		// TODO Auto-generated method stub
		if(permitRequest()){
	           String sqlback = null;
			try
		       {
		           Connection con = DBUtil.getConnection(url);
		           Statement stmt = con.createStatement();
		           String sql1 = "select * from Products where productID = "+ productID+" and stocklevel >="+amount;
		           ResultSet rs = stmt.executeQuery(sql1);
		           if(rs.next())
		           {

		        	   if(isCurrentStockedItem)sqlback = "update Products set stocklevel = stocklevel+"+amount+" where productID ="+productID;
		        	   else sqlback = "insert into Products values ("+productID+",'"+rs.getString(2)+"','"+rs.getString(3)+"',"+amount+",'')";
		        	   String sql2 = "update Products set stocklevel = stocklevel-"+amount+" where productID ="+productID;		        	   
		        	   stmt.executeUpdate(sql2);//send products to the branch server
		           }
		           

		           
		        }
		       catch(Exception e)
		       {
		           e.printStackTrace();
		        }
		       
		       finally
		       {
		           DBUtil.Clse();
		        }
			return sqlback;
			
		}
		
		else return null;
	}

	private boolean permitRequest() {
		
		return true;
	}

}
