<?php
if(isset($_COOKIE['userID'])){ ?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta name = "viewport" content = "width = device-width, initial-scale = 1.0">

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="css/font-awesome.min.css"> 
      <link rel="stylesheet" href="css/nav.css">
      <link rel="stylesheet" href="css/footer.css">
      <link rel="stylesheet" href="css/requests.css">
      <meta charset="utf-8">
      <title>My requests</title>
    </head>

    <body>
      <?php include "php/includes/nav.php"; ?>
      <main class="content">
        <div class="list">
        </div>
      </main>
      <?php include "php/includes/footer.php"; ?>

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <script src="js/nav.js"></script>
      <script src="js/jquery.js"></script>
      <script src="js/cookies.js"></script>
      <script src="js/myrequests.js"></script>
    </body>
  </html>
<?php } else{
  header('HTTP/1.0 403 Forbidden');
}
 ?>
