

import java.net.MalformedURLException;
import java.rmi.Naming;
import java.rmi.NotBoundException;
import java.rmi.RemoteException;
import java.util.Scanner;


/**
 * The Client(run on commandline)
 * 
 * @Tongfei Ding
 * @1.0
 */

public class Client {
	     static String bsaddress;
	     static String dbaddress;

	     public static void main(String[] args) {

	    		//the server that this client is now talking to
	    	    Client client = new Client();	    	   
	    	    String com;
	    	    int productID,customerID,amount;
		        try {		        	 
		        	 client.chooseServer();//please ensure the server has started,choose a branch to talk to 		        	 
		        	 BranchInterface b = (BranchInterface) Naming.lookup(bsaddress);
		        	 LoadBalancerInterface lb = (LoadBalancerInterface) Naming.lookup("rmi://localhost:39000/LoadBalancerInterface");
		        	 while(true){// the main menu, after finishing a task,return to the menu and wait for next operation
		        		 System.out.println("\n"+b.sayHi()+"\n");//greeting from the server
		    	    	 System.out.println("Choose a function:");
		    	    	 System.out.println("1.Show this branch's stock of all products");
		    	    	 System.out.println("2.Show a product's information by inputting ID");
		    	    	 System.out.println("3.Show a customer's information and purchase history by inputting ID");
		    	    	 System.out.println("4.Proceed a transaction");
		    	    	 System.out.println("5.Show the HQ's stock of all products");
		    	    	 System.out.println("6.Request additional stock from HQ");
		    	    	 System.out.println("7.Exit the system");
		    	    	 Scanner s = new Scanner(System.in);
		    	    	 com = s.nextLine();
		    	    	 
		        		 if(com.equals("1")){
		        			 System.out.println("Stock list of this shop:");
		        			 System.out.printf(b.showStock(dbaddress));
		        		 }
		        		 else if(com.equals("2")){
		        			 System.out.println("Please input a productID:");
		        			 productID = s.nextInt();
		        			 String re = b.findProductbyID(productID, dbaddress);
		        			 if(re!=null)System.out.printf(re);		        			 
		        			 else System.out.println("This product cannot be found in this shop");
		        		 }
		        		 else if(com.equals("3")){
		        	    	 System.out.println("Please input a customerID:");
		        	    	 customerID = s.nextInt();
		        	    	 String re = b.findCustomerbyID(customerID, dbaddress);
		        	    	 if(re!=null)System.out.printf(re);
		        	    	 else System.out.println("Customer doesn't exist!");
		        	     }
		        		 else if(com.equals("4")){
		        			 System.out.println("Please input a productID:");
		        			 productID = s.nextInt();
		        	    	 System.out.println("Please input a customerID:");
		        	    	 customerID = s.nextInt();
		        	    	 System.out.println("Please input the amount of products in this purchase:");
		        	    	 amount = s.nextInt();
		        	    	 String re = b.purchase(productID, customerID, amount, dbaddress);
		        	    	 if(re!=null)System.out.printf(re);
		        	    	 else System.out.println("Not enough stock or the product doesn't exist.Please request additional stock from HQ");
		        	    	 
		        		 }
		        		 else if(com.equals("5")){
		        			 System.out.println("stock list of HQ:");
		        			 System.out.printf(lb.showHQStock());
		        		 }
		        		 else if(com.equals("6")){
		        			 System.out.println("Please input a productID:");
		        			 productID = s.nextInt();
		        	    	 System.out.println("Please input the amount of products you want to request from HQ:");
		        	    	 amount = s.nextInt();
		        	    	 String re = b.requestAdditionalStock(productID,amount,dbaddress); 
		        	    	 if(re!=null)System.out.printf(re);
		        	    	 else System.out.println("The HQ server doesn't stock this product or doesn't have enough products");
		        			 
		        		 }
		        		 else if(com.equals("7")){
		        	    	 System.out.println("The client is closed now");
		        	    	 break;
		        	     }
		        	     else System.out.println("Invalid input,please try again");
		        		 com = null;
		        		 productID = 0;
		        		 customerID = 0;
		        		 amount = 0;
		        			
		        	 }
		             
		             
		        } catch (MalformedURLException e) {   
		             e.printStackTrace();
		        } catch (RemoteException e) {
		             e.printStackTrace();
		         } catch (NotBoundException e) {
		             e.printStackTrace();
		         }
		    }
	     public void chooseServer(){
	    	 System.out.println("Welcome,please choose a branchserver to access!");
	         System.out.println("1.BranchServerA\n2.BranchServerB");
	         Scanner s = new Scanner(System.in);
	         String com = s.nextLine();
	            if(com.equals("1")){
	            	bsaddress = "rmi://localhost:1099/BranchInterface"; 
	            	dbaddress = "jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaBranchA";
	            	System.out.println("ServerA is chosen");
	            		            	
	            }
	            else if(com.equals("2")){
	            	bsaddress = "rmi://localhost:38001/BranchInterface"; 
	            	dbaddress = "jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaBranchB";
	            	System.out.println("ServerB is chosen");
	            	
	            }
	            
	            else {
	            	System.out.println("Invalid input,please try again");
	            	chooseServer();
	            }
	    
	    	 
	     }


}
