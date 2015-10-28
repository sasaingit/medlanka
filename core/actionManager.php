<?php

class actionManager{
	
	public $manager = null;
	public $appFb = null;
	
	public function handleAction($user,$method,$params,$manager,$appFb){
		$this->manager 	= $manager;
		$this->appFb 	= $appFb;
		$ret->status 	= '0';
		$ret->data 		= null;
		
		if(empty($method)){
			return $ret;
		}else if(!method_exists($this,$method)){
			return $ret;
		}else{
			return $this->$method($user,$params);
		}
	}
	
	private function createUser($user,$params){
		$init_user 		= new stdClass();
		$fb_id 			= $params['fb_id'];
		$access_token 	= $params['access_token'];
				
		$me 			= $this->appFb->getMe($access_token);
		$access_token 	= $this->appFb->getExtendedAt($access_token);
		
		//check for invalid at
		if(empty($me['id']) || ($me['id']!=$fb_id)){
			return false;
		}
		
		$init_user->fb_id 			= $fb_id;
		$init_user->access_token 	= $access_token;
		$init_user->email 			= $me['email'];
		$init_user->name 			= $me['name'];
		$ret->data 					= $this->manager->createUser($init_user);
		if(!empty($ret->data)){
			$ret->status = '1';
		}else{
			$ret->status = '0';
		}
		return 	$ret;
	}
	
	private function registerUser($user,$params){
		$user_attrs = $user->getAttributeNames();
		error_log("params:".print_r($params,true));
		foreach($params as $key=>$val){
			if(in_array($key, $user_attrs) && !empty($val)){
				$user->$key = $val;
			}
		}
		error_log("user for reg:".print_r($user,true));
		$ok = $user->save();
		if($ok){
			$ret->status = '1';
			$ret->data = $user;
		}else{
			$ret->status = '0';
			$ret->data = null;
		}
		return $ret;
	}
	
	
	
}



?>