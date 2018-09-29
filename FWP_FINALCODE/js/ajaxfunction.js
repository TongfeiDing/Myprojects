// JavaScript Document
// Ajax fundemental functions

var wu;
function ajaxrequest(url,data,returnelement,returntype,callBack) {
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
				  returnelement = xhr.responseText;//use return value from php to call loginCheck method.If login successes,open a new page for the customer or manager.
				  alert(returnelement);
				  return returnelement;
				  if(returnelement==null||returnelement=='')alert('No return from server!');


			  }
			  if(returntype==3){

				  if(returnelement!=null){
            wu = xhr.responseText
					  var resultText = callBack(xhr.responseText);
					  document.getElementById(returnelement).innerHTML = resultText;
					  if(returnelement==null||returnelement=='')alert('No return from server!');
            if(returnelement === 'searchResult'){
              $('.user-mark').click(function(){
                console.log('MODAL')
                var username = $(this).text();
                $.post('php/profile.php', {username: username}, function(response){
                  if(response.success){
                    var profile = response.data
                    $.get('php/' + profile.image)
                        .done(function() {
                          $('div.container-picture > div')
                            .css('background-image', "url('" + 'php/' + profile.image + "')")
                        })
                        .fail(function() {
                            $('div.container-picture > div')
                              .css('background-image', "url('images/generic-user-profile.svg')")
                          })

                    $('.container-user-info .name').text(profile.firstName + " " + profile.lastName)
                    $('.container-user-info .phone').text(profile.phoneNo)
                  }
                }, 'json')
                $('#user-info-modal').modal('toggle')
                $('#user-info-modal h4.modal-title').text(username)
              })
            }
				  }//use return value from php to call loginCheck method.If login successes,open a new page for the customer or manager.

				  else{
					  callBack(xhr.responseText);
				  }


			  }
         }    }


   }  }
