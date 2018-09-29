<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

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
            <h1>Registration</h1>
            <div class="input-group-lg">
            
                    <input id="email" class="form-control" type="text" value = "Emailaddress" style="color:gray" onfocus="removePlaceholder(this,'Emailaddress')" onblur="setPlaceholder(this,'Emailaddress')" required autocomplete="off"/>
                               
                    
                    <br>
                    
                    <input id="username" class="form-control" type="text" value = "Username" style="color:gray" onfocus="removePlaceholder(this,'Username')" onblur="setPlaceholder(this,'Username')" required autocomplete="off"/>
                    <br>
                    
                    <input id="phone" class="form-control" type="text" value = "PhoneNo" style="color:gray" onfocus="removePlaceholder(this,'PhoneNo')" onblur="setPlaceholder(this,'PhoneNo')" required autocomplete="off"/>
                    <br>
                    
                    <input id="password" class="form-control" type="text" value = "Password" style="color:gray" onfocus="removePlaceholder(this,'Password')" onblur="setPlaceholder(this,'Password')" required autocomplete="off"/>
                    <br>
                    
                    <div class="checkbox">
                    <label><input type="checkbox" id="agreement" value=""><a href="##" onClick="showAgreement();">I accept the user agreement</a></label>
                    
                    </div>


            </div>

            <div>
            	<button type="button" class="btn btn-primary btn-lg btn-block" onClick="ajaxrequest('php/register.php',registerValues(),register,null);">Register</button>
            </div>
        </div>
        

    </div>
    
    
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>