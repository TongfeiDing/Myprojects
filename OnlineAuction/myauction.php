<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My auction</title>

  <link href="bootstrap.min.css" rel="stylesheet">
  <link href="css/myauction.css" rel="stylesheet">
  <script src="js/myauction.js"></script>
  <script src="js/ajaxfunction.js"></script>
  <script src="js/cookies.js"></script>
  <script src="js/imagesfunction.js"></script>
</head>

<body onLoad="getSelling();">
  <div class="container">
     <div class="row">
       <?php 
         include "nav.php";
       ?>
	       
    </div>
    
    
    <br>
   
    <div class="row"> 
    	
  	  <div class="col-md-3">
  	  
  	  <div class="row">
  	  <div class="col-md-10 col-md-offset-1 imgwrap">
       <!--upload an image-->
        <img id="imageshow" src="img1.jpg" class="img-thumbnail imgmyphoto">
        <h1 id="usernamelab" class="text-center">Hello,dear guest</h1>           
      </div>
      </div>
     
      
        
      <div id="stackednav_left" class="row">
      <ul class="nav nav-pills nav-stacked">
      <li class="active"><a href="#sellingpanel" onClick="getSelling();" data-toggle="pill">Selling</a></li>
      <li class="nav-divider"></li>
      <li><a href="#bidspanel" data-toggle="pill" onClick="getBidding();">Bids</a></li>
      <li class="nav-divider"></li>
      <li><a href="#transactionspanel" onClick="getTransacton();" data-toggle="pill">Transactions</a></li>
      <li class="nav-divider"></li>
      </ul>
      </div>
      
        
          
            
                
      </div>
      
      <div class="col-md-9">
      <br><br>
      
      
        <div class="tab-content">
        
        <div role="tabpanel" class="tab-pane active fade in" id="sellingpanel">
       
        <div class="row">
        <div class="col-md-12 bg-primary">
        <h3>Active items</h3>
        </div>          
        </div>
        <br>       
        <div id="sellinglist" class="list-group">            
        </div>
        
        <div class="row">
        <div class="col-md-12 bg-primary">
        <h3>Sold items</h3>
        </div>     
        </div>
        <br>       
        <div id="solditemlist" class="list-group">            
        </div>
        
        <div class="row">
        <div class="col-md-12 bg-primary">
        <h3>Canceled items</h3>
        </div>     
        </div> 
        <br>      
        <div id="removeditemlist" class="list-group">            
        </div>
    
        
        <div class="row">
        <div class="col-md-12 bg-primary">
        <h3>Unsold items(Overtime)</h3>
        </div>     
        </div>
        <br>       
        <div id="overtimeitemlist" class="list-group">            
        </div>
        
        </div>
        
        <div role="tabpanel" class="tab-pane fade" id="bidspanel">
       
        <div class="row bg-primary">
        <div class="col-md-12 bg-primary">
        <h3>My bids</h3>
        </div>          
        </div>
        <br>
        <div id="mybidlist" class="list-group">            
        </div>
        
        
        </div>
        
        <div role="tabpanel" class="tab-pane fade" id="transactionspanel">
       
        <div class="row">
        <div class="col-md-12 bg-primary">
        <h3>Purchase history</h3>
        </div>          
        </div>
        <br>
        <div id="mytransactionlist" class="list-group">            
        </div>
        
        
        
        </div>
        
        </div>
        
      </div>
      
      </div>
        

    
    
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>
