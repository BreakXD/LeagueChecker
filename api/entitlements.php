<?php
namespace entitlements;

class Entitlements{
	public $entitlementsToken;

	public function __construct($token){
		$apiUrl = "https://entitlements.auth.riotgames.com/api/token/v1";

		$header = array(
	        "Accept: application/json",
	        "User-Agent: RiotClient/18.0.0 (lol-store)",
	        "Content-Type: application/json",
	        "Authorization: Bearer ".$token
	    );

	    $ch = curl_init($apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{}");
		$result = json_decode(curl_exec($ch), 1);
		curl_close($ch);
		
		$this->entitlementsToken = $result['entitlements_token'];
	}

}


?>