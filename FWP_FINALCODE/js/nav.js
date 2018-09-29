$(document).ready(function(){
	poll()
	pollnewitems()
	nav()

	$('#usr').click(function(){
      var r=confirm("Do you want to sign out?");
       if (r==true){
        setCookie("userID","",-1);
        setCookie("username","",-1);
        setCookie("image","",-1);
        window.location.href = "index.php";
       }
    })


})

function nav() {
    var uid = getCookie("username");
    if(uid == ""){
    	$('.needed-login').hide();
        $('.no-needed-login').show();
    }else{
    	var x = uid + '<span class="caret"></span>';
    	$("#uid").append(x);
    	$('.needed-login').show();
      $('.no-needed-login').hide();
    }
}

function poll(){
  var id = getCookie('userID')
  $.ajax({
    url: 'php/' + 'messages.php',
    type: "POST",
    dataType: 'json',
    data: {action: "get-unread", userID: id},
    success: function(response){
      setTimeout(function(){
        if(response.success == 1){
          if(response.data > 0){
            $('#chat-menu-option').html("Chat (" + response.data + ")")
          }
        }
        poll()
      },2000)
    }
  })
}


function pollnewitems(){
  var id = getCookie('userID')
	if(id != null && id > 0){
		$.ajax({
	    url: 'php/' + 'getunseenitems.php',
	    type: "POST",
	    dataType: 'json',
	    data: { userID: id},
	    success: function(response){
	      setTimeout(function(){
	        if(response.success == 1){
	          if(response.data > 0){
	            $('#items-menu-option').html("Search (" + response.data + ")")
	          }
	        }
	        pollnewitems()
	      },2000)
	    }
	  })
	}

}
