<?php
namespace ledgeApi;

class LedgeApi{
	private $store;
	private $token;
	private $header;
	private $apiBaseUrl;
	private $region;
	private $nick;
	private $puuid;
	private $lootRegion;
	private $sumId;
	private $accId;
	private $transactionId;
	private $curl_options;

	// API ARRAYS
	public $history;
	public $penalty;
	public $phone;
	public $rankedData;
	public $inventory;
	public $loot;

	public function __construct($token, $ledgePrefix, $region, $nick, $puuid, $lootRegion, $sumId, $accId){
		$this->token = $token;
		$this->header = array(
	        "Content-Type: application/json",
	        "Accept: application/json",
	        "User-Agent: LeagueOfLegendsClient/12.2.418.8114 (rcp-be-lol-login)",
	        "authorization: Bearer ".$this->token
	    );

	    $this->region = $region;
	    $this->apiBaseUrl = "https://".$ledgePrefix.".lol.sgp.pvp.net";
	    $this->nick = str_replace(" ", "", $nick);
	    $this->puuid = $puuid;
	    $this->lootRegion = $lootRegion;
	    $this->sumId = $sumId;
	    $this->accId = $accId;

	    $this->curl_options = array(
	    	CURLOPT_HTTPHEADER => $this->header,
	    	CURLOPT_RETURNTRANSFER => 1,
	    	CURLOPT_SSL_VERIFYPEER => 0,
	    	CURLOPT_SSL_VERIFYHOST => 0
	    );

	    self::getAllData();
	}
 
	private function getAllData(){
		$ch = array();
		$mh = curl_multi_init();

		$api_array = array(
			"history" => "/summoner-ledge/v1/regions/".$this->region."/summoners/name/".$this->nick,
			"penalty" => "/leaverbuster-ledge/getEntry",
			"ranked" => "/leagues-ledge/v2/signedRankedStats",
			"inventory" => "/lolinventoryservice-ledge/v1/inventoriesWithLoyalty?puuid=".$this->puuid."&inventoryTypes=CHAMPION_SKIN&inventoryTypes=CHAMPION",
			"loot" => "/loot/v2/player/{$this->puuid}/loot/definitions?lastLootItemUpdate=".(time() * 1000)."&lastRecipeUpdate=".(time() * 1000)."&lastQueryUpdate=".(time() * 1000)
		);

		for($i = 0; $i < count($api_array); $i++){
			$ch[$i] = self::ledgeBase(array_values($api_array)[$i]);
			curl_setopt_array($ch[$i], $this->curl_options);

			curl_multi_add_handle($mh, $ch[$i]);
		}

		do{
			curl_multi_exec($mh, $active);
		} while ($active);

		for($i = 0; $i < count($api_array); $i++){
			curl_multi_remove_handle($mh, $ch[$i]);

			$result = json_decode(curl_multi_getcontent($ch[$i]), 1);
			switch($i){
				case 0:
					$this->history = self::getHistory($result);
					break;
				case 1:
					$this->penalty = self::getPenalty($result);
					break;
				case 2:
					$this->rankedData = self::getRankedData($result);
					break;
				case 3:
					$this->inventory = self::getInventory($result);
					break;
				case 4:
					$this->loot = self::getLoot($result);
					break;

			}
		}

		curl_multi_close($mh);

	}

	private function ledgeBase($endpoint){
		return curl_init($this->apiBaseUrl.$endpoint);
	}

	private function getHistory($result){

		//var_dump($result);
		if($this->nick == "WITHOUT_NICK"){
			$this->history = array(
				"inactiveTime" => "INACTIVE",
				"lastGameDate" => "INACTIVE"
			);

			return $this->history;
		}

		$lastgamesec = intval($result['lastGameDate'] / 1000);
		$lastgamedate = date('d/m/Y', $lastgamesec);
		$inactiveTime = (int)((((time() - $lastgamesec) / 60) / 60) / 24);

		$inactiveTime <= 1 ? $inactiveTime .= " day" : $inactiveTime .= " days";

		$this->history = array(
			"inactiveTime" => $inactiveTime,
			"lastGameDate" => $lastgamedate
		);

		if($GLOBALS['debugMode']){
			echo PHP_EOL.'getHistory(): '.time() - $GLOBALS['startTime'];
		}

		return $this->history;

	}

	private function getPenalty($result){
		//echo $result;

		$this->penalty = array(
			"hasPenalty" => $result['leaverPenalty']['hasActivePenalty'] == 0 ? "false" : "true",
			"gamesRemaining" => $result['punishedGamesRemaining']
		);
		if($GLOBALS['debugMode']){
			echo PHP_EOL.'getPenalty(): '.time() - $GLOBALS['startTime'];
		}

		return $this->penalty;

	}

	private function getRankedData($result){
		$high_elo = array("MASTER", "GRANDMASTER", "CHALLENGER");

		$soloq = $result['queues'][0];
		$flex = $result['queues'][1];

		// SOLOQ
		if(isset($soloq['tier']) && $soloq['tier'] != 'UNRANKED'){
		        $tier_soloq = in_array($soloq['tier'], $high_elo) ? $soloq['tier'].' '.$soloq['leaguePoints'].' LP' : $soloq['tier'].' '.$soloq['rank'];

		        $wr_soloq = (($soloq['wins']) / ($soloq['wins'] + $soloq['losses']) * 100).'%';
		        $wr_soloq = number_format((float)$wr_soloq, 2, '.', '')."%";
		}else{
		        $tier_soloq = 'UNRANKED';
		        $wr_soloq = '0%';
		}
		$last_tier_soloq = isset($soloq['previousSeasonEndTier']) ? $soloq['previousSeasonEndTier'].' '.$soloq['previousSeasonEndRank'] : "UNRANKED";

		//FLEX
		if(isset($flex['tier']) && $flex['tier'] != 'UNRANKED'){
				$tier_flex = in_array($flex['tier'], $high_elo) ? $flex['tier'].' '.$flex['leaguePoints'].' LP' : $flex['tier'].' '.$flex['rank'];

		        $wr_flex = (($flex['wins']) / ($flex['wins'] + $flex['losses']) * 100).'%';
		        $wr_flex = number_format((float)$wr_flex, 2, '.', '')."%";
		}else{
		        $tier_flex = 'UNRANKED';
		        $wr_flex = '0%';
		}
		$last_tier_flex = isset($flex['previousSeasonEndTier']) ? $flex['previousSeasonEndTier'].' '.$flex['previousSeasonEndRank'] : "UNRANKED";

		$this->rankedData = array(
			"soloq" => array(
				"tier" => $tier_soloq,
				"winrate" => $wr_soloq,
				"lastSeason" => $last_tier_soloq
			),
			"flex" => array(
				"tier" => $tier_flex,
				"winrate" => $wr_flex,
				"lastSeason" => $last_tier_flex
			)
		);

		if($GLOBALS['debugMode']){
			echo PHP_EOL.'getRankedData(): '.time() - $GLOBALS['startTime'];
		}

		return $this->rankedData;

	}

	private function getInventory($result){

		$championArray = $result['data']['items']['CHAMPION'];
		$skinArray = $result['data']['items']['CHAMPION_SKIN'];

		$totalChampions = count($championArray) >= 1 ? count($championArray) : 0;
		$totalSkins = count($skinArray) >= 1 ? count($skinArray) : 0;

		$sortedChampionsByDate = \utils\Utils::array_sort($championArray, "purchaseDate");
		$sortedSkinByDate = \utils\Utils::array_sort($skinArray, "purchaseDate");

		$fiveChampions = array_slice($sortedChampionsByDate, 0, 5);
		$fiveSkins = array_slice($sortedSkinByDate, 0, 5);

		//\utils\Utils::updateJsonFile(); // TO UPDATE CHAMPIONS & SKIN DATA

		for($i = 0; $i < count($fiveChampions); $i++){
			$fiveChampions[$i]['name'] = \utils\Utils::champNameByID($fiveChampions[$i]['itemId']);

			$newDate = \DateTime::createFromFormat('Ymd\THis.u\Z', $fiveChampions[$i]['purchaseDate']);
			$fiveChampions[$i]['purchaseDate'] = $newDate->format("d/m/Y");
		}

		for($i = 0; $i < count($fiveSkins); $i++){
			$fiveSkins[$i]['name'] = \utils\Utils::getSkinByID($fiveSkins[$i]['itemId']);

			$newDate = \DateTime::createFromFormat('Ymd\THis.u\Z', $fiveSkins[$i]['purchaseDate']);
			$fiveSkins[$i]['purchaseDate'] = $newDate->format("d/m/Y");

		}

		$this->inventory = array(
			"championsCount" => $totalChampions,
			"skinsCount" => $totalSkins,
			"champions" => $fiveChampions,
			"skins" => $fiveSkins
		);

		if($GLOBALS['debugMode']){
			echo PHP_EOL.'getInventory(): '.time() - $GLOBALS['startTime'];
		}

		return $this->inventory;

	}

	private function getLoot($result){

		$playerLoot = $result['playerLoot'];

		$types = array(
			'CURRENCY_mythic' => 0,
			'MATERIAL_key' => 0,
			'MATERIAL_key_fragment' => 0,
			'CHEST_champion_mastery' => 0,
			'CHEST_generic' => 0,
			'CURRENCY_RP' => 0,
			'CURRENCY_champion' => 0
		);

		for($i = 0; $i < count($playerLoot); $i++){
			$l = $playerLoot[$i];

			if(isset($types[$l['lootName']])){
				$types[$l['lootName']] += $l['count'];
			}
		}

		$gem = $types['CURRENCY_mythic'];
		$key = $types['MATERIAL_key'] + intdiv($types['MATERIAL_key_fragment'], 3);
		$chest = $types['CHEST_champion_mastery'] + $types['CHEST_generic'];

		$rp = $types['CURRENCY_RP'];
		$be = $types['CURRENCY_champion'];

		$this->loot = array(
			"gem" => $gem,
			"key" => $key,
			"chest" => $chest,
			"rp" => $rp,
			"be" => $be
		);

		if($GLOBALS['debugMode']){
			echo PHP_EOL.'getLoot(): '.time() - $GLOBALS['startTime'];
		}

		return $this->loot;

	}

}


?>