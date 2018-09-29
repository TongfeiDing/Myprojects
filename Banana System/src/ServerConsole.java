


public class ServerConsole {
	public static BranchServer bsA = new BranchServer("BranchA",1099,"jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaBranchA");
    public static BranchServer bsB = new BranchServer("BranchB",38001,"jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaBranchB");
    public static LoadBalancer LB = new LoadBalancer("LoadBalancer",39000,null);
    public static HQServer psA = new HQServer("ProductServerA",38002,"jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaPSA");
    public static HQServer psB = new HQServer("ProductServerB",38003,"jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaPSB");
    public static HQServer psC = new HQServer("ProductServerC",38004,"jdbc:mysql://mysql.dur.ac.uk/Xwmrn68_BananaPSC");
	
	 public static void main(String[] args){
		 new ServerGUI();//make a GUI frame
     }

}
