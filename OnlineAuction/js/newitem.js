var imgurls = new Array();
var categories = new Array();
var data = new FormData();

function getCategorylist(returnjson){
	var obj = JSON.parse(returnjson);
	var selectcategories = document.getElementById("selectcategories");
	var maincategory = document.getElementById("maincategory");

	var data = obj.data;
	for(var i=0;i<data.length;i++){
		var newoption =  document.createElement("option");
		newoption.text = data[i].categoryname;
		newoption.value = data[i].categoryID;
		
		if(data[i].status==0){
		var newoption_main =  document.createElement("option");
		newoption_main.text = data[i].categoryname;
		newoption_main.value = data[i].categoryID;
		}
		
		selectcategories.options.add(newoption, null);
		maincategory.options.add(newoption_main, null);
		
	}
	
	selectcategories.selectedIndex = -1;
	maincategory.selectedIndex = -1;
}

//Preview all selected pictures
function refreshImgarea(){
	for(var i=1;i<=9;i++){
		if(i<=imgurls.length){
			document.getElementById('itempic'+i).src = window.URL.createObjectURL(imgurls[i-1]);
		}
		else{
			document.getElementById('itempic'+i).src = 'img1.jpg';		
		}
		
	}

}

function showforDutch(){
	var auctiontype = document.getElementById('auctiontype');
	var index = auctiontype.selectedIndex;
	if(index==2){
	document.getElementById("inputfordutch").style.display="";
	}
	else document.getElementById("inputfordutch").style.display="none";
}

function showDurationInput(){
	var duration = document.getElementById('duration');
	var index = duration.selectedIndex;
	if(index==5){
	document.getElementById("inputatime").style.display="";
	}
	else document.getElementById("inputatime").style.display="none";
}


function addImages(imgfile){
	for(var i=0;i<imgfile.files.length;i++){
		if(imgurls.length<9)
		imgurls.push(imgfile.files[i]);
		else{
			alert('You can upload at most 9 pictures');
			break;
		}
	}
	
	refreshImgarea();
	
}

function removeImage(img){
	var index = parseInt(img.id.substr(7,1));
	
	if(index<=imgurls.length){
		
	if(confirmRemoving()){
	
	imgurls.splice(index-1,1);	
	refreshImgarea();
	}
		
	}
}

function removeAllImages(){
	imgurls.splice(0,imgurls.length);
	refreshImgarea();
}




function addCategory(){
	var selectcategories = document.getElementById('selectcategories');
	var index = selectcategories.selectedIndex;	
	var cname = selectcategories.options[index].text;
	
	if(!containElement(categories,cname)){
		categories.push(cname);
		var html = "<span class='label label-primary cspan' onClick='removeCategory(this);'>"+cname+"</span>";
		document.getElementById('cblock').innerHTML += html;
	}
	
	else alert('The category has existed!');

	
	

}
	
function containElement(arr,val){
	for(var i=0;i<arr.length;i++){
		if(arr[i]==val){
			return true;
		}
	}
	return false;
}
	
function removeCategory(calabel){
	if(calabel != null&&confirmRemoving()){
		var index = $.inArray(calabel.textContent,categories);
		if(index >= 0){
			categories.splice(index,1);		

		}
		calabel.parentNode.removeChild(calabel);

	}
	
}

function createNewCategory(returnjson){
	var obj = JSON.parse(returnjson);
	if(obj.status>0){
		alert("New category is added.");
		var newoption =  document.createElement("option");
		var cname = document.getElementById("newcategory").value;
		newoption.text = cname;
		newoption.value = obj.status;
		selectcategories.options.add(newoption, null);
		
		categories.push(cname);
		var html = "<span class='label label-primary cspan' onClick='removeCategory(this);'>"+cname+"</span>";
		document.getElementById('cblock').innerHTML += html;
		
		
	}
	
	else alert("This category has existed.");


	
}

function backtoMyauction(){
	window.location.href="myauction.php";
}


function createNewItem(){
	data.append("action",'add');
	data.append("userID",getCookie('userID'));
	
	data.append("itemname",document.getElementById('itemname').value);
	
	//add main category
	var maincategory = document.getElementById('maincategory');
	var indexmc = maincategory.selectedIndex;	
	var cname = maincategory.options[indexmc].text;	
	if(!containElement(categories,cname)){
		categories.push(cname);
	}
	for(i=0;i<categories.length;i++)
	{data.append('categories[]',categories[i]);}
	
	for(var i=1;i<=imgurls.length;i++){
	data.append("itempic"+i,imgurls[i-1]);
	}
	data.append("num_of_pics",imgurls.length);
	
	data.append("description",document.getElementById('description').value);
	
	data.append("startingprice",document.getElementById('startingprice').value);
	
	var auctiontype = document.getElementById('auctiontype');
	var indexat = auctiontype.selectedIndex;
	data.append("auctiontype",auctiontype.options[indexat].value);
	
	if(auctiontype.options[indexat].value==2){
		data.append("pricedown",document.getElementById('pricedown').value);
	}
	
	var duration = document.getElementById('duration');
	var indexd = duration.selectedIndex;
	if(indexd == 5){
		data.append("duration",(document.getElementById('otherduration').value)*60);
	}
	else{
		data.append("duration",(duration.options[indexd].value)*60);
	}
	
	
	
	
	var url = "php/items.php";	
	var xhr = null; 
     if (window.XMLHttpRequest) {    // Mozilla, Safari, ...
           xhr = new XMLHttpRequest();
     } 
	else if (window.ActiveXObject) {    // IE 8 and older
           xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }
	else{
          alert("Error creating request object!");
    }//Create Ajax object according to browser's type.
    xhr.open("POST", url, true); //post method and giving url as a parameter
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest"); 
   xhr.send(data);//send data to the server
   xhr.onreadystatechange = checkdata;//When state changes,call 	
   function checkdata() {
   if (xhr.readyState == 4) {//Ajax got return values from php
          if (xhr.status == 200) {			 
				 alert('New item is uploaded');	  
			     window.location.href="myauction.php";
         }  
	   else {
                alert(xhr.status);
	   }
   }
  } 
}
