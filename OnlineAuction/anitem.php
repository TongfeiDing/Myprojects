<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Item details</title>

  <link href="bootstrap.min.css" rel="stylesheet">
  <link href="css/anitem.css" rel="stylesheet">
  
  <script src="js/anitem.js"></script>
  <script src="js/ajaxfunction.js"></script>
  <script src="js/cookies.js"></script>
  <script src="js/imagesfunction.js"></script>
</head>

<body onLoad="ajaxrequest('php/items.php',findItem(),createItemPage,null);">
  <div class="container">
     <div class="row">
       <?php 
         include "nav.php";
       ?>
	       
    </div>
    
    <br>
   
    <div class="row">
     
    <div class="col-md-4">
    
    <div id="myCarousel" class="carousel slide">
    
    <ol id="carousel-indicators" class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>

    </ol>   

    <div id="carousel-inner" class="carousel-inner">
        <div class="item active">
            <img src="img1.jpg" alt="First slide">
        </div>
 
        
    </div>

    <a class="carousel-control left" href="#myCarousel" 
       data-slide="prev"> <span _ngcontent-c3="" aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span></a>
    <a class="carousel-control right" href="#myCarousel" 
       data-slide="next">&rsaquo;</a>
</div>
   	
   	<br>
   	<div class="col-md-12 bg-info">
   	<h3><b>Auction Principles</b></h3>
   	<p id="auctionintroduction"></p>
   	</div>
    	
    </div>
    
    <div class="col-md-5">
      <h1 id="titleitemname">Itemname</h2>
      
      	<h4 id="auctiontype">Auction Type: </h4>
      	
      	<h4 id="uploadtime">Update on </h4>
      	
      	<h4 id="timeleft"><b>24h</b> left</h4>
      	
      	<h4><b>Categories:</b></h4>
      	
      	
      	<div id="categories"></div>
      	<br>
      	<h3 id="price">Price: $</h3> 
      	<div id="biddingarea" class="row">   	
      	<div class="col-md-8">
      	<input id="mybid" class="form-control" type="text">
      	</div>
      	<div class="col-md-4">
      	<button id="btn_bid" type="button" class="btn btn-primary btn-block" onClick="bid();">Bid</button>
      	</div>
      	
      	</div>
      	
      	<h4>Description: </h4>
      	<p id="description"></p>	
      		
      	
      </div>
      
    <div class="col-md-3 bg-info">
     		<h3><b>Seller Information</b></h3>
     		<h4 id="sellername">USER1</h4>
     		<h4 id="selleremail">Email</h4>
      		
    </div>
    </div>
    
    <div class="row">
    
    <div class = "col-md-12">
    <h2>Comments</h2>
       <div class="row">
       <div class="col-md-10">
        <input id="mycomment" type="text" class="form-control">                                           
       </div>
       
       <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block" onClick="submitcomment();">Submit</button>
       </div>
       </div>
       <br> 
    <div id="comments" class="list-group">
    	
    </div>
    </div>
    </div>
    
 
    

    

    	
  	  
        
        
    

        

    
    
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>
