<?php include("includes.php"); ?>

<!DOCTYPE html>
<html>
	<head>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>	
		<script src="js/app.js?v=9"></script>	
		<script src="js/fb.js"></script>
		<link rel="stylesheet" type="text/css" href="css/app.css">
	</head>
	
	<body>
		<script>
		  function statusChangeCallback(response) {
			    console.log('statusChangeCallback');
			    console.log(response);
			    // The response object is returned with a status field that lets the
			    // app know the current login status of the person.
			    // Full docs on the response object can be found in the documentation
			    // for FB.getLoginStatus().
			    if (response.status === 'connected') {
			      // Logged into your app and Facebook.
			      testAPI();
			    } else if (response.status === 'not_authorized') {
			      // The person is logged into Facebook, but not your app.
			      document.getElementById('status').innerHTML = 'Please log ' +
			        'into this app.';
			    } else {
			      // The person is not logged into Facebook, so we're not sure if
			      // they are logged into this app or not.
			      document.getElementById('status').innerHTML = 'Please log ' +
			        'into Facebook.';
			    }
			}


		  function checkLoginState() {
			    FB.getLoginStatus(function(response) {
			      statusChangeCallback(response);
			    });
			  }

		  
				
		$(document).ready(function() {

				window.fbAsyncInit = function() {
				  FB.init({
				    appId      : '<?=$conf['appId']?>',
				    cookie     : true,  // enable cookies to allow the server to access 
				                        // the session
				    xfbml      : true,  // parse social plugins on this page
				    version    : 'v2.2' // use version 2.2
				  });
				
		  	
		  		$('.regUser').click(function() {
		  			fblogin(permission,registerUser);
		  			return false;
		  		});

		  		 FB.getLoginStatus(function(response) {
		  		    statusChangeCallback(response);
		  		  });

		  		  
		  		
			});
		   
		</script>
	
	
		<div id="fb-root"></div>
				
		<div id="userRegistrationForm" >    	
    	   	<input id="userName"	placeholder="userName" 	type="text" /><br/>
           	<input id="userMobile"	placeholder="userMobile" 	type="text" /><br/>
           	<input id="userNRIC"	placeholder="userNRIC" 	type="text" /><br/>
            <input id="userEmail"	placeholder="userEmail"	type="text" /><br/>
       		<a href="#" class="regUser">submit</a>     
		</div>
		
		<div id="getUser" style="display:none">
			<a href="#" class="getuser">getuser</a>  
		</div>
		
		<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
		</fb:login-button>
		
		<div id="status">
		</div>
		
	</body>
	
	
</html>