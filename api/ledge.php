<?php
namespace ledge;


class Ledge{

	private $tokenLol;
	private $userInfoJwt;

	private $puuid;

	private $sessionToken;
	public $tokenLedge;

	public $uswPrefix;
	public $ledgePrefix;
	public $region;

	public function __construct($token, $userInfoJwt, $uswPrefix, $ledgePrefix, $region, $puuid){
		$this->tokenLol = $token;
		$this->userInfoJwt = $userInfoJwt;
		$this->uswPrefix = $uswPrefix;
		$this->ledgePrefix = $ledgePrefix;
		$this->region = $region;
	}

	public function getToken(){
		$header = array(
	        "Content-Type: application/json",
	        "Accept: application/json",
	        "User-Agent: LeagueOfLegendsClient/12.2.418.8114 (rcp-be-lol-login)",
	        "Authorization: Bearer ".$this->sessionToken
	    );

	    $data = json_encode(array(
		        'claims' => array(
		                'cname' => 'lcu'
		        ),
		        'product' =>  'lol',
		        'puuid' => $this->puuid,
		        'region' => strtolower($this->region)
			)
		);

		$apiUrl = 'https://'.$this->uswPrefix.'.pp.sgp.pvp.net/session-external/v1/session/create';

		$ch = curl_init($apiUrl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		$result = curl_exec($ch);
		curl_close($ch);

		$this->tokenLedge = str_replace('"','',$result);

	}

	public function getSession($banned){
		$header = array(
	        "Content-Type: application/json",
	        "Accept: application/json",
	        "User-Agent: LeagueOfLegendsClient/12.2.418.8114 (rcp-be-lol-login)",
	        "Authorization: Bearer ".$this->tokenLol
	    );
		$data_array = array(
	        'clientName' => 'lcu',
	        'userinfo' => $this->userInfoJwt
		);

		$apiUrl = 'https://'.$this->uswPrefix.'.pp.sgp.pvp.net/login-queue/v2/login/products/lol/regions/'.$this->region;
		$data = json_encode($data_array);

		$ch = curl_init($apiUrl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		$result = json_decode(curl_exec($ch), 1);
		curl_close($ch);

		$this->sessionToken = $result['token'];
	}


}


?>