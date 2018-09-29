// Ajax fundemental functions 

function ajaxrequest(url,data,returnelement,returntype,callback) {
     var xhr = null; 
     if (window.XMLHttpRequest) {    // Mozilla, Safari, ...
           xhr = new XMLHttpRequest();
     } else if (window.ActiveXObject) {    // IE 8 and older
           xhr = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
          alert("Error creating request object!");
    }//Create Ajax object according to browser's type.
    xhr.open("POST", url, true); //post method and giving url as a parameter
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
   xhr.send(data);//send data to the server
   xhr.onreadystatechange = checkdata;//When state changes,call 	
   function checkdata() {
   if (xhr.readyState == 4) {//Ajax got return values from php
          if (xhr.status == 200) {
			  if(returntype==1){
                   document.getElementById(returnelement).innerHTML = xhr.responseText;//put return html code into a div called returnelement
				   if(returnelement==null||returnelement=='')alert('No return from server!');
			  }
			  if(returntype==2){
				  returnelement = xhr.responseText;
				  return returnelement;
			  }
			  if(returntype==3){
				  if(callback!=null) returnelement=callback(xhr.responseText);
			  }
         }  else {
                   alert(xhr.status);   }  }   }  }






function setCookie(c_name,value,expiredays)
{
var exdate=new Date()
exdate.setDate(exdate.getDate()+expiredays)
document.cookie=c_name+ "=" +escape(value)+
((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}

function getCookie(c_name)
{
if (document.cookie.length>0)
  {
  c_start=document.cookie.indexOf(c_name + "=")
  if (c_start!=-1)
    { 
    c_start=c_start + c_name.length+1 
    c_end=document.cookie.indexOf(";",c_start)
    if (c_end==-1) c_end=document.cookie.length
    return unescape(document.cookie.substring(c_start,c_end));
    } 
  }
return "";
}

function alertcookie(c1){
	alert(c1);
}


