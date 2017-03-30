<?php
if (WAN_TEST_ENVIRONMENT){

	define('WW_API_LP_URL','http://test-platform.wisewire.com:8081/api/user/createAuthCodeForUser');
	define('WW_API_LP_URL_2','http://test-platform.wisewire.com:8081/api/oauth2/token/request');
	define('WW_API_LP_CLIENT_ID','37e7098c85e30d60dd2a');
	define('WW_API_LP_CLIENT_SECRET','1bac2b21197af84220c6d73092ccd168be060950');
	define('REDIRECT_LOCATION','http://test-platform.wisewire.com/auth/token/');
	define('REDIRECT_LOCATION_FAVORITE','http://test-platform.wisewire.com/auth/favorite/');
	define('REDIRECT_URI','http://test-mkt-site.wisewire.com/user-login');
	

} else {

	define('WW_API_LP_URL','https://api.wisewire.com/api/user/createAuthCodeForUser');
	define('WW_API_LP_URL_2','https://api.wisewire.com/api/oauth2/token/request');
	define('WW_API_LP_CLIENT_ID','0a6a625ccb0cd7417f78');
	define('WW_API_LP_CLIENT_SECRET','c3c068c693b2609d92353012193a086d3e069f01');
	define('REDIRECT_LOCATION','https://platform.wisewire.com/auth/token/');
	define('REDIRECT_LOCATION_FAVORITE','https://platform.wisewire.com/auth/favorite/');
	define('REDIRECT_URI','http://wisewire.com/user-login');

}

class Controller_BecomeAuthor {
	
	
	public $redirect_location; 
	public $token;
	
	public function __construct($type_request_page, $itemId='', $itemType='') {
		
		$this->redirect_location = 	REDIRECT_LOCATION;	

		/* If comes from openstax request */
		if( $itemId!="" && $itemType!="" ){
			$this->redirect_location = 	REDIRECT_LOCATION_FAVORITE;
		}
		
		if (  is_user_logged_in() ){
			/*First Call - To get a new Access Code*/
			$user_id = get_current_user_id();
			$user_info = get_userdata($user_id);
			$is_oauth = (get_user_meta( $user_id, 'wpoa_identity', true ) ? true :  false);

			if ($is_oauth){
				$email = get_user_meta( $user_id, 'email', true );
				$username = $email;
			}else{
				$email = $user_info->user_email;
				$username = $user_info->user_login;
			}

			$data = array(
				'username' => $username,
				'email' => $email,
				'password' => $user_info->user_pass,
				'fullName' => $user_info->first_name." ".$user_info->last_name,
				'disposition' => 'educator',				
				'client_id' => WW_API_LP_CLIENT_ID,	
				'itemId' => $itemId,	
				'itemType' => $itemType,
			    'redirect_uri' => REDIRECT_URI,
			    'type' => "web_server",
			    'optionFromMKTSite' => $type_request_page // request, publish
			 );

			$s1 = $this->learning_pod_service(WW_API_LP_URL, $data);
			$requested_code = $s1->code;	

			
			/*Second Call - Create a new User if not exist / To get a New Token */
			$data_2 = array(					
				'client_id' => WW_API_LP_CLIENT_ID,	
			    'client_secret' => WW_API_LP_CLIENT_SECRET,
			    "code" => $requested_code,
			    'redirect_uri' => REDIRECT_URI,
			);		
		
			$s2 = $this->learning_pod_service(WW_API_LP_URL_2, $data_2);			
			$this->token = $s2->access_token;
		}
		else{
			echo "No user logged in";
			die();
		}
		
	}


	private function learning_pod_service($API, $data) {

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


	
}