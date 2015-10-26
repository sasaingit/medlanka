<?php

class AppFb{
	
	public $user = null;
	public $page_liked = false;
	public $conf = array();
				
	public function init($conf){	
		$this->conf = $conf;			
	}
		
	public function fbauth(){		
		$response = $this->parse_signed_request($_REQUEST['signed_request'],$this->conf['appSecret']);
		
		if(!empty($response) && !empty($response['user_id']) && !empty($response['oauth_token'])){
			$this->user->fb_id = $response['user_id'];
			$this->user->access_token = $this->getExtendedAt($response['oauth_token']);
			$me = $this->getMe($this->user->access_token);
						
			$this->user->dob = $me['birthday'];
			$this->user->gender = $me['gender'];
			$this->user->email = $me['email'];	
			$this->user->name = $me['name'];
		}
		
		$pageSr = $this->parsePageSignedRequest();
		$this->page_liked = $pageSr->page->liked;
		
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
		
	private function parsePageSignedRequest() {
		if (isset($_REQUEST['signed_request'])) {
			$encoded_sig = null;
			$payload = null;
			list($encoded_sig, $payload) = explode('.', $_REQUEST['signed_request'], 2);
			$sig = base64_decode(strtr($encoded_sig, '-_', '+/'));
			$data = json_decode(base64_decode(strtr($payload, '-_', '+/'), true));
			return $data;
		}
		return false;
	}
	
	private function parse_signed_request($signed_request, $secret) {
		if(empty($signed_request))return null;
		list($encoded_sig, $payload) = explode('.', $signed_request, 2);
	
		// decode the data
		$sig = $this->base64_url_decode($encoded_sig);
		$data = json_decode($this->base64_url_decode($payload), true);
	
		if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
			error_log('Unknown algorithm. Expected HMAC-SHA256');
			return null;
		}
	
		// check sig
		$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
		if ($sig !== $expected_sig) {
			error_log('Bad Signed JSON signature!');
			return null;
		}
	
		return $data;
	}
	
	private function base64_url_decode($input) {
		return base64_decode(strtr($input, '-_', '+/'));
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