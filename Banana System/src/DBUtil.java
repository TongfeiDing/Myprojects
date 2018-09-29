
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.*;
/**
 * Mysql database connector class
 * 
 * @Tongfei Ding
 * @1.0
 */
public class DBUtil
{
   // database connection paramaters
    private static String driverClass="com.mysql.jdbc.Driver";
    private static String username="wmrn68"; 
    private static String password="madr33id";
    private static Connection conn; 
    /**
     * Install database driver
     */
    static{ 
        try{ 
             Class.forName(driverClass); 
        }
        catch(ClassNotFoundException e){ 
             e.printStackTrace();
            }
        } 
    /**
     * Create a database connection
     */
    public static Connection getConnection(String url){
    	try{
        	conn=DriverManager.getConnection(url,username,password);
        	}
        catch(SQLException e){e.printStackTrace();
        }
    	return conn;
          }
    /**
     * Test link to database
     */
   /* public static void main(String[] args){
    	Connection conn=DBUtil.getConnection(args[0]); 
        if(conn==null){ 
            System.out.println("Connection failed£¡");
            }
        }*/
    /**
     * Close a connection
     */
    public static void Clse(){
    	if(conn!=null){
    		try{
    			conn.close();
    			}
    		catch(SQLException e){
    			e.printStackTrace();
    			}
    		}
    	}
}

