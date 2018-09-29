<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign in/Sign up</title>

  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/login_signup.css" >
  <link rel="stylesheet" href="css/nav.css" >
  <link rel="stylesheet" href="css/footer.css" >
</head>

<body>
  <?php include "php/includes/nav.php"; ?>
  <main class="form">
    <ul class="tab-group">
      <li class="tab active"><a href="#signup">SIGN UP</a></li>
      <li class="tab"><a href="#login">LOGIN</a></li>
    </ul>
    <div class="tab-content">
      <div id="signup">
        <h1>Sign Up for Free</h1>
        <form action="/" method="post">
          <div class="top-row">
            <div class="field-wrap">
              <label>First Name<span class="req">*</span></label>
              <input id="firstname" type="text" required autocomplete="off"/>
            </div>

            <div class="field-wrap">
              <label>Last Name<span class="req">*</span></label>
              <input id="lastname" type="text" required autocomplete="off"/>
            </div>
          </div>

          <div class="field-wrap">
            <label>Email Address<span class="req">*</span></label>
            <input id="email" type="email" required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>Set A Username<span class="req">*</span></label>
            <input id="username" type="text" required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>Set A Password<span class="req">*</span></label>
            <input id="password" type="password" required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>Address<span class="req">*</span></label>
            <input id="address" type="text" required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>Phone Number<span class="req">*</span></label>
            <input id="phoneNo" type="text" required autocomplete="off"/>
          </div>

        </form>

          <div class="field-wrap">
		  <input type="checkbox" name="agree" id="agreement">
            <a href="agreement.html">I agree with this user agreement<span class="req">*</span></a>

          </div>
          <button class="button button-block" type="button" onClick="inputCheck()"/>GET STARTED</button>

    </div>

      <div id="login">
        <h1>Welcome Back!</h1>
        <form action="/" method="post">
          <div class="field-wrap">
            <label>Email Address/Username<span class="req">*</span></label>
            <input id = "user" type="email" required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label>Password<span class="req">*</span></label>
            <input id = "password2" type="password" required autocomplete="off"/>
          </div>

        </form>

          <button class="button button-block" type="button" onClick="ajaxrequest('php/login.php',loginValues(),null,3,loginCheck)"/>LOGIN</button>

      </div>

    </div><!-- tab-content -->

  </main> <!-- /form -->
  <?php include "php/includes/footer.php"; ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/ajaxfunction.js"></script>
  <script src="js/cookies.js"></script>
  <script src="js/nav.js"></script>
  <script src="js/login_signup.js"></script>
</body>

</html>
