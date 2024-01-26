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

	public function submitRiotId($name, $tag){
		if(!$this->riotIdChange['canChange']) return "Error during Riot ID change!";

		$header = $this->header;
		array_push($header, "Content-Type: application/json");

		$curl_option = $this->curl_options;

		$curl_option[CURLOPT_POSTFIELDS] = json_encode(array(
			"game_name" => $name,
			"tag_line" => $tag
		));
		$curl_option[CURLOPT_HTTPHEADER] = $header;


		$url = "{$this->baseUrl}/aliases/v1/aliases";

		$ch = curl_init($url);
		curl_setopt_array($ch, $curl_option);

		$result = curl_exec($ch);
		curl_close($ch);

		$result_json = json_decode($result,1);
		if(isset($result_json['game_name']) && $result_json['game_name'] == $name){
			return "Riot ID now is $name\#$tag!";
		}else{
			return "Error during Riot ID change!: $result";
		}
	}

}




?>