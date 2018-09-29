// JavaScript Document



function getCategorylist(returnjson){
	var obj = JSON.parse(returnjson);
	var data = obj.data;
	for(var i=0;i<data.length;i++){
		var li =  "<li class='list-group-item'><a href='##' name="+data[i].categoryID+" onClick=searchItems(this);><b>"+data[i].categoryname+"</b></a></li>";
		document.getElementById("defaultcategories").innerHTML+=li;	
	}

}

function createList(returnjson){
	document.getElementById('resultlist').innerHTML = '';
	var obj = JSON.parse(returnjson);
	var html;
	if(obj.status==0){
		html="<div id='nothingtoshow' class='list-group-item'><h2>No relevant items</h2></div>";
	document.getElementById('resultlist').innerHTML += html;
		
		return null;	
	}
	
	var data = obj.data;
	
	for(var i=0;i<data.length;i++){
		var item = data[i];
		var itemdetail = item.item;
		var itemID = itemdetail.itemID;
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
			categoriesdiv += "<span class='label label-primary cspan'>"+cname+"</span>";
			
		}
		}
	
	//var timeleft = calLeftTime(itemdetail.uploadtime,itemdetail.duration);
		var auctiontype;
		if(itemdetail.auctiontype=='0') auctiontype = 'Ebay Auction';
		else if(itemdetail.auctiontype=='1') {
			auctiontype = 'Vickrey Auction';
			//In Vickrey auction the current price is invisible
			currentprice = itemdetail.startingprice;
		}
		else if(itemdetail.auctiontype=='2') auctiontype = 'Dutch Auction';
		var description = itemdetail.description;
		html ="<a href='##' id="+itemID+" onClick=toItempage(this) class='list-group-item'><div class='row'><div class='col-md-4 imgwrap'><img src="+pictureURL+" class='img-thumbnail'></div><div class='col-md-6'><h3 class='list-group-item-heading'>"+itemname+"</h3><h4><b>$"+currentprice+"</b></h4><h5>Auction Type:"+auctiontype+"</h5><h5>Update on <b>"+uploadtime+"</b></h5><h5><b>"+duration+"</b> left</h5><h5><b>Categories:</b></h5><div>"+categoriesdiv+"</div><br><p class='list-group-item-text'>Description</p><p class='list-group-item-text'>"+description+"</p></div></div></a>";
		document.getElementById('resultlist').innerHTML += html;
	}
	
}


function toItempage(item){
	window.location.href="anitem.php?itemID="+item.id;
}

function searchItems(ca){
	var userID = getCookie('userID');
	var keyword = document.getElementById('keyword').value;
	if(keyword=='Everything'){
		keyword='';
	}
	if(ca!=null){
		var categories = ca.name;
		var data = 'userID='+userID+'&receivedword='+keyword+'&categories='+categories;
	}
	else var data = 'userID='+userID+'&receivedword='+keyword;
	ajaxrequest('php/search.php',data,createList,null);
	
}

function removePlaceholder(element,placeholder){
	if(element.value==placeholder){
		element.value='';
	    element.style.color='black';
		if(placeholder=='Password'){
			element.type='password';
		}
	}
}
//Show default values in input boxes
function setPlaceholder(element,placeholder){
	if(element.value==''||element.value==placeholder){
		element.value=placeholder;
		element.style.color='gray';
		if(placeholder=='Password'){
			element.type='text';
		}
	}
}



