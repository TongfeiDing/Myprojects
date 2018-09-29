/*
  The encapsulated common ajax function
  @Tongfei Ding
*/

function ajaxrequest(url,data,callBack,returnelement) {
	 if(data==null) return false;
	
	
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
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
   xhr.send(data);//send data to the server
   xhr.onreadystatechange = checkdata;//When state changes,call 	
   function checkdata() {
   if (xhr.readyState == 4) {//Ajax got return values from php
          if (xhr.status == 200) {
			 if(returnelement==null||returnelement==''){
				 callBack(xhr.responseText);
			 }//if returnelement isn't set, call the callback method
			 else{
				 document.getElementById(returnelement).innerHTML = xhr.responseText;
			 }//if there is an returnelement, directly put the return of server into this div block
		     				 						  
         }  
	   else {
                alert(xhr.status);
	   }
   }
  } 
}

function showrj(rj){
	alert(rj);
}

function confirmRemoving(){
var r=confirm("Do you want to remove it?");
if (r==true)
  {
	  return true;
	  
  }
else
  {
     return false;
  }
}

function SecondstoMins(second){
    var min;
    min = Math.floor(second/60);
    second = second%60;
    if(min==1){
		return min+'min '+second+'s';
	}
    else return min+'mins '+second+'s';

}


