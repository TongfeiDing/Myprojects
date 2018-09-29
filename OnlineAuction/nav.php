<nav class="navbar navbar-default" role="navigation">   
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><b>My OnlineAuction</b></a>
    </div>
    <div>
        <ul class="nav navbar-nav navbar-left">
            <li><a href="itemlist.php">Search items</a></li>
      
        </ul>
        
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <?php
					if(isset($_COOKIE['username'])){
					  echo 'Hi,'.$_COOKIE['username'];}
					else echo 'Hi,dear guest'
					?>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                   <?php 
					  if(isset($_COOKIE['username'])){
						  echo '<li><a href="myprofile.php">My Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="myauction.php">My Auction</a></li>
                    <li class="divider"></li>
					 <li><a href="newitem.php">Sell an item</a></li>
					  <li class="divider"></li>
                    <li><a href="##" onClick=logout();>Log out</a></li>';
					  }
					
					  else{
						  echo '<li><a href="login.php">Sign in</a></li>';
					  }
					?>

                </ul>
            </li>


        </ul>
    </div>
    
    
    <script type="text/javascript">
		function logout(){
		if(confirmLogout()){
		setCookie('userID','',0);
		setCookie('username','',0);
		setCookie('firstname','',0);
		setCookie('lastname','',0);
		setCookie('address','',0);
		setCookie('email','',0);
		setCookie('phone','',0);
		setCookie('image','',0);
		window.location.href="itemlist.php";
		}
		}
		
		function confirmLogout(){
			var r=confirm("You are going to sign out ");
			if (r==true){
				return true;
			}
			else{
				return false;
			}
		}
	</script>
    
</nav>
