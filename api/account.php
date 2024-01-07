<?php

namespace accountAPI;

class AccountApi{
	//INTERNAL VARIABLES
	private $header;
	private $baseUrl;
	private $curl_options;

	//API ARRAYS
	public $riotIdChange;

	public function __construct($token){
		$this->header = array(
	        "Accept: application/json",
	        "User-Agent: RiotClient/18.0.0 (lol-store)",
	        "Authorization: Bearer ".$token
	    );

	    $this->curl_options = array(
	    	CURLOPT_HTTPHEADER => $this->header,
	    	CURLOPT_RETURNTRANSFER => 1,
	    	CURLOPT_SSL_VERIFYPEER => 0,
	    	CURLOPT_SSL_VERIFYHOST => 0
	    );

	    $this->baseUrl = "https://api.account.riotgames.com";

	    self::riotIdChange();
	}

	public function riotIdChange(){
		$url = "{$this->baseUrl}/aliases/v1/eligibility";

		$ch = curl_init($url);
		curl_setopt_array($ch, $this->curl_options);

		$result = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($result,1);
		if(!isset($result['eligible'])){
			$return['canChange'] = true;
			$return['changeDate'] = "01/33/7";
			$this->riotIdChange = $return;

			return $this->riotIdChange;
		}

		$canChange = $result['eligible'];
		$elegibleAfterMS = intval($result['eligibleAfter'] / 1000);
		$eligibleAfter = date('d/m/Y', $elegibleAfterMS);

		$return['canChange'] = $canChange;
		$return['changeDate'] = $eligibleAfter;
		$this->riotIdChange = $return;

		return $this->riotIdChange;
	}

}




?>