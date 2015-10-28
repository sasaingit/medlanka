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
		var appId = null;
		var permission = null; 
		var actionUrl = null;
		var appUser = null;
		
		$(document).ready(function() {
				 appId 		= '<?=$conf['appId']?>';
				 permission = {scope: '<?=$conf['fb_permission']?>'}; 
				 actionUrl 	= '<?=$conf['action_url']?>';
							
			  	window.fbAsyncInit = function() {
				    FB.init({
				      appId      : '<?=$conf['appId']?>', // App ID
				      status     : true, // check login status
				      cookie     : true, // enable cookies to allow the server to access the session
				      xfbml      : true  // parse XFBML
				    });
	
			  	};
		  	
		  		$('.addComment').click(function() {
		  			fblogin(permission,addComment);
		  			return false;
		  		});

		  		
		  		
			});
		   
		</script>
	
	
		<div id="fb-root"></div>
				
		<div id="userRegistrationForm" >    	
    	   	<input id="doc_id"			placeholder="doc_id" 			type="text" /><br/>
           	<input id="friendlyness"	placeholder="friendlyness" 		type="text" /><br/>
           	<input id="knowledge"		placeholder="knowledge" 		type="text" /><br/>
            <input id="punctuality"		placeholder="punctuality"		type="text" /><br/>
            <input id="treatment_time"	placeholder="treatment_time"	type="text" /><br/>
            <input id="comment"			placeholder="comment"			type="text" /><br/>
       		<a href="#" class="addComment">Add comment</a>     
		</div>
		
		<div id="getUser" style="display:none">
			<a href="#" class="getuser">getuser</a>  
		</div>
		
	</body>
	
	
</html>