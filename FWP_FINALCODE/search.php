<!DOCTYPE html>
<html lang="en">

<head>
    <title>Choosr Item Search</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Custom styles for this template -->



    <script src="js/cookies.js"></script>
    <script src="js/nav.js"></script>
    <script src="js/ajaxfunction.js"></script>
    <script src="js/search.js"></script>
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/nav.css" rel="stylesheet">
    <link href="css/footer.css" rel="stylesheet">
    <link href="css/search.css" rel="stylesheet">

    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #mapResult {
            height: 480px;
            width: 640px;
            background-color: #ffffff;
            z-index: 999;
            top: 0;

        }
    </style>

</head>

<body id="myPage">
<?php include "php/includes/nav.php"; ?>
<main class="container">
    <div class="row">
        <div class="col-md-3">
            <h2 style="display: inline;">Search</h2>
            <a class="btn btn-primary" data-toggle="collapse" href="#collapsibleSearch"
            role="button" aria-expanded="false" aria-controls="collapseExample" id="cbutton">
              <span class="caret"></span>
            </a>
            <div class="collapse navbar-collapse" id="collapsibleSearch">
              <label>Keyword</label>
              <div>
                  <!-- enter keyword -->
                  <input type="text" name="keyword" id="receivedword" placeholder="Enter keyword" style="color:gray"
                         required autocomplete="off"/>
              </div>
              <hr>
              <label>Select Categories</label>
              <div>
                  <div id="cat-selectors"> <!--choose 3 categories  -->

                  </div>
                  <hr>
                  <div>
                      <!-- checkbox to choose use distance limit or not -->
                      <input type="checkbox" name="distancelimit" id="positioncheckbox" onchange="activateDistance()"/>
                      Use Distance Filter<br>
                      <!-- enter distance limit -->
                      <input type="text" name="keyword" id="distancelimit" value="Distance Limit" style="color:gray"
                             onfocus="if(this.value=='Distance Limit'){this.value=''};this.style.color='black';"
                             onblur="if(this.value==''||this.value=='Distance Limit'){this.value='Distance Limit';this.style.color='gray';}"
                             required autocomplete="off" disabled/>
                  </div>
                  <hr>
                  <div class="btn-group-vertical">
                      <!-- a button to view all items -->
                      <button type="button"
                              onClick="ajaxrequest('php/search.php','','searchResult',3,viewItems)"
                              class="actionButton btn btn-info">View All Items
                      </button>
                      <!-- a button to use search function-->
                      <button type="button"
                              onClick="search();"
                              class="actionButton btn btn-info">Search
                      </button>
                  </div>
              </div>
              <hr>
            </div>


        </div>
        <div class="col-md-9 clearfix">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#searchResult">Search Result</a></li>
                <li><a href="#mapResult">Map Result</a></li>
            </ul>
            <div class="tab-content">
                <!-- the div to display listing result  -->
                <div id="searchResult">
                </div>
                <!-- the div to display map -->
                <div id="mapResult" hidden>
                </div>
            </div>
            <script src="js/index.js"></script>
        </div>
    </div>
</main>

<div class="modal fade" tabindex="-1" role="dialog" id="user-info-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body clearfix">
        <div class="container-picture">
          <div class="profile-picture"></div>
        </div>
        <div class="container-user-info">
          <div class="name">Alan Zhu</div>
          <user class="phone">99999999</user>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="request-item-modal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Request item</h4>
      </div>
      <div class="modal-body clearfix">
        <p>Are you sure you want to request this item <span class="item-to-request"></span>?</p>
      </div>
      <div class="modal-footer">
        <button id="request-button" class="btn btn-primary" type="button">Request</button>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>

<?php include "php/includes/footer.php"; ?>

<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
</script>
<script src="js/mapfunction.js"></script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDi_LpnqrVB_MpxJI2Kb5ROtacP792TG04">
</script>


<script>
$(document).ready(function(){
   ajaxrequest('php/search.php','','searchResult',3,viewItems)

  // Add smooth scrolling to all links in navbar + footer link
  $("footer a[href='#myPage']").on('click', function(event) {

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
