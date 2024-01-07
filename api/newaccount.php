<?php
namespace newAccount;

class StartCheck{
	private $user;
	private $password;

	public $tokenLol;
	public $tokenRiot;
	public $tokenLedge;
	#public $entitlements;

	// API STUFF
	public $account;
	public $userInfo;
	#public $store; //DEPRECATED, USING LOOT TO GET RP & BE, USERINFO FOR LEVEL
	#public $storeLedge; //DEPRECATED, USING LOOT TO GET RP & BE, USERINFO FOR LEVEL
	public $email;
	public $history;
	public $penalty;
	public $phone;
	public $rankedData;
	public $inventory;
	public $loot;

	public function userInfo(){

		// RIOT USERINFO (ALL INFO)
		$this->userInfo = new \userInfo\UserInfo($this->tokenRiot, "riot");
		if($GLOBALS['debugMode']){
			echo PHP_EOL.'new UserInfo(riot): '.time() - $GLOBALS['startTime'];
		}
		// LOL USERINFO (JWT)
		$userInfo = new \userInfo\UserInfo($this->tokenLol, "lol");
		$this->userInfo->userInfoJwt = $userInfo->userInfoJwt;
		if($GLOBALS['debugMode']){
			echo PHP_EOL.'new UserInfo(lol): '.time() - $GLOBALS['startTime'];
		}

	}

	public function __construct($u, $p){
		if($GLOBALS['debugMode']){
				echo PHP_EOL.'new StartCheck: '.time() - $GLOBALS['startTime'];
		}

		$this->user = $u;
		$this->password = $p;

		$user = new \login\Auth($this->user, $this->password);

		$tokenLol = $user->response['lol'];
		if(!isset($tokenLol['token'])){
			throw new \Exception("Error to login in ".$u.": ".$tokenLol['error']."(".$tokenLol['status'].")");
		}
		$this->tokenLol = $tokenLol['token'];

		$tokenRiot = $user->response['riot'];
		if(!isset($tokenRiot['token'])){
			throw new \Exception("Error to login in ".$u.": ".$tokenRiot['error']."(".$tokenRiot['status'].")");
		}
		$this->tokenRiot = $tokenRiot['token'];

		// USERINFO
		self::userInfo();

		if($this->userInfo->banned){
			$s = " | ";

			$r = "#breakcoder.org$s";
			$r .= "$this->user $s";
		    if ($this->userInfo->banned) {
		        $r .= "⚠️ BANNED [TYPE: {$this->userInfo->banInfo} > REASON: {$this->userInfo->banReason}";
		        if ($this->userInfo->banGame != "null" && $this->userInfo->banGame != "0") {
		            $r .= " > GAME: {$this->userInfo->banGame}";
		        }
		        $r .= " > EXP: {$this->userInfo->banEnd}";
		        $r .= " > BANS: {$this->userInfo->totalBans}]";
		    }

			throw new \Exception($r);
		}

		// ACCOUNT API
		$this->account = new \accountAPI\AccountApi($this->tokenRiot);
		if($GLOBALS['debugMode']){
			echo PHP_EOL.'new AccountApi: '.time() - $GLOBALS['startTime'];
		}

		// STORE -> DEPRECATED, USING LOOT TO GET RP & BE, USERINFO FOR LEVEL
		/*$this->store = new \store\Store($this->tokenLol, $this->userInfo->ledge_region); // NOT USING $this->userInfo->store_region ANYMORE
		if($GLOBALS['debugMode']){
			echo PHP_EOL.'new Store: '.time() - $GLOBALS['startTime'];
		}

		// STORE LEDGE
		$this->storeLedge = new \storeLedge\StoreLedge($this->tokenLol, $this->userInfo->accId, $this->userInfo->ledge_region);
		if($GLOBALS['debugMode']){
			echo PHP_EOL.'new StoreLedge: '.time() - $GLOBALS['startTime'];
		}*/

		// EMAIL
		$this->email = new \email\Email($this->tokenRiot);
		if($GLOBALS['debugMode']){
			echo PHP_EOL.'new Email: '.time() - $GLOBALS['startTime'];
		}

		// LEDGE
		$ledge = new \ledge\Ledge($this->tokenLol, $this->userInfo->userInfoJwt, $this->userInfo->usw_region, $this->userInfo->ledge_region, $this->userInfo->region, $this->userInfo->puuid);
		if($GLOBALS['debugMode']){
			echo PHP_EOL.'new Ledge: '.time() - $GLOBALS['startTime'];
		}

		$ledge->getSession($this->userInfo->banned);
		if($GLOBALS['debugMode']){
			echo PHP_EOL.'$ledge->getSession(): '.time() - $GLOBALS['startTime'];
		}

		$ledge->getToken();
		if($GLOBALS['debugMode']){
			echo PHP_EOL.'$ledge->getToken(): '.time() - $GLOBALS['startTime'];
		}

		$this->tokenLedge = $ledge->tokenLedge;

		// LEDGE API
		if($GLOBALS['debugMode']){
			echo PHP_EOL.'starting LedgeApi: '.time() - $GLOBALS['startTime'];
		}
		$ledgeApi = new \ledgeApi\LedgeApi($this->tokenLedge, $ledge->ledgePrefix, $ledge->region, $this->userInfo->nick, $this->userInfo->puuid, $this->userInfo->loot_region, $this->userInfo->sumId, $this->userInfo->accId);

		$this->history = $ledgeApi->history;
		$this->penalty = $ledgeApi->penalty;
		$this->rankedData = $ledgeApi->rankedData;
		$this->inventory = $ledgeApi->inventory;
		$this->loot = $ledgeApi->loot;

		if($GLOBALS['debugMode']){
			echo PHP_EOL;
		}
	}

	public function returnAccount($mode = "text"){

		if($mode == "text"){
			// SEPARATOR
			$s = " | ";

		    // CHECKER RETURN START
		    $r = "#breakcoder.org$s";

		    if ($this->userInfo->banned) {
		        $r .= "⚠️ BANNED [TYPE: {$this->userInfo->banInfo} > REASON: {$this->userInfo->banReason}";
		        if ($this->userInfo->banGame != "null" && $this->userInfo->banGame != "0") {
		            $r .= " > GAME: {$this->userInfo->banGame}";
		        }
		        $r .= " > EXP: {$this->userInfo->banEnd}";
		        $r .= " > BANS: {$this->userInfo->totalBans}]$s";
		    }

		    // user:password
		    $r .= "🔐 {$this->user}$s";

		    // nick
		    $r .= "👴 OLD NICK: {$this->userInfo->nick}$s";

		    // riot id
		    $r .= "🆔 RIOT ID: {$this->userInfo->riotId} ";
		    $r .= $this->account->riotIdChange['canChange'] ? "(CAN CHANGE)$s" : "({$this->account->riotIdChange['changeDate']})$s";

		    // email
		    $r .= "📧 E-MAIL: {$this->email->emailData['email']}$s";

		    // level
		    $r .= "📖 LEVEL: {$this->userInfo->level}$s";

		    // penalty
		    $r .= $this->penalty['hasPenalty'] == "false" ? "🕕 LEAVEBUSTER: {$this->penalty['hasPenalty']}$s" : "🕕 LEAVEBUSTER: {$this->penalty['hasPenalty']} [{$this->penalty['gamesRemaining']} LEFT]$s";

		    // create time
		    $r .= "👶 CREATE TIME: {$this->userInfo->createTime}$s";

		    if ($this->userInfo->level >= 30) {
		        // soloq
		        $r .= "🥇 SOLOQ: {$this->rankedData['soloq']['tier']} [{$this->rankedData['soloq']['winrate']}] > LAST SEASON: {$this->rankedData['soloq']['lastSeason']}$s";

		        // flex
		        $r .= "🥇 FLEX: {$this->rankedData['flex']['tier']} [{$this->rankedData['flex']['winrate']}] > LAST SEASON: {$this->rankedData['flex']['lastSeason']}$s";
		    }

		    // iactivity
		    $r .= "💤 LAST GAME: {$this->history['lastGameDate']} ({$this->history['inactiveTime']})$s";

		    // skin count
		    $sCount = $this->inventory['skinsCount'];
		    $r .= $sCount > 1 ? "👚 SKINS: {$sCount}$s" : "👚 SKIN: {$sCount}$s";

		    // champions
		    $cCount = $this->inventory['championsCount'];
		    $r .= $sCount > 1 ? "⚔ CHAMPIONS: {$cCount}$s" : "⚔ CHAMPION: {$cCount}$s";

		    // be
		    $r .= "💰 BE: {$this->loot['be']}$s";

			// rp
			$r .= "💰💰💰 RP: {$this->loot['rp']}$s";
			
			// gem
			$r .= $this->loot['gem'] > 1 ? "💎 GEMS: {$this->loot['gem']}$s" : "💎 GEM: {$this->loot['gem']}$s";

			// chest
			$r .= $this->loot['chest'] > 1 ? "🎁 CHESTS: {$this->loot['chest']}$s": "🎁 CHEST: {$this->loot['chest']}$s";

			// key
			$r .= $this->loot['key'] > 1 ? "🗝 KEYS: {$this->loot['key']}$s" : "🗝 KEY: {$this->loot['key']}$s";

			// first champions
			$r .= "⚔ FIRST CHAMPS: ";

			for($i = 0; $i < count($this->inventory['champions']); $i++){
				$r .= "{$this->inventory['champions'][$i]['name']} ({$this->inventory['champions'][$i]['purchaseDate']})";
				if($i != count($this->inventory['champions']) - 1){
					$r .= " > ";
				}
			}
			$r .= $s;

			// first skins
			$r .= "👚 FIRST SKINS: ";

			for($i = 0; $i < count($this->inventory['skins']); $i++){
				$r .= "{$this->inventory['skins'][$i]['name']} ({$this->inventory['skins'][$i]['purchaseDate']})";
				if($i != count($this->inventory['skins']) - 1){
					$r .= " > ";
				}
			}

			//$r .= " | JWT ( {$this->userInfo->userInfoJwt} )";


			echo $r;
		}elseif($mode == "json"){

		}else{
			throw new \Exception("Error Invalid mode ($mode) called in returnAccount(mode)");
		}



	}

}




?>