<?php

class AppFb{
	
	public $user = null;
	public $conf = array();
				
	public function init($conf){	
		$this->conf = $conf;			
	}
		
	public function fbauth($at){
		
		if(empty($at)){
			return false;
		}
		
		$me = $this->getMe($at);
		if(empty($me['id']) || ($me['id']!=$_REQUEST['fb_id'])){
			return false;
		}
		$this->user->fb_id 			= $me['id'];
		$this->user->access_token 	= $this->getExtendedAt($at);
		$this->user->email 			= $me['email'];
		$this->user->name 			= $me['name'];

		return $this->user;
	}	
	
	public function getExtendedAt($at){
		if(empty($at)){
			return false;
		}
		
		$fbRequests[] = 'oauth/access_token?client_id='.$this->conf['appId'].'&client_secret='.$this->conf['appSecret'].'&grant_type=fb_exchange_token&fb_exchange_token='.$at;
		// Run the curl
		$batchData = array();
		foreach ($fbRequests as $fbRequest) {
			$batchData[] = '{"method": "GET", "relative_url": "'.$fbRequest.'"}';
		}
		$curl_command = "curl -F 'access_token=".$at."' -F 'batch=[".implode(",", $batchData)."]' ".'https://graph.facebook.com';
		$curl_result = exec($curl_command);
		$fbBatchData = json_decode($curl_result, true);
		
		$array1 = explode("&", $fbBatchData[0]['body']);
		$array2 = explode("=",$array1[0]);
		$extended_access_token = $array2[1];
		error_log($extended_access_token);
		if(empty($extended_access_token)){
			return $at;
		}else{
			return $extended_access_token;
		}
		
	}
	
	public function	getMe($token) {
			if(empty($token)){
				return null;
			}
		
			$fbRequests = array('me', 'me/permissions');
		
		   	foreach ($fbRequests as $fbRequest) {
		    	$batchData[] = '{"method": "GET", "relative_url": "'.$fbRequest.'"}';
		   	}
			$curl_command = "curl -F 'access_token=".$token."' -F 'batch=[".implode(",", $batchData)."]' ".'https://graph.facebook.com';
		   	$curl_result = exec($curl_command);
		  	$fbBatchData = json_decode($curl_result, true);

		  	$me = json_decode($fbBatchData[0]['body'], true);
		  	$permissions = json_decode($fbBatchData[1]['body'], true);
			if(is_null($permissions) || !isset($permissions['data'])) {
				$permissions = array();
			}
			else {
				$permissions = array_keys($permissions['data'][0]);
			}
		  	$me['permissions'] = $permissions;

		   return $me;
		
	}
	
}





?>