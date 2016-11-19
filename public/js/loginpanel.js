var loginvalid = 2;
function loginformcheck () {
        var username = $("#login").val();
        var password = $("#password").val();
        $.post("../php/checking.php", {
          username:username,
          password:password
          },
            function check_login_password(result) {
                if(result == 1) {  
                    loginvalid = 1;
                }
                else { 
                    loginvalid = 0;
                }
            });
}

$("#login").keyup(function() {
        loginformcheck ();
});

$("#password").keyup(function() {
        loginformcheck ();
});

$("#loginbutton").click(function() {
        loginformcheck ();
     });

function checkLoginForm (form) {
if (loginvalid == 0) {
	document.getElementById("LoginValid").setAttribute('style', 'display:none');
	return true;
} else {
	document.getElementById("LoginValid").removeAttribute("style"); 
	return false;
}
}