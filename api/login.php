<?php

namespace login;

class Auth{
	private $user;
	private $password;
	private $apiUrl = "https://api.hydranetwork.org/";
	private $key;
	private $client_id;
	private $curl_options;
	private static $header = array("Content-Type: application/json");

	public $response;
	public $data;

	public function __construct($u, $p){
		$this->key =  $GLOBALS['config']['variable']['hydra_key'];

		$this->user = $u;
		$this->password = $p;

		$this->data = array(
			"login" => $this->user,
			"pass" => $this->password,
			"hnkey" => $this->key
		);

		$this->client_id = array("lol", "riot-client");

		self::getTokens();
	}

	private static function curl_options($data){
		$curl_options = array(
	    	CURLOPT_HTTPHEADER => self::$header,
	    	CURLOPT_RETURNTRANSFER => 1,
	    	CURLOPT_SSL_VERIFYPEER => 0,
	    	CURLOPT_SSL_VERIFYHOST => 0,
	    	CURLOPT_POSTFIELDS => $data
	    );

	    return $curl_options;
	}

	private function getTokens(){
		$ch = array();
		$mh = curl_multi_init();
		$active = 1;
		$resultArray = array();

		for($i = 0; $i < 2; $i++){

			$ch[$i] = curl_init($this->apiUrl);

			$this->data['client_id'] = $this->client_id[$i];
			$data = json_encode($this->data);

			curl_setopt_array($ch[$i], self::curl_options($data));

			curl_multi_add_handle($mh, $ch[$i]);
		}

		while($active){
			curl_multi_exec($mh, $active);
		}

		for($i = 0; $i < 2; $i++){
			curl_multi_remove_handle($mh, $ch[$i]);

			$r = curl_multi_getcontent($ch[$i]);
			$result = json_decode($r, 1);

			$type = $i == 0 ? "lol" : "riot";

			if($GLOBALS['debugMode']){
				echo PHP_EOL.'getTokens('.$type.'): '.time() - $GLOBALS['startTime'];
			}

			if(!isset($result['status'])){ // CHECK FOR 429 OR OTHER ERROR
				$resultArray[$type] = array("status" => "unknown", "error" => $r);
			}

			if($result['status'] == "1"){ // CHECK IF ACCOUNT IS CORRECT
				$resultArray[$type] = array("status" => $result['status'], "token" => $result['token'] );
			}else{
				$resultArray[$type] = array("status" => $result['status'], "error" => $result['error'] );
			}
			
		}

		curl_multi_close($mh);

		$this->response = $resultArray;

	}

}




?>