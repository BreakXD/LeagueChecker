<?php
namespace email;

class Email{

	public $emailData;

	public function __construct($token){
		$apiUrl = "https://email-verification.riotgames.com/api/v1/account/status";

		$header = array(
	        "User-Agent: RiotClient/18.0.0 (lol-store)",
	        "Accept: application/json",
	        "Authorization: Bearer ".$token
	    );

		$ch = curl_init($apiUrl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		$result = json_decode(curl_exec($ch), 1);
		curl_close($ch);

		$email = $result['email'];
		
		if(isset($result['emailVerified'])){
			$verified = $result['emailVerified'];
		}else{
			$verified = null;
		}

		$this->emailData = array(
			"email" => $email,
			"verified" => $verified
		);

	}
}


?>