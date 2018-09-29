<?php
//First check if the cookie is defined (i.e., if the user has sign in)
if(isset($_COOKIE['userID'])){
echo '
  
 <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                     
        </button>
        <a class="navbar-brand" href="index.php">HOME</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-left">
          <li><a href="search.html">FOOD</a></li>
          <li><a href="chat.php">CHAT</a></li> 
        </ul>
        <ul class="nav navbar-nav navbar-right">';

    echo '<li><a class="dropdown-toggle" data-toggle="dropdown" href="#">',$_COOKIE['username'],
         '<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="myprofile.php">PROFILE</a></li>
              <li><a href="items.html">MANAGE ITEMS</a></li>
            </ul>
          </li> 

         <li id="usr"><a href="#">LOG OUT</a></li>
         </ul>
      </div>
    </div>
  </nav> 
  
  <script>
  $(function(){
        
        $("#usr").click(function(){
          setCookie("userID","",-1);
          setCookie("username","",-1);
          setCookie("image","",-1);
          window.location.href = "index.php";
        })
        

      })
  </script>
  ';


/*
<script src="../js/cookies.js"></script>

<script>
var id = getCookie('userID');
$("#usr").append(id);
</script>
*/

   } else { 
echo '
  <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                      
        </button>
        <a class="navbar-brand" href="index.php">HOME</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-left"> 
          <li><a href="#about">INTRO</a></li>
          <li><a href="#contact">CONTACT</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li id="usr"><a href="login_signup.html">SIGN UP/LOGIN</a></li>     
        </ul>
      </div>
    </div>
  </nav> ';
 
  //If there is no cookie, show a 403 error
  //header('HTTP/1.0 403 Forbidden');
}

 ?>