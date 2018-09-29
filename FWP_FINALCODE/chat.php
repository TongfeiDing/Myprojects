<?php
//First check if the cookie is defined (i.e., if the user has sign in)
if(isset($_COOKIE['userID'])){?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
  <head>
    <title>Choosr Chat</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/chat.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
  </head>

<body class="wrapper">
  <?php include "php/includes/nav.php";?>
  <main class="wrapper">
    <nav id="sidebar">
      <div class="sidebar-header">
        <h3>Current chats</h3>
      </div>

      <ul class="list-unstyled components" id="contacts"></ul>
    </nav>

    <div id="content">
      <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
          <i class="glyphicon glyphicon-align-left"></i>
          Chats
      </button>

      <div class="box">

        <div class="messages-area"></div>

        <form class="send-message flex-row" role="form">
          <div class="input-group-lg input-group">
            <input type="text" class="form-control" id="message-to-send" />
            <span class="input-group-addon" id="send-button" disabled>Send</span>
          </div>
        </form>

      </div>


    </div>

  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/cookies.js"></script>
  <script src="js/nav.js"></script>
  <script src="js/jquery.js"></script>
  <script src="js/chat.js"></script>
  </body>
  </html>

<?php } else {
  //If there is no cookie, show a 403 error
  header('HTTP/1.0 403 Forbidden');
}

 ?>
