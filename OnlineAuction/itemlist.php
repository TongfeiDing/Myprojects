<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search result</title>

  <link href="bootstrap.min.css" rel="stylesheet">
  <script src="js/itemlist.js"></script>
  <script src="js/ajaxfunction.js"></script>
  <script src="js/cookies.js"></script>
</head>

<body onLoad="ajaxrequest('php/items.php','action=viewcas&userID=0',getCategorylist,null);">
  <div class="container">
       <div class="row">
       <?php 
         include "nav.php";
       ?>
	       
    </div>
   
   
    <div class="row">
       <div class="col-md-10">
        <input id="keyword" type="text" class="form-control" value = "Everything" style="color:gray" onfocus="removePlaceholder(this,'Everything')" onblur="setPlaceholder(this,'Everything')">                                           
       </div>
       
       <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-block" onClick="searchItems(null);">Search</button>
       </div>
  </div>
    
    <div class="row">
        	
  		<div class="col-md-3">
            <h1>Auction Types</h1>
            <ul class="list-group">
             <li class="list-group-item"><a href="##" value="0" onClick="ajaxrequest('php/items.php','action=viewbyat&userID='+getCookie('userID')+'&auctiontype=0',createList,null);"><b>Ebay Auction</b></a></li>
             <li class="list-group-item"><a href="##" value="1" onClick="ajaxrequest('php/items.php','action=viewbyat&userID='+getCookie('userID')+'&auctiontype=1',createList,null);"><b>Vickrey Auction</b></a></li>
             <li class="list-group-item"> <a href="##" value="2" onClick="ajaxrequest('php/items.php','action=viewbyat&userID='+getCookie('userID')+'&auctiontype=2',createList,null);"><b>Dutch Auction</b></a></li>
             </ul>
            
            
           
            <h1>Shop by Category</h1>
             <ul id="defaultcategories" class="list-group">
             </ul>
            
             
             
            


        </div>
         		
        <div class="col-md-9">
            <h1>Search Result</h1>
            <div id="resultlist" class="list-group">
            

            </div>
            


        </div>
        

    </div>
    
    
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="css/itemlist.css" rel="stylesheet">

</body>
</html>
