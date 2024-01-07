<?php
namespace storeLedge;

class storeLedge{

	public $storeData;

	private $apiBaseUrl;
	private $token;
	private $accId;
	private $curl_options;

	public function __construct($token, $accId, $ledgePrefix){
		$this->apiBaseUrl = "https://".$ledgePrefix.".lol.sgp.pvp.net";
		$this->accId = $accId;
		$this->token = $token;

		$headerStore = array(
	        "Content-Type: application/json",
	        "Accept: application/json",
	        "authorization: Bearer ".$this->token
	    );

	    $this->curl_options = array(
	    	CURLOPT_HTTPHEADER => $headerStore,
	    	CURLOPT_RETURNTRANSFER => 1,
	    	CURLOPT_SSL_VERIFYPEER => 0,
	    	CURLOPT_SSL_VERIFYHOST => 0
	    );

	    self::getStoreData();
	}

	private function ledgeBase($endpoint){
		return curl_init($this->apiBaseUrl.$endpoint);
	}

	private function getStoreData(){
		$ch = self::ledgeBase("/storefront/v3/history/purchase?language=en_US");

		curl_setopt_array($ch, $this->curl_options);

		$result = json_decode(curl_exec($ch), 1);
		curl_close($ch);

		if(isset($result['player']['rp'])){

			$rp = $result['player']['rp'];
		    $be = $result['player']['ip'];
		    $level = $result['player']['summonerLevel'];
		    $refunds = $result['refundCreditsRemaining'];

		    $this->storeData = array(
		    	"rp" => $rp,
		    	"be" => $be,
		    	"level" => $level,
		    	"refunds" => $refunds
		    );
		}else{
			throw new \Exception(json_encode($result));
		}

	}

}



?>