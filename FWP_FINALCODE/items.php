<!DOCTYPE html>
<html lang="en">
  <head>
	  <style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #mapResult {
        height: 480px;
        width: 100%;
        background-color: #ffffff;
        z-index: 999;
        top: 0;
        vertical-align: middle;
    }
</style>
    <meta charset="utf-8">

    <title>Choosr</title>

    <!-- Bootstrap core CSS -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">

	<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>

    <script src="js/ajaxfunction.js"></script>
    <script src="js/items.js"></script>
    <script src="js/cookies.js"></script>
    <script src="js/nav.js"></script>
    <script src="js/mapfunction.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDi_LpnqrVB_MpxJI2Kb5ROtacP792TG04">
        </script>
      <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/items.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">

  </head>

  <body id="myPage">

    <?php include "php/includes/nav.php"; ?>

<div class="overlay"></div>

<main class="container clearfix">

    <ul class="nav nav-tabs">
        <li id="available" class="active" onClick ="ajaxrequest('php/items.php','action=viewavailable&userID='+getCookie('userID'),'searchResult',3,viewItems)">
        <a href="#">Available</a></li>

        <li id="delivered" onClick ="ajaxrequest('php/items.php','action=viewdelivered&userID='+getCookie('userID'),'searchResult',3,viewItems)">
        <a href="#">Delivered</a></li>

        <li id="removed" onClick ="ajaxrequest('php/items.php','action=viewremoved&userID='+getCookie('userID'),'searchResult',3,viewItems)">
        <a href="#">Removed</a></li>

        <li id="map" class="pull-right"><a href="#mapResult">Map</a></li>
        <li id="list" class="active pull-right"><a href="#searchResult">Item List</a></li>
        <li class="active pull-right" data-toggle="modal" data-target="#itemAdd"><a href="#">Add Items</a></li>
    </ul>


<!-- Modal "itemUpdate"-->
<div id="itemUpdate" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Item</h4>
      </div>

      <div class="modal-body">
        <form class="form-horizontal" id="item-input-elements-formm">
          <div class="form-group">
            <label class="control-label col-sm-3" for="name">Name:</label>
            <div class="col-sm-9">
              <input class="from-modal" type="text" id="name" name="name" placeholder="Enter the name of the food">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="calorie">Calorie:</label>
            <div class="col-sm-9">
              <input class="from-modal" type="text" id="calorie" name="calorie" placeholder="Enter the calorie of the food">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="description">Description:</label>
            <div class="col-sm-9">
              <input class="from-modal" type="text" id="description" name="description" placeholder="Enter the description">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="quantity">Quantity:</label>
            <div class="col-sm-9">
              <input class="from-modal" type="text" id="quantity" name="quantity" placeholder="Enter the quantity of the food">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="bestbeforeDate">Best before date:</label>
            <div class="col-sm-9">
              <input class="from-modal" type="date" id="bestbeforeDate" name="bestbeforeDate">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="picURL">Image:</label>
            <div class="col-sm-9">
              <input class="from-modal" type="file" id="picURL" name="picURL" accept="image/gif, image/jpeg, image/jpg" />
            </div>
          </div>
        </form>

        <from class="form-horizontal">
          <div class="form-group">
            <label class="control-label col-sm-3">Categories:</label>
            <div class="col-sm-9">
              <input type="checkbox" name="check1" id="ch2" value= "Chinese"> Chinese &emsp;
              <input type="checkbox" name="check1" id="ch3" value= "French"> French &emsp;
              <input type="checkbox" name="check1" id="ch6" value= "Italian"> Italian <br>
              <input type="checkbox" name="check1" id="ch7" value= "Japanese"> Japanese &emsp;
              <input type="checkbox" name="check1" id="ch9" value= "Mexican"> Mexican <br>
              <input type="checkbox" name="check1" id="ch4" value= "Fruits and vegetables"> Fruits and vegetables <br>
              <input type="checkbox" name="check1" id="ch14" value= "Vegan"> Vegan &emsp;
              <input type="checkbox" name="check1" id="ch15" value= "Vegetarian"> Vegetarian &emsp;
              <input type="checkbox" name="check1" id="ch8" value= "Low Fat"> Low Fat <br>
              <input type="checkbox" name="check1" id="ch12" value= "Savoury dish"> Savoury dish &emsp;
              <input type="checkbox" name="check1" id="ch13" value= "Sweets"> Sweets <br>
              <input type="checkbox" name="check1" id="ch1" value= "Canned"> Canned &emsp;
              <input type="checkbox" name="check1" id="ch10" value= "Pasta"> Pasta &emsp;
              <input type="checkbox" name="check1" id="ch11" value= "Pizza"> Pizza <br>
              <input type="checkbox" name="check1" id="ch5" value= "Gluten Free"> Gluten Free <br>
              <input type="checkbox" name="check1" id="ch16" value= "Other"> Others <br>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3">Position:</label>
            <div class="col-sm-9">
              <input name="currentposition" id ="currentposition" type="radio" onClick="document.getElementById('inputposition').checked=false;"/>Use current position<br>
              <input name="inputposition" id ="inputposition" type="radio"  onClick="document.getElementById('currentposition').checked=false;"/>Address:<br>
              <input class="from-modal" type="text" name="position" id="position" placeholder="Enter your postcode or city name of your item location">
            </div>
          </div>

          <input type="text" id="hid" value="" hidden>
        </form>

      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-default" onClick ="update()" class="actionButton">Update</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal for add function -->
<div id="itemAdd" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Item</h4>
      </div>

      <div class="modal-body">
        <form class="form-horizontal" id="item-input-elements-form">
          <div class="form-group">
            <label class="control-label col-sm-3" for="name">Name:</label>
            <div class="col-sm-9">
              <input class="from-modal" type="text" id="name" name="name" placeholder="Enter the name of the food">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="calorie">Calorie:</label>
            <div class="col-sm-9">
              <input class="from-modal" type="text" id="calorie" name="calorie" placeholder="Enter the calorie of the food">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="description">Description:</label>
            <div class="col-sm-9">
              <input class="from-modal" type="text" id="description" name="description" placeholder="Enter the description">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="quantity">Quantity:</label>
            <div class="col-sm-9">
              <input class="from-modal" type="text" id="quantity" name="quantity" placeholder="Enter the quantity of the food">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="bestbeforeDate">Best before date:</label>
            <div class="col-sm-9">
              <input class="from-modal" type="date" id="bestbeforeDate" name="bestbeforeDate">
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3" for="picURL">Image:</label>
            <div class="col-sm-9">
              <input class="from-modal" type="file" id="picURL" name="picURL" accept="image/gif, image/jpeg, image/jpg" />
            </div>
          </div>
        </form>

        <from class="form-horizontal">
          <div class="form-group">
            <label class="control-label col-sm-3">Categories:</label>
            <div class="col-sm-9">
              <input type="checkbox" name="check1" id="ch2" value= "Chinese"> Chinese &emsp;
              <input type="checkbox" name="check1" id="ch3" value= "French"> French &emsp;
              <input type="checkbox" name="check1" id="ch6" value= "Italian"> Italian <br>
              <input type="checkbox" name="check1" id="ch7" value= "Japanese"> Japanese &emsp;
              <input type="checkbox" name="check1" id="ch9" value= "Mexican"> Mexican <br>
              <input type="checkbox" name="check1" id="ch4" value= "Fruits and vegetables"> Fruits and vegetables <br>
              <input type="checkbox" name="check1" id="ch14" value= "Vegan"> Vegan &emsp;
              <input type="checkbox" name="check1" id="ch15" value= "Vegetarian"> Vegetarian &emsp;
              <input type="checkbox" name="check1" id="ch8" value= "Low Fat"> Low Fat <br>
              <input type="checkbox" name="check1" id="ch12" value= "Savoury dish"> Savoury dish &emsp;
              <input type="checkbox" name="check1" id="ch13" value= "Sweets"> Sweets <br>
              <input type="checkbox" name="check1" id="ch1" value= "Canned"> Canned &emsp;
              <input type="checkbox" name="check1" id="ch10" value= "Pasta"> Pasta &emsp;
              <input type="checkbox" name="check1" id="ch11" value= "Pizza"> Pizza <br>
              <input type="checkbox" name="check1" id="ch5" value= "Gluten Free"> Gluten Free <br>
              <input type="checkbox" name="check1" id="ch16" value= "Other"> Others <br>
            </div>
          </div>

          <div class="form-group">
            <label class="control-label col-sm-3">Position:</label>
            <div class="col-sm-9">
              <input name="currentposition" id ="currentposition2" type="radio" onClick="document.getElementById('inputposition').checked=false;"/>Use current position<br>
              <input name="inputposition" id ="inputposition2" type="radio"  onClick="document.getElementById('currentposition').checked=false;"/>Address:<br>
              <input class="from-modal" type="text" name="position" id="position2" placeholder="Enter your postcode or city name of your item location">
            </div>
          </div>

        </form>

      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-default" onClick ="add()" class="actionButton">Add item</button>
      </div>
    </div>

  </div>
</div>


<div id="itemRemove" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center">Do you want to remove this item?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onClick="remove()">Remove</button>
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <input type="text" id="rhid" value="" hidden>
      </div>
    </div>

  </div>
</div
    <div class="tab-content">
        <div id="searchResult">

        </div>

        <div id="mapResult" hidden>



        </div>

    </div>

</main>



<?php include "php/includes/footer.php"; ?>


<script src="js/indexitems.js"></script>
<script>
$(document).ready(function(){
   ajaxrequest('php/items.php','action=viewavailable&userID='+getCookie('userID'),'searchResult',3,viewItems)

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

  $(document).on("click", ".open-updateModal", function (){
      var itemID = $(this).data('id');
      $("#hid").val(itemID);
  });

  $(document).on("click", ".open-removeModal", function (){
      var itemID = $(this).data('id');
      $("#rhid").val(itemID);
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
