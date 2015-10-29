
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
   
  function addComment(){
	  var params 			= new Object();
	  params.doc_id  		= $('#doc_id').val();
	  params.friendlyness  	= $('#friendlyness').val(); 
	  params.knowledge  	= $('#knowledge').val(); 
	  params.punctuality  	= $('#punctuality').val(); 
	  params.treatment_time = $('#treatment_time').val();
	  params.comment  		= $('#comment').val();
	  params.method  		= 'addComment'; 
	  
	  $.post(actionUrl, params,function(data) {		  
		  	if(data.status == '1'){
		  		showMessage('comment added successfully!');
			}else{
				showMessage('operation failed!');
			}
	  },"json");
  }
  
  function showMessage(msg){
	 alert(msg);
  }
  
  
  
  
	
