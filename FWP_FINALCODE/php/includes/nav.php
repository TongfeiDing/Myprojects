<nav class="navbar navbar-default" id="navlogin">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">CHOOSR</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-left">
          <li><a href="search.php" id="items-menu-option">Search</a></li>
          <li class="needed-login"><a href="items.php">My Items</a></li>
          <li class="needed-login"><a href="chat.php" id="chat-menu-option">Chat</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="no-needed-login"><a href="login.php">LOGIN</a></li>
          <li class="needed-login"><a class="dropdown-toggle" data-toggle="dropdown" href="#" id="uid"></a>
            <ul class="dropdown-menu">
              <li><a href="myprofile.php">USER PROFILE</a></li>
              <li><a href="myrequests.php">VIEW TRANSACTIONS</a></li>
              <li><a href="recommendations.php">WASTAGE ANALYSIS</a></li>
              <li><a href="#" id="usr">LOG OUT</a></li>
            </ul>
          </li>
         </ul>
      </div>
    </div>
</nav>
