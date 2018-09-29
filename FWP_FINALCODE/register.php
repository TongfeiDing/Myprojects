<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sign up</title>

  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/register.css" >
  <link rel="stylesheet" href="css/nav.css" >
  <link rel="stylesheet" href="css/footer.css" >

</head>

<body>
  <?php include "php/includes/nav.php"; ?>
  <main class="form">
    <div id="signup">
      <h1>Sign Up for Free</h1>
      <form action="/" method="post">
        <div class="top-row">
          <div class="field-wrap">
            <label class="active">First Name<span class="req">*</span></label>
            <input id="firstname" type="text" required autocomplete="off"/>
          </div>

          <div class="field-wrap">
            <label class="active">Last Name<span class="req">*</span></label>
            <input id="lastname" type="text" required autocomplete="off"/>
          </div>
        </div>

        <div class="field-wrap">
          <label class="active">Email Address<span class="req">*</span></label>
          <input id="email" type="email" required autocomplete="off"/>
        </div>

        <div class="field-wrap">
          <label class="active">Set A Username<span class="req">*</span></label>
          <input id="username" type="text" required autocomplete="off"/>
        </div>

        <div class="field-wrap">
          <label class="active">Set A Password<span class="req">*</span></label>
          <input id="password" type="password" required autocomplete="off"/>
        </div>

        <div class="field-wrap">
          <label class="active">Address<span class="req">*</span></label>
          <input id="address" type="text" required autocomplete="off"/>
        </div>

        <div class="field-wrap">
          <label class="active">Phone Number<span class="req">*</span></label>
          <input id="phoneNo" type="text" required autocomplete="off"/>
        </div>

      </form>

        <div class="field-wrap-agreement">
          <input type="checkbox" name="agree" id="agreement">
          <a href="agreement.html">I agree with this user agreement<span class="req">*</span></a>

        </div>
        <button class="button button-block" type="button" onClick="inputCheck()"/>GET STARTED</button>

  </div>
  </main><!-- tab-content -->
  <?php include "php/includes/footer.php"; ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/ajaxfunction.js"></script>
  <script src="js/cookies.js"></script>
  <script src="js/nav.js"></script>
  <script src="js/register.js"></script>
</body>

</html>
