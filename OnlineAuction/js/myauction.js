// JavaScript Document

function getSelling(){
	ajaxrequest('php/items.php','action=view&userID='+getCookie('userID'),getMyitemLists,null);
	document.getElementById("usernamelab").innerHTML = getCookie('username');
	if(getCookie('image')!=null&&getCookie('image')!=''){
		document.getElementById("imageshow").src = getCookie('image');
	}
}

function getMyitemLists(returnjson){
	var obj = JSON.parse(returnjson);
	if(obj.status==0){
		return null;	
	}
	
	var data = obj.data;
	var html;	
	
	document.getElementById('sellinglist').innerHTML = '';
	document.getElementById('removeditemlist').innerHTML = '';
	document.getElementById('solditemlist').innerHTML = '';
	document.getElementById('overtimeitemlist').innerHTML = '';
	
	for(var i=0;i<data.length;i++){
		var item = data[i];
		var itemdetail = item.item;
		var itemID = itemdetail.itemID;
		var status = itemdetail.status;
		var itemname = itemdetail.itemname;
		var pictureURL = itemdetail.pictureURL+'1.jpg';
		var currentprice = itemdetail.currentprice;
		var uploadtime = itemdetail.uploadtime;
		var duration = SecondstoMins(itemdetail.duration);
		var categories = item.categories;
		var categoriesdiv = '';
		if(categories!=null&&categories!=''){
		for(var j=0;j<categories.length;j++){
			var cname = categories[j].categoryname;
			categoriesdiv += "<span class='label label-primary cspan'>"+cname+"</span>"
			
		}
		}
	
	//var timeleft = calLeftTime(itemdetail.uploadtime,itemdetail.duration);
		var auctiontype;
		if(itemdetail.auctiontype=='0') auctiontype = 'Ebay Auction';
		else if(itemdetail.auctiontype=='1') {
			auctiontype = 'Vickrey Auction';
			currentprice = itemdetail.startingprice;
		}
		else if(itemdetail.auctiontype=='2') auctiontype = 'Dutch Auction';
		var description = itemdetail.description;
		//available items
		if(status==0){
			html ="<div id="+itemID+" class='list-group-item'><div class='row'><div class='col-md-4 imgwrap'><img src="+pictureURL+" class='img-thumbnail'></div><div class='col-md-6'><h3 class='list-group-item-heading'>"+itemname+"</h3><h4><b>$"+currentprice+"</b></h4><h5>Auction Type:"+auctiontype+"</h5><h5>Update on <b>"+uploadtime+"</b></h5><h5><b>"+duration+"</b> left</h5><h5><b>Categories:</b></h5><div>"+categoriesdiv+"</div><br><p class='list-group-item-text'>Description</p><p class='list-group-item-text'>"+description+"</p></div> <div class='col-md-2'><br><button value= "+itemID+" type='button' class='btn btn-primary btn-block' onClick='removeitem(this);'>Cancel item</button></div></div></div>";
			document.getElementById('sellinglist').innerHTML += html;
		}
		//removed items
		else if(status==1){
			html = "<div id="+itemID+" class='list-group-item'><div class='row'><div class='col-md-4 imgwrap'><img src="+pictureURL+" class='img-thumbnail'></div><div class='col-md-6'><h3 class='list-group-item-heading'>"+itemname+"</h3><h4><b>$"+currentprice+"</b></h4><h5>Auction Type:"+auctiontype+"</h5><h5>Update on <b>"+uploadtime+"</b></h5><h5><b>Categories:</b></h5><div>"+categoriesdiv+"</div><br><p class='list-group-item-text'>Description</p><p class='list-group-item-text'>"+description+"</p></div><div class='col-md-2'><br><button value= "+itemID+" type='button' class='btn btn-primary btn-block' onClick='relistitem(this);'>Relist item</button></div></div></div>";
			document.getElementById('removeditemlist').innerHTML += html;				
		}
		//sold items
		else if(status==2){			
			html = "<div id="+itemID+" class='list-group-item'><div class='row'><div class='col-md-4 imgwrap'><img src="+pictureURL+" class='img-thumbnail'></div><div class='col-md-6'><h3 class='list-group-item-heading'>"+itemname+"</h3><h4><b>$"+currentprice+"</b></h4><h5>Auction Type:"+auctiontype+"</h5><h5>Update on <b>"+uploadtime+"</b></h5><h5><b>Categories:</b></h5><div>"+categoriesdiv+"</div><br><p class='list-group-item-text'>Description</p><p class='list-group-item-text'>"+description+"</p></div></div></div>";
			document.getElementById('solditemlist').innerHTML += html;		
			
		}
		//overtimeitems
		else if(status==3){
			html = "<div id="+itemID+" class='list-group-item'><div class='row'><div class='col-md-4 imgwrap'><img src="+pictureURL+" class='img-thumbnail'></div><div class='col-md-6'><h3 class='list-group-item-heading'>"+itemname+"</h3><h4><b>$"+currentprice+"</b></h4><h5>Auction Type:"+auctiontype+"</h5><h5>Update on <b>"+uploadtime+"</b></h5><h5><b>Categories:</b></h5><div>"+categoriesdiv+"</div><br><p class='list-group-item-text'>Description</p><p class='list-group-item-text'>"+description+"</p></div><div class='col-md-2'><br><button value= "+itemID+" type='button' class='btn btn-primary btn-block' onClick='relistitem(this);'>Relist item</button></div></div></div>";
			document.getElementById('overtimeitemlist').innerHTML += html;		
		}
	}
	html="<div id='tonewitem' class='list-group-item'><a href='newitem.php'>Go to upload and sell a new item</a></div>";
	document.getElementById('sellinglist').innerHTML += html;
	
	
}


function removeitem(btn){
	var index = btn.value;
	var itemdiv = document.getElementById(index);
		if(confirmRemoving()){
		ajaxrequest('php/items.php','action=remove&userID='+getCookie('userID')+'&itemID='+index,refreshPage,null);
		

	}
}

function confirmRelisting(){
var r=confirm("Click to confirm relisting this item");
if (r==true)
  {
	  return true;
	  
  }
else
  {
     return false;
  }
}

function refreshPage(returnjson){
	window.location.reload();
}

function relistitem(btn){
	var index = btn.value;
	var itemdiv = document.getElementById(index);
		if(confirmRelisting()){
		ajaxrequest('php/items.php','action=relist&userID='+getCookie('userID')+'&itemID='+index,refreshPage,null);

	}
}

function getBidding(){
	ajaxrequest('php/transaction.php','action=viewuserbidding&userID='+getCookie('userID'),getMybidsLists,null);
}

function getTransacton(){
	ajaxrequest('php/transaction.php','action=viewtransactions&userID='+getCookie('userID'),getMytransactionsLists,null);
}

function getMybidsLists(returnjson){
	var obj = JSON.parse(returnjson);
	if(obj.status==0){
		return null;	
	}
	
	var data = obj.data;
	var html;	
	
	document.getElementById('mybidlist').innerHTML = '';
	
	for(var i=0;i<data.length;i++){
		var item = data[i];
		var itemdetail = item.item;
		var itemID = itemdetail.itemID;
		var itemname = itemdetail.itemname;
		var pictureURL = itemdetail.pictureURL+'1.jpg';
		var currentprice = itemdetail.currentprice;
		var uploadtime = itemdetail.uploadtime;
		var duration = SecondstoMins(itemdetail.duration);
		var bids = item.bids;
		var mycurrentbid = 0;
		var mycurrentbidtime = '';
		//get bids information
		for(var j=0;j<bids.length;j++){
			var bid = bids[j];
			if(bid.price > mycurrentbid && bid.bidderID == getCookie('userID')){
				mycurrentbid = bid.price;
				mycurrentbidtime = bid.time;
			}
						
			
		}
		
	
		
		//This list doesnt show items in Dutch auction,because these items have been bought and shown in transactions 
		var auctiontype;
		if(itemdetail.auctiontype=='0'){
			auctiontype = 'Ebay Auction';
		}
		else if(itemdetail.auctiontype=='1') {
			auctiontype = 'Vickrey Auction';
			currentprice = itemdetail.startingprice;
		}
		else if(itemdetail.auctiontype=='2') auctiontype = 'Dutch Auction';
		
		var hint = '';
		if(currentprice>=mycurrentbid) hint = 'bg-danger';

		if(itemdetail.auctiontype=='0'||itemdetail.auctiontype=='1'){
		html ="<div class='list-group-item'><div class='row "+hint+"'><div class='col-md-4 imgwrap'><img src="+pictureURL+" class='img-thumbnail'></div><div class='col-md-6'><h3 class='list-group-item-heading'>"+itemname+"</h3><h5>Auction Type:"+auctiontype+"</h5><h5>Update on <b>"+uploadtime+"</b></h5><h5><b>"+duration+"</b> left</h5><h4><b>The current price is $"+currentprice+"</b></h4><h4><b>The price I offer is $"+mycurrentbid+"</b></h4><h5>at <b>"+mycurrentbidtime+"</b></h5><br></div> <div class='col-md-2'><br><button value= "+itemID+" type='button' class='btn btn-primary btn-block' onClick='toItempage(this);'>Go</button></div></div></div>";
			
		if(itemdetail.status==1){
				html ="<div class='list-group-item'><div class='row bg-warning'><div class='col-md-4 imgwrap'><img src="+pictureURL+" class='img-thumbnail'></div><div class='col-md-6'><h3 class='list-group-item-heading'>"+itemname+"</h3><h5>Auction Type:"+auctiontype+"</h5><br><h3>This item has been removed</h3></div> </div></div>";
			
		}		
		if(itemdetail.status==2){
				html ="<div class='list-group-item'><div class='row bg-warning'><div class='col-md-4 imgwrap'><img src="+pictureURL+" class='img-thumbnail'></div><div class='col-md-6'><h3 class='list-group-item-heading'>"+itemname+"</h3><h5>Auction Type:"+auctiontype+"</h5><br><h3>This item has been sold</h3></div> </div></div>";
			
		}
		if(itemdetail.status==3){
				html ="<div class='list-group-item'><div class='row bg-warning'><div class='col-md-4 imgwrap'><img src="+pictureURL+" class='img-thumbnail'></div><div class='col-md-6'><h3 class='list-group-item-heading'>"+itemname+"</h3><h5>Auction Type:"+auctiontype+"</h5><br><h3>This item is overtime</h3></div> </div></div>";
			
		}
		
		document.getElementById('mybidlist').innerHTML += html;
		}
		

	}
	
	
}



function getMytransactionsLists(returnjson){
	var obj = JSON.parse(returnjson);
	if(obj.status==0){
		return null;	
	}
	
	var data = obj.data;
	var html;	
	
	document.getElementById('mytransactionlist').innerHTML = '';
	
	for(var i=0;i<data.length;i++){
		var item = data[i];
		var itemdetail = item.item;
		var itemID = itemdetail.itemID;
		var itemname = itemdetail.itemname;
		var pictureURL = itemdetail.pictureURL+'1.jpg';
		var currentprice = itemdetail.currentprice;
		var uploadtime = itemdetail.uploadtime;
		var duration = SecondstoMins(itemdetail.duration);
		var dealtime = itemdetail.dealtime;
		
		
		//This list doesnt show items in Dutch auction,because these items have been bought and shown in transactions 
		var auctiontype;
		if(itemdetail.auctiontype=='0'){
			auctiontype = 'Ebay Auction';
		}
		else if(itemdetail.auctiontype=='1') {
			auctiontype = 'Vickrey Auction';
		}
		else if(itemdetail.auctiontype=='2') auctiontype = 'Dutch Auction';
	

		html ="<div class='list-group-item'><div class='row'><div class='col-md-4 imgwrap'><img src="+pictureURL+" class='img-thumbnail'></div><div class='col-md-6'><h3 class='list-group-item-heading'>"+itemname+"</h3><h5>Auction Type:"+auctiontype+"</h5><h5>Update on <b>"+uploadtime+"</b></h5><br><h4><b>The price of the deal: $"+currentprice+"</b></h4><h5>This transaction is proceeded at <b>"+dealtime+"</b></h5><br></div> <div class='col-md-2'></div></div></div>";
		
		document.getElementById('mytransactionlist').innerHTML += html;
		
		

	}
	
	
}

function toItempage(item){
	window.location.href="anitem.php?itemID="+item.value;
}


