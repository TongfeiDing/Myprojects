// JavaScript Document

function findItem(){
	var loc = location.href;
    var n1 = loc.length;
    var n2 = loc.indexOf("=");
    var itemID = decodeURI(loc.substr(n2+1, n1-n2));
	return 'action=find&itemID='+itemID;

}

function createItemPage(returnjson){
	var obj = JSON.parse(returnjson);
	var data = obj.data;
	var itemdetail = data.item;
	var itemID = itemdetail.itemID;
	var itemname = itemdetail.itemname;
	var pictureURL = itemdetail.pictureURL+'1.jpg';
	var pictures = " <div class='item active'><img src="+pictureURL+" alt='First slide'></div>";
	var indicators = "<li data-target='#myCarousel' data-slide-to='0' class='active'></li>";
	var num_pics = data.num_pics;
	for(var x=2;x<=num_pics;x++){
			var nextpicURL = itemdetail.pictureURL+x+'.jpg';
			pictures += "<div class='item'><img src="+nextpicURL+"></div>";
		    indicators += "<li data-target='#myCarousel' data-slide-to='"+(x-1)+"'></li>";
		}
	
	var currentprice = itemdetail.currentprice;
	var uploadtime = itemdetail.uploadtime;
	var categories = data.categories;
	var categoriesdiv = '';
	if(categories!=null&&categories!=''){
		for(var j=0;j<categories.length;j++){
			var cname = categories[j].categoryname;
			categoriesdiv += "<span class='label label-primary cspan'>"+cname+"</span>";			
		}
		}
	
		var auctiontype;
		if(itemdetail.auctiontype=='0') {
			auctiontype = 'Ebay Auction';
			//set auction introduction
	        document.getElementById('auctionintroduction').innerHTML = ' <b>Ebay Auction: </b><br>1.This item is in Ebay auction now.<br>2.The bidder who gives the highest price will finally win this item.<br>3.The price you see here is the second highest bid on this item<br>4. The winner only need to pay the price shown here(the second price)<br>5.you can bid many times as you like.';
		}
		else if(itemdetail.auctiontype=='1') {
			auctiontype = 'Vickrey Auction';
			//In Vickrey auction the current price is invisible
			currentprice = itemdetail.startingprice;
			document.getElementById('auctionintroduction').innerHTML = ' <b>Vickrey Auction: </b><br>1.This item is in Vickrey auction now.<br>2.The bidder who gives the highest price will finally win this item.<br>3.The price you see here is the starting price of this item<br>4. The winner only need to pay the second highest price in all bids<br>5.<b>Please notice that you can bid only once on this item.</b>';
		}
		else if(itemdetail.auctiontype=='2') {
			auctiontype = 'Dutch Auction';
			var pricedown = itemdetail.pricedown;
			document.getElementById('mybid').value = currentprice;
			document.getElementById('mybid').disabled = 'disabled';
			 document.getElementById('auctionintroduction').innerHTML = ' <b>Dutch Auction: </b><br>1.This item is in Dutch auction now.<br>2.The price in this page is the current price of this item.<br>3.Once you confirm your bid, you will win this item and pay the current price.<br>4.You cannot offer a new price, but the price here will go down by time';
		}
	var description = itemdetail.description;
	
	var seller = data.seller;
	var sellerID = seller.userID;
	var sellername = seller.username;
	var selleremail = seller.email;
	
	var comments = data.comments;
	var commentsdiv = '';
	if(comments!=null&&comments!=''){
		for(var y=0;y<comments.length;y++){
			var commentsender = comments[y].username;
			var comment = comments[y].content;
			var commenttime = comments[y].time;
			commentsdiv ="<div class='list-group-item'><div class='row'><div class='col-md-12'><h4><b>"+commentsender+"</b><h4><h5>"+commenttime+"</h5><p>"+comment+"</p></div></div></div>";
			document.getElementById('comments').innerHTML += commentsdiv;		
		}
		}
	
	
	
	document.getElementById('titleitemname').innerHTML = itemname;
	document.getElementById('auctiontype').innerHTML += auctiontype;
	document.getElementById('uploadtime').innerHTML += uploadtime;
	
	var duration = itemdetail.duration;
	if(duration<=0){
		duration = 'item expired';
		document.getElementById('timeleft').innerHTML = duration;
	}
	else{
		duration = SecondstoMins(itemdetail.duration);
		document.getElementById('timeleft').innerHTML = "<b>"+duration+"</b> left";
	}
	
	
	document.getElementById('categories').innerHTML = categoriesdiv;
	document.getElementById('price').value = currentprice;
	if(auctiontype=='Dutch Auction'){
	document.getElementById('price').innerHTML += currentprice + "<small> will go down "+pricedown+" every 10s</small>";
	}
	else document.getElementById('price').innerHTML += currentprice;
	document.getElementById('description').innerHTML = description;
	
	
	//set images
	document.getElementById('carousel-inner').innerHTML = pictures;
	document.getElementById('carousel-indicators').innerHTML = indicators;
	
	//set seller information
	document.getElementById('sellername').innerHTML = sellername;
	document.getElementById('selleremail').innerHTML = selleremail;
	//cannot buy your own item
	if(sellerID == getCookie('userID')){
		document.getElementById('btn_bid').disabled = 'disabled';
		document.getElementById('btn_bid').title = 'Sorry, you cannot bid your own item';
	}
	
	
	//set a timer
	setInterval("ajaxrequest('php/items.php',findItem(),refreshTimeandPrice,null)",1000);

	
}

function bid(){
	var loc = location.href;
    var n1 = loc.length;
    var n2 = loc.indexOf("=");
    var itemID = decodeURI(loc.substr(n2+1, n1-n2));
	var mybid = document.getElementById('mybid').value;
	
		//login first to bid an item
	if(getCookie('userID')==''||getCookie('userID')==null){
		alert('You need to login or register a new account');
		return null;
	}
	
	if(mybid == ''||mybid == null){
		alert('Please input a price!');
		return null;
	}
	
	
	if(parseFloat(mybid) < document.getElementById('price').value){
		alert('You must offer a higher price');
		return null;
	}
	
	if(confirmBid(mybid)){
		ajaxrequest('php/transaction.php','action=bid&itemID='+itemID+'&price='+parseFloat(mybid)+'&userID='+getCookie('userID'),updateBid,null);
	}
	
	
	
	
}

function updateBid(returnjson){
	var obj = JSON.parse(returnjson);
	var data = obj.data;
	alert('You have offered a price for this item');
	alert(data);
	window.location.href("myauction.php");
}

function confirmBid(price){
var r=confirm("Confirm your price:$"+price);
if (r==true)
  {
	  return true;
	  
  }
else
  {
     return false;
  }
}

function submitcomment(){
	var loc = location.href;
    var n1 = loc.length;
    var n2 = loc.indexOf("=");
    var itemID = decodeURI(loc.substr(n2+1, n1-n2));
	var senderID = getCookie('userID');	
	var content = document.getElementById('mycomment').value;
	var data = 'action=writecomment&userID='+senderID+'&itemID='+itemID+'&content='+content;
	ajaxrequest('php/items.php',data,showcomment,null);
}

function showcomment(returnjson){
	alert('Thank you for your comment!');
	window.location.href="myauction.php";
}

//update the current price and the duration every 10s. In Vickrey auction, only update the duration
function refreshTimeandPrice(returnjson){
	var obj = JSON.parse(returnjson);
	var data = obj.data;
	var itemdetail = data.item;
	var auctiontype = itemdetail.auctiontype;
	var currentprice = itemdetail.currentprice;
	var duration = itemdetail.duration;
	var pricedown = itemdetail.pricedown;
	
	if(duration>0){
		duration = SecondstoMins(duration);
		document.getElementById('timeleft').innerHTML = "<b>"+duration+"</b> left";	
	}
	
	else document.getElementById('timeleft').innerHTML = "item expired";
	
	//show newest price except in Vickrey
	if(auctiontype == 0){
		document.getElementById('price').innerHTML = "Price: $"+currentprice;
	}
	
	if(auctiontype == 2){
		document.getElementById('price').innerHTML = "Price: $"+currentprice+ "<small> will go down "+pricedown+" every 10s</small>";
		document.getElementById('mybid').value = currentprice;
	}
	
	
	
}
