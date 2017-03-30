<?php

class WiseWireRegisterPlatformItem{

	private $wpdb;
 	
	public function __construct() {
			
		// //////////////////////////////////////////////////////////////////// PRODUCT API CALL
		if (WAN_TEST_ENVIRONMENT){		

			$this->WW_API_LP_URL = 'http://test-platform.wisewire.com:8081/api/user/createAuthCodeForUser';
			$this->WW_API_LP_URL_2 = 'http://test-platform.wisewire.com:8081/api/oauth2/token/request';
			$this->WW_API_LP_URL_3 = 'http://test-platform.wisewire.com:8081/api/purchased/save';
			$this->WW_API_LP_CLIENT_ID = '37e7098c85e30d60dd2a';
			$this->WW_API_LP_CLIENT_SECRET = '1bac2b21197af84220c6d73092ccd168be060950';
			$this->WW_REDIRECT_URI = 'http://test-mkt-site.wisewire.com/user-login';

		} else {

			$this->WW_API_LP_URL = 'https://api.wisewire.com/api/user/createAuthCodeForUser';
			$this->WW_API_LP_URL_2 = 'https://api.wisewire.com/api/oauth2/token/request';
			$this->WW_API_LP_URL_3 = 'https://api.wisewire.com/api/purchased/save';
			$this->WW_API_LP_CLIENT_ID = '0a6a625ccb0cd7417f78';
			$this->WW_API_LP_CLIENT_SECRET = 'c3c068c693b2609d92353012193a086d3e069f01';
			$this->WW_REDIRECT_URI = 'http://wisewire.com/user-login';

		}
    
	}
	
	
	
 public function platform_order_call($API, $data) {
			  
		$data_string = json_encode($data);			
		$header = array(                                                                          
				'Content-Type: application/json',                                                                                
				'Content-Length: ' . strlen($data_string)
				);

		$ch = curl_init($API);		
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if(!curl_exec($ch)){
			die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
		}
		$result = curl_exec( $ch );			
		$json = json_decode($result);
		return $json;
		
}
			  
public function register_items($sku, $token,$type){

	$data_3 = array(
	  'access_token' => $token,
	  'objectId' => $sku,
	  'objectType' => $type
	);

   $s3 = $this->platform_order_call($this->WW_API_LP_URL_3, $data_3);			

  if($s3->error){
	  echo $s3->error;
  }
  
  return $s3;


}

public function platform_access_calls(){
	
		/*First Call - To get a new Access Code*/
			$user_id = get_current_user_id();
			$user_info = get_userdata($user_id);
			
			$data = array(
				'username' => $user_info->user_login,
				'email' => $user_info->user_email,
				'password' => $user_info->user_pass,
				'fullName' => $user_info->first_name." ".$user_info->last_name, 
				'disposition' => 'educator',				
				'client_id' => $this->WW_API_LP_CLIENT_ID,	
			    'redirect_uri' => $this->WW_REDIRECT_URI,
			    'type' => "web_server"
			 );

			$s1 = $this->platform_order_call($this->WW_API_LP_URL, $data);				
			
			// print_r($s1);
			
			$requested_code = $s1->code;	
			
			
			/*Second Call - Create a new User if not exist / To get a New Token */
			$data_2 = array(					
				'client_id' => $this->WW_API_LP_CLIENT_ID,	
			    'client_secret' => $this->WW_API_LP_CLIENT_SECRET,
			    "code" => $requested_code,
			    'redirect_uri' => $this->WW_REDIRECT_URI,
			);		
		
			$s2 = $this->platform_order_call($this->WW_API_LP_URL_2, $data_2);			
			$token = $s2->access_token;
			
			return $token;
	
}

	
	
}