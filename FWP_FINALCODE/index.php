<!DOCTYPE html>
<html lang="en">

<head>
  <title>Choosr</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/nav.css">
  <link rel="stylesheet" href="css/footer.css">
</head>

<body id="myPage" data-offset="15">

<?php include "php/includes/nav.php"; ?>

<div class = "jumbotron">
	<div class="text-center jumbotron-overlay">
  <h1>Choosr</h1>
  <p>Community Food Sharing System</p>

  <div class="container">
    <div class="row">
      <div class="col-sm-2">
      </div>

      <div class="col-sm-4">

      </div>

      <div class="col-sm-4">

      </div>

      <div class="col-sm-2">
      </div>
    </div>

  </div>
</div>
</div>

<main>
<!-- Container (About Section) -->
  <div id="about" class="container-fluid">
    <div class="row">
      <div class="col-sm-8">
        <h2>About Choosr</h2><br>
        <h4>Best food sharing program in the UK</h4><br>
        <p>We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.We got everything you want.</p>
      </div>
      <div class="col-sm-4">
        <img src="images/logo.png" class="img-rounded img-responsive" alt="Cinque Terre">
      </div>
    </div>
  </div>

  <div class="container-fluid bg-grey">
    <div class="row">
      <div class="col-sm-4">
        <img src="images/pizza.jpg" class="img-rounded img-responsive" alt="Cinque Terre">
      </div>
      <div class="col-sm-8">
        <h2>Product offered</h2><br>
        <h4><strong>FOOD:</strong> Various type of food donated and uploaded by users.</h4><br>
        <h4><strong>SERVICE:</strong> Online chat system to negotiate your food trasaction.</h4>
      </div>
    </div>
  </div>

  <!-- Container (Contact Section) -->
  <div id="contact" class="container-fluid">
    <h2 class="text-center">CONTACT</h2>
    <div class="row">
      <div class="col-sm-5">
        <p>Contact us and we'll get back to you within 24 hours.</p>
        <p><span class="glyphicon glyphicon-map-marker"></span> Durham, UK</p>
        <p><span class="glyphicon glyphicon-phone"></span> +44 01234 012345</p>
        <p><span class="glyphicon glyphicon-envelope"></span> yuancheng.miao@dur.ac.uk</p>
      </div>
      <div class="col-sm-7 slideanim">
        <div class="row">
          <div class="col-sm-6 form-group">
            <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
          </div>
          <div class="col-sm-6 form-group">
            <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
          </div>
        </div>
        <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br>
        <div class="row">
          <div class="col-sm-12 form-group">
            <button class="btn btn-default pull-right" type="submit">Send</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>
<div class="to-top text-center container-fluid">
  <a href="#myPage" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
</div>

<?php include "php/includes/footer.php"; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/cookies.js"></script>
<script src="js/nav.js"></script>
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links in navbar + footer link
  $(".nav a, .navbar a, footer a[href='#myPage']").on('click', function(event) {

   // Make sure this.hash has a value before overriding default behavior
  if (this.hash !== "") {

    // Prevent default anchor click behavior
    event.preventDefault();

    // Store hash
    var hash = this.hash;

    // Using jQuery's animate() method to add smooth page scroll
    // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
    $('html, body').animate({
      scrollTop: $(hash).offset().top
    }, 900, function(){

      // Add hash (#) to URL when done scrolling (default click behavior)
      window.location.hash = hash;
      });
    } // End if
  });

 $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });

})
</script>

</body>

</html>
