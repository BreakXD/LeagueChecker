<?php
namespace store;

class Store{
	//DEPRECATED

	private $token;

	public $storeData;

	public function __construct($token, $storePrefix){
		$this->token = $token;

		//$apiUrl = "https://".$storePrefix.".store.leagueoflegends.com/storefront/v3/history/purchase?language=en_US";
		$apiUrl = "https://".$storePrefix.".lol.sgp.pvp.net/storefront/v3/history/purchase?language=en_US";
		$header = array(
            "Accept: application/json",
            "User-Agent: RiotClient/18.0.0 (lol-store)",
            "Authorization: Bearer ".$this->token."" 
        );

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

	    $result = json_decode(curl_exec($ch), 1);
	    curl_close($ch);

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

	}

}



?>