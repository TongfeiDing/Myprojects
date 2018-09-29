<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My profile</title>

  <link href="bootstrap.min.css" rel="stylesheet">
  <link href="css/myprofile.css" rel="stylesheet">
  <script src="js/myprofile.js"></script>
  <script src="js/ajaxfunction.js"></script>
  <script src="js/cookies.js"></script>
  <script src="js/imagesfunction.js"></script>
</head>

<body onLoad="showUserdetails();">
  <div class="container">
    <div class="row">
       <?php 
         include "nav.php";
       ?>
	       
    </div>
    
    <div class="row"> 	
  	  <div class="col-md-3">
       <!--upload an image-->
       <div class="imgwrap">
        <img id="imageshow" src="img1.jpg" class="img-responsive center-block">
        </div>
        <button type="button" class="btn btn-primary" onClick="selectImages('myphoto');">New photo</button>
        <button type="button" class="btn btn-primary" onClick="uploadImages('myphoto');">Upload</button>
        <input id="myphoto" type="file" style="display:none" onChange="displayImages('imageshow',this);">

        
        
        
      </div>
      <div class="col-md-9">
        <div class="row">
        <h1 id="usernamelab">Hello,dear guest</h1>       
        <h3 id="emaillab"><b>Email </b> </h3>
        <h3 id="phonelab"><b>Phonenumber </b></h3>
        <br> 
        <button type="button" class="btn btn-primary" onClick="showEditform();">Edit details</button>      
        </div>
        
        <div id="editprofile" class="row">            
           <div class="form-group-lg">
                   <h3>Edit profile</h3>
                    <label>Email</label>
                    <input id="email" class="form-control" type="text" disabled="disabled" required autocomplete="off"/>             
                    <br>
                    
                    <label>Username</label>
                    <input id="username" class="form-control" type="text" disabled="disabled" required autocomplete="off"/>             
                    <br>
                    
                    <label>PhoneNo</label>
                    <input id="phone" class="form-control" type="text" required autocomplete="off"/>             
                    <br>
                    
                    <label>Address</label>
                    <input id="address" class="form-control" type="text" required autocomplete="off"/>             
                    <br>
                    
                    <label>First Name</label>
                    <input id="firstname" class="form-control" type="text" required autocomplete="off"/>             
                    <br>
                                       
                    <label>Last Name</label>
                    <input id="lastname" class="form-control" type="text" required autocomplete="off"/>             
                    <br>
                    
                    <h3>Change Password</h3>
                    <label>Password</label>
                    <input id="password" class="form-control" type="password" required autocomplete="off"/>             
                    <br>
                    
                    <label>Confirm Password</label>
                    <input id="confirm" class="form-control" type="password" required autocomplete="off"/>             
                    <br>
                    
                    <button type="button" class="btn btn-primary" onClick="ajaxrequest('php/userdetails.php',passValues(),refreshDetails,null);">submit</button> 
                    <button type="button" class="btn btn-default" onClick="hideEditform();">cancel</button> 
                    <br>
                    

                    
                    </div>


            </div>
            </div>
      </div>
        

    
    
    
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>