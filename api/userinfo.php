<?php
namespace userInfo;

class UserInfo{

	public $userInfoJwt;

	public $puuid;
	public $accId;
	public $sumId;
	public $level;
	public $riotId;
	public $nick;
	public $createTime;

	public $region;
	public $usw_region;
	public $ledge_region;
	public $store_region;
	public $loot_region;

	public $banned;
	public $totalBans;
	public $banInfo;
	public $banReason;
	public $banGame;
	public $banEnd;

	public function __construct($token, $type){
		$apiUrl = "https://auth.riotgames.com/userinfo";

		$header = array(
	        "Accept: application/json",
	        "User-Agent: RiotClient/18.0.0 (lol-store)",
	        "Authorization: Bearer ".$token
	    );


		$ch = curl_init($apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		$result = curl_exec($ch);
		curl_close($ch);

		if($type == "lol"){
			$this->userInfoJwt = $result;
			//echo $result;
		}elseif($type == "riot"){
			//echo $result;

			$r = json_decode($result, 1);

			$this->puuid = $r['sub'];
			$this->accId = $r['original_account_id'];
			$this->sumId = $r['lol_account']['summoner_id'];
			$this->level = (int)$r['lol_account']['summoner_level'];
			$this->riotId = $r['acct']['game_name']. '#' .$r['acct']['tag_line'];
			$this->nick = strlen($r['lol_account']['summoner_name']) >= 1 ? $r['lol_account']['summoner_name'] : "WITHOUT_NICK";
			$this->createTime = date('d/m/Y', $r['acct']['created_at'] / 1000);

			for($i = 0; $i < count($r['lol_region']); $i++){
				if($r['lol_region'][$i]['active']){
					$this->region = $r['lol_region'][$i]['cpid'];
					break;
				}
			}

			$this->usw_region = $GLOBALS['config']['endpoint']['usw_region'][$this->region];
			$this->ledge_region = $GLOBALS['config']['endpoint']['ledge_region'][$this->region];
			$this->store_region = $GLOBALS['config']['endpoint']['store_region'][$this->region];
			$this->loot_region = $GLOBALS['config']['endpoint']['loot_region'][$this->region];
			
			//echo $r['ban']['exp'].' > '.time() * 1000;

			$this->totalBans = count($r['ban']['restrictions']);
			for($i = 0; $i < $this->totalBans; $i++){
				$b = $r['ban']['restrictions'][$i];
				$trigger_scope = array("lol", "riot");
				$ignore_type = array("TEXT_CHAT_RESTRICTION");

				if(in_array($b['scope'], $trigger_scope) && !in_array($b['type'], $ignore_type)){
					$this->banned = true;
					$this->banInfo = $b['type'];
					$this->banReason = $b['reason'];
					$this->banGame = isset($b['dat']['gameData']['triggerGameId']) ? $b['dat']['gameData']['triggerGameId'] : "null";

					if(isset($b['dat']['expirationMillis'])){
						$banEnd = ($b['dat']['expirationMillis'] / 1000) - time();
						$banEnd = (($banEnd / 60) / 60) / 24;

						if($banEnd > 1000){
							$this->banEnd = 'PERMANENT_BAN';
						}else{
							$this->banEnd = $banEnd > 1 ? (int)$banEnd.' days LEFT' : (int)$banEnd.' day LEFT';
						}

					}else{
						$this->banEnd = 'PERMANENT_BAN';
					}
					break;
				}
			}
			
			if($this->banned != true){
				$this->banned = false;
			}
		}

	}

}


?>