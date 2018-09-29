<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload a new item</title>

  <script src="js/newitem.js"></script>
  <script src="js/ajaxfunction.js"></script>
  <script src="js/imagesfunction.js"></script>
  <script src="js/cookies.js"></script>
</head>

<body onLoad="ajaxrequest('php/items.php','action=viewcas&userID='+getCookie('userID'),getCategorylist,null);">
  <div class="container">
    <div class="row"> 	
  		<div class="col-md-10 col-md-offset-1">
            <h1>Sell your item</h1>
            <h3>Basic details</h3>
            <div class="row bg-info">
            <div class="col-md-10">
            <div class="input-group-lg ">
                    
            
                    <h4>Title(*)</h4>
                    <input id="itemname" class="form-control" type="text" required autocomplete="off"/>
                    
                    <h4>Main category(*)</h4>
                     <select id="maincategory" class="form-control">                  
				     </select>
                    
                    <br>
          


            </div>
            </div>
            </div>
            
            <h3>Photos</h3>
            <div class="row bg-info">
            <div class="col-md-10">
            
                    
                    
                    <br>
                    
                   
                    
                   
                    <div class="row">
                    <div class="col-md-3 col-md-offset-1 imgwrap"><img id="itempic1" src="img1.jpg" class="img-thumbnail uploadimg" onClick="removeImage(this);"></div>
                    <div class="col-md-3 imgwrap"><img id="itempic2" src="img1.jpg" class="img-thumbnail uploadimg" onClick="removeImage(this);"></div>
                    <div class="col-md-3 imgwrap"><img id="itempic3" src="img1.jpg" class="img-thumbnail uploadimg" onClick="removeImage(this);"></div>
                    </div>
                    
                    <div class="row">
                    <div class="col-md-3 col-md-offset-1 imgwrap"><img id="itempic4" src="img1.jpg" class="img-thumbnail uploadimg" onClick="removeImage(this);"></div>
                    <div class="col-md-3 imgwrap"><img id="itempic5" src="img1.jpg" class="img-thumbnail uploadimg" onClick="removeImage(this);"></div>
                    <div class="col-md-3 imgwrap"><img id="itempic6" src="img1.jpg" class="img-thumbnail uploadimg" onClick="removeImage(this);"></div>
                    </div>
                    
                    <div class="row">
                    <div class="col-md-3 col-md-offset-1 imgwrap"><img id="itempic7" src="img1.jpg" class="img-thumbnail uploadimg" onClick="removeImage(this);"></div>
                    <div class="col-md-3 imgwrap"><img id="itempic8" src="img1.jpg" class="img-thumbnail uploadimg" onClick="removeImage(this);"></div>
                    <div class="col-md-3 imgwrap"><img id="itempic9" src="img1.jpg" class="img-thumbnail uploadimg" onClick="removeImage(this);"></div>
                    </div>
                    
                    

                   
                    <br>
                    
                    <div class="row">
                    <div class="col-md-6 col-md-offset-1">
                    <input id="itempics" type="file" onChange="addImages(this);" multiple style="display:none" >
                    <button type="button" class="btn btn-primary" onClick="selectImages('itempics');">Add</button>
                    <button type="button" class="btn btn-primary" onClick="removeAllImages();">Remove all</button>
                  
                    </div>
                    </div>
                    
                    <br>
                   

                    
                    
      
            
            <br>
            
            </div>
            </div>

            <h3>Additional details</h3>
            
            <div class="row bg-info">
            <div class="col-md-6">
            <div class="input-group-lg ">
                    
                    
                    <h4>Additional predefined categories</h4>
                     <select id="selectcategories" class="form-control">                  
				     </select>
                        
                     <button class="btn btn-primary btn-lg" type="button" onClick="addCategory();">add</button>

                    <h4>Customized categories</h4>
                    <input id="newcategory" class="form-control" type="text" required autocomplete="off"/>
                    <button class="btn btn-primary btn-lg" type="button" onClick="ajaxrequest('php/items.php','action=addca&categoryname='+document.getElementById('newcategory').value+'&userID='+getCookie('userID'),createNewCategory,null);">create a category</button>
                    
                    <h4>Description</h4>
                    <textarea id="description" class="form-control" rows="3"></textarea>
                    <br>
                    
          


            </div>
            </div>
            
            <div class="col-md-6">
            <br>
            <h2><span class="label label-default">Categories</span></h2>
            <div class="row">
            <div class="col-md-10">

            <div id="cblock" >
            </div>


            </div>
            </div>
            </div>
            
            </div>
            
            <h3>Auction settings</h3>
            
            <div class="row bg-info">
            <div class="col-md-10">
            <div class="input-group-lg ">
                    
                    <h4>Starting price($)(*)</h4>
                    <input id="startingprice" class="form-control" type="text" required autocomplete="off"/>
                    
                    <h4>Auction type(*)</h4>
                     <select id="auctiontype" class="form-control" onChange="showforDutch();">
                      <option value=0>Ebay auction</option>
                      <option value=1>Vickrey auction</option>
                      <option value=2>Dutch auction</option>

				</select>
                   <div id="inputfordutch" style="display:none;">
                    <h4>Price Down($)(*)<small>The price will go down every 10s</small></h4>
                    <input id="pricedown" class="form-control" type="text" required autocomplete="off"/>
                    </div>
                    
                     
                     <h4>Duration(mins)(*)</h4>
                     <select id="duration" class="form-control" onChange="showDurationInput();">
                      <option value=1>1 min</option>
                      <option value=2>2 mins</option>
                      <option value=3>3 mins</option>
                      <option value=5>5 mins</option>
                      <option value=10>10 mins</option>
                      <option value=0>Input a duration</option>
                     </select>
                     
                    <div id="inputatime" style="display:none;">
                    <h4>Duration(mins)(*)</h4>
                    <input id="otherduration" class="form-control" type="text" required autocomplete="off"/>
                    </div>
                    
                    <br>
                     
                     
          


            </div>
            </div>
            </div>
            
            <br>
            
            <button type="button" class="btn btn-primary btn-lg" onClick="createNewItem();">Submit</button>
            <button type="button" class="btn btn-default btn-lg" onClick="backtoMyauction();">Cancel</button>
          
        </div>
      

    </div>
    
    
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="bootstrap.min.css" rel="stylesheet">
  <link href="css/newitem.css" rel="stylesheet">


  
</body>
</html>
