// JavaScript Document

//the number of selected images in this group

function selectImages(inputid){	
	document.getElementById(inputid).click();	
}

function displayImages(img,imgfile){
	document.getElementById(img).src = window.URL.createObjectURL(imgfile.files[0]);
}


function uploadImages(imgfile){
	var data = new FormData();
	var url = "php/userdetails.php";
	var image = document.getElementById(imgfile).files[0];
	data.append("image", image);
	data.append("action", 'setp');
	data.append("userID",getCookie('userID'));
	
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
				 refreshImage(xhr.responseText);			 			 						  
         }  
	   else {
                alert(xhr.status);
	   }
   }
  } 
	
	
}

function refreshImage(rj){
	var obj = JSON.parse(rj);	
	if(obj.status>0){
		alert('update success');
		var data = obj.data;
		setCookie('image',data.photoURL,7);
		window.location.reload();

		
	}
}