<?php
class appManager{
	
	public function init($conf){
		
	}
	
	public function setupUser($init_user){
		if(!isset($init_user->fb_id) || empty($init_user->fb_id)){
			return null;
		}
		
		$user = $this->getUserByFbId($init_user->fb_id);
		if(empty($user->fb_id)){
			$user = $this->createUser($init_user);
		}
		
		return $user;		
	}
	
	public function getUserByFbId($fb_id){
		$user = new user();
		$user->load("fb_id = ?",array($fb_id));
		return $user;
	}
	
	public function createUser($init_user){
		$user = new User();
		$user->fb_id = $init_user->fb_id;
		$user->name = $init_user->name;
		$user->email = $init_user->email;
		$user->dob = $init_user->dob;
		$user->gender = $init_user->gender;
		$user->access_token = $init_user->access_token;
		$ok = $user->save();
		if($ok){
			return $user;
		}else{
			return null;
		}
	}
	
	
	
}



?>