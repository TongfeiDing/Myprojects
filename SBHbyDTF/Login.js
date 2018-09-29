$(function(){
	"use strict";
	$(".flashBanner").each(function(){
		var timer;
		$(".flashBanner .mask img").click(function(){
			var index = $(".flashBanner .mask img").index($(this));	
			changeImg(index);
		}).eq(0).click();
		$(this).find(".mask").animate({
			"bottom":"0"	
		},700);
		$(".flashBanner").hover(function(){
			clearInterval(timer);	
		},function(){
			timer = setInterval(function(){
				var show = $(".flashBanner .mask img.show").index();
				if (show >= $(".flashBanner .mask img").length-1)
					show = 0;
				else
					show ++;
				changeImg(show);
			},3000);
		});
		function changeImg (index)
		{
			$(".flashBanner .mask img").removeClass("show").eq(index).addClass("show");
			$(".flashBanner .bigImg").parents("a").attr("href",$(".flashBanner .mask img").eq(index).attr("link"));
			$(".flashBanner .bigImg").hide().attr("src",$(".flashBanner .mask img").eq(index).attr("uri")).fadeIn("slow");
		}
		timer = setInterval(function(){
			var show = $(".flashBanner .mask img.show").index();
			if (show >= $(".flashBanner .mask img").length-1)
				show = 0;
			else
				show ++;
			changeImg(show);
		},3000);
	});
});

function presentSignUp(){
	
	"use strict";
        var signup = document.getElementById("signup");
		var login = document.getElementById("login");

        if(signup.style.display === "none"){
			login.style.display = "none";
           signup.style.display = "block";
		   
        }
		
		else if(signup.style.display === "block"){ 
           signup.style.display = "none";
        }
		else{
			signup.style.display = "block";
			login.style.display = "none";
		}
    }
function presentLogIn(){
	
	"use strict";
        var login = document.getElementById("login");
		var signup = document.getElementById("signup");
        if(login.style.display === "none"){
		   signup.style.display = "none";
           login.style.display = "block";
		   
        }else if(login.style.display === "block"){ 
           login.style.display = "none";
        }
		else{
			login.style.display = "block";
			signup.style.display = "none";
		}
    }

//Use inputting username and password to make a data string to ajax
function passValues(){
	var useraccount = document.getElementById("emailaddress").value;
	var password = document.getElementById("password").value;
	return "emailaddress="+useraccount+"&password="+password;
}

