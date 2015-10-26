<?php include("includes.php"); ?>

<?php 

$appFb = new AppFb();
$appFb->init($conf);
$appFb->fbauth();
$init_user = $appFb->user;
error_log("user:".print_r($init_user,true));
$page_liked = $appFb->page_liked;

$manager = new appManager();
$manager->init($conf);
$user = $manager->setupUser($init_user);

session_start();
$_SESSION[$conf['appId'].'_user_fb_id'] = isset($user->fb_id)?$user->fb_id:null; // store session data
session_write_close ();

//var_dump($user);

?>

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
				 appId = '<?=$conf['appId']?>';
				 permission = {scope: '<?=$conf['fb_permission']?>'}; 
				 actionUrl = '<?=$conf['action_url']?>';
				 appUser = $.parseJSON( '<?=json_encode($init_user)?>' );
			
			  	window.fbAsyncInit = function() {
				    FB.init({
				      appId      : '<?=$conf['appId']?>', // App ID
				      channelUrl : '//web-stalk.com/ws/other/standalone_basic/channel.html', // Channel File
				      status     : true, // check login status
				      cookie     : true, // enable cookies to allow the server to access the session
				      xfbml      : true  // parse XFBML
				    });
	
			  	};
		  	
		  		$('.regUser').click(function() {
		  			fblogin(permission,registerUser);
		  			return false;
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
		
	</body>
	
	
</html>