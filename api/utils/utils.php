<?php
namespace utils;

class Utils{

	private static $pathChampions = "api/data/champions-sumary.json";
	private static $pathSkins = "api/data/skins.json";
	private static $configPath = "api/data/config.json";

	public static function getConfigJson(){

		if(file_exists(self::$configPath)){
			$config = file_get_contents(self::$configPath);

			return json_decode($config, 1);
		}else{
			return "Cant found config file (".self::$configPath.")";
		}

	}

	public static function updateJsonFile(){

		$curl_options = array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER =>0
		);

		if(!self::writeJsonFile(self::$pathChampions, "https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/en_gb/v1/champion-summary.json", $curl_options)){
			echo 'Fail write in '.self::$pathChampions.PHP_EOL;
		}else{
			echo 'Sucessfully write in '.self::$pathChampions.PHP_EOL;
		}

		if(!self::writeJsonFile(self::$pathSkins, "https://raw.communitydragon.org/latest/plugins/rcp-be-lol-game-data/global/default/v1/skins.json", $curl_options)){
			echo 'Fail write in '.self::$pathSkins.PHP_EOL;
		}else{
			echo 'Sucessfully write in '.self::$pathSkins.PHP_EOL;
		}
	}

	public static function writeJsonFile($path, $apiUrl, $curl_options){
		$ch = curl_init($apiUrl); // INIT CURL TO APIURL
		curl_setopt_array($ch, $curl_options); // SET CURL OPTIONS TO $CH

		$fp = fopen($path, 'w'); // OPEN FILE
		$fResult = fwrite($fp, curl_exec($ch)); // WRITE JSON
		fclose($fp); // CLOSE FILE

		curl_close($ch); // CLOSE CURL

		return $fResult;
	}

	public static function champNameByID($id){

		$json = file_get_contents(self::$pathChampions);

	    $result = json_decode($json, 1);

	    for($i = 0; $i < count($result); $i++){
	    	if($id == $result[$i]['id']){
		        return $result[$i]['alias'];
		    }
	    }
	}

	public static function getSkinByID($id){
	    $json = file_get_contents(self::$pathSkins);

	    $result = json_decode($json, 1);

	    return isset($result[$id]) ? $result[$id]['name'] : "UNDEFINED";
	}

	public static function array_sort($array, $on, $order=SORT_ASC){
	    $new_array = array();
	    $sortable_array = array();

	    if (count($array) > 0) {
	        foreach ($array as $k => $v) {
	            if (is_array($v)) {
	                foreach ($v as $k2 => $v2) {
	                    if ($k2 == $on) {
	                        $sortable_array[$k] = $v2;
	                    }
	                }
	            } else {
	                $sortable_array[$k] = $v;
	            }
	        }

	        switch ($order) {
	            case SORT_ASC:
	                asort($sortable_array);
	            break;
	            case SORT_DESC:
	                arsort($sortable_array);
	            break;
	        }

	        foreach ($sortable_array as $k => $v) {
	            $new_array[$k] = $array[$k];
	        }
	    }

	    return $new_array;
	}


}


?>