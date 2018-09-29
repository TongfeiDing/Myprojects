<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

  <link href="bootstrap.min.css" rel="stylesheet">
  <style>body 
	  {
		  background-repeat:no-repeat;
		  text-align: center; 
		  background-size: cover;
		  width: 100%;
	  }</style>
  <script src="js/login.js"></script>
  <script src="js/ajaxfunction.js"></script>
  <script src="js/cookies.js"></script>
</head>

<body background="img1.jpg">
  <div class="container">
    <div class="row"> 	
  		<div class="col-md-6 col-md-offset-3">
            <h1>Welcome Back!</h1>
            <div class="input-group-lg">
                    <input id="user" class="form-control" type="text" value = "Emailaddress/Username" style="color:gray" onfocus="removePlaceholder(this,'Emailaddress/Username')" onblur="setPlaceholder(this,'Emailaddress/Username')" required autocomplete="off"/>
                    <br>
                    
                    <input id="password" class="form-control" type="text" value = "Password" style="color:gray" onfocus="removePlaceholder(this,'Password')" onblur="setPlaceholder(this,'Password')" required autocomplete="off"/>
                    <br>
                    
                    <div class="checkbox">
                    <label><input type="checkbox" value="">Remember me
                    </label>
                    </div>

                    
                    <a href="register.php">Go to register a new account now</a>
                    <br>
            </div>

            <div>
            	<button type="button" class="btn btn-primary btn-lg btn-block" onClick="ajaxrequest('php/login.php',loginValues(),login,null);">Login</button>
            </div>
        </div>
        

    </div>
    
    
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>