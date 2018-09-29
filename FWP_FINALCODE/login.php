<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/login.css" >
  <link rel="stylesheet" href="css/nav.css" >
  <link rel="stylesheet" href="css/footer.css" >

</head>

<body>
  <?php include "php/includes/nav.php"; ?>
  <main class="form">
    <div id="login">
      <h1>Welcome Back!</h1>
      <form action="/" method="post">
        <div class="field-wrap">
          <label class="active">Email Address/Username<span class="req">*</span></label>
          <input id = "user" type="email" required autocomplete="off"/>
        </div>

        <div class="field-wrap">
          <label class="active">Password<span class="req">*</span></label>
          <input id = "password2" type="password" required autocomplete="off"/>
        </div>

      </form>

        <button class="button button-block" type="button" onClick="ajaxrequest('php/login.php',loginValues(),null,3,loginCheck)"/>LOGIN</button>

        <p>You do not have an account? Register <a href="register.php">here</a></p>
    </div>
  </main><!-- tab-content -->
  <?php include "php/includes/footer.php"; ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/ajaxfunction.js"></script>
  <script src="js/cookies.js"></script>
  <script src="js/nav.js"></script>
  <script src="js/login.js"></script>
</body>

</html>
