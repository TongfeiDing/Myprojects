
import java.net.MalformedURLException;
import java.rmi.Naming;
import java.rmi.NotBoundException;
import java.rmi.RemoteException;
import java.rmi.server.UnicastRemoteObject;
import java.sql.*;


public class BranchImp extends UnicastRemoteObject implements BranchInterface{

	//private static final long serialVersionUID = 3434060152387200042L;
	protected BranchImp() throws RemoteException {
		super();
		// TODO Auto-generated constructor stub
	}

	@Override
	/**
	 * Show the client all the items in this shop by inputting database address
	 */
	public String showStock(String url) throws RemoteException {
		String stocklevel = "";
	       try
	       {
	           Connection con = DBUtil.getConnection(url);
	           Statement stmt = con.createStatement();
	           String sql = "select * from Products";
	           ResultSet rs = stmt.executeQuery(sql);
	           while(rs.next())
	           {
	        	   stocklevel += rs.getInt(1)+" "+rs.getString(2)+" "+rs.getString(3)+" "+rs.getInt(4)+"\n";
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
	public String sayHi() throws RemoteException {
		return "Hi,this is the server!";
	}

	@Override
	/**
	 * Show the client a customer's information and purchase history by inputting his/her ID and  database address
	 */
	public String findCustomerbyID(int customerID, String url) throws RemoteException {
		String info = "";
	       try
	       {
	           Connection con = DBUtil.getConnection(url);
	           Statement stmt = con.createStatement();
	           String sql1 = "select * from Customers where customerID = "+customerID;
	           ResultSet rs1 = stmt.executeQuery(sql1);
	           if(rs1.next())
	           {
	        	  info += rs1.getString(2)+" "+rs1.getString(3)+" address:"+rs1.getString(4)+" "+rs1.getString(5)+" phonenumber:"+rs1.getString(6)+" email:"+rs1.getString(7)+"\n"+"purchase history:\n";
	        	  String sql2 = "select * from Products,Transactions where Transactions.customerID = "+customerID+" and Products.productID = Transactions.productID";
	        	  ResultSet rs2 = stmt.executeQuery(sql2);
	        	  while(rs2.next())
	        	  {
	        		  info += rs2.getString("productname")+" "+rs2.getInt("amount")+" at:"+rs2.getTime("time")+"\n";
	        	  }
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
	       return info;
		
		
	}

	@Override
	/**
	 * return a product's information by inputting ID and database address. If this branch doesn't store this product,return null.
	 */
	public String findProductbyID(int productID, String url) throws RemoteException {
		String info = "";
	       try
	       {
	           Connection con = DBUtil.getConnection(url);
	           Statement stmt = con.createStatement();
	           String sql = "select * from Products where productID = "+ productID;
	           ResultSet rs = stmt.executeQuery(sql);
	           if(rs.next())
	           {
	        	   info += rs.getInt(1)+" "+rs.getString(2)+" "+rs.getString(3)+" "+rs.getInt(4)+"\n";
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
	       return info;
	}

	@Override
	/**
	 * purchase products by inputting productID,customerID and amount
	 */
	public String purchase(int productID, int customerID, int amount, String url)
			throws RemoteException {
	       try
	       {
	           Connection con = DBUtil.getConnection(url);
	           Statement stmt = con.createStatement();
	           String sql1 = "select * from Products where productID = "+ productID+" and stocklevel >="+amount;
	           ResultSet rs = stmt.executeQuery(sql1);
	           if(rs.next())
	           {
	        	   String sql2 = "update Products set stocklevel = stocklevel-"+amount+" where productID ="+productID;
	        	   String sql3 = "insert into Transactions (productID, customerID, amount) values ("+productID+","+customerID+","+amount+")";
	        	   stmt.executeUpdate(sql2);
	        	   stmt.executeUpdate(sql3);
	        	   
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
	       return "Purchase proceeded";
		
	}

	@Override
	/**
	 * a branch server send a request asking additional stock from product servers.
	 * Input the product ID,requesting amount and the address of loadbalancer
	 */
	public String requestAdditionalStock(int productID, int amount,
			String url) throws RemoteException {
		try {
			boolean isCurrentStockedItem = true;//A flag to identify if this shop stocked this product.If it has,this value is true
			if(findProductbyID(productID,url) == null) isCurrentStockedItem = false;//try to find this item in branch database,if there isn't,set false
			LoadBalancerInterface lb = (LoadBalancerInterface)Naming.lookup("rmi://localhost:39000/LoadBalancerInterface");
			Connection con = DBUtil.getConnection(url);
	        Statement stmt = con.createStatement();
	        String sql = lb.requestAdditionalStock(productID,amount,isCurrentStockedItem);
	        if(sql!=null){
	        stmt.executeUpdate(sql);
	        return "Request proceeded";
	        }
		} catch (MalformedURLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (NotBoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		return null;
	}




}
