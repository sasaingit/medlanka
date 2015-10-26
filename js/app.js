
  function fblogin(fb_permission,clbk){
	  var fbAuthCallbk = function(response){
		  if (response && response.authResponse) {
			  if(response.status = 'connected'){
					if($.isFunction(clbk)){
						clbk();
					}else{
						showMessage('internal error');
					}
			  }else{
				  	createUser(response.authResponse.accessToken,response.authResponse.userID,clbk);
			  }
			  
			} else {
				showMessage('not authenticated');
			}
		  
	  };
	  FB.login(fbAuthCallbk, fb_permission);
  }  
  
  
  function createUser(at,fbid,clbk){	  
	  	var params = {"method":"createUser","access_token":at,"fb_id":fbid};
		$.post(actionUrl, params,function(data){
			if(data.status == '1'){
				appUser = data.data;
				if($.isFunction(clbk)){
					clbk();
				}
			}else{
				showMessage('user creation failed!');
			}
								
		},"json");
  }
   
  function registerUser(){
	  var params 		= new Object();
	  params.name  		= $('#userName').val();
	  params.email  	= $('#userEmail').val(); 
	  params.ic  		= $('#userNRIC').val(); 
	  params.mobile  	= $('#userMobile').val(); 
	  params.method  	= 'registerUser'; 
	  
	  $.post(actionUrl, params,function(data) {		  
		  	if(data.status == '1'){
		  		appUser = data.data;
		  		$('#userRegistrationForm').hide();
		  		showMessage('successfully registered!');
			}else{
				showMessage('user registration failed!');
			}
	  },"json");
  }
  
  function showMessage(msg){
	 alert(msg);
  }
  
  
  
  
	
